<?php
/**
 * @file user_activity.model.php
 */
/**
 * Class UserActivityModel
 *
 * @see readme.md
 *
 * @property-read int $fromUserIdx
 * @property-read int $toUserIdx
 * @property-read string $action
 * @property-read string $taxonomy
 * @property-read int $entity
 * @property-read int categoryIdx
 * @property-read int fromUserPointApply
 * @property-read int fromUserPointAfter
 * @property-read int toUserPointApply
 * @property-read int toUserPointAfter
 * @property-read int createdAt
 * @property-read int updatedAt
 */
class UserActivityModel extends UserActivityBase {




    public function __construct(int $idx)
    {
        parent::__construct(USER_ACTIVITIES, $idx);
    }

    /**
     * Check if the user can create a post.
     *
     * Checks on
     *  - limit by daily/hourly
     *  - lack of point
     *
     * @param CategoryModel $category
     * @return $this
     */
    public function canCreatePost(CategoryModel $category ): self {
        return $this->canCreateForumRecord($category, Actions::$createPost);
    }

    public function canCreateComment(CategoryModel $category ):self {
        return $this->canCreateForumRecord($category, Actions::$createComment);
    }

    /**
     * Check if the user has permission on post read.
     *
     * Note, if the app is showing posts from multiple categories (like, when the app shows latest posts to user),
     *  Some of the posts may have permission error. So, it is important to know when to show what posts to user based
     *  on the permission rule.
     *
     * Note, admin can read all posts without limitation.
     *
     * @param int $categoryIdx
     * @return $this
     */
    public function canRead(int $categoryIdx): self {
        if ( admin() ) return $this; // admin can read without limit.
        $pointToRead = userActivity()->getReadLimitPoint($categoryIdx);
        if ( $pointToRead ) {
            if ( notLoggedIn() ) return $this->error(e()->not_logged_in);
            if (  login()->getPoint() < $pointToRead ) {
                return $this->error(e()->lack_of_point_possession_limit);
            }
        }
        return $this;
    }


    /**
     * Check if the login user can create a post or a comment.
     *
     * @참고, 여기서는 글/코멘트 작성을 통해 포인트 충전이 가능한지 아닌지를 검사하는 것이 아니라, 글/코멘트 쓰기가 가능한지 아닌지를 검사한다.
     * 즉, 포인트가 증가하지 않아도, 글 쓰기가 가능하면, 참을 리턴한다.
     *
     * @param CategoryModel $category
     * @param string $activity
     * @return $this
     *  - If there is an error, 'error code' will be set to the object.
     *  - No error, no error code will be set to the object.
     */
    private function canCreateForumRecord(CategoryModel $category, string $activity) : self {
        // If banned(limited for creating), return an error. error on limit.
        if ( $this->isCategoryBanOnLimit($category->idx) ) {
            $re = userActivity()->checkCategoryCreateLimit($category->idx);
            if ( $re ) return $this->error($re);
        }

        // If the point is set to decrease in writing/comment writing, if the points are insufficient, an error
        if ($activity == Actions::$createPost ) $pointToCreate = userActivity()->getPostCreatePoint($category->idx);
        else if($activity == Actions::$createComment ) $pointToCreate = userActivity()->getCommentCreatePoint($category->idx);
        else {
            return $this->error(e()->wrong_activity);
        }

        /// 포인트가 음수 값이면, 글/코멘트 생성시 포인트를 감소하는 것.
        if ( $pointToCreate < 0 ) {
            /// 감소하는(될) 포인트 보다, 보유하고 있는 포인트가 더 적으면 에러,
            if ( login()->getPoint() < abs( $pointToCreate ) ) {
                return $this->error(e()->lack_of_point); //
            }
        }



        // 회원이 보유한 포인트를 바탕으로 글/코멘트 쓰기 검사
        // 예를 들어, 설정에서 1만으로 해 놓았으면, 사용자의 포인트가 1만 이상이어야지만, 글/코멘트 쓰기가 가능하다.
        // Set error if the user's point is less than the point of 'postCreateLimit' or 'commentCreateLimit'.
        if ($activity == Actions::$createPost ) $pointToCreate = userActivity()->getPostCreateLimitPoint($category->idx);
        else if($activity == Actions::$createComment ) $pointToCreate = userActivity()->getCommentCreateLimitPoint($category->idx);
        else {
            return $this->error(e()->wrong_activity);
        }
        if ( $pointToCreate ) {
            if (  login()->getPoint() < $pointToCreate ) {
                return $this->error(e()->lack_of_point_possession_limit);
            }
        }
        return $this;
    }

