<?php


class Post extends Entity {
    public function __construct(int $idx)
    {
        parent::__construct(POSTS, $idx);
    }

    /**
     * @param array $in
     * @return array|string
     */
    public function create( array $in ): array|string {
        if ( notLoggedIn() ) return e()->not_logged_in;
        if ( !isset($in[CATEGORY_ID]) ) return e()->category_id_is_empty;
        $category = category($in[CATEGORY_ID]);
        if ( $category->exists() == false ) return e()->category_not_exists;
        unset($in[CATEGORY_ID]);

        //
        $in[CATEGORY_IDX] = $category->idx;

        //
        $in[USER_IDX] = my(IDX);


        // @todo check if user has permission
        // @todo check if too many post creation.
        // @todo check if too many comment creation.

        // Temporary path.
        $in[PATH] = 'path-' . md5(my(IDX)) . md5(time());
        $post = parent::create($in);
        if ( isError($post) ) return $post;

        // Set idx
        $this->setIdx($post[IDX]);

        // Update path
        $path = $this->getPath($post);
        $this->update([PATH => $path]);
        $post = $this->get();



        // update `noOfPosts`
        // update `noOfComments`

        // @todo push notification

        return $post;
    }

    /**
     * @attention The entity.idx must be set. That means, it can only be called with `post(123)->update()`.
     *
     * @param array $in
     * @return array|string
     */
    public function update(array $in): array|string {
        if ( notLoggedIn() ) return e()->not_logged_in;
        if ( ! $this->idx ) return e()->idx_is_empty;
        if ( $this->exists() == false ) return e()->post_not_exists;
        if ( $this->isMine() == false ) return e()->not_your_post;


        //
        return parent::update($in);
    }

    /**
     * @return array|string
     */
    public function markDelete(): array|string {
        if ( notLoggedIn() ) return e()->not_logged_in;
        if ( ! $this->idx ) return e()->idx_is_empty;
        if ( $this->exists() == false ) return e()->post_not_exists;
        if ( $this->isMine() == false ) return e()->not_your_post;


        $record = parent::markDelete();
        if ( isError($record) ) return $record;
        $this->update([TITLE => '', CONTENT => '']);
        return $this->get();
    }

    /**
     * Returns posts after search and add meta datas.
     *
     * @attention Categories can be passed like  "categoryId=<apple> or categoryId='<banana>'" and it wil be converted
     * as "categoryIdx=1 or categoryIdx='2'"
     *
     * @param string $where
     * @param int $page
     * @param int $limit
     * @param string $order
     * @param string $by
     * @param string $select
     * @param string $categoryId
     * @return mixed
     * @throws Exception
     */
    public function search(
        string $where='1', int $page=1, int $limit=10, string $order='idx', string $by='DESC', $select='idx'
    ): mixed {

        // Parse category
        $count = preg_match_all("/<([^>]+)>/", $where, $ms);
        if ( $count ) {
            for( $i = 0; $i < $count; $i ++ ) {
                $cat = $ms[1][$i];
                $idx = category($cat)->idx;
                $where = str_replace($ms[0][$i], $idx, $where);
            }
        }
        $where = str_replace('categoryId', CATEGORY_IDX, $where);

        $posts = parent::search(
            where: $where,
            page: $page,
            limit: $limit,
            order: $order,
            by: $by,
            select: 'idx',
        );

        $rets = [];
        foreach( $posts as $post ) {
            $idx = $post[IDX];
            $rets[] = post($idx)->get();
        }

        return $rets;
    }

    // Helper class of search()
    public function list(string $categoryId, int $page=1, int $limit=10) {
        return $this->search(where: "categoryId=<$categoryId> AND deletedAt=0", page: $page, limit: $limit, select: '*');
    }


    /**
     *
     * @param string|null $field
     * @param mixed|null $value
     * @param string $select
     * @return mixed
     * - Empty array([]) if post not exists.
     *
     *
    // @todo comment.
    // @todo add user(author) information
    // @todo add attached files if exists.
     */
    public function get(string $field=null, mixed $value=null, string $select='*'): mixed
    {
        global $__rets;
        $post = parent::get($field, $value, $select);
        if ( ! $post ) return [];
        $post[COMMENTS] = [];
        if ( isset($post[IDX]) ) {
            $__rets = [];
            $comments = $this->getComments($post[IDX]);
            if ( $comments ) {
                foreach($comments as $comment) {
                    $got = comment($comment[IDX])->get();
                    $got[DEPTH] = $comment[DEPTH];
                    $post[COMMENTS][] = $got;
                }
            }
        }
        /**
         * Get files only if $select includes 'files' field.
         */
        if ( isset($post[FILES]) ) {
            $post[FILES] = files()->get($post[FILES], select: 'idx,userIdx,path,name,size');
        }
        return $post;
    }

    /**
     * Returns posts.idx, rootIdx, parentIdx, and its depth recursively.
     *
     * @attention $__rets must be reset for getting children of each post.
     *
     * @param int $parentIdx - The parent. It can be a post or a comment. If it's comment, it returns the children of the comments.
     * @param int $depth
     */
    private array $__rets = [];
    public function getComments(int $parentIdx, int $depth=1) {
        global $__rets;
        $q = "SELECT idx, rootIdx, parentIdx FROM " . $this->getTable() . " WHERE parentIdx=$parentIdx";
        $rows = db()->get_results($q, ARRAY_A);
        foreach($rows as $row) {
            $row[DEPTH] = $depth;
            $__rets[] = $row;
            $this->getComments($row[IDX], $depth + 1);
        }
        return $__rets;
    }


    /**
     * Return a post based on current url.
     *
     * For instance, "https://local.domain.com/post-url-is-like-%ED%95%9C%EA%B8%80%EB%8F%84-%EB%90%okay",
     *  then, it will decode the url and find it in path, and return the post.
     *
     * @return array
     * - empty array([]) if post not exists.
     * - or post record.
     *
     * @example
     *   d(post()->getFromPath());
     */
    public function getFromPath(): array {
        $path = $_SERVER['REQUEST_URI'];
        $path = ltrim($path,'/');
        if ( empty($path) ) return [];
        $path = urldecode($path);
        $post = $this->get(PATH, $path);
        return $post;
    }


    /**
     * Returns unique seo friendly url for the post.
     *
     * It returns empty string for comment.
     *
     * @param $post
     * @return string
     */
    private function getPath($post): string {
        if ( $post[PARENT_IDX] ) return '';
        $title = empty($post[TITLE]) ? $post[IDX] : $post[TITLE];
        $title = seoFriendlyString($title);
        $path = $title;
        $count = 0;
        while ( true ) {
            $p = parent::get(PATH, $path, 'idx'); // Don't use post()->get() for the performance.
            if ( $p ) {
                $count ++;
                $path = "$title-$count";
            } else {
                return $path;
            }
        }
    }


}





/**
 * User 는 uid 를 입력 받으므로 항상 새로 생성해서 리턴한다.
 *
 * $_COOKIE[SESSION_ID] 에 값이 있으면, 사용자가 로그인을 확인을 해서, 로그인이 맞으면 해당 사용자의 idx 를 기본 사용한다.
 * @param int $idx
 * @return Post
 */
function post(int $idx=0): Post
{
    return new Post($idx);
}



