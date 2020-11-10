<?php
defined('SYSPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| PDO Database Connectivity Settings
| -------------------------------------------------------------------
*/

$active_group = 'default';

$db['default'] = array(
	'hostname' => 'db_hostname',
	'username' => 'db_username',
	'password' => 'db_password',
	'database' => 'db_name'
);

$options = array(
	PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
	PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
	PDO::ATTR_EMULATE_PREPARES   => false,
);