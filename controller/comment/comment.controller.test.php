<?php

$admin = setLoginAsAdmin();
$category = request("category.create", [
    'id' => 'commentTest' . time(),
    SESSION_ID => $admin->sessionId
]);

$userA = registerUser();
$userB = registerUser();

$post = request("post.create", [
    'categoryId' => $category[ID],
    TITLE => "comment controller test",
    SESSION_ID => $userA->sessionId
]);

$comment = request("comment.create", [
    SESSION_ID => $userA->sessionId,
    ROOT_IDX => $post[IDX]
]);
isTrue($comment[IDX] && $comment[ROOT_IDX] == $post[IDX], 'comment create');

$title = "updateComment" . time();
$re = request("comment.update", [
    SESSION_ID => $userA->sessionId,
    IDX=> $comment[IDX],
    TITLE => $title,
    CONTENT => "There, hello, hoare yo?"
]);
isTrue($re[TITLE] == $title, 'comment update');

$get = request("comment.get", [
    IDX=> $comment[IDX],
]);
isTrue($get[IDX] == $comment[IDX], 'comment get');

$search = request("comment.search", [
    'where' => "content LIKE ?",
    'params' => ['hello']
]);
isTrue( str_contains($search[0][CONTENT], 'hello') , 'comment search');

$vote = request("comment.vote", [
    IDX => $comment[IDX],
    CHOICE => 'Y',
    SESSION_ID => $userA->sessionId
]);
isTrue($vote['Y'] == 1 , "vote Y:: Y = 1");

$vote = request("comment.vote", [
    IDX => $comment[IDX],
    CHOICE => 'N',
    SESSION_ID => $userA->sessionId
]);
isTrue($vote['N'] == 1,  "vote N:: N = 1");

$vote = request("comment.vote", [
    IDX => $comment[IDX],
    CHOICE => 'N',
    SESSION_ID => $userA->sessionId
]);
isTrue($vote['Y'] == 0 , "vote N again:: Y = 0");
isTrue($vote['N'] == 0,  "vote N again:: N = 0");



