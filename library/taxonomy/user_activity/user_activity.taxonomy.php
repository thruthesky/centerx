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

