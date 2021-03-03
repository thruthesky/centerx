<?php


$db = getDatabase();
$reference = $db->getReference("test/doc");
$stamp = time();
$reference->set(['updatedAt' => $stamp]);




