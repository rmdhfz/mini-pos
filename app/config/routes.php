<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route = [
	'404_override' => "",
	// ------------------------------------------------------------------------
	'default_controller'	=>	'Frontend',
	'verify'				=>	'Frontend/login',
	'dashboard'				=>	'Backend',
	'logout'				=>	'Backend/logout',

	# user
	'user'					=> 'Backend/user',
	'user/add'				=> 'Backend/userAdd',
	'user/id'				=> 'Backend/userId',
	'user/update'			=> 'Backend/userUpdate',
	'user/delete'			=> 'Backend/userDelete',
	# user
];