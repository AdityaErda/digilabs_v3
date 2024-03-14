<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Role extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('master/M_role');
	}

	/* INDEX */
	public function index()
	{
		$isi['judul'] = 'Role';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');
		$data['menu'] = $this->M_role->getMenu();
		$this->load->view('tampilan/header', $isi);
		$this->load->view('tampilan/sidebar', $data);
		$this->load->view('master/role',);
		$this->load->view('tampilan/footer');
		$this->load->view('master/role_js');
	}
	/* INDEX */

	/* GET */
	public function getRole()
	{
		$param['role_id'] = $this->input->get('role_id');

		$data = $this->M_role->getRole($param);
		echo json_encode($data);
	}

	public function getMenuRole()
	{
		$param['role_id'] = $this->input->get('role_id');

		$data = $this->M_role->getMenuRole($param);
		// echo $this->db->last_query();

		echo json_encode($data);
	}
	/* GET */

	/* INSERT */
	public function insertRole()
	{
		$isi = $this->session->userdata();

		$data['role_id'] = create_id();
		$data['role_kode'] = anti_inject($this->input->post('role_kode'));
		$data['role_nama'] = anti_inject($this->input->post('role_nama'));
		$data['when_create'] = date('Y-m-d H:i:s');
		$data['who_create'] = $isi['user_nama_lengkap'];

		$this->M_role->insertRole($data);
	}

	public function insertMenuRole()
	{
		$this->M_role->deleteMenuRole($this->input->post('role_id_temp'));
		foreach ($this->input->post('menu') as $value) {
			$data['menu_role_id'] = uniqid();
			$data['id_menu'] = $value;
			$data['id_role'] = $this->input->post('role_id_temp');

			$this->M_role->insertMenuRole($data);
			echo $this->db->last_query();
		}
	}
	/* INSERT */

	/* UPDATE */
	public function updateRole()
	{
		$isi = $this->session->userdata();

		$id = anti_inject($this->input->post('role_id'));
		$data = array(
			'role_kode' => anti_inject($this->input->post('role_kode')),
			'role_nama' => anti_inject($this->input->post('role_nama')),
			'when_create' => date('Y-m-d H:i:s'),
			'who_create' => $isi['user_nama_lengkap'],
		);

		$this->M_role->updateRole($data, $id);
	}
	/* UPDATE */

	/* DELETE */
	public function deleteRole()
	{
		$this->M_role->deleteRole($this->input->get('role_id'));
	}
	/* DELETE */

	/* INDEX IMPORT */
	public function index_import()
	{
		$isi['judul'] = 'Import Role';
		$data = $this->session->userdata();
		$data['header_menu'] = $this->input->get('header_menu');
		$data['menu_id'] = $this->input->get('menu_id');

		$this->load->view('tampilan/header', $isi);
		$this->load->view('tampilan/sidebar', $data);
		$this->load->view('master/role_import');
		$this->load->view('tampilan/footer');
		$this->load->view('master/role_import_js');
	}
	/* INDEX IMPORT */

	/* GET IMPORT */
	public function getImport()
	{
		$param['import_kode'] = $this->input->get('import_kode');

		$data = $this->M_role->getImport($param);
		echo json_encode($data);
	}
	/* GET IMPORT */

	/* INSERT IMPORT */
	public function insertImport()
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

				$data_excel[$i - 1]['import_kode']    = $id;
				$data_excel[$i - 1]['role_id']    = create_id();
				$data_excel[$i - 1]['role_kode']  = $sheets['cells'][$i][1];
				$data_excel[$i - 1]['role_nama']  = $sheets['cells'][$i][2];
				$data_excel[$i - 1]['when_create']  = date('Y-m-d H:i:s');
				$data_excel[$i - 1]['who_create']  = $data_session['user_nama_lengkap'];
			}

			$this->db->insert_batch('import.import_global_role', $data_excel);

			header("Location: " . base_url('master/role/index_import?header_menu=0&menu_id=0&import_kode=' . $id));
		}
	}

	public function insertTable()
	{
		$param['import_kode'] = $this->input->get('import_kode');
		$this->M_role->insertTable($param);
		$this->M_role->deleteTable($this->input->get('import_kode'));

		header("Location: " . base_url('master/role/index?header_menu=0&menu_id=0'));
	}
	/* INSERT IMPORT */

	/* FK */
	public function fk_menu_role()
	{
		foreach ($this->M_role->getRole() as $value) {
			$this->M_role->deleteMenuRole($value['role_id']);
			foreach ($this->M_role->getMenu() as $val) {
				$data['menu_role_id'] = create_id();
				$data['id_menu'] = $val['menu_id'];
				$data['id_role'] = $value['role_id'];

				$this->M_role->insertMenuRole($data);
			}
		}
	}
	/* FK */
}
