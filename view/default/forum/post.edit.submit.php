<?php
if ( in(IDX) ) {
    $post = post(in(IDX))->permissionCheck()->update(in());
    if ( $post->ok ) {
        $categoryId = $post->categoryId();
    }
}
else {
    $post = post()->create(in());
    $categoryId = in(CATEGORY_ID);
}

if ( $post->hasError ) {
    jsBack($post->getError());
}


$category = category($categoryId);

if ( $category->returnToAfterPostEdit == 'L' ) {
    $url = postListUrl($categoryId);
} else {
    if ( in(RETURN_URL) ) {
        if ( in(RETURN_URL) == 'view' ) $url = $post->url;
        else if ( in(RETURN_URL) == 'list' ) $url = postListUrl($categoryId);
        else if ( in(RETURN_URL) == 'edit' ) $url = postEditUrl(postIdx: $post->idx);
        else $url = in(RETURN_URL);
    } else {
        $url = postListUrl($categoryId);
    }
}

jsGo($url);



