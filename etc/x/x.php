<?php
/**
 * @file x.php
 */
/**
 * @see readme
 */
include '/docker/home/centerx/boot.php';


if ( $argv[1] == 'post' ) {
    if ( $argv[2] == 'create' ) {
        _post_create(_matrix_path($argv[3] ?? 'etc/res/forum/sample.php'));
    }
}

