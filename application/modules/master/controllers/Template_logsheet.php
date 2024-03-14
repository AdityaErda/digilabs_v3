<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Template_logsheet extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
		$this->load->model('M_template_logsheet');
		$this->load->model('M_perhitungan_sample');
	}

	public function index()
	{
		$isi['judul'] = 'Template LogSheet';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

		$this->load->view('tampilan/header', $isi);
		$this->load->view('tampilan/sidebar', $data);
		$this->load->view('master/template_logsheet');
		$this->load->view('tampilan/footer');
		$this->load->view('master/template_logsheet_js');
	}

	public function preview_template()
	{
		if ($this->uri->segment(4)) {
			$param['id_logsheet_template'] = anti_inject_replace($this->uri->segment(4));
		}
		$data['judul'] = "Preview Template";
		$data['template_detail']	=	$this->M_template_logsheet->getDetailLogsheet($param);
		$this->load->view('master/preview_template', $data, FALSE);
	}

	public function download_excel()
	{
		error_reporting(0);
		$this->load->library('Excel');
		if ($this->uri->segment(4)) {
			$param['id_logsheet_template'] = anti_inject_replace($this->uri->segment(4));
			$param['template_logsheet_id'] = anti_inject_replace($this->uri->segment(4));
		} else {
			$param['id_logsheet_template'] = $this->input->get_post('template_logsheet_id');
			$param['template_logsheet_id'] = $this->input->get_post('template_logsheet_id');
		}
		$data['judul'] = "Preview Template";
		$data['template'] = $this->M_template_logsheet->getTemplateLogsheet($param);

		$data['template_detail']	=	$this->M_template_logsheet->getDetailLogsheet($param);
		$this->load->view('master/template_logsheet_download_excel', $data, FALSE);
		// $this->load->view('master/template_logsheet_download_excel', $data, FALSE);
	}

	public function download_excel_proses()
	{


		if (isset($_POST["file_content"])) {
			$temporary_html_file = './tmp_html/' . time() . '.html';

			file_put_contents($temporary_html_file, $_POST["file_content"]);

			$reader = IOFactory::createReader('Html');

			$spreadsheet = $reader->load($temporary_html_file);

			$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

			$filename = time() . '.xlsx';

			$writer->save($filename);

			header('Content-Type: application/x-www-form-urlencoded');

			header('Content-Transfer-Encoding: Binary');

			header("Content-disposition: attachment; filename=\"" . $filename . "\"");

			readfile($filename);

			unlink($temporary_html_file);

			unlink($filename);

			exit;
		}
	}

	public function download_excel_multiple()
	{

		error_reporting(0);
		$this->load->library('Excel');
		if ($this->uri->segment(4)) {
			$param['id_logsheet_template'] = anti_inject_replace($this->uri->segment(4));
			$param['template_logsheet_id'] = anti_inject_replace($this->uri->segment(4));
		} else {
			$param['id_logsheet_template'] = $this->input->get_post('template_logsheet_id');
			$param['template_logsheet_id'] = $this->input->get_post('template_logsheet_id');
		}
		$data['judul'] = "Preview Template";
		$data['template'] = $this->M_template_logsheet->getTemplateLogsheet($param);

		$data['template_detail']	=	$this->M_template_logsheet->getDetailLogsheet($param);
		$this->load->view('master/template_logsheet_download_excel_multiple', $data, FALSE);
		// $this->load->view('master/template_logsheet_download_excel', $data, FALSE);
	}


	/* Get */
	public function getTemplateLogsheetList()
	{
		$jenis['results'] = array();
		$session = $this->session->userdata();
		$param = [];
		if ($session['role_id'] != '1') {
			$param['who_seksi_create_id'] = $session['id_seksi'];
		}
		if ($this->input->get_post('template_logsheet_id')) {
			$param['template_logsheet_id'] = anti_inject_replace($this->input->get_post('template_logsheet_id'));
		}
		if ($this->input->get_post('param_search')) {
			$param['param_search'] = anti_inject_replace($this->input->get('param_search'));
		}
		foreach ($this->M_template_logsheet->getTemplateLogsheet($param) as $key => $value) {
			array_push($jenis['results'], [
				'id' => $value['template_logsheet_id'],
				'text' => $value['template_logsheet_nama'],
			]);
		}
		echo json_encode($jenis);
	}

	public function getTemplateLogsheet()
	{
		$session = $this->session->userdata();
		$param = [];
		if ($session['role_id'] != '1') {
			$param['who_seksi_create_id'] = $session['id_seksi'];
		}
		if ($this->input->get_post('template_logsheet_id')) {
			$param['template_logsheet_id'] = anti_inject_replace($this->input->get_post('template_logsheet_id'));
		}
		$data = $this->M_template_logsheet->getTemplateLogsheetList($param);

		echo json_encode($data);
	}

	public function getMasterTemplate()
	{
		$listJenis['results'] = array();

		$param['logsheet_template_nama'] = $this->input->get('logsheet_template_nama');
		foreach ($this->M_template_logsheet->getMasterTemplate($param) as $key => $value) {
			array_push($listJenis['results'], [
				'id' => $value['logsheet_template_id'],
				'text' => $value['logsheet_template_nama'],
			]);
		}

		echo json_encode($listJenis);
	}
	/* Get */

	/* Insert */
	public function insertTemplateLogsheet()
	{
		$isi = $this->session->userdata();

		$seksi = $this->db->get_where('global.global_seksi', array('seksi_id' => $isi['id_seksi']))->row_array();

		$data['template_logsheet_id'] = create_id();
		$data['template_logsheet_nama'] = anti_inject($this->input->post('template_logsheet_nama'));
		$data['when_create'] = date('Y-m-d H:i:s');
		$data['who_create'] = $isi['user_nama_lengkap'];
		$data['is_aktif'] = anti_inject($this->input->post('is_aktif'));
		$data['who_seksi_create_id'] = $isi['id_seksi'];
		$data['who_seksi_create_name'] = $seksi['seksi_nama'];

		$this->M_template_logsheet->insertTemplateLogsheet($data);
	}
	/* Insert */

	/* Update */
	public function updateTemplateLogsheet()
	{
		$isi = $this->session->userdata();

		$id = anti_inject($this->input->post('template_logsheet_id'));
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
	public function deleteTemplateLogsheet()
	{
		$this->M_template_logsheet->deleteTemplateLogsheet($this->input->get('template_logsheet_id'));
	}

	/* Delete */

	/* Get Detail */
	public function getDetailLogsheet()
	{
		$param = array();

		if ($this->input->get('id_logsheet_template')) $param['id_logsheet_template'] = $this->input->get('id_logsheet_template');
		if ($this->input->get('template_logsheet_detail_id')) $param['template_logsheet_detail_id'] = $this->input->get('template_logsheet_detail_id');
		if ($this->input->get_post('rumus_id')) $param['rumus_id'] = $this->input->get_post('rumus_id');

		$data = $this->M_template_logsheet->getDetailLogsheet($param);
		// echo $this->db->last_query($data);

		echo json_encode($data);
	}

	public function getMasterRumus()
	{
		$session = $this->session->userdata();
		$listJenis['results'] = array();

		if ($session['role_id'] != '1') {
			$param['who_seksi_create_id'] = $session['id_seksi'];
		}
		$param['rumus_nama'] = $this->input->get('rumus_nama');

		$data = $this->M_template_logsheet->getMasterRumus($param);
		foreach ($data as $key => $value) {
			array_push($listJenis['results'], [
				'id' => $value['rumus_id'],
				'text' => $value['jenis_nama'] . ' - ' . $value['rumus_nama'],
			]);
		}

		echo json_encode($listJenis);
	}

	public function getMasterRumusData()
	{
		$listJenis['results'] = array();

		$param['rumus_id'] = $this->input->get_post('rumus_id');
		$param['id_rumus'] = $this->input->get_post('id_rumus');
		$param['rumus_nama'] = $this->input->get('rumus_nama');
		$data = $this->M_template_logsheet->getMasterRumus($param);
		echo json_encode($data);
	}
	/* Get Detail */

	/* Insert Detail */
	public function insertTemplateLogsheetDetail()
	{
		$isi = $this->session->userdata();

		$data['template_logsheet_detail_id'] = create_id();
		$data['id_logsheet_template'] = anti_inject($this->input->post('temp_logsheet_id'));
		$data['detail_logsheet_urut'] = anti_inject($this->input->post('detail_logsheet_urut'));
		$data['logsheet_nama_rumus'] = anti_inject($this->input->post('logsheet_nama_rumus'));
		$data['is_sertifikat'] = anti_inject($this->input->post('is_sertifikat'));
		$data['when_create'] = date('Y-m-d H:i:s');
		$data['who_create'] = $isi['user_nama_lengkap'];

		$this->M_template_logsheet->insertTemplateLogsheetDetail($data);
	}
	/* Insert Detail */

	/* Update Detail */
	public function updateTemplateLogsheetDetail()
	{
		$isi = $this->session->userdata();

		$id = anti_inject($this->input->post('template_logsheet_detail_id'));
		$data = array(
			'id_logsheet_template' => anti_inject($this->input->post('temp_logsheet_id')),
			'detail_logsheet_urut' => anti_inject($this->input->post('detail_logsheet_urut')),
			'logsheet_nama_rumus' => anti_inject($this->input->post('logsheet_nama_rumus')),
			'is_sertifikat' => anti_inject($this->input->post('is_sertifikat')),
			'when_create' => date('Y-m-d H:i:s'),
			'who_create' => $isi['user_nama_lengkap'],
		);

		$this->M_template_logsheet->updateTemplateLogsheetDetail($data, $id);
	}
	/* Update Detail */

	/* Delete Detail*/
	public function deleteTemplateLogsheetDetail()
	{
		$this->M_template_logsheet->deleteTemplateLogsheetDetail($this->input->get('template_logsheet_detail_id'));
	}

	/* Delete Detail */
}

/* End of file Template_logsheet.php */
