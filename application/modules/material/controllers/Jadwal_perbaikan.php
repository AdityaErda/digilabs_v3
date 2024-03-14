<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jadwal_perbaikan extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('material/M_request');
		$this->load->model('master/M_material_aset');
		$this->load->model('master/M_sample_pekerjaan');
		$this->load->model('master/M_sample_peminta_jasa');
	}

	public function index()
	{
		$isi['judul'] = 'Jadwal Perbaikan / Kalibrasi';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

		$this->load->view('tampilan/header', $isi);
		$this->load->view('tampilan/sidebar', $data);
		$this->load->view('material/jadwal_perbaikan');
		$this->load->view('tampilan/footer');
		$this->load->view('material/jadwal_perbaikan_js');
	}

	//

	public function getJadwalPerbaikan()
	{
		$param['aset_perbaikan_id'] = $this->input->get_post('aset_perbaikan_id');
		$param['aset_nomor'] = $this->input->get_post('aset_nomor');
		$param['aset_nama'] = $this->input->get_post('aset_nama');
		$param['aset_nomor_utama'] = $this->input->get_post('aset_nomor_utama');
		$param['sample_peminta_jasa'] = $this->input->get_post('pengelola');
		$param['aset_perbaikan_vendor'] = $this->input->get_post('vendor');
		$param['pekerjaan_id_cari'] = $this->input->get_post('pekerjaan_id_cari');
		$param['terjadwal_cari'] = $this->input->get_post('terjadwal_cari');


		$param['bulan_cari'] = $this->input->get_post('bulan_cari');
		$param['tahun_cari'] = $this->input->get_post('tahun_cari');
		$where = array();
		if (!empty($param['bulan_cari'])) {
			$tgl_ini = date($param['tahun_cari'] . '-' . $param['bulan_cari'] . '-d');
			$where['aset_perbaikan_tgl_deadline >= '] = date('Y-m-01', strtotime($tgl_ini));
			$where['aset_perbaikan_tgl_deadline <= '] = date('Y-m-t', strtotime($tgl_ini));
		} else if (!empty($param['tahun_cari'])) {
			$where['aset_perbaikan_tgl_deadline >= '] = $param['tahun_cari'] . '-01-01';
			$where['aset_perbaikan_tgl_deadline <= '] = $param['tahun_cari'] . '-12-31';
		}

		$data = $this->M_request->getJadwalPerbaikan($param, $where);
		echo json_encode($data);
		// echo $this->db->last_query();

	}


	// get select2 nama aset
	public function getAsetNama()
	{
		$listNamaAset['results'] = array();
		$param['aset_nama'] = $this->input->get('aset_nama');
		foreach ($this->M_material_aset->getAset($param) as $key => $value) {
			array_push($listNamaAset['results'], [
				'id' => $value['aset_id'],
				'text' => $value['aset_nama'],
			]);
		}
		echo json_encode($listNamaAset);
	}
	// end  select2 get nama aset

	// get select2 nama item
	public function getAsetKode()
	{
		$listItemKode['results'] = array();
		$param['aset_id'] = $this->input->get('aset_id');
		$param['aset_nomor'] = $this->input->get_post('aset_nomor');
		foreach ($this->M_material_aset->getAsetDetail($param) as $key => $value) {
			array_push($listItemKode['results'], [
				'id' => $value['aset_detail_id'],
				'text' => $value['aset_nomor'],
			]);
		}
		echo json_encode($listItemKode);
	}

	// end select nama item

	// start select 2 pekerjaan
	public function getPekerjaan()
	{
		$listPekerjaan['results'] = array();
		$param['sample_pekerjaan_id'] = $this->input->get('sample_pekerjaan_id');
		$param['sample_pekerjaan_nama'] = $this->input->get_post('sample_pekerjaan_nama');
		foreach ($this->M_sample_pekerjaan->getJenisPekerjaan($param) as $key => $value) {
			array_push($listPekerjaan['results'], [
				'id' => $value['sample_pekerjaan_id'],
				'text' => $value['sample_pekerjaan_nama'],
			]);
		}
		echo json_encode($listPekerjaan);
	}
	// end select 2 pekerjaan

	public function insertJadwalPerbaikan()
	{
		$user = $this->session->userdata();

		if (isset($_FILES['aset_perbaikan_file'])) {
			$upload_path = FCPATH . './upload/';
			if (!file_exists($upload_path)) mkdir($upload_path);
			$allowed_mime_type_arr = array('application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'text/plain', 'application/pdf', 'image/jpeg', 'image/png', 'image/gif', 'image/bmp');
			$mime = get_mime_by_extension($_FILES['aset_perbaikan_file']['name']);
			if (isset($_FILES['aset_perbaikan_file']['name']) && $_FILES['aset_perbaikan_file']['name'] != "") {
				if (in_array($mime, $allowed_mime_type_arr)) {
					/*upload excelnya*/
					$tmpName = $_FILES['aset_perbaikan_file']['tmp_name'];
					$fileName = $_FILES['aset_perbaikan_file']['name'];
					$fileType = $_FILES['aset_perbaikan_file']['type'];
					$acak = rand(11111111, 99999999);
					$fileExt = substr($fileName, strpos($fileName, '.'));
					$fileExt = str_replace('.', '', $fileExt); // Extension
					$fileName = preg_replace("/\.[^.\s]{3,4}$/", "", $fileName);
					$newFileName = $fileName . '-' . str_replace(' ', '', $acak . '_' . date('ymdhis') . '.' . $fileExt);
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

		$data['aset_perbaikan_id'] = create_id();
		$data['aset_detail_id'] = anti_inject($this->input->get_post('aset_detail_id'));
		$data['aset_perbaikan_tgl_penyerahan'] = date('Y-m-d', strtotime($this->input->get_post('aset_perbaikan_tgl_penyerahan')));
		$data['aset_perbaikan_tgl_deadline'] = date('Y-m-d', strtotime($this->input->get_post('aset_perbaikan_tgl_deadline')));
		$data['pekerjaan_id'] = anti_inject($this->input->get_post('pekerjaan_id'));
		$data['peminta_id'] = anti_inject($this->input->get_post('peminta_id'));
		$data['aset_perbaikan_note'] = anti_inject($this->input->get_post('aset_perbaikan_note'));
		$data['aset_perbaikan_status'] = anti_inject($this->input->get_post('aset_perbaikan_status'));
		$data['aset_perbaikan_vendor'] = anti_inject($this->input->get_post('aset_perbaikan_vendor'));
		$data['is_jadwal'] = 'y';
		$data['aset_perbaikan_file'] = $newFileName;
		$data['when_create'] = date('Y-m-d H:i:s');
		$data['who_create'] = $user['user_nama_lengkap'];

		$this->M_request->insertPengajuanPerbaikan($data);
	}
	// end simpan pengajuan

	// start simpn pengajuan
	public function updateJadwalPerbaikan()
	{
		$user = $this->session->userdata();

		if (isset($_FILES['aset_perbaikan_file'])) {
			$upload_path = FCPATH . './upload/';
			if (!file_exists($upload_path)) mkdir($upload_path);
			$allowed_mime_type_arr = array('application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'text/plain', 'application/pdf', 'image/jpeg', 'image/png', 'image/gif', 'image/bmp');
			$mime = get_mime_by_extension($_FILES['aset_perbaikan_file']['name']);
			if (isset($_FILES['aset_perbaikan_file']['name']) && $_FILES['aset_perbaikan_file']['name'] != "") {
				if (in_array($mime, $allowed_mime_type_arr)) {
					/*upload excelnya*/
					$tmpName = $_FILES['aset_perbaikan_file']['tmp_name'];
					$fileName = $_FILES['aset_perbaikan_file']['name'];
					$fileType = $_FILES['aset_perbaikan_file']['type'];
					$acak = rand(11111111, 99999999);
					$fileExt = substr($fileName, strpos($fileName, '.'));
					$fileExt = str_replace('.', '', $fileExt); // Extension
					$fileName = preg_replace("/\.[^.\s]{3,4}$/", "", $fileName);
					$newFileName = $fileName . '-' . str_replace(' ', '', $acak . '_' . date('ymdhis') . '.' . $fileExt);
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
		} else if ($this->input->get_post('aset_perbaikan_file') == 'undefined') {
			echo 1;
		}

		$id = anti_inject($this->input->get_post('aset_perbaikan_id'));
		$data['aset_detail_id'] = anti_inject($this->input->get_post('aset_detail_id'));
		$data['aset_perbaikan_tgl_penyerahan'] = date('Y-m-d', strtotime($this->input->get_post('aset_perbaikan_tgl_penyerahan')));
		$data['aset_perbaikan_tgl_deadline'] = date('Y-m-d', strtotime($this->input->get_post('aset_perbaikan_tgl_deadline')));
		$data['pekerjaan_id'] = anti_inject($this->input->get_post('pekerjaan_id'));
		$data['peminta_id'] = anti_inject($this->input->get_post('peminta_id'));
		$data['aset_perbaikan_note'] = anti_inject($this->input->get_post('aset_perbaikan_note'));
		$data['aset_perbaikan_status'] = anti_inject($this->input->get_post('aset_perbaikan_status'));
		$data['aset_perbaikan_vendor'] = anti_inject($this->input->get_post('aset_perbaikan_vendor'));
		if ($newFileName != '') {
			$data['aset_perbaikan_file'] = $newFileName;
		}
		$data['is_jadwal'] = 'y';
		$data['when_create'] = date('Y-m-d H:i:s');
		$data['who_create'] = $user['user_nama_lengkap'];
		$this->M_request->updatePengajuanPerbaikan($id, $data);
		// jika status y maka update tanggal selesai
		if ($this->input->get_post('aset_perbaikan_status') == 'y') {
			$id1 = $this->input->get_post('aset_perbaikan_id');
			$data1['aset_perbaikan_tgl_selesai'] = date('Y-m-d', strtotime($this->input->get_post('aset_perbaikan_tgl_selesai')));
			$this->M_request->updateJadwalSelesai($id1, $data1);
		}
	}

	public function deleteJadwalPerbaikan()
	{
		$id = $this->input->get_post('aset_perbaikan_id');
		$this->M_request->deletePengajuanPerbaikan($id);
		// print_r($this->db->last_query());
	}

	public function getSerialNumber()
	{
		$p['aset_id'] = $this->input->get_post('aset_id');
		$data = $this->M_request->getSerialNumber($p);
		echo json_encode($data);
		// echo $this->db->last_query();
	}

	/* INDEX IMPORT */
	public function index_import()
	{
		$isi['judul'] = 'Import Jadwal Perbaikan';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

		$this->load->view('tampilan/header', $isi);
		$this->load->view('tampilan/sidebar', $data);
		$this->load->view('material/jadwal_perbaikan_import');
		$this->load->view('tampilan/footer');
		$this->load->view('material/jadwal_perbaikan_import_js');
	}
	/* INDEX IMPORT */

	/* GET IMPORT */
	public function getImport()
	{
		$param['import_kode'] = $this->input->get('import_kode');

		$data = $this->M_request->getImport($param);
		echo json_encode($data);
	}
	/* GET IMPORT */

	/* INSERT IMPORT */
	public function insertImport()
	{
		error_reporting(0);
		$data_session = $this->session->userdata();
		$upload_path = FCPATH . './upload/';
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

				chmod($upload_path . $NewExcelName, 0777);

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

					$user = $this->session->userdata();

					$param_status['status'] = $sheets['cells'][$i][11];
					if ($param_status['status'] == 'Selesai') {
						$param_statusnya = 'y';
					} else if ($param_status['status'] == 'Pengajuan') {
						$param_statusnya = 'n';
					} else if ($param_status['status'] == 'Dikerjakan') {
						$param_statusnya = 'k';
					} else if ($param_status['status'] == 'Pending') {
						$param_statusnya = 'p';
					} else if ($param_status['status'] == 'Terjadwal') {
						$param_statusnya = 't';
					}


					$param_nama_aset['aset_nama'] = $sheets['cells'][$i][5];
					$param_nama_aset['aset_nomor_utama'] = $sheets['cells'][$i][4];
					$param_nama_aset['aset_nomor'] = $sheets['cells'][$i][6];
					$isiNama = $this->M_request->getAsetImport($param_nama_aset);


					$param_pekerjaan['peminta_jasa_nama'] = $sheets['cells'][$i][7];
					$isiPekerjaan = $this->M_sample_peminta_jasa->getPemintaJasa($param_pekerjaan);

					$param_kerja['pekerjaan_id'] = $sheets['cells'][$i][10];
					if ($param_kerja['pekerjaan_id'] == 'Kalibrasi') {
						$param1 = 'k';
					} else if ($param_kerja['pekerjaan_id'] == 'Perbaikan') {
						$param1 = 'p';
					}

					$data_excel[$i - 1]['import_kode']    = $id;
					$data_excel[$i - 1]['aset_perbaikan_id'] = create_id();
					$data_excel[$i - 1]['aset_detail_id'] =  $isiNama[0]['aset_detail_id'];
					$data_excel[$i - 1]['aset_perbaikan_tgl_penyerahan'] = date('Y-m-d', strtotime($sheets['cells'][$i]['1']));
					$data_excel[$i - 1]['aset_perbaikan_tgl_deadline'] = date('Y-m-d', strtotime($sheets['cells'][$i]['2']));
					$data_excel[$i - 1]['aset_perbaikan_tgl_selesai'] = date('Y-m-d', strtotime($sheets['cells'][$i]['3']));
					$data_excel[$i - 1]['aset_perbaikan_note'] = $sheets['cells'][$i]['8'];
					$data_excel[$i - 1]['aset_perbaikan_status'] = $param_statusnya;
					$data_excel[$i - 1]['when_create'] = date('Y-m-d H:i:s');
					$data_excel[$i - 1]['who_create'] = $data_session['user_nama_lengkap'];
					$data_excel[$i - 1]['peminta_id'] = $isiPekerjaan[0]['peminta_jasa_id'];
					$data_excel[$i - 1]['aset_perbaikan_vendor'] = $sheets['cells'][$i][9];
					$data_excel[$i - 1]['pekerjaan_id'] = $param1;
					$data_excel[$i - 1]['id_user'] = $user['user_id'];
					$data_excel[$i - 1]['is_jadwal'] = 'y';
				}

				$this->db->insert_batch('import.import_jadwal_perbaikan', $data_excel);


				redirect(base_url('material/jadwal_perbaikan/index_import?header_menu=32&menu_id=35&import_kode=' . $id), 'refresh');
			}
		}
	}

	public function insertTable()
	{
		$param['import_kode'] = $this->input->get('import_kode');
		$this->M_request->insertTable($param);
		$this->M_request->deleteTable($this->input->get('import_kode'));
		redirect(base_url('material/jadwal_perbaikan/index?header_menu=32&menu_id=35'));
	}
}
