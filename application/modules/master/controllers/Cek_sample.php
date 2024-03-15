<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Cek_sample extends MY_Controller{

	public function __construct(){
		parent::__construct();
		//Do your magic here
		$this->load->model('M_cek_sample');
	}

	public function index(){
		$isi['judul'] = 'Cek Sample';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');
		
		$this->template->template_master('master/cek_sample',$isi,$data);
	}

	/* Get */
	public function getTemplateLogsheet(){
		$param = array(
			'template_logsheet_id' => $this->input->get_post('template_logsheet_id'),
		);

		$data = $this->M_cek_sample->getTemplateLogsheet($param);
		echo json_encode($data);
	}

	public function getcekSample(){
		$param['cek_sample_id'] = $this->input->get_post('cek_sample_id');
		$data = $this->M_cek_sample->getSample($param);
		echo json_encode($data);
	}

	public function getCekSampleDetail(){
		$param['cek_sample_id'] = $this->input->get_post('cek_sample_id');
		$param['rumus_id'] = $this->input->get_post('rumus_id');
		$data = $this->M_cek_sample->getSampleDetail($param);
		echo json_encode($data);
	}

	public function getCekSampleDetailDetail(){
		$param['cek_sample_detail_id'] = $this->input->get_post('cek_sample_detail_id');
		$data = $this->M_cek_sample->getSampleDetailDetail($param);

		echo json_encode($data);
	}

	/* Get */

	/* Insert */
	public function insertTemplateLogsheet(){
		$isi = $this->session->userdata();

		$data['template_logsheet_id'] = create_id();
		$data['template_logsheet_nama'] = $this->input->post('template_logsheet_nama');
		// $data['template_logsheet_file'] = $this->input->post('template_logsheet_file');
		$data['when_create'] = date('Y-m-d H:i:s');
		$data['who_create'] = $isi['user_nama_lengkap'];
		$data['is_aktif'] = $this->input->post('is_aktif');

		$this->M_template_logsheet->insertTemplateLogsheet($data);
	}
	/* Insert */

	/* Update */
	public function updateTemplateLogsheet(){
		$isi = $this->session->userdata();

		$id = $this->input->post('template_logsheet_id');
		$data = array(
			'template_logsheet_nama' => $this->input->get_post('template_logsheet_nama'),
			// 'template_logsheet_file' => $this->input->get_post('template_logsheet_file'),
			'when_create' => date('Y-m-d H:i:s'),
			'who_create' => $isi['user_nama_lengkap'],
			'is_aktif' => $this->input->get_post('is_aktif'),
		);

		$this->M_template_logsheet->updateTemplateLogsheet($data, $id);
	}
	/* Update */

	/* Delete */
	public function deleteTemplateLogsheet(){
		$this->M_template_logsheet->deleteTemplateLogsheet($this->input->get('template_logsheet_id'));
	}

	/* Delete */

	/* Get Detail */
	public function getDetailLogsheet(){
		$param = array();

		if ($this->input->get('id_logsheet_template')) $param['id_logsheet_template'] = $this->input->get('id_logsheet_template');
		if ($this->input->get('template_logsheet_detail_id')) $param['template_logsheet_detail_id'] = $this->input->get('template_logsheet_detail_id');
		if ($this->input->get_post('rumus_id')) $param['rumus_id'] = $this->input->get_post('rumus_id');

		$data = $this->M_template_logsheet->getDetailLogsheet($param);

		echo json_encode($data);
	}

	public function getMasterRumus(){
		$listJenis['results'] = array();

		$param['rumus_nama'] = $this->input->get('rumus_nama');
		foreach ($this->M_template_logsheet->getMasterRumus($param) as $key => $value) {
			array_push($listJenis['results'], [
				'id' => $value['rumus_id'],
				'text' => $value['jenis_nama'] . ' - ' . $value['rumus_nama'],
			]);
		}

		echo json_encode($listJenis);
	}
	/* Get Detail */

	/* Insert Detail */
	public function insertTemplateLogsheetDetail(){
		$isi = $this->session->userdata();

		$data['template_logsheet_detail_id'] = create_id();
		$data['id_logsheet_template'] = $this->input->post('temp_logsheet_id');
		$data['detail_logsheet_urut'] = $this->input->post('detail_logsheet_urut');
		$data['logsheet_nama_rumus'] = $this->input->post('logsheet_nama_rumus');
		$data['is_sertifikat'] = $this->input->post('is_sertifikat');
		$data['when_create'] = date('Y-m-d H:i:s');
		$data['who_create'] = $isi['user_nama_lengkap'];

		$this->M_template_logsheet->insertTemplateLogsheetDetail($data);
	}
	/* Insert Detail */

	/* Update Detail */
	public function updateTemplateLogsheetDetail(){
		$isi = $this->session->userdata();

		$id = $this->input->post('template_logsheet_detail_id');
		$data = array(
			'id_logsheet_template' => $this->input->post('temp_logsheet_id'),
			'detail_logsheet_urut' => $this->input->post('detail_logsheet_urut'),
			'logsheet_nama_rumus' => $this->input->post('logsheet_nama_rumus'),
			'is_sertifikat' => $this->input->post('is_sertifikat'),
			'when_create' => date('Y-m-d H:i:s'),
			'who_create' => $isi['user_nama_lengkap'],
		);

		$this->M_template_logsheet->updateTemplateLogsheetDetail($data, $id);
	}
	/* Update Detail */

	/* Delete Detail*/
	public function deleteTemplateLogsheetDetail(){
		$this->M_template_logsheet->deleteTemplateLogsheetDetail($this->input->get('template_logsheet_detail_id'));
	}

	/* Delete Detail */

	public function prosesCekSample(){
		error_reporting(0);

		$data1 = $this->db->query("SELECT * FROM sample.sample_cek_sample a WHERE a.id_template_logsheet = '" . $this->input->get_post('template_logsheet_id_import') . "'")->result_array();
		foreach ($data1 as $value1) {
			$data2 = $this->db->query("SELECT * FROM sample.sample_cek_sample_detail a WHERE a.cek_sample_id='" . $value1['cek_sample_id'] . "'")->result_array();
			foreach ($data2 as $value2) {
				$update3 = $this->db->query("UPDATE sample.sample_cek_sample_detail_detail SET is_lama = 'y' WHERE id_cek_sample_detail = '" . $value2['cek_sample_detail_id'] . "' AND id_cek_sample = '" . $value1['cek_sample_id'] . "'");
			}
			$update2 = $this->db->query("UPDATE sample.sample_cek_sample_detail SET is_lama = 'y' WHERE cek_sample_id = '" . $value1['cek_sample_id'] . "'");
			$update1 = $this->db->query("UPDATE sample.sample_cek_sample SET is_lama = 'y' WHERE cek_sample_id = '" . $value1['cek_sample_id'] . "'");
		}

		$session = $this->session->userdata();
		$upload_path = FCPATH . './dokumen_logsheet/cek_sample/';
		/*ekstensi file yang diperbolehkan*/
		$allowed_mime_type_arr = array('application/vnd.ms-excel');
		$mime = get_mime_by_extension($_FILES['cek_sample_file']['name']);
		if (isset($_FILES['cek_sample_file']['name']) && $_FILES['cek_sample_file']['name'] != "") {
			if (in_array($mime, $allowed_mime_type_arr)) {
				/*upload excelnya*/
				$excelTmp = $_FILES['cek_sample_file']['tmp_name'];
				$excelName = $_FILES['cek_sample_file']['name'];
				$excelType = $_FILES['cek_sample_file']['type'];

				$acak = rand(11111111, 99999999);
				$excelExt = substr($excelName, strrpos($excelName, '.'));
				$excelExt = str_replace('.', '', $excelExt); // Extension
				$excelName = preg_replace("/\.[^.\s]{3,4}$/", "", $excelName);
				$NewExcelName = $excelName . str_replace(' ', '', $acak . '_' . date('ymdhis') . '.' . $excelExt);
				move_uploaded_file($_FILES["cek_sample_file"]["tmp_name"], $upload_path . $NewExcelName);
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

				/* cek sample 1 */
				$param['cek_sample_id'] = create_id();
				$param['id_template_logsheet'] = $this->input->get_post('template_logsheet_id_import');
				$param['who_create'] = ($session['user_id'] != '1') ? $session['user_nama_lengkap'] : 'Super Admin';
				$param['when_create'] = date('Y-m-d H:i:s');
				$param['is_lama'] = 'n';
				$param['tgl_input'] = date('Y-m-d');
				$param['cek_sample_file'] = $NewExcelName;
				$this->M_cek_sample->insertCekSample($param);
				/*cek sample 1*/

				/* cek_sample 2 */
				$param_rumus['id_logsheet_template'] = $this->input->get_post('template_logsheet_id_import');

				$jumlah_rumus = $this->db->query("SELECT * FROM sample.sample_template_logsheet_detail a LEFT JOIN sample.sample_perhitungan_sample b ON a.logsheet_nama_rumus = b.rumus_id WHERE id_logsheet_template = '" . $this->input->get_post('template_logsheet_id_import') . "'  ORDER BY detail_logsheet_urut ASC")->num_rows();

				$jumlah_baris = ($this->input->post('cek_sample_batas') * $jumlah_rumus) + ($jumlah_rumus * 3);

				for ($i = 1; $i <= $jumlah_baris; $i++) {
					if ($sheets['cells'][$i][1] == 'Rumus') {
						$param_rumus['urut'] = $i;
						$param_rumus['rumus_nama'] = strtoupper($sheets['cells'][$i][2]);
					}

					$param_rumus['id_logsheet_template'] = $this->input->get_post('template_logsheet_id_import');
					if ($param_rumus['rumus_nama'] != '') :
						$data_rumus = $this->db->query("SELECT a.*, b.rumus_id, b.rumus_nama, b.is_adbk, b.satuan_sample, b.desimal_angka, b.batasan_emisi, b.metode FROM sample.sample_template_logsheet_detail a LEFT JOIN sample.sample_perhitungan_sample b ON a.logsheet_nama_rumus = b.rumus_id WHERE id_logsheet_template = '" . $this->input->get_post('template_logsheet_id_import') . "' AND UPPER(rumus_nama) = '" . $param_rumus['rumus_nama'] . "' ORDER BY detail_logsheet_urut ASC")->row_array();

						$jumlah_isi_rumus = $this->db->query("SELECT * FROM sample.sample_perhitungan_sample_detail WHERE id_rumus = '" . $data_rumus['rumus_id'] . "' AND rumus_detail_template IS NOT NULL ORDER BY rumus_detail_template ASC")->num_rows();
						$jumlah_isi_rumus = $jumlah_isi_rumus + 1;
					endif;

					if (($data_rumus)) :
						if ($sheets['cells'][$i][$jumlah_isi_rumus + 1] == 'Hasil') {
							continue;
						}

						$param2['cek_sample_detail_id'] = create_id();
						$param2['cek_sample_id'] = $param['cek_sample_id'];
						$param2['id_rumus'] = $data_rumus['rumus_id'];
						$param2['cek_sample_detail_urut'] = $sheets['cells'][$i][1];
						$param2['when_create'] = date('Y-m-d H:i:s');
						$param2['who_create'] = ($session['user_id'] != '1') ? $session['user_nama_lengkap'] : 'Super Admin';
						$param2['cek_sample_detail_urut_baris'] = $sheets['cells'][$i][1];
						$hasil = '';
						$batas = '';
						$average = '';
						$batas = ($data_rumus['desimal_angka'] != '') ? $data_rumus['desimal_angka'] : '0';
						$hasil = $sheets['cells'][$i][$jumlah_isi_rumus + 1];
						$average = $sheets['cells'][$i][$jumlah_isi_rumus + 2];
						$param2['rumus_hasil'] = $hasil;
						$param2['rumus_avg'] = $average;
						if ($sheets['cells'][$i][4] == 'Metoda') {
							$param2['rumus_metoda'] = ($sheets['cells'][$i][5]);
							continue;
						}
						if ($sheets['cells'][$i][1] == 'Satuan') {
							$param2['rumus_satuan'] = ($sheets['cells'][$i][2]);
							continue;
						}
						$param2['is_lama'] = 'n';
						$param2['tgl_input'] = date('Y-m-d');

					endif;
					$this->M_cek_sample->insertCekSampleDetail($param2);
					// $this->M_inbox->insertLogSheetDetail($param_logsheet2);
					/* cek sample 2 */

					/* cek sample 3 */
					for ($x = 1; $x <= $jumlah_isi_rumus - 1; $x++) {
						$data_isi_rumus = $this->db->query("SELECT * FROM sample.sample_perhitungan_sample_detail WHERE id_rumus = '" . $data_rumus['rumus_id'] . "' AND rumus_detail_template IS NOT NULL ORDER BY rumus_detail_template ASC")->result_array();

						$param3['cek_sample_detail_detail_id'] = create_id();
						$param3['id_cek_sample'] = $param['cek_sample_id'];
						$param3['id_cek_sample_detail'] = $param2['cek_sample_detail_id'];
						$param3['rumus_detail_id'] = $data_isi_rumus[$x - 1]['rumus_detail_id'];
						$param3['rumus_detail_nama'] = $data_isi_rumus[$x - 1]['rumus_detail_nama'];
						$param3['rumus_detail_isi'] = $sheets['cells'][$i][$x + 1];
						$param3['rumus_jenis'] = $data_isi_rumus[$x - 1]['rumus_jenis'];
						$param3['when_create'] = date('Y-m-d H:i:s');
						$param3['who_create'] = ($session['user_id'] != '1') ? $session['user_nama_lengkap'] : 'Super Admin';
						$param3['rumus_detail_urut'] = $data_isi_rumus[$x - 1]['rumus_detail_urut'];
						$param3['rumus_detail_template'] = $data_isi_rumus[$x - 1]['rumus_detail_template'];
						$param3['is_lama'] = 'n';
						$param3['tgl_input'] = date('Y-m-d');
						$this->M_cek_sample->insertCekSampleDetailDetail($param3);
						// $this->M_inbox->insertLogSheetDetailDetail($param_logsheet3);
					}
				}

				/* cek sample 3 */
			} else {
				echo 0;
			}
		} else {
			echo 00;
		}
	}
}


/* End of file Template_logsheet.php */
