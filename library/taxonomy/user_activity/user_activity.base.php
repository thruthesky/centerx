<?php

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
            if ( $total >= $count ) {
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
            $user = "fromUserIdx=?";
            $userIdx = $fromUserIdx;
        } else {
            $user = "toUserIdx=?";
            $userIdx = login()->idx;
        }

        $q = "SELECT COUNT(*) FROM ". $this->getTable() ." WHERE createdAt > $last_stamp AND $user $q_categoryIdx AND $reason_ors";
//        d($q);

        return db()->column($q);
    }


    /**
     * Records user action
     *
     *
     *
     * @param string $action - the action ( or the user's activity )
     * @param int $fromUserIdx - the user(or system) that gives point to the other user.
     *  If the system is the one that give points to 'toUserIdx', then it should be 0.
     *  For instance 'register' or 'login' actions, the system is the one that give point to user.
     *  For vote, one user triggers the action and that effects to the other user.
     *      So, 'fromUser' is the user who votes, and 'toUser' is the user who wrote the post(or comment)
     *
     * @param int $fromUserPoint - the point to apply to $fromUserIdx
     * @param int $toUserIdx - the user that will receive point.
     * @param int $toUserPoint - the point to apply to $toUserIdx.
     * @param string $taxonomy
     * @param int $entity
     * @param int $categoryIdx
     * @return int|string
     *
     * - 적용된 포인트를 음/양의 값으로 리턴한다. 이 리턴되는 값을 from_user_point_apply 또는 to_user_point_apply 에 넣으면 된다.
     * - 입력된 $point 가 올바르지 않거나, 증가되지 않으면 0을 리턴한다.
     */
    public function recordAction(
        string $action, int $fromUserIdx, int $fromUserPoint, int $toUserIdx, int $toUserPoint,
        string $taxonomy = '',
        int $entity = 0,
        int $categoryIdx = 0,
    ): int|string {
        // d("recordAction( action: $action, fromUserIdx: $fromUserIdx, toUserIdx: $toUserIdx, toUserPoint: $toUserPoint");
        // prepare
        $toUser = user($toUserIdx);
        $fromUserPointApply = 0;
        $fromUserPointAfter = 0;
        $toUserPointApply = 0;

        if ( ! $toUserIdx ) return e()->user_activity_record_action_to_user_idx_is_empty;

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

        $created = $this->create($record);


        if ( $created->hasError ) return $created->getError();
        else return $created->idx;
    }




    /**
     *
     * Return changed amount after increase or decrease point.
     *
     * @logic
     *  - The point does not go below 0. That means no user gets minus point.
     *  - If the returned value is bigger than 0, then the point has increased.
     *  - If the returned value is lower than 0, then the point has decreased.
     *  - If the user is lack of point, than it deducts only the user's amount.
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
    public function changeUserPoint($userIdx, $point): int
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







    public function setLikePoint($no) {
        config()->set(POINT_LIKE, $no);
    }

    public function getLikePoint() {
        return config()->get(POINT_LIKE) ?? 0;
    }

    public function setDislikePoint($no) {
        config()->set(POINT_DISLIKE, $no);
    }

    public function getDislikePoint() {
        return config()->get(POINT_DISLIKE) ?? 0;
    }

    public function setLikeDeductionPoint($no) {
        config()->set(POINT_LIKE_DEDUCTION, $no);
    }
    public function getLikeDeductionPoint() {
        return config()->get(POINT_LIKE_DEDUCTION) ?? 0;
    }

    public function setDislikeDeductionPoint($no) {
        config()->set(POINT_DISLIKE_DEDUCTION, $no);
    }

    public function getDislikeDeductionPoint() {
        return config()->get(POINT_DISLIKE_DEDUCTION) ?? 0;
    }

    public function setRegisterPoint($no) {
        config()->set(POINT_REGISTER, $no);
    }

    public function getRegisterPoint() {
        return config()->get(POINT_REGISTER) ?? 0;
    }

    public function setLoginPoint($no) {
        config()->set(POINT_LOGIN, $no);
    }

    public function getLoginPoint() {
        return config()->get(POINT_LOGIN) ?? 0;
    }

    public function setLikeHourLimit($hour) {
        config()->set(POINT_LIKE_HOUR_LIMIT, $hour);
    }

    public function getLikeHourLimit() {
        return config()->get(POINT_LIKE_HOUR_LIMIT) ?? 0;
    }

    public function setLikeHourLimitCount($count) {
        config()->set(POINT_LIKE_HOUR_LIMIT_COUNT, $count);
    }

    public function getLikeHourLimitCount() {
        return config()->get(POINT_LIKE_HOUR_LIMIT_COUNT) ?? 0;
    }

    public function setLikeDailyLimitCount($count) {
        config()->set(POINT_LIKE_DAILY_LIMIT_COUNT, $count);
    }

    public function getLikeDailyLimitCount() {
        return config()->get(POINT_LIKE_DAILY_LIMIT_COUNT) ?? 0;
    }



    public function get(int $categoryIdx, string $action) {
        return category($categoryIdx)->getData($action);
    }

    public function setPostCreatePoint($category, $point) {
        category($category)->update([Actions::$createPostPoint => $point]);
    }

    public function getPostCreatePoint($category) {
        return category($category)->createPostPoint;
    }

    public function setCommentCreatePoint($category, $point) {
        category($category)->update([Actions::$createCommentPoint => $point]);
    }

    public function getCommentCreatePoint(int|string $category) {
        return category($category)->createCommentPoint;
    }

    public function setPostDeletePoint($category, $point) {
        category($category)->update([Actions::$deletePostPoint => $point]);
    }

    public function getPostDeletePoint($category) {
        return category($category)->deletePostPoint;
    }

    public function setCommentDeletePoint($category, $point) {
        category($category)->update([Actions::$deleteCommentPoint => $point]);
    }

    public function getCommentDeletePoint($category) {
        return category($category)->deleteCommentPoint;
    }

    public function setCategoryHour($category, $hour) {
        category($category)->update([POINT_HOUR_LIMIT => $hour]);
    }


    public function getCategoryHourLimit(int|string $category) {
        return category($category)->POINT_HOUR_LIMIT;
    }

    public function setCategoryHourLimitCount($category, $count) {
        return category($category)->update([POINT_HOUR_LIMIT_COUNT => $count]);
    }

    public function getCategoryHourLimitCount(int|string $category) {
        return category($category)->POINT_HOUR_LIMIT_COUNT;
    }

    public function setCategoryDailyLimitCount($category, $count) {
        category($category)->update([POINT_DAILY_LIMIT_COUNT => $count]);
    }
    public function getCategoryDailyLimitCount(int|string $category) {
        return category($category)->POINT_DAILY_LIMIT_COUNT;
    }

    public function enableCategoryBanOnLimit(int|string $category) {
        category($category)->update([BAN_ON_LIMIT => 'Y']);
    }

    public function disableCategoryBanOnLimit(int|string $category) {
        category($category)->update([BAN_ON_LIMIT => 'N']);
    }
}