<?php

class Query_model extends DB {

    protected $table = 'queries';
    protected $primary_key = 'id';
    protected $foreign_key = 'user_id';

    // --------------------------------------------------------------------

    /**
     * Class constructor
     *
     * @return	void
     */

    public function __construct($database) {
        parent::__construct();
        $this->database = $database;
    }

    // --------------------------------------------------------------------

    /**
     * Saved queries
     *
     * @return	PDOStatement
     */

    public function saved_queries() {
        $this->table('queries');
        $select = array('id', 'name', 'table_name', 'referenced_table_name', 'add_to_menu', 'add_to_dashboard');
        $where = array('user_id' => $_SESSION['user_id']);

        $query = $this->get($select, $where);
        return $query;
    }

    // --------------------------------------------------------------------

    /**
     * Get saved query
     *
     * @param    int $id
     * @return	object
     */

    public function get_saved_query($id, $database) {
        $this->table('queries');
        $query = $this->get_first_row(NULL, array('id' => $id));

        if (!empty($query->table_name)) {
            $this->database = $database;
            $this->table($query->table_name);
        }

        if (!empty($query->referenced_table_name) && !empty($query->primary_key) && !empty($query->foreign_key)) {
            $this->primary_key = $query->foreign_key;
            $this->foreign_key = $query->primary_key;
            $saved_query = $this->inner_join($query->referenced_table_name, $query->select_stmt, $query->where_stmt, $query->orderby_stmt, $query->limit_stmt);
        }
        else if (!empty($query->primary_key)) {
            $this->primary_key = $query->primary_key;
            $saved_query = $this->get($query->select_stmt, $query->where_stmt, $query->orderby_stmt, $query->limit_stmt);
        }
        else {
            return NULL;
        }

        return $saved_query;
    }

    // --------------------------------------------------------------------

    /**
     * Save saved query
     *
     * @param   array $data
     * @return	void
     */

    public function save_saved_query($data) {
        $select_stmt = '';

        // Compile select statement
        foreach ($data as $key => $value) {
            $key_name = str_replace_first('@', '.', $key);
            if ($key_name === $value) {
                $select_stmt .= urldecode($value) . ', ';
                unset($data[$key]);
            }
        }

        // Add select_stmt and user_id to data array
        $data += array(
            'select_stmt' => rtrim($select_stmt,', '),
            'user_id' => $_SESSION['user_id']
        );

        $this->table('queries');

        // Create saved query
        if ($this->insert($data)) {
            $_SESSION['toastr_success'] = 'Saved query ' . $data['name'] . ' has been created!';
        }
        else {
            $_SESSION['toastr_error'] = 'Error: Unable to create saved query ' . $data['name'];
        }
    }

    // --------------------------------------------------------------------

    /**
     * Referenced table data
     *
     * @param   int $id
     * @param   bool $foreign_key
     * @return	array
     */

    public function ref_table_data($id, $foreign_key = FALSE) {
        $select = array('name, table_name, referenced_table_name, primary_key, foreign_key');
        $where = array('id' => $id);
        $query = $this->get_first_row($select, $where);

        $data['name'] = $query->name;
        $data['table_name'] = $query->table_name;
        $data['referenced_table_name'] = $query->referenced_table_name;
        $data['primary_key'] = $query->primary_key;
        $data['foreign_key'] = $query->foreign_key;

        if ($foreign_key) {
            $data['primary_key'] = $query->foreign_key;
            $data['foreign_key'] = $query->primary_key;
        }

        return $data;
    }
}