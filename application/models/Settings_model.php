<?php

class Settings_model extends DB {

    protected $table = 'settings';
    protected $primary_key = 'setting_id';

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
}