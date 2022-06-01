<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->init();
        $this->load->database();
    }

    private function init() 
    {
		$this->load->library('session');
		if (!$this->session->userdata('is_login') ){
			redirect(site_url(), 'refresh');
			return false;
		}
	}
	private function createOptions($id)
	{
		if (!$id) {
			return false;
		}
		return '
		<button id="edit" data-id="'.$id.'" class="btn btn-flat btn-sm btn-info"> edit </button>
		<button id="delete" data-id="'.$id.'" class="btn btn-flat btn-sm btn-danger"> hapus </button>';
	}

	# list
	public function listUser()
	{
		$get = $this->db->query("SELECT id, name, email, username, is_active, created_at, created_by FROM users WHERE is_deleted IS NULL");
		if ($get->num_rows() == 0) {
			json([]);
		}
		$no = 0;
		$result = ['data' => []];
		foreach ($get->result() as $key => $value) { $no++;
			$id = $value->id;
			$status = (int) ($value->is_active) == 1 ? "Aktif" : "Tidak Aktif";
			$options = $this->createOptions($id);
			if (!$options) {
				json("failed create options");
			}
			$result['data'][$key] = [
				$no,
				$value->name,
				$value->email,
				$value->username,
				$status,
				change_format_date($value->created_at),
				$value->created_by,
				$options
			];
		}
		json($result);
	}
	public function listSupplier()
	{
		$get = $this->db->query("SELECT id, name, created_at, created_by FROM suppliers WHERE is_deleted IS NULL");
		if ($get->num_rows() == 0) {
			json([]);
		}
		$no = 0;
		$result = ['data' => []];
		foreach ($get->result() as $key => $value) { $no++;
			$id = $value->id;
			$options = $this->createOptions($id);
			if (!$options) {
				json("failed create options");
			}
			$result['data'][$key] = [
				$no,
				$value->name,
				change_format_date($value->created_at),
				$value->created_by,
				$options
			];
		}
		json($result);
	}
	public function listCategory()
	{
		$get = $this->db->query("SELECT id, name, created_at, created_by FROM category WHERE is_deleted IS NULL");
		if ($get->num_rows() == 0) {
			json([]);
		}
		$no = 0;
		$result = ['data' => []];
		foreach ($get->result() as $key => $value) { $no++;
			$id = $value->id;
			$options = $this->createOptions($id);
			if (!$options) {
				json("failed create options");
			}
			$result['data'][$key] = [
				$no,
				$value->name,
				change_format_date($value->created_at),
				$value->created_by,
				$options
			];
		}
		json($result);
	}
	public function listProduct()
	{
		$get = $this->db->query("SELECT 
			p.id, 
			p.name,
			p.price, 
			p.img, 
			p.description, 
			p.created_at, 
			p.created_by,
			c.name as category

			FROM product p 
			INNER JOIN category c ON p.category_id = c.id
			WHERE p.is_deleted IS NULL");

		if ($get->num_rows() == 0) {
			json([]);
		}
		$no = 0;
		$result = ['data' => []];
		foreach ($get->result() as $key => $value) { $no++;
			$id = $value->id;
			$img = "<img class='img-thumbnail' draggable='false' src='".PATH_PRODUCT.$value->img."' loading='lazy' alt='product'>";
			$options = $this->createOptions($id);
			if (!$options) {
				json("failed create options");
			}
			$result['data'][$key] = [
				$no,
				$value->name,
				$value->category,
				$value->price,
				$value->description,
				$img,
				change_format_date($value->created_at),
				$value->created_by,
				$options
			];
		}
		json($result);
	}
	public function listCustomer()
	{
		$get = $this->db->query("SELECT id, name, email, is_active, created_at, created_by FROM customers WHERE is_deleted IS NULL");
		if ($get->num_rows() == 0) {
			json([]);
		}
		$no = 0;
		$result = ['data' => []];
		foreach ($get->result() as $key => $value) { $no++;
			$id = $value->id;
			$status = (int) ($value->is_active) == 1 ? "Aktif" : "Tidak Aktif";
			$options = $this->createOptions($id);
			if (!$options) {
				json("failed create options");
			}
			$result['data'][$key] = [
				$no,
				$value->name,
				$value->email,
				$status,
				change_format_date($value->created_at),
				$value->created_by,
				$options
			];
		}
		json($result);
	}
	public function listPurchase()
	{
		$get = $this->db->query("
			SELECT
			
			p.id, p.qty, p.total, p.note,
			p.created_at, p.created_by,
			s.name as supplier,
			k.name as category,
			pd.name as product

			FROM purchase p
			INNER JOIN suppliers s ON p.supplier_id = s.id
			INNER JOIN category k ON p.category_id = k.id
			INNER JOIN product pd ON p.product_id = pd.id

			WHERE
			p.is_deleted IS NULL AND
			k.is_deleted IS NULL AND
			pd.is_deleted IS NULL
		");
		if ($get->num_rows() == 0) {
			json([]);
		}
		$no = 0;
		$result = ['data' => []];
		foreach ($get->result() as $key => $value) { $no++;
			$id = $value->id;
			$note = ($value->note) == "" ? "-" : $value->note;
			$options = $this->createOptions($id);
			if (!$options) {
				json("failed create options");
			}
			$result['data'][$key] = [
				$no,
				$value->supplier,
				$value->category,
				$value->product,
				$value->qty,
				$value->total,
				$note,
				change_format_date($value->created_at),
				$value->created_by,
				$options
			];
		}
		json($result);
	}
	# list
}