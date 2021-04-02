<?php


$o = getWidgetOptions();

/**
 * @var File[] $files
 */
$files =  $o['files'];

$fileCount = count($files);

if ($fileCount) { ?>

    <div class="container photos mt-3">
        <div class="row">
            <?php
            if ($fileCount == 1) { ?>
                <img style="border-radius: 10px;" class="w-100" src="<?= $files[0]->url ?>" />
                <?php } else if ($fileCount == 2) {
                foreach ($files as $file) { ?>
                    <div class="col-4 p-1">
                        <img style="border-radius: 10px;" class="w-100" src="<?= $file->url ?>">
                    </div>
                <?php }
            } else {
                foreach ($files as $file) { ?>
                    <div class="col-4 p-1">
                        <img style="border-radius: 10px;" class="w-100" src="<?= $file->url ?>">
                    </div>
            <?php }
            } ?>
        </div>
    </div>

<?php } ?>