<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Library extends MY_Controller{

	public function __construct(){
		parent::__construct();
		isLogin();
		$this->load->model('sample/M_request');
		$this->load->model('sample/M_library');
		$this->load->model('sample/M_inbox');
		$this->load->model('sample/M_notifikasi');
	}

	public function index(){
		$isi['judul'] = 'Library';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');
		// $data['tipe'] = $this->input->get('tipe');

		$this->template->template_master('sample/library',$isi,$data);
	}

	/* GET */
	public function getLibrary(){
		$session = $this->session->userdata();

		$param['transaksi_id'] = $this->input->get_post('transaksi_id');
		$param['transaksi_detail_id'] = $this->input->get_post('transaksi_detail_id');
		$param['jenis_id'] = $this->input->get_post('jenis_id');
		if ($this->input->get_post('transaksi_tipe') != '-') {
			$param['transaksi_tipe'] = $this->input->get_post('transaksi_tipe');
		}
		$param['tanggal_cari'] = $this->input->get_post('tanggal_cari');
		$param['track_sample'] = $this->input->get_post('track_sample');
		$param['tanggal_cari_awal'] = $this->input->get_post('tanggal_cari_awal');
		$param['tanggal_cari_akhir'] = $this->input->get_post('tanggal_cari_akhir');
		$param['status'] = $this->input->get_post('status');
		$param['transaksi_status'] = $this->input->get_post('transaksi_status');
		if ($session['role_id'] != '1' && $session['user_unit_id'] != 'E44000') {
			$param['user_unit_id'] = $session['user_unit_id'];
		}


		$where = array();
		// if (!empty($param['tanggal_cari'])) {
		// 	$tgl_ini = date($param['tanggal_cari'] . '-d');
		// 	$where['DATE(transaksi_detail_tgl_pengajuan) >= '] = date('Y-m-01', strtotime($tgl_ini));
		// 	$where['DATE(transaksi_detail_tgl_pengajuan) <= '] = date('Y-m-t', strtotime($tgl_ini));
		// } else if (!empty($param['tahun_cari'])) {
		// 	$where['DATE(transaksi_detail_tgl_pengajuan) >= '] = $param['tahun_cari'] . '-01-01';
		// 	$where['DATE(transaksi_detail_tgl_pengajuan) <= '] = $param['tahun_cari'] . '-12-31';
		// }
		$data = $this->M_library->getLibrary($param, $where);
		echo json_encode($data);
	}

	public function getLibraryLanding(){
		// if ($this->input->get('tgl_cari')) $tgl = explode(' - ', $this->input->get('tgl_cari'));

		$param['transaksi_id'] = $this->input->get_post('transaksi_id');
		$param['transaksi_tipe'] = $this->input->get_post('transaksi_tipe');
		$param['tanggal_cari'] = $this->input->get_post('tanggal_cari');
		$param['track_sample'] = $this->input->get_post('track_sample');
		$param['tanggal_cari_awal'] = $this->input->get_post('tanggal_cari_awal');
		$param['tanggal_cari_akhir'] = $this->input->get_post('tanggal_cari_akhir');
		// print_r($param);

		$where = array();
		if (!empty($param['tanggal_cari'])) {
			$tgl_ini = date($param['tanggal_cari'] . '-d');
			$where['DATE(transaksi_detail_tgl_pengajuan) >= '] = date('Y-m-01', strtotime($tgl_ini));
			$where['DATE(transaksi_detail_tgl_pengajuan) <= '] = date('Y-m-t', strtotime($tgl_ini));
		} else if (!empty($param['tanggal_cari_awal']) && !empty($param['tanggal_cari_akhir'])) {
			$tgl_ini = date($param['tanggal_cari_awal'] . '-d');
			$tgl_akhir = date($param['tanggal_cari_akhir'] . '-d');
			$where['DATE(transaksi_detail_tgl_pengajuan) >= '] = date('Y-m-01', strtotime($tgl_ini));
			$where['DATE(transaksi_detail_tgl_pengajuan) <= '] = date('Y-m-t', strtotime($tgl_akhir));
		} else if (!empty($param['tahun_cari'])) {
			$where['DATE(transaksi_detail_tgl_pengajuan) >= '] = $param['tahun_cari'] . '-01-01';
			$where['DATE(transaksi_detail_tgl_pengajuan) <= '] = $param['tahun_cari'] . '-12-31';
		}
		// if ($this->input->get('tgl_cari')) $param['tgl_awal'] = date('Y-m-d', strtotime($tgl[0]));
		// if ($this->input->get('tgl_cari')) $param['tgl_akhir'] = date('Y-m-d', strtotime($tgl[1]));

		$data = $this->M_request->getAllRequest($param, $where);

		echo json_encode($data);
	}
	/* GET */

	/* GET DETAIL */
	public function getLibraryDetail(){
		$param1['transaksi_id'] = $this->input->get_post('transaksi_id');
		$param['transaksi_non_rutin_id'] = $this->input->get_post('transaksi_non_rutin_id');
		$param['jenis_id'] = $this->input->get_post('jenis_id');
		$param['transaksi_detail_id'] = $this->input->get_post('transaksi_detail_id');
		$data = array();
		$data_library = $this->M_library->getLibraryDetail($param);
		foreach ($data_library as $value) {
			$data_detail = array();
			$data_disposisi = $this->M_library->getLibraryDisposisi($param1);
			foreach ($data_disposisi as $val) {
				array_push($data_detail, $val['seksi_nama']);
			}
			$value['disposisi'] = implode(', ', $data_detail);

			array_push($data, $value);
		}
		echo json_encode($data);
	}

	public function getHistoryLogSheet(){
		$param['sample_transaksi_id'] = $this->input->get_post('sample_transaksi_id');
		$param['history_logsheet_id'] = $this->input->get_post('history_logsheet_id');

		$data = $this->M_library->getHistoryLogSheet($param);
		// echo $this->db->last_query($data);
		// print_r($data);

		echo json_encode($data);
	}

	/* GET DETAIL */

	// GET EDIT
	public function getLibraryEdit(){
		$param['transaksi_detail_id'] = $this->input->get_post('transaksi_detail_id');
		$data = $this->M_library->getLibraryEdit($param);
		echo json_encode($data);
	}
	// GET EDIT

	// EDIT
	public function updateLibraryEdit(){
		$id = htmlentities($this->input->get_post('transaksi_detail_id'));
		$param['transaksi_detail_note'] = htmlentities($this->input->get_post('transaksi_detail_note'));
		$param['transaksi_detail_tgl_memo'] = htmlentities($this->input->get_post('transaksi_detail_tgl_memo'));
		$param['transaksi_detail_no_memo'] = htmlentities($this->input->get_post('transaksi_detail_no_memo'));

		$this->M_library->updateLibraryEdit($id, $param);
	}
	// EDIT

	public function viewSertifikat($filename = NULL){
		$data = [];
		$data['path'] = FCPATH . '/dokumen_dof/' . $this->uri->segment(4);
		$this->load->view('tampilan/header', $data, FALSE);
		$this->load->view('sample/view_sertifikat', $data, FALSE);
	}

	public function downloadSertifikat($filename = NULL){
		$data = [];
		$data['path'] = FCPATH . '/dokumen_dof/' . $this->uri->segment(4);
		force_download($filename, file_get_contents($data['path']));
	}

	public function getDOFIdentitas(){
		$param['transaksi_id'] = $this->input->get('transaksi_id');
		if ($this->input->get('transaksi_detail_group') != 'null') {
			$param['transaksi_detail_group'] = $this->input->get('transaksi_detail_group');
		} else {
			$param['transaksi_detail_id'] = $this->input->get('transaksi_detail_id');
		}
		$param['logsheet_id'] = $this->input->get_post('logsheet_id');
		$data = $this->M_library->getDOFIdentitas($param);
		echo json_encode($data);
	}

	public function getDOFStatus(){
		$param['transaksi_id'] = $this->input->get('transaksi_id');
		$param['transaksi_detail_id'] = $this->input->get('transaksi_detail_id');
		$param['jenis_id'] = $this->input->get('jenis_id');
		$param['transaksi_detail_status'] = $this->input->get('transaksi_detail_status');
		$param['id_template_logsheet'] = $this->input->get('template_logsheet_id');
		$param['logsheet_id'] = $this->input->get('logsheet_id');
		$param['transaksi_rutin_id'] = $this->input->get_post('transaksi_rutin_id');

		$data_awal = $this->M_notifikasi->getNotifikasiBarcodeAwal($param);

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

		$item = curl_exec($token);
		curl_close($token);
		$item = json_decode($item);
		$items = $item->data;
		echo json_encode($items);
	}
}
