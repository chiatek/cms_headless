<?php

class Database_model extends DB {

    protected $table = '';
    protected $primary_key = '';
    protected $foreign_key = '';
    private $privileges = array('from', 'into', 'update', 'delete', 'table');
    public $config = array(
        'table_name' => array(
            'field' => 'table_name',
            'label' => 'Name',
            'rules' => 'trim|required'
        ),
        'num_columns' => array(
            'field' => 'num_columns',
            'label' => 'Number of Columns',
            'rules' => 'trim|required'
        )
    );

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
     * Upload config
     *
     * @return	array
     */

    public function upload_config() {
        $config = array(
            'upload_path' => ASSETPATH . 'tmp',
            'input_name' => 'userfile',
            'allowed_types' => 'sql',
            'max_size' => 100000
        );

        return $config;
    }

    // --------------------------------------------------------------------

    /**
     * Returns the table name if the sql can be processed, false on failure
     *
     * @param   string $sql
     * @return	string
     */

    public function process_sql($sql) {

        $query_array = explode(" ", strtolower($sql));

        for ($i = 0; $i < count($this->privileges); $i++) {

            if (in_array($this->privileges[$i], $query_array) == TRUE) {
                $table_name = array_search($this->privileges[$i], $query_array) + 1;
                $query = $this->show_tables();

                while($table = $query->fetch()) {
                    if ($table->table_name == $query_array[$table_name]) {
                        return $query_array[$table_name];
                    }
                }
            }
        }

        return FALSE;
    }

    // --------------------------------------------------------------------

    /**
     * Modify column array
     *
     * @param   array $data
     * @param   string $name
     * @param   string $unique
     * @return	array
     */

    public function modify_column_array($data, $name, $unique) {
        $column = array();

        if (!isset($data['column_name'])) {
            return $data;
        }

        foreach ($data as $key => $value) {

            // Column name or value is not set, don't add to the array
            if (empty($value)) {
                continue;
            }

            if ($key == 'column_name') {
                $column[$name]['name'] = $value;
            }

            if ($key == 'column_type') {
                $column[$name]['type'] = $value;
            }

            if ($key == 'num_length') {
                $column[$name]['length'] = '(' . $value . ')';
            }

            if ($key == 'char_length') {
                $column[$name]['length'] = '(' . $value . ')';
            }

            if ($key == 'is_nullable' && $value == 'YES') {
                $column[$name]['null'] = 'NULL';
            }

            if ($key == 'column_key' && $value == 'UNI') {
                $column['unique'][$name] = 'UNIQUE (' . $data['column_name'] . ')';
            }

        }

        if (!isset($column[$name]['null'])) {
            $column[$name]['null'] = 'NOT NULL';
        }

        if (!isset($column['unique'][$name]) && isset($unique)) {
            $column['unique'][$name] = 'INDEX ' . $data['column_name'];
        }

        return $column;
    }

    // --------------------------------------------------------------------

    /**
     * Create table array
     *
     * @param   array $data
     * @return	array
     */

    public function create_table_array($data) {
        $fields = array();
        $name = '';
        $i = $j = 0;

        foreach ($data as $key => $value) {
            $param = explode("_", $key);
            $column = $param[1];
            $index = $param[2];

            // Column name or value is not set, don't add to the array
            if (empty($data['column_name_'.$index]) || empty($value)) {
                continue;
            }

            // Name
            if (strpos($key, 'name')) {
                $name = $value;
                $fields[$name]['name'] = $value;
            }
            // Length
            else if (strpos($key, 'length')) {
                $fields[$name]['length'] = '(' . $value . ')';
            }
            // Unique
            else if (strpos($key, 'unique') && isset($fields[$name]['name'])) {
                $fields['unique'][$name] = 'UNIQUE (' . $fields[$name]['name'] . ')';
            }
            // Foreign Key
            else if (strpos($key, 'fk') && isset($fields[$name]['name'])) {
                $fields['fk'][$name] = 'foreign key (' . $fields[$name]['name'] . ') references ' . $value;
            }
            // All other column types
            else {
                $fields[$name][$column] = $value;
            }
        }

        return $fields;
    }

    // --------------------------------------------------------------------

    /**
     * Display table for edit_table.php
     *
     * @param   object $query
     * @return	array
     */

