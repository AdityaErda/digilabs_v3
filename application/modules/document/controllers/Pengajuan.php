<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengajuan extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('document/M_daftar');
		$this->load->model('master/M_document_jenis');
		$this->load->model('master/M_user');
	}

	public function index()
	{
		$isi['judul'] = 'Pengajuan Document';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

		$this->load->view('tampilan/header', $isi);
		$this->load->view('tampilan/sidebar', $data);
		$this->load->view('document/pengajuan');
		$this->load->view('tampilan/footer');
		$this->load->view('document/pengajuan_js');
	}
	// select 2
	// jenis document
	public function getJenisDocument()
	{
		$listJenisDocument['results'] = array();
		$param['jenis_nama'] = $this->input->get('jenis_nama');
		// sss
		foreach ($this->M_document_jenis->getJenisDocument($param) as $key => $value) {
			array_push($listJenisDocument['results'], [
				'id' => $value['jenis_id'],
				'text' => $value['jenis_nama'],
			]);
		}
		echo json_encode($listJenisDocument);
	}
	// jenis document

	// seksi
	public function getSeksi()
	{
		$listSeksi['results'] = array();

		$param['seksi_id'] = $this->input->get('seksi_id');
		$param['seksi_nama'] = $this->input->get('seksi_nama');
		// sss
		foreach ($this->M_daftar->getSeksi($param) as $key => $value) {
			array_push($listSeksi['results'], [
				'id' => $value['seksi_id'],
				'text' => $value['seksi_nama'],
			]);
		}
		echo json_encode($listSeksi);
	}
	// seksi

	// select 2

	// data pengajuan
	public function getDataPengajuan()
	{
		$par['transaksi_id'] = $this->input->get_post('transaksi_id');
		$par['transaksi_status'] = $this->input->get_post('transaksi_status');

		$data = $this->M_daftar->getDataPengajuan($par);
		echo json_encode($data);
	}
	// data pengajuan

	// data pengajuan
	public function getDataPengajuanDetail()
	{
		$par['transaksi_id'] = $this->input->get_post('transaksi_id');
		$par['transaksi_status'] = $this->input->get_post('transaksi_status');

		$data = $this->M_daftar->getDataPengajuanDetail($par);
		echo json_encode($data);
		// echo $this->db->last_query();

	}
	// data pengajuan

	// simpan document
	public function insertPengajuan()
	{

		$user = $this->session->userdata();

		if (isset($_FILES['transaksi_file_word'])) {
			$upload_path = FCPATH . './upload/';
			if (!file_exists($upload_path)) mkdir($upload_path);
			$allowed_mime_type_arr = array('application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');
			$mime = get_mime_by_extension($_FILES['transaksi_file_word']['name']);
			if (isset($_FILES['transaksi_file_word']['name']) && $_FILES['transaksi_file_word']['name'] != "") {
				if (in_array($mime, $allowed_mime_type_arr)) {
					/*upload excelnya*/
					$tmpName = $_FILES['transaksi_file_word']['tmp_name'];
					$fileName = $_FILES['transaksi_file_word']['name'];
					$fileType = $_FILES['transaksi_file_word']['type'];

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

		if (isset($_FILES['transaksi_file_pdf'])) {
			$upload_path = FCPATH . './upload/';
			if (!file_exists($upload_path)) mkdir($upload_path);
			$allowed_mime_type_arr = array('application/pdf');
			$mime = get_mime_by_extension($_FILES['transaksi_file_pdf']['name']);
			if (isset($_FILES['transaksi_file_pdf']['name']) && $_FILES['transaksi_file_pdf']['name'] != "") {
				if (in_array($mime, $allowed_mime_type_arr)) {
					/*upload excelnya*/
					$tmpName = $_FILES['transaksi_file_pdf']['tmp_name'];
					$fileName = $_FILES['transaksi_file_pdf']['name'];
					$fileType = $_FILES['transaksi_file_pdf']['type'];

					$acak = rand(11111111, 99999999);
					$fileExt = substr($fileName, strpos($fileName, '.'));
					$fileExt = str_replace('.', '', $fileExt); // Extension
					$fileName = preg_replace("/\.[^.\s]{3,4}$/", "", $fileName);
					$newFileNamePDF = $fileName . str_replace(' ', '', $acak . '_' . date('ymdhis') . '.' . $fileExt);
					move_uploaded_file($tmpName, $upload_path . $newFileNamePDF);
				} else {
					echo 0;
					exit;
				}
			}
		} else {
			$newFileNamePDF = null;
		}

		if ($newFileName != null && $newFileNamePDF != null) {
			echo 1;
		}

		$par['transaksi_id'] = anti_inject(create_id());
		$par['company_code'] = anti_inject('1');
		$par['jenis_id'] = anti_inject($this->input->get_post('jenis_id'));
		$par['transaksi_tgl_pengajuan'] = date('Y-m-d', strtotime($this->input->get_post('transaksi_tgl_pengajuan')));
		$par['transaksi_judul_document'] = anti_inject($this->input->get_post('transaksi_judul_document'));
		$par['transaksi_nomor_document'] = anti_inject($this->input->get_post('transaksi_nomor_document'));
		$par['transaksi_revisi'] = anti_inject($this->input->get_post('transaksi_revisi'));
		$par['transaksi_terbitan'] = anti_inject($this->input->get_post('transaksi_terbitan'));
		$par['transaksi_file_word'] = $newFileName;
		$par['transaksi_file_pdf'] = $newFileNamePDF;
		$par['who_create'] = $user['user_nama_lengkap'];
		$par['when_create'] = date('Y-m-d H:i:s');
		$par['seksi_id'] = anti_inject($this->input->get_post('seksi_id'));
		$par['transaksi_keterangan_document'] = anti_inject($this->input->get_post('transaksi_keterangan_document'));
		$par['transaksi_status'] = '0';
		$par['transaksi_tipe'] = '0';
		$par['transaksi_urut_document'] = anti_inject($this->input->get_post('transaksi_urut_document'));
		$this->M_daftar->insertPengajuan($par);

		$par1['transaksi_detail_id'] = anti_inject(create_id());
		$par1['transaksi_id'] = anti_inject($par['transaksi_id']);
		$par1['transaksi_detail_tgl'] = date('Y-m-d');
		$par1['transaksi_detail_judul_document'] = anti_inject($this->input->get_post('transaksi_judul_document'));
		$par1['transaksi_detail_tgl_document_pengajuan'] = date('Y-m-d', strtotime($this->input->get_post('transaksi_tgl_pengajuan')));
		$par1['transaksi_detail_revisi'] = anti_inject($this->input->get_post('transaksi_revisi'));
		$par1['transaksi_detail_terbitan'] = anti_inject($this->input->get_post('transaksi_terbitan'));
		$par1['transaksi_detail_file_word'] = $newFileName;
		$par1['transaksi_detail_file_pdf'] = $newFileNamePDF;
		$par1['transaksi_detail_tipe'] = '0';
		$par1['when_create'] = date('Y-m-d H:i:s');
		$par1['who_create'] = $user['user_nama_lengkap'];
		$par1['transaksi_detail_keterangan_document'] = anti_inject($this->input->get_post('transaksi_keterangan_document'));
		$par1['transaksi_detail_nomor_document'] = anti_inject($this->input->get_post('transaksi_nomor_document'));
		$par1['transaksi_detail_note_document'] = anti_inject($this->input->get_post('transaksi_note_document'));
		$par1['transaksi_detail_status_pengajuan'] = '0';
		$par1['transaksi_detail_urut_document'] = anti_inject($this->input->get_post('transaksi_urut_document'));
		$this->M_daftar->insertPengajuanDetail($par1);
	}
	// simpan document

	// update document
	public function updatePengajuan()
	{
		// proses simpan word
		$user = $this->session->userdata();

		if (isset($_FILES['transaksi_file_word'])) {
			$upload_path = FCPATH . './upload/';
			if (!file_exists($upload_path)) mkdir($upload_path);
			$allowed_mime_type_arr = array('application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');
			$mime = get_mime_by_extension($_FILES['transaksi_file_word']['name']);
			if (isset($_FILES['transaksi_file_word']['name']) && $_FILES['transaksi_file_word']['name'] != "") {
				if (in_array($mime, $allowed_mime_type_arr)) {
					/*upload excelnya*/
					$tmpName = $_FILES['transaksi_file_word']['tmp_name'];
					$fileName = $_FILES['transaksi_file_word']['name'];
					$fileType = $_FILES['transaksi_file_word']['type'];

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

		if (isset($_FILES['transaksi_file_pdf'])) {
			$upload_path = FCPATH . './upload/';
			if (!file_exists($upload_path)) mkdir($upload_path);
			$allowed_mime_type_arr = array('application/pdf');
			$mime = get_mime_by_extension($_FILES['transaksi_file_pdf']['name']);
			if (isset($_FILES['transaksi_file_pdf']['name']) && $_FILES['transaksi_file_pdf']['name'] != "") {
				if (in_array($mime, $allowed_mime_type_arr)) {
					/*upload excelnya*/
					$tmpName = $_FILES['transaksi_file_pdf']['tmp_name'];
					$fileName = $_FILES['transaksi_file_pdf']['name'];
					$fileType = $_FILES['transaksi_file_pdf']['type'];

					$acak = rand(11111111, 99999999);
					$fileExt = substr($fileName, strpos($fileName, '.'));
					$fileExt = str_replace('.', '', $fileExt); // Extension
					$fileName = preg_replace("/\.[^.\s]{3,4}$/", "", $fileName);
					$newFileNamePDF = $fileName . str_replace(' ', '', $acak . '_' . date('ymdhis') . '.' . $fileExt);
					move_uploaded_file($tmpName, $upload_path . $newFileNamePDF);
				} else {
					echo 0;
					exit;
				}
			}
		} else {
			$newFileNamePDF = null;
		}

		if (($newFileName != null && $newFileNamePDF != null)) {
			echo 1;
		} else if (($this->input->get_post('transaksi_file_pdf') == 'undefined' || $this->input->get_post('transaksi_file_word') == 'undefined')) {
			echo 1;
		}

		$id = anti_inject($this->input->get_post('transaksi_id'));
		$par['company_code'] = '1';
		$par['jenis_id'] = anti_inject($this->input->get_post('jenis_id'));
		$par['transaksi_tgl_pengajuan'] = date('Y-m-d', strtotime($this->input->get_post('transaksi_tgl_pengajuan')));
		$par['transaksi_judul_document'] = anti_inject($this->input->get_post('transaksi_judul_document'));
		$par['transaksi_nomor_document'] = anti_inject($this->input->get_post('transaksi_nomor_document'));
		$par['transaksi_revisi'] = anti_inject($this->input->get_post('transaksi_revisi'));
		$par['transaksi_terbitan'] = anti_inject($this->input->get_post('transaksi_terbitan'));
		if ($this->input->get_post('transaksi_file_word') != 'undefined') {
			$par['transaksi_file_word'] = $newFileName;
		}
		if ($this->input->get_post('transaksi_file_pdf') != 'undefined') {
			$par['transaksi_file_pdf'] = $newFileNamePDF;
		}
		$par['who_create'] = $user['user_nama_lengkap'];
		$par['when_create'] = date('Y-m-d H:i:s');
		$par['seksi_id'] = anti_inject($this->input->get_post('seksi_id'));
		$par['transaksi_keterangan_document'] = anti_inject($this->input->get_post('transaksi_keterangan_document'));
		$par['transaksi_status'] = '0';
		$this->M_daftar->updatePengajuan($par, $id);

		$id_det = anti_inject($this->input->get_post('transaksi_detail_id'));
		$par1['transaksi_id'] = $id;
		$par1['transaksi_detail_tgl'] = date('Y-m-d');
		$par1['transaksi_detail_judul_document'] = anti_inject($this->input->get_post('transaksi_judul_document'));
		$par1['transaksi_detail_tgl_document_pengajuan'] = date('Y-m-d', strtotime($this->input->get_post('transaksi_tgl_pengajuan')));
		$par1['transaksi_detail_revisi'] = anti_inject($this->input->get_post('transaksi_revisi'));
		$par1['transaksi_detail_terbitan'] = anti_inject($this->input->get_post('transaksi_terbitan'));
		$par1['transaksi_detail_file_word'] = $newFileName;
		$par1['transaksi_detail_file_pdf'] = $newFileNamePDF;
		$par1['transaksi_detail_tipe'] = '0';
		$par1['when_create'] = date('Y-m-d H:i:s');
		$par1['who_create'] = $user['user_nama_lengkap'];
		$par1['transaksi_detail_keterangan_document'] = anti_inject($this->input->get_post('transaksi_keterangan_document'));
		$par1['transaksi_detail_nomor_document'] = anti_inject($this->input->get_post('transaksi_nomor_document'));
		$par1['transaksi_detail_note_document'] = anti_inject($this->input->get_post('transaksi_note_document'));
		$par1['transaksi_detail_status_pengajuan'] = '0';
		$this->M_daftar->updatePengajuanDetail($par1, $id_det);
	}
	// update document

	// hapus document

	public function hapusPengajuan()
	{
		$this->M_daftar->hapusPengajuan($this->input->get_post('transaksi_id'));
		$this->M_daftar->hapusPengajuanDetail($this->input->get_post('transaksi_id'));
	}

	public function getNomorDocument()
	{
		$p['jenis_id'] = $this->input->get_post('jenis_id');
		$data = $this->M_document_jenis->getJenisDocument($p);
		$p1['seksi_id'] = $this->input->get_post('seksi_id');
		$data1 = $this->M_user->getSeksi($p1);
		$p2['transaksi_id'] = $this->input->get_post('transaksi_id');
		$tahun = date('Y');
		$bulan = date('m');
		$tahun_potong = substr($tahun, '2');
		$where = " 1=1 ";
		$where .= " and transaksi_waktu >= " . "'" . $tahun . '-01-01' . "'";
		$where .= " and transaksi_waktu <= " . "'" . $tahun . '-12-31' . "'";
		if ($p2['transaksi_id'] = '') {
			$urut = $this->db->query("SELECT max(transaksi_detail_urut_document) as urut FROM document.document_transaksi_detail")->row_array();
			$kode = $urut['urut'] + 1;
			$kodeUrut =  sprintf("%02s", $kode);
			$kodenya = 	[
				"kodefinal" => "PG-" . $data['jenis_kode'] . "-39-4" . $data1['seksi_kode'] . $kodeUrut,
				"kodeurut" => $kode,
			];
		} else {
			$urut = $this->db->query("SELECT max(transaksi_detail_urut_document) as urut FROM document.document_transaksi_detail ")->row_array();
			$kodeUrut =  sprintf("%02s", $urut['urut']);
			$kodenya = 	[
				"kodefinal" => "PG-" . $data['jenis_kode'] . "-39-4" . $data1['seksi_kode'] . $kodeUrut,
				"kodeurut" => $urut,
			];
		}
		echo json_encode($kodenya);
	}

	public function getNomorKembar()
	{
		$data = $this->M_daftar->getNomorKembar();
		echo json_encode($data);
	}
}
