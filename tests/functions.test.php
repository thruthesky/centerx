<?php

levelTest();
pointBetweenTest();
percentageOfTest();



function levelTest() {
    isTrue(levelByPoint(0) == 1, '0 -> lv. 1');
    isTrue(levelByPoint(100) == 1, '100 -> lv. 1');
    isTrue(levelByPoint(101) == 2, '101 -> lv. 2');
    isTrue(levelByPoint(407) == 2, '407 -> lv. 2');
    isTrue(levelByPoint(408) == 3, '408 -> lv. 3');
    isTrue(levelByPoint(926) == 3, '926 -> lv. 3');
    isTrue(levelByPoint(927) == 4, '927 -> lv. 4');
    isTrue(levelByPoint(928) == 4, '928 -> lv. 4');
    isTrue(levelByPoint(2625) == 6, '2625 -> lv. 6');
    isTrue(levelByPoint(3816) == 7, '3816 -> lv. 7');
    isTrue(levelByPoint(8829) == 10, '8829 -> lv. 10');
    isTrue(levelByPoint(11000) == 11, '11000 -> lv. 11');
    isTrue(levelByPoint(357749) == 50, '357749 -> lv. 50');
    isTrue(levelByPoint(804608) ==69, '804608 -> lv. 69');
    isTrue(levelByPoint(11840699) == 200, '11840699 -> lv. 200');
    isTrue(levelByPoint(12000000) == 201, '12000000 -> lv. 201');
}


function pointBetweenTest() {
    isTrue(pointBetween(1) == 101, "between 1 -> 101, but: " . pointBetween(1));
    isTrue(pointBetween(2) == 307, "between 2 -> 307");
    isTrue(pointBetween(4) == 737, "between 4 -> 737, but: " . pointBetween(4));
    isTrue(pointBetween(43) == 13919, "between 43 -> 13919");
    isTrue(pointBetween(199) == 157907, "between 199 -> 157907");
}


function percentageOfTest() {
    isTrue(percentageOf(55) == 54, "percentageOf(55) -> 54%, but: " . percentageOf(54));
    isTrue(percentageOf(333) == 76, "percentageOf(333) -> 76%, but: " . percentageOf(333));
    isTrue(percentageOf(1234567) == 29, "percentageOf(1234567) -> 29%, but: " . percentageOf(1234567));
    isTrue(percentageOf(10000000) == 75, "percentageOf(10000000) -> 75%, but: " . percentageOf(10000000));
}