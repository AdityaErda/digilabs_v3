<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notifikasi extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('M_request');
	}

	public function index()
	{
		$isi['judul'] = 'Material Notifikasi';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

		$this->load->view('tampilan/header', $isi);
		$this->load->view('tampilan/sidebar', $data);
		$this->load->view('material/notifikasi');
		$this->load->view('tampilan/footer');
		$this->load->view('material/notifikasi_js');
	}

	// data stok limit
	public function getLimitMaterial()
	{
		$param['item_id'] = $this->input->get_post('item_id');
		$data = $this->M_request->getLimitMaterial($param);

		echo json_encode($data);
	}

	public function getLimitMaterialJumlah()
	{
		$param['item_id'] = $this->input->get_post('item_id');
		$data = $this->M_request->getLimitMaterialJumlah($param);
		echo json_encode($data);
		// $this->load->view('tampilan/sidebar',$data);
	}
}
