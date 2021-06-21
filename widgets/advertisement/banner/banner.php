<?php
$bo = getWidgetOptions();
$ad_type = $bo['type'];
$place = $bo['place'] ?? '';

// place 값이 지정되지 않았으면, 현재 게시판, 게시글로 place 를 지정한다.
if ( ! $place ) {
    if ( in('categoryId') ) {
        $place = in('categoryId');
    } else {
        $post = post()->current();
        if ( $post->ok ) $place = $post->categoryId();
    }
}


include_once ROOT_DIR . 'widgets/advertisement/banner/banner.lib.php';

if ( $ad_type == AD_TOP ) {
    $row = db()->row(advSql($ad_type, $place));
    if ( $row ) {
        $post = post($row['postIdx']);
        $file = $post->fileByCode( $ad_type );
        echo "<img src='{$file->url}'>";
    } else { // 광고가 없는 경우, 기본 표시 광고
        if ( $place == 'L' ) {
            echo "<a href='https://katalkenglish.com' target='_blank'><img src='/widgets/advertisement/banner/ad-top-left.jpg'></a>";
        } else if ( $place == 'R' ) {
            echo "<a href='https://katalkenglish.com' target='_blank'><img src='/widgets/advertisement/banner/ad-top-left.jpg'></a>";
        }
    }
} else if ( $ad_type == AD_WING && $place != 'main'  ) {
    // 현재 게시판 카테고리의 날개 배너를 먼저 보여준다.
    $q = advSql($ad_type, $place);
    $rows = db()->rows($q);

    // 현재 카테고리에 상관 없이 전체 배너를 보여준다.
    if ( $place ) {
        $q = advSql($ad_type, '');
        $rows2 = db()->rows($q);
        $rows = array_merge($rows, $rows2);
    }

    if ( count($rows) ) {
        foreach( $rows as $row ) {
            $post = post($row['postIdx']);
            $file = $post->fileByCode( $ad_type );
            echo "<img src='{$file->url}'>";
        }
    }
} else if ( $ad_type == AD_WING && $place == 'main'  ) {
    $q = advSql($ad_type);
    $rows = db()->rows($q);
    if ( count($rows) ) {
        echo "<div class='row px-1 {$bo['class']}'>";
        foreach( $rows as $row ) {
            $post = post($row['postIdx']);
            $file = $post->fileByCode( $ad_type );
            echo "<div class='col-4 mb-2 px-1'><img class='w-100' src='{$file->url}'></div>";
        }
        echo '</div>';
    }
} else if ( $ad_type == AD_POST_LIST_SQUARE ) {
    $rows = db()->rows(advSql($ad_type, $place));
    if ( $rows ) {
        ?>
        <div class="ad-post-list-square mx-0 mx-md-2">
            <div class="row">
                <?php foreach($rows as $row) {
                    $post = post($row['postIdx']);
                    $file = $post->fileByCode( $ad_type );  ?>
                    <div class="col-4 col-lg-3 px-1 mb-1 mb-lg-2"><img class="w-100" src="<?=$file->url?>"></div>
                <?php } ?>
            </div>
        </div>
        <?php
    }
}
