<?php
defined('BASEPATH') or exit('No direct script access allowed');

class History_card extends MY_Controller{

	public function __construct() {
		parent::__construct();

		$this->load->model('material/M_request');
		$this->load->model('master/M_material_aset');
	}

	public function index() {
		$isi['judul'] = 'History Card';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

		$this->load->view('tampilan/header', $isi);
		$this->load->view('tampilan/sidebar', $data);
		$this->load->view('material/history_card');
		$this->load->view('tampilan/footer');
		$this->load->view('material/history_card_js');
	}

	public function getAset(){
		$param['aset_id'] = $this->input->get('aset_id');
		$data = $this->M_request->getAset($param);
		echo json_encode($data);
	}

	public function getAsetDetail(){
		$param['aset_detail_id'] = $this->input->get_post('aset_detail_id');
		$param['aset_id'] = $this->input->get_post('aset_id');
		$data = $this->M_request->getAsetDetail($param);
		echo json_encode($data);
		// print_r($this->db->last_query());
	}

	public function getAsetDetailDownload(){
		$param['aset_id'] = $this->input->get_post('aset_id');
		$data = $this->M_request->getAsetDetailDownload($param);
		echo json_encode($data);
		
	}

	public function getAsetDetailHistory(){
		$param['aset_id'] = $this->input->get_post('aset_id');
		$data = $this->M_request->getAsetDetailHistory($param);
		echo json_encode($data);
		
	}

	public function getAsetMovement(){
		$param['aset_perbaikan_id'] = $this->input->get_post('aset_perbaikan_id');
		$data = $this->M_request->getAsetMovement($param);
		echo json_encode($data);

	}

	public function insertAsetMovement(){
		$user = $this->session->userdata();
		$param['aset_history_id'] = create_id();
		$param['aset_perbaikan_id'] = $this->input->get_post('aset_perbaikan_id');
		$param['aset_history_tgl_movement'] = date('Y-m-d', strtotime($this->input->get_post('tanggal')));
		$param['peminta_jasa_id'] = $this->input->get_post('peminta_jasa_id');
		$param['when_create'] = date('Y-m-d H:i:s');
		$param['who_create'] = $user['user_nama_lengkap'];
		// 
		$this->M_request->insertAsetMovement($param);

		$id = $this->input->get_post('aset_perbaikan_id');
		$param1['aset_perbaikan_tgl_movement'] = date('Y-m-d', strtotime($this->input->get_post('tanggal')));
		$param1['peminta_id'] = $this->input->get_post('peminta_jasa_id');

		$this->M_request->updateAsetMovement($id,$param1);

	}

	// public function updateAsetMovement(){
		
	// }

	public function getAsetHistory(){
		$param['aset_perbaikan_id'] = $this->input->get_post('aset_perbaikan_id');
		
		$data = $this->M_request->getAsetHistory($param);
		echo json_encode($data);
	}

}