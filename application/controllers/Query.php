<?php

class Query extends CMS_Controller {

    protected $query;

    // --------------------------------------------------------------------

    /**
     * Class constructor
     *
     * @return	void
     */

    public function __construct() {
        parent::__construct();
        $this->user_database = $this->model('Database_model', $this->database);
    }

    // --------------------------------------------------------------------

    /**
     * Index
     *
     * @return	void
     */

    public function index() {

        // Set page data and load the view (show all database table names)
        $this->data['title'] = config('cms_name') . config('title_separator') . 'Saved Queries';
        $this->data['table'] = 'queries';
        $this->data['query'] = $this->query->saved_queries();
        $this->view('pages/saved_query_results', $this->data);
    }

    // --------------------------------------------------------------------

    /**
     * Saved Query
     * Display saved queries, view and edit the results table for that query
     *
     * @param   int $id
     * @param   int $pkey_val
     * @return	void
     */

    public function saved_query($id = NULL, $pkey_val = NULL, $fkey_val = NULL) {
        // Process and update saved query tables
        if (!empty($_POST)) {
            $table = $this->query->ref_table_data($id, TRUE);
            $this->user_database->process_saved_query($_POST, $table, $pkey_val);
            redirect('query/saved_query/'.$id);
        }
        // Load saved query edit form or results table
        else if (isset($id)) {
            $table = $this->query->ref_table_data($id);
            $this->data['title'] = config('cms_name') . config('title_separator') . $table['name'];

            // Set saved query page data
            $this->data['table'] = $table['table_name'];
            $this->data['ref_table'] = $table['referenced_table_name'];
            $this->data['primary_key'] = $table['primary_key'];
            $this->data['foreign_key'] = $table['foreign_key'];
            $this->data['name'] = $table['name'];
            $this->data['id'] = $id;

            // Load edit_table
            if (isset($pkey_val)) {

                // Get the primary key
                $primary_key = $this->user_database->get_table_primary_key($table['table_name']);

                // Get query for table
                $this->user_database->table($this->data['table']);
                $this->data['pkey_val'] = $pkey_val;
                $this->data['query'] = $this->user_database->get(NULL, array($primary_key => $pkey_val));

                // Get query for referenced table
                if (!empty($this->data['ref_table']) && isset($fkey_val)) {
                    $this->user_database->table($this->data['ref_table']);
                    $this->data['fkey_val'] = $fkey_val;
                    $this->data['ref_query'] = $this->user_database->get(NULL, array($this->data['primary_key'] => $fkey_val));
                }

                // Load the view (form to edit the selected table record(s))
                $this->view('pages/edit_table', $this->data);
            }
            // Load query_results (show all records for the selected table)
            else {
                // Load saved queries
                if (!empty($this->data['config']->setting_saved_queries)) {
                    $this->data['saved_query_list'] = $this->query->get(NULL, array('user_id' => $_SESSION['user_id'], 'add_to_menu' => 1));
                }

                //$this->data['query'] = $this->query->query('SELECT comments.id as testid, comments.post_id, comments.date, comments.name, posts.id, posts.title, posts.slug, posts.author FROM blog_sample.comments INNER JOIN blog_sample.posts ON posts.id = comments.post_id');
                $this->data['query'] = $this->query->get_saved_query($id, $this->database);
                $this->view('pages/query_results', $this->data);
            }
        }
        // Load saved_query_results (show all saved queries)
        else {
            $this->data['title'] = config('cms_name') . config('title_separator') . 'Saved Queries';
            $this->data['table'] = 'queries';
            $this->data['query'] = $this->query->saved_queries();
            $this->view('pages/saved_query_results', $this->data);
        }
    }

    // --------------------------------------------------------------------

    /**
     * Edit saved query
     *
     * @param   string $table
     * @param   string $primary_key
     * @param   int $pkey_val
     * @return	void
     */

    public function edit_saved_query($table = '', $primary_key = NULL, $pkey_val = NULL) {
        // Chnage the user_database to default and set table
        $this->query->table($table);

        // Process form and update saved queries
        if (!empty($_POST)) {
            // set the primary key
            $this->query->primary_key($primary_key);

            if (empty($_POST['limit_stmt'])) {
                $_POST['limit_stmt'] = NULL;
            }

            // Update the table
            if ($this->query->update($_POST, $pkey_val)) {
                $_SESSION['toastr_success'] = 'Saved query has been updated!';
            }
            redirect('query/saved_query');
        }
        // Load edit_table
        else if (!empty($table) && isset($primary_key) && isset($pkey_val)) {
            $this->data['title'] = config('cms_name') . config('title_separator') . 'Edit Saved Query';

            // Set primary key
            $this->query->primary_key($primary_key);

            // Set page data
            $this->data['table'] = $table;
            $this->data['primary_key'] = $primary_key;
            $this->data['pkey_val'] = $pkey_val;

            // SELECT * FROM queries WHERE id = $pkey_val
            // Generate query and load the view (form to edit saved query)
            $this->data['query'] = $this->query->get(NULL, $pkey_val);

            $this->view('pages/edit_table', $this->data);
        }
        // Show error 404
        else {
            show_error_404();
        }
    }

    // --------------------------------------------------------------------

    /**
     * Insert saved query
     * Loads wizard and saves the new query
     *
     * @param   string $table
     * @return	void
     */

    public function insert_saved_query($table = NULL) {
        // Display table column checkboxes in the saved query wizard using AJAX
        if (isset($table)) {
            $this->user_database->display_table_columns($table);
        }
        // Process the form and save the saved query
        else if (!empty($_POST)) {
            $this->query->save_saved_query($_POST);
            redirect('query/saved_query');
        }
        // Load query_new (new saved query wizard)
        else {
            $this->data['title'] = config('cms_name') . config('title_separator') . 'New Saved Query';

            $this->data['tables'] = $this->user_database->show_tables(TRUE);
            $this->data['ref_tables'] = $this->user_database->show_ref_tables();

            $this->view('pages/query_new', $this->data);
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

        // Process the form
        if (!empty($_POST)) {

            foreach ($_POST['delete'] as $value) {

                $data = explode('/', $value);

                // Delete saved query
                if (!empty($data[1])) {
                    $this->query->delete(array($data[0] => $data[1]));
                }
            }

            redirect('query/saved_query');
        }
        // Show error 404
        else {
            show_error_404();
        }
    }
}