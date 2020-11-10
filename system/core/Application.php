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

class Application {

    protected $_controller;
    protected $_alt_controller;
    protected $_method;
    protected $_params = array();
    protected $_folder = '';

    // --------------------------------------------------------------------

    /**
     * Class constructor
     *
     * Gets the controller, method, and parameters from the url path
     *
     * @return	void
     */

    public function __construct() {
        $this->set_config_defaults();
        $this->route_url();
    }

    // --------------------------------------------------------------------

    /**
     * set_config_defaults
     *
     * Set default controller and method from the config file
     *
     * @return	void
     */

    public function set_config_defaults() {
        $config = get_config();

        $this->_controller = $config['default_controller'];
        $this->_alt_controller = $config['alternate_controller'];
        $this->_method = $config['default_method'];
    }

    // --------------------------------------------------------------------

    /**
     * route_url
     *
     * Process url and and call the controller with the corresponding method and parameters
     *
     * @return	void
     */

    public function route_url() {
        $index = 0;
        // Get an array of segments from the url path
        $url = $this->parse_url();

        // Set the folder and remove it from the array
        if (isset($url[$index])) {
            if (is_dir(APPPATH . 'controllers/' .  $url[$index])) {
                $this->_folder = $url[$index] . '/';
                unset($url[$index]);
                $index++;
            }
        }

        // Set the controller and remove it from the array
        if (isset($url[$index])) {
            if (file_exists(APPPATH . 'controllers/' . $this->_folder . ucfirst($url[$index] . '.php'))) {
                $this->_controller = $url[$index];
                unset($url[$index]);
                $index++;
            }
            else {
                show_error_404();
            }
        }

        // load the default or alternate controller
        if (file_exists(APPPATH . 'controllers/' . $this->_folder . ucfirst($this->_controller . '.php'))) {
            require_once APPPATH . 'controllers/' . $this->_folder . ucfirst($this->_controller . '.php');
            $this->_controller = new $this->_controller;
        }
        else if (file_exists(APPPATH . 'controllers/' . $this->_folder . ucfirst($this->_alt_controller . '.php'))) {
            require_once APPPATH . 'controllers/' . $this->_folder . ucfirst($this->_alt_controller . '.php');
            $this->_controller = new $this->_alt_controller;
        }
        else {
            $message = "A problem has occurred loading the controller. Make sure the default controller and alternate controller are set correctly in config.php.";
            show_error_general('Routing Error', $message);
        }

        // Set the mothod and remove it from the array
        if (isset($url[$index])) {
            if (method_exists($this->_controller, $url[$index])) {
                $this->_method = $url[$index];
                unset($url[$index]);
            }
            else {
                show_error_404();
            }
        }

        // Set the parameters to the remaining array values and call the controller
        $this->_params = $url ? array_values($url) : [];
        if (!empty($this->_controller) && !empty($this->_method)) {
            call_user_func_array([$this->_controller, $this->_method], $this->_params);
        }
        else {
            $message = "A problem has occurred loading the controller method. Make sure the default method is set correctly in config.php.";
            show_error_general('Routing Error', $message);
        }

    }

    // --------------------------------------------------------------------

    /**
     * parse_url
     *
     * Returns an array of segments from the url path
     *
     * @return	array
     */

    public function parse_url() {
        if (isset($_GET['url'])) {
            $_GET['url'] = rtrim($_GET['url'], '/');

            return explode('/', filter_var(str_replace(' ', '%20', $_GET['url']), FILTER_SANITIZE_URL));
        }
    }
}