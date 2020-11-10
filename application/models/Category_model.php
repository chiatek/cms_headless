<?php

class Category_model extends DB {

    protected $table = "category";
    protected $primary_key = "id";
    protected $foreign_key = "category_id";
    protected $exception_fields = array();
    public $config = array(
        'name' => array(
            'field' => 'name',
            'label' => 'Name',
            'rules' => 'trim|required'
        ),
        'slug' => array(
            'field' => 'slug',
            'label' => 'Slug',
            'rules' => 'trim|required'
        )
    );

    // ------------------------------------------------------------------

    public function __construct($database) {
        parent::__construct();
        $this->database = $database;
    }

    // --------------------------------------------------------------------

    /**
     * Update categories
     *
     * @param   string $category
     * @param   string $prev_category
     * @param   int $id
     * @param   int $prev_id
     * @return  void
     */

    public function update_categories($category, $prev_category, $id, $prev_id) {

        // The category was set previously and a new category has been selected.
        if (isset($prev_category) && isset($category)) {

            // The post was previously published and now is saved as a draft.
            // Insert all selected categories in the database for the draft.
            if ($prev_id < $id) {
                for ($i = 0; $i < count($category); $i++) {
                    $this->insert_category($id, $category[$i]);
                }
            }
            // The post was previously published then saved as a draft and published again
            // Delete the draft categories and insert all categories for the published post.
            else if ($prev_id > $id) {
                $this->delete_category($id);

                for ($i = 0; $i < count($category); $i++) {
                    $this->insert_category($id, $category[$i]);
                }

            }
            // ($prev_id == $id)
            // The post was previously published and is published again.
            // Or the post was previously a draft and is saved as a draft again.
            else {
                // Search selected categories and find those not previously selected.
                // Insert those cagegories into post_category.
                for ($i = 0; $i < count($category); $i++) {
                    if (in_array($category[$i], $prev_category) == FALSE) {
                        $this->insert_category($id, $category[$i]);
                    }
                }

                // Search previous categories and find those currently not selected.
                // Delete those categories from post_category.
                for ($i = 0; $i < count($prev_category); $i++) {
                    if (in_array($prev_category[$i], $category) == FALSE) {
                        $this->delete_category($id, $prev_category[$i]);
                    }
                }
            }

        }
        // No categories were set previously.
        // Insert cagegories into post_category.
        else if (isset($category)) {
            foreach ($category as $option => $value) {
                $this->insert_category($id, $value);
            }
        }
        // The category was previously selected and is not set now.
        // Delete categories from post_category.
        else if (isset($prev_category) || ($prev_id > $id)) {
            $this->delete_category($id);
        }
        // The category was not previuosly set and is not set now.
        // Do nothing
        else {}

    }

    // --------------------------------------------------------------------

    /**
     * Insert category
     *
     * @param   int $post_id
     * @param   int $category_id
     * @return	void
     */

    public function insert_category($post_id, $category_id = NULL) {
        $this->table('post_category');

        if ($category_id) {
            $this->insert(['post_id' => $post_id, 'category_id' => $category_id]);
        }
        else {
            $this->insert(['post_id' => $post_id]);
        }
    }

    // --------------------------------------------------------------------

    /**
     * Delete category
     *
     * @param   int $post_id
     * @param   int $category_id
     * @return	void
     */

    public function delete_category($post_id, $category_id = NULL) {
        $this->table('post_category');

        if ($category_id) {
            $this->delete(['post_id' => $post_id, 'category_id' => $category_id]);
        }
        else {
            $this->delete(['post_id' => $post_id]);
        }
    }
}