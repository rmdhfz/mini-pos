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
	public function listUser(){
		$this->load->database();
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
				$value->created_at,
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
				$options
			];
		}
		json($result);
	}
	public function listProduct()
	{
		$get = $this->db->query("SELECT id, name, price, img, description FROM product WHERE is_deleted IS NULL");
		if ($get->num_rows() == 0) {
			json([]);
		}
		$no = 0;
		$result = ['data' => []];
		foreach ($get->result() as $key => $value) { $no++;
			$id = $value->id;
			$img = "<img src='".PATH_PRODUCT.$value->img."' loading='lazy' alt='product'>";
			$options = $this->createOptions($id);
			if (!$options) {
				json("failed create options");
			}
			$result['data'][$key] = [
				$no,
				$value->name,
				$value->price,
				$img,
				$value->description,
				$value->created_at,
				$value->created_by,
				$options
			];
		}
		json($result);
	}
	# list
}