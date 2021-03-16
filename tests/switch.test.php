<?php

setLoginAny();
$user = login()->switch('d');
isTrue($user->v('d') == 'on', 'A Switched On');


$user = login()->switch('d');
isTrue( $user->v('d') == 'off', 'A Switched On');


login()->switchOn('hello');
isTrue( login()->v('hello') == 'on', 'Hello should Switched On. But: ' . login()->v('hello'));


login()->switchOff('hello');
isTrue( login()->v('hello') == 'off', 'Hello Switched Off');



$posts = post()->search(limit: 1);
$post = $posts[0];

$post->switch('reminder');
isTrue($post->v('reminder') == 'on', 'The post is set to on - reminder');

$post->switch('reminder');
isTrue($post->v('reminder') == 'off', 'The post is set to off - reminder');


