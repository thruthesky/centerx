<?php


$o = getWidgetOptions();

/**
 * @var File[] $files
 */
$files =  $o['files'];

?>

<?php foreach ($post->files() as $file) { ?>
    <img class="w-100" src="<?= $file->url ?>" />
<?php } ?>