<?php


$o = getWidgetOptions();

/**
 * @var File[] $files
 */
$files =  $o['files'];

if (count($files)) { ?>

    <div class="container photos">
        <div class="row">
            <?php
            if (count($files) > 1) {
                foreach ($files as $file) { ?>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 p-0">
                        <img class="w-100" src="<?= $file->url ?>">
                    </div>
                <?php }
            } else { ?>
                <img class="w-100" src="<?= $files[0]->url ?>" />
            <?php } ?>
        </div>
    </div>

<?php } ?>