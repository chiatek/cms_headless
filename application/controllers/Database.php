<?php

class Database extends CMS_Controller {

    protected $user_database;
    protected $form_validation;

    // These URL's can be accessed by anyone.
    private $not_admin_urls = array(
        'insert_saved_query',
        'edit_saved_query',
        'saved_query',
        'edit_query',
        'insert_query',
        'query',
        'delete'
    );

    // --------------------------------------------------------------------

    /**
     * Class constructor
     *
     * @return	void
     */

    public function __construct() {
        parent::__construct();
        $this->user_database = $this->model('Database_model', $this->database);

        // Restrict access if user is not admin
        if ($this->data['user']->user_role != "administrator" && in_array(segment(3), $this->not_admin_urls) == FALSE) {
            redirect();
        }
    }

    // --------------------------------------------------------------------

    /**
     * Index
     *
     * @return	void
     */

    public function index() {

        // Set page data and load the view (show all database table names)
        $this->data['title'] = config('cms_name') . config('title_separator') . 'Database';
        $this->data['table'] = '';
        $this->data['query'] = $this->user_database->show_tables();
        $this->view('pages/table_results', $this->data);
    }

    // --------------------------------------------------------------------

    /**
     * Query
     *
     * @param   string $table
     * @return	void
     */

    public function query($table = '') {
        // Load database_results (show all records for the table)
        if (!empty($table)) {
            $this->data['title'] = config('cms_name') . config('title_separator') . 'Browse Table';
            $this->user_database->table($table);
            $this->data['table'] = $table;
            $this->data['query'] = $this->user_database->get();
            $this->view('pages/database_results', $this->data);
        }
        // Show error 404
        else {
            show_error_404();
        }
    }

    // --------------------------------------------------------------------

    /**
     * Edit query
     *
     * @param   string $table
     * @param   string $primary_key
     * @param   int $pkey_val
     * @return	void
     */

    public function edit_query($table = '', $primary_key = NULL, $pkey_val = NULL) {
        // Set page data
        $this->data['table'] = $table;
        $this->user_database->table($table);

        // Process form and update the table
        if (!empty($_POST)) {
            // set the primary key
            $this->user_database->primary_key($primary_key);
            // Update the table
            if ($this->user_database->update($_POST, $pkey_val)) {
                $_SESSION['toastr_success'] = 'Table ' . $table . ' has been saved!';
            }
            redirect('database/query/'.$table);
        }
        // Load edit_table (form to edit the selected table record)
        else if (!empty($table) && isset($primary_key) && isset($pkey_val)) {
            $this->user_database->primary_key($primary_key);
            $this->data['title'] = config('cms_name') . config('title_separator') . 'Edit Table';
            $this->data['primary_key'] = $primary_key;
            $this->data['pkey_val'] = $pkey_val;
            $this->data['query'] = $this->user_database->get(NULL, $pkey_val);
            $this->view('pages/edit_table', $this->data);
        }
        // Show error 404
        else {
            show_error_404();
        }
    }

    // --------------------------------------------------------------------

    /**
     * Insert query
     *
     * @param   string $table
     * @return	void
     */

    public function insert_query($table = '') {
        // Set page data
        $this->data['title'] = config('cms_name') . config('title_separator') . 'Insert into table';
        $this->data['table'] = $table;
        $this->user_database->table($table);

        // Process form and insert data for the table
        if (!empty($_POST)) {
            if ($id = $this->user_database->insert($_POST)) {
                $_SESSION['toastr_success'] = $table.' id '.$id.' has been created!';
            }
            redirect('database/query/'.$table);
        }
        // Set additional page data and load the view (new record for the table)
        else {
            $this->data['auto_increment'] = $this->user_database->auto_increment($table);
            $this->data['query'] = $this->user_database->get();
            $this->view('pages/record_new', $this->data);
        }
    }

    // --------------------------------------------------------------------

    /**
     * Column
     *
     * @param   string $table
     * @return	void
     */

