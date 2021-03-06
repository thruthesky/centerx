<?php

$post = post()->create(in());

if ( isError($post) ) jsBack($post);
jsGo("/?p=forum.post.list&categoryId=" . in(CATEGORY_ID) );
