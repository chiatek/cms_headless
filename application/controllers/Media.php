<?php

class Media extends CMS_Controller {

    protected $media;

    // --------------------------------------------------------------------

    /**
     * Class constructor
     *
     * @return	void
     */

    public function __construct() {
        parent::__construct();

        $this->helper('file');
        $this->media = $this->model('Media_model');
    }

    // --------------------------------------------------------------------

    /**
     * Index
     *
     * @return	void
     */

    public function index() {
        header("Access-Control-Allow-Origin: *");
        // Set page data and load the view
        $this->data['title'] = config('cms_name') . config('title_separator') . 'Media';
        $this->data['file_type'] = 'media';
        $this->data['file_info'] = get_dir_file_info($this->data['config']->setting_root . '/' . $this->data['config']->setting_media);
        $this->view('pages/file_results', $this->data);
    }

    // --------------------------------------------------------------------

    /**
     * Edit
     *
     * @param   string $file_name
     * @return	void
     */

    public function edit($file_name) {
        header("Access-Control-Allow-Origin: *");
        // Set page data and load the view
        $this->data['title'] = config('cms_name') . config('title_separator') . 'Edit Image';
        $this->data['file_name'] = $file_name;
        $this->data['file_path'] = $this->data['config']->setting_url . '/' . $this->data['config']->setting_media;
        $this->view('pages/edit_image', $this->data);
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
            if(!delete_files($_POST['delete'])) {
                $_SESSION['toastr_error'] = 'Error - Unable to delete file(s)';
            }
            redirect('media');
        }
        else {
            show_404();
        }
    }

    // --------------------------------------------------------------------

    /**
     * Upload
     *
     * @return	void
     */

    public function upload() {
        // Set page data and load the view
        $this->data['title'] = config('cms_name') . config('title_separator') . 'Upload Image';
        $this->data['error'] = ' ';
        $this->data['success'] = FALSE;
        $this->view('pages/media_new', $this->data);
    }

    // --------------------------------------------------------------------

    /**
     * AJAX Upoad
     *
     * @param   string $file_name
     * @return	void
     */

    public function ajax_upload($file_name) {
        header("Access-Control-Allow-Origin: *");
        // Set target directory
        $target_dir = $this->data['config']->setting_root . '/' . $this->data['config']->setting_media;
        $target_file = $target_dir."/".$file_name;

        // Get uploaded file and move to target directory
        $file_to_upload = $_FILES['croppedImage']['tmp_name'];
        move_uploaded_file($file_to_upload, $target_file);

        redirect('media');
    }

    // --------------------------------------------------------------------

    /**
     * Do Upload
     *
     * @return	void
     */

    public function do_upload() {
        // Get upload configuration
        $upload = $this->library('Upload');
        $config = $this->media->upload_config($this->data['config']->setting_root . '/' . $this->data['config']->setting_media);

        if (!$upload->do_upload($config)) {
            // Upload failed
            $this->data['success'] = FALSE;
            $this->data['error'] = $upload->display_errors();
        }
        else {
            // Upload success
            $this->data['success'] = TRUE;
            $this->data['error'] = ' ';
            $this->data['upload_data'] = $upload->data();
        }

        // Set page data and load the view
        $this->data['title'] = config('cms_name') . config('title_separator') . 'Media Upload Success';
        $this->view('pages/media_new', $this->data);
    }
}