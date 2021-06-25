<?php



include '../boot.php';

echo "Localhost test<hr>";
d("isLocalhost(): ");
if ( isLocalhost() ) d("yes, it is localhost");
else d('no, it is not localhost');


echo "<hr>daysBetween(), carbon diffInDays test<hr>";


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

echo "<br>daysBetween(), carbon diffInDays() test using startOfDay()<br>";

$dayStampA = strtotime('+1 day 6 hours');
$dayStampB = strtotime('+2 days 13 hours');
$dayStampC = strtotime('+3 days 2 hours');
$nowStamp = time();

$day1 = \Carbon\Carbon::createFromTimestamp($dayStampA);
$day2 = \Carbon\Carbon::createFromTimestamp($dayStampB);
$day3 = \Carbon\Carbon::createFromTimestamp($dayStampC);

echo "<br>day1 : $day1 <br>";
echo "day2 : $day2<br>";
echo "day3 : $day3<br>";

$now = \Carbon\Carbon::createFromTimestamp($nowStamp);
echo "<hr>not using (Carbon()->startOfDay()) now : $now<br><br>";

echo "now->diffInDays() - now vs day1 : " . $now->diffInDays($day1) . "<br>";
echo "now->diffInDays() - now vs day2 : " . $now->diffInDays($day2) . "<br>";
echo "now->diffInDays() - now vs day3 : " . $now->diffInDays($day3) . "<br>";


$now = $now->startOfDay();
$day1 = $day1->startOfDay();
$day2 = $day2->startOfDay();
$day3 = $day3->startOfDay();

echo "<br>day1 : $day1 <br>";
echo "day2 : $day2<br>";
echo "day3 : $day3<br>";

echo "<hr>using (Carbon()->startOfDay()) now : $now<br><br>";

echo "now->diffInDays() - now vs day1 : " . $now->diffInDays($day1) . "<br>";
echo "now->diffInDays() - now vs day2 : " . $now->diffInDays($day2) . "<br>";
echo "now->diffInDays() - now vs day3 : " . $now->diffInDays($day3) . "<br>";
