<?php
/**
 * Halografix - MVC Framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2020 Halografix
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */
defined('SYSPATH') OR exit('No direct script access allowed');

require_once 'DB_init.php';
require_once SYSPATH . 'helpers/download.php';

class DB_utility extends DB_init {

    // --------------------------------------------------------------------

    /**
     * Class constructor
     *
     * @return	void
     */

    public function __construct() {
        parent::__construct();
    }

    // --------------------------------------------------------------------

    /**
     * Prints a list of available PDO attributes
     *
     * @return  void
     */

    public function attributes() {
        $attributes = array(
            "AUTOCOMMIT", "ERRMODE", "CASE", "CLIENT_VERSION", "CONNECTION_STATUS",
            "ORACLE_NULLS", "SERVER_INFO", "SERVER_VERSION"
        );

        foreach ($attributes as $val) {
            echo "PDO::ATTR_$val: ";
            echo $this->conn->getAttribute(constant("PDO::ATTR_$val")) . "\n";
        }
    }

    // --------------------------------------------------------------------

    /**
     * Returns the client version
     *
     * @return  string
     */

    public function client_version() {
        if (self::$_instance) {
            return $this->conn->getAttribute(constant( "PDO::ATTR_CLIENT_VERSION" ));
        }

        return;
    }

    // --------------------------------------------------------------------

    /**
     * Returns the connection status
     *
     * @return  string
     */

    public function connection_status() {
        if (self::$_instance) {
            return $this->conn->getAttribute(constant( "PDO::ATTR_CONNECTION_STATUS" ));
        }

        return;
    }

    // --------------------------------------------------------------------

    /**
     * Returns server info
     *
     * @return  string
     */

    public function server_info() {
        if (self::$_instance) {
            return $this->conn->getAttribute(constant( "PDO::ATTR_SERVER_INFO" ));
        }

        return;
    }

    // --------------------------------------------------------------------

    /**
     * Returns the server version
     *
     * @return  string
     */

    public function server_version() {
        if (self::$_instance) {
            return $this->conn->getAttribute(constant( "PDO::ATTR_SERVER_VERSION" ));
        }

        return;
    }

    // --------------------------------------------------------------------

    /**
     * Add database
     *
     * @param   string $table
     * @return  bool
     */

    public function add_database($database) {
        $stmt = 'CREATE DATABASE ' . $database;

        // Create the database
        try {
            $this->execute($stmt);
            return TRUE;
        }
        catch(PDOException $e) {
            log_exception($e);
            return FALSE;
        }
    }

    // --------------------------------------------------------------------

    /**
     * Drop database
     *
     * @param   string $database
     * @return  bool
     */

    public function drop_database($database = NULL) {
        if (!isset($database)) {
            $database = $this->database;
        }

        $stmt = 'DROP DATABASE ' . $database;

        // Drop the database
        try {
            $this->execute($stmt);
            return TRUE;
        }
        catch(PDOException $e) {
            log_exception($e);
            return FALSE;
        }
    }

    // --------------------------------------------------------------------

    /**
     * Add column
     *
     * @param   array $data
     * @param   string $table
     * @return	bool
     */

    public function add_column($data, $table = NULL) {
        if (!isset($table)) {
            $table = $this->table;
        }

        $stmt = 'ALTER TABLE ' . $this->database . '.' . $table . ' ADD COLUMN ';

        // Column name, data type, nullable, auto increment, primary key
        foreach ($data as $column => $array) {
            // All columns except unique and foreign key
            if ($column != 'unique' && $column != 'fk') {
                $num_items = count($array);
                $field_count = 1;

                foreach ($array as $field => $value) {

                    if (($field == 'type' && isset($data[$column]['length'])) || ($field_count == $num_items)) {
                        $stmt .= $value;
                    }
                    else {
                        $stmt .= $value . ' ';
                    }

                    $field_count++;
                }
            }
            // Unique and foreign key
            else {
                $stmt .= ', ADD ';

                foreach ($array as $field => $value) {
                    $stmt .= $value;
                }
            }
        }

        // Add the column
        try {
            $this->execute($stmt);
            return TRUE;
        }
        catch(PDOException $e) {
            log_exception($e);
            return FALSE;
        }
    }

