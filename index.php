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

/*
 *---------------------------------------------------------------
 *  Directory Paths
 *---------------------------------------------------------------
 */

	$system_path = 'system';
    $application_path = 'application';
    $assets_path = 'assets';

/*
 * -------------------------------------------------------------------
 *  Set the main path constants
 * -------------------------------------------------------------------
 */

	// System directory
	define('SYSTEM', $system_path.DIRECTORY_SEPARATOR);

    // Application directory
    define('APPLICATION', $application_path.DIRECTORY_SEPARATOR);

    // Assets directory
    define('ASSETS', $assets_path.DIRECTORY_SEPARATOR);

    // Path to the root directory (this file)
    define('BASEPATH', dirname(__FILE__).DIRECTORY_SEPARATOR);

    // Path to the system directory
    define('SYSPATH', BASEPATH.SYSTEM);

	// Path to the application directory
	define('APPPATH', BASEPATH.APPLICATION);

    // Path to the assets directory
    define('ASSETPATH', BASEPATH.ASSETS);

/*
 *---------------------------------------------------------------
 *  Error Reporting
 *---------------------------------------------------------------
 */

    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    ini_set('error_log', APPPATH . '/logs/php_error.log');

/*
 * -------------------------------------------------------------------
 *  Verify folder paths and load the bootstrap file
 * -------------------------------------------------------------------
 */
 	if ( ! is_dir($application_path)) {
		exit("Your application folder path does not appear to be set correctly. Please open the following file and correct this: " . BASEPATH . "index.php");
	}

	if ( ! is_dir($assets_path)) {
		exit("Your assets folder path does not appear to be set correctly. Please open the following file and correct this: " . BASEPATH . "index.php");
	}

	if ( ! file_exists(SYSPATH . 'core/Init.php')) {
		exit("Your system folder path does not appear to be set correctly. Please open the following file and correct this: " . BASEPATH . "index.php");
	}

    require_once SYSPATH . 'core/Init.php';
