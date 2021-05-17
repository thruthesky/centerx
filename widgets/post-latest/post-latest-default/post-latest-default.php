<?php
/**
 * @size narrow
 * @options $categoryId, $limit
 */
$lo = getWidgetOptions();
$posts = post()->latest(categoryId: $lo[CATEGORY_ID] ?? null, limit: $lo['limit'] ?? 10);
$out = [];
$_no = 0;
foreach($posts as $post) {
    $_no ++;
    if ( isset($lo['displayNumbers']) && $lo['displayNumbers'] ) {
      $no = "<b>$_no</b> ";
    } else {
        $no = "";
    }
    $out[] = "<a class='d-block p-1' href='{$post->url}'>$no{$post->title}</a>";

}
echo implode($o['separator'] ?? '', $out);


