<?php

hook()->add('posts-before-create', function($record, $in) {
    debug_log("-------------- 1st hook of posts-before-create ", $record);

    if ( !isset($record[ROOT_IDX]) || empty($record[ROOT_IDX]) ) { // 글 작성
//        debug_log("글작성;", $record);
    }
    else if ( isset($record[ROOT_IDX]) && $record[ROOT_IDX] ) { // 코멘트 작성
        if ( $record[ROOT_IDX] == $record[PARENT_IDX] ) { // 첫번째 depth 코멘트. 즉, 글의 첫번째 자식 글. 자손의 글이 아님.

//            debug_log("첫번째 depth 코멘트 작성;", $record);

            $categoryId = category($record[CATEGORY_IDX])->v('id');
//            debug_log("categoryId;", $categoryId);
            if ( $categoryId == SHOPPING_MALL ) {

                $rows = shoppingMallOrder()->search(where: 'userIdx=' . login()->idx, select: '*');
                debug_log('row2;', $rows);
                foreach( $rows as $row ) {
                    $info = json_decode($row['info'], true);
//                    debug_log('info', $info);
                    foreach( $info['items'] as $item ) {
                        if ( $item['postIdx'] == $record[ROOT_IDX] ) {
                            // 구매한 제품
                            if ( ! $row['confirmedAt'] ) {
//                                debug_log('--------- 내가 주문했지만, 주문 컨펌이 안된 제품!!');
                                return e()->order_not_confirmed;
                            } else {
//                                debug_log('--------- 내가 구매하고, 컨펀 된 제품!!');
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

hook()->add('posts-after-create', function($record, $in) {
//    debug_log("-------------- hook of posts-after-create. record:", $record);
//    debug_log("-------------- hook of posts-after-create. in:", $in);
});

hook()->add('posts-create-point', function($data) {
    debug_log("-------------- hook of posts-create-point. post data:", $data);

    $categoryIdxes = [];
    foreach( HEALTH_CATEGORIES as $categoryId ) {
        $categoryIdxes[] = category($categoryId)->idx;
    }
    if ( in_array($data[CATEGORY_IDX], $categoryIdxes) ) {
        $entity = entity('itsuda');
        if ( $entity->exists([USER_IDX => login()->idx]) ) {
            $found = $entity->findOne([USER_IDX => login()->idx]);
            $found->update(['healthPoint' => $found->healthPoint + $data['appliedPoint'] ]);
        } else {
            $entity->create([USER_IDX => login()->idx, 'healthPoint' => $data['appliedPoint']]);
        }
    }
});


hook()->add('admin-setting', function($settings) {
    $account_info_name = $settings['account_info_name'] ?? '';
    $account_info_bank = $settings['account_info_bank'] ?? '';
    $account_info_no = $settings['account_info_no'] ?? '';
   echo <<<EOH
    <h2>쇼핑몰 입금 통장 정보</h2>
    <input type="text" class="form-control mb-2" name='account_info_name' value="$account_info_name" placeholder="예금주">
    <div class="hint">
        쇼핑몰에 표시 될 무통장 정보 중 예금주를 입력해주세요. 예) 주식회사 위드플랜잇
    </div>
    <input type="text" class="form-control mb-2" name='account_info_bank' value="$account_info_bank" placeholder="은행이름">
    <div class="hint">
        쇼핑몰에 표시 될 무통장 정보 중 은행 이름을 입력해주세요. 예) 기업 은행
    </div>
    <input type="text" class="form-control mb-2" name='account_info_bank' value="$account_info_no" placeholder="계좌번호">
    <div class="hint">
        쇼핑몰에 표시 될 무통장 정보 중 계좌번호를 입력해주세요. 예) 1234-xxxx-5678
    </div>
EOH;

});

