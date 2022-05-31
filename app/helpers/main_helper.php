<?php if (!defined('BASEPATH')) {
  exit('No direct script access allowed');
}
if(!function_exists('HariIndonesia')) {
  function HariIndonesia ($hari) {
    switch ($hari) {
      case 'Sunday':
        return 'Minggu';
      case 'Monday':
        return 'Senin';
      case 'Tuesday':
        return 'Selasa';
      case 'Wednesday':
        return 'Rabu';
      case 'Thursday':
        return 'Kamis';
      case 'Friday':
        return 'Jumat';
      case 'Saturday':
        return 'Sabtu';
      default:
        return 'hari tidak valid';
    }
  }
}
if(!function_exists('BulanIndonesia')) {
  function BulanIndonesia($tanggal)
  {
  	$bulan = array (1 =>   'Januari',
  				'Februari',
  				'Maret',
  				'April',
  				'Mei',
  				'Juni',
  				'Juli',
  				'Agustus',
  				'September',
  				'Oktober',
  				'November',
  				'Desember'
  			);
    return $bulan[(int)$tanggal];
  }
}
/*network-function*/
if (!function_exists('get_os')) {
  function get_os()
  {
    $CI = &get_instance();
    $CI->load->library('user_agent');
    return $CI->agent->platform();
  }
}
if (!function_exists('get_ip_address')) {
  function get_ip_address()
  {
    $CI = &get_instance();
    return $CI->input->ip_address();
  }
}
if (!function_exists('get_user_agent')) {
  function get_user_agent()
  {
    $CI = &get_instance();
    $CI->load->library('user_agent');
    if ($CI->agent->is_browser()) {
      $agent = $CI->agent->browser() . $CI->agent->version();
    } elseif ($CI->agent->is_robot()) {
      $agent = $CI->agent->robot() . ': is robot';
    } elseif ($CI->agent->is_mobile()) {
      $agent = $CI->agent->mobile() . ': is mobile';
    } else {
      $agent = 'Tidak Teridentifikasi User Agent: unknown';
    }
    return $agent;
  }
}
if (!function_exists('upload_action')) {
  function upload_action($path, $name)
  {
    if (!file_exists($path)) {
      mkdir($path, 0777, true);
    } else {
      /*jika file sudah ada maka tinggal di overwrite saja*/
      $config = [
        'upload_path'               => './' . $path,
        'allowed_types'             => "pdf|jpg|jpeg|png",
        'encrypt_name'              => true,
        'remove_spaces'             => true,
        'detect_mime'               => true,
        'mod_mime_fix'              => true,
        'file_ext_tolower'          => true,
        'max_filename_increment'    => 1000,
        'overwrite'                 => 1,
      ];
      $CI = &get_instance();
      $CI->load->library('upload', $config);
      if ($CI->upload->do_upload($name)) {
        // ------------------------------------------------------------------------
        return $CI->upload->data();
      } else {
        $error = $CI->upload->display_errors();
        // ------------------------------------------------------------------------
        if ($error === "<p>The file you are attempting to upload is larger than the permitted size.</p>") {
          $msg = 'File terlalu besar';
          $response = ['status' => false, 'code' => 500, 'msg' => $msg];
        } elseif ($error === "<p>The filetype you are attempting to upload is not allowed.</p>") {
          $msg = 'Jenis file tidak mendukung';
          $response = ['status' => false, 'code' => 500, 'msg' => $msg];
        } else {
          print_r($error);
          die();
        }
        json($response);
      }
    }
  }
}

if (!function_exists('upload_multiple_files')) {
  function upload_multiple_files($path)
  {
    if (!file_exists($path)) {
      mkdir($path, 0777, true);
    } else {
      $config = [
        'upload_path' => './' . $path,
        'allowed_types' => "gif|jpg|jpeg|png",
        'encrypt_name' => true,
        'remove_spaces' => true,
        'detect_mime' => true,
        'mod_mime_fix' => true,
        'file_ext_tolower' => true,
        'max_filename_increment' => 1000,
        'overwrite' => 1,
      ];
      $CI = &get_instance();
      $CI->load->library('upload', $config);
      // ------------------------------------------------------------------------
      foreach ($_FILES as $fieldname => $fileObject) {
        if (!empty($fileObject['name'])) {
          // ------------------------------------------------------------------------
          if ($CI->upload->do_upload($fileObject['name'])) {
            // ------------------------------------------------------------------------
            return $CI->upload->data();
          }else{
            $error = $CI->upload->display_errors();
            // ------------------------------------------------------------------------
            if ($error === "<p>The file you are attempting to upload is larger than the permitted size.</p>") {
              $msg = 'File terlalu besar';
              $response = ['status' => false, 'code' => 500, 'msg' => $msg];
            } elseif ($error === "<p>The filetype you are attempting to upload is not allowed.</p>") {
              $msg = 'Jenis file tidak mendukung';
              $response = ['status' => false, 'code' => 500, 'msg' => $msg];
            } else {
              print_r($error);
              die();
            }
            json($response);
          }
        }
      }
    }
  }
}

