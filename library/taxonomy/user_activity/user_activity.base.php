<?php

class UserActivityBase extends Entity {

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
     * @return int
     *
     * - 적용된 포인트를 음/양의 값으로 리턴한다. 이 리턴되는 값을 from_user_point_apply 또는 to_user_point_apply 에 넣으면 된다.
     * - 입력된 $point 가 올바르지 않거나, 증가되지 않으면 0을 리턴한다.
     */
    public function recordAction(
        string $action, int $fromUserIdx, int $fromUserPoint, int $toUserIdx, int $toUserPoint,
        string $taxonomy = '',
        int $entity = 0,
        int $categoryIdx = 0,
    ): int {
        // prepare
        $toUser = user($toUserIdx);
        $fromUserPointApply = 0;
        $fromUserPointAfter = 0;


        if ( $fromUserIdx ) {
            $fromUser = user($fromUserIdx);
            $fromUserPointApply  = $this->changeUserPoint($fromUserIdx, $fromUserPoint);
            $fromUserPointAfter = $fromUser->getPoint();
        }


        $toUserPointApply  = $this->changeUserPoint($toUserIdx, $toUserPoint);
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



    public function get(int $categoryIdx, string $reason) {
        return category($categoryIdx)->getAttribute($reason);
    }

    public function setPostCreatePoint($category, $point) {
        category($category)->update([POINT_POST_CREATE => $point]);
    }

    public function getPostCreatePoint($category) {
        return category($category)->POINT_POST_CREATE;
    }

    public function setCommentCreatePoint($category, $point) {
        category($category)->update([POINT_COMMENT_CREATE => $point]);
    }

    public function getCommentCreatePoint(int|string $category) {
        return category($category)->POINT_COMMENT_CREATE;
    }

    public function setPostDeletePoint($category, $point) {
        category($category)->update([POINT_POST_DELETE => $point]);
    }

    public function getPostDeletePoint($category) {
        return category($category)->POINT_POST_DELETE;
    }

    public function setCommentDeletePoint($category, $point) {
        category($category)->update([POINT_COMMENT_DELETE => $point]);
    }

    public function getCommentDeletePoint($category) {
        return category($category)->POINT_COMMENT_DELETE;
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