<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Antrian_perbaikan extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('material/M_request');
		$this->load->model('master/M_material_aset');
	}

	public function index()
	{
		$isi['judul'] = 'Daftar Antrian Perbaikan / Kalibrasi';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

		$this->load->view('tampilan/header', $isi);
		$this->load->view('tampilan/sidebar', $data);
		$this->load->view('material/antrian_perbaikan');
		$this->load->view('tampilan/footer');
		$this->load->view('material/antrian_perbaikan_js');
	}

	// data perbaikan
	public function getAntrianPerbaikan()
	{

		$param['aset_perbaikan_id'] = $this->input->get_post('aset_perbaikan_id');
		$param['terjadwal_cari'] = $this->input->get_post('terjadwal_cari');
		$param['jenis_cari'] = $this->input->get_post('jenis_cari');
		$param['tahun'] = $this->input->get('tahun');
		$param['tanggal_cari'] = $this->input->get_post('tanggal_cari');
		$param['tanggal_cari_awal'] = $this->input->get_post('tanggal_cari_awal');
		$param['tanggal_cari_akhir'] = $this->input->get_post('tanggal_cari_akhir');

		$where = array();
		if (!empty($param['tanggal_cari'])) {
			$tgl_ini = date($param['tanggal_cari'] . '-d');
			$where['DATE(aset_perbaikan_tgl_penyerahan) >= '] = date('Y-m-01', strtotime($tgl_ini));
			$where['DATE(aset_perbaikan_tgl_penyerahan) <= '] = date('Y-m-t', strtotime($tgl_ini));
		} else if (!empty($param['tahun_cari'])) {
			$where['DATE(aset_perbaikan_tgl_penyerahan) >= '] = $param['tahun_cari'] . '-01-01';
			$where['DATE(aset_perbaikan_tgl_penyerahan) <= '] = $param['tahun_cari'] . '-12-31';
		}

		$data = $this->M_request->getPengajuan($param, $where);
		echo json_encode($data);
	}
	// data perbaikan

	// select2
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

	public function updateAntrianPerbaikan()
	{
		$user = $this->session->userdata();

		if (isset($_FILES['aset_perbaikan_file'])) {
			$temp = ('./upload/');

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
		$data['aset_detail_id'] = $this->input->get_post('aset_detail_id');
		$data['aset_perbaikan_tgl_penyerahan'] = date('Y-m-d', strtotime($this->input->get_post('aset_perbaikan_tgl_penyerahan')));
		// $data['aset_perbaikan_tgl_selesai'] = date('Y-m-d',strtotime($this->input->get_post('aset_perbaikan_tgl_selesai')));
		$data['pekerjaan_id'] = $this->input->get_post('pekerjaan_id');
		$data['peminta_id'] = $this->input->get_post('peminta_id');
		$data['aset_perbaikan_note_selesai'] = $this->input->get_post('aset_perbaikan_note_selesai');
		$data['aset_perbaikan_note'] = $this->input->get_post('aset_perbaikan_note');
		$data['aset_perbaikan_status'] = $this->input->get_post('aset_perbaikan_status');
		$data['aset_perbaikan_vendor'] = $this->input->get_post('aset_perbaikan_vendor');
		if ($NewImageName != '') {
			$data['aset_perbaikan_file'] = $NewImageName;
		}
		$data['when_create'] = date('Y-m-d H:i:s');
		$data['who_create'] = $user['user_nama_lengkap'];

		$this->M_request->updatePengajuanPerbaikan($id, $data);

		materialAsetHisotri($id, $data['aset_perbaikan_status']);

		// jika status y maka update tanggal selesai 
		if ($this->input->get_post('aset_perbaikan_status') == 'y') {
			// print_r('y');
			$id1 = $this->input->get_post('aset_perbaikan_id');
			$data1['aset_perbaikan_tgl_selesai'] = date('Y-m-d', strtotime($this->input->get_post('aset_perbaikan_tgl_selesai')));
			$this->M_request->updateJadwalSelesai($id1, $data1);
			echo $this->db->last_query();
		}

		// jika status sudah selesai maka masukann ke detail aset 
		// if ($this->input->get_post('aset_perbaikan_status') == 'y') {
		// 	$isi = $this->session->userdata();

		// 	$data2['aset_detail_id'] = create_id();
		// 	$data2['aset_id'] = $this->input->post('temp_aset_id');
		// 	$data2['aset_nomor'] = $this->input->post('temp_aset_nomor');
		// 	$data2['aset_detail_merk'] = $this->input->post('temp_aset_detail_merk');
		// 	$data2['peminta_jasa_id'] = $this->input->post('peminta_id');
		// 	$data2['when_create'] = date('Y-m-d H:i:s');
		// 	$data2['who_create'] = $isi['user_nama_lengkap'];
		// 	// print_r($data2);

		// 	$this->M_material_aset->insertAsetDetail($data2);
		// 	// echo $this->db->last_query();

		// 	$this->fun_jumlah($this->input->post('temp_aset_id'));
		// }


		// print_r($data);
	}

	/* FUN TAMBAHAN */
	public function fun_jumlah($id)
	{
		$param['aset_id'] = $id;
		$isi = $this->M_material_aset->getJumlahAsetDetail($param);

		$data = array(
			'aset_jumlah' => $isi['total'],
		);

		$this->M_material_aset->updateAset($data, $id);
	}
	/* FUN TAMBAHAN */

	// selet2
}
