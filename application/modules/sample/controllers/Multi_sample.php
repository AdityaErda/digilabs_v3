<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once('assets_tambahan/vendor/autoload.php');
require_once('assets_tambahan/vendor/phpoffice/phpword/bootstrap.php');

use PhpWord\src\PhpWord\PhpWord;
use PhpWord\src\PhpWord\Writer\Word2007;
use Aspose\Words\WordsApi;
use Aspose\Words\Model\Requests\ConvertDocumentRequest;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\Shared\Converter;
use PhpOffice\PhpWord\Style\TablePosition;
use PhpOffice\PhpWord\Style\Alignment;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\SimpleType\JcTable;
use PhpOffice\PhpWord\SimpleType\TextAlignment;
use PhpOffice\PhpWord\Style\AbstractStyle;
use PhpOffice\PhpWord\Style\Font;
use PhpOffice\PhpWord\Element\Table;
use PhpOffice\PhpWord\TemplateProcessor;

class Multi_sample extends MX_Controller
{
	public function __construct()
	{
		parent::__construct();
		isLogin();
		$this->load->model('master/M_perhitungan_sample');
		$this->load->model('master/M_template_logsheet');
		$this->load->model('master/M_sample_pekerjaan');
		$this->load->model('master/M_sample_jenis');
		$this->load->model('sample/M_request');
		$this->load->model('sample/M_library');
		$this->load->model('sample/M_inbox');
		$this->load->model('sample/M_approve');
		$this->load->model('sample/M_nomor');
		$this->load->model('sample/M_multi_sample');
		$this->load->model('master/M_rumus_multiple');
	}

	public function index()
	{
		$isi['judul'] = 'Multi Sample';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

		$this->load->view('tampilan/header', $isi);
		$this->load->view('tampilan/sidebar', $data);
		$this->load->view('sample/logsheet_multi/multi_sample');
		$this->load->view('tampilan/footer');
		$this->load->view('sample/logsheet_multi/multi_sample_js');
	}

	public function procesMulti()
	{
		$isi['judul'] = 'Multi Sample';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');
		$param['transaksi_id'] = ($this->input->get_post('transaksi_id'));
		$param['transaksi_detail_id_multiple'] = ($this->input->get('transaksi_detail_id'));
		if ($this->input->get('transaksi_detail_group') != 'null') {
			$param['transaksi_detail_group'] = $this->input->get('transaksi_detail_group');
		}

		$hexStrings = $this->input->get_post('transaksi_detail_id_group');
		$hexArray = explode(',', $hexStrings);
		$param['transaksi_detail_id_group'] = $hexArray;

		$result['inbox'] = $this->M_request->getRequestAll($param);
		$result['inbox_detail'] = $this->M_request->getRequestDetail($param);
		$result['multisample_group'] = $this->M_multi_sample->getMultiSampleGroup($param);

		$result['sample_detail'] = $this->M_multi_sample->getDetailSample($param);
		$result['sample_jenis'] = $this->M_sample_jenis->getJenisSampleUJi($param);
		$result['pekerjaan_jenis'] = $this->M_sample_pekerjaan->getJenisPekerjaan($param);

		$this->load->view('tampilan/header', $isi);
		$this->load->view('tampilan/sidebar', $data);
		$this->load->view('sample/logsheet_multi/multi_proces', $result);
		$this->load->view('tampilan/footer');
		$this->load->view('sample/logsheet_multi/multi_proces_js');
	}

	public function procesLogSheet()
	{
		$this->load->model('master/M_template_logsheet');

		$isi['judul'] = 'Lembar Kerja / Log Sheet';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

		$param['transaksi_id'] = ($this->input->get_post('transaksi_id'));
		$param['template_logsheet_id'] = ($this->input->get_post('template_logsheet_id'));
		$param['id_logsheet_template'] = ($this->input->get_post('template_logsheet_id'));
		$param['transaksi_non_rutin_id'] = $this->input->get_post('transaksi_non_rutin_id');
		$param['transaksi_detail_status'] = $this->input->get_post('status');
		$param['transaksi_detail_group'] = $this->input->get_post('transaksi_detail_group');
		$param['logsheet_multiple_id'] = $this->input->get_post('transaksi_detail_group');

		$result['inbox'] = $this->M_request->getRequestAll($param);
		$result['identitas_detail'] = $this->M_multi_sample->getIdentitas($param);
		$result['inbox_detail'] = $this->M_request->getRequestDetail($param);
		$result['multi_detail'] = $this->M_multi_sample->getMultiDetailLogsheet($param);
		$result['multisample_group'] = $this->M_multi_sample->getMultiSampleGroup($param);

		$result['sample_jenis'] = $this->M_sample_jenis->getJenisSampleUJi($param);
		$result['pekerjaan_jenis'] = $this->M_sample_pekerjaan->getJenisPekerjaan($param);
		$result['template'] = $this->M_template_logsheet->getTemplateLogsheet($param);
		$result['template_detail'] = $this->M_template_logsheet->getDetailLogsheet($param);
		$result['logsheet_level_1'] = $this->M_inbox->getLogsheet($param);
		$result['logsheet_level_2'] = $this->M_multi_sample->getMultiDetailHasil($param);
		$result['pengolah_sample'] = $this->M_sample_jenis->getPengambil($param);
		// kuery menentukan template

		$this->load->view('tampilan/header', $isi);
		$this->load->view('tampilan/sidebar', $data);
		$this->load->view('sample/logsheet_multi/multi_logsheet', $result);
		$this->load->view('tampilan/footer');
		$this->load->view('sample/logsheet_multi/multi_logsheet_js');
	}

	public function draftLogSheet()
	{
		$this->load->model('master/M_template_logsheet');

		$isi['judul'] = 'Lembar Kerja / Log Sheet';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');


		$param['transaksi_id'] = ($this->input->get_post('transaksi_id'));
		$param['logsheet_multiple_id'] = $this->input->get_post('multiple_logsheet_id');
		$param['template_logsheet_id'] = ($this->input->get_post('template_logsheet_id'));
		$param['id_logsheet_template'] = ($this->input->get_post('template_logsheet_id'));
		$param['transaksi_non_rutin_id'] = $this->input->get_post('transaksi_non_rutin_id');
		$param['transaksi_detail_status'] = $this->input->get_post('status');
		if ($this->input->get('transaksi_detail_group') && $this->input->get('transaksi_detail_group') != 'null') {
			$param['logsheet_multiple_id'] = $this->input->get_post('transaksi_detail_group');
			$param['transaksi_detail_group'] = $this->input->get_post('transaksi_detail_group');
		}
		if ($this->input->get_post('transaksi_detail_id_group')) {
			$hexStrings = $this->input->get_post('transaksi_detail_id_group');
			$hexArray = explode(',', $hexStrings);
			$param['transaksi_detail_id_group'] = $hexArray;
		}


		$result['inbox'] = $this->M_request->getRequestAll($param);
		$result['identitas_detail'] = $this->M_multi_sample->getIdentitas($param);
		$result['inbox_detail'] = $this->M_request->getRequestDetail($param);
		$result['logsheet'] = $this->M_multi_sample->getLogsheet($param);
		$result['multi_detail'] = $this->M_multi_sample->getMultiDetail($param);
		$result['multisample_group'] = $this->M_multi_sample->getMultiSampleGroup($param);
		$result['logsheet_group'] = $this->M_multi_sample->getLogSheetGroup($param);
		$result['sample_jenis'] = $this->M_sample_jenis->getJenisSampleUJi($param);
		$result['pekerjaan_jenis'] = $this->M_sample_pekerjaan->getJenisPekerjaan($param);
		$result['template'] = $this->M_template_logsheet->getTemplateLogsheet($param);
		$result['template_detail'] = $this->M_template_logsheet->getDetailLogsheet($param);
		// kuery menentukan template

		$this->load->view('tampilan/header', $isi);
		$this->load->view('tampilan/sidebar', $data);
		$this->load->view('sample/logsheet_multi/multi_draft', $result);
		$this->load->view('tampilan/footer');
		$this->load->view('sample/logsheet_multi/multi_draft_js');
	}

	public function reviewLogSheet()
	{
		$this->load->model('master/M_template_logsheet');

		$isi['judul'] = 'Konsep Lembar Kerja / Log Sheet';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

		$param['transaksi_id'] = ($this->input->get_post('transaksi_id'));
		$param['template_logsheet_id'] = ($this->input->get_post('template_logsheet_id'));
		$param['id_logsheet_template'] = ($this->input->get_post('template_logsheet_id'));
		$param['transaksi_non_rutin_id'] = $this->input->get_post('transaksi_non_rutin_id');
		$param['transaksi_detail_status'] = $this->input->get_post('status');
		if ($this->input->get('transaksi_detail_group') && $this->input->get('transaksi_detail_group') != 'null') {
			$param['logsheet_multiple_id'] = $this->input->get_post('transaksi_detail_group');
			$param['transaksi_detail_group'] = $this->input->get_post('transaksi_detail_group');
		}
		if ($this->input->get_post('transaksi_detail_id_group')) {
			$hexStrings = $this->input->get_post('transaksi_detail_id_group');
			$hexArray = explode(',', $hexStrings);
			$param['transaksi_detail_id_group'] = $hexArray;
		}

		$result['inbox'] = $this->M_request->getRequestAll($param);
		$result['identitas_detail'] = $this->M_multi_sample->getIdentitas($param);
		$result['inbox_detail'] = $this->M_request->getRequestDetail($param);
		$result['logsheet'] = $this->M_multi_sample->getLogsheet($param);
		$result['multi_detail'] = $this->M_multi_sample->getMultiDetail($param);
		$result['multisample_group'] = $this->M_multi_sample->getMultiSampleGroup($param);
		$result['logsheet_group'] = $this->M_multi_sample->getLogSheetGroup($param);
		$result['sample_jenis'] = $this->M_sample_jenis->getJenisSampleUJi($param);
		$result['pekerjaan_jenis'] = $this->M_sample_pekerjaan->getJenisPekerjaan($param);
		$result['template'] = $this->M_template_logsheet->getTemplateLogsheet($param);
		$result['template_detail'] = $this->M_template_logsheet->getDetailLogsheet($param);
		$result['sample_jenis'] = $this->M_sample_jenis->getJenisSampleUJi($param);
		$result['pekerjaan_jenis'] = $this->M_sample_pekerjaan->getJenisPekerjaan($param);

		$template = $this->M_template_logsheet->getTemplateLogsheet($param);


		$this->load->view('tampilan/header', $isi);
		$this->load->view('tampilan/sidebar', $data);
		$this->load->view('sample/logsheet_multi/multi_review', $result);
		$this->load->view('tampilan/footer');
		$this->load->view('sample/logsheet_multi/multi_review_js');
	}


