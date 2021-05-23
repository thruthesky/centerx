<?php


/**
 * Class PostTaxonomy
 *
 * 글을 관리하는 Taxonomy 객체
 *
 * 글을 하나의 객체로 만들 때, new PostTaxonomy(123) 또는 post(123) 과 같이 할 수 있다. 이 때, 해당 글에 대해서만 데이터를 초기화 한다. 이 말은 post(1) 과
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
 * @property-read FileTaxonomy[] $files;
 * @property-read string $path;
 * @property-read string $url;
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
 * @property-read CommentTaxonomy[] $comments;
 * @property-read string $shortDate - 짧은 날짜 표시
 */
class PostTaxonomy extends Forum {

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


        $act = act()->canRead($this->categoryIdx);
        if ( $act->hasError ) {
            return $this->error( $act->getError() );
        }

        if ( $this->path ) {
            $url = get_current_root_url() . $this->path;
            $this->updateMemory('url', $url);
        }

        $this->patchPoint();


        $this->updateMemory('shortDate', short_date_time($this->createdAt));
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
        if ( !isset($in[CATEGORY_ID]) ) return $this->error(e()->category_id_is_empty);
        $category = category($in[CATEGORY_ID]);
        if ( $category->notFound ) return $this->error(e()->category_not_exists); // The category really exists in database?

        // Save category.idx
        $in[CATEGORY_IDX] = $category->idx;

        // Save author idx.
        $in[USER_IDX] = login()->idx;

        // Check if the user can create a post.
        $act  = act()->canCreatePost($category);

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

        // beginAt 과 endAt 의 값이 문자열이면, strtotime 을 해서 저장한다.
        $in[BEGIN_AT] = dateToTime($in[BEGIN_AT]);
        $in[END_AT] = dateToTime($in[END_AT]);
        // Create a post
        parent::create($in);
        if ( $this->hasError ) return $this;

        // 업로드된 파일의 taxonomy 와 entity 수정
        $this->fixUploadedFiles($in);

        // Record for post creation and change point.
        act()->createPost($this);

        // Apply the point to post memory field. 포인트를 현재 객체의 $this->data 에 업데이트
        $this->patchPoint();

        /// 글/코멘트에 포인트를 적용 한 후, 훅
        $data = $this->getData();
        hook()->run("{$this->taxonomy}-create-point", $data);

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
        sendMessageToTopic(NOTIFY_POST . $category->id, $title, $in[CONTENT] ?? '', $this->url ?? '', $data);

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


        // beginAt 과 endAt 의 값이 문자열이면, strtotime 을 해서 저장한다.
        $in[BEGIN_AT] = dateToTime($in[BEGIN_AT]);
        $in[END_AT] = dateToTime($in[END_AT]);

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
        act()->deletePost($this);

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

        $post['comments'] = $this->comments(response: true);


        // taxonomy 와 entity 를 기반으로 첨부 파일을 가져온다.
        $post[FILES] = $this->files(response: true);


        if ( $post[USER_IDX] ) {
            $post['user'] = user($post[USER_IDX])->shortProfile(firebaseUid: true);
        }

        return $post;
    }


    /**
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
     * @return PostTaxonomy[]
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
        if ( $photo === true ) $where .= " AND files <> '' ";
        else if ( $photo === false ) $where .= " AND files = '' ";

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
        bool $photo = null) {
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
     * @return PostTaxonomy[]
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
     * @return self
     * - error will be set into $this if post not exists.
     * - or post object
     *
     * @example
     *   d(post()->getFromPath());
     */
    public function getFromPath(): self {
        if ( in('postIdx') ) return post(in('postIdx'));
        $path = $_SERVER['REQUEST_URI'];
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
     * @return CommentTaxonomy[]
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
}


/**
 * Returns post object.
 * 글 객체 리턴
 *
 * Note, that it might be a comment or something else as long as it users 'posts' table. Meaning, you can get post object of a comment.
 *
 *
 * @param int|string $idx - 숫자이면 글번호로 인식. 아니면, 코드로 인식하여 글 객체를 리턴한다.
 * @return PostTaxonomy
 */
function post(int|string $idx=0): PostTaxonomy
{
    if ( $idx == 0 ) return new PostTaxonomy(0); // 0 이면, 빈 글 객체 리턴.
    else if ( is_numeric($idx) && $idx > 0 ) return new PostTaxonomy($idx); // 숫자이고 0 보다 크면, 해당 글 객체 리턴.
    else return postByCode($idx); // 숫자가 아니면, 코드로 인식해서, 해당 글 객체 리턴.
}

/**
 * 코드를 입력 받아, 글 객체를 리턴한다.
 *
 * 참고, 동일한 코드가 여러개 있다면, 그 중 하나만 리턴한다. 모든 코드의 글을 다 가져오려면, `search` 함수를 사용한다.
 *
 * @param string $code
 * @return PostTaxonomy
 */
function postByCode(string $code): PostTaxonomy {
    return post()->findOne(['code' => $code]);
}



