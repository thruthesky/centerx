<?php
include './boot.php';

d($_SERVER);

$dsn_path_user = 'myuser';
$password = 'mypass';
$database = 'mydatabase';
$host = 'mariadb';



use ezsql\Database;
$db = Database::initialize('mysqli', [$dsn_path_user, $password, $database, $host]);