	public function ceklistMultiSample()
	{
		$jumlah_ceklist = count($this->input->post('transaksi_detail_id'));

		foreach ($this->input->post('transaksi_detail_id') as $value) {
			$data = $this->db->get_where('sample.sample_transaksi_detail', array('transaksi_detail_id' => $value))->row_array();

			$data_jenis = $this->db->query("SELECT count(jenis_id) as total_jenis,count(transaksi_detail_status) as total_status FROM sample.sample_transaksi_detail WHERE transaksi_id = '" . $this->input->post('transaksi_id') . "' AND jenis_id = '" . $data['jenis_id'] . "' AND transaksi_detail_status = '" . $data['transaksi_detail_status'] . "' AND is_proses is null GROUP BY jenis_id,transaksi_detail_status")->row_array();

			$data_pilih = $this->db->query("SELECT count(jenis_id) as total_jenis,transaksi_detail_status FROM sample.sample_transaksi_detail WHERE transaksi_id = '" . $this->input->post('transaksi_id') . "' AND jenis_id = '" . $data['jenis_id'] . "' AND transaksi_detail_status = '" . $this->input->post('transaksi_detail_status_group') . "' AND is_proses is null GROUP BY jenis_id,transaksi_detail_status")->row_array();

			// echo $this->db->last_query();

			// echo "<pre>";
			// print_r ($data_pilih);
			// echo "</pre>";

		}

		if ($jumlah_ceklist != $data_jenis['total_jenis'] && $jumlah_ceklist != $data_jenis['total_status']) {
			echo 0;
		} else {
			echo 1;
		}
	}


	public function getDataSample()
	{
		$data = array();
		$isi = $this->session->userdata();
		if ($this->input->get('id_transaksi')) {
			$param['id_transaksi'] = $this->input->get('id_transaksi');
		} else {
			$param['transaksi_id'] = $this->input->get_post('transaksi_id');
			$param['status'] = $this->input->get_post('status');
			$param['seksi_id'] = $isi['id_seksi'];
			$param['role_id'] = $isi['role_id'];
			$param['transaksi_status'] = $this->input->get_post('transaksi_status');
			$param['tanggal_cari'] = $this->input->get_post('tanggal_cari');
			$param['tanggal_cari_awal'] = $this->input->get_post('tanggal_cari_awal');
			$param['tanggal_cari_akhir'] = $this->input->get_post('tanggal_cari_akhir');

			$where = array();
			if (!empty($param['tanggal_cari'])) {
				$tgl_ini = date($param['tanggal_cari'] . '-d');
				$where['DATE(transaksi_tgl) >= '] = date('Y-m-01', strtotime($tgl_ini));
				$where['DATE(transaksi_tgl) <= '] = date('Y-m-t', strtotime($tgl_ini));
			} else if (!empty($param['tahun_cari'])) {
				$where['DATE(transaksi_tgl) >= '] = $param['tahun_cari'] . '-01-01';
				$where['DATE(transaksi_tgl) <= '] = $param['tahun_cari'] . '-12-31';
			}
		}

		$dataTipe = $this->M_inbox->getTransaksiTipe($param);

		if (isset($dataTipe)) {
			$param['transaksi_tipe_rutin'] = $dataTipe['transaksi_tipe'];
		}

		$data_inbox = $this->M_multi_sample->getDataSample($param, $where);

		foreach ($data_inbox as $value) {

			$param_detail['transaksi_id'] = $value['transaksi_id'];
			$param_detail['id_seksi'] = $isi['id_seksi'];

			$data_detail = $this->M_inbox->getDisposisi($param_detail);

			$sql_kasie = $this->db->query("SELECT COUNT(*) as total FROM global.global_seksi WHERE seksi_kepala = '" . $isi['user_id'] . "'");
			$data_kasie = $sql_kasie->row_array();

			$value['kasie'] = ($data_kasie['total'] > 0) ? 'y' : 'n';
			if ($data_detail['total'] > 0 || $isi['role_id'] ==  '1') array_push($data, $value);
			if ($data_detail['total'] > 0 || $isi['role_id'] ==  '1') $id[$value['transaksi_id']] = $value['transaksi_id'];
		}

		foreach ($data_inbox as $val) {
			$param_petugas['transaksi_id'] = $val['transaksi_id'];
			// $param_petugas['transaksi_detail_id'] = $value['transaksi_detail_id'];
			$param_petugas['user_id'] = $isi['user_id'];

			$data_petugas = $this->M_inbox->getPetugas($param_petugas);

			$val['kasie'] = ($data_kasie['total'] > 0) ? 'y' : 'n';
			$sql_kasie = $this->db->query("SELECT COUNT(*) as total FROM global.global_seksi WHERE seksi_kepala = '" . $isi['user_id'] . "'");
			$data_kasie = $sql_kasie->row_array();

			if (!isset($id[$val['transaksi_id']])) if ($data_petugas['total'] > 0 || $isi['role_id'] ==  '1') array_push($data, $val);
		}

		echo json_encode($data);
	}

	public function getDetailSample()
	{
		$data = array();
		$isi = $this->session->userdata();

		$param['transaksi_id'] = $this->input->get_post('transaksi_id');

		$data_sample_detail = $this->M_multi_sample->getDetailSample($param);
		foreach ($data_sample_detail as $value) {
			// print_r($value);
			$param_detail['transaksi_id'] = $value['transaksi_id'];
			$param_detail['transaksi_detail_id'] = $value['transaksi_detail_id'];
			$param_detail['id_seksi'] = $isi['id_seksi'];

			$data_detail = $this->M_inbox->getDisposisi($param_detail);

			$sql_kasie = $this->db->query("SELECT COUNT(*) as total FROM global.global_seksi WHERE seksi_kepala = '" . $isi['user_id'] . "'");
			$data_kasie = $sql_kasie->row_array();

			$value['kasie'] = ($data_kasie['total'] > 0) ? 'y' : 'n';
			if ($data_detail['total'] > 0 || $isi['role_id'] ==  '1') array_push($data, $value);
			if ($data_detail['total'] > 0 || $isi['role_id'] ==  '1') $id[$value['transaksi_id']] = $value['transaksi_id'];
		}

		foreach ($data_sample_detail as $val) {
			$param_petugas['transaksi_id'] = $val['transaksi_id'];
			$param_petugas['transaksi_detail_id'] = $value['transaksi_detail_id'];
			$param_petugas['user_id'] = $isi['user_id'];

			$data_petugas = $this->M_inbox->getPetugas($param_petugas);

			$val['kasie'] = ($data_kasie['total'] > 0) ? 'y' : 'n';
			$sql_kasie = $this->db->query("SELECT COUNT(*) as total FROM global.global_seksi WHERE seksi_kepala = '" . $isi['user_id'] . "'");
			$data_kasie = $sql_kasie->row_array();

			if (!isset($id[$val['transaksi_id']])) if ($data_petugas['total'] > 0 || $isi['role_id'] ==  '1') array_push($data, $val);
		}

		echo json_encode($data);
	}

	public function getDetailSamplePerhitungan()
	{
		$param = [
			'transaksi_id' => $this->input->get_post('transaksi_id'),
			'transaksi_detail_status' => $this->input->get_post('transaksi_detail_status'),
			'id_jenis' => $this->input->get_post('id_jenis'),
		];
		$data = $this->M_multi_sample->getDetailSample($param);
		echo json_encode($data);
	}

	public function getLogSheetGroup()
	{
		$param['logsheet_multiple_id'] = $this->input->get_post('logsheet_multiple_id');
		$data = $this->M_multi_sample->getLogSheetGroup($param);
		echo json_encode($data);
	}


	public function insertClossedMultiNonLetter()
	{
		$isi = $this->session->userdata();
		$transaksi_detail_group = create_id();

		$param['transaksi_detail_group'] = $this->input->get_post('transaksi_detail_group');

		$datanya = $this->M_multi_sample->getDetailSample($param);

		foreach ($datanya as $key => $value) {

			$transaksi_detail_id = create_id();

			$id = $value['transaksi_id'];
			$id_detail = $value['transaksi_detail_id'];
			$data_detail['is_proses'] = 'y';
			$this->M_request->updateRequestDetail($data_detail, $id_detail);

			/* Insert Transaksi Detail */
			$data['transaksi_detail_id_temp'] = $value['transaksi_detail_id'];
			$data['transaksi_detail_id'] = $transaksi_detail_id;
			$data['transaksi_id'] = $value['transaksi_id'];
			$data['transaksi_detail_status'] = '17';
			$data['transaksi_detail_nomor'] = '';
			$data['when_create'] = date('Y-m-d H:i:s');
			$data['who_create'] = ($isi['user_id'] == '1') ?  'Super Admin' : $isi['user_nama'];
			$data['who_seksi_create'] = $isi['user_unit_id'];
			$this->M_inbox->insertInboxClossed($data);

			$id_logsheets = $this->input->get_post('logsheet_id');
			$data_logsheets['id_transaksi_detail'] = ($value['transaksi_detail_id']);
			$data_logsheets['logsheet_last_update'] = date('Y-m-d H:i:s');
			$this->M_inbox->updateLogSheet($id_logsheets, $data_logsheets);

			$param_disposisi['id_seksi'] = $isi['id_seksi'];
			$param_disposisi['id_transaksi'] = $value['transaksi_id'];
			$param_disposisi['id_transaksi_detail'] = $value['transaksi_detail_id'];
			$data_disposisi['id_transaksi_detail'] = $transaksi_detail_id;
			$this->M_inbox->updateTransaksiSeksiDisposisi($param_disposisi, $data_disposisi);

			/* Update Petugas Sample */
			$this->db->query("UPDATE sample.sample_petugas SET id_transaksi_detail = '" . $transaksi_detail_id . "' WHERE id_transaksi_detail = '" . $value['transaksi_detail_id'] . "'");
			/* Update Petugas Sample */

			$this->db->query("UPDATE sample.sample_transaksi_detail SET transaksi_detail_group='" . $transaksi_detail_group . "' WHERE transaksi_detail_id = '" . $transaksi_detail_id . "'");

			// $this->db->query("UPDATE sample.sample_logsheet SET id_transaksi_detail = '" . $data['transaksi_detail_id'] . "' WHERE id_transaksi = '" . $data['transaksi_id'] . "' AND id_transaksi_detail = '" . $data['transaksi_detail_id_temp'] . "'");

			sampleLog($value['transaksi_id'], null, $this->input->get_post('transaksi_non_rutin_id'), $this->input->get_post('transaksi_tipe'), $data['transaksi_detail_status'], 'Pekerjaan Telah Diprogress Oleh Eksekutor (Non Latter)');
		}
	}


