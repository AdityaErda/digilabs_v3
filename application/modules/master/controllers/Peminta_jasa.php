<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Peminta_jasa extends MY_Controller
{

	public function __construct(){
		parent::__construct();

		$this->load->model('master/M_sample_peminta_jasa');
	}

	public function index(){
		$isi['judul'] = 'Peminta Jasa';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

		$this->template->template_master('master/peminta_jasa',$isi,$data);
	}

	/* GET */
	public function getPemintaJasa(){
		$param = [];
		if ($this->input->get('peminta_jasa_id')) {
			$param['peminta_jasa_id'] = $this->input->get('peminta_jasa_id');
		}

		if ($this->input->get_post('q')) {
			$param['peminta_jasa_nama'] = $this->input->get_post('q');
		}

		$data = $this->M_sample_peminta_jasa->getPemintaJasa($param);
		echo json_encode($data);
	}
	/* GET */

	/* INSERT */
	public function insertPemintaJasa(){
		$isi = $this->session->userdata();

		$data['peminta_jasa_id'] = create_id();
		$data['peminta_jasa_kode'] = anti_inject($this->input->post('peminta_jasa_kode'));
		$data['peminta_jasa_nama'] = anti_inject($this->input->post('peminta_jasa_nama'));
		$data['peminta_jasa_ext'] = anti_inject($this->input->post('peminta_jasa_ext'));
		$data['when_create'] = date('Y-m-d H:i:s');
		$data['who_create'] = $isi['user_nama_lengkap'];

		$this->M_sample_peminta_jasa->insertPemintaJasa($data);
	}
	/* INSERT */

	/* UPDATE */
	public function updatePemintaJasa(){
		$isi = $this->session->userdata();

		$id = anti_inject($this->input->post('peminta_jasa_id'));
		$data = array(
			'peminta_jasa_kode' => anti_inject($this->input->post('peminta_jasa_kode')),
			'peminta_jasa_nama' => anti_inject($this->input->post('peminta_jasa_nama')),
			'peminta_jasa_ext' => anti_inject($this->input->post('peminta_jasa_ext')),
			'when_create' => date('Y-m-d H:i:s'),
			'who_create' => $isi['user_nama_lengkap'],
		);

		$this->M_sample_peminta_jasa->updatePemintaJasa($data, $id);
	}
	/* UPDATE */

	/* DELETE */
	public function deletePemintaJasa(){
		$this->M_sample_peminta_jasa->deletePemintaJasa($this->input->get('peminta_jasa_id'));
	}

	public function resetPemintaJasa(){
		$this->M_sample_peminta_jasa->resetPemintaJasa();
	}
	/* DELETE */

	/* INDEX IMPORT */
	public function index_import(){
		$isi['judul'] = 'Import Sample Peminta Jasa';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

		$this->template->template_master('master/peminta_jasa_import',$isi,$data);
	}
	/* INDEX IMPORT */

	/* GET IMPORT */
	public function getImport(){
		$param['import_kode'] = $this->input->get('import_kode');

		$data = $this->M_sample_peminta_jasa->getImport($param);
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
					$data_excel[$i - 1]['peminta_jasa_id']    = create_id();
					$data_excel[$i - 1]['peminta_jasa_kode']  = $sheets['cells'][$i][1];
					$data_excel[$i - 1]['peminta_jasa_nama']  = $sheets['cells'][$i][2];
					$data_excel[$i - 1]['peminta_jasa_ext']  = $sheets['cells'][$i][3];
					$data_excel[$i - 1]['when_create']  = date('Y-m-d H:i:s');
					$data_excel[$i - 1]['who_create']  = $data_session['user_nama_lengkap'];
				}

				$this->db->insert_batch('import.import_sample_peminta_jasa', $data_excel);

				header("Location: " . base_url('master/peminta_jasa/index_import?header_menu=0&menu_id=0&import_kode=' . $id));
			}
		}
	}

	public function insertTable(){
		$param['import_kode'] = $this->input->get('import_kode');
		$this->M_sample_peminta_jasa->insertTable($param);
		$this->M_sample_peminta_jasa->deleteTable($this->input->get('import_kode'));

		header("Location: " . base_url('master/peminta_jasa/index?header_menu=0&menu_id=0'));
	}
	/* INSERT IMPORT */
}
