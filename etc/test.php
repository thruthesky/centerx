<?php



include '../boot.php';

echo "Localhost test<hr>";
d("isLocalhost(): ");
if ( isLocalhost() ) d("yes, it is localhost");
else d('no, it is not localhost');


echo "<hr>daysBetween, carbon diffInDays test<hr>";


$stamp_today = time();
$stamp_tomorrow = time() + 60 * 60 * 24;
$stamp_after_tomorrow = time() + 60 * 60 * 24 * 2;

$today1 = \Carbon\Carbon::createFromTimestamp($stamp_today);
$today2 = \Carbon\Carbon::createFromTimestamp($stamp_today);
$tomorrow = \Carbon\Carbon::createFromTimestamp($stamp_tomorrow);
$after_tomorrow = \Carbon\Carbon::createFromTimestamp($stamp_after_tomorrow);

echo "diffInDays() - today vs today: " . $today1->diffInDays($today2) . "<hr>";
echo "diffInDays() - today vs tomorrow: " . $today1->diffInDays($tomorrow) . "<hr>";
echo "diffInDays() - today vs after_tomorrow: " . $today1->diffInDays($after_tomorrow) . "<hr>";
echo "diffInDays() - tomorrow vs after_tomorrow: " . $tomorrow->diffInDays($after_tomorrow) . "<hr>";