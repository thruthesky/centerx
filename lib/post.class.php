<?php


/**
 * Class Post
 *
 * 글을 관리하는 Taxonomy 객체
 *
 * 글을 하나의 객체로 만들 때, new Post(123) 또는 post(123) 과 같이 할 수 있다. 이 때, 해당 글에 대해서만 데이터를 초기화 한다. 이 말은 post(1) 과
 * 같이 할 때, 글이 저장된 레코드와 메타에는 url 정보가 존재하지 않는데, 처음 객체를 생성하거나 객체에 대한 변경 작업을 할 때, url 값을 초기화 한다.
 * 하지만, 현재 글이 아닌 것, 예를 들면 글 쓴이 정보, 첨부 파일 정보, 코멘트 정보, 카테고리 정보 등등은 초기화를 하지 않는다.
 * 따라서, 그러한 정보를 얻기 위해서는 $post->user(), $post->files(), $post->comments(), $post->category() 와 같은 함수를 호출해서 해당
 * 정보를 사용 할 수 있다.
 *
 * 참고로, 현재 글의 카테고리 아이디를 얻기 위해서는 $this->category()->id 와 같이 할 수도 있고, postCategoryId($this->categoryIdx) 와 같이
 * 할 수 있다. 전자는 레코드와 메타 데이터 전체를 다 읽고 필요한 초기화까지 한다. 후자는 필드 하나만 읽는다. 어느 함수를 쓸지는 적절히 결정해야 한다.
 *
 * @property-read int $rootIdx;
 * @property-read int $parentIdx;
 * @property-read int $categoryIdx;
 * @property-read int $userIdx;
 * @property-read string $title;
 * @property-read File[] $files;
 * @property-read string $path;
 * @property-read string $content;
 * @property-read string $url;
 * @property-read int $y;
 * @property-read int $n;
 * @property-read string $countryCode;
 * @property-read string $province;
 * @property-read string $city;
 * @property-read string $address;
 * @property-read string $zipcode;
 * @property-read int $Ymd
 * @property-read int $createdAt;
 * @property-read int $updatedAt;
 * @property-read int $deletedAt;
 */
class Post extends PostTaxonomy {

    public function __construct(int $idx)
    {
        parent::__construct($idx);
    }


    /**
     * 게시글을 읽어서 적절한 패치를 한 후, data 에 보관한다.
     *
     * 예를 들면, URL 을 패치해서, $this->data 에 보관한다.
     * 참고, 현재 객체에 read() 메소드를 정의하면, 부모 클래스의 read() 메소드를 overridden 한다. 그래서 부모 함수를 호출해야한다.
     * read() 메소드를 정의하지 않고, 그냥 constructor 에서 정의 할 수 있는데, 그렇게하면 각종 상황에서 read() 가 호출되는데, 그 때 적절한 패치를 못할 수 있다.
     * 예를 들어, create() 함수 호출 후, url 패치가 안되는 것이다.
     *
     * @param int $idx
     * @return self
     */
    public function read(int $idx = 0): self
    {
        parent::read($idx);
        if ( $this->notFound ) return $this;

        if ( $this->path ) {
            $url = get_current_root_url() . $this->path;
            $this->updateData('url', $url);
        }

        return $this;
    }