    public function display_table($query) {
        for ($i = 0; $i < $query->rowCount(); $i++) {
            $row = $query->fetch(PDO::FETCH_ASSOC);

            for ($j = 0; $j < $query->columnCount(); $j++) {
                $col = $query->getColumnMeta($j);

                // If the column is not null make the field required
                if (in_array('not_null', $col['flags']) == TRUE) {
                    $required = ' required';
                }
                else {
                    $required = '';
                }

                echo '<div class="form-group">
                      <label class="form-label" for="'.$col['name'].'">'.$col['name'].'</label>';

                // Column is a primary key
                if (in_array('primary_key', $col['flags']) == TRUE) {
                    echo '<input type="text" class="form-control" name="'.$col['name'].'" form="table-form" value="'.$row[$col['name']].'" readonly>';
                }
                // Column is a foreign key or key|index
                else if (in_array('multiple_key', $col['flags']) == TRUE) {
                    $ref_table = $this->referenced_table($col['table'], $col['name']);

                    if (!empty($ref_table)) {
                        $ref_table_query = $this->query("SELECT ".$ref_table->REFERENCED_COLUMN_NAME." FROM ".$this->database.'.'.$ref_table->REFERENCED_TABLE_NAME);

                        echo '<select class="custom-select" name="'.$col['name'].'" form="table-form">';
                        while ($ref = $ref_table_query->fetch()) {

                            if ($ref->{$ref_table->REFERENCED_COLUMN_NAME} == $row[$col['name']]) {
                                echo '<option value="'.$ref->{$ref_table->REFERENCED_COLUMN_NAME}.'" selected>'.$ref->{$ref_table->REFERENCED_COLUMN_NAME}.'</option>';
                            }
                            else {
                                echo '<option value="'.$ref->{$ref_table->REFERENCED_COLUMN_NAME}.'">'.$ref->{$ref_table->REFERENCED_COLUMN_NAME}.'</option>';
                            }
                        }
                        echo '</select>';
                    }
                    else {
                        // Column is type INT or LONG
                        if ($col['native_type'] == 'INT24' || $col['native_type'] == 'LONG') {
                            echo '<input type="number" class="form-control" name="'.$col['name'].'" form="table-form" value="'.$row[$col['name']].'" '.$required.'>';
                        }
                        // All other column data types
                        else {
                            echo '<input type="text" class="form-control" name="'.$col['name'].'" form="table-form" value="'.$row[$col['name']].'" maxlength="'.$col['len'].'" '.$required.'>';
                        }
                    }
                }
                // Column is type BLOB
                else if ($col['native_type'] == 'BLOB') {
                    echo '<textarea class="form-control" id="summernote" name="'.$col['name'].'" form="table-form" '.$required.'>'.$row[$col['name']].'</textarea>';
                }
                // Column is type DATE
                else if ($col['native_type'] == 'DATE') {
                    echo '<input type="date" class="form-control" name="'.$col['name'].'" form="table-form" value="'.$row[$col['name']].'" '.$required.'>';
                }
                // Column is type DATETIME
                else if ($col['native_type'] == 'DATETIME') {
                    $date = new DateTime($row[$col['name']]);
                    echo '<input type="datetime-local" class="form-control" name="'.$col['name'].'" form="table-form" value="'.$date->format('Y-m-d\TH:i').'" '.$required.'>';
                }
                // Column is type TIME
                else if ($col['native_type'] == 'TIME') {
                    echo '<input type="time" class="form-control" name="'.$col['name'].'" form="table-form" value="'.$row[$col['name']].'" '.$required.'>';
                }
                // Column is type INT or LONG
                else if ($col['native_type'] == 'INT24' || $col['native_type'] == 'LONG' || $col['native_type'] == 'SHORT') {
                    echo '<input type="number" class="form-control" name="'.$col['name'].'" form="table-form" value="'.$row[$col['name']].'" '.$required.'>';
                }
                // Column is type TINY
                else if ($col['native_type'] == 'TINY') {
                    if ($row[$col['name']] == 1) {
                        echo '<div class="form-check-inline">
                            <label class="form-check-label" for="1">
                                <input type="radio" name="'.$col['name'].'" form="table-form" value="1" checked> Yes
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <label class="form-check-label" for="0">
                                <input type="radio" name="'.$col['name'].'" form="table-form" value="0"> No
                            </label>
                        </div>';
                    }
                    else {
                        echo '<div class="form-check-inline">
                            <label class="form-check-label" for="1">
                                <input type="radio" name="'.$col['name'].'" form="table-form" value="1"> Yes
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <label class="form-check-label" for="0">
                                <input type="radio" name="'.$col['name'].'" form="table-form" value="0" checked> No
                            </label>
                        </div>';
                    }
                }
                // Column is type FLOAT
                else if ($col['native_type'] == 'FLOAT' || $col['native_type'] == 'DECIMAL') {
                    echo '<input type="number" step="0.001" class="form-control" name="'.$col['name'].'" form="table-form" value="'.$row[$col['name']].'" '.$required.'>';
                }
                // Column is type VAR STRING and length >= 250
                else if ($col['native_type'] == 'VAR_STRING' && $col['len'] >= 250) {
                    echo '<textarea class="form-control" rows="4" name="'.$col['name'].'" form="table-form" '.$required.'>'.$row[$col['name']].'</textarea>';
                }
                // All other column data types
                else {
                    echo '<input type="text" class="form-control" name="'.$col['name'].'" form="table-form" value="'.$row[$col['name']].'" maxlength="'.$col['len'].'" '.$required.'>';
                }

                echo '</div>';
            }
        }
    }

