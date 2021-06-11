<?php
/**
 * @file user_activity.base.php
 */
/**
 * Class UserActivityBase
 */
class UserActivityBase extends Entity {


    /**
     * Returns true if the records of $actions are more than the number of $count.
     * For instance, $count is set to 3, and $stamp is for 5 hours, and $actions are set to [login, createPost],
     *  then if there are more than 3 of login or createPost, it will return true.
     *
     * 포인트 기록 테이블에서 $stamp 시간 내에 $reason 들을 찾아 그 수가 $count 보다 많으면 true 를 리턴한다.
     * 예를 들어,
     *   - 추천/비추천을 1시간 이내에 5번으로 제한을 하려고 할 때,
     *   - 글 쓰기를 하루에 몇번으로 제한 할 때 등에 사용 할 수 있다.
     *
     * @param array $actions
     * @param int $stamp
     * @param int $count
     * @param int $fromUserIdx
     * @param int $categoryIdx
     * @return bool
     *  - true if there are more records than $count
     *  - false otherwise.
     *
     * @example
     *
     * // 추천/비추천 시간/수 제한
     * if ( $re = count_over(
     * [ POINT_LIKE, POINT_DISLIKE ], // 추천/비추천을
     * get_like_hour_limit() * 60 * 60, // 특정 시간에, 시간 단위 이므로 * 60 * 60 을 하여 초로 변경.
     * get_like_hour_limit_count() // count 회 수 이상 했으면,
     * ) ) return ERROR_HOURLY_LIMIT; // 에러 리턴
     */
    function countOver(array $actions, int $stamp, int $count, int $fromUserIdx=0, int $categoryIdx=0): bool {
        if ( $count ) {
//            d("countOver: $categoryIdx");
            $total = $this->countActions( actions: $actions, stamp: $stamp, fromUserIdx: $fromUserIdx, categoryIdx: $categoryIdx );
//            d("if ( total: $total >= count: $count ) {");
            if ( $total == 0 ) return false;
            else if ( $total >= $count ) {
                return true;
            }
        }
        return false;
    }




    /**
     * Returns the number of records of $actions for the last period of $stamp.
     *
     * 포인트 기록 테이블에서, $stamp 시간 내의 입력된 $actions 의 레코드를 수를 찾아 리턴한다.
     *
     * 주의, 추천/비추천과 같이 행동을 하는(포인트를 주는) 주체가 나 인경우, fromUser 에서 제한한다.
     * 그 외(가입, 로그인 글 쓰기)는 toUser 에서 제한한다.
     * 이 때에는 $fromUserIdx 에 값이 들어와야 한다.
     *
     * @param int $stamp
     * @param array $actions
     * @param int $fromUserIdx - user.idx to find records of
     *  - If $fromUserIdx is not set, then it will search for the login user's record.
     *    만약 fromUserIdx 가 지정되지 않으면, 로그인한 사용자의 idx 를 toUserIdx 로 사용한다.
     * @param int $categoryIdx
     *  Finds records for that specific category.idx
     * @return int|string|null
     */
    function countActions(array $actions, int $stamp, int $fromUserIdx=0, int $categoryIdx=0): int|string|null
    {
        if ( ! $stamp ) return 0;
        $reason_ors = "(" . sqlCondition($actions, 'OR', 'action') . ")";

        $q_categoryIdx = '';
        if ( $categoryIdx ) $q_categoryIdx = "AND categoryIdx=$categoryIdx";

        $last_stamp = time() - $stamp;

        if ( $fromUserIdx ) {
            $user = "fromUserIdx=$fromUserIdx";
        } else {
            $user = "toUserIdx=" . login()->idx;
        }

        $q = "SELECT COUNT(*) FROM ". $this->getTable() ." WHERE createdAt > $last_stamp AND $user $q_categoryIdx AND $reason_ors";
//        d($q);

        return db()->column($q);
    }


