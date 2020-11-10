<?php
/**
 * Halografix - MVC Framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2020 Halografix
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */
defined('SYSPATH') OR exit('No direct script access allowed');

class Controller {

    public $data = array();
    protected $db = NULL;

    // --------------------------------------------------------------------

    /**
     * Class constructor
     *
     * @return	void
     */

    public function __construct() {
        $this->db = DB::get_instance();
    }

    // --------------------------------------------------------------------

    /**
     * Class destructor
     *
     * @return	void
     */

    public function __destruct() {
        $this->db->close_connection();
    }

    // --------------------------------------------------------------------

    /**
     * Load the required model .php file
     *
     * @param	string	$model
     * @return	object
     */

    public function model($model, $database = "") {

        if (file_exists(APPPATH . 'models/' . $model . '.php')) {
            require_once APPPATH . 'models/' . $model . '.php';

            // Check for subdirectores
            $str = explode('/', $model);

            if (isset($str[1])) {
                // A subdirectory was found
                $model = $str[1];
            }

            return new $model($database);
        }
    }

    // --------------------------------------------------------------------

    /**
     * Load the required view .php file
     *
     * @param	string	$view
     * @param	array	$data
     * @return	void
     */

    public function view($view, $data = []) {

        if (file_exists(APPPATH . 'views/' . $view . '.php')) {
            foreach ($data as $key => $value) {
                ${$key} = $value;
            }

            require_once APPPATH . 'views/' . $view . '.php';
        }
    }

    // --------------------------------------------------------------------

    /**
     * Load the required helper .php file
     *
     * @param	string	$helper
     * @return	void
     */

    public function helper($helper) {

        if (file_exists(SYSPATH . 'helpers/' . $helper . '.php')) {
            require_once SYSPATH . 'helpers/' . $helper . '.php';
        }
    }

    // --------------------------------------------------------------------

    /**
     * Load the required library .php file
     *
     * @param	string	$library
     * @return	void
     */

    public function library($library) {

        if (file_exists(SYSPATH . 'libraries/' . $library . '.php')) {
            require_once SYSPATH . 'libraries/' . $library . '.php';
            return new $library();
        }
    }

    // --------------------------------------------------------------------

    /**
     * Connects to the database and gets an instance of the database class
     *
     * @return	void
     */

    public function load_database() {

        $this->db = DB::get_instance();

    }
}