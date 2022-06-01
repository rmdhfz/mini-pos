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
			return;
		}
		if ($_SERVER['REQUEST_METHOD'] !== "POST") {
			http_response_code(405);
			return;
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

	public function monitoringList()
	{
		$get = $this->db->query("
			SELECT
			
			u.name as user,
			p.*

			FROM history_login p
			INNER JOIN users u ON p.user_id = p.id");
		if ($get->num_rows() == 0) {
			json([]);
		}
		$no = 0;
		$result = ['data' => []];
		foreach ($get->result() as $key => $value) { $no++;
			$id = $value->ip_address;
			$options = '<button id="kick" data-id="'.$id.'" class="btn btn-flat btn-sm btn-danger"> keluarkan </button>';
			if (!$options) {
				json("failed create options");
			}
			$result['data'][$key] = [
				$no,
				$value->user,
				$value->os,
				$value->browser,
				$value->ip_address,
				change_format_date($value->last_login),
				$options
			];
		}
		json($result);
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
		$get = $this->db->query("SELECT id, name, code_category, created_at, created_by FROM category WHERE is_deleted IS NULL");
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
				$value->code_category,
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
			p.id, p.sku,
			p.name,
			p.buy_price, p.sell_price, p.margin, p.stock,
			p.img, 
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
			$buy_price = rupiah($value->buy_price);
			$sell_price = rupiah($value->sell_price);
			$margin = rupiah($value->margin);
			$harga = "
				Beli: $buy_price <br>
				Jual: $sell_price <br>
			";
			$result['data'][$key] = [
				$no,
				$value->name."<br>".$value->sku,
				$value->category,
				$harga,
				$margin,
				$value->stock,
				$img,
				$value->created_by."<br>".change_format_date($value->created_at),
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
	public function listSell()
	{
		$get = $this->db->query("
			SELECT
			
			p.id, p.qty, p.total, p.note,
			p.created_at, p.created_by,
			c.name as customer,
			k.name as category,
			pd.name as product

			FROM sell p
			INNER JOIN customers c ON p.customer_id = c.id
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
				$value->customer,
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

	# report
	public function reportPembelian($from, $to)
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
			pd.is_deleted IS NULL AND
			p.created_at BETWEEN ? AND ? AND
			p.is_deleted IS NULL
			", [$from, $to]);
		if ($get->num_rows() == 0) {
			json([]);
		}
		$no = 0;
		$result = ['data' => []];
		foreach ($get->result() as $key => $value) { $no++;
			$id = $value->id;
			$note = ($value->note) == "" ? "-" : $value->note;
			$result['data'][$key] = [
				$no,
				$value->supplier,
				$value->category,
				$value->product,
				$value->qty,
				$value->total,
				$note,
				change_format_date($value->created_at),
				$value->created_by
			];
		}
		json($result);
	}
	public function reportPembelianPerproduk($from, $to, $product_id)
	{
		# check product
		$check = $this->db->query("SELECT id FROM product WHERE id = ? AND is_deleted IS NULL LIMIT 1", [$product_id])->num_rows();

		if ($check == 0) {
			json(response(false, 400, 'product not found'));
		}

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
			pd.is_deleted IS NULL AND
			p.created_at BETWEEN ? AND ? AND
			p.product_id = ? AND
			p.is_deleted IS NULL
			", [$from, $to, $product_id]);
		if ($get->num_rows() == 0) {
			json([]);
		}
		$no = 0;
		$result = ['data' => []];
		foreach ($get->result() as $key => $value) { $no++;
			$id = $value->id;
			$note = ($value->note) == "" ? "-" : $value->note;
			$result['data'][$key] = [
				$no,
				$value->supplier,
				$value->category,
				$value->product,
				$value->qty,
				$value->total,
				$note,
				change_format_date($value->created_at),
				$value->created_by
			];
		}
		json($result);
	}

	public function reportPenjualan($from, $to)
	{
		$get = $this->db->query("
			SELECT 
			p.id, p.qty, p.total, p.note,
			p.created_at, p.created_by,
			s.name as supplier,
			k.name as category,
			pd.name as product

			FROM sell p
			INNER JOIN customers s ON p.customer_id = s.id
			INNER JOIN category k ON p.category_id = k.id
			INNER JOIN product pd ON p.product_id = pd.id

			WHERE
			p.is_deleted IS NULL AND
			k.is_deleted IS NULL AND
			pd.is_deleted IS NULL AND
			p.created_at BETWEEN ? AND ? AND
			p.is_deleted IS NULL
			", [$from, $to]);
		if ($get->num_rows() == 0) {
			json([]);
		}
		$no = 0;
		$result = ['data' => []];
		foreach ($get->result() as $key => $value) { $no++;
			$id = $value->id;
			$note = ($value->note) == "" ? "-" : $value->note;
			$result['data'][$key] = [
				$no,
				$value->supplier,
				$value->category,
				$value->product,
				$value->qty,
				$value->total,
				$note,
				change_format_date($value->created_at),
				$value->created_by
			];
		}
		json($result);
	}
	public function reportPenjualanPerproduk($from, $to, $product_id)
	{
		# check product
		$check = $this->db->query("SELECT id FROM product WHERE id = ? AND is_deleted IS NULL LIMIT 1", [$product_id])->num_rows();

		if ($check == 0) {
			json(response(false, 400, 'product not found'));
		}

		$get = $this->db->query("
			SELECT 
			p.id, p.qty, p.total, p.note,
			p.created_at, p.created_by,
			s.name as supplier,
			k.name as category,
			pd.name as product

			FROM sell p
			INNER JOIN customers s ON p.customer_id = s.id
			INNER JOIN category k ON p.category_id = k.id
			INNER JOIN product pd ON p.product_id = pd.id

			WHERE
			p.is_deleted IS NULL AND
			k.is_deleted IS NULL AND
			pd.is_deleted IS NULL AND
			p.created_at BETWEEN ? AND ? AND
			p.product_id = ? AND
			p.is_deleted IS NULL
			", [$from, $to, $product_id]);
		if ($get->num_rows() == 0) {
			json([]);
		}
		$no = 0;
		$result = ['data' => []];
		foreach ($get->result() as $key => $value) { $no++;
			$id = $value->id;
			$note = ($value->note) == "" ? "-" : $value->note;
			$result['data'][$key] = [
				$no,
				$value->supplier,
				$value->category,
				$value->product,
				$value->qty,
				$value->total,
				$note,
				change_format_date($value->created_at),
				$value->created_by
			];
		}
		json($result);
	}
	# report
}