    /**
     * @param UserModel $user
     * @return self
     *  - error code string if there is an error.
     *  - user.idx if success.
     */
    public function register(UserModel $user) : self {
        return $this->recordAction(
            action: Actions::$register,
            fromUserIdx: 0,
            fromUserPoint: 0,
            toUserIdx: $user->idx,
            toUserPoint: $this->getRegisterPoint(),
            taxonomy: $user->taxonomy,
            entity: $user->idx
        );
    }

    /**
     * @param UserModel $user
     * @return $this
     */
    public function login(UserModel $user): self {
        return $this->recordAction(
            action: Actions::$login,
            fromUserIdx: 0,
            fromUserPoint: 0,
            toUserIdx: $user->idx,
            toUserPoint: $this->getLoginPoint(),
            taxonomy: $user->taxonomy,
            entity: $user->idx
        );
    }


    /**
     * User votes on post ( or any taxonomy that users posts table ).
     * @param Forum $forum
     * @param string $Yn
     */
    public function vote(Forum $forum, string $Yn): self {
        $actions = [ Actions::$like, Actions::$dislike ];


        $limit = false;
        // Check hourly limit. 추천/비추천 시간/수 제한
        if ( $re = $this->countOver(
            $actions, // check action for like and dislike. 추천/비추천을
            userActivity()->getLikeHourLimit() * 60 * 60, // for how many hours? 특정 시간에, 시간 단위 이므로 * 60 * 60 을 하여 초로 변경.
            userActivity()->getLikeHourLimitCount(), // for how many actions? count 회 수 이상 했으면,
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
            userActivity()->getLikeDailyLimitCount(), // count 회 수 이상 했으면,
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

        return $this->recordAction(
            $action,
            fromUserIdx: login()->idx,
            fromUserPoint: $fromUserPoint,
            toUserIdx: $forum->userIdx,
            toUserPoint: $toUserPoint,
            taxonomy: $forum->taxonomy,
            entity: $forum->idx,
            categoryIdx: $forum->categoryIdx
        );



    }

    /**
     * Record action and change point for post creation
     *
     * Limitation check must be done before calling this method.
     *
     * @param PostModel $post
     * @return UserActivityModel
     */
    public function createPost(PostModel $post):  self {


        /// 글 포인트 증가 제한에 걸렸는지 확인,
        /// 참고, ban 옵션에 걸렸으면, 글 쓰기 자체를 못하지만, ban 옵션이 걸리지 않았으면, 포인트 증가는 안되어도 글은 계속 쓸 수 있다.
        /// 이 때, 로그를 남겨야 한다.
        $re = userActivity()->checkCategoryCreateLimit($post->categoryIdx);
        if ( $re ) {
            /// 제한에 걸렸으면, 포인트는 0.
            $point = 0;
        } else {
            /// 아니면, 포인트 증/감.
            $point = $this->getPostCreatePoint($post->categoryIdx);
        }


        return $this->recordAction(
            Actions::$createPost,
            fromUserIdx: 0,
            fromUserPoint: 0,
            toUserIdx: login()->idx,
            toUserPoint: $point,
            taxonomy: $post->taxonomy,
            entity: $post->idx,
            categoryIdx: $post->categoryIdx
        );
    }

    /**
     * Record action and change point for post delete
     * @param PostModel $post
     * @return UserActivityModel
     */
    public function deletePost(PostModel $post): self {

        return $this->recordAction(
            Actions::$deletePost,
            fromUserIdx: 0,
            fromUserPoint: 0,
            toUserIdx: login()->idx,
            toUserPoint: $this->getPostdeletePoint($post->categoryIdx),
            taxonomy: $post->taxonomy,
            entity: $post->idx,
            categoryIdx: $post->categoryIdx
        );
    }


    /**
     * Record action and change point for comment creation
     *
     * Limitation check must be done before calling this method.
     * @param CommentModel $comment
     * @return UserActivityModel
     */
    public function createComment(CommentModel $comment):self {

        /// 글 포인트 증가 제한에 걸렸는지 확인,
        /// 참고, ban 옵션에 걸렸으면, 글 쓰기 자체를 못하지만, ban 옵션이 걸리지 않았으면, 포인트 증가는 안되어도 글은 계속 쓸 수 있다.
        /// 이 때, 로그를 남겨야 한다.
        $re = userActivity()->checkCategoryCreateLimit($comment->categoryIdx);
        if ( $re ) {
            /// 제한에 걸렸으면, 포인트는 0.
            $point = 0;
        } else {
            /// 아니면, 포인트 증/감.
            $point = $this->getCommentCreatePoint($comment->categoryIdx);
        }



        return $this->recordAction(
            Actions::$createComment,
            fromUserIdx: 0,
            fromUserPoint: 0,
            toUserIdx: login()->idx,
            toUserPoint: $point,
            taxonomy: $comment->taxonomy,
            entity: $comment->idx,
            categoryIdx: $comment->categoryIdx
        );
    }

    /**
     * Record action and change point for comment creation
     *
     * Limitation check must be done before calling this method.
     * @param CommentModel $comment
     * @return UserActivityModel
     */
    public function deleteComment(CommentModel $comment): self {
        return $this->recordAction(
            Actions::$deleteComment,
            fromUserIdx: 0,
            fromUserPoint: 0,
            toUserIdx: login()->idx,
            toUserPoint: $this->getCommentDeletePoint($comment->categoryIdx),
            taxonomy: $comment->taxonomy,
            entity: $comment->idx,
            categoryIdx: $comment->categoryIdx
        );
    }


    /**
     * Return false on success. Or error code if the user reached on limit.
     *
     *
     * @참고, "게시판 글/코멘트 작성 포인트 증가" 제한에 걸렸으면 에러 문자열을 리턴한다. 제한에 걸리지 않았으면 false 를 리턴한다.
     * @참고, "게시판 글/코멘트 작성 포인트 증가" 제한 옵션은 카테고리에 적용하는 것으로 "글/코멘트" 합산해서 회수를 계산한다.
     *
     * @param int $categoryIdx
     * @return false|string
     */
    public function checkCategoryCreateLimit(int $categoryIdx): bool|string
    {

        if ( $this->categoryCreateHourlyLimit($categoryIdx) ) {
//            d("categoryHourlyLimit($category) returns true");
            return e()->hourly_limit;
        }
        if ( $this->categoryCreateDailyLimit($categoryIdx) ) {
//            d("categoryDailyLimit($categoryIdx) returns true");
            return e()->daily_limit;
        }
        return false;
    }

    /**
     * 카테고리 별 글/코멘트 쓰기 제한에 걸렸으면 true 를 리턴한다.
     * @param int|string $categoryIdx
     * @return bool
     * - true error
     * - false success
     */
    public function categoryCreateHourlyLimit(int|string $categoryIdx): bool {
        $re = $this->countOver(
            actions: [ Actions::$createPost, Actions::$createComment ], // 글/코멘트 작성을
            stamp: $this->getCreateHourLimit($categoryIdx) * 60 * 60, // 특정 시간에, 시간 단위 이므로 * 60 * 60 을 하여 초로 변경.
            count: $this->getCreateHourLimitCount($categoryIdx), // count 회 수 이상 했으면,
            categoryIdx: $categoryIdx,
        );
//         d("결과: $re, 회수: " . $this->getCategoryHourLimitCount($categoryIdx));
        return $re;
    }

    /**
     * 카테고리 별 일/수, 글/코멘트 쓰기 제한에 걸렸으면 true 를 리턴한다.
     * @param int $categoryIdx
     * @return bool
     */
    public function categoryCreateDailyLimit(int $categoryIdx): bool {
        // d("categoryDailyLimit(int $categoryIdx)");
        // 추천/비추천 일/수 제한
        return $this->countOver(
            actions: [ Actions::$createPost, Actions::$createComment ], // 글/코멘트 작성을
            stamp: time() - mktime(0, 0, 0, date('m'), date('d'), date('Y')), // 하루에 몇번. 주의: 정확히는 0시 0분 0초 부터 현재 시점까지이다. README.md# 포인트 참고
            count: $this->getCreateDailyLimitCount($categoryIdx), // count 회 수 이상 했으면,
            categoryIdx: $categoryIdx
        );
    }


    /**
     * Returns the last history based on the input.
     *
     * point history 테이블에서 taxonomy, entity, reason 에 맞는 마지막 기록 1개를 리턴한다.
     *
     * - 예제) 마지막 기록을 가져와서, 포인트 기록이 된 시간을 24시간 이전으로 수정한다.
     * ```php
     * $ph = pointHistory()->last(POSTS, $post1->idx, POINT_POST_CREATE);
     * $ph->update([CREATED_AT => $ph->createdAt - (60 * 60 * 24)]);
     * ```
     *
     * @param string $taxonomy
     * @param int $entity
     * @param string $action
     * @return self
     */
    public function last(string $taxonomy, int $entity, string $action=''): self {
        $conds = [ TAXONOMY => $taxonomy, ENTITY => $entity ];
        if ( $action ) $conds['action'] = $action;

        $histories = $this->search(conds: $conds, limit: 1, object: true);
        if ( count($histories) ) return userActivity($histories[0]->idx);
        return userActivity();
    }

}




/**
 * @attention This method must return new object every time, for clearing the previous error message(or not to keep previous error message into new action)
 *
 * @param int $idx
 * @return UserActivityModel
 */
function userActivity(int $idx=0): UserActivityModel {
    return new UserActivityModel($idx);
}

/**
 * @deprecated Use `userActivity()` instead.
 * @param int $idx
 * @return UserActivityModel
 */
function act(int $idx=0): UserActivityModel
{
    return userActivity($idx);
}
