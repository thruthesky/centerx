<?php

/**
 * @size wide
 * @options PostTaxonomy 'post'
 * @dependency none
 */

$o = getWidgetOptions();

$post = $o['post'] ?? firstPost();
if (!$post->idx) return;
?>

<div class="reminder rounded">
  <a href="<?= $post->url ?>">
    <span class="badge bg-dark rounded"><?= $post->categoryIdx ? category($post->categoryIdx)->id : 'uncategorized' ?></span>
    <span class="title"><?= $post->title ?></span>
    <span><?= $post->content ?></span>
  </a>
</div>

<style>
  .reminder {
    padding: 4px 8px;
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
    font-size: .9em;
    font-weight: bold;
    background-color: #ededed;
  }

  .reminder .badge {
    color: white;
  }

  .reminder .title {
    color: #f00000;
  }
</style>