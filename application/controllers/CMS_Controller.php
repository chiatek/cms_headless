<?php

class CMS_Controller extends Controller {

    protected $user;
    protected $setting;
    protected $notification;
    protected $database;
    protected $query;

    // These admin URL's can be accessed without logging in.
    private $exception_urls = array(
        'users/login',
        'users/logout',
        'users/reset_password',
        'users/setup',
        'users/api'
    );

    // These admin URL's can only be accessed by administrators.
    private $admin_urls = array(
        'users',
        'users/edit',
        'users/new'
    );

    // --------------------------------------------------------------------

    /**
     * Class constructor
     *
     * @return	void
     */

    function __construct() {
        parent::__construct();

        // Start the session
        session_start();
        // Load string helper
        $this->helper('string');

        // The user has not yet logged in and is trying to access a restricted page.
        if (in_array(url_string(), $this->exception_urls) == FALSE) {

            // If the database connection fails run CMS setup.
            if (!DB::check_connection()) {
                redirect('users/setup');
                exit;
            }

            // The user is not logged in, redirect to login page.
            if (!isset($_SESSION['user_username'])) {
                redirect('users/login');
                exit;
            }
        }

        // The user is logged in. Load database and get user info.
        if (isset($_SESSION['user_id']) && isset($_SESSION['user_username'])) {
            // Create a new user
            $this->user = $this->model('User_model', $this->db->database());
            $this->setting = $this->model('Settings_model', $this->db->database());
            $this->query = $this->model('Query_model', $this->db->database());

            // Load the user
            $this->data['user'] = $this->user->get_user_info();

            // Load settings and set user database
            $this->data['config'] = $this->setting->get_first_row(NULL, array('user_id' => $_SESSION['user_id']));
            $this->database = $this->data['config']->setting_database;
            $_SESSION['user_api'] = $this->data['config']->setting_api;

            // Load saved queries
            if (isset($this->data['config']->setting_saved_queries)) {
                $this->data['saved_query_menu'] = $this->query->get(NULL, array('user_id' => $_SESSION['user_id'], 'add_to_menu' => 1));
            }

            // Load notifications
            $this->notification = $this->model('Notification_model', $this->db->database());
            $this->data['notifications'] = $this->notification->get_notifications($_SESSION['user_id']);
            $this->data['total_notifications'] = $this->data['notifications']->rowCount();

            // If the user is not administrator restrict access from $admin_urls list.
            if ($this->data['user']->user_role != "administrator") {
                if (in_array(url_string(), $this->admin_urls) == TRUE) {
                    redirect();
                }
            }
        }
    }
}