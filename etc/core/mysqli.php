<?php
/**
 * @file mysqli.php
 */
/**
 * Class MySQLiDatabase
 */

class MySQLiDatabase {
    public mysqli $connection;
    public string $error = '';
    public bool $displayError = false;
    public bool $displaySql = false;



    public function __construct(string $host, string $dbname, string $username, string $passwd, int $port = 0) {
        try {
            if ( !$port ) $port = ini_get("mysqli.default_port");
            $this->connection = new mysqli($host, $username, $passwd, $dbname, $port);
        } catch(Exception $e) {
            $this->handleError($e->getCode() . ': ' . $e->getMessage());
        }
    }

    private function handleError(string $msg, string $sql='') {

	    $this->error = "\n>\n>\n> {$this->connection->error}\n>\n>\n";
        $this->error .= "$msg\n";
        if ( $sql ) $this->error .= "SQL: $sql\n";
        if ( $this->displayError && isLocalhost() ) {
            d($this->error);
            debug_print_backtrace();
        }
        debug_log($this->error);
    }



    /**
     * @deprecated Do not use this method. it is not safe. Use it only for test or debug.
     *
     * Performs a query on the database
     *
     * @warning Security warning: SQL injection @see https://www.php.net/manual/en/mysqli.query.php
     * @warning Due to the security reason, this method must be used only internally. It is important to avoid querying
     *  with user data from HTTP input.
     * @warning Avoid to use this method with "SELECT", "UPDATE", "DELETE".
     *
     * @return mixed
     *  Returns false on failure. For successful queries which produce a result set, such as SELECT, SHOW, DESCRIBE or
     *  EXPLAIN, mysqli_query() will return a mysqli_result object. For other successful queries, mysqli_query() will
     *  return true.
     */
    public function query($sql): mixed {
        return $this->connection->query($sql);
    }


    /**
     * @param string $table
     * @param array $record
     * @return int
     *  - integer (bigger than 0) on success.
     *      -- Attention!!
     *       It might be last insert id.
     *       Or it might be 1 if there is no insert id(auto generated id).
     *  - zero(0) on failure.
     *  - It only returns integer(insert_id) when the record is actually created.
     *
     * @fix 2021. 04. 13. Display details error message if there is SQL error.
     *  Especially when `$stmt->execute()` return -1.
     */
    public function insert(string $table, array $record): int {
        if ( empty($table) || empty($record) ) return 0;
        list( $fields, $placeholders, $values ) = $this->parseRecord($record);


        try {
            $sql = "INSERT INTO {$table} ({$fields}) VALUES ({$placeholders})";

            $stmt = $this->connection->prepare($sql);

            if ( is_bool($stmt) ) {
                if ( $this->displayError ) {
                    echo "<hr>\n\n";
                    echo "Database connection->prepare error message: " . $this->connection->error . "\n";
                    echo "SQL: $sql\nValues: ";
                    print_r($values);
                    echo "\n";
                    die("db()->insert()");
                } else {
                    die("connection->prepare() returned bool. Enable `displayError` to see error message.");
                }
            }

            //
            $types = $this->types($values);
            $stmt->bind_param($types, ...$values);

            // Execute the query
            $stmt->execute();

            // @TODO 아래의 코드에서 execute() 가 -1 을 리턴한다.
            // ```translation()->create(['code'=>'tesu0t', 'text' => 'yo']);```
            // 위 코드에서 language 가 빠져서 에러가 난다.



            // Check for successful insertion
            if ( $stmt->affected_rows > 0 ) {
                $id = $this->connection->insert_id;
                if ( $id ) return $id;
                else return 1;
            } else if ( $stmt->affected_rows == 0 ) {
                return 0;
            } else {
                $this->handleError($stmt->error, $sql);
                return 0;
            }
        } catch (mysqli_sql_exception $e) {
            // This is critical SQL error.
            $this->handleError($e->__toString(), $sql);
            return 0;
        }
    }

