<?php
/**
 * @file user_activity.php
 * @see readme.md
 */


class UserActivityTaxonomy extends UserActivityBase {

    public string $createPost = 'createPost';



    public function __construct(int $idx)
    {
        parent::__construct(USER_ACTIVITIES, $idx);
    }

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
            toUserIdx: $user->idx,
            toUserPoint: $this->getRegisterPoint()
        );
    }

    public function login(UserTaxonomy $user): int|string {
        return $this->recordAction(
            action: Actions::$login,
            fromUserIdx: 0,
            fromUserPoint: 0,
            toUserIdx: $user->idx,
            toUserPoint: $this->getLoginPoint()
        );
    }


    /**
     * User votes on post ( or any taxonomy that users posts table ).
     * @param Forum $forum
     * @param string $Yn
     */
    public function vote(Forum $forum, string $Yn) {



        $actions = [ Actions::$like, Actions::$dislike ];


        $limit = false;
        // Check hourly limit. 추천/비추천 시간/수 제한
        if ( $re = $this->countOver(
            $actions, // check action for like and dislike. 추천/비추천을
            point()->getLikeHourLimit() * 60 * 60, // for how many hours? 특정 시간에, 시간 단위 이므로 * 60 * 60 을 하여 초로 변경.
            point()->getLikeHourLimitCount(), // for how many actions? count 회 수 이상 했으면,
            fromUserIdx: login()->idx, // for the login user
        ) ) {
            // Limitation reached.
            // 제한에 걸렸다.
            // 추천/비추천에서는 에러를 리턴 할 필요 없이 그냥 계속 한다.
            $limit = true;
        }


        // 추천/비추천 일/수 제한
        if ( $re = $this->countOver(
            $actions, // 추천/비추천을
            24 * 60 * 60, // 하루에
            point()->getLikeDailyLimitCount(), // count 회 수 이상 했으면,
            login()->idx,
        ) ) {
            // Limitation reached.
            // 제한에 걸렸다.
            // 무시하고 계속
            $limit = true;
        }

        $action = $Yn== 'Y' ? Actions::$like : Actions::$dislike;



        if ( $forum->isMine() ) {
            // If it's my post, then don't change point.
            $fromUserPoint = 0;
            $toUserPoint = 0;
        }
        else {
            // If the limit is not yet reached. 제한에 안 걸렸으면, 포인트 증/감.
            if ( $limit == false ) {
                $fromUserPoint = $Yn == 'Y' ? $this->getLikeDeductionPoint() : $this->getDislikeDeductionPoint();
                $toUserPoint = $Yn == 'Y' ? $this->getLikePoint() : $this->getDislikePoint();
            } else {
                // If the user reached to the limit.
                $fromUserPoint = 0;
                $toUserPoint = 0;
            }
        }
        $this->recordAction(
            $action,
            fromUserIdx: login()->idx,
            fromUserPoint: $fromUserPoint,
            toUserIdx: $forum->userIdx,
            toUserPoint: $toUserPoint,
        );



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

