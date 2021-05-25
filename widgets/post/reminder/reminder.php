<?php

/**
 * @size wide
 * @options PostTaxonomy 'post'
 * @dependency none
 */

$o = getWidgetOptions();

$post = $o['post'] ?? firstPost();
?>

<div class="reminder">
  <span class="badge"><?=category($post->categoryIdx)->id?></span>
  <span class="title"><?=$post->title?></span>
  <span><?=$post->content ?></span>
</div>

<style>
  .reminder {
    padding: 0 8px;
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
    font-weight: bold;
    background-color: #ededed;
  }

  .reminder,
  .reminder .badge {
    border-radius: 5px;
  }

  .reminder .badge {
    font-size: .8em;
    color: white;
    background-color: black;
  }

  .reminder .title {
    color: #c90000;
  }
</style>