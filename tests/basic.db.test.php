<?php


connectionTest();
insertTest();
rowTest();
rowsTest();
columnTest();



function connectionTest() {
    $conn = new MySQLiDatabase(DB_HOST, DB_NAME, DB_USER, 'wrong password yo');
    isTrue( $conn->error, "connection error: {$conn->error}");

    $conn = new MySQLiDatabase(DB_HOST, DB_NAME, DB_USER, DB_PASS);
    isTrue( $conn->error == '', "connection ok");
    isTrue( $conn->connection->client_version > 0, "client_version: {$conn->connection->client_version}");
}

function insertTest() {

    /// Failure - empty value.
    $re = db()->insert(DB_PREFIX . 'search_keys', []);
    isTrue($re == 0, "must fail with empty record");

    /// Failure - wrong field
    db()->displayError = false;
    $re = db()->insert(DB_PREFIX . 'search_keys', ['a' => 'b']);
    isTrue($re == 0, "field a not exists");
    isTrue(str_contains(db()->error, 'Unknown column'), "Unknown column 'a' in 'field list'");
    db()->displayError = true;

    /// Success
    $re = db()->insert(DB_PREFIX . 'search_keys', ['searchKey' => 'hi', 'createdAt' => '12345']);
    isTrue($re > 0, "Must success");



    $idx = db()->insert(DB_PREFIX.'users', [
        'email' => 'insert'.time().'@test.com',
        'password' => 'insert'.time().'@test.com',
        'createdAt' => time(),
        'updatedAt' => time(),
    ]);

    isTrue($idx > 0, "user insert");


}

function rowTest() {
    $t = time();
    $key = 'k-' . $t;
    db()->insert(DB_PREFIX . 'search_keys', ['searchKey' => $key, 'createdAt' => $t]);
    $row = db()->row("SELECT * FROM " . DB_PREFIX . 'search_keys' . " WHERE searchKey=?", $key);
    isTrue($row['searchKey'] == $key, "key match: $key");
    isTrue($row['createdAt'] == $t, "time match: $key");
}

function rowsTest() {

    /// insert two search key
    $t = time();
    $key = 'rows-' . $t;
    db()->insert(DB_PREFIX . 'search_keys', ['searchKey' => $key, 'createdAt' => $t]);
    db()->insert(DB_PREFIX . 'search_keys', ['searchKey' => $key, 'createdAt' => $t]);
    $rows = db()->rows("SELECT * FROM " . DB_PREFIX . 'search_keys' . " WHERE searchKey=?", $key);
    isTrue(count($rows) == 2, "Two rows");
    foreach($rows as $row) {
        isTrue($row['searchKey'] == $key, 'Key test');
    }

    /// insert two user
    $idx = db()->insert(DB_PREFIX.'users', [
        'email' => 'rt1'.$t.'@test.com',
        'password' => 'insert'.$t.'@test.com',
        'createdAt' =>$t,
        'updatedAt' => $t,
    ]);

    $idx = db()->insert(DB_PREFIX.'users', [
        'email' => 'rt2'.$t.'@test.com',
        'password' => 'insert'.$t.'@test.com',
        'createdAt' =>$t,
        'updatedAt' => $t,
    ]);

    $rows = db()->rows(
        "SELECT * FROM " . DB_PREFIX . 'users' . " WHERE idx>? AND email LIKE ? AND ( createdAt=? OR updatedAt=?)",
        1, 'rt%', $t, $t
    );
    isTrue(count($rows) >= 2, "more than 2 users: " . count($rows));
}
function columnTest() {

    $t = time();
    $key = 'kcol-' . $t;
    db()->insert(DB_PREFIX . 'search_keys', ['searchKey' => $key, 'createdAt' => $t]);
    $col = db()->column("SELECT * FROM " . DB_PREFIX . 'search_keys' . " WHERE searchKey=?", $key);
    isTrue($col == $key, 'col key match');
}


