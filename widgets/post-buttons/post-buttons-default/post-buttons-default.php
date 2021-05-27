<?php
$o = getWidgetOptions();
$post = $o['post'];
?>

<div class="d-flex align-items-center buttons mt-2">
  <div class="d-flex">
    <vote-buttons parent-idx="<?= $post->idx ?>" y="<?= $post->Y ?>" n="<?= $post->N ?>" text-like="<?= ln('like') ?>" text-dislike="<?= ln('dislike') ?>"></vote-buttons>
    <?php if ($post->isMine() == false) { ?><a class="btn btn-sm mr-2" href="<?= messageSendUrl($post->userIdx) ?>"><?= ln('send_message') ?></a><?php } ?>
  </div>
  <span class="flex-grow-1"></span>


  <?php if (in('p') !== 'forum.post.list') { ?>
    <a class="btn btn-sm mr-1" href="/?p=forum.post.list&categoryId=<?= $post->categoryId() ?>"><?= ln('list') ?></a>
  <?php } ?>



    <?=hook()->run('post-buttons-right-side', $post)?>



  <?php if ($post->isMine() || admin()) { ?>
    <b-dropdown size="lg" variant="link" toggle-class="text-decoration-none" right no-caret>
      <template #button-content>
        <i class="fa fa-ellipsis-h dark fs-md"></i><span class="sr-only">Search</span>
      </template>
      <b-dropdown-item href="<?= postEditUrl(postIdx: $post->idx) ?>"><?= ln('edit') ?></b-dropdown-item>
      <b-dropdown-item href="<?= postDeleteUrl($post->idx) ?>" onclick="return confirm('<?= ln('confirm_delete') ?>')">
        <div class="red"><?= ln('delete') ?></div>
      </b-dropdown-item>
      <?php if (admin()) { ?>
        <b-dropdown-divider></b-dropdown-divider>
        <b-dropdown-group id="dropdown-group-1" header="Admin">
          <b-dropdown-item href="<?= postMessagingUrl($post->idx) ?>"><?= ln('admin push') ?></b-dropdown-item>
        </b-dropdown-group>
      <?php } ?>
    </b-dropdown>
  <?php } ?>
</div>