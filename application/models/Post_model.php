<?php

class Post_model extends DB {

    protected $table = 'posts';
    protected $primary_key = 'id';
    protected $foreign_key = 'post_id';
    protected $exception_fields = array(
        'body',
        'slug'
    );
    protected $unset_fields = array(
        'prev_category',
        'category_id'
    );
    public $config = array(
        'title' => array(
            'field' => 'title',
            'label' => 'Title',
            'rules' => 'trim|required'
        ),
        'slug' => array(
            'field' => 'slug',
            'label' => 'Slug',
            'rules' => 'trim|required'
        )
    );

    // --------------------------------------------------------------------

    /**
     * Class constructor
     *
     * @return	void
     */

    public function __construct($database) {
        parent::__construct();
        $this->database = $database;
    }

    // --------------------------------------------------------------------

    /**
     * Returns an updated array for the post table
     *
     * @param   array $data
     * @return	array
     */

    public function insert_post_array($data) {
        $data += array(
            'user_id' => $_SESSION['user_id'],
            'status' => 'draft',
            'created' => date("Y-m-d h:i:s"),
            'modified' => date("Y-m-d h:i:s")
        );

        return $data;
    }

    // --------------------------------------------------------------------

    /**
     * Returns an updated array for the post table
     *
     * @param   array $data
     * @return	array
     */

    public function update_post_array($data) {
        if (!isset($data['featured'])) {
            $data += array(
                'modified' => date("Y-m-d h:i:s"),
                'featured' => 0
            );
        }
        else {
            $data += array('modified' => date("Y-m-d h:i:s"));
        }

        return $data;
    }

    // --------------------------------------------------------------------

    /**
     * Save post
     * Returns insert ID (new post), primary key (existing post)
     *
     * @param   array $data
     * @param   int $pkey_val
     * @return	int
     */

    public function save_post($data, $pkey_val) {

        // Remove 'prev_category' and 'category_id' from the array
        $data = $this->unset_data($data);

        // Select * from posts where 'post_slug' = $data['post_slug'] and 'post_status' = 'draft';
        $query = $this->get(NULL, array('slug' => $data['slug'], 'status' => 'draft'));

        // Create a new post as a draft.
        if ($query->rowCount() == 0) {
            $data = $this->insert_post_array($data);
            return $this->insert($data);
        }
        // Update an existing post as a draft.
        else {
            // Remove 'prev_category' and 'category_id' from the array and update post
            $data = $this->update_post_array($data);
            $this->update($data, $pkey_val);
            return $pkey_val;
        }
    }

    // --------------------------------------------------------------------

    /**
     * Publish post
     * Returns Post ID
     *
     * @param   array $data
     * @param   int $pkey_val
     * @return	int
     */

    public function publish_post($data, $pkey_val) {

        // Update the $data array with additonal values to insert into table post
        $data = $this->update_post_array($data);

        // Select * from posts where 'slug' = $data['slug'] and 'status' = 'published';
        $query = $this->get(NULL, array('slug' => $data['slug'], 'status' => 'published'));

        // The post has already been published. Update it.
        if ($query->rowCount() > 0) {
            $row = $query->fetch();

            // Update categories with the correct post_id
            if (isset($data['prev_category'])) {
                $this->update_category(array('post_id' => $row->id), array('post_id' => $pkey_val));
            }

            // Remove 'prev_category' and 'category_id' from the array and update post
            $data = $this->unset_data($data);
            $this->update($data, $row->id);
            
            // Select * from posts where 'slug' = $data['slug'] and 'status' = 'draft';
            $query = $this->get(NULL, array('slug' => $data['slug'], 'status' => 'draft'));

            // Delete the draft post.
            if ($query->rowCount() > 0) {
                $this->delete_foreign_key($pkey_val, 'post_category', 'post_id');
                $this->delete($pkey_val);
            }

            return $row->id;
        }
        // The post has not been published yet. Update the draft and change the status to published.
        else {
            // Remove 'prev_category' and 'category_id' from the array and update post
            $data = $this->unset_data($data);
            $this->update($data, $pkey_val);
            return $pkey_val;
        }
    }

    // --------------------------------------------------------------------

    /**
     * Update category
     *
     * @param	string $set
     * @param	string $where
     * @return  void
     */

    public function update_category($set, $where) {
        $this->table('post_category');
        $this->update($set, $where,  FALSE);
        $this->table('posts');
    }

    // --------------------------------------------------------------------

    /**
     * Returns an array with 'unset_fields' unset.
     *
     * @param	array $data
     * @return	array
     */

    public function unset_data($data) {
        foreach ($data as $key => $value) {
            if (in_array($key, $this->unset_fields) == TRUE) {
                if (isset($data[$key])) {
                    unset($data[$key]);
                }
            }
        }
        return $data;
    }

    // --------------------------------------------------------------------

    /**
     * Comments JOIN sql query
     *
     * @param   string $limit
     * @return	database result
     */

    public function get_comments($limit = NULL) {

        $table = 'comments';

        $select = array('comments.id as "id"', 'posts.title as "post"', 
        'posts.slug as "slug"', 'comments.date as "date"', 
        'comments.name as "user"', 'comments.status as "status"', 'comments.comment as "comment"');

        $where = NULL;
        $order_by = 'date DESC';

        $query = $this->inner_join($table, $select, $where, $order_by, $limit);
        return $query;
    }

    // --------------------------------------------------------------------

    /**
     * Search SQL
     *
     * @param	string $query
     * @return	string
     */

    public function search_sql($query) {

        $sql = "SELECT DISTINCT posts.id as id, posts.title as title, posts.author as author, 
            posts.created as created, posts.modified as modified, posts.status as status FROM ".$this->database.".posts
            LEFT JOIN ".$this->database.".post_category
            on post_category.post_id=posts.id
            WHERE posts.status = 'published'
            AND posts.title LIKE '%".$query."%'
            OR posts.slug LIKE '%".$query."%'
            OR posts.author LIKE '%".$query."%'
            OR posts.description LIKE '%".$query."%'
            OR posts.body LIKE '%".$query."%'
            ORDER BY posts.modified DESC";

        return $sql;
    }
}