<?php


$o = getWidgetOptions();

/**
 * @var File[] $files
 */
$files =  $o['files'];

$fileCount = count($files);

if ($fileCount) { ?>
    <hr class="mb-0">
    <div class="text-muted ml-1"><small><?= ln('attached_files') ?></small></div>
    <div class="container photos" style="border-radius: 12px">
        <div class="row">
            <?php
            foreach ($files as $file) { ?>
                <!-- <div class="col-4 p-1"> -->
                    <img class="mb-1" style="border-radius: 10px; width: 100%;" class="w-100" src="<?= $file->url ?>">
                <!-- </div> -->
            <?php } ?>
        </div>
    </div>

<?php } ?>