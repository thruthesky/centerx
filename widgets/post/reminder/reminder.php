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

<div class="reminder">
  <a href="<?= $post->url ?>">
    <span class="badge"><?= $post->categoryIdx ? category($post->categoryIdx)->id : 'uncategorized' ?></span>
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

  .reminder,
  .reminder .badge {
    border-radius: 5px;
  }

  .reminder .badge {
    color: white;
    background-color: black;
  }

  .reminder .title {
    color: #f00000;
  }
</style>