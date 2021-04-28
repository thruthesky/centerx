<?php

setLogout();
testCommentEntity();
testCommentCreate();
testCommentRead();
testCommentOnComment();
testCommentUpdate();
testCommentDelete();


//testCommentCrud();

function testCommentEntity() {
    isTrue( get_class(comment()) == 'CommentTaxonomy', 'is CommentTaxonomy');
}

function testCommentCreate() {
    // login first
    setLoginAny();
    // get category
    $cat = category()->create(['id' => 'comment-create' . time()]);
    // create post with the category id
    $p = post()->create(['categoryId' => $cat->id, 'title' => 'comment create']);
    isTrue($p->ok, 'must have no error, post create should success');
    isTrue($p->idx > 0, 'post must have idx');

    // create comment on the post above
    $comment = comment()->create([ ROOT_IDX => $p->idx, CONTENT => 'comment content' ]);
    isTrue($comment->idx > 0, 'comment create');
    isTrue($comment->content == 'comment content', 'comment content match');
}


function testCommentRead() {
    setLoginAny();
    // get category
    $cat = category()->create(['id' => 'create-read' . time()]);
    // create post with the category id
    $p = post()->create(['categoryId' => $cat->id, 'title' => 'post comment create-read']);
    isTrue($p->idx > 0, 'post must have idx');
    $p_res = $p->response();
    isTrue(count($p_res[COMMENTS]) == 0, 'no comment yet');

    // create comment on the post above
    $comment = comment()->create([ ROOT_IDX => $p->idx, CONTENT => 'comment content read' ]);
    isTrue($comment->idx > 0, 'comment create success');
    isTrue($comment->rootIdx ==  $p->idx, 'comment rootIdx should be equal to post idx');
    isTrue($comment->parentIdx ==  $p->idx, 'comment parentIdx should be equal to post idx');

    // check if comment exist in the post
    $p_res = $p->response();
    isTrue(count($p_res[COMMENTS]) > 0, 'post must have comment');
    isTrue($p_res[COMMENTS][0][IDX] == $comment->idx, 'post 1st comment must be same to the newly created comment');

    $r1 = comment($comment->idx);
    isTrue($r1->idx == $comment->idx, 'idx must be equal');
    isTrue($r1->content == $comment->content, 'content must be same');
    isTrue($r1->rootIdx == $p->idx, 'comment root idx must be equal to post idx');

    $r2 = comment()->read($comment->idx);
    isTrue($r2->idx == $comment->idx, 'idx must be equal on read');
    isTrue($r2->content == $r1->content, 'content must be same on read');
    isTrue($r2->rootIdx == $p->idx, 'comment root idx must be equal to post idx on read');
}

function testCommentOnComment(){
    setLoginAny();
    // get category
    $cat = category()->create(['id' => 'comment-on-comment' . time()]);
    // create post with the category id
    $p = post()->create(['categoryId' => $cat->id, 'title' => 'post comment create-read']);
    isTrue($p->idx > 0, 'post must have idx');

    // create comment on the post above
    $comment = comment()->create([ ROOT_IDX => $p->idx, CONTENT => 'comment on comment' ]);
    isTrue($comment->idx > 0, 'first comment create');
    isTrue($comment->rootIdx ==  $p->idx, 'comment rootIdx should be equal to post idx');
    isTrue($comment->parentIdx ==  $p->idx, 'comment parentIdx should be equal to post idx');


    // create comment on the comment above
    $commentChild = comment()->create([ ROOT_IDX => $p->idx, PARENT_IDX => $comment->idx, CONTENT => "Child of $comment->idx" ]);
    isTrue($commentChild->idx > 1, '2nd comment create');
    isTrue($comment->rootIdx ==  $p->idx, 'comment rootIdx should be equal to post idx');
    isTrue($comment->parentIdx ==  $comment->idx, 'comment parentIdx should be equal to parent comment idx');

    // check if 2nd comment exist in the post
    $p_res = $p->response();
    d($p_res);
    isTrue(count($p_res[COMMENTS]) == 2, 'post must have 2 comment');
    isTrue($p_res[COMMENTS][0][IDX] == $comment->idx, 'post 1st comment must be same to the newly created comment');
    isTrue($p_res[COMMENTS][0][DEPTH] == 1, 'comment must have 1 depth');
    isTrue($p_res[COMMENTS][1][IDX] == $commentChild->idx, 'post 2st comment must be same to the newly created comment');
    isTrue($p_res[COMMENTS][1][DEPTH] == 2, 'comment under comment must have higher depth');

}


function testCommentUpdate() {
    setLoginAny();
    // get category
    $cat = category()->create(['id' => 'create-update-read' . time()]);
    // create post with the category id
    $p = post()->create(['categoryId' => $cat->id, 'title' => 'post comment create-read-update']);
    isTrue($p->idx > 0, 'post must have idx');
    // create comment on the post above
    $comment = comment()->create([ ROOT_IDX => $p->idx, CONTENT => 'comment create read update' ]);
    isTrue($comment->idx > 0, 'comment create');

    // update comment content
    $update = comment($comment->idx)->update([ CONTENT => 'Updated comment' ])->read();
    isTrue($update->content != 'comment create read update', 'comment updated');
    isTrue($update->content == 'Updated comment', 'comment updated');
}

function testCommentDelete() {
    setLoginAny();
    // get category
    $cat = category()->create(['id' => 'create-delete-read' . time()]);
    // create post with the category id
    $p = post()->create(['categoryId' => $cat->id, 'title' => 'post comment create-read-delete']);
    isTrue($p->idx > 0, 'post must have idx');

    // create comment on the post above
    $comment = comment()->create([ ROOT_IDX => $p->idx, CONTENT => 'comment create read update' ]);
    isTrue($comment->idx > 0, 'comment create');

    // update comment content
    $delete = comment($comment->idx)->delete();
    isTrue($delete->hasError, 'comment delete error');
    isTrue($delete->getError() == e()->comment_delete_not_supported, 'comment delete not supported');
//    d($delete);
}



//function testCommentCrud() {
//    // 로그인
//    setLoginAny();
//
//    // 카테고리 생성
//
//    $cat = category()->create(['id' => 'comment-create' . time()]);
//
//    // 글 생성
//    $p = post()->create(['categoryId' => $cat->id, 'title' => 'comment create']);
//    isTrue($p->ok, 'must have no error');
//
//    $comment = comment()->create([ ROOT_IDX => $p->idx, CONTENT => 'comment content' ]);
//    isTrue($comment->idx > 0, 'comment create');
//    isTrue($comment->content == 'comment content', 'comment content match');
//
//    isTrue($comment->update(['content' => 'yo.'])->content == 'yo.', 'comment updated');
//
//    isTrue(comment($comment->idx)->content == 'yo.', 'comment read');
//
//    isTrue(isError($comment->response()) == false, 'comment response');
//    isTrue($comment->response()[IDX] == $comment->idx, 'comment response idx match');
//
//
//    isTrue($comment->delete()->getError() == e()->comment_delete_not_supported, 'comment cannot be deleted');
//    isTrue($comment->reset($comment->idx)->markDelete()->deletedAt > 0, 'comment marked as deleted');
//
//}






