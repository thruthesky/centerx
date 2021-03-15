<?php

if ( category(SHOPPING_MALL)->notExists() ) {
    $re = category()->create([ID => SHOPPING_MALL]);
}

if ( in('mode') == 'deleteAllItems' ) {
    $q = "DELETE FROM " . entity(POSTS)->getTable() . " WHERE categoryIdx=" . category(SHOPPING_MALL)->idx;
    db()->query($q);
}

?>

<div class="container">
    <div class="row">
        <div class="col-3">
            <h3>Shopping Mall</h3>
            <ul>
                <li><a href="/?p=admin.index&w=shopping-mall/admin-shopping-mall&cw=list">상품 목록</a></li>
                <li><a href="/?p=admin.index&w=shopping-mall/admin-shopping-mall&cw=edit">상품 추가</a></li>
                <li><a href="/?p=admin.index&w=shopping-mall/admin-shopping-mall&mode=deleteAllItems"  onclick="return confirm('경고: 모든 주문 데이터가 삭제됩니다. 이것은 오직 개발자만 할 수 있는 명령입니다. 관리자는 이 버튼(메뉴) 자체를 보면 안됩니다. 이 버튼이 보이면, 개발자에게 얘기해주세요.');">전체 상품 삭제</a></li>
                <li><a href="/?p=<?=in('p')?>&w=<?=in('w')?>&cw=setting">설정</a></li>
                <li><a href="/?p=<?=in('p')?>&w=<?=in('w')?>&cw=order-list">주문 관리</a></li>
            </ul>
        </div>
        <div class="col-9">
            <?php
            include in('cw', 'list') . '.php';
            ?>
        </div>
    </div>

</div>
