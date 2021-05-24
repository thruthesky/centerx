<?php
$bo = getWidgetOptions();
$ad_type = $bo['ad_type'];

$file_table = DB_PREFIX . 'files';
$post_table = DB_PREFIX . 'posts';
$today = \Carbon\Carbon::today()->getTimestamp();



if ( $ad_type == AD_TOP ) {
    $q = "SELECT f.idx fileIdx, p.idx postIdx FROM $file_table f, $post_table p WHERE f.code = '$ad_type' AND f.entity = p.idx AND p.endAt >= $today ORDER BY p.listOrder DESC";
}
$rows = db()->rows($q);
foreach( $rows as $row ) {
    $post = post($row['postIdx']);
//    $post->files//

//    files()->getByCode();
}