    // --------------------------------------------------------------------

    /**
     * Modify column
     *
     * @param   array $data
     * @param   string $table
     * @return	bool
     */

    public function modify_column($data, $table = NULL) {
        if (!isset($table)) {
            $table = $this->table;
        }

        $stmt = 'ALTER TABLE ' . $this->database . '.' . $table;

        // Column name, data type, nullable, auto increment, primary key
        foreach ($data as $column => $array) {
            // All columns except unique and foreign key
            if ($column != 'unique'  && $column != 'fk') {
                $num_items = count($array);
                $field_count = 1;

                foreach ($array as $field => $value) {

                    if ($field == 'name' && $column != $value) {
                        $stmt .= ' CHANGE COLUMN ' .  $column . ' ' . $value . ' ';
                    }
                    else if ($field == 'name' && $column == $value) {
                        $stmt .= ' MODIFY ' . $value . ' ';
                    }
                    else if (($field == 'type' && isset($data[$column]['length'])) || ($field_count == $num_items)) {
                        $stmt .= $value;
                    }
                    else {
                        $stmt .= $value . ' ';
                    }

                    $field_count++;
                }
            }
            // Unique and foreign key
            else {
                foreach ($array as $field => $value) {
                    if (stristr($value, 'index')) {
                        $stmt .= ', DROP ';
                    }
                    else {
                        $stmt .= ', ADD ';
                    }

                    $stmt .= $value;
                }
            }
        }

        // Modify the column
        try {
            $this->execute($stmt);
            return TRUE;
        }
        catch(PDOException $e) {
            log_exception($e);
            return FALSE;
        }
    }

    // --------------------------------------------------------------------

    /**
     * Drop column
     *
     * @param   string $column
     * @param   string $table
     * @return  bool
     */

    public function drop_column($column, $table = NULL) {
        if (!isset($table)) {
            $table = $this->table;
        }

        $stmt = 'ALTER TABLE ' . $this->database . '.' . $table . ' DROP COLUMN ' . $column;

        // Drop the column
        try {
            $this->execute($stmt);
            return TRUE;
        }
        catch(PDOException $e) {
            log_exception($e);
            return FALSE;
        }
    }

    // --------------------------------------------------------------------

    /**
     * Drop foreign key
     *
     * @param   string $column
     * @param   string $table
     * @return  bool
     */

    public function drop_foreign_key($column, $table = NULL) {
        if (!isset($table)) {
            $table = $this->table;
        }

        $stmt = 'ALTER TABLE ' . $this->database . '.' . $table . ' DROP FOREIGN KEY ' . $column;

        // Drop the foreign key
        try {
            $this->execute($stmt);
            return TRUE;
        }
        catch(PDOException $e) {
            log_exception($e);
            return FALSE;
        }
    }

    // --------------------------------------------------------------------

    /**
     * Create table
     *
     * @usage
     *    Example $data array
     *    The first element in the array will be the primary key by default
     *
     *    $data = array(
     *            'id' => array(
     *                    'name' => 'id'
     *                    'type' => 'int'
     *                    'length' => '(11)'
     *             ),
     *            'name' => array(
     *                    'name' => 'name'
     *                    'type' => 'varchar'
     *                    'length' => '(100)'
     *                    'null' => not null
     *                    'ai' => auto_increment
     *             ),
     *            'unique' => array(
     *                    'name' => 'UNIQUE (name)'
     *             ),
     *            'fk' => array(
     *                    'id' => 'foreign key (id) references table(id)'
     *                    'name' => 'foreign key (name) references table(name)'
     *             )
     *      );
     *
     * @param   array $data
     * @param   string $table
     * @return	void
     */

