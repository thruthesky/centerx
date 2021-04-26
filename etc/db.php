<?php




//
//use ezsql\Database;
//$__db = Database::initialize('mysqli', [DB_USER, DB_PASS, DB_NAME, DB_HOST]);


$__db = new MySQLiDatabase(DB_HOST, DB_NAME, DB_USER, DB_PASS);

/**
 * If `displayError` is set to `true`, then database error messages will be printed.
 * You may display error only on development mode(local host work).
 */
db()->displayError = true;



/**
 * db() 는 db 에 두 번 접속하지 않도록, 생성된 객체를 리턴한다.
 * @return MySQLiDatabase
 */
function db(): MySQLiDatabase {
    global $__db;
    return $__db;
}