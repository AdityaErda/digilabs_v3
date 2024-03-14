<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notifikasi extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('sample/M_notifikasi');
		$this->load->model('sample/M_request');
		$this->load->model('master/M_user');

		$this->load->model('master/M_perhitungan_sample');
		$this->load->model('master/M_template_logsheet');
		$this->load->model('master/M_sample_pekerjaan');
		$this->load->model('master/M_sample_jenis');
		$this->load->model('sample/M_library');
		$this->load->model('sample/M_inbox');
		$this->load->model('sample/M_approve');
		$this->load->model('sample/M_nomor');
	}

	public function index()
	{
		$isi['judul'] = 'Notifikasi';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');
		// $data['tipe'] = $this->input->get('tipe');

		$this->load->view('tampilan/header', $isi);
		$this->load->view('tampilan/sidebar', $data);
		$this->load->view('sample/notifikasi');
		$this->load->view('tampilan/footer');
		$this->load->view('sample/notifikasi_js');
	}

	/* GET */
	public function getUser()
	{
		$list['results'] = array();

		$param['user_nama_lengkap'] = $this->input->get('user_nama_lengkap');
		$data = $this->M_notifikasi->getUser($param);
		foreach ($data as $key => $value) {
			array_push($list['results'], [
				'id' => $value['user_id'],
				'text' => $value['user_nama_lengkap'] . ' - ' . $value['role_nama'],
			]);
		}

		echo json_encode($list);
	}

	public function getUserBySeksi()
	{
		$list['results'] = array();

		$param['user_nama_lengkap'] = $this->input->get('user_nama_lengkap');
		$param['id_seksi'] = $this->input->get_post('id_seksi');
		$data = $this->M_notifikasi->getUserBySeksi($param);
		foreach ($data as $key => $value) {
			array_push($list['results'], [
				'id' => $value['user_id'],
				'text' => $value['user_nama_lengkap'] . ' - ' . $value['role_nama'],
			]);
		}

		echo json_encode($list);
	}
	/* GET */

	/* INSERT */
	public function insertNotifikasi()
	{
		$isi = $this->session->userdata();
		/* Insert Petugas */
		foreach ($this->input->post('id_petugas') as $value) {
			$data_petugas['petugas_id'] = create_id();
			$data_petugas['id_transaksi'] = $this->input->post('transaksi_id');
			$data_petugas['id_user'] = $value;

			$this->M_notifikasi->insertNotifikasiPetugas($data_petugas);
		}
		/* Insert Petugas */

		/* Insert Transaksi Detail */
		$data['transaksi_detail_id'] = create_id();
		$data['transaksi_id'] = $this->input->post('transaksi_id');
		$data['transaksi_detail_note'] = $this->input->post('transaksi_detail_note');
		$data['transaksi_detail_status'] = '7';
		$data['when_create'] = date('Y-m-d H:i:s');
		$data['who_create'] = $isi['user_nama_lengkap'];
		$data['who_seksi_create'] = $isi['id_seksi'];

		$this->M_notifikasi->insertNotifikasi($data);
		/* Insert Transaksi Detail */

		/* Update Transaksi */
		$id = $this->input->post('transaksi_id');
		$data_detail = array(
			'id_transaksi_detail' => $data['transaksi_detail_id'],
			'transaksi_status' => $data['transaksi_detail_status'],
			'when_create' => date('Y-m-d H:i:s'),
			'who_create' => $isi['user_nama_lengkap'],
			'who_seksi_create' => $isi['id_seksi'],
		);

		$this->M_request->updateRequest($data_detail, $id);
		/* Update Transaksi */
	}
	/* INSERT */

	public function getNotifikasi()
	{
		$param['transaksi_id'] = $this->input->get('transaksi_id');
		$param['transaksi_tipe'] = $this->input->get('transaksi_tipe');
		$param['transaksi_status'] = $this->input->get('transaksi_status');

		$data = $this->M_notifikasi->getNotifikasi($param);
		echo json_encode($data);
	}

	public function print_qrcode()
	{

		$this->load->library('ciqrcode'); //pemanggilan library QR CODE


		$param['transaksi_id'] = $this->input->get('transaksi_id');
		$param['transaksi_detail_id'] = $this->input->get('transaksi_detail_id');
		$param['jenis_id'] = $this->input->get('jenis_id');
		$param['transaksi_detail_status'] = $this->input->get('transaksi_detail_status');
		$param['id_template_logsheet'] = $this->input->get('template_logsheet_id');
		$param['logsheet_id'] = $this->input->get('logsheet_id');

		$data_awal = $this->M_notifikasi->getNotifikasiBarcodeAwal($param);
		$data = $this->M_notifikasi->getNotifikasiBarcode($param);

		$param_dof = [];
		if (!empty($data_awal['transaksi_detail_group'])) {
			$param_dof['transaksi_detail_group'] = $data_awal['transaksi_detail_group'];
		}
		if (!empty($data_awal['transaksi_detail_id']) && empty($data_awal['transaksi_detail_id'])) {
			$param_dof['transaksi_detail_id']  = $data_awal['transaksi_detail_id'];
		}
		if (!empty($data_awal['id_transaksi_rutin'])) {
			$param_dof['transaksi_rutin_id'] = $data_awal['id_transaksi_rutin'];
		}

		$data_dof = $this->M_library->getDOFIdentitas($param_dof);
		$url = '';
		/* api baca dokumen status */

		$tokenBearer = $this->session->userdata('access_token_dof');
		$tokenUrl = $this->config->item('dof_url') . '/api/Docs/GetDocStatus?id=' . $data_dof['id_surat'];
		$tokenHeaders = array(
			"User-Agent:PostmanRuntime/7.30.0",
			"Authorization:  Bearer " . $tokenBearer,
			"Content-Type: application/x-www-form-urlencoded",
		);

		$token = curl_init();
		curl_setopt($token, CURLOPT_URL, $tokenUrl);
		curl_setopt($token, CURLOPT_HTTPHEADER, $tokenHeaders);
		curl_setopt($token, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($token, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($token, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($token, CURLOPT_MAXREDIRS, 10);
		curl_setopt($token, CURLOPT_TIMEOUT, 0);
		// curl_setopt($token, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		// curl_setopt($token, CURLOPT_POST, true);
		// curl_setopt($token, CURLOPT_POSTFIELDS, $tokenContent);

		$item = curl_exec($token);
		curl_close($token);
		$item = json_decode($item);
		$items = $item->data;

		$data_api_dof['status'] = $items->status;
		$data_api_dof['fileStream'] = $items->fileStream;

		$file_word_base64 = base64_decode($data_api_dof['fileStream']);
		$file_word = file_put_contents(FCPATH . '/dokumen_dof/' . $data_dof['id_surat'] . '.docx', $file_word_base64);
		$file_word = file_put_contents(FCPATH . '/dokumen_dof/' . $data_dof['id_surat'] . '', $file_word_base64);

		try {
			$dataFile = $data_dof['id_surat'] . '.docx';
			$sftpServer = "103.157.97.200";
			$sftpUsername = "root";
			$sftpPassword = "P@ssw0rds1k1t4";
			$sftpPort = "22";
			$sftpRemoteDir = "/var/www/dokumen_dof";
			$ch = curl_init('sftp://' . $sftpServer . ':' . $sftpPort . $sftpRemoteDir . '/' . basename($dataFile));
			// $fh = fopen('./dokumen_dof/' . $dataFile, 'r');
			$fh = fopen(FCPATH . '/dokumen_dof/' . $data_dof['id_surat'] . '.docx', 'r');

			if ($fh) {
				curl_setopt($ch, CURLOPT_USERPWD, $sftpUsername . ':' . $sftpPassword);
				curl_setopt($ch, CURLOPT_UPLOAD, true);
				curl_setopt($ch, CURLOPT_PROTOCOLS, CURLPROTO_SFTP);
				curl_setopt($ch, CURLOPT_INFILE, $fh);
				curl_setopt($ch, CURLOPT_INFILESIZE, filesize('./dokumen_dof/' . $dataFile));
				curl_setopt($ch, CURLOPT_VERBOSE, true);
				$verbose = fopen('php://temp', 'w+');
				curl_setopt($ch, CURLOPT_STDERR, $verbose);
				$response = curl_exec($ch);
				$error = curl_error($ch);
				curl_close($ch);
			}
		} catch (Exception $e) {
			log_message("info", "Exception in uploading file to ftp---" . print_r($e->getMessage(), 1));
			echo "error exception" . $e->getMessage();
		}

		/* api baca dokumen status */

		if ($data_awal['transaksi_detail_status'] >= '17') {
			if ($data_api_dof['status'] == 'DISETUJUI_APPROVER') {
				$url = base_url('sample/library/viewSertifikat/' . $data_dof['id_surat'] . '.docx');
			} else {
				$url = base_url('login/?header_menu=02&menu_id=0203&transaksi_id=' . $data['transaksi_id'] . '&jenis_id=' . $data['jenis_id']);
			}
		} else if ($data_awal['transaksi_detail_status'] == '12' && $data_awal['transaksi_tipe'] == 'R') {
			$url = base_url('sample/nomor/cetakMultipleNomor?transaksi_detail_id=' . $data_awal['transaksi_detail_id'] . '&transaksi_detail_status=' . $data_awal['transaksi_detail_status'] . '&transaksi_id=' . $data_awal['transaksi_id'] . '&template_logsheet_id=' . $data_awal['id_template_logsheet'] . '&logsheet_id=' . $data_awal['logsheet_id']);
		} else {
			$url = base_url('login/?header_menu=02&menu_id=0203&transaksi_id=' . $data['transaksi_id'] . '&jenis_id=' . $data['jenis_id']);
		}

		/* QRCODE */
		$config['cacheable']    = true; //boolean, the default is true
		$config['cachedir']     = './assets/'; //string, the default is application/cache/
		$config['errorlog']     = './assets/'; //string, the default is application/logs/
		$config['imagedir']     = './img/'; //direktori penyimpanan qr code
		$config['quality']      = true; //boolean, the default is true
		$config['size']         = '1024'; //interger, the default is 1024
		$config['black']        = array(224, 255, 255); // array, default is array(255,255,255)
		$config['white']        = array(70, 130, 180); // array, default is array(0,0,0)
		
		$nim = $data['transaksi_id'];
		$image_name = $nim . '.PNG'; //buat name dari qr code sesuai dengan nim

		$params['data'] = $url; //data yang akan di jadikan QR CODE
		$params['level'] = 'H'; //H=High
		$params['size'] = 10;
		$params['savename'] = FCPATH . $config['imagedir'] . $image_name; //simpan image QR CODE ke folder assets/images/
		$this->ciqrcode->generate($params);
		/* QRCODE */

		$this->load->view('sample/print_qrcode', $data);
	}
}