    /**
     * @param string $table
     * @param array $record
     * @param array $conds - condition must be set. That means, you cannot update the whole records of a table.
     * @param string $conj
     * @return bool
     *  - returns true as long as the statement executed. It does not matter on any of the rows are updated or not.
     */
    public function update(string $table, array $record, array $conds, string $conj = 'AND'): bool
    {
        if (empty($table) || empty($record) || empty($conds)) return false;
        list($fields, $updates, $record_values) = $this->parseRecord($record, 'update');
        list($fields, $wheres, $where_values) = $this->parseRecord($conds, 'where', $conj);

        try {
            $sql = "UPDATE $table SET $updates WHERE $wheres";
            $stmt = $this->connection->prepare($sql);

            $newValues = [...$record_values, ...$where_values ];
            $types = $this->types($newValues);


            $stmt->bind_param($types, ...$newValues);

            // Execute the query
            return $stmt->execute();

        } catch (mysqli_sql_exception $e) {
            // This is critical SQL error.
            $this->handleError($e->__toString(), $sql);
            return false;
        }
    }


    /**
     * @param string $table
     * @param array $conds - condition must be set. That means, you cannot delete the whole records of a table.
     *  You may delete by providing condition like ['idx >' => 0]
     * @param string $conj
     * @return bool
     *  - returns true as long as the statement executed. It does not matter on any of the rows are deleted or not.
     */
    public function delete(string $table, array $conds, string $conj = 'AND' ): bool {
        if (empty($table) || empty($conds)) return false;
        list($fields, $wheres, $where_values) = $this->parseRecord($conds, 'where', $conj);
        try {
            $sql = "DELETE FROM $table WHERE $wheres";
            $stmt = $this->connection->prepare($sql);
            $stmt->bind_param($this->types($where_values), ...$where_values);
            return $stmt->execute();
        } catch (mysqli_sql_exception $e) {
            // This is critical SQL error.
            $this->handleError($e->__toString(), $sql);
            return false;
        }

    }




    /**
     * Returns a record.
     *
     * @attention It is always right to add `LIMIT 1` on the $sql since you will get only 1 record.
     *
     * @param string $sql
     * @param mixed ...$values
     *  ...$values can be a empty variable format. It work without any SQL condition. Like `SELECT COUNT(*) FROM TABLE`.
     *
     * @return array
     *  - empty row if there is no record (or there is an error)
     */
    public function row(string $sql, ...$values): array {
        $rows = $this->rows($sql, ...$values);
        if ( count($rows) ) return $rows[0];
        else return [];
    }



    




    /**
     * Returns many records
     *
     * @attention If the result set are more than 1,000 records, you may need to collect only id of the records and get the record of the id separately.
     * @attention It prevents a common mistake passing array as the second parameter *
     * ```
     * $rows = db()->rows($q, ['value', 1, 2, 3]); // This is error. It must be unpacked (or spread).
     * ```
     *
     * @attention We don't use binary as values. If binary data in $values had delivered, then it must be a mistake.
     * @param string $sql
     * @param mixed ...$values
     *  - If this is a empty (or no parameters), then it does not bind params. Just executes the statement.
     * @return array
     *
     */
    public function rows(string $sql, ...$values): array {

        try {
            $stmt = $this->connection->prepare($sql);
            if ( is_bool($stmt) && $stmt === false ) {
		$this->handleError("SQL Error on mysqli::rows()", $sql);
		exit(-1);
            }

            if ( $values ) {
                if ( is_array($values[0]) || is_object($values[0]) ) {
                    debug_print_backtrace();
                    die("\n>\n>\n> MySQLiDatabase::rows() - The first value in \$values is not a scalar! It must be a mistake. Wrong parameter format.\n>\n>\n");
                }
                $types = $this->types($values);
                if ( $types == 'b' ) {
                    debug_print_backtrace();
                    die("MySQLiDatabase::rows() - types == 'b'. We don't use binary as values.");
                }

                $stmt->bind_param($types, ...$values);
            }
            $stmt->execute();
            $result = $stmt->get_result(); // get the mysqli result

            // @todo DB 에서 에러가 발생하면, 심각한 에러로 빈 배열을 리턴하는 대신, 프로그램 종료를 해야하지 않는가?
            if ( $result === false ) {

                $this->handleError("SQL ERROR on row()", $sql);

                d($sql);
                d($values);
                d($result);

                return [];
            }


            /* fetch associative array */
            $rets = [];
            while ($row = $result->fetch_assoc()) {
                $rets[] = $row;
            }
            return $rets;
        } catch(mysqli_sql_exception $e) {
            // This is critical SQL error.
            $this->handleError($e->__toString(), $sql);
            return [];
        }
    }

