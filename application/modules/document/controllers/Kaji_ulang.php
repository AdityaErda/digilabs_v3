<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kaji_ulang extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('M_daftar');
	}

	public function index()
	{
		$isi['judul'] = 'Kaji Ulang';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

		$this->load->view('tampilan/header', $isi);
		$this->load->view('tampilan/sidebar', $data);
		$this->load->view('document/kaji_ulang');
		$this->load->view('tampilan/footer');
		$this->load->view('document/kaji_ulang_js');
	}

	public function getDaftar()
	{
		echo json_encode($this->M_daftar->getDaftar());
	}

	public function cover()
	{
		$par['transaksi_id'] = $this->input->get_post('transaksi_id');
		$data['isi'] = $this->M_daftar->getDataPengajuan($par);
		$this->load->view('document/print_cover', $data);
	}

	public function getDataPengajuanDocument()
	{
		$par['transaksi_id']  = $this->input->get_post('transaksi_id');
		echo json_encode($this->M_daftar->getDataPengajuanDocument($par));
		// echo $this->db->last_query();
	}

	public function getDataPengajuanDocumentWord()
	{
		$par['transaksi_id']  = $this->input->get_post('transaksi_id');
		echo json_encode($this->M_daftar->getDataPengajuanDocument($par));
		// echo $this->db->last_query();
	}

	public function getDataPengajuanDetailDocument()
	{
		$par['transaksi_id'] = $this->input->get_post('transaksi_id');
		echo json_encode($this->M_daftar->getDataPengajuanDetail($par));
	}

	public function getHistoryDownload()
	{
		$par['transaksi_id'] = $this->input->get_post('transaksi_id');
		echo json_encode($this->M_daftar->getHistoryDownload($par));
		// echo $this->db->last_query();

	}
	public function getHistoryDownloadDetail()
	{
		$par['transaksi_detail_id'] = $this->input->get_post('transaksi_detail_id');
		echo json_encode($this->M_daftar->getHistoryDownloadDetail($par));
		// echo $this->db->last_query();

	}
	// update document
	public function updatePerubahan()
	{

		// proses simpan word
		$user = $this->session->userdata();

		if (isset($_FILES['transaksi_file_word'])) {
			$temp = './upload/';

			if (!file_exists($temp)) mkdir($temp);

			$fileupload      = $_FILES['transaksi_file_word']['tmp_name'];
			$ImageName       = $_FILES['transaksi_file_word']['name'];
			$ImageType       = $_FILES['transaksi_file_word']['type'];

			if (!empty($fileupload)) {
				$acak           = rand(11111111, 99999999);
				$ImageExt       = substr($ImageName, strrpos($ImageName, '.'));
				$ImageExt       = str_replace('.', '', $ImageExt); // Extension
				$ImageName      = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
				$NewImageNameDoc   = date('YmdHis') . '-' . $ImageName . '.' . $ImageExt;
				move_uploaded_file($_FILES["transaksi_file_word"]["tmp_name"], $temp . $NewImageNameDoc); // Menyimpan file

				$cek = "Data Berhasil Disimpan";
			} else {
				$cek = "Data Gagal Disimpan";
			}
			echo $cek;
		} else {
			$NewImageNameDoc = null;
		}

		// simpan pdf
		if (isset($_FILES['transaksi_file_pdf'])) {
			$temp = './upload/';

			if (!file_exists($temp)) mkdir($temp);

			$fileupload      = $_FILES['transaksi_file_pdf']['tmp_name'];
			$ImageName       = $_FILES['transaksi_file_pdf']['name'];
			$ImageType       = $_FILES['transaksi_file_pdf']['type'];

			if (!empty($fileupload)) {
				$acak           = rand(11111111, 99999999);
				$ImageExt       = substr($ImageName, strrpos($ImageName, '.'));
				$ImageExt       = str_replace('.', '', $ImageExt); // Extension
				$ImageName      = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
				$NewImageNamePDF   = date('YmdHis') . '-' . $ImageName . '.' . $ImageExt;
				move_uploaded_file($_FILES["transaksi_file_pdf"]["tmp_name"], $temp . $NewImageNamePDF); // Menyimpan file

				$cek = "Data Berhasil Disimpan";
			} else {
				$cek = "Data Gagal Disimpan";
			}
			echo $cek;
		} else {
			$NewImageNamePDF = null;
		}

		$id =  $this->input->get_post('transaksi_id');
		$par['company_code'] = '1';
		$par['jenis_id'] = $this->input->get_post('jenis_id');
		$par['transaksi_tgl_pengajuan'] = date('Y-m-d', strtotime($this->input->get_post('transaksi_tgl_pengajuan')));
		$par['transaksi_judul_document'] = $this->input->get_post('transaksi_judul_document');
		$par['transaksi_nomor_document'] = $this->input->get_post('transaksi_nomor_document');
		$par['transaksi_revisi'] = $this->input->get_post('transaksi_revisi');
		$par['transaksi_terbitan'] = $this->input->get_post('transaksi_terbitan');
		if ($this->input->get_post('transaksi_file_word') != 'undefined') {
			$par['transaksi_file_word'] = $NewImageNameDoc;
		}
		if ($this->input->get_post('transaksi_file_pdf') != 'undefined') {
			$par['transaksi_file_pdf'] = $NewImageNamePDF;
		}
		$par['who_create'] = $user['user_nama_lengkap'];
		$par['when_create'] = date('Y-m-d H:i:s');
		$par['seksi_id'] = $this->input->get_post('seksi_id');
		$par['transaksi_keterangan_document'] = $this->input->get_post('transaksi_keterangan_document');
		$par['transaksi_status'] = '1';


		$this->M_daftar->updatePengajuan($par, $id);

		$par1['transaksi_detail_id'] = create_id();
		$par1['transaksi_id'] = $id;
		$par1['transaksi_detail_tgl'] = date('Y-m-d');
		$par1['transaksi_detail_judul_document'] = $this->input->get_post('transaksi_judul_document');
		$par1['transaksi_detail_tgl_document_pengajuan'] = date('Y-m-d', strtotime($this->input->get_post('transaksi_tgl_pengajuan')));
		$par1['transaksi_detail_revisi'] = $this->input->get_post('transaksi_revisi');
		$par1['transaksi_detail_terbitan'] = $this->input->get_post('transaksi_terbitan');
		$par1['transaksi_detail_file_word'] = $NewImageNameDoc;
		$par1['transaksi_detail_file_pdf'] = $NewImageNamePDF;
		$par1['transaksi_detail_tipe'] = '1';
		$par1['when_create'] = date('Y-m-d H:i:s');
		$par1['who_create'] = $user['user_nama_lengkap'];
		// $par1['transaksi_detail_status'] = ;
		$par1['transaksi_detail_keterangan_document'] = $this->input->get_post('transaksi_keterangan_document');
		$par1['transaksi_detail_nomor_document'] = $this->input->get_post('transaksi_nomor_document');
		// $par1['transaksi_detail_file'] = ;
		$par1['transaksi_detail_note_document'] = $this->input->get_post('transaksi_note_document');
		$par1['transaksi_detail_status_pengajuan'] = '0';

		// print_r($par1);

		$this->M_daftar->insertPengajuanDetail($par1);
		// echo $this->db->last_query();
	}
	// update document 

	function historyDownload()
	{
		$user = $this->session->userdata();
		$par['history_download_id'] = create_id();
		$par['transaksi_id'] = $this->input->get_post('transaksi_id');
		$par['transaksi_detail_id'] = $this->input->get_post('transaksi_detail_id');
		$par['history_file_download'] = $this->input->get_post('history_file_download');
		$par['who_download'] = $user['user_nama_lengkap'];
		$par['when_download'] = date('Y-m-d H:i:s');
		$this->M_daftar->historyDownload($par);
	}

	public function print()
	{
		$par['transaksi_status'] = '1';
		$data['isi'] = $this->M_daftar->getDataPengajuan($par);
		// echo $this->db->last_query();

		// $this->load->view('document/kaji_ulang_print', $data);
		$this->load->view('document/kaji_ulang_print_edit', $data);
	}
}
