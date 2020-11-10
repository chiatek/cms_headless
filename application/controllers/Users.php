<?php

class Users extends CMS_Controller {
    
    protected $form_validation;

    // --------------------------------------------------------------------

    /**
     * Class constructor
     *
     * @return	void
     */

    public function __construct() {
        parent::__construct();
        $this->form_validation = $this->library('Form_validation');
    }

    // --------------------------------------------------------------------

    /**
     * Index
     *
     * @return	void
     */

    public function index() {
        $fields = $this->user->limit_fields("_");

        // Set page data and load the view
        $this->data['title'] = config('cms_name') . config('title_separator') . 'Users';
        $this->data['table'] = $this->user->get_table();
        $this->data['query'] = $this->user->get($fields);
        $this->view('pages/content_results', $this->data);
    }

    /**
     * Edit
     *
     * @param   int $pkey_val
     * @return	void
     */

    public function edit($pkey_val = NULL) {
        // Set form validation rules
        $config = $this->user->config;
        $this->form_validation->set_rules($config);

        // Process the form
        if ($this->form_validation->run() == TRUE) {
            if (empty($_POST['user_birthday'])) {
                $_POST['user_birthday'] = NULL;
            }

            if ($this->user->update($_POST, $pkey_val)) {
                $_SESSION['toastr_success'] = 'User '.$_POST['user_username'].' has been saved!';
            }
            redirect('users/edit/'.$pkey_val);
        }

        // Restrict access if user is not admin
        if ($this->data['user']->user_role != "administrator") {
            redirect();
        }

        // Set page data and load the view
        $this->data['title'] = config('cms_name') . config('title_separator') . 'Edit User';
        $this->data['error'] = -1;
        $this->data['validation_errors'] = $this->form_validation->validation_errors();
        $this->data['pkey_val'] = $pkey_val;
        $this->data['row'] = $this->user->get_first_row(NULL, $pkey_val);
        $this->view('pages/edit_user', $this->data);
    }

    // --------------------------------------------------------------------

    /**
     * Insert
     *
     * @return	void
     */

    public function insert() {
        // Set form validation rules
        $config = $this->user->config;
        $this->form_validation->set_rules($config);

        // Process the form
        if ($this->form_validation->run() == TRUE) {
            $password = $this->user->set_user_password($_POST['user_name'], $_POST['user_email']);
            $_POST += array('user_password' => $password);

            // Create user
            if ($this->user->insert($_POST)) {
                $user = $this->user->get_first_row("user_id", array('user_username' => $_POST['user_username']));

                // Default settings for new user
                $settings = array("setting_saved_queries" => "Favorites", "setting_datetime" => "F Y h:i:s A", "setting_posts" => 0, "setting_dashboard_posts_widget" => 0, "setting_dashboard_GA_widget" => 0,
                    "setting_dashboard_posts" => 0, "setting_dashboard_comments" => 0, "setting_dashboard_GA_chart" => 0, "setting_dashboard_GA_stats" => 0, "user_id" => $user->user_id);

                // Create settings for new user
                $this->user->table("settings");
                if ($this->user->insert($settings)) {
                    $_SESSION['toastr_success'] = 'User '.$_POST['user_username'].' has been created!';
                }
            }

            redirect('users');
        }

        // Set page data and load the view
        $this->data['title'] = config('cms_name') . config('title_separator') . 'New User';
        $this->data['validation_errors'] = $this->form_validation->validation_errors();
        $this->view('pages/user_new', $this->data);
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
                $this->user->delete_foreign_key($value, 'settings', 'user_id');
                $this->user->delete_foreign_key($value, 'notification_user', 'user_id');
                $this->user->delete_foreign_key($value, 'queries', 'user_id');

                // Delete the user
                $this->user->table('users');
                $this->user->delete($value);
            }

