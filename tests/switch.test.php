<?php

setLoginAny();
login()->update(['d'=>'']);
login()->switch('d');
isTrue(login()->v('d') == 'Y', 'A Switched On');

login()->switch('d');
isTrue( login()->v('d') == 'N', 'A Switched On');


login()->switchOn('hello');
isTrue( login()->isOn('hello'), 'Hello should Switched On. But: ' . login()->v('hello'));


login()->switchOff('hello');
isTrue( login()->isOff('hello'), 'Hello Switched Off');


$posts = post()->search(limit: 1);
$post = post($posts[0][IDX]);

$post->update(['reminder' => '']);
isTrue($post->isNeverSwitched('reminder'), 'The post is set to on - reminder');

$post->switch('reminder');
isTrue($post->isOn('reminder'), 'The post is set to on - reminder');

$post->switch('reminder');
isTrue($post->isOff('reminder'), 'The post is set to off - reminder');


