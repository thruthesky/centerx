<?php

class SearchKeyRoute {
    public function stats($in) {
        $table = DB_PREFIX . 'search_keys';



        if ( !isset($in['days']) || !$in['days'] ) $in['days'] = 7;

        $stamp_days_ago = time() - $in['days'] * 24 * 60 * 60;




        $q = "SELECT searchKey, COUNT(*) as cnt from $table WHERE createdAt > $stamp_days_ago GROUP BY searchKey ORDER BY cnt DESC, searchKey ASC";
        debug_log($q);
        $rows = db()->get_results($q, ARRAY_A);
        $rets = [];
        foreach( $rows as $row ) {
            $rets[$row['searchKey']] = $row['cnt'];
        }
        return $rets;
    }
}