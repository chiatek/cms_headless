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

require_once 'DB_utility.php';

class DB extends DB_utility {

    protected $table = NULL;
    protected $primary_key = NULL;
    protected $foreign_key = NULL;
    protected $exception_fields = NULL;
	protected $field_limit = 6;

    // --------------------------------------------------------------------

    /**
     * Class constructor
     *
     * Sets the database connection
     *
     * @return	void
     */

    public function __construct() {
        parent::__construct();
    }

    // --------------------------------------------------------------------

    /**
     * Returns and instance of the database class
     *
     * @return	self
     */

    public static function get_instance() {

        if (!self::$_instance) {
            self::$_instance = new DB();
        }

        return self::$_instance;
    }

    // --------------------------------------------------------------------

    /**
     * Checks if the database is connected
     *
     * @return	bool
     */

    public static function check_connection() {
        if (!self::$_instance) {
            return FALSE;
        }

        return TRUE;
    }

    // --------------------------------------------------------------------

    /**
     * Returns the database connection
     *
     * @return	database connection
     */

    public function get_connection() {
        return $this->conn;
    }

    // --------------------------------------------------------------------

    /**
     * Closes the database connection
     *
     * @return	void
     */

    public function close_connection() {
        $this->conn = NULL;
    }

    // --------------------------------------------------------------------

    /**
     * Set table
     *
     * @param   string $table
     * @return	void
     */

    public function table($table) {
        $this->table = $table;
    }

    // --------------------------------------------------------------------

    /**
     * Set primary key
     *
     * @param   string $primary_key
     * @return	void
     */

    public function primary_key($primary_key) {
        $this->primary_key = $primary_key;
    }

    // --------------------------------------------------------------------

    /**
     * Set foreign key
     *
     * @param   string $foreign_key
     * @return	void
     */

    public function foreign_key($foreign_key) {
        $this->foreign_key = $foreign_key;
    }

    // --------------------------------------------------------------------

    /**
     * Get table
     *
     * @return object
     */

    public function get_table() {
        return $this->table;
    }

    // --------------------------------------------------------------------

    /**
     * Get primary key
     *
     * @return	object
     */

    public function get_primary_key() {
        return $this->primary_key;
    }

    // --------------------------------------------------------------------

    /**
     * Returns the database instance name
     *
     * @return	string
     */

    public static function _database() {
        return self::$_database;
    }

    // --------------------------------------------------------------------

    /**
     * Get current database name
     *
     * @return	string
     */

    public function database() {
        return $this->database;
    }

    // --------------------------------------------------------------------

    /**
     * Set database name
     *
     * @return	string
     */

    public function set_database($database) {
        $this->database = $database;
    }

    // --------------------------------------------------------------------

    /**
     * Execute query
     *
     * @param   string $sql
     * @return	bool
     */

    public function execute($sql = NULL) {

        if (isset($sql)) {
            $this->conn->exec($sql);
            return TRUE;
        }

        return FALSE;
    }

    // --------------------------------------------------------------------

    /**
     * Query the database with the supplied sql statement
     *
     * @param   string $sql
     * @return	mixed
     */

    public function query($sql = NULL) {

        if (isset($sql)) {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt;
        }

        return FALSE;
    }

    // --------------------------------------------------------------------

    /**
     * Query the database and return the first row only
     *
     * @param   string $sql
     * @return	mixed
     */

    public function query_first_row($sql = NULL) {

        if (isset($sql)) {

            if (strpos($sql, "LIMIT") === FALSE) {
                $sql .= " LIMIT 1";
            }

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return $stmt->fetch();
            }

        }

