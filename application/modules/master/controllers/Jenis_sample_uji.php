<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jenis_sample_uji extends MY_Controller{

	public function __construct(){
		parent::__construct();

		$this->load->model('master/M_sample_jenis');
	}

	/* INDEX */
	public function index(){
		$isi['judul'] = 'Jenis Sample Uji';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

		$this->template->template_master('master/jenis_sample_uji',$isi,$data);
	}
	/* INDEX */

	/* GET */
	public function getJenisSampleUji(){
		$param['jenis_id'] = $this->input->get('jenis_id');
		$param['jenis_nama'] = $this->input->get_post('q');

		$data = $this->M_sample_jenis->getJenisSampleUji($param);
		echo json_encode($data);
	}
	/* GET */

	/* INSERT */
	public function insertJenisSampleUji(){
		$isi = $this->session->userdata();

		$data['jenis_id'] = create_id();
		$data['jenis_kode'] = $this->input->post('jenis_kode');
		$data['jenis_nama'] = $this->input->post('jenis_nama');
		$data['jenis_parameter'] = $this->input->post('jenis_parameter');
		$data['pengambil_sample'] = $this->input->post('pengambil_sample');
		$data['referensi_spesifikasi'] = $this->input->post('referensi_spesifikasi');
		$data['when_create'] = date('Y-m-d H:i:s');
		$data['who_create'] = $isi['user_nama_lengkap'];

		$this->M_sample_jenis->insertJenisSampleUji($data);
	}
	/* INSERT */

	/* UPDATE */
	public function updateJenisSampleUji(){
		$isi = $this->session->userdata();

		$id = $this->input->post('jenis_id');
		$data = array(
			'jenis_kode' => $this->input->post('jenis_kode'),
			'jenis_nama' => $this->input->post('jenis_nama'),
			'jenis_parameter' => $this->input->post('jenis_parameter'),
			'pengambil_sample' => $this->input->post('pengambil_sample'),
			'referensi_spesifikasi' => $this->input->post('referensi_spesifikasi'),
			'when_create' => date('Y-m-d H:i:s'),
			'who_create' => $isi['user_nama_lengkap'],
		);

		$this->M_sample_jenis->updateJenisSampleUji($data, $id);
	}
	/* UPDATE */

	/* DELETE */
	public function deleteJenisSampleUji(){
		$this->M_sample_jenis->deleteJenisSampleUji($this->input->get('jenis_id'));
	}

	public function resetJenisSampleUji(){
		$this->M_sample_jenis->resetJenisSampleUji();
	}
	/* DELETE */

	/* GET DETAIL */
	public function getSampleIdentitas(){
		$param = array();

		if ($this->input->get('jenis_id')) $param['jenis_id'] = $this->input->get('jenis_id');
		if ($this->input->get('identitas_id')) $param['identitas_id'] = $this->input->get('identitas_id');
		if ($this->input->post('q')) $param['identitas_nama'] = $this->input->post('q');

		$data = $this->M_sample_jenis->getSampleIdentitas($param);
		echo json_encode($data);
	}
	/* GET DETAIL */

	/* INSERT DETAIL */
	public function insertSampleIdentitas(){
		$isi = $this->session->userdata();

		$data['identitas_id'] = create_id();
		$data['jenis_id'] = $this->input->post('temp_jenis_id');
		$data['identitas_nama'] = $this->input->post('identitas_nama');
		$data['identitas_parameter'] = $this->input->post('identitas_parameter');
		$data['identitas_harga'] = $this->input->post('identitas_harga');
		$data['identitas_spesifikasi'] = $this->input->post('identitas_spesifikasi');
		$data['batasan_minimal'] = $this->input->post('batasan_minimal');
		$data['batasan_maksimal'] = $this->input->post('batasan_maksimal');
		$data['when_create'] = date('Y-m-d H:i:s');
		$data['who_create'] = $isi['user_nama_lengkap'];

		$this->M_sample_jenis->insertSampleIdentitas($data);
	}
	/* INSERT DETAIL */

	/* UPDATE DETAIL */
	public function updateSampleIdentitas(){
		$isi = $this->session->userdata();

		$id = $this->input->post('identitas_id');
		$data = array(
			'jenis_id' => $this->input->post('temp_jenis_id'),
			'identitas_nama' => $this->input->post('identitas_nama'),
			'identitas_parameter' => $this->input->post('identitas_parameter'),
			'identitas_harga' => $this->input->post('identitas_harga'),
			'identitas_spesifikasi' => $this->input->post('identitas_spesifikasi'),
			'batasan_minimal' => $this->input->post('batasan_minimal'),
			'batasan_maksimal' => $this->input->post('batasan_maksimal'),
			'when_create' => date('Y-m-d H:i:s'),
			'who_create' => $isi['user_nama_lengkap'],
		);

		$this->M_sample_jenis->updateSampleIdentitas($data, $id);
	}
	/* UPDATE DETAIL */

	/* DELETE DETAIL */
	public function deleteSampleIdentitas(){
		$this->M_sample_jenis->deleteSampleIdentitas($this->input->get('identitas_id'));
	}
	/* DELETE DETAIL */

	/* INDEX IMPORT */
	public function index_import(){
		$isi['judul'] = 'Import Sample Jenis';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

		$this->template->template_master('master/jenis_sample_uji_import',$isi,$data);
	}
	/* INDEX IMPORT */

	/* GET IMPORT */
	public function getImport(){
		$param['import_kode'] = $this->input->get('import_kode');

		$data = $this->M_sample_jenis->getImport($param);

		echo json_encode($data);
	}
	/* GET IMPORT */

	public function insertImport(){
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
				if ($sheets['cells'][$i][3] == '') break;

				$data_excel[$i - 1]['import_kode'] = $id;
				$data_excel[$i - 1]['jenis_id'] = create_id();
				$data_excel[$i - 1]['jenis_kode'] = $sheets['cells'][$i][1];
				$data_excel[$i - 1]['jenis_nama'] = $sheets['cells'][$i][2];
				$data_excel[$i - 1]['jenis_parameter'] = $sheets['cells'][$i][3];
				$data_excel[$i - 1]['pengambil_sample'] = $sheets['cells'][$i][4];
				$data_excel[$i - 1]['when_create']  = date('Y-m-d H:i:s');
				$data_excel[$i - 1]['who_create']  = $data_session['user_nama_lengkap'];
			}

			$this->db->insert_batch('import.import_sample_jenis', $data_excel);

			header("Location: " . base_url('master/jenis_sample_uji/index_import?header_menu=0&menu_id=0&import_kode=' . $id));
		} else {
			$error = $this->upload->display_errors();
			print_r($error);
		}
	}

	public function insertTable(){
		$param['import_kode'] = $this->input->get('import_kode');
		$this->M_sample_jenis->insertTable($param);
		$this->M_sample_jenis->deleteTable($this->input->get('import_kode'));

		header("Location: " . base_url('master/jenis_sample_uji/index?header_menu=0&menu_id=0'));
	}
	/* INSERT IMPORT */

	/* INDEX IMPORT DETAIL */
	public function index_identitas_import(){
		$isi['judul'] = 'Import Identitas';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

		$this->template->template_master('master/jenis_sample_uji_identitas_import',$isi,$data);
	}
	/* INDEX IMPORT DETAIL */

	/* GET IMPORT DETAIL */
	public function getImportIdentitas(){
		$param['import_kode'] = $this->input->get('import_kode');

		$data = $this->M_sample_jenis->getImportIdentitas($param);
		echo json_encode($data);
	}
	/* GET IMPORT DETAIL */

	/* INSERT IMPORT DETAIL */
	public function insertImportIdentitas(){
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

				$param['jenis_nama'] = $sheets['cells'][$i][2];

				$data = $this->M_sample_jenis->getJenisSampleUji($param);

				$data_excel[$i - 1]['import_kode']    = $id;
				$data_excel[$i - 1]['identitas_id']    = create_id();
				$data_excel[$i - 1]['identitas_nama']  = $sheets['cells'][$i][1];
				$data_excel[$i - 1]['jenis_id']  = $data[0]['jenis_id'];
				$data_excel[$i - 1]['identitas_parameter']  = $sheets['cells'][$i][3];
				$data_excel[$i - 1]['identitas_harga']  = $sheets['cells'][$i][4];
				$data_excel[$i - 1]['when_create']  = date('Y-m-d H:i:s');
				$data_excel[$i - 1]['who_create']  = $data_session['user_nama_lengkap'];
			}

			$this->db->insert_batch('import.import_sample_identitas', $data_excel);

			header("Location: " . base_url('master/jenis_sample_uji/index_identitas_import?header_menu=0&menu_id=0&import_kode=' . $id));
		}
	}

	public function insertTableIdentitas(){
		$param_identitas['import_kode'] = $this->input->get('import_kode');

		foreach ($this->M_sample_jenis->getImportIdentitas($param_identitas) as $row) {
			$param_identitas['jenis_id'] = $row['jenis_id'];
			// print_r($param_identitas);
			$this->M_sample_jenis->insertTableIdentitas($param_identitas);
			// echo $this->db->last_query();
		}
		// $this->M_sample_jenis->insertTableIdentitas($param);

		$this->M_sample_jenis->deleteTableIdentitas($this->input->get('import_kode'));

		header("Location: " . base_url('master/jenis_sample_uji/index?header_menu=0&menu_id=0'));
	}
	/* INSERT IMPORT DETAIL */

	// UPDATE RUMUS
	public function updateRumus(){
		$id = htmlentities($this->input->get_post('identitas_id_rumus'));
		$param['identitas_harga'] = htmlentities($this->input->get_post('identitas_harga_rumus'));
		$param['identitas_jumlah_tenaga_kerja'] = htmlentities($this->input->get_post('identitas_jumlah_tenaga_kerja_rumus'));
		$param['identitas_harga_tambahan'] = htmlentities($this->input->get_post('identitas_harga_tambahan_rumus'));
		$param['identitas_harga_total'] = (htmlentities($param['identitas_harga']) * htmlentities($param['identitas_jumlah_tenaga_kerja'])) + htmlentities($param['identitas_harga_tambahan']);

		$this->M_sample_jenis->updateRumus($id, $param);
	}
	// UPDATE RUMUS

	// cetak rumus
	public function cetakRumus(){
		$data['session'] = $this->session->userdata();
		$data['judul'] = 'Cetak Rumus';

		// $dataX = [];

		$jenis = $this->M_sample_jenis->getJenisSampleUji();
		$data['rumus'] = $jenis;

		$this->load->view('master/cetak_rumus_uji', $data, FALSE);

	}
	// cetak rumus

	// TAMBAHAN
	public function getPengambilList(){
		$pengambil['results'] = array();
		$param['param_search'] = $this->input->get('param_search');
		foreach ($this->M_sample_jenis->getPengambil($param) as $key => $value) {
			array_push($pengambil['results'], [
				'id' => $value['pengambil_sample'],
				'text' => $value['pengambil_sample'],
			]);
		}
		echo json_encode($pengambil);
	}
	// TAMBAHAN
}
