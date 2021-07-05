<?php
/**
 * @file post.model.php
 */
/**
 * Class PostModel
 *
 * 글을 관리하는 Model 객체
 *
 * 글을 하나의 객체로 만들 때, new PostModel(123) 또는 post(123) 과 같이 할 수 있다. 이 때, 해당 글에 대해서만 데이터를 초기화 한다. 이 말은 post(1) 과
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
 * @property-read int $otherUserIdx;
 * @property-read string $subcategory;
 * @property-read string $title;
 * @property-read string $content;
 * @property-read string $privateTitle;
 * @property-read string $privateContent;
 * @property-read string $private;
 * @property-read string $isPrivate;
 * @property-read int $noOfComments;
 * @property-read int $noOfViews;
 * @property-read string $reminder;
 * @property-read int $listOrder;
 * @property-read FileModel[] $files;
 * @property-read string $path;
 * @property-read string $url;
 * @property-read string $relativeUrl - url 이 절대 경로인데 반해, 상대경로를 리턴한다.
 * @property-read int $y;
 * @property-read int $n;
 * @property-read int $report;
 * @property-read string $countryCode;
 * @property-read string $province;
 * @property-read string $city;
 * @property-read string $address;
 * @property-read string $zipcode;
 * @property-read int $Ymd
 * @property-read int $createdAt;
 * @property-read int $updatedAt;
 * @property-read int $deletedAt;
 * @property-read int $readAt;
 * @property-read int $beginAt;
 * @property-read int $endAt;
 * @property-read CommentModel[] $comments;
 * @property-read string $shortDate - 짧은 날짜 표시
 */
class PostModel extends Forum {

    public function __construct(int $idx)
    {
        parent::__construct($idx);
    }



    /**
     * getter 에 verified 를 추가.
     * @param $name
     * @return mixed
     */
    public function __get($name): mixed {
        if ( $name == 'isPrivate' ) {
            return $this->private == 'Y';
        } else {
            return parent::__get($name);
        }
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


        $act = userActivity()->canRead($this->categoryIdx);
        if ( $act->hasError ) {
            return $this->error( $act->getError() );
        }

        // post view url
        if ( $this->path ) {
            $this->updateMemoryData('url', get_current_root_url() . $this->path);
            $this->updateMemoryData('relativeUrl', '/' . $this->path);
        }

        // update point for the post create
        $this->patchPoint();



        // short date for the post create time
        $this->updateMemoryData('shortDate', short_date_time($this->createdAt));


        // Return the date of beginAt and endAt in the format of HTML input date.
        $this->updateMemoryData('beginDate', date('Y-m-d', $this->beginAt));
        $this->updateMemoryData('endDate', date('Y-m-d', $this->endAt));
        return $this;
    }



