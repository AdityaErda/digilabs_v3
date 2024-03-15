<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Departemen extends MY_Controller{

	public function __construct(){
		parent::__construct();
		isLogin();
		//Do your magic here
		$this->load->model('M_departemen');
	}

	public function index(){
		$isi['judul'] = 'Departemen';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');
		$data['kategori'] = $this->input->get('kategori');

		$this->template->template_master('api/departemen',$isi,$data);
	}


	public function getDepartemen(){
		error_reporting(0);
		$sesi = $this->session->userdata();
		// generate token
		$dep = $this->input->get_post('departemen_id');
		$api_key = "6BF86150-729F-410B-9871-D3F06CA05B7E";
		// generate berdarkan loginnya
		$token = $this->session->userdata('access_token');

		$url = 'http://sso.petrokimia-gresik.com/api/user/ListDepartemen?apikey=' . $api_key . '&dep=' . $dep;
		$options = array('http' => array(
			'method'  => 'GET',
			'header' => 'Authorization: Bearer ' . $token
		));
		$context  = stream_context_create($options);
		$response = file_get_contents($url, false, $context);

		if (json_decode($response, true)) {
			$data = json_decode($response, true);
			for ($i = 0; $i < count($data); $i++) {
				$datas[$i] = array(
					'departemen_kode' => $data[$i]['depCode'],
					'departemen_id' => $data[$i]['idDep'],
					'departemen_nama' => $data[$i]['namaDep'],
					'departemen_komp_id' => $data[$i]['idKomp'],
					'departemen_komp_nama' => $data[$i]['namaKomp'],
					'status' => 'success',
				);

				// checking
				$query = $this->db->get_where('global.global_api_departemen', array('departemen_id' => $data[$i]['idDep']))->num_rows();
				if ($query == 0) {
					$param['departemen_kode'] = $data[$i]['depCode'];
					$param['departemen_id'] = $data[$i]['idDep'];
					$param['departemen_nama'] = $data[$i]['namaDep'];
					$param['departemen_komp_id'] = $data[$i]['idKomp'];
					$param['departemen_nama_komp'] = $data[$i]['namaKomp'];

					$this->db->insert('global.global_api_departemen', $param);
				} else {
					$id = $data[$i]['idDep'];
					$param['departemen_kode'] = $data[$i]['depCode'];
					$param['departemen_nama'] = $data[$i]['namaDep'];
					$param['departemen_komp_id'] = $data[$i]['idKomp'];
					$param['departemen_nama_komp'] = $data[$i]['namaKomp'];

					$this->db->where('departemen_id', $id);
					$this->db->update('global.global_api_departemen', $param);
				}
			}
		} else {
			$param['dep'] = $this->input->get_post('departemen_id');
			$datas = $this->M_departemen->getDepartemen($param);
		}
		echo json_encode($datas);
	}

	public function getDepartemenList(){
		$departemen['results'] = array();
		$param['param_search'] = $this->input->get('param_search');
		// sss
		foreach ($this->M_departemen->getDepartemen($param) as $key => $value) {
			array_push($departemen['results'], [
				'id' => $value['departemen_id'],
				'text' => $value['departemen_nama'],
			]);
		}
		echo json_encode($departemen);
	}
}

/* End of file Departemen.php */
