<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report extends MY_Controller{

	public function __construct(){
		parent::__construct();
		isLogin();
		$this->load->model('sample/M_report');
	}

	public function index(){
		$isi['judul'] = 'Report Sample';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');
		$data['tipe'] = $this->input->get('tipe');

		$this->template->template_master('sample/report',$isi,$data);
	}

	/* GET */
	public function getJenisSample(){
		$listJenis['results'] = array();

		$param['jenis_nama'] = $this->input->get('jenis_nama');
		foreach ($this->M_report->getJenisSample($param) as $key => $value) {
			array_push($listJenis['results'], [
				'id' => $value['jenis_id'],
				'text' => $value['jenis_nama'],
			]);
		}

		echo json_encode($listJenis);
	}

	public function getParameter(){
		$param['transaksi_id'] = $this->input->get_post('transaksi_id');
		$param['transaksi_detail_id'] = $this->input->get_post('transaksi_detail_id');
		$param['jenis_id'] = $this->input->get_post('jenis_id');
		$param['tanggal_cari'] = $this->input->get_post('tanggal_cari');
		$param['tanggal_cari_awal'] = $this->input->get_post('tanggal_cari_awal');
		$param['tanggal_cari_akhir'] = $this->input->get_post('tanggal_cari_akhir');
		$param['transaksi_status'] = $this->input->get_post('transaksi_status');
		$param['jenis_id'] = $this->input->get_post('jenis');

		$data = $this->M_report->getParameter($param);
		// echo $this->db->last_query($data);

		echo json_encode($data);
	}

	public function getHistoryLogSheet(){
		$param['transaksi_id'] = $this->input->get_post('transaksi_id');
		$param['jenis_id'] = $this->input->get_post('jenis_id');
		// $param['jenis_id'] = $this->input->get_post('jenis');
		$param['id_rumus'] = $this->input->get_post('id_rumus');
		$param['tanggal_cari'] = $this->input->get_post('tanggal_cari');
		$param['tanggal_cari_awal'] = $this->input->get_post('tanggal_cari_awal');
		$param['tanggal_cari_akhir'] = $this->input->get_post('tanggal_cari_akhir');

		$data = $this->M_report->getHistoryLogSheet($param);

		echo json_encode($data);
	}

	public function print(){
		$param['transaksi_id'] = $this->input->get_post('transaksi_id');
		$param['jenis_id'] = $this->input->get_post('jenis_id');
		$param['jenis_id'] = $this->input->get_post('jenis');
		$param['id_rumus'] = $this->input->get_post('id_rumus');
		$param['tanggal_cari'] = $this->input->get_post('tanggal_cari');
		$param['tanggal_cari_awal'] = $this->input->get_post('tanggal_cari_awal');
		$param['tanggal_cari_akhir'] = $this->input->get_post('tanggal_cari_akhir');

		$value['aset_baru'] = $this->M_report->getHistoryLogSheet($param);

		// $this->load->view('sample/cetak/cetak_report_sample', $value);
		$this->load->view('sample/cetak/cetak_report_sample_baru', $value);
	}
	/* GET */
}
