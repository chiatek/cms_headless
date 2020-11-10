<?php

class Category extends CMS_Controller {

    protected $category;
    protected $form_validation;

    // --------------------------------------------------------------------

    /**
     * Class constructor
     *
     * @return	void
     */

    public function __construct() {
        parent::__construct();
        // Create new category
        $this->category = $this->model('Category_model', $this->database);

        // Set form validation rules
        $this->form_validation = $this->library('Form_validation');
        $config = $this->category->config;
        $this->form_validation->set_rules($config);
    }

    // --------------------------------------------------------------------

    /**
     * Index
     *
     * @return	void
     */

    public function index() {
        $fields = $this->category->limit_fields();

        // Set page data and load the view
        $this->data['title'] = config('cms_name') . config('title_separator') . 'Category';
        $this->data['table'] = $this->category->get_table();
        $this->data['query'] = $this->category->get($fields);
        $this->view('pages/content_results', $this->data);
    }

    // --------------------------------------------------------------------

    /**
     * Edit
     *
     * @param   int $pkey_val
     * @return	void
     */

    public function edit($pkey_val = NULL) {
        // Process the form
        if ($this->form_validation->run() == TRUE) {
            if ($this->category->update($_POST, $pkey_val)) {
                $_SESSION['toastr_success'] = $_POST['name']. ' has been saved!';
            }
            redirect('category/edit/'.$pkey_val);
        }

        // Set page data and load the view
        $this->data['title'] = config('cms_name') . config('title_separator') . 'Edit Category';
        $this->data['category_all'] = $this->category->get();
        $this->data['row'] = $this->category->get_first_row(NULL, $pkey_val);
        $this->view('pages/edit_category', $this->data);
    }

    // --------------------------------------------------------------------

    /**
     * Insert
     *
     * @return	void
     */

    public function insert() {
        // Process the form
        if ($this->form_validation->run() == TRUE) {
            if ($this->category->insert($_POST)) {
                $_SESSION['toastr_success'] = $_POST['name']. ' has been created!';
            }
            redirect('category');
        }

        // Set page data and load the view
        $this->data['title'] = config('cms_name') . config('title_separator') . 'New Category';
        $this->data['category_all'] = $this->category->get();
        $this->view('pages/category_new', $this->data);
    }

    // --------------------------------------------------------------------

    /**
     * Delete
     *
     * @return	void
     */

    public function delete() {
        // Process the form or show 404
        if (!empty($_POST)) {

            foreach ($_POST['delete'] as $value) {
                // Delete any foreign key constraints
                $this->category->delete_foreign_key($value, 'post_category', 'post_id');
                // Delete the category
                $this->category->table('category');
                $this->category->delete($value);
            }

            redirect('category');
        }
        else {
            show_error_404();
        }
    }
}