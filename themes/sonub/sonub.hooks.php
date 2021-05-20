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



hook()->add('post_list_country_code', function(&$countryCode) {
    $countryCode = cafe()->countryCode;
});

hook()->add('post-list-top', function() {
    include widget('banner/post-list-top');
});