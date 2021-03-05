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
        $root = post($in[ROOT_IDX])->get(select: CATEGORY_IDX);
        $in[CATEGORY_IDX] = $root[CATEGORY_IDX];
        $re = parent::create($in);


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
        onCommentCreateSendNotification($re);
        return $re;
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
     * - Empty array([]) if post not exists.
     *
     *
     * @todo add user(author) information
     * @todo add attached files if exists.
     */
    public function get(string $field=null, mixed $value=null, string $select='*', bool $cache=true): mixed
    {
        $comment = parent::get($field, $value, $select, $cache);

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


function onCommentCreateSendNotification(array $commentRecord)
{
    /**

     * 1) get post owner id
     * 2) get comment ancestors users_id
     * 3) make it unique to eliminate duplicate
     * 4) get topic subscriber
     * 5) remove all subscriber from token users
     * 6) get users token
     * 7) send batch 500 is maximum
     */

    /**
     *
     *  get all the user id of comment ancestors. - name as '$usersIdx'
     *  get all the user id of topic subscribers. - named as 'topic subscribers'.
     *  remove users of 'topic subscribers' from 'token users'. - with array_diff($array1, $array2) return the array1 that has no match from array2
     *  get the tokens of the users_id and filtering those who want to get comment notification
     *
     */


    $post = post($commentRecord[ROOT_IDX]);
    $usersIdx = [];

    /**
     * add post owner id if not mine
     */

    if ($post->isMine() == false) {
        $usersIdx[] = $post->value(USER_IDX);
    }

    /**
     * get comment ancestors id
     */
//    $comment = comment($commentRecord[IDX])->get();
    if ($commentRecord[PARENT_IDX] > 0) {
        $usersIdx = array_merge($usersIdx, getCommentAncestors($commentRecord[IDX]));
    }

    /**
     * get unique user ids
     */
    $usersIdx = array_unique($usersIdx);

    /**
     * get user who subscribe to comment forum topic
     */
    $catArr = category($post->value(CATEGORY_IDX))->get();
    $topic_subscribers = getForumSubscribers(NOTIFY_COMMENT . $catArr[ID]);

    /**
     * remove users_id that are registered to comment topic
     */
    $usersIdx = array_diff($usersIdx, $topic_subscribers);

    /**
     * get token of user that are not registered to forum comment topic and want to get notification on user settings
     */
    $tokens = getTokensFromUserIDs($usersIdx, NEW_COMMENT_ON_MY_POST_OR_COMMENT);


    /**
     * set the title and body, etc.
     */

    $title              = $post->value(TITLE);
    $body               = $commentRecord[CONTENT];
    $click_url          = $post->value(PATH);
    $data               = [
        'senderIdx' => my(IDX),
        'type' => 'post',
        'idx'=> $post->value(IDX)
    ];

    /**
     * send notification to users who subscribe to comment topic
     */
    sendMessageToTopic(NOTIFY_COMMENT . $catArr[ID], $title, $body, $click_url, $data);

    /**
     * send notification to comment ancestors who enable reaction notification
     */
    if (!empty($tokens)) sendMessageToTokens( $tokens, $title, $body, $click_url, $data);
}



/**
 * @param $topic - topic as string.
 *  It likes like `notificationPost_qna`.
 * @return array - array of user ids
 * @throws Exception
 */
function getForumSubscribers(string $topic): array
{
    $ids = [];

    // @TODO SEARCH ON META
//    $rows = user()->search(where: "code='$topic' AND data='Y'");
//    foreach ($rows as $user) {
//        $ids[] = $user[IDX];
//    }
    return $ids;
}

