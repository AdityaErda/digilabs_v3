<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Personil extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('document/M_daftar');
		$this->load->model('master/M_user');
	}

	public function index()
	{
		$isi['judul'] = 'CV. Personil';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

		$this->load->view('tampilan/header', $isi);
		$this->load->view('tampilan/sidebar', $data);
		$this->load->view('document/personil');
		$this->load->view('tampilan/footer');
		$this->load->view('document/personil_js');
	}

	public function getCV()
	{
		$param['cv_id'] = ($this->input->get_post('cv_id'));
		$param['user_id'] = anti_inject_replace($this->input->get_post('user_id'));
		echo json_encode($this->M_daftar->getCV($param));
		// echo $this->db->last_query();
	}

	public function getMasaJabatan()
	{
		$param['cv_id'] = anti_inject_replace($this->input->get_post('cv_id'));
		$param['user_id'] = anti_inject_replace($this->input->get_post('user_id'));
		echo json_encode($this->M_daftar->getMasaJabatan($param));
	}

	public function insertCV()
	{
		$user = $this->session->userdata();

		$param['cv_id'] = create_id();
		$param['company_code'] = '1';
		$param['cv_nik'] = anti_inject($this->input->get_post('nik'));
		$param['user_id'] = anti_inject($this->input->get_post('user_id'));
		$param['cv_email'] = anti_inject($this->input->get_post('email'));
		$param['cv_alamat'] = anti_inject($this->input->get_post('alamat'));
		$param['cv_tanggal_masuk'] = date('Y-m-d', strtotime($this->input->get_post('tanggal_masuk')));
		$param['cv_masa_kerja_tahun'] = anti_inject($this->input->get_post('masa_kerja_tahun'));
		$param['when_create'] = date('Y-m-d H:i:s');
		$param['who_create'] = $user['user_nama_lengkap'];

		$this->M_daftar->insertCV($param);
	}

	public function updateCV()
	{
		$user = $this->session->userdata();

		$id = anti_inject($this->input->get_post('cv_id'));
		$param['company_code'] = '1';
		$param['cv_nik'] = anti_inject($this->input->get_post('nik'));
		$param['user_id'] = anti_inject($this->input->get_post('user_id'));
		$param['cv_email'] = anti_inject($this->input->get_post('email'));
		$param['cv_alamat'] = anti_inject($this->input->get_post('alamat'));
		$param['cv_tanggal_masuk'] = date('Y-m-d', strtotime($this->input->get_post('tanggal_masuk')));
		$param['cv_masa_kerja_tahun'] = anti_inject($this->input->get_post('masa_kerja_tahun'));
		$param['when_create'] = date('Y-m-d H:i:s');
		$param['who_create'] = $user['user_nama_lengkap'];

		$this->M_daftar->updateCV($param, $id);
	}

	public function getDaftar()
	{
		$user = $this->session->userdata();
		$param['user_id'] = $user['user_id'];
		$param['role_id'] = $user['role_id'];

		$data = $this->M_daftar->getDaftar($param);
		echo json_encode($data);
	}

	public function getUser()
	{
		$listUser['results'] = array();
		$param['user_nama_lengkap'] = anti_inject_replace($this->input->get('user_nama_lengkap'));
		// sss
		foreach ($this->M_user->getUser($param) as $key => $value) {
			array_push($listUser['results'], [
				'id' => $value['user_id'],
				'text' => $value['user_nama_lengkap'],
			]);
		}
		echo json_encode($listUser);
	}

	public function cetakCV()
	{
		$param['user_id'] = anti_inject_replace($this->input->get_post('download_user_id'));
		$param['cv_id'] = anti_inject_replace($this->input->get_post('download_cv_id'));

		$data['isi'] = $this->M_daftar->getCetakCV($param);
		$data['isirpf']	= $this->M_daftar->getEasyuiRiwayatPendidikanFormal($param);
		$data['isirpnf']	= $this->M_daftar->getEasyuiRiwayatPendidikanNonFormal($param);
		$data['isirj']	= $this->M_daftar->getEasyuiRiwayatJabatan($param);
		$data['isik']	= $this->M_daftar->getEasyuiKompetensi($param);
		$data['isipk']	= $this->M_daftar->getEasyuiPenilaianKerja($param);
		$data['isipi']	= $this->M_daftar->getEasyuiPenugasanInternal($param);
		$data['isirk']	= $this->M_daftar->getEasyuiRiwayatPengalamanKerja($param);
		$data['isidk']	= $this->M_daftar->getEasyuiDataKeluarga($param);

		$this->load->view('personil_cetak', $data);
	}

	//  start easy ui

	// start file upload
	public function insertEasyuiPendidikanFormalFile()
	{
		if (isset($_FILES['file'])) {
			$upload_path = FCPATH . './upload/';
			if (!file_exists($upload_path)) mkdir($upload_path);
			$allowed_mime_type_arr = array('application/pdf');
			$mime = get_mime_by_extension($_FILES['file']['name']);
			if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != "") {
				if (in_array($mime, $allowed_mime_type_arr)) {
					/*upload excelnya*/
					$tmpName = $_FILES['file']['tmp_name'];
					$fileName = $_FILES['file']['name'];
					$fileType = $_FILES['file']['type'];

					$acak = rand(11111111, 99999999);
					$fileExt = substr($fileName, strpos($fileName, '.'));
					$fileExt = str_replace('.', '', $fileExt); // Extension
					$fileName = preg_replace("/\.[^.\s]{3,4}$/", "", $fileName);
					$newFileName = $fileName . '-' . str_replace(' ', '', $acak . '_' . date('ymdhis') . '.' . $fileExt);
					move_uploaded_file($tmpName, $upload_path . $newFileName);
					echo $newFileName;
				} else {
					// echo 0;
					exit;
				}
			}
		} else {
			$newFileName = null;
		}
	}

	public function insertEasyuiPendidikanNonFormalFile()
	{
		if (isset($_FILES['file'])) {
			$upload_path = FCPATH . './upload/';
			if (!file_exists($upload_path)) mkdir($upload_path);
			$allowed_mime_type_arr = array('application/pdf');
			$mime = get_mime_by_extension($_FILES['file']['name']);
			if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != "") {
				if (in_array($mime, $allowed_mime_type_arr)) {
					/*upload excelnya*/
					$tmpName = $_FILES['file']['tmp_name'];
					$fileName = $_FILES['file']['name'];
					$fileType = $_FILES['file']['type'];

					$acak = rand(11111111, 99999999);
					$fileExt = substr($fileName, strpos($fileName, '.'));
					$fileExt = str_replace('.', '', $fileExt); // Extension
					$fileName = preg_replace("/\.[^.\s]{3,4}$/", "", $fileName);
					$newFileName = $fileName . '-' . str_replace(' ', '', $acak . '_' . date('ymdhis') . '.' . $fileExt);
					move_uploaded_file($tmpName, $upload_path . $newFileName);
					echo $newFileName;
				} else {
					// echo 0;
					exit;
				}
			}
		} else {
			$newFileName = null;
		}
	}

	public function insertEasyuiRiwayatJabatanFile()
	{
		if (isset($_FILES['file'])) {
			$upload_path = FCPATH . './upload/';
			if (!file_exists($upload_path)) mkdir($upload_path);
			$allowed_mime_type_arr = array('application/pdf');
			$mime = get_mime_by_extension($_FILES['file']['name']);
			if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != "") {
				if (in_array($mime, $allowed_mime_type_arr)) {
					/*upload excelnya*/
					$tmpName = $_FILES['file']['tmp_name'];
					$fileName = $_FILES['file']['name'];
					$fileType = $_FILES['file']['type'];

					$acak = rand(11111111, 99999999);
					$fileExt = substr($fileName, strpos($fileName, '.'));
					$fileExt = str_replace('.', '', $fileExt); // Extension
					$fileName = preg_replace("/\.[^.\s]{3,4}$/", "", $fileName);
					$newFileName = $fileName . '-' . str_replace(' ', '', $acak . '_' . date('ymdhis') . '.' . $fileExt);
					move_uploaded_file($tmpName, $upload_path . $newFileName);
					echo $newFileName;
				} else {
					// echo 0;
					exit;
				}
			}
		} else {
			$newFileName = null;
		}
	}

	public function insertEasyuiKompetensiFile()
	{

		if (isset($_FILES['file'])) {
			$upload_path = FCPATH . './upload/';
			if (!file_exists($upload_path)) mkdir($upload_path);
			$allowed_mime_type_arr = array('application/pdf');
			$mime = get_mime_by_extension($_FILES['file']['name']);
			if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != "") {
				if (in_array($mime, $allowed_mime_type_arr)) {
					/*upload excelnya*/
					$tmpName = $_FILES['file']['tmp_name'];
					$fileName = $_FILES['file']['name'];
					$fileType = $_FILES['file']['type'];

					$acak = rand(11111111, 99999999);
					$fileExt = substr($fileName, strpos($fileName, '.'));
					$fileExt = str_replace('.', '', $fileExt); // Extension
					$fileName = preg_replace("/\.[^.\s]{3,4}$/", "", $fileName);
					$newFileName = $fileName . '-' . str_replace(' ', '', $acak . '_' . date('ymdhis') . '.' . $fileExt);
					move_uploaded_file($tmpName, $upload_path . $newFileName);
					echo $newFileName;
				} else {
					// echo 0;
					exit;
				}
			}
		} else {
			$newFileName = null;
		}
	}

	public function insertEasyuiPenilaianKerjaFile()
	{

		if (isset($_FILES['file'])) {
			$upload_path = FCPATH . './upload/';
			if (!file_exists($upload_path)) mkdir($upload_path);
			$allowed_mime_type_arr = array('application/pdf');
			$mime = get_mime_by_extension($_FILES['file']['name']);
			if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != "") {
				if (in_array($mime, $allowed_mime_type_arr)) {
					/*upload excelnya*/
					$tmpName = $_FILES['file']['tmp_name'];
					$fileName = $_FILES['file']['name'];
					$fileType = $_FILES['file']['type'];

					$acak = rand(11111111, 99999999);
					$fileExt = substr($fileName, strpos($fileName, '.'));
					$fileExt = str_replace('.', '', $fileExt); // Extension
					$fileName = preg_replace("/\.[^.\s]{3,4}$/", "", $fileName);
					$newFileName = $fileName . '-' . str_replace(' ', '', $acak . '_' . date('ymdhis') . '.' . $fileExt);
					move_uploaded_file($tmpName, $upload_path . $newFileName);
					echo $newFileName;
				} else {
					// echo 0;
					exit;
				}
			}
		} else {
			$newFileName = null;
		}
	}

	public function insertEasyuiPenugasanInternalFile()
	{
		if (isset($_FILES['file'])) {
			$upload_path = FCPATH . './upload/';
			if (!file_exists($upload_path)) mkdir($upload_path);
			$allowed_mime_type_arr = array('application/pdf');
			$mime = get_mime_by_extension($_FILES['file']['name']);
			if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != "") {
				if (in_array($mime, $allowed_mime_type_arr)) {
					/*upload excelnya*/
					$tmpName = $_FILES['file']['tmp_name'];
					$fileName = $_FILES['file']['name'];
					$fileType = $_FILES['file']['type'];

					$acak = rand(11111111, 99999999);
					$fileExt = substr($fileName, strpos($fileName, '.'));
					$fileExt = str_replace('.', '', $fileExt); // Extension
					$fileName = preg_replace("/\.[^.\s]{3,4}$/", "", $fileName);
					$newFileName = $fileName . '-' . str_replace(' ', '', $acak . '_' . date('ymdhis') . '.' . $fileExt);
					move_uploaded_file($tmpName, $upload_path . $newFileName);
					echo $newFileName;
				} else {
					// echo 0;
					exit;
				}
			}
		} else {
			$newFileName = null;
		}
	}

	public function insertEasyuiPengalamanKerjaFile()
	{
		if (isset($_FILES['file'])) {
			$upload_path = FCPATH . './upload/';
			if (!file_exists($upload_path)) mkdir($upload_path);
			$allowed_mime_type_arr = array('application/pdf');
			$mime = get_mime_by_extension($_FILES['file']['name']);
			if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != "") {
				if (in_array($mime, $allowed_mime_type_arr)) {
					/*upload excelnya*/
					$tmpName = $_FILES['file']['tmp_name'];
					$fileName = $_FILES['file']['name'];
					$fileType = $_FILES['file']['type'];

					$acak = rand(11111111, 99999999);
					$fileExt = substr($fileName, strpos($fileName, '.'));
					$fileExt = str_replace('.', '', $fileExt); // Extension
					$fileName = preg_replace("/\.[^.\s]{3,4}$/", "", $fileName);
					$newFileName = $fileName . '-' . str_replace(' ', '', $acak . '_' . date('ymdhis') . '.' . $fileExt);
					move_uploaded_file($tmpName, $upload_path . $newFileName);
					echo $newFileName;
				} else {
					// echo 0;
					exit;
				}
			}
		} else {
			$newFileName = null;
		}
	}

	public function insertEasyuiDataKeluargaFile()
	{

		if (isset($_FILES['file'])) {
			$upload_path = FCPATH . './upload/';
			if (!file_exists($upload_path)) mkdir($upload_path);
			$allowed_mime_type_arr = array('application/pdf');
			$mime = get_mime_by_extension($_FILES['file']['name']);
			if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != "") {
				if (in_array($mime, $allowed_mime_type_arr)) {
					/*upload excelnya*/
					$tmpName = $_FILES['file']['tmp_name'];
					$fileName = $_FILES['file']['name'];
					$fileType = $_FILES['file']['type'];

					$acak = rand(11111111, 99999999);
					$fileExt = substr($fileName, strpos($fileName, '.'));
					$fileExt = str_replace('.', '', $fileExt); // Extension
					$fileName = preg_replace("/\.[^.\s]{3,4}$/", "", $fileName);
					$newFileName = $fileName . '-' . str_replace(' ', '', $acak . '_' . date('ymdhis') . '.' . $fileExt);
					move_uploaded_file($tmpName, $upload_path . $newFileName);
					echo $newFileName;
				} else {
					// echo 0;
					exit;
				}
			}
		} else {
			$newFileName = null;
		}
	}
	// start file upload

	// start data
	public function getEasyuiRiwayatPendidikanFormal()
	{
		$param['user_id'] = anti_inject_replace($this->input->get_post('user_id'));
		$param['cv_id'] = anti_inject_replace($this->input->get_post('cv_id'));
		echo json_encode($this->M_daftar->getEasyuiRiwayatPendidikanFormal($param));
	}

	public function getEasyuiRiwayatPendidikanNonFormal()
	{
		$param['user_id'] = anti_inject_replace($this->input->get_post('user_id'));
		$param['cv_id'] = anti_inject_replace($this->input->get_post('cv_id'));
		echo json_encode($this->M_daftar->getEasyuiRiwayatPendidikanNonFormal($param));
	}

	public function getEasyuiRiwayatJabatan()
	{
		$param['user_id'] = anti_inject_replace($this->input->get_post('user_id'));
		$param['cv_id'] = anti_inject_replace($this->input->get_post('cv_id'));
		echo json_encode($this->M_daftar->getEasyuiRiwayatJabatan($param));
	}

	public function getEasyuiKompetensi()
	{
		$param['user_id'] = anti_inject_replace($this->input->get_post('user_id'));
		$param['cv_id'] = anti_inject_replace($this->input->get_post('cv_id'));
		echo json_encode($this->M_daftar->getEasyuiKompetensi($param));
	}

	public function getEasyuiPenilaianKerja()
	{
		$param['user_id'] = anti_inject_replace($this->input->get_post('user_id'));
		$param['cv_id'] = anti_inject_replace($this->input->get_post('cv_id'));
		echo json_encode($this->M_daftar->getEasyuiPenilaianKerja($param));
	}

	public function getEasyuiPenugasanInternal()
	{
		$param['user_id'] = anti_inject_replace($this->input->get_post('user_id'));
		$param['cv_id'] = anti_inject_replace($this->input->get_post('cv_id'));
		echo json_encode($this->M_daftar->getEasyuiPenugasanInternal($param));
	}

	public function getEasyuiRiwayatPengalamanKerja()
	{
		$param['user_id'] = anti_inject_replace($this->input->get_post('user_id'));
		$param['cv_id'] = anti_inject_replace($this->input->get_post('cv_id'));
		echo json_encode($this->M_daftar->getEasyuiRiwayatPengalamanKerja($param));
	}

	public function getEasyuiDataKeluarga()
	{
		$param['user_id'] = anti_inject_replace($this->input->get_post('user_id'));
		$param['cv_id'] = anti_inject_replace($this->input->get_post('cv_id'));
		echo json_encode($this->M_daftar->getEasyuiDataKeluarga($param));
	}
	// end data

	// start insert
	public function insertEasyuiRiwayatPendidikanFormal()
	{
		$user = $this->session->userdata();
		$param['pendidikan_formal_id'] = create_id();
		$param['cv_id'] = anti_inject($this->input->get_post('cv_id'));
		$param['pendidikan_formal_jenjang'] = anti_inject($this->input->get_post('pendidikan_formal_jenjang'));
		$param['pendidikan_formal_jurusan'] = anti_inject($this->input->get_post('pendidikan_formal_jurusan'));
		$param['pendidikan_formal_institusi'] = anti_inject($this->input->get_post('pendidikan_formal_institusi'));
		$param['pendidikan_formal_tahun'] = anti_inject($this->input->get_post('pendidikan_formal_tahun'));
		$param['pendidikan_formal_file'] = anti_inject($this->input->get_post('filerpf'));
		$param['when_create'] = date('Y-m-d H:i:s');
		$param['who_create'] = $user['user_nama_lengkap'];

		$this->M_daftar->insertEasyuiRiwayatPendidikanFormal($param);
	}

	public function insertEasyuiRiwayatPendidikanNonFormal()
	{
		$user = $this->session->userdata();
		$param['pendidikan_non_formal_id'] = create_id();
		$param['cv_id'] = anti_inject($this->input->get_post('cv_id'));
		$param['pendidikan_non_formal_judul'] = anti_inject($this->input->get_post('pendidikan_non_formal_judul'));
		$param['pendidikan_non_formal_institusi'] = anti_inject($this->input->get_post('pendidikan_non_formal_institusi'));
		$param['pendidikan_non_formal_tahun'] = anti_inject($this->input->get_post('pendidikan_non_formal_tahun'));
		$param['pendidikan_non_formal_file'] = anti_inject($this->input->get_post('fil_pendidikan_non_formal'));
		$param['when_create'] = date('Y-m-d H:i:s');
		$param['who_create'] = $user['user_nama_lengkap'];

		$this->M_daftar->insertEasyuiRiwayatPendidikanNonFormal($param);
	}

	public function insertEasyuiRiwayatJabatan()
	{
		$user = $this->session->userdata();
		$param['jabatan_id'] = create_id();
		$param['cv_id'] = anti_inject($this->input->get_post('cv_id'));
		$param['jabatan_mulai'] = date('Y-m-d', strtotime($this->input->get_post('jabatan_mulai')));
		$param['jabatan_selesai'] = date('Y-m-d', strtotime($this->input->get_post('jabatan_selesai')));
		$param['jabatan_masa_kerja'] = anti_inject($this->input->get_post('jabatan_masa_kerja'));
		$param['jabatan_unit_kerja'] = anti_inject($this->input->get_post('jabatan_unit_kerja'));
		$param['jabatan_nama'] = anti_inject($this->input->get_post('jabatan_nama'));
		$param['jabatan_file'] = anti_inject($this->input->get_post('filerj'));
		$param['when_create'] = date('Y-m-d H:i:s');
		$param['who_create'] = $user['user_nama_lengkap'];

		$this->M_daftar->insertEasyuiRiwayatJabatan($param);
	}

	public function insertEasyuiKompetensi()
	{
		$user = $this->session->userdata();
		$param['kompetensi_id'] = create_id();
		$param['cv_id'] = anti_inject($this->input->get_post('cv_id'));
		$param['kompetensi_judul'] = anti_inject($this->input->get_post('kompetensi_judul'));
		$param['kompetensi_nama'] = anti_inject($this->input->get_post('kompetensi_nama'));
		$param['kompetensi_tahun'] = anti_inject($this->input->get_post('kompetensi_tahun'));
		$param['kompetensi_file'] = anti_inject($this->input->get_post('filekp'));
		$param['when_create'] = date('Y-m-d H:i:s');
		$param['who_create'] = $user['user_nama_lengkap'];

		$this->M_daftar->insertEasyuiKompetensi($param);
	}

	public function insertEasyuiPenilaianKerja()
	{
		$user = $this->session->userdata();
		$param['penilaian_kerja_id'] = create_id();
		$param['cv_id'] = anti_inject($this->input->get_post('cv_id'));
		$param['penilaian_kerja_tanggal'] = date('Y-m-d', strtotime($this->input->get_post('penilaian_kerja_tanggal')));
		$param['penilaian_kerja_file'] = anti_inject($this->input->get_post('filepk'));
		$param['when_create'] = date('Y-m-d H:i:s');
		$param['who_create'] = $user['user_nama_lengkap'];

		$this->M_daftar->insertEasyuiPenilaianKerja($param);
	}

	public function insertEasyuiPenugasanInternal()
	{
		$user = $this->session->userdata();
		$param['penugasan_internal_id'] = create_id();
		$param['cv_id'] = anti_inject($this->input->get_post('cv_id'));
		$param['penugasan_internal_tanggal_mulai'] = date('Y-m-d', strtotime($this->input->get_post('penugasan_internal_tanggal_mulai')));
		$param['penugasan_internal_tanggal_selesai'] = date('Y-m-d', strtotime($this->input->get_post('penugasan_internal_tanggal_selesai')));
		$param['penugasan_internal_nama'] = anti_inject($this->input->get_post('penugasan_internal_nama'));
		$param['penugasan_internal_memo'] = anti_inject($this->input->get_post('penugasan_internal_memo'));
		$param['penugasan_internal_file'] = anti_inject($this->input->get_post('fil_pendidikan_non_formal'));
		$param['when_create'] = date('Y-m-d H:i:s');
		$param['who_create'] = $user['user_nama_lengkap'];

		$this->M_daftar->insertEasyuiPenugasanInternal($param);
	}

	public function insertEasyuiRiwayatPengalamanKerja()
	{
		$user = $this->session->userdata();
		$param['pengalaman_id'] = create_id();
		$param['cv_id'] = anti_inject($this->input->get_post('cv_id'));
		$param['pengalaman_tanggal_mulai'] = date('Y-m-d', strtotime($this->input->get_post('pengalaman_tanggal_mulai')));
		$param['pengalaman_tanggal_selesai'] = date('Y-m-d', strtotime($this->input->get_post('pengalaman_tanggal_selesai')));
		$param['pengalaman_unit_kerja'] = anti_inject($this->input->get_post('pengalaman_unit_kerja'));
		$param['pengalaman_grade'] = anti_inject($this->input->get_post('pengalaman_grade'));
		$param['pengalaman_nama'] = anti_inject($this->input->get_post('pengalaman_nama'));
		$param['pengalaman_instansi'] = anti_inject($this->input->get_post('pengalaman_instansi'));
		$param['pengalaman_file'] = anti_inject($this->input->get_post('filerpk'));
		$param['when_create'] = date('Y-m-d H:i:s');
		$param['who_create'] = $user['user_nama_lengkap'];

		$this->M_daftar->insertEasyuiRiwayatPengalamanKerja($param);
	}

	public function insertEasyuiDataKeluarga()
	{
		$user = $this->session->userdata();
		$param['data_keluarga_id'] = create_id();
		$param['cv_id'] = anti_inject($this->input->get_post('cv_id'));
		$param['data_keluarga_nama'] = anti_inject($this->input->get_post('data_keluarga_nama'));
		$param['data_keluarga_status'] = anti_inject($this->input->get_post('data_keluarga_status'));
		$param['data_keluarga_alamat'] = anti_inject($this->input->get_post('data_keluarga_alamat'));
		$param['when_create'] = date('Y-m-d H:i:s');
		$param['who_create'] = $user['user_nama_lengkap'];

		$this->M_daftar->insertEasyuiDataKeluarga($param);
		echo $this->db->last_query();
	}
	// end insert

	// start edit
	public function editEasyuiRiwayatPendidikanFormal()
	{
		$user = $this->session->userdata();
		$id = anti_inject($this->input->get_post('pendidikan_formal_id'));
		$param['cv_id'] = anti_inject($this->input->get_post('cv_id'));
		$param['pendidikan_formal_jenjang'] = anti_inject($this->input->get_post('pendidikan_formal_jenjang'));
		$param['pendidikan_formal_jurusan'] = anti_inject($this->input->get_post('pendidikan_formal_jurusan'));
		$param['pendidikan_formal_institusi'] = anti_inject($this->input->get_post('pendidikan_formal_institusi'));
		$param['pendidikan_formal_tahun'] = anti_inject($this->input->get_post('pendidikan_formal_tahun'));
		if ($this->input->get_post('filerpf')) {
			$param['pendidikan_formal_file'] = anti_inject($this->input->get_post('filerpf'));
		}
		$param['when_create'] = date('Y-m-d H:i:s');
		$param['who_create'] = $user['user_nama_lengkap'];

		$this->M_daftar->editEasyuiRiwayatPendidikanFormal($param, $id);
	}

	public function editEasyuiRiwayatPendidikanNonFormal()
	{
		$user = $this->session->userdata();
		$id = anti_inject($this->input->get_post('pendidikan_non_formal_id'));
		$param['cv_id'] = anti_inject($this->input->get_post('cv_id'));
		$param['pendidikan_non_formal_judul'] = anti_inject($this->input->get_post('pendidikan_non_formal_judul'));
		$param['pendidikan_non_formal_institusi'] = anti_inject($this->input->get_post('pendidikan_non_formal_institusi'));
		$param['pendidikan_non_formal_tahun'] = anti_inject($this->input->get_post('pendidikan_non_formal_tahun'));
		if ($this->input->get_post('fil_pendidikan_non_formal')) {
			$param['pendidikan_non_formal_file'] = anti_inject($this->input->get_post('fil_pendidikan_non_formal'));
		}
		$param['when_create'] = date('Y-m-d H:i:s');
		$param['who_create'] = $user['user_nama_lengkap'];

		$this->M_daftar->editEasyuiRiwayatPendidikanNonFormal($param, $id);
	}

	public function editEasyuiRiwayatJabatan()
	{
		$user = $this->session->userdata();
		$id = anti_inject($this->input->get_post('jabatan_id'));
		$param['cv_id'] = anti_inject($this->input->get_post('cv_id'));
		$param['jabatan_mulai'] = date('Y-m-d', strtotime($this->input->get_post('jabatan_mulai')));
		$param['jabatan_selesai'] = date('Y-m-d', strtotime($this->input->get_post('jabatan_selesai')));
		$param['jabatan_masa_kerja'] = anti_inject($this->input->get_post('jabatan_masa_kerja'));
		$param['jabatan_unit_kerja'] = anti_inject($this->input->get_post('jabatan_unit_kerja'));
		$param['jabatan_nama'] = anti_inject($this->input->get_post('jabatan_nama'));
		$param['jabatan_file'] = anti_inject($this->input->get_post('filerj'));
		$param['when_create'] = date('Y-m-d H:i:s');
		$param['who_create'] = $user['user_nama_lengkap'];

		$this->M_daftar->editEasyuiRiwayatJabatan($param, $id);
	}

	public function editEasyuiKompetensi()
	{
		$user = $this->session->userdata();
		$id = anti_inject($this->input->get_post('kompetensi_id'));
		$param['cv_id'] = anti_inject($this->input->get_post('cv_id'));
		$param['kompetensi_judul'] = anti_inject($this->input->get_post('kompetensi_judul'));
		$param['kompetensi_nama'] = anti_inject($this->input->get_post('kompetensi_nama'));
		$param['kompetensi_tahun'] = anti_inject($this->input->get_post('kompetensi_tahun'));
		$param['kompetensi_file'] = anti_inject($this->input->get_post('filekp'));
		$param['when_create'] = date('Y-m-d H:i:s');
		$param['who_create'] = $user['user_nama_lengkap'];

		$this->M_daftar->editEasyuiKompetensi($param, $id);
	}

	public function editEasyuiPenilaianKerja()
	{
		$user = $this->session->userdata();
		$id = anti_inject($this->input->get_post('penilaian_kerja_id'));
		$param['cv_id'] = anti_inject($this->input->get_post('cv_id'));
		$param['penilaian_kerja_tanggal'] = date('Y-m-d', strtotime($this->input->get_post('penilaian_kerja_tanggal')));
		$param['penilaian_kerja_file'] = anti_inject($this->input->get_post('filepk'));
		$param['when_create'] = date('Y-m-d H:i:s');
		$param['who_create'] = $user['user_nama_lengkap'];

		$this->M_daftar->editEasyuiPenilaianKerja($param, $id);
	}

	public function editEasyuiPenugasanInternal()
	{
		$user = $this->session->userdata();
		$id = anti_inject($this->input->get_post('penugasan_internal_id'));
		$param['cv_id'] = anti_inject($this->input->get_post('cv_id'));
		$param['penugasan_internal_tanggal_mulai'] = date('Y-m-d', strtotime($this->input->get_post('penugasan_internal_tanggal_mulai')));
		$param['penugasan_internal_tanggal_selesai'] = date('Y-m-d', strtotime($this->input->get_post('penugasan_internal_tanggal_selesai')));
		$param['penugasan_internal_nama'] = anti_inject($this->input->get_post('penugasan_internal_nama'));
		$param['penugasan_internal_memo'] = anti_inject($this->input->get_post('penugasan_internal_memo'));
		$param['penugasan_internal_file'] = anti_inject($this->input->get_post('fil_pendidikan_non_formal'));
		$param['when_create'] = date('Y-m-d H:i:s');
		$param['who_create'] = $user['user_nama_lengkap'];

		$this->M_daftar->editEasyuiPenugasanInternal($param, $id);
	}

	public function editEasyuiRiwayatPengalamanKerja()
	{
		$user = $this->session->userdata();
		$id = anti_inject($this->input->get_post('pengalaman_id'));
		$param['cv_id'] = anti_inject($this->input->get_post('cv_id'));
		$param['pengalaman_tanggal_mulai'] = date('Y-m-d', strtotime($this->input->get_post('pengalaman_tanggal_mulai')));
		$param['pengalaman_tanggal_selesai'] = date('Y-m-d', strtotime($this->input->get_post('pengalaman_tanggal_selesai')));
		$param['pengalaman_unit_kerja'] = anti_inject($this->input->get_post('pengalaman_unit_kerja'));
		$param['pengalaman_grade'] = anti_inject($this->input->get_post('pengalaman_grade'));
		$param['pengalaman_nama'] = anti_inject($this->input->get_post('pengalaman_nama'));
		$param['pengalaman_file'] = anti_inject($this->input->get_post('filerpk'));
		$param['when_create'] = date('Y-m-d H:i:s');
		$param['who_create'] = $user['user_nama_lengkap'];

		$this->M_daftar->editEasyuiRiwayatPengalamanKerja($param, $id);
	}

	public function editEasyuiDataKeluarga()
	{
		$user = $this->session->userdata();
		$id = anti_inject($this->input->get_post('data_keluarga_id'));
		$param['cv_id'] = anti_inject($this->input->get_post('cv_id'));
		$param['data_keluarga_nama'] = anti_inject($this->input->get_post('data_keluarga_nama'));
		$param['data_keluarga_status'] = anti_inject($this->input->get_post('data_keluarga_status'));
		$param['data_keluarga_alamat'] = anti_inject($this->input->get_post('data_keluarga_alamat'));
		$param['when_create'] = date('Y-m-d H:i:s');
		$param['who_create'] = $user['user_nama_lengkap'];

		$this->M_daftar->editEasyuiDataKeluarga($param, $id);
	}
	// finish edit


	// start delete
	public function deleteEasyuiRiwayatPendidikanFormal()
	{
		$id = anti_inject_replace($this->input->get_post('pendidikan_formal_id'));
		$this->M_daftar->deleteEasyuiRiwayatPendidikanFormal($id);
	}
	public function deleteEasyuiRiwayatPendidikanNonFormal()
	{
		$id = anti_inject_replace($this->input->get_post('pendidikan_non_formal_id'));
		$this->M_daftar->deleteEasyuiRiwayatPendidikanNonFormal($id);
	}
	public function deleteEasyuiRiwayatJabatan()
	{
		$id = anti_inject_replace($this->input->get_post('jabatan_id'));
		$this->M_daftar->deleteEasyuiRiwayatJabatan($id);
	}
	public function deleteEasyuiKompetensi()
	{
		$id = anti_inject_replace($this->input->get_post('kompetensi_id'));
		$this->M_daftar->deleteEasyuiKompetensi($id);
	}
	public function deleteEasyuiPenilaianKerja()
	{
		$id = anti_inject_replace($this->input->get_post('penilaian_kerja_id'));
		$this->M_daftar->deleteEasyuiPenilaianKerja($id);
	}
	public function deleteEasyuiPenugasanInternal()
	{
		$id = anti_inject_replace($this->input->get_post('penugasan_internal_id'));
		$this->M_daftar->deleteEasyuiPenugasanInternal($id);
	}
	public function deleteEasyuiRiwayatPengalamanKerja()
	{
		$id = anti_inject_replace($this->input->get_post('pengalaman_id'));
		$this->M_daftar->deleteEasyuiRiwayatPengalamanKerja($id);
	}
	public function deleteEasyuiDataKeluarga()
	{
		$id = anti_inject_replace($this->input->get_post('data_keluarga_id'));
		$this->M_daftar->deleteEasyuiDataKeluarga($id);
	}
	// finisg delete

	// end easy ui
}
