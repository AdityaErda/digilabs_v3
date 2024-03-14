	<?php
	defined('BASEPATH') or exit('No direct script access allowed');
	require_once('assets_tambahan/vendor/autoload.php');

	use PhpWord\src\PhpWord\PhpWord;
	use PhpWord\src\PhpWord\Writer\Word2007;
	use PhpOffice\PhpWord\Element\Field;
	use PhpOffice\PhpWord\Element\Table;
	use PhpOffice\PhpWord\Element\TextRun;
	use PhpOffice\PhpWord\SimpleType\TblWidth;
	use Aspose\Words\WordsApi;
	use Aspose\Words\Model\Requests\ConvertDocumentRequest;
	use SebastianBergmann\Environment\Console;

	class Inbox extends MY_Controller
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
		}

		public function index()
		{
			$isi['judul'] = 'Inbox';
			$data = $this->session->userdata();
			$data['id_sidebar'] = $this->input->get('id_sidebar');
			$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');
			// $data['tipe'] = $this->input->get('tipe');

			$this->load->view('tampilan/header', $isi);
			$this->load->view('tampilan/sidebar', $data);
			$this->load->view('sample/inbox');
			$this->load->view('tampilan/footer');
			$this->load->view('sample/inbox_js');
		}

		/* Proses */
		public function procesInbox()
		{
			$isi['judul'] = 'Inbox';
			$data = $this->session->userdata();
			$data['id_sidebar'] = $this->input->get('id_sidebar');
			$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');
			// $data['tipe'] = $this->input->get('tipe');

			$param['transaksi_id'] = anti_inject($this->input->get_post('transaksi_id'));
			$param['transaksi_detail_id'] = anti_inject($this->input->get_post('transaksi_detail_id'));
			// $param['transaksi_status'] = anti_inject($this->input->get_post('transaksi_status'));
			$param['transaksi_detail_status'] = anti_inject($this->input->get_post('transaksi_detail_status'));

			$result['inbox'] = $this->M_request->getRequestAll($param);
			$result['inbox_detail'] = $this->M_request->getRequestDetail($param);
			$result['sample_jenis'] = $this->M_sample_jenis->getJenisSampleUJi($param);
			$result['pekerjaan_jenis'] = $this->M_sample_pekerjaan->getJenisPekerjaan($param);

			$this->load->view('tampilan/header', $isi);
			$this->load->view('tampilan/sidebar', $data);
			$this->load->view('sample/inbox_proces', $result);
			$this->load->view('tampilan/footer');
			$this->load->view('sample/inbox_proces_js');
		}

		public function procesLogSheet()
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
			$param['id_logsheet_template'] = $this->input->get_post('template_logsheet_id');
			$param['logsheet_id'] = $this->input->get_post('logsheet_id');

			$result['inbox'] = $this->M_request->getRequestAll($param);
			$result['inbox_detail'] = $this->M_request->getRequestDetail($param);
			$result['logsheet'] = $this->M_inbox->getLogsheet($param);
			$result['template_logsheet'] = $this->M_template_logsheet->getDetailLogsheet($param);
			$result['sample_jenis'] = $this->M_sample_jenis->getJenisSampleUJi($param);
			$result['pekerjaan_jenis'] = $this->M_sample_pekerjaan->getJenisPekerjaan($param);
			$result['pengambil_sample'] = $this->M_sample_jenis->getPengambil($param);


			$template = $this->M_template_logsheet->getTemplateLogsheet($param);
			// kuery menentukan template

			$this->load->view('tampilan/header', $isi);
			$this->load->view('tampilan/sidebar', $data);
			$this->load->view('sample/logsheet_single/logsheet_proces', $result);
			$this->load->view('tampilan/footer');
			$this->load->view('sample/logsheet_single/logsheet_proces_js');
		}

		public function viewLogSheet()
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
			$param['logsheet_id'] = $this->input->get_post('logsheet_id');

			$result['inbox'] = $this->M_request->getRequestAll($param);
			$result['inbox_detail'] = $this->M_request->getRequestDetail($param);

			$result['logsheet'] = $this->M_inbox->getLogsheet($param);
			$result['logsheet_detail'] = $this->M_inbox->getLogsheetDetail($param);

			$result['sample_jenis'] = $this->M_sample_jenis->getJenisSampleUJi($param);
			$result['pekerjaan_jenis'] = $this->M_sample_pekerjaan->getJenisPekerjaan($param);

			$template = $this->M_template_logsheet->getTemplateLogsheet($param);


			$this->load->view('tampilan/header', $isi);
			$this->load->view('tampilan/sidebar', $data);
			$this->load->view('sample/logsheet_single/logsheet_view', $result);
			$this->load->view('tampilan/footer');
			$this->load->view('sample/logsheet_single/logsheet_view_js');
		}

		public function editLogSheet()
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
			$param['logsheet_id'] = $this->input->get_post('logsheet_id');

			$result['inbox'] = $this->M_request->getRequestAll($param);
			$result['inbox_detail'] = $this->M_request->getRequestDetail($param);

			$result['logsheet'] = $this->M_inbox->getLogsheet($param);
			$result['logsheet_detail'] = $this->M_inbox->getLogsheetDetail($param);

			$result['sample_jenis'] = $this->M_sample_jenis->getJenisSampleUJi($param);
			$result['pekerjaan_jenis'] = $this->M_sample_pekerjaan->getJenisPekerjaan($param);

			$template = $this->M_template_logsheet->getTemplateLogsheet($param);


			$this->load->view('tampilan/header', $isi);
			$this->load->view('tampilan/sidebar', $data);
			$this->load->view('sample/logsheet_single/logsheet_edit', $result);
			$this->load->view('tampilan/footer');
			$this->load->view('sample/logsheet_single/logsheet_edit_js');
		}

		public function draftLogSheet()
		{
			$this->load->model('master/M_template_logsheet');

			$isi['judul'] = 'Preview Lembar Kerja / Log Sheet';
			$data = $this->session->userdata();
			$data['id_sidebar'] = $this->input->get('id_sidebar');
			$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');
			// $data['tipe'] = $this->input->get('tipe');

			$param['transaksi_id'] = anti_inject($this->input->get_post('transaksi_id'));
			$param['transaksi_detail_id'] = anti_inject($this->input->get_post('transaksi_detail_id'));
			// $param['transaksi_status'] = anti_inject($this->input->get_post('transaksi_status'));
			$param['transaksi_detail_status'] = anti_inject($this->input->get_post('transaksi_detail_status'));
			$param['template_logsheet_id'] = anti_inject($this->input->get_post('template_logsheet_id'));
			$param['id_logsheet_template'] = anti_inject($this->input->get_post('template_logsheet_id'));

			$param['logsheet_id'] = $this->input->get_post('logsheet_id');

			$result['inbox'] = $this->M_request->getRequestAll($param);
			$result['inbox_detail'] = $this->M_request->getRequestDetail($param);
			$result['logsheet'] = $this->M_inbox->getLogsheet($param);
			$result['logsheet_detail'] = $this->M_inbox->getLogsheetDetail($param);
			$result['detail_logsheet'] = $this->M_template_logsheet->getDetailLogsheet($param);
			$result['sample_jenis'] = $this->M_sample_jenis->getJenisSampleUJi($param);
			$result['pekerjaan_jenis'] = $this->M_sample_pekerjaan->getJenisPekerjaan($param);

			$template = $this->M_template_logsheet->getTemplateLogsheet($param);


			$this->load->view('tampilan/header', $isi);
			$this->load->view('tampilan/sidebar', $data);
			$this->load->view('sample/logsheet_single/logsheet_draft', $result);
			$this->load->view('tampilan/footer');
			$this->load->view('sample/logsheet_single/logsheet_draft_js');
		}

		public function reviewLogSheet()
		{
			$this->load->model('master/M_template_logsheet');

			$isi['judul'] = 'Konsep Lembar Kerja / Log Sheet';
			$data = $this->session->userdata();
			$data['id_sidebar'] = $this->input->get('id_sidebar');
			$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');
			// $data['tipe'] = $this->input->get('tipe');

			$param['transaksi_id'] = anti_inject($this->input->get_post('transaksi_id'));
			$param['transaksi_detail_id'] = anti_inject($this->input->get_post('transaksi_detail_id'));
			// $param['transaksi_status'] = anti_inject($this->input->get_post('transaksi_status'));
			$param['transaksi_detail_status'] = anti_inject($this->input->get_post('transaksi_detail_status'));
			$param['template_logsheet_id'] = anti_inject($this->input->get_post('template_logsheet_id'));
			$param['id_logsheet_template'] = anti_inject($this->input->get_post('template_logsheet_id'));
			$param['logsheet_id'] = $this->input->get_post('logsheet_id');

			$result['inbox'] = $this->M_request->getRequestAll($param);
			$result['inbox_detail'] = $this->M_request->getRequestDetail($param);

			$result['detail_logsheet'] = $this->M_template_logsheet->getDetailLogsheet($param);
			$result['logsheet'] = $this->M_inbox->getLogsheet($param);
			$result['logsheet_detail'] = $this->M_inbox->getLogsheetDetail($param);

			$result['sample_jenis'] = $this->M_sample_jenis->getJenisSampleUJi($param);
			$result['pekerjaan_jenis'] = $this->M_sample_pekerjaan->getJenisPekerjaan($param);

			$template = $this->M_template_logsheet->getTemplateLogsheet($param);


			$this->load->view('tampilan/header', $isi);
			$this->load->view('tampilan/sidebar', $data);
			$this->load->view('sample/logsheet_single/logsheet_review', $result);
			$this->load->view('tampilan/footer');
			$this->load->view('sample/logsheet_single/logsheet_review_js');
		}

		public function reviewSertifikat()
		{
			$this->load->model('master/M_template_logsheet');

			$isi['judul'] = 'Konsep Sertifikat';
			$data = $this->session->userdata();
			$data['id_sidebar'] = $this->input->get('id_sidebar');
			$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');
			// $data['tipe'] = $this->input->get('tipe');

			$param['transaksi_id'] = anti_inject($this->input->get_post('transaksi_id'));
			$param['transaksi_detail_id'] = anti_inject($this->input->get_post('transaksi_detail_id'));
			// $param['transaksi_status'] = anti_inject($this->input->get_post('transaksi_status'));
			$param['transaksi_detail_status'] = anti_inject($this->input->get_post('transaksi_detail_status'));
			$param['template_logsheet_id'] = anti_inject($this->input->get_post('template_logsheet_id'));
			$param['logsheet_id'] = $this->input->get_post('logsheet_id');

			$result['inbox'] = $this->M_request->getRequestAll($param);
			$result['inbox_detail'] = $this->M_request->getRequestDetail($param);

			$result['logsheet'] = $this->M_inbox->getLogsheet($param);

			$result['logsheet_detail'] = $this->M_inbox->getLogsheetDetail($param);


			$result['sample_jenis'] = $this->M_sample_jenis->getJenisSampleUJi($param);
			$result['pekerjaan_jenis'] = $this->M_sample_pekerjaan->getJenisPekerjaan($param);

			$template = $this->M_template_logsheet->getTemplateLogsheet($param);


			$this->load->view('tampilan/header', $isi);
			$this->load->view('tampilan/sidebar', $data);
			$this->load->view('sample/sertifikat_review', $result);
			$this->load->view('tampilan/footer');
			$this->load->view('sample/sertifikat_review_js');
		}


		public function cetakLogSheet()
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


			$result['logsheet'] = $this->M_inbox->getLogsheet($param);
			$result['inbox'] = $this->M_request->getRequestAll($param);
			$result['inbox_detail'] = $this->M_request->getRequestDetail($param);
			$result['logsheet_detail'] = $this->M_inbox->getLogsheetDetail($param);
			// print_r($result['logsheet_detail']);
			// die();
			$result['sample_jenis'] = $this->M_sample_jenis->getJenisSampleUJi($param);
			$result['pekerjaan_jenis'] = $this->M_sample_pekerjaan->getJenisPekerjaan($param);

			$template = $this->M_template_logsheet->getTemplateLogsheet($param);


			// $this->load->view('tampilan/header', $isi);
			// $this->load->view('tampilan/sidebar', $data);
			$this->load->view('sample/cetak/cetak_logsheet', $result);
			// $this->load->view('tampilan/footer');
			// $this->load->view('sample/cetak/view_logsheet_js');
		}

		public function cetakSertifikat()
		{
			$this->load->model('master/M_template_logsheet');

			$isi['judul'] = 'Lembar Kerja / Log Sheet';
			$data = $this->session->userdata();
			$data['id_sidebar'] = $this->input->get('id_sidebar');
			$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');
			// $data['tipe'] = $this->input->get('tipe');

			$param['transaksi_id'] = anti_inject($this->input->get_post('transaksi_id'));
			$param['transaksi_detail_id'] = anti_inject($this->input->get_post('transaksi_detail_id'));
			$param['logsheet_id'] = anti_inject($this->input->get_post('logsheet_id'));
			$param['transaksi_detail_status'] = anti_inject($this->input->get_post('transaksi_detail_status'));
			$param['template_logsheet_id'] = anti_inject($this->input->get_post('template_logsheet_id'));


			$result['inbox'] = $this->M_request->getRequestAll($param);
			$result['inbox_detail'] = $this->M_request->getRequestDetail($param);
			$result['logsheet'] = $this->M_inbox->getLogsheet($param);
			// echo $this->db->last_query();
			$result['logsheet_detail'] = $this->M_inbox->getLogsheetDetail($param);
			// print_r($result['logsheet_detail']);
			// die();
			$result['sample_jenis'] = $this->M_sample_jenis->getJenisSampleUJi($param);
			$result['pekerjaan_jenis'] = $this->M_sample_pekerjaan->getJenisPekerjaan($param);

			$template = $this->M_template_logsheet->getTemplateLogsheet($param);


			// $this->load->view('tampilan/header', $isi);
			// $this->load->view('tampilan/sidebar', $data);
			$this->load->view('sample/cetak/cetak_sertifikat', $result);
			// $this->load->view('tampilan/footer');
			// $this->load->view('sample/cetak/view_logsheet_js');
		}

		public function cetakKonsep()
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

			$this->load->view('sample/cetak/cetak_konsep', $result);
		}

		public function cetakSertifikatSingle()
		{
			$this->load->model('master/M_template_logsheet');

			// $isi['judul'] = 'Konsep Lembar Kerja / Log Sheet';
			$data = $this->session->userdata();
			$data['id_sidebar'] = $this->input->get('id_sidebar');
			$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

			$param['transaksi_id'] = anti_inject($this->input->get_post('transaksi_id'));
			$param['transaksi_detail_id'] = anti_inject($this->input->get_post('transaksi_detail_id'));
			$param['transaksi_detail_status'] = anti_inject($this->input->get_post('transaksi_detail_status'));
			$param['template_logsheet_id'] = anti_inject($this->input->get_post('template_logsheet_id'));
			$param['id_logsheet_template'] = anti_inject($this->input->get_post('template_logsheet_id'));
			$param['logsheet_id'] = $this->input->get_post('logsheet_id');

			$result['inbox'] = $this->M_request->getRequestAll($param);
			$result['inbox_detail'] = $this->M_request->getRequestDetail($param);

			$result['detail_logsheet'] = $this->M_template_logsheet->getDetailLogsheet($param);
			$result['logsheet'] = $this->M_inbox->getLogsheet($param);
			$result['logsheet_detail'] = $this->M_inbox->getLogsheetDetail($param);

			$result['sample_jenis'] = $this->M_sample_jenis->getJenisSampleUJi($param);
			$result['pekerjaan_jenis'] = $this->M_sample_pekerjaan->getJenisPekerjaan($param);

			$template = $this->M_template_logsheet->getTemplateLogsheet($param);

			$this->load->view('sample/template/sertifikat_logsheet_single', $result);
		}

		/* GET */
		public function getInbox()
		{
			$session = $this->session->userdata();

			if ($this->input->get('id_transaksi')) {
				$param['id_transaksi'] = $this->input->get('id_transaksi');
			} else {
				$param['transaksi_id'] = $this->input->get_post('transaksi_id');
				$param['status'] = $this->input->get_post('status');
				$param['seksi_id'] = $session['id_seksi'];
				$param['role_id'] = $session['role_id'];
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
			$data_inbox = $this->M_inbox->getInbox($param, $where);

			// echo $this->db->last_query();

			$data = array();
			foreach ($data_inbox as $value) {

				$dataSeksi = $this->db->query("SELECT count(*) AS total FROM sample.sample_seksi_disposisi WHERE id_transaksi_detail = '" . $value['transaksi_detail_id'] . "' AND id_seksi = '" . $session['id_seksi'] . "'")->row_array();
				
				$dataKasie = $this->db->query("SELECT COUNT(*) as total FROM global.global_seksi WHERE seksi_kepala = '" . $session['user_id'] . "'")->row_array();

				$dataPetugas = $this->db->query("SELECT count(*) AS total FROM sample.sample_petugas WHERE id_transaksi_detail = '" . $value['transaksi_detail_id'] . "' AND id_user = '" . $session['user_id'] . "'")->row_array();

				$value['kasie'] = ($dataKasie['total'] > 0) ? 'y' : 'n';
				$value['petugas'] = (($value['transaksi_tipe'] == 'E' && $dataPetugas['total'] > 0) || $value['transaksi_tipe'] == 'I') ? 'y' : 'n';
				if ($dataSeksi['total'] > 0 || $dataPetugas['total']>0) array_push($data, $value);
			}

			echo json_encode($data);
		}

		function getInboxJumlah()
		{
			$param['transaksi_detail_id'] = anti_inject($this->input->get_post('transaksi_detail_status'));

			$data = $this->M_inbox->getInboxJumlah($param);

			print_r($param);
		}

		// History
		public function getHistory()
		{
			$param['id_transaksi'] = $this->input->get_post('id_transaksi');

			$data = $this->M_inbox->getHistory($param);

			echo json_encode($data);
		}
		// HIstory

		public function getRequestDashboard()
		{
			$isi = $this->session->userdata();
			// print_r($isi);
			if ($this->input->get('tgl_cari')) $tgl = explode(' - ', $this->input->get('tgl_cari'));
			if ($this->input->get('tgl_cari')) $param['tgl_awal'] = date('Y-m-d', strtotime($tgl[0]));
			if ($this->input->get('tgl_cari')) $param['tgl_akhir'] = date('Y-m-d', strtotime($tgl[1]));
			if (empty($isi)) {
				if ($this->input->get('isi') != 'ok') if ($isi['role_id'] != '1') $param['seksi_id'] = $isi['user_unit_id'];
			}
			$param['transaksi_id'] = $this->input->get('transaksi_id');
			$param['transaksi_non_rutin_id'] = $this->input->get('transaksi_non_rutin_id');
			$param['transaksi_tipe'] = $this->input->get('transaksi_tipe');
			$param['tahun'] = $this->input->get('tahun');
			$param['transaksi_status'] = $this->input->get_post('transaksi_status');
			$param['transaksi_status_request'] = $this->input->get_post('transaksi_status_request');
			$param['tanggal_cari'] = $this->input->get_post('tanggal_cari');
			$param['tanggal_cari_awal'] = $this->input->get_post('tanggal_cari_awal');
			$param['tanggal_cari_akhir'] = $this->input->get_post('tanggal_cari_akhir');

			$where = array();
			if (!empty($param['tanggal_cari'])) {
				$tgl_ini = date($param['tanggal_cari'] . '-d');
				$where['DATE(transaksi_tgl) >= '] = date('Y-m-01', strtotime($tgl_ini));
				$where['DATE(transaksi_tgl) <= '] = date('Y-m-t', strtotime($tgl_ini));
			} else if (!empty($param['tanggal_cari_awal']) && !empty($param['tanggal_cari_akhir'])) {
				$tgl_ini = date($param['tanggal_cari_awal'] . '-d');
				$tgl_akhir = date($param['tanggal_cari_akhir'] . '-d');
				$where['DATE(transaksi_tgl) >= '] = date('Y-m-01', strtotime($tgl_ini));
				$where['DATE(transaksi_tgl) <= '] = date('Y-m-t', strtotime($tgl_akhir));
			} else if (!empty($param['tahun_cari'])) {
				$where['DATE(transaksi_tgl) >= '] = $param['tahun_cari'] . '-01-01';
				$where['DATE(transaksi_tgl) <= '] = $param['tahun_cari'] . '-12-31';
			}

			$data = $this->M_request->getRequest($param, $where);
			echo json_encode($data);
		}

		public function getRumusList()
		{
			$list['results'] = array();

			$param['param_search'] = anti_inject($this->input->get_post('param_search'));

			$cek = $this->M_inbox->getRumus($param);


			foreach ($this->M_perhitungan_sample->getPerhitunganSample($param) as $key => $value) {
				array_push($list['results'], [
					'id' => $value['rumus_id'],
					'text' => $value['rumus_nama'],
				]);
			}
			echo json_encode($list);
		}

		public function getLogSheet()
		{
			$param['logsheet_id'] = $this->input->get('logsheet_id');
			$data = $this->M_inbox->getLogsheet($param);
			echo json_encode($data);
		}

		public function getinboxDetail()
		{
			$param1['transaksi_id'] = $this->input->get_post('transaksi_id');
			$param['transaksi_non_rutin_id'] = $this->input->get_post('transaksi_non_rutin_id');
			$param['jenis_id'] = $this->input->get_post('jenis_id');
			$param['transaksi_detail_id'] = $this->input->get_post('transaksi_detail_id');
			$data = array();
			$data_library = $this->M_inbox->getInboxDetail($param);
			foreach ($data_library as $value) {
				$data_detail = array();
				$data_disposisi = $this->M_library->getLibraryDisposisi($param1);
				foreach ($data_disposisi as $val) {
					array_push($data_detail, $val['seksi_nama']);
				}
				$value['disposisi'] = implode(', ', $data_detail);

				array_push($data, $value);
			}
			echo json_encode($data);
		}
		/* GET */

		/* INSERT */
		/* Belum Diterima */
		public function insertBelumDiterima()
		{
			$isi = $this->session->userdata();

			/* Update Transaksi Detail */
			$id_detail = $this->input->get_post('transaksi_detail_id_temp');
			$data_detail['is_proses'] = 'y';

			$this->M_request->updateRequestDetail($data_detail, $id_detail);
			/* Update Transaksi Detail */

			/* Insert Transaksi Detail - Belum Diterima */
			$data['transaksi_detail_id_temp'] = $this->input->get_post('transaksi_detail_id_temp');
			$data['transaksi_detail_id'] = $this->input->get_post('transaksi_detail_id');
			$data['transaksi_id'] = $this->input->post('transaksi_id');
			$data['transaksi_detail_tgl_estimasi'] = date('Y-m-d H:i:s', strtotime($this->input->post('transaksi_detail_tgl_estimasi')));
			$data['transaksi_detail_status'] = '6';
			$data['transaksi_detail_tgl_memo'] = date('Y-m-d H:i:s', strtotime($this->input->post('transaksi_detail_tgl_memo')));
			$data['transaksi_detail_no_memo'] = $this->input->post('transaksi_detail_no_memo');
			$data['transaksi_detail_note'] = $this->input->post('transaksi_detail_note');
			$data['transaksi_detail_parameter'] = $this->input->post('transaksi_detail_parameter');
			$data['transaksi_detail_jumlah'] = $this->input->get_post('transaksi_detail_jumlah');;
			$data['when_create'] = date('Y-m-d H:i:s');
			$data['who_create'] = ($isi['user_id'] == '1') ?  'Super Admin' : $isi['user_nama'];
			$data['who_seksi_create'] = $isi['user_unit_id'];

			$this->M_inbox->insertInboxNew($data);
			/* Insert Transaksi Detail - Belum Diterima */

			/* Update Sample Seksi Disposisi */
			$param_disposisi['id_seksi'] = $isi['id_seksi'];
			$param_disposisi['id_transaksi'] = $data['transaksi_id'];
			$param_disposisi['id_transaksi_detail'] = $data['transaksi_detail_id_temp'];
			$data_disposisi['id_transaksi_detail'] = $data['transaksi_detail_id'];

			$this->M_inbox->updateTransaksiSeksiDisposisi($param_disposisi, $data_disposisi);
			/* Update Sample Seksi Disposisi */

			/* Update Petugas Sample */
			$this->db->query("UPDATE sample.sample_petugas SET id_transaksi_detail = '" . $data['transaksi_detail_id'] . "' WHERE id_transaksi_detail = '" . $data['transaksi_detail_id_temp'] . "'");
			/* Update Petugas Sample */

			sampleLog($this->input->get_post('transaksi_id'), null, $this->input->get_post('transaksi_non_rutin_id'), $this->input->get_post('transaksi_tipe'), $data['transaksi_detail_status'], 'Pekerjaan Belum Diterima Oleh Eksekutor');
		}
		/* Belum Diterima */


		/* Diterima */

		public function insertDiterima()
		{
			$isi = $this->session->userdata();

			/* Update Transaksi Detail */
			$id_detail = $this->input->get_post('transaksi_detail_id_temp');
			$data_detail['is_proses'] = 'y';

			$this->M_request->updateRequestDetail($data_detail, $id_detail);
			/* Update Transaksi Detail */

			/* Insert Transaksi Detail - Diterima */
			$data['transaksi_detail_id_temp'] = $this->input->get_post('transaksi_detail_id_temp');
			$data['transaksi_detail_id'] = $this->input->get_post('transaksi_detail_id');
			$data['transaksi_id'] = $this->input->post('transaksi_id');
			$data['transaksi_detail_tgl_estimasi'] = date('Y-m-d H:i:s', strtotime($this->input->post('transaksi_detail_tgl_estimasi')));
			$data['transaksi_detail_status'] = '7';
			$data['transaksi_detail_jumlah'] = $this->input->get_post('transaksi_detail_jumlah');;
			$data['transaksi_detail_parameter'] = $this->input->post('transaksi_detail_parameter');
			$data['transaksi_detail_deskripsi_parameter'] = $this->input->get_post('transaksi_detail_deskripsi_parameter');
			$data['when_create'] = date('Y-m-d H:i:s');
			$data['who_create'] = ($isi['user_id'] == '1') ?  'Super Admin' : $isi['user_nama'];
			$data['who_seksi_create'] = $isi['user_unit_id'];

			$this->M_inbox->insertInboxDiterima($data);
			/* Insert Transaksi Detail - Diterima */

			/* Update Sample Seksi Disposisi */
			$param_disposisi['id_seksi'] = $isi['id_seksi'];
			$param_disposisi['id_transaksi'] = $this->input->get_post('transaksi_id');
			$param_disposisi['id_transaksi_detail'] = $this->input->get_post('transaksi_detail_id_temp');
			$data_disposisi['id_transaksi_detail'] = $this->input->get_post('transaksi_detail_id');

			$this->M_inbox->updateTransaksiSeksiDisposisi($param_disposisi, $data_disposisi);
			/* Update Sample Seksi Disposisi */

			/* Update Petugas Sample */
			$this->db->query("UPDATE sample.sample_petugas SET id_transaksi_detail = '" . $data['transaksi_detail_id'] . "' WHERE id_transaksi_detail = '" . $data['transaksi_detail_id_temp'] . "'");
			/* Update Petugas Sample */

			sampleLog($this->input->get_post('transaksi_id'), null, $this->input->get_post('transaksi_non_rutin_id'), $this->input->get_post('transaksi_tipe'), $data['transaksi_detail_status'], 'Pekerjaan Telah Diterima Oleh Eksekutor');
		}

		/* Diterima */

		/* On Progress */
		public function insertProgress()
		{
			$isi = $this->session->userdata();

			/* Update Transaksi Detail */
			$id_detail = $this->input->get_post('transaksi_detail_id_temp');
			$data_detail['is_proses'] = 'y';

			$this->M_request->updateRequestDetail($data_detail, $id_detail);
			/* Update Transaksi Detail */

			/* Insert Transaksi Detail - On Progress Single */
			$data['transaksi_detail_id_temp'] = $this->input->get_post('transaksi_detail_id_temp');
			$data['transaksi_detail_id'] = $this->input->get_post('transaksi_detail_id');
			$data['transaksi_id'] = $this->input->post('transaksi_id');
			$data['transaksi_detail_tgl_estimasi'] = date('Y-m-d H:i:s', strtotime($this->input->post('transaksi_detail_tgl_estimasi')));
			$data['transaksi_detail_status'] = '8';
			$data['transaksi_detail_tgl_memo'] = date('Y-m-d H:i:s', strtotime($this->input->post('transaksi_detail_tgl_memo')));
			$data['transaksi_detail_no_memo'] = $this->input->post('transaksi_detail_no_memo');
			$data['transaksi_detail_note'] = $this->input->post('transaksi_detail_note');
			$data['transaksi_detail_parameter'] = $this->input->post('transaksi_detail_parameter');
			$data['transaksi_detail_jumlah'] = $this->input->get_post('transaksi_detail_jumlah');;
			$data['when_create'] = date('Y-m-d H:i:s');
			$data['who_create'] = ($isi['user_id'] == '1') ?  'Super Admin' : $isi['user_nama'];
			$data['who_seksi_create'] = $isi['user_unit_id'];

			$this->M_inbox->insertInboxNew($data);
			/* Insert Transaksi Detail - On Progress Single */

			/* Update Sample Seksi Disposisi */
			$param_disposisi['id_seksi'] = $isi['id_seksi'];
			$param_disposisi['id_transaksi'] = $this->input->get_post('transaksi_id');
			$param_disposisi['id_transaksi_detail'] = $this->input->get_post('transaksi_detail_id_temp');
			$data_disposisi['id_transaksi_detail'] = $this->input->get_post('transaksi_detail_id');

			$this->M_inbox->updateTransaksiSeksiDisposisi($param_disposisi, $data_disposisi);
			/* Update Sample Seksi Disposisi */

			/* Update Petugas Sample */
			$this->db->query("UPDATE sample.sample_petugas SET id_transaksi_detail = '" . $data['transaksi_detail_id'] . "' WHERE id_transaksi_detail = '" . $data['transaksi_detail_id_temp'] . "'");
			/* Update Petugas Sample */

			sampleLog($this->input->get_post('transaksi_id'), null, $this->input->get_post('transaksi_non_rutin_id'), $this->input->get_post('transaksi_tipe'), $data['transaksi_detail_status'], 'Pekerjaan Telah Diprogress Oleh Eksekutor (Single)');
		}
		/* On Progress */

		/* Terbit Sertifikat */
		public function insertTerbitSertifikat()
		{
			$isi = $this->session->userdata();

			/* Insert Transaksi Detail */
			$data['transaksi_detail_id'] = $this->input->get_post('transaksi_detail_id');
			$data['transaksi_id'] = $this->input->post('transaksi_id');
			$data['transaksi_detail_tgl_estimasi'] = date('Y-m-d H:i:s', strtotime($this->input->post('transaksi_detail_tgl_estimasi')));
			$data['transaksi_detail_status'] = '5';
			$data['transaksi_detail_tgl_memo'] = date('Y-m-d H:i:s', strtotime($this->input->post('transaksi_detail_tgl_memo')));
			$data['transaksi_detail_no_memo'] = $this->input->post('transaksi_detail_no_memo');
			$data['transaksi_detail_note'] = $this->input->post('transaksi_detail_note');
			$data['transaksi_detail_parameter'] = $this->input->post('transaksi_detail_parameter');
			$data['when_create'] = date('Y-m-d H:i:s');
			$data['who_create'] = $isi['user_nama_lengkap'];
			$data['who_seksi_create'] = $isi['id_seksi'];
			$data['transaksi_detail_jumlah'] = '1';

			$this->M_inbox->insertInbox($data);

			// redirect(base_url('inbox'));

			/* Insert Transaksi Detail */

			/* Update Transaksi */
			$id = $this->input->post('transaksi_id');
			$data_detail = array(
				'id_transaksi_detail' => $data['transaksi_detail_id'],
				'transaksi_status' => '5',
				'when_create' => date('Y-m-d H:i:s'),
				'who_create' => $isi['user_nama_lengkap'],
				'who_seksi_create' => $isi['id_seksi'],
			);

			$this->M_request->updateRequest($data_detail, $id);

			// redirect(base_url('inbox'));

			/* Update Transaksi */
		}
		/* Terbit Sertifikat */

		/* Tunda */
		public function insertTunda()
		{
			$isi = $this->session->userdata();

			/* Update Transaksi Detail */
			$id_detail = $this->input->get_post('transaksi_detail_id_temp');
			$data_detail['is_proses'] = 'y';

			$this->M_request->updateRequestDetail($data_detail, $id_detail);
			/* Update Transaksi Detail */

			/* Insert Transaksi Detail - Tunda */
			$data['transaksi_detail_id_temp'] = $this->input->get_post('transaksi_detail_id_temp');
			$data['transaksi_detail_id'] = $this->input->get_post('transaksi_detail_id');
			$data['transaksi_id'] = $this->input->post('transaksi_id');
			$data['transaksi_detail_tgl_estimasi'] = date('Y-m-d H:i:s', strtotime($this->input->post('transaksi_detail_tgl_estimasi')));
			$data['transaksi_detail_status'] = $this->input->get_post('transaksi_detail_status');
			$data['transaksi_detail_tgl_memo'] = date('Y-m-d H:i:s', strtotime($this->input->post('transaksi_detail_tgl_memo')));
			$data['transaksi_detail_no_memo'] = $this->input->post('transaksi_detail_no_memo');
			$data['transaksi_detail_note'] = $this->input->post('transaksi_detail_note');
			$data['transaksi_detail_parameter'] = $this->input->post('transaksi_detail_parameter');
			$data['transaksi_detail_reject_alasan'] = $this->input->get_post('transaksi_tunda_alasan');
			$data['transaksi_detail_jumlah'] = $this->input->get_post('transaksi_detail_jumlah');
			$data['when_create'] = date('Y-m-d H:i:s');
			$data['who_create'] = ($isi['user_id'] == '1') ?  'Super Admin' : $isi['user_nama'];
			$data['who_seksi_create'] = $isi['user_unit_id'];

			$this->M_inbox->insertInboxNew($data);
			/* Insert Transaksi Detail - Tunda */

			/* Update Sample Seksi Disposisi */
			$param_disposisi['id_seksi'] = $isi['id_seksi'];
			$param_disposisi['id_transaksi'] = $this->input->get_post('transaksi_id');
			$param_disposisi['id_transaksi_detail'] = $this->input->get_post('transaksi_detail_id_temp');
			$data_disposisi['id_transaksi_detail'] = $this->input->get_post('transaksi_detail_id');

			$this->M_inbox->updateTransaksiSeksiDisposisi($param_disposisi, $data_disposisi);
			/* Update Sample Seksi Disposisi */

			/* Update Petugas Sample */
			$this->db->query("UPDATE sample.sample_petugas SET id_transaksi_detail = '" . $data['transaksi_detail_id'] . "' WHERE id_transaksi_detail = '" . $data['transaksi_detail_id_temp'] . "'");
			/* Update Petugas Sample */

			sampleLog($this->input->get_post('transaksi_id'), null, $this->input->get_post('transaksi_non_rutin_id'), $this->input->get_post('transaksi_tipe'), $data['transaksi_detail_status'], 'Pekerjaan Telah Ditunda');
		}
		/* Tunda */

		// Batal
		public function insertBatal()
		{
			$isi = $this->session->userdata();

			/* Update Transaksi Detail */
			$id_detail = $this->input->get_post('transaksi_detail_id_temp');
			$data_detail['is_proses'] = 'y';

			$this->M_request->updateRequestDetail($data_detail, $id_detail);
			/* Update Transaksi Detail */

			/* Insert Transaksi Detail - Batal */
			$data['transaksi_detail_id_temp'] = $this->input->get_post('transaksi_detail_id_temp');
			$data['transaksi_detail_id'] = $this->input->get_post('transaksi_detail_id');
			$data['transaksi_id'] = $this->input->post('transaksi_id');
			$data['transaksi_detail_status'] = '14';
			$data['transaksi_detail_reject_alasan'] = $this->input->get_post('transaksi_batal_alasan');
			$data['when_create'] = date('Y-m-d H:i:s');
			$data['who_create'] = ($isi['user_id'] == '1') ?  'Super Admin' : $isi['user_nama'];
			$data['who_seksi_create'] = $isi['user_unit_id'];

			$this->M_inbox->insertBatal($data);
			/* Insert Transaksi Detail - Batal */

			/* Update Sample Seksi Disposisi */
			$param_disposisi['id_seksi'] = $isi['id_seksi'];
			$param_disposisi['id_transaksi'] = $this->input->get_post('transaksi_id');
			$param_disposisi['id_transaksi_detail'] = $this->input->get_post('transaksi_detail_id_temp');
			$data_disposisi['id_transaksi_detail'] = $this->input->get_post('transaksi_detail_id');

			$this->M_inbox->updateTransaksiSeksiDisposisi($param_disposisi, $data_disposisi);
			/* Update Sample Seksi Disposisi */

			/* Update Petugas Sample */
			$this->db->query("UPDATE sample.sample_petugas SET id_transaksi_detail = '" . $data['transaksi_detail_id'] . "' WHERE id_transaksi_detail = '" . $data['transaksi_detail_id_temp'] . "'");
			/* Update Petugas Sample */

			sampleLog($this->input->get_post('transaksi_id'), null, $this->input->get_post('transaksi_non_rutin_id'), $this->input->get_post('transaksi_tipe'), $data['transaksi_detail_status'], 'Pekerjaan Telah Dibatalkan');
		}
		// Batal

		// logsheet

		public function insertDraftLogSheet1()
		{
			$session = $this->session->userdata();

			$param_logsheet = array();
			$param_logsheet_detail = array();
			$param_logsheet_detail_detail = array();

			$data_transaksi = $this->db->query("SELECT * FROM sample.sample_transaksi_detail a LEFT JOIN sample.sample_transaksi b ON b.transaksi_id = a.transaksi_id LEFT JOIN sample.sample_jenis c ON c.jenis_id = a.jenis_id LEFT JOIN sample.sample_peminta_jasa d ON d.peminta_jasa_id = a.peminta_jasa_id WHERE a.transaksi_detail_id = '" . $this->input->get_post('transaksi_detail_id_temp') . "'")->result_array();

			foreach ($data_transaksi as $key => $val_transaksi) {
				$data_template = $this->db->query("SELECT * FROM sample.sample_template_logsheet a WHERE a.template_logsheet_id = '" . $this->input->get_post('template_logsheet_id') . "'")->row_array();

				$data_rumus = $this->db->query("SELECT * FROM sample.sample_perhitungan_sample a WHERE a.jenis_id = '" . $val_transaksi['jenis_id'] . "'")->result_array();

				$param_logsheet['logsheet_id'] = $this->input->get_post('logsheet_id');
				$param_logsheet['logsheet_nomor_sample'] = $val_transaksi['transaksi_detail_nomor_sample'];
				$param_logsheet['logsheet_jenis'] = $val_transaksi['jenis_nama'];
				$param_logsheet['logsheet_peminta_jasa'] = $val_transaksi['peminta_jasa_nama'];
				$param_logsheet['logsheet_nomor_permintaan'] = $val_transaksi['transaksi_nomor'];
				$param_logsheet['logsheet_tgl_sampling'] = date('Y-m-d', strtotime($this->input->get_post('logsheet_tgl_sampling')));
				$param_logsheet['logsheet_tgl_terima'] = date('Y-m-d', strtotime($this->input->get_post('logsheet_tgl_terima')));
				$param_logsheet['logsheet_tgl_uji'] = date('Y-m-d', strtotime($this->input->get_post('logsheet_tgl_uji')));
				$param_logsheet['logsheet_asal_sample'] = $this->input->get_post('logsheet_asal_sample');
				$param_logsheet['logsheet_pengolah_sample'] = $this->input->get_post('logsheet_pengolah_sample');
				$param_logsheet['logsheet_jenis_nama'] = $val_transaksi['jenis_nama'];
				$param_logsheet['logsheet_jenis_unit'] = $val_transaksi['jenis_id'];
				$param_logsheet['logsheet_deskripsi'] = $this->input->get_post('log_deskripsi');
				$param_logsheet['id_non_rutin'] = $this->input->get_post('transaksi_non_rutin_id');
				$param_logsheet['id_transaksi'] = $val_transaksi['transaksi_id'];
				$param_logsheet['id_template_logsheet'] = $data_template['template_logsheet_id'];
				$param_logsheet['id_transaksi_detail'] = $this->input->get_post('transaksi_detail_id');

				// echo "stau";
				// echo "<pre>";
				// print_r ($param_logsheet);
				// echo "</pre>";
				$this->M_inbox->insertLogSheet($param_logsheet);

				foreach ($this->input->get_post('logsheet_detail_urut_baris') as $key_1 => $value_detail) {

					$param_logsheet_detail['logsheet_detail_id'] = $this->input->get_post('logsheet_detail_id')[$key_1];
					$param_logsheet_detail['logsheet_id'] = $param_logsheet['logsheet_id'];
					$param_logsheet_detail['id_rumus'] = $this->input->get_post('logsheet_rumus_id')[$key_1];
					$param_logsheet_detail['logsheet_detail_urut'] = $this->input->get_post('logsheet_detail_urut')[$key_1];
					$param_logsheet_detail['when_create'] = date('Y-m-d H:i:s');
					$param_logsheet_detail['who_create'] = ($session['user_id'] != '1') ? $session['user_nama_lengkap'] : 'Super Admin';
					$param_logsheet_detail['logsheet_detail_urut_baris'] = $value_detail;
					$param_logsheet_detail['rumus_hasil'] = $this->input->get_post('rumus_detail_hasil')[$key_1];
					$param_logsheet_detail['rumus_avg'] = $this->input->get_post('rata_rata')[$key_1];
					$param_logsheet_detail['rumus_adbk'] = $this->input->get_post('nilai_adbk')[$key_1];
					$param_logsheet_detail['rumus_satuan'] = $this->input->get_post('rumus_satuan')[$key_1];
					$param_logsheet_detail['rumus_metoda'] = $this->input->get_post('rumus_metoda')[$key_1];

					$data_parameter_rumus = $this->db->query("SELECT * FROM sample.sample_perhitungan_sample_detail WHERE id_rumus = '" . $this->input->get_post('logsheet_rumus_id')[$key_1] . "'")->result_array();

					echo $this->db->last_query();


					// echo 'dua';
					// echo "<pre>";
					// print_r ($param_logsheet_detail);
					// echo "</pre>";
					$this->M_inbox->insertLogSheetDetail($param_logsheet_detail);

					foreach ($data_parameter_rumus as $key_2 => $value_detail_detail) {

						$param_logsheet_detail_detail['logsheet_detail_detail_id'] = create_id();
						$param_logsheet_detail_detail['id_logsheet'] = $param_logsheet['logsheet_id'];
						$param_logsheet_detail_detail['id_logsheet_detail'] = $this->input->get_post('logsheet_detail_id_detail')[$key_2];
						$param_logsheet_detail_detail['rumus_detail_id'] = $value_detail_detail['rumus_detail_id'];
						$param_logsheet_detail_detail['id_rumus'] = $value_detail_detail['id_rumus'];
						$param_logsheet_detail_detail['rumus_detail_nama'] = $value_detail_detail['rumus_detail_nama'];
						$param_logsheet_detail_detail['rumus_detail_isi'] = $this->input->get_post('rumus_detail_isi')[$key_2];
						$param_logsheet_detail_detail['rumus_jenis'] = $value_detail_detail['rumus_jenis'];
						$param_logsheet_detail_detail['when_create'] = date('Y-m-d H:i:s');
						$param_logsheet_detail_detail['who_create'] = ($session['user_id'] != '1') ? $session['user_nama_lengkap'] : 'Super Admin';
						$param_logsheet_detail_detail['rumus_detail_urut'] = $value_detail_detail['rumus_detail_urut'];
						$param_logsheet_detail_detail['rumus_detail_template'] = $value_detail_detail['rumus_detail_template'];
						$param_logsheet_detail_detail['rumus_detail_jenis'] = $value_detail_detail['rumus_detail_template'];


						$this->M_inbox->insertLogSheetDetailDetail($param_logsheet_detail_detail);
					}
				}
			}

			// update status
			$id = $this->input->post('transaksi_id');
			$id_detail_update = $this->input->get_post('transaksi_detail_id_temp');
			$data_detail_update['is_proses'] = 'y';

			$this->M_request->updateRequestDetail($data_detail_update, $id_detail_update);

			/* Insert Transaksi Detail */
			$data['transaksi_detail_id_temp'] = $this->input->get_post('transaksi_detail_id_temp');
			$data['transaksi_detail_id'] = $this->input->get_post('transaksi_detail_id');
			$data['transaksi_id'] = $this->input->post('transaksi_id');
			$data['transaksi_detail_status'] = '9';
			$data['when_create'] = date('Y-m-d H:i:s');
			$data['who_create'] = ($session['user_id'] == '1') ?  'Super Admin' : $session['user_nama'];
			$data['who_seksi_create'] = $session['user_unit_id'];

			$this->M_inbox->insertInboxLogsheet($data);

			$param_disposisi['id_seksi'] = $session['id_seksi'];
			$param_disposisi['id_transaksi'] = $this->input->get_post('transaksi_id');
			$param_disposisi['id_transaksi_detail'] = $this->input->get_post('transaksi_detail_id_temp');
			$data_disposisi['id_transaksi_detail'] = $this->input->get_post('transaksi_detail_id');

			$this->M_inbox->updateTransaksiSeksiDisposisi($param_disposisi, $data_disposisi);
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
					$sheets = $this->spreadsheet_excel_reader->sheets[0];
					/*proses excelnya*/

					$data_excel = array();
					$id = create_id();

					$data_transaksi_detail = $this->db->query("SELECT * FROM sample.sample_transaksi_detail a LEFT JOIN sample.sample_jenis b ON b.jenis_id = a.jenis_id LEFT JOIN sample.sample_pekerjaan c ON c.sample_pekerjaan_id = a.jenis_pekerjaan_id LEFT JOIN sample.sample_transaksi d ON d.transaksi_id = a.transaksi_id LEFT JOIN sample.sample_peminta_jasa e ON e.peminta_jasa_id = d.transaksi_id_peminta_jasa WHERE a.transaksi_detail_id = '" . $this->input->get_post('transaksi_detail_id_temp') . "'")->row_array();

					$param_logsheet['logsheet_id'] = create_id();
					$param_logsheet['logsheet_nomor_sample'] = $data_transaksi_detail['transaksi_detail_nomor_sample'];
					$param_logsheet['logsheet_jenis'] = $data_transaksi_detail['jenis_nama'];
					$param_logsheet['logsheet_peminta_jasa'] = $data_transaksi_detail['peminta_jasa_nama'];
					$param_logsheet['logsheet_nomor_permintaan'] = $data_transaksi_detail['transaksi_nomor'];
					$param_logsheet['logsheet_jenis_nama'] = $data_transaksi_detail['jenis_nama'];
					$param_logsheet['id_non_rutin'] = $data_transaksi_detail['id_non_rutin'];
					$param_logsheet['id_transaksi'] = $data_transaksi_detail['transaksi_id'];
					$param_logsheet['id_template_logsheet'] = $this->input->get_post('template_logsheet_id');
					$param_logsheet['id_transaksi_detail'] = $this->input->get_post('transaksi_detail_id');
					$param_logsheet['logsheet_file_excel'] = $NewExcelName;
					if ($data_transaksi_detail['transaksi_detail_tgl_sampling'] != '' || $data_transaksi_detail['transaksi_detail_tgl_sampling'] != null) {
						$param_logsheet['logsheet_tgl_sampling'] =  $data_transaksi_detail['transaksi_detail_tgl_sampling'];
					}
					$this->M_inbox->insertLogSheet($param_logsheet);
					/*logsheet level 1*/

					/* logsheet level 2 */
					$param_rumus['id_logsheet_template'] = $this->input->get_post('template_logsheet_id');

					$jumlah_rumus = $this->db->query("SELECT * FROM sample.sample_template_logsheet_detail a LEFT JOIN sample.sample_perhitungan_sample b ON a.logsheet_nama_rumus = b.rumus_id WHERE id_logsheet_template = '" . $this->input->get_post('template_logsheet_id') . "'  ORDER BY detail_logsheet_urut ASC")->num_rows();

					$jumlah_baris = ($this->input->post('logsheet_baris_excel') * $jumlah_rumus) + ($jumlah_rumus * 3);

					for ($i = 1; $i <= $jumlah_baris; $i++) {
						if ($sheets['cells'][$i][1] == 'Rumus') {
							$param_rumus['urut'] = $i;
							$param_rumus['rumus_nama'] = strtoupper($sheets['cells'][$i][2]);
						}

						$param_rumus['id_logsheet_template'] = $this->input->get_post('template_logsheet_id');
						if ($param_rumus['rumus_nama'] != '') :
							$data_rumus = $this->db->query("SELECT a.*, b.rumus_id, b.rumus_nama, b.is_adbk, b.satuan_sample, b.desimal_angka, b.batasan_emisi, b.metode FROM sample.sample_template_logsheet_detail a LEFT JOIN sample.sample_perhitungan_sample b ON a.logsheet_nama_rumus = b.rumus_id WHERE id_logsheet_template = '" . $this->input->get_post('template_logsheet_id') . "' AND UPPER(rumus_nama) LIKE '%" . $param_rumus['rumus_nama'] . "%' ORDER BY detail_logsheet_urut ASC")->row_array();

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
							// $param_logsheet2['rumus_adbk'] = $sheets['cells'][$i][$jumlah_isi_rumus + 3];
							// $param_logsheet2['rumus_satuan'] = $sheets['cells'][$i][$jumlah_isi_rumus + 3];
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
						for ($x = 1; $x <= $jumlah_isi_rumus - 1; $x++) {
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
						}
					}

					/* update status pekerjaan detail */
					$id = $this->input->post('transaksi_id');
					$id_detail_update = $this->input->get_post('transaksi_detail_id_temp');
					$data_detail_update['is_proses'] = 'y';
					$this->M_request->updateRequestDetail($data_detail_update, $id_detail_update);
					/* update status pekerjaan detail */

					/* Insert Transaksi Detail */
					$data['transaksi_detail_id_temp'] = $this->input->get_post('transaksi_detail_id_temp');
					$data['transaksi_detail_id'] = $this->input->get_post('transaksi_detail_id');
					$data['transaksi_id'] = $this->input->post('transaksi_id');
					$data['transaksi_detail_status'] = '9';
					$data['when_create'] = date('Y-m-d H:i:s');
					$data['who_create'] = ($session['user_id'] == '1') ?  'Super Admin' : $session['user_nama'];
					$data['who_seksi_create'] = $session['user_unit_id'];
					$this->M_inbox->insertInboxLogsheet($data);
					/* Insert Transaksi Detail */

					/*udpate transaksi detail seksi disposisi */
					$param_disposisi['id_seksi'] = $session['id_seksi'];
					$param_disposisi['id_transaksi'] = $this->input->get_post('transaksi_id');
					$param_disposisi['id_transaksi_detail'] = $this->input->get_post('transaksi_detail_id_temp');
					$data_disposisi['id_transaksi_detail'] = $this->input->get_post('transaksi_detail_id');
					$this->M_inbox->updateTransaksiSeksiDisposisi($param_disposisi, $data_disposisi);
					/*udpate transaksi detail seksi disposisi */

					/* Update transaksi detail Petugas Sample */
					$this->db->query("UPDATE sample.sample_petugas SET id_transaksi_detail = '" . $data['transaksi_detail_id'] . "' WHERE id_transaksi_detail = '" . $data['transaksi_detail_id_temp'] . "'");
					/* Update transaksi detail Petugas Sample */

					$link = base_url() . 'sample/inbox/procesLogSheet/?header_menu=' . $this->input->post('header_menu') . '&menu_id=' . $this->input->post('menu_id') . '&transaksi_id=' . $this->input->post('transaksi_id') . '&transaksi_detail_id=' . $this->input->post('transaksi_detail_id') . '&transaksi_detail_status=' . $data['transaksi_detail_status'] . '&template_logsheet_id=' . $this->input->post('template_logsheet_id') . '&logsheet_id=' . $param_logsheet['logsheet_id'] . '&transaksi_non_rutin_id=' . $this->input->post('transaksi_non_rutin_id');
					echo $link;
				} else {
					echo 0;
				}
			} else {
				echo 00;
			}
			/*ekstensi file yang diperbolehkan*/
		}

		public function insertDraftLogSheet()
		{
			$session = $this->session->userdata();

			$id = $this->input->post('logsheet_id');
			$data['logsheet_tgl_sampling'] = date('Y-m-d', strtotime($this->input->get_post('logsheet_tgl_sampling')));
			$data['logsheet_tgl_terima'] = date('Y-m-d', strtotime($this->input->get_post('logsheet_tgl_terima')));
			$data['logsheet_tgl_uji'] = date('Y-m-d', strtotime($this->input->get_post('logsheet_tgl_uji')));
			$data['logsheet_asal_sample'] = $this->input->get_post('logsheet_asal_sample');
			$data['logsheet_pengolah_sample'] = $this->input->get_post('logsheet_pengolah_sample');
			$data['logsheet_deskripsi'] = $this->input->get_post('log_deskripsi');

			$this->M_inbox->updateLogSheet($id, $data);
		}

		public function insertOlahLogSheet()
		{
			$session = $this->session->userdata();
			// update status
			$id = $this->input->post('transaksi_id');
			$id_detail_update = $this->input->get_post('transaksi_detail_id_temp');
			$data_detail_update['is_proses'] = 'y';
			$this->M_request->updateRequestDetail($data_detail_update, $id_detail_update);

			$id_logsheets = $this->input->get_post('logsheet_id');
			$data_logsheets['id_transaksi_detail'] = $this->input->get_post('transaksi_detail_id');
			$data_logsheets['logsheet_last_update'] = date('Y-m-d H:i:s');
			$data_logsheet['logsheet_tgl_sampling'] = date('Y-m-d', strtotime($this->input->get_post('logsheet_tgl_sampling')));
			$data_logsheets['logsheet_tgl_terima'] = date('Y-m-d', strtotime($this->input->get_post('logsheet_tgl_terima')));
			$data_logsheets['logsheet_tgl_uji'] = date('Y-m-d', strtotime($this->input->get_post('logsheet_tgl_uji')));
			$data_logsheets['logsheet_asal_sample'] = $this->input->get_post('logsheet_asal_sample');
			$data_logsheets['logsheet_pengolah_sample'] = $this->input->get_post('logsheet_pengolah_sample');
			$data_logsheets['logsheet_deskripsi'] = $this->input->get_post('logsheet_deskripsi');
			$this->M_inbox->updateLogSheet($id_logsheets, $data_logsheets);

			/* Insert Transaksi Detail */
			$data['transaksi_detail_id_temp'] = $this->input->get_post('transaksi_detail_id_temp');
			$data['transaksi_detail_id'] = $this->input->get_post('transaksi_detail_id');
			$data['transaksi_id'] = $this->input->post('transaksi_id');
			$data['transaksi_detail_status'] = '10';
			$data['when_create'] = date('Y-m-d H:i:s');
			$data['who_create'] = ($session['user_id'] == '1') ?  'Super Admin' : $session['user_nama'];
			$data['who_seksi_create'] = $session['user_unit_id'];
			$this->M_inbox->insertInboxLogsheet($data);

			$param_disposisi['id_seksi'] = $session['id_seksi'];
			$param_disposisi['id_transaksi'] = $this->input->get_post('transaksi_id');
			$param_disposisi['id_transaksi_detail'] = $this->input->get_post('transaksi_detail_id_temp');
			$data_disposisi['id_transaksi_detail'] = $this->input->get_post('transaksi_detail_id');
			$this->M_inbox->updateTransaksiSeksiDisposisi($param_disposisi, $data_disposisi);

			/* Update Petugas Sample */
			$this->db->query("UPDATE sample.sample_petugas SET id_transaksi_detail = '" . $data['transaksi_detail_id'] . "' WHERE id_transaksi_detail = '" . $data['transaksi_detail_id_temp'] . "'");
			/* Update Petugas Sample */

			$redirect = base_url() . 'sample/inbox/draftLogSheet/?header_menu=' . $this->input->get_post('header_menu') . '&menu_id=' . $this->input->get_post('menu_id') . '&transaksi_id=' . $this->input->get_post('transaksi_id') . '&transaksi_detail_id=' . $this->input->get_post('transaksi_detail_id') . '&transaksi_detail_status=10&template_logsheet_id=' . $this->input->get_post('template_logsheet_id') . '&logsheet_id=' . $this->input->get_post('logsheet_id');

			echo $redirect;
		}


		public function insertLogSheet()
		{
			$session = $this->session->userdata();

			$id_detail_update = $this->input->get_post('transaksi_detail_id_temp');
			$data_detail_update['is_proses'] = 'y';

			$this->M_request->updateRequestDetail($data_detail_update, $id_detail_update);

			$id_logsheets = $this->input->get_post('logsheet_id');
			$data_logsheets['id_transaksi_detail'] = ($this->input->get_post('transaksi_detail_id'));
			$data_logsheets['logsheet_analisis'] = $session['user_nik_sap'];
			$data_logsheets['logsheet_analisis_date'] = date('Y-m-d H:i:s');
			$data_logsheets['logsheet_last_update'] = date('Y-m-d H:i:s');
			$data_logsheets['is_kan'] = $this->input->get_post('is_kan');
			$data_logsheets['is_ds'] = $this->input->get_post('is_ds');
			$data_logsheets['id_template_footer'] = $this->input->get_post('id_template_footer');
			$data_logsheets['logsheet_keterangan'] = $this->input->get_post('logsheet_keterangan');
			$this->M_inbox->updateLogSheet($id_logsheets, $data_logsheets);
			/* Update Logsheet */

			/* Insert Transaksi Detail */
			$data['transaksi_detail_id_temp'] = $this->input->get_post('transaksi_detail_id_temp');
			$data['transaksi_detail_id'] = $this->input->get_post('transaksi_detail_id');
			$data['transaksi_id'] = $this->input->post('transaksi_id');
			$data['transaksi_detail_status'] = '10';
			$data['when_create'] = date('Y-m-d H:i:s');
			$data['who_create'] = ($session['user_id'] == '1') ?  'Super Admin' : $session['user_nama'];
			$data['who_seksi_create'] = $session['user_unit_id'];

			$this->M_inbox->insertInboxLogsheet($data);

			// untuk qr code nya
			$param['logsheet_id'] = $this->input->get_post('logsheet_id');

			$data = $this->M_inbox->getLogsheet($param);

			$url = array();
			$nama_analisa = $data['nama_analisis'];
			$tanggal_analisa = $data['logsheet_analisis_date'];
			$last_update = $data['logsheet_last_update'];

			$analisa = "Nama Analis : " . $nama_analisa . "";
			$analisa .= ", Approver Analisa : " . $tanggal_analisa . "";
			// $analisa .= ", Update Terakhir : " . $last_update . "";

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

			$nim = $data['logsheet_id'] . $data['nama_analisis'];
			$image_name = $nim . '.png'; //buat name dari qr code sesuai dengan nim

			$params['data'] = $analisa; //data yang akan di jadikan QR CODE
			$params['level'] = 'H'; //H=High
			$params['size'] = 5;
			$params['savename'] = FCPATH . $config['imagedir'] . $image_name; //simpan image QR CODE ke folder assets/images/

			$this->ciqrcode->generate($params);
			$id_logsheet_qr = $this->input->get_post('logsheet_id');
			$data_logsheet_qr['logsheet_analisis_qr'] = $image_name;
			$this->M_inbox->updateLogSheet($id_logsheet_qr, $data_logsheet_qr);

			/* QRCODE */

			$param_disposisi['id_seksi'] = $session['id_seksi'];
			$param_disposisi['id_transaksi'] = $this->input->get_post('transaksi_id');
			$param_disposisi['id_transaksi_detail'] = $this->input->get_post('transaksi_detail_id_temp');
			$data_disposisi['id_transaksi_detail'] = $this->input->get_post('transaksi_detail_id');

			$this->M_inbox->updateTransaksiSeksiDisposisi($param_disposisi, $data_disposisi);
		}

		public function insertApproveKonsepLogSheet()
		{
			$session = $this->session->userdata();

			/* Penciptaan Dokumen DOCX */
			$dataTransaksi = $this->db->query("SELECT a.transaksi_detail_nomor_sample, b.transaksi_nomor, d.jenis_nama, c.logsheet_tgl_terima, c.logsheet_tgl_uji, c.logsheet_peminta_jasa, e.user_nama, e.user_post_title, c.logsheet_asal_sample, c.logsheet_pengolah_sample, c.logsheet_deskripsi, c.id_template_footer, c.is_kan, c.is_ds, c.logsheet_keterangan FROM sample.sample_transaksi_detail a LEFT JOIN sample.sample_transaksi b ON a.transaksi_id = b.transaksi_id LEFT JOIN sample.sample_logsheet c ON c.id_transaksi_detail = a.transaksi_detail_id LEFT JOIN sample.sample_jenis d ON a.jenis_id = d.jenis_id LEFT JOIN global.global_api_user e ON b.transaksi_tujuan = e.user_nik_sap WHERE a.transaksi_detail_id = '" . $this->input->post('transaksi_detail_id_temp') . "'")->row_array();

			$dataFooter = explode(',', $dataTransaksi['id_template_footer']);
			for ($i = 0; $i < count($dataFooter); $i++) {
				$data_footer =  $this->db->query("SELECT * FROM sample.sample_footer_sertifikat WHERE footer_id = '" . $dataFooter[$i] . "'")->row_array();

				$isi_footer[$i + 1] = $data_footer['footer_isi'];
			}

			if ($dataTransaksi['is_kan'] == 'y') {
				$template = ($dataTransaksi['is_ds'] == 'y') ? 'template_is_kan_ds.docx' : 'template_is_kan.docx';
			} else {
				$template = ($dataTransaksi['is_ds'] == 'y') ? 'template_no_kan_ds.docx' : 'template_no_kan.docx';
			}

			$templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('./dokumen_dof/default/' . $template);
			$templateProcessor->setValues(
				[
					'nomor_sampel' => htmlspecialchars($dataTransaksi['transaksi_detail_nomor_sample']),
					'jenis_sampel' => htmlspecialchars($dataTransaksi['jenis_nama']),
					'peminta_jasa' => htmlspecialchars($dataTransaksi['logsheet_peminta_jasa']),
					'nomor_permintaan' => htmlspecialchars($dataTransaksi['transaksi_nomor']),
					'tanggal_terima' => htmlspecialchars(date("d F Y", strtotime($dataTransaksi['logsheet_tgl_terima']))),
					'tanggal_pengujian' => htmlspecialchars(date("d F Y", strtotime($dataTransaksi['logsheet_tgl_uji']))),
					'asal_sampel' => htmlspecialchars($dataTransaksi['logsheet_asal_sample']),
					'pengambilan_sampel_oleh' => htmlspecialchars($dataTransaksi['logsheet_pengolah_sample']),
					'deskripsi_sampel' => htmlspecialchars($dataTransaksi['logsheet_deskripsi']),
					'nama_vp' => htmlspecialchars($dataTransaksi['user_nama']),
					'jabatan_vp' => htmlspecialchars($dataTransaksi['user_post_title']),
					'isi_footer_1' => htmlspecialchars((isset($isi_footer[1])) ? $isi_footer[1] : ''),
					'isi_footer_2' => htmlspecialchars((isset($isi_footer[2])) ? $isi_footer[2] : ''),
					'isi_footer_3' => htmlspecialchars((isset($isi_footer[3])) ? $isi_footer[3] : ''),
				]
			);

			$hasil = array();
			$dataLogsheet = $this->db->query("SELECT * FROM sample.sample_logsheet a LEFT JOIN sample.sample_logsheet_detail b ON a.logsheet_id = b.logsheet_id LEFT JOIN sample.sample_perhitungan_sample c ON c.rumus_id = b.id_rumus LEFT JOIN sample.sample_template_logsheet_detail d ON b.id_rumus = d.logsheet_nama_rumus AND a.id_template_logsheet = d.id_logsheet_template WHERE 1=1 AND id_transaksi = '" . $this->input->post('transaksi_id') . "' AND a.logsheet_id = '" . $this->input->post('logsheet_id') . "' ORDER BY d.detail_logsheet_urut ASC, b.logsheet_detail_urut ASC")->result_array();

			foreach ($dataLogsheet as $key => $value) {
				$hasil[] = array(
					'jenis_uji' => $value['rumus_nama'],
					'satuan' => $value['rumus_satuan'],
					'hasil_uji' => $value['rumus_hasil'],
					'metoda' => $value['rumus_metoda'],
				);
			}
			$templateProcessor->cloneBlock('hasil', 0, true, false, $hasil);

			$dataKeterangan = explode(',', $dataTransaksi['logsheet_keterangan']);
			$keterangan = array();
			for ($i = 0; $i < count($dataKeterangan); $i++) {
				$data_keterangan =  $this->db->query("SELECT * FROM sample.sample_keterangan_sertifikat WHERE keterangan_sertifikat_id = '" . $dataKeterangan[$i] . "'")->row_array();

				$keterangan[] = array(
					'keterangan' => $data_keterangan['keterangan_sertifikat_isi'],
				);
			}
			$templateProcessor->cloneBlock('ket', 0, true, false, $keterangan);

			$pathToSave = './dokumen_dof/' . $this->input->post('transaksi_detail_id_temp') . '.docx';
			$templateProcessor->saveAs($pathToSave);
			/* Penciptaan Dokumen DOCX */

			/* Send Dokumen SFTP */
			try {
				$dataFile = $this->input->post('transaksi_detail_id_temp') . '.docx';
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

			// die();
			/* Send Dokumen SFTP */

			/* Update Logsheet */
			$id_logsheets = $this->input->get_post('logsheet_id');
			$data_logsheets['logsheet_review'] = $session['user_nik_sap'];
			$data_logsheets['logsheet_review_date'] = date('Y-m-d H:i:s');
			$data_logsheets['logsheet_last_update'] = date('Y-m-d H:i:s');
			$data_logsheets['is_kan'] = $this->input->get_post('is_kan');
			$data_logsheets['is_ds'] = $this->input->get_post('is_ds');
			$data_logsheets['id_template_footer'] = $this->input->get_post('id_template_footer');
			$data_logsheets['logsheet_keterangan'] = $this->input->get_post('logsheet_keterangan');

			$this->M_inbox->updateLogSheet($id_logsheets, $data_logsheets);
			/* Update Logsheet */

			/* Update Transaksi Detail */
			$id_trans_detail = $this->input->get_post('transaksi_detail_id_temp');
			$data_trans_detail['transaksi_detail_status'] = '11';

			$this->M_request->updateRequestDetail($data_trans_detail, $id_trans_detail);

			/* Update Transaksi Detail */

			$param['logsheet_id'] = $this->input->get_post('logsheet_id');
			$data = $this->M_inbox->getLogsheet($param);

			/* Update Logsheet */
			$review = "Nama Reviewer : " . $data['nama_review'] . "";
			$review .= ", Approver Reviewer : " . $data['logsheet_review_date'] . "";

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

			$nim = $data['logsheet_id'] . $data['nama_review'];
			$image_name = $nim . '.png'; //buat name dari qr code sesuai dengan nim

			$params['data'] = $review; //data yang akan di jadikan QR CODE
			$params['level'] = 'H'; //H=High
			$params['size'] = 5;
			$params['savename'] = FCPATH . $config['imagedir'] . $image_name; //simpan image QR CODE ke folder assets/images/
			$this->ciqrcode->generate($params);

			$id_logsheets_1 = $this->input->get_post('logsheet_id');
			$data_logsheets_1['logsheet_review_qr'] = $image_name;

			$this->M_inbox->updateLogSheet($id_logsheets_1, $data_logsheets_1);
			/* Update Logsheet */
		}

		public function insertReviewLogSheet()
		{
			$session = $this->session->userdata();
			// update status
			// $id_logsheet = $this->input->get_post('logsheet_id');
			// $data_logsheet['logsheet_review'] = $session['user_nik_sap'];

			// $this->M_inbox->updateLogSheet($id_logsheet, $data_logsheet);

			$id = $this->input->post('transaksi_id');
			$id_detail_update = $this->input->get_post('transaksi_detail_id_temp');
			$data_detail_update['is_proses'] = 'y';

			$this->M_request->updateRequestDetail($data_detail_update, $id_detail_update);

			$id_logsheets = $this->input->get_post('logsheet_id');
			$data_logsheets['id_transaksi_detail'] = ($this->input->get_post('transaksi_detail_id'));
			$data_logsheets['logsheet_last_update'] = date('Y-m-d H:i:s');

			$this->M_inbox->updateLogSheet($id_logsheets, $data_logsheets);

			/* Insert Transaksi Detail */
			$data['transaksi_detail_id_temp'] = $this->input->get_post('transaksi_detail_id_temp');
			$data['transaksi_detail_id'] = $this->input->get_post('transaksi_detail_id');
			$data['transaksi_id'] = $this->input->post('transaksi_id');
			$data['transaksi_detail_status'] = '11';
			$data['when_create'] = date('Y-m-d H:i:s');
			$data['who_create'] = ($session['user_id'] == '1') ?  'Super Admin' : $session['user_nama'];
			$data['who_seksi_create'] = $session['user_unit_id'];

			$this->M_inbox->insertInboxLogsheet($data);


			$param_disposisi['id_seksi'] = $session['id_seksi'];
			$param_disposisi['id_transaksi'] = $this->input->get_post('transaksi_id');
			$param_disposisi['id_transaksi_detail'] = $this->input->get_post('transaksi_detail_id_temp');
			$data_disposisi['id_transaksi_detail'] = $this->input->get_post('transaksi_detail_id');

			$this->M_inbox->updateTransaksiSeksiDisposisi($param_disposisi, $data_disposisi);
		}

		public function insertApproveSertifikat()
		{
			$session = $this->session->userdata();

			$id_logsheet = $this->input->get_post('logsheet_id');
			$data_logsheet['is_approve'] = 'y';

			$this->M_inbox->updateLogSheet($id_logsheet, $data_logsheet);
		}

		public function insertDOF()
		{

			$this->load->library('PdfGenerator');
			$session = $this->session->userdata();
			/* buat file word */
			$dataTransaksi = $this->db->query("SELECT a.transaksi_detail_nomor_sample, b.transaksi_nomor, d.jenis_nama, c.logsheet_tgl_terima, c.logsheet_tgl_uji, c.logsheet_peminta_jasa, e.user_nama, e.user_post_title, c.logsheet_asal_sample, c.logsheet_pengolah_sample, c.logsheet_deskripsi, c.id_template_footer, c.is_kan, c.is_ds , c.logsheet_keterangan FROM sample.sample_transaksi_detail a LEFT JOIN sample.sample_transaksi b ON a.transaksi_id = b.transaksi_id LEFT JOIN sample.sample_logsheet c ON c.id_transaksi_detail = a.transaksi_detail_id LEFT JOIN sample.sample_jenis d ON a.jenis_id = d.jenis_id LEFT JOIN global.global_api_user e ON b.transaksi_tujuan = e.user_nik_sap WHERE a.transaksi_detail_id = '" . $this->input->post('transaksi_detail_id_temp') . "'")->row_array();

			$dataFooter = explode(',', $dataTransaksi['id_template_footer']);
			for ($i = 0; $i < count($dataFooter); $i++) {
				if ($i > 0) {
					$data_footer =  $this->db->query("SELECT * FROM sample.sample_footer_sertifikat WHERE footer_id = '" . $dataFooter[$i] . "'")->row_array();

					$isi_footer[$i + 1] = $data_footer['footer_isi'];
				}
			}

			if ($dataTransaksi['is_kan'] == 'y') {
				$template = ($dataTransaksi['is_ds'] == 'y') ? 'template_is_kan_ds.docx' : 'template_is_kan.docx';
			} else {
				$template = ($dataTransaksi['is_ds'] == 'y') ? 'template_no_kan_ds.docx' : 'template_no_kan.docx';
			}

			$templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('./dokumen_dof/default/' . $template);
			$templateProcessor->setValues(
				[
					'nomor_sampel' => htmlspecialchars($dataTransaksi['transaksi_detail_nomor_sample']),
					'jenis_sampel' => htmlspecialchars($dataTransaksi['jenis_nama']),
					'peminta_jasa' => htmlspecialchars($dataTransaksi['logsheet_peminta_jasa']),
					'nomor_permintaan' => htmlspecialchars($dataTransaksi['transaksi_nomor']),
					'tanggal_terima' => htmlspecialchars(date("d F Y", strtotime($dataTransaksi['logsheet_tgl_terima']))),
					'tanggal_pengujian' => htmlspecialchars(date("d F Y", strtotime($dataTransaksi['logsheet_tgl_uji']))),
					'asal_sampel' => htmlspecialchars($dataTransaksi['logsheet_asal_sample']),
					'pengambilan_sampel_oleh' => htmlspecialchars($dataTransaksi['logsheet_pengolah_sample']),
					'deskripsi_sampel' => htmlspecialchars($dataTransaksi['logsheet_deskripsi']),
					'nama_vp' => htmlspecialchars($dataTransaksi['user_nama']),
					'jabatan_vp' => htmlspecialchars($dataTransaksi['user_post_title']),
					'isi_footer_1' => htmlspecialchars((isset($isi_footer[1])) ? $isi_footer[1] : ''),
					'isi_footer_2' => htmlspecialchars((isset($isi_footer[2])) ? $isi_footer[2] : ''),
					'isi_footer_3' => htmlspecialchars((isset($isi_footer[3])) ? $isi_footer[3] : ''),
				]
			);

			$hasil = array();
			$dataLogsheet = $this->db->query("SELECT * FROM sample.sample_logsheet a LEFT JOIN sample.sample_logsheet_detail b ON a.logsheet_id = b.logsheet_id LEFT JOIN sample.sample_perhitungan_sample c ON c.rumus_id = b.id_rumus LEFT JOIN sample.sample_template_logsheet_detail d ON b.id_rumus = d.logsheet_nama_rumus AND a.id_template_logsheet = d.id_logsheet_template WHERE 1=1 AND id_transaksi = '" . $this->input->post('transaksi_id') . "' AND a.logsheet_id = '" . $this->input->post('logsheet_id') . "' ORDER BY d.detail_logsheet_urut ASC, b.logsheet_detail_urut ASC")->result_array();

			foreach ($dataLogsheet as $key => $value) {
				$hasil[] = array(
					'jenis_uji' => $value['rumus_nama'],
					'satuan' => $value['rumus_satuan'],
					'hasil_uji' => $value['rumus_hasil'],
					'metoda' => $value['rumus_metoda'],
				);
			}
			$templateProcessor->cloneBlock('hasil', 0, true, false, $hasil);

			$dataKeterangan = explode(',', $dataTransaksi['logsheet_keterangan']);
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

			$pathToSave = './dokumen_dof/' . $this->input->get_post('transaksi_detail_id_temp') . '.docx';
			$templateProcessor->saveAs($pathToSave);
			/* buat file word */

			/* convert dokumen yang sudah dibuat ke format base64 */
			$file_word = file_get_contents(FCPATH . $pathToSave);
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
			// echo json_encode($item);
			// kirim datanya ke dof

			// die();

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
			$data_dof['transaksi_detail_id'] = $this->input->post('transaksi_detail_id');
			// }
			$data_dof['id_surat'] = $item['id'];

			$this->db->insert('sample.sample_dof_identitas', $data_dof);

			// kirim data document ke dof
			$id = $this->input->post('transaksi_id');
			$id_detail_update = $this->input->get_post('transaksi_detail_id_temp');
			$data_detail_update['is_proses'] = 'y';
			$this->M_request->updateRequestDetail($data_detail_update, $id_detail_update);

			/* update logsheet */
			$logsheet_id = $this->input->get_post('logsheet_id');
			$data_logsheet['id_transaksi_detail'] = $this->input->post('transaksi_detail_id');
			$this->M_inbox->updateLogSheet($logsheet_id, $data_logsheet);
			/* update logsheet */

			/* Insert Transaksi Detail */
			$data['transaksi_detail_id_temp'] = $this->input->get_post('transaksi_detail_id_temp');
			$data['transaksi_detail_id'] = $this->input->get_post('transaksi_detail_id');
			$data['transaksi_id'] = $this->input->post('transaksi_id');
			$data['transaksi_detail_status'] = '17';
			$data['when_create'] = date('Y-m-d H:i:s');
			$data['who_create'] = ($session['user_id'] == '1') ?  'Super Admin' : $session['user_nama'];
			$data['who_seksi_create'] = $session['user_unit_id'];
			$this->M_inbox->insertInboxLogsheet($data);
			/* Insert Transaksi Detail */

			$param_disposisi['id_seksi'] = $session['id_seksi'];
			$param_disposisi['id_transaksi'] = $this->input->get_post('transaksi_id');
			$param_disposisi['id_transaksi_detail'] = $this->input->get_post('transaksi_detail_id_temp');
			$data_disposisi['id_transaksi_detail'] = $this->input->get_post('transaksi_detail_id');
			$this->M_inbox->updateTransaksiSeksiDisposisi($param_disposisi, $data_disposisi);
		}

		// logsheet

		public function pdf_create($isi = null)
		{
			$isi_html['isi'] = $isi;
			$this->load->view('sample/mamas', $isi_html);
		}

		// closed
		public function insertClossed()
		{

			$isi = $this->session->userdata();

			$id = $this->input->post('transaksi_id');
			$id_detail = $this->input->get_post('transaksi_detail_id_temp');
			$data_detail['is_proses'] = 'y';

			$this->M_request->updateRequestDetail($data_detail, $id_detail);

			if (isset($_FILES['transaksi_detail_file'])) {
				$temp = "./document/";
				if (!file_exists($temp))
					mkdir($temp);

				$fileupload = $_FILES['transaksi_detail_file']['tmp_name'];
				$ImageName = $_FILES['transaksi_detail_file']['name'];
				$ImageType = $_FILES['transaksi_detail_file']['type'];

				if (!empty($fileupload)) {
					$acak = rand(11111111, 99999999);
					$ImageExt = substr($ImageName, strrpos($ImageName, '.'));
					$ImageExt = str_replace('.', '', $ImageExt); // Extension
					$ImageName = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
					$NewImageName = str_replace(' ', '', $acak . '_' . date('ymdhis') . '.' . $ImageExt);

					move_uploaded_file($_FILES["transaksi_detail_file"]["tmp_name"], $temp . $NewImageName); // Menyimpan file

					$note = "Data Berhasil Disimpan";
				} else {
					$note = "Data Gagal Disimpan";
				}
				echo $note;
			} else {
				$NewImageName = null;
			}

			/* Insert Transaksi Detail */
			// $data['transaksi_detail_file'] = $NewImageName;
			$data['transaksi_detail_id_temp'] = $this->input->get_post('transaksi_detail_id_temp');
			$data['transaksi_detail_id'] = $this->input->get_post('transaksi_detail_id');
			$data['transaksi_id'] = $this->input->post('transaksi_id');
			$data['transaksi_detail_status'] = '18';
			$data['transaksi_detail_no_surat'] = $this->input->get_post('transaksi_detail_nomor');
			$data['transaksi_detail_tgl_pengajuan'] = date('Y-m-d H:i:s', strtotime($this->input->post('transaksi_detail_tgl_pengajuan')));
			$data['when_create'] = date('Y-m-d H:i:s');
			$data['who_create'] = ($isi['user_id'] == '1') ?  'Super Admin' : $isi['user_nama'];
			$data['who_seksi_create'] = $isi['user_unit_id'];

			$this->M_inbox->insertInboxClossed($data);
			echo $this->db->last_query();

			if ($this->input->get_post('logsheet_id') != null) {

				$id_logsheets = $this->input->get_post('logsheet_id');
				$data_logsheets['id_transaksi_detail'] = ($this->input->get_post('transaksi_detail_id'));
				$data_logsheets['logsheet_last_update'] = date('Y-m-d H:i:s');

				$this->M_inbox->updateLogSheet($id_logsheets, $data_logsheets);

				$param_dof['transaksi_detail_id'] = $this->input->post('transaksi_detail_id_temp');
				$data_dof['transaksi_detail_id'] = $this->input->post('transaksi_detail_id');
				$this->db->where('a.transaksi_detail_id', $param_dof['transaksi_detail_id']);
				$this->db->update('sample.sample_dof_identitas a', $data_dof);

				$old_file_path = FCPATH . '/dokumen_dof/' . $this->input->get_post('transaksi_detail_id_temp') . '.docx';
				$new_file_path = FCPATH . '/dokumen_dof/' . $this->input->get_post('transaksi_detail_id') . '.docx';

				rename($old_file_path, $new_file_path);

				/* Send Dokumen SFTP */
				try {
					$dataFile = $this->input->post('transaksi_detail_id') . '.docx';
					$sftpServer = "103.157.97.200";
					$sftpUsername = "root";
					$sftpPassword = "P@ssw0rds1k1t4";
					$sftpPort = "22";
					$sftpRemoteDir = "/var/www/dokumen_dof";
					$ch = curl_init('sftp://' . $sftpServer . ':' . $sftpPort . $sftpRemoteDir . '/' . basename($dataFile));
					// $fh = fopen('./dokumen_dof/' . $dataFile, 'r');
					$fh = fopen($new_file_path, 'r');

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
			}

			$param_disposisi['id_seksi'] = $isi['id_seksi'];
			$param_disposisi['id_transaksi'] = $this->input->get_post('transaksi_id');
			$param_disposisi['id_transaksi_detail'] = $this->input->get_post('transaksi_detail_id_temp');
			$data_disposisi['id_transaksi_detail'] = $this->input->get_post('transaksi_detail_id');

			$this->M_inbox->updateTransaksiSeksiDisposisi($param_disposisi, $data_disposisi);
		}

		public function insertClossedRutin()
		{

			$isi = $this->session->userdata();

			$id = $this->input->post('transaksi_id');
			$id_detail = $this->input->get_post('transaksi_detail_id_temp');
			$data_detail['is_proses'] = 'y';

			$this->M_request->updateRequestDetail($data_detail, $id_detail);

			if (isset($_FILES['transaksi_detail_file'])) {
				$temp = "./document/";
				if (!file_exists($temp))
					mkdir($temp);

				$fileupload = $_FILES['transaksi_detail_file']['tmp_name'];
				$ImageName = $_FILES['transaksi_detail_file']['name'];
				$ImageType = $_FILES['transaksi_detail_file']['type'];

				if (!empty($fileupload)) {
					$acak = rand(11111111, 99999999);
					$ImageExt = substr($ImageName, strrpos($ImageName, '.'));
					$ImageExt = str_replace('.', '', $ImageExt); // Extension
					$ImageName = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
					$NewImageName = str_replace(' ', '', $acak . '_' . date('ymdhis') . '.' . $ImageExt);

					move_uploaded_file($_FILES["transaksi_detail_file"]["tmp_name"], $temp . $NewImageName); // Menyimpan file

					$note = "Data Berhasil Disimpan";
				} else {
					$note = "Data Gagal Disimpan";
				}
				echo $note;
			} else {
				$NewImageName = null;
			}

			/* Insert Transaksi Detail */
			// $data['transaksi_detail_file'] = $NewImageName;
			$data['transaksi_detail_id_temp'] = $this->input->get_post('transaksi_detail_id_temp');
			$data['transaksi_detail_id'] = $this->input->get_post('transaksi_detail_id');
			$data['transaksi_id'] = $this->input->post('transaksi_id');
			$data['transaksi_detail_status'] = '18';
			$data['transaksi_detail_no_surat'] = $this->input->get_post('transaksi_detail_nomor');
			$data['transaksi_detail_tgl_pengajuan'] = date('Y-m-d H:i:s', strtotime($this->input->post('transaksi_detail_tgl_pengajuan')));
			$data['when_create'] = date('Y-m-d H:i:s');
			$data['who_create'] = ($isi['user_id'] == '1') ?  'Super Admin' : $isi['user_nama'];
			$data['who_seksi_create'] = $isi['user_unit_id'];

			// $this->M_inbox->insertInboxClossed($data);
			// echo $this->db->last_query();

			$this->db->query("UPDATE sample.sample_transaksi_detail SET transaksi_detail_status = '18',transaksi_detail_no_surat = '".$this->input->get_post('transaksi_detail_nomor')."' WHERE transaksi_id = '".$this->input->get_post('transaksi_id')."'");
			echo $this->db->last_query();

			if ($this->input->get_post('logsheet_id') != null) {

				$id_logsheets = $this->input->get_post('logsheet_id');
				$data_logsheets['id_transaksi_detail'] = ($this->input->get_post('transaksi_detail_id'));
				$data_logsheets['logsheet_last_update'] = date('Y-m-d H:i:s');

				$this->M_inbox->updateLogSheet($id_logsheets, $data_logsheets);

				$param_dof['transaksi_detail_id'] = $this->input->post('transaksi_detail_id_temp');
				$data_dof['transaksi_detail_id'] = $this->input->post('transaksi_detail_id');
				$this->db->where('a.transaksi_detail_id', $param_dof['transaksi_detail_id']);
				$this->db->update('sample.sample_dof_identitas a', $data_dof);

				$old_file_path = FCPATH . '/dokumen_dof/' . $this->input->get_post('transaksi_detail_id_temp') . '.docx';
				$new_file_path = FCPATH . '/dokumen_dof/' . $this->input->get_post('transaksi_detail_id') . '.docx';

				rename($old_file_path, $new_file_path);

				/* Send Dokumen SFTP */
				try {
					$dataFile = $this->input->post('transaksi_detail_id') . '.docx';
					$sftpServer = "103.157.97.200";
					$sftpUsername = "root";
					$sftpPassword = "P@ssw0rds1k1t4";
					$sftpPort = "22";
					$sftpRemoteDir = "/var/www/dokumen_dof";
					$ch = curl_init('sftp://' . $sftpServer . ':' . $sftpPort . $sftpRemoteDir . '/' . basename($dataFile));
					// $fh = fopen('./dokumen_dof/' . $dataFile, 'r');
					$fh = fopen($new_file_path, 'r');

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
			}

			$param_disposisi['id_seksi'] = $isi['id_seksi'];
			$param_disposisi['id_transaksi'] = $this->input->get_post('transaksi_id');
			$param_disposisi['id_transaksi_detail'] = $this->input->get_post('transaksi_detail_id_temp');
			$data_disposisi['id_transaksi_detail'] = $this->input->get_post('transaksi_detail_id');

			// $this->M_inbox->updateTransaksiSeksiDisposisi($param_disposisi, $data_disposisi);
		}

		public function insertClossedNonLetter()
		{
			$isi = $this->session->userdata();

			/* Update Transaksi Detail */
			$id_detail = $this->input->get_post('transaksi_detail_id_temp');
			$data_detail['is_proses'] = 'y';

			$this->M_request->updateRequestDetail($data_detail, $id_detail);
			/* Update Transaksi Detail */

			/* Insert Transaksi Detail - On Progress Non Latter */
			$data['transaksi_detail_id_temp'] = $this->input->get_post('transaksi_detail_id_temp');
			$data['transaksi_detail_id'] = $this->input->get_post('transaksi_detail_id');
			$data['transaksi_id'] = $this->input->post('transaksi_id');
			$data['transaksi_detail_status'] = '17';
			$data['transaksi_detail_nomor'] = '';
			$data['when_create'] = date('Y-m-d H:i:s');
			$data['who_create'] = ($isi['user_id'] == '1') ?  'Super Admin' : $isi['user_nama'];
			$data['who_seksi_create'] = $isi['user_unit_id'];

			$this->M_inbox->insertInboxClossed($data);
			/* Insert Transaksi Detail - On Progress Non Latter */

			/* Update Logsheet */
			$id_logsheets = $this->input->get_post('logsheet_id');
			$data_logsheets['id_transaksi_detail'] = ($this->input->get_post('transaksi_detail_id'));
			$data_logsheets['logsheet_last_update'] = date('Y-m-d H:i:s');

			$this->M_inbox->updateLogSheet($id_logsheets, $data_logsheets);
			/* Update Logsheet */

			/* Update Sample Seksi Disposisi */
			$param_disposisi['id_seksi'] = $isi['id_seksi'];
			$param_disposisi['id_transaksi'] = $this->input->get_post('transaksi_id');
			$param_disposisi['id_transaksi_detail'] = $this->input->get_post('transaksi_detail_id_temp');
			$data_disposisi['id_transaksi_detail'] = $this->input->get_post('transaksi_detail_id');

			$this->M_inbox->updateTransaksiSeksiDisposisi($param_disposisi, $data_disposisi);
			/* Update Sample Seksi Disposisi */

			/* Update Petugas Sample */
			$this->db->query("UPDATE sample.sample_petugas SET id_transaksi_detail = '" . $data['transaksi_detail_id'] . "' WHERE id_transaksi_detail = '" . $data['transaksi_detail_id_temp'] . "'");
			/* Update Petugas Sample */

			sampleLog($this->input->get_post('transaksi_id'), null, $this->input->get_post('transaksi_non_rutin_id'), $this->input->get_post('transaksi_tipe'), $data['transaksi_detail_status'], 'Pekerjaan Telah Diprogress Oleh Eksekutor (Non Latter)');
		}
		// closed


		// Alihkan
		public function insertAlihkan()
		{

			$session = $this->session->userdata();

			$param_delete['id_transaksi'] = $this->input->get_post('id_transaksi_alihkan');
			$param_delete['id_transaksi_detail'] = $this->input->get_post('id_transaksi_detail_alihkan');

			$this->M_inbox->deleteDisposisi($param_delete);

			$id_proses = $this->input->get_post('id_transaksi_detail_alihkan');
			$data_proses['is_proses'] = 'y';

			$this->M_request->updateRequestDetail($data_proses, $id_proses);

			/* Insert Transaksi Detail */
			$data['transaksi_detail_id_temp'] = $this->input->get_post('id_transaksi_detail_alihkan');
			$data['transaksi_detail_id'] = create_id();
			$data['transaksi_id'] = $this->input->post('id_transaksi_alihkan');
			$data['transaksi_detail_status'] = '4';
			$data['when_create'] = date('Y-m-d H:i:s');
			$data['who_create'] = ($session['user_id'] == '1') ?  'Super Admin' : $session['user_nama'];
			$data['who_seksi_create'] = $session['user_unit_id'];
			$data['transaksi_detail_reject_alasan'] = $this->input->get_post('alasan_alihkan');

			$this->M_inbox->insertInboxAlihkan($data);

			echo $this->db->last_query();


			$id = $this->input->post('id_transaksi_alihkan');
			$data_detail = array(
				'id_transaksi_detail' => $this->input->get_post('id_transaksi_detail_alihkan'),
				'transaksi_status' => '4',
				'when_create' => date('Y-m-d H:i:s'),
				'who_create' => $session['user_nama_lengkap'],
				'who_seksi_create' => $session['id_seksi'],
			);

			$this->M_request->updateRequest($data_detail, $id);

			// insert into log
			sampleLog($data['transaksi_id'], null, $this->input->get_post('id_non_rutin_alihkan'), $this->input->get_post('tipe_alihkan'), $data['transaksi_detail_status'], 'Pekerjaan Telah Diminta Dialihkan Oleh Seksi');
		}
		// Alihkan

		public function storeLogsheetHistory()
		{

			$sample_logsheet_id = $this->input->get_post('logsheet_id');
			$sample_transaksi_id = $this->input->get_post('transaksi_id');
			$sample_transaksi_detail_id = $this->input->get_post('transaksi_detail_id_temp');
			$sample_transaksi_non_rutin_id = $this->input->get_post('transaksi_non_rutin_id');
			$sample_history_detail = $this->input->get_post('logsheet_rumus_nama');
			$sample_history_isi = $this->input->get_post('logsheet_rumus');
			$sample_history_hasil = $this->input->get_post('logsheet_hasil');

			logsheetHistory($sample_logsheet_id, $sample_transaksi_id, $sample_transaksi_detail_id, $sample_transaksi_non_rutin_id, $sample_history_detail, $sample_history_isi, $sample_history_hasil);
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


			$id_logsheet = $this->db->get_where('sample.sample_logsheet', array('id_transaksi' => $param['transaksi_id'], 'id_transaksi_detail' => $param['transaksi_detail_id_temp']))->row_array();

			// reset data logsheet detail detail
			if (!empty($id_logsheet)) {
				$id_logsheet_detail = $this->db->get_where('sample.sample_logsheet_detail', array('logsheet_id' => $id_logsheet['logsheet_id']))->result_array();

				foreach ($id_logsheet_detail as $key => $logsheet_detail) {
					$param_logsheet_detail_detail['id_logsheet'] = $logsheet_detail['logsheet_id'];
					$param_logsheet_detail_detail['id_logsheet_detail'] = $logsheet_detail['logsheet_detail_id'];

					$this->M_inbox->deleteLogsheetDetailDetail($param_logsheet_detail_detail);
				}

				// reset data logsheet detail
				$param_logsheet_detail['logsheet_id'] = $id_logsheet['logsheet_id'];
				$this->M_inbox->deleteLogsheetDetail($param_logsheet_detail);
			}

			// reset data logsheet
			$param_logsheet['id_transaksi'] = $this->input->get_post('transaksi_id');
			$param_logsheet['id_transaksi_detail'] = $this->input->get_post('transaksi_detail_id_temp');
			$this->M_inbox->deleteLogsheet($param_logsheet);

			// update data disposisinya
			/* Insert Transaksi Detail */
			// $param_disposisi['id_seksi'] = $session['id_seksi'];
			$param_disposisi['id_transaksi'] = $this->input->get_post('transaksi_id');
			$param_disposisi['id_transaksi_detail'] = $this->input->get_post('transaksi_detail_id_temp');
			$data_disposisi['id_transaksi_detail'] = $this->input->get_post('transaksi_detail_id');
			$this->M_inbox->updateTransaksiSeksiDisposisi($param_disposisi, $data_disposisi);

			// set status saat ini menjadi y
			$id = $this->input->post('transaksi_id');
			$id_detail = $this->input->get_post('transaksi_detail_id_temp');
			$data_detail['is_proses'] = 'y';

			$this->M_request->updateRequestDetail($data_detail, $id_detail);

			// kembali ke status on progres (8)
			$data['transaksi_detail_id_temp'] = $this->input->get_post('transaksi_detail_id_temp');
			$data['transaksi_detail_id'] = $this->input->get_post('transaksi_detail_id');
			$data['transaksi_id'] = $this->input->post('transaksi_id');
			$data['transaksi_detail_status'] = '8';
			$data['transaksi_detail_reject_alasan'] = $this->input->get_post('transaksi_reset_logsheet_alasan');
			$data['when_create'] = date('Y-m-d H:i:s');
			$data['who_create'] = ($session['user_id'] == '1') ?  'Super Admin' : $session['user_nama'];
			$data['who_seksi_create'] = $session['user_unit_id'];

			$this->M_inbox->insertBatal($data);

			$this->db->query("UPDATE sample.sample_petugas SET id_transaksi_detail = '" . $data['transaksi_detail_id'] . "' WHERE id_transaksi_detail = '" . $data['transaksi_detail_id_temp'] . "'");

			// simpan ke sample log untuk history
			sampleLog($this->input->get_post('transaksi_id'), null, $this->input->get_post('transaksi_non_rutin_id'), $this->input->get_post('transaksi_tipe'), $data['transaksi_detail_status'], 'Pekerjaan Telah Direset Logsheet');
		}
		// reset logsheet

		// edit surat
		public function insertEditSurat()
		{
			$session = $this->session->userdata();

			$param['typeId'] = $this->input->get_post('typeId');
			$param['templateId'] = $this->input->get_post('templateId');
			$param['classId'] = $this->input->get_post('classId');
			$param['category'] = $this->input->get_post('category');
			$param['responseSpeed'] = $this->input->get_post('responseSpeed');
			$param['title'] = $this->input->get_post('title');
			$param['drafterId'] = $this->input->get_post('drafterId');
			$param['drafterPoscode'] = $this->input->get_post('drafterPoscode');
			$param['drafterNik'] = $this->input->get_post('drafterNik');
			$param['reviewerId'] = $this->input->get_post('reviewerId');
			$param['reviewerPoscode'] = $this->input->get_post('reviewerPoscode');
			$param['reviewerNik'] = $this->input->get_post('reviewerNik');
			$param['approverId'] = $this->input->get_post('approverId');
			$param['approverPoscode'] = $this->input->get_post('approverPoscode');
			$param['approverNik'] = $this->input->get_post('approverNik');
			$param['tujuanId'] = $this->input->get_post('tujuanId');
			$param['tujuanPoscode'] = $this->input->get_post('tujuanPoscode');
			$param['tujuanNik'] = $this->input->get_post('tujuanNik');
			$param['transaksi_id'] = $this->input->get_post('transaksi_id');
			$param['transaksi_detail_id'] = $this->input->get_post('transaksi_detail_id');
			$param['transaksi_detail_id_temp'] = $this->input->get_post('transaksi_detail_id_temp');
			$param['transaksi_non_rutin_id'] = $this->input->get_post('transaksi_non_rutin_id');
			$param['transaksi_tipe'] = $this->input->get_post('transaksi_tipe');
			$param['dokumen_template_file'] = $this->input->get_post('dokumen_template_file');
			$param['logsheet_id'] = $this->input->get_post('logsheet_id');

			$id_transaksi = $param['transaksi_id'];
			// $param_transaksi['transaksi_id'] = $param['transaksi_id'];
			$param_transaksi['when_create'] = date('Y-m-d H:i:s');
			// $param_transaksi['who_create'] =
			// $param_transaksi['who_seksi_create'] =
			$param_transaksi['transaksi_klasifikasi_id'] = $param['classId'];
			$param_transaksi['transaksi_judul'] = $param['title'];
			$param_transaksi['transaksi_sifat'] = $param['category'];
			$param_transaksi['transaksi_kecepatan_tanggap'] = $param['responseSpeed'];
			$param_transaksi['transaksi_drafter'] = $param['drafterNik'];
			$param_transaksi['transaksi_reviewer'] = $param['reviewerNik'];
			$param_transaksi['transaksi_approver'] = $param['approverNik'];
			$param_transaksi['transaksi_tujuan'] = $param['tujuanNik'];
			$param_transaksi['transaksi_drafter_poscode'] = $param['drafterPoscode'];
			$param_transaksi['transaksi_reviewer_poscode'] = $param['reviewerPoscode'];
			$param_transaksi['transaksi_approver_poscode'] = $param['approverPoscode'];
			$param_transaksi['transaksi_tujuan_poscode'] = $param['tujuanPoscode'];

			$this->M_request->updateRequest($param_transaksi, $id_transaksi);

			// kirim metadatanya ke docx

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

			$tokenBearer = $session['access_token_dof'];

			$reviewerIdList = array($isi['reviewerId']);
			$tujuanIdList = array($isi['tujuanId']);

			$tokenUrl = "https://dof.petrokimia-gresik.com/api/Docs/";

			$tokenContentArray = array(
				"TypeId" => $isi['typeId'],
				"TemplateId" => $isi['templateId'],
				"ClassId" => $isi['classId'],
				"Category" => $isi['category'],
				"ResponseSpeed" => $isi['responseSpeed'],
				"Title" => $isi['title'],
				"DrafterId" => $isi['drafterId'],
				"ReviewerIds" => $isi['reviewerId'],
				"ApproverId" => $isi['approverId'],
				"TujuanIds" => $isi['tujuanId'],
			);

			$tokenContent = urldecode(http_build_query($tokenContentArray));

			$tokenHeaders = array(
				"User-Agent:PostmanRuntime/7.30.0",
				"Authorization:  Bearer " . $tokenBearer,
				"Content-Type: application/x-www-form-urlencoded"
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
			// $object = json_decode(json_encode($item), FALSE);
			// echo json_encode($item);


			if (isset($item['isSuccess']) && $item['isSuccess'] == 'true') {
				// set file lama dan rename ke file baru dengan format docx
				$data_logsheet = $this->db->get_where('sample.sample_logsheet', array('logsheet_id' => $param['logsheet_id']))->row_array();
				$file_lama = $data_logsheet['dokumen_template_file'];
				$file_baru = $item['fileName'];

				// ambil file lama
				$file_lama_berkas = FCPATH . 'document/dof/' . $file_lama;
				$file_baru_berkas = FCPATH . 'document/dof/' . $file_baru;

				$appSid = "06c06436-465e-4d7b-a0c1-43ccea88447f";
				$appKey = "b1fbcc78174ddb6e5873b353e602b5f1";
				$wordsApi = new WordsApi($appSid, $appKey);

				$request = new ConvertDocumentRequest($file_lama_berkas, "docx");

				$result = $wordsApi->convertDocument($request);
				// Save an output file as "sample.docx"
				rename($result->getPathname(), $file_baru_berkas);
			}


			// upload file to ftp
			// ftp settings
			if (isset($item['fileName'])) {
				// FTP access parameters:

				$host = "10.14.41.21";
				$port = "21";
				$timeout = "5";
				$user = "digilab";
				$pass = "D3vD1gi2023!!";
				$local_file = $file_baru_berkas;

				chmod($local_file, 0777);

				$ftp_path = $file_baru;

				$ftp = ftp_connect($host, $port, $timeout);
				ftp_login($ftp, $user, $pass);
				ftp_pasv($ftp, true);

				$ret = ftp_nb_put($ftp, $ftp_path, $local_file, FTP_BINARY, FTP_AUTORESUME);

				while (FTP_MOREDATA == $ret) {
					$ret = ftp_nb_continue($ftp);
				}

				// upload file to ftp
				// die();

				$dof_tokenUrl = "https://dof.petrokimia-gresik.com/api/Docs/IsDocExist?filename=" . $file_baru;

				$dof_tokenHeaders = array(
					"User-Agent:PostmanRuntime/7.30.0",
					"Authorization:  Bearer " . $tokenBearer,
					"Content-Type: application/x-www-form-urlencoded"
				);

				$dof_token = curl_init();
				curl_setopt($dof_token, CURLOPT_URL, $dof_tokenUrl);
				curl_setopt($dof_token, CURLOPT_HTTPHEADER, $dof_tokenHeaders);
				curl_setopt($dof_token, CURLOPT_FOLLOWLOCATION, true);
				curl_setopt($dof_token, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($dof_token, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($dof_token, CURLOPT_MAXREDIRS, 10);
				curl_setopt($dof_token, CURLOPT_TIMEOUT, 0);
				curl_setopt($dof_token, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
				// curl_setopt($dof_token, CURLOPT_POST, true);
				curl_setopt($dof_token, CURLOPT_CUSTOMREQUEST, 'GET');

				$item_dof = curl_exec($dof_token);
				curl_close($dof_token);
				$item_dof = (array)json_decode($item_dof);
				echo json_encode($item_dof);
				// kirim data document ke dof
			}

			// check file apakah sudah sesuai
			$id_logsheet = $param['logsheet_id'];
			// $param_logsheet['id_transaksi'] = $param['transaksi_id'];
			// $param_logsheet['id_transaksi_detail'] = $param['transaksi_detail_id'];
			$param_logsheet['id_dokumen_tipe'] = $param['typeId'];
			$param_logsheet['id_dokumen_template'] = $param['templateId'];
			$param_logsheet['dokumen_template_file'] = $file_baru;

			$this->M_inbox->updateLogsheet($id_logsheet, $param_logsheet);
		}


		// function coba_word()
		// {

		// 	$this->load->library('PdfGenerator');

		// 	$filenames = 'cek.123.docx';
		// 	$main_word = $this->input->get_post('custom_area');
		// 	$link_word = FCPATH . "document/dof/" . $filenames;

		// 	$filename_pdf = explode('.', $filenames);

		// 	$this->pdfgenerator->save($main_word, $filename_pdf[0] . ".pdf", 'A4', 'portrait');


		// 	$appSid = "06c06436-465e-4d7b-a0c1-43ccea88447f";
		// 	$appKey = "b1fbcc78174ddb6e5873b353e602b5f1";
		// 	$wordsApi = new WordsApi($appSid, $appKey);

		// 	$link_pdf = FCPATH . "document/dof/" . $filename_pdf[0] . ".pdf";

		// 	$request = new ConvertDocumentRequest($link_pdf, "docx");

		// 	$result = $wordsApi->convertDocument($request);
		// 	// Save an output file as "sample.docx"
		// 	rename($result->getPathname(), $link_word);

		// 	$local_file = FCPATH . 'document/dof/' . $filenames;

		// 	chmod($local_file, 0777);
		// }

		// edit surat

		/* INSERT */

		public function view_dokumen()
		{
			try {
				$dataFile = 'template.docx';
				// $dataFile = $this->input->post('transaksi_detail_id_temp').'.docx';
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
		}


		/* Reject Kasie */
		public function rejectKasie()
		{
			$isi = $this->session->userdata();

			/* Update Transaksi Detail */
			$id_detail = $this->input->get_post('transaksi_detail_id_temp');
			$data_detail['is_proses'] = 'y';

			$this->M_request->updateRequestDetail($data_detail, $id_detail);
			/* Update Transaksi Detail */

			/* Insert Transaksi Detail - Reject Kasie */
			$data['transaksi_detail_id_temp'] = $this->input->get_post('transaksi_detail_id_temp');
			$data['transaksi_detail_id'] = $this->input->get_post('transaksi_detail_id');
			$data['transaksi_id'] = $this->input->post('transaksi_id');
			$data['transaksi_detail_tgl_estimasi'] = date('Y-m-d H:i:s', strtotime($this->input->post('transaksi_detail_tgl_estimasi')));
			$data['transaksi_detail_status'] = '15';
			$data['transaksi_detail_jumlah'] = '1';
			$data['transaksi_detail_parameter'] = $this->input->post('transaksi_detail_parameter');
			$data['transaksi_detail_deskripsi_parameter'] = $this->input->get_post('transaksi_detail_deskripsi_parameter');
			$data['transaksi_detail_reject_alasan'] = $this->input->get_post('transaksi_detail_reject_alasan');
			$data['when_create'] = date('Y-m-d H:i:s');
			$data['who_create'] = ($isi['user_id'] == '1') ?  'Super Admin' : $isi['user_nama'];
			$data['who_seksi_create'] = $isi['user_unit_id'];

			$this->M_inbox->insertInboxRejectKasie($data);
			/* Insert Transaksi Detail - Reject Kasie */

			/* Update Sample Seksi Disposisi */
			$param_disposisi['id_seksi'] = $isi['id_seksi'];
			$param_disposisi['id_transaksi'] = $this->input->get_post('transaksi_id');
			$param_disposisi['id_transaksi_detail'] = $this->input->get_post('transaksi_detail_id_temp');
			$data_disposisi['id_transaksi_detail'] = $this->input->get_post('transaksi_detail_id');

			$this->M_inbox->updateTransaksiSeksiDisposisi($param_disposisi, $data_disposisi);
			/* Update Sample Seksi Disposisi */

			/* Update Petugas Sample */
			$this->db->query("UPDATE sample.sample_petugas SET id_transaksi_detail = '" . $data['transaksi_detail_id'] . "' WHERE id_transaksi_detail = '" . $data['transaksi_detail_id_temp'] . "'");
			/* Update Petugas Sample */

			/* Update Logsheet */
			$this->db->query("UPDATE sample.sample_logsheet SET id_transaksi_detail = '" . $data['transaksi_detail_id'] . "' WHERE logsheet_id = '" . $this->input->get_post('logsheet_id') . "'");
			/* Update Logsheet */

			sampleLog($this->input->get_post('transaksi_id'), null, $this->input->get_post('transaksi_non_rutin_id'), $this->input->get_post('transaksi_tipe'), $data['transaksi_detail_status'], 'Pekerjaan Telah Diriject Oleh Kasie');
		}
		/* Reject Kasie */

		/* Cek Logsheet */
		public function cekLogsheet()
		{
			$data = $this->db->query("SELECT *,
			to_char(logsheet_tgl_terima,'DD-MM-YYYY') as logsheet_tgl_terima_indo,
			to_char(logsheet_tgl_uji,'DD-MM-YYYY') as logsheet_tgl_uji_indo,
			to_char(logsheet_tgl_sampling,'DD-MM-YYYY') as logsheet_tgl_sampling_indo
			FROM sample.sample_logsheet WHERE logsheet_id = '" . $this->input->get('logsheet_id') . "'")->row_array();

			echo json_encode($data);
		}
		/* Cek Logsheet */

		/* Cek Logsheet Detail */
		public function cekLogsheetDetail()
		{
			$data = $this->db->query("SELECT * FROM sample.sample_logsheet_detail WHERE logsheet_id = '" . $this->input->get('logsheet_id') . "' AND id_rumus = '" . $this->input->get('rumus_id') . "' ORDER BY id_rumus ASC,logsheet_detail_urut ASC")->result_array();

			echo json_encode($data);
		}
		/* Cek Logsheet Detail */

		/* Cek Logsheet Detail Detail */
		public function cekLogsheetDetailDetail()
		{
			$data = $this->db->query("SELECT * FROM sample.sample_logsheet_detail_detail WHERE 1=1 AND id_logsheet_detail = '" . $this->input->get('id_logsheet_detail') . "' ORDER BY rumus_detail_urut ASC,id_logsheet_detail ASC")->result_array();

			echo json_encode($data);
		}
		/* Cek Logsheet Detail Detail */
	}