    /**
     * @param array $in
     * @return self
     * @throws \Kreait\Firebase\Exception\FirebaseException
     * @throws \Kreait\Firebase\Exception\MessagingException
     *
     *
     */
    public function create( array $in ): self {
        if ( notLoggedIn() ) return $this->error(e()->not_logged_in);
        if ( login()->block == 'Y' ) return $this->error(e()->blocked);
        if ( !isset($in[CATEGORY_ID]) || empty($in[CATEGORY_ID]) ) return $this->error(e()->category_id_is_empty);
        $category = category($in[CATEGORY_ID]);
        if ( $category->notFound ) return $this->error(e()->category_not_exists); // The category really exists in database?


        // 기본 값 지정.
        $in['listOrder'] ??= 0;

        // Save category.idx
        $in[CATEGORY_IDX] = $category->idx;

        // Save author idx.
        $in[USER_IDX] = login()->idx;

        // Check if the user can create a post.
        $act  = userActivity()->canCreatePost($category);

        debug_log("canCreatePost; act; ", $act);

        if($act->hasError) {
            return $this->error($act->getError());
        }

        // 비밀글이면, title 과 content 에 값이 들어오면, privateTitle 과 privateContent 로 이동한다.
        if ( isset($in['private']) && $in['private'] == 'Y' ) {
            if ( isset($in[TITLE]) && ! empty($in[TITLE]) ) {
                $in[PRIVATE_TITLE] = $in[TITLE];
                unset($in[TITLE]);
            }
            if ( isset($in[CONTENT]) && ! empty($in[CONTENT]) ) {
                $in[PRIVATE_CONTENT] = $in[CONTENT];
                unset($in[CONTENT]);
            }
        }

        // Update path for SEO friendly.
        $in[PATH] = $this->getSeoPath($in['title'] ?? '');
        $in['Ymd'] = date('Ymd');

        $in = $this->updateBeginEndDate($in);


        // Create a post
        parent::create($in);
        if ( $this->hasError ) return $this;

        // 업로드된 파일의 taxonomy 와 entity 수정
        $this->fixUploadedFiles($in);

        // Record for post creation and change point.
        userActivity()->createPost($this);

        // Apply the point to post memory field. 포인트를 현재 객체의 $this->data 에 업데이트
        $this->patchPoint();

        /// 글/코멘트에 포인트를 적용 한 후, 훅
        $data = $this->getData();
        hook()->run("{$this->taxonomy}-create-point", $data);

        // update `noOfPosts`
        // update `noOfComments`

        $req = [
            TITLE => postNotificationTitle($this),
            BODY => $in[CONTENT] ?? '',
            CLICK_ACTION => $this->url ?? '',
            DATA => [
                'idx' => $this->idx,
                'type' => 'post'
            ]
        ];
        sendMessageToTopic(NOTIFY_POST . $category->id, $req);

        return $this;
    }


