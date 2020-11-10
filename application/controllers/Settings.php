<?php
class Settings extends CMS_Controller {

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
     * @return	void
     */

    public function index() {
        $this->helper('file');

        // Process the form
        if (!empty($_POST)) {

            if (!isset($_POST['setting_posts'])) {
                $_POST += array('setting_posts' => 0);
            }

            if (!isset($_POST['setting_dashboard_posts_widget'])) {
                $_POST += array('setting_dashboard_posts_widget' => 0);
            }

            if (!isset($_POST['setting_dashboard_GA_widget'])) {
                $_POST += array('setting_dashboard_GA_widget' => 0);
            }

            if (!isset($_POST['setting_dashboard_posts'])) {
                $_POST += array('setting_dashboard_posts' => 0);
            }

            if (!isset($_POST['setting_dashboard_comments'])) {
                $_POST += array('setting_dashboard_comments' => 0);
            }

            if (!isset($_POST['setting_dashboard_GA_chart'])) {
                $_POST += array('setting_dashboard_GA_chart' => 0);
            }

            if (!isset($_POST['setting_dashboard_GA_stats'])) {
                $_POST += array('setting_dashboard_GA_stats' => 0);
            }

            if ($this->setting->update($_POST, $this->data['config']->setting_id)) {
                if (!empty($_POST['setting_siteicon'])) {
                    // Set site icon and move images folder
                    copy($_POST['setting_siteicon'], $this->data['config']->setting_root . '/' . $this->data['config']->setting_media . '/favicon.ico');
                }

                if (!empty($_POST['setting_title']) && !empty($_POST['setting_tagline'])) {
                    $title = $_POST['setting_title'] . config("title_separator") . $_POST['setting_tagline'];
                }
                else {
                    $title = $_POST['setting_title'];
                }

                if (!empty($_POST['setting_root'])) {
                    $this->user->update_header($this->data['config'], $_POST['setting_root'] . '/index.html', $title);
                }

                $_SESSION['toastr_success'] = 'Your settings have been saved!';
            }

            redirect('settings');
        }

        // Set page data and load the view
        $this->data['title'] = config('cms_name') . config('title_separator') . 'Settings';
        $this->data['media_info'] = get_dir_file_info($this->data['config']->setting_root . '/' . $this->data['config']->setting_media);
        $this->view('pages/settings', $this->data);
    }

    // --------------------------------------------------------------------

    /**
     * Download
     *
     * @return	void
     */

    public function download() {
        // Process the form
        if (!empty($_POST['download'])) {
            if ($_POST['download'] == "sql") {
                // Export .sql file
                if (!empty($this->data['config']->setting_database)) {
                    $this->setting->set_database($this->data['config']->setting_database);
                }

                $this->setting->backup();
            }
            else {
                // Export component in a .zip file
                $zip = $this->library('Zip');
                $path = APPPATH . 'logs/';
                $zip->read_dir($path, FALSE);
                $zip->download($_POST['download'].'_'.date('mdy').'.zip');
            }
        }
        redirect('settings');
    }

    // --------------------------------------------------------------------

    /**
     * CSS Editor
     *
     * @return	void
     */

    public function css_editor() {
        $path = $this->data['config']->setting_root . '/' . $this->data['config']->setting_css;

        // Process the form
        if (!empty($_POST)) {
            file_put_contents($path, $_POST['css_textarea']);
            redirect('settings/css_editor');
        }

        // Load CSS style sheet or blank if none
        $css = $this->setting->get_first_row("setting_css", array('user_id' => $_SESSION['user_id']));
        if (!empty($this->data['config']->setting_css)) {
            $this->data['css'] = file_get_contents($path);
        }
        else {
            $this->data['css'] = "";
        }

        // Set page data and load the view
        $this->data['title'] = config('cms_name') . config('title_separator') . 'CSS Editor';
        $this->view('pages/css_editor', $this->data);
    } 
}