	// eksekutor klik sample diterima
	public function insertDiterima()
	{
		$isi = $this->session->userdata();

		$transaksi_detail_group = $this->input->post('transaksi_id') . rand();


		foreach ($this->input->get_post('transaksi_detail_id_temp') as $key => $transaksi_detail_id_temp) {

			$id = $this->input->post('transaksi_id');
			$id_detail = $transaksi_detail_id_temp;
			$data_detail['is_proses'] = 'y';
			$this->M_request->updateRequestDetail($data_detail, $id_detail);

			/* Insert Transaksi Detail */
			$data['transaksi_detail_id_temp'] = $transaksi_detail_id_temp;
			$data['transaksi_detail_id'] = $this->input->get_post('transaksi_detail_id')[$key];
			$data['transaksi_id'] = $this->input->post('transaksi_id');
			$data['transaksi_detail_tgl_estimasi'] = date('Y-m-d H:i:s', strtotime($this->input->post('transaksi_detail_tgl_estimasi')[$key]));
			$data['transaksi_detail_status'] = '7';
			$data['transaksi_detail_jumlah'] = $this->input->get_post('transaksi_detail_jumlah')[$key];
			$data['transaksi_detail_parameter'] = $this->input->post('transaksi_detail_parameter')[$key];
			$data['transaksi_detail_deskripsi_parameter'] = $this->input->get_post('transaksi_detail_deskripsi_parameter')[$key];
			$data['when_create'] = date('Y-m-d H:i:s');
			$data['who_create'] = ($isi['user_id'] == '1') ?  'Super Admin' : $isi['user_nama'];
			$data['who_seksi_create'] = $isi['user_unit_id'];
			$this->M_inbox->insertInboxDiterima($data);

			$param_disposisi['id_seksi'] = $isi['id_seksi'];
			$param_disposisi['id_transaksi'] = $this->input->get_post('transaksi_id');
			$param_disposisi['id_transaksi_detail'] = $transaksi_detail_id_temp;
			$data_disposisi['id_transaksi_detail'] = $this->input->get_post('transaksi_detail_id')[$key];
			$this->M_inbox->updateTransaksiSeksiDisposisi($param_disposisi, $data_disposisi);

			$this->db->query("UPDATE sample.sample_transaksi_detail SET transaksi_detail_group = '" . $transaksi_detail_group . "' WHERE transaksi_detail_id = '" . $this->input->get_post('transaksi_detail_id')[$key] . "'");

			$transaksi_detail_id_group = implode(',', $this->input->get_post('transaksi_detail_id'));

			sampleLog($this->input->get_post('transaksi_id'), null, $this->input->get_post('transaksi_non_rutin_id'), $this->input->get_post('transaksi_tipe'), $data['transaksi_detail_status'], 'Pekerjaan Telah Diterima Oleh Eksekutor');
		}

		$link = base_url('sample/multi_sample/procesMulti?') . 'header_menu=' . $this->input->post('header_menu') . '&menu_id=' . $this->input->get_post('menu_id') . '&transaksi_status=7&transaksi_id=' . $this->input->post('transaksi_id') . '&transaksi_detail_group=' . $transaksi_detail_group . '&template_logsheet_id=' . $this->input->get_post('template_logsheet_id') . '&transaksi_non_rutin_id=' . $this->input->get_post('transaksi_non_rutin_id') . '&transaksi_detail_id_group=' . $transaksi_detail_id_group;
		echo $link;
	}
	// eksekutor klik sample diterima

	// eksekutor klik on proggres dan pilih sample multiple
	public function insertProgress()
	{
		$isi = $this->session->userdata();

		$transaksi_detail_group = $this->input->post('transaksi_id') . rand();

		foreach ($this->input->get_post('transaksi_detail_id_temp') as $key => $detail_id) :
			$id = $this->input->post('transaksi_id');
			$id_detail = $detail_id;
			$data_detail['is_proses'] = 'y';
			$this->M_request->updateRequestDetail($data_detail, $id_detail);

			/* Insert Transaksi Detail */

			$data['transaksi_detail_id_temp'] = $detail_id;
			$data['transaksi_detail_id'] = $this->input->get_post('transaksi_detail_id')[$key];
			$data['transaksi_id'] = $this->input->post('transaksi_id');
			$data['transaksi_detail_tgl_estimasi'] = date('Y-m-d H:i:s', strtotime($this->input->post('transaksi_detail_tgl_estimasi')[$key]));
			$data['transaksi_detail_status'] = '8';
			$data['transaksi_detail_tgl_memo'] = date('Y-m-d H:i:s', strtotime($this->input->post('transaksi_detail_tgl_memo')));
			$data['transaksi_detail_no_memo'] = $this->input->post('transaksi_detail_no_memo');
			$data['transaksi_detail_note'] = $this->input->post('transaksi_detail_note');
			$data['transaksi_detail_parameter'] = $this->input->post('transaksi_detail_parameter')[$key];
			$data['transaksi_detail_jumlah'] = $this->input->get_post('transaksi_detail_jumlah')[$key];
			$data['when_create'] = date('Y-m-d H:i:s');
			$data['who_create'] = ($isi['user_id'] == '1') ?  'Super Admin' : $isi['user_nama'];
			$data['who_seksi_create'] = $isi['user_unit_id'];
			$this->M_inbox->insertInboxNew($data);

			$this->db->query("UPDATE sample.sample_transaksi_detail SET transaksi_detail_group = '" . $transaksi_detail_group . "' WHERE transaksi_detail_id = '" . $data['transaksi_detail_id'] . "' ");

			$param_disposisi['id_seksi'] = $isi['id_seksi'];
			$param_disposisi['id_transaksi'] = $this->input->get_post('transaksi_id');
			$param_disposisi['id_transaksi_detail'] = $detail_id;
			$data_disposisi['id_transaksi_detail'] = $this->input->get_post('transaksi_detail_id')[$key];

			$this->M_inbox->updateTransaksiSeksiDisposisi($param_disposisi, $data_disposisi);

			$transaksi_detail_id_group = implode(',', $this->input->get_post('transaksi_detail_id'));

			sampleLog($this->input->get_post('transaksi_id'), null, $this->input->get_post('transaksi_non_rutin_id'), $this->input->get_post('transaksi_tipe'), $data['transaksi_detail_status'], 'Pekerjaan Telah Diprogress Oleh Eksekutor');
		endforeach;

		$link = base_url('sample/multi_sample/procesMulti?') . 'header_menu=' . $this->input->post('header_menu') . '&menu_id=' . $this->input->get_post('menu_id') . '&transaksi_status=8&transaksi_id=' . $this->input->post('transaksi_id') . '&transaksi_detail_group=' . $transaksi_detail_group  . '&template_logsheet_id=' . $this->input->get_post('template_logsheet_id') . '&transaksi_non_rutin_id=' . $this->input->get_post('transaksi_non_rutin_id') . '&transaksi_detail_id_group=' . $transaksi_detail_id_group;
		echo $link;
	}



