<?php




hook()->add('post-meta-3rd-line', function( PostTaxonomy $post ) {
    $countryCode = strtolower($post->countryCode);

    return <<<EOH
No. {$post->idx} ($countryCode) {$post->categoryId()}
EOH;

});


/**
 * 글 쓰기를 할 때, 카페(카테고리)의 국가를 countryCode 에 기록한다.
 */
hook()->add('posts-before-create', function(&$record, $in) {
    $record['countryCode'] = cafe()->countryCode;
});



hook()->add(HOOK_POST_LIST_COUNTRY_CODE, function(&$countryCode) {
    if ( in(CATEGORY_ID) != MESSAGE_CATEGORY ) $countryCode = cafe()->countryCode;
    return $countryCode;
});

hook()->add(HOOK_POST_LIST_TOP, function() {
});


hook()->add(HOOK_POST_LIST_ROW, function(int $rowNo, array $posts) {
    if ( $rowNo == 3 ) {
        include widget('advertisement/banner', ['type' => AD_POST_LIST_SQUARE]);
        echo "<hr>";
    }
    if ( count($posts) == $rowNo ) {
        // This is the last line.
    }
});