    /**
     * @param array $in
     * @return Post
     */
    public function create( array $in ): self {
        if ( notLoggedIn() ) return $this->error(e()->not_logged_in);
        if ( !isset($in[CATEGORY_ID]) ) return $this->error(e()->category_id_is_empty);
        $category = category($in[CATEGORY_ID]);
        if ( $category->notFound ) return $this->error(e()->category_not_exists);

        // Category ID 는 저장하지 않는다.
        unset($in[CATEGORY_ID]);

        // 대신, Category idx 를 저장한다.
        $in[CATEGORY_IDX] = $category->idx;

        // 회원 번호
        $in[USER_IDX] = login()->idx;

        // 제한에 걸렸으면, 에러 리턴.
        if ( $category->BAN_ON_LIMIT == 'Y' ) {
            $re = point()->checkCategoryLimit($category->idx);
            if ( isError($re) ) return $this->error($re);
        }

        // 글/코멘트 쓰기에서 포인트 감소하도록 설정한 경우, 포인트가 모자라면, 에러
        $pointToCreate = point()->getPostCreate($category->idx);
        if ( $pointToCreate < 0 ) {
            if ( login()->getPoint() < abs( $pointToCreate ) ) return $this->error(e()->lack_of_point);
        }


        // @todo check if user has permission
        // @todo check if too many post creation.
        // @todo check if too many comment creation.

        // Update path for SEO friendly.
        $in[PATH] = $this->getPath($in['title'] ?? '');
        $in['Ymd'] = date('Ymd');
        parent::create($in);
        if ( $this->hasError ) return $this;


        $this->fixUploadedFiles($in);



        point()->forum(POINT_POST_CREATE, $this->idx);



        // update `noOfPosts`
        // update `noOfComments`


        // NEW POST IS CREATED => Send notification to forum subscriber
        $title = $in[TITLE] ?? '';
        if (empty($title)) {
            if (isset($in[FILES]) && !empty($in[FILES])) {
                $title = "New photo was uploaded";
            }
        }
        $data = [
            'senderIdx' => login()->idx,
            'idx' => $this->idx,
            'type' => 'post'
        ];
        sendMessageToTopic(NOTIFY_POST . $category->id, $title, $in[CONTENT] ?? '', $this->url, $data);

        return $this;
    }

    /**
     * @attention The entity.idx must be set. That means, it can only be called with `post(123)->update()`.
     *
     * 참고, 프로그램적으로 타인의 글을 업데이트 할 수 있다. 예를 들어, 추천을 할 때, 추천 수를 증가시켜야 한다.
     * 단, Api 호출에서는 못하게 한다. 즉, 미리 Api 호출에서 검사를 해야 한다.
     *
     * @param array $in
     * @return Post - `post()->get()` 에 대한 결과를 리턴한다. 즉, url 등의 값이 들어가 있다.
     * - `post()->get()` 에 대한 결과를 리턴한다. 즉, url 등의 값이 들어가 있다.
     */
    public function update(array $in): self {
        if ( notLoggedIn() ) return $this->error(e()->not_logged_in);
        if ( ! $this->idx ) return $this->error(e()->idx_is_empty);
        if ( $this->exists() == false ) return $this->error(e()->post_not_exists);

        parent::update($in);
        $this->fixUploadedFiles($in);
        return $this;
    }


    /**
     * @return $this
     */
    public function delete(): self
    {
        return $this->error(e()->post_delete_not_supported);
    }

    /**
     *
     * 참고, 글 삭제에 필요한 각종 검사를 이 함수에서 한다. 특히, 퍼미션이 있는지도 검사를 한다.
     * 참고, 글과 내용을 없애고, 나머지 정보는 유지한다.
     *
     * @return self
     */
    public function markDelete(): self {
        if ( notLoggedIn() ) return $this->error(e()->not_logged_in);
        if ( ! $this->idx ) return $this->error(e()->idx_is_empty);
        if ( $this->isMine() == false ) return $this->error(e()->not_your_post);

        parent::markDelete();
        parent::update([TITLE => '', CONTENT => '']);

        point()->forum(POINT_POST_DELETE, $this->idx);

        return $this;
    }

