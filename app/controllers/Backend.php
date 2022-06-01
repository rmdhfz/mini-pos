<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Backend extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->init();
	}

	private function init() 
	{
		$this->load->library('session');
		if (!$this->session->userdata('is_login') ){
			redirect(site_url(), 'refresh');
		}
	}
	private function load($params)
	{
		if (!$params) {
			return false;
		}
		$this->load->view('backend/index', $params);
	}

	public function monitoring()
	{
		$this->load([
			'file' => 'module/monitoring/index',
		]);
	}

	public function monitoringList()
	{
		$this->load->model('model');
		$this->model->monitoringList();
	}

	public function monitoringKick()
	{
		if ($_SERVER['REQUEST_METHOD'] !== "POST") {
			http_response_code(405);
			return;
		}
		$ip_address = post('ip_address');
		$this->load->database();
		$check = $this->db->query("SELECT id FROM history_login WHERE ip_address = ? LIMIT 1", [$ip_address])->num_rows();

		if ($check == 0) {
			json(response(false, 404, 'data not found'));
		}

		$delete = $this->db->where('ip_address', $ip_address)->delete('sessions');
		if (!$delete) {
			json(response(false, 500, 'failed delete session'));
		}
		json(response(true, 200, 'success'));
	}

	private function getTotal($table)
	{
		if (!$table) {
			return false;
		}
		$this->load->database();
		$get = $this->db->query("SELECT count(id) as total FROM $table WHERE is_deleted IS NULL");
		if ($get->num_rows() == 0) {
			json(response(false, 404, 'data not found'));
		}
		return $get->row();
	}

	# total
	public function totalUser()
	{
		json(response(true, 200, 'success', $this->getTotal('users')));
	}
	public function totalSupplier()
	{
		json(response(true, 200, 'success', $this->getTotal('suppliers')));
	}
	public function totalProduk()
	{
		json(response(true, 200, 'success', $this->getTotal('product')));
	}
	public function totalPelanggan()
	{
		json(response(true, 200, 'success', $this->getTotal('customers')));
	}
	public function totalPembelian()
	{
		json(response(true, 200, 'success', $this->getTotal('purchase')));
	}
	public function totalPenjualan()
	{
		json(response(true, 200, 'success', $this->getTotal('sell')));
	}
	# total

	# list
	public function listUser()
	{
		$this->load->model('model');
		$this->model->listUser();
	}
	public function listSupplier()
	{
		$this->load->model('model');
		$this->model->listSupplier();
	}
	public function listCategory()
	{
		$this->load->model('model');
		$this->model->listCategory();
	}
	public function listProduct()
	{
		$this->load->model('model');
		$this->model->listProduct();
	}
	public function listCustomer()
	{
		$this->load->model('model');
		$this->model->listCustomer();
	}
	public function listPurchase()
	{
		$this->load->model('model');
		$this->model->listPurchase();
	}
	public function listSell()
	{
		$this->load->model('model');
		$this->model->listSell();
	}
	# list

	# data
	public function dataSupplier()
	{
		if ($_SERVER['REQUEST_METHOD'] !== "POST") {
			http_response_code(405);
			return;
		}
		$this->load->database();
		$data = $this->db->query("SELECT id, name FROM suppliers WHERE is_deleted IS NULL");
		json(response(true, 200, 'success', $data->result()));
	}
	public function dataCategory()
	{
		if ($_SERVER['REQUEST_METHOD'] !== "POST") {
			http_response_code(405);
			return;
		}
		$this->load->database();
		$data = $this->db->query("SELECT id, name FROM category WHERE is_deleted IS NULL");
		json(response(true, 200, 'success', $data->result()));
	}
	public function dataProduct()
	{
		if ($_SERVER['REQUEST_METHOD'] !== "POST") {
			http_response_code(405);
			return;
		}
		$category_id = post('category_id');
		if (!($category_id)) {
			json(response(false, 400, 'bad request'));
		}
		$this->load->database();
		$check = $this->db->query("SELECT id FROM category WHERE id = ? AND is_deleted IS NULL", [$category_id])->num_rows();
		if ($check == 0) {
			json(response(false, 404, 'category not found'));
		}
		$data = $this->db->query("SELECT id, name, price, description, img FROM product WHERE is_deleted IS NULL AND is_publish = 1");
		json(response(true, 200, 'success', $data->result()));
	}
	public function dataCustomer()
	{
		if ($_SERVER['REQUEST_METHOD'] !== "POST") {
			http_response_code(405);
			return;
		}
		$this->load->database();
		$data = $this->db->query("SELECT id, name, email FROM customers WHERE is_deleted IS NULL AND is_active = 1");
		json(response(true, 200, 'success', $data->result()));
	}
	# data

	public function index() 
	{
		$this->load([
			'file'	=> 'module/dashboard/index',
		]);
	}
	public function logout() 
	{
		$confirm = $this->input->get('confirm', true);
		if (!$confirm) {
			redirect(site_url('dashboard'), 'refresh');
		}
		$this->session->sess_destroy();
		redirect(site_url());
	}

	# user
	public function user()
	{
		$this->load([
			'file' => 'module/user/index'
		]);
	}
	public function userAdd()
	{
		if ($_SERVER['REQUEST_METHOD'] !== "POST") {
			http_response_code(405);
			return;
		}
		$name  = post('name');
		$email = post('email');
		if (!($name) || !($email)) {
            json(response(false, 400, 'bad request'));
		}
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            json(response(false, 400, 'email not valid'));
        }
        $username = post('username');
        $password = post('password');
        if (!($username) || !($password)) {
            json(response(false, 400, 'bad request'));
		}
		$status = (int) post('status');
		$this->load->database();
		$check = $this->db->query("SELECT id FROM users WHERE email = ? AND is_deleted IS NULL LIMIT 1", [$email])->num_rows();
		if ($check > 0) {
			json(response(false, 400, 'user already exist'));
		}
		$create = $this->db->insert('users', [
			'name'			=> $name,
			'email'			=> $email,
			'username'		=> $username,
			'password'		=> password_hash($password, PASSWORD_DEFAULT),
			'is_active'		=> $status,
			'created_by'	=> session('user_name'),
		]);
		if (!$create) {
			json(response(false, 500, 'failed'));
		}
		json(response(true, 201, 'success, created'));
	}
	public function userId()
	{
		if ($_SERVER['REQUEST_METHOD'] !== "POST") {
			http_response_code(405);
			return;
		}
		$id = post('id');
		if (!$id) {
			json(response(false, 400, 'bad request'));
		}
		$this->load->database();
		$get = $this->db->query("SELECT id, name, email, username, is_active FROM users WHERE id = ? AND is_deleted IS NULL LIMIT 1", [$id]);
		if ($get->num_rows() == 0) {
			json(response(false, 404, 'data not found'));
		}
		json(response(true, 200, 'success', $get->row()));
	}
	public function userUpdate()
	{
		if ($_SERVER['REQUEST_METHOD'] !== "POST") {
			http_response_code(405);
			return;
		}
		$id = post('id');
		if (!$id) {
			json(response(false, 400, 'bad request'));
		}
		$name  = post('name');
		$email = post('email');
		if (!($name) || !($email)) {
            json(response(false, 400, 'bad request'));
		}
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            json(response(false, 400, 'email not valid'));
        }
        $username = post('username');
        $password = post('password');
        if (!($username) || !($password)) {
            json(response(false, 400, 'bad request'));
		}
		$status = (int) post('status');
		$this->load->database();
		$check = $this->db->query("SELECT id FROM users WHERE id = ? AND is_deleted IS NULL LIMIT 1", [$id])->num_rows();
		if ($check == 0) {
			json(response(false, 400, 'user not found'));
		}
		$update = $this->db->where('id', $id)->update('users', [
			'name'			=> $name,
			'email'			=> $email,
			'username'		=> $username,
			'password'		=> password_hash($password, PASSWORD_DEFAULT),
			'is_active'		=> $status,
			'updated_at'	=> date('Y-m-d h:i:s'),
			'updated_by'	=> session('user_name'),
		]);
		if (!$update) {
			json(response(false, 500, 'failed'));
		}
		json(response(true, 201, 'success, updated'));
	}
	public function userDelete()
	{
		if ($_SERVER['REQUEST_METHOD'] !== "POST") {
			http_response_code(405);
			return;
		}
		$id = post('id');
		if (!$id) {
			json(response(false, 400, 'bad request'));
		}
		$this->load->database();
		$check = $this->db->query("SELECT id FROM users WHERE id = ? AND is_deleted IS NULL LIMIT 1", [$id])->num_rows();
		if ($check == 0) {
			json(response(false, 400, 'user not found'));
		}
		$update = $this->db->where('id', $id)->update('users', [
			'is_deleted'	=> 1,
			'deleted_at'	=> date('Y-m-d h:i:s'),
			'deleted_by'	=> session('user_name'),
		]);
		if (!$update) {
			json(response(false, 500, 'failed'));
		}
		json(response(true, 201, 'success, deleted'));
	}
	# user

	# supplier
	public function supplier()
	{
		$this->load([
			'file' => 'module/supplier/index'
		]);
	}
	public function supplierAdd()
	{
		if ($_SERVER['REQUEST_METHOD'] !== "POST") {
			http_response_code(405);
			return;
		}
		$name  = post('name');
		if (!($name)) {
            json(response(false, 400, 'bad request'));
		}
		$this->load->database();
		$check = $this->db->query("SELECT id FROM suppliers WHERE name = ? AND is_deleted IS NULL LIMIT 1", [$name])->num_rows();
		if ($check > 0) {
			json(response(false, 400, 'supplier already exist'));
		}
		$create = $this->db->insert('suppliers', [
			'name'			=> $name,
			'created_by'	=> session('user_name'),
		]);
		if (!$create) {
			json(response(false, 500, 'failed'));
		}
		json(response(true, 201, 'success, created'));
	}
	public function supplierId()
	{
		if ($_SERVER['REQUEST_METHOD'] !== "POST") {
			http_response_code(405);
			return;
		}
		$id = post('id');
		if (!$id) {
			json(response(false, 400, 'bad request'));
		}
		$this->load->database();
		$get = $this->db->query("SELECT id, name FROM suppliers WHERE id = ? AND is_deleted IS NULL LIMIT 1", [$id]);
		if ($get->num_rows() == 0) {
			json(response(false, 404, 'data not found'));
		}
		json(response(true, 200, 'success', $get->row()));
	}
	public function supplierUpdate()
	{
		if ($_SERVER['REQUEST_METHOD'] !== "POST") {
			http_response_code(405);
			return;
		}
		$id = post('id');
		if (!$id) {
			json(response(false, 400, 'bad request'));
		}
		$name  = post('name');
		if (!($name)) {
            json(response(false, 400, 'bad request'));
		}
		$this->load->database();
		$check = $this->db->query("SELECT id FROM suppliers WHERE id = ? AND is_deleted IS NULL LIMIT 1", [$id])->num_rows();
		if ($check == 0) {
			json(response(false, 400, 'supplier not found'));
		}
		$update = $this->db->where('id', $id)->update('suppliers', [
			'name'			=> $name,
			'updated_at'	=> date('Y-m-d h:i:s'),
			'updated_by'	=> session('user_name'),
		]);
		if (!$update) {
			json(response(false, 500, 'failed'));
		}
		json(response(true, 201, 'success, updated'));
	}
	public function supplierDelete()
	{
		if ($_SERVER['REQUEST_METHOD'] !== "POST") {
			http_response_code(405);
			return;
		}
		$id = post('id');
		if (!$id) {
			json(response(false, 400, 'bad request'));
		}
		$this->load->database();
		$check = $this->db->query("SELECT id FROM suppliers WHERE id = ? AND is_deleted IS NULL LIMIT 1", [$id])->num_rows();
		if ($check == 0) {
			json(response(false, 400, 'supplier not found'));
		}
		$update = $this->db->where('id', $id)->update('suppliers', [
			'is_deleted'	=> 1,
			'deleted_at'	=> date('Y-m-d h:i:s'),
			'deleted_by'	=> session('user_name'),
		]);
		if (!$update) {
			json(response(false, 500, 'failed'));
		}
		json(response(true, 201, 'success, deleted'));
	}
	# supplier

	# category
	public function category()
	{
		$this->load([
			'file' => 'module/category/index'
		]);
	}
	public function categoryAdd()
	{
		if ($_SERVER['REQUEST_METHOD'] !== "POST") {
			http_response_code(405);
			return;
		}
		$name  = post('name');
		if (!($name)) {
            json(response(false, 400, 'bad request'));
		}
		$this->load->database();
		$check = $this->db->query("SELECT id FROM category WHERE name = ? AND is_deleted IS NULL LIMIT 1", [$name])->num_rows();
		if ($check > 0) {
			json(response(false, 400, 'category already exist'));
		}
		$create = $this->db->insert('category', [
			'name'			=> $name,
			'created_by'	=> session('user_name'),
		]);
		if (!$create) {
			json(response(false, 500, 'failed'));
		}
		json(response(true, 201, 'success, created'));
	}
	public function categoryId()
	{
		if ($_SERVER['REQUEST_METHOD'] !== "POST") {
			http_response_code(405);
			return;
		}
		$id = post('id');
		if (!$id) {
			json(response(false, 400, 'bad request'));
		}
		$this->load->database();
		$get = $this->db->query("SELECT id, name FROM category WHERE id = ? AND is_deleted IS NULL LIMIT 1", [$id]);
		if ($get->num_rows() == 0) {
			json(response(false, 404, 'data not found'));
		}
		json(response(true, 200, 'success', $get->row()));
	}
	public function categoryUpdate()
	{
		if ($_SERVER['REQUEST_METHOD'] !== "POST") {
			http_response_code(405);
			return;
		}
		$id = post('id');
		if (!$id) {
			json(response(false, 400, 'bad request'));
		}
		$name  = post('name');
		if (!($name)) {
            json(response(false, 400, 'bad request'));
		}
		$this->load->database();
		$check = $this->db->query("SELECT id FROM category WHERE id = ? AND is_deleted IS NULL LIMIT 1", [$id])->num_rows();
		if ($check == 0) {
			json(response(false, 400, 'category not found'));
		}
		$update = $this->db->where('id', $id)->update('category', [
			'name'			=> $name,
			'updated_at'	=> date('Y-m-d h:i:s'),
			'updated_by'	=> session('user_name'),
		]);
		if (!$update) {
			json(response(false, 500, 'failed'));
		}
		json(response(true, 201, 'success, updated'));
	}
	public function categoryDelete()
	{
		if ($_SERVER['REQUEST_METHOD'] !== "POST") {
			http_response_code(405);
			return;
		}
		$id = post('id');
		if (!$id) {
			json(response(false, 400, 'bad request'));
		}
		$this->load->database();
		$check = $this->db->query("SELECT id FROM category WHERE id = ? AND is_deleted IS NULL LIMIT 1", [$id])->num_rows();
		if ($check == 0) {
			json(response(false, 400, 'category not found'));
		}
		$update = $this->db->where('id', $id)->update('category', [
			'is_deleted'	=> 1,
			'deleted_at'	=> date('Y-m-d h:i:s'),
			'deleted_by'	=> session('user_name'),
		]);
		if (!$update) {
			json(response(false, 500, 'failed'));
		}
		json(response(true, 201, 'success, deleted'));
	}
	# category

	# product
	public function product()
	{
		$this->load([
			'file' => 'module/product/index'
		]);
	}
	public function productAdd()
	{
		if ($_SERVER['REQUEST_METHOD'] !== "POST") {
			http_response_code(405);
			return;
		}
		$category_id = post('category_id');
		$name  = post('name');
		$price = post('price');
		$status = post('status');
		$description = $this->input->post('description'); # ignore description
		if (!($name) || !($category_id) || !($price) || !($description)) {
            json(response(false, 400, 'bad request'));
		}

		$upload = _uploadFile(PATH_PRODUCT, 'file');
		if (!$upload) {
			json(response(false, 400, 'failed upload'));
		}

		$this->load->database();
		# check category
		$category = $this->db->query("SELECT id FROM category WHERE id = ? AND is_deleted IS NULL LIMIT 1", [$category_id])->num_rows();
		if ($category == 0) {
			json(response(false, 404, 'category not found'));
		}

		$check = $this->db->query("SELECT id FROM product WHERE name = ? AND category_id = ? AND is_deleted IS NULL LIMIT 1", [$name, $category_id])->num_rows();
		if ($check > 0) {
			json(response(false, 400, 'product already exist'));
		}
		$create = $this->db->insert('product', [
			'category_id'	=>	$category_id,
			'name'			=>	$name,
			'price'			=>	$price,
			'img'			=>	$upload['file_name'],
			'description'	=>	$description,
			'is_publish'	=>	$status,
			'created_by'	=>	session('user_name'),
		]);
		if (!$create) {
			json(response(false, 500, 'failed'));
		}
		json(response(true, 201, 'success, created'));
	}
	public function productId()
	{
		if ($_SERVER['REQUEST_METHOD'] !== "POST") {
			http_response_code(405);
			return;
		}
		$id = post('id');
		if (!$id) {
			json(response(false, 400, 'bad request'));
		}
		$this->load->database();
		$get = $this->db->query("SELECT id, name, category_id, price, img, is_publish, description FROM product WHERE id = ? AND is_deleted IS NULL LIMIT 1", [$id]);
		if ($get->num_rows() == 0) {
			json(response(false, 404, 'data not found'));
		}
		json(response(true, 200, 'success', $get->row()));
	}
	public function productUpdate()
	{
		if ($_SERVER['REQUEST_METHOD'] !== "POST") {
			http_response_code(405);
			return;
		}
		$id = post('id');
		if (!$id) {
			json(response(false, 400, 'bad request'));
		}
		$category_id = post('category_id');
		$name  = post('name');
		$price = post('price');
		$fileold = post('fileold');
		$status = post('status');
		$description = $this->input->post('description'); # ignore description
		if (!($name) || !($category_id) || !($price) || !($description)) {
            json(response(false, 400, 'bad requests'));
		}
		
		$file = $fileold;

		# check new image
		if (is_uploaded_file($_FILES['file']['tmp_name'])) {
			# delete old file
			$filename = PATH_PRODUCT.'/'.$fileold;
			if (!file_exists($filename)) {
				json(response(false, 404, 'old file not found'));
			}
			unlink($filename);

			# upload new file
			$upload = _uploadFile(PATH_PRODUCT, 'file');
			if (!$upload) {
				json(response(false, 400, 'failed upload'));
			}
			$file = $upload['file_name'];
		}

		$this->load->database();
		
		# check category
		$category = $this->db->query("SELECT id FROM category WHERE id = ? AND is_deleted IS NULL LIMIT 1", [$category_id])->num_rows();
		if ($category == 0) {
			json(response(false, 404, 'category not found'));
		}

		$check = $this->db->query("SELECT id FROM product WHERE id = ? AND is_deleted IS NULL LIMIT 1", [$id])->num_rows();
		if ($check == 0) {
			json(response(false, 400, 'product not found'));
		}
		$update = $this->db->where('id', $id)->update('product', [
			'category_id'	=>	$category_id,
			'name'			=>	$name,
			'price'			=>	$price,
			'img'			=>	$file,
			'description'	=>	$description,
			'is_publish'	=>	$status,
			'created_by'	=>	session('user_name'),
		]);
		if (!$update) {
			json(response(false, 500, 'failed'));
		}
		json(response(true, 201, 'success, updated'));
	}
	public function productDelete()
	{
		if ($_SERVER['REQUEST_METHOD'] !== "POST") {
			http_response_code(405);
			return;
		}
		$id = post('id');
		if (!$id) {
			json(response(false, 400, 'bad request'));
		}
		$this->load->database();
		$check = $this->db->query("SELECT id, img FROM product WHERE id = ? AND is_deleted IS NULL LIMIT 1", [$id]);
		if ($check->num_rows() == 0) {
			json(response(false, 400, 'product not found'));
		}
		# delete old file
		$filename = PATH_PRODUCT.'/'.$check->row()->img;
		if (!file_exists($filename)) {
			json(response(false, 404, 'old file not found'));
		}
		unlink($filename);
		$update = $this->db->where('id', $id)->update('product', [
			'is_deleted'	=> 1,
			'deleted_at'	=> date('Y-m-d h:i:s'),
			'deleted_by'	=> session('user_name'),
		]);
		if (!$update) {
			json(response(false, 500, 'failed'));
		}
		json(response(true, 201, 'success, deleted'));
	}
	# product

	# customer
	public function customer()
	{
		$this->load([
			'file' => 'module/customer/index'
		]);
	}
	public function customerAdd()
	{
		if ($_SERVER['REQUEST_METHOD'] !== "POST") {
			http_response_code(405);
			return;
		}
		$name  = post('name');
		$email = post('email');
		$status = post('status');
		if (!($name) || !($email) || !($status)) {
            json(response(false, 400, 'bad request'));
		}
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            json(response(false, 400, 'email not valid'));
        }
		$this->load->database();
		$check = $this->db->query("SELECT id FROM customers WHERE email = ? AND is_deleted IS NULL LIMIT 1", [$email])->num_rows();
		if ($check > 0) {
			json(response(false, 400, 'customer already exist'));
		}
		$create = $this->db->insert('customers', [
			'name'			=> $name,
			'email'			=> $email,
			'is_active'		=> $status,
			'created_by'	=> session('user_name'),
		]);
		if (!$create) {
			json(response(false, 500, 'failed'));
		}
		json(response(true, 201, 'success, created'));
	}
	public function customerId()
	{
		if ($_SERVER['REQUEST_METHOD'] !== "POST") {
			http_response_code(405);
			return;
		}
		$id = post('id');
		if (!$id) {
			json(response(false, 400, 'bad request'));
		}
		$this->load->database();
		$get = $this->db->query("SELECT id, name, email, is_active FROM customers WHERE id = ? AND is_deleted IS NULL LIMIT 1", [$id]);
		if ($get->num_rows() == 0) {
			json(response(false, 404, 'data not found'));
		}
		json(response(true, 200, 'success', $get->row()));
	}
	public function customerUpdate()
	{
		if ($_SERVER['REQUEST_METHOD'] !== "POST") {
			http_response_code(405);
			return;
		}
		$id = post('id');
		if (!$id) {
			json(response(false, 400, 'bad request'));
		}
		$name  = post('name');
		$email = post('email');
		$status = post('status');
		if (!($name) || !($email) || !($status)) {
            json(response(false, 400, 'bad request'));
		}
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            json(response(false, 400, 'email not valid'));
        }
		$this->load->database();
		$check = $this->db->query("SELECT id FROM customers WHERE id = ? AND is_deleted IS NULL LIMIT 1", [$id])->num_rows();
		if ($check == 0) {
			json(response(false, 400, 'customer not found'));
		}
		$update = $this->db->where('id', $id)->update('customers', [
			'name'			=> $name,
			'email'			=> $email,
			'is_active'		=> $status,
			'updated_at'	=> date('Y-m-d h:i:s'),
			'updated_by'	=> session('user_name'),
		]);
		if (!$update) {
			json(response(false, 500, 'failed'));
		}
		json(response(true, 201, 'success, updated'));
	}
	public function customerDelete()
	{
		if ($_SERVER['REQUEST_METHOD'] !== "POST") {
			http_response_code(405);
			return;
		}
		$id = post('id');
		if (!$id) {
			json(response(false, 400, 'bad request'));
		}
		$this->load->database();
		$check = $this->db->query("SELECT id FROM customers WHERE id = ? AND is_deleted IS NULL LIMIT 1", [$id])->num_rows();
		if ($check == 0) {
			json(response(false, 400, 'customer not found'));
		}
		$update = $this->db->where('id', $id)->update('customers', [
			'is_deleted'	=> 1,
			'deleted_at'	=> date('Y-m-d h:i:s'),
			'deleted_by'	=> session('user_name'),
		]);
		if (!$update) {
			json(response(false, 500, 'failed'));
		}
		json(response(true, 201, 'success, deleted'));
	}
	# customer

	# purchase
	public function purchase()
	{
		$this->load([
			'file' => 'module/purchase/index'
		]);
	}
	public function purchaseAdd()
	{
		if ($_SERVER['REQUEST_METHOD'] !== "POST") {
			http_response_code(405);
			return;
		}
		$supplier_id = post('supplier_id');
		$category_id = post('category_id');
		$product_id = post('product_id');
		$note = $this->input->post('note');
		$qty = post('qty');
		$total = post('total');
		if (
			!($supplier_id) ||
			!($category_id) || 
			!($product_id) || 
			!($note) || 
			!($qty) || 
			!($total)
		) {
			json(response(false, 400, 'bad request'));
		}
		# check supplier, category, product
		$this->load->database();
		$check_supplier = $this->db->query("SELECT id FROM suppliers WHERE id = ? AND is_deleted IS NULL LIMIT 1", [$supplier_id])->num_rows();
		if ($check_supplier == 0) {
			json(response(false, 404, 'supplier not found'));
		}
		$check_category = $this->db->query("SELECT id FROM category WHERE id = ? AND is_deleted IS NULL LIMIT 1", [$category_id])->num_rows();
		if ($check_category == 0) {
			json(response(false, 404, 'category not found'));
		}
		$check_product = $this->db->query("SELECT id FROM product WHERE id = ? AND is_deleted IS NULL LIMIT 1", [$product_id])->num_rows();
		if ($check_product == 0) {
			json(response(false, 404, 'product not found'));
		}

		$create = $this->db->insert('purchase', [
			'supplier_id'	=> $supplier_id,
			'category_id'	=> $category_id,
			'product_id'	=> $product_id,
			'note'			=> $note,
			'qty'			=> $qty,
			'total'			=> $total,
			'created_by'	=> session('user_name'),
		]);
		if (!$create) {
			json(response(false, 500, 'failed create purchase'));
		}
		json(response(true, 201, 'success create purchase'));
	}
	public function purchaseId()
	{
		if ($_SERVER['REQUEST_METHOD'] !== "POST") {
			http_response_code(405);
			return;
		}
		$id = post('id');
		if (!$id) {
			json(response(false, 400, 'bad request'));
		}
		$this->load->database();
		$get = $this->db->query("
				SELECT 
				p.id, p.supplier_id, 
				p.category_id, p.product_id, 
				p.qty, p.total, p.note,
				pd.price
				
				FROM purchase p
				INNER JOIN product pd ON p.product_id = pd.id
				WHERE 
				p.id = ? AND 
				p.is_deleted IS NULL LIMIT 1
			", [$id]);
		if ($get->num_rows() == 0) {
			json(response(false, 404, 'data not found'));
		}
		json(response(true, 200, 'success', $get->row()));
	}
	public function purchaseUpdate()
	{
		if ($_SERVER['REQUEST_METHOD'] !== "POST") {
			http_response_code(405);
			return;
		}
		$id = post('id');
		$supplier_id = post('supplier_id');
		$category_id = post('category_id');
		$product_id = post('product_id');
		$note = $this->input->post('note');
		$qty = post('qty');
		$total = post('total');
		if (
			!($id) ||
			!($supplier_id) ||
			!($category_id) || 
			!($product_id) || 
			!($note) || 
			!($qty) || 
			!($total)
		) {
			json(response(false, 400, 'bad request'));
		}
		# check supplier, category, product
		$this->load->database();
		$check_supplier = $this->db->query("SELECT id FROM suppliers WHERE id = ? AND is_deleted IS NULL LIMIT 1", [$supplier_id])->num_rows();
		if ($check_supplier == 0) {
			json(response(false, 404, 'supplier not found'));
		}
		$check_category = $this->db->query("SELECT id FROM category WHERE id = ? AND is_deleted IS NULL LIMIT 1", [$category_id])->num_rows();
		if ($check_category == 0) {
			json(response(false, 404, 'category not found'));
		}
		$check_product = $this->db->query("SELECT id FROM product WHERE id = ? AND is_deleted IS NULL LIMIT 1", [$product_id])->num_rows();
		if ($check_product == 0) {
			json(response(false, 404, 'product not found'));
		}

		# check data
		$check = $this->db->query("SELECT id FROM purchase WHERE id = ? AND is_deleted IS NULL LIMIT 1", [$id])->num_rows();

		if ($check == 0) {
			json(response(false, 404, 'data not found'));
		}

		$update = $this->db->where('id', $id)->update('purchase', [
			'supplier_id'	=> $supplier_id,
			'category_id'	=> $category_id,
			'product_id'	=> $product_id,
			'note'			=> $note,
			'qty'			=> $qty,
			'total'			=> $total,
			'updated_by'	=> session('user_name'),
		]);
		if (!$update) {
			json(response(false, 500, 'failed update purchase'));
		}
		json(response(true, 201, 'success update purchase'));
	}
	public function purchaseDelete()
	{
		if ($_SERVER['REQUEST_METHOD'] !== "POST") {
			http_response_code(405);
			return;
		}
		$id = post('id');
		if (!$id) {
			json(response(false, 400, 'bad request'));
		}
		$this->load->database();
		$check = $this->db->query("SELECT id FROM purchase WHERE id = ? AND is_deleted IS NULL LIMIT 1", [$id])->num_rows();
		if ($check == 0) {
			json(response(false, 400, 'purchase not found'));
		}
		$update = $this->db->where('id', $id)->update('purchase', [
			'is_deleted'	=> 1,
			'deleted_at'	=> date('Y-m-d h:i:s'),
			'deleted_by'	=> session('user_name'),
		]);
		if (!$update) {
			json(response(false, 500, 'failed'));
		}
		json(response(true, 201, 'success, deleted'));
	}
	# purchase

	# sell
	public function sell()
	{
		$this->load([
			'file' => 'module/sell/index'
		]);
	}
	public function sellAdd()
	{
		if ($_SERVER['REQUEST_METHOD'] !== "POST") {
			http_response_code(405);
			return;
		}
		$customer_id = post('customer_id');
		$category_id = post('category_id');
		$product_id = post('product_id');
		$note = $this->input->post('note');
		$qty = post('qty');
		$total = post('total');
		if (
			!($customer_id) ||
			!($category_id) || 
			!($product_id) || 
			!($note) || 
			!($qty) || 
			!($total)
		) {
			json(response(false, 400, 'bad request'));
		}
		# check supplier, category, product
		$this->load->database();
		$check_customer = $this->db->query("SELECT id FROM customers WHERE id = ? AND is_deleted IS NULL LIMIT 1", [$customer_id])->num_rows();
		if ($check_customer == 0) {
			json(response(false, 404, 'customer not found'));
		}
		$check_category = $this->db->query("SELECT id FROM category WHERE id = ? AND is_deleted IS NULL LIMIT 1", [$category_id])->num_rows();
		if ($check_category == 0) {
			json(response(false, 404, 'category not found'));
		}
		$check_product = $this->db->query("SELECT id FROM product WHERE id = ? AND is_deleted IS NULL LIMIT 1", [$product_id])->num_rows();
		if ($check_product == 0) {
			json(response(false, 404, 'product not found'));
		}

		$create = $this->db->insert('sell', [
			'customer_id'	=> $customer_id,
			'category_id'	=> $category_id,
			'product_id'	=> $product_id,
			'note'	=> $note,
			'qty'			=> $qty,
			'total'			=> $total,
			'created_by'	=> session('user_name'),
		]);
		if (!$create) {
			json(response(false, 500, 'failed create sell'));
		}
		json(response(true, 201, 'success create sell'));
	}
	public function sellId()
	{
		if ($_SERVER['REQUEST_METHOD'] !== "POST") {
			http_response_code(405);
			return;
		}
		$id = post('id');
		if (!$id) {
			json(response(false, 400, 'bad request'));
		}
		$this->load->database();
		$get = $this->db->query("
				SELECT 
				p.id, p.customer_id, 
				p.category_id, p.product_id, 
				p.qty, p.total, p.note,
				pd.price
				
				FROM sell p
				INNER JOIN product pd ON p.product_id = pd.id
				WHERE 
				p.id = ? AND 
				p.is_deleted IS NULL LIMIT 1
			", [$id]);
		if ($get->num_rows() == 0) {
			json(response(false, 404, 'data not found'));
		}
		json(response(true, 200, 'success', $get->row()));
	}
	public function sellUpdate()
	{
		if ($_SERVER['REQUEST_METHOD'] !== "POST") {
			http_response_code(405);
			return;
		}
		$id = post('id');
		$customer_id = post('customer_id');
		$category_id = post('category_id');
		$product_id = post('product_id');
		$note = $this->input->post('note');
		$qty = post('qty');
		$total = post('total');
		if (
			!($id) ||
			!($customer_id) ||
			!($category_id) || 
			!($product_id) || 
			!($note) || 
			!($qty) || 
			!($total)
		) {
			json(response(false, 400, 'bad request'));
		}
		# check supplier, category, product
		$this->load->database();
		$check_customer = $this->db->query("SELECT id FROM customers WHERE id = ? AND is_deleted IS NULL LIMIT 1", [$customer_id])->num_rows();
		if ($check_customer == 0) {
			json(response(false, 404, 'customer not found'));
		}
		$check_category = $this->db->query("SELECT id FROM category WHERE id = ? AND is_deleted IS NULL LIMIT 1", [$category_id])->num_rows();
		if ($check_category == 0) {
			json(response(false, 404, 'category not found'));
		}
		$check_product = $this->db->query("SELECT id FROM product WHERE id = ? AND is_deleted IS NULL LIMIT 1", [$product_id])->num_rows();
		if ($check_product == 0) {
			json(response(false, 404, 'product not found'));
		}

		# check data
		$check = $this->db->query("SELECT id FROM sell WHERE id = ? AND is_deleted IS NULL LIMIT 1", [$id])->num_rows();

		if ($check == 0) {
			json(response(false, 404, 'data not found'));
		}

		$update = $this->db->where('id', $id)->update('sell', [
			'customer_id'	=> $customer_id,
			'category_id'	=> $category_id,
			'product_id'	=> $product_id,
			'note'			=> $note,
			'qty'			=> $qty,
			'total'			=> $total,
			'updated_by'	=> session('user_name'),
		]);
		if (!$update) {
			json(response(false, 500, 'failed update sell'));
		}
		json(response(true, 201, 'success update sell'));
	}
	public function sellDelete()
	{
		if ($_SERVER['REQUEST_METHOD'] !== "POST") {
			http_response_code(405);
			return;
		}
		$id = post('id');
		if (!$id) {
			json(response(false, 400, 'bad request'));
		}
		$this->load->database();
		$check = $this->db->query("SELECT id FROM sell WHERE id = ? AND is_deleted IS NULL LIMIT 1", [$id])->num_rows();
		if ($check == 0) {
			json(response(false, 400, 'sell not found'));
		}
		$update = $this->db->where('id', $id)->update('sell', [
			'is_deleted'	=> 1,
			'deleted_at'	=> date('Y-m-d h:i:s'),
			'deleted_by'	=> session('user_name'),
		]);
		if (!$update) {
			json(response(false, 500, 'failed'));
		}
		json(response(true, 201, 'success, deleted'));
	}
	# sell
}