    public function column($table = '') {
        // Load column_results (Show all colums for the table)
        if (!empty($table)) {
            $this->data['title'] = config('cms_name') . config('title_separator') . 'Table Structure';
            $this->data['table'] = $table;
            $this->data['query'] = $this->user_database->table_structure($table);
            $this->view('pages/column_results', $this->data);
        }
        // Show error 404
        else {
            show_error_404();
        }
    }

    // --------------------------------------------------------------------

    /**
     * Edit column
     *
     * @param   string $table
     * @param   string $column
     * @param   string $key
     * @return	void
     */

    public function edit_column($table = '', $column = '', $key = NULL) {
        // Set page data
        $this->data['table'] = $table;

        // Process form and modify the column
        if (!empty($_POST)) {
            // Use current database
            $this->user_database->execute('USE ' . $this->database);
            // Format an array using $_POST data needed to modify column
            $data = $this->user_database->modify_column_array($_POST, $column, $key);

            // Modify the column
            if ($this->user_database->modify_column($data, $table)) {
                $_SESSION['toastr_success'] = 'Column has been modified for table ' .$table. '!';
            }
            else {
                $_SESSION['toastr_error'] = 'Error: Unable to modify column';
            }
            redirect('database/column/'.$table);
        }
        // Load edit_column (form to edit the selected table column)
        else if (!empty($table) && !empty($column)) {
            $this->data['title'] = config('cms_name') . config('title_separator') . 'Edit Column';
            $this->data['column_name'] = $column;
            $this->data['query'] = $this->user_database->table_structure($table, $column);
            $this->view('pages/edit_column', $this->data);
        }
        // Show error 404
        else {
            show_error_404();
        }
    }

    // --------------------------------------------------------------------

    /**
     * Insert column
     *
     * @param   string $table
     * @return	void
     */

    public function insert_column($table = '') {
        // Set page data
        $this->data['table'] = $table;
        $this->user_database->table($table);

        // Process form and add the column
        if (!empty($_POST) && !empty($table)) {
            // Use the current database
            $this->user_database->execute('USE ' . $this->database);
            // Format an array using $_POST data needed to add column to table
            $data = $this->user_database->create_table_array($_POST);

            // Add the column
            if ($this->user_database->add_column($data, $table)) {
                $_SESSION['toastr_success'] = 'Column has been added to table ' .$table. '!';
            }
            else {
                $_SESSION['toastr_error'] = 'Error: Unable to add column';
            }
            redirect('database/column/'.$table);
        }
        // Load add_column (new column for the table)
        else if (!empty($table)) {
            $this->data['title'] = config('cms_name') . config('title_separator') . 'Add Column';
            $this->view('pages/add_column', $this->data);
        }
        // Show error 404
        else {
            show_error_404();
        }
    }

    // --------------------------------------------------------------------

    /**
     * Table
     *
     * @param   string $table
     * @return	void
     */

    public function table($table = '') {
        // Set form validation rules
        $this->form_validation = $this->library('Form_validation');
        $config = $this->user_database->config;
        $this->form_validation->set_rules($config);

        // Set page data
        $this->data['table'] = $table;
        $this->user_database->table($table);

        // Process form and create the table
        if (!empty($_POST) && !empty($table)) {
            // Use the current database
            $this->user_database->execute('USE ' . $this->database);
            // Format an array using $_POST data needed to create table
            $data = $this->user_database->create_table_array($_POST);

            // Create the table
            if ($this->user_database->create_table($data, $table)) {
                $_SESSION['toastr_success'] = 'Table ' . $table . ' has been created!';
            }
            else {
                $_SESSION['toastr_error'] = 'Error: Unable to create table ' . $table;
            }
            redirect('database');
        }
        // Load create_table
        else if (!empty($_POST) && $this->form_validation->run() == TRUE) {
            $this->data['title'] = config('cms_name') . config('title_separator') . 'New Table';
            $this->data['table'] = $_POST['table_name'];
            $this->data['columns'] = $_POST['num_columns'];
            $this->view('pages/create_table', $this->data);
        }
        // Load table_new
        else {
            $this->data['title'] = config('cms_name') . config('title_separator') . 'New Table';
            $this->view('pages/table_new', $this->data);
        }
    }

