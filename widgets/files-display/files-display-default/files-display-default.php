<?php


$o = getWidgetOptions();

/**
 * @var File[] $files
 */
$files =  $o['files'];

if (count($files)) { ?>

    <div class="container photos mt-3">
        <div class="row">
            <?php
            if (count($files) > 1) {
                foreach ($files as $file) { ?>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 p-1">
                        <img style="border-radius: 10px;" class="w-100" src="<?= $file->url ?>">
                    </div>
                <?php }
            } else { ?>
                <img style="border-radius: 10px;" class="w-100" src="<?= $files[0]->url ?>" />
            <?php } ?>
        </div>
    </div>

<?php } ?>