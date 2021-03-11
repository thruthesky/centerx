<?php




setLogout();

testCommentEntity();
testCommentCrud();


function testCommentEntity() {
    isTrue( get_class(comment()) == 'Comment', 'is post');
}


function testCommentCrud() {
    // 로그인
    setLoginAny();

    // 카테고리 생성
    $cat = category()->create(['id' => 'comment-create' . time()]);

    // 글 생성
    $p = post()->create(['categoryId' => $cat->id, 'title' => 'comment create']);
    isTrue($p->hasError == false, 'must have no error');

//    enableDebugging();
    $comment = comment()->create([ ROOT_IDX => $p->idx, CONTENT => 'comment content' ]);
    isTrue($comment->idx > 0, 'comment create');
    isTrue($comment->content == 'comment content', 'comemnt content match');
//disableDebugging();
}

