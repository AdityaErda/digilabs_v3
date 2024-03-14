<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notifikasi_document extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('M_request');
	}

	public function index()
	{
		$isi['judul'] = 'Notifikasi Document';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

		$this->load->view('tampilan/header', $isi);
		$this->load->view('tampilan/sidebar', $data);
		$this->load->view('material/notifikasi_document');
		$this->load->view('tampilan/footer');
		$this->load->view('material/notifikasi_document_js');
	}

	public function getNotifDokumen()
	{

		$param['tanggal_cari'] = $this->input->get_post('tanggal_cari');
		$param['tanggal_cari_awal'] = $this->input->get_post('tanggal_cari_awal');
		$param['tanggal_cari_akhir'] = $this->input->get_post('tanggal_cari_akhir');

		$where = array();
		if (!empty($param['tanggal_cari'])) {
			$tgl_ini = date($param['tanggal_cari'] . '-d');
			$where['DATE(batch_file_tgl_expired) >= '] = date('Y-m-01', strtotime($tgl_ini));
			$where['DATE(batch_file_tgl_expired) <= '] = date('Y-m-t', strtotime($tgl_ini));
		} else if (!empty($param['tahun_cari'])) {
			$where['DATE(batch_file_tgl_expired) >= '] = $param['tahun_cari'] . '-01-01';
			$where['DATE(batch_file_tgl_expired) <= '] = $param['tahun_cari'] . '-12-31';
		}

		$param['batch_file_id'] = $this->input->post('batch_file_id');
		$data = $this->M_request->getNotifDokumen($param, $where);
		echo json_encode($data);
		// print_r($this->db->last_query());
	}

	public function getNotifDocumentJumlah()
	{
		$param['batch_file_id'] = $this->input->post('batch_file_id');
		$data = $this->M_request->getNotifDocumentJumlah($param);
		echo json_encode($data);
	}
}
