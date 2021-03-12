<?php
/**
 * @file comment.class.php
 */
/**
 * Class Comment
 *
 * @property-read string title
 * @property-read string content
 * @property-read int createdAt
 * @property-read int deletedAt
 */
class Comment extends PostTaxonomy {

    public function __construct(int $idx)
    {
        parent::__construct($idx);

        if ( $idx ) {
            /// 코멘트 초기화
            /// 현재 코멘트에 대해서만 초기화를 한다.
            /// 현재 코멘트의 글 쓴이 정보나 파일(첨부 사진) 등을 로드하지 않는다.
            if ( $this->notFound == false ) {
                // $this->updateData('key', 'value');
            }
        }

    }

    /**
     * @param array $in
     *
     * @return Comment
     */
    public function create(array $in): self
    {
        if ( notLoggedIn() ) return $this->error(e()->not_logged_in);
        if ( !isset($in[ROOT_IDX]) ) return $this->error(e()->root_idx_is_empty);
        $in[USER_IDX] = login()->idx;

        /**
         * @todo when categoryIdx of post changes, categoryIdx of children must be changes.
         */
        $categoryIdx = postCategoryIdx($in[ROOT_IDX]);

        $in[CATEGORY_IDX] = $categoryIdx;
        parent::create($in);
        if ( $this->hasError ) return $this;


        $category = category($categoryIdx);

        // 제한에 걸렸으면, 에러 리턴.
        if ( $category->BAN_ON_LIMIT ) {
            $limit = point()->checkCategoryLimit($category->idx);
            if ( isError($limit) ) return $this->error($limit);
        }

        // 글/코멘트 쓰기에서 포인트 감소하도록 설정한 경우, 포인트가 모자라면, 에러
        $pointToCreate = point()->getCommentCreate($category->idx);
        if ( $pointToCreate < 0 ) {
            if ( login(POINT) < abs( $pointToCreate ) ) return $this->error(e()->lack_of_point);
        }

        // $comment = parent::create($in);
        point()->forum(POINT_COMMENT_CREATE, $this->idx);

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
        $record = $this->get(select: CATEGORY_IDX);
        $category = category($record[CATEGORY_IDX])->get(select: ID);
        return $category[ID];
    }



    /**
     * Update comment
     *
     * The `$this->idx` must be set. That means, it can only be called with current entity(comment).
     *
     * @param array $in
     *
     * @return Comment
     */
    public function update(array $in): self {
        if ( notLoggedIn() ) return $this->error(e()->not_logged_in);
        if ( ! $this->idx ) return $this->error(e()->idx_is_empty);
        if ( $this->isMine() == false ) return $this->error(e()->not_your_comment);

        return parent::update($in);
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
        if ( notLoggedIn() ) return $this->error(e()->not_logged_in);
        if ( ! $this->idx ) return $this->error(e()->idx_is_empty);
        if ( $this->isMine() == false ) return $this->error(e()->not_your_comment);

        parent::markDelete();
        parent::update([TITLE => '', CONTENT => '']);

        point()->forum(POINT_COMMENT_DELETE, $this->idx);

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

        /**
         * Get files only if $select includes 'files' field.
         */
        if ( isset($comment[FILES]) ) {
            $comment[FILES] = files()->responseFromIdxes($comment[FILES]);
        }


        if ( $comment[USER_IDX] ) {
            $comment['user'] = user($comment[USER_IDX])->postProfile();
        }

        return $comment;
    }



    /**
     * @deprecated
     * @param string|null $field
     * @param mixed|null $value
     * @param string $select
     * @param bool $cache
     * @return mixed
     * - Empty array([]) if comment not exists.
     *
     *
     * @todo add user(author) information
     * @todo add attached files if exists.
     */
    public function get(string $field=null, mixed $value=null, string $select='*', bool $cache=true): mixed
    {
        $comment = parent::get($field, $value, $select, $cache);

        /// @todo why is it getting empty comment? why empty comment happens?
        if ( empty($comment) ) {
            return [];
        }

        /**
         * Get files only if $select includes 'files' field.
         */
        if ( isset($comment[FILES]) ) {
            $comment[FILES] = files()->get($comment[FILES], select: 'idx,userIdx,path,name,size');
        }


        if ( $comment[USER_IDX] ) {
            $comment['user'] = user($comment[USER_IDX])->postProfile();
        }

        return $comment;
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
     * @param array $conds
     * @param string $conj
     * @return mixed
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
    ): array {

        $posts = parent::search(
            select: $select,
            where: $where,
            order: $order,
            by: $by,
            page: $page,
            limit: $limit,
        );

        $rets = [];
        foreach( $posts as $post ) {
            $idx = $post[IDX];
            $rets[] = comment($idx)->get();
        }

        return $rets;
    }


}


/**
 * Returns Comment instance.
 *
 * @param int $idx - The `idx` is the field of `posts` table. Comment uses the same table of posts.
 * @return Comment
 */
function comment(int $idx=0): Comment
{
    return new Comment($idx);
}


