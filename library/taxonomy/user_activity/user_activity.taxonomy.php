<?php
/**
 * @file user_activity.php
 * @see readme.md
 */

class Actions {
    public static string $createPost = "createPost";
    public static string $createComment = "createComment";
    public static string $readPost = 'readPost';
    public static string $vote = 'vote';
    public static string $register = 'register';
}


class UserActivityTaxonomy extends Entity {

    public string $createPost = 'createPost';



    public function __construct(int $idx)
    {
        parent::__construct(USER_ACTIVITIES, $idx);
    }




    /**
     * Check the conditions on the activity.
     *
     * To see if the user has permission to act on the activity.
     * It is checking more on permission check, not on input parameter check for the activity.
     *  - It does not check if the user logged in or not,
     *  - and does not check the input data.
     *
     * What it does is to check the condition for user to act on the activity.
     *  - if the user has enough point
     *  - if the user has permission based on permission rules,
     *  - if the user can do the action based on the hourly, daily limitation
     *
     *
     *
     * @param string $activity
     * @param int $categoryIdx
     * @return bool|string
     *      true on success.
     *      error code on error.
     */
//    public function can(
//        string $activity,
//        int $categoryIdx = 0,
//        int $postIdx = 0,
//    ): bool|string {
//
//        switch ($activity) {
//            case Activity::$createPost :
//                if ( empty($categoryIdx) ) return e()->empty_category_idx;
//                $category = category($categoryIdx);
//
//                // if user is banned by daily, hourly limit.
//
//                // if user is banned by point change. (lack of point)
//
//                // if user is banned by point possession.
//
//                break;
//
//            case Activity::$createComment :
//                $category = category($categoryIdx);
//                // if user is banned by daily, hourly limit.
//                // if user is banned by point change. (lack of point)
//                // if user is banned by point possession.
//
//
//                break;
//
//            case Activity::$vote :
//                $category = post($postIdx);
//
//
//                break;
//
//            default :
//                return e()->wrong_activity;
//        }
//
//        return true;
//    }

    /**
     *
     * It logs a record on user activity.
     *
     * It will deduct point if it needs.
     *
     * What are the logs/activities to be recorded:
     *  - user registration, login, update, sign-out
     *  - forum like, dislike
     *  - forum create, update, delete
     *  - file upload, delete
     *  - You can add more.
     *
     */
//    public function on(string $activity) {
//
//    }


    public function canCreatePost(CategoryTaxonomy $category ) {

        // if user is banned by daily, hourly limit.
        // if user is banned by point change. (lack of point)
        // if user is banned by point possession.
    }

    public function canCreateComment(CategoryTaxonomy $category ) {

    }

    /**
     * @param UserTaxonomy $user
     * @return int|string
     *  - error code string if there is an error.
     *  - user.idx if success.
     */
    public function register(UserTaxonomy $user) : int | string {
        return $this->recordAction(
            action: Actions::$register,
            fromUserIdx: 0,
            fromUserPoint: 0,
            toUserIdx: login()->idx,
            toUserPoint: $this->getRegisterPoint()
        );
    }



    /**
     *
     * 입력된 $point 만큼 증감/한다. 만약, $point 가 음수 이면 차감한다.
     *
     * @param string $action - the action
     * @param int $fromUserIdx - the user(or system) that gives point. If the system is the one that give points to
     *  'toUser', then it should be 0.
     *  For register, login, $fromUserIdx must be 0 and $fromUserPoint must be 0.
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

        $fromUser = user($fromUserIdx);
        $toUser = user($toUserIdx);

        if ( $fromUserIdx ) {
            $fromUserPointApply  = $this->changeUserPoint($fromUserIdx, $fromUserPoint);
        }
        $toUserPointApply  = $this->changeUserPoint($toUserIdx, $toUserPoint);

        $created = $this->create([
            'fromUserIdx' => $fromUserIdx,
            'toUserIdx' => $toUserIdx,
            'action' => $action,
            'taxonomy' => $taxonomy,
            'entity' => $entity,
            'categoryIdx' => $categoryIdx,
            'fromUserPointApply' => $fromUserPointApply,
            'fromUserPointAfter' => $fromUser->getPoint(),
            'toUserPointApply' => $toUserPointApply,
            'toUserPointAfter' => $toUser->getPoint(),
        ]);

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

//        d("userIdx: $userIdx, point: $point, userPoint: $userPoint, savingPoint: $savingPoint");


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








    public function setLike($no) {
        config()->set(POINT_LIKE, $no);
    }

    public function getLike() {
        return config()->get(POINT_LIKE) ?? 0;
    }

    public function setDislike($no) {
        config()->set(POINT_DISLIKE, $no);
    }

    public function getDislike() {
        return config()->get(POINT_DISLIKE) ?? 0;
    }

    public function setLikeDeduction($no) {
        config()->set(POINT_LIKE_DEDUCTION, $no);
    }
    public function getLikeDeduction() {
        return config()->get(POINT_LIKE_DEDUCTION) ?? 0;
    }

    public function setDislikeDeduction($no) {
        config()->set(POINT_DISLIKE_DEDUCTION, $no);
    }

    public function getDislikeDeduction() {
        return config()->get(POINT_DISLIKE_DEDUCTION) ?? 0;
    }

    public function setRegisterPoint($no) {
        config()->set(POINT_REGISTER, $no);
    }

    public function getRegisterPoint() {
        return config()->get(POINT_REGISTER) ?? 0;
    }

    public function setLogin($no) {
        config()->set(POINT_LOGIN, $no);
    }

    public function getLogin() {
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

    public function setPostCreate($category, $point) {
        category($category)->update([POINT_POST_CREATE => $point]);
    }

    public function getPostCreate($category) {
        return category($category)->POINT_POST_CREATE;
    }

    public function setCommentCreate($category, $point) {
        category($category)->update([POINT_COMMENT_CREATE => $point]);
    }

    public function getCommentCreate(int|string $category) {
        return category($category)->POINT_COMMENT_CREATE;
    }

    public function setPostDelete($category, $point) {
        category($category)->update([POINT_POST_DELETE => $point]);
    }

    public function getPostDelete($category) {
        return category($category)->POINT_POST_DELETE;
    }

    public function setCommentDelete($category, $point) {
        category($category)->update([POINT_COMMENT_DELETE => $point]);
    }

    public function getCommentDelete($category) {
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





$__UserActivityTaxonomy = null;
/**
 * @param int $idx
 * @return UserActivityTaxonomy
 */
function act(int $idx=0): UserActivityTaxonomy
{
    global $__UserActivityTaxonomy;
    if ( $__UserActivityTaxonomy == null ) {
        $__UserActivityTaxonomy = new UserActivityTaxonomy($idx);
    }
    return $__UserActivityTaxonomy;
}

