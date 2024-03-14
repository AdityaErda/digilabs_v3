<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kode_sample extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
		$this->load->model('master/M_kode_sample');
	}

	public function index()
	{
		$isi['judul'] = 'Kode Sample';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');
		$data['tipe'] = $this->input->get('tipe');

		$this->load->view('tampilan/header', $isi);
		$this->load->view('tampilan/sidebar', $data);
		$this->load->view('master/kode_sample');
		$this->load->view('tampilan/footer');
		$this->load->view('master/kode_sample_js');
	}

	public function getKodeSample()
	{
		$param['kode_sample_id'] = $this->input->get_post('kode_sample_id');
		$data = $this->M_kode_sample->getKodeSample($param);
		echo json_encode($data);
	}

	public function updateKodeSample()
	{
		$id = $this->input->get_post('kode_sample_id');
		$param['kode_sample_nama'] = anti_inject($this->input->get_post('kode_sample_nama'));
		$param['kode_sample_kode_awal'] = anti_inject($this->input->get_post('kode_sample_kode_awal'));
		$param['kode_sample_kode_akhir'] = anti_inject($this->input->get_post('kode_sample_kode_akhir'));

		// Pecah
		$kode = range($param['kode_sample_kode_awal'], $param['kode_sample_kode_akhir']);
		$kodex = array();
		foreach ($kode as $key => $kodes) {
			array_push($kodex, $kodes);
		}
		$param['kode_sample_kode'] = implode(',', $kodex);
		$this->M_kode_sample->updateKodeSample($id, $param);
		echo $this->db->last_query();
	}
}

/* End of file Kode_sample.php */
