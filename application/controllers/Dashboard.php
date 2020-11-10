<?php

class Dashboard extends CMS_Controller {

    // --------------------------------------------------------------------

    /**
     * Class constructor
     *
     * @return	void
     */

    public function __construct() {
        parent::__construct();
    }

    // --------------------------------------------------------------------

    /**
     * Index
     *
     * @param   string $date
     * @param   string $metric
     * @return	void
     */

    public function index($date = NULL, $metric = NULL) {
        $this->helper('file');
        $this->helper('analytics');
        $post = $this->model('Post_model', $this->database);
        $comment = $this->model('Comment_model', $this->database);

        // AJAX: Google Analytics Charts
        if (isset($date) && isset($metric)) {
            $this->user->ajax_analytics_chart($date, $metric);
        }
        // AJAX: Google Analytics stats
        else if (isset($date)) {
            $this->user->ajax_analytics_stats($date);
        }
        // Load dashboard
        else {

            // Set Google Analytics (page views / sessions)
            $this->data['page_views'] = $this->user->analytics('today', 'today', 'ga:pageViews');
            $this->data['users'] = $this->user->analytics('today', '7daysAgo', 'ga:users');

            // Load posts
            if ($this->data['config']->setting_posts) {
                $this->data['total_posts'] = $post->get("*", array('status' => 'published'))->rowCount();
                $sql = $post->compile_left_join("t1.slug = t2.slug", "t1.modified < t2.modified", "t2.id IS NULL", "t1.modified DESC", config('dashboard_posts_limit'));
                $this->data['posts'] = $post->query($sql);

                // Load comments
                $this->data['comments'] = $post->get_comments(config('dashboard_comments_limit'), TRUE);
                $this->data['total_comments'] = $comment->get()->rowCount();
            }

            // Load saved queries
            if (!empty($this->data['config']->setting_saved_queries)) {
                $this->data['saved_query_dashboard'] = $this->query->get(NULL, array('user_id' => $_SESSION['user_id'], 'add_to_dashboard' => 1));
            }

            // Set additional page data and load the view
            $this->data['title'] = config('cms_name') . config('title_separator') . 'Dashboard';
            $this->view('pages/index', $this->data);
        }
    }    
}