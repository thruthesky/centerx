<?php


isTrue(trim(sqlCondition([])) == '', 'empty condition');

isTrue(trim(sqlCondition(['a' => 'b'])) == "`a`='b'", 'condition a=b');

isTrue(trim(sqlCondition(['a >' => 0])) == "`a` > 0", "condition `a` > 0");
isTrue(trim(sqlCondition(['a >' => '0'])) == "`a` > '0'", "condition `a` > '0'");
