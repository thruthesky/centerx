<?php

class UserActivityController {

    /**
     * @param $in
     * @return array|string
     */
    public function search($in): array|string
    {
        if (notLoggedIn()) return e()->not_logged_in;
        if (!admin()) return e()->you_are_not_admin;

        $histories = userActivity()->search(
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

    public function list($in): array | string
    {

        if (notLoggedIn()) return e()->not_logged_in;
        if (!admin()) return e()->you_are_not_admin;

        $sql = [];
        $params = [];
        if ( isset($in[IDX]) && !empty($in[IDX])) {
            $sql[] = "((fromUserIdx=? AND fromUserPointApply<>0) OR (toUserIdx=? AND toUserPointApply<>0))";
            $params[] = $in[IDX];
            $params[] = $in[IDX];
        } else {
            $sql[] = "(fromUserPointApply<>0 OR toUserPointApply<>0)";
        }

        $in = post()->updateBeginEndDate($in);
        $endAt = $in[END_AT] + (60 * 60 * 24) - 1;
        $sql[] = "(createdAt >=? AND createdAt <=?)";
        $params[] =  $in[BEGIN_AT];
        $params[] =  $endAt;
        $q = implode(' AND ', $sql);

        $limit = $in['limit'] ?? 1000;
        $histories = userActivity()->search( select: '*', where: $q, params: $params, limit: $limit);

        $rets = [];
        foreach($histories as $history) {
            if ( isset($history ['fromUserIdx']) ) {
                $history['fromUser'] = user($history['fromUserIdx'])->shortProfile();
            }
            if ( isset($history['toUserIdx']) ) {
                $history['toUser'] = user($history['toUserIdx'])->shortProfile();
            }

            if ( isset($history[CATEGORY_IDX]) ) {
                $history[CATEGORY_ID] = category($history[CATEGORY_IDX])->id;
            }
            $rets[] = $history;
        }
        return $rets;
    }

}