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



}