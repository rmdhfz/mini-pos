<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Model extends CI_Model {

    public function __construct(){
        parent::__construct();
        $this->init();
    }
    private function init() {
		$this->load->library('session');
		if (!$this->session->userdata('is_login') ){
			redirect(site_url(), 'refresh');
		}
	}
	private function _executeSQL($table, $fields, $condition = false) {
		/*TODO*/
		if (!$table || !$fields) {
			return false;
		}
		$this->load->database();
		if ($condition) {
			$sql = $this->db->query("SELECT $fields FROM $table WHERE $condition");
		}
		$sql = $this->db->query("SELECT $fields FROM $table");
		if ($sql->num_rows() == 0) {
			return false;
		}
		$result = ['data' => []];
		$no = 0;
		$fields = $sql->list_fields();
		$fields_data = $sql->field_data();
		json($fields_data);
		$arrfields = [];
		foreach ($fields as $key => $value) {
			$arrfields[$key] = $value;
		}
		$row = $sql->result_array();
		$tmp = [];
		for ($i=0; $i <= count($fields); $i++) { $no++;
			foreach ($row as $key => $value) {
				$result['data'][$key] = [
					$no,
					$value[$arrfields[$key]]
				];
			}
		}
		return $result;
	}
	private function createOptions($id) {
		if (!$id) {
			return false;
		}
		return '
		<button id="edit" data-id="'.$id.'" class="btn btn-flat btn-sm btn-info"> edit </button>
		<button id="delete" data-id="'.$id.'" class="btn btn-flat btn-sm btn-danger"> hapus </button>';
	}
	public function listEmployee(){
		$this->load->database();
		$get = $this->db->query("SELECT * FROM employees");
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
				$value->email,
				$value->phone,
				$options
			];
		}
		json($result);
	}
	public function listRole(){
		$this->load->database();
		$get = $this->db->query("SELECT * FROM roles");
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
	public function listAsset(){
		$this->load->database();
		$get = $this->db->query("SELECT * FROM assets");
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
				$value->asset_no,
				$value->name,
				$value->type,
				$options
			];
		}
		json($result);
	}
	public function listAssignment(){
		$this->load->database();
		$get = $this->db->query("SELECT a.name as asset, e.name as employee, m.id, m.asset_id, m.employee_id, m.date_assign FROM assignments m INNER JOIN assets a ON m.asset_id = a.id INNER JOIN employees e ON m.employee_id = e.id");
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
				$value->asset,
				$value->employee,
				$value->date_assign,
				$options
			];
		}
		json($result);
	}
}