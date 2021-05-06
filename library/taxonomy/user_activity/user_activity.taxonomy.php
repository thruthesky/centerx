<?php
/**
 * @file user_activity.php
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
class UserActivityTaxonomy extends UserActivityBase {




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
     * @param CategoryTaxonomy $category
     * @return $this
     */
    public function canCreatePost(CategoryTaxonomy $category ): self {
        // 제한에 걸렸으면, 에러 리턴. error on limit.
        if ( $this->isCategoryBanOnLimit($category->idx) ) {
            $re = act()->checkCategoryLimit($category->idx);
            if ( $re ) return $this->error($re);
//            if ( isError($re) ) return $this->error($re);
        }

        // 글/코멘트 쓰기에서 포인트 감소하도록 설정한 경우, 포인트가 모자라면, 에러. error if user is lack of point.
        $pointToCreate = act()->getPostCreatePoint($category->idx);
        if ( $pointToCreate < 0 ) { // point deduction is set on category?
            if ( login()->getPoint() < abs( $pointToCreate ) ) { // user does not have enough point?
                return $this->error(e()->lack_of_point); //
            }
        }

        // @todo if user is banned by the amount of point possession.
        return $this;
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
            act()->getLikeHourLimit() * 60 * 60, // for how many hours? 특정 시간에, 시간 단위 이므로 * 60 * 60 을 하여 초로 변경.
            act()->getLikeHourLimitCount(), // for how many actions? count 회 수 이상 했으면,
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
            act()->getLikeDailyLimitCount(), // count 회 수 이상 했으면,
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

    /**
     * Record action and change point for post creation
     *
     * Limitation check must be done before calling this method.
     * @param CategoryTaxonomy $category
     * @param PostTaxonomy $post
     */
    public function createPost(CategoryTaxonomy $category, PostTaxonomy $post) {
        $this->recordAction(
            Actions::$createPost,
            fromUserIdx: 0,
            fromUserPoint: 0,
            toUserIdx: login()->idx,
            toUserPoint: $this->getPostCreatePoint($category->idx),
            taxonomy: $post->taxonomy,
            entity: $post->idx,
            categoryIdx: $category->idx
        );
    }

    /**
     * Record action and change point for post delete
     * @param CategoryTaxonomy $category
     * @param PostTaxonomy $post
     */
    public function deletePost(CategoryTaxonomy $category, PostTaxonomy $post) {

        $this->recordAction(
            Actions::$deletePost,
            fromUserIdx: 0,
            fromUserPoint: 0,
            toUserIdx: login()->idx,
            toUserPoint: $this->getPostdeletePoint($category->idx),
            taxonomy: $post->taxonomy,
            entity: $post->idx,
            categoryIdx: $category->idx
        );
    }


    /**
     * Return false on success. Or error code if the user reached on limit.
     *
     *
     * 게시판 글/코멘트 쓰기 제한에 걸렸으면 에러 문자열을 리턴한다. 제한에 걸리지 않았으면 false 를 리턴한다.
     * @param int|string $category
     * @return false|string
     */
    public function checkCategoryLimit(int|string $category): bool|string
    {
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
            actions: [ Actions::$createPost, Actions::$createComment ], // 글/코멘트 작성을
            stamp: $this->getCategoryHourLimit($categoryIdx) * 60 * 60, // 특정 시간에, 시간 단위 이므로 * 60 * 60 을 하여 초로 변경.
            count: $this->getCategoryHourLimitCount($categoryIdx), // count 회 수 이상 했으면,
            categoryIdx: $categoryIdx,
        );
        // d("결과: $re, 회수: " . $this->getCategoryHourLimitCount($categoryIdx));
        return $re;
    }

    /**
     * 카테고리 별 일/수, 글/코멘트 쓰기 제한에 걸렸으면 true 를 리턴한다.
     * @param int $categoryIdx
     * @return bool
     */
    public function categoryDailyLimit(int $categoryIdx): bool {
        // d("categoryDailyLimit(int $categoryIdx)");
        // 추천/비추천 일/수 제한
        return $this->countOver(
            actions: [ Actions::$createPost, Actions::$createComment ], // 글/코멘트 작성을
            stamp: time() - mktime(0, 0, 0, date('m'), date('d'), date('Y')), // 하루에 몇번. 주의: 정확히는 0시 0분 0초 부터 현재 시점까지이다. README.md# 포인트 참고
            count: $this->getCategoryDailyLimitCount($categoryIdx), // count 회 수 이상 했으면,
            categoryIdx: $categoryIdx
        );
    }


    /**
     * Returns last history.
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
     * @return UserActivityTaxonomy
     */
    public function last(string $taxonomy, int $entity, string $action=''): UserActivityTaxonomy {
        $conds = [ TAXONOMY => $taxonomy, ENTITY => $entity ];
        if ( $action ) $conds['action'] = $action;

        $histories = $this->search(conds: $conds, limit: 1, object: true);
        if ( count($histories) ) return act($histories[0]->idx);
        return act();
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

