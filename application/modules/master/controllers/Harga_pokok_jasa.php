<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Harga_pokok_jasa extends MY_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('master/M_material_item');
		$this->load->model('master/M_material_aset');
		$this->load->model('master/M_sample_jenis');
		$this->load->model('master/M_harga_pokok_jasa');
	}

	/* INDEX */
	public function index(){
		$isi['judul'] = 'Harga Pokok Jasa';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');
		
		$this->template->template_master('master/harga_pokok_jasa',$isi,$data);
	}
	/* INDEX */

	/* GET */
    public function getBarangMaterial(){
		$listAset['results'] = array();

		$param['item_nama'] = $this->input->get('item_nama');
		foreach ($this->M_material_item->getBarangMaterial($param) as $key => $value) {
			array_push($listAset['results'], [
				'id' => $value['item_id'],
				'text' => $value['item_nama'],
				'harga' => $value['item_harga'],
			]);
		}

		echo json_encode($listAset);
	}
    public function getAset(){
		$listAset['results'] = array();

		$param['aset_nama'] = $this->input->get('aset_nama');
		foreach ($this->M_material_aset->getAset($param) as $key => $value) {
			array_push($listAset['results'], [
				'id' => $value['aset_id'],
				'text' => $value['aset_nama'],
				'harga' => $value['aset_nilai_perolehan'],
			]);
		}

		echo json_encode($listAset);
	}
    public function getJenisSampleUji(){
		$listAset['results'] = array();

		$param['jenis_nama'] = $this->input->get('jenis_nama');
		foreach ($this->M_sample_jenis->getJenisSampleUji($param) as $key => $value) {
			array_push($listAset['results'], [
				'id' => $value['jenis_id'],
				'text' => $value['jenis_nama'],
			]);
		}

		echo json_encode($listAset);
	}
    public function getSampleIdentitas(){
		$listAset['results'] = array();

		$param['jenis_id'] = $this->input->get('jenis_id');
		$param['identitas_nama'] = $this->input->get('identitas_nama');
		foreach ($this->M_sample_jenis->getSampleIdentitas($param) as $key => $value) {
			array_push($listAset['results'], [
				'id' => $value['identitas_id'],
				'text' => $value['identitas_nama'],
				'harga' => $value['identitas_harga'],
			]);
		}

		echo json_encode($listAset);
	}

	public function getHargaPokokJasa(){
		$param['harga_pokok_jasa_id'] = $this->input->get('harga_pokok_jasa_id');

		$data = $this->M_harga_pokok_jasa->getHargaPokokJasa($param);
		echo json_encode($data);
	}
	/* GET */

	/* INSERT */
	public function insertHargaPokokJasa(){
		$isi = $this->session->userdata();

		$data['harga_pokok_jasa_id'] = create_id();
		$data['id_item'] = anti_inject($this->input->post('id_item')); 
		$data['id_aset'] = anti_inject($this->input->post('id_aset')); 
		$data['id_sample'] = anti_inject($this->input->post('id_sample')); 
		$data['harga_item'] = anti_inject($this->input->post('harga_item')); 
		$data['harga_aset'] = anti_inject($this->input->post('harga_aset')); 
		$data['harga_sample'] = anti_inject($this->input->post('harga_sample')); 

		$data['harga_item'] = ($data['harga_item'] == null) ? 0 : $data['harga_item'];
		$data['harga_aset'] = ($data['harga_aset'] == null) ? 0 : $data['harga_aset'];
		$data['harga_sample'] = ($data['harga_sample'] == null) ? 0 : $data['harga_sample'];
		
		$data['harga_total'] = ($data['harga_item']) + $data['harga_aset'] + $data['harga_sample']; 
		$data['when_create'] = date('Y-m-d H:i:s');
		$data['who_create'] = $isi['user_nama_lengkap'];

		$this->M_harga_pokok_jasa->insertHargaPokokJasa($data);
	}
	/* INSERT */

	/* UPDATE */
	public function updateHargaPokokJasa(){
		$isi = $this->session->userdata();

		$id = $this->input->post('harga_pokok_jasa_id');
		
		$harga_item = ($this->input->post('harga_item') == null) ? 0 : $harga_item;
		$harga_aset = ($this->input->post('harga_aset') == null) ? 0 : $harga_aset;
		$harga_sample = ($this->input->post('harga_sample') == null) ? 0 : $harga_sample;
		$data = array(
			'id_item' => anti_inject($this->input->post('id_item')), 
			'id_aset' => anti_inject($this->input->post('id_aset')), 
			'id_sample' => anti_inject($this->input->post('id_sample')), 
			'harga_item' => anti_inject($this->input->post('harga_item')), 
			'harga_aset' => anti_inject($this->input->post('harga_aset')), 
			'harga_sample' => anti_inject($this->input->post('harga_sample')), 
			
			'harga_total' => ($harga_item) + $harga_aset + $harga_sample, 
			'when_create' => date('Y-m-d H:i:s'),
			'who_create' => $isi['user_nama_lengkap'],

		);

		$this->M_harga_pokok_jasa->updateHargaPokokJasa($data, $id);
	}
	/* UPDATE */

	/* DELETE */
	public function deleteHargaPokokJasa(){
		$this->M_harga_pokok_jasa->deleteHargaPokokJasa($this->input->get('harga_pokok_jasa_id'));
	}
	/* DELETE */
	/* RESET */
	public function resetHargaPokokJasa(){
		$this->M_harga_pokok_jasa->resetHargaPokokJasa();
	}
	/* RESET */

	/* INDEX IMPORT */
	public function index_import(){
		$isi['judul'] = 'Import Jenis Barang';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

		$this->load->view('tampilan/header', $isi);
		$this->load->view('tampilan/sidebar', $data);
		$this->load->view('master/harga_pokok_jasa_import');
		$this->load->view('tampilan/footer');
		$this->load->view('master/harga_pokok_jasa_import_js');
	}
	/* INDEX IMPORT */

	/* GET IMPORT */
	public function getImport(){
		$param['import_kode'] = $this->input->get('import_kode');

		$data = $this->M_harga_pokok_jasa->getImport($param);
		echo json_encode($data);
	}
	/* GET IMPORT */

	/* INSERT IMPORT */
	public function insertImport(){
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
				$data_excel[$i - 1]['jenis_id']    = create_id();
				$data_excel[$i - 1]['jenis_kode']  = $sheets['cells'][$i][1];
				$data_excel[$i - 1]['jenis_nama']  = $sheets['cells'][$i][2];
				$data_excel[$i - 1]['when_create']  = date('Y-m-d H:i:s');
				$data_excel[$i - 1]['who_create']  = $data_session['user_nama_lengkap'];
			}

			$this->db->insert_batch('import.import_material_jenis', $data_excel);

			header("Location: " . base_url('master/harga_pokok_jasa/index_import?header_menu=0&menu_id=0&import_kode=' . $id));
		}
	}

	public function insertTable(){
		$param['import_kode'] = $this->input->get('import_kode');
		$this->M_harga_pokok_jasa->insertTable($param);
		$this->M_harga_pokok_jasa->deleteTable($this->input->get('import_kode'));

		header("Location: " . base_url('master/harga_pokok_jasa/index?header_menu=0&menu_id=0'));
	}
	/* INSERT IMPORT */
}
