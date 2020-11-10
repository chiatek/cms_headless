<?php
defined('SYSPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Base Site URL
|--------------------------------------------------------------------------
*/
$config['base_url'] = (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . preg_replace('@/+$@', '', dirname($_SERVER['SCRIPT_NAME'])) . '/';

/*
|--------------------------------------------------------------------------
| Default Controller and Method
|--------------------------------------------------------------------------
*/
$config['default_controller'] = 'dashboard';
$config['alternate_controller'] = 'users';
$config['default_method'] = 'index';

/*
|--------------------------------------------------------------------------
| Halografix CMS
|--------------------------------------------------------------------------
*/
$config['cms_name'] = $_SERVER['HTTP_HOST'];
$config['cms_version'] = '3.0.1';

/*
|--------------------------------------------------------------------------
| Website title / page title separator
|--------------------------------------------------------------------------
*/
$config['title_separator'] = ' | ';

/*
|--------------------------------------------------------------------------
| Table/Query Results Limit
|--------------------------------------------------------------------------
*/
$config['field_limit'] = 6;
$config['dashboard_comments_limit'] = 4;
$config['dashboard_posts_limit'] = 4;
$config['summary_sentence_limit'] = 1;