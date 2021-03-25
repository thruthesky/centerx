<?php

class SearchKeyRoute {
    public function stats() {
        $table = DB_PREFIX . 'search_keys';
        $q = "SELECT searchKey, COUNT(*) as cnt from $table GROUP BY searchKey ORDER BY cnt DESC";
        $rows = db()->get_results($q, ARRAY_A);
        foreach( $rows as $row ) {
            $rets[$row['searchKey']] = $row['cnt'];
        }
        return $rets;
    }
}