<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kategori_barang extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('master/M_material_gl_account');
	}

	/* INDEX */
	public function index()
	{
		$isi['judul'] = 'Gl Account';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

		$this->load->view('tampilan/header', $isi);
		$this->load->view('tampilan/sidebar', $data);
		$this->load->view('master/kategori_barang');
		$this->load->view('tampilan/footer');
		$this->load->view('master/kategori_barang_js');
	}
	/* INDEX */

	/* GET */
	public function getGlAccount()
	{
		$param['gl_account_id'] = $this->input->get('gl_account_id');

		$data = $this->M_material_gl_account->getGlAccount($param);
		echo json_encode($data);
	}
	/* GET */

	/* INSERT */
	public function insertGlAccount()
	{
		$isi = $this->session->userdata();

		$data['gl_account_id'] = create_id();
		$data['gl_account_kode'] = anti_inject($this->input->post('gl_account_kode'));
		$data['gl_account_nama'] = anti_inject($this->input->post('gl_account_nama'));
		$data['when_create'] = date('Y-m-d H:i:s');
		$data['who_create'] = $isi['user_nama_lengkap'];

		$this->M_material_gl_account->insertGlAccount($data);
	}
	/* INSERT */

	/* UPDATE */
	public function updateGlAccount()
	{
		$isi = $this->session->userdata();

		$id = anti_inject($this->input->post('gl_account_id'));
		$data = array(
			'gl_account_kode' => anti_inject($this->input->post('gl_account_kode')),
			'gl_account_nama' => anti_inject($this->input->post('gl_account_nama')),
			'when_create' => date('Y-m-d H:i:s'),
			'who_create' => $isi['user_nama_lengkap'],
		);

		$this->M_material_gl_account->updateGlAccount($data, $id);
	}
	/* UPDATE */

	/* DELETE */
	public function deleteGlAccount()
	{
		$this->M_material_gl_account->deleteGlAccount($this->input->get('gl_account_id'));
	}
	/* DELETE */

	/* RESET */
	public function resetGlAccount()
	{
		$this->M_material_gl_account->resetGlAccount();
	}
	/* RESET */
	/* INDEX IMPORT */
	public function index_import()
	{
		$isi['judul'] = 'Import Gl Account';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

		$this->load->view('tampilan/header', $isi);
		$this->load->view('tampilan/sidebar', $data);
		$this->load->view('master/kategori_barang_import');
		$this->load->view('tampilan/footer');
		$this->load->view('master/kategori_barang_import_js');
	}
	/* INDEX IMPORT */

	/* GET IMPORT */
	public function getImport()
	{
		$param['import_kode'] = $this->input->get('import_kode');

		$data = $this->M_material_gl_account->getImport($param);
		echo json_encode($data);
	}
	/* GET IMPORT */

	/* INSERT IMPORT */
	public function insertImport()
	{

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
					$data_excel[$i - 1]['gl_account_id']    = create_id();
					$data_excel[$i - 1]['gl_account_kode']  = $sheets['cells'][$i][1];
					$data_excel[$i - 1]['gl_account_nama']  = $sheets['cells'][$i][2];
					$data_excel[$i - 1]['when_create']  = date('Y-m-d H:i:s');
					$data_excel[$i - 1]['who_create']  = $data_session['user_nama_lengkap'];
				}

				$this->db->insert_batch('import.import_material_gl_account', $data_excel);

				header("Location: " . base_url('master/kategori_barang/index_import?header_menu=0&menu_id=0&import_kode=' . $id));
			}
		}
	}

	public function insertTable()
	{
		$param['import_kode'] = $this->input->get('import_kode');
		$this->M_material_gl_account->insertTable($param);
		$this->M_material_gl_account->deleteTable($this->input->get('import_kode'));

		header("Location: " . base_url('master/kategori_barang/index?header_menu=0&menu_id=0'));
	}
	/* INSERT IMPORT */
}
