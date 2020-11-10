<?php

class User_model extends DB {

    protected $table = 'users';
    protected $primary_key = 'user_id';
    protected $key_file_location = NULL;
    protected $exception_fields = array(
        'user_password'
    );
    public $config = array(
        'user_username' => array(
            'field' => 'user_username',
            'label' => 'Username',
            'rules' => 'trim|required'
        ),
        'user_name' => array(
            'field' => 'user_name',
            'label' => 'Name',
            'rules' => 'trim|required'
        ),
        'user_email' => array(
            'field' => 'user_email',
            'label' => 'E-mail',
            'rules' => 'trim|required|email'
        )
    );
    public $password_config = array(
        'current_password' => array(
            'field' => 'current_password',
            'label' => 'Current password',
            'rules' => 'trim|required'
        ),
        'new_password' => array(
            'field' => 'new_password',
            'label' => 'New password',
            'rules' => 'trim|required|length(5,20)'
        ),
        'repeat_password' => array(
            'field' => 'repeat_password',
            'label' => 'Repeat new password',
            'rules' => 'trim|required|length(5,20)|new_password'
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
     * Get Key File Location
     *
     * @return	string
     */

    public function set_key_file_location() {
        $this->table = 'settings';
        $config = $this->get_first_row(NULL, array('user_id' => $_SESSION['user_id']));
        $this->key_file_location = $config->setting_GA_key_location;
    }

    // --------------------------------------------------------------------

    /**
     * Analytics
     *
     * @param   string $start_date
     * @param   string $end_date
     * @param   string $metric
     * @param   array $options
     * @return	mixed
     */

    public function analytics($start_date = 'today', $end_date = 'today', $metric = 'ga:sessions', $options = array()) {
        $this->set_key_file_location();

        // Load Google Analytics
        if ($this->key_file_location != NULL) {
            $analytics = initialize_analytics($this->key_file_location);
            $profile_id = get_profile_id($analytics);

            // Run the query
            $data = $analytics->data_ga->get('ga:' . $profile_id, $end_date, $start_date, $metric, $options);

            if (!empty($data->getRows()) && count($data->getRows()) > 0) {
                return $data->getRows();
            }
        }

        return FALSE;
    }

    // --------------------------------------------------------------------

    /**
     * AJAX Analytics Chart
     *
     * @param   string $date
     * @param   string $metric
     * @return	void
     */

    public function ajax_analytics_chart($date = 'today', $metric = 'ga:sessions') {
        $this->set_key_file_location();
        $cols = $str = '';

        // Load Google Analytics
        if ($this->key_file_location != NULL) {
            $analytics = initialize_analytics($this->key_file_location);
            $profile_id = get_profile_id($analytics);

            // Run the query
            $data = $analytics->data_ga->get('ga:' . $profile_id, $date, 'today', $metric, array('dimensions' => 'ga:date'));

            if (!empty($data->getRows()) && count($data->getRows()) > 0) {
                $rows = $data->getRows();

                // Create and echo JSON string for AJAX
                $str = '{"cols": [{"id":"","label":"Date","pattern":"","type":"string"},{"id":"","label":"'.$metric.'","pattern":"","type":"number"}], "rows": [';

                for ($i = 0; $i < count($data->getRows()); $i++) {
                    $date = new DateTime($rows[$i][0]);
                    $cols .= '{"c":[{"v":"'.$date->format('m/d/Y').'","f":null},{"v":'.$rows[$i][1].',"f":null}]},';
                }

                $str .= rtrim($cols,', ');
                $str .= ']}';
            }

        }

        echo $str;
    }

    // --------------------------------------------------------------------

    /**
     * AJAX Analytics Stats
     *
     * @param   string $date
     * @return	void
     */

    public function ajax_analytics_stats($date = 'today') {
        $this->set_key_file_location();
        $str = 'No data found';

        // Load Google Analytics
        if ($this->key_file_location != NULL) {
            $analytics = initialize_analytics($this->key_file_location);
            $profile_id = get_profile_id($analytics);

            // Run the query
            $data = $analytics->data_ga->get('ga:' . $profile_id, $date, 'today', 'ga:sessions, ga:users, ga:pageViews, ga:bounceRate, ga:organicSearches, ga:pageViewsPerSession, ga:timeOnPage, ga:pageLoadTime, ga:sessionDuration');

            // Analytics data has been found for that date range
            if (!empty($data->getRows()) && count($data->getRows()) > 0) {
                $rows = $data->getRows();

                // Create html string for AJAX outout
                if (count($rows[0]) == 9) {
                    $str = '<div class="row justify-content-around p-3">
                                <div class="col-4 text-center text-primary shadow-sm bg-light rounded py-1">
                                    <small>Sessions</small><br><h4>'.$rows[0][0].'</h4>
                                </div>
                                <div class="col-3 text-center text-primary shadow-sm bg-light rounded py-1">
                                    <small>Users</small><br><h4>'.$rows[0][1].'</h4>
                                </div>
                                <div class="col-4 text-center text-primary shadow-sm bg-light rounded py-1">
                                    <small>Page Views</small><br><h4>'.$rows[0][2].'</h4>
                                </div>
                            </div>
                            <div class="row justify-content-around p-3">
                                <div class="col-4 text-center text-primary shadow-sm bg-light rounded py-1">
                                    <small>Bounce Rate</small><br><h4>'.round($rows[0][3], 2).'%</h4>
                                </div>
                                <div class="col-3 text-center text-primary shadow-sm bg-light rounded py-1">
                                    <small>Organic Search</small><br><h4>'.$rows[0][4].'</h4>
                                </div>
                                <div class="col-4 text-center text-primary shadow-sm bg-light rounded py-1">
                                    <small>Pages/Session</small><br><h4>'.round($rows[0][5], 2).'</h4>
                                </div>
                            </div>
                            <div class="row justify-content-around p-3">
                                <div class="col-4 text-center text-primary shadow-sm bg-light rounded py-1">
                                    <small>Time on Page</small><br><h4>'.decimal_to_time($rows[0][6]).'</h4>
                                </div>
                                <div class="col-3 text-center text-primary shadow-sm bg-light rounded py-1">
                                    <small>Page Load Time</small><br><h4>'.$rows[0][7].'</h4>
                                </div>
                                <div class="col-4 text-center text-primary shadow-sm bg-light rounded py-1">
                                    <small>Session Duration</small><br><h4>'.decimal_to_time($rows[0][8]).'</h4>
                                </div>
                            </div>';
                }
            }
        }

        echo $str;
    }

    // --------------------------------------------------------------------

    /**
     * Get user info
     *
     * @return	void
     */

    public function get_user_info() {
        $select = 'user_id, user_username, user_name, user_email, user_role, user_status, user_activity, user_company, user_birthday, user_country, user_bio, user_phone, user_facebook,
                   user_instagram, user_linkedin, user_twitter, user_youtube, user_avatar, user_theme, user_theme_header, user_theme_subheader, user_theme_footer';
        $where = array('user_username' => $_SESSION['user_username']);

        $user = $this->get_first_row($select, $where);
        return $user;
    }

    // --------------------------------------------------------------------

    /**
     * Returns a modified array with the new user password
     *
     * @param   string $user_name
     * @param   string $email
     * @return	string
     */

    public function set_user_password($user_name, $email) {
        // Set password for new user
        // Format: Firstname*reversemail!1 (ex User: John Doe, Email: user@domain.com, Password: John*resu!1)
        $user_name = explode(" ", $user_name);
        $email = explode("@", $email);
        $password = ucfirst($user_name[0]) . '*' . strrev($email[0]) . '!1';

        return hash_password($password);
    }

    // --------------------------------------------------------------------

    /**
     * Change user password
     *
     * @param   string $password
     * @param   string $current_password
     * @param   string $new
     * @param   string $repeat
     * @return	void
     */

    public function change_user_password($password, $current_password, $new, $repeat) {
        if(strcasecmp(hash_password($current_password), $password) == 0) {
            if(strcmp($new, $repeat) == 0) {
                $this->update(array('user_password' => hash_password($new)), $_SESSION['user_id']);
                $_SESSION['toastr_success'] = 'Your password has been changed.';
            }
            else {
                $_SESSION['toastr_error'] = 'Passwords do not match. Please try again.';
            }
        }
        else {
            $_SESSION['toastr_error'] = 'Invalid password. Please try again.';
        }
    }

    // --------------------------------------------------------------------

    /**
     * Reset user password. Returns 0 on success, 1 (email not found) or 2 (mail not sent) on failure.
     *
     * @param   string $email
     * @return	int
     */

    public function reset_user_password($email) {
        $query = $this->get(NULL, array('user_email' => $email));
        if ($query->rowCount() > 0) {
            $new_password = get_random_string();

            // add a number  between 0 and 999 to it
            // to make it a slightly better password
            $rand_number = rand(0, 999);
            $new_password .= $rand_number;

            // set user's password to this in database or return false
            $result = $this->update(array('user_password' => hash_password($new_password)), array('user_email' => $email));

            if ($result) {
                return $this->email_password($email, $new_password);
            }
        }
        else {
            return 1;
        }
    }

    // --------------------------------------------------------------------

    /**
     * Email password. Returns 0 on success, 2 on failure.
     *
     * @param   string $email
     * @param   string $new_password
     * @return	int
     */

    public function email_password($email, $new_password) {

        $from = "From: support@halografix.com \r\n";
        $mesg = "Your ".config('cms_name')." password has been changed to: \r\n\r\n".$new_password."\r\n\r\n"
            ."Please change it next time you log in.\r\n";

        if (mail($email, config('cms_name').' login information', $mesg, $from)) {
            return 0;
        }
        else {
            return 2;
        }
    }

    // --------------------------------------------------------------------

    /**
     * Create database
     *
     * @param   string $database
     * @param   string $hostname
     * @param   string $username
     * @param   string $password
     * @return	void
     */

    public function create_database($database, $hostname, $username, $password) {

        try {
            // Create connection
            $conn = new PDO("mysql:host={$hostname}", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Create database
            $conn->beginTransaction();
            $conn->exec("DROP DATABASE IF EXISTS " . $database);
            $conn->exec("CREATE DATABASE " . $database);
            $conn->commit();
        }
        catch(PDOException $e) {
            if (isset($conn)) {
                $conn->rollback();
            }

            die("<br />Error: " . $e->getMessage() . "<br /><br />");
        }

        $conn = null;
    }

    // --------------------------------------------------------------------

    /**
     * Restore database
     *
     * @param   string $database
     * @param   string $hostname
     * @param   string $username
     * @param   string $password
     * @return	void
     */

    public function restore_database($database, $hostname, $username, $password) {

        try {
            // Create connection
            $conn = new PDO("mysql:host={$hostname};dbname={$database}", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Temporary variable, used to store current query
            $templine = '';
            // Read in entire file
            $lines = file(APPPATH . 'config/sql/database.sql');
            // Loop through each line
            foreach ($lines as $line) {
                // Skip it if it's a comment
                if (substr($line, 0, 2) == '--' || $line == '') {
                    continue;
                }

                // Add this line to the current segment
                $templine .= $line;
                // If it has a semicolon at the end, it's the end of the query
                if (substr(trim($line), -1, 1) == ';') {
                    // Perform the query
                    $stmt = $conn->prepare($templine);
                    $stmt->execute();

                    // Reset temp variable to empty
                    $templine = '';
                }
            }
        }
        catch(PDOException $e) {
            die("<br />Error: " . $e->getMessage() . "<br /><br />");
        }

        $conn = null;
    }

    // --------------------------------------------------------------------

    /**
     * Inserts values from CMS setup into the database
     *
     * @param   array $data
     * @return	void
     */

    public function insert_data($data) {

		$user = "UPDATE users SET user_username='".$data['user_username']."', user_password='".hash_password($data['user_password'])."', user_name='".$data['user_name']."', 
		user_email='".$data['user_email']."' WHERE user_id=1000";

        try {
            // Create connection
            $conn = new PDO("mysql:host={$data['db_hostname']};dbname={$data['db_name']}", $data['db_username'], $data['db_password']);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Create user and update settings
            $conn->beginTransaction();
            $conn->exec($user);
            $conn->commit();

            $this->update_db_config($data['db_name'], $data['db_hostname'], $data['db_username'], $data['db_password']);
        }
        catch(PDOException $e) {
            if (isset($conn)) {
                $conn->rollback();
            }

            die("<br />Error: " . $e->getMessage() . "<br /><br />");
        }

        $conn = null;
    }

    // --------------------------------------------------------------------

    /**
     * Update database config file
     *
     * @param   string $database
     * @param   string $hostname
     * @param   string $username
     * @param   string $password
     * @return	void
     */

    public function update_db_config($database, $hostname, $username, $password) {
        $config = file_get_contents(APPPATH . 'config/tmp/database.php');

        $config = str_replace('db_hostname', $hostname, $config);
        $config = str_replace('db_username', $username, $config);
        $config = str_replace('db_password', $password, $config);
        $config = str_replace('db_name', $database, $config);

        if (!file_put_contents(APPPATH . 'config/database.php', $config)) {
            echo "Error updating database configuration.";
        }
        else {
            $this->disable_setup();
        }
    }

    // --------------------------------------------------------------------

    /**
     * Disable setup
     *
     * @return	void
     */

    public function disable_setup() {
        if (!copy(APPPATH . 'config/tmp/cms_controller.php', APPPATH . 'controllers/CMS_Controller.php')) {
            echo "Failed to copy Admin_Controller.php<br />";
        }
        if (!copy(APPPATH . 'config/tmp/controller.php', SYSPATH . 'core/Controller.php')) {
            echo "Failed to copy Controller.php<br />";
        }
        if (!copy(APPPATH . 'config/tmp/db_init.php', SYSPATH . 'database/DB_init.php')) {
            echo "Failed to copy DB_init.php<br />";
        }
    }

    // --------------------------------------------------------------------

    /**
     * Update header
     *
     * @param   object $data
     * @param   string $path
     * @param   string $title
     */

    public function update_header($data, $path, $title) {

        $new_trackingid = $new_code = $new_title = $html = "";
        $header = file_get_contents($path);
        $prev_title = get_string_between($header, '<title>', '</title>');
        $prev_title = '<title>' . $prev_title . '</title>';

        $trackingid = get_string_between($header, '<script async src=', '</script>');
        $prev_trackingid = '<script async src=' . $trackingid . '</script>';
        $code = get_string_between($header, $prev_trackingid . '<script>' , '</script>');
        $prev_code = '<script>' . $code . '</script>';

        if (!empty($data->setting_GA_code) && !empty($data->setting_GA_trackingid)) {
            $new_trackingid = '<script async src="https://www.googletagmanager.com/gtag/js?id='.$data->setting_GA_trackingid.'"></script>';
            $new_code = '<script>' . $data->setting_GA_code . '</script>';
        }

        if (!empty($trackingid) && !empty($code)) {
            $new_title = '<title>' . $title . '</title>';
            $html = str_replace($prev_title, $new_title, $header);
            $html = str_replace($prev_trackingid, $new_trackingid, $html);
            $html = str_replace($prev_code, $new_code, $html);
        }
        else {
            $new_title = '<title>' . $title . '</title>' . $new_trackingid . $new_code;
            $html = str_replace($prev_title, $new_title, $header);
        }

        file_put_contents($path, $html);
    }
}