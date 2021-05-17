<?php

class Point {


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

    public function setRegister($no) {
        config()->set(POINT_REGISTER, $no);
    }

    public function getRegister() {
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


    /**
     * 포인트 증/감 후, 증/감된 값을 리턴한다.
     *
     * 리턴 값이 양수이면, 증가된 값, 음수이면, 감소한 값이다.
     *
     * 주의: 포인트가 음수로 입력되어 사용자의 포인트를 차감하려고 하는 경우, 사용자의 포인트를 음수로 DB 에 저장하지 않고, 최소 0으로 저장한다.
     *      즉, 포인트가 모자라도, 정상적인 값을 리턴한다.
     *      예) -100 을 차감하는데, 가진 포인트가 80 밖에 없다면, DB 에는 0을 저장하고, -80을 리턴한다.
     *      따라서, 포인트가 모자란 경우, 에러를 내야한다면, 이 함수를 호출하기 전에 에러 체크를 해야 한다.
     *
     * 주의: 로그는 $this->log() 함수를 호출해서, 따로 기록을 해야 한다.
     *
     * @param $user_ID
     * @param $point
     * 입력된 $point 만큼 증감/한다. 만약, $point 가 음수 이면 차감한다.
     *
     * @return int
     *
     * - 적용된 포인트를 음/양의 값으로 리턴한다. 이 리턴되는 값을 from_user_point_apply 또는 to_user_point_apply 에 넣으면 된다.
     * - 입력된 $point 가 올바르지 않거나, 증가되지 않으면 0을 리턴한다.
     */
    public function addUserPoint($userIdx, $point): int
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


    /**
     * 포인트 기록
     *
     * 시스템이 포인트를 주거나(글/코멘트 쓰기/삭제), 또는 관리자가 포인트를 충전하거나 등에서는 fromUserIdx 값이 없고, toUserIdx 값만 있다.
     * 그래서, toUserIdx 와 toUserPointApply 의 값은 거의 항상 들어와야 한다.
     * 하지만, 사용자끼리 포인트를 주고 받는 경우(증감하는 경우)에는 fromUserIdx 와 toUserIdx 값이 있다.
     *
     * @param string $reason - 포인트 변경 사유.
     * @param int $toUserIdx - 포인트를 받는 사용자.
     * @param int $fromUserIdx - 포인트를 주는 사용자.
     * @param int $toUserPointApply
     * @param int $fromUserPointApply
     * @param string $taxonomy
     * @param int $entity
     * @param int $categoryIdx
     * @return int - 기록 레코드 번호
     */
    public function log(
        string $reason,
        int $toUserIdx=0,
        int $fromUserIdx=0,
        int $toUserPointApply=0,
        int $fromUserPointApply=0,
        string $taxonomy = '',
        int $entity = 0,
        int $categoryIdx = 0,
    ): int {

        $history = [
            FROM_USER_IDX => $fromUserIdx,
            TO_USER_IDX => $toUserIdx,
            REASON => $reason,
            TAXONOMY => $taxonomy,
            ENTITY => $entity,
            CATEGORY_IDX => $categoryIdx,
            'fromUserPointApply' => $fromUserPointApply,
            'fromUserPointAfter' => $fromUserIdx ? user($fromUserIdx)->getPoint() : 0,
            'toUserPointApply' => $toUserPointApply,
            'toUserPointAfter' => user($toUserIdx)->getPoint(),
        ];
        $record = pointHistory()->create($history);
        return $record->idx;
    }

    /**
     * 에러가 있으면 에러 문자열, 아니면, idx 가 리턴된다.
     * @param array $profile
     * @return int
     */
    public function register(array $profile) {
        $applied = $this->addUserPoint($profile[IDX], config()->get(POINT_REGISTER));
        $idx = $this->log(
            POINT_REGISTER,
            toUserIdx: $profile[IDX],
            toUserPointApply: $applied,
        );
        if (pointHistory($idx)->toUserPointAfter == config()->get(POINT_REGISTER)) {
            return $idx;
        } else {
            return e()->failed_to_add_register_point;
        }
    }

    /**
     * @param array $profile
     * @return int
     */
    public function login(array $profile) {
//        debug_log("POINT_LOING: ", config()->get(POINT_LOGIN));
        $applied = $this->addUserPoint($profile[IDX], config()->get(POINT_LOGIN));
//        debug_log('applied: ', $applied);
//        debug_log('my point: ', login()->getPoint());
        return $this->log(
            POINT_LOGIN,
            toUserIdx: $profile[IDX],
            toUserPointApply: $applied,
        );
    }


    /**
     * When user purchase point, it adds the point to the user and logs.
     * @param int $point
     * @return int
     */
    public function purchase(int $point): int
    {
        $applied = $this->addUserPoint(login()->idx, $point);
       return $this->log(
           reason: POINT_PURCHASE,
           toUserIdx: login()->idx,
           toUserPointApply: $applied,
       );
    }


    /**
     * 글 뿐만아니라, 코멘트나 기타 posts 테이블을 사용하는 모든 것이 된다.
     * 추천이 아니라, 쓰기/삭제이기 때문에, 내가 내 자신에게만 적용한다. 그래서 다른 사람의 글이면 그냥 리턴한다.
     * 그리고 toUserIdx 와 toUserPointApply 만 업데이트 된다.
     *
     * @param string $reason
     * @param int|string $idx
     * @return int|string
     */
    public function forum(string $reason, int $idx): int|string {

        $post = post($idx);
        if ( $post->isMine() == false ) return 0;
        $categoryIdx = $post->categoryIdx;

        // 제한에 걸렸으면, 에러 코드 리턴
        $re = $this->checkCategoryLimit($categoryIdx);
        if ( isError($re) ) {
            return $re;
        }

        // 현재 REASON 에 대한 포인트를 얻는다.
        $point = $this->get($categoryIdx, $reason);

        // 포인트 추가하기
        $applied = $this->addUserPoint(login()->idx, $point );

//        d("reason: $reason, toUserIdx: " . $post->userIdx . ", toUserPointApply: $applied, taxonomy: posts");

        // 포인트 기록 남기기
        return $this->log(
            reason: $reason,
            toUserIdx: $post->userIdx,
            toUserPointApply: $applied,
            taxonomy: POSTS,
            entity: $post->idx,
            categoryIdx: $categoryIdx,
        );
    }

    /**
     * 게시판 글/코멘트 쓰기 제한에 걸렸으면 에러 문자열을 리턴한다. 제한에 걸리지 않았으면 false 를 리턴한다.
     * @param int|string $category
     * @return false|string
     */
    public function checkCategoryLimit(int|string $category) {
        if ( $this->categoryHourlyLimit($category) ) {
            return e()->hourly_limit;
        }
        if ( $this->categoryDailyLimit($category) ) {
            return e()->daily_limit;
        }
        return false;
    }

    /**
     * 카테고리 별 글/코멘트 쓰기 제한에 걸렸으면 true 를 리턴한다.
     * @param int|string $categoryIdx
     * @return bool
     */
    public function categoryHourlyLimit(int|string $categoryIdx): bool {
        $re = $this->countOver(
            reasons: [ POINT_POST_CREATE, POINT_COMMENT_CREATE ], // 글/코멘트 작성을
            stamp: intval($this->getCategoryHourLimit($categoryIdx)) * 60 * 60, // 특정 시간에, 시간 단위 이므로 * 60 * 60 을 하여 초로 변경.
            count: intval($this->getCategoryHourLimitCount($categoryIdx)), // count 회 수 이상 했으면,
            categoryIdx: $categoryIdx,
        );
//        d("결과: $re, 회수: " . $this->getCategoryHourLimitCount($categoryIdx));
        return $re;
    }

    /**
     * 카테고리 별 일/수, 글/코멘트 쓰기 제한에 걸렸으면 true 를 리턴한다.
     * @param int $categoryIdx
     * @return bool
     */
    public function categoryDailyLimit(int $categoryIdx): bool {
//        d("categoryDailyLimit(int $categoryIdx)");
        // 추천/비추천 일/수 제한

        return $this->countOver(
            reasons: [ POINT_POST_CREATE, POINT_COMMENT_CREATE ], // 글/코멘트 작성을
            stamp: time() - mktime(0, 0, 0, date('m'), date('d'), date('Y')), // 하루에 몇번. 주의: 정확히는 0시 0분 0초 부터 현재 시점까지이다. README.md# 포인트 참고
            count: intval($this->getCategoryDailyLimitCount($categoryIdx)), // count 회 수 이상 했으면,
            categoryIdx: $categoryIdx
        );
    }

    /**
     * 포인트 기록 테이블에서 $stamp 시간 내에 $reason 들을 찾아 그 수가 $count 보다 많으면 true 를 리턴한다.
     *
     * 예를 들어,
     *   - 추천/비추천을 1시간 이내에 5번으로 제한을 하려고 할 때,
     *   - 글 쓰기를 하루에 몇번으로 제한 할 때 등에 사용 할 수 있다.
     *
     * @param array $reasons
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
    function countOver(array $reasons, int $stamp, int $count, $fromUserIdx=0, int $categoryIdx=0): bool {
        if ( $count ) {
//            d("countOver: $categoryIdx");
            $total = $this->countReasons( stamp: $stamp, reasons: $reasons, fromUserIdx: $fromUserIdx, categoryIdx: $categoryIdx );
            if ( $total >= $count ) {
                return true;
            }
        }
        return false;
    }


    /**
     * 포인트 기록 테이블에서, $stamp 시간 내의 입력된 $actions 의 레코드를 수를 찾아 리턴한다.
     *
     * 주의, 추천/비추천과 같이 행동을 하는(포인트를 주는) 주체가 나 인경우, fromUser 에서 제한한다.
     * 그 외(가입, 로그인 글 쓰기)는 toUser 에서 제한한다.
     * 이 때에는 $fromUserIdx 에 값이 들어와야 한다.
     *
     * @param $stamp
     * @param array $reasons
     * @param int $fromUserIdx - 만약 fromUserIdx 가 지정되지 않으면, 로그인한 사용자의 idx 를 toUserIdx 로 사용한다.
     * @param int $categoryIdx
     * @return int|string|null
     */
    function countReasons($stamp, $reasons, int $fromUserIdx=0, int $categoryIdx=0): int|string|null
    {
        if ( ! $stamp ) return 0;
        $reason_ors = "(" . sqlCondition($reasons, 'OR', REASON) . ")";

        $q_categoryIdx = '';
        if ( $categoryIdx ) $q_categoryIdx = "AND categoryIdx=$categoryIdx";

        $last_stamp = time() - $stamp;
        if ( $fromUserIdx ) {
            $user = "fromUserIdx=$fromUserIdx";
        } else {
            $user = "toUserIdx=" . login()->idx;
        }

        $q = "SELECT COUNT(*) FROM ".entity(POINT_HISTORIES)->getTable()." WHERE createdAt > $last_stamp AND $user $q_categoryIdx AND $reason_ors";
//        d($q);
        if ( isDebugging() ) d( $q );
        return db()->get_var($q);
    }



    public function vote(PostTaxonomy $post, $Yn) {

        // 내 글/코멘트이면 리턴. 내 글/코멘트에 추천하는 경우, 포인트 증감 없으며, 포인트 기록도 하지 않는다.
        if ( $post->isMine() ) return;

        $limit = false;
        // 추천/비추천 시간/수 제한
        if ( $re = point()->countOver(
            [ POINT_LIKE, POINT_DISLIKE ], // 추천/비추천을
            point()->getLikeHourLimit() * 60 * 60, // 특정 시간에, 시간 단위 이므로 * 60 * 60 을 하여 초로 변경.
            point()->getLikeHourLimitCount(), // count 회 수 이상 했으면,
            fromUserIdx: login()->idx,
        ) ) {
            // 제한에 걸렸다.
            // 추천/비추천에서는 에러를 리턴 할 필요 없이 그냥 계속 한다.
            $limit = true;
        }


        // 추천/비추천 일/수 제한
        if ( $re = point()->countOver(
            [ POINT_LIKE, POINT_DISLIKE ], // 추천/비추천을
            24 * 60 * 60, // 하루에
            point()->getLikeDailyLimitCount(), // count 회 수 이상 했으면,
            login()->idx,
        ) ) {
            // 제한에 걸렸다.
            // 무시하고 계속
            $limit = true;
        }

        // 제한에 안 걸렸으면, 포인트 증/감.
        if ( $limit == false ) {
            $fromUserPointApply = $this->addUserPoint(login()->idx, $Yn == 'Y' ? $this->getLikeDeduction() : $this->getDislikeDeduction());
            $toUserPointApply = $this->addUserPoint($post->userIdx, $Yn == 'Y' ? $this->getLike() : $this->getDislike() );
            $myPoint = login()->getPoint();
            $toUserIdx = $post->userIdx;
//                d("{$post->idx} : $Yn, toUserIdx: $toUserIdx, userIdx: " . $post->value(USER_IDX) . ", myIdx: " . my(IDX) . ", myPoint: $myPoint, fromuserPointApply: $fromUserPointApply, toUserPointApply: $toUserPointApply\n");
            $this->log(
                $Yn== 'Y' ? POINT_LIKE : POINT_DISLIKE,
                toUserIdx: $post->userIdx,
                fromUserIdx: login()->idx,
                toUserPointApply: $toUserPointApply,
                fromUserPointApply: $fromUserPointApply,
            );
        }
    }

    /**
     * 사용자 포인트를 이동한다.
     *
     * @param int $fromUserIdx
     * @param int $toUserIdx
     * @param int $postIdx
     * @param int $point
     * @return int
     * - 실패시, 0을 리턴한다. 이 때, $fromUserIdx 의 포인트가 차감되었을 가능성이 있음.
     * - 성공시, log 번호를 리턴한다.
     */
    public function move(int $fromUserIdx, int $toUserIdx, int $postIdx, int $point): int {
        $fromUserPointApply = $this->addUserPoint($fromUserIdx, -$point);
        if ( $point != abs($fromUserPointApply) ) return 0;
        $toUserPointApply = $this->addUserPoint($toUserIdx, $point);
        return $this->log(
            POINT_STAR,
            toUserIdx: $toUserIdx,
            fromUserIdx: $fromUserIdx,
            toUserPointApply: $toUserPointApply,
            fromUserPointApply: $fromUserPointApply,
            taxonomy: POSTS,
            entity: $postIdx,
        );
    }


}





/**
 * Returns Point instance.
 *
 *
 * @return Point
 */
function point(): Point
{
    return new Point();
}

