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

if ( ! function_exists('has_string_keys')) {
    /**
     * Returns the number of keys in an array that are of type string.
     *
     * @param	array $array
     * @return	int
     */
    function has_string_keys(array $array) {
        return count(array_filter(array_keys($array), 'is_string')) > 0;
    }
}

// --------------------------------------------------------------------

if ( ! function_exists('get_string_between')) {
    /**
     * Returns the string in between the $start and $end paramaters
     *
     * @param	string $string
     * @param	string $start
     * @param	string $end
     * @return	string
     */
    function get_string_between($string, $start, $end) {
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }
}

// --------------------------------------------------------------------

if ( ! function_exists('str_replace_first')) {
    /**
     * Finds and replaces the first occurance of the matching string
     *
     * @param	string $find
     * @param	string $replace
     * @param	string $string
     * @return	string
     */
    function str_replace_first($find, $replace, $string) {
		
		if (!empty($find)) {
			$pos = strpos($string, $find);
		}
		else {
			$pos = false;
		}
        
        if ($pos !== false) {
            return substr_replace($string, $replace, $pos, strlen($find));
        }
        return $string;
    }
}

// --------------------------------------------------------------------

if ( ! function_exists('hash_password')) {
    /**
     * Returns the hash value of the $string paramater
     *
     * @param	string $string
     * @return	string
     */
    function hash_password($string) {
        return hash('sha512', $string . config('encryption_key'));
    }
}

// --------------------------------------------------------------------

if ( ! function_exists('get_random_string')) {
    /**
     * Returns a random string for generating passwords
     *
     * @return	string
     */
    function get_random_string() {
        $length = 10;

        $random_string = substr(str_shuffle("!@#$%^&*()0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
        return $random_string;
    }
}

// --------------------------------------------------------------------

if ( ! function_exists('get_summary')) {
    /**
     * Returns a summary of a string with the specified number of sentences.
     *
     * @param	string $string
     * @return	string
     */
    function get_summary($string, $limit = 5) {
        $count = $limit - 1;
        $summary = "";
        $sentence = explode('.', $string);

        for ($i = 0; $i < count($sentence); $i++) {
            if ($i == $count) {
                $summary .= $sentence[$i]."...";
                break;
            }
            else if (count($sentence) == 1) {
                $summary .= $sentence[$i];
                break;
            }
            else {
                $summary .= $sentence[$i].".";
            }
        }

        return $summary;
    }
}

// ------------------------------------------------------------------------

if ( ! function_exists('decimal_to_time')) {
	/**
	 * Converts decimal to hh:mm:ss format
	 *
	 * @param	float $decimal
	 * @return	string
	 */
    function decimal_to_time($decimal = 0) {
        $n = $decimal * (1/60);
        $min = floor($n);
        $fraction = $n - $min;
        $total = $fraction * 60;
        $seconds = ($min * 60) + $total;

        return gmdate("H:i:s", $seconds);
    }
}

// ------------------------------------------------------------------------

if ( ! function_exists('format_timestamp')) {
	/**
	 * Formats Unix timestamp to the following prototype: 2006-08-21 11:35 PM
	 *
	 * @param	int	$time
	 * @param	bool $seconds
	 * @return	string
	 */
	function format_timestamp($time = '', $seconds = FALSE) {

		$timestamp = date('Y', $time).'-'.date('m', $time).'-'.date('d', $time).' ';

        $timestamp .= date('h', $time).':'.date('i', $time);

		if ($seconds) {
			$timestamp .= ':'.date('s', $time);
		}

		return $timestamp.' '.date('A', $time);
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('singular')) {
	/**
	 * Singular
	 *
	 * @param	string	$str
	 * @return	string
	 */
	function singular($str) {
        $result = '';

        // Any words included here will be ingnored
        $exception_string = array('category');

		if (in_array(strtolower($str), $exception_string) == TRUE) {
            return $str;
        }

		$singular_rules = array(
			'/(matr)ices$/'		=> '\1ix',
			'/(vert|ind)ices$/'	=> '\1ex',
			'/^(ox)en/'		=> '\1',
			'/(alias)es$/'		=> '\1',
			'/([octop|vir])i$/'	=> '\1us',
			'/(cris|ax|test)es$/'	=> '\1is',
			'/(shoe)s$/'		=> '\1',
			'/(o)es$/'		=> '\1',
			'/(bus|campus)es$/'	=> '\1',
			'/([m|l])ice$/'		=> '\1ouse',
			'/(x|ch|ss|sh)es$/'	=> '\1',
			'/(m)ovies$/'		=> '\1\2ovie',
			'/(s)eries$/'		=> '\1\2eries',
			'/([^aeiouy]|qu)ies$/'	=> '\1y',
			'/([lr])ves$/'		=> '\1f',
			'/(tive)s$/'		=> '\1',
			'/(hive)s$/'		=> '\1',
			'/([^f])ves$/'		=> '\1fe',
			'/(^analy)ses$/'	=> '\1sis',
			'/((a)naly|(b)a|(d)iagno|(p)arenthe|(p)rogno|(s)ynop|(t)he)ses$/' => '\1\2sis',
			'/([ti])a$/'		=> '\1um',
			'/(p)eople$/'		=> '\1\2erson',
			'/(m)en$/'		=> '\1an',
			'/(s)tatuses$/'		=> '\1\2tatus',
			'/(c)hildren$/'		=> '\1\2hild',
			'/(n)ews$/'		=> '\1\2ews',
			'/(quiz)zes$/'		=> '\1',
			'/([^us])s$/'		=> '\1'
		);

		foreach ($singular_rules as $rule => $replacement) {
			if (preg_match($rule, $str)) {
				$result = preg_replace($rule, $replacement, $str);
				break;
			}
		}

		return $result;
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('plural')) {
	/**
	 * Plural
	 *
	 * @param	string	$str
	 * @return	string
	 */
	function plural($str) {
        $result = '';

        // Any words included here will be ingnored
        $exception_string = array();

		if (in_array(strtolower($str), $exception_string) == TRUE) {
            return $str;
        }

		$plural_rules = array(
			'/(quiz)$/'                => '\1zes',
			'/^(ox)$/'                 => '\1\2en',
			'/([m|l])ouse$/'           => '\1ice',
			'/(matr|vert|ind)ix|ex$/'  => '\1ices',
			'/(x|ch|ss|sh)$/'          => '\1es',
			'/([^aeiouy]|qu)y$/'       => '\1ies',
			'/(hive)$/'                => '\1s',
			'/(?:([^f])fe|([lr])f)$/'  => '\1\2ves',
			'/sis$/'                   => 'ses',
			'/([ti])um$/'              => '\1a',
			'/(p)erson$/'              => '\1eople',
			'/(m)an$/'                 => '\1en',
			'/(c)hild$/'               => '\1hildren',
			'/(buffal|tomat)o$/'       => '\1\2oes',
			'/(bu|campu)s$/'           => '\1\2ses',
			'/(alias|status|virus)$/'  => '\1es',
			'/(octop)us$/'             => '\1i',
			'/(ax|cris|test)is$/'      => '\1es',
			'/s$/'                     => 's',
			'/$/'                      => 's',
		);

		foreach ($plural_rules as $rule => $replacement) {
			if (preg_match($rule, $str)) {
				$result = preg_replace($rule, $replacement, $str);
				break;
			}
		}

		return $result;
	}
}