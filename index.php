<?php
include './boot.php';


use ezsql\Database;
$db = Database::initialize('mysqli', [DB_USER, DB_PASS, DB_NAME, DB_HOST]);

d($db);

//$db->insert(table: 'users', keyValue: ['id' => 1, 'name' => 'yo']);
$db->query("INSERT INTO users (id,name) VALUES (4, 'EunSu')");
$rows = $db->get_results('select * from users', ARRAY_A);

d($rows);
