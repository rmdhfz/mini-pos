<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Backend extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->init();
	}
	private function init() {
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
	public function index() {
		$this->load([
			'file'	=> 'module/dashboard/index',
		]);
	}
	public function logout() {
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
		if (empty($name) || empty($email)) {
            json(response(false, 400, 'bad request'));
		}
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            json(response(false, 400, 'email not valid'));
        }
        $username = post('username');
        $password = post('password');
        if (empty($username) || empty($password)) {
            json(response(false, 400, 'bad request'));
		}
		$this->load->database();
		$check = $this->db->query("SELECT id FROM users WHERE email = ? AND is_deleted = ? LIMIT 1", [$email, null])->num_rows();
		if ($check > 0) {
			json(response(false, 400, 'user already exist'));
		}
		$create = $this->db->insert('users', [
			'name'			=> $name,
			'email'			=> $email,
			'username'		=> $username,
			'password'		=> password_hash($password, PASSWORD_DEFAULT),
			'created_by'	=> session('user_name'),
		]);
		if (!$create) {
			json(response(false, 500, 'failed'));
		}
		json(response(true, 200, 'success, created'));
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
		$get = $this->db->query("SELECT id, name, email, username FROM users WHERE id = ? AND is_deleted = ? LIMIT 1", [$id, null]);
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
		if (empty($name) || empty($email)) {
            json(response(false, 400, 'bad request'));
		}
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            json(response(false, 400, 'email not valid'));
        }
        $username = post('username');
        $password = post('password');
        if (empty($username) || empty($password)) {
            json(response(false, 400, 'bad request'));
		}
		$this->load->database();
		$check = $this->db->query("SELECT id FROM users WHERE id = ? AND is_deleted = ? LIMIT 1", [$id, null])->num_rows();
		if ($check == 0) {
			json(response(false, 400, 'user not found'));
		}
		$update = $this->db->where('id', $id)->update('users', [
			'name'			=> $name,
			'email'			=> $email,
			'username'		=> $username,
			'password'		=> password_hash($password, PASSWORD_DEFAULT),
			'updated_at'	=> date('Y-m-d h:i:s'),
			'updated_by'	=> session('user_name'),
		]);
		if (!$update) {
			json(response(false, 500, 'failed'));
		}
		json(response(true, 200, 'success, updated'));
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
		$check = $this->db->query("SELECT id FROM users WHERE id = ? AND is_deleted = ? LIMIT 1", [$id, null])->num_rows();
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
		json(response(true, 200, 'success, deleted'));
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
		if (empty($name)) {
            json(response(false, 400, 'bad request'));
		}
		$this->load->database();
		$check = $this->db->query("SELECT id FROM suppliers WHERE name = ? AND is_deleted = ? LIMIT 1", [$name, null])->num_rows();
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
		json(response(true, 200, 'success, created'));
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
		$get = $this->db->query("SELECT id, name FROM suppliers WHERE id = ? AND is_deleted = ? LIMIT 1", [$id, null]);
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
		if (empty($name)) {
            json(response(false, 400, 'bad request'));
		}
		$this->load->database();
		$check = $this->db->query("SELECT id FROM suppliers WHERE id = ? AND is_deleted = ? LIMIT 1", [$id, null])->num_rows();
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
		json(response(true, 200, 'success, updated'));
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
		$check = $this->db->query("SELECT id FROM suppliers WHERE id = ? AND is_deleted = ? LIMIT 1", [$id, null])->num_rows();
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
		json(response(true, 200, 'success, deleted'));
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
		if (empty($name)) {
            json(response(false, 400, 'bad request'));
		}
		$this->load->database();
		$check = $this->db->query("SELECT id FROM category WHERE name = ? AND is_deleted = ? LIMIT 1", [$name, null])->num_rows();
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
		json(response(true, 200, 'success, created'));
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
		$get = $this->db->query("SELECT id, name FROM category WHERE id = ? AND is_deleted = ? LIMIT 1", [$id, null]);
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
		if (empty($name)) {
            json(response(false, 400, 'bad request'));
		}
		$this->load->database();
		$check = $this->db->query("SELECT id FROM category WHERE id = ? AND is_deleted = ? LIMIT 1", [$id, null])->num_rows();
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
		json(response(true, 200, 'success, updated'));
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
		$check = $this->db->query("SELECT id FROM category WHERE id = ? AND is_deleted = ? LIMIT 1", [$id, null])->num_rows();
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
		json(response(true, 200, 'success, deleted'));
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
		$description = post('description');
		if (empty($name) || empty($category_id) || empty($price) || empty($description)) {
            json(response(false, 400, 'bad request'));
		}

		$upload = _uploadFile(PATH_PRODUCT, 'file');
		if (!$upload) {
			json(response(false, 400, 'failed upload'));
		}
		
		$this->load->database();
		# check category
		$category = $this->db->query("SELECT id FROM category WHERE id = ? AND is_deleted = ? LIMIT 1", [$id, null])->num_rows();
		if ($category == 0) {
			json(response(false, 404, 'category not found'));
		}

		$check = $this->db->query("SELECT id FROM product WHERE name = ? AND category_id = ? AND is_deleted = ? LIMIT 1", [$name, $category_id, null])->num_rows();
		if ($check > 0) {
			json(response(false, 400, 'product already exist'));
		}
		$create = $this->db->insert('product', [
			'category_id'	=>	$category_id,
			'name'			=>	$name,
			'price'			=>	$price,
			'img'			=>	$upload['file_name'],
			'description'	=>	$description,
			'created_by'	=>	session('user_name'),
		]);
		if (!$create) {
			json(response(false, 500, 'failed'));
		}
		json(response(true, 200, 'success, created'));
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
		# check category
		$category = $this->db->query("SELECT id FROM category WHERE id = ? AND is_deleted = ? LIMIT 1", [$id, null])->num_rows();
		if ($category == 0) {
			json(response(false, 404, 'category not found'));
		}

		$get = $this->db->query("SELECT id, name, category_id FROM product WHERE id = ? AND is_deleted = ? LIMIT 1", [$id, null]);
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
		$description = post('description');
		if (empty($name) || empty($category_id) || empty($price) || empty($description)) {
            json(response(false, 400, 'bad request'));
		}

		$upload = _uploadFile(PATH_PRODUCT, 'file');
		if (!$upload) {
			json(response(false, 400, 'failed upload'));
		}
		$this->load->database();
		
		# check category
		$category = $this->db->query("SELECT id FROM category WHERE id = ? AND is_deleted = ? LIMIT 1", [$id, null])->num_rows();
		if ($category == 0) {
			json(response(false, 404, 'category not found'));
		}

		$check = $this->db->query("SELECT id FROM product WHERE id = ? AND is_deleted = ? LIMIT 1", [$id, null])->num_rows();
		if ($check == 0) {
			json(response(false, 400, 'product not found'));
		}
		$update = $this->db->where('id', $id)->update('product', [
			'category_id'	=>	$category_id,
			'name'			=>	$name,
			'price'			=>	$price,
			'img'			=>	$upload['file_name'],
			'description'	=>	$description,
			'created_by'	=>	session('user_name'),
		]);
		if (!$update) {
			json(response(false, 500, 'failed'));
		}
		json(response(true, 200, 'success, updated'));
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
		$check = $this->db->query("SELECT id FROM product WHERE id = ? AND is_deleted = ? LIMIT 1", [$id, null])->num_rows();
		if ($check == 0) {
			json(response(false, 400, 'product not found'));
		}
		$update = $this->db->where('id', $id)->update('product', [
			'is_deleted'	=> 1,
			'deleted_at'	=> date('Y-m-d h:i:s'),
			'deleted_by'	=> session('user_name'),
		]);
		if (!$update) {
			json(response(false, 500, 'failed'));
		}
		json(response(true, 200, 'success, deleted'));
	}
	# product
}