    // --------------------------------------------------------------------

    /**
     * Display referenced table for edit_table.php
     *
     * @param   object $query
     * @return	array
     */

    public function display_ref_table($query) {
        for ($i = 0; $i < $query->rowCount(); $i++) {
            $row = $query->fetch(PDO::FETCH_ASSOC);

            for ($j = 0; $j < $query->columnCount(); $j++) {
                $col = $query->getColumnMeta($j);

                // If the column is not null make the field required
                if (in_array('not_null', $col['flags']) == TRUE) {
                    $required = ' required';
                }
                else {
                    $required = '';
                }

                echo '<div class="form-group">
                    <label class="form-label" for="'.$col['name'].'">'.$col['name'].'</label>';

                // Column is a primary key
                if (in_array('primary_key', $col['flags']) == TRUE) {
                    echo '<input type="text" class="form-control" name="'.$col['table'].'/'.$col['name'].'/PRI'.'" form="table-form" value="'.$row[$col['name']].'" readonly>';
                }
                // Column is a foreign key or key|index
                else if (in_array('multiple_key', $col['flags']) == TRUE) {
                    $ref_table = $this->referenced_table($col['table'], $col['name']);
                    
                    if (!empty($ref_table)) {
                        $ref_table_query = $this->query("SELECT ".$ref_table->REFERENCED_COLUMN_NAME." FROM ".$this->database.'.'.$ref_table->REFERENCED_TABLE_NAME);

                        echo '<select class="custom-select" name="'.$col['table'].'/'.$col['name'].'" form="table-form">';
                        while ($ref = $ref_table_query->fetch()) {

                            if ($ref->{$ref_table->REFERENCED_COLUMN_NAME} == $row[$col['name']]) {
                                echo '<option value="'.$ref->{$ref_table->REFERENCED_COLUMN_NAME}.'" selected>'.$ref->{$ref_table->REFERENCED_COLUMN_NAME}.'</option>';
                            }
                            else {
                                echo '<option value="'.$ref->{$ref_table->REFERENCED_COLUMN_NAME}.'">'.$ref->{$ref_table->REFERENCED_COLUMN_NAME}.'</option>';
                            }
                        }
                        echo '</select>';
                    }
                    else {
                        // Column is type INT or LONG
                        if ($col['native_type'] == 'INT24' || $col['native_type'] == 'LONG') {
                            echo '<input type="number" class="form-control" name="'.$col['table'].'/'.$col['name'].'" form="table-form" value="'.$row[$col['name']].'" '.$required.'>';
                        }
                        // All other column data types
                        else {
                            echo '<input type="text" class="form-control" name="'.$col['table'].'/'.$col['name'].'" form="table-form" value="'.$row[$col['name']].'" maxlength="'.$col['len'].'" '.$required.'>';
                        }
                    }
                }
                // Column is type BLOB
                else if ($col['native_type'] == 'BLOB') {
                    echo '<textarea class="form-control" id="summernote" name="'.$col['table'].'/'.$col['name'].'" form="table-form" '.$required.'>'.$row[$col['name']].'</textarea>';
                }
                // Column is type DATE
                else if ($col['native_type'] == 'DATE') {
                    echo '<input type="date" class="form-control" name="'.$col['table'].'/'.$col['name'].'" form="table-form" value="'.$row[$col['name']].'" '.$required.'>';
                }
                // Column is type DATETIME
                else if ($col['native_type'] == 'DATETIME') {
                    $date = new DateTime($row[$col['name']]);
                    echo '<input type="datetime-local" class="form-control" name="'.$col['table'].'/'.$col['name'].'" form="table-form" value="'.$date->format('Y-m-d\TH:i').'" '.$required.'>';
                }
                // Column is type TIME
                else if ($col['native_type'] == 'TIME') {
                    echo '<input type="time" class="form-control" name="'.$col['table'].'/'.$col['name'].'" form="table-form" value="'.$row[$col['name']].'" '.$required.'>';
                }
                // Column is type INT or LONG
                else if ($col['native_type'] == 'INT24' || $col['native_type'] == 'LONG' || $col['native_type'] == 'SHORT') {
                    echo '<input type="number" class="form-control" name="'.$col['table'].'/'.$col['name'].'" form="table-form" value="'.$row[$col['name']].'" '.$required.'>';
                }
                // Column is type TINY
                else if ($col['native_type'] == 'TINY') {
                    if ($row[$col['name']] == 1) {
                        echo '<div class="form-check-inline">
                            <label class="form-check-label" for="1">
                                <input type="radio" name="'.$col['table'].'/'.$col['name'].'" form="table-form" value="1" checked> Yes
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <label class="form-check-label" for="0">
                                <input type="radio" name="'.$col['table'].'/'.$col['name'].'" form="table-form" value="0"> No
                            </label>
                        </div>';
                    }
                    else {
                        echo '<div class="form-check-inline">
                            <label class="form-check-label" for="1">
                                <input type="radio" name="'.$col['table'].'/'.$col['name'].'" form="table-form" value="1"> Yes
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <label class="form-check-label" for="0">
                                <input type="radio" name="'.$col['table'].'/'.$col['name'].'" form="table-form" value="0" checked> No
                            </label>
                        </div>';
                    }
                }
                // Column is type FLOAT
                else if ($col['native_type'] == 'FLOAT' || $col['native_type'] == 'DECIMAL') {
                    echo '<input type="number" step="0.001" class="form-control" name="'.$col['table'].'/'.$col['name'].'" form="table-form" value="'.$row[$col['name']].'" '.$required.'>';
                }
                // Column is type VAR STRING and length >= 250
                else if ($col['native_type'] == 'VAR_STRING' && $col['len'] >= 250) {
                    echo '<textarea class="form-control" rows="4" name="'.$col['table'].'/'.$col['name'].'" form="table-form" '.$required.'>'.$row[$col['name']].'</textarea>';
                }
                // All other column data types
                else {
                    echo '<input type="text" class="form-control" name="'.$col['table'].'/'.$col['name'].'" form="table-form" value="'.$row[$col['name']].'" maxlength="'.$col['len'].'" '.$required.'>';
                }

                echo '</div>';
            }
        }
    }

