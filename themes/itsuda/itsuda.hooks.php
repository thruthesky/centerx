<?php

hook()->add('posts-before-create', function($record, $in) {
    debug_log("-------------- 1st hook of posts-before-create ", $record);

    if ( !isset($record[ROOT_IDX]) || empty($record[ROOT_IDX]) ) { // 글 작성
//        debug_log("글작성;", $record);
    }
    else if ( isset($record[ROOT_IDX]) && $record[ROOT_IDX] ) { // 코멘트 작성
        if ( $record[ROOT_IDX] == $record[PARENT_IDX] ) { // 첫번째 depth 코멘트. 즉, 글의 첫번째 자식 글. 자손의 글이 아님.

            debug_log("첫번째 depth 코멘트 작성;", $record);

            $categoryId = category($record[CATEGORY_IDX])->v('id');
            debug_log("categoryId;", $categoryId);
            if ( $categoryId == SHOPPING_MALL ) {

                $rows = shoppingMallOrder()->search(where: 'userIdx=' . login()->idx, select: '*');
                debug_log('row2;', $rows);
                foreach( $rows as $row ) {
                    $info = json_decode($row['info'], true);
                    debug_log('info', $info);
                    foreach( $info['items'] as $item ) {
                        if ( $item['postIdx'] == $record[ROOT_IDX] ) {
                            // 구매한 제품
                            if ( ! $row['confirmedAt'] ) {
                                debug_log('--------- 내가 주문했지만, 주문 컨펌이 안된 제품!!');
                                return e()->order_not_confirmed;
                            } else {
                                debug_log('--------- 내가 구매하고, 컨펀 된 제품!!');

                                $userIdx = login()->idx;
                                $comments = entity(POSTS)->search(where: " rootIdx={$record[ROOT_IDX]} AND userIdx=$userIdx ");
                                // debug_log('comments; ', $comments);
                                if ( count($comments) ) return e()->already_reviewed;
                                return;
                            }
                        }
                    }
                }

                debug_log("------ 구매 안한 제품");
                return e()->not_your_order;
            }
        } else { // 첫번째 depth 가 아닌 코멘트. 단계가 2단계 이하인 코멘트. 즉, 코멘트의 코멘트.
//            debug_log("코멘트의 코멘트 작성;", $record);
        }
    }
});

hook()->add('posts-before-create', function($record, $in) {
//    debug_log("-------------- 두번째 훅: hook of posts-before-create", $in);
});
