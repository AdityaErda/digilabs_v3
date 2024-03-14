<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Aset extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();

		isLogin();
		$this->load->model('master/M_material_aset');
		$this->load->model('master/M_sample_peminta_jasa');
	}

	/* INDEX */
	public function index()
	{
		$isi['judul'] = 'Aset';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

		$this->load->view('tampilan/header', $isi);
		$this->load->view('tampilan/sidebar', $data);
		$this->load->view('master/aset');
		$this->load->view('tampilan/footer');
		$this->load->view('master/aset_js');
	}
	/* INDEX */

	/* GET */
	public function getAset()
	{
		$param['aset_id'] = $this->input->get('aset_id');
		$param['tahun'] = $this->input->get('tahun');

		$data = $this->M_material_aset->getAset($param);
		echo json_encode($data);
	}
	/* GET */

	/* INSERT */
	public function insertAset()
	{
		$isi = $this->session->userdata();

		if (isset($_FILES['aset_foto'])) {
			$upload_path = FCPATH . './document/';
			if (!file_exists($upload_path)) mkdir($upload_path);
			$allowed_mime_type_arr = array('image/jpeg', 'image/png', 'image/gif', 'image/bmp');
			$mime = get_mime_by_extension($_FILES['aset_foto']['name']);
			if (isset($_FILES['aset_foto']['name']) && $_FILES['aset_foto']['name'] != "") {
				if (in_array($mime, $allowed_mime_type_arr)) {
					/*upload excelnya*/
					$tmpName = $_FILES['aset_foto']['tmp_name'];
					$fileName = $_FILES['aset_foto']['name'];
					$fileType = $_FILES['aset_foto']['type'];

					$acak = rand(11111111, 99999999);
					$fileExt = substr($fileName, strpos($fileName, '.'));
					$fileExt = str_replace('.', '', $fileExt); // Extension
					$fileName = preg_replace("/\.[^.\s]{3,4}$/", "", $fileName);
					$newFileName = $fileName . str_replace(' ', '', $acak . '_' . date('ymdhis') . '.' . $fileExt);
					move_uploaded_file($tmpName, $upload_path . $newFileName);
				} else {
					echo 0;
					exit;
				}
			}
		} else {
			$newFileName = null;
		}

		if ($newFileName) {
			echo 1;
		}

		$data['aset_id'] = anti_inject($this->input->post('aset_id'));
		$data['aset_umur'] = anti_inject($this->input->post('aset_umur'));
		$data['aset_nomor_utama'] = anti_inject($this->input->post('aset_nomor_utama'));
		$data['aset_nama'] = anti_inject($this->input->post('aset_nama'));
		$data['aset_tahun_perolehan'] = date('Y-m-d', strtotime($this->input->post('aset_tahun_perolehan')));
		$data['aset_nilai_perolehan'] = anti_inject($this->input->post('aset_nilai_perolehan'));
		$data['aset_penyusutan_thn_lalu'] = anti_inject($this->input->post('aset_penyusutan_thn_lalu'));
		$data['aset_penyusutan_thn_ini'] = anti_inject($this->input->post('aset_penyusutan_thn_ini'));
		$data['aset_total_penyusutan'] = anti_inject($this->input->post('aset_total_penyusutan'));
		$data['aset_nilai_buku'] = anti_inject($this->input->post('aset_nilai_buku'));
		$data['aset_umur_ekonomis'] = anti_inject($this->input->post('aset_umur_ekonomis'));
		$data['aset_residu'] = anti_inject($this->input->post('aset_residu'));
		$data['is_aset'] = ($this->input->post('is_aset')) ? anti_inject($this->input->post('is_aset')) : 'n';
		$data['aset_foto'] = $newFileName;
		$data['aset_jumlah'] = 0;
		$data['when_create'] = date('Y-m-d H:i:s');
		$data['who_create'] = $isi['user_nama_lengkap'];

		$this->M_material_aset->insertAset($data);
	}
	/* INSERT */

	/* UPDATE */
	public function updateAset()
	{
		$isi = $this->session->userdata();

		if (isset($_FILES['aset_foto'])) {
			$upload_path = FCPATH . './document/';
			if (!file_exists($upload_path)) mkdir($upload_path);
			$allowed_mime_type_arr = array('image/jpeg', 'image/png', 'image/gif', 'image/bmp');
			$mime = get_mime_by_extension($_FILES['aset_foto']['name']);
			if (isset($_FILES['aset_foto']['name']) && $_FILES['aset_foto']['name'] != "") {
				if (in_array($mime, $allowed_mime_type_arr)) {
					/*upload excelnya*/
					$tmpName = $_FILES['aset_foto']['tmp_name'];
					$fileName = $_FILES['aset_foto']['name'];
					$fileType = $_FILES['aset_foto']['type'];

					$acak = rand(11111111, 99999999);
					$fileExt = substr($fileName, strpos($fileName, '.'));
					$fileExt = str_replace('.', '', $fileExt); // Extension
					$fileName = preg_replace("/\.[^.\s]{3,4}$/", "", $fileName);
					$newFileName = $fileName . str_replace(' ', '', $acak . '_' . date('ymdhis') . '.' . $fileExt);
					move_uploaded_file($tmpName, $upload_path . $newFileName);
				} else {
					echo 0;
					exit;
				}
			}
		} else {
			$newFileName = null;
		}

		if ($newFileName) {
			echo 1;
		}

		$id = anti_inject($this->input->post('aset_id'));

		if ($newFileName == null) {
			$data = array(
				'aset_umur' => anti_inject($this->input->post('aset_umur')),
				'aset_nomor_utama' => anti_inject($this->input->post('aset_nomor_utama')),
				'aset_nama' => anti_inject($this->input->post('aset_nama')),
				'aset_tahun_perolehan' => anti_inject($this->input->post('aset_tahun_perolehan')),
				'aset_nilai_perolehan' => anti_inject($this->input->post('aset_nilai_perolehan')),
				'aset_penyusutan_thn_lalu' => anti_inject($this->input->post('aset_penyusutan_thn_lalu')),
				'aset_penyusutan_thn_ini' => anti_inject($this->input->post('aset_penyusutan_thn_ini')),
				'aset_total_penyusutan' => anti_inject($this->input->post('aset_total_penyusutan')),
				'aset_nilai_buku' => anti_inject($this->input->post('aset_nilai_buku')),
				'aset_umur_ekonomis' => anti_inject($this->input->post('aset_umur_ekonomis')),
				'aset_residu' => anti_inject($this->input->post('aset_residu')),
				'is_aset' => ($this->input->post('is_aset')) ? anti_inject($this->input->post('is_aset')) : 'n',
				'when_create' => date('Y-m-d H:i:s'),
				'who_create' => $isi['user_nama_lengkap'],
			);
		} else {
			$data = array(
				'aset_umur' => anti_inject($this->input->post('aset_umur')),
				'aset_nomor_utama' => anti_inject($this->input->post('aset_nomor_utama')),
				'aset_nama' => anti_inject($this->input->post('aset_nama')),
				'aset_tahun_perolehan' => anti_inject($this->input->post('aset_tahun_perolehan')),
				'aset_nilai_perolehan' => anti_inject($this->input->post('aset_nilai_perolehan')),
				'aset_penyusutan_thn_lalu' => anti_inject($this->input->post('aset_penyusutan_thn_lalu')),
				'aset_penyusutan_thn_ini' => anti_inject($this->input->post('aset_penyusutan_thn_ini')),
				'aset_total_penyusutan' => anti_inject($this->input->post('aset_total_penyusutan')),
				'aset_nilai_buku' => anti_inject($this->input->post('aset_nilai_buku')),
				'aset_umur_ekonomis' => anti_inject($this->input->post('aset_umur_ekonomis')),
				'aset_residu' => anti_inject($this->input->post('aset_residu')),
				'is_aset' => ($this->input->post('is_aset')) ? anti_inject($this->input->post('is_aset')) : 'n',
				'aset_foto' => $newFileName,
				'when_create' => date('Y-m-d H:i:s'),
				'who_create' => $isi['user_nama_lengkap'],
			);
		}

		$this->M_material_aset->updateAset($data, $id);
	}
	/* UPDATE */

	/* DELETE */
	public function deleteAset()
	{
		$this->M_material_aset->deleteAset($this->input->get('aset_id'));
	}

	public function resetAset()
	{
		$this->M_material_aset->resetAset();
	}
	/* DELETE */

	/* GET DETAIL */
	public function getAsetDetail()
	{
		$param = array();

		if ($this->input->get('aset_id')) $param['aset_id'] = $this->input->get('aset_id');
		if ($this->input->get('aset_detail_id')) $param['aset_detail_id'] = $this->input->get('aset_detail_id');

		$data = $this->M_material_aset->getAsetDetail($param);
		echo json_encode($data);
	}

	public function getPemintaJasa()
	{
		$listPemintaJasa['results'] = array();

		$param['peminta_jasa_nama'] = $this->input->get('peminta_jasa_nama');
		foreach ($this->M_sample_peminta_jasa->getPemintaJasa($param) as $key => $value) {
			array_push($listPemintaJasa['results'], [
				'id' => $value['peminta_jasa_id'],
				'text' => $value['peminta_jasa_nama'],
			]);
		}

		echo json_encode($listPemintaJasa);
	}
	/* GET DETAIL */

	/* INSERT DETAIL */
	public function insertAsetDetail()
	{
		$isi = $this->session->userdata();

		$data['aset_detail_id'] = create_id();
		$data['aset_id'] = anti_inject($this->input->post('temp_aset_id_detail'));
		$data['aset_nomor'] = anti_inject($this->input->post('aset_nomor'));
		$data['aset_detail_merk'] = anti_inject($this->input->post('aset_detail_merk'));
		$data['peminta_jasa_id'] = anti_inject($this->input->post('peminta_jasa_id'));
		$data['when_create'] = date('Y-m-d H:i:s');
		$data['who_create'] = $isi['user_nama_lengkap'];

		$this->M_material_aset->insertAsetDetail($data);

		$this->fun_jumlah($this->input->post('temp_aset_id_detail'));
	}
	/* INSERT DETAIL */

	/* UPDATE DETAIL */
	public function updateAsetDetail()
	{
		$id = anti_inject($this->input->post('aset_detail_id'));
		$data = array(
			'aset_id' => anti_inject($this->input->post('temp_aset_id_detail')),
			'aset_nomor' => anti_inject($this->input->post('aset_nomor')),
			'aset_detail_merk' => anti_inject($this->input->post('aset_detail_merk')),
			'peminta_jasa_id' => anti_inject($this->input->post('peminta_jasa_id')),
		);

		$this->M_material_aset->updateAsetDetail($data, $id);

		$this->fun_jumlah($this->input->post('temp_aset_id'));
	}
	/* UPDATE DETAIL */

	/* DELETE DETAIL */
	public function deleteAsetDetail()
	{
		$isi = $this->session->userdata();

		$param['aset_detail_id'] = $this->input->get('aset_detail_id');
		$data = $this->M_material_aset->getAsetDetail($param);

		$id = $this->input->get('aset_detail_id');
		$data_isi = array(
			'is_aktif' => 'n',
			'when_create' => date('Y-m-d H:i:s'),
			'who_create' => $isi['user_nama_lengkap'],
		);

		$this->M_material_aset->deleteAsetDetail($data_isi, $id);

		$this->fun_jumlah($data['aset_id']);
	}
	/* DELETE DETAIL */

	/* FUN TAMBAHAN */
	public function fun_jumlah($id)
	{
		$param['aset_id'] = $id;
		$isi = $this->M_material_aset->getJumlahAsetDetail($param);

		$data = array(
			'aset_jumlah' => $isi['total'],
		);

		$this->M_material_aset->updateAset($data, $id);
	}
	/* FUN TAMBAHAN */

	/* GET DOCUMENT */
	public function getAsetDocument()
	{
		$param = array();

		if ($this->input->get('aset_id')) $param['aset_id'] = $this->input->get('aset_id');
		if ($this->input->get('aset_document_id')) $param['aset_document_id'] = $this->input->get('aset_document_id');

		$data = $this->M_material_aset->getAsetDocument($param);
		echo json_encode($data);
	}
	/* GET DOCUMENT */

	/* INSERT DOCUMENT */
	public function insertAsetDocument()
	{
		$data['aset_document_id'] = create_id();
		$data['aset_id'] = anti_inject($this->input->post('aset_id'));
		$data['aset_document_nama'] = anti_inject($this->input->post('aset_document_nama'));
		$data['aset_document_file'] = anti_inject($this->input->post('savedFileName'));

		$this->M_material_aset->insertAsetDocument($data);
	}

	public function insertAsetDocumentFile()
	{

		if (isset($_FILES['file'])) {
			$upload_path = FCPATH . './document/';
			if (!file_exists($upload_path)) mkdir($upload_path);
			$allowed_mime_type_arr = array('application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'text/plain', 'application/pdf', 'image/jpeg', 'image/png', 'image/gif', 'image/bmp');
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
					$newFileName = $fileName . str_replace(' ', '', $acak . '_' . date('ymdhis') . '.' . $fileExt);
					move_uploaded_file($tmpName, $upload_path . $newFileName);
					echo $newFileName;
				} else {

					exit;
				}
			}
		} else {
			$newFileName = null;
		}
	}
	/* INSERT DOCUMENT */

	/* UPDATE DOCUMENT */
	public function updateAsetDocument()
	{
		$id = anti_inject($this->input->post('aset_document_id'));
		$data = array(
			'aset_id' => anti_inject($this->input->post('aset_id')),
			'aset_document_nama' => anti_inject($this->input->post('aset_document_nama')),
		);

		$this->M_material_aset->updateAsetDocument($data, $id);
	}
	/* UPDATE DOCUMENT */

	/* DELETE DOCUMENT */
	public function deleteAsetDocument()
	{
		$this->M_material_aset->deleteAsetDocument($this->input->post('aset_document_id'));
	}
	/* DELETE DOCUMENT */

	/* GET DOWNLOAD */
	public function getAsetDownload()
	{
		$param = array();

		if ($this->input->get('aset_id')) $param['aset_id'] = $this->input->get('aset_id');
		if ($this->input->get('aset_detail_id')) $param['aset_detail_id'] = $this->input->get('aset_detail_id');

		$data = $this->M_material_aset->getAsetDownload($param);
		echo json_encode($data);
	}
	/* GET DOWNLOAD */

	/* INDEX IMPORT */
	public function index_import()
	{
		$isi['judul'] = 'Import Aset';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

		$this->load->view('tampilan/header', $isi);
		$this->load->view('tampilan/sidebar', $data);
		$this->load->view('master/aset_import');
		$this->load->view('tampilan/footer');
		$this->load->view('master/aset_import_js');
	}
	/* INDEX IMPORT */

	/* GET IMPORT */
	public function getImport()
	{
		$param['import_kode'] = $this->input->get('import_kode');

		$data = $this->M_material_aset->getImport($param);
		echo json_encode($data);
	}
	/* GET IMPORT */

	/* INSERT IMPORT */
	public function insertImport()
	{
		ini_set('display_errors', 1);
		error_reporting(E_ALL);
		$data_session = $this->session->userdata();
		$config = array(
			'upload_path'   => FCPATH . '/upload/',
			'allowed_types' => 'xls|csv'
		);

		$this->upload->initialize($config);

		if ($this->upload->do_upload('file_import')) {
			$data = $this->upload->data();
			@chmod($data['full_path'], 0777);

			$this->load->library('Spreadsheet_Excel_Reader');
			$this->spreadsheet_excel_reader->setOutputEncoding('CP1251');
			$this->db->db_set_charset('latin1', 'latin1_swedish_ci');

			$this->spreadsheet_excel_reader->read($data['full_path']);
			$sheets = $this->spreadsheet_excel_reader->sheets[0];


			$data_excel = array();
			$id = create_id();
			for ($i = 2; $i <= $sheets['numRows']; $i++) {
				if ($sheets['cells'][$i][1] == '') break;

				$data_excel[$i - 1]['import_kode']    = $id;
				$data_excel[$i - 1]['aset_id']    = create_id();
				$data_excel[$i - 1]['aset_nama']  = $sheets['cells'][$i][1];
				$data_excel[$i - 1]['aset_umur']  = $sheets['cells'][$i][2];
				$data_excel[$i - 1]['aset_tahun_perolehan']  = $sheets['cells'][$i][3];
				$data_excel[$i - 1]['aset_nilai_perolehan']  = $sheets['cells'][$i][4];
				$data_excel[$i - 1]['aset_penyusutan_thn_lalu']  = $sheets['cells'][$i][5];
				$data_excel[$i - 1]['aset_penyusutan_thn_ini']  = $sheets['cells'][$i][6];
				$data_excel[$i - 1]['aset_total_penyusutan']  = $sheets['cells'][$i][7];
				$data_excel[$i - 1]['aset_nilai_buku']  = $sheets['cells'][$i][8];
				$data_excel[$i - 1]['aset_serial']  = $sheets['cells'][$i][9];
				$data_excel[$i - 1]['is_aset']  = $sheets['cells'][$i][10];
				$data_excel[$i - 1]['when_create']  = date('Y-m-d H:i:s');
				$data_excel[$i - 1]['who_create']  = $data_session['user_nama_lengkap'];
			}

			$this->db->insert_batch('import.import_material_aset', $data_excel);

			header("Location: " . base_url('master/aset/index_import?header_menu=0&menu_id=0&import_kode=' . $id));
		} else {
			$error = $this->upload->display_errors();
			print_r($error);
		}
	}

	public function insertTable()
	{
		$param['import_kode'] = $this->input->get('import_kode');
		$this->M_material_aset->insertTable($param);
		$this->M_material_aset->deleteTable($this->input->get('import_kode'));

		header("Location: " . base_url('master/aset/index?header_menu=0&menu_id=0'));
	}
	/* INSERT IMPORT */

	/* INDEX IMPORT DETAIL */
	public function index_import_detail()
	{
		$isi['judul'] = 'Import Aset Detail';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

		$this->load->view('tampilan/header', $isi);
		$this->load->view('tampilan/sidebar', $data);
		$this->load->view('master/aset_detail_import');
		$this->load->view('tampilan/footer');
		$this->load->view('master/aset_detail_import_js');
	}
	/* INDEX IMPORT DETAIL */

	/* GET IMPORT DETAIL */
	public function getImportDetail()
	{
		$param['import_kode'] = $this->input->get('import_kode');

		$data = $this->M_material_aset->getImportDetail($param);
		echo json_encode($data);
	}
	/* GET IMPORT DETAIL */

	/* INSERT IMPORT */
	public function insertImportDetail()
	{
		$data_session = $this->session->userdata();

		$config = array(
			'upload_path'   => FCPATH . 'upload/',
			'allowed_types' => 'xls|csv'
		);
		$this->load->library('upload', $config);
		if ($this->upload->do_upload('file')) {
			$data = $this->upload->data();
			@chmod($data['full_path'], 0777);

			$this->load->library('Spreadsheet_Excel_Reader');
			$this->spreadsheet_excel_reader->setOutputEncoding('CP1251');
			$this->db->db_set_charset('latin1', 'latin1_swedish_ci');

			$this->spreadsheet_excel_reader->read($data['full_path']);
			$sheets = $this->spreadsheet_excel_reader->sheets[0];
			error_reporting(0);

			$data_excel = array();
			$id = create_id();
			for ($i = 2; $i <= $sheets['numRows']; $i++) {
				if ($sheets['cells'][$i][1] == '') break;

				$param_aset['aset_nomor_utama'] = $sheets['cells'][$i][1];
				$param_aset['is_aset'] = $sheets['cells'][$i][2];
				if ($param_aset['is_aset'] == 'Aset') {
					$param_aset['is_aset'] = 'y';
				} else if ($param_aset['is_aset'] == 'Non Aset') {
					$param_aset['is_aset'] = 'n';
				}

				$param_aktif['is_aktif'] = $sheets['cells'][$i][7];
				if ($param_aktif['is_aktif'] == 'Aktif') {
					$aktif = 'y';
				} else if ($param_aktif['is_aktif'] == 'Non AKtif') {
					$aktif = 'n';
				}

				$param_aset['aset_nama_import'] = $sheets['cells'][$i][3];
				$isiAset = $this->M_material_aset->getAset($param_aset);
				// echo $this->db->last_query();
				// print_r($param_aset);

				$param_pengelola['peminta_jasa_nama_import'] = $sheets['cells'][$i][6];
				$isiPengelola = $this->M_sample_peminta_jasa->getPemintaJasa($param_pengelola);
				// print_r($param_pengelola);
				// echo ;



				$data_excel[$i - 1]['import_kode'] = $id;
				$data_excel[$i - 1]['aset_detail_id'] = create_id();
				$data_excel[$i - 1]['aset_id'] = $isiAset[0]['aset_id'];
				$data_excel[$i - 1]['aset_detail_merk'] = $sheets['cells'][$i][4];
				$data_excel[$i - 1]['aset_nomor'] = $sheets['cells'][$i][5];
				$data_excel[$i - 1]['peminta_jasa_id'] = $isiPengelola[0]['peminta_jasa_id'];
				$data_excel[$i - 1]['is_aktif'] = $aktif;
				$data_excel[$i - 1]['when_create']  = date('Y-m-d H:i:s');
				$data_excel[$i - 1]['who_create']  = $data_session['user_nama_lengkap'];
			}

			$this->db->insert_batch('import.import_material_aset_detail', $data_excel);

			header("Location: " . base_url('master/aset/index_import_detail?header_menu=0&menu_id=0&import_kode=' . $id));
		}
	}

	public function insertTableDetail()
	{
		$param['import_kode'] = $this->input->get('import_kode');

		foreach ($this->M_material_aset->getImportDetail($param) as $value) {
			$param['aset_id'] = $value['aset_id'];
			$this->M_material_aset->insertTableDetail($param);
			// echo $this->db->last_query();
			// print_r($param);
		}


		// $this->M_material_aset->insertTableDetail($param);
		// echo $this->db->last_query();

		foreach ($this->M_material_aset->getImportDetail($param) as $value) {
			$this->fun_jumlah($value['aset_id']);
		}

		$this->M_material_aset->deleteTableDetail($this->input->get('import_kode'));

		header("Location: " . base_url('master/aset/index?header_menu=0&menu_id=0'));
	}
	/* INSERT IMPORT */


	/* QRCODE */
	public function printQrcode()
	{
		// $param['aset_detail_id'] = $this->input->get('aset_detail_id');
		// $data_detail = $this->M_material_aset->getAsetDetail($param);

		// $param['aset_id'] = $data_detail['aset_id'];
		// $data = $this->M_material_aset->getAset($param);

		// $data['aset_detail_id'] = $data_detail['aset_detail_id'];
		// $data['aset_nomor'] = $data_detail['aset_nomor'];

		// /* QRCODE */
		// $this->load->library('ciqrcode'); //pemanggilan library QR CODE

		// $config['cacheable']    = true; //boolean, the default is true
		// $config['cachedir']     = './application/cache/'; //string, the default is application/cache/
		// $config['errorlog']     = './application/logs/'; //string, the default is application/logs/
		// $config['imagedir']     = './img/'; //direktori penyimpanan qr code
		// $config['quality']      = true; //boolean, the default is true
		// $config['size']         = '1024'; //interger, the default is 1024
		// $config['black']        = array(224, 255, 255); // array, default is array(255,255,255)
		// $config['white']        = array(70, 130, 180); // array, default is array(0,0,0)
		// $this->ciqrcode->initialize($config);

		// $nim = $param['aset_detail_id'];
		// $image_name = $nim . '.png'; //buat name dari qr code sesuai dengan nim

		// // $url = base_url('master/aset/ResultQrcode/?aset_id_detail=' . $param['aset_detail_id']);
		// $url = 'cobajhsbugerbdfgubbdj';

		// $params['data'] = $url; //data yang akan di jadikan QR CODE
		// $params['level'] = 'H'; //H=High
		// $params['size'] = 10;
		// $params['savename'] = FCPATH . $config['imagedir'] . $image_name; //simpan image QR CODE ke folder assets/images/
		// $this->ciqrcode->generate($params);
		// /* QRCODE */

		// $this->load->view('master/print_qrcode', $data);

		$param['aset_detail_id'] = $this->input->get('aset_detail_id');
		$data_detail = $this->M_material_aset->getAsetDetail($param);

		$param['aset_id'] = $data_detail['aset_id'];
		$data = $this->M_material_aset->getAset($param);

		$data['aset_detail_id'] = $data_detail['aset_detail_id'];
		$data['aset_nomor'] = $data_detail['aset_nomor'];

		//load library
		$this->load->library('zend');
		//load in folder Zend
		$this->zend->load('Zend/Barcode');
		//generate barcode
		$imageResource = Zend_Barcode::factory('code128', 'image', array('text' => $data_detail['aset_nomor'], 'drawText' => false), array())->draw();
		imagepng($imageResource, './img/' . $data_detail['aset_nomor'] . '.png');

		$this->load->view('master/print_qrcode', $data);
	}
	/* QRCODE */

	/* Hasil Scan QRCODE */

	public function ResultQrcode()
	{
		$this->load->view('master/result_qrcode', $data);
		$this->load->view('master/result_qrcode_js');
	}
	/* Hasil Scan QRCODE */

	/* Ambil data qrcode */
	public function getResultQrcode()
	{
		$param['aset_detail_id'] = $this->input->get('aset_detail_id');
		$data_detail = $this->M_material_aset->getAsetDetail($param);

		$param['aset_id'] = $data_detail['aset_id'];
		$data = $this->M_material_aset->getAset($param);

		$data['aset_detail_id'] = $data_detail['aset_detail_id'];
		$data['aset_nomor'] = $data_detail['aset_nomor'];

		echo json_encode($data);
	}
	/* Ambil data qrcode */
}
