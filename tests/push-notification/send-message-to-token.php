<?php


require_once '/root/boot.php';

$push = new PushNotification();

$res = $push->send(tokens: 'fsgcfz9XU0G3my8QVbNZSd:APA91bGgNSM7csgYlaQfzxaSZCWRlQ8XK6f0wFMQFRZLRCRnIrM_Nr_jbHbayyAUv3veO6N4-Ny_XO8Aj_nn07Yv-Tb17wPEeCubqa-uxKjeZuTLXVBKpJhFaT9RNu7ZmtadM8cz4XBx',
    title: 'From cli #3' . time(),
    body: 'The content',
);


d($res);
