<?php

class Comments extends CMS_Controller {

    protected $comments;

    // --------------------------------------------------------------------

    /**
     * Class constructor
     *
     * @return	void
     */

    public function __construct() {
        parent::__construct();
        $this->post = $this->model('Post_model', $this->database);
        $this->comments = $this->model('Comment_model', $this->database);
    }

    // --------------------------------------------------------------------

    /**
     * Index
     *
     * @return	void
     */

    public function index() {
        // Set page data and load the view
        $this->data['title'] = config('cms_name') . config('title_separator') . 'Comments';
        $this->data['table'] = $this->comments->get_table();
        $this->data['query'] = $this->comments->get(array("id", "date", "name", "email", "website", "status"));
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
        if (!empty($_POST) && isset($pkey_val)) {
            if ($this->comments->update($_POST, $pkey_val)) {
                $_SESSION['toastr_success'] = 'Comment status has been saved!';
            }
            redirect('comments');
        }

        // Set page data and load the view
        $this->data['title'] = config('cms_name') . config('title_separator') . 'Edit Comment';
        $this->data['comment'] = $this->comments->get_first_row(NULL, $pkey_val);
        $this->view('pages/edit_comment', $this->data);
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
            // Delete the comment
            foreach ($_POST['delete'] as $_value) {
                $this->comments->delete($_value);
            }

            redirect('comments');
        }
        else {
            show_error_404();
        }
    }
}