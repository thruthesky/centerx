<?php
/**
 * @file comment.class.php
 */
/**
 * Class CommentTaxonomy
 *
 * 코멘트는 PostTaxonomy 와 동일한 테이블을 사용한다. 따라서 PostTaxonomy 클래스와 비슷한 부분이 많다.
 *
 * @property-read int $rootIdx
 * @property-read int $parentIdx
 * @property-read int $categoryIdx
 * @property-read string $title
 * @property-read string $content
 * @property-read string $files
 * @property-read string $Y
 * @property-read string $N
 * @property-read int $createdAt
 * @property-read int $deletedAt
 */
class CommentTaxonomy extends Forum {

    /**
     * depth 는 재귀적 함수 호출에 의해서 결정되므로, DB 에 없는 필드이다. 따라서 재귀적 함수 호출 후에 설정을 해 주어야 한다.
     * @var int
     */
    public int $depth = 0;

    public function __construct(int $idx)
    {
        parent::__construct($idx);
    }


    /**
     * Load comments
     *
     * @param int $idx
     * @return self
     */
    public function read(int $idx = 0): self
    {
        parent::read($idx);

        $this->patchPoint();
        return $this;
    }


    /**
     * @param array $in
     *
     * @return self
     * @throws Exception
     */
    public function create(array $in): self
    {
        if ( notLoggedIn() ) return $this->error(e()->not_logged_in);
        if ( login()->block == 'Y' ) return $this->error(e()->blocked);
        if ( !isset($in[ROOT_IDX]) ) return $this->error(e()->root_idx_is_empty);

        if ( !isset($in[PARENT_IDX]) ) $in[PARENT_IDX] = $in[ROOT_IDX]; // if parent idx is not set, set it same as root idx

        $in[USER_IDX] = login()->idx;

        $post = post($in[ROOT_IDX]);
        $categoryIdx = $post->categoryIdx;

        $category = category($categoryIdx);

        $in[CATEGORY_IDX] = $categoryIdx;
        $in['Ymd'] = date('Ymd'); // 오늘 날짜


        // Check if the user can create a comment.
        $act  = act()->canCreateComment($category);
        if($act->hasError) {
            return $this->error($act->getError());
        }

        parent::create($in);
        if ( $this->hasError ) return $this;


        // update no of comment. There is no delete on comments. It's only marking as deleted.
        $post->update(['noOfComments' => $post->noOfComments + 1]);

        // 업로드된 파일의 taxonomy 와 entity 수정
        $this->fixUploadedFiles($in);


        act()->createComment($this);

        // Apply the point to comment memory field.
        $this->patchPoint();

        /**
         * NEW COMMENT IS CREATED ==>  Send notification to forum comment subscriber
         */
        onCommentCreateSendNotification($this); //

        return $this;

    }

    /**
     * Returns category.id of the current comment.
     * @return string
     */
    public function categoryId(): string {
        return postCategoryId($this->categoryIdx);
    }




    /**
     * Update comment
     *
     * The `$this->idx` must be set. That means, it can only be called with current entity(comment).
     *
     * @param array $in
     *
     * @return self
     */
    public function update(array $in): self {
        if ( notLoggedIn() ) return $this->error(e()->not_logged_in);
        if ( login()->block == 'Y' ) return $this->error(e()->blocked);
        if ( ! $this->idx ) return $this->error(e()->idx_is_empty);
        if ( $this->isMine() == false ) return $this->error(e()->not_your_comment);

        parent::update($in);

        // 업로드된 파일의 taxonomy 와 enttity 수정
        $this->fixUploadedFiles($in);

        return $this;
    }


    /**
     * @return $this
     */
    public function delete(): self
    {
        return $this->error(e()->comment_delete_not_supported);
    }


    /**
     * @return $this
     */
    public function markDelete(): self {
        if ( $this->hasError ) return $this;
        if ( notLoggedIn() ) return $this->error(e()->not_logged_in);
        if ( ! $this->idx ) return $this->error(e()->idx_is_empty);
        if ( $this->isMine() == false ) return $this->error(e()->not_your_comment);

        parent::markDelete();
        if ( $this->hasError ) return $this;

        parent::update([TITLE => '', CONTENT => '']);

        act()->deleteComment($this);

        return $this;
    }


    /**
     * 클라이언트로 보낼 정보
     *
     * @return array|string
     * - 에러가 있으면 에러 문자열
     * - 아니면, 배열
     */
    public function response(): array|string {
        if ( $this->hasError ) return $this->getError();

        $comment = $this->getData();


        // taxonomy 와 entity 를 기반으로 첨부 파일을 가져온다.
        $comment[FILES] = $this->files(response: true);


        if ( $comment[USER_IDX] ) {
            $comment['user'] = user($comment[USER_IDX])->shortProfile(firebaseUid: true);
        }

        $comment['shortDate'] = short_date_time($comment['createdAt']);


        return $comment;
    }


    /**
     * 현재 코멘트의 (최상위) 글을 객체로 리턴한다.
     *
     * @return PostTaxonomy
     */
    public function post(): PostTaxonomy {
        return post($this->rootIdx);
    }

    /**
     * return the number of login user's comments.
     * @return int
     */
    public function countMine(): int {
        $loginIdx = login()->idx;
        return $this->count(where: "userIdx=$loginIdx AND parentIdx>0 AND deletedAt=0");
    }

}


/**
 * Returns CommentTaxonomy instance.
 *
 * @param int $idx - The `idx` is the field of `posts` table. CommentTaxonomy uses the same table of posts.
 * @return CommentTaxonomy
 */
function comment(int $idx=0): CommentTaxonomy
{
    return new CommentTaxonomy($idx);
}


