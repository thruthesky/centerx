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
        _post_create(_matrix_path($argv[3]));

    }
}


function _matrix_path($path) {
    return ROOT_DIR . $path;
}


function _post_create( $path ) {
    global $data;
    include $path;

    registerAndLogin();
    foreach( $data as $post ) {
        $category = category($post['category']);
        if ( $category->exists == false ) {
            d("Category: $post[category] does not exists");
            exit;
        }
        $created = createPostWithPhoto($post['category'], $post['title'], $post['content'], $post['photo']);
        if ( $created->hasError ) {
            d("Error: Category: $post[category], " . $created->getError() );
            exit;
        }
        if ( isset($post['comments']) ) {
            foreach( $post['comments'] as $comment ) {
                comment()->create([ ROOT_IDX => $created->idx, CONTENT => $comment[CONTENT] ]);
            }
        }
    }
}