    // --------------------------------------------------------------------

    /**
     * Display table columns
     *
     * @param   string $table
     * @return	void
     */

    public function display_table_columns($table) {
        $table_name = explode('@', $table);

        if (!empty($table_name[2]) && !empty($table_name[3])) {

            $ref_table = $this->remove_duplicate_columns($table_name[0], $table_name[1]);

            echo '<div class="row">'.
                '<div class="col-md-4 mb-3">'.
                '<h5>Table: '.$table_name[0].'</h5>'.

                $this->get_table_columns($table_name[0])

                .'</div>'.
                '<div class="col-md-4">'.
                '<h5>Referenced Table: '.$table_name[1].'</h5>'.

                $this->get_table_columns($table_name[1], $ref_table)

                .'</div></div>'.

                '<input type="hidden" name="table_name" value="'.$table_name[0].'" />'.
                '<input type="hidden" name="referenced_table_name" value="'.$table_name[1].'" />'.
                '<input type="hidden" name="primary_key" value="'.$table_name[3].'" />'.
                '<input type="hidden" name="foreign_key" value="'.$table_name[2].'" />';

        }
        else if (!empty($table_name[0]) && !empty($table_name[1])) {

            echo '<h5>Table: '.$table_name[0].'</h5>'.

                $this->get_table_columns($table_name[0])

                .'<input type="hidden" name="table_name" value="'.$table_name[0].'" />'.
                '<input type="hidden" name="primary_key" value="'.$table_name[1].'" />';
        }
        else {
            echo 'Please go back to the previous step and select a table.';
        }
    }

