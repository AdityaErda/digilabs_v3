<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Unit_kerja extends MY_Controller{

	public function __construct(){
		parent::__construct();
		isLogin();
		$this->load->model('api/M_unit_kerja');
	}

	public function index(){
		$isi['judul'] = 'Departemen';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');
		$data['kategori'] = $this->input->get('kategori');

		$this->template->template_master('api/unit_kerja',$isi,$data);
	}


	public function getUnitKerja(){
		error_reporting(0);
		$sesi = $this->session->userdata();
		// generate token
		$unit_kerja = $this->input->get_post('unit_kerja_id');
		$api_key = "6BF86150-729F-410B-9871-D3F06CA05B7E";
		// nanti generate berdarkan loginnya
		$token = $this->session->userdata('access_token');

		$url = 'http://sso.petrokimia-gresik.com/api/user/ListUnitKerja?apikey=' . $api_key . '&unitkerja=' . $unit_kerja;
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
					'unit_kerja_id' => $data[$i]['unitKerja'],
					'unit_kerja_nama' => $data[$i]['namaUnitKerja'],
					'unit_kerja_parent' => $data[$i]['parentUnitKerja'],
					'unit_kerja_level' => $data[$i]['orgLevelName'],
				);
				// die();

				// checking
				$query = $this->db->get_where('global.global_api_unit_kerja', array('unit_kerja_id' => $data[$i]['unitKerja']))->num_rows();
				if ($query == 0) {
					$param['unit_kerja_id'] = $data[$i]['unitKerja'];
					$param['unit_kerja_nama'] = $data[$i]['namaUnitKerja'];
					$param['unit_kerja_parent'] = $data[$i]['parentUnitKerja'];
					$param['unit_kerja_level'] = $data[$i]['orgLevelName'];
					$this->db->insert('global.global_api_unit_kerja', $param);
				} else {
					$id = $data[$i]['unitKerja'];
					$param['unit_kerja_nama'] = $data[$i]['namaUnitKerja'];
					$param['unit_kerja_parent'] = $data[$i]['parentUnitKerja'];
					$param['unit_kerja_level'] = $data[$i]['orgLevelName'];
					$this->db->where('unit_kerja_id', $id);
					$this->db->update('global.global_api_unit_kerja', $param);
				}
			}
		} else {
			$param['unitkerja'] = $this->input->get_post('unit_kerja_id');
			$datas = $this->M_unit_kerja->getUnitKerja($param);
			// $datanya =
		}
		echo json_encode($datas);
	}

	public function getUnitKerjaList(){
		$unitKerja['results'] = array();
		$param['unit_kerja_nama'] = $this->input->get('unit_kerja_nama');
		// sss
		foreach ($this->M_unit_kerja->getUnitKerja($param) as $key => $value) {
			array_push($unitKerja['results'], [
				'id' => $value['unit_kerja_id'],
				'text' => $value['unit_kerja_id'] . ' | ' . $value['unit_kerja_nama'],
			]);
		}
		echo json_encode($unitKerja);
	}
}


/* End of file Unit_kerja.php */
