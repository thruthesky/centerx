<?php

$rows = inAppPurchase()->search(select: "*", where: "status='success'", limit: 1000);
?>
<h1>In app purchase</h1>;

<?php
d($rows);
?>