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

	# list
	public function listUser()
	{
		if ($_SERVER['REQUEST_METHOD'] !== "POST") {
			http_response_code(405);
			return;
		}
		$this->load->model('model');
		$this->model->listUser();
	}
	public function listSupplier()
	{
		if ($_SERVER['REQUEST_METHOD'] !== "POST") {
			http_response_code(405);
			return;
		}
		$this->load->model('model');
		$this->model->listSupplier();
	}
	public function listCategory()
	{
		if ($_SERVER['REQUEST_METHOD'] !== "POST") {
			http_response_code(405);
			return;
		}
		$this->load->model('model');
		$this->model->listCategory();
	}
	public function listProduct()
	{
		if ($_SERVER['REQUEST_METHOD'] !== "POST") {
			http_response_code(405);
			return;
		}
		$this->load->model('model');
		$this->model->listProduct();
	}
	public function listCustomer()
	{
		if ($_SERVER['REQUEST_METHOD'] !== "POST") {
			http_response_code(405);
			return;
		}
		$this->load->model('model');
		$this->model->listCustomer();
	}
	# list

	# data
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
		if (!($name) || !($email)) {
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
		$get = $this->db->query("SELECT id, name, email, username FROM customers WHERE id = ? AND is_deleted IS NULL LIMIT 1", [$id]);
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
		if (!($name) || !($email)) {
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
}