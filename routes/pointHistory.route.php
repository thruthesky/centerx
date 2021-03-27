<?php

class PointHistoryRoute {

    /**
     * @param $in
     * @return array|string
     */
    public function search($in): array|string
    {
        $histories = pointHistory()->search(
            select: $in['select'] ?? 'idx',
            where: $in['where'] ?? '1',
            order: $in['order'] ?? IDX,
            by: $in['by'] ?? 'DESC',
            page: $in['page'] ?? 1,
            limit: $in['limit'] ?? 10,
        );

        $rets = [];
        foreach($histories as $history) {
            if ( isset($history['fromUserIdx']) ) {
                $history['fromUser'] = user($history['fromUserIdx'])->shortProfile();
            }
            if ( isset($history['toUserIdx']) ) {
                $history['toUser'] = user($history['toUserIdx'])->shortProfile();
            }
            $rets[] = $history;
        }
        return $rets;
    }

}