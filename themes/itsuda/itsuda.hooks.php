<?php

hook()->add('posts_before_create', function($record, $in) {
    debug_log("-------------- 1st hook of posts_before_create ");
    if ( !isset($record[ROOT_IDX]) || empty($record[ROOT_IDX]) ) { // 글 작성
        debug_log("글작성;", $record);
    }
    else if ( isset($record[ROOT_IDX]) && $record[ROOT_IDX] ) { // 코멘트 작성
        if ( $record[ROOT_IDX] == $record[PARENT_IDX] ) { // 첫번째 depth 코멘트. 즉, 글의 첫번째 자식 글. 자손의 글이 아님.
            debug_log("첫번째 depth 코멘트 작성;", $record);
        } else { // 첫번째 depth 가 아닌 코멘트. 단계가 2단계 이하인 코멘트. 즉, 코멘트의 코멘트.
            debug_log("코멘트의 코멘트 작성;", $record);
        }
    }
    return 'error_reject_on_create'; // 에러를 리턴하면, 글 쓰기 중지.
});

hook()->add('posts_before_create', function($record, $in) {
    debug_log("-------------- 두번째 훅: hook of posts_before_create", $in);
});