<?php

class Media_model extends DB {

    protected $file_type = "media";

    // --------------------------------------------------------------------

    /**
     * Class constructor
     *
     * @return	void
     */

    public function __construct($database) {
        parent::__construct();
    }

    // --------------------------------------------------------------------

    /**
     * Upload config
     * 
     * string   $path 
     * @return	array
     */

    public function upload_config($path) {
        $config = array(
            'upload_path' => $path,
            'input_name' => 'userfile',
            'allowed_types' => 'gif|jpg|png',
            'max_size' => 500000
        );

        return $config;
    }
}