    /**
     * Returns the first column of the first row of the result.
     * @param string $sql
     * @param mixed ...$values
     * @return mixed
     *  - `null` if there is no record.
     */
    public function column(string $sql, ...$values): mixed {
        $row = $this->row($sql, ...$values);

        if ( ! $row ) return null;
        $firstKey = array_key_first($row);
        return $row[$firstKey];
    }


    /**
     *
     * Gets an array of fields and values and returns 'fields', 'placeholders', 'values' for statement execution.
     *
     *
     * @note 사용자로 부터 입력되는 값은 무조건 escape 또는 Statement prepare & binding 형식으로 해야 한다.
     *      참고로, 이 함수는 statement prepare & binding 형식으로 처리하기 위한 정보를 가공해서 리턴한다.
     *
     * @param array $record
     *  - Record can have field, expression, value.
     *     If the record has an array of "['count >' => 5]", then, the placeholder will be "count > ?".
     *  - There must be a blank when the key has expression.
     *
     * @param string $type
     *
     *  if type is 'select' or 'where', the record key can have expression for `WHERE` clause.
     *  if type is 'update', the placeholders will be `SET` clause.
     *
     * @return array
     *
     * @example
     * ````
     *  $record = ['a' => 'apple', 'b' => 'banana', 'count >' => 5, 'title LIKE ?' => 'yo%'] // 와 같이 입력하면,
     *
     *  // 아래와 같이 2차원 배열에 각 배열은 fields 만 다음 배열, 조건식이 있는 배열, 값만 있는 배열이 리턴된다.
     *  return [
     *      ['a', 'b', 'c', 'title'],
     *      ['a=?', 'b=?', 'count>?', 'title LIKE ?'],
     *      ['apple', 'banana', 5, 'yo%'],
     *  ];
     * ```
     *
     *
     */
    public function parseRecord(array $record, string $type='', string $glue=',') {
        $fields = [];
        $placeholders = [];
        $values = [];


        // Loop through $data and build $fields, $placeholders, and $values
        foreach ( $record as $field => $value ) {

            $values[] = $value;
            // SQL Query 가 UPDATE 인 경우, 조합이 간단하다.
            if ( $type == 'update') {
                $fields[] = $field;
                $placeholders[] = $field . '=?';
            } else if ( $type == 'select' || $type == 'where' ) {
                // SELECT 나 기타 DELETE, UPDATE 에서 사용하는 경우, 조금 복잡하다.
                // @todo 더 많은 테스트 필요
                if ( str_contains($field, ' ')) {
                    $ke = explode(' ', $field, 2);
                    $field = $ke[0];
                    $fields[] = $field;
                    $exp = $ke[1];
                } else {
                    $fields[] = $field;
                    $exp = "=";
                }
                $placeholders[] = $field . ' ' . $exp . ' ?';
            } else {
                $fields[] = $field;
                $placeholders[] = '?';
            }
        }

        return array( implode(",", $fields), implode(' ' . $glue . ' ', $placeholders), $values );


    }

    /**
     * @param $val
     * @return string
     */
    private function type(mixed $val): string {
        if ($val == '' || is_string($val)) return 's';
        if (is_float($val)) return 'd';
        if (is_int($val)) return 'i';
        return 'b';
    }

    /**
     * @param array $values
     * @return string
     */
    private function types(array $values): string {
        $type = '';
        foreach($values as $val) {
            $type .= $this->type($val);
        }
        return $type;
    }


    /**
     * Returns the fields names of the table.
     * @param string $table
     * @return array
     */
    public function fieldNames(string $table): array {
        $q = "SELECT column_name FROM information_schema.columns WHERE table_schema = '".DB_NAME."' AND table_name = '$table'";
        $rows = db()->rows($q);
        $names = [];
        foreach($rows as $row) {
            $names[] = $row['column_name'];
        }
        return $names;
    }

}
