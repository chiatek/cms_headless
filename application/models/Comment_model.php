<?php

class Comment_model extends DB {

    protected $table = 'comments';
    protected $primary_key = 'id';
    protected $foreign_key = 'comment_id';

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