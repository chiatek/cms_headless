<?php

class Posts extends CMS_Controller {

    protected $post;
    protected $form_validation;

    // --------------------------------------------------------------------

    /**
     * Class constructor
     *
     * @return	void
     */

    public function __construct() {
        parent::__construct();

        $this->helper('file');
        $this->post = $this->model('Post_model', $this->database);

        // Set form validation rules
        $this->form_validation = $this->library('Form_validation');
        $config = $this->post->config;
        $this->form_validation->set_rules($config);
    }

    // --------------------------------------------------------------------

    /**
     * Index
     *
     * @return	void
     */

    public function index() {
        // Get SQL statement for all posts (drafts and published)
        $sql = $this->post->compile_left_join("t1.slug = t2.slug", "t1.modified < t2.modified", "t2.id IS NULL", "t1.modified DESC");

        // Set page data and load the view
        $this->data['title'] = config('cms_name') . config('title_separator') . 'Posts';
        $this->data['table'] = $this->post->get_table();
        $this->data['query'] = $this->post->query($sql);
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
        $category = $this->model('Category_model', $this->database);
        // Process the form
        if ($this->form_validation->run() == TRUE) {

            // Set categories
            $category_id = isset($_POST['category_id']) ? $_POST['category_id'] : NULL;
            $prev_category = isset($_POST['prev_category']) ? $_POST['prev_category'] : NULL;

            if ($_POST['status'] == "published") {
                // Publish the post
                $id = $this->post->publish_post($_POST, $pkey_val);
                $_SESSION['toastr_success'] = $_POST['slug']. ' has been published!';
            }
            else {
                // Save the post
                $id = $this->post->save_post($_POST, $pkey_val);
                $_SESSION['toastr_success'] = $_POST['slug']. ' has been saved!';
            }

            // Update categories
            $category->update_categories($category_id, $prev_category, $id, $pkey_val);
            redirect('posts/edit/'.$id);
        }

        // Get upload folder info for image modal
        $this->data['media_info'] = get_dir_file_info($this->data['config']->setting_root . '/' . $this->data['config']->setting_media);

        // Set categories
        $this->data['category_all'] = $category->get();
        $this->data['category_post'] = $category->inner_join('post_category', NULL, 'post_category.post_id = '.$pkey_val);

        // Load and set posts
        $this->data['post'] = $this->post->get_first_row(NULL, $pkey_val);

        // Set additional page data and load the view
        $this->data['title'] = config('cms_name') . config('title_separator') . 'Edit Post';
        $this->data['pkey_val'] = $pkey_val;
        $this->view('pages/edit_post', $this->data);
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
            $_POST = $this->post->insert_post_array($_POST);
            $pkey_val = $this->post->insert($_POST);
            redirect('posts/edit/'.$pkey_val);
        }

        // Set page data and load the view
        $this->data['title'] = config('cms_name') . config('title_separator') . 'New Post';
        $this->view('pages/post_new', $this->data);
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
                $this->post->delete_foreign_key($value, 'post_category', 'post_id');
                $this->post->delete_foreign_key($value, 'comments', 'post_id');

                // Delete the post
                $this->post->table('posts');
                $this->post->delete($value);
            }

            redirect('posts');
        }
        else {
            show_error_404();
        }
    }

    // --------------------------------------------------------------------

    /**
     * Search
     *
     * @return	void
     */

    public function search() {

        // Get SQL statement for search query
        $sql = $this->post->search_sql($_POST['query']);

        // Set page data and load the view
        $this->data['title'] = config('cms_name') . config('title_separator') . 'Posts Search';
        $this->data['table'] = $this->post->get_table();
        $this->data['query'] = $this->post->query($sql);
        $this->view('pages/content_results', $this->data);
    }
}