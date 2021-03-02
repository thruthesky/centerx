<?php

class Comment extends Entity {

    public function __construct(int $idx)
    {
        parent::__construct(COMMENTS_TAXONOMY, $idx);
    }

    public function create(array $in): array|string
    {
        if ( notLoggedIn() ) return e()->not_logged_in;
        if ( !isset($in[ROOT_IDX]) ) return e()->root_idx_is_empty;
        $in[USER_IDX] = my(IDX);

        /**
         * @todo when categoryIdx of post changes, categoryIdx of children must be changes.
         */
        $root = post($in[ROOT_IDX])->get(select: CATEGORY_IDX);
        $in[CATEGORY_IDX] = $root[CATEGORY_IDX];

        return parent::create($in);
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


        //
        return parent::update($in);
    }


    public function markDelete(): array|string {
        if ( notLoggedIn() ) return e()->not_logged_in;
        if ( ! $this->idx ) return e()->idx_is_empty;
        if ( $this->exists() == false ) return e()->post_not_exists;
        if ( $this->isMine() == false ) return e()->not_your_comment;


        $record = parent::markDelete();
        if ( isError($record) ) return $record;
        $this->update([TITLE => '', CONTENT => '']);
        return $this->get();
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
     * @todo add user(author) information
     * @todo add attached files if exists.
     */
    public function get(string $field=null, mixed $value=null, string $select='*'): mixed
    {
        $comment = parent::get($field, $value, $select);

        /**
         * Get files only if $select includes 'files' field.
         */
        if ( isset($comment[FILES]) ) {
            $comment[FILES] = files()->get($comment[FILES], select: 'idx,userIdx,path,name,size');
        }
        return $comment;
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