    /**
     * An alias of recordAction()
     * @param string $action
     * @param int $fromUserIdx
     * @param int $fromUserPoint
     * @param int $toUserIdx
     * @param int $toUserPoint
     * @param string $taxonomy
     * @param int $entity
     * @param int $categoryIdx
     * @return $this
     */
    public function changePoint(
        string $action,
        int $fromUserIdx,
        int $fromUserPoint,
        int $toUserIdx,
        int $toUserPoint,
        string $taxonomy = '',
        int $entity = 0,
        int $categoryIdx = 0,
    ): self {
        return $this->recordAction(
            $action,
            $fromUserIdx,
            $fromUserPoint,
            $toUserIdx,
            $toUserPoint,
            $taxonomy,
            $entity,
            $categoryIdx,
        );
    }

    /**
     * Records user action.
     *
     * @attention All of the user action(or events) should be recorded whether the point is being changed or not.
     *
     * @attention This deducts or increases user point.
     *
     * @attention All the check & test must be done before calling this method. Or it may cause an unexpected result!
     *
     *      If the user has reached the limit of voting point change, then the input of toUserPoint must be 0, so it
     *      will record the action without point change.
     *
     * @attention If the user point is less than the deduction, then user point will be 0.
     *
     *
     * @param string $action - the action ( or the user's activity ). For instance, 'vote', 'create', or any event name you like.
     *
     * @param int $fromUserIdx - the user(or system) that gives point to the other user.
     *  - If the from user is you, then you will lose your point and the other will get your point.
     *  - If the from user is you, and the other user(toUser) is you, then from user and its point must be 0.
     *
     *  - If the system is the one that give points to 'toUserIdx', then it should be 0.
     *      For instance 'register' or 'login' actions, the system is the one that give point to user.
     *
     *
     *  - If the point should be changed on both user(fromUser and toUser), then set fromUser.
     *    For instance, vote(like or dislike), one user triggers the action and that effects to the other user.
     *    So, 'fromUser' is the user who does the voting, and 'toUser' is the user who wrote the post(or comment)
     *    And if fromUserPoint is set, the fromUser will lose(or gain by the admin setting) his point,
     *      And the other user will get(or lose by the admin setting) his point.
     *
     * @param int $fromUserPoint - the amount of the point to apply to(or to deduct from) $fromUserIdx
     * @param int $toUserIdx - the user that will receive point from $fromUserIdx.
     * @param int $toUserPoint - the amount of the point to apply to $toUserIdx.
     * @param string $taxonomy
     * @param int $entity
     * @param int $categoryIdx
     *
     * @return $this
     * It returns the created object.
     * - if it has error, then error will be set on the object.
     *
     *
     * @example User A wants give 100 points to User B by 'point-transfer'. Then,
     * ```
     * $this->recordAction(
     *  action: 'point-transfer',
     *  fromUserIdx: A's idx,
     *  fromUserFrom: 100,
     *  toUserIdx: B's idx,
     *  toUserPoint: 100,
     *  // ...
     * )
     * ```
     *
     * @example User A loses 200 points by creating a job posting, then,
     * ```
     * $this->recordAction(
     *  action: 'job-posting',
     *  fromUserIdx: 0,
     *  fromUserFrom: 0,
     *  toUserIdx: A's idx,
     *  toUserPoint: -200,
     *  // ...
     * )
     * ```
     *
     * @note You may need to record twice by calling `recordAction()` two times for a specific actions like voting.
     *
     *
     * - 적용된 포인트를 음/양의 값으로 리턴한다. 이 리턴되는 값을 from_user_point_apply 또는 to_user_point_apply 에 넣으면 된다.
     * - 입력된 $point 가 올바르지 않거나, 증가되지 않으면 0을 리턴한다.
     */
    public function recordAction(
        string $action,
        int $fromUserIdx,
        int $fromUserPoint,
        int $toUserIdx,
        int $toUserPoint,
        string $taxonomy = '',
        int $entity = 0,
        int $categoryIdx = 0,
    ): self {
        // d("recordAction( action: $action, fromUserIdx: $fromUserIdx, toUserIdx: $toUserIdx, toUserPoint: $toUserPoint");
        // prepare
        $toUser = user($toUserIdx);
        $fromUserPointApply = 0;
        $fromUserPointAfter = 0;
        $toUserPointApply = 0;

        if ( ! $toUserIdx ) return $this->error(e()->user_activity_record_action_to_user_idx_is_empty);

        if ( $fromUserIdx ) {
            $fromUser = user($fromUserIdx);
            $fromUserPointApply  = $this->changeUserPoint($fromUserIdx, $fromUserPoint);
            $fromUserPointAfter = $fromUser->getPoint();
        }


        if ( $toUserPoint ) {
            $toUserPointApply  = $this->changeUserPoint($toUserIdx, $toUserPoint);
        }
        $toUserPointAfter = $toUser->getPoint();


        $record = [
            'fromUserIdx' => $fromUserIdx,
            'toUserIdx' => $toUserIdx,
            'action' => $action,
            'taxonomy' => $taxonomy,
            'entity' => $entity,
            'categoryIdx' => $categoryIdx,
            'fromUserPointApply' => $fromUserPointApply,
            'fromUserPointAfter' => $fromUserPointAfter,
            'toUserPointApply' => $toUserPointApply,
            'toUserPointAfter' => $toUserPointAfter,
        ];
//        d($record);

        return $this->create($record);

//        $created = $this->create($record);
//
//        if ( $created->hasError ) return $created->getError();
//        else return $created->idx;
    }




