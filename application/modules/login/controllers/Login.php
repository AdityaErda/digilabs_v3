<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Login extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user/M_user', 'M_user');
		$this->load->model('document/M_daftar');
	}
	public function index()
	{
		if (($this->session->userdata('user_id') != '' || $this->session->userdata('user_nik_sap') != '')) {
			if ($this->input->get('transaksi_id')) redirect(base_url('sample/library/?&header_menu=' . $this->input->get('header_menu') . '&menu_id=' . $this->input->get('menu_id') . '&transaksi_id=' . $this->input->get('transaksi_id') . '&jenis_id=' . $this->input->get('jenis_id')));
			else redirect(base_url('dashboard/order/?&header_menu=53&menu_id=54'));
		} else {
			$this->load->view('login/login');
		}
	}
	public function masuk()
	{
		$isi['username'] = $this->input->post('username');
		$isi['password'] = $this->input->post('password');

		$data = $this->M_user->getUser($isi);

		// get api login
		$client_id = "";
		$client_secret = "";
		$tokenUrl = "http://sso.petrokimia-gresik.com/token";

		$tokenContent = "grant_type=password&username=" . $isi['username'] . "&password=" . $isi['password'] . "";

		$authorization = base64_encode("$client_id:$client_secret");

		$tokenHeaders = array(
			"User-Agent:PostmanRuntime/7.30.0",
			"Authorization: Basic {$authorization}",
			"Content-Type: application/x-www-form-urlencoded"
		);

		$token = curl_init();
		curl_setopt($token, CURLOPT_URL, $tokenUrl);
		curl_setopt($token, CURLOPT_HTTPHEADER, $tokenHeaders);
		curl_setopt($token, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($token, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($token, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($token, CURLOPT_MAXREDIRS, 10);
		curl_setopt($token, CURLOPT_TIMEOUT, 0);
		curl_setopt($token, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($token, CURLOPT_POSTFIELDS, $tokenContent);

		$item = curl_exec($token);
		curl_close($token);
		$item = (array)json_decode($item);

		$isi_dof['username'] = "digilab_apps";
		$isi_dof['password'] = "D!g!l4b@2022";

		// $isi_dof['username'] = $this->input->post('username');
		// $isi_dof['password'] = $this->input->post('password');

		// get token
		$client_id_dof = "";
		$client_secret_dof = "";
		$tokenUrl_dof = "https://dof.petrokimia-gresik.com/api/v2/Account/Login";
		$tokenContent_dof = "grant_type=password&username=" . $isi_dof['username'] . "&password=" . $isi_dof['password'] . ""; // sementara
		$tokenHeaders_dof = array(
			"User-Agent:PostmanRuntime/7.30.0",
			"Content-Type: application/x-www-form-urlencoded"
		);
		$token_dof = curl_init();

		curl_setopt($token_dof, CURLOPT_URL, $tokenUrl_dof);
		curl_setopt($token_dof, CURLOPT_HTTPHEADER, $tokenHeaders_dof);
		curl_setopt($token_dof, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($token_dof, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($token_dof, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($token_dof, CURLOPT_MAXREDIRS, 10);
		curl_setopt($token_dof, CURLOPT_TIMEOUT, 0);
		curl_setopt($token_dof, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($token_dof, CURLOPT_POSTFIELDS, $tokenContent_dof);

		$item_dof = curl_exec($token_dof);
		curl_close($token_dof);
		$item_dof = (array)json_decode($item_dof);

		if ($item_dof) {
			$data_dof['status_dof'] = $item_dof['status'];
			$data_dof['access_token_dof'] = $item_dof['access_token'];
			$data_dof['token_type_dof'] = $item_dof['token_type'];
			$data_dof['expires_in_dof'] = $item_dof['expires'];
			$data_dof['userName_dof'] = $item_dof['userName'];
			$data_dof['issued_dof'] = $item_dof['issued'];
			$data_dof['expires_dof'] = $item_dof['expires'];
		}
		if ($data) {
			$datas = array_merge($data, $item);
		} else {
			$datas = array_merge($item);
		}

		$datass = array_merge($datas, $data_dof);

		if ($data) {
			$this->session->set_userdata($datass);
			if ($_POST['transaksi_id'] != '') redirect(base_url('sample/library/?&header_menu=' . $_POST['header_menu'] . '&menu_id=' . $_POST['menu_id'] . '&transaksi_id=' . $_POST['transaksi_id'] . '&jenis_id=' . $_POST['jenis_id']));
			else redirect(base_url('dashboard/order/?&header_menu=53&menu_id=54'));
		} else {
			$client_id_login = "";
			$client_secret_login = "";
			$tokenUrl_login = "https://sso.petrokimia-gresik.net/api/User/Login";
			$tokenContent_login = "grant_type=password&username=" . $isi['username'] . "&password=" . $isi['password'];
			$authorization_login = base64_encode("$client_id:$client_secret");
			$tokenHeaders_login = array(
				"User-Agent:PostmanRuntime/7.30.0",
				"Authorization: Basic {$authorization}",
				"Content-Type: application/x-www-form-urlencoded"
			);
			$token_login = curl_init();
			curl_setopt($token_login, CURLOPT_URL, $tokenUrl_login);
			curl_setopt($token_login, CURLOPT_HTTPHEADER, $tokenHeaders_login);
			curl_setopt($token_login, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($token_login, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($token_login, CURLOPT_POST, true);
			curl_setopt($token_login, CURLOPT_POSTFIELDS, $tokenContent_login);
			$item_login = curl_exec($token_login);
			curl_close($token_login);
			$item_login = json_decode($item_login);

			if ($item_login->status) {
				$isi_cek['username'] = $this->input->get_post('username');
				$data_cek = $this->M_user->getUserName($isi_cek);
				if ($data_cek) {
					$id = $data_cek['user_id'];
					$data['user_username'] = $this->input->post('username');
					$data['user_password'] = md5($this->input->post('password'));
					$this->M_user->updateUser($data, $id);
					// echo $this->db->last_query();
				} else {
					$id =  create_id();
					$data['user_id'] = $id;
					$data['role_id'] = 'f6548aef55942a79cdb7ad524cfcb8ac1625e760';
					$data['id_seksi'] = 'cb70f2dc85571e5c29d2e9cf3f33412d3ea16485';
					$data['user_nama_lengkap'] = $item_login->name;
					$data['user_username'] = $isi['username'];
					$data['user_password'] = md5($isi['password']);
					$data['when_create'] = date('Y-m-d H:i:s');
					$data['who_create'] = '-';

					$this->M_user->insertUser($data);

					$par['cv_id'] = create_id();
					$par['company_code'] = '1';
					$par['cv_nik'] = $item->nikSap;
					$par['user_id'] = $id;
					$par['when_create'] = date('Y-m-d H:i:s');
					$this->M_daftar->insertCV($par);
				}
				$login = $this->M_user->getUser($isi);

				if ($login) {
					$this->session->set_userdata($login);
					if ($_POST['transaksi_id'] != '') redirect(base_url('sample/library/?&header_menu=' . $_POST['header_menu'] . '&menu_id=' . $_POST['menu_id'] . '&transaksi_id=' . $_POST['transaksi_id'] . '&jenis_id=' . $_POST['jenis_id']));
					else redirect(base_url('dashboard/order/?&header_menu=53&menu_id=54'));
				}
			} else {
				$this->session->set_flashdata('pesan', 'Username dan password Salah');
				redirect(base_url('login'));
			}
		}
	}
	public function keluar()
	{
		$this->session->sess_destroy();
		redirect(base_url());
	}
	public function checkLogin()
	{
		$sess_id = $this->session->userdata();
		echo json_encode($sess_id);
	}
}
