<?php

class PointRoute {

    /**
     * 해당 글 또는 코멘트를 생성할 때 획득한 포인트를 리턴한다.
     */
    public function postCreate($in) {
        if ( post($in[IDX])->parentIdx ) $reason = POINT_COMMENT_CREATE;
        else $reason = POINT_POST_CREATE;

        return ['point' => pointHistory()->last(POSTS, $in[IDX], $reason)->toUserPointApply];
    }



    /**
     * 포인트 이동 기능
     *
     * 별쏘기, 추천 등에 사용.
     *
     * 상대방을 추천할 때, 자기 포인트를 깍은 만큼, 상대방의 포인트를 추가할 때 사용한다.
     * 글/코멘트 추천 기능과 유사하나, 사용자가 클라이언트에서 직접 포인트를 선택할 수 있고, 또 그 만큼 자신의 포인트를 깍아 상대방의 포인트로 추가해주는 것이 다르다.
     *
     * @todo 현재는 글/코멘트 번호를 입력 받는데, 사용자 번호 만으로도 포인트를 이동 할 수 있도록 할 것.
     *
     * @param array $in
     *  - $in['postIdx'] - 글 또는 코멘트 번호.
     */
    public function move(array $in): array|string {
        $postIdx = $in['postIdx'] ?? null;
        $point = $in['point'] ?? 0;

        $loginUser = login();

        if ( ! $postIdx ) return e()->empty_post_idx;
        if ( ! $point ) return e()->empty_point;
        if ( $point < 0 ) return e()->point_must_be_bigger_than_0;

        if ( notLoggedIn() ) return e()->not_logged_in;

        $post = post($postIdx);
        if ( $post->hasError ) return e()->post_not_exists;

        if ( $post->userIdx == 0 ) return e()->user_not_found;

        $toUser = user($post->userIdx);
        if ( $toUser->hasError ) return e()->user_not_found;

        if ( $loginUser->idx == $toUser->idx ) return e()->point_move_for_same_user;


        $userPoint = $loginUser->getPoint();
        if ( is_numeric($userPoint) == false ) {
            return $loginUser->getError();
        }

        if ( $userPoint < $point ) return e()->lack_of_point;
        $logIdx = point()->move(
            fromUserIdx: $loginUser->idx,
            toUserIdx: post($postIdx)->userIdx,
            postIdx: $postIdx,
            point: $point,
        );
        return ['logIdx' => $logIdx];
    }





}