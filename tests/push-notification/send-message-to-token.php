<?php


require_once '/docker/home/centerx/boot.php';

$push = new PushNotification();

$res = $push->send(tokens: 'cEaVu9p3_rOH1BigneMGUt:APA91bFX8Xr8U6ovcF7OyR0jfd4hdtAZ9t0OUdQMoq1e62f9QpPCY87Ct82IoE5pHsl3lt8jQDSdUAbAnQhft3KVjK4_3aOyKpYiZiSMi6SCSHdOgqHPjjd5Nh8cBnqKr9iBZQBKLrbD',
    title: 'From cli #3' . time(),
    body: 'The content',
);


d($res);

