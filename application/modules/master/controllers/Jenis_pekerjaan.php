<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jenis_pekerjaan extends MY_Controller{

	public function __construct(){
		parent::__construct();

		$this->load->model('master/M_sample_pekerjaan');
	}

	/* INDEX */
	public function index(){
		$isi['judul'] = 'Jenis Pekerjaan';
		$data = $this->session->userdata();
		$data['id_sidebar'] = anti_inject_replace($this->input->get('id_sidebar'));
		$data['id_sidebar_detail'] = anti_inject_replace($this->input->get('id_sidebar_detail'));

		$this->template->template_master('master/jenis_pekerjaan',$isi,$data);
	}
	/* INDEX */

	/* GET */
	public function getJenisPekerjaan(){
		$param = [];
		if ($this->input->get('sample_pekerjaan_id')) {
			$param['sample_pekerjaan_id'] = anti_inject_replace($this->input->get('sample_pekerjaan_id'));
		}
		if ($this->input->get_post('q')) {
			$param['sample_pekerjaan_nama'] = anti_inject_replace($this->input->get_post('q'));
		}

		$data = $this->M_sample_pekerjaan->getJenisPekerjaan($param);

		echo json_encode($data);
	}
	/* GET */

	/* INSERT */
	public function insertJenisPekerjaan(){
		$isi = $this->session->userdata();

		$data['sample_pekerjaan_id'] = create_id();
		$data['sample_pekerjaan_kode'] = anti_inject($this->input->post('sample_pekerjaan_kode'));
		$data['sample_pekerjaan_nama'] = anti_inject($this->input->post('sample_pekerjaan_nama'));
		$data['when_create'] = date('Y-m-d H:i:s');
		$data['who_create'] = $isi['user_nama_lengkap'];

		$this->M_sample_pekerjaan->insertJenisPekerjaan($data);
	}
	/* INSERT */

	/* UPDATE */
	public function updateJenisPekerjaan(){
		$isi = $this->session->userdata();

		$id = anti_inject($this->input->post('sample_pekerjaan_id'));
		$data = array(
			'sample_pekerjaan_kode' => anti_inject($this->input->post('sample_pekerjaan_kode')),
			'sample_pekerjaan_nama' => anti_inject($this->input->post('sample_pekerjaan_nama')),
			'when_create' => date('Y-m-d H:i:s'),
			'who_create' => $isi['user_nama_lengkap'],
		);

		$this->M_sample_pekerjaan->updateJenisPekerjaan($data, $id);
	}
	/* UPDATE */

	/* DELETE */
	public function deleteJenisPekerjaan(){
		$this->M_sample_pekerjaan->deleteJenisPekerjaan(anti_inject_replace($this->input->get('sample_pekerjaan_id')));
	}

	public function resetJenisPekerjaan(){
		$this->M_sample_pekerjaan->resetJenisPekerjaan();
	}
	/* DELETE */

	/* INDEX IMPORT */
	public function index_import(){
		$isi['judul'] = 'Import Sample Pekerjaan';
		$data = $this->session->userdata();
		$data['id_sidebar'] = anti_inject_replace($this->input->get('id_sidebar'));
		$data['id_sidebar_detail'] = anti_inject_replace($this->input->get('id_sidebar_detail'));

		$this->template->template_master('master/jenis_pekerjaan_import',$isi,$data);
	}
	/* INDEX IMPORT */

	/* GET IMPORT */
	public function getImport(){
		$param['import_kode'] = anti_inject_replace($this->input->get('import_kode'));

		$data = $this->M_sample_pekerjaan->getImport($param);
		echo json_encode($data);
	}
	/* GET IMPORT */

	/* INSERT IMPORT */
	public function insertImport(){

		error_reporting(0);
		$data_session = $this->session->userdata();
		$upload_path = FCPATH . './upload/';
		/*ekstensi file yang diperbolehkan*/
		$allowed_mime_type_arr = array('application/vnd.ms-excel');
		$mime = get_mime_by_extension($_FILES['file']['name']);
		if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != "") {
			if (in_array($mime, $allowed_mime_type_arr)) {
				/*upload excelnya*/
				$excelTmp = $_FILES['file']['tmp_name'];
				$excelName = $_FILES['file']['name'];
				$excelType = $_FILES['file']['type'];

				$acak = rand(11111111, 99999999);
				$excelExt = substr($excelName, strrpos($excelName, '.'));
				$excelExt = str_replace('.', '', $excelExt); // Extension
				$excelName = preg_replace("/\.[^.\s]{3,4}$/", "", $excelName);
				$NewExcelName = $excelName . str_replace(' ', '', $acak . '_' . date('ymdhis') . '.' . $excelExt);
				move_uploaded_file($_FILES["file"]["tmp_name"], $upload_path . $NewExcelName);
				/*upload excelnya*/

				/*proses excelnya*/
				$this->load->library('Spreadsheet_Excel_Reader');
				$this->spreadsheet_excel_reader->setOutputEncoding('CP1251');
				$this->db->db_set_charset('latin1', 'latin1_swedish_ci');
				$this->spreadsheet_excel_reader->read($upload_path . $NewExcelName);
				$sheets = $this->spreadsheet_excel_reader->sheets[0];
				/*proses excelnya*/

				$data_excel = array();
				$id = create_id();
				for ($i = 2; $i <= $sheets['numRows']; $i++) {
					if ($sheets['cells'][$i][1] == '') break;

					$data_excel[$i - 1]['import_kode']    = $id;
					$data_excel[$i - 1]['sample_pekerjaan_id']    = create_id();
					$data_excel[$i - 1]['sample_pekerjaan_kode']  = $sheets['cells'][$i][1];
					$data_excel[$i - 1]['sample_pekerjaan_nama']  = $sheets['cells'][$i][2];
					$data_excel[$i - 1]['when_create']  = date('Y-m-d H:i:s');
					$data_excel[$i - 1]['who_create']  = $data_session['user_nama_lengkap'];
				}

				$this->db->insert_batch('import.import_sample_pekerjaan', $data_excel);

				header("Location: " . base_url('master/jenis_pekerjaan/index_import?header_menu=0&menu_id=0&import_kode=' . $id));
			}
		}
	}

	public function insertTable(){
		$param['import_kode'] = anti_inject_replace($this->input->get('import_kode'));
		$this->M_sample_pekerjaan->insertTable($param);
		$this->M_sample_pekerjaan->deleteTable(anti_inject_replace($this->input->get('import_kode')));

		header("Location: " . base_url('master/jenis_pekerjaan/index?header_menu=0&menu_id=0'));
	}
	/* INSERT IMPORT */
}