            redirect('users');
        }
        else {
            show_error_404();
        }
    }

    // --------------------------------------------------------------------

    /**
     * Notifications
     *
     * @param   int $id
     * @return	void
     */

    public function notifications($id) {
        // Process the form
        if (!empty($id)) {
            $this->notification->table('notification_user');
            $this->notification->update(["nu_dismiss" => 1], ["nu_id" => $id]);
        }
        redirect();
    }

    // --------------------------------------------------------------------

    /**
     * Profile
     *
     * @param   int $pkey_val
     * @return	void
     */

    public function profile($pkey_val = NULL) {
        // Set form validation rules
        $config = $this->user->config;
        $this->form_validation->set_rules($config);

        // Process the form
        if ($this->form_validation->run() == TRUE) {
            if (empty($_POST['user_birthday'])) {
                $_POST['user_birthday'] = NULL;
            }

            if ($this->user->update($_POST, $pkey_val)) {
                $_SESSION['toastr_success'] = 'Your profile has been saved!';
            }
            redirect('users/profile');
        }

        // Get upload folder info for image modal
        $this->helper('file');
        $this->data['media_info'] = get_dir_file_info($this->data['config']->setting_root . '/' . $this->data['config']->setting_media);

        // Set page data and load the view
        $this->data['title'] = config('cms_name') . config('title_separator') . 'Profile';
        $this->data['validation_errors'] = $this->form_validation->validation_errors();
        $this->view('pages/profile', $this->data);
    }

    // --------------------------------------------------------------------

    /**
     * Login
     *
     * @return	void
     */

    public function login() {
        $temp_user = $this->model('User_model', $this->db->database());
        $this->data['error'] = 0;

        // Process the form
        if (!empty($_POST)) {

            // Get user login info
            $user = $temp_user->get_first_row(NULL, array(
                'user_username' => $_POST['username'],
                'user_password' => hash_password($_POST['password'])
            ));

            if (!$user) {
                // Username or password not found
                $this->data['error'] = 1;
            }
            else {
                // Set user session to grant login and update activity
                $_SESSION['user_id'] = $user->user_id;
                $_SESSION['user_username'] = $user->user_username;
                $temp_user->update(array('user_activity' => date("Y-m-d h:i:s")), $user->user_id);
                redirect();
            }
        }

        // Set page data and load the view
        $this->data['title'] = config('cms_name') . config('title_separator') . 'Log In';
        $this->view('pages/login', $this->data);
    }

    // --------------------------------------------------------------------

    /**
     * Setup
     *
     * @return	void
     */

    public function setup() {
        $temp_user = $this->model('User_model', DB::_database());

        if (!DB::check_connection() && !empty($_POST)) {
            // Process the form
            $database = $_POST['db_name'];
            $username = $_POST['db_username'];
            $password = $_POST['db_password'];
            $hostname = $_POST['db_hostname'];

            $temp_user->create_database($database, $hostname, $username, $password);
            $temp_user->restore_database($database, $hostname, $username, $password);
            $temp_user->insert_data($_POST);
        }
        else if (!DB::check_connection()) {
            // Database connetion failed, load CMS setup
            $this->data['title'] = config('cms_name') . config('title_separator') . 'Setup';
            $this->view('pages/setup', $this->data);
        }
        else {
            show_error_404();
        }
    }

    // --------------------------------------------------------------------

    /**
     * Change Password
     *
     * @return	void
     */

    public function change_password() {
        // Set form validation rules
        $config = $this->user->password_config;
        $this->form_validation->set_rules($config);

        // Process the form
        if ($this->form_validation->run() == TRUE) {
            $password = $this->user->get_first_row('user_password', array('user_id' => $_SESSION['user_id']));
            $this->user->change_user_password($password->user_password, $_POST['current_password'], $_POST['new_password'], $_POST['repeat_password']);
        }

        // Set page data and load the view
        $this->data['title'] = config('cms_name') . config('title_separator') . 'Profile';
        $this->data['change_password'] = TRUE;
        $this->view('pages/profile', $this->data);
    }

    // --------------------------------------------------------------------

    /**
     * Reset Password
     *
     * @return	void
     */

    public function reset_password($id = NULL) {

        // Reset password from users/edit
        if ($id) {
            // Process the form (get email from query)
            $user = $this->user->get_first_row('user_email', $id);
            $this->data['error'] = $this->user->reset_user_password($user->user_email);

            // Set page data and load the view
            $this->data['title'] = config('cms_name') . config('title_separator') . 'Edit User';
            $this->data['pkey_val'] = $id;
            $this->data['row'] = $this->user->get_first_row(NULL, $id);
            $this->view('pages/edit_user', $this->data);
        }
        // Reset password from login screen
        else {
            $this->data['error'] = -1;
            // Process the form (get email from $_POST)
            if (!empty($_POST)) {
                $this->data['error'] = $this->user->reset_user_password($_POST['email_address']);
            }

            // Set page data and load the view
            $this->data['title'] = config('cms_name') . config('title_separator') . 'Reset Password';
            $this->view('pages/reset_password', $this->data);
        }

    }

    // --------------------------------------------------------------------

    /**
     * API
     *
     * @return	void
     */

    public function api() {
        if (!empty($_POST) && isset($_POST["database"])) {
            require_once APPPATH . 'models/Api_model.php';
            $api_user = new Api_model($_POST["database"]);

            // Set form validation rules
            $config = $api_user->config;
            $this->form_validation->set_rules($config);
    
            if ($api_user->check_connection() && $this->form_validation->run() == TRUE) {
                $api_user->insert_message($_POST);
                $api_user->update_notifications($_POST);
                
                if (!$api_user->send_email($_POST)) {
                    $this->data["error"] = 1;
                }

                // Set page data and load the view
                $this->data["site_url"] = $api_user->get_site_url($_POST["user"]);
                $this->data["error"] = 0;
                $this->data["user_id"] = $_POST["user"];
                $this->data["title"] = "Contact";
                $this->view('pages/user_api', $this->data);

                $api_user->close_connection();
            }
        }
        else {
            show_error_404();
        }
    }

    // --------------------------------------------------------------------

    /**
     * logout
     *
     * @return	void
     */

    public function logout() {
        session_unset();
        session_destroy();
        redirect('users/login');
    }
}