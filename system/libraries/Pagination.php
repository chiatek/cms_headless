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
 *      $config = array(
 *          'base_url' => base_url('home/index'),
 *          'per_page' => 5,
 *          'cur_tag_open' => '<li class="page-item active"><span class="page-link">',
 *          'cur_tag_close' => '<span class="sr-only">(current)</span></span></li>',
 *          'first_tag_open' => '<li class="page-item">',
 *          'first_tag_close' => '</li>',
 *          'full_tag_open' => '<ul class="pagination justify-content-center">',
 *          'full_tag_close' => '</ul>',
 *          'last_tag_open' => '<li class="page-item">',
 *          'last_tag_close' => '</li>',
 *          'next_link' => '&raquo',
 *          'next_tag_open' => '<li class="page-item">',
 *          'next_tag_close' => '</li>',
 *          'num_tag_open' => '<li class="page-item">',
 *          'num_tag_close' => '</li>',
 *          'prev_link' => '&laquo',
 *          'prev_tag_open' => '<li class="page-item">',
 *          'prev_tag_close' => '</li>'
 *      );
 */

class Pagination {

    private $page = 1;
    private $limit = 10;
    private $page_count;
    private $total_rows;
    private $config = array();

    // --------------------------------------------------------------------

    /**
     * Class constructor
     *
     * @return	void
     */

    public function __construct() {}

    // --------------------------------------------------------------------

    /**
     * Returns the offset
     *
     * @return	int
     */

    public function get_offset() {
        if ($this->page != 1) {
            return $this->limit * ($this->page - 1);
        }

        return 0;
    }

    // --------------------------------------------------------------------

    /**
     * Returns the page count given the total row count of a query
     *
     * @return	int
     */

    public function get_page_count() {
        $this->page_count = ceil($this->total_rows / $this->limit);
        return $this->page_count;
    }

    // --------------------------------------------------------------------

    /**
     * Initialize pagination
     *
     * @param   array $config
     * @param   int $page
     * @param   int $total_rows
     * @return	int
     */

    public function initialize($config, $page, $total_rows) {

        // If the page number is not set, use the default value
        if (isset($page)) {
            $this->page = $page;
        }

        // Set config array, total rows, and limit
        $this->config = $config;
        $this->total_rows = $total_rows;
        $this->limit = $this->config['per_page'];

        // Set offset and page count
        $offset = $this->get_offset();
        $this->page_count = $this->get_page_count($total_rows);

        return $offset;
    }

    // --------------------------------------------------------------------

    /**
     * Returns a Bootstrap html string with pagination links
     *
     * @return	string
     */

    public function create_links() {
        $links = '<nav>' . $this->config['full_tag_open'];
        // The current page is somewhere in between the first and last page
        if ($this->page > 1 && $this->page < $this->page_count) {
            $links .= $this->config['prev_tag_open'] . '<a href="'.$this->config['base_url'].'/'.($this->page - 1).'" class="page-link">'.$this->config['prev_link'].'</a>' . $this->config['prev_tag_close'];
            for ($i = 1; $i <= $this->page_count; $i++) {
                if ($i == $this->page) {
                    $links .= $this->config['cur_tag_open'] . $i . $this->config['cur_tag_close'];
                }
                else {
                    $links .= $this->config['num_tag_open'] . '<a href="'.$this->config['base_url'].'/'.$i.'" class="page-link">'.$i.'</a>' . $this->config['num_tag_close'];
                }
            }
            $links .= $this->config['next_tag_open'] . '<a href="'.$this->config['base_url'].'/'.($this->page + 1).'" class="page-link">'.$this->config['next_link'].'</a>' . $this->config['next_tag_close'];
        }
        // The current page is the last Page
        else if ($this->page == $this->page_count && $this->total_rows > $this->limit) {
            $links .= $this->config['prev_tag_open'] . '<a href="'.$this->config['base_url'].'/'.($this->page - 1).'" class="page-link">'.$this->config['prev_link'].'</a>' . $this->config['prev_tag_close'];
            for ($i = 1; $i <= $this->page_count; $i++) {
                if ($i == $this->page) {
                    $links .= $this->config['cur_tag_open'] . $i . $this->config['cur_tag_close'];
                }
                else {
                    $links .= $this->config['num_tag_open'] . '<a href="'.$this->config['base_url'].'/'.$i.'" class="page-link">'.$i.'</a>' . $this->config['num_tag_close'];
                }
            }
        }
         // The current page is the only page
        else if ($this->page == $this->page_count) {
            $links .= $this->config['cur_tag_open'] . '1' . $this->config['cur_tag_close'];
        }
         // The current page is the first Page
        else {
            for ($i = 1; $i <= $this->page_count; $i++) {
                if($i == $this->page) {
                    $links .= $this->config['cur_tag_open'] . $i . $this->config['cur_tag_close'];
                }
                else {
                    $links .= $this->config['num_tag_open'] . '<a href="'.$this->config['base_url'].'/'.$i.'" class="page-link">'.$i.'</a>' . $this->config['num_tag_close'];
                }
            }
            $links .= $this->config['next_tag_open'] . '<a href="'.$this->config['base_url'].'/'.($this->page + 1).'" class="page-link">'.$this->config['next_link'].'</a>' . $this->config['next_tag_close'];
        }
        $links .= $this->config['full_tag_close'] . '</nav>';

        return $links;
    }
}