    // --------------------------------------------------------------------

    /**
     * Get table columns
     *
     * @param   string $table
     * @return	string
     */

    public function get_table_columns($table, $modified_ref_table = NULL) {
        $str = '';

        // Get column names for table
        $this->table($table);
        $query = $this->get_columns($table);

        for ($j=0; $j < $query->rowCount(); $j++) {
            $row = $query->fetch(PDO::FETCH_ASSOC);

            // If the column name was not found in the $modified_ref_table array it is a duplicate. Rename it with an underscore.
            if (isset($modified_ref_table) && in_array($row['column_name'], $modified_ref_table) == FALSE) {
                $row['column_name'] = urlencode($row['column_name'] . ' as ' . $row['column_name'] . '_');
            }

            $str .= '<div class="form-check">
                <label class="form-check-label">';

            if ($row['column_key'] == 'PRI' || $row['column_key'] == 'MUL') {   
                $str .= '<input type="checkbox" class="form-check-input" name="'.$table.'@'.$row['column_name'].'" value="'.$table.'.'.$row['column_name'].'" checked disabled>';
                $str .= '<input type="hidden" name="'.$table.'@'.$row['column_name'].'" value="'.$table.'.'.$row['column_name'].'"/>';
            }
            else {
                $str .= '<input type="checkbox" class="form-check-input" name="'.$table.'@'.$row['column_name'].'" value="'.$table.'.'.$row['column_name'].'">';
            }
                
            $str .= $row['column_name']. '</label></div>';
        }

        return $str;
    }

    // --------------------------------------------------------------------

    /**
     * Remove duplicate columns from the referenced table
     *
     * @param   string $table
     * @param   string $ref_table
     * @return	array
     */

    public function remove_duplicate_columns($table, $ref_table) {
        $table_columns = $ref_table_columns = array();

        // Get column names for table
        $this->table($table);
        $query = $this->get_columns($table);

        for ($i=0; $i < $query->rowCount(); $i++) {
            $row = $query->fetch(PDO::FETCH_ASSOC);
            $table_columns[$i] = $row['column_name'];
        }

        // Get column names for referenced table
        $this->table($ref_table);
        $query = $this->get_columns($ref_table);

        for ($i=0; $i < $query->rowCount(); $i++) {
            $row = $query->fetch(PDO::FETCH_ASSOC);
            $ref_table_columns[$i] = $row['column_name'];
        }

        // removed duplicate values from the referenced table array
        for ($i=0; $i < count($ref_table_columns); $i++) {
            if (in_array($ref_table_columns[$i], $table_columns) == TRUE) {
                unset($ref_table_columns[$i]);
            }
        }
        
        return $ref_table_columns;
    }

    // --------------------------------------------------------------------

    /**
     * Process saved query. Prepare the table data array and update the database.
     *
     * @param   array $table_data
     * @param   array $table
     * @param   int $pkey_val
     * @return	void
     */

    public function process_saved_query($table_data, $table, $pkey_val) {
        $fkey_val = NULL;
        $ref_table_data = array();

        // Get the primary key for the table if it is not set
        $table['primary_key'] = $this->get_table_primary_key($table['table_name']);

        // Set table and primary key
        $this->table($table['table_name']);
        $this->primary_key($table['primary_key']);

        // Get referenced table data and put it into the $ref_table_data array
        // Remove referenced table data from the $table_data array
        foreach ($table_data as $key => $value) {
            $table_array = explode('/', $key);
            if (isset($table_array[2]) && $table_array[2] == 'PRI') {
                $fkey_val = $value;
            }

            if (isset($table_array[1])) {
                $ref_table_data[$table_array[1]] = $value;
                unset($table_data[$key]);
            }
        }

        // Update table
        if ($this->update($table_data, $pkey_val)) {
            $_SESSION['toastr_success'] = 'Table ' . $table['table_name'] . ' has been saved!';
        }

        // Update referenced table
        if (!empty($table['referenced_table_name'])) {
            // Set referenced table and primary key
            $this->table($table['referenced_table_name']);
            $this->primary_key($table['foreign_key']);

            if ($this->update($ref_table_data, $fkey_val)) {
                $_SESSION['toastr_success'] = 'Tables ' . $table['table_name'] . ' and ' . $table['referenced_table_name'] . ' have been saved!';
            }
        }
    }
}