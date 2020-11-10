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

/**
 * Example Configuration Array
 *
 *     $config = array(
 *         'name' => array(
 *             'field' => 'name',
 *             'label' => 'Name',
 *             'rules' => 'trim|required|name'
 *         ),
 *         'email' => array(
 *             'field' => 'email',
 *             'label' => 'Email',
 *             'rules' => 'trim|required|email'
 *         ),
 *         'password' => array(
 *             'field' => 'password',
 *             'label' => 'Password',
 *             'rules' => 'trim|required|length(6,15)'
 *         ),
 *         'repeat_password' => array(
 *             'field' => 'repeat_password',
 *             'label' => 'Repeat Password',
 *             'rules' => 'trim|required|length(6,15)|password'
 *         )
 *     );
 */

class Form_Validation {

    private $config = array();
    private $field;
    private $label;
    private $rules;
    private $error = '';
    private $field_is_valid = TRUE;
    private $form_is_valid = TRUE;

    // --------------------------------------------------------------------

    /**
     * Class constructor
     *
     * @return	void
     */

    public function __construct() {}

    // --------------------------------------------------------------------

    /**
     * Set the config array of validation rules
     *
     * @param   array $_config
     * @return	void
     */

    public function set_rules($_config) {
        $this->config = $_config;
    }

    // --------------------------------------------------------------------

    /**
     * Returns a string of validation errors
     *
     * @return	string
     */

    public function validation_errors() {
        return $this->error;
    }

    // --------------------------------------------------------------------

    /**
     * Runs form validation and returns true on success and false on failure
     *
     * @return	bool
     */

    public function run() {

        if (!empty($_POST)) {

            // Get field, label, and rules for each field
            $keys = array_keys($this->config);
            for($i = 0; $i < count($this->config); $i++) {
                if (in_array($keys[$i], array_keys($_POST)) == TRUE) {
                    $this->field = $this->config[$keys[$i]]['field'];
                    $this->label = $this->config[$keys[$i]]['label'];
                    $this->rules = $this->config[$keys[$i]]['rules'];

                    // Validate the field
                    $this->validate_form();
                }
            }

            // The form is valid
            if ($this->form_is_valid) {
                return TRUE;
            }
        }

        return FALSE;
    }

    // --------------------------------------------------------------------

    /**
     * Validate form
     *
     * Gets an array of rules and performs form validation for each specific rule
     *
     * @return	void
     */

    public function validate_form() {
        // Get an array of rules for the field
        $rules = explode('|', $this->rules);

        // The field is required, input is required before moving on
        if (in_array('required', $rules) == TRUE) {
            array_unshift($rules, 'required');
            $rules = array_unique($rules);
            unset($rules[0]);

            $this->field_is_valid = $this->required();
        }

        // Validate all other fields
        foreach ($rules as $rule) {
            if ($this->field_is_valid) {
                // Run length validation
                if (substr_count($rule, 'length') > 0) {
                    $min = $this->get_string_between($rule, '(', ',');
                    $max = $this->get_string_between($rule, ',', ')');
                    $this->field_is_valid = $this->length($min, $max);
                }
                // Run equal validation
                else if (in_array($rule, $rules) == TRUE && !method_exists('Form_Validation', $rule) && isset($_POST[$rule])) {
                    $this->field_is_valid = $this->equal($rule, $this->field);
                }
                // Run all other validation rules
                else if (method_exists('Form_Validation', $rule)) {
                    $this->field_is_valid = $this->$rule();
                }
                // The rule is invalid
                else {
                    throw new Exception('Invalid form validation rule');
                }
            }
        }

        // If the field is not validated, set from validation to false
        if (!$this->field_is_valid) {
            $this->form_is_valid = FALSE;
        }

    }

    // --------------------------------------------------------------------

    /**
     * Trim
     *
     * Perform security check and remove unwanted characters from the users input
     *
     * @return	bool
     */

    public function trim() {
        $_POST[$this->field] = trim($_POST[$this->field]);
        $_POST[$this->field] = stripslashes($_POST[$this->field]);
        $_POST[$this->field] = htmlspecialchars($_POST[$this->field]);

        return TRUE;
    }

    // --------------------------------------------------------------------

    /**
     * Form validation rule: required
     * Checks if the field is empty
     *
     * @return	bool
     */

    public function required() {
        if (empty($_POST[$this->field])) {
            $this->error .= '* ' . $this->label . ' is required<br />';
            return FALSE;
        }

        return TRUE;
    }

    // --------------------------------------------------------------------

    /**
     * Form validation rule: email
     * Check if e-mail address is well-formed
     *
     * @return	bool
     */

    public function email() {
        if (!filter_var($_POST[$this->field], FILTER_VALIDATE_EMAIL)) {
            $this->error .= '* Invalid email format<br />';
            return FALSE;
        }

        return TRUE;
    }

    // --------------------------------------------------------------------

    /**
     * Form validation rule: website
     * Check if URL address syntax is valid (this regular expression also allows dashes in the URL)
     *
     * @return	bool
     */

    public function website() {
        if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $_POST[$this->field])) {
            $this->error .= '* Invalid URL<br />';
            return FALSE;
        }

        return TRUE;
    }

    // --------------------------------------------------------------------

    /**
     * Form validation rule: name
     * Check if name only contains letters and whitespace
     *
     * @return	bool
     */

    public function name() {
        if (!preg_match("/^[a-zA-Z ]*$/", $_POST[$this->field])) {
            $this->error .= '* Only letters and white space allowed<br />';
            return FALSE;
        }

        return TRUE;
    }

    // --------------------------------------------------------------------

    /**
     * Form validation rule: length
     * Checks if the length is between $min and $max
     *
     * @return	bool
     */

    public function length($min = 1, $max = 20) {
        if (strlen($_POST[$this->field]) < $min || strlen($_POST[$this->field]) > $max) {
            $this->error .= '* ' . $this->label . ' must be between ' . $min . ' and ' . $max . ' characters<br />';
            return FALSE;
        }

        return TRUE;
    }

    // --------------------------------------------------------------------

    /**
     * Form validation rule: numeric
     * Checks if the value is numeric
     *
     * @return	bool
     */

    public function numeric() {
        if (!is_numeric($_POST[$this->field])) {
            $this->error .= '* ' . $this->label . ' must be a number<br />';
            return FALSE;
        }

        return TRUE;
    }

    // --------------------------------------------------------------------

    /**
     * Form validation rule: equal
     * Checks if the user input from $field1 equals $field2
     *
     * @param   string $field2
     * @param   string $field1
     * @return	bool
     */

    public function equal($field1, $field2) {
        if (strcmp($_POST[$field1], $_POST[$field2])) {
            $this->error .= '* ' . $this->label . ' and '. $this->config[$field1]['label'] . ' do not match<br />';
            return FALSE;
        }

        return TRUE;
    }

    // --------------------------------------------------------------------

    /**
     * Returns the string in between the $start and $end paramaters
     *
     * @param   string $string
     * @param   string $start
     * @param   string $end
     * @return	string
     */

    public function get_string_between($string, $start, $end) {
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }
}