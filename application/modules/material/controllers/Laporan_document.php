<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan_document extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('M_request');
	}

	public function index()
	{
		$isi['judul'] = 'Laporan Document';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

		$this->load->view('tampilan/header', $isi);
		$this->load->view('tampilan/sidebar', $data);
		$this->load->view('material/laporan_document');
		$this->load->view('tampilan/footer');
		$this->load->view('material/laporan_document_js');
	}

	public function getLapDocument()
	{

		$param['tanggal_cari'] = $this->input->get_post('tanggal_cari');
		$param['tanggal_cari_awal'] = $this->input->get_post('tanggal_cari_awal');
		$param['tanggal_cari_akhir'] = $this->input->get_post('tanggal_cari_akhir');

		$where = array();
		if (!empty($param['tanggal_cari'])) {
			$tgl_ini = date($param['tanggal_cari'] . '-d');
			$where['DATE(batch_file_tgl_terbit) >= '] = date('Y-m-01', strtotime($tgl_ini));
			$where['DATE(batch_file_tgl_terbit) <= '] = date('Y-m-t', strtotime($tgl_ini));
		} else if (!empty($param['tahun_cari'])) {
			$where['DATE(batch_file_tgl_terbit) >= '] = $param['tahun_cari'] . '-01-01';
			$where['DATE(batch_file_tgl_terbit) <= '] = $param['tahun_cari'] . '-12-31';
		}

		$param['batch_file_id'] = $this->input->post('batch_file_id');
		$data = $this->M_request->getLapDocument($param, $where);
		// print_r($where);

		echo json_encode($data);
	}

	public function cetakLapDocument()
	{
		$param['tanggal_cari'] = $this->input->get_post('tanggal_cari');

		$where = array();
		if (!empty($param['tanggal_cari'])) {
			$tgl_ini = date($param['tanggal_cari'] . '-d');
			$where['DATE(batch_file_tgl_terbit) >= '] = date('Y-m-01', strtotime($tgl_ini));
			$where['DATE(batch_file_tgl_terbit) <= '] = date('Y-m-t', strtotime($tgl_ini));
		} else if (!empty($param['tahun_cari'])) {
			$where['DATE(batch_file_tgl_terbit) >= '] = $param['tahun_cari'] . '-01-01';
			$where['DATE(batch_file_tgl_terbit) <= '] = $param['tahun_cari'] . '-12-31';
		}

		$param['batch_file_id'] = $this->input->post('batch_file_id');
		$data['isi'] = $this->M_request->getLapDocument($param, $where);

		// $this->load->view('material/laporan_document_print', $data);
		$this->load->view('material/laporan_document_print_edit', $data);
	}
}
