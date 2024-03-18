<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Request extends MY_Controller{

	public function __construct(){
		parent::__construct();
		isLogin();
		$this->load->model('api/M_user', 'M_user_api');
		$this->load->model('master/M_user', 'M_user');
		$this->load->model('master/M_sample_peminta_jasa');
		$this->load->model('master/M_sample_jenis');
		$this->load->model('master/M_sample_pekerjaan');
		$this->load->model('sample/M_request');
		$this->load->model('sample/M_nomor');
	}

	public function index(){
		// $this->checkLogin();
		$isi['judul'] = 'Sample & Calibration Request';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');
		// $data['tipe'] = $this->input->get('tipe');

		$this->template->template_master('sample/request_baru',$isi,$data);
	}

	// Add
	public function addRequest(){
		$isi['judul'] = 'Sample & Calibration Request';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

		$jabatan = substr($this->session->userdata('user_job_id'), 0, 1);
		$role = ($this->session->userdata('role_id'));
		if ($role == '1') {
			$data['avp_nik_sap'] = '';
			$data['avp_nama'] = '';
			$data['avp_post_title'] = '';
			$data['vp_nik_sap'] = '';
			$data['vp_nama'] = '';
			$data['vp_post_title'] = '';
		} else if ($jabatan == '2') {
			$data['avp_nik_sap'] = $this->session->userdata('user_nik_sap');
			$data['avp_nama'] = $this->session->userdata('user_nama');
			$data['avp_post_title'] = $this->session->userdata('user_post_title');
			$data['vp_nik_sap'] = $this->session->userdata('user_nik_sap');
			$data['vp_nama'] = $this->session->userdata('user_nama');
			$data['vp_post_title'] = $this->session->userdata('user_post_title');
		} elseif ($jabatan == '3') {
			$data['avp_nik_sap'] = $this->session->userdata('user_nik_sap');
			$data['avp_nama'] = $this->session->userdata('user_nama');
			$data['avp_post_title'] = $this->session->userdata('user_post_title');

			$dataVP = $this->db->query("SELECT user_nik_sap, user_nama, user_post_title FROM global.global_api_user WHERE user_poscode IN (SELECT user_direct_superior FROM global.global_api_user WHERE user_nik_sap = '" . $data['avp_nik_sap'] . "')")->row_array();
			$data['vp_nik_sap'] = $dataVP['user_nik_sap'];
			$data['vp_nama'] = $dataVP['user_nama'];
			$data['vp_post_title'] = $dataVP['user_post_title'];
		} else {
			$dataAVP = $this->db->query("SELECT user_nik_sap, user_nama, user_post_title FROM global.global_api_user WHERE user_poscode IN (SELECT user_direct_superior FROM global.global_api_user WHERE user_nik_sap = '" . $this->session->userdata('user_nik_sap') . "')")->row_array();
			$data['avp_nik_sap'] = $dataAVP['user_nik_sap'];
			$data['avp_nama'] = $dataAVP['user_nama'];
			$data['avp_post_title'] = $dataAVP['user_post_title'];

			$dataVP = $this->db->query("SELECT user_nik_sap, user_nama, user_post_title FROM global.global_api_user WHERE user_poscode IN (SELECT user_direct_superior FROM global.global_api_user WHERE user_nik_sap = '" . $data['avp_nik_sap'] . "')")->row_array();
			$data['vp_nik_sap'] = $dataVP['user_nik_sap'];
			$data['vp_nama'] = $dataVP['user_nama'];
			$data['vp_post_title'] = $dataVP['user_post_title'];
		}

		$this->template->template_master('sample/request_add',$isi,$data);
	}

	// Edit
	public function editRequest(){
		$isi['judul'] = 'Sample & Calibration Request';
		$data = $this->session->userdata();
		$session = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

		$param['transaksi_id'] = $this->input->get_post('transaksi_id');
		$param['transaksi_detail_id'] = $this->input->get_post('transaksi_detail_id');
		$param['transaksi_non_rutin_id'] = $this->input->get_post('non_rutin');
		$param['transaksi_status'] = $this->input->get_post('status');


		$data['sample_jenis'] = $this->M_sample_jenis->getJenisSampleUJi($param);
		$data['pekerjaan_jenis'] = $this->M_sample_pekerjaan->getJenisPekerjaan($param);
		$data['sample_detail'] = $this->M_request->getRequestDetail($param);

		$this->template->template_master('sample/request_edit',$isi,$data);
	}

	// Preview
	public function previewRequest(){
		$isi['judul'] = 'Preview Sample & Calibration Request';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

		$param['transaksi_id'] = $this->input->get_post('transaksi_id');
		$param['transaksi_detail_id'] = $this->input->get_post('transaksi_detail_id');
		$param['transaksi_non_rutin_id'] = $this->input->get_post('non_rutin');
		$param['transaksi_status'] = $this->input->get_post('status');

		$data['sample'] = $this->M_request->getRequestNew($param, $where = null);

		$data['sample_jenis'] = $this->M_sample_jenis->getJenisSampleUJi($param);
		$data['pekerjaan_jenis'] = $this->M_sample_pekerjaan->getJenisPekerjaan($param);
		$data['sample_detail'] = $this->M_request->getRequestDetail($param);

		$this->template->template_master('sample/request_preview',$isi,$data);
	}

	public function cetakPreviewRequest(){
		$session = $this->session->userdata();
		$param['transaksi_non_rutin_id'] = anti_inject($this->input->get_post('non_rutin'));
		$param['transaksi_status'] = anti_inject($this->input->get_post('status'));
		$isi['judul'] = 'Cetak Preview Request';
		$result['sample'] = $this->M_request->getRequestAll($param);
		$result['sample_detail'] = $this->M_request->getRequestDetail($param);
		$this->load->view('tampilan/header_fix', $isi);
		$this->load->view('cetak/cetak_preview_request_baru', $result, FALSE);
	}

	/* GET */
	public function getRequestMain(){
		$isi = $this->session->userdata();

		if ($this->input->get('tgl_cari')) $tgl = explode(' - ', $this->input->get('tgl_cari'));
		if ($this->input->get('tgl_cari')) $param['tgl_awal'] = date('Y-m-d', strtotime($tgl[0]));
		if ($this->input->get('tgl_cari')) $param['tgl_akhir'] = date('Y-m-d', strtotime($tgl[1]));
		if ($this->input->get('isi') != 'ok') if ($isi['role_id'] != '1') $param['seksi_id'] = $isi['user_unit_id'];

		$param['transaksi_id'] = $this->input->get_post('transaksi_id');
		$param['transaksi_non_rutin_id'] = $this->input->get('transaksi_non_rutin_id');
		$param['transaksi_tipe'] = $this->input->get('transaksi_tipe');
		$param['transaksi_status'] = $this->input->get_post('transaksi_status');
		if ($isi['user_id'] != '1') {
			$param['seksi_id'] = $isi['user_unit_id'];
		}
		if (!empty($this->input->get_post('transaksi_status_not_array2'))) {
			$explode_not_status = explode(',', $this->input->get_post('transaksi_status_not_array2'));
			$param['transaksi_status_not_array2'] = $explode_not_status;
		}

		if (!empty($this->input->get_post('array_transaksi_status_in'))) {
			$explode_status_in = explode(',', $this->input->get_post('array_transaksi_status_in'));
			$param['array_transaksi_status_in'] = $explode_status_in;
		}

		if (!empty($this->input->get_post('array_transaksi_status_not_in'))) {
			$explode_status_not_in = explode(',', $this->input->get_post('array_transaksi_status_not_in'));
			$param['array_transaksi_status_not_in'] = $explode_status_in;
		}

		$status_request = explode(',', $this->input->get_post('transaksi_status_request'));
		$param['transaksi_status_request'] = $status_request;
		$param['tahun'] = $this->input->get('tahun');
		$param['tanggal_cari'] = $this->input->get_post('tanggal_cari');
		$param['tanggal_cari_awal'] = $this->input->get_post('tanggal_cari_awal');
		$param['tanggal_cari_akhir'] = $this->input->get_post('tanggal_cari_akhir');

		$where = array();
		if (!empty($param['tanggal_cari'])) {
			$tgl_ini = date($param['tanggal_cari'] . '-d');
			$where['DATE(transaksi_tgl) >= '] = date('Y-m-d', strtotime($tgl_ini));
			$where['DATE(transaksi_tgl) <= '] = date('Y-m-d', strtotime($tgl_ini));
		} else if (!empty($param['tahun_cari'])) {
			$where['DATE(transaksi_tgl) >= '] = $param['tahun_cari'] . '-01-01';
			$where['DATE(transaksi_tgl) <= '] = $param['tahun_cari'] . '-12-31';
		}

		if (!empty($this->input->get_post('transaksi_tipe_cari') && $this->input->get_post('transaksi_tipe_cari') != '-')) {
			$where['transaksi_tipe'] = $this->input->get_post('transaksi_tipe_cari');
		}

		$data = $this->M_request->getRequestMain($param, $where);

		// echo $this->db->last_query();

		echo json_encode($data);
	}

	public function getRequest(){
		$isi = $this->session->userdata();

		if ($this->input->get('tgl_cari')) $tgl = explode(' - ', $this->input->get('tgl_cari'));
		if ($this->input->get('tgl_cari')) $param['tgl_awal'] = date('Y-m-d', strtotime($tgl[0]));
		if ($this->input->get('tgl_cari')) $param['tgl_akhir'] = date('Y-m-d', strtotime($tgl[1]));
		if ($this->input->get('isi') != 'ok') if ($isi['role_id'] != '1') $param['seksi_id'] = $isi['user_unit_id'];

		$param['transaksi_id'] = $this->input->get('transaksi_id');
		$param['transaksi_non_rutin_id'] = $this->input->get('transaksi_non_rutin_id');
		$param['transaksi_tipe'] = $this->input->get('transaksi_tipe');
		$param['transaksi_status'] = $this->input->get_post('transaksi_status');
		// $param['transaksi_status_not_array'] = array('1', '2');
		if (!empty($this->input->get_post('transaksi_status_not_array2'))) {
			$explode_not_status = explode(',', $this->input->get_post('transaksi_status_not_array2'));
			$param['transaksi_status_not_array2'] = $explode_not_status;
		}
		$status_request = explode(',', $this->input->get_post('transaksi_status_request'));
		$param['transaksi_status_request'] = $status_request;
		$param['tahun'] = $this->input->get('tahun');
		$param['tanggal_cari'] = $this->input->get_post('tanggal_cari');
		$param['tanggal_cari_awal'] = $this->input->get_post('tanggal_cari_awal');
		$param['tanggal_cari_akhir'] = $this->input->get_post('tanggal_cari_akhir');

		$where = array();
		if (!empty($param['tanggal_cari'])) {
			$tgl_ini = date($param['tanggal_cari'] . '-d');
			$where['DATE(transaksi_tgl) >= '] = date('Y-m-d', strtotime($tgl_ini));
			$where['DATE(transaksi_tgl) <= '] = date('Y-m-d', strtotime($tgl_ini));
		} else if (!empty($param['tahun_cari'])) {
			$where['DATE(transaksi_tgl) >= '] = $param['tahun_cari'] . '-01-01';
			$where['DATE(transaksi_tgl) <= '] = $param['tahun_cari'] . '-12-31';
		}

		if (!empty($this->input->get_post('transaksi_tipe_cari') && $this->input->get_post('transaksi_tipe_cari') != '-')) {
			$where['transaksi_tipe'] = $this->input->get_post('transaksi_tipe_cari');
		}

		$data = $this->M_request->getRequestAll($param, $where);

		echo json_encode($data);
	}

	public function getRequestDOF(){
		$param['transaksi_id'] = $this->input->get_post('transaksi_id');
		$param['transaksi_detail_id'] = $this->input->get_post('transaksi_detail_id');
		$param['transaksi_detail_group'] = $this->input->get_post('transaksi_detail_group');
		$data = $this->M_request->getRequestDOF($param);

		echo json_encode($data);
	}

	public function getRequestDashboard(){
		$isi = $this->session->userdata();
		// print_r($isi);
		if ($this->input->get('tgl_cari')) $tgl = explode(' - ', $this->input->get('tgl_cari'));
		if ($this->input->get('tgl_cari')) $param['tgl_awal'] = date('Y-m-d', strtotime($tgl[0]));
		if ($this->input->get('tgl_cari')) $param['tgl_akhir'] = date('Y-m-d', strtotime($tgl[1]));
		if (empty($isi)) {
			if ($this->input->get('isi') != 'ok') if ($isi['role_id'] != '1') $param['seksi_id'] = $isi['user_unit_id'];
		}
		$param['transaksi_id'] = $this->input->get('transaksi_id');
		$param['transaksi_non_rutin_id'] = $this->input->get('transaksi_non_rutin_id');
		$param['transaksi_tipe'] = $this->input->get('transaksi_tipe');
		$param['tahun'] = $this->input->get('tahun');
		$param['transaksi_status'] = $this->input->get_post('transaksi_status');
		$param['transaksi_status_request'] = $this->input->get_post('transaksi_status_request');
		$param['tanggal_cari'] = $this->input->get_post('tanggal_cari');
		$param['tanggal_cari_awal'] = $this->input->get_post('tanggal_cari_awal');
		$param['tanggal_cari_akhir'] = $this->input->get_post('tanggal_cari_akhir');

		$where = array();
		if (!empty($param['tanggal_cari'])) {
			$tgl_ini = date($param['tanggal_cari'] . '-d');
			$where['DATE(transaksi_tgl) >= '] = date('Y-m-01', strtotime($tgl_ini));
			$where['DATE(transaksi_tgl) <= '] = date('Y-m-t', strtotime($tgl_ini));
		} else if (!empty($param['tanggal_cari_awal']) && !empty($param['tanggal_cari_akhir'])) {
			$tgl_ini = date($param['tanggal_cari_awal'] . '-d');
			$tgl_akhir = date($param['tanggal_cari_akhir'] . '-d');
			$where['DATE(transaksi_tgl) >= '] = date('Y-m-01', strtotime($tgl_ini));
			$where['DATE(transaksi_tgl) <= '] = date('Y-m-t', strtotime($tgl_akhir));
		} else if (!empty($param['tahun_cari'])) {
			$where['DATE(transaksi_tgl) >= '] = $param['tahun_cari'] . '-01-01';
			$where['DATE(transaksi_tgl) <= '] = $param['tahun_cari'] . '-12-31';
		}

		$data = $this->M_request->getRequest($param, $where);

		echo json_encode($data);
	}

	public function getRequestDetail(){
		$param['transaksi_id'] = $this->input->get_post('transaksi_id');
		$param['transaksi_detail_id'] = $this->input->get_post('transaksi_detail_id');
		$param['transaksi_non_rutin_id'] = $this->input->get_post('transaksi_non_rutin_id');
		$param['transaksi_status'] = $this->input->get_post('transaksi_status');

		$data = $this->M_request->getRequestDetail($param);

		echo json_encode($data);
	}

	public function getRequestHistory(){
		$param['transaksi_id'] = $this->input->get_post('transaksi_id');
		$param['transaksi_detail_id'] = $this->input->get_post('transaksi_detail_id');
		$param['transaksi_non_rutin_id'] = $this->input->get_post('transaksi_non_rutin_id');
		$param['transaksi_status'] = $this->input->get_post('transaksi_status');

		$data = $this->M_request->getRequestHistory($param);

		echo json_encode($data);
	}

	public function getPemintaJasa(){
		$list['results'] = array();

		$param['peminta_jasa_nama'] = $this->input->get('peminta_jasa_nama');
		foreach ($this->M_sample_peminta_jasa->getPemintaJasa($param) as $key => $value) {
			array_push($list['results'], [
				'id' => $value['peminta_jasa_id'],
				'text' => $value['peminta_jasa_nama'],
			]);
		}

		echo json_encode($list);
	}

	public function getJenisSampleUJi(){
		$list['results'] = array();

		$param['jenis_nama'] = $this->input->get('jenis_nama');
		foreach ($this->M_sample_jenis->getJenisSampleUJi($param) as $key => $value) {
			array_push($list['results'], [
				'id' => $value['jenis_id'],
				'text' => $value['jenis_nama'],
				'parameter' => $value['jenis_parameter'],
			]);
		}

		echo json_encode($list);
	}

	public function getJenisPekerjaan(){
		$list['results'] = array();

		$param['sample_pekerjaan_nama'] = $this->input->get('sample_pekerjaan_nama');
		foreach ($this->M_sample_pekerjaan->getJenisPekerjaan($param) as $key => $value) {
			array_push($list['results'], [
				'id' => $value['sample_pekerjaan_id'],
				'text' => $value['sample_pekerjaan_nama'],
			]);
		}

		echo json_encode($list);
	}

	public function getSampleIdentitas(){
		$list['results'] = array();

		$param['identitas_nama'] = $this->input->get('identitas_nama');
		$param['jenis_id'] = $this->input->get('jenis_id');
		foreach ($this->M_sample_jenis->getSampleIdentitas($param) as $key => $value) {
			array_push($list['results'], [
				'id' => $value['identitas_id'],
				'text' => $value['identitas_nama'],
			]);
		}

		echo json_encode($list);
	}

	public function getIdentitas(){
		$param['identitas_nama'] = $this->input->get('search');
		$param['jenis_id'] = $this->input->get('jenis_id');
		$data = $this->M_sample_jenis->getSampleIdentitas($param);
		echo json_encode($data);
	}
	/* GET */

	/* INSERT */

	public function insertDraft(){
		$session = $this->session->userdata();
		$data_user['direct_superior'] = substr($session['user_direct_superior'], 0, 6);
		$user = $this->M_user_api->getUserList($data_user);

		$jumlah_upload_data = count($this->input->get_post('transaksi_detail_id'));

		$upload_path = FCPATH . './document/';
		if (!file_exists($upload_path)) mkdir($upload_path);
		for ($i = 0; $i < $jumlah_upload_data; $i++) {
			$allowed_mime_type_arr = array('application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'text/plain', 'application/pdf', 'image/jpeg', 'image/png', 'image/gif', 'image/bmp');
			$mime = get_mime_by_extension($_FILES['transaksi_detail_attachment']['name'][$i]);
			if (!empty($_FILES['transaksi_detail_attachment']['name'][$i])) {
				if (in_array($mime, $allowed_mime_type_arr)) {
					$tmpName = $_FILES['transaksi_detail_attachment']['tmp_name'][$i];
					$fileName = $_FILES['transaksi_detail_attachment']['name'][$i];
					$fileType = $_FILES['transaksi_detail_attachment']['type'][$i];

					$acak = rand(11111111, 99999999);
					$fileExt = substr($fileName, strpos($fileName, '.'));
					$fileExt = str_replace('.', '', $fileExt); // Extension
					$fileName = preg_replace("/\.[^.\s]{3,4}$/", "", $fileName);
					$newFileName = $fileName . str_replace(' ', '', $acak . '_' . date('ymdhis') . '.' . $fileExt);
					move_uploaded_file($tmpName, $upload_path . $newFileName);
					$new_attachment = $newFileName;
				} else {
					echo 0;
					exit;
				}
			} else {
				$new_attachment =	null;
			}

			$mime = get_mime_by_extension($_FILES['transaksi_detail_file']['name'][$i]);
			if (!empty($_FILES['transaksi_detail_file']['name'][$i])) {
				if (in_array($mime, $allowed_mime_type_arr)) {
					$tmpName = $_FILES['transaksi_detail_file']['tmp_name'][$i];
					$fileName = $_FILES['transaksi_detail_file']['name'][$i];
					$fileType = $_FILES['transaksi_detail_file']['type'][$i];

					$acak = rand(11111111, 99999999);
					$fileExt = substr($fileName, strpos($fileName, '.'));
					$fileExt = str_replace('.', '', $fileExt); // Extension
					$fileName = preg_replace("/\.[^.\s]{3,4}$/", "", $fileName);
					$newFileName = $fileName . str_replace(' ', '', $acak . '_' . date('ymdhis') . '.' . $fileExt);
					move_uploaded_file($tmpName, $upload_path . $newFileName);
					$new_file = $newFileName;
				} else {
					echo 0;
					exit;
				}
			} else {
				$new_file =	null;
			}

			if ($new_file && $new_attachment) {
				echo 1;
			}

			$data[] = array(
				'transaksi_detail_id' => anti_inject($this->input->get_post('transaksi_detail_id')[$i]),
				'transaksi_detail_judul' => ($this->input->get_post('item_judul')[$i]),
				'jenis_id' => anti_inject($this->input->get_post('jenis_id')[$i]),
				'jenis_pekerjaan_id' => anti_inject($this->input->get_post('jenis_pekerjaan_id')[$i]),
				'transaksi_detail_jumlah' => anti_inject($this->input->get_post('transaksi_detail_jumlah')[$i]),
				'identitas_id' => anti_inject($this->input->get_post('identitas_id')[$i]),
				'transaksi_detail_identitas' => anti_inject($this->input->get_post('transaksi_detail_identitas')[$i]),
				'transaksi_detail_parameter' => anti_inject($this->input->get_post('transaksi_detail_parameter')[$i]),
				'transaksi_detail_deskripsi_parameter' => anti_inject($this->input->get_post('transaksi_detail_deskripsi_parameter')[$i]),
				'transaksi_detail_catatan' => anti_inject($this->input->get_post('transaksi_detail_catatan')[$i]),
				'transaksi_detail_attach' => $new_attachment,
				'transaksi_detail_file' => $new_file,
				'transaksi_id' => anti_inject($this->input->get_post('transaksi_id')),
				'id_non_rutin' => anti_inject($this->input->get_post('transaksi_non_rutin_id')),
				'peminta_jasa_id' => anti_inject($this->input->get_post('peminta_jasa_id')),
				'transaksi_detail_tgl_pengajuan' => date('Y-m-d H:i:s'),
				'transaksi_detail_klasifikasi_id' => anti_inject($this->input->get_post('transaksi_klasifikasi_id')),
				'transaksi_detail_id_template_keterangan' => anti_inject($this->input->get_post('template_id')),
				'transaksi_detail_status' => '0',
				'when_create' => date('Y-m-d H:i:s'),
				'who_create' => $session['user_nama_lengkap'],
				'who_seksi_create' => $session['user_unit_id'],
			);
		}
		$this->db->insert_batch('sample.sample_transaksi_detail', $data);

		$data_non_rutin['transaksi_non_rutin_id'] = anti_inject($this->input->get_post('transaksi_non_rutin_id'));
		$data_non_rutin['transaksi_non_rutin_tgl'] = date('Y-m-d H:i:s');
		$data_non_rutin['who_create'] = htmlentities($session['user_nama_lengkap']);
		$data_non_rutin['when_create'] = date('Y-m-d H:i:s');
		$data_non_rutin['who_seksi_create'] = htmlentities($session['user_unit_id']);
		$this->M_request->insertNonRutin($data_non_rutin);

		/* Insert Transaksi */
		$data_transaksi['transaksi_id'] = anti_inject($this->input->get_post('transaksi_id'));
		$data_transaksi['id_transaksi_non_rutin'] = $data_non_rutin['transaksi_non_rutin_id'];
		$data_transaksi['transaksi_tipe'] = (anti_inject($this->input->get_post('transaksi_approver_poscode')) == 'E35000000') ? 'E' : 'I';
		$data_transaksi['transaksi_judul'] = ($this->input->get_post('transaksi_judul'));
		$data_transaksi['transaksi_id_peminta_jasa'] = anti_inject($this->input->get_post('peminta_jasa_id'));
		$data_transaksi['transaksi_nomor'] = '';
		$data_transaksi['transaksi_id_template_keterangan'] = anti_inject($this->input->get_post('template_id'));
		$data_transaksi['transaksi_klasifikasi_id'] = anti_inject($this->input->get_post('transaksi_klasifikasi_id'));
		$data_transaksi['transaksi_sifat'] = anti_inject($this->input->get_post('transaksi_sifat'));
		$data_transaksi['transaksi_kecepatan_tanggap'] = anti_inject($this->input->get_post('transaksi_kecepatan_tanggap'));
		$data_transaksi['transaksi_reviewer'] = anti_inject($this->input->get_post('transaksi_reviewer'));
		$data_transaksi['transaksi_approver'] = anti_inject($this->input->get_post('transaksi_approver'));
		$data_transaksi['transaksi_drafter'] = anti_inject($this->input->get_post('transaksi_drafter'));
		$data_transaksi['transaksi_tujuan'] = anti_inject($this->input->get_post('transaksi_tujuan'));
		$data_transaksi['who_seksi_create'] = $session['user_unit_id'];
		$data_transaksi['transaksi_status'] = '0';
		$data_transaksi['transaksi_pic_pengirim_id'] = anti_inject($this->input->get_post('transaksi_pic_pengirim_id'));
		$data_transaksi['transaksi_pic_pengirim'] = anti_inject($this->input->get_post('transaksi_detail_pic_pengirim'));
		$data_transaksi['transaksi_pic_ext'] = anti_inject($this->input->get_post('transaksi_detail_ext_pengirim'));
		$data_transaksi['transaksi_pic_telepon'] = anti_inject($this->input->get_post('transaksi_detail_pic_telepon'));
		$data_transaksi['transaksi_reviewer_poscode'] = anti_inject($this->input->get_post('transaksi_reviewer_poscode'));
		$data_transaksi['transaksi_approver_poscode'] = anti_inject($this->input->get_post('transaksi_approver_poscode'));
		$data_transaksi['transaksi_drafter_poscode'] = anti_inject($this->input->get_post('transaksi_drafter_poscode'));
		$data_transaksi['transaksi_tujuan_poscode'] = anti_inject($this->input->get_post('transaksi_tujuan_poscode'));
		$data_transaksi['transaksi_pic_poscode'] = anti_inject($this->input->get_post('transaksi_pic_pengirim_poscode'));
		$data_transaksi['transaksi_tgl'] = date('Y-m-d H:i:s');
		$data_transaksi['who_create'] = $session['user_nama'];
		$data_transaksi['when_create'] = date('Y-m-d H:i:s');

		$this->M_request->insertRequest($data_transaksi);
		/* Insert Transaksi */

		sampleLog($data_transaksi['transaksi_id'], null, $data_transaksi['id_transaksi_non_rutin'], $data_transaksi['transaksi_tipe'], $data_transaksi['transaksi_status'], 'Pekerjaan Telah DiDraft Oleh PIC ');
	}


	public function insertAjukan(){
		$session = $this->session->userdata();
		$data_user['direct_superior'] = substr($session['user_direct_superior'], 0, 6);
		$user = $this->M_user_api->getUserList($data_user);

		/* Nomor Surat */
		$nomor = $this->M_nomor->getNomorMax();
		$isi_nomor = ($nomor['isi'] != null) ? ($nomor['isi'] + 1) : 1;
		$sekretariat = $this->input->get_post('transaksi_klasifikasi_id');
		$kode_sekretariat = $this->db->get_where('sample.sample_klasifikasi', array('klasifikasi_id' => $sekretariat))->row_array();
		$dept = '39.4';
		$digi = 'DIGILABS';
		$tahun = date('Y');
		$dep = ($this->input->get_post('transaksi_approver_poscode') == 'E35000000') ? 'EXT' : 'INT';

		$newNomor = sprintf("%05d", $isi_nomor) . '/' . $kode_sekretariat['klasifikasi_kode'] . '/' . $dep . '/' . $digi . '/' . $tahun;
		/* Nomor Surat */

		$jumlah_upload_data = count($this->input->get_post('transaksi_detail_id'));

		if ($this->input->post('transaksi_reviewer') == $this->input->post('transaksi_approver')) $status = '3';
		elseif ($this->input->post('transaksi_drafter') == $this->input->post('transaksi_reviewer')) $status = '2';
		else $status = '1';

		$upload_path = FCPATH . './document/';
		if (!file_exists($upload_path)) mkdir($upload_path);
		// $config['upload_path'] = FCPATH . './document/';
		// $config['allowed_types'] = 'application/pdf|.doc|.docx|.xls|.xlsx|.ppt|.pptx|image/jpeg|image/png|image/gif|image/bmp';
		for ($i = 0; $i < $jumlah_upload_data; $i++) {
			$allowed_mime_type_arr = array('application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'text/plain', 'application/pdf', 'image/jpeg', 'image/png', 'image/gif', 'image/bmp');
			$mime = get_mime_by_extension($_FILES['transaksi_detail_attachment']['name'][$i]);
			if (!empty($_FILES['transaksi_detail_attachment']['name'][$i])) {
				if (in_array($mime, $allowed_mime_type_arr)) {
					$tmpName = $_FILES['transaksi_detail_attachment']['tmp_name'][$i];
					$fileName = $_FILES['transaksi_detail_attachment']['name'][$i];
					$fileType = $_FILES['transaksi_detail_attachment']['type'][$i];

					$random = uniqid();
					$fileExt       = substr($fileName, strrpos($fileName, '.'));
					$fileExt       = str_replace('.', '', $fileExt); /* Extension*/
					$fileName      = preg_replace("/\.[^.\s]{3,4}$/", "", $fileName);
					$newFileName = str_replace(' ', '', $this->input->post('transaksi_id') . '_' . date('ymdhis') . '_' . $random . '.' . $fileExt);

					move_uploaded_file($tmpName, $upload_path . $newFileName);
					$new_attachment = $newFileName;
				} else {
					echo 0;
					exit;
				}
			} else {
				$new_attachment =	null;
			}
			$mime = get_mime_by_extension($_FILES['transaksi_detail_file']['name'][$i]);
			if (!empty($_FILES['transaksi_detail_file']['name'][$i])) {
				if (in_array($mime, $allowed_mime_type_arr)) {
					$tmpName1 = $_FILES['transaksi_detail_file']['tmp_name'][$i];
					$fileName1 = $_FILES['transaksi_detail_file']['name'][$i];
					$fileType1 = $_FILES['transaksi_detail_file']['type'][$i];

					$random1 = uniqid();
					$fileExt1       = substr($fileName1, strrpos($fileName1, '.'));
					$fileExt1       = str_replace('.', '', $fileExt1); /* Extension*/
					$fileName1      = preg_replace("/\.[^.\s]{3,4}$/", "", $fileName1);
					$newFileName1 = str_replace(' ', '', $this->input->post('transaksi_id') . '_' . date('ymdhis') . '_' . $random1 . '.' . $fileExt1);

					move_uploaded_file($tmpName1, $upload_path . $newFileName1);
					$new_file = $newFileName1;
				} else {
					echo 0;
					exit;
				}
			} else {
				$new_file =	null;
			}

			if ($new_file || $new_attachment) {
				echo 1;
			}

			$data[] = array(
				'transaksi_detail_id' => ($this->input->get_post('transaksi_detail_id')[$i]),
				'transaksi_detail_judul' => ($this->input->get_post('item_judul')[$i]),
				'jenis_id' => ($this->input->get_post('jenis_id')[$i]),
				'jenis_pekerjaan_id' => ($this->input->get_post('jenis_pekerjaan_id')[$i]),
				'transaksi_detail_jumlah' => ($this->input->get_post('transaksi_detail_jumlah')[$i]),
				'identitas_id' => ($this->input->get_post('identitas_id')[$i]),
				'transaksi_detail_identitas' => ($this->input->get_post('transaksi_detail_identitas')[$i]),
				'transaksi_detail_parameter' => ($this->input->get_post('transaksi_detail_parameter')[$i]),
				'transaksi_detail_deskripsi_parameter' => ($this->input->get_post('transaksi_detail_deskripsi_parameter')[$i]),
				'transaksi_detail_catatan' => ($this->input->get_post('transaksi_detail_catatan')[$i]),
				'transaksi_detail_attach' => $new_attachment,
				'transaksi_detail_file' => $new_file,
				'transaksi_id' => ($this->input->get_post('transaksi_id')),
				'id_non_rutin' => ($this->input->get_post('transaksi_non_rutin_id')),
				'peminta_jasa_id' => ($this->input->get_post('peminta_jasa_id')),
				'transaksi_detail_tgl_pengajuan' => date('Y-m-d H:i:s'),
				'transaksi_detail_klasifikasi_id' => ($this->input->get_post('transaksi_klasifikasi_id')),
				'transaksi_detail_id_template_keterangan' => ($this->input->get_post('template_id')),
				'transaksi_detail_status' => $status,
				'when_create' => date('Y-m-d H:i:s'),
				'who_create' => $session['user_nama_lengkap'],
				'who_seksi_create' => $session['user_unit_id'],
			);
		}
		$this->db->insert_batch('sample.sample_transaksi_detail', $data);

		$data_non_rutin['transaksi_non_rutin_id'] = ($this->input->get_post('transaksi_non_rutin_id'));
		$data_non_rutin['transaksi_non_rutin_tgl'] = date('Y-m-d H:i:s');
		$data_non_rutin['who_create'] = ($session['user_nama_lengkap']);
		$data_non_rutin['when_create'] = date('Y-m-d H:i:s');
		$data_non_rutin['who_seksi_create'] = ($session['user_unit_id']);
		$this->M_request->insertNonRutin($data_non_rutin);

		/* Insert Transaksi */
		$data_transaksi['transaksi_id'] = ($this->input->get_post('transaksi_id'));
		$data_transaksi['id_transaksi_non_rutin'] = $data_non_rutin['transaksi_non_rutin_id'];
		$data_transaksi['transaksi_tipe'] = (($this->input->get_post('transaksi_approver_poscode')) == 'E35000000') ? 'E' : 'I';
		$data_transaksi['transaksi_judul'] = ($this->input->get_post('transaksi_judul'));
		$data_transaksi['transaksi_id_peminta_jasa'] = ($this->input->get_post('peminta_jasa_id'));
		$data_transaksi['transaksi_id_template_keterangan'] = ($this->input->get_post('template_id'));
		$data_transaksi['transaksi_klasifikasi_id'] = ($this->input->get_post('transaksi_klasifikasi_id'));
		$data_transaksi['transaksi_sifat'] = ($this->input->get_post('transaksi_sifat'));
		$data_transaksi['transaksi_kecepatan_tanggap'] = ($this->input->get_post('transaksi_kecepatan_tanggap'));
		$data_transaksi['transaksi_reviewer'] = ($this->input->get_post('transaksi_reviewer'));
		$data_transaksi['transaksi_approver'] = ($this->input->get_post('transaksi_approver'));
		$data_transaksi['transaksi_drafter'] = ($this->input->get_post('transaksi_drafter'));
		$data_transaksi['transaksi_tujuan'] = ($this->input->get_post('transaksi_tujuan'));
		$data_transaksi['who_seksi_create'] = $session['user_unit_id'];
		$data_transaksi['transaksi_status'] = $status;
		$data_transaksi['transaksi_pic_pengirim_id'] = ($this->input->get_post('transaksi_pic_pengirim_id'));
		$data_transaksi['transaksi_pic_pengirim'] = ($this->input->get_post('transaksi_detail_pic_pengirim'));
		$data_transaksi['transaksi_pic_ext'] = ($this->input->get_post('transaksi_detail_ext_pengirim'));
		$data_transaksi['transaksi_pic_telepon'] = ($this->input->get_post('transaksi_detail_pic_telepon'));
		$data_transaksi['transaksi_reviewer_poscode'] = ($this->input->get_post('transaksi_reviewer_poscode'));
		$data_transaksi['transaksi_approver_poscode'] = ($this->input->get_post('transaksi_approver_poscode'));
		$data_transaksi['transaksi_drafter_poscode'] = ($this->input->get_post('transaksi_drafter_poscode'));
		$data_transaksi['transaksi_tujuan_poscode'] = ($this->input->get_post('transaksi_tujuan_poscode'));
		$data_transaksi['transaksi_pic_poscode'] = ($this->input->get_post('transaksi_pic_pengirim_poscode'));
		$data_transaksi['transaksi_tgl'] = date('Y-m-d H:i:s');
		$data_transaksi['who_create'] = $session['user_nama'];
		$data_transaksi['when_create'] = date('Y-m-d H:i:s');
		if ($status == '3') {
			$data_transaksi['transaksi_urut'] = $isi_nomor;
			$data_transaksi['transaksi_nomor'] = $newNomor;
		}
		$data_transaksi['transaksi_agreement_keterangan'] = ($this->input->get_post('transaksi_agreement_keterangan'));

		$this->M_request->insertRequest($data_transaksi);
		/* Insert Transaksi */

		sampleLog($data_transaksi['transaksi_id'], null, $data_transaksi['id_transaksi_non_rutin'], $data_transaksi['transaksi_tipe'], $data_transaksi['transaksi_status'], 'Pekerjaan Telah Diajukan Oleh PIC ');
	}

	public function insertProces(){
		$session = $this->session->userdata();
		$data_user['direct_superior'] = substr($session['user_direct_superior'], 0, 6);
		$user = $this->M_user_api->getUserList($data_user);

		$nomor = $this->M_nomor->getNomorMax();
		$sekretariat = $this->input->get_post('transaksi_klasifikasi_id');
		$kode_sekretariat = $this->db->get_where('sample.sample_klasifikasi', array('klasifikasi_id' => $sekretariat))->row_array();
		$dept = '39.4';
		$digi = 'DIGILABS';
		$tahun = date('Y');

		$newNomor = sprintf("%05d", ($nomor['isi'] + 1)) . '/' . $kode_sekretariat['klasifikasi_kode'] . '/'  . $digi . '/' . $tahun;

		$jumlah_upload_data = count($this->input->get_post('transaksi_detail_id'));

		$upload_path = FCPATH . './document/';
		if (!file_exists($upload_path)) mkdir($upload_path);
		// $config['upload_path'] = FCPATH . './document/';
		// $config['allowed_types'] = 'application/pdf|.doc|.docx|.xls|.xlsx|.ppt|.pptx|image/jpeg|image/png|image/gif|image/bmp';
		for ($i = 0; $i < $jumlah_upload_data; $i++) {
			$allowed_mime_type_arr = array('application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'text/plain', 'application/pdf', 'image/jpeg', 'image/png', 'image/gif', 'image/bmp');
			$mime = get_mime_by_extension($_FILES['transaksi_detail_attachment']['name'][$i]);
			if (!empty($_FILES['transaksi_detail_attachment']['name'][$i])) {
				if (in_array($mime, $allowed_mime_type_arr)) {
					$tmpName = $_FILES['transaksi_detail_attachment']['tmp_name'][$i];
					$fileName = $_FILES['transaksi_detail_attachment']['name'][$i];
					$fileType = $_FILES['transaksi_detail_attachment']['type'][$i];

					$acak = rand(11111111, 99999999);
					$fileExt = substr($fileName, strpos($fileName, '.'));
					$fileExt = str_replace('.', '', $fileExt); // Extension
					$fileName = preg_replace("/\.[^.\s]{3,4}$/", "", $fileName);
					$newFileName = $fileName . str_replace(' ', '', $acak . '_' . date('ymdhis') . '.' . $fileExt);
					move_uploaded_file($tmpName, $upload_path . $newFileName);
					$new_attachment = $newFileName;
				} else {
					echo 0;
					exit;
				}
			} else {
				$new_attachment =	null;
			}
			$mime = get_mime_by_extension($_FILES['transaksi_detail_file']['name'][$i]);
			if (!empty($_FILES['transaksi_detail_file']['name'][$i])) {
				if (in_array($mime, $allowed_mime_type_arr)) {
					$tmpName = $_FILES['transaksi_detail_file']['tmp_name'][$i];
					$fileName = $_FILES['transaksi_detail_file']['name'][$i];
					$fileType = $_FILES['transaksi_detail_file']['type'][$i];

					$acak = rand(11111111, 99999999);
					$fileExt = substr($fileName, strpos($fileName, '.'));
					$fileExt = str_replace('.', '', $fileExt); // Extension
					$fileName = preg_replace("/\.[^.\s]{3,4}$/", "", $fileName);
					$newFileName = $fileName . str_replace(' ', '', $acak . '_' . date('ymdhis') . '.' . $fileExt);
					move_uploaded_file($tmpName, $upload_path . $newFileName);
					$new_file = $newFileName;
				} else {
					echo 0;
					exit;
				}
			} else {
				$new_file =	null;
			}

			if ($new_file && $new_attachment) {
				echo 1;
			}

			$transaksi_detail_id = $this->input->get_post('transaksi_detail_id');
			$transaksi_detail_judul = $this->input->get_post('item_judul');
			$jenis_id = $this->input->get_post('jenis_id');
			$jenis_pekerjaan_id = $this->input->get_post('jenis_pekerjaan_id');
			$transaksi_detail_jumlah = $this->input->get_post('transaksi_detail_jumlah');
			$transaksi_detail_identitas = $this->input->get_post('transaksi_detail_identitas');
			$transaksi_detail_parameter = $this->input->get_post('transaksi_detail_parameter');
			$transaksi_detail_deskripsi_parameter = $this->input->get_post('transaksi_detail_deskripsi_parameter');
			$transaksi_detail_catatan = $this->input->get_post('transaksi_detail_catatan');
			$transaksi_detail_attac = $new_attachment;
			$transaksi_detail_file = $new_file;
			$transaksi_id = $this->input->get_post('transaksi_id');
			$id_non_rutin = $this->input->get_post('transaksi_non_rutin_id');

			if ($this->input->get_post('transaksi_status') == '2') {
				$id_user_disposisi = '2105099';
			} else if ($this->input->get_post('transaksi_status') == '3') {
				$id_user_disposisi = '2105087';
			} else if ($this->input->get_post('transaksi_status') == '4' && $this->input->get_post('transaksi_tipe') == 'E') {
				$id_user_disposisi = $this->input->get_post('transaksi_pic_pengirim_id');
			} else {
				$id_user_disposisi = $user[0]['user_nik_sap'];
			}


			if ($this->input->get_post('transaksi_status') == '2') {
				$id_seksi_disposisi = 'E44000';
			} else if ($this->input->get_post('transaksi_status') == '3') {
				$id_seksi_disposisi = 'E44000';
			} else if ($this->input->get_post('transaksi_status') == '4' && $this->input->get_post('transaksi_tipe') == 'E') {
				// $id_seksi_disposisi = $this->input->get_post('transaksi_pic_pengirim_id');
				$sql_pic_seksi = $this->db->query("SELECT user_unit_id FROM global.global_api_user where user_nik_sap = '" . $user[0]['user_unit_id'] . "'")->row_array();
				$id_seksi_disposisi = $sql_pic_seksi['user_unit_id'];
			} else {
				$id_seksi_disposisi = $user[0]['user_unit_id'];
			}


			$peminta_jasa = $this->input->post('peminta_jasa_id');
			$transaksi_detail_pic_pengirim = $this->input->post('transaksi_detail_pic_pengirim');
			$transaksi_detail_pic_telepon = $this->input->post('transaksi_detail_pic_telepon');
			$transaksi_detail_ext_pengirim = $this->input->post('transaksi_detail_ext_pengirim');
			$transaksi_detail_tgl_pengajuan = date('Y-m-d H:i:s');
			$transaksi_detail_tgl_memo = date('Y-m-d H:i:s', strtotime($this->input->post('transaksi_detail_tgl_memo')));
			$transaksi_detail_no_memo = $this->input->post('transaksi_detail_no_memo');
			$transaksi_detail_klasifikasi_id = htmlentities($this->input->get_post('transaksi_klasifikasi_id'));
			$transaksi_detail_id_template_keterangan = anti_inject($this->input->get_post('template_id'));
			if ($this->input->get_post('transaksi_status') == '4' && $this->input->get_post('transaksi_tipe') != 'E') {
				$transaksi_detail_status = $this->input->get_post('transaksi_status') + 2;
			} else {
				$transaksi_detail_status = $this->input->get_post('transaksi_status') + 1;
			}
			$when_create = date('Y-m-d H:i:s');
			$who_create = $session['user_nama_lengkap'];
			$who_seksi_create = $session['user_unit_id'];


			$data = array();

			foreach ($transaksi_detail_id as $key => $detail_id) {
				$data[] = array(
					'transaksi_detail_id' => $detail_id,
					'transaksi_detail_judul' => $transaksi_detail_judul[$key],
					'jenis_id' => $jenis_id[$key],
					'jenis_pekerjaan_id' => $jenis_pekerjaan_id[$key],
					'transaksi_detail_jumlah' => $transaksi_detail_jumlah[$key],
					'transaksi_detail_identitas' => $transaksi_detail_identitas[$key],
					'transaksi_detail_parameter' => $transaksi_detail_parameter[$key],
					'transaksi_detail_deskripsi_parameter' => $transaksi_detail_deskripsi_parameter[$key],
					'transaksi_detail_catatan' => $transaksi_detail_catatan[$key],
					'transaksi_detail_attach' => $new_attachment,
					'transaksi_detail_file' => $new_file,
					'transaksi_id' => $transaksi_id,
					'id_non_rutin' => $id_non_rutin,
					'id_user_disposisi' => $id_user_disposisi,
					'id_seksi_disposisi' => $id_seksi_disposisi,
					'peminta_jasa_id' => $peminta_jasa,
					'transaksi_detail_pic_pengirim' => $transaksi_detail_pic_pengirim,
					'transaksi_detail_pic_telepon' => $transaksi_detail_pic_telepon,
					'transaksi_detail_ext_pengirim' => $transaksi_detail_ext_pengirim,
					'transaksi_detail_tgl_pengajuan' => $transaksi_detail_tgl_pengajuan,
					'transaksi_detail_tgl_memo' => $transaksi_detail_tgl_memo,
					'transaksi_detail_no_memo' => $transaksi_detail_no_memo,
					'transaksi_detail_klasifikasi_id' => $transaksi_detail_klasifikasi_id,
					'transaksi_detail_id_template_keterangan' => $transaksi_detail_id_template_keterangan,
					'transaksi_detail_status' => $transaksi_detail_status,
					'when_create' => $when_create,
					'who_create' => $who_create,
					'who_seksi_create' => $who_seksi_create,
				);
			}
		}
		$this->db->insert_batch('sample.sample_transaksi_detail', $data);
		// insert non rutin
		$data_non_rutin['transaksi_non_rutin_id'] = $this->input->get_post('transaksi_non_rutin_id');
		$data_non_rutin['transaksi_non_rutin_tgl'] = date('Y-m-d H:i:s');
		$data_non_rutin['who_create'] = htmlentities($session['user_nama_lengkap']);
		$data_non_rutin['when_create'] = date('Y-m-d H:i:s');
		$data_non_rutin['who_seksi_create'] = htmlentities($session['user_unit_id']);

		// $this->M_request->insertNonRutin($data_non_rutin);
		// insert transaksi

		$sql = $this->db->query("SELECT * FROM sample.sample_transaksi_detail WHERE id_non_rutin = '" . $id_non_rutin
			. "'");

		foreach ($sql->result_array() as $key => $value) {
			/* Insert Request */
			// is_new:
			// $id_transaksi = $transaksi_id;
			$id_non_rutin = $data_non_rutin['transaksi_non_rutin_id'];
			$data_transaksi['transaksi_id'] = $transaksi_id;
			$data_transaksi['id_transaksi_detail'] = $value['transaksi_detail_id'];
			$data_transaksi['transaksi_tipe'] = anti_inject($this->input->get_post('transaksi_tipe'));
			$data_transaksi['transaksi_judul'] = ($this->input->get_post('transaksi_judul'));
			$data_transaksi['transaksi_id_peminta_jasa'] = anti_inject($this->input->get_post('peminta_jasa_id'));
			$data_transaksi['transaksi_urut'] = $nomor['isi'] + 1;
			$data_transaksi['transaksi_nomor'] = $newNomor;
			$data_transaksi['transaksi_id_template_keterangan'] = anti_inject($this->input->get_post('template_id'));
			$data_transaksi['transaksi_klasifikasi_id'] = anti_inject($this->input->get_post('transaksi_klasifikasi_id'));
			$data_transaksi['transaksi_sifat'] = anti_inject($this->input->get_post('transaksi_sifat'));
			$data_transaksi['transaksi_kecepatan_tanggap'] = anti_inject($this->input->get_post('transaksi_kecepatan_tanggap'));
			$data_transaksi['transaksi_reviewer'] = anti_inject($this->input->get_post('transaksi_reviewer'));
			$data_transaksi['transaksi_approver'] = anti_inject($this->input->get_post('transaksi_approver'));
			$data_transaksi['transaksi_drafter'] = anti_inject($this->input->get_post('transaksi_drafter'));
			$data_transaksi['transaksi_tujuan'] = anti_inject($this->input->get_post('transaksi_tujuan'));
			$data_transaksi['who_seksi_create'] = $session['user_unit_id'];
			if ($this->input->get_post('transaksi_status') == '4' && $this->input->get_post('transaksi_tipe') != 'E') {
				$data_transaksi['transaksi_status'] = $this->input->get_post('transaksi_status') + 2;
			} else {
				$data_transaksi['transaksi_status'] = $this->input->get_post('transaksi_status') + 1;
			}
			if ($this->input->get_post('transaksi_status') == '2') {
				$data_transaksi['transaksi_id_user'] = '2105099';
			} else if ($this->input->get_post('transaksi_status') == '3') {
				$data_transaksi['transaksi_id_user'] = '2105087';
			} else {
				$data_transaksi['transaksi_id_user'] = $user[0]['user_nik_sap'];
			}
			// $data_transaksi['transaksi_id_user'] =  ($this->input->get_post('transaksi_status')=='2') ? '2105099' : $user[0]['user_nik_sap'];
			$data_transaksi['transaksi_pic_pengirim_id'] = $this->input->get_post('transaksi_pic_pengirim_id');
			$data_transaksi['transaksi_pic_pengirim'] = $this->input->get_post('transaksi_detail_pic_pengirim');
			$data_transaksi['transaksi_pic_ext'] = $this->input->get_post('transaksi_detail_ext_pengirim');
			$data_transaksi['transaksi_pic_telepon'] = $this->input->get_post('transaksi_detail_pic_telepon');

			// $data_transaksi['transaksi_id_user'] =
		}
		$this->M_request->updateRequestNon($data_transaksi, $id_non_rutin);
	}

	public function updateDraft(){
		$session = $this->session->userdata();
		$data_user['direct_superior'] = substr($session['user_direct_superior'], 0, 6);
		$user = $this->M_user_api->getUserList($data_user);

		/* DELETE */
		$delete_sample = $this->db->delete('sample.sample_transaksi', array('id_transaksi_non_rutin' => $this->input->get_post('transaksi_non_rutin_id')));
		$delete_detail = $this->db->delete('sample.sample_transaksi_detail', array('id_non_rutin' => $this->input->get_post('transaksi_non_rutin_id'), 'transaksi_detail_status' => $this->input->get_post('transaksi_status')));
		$delete_non_rutin = $this->db->delete('sample.sample_transaksi_non_rutin', array('transaksi_non_rutin_id' => $this->input->get_post('transaksi_non_rutin_id')));
		/* DELETE */

		if ($delete_detail == TRUE && $delete_sample == TRUE && $delete_non_rutin == TRUE) {

			$jumlah_upload_data = count($this->input->get_post('transaksi_detail_id'));

			$upload_path = FCPATH . './document/';
			if (!file_exists($upload_path)) mkdir($upload_path);
			for ($i = 0; $i < $jumlah_upload_data; $i++) {
				$allowed_mime_type_arr = array('application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'text/plain', 'application/pdf', 'image/jpeg', 'image/png', 'image/gif', 'image/bmp');
				$mime = get_mime_by_extension($_FILES['transaksi_detail_attachment']['name'][$i]);
				if (!empty($_FILES['transaksi_detail_attachment']['name'][$i])) {
					if (in_array($mime, $allowed_mime_type_arr)) {
						$tmpName = $_FILES['transaksi_detail_attachment']['tmp_name'][$i];
						$fileName = $_FILES['transaksi_detail_attachment']['name'][$i];
						$fileType = $_FILES['transaksi_detail_attachment']['type'][$i];

						$acak = rand(11111111, 99999999);
						$fileExt = substr($fileName, strpos($fileName, '.'));
						$fileExt = str_replace('.', '', $fileExt); // Extension
						$fileName = preg_replace("/\.[^.\s]{3,4}$/", "", $fileName);
						$newFileName = $fileName . str_replace(' ', '', $acak . '_' . date('ymdhis') . '.' . $fileExt);
						move_uploaded_file($tmpName, $upload_path . $newFileName);
						$new_attachment = $newFileName;
					} else {
						echo 0;
						exit;
					}
				} else {
					$new_attachment =	$this->input->get_post('transaksi_detail_attachment_lama')[$i];
				}
				$mime = get_mime_by_extension($_FILES['transaksi_detail_file']['name'][$i]);
				if (!empty($_FILES['transaksi_detail_file']['name'][$i])) {
					if (in_array($mime, $allowed_mime_type_arr)) {
						$tmpName = $_FILES['transaksi_detail_file']['tmp_name'][$i];
						$fileName = $_FILES['transaksi_detail_file']['name'][$i];
						$fileType = $_FILES['transaksi_detail_file']['type'][$i];

						$acak = rand(11111111, 99999999);
						$fileExt = substr($fileName, strpos($fileName, '.'));
						$fileExt = str_replace('.', '', $fileExt); // Extension
						$fileName = preg_replace("/\.[^.\s]{3,4}$/", "", $fileName);
						$newFileName = $fileName . str_replace(' ', '', $acak . '_' . date('ymdhis') . '.' . $fileExt);
						move_uploaded_file($tmpName, $upload_path . $newFileName);
						$new_file = $newFileName;
					} else {
						echo 0;
						exit;
					}
				} else {
					$new_file =	$this->input->get_post('transaksi_detail_file_lama')[$i];
				}

				if ($new_file && $new_attachment) {
					echo 1;
				}

				$data[] = array(
					'transaksi_detail_id' => anti_inject($this->input->get_post('transaksi_detail_id')[$i]),
					'transaksi_detail_judul' => ($this->input->get_post('item_judul')[$i]),
					'jenis_id' => anti_inject($this->input->get_post('jenis_id')[$i]),
					'jenis_pekerjaan_id' => anti_inject($this->input->get_post('jenis_pekerjaan_id')[$i]),
					'transaksi_detail_jumlah' => anti_inject($this->input->get_post('transaksi_detail_jumlah')[$i]),
					'identitas_id' => anti_inject($this->input->get_post('identitas_id')[$i]),
					'transaksi_detail_identitas' => anti_inject($this->input->get_post('transaksi_detail_identitas')[$i]),
					'transaksi_detail_parameter' => anti_inject($this->input->get_post('transaksi_detail_parameter')[$i]),
					'transaksi_detail_deskripsi_parameter' => anti_inject($this->input->get_post('transaksi_detail_deskripsi_parameter')[$i]),
					'transaksi_detail_catatan' => anti_inject($this->input->get_post('transaksi_detail_catatan')[$i]),
					'transaksi_detail_attach' => $new_attachment,
					'transaksi_detail_file' => $new_file,
					'transaksi_id' => anti_inject($this->input->get_post('transaksi_id')),
					'id_non_rutin' => anti_inject($this->input->get_post('transaksi_non_rutin_id')),
					'peminta_jasa_id' => $this->input->post('peminta_jasa_id'),
					'transaksi_detail_tgl_pengajuan' => date('Y-m-d H:i:s'),
					'transaksi_detail_klasifikasi_id' => anti_inject($this->input->get_post('transaksi_klasifikasi_id')),
					'transaksi_detail_id_template_keterangan' => anti_inject($this->input->get_post('template_id')),
					'transaksi_detail_status' => anti_inject($this->input->get_post('transaksi_status')),
					'when_create' => date('Y-m-d H:i:s'),
					'who_create' => $session['user_nama_lengkap'],
					'who_seksi_create' => $session['user_unit_id'],
				);
			}
			$this->db->insert_batch('sample.sample_transaksi_detail', $data);

			$data_non_rutin['transaksi_non_rutin_id'] = anti_inject($this->input->get_post('transaksi_non_rutin_id'));
			$data_non_rutin['transaksi_non_rutin_tgl'] = date('Y-m-d H:i:s');
			$data_non_rutin['who_create'] = htmlentities($session['user_nama_lengkap']);
			$data_non_rutin['when_create'] = date('Y-m-d H:i:s');
			$data_non_rutin['who_seksi_create'] = htmlentities($session['user_unit_id']);

			$this->M_request->insertNonRutin($data_non_rutin);

			/* Insert Transaksi */
			$data_transaksi['transaksi_id'] = anti_inject($this->input->get_post('transaksi_id'));
			$data_transaksi['id_transaksi_non_rutin'] = $data_non_rutin['transaksi_non_rutin_id'];
			$data_transaksi['transaksi_tipe'] = (anti_inject($this->input->get_post('transaksi_approver_poscode')) == 'E35000000') ? 'E' : 'I';
			$data_transaksi['transaksi_judul'] = ($this->input->get_post('transaksi_judul'));
			$data_transaksi['transaksi_id_peminta_jasa'] = anti_inject($this->input->get_post('peminta_jasa_id'));
			$data_transaksi['transaksi_nomor'] = '';
			$data_transaksi['transaksi_id_template_keterangan'] = anti_inject($this->input->get_post('template_id'));
			$data_transaksi['transaksi_klasifikasi_id'] = anti_inject($this->input->get_post('transaksi_klasifikasi_id'));
			$data_transaksi['transaksi_sifat'] = anti_inject($this->input->get_post('transaksi_sifat'));
			$data_transaksi['transaksi_kecepatan_tanggap'] = anti_inject($this->input->get_post('transaksi_kecepatan_tanggap'));
			$data_transaksi['transaksi_reviewer'] = anti_inject($this->input->get_post('transaksi_reviewer'));
			$data_transaksi['transaksi_approver'] = anti_inject($this->input->get_post('transaksi_approver'));
			$data_transaksi['transaksi_drafter'] = anti_inject($this->input->get_post('transaksi_drafter'));
			$data_transaksi['transaksi_tujuan'] = anti_inject($this->input->get_post('transaksi_tujuan'));
			$data_transaksi['who_seksi_create'] = $session['user_unit_id'];
			$data_transaksi['transaksi_status'] = anti_inject($this->input->get_post('transaksi_status'));
			$data_transaksi['transaksi_pic_pengirim_id'] = anti_inject($this->input->get_post('transaksi_pic_pengirim_id'));
			$data_transaksi['transaksi_pic_pengirim'] = anti_inject($this->input->get_post('transaksi_detail_pic_pengirim'));
			$data_transaksi['transaksi_pic_ext'] = anti_inject($this->input->get_post('transaksi_detail_ext_pengirim'));
			$data_transaksi['transaksi_pic_telepon'] = anti_inject($this->input->get_post('transaksi_detail_pic_telepon'));
			$data_transaksi['transaksi_reviewer_poscode'] = anti_inject($this->input->get_post('transaksi_reviewer_poscode'));
			$data_transaksi['transaksi_approver_poscode'] = anti_inject($this->input->get_post('transaksi_approver_poscode'));
			$data_transaksi['transaksi_drafter_poscode'] = anti_inject($this->input->get_post('transaksi_drafter_poscode'));
			$data_transaksi['transaksi_tujuan_poscode'] = anti_inject($this->input->get_post('transaksi_tujuan_poscode'));
			$data_transaksi['transaksi_pic_poscode'] = anti_inject($this->input->get_post('transaksi_pic_pengirim_poscode'));
			$data_transaksi['transaksi_tgl'] = date('Y-m-d H:i:s');
			$data_transaksi['who_create'] = $session['user_nama'];
			$data_transaksi['when_create'] = date('Y-m-d H:i:s');

			$this->M_request->insertRequest($data_transaksi);
			/* Insert Transaksi */

			sampleLog($data_transaksi['transaksi_id'], null, $data_transaksi['id_transaksi_non_rutin'], $data_transaksi['transaksi_tipe'], $data_transaksi['transaksi_status'], 'Pekerjaan Draft Telah Diupdate Oleh PIC');
		}
	}

	public function updateAjukan(){
		$session = $this->session->userdata();
		$data_user['direct_superior'] = substr($session['user_direct_superior'], 0, 6);
		$user = $this->M_user_api->getUserList($data_user);

		/* DELETE */
		$delete_sample = $this->db->delete('sample.sample_transaksi', array('id_transaksi_non_rutin' => $this->input->get_post('transaksi_non_rutin_id')));
		$delete_detail = $this->db->delete('sample.sample_transaksi_detail', array('id_non_rutin' => $this->input->get_post('transaksi_non_rutin_id'), 'transaksi_detail_status' => $this->input->get_post('transaksi_status')));
		$delete_non_rutin = $this->db->delete('sample.sample_transaksi_non_rutin', array('transaksi_non_rutin_id' => $this->input->get_post('transaksi_non_rutin_id')));
		/* DELETE */

		if ($delete_detail == TRUE && $delete_sample == TRUE && $delete_non_rutin == TRUE) {

			$jumlah_upload_data = count($this->input->get_post('transaksi_detail_id'));

			if ($this->input->post('transaksi_reviewer') == $this->input->post('transaksi_approver')) $status = '3';
			elseif ($this->input->post('transaksi_drafter') == $this->input->post('transaksi_reviewer')) $status = '2';
			else $status = '1';

			$upload_path = FCPATH . './document/';
			if (!file_exists($upload_path)) mkdir($upload_path);
			for ($i = 0; $i < $jumlah_upload_data; $i++) {
				$allowed_mime_type_arr = array('application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'text/plain', 'application/pdf', 'image/jpeg', 'image/png', 'image/gif', 'image/bmp');
				$mime = get_mime_by_extension($_FILES['transaksi_detail_attachment']['name'][$i]);
				if (!empty($_FILES['transaksi_detail_attachment']['name'][$i])) {
					if (in_array($mime, $allowed_mime_type_arr)) {
						$tmpName = $_FILES['transaksi_detail_attachment']['tmp_name'][$i];
						$fileName = $_FILES['transaksi_detail_attachment']['name'][$i];
						$fileType = $_FILES['transaksi_detail_attachment']['type'][$i];

						$acak = rand(11111111, 99999999);
						$fileExt = substr($fileName, strpos($fileName, '.'));
						$fileExt = str_replace('.', '', $fileExt); // Extension
						$fileName = preg_replace("/\.[^.\s]{3,4}$/", "", $fileName);
						$newFileName = $fileName . str_replace(' ', '', $acak . '_' . date('ymdhis') . '.' . $fileExt);
						move_uploaded_file($tmpName, $upload_path . $newFileName);
						$new_attachment = $newFileName;
					} else {
						echo 0;
						exit;
					}
				} else {
					$new_attachment =	$this->input->get_post('transaksi_detail_attachment_lama')[$i];;
				}
				$mime = get_mime_by_extension($_FILES['transaksi_detail_file']['name'][$i]);
				if (!empty($_FILES['transaksi_detail_file']['name'][$i])) {
					if (in_array($mime, $allowed_mime_type_arr)) {
						$tmpName = $_FILES['transaksi_detail_file']['tmp_name'][$i];
						$fileName = $_FILES['transaksi_detail_file']['name'][$i];
						$fileType = $_FILES['transaksi_detail_file']['type'][$i];

						$acak = rand(11111111, 99999999);
						$fileExt = substr($fileName, strpos($fileName, '.'));
						$fileExt = str_replace('.', '', $fileExt); // Extension
						$fileName = preg_replace("/\.[^.\s]{3,4}$/", "", $fileName);
						$newFileName = $fileName . str_replace(' ', '', $acak . '_' . date('ymdhis') . '.' . $fileExt);
						move_uploaded_file($tmpName, $upload_path . $newFileName);
						$new_file = $newFileName;
					} else {
						echo 0;
						exit;
					}
				} else {
					$new_file =	$this->input->get_post('transaksi_detail_file_lama')[$i];;
				}

				if ($new_file && $new_attachment) {
					echo 1;
				}

				$data[] = array(
					'transaksi_detail_id' => anti_inject($this->input->get_post('transaksi_detail_id')[$i]),
					'transaksi_detail_judul' => ($this->input->get_post('item_judul')[$i]),
					'jenis_id' => anti_inject($this->input->get_post('jenis_id')[$i]),
					'jenis_pekerjaan_id' => anti_inject($this->input->get_post('jenis_pekerjaan_id')[$i]),
					'transaksi_detail_jumlah' => anti_inject($this->input->get_post('transaksi_detail_jumlah')[$i]),
					'identitas_id' => anti_inject($this->input->get_post('identitas_id')[$i]),
					'transaksi_detail_identitas' => anti_inject($this->input->get_post('transaksi_detail_identitas')[$i]),
					'transaksi_detail_parameter' => anti_inject($this->input->get_post('transaksi_detail_parameter')[$i]),
					'transaksi_detail_deskripsi_parameter' => anti_inject($this->input->get_post('transaksi_detail_deskripsi_parameter')[$i]),
					'transaksi_detail_catatan' => anti_inject($this->input->get_post('transaksi_detail_catatan')[$i]),
					'transaksi_detail_attach' => $new_attachment,
					'transaksi_detail_file' => $new_file,
					'transaksi_id' => anti_inject($this->input->get_post('transaksi_id')),
					'id_non_rutin' => anti_inject($this->input->get_post('transaksi_non_rutin_id')),
					'peminta_jasa_id' => anti_inject($this->input->post('peminta_jasa_id')),
					'transaksi_detail_tgl_pengajuan' => date('Y-m-d H:i:s'),
					'transaksi_detail_klasifikasi_id' => anti_inject($this->input->get_post('transaksi_klasifikasi_id')),
					'transaksi_detail_id_template_keterangan' => anti_inject($this->input->get_post('template_id')),
					'transaksi_detail_status' => $status,
					'when_create' => date('Y-m-d H:i:s'),
					'who_create' => $session['user_nama_lengkap'],
					'who_seksi_create' => $session['user_unit_id'],
				);
			}
			$this->db->insert_batch('sample.sample_transaksi_detail', $data);

			$data_non_rutin['transaksi_non_rutin_id'] = anti_inject($this->input->get_post('transaksi_non_rutin_id'));
			$data_non_rutin['transaksi_non_rutin_tgl'] = date('Y-m-d H:i:s');
			$data_non_rutin['who_create'] = htmlentities($session['user_nama_lengkap']);
			$data_non_rutin['when_create'] = date('Y-m-d H:i:s');
			$data_non_rutin['who_seksi_create'] = htmlentities($session['user_unit_id']);
			$this->M_request->insertNonRutin($data_non_rutin);

			$sql = $this->db->query("SELECT * FROM sample.sample_transaksi_detail WHERE id_non_rutin = '" . $this->input->get_post('transaksi_non_rutin_id') . "'");
			foreach ($sql->result_array() as $key => $value) {
				$data_transaksi['transaksi_id'] = anti_inject($this->input->get_post('transaksi_id'));
				$data_transaksi['id_transaksi_non_rutin'] = $data_non_rutin['transaksi_non_rutin_id'];
				$data_transaksi['id_transaksi_detail'] = $value['transaksi_detail_id'];
				$data_transaksi['transaksi_tipe'] = (anti_inject($this->input->get_post('transaksi_approver_poscode')) == 'E35000000') ? 'E' : 'I';
				$data_transaksi['transaksi_judul'] = ($this->input->get_post('transaksi_judul'));
				$data_transaksi['transaksi_id_peminta_jasa'] = anti_inject($this->input->get_post('peminta_jasa_id'));
				$data_transaksi['transaksi_nomor'] = '';
				$data_transaksi['transaksi_id_template_keterangan'] = anti_inject($this->input->get_post('template_id'));
				$data_transaksi['transaksi_klasifikasi_id'] = anti_inject($this->input->get_post('transaksi_klasifikasi_id'));
				$data_transaksi['transaksi_sifat'] = anti_inject($this->input->get_post('transaksi_sifat'));
				$data_transaksi['transaksi_kecepatan_tanggap'] = anti_inject($this->input->get_post('transaksi_kecepatan_tanggap'));
				$data_transaksi['transaksi_reviewer'] = anti_inject($this->input->get_post('transaksi_reviewer'));
				$data_transaksi['transaksi_approver'] = anti_inject($this->input->get_post('transaksi_approver'));
				$data_transaksi['transaksi_drafter'] = anti_inject($this->input->get_post('transaksi_drafter'));
				$data_transaksi['transaksi_tujuan'] = anti_inject($this->input->get_post('transaksi_tujuan'));
				$data_transaksi['who_seksi_create'] = $session['user_unit_id'];
				$data_transaksi['transaksi_status'] = $status;
				$data_transaksi['transaksi_pic_pengirim_id'] = anti_inject($this->input->get_post('transaksi_pic_pengirim_id'));
				$data_transaksi['transaksi_pic_pengirim'] = anti_inject($this->input->get_post('transaksi_detail_pic_pengirim'));
				$data_transaksi['transaksi_pic_ext'] = anti_inject($this->input->get_post('transaksi_detail_ext_pengirim'));
				$data_transaksi['transaksi_pic_telepon'] = anti_inject($this->input->get_post('transaksi_detail_pic_telepon'));
				$data_transaksi['transaksi_reviewer_poscode'] = anti_inject($this->input->get_post('transaksi_reviewer_poscode'));
				$data_transaksi['transaksi_approver_poscode'] = anti_inject($this->input->get_post('transaksi_approver_poscode'));
				$data_transaksi['transaksi_drafter_poscode'] = anti_inject($this->input->get_post('transaksi_drafter_poscode'));
				$data_transaksi['transaksi_tujuan_poscode'] = anti_inject($this->input->get_post('transaksi_tujuan_poscode'));
				$data_transaksi['transaksi_pic_poscode'] = anti_inject($this->input->get_post('transaksi_pic_pengirim_poscode'));
				$data_transaksi['transaksi_tgl'] = date('Y-m-d H:i:s');
				$data_transaksi['who_create'] = $session['user_nama'];
				$data_transaksi['when_create'] = date('Y-m-d H:i:s');
			}
			$data_transaksi['transaksi_agreement_keterangan'] = anti_inject($this->input->get_post('transaksi_agreement_keterangan'));

			$this->M_request->insertRequest($data_transaksi);

			sampleLog($data_transaksi['transaksi_id'], null, $data_transaksi['id_transaksi_non_rutin'], $data_transaksi['transaksi_tipe'], $data_transaksi['transaksi_status'], 'Pekerjaan Ajuan Telah Diedit Oleh PIC ');
		}
	}

	public function insertKeterangan(){

		$session = $this->session->userdata();

		$config['upload_path'] = FCPATH . './upload/keterangan';
		$config['allowed_types'] = 'application/pdf|.doc|.docx|.xls|.xlsx|.ppt|.pptx|image/jpeg|image/png|image/gif|image/bmp';
		// $config['max_size']  = '15000';
		// $config['max_width']  = '1024';
		// $config['max_height']  = '768';

		$this->upload->initialize($config);

		if (!empty($_FILES['keterangan_file']['name'])) {
			if (!$this->upload->do_upload('keterangan_file')) {
				$error = array('error' => $this->upload->display_errors());
				print_r($error);
			} else {
				$data = $this->upload->data();
			}
		}

		if (isset($data['file_name'])) {
			$newFile = $data['file_name'];
		} else {
			$newFile = '';
		}


		$param['transaksi_keterangan_id'] =  anti_inject($this->input->get_post('keterangan_id'));
		$param['transaksi_id_template'] =  anti_inject($this->input->get_post('id_template'));
		$param['transaksi_keterangan_asal'] = anti_inject($this->input->get_post('keterangan_dari'));
		$param['transaksi_keterangan_tujuan'] = anti_inject($this->input->get_post('keterangan_kepada'));
		$param['transaksi_keterangan_perihal'] = anti_inject($this->input->get_post('keterangan_perihal'));
		$param['transaksi_keterangan_tanggal'] = anti_inject($this->input->get_post('keterangan_tanggal'));
		$param['transaksi_keterangan_file'] = $newFile;
		$param['transaksi_keterangan_isi'] = anti_inject($this->input->get_post('keterangan_isi'));
		$param['when_create'] = date('Y-m-d H:i:s');
		$param['who_create'] = $session['user_nama'];

		print_r($param);

		$this->M_request->insertKeterangan($param);
	}

	/* INSERT */

	/* UPDATE */
	public function updateRequestOld(){
		$isi = $this->session->userdata();

		if (isset($_FILES['transaksi_detail_foto'])) {
			$temp = "./document/";
			if (!file_exists($temp)) mkdir($temp);

			$fileupload      = $_FILES['transaksi_detail_foto']['tmp_name'];
			$ImageName       = $_FILES['transaksi_detail_foto']['name'];
			$ImageType       = $_FILES['transaksi_detail_foto']['type'];

			if (!empty($fileupload)) {
				$acak           = rand(11111111, 99999999);
				$ImageExt       = substr($ImageName, strrpos($ImageName, '.'));
				$ImageExt       = str_replace('.', '', $ImageExt); // Extension
				$ImageName      = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
				$NewImageName   = str_replace(' ', '', $_POST['jenis_id'] . '_' . date('ymdhis') . '.' . $ImageExt);

				move_uploaded_file($_FILES["transaksi_detail_foto"]["tmp_name"], $temp . $NewImageName); // Menyimpan file

				$note = "Data Berhasil Disimpan";
			} else {
				$note = "Data Gagal Disimpan";
			}
			echo $note;
		} else {
			$NewImageName = null;
		}

		$id = $this->input->post('transaksi_id');
		$data = array(
			'transaksi_tgl' => date('Y-m-d H:i:s', strtotime($this->input->post('transaksi_detail_tgl_pengajuan'))),
			'when_create' => date('Y-m-d H:i:s'),
			'who_create' => $isi['user_nama_lengkap'],
			'who_seksi_create' => $isi['user_unit_id'],
		);

		$this->M_request->updateRequest($data, $id);

		$transaksi_detail_foto = ($NewImageName) ? $NewImageName : $this->input->post('temp_transaksi_detail_foto');
		$id_detail = $this->input->post('transaksi_detail_id');

		$data_detail = array(
			'identitas_id' => $this->input->post('identitas_id'),
			'jenis_id' => $this->input->post('jenis_id'),
			'peminta_jasa_id' => $this->input->post('peminta_jasa_id'),
			'jenis_pekerjaan_id' => $this->input->post('jenis_pekerjaan_id'),
			'transaksi_detail_pic_pengirim' => $this->input->post('transaksi_detail_pic_pengirim'),
			'transaksi_detail_ext_pengirim' => $this->input->post('transaksi_detail_ext_pengirim'),
			'transaksi_detail_jumlah' => $this->input->post('transaksi_detail_jumlah'),
			'transaksi_detail_parameter' => $this->input->post('transaksi_detail_parameter'),
			'transaksi_detail_tgl_pengajuan' => date('Y-m-d H:i:s', strtotime($this->input->post('transaksi_detail_tgl_pengajuan'))),
			'transaksi_detail_tgl_memo' => date('Y-m-d H:i:s', strtotime($this->input->post('transaksi_detail_tgl_memo'))),
			'transaksi_detail_no_memo' => $this->input->post('transaksi_detail_no_memo'),
			// 'transaksi_detail_no_memo' => $this->input->post('transaksi_detail_no_memo'),
			// 'transaksi_detail_note' => $this->input->post('transaksi_detail_note'),
			'transaksi_detail_foto' => $transaksi_detail_foto,
			'when_create' => date('Y-m-d H:i:s'),
			'who_create' => $isi['user_nama_lengkap'],
			'who_seksi_create' => $isi['user_unit_id'],
		);

		$this->M_request->updateRequestDetail($data_detail, $id_detail);
	}

	public function updateRequest(){
		$sql = $this->db->query("SELECT * FROM sample.sample_transaksi_detail WHERE id_non_rutin = '" . $this->input->get_post('transaksi_non_rutin_id')
			. "'");
		if ($sql->num_rows() == 0) {
			$error = "Data Sample Tidak Boleh Kosong";
			echo json_encode($error);
		} else {
			$isi = $this->session->userdata();
			// generate nomor (sementara sampai dapet ketentuan yang baru)
			// Nomor urut/kode sesuai skretariat/Dep.PPK.LUK/Digilabs Number/tahun
			$param_seksi['seksi_id'] = $isi['user_unit_id'];
			$nomor = $this->M_nomor->getNomorMax();
			$sekretariat = $this->input->get_post('transaksi_klasifikasi_id');
			$kode_sekretariat = $this->db->get_where('sample.sample_klasifikasi', array('klasifikasi_id' => $sekretariat))->row_array();
			$dept = '39.4';
			$digi = 'DIGILABS';
			$tahun = date('Y');

			$newNomor = sprintf("%05d", ($nomor['isi'] + 1)) . '/' . $kode_sekretariat['klasifikasi_kode'] . '/'  . $digi . '/' . $tahun;
			// generate nomor (sementara sampai dapat ketentuan yang baru

			// insert transaksi non rutin
			// $data_non_rutin['transaksi_non_rutin_id'] = htmlentities($this->input->get_post('transaksi_non_rutin_id'));
			$id_non_rutin = $this->input->get_post('transaksi_non_rutin_id');
			$data_non_rutin['transaksi_non_rutin_tgl'] = date('Y-m-d H:i:s');
			$data_non_rutin['who_create'] = htmlentities($isi['user_nama_lengkap']);
			$data_non_rutin['when_create'] = date('Y-m-d H:i:s');
			$data_non_rutin['who_seksi_create'] = htmlentities($isi['user_unit_id']);

			$this->M_request->updateNonRutin($data_non_rutin, $id_non_rutin);

			foreach ($sql->result_array() as $key => $value) {
				/* Insert Request */
				// $data['transaksi_id'] = create_id();
				$id = $value['transaksi_id'];
				$data['transaksi_tgl'] = date('Y-m-d H:i:s', strtotime($this->input->post('transaksi_detail_tgl_pengajuan')));
				$data['transaksi_tipe'] = htmlentities($this->input->post('transaksi_tipe'));
				// $data['transaksi_urut'] = htmlentities($nomor['isi'] + 1);
				$data['transaksi_nomor'] = htmlentities($newNomor);
				// $data['transaksi_status'] = htmlentities('0');
				$data['when_create'] = date('Y-m-d H:i:s');
				$data['who_create'] = htmlentities($isi['user_nama_lengkap']);
				$data['who_seksi_create'] = htmlentities($isi['user_unit_id']);
				$data['transaksi_klasifikasi_id'] = htmlentities($this->input->get_post('transaksi_klasifikasi_id'));
				// $data['id_transaksi_non_rutin'] = htmlentities($data_non_rutin['transaksi_non_rutin_id']);
				// $data['id_transaksi_detail'] = htmlentities($value['transaksi_detail_id']);

				$this->M_request->updateRequest($data, $id);
				/* Insert Request */

				/* Insert Request Detail */
				$id_detail = $value['transaksi_detail_id'];
				// $data_detail['transaksi_detail_id'] = htmlentities($value['transaksi_detail_id']);
				$data_detail['peminta_jasa_id'] = $this->input->post('peminta_jasa_id');
				$data_detail['jenis_pekerjaan_id'] = $this->input->post('jenis_pekerjaan_id');
				// $data_detail['transaksi_id'] = $data['transaksi_id'];
				$data_detail['transaksi_detail_pic_pengirim'] = $this->input->post('transaksi_detail_pic_pengirim');
				$data_detail['transaksi_detail_ext_pengirim'] = $this->input->post('transaksi_detail_ext_pengirim');
				$data_detail['transaksi_detail_tgl_pengajuan'] = date('Y-m-d H:i:s', strtotime($this->input->post('transaksi_detail_tgl_pengajuan')));
				$data_detail['transaksi_detail_tgl_memo'] = date('Y-m-d H:i:s', strtotime($this->input->post('transaksi_detail_tgl_memo')));
				$data_detail['transaksi_detail_no_memo'] = $this->input->post('transaksi_detail_no_memo');
				$data_detail['transaksi_detail_klasifikasi_id'] = htmlentities($this->input->get_post('transaksi_klasifikasi_id'));
				// $data_detail['transaksi_detail_note'] = $this->input->post('transaksi_detail_note');
				$data_detail['transaksi_detail_status'] = '0';
				$data_detail['when_create'] = date('Y-m-d H:i:s');
				$data_detail['who_create'] = $isi['user_nama_lengkap'];
				$data_detail['who_seksi_create'] = $isi['user_unit_id'];
				// $data_detail['id_non_rutin'] = $data_non_rutin['transaksi_non_rutin_id'];
				$data_detail['transaksi_detail_nomor'] = $newNomor;

				$this->M_request->updateRequestDetail($data_detail, $id_detail);
			}
		}
		/* Insert Request Detail */
	}

	/* UPDATE */

	/* DELETE */
	public function deleteRequest(){
		$this->M_request->deleteRequestDetail($this->input->get('transaksi_non_rutin_id')); // Delete Request Detail
		$this->M_request->deleteRequest($this->input->get('transaksi_non_rutin_id')); // Delete Request
	}

	public function deleteSampleDetail(){
		$this->M_request->deleteSampleDetail($this->input->get('transaksi_detail_id'));
	}
	/* DELETE */

	// EASY UI ATTACH
	public function getEasyuiAttach(){
		$param['transaksi_id'] = $this->input->get_post('transaksi_id');
		$param['transaksi_detail_id'] = $this->input->get_post('transaksi_detail_id');
		$param['transaksi_non_rutin_id'] = $this->input->get_post('transaksi_non_rutin_id');

		$data = $this->M_request->getEasyuiAttach($param);
		// var_dump($data);
		// die;
		echo json_encode($data);
	}

	public function insertEasyuiAttachFile(){
		$config['upload_path'] = FCPATH . './upload/attach';
		$config['allowed_types'] = 'application/pdf|.doc|.docx|.xls|.xlsx|.ppt|.pptx|image/jpeg|image/png|image/gif|image/bmp';
		// $config['max_size']  = '15000';
		// $config['max_width']  = '1024';
		// $config['max_height']  = '768';

		$this->upload->initialize($config);

		if (!empty($_FILES['file']['name'])) {
			if (!$this->upload->do_upload('file')) {
				$error = array('error' => $this->upload->display_errors());
				print_r($error);
			} else {
				$data = $this->upload->data();
			}
		}

		$newSampleFile = ($this->upload->do_upload('file')) ? $data['file_name'] : null;
		print($newSampleFile);
	}

	public function insertEasyuiAttach(){
		$session = $this->session->userdata();
		$param = array(
			'transaksi_attach_id' => create_id(),
			'transaksi_attach_nama' => $this->input->get_post('transaksi_attach_nama'),
			'transaksi_attach_file' => $this->input->get_post('savedFileName'),
			'transaksi_attach_id_transaksi' => $this->input->get_post('transaksi_id'),
			'who_create' => ($session['user_nama'] != '') ? $session['user_nama'] : $session['user_nama_lengkap'],
			'when_create' => date('Y-m-d H:i:s'),
		);

		$this->M_request->insertAttach($param);
	}

	public function editEasyuiAttach(){
		$session = $this->session->userdata();
		$id = $this->input->get_post('transaksi_attach_id');
		$param = array(
			'transaksi_attach_nama' => $this->input->get_post('transaksi_attach_nama'),
			'transaksi_attach_file' => $this->input->get_post('savedFileName'),
			// 'transaksi_attach_id_transaksi' => $this->input->get_post('transaksi_id'),
			// 'who_create' => ($session['user_nama'] != '') ? $session['user_nama'] : $session['user_nama_lengkap'],
			// 'when_create' => date('Y-m-d H:i:s'),
		);

		$this->M_request->updateAttach($id, $param);
	}

	public function deleteEasyuiAttach(){
		$this->M_request->deleteEasyuiSample(anti_inject($this->input->get_post('transaksi_detail_id')));
		echo $this->db->last_query();
	}

	// EASY UI ATTACH

	// EASY UI CRUD
	public function getEasyuiSample(){
		$param['transaksi_id'] = $this->input->get_post('transaksi_id');
		$param['transaksi_detail_id'] = $this->input->get_post('transaksi_detail_id');
		$param['transaksi_non_rutin_id'] = $this->input->get_post('transaksi_non_rutin_id');

		$data = $this->M_request->getEasyuiSample($param);
		// var_dump($data);
		// die;
		echo json_encode($data);
	}

	public function insertEasyuiSampleFile(){
		// $config['upload_path'] = FCPATH . './document/';
		// $config['allowed_types'] = 'application/pdf|.doc|.docx|.xls|.xlsx|.ppt|.pptx|image/jpeg|image/png|image/gif|image/bmp';
		// $config['max_size']  = '15000';
		// $config['max_width']  = '1024';
		// $config['max_height']  = '768';

		$this->upload->initialize($config);

		if (!empty($_FILES['file']['name'])) {
			if (!$this->upload->do_upload('file')) {
				$error = array('error' => $this->upload->display_errors());
				print_r($error);
			} else {
				$data = $this->upload->data();
			}
		}

		$newSampleFile = ($this->upload->do_upload('file')) ? $data['file_name'] : null;
		print($newSampleFile);
	}

	public function insertEasyuiSample(){
		// initialize form
		$param_detail['transaksi_detail_id'] = anti_inject(create_id());
		// $param_detail['transaksi_id'] = $this->input->get_post('transaksi_id');
		$param_detail['id_non_rutin'] = anti_inject($this->input->get_post('transaksi_non_rutin_id'));
		$param_detail['jenis_id'] = anti_inject($this->input->get_post('jenis_id'));
		$param_detail['transaksi_detail_jumlah'] = anti_inject($this->input->get_post('transaksi_detail_jumlah'));
		$param_detail['identitas_id'] = anti_inject($this->input->get_post('identitas_id'));
		$param_detail['transaksi_detail_parameter'] = anti_inject($this->input->get_post('transaksi_detail_parameter'));
		$param_detail['transaksi_detail_keterangan'] = anti_inject($this->input->post('transaksi_detail_keterangan'));
		$param_detail['transaksi_detail_foto'] = anti_inject($this->input->get_post('savedFileName'));
		$param_detail['transaksi_detail_kode_tracking'] = rand();


		$this->M_request->insertRequestDetail($param_detail);
	}

	public function editEasyuiSample(){
		$id_detail = anti_inject($this->input->get_post('transaksi_detail_id'));
		$param_detail['jenis_id'] = anti_inject($this->input->get_post('jenis_id'));
		$param_detail['transaksi_detail_jumlah'] = anti_inject($this->input->get_post('transaksi_detail_jumlah'));
		$param_detail['identitas_id'] = anti_inject($this->input->get_post('identitas_id'));
		$param_detail['transaksi_detail_parameter'] = anti_inject($this->input->get_post('transaksi_detail_parameter'));
		$param_detail['transaksi_detail_keterangan'] = anti_inject($this->input->post('transaksi_detail_keterangan'));
		$param_detail['transaksi_detail_foto'] = anti_inject($this->input->get_post('savedFileName'));
		$this->M_request->updateRequestDetail($param_detail, $id_detail);
	}

	public function deleteEasyuiSample(){
		$this->M_request->deleteEasyuiSample(anti_inject($this->input->get_post('transaksi_detail_id')));
		echo $this->db->last_query();
	}
	// EASY UI CRUD

	// cetak
	public function cetakKeterangan(){
		$param['transaksi_keterangan_id'] = anti_inject($this->input->get_post('transaksi_keterangan_id'));
		$data['keterangan'] = $this->M_request->getKeterangan($param);
		$this->load->view('sample/cetak/memo', $data, FALSE);
	}
	// cetak

	public function downloadFile(){
		$files = $this->input->get_post('file');
		$file = FCPATH . ('document/' . $files);
		force_download($file, NULL);
	}
}
