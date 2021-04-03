<?php


use ezsql\Database;
$__db = Database::initialize('mysqli', [DB_USER, DB_PASS, DB_NAME, DB_HOST]);

/**
 * db() 는 db 에 두 번 접속하지 않도록, 생성된 객체를 리턴한다.
 * @return Database\ez_mysqli|Database\ez_pdo|Database\ez_pgsql|Database\ez_sqlite3|Database\ez_sqlsrv|false
 */
function db() {
    global $__db;
    return $__db;
}