	public function insertDraftLogSheetExcel()
	{
		error_reporting(0);
		$session = $this->session->userdata();
		$upload_path = FCPATH . './dokumen_logsheet/';
		/*ekstensi file yang diperbolehkan*/
		$allowed_mime_type_arr = array('application/vnd.ms-excel');
		$mime = get_mime_by_extension($_FILES['logsheet_file_excel']['name']);
		if (isset($_FILES['logsheet_file_excel']['name']) && $_FILES['logsheet_file_excel']['name'] != "") {
			if (in_array($mime, $allowed_mime_type_arr)) {
				/*upload excelnya*/
				$excelTmp = $_FILES['logsheet_file_excel']['tmp_name'];
				$excelName = $_FILES['logsheet_file_excel']['name'];
				$excelType = $_FILES['logsheet_file_excel']['type'];

				$acak = rand(11111111, 99999999);
				$excelExt = substr($excelName, strrpos($excelName, '.'));
				$excelExt = str_replace('.', '', $excelExt); // Extension
				$excelName = preg_replace("/\.[^.\s]{3,4}$/", "", $excelName);
				$NewExcelName = $excelName . str_replace(' ', '', $acak . '_' . date('ymdhis') . '.' . $excelExt);
				move_uploaded_file($_FILES["logsheet_file_excel"]["tmp_name"], $upload_path . $NewExcelName);
				/*upload excelnya*/

				/*proses excelnya*/
				$this->load->library('Spreadsheet_Excel_Reader');
				$this->spreadsheet_excel_reader->setOutputEncoding('CP1251');
				$this->db->db_set_charset('latin1', 'latin1_swedish_ci');
				$this->spreadsheet_excel_reader->read($upload_path . $NewExcelName);

				foreach ($this->input->post('transaksi_detail_id_temp') as $key_td => $val_td) {
					$sheets = $this->spreadsheet_excel_reader->sheets[$key_td];
					/*proses excelnya*/
					$data_excel = array();
					$id = create_id();

					if ($sheets['cells'][1][1] == 'Identitas') {
						$param_trans['transaksi_detail_identitas'] = ($sheets['cells'][1][2]);
					}

					$data_transaksi_detail = $this->db->query("SELECT * FROM sample.sample_transaksi_detail a LEFT JOIN sample.sample_jenis b ON b.jenis_id = a.jenis_id LEFT JOIN sample.sample_pekerjaan c ON c.sample_pekerjaan_id = a.jenis_pekerjaan_id LEFT JOIN sample.sample_transaksi d ON d.transaksi_id = a.transaksi_id LEFT JOIN sample.sample_peminta_jasa e ON e.peminta_jasa_id = d.transaksi_id_peminta_jasa WHERE a.transaksi_detail_id = '" . $val_td . "' AND (transaksi_detail_identitas) = '" . $param_trans['transaksi_detail_identitas'] . "' ")->row_array();

					/*logsheet level 1*/
					$param_logsheet = array(
						'logsheet_id' => create_id(),
						'logsheet_nomor_sample' => $data_transaksi_detail['transaksi_detail_nomor_sample'],
						'logsheet_jenis' => $data_transaksi_detail['jenis_nama'],
						'logsheet_peminta_jasa' => $data_transaksi_detail['peminta_jasa_nama'],
						'logsheet_nomor_permintaan' => $data_transaksi_detail['transaksi_nomor'],
						'logsheet_jenis_nama' => $data_transaksi_detail['jenis_nama'],
						'id_non_rutin' => $data_transaksi_detail['id_non_rutin'],
						'id_transaksi' => $data_transaksi_detail['transaksi_id'],
						'id_template_logsheet' => $this->input->get_post('template_logsheet_id'),
						'id_transaksi_detail' => $this->input->get_post('transaksi_detail_id')[$key_td],
						'logsheet_file_excel' => $NewExcelName,
						'logsheet_multiple_id' => $data_transaksi_detail['transaksi_detail_group'],
					);
					$this->M_inbox->insertLogSheet($param_logsheet);
					/*logsheet level 1*/

					/* logsheet level 2 */
					$param_rumus['id_logsheet_template'] = $this->input->get_post('template_logsheet_id');

					$jumlah_rumus = $this->db->query("SELECT * FROM sample.sample_template_logsheet_detail a LEFT JOIN sample.sample_perhitungan_sample b ON a.logsheet_nama_rumus = b.rumus_id WHERE id_logsheet_template = '" . $this->input->get_post('template_logsheet_id') . "'  ORDER BY detail_logsheet_urut ASC")->num_rows();

					$jumlah_baris = ($this->input->post('logsheet_baris_excel') * $jumlah_rumus) + ($jumlah_rumus * 3) + 1;

					for ($i = 1; $i <= $jumlah_baris; $i++) {

						if ($sheets['cells'][$i][1] == 'Identitas') {
							continue;
						}

						if ($sheets['cells'][$i][1] == 'Rumus') {
							$param_rumus['urut'] = $i;
							$param_rumus['rumus_nama'] = strtoupper($sheets['cells'][$i][2]);
							// continue;
						}

						$param_rumus['id_logsheet_template'] = $this->input->get_post('template_logsheet_id');

						if ($param_rumus['rumus_nama'] != '') :
							$data_rumus = $this->db->query("SELECT a.*, b.rumus_id, b.rumus_nama, b.is_adbk, b.satuan_sample, b.desimal_angka, b.batasan_emisi, b.metode FROM sample.sample_template_logsheet_detail a LEFT JOIN sample.sample_perhitungan_sample b ON a.logsheet_nama_rumus = b.rumus_id WHERE id_logsheet_template = '" . $this->input->get_post('template_logsheet_id') . "' AND UPPER(rumus_nama) = '" . $param_rumus['rumus_nama'] . "' ORDER BY detail_logsheet_urut ASC")->row_array();

							$jumlah_isi_rumus = $this->db->query("SELECT * FROM sample.sample_perhitungan_sample_detail WHERE id_rumus = '" . $data_rumus['rumus_id'] . "' AND rumus_detail_template IS NOT NULL ORDER BY rumus_detail_template ASC")->num_rows();
							$jumlah_isi_rumus = $jumlah_isi_rumus + 1;
						endif;
						if (($data_rumus)) :
							if ($sheets['cells'][$i][$jumlah_isi_rumus + 1] == 'Hasil') {
								continue;
							}

							$param_logsheet2['logsheet_detail_id'] = create_id();
							$param_logsheet2['logsheet_id'] = $param_logsheet['logsheet_id'];
							$param_logsheet2['id_rumus'] = $data_rumus['rumus_id'];
							$param_logsheet2['logsheet_detail_urut'] = $sheets['cells'][$i][1];
							$param_logsheet2['logsheet_detail_urut_baris'] = $sheets['cells'][$i][1];
							$param_logsheet2['when_create'] = date('Y-m-d H:i:s');
							$param_logsheet2['who_create'] = ($session['user_id'] != '1') ? $session['user_nama_lengkap'] : 'Super Admin';
							$hasil = '';
							$batas = ($data_rumus['desimal_angka'] != '') ? $data_rumus['desimal_angka'] : '0';
							$hasil = $sheets['cells'][$i][$jumlah_isi_rumus + 1];
							$average = $sheets['cells'][$i][$jumlah_isi_rumus + 2];
							$param_logsheet2['rumus_hasil'] = round($hasil, $batas);
							$param_logsheet2['rumus_avg'] = round($average, $batas);
							if ($sheets['cells'][$i][4] == 'Metoda') {
								$param_logsheet2['rumus_metoda'] = ($sheets['cells'][$i][5]);
								continue;
							}
							if ($sheets['cells'][$i][1] == 'Satuan') {
								$param_logsheet2['rumus_satuan'] = ($sheets['cells'][$i][2]);
								continue;
							}
						endif;
						$this->M_inbox->insertLogSheetDetail($param_logsheet2);
						/* logsheet level 2 */

						/* logsheet level 3 */
						for ($x = 1; $x <= $jumlah_isi_rumus; $x++) {
							$data_isi_rumus = $this->db->query("SELECT * FROM sample.sample_perhitungan_sample_detail WHERE id_rumus = '" . $data_rumus['rumus_id'] . "' AND rumus_detail_template IS NOT NULL ORDER BY rumus_detail_template ASC")->result_array();
							$param_logsheet3['logsheet_detail_detail_id'] = create_id();
							$param_logsheet3['id_logsheet'] = $param_logsheet['logsheet_id'];
							$param_logsheet3['id_logsheet_detail'] = $param_logsheet2['logsheet_detail_id'];
							$param_logsheet3['rumus_detail_id'] = $data_isi_rumus[$x - 1]['rumus_detail_id'];
							$param_logsheet3['id_rumus'] = $param_logsheet2['id_rumus'];
							$param_logsheet3['rumus_detail_nama'] = $data_isi_rumus[$x - 1]['rumus_detail_nama'];
							$param_logsheet3['rumus_detail_isi'] = $sheets['cells'][$i][$x + 1];
							$param_logsheet3['rumus_jenis'] = $data_isi_rumus[$x - 1]['rumus_jenis'];
							$param_logsheet3['when_create'] = date('Y-m-d H:i:s');
							$param_logsheet3['who_create'] = ($session['user_id'] != '1') ? $session['user_nama_lengkap'] : 'Super Admin';
							$param_logsheet3['rumus_detail_urut'] = $data_isi_rumus[$x - 1]['rumus_detail_urut'];
							$param_logsheet3['rumus_detail_template'] = $data_isi_rumus[$x - 1]['rumus_detail_template'];
							$this->M_inbox->insertLogSheetDetailDetail($param_logsheet3);
							/* insertlogsheetlevel3 */
						}
					}
					/* update status pekerjaan detail */
					$id = $this->input->post('transaksi_id');
					$id_detail_update = $val_td;
					$data_detail_update['is_proses'] = 'y';
					$this->M_request->updateRequestDetail($data_detail_update, $id_detail_update);
					/* update status pekerjaan detail */

					/* Insert Transaksi Detail */
					$data['transaksi_detail_id_temp'] = $val_td;
					$data['transaksi_detail_id'] = $this->input->get_post('transaksi_detail_id')[$key_td];
					$data['transaksi_id'] = $this->input->post('transaksi_id');
					$data['transaksi_detail_status'] = '9';
					$data['when_create'] = date('Y-m-d H:i:s');
					$data['who_create'] = ($session['user_id'] == '1') ?  'Super Admin' : $session['user_nama'];
					$data['who_seksi_create'] = $session['user_unit_id'];
					$this->M_inbox->insertInboxLogsheet($data);

					$this->db->query("UPDATE sample.sample_transaksi_detail SET transaksi_detail_group = '" . $data_transaksi_detail['transaksi_detail_group'] . "' WHERE transaksi_detail_id = '" . $this->input->get_post('transaksi_detail_id')[$key_td] . "'");
					/* Insert Transaksi Detail */

					/*udpate transaksi detail seksi disposisi */
					$param_disposisi['id_seksi'] = $session['id_seksi'];
					$param_disposisi['id_transaksi'] = $this->input->get_post('transaksi_id');
					$param_disposisi['id_transaksi_detail'] = $val_td;
					$data_disposisi['id_transaksi_detail'] = $this->input->get_post('transaksi_detail_id')[$key_td];
					$this->M_inbox->updateTransaksiSeksiDisposisi($param_disposisi, $data_disposisi);
					/*udpate transaksi detail seksi disposisi */

					/* Update transaksi detail Petugas Sample */
					$this->db->query("UPDATE sample.sample_petugas SET id_transaksi_detail = '" . $data['transaksi_detail_id'][$key_td] . "' WHERE id_transaksi_detail = '" . $val_td . "'");
					/* Update transaksi detail Petugas Sample */

					$transaksi_detail_id_group = implode(',', $this->input->get_post('transaksi_detail_id'));
				}

				$link = base_url('sample/multi_sample/procesLogSheet?') . 'header_menu=' . $this->input->post('header_menu') . '&menu_id=' . $this->input->get_post('menu_id') . '&transaksi_status=9&transaksi_id=' . $this->input->post('transaksi_id') . '&transaksi_detail_group=' . $data_transaksi_detail['transaksi_detail_group'] . '&template_logsheet_id=' . $this->input->post('template_logsheet_id') . '&transaksi_non_rutin_id=' . $this->input->post('transaksi_non_rutin_id') . '&transaksi_detail_id_group=' . $transaksi_detail_id_group;
				echo $link;
			} else {
				echo 0;
			}
		} else {
			echo 00;
		}
		/*ekstensi file yang diperbolehkan*/
	}

