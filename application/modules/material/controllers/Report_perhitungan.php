<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report_perhitungan extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('M_request');
	}

	public function index()
	{
		$isi['judul'] = 'Report Perhitungan';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

		$this->load->view('tampilan/header', $isi);
		$this->load->view('tampilan/sidebar', $data);
		$this->load->view('material/report_perhitungan');
		$this->load->view('tampilan/footer');
		$this->load->view('material/report_perhitungan_js');
	}

	public function getReportPerhitungan()
	{
		$user = $this->session->userdata();
		$param['transaksi_detail_id'] = $this->input->get_post('transaksi_detail_id');
		$param['transaksi_id'] = $this->input->get_post('transaksi_id');
		$param['tanggal_cari'] = $this->input->get_post('tanggal_cari');
		$param['tanggal_cari_awal'] = $this->input->get_post('tanggal_cari_awal');
		$param['tanggal_cari_akhir'] = $this->input->get_post('tanggal_cari_akhir');

		$where = array();
		if (!empty($param['tanggal_cari'])) {
			$tgl_ini = date($param['tanggal_cari'] . '-d');
			$where['DATE(transaksi_waktu) >= '] = date('Y-m-01', strtotime($tgl_ini));
			$where['DATE(transaksi_waktu) <= '] = date('Y-m-t', strtotime($tgl_ini));
		} else if (!empty($param['tahun_cari'])) {
			$where['DATE(transaksi_waktu) >= '] = $param['tahun_cari'] . '-01-01';
			$where['DATE(transaksi_waktu) <= '] = $param['tahun_cari'] . '-12-31';
		}
		// $param['peminta_jasa_cari'] = $user['id_seksi'];
		$param['peminta_jasa_cari'] = $this->input->get_post('peminta_jasa_cari');
		$param['material_cari'] = $this->input->get_post('material_cari');


		$data = $this->M_request->getReportPerhitungan($param, $where);
		// echo $this->db->last_query();
		echo json_encode($data);
	}

	public function print()
	{
		$user = $this->session->userdata();
		$param['transaksi_detail_id'] = $this->input->get_post('transaksi_detail_id');
		$param['transaksi_id'] = $this->input->get_post('transaksi_id');
		$param['tanggal_cari'] = $this->input->get_post('tanggal_cari');
		$param['tanggal_cari_awal'] = $this->input->get_post('tanggal_cari_awal');
		$param['tanggal_cari_akhir'] = $this->input->get_post('tanggal_cari_akhir');

		$where = array();
		if (!empty($param['tanggal_cari'])) {
			$tgl_ini = date($param['tanggal_cari'] . '-d');
			$where['DATE(transaksi_waktu) >= '] = date('Y-m-01', strtotime($tgl_ini));
			$where['DATE(transaksi_waktu) <= '] = date('Y-m-t', strtotime($tgl_ini));
		} else if (!empty($param['tahun_cari'])) {
			$where['DATE(transaksi_waktu) >= '] = $param['tahun_cari'] . '-01-01';
			$where['DATE(transaksi_waktu) <= '] = $param['tahun_cari'] . '-12-31';
		}
		$param['peminta_jasa_cari'] = $this->input->get_post('peminta_jasa_cari');
		$param['material_cari'] = $this->input->get_post('material_cari');

		$data['isi'] = $this->M_request->getReportPerhitungan($param, $where);

		// $this->load->view('material/report_perhitungan_print', $data);
		$this->load->view('material/report_perhitungan_print_edit', $data);
	}
}
