<?php

mysqli_report(MYSQLI_REPORT_ALL);



class MySQLiDatabase {
    public mysqli $connection;
    public string $error = '';
    public bool $displayError = false;


    public function __construct(string $host, string $dbname, string $username, string $passwd, int $port = 0) {
        try {
            if ( !$port ) $port = ini_get("mysqli.default_port");
            $this->connection = new mysqli($host, $username, $passwd, $dbname, $port);
        } catch(Exception $e) {
            $this->handleError($e->getCode() . ': ' . $e->getMessage());
        }
    }

    private function handleError(string $msg, string $sql='') {
        $this->error = "$msg\n";
        if ( $sql ) $this->error .= "SQL: $sql\n";
        if ( $this->displayError ) d($this->error);
        debug_log($this->error);
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
     */
    public function insert(string $table, array $record): int {
        if ( empty($table) || empty($record) ) return 0;
        list( $fields, $placeholders, $values ) = $this->parseRecord($record);


        try {
            $prepare = "INSERT INTO {$table} ({$fields}) VALUES ({$placeholders})";
            $stmt = $this->connection->prepare($prepare);
            $types = $this->types($values);
            $stmt->bind_param($types, ...$values);

            // Execute the query
            $stmt->execute();
            // Check for successful insertion
            if ( $stmt->affected_rows ) {
                $id = $this->connection->insert_id;
                if ( $id ) return $id;
                else return 1;
            } else {
                return 0;
            }
        } catch (mysqli_sql_exception $e) {
            $this->handleError($e->__toString());
            return 0;
        }
    }


    /**
     * @deprecated - Use $this->row();
     * @param $q
     * @param string $_ - for backward compatibility.
     * @return array
     */
    public function get_row($q, string $_=''): array {
        die("Do not use db()->get_row()");
        return $this->connection->query($q)->fetch_assoc();
    }

    /**
     * Returns a record.
     *
     * @return array
     *  - empty row if there is no value (or there is an error)
     */
    public function row($sql, ...$values): array {
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->bind_param($this->types($values), ...$values);
            $stmt->execute();
            $result = $stmt->get_result(); // get the mysqli result
            return $result->fetch_assoc(); // fetch data
        } catch(mysqli_sql_exception $e) {
            $this->handleError($e->__toString(), $sql);
            return [];
        }
    }



    /**
     * Backward compatibility
     *
     * @deprecated user $this->rows().
     * @param $q
     * @param string $_ - backward compatibility
     * @return array
     */
    public function get_results($q, $_=''): array {
        die("Do not use db()->get_result()");
        $rets = [];
        $result = $this->connection->query($q);
        while ($row = $result->fetch_assoc()) {
            $rets[] = $row;
        }
        return $rets;
    }

    /**
     * Returns many records
     *
     * @attention If the result set are more than 1,000 records, you may need to collect only id of the records and get the record of the id separately.
     *
     * @param string $sql
     * @param mixed ...$values
     * @return array
     */
    public function rows(string $sql, ...$values): array {
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param($this->types($values), ...$values);
        $stmt->execute();
        $result = $stmt->get_result(); // get the mysqli result
        /* fetch associative array */
        $rets = [];
        while ($row = $result->fetch_assoc()) {
            $rets[] = $row;
        }
        return $rets;
    }

    /**
     * alias of column(). for backward compatibility.
     * @deprecated
     * @param $q
     * @return mixed
     */
    public function get_var($q): mixed {
        die("Do not use db()->get_var()");
        return $this->get_row($q)[0];
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
     * @param array $record
     * @param string $type
     * @return array
     */
    private function parseRecord(array $record, string $type='insert') {
        $fields = [];
        $placeholders = [];
        $values = [];


        // Loop through $data and build $fields, $placeholders, and $values
        foreach ( $record as $field => $value ) {
            $fields[] = $field;
            $values[] = $value;
            if ( $type == 'update') {
                $placeholders[] = $field . '=?';
            } else {
                $placeholders[] = '?';
            }
        }

        return array( implode(",", $fields), implode(",", $placeholders), $values );


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


}
