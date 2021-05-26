<?php
/**
 * @param $ad_type
 * @param null $place - null 이면, 기본적으로 전체 place 를 모두 사용한다.
 * @return string
 */
function advSql($ad_type, $place = null):string {
    $today = \Carbon\Carbon::today()->getTimestamp();
    $file_table = fileTable();
    $post_table = postTable();
    $meta_table = metaTable();

    $q_place = '';
    if ( $place !== null ) {
        $q_place = "AND m.data = '$place'";
    }

    return "SELECT f.idx fileIdx, f.code, p.idx postIdx
            FROM $file_table f, $post_table p, $meta_table m
            WHERE f.code = '$ad_type' AND f.entity = p.idx AND p.endAt >= $today AND p.deletedAt = 0
                AND p.idx = m.entity AND m.code = '$ad_type' $q_place
            ORDER BY p.listOrder DESC";
}