    // --------------------------------------------------------------------

    /**
     * Delete
     *
     * @param   string $table
     * @param   bool $saved_query
     * @return	void
     */

    public function delete($table = NULL) {
        $redirect_path = 'database';

        // Process the form
        if (!empty($_POST)) {

            foreach ($_POST['delete'] as $value) {

                if (isset($table)) {
                    $data = explode('/', $value);

                    // Delete record
                    if (!empty($data[1])) {
                        $this->user_database->table($table);
                        $this->user_database->delete(array($data[0] => $data[1]));
                        $redirect_path = 'database/query/'.$table;
                    }
                    // Delete column
                    else {
                        $this->user_database->table($table);
                        $this->user_database->drop_column($value);
                        $redirect_path = 'database/column/'.$table;
                    }
                }
                // Delete table
                else {
                    $this->user_database->table($value);
                    $this->user_database->drop_table();
                }
            }

            redirect($redirect_path);
        }
        // Show error 404
        else {
            show_error_404();
        }
    }

    // --------------------------------------------------------------------

    /**
     * SQL Query
     *
     * @return	void
     */

    public function sql() {

        // Set page data
        $this->data['title'] = config('cms_name') . config('title_separator') . 'SQL Qquery';

        // Process the form
        if (!empty($_POST)) {

            // Verify sql statement and get table name
            $this->data['table'] = $this->user_database->process_sql($_POST['sql_textarea']);

            // Only execute the query if the table name is returned
            if ($this->data['table']) {
                $this->user_database->execute('USE ' . $this->database);
                $this->data['query'] = $this->user_database->query($_POST['sql_textarea']);

                // SELECT queries
                if ($this->data['query']->columnCount() > 0) {
                    $_SESSION['toastr_success'] = $_POST['sql_textarea'] . '<br />Row count: ' . $this->data['query']->rowCount();
                    $this->view('pages/database_results', $this->data);
                }
                // All other queries with row count > 0
                else if ($this->data['query']->rowCount() > 0) {
                    $_SESSION['toastr_success'] = $_POST['sql_textarea'] . '<br />Row count: ' . $this->data['query']->rowCount();
                    $this->view('pages/sql_query', $this->data);
                }
                // All other queries with row count == 0
                else {
                    $_SESSION['toastr_info'] = 'MySQL returned an empty result set (i.e. zero rows)';
                    $this->view('pages/sql_query', $this->data);
                }

            }
            // The query did not run, load sql_query and show error
            else {
                $_SESSION['toastr_error'] = 'Unable to execute query: <br />' . $_POST['sql_textarea'];
                $this->view('pages/sql_query', $this->data);
            }
        }
        // Load sql_query
        else {
            $this->view('pages/sql_query', $this->data);
        }

    }

    // --------------------------------------------------------------------

    /**
     * Backup / Restore
     *
     * @return	void
     */

    public function archive() {

        // Set page data
        $this->data['title'] = config('cms_name') . config('title_separator') . 'Backup/Restore';

        // Export .sql file
        if (!empty($_POST['backup']) && $this->database == $_POST['backup']) {
            $this->user_database->backup();
        }

        // Get upload configuration
        $upload = $this->library('Upload');
        $config = $this->user_database->upload_config();

        // Upload the file
        if (!$upload->do_upload($config)) {
            // Upload failed
            $this->data['success'] = FALSE;
            $this->data['error'] = $upload->display_errors();
        }
        else {
            // Upload success
            $this->data['upload_data'] = $upload->data();

            if ($this->user_database->restore(ASSETPATH . 'tmp/' . $this->data['upload_data']['File Name'])) {
                // Database restore success
                $this->data['success'] = TRUE;
                $this->data['error'] = ' ';
            }
            else {
                // Databse restore failure
                $this->data['success'] = FALSE;
                $this->data['error'] = 'An error has occured restoring database file: ' . $this->data['upload_data']['File Name'];
            }

            // Delete the temporary .sql file
            unlink(ASSETPATH . 'tmp/' . $this->data['upload_data']['File Name']);
        }
        // Load the view
        $this->view('pages/archive', $this->data);
    }
}