if (!function_exists('rupiah')) {
  function rupiah($number)
  {
    if (!$number) {
      return false;
    }
    return 'Rp. ' . number_format($number, 0, ',', '.');
  }
}
if (!function_exists('safeURL')) {
  function safeURL($url)
  {
    echo $safe = base64_encode($url);
    return $safe;
  }
}
if (!function_exists('intToMonth')) {
  function intToMonth($monthNum)
  {
    $dateObj = DateTime::createFromFormat('!m', '0' . $monthNum);
    return $dateObj->format('F');
  }
}
if (!function_exists('secToHR')) {
  function secToHR($seconds)
  {
    $hours = floor($seconds / 3600);
    $minutes = floor(($seconds / 60) % 60);
    $seconds = $seconds % 60;
    return $hours > 0 ? "$hours hours, $minutes min" : ($minutes > 0 ? "$minutes min, $seconds sec" : "$seconds sec");
  }
}

if (!function_exists('readURL')) {
  function readURL($url)
  {
    return base64_decode($url);
  }
}
if (!function_exists('change_format_date')) {
  function change_format_date($date)
  {
    if ($date) {
      return date('d-m-Y H:i:s', strtotime(str_replace('-', '/', $date)));
    } else {
      return '-';
    }
  }
}
if (!function_exists('formatBytes')) {
  function formatBytes($bytes, $precision = 2)
  {
    if (!$bytes) {
      return false;
    }
    $units = ['B', 'KB', 'MB', 'GB', 'TB'];
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    $bytes /= pow(1024, $pow);
    return round($bytes, $precision) . ' ' . $units[$pow];
  }
}
if (!function_exists('json')) {
  function json($data = '')
  {
    $CI = &get_instance();
    $CI->output
    ->set_content_type('application/json', 'utf-8')
    ->set_output(json_encode($data, JSON_PRETTY_PRINT))
    ->_display();
    exit();
  }
}
if (!function_exists('interpreter')) {
  function interpreter($detail)
  {
    $CI = &get_instance();
    return $CI->load->view('backend/index', $detail);
  }
}
if (!function_exists('escapeData')) {
  function escapeData($data) {
    if ($data) {
      $CI = &get_instance();
      return $CI->security->xss_clean(stripcslashes(htmlspecialchars(htmlentities($data))));
    }else{
      return false;
    }
  }
}
if (!function_exists('post')) {
  function post($data)
  {
    if ($data) {
      if (is_array($data)) {
        http_response_code(400);
      }else{
        $CI = &get_instance();
        return $CI->security->xss_clean(stripcslashes(htmlspecialchars(htmlentities($CI->input->post($data, true)))));
      }
    }else{
      http_response_code(400);
    }
  }
}
if (!function_exists('load')) {
  function load($folder, $data = '')
  {
    $CI = &get_instance();
    return $CI->load->view($folder, $data);
  }
}
if (!function_exists('get_ip_address')) {
  function get_ip_address()
  {
    return getenv('HTTP_X_FORWARDED_FOR') ? getenv('HTTP_X_FORWARDED_FOR') : getenv('REMOTE_ADDR');
  }
}
if (!function_exists('check_internet_connection')) {
  function check_internet_connection()
  {
    return checkdnsrr('google.co.id');
  }
}
if (!function_exists('session')) {
  function session(string $session)
  {
    $CI = &get_instance();
    $CI->load->library('session');
    return $CI->session->userdata($session);
  }
}
if (!function_exists('allowed_type')) {
  function allowed_type($data)
  {
    if (!$data) {
      return false;
    }
    $fileNameParts = explode(".", $data);
    $fileExtension = end($fileNameParts);
    $fileExtension = strtolower($fileExtension);
    return $fileExtension;
  }
}

if (!function_exists('verifyEmail')) {
  function verifyEmail($email)
  {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
      return $email;
    } else {
      return json('email not valid');
    }
  }
}

if (!function_exists('imageToBase64')) {
  function imageToBase64($path, $img)
  {
    return 'data:image/' . pathinfo($path . $img, PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents($path . $img));
  }
}
if (!function_exists('checkAvailibleData')) {
  function checkAvailibleData(string $table, $where = []){
    $CI = &get_instance();
    $CI->load->database();
    $where['is_deleted'] = NULL;
    $check = $CI->db->select('id')->from($table)->where($where)->get();
    if ($check->num_rows() > 0){
      /*if data exist, return false to show error message*/
      return false;
    }else{
      /*if data not exist, return true to continue*/
      return true;
    }
  }
}
if (!function_exists('response')) {
  function response(bool $status = null, int $code = 200, string $msg = "Message is null.", $data = [])
  {
    http_response_code($code);
    return ['status' => $status, 'code' => $code, 'msg' => $msg, 'data' => $data];
  }
}
if (!function_exists('DataAllreadyExist')) {
  function DataAllreadyExist(string $table)
  {
    json(response(true, 200, "data $table already exist", null));
  }
}
if (!function_exists('salam')) {
  function salam()
  {
    date_default_timezone_set("Asia/Jakarta");
    $jam = date('H:i');
    if ($jam > '05:30' && $jam < '10:00') {
      $salam = 'Selamat Pagi!';
    } elseif ($jam >= '10:00' && $jam < '14:00') {
      $salam = 'Selamat Siang!';
    } elseif ($jam >= '14:00' && $jam < '18:00') {
      $salam = 'Selamat Sore!';
    } else {
      $salam = 'Good Malam!';
    }
    return $salam;
  }
}