        return FALSE;
    }

    // --------------------------------------------------------------------

    /**
     * Select data from the database
     *
     * @Usage:
     *      All:      $this->get();
     *      Single:   $this->get(2);
     *      Custom:   $this->get(array('any' => 'param'));
     *
     * @param   mixed $select
     * @param   mixed $where
     * @param   mixed $order_by
     * @param   mixed $limit
     * @return  PDOStatement
     */

    public function get($select = NULL, $where = NULL, $order_by = NULL, $limit = NULL) {

        $sql = $this->select($select);
        $sql .= $this->where($where);
        $sql .= $this->order_by($order_by);
        $sql .= $this->limit($limit);
    
        $stmt = $this->conn->prepare($sql);

        if (is_array($where)) {
            $stmt->execute($where);
        }
        else if (is_numeric($where)) {
            $stmt->execute([$this->primary_key => $where]);
        }
        else {
            $stmt->execute();
        }

        return $stmt;
    }

    // --------------------------------------------------------------------

    /**
     * Select data from the database, return the first row only as an array
     *
     * @Usage:
     *      All:      $this->get();
     *      Single:   $this->get(2);
     *      Custom:   $this->get(array('any' => 'param'));
     *
     * @param   mixed $select
     * @param   mixed $where
     * @param   mixed $order_by
     * @return  array
     */

    public function get_first_row($select = NULL, $where = NULL, $order_by = NULL) {

        $stmt = $this->get($select, $where, $order_by, 1);

        if ($stmt->rowCount() > 0) {
            return $stmt->fetch();
        }

        return FALSE;
    }

    // --------------------------------------------------------------------

    /**
     * Insert data into the database
     *
     * @param   array $data
     * @param   bool $placeholder
     * @return	int
     */

    public function insert($data, $placeholder = TRUE) {

        if (is_array($data)) {
            foreach ($data as $key => $value) {
                if (empty($value) && !is_numeric($value)) {
                    unset($data[$key]);
                }
            }
        }
        else {
            show_error_db("Unable to insert data. Input parameter must be an array.");
        }

        $sql = $this->insert_into($data, $placeholder);
        $stmt = $this->conn->prepare($sql);

        if ($placeholder) {
            $stmt->execute($data);
        }
        else {
            $stmt->execute();
        }

        // Update .json api file
        if (($this->database != self::$_database) && !empty($_SESSION["user_api"])) {
            if (!$this->json_output_minified($_SESSION["user_api"], array("messages"))) {
                show_error_db("A problem occured when creating the following file: " . $_SESSION["user_api"]);
            }
        }

        return $this->conn->lastInsertId();
    }

    // --------------------------------------------------------------------

    /**
     * Update data in the database
     *
     * @Usage:
     *       $result = $this->update(array('password' => 'mypassword'), 26);
     *       $result = $this->update(['login' => 'Ted'], ['date_created' => '0']);
     *       $result = $this->update(
     *               array('password' => 'dog', 'login' => 'steve'),
     *               array('login' => 'joe'));
     *
     * @param   mixed $set
     * @param   mixed $where
     * @param   bool $placeholder
     * @return  int
     */

    public function update($set = NULL, $where = NULL, $placeholder = TRUE) {
        $data = array();

        if (is_numeric($where) && isset($set[$this->primary_key])) {
            unset($set[$this->primary_key]);
        }

        $sql = "UPDATE " . $this->database . "." . $this->table;
        $sql .= $this->set($set, $placeholder);
        $sql .= $this->where($where, $placeholder);

        $stmt = $this->conn->prepare($sql);

        if (is_array($set) && is_array($where)) {
            $data = array_merge($set, $where);
        }
        else if (is_array($set) && is_numeric($where)) {
            $data = array_merge($set, [$this->primary_key => $where]);
        }
        else if (is_numeric($set) && is_array($where)) {
            $data = array_merge([$this->primary_key => $set], $where);
        }
        else if (is_numeric($set) && is_numeric($where)) {
            $data = array_merge([$this->primary_key => $set], [$this->primary_key => $where]);
        }
        else {
            show_error_db("A problem occured when updating table " . $this->database . "." . $this->table . "<br /><br />" . $sql);
        }

        if ($placeholder) {
            $stmt->execute($data);
        }
        else {
            $stmt->execute();
        }

        // Update .json api file
        if (($this->database != self::$_database) && !empty($_SESSION["user_api"])) {
            if (!$this->json_output_minified($_SESSION["user_api"], array("messages"))) {
                show_error_db("A problem occured when creating the following file: " . $_SESSION["user_api"]);
            }
        }

        return $stmt->rowCount();
    }

    // --------------------------------------------------------------------

    /**
     * Delete data from the database
     *
     * @usage
     *       $this->delete(6);
     *       $this->delete(array('name' => 'steve'));
     *
     * @param   mixed $id
     * @param   bool $placeholder
     * @return  int
     */

    public function delete($id = NULL, $placeholder = TRUE) {

        $sql = "DELETE FROM " . $this->database . "." . $this->table;
        $sql .= $this->where($id, $placeholder);

        $stmt = $this->conn->prepare($sql);

        if ($placeholder == FALSE) {
            $stmt->execute();
        }
        else if (is_array($id)) {
            $stmt->execute($id);
        }
        else if (is_numeric($id)) {
            $stmt->execute([$this->primary_key => $id]);
        }
        else {
            show_error_db("Unable to delete from table: " . $this->database . "." . $this->table . "<br /><br />" . $sql);
        }

        // Update .json api file
        if (($this->database != self::$_database) && !empty($_SESSION["user_api"])) {
            if (!$this->json_output_minified($_SESSION["user_api"], array("messages"))) {
                show_error_db("A problem occured when creating the following file: " . $_SESSION["user_api"]);
            }
        }

        return $stmt->rowCount();
    }

    // --------------------------------------------------------------------

    /**
     * INNER JOIN clause to combine rows from two or more tables
     *
     * @param   string $table
     * @param   mixed $select
     * @param   mixed $where
     * @param   mixed $order_by
     * @param   mixed $limit
     * @return	PDOStatement
     */

    public function inner_join($table = NULL, $select = NULL, $where = NULL, $order_by = NULL, $limit = NULL) {

        $sql = $this->select($select);
        $sql .= $this->_inner_join($table);
        $sql .= $this->where($where, FALSE);
        $sql .= $this->order_by($order_by);
        $sql .= $this->limit($limit);
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt;
    }

    // --------------------------------------------------------------------

    /**
     * LEFT JOIN clause to combine rows from two or more tables
     *
     * @param   string $table
     * @param   mixed $select
     * @param   mixed $where
     * @param   mixed $order_by
     * @param   mixed $limit
     * @return	PDOStatement
     */

    public function left_join($table = NULL, $select = NULL, $where = NULL, $order_by = NULL, $limit = NULL) {

        $sql = $this->select($select);
        $sql .= $this->_left_join($table);
        $sql .= $this->where($where, FALSE);
        $sql .= $this->order_by($order_by);
        $sql .= $this->limit($limit);

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt;
    }

    // --------------------------------------------------------------------

    /**
     * Returns SELECT portion of SQL statement
     *
     * @param   mixed $data
     * @return	string
     */

    public function select($data = NULL) {
        $sql = "SELECT ";

        if (is_array($data)) {
            for ($i = 0; $i < count($data); $i++) {
                if ($i == count($data)-1) {
                    $sql .= $data[$i];
                }
                else {
                    $sql .= $data[$i] . ", ";
                }
            }
        }
        else if (!empty($data)) {
            $sql .= $data;
        }
        else {
            $sql .= "*";
        }

        $sql .= " FROM " . $this->database . "." . $this->table;

        return $sql;
    }

    // --------------------------------------------------------------------

    /**
     * Return WHERE portion of SQL statement
     *
     * @param   mixed $data
     * @param   bool $placeholder
     * @return	string
     */

    public function where($data = NULL, $placeholder = TRUE) {
        $index = 1;
        $sql = " WHERE ";

        if (is_array($data)) {
            foreach ($data as $key => $value) {
                if ($index == count($data) || count($data) == 1) {
                    if ($placeholder) {
                        $sql .= $key . " = :" . $key;
                    }
                    else {
                        $sql .= $key . " = " . $value;
                    }
                }
                else {
                    if ($placeholder) {
                        $sql .= $key . " = :" . $key . " AND ";
                    }
                    else {
                        $sql .= $key . " = " . $value . " AND ";
                    }
                    $index++;
                }
            }
        }
        else if (is_numeric($data)) {
            if ($placeholder) {
                $sql .= $this->primary_key . " = :" . $this->primary_key;
            }
            else {
                $sql .= $this->primary_key . " = " . $data;
            }
        }
        else if (!empty($data)) {
            $sql .= $data;
        }
        else {
            $sql = "";
        }

        return $sql;
    }

    // --------------------------------------------------------------------

    /**
     * Returns SET portion of SQL statement
     *
     * @param   mixed $data
     * @param   bool $placeholder
     * @return	string
     */

    public function set($data = NULL, $placeholder = TRUE) {
        $index = 1;
        $sql = " SET ";

        if (is_array($data)) {
            foreach ($data as $key => $value) {
                if ($index == count($data) || count($data) == 1) {
                    if ($placeholder) {
                        $sql .= $key . " = :" . $key;
                    }
                    else {
                        $sql .= $key . " = '" . addslashes($value) . "'";
                    }
                }
                else {
                    if ($placeholder) {
                        $sql .= $key . " = :" . $key . ", ";
                    }
                    else {
                        $sql .= $key . " = '" . addslashes($value) . "', ";
                    }
                    $index++;
                }
            }
        }
        else if (is_numeric($data)) {
            if ($placeholder) {
                $sql .= $this->primary_key . " = :" . $this->primary_key;
            }
            else {
                $sql .= $this->primary_key . " = " . $data;
            }
        }
        else if (!empty($data)) {
            $sql .= $data;
        }
        else {
            $sql = "";
        }

        return $sql;
    }

    // --------------------------------------------------------------------

    /**
     * Returns INSERT INTO portion of SQL statement
     *
     * @param   mixed $data
     * @param   bool $placeholder
     * @return	string
     */

    public function insert_into($data = NULL, $placeholder = TRUE) {
        $index = 1;
        $sql = "INSERT INTO " . $this->database . "." . $this->table . " (";

        if (is_array($data)) {
            foreach ($data as $key => $value) {
                if ($index == count($data) || count($data) == 1) {
                    $sql .= $key . ") VALUES (";
                    $index = 1;
                }
                else {
                    $sql .= $key . ", ";
                    $index++;
                }
            }

            foreach ($data as $key => $value) {
                if ($index == count($data) || count($data) == 1) {
                    if ($placeholder) {
                        $sql .= ":" . $key . ")";
                    }
                    else {
                        $sql .= "'" . addslashes($value) . "')";
                    }

                }
                else {
                    if ($placeholder) {
                        $sql .= ":" . $key . ", ";
                    }
                    else {
                        $sql .= "'" . addslashes($value) . "', ";
                    }
                    $index++;
                }
            }
        }

        return $sql;
    }

    // --------------------------------------------------------------------

    /**
     * Returns INNER JOIN portion of SQL statement
     *
     * @param   string $table
     * @return	string
     */

    public function _inner_join($table) {

        if (strpos($table, " ") > 0) {
            $sql = " INNER JOIN " . $this->database.".".$table;
        }
        else if (isset($table) && $this->foreign_key != NULL) {
            $sql = " INNER JOIN " . $this->database.".".$table . " ON " . $table.".".$this->foreign_key.' = '.$this->table.'.'.$this->primary_key;
        }
        else if (isset($table)) {
            $sql = " INNER JOIN " . $this->database.".".$table . " ON " . $table.".".$this->primary_key.' = '.$this->table.'.'.$this->primary_key;
        }
        else {
            show_error_db("Inner Join Error: table parameter required");
        }

        return $sql;
    }

    // --------------------------------------------------------------------

    /**
     * Returns LEFT JOIN portion of SQL statement
     *
     * @param   string $table
     * @return	string
     */

    public function _left_join($table) {

        if (strpos($table, " ") > 0) {
            $sql = " LEFT JOIN " . $this->database.".".$table;
        }
        else if (isset($table) && $this->foreign_key != NULL) {
            $sql = " LEFT JOIN " . $this->database.".".$table . " ON " . $table.".".$this->foreign_key.' = '.$this->table.'.'.$this->primary_key;
        }
        else if (isset($table)) {
            $sql = " LEFT JOIN " . $this->database.".".$table . " ON " . $table.".".$this->primary_key.' = '.$this->table.'.'.$this->primary_key;
        }
        else {
            show_error_db("Left Join Error: table parameter required");
        }

        return $sql;
    }

    // --------------------------------------------------------------------

    /**
     * Returns LIMIT portion of SQL statement
     *
     * @param   string $data
     * @return	string
     */

    public function limit($data) {

        if (is_numeric($data)) {
            $sql = " LIMIT " . $data;
            return $sql;
        }

        return " " . $data;
    }

    // --------------------------------------------------------------------

    /**
     * Returns ORDER BY portion of SQL statement
     *
     * @param   string $data
     * @return	string
     */

    public function order_by($data) {
        $sql = '';

        if (!empty($data)) {
            $sql .= " ORDER BY " . $data;
        }

        return $sql;
    }

    // --------------------------------------------------------------------

    /**
     * Removes the fields listed in the $exception_fields array and limits
     * the number of results based on the field_limit config item.
     *
     * @return	array
     */

    public function limit_fields($field_seperator = NULL) {
        $fields = array();
        $query = $this->list_fields();

        for ($i = 0; $i < count($query); $i++) {

            if (isset($field_seperator)) {
                $str = explode($field_seperator, $query[$i]);
                $field_name = $query[$i] . ' as "' . $str[1] . '"';
            }
            else {
                $field_name = $query[$i];
            }

            if (in_array($query[$i], $this->exception_fields) == FALSE) {
                if ($i == config('field_limit') + 1) {
                    break;
                }
                else {
                    array_push($fields, $field_name);
                }
            }

        }

        return $fields;
    }

    // --------------------------------------------------------------------

    /**
     * Deletes the foreign key constraint
     *
     * @param   mixed $id
     * @param   string $table
     * @return  int
     */

    public function delete_foreign_key($id, $table, $foreign_key) {

        $temp = $this->table;
        $this->table = $table;

        $query = $this->get($foreign_key, [$foreign_key => $id]);
        $result = $query->rowCount();

        if ($result > 0) {
            $affected_rows = $this->delete([$foreign_key => $id]);
            return $affected_rows;
        }

        $this->table = $temp;

        return $result;
    }

    // --------------------------------------------------------------------

    /**
     * Returns a SELECT SQL statement
     *
     * @return  string
     */

    public function compile_select() {
        $fields = $this->list_fields();
        $this->field_limit = config('field_limit');
        $field_count = 1;

        foreach ($fields as $field) {
            if (isset($this->field_seperator)) {
                $str = explode($this->field_seperator, $field);
                $field_name = $str[1];
            }
            else {
                $field_name = $field;
            }

            if (is_array($this->exception_fields) && in_array($field, $this->exception_fields) == TRUE) {
                continue;
            }

            if ($field_count == 1) {
                $sql = "SELECT ".$field." as ".$field_name.", ";
            }
            else if ($field_count == count($fields) || $field_count == $this->field_limit) {
                $sql = $sql." ".$field." as ".$field_name;
                break;
            }
            else {
                $sql = $sql." ".$field." as ".$field_name.", ";
            }

            $field_count++;
        }
        $sql = $sql." FROM ".$this->database . "." . $this->table;
        return $sql;
    }

    // --------------------------------------------------------------------

    /**
     * Returns a LEFT JOIN SQL statement
     *
     * @param   string $on
     * @param   string $and
     * @param   string $where
     * @param   string $order_by
     * @param   string $limit
     * @return  string
     */

    public function compile_left_join($on = NULL, $and = NULL, $where = NULL, $order_by = NULL, $limit = NULL) {
        $fields = $this->list_fields();
        $this->field_limit = config('field_limit');
        $field_count = 1;

        foreach ($fields as $field) {
            if (isset($this->field_seperator)) {
                $str = explode($this->field_seperator, $field);
                $field_name = $str[1];
            }
            else {
                $field_name = $field;
            }

            if (is_array($this->exception_fields) && in_array($field, $this->exception_fields) == TRUE) {
                continue;
            }

            if ($field_count == 1) {
                $sql = "SELECT t1.".$field." as ".$field_name.", ";
            }
            else if ($field_count == count($fields) || $field_count == $this->field_limit) {
                $sql = $sql." t1.".$field." as ".$field_name;
                break;
            }
            else {
                $sql = $sql." t1.".$field." as ".$field_name.", ";
            }

            $field_count++;
        }

        $sql = $sql." FROM ".$this->database . "." . $this->table." as t1 LEFT JOIN ".$this->database . "." . $this->table." as t2";

        if ($on) {
            $sql = $sql." ON ".$on;
        }

        if ($and) {
            $sql = $sql." AND ".$and;
        }

        if ($where) {
            $sql = $sql." WHERE ".$where;
        }

        if ($order_by) {
            $sql = $sql." ORDER BY ".$order_by;
        }

        if ($limit) {
            $sql = $sql." LIMIT ".$limit;
        }

        return $sql;
    }
}