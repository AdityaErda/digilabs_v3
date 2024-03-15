<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends MY_Controller{

	public function __construct(){
		parent::__construct();
		//Do your magic here
		isLogin();
		$this->load->model('M_user');
	}

	public function index(){
		$isi['judul'] = 'Karyawan';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');
		$data['kategori'] = $this->input->get('kategori');

		$this->load->view('tampilan/header', $isi);
		$this->load->view('tampilan/sidebar', $data);
		$this->load->view('api/user');
		$this->load->view('tampilan/footer');
		$this->load->view('api/user_js');
	}


	public function getUser(){
		error_reporting(0);
		$sesi = $this->session->userdata();
		// generate token
		$unit_kerja = $this->input->get_post('departemen_id');
		$api_key = "6BF86150-729F-410B-9871-D3F06CA05B7E";
		// nanti generate berdarkan loginnya
		$token = $this->session->userdata('access_token');

		$url = 'http://sso.petrokimia-gresik.com/api/user/ListKaryawanV2?apikey=' . $api_key . '&name=' . $unit_kerja;
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
					'user_nik' => $data[$i]['nik'],
					'user_nik_sap' => $data[$i]['nikSap'],
					'user_nama' => $data[$i]['nama'],
					'user_no_hp' => $data[$i]['noHp'],
					'user_status_karyawan' => $data[$i]['statusKaryawan'],
					'user_type' => $data[$i]['empType'],
					'user_unit_kerja_id' => $data[$i]['unitKerjaId'],
					'user_unit_kerja_nama' => $data[$i]['unitKerjaName'],
					'user_unit_kerja_parent' => $data[$i]['parentUnitKerja'],
					'user_pgrade' => $data[$i]['pGrade'],
					'user_tmtpgrade' => $data[$i]['tmtPGrade'],
					'user_jobgrade' => $data[$i]['jobGrade'],
					'user_tmtjbt' => $data[$i]['tmtJbt'],
					'user_tmtpjs' => $data[$i]['tmtPjs'],
					'user_tmtuker' => $data[$i]['tmtUker'],
					'user_bp' => $data[$i]['bp'],
					'user_lokasi_kerja' => $data[$i]['workLoc'],
					'user_job_id' => $data[$i]['jobId'],
					'user_job_title' => $data[$i]['jobTitle'],
					'user_poscode' => $data[$i]['posCode'],
					'user_direct_superior' => $data[$i]['directSuperior'],
					'user_unit_id' => $data[$i]['unitId'],
					'user_departemen' => $data[$i]['department'],
					'user_post_title' => $data[$i]['postTitle'],
					'user_tempat_lahir' => $data[$i]['tempatLahir'],
					'user_tanggal_lahir' => $data[$i]['tglLahir'],
					'user_tanggal_masuk' => $data[$i]['tanggalMasuk'],
					'user_tanggal_pensiun' => $data[$i]['tanggalPensiun'],
					'user_status_kawin' => $data[$i]['statusPerkawinan'],
					'user_alamat' => $data[$i]['alamat'],
					'user_provinsi' => $data[$i]['provinsi'],
					'user_kabupaten' => $data[$i]['kabupaten'],
					'user_kecamatan' => $data[$i]['kecamatan'],
					'user_kelurahan' => $data[$i]['kelurahan'],
					'user_agama' => $data[$i]['agama'],
					'user_jenis_kelamin' => $data[$i]['jenisKelamin'],
					'user_pendidikan_akhir' => $data[$i]['pendidikanAkhir'],
					'user_pendididikan_diterima' => $data[$i]['pendidikanDiterima'],
					'user_email' => $data[$i]['email'],
					'user_foto' => $data[$i]['foto'],
					'user_npwp' => $data[$i]['npwp'],
					'user_departemen_id' => $data[$i]['idDep'],
					'user_departemen_nama' => $data[$i]['namaDep'],
					'user_komp_id' => $data[$i]['idKomp'],
					'user_komp_nama' => $data[$i]['namaKomp'],
					'user_direktori_id' => $data[$i]['idDir'],
					'user_direktori_nama' => $data[$i]['namaDir'],

				);
				// die();

				// checking
				$query = $this->db->get_where('global.global_api_user', array('user_nik' => $data[$i]['nik']))->num_rows();
				if ($query == 0) {
					$param['user_nik'] = $data[$i]['nik'];
					$param['user_nik_sap'] = $data[$i]['nikSap'];
					$param['user_nama'] = $data[$i]['nama'];
					$param['user_no_hp'] = $data[$i]['noHp'];
					$param['user_status_karyawan'] = $data[$i]['statusKaryawan'];
					$param['user_type'] = $data[$i]['empType'];
					$param['user_unit_kerja_id'] = $data[$i]['unitKerjaId'];
					$param['user_unit_kerja_nama'] = $data[$i]['unitKerjaName'];
					$param['user_unit_kerja_parent'] = $data[$i]['parentUnitKerja'];
					$param['user_pgrade'] = $data[$i]['pGrade'];
					$param['user_tmtpgrade'] = $data[$i]['tmtPGrade'];
					$param['user_jobgrade'] = $data[$i]['jobGrade'];
					$param['user_tmtjbt'] = $data[$i]['tmtJbt'];
					$param['user_tmtpjs'] = $data[$i]['tmtPjs'];
					$param['user_tmtuker'] = $data[$i]['tmtUker'];
					$param['user_bp'] = $data[$i]['bp'];
					$param['user_lokasi_kerja'] = $data[$i]['workLoc'];
					$param['user_job_id'] = $data[$i]['jobId'];
					$param['user_job_title'] = $data[$i]['jobTitle'];
					$param['user_poscode'] = $data[$i]['posCode'];
					$param['user_direct_superior'] = $data[$i]['directSuperior'];
					$param['user_unit_id'] = $data[$i]['unitId'];
					$param['user_departemen'] = $data[$i]['department'];
					$param['user_post_title'] = $data[$i]['postTitle'];
					$param['user_tempat_lahir'] = $data[$i]['tempatLahir'];
					$param['user_tanggal_lahir'] = $data[$i]['tglLahir'];
					$param['user_tanggal_masuk'] = $data[$i]['tanggalMasuk'];
					$param['user_tanggal_pensiun'] = $data[$i]['tanggalPensiun'];
					$param['user_status_kawin'] = $data[$i]['statusPerkawinan'];
					$param['user_alamat'] = $data[$i]['alamat'];
					$param['user_provinsi'] = $data[$i]['provinsi'];
					$param['user_kabupaten'] = $data[$i]['kabupaten'];
					$param['user_kecamatan'] = $data[$i]['kecamatan'];
					$param['user_kelurahan'] = $data[$i]['kelurahan'];
					$param['user_agama'] = $data[$i]['agama'];
					$param['user_jenis_kelamin'] = $data[$i]['jenisKelamin'];
					$param['user_pendidikan_akhir'] = $data[$i]['pendidikanAkhir'];
					$param['user_pendididikan_diterima'] = $data[$i]['pendidikanDiterima'];
					$param['user_email'] = $data[$i]['email'];
					$param['user_foto'] = $data[$i]['foto'];
					$param['user_npwp'] = $data[$i]['npwp'];
					$param['user_departemen_id'] = $data[$i]['idDep'];
					$param['user_departemen_nama'] = $data[$i]['namaDep'];
					$param['user_komp_id'] = $data[$i]['idKomp'];
					$param['user_komp_nama'] = $data[$i]['namaKomp'];
					$param['user_direktori_id'] = $data[$i]['idDir'];
					$param['user_direktori_nama'] = $data[$i]['namaDir'];
					$this->db->insert('global.global_api_user', $param);
					// $this->db->last_query();
				} else {
					$id = $data[$i]['nik'];
					$param['user_nik_sap'] = $data[$i]['nikSap'];
					$param['user_nama'] = $data[$i]['nama'];
					$param['user_no_hp'] = $data[$i]['noHp'];
					$param['user_status_karyawan'] = $data[$i]['statusKaryawan'];
					$param['user_type'] = $data[$i]['empType'];
					$param['user_unit_kerja_id'] = $data[$i]['unitKerjaId'];
					$param['user_unit_kerja_nama'] = $data[$i]['unitKerjaName'];
					$param['user_unit_kerja_parent'] = $data[$i]['parentUnitKerja'];
					$param['user_pgrade'] = $data[$i]['pGrade'];
					$param['user_tmtpgrade'] = $data[$i]['tmtPGrade'];
					$param['user_jobgrade'] = $data[$i]['jobGrade'];
					$param['user_tmtjbt'] = $data[$i]['tmtJbt'];
					$param['user_tmtpjs'] = $data[$i]['tmtPjs'];
					$param['user_tmtuker'] = $data[$i]['tmtUker'];
					$param['user_bp'] = $data[$i]['bp'];
					$param['user_lokasi_kerja'] = $data[$i]['workLoc'];
					$param['user_job_id'] = $data[$i]['jobId'];
					$param['user_job_title'] = $data[$i]['jobTitle'];
					$param['user_poscode'] = $data[$i]['posCode'];
					$param['user_direct_superior'] = $data[$i]['directSuperior'];
					$param['user_unit_id'] = $data[$i]['unitId'];
					$param['user_departemen'] = $data[$i]['department'];
					$param['user_post_title'] = $data[$i]['postTitle'];
					$param['user_tempat_lahir'] = $data[$i]['tempatLahir'];
					$param['user_tanggal_lahir'] = $data[$i]['tglLahir'];
					$param['user_tanggal_masuk'] = $data[$i]['tanggalMasuk'];
					$param['user_tanggal_pensiun'] = $data[$i]['tanggalPensiun'];
					$param['user_status_kawin'] = $data[$i]['statusPerkawinan'];
					$param['user_alamat'] = $data[$i]['alamat'];
					$param['user_provinsi'] = $data[$i]['provinsi'];
					$param['user_kabupaten'] = $data[$i]['kabupaten'];
					$param['user_kecamatan'] = $data[$i]['kecamatan'];
					$param['user_kelurahan'] = $data[$i]['kelurahan'];
					$param['user_agama'] = $data[$i]['agama'];
					$param['user_jenis_kelamin'] = $data[$i]['jenisKelamin'];
					$param['user_pendidikan_akhir'] = $data[$i]['pendidikanAkhir'];
					$param['user_pendididikan_diterima'] = $data[$i]['pendidikanDiterima'];
					$param['user_email'] = $data[$i]['email'];
					$param['user_foto'] = $data[$i]['foto'];
					$param['user_npwp'] = $data[$i]['npwp'];
					$param['user_departemen_id'] = $data[$i]['idDep'];
					$param['user_departemen_nama'] = $data[$i]['namaDep'];
					$param['user_komp_id'] = $data[$i]['idKomp'];
					$param['user_komp_nama'] = $data[$i]['namaKomp'];
					$param['user_direktori_id'] = $data[$i]['idDir'];
					$param['user_direktori_nama'] = $data[$i]['namaDir'];
					$this->db->where('user_nik', $id);
					$this->db->update('global.global_api_user', $param);
				}
			}
		} else {
			$param = array();
			$datas = $this->M_user->getUserList($param);
		}
		echo json_encode($datas);
	}

	public function getUserById(){
		$user['results'] = array();
		$session = $this->session->userdata();
		$param['param_search'] = $this->input->get('param_search');
		$param['user_unit_id_array'] = array('E44000');
		$param['user_detail_id'] = $this->input->get_post('user_detail_id');

		$data = $this->M_user->getUserList2($param);
		echo json_encode($data);
	}

	public function getUserJabatanList(){
		$userjabatan['results'] = array();
		$param['param_name'] = $this->input->get('param_name');
		foreach ($this->M_user->getUserJabatanList($param) as $key => $value) {
			array_push($userjabatan['results'], [
				'id' => $value['user_poscode'],
				'text' => $value['user_post_title'],
			]);
		}
		echo json_encode($userjabatan);
	}

	public function getUserList(){

		$user['results'] = array();

		$session = $this->session->userdata();

		$param['param_search'] = $this->input->get('param_search');

		if ($this->input->get_post('direct_superior') != '') {
			$param['direct_superior'] = substr($this->input->get_post('direct_superior'), 0, 6);
			$param['direct_superior_real'] = ($this->input->get_post('direct_superior'));
		}
		if (!empty($this->input->get_post('user_unit_id'))) {
			$param['user_unit_id'] = $this->input->get_post('user_unit_id');;
		} else {
			$param['user_unit_id'] = $session['user_unit_id'];
		}

		$param['user_nik_sap'] = $this->input->get_post('user_nik_sap');

		foreach ($this->M_user->getUserList($param) as $key => $value) {
			array_push($user['results'], [
				'id' => $value['user_nik_sap'],
				'text' => $value['user_nik_sap'] . ' - ' . $value['user_nama'] . ' - ' . $value['user_post_title'],
				'direct_superior' => $value['user_direct_superior'],
				'unit_id' => $value['user_unit_id'],
			]);
		}
		echo json_encode($user);
	}

	public function getUserDOFList(){
		$user['results'] = array();
		$session = $this->session->userdata();
		$param['param_search'] = $this->input->get('param_search');
		$param['user_detail_id'] = $this->input->get_post('user_detail_id');
		if ($this->input->get_post('direct_superior') != '') {
			$param['direct_superior'] = substr($this->input->get_post('direct_superior'), 0, 6);
			$param['direct_superior_real'] = ($this->input->get_post('direct_superior'));
		}
		if (!empty($this->input->get_post('user_unit_id'))) {
			$param['user_unit_id'] = $this->input->get_post('user_unit_id');;
		} else {
			$param['user_unit_id'] = $session['user_unit_id'];
		}
		$data = $this->M_user->getUserList($param);
		foreach ($data as $key => $value) {
			array_push($user['results'], [
				'id' => $value['user_detail_id'],
				'text' => $value['user_detail_name'],
				'direct_superior' => $value['user_direct_superior'],
				'unit_id' => $value['user_unit_id'],
			]);
		}
		echo json_encode($user);
	}

	public function getUserCCList(){

		$user['results'] = array();

		$session = $this->session->userdata();

		$param['param_search'] = $this->input->get('param_search');
		$data = $this->M_user->getUserCCList($param);
		foreach ($data as $key => $value) {
			array_push($user['results'], [
				'id' => $value['user_detail_id'],
				'text' => $value['user_detail_name'],
			]);
		}
		echo json_encode($user);
	}

	public function getUserList2(){
		$list['results'] = array();

		$param['user_poscode'] = $this->input->get('param1');
		$param['user_nik_sap'] = $this->input->get('user_nik_sap');

		$data_pegawai = $this->M_user->getUserList2($param);
		$data['id'] = $data_pegawai['user_nik_sap'];
		$data['text'] = $data_pegawai['user_nik_sap'] . ' - ' . $data_pegawai['user_nama'] . ' - ' . $data_pegawai['user_post_title'];
		$data['user_poscode'] = $data_pegawai['user_poscode'];

		echo json_encode($data);
	}

	public function getUserList3(){
		$session = $this->session->userdata();
		$list['results'] = array();

		$param['user_poscode'] = $this->input->get('param1');
		$param['user_nik_sap'] = $this->input->get('user_nik_sap');

		$data_pegawai = $this->M_user->getUserList3($param);

		echo json_encode($data_pegawai);
	}

	public function getUserAVPList(){
		$user['results'] = array();

		$session = $this->session->userdata();

		$param['param_search'] = $this->input->get('param_search');

		// $param['user_job_id_array'] = array('31A', '32A', '30A');

		foreach ($this->M_user->getUserList($param) as $key => $value) {
			array_push($user['results'], [
				'id' => $value['user_nik_sap'],
				'text' => $value['user_nik_sap'] . ' - ' . $value['user_nama'] . ' - ' . $value['user_post_title'],
				'direct_superior' => $value['user_direct_superior'],
				'poscode' => $value['user_poscode'],
				'unit_id' => $value['user_unit_id'],
			]);
		}
		echo json_encode($user);
	}

	public function getUserVPAVPList(){
		$user['results'] = array();

		$session = $this->session->userdata();

		$param['param_search'] = $this->input->get('param_search');

		// $param['user_job_id_array'] = array('20F','31A', '32A', '30A');

		foreach ($this->M_user->getUserList($param) as $key => $value) {
			array_push($user['results'], [
				'id' => $value['user_nik_sap'],
				'text' => $value['user_nik_sap'] . ' - ' . $value['user_nama'] . ' - ' . $value['user_post_title'],
				'direct_superior' => $value['user_direct_superior'],
				'poscode' => $value['user_poscode'],
				'unit_id' => $value['user_unit_id'],
			]);
		}
		echo json_encode($user);
	}

	public function getAllUserLabList(){
		$user['results'] = array();
		$session = $this->session->userdata();
		$param['param_search'] = $this->input->get('param_search');
		$param['user_unit_id_array'] = array('E44000');
		$param['user_detail_id'] = $this->input->get_post('user_detail_id');

		$data = $this->M_user->getUserList($param);

		foreach ($data as $key => $value) {
			array_push($user['results'], [
				'id_dof' => $value['user_detail_id'],
				'id' => $value['user_nik_sap'],
				'text' => $value['user_nik_sap'] . ' - ' . $value['user_nama'] . ' - ' . $value['user_post_title'],
				'direct_superior' => $value['user_direct_superior'],
				'poscode' => $value['user_poscode'],
				'unit_id' => $value['user_unit_id'],
			]);
		}
		echo json_encode($user);
	}

	public function getUserLabList(){
		$user['results'] = array();
		$session = $this->session->userdata();
		$param['param_search'] = $this->input->get('param_search');
		$param['user_job_id_array'] = array('20F', '32A', '30A');
		$param['user_unit_id_array'] = array('E44000');
		$param['user_detail_id'] = $this->input->post('user_detail_id');
		foreach ($this->M_user->getUserList($param) as $key => $value) {
			array_push($user['results'], [
				'id' => $value['user_nik_sap'],
				'text' => $value['user_nik_sap'] . ' - ' . $value['user_nama'] . ' - ' . $value['user_post_title'],
				'direct_superior' => $value['user_direct_superior'],
				'poscode' => $value['user_poscode'],
				'unit_id' => $value['user_unit_id'],
			]);
		}
		echo json_encode($user);
	}

	public function getUserDOFAVPLabList(){
		$user['results'] = array();

		$session = $this->session->userdata();

		$param['param_search'] = $this->input->get('param_search');
		$param['user_nik_sap'] = $this->input->get('user_nik_sap');

		$param['user_job_id_array'] = array('32A', '30A');
		$param['user_unit_id_array'] = array('E44000');

		$data = $this->M_user->getUserList($param);

		foreach ($data as $key => $value) {
			array_push($user['results'], [
				'id' => $value['user_detail_id'],
				'text' => $value['user_detail_name'],
				'direct_superior' => $value['user_direct_superior'],
				'poscode' => $value['user_poscode'],
				'unit_id' => $value['user_unit_id'],
			]);
		}
		echo json_encode($user);
	}

	public function getUserAVPLabList1(){
		$list['results'] = array();

		$param['user_poscode'] = $this->input->get('param1');
		$param['user_nik_sap'] = $this->input->get('user_nik_sap');

		$data_pegawai = $this->M_user->getUserList2($param);
		$data['id'] = $data_pegawai['user_nik_sap'];
		$data['text'] = $data_pegawai['user_nik_sap'] . ' - ' . $data_pegawai['user_nama'] . ' - ' . $data_pegawai['user_post_title'];
		$data['user_poscode'] = $data_pegawai['user_poscode'];

		echo json_encode($data);
	}
}

/* End of file User.php */
