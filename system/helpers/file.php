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

if ( ! function_exists('delete_files')) {
	/**
	 * Delete files passed in from an array
	 *
	 * @param	array $path
	 * @return	bool
	 */
	function delete_files($path) {
		for ($i = 0; $i < count($path); $i++) {
			if (!unlink($path[$i])) {
				return FALSE;
			}
		}
		return TRUE;
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('get_file_info')) {
	/**
	 * Get file info
	 *
	 * @param	string $file
	 * @return	array
	 */
	function get_file_info($file) {

		if ( ! file_exists($file)) {
			return FALSE;
		}

		$file_info = array(
			'name' => basename($file),
			'server_path' => $file,
			'size' => filesize($file),
			'date' => filemtime($file)
		);

		return $file_info;
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('get_filenames')) {
	/**
	 * Get filenames
	 *
	 * @param	string $source_dir
	 * @return	array
	 */
	function get_filenames($source_dir) {
		static $file_data = array();
		$recursion = FALSE;

		if ($fp = @opendir($source_dir)) {

			if ($recursion === FALSE) {
				$file_data = array();
				$source_dir = rtrim(realpath($source_dir), DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;
			}

			while (FALSE !== ($file = readdir($fp))) {
				if (is_dir($source_dir.$file) && $file[0] !== '.') {
					get_filenames($source_dir.$file.DIRECTORY_SEPARATOR);
				}
				else if ($file[0] !== '.') {
					$file_data[] = $file;
				}
			}

			closedir($fp);
			return $file_data;
		}

		return FALSE;
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('get_dir_file_info')) {
	/**
	 * Get directory file information
	 *
	 * @param	string $source_dir
	 * @param	bool $top_level_only
	 * @return	array
	 */
	function get_dir_file_info($source_dir, $top_level_only = TRUE) {
		static $file_data = array();
		$recursion = FALSE;
		$relative_path = $source_dir;

		if ($fp = @opendir($source_dir)) {

			if ($recursion === FALSE) {
				$file_data = array();
				$source_dir = rtrim(realpath($source_dir), DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;
			}

			while (FALSE !== ($file = readdir($fp))) {
				if (is_dir($source_dir.$file) && $file[0] !== '.' && $top_level_only === FALSE) {
					get_dir_file_info($source_dir.$file.DIRECTORY_SEPARATOR, $top_level_only);
				}
				else if ($file[0] !== '.') {
					$file_data[$file] = get_file_info($source_dir.$file);
					$file_data[$file]['relative_path'] = $relative_path;
				}
			}

			closedir($fp);
			return $file_data;
		}

		return FALSE;
	}
}