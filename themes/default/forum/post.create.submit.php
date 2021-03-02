<?php

$post = post()->create(in());


jsGo("/?p=forum.post.list&categoryId=" . in(CATEGORY_ID) );