	public function insertDraft()
	{
		$logsheet = $this->db->query("SELECT * FROM sample.sample_logsheet WHERE logsheet_multiple_id = '" . $this->input->post('logsheet_multiple_id') . "' ORDER BY logsheet_nomor_sample ASC")->result_array();

		foreach ($logsheet as $key => $val) {
			$id = $val['logsheet_id'];
			$data['logsheet_tgl_terima'] = date('Y-m-d', strtotime($this->input->get_post('logsheet_tgl_terima')));
			$data['logsheet_tgl_uji'] = date('Y-m-d', strtotime($this->input->get_post('logsheet_tgl_uji')));
			$data['logsheet_asal_sample'] = $this->input->get_post('logsheet_asal_sample');
			$data['logsheet_pengolah_sample'] = $this->input->get_post('logsheet_pengolah_sample');
			$data['logsheet_deskripsi'] = $this->input->get_post('log_deskripsi')[$key];
			$this->M_inbox->updateLogSheet($id, $data);
		}
	}

	public function insertReset()
	{
		$session = $this->session->userdata();

		$param['transaksi_id'] = $this->input->get_post('transaksi_id');
		$param['transaksi_non_rutin_id'] = $this->input->get_post('transaksi_non_rutin_id');
		$param['transaksi_tipe'] = $this->input->get_post('transaksi_tipe');
		$param['logsheet_multiple_id'] = $this->input->get_post('logsheet_multiple_id');
		$param['transaksi_reset_logsheet_alasan'] = $this->input->get_post('transaksi_reset_logsheet_alasan');

		$logsheet = $this->db->query("SELECT * FROM sample.sample_logsheet WHERE logsheet_multiple_id = '" . $this->input->post('logsheet_multiple_id') . "' ORDER BY logsheet_nomor_sample ASC")->result_array();

		$jumlah_logsheet = count($logsheet);

		if ($jumlah_logsheet > 0) {
			foreach ($logsheet as $key_log => $val_log) :
				$logsheet_detail = $this->db->get_where('sample.sample_logsheet_detail', array('logsheet_id' => $val_log['logsheet_id']))->result_array();
				foreach ($logsheet_detail as $key => $val_logsheet_detail) {
					$param_logsheet_detail_detail['id_logsheet'] = $val_logsheet_detail['logsheet_id'];
					$param_logsheet_detail_detail['id_logsheet_detail'] = $val_logsheet_detail['logsheet_detail_id'];
					$this->M_inbox->deleteLogsheetDetailDetail($param_logsheet_detail_detail);
				}
				$param_logsheet_detail['logsheet_id'] = $val_log['logsheet_id'];
				$this->M_inbox->deleteLogsheetDetail($param_logsheet_detail);
			endforeach;
			$this->db->query("DELETE FROM sample.sample_logsheet WHERE logsheet_multiple_id = '" . $param['logsheet_multiple_id'] . "'");
		}

		$transaksi = $this->db->query("SELECT * FROM sample.sample_transaksi_detail WHERE transaksi_detail_group = '" . $this->input->post('logsheet_multiple_id') . "' AND is_proses is null ORDER BY transaksi_detail_nomor ASC")->result_array();

		$jumlah_transaksi = count($transaksi);

		if ($jumlah_transaksi > 0) {
			foreach ($transaksi as $key_trans => $val_trans) :
				$param_disposisi['id_transaksi'] = $val_trans['transaksi_id'];
				$param_disposisi['id_transaksi_detail'] = $val_trans['transaksi_detail_id'];
				$data_disposisi['id_transaksi_detail'] = create_id();
				$this->M_inbox->updateTransaksiSeksiDisposisi($param_disposisi, $data_disposisi);

				$id = $param_disposisi['id_transaksi'];
				$id_detail = $param_disposisi['id_transaksi_detail'];
				$data_detail['is_proses'] = 'y';
				$this->M_request->updateRequestDetail($data_detail, $id_detail);

				$data['transaksi_detail_id_temp'] = $param_disposisi['id_transaksi_detail'];
				$data['transaksi_detail_id'] = $data_disposisi['id_transaksi_detail'];
				$data['transaksi_id'] = $param_disposisi['id_transaksi'];
				$data['transaksi_detail_status'] = '8';
				$data['transaksi_detail_reject_alasan'] = $this->input->get_post('transaksi_reset_logsheet_alasan');
				$data['when_create'] = date('Y-m-d H:i:s');
				$data['who_create'] = ($session['user_id'] == '1') ?  'Super Admin' : $session['user_nama'];
				$data['who_seksi_create'] = $session['user_unit_id'];

				$this->M_inbox->insertBatal($data);

				$this->db->query("UPDATE sample.sample_transaksi_detail SET transaksi_detail_group = '" . $param['logsheet_multiple_id'] . "' WHERE transaksi_detail_id = '" . $data_disposisi['id_transaksi_detail'] . "'");

				$this->db->query("UPDATE sample.sample_petugas SET id_transaksi_detail = '" . $data_disposisi['id_transaksi_detail'] . "' WHERE id_transaksi_detail = '" . $param_disposisi['id_transaksi_detail'] . "'");

			// simpan ke sample log untuk history

			endforeach;
			sampleLog($this->input->get_post('transaksi_id'), null, $this->input->get_post('transaksi_non_rutin_id'), $this->input->get_post('transaksi_tipe'), $data['transaksi_detail_status'], 'Pekerjaan Telah Direset Logsheet');
		}
	}
	// reset logsheet

	public function insertOlahLogSheet()
	{
		$session = $this->session->userdata();
		foreach ($this->input->get_post('transaksi_detail_id_temp') as $key => $detail_id_temp) :
			$id = $this->input->post('transaksi_id');
			$id_detail_update = $detail_id_temp;
			$data_detail_update['is_proses'] = 'y';
			$transaksi_detail_id_baru = create_id();
			$this->M_request->updateRequestDetail($data_detail_update, $id_detail_update);

			$id_logsheets = $this->input->get_post('logsheet_id')[$key];
			$data_logsheets['id_transaksi_detail'] = $transaksi_detail_id_baru;
			$data_logsheets['logsheet_last_update'] = date('Y-m-d H:i:s');
			$data_logsheets['logsheet_tgl_terima'] = date('Y-m-d', strtotime($this->input->get_post('logsheet_tgl_terima')));
			$data_logsheets['logsheet_tgl_uji'] = date('Y-m-d', strtotime($this->input->get_post('logsheet_tgl_uji')));
			$data_logsheets['logsheet_asal_sample'] = $this->input->get_post('logsheet_asal_sample');
			$data_logsheets['logsheet_pengolah_sample'] = $this->input->get_post('logsheet_pengolah_sample');
			$data_logsheets['logsheet_deskripsi'] = $this->input->get_post('log_deskripsi')[$key];
			$this->M_inbox->updateLogSheet($id_logsheets, $data_logsheets);

			/* Insert Transaksi Detail */
			$data['transaksi_detail_id_temp'] = $detail_id_temp;
			$data['transaksi_detail_id'] = $data_logsheets['id_transaksi_detail'];
			$data['transaksi_id'] = $this->input->post('transaksi_id');
			$data['transaksi_detail_status'] = '10';
			$data['when_create'] = date('Y-m-d H:i:s');
			$data['who_create'] = ($session['user_id'] == '1') ?  'Super Admin' : $session['user_nama'];
			$data['who_seksi_create'] = $session['user_unit_id'];
			$this->M_inbox->insertInboxLogsheet($data);

			$param_disposisi['id_seksi'] = $session['id_seksi'];
			$param_disposisi['id_transaksi'] = $this->input->get_post('transaksi_id');
			$param_disposisi['id_transaksi_detail'] = $detail_id_temp;
			$data_disposisi['id_transaksi_detail'] = $data_logsheets['id_transaksi_detail'];
			$this->M_inbox->updateTransaksiSeksiDisposisi($param_disposisi, $data_disposisi);

			$this->db->query("UPDATE sample.sample_transaksi_detail SET transaksi_detail_group = '" . $this->input->post('logsheet_multiple_id') . "' WHERE transaksi_detail_id = '" . $data_logsheets['id_transaksi_detail'] . "'");

		endforeach;
		if ($this->input->get_post('logsheet_multiple_id')) {
			$redirect = base_url() . "sample/multi_sample/draftLogSheet/?header_menu=" . $this->input->get_post('header_menu') . "&menu_id=" . $this->input->get_post('menu_id') . "&transaksi_id=" . $this->input->get_post('transaksi_id') . "&transaksi_detail_group=" . $this->input->get_post('logsheet_multiple_id') . "&transaksi_detail_status=10&template_logsheet_id=" . $this->input->get_post('template_logsheet_id');
		} else {
			$redirect = base_url() . "sample/multi_sample/draftLogSheet/?header_menu=" . $this->input->get_post('header_menu') . "&menu_id=" . $this->input->get_post('menu_id') . "&transaksi_id=" . $this->input->get_post('transaksi_id') . "&transaksi_detail_group=" . $this->input->get_post('transaksi_detail_group') . "&transaksi_detail_status=10&template_logsheet_id=" . $this->input->get_post('template_logsheet_id');
		}
		echo $redirect;
	}

