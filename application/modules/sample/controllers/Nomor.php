<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once('assets_tambahan/vendor/autoload.php');
require_once('assets_tambahan/vendor/phpoffice/phpword/bootstrap.php');

use PhpWord\src\PhpWord\PhpWord;
use PhpWord\src\PhpWord\Writer\Word2007;
use Aspose\Words\WordsApi;
use Aspose\Words\Model\Requests\ConvertDocumentRequest;
use FontLib\Table\Type\post;
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



// use PhpOffice\PhpWord\IOFactory;


class Nomor extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		isLogin();
		$this->load->model('sample/M_nomor');
		$this->load->model('sample/M_inbox');
		$this->load->model('sample/M_request');
		$this->load->model('master/M_rumus_multiple');
		$this->load->model('master/M_sample_jenis');
		$this->load->model('master/M_sample_pekerjaan');
	}

	public function index()
	{
		$isi['judul'] = 'Nomor Sample';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

		$this->load->view('tampilan/header', $isi);
		$this->load->view('tampilan/sidebar', $data);
		$this->load->view('sample/nomor');
		$this->load->view('tampilan/footer');
		$this->load->view('sample/nomor_js');
	}

	public function logsheetMultipleNomor()
	{
		$isi['judul'] = 'Logsheet Nomor Sample';
		$data = $this->session->userdata();
		$session = $data;
		$param = array();
		$where = array();
		$param['transaksi_detail_status'] = $this->input->get_post('status');
		$param['transaksi_rutin_id'] = $this->input->get_post('id_transaksi_rutin');
		$param['seksi_id'] = $session['id_seksi'];
		$param['role_id'] = $session['role_id'];

		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');
		$data['nomor'] = $this->M_nomor->getNomorById($param, $where);
		$data['nomor_detail'] = $this->M_nomor->getNomorDetail($param);
		$data['nomor_detail_group'] = $this->M_nomor->getNomorDetailGroup($param);
		$data['nomor_all'] = $this->M_nomor->getNomorAll($param);
		$data['rumus_all'] = $this->M_nomor->getRumusAll($param);

		$this->load->view('tampilan/header', $isi);
		$this->load->view('tampilan/sidebar', $data);
		$this->load->view('sample/logsheet_rutin/logsheet_multiple');
		$this->load->view('tampilan/footer');
		$this->load->view('sample/logsheet_rutin/logsheet_multiple_js');
	}

	public function draftMultipleNomor()
	{
		$isi['judul'] = 'Logsheet Nomor Sample';
		$data = $this->session->userdata();
		$session = $data;
		$param = array();
		$where = array();
		$param['transaksi_detail_status'] = $this->input->get_post('status');
		$param['transaksi_rutin_id'] = $this->input->get_post('id_transaksi_rutin');
		$param['seksi_id'] = $session['id_seksi'];
		$param['role_id'] = $session['role_id'];

		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');
		$data['nomor'] = $this->M_nomor->getNomorById($param, $where);
		$data['nomor_detail'] = $this->M_nomor->getNomorDetail($param);
		$data['nomor_detail_group'] = $this->M_nomor->getNomorDetailGroup($param);
		$data['nomor_all'] = $this->M_nomor->getNomorAll($param);
		$data['rumus_all'] = $this->M_nomor->getRumusAll($param);
		$data['logsheet_group'] = $this->M_nomor->getLogsheetGroup($param);
		$data['logsheet'] = $this->M_nomor->getLogsheet($param);
		$data['logsheet_detail'] = $this->M_nomor->getLogsheetDetail($param);


		$this->load->view('tampilan/header', $isi);
		$this->load->view('tampilan/sidebar', $data);
		$this->load->view('sample/logsheet_rutin/draft_multiple');
		$this->load->view('tampilan/footer');
		$this->load->view('sample/logsheet_rutin/draft_multiple_js');
	}

	public function reviewMultipleNomor()
	{
		$isi['judul'] = 'Logsheet Nomor Sample';
		$data = $this->session->userdata();
		$session = $data;
		$param = array();
		$where = array();
		$param['transaksi_detail_status'] = $this->input->get_post('status');
		$param['transaksi_rutin_id'] = $this->input->get_post('id_transaksi_rutin');
		$param['seksi_id'] = $session['id_seksi'];
		$param['role_id'] = $session['role_id'];

		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');
		$data['nomor'] = $this->M_nomor->getNomorById($param, $where);
		$data['nomor_detail'] = $this->M_nomor->getNomorDetail($param);
		$data['nomor_detail_group'] = $this->M_nomor->getNomorDetailGroup($param);
		$data['nomor_all'] = $this->M_nomor->getNomorAll($param);
		$data['rumus_all'] = $this->M_nomor->getRumusAll($param);
		$data['logsheet_group'] = $this->M_nomor->getLogsheetGroup($param);
		$data['logsheet'] = $this->M_nomor->getLogsheet($param);
		$data['logsheet_detail'] = $this->M_nomor->getLogsheetDetail($param);


		$this->load->view('tampilan/header', $isi);
		$this->load->view('tampilan/sidebar', $data);
		$this->load->view('sample/logsheet_rutin/review_multiple');
		$this->load->view('tampilan/footer');
		$this->load->view('sample/logsheet_rutin/review_multiple_js');
	}

	public function cetakMultipleNomor()
	{
		$data = $this->session->userdata();
		$session = $data;
		$param = array();
		$where = array();
		$param['transaksi_detail_status'] = $this->input->get_post('status');
		$param['transaksi_rutin_id'] = $this->input->get_post('id_transaksi_rutin');
		$param['seksi_id'] = $session['id_seksi'];
		$param['role_id'] = $session['role_id'];

		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');
		$data['nomor'] = $this->M_nomor->getNomorById($param, $where);
		$data['nomor_detail'] = $this->M_nomor->getNomorDetail($param);
		$data['nomor_detail_group'] = $this->M_nomor->getNomorDetailGroup($param);
		$data['nomor_all'] = $this->M_nomor->getNomorAll($param);
		$data['rumus_all'] = $this->M_nomor->getRumusAll($param);
		$data['logsheet_group'] = $this->M_nomor->getLogsheetGroup($param);
		$data['logsheet'] = $this->M_nomor->getLogsheet($param);
		$data['logsheet_detail'] = $this->M_nomor->getLogsheetDetail($param);

		$this->load->view('sample/template/sertifikat_sample_rutin', $data);
	}

	public function cetakKonsepRutin()
	{
		$this->load->model('master/M_template_logsheet');

		$isi['judul'] = 'Lembar Kerja / Log Sheet';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');
		// $data['tipe'] = $this->input->get('tipe');

		$param['transaksi_id'] = anti_inject($this->input->get_post('transaksi_id'));
		$param['transaksi_detail_id'] = anti_inject($this->input->get_post('transaksi_detail_id'));
		// $param['transaksi_status'] = anti_inject($this->input->get_post('transaksi_status'));
		$param['transaksi_detail_status'] = anti_inject($this->input->get_post('transaksi_detail_status'));
		$param['template_logsheet_id'] = anti_inject($this->input->get_post('template_logsheet_id'));
		$param['logsheet_id'] = anti_inject($this->input->get_post('logsheet_id'));


		$result['inbox'] = $this->M_request->getRequestAll($param);
		$result['inbox_detail'] = $this->M_request->getRequestDetail($param);
		$result['logsheet'] = $this->M_inbox->getLogsheet($param);
		$result['logsheet_detail'] = $this->M_inbox->getLogsheetDetail($param);
		$result['sample'] = $this->M_request->getRequestAll($param);
		$result['sample_detail'] = $this->M_request->getRequestDetail($param);
		// print_r($result['logsheet_detail']);
		// die();
		$result['sample_jenis'] = $this->M_sample_jenis->getJenisSampleUJi($param);
		$result['pekerjaan_jenis'] = $this->M_sample_pekerjaan->getJenisPekerjaan($param);

		$template = $this->M_template_logsheet->getTemplateLogsheet($param);

		$this->load->view('sample/cetak/cetak_konsep_rutin', $result);
	}

	public function getNomor()
	{
		$isi = $this->session->userdata();

		$datanya = array();
		$param['seksi_id'] = $isi['id_seksi'];
		$param['role_id'] = $isi['role_id'];
		$param['transaksi_detail_status'] = $this->input->get_post('status_cari');
		$param['tanggal_cari'] = $this->input->get_post('tanggal_cari');
		$param['tanggal_cari_awal'] = $this->input->get_post('tanggal_cari_awal');
		$param['tanggal_cari_akhir'] = $this->input->get_post('tanggal_cari_akhir');

		$where = array();
		if (!empty($param['tanggal_cari'])) {
			$tgl_ini = date($param['tanggal_cari'] . '-d');
			$where['transaksi_rutin_tgl >= '] = date('Y-m-01', strtotime($tgl_ini));
			$where['transaksi_rutin_tgl <= '] = date('Y-m-t', strtotime($tgl_ini));
		} else if (!empty($param['tahun_cari'])) {
			$where['transaksi_rutin_tgl >= '] = $param['tahun_cari'] . '-01-01';
			$where['transaksi_rutin_tgl <= '] = $param['tahun_cari'] . '-12-31';
		}

		if ($param['seksi_id'] == '8a1768c878c3a337463221980a5fc5aea01f588f') {
			$data = $this->M_nomor->getNomorAuto($param, $where);

			foreach ($data as $value) {
				$sql_kasie = $this->db->query("SELECT COUNT(*) as total FROM global.global_seksi WHERE seksi_kepala = '" . $isi['user_id'] . "'");
				$data_kasie = $sql_kasie->row_array();

				$value['kasie'] = ($data_kasie['total'] > 0) ? 'y' : 'n';
				array_push($datanya, $value);
			}
		} else {
			$data = $this->M_nomor->getNomor($param, $where);
			foreach ($data as $value) {
				$sql_kasie = $this->db->query("SELECT COUNT(*) as total FROM global.global_seksi WHERE seksi_kepala = '" . $isi['user_id'] . "'");
				$data_kasie = $sql_kasie->row_array();

				$value['kasie'] = ($data_kasie['total'] > 0) ? 'y' : 'n';
				array_push($datanya, $value);
			}
		}

		echo json_encode($datanya);
	}

	public function getNomorDOF()
	{
		$param['transaksi_rutin_id'] = $this->input->get_post('transaksi_rutin_id');
		$data = $this->M_nomor->getNomorDOF($param);
		echo json_encode($data);
	}

	public function getNomorDetail()
	{
		$param['transaksi_rutin_id'] = $this->input->get('transaksi_rutin_id');

		$data = $this->M_nomor->getNomorDetail($param);

		echo json_encode($data);
	}

	public function insertProses()
	{
		$this->load->model('M_lab');
		$isi = $this->session->userdata();
		$tgl = date('Y-m-d H:i:s');

		$nomor = $this->M_nomor->getNomorMax();
		$isi_nomor = ($nomor['isi'] != null) ? ($nomor['isi'] + 1) : 1;
		$digi = 'DIGILABS';
		$tahun = date('Y');
		$dep = ($this->input->get_post('transaksi_approver_poscode') == 'E35000000') ? 'EXT' : 'INT';

		$newNomor = sprintf("%05d", $isi_nomor) . '/' . 'PR.01.02' . '/' . $dep . '/' . $digi . '/' . $tahun;

		/* Insert Transaksi Rutin */
		$this->M_nomor->deleteNomorRutin($this->input->post('transaksi_rutin_id'));

		$data_rutin['transaksi_rutin_id'] = $this->input->post('transaksi_rutin_id');
		$data_rutin['transaksi_rutin_tgl'] = $tgl;
		$data_rutin['when_create'] = date('Y-m-d H:i:s');
		$data_rutin['who_create'] = $isi['user_nama_lengkap'];
		$data_rutin['who_seksi_create'] = $isi['id_seksi'];

		$this->M_nomor->insertNomorRutin($data_rutin);
		/* Insert Transaksi Rutin */

		for ($i = 0; $i < $this->input->post('jumlah_sample'); $i++) {
			/* Max Nomor */
			$param_nomor_detail['id_seksi'] = $isi['id_seksi'];
			$nomor = $this->M_nomor->getNomorMax();
			$nomor_detail = $this->M_nomor->getNomorDetailBySeksiMax($param_nomor_detail);
			/* Max Nomor */

			/* Insert Transaksi */
			$data['transaksi_id'] = create_id();
			$data['id_transaksi_rutin'] = $data_rutin['transaksi_rutin_id'];
			$data['transaksi_tgl'] = $tgl;
			$data['transaksi_tipe'] = 'R';
			$data['transaksi_status'] = NULL;
			$data['when_create'] = date('Y-m-d H:i:s');
			$data['who_create'] = $isi['user_nama_lengkap'];
			$data['who_seksi_create'] = $isi['id_seksi'];
			$data['id_transaksi_detail'] = create_id();
			$data['transaksi_nomor'] = $newNomor;
			$data['transaksi_urut'] = $nomor['isi'] + 1;

			$this->M_nomor->insertNomor($data);
			/* Insert Transaksi */

			$seksi = $this->db->get_where('global.global_seksi', ['seksi_id' => $isi['id_seksi']])->row_array();

			$range = range(
				'K',
				'O'
			);

			$param_nomor_baru['range'] = $range[$i];
			$param_nomor_baru['transaksi_tipe'] = $this->input->post('transaksi_tipe');
			$param_nomor_baru['seksi_kode'] = $seksi['disposisi_kode'];
			$bulan = date('m');
			$tahun = substr(date('Y'), -2);
			$seksi_tujuan = $seksi['disposisi_kode'];

			$nomor_baru = '';
			if ($i < count($range)) {
				$kode = $range[$i];
				$nomor_baru = $range[$i] . $seksi_tujuan . $bulan . $tahun . sprintf("%04d", ($nomor_detail['isi'] + 1));
			} else {
				$indexs = $i % count($range);
				$kode = $range[$indexs];
				$nomor_baru = $range[$indexs] . $seksi_tujuan . $bulan . $tahun . sprintf("%04d", ($nomor_detail['isi'] + 1));
			}

			/* Insert Request Detail */
			$data_detail['transaksi_detail_id'] = $data['id_transaksi_detail'];
			$data_detail['jenis_id'] = $this->input->post('jenis_id');
			$data_detail['peminta_jasa_id'] = $this->input->post('peminta_jasa_id');
			$data_detail['jenis_pekerjaan_id'] = $this->input->post('jenis_pekerjaan_id');
			$data_detail['transaksi_id'] = $data['transaksi_id'];
			$data_detail['transaksi_detail_jumlah'] = '1';
			$data_detail['transaksi_detail_parameter'] = ($this->input->post('parameter') == '') ? NULL : $this->input->post('parameter') * 1;
			$data_detail['transaksi_detail_tgl_pengajuan'] = $tgl;
			$data_detail['transaksi_detail_status'] = NULL;
			$data_detail['when_create'] = date('Y-m-d H:i:s');
			$data_detail['who_create'] = $isi['user_nama_lengkap'];
			$data_detail['who_seksi_create'] = $isi['id_seksi'];
			$data_detail['transaksi_detail_urut'] = $nomor_detail['isi'] + 1;
			$data_detail['transaksi_detail_nomor_sample'] = $nomor_baru;
			$data_detail['transaksi_detail_kode'] = $kode;

			$this->M_nomor->insertNomorDetail($data_detail);
			/* Insert Request Detail */
		}
	}

	public function editEasyui()
	{
		$id = $this->input->post('transaksi_detail_id');
		$data = array(
			'transaksi_detail_tgl_pengajuan' => date('Y-m-d', strtotime($this->input->get_post('transaksi_detail_tgl_pengajuan_baru'))),
			'identitas_id' => $this->input->post('identitas_id'),
			'transaksi_detail_parameter' => $this->input->post('transaksi_detail_parameter'),
			'transaksi_detail_note' => $this->input->post('transaksi_detail_note'),
			'peminta_jasa_id' => $this->input->get_post('peminta_jasa_id'),
			'jenis_id' => $this->input->get_post('jenis_id'),
			'jenis_pekerjaan_id' => $this->input->get_post('jenis_pekerjaan_id')
		);

		$this->M_nomor->updateNomorDetail($data, $id);
	}

	public function deleteNomorEasyui()
	{
		$isi = $this->session->userdata();

		/* Insert Transaksi Detail */
		$id = $this->input->post('transaksi_id');
		$data = array(
			'transaksi_detail_status' => '8'
		);

		$this->M_nomor->deleteNomorDetail($data, $id);
		echo $this->db->last_query();
		/* Insert Transaksi Detail */

		/* Update Transaksi */
		$id = $this->input->post('transaksi_id');
		$data_detail = array(
			'transaksi_status' => '8',
			'when_create' => date('Y-m-d H:i:s'),
			'who_create' => $isi['user_nama_lengkap'],
			'who_seksi_create' => $isi['id_seksi'],
		);

		$this->M_nomor->deleteNomor($data_detail, $id);

		// $this->M_request->updateRequest($data_detail, $id);
		echo $this->db->last_query();
		/* Update Transaksi */
	}

	/* CLOSSED */
	public function updateClossed()
	{
		$isi = $this->session->userdata();

		if (isset($_FILES['transaksi_detail_file'])) {
			$upload_path = FCPATH . './document/';
			if (!file_exists($upload_path)) mkdir($upload_path);
			$allowed_mime_type_arr = array('application/pdf', '.doc', '.docx', '.xls', '.xlsx', '.ppt', '.pptx', 'image/jpeg', 'image/png', 'image/gif', 'image/bmp');
			$mime = get_mime_by_extension($_FILES['transaksi_detail_file']['name']);
			if (isset($_FILES['transaksi_detail_file']['name']) && $_FILES['transaksi_detail_file']['name'] != "") {
				if (in_array($mime, $allowed_mime_type_arr)) {
					/*upload excelnya*/
					$tmpName = $_FILES['transaksi_detail_file']['tmp_name'];
					$fileName = $_FILES['transaksi_detail_file']['name'];
					$fileType = $_FILES['transaksi_detail_file']['type'];

					$acak = rand(11111111, 99999999);
					$fileExt = substr($fileName, strpos($fileName, '.'));
					$fileExt = str_replace('.', '', $fileExt); // Extension
					$fileName = preg_replace("/\.[^.\s]{3,4}$/", "", $fileName);
					$newFileName = $fileName . str_replace(' ', '', $acak . '_' . date('ymdhis') . '.' . $fileExt);
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

		$data['transaksi_detail_file'] = $newFileName;
		$data['transaksi_detail_no_surat'] = $this->input->post('transaksi_detail_no_surat');
		$data['id_transaksi_rutin'] = $this->input->post('id_transaksi_rutin');
		$data['when_create'] = date('Y-m-d H:i:s');
		$data['who_create'] = $isi['user_nama_lengkap'];
		$data['who_seksi_create'] = $isi['id_seksi'];

		$this->M_nomor->updateClossed($data);

		$id = $this->input->post('id_transaksi_rutin');
		$data_utama['transaksi_status'] = '18';
		$data['when_create'] = date('Y-m-d H:i:s');
		$data['who_create'] = $isi['user_nama_lengkap'];
		$data['who_seksi_create'] = $isi['id_seksi'];

		$this->M_nomor->updateClose($data_utama, $id);
	}
	/* CLOSSED */

	/* CLOSSED DETAIL */
	public function updateClossedDetail()
	{
		$isi = $this->session->userdata();

		if (isset($_FILES['transaksi_detail_file'])) {
			$upload_path = FCPATH . './document/';
			if (!file_exists($upload_path)) mkdir($upload_path);
			$allowed_mime_type_arr = array('application/pdf', '.doc', '.docx', '.xls', '.xlsx', '.ppt', '.pptx', 'image/jpeg', 'image/png', 'image/gif', 'image/bmp');
			$mime = get_mime_by_extension($_FILES['transaksi_detail_file']['name']);
			if (isset($_FILES['transaksi_detail_file']['name']) && $_FILES['transaksi_detail_file']['name'] != "") {
				if (in_array($mime, $allowed_mime_type_arr)) {
					/*upload excelnya*/
					$tmpName = $_FILES['transaksi_detail_file']['tmp_name'];
					$fileName = $_FILES['transaksi_detail_file']['name'];
					$fileType = $_FILES['transaksi_detail_file']['type'];

					$acak = rand(11111111, 99999999);
					$fileExt = substr($fileName, strpos($fileName, '.'));
					$fileExt = str_replace('.', '', $fileExt); // Extension
					$fileName = preg_replace("/\.[^.\s]{3,4}$/", "", $fileName);
					$newFileName = $fileName . str_replace(' ', '', $acak . '_' . date('ymdhis') . '.' . $fileExt);
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

		$data['transaksi_detail_file'] = $newFileName;
		$data['transaksi_detail_no_surat'] = $this->input->post('transaksi_detail_no_surat');
		$data['id_transaksi'] = $this->input->post('id_transaksi');
		$data['when_create'] = date('Y-m-d H:i:s');
		$data['who_create'] = $isi['user_nama_lengkap'];
		$data['who_seksi_create'] = $isi['id_seksi'];

		$this->M_nomor->updateClossedDetail($data);

		$id = $this->input->post('id_transaksi');
		$data_utama['transaksi_status'] = '18';
		$data['when_create'] = date('Y-m-d H:i:s');
		$data['who_create'] = $isi['user_nama_lengkap'];
		$data['who_seksi_create'] = $isi['id_seksi'];

		$this->M_nomor->updateCloseDetail($data_utama, $id);
	}
	/* CLOSSED DETAIL */

	public function insertAuto()
	{
		$isi = $this->session->userdata();
		$tgl = date('Y-m-d H:i:s');

		/* Insert Transaksi Rutin */
		$data_rutin['transaksi_rutin_id'] = create_id();
		$data_rutin['transaksi_rutin_tgl'] = $tgl;
		$data_rutin['when_create'] = $tgl;
		$data_rutin['who_create'] = 'Auto';
		$data_rutin['who_seksi_create'] = '-';

		$this->M_nomor->insertNomorRutin($data_rutin);
		/* Insert Transaksi Rutin */

		// for ($i = 0; $i < 3; $i++) {
		/* Max Nomor */
		$nomor = $this->M_nomor->getNomorMax();
		/* Max Nomor */

		/* Insert Transaksi */
		$data['transaksi_id'] = create_id();
		$data['id_transaksi_rutin'] = $data_rutin['transaksi_rutin_id'];
		$data['transaksi_tgl'] = $tgl;
		$data['transaksi_tipe'] = 'R';
		$data['transaksi_status'] = '0';
		$data['when_create'] = $tgl;
		$data['who_create'] = 'Auto';
		$data['who_seksi_create'] = '-';
		$data['id_transaksi_detail'] = create_id();
		$data['transaksi_nomor'] = sprintf("%05d", ($nomor['isi'] + 1));

		$this->M_nomor->insertNomor($data);
		/* Insert Transaksi */

		/* Insert Request Detail */
		$data_detail['transaksi_detail_id'] = $data['id_transaksi_detail'];
		$data_detail['transaksi_id'] = $data['transaksi_id'];
		$data_detail['transaksi_detail_jumlah'] = '1';
		$data_detail['transaksi_detail_tgl_pengajuan'] = $tgl;
		$data_detail['transaksi_detail_status'] = '0';
		$data_detail['when_create'] = $tgl;
		$data_detail['who_create'] = 'Auto';
		$data_detail['who_seksi_create'] = '-';

		$this->M_nomor->insertNomorDetail($data_detail);
		/* Insert Request Detail */
		// }
	}

	public function getAlert()
	{
		$isi = $this->session->userdata();
		$param['seksi_id'] = $isi['id_seksi'];

		$eksternal = $this->M_nomor->getEksternal($param);
		$internal = $this->M_nomor->getInternal($param);

		$rutin = 0;
		foreach ($this->M_nomor->getRutin($param) as $value) {
			if ($value['status'] == 0)
				$rutin++;
		}

		$data['eksternal'] = $eksternal['total'];
		$data['internal'] = $internal['total'];
		$data['rutin'] = $rutin;

		echo json_encode($data);
	}

	public function Reject()
	{
		$isi = $this->session->userdata();
		$param['transaksi_rutin_id'] = $this->input->get('id');

		foreach ($this->M_nomor->getNomorReject($param) as $value) {
			/* Insert Transaksi Detail */
			$data['transaksi_detail_id'] = create_id();
			$data['transaksi_id'] = $value['transaksi_id'];
			$data['transaksi_detail_status'] = '8';
			$data['when_create'] = date('Y-m-d H:i:s');
			$data['transaksi_detail_note'] = 'Sample Telah di Cancel / Dihapus diNomor Rutin';
			$data['transaksi_detail_parameter'] = $this->input->post('transaksi_detail_parameter');
			$data['who_create'] = $isi['user_nama_lengkap'];
			$data['who_seksi_create'] = $isi['id_seksi'];

			$this->M_nomor->insertReject($data);
			/* Insert Transaksi Detail */

			/* Update Transaksi */
			$id = $value['transaksi_id'];
			$data_detail = array(
				'id_transaksi_detail' => $data['transaksi_detail_id'],
				'transaksi_status' => '8',
				'when_create' => date('Y-m-d H:i:s'),
				'who_create' => $isi['user_nama_lengkap'],
				'who_seksi_create' => $isi['id_seksi'],
			);

			$this->M_request->updateRequest($data_detail, $id);
			/* Update Transaksi */
		}
	}

	public function simpanSample()
	{
		$isi = $this->session->userdata();
		$param['transaksi_rutin_id'] = $this->input->get('id');

		foreach ($this->M_nomor->getNomorReject($param) as $value) {
			/* Insert Transaksi Detail */
			$id = $value['transaksi_detail_id'];
			$data = array(
				'transaksi_detail_status' => '0'
			);

			$this->M_nomor->updateNomorDetail($data, $id);
			/* Insert Transaksi Detail */

			/* Update Transaksi */
			$id = $value['transaksi_id'];
			$data_detail = array(
				'transaksi_status' => '0',
				'when_create' => date('Y-m-d H:i:s'),
				'who_create' => $isi['user_nama_lengkap'],
				'who_seksi_create' => $isi['id_seksi'],
			);

			$this->M_request->updateRequest($data_detail, $id);
			/* Update Transaksi */
		}
	}

	public function Cancel()
	{
		$param['transaksi_rutin_id'] = $this->input->get_post('id');
		// print_r($param);
		// $data = $this
		$this->M_nomor->Cancel($param);
		$this->M_nomor->deleteNomorRutin($this->input->get_post('id'));
		// echo json_encode($data);
	}

	public function hapusNomorDetail()
	{
		$param = [
			'transaksi_id' => $this->input->get_post('transaksi_id'),
			'transaksi_detail_id' => $this->input->get_post('transaksi_detail_id'),
		];
		$this->M_nomor->hapusNomor($param);
		$this->M_nomor->hapusNomorDetail($param);
		// echo $this->db->last_query();
	}

	// PROSES LOGSHEET
	// insert logsheet
	public function insertLogsheetMultiple()
	{
		http: //10.14.41.130/test_digilab_v2/sample/nomor/logsheetMultipleNomor?header_menu=02&menu_id=0205&id_transaksi_rutin=1676365440689&status=0

		$param_url['header_menu'] = $this->input->post('header_menu');
		$param_url['menu_id'] = $this->input->post('menu_id');
		$param_url['id_transaksi_rutin'] = $this->input->post('transaksi_rutin_id');

		$session = $this->session->userdata();

		$data_transaksi = $this->db->query("SELECT a.transaksi_id, a.id_transaksi_rutin, a.transaksi_tipe, b.transaksi_detail_id, b.jenis_id, a.transaksi_nomor, c.peminta_jasa_nama FROM sample.sample_transaksi a LEFT JOIN sample.sample_transaksi_detail b ON a.id_transaksi_detail = b.transaksi_detail_id LEFT JOIN sample.sample_peminta_jasa c ON c.peminta_jasa_id = b.peminta_jasa_id WHERE id_transaksi_rutin = '" . $this->input->post('transaksi_rutin_id') . "' ORDER BY jenis_id ASC,CAST(transaksi_nomor AS INT) ASC")->result_array();

		// insert data logsheet
		foreach ($data_transaksi as $key_transaksi => $value_transaksi) {

			$data_rumus = $this->db->query("SELECT * FROM sample.sample_perhitungan_multiple a LEFT JOIN sample.sample_detail_multiple b ON a.multiple_rumus_id = b.id_multiple_rumus WHERE jenis_id = '" . $value_transaksi['jenis_id'] . "'")->result_array();

			$data_jenis = $this->M_rumus_multiple->getJenisSample(array('jenis_id' => $value_transaksi['jenis_id']));

			$param_logsheet = array();

			$param_logsheet['logsheet_id'] = create_id();
			$param_logsheet['logsheet_jenis'] = $data_jenis['jenis_nama'];
			$param_logsheet['logsheet_peminta_jasa'] = $value_transaksi['peminta_jasa_nama'];
			$param_logsheet['logsheet_nomor_permintaan'] = $value_transaksi['transaksi_nomor'];
			$param_logsheet['logsheet_tgl_sampling'] = date('Y-m-d', strtotime($this->input->get_post('transaksi_tanggal_uji')));
			$param_logsheet['logsheet_tgl_terima'] = date('Y-m-d', strtotime($this->input->get_post('transaksi_tanggal_terima')));
			$param_logsheet['logsheet_tgl_uji'] = date('Y-m-d', strtotime($this->input->get_post('transaksi_tanggal_uji')));
			$param_logsheet['logsheet_asal_sample'] = $this->input->get_post('transaksi_asal');
			$param_logsheet['logsheet_pengolah_sample'] = $this->input->get_post('transaksi_penerima');
			$param_logsheet['logsheet_jenis_nama'] = $data_jenis['jenis_nama'];
			$param_logsheet['id_transaksi'] = $value_transaksi['transaksi_id'];
			$param_logsheet['id_transaksi_detail'] = $value_transaksi['transaksi_detail_id'];
			$param_logsheet['when_create'] = date('Y-m-d H:i:s');
			$param_logsheet['who_create'] = ($session['role_id'] == '1') ? 'Super Admin' : $session['user_nama_lengkap'];
			$param_logsheet['id_nomor_rutin'] = $value_transaksi['id_transaksi_rutin'];
			$this->db->insert('sample.sample_logsheet', $param_logsheet);

			foreach ($data_rumus as $key_rumus => $value_rumus) {

				$random = $this->input->post('random_temp');

				$param_logsheet_detail = array();
				$param_logsheet_detail['logsheet_detail_id'] = create_id();
				$param_logsheet_detail['logsheet_id'] = $param_logsheet['logsheet_id'];
				$param_logsheet_detail['id_rumus'] = $value_rumus['detail_multiple_rumus_id'];
				$param_logsheet_detail['logsheet_detail_urut'] = $key_rumus + 1;
				$param_logsheet_detail['when_create'] = date('Y-m-d H:i:s');
				$param_logsheet_detail['who_create'] = ($session['role_id'] == '1') ? 'Super Admin' : $session['user_nama_lengkap'];
				$param_logsheet_detail['id_jenis'] = $value_transaksi['jenis_id'];
				$param_logsheet_detail['rumus_hasil'] = $this->input->post('logsheet_detail_rumus_hasil')[$value_transaksi['transaksi_detail_id']][$value_rumus['detail_multiple_rumus_id']];
				$param_logsheet_detail['rumus_metoda'] = $this->input->post('logsheet_detail_rumus_metoda')[$value_transaksi['transaksi_detail_id']][$value_rumus['detail_multiple_rumus_id']];
				$param_logsheet_detail['rumus_satuan'] = $this->input->post('logsheet_detail_rumus_satuan')[$value_transaksi['transaksi_detail_id']][$value_rumus['detail_multiple_rumus_id']];
				$param_logsheet_detail['logsheet_kesimpulan'] = $this->input->post('logsheet_kesimpulan')[$value_transaksi['transaksi_detail_id']][$value_rumus['detail_multiple_rumus_id']];
				$this->db->insert('sample.sample_logsheet_detail', $param_logsheet_detail);

				$data_parameter_rumus = $this->db->query("SELECT * FROM sample.sample_parameter_rumus WHERE id_parameter = '" . $value_rumus['detail_multiple_rumus_id'] . "'")->result_array();

				foreach ($data_parameter_rumus as $key_parameter_rumus => $value_parameter_rumus) {

					$param_logsheet_detail_detail['logsheet_detail_detail_id'] = rand();
					$param_logsheet_detail_detail['id_logsheet'] = $param_logsheet['logsheet_id'];
					$param_logsheet_detail_detail['id_logsheet_detail'] = $param_logsheet_detail['logsheet_detail_id'];
					$param_logsheet_detail_detail['rumus_detail_id'] = $value_parameter_rumus['detail_parameter_rumus_id'];
					$param_logsheet_detail_detail['id_rumus'] = $value_parameter_rumus['id_parameter'];
					$param_logsheet_detail_detail['rumus_detail_nama'] = $value_parameter_rumus['detail_parameter_rumus'];
					$param_logsheet_detail_detail['rumus_detail_isi'] = $this->input->get_post('logsheet_detail_rumus_isi')[$value_rumus['detail_multiple_rumus_id']][$value_parameter_rumus['detail_parameter_rumus_id']][$key_rumus];
					// $param_logsheet_detail_detail['rumus_detail_isi'] = $this->input->get_post('logsheet_detail_rumus_isi')[$value_parameter_rumus['detail_parameter_rumus_id']][$random];
					$param_logsheet_detail_detail['rumus_jenis'] = $value_parameter_rumus['rumus_jenis'];
					$param_logsheet_detail_detail['when_create'] = date('Y-m-d H:i:s');
					$param_logsheet_detail_detail['who_create'] = ($session['role_id'] == '1') ? 'Super Admin' : $session['user_nama_lengkap'];
					$param_logsheet_detail_detail['rumus_detail_urut'] = $value_parameter_rumus['rumus_detail_urut'];



					$this->db->insert('sample.sample_logsheet_detail_detail', $param_logsheet_detail_detail);
				}
			}
		}
		/* Insert Data Transaksi */

		// insert data logsheet rutin
		$param_logsheet_rutin['logsheet_rutin_id'] = $this->input->post('transaksi_rutin_id');
		$param_logsheet_rutin['logsheet_rutin_tanggal'] = date('Y-m-d H:i:s');
		$param_logsheet_rutin['when_create'] = date('Y-m-d H:i:s');
		$param_logsheet_rutin['who_create'] = ($session['role_id'] == '1') ? 'Super Admin' : $session['user_nama_lengkap'];
		$param_logsheet_rutin['who_seksi_create'] = $session['id_seksi'];

		$this->db->insert('sample.sample_logsheet_rutin', $param_logsheet_rutin);

		// $param_transaksi_rutin['transaksi_detail_no_surat'] = $this->input->post('transaksi_detail_no_surat');
		$param_rutin_detail['id_transaksi_rutin'] = $this->input->post('transaksi_rutin_id');
		$param_rutin_detail['when_create'] = date('Y-m-d H:i:s');
		$param_rutin_detail['who_create'] = ($session['role_id'] == '1') ? 'Super Admin' : $session['user_nama_lengkap'];
		$param_rutin_detail['who_seksi_create'] = $session['id_seksi'];
		$param_rutin_detail['transaksi_detail_status'] = '9';
		$this->M_nomor->updateNomorTransaksiDetail($param_rutin_detail);

		$id = $this->input->post('transaksi_rutin_id');
		$param_rutin['transaksi_status'] = '9';
		$param_rutin['when_create'] = date('Y-m-d H:i:s');
		$param_rutin['who_create'] = ($session['role_id'] == '1') ? 'Super Admin' : $session['user_nama_lengkap'];
		$param_rutin['who_seksi_create'] = $session['id_seksi'];
		$this->M_nomor->updateNomorTransaksi($id, $param_rutin);

		$redirect = base_url() . 'sample/nomor/draftMultipleNomor?header_menu=' . $param_url['header_menu'] . '&menu_id=' . $param_url['menu_id'] . '&id_transaksi_rutin=' . $param_url['id_transaksi_rutin'] . '&status=9';

		redirect($redirect, 'refresh');
	}
	// insert logsheet

	// insert draft
	public function insertLogsheetMultipleDraft()
	{
		$this->load->model('M_inbox');
		$this->load->library('ciqrcode'); //pemanggilan library QR CODE

		$param_url['header_menu'] = $this->input->post('header_menu');
		$param_url['menu_id'] = $this->input->post('menu_id');
		$param_url['id_transaksi_rutin'] = $this->input->post('transaksi_rutin_id');

		$session = $this->session->userdata();

		$data_logsheet = $this->M_nomor->getLogsheet(array('transaksi_rutin_id' => $this->input->get_post('transaksi_rutin_id')));

		foreach ($data_logsheet as $key_logsheet => $val_logsheet) {
			$id_rutin = $val_logsheet['id_nomor_rutin'];
			$param_logsheet['id_transaksi_detail'] = $val_logsheet['transaksi_detail_id'];
			$param_logsheet['logsheet_analisis'] = $session['user_nik_sap'];
			$param_logsheet['logsheet_analisis_date'] = date('Y-m-d H:i:s');
			$param_logsheet['logsheet_last_update'] = date('Y-m-d H:i:s');

			$this->M_nomor->updateLogSheet($id_rutin, $param_logsheet);

			$data_analisa = $this->M_inbox->getLogsheet(array('logsheet_id' => $val_logsheet['logsheet_id']));

			$url = array();
			$nama_analisa = $data_analisa['nama_analisis'];
			$tanggal_analisa = $data_analisa['logsheet_analisis_date'];

			$analisa = "Nama Analis : " . $nama_analisa . "";
			$analisa .= ", Date : " . $tanggal_analisa . "";

			$config['cacheable']    = true; //boolean, the default is true
			$config['cachedir']     = './application/cache/'; //string, the default is application/cache/
			$config['errorlog']     = './application/logs/'; //string, the default is application/logs/
			$config['imagedir']     = './img/'; //direktori penyimpanan qr code
			$config['quality']      = true; //boolean, the default is true
			$config['size']         = '1024'; //interger, the default is 1024
			$config['black']        = array(224, 255, 255); // array, default is array(255,255,255)
			$config['white']        = array(70, 130, 180); // array, default is array(0,0,0)

			$this->ciqrcode->initialize($config);

			$nim = $data_analisa['logsheet_id'] . $data_analisa['nama_analisis'];
			$image_name = $nim . '.png'; //buat name dari qr code sesuai dengan nim

			$params['data'] = $analisa; //data yang akan di jadikan QR CODE
			$params['level'] = 'H'; //H=High
			$params['size'] = 5;
			$params['savename'] = FCPATH . $config['imagedir'] . $image_name; //simpan image QR CODE ke folder assets/images/

			$this->ciqrcode->generate($params);
			$id_logsheet_qr = $val_logsheet['logsheet_id'];
			$data_logsheet_qr['logsheet_analisis_qr'] = $image_name;
			$this->M_inbox->updateLogSheet($id_logsheet_qr, $data_logsheet_qr);
		}

		$param_rutin_detail['id_transaksi_rutin'] = $this->input->post('transaksi_rutin_id');
		$param_rutin_detail['when_create'] = date('Y-m-d H:i:s');
		$param_rutin_detail['who_create'] = ($session['role_id'] == '1') ? 'Super Admin' : $session['user_nama_lengkap'];
		$param_rutin_detail['who_seksi_create'] = $session['id_seksi'];
		$param_rutin_detail['transaksi_detail_status'] = '10';

		$this->M_nomor->updateNomorTransaksiDetail($param_rutin_detail);

		$id = $this->input->post('transaksi_rutin_id');
		$param_rutin['transaksi_status'] = '10';
		$param_rutin['when_create'] = date('Y-m-d H:i:s');
		$param_rutin['who_create'] = ($session['role_id'] == '1') ? 'Super Admin' : $session['user_nama_lengkap'];
		$param_rutin['who_seksi_create'] = $session['id_seksi'];

		$this->M_nomor->updateNomorTransaksi($id, $param_rutin);

		$redirect = base_url() . 'sample/nomor/?header_menu=' . $param_url['header_menu'] . '&menu_id=' . $param_url['menu_id'];
		redirect($redirect, 'refresh');
	}
	// insert draft

	// insert aprrove kasie
	public function insertLogsheetMultipleReview()
	{
		$this->load->model('M_inbox');
		$this->load->library('ciqrcode'); //pemanggilan library QR CODE

		$param_url['header_menu'] = $this->input->post('header_menu');
		$param_url['menu_id'] = $this->input->post('menu_id');
		$param_url['id_transaksi_rutin'] = $this->input->post('transaksi_rutin_id');

		$session = $this->session->userdata();

		$data_logsheet = $this->M_nomor->getLogsheet(array('transaksi_rutin_id' => $this->input->get_post('transaksi_rutin_id')));

		foreach ($data_logsheet as $key_logsheet => $val_logsheet) {
			$id_rutin = $val_logsheet['id_nomor_rutin'];
			$param_logsheet['id_transaksi_detail'] = $val_logsheet['transaksi_detail_id'];
			$param_logsheet['logsheet_review'] = $session['user_nik_sap'];
			$param_logsheet['logsheet_review_date'] = date('Y-m-d H:i:s');
			$param_logsheet['logsheet_last_update'] = date('Y-m-d H:i:s');

			$this->M_nomor->updateLogSheet($id_rutin, $param_logsheet);

			$data_review = $this->M_inbox->getLogsheet(array('logsheet_id' => $val_logsheet['logsheet_id']));

			$url = array();
			$nama_review = $data_review['nama_review'];
			$tanggal_review = $data_review['logsheet_review_date'];

			$review = "Nama Analis : " . $nama_review . "";
			$review .= ", Date : " . $tanggal_review . "";

			$config['cacheable']    = true; //boolean, the default is true
			$config['cachedir']     = './application/cache/'; //string, the default is application/cache/
			$config['errorlog']     = './application/logs/'; //string, the default is application/logs/
			$config['imagedir']     = './img/'; //direktori penyimpanan qr code
			$config['quality']      = true; //boolean, the default is true
			$config['size']         = '1024'; //interger, the default is 1024
			$config['black']        = array(224, 255, 255); // array, default is array(255,255,255)
			$config['white']        = array(70, 130, 180); // array, default is array(0,0,0)

			$this->ciqrcode->initialize($config);

			$nim = $data_review['logsheet_id'] . $data_review['nama_review'];
			$image_name = $nim . '.png'; //buat name dari qr code sesuai dengan nim

			$params['data'] = $review; //data yang akan di jadikan QR CODE
			$params['level'] = 'H'; //H=High
			$params['size'] = 5;
			$params['savename'] = FCPATH . $config['imagedir'] . $image_name; //simpan image QR CODE ke folder assets/images/

			$this->ciqrcode->generate($params);
			$id_logsheet_qr = $val_logsheet['logsheet_id'];
			$data_logsheet_qr['logsheet_review_qr'] = $image_name;
			$this->M_inbox->updateLogSheet($id_logsheet_qr, $data_logsheet_qr);
		}

		$param_rutin_detail['id_transaksi_rutin'] = $this->input->post('transaksi_rutin_id');
		$param_rutin_detail['when_create'] = date('Y-m-d H:i:s');
		$param_rutin_detail['who_create'] = ($session['role_id'] == '1') ? 'Super Admin' : $session['user_nama_lengkap'];
		$param_rutin_detail['who_seksi_create'] = $session['id_seksi'];
		$param_rutin_detail['transaksi_detail_status'] = '11';

		$this->M_nomor->updateNomorTransaksiDetail($param_rutin_detail);

		$id = $this->input->post('transaksi_rutin_id');
		$param_rutin['transaksi_status'] = '11';
		$param_rutin['when_create'] = date('Y-m-d H:i:s');
		$param_rutin['who_create'] = ($session['role_id'] == '1') ? 'Super Admin' : $session['user_nama_lengkap'];
		$param_rutin['who_seksi_create'] = $session['id_seksi'];

		$this->M_nomor->updateNomorTransaksi($id, $param_rutin);

		/* Penciptaan Dokumen DOCX */
		$param_transaksi['transaksi_detail_status'] = '11';
		$param_transaksi['transaksi_rutin_id'] = $this->input->post('transaksi_rutin_id');
		$param_transaksi['seksi_id'] = $session['id_seksi'];
		$param_transaksi['role_id'] = $session['role_id'];


		$dataTransaksi = $this->M_nomor->getNomorDetailGroup($param_transaksi);
		$dataTransaksiGroup = $this->M_nomor->getLogsheetGroup($param_transaksi);

		$arr_nama_sample = array();
		$arr_peminta_jasa = array();
		foreach ($dataTransaksi as $value) {
			$arr_nama_sample[$value['jenis_nama']] = $value['jenis_nama'];
			$arr_peminta_jasa[$value['peminta_jasa_nama']] = $value['peminta_jasa_nama'];
		}
		$nama_sample = implode(', ', $arr_nama_sample);
		$peminta_jasa = implode(', ', $arr_peminta_jasa);

		$dataVP = $this->db->query("SELECT * FROM global.global_api_user WHERE user_unit_id = 'E44000' AND user_jobgrade = '2A'")->row_array();

		$dataLogsheet = $this->M_nomor->getLogsheet($param_transaksi);

		/* 		create docx */
		$templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('./dokumen_dof/default/template_rutin.docx');
		$templateProcessor->setValues(
			[
				'jenis_sampel' => htmlspecialchars($nama_sample),
				'peminta_jasa' => htmlspecialchars($peminta_jasa),
				'tanggal_terima' => htmlspecialchars(date("d F Y", strtotime($dataTransaksiGroup['logsheet_tgl_terima']))),
				'tanggal_pengujian' => htmlspecialchars(date("d F Y", strtotime($dataTransaksiGroup['logsheet_tgl_uji']))),
				'asal_sampel' => htmlspecialchars($dataTransaksiGroup['logsheet_asal_sample']),
				'pengambilan_sampel_oleh' => htmlspecialchars($dataTransaksiGroup['logsheet_pengolah_sample']),
				'nama_vp' => htmlspecialchars($dataVP['user_nama']),
				'jabatan_vp' => htmlspecialchars($dataVP['user_post_title']),
			]
		);

		$fancyTableStyle = [
			'borderSize'  => 6,
			'borderColor' => '000000',
			'cellMargin'  => 80,
			'alignment'   => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER,
			'layout'      => \PhpOffice\PhpWord\Style\Table::LAYOUT_AUTO,
			'unit'				=>	\PhpOffice\PhpWord\SimpleType\TblWidth::TWIP,
			'width' => 100 * 10, // not sure if width 100 is valid parameter though check the documentation
		];

		$table = new Table($fancyTableStyle);

		$row = $table->addRow();
		$row->addCell(1000, ['vMerge' => 'restart', 'vAlign' => 'center', 'borderColor' => '000000', 'borderSize' => 6,])->addText('No', array('align' => 'center', 'bold' => true, 'size' => 10,), array('align' => 'center'));
		$row->addCell(1000, ['vMerge' => 'restart', 'vAlign' => 'center', 'borderColor' => '000000', 'borderSize' => 6,])->addText('No Lab', array('align' => 'center', 'bold' => true, 'size' => 10), array('align' => 'center'));
		$row->addCell(1000, ['vMerge' => 'restart', 'vAlign' => 'center', 'borderColor' => '000000', 'borderSize' => 6,])->addText('No Identitas', array('align' => 'center', 'bold' => true, 'size' => 10), array('align' => 'center'));
		$row->addCell(1000, ['vMerge' => 'restart', 'vAlign' => 'center', 'borderColor' => '000000', 'borderSize' => 6,])->addText('Metoda', array('align' => 'center', 'bold' => true, 'size' => 10), array('align' => 'center'));

		$dataLogsheetGroup = $this->M_nomor->getLogsheetGroupIdentitas($param_transaksi);

		foreach ($dataLogsheetGroup as $keys => $vals) {
			$data_logsheet_jumlah = $this->db->query("SELECT count(*) as total FROM sample.sample_parameter_rumus WHERE id_parameter = '" . $vals['id_rumus'] . "' AND rumus_detail_input IS NULL")->row_array();

			if (strlen($vals['parameter_rumus']) <= 10) {
				$parameter_rumus = $vals['parameter_rumus'];
			} else {
				$potongan = substr($vals['parameter_rumus'], 0, 8);
				$potongan = rtrim($potongan);
				$last_char = substr($potongan, -1);
				if ($last_char === "." || $last_char === "!" || $last_char === "?") {
					$parameter_rumus = $potongan . "...";
				} else {
					$parameter_rumus = $potongan . "...";
				}
			}

			$row->addCell(1000, ['vMerge' => 'restart', 'gridSpan' => $data_logsheet_jumlah['total'], 'vAlign' => 'center', 'borderColor' => '000000', 'borderSize' => 6,])->addText($parameter_rumus, array('align' => 'center', 'bold' => true, 'size' => 10), array('align' => 'center'));
		}

		$row = $table->addRow();
		$row->addCell(1000, ['vMerge' => 'continue', 'borderColor' => '000000', 'borderSize' => 6,]);
		$row->addCell(1000, ['vMerge' => 'continue', 'borderColor' => '000000', 'borderSize' => 6,]);
		$row->addCell(1000, ['vMerge' => 'continue', 'borderColor' => '000000', 'borderSize' => 6,]);
		$row->addCell(1000, ['vMerge' => 'continue', 'borderColor' => '000000', 'borderSize' => 6,]);
		$dataLogsheetGroup = $this->M_nomor->getLogsheetGroupIdentitas($param_transaksi);
		foreach ($dataLogsheetGroup as $keys => $vals) {
			$data_logsheet_detail = $this->db->query("SELECT * FROM sample.sample_parameter_rumus WHERE id_parameter = '" . $vals['id_rumus'] . "' AND rumus_detail_input IS NULL")->result_array();
			foreach ($data_logsheet_detail as $k => $val) {
				if (strlen($val['detail_parameter_rumus']) <= 10) {
					$detail_rumus = $val['detail_parameter_rumus'];
				} else {
					$potongan = substr($val['detail_parameter_rumus'], 0, 8);
					$potongan = rtrim($potongan);
					$last_char = substr($potongan, -1);
					if ($last_char === "." || $last_char === "!" || $last_char === "?") {
						$detail_rumus = $potongan . "...";
					} else {
						$detail_rumus = $potongan . "...";
					}
				}
				$row->addCell(1000, ['vMerge' => 'restart', 'vAlign' => 'center', 'borderColor' => '000000', 'borderSize' => 6,])->addText($detail_rumus, array('align' => 'center', 'bold' => true, 'size' => 10), array('align' => 'center'));
			}
		}

		/*isi*/
		foreach ($dataLogsheet as $key => $value) {
			$identitas = $this->db->get_where('sample.sample_identitas', array('identitas_id' => $value['identitas_id']))->row_array();
			$row = $table->addRow();
			$row->addCell(1000)->addText($key + 1, array('align' => 'center', 'bold' => false, 'size' => 10), array('align' => 'center'));
			$row->addCell(1000)->addText($value['transaksi_nomor'], array('align' => 'center', 'bold' => false, 'size' => 10), array('align' => 'center'));
			$row->addCell(1000)->addText($identitas['identitas_nama'], array('align' => 'center', 'bold' => false, 'size' => 10), array('align' => 'center'));
			$row->addCell(1000)->addText($value['logsheet_metoda'], array('align' => 'center', 'bold' => false, 'size' => 10), array('align' => 'center'));
			$data_logsheet_detail = $this->db->query("SELECT * FROM sample.sample_logsheet_detail_detail WHERE id_logsheet = '" . $value['logsheet_id'] . "' AND rumus_jenis = 'I'")->result_array();
			foreach ($data_logsheet_detail as $k => $val) {
				$row->addCell(1000, ['vMerge' => 'restart', 'vAlign' => 'center'])->addText($val['rumus_detail_isi'], array('align' => 'center', 'bold' => false, 'size' => 10), array('align' => 'center'));
			}
		}

		$templateProcessor->setComplexBlock('{table}', $table);

		$pathToSave = FCPATH . '/dokumen_dof/' . $this->input->post('transaksi_rutin_id') . '.docx';
		$templateProcessor->saveAs($pathToSave);
		/* 		create docx */

		/* Send Dokumen SFTP */
		try {
			$dataFile = $this->input->post('transaksi_rutin_id') . '.docx';
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
					echo "Success";
				} else {
					echo "Failure";
					rewind($verbose);
					$verboseLog = stream_get_contents($verbose);
					echo "Verbose information:\n" . $verboseLog . "\n";
				}
			}
		} catch (Exception $e) {
			log_message("info", "Exception in uploading file to ftp---" . print_r($e->getMessage(), 1));
			echo "error exception" . $e->getMessage();
		}
		/* Send Dokumen SFTP */

		$redirect = base_url() . 'sample/nomor/reviewMultipleNomor?header_menu=' . $param_url['header_menu'] . '&menu_id=' . $param_url['menu_id'] . '&id_transaksi_rutin=' . $param_url['id_transaksi_rutin'] . '&status=11';
		redirect($redirect);
	}
	// insert approve kasie

	public function insertLogsheetMultipleApprove()
	{ {

			$param_url['header_menu'] = $this->input->post('header_menu');
			$param_url['menu_id'] = $this->input->post('menu_id');
			$param_url['id_transaksi_rutin'] = $this->input->post('transaksi_rutin_id');

			$session = $this->session->userdata();

			$data_logsheet = $this->M_nomor->getLogsheet(array('transaksi_rutin_id' => $this->input->get_post('transaksi_rutin_id')));

			foreach ($data_logsheet as $val_logsheet) {
				$id_logsheet = $val_logsheet['logsheet_id'];
				$param_logsheet['is_approve'] = 'y';
				$this->M_inbox->updateLogSheet($id_logsheet, $param_logsheet);
			}

			$param_rutin_detail['id_transaksi_rutin'] = $this->input->post('transaksi_rutin_id');
			$param_rutin_detail['when_create'] = date('Y-m-d H:i:s');
			$param_rutin_detail['who_create'] = ($session['role_id'] == '1') ? 'Super Admin' : $session['user_nama_lengkap'];
			$param_rutin_detail['who_seksi_create'] = $session['id_seksi'];
			$param_rutin_detail['transaksi_detail_status'] = '12';

			$this->M_nomor->updateNomorTransaksiDetail($param_rutin_detail);

			$id = $this->input->post('transaksi_rutin_id');
			$param_rutin['transaksi_status'] = '12';
			$param_rutin['when_create'] = date('Y-m-d H:i:s');
			$param_rutin['who_create'] = ($session['role_id'] == '1') ? 'Super Admin' : $session['user_nama_lengkap'];
			$param_rutin['who_seksi_create'] = $session['id_seksi'];

			$this->M_nomor->updateNomorTransaksi($id, $param_rutin);
		}
	}

	// reset logsheet
	public function insertReset()
	{
		$session = $this->session->userdata();

		$param['transaksi_id'] = $this->input->get_post('transaksi_id');
		$param['transaksi_detail_id'] = $this->input->get_post('transaksi_detail_id');
		$param['transaksi_detail_id_temp'] = $this->input->get_post('transaksi_detail_id_temp');
		$param['transaksi_non_rutin_id'] = $this->input->get_post('transaksi_non_rutin_id');
		$param['transaksi_tipe'] = $this->input->get_post('transaksi_tipe');
		$param['transaksi_detail_reject_alasan'] = $this->input->get_post('transaksi_reset_logsheet_alasan');


		$id_logsheet = $this->db->get_where('sample.sample_logsheet', array('id_nomor_rutin' => $this->input->get_post('transaksi_rutin_id')))->result_array();

		$jml_logsheet = count($id_logsheet);
		// reset data logsheet detail detail
		if ($jml_logsheet > 0) {
			foreach ($id_logsheet as $logsheet) :
				$id_logsheet_detail = $this->db->get_where('sample.sample_logsheet_detail', array('logsheet_id' => $logsheet['logsheet_id']))->result_array();
				foreach ($id_logsheet_detail as $key => $logsheet_detail) {
					$param_logsheet_detail_detail['id_logsheet'] = $logsheet_detail['logsheet_id'];
					$param_logsheet_detail_detail['id_logsheet_detail'] = $logsheet_detail['logsheet_detail_id'];
					$this->M_inbox->deleteLogsheetDetailDetail($param_logsheet_detail_detail);
				}
				// reset data logsheet detail
				$param_logsheet_detail['logsheet_id'] = $logsheet['logsheet_id'];
				$this->M_inbox->deleteLogsheetDetail($param_logsheet_detail);
			endforeach;
			$this->db->query("DELETE FROM sample.sample_logsheet WHERE id_nomor_rutin = '" . $this->input->get_post('transaksi_rutin_id') . "'");
		}

		$transaksi = $this->db->query("SELECT * FROM sample.sample_transaksi_detail a LEFT JOIN sample.sample_transaksi b ON a.transaksi_id = b.transaksi_id AND a.transaksi_detail_id = b.id_transaksi_detail WHERE id_transaksi_rutin = '" . $this->input->post('transaksi_rutin_id') . "' ORDER BY transaksi_nomor ASC")->result_array();

		$jumlah_transaksi = count($transaksi);

		if ($jumlah_transaksi > 0) {
			foreach ($transaksi as $key_trans => $val_trans) :

				$this->db->query("UPDATE sample.sample_transaksi SET transaksi_status = '8' WHERE id_transaksi_rutin = '" . $val_trans['id_transaksi_rutin'] . "'");

				$this->db->query("UPDATE sample.sample_transaksi_detail SET transaksi_detail_status = '8' WHERE transaksi_detail_id = '" . $val_trans['transaksi_detail_id'] . "' AND transaksi_id ='" . $val_trans['id_transaksi'] . "'");

			endforeach;
			// sampleLog($this->input->get_post('transaksi_id'), null, $this->input->get_post('transaksi_non_rutin_id'), $this->input->get_post('transaksi_tipe'), $data['transaksi_detail_status'], 'Pekerjaan Telah Direset Logsheet');
		}
	}
	// reset logsheet

	public function insertDOF()
	{
		$this->load->library('PdfGenerator');

		$session = $this->session->userdata();
		$param_url['header_menu'] = $this->input->post('header_menu');
		$param_url['menu_id'] = $this->input->post('menu_id');
		$param_url['id_transaksi_rutin'] = $this->input->post('transaksi_rutin_id');
		$param_transaksi['transaksi_detail_status'] = '17';
		$param_transaksi['transaksi_rutin_id'] = $this->input->post('transaksi_rutin_id');
		$param_transaksi['seksi_id'] = $session['id_seksi'];
		$param_transaksi['role_id'] = $session['role_id'];

		/* Penciptaan Dokumen DOCX */
		$param_transaksi['transaksi_detail_status'] = '11';
		$param_transaksi['transaksi_rutin_id'] = $this->input->post('transaksi_rutin_id');
		$param_transaksi['seksi_id'] = $session['id_seksi'];
		$param_transaksi['role_id'] = $session['role_id'];


		$dataTransaksi = $this->M_nomor->getNomorDetailGroup($param_transaksi);
		$dataTransaksiGroup = $this->M_nomor->getLogsheetGroup($param_transaksi);

		$arr_nama_sample = array();
		$arr_peminta_jasa = array();
		foreach ($dataTransaksi as $value) {
			$arr_nama_sample[$value['jenis_nama']] = $value['jenis_nama'];
			$arr_peminta_jasa[$value['peminta_jasa_nama']] = $value['peminta_jasa_nama'];
		}
		$nama_sample = implode(', ', $arr_nama_sample);
		$peminta_jasa = implode(', ', $arr_peminta_jasa);

		$dataVP = $this->db->query("SELECT * FROM global.global_api_user WHERE user_unit_id = 'E44000' AND user_jobgrade = '2A'")->row_array();

		$dataLogsheet = $this->M_nomor->getLogsheet($param_transaksi);

		/* 		create docx */
		$templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('./dokumen_dof/default/template_rutin.docx');
		$templateProcessor->setValues(
			[
				'jenis_sampel' => htmlspecialchars($nama_sample),
				'peminta_jasa' => htmlspecialchars($peminta_jasa),
				'tanggal_terima' => htmlspecialchars(date("d F Y", strtotime($dataTransaksiGroup['logsheet_tgl_terima']))),
				'tanggal_pengujian' => htmlspecialchars(date("d F Y", strtotime($dataTransaksiGroup['logsheet_tgl_uji']))),
				'asal_sampel' => htmlspecialchars($dataTransaksiGroup['logsheet_asal_sample']),
				'pengambilan_sampel_oleh' => htmlspecialchars($dataTransaksiGroup['logsheet_pengolah_sample']),
				'nama_vp' => htmlspecialchars($dataVP['user_nama']),
				'jabatan_vp' => htmlspecialchars($dataVP['user_post_title']),
			]
		);

		$fancyTableStyle = [
			'borderSize'  => 6,
			'borderColor' => '000000',
			'cellMargin'  => 80,
			'alignment'   => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER,
			'layout'      => \PhpOffice\PhpWord\Style\Table::LAYOUT_AUTO,
			'unit'				=>	\PhpOffice\PhpWord\SimpleType\TblWidth::TWIP,
			'width' => 100 * 10, // not sure if width 100 is valid parameter though check the documentation
		];

		$table = new Table($fancyTableStyle);

		$row = $table->addRow();
		$row->addCell(1000, ['vMerge' => 'restart', 'vAlign' => 'center', 'borderColor' => '000000', 'borderSize' => 6,])->addText('No', array('align' => 'center', 'bold' => true, 'size' => 10,), array('align' => 'center'));
		$row->addCell(1000, ['vMerge' => 'restart', 'vAlign' => 'center', 'borderColor' => '000000', 'borderSize' => 6,])->addText('No Lab', array('align' => 'center', 'bold' => true, 'size' => 10), array('align' => 'center'));
		$row->addCell(1000, ['vMerge' => 'restart', 'vAlign' => 'center', 'borderColor' => '000000', 'borderSize' => 6,])->addText('No Identitas', array('align' => 'center', 'bold' => true, 'size' => 10), array('align' => 'center'));
		$row->addCell(1000, ['vMerge' => 'restart', 'vAlign' => 'center', 'borderColor' => '000000', 'borderSize' => 6,])->addText('Metoda', array('align' => 'center', 'bold' => true, 'size' => 10), array('align' => 'center'));

		$dataLogsheetGroup = $this->M_nomor->getLogsheetGroupIdentitas($param_transaksi);

		foreach ($dataLogsheetGroup as $keys => $vals) {
			$data_logsheet_jumlah = $this->db->query("SELECT count(*) as total FROM sample.sample_parameter_rumus WHERE id_parameter = '" . $vals['id_rumus'] . "' AND rumus_detail_input IS NULL")->row_array();

			if (strlen($vals['parameter_rumus']) <= 10) {
				$parameter_rumus = $vals['parameter_rumus'];
			} else {
				$potongan = substr($vals['parameter_rumus'], 0, 8);
				$potongan = rtrim($potongan);
				$last_char = substr($potongan, -1);
				if ($last_char === "." || $last_char === "!" || $last_char === "?") {
					$parameter_rumus = $potongan . "...";
				} else {
					$parameter_rumus = $potongan . "...";
				}
			}

			$row->addCell(1000, ['vMerge' => 'restart', 'gridSpan' => $data_logsheet_jumlah['total'], 'vAlign' => 'center', 'borderColor' => '000000', 'borderSize' => 6,])->addText($parameter_rumus, array('align' => 'center', 'bold' => true, 'size' => 10), array('align' => 'center'));
		}

		$row = $table->addRow();
		$row->addCell(1000, ['vMerge' => 'continue', 'borderColor' => '000000', 'borderSize' => 6,]);
		$row->addCell(1000, ['vMerge' => 'continue', 'borderColor' => '000000', 'borderSize' => 6,]);
		$row->addCell(1000, ['vMerge' => 'continue', 'borderColor' => '000000', 'borderSize' => 6,]);
		$row->addCell(1000, ['vMerge' => 'continue', 'borderColor' => '000000', 'borderSize' => 6,]);
		$dataLogsheetGroup = $this->M_nomor->getLogsheetGroupIdentitas($param_transaksi);
		foreach ($dataLogsheetGroup as $keys => $vals) {
			$data_logsheet_detail = $this->db->query("SELECT * FROM sample.sample_parameter_rumus WHERE id_parameter = '" . $vals['id_rumus'] . "' AND rumus_detail_input IS NULL")->result_array();
			foreach ($data_logsheet_detail as $k => $val) {
				if (strlen($val['detail_parameter_rumus']) <= 10) {
					$detail_rumus = $val['detail_parameter_rumus'];
				} else {
					$potongan = substr($val['detail_parameter_rumus'], 0, 8);
					$potongan = rtrim($potongan);
					$last_char = substr($potongan, -1);
					if ($last_char === "." || $last_char === "!" || $last_char === "?") {
						$detail_rumus = $potongan . "...";
					} else {
						$detail_rumus = $potongan . "...";
					}
				}
				$row->addCell(1000, ['vMerge' => 'restart', 'vAlign' => 'center', 'borderColor' => '000000', 'borderSize' => 6,])->addText($detail_rumus, array('align' => 'center', 'bold' => true, 'size' => 10), array('align' => 'center'));
			}
		}

		/*isi*/
		foreach ($dataLogsheet as $key => $value) {
			$identitas = $this->db->get_where('sample.sample_identitas', array('identitas_id' => $value['identitas_id']))->row_array();
			$row = $table->addRow();
			$row->addCell(1000)->addText($key + 1, array('align' => 'center', 'bold' => false, 'size' => 10), array('align' => 'center'));
			$row->addCell(1000)->addText($value['transaksi_nomor'], array('align' => 'center', 'bold' => false, 'size' => 10), array('align' => 'center'));
			$row->addCell(1000)->addText($identitas['identitas_nama'], array('align' => 'center', 'bold' => false, 'size' => 10), array('align' => 'center'));
			$row->addCell(1000)->addText($value['logsheet_metoda'], array('align' => 'center', 'bold' => false, 'size' => 10), array('align' => 'center'));
			$data_logsheet_detail = $this->db->query("SELECT * FROM sample.sample_logsheet_detail_detail WHERE id_logsheet = '" . $value['logsheet_id'] . "' AND rumus_jenis = 'I'")->result_array();
			foreach ($data_logsheet_detail as $k => $val) {
				$row->addCell(1000, ['vMerge' => 'restart', 'vAlign' => 'center'])->addText($val['rumus_detail_isi'], array('align' => 'center', 'bold' => false, 'size' => 10), array('align' => 'center'));
			}
		}

		$templateProcessor->setComplexBlock('{table}', $table);

		$pathToSave = FCPATH . '/dokumen_dof/' . $this->input->post('transaksi_rutin_id') . '.docx';
		$templateProcessor->saveAs($pathToSave);
		/* 		create docx */

		/* Send Dokumen SFTP */
		try {
			$dataFile = $this->input->post('transaksi_rutin_id') . '.docx';
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
					echo "Success";
				} else {
					echo "Failure";
					rewind($verbose);
					$verboseLog = stream_get_contents($verbose);
					echo "Verbose information:\n" . $verboseLog . "\n";
				}
			}
		} catch (Exception $e) {
			log_message("info", "Exception in uploading file to ftp---" . print_r($e->getMessage(), 1));
			echo "error exception" . $e->getMessage();
		}
		/* Send Dokumen SFTP */
		/* Penciptaan Dokumen DOCX */

		/* convert dokumen yang sudah dibuat ke format base64 */
		$file_word = file_get_contents($pathToSave);
		$file_word_base64 = base64_encode($file_word);
		/* convert dokumen yang sudah dibuat ke format base64 */

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

		// $tokenContent = urldecode(http_build_query($tokenContentArray));
		$tokenContent = json_encode($tokenContentArray);

		$tokenHeaders = array(
			"User-Agent:PostmanRuntime/7.31.3",
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
		$data_dof['logsheet_id'] = $this->input->post('logsheet_id');
		// if ($this->input->post('transaksi_detail_group')) {
		// $data_dof['transaksi_detail_group'] = $this->input->post('transaksi_detail_group');
		// } else {
		// $data_dof['transaksi_detail_id'] = $this->input->post('transaksi_detail_id');
		// }
		$data_dof['transaksi_rutin_id'] = $this->input->post('transaksi_rutin_id');

		$data_dof['id_surat'] = $item['id'];

		$this->db->insert('sample.sample_dof_identitas', $data_dof);

		// kirim datanya ke dof

		$data_logsheet = $this->M_nomor->getLogsheet(array('transaksi_rutin_id' => $this->input->get_post('transaksi_rutin_id')));

		foreach ($data_logsheet as $val_logsheet) {
			$id_logsheets = $val_logsheet['logsheet_id'];
			// $param_logsheets['id_transaksi_detail'] = $this->input->get_post('transaksi_detail_id');
			$param_logsheets['logsheet_last_update'] = date('Y-m-d H:i:s');
			$param_logsheets['id_dokumen_tipe'] = $this->input->get_post('typeId');
			$param_logsheets['id_dokumen_template'] = $this->input->get_post('templateId');
			$param_logsheets['dokumen_template_file'] = $item['fileName'];

			$this->M_inbox->updateLogSheet($id_logsheets, $param_logsheets);
		}

		$param_rutin_detail['id_transaksi_rutin'] = $this->input->post('transaksi_rutin_id');
		$param_rutin_detail['when_create'] = date('Y-m-d H:i:s');
		$param_rutin_detail['who_create'] = ($session['role_id'] == '1') ? 'Super Admin' : $session['user_nama_lengkap'];
		$param_rutin_detail['who_seksi_create'] = $session['id_seksi'];
		$param_rutin_detail['transaksi_detail_status'] = '17';

		$this->M_nomor->updateNomorTransaksiDetail($param_rutin_detail);

		$id = $this->input->post('transaksi_rutin_id');
		$param_rutin['transaksi_status'] = '17';
		$param_rutin['when_create'] = date('Y-m-d H:i:s');
		$param_rutin['who_create'] = ($session['role_id'] == '1') ? 'Super Admin' : $session['user_nama_lengkap'];
		$param_rutin['who_seksi_create'] = $session['id_seksi'];

		$this->M_nomor->updateNomorTransaksi($id, $param_rutin);
		// }
		/* Penciptaan Dokumen DOCX */
		$redirect = base_url() . 'sample/nomor/?header_menu=' . $param_url['header_menu'] . '&menu_id=' . $param_url['menu_id'];
		// redirect($redirect, 'refresh');
	}

	public function insertCloseNonLetter()
	{

		$session = $this->session->userdata();


		$param_rutin_detail['id_transaksi_rutin'] = $this->input->post('id_transaksi_rutin');
		$param_rutin_detail['when_create'] = date('Y-m-d H:i:s');
		$param_rutin_detail['who_create'] = ($session['role_id'] == '1') ? 'Super Admin' : $session['user_nama_lengkap'];
		$param_rutin_detail['who_seksi_create'] = $session['id_seksi'];
		$param_rutin_detail['transaksi_detail_status'] = '17';

		$this->M_nomor->updateNomorTransaksiDetail($param_rutin_detail);

		$id = $this->input->post('id_transaksi_rutin');
		$param_rutin['transaksi_status'] = '17';
		$param_rutin['when_create'] = date('Y-m-d H:i:s');
		$param_rutin['who_create'] = ($session['role_id'] == '1') ? 'Super Admin' : $session['user_nama_lengkap'];
		$param_rutin['who_seksi_create'] = $session['id_seksi'];

		$this->M_nomor->updateNomorTransaksi($id, $param_rutin);
	}
}
