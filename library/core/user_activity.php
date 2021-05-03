<?php
/**
 * @file user_activity.php
 * @see readme.md
 */

const CREATE_POST = 'CREATE_POST';
const CREATE_COMMENT = 'CREATE_COMMENT';
const READ_POST = 'READ_POST';



class UserActivity {

    /**
     * @param string $activity
     * @param int $categoryIdx
     * @return bool|string
     *      true on success.
     *      error code on error.
     */
    public function can(
        string $activity,
        int $categoryIdx,
    ): bool|string {

        switch ($activity) {
            case CREATE_POST :
                if ( empty($categoryIdx) ) return e()->empty_category_idx;
                $category = category($categoryIdx);

                // if user is banned by daily, hourly limit.

                // if user is banned by point change. (lack of point)

                // if user is banned by point possession.

                break;

            default :
                return e()->wrong_activity;
        }

        return true;
    }
}





$__UserActivity = null;
/**
 * @return UserActivity
 */
function act(): UserActivity
{
    global $__UserActivity;
    if ( $__UserActivity == null ) {
        $__UserActivity = new UserActivity();
    }
    return $__UserActivity;
}

