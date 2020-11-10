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

require_once SYSPATH . 'helpers/download.php';

class Zip {

	public $zipdata = '';
	public $directory = '';
	public $entries = 0;
	public $file_num = 0;
	public $offset = 0;
	public $now;
	public $compression_level = 2;
	protected static $func_overload;

	/**
	 * Initialize zip compression class
	 *
	 * @return	void
	 */
	public function __construct() {
		isset(self::$func_overload) OR self::$func_overload = (extension_loaded('mbstring') && ini_get('mbstring.func_overload'));

		$this->now = time();
	}

	// --------------------------------------------------------------------

	/**
	 * Read the contents of a file and add it to the zip
	 *
	 * @param	string	$path
	 * @param	bool	$archive_filepath
	 * @return	bool
	 */
	public function read_file($path, $archive_filepath = FALSE) {

		if (file_exists($path) && FALSE !== ($data = file_get_contents($path))) {
			if (is_string($archive_filepath)) {
				$name = str_replace('\\', '/', $archive_filepath);
			}
			else {
				$name = str_replace('\\', '/', $path);

				if ($archive_filepath === FALSE) {
					$name = preg_replace('|.*/(.+)|', '\\1', $name);
				}
			}

			$this->add_data($name, $data);
			return TRUE;
		}

		return FALSE;
	}

	// ------------------------------------------------------------------------

	/**
	 * Read a directory and add it to the zip.
	 *
	 * @param	string	$path
	 * @param	bool	$preserve_filepath
	 * @param	string	$root_path
	 * @return	bool
	 */
	public function read_dir($path, $preserve_filepath = TRUE, $root_path = NULL) {
		$path = rtrim($path, '/\\').DIRECTORY_SEPARATOR;
		if ( ! $fp = @opendir($path)) {
			return FALSE;
		}

		if ($root_path === NULL) {
			$root_path = str_replace(array('\\', '/'), DIRECTORY_SEPARATOR, dirname($path)).DIRECTORY_SEPARATOR;
		}

		while (FALSE !== ($file = readdir($fp))) {
			if ($file[0] === '.') {
				continue;
			}

			if (is_dir($path.$file)) {
				$this->read_dir($path.$file.DIRECTORY_SEPARATOR, $preserve_filepath, $root_path);
			}
			elseif (FALSE !== ($data = file_get_contents($path.$file))) {
				$name = str_replace(array('\\', '/'), DIRECTORY_SEPARATOR, $path);
				if ($preserve_filepath === FALSE) {
					$name = str_replace($root_path, '', $name);
				}

				$this->add_data($name.$file, $data);
			}
		}

		closedir($fp);
		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Add Data to Zip
	 *
	 * @param	mixed	$filepath
	 * @param	string	$data
	 * @return	void
	 */
	public function add_data($filepath, $data = NULL) {
		if (is_array($filepath)) {
			foreach ($filepath as $path => $data) {
				$file_data = $this->get_mod_time($path);
				$this->_add_data($path, $data, $file_data['file_mtime'], $file_data['file_mdate']);
			}
		}
		else {
			$file_data = $this->get_mod_time($filepath);
			$this->_add_data($filepath, $data, $file_data['file_mtime'], $file_data['file_mdate']);
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Add Data to Zip
	 *
	 * @param	string	$filepath
	 * @param	string	$data
	 * @param	int	$file_mtime
	 * @param	int	$file_mdate
	 * @return	void
	 */
	protected function _add_data($filepath, $data, $file_mtime, $file_mdate) {
		$filepath = str_replace('\\', '/', $filepath);

		$uncompressed_size = self::strlen($data);
		$crc32  = crc32($data);
		$gzdata = self::substr(gzcompress($data, $this->compression_level), 2, -4);
		$compressed_size = self::strlen($gzdata);

		$this->zipdata .=
			"\x50\x4b\x03\x04\x14\x00\x00\x00\x08\x00"
			.pack('v', $file_mtime)
			.pack('v', $file_mdate)
			.pack('V', $crc32)
			.pack('V', $compressed_size)
			.pack('V', $uncompressed_size)
			.pack('v', self::strlen($filepath)) // length of filename
			.pack('v', 0) // extra field length
			.$filepath
			.$gzdata; // "file data" segment

		$this->directory .=
			"\x50\x4b\x01\x02\x00\x00\x14\x00\x00\x00\x08\x00"
			.pack('v', $file_mtime)
			.pack('v', $file_mdate)
			.pack('V', $crc32)
			.pack('V', $compressed_size)
			.pack('V', $uncompressed_size)
			.pack('v', self::strlen($filepath)) // length of filename
			.pack('v', 0) // extra field length
			.pack('v', 0) // file comment length
			.pack('v', 0) // disk number start
			.pack('v', 0) // internal file attributes
			.pack('V', 32) // external file attributes - 'archive' bit set
			.pack('V', $this->offset) // relative offset of local header
			.$filepath;

		$this->offset = self::strlen($this->zipdata);
		$this->entries++;
		$this->file_num++;
	}

	// --------------------------------------------------------------------

	/**
	 * Get the Zip file
	 *
	 * @return	string
	 */
	public function get_zip() {

		if ($this->entries === 0) {
			return FALSE;
		}

		return $this->zipdata
			.$this->directory."\x50\x4b\x05\x06\x00\x00\x00\x00"
			.pack('v', $this->entries) // total # of entries "on this disk"
			.pack('v', $this->entries) // total # of entries overall
			.pack('V', self::strlen($this->directory)) // size of central dir
			.pack('V', self::strlen($this->zipdata)) // offset to start of central dir
			."\x00\x00"; // .zip file comment length
	}

	// --------------------------------------------------------------------

	/**
	 * Download
	 *
	 * @param	string	$filename
	 * @return	void
	 */
	public function download($filename = 'backup.zip') {
		if ( ! preg_match('|.+?\.zip$|', $filename)) {
			$filename .= '.zip';
		}

		$get_zip = $this->get_zip();
		$zip_content =& $get_zip;

		download($filename, $zip_content);
	}

	// --------------------------------------------------------------------

	/**
	 * Get file/directory modification time
	 *
	 * @param	string	$dir
	 * @return	array
	 */
	protected function get_mod_time($dir) {
		$date = file_exists($dir) ? getdate(filemtime($dir)) : getdate($this->now);

		return array(
			'file_mtime' => ($date['hours'] << 11) + ($date['minutes'] << 5) + $date['seconds'] / 2,
			'file_mdate' => (($date['year'] - 1980) << 9) + ($date['mon'] << 5) + $date['mday']
		);
	}

	// --------------------------------------------------------------------

	/**
	 * Byte-safe strlen()
	 *
	 * @param	string	$str
	 * @return	int
	 */
	protected static function strlen($str) {
		return (self::$func_overload)
			? mb_strlen($str, '8bit')
			: strlen($str);
	}

	// --------------------------------------------------------------------

	/**
	 * Byte-safe substr()
	 *
	 * @param	string	$str
	 * @param	int	$start
	 * @param	int	$length
	 * @return	string
	 */
	protected static function substr($str, $start, $length = NULL) {
		if (self::$func_overload) {

			isset($length) OR $length = ($start >= 0 ? self::strlen($str) - $start : -$start);
			return mb_substr($str, $start, $length, '8bit');
		}

		return isset($length)
			? substr($str, $start, $length)
			: substr($str, $start);
	}
}