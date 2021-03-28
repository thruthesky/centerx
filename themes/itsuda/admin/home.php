<?php

if ( modeSubmit() ) {
    foreach( DEFAULT_CATEGORIES as $categoryId ) {
        $category = category($categoryId);
        if ( $category->exists() == false ) {
            $re = category()->create([ID => $categoryId]);
        }
    }

}

foreach( DEFAULT_CATEGORIES as $categoryId ) {
    $category = category($categoryId);
    if ( $category->exists() ) echo "<div class='fs-title'>{$category->title}</div><div class='fs-desc'>$categoryId</div><hr>";
    else echo "<div class='alert alert-danger'>$categoryId 가 존재하지 않습니다.</div><hr>";
}

?>
<a href="/?p=<?=in('p')?>&mode=submit">존재하지 않는 게시판 생성하기</a>
