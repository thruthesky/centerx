<?php

include 'comment.controller.php';


$comment = new CommentController();


registerAndLogin();
$re = $comment->update([]);
isTrue($re = e()->idx_is_empty, 'error comment idx is empty');
$re = $comment->delete([]);
isTrue($re = e()->idx_is_empty, 'error delete idx is empty');
$re = $comment->get([]);
isTrue($re = e()->idx_is_empty, 'error get idx is empty');
$re = $comment->vote([]);
isTrue($re = e()->idx_is_empty, 'error vote idx is empty');