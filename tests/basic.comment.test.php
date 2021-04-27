<?php




setLogout();

testCommentEntity();
testCommentCrud();


function testCommentEntity() {
    isTrue( get_class(comment()) == 'CommentTaxonomy', 'is CommentTaxonomy');
}


function testCommentCrud() {
    // 로그인
    setLoginAny();

    // 카테고리 생성

    $cat = category()->create(['id' => 'comment-create' . time()]);

    // 글 생성
    $p = post()->create(['categoryId' => $cat->id, 'title' => 'comment create']);
    isTrue($p->ok, 'must have no error');

//    enableDebugging();
    $comment = comment()->create([ ROOT_IDX => $p->idx, CONTENT => 'comment content' ]);
    isTrue($comment->idx > 0, 'comment create');
    isTrue($comment->content == 'comment content', 'comment content match');

    isTrue($comment->update(['content' => 'yo.'])->content == 'yo.', 'comment updated');

    isTrue(comment($comment->idx)->content == 'yo.', 'comment read');

    isTrue(isError($comment->response()) == false, 'comment response');
    isTrue($comment->response()[IDX] == $comment->idx, 'comment response idx match');



    isTrue($comment->delete()->getError() == e()->comment_delete_not_supported, 'comment cannot be deleted');
    isTrue($comment->reset($comment->idx)->markDelete()->deletedAt > 0, 'comment marked as deleted');

}