	// eksekutor approve logsheet
	public function insertLogSheet()
	{
		$session = $this->session->userdata();
		foreach ($this->input->get_post('transaksi_detail_id_temp') as $key => $detail_id_temp) :

			$id = $this->input->post('transaksi_id');
			$id_detail_update = $detail_id_temp;
			$data_detail_update['is_proses'] = 'y';
			$this->M_request->updateRequestDetail($data_detail_update, $id_detail_update);

			$transaksi_detail_id_baru = create_id();
			$id_logsheets = $this->input->get_post('logsheet_id')[$key];
			$data_logsheets['id_transaksi_detail'] = $transaksi_detail_id_baru;
			$data_logsheets['logsheet_analisis'] = $session['user_nik_sap'];
			$data_logsheets['logsheet_analisis_date'] = date('Y-m-d');
			$data_logsheets['logsheet_last_update'] = date('Y-m-d');
			$data_logsheets['is_kan'] = $this->input->get_post('is_kan');
			$data_logsheets['is_ds'] = $this->input->get_post('is_ds');
			$data_logsheets['id_template_footer'] = $this->input->get_post('id_template_footer');
			$data_logsheets['logsheet_keterangan'] = $this->input->get_post('logsheet_keterangan');
			$this->M_inbox->updateLogSheet($id_logsheets, $data_logsheets);

			/* Insert Transaksi Detail */
			$data['transaksi_detail_id_temp'] = $detail_id_temp;
			$data['transaksi_detail_id'] = $data_logsheets['id_transaksi_detail'];
			$data['transaksi_id'] = $this->input->post('transaksi_id');
			$data['transaksi_detail_status'] = '10';
			$data['when_create'] = date('Y-m-d H:i:s');
			$data['who_create'] = ($session['user_id'] == '1') ?  'Super Admin' : $session['user_nama'];
			$data['who_seksi_create'] = $session['user_unit_id'];
			$this->M_inbox->insertInboxLogsheet($data);

			$this->db->query("UPDATE sample.sample_transaksi_detail SET transaksi_detail_group = '" . $this->input->post('transaksi_detail_group') . "' WHERE transaksi_detail_id = '" . $data_logsheets['id_transaksi_detail'] . "'");

			// untuk qr code nya
			$param['logsheet_multiple_id'] = $this->input->get_post('transaksi_detail_group');

			$data_log = $this->M_multi_sample->getLogsheetGroup($param);

			$url = array();
			$nama_analisa = $data_log['nama_analisis'];
			$tanggal_analisa = $data_log['logsheet_analisis_date'];
			$last_update = $data_log['logsheet_last_update'];;

			$analisa = "Nama Analisa : " . $nama_analisa . "";
			$analisa .= ", Tanggal Analisa : " . $tanggal_analisa . "";
			$analisa .= ", Update Terakhir : " . $last_update . "";

			/* QRCODE */
			$this->load->library('ciqrcode'); //pemanggilan library QR CODE
			$config['cacheable']    = true; //boolean, the default is true
			$config['cachedir']     = './application/cache/'; //string, the default is application/cache/
			$config['errorlog']     = './application/logs/'; //string, the default is application/logs/
			$config['imagedir']     = './img/'; //direktori penyimpanan qr code
			$config['quality']      = true; //boolean, the default is true
			$config['size']         = '1024'; //interger, the default is 1024
			$config['black']        = array(224, 255, 255); // array, default is array(255,255,255)
			$config['white']        = array(70, 130, 180); // array, default is array(0,0,0)

			$this->ciqrcode->initialize($config);

			$nim = $data_log['logsheet_multiple_id'] . $data_log['nama_analisis'];
			$image_name = $nim . '.png'; //buat name dari qr code sesuai dengan nim
			$params['data'] = $analisa; //data yang akan di jadikan QR CODE
			$params['level'] = 'H'; //H=High
			$params['size'] = 5;
			$params['savename'] = FCPATH . $config['imagedir'] . $image_name; //simpan image QR CODE ke folder assets/images/
			$this->ciqrcode->generate($params);
			$id_logsheets_1 = $this->input->get_post('logsheet_id')[$key];
			$data_logsheets_1['logsheet_analisis_qr'] = $image_name;
			$this->M_inbox->updateLogSheet($id_logsheets_1, $data_logsheets_1);

			/* QRCODE */

			$param_disposisi['id_seksi'] = $session['id_seksi'];
			$param_disposisi['id_transaksi'] = $this->input->get_post('transaksi_id');
			$param_disposisi['id_transaksi_detail'] = $detail_id_temp;
			$data_disposisi['id_transaksi_detail'] = $data_logsheets['id_transaksi_detail'];
			$this->M_inbox->updateTransaksiSeksiDisposisi($param_disposisi, $data_disposisi);

		endforeach;
	}

	// eksekutor approve logsheet