    public function create_table($data, $table = NULL) {
        if (!isset($table)) {
            $table = $this->table;
        }

        $stmt = 'CREATE TABLE ' . $this->database . '.' . $table . ' (';
        $unique_count = $fk_count = 0;
        $column_count = $key_count = 1;

        // If set move unique to the end of the array
        if (isset($data['unique'])) {
            $temp = $data['unique'];
            unset($data['unique']);
            $data['unique'] = $temp;

            $unique_count = count($data['unique']);
        }

        // If set move foreign key to the end of the array
        if (isset($data['fk'])) {
            $temp = $data['fk'];
            unset($data['fk']);
            $data['fk'] = $temp;

            $fk_count = count($data['fk']);
        }

        $total_columns = count($data) - $unique_count - $fk_count;

        foreach ($data as $column => $array) {

            // All columns except unique and foreign key
            if ($column != 'unique'  && $column != 'fk') {
                $num_items = count($array);
                $field_count = 1;

                foreach ($array as $field => $value) {
                    if (($field == 'type' && isset($data[$column]['length'])) || $field_count == $num_items) {
                        $stmt .= $value;
                    }
                    else {
                        $stmt .= $value . ' ';
                    }

                    $field_count++;
                }

                if ($column_count == 1 && $total_columns == 1) {
                    $stmt .= ' not null auto_increment primary key';
                }
                else if ($column_count == 1) {
                    $stmt .= ' not null auto_increment primary key, ';
                }
                else if ($column_count == count($data)) {
                    break;
                }
                else {
                    $stmt .= ', ';
                }

                $column_count++;
            }
            // Unique and foreign key
            else {
                $num_items = $unique_count + $fk_count;

                foreach ($array as $field => $value) {
                    if ($key_count == $num_items) {
                        $stmt .= $value;
                    }
                    else {
                        $stmt .= $value . ', ';
                    }

                    $key_count++;
                }
            }
        }

        $stmt .= ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';

        // Create the table
        try {
            $this->execute($stmt);
            return TRUE;
        }
        catch(PDOException $e) {
            log_exception($e);
            return FALSE;
        }
    }

    // --------------------------------------------------------------------

    /**
     * Drop table
     *
     * @param   string $table
     * @return  bool
     */

    public function drop_table($table = NULL) {
        if (!isset($table)) {
            $table = $this->table;
        }

        $stmt = 'DROP TABLE ' . $this->database . '.' . $table;

        // Drop the table
        try {
            $this->execute($stmt);
            return TRUE;
        }
        catch(PDOException $e) {
            log_exception($e);
            return FALSE;
        }
    }

    // --------------------------------------------------------------------

    /**
     * Rename table
     *
     * @param   string $new_table_name
     * @param   string $old_table_name
     * @return  bool
     */

    public function rename_table($new_table_name, $old_table_name = NULL) {
        if (!isset($old_table_name)) {
            $old_table_name = $this->table;
        }

        $stmt = 'RENAME TABLE ' . $old_table_name . ' TO ' . $new_table_name;

        // Rename the table
        try {
            $this->execute($stmt);
            return TRUE;
        }
        catch(PDOException $e) {
            log_exception($e);
            return FALSE;
        }
    }

    // --------------------------------------------------------------------

    /**
     * Returns the auto increment value for the next record in a given table
     *
     * @param   string $table
     * @return  int
     */

    public function auto_increment($table = NULL) {
        if (!isset($table)) {
            $table = $this->table;
        }

        $sql = "SELECT auto_increment
                FROM information_schema.tables
                WHERE table_schema = '".$this->database."' AND table_name = '".$table."'";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $query = $stmt->fetch();
            return $query->auto_increment;
        }

