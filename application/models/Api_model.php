<?php

class Api_model extends DB {

    protected $table = 'users';
    protected $primary_key = 'user_id';
    public $config = array(
        'first_name' => array(
            'field' => 'first_name',
            'label' => 'First Name',
            'rules' => 'trim'
        ),
        'last_name' => array(
            'field' => 'last_name',
            'label' => 'Last Name',
            'rules' => 'trim'
        ),
        'email' => array(
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'trim'
        ),
        'subject' => array(
            'field' => 'subject',
            'label' => 'Subject',
            'rules' => 'trim'
        ),
        'message' => array(
            'field' => 'message',
            'label' => 'Message',
            'rules' => 'trim'
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
     * get site url
     *
     * @param   array $user_id
     * @return	string
     */

    public function get_site_url($user_id) {
        $this->set_database(DB::_database());
        $this->table("settings");
        $config = $this->get_first_row("setting_url", array("user_id" => $user_id));

        return $config->setting_url;
    }

    // --------------------------------------------------------------------

    /**
     * insert message
     *
     * @param   array $data
     * @return	void
     */

    public function insert_message($data) {
        // Set table to messages on the user database and insert data
        $this->table("messages");
        unset($data["database"]);
        unset($data["user"]);
        $this->insert($data);
    }

    // --------------------------------------------------------------------

    /**
     * update notifications
     *
     * @param   array $data
     * @return	void
     */

    public function update_notifications($data) {
        $message = "<strong>from:</strong> " . $data["first_name"] . " " . $data["last_name"] . 
        "<br /><strong>email:</strong> " . $data["email"] .
        "<br /><strong>subject:</strong> " . $data["subject"] .
        "<br /><strong>message:</strong> " . $data["message"];

        // Change database, set table to notifications and insert data
        $this->set_database(DB::_database());
        $this->table("notifications");
        $notification_id = $this->auto_increment("notifications");
        $this->insert(array(
            "notification_id" => $notification_id,
            "notification_title" => "You have a new message!", 
            "notification_text" => $message, 
            "notification_image" => "assets/img/browser.png",
            "notification_startdate" => date("Y-m-d"),
            "notification_enddate" => date("Y-m-d")
        ));

        // Set table to notification_user and insert data
        $this->table("notification_user");
        $this->insert(array(
            "notification_id" => $notification_id,
            "user_id" => $data["user"],
            "nu_dismiss" => 0
        ));
    }

    // --------------------------------------------------------------------

    /**
     * send email
     *
     * @param   array $data
     * @return	bool
     */

    public function send_email($data) {
        $this->set_database(DB::_database());
        $this->table("users");
        $user = $this->get_first_row("user_email", array("user_id" => $data["user"]));
        $from = "From: " . $data["first_name"] . " " . $data["last_name"] . " <" . $data["email"] . "> \r\n";

        if (mail($user->user_email, $data["subject"], $data["message"], $from)) {
            return true;
        }

        return false;
    }
}