	// kasie approve logsheet
	public function insertApproveKonsepLogSheet()
	{
		error_reporting(0);
		$session = $this->session->userdata();

		$param_where['transaksi_id'] = ($this->input->get_post('transaksi_id'));
		$param_where['logsheet_multiple_id'] = $this->input->get_post('multiple_logsheet_id');
		$param_where['template_logsheet_id'] = ($this->input->get_post('template_logsheet_id'));
		$param_where['id_logsheet_template'] = ($this->input->get_post('template_logsheet_id'));
		$param_where['transaksi_non_rutin_id'] = $this->input->get_post('transaksi_non_rutin_id');
		$param_where['transaksi_detail_status'] = $this->input->get_post('status');
		$param_where['transaksi_detail_group'] = $this->input->get_post('transaksi_detail_group');

		$logsheet_group = $this->M_multi_sample->getLogSheetGroup($param_where);
		$multi_detail = $this->M_multi_sample->getMultiDetail($param_where);
		$template = $this->M_template_logsheet->getTemplateLogsheet($param_where);
		$template_detail = $this->M_template_logsheet->getDetailLogsheet($param_where);

		$dataVP = $this->db->query("SELECT * FROM global.global_api_user WHERE user_unit_id = 'E44000' AND user_jobgrade = '2A'")->row_array();

		/* Penciptaan Dokumen DOCX */
		$dataFooter = explode(',', $logsheet_group['id_template_footer']);
		for ($i = 0; $i < count($dataFooter); $i++) {
			$data_footer =  $this->db->query("SELECT * FROM sample.sample_footer_sertifikat WHERE footer_id = '" . $dataFooter[$i] . "'")->row_array();

			$isi_footer[$i + 1] = $data_footer['footer_isi'];
		}

		if ($logsheet_group['is_kan'] == 'y') {
			$template = ($logsheet_group['is_ds'] == 'y') ? 'template_is_kan_ds.docx' : 'template_is_kan.docx';
		} else {
			$template = ($logsheet_group['is_ds'] == 'y') ? 'template_no_kan_ds.docx' : 'template_no_kan.docx';
		}

		$templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('./dokumen_dof/default/multiple_' . $template);
		$templateProcessor->setValues(
			[
				'jenis_sampel' => htmlspecialchars($logsheet_group['logsheet_jenis']),
				'peminta_jasa' => htmlspecialchars($logsheet_group['logsheet_peminta_jasa']),
				'nomor_permintaan' => htmlspecialchars($logsheet_group['logsheet_nomor_permintaan']),
				'tanggal_terima' => htmlspecialchars(date("d F Y", strtotime($logsheet_group['logsheet_tgl_terima']))),
				'tanggal_pengujian' => htmlspecialchars(date("d F Y", strtotime($logsheet_group['logsheet_tgl_uji']))),
				'asal_sampel' => htmlspecialchars($logsheet_group['logsheet_asal_sample']),
				'pengambilan_sampel_oleh' => htmlspecialchars($logsheet_group['logsheet_pengolah_sample']),
				'nama_vp' => htmlspecialchars($dataVP['user_nama']),
				'jabatan_vp' => htmlspecialchars($dataVP['user_post_title']),
				'isi_footer_1' => htmlspecialchars((isset($isi_footer[1])) ? $isi_footer[1] : ''),
				'isi_footer_2' => htmlspecialchars((isset($isi_footer[2])) ? $isi_footer[2] : ''),
				'isi_footer_3' => htmlspecialchars((isset($isi_footer[3])) ? $isi_footer[3] : ''),
			]
		);


		$hasil = array();

		foreach ($template_detail as $key_td => $val_td) :
			$list_rumus = $this->M_perhitungan_sample->getListRumus(array('id_rumus' => $val_td['rumus_id']));
			$detail_rumus = $this->M_perhitungan_sample->getDetailRumusSampleTemplate(array('id_rumus' => $val_td['rumus_id']));
			foreach ($multi_detail as $key_detail => $val_detail) :
				$logsheets = $this->M_multi_sample->getLogsheet(array('transaksi_id' => $this->input->get_post('transaksi_id'), 'logsheet_multiple_id' => $this->input->get_post('transaksi_detail_group'), 'id_transaksi_detail' => $val_detail['transaksi_detail_id']));
			endforeach;
			$logsheet_level_2 = $this->M_inbox->getLogsheetDetail(array('logsheet_multiple_id' => $this->input->get_post('transaksi_detail_group'), 'rumus_id' => $val_td['rumus_id']));
			foreach ($logsheet_level_2 as $key => $value) {
				$hasil[] = array(
					'nomor_sampel' => $value['logsheet_nomor_sample'],
					'jenis_uji' => $value['rumus_nama'],
					'satuan' => $value['rumus_satuan'],
					'hasil_uji' => $value['rumus_hasil'],
					'metoda' => $value['rumus_metoda'],
				);
			}
		endforeach;
		$templateProcessor->cloneBlock('hasil', 0, true, false, $hasil);

		$dataKeterangan = explode(',', $logsheet_group['logsheet_keterangan']);
		$keterangan = array();
		for ($i = 0; $i < count($dataKeterangan); $i++) {
			$data_keterangan =  $this->db->query("SELECT * FROM sample.sample_keterangan_sertifikat WHERE keterangan_sertifikat_id = '" . $dataKeterangan[$i] . "'")->row_array();

			$keterangan[] = array(
				'keterangan' => $data_keterangan['keterangan_sertifikat_isi'],
			);
		}
		$templateProcessor->cloneBlock('ket', 0, true, false, $keterangan);

		$pathToSave = FCPATH . './dokumen_dof/' . $this->input->post('transaksi_detail_group') . '.docx';
		$templateProcessor->saveAs($pathToSave);
		/* Penciptaan Dokumen DOCX */

		/* Send Dokumen SFTP */
		try {
			$dataFile = $this->input->post('transaksi_detail_group') . '.docx';
			$sftpServer = "103.157.97.200";
			$sftpUsername = "root";
			$sftpPassword = "P@ssw0rds1k1t4";
			$sftpPort = "22";
			$sftpRemoteDir = "/var/www/dokumen_dof";
			$ch = curl_init('sftp://' . $sftpServer . ':' . $sftpPort . $sftpRemoteDir . '/' . basename($dataFile));
			$fh = fopen('./dokumen_dof/' . $dataFile, 'r');

			if ($fh) {
				curl_setopt($ch, CURLOPT_USERPWD, $sftpUsername . ':' . $sftpPassword);
				curl_setopt($ch, CURLOPT_UPLOAD, true);
				curl_setopt($ch, CURLOPT_PROTOCOLS, CURLPROTO_SFTP);
				curl_setopt($ch, CURLOPT_INFILE, $fh);
				curl_setopt($ch, CURLOPT_INFILESIZE, filesize('./dokumen_dof/' . $dataFile));
				curl_setopt($ch, CURLOPT_VERBOSE, true);
				$verbose = fopen('php://temp', 'w+');
				curl_setopt($ch, CURLOPT_STDERR, $verbose);
				$response = curl_exec($ch);
				$error = curl_error($ch);
				curl_close($ch);
				if ($response) {
					// echo "Success";
				} else {
					// echo "Failure";
					rewind($verbose);
					$verboseLog = stream_get_contents($verbose);
					// echo "Verbose information:\n" . $verboseLog . "\n";
				}
			}
		} catch (Exception $e) {
			log_message("info", "Exception in uploading file to ftp---" . print_r($e->getMessage(), 1));
			// echo "error exception" . $e->getMessage();
		}
		/* Send Dokumen SFTP */
		foreach ($this->input->get_post('transaksi_detail_id_temp') as $key => $detail_id_temp) :

			$transaksi_detail_id_baru = create_id();
			$id = $this->input->post('transaksi_id');
			$id_detail_update = $detail_id_temp;
			$data_detail_update['is_proses'] = 'y';

			/* Insert Transaksi Detail */
			$id_transaksi = $detail_id_temp;
			$data_transaksi['transaksi_detail_id'] = $transaksi_detail_id_baru;
			$data_transaksi['transaksi_id'] = $this->input->post('transaksi_id');
			$data_transaksi['transaksi_detail_status'] = '10';
			$data_transaksi['when_create'] = date('Y-m-d H:i:s');
			$data_transaksi['who_create'] = ($session['user_id'] == '1') ?  'Super Admin' : $session['user_nama'];
			$data_transaksi['who_seksi_create'] = $session['user_unit_id'];
			$data_transaksi['transaksi_detail_group'] = $this->input->get_post('transaksi_detail_group');
			$this->db->where('transaksi_detail_id', $id_transaksi);
			$this->db->update('sample.sample_transaksi_detail', $data_transaksi);

			$id_logsheets = $this->input->get_post('logsheet_id')[$key];
			$data_logsheets['id_transaksi_detail'] = $data_transaksi['transaksi_detail_id'];
			$data_logsheets['logsheet_review'] = $session['user_nik_sap'];
			$data_logsheets['logsheet_review_date'] = date('Y-m-d');
			$data_logsheets['logsheet_last_update'] = date('Y-m-d');
			$data_logsheets['is_kan'] = $this->input->get_post('is_kan');
			$data_logsheets['is_ds'] = $this->input->get_post('is_ds');
			$data_logsheets['id_template_footer'] = $this->input->get_post('id_template_footer');
			$data_logsheets['logsheet_keterangan'] = $this->input->get_post('logsheet_keterangan');
			$this->M_inbox->updateLogSheet($id_logsheets, $data_logsheets);

			// untuk qr code nya
			$param['logsheet_multiple_id'] = $this->input->get_post('transaksi_detail_group');
			$data_log = $this->M_multi_sample->getLogsheetGroup($param);
			$url = array();
			$nama_review = $data_log['nama_review'];
			$tanggal_review = $data_log['logsheet_review_date'];
			$last_update = $data_log['logsheet_last_update'];;

			$review = "Nama Reviewer : " . $nama_review . "";
			$review .= ", Approver Reviewer : " . $tanggal_review . "";
			// $review .= ", Update Terakhir : " . $last_update . "";

			/* QRCODE */
			$this->load->library('ciqrcode'); //pemanggilan library QR CODE
			$config['cacheable']    = true; //boolean, the default is true
			$config['cachedir']     = './application/cache/'; //string, the default is application/cache/
			$config['errorlog']     = './application/logs/'; //string, the default is application/logs/
			$config['imagedir']     = './img/'; //direktori penyimpanan qr code
			$config['quality']      = true; //boolean, the default is true
			$config['size']         = '1024'; //interger, the default is 1024
			$config['black']        = array(224, 255, 255); // array, default is array(255,255,255)
			$config['white']        = array(70, 130, 180); // array, default is array(0,0,0)
			$this->ciqrcode->initialize($config);

			$nim = $data_log['logsheet_multiple_id'] . $data_log['nama_review'];
			$image_name = $nim . '.png'; //buat name dari qr code sesuai dengan nim

			$params['data'] = $review; //data yang akan di jadikan QR CODE
			$params['level'] = 'H'; //H=High
			$params['size'] = 5;
			$params['savename'] = FCPATH . $config['imagedir'] . $image_name; //simpan image QR CODE ke folder assets/images/
			$this->ciqrcode->generate($params);

			$id_logsheets_1 = $this->input->get_post('logsheet_id')[$key];
			$data_logsheets_1['logsheet_review_qr'] = $image_name;
			$this->M_inbox->updateLogSheet($id_logsheets_1, $data_logsheets_1);

			$param_disposisi['id_seksi'] = $session['id_seksi'];
			$param_disposisi['id_transaksi'] = $this->input->get_post('transaksi_id');
			$param_disposisi['id_transaksi_detail'] = $detail_id_temp;
			$data_disposisi['id_transaksi_detail'] = $data_transaksi['transaksi_detail_id'];
			$this->M_inbox->updateTransaksiSeksiDisposisi($param_disposisi, $data_disposisi);
		endforeach;

		$redirect = base_url() . "sample/multi_sample/reviewLogSheet/?header_menu=" . $this->input->get_post('header_menu') . "&menu_id=" . $this->input->get_post('menu_id') . "&transaksi_id=" . $this->input->get_post('transaksi_id') . "&transaksi_detail_group=" . $this->input->get_post('transaksi_detail_group') . "&transaksi_detail_status=10&template_logsheet_id=" . $this->input->get_post('template_logsheet_id') . '&transaksi_status=10';
		echo $redirect;
	}
	// kasie approve logsheet

	// kasie approve sertifikat
	public function insertApproveSertifikat()
	{
		$session = $this->session->userdata();
		$this->db->query("UPDATE sample.sample_logsheet SET is_approve='y' WHERE logsheet_multiple_id='" . $this->input->get_post('transaksi_detail_group') . "'");
	}
	// kasie approve sertifikat

	// send dof

