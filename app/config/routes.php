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

	# supplier
	'supplier'					=> 'Backend/supplier',
	'supplier/add'				=> 'Backend/supplierAdd',
	'supplier/id'				=> 'Backend/supplierId',
	'supplier/update'			=> 'Backend/supplierUpdate',
	'supplier/delete'			=> 'Backend/supplierDelete',
	# supplier

	# category
	'category'					=> 'Backend/category',
	'category/add'				=> 'Backend/categoryAdd',
	'category/id'				=> 'Backend/categoryId',
	'category/update'			=> 'Backend/categoryUpdate',
	'category/delete'			=> 'Backend/categoryDelete',
	# category
];