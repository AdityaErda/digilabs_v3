<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Update_document extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('M_request');
	}

	public function index()
	{
		$isi['judul'] = 'Update Document';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

		$this->load->view('tampilan/header', $isi);
		$this->load->view('tampilan/sidebar', $data);
		$this->load->view('material/update_document');
		$this->load->view('tampilan/footer');
		$this->load->view('material/update_document_js');
	}

	public function getDocument()
	{
		$param['tanggal_cari'] = $this->input->get_post('tanggal_cari');
		$param['tanggal_cari_awal'] = $this->input->get_post('tanggal_cari_awal');
		$param['tanggal_cari_akhir'] = $this->input->get_post('tanggal_cari_akhir');
		$where = array();
		if (!empty($param['tanggal_cari'])) {
			$tgl_ini = date($param['tanggal_cari'] . '-d');
			$where['DATE(transaksi_waktu) >= '] = date('Y-m-01', strtotime($tgl_ini));
			$where['DATE(transaksi_waktu) <= '] = date('Y-m-t', strtotime($tgl_ini));
		} else if (!empty($param['tahun_cari'])) {
			$where['DATE(transaksi_waktu) >= '] = $param['tahun_cari'] . '-01-01';
			$where['DATE(transaksi_waktu) <= '] = $param['tahun_cari'] . '-12-31';
		}

		$param['list_batch_id'] = $this->input->get_post('list_batch_id');
		$data = $this->M_request->getDocument($param, $where);

		echo json_encode($data);
	}

	public function getDocumentDetail()
	{
		$param['list_batch_id'] = $this->input->get_post('list_batch_id');
		$param['batch_file_tgl_expired'] = $this->input->get_post('tanggal_exp');
		$data = $this->M_request->getDocumentDetail($param);
		// print_r($this->db->last_query());

		echo json_encode($data);
	}

	public function getDocumentDetailAll() {
		$param['id_item'] = $this->input->get_post('id_item');
		$param['batch_file_tgl_expired'] = $this->input->get_post('tanggal_exp');

		$data = $this->M_request->getDocumentDetailAll($param);

		echo json_encode($data);
	}

	public function getEasyuiDocument()
	{
		$param['list_batch_id'] = $this->input->get_post('list_batch_id');
		$data = $this->M_request->getEasyuiDocument($param);
		// print($this->db->last_query());
		echo json_encode($data);
	}


	public function insertEasyuiDocument()
	{

		$user = $this->session->userdata();

		$data['batch_file_id'] = create_id();
		$data['list_batch_id'] = $this->input->get_post('list_batch_id');
		$data['batch_file_tgl_terbit'] = date('Y-m-d', strtotime($this->input->get_post('batch_file_tgl_terbit')));
		$data['batch_file_tgl_expired'] = date('Y-m-d', strtotime($this->input->get_post('batch_file_tgl_expired')));
		$data['batch_file_judul'] = $this->input->get_post('batch_file_judul');
		$data['batch_file_isi'] = $this->input->get_post('savedFileName');
		$data['when_create'] = date('Y-m-d H:i:s');
		$data['who_create'] = $user['user_nama_lengkap'];

		$this->M_request->insertEasyuiDocument($data);
	}

	public function insertEasyuiDocumentFile()
	{

		if (isset($_FILES['file'])) {
			$temp = "./upload/";
			// echo $temp;
			if (!file_exists($temp)) mkdir($temp);

			$fileupload      = $_FILES['file']['tmp_name'];
			$ImageName       = $_FILES['file']['name'];
			$ImageType       = $_FILES['file']['type'];

			if (!empty($fileupload)) {
				$acak           = rand(11111111, 99999999);
				$ImageExt       = substr($ImageName, strrpos($ImageName, '.'));
				$ImageExt       = str_replace('.', '', $ImageExt); // Extension
				$ImageName      = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
				$NewImageName   = date('ymdhis') . '.' . $ImageExt;

				move_uploaded_file($_FILES["file"]["tmp_name"], $temp . $NewImageName); // Menyimpan file

				echo $NewImageName;
			} else {
				$NewImageName = null;
			}
		}
	}

	public function editEasyuiDocument()
	{
		$id = $this->input->get_post('batch_file_id');

		$data['batch_file_tgl_terbit'] = date('Y-m-d', strtotime($this->input->get_post('batch_file_tgl_terbit')));
		$data['batch_file_tgl_expired'] = date('Y-m-d', strtotime($this->input->get_post('batch_file_tgl_expired')));
		$data['batch_file_judul'] = $this->input->get_post('batch_file_judul');

		if ($this->input->get_post('savedFileName')) {
			$data['batch_file_isi'] = $this->input->get_post('savedFileName');
		}

		$data['when_create'] = date('Y-m-d H:i:s');
		// echo json_encode($data);

		$this->M_request->editEasyuiDocument($id, $data);
		// print_r($this->db->last_query());
	}

	public function deleteEasyuiDocument()
	{
		$id = $this->input->get_post('batch_file_id');
		$this->M_request->deleteEasyuiDocument($id);
		// print_r($this->db->last_query());
	}
}