	public function insertDOF()
	{
		$session = $this->session->userdata();
		/* buat file word */
		$param_where['transaksi_id'] = ($this->input->get_post('transaksi_id'));
		$param_where['logsheet_multiple_id'] = $this->input->get_post('multiple_logsheet_id');
		$param_where['template_logsheet_id'] = ($this->input->get_post('template_logsheet_id'));
		$param_where['id_logsheet_template'] = ($this->input->get_post('template_logsheet_id'));
		$param_where['transaksi_non_rutin_id'] = $this->input->get_post('transaksi_non_rutin_id');
		$param_where['transaksi_detail_status'] = $this->input->get_post('status');
		$param_where['transaksi_detail_group'] = $this->input->get_post('transaksi_detail_group');

		$logsheet_group = $this->M_multi_sample->getLogSheetGroup($param_where);
		$multi_detail = $this->M_multi_sample->getMultiDetail($param_where);
		$template = $this->M_template_logsheet->getTemplateLogsheet($param_where);
		$template_detail = $this->M_template_logsheet->getDetailLogsheet($param_where);

		$dataVP = $this->db->query("SELECT * FROM global.global_api_user WHERE user_unit_id = 'E44000' AND user_jobgrade = '2A'")->row_array();

		/* Penciptaan Dokumen DOCX */
		$dataFooter = explode(',', $logsheet_group['id_template_footer']);
		for ($i = 0; $i < count($dataFooter); $i++) {
			if ($i > 0) {
				$data_footer =  $this->db->query("SELECT * FROM sample.sample_footer_sertifikat WHERE footer_id = '" . $dataFooter[$i] . "'")->row_array();
				$isi_footer[$i + 1] = $data_footer['footer_isi'];
			}
		}

		if ($logsheet_group['is_kan'] == 'y') {
			$template = ($logsheet_group['is_ds'] == 'y') ? 'template_is_kan_ds.docx' : 'template_is_kan.docx';
		} else {
			$template = ($logsheet_group['is_ds'] == 'y') ? 'template_no_kan_ds.docx' : 'template_no_kan.docx';
		}

		$templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('./dokumen_dof/default/multiple_' . $template);
		$templateProcessor->setValues(
			[
				'jenis_sampel' => htmlspecialchars($logsheet_group['logsheet_jenis']),
				'peminta_jasa' => htmlspecialchars($logsheet_group['logsheet_peminta_jasa']),
				'nomor_permintaan' => htmlspecialchars($logsheet_group['logsheet_nomor_permintaan']),
				'tanggal_terima' => htmlspecialchars(date("d F Y", strtotime($logsheet_group['logsheet_tgl_terima']))),
				'tanggal_pengujian' => htmlspecialchars(date("d F Y", strtotime($logsheet_group['logsheet_tgl_uji']))),
				'asal_sampel' => htmlspecialchars($logsheet_group['logsheet_asal_sample']),
				'pengambilan_sampel_oleh' => htmlspecialchars($logsheet_group['logsheet_pengolah_sample']),
				'nama_vp' => htmlspecialchars($dataVP['user_nama']),
				'jabatan_vp' => htmlspecialchars($dataVP['user_post_title']),
				'isi_footer_1' => htmlspecialchars((isset($isi_footer[1])) ? $isi_footer[1] : ''),
				'isi_footer_2' => htmlspecialchars((isset($isi_footer[2])) ? $isi_footer[2] : ''),
				'isi_footer_3' => htmlspecialchars((isset($isi_footer[3])) ? $isi_footer[3] : ''),
			]
		);

		$hasil = array();
		foreach ($template_detail as $key_td => $val_td) :
			$list_rumus = $this->M_perhitungan_sample->getListRumus(array('id_rumus' => $val_td['rumus_id']));
			$detail_rumus = $this->M_perhitungan_sample->getDetailRumusSampleTemplate(array('id_rumus' => $val_td['rumus_id']));
			foreach ($multi_detail as $key_detail => $val_detail) :
				$logsheets = $this->M_multi_sample->getLogsheet(array('transaksi_id' => $this->input->get_post('transaksi_id'), 'logsheet_multiple_id' => $this->input->get_post('transaksi_detail_group'), 'id_transaksi_detail' => $val_detail['transaksi_detail_id']));
			endforeach;
			$logsheet_level_2 = $this->M_inbox->getLogsheetDetail(array('logsheet_multiple_id' => $this->input->get_post('transaksi_detail_group'), 'rumus_id' => $val_td['rumus_id']));
			foreach ($logsheet_level_2 as $key => $value) {
				$hasil[] = array(
					'nomor_sampel' => $value['logsheet_nomor_sample'],
					'jenis_uji' => $value['rumus_nama'],
					'satuan' => $value['rumus_satuan'],
					'hasil_uji' => $value['rumus_hasil'],
					'metoda' => $value['rumus_metoda'],
				);
			}
		endforeach;
		$templateProcessor->cloneBlock('hasil', 0, true, false, $hasil);

		$dataKeterangan = explode(',', $logsheet_group['logsheet_keterangan']);
		$keterangan = array();
		for ($i = 0; $i < count($dataKeterangan); $i++) {
			if ($i > 0) {
				$data_keterangan =  $this->db->query("SELECT * FROM sample.sample_keterangan_sertifikat WHERE keterangan_sertifikat_id = '" . $dataKeterangan[$i] . "'")->row_array();

				$keterangan[] = array(
					'keterangan' => $data_keterangan['keterangan_sertifikat_isi'],
				);
			}
		}
		$templateProcessor->cloneBlock('ket', 0, true, false, $keterangan);

		$pathToSave = FCPATH . './dokumen_dof/' . $this->input->get_post('transaksi_detail_group') . '.docx';

		$templateProcessor->saveAs($pathToSave);
		/* buat file word */

		/* convert base64 */
		$file_word = file_get_contents($pathToSave);
		$file_word_base64 = base64_encode($file_word);
		/* convert base64 */

		// kirim datanya ke dof
		$isi['typeId'] = $this->input->get_post('typeId');
		$isi['templateId'] = $this->input->get_post('templateId');
		$isi['classId'] = $this->input->get_post('classId');
		$isi['className'] = $this->input->get_post('ClassName');
		$isi['category'] = $this->input->get_post('category');
		$isi['responseSpeed'] = $this->input->get_post('responseSpeed');
		$isi['title'] = $this->input->get_post('title');
		$isi['drafterId'] = $this->input->get_post('drafterId');
		$isi['reviewerId'] = $this->input->get_post('reviewerId');
		$isi['approverId'] = $this->input->get_post('approverId');
		$isi['tujuanId'] = $this->input->get_post('tujuanId');
		$isi['cc'] = $this->input->get_post('cc');
		$isi['file_word'] = $file_word_base64;

		$tokenBearer = $session['access_token_dof'];

		$tokenUrl = $this->config->item('dof_url') . "/api/Docs/Create";

		$tokenContentArray = array(
			"TypeId" => $isi['typeId'],
			"TemplateId" => $isi['templateId'],
			"ClassId" => $isi['classId'],
			"Category" => $isi['category'],
			"ResponseSpeed" => $isi['responseSpeed'],
			"Title" => $isi['title'],
			"DrafterId" => $isi['drafterId'],
			"ReviewerIds" => $isi['reviewerId'],
			"ApproverIds" => $isi['approverId'],
			"TujuanIds" => $isi['tujuanId'],
			"CCIds" => $isi['cc'],
			"Base64" => $isi['file_word'],
		);

		$tokenContent = json_encode($tokenContentArray);

		$tokenHeaders = array(
			"User-Agent:PostmanRuntime/7.30.0",
			"Authorization:  Bearer " . $tokenBearer,
			"Content-Type: application/json"
		);

		$token = curl_init();
		curl_setopt($token, CURLOPT_URL, $tokenUrl);
		curl_setopt($token, CURLOPT_HTTPHEADER, $tokenHeaders);
		curl_setopt($token, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($token, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($token, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($token, CURLOPT_MAXREDIRS, 10);
		curl_setopt($token, CURLOPT_TIMEOUT, 0);
		curl_setopt($token, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($token, CURLOPT_POST, true);
		curl_setopt($token, CURLOPT_POSTFIELDS, $tokenContent);

		$item = curl_exec($token);
		curl_close($token);
		$item = (array)json_decode($item);

		// kirim datanya ke dof
		$data_dof['dof_identitas_id'] = create_id();
		$data_dof['tipe_id'] = $this->input->post('typeId');
		$data_dof['template_id'] = $this->input->post('templateId');
		$data_dof['klasifikasi_id'] = $this->input->post('classId');
		$data_dof['klasifikasi_nama'] = $this->input->post('className');
		$data_dof['kategori_id'] = $this->input->post('category');
		$data_dof['kecepatan_tanggap'] = $this->input->post('responseSpeed');
		$data_dof['judul'] = $this->input->post('title');
		$data_dof['drafter_id'] = $this->input->post('drafterId');
		$reviewerId = implode(',', $this->input->get_post('reviewerId'));
		$data_dof['reviewer_id'] = $reviewerId;
		$approverId = implode(',', $this->input->get_post('approverId'));
		$data_dof['approver_id'] = $approverId;
		$tujuanId = implode(',', $this->input->get_post('tujuanId'));
		$data_dof['tujuan_id'] = $tujuanId;
		if ($this->input->post('ccId')) {
			$ccId = implode(',', $this->input->get_post('ccId'));
			$data_dof['cc_id'] = $ccId;
		}
		$data_dof['transaksi_id'] = $this->input->post('transaksi_id');
		$data_dof['transaksi_detail_group'] = $this->input->post('transaksi_detail_group');
		$data_dof['id_surat'] = $item['id'];

		$this->db->insert('sample.sample_dof_identitas', $data_dof);


		/* Send Dokumen SFTP */
		$transaksi_detail = $this->db->query("SELECT * FROM sample.sample_transaksi_detail a LEFT JOIN sample.sample_logsheet b ON b.id_transaksi_detail = a.transaksi_detail_id WHERE transaksi_detail_group = '" . $this->input->get_post('transaksi_detail_group')	. "' AND transaksi_id = '" . $this->input->get_post('transaksi_id') . "' AND is_proses IS NULL")->result_array();

		foreach ($transaksi_detail as $key => $transaksi_detail_temp) {

			$transaksi_detail_id_baru = create_id();

			$id = $this->input->post('transaksi_id');
			$id_detail_update = $transaksi_detail_temp['transaksi_detail_id'];
			$data_detail_update['is_proses'] = 'y';
			$this->M_request->updateRequestDetail($data_detail_update, $id_detail_update);

			$id_logsheets = $transaksi_detail_temp['logsheet_id'];
			$data_logsheets['id_transaksi_detail'] = $transaksi_detail_id_baru;
			$data_logsheets['logsheet_last_update'] = date('Y-m-d H:i:s');
			$this->M_inbox->updateLogSheet($id_logsheets, $data_logsheets);

			/* Insert Transaksi Detail */
			$data['transaksi_detail_id_temp'] = $transaksi_detail_temp['transaksi_detail_id'];
			$data['transaksi_detail_id'] = $transaksi_detail_id_baru;
			$data['transaksi_id'] = $this->input->post('transaksi_id');
			$data['transaksi_detail_status'] = '17';
			$data['when_create'] = date('Y-m-d H:i:s');
			$data['who_create'] = ($session['user_id'] == '1') ?  'Super Admin' : $session['user_nama'];
			$data['who_seksi_create'] = $session['user_unit_id'];
			$this->M_inbox->insertInboxLogsheet($data);

			$this->db->query("UPDATE sample.sample_transaksi_detail SET transaksi_detail_group = '" . $this->input->post('transaksi_detail_group') . "' WHERE transaksi_detail_id = '" . $transaksi_detail_id_baru . "'");

			$param_disposisi['id_seksi'] = $session['id_seksi'];
			$param_disposisi['id_transaksi'] = $this->input->get_post('transaksi_id');
			$param_disposisi['id_transaksi_detail'] = $transaksi_detail_temp['transaksi_detail_id'];
			$data_disposisi['id_transaksi_detail'] = $transaksi_detail_id_baru;
			$this->M_inbox->updateTransaksiSeksiDisposisi($param_disposisi, $data_disposisi);
		}
	}
	// send dof

}

/* End of file MultiSample.php */
/* Location: ./application/modules/sample/controllers/MultiSample.php */