<?php


$db = getRealtimeDatabase();
$reference = $db->getReference("test/doc");
$stamp = time();
$reference->set(['updatedAt' => $stamp]);




