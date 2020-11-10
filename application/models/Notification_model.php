<?php

class Notification_model extends DB {

    protected $table = 'notifications';
    protected $primary_key = 'notification_id';

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
     * Returns the database query
     *
     * @param   int $id
     * @return	database result
     */

    public function get_notifications($id) {
        $table = 'notification_user';
        $select = array('notifications.notification_title', 'notifications.notification_text', 'notifications.notification_image', 'notifications.notification_startdate', 'notification_user.nu_id');
        $where = array('notification_user.user_id' => $id, "notification_user.nu_dismiss" => 0);
        $order_by = "notifications.notification_startdate DESC";
        $limit = 3;

        $query = $this->inner_join($table, $select, $where, $order_by, $limit);
        return $query;
    }
}