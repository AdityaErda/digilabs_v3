<?php
defined('BASEPATH') or exit('No direct script access allowed');

class History_transaksi extends MY_Controller{

	public function __construct() {
		parent::__construct();

		$this->load->model('M_request');
	}

	public function index() {
		$isi['judul'] = 'History Transaksi';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

		$this->load->view('tampilan/header', $isi);
		$this->load->view('tampilan/sidebar', $data);
		$this->load->view('material/history_transaksi');
		$this->load->view('tampilan/footer');
		$this->load->view('material/history_transaksi_js');
	}

	public function print() {
		$this->load->view('material/history_transaksi_print');
	}
}