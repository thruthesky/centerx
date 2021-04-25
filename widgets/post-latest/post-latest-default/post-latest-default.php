<?php
$o = getWidgetOptions();
$posts = post()->latest(categoryId: $o[CATEGORY_ID] ?? null, limit: $o['limit'] ?? 10);
$out = [];
foreach($posts as $post) {
    $out[] = "<a class='d-block p-1' href='{$post->url}'>{$post->title}</a>";

}
echo implode($o['separator'] ?? '', $out);

