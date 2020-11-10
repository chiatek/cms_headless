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

if ( ! function_exists('get_config')) {
	/**
	 * Loads the main config.php file
	 *
	 * @return	array
	 */
	function get_config() {
        $config = array();

		if (file_exists(APPPATH . 'config/config.php')) {
            require APPPATH . 'config/config.php';
        }

		return $config;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('config')) {
	/**
	 * Returns the specified config item
	 *
	 * @param	string $item
	 * @return	string
	 */
	function config($item = NULL) {
		$_config = get_config();

		if (isset($_config[$item])) {
			return $_config[$item];
		}

		return NULL;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('site_url')) {
	/**
	 * Returns base_url set in the config file or the default site url on null
	 *
	 * @param 	string $url
	 * @return	string
	 */
    function site_url($url = '') {
		$_config = get_config();

		if (isset($_config['base_url'])) {
			return $_config['base_url'] . $url;
		}

		return (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . preg_replace('@/+$@', '', dirname($_SERVER['SCRIPT_NAME'])) . '/';
    }
}

// ------------------------------------------------------------------------

if ( ! function_exists('base_url')) {
	/**
	 * Returns base_url set in the config file or the default base url on null
	 *
	 * @param 	string $url
	 * @return	string
	 */
    function base_url($url = '') {
		$_config = get_config();

		if (isset($_config['base_url'])) {
			return $_config['base_url'] . $url;
		}

        return (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . preg_replace('@/+$@', '', dirname($_SERVER['SCRIPT_NAME'])) . '/';
    }
}

// ------------------------------------------------------------------------

if ( ! function_exists('current_url')) {
	/**
	 * Returns the full url of the page currenly being viewed
	 *
	 * @return	string
	 */
    function current_url() {
		if (isset($_GET['url'])) {
			$_GET['url'] = rtrim($_GET['url'], '/');
			return (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . preg_replace('@/+$@', '', dirname($_SERVER['SCRIPT_NAME'])) . '/' . filter_var(str_replace(' ', '%20', $_GET['url']), FILTER_SANITIZE_URL);
		}

		return NULL;
    }
}

// ------------------------------------------------------------------------

if ( ! function_exists('url_string')) {
	/**
	 * Returns a string of url segments from the page currently being viewed
	 *
	 * @return	string
	 */
    function url_string() {
		if (isset($_GET['url'])) {
			$_GET['url'] = rtrim($_GET['url'], '/');
			return filter_var(str_replace(' ', '%20', $_GET['url']), FILTER_SANITIZE_URL);
		}

		return NULL;
    }
}

// ------------------------------------------------------------------------

if ( ! function_exists('segment')) {
	/**
	 * Returns a speciic segment of the current url
	 *
	 * @param 	int $index
	 * @return	string
	 */
    function segment($index = 1) {
		if (isset($_GET['url'])) {
			$_GET['url'] = rtrim($_GET['url'], '/');
			$segment = explode('/', filter_var(str_replace(' ', '%20', $_GET['url']), FILTER_SANITIZE_URL));
			if (isset($segment[$index - 1])) {
				return $segment[$index - 1];
			}
		}

		return NULL;
    }
}

// ------------------------------------------------------------------------

if ( ! function_exists('total_segments')) {
	/**
	 * Returns the total segments of the current url
	 *
	 * @return	int
	 */
    function total_segments() {
		if (isset($_GET['url'])) {
			$segment = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
			return count($segment);
		}

		return 0;
    }
}

// ------------------------------------------------------------------------

if ( ! function_exists('redirect')) {
	/**
	 * Redirects to the specified page
	 *
	 * @param 	string $url
 	 * @param 	string $method
	 */
    function redirect($url = '', $method = 'auto') {

        if ( ! preg_match('#^(\w+:)?//#i', $url)) {
            $url = site_url($url);
        }

        // If IIS environment use refresh for better compatibility
        if ($method === 'auto' && isset($_SERVER['SERVER_SOFTWARE']) && strpos($_SERVER['SERVER_SOFTWARE'], 'Microsoft-IIS') !== FALSE) {
            $method = 'refresh';
        }

        switch ($method) {
            case 'refresh':
                header('Refresh:0;url='.$url);
                break;
            default:
                header('Location: '.$url, TRUE);
                break;
        }

        exit;
    }
}

// ------------------------------------------------------------------------

if ( ! function_exists('php_error_handler')) {
	/**
     * Show error 404 page
     *
	 * @param 	string $level
	 * @param 	string $message
	 * @param 	string $file
	 * @param 	string $line
     * @return	void
     */
	function php_error_handler($level, $message, $file, $line) {

		if (file_exists(APPPATH . 'views/errors/error_php.php')) {
			require_once APPPATH . 'views/errors/error_php.php';
		}

		$message = 'PHP Error:  ' . $message . ' (Severity: ' . $level . ', Filename: ' . $file . ', Line number: ' . $line . ')';

		error_log($message);

		exit;
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('exception_handler')) {
	/**
	 * Show error exception page
	 *
	 * @param 	object $exception
	 * @return	void
	 */
	function exception_handler($exception) {

		if (file_exists(APPPATH . 'views/errors/error_exception.php')) {
			require_once APPPATH . 'views/errors/error_exception.php';
		}

		$message = 'Uncaught Exception:  ' . $exception->getMessage() .
		' (Filename: ' . $exception->getFile() . ', Line number: ' . $exception->getLine() . ')';

		error_log($message);

		exit;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('show_error_404')) {
	/**
     * Show error 404 page
     *
     * @return	void
     */
	function show_error_404() {
		$heading = "Oops.. You just found an error page...";
		$message = "We're sorry but the page you requested was not found.";

		if (file_exists(APPPATH . 'views/errors/error_404.php')) {
			require_once APPPATH . 'views/errors/error_404.php';
		}

		error_log('Error 404:  ' . $message);

		exit;
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('show_error_db')) {
	/**
	 * Show the database error page
	 *
	 * @param 	string $message
	 * @return	void
	 */
	function show_error_db($message = '') {
		$heading = "database error";

		if (file_exists(APPPATH . 'views/errors/error_db.php')) {
			require_once APPPATH . 'views/errors/error_db.php';
		}

		error_log($heading . ':  ' . $message);

		exit;
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('show_error_general')) {
	/**
	 * Show general error page
	 *
	 * @param 	string $heading
	 * @param 	string $message
	 * @return	void
	 */
	function show_error_general($heading = '', $message = '') {

		if (file_exists(APPPATH . 'views/errors/error_general.php')) {
			require_once APPPATH . 'views/errors/error_general.php';
		}

		error_log($heading . ':  ' . $message);

		exit;
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('log_exception')) {
	/**
	 * Show error exception page
	 *
	 * @param 	object $exception
	 * @return	void
	 */
	function log_exception($exception) {

		$message = 'Uncaught Exception:  ' . $exception->getMessage() .
		' (Filename: ' . $exception->getFile() . ', Line number: ' . $exception->getLine() . ')';

		error_log($message);

	}
}