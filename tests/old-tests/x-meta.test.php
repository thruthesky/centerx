<?php


$idx = entity('t')->addMetaIfNotExists(1, 'a', 'apple');


$a = entity('t', 1)->getMeta('a');
isTrue($a == 'apple', "expect: apple, result: $a");



/// Test empty array
$idx = entity('t')->addMetaIfNotExists(2, 'empty-array', []);
$empty_array = entity('t', 2)->getMeta('empty-array');
isTrue($empty_array == [], 'empty_array');
isTrue(count($empty_array) === 0, 'count 0');




/// Test array
$idx = entity('t')->addMetaIfNotExists(3, 'empty-array', [1, 2, 3, 'a', 'b', 'c']);
$arr = entity('t', 3)->getMeta('empty-array');
isTrue($arr[3] === 'a', 'array[3] == a');
isTrue(count($arr) === 6, 'count 6');



/// Test assoc array
$idx = entity('t')->addMetaIfNotExists(4, 'empty-array', [1, 2, 3, 'a'=>'apple', 'b'=>'banana', 'c']);
$arr = entity('t', 4)->getMeta('empty-array');
isTrue($arr['a'] === 'apple', 'array[a] == apple');
isTrue(count($arr) === 6, 'count 6');






