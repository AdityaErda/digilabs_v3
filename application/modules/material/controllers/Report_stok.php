<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report_stok extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('material/M_request');
		$this->load->model('master/M_material_item');
	}

	public function index()
	{
		$isi['judul'] = 'Report Data Stok';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

		$this->load->view('tampilan/header', $isi);
		$this->load->view('tampilan/sidebar', $data);
		$this->load->view('material/report_stok');
		$this->load->view('tampilan/footer');
		$this->load->view('material/report_stok_js');
	}

	public function getItemReport()
	{
		$listItemReport['results'] = array();
		$param['item_nama'] = $this->input->get('item_nama');
		// sss
		foreach ($this->M_request->getStok($param) as $key => $value) {
			array_push($listItemReport['results'], [
				'id' => $value['item_id'],
				'text' => $value['item_nama'],
			]);
		}
		echo json_encode($listItemReport);
	}

	public function getJenisBarang()
	{
		$listItemReport['results'] = array();
		$param['jenis_nama'] = $this->input->get('jenis_barang');

		foreach ($this->M_request->getJenisBarang($param) as $jb => $value) {
			array_push($listItemReport['results'], [
				'id' => $value['jenis_id'],
				'text' => $value['jenis_nama'],
			]);
		}
		echo json_encode($listItemReport);
	}

	public function getLaporanData()
	{
		// $param['item_id'] = $this->input->get_post('item_id');
		$param['jenis_barang'] = $this->input->get_post('jenis_barang');
		$param['item_cari'] = $this->input->get_post('item_cari');
		$param['tanggal_cari'] = $this->input->get_post('tanggal_cari');
		$param['tahun_cari'] = $this->input->get_post('tahun_cari');
		$param['tanggal_cari_awal'] = $this->input->get_post('tanggal_cari_awal');
		$param['tanggal_cari_akhir'] = $this->input->get_post('tanggal_cari_akhir');

		$where = array();
		// if (!empty($param['tanggal_cari'])) {
		// 	$tgl_ini = date($param['tanggal_cari'] . '-d');
		// 	$where['list_stok_waktu >= '] = date('Y-m-01', strtotime($tgl_ini));
		// 	$where['list_stok_waktu <= '] = date('Y-m-t', strtotime($tgl_ini));
		// } else if (!empty($param['tahun_cari'])) {
		// 	$where['list_stok_waktu >= '] = $param['tahun_cari'] . '-01-01';
		// 	$where['list_stok_waktu <= '] = $param['tahun_cari'] . '-12-31';
		// }

		$data = $this->M_request->getLaporanData($param,$where);
		echo json_encode($data);
	}


	public function cetakLaporanBulanan()
	{
		$param['jenis_barang'] = $this->input->get_post('jenis_barang');
		$param['item_cari'] = $this->input->get_post('item_cari');
		$param['tanggal_cari'] = $this->input->get_post('tanggal_cari');
		$param['tahun_cari'] = $this->input->get_post('tahun_cari');
		$param['tanggal_cari_awal'] = $this->input->get_post('tanggal_cari_awal');
		$param['tanggal_cari_akhir'] = $this->input->get_post('tanggal_cari_akhir');

		$where = array();
		if (!empty($param['tanggal_cari'])) {
			$tgl_ini = date($param['tanggal_cari'] . '-d');
			$where['list_stok_waktu >= '] = date('Y-m-01', strtotime($tgl_ini));
			$where['list_stok_waktu <= '] = date('Y-m-t', strtotime($tgl_ini));
		} else if (!empty($param['tahun_cari'])) {
			$where['list_stok_waktu >= '] = $param['tahun_cari'] . '-01-01';
			$where['list_stok_waktu <= '] = $param['tahun_cari'] . '-12-31';
		}
		$isi['data'] = $this->M_request->getLaporanData($param, $where);

		// $this->load->view('material/bulanan_print', $isi);
		$this->load->view('material/bulanan_print_edit', $isi);
	}
}
