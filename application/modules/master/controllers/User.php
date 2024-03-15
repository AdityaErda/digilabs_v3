<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends MY_Controller{

	public function __construct(){
		parent::__construct();

		$this->load->model('master/M_user');
		$this->load->model('master/M_role');
	}

	public function index(){
		$isi['judul'] = 'User';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

		$this->template->template_master('master/user',$isi,$data);
	}

	/* GET */
	public function getUser(){
		$param['user_id'] = $this->input->get('user_id');
		$param['id_seksi'] = $this->input->get('id_seksi');

		$data = $this->M_user->getUser($param);

		echo json_encode($data);
	}

	public function getRole(){
		$listRole['results'] = array();

		$param['role_nama'] = $this->input->get('role_nama');
		foreach ($this->M_role->getRole($param) as $key => $value) {
			array_push($listRole['results'], [
				'id' => $value['role_id'],
				'text' => $value['role_nama'],
			]);
		}

		echo json_encode($listRole);
	}

	public function getSeksiUser(){
		$listSeksi['results'] = array();

		$param['seksi_nama'] = $this->input->get('seksi_nama');
		foreach ($this->M_user->getSeksi($param) as $key => $value) {
			array_push($listSeksi['results'], [
				'id' => $value['seksi_id'],
				'text' => $value['seksi_nama'],
			]);
		}

		echo json_encode($listSeksi);
	}
	/* GET */

	/* INSERT */
	public function insertUser(){
		$isi = $this->session->userdata();

		if (!empty($_FILES['user_tanda_tangan']['name'])) {

			$file_name                  = str_replace(' ', '', create_id() . '_' . date('ymdhis'));
			$config['upload_path']      = './document/';
			$config['allowed_types']    = 'jpeg|jpg|png|bmp|gif';
			$config['max_size']         = 2048; // 2MB
			$config['file_name']        = $file_name;

			$this->upload->initialize($config);

			if (!$this->upload->do_upload('user_tanda_tangan')) {
				echo "Data Gagal Disimpan";
				die();
			} else {
				$user_tanda_tangan = $this->upload->data('file_name');
			}


			echo "Data Berhasil Disimpan";
		}

		$data = array(
			'user_id' => create_id(),
			'role_id' => anti_inject($this->input->post('role_id')),
			'id_seksi' => anti_inject($this->input->post('id_seksi')),
			'user_nama_lengkap' => anti_inject($this->input->post('user_nama_lengkap')),
			'user_tempat_lahir' => anti_inject($this->input->post('user_tempat_lahir')),
			'user_tgl_lahir' => date('Y-m-d', strtotime($this->input->post('user_tgl_lahir'))),
			'user_tanda_tangan' => $user_tanda_tangan,
			'user_username' => anti_inject($this->input->post('user_username')),
			'user_password' => md5(anti_inject($this->input->post('user_password'))),
			'when_create' =>  date('Y-m-d H:i:s'),
			'who_create' =>  $isi['user_nama_lengkap'],
		);

		$this->M_user->insertUser($data);
	}
	/* INSERT */

	/* UPDATE */
	public function updateUser(){
		$isi = $this->session->userdata();

		if (isset($_FILES['user_tanda_tangan']['name'])) {

			$file_name                  = str_replace(' ', '', create_id() . '_' . date('ymdhis'));
			$config['upload_path']      = './document/';
			$config['allowed_types']    = 'jpeg|jpg|png|bmp|gif';
			$config['max_size']         = 2048; // 2MB
			$config['file_name']        = $file_name;

			$this->upload->initialize($config);

			if (!$this->upload->do_upload('user_tanda_tangan')) {
				echo "Data Gagal Disimpan";
				die();
			} else {
				$user_tanda_tangan = $this->upload->data('file_name');
			}
			echo "Data Berhasil Disimpan";
		}

		$id = anti_inject($this->input->post('user_id'));
		$password = (anti_inject($this->input->post('user_password')) == anti_inject($this->input->post('user_password_lama'))) ? anti_inject($this->input->post('user_password')) : md5(anti_inject($this->input->post('user_password')));
		$data = array(
			'role_id' => anti_inject($this->input->post('role_id')),
			'id_seksi' => anti_inject($this->input->post('seksi_id_user')),
			'user_nama_lengkap' => anti_inject($this->input->post('user_nama_lengkap')),
			'user_tempat_lahir' => anti_inject($this->input->post('user_tempat_lahir')),
			'user_tanda_tangan' => $user_tanda_tangan,
			'user_tgl_lahir' => date('Y-m-d', strtotime($this->input->post('user_tgl_lahir'))),
			'user_username' => anti_inject($this->input->post('user_username')),
			'user_password' => $password,
			'when_create' => date('Y-m-d H:i:s'),
			'who_create' => $isi['user_nama_lengkap'],
		);

		$this->M_user->updateUser($data, $id);
	}
	/* UPDATE */

	/* DELETE */
	public function deleteUser(){
		$this->M_user->deleteUser($this->input->get('user_id'));
	}
	/* DELETE */

	/* GET SEKSI */
	public function getSeksi(){
		$param['seksi_id'] = $this->input->get('seksi_id');
		$param['seksi_nama'] = $this->input->get('seksi_nama');

		$data = $this->M_user->getSeksi($param);
		echo json_encode($data);
	}
	/* GET SEKSI */

	/* GET KASIE */
	public function getNamaKasie(){
		$KasieNama['results'] = array();
		$param['user_nama_lengkap'] = $this->input->get('user_nama_lengkap');

		foreach ($this->M_user->getNamaKasie($param) as $key => $value) {
			array_push($KasieNama['results'], [
				'id' => $value['user_id'],
				'text' => $value['user_nama_lengkap'],
			]);
		}

		echo json_encode($KasieNama);
	}
	/* GET KASIE */

	/* Insert Kasie */
	public function updateKasieNama(){
		$id = htmlentities($this->input->get_post('identitas_kasie_nama'));
		$param['seksi_kepala'] = htmlentities($this->input->get_post('kasie_nama'));

		$this->M_user->updateKasieNama($id, $param);
	}
	/* Insert Kasie */

	/* INSERT SEKSI */
	public function insertSeksi(){
		$isi = $this->session->userdata();

		$data['seksi_id'] = create_id();
		$data['seksi_kode'] = anti_inject($this->input->post('seksi_kode'));
		$data['seksi_nama'] = anti_inject($this->input->post('seksi_nama'));
		// $data['seksi_kepala'] = anti_inject($this->input->post('kasie_nama'));
		$data['is_disposisi'] = anti_inject($this->input->post('is_disposisi'));
		$data['when_create'] = date('Y-m-d H:i:s');
		$data['who_create'] = $isi['user_nama_lengkap'];

		$this->M_user->insertSeksi($data);
	}
	/* INSERT SEKSI */

	/* UPDATE SEKSI */
	public function updateSeksi(){
		$isi = $this->session->userdata();

		$id = anti_inject($this->input->post('seksi_id'));
		$data = array(
			'seksi_kode' => anti_inject($this->input->post('seksi_kode')),
			'seksi_nama' => anti_inject($this->input->post('seksi_nama')),
			'is_disposisi' => anti_inject($this->input->post('is_disposisi')),
			'when_create' => date('Y-m-d H:i:s'),
			'who_create' => $isi['user_nama_lengkap'],
		);

		$this->M_user->updateSeksi($data, $id);
	}
	/* UPDATE SEKSI */

	/* DELETE SEKSI */
	public function deleteSeksi(){
		$this->M_user->deleteSeksi($this->input->get('seksi_id'));
	}
	/* DELETE SEKSI */

	/* INDEX IMPORT SEKSI */
	public function index_seksi_import(){
		$isi['judul'] = 'Import Seksi';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

		$this->load->view('tampilan/header', $isi);
		$this->load->view('tampilan/sidebar', $data);
		$this->load->view('master/user_seksi_import');
		$this->load->view('tampilan/footer');
		$this->load->view('master/user_seksi_import_js');
	}
	/* INDEX IMPORT SEKSI */

	/* GET IMPORT SEKSI */
	public function getImportSeksi(){
		$param['import_kode'] = $this->input->get('import_kode');

		$data = $this->M_user->getImportSeksi($param);
		echo json_encode($data);
	}
	/* GET IMPORT SEKSI */

	/* INSERT IMPORT SEKSI */
	public function insertImportSeksi(){

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
					$data_excel[$i - 1]['seksi_id']    = create_id();
					$data_excel[$i - 1]['seksi_kode']  = $sheets['cells'][$i][1];
					$data_excel[$i - 1]['seksi_nama']  = $sheets['cells'][$i][2];
					$data_excel[$i - 1]['when_create']  = date('Y-m-d H:i:s');
					$data_excel[$i - 1]['who_create']  = $data_session['user_nama_lengkap'];
				}

				$this->db->insert_batch('import.import_global_seksi', $data_excel);

				header("Location: " . base_url('master/user/index_seksi_import?header_menu=0&menu_id=0&import_kode=' . $id));
			}
				header("Location: " . base_url('master/user/index_seksi_import?header_menu=0&menu_id=0&import_kode=0'));
		}
				header("Location: " . base_url('master/user/index_seksi_import?header_menu=0&menu_id=0&import_kode=0'));
	}

	public function insertTableSeksi(){
		$param['import_kode'] = $this->input->get('import_kode');
		$this->M_user->insertTableSeksi($param);
		$this->M_user->deleteTableSeksi($this->input->get('import_kode'));

		header("Location: " . base_url('master/user/index?header_menu=0&menu_id=0'));
	}
	/* INSERT IMPORT SEKSI */

	/* INDEX IMPORT */
	public function index_import(){
		$isi['judul'] = 'Import User';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

		$this->load->view('tampilan/header', $isi);
		$this->load->view('tampilan/sidebar', $data);
		$this->load->view('master/user_import');
		$this->load->view('tampilan/footer');
		$this->load->view('master/user_import_js');
	}
	/* INDEX IMPORT */

	/* GET IMPORT */
	public function getImport(){
		$param['import_kode'] = $this->input->get('import_kode');

		$data = $this->M_user->getImport($param);
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

					$param_role['role_nama'] = $sheets['cells'][$i][4];
					$isiRole = $this->M_role->getRole($param_role);

					$param_seksi['seksi_nama'] = $sheets['cells'][$i][5];
					$isiSeksi = $this->M_user->getSeksi($param_seksi);

					$data_excel[$i - 1]['import_kode']    = $id;
					$data_excel[$i - 1]['user_id']    = create_id();
					$data_excel[$i - 1]['user_nama_lengkap']  = $sheets['cells'][$i][1];
					$data_excel[$i - 1]['user_tempat_lahir']  = $sheets['cells'][$i][2];
					$data_excel[$i - 1]['user_tgl_lahir']  = $sheets['cells'][$i][3];
					$data_excel[$i - 1]['role_id']  = $isiRole[0]['role_id'];
					$data_excel[$i - 1]['id_seksi']  = $isiSeksi[0]['seksi_id'];
					$data_excel[$i - 1]['user_username']  = $sheets['cells'][$i][6];
					$data_excel[$i - 1]['user_password']  = md5($sheets['cells'][$i][7]);
					$data_excel[$i - 1]['when_create']  = date('Y-m-d H:i:s');
					$data_excel[$i - 1]['who_create']  = $data_session['user_nama_lengkap'];
				}

				$this->db->insert_batch('import.import_global_user', $data_excel);

				header("Location: " . base_url('master/user/index_import?header_menu=0&menu_id=0&import_kode=' . $id));
			}
			header("Location: " . base_url('master/user/index_import?header_menu=0&menu_id=0&import_kode=0'));
		}
		header("Location: " . base_url('master/user/index_import?header_menu=0&menu_id=0&import_kode=0'));
	}

	public function insertTable(){
		$param['import_kode'] = $this->input->get('import_kode');
		foreach ($this->M_user->getImport($param) as $value) {
			$param['id_seksi'] = $value['id_seksi'];
			$this->M_user->insertTable($param);
			// print_r($this->db->last_query());
			// $this->M_material_aset->insertTableDetail($param);
		}
		$this->M_user->deleteTable($this->input->get('import_kode'));

		header("Location: " . base_url('master/user/index?header_menu=0&menu_id=0'));
	}
	/* INSERT IMPORT */
}
