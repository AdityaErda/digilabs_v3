<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master_cost_center extends MY_Controller{

	public function __construct() {
		parent::__construct();

		$this->load->model('M_request');
	}

	public function index() {
		$isi['judul'] = 'Master Cost Center';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

		$this->load->view('tampilan/header', $isi);
		$this->load->view('tampilan/sidebar', $data);
		$this->load->view('material/master_cost_center');
		$this->load->view('tampilan/footer');
		$this->load->view('material/master_cost_center_js');
	}
}