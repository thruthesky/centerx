<?php


connectionTest();
insertTest();
rowTest();
rowsTest();
columnTest();
entitySearchTest();
fieldNamesTest();
updateTest();
deleteTest();






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


function entitySearchTest() {
    $t = time();
    /// insert two user
    $idx = db()->insert(DB_PREFIX.'users', [
        'email' => 'select-1'.$t.'@test.com',
        'password' => 'insert'.$t.'@test.com',
        'createdAt' =>$t,
        'updatedAt' => $t,
    ]);

    $idx = db()->insert(DB_PREFIX.'users', [
        'email' => 'select-2'.$t.'@test.com',
        'password' => 'insert'.$t.'@test.com',
        'createdAt' =>$t,
        'updatedAt' => $t,
    ]);

    $rows = entity(USERS)->search(conds: ["idx >" => 1, "email LIKE" => "select%" ]);
    isTrue(count($rows) >= 2, "search records");

    $newRows = entity(USERS)->search(where: "idx > ? AND email LIKE ?", params: [1, "select%"]);
    isTrue(count($newRows) >= 2, "search records");

    $allRows = entity(USERS)->search();
    isTrue(count($allRows) >= 2, "search records");

}

function fieldNamesTest() {
    $names = db()->fieldNames(DB_PREFIX . 'search_keys');
    isTrue(count($names) == 2, 'Two fields');
    isTrue($names[0] == 'searchKey' && $names[1] == 'createdAt', 'Two fields');
}


function updateTest() {

    /// insert a search key
    $table = DB_PREFIX . 'search_keys';
    $t = time();
    $key = 'update-' . $t;
    db()->insert($table, ['searchKey' => $key, 'createdAt' => $t]);
    isTrue( db()->update($table, [CREATED_AT => 33], []) == false, "Update fails with empty conds");
    db()->displayError = false;
    isTrue( db()->update($table, [CREATED_AT => 33], ['abc' => 'def']) == false, "Update fails with wrong fields in conds");
    db()->displayError = true;

    isTrue( db()->update($table, [CREATED_AT => 33], ['searchKey' => $key, CREATED_AT => $t]), "Update createdAt to 33" );

    $re = db()->row("SELECT * FROM $table WHERE searchKey=? AND createdAt=?", ...[$key, 33]);
    isTrue($re['searchKey'] == $key && $re[CREATED_AT] == 33, "createdAt must be 33.");

}

function deleteTest() {
    $table = DB_PREFIX . 'search_keys';
    $t = time();
    $key = 'delete-' . $t;
    db()->insert($table, ['searchKey' => $key, 'createdAt' => $t]);
    $re = db()->row("SELECT * FROM $table WHERE searchKey=? AND createdAt=?", $key, $t);
    isTrue($re['searchKey'] == $key, "searchKey $key exists");

    db()->delete($table, ['searchKey' => $key, 'createdAt' => $t]);
    $re = db()->row("SELECT * FROM $table WHERE searchKey=? AND createdAt=?", $key, $t);
    isTrue($re == [], "searchKey $key deleted");

}