    /**
     * @attention The entity.idx must be set. That means, it can only be called with `post(123)->update()`.
     *
     * 참고, 프로그램적으로 타인의 글을 업데이트 할 수 있다. 예를 들어, 추천을 할 때, 추천 수를 증가시켜야 한다.
     * 단, 로그인은 해야 한다.
     * 단, Api 호출에서는 못하게 한다. 즉, 미리 Api 호출에서 검사를 해야 한다.
     *
     * @param array $in
     * @return self - `post()->get()` 에 대한 결과를 리턴한다. 즉, url 등의 값이 들어가 있다.
     * - `post()->get()` 에 대한 결과를 리턴한다. 즉, url 등의 값이 들어가 있다.
     *
     * @warning permission check must be done before calling this method. This method will just update the post even if
     *  the login user has no permission.
     */
    public function update(array $in): self {
        if ( $this->hasError ) return $this;

        if ( notLoggedIn() ) return $this->error(e()->not_logged_in);
        if ( login()->block == 'Y' ) return $this->error(e()->blocked);
        if ( ! $this->idx ) return $this->error(e()->idx_is_empty);
        if ( $this->exists() == false ) return $this->error(e()->post_not_exists);
        if ( $this->otherUserIdx ) return $this->error(e()->cannot_be_updated_due_to_other_user_idx);

        $in = $this->updateBeginEndDate($in);

        //
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
     * @warning the permission must be checked before calling this method.
     *
     * @return self
     *
     * @attention It does not check if the user can delete. Since it's the user's right to delete his own post whether
     *      he has points or not. It must be that way.
     */
    public function markDelete(): self {

        if ( $this->hasError ) return $this;

        if ( notLoggedIn() ) return $this->error(e()->not_logged_in);

        // otherUserIdx 가 설정되었으면,
        if ( $this->otherUserIdx  ) {
            // 오직 otherUserIdx 삭제 가능.
            if ( $this->otherUserIdx != login()->idx ) return $this->error(e()->cannot_be_deleted_due_to_wrong_other_user_idx);
        } else {
            // 아니면, 내 글인 경우에만 삭제 가능.
            if ( $this->isMine() == false ) {
                return $this->error(e()->not_your_post);
            }
        }

        if ( ! $this->idx ) return $this->error(e()->idx_is_empty);


        parent::markDelete();
        if ( $this->hasError ) return $this;

        //
        parent::update([TITLE => '', CONTENT => '', PRIVATE_TITLE => '', PRIVATE_CONTENT => '']);

        //
        userActivity()->deletePost($this);

        return $this;
    }

    /**
     * - 코멘트가 없으면 'comments' 에 빈 배열이 지정됨.
     * - 첨부 파일이 없으면 'files' 에 빈 배열이 지정됨.
     * - 사용자 정보가 없으면 'user' 에 빈 배열이 지정됨.
     *
     * @param int $comments - comments 에
     *  - 0 가 입력되면, 코멘트 정보를 리턴하지 않는다.
     *  - 음수, -1 이 입력되면, 모든 코멘트를 리턴한다. 기본 값은 -1 로서, 모든 코멘트를 리턴한다.
     *  - @todo 양수가 입력되면 그 갯수 만큼 맨 마지막 글들 중에서 리턴한다.
     *
     * @attention $comments 가 0 이면, 실제로 해당 글에 코멘트가 있어도, noOfComments 도 0 이 된다.
     *  따라서, noOfComments 의 값을 얻기 위해서는 반드시, $comments 가 0 이 아니어야 한다. $comment 가 1 이어도,
     *  전체 코멘트 수를 가져온다.
     *
     * @return array|string
     * - 에러가 있으면 에러 문자열.
     * - 아니면, 클라이언트에 전달할 글 내용
     */
    public function response(string $fields = null, int $comments = -1): array|string {
        if ( $this->hasError ) return $this->getError();
        $post = $this->getData();
        $post['categoryId'] = $this->categoryId();
        if ( $comments == 0 ) {
            $post['comments'] = [];
            $post['noOfComments'] = count($post['comments']);
        }
        else {
            $post['comments'] = $this->comments(response: true);
            $post['noOfComments'] = count($post['comments']);
            if ( $post['comments'] && $comments > 0 ) {
                $newArr = array_reverse($post['comments']);
                $post['comments'] = array_slice($newArr, 0, $comments);
            }
        }


        // taxonomy 와 entity 를 기반으로 첨부 파일을 가져온다.
        $post[FILES] = $this->files(response: true);


        if ( isset($post[USER_IDX]) ) {
            $post['user'] = user($post[USER_IDX])->shortProfile(firebaseUid: true);
        } else {
            $post['user'] = [];
        }

        return $post;
    }


    /**
     * 글을 검색한다.
     *
     * 입력 값 중에 $in 에 값이 들어오면 그 값을 먼저 사용한다.
     *
     * This searches posts based the HTTP input. And if there is no HTTP input, then it searches with the function
     * parameters.
     *
     * @param string $select
     * @param string $where
     * @param array $params
     * @param array $conds
     * @param string $conj
     * @param string $order
     * @param string $by
     * @param int $page
     * @param int $limit
     * @param bool $object
     * @param array $in
     * @return self[]
     */
    public function search(
        string $select='idx',
        string $where='1',
        array $params = [],
        array $conds=[],
        string $conj = 'AND',
        string $order='idx',
        string $by='DESC',
        int $page=1,
        int $limit=10,
        bool $object = false,
        array $in = []): array {


        // Save search keyword if there is any.
        if ( isset($in['searchKey']) ) saveSearchKeyword($in['searchKey']);

        //
        return parent::search(
            select: $in['select'] ?? $select,
            where: $in['where'] ?? $where,
            params: $in['params'] ?? $params,
            order: $in['order'] ?? $order,
            by: $in['by'] ?? $by,
            page: $in['page'] ?? $page,
            limit: $in['limit'] ?? $limit,
            object: $object
        );
    }

    /**
     * @deprecated User post()->search()
     *
     * 최신 글을 추출 할 때 유용하다. 글만 추출. 코멘트와 첨부 파일은 추출하지 않음.
     *
     * 여러가지 옵션이 있으면, 특히 `by` 파라메타를 'ASC' 로 입력하면 처음 글들을 추출할 수 있다.
     * 참고로, `post()->first()` 함수를 통해서, 마지막 글들이 아닌 최근 글들을 추출 할 수 있다.
     *
     *
     *
     *
     *
     *
     * @param int $categoryIdx
     * @param string|null $categoryId
     * @param string|null $countryCode - 특정 국가의 글만 추출한다.
     * @param string $by
     * @param int $limit
     * @param bool|null $photo
     *  - 이 값이 true 이면 사진이 있는 것만,
     *  - false 이면, 사진이 없는 것만,
     *  - 기본 값이 null 인데, 사진이 있든 없든 모두 추출한다.
     *
     * @return PostModel[]
     *
     *
     * @example
     * ```php
     *  $posts = post()->latest();
     *
     *  // getting latest posts that has photo.
     *  post()->latest(categoryId: 'qna', countryCode: cafe()->countryCode, limit: 3, photo: true);
     * ```
     */
    public function latest(
        int $categoryIdx = 0,
        string $categoryId=null,
        string $countryCode = null,
        string $by = 'DESC',
        int $limit=10,
        bool $photo = null,
        string $private = '',
    ): array {

        $where = "parentIdx=0 AND deletedAt=0 AND private='$private'";
        if ( $categoryIdx == 0 ) {
            if ( $categoryId ) {
                $categoryIdx = category($categoryId)->idx;
            }
        }
        $params = [];
        if ( $categoryIdx ) {
            $where .= " AND categoryIdx=?";
            $params[] = $categoryIdx;
        }

        // 국가 코드 훅. @see README `HOOK_POST_LIST_COUNTRY_CODE` 참고
        if ( $countryCode = hook()->run(HOOK_POST_LIST_COUNTRY_CODE, $countryCode) ) {
            $where .= " AND countryCode=?";
            $params[] = $countryCode;
        }
        if ( $photo === true ) $where .= " AND fileIdxes <> '' ";
        else if ( $photo === false ) $where .= " AND fileIdxes = '' ";

        return $this->search(
            where: $where,
            params: $params,
            by: $by,
            limit: $limit,
            object: true
        );

    }

    /**
     * It returns the very first posts while latest() returns the very last posts.
     * @param int $categoryIdx
     * @param string|null $categoryId
     * @param int $limit
     * @param bool|null $photo
     * @return array
     */
    public function first(
        int $categoryIdx = 0,
        string $categoryId=null,
        string $countryCode = null,
        int $limit=10,
        bool $photo = null): array {
        return $this->latest(
            categoryIdx: $categoryIdx,
            categoryId: $categoryId,
            countryCode: $countryCode,
            limit: $limit,
            photo: $photo
        );
    }



    /**
     * @deprecated Don't use this.
     *
     * Helper class of search()
     *
     * @param string $categoryId
     * @param int $page
     * @param int $limit
     * @return PostModel[]
     */
    public function list(string $categoryId, int $page=1, int $limit=10): array
    {
        $categoryIdx = category($categoryId)->idx;
        return $this->search( where: "categoryIdx=? AND parentIdx=0 AND deletedAt=0", params: [$categoryIdx], page: $page, limit: $limit);
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
//        $q = "SELECT idx, rootIdx, parentIdx FROM " . $this->getTable() . " WHERE parentIdx=$parentIdx";
//        $rows = db()->get_results($q, ARRAY_A);

        $sql = "SELECT idx, rootIdx, parentIdx FROM " . $this->getTable() . " WHERE parentIdx=?";
        $rows = db()->rows($sql, $parentIdx);
        foreach($rows as $row) {
            $row[DEPTH] = $depth;
            $__rets[] = $row;
            $this->getComments($row[IDX], $depth + 1);
        }
        return $__rets;
    }


    /**
     * Return the post of current page base on the URL(Friendly URL)
     *
     * It returns the post based on current url.
     *
     * For instance, "https://local.domain.com/post-url-is-like-%ED%95%9C%EA%B8%80%EB%8F%84-%EB%90%okay",
     *  then, it will decode the url and find it in path, and return the post.
     *
     * Note, that it will ignore `?` and the string after it if it exists.
     * i.e) If the URL is `https://local.itsuda50.com/banana-6?lcategory=banana` then, `?lcategory=banana` is ignored.
     *
     * 참고, 현재 페이지가 글 읽기 페이지가 아니면, DB 액세스 없이 바로 error 를 리턴한다.
     *
     * @return self
     * - error_post_path_is_empty will be set into $this if post not exists.
     * - or post object
     *
     * @example
     *   d(post()->getFromPath());
     */
    public function getFromPath(string $path = null): self {
        if ( in('postIdx') ) return post(in('postIdx'));
        if ( $path === null ) $path = $_SERVER['REQUEST_URI'];
        if ( str_contains($path, '?') ) {
            $arr = explode('?', $path);
            $path = $arr[0];
        }
        $path = ltrim($path,'/');
        if ( empty($path) ) return $this->error(e()->post_path_is_empty);
        $path = urldecode($path);
        return $this->findOne([PATH => $path]);
    }

    /**
     * @return self
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
    private function getSeoPath(string $title=''): string {
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
     * @param bool $response - false 이면 객체로 리턴. true 이면 배열로 리턴.
     * @return CommentModel[]
     */
    public function comments(bool $response = false): array {


        // reset global comments container.
        global $__rets;
        $__rets = [];

        // get all comments.
        $comments = $this->getComments($this->idx);

        $rets = [];
        if ( $comments ) {
            foreach($comments as $comment) {
                if ( $response ) {
                    $cmt = comment($comment[IDX])->response();
                    $cmt[DEPTH] = $comment[DEPTH];
                } else {
                    $cmt = comment($comment[IDX]);
                    $cmt->depth = $comment[DEPTH];
                }
                $rets[] = $cmt;
            }
        }

        return $rets;
    }


    /**
     *
     * 읽은 시간을 업데이트한다.
     *
     * 주의, parent::update() 를 호출하여 퍼미션을 검사하지 않고, 업데이트한다. 참고로 이 후, read() 가 호출되어 메모리 캐시 변수가 업데이트 된다.
     */
    public function readAt() {
        parent::update([READ_AT => time()]);
    }

    public function increaseNoOfViews() {
        parent::update([NO_OF_VIEWS => $this->noOfViews + 1]);
    }

    /**
     * return the number of login user's posts.
     * @return int
     */
    public function countMine(): int {
        return $this->count(conds: [USER_IDX => login()->idx, PARENT_IDX => 0, DELETED_AT => 0]);
    }
}


/**
 * Returns post object.
 * 글 객체 리턴
 *
 * Note, that it might be a comment or something else as long as it users 'posts' table. Meaning, you can get post object of a comment.
 *
 *
 * @param int|string $idx - 숫자이면 글번호로 인식. 아니면, 경로로 인식해서 글 객체를 리턴한다.
 * @return PostModel
 */
function post(int|string $idx=0): PostModel
{
    if ( $idx == 0 ) return new PostModel(0); // 0 이면, 빈 글 객체 리턴.
    else if ( is_numeric($idx) && $idx > 0 ) return new PostModel($idx); // 숫자이고 0 보다 크면, 해당 글 객체 리턴.
    else return post()->getFromPath($idx);
//    else return postByCode($idx); // 숫자가 아니면, 코드로 인식해서, 해당 글 객체 리턴.
}

/**
 * 코드를 입력 받아, 글 객체를 리턴한다.
 *
 * 참고, 동일한 코드가 여러개 있다면, 그 중 하나만 리턴한다. 모든 코드의 글을 다 가져오려면, `search` 함수를 사용한다.
 *
 * @param string $code
 * @return PostModel
 */
function postByCode(string $code): PostModel {
    return post()->findOne(['code' => $code]);
}



function postNotificationTitle(PostModel $post): string {
    // NEW POST IS CREATED => Send notification to forum subscriber
    if (!empty($post->title)) return $post->title;

    if (!empty($post->fileIdxes)) {
        return  "New photo was uploaded";
    }
    return "New post was posted on" . $post->categoryId();
}