    /**
     *
     * Return changed amount after increase or decrease point.
     *
     * @logic
     *  - The point does not go below 0. That means no user have minus point(less than 0).
     *  - If the returned value is bigger than 0, then the point has increased.
     *  - If the returned value is lower than 0, then the point has decreased.
     *  - If the user is lack of point, than it deducts only amount of the point that the user has.
     *      For instance, the system point for dislike deduction is 500, and the user has only 300.
     *      then, 300 point will be deducted. and 300 will be returned.
     *
     *
     *
     * @return int
     *
     * - 적용된 포인트를 음/양의 값으로 리턴한다. 이 리턴되는 값을 from_user_point_apply 또는 to_user_point_apply 에 넣으면 된다.
     * - 입력된 $point 가 올바르지 않거나, 증가되지 않으면 0을 리턴한다.
     */
    protected function changeUserPoint($userIdx, $point): int
    {
        if ( !$point ) return 0;
        $user = user($userIdx);
        $userPoint = $user->getPoint();
        $savingPoint = $userPoint + $point;

        // 저장되려는 포인트가 0 보다 작으면,
        if ( $savingPoint < 0 ) {
            // 0 을 저장하고,
            $user->setPoint(0);
            // 실제 차감된 포인트를 리턴
            return -$userPoint;
        } else {
            // 저장되려는 포인트가 양수이면, 저장하고,
            $user->setPoint($savingPoint);
            // 전체 증가 포인트를 리턴
            return $point;
        }
    }


    /**
     * @deprecated remove 'point.defines.php'
     * @param $no
     */
    public function setLikePoint($no) {
        config()->set(Actions::$like, $no);
    }

    public function getLikePoint() {
        return config()->get(Actions::$like) ?? 0;
    }

    public function setDislikePoint($no) {
        config()->set(Actions::$dislike, $no);
    }

    public function getDislikePoint() {
        return config()->get(Actions::$dislike) ?? 0;
    }

    /**
     * @deprecated delete point.definitions.php
     * @param $no
     */
    public function setLikeDeductionPoint($no) {
        config()->set(Actions::$likeDeduction, $no);
    }
    public function getLikeDeductionPoint() {
        return config()->get(Actions::$likeDeduction) ?? 0;
    }

    public function setDislikeDeductionPoint($no) {
        config()->set(Actions::$dislikeDeduction, $no);
    }

    public function getDislikeDeductionPoint() {
        return config()->get(Actions::$dislikeDeduction) ?? 0;
    }

    public function setRegisterPoint($no) {
        config()->set(Actions::$register, $no);
    }

    public function getRegisterPoint() {
        return config()->get(Actions::$register) ?? 0;
    }

    public function setLoginPoint($no) {
        config()->set(Actions::$login, $no);
    }

    public function getLoginPoint() {
        return config()->get(Actions::$login) ?? 0;
    }

    /**
     * @deprecated rename to setVoteHourLimit
     * @param $hour
     */
    public function setLikeHourLimit($hour) {
        config()->set(ActivityLimits::$voteHourlyLimit, $hour);
    }

    public function getLikeHourLimit() {
        return config()->get(ActivityLimits::$voteHourlyLimit) ?? 0;
    }


