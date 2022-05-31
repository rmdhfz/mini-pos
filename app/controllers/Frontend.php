<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Frontend extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->init();
	}
	private function init() {
		$this->load->library('session');
		if ( $this->session->userdata('is_login') ){
			redirect(site_url('dashboard'), 'refresh');
		}
	}
	private function _validationRequest($token) {
		if (!$token) {
			return false;
		}
		return true;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
		curl_setopt($ch, CURLOPT_POSTFIELDS, "secret=".SECRET_GOOGLE_RECAPTCHA."&response=".$token);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($ch);
		curl_close($ch);
		$res = json_decode($output, true);
		if (!$res['success']) {
			return false;
		}
		return true;
	}
	private function _saveHistoryLogin($user_id, $ip_address, $browser, $os)
	{
		if (!$user_id || !$ip_address || !$browser || !$os) {
			return false;
		}
		$this->load->database();
		$insert = $this->db->insert('history_login', [
			'user_id'		=>	$user_id,
			'os'			=>	$os,
			'browser'		=>	$browser,
			'ip_address'	=>	$ip_address,
		]);
		if (!$insert) {
			return false;
		}
		return true;
	}
	private function _getBrowser(){
		$this->load->library('user_agent');
		if ($this->agent->is_browser()){
			$agent = $this->agent->browser().' '.$this->agent->version();
		}elseif ($this->agent->is_robot()){
			$agent = $this->agent->robot();
		}elseif ($this->agent->is_mobile()){
			$agent = $this->agent->mobile();
		}else{
			$agent = 'Unidentified User Agent';
		}
		return $agent;
	}
	private function _getOS(){
		$this->load->library('user_agent');
		return $this->agent->platform();
	}
	private function _setSessions($data, $is_admin = false){
		if (!$data || !is_object($data)) {
			return false;
		}
		$this->load->library('session');
		$sessions = [
			'is_login'		=>	true,
			'login_at'		=>	date('d-m-Y h:i:s'),
			'user_id'		=>	$data->id,
			'user_name'		=>	$data->name,
			'user_username'	=>	$data->username,
		];
		if ($is_admin) {
			$sessions['is_admin'] = true;
		}else{
			$sessions['is_admin'] = false;
		}
		$this->session->set_userdata($sessions);
		return true;
	}
	public function index(){
		$this->load->view('frontend/index');
	}
	public function daftar(){
		$this->load->view('frontend/daftar');
	}
	public function login()
	{
		if ($_SERVER['REQUEST_METHOD'] !== "POST") {
			http_response_code(401);
			return false;
		}
		$key = post('key');
		$token = post('token');
		$ip_addr = post('ip_addr');
		if (!$key || !$token || !$ip_addr) {
			http_response_code(401);
			return false;
		}
		$verifyIp = (bool) filter_var($ip_addr, FILTER_VALIDATE_IP);
		if (!$verifyIp) {
			http_response_code(401);
			return false;
		}
		$validation = $this->_validationRequest($token);
		if (!$validation) {
			http_response_code(401);
			return false;
		}
		$username 	= post('username');
		$pwd		= post('password');
		if (!$username || !$pwd) {
			http_response_code(401);
			return false;
		}
		$this->load->database();
		$check = $this->db->query("SELECT id, name, username, password FROM users WHERE username = ? LIMIT 1", [$username]);
		if ($check->num_rows() == 0) {
			http_response_code(404);
			return false;
		}
		$data = $check->row();
		$verify = password_verify($pwd, $data->password);
		if (!$verify) {
			json(response(false, 404, 'username or password is wrong'));
		}
		$history = $this->_saveHistoryLogin((int) $data->id, $ip_addr, $this->_getBrowser(), $this->_getOS());
		if (!$history) {
			json(response(false, 500, 'failed save history login'));
		}
		$set = $this->_setSessions($data, true);
		if (!$set) {
			json(response(false, 500, 'failed create session'));
		}
		json(response(true, 200, 'success'));
	}
}