        return 0;
    }

    // --------------------------------------------------------------------

    /**
     * Table structure
     *
     * @param   string $table
     * @param   string $column
     * @return  PDOStatement
     */

    public function table_structure($table = '', $column = NULL) {
        $sql = "SELECT COLUMN_NAME AS column_name, DATA_TYPE AS data_type, CHARACTER_MAXIMUM_LENGTH AS char_length, NUMERIC_PRECISION AS num_length, COLUMN_KEY AS column_key, IS_NULLABLE AS nullable
            FROM information_schema.columns
            WHERE TABLE_SCHEMA = '".$this->database."' AND TABLE_NAME = '".$table."'";

        if (isset($column)) {
            $sql .= " AND COLUMN_NAME = '".$column."'";
        }

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt;
    }

    // --------------------------------------------------------------------

    /**
     * Referenced table array
     *
     * @param   string $table
     * @param   string $primary_key
     * @return  object
     */

    public function referenced_table($table = '', $primary_key = '') {
        $sql = "SELECT * FROM information_schema.key_column_usage
            WHERE referenced_table_name IS NOT NULL
            AND table_schema = '".$this->database."'
            AND table_name = '".$table."'
            AND column_name = '".$primary_key."'";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $query = $stmt->fetch();
            return $query;
        }

        return FALSE;
    }

    // --------------------------------------------------------------------

    /**
     * Show tables
     *
     * @param   bool $column_name
     * @return  PDOStatement
     */

    public function show_tables($column_name = FALSE) {

        if ($column_name) {
            $sql = "SELECT table_name, column_name
                FROM INFORMATION_SCHEMA.COLUMNS
                WHERE TABLE_SCHEMA = '".$this->database."' AND COLUMN_KEY = 'PRI'";
        }
        else {
            $sql = "SELECT DISTINCT table_name FROM information_schema.key_column_usage WHERE table_schema = '".$this->database."'";
        }

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt;
    }

    // --------------------------------------------------------------------

    /**
     * Show Referenced tables
     *
     * @return  PDOStatement
     */

    public function show_ref_tables() {
        $sql = "SELECT table_name, column_name, referenced_table_name, referenced_column_name
            FROM information_schema.key_column_usage
            WHERE referenced_table_name is not null AND table_schema = '".$this->database."'";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt;
    }

    // --------------------------------------------------------------------

    /**
     * Gets table field names
     *
     * @param   string $table
     * @return  array
     */

    public function list_fields($table = NULL) {
        if (!isset($table)) {
            $table = $this->database . "." . $this->table;
        }

        $sql = "DESCRIBE " . $table;
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    // --------------------------------------------------------------------

    /**
     * Get table columns
     *
     * @param   string $table
     * @return  PDOStatement
     */

     public function get_columns($table = NULL) {
         if (!isset($table)) {
             $table = $this->table;
         }

         $sql = "SELECT column_name, column_key FROM INFORMATION_SCHEMA.COLUMNS
                WHERE TABLE_SCHEMA = '".$this->database."' AND TABLE_NAME = '".$table."'";

         $stmt = $this->conn->prepare($sql);
         $stmt->execute();

         return $stmt;
     }

    // --------------------------------------------------------------------

    /**
     * Get table primary key
     *
     * @param   string $table
     * @return  mixed
     */

    public function get_table_primary_key($table = NULL) {
        if (!isset($table)) {
            $table = $this->table;
        }

        $sql = "SELECT column_name
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_SCHEMA = '".$this->database."' AND TABLE_NAME = '".$table."' AND COLUMN_KEY = 'PRI'";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $query = $stmt->fetch();
            return $query->column_name;
        }

        return FALSE;
    }

    // --------------------------------------------------------------------

    /**
     * Get tables
     *
     * Returns an array of tables in the database sorted by foreign key constraints
     *
     * @return  array
     */

    public function get_tables() {
        $data = array();
        $sql = "SELECT table_name, referenced_table_name
            FROM information_schema.key_column_usage
            WHERE referenced_table_name IS NOT NULL
            AND table_schema = '".$this->database."'";

            // Get all table names
            $query = $this->show_tables();
            $total_rows = $query->rowCount();

        // Put table names into $data array
        for ($i=0; $i < $total_rows; $i++) {
            $row = $query->fetch(PDO::FETCH_NUM);
            $data[$i] = $row[0];
        }

        // Get a all tables with foreign key constraints
        $query = $this->query($sql);

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            // Find the table name and referenced table name positions in the array
            $table = array_search($row['table_name'], $data);
            $ref = array_search($row['referenced_table_name'], $data);

            // If the referenced table's position is greater than the table's position
            // in the array then swap them.
            if ($ref > $table) {
                $temp = $data[$table];
                $data[$table] = $data[$ref];
                $data[$ref] = $temp;
            }
        }

        return $data;
    }

    // --------------------------------------------------------------------

    /**
     * Create JSON from the database and write the result to the specified file path.
     *
     * @param   string $path
     * @param   array $exclude
     * @return  bool
     */

    public function json_output($path = NULL, $exclude = array()) {
        $output = $end_row = $end_line = '';
        $numeric_type = array('DECIMAL', 'TINY', 'SHORT', 'LONG', 'LONGLONG', 'INT24', 'FLOAT', 'DOUBLE');
        $last_index = 0;

        // Get all table names
        $table = $this->get_tables();
        // Use the current database
        $this->execute('USE ' . $this->database);

        // Loop through all tables to determine the last index
        for ($i = 0; $i < count($table); $i++) {
            $select_query = $this->query("SELECT * FROM " . $table[$i]);
            $total_rows = $select_query->rowCount();

            if ($total_rows > 0 && (in_array($table[$i], $exclude) == FALSE)) {
                $last_index = $i;
            }            
        }

        $output = '[';

        for ($i = 0; $i < count($table); $i++) {
            $primary_key = $pk_output = $field_output = '';

            // Select all from the table
            $select_query = $this->query("SELECT * FROM " . $table[$i]);
            $total_rows = $select_query->rowCount();
            $total_columns = $select_query->columnCount();

            // Only inlude the tables with data also not in the excluded array
            if ($total_rows > 0 && (in_array($table[$i], $exclude) == FALSE)) {

                $output .= "\n\t" . '{' . "\n\t\t" . '"' . $table[$i] . '": [';

                // Get all rows from the table and add to output
                for ($j = 0; $j < $total_rows; $j++) {
                    $row = $select_query->fetch(PDO::FETCH_ASSOC);

                    $output .= "\n\t\t\t" . '{' . "\n\t\t\t\t" . '"table": "' . $table[$i] . '",';

                    // Get the field names for each row and create output
                    for ($k = 0; $k < $total_columns; $k++) {
                        $field = $select_query->getColumnMeta($k);

                        // Use the correct syntax at the end of each row/column
                        if (($total_rows == $j + 1) && ($total_columns == $k + 1)) {
                            $end_row = "\n\t\t\t" . '}';
                            $end_line = '';
                        }
                        else if ($total_columns == $k + 1) {
                            $end_row = "\n\t\t\t" . '},';
                            $end_line = '';
                        }
                        else {
                            $end_line = ',';
                        }

                        // Add field name and values for the correct type to output
                        if (in_array('primary_key', $field['flags']) == TRUE) {
                            $primary_key = "\n\t\t\t\t" . '"primary_key": ' . $row[$field['name']] . $end_line;
                            $pk_output = "\n\t\t\t\t" . '"fields": {' . "\n\t\t\t\t\t" . '"' . $field['name'] . '": ' . $row[$field['name']] . $end_line;
                        }
                        else if ((in_array($field['native_type'], $numeric_type) == TRUE) && is_null($row[$field['name']])) {
                            $field_output .= "\n\t\t\t\t\t" . '"' . $field['name'] . '": ' . 0 . $end_line;
                        }
                        else if (in_array($field['native_type'], $numeric_type) == TRUE) {
                            $field_output .= "\n\t\t\t\t\t" . '"' . $field['name'] . '": ' . $row[$field['name']] . $end_line;
                        }
                        else {
                            $str = trim($row[$field['name']]);
                            $str = addcslashes($str,'/');
                            $str = addcslashes($str,'"');
                            $field_output .= "\n\t\t\t\t\t" . '"' . $field['name'] . '": "' . $str . '"' . $end_line;
                        }
                    }

                    $output .= $primary_key . $pk_output . $field_output . "\n\t\t\t\t" . '}' . $end_row;
                    $primary_key = $pk_output = $field_output = '';
                }

                if ($last_index != $i) {
                    $output .= "\n\t\t" . ']' . "\n\t" . '},';
                }
            }
            else {
                $output .= '';
            }
            
        }

        $output .= "\n\t\t" . ']' . "\n\t" . '}' . "\n" . ']'; 

        // Write the output to the specified file path
        if (isset($path)) {
            file_put_contents($path, $output);
            return true;
        }
        else {
            return false;
        }

    }

    // --------------------------------------------------------------------

    /**
     * Create JSON from the database and write the result to the specified file path (minified version)
     *
     * @param   string $path
     * @param   array $exclude
     * @return  bool
     */

    public function json_output_minified($path = NULL, $exclude = array()) {
        $output = $end_row = $end_line = '';
        $numeric_type = array('DECIMAL', 'TINY', 'SHORT', 'LONG', 'LONGLONG', 'INT24', 'FLOAT', 'DOUBLE');
        $last_index = 0;

        // Get all table names
        $table = $this->get_tables();
        // Use the current database
        $this->execute('USE ' . $this->database);

        // Loop through all tables to determine the last index
        for ($i = 0; $i < count($table); $i++) {
            $select_query = $this->query("SELECT * FROM " . $table[$i]);
            $total_rows = $select_query->rowCount();

            if ($total_rows > 0 && (in_array($table[$i], $exclude) == FALSE)) {
                $last_index = $i;
            }            
        }

        $output = '[';

        for ($i = 0; $i < count($table); $i++) {
            $primary_key = $pk_output = $field_output = '';

            // Select all from the table
            $select_query = $this->query("SELECT * FROM " . $table[$i]);
            $total_rows = $select_query->rowCount();
            $total_columns = $select_query->columnCount();

            // Only inlude the tables with data also not in the excluded array
            if ($total_rows > 0 && (in_array($table[$i], $exclude) == FALSE)) {

                $output .= '{"' . $table[$i] . '":[';

                // Get all rows from the table and add to output
                for ($j = 0; $j < $total_rows; $j++) {
                    $row = $select_query->fetch(PDO::FETCH_ASSOC);

                    $output .= '{"table":"' . $table[$i] . '",';

                    // Get the field names for each row and create output
                    for ($k = 0; $k < $total_columns; $k++) {
                        $field = $select_query->getColumnMeta($k);

                        // Use the correct syntax at the end of each row/column
                        if (($total_rows == $j + 1) && ($total_columns == $k + 1)) {
                            $end_row = '}';
                            $end_line = '';
                        }
                        else if ($total_columns == $k + 1) {
                            $end_row = '},';
                            $end_line = '';
                        }
                        else {
                            $end_line = ',';
                        }

                        // Add field name and values for the correct type to output
                        if (in_array('primary_key', $field['flags']) == TRUE) {
                            $primary_key = '"primary_key":' . $row[$field['name']] . $end_line;
                            $pk_output = '"fields":{"' . $field['name'] . '":' . $row[$field['name']] . $end_line;
                        }
                        else if ((in_array($field['native_type'], $numeric_type) == TRUE) && is_null($row[$field['name']])) {
                            $field_output .= '"' . $field['name'] . '":' . 0 . $end_line;
                        }
                        else if (in_array($field['native_type'], $numeric_type) == TRUE) {
                            $field_output .= '"' . $field['name'] . '":' . $row[$field['name']] . $end_line;
                        }
                        else {
                            $str = trim($row[$field['name']]);
                            $str = addcslashes($str,'/');
                            $str = addcslashes($str,'"');
                            $field_output .= '"' . $field['name'] . '":"' . $str . '"' . $end_line;
                        }
                    }

                    $output .= $primary_key . $pk_output . $field_output . '}' . $end_row;
                    $primary_key = $pk_output = $field_output = '';
                }

                if ($last_index != $i) {
                    $output .= ']},';
                }
            }
            else {
                $output .= '';
            }
            
        }

        $output .= ']}]'; 

        // Write the output to the specified file path
        if (isset($path)) {
            file_put_contents($path, $output);
            return true;
        }
        else {
            return false;
        }

    }

    // --------------------------------------------------------------------

    /**
     * Backup
     *
     * Create a backup .sql file of the database and start the download.
     *
     * @param  string $file_name
     * @return  void
     */

    public function backup($file_name = NULL) {
        $quote = '';
        $output = '';
        $numeric_type = array('DECIMAL', 'TINY', 'SHORT', 'LONG', 'LONGLONG', 'INT24', 'FLOAT', 'DOUBLE');

        // Add database name, generation time, and server version to output
        $output .= "--\n-- Database: " . $this->database . "\n" .
            "-- Generation Time: " . date("F d Y, h:i:s A") . "\n" .
            "-- Server Version: " . $this->server_version() . "\n" .
            "-- PHP Version: " . phpversion() . "\n--\n\n";

        // Get all table names
        $table = $this->get_tables();
        // Use the current database
        $this->execute('USE ' . $this->database);

        for ($i = 0; $i < count($table); $i++) {

            $output .= "-- --------------------------------------------------------\n\n";

            // Add TABLE STRUCTURE and DROP TABLE statements for the table to output
            $output .= "--\n-- Table structure for: " . $table[$i] . "\n--\n\n";
            $output .= "DROP TABLE IF EXISTS `" . $table[$i] . "`;\n\n";

            // Get create table statement for the table and add to output
            $create_query = $this->query("SHOW CREATE TABLE " . $table[$i]);
            $row = $create_query->fetch(PDO::FETCH_ASSOC);
            $output .= $row["Create Table"] . ";\n";

            // Select all from the table
            $select_query = $this->query("SELECT * FROM " . $table[$i]);
            $total_rows = $select_query->rowCount();
            $total_columns = $select_query->columnCount();

            if ($total_rows > 0) {

                // Begin INSERT INTO statement
                $output .= "\nINSERT INTO `" . $table[$i] . "` (";

                // Get all fields for table and add to output after INSERT INTO
                for ($j=0; $j < $total_columns; $j++) {
                    $field = $select_query->getColumnMeta($j);

                    if ($total_columns == ($j + 1)) {
                        $output .= "`" . $field['name'] . "`" . ") VALUES\n";
                    }
                    else {
                        $output .= "`" . $field['name'] . "`" . ", ";
                    }
                }

                // Get all rows from the table and add to output after VALUES
                for ($j=0; $j < $total_rows; $j++) {
                    $row = $select_query->fetch(PDO::FETCH_ASSOC);

                    // Get the field names for each row and create output
                    for ($k = 0; $k < $total_columns; $k++) {
                        $field = $select_query->getColumnMeta($k);

                        if (in_array($field['native_type'], $numeric_type) == FALSE && !empty($row[$field['name']])) {
                            $quote = "'";
                        }

                        // Check for NULL and empty values. Add slashes to other values if needed.
                        if (is_null($row[$field['name']])) {
                            $row[$field['name']] = 'NULL';
                        }
                        else if ($row[$field['name']] === 0) {
                            $row[$field['name']] = 0;
                        }
                        else if (empty($row[$field['name']])) {
                            $row[$field['name']] = "''";
                        }
                        else {
                            $row[$field['name']] = addslashes($row[$field['name']]);
                        }

                        // Create the correct SQL syntax for VALUES
                        if ($k == 0) {
                            $output .= "(" . $quote . $row[$field['name']] . $quote . ", ";
                        }
                        else if ($total_rows == ($j + 1) && $total_columns == ($k + 1)) {
                            $output .= $quote . $row[$field['name']] . $quote . ");\n\n";
                        }
                        else if ($total_columns == ($k + 1)) {
                            $output .= $quote . $row[$field['name']] . $quote . "),\n";
                        }
                        else {
                            $output .= $quote . $row[$field['name']] . $quote . ", ";
                        }

                        $quote = '';
                    }
                }
            }
            else {
                $output .= "\n";
            }
        }

        // Set the filename and force download of the output string
        if (!isset($file_name)) {
            $file_name = $this->database() . '.sql';
        }

        download($file_name, $output);
    }

    // --------------------------------------------------------------------

    /**
     * Restore
     *
     * Restore database from a backup .sql file.
     *
     * @param  string $path
     * @return  void
     */

    public function restore($path = '') {

        try {
            // Use the current database
            $this->execute('USE ' . $this->database);

            // Temporary variable, used to store current query
            $templine = '';

            // Read in entire file
            $lines = file($path);

            // Loop through each line
            foreach ($lines as $line) {
                // Skip it if it's a comment
                if (substr($line, 0, 2) == '--' || $line == '') {
                    continue;
                }

                // Add this line to the current segment
                $templine .= $line;
                // If it has a semicolon at the end, it's the end of the query
                if (substr(trim($line), -1, 1) == ';') {
                    // Perform the query
                    $stmt = $this->conn->prepare($templine);
                    $stmt->execute();

                    // Reset temp variable to empty
                    $templine = '';
                }
            }

            return TRUE;
        }
        catch(PDOException $e) {
            log_exception($e);
            return FALSE;
        }
    }
}