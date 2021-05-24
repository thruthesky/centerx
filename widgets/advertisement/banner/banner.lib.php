<?php
function advSql($ad_type, $place):string {
    $today = \Carbon\Carbon::today()->getTimestamp();
    $file_table = fileTable();
    $post_table = postTable();
    $meta_table = metaTable();
    return "SELECT f.idx fileIdx, f.code, p.idx postIdx
            FROM $file_table f, $post_table p, $meta_table m
            WHERE f.code = '$ad_type' AND f.entity = p.idx AND p.endAt >= $today AND p.deletedAt = 0
                AND p.idx = m.entity AND m.code = '$ad_type' AND m.data = '$place'
            ORDER BY p.listOrder DESC";
}

