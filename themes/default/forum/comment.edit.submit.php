<?php

$comment = comment()->create(in());
jsGo("/?p=forum.post.list&categoryId=" . comment($comment)->categoryId() );