    /**
     * - 코멘트가 없으면 'comments' 에 빈 배열이 지정됨.
     * - 첨부 파일이 없으면 'files' 에 빈 배열이 지정됨.
     *
     * @return array|string
     * - 에러가 있으면 에러 문자열.
     * - 아니면, 클라이언트에 전달할 글 내용
     */
    public function response(): array|string {
        if ( $this->hasError ) return $this->getError();
        $post = $this->getData();

        $post['comments'] = $this->comments(false);

        /**
         *
         * taxonomy 와 entity 를 기반으로 첨부 파일을 가져온다.
         */
        if ( isset($post[FILES]) ) {
            $post[FILES] = [];
            $files = files()->find([TAXONOMY => POSTS, ENTITY => $this->idx]);
            foreach( $files as $file ) {
                $post[FILES][] = $file->response();
            }
        }
        $post[FILES] = $this->files(false);

        if ( $post[USER_IDX] ) {
            $post['user'] = user($post[USER_IDX])->postProfile();
        }

        $post['shortDate'] = short_date_time($post['createdAt']);
        return $post;
    }

    /**
     * Returns posts after search and add meta datas.
     *
     * @attention Categories can be passed like  "categoryId=<apple> or categoryId='<banana>'" and it wil be converted
     * as "categoryIdx=1 or categoryIdx='2'"
     *
     *
     * Post 객체를 배열로 리턴한다. 그래서 아래와 같이 코딩을 할 수 있다.
     *
     * ```
     * $posts = post()->search(where: "userIdx != " . login()->idx);
     * foreach( $posts as $post ) {
     *   $post->vote('N');
     * }
     * ```
     *
     * @param string $where
     * @param int $page
     * @param int $limit
     * @param string $order
     * @param string $by
     * @param string $select
     * @param array $conds
     * @param string $conj
     * @return Post[]
     *
     *
     */
    public function search(
        string $select='idx',
        string $where='1',
        string $order='idx',
        string $by='DESC',
        int $page=1,
        int $limit=10,
        array $conds=[],
        string $conj = 'AND',
    ): array
    {

        // Parse category
        $where = $this->parseCategory($where);


        $posts = parent::search(
            select: $select,
            where: $where,
            order: $order,
            by: $by,
            page: $page,
            limit: $limit,
        );


        $rets = [];
        foreach( ids($posts) as $idx ) {
            $rets[] = post($idx);
        }
        return $rets;
    }



    /**
     * @param string $where
     * @param array $conds
     * @param string $conj
     * @return int
     */
    public function count(string $where='1', array $conds=[], string $conj = 'AND'): int {
        $where = $this->parseCategory($where);
        return parent::count($where, $conds, $conj);
    }

    /**
     * @param string $where
     * @return string
     */
    private function parseCategory(string $where): string {

        $count = preg_match_all("/<([^>]+)>/", $where, $ms);
        if ( $count ) {
            for( $i = 0; $i < $count; $i ++ ) {
                $cat = $ms[1][$i];
                $idx = category($cat)->idx;
                $where = str_replace($ms[0][$i], $idx, $where);
            }
        }
        $where = str_replace('categoryId', CATEGORY_IDX, $where);
        return $where;
    }


    /**
     * 최신 글을 추출 할 때 유용하다. 글만 추출. 코멘트는 추출하지 않음.
     * @param string|null $categoryId
     * @param int $page
     * @param int $limit
     * @return Post[]
     * @throws Exception
     *
     * @example
     *  $posts = post()->latest();
     */
    public function latest(string $categoryId=null, int $page=1, int $limit=10): array {
        return $this->search(
            where: $categoryId ? "parentIdx=0 AND categoryId=<$categoryId>" : "parentIdx=0",
            page: $page,
            limit: $limit,
        );
    }


    /**
     * Helper class of search()
     *
     * @param string $categoryId
     * @param int $page
     * @param int $limit
     * @return Post[]
     */
    public function list(string $categoryId, int $page=1, int $limit=10): array
    {
        return $this->search( where: "categoryId=<$categoryId> AND parentIdx=0 AND deletedAt=0", page: $page, limit: $limit);
    }

