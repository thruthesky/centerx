<?php
?>
<h1>Cafe check</h1>
<?php

foreach(cafe()->mainMenus as $categoryId) {
    $cat = category($categoryId);
    if ($cat->exists) {
        echo "<div>$categoryId 가 존재합니다.</div>";
    } else {
        $ncat = category()->create([ID => $categoryId]);
        echo "<div style='color: blue;'>$categoryId 를 생성하였습니다.</div>";
    }
}

exit;