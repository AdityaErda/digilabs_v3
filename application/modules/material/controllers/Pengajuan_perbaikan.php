<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengajuan_perbaikan extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('material/M_request');
		$this->load->model('master/M_material_aset');
		$this->load->model('master/M_sample_pekerjaan');
	}

	public function index()
	{
		$isi['judul'] = 'Pengajuan Perbaikan / Kalibrasi';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

		$this->load->view('tampilan/header', $isi);
		$this->load->view('tampilan/sidebar', $data);
		$this->load->view('material/pengajuan_perbaikan');
		$this->load->view('tampilan/footer');
		$this->load->view('material/pengajuan_perbaikan_js');
	}

	public function getPengajuan()
	{
		$user = $this->session->userdata();
		$param['user_id'] = $user['user_id'];
		$param['user_unit_id'] = $user['user_unit_id'];
		$param['grade'] = (substr($user['user_pgrade'], 0, 1) > '3') ? '1' : '0';
		$param['role_id'] = $user['role_id'];
		$param['aset_perbaikan_id'] = $this->input->get_post('aset_perbaikan_id');
		$param['tanggal_cari'] = $this->input->get_post('tanggal_cari');
		$param['tanggal_cari_awal'] = $this->input->get_post('tanggal_cari_awal');
		$param['tanggal_cari_akhir'] = $this->input->get_post('tanggal_cari_akhir');

		$where = array();
		// if (!empty($param['tanggal_cari'])) {
		// 	$tgl_ini = date($param['tanggal_cari'] . '-d');
		// 	$where['DATE(aset_perbaikan_tgl_penyerahan) >= '] = date('Y-m-01', strtotime($tgl_ini));
		// 	$where['DATE(aset_perbaikan_tgl_penyerahan) <= '] = date('Y-m-t', strtotime($tgl_ini));
		// } else if (!empty($param['tahun_cari'])) {
		// 	$where['DATE(aset_perbaikan_tgl_penyerahan) >= '] = $param['tahun_cari'] . '-01-01';
		// 	$where['DATE(aset_perbaikan_tgl_penyerahan) <= '] = $param['tahun_cari'] . '-12-31';
		// }

		$data = $this->M_request->getPengajuan($param, $where);

		echo json_encode($data);
	}

	// select 2 aset nomor utama
	public function getAsetNomor()
	{
		$listNomorAset['results'] = array();
		$param['aset_nama'] = $this->input->get('aset_nomor_utama');
		foreach ($this->M_material_aset->getAset($param) as $key => $value) {
			array_push($listNomorAset['results'], [
				'id' => $value['aset_id'],
				'text' => $value['aset_nomor_utama'] . ' - ' . $value['aset_nama'],
			]);
		}
		echo json_encode($listNomorAset);
	}
	// select 2 aset nomor utama

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

	// simpan pengajuan
	public function insertPengajuanPerbaikan()
	{
		$user = $this->session->userdata();

		if (isset($_FILES['aset_perbaikan_file'])) {
			$temp = './upload/';

			if (!file_exists($temp)) mkdir($temp);

			$fileupload      = $_FILES['aset_perbaikan_file']['tmp_name'];
			$ImageName       = $_FILES['aset_perbaikan_file']['name'];
			$ImageType       = $_FILES['aset_perbaikan_file']['type'];

			if (!empty($fileupload)) {
				$acak           = rand(11111111, 99999999);
				$ImageExt       = substr($ImageName, strrpos($ImageName, '.'));
				$ImageExt       = str_replace('.', '', $ImageExt); // Extension
				$ImageName      = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
				$NewImageName   = date('YmdHis') . '.' . $ImageExt;
				move_uploaded_file($_FILES["aset_perbaikan_file"]["tmp_name"], $temp . $NewImageName); // Menyimpan file

				$cek = "Data Berhasil Disimpan";
			} else {
				$cek = "Data Gagal Disimpan";
			}
			echo $cek;
		} else {
			$NewImageName = null;
		}

		if ($user['user_job_title'] == 'AVP') {
			$transaksiStatus = 'n';
		} else {
			$transaksiStatus = '0';
		}

		if ($this->input->get_post('item_id_baru') != '') {
			$data_awal['aset_id'] = create_id();
			$data_awal['aset_nomor_utama'] = $this->input->post('item_id_baru');
			$data_awal['aset_nama'] = $this->input->post('aset_nama');
			$data_awal['aset_umur'] = 0;
			$data_awal['aset_tahun_perolehan'] = date('Y-m-d');
			$data_awal['is_aset'] = 'n';
			$data_awal['aset_jumlah'] = 1;
			$data_awal['when_create'] = date('Y-m-d H:i:s');
			$data_awal['who_create'] = $user['user_nama_lengkap'];

			$this->M_material_aset->insertAset($data_awal);

			$data_detail['aset_detail_id'] = create_id();
			$data_detail['aset_id'] = $data_awal['aset_id'];
			$data_detail['aset_nomor'] = $this->input->post('item_id_baru');
			$data_detail['peminta_jasa_id'] = $this->input->post('peminta_id');
			$data_detail['when_create'] = date('Y-m-d H:i:s');
			$data_detail['who_create'] = $user['user_nama_lengkap'];

			$this->M_material_aset->insertAsetDetail($data_detail);

			$aset_detail_id = $data_detail['aset_detail_id'];
		} else {
			$aset_detail_id = $this->input->get_post('aset_detail_id');
		}

		$data['aset_perbaikan_id'] = create_id();
		$data['aset_detail_id'] = $aset_detail_id;
		$data['aset_perbaikan_tgl_penyerahan'] = date('Y-m-d', strtotime($this->input->get_post('aset_perbaikan_tgl_penyerahan')));
		$data['pekerjaan_id'] = $this->input->get_post('pekerjaan_id');
		$data['peminta_id'] = $this->input->get_post('peminta_id');

		// $data['aset_perbaikan_tgl_selesai'] =
		$data['aset_perbaikan_note'] = $this->input->get_post('aset_perbaikan_note');
		// $data['aset_perbaikan_status'] = $this->input->get_post('aset_perbaikan_status');
		$data['aset_perbaikan_status'] = $transaksiStatus;
		$data['aset_perbaikan_vendor'] = $this->input->get_post('aset_perbaikan_vendor');
		$data['id_user'] = $this->input->get_post('id_user');
		$data['aset_perbaikan_file'] = $NewImageName;
		$data['is_jadwal'] = 'n';
		$data['when_create'] = date('Y-m-d H:i:s');
		$data['who_create'] = $user['user_nama_lengkap'];


		$this->M_request->insertPengajuanPerbaikan($data);

		materialAsetHisotri($data['aset_perbaikan_id'], $data['aset_perbaikan_status']);
	}
	// end simpan pengajuan

	// start simpn pengajuan
	public function updatePengajuanPerbaikan()
	{
		$user = $this->session->userdata();

		if (isset($_FILES['aset_perbaikan_file'])) {
			$temp = './upload/';

			if (!file_exists($temp)) mkdir($temp);

			$fileupload      = $_FILES['aset_perbaikan_file']['tmp_name'];
			$ImageName       = $_FILES['aset_perbaikan_file']['name'];
			$ImageType       = $_FILES['aset_perbaikan_file']['type'];

			if (!empty($fileupload)) {
				$acak           = rand(11111111, 99999999);
				$ImageExt       = substr($ImageName, strrpos($ImageName, '.'));
				$ImageExt       = str_replace('.', '', $ImageExt); // Extension
				$ImageName      = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
				$NewImageName   = date('YmdHis') . '.' . $ImageExt;
				move_uploaded_file($_FILES["aset_perbaikan_file"]["tmp_name"], $temp . $NewImageName); // Menyimpan file

				$cek = "Data Berhasil Disimpan";
			} else {
				$cek = "Data Gagal Disimpan";
			}
			echo $cek;
		} else {
			$NewImageName = null;
		}
		$id = $this->input->get_post('aset_perbaikan_id');
		$data['aset_perbaikan_id'] = $id;
		$data['aset_detail_id'] = $this->input->get_post('aset_detail_id');
		$data['aset_perbaikan_tgl_penyerahan'] = date('Y-m-d', strtotime($this->input->get_post('aset_perbaikan_tgl_penyerahan')));
		$data['pekerjaan_id'] = $this->input->get_post('pekerjaan_id');
		// $data['aset_perbaikan_tgl_selesai'] =
		$data['aset_perbaikan_vendor'] = $this->input->get_post('aset_perbaikan_vendor');
		$data['aset_perbaikan_note'] = $this->input->get_post('aset_perbaikan_note');
		$data['aset_perbaikan_status'] = $this->input->get_post('aset_perbaikan_status');
		$data['id_user'] = $this->input->get_post('id_user');
		if ($NewImageName != '') {
			$data['aset_perbaikan_file'] = $NewImageName;
		}
		$data['is_jadwal'] = 'n';
		$data['when_create'] = date('Y-m-d H:i:s');
		$data['who_create'] = $user['user_nama_lengkap'];

		$this->M_request->updatePengajuanPerbaikan($id, $data);

		materialAsetHisotri($id, $data['aset_perbaikan_status']);

		// print_r($id);
	}
	// start simpn pengajuan
	public function approvePengajuanPerbaikan()
	{
		// if ($this->input->get_post('aset_perbaikan_status') == '0') $status = '1';
		// else $status = 'n';

		$user = $this->session->userdata();

		$id = $this->input->get_post('aset_perbaikan_id');
		$data['aset_perbaikan_status'] = 'n';

		$this->M_request->updatePengajuanPerbaikan($id, $data);

		materialAsetHisotri($id, $data['aset_perbaikan_status']);

		// print_r($id);
	}

	public function deletePengajuanPerbaikan()
	{
		$id = $this->input->get_post('aset_perbaikan_id');
		$this->M_request->deletePengajuanPerbaikan($id);
	}

	public function getAsetHistory()
	{
		$sql = $this->db->query("SELECT * FROM material.material_aset_histori WHERE id_perbaikan_aset = '" . $_GET['aset_perbaikan_id'] . "' ORDER BY material_aset_histori_waktu ASC");
		$isi = $sql->result_array();
		echo json_encode($isi);
	}
}
