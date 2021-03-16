<?php


$category = category('test');
if ( $category->exists() == false ) {
    $category = category()->create([ID => 'test']);
}
setLoginAny();
$created = post()->create([CATEGORY_ID => 'test', TITLE=>'hi']);
$post = post($created[IDX]);
isTrue($post->title == 'hi', 'post title must be. hi');



$post->update(['eat' => 'apple pie']);
isTrue($post->eat == 'apple pie', 'Must eat apple pie');




