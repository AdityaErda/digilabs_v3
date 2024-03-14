<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tahunan extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('material/M_request');
		$this->load->model('master/M_material_item');
	}

	public function index()
	{
		$isi['judul'] = 'Report Tahunan';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

		$this->load->view('tampilan/header', $isi);
		$this->load->view('tampilan/sidebar', $data);
		$this->load->view('material/tahunan');
		$this->load->view('tampilan/footer');
		$this->load->view('material/tahunan_js');
	}

	public function getLaporanData()
	{
		// $param['item_id'] = $this->input->get_post('item_id');
		$param['jenis_barang'] = $this->input->get_post('jenis_barang');
		$param['item_cari'] = $this->input->get_post('item_cari');
		$param['bulan_cari'] = $this->input->get_post('bulan_cari');
		$param['tahun_cari'] = $this->input->get_post('tahun_cari');
		$where = array();
		if (!empty($param['bulan_cari'])) {
			$tgl_ini = date($param['tahun_cari'] . '-' . $param['bulan_cari'] . '-d');
			$where['list_stok_waktu >= '] = date('Y-m-01', strtotime($tgl_ini));
			$where['list_stok_waktu <= '] = date('Y-m-t', strtotime($tgl_ini));
		} else if (!empty($param['tahun_cari'])) {
			$where['list_stok_waktu >= '] = $param['tahun_cari'] . '-01-01';
			$where['list_stok_waktu <= '] = $param['tahun_cari'] . '-12-31';
		}
		// $param[]
		// ganti ke sgetMaternail
		$data = $this->M_request->getLaporanData($param, $where);
		// print_r($this->db->last_query());
		echo json_encode($data);
	}

	public function cetakLaporanTahunan()
	{
		$param['item_cari'] = $this->input->get_post('item_cari');
		$param['bulan_cari'] = $this->input->get_post('bulan_cari');
		$param['tahun_cari'] = $this->input->get_post('tahun_cari');
		$where = array();
		if (!empty($param['bulan_cari'])) {
			$tgl_ini = date($param['tahun_cari'] . '-' . $param['bulan_cari'] . '-d');
			$where['list_stok_waktu >= '] = date('Y-m-01', strtotime($tgl_ini));
			$where['list_stok_waktu <= '] = date('Y-m-t', strtotime($tgl_ini));
		} else if (!empty($param['tahun_cari'])) {
			$where['list_stok_waktu >= '] = $param['tahun_cari'] . '-01-01';
			$where['list_stok_waktu <= '] = $param['tahun_cari'] . '-12-31';
		}
		$isi['data'] = $this->M_request->getLaporanData($param, $where);
		// echo json_encode($isi);
		// print_r($this->db->last_query());
		$this->load->view('material/tahunan_print', $isi);
	}



	public function print()
	{
		$this->load->view('material/tahunan_print');
	}
}
