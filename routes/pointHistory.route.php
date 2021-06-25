<?php

class PointHistoryRoute {

    /**
     * @param $in
     * @return array|string
     */
    public function search($in): array|string
    {
        /**
         * pointHistory()->search() 는 객체를 리턴하는데, 여기서 필요한 것은
         * 원하는 필드(select) 만 리턴을 하는 것이다. 그래서 필드 배열을 리턴하는, entity()->search 가 더 적합하다.
         */
        $histories = entity(POINT_HISTORIES)->search(
            select: $in['select'] ?? 'idx',
            where: $in['where'] ?? '1',
            order: $in['order'] ?? IDX,
            by: $in['by'] ?? 'DESC',
            page: $in['page'] ?? 1,
            limit: $in['limit'] ?? 10,
        );

        $rets = [];
        foreach($histories as $history) {
            if ( isset($history ['fromUserIdx']) ) {
                $history['fromUser'] = user($history['fromUserIdx'])->shortProfile();
            }
            if ( isset($history['toUserIdx']) ) {
                $history['toUser'] = user($history['toUserIdx'])->shortProfile();
            }
            if ( $history[ENTITY] ) {
                $pc = post( $history[ENTITY] );
                if ( $pc->parentIdx ) $history[TITLE] = $pc->content;
                else $history[TITLE] = post( $history[ENTITY] )->title;
            }
            $rets[] = $history;
        }
        return $rets;
    }

}