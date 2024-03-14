<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reject_nomor extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		isLogin();
		$this->load->model('sample/M_reject_nomor');
	}

	public function index()
	{
		$isi['judul'] = 'Reject Nomor Sample';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

		$this->load->view('tampilan/header', $isi);
		$this->load->view('tampilan/sidebar', $data);
		$this->load->view('sample/reject_nomor');
		$this->load->view('tampilan/footer');
		$this->load->view('sample/reject_nomor_js');
	}

	public function getNomor()
	{
		$param['tanggal_cari'] = $this->input->get_post('tanggal_cari');
		$param['tanggal_cari_awal'] = $this->input->get_post('tanggal_cari_awal');
		$param['tanggal_cari_akhir'] = $this->input->get_post('tanggal_cari_akhir');

		$where = array();
		// if (!empty($param['tanggal_cari'])) {
		// 	$tgl_ini = date($param['tanggal_cari'] . '-d');
		// 	$where['DATE(transaksi_tgl) >= '] = date('Y-m-01', strtotime($tgl_ini));
		// 	$where['DATE(transaksi_tgl) <= '] = date('Y-m-t', strtotime($tgl_ini));
		// } else if (!empty($param['tahun_cari'])) {
		// 	$where['DATE(transaksi_tgl) >= '] = $param['tahun_cari'] . '-01-01';
		// 	$where['DATE(transaksi_tgl) <= '] = $param['tahun_cari'] . '-12-31';
		// }
		$data = $this->M_reject_nomor->getNomor($param, $where);
		echo json_encode($data);
	}

	public function prosesNomor()
	{
		$param = array();

		if ($this->input->get('tgl_cari')) $tgl = explode(' - ', $this->input->get('tgl_cari'));
		if ($this->input->get('tgl_cari')) $param['tgl_awal'] = date('Y-m-d', strtotime($tgl[0]));
		if ($this->input->get('tgl_cari')) $param['tgl_akhir'] = date('Y-m-d', strtotime($tgl[1]));

		$data = $this->M_reject_nomor->getNomor($param);

		foreach ($this->M_reject_nomor->getNomor($param) as $value) {
			$id = $value['transaksi_id'];
			$data = array('transaksi_status' => '8');
			$this->M_reject_nomor->updateNomor($data, $id);

			$id_detail = $value['transaksi_id'];
			$data_detail = array('transaksi_detail_status' => '8');
			$this->M_reject_nomor->updateNomorDetail($data_detail, $id_detail);
		}
	}
}
