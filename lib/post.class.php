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


        // 제한에 걸렸으면, 에러 리턴.
        if ( $category->value(BAN_ON_LIMIT) ) {
            $re = point()->checkCategoryLimit($category->idx);
            if ( isError($re) ) return $re;
        }

        // 글/코멘트 쓰기에서 포인트 감소하도록 설정한 경우, 포인트가 모자라면, 에러
        $pointToCreate = point()->getPostCreate($category->idx);
        if ( $pointToCreate < 0 ) {
            if ( my(POINT) < abs( $pointToCreate ) ) return e()->lack_of_point;
        }



        // @todo check if user has permission
        // @todo check if too many post creation.
        // @todo check if too many comment creation.

        // Temporary path since path must be unique.
        $in[PATH] = 'path-' . md5(my(IDX)) . md5(time());
        $post = parent::create($in);
        if ( isError($post) ) return $post;

        // Set idx
        $this->setIdx($post[IDX]);

        // Update path
        $path = $this->getPath($post);
        $this->update([PATH => $path]);
        $post = $this->get();


        point()->forum(POINT_POST_CREATE, $post[IDX]);



        // update `noOfPosts`
        // update `noOfComments`


        // NEW POST IS CREATED => Send notification to forum subscriber
        $data = [
            'senderIdx' => my(IDX),
            'idx' => $post[IDX],
            'type' => 'post'
        ];
        sendMessageToTopic(NOTIFY_POST . $category[ID], $in[TITLE], $in[CONTENT] ?? '', $post[PATH], $data);

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


    public function delete()
    {
        return e()->post_delete_not_supported;
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


        point()->forum(POINT_POST_DELETE, $this->idx);

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
                    if ($got[DELETED_AT] != '0') continue;
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

    /**
     *
     * 동일한 투표를 두 번하면, 취소가 된다. 찬성 투표를 했다가 찬성을 하면 취소.
     * 찬성을 했다가 반대를 하면, 반대 투표로 변경된다.
     *
     * 'choice' 필드가 Y 이면 찬성/좋아요, N 이면 반대/싫어요, 빈 문자열('')이면 취소이다.
     * @param $in
     *
     * @return array|mixed|string
     *
     * - 성공이면, 글 또는 코멘트를 리턴한다.
     *
     * @example
     *  $re = api_vote(['post_ID' => 1, 'choice' => 'Y']);
     */
    function vote($Yn): array|string {
        if ( $this->exists() == false ) return e()->post_not_exists;
        if ( !$Yn ) return e()->empty_vote_choice;// ERROR_EMPTY_CHOICE;
        if ( $Yn != 'Y'  && $Yn != 'N' ) return e()->empty_wrong_choice;// ERROR_WRONG_INPUT;

        $vote = voteHistory()->by(my(IDX), POSTS, $this->idx);

        if ( $vote->exists() ) {
            // 이미 한번 추천 했음. 포인트 변화 없이, 추천만 바꾸어 준다.
            if ( $vote->value(CHOICE) == $Yn ) $vote->update([CHOICE=>'']);
            else $vote->update([CHOICE=>$Yn]);
        } else {
            // 처음 추천
            // 처음 추천하는 경우에만 포인트 지정.
            // 추천 기록 남김. 포인트 증/감 유무와 상관 없음.
            voteHistory()->create([
                USER_IDX => my(IDX),
                TAXONOMY => POSTS,
                ENTITY => $this->idx,
                CHOICE => $Yn
            ]);
//            d("$Yn");
            point()->vote($this, $Yn);
        }


        // 해당 글 또는 코멘트의 총 vote 수를 업데이트 한다.
        $Y = voteHistory()->count(TAXONOMY . "='" . POSTS. "' AND " . ENTITY . "=" . $this->idx . " AND " . CHOICE . "='Y'");
        $N = voteHistory()->count(TAXONOMY . "='" . POSTS. "' AND " . ENTITY . "=" . $this->idx . " AND " . CHOICE . "='N'");

        $data = ['Y' => $Y, 'N' => $N];

        $record = entity(POSTS, $this->idx)->update($data);


        return $record;
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