    /**
     * Returns only idx, rootIdx, parentIdx, and its depth of all the child posts(comments) in recursive tree.
     * 하위 코멘트를 tree 구조로 리턴한다. 최종 리턴되는 배열에는 idx, rootIdx, parentIdx, depth 의 값이 들어가 있다.
     *
     * @attention $__rets must be reset for getting children of each post since it is added it there.
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
     * Return the post of current page.
     *
     * It returns the post based on current url.
     *
     * For instance, "https://local.domain.com/post-url-is-like-%ED%95%9C%EA%B8%80%EB%8F%84-%EB%90%okay",
     *  then, it will decode the url and find it in path, and return the post.
     *
     * @return Post
     * - error will be set into $this if post not exists.
     * - or post object
     *
     * @example
     *   d(post()->getFromPath());
     */
    public function getFromPath(): self {
        $path = $_SERVER['REQUEST_URI'];
        $path = ltrim($path,'/');
        if ( empty($path) ) return $this->error(e()->post_path_is_empty);
        $path = urldecode($path);
        return $this->findOne([PATH => $path]);
    }

    /**
     * @return Post
     */
    public function current(): self {
        return $this->getFromPath();
    }

    /**
     * Returns unique seo friendly url for the post.
     *
     * It returns empty string for comment.
     *
     * @logic
     *   - 먼저, 동일한 path 가 있는지 검사하고 있다면, count 를 1 증가하고, rand(count, count * 10) 의 값을 구해 count 에 저장한다.
     *   - path 가 없는 값이 나올 때 까지 계속해서 계속해서 반복한다.
     *   - 즉, 첫번째 루프에서는 rand(1, 10) 사이의 값을 구한다. 만약 5가 나왔다면, -5 경로가 있는지 검사.
     *     두번째 루프에서는 rand(5, 50) 사이의 값을 구한다. 만약, 33 이 나왔다면, -33 경로가 있는지 검사.
     *     세번재 루프에서는 rand(33, 330) 사이의 값을 구한다. 222 이 나왔다면, -222 경로가 있는지 검사.
     *     네번째 루프에서는 rand(222, 2220) 사이 중 하나의 count 값을 구한다.
     *   - 이런식으로 동일한 제목이 수 천개 쓰여져도, 빠르게 찾는다.
     *
     *
     * @param string $title - 제목.
     *  제목이 입력되지 않으면, 현재 글의 제목을 사용한다. 제목이 없으면, 글 번호를 제목으로 사용한다.
     *  제목이 입력되지 않은 경우, 코멘트의 경우는 그냥 빈 문자열이 리턴된다.
     *
     *  제목이 입력되면, 해당 제목을 바탕으로 path 값을 구한다.
     *
     * @return string
     */
    private function getPath(string $title=''): string {
        if ( empty($title) ) {
            if ( $this->parentIdx ) return '';
            $title = empty($this->title) ? $this->idx : $this->title;
        }

        $title = seoFriendlyString($title);
        $path = $title;
        $count = 0;
        while ( true ) {
            if ( post()->exists([PATH => $path]) ) {
                $count ++;
                $count = rand($count, $count * 10);
                $path = "$title-$count";
            } else {
                return $path;
            }
        }
    }


    /**
     * 현재 글에 연결된 코멘트 객체를 배열로 리턴한다.
     *
     * 참고: getComments() 는 하위 코멘트의 구조만 담고 있다.
     *
     * @param bool $object - true 이면 객체로 리턴. false 이면 배열로 리턴.
     * @return Comment[]
     */
    public function comments(bool $object = true): array {


        // reset global comments container.
        global $__rets;
        $__rets = [];

        // get all comments.
        $comments = $this->getComments($this->idx);

        $rets = [];
        if ( $comments ) {
            foreach($comments as $comment) {
                if ( $object ) {
                    $cmt = comment($comment[IDX]);
                    $cmt->depth = $comment[DEPTH];
                } else {
                    $cmt = comment($comment[IDX])->response();
                    $cmt[DEPTH] = $comment[DEPTH];
                }
                $rets[] = $cmt;
            }
        }

        return $rets;
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

