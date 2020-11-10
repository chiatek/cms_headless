<?php
/**
 * Halografix - MVC Framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2019 Halografix
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

/**
 * Example Configuration Array
 *
 *      $config = array(
 *          'upload_path' => ASSETPATH . 'img/uploads',
 *          'input_name' => 'userFile',
 *          'allowed_types' => 'gif|jpg|png',
 *          'max_size' => 500000
 *      );
 */

class Upload {

    private $config = array();
    private $file_name;
    private $file_size;
    private $file_tmp;
    private $file_type;
    private $error = NULL;

    // --------------------------------------------------------------------

    /**
     * Class constructor
     *
     * @return	void
     */

    public function __construct() {}

    // --------------------------------------------------------------------

    /**
     * Returns a message string
     *
     * @return	string
     */

    public function display_errors() {
        return $this->error;
    }

    // --------------------------------------------------------------------

    /**
     * Returns an array for the uloaded file
     *
     * @return	array
     */

    public function data() {
        $data = array(
            'File Name' => $this->file_name,
            'File Size' => $this->file_size,
            'File Type' => $this->file_type,
            'Location' => $this->config['upload_path']
        );

        return $data;
    }

    // --------------------------------------------------------------------

    /**
     * Allow certain file formats
     *
     * @param   string $image_file_type
     * @return	void
     */

    public function verify_file_format() {
        $file_ext = strtolower(pathinfo($this->file_name, PATHINFO_EXTENSION));
        $extensions = explode('|', $this->config['allowed_types']);

        if (in_array($file_ext, $extensions) === FALSE){
           $this->error = "Extension not allowed, please choose one of the following: " . str_replace('|', ', ',$this->config['allowed_types']) . '<br />';
        }
    }

    // --------------------------------------------------------------------

    /**
     * Check file size
     *
     * @return	void
     */

    public function verify_file_size() {
        if ($this->file_size > $this->config['max_size']){
            $this->error = "The file is too large<br />";
        }
    }

    // --------------------------------------------------------------------

    /**
     * Upload a file. Returns true on success, false on failure
     *
     * @param   array $config
     * @return	bool
     */

    public function do_upload($config) {
        $this->config = $config;

        if (isset($_FILES[$this->config['input_name']]["name"])) {

            // Set file info
            $this->file_name = $_FILES[$this->config['input_name']]['name'];
            $this->file_size = $_FILES[$this->config['input_name']]['size'];
            $this->file_tmp = $_FILES[$this->config['input_name']]['tmp_name'];
            $this->file_type = $_FILES[$this->config['input_name']]['type'];

            // Verify file size and format
            $this->verify_file_size();
            $this->verify_file_format();

            // No file was chosen
            if (empty($this->file_name)) {
                $this->error = "Please choose a file<br />";
            }
            // The file size or format was invalid
            else if (isset($this->error)) {
                $this->error .= "Your file was not uploaded<br />";
            }
            // Upload the file
            else {
                if (move_uploaded_file($this->file_tmp, $this->config['upload_path'].'/'.$this->file_name)) {
                    return TRUE;
                }
                else {
                    $this->error = "There was an error uploading your file<br />";
                }
            }

            return FALSE;
        }
    }
}