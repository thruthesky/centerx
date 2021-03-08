<?php

class Comment extends Entity {

    public function __construct(int $idx)
    {
        parent::__construct(COMMENTS_TAXONOMY, $idx);
    }

    /**
     * @param array $in
     * @return array|string
     */
    public function create(array $in): array|string
    {
        if ( notLoggedIn() ) return e()->not_logged_in;
        if ( !isset($in[ROOT_IDX]) ) return e()->root_idx_is_empty;
        $in[USER_IDX] = my(IDX);

        /**
         * @todo when categoryIdx of post changes, categoryIdx of children must be changes.
         */
        $categoryIdx = postCategoryIdx($in[ROOT_IDX]); // post($in[ROOT_IDX])->get(select: CATEGORY_IDX);


        $in[CATEGORY_IDX] = $categoryIdx;
        $re = parent::create($in);
        if ( isError($re) ) return $re;

        $category = category($re[CATEGORY_IDX]);

        // 제한에 걸렸으면, 에러 리턴.
        if ( $category->value(BAN_ON_LIMIT) ) {
            $limit = point()->checkCategoryLimit($category->idx);
            if ( isError($limit) ) return $limit;
        }

        // 글/코멘트 쓰기에서 포인트 감소하도록 설정한 경우, 포인트가 모자라면, 에러
        $pointToCreate = point()->getCommentCreate($category->idx);
        if ( $pointToCreate < 0 ) {
            if ( my(POINT) < abs( $pointToCreate ) ) return e()->lack_of_point;
        }

        // $comment = parent::create($in);
        point()->forum(POINT_COMMENT_CREATE, $re[IDX]);

        /**
         * NEW COMMENT IS CREATED ==>  Send notification to forum comment subscriber
         */
        onCommentCreateSendNotification($re); //

        return comment($re[IDX])->get();
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
     * @attention The entity.idx must be set. That means, it can only be called with `post(123)->update()`.
     *
     * @param array $in
     * @return array|string
     */
    public function update(array $in): array|string {
        if ( notLoggedIn() ) return e()->not_logged_in;
        if ( ! $this->idx ) return e()->idx_is_empty;
        if ( $this->exists() == false ) return e()->post_not_exists;
        if ( $this->isMine() == false ) return e()->not_your_comment;


        $updated = parent::update($in);
        if ( isError($updated) ) return $updated;
        return comment($updated[IDX])->get();
    }



    public function delete()
    {
        return e()->comment_delete_not_supported;
    }


    public function markDelete(): array|string {
        if ( notLoggedIn() ) return e()->not_logged_in;
        if ( ! $this->idx ) return e()->idx_is_empty;
        if ( $this->exists() == false ) return e()->post_not_exists;
        if ( $this->isMine() == false ) return e()->not_your_comment;


        $record = parent::markDelete();
        if ( isError($record) ) return $record;
        $this->update([TITLE => '', CONTENT => '']);


        point()->forum(POINT_COMMENT_DELETE, $this->idx);

        return $this->get();
    }


    /**
     *
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
     * @param string $categoryId
     * @return mixed
     * @throws Exception
     */
    public function search(
        string $where='1', int $page=1, int $limit=10, string $order='idx', string $by='DESC', $select='idx'
    ): mixed {

        $posts = parent::search(
            where: $where,
            page: $page,
            limit: $limit,
            order: $order,
            by: $by,
            select: $select,
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
 * @param array|int $idx - The `posts.idx` which is considered as comment idx. Or an array of the comment record.
 * @return Comment
 */
function comment(array|int $idx=0): Comment
{
    if ( is_array($idx) ) return new Comment($idx[IDX]);
    else return new Comment($idx);
}