    public function setLikeHourLimitCount($count) {
        config()->set(ActivityLimits::$voteHourlyLimitCount, $count);
    }

    public function getLikeHourLimitCount() {
        return config()->get(ActivityLimits::$voteHourlyLimitCount) ?? 0;
    }

    /**
     * @deprecated name it to setVoteDailyCount
     * @param $count
     */
    public function setLikeDailyLimitCount($count) {
        config()->set(ActivityLimits::$voteDailyLimitCount, $count);
    }

    public function getLikeDailyLimitCount() {
        return config()->get(ActivityLimits::$voteDailyLimitCount) ?? 0;
    }


    /**
     * @deprecated don't use this
     * @param int $categoryIdx
     * @param string $action
     * @return array|float|int|string|null
     */
    public function get(int $categoryIdx, string $action) {
        return category($categoryIdx)->getData($action);
    }

    public function setPostCreatePoint($category, $point) {
        category($category)->update([Actions::$createPost => $point]);
    }

    public function getPostCreatePoint($category) {
        return category($category)->getData(Actions::$createPost, 0);
    }

    public function setCommentCreatePoint($category, $point) {
        category($category)->update([Actions::$createComment => $point]);
    }

    public function getCommentCreatePoint(int|string $category) {
        return category($category)->getData(Actions::$createComment, 0);
    }

    public function setPostDeletePoint($category, $point) {
        category($category)->update([Actions::$deletePost => $point]);
    }

    public function getPostDeletePoint($category) {
        return category($category)->getData(Actions::$deletePost, 0);
    }


    public function setCommentDeletePoint($category, $point) {
        category($category)->update([Actions::$deleteComment => $point]);
    }

    public function getCommentDeletePoint($category) {
        return category($category)->getData(Actions::$deleteComment, 0);
    }

    public function setCreateHourLimit($category, $hour) {
        category($category)->update([ActivityLimits::$createHourLimit => $hour]);
    }


    public function getCreateHourLimit(int|string $category) {
        return category($category)->getData(ActivityLimits::$createHourLimit, 0);
    }

    public function setCreateHourLimitCount($category, $count) {
        return category($category)->update([ActivityLimits::$createHourLimitCount => $count]);
    }

    public function getCreateHourLimitCount(int|string $category) {
        return category($category)->getData(ActivityLimits::$createHourLimitCount, 0);
    }

    public function setCreateDailyLimitCount($category, $count) {
        category($category)->update([ActivityLimits::$createDailyLimitCount => $count]);
    }
    public function getCreateDailyLimitCount(int|string $category) {
        return category($category)->getData(ActivityLimits::$createDailyLimitCount, 0);
    }

    public function enableBanCreateOnLimit(int|string $category) {
        category($category)->update([ActivityLimits::$banCreateOnLimit => 'Y']);
    }

    public function disableBanCreateOnLimit(int|string $category) {
        category($category)->update([ActivityLimits::$banCreateOnLimit => 'N']);
    }




    /**
     * Returns true if the activity of the category is banned on limit.
     * @param int $categoryIdx
     * @return bool
     */
    public function isCategoryBanOnLimit(int $categoryIdx) {
//        d("ban($categoryIdx): " . category($categoryIdx)->getData(ActivityLimits::$banCreateOnLimit, ''));
        return category($categoryIdx)->getData(ActivityLimits::$banCreateOnLimit, '') == 'Y';
    }

    public function setPostCreateLimitPoint(int|string $category, $point) {
        category($category)->update([ActivityLimits::$postCreateLimit => $point]);
    }
    public function getPostCreateLimitPoint(int|string $category): int {
        return category($category)->getData(ActivityLimits::$postCreateLimit, 0);
    }

    public function setCommentCreateLimitPoint(int|string $category, $point) {
        category($category)->update([ActivityLimits::$commentCreateLimit => $point]);
    }
    public function getCommentCreateLimitPoint(int|string $category): int {
        return category($category)->getData(ActivityLimits::$commentCreateLimit, 0);
    }

    public function setReadLimitPoint(int|string $category, $point) {
        category($category)->update([ActivityLimits::$readLimit => $point]);
    }
    public function getReadLimitPoint(int|string $category): int {
        return category($category)->getData(ActivityLimits::$readLimit, 0);
    }

}