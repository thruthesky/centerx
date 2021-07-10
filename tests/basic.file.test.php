<?php

registerAndLogin();
testInputFileUpload();
testFileUpload();
testPostCreateWithImage();


function testInputFileUpload() {
    $re = files()->upload([]);
    isTrue($re->getError() == e()->file_is_empty, "file data is empty");

    $re = files()->upload([], []);
    isTrue($re->getError() == e()->file_is_empty, "file data is empty");


    $re = files()->upload([], [
        NAME => '',
    ]);
    isTrue($re->getError() == e()->file_name_is_empty, "file name is empty");


    $re = files()->upload([], [
        NAME => 'oo',
    ]);
    isTrue($re->getError() == e()->file_size_is_empty, "file size is empty");

    $re = files()->upload([], [
        NAME => 'oo',
        SIZE => 1,
    ]);
    isTrue($re->getError() == e()->file_type_is_empty, "file type is empty");

    $re = files()->upload([], [
        NAME => 'oo',
        SIZE => 1,
        TYPE => 'image/jpeg',
    ]);
    isTrue($re->getError() == e()->file_tmp_name_is_empty, "file tmp_name is empty");

}
function testFileUpload() {

    $_FILES[USERFILE][NAME] = 'frog.jpg';
    $_FILES[USERFILE][TMP_NAME] = ROOT_DIR . 'tests/images/frog.jpg';
    $_FILES[USERFILE][SIZE] = filesize($_FILES[USERFILE][TMP_NAME]);
    $_FILES[USERFILE][TYPE] = mimeType($_FILES[USERFILE][TMP_NAME]);

    $res = files()->upload([]);

    isTrue($res->idx > 0, 'File upload success');
}

function testPostCreateWithImage() {
    $path = ROOT_DIR . 'tests/images/frog.jpg';
    $file = files()->upload([], [
        NAME => basename($path),
        TMP_NAME => $path,
        SIZE => filesize($path),
        TYPE => mimeType($path),
    ]);

    $post = createPost('qna',
        title: '겨울잠을 자고 일어난 개구리',
        files: $file->idx);
    if ( $post->hasError && $post->getError() == e()->not_verified ) {
        echo "\n@warning user verification failed. Test again with right permission.\n";
    } else {
        isTrue($post->idx > 0, '사진과 함께 게시글 작성');
    }
}