<?php


require_once '/docker/home/centerx/boot.php';

$push = new PushNotification();

$res = $push->send(tokens: 'dcGPF_L7nTUIskC5WQ3yqW:APA91bFjA1OOBLBC5xDTUeuff3WteJ1Onm3k90n72CgnLw9FhMlNpBuBhr7RQ6QP_O5pL-zbxZKMdNZNPGJU0TzlmIKY_FdiAXCS5UA03qHVsMRl3bhZzxvOfBQZipFUkEtV4HMC72Fj',
    title: 'From cli #3' . time(),
    body: 'The content',
);


d($res);

