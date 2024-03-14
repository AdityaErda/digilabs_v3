<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Request extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('master/M_sample_peminta_jasa');
		$this->load->model('master/M_material_item');
		$this->load->model('material/M_request');
		$this->load->model('master/M_user');
	}

	/* INDEX */
	public function index()
	{
		$isi['judul'] = 'Material Request';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

		$this->load->view('tampilan/header', $isi);
		$this->load->view('tampilan/sidebar', $data);
		$this->load->view('material/request');
		$this->load->view('tampilan/footer');
		$this->load->view('material/request_js');
	}
	/* INDEX */

	/* INDEX PROSES */
	public function indexProses()
	{
		$isi['judul'] = 'Proses Material Request';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

		$this->load->view('tampilan/header', $isi);
		$this->load->view('tampilan/sidebar', $data);
		$this->load->view('material/request_proses');
		$this->load->view('tampilan/footer');
		$this->load->view('material/request_proses_js');
	}
	/* INDEX PROSES */

	/* Get Request */
	public function getRequest()
	{
		$user = $this->session->userdata();
		$where = array();

		$param['user_id'] = $user['user_id'];
		// $param['user_nik_sap'] = $user['user_nik_sap'];
		$param['user_unit_id'] = $user['user_unit_id'];
		$param['grade'] = (substr($user['user_pgrade'], 0, 1) > '3') ? '1' : '0';
		$param['role_id'] = $user['role_id'];
		$param['tahun'] = $this->input->get('tahun');
		$param['transaksi_id'] = $this->input->get('transaksi_id');
		$param['transaksi_tipe'] = $this->input->get_post('transaksi_tipe');
		$param['transaksi_status'] = $this->input->get_post('transaksi_status');
		$param['tanggal_cari_awal'] = $this->input->get_post('tanggal_cari_awal');
		$param['tanggal_cari_akhir'] = $this->input->get_post('tanggal_cari_akhir');

		$data = $this->M_request->getRequest($param, $where);

		echo json_encode($data);
	}

	public function getTransaksiOut()
	{
		$user = $this->session->userdata();
		$where = array();

		$param['user_id'] = $user['user_id'];
		$param['grade'] = (substr($user['user_pgrade'], 0, 1) > '3') ? '1' : '0';
		$param['role_id'] = $user['role_id'];
		$param['tahun'] = $this->input->get('tahun');
		$param['transaksi_id'] = $this->input->get('transaksi_id');
		$param['transaksi_tipe'] = $this->input->get_post('transaksi_tipe');
		$param['transaksi_status'] = $this->input->get_post('transaksi_status');
		$param['tanggal_cari_awal'] = $this->input->get_post('tanggal_cari_awal');
		$param['tanggal_cari_akhir'] = $this->input->get_post('tanggal_cari_akhir');

		$data = $this->M_request->getRequest($param, $where);

		echo json_encode($data);
	}
	/* Get Request */

	public function getRequestDetail()
	{
		$param['transaksi_id'] = $this->input->get('transaksi_id');
		$data = $this->M_request->getRequestDetail($param);
		echo json_encode($data);
	}

	/* Get History */
	public function getRequestHistory()
	{
		$param['transaksi_id'] = htmlentities($this->input->get('transaksi_id'));
		$data = $this->M_request->getRequestHistory($param);
		echo json_encode($data);
	}
	/* Get History */

	public function getSeksiPeminta()
	{

		if ($this->input->get('aksi')) {
			$user_id = $this->db->query("SELECT * FROM material.material_transaksi WHERE transaksi_id = '" . $this->input->get('id_transaksi') . "'")->row_array();
			$user = $this->db->query("SELECT * FROM global.global_user WHERE user_id = '" . $user_id['user_id_peminta'] . "'")->row_array();
		} else {
			$user = $this->session->userdata();
		}

		$param['seksi_id'] = $user['id_seksi'];
		$data = $this->M_user->getSeksi($param);
		echo json_encode($data);
	}

	public function getUserPeminta()
	{
		if ($this->input->get('aksi')) {
			$user_id = $this->db->query("SELECT * FROM material.material_transaksi WHERE transaksi_id = '" . $this->input->get('id_transaksi') . "'")->row_array();
			$user = $this->db->query("SELECT * FROM global.global_user WHERE user_id = '" . $user_id['user_id_peminta'] . "'")->row_array();
		} else {
			$user = $this->session->userdata();
		}

		$param['user_id'] = $user['user_id'];
		echo json_encode($this->M_user->getUser($param));
	}

	public function getSeksiList()
	{
		$listRequestOrder['results'] = array();
		$param['seksi_nama'] = $this->input->get('seksi_nama');
		foreach ($this->M_user->getSeksi($param) as $key => $value) {
			array_push($listRequestOrder['results'], [
				'id' => $value['seksi_id'],
				'text' => $value['seksi_nama'],
			]);
		}
		echo json_encode($listRequestOrder);
	}


	public function getPemintaJasa()
	{
		$listRequestOrder['results'] = array();
		$param['peminta_jasa_nama'] = $this->input->get('peminta_jasa_nama');
		foreach ($this->M_sample_peminta_jasa->getPemintaJasa($param) as $key => $value) {
			array_push($listRequestOrder['results'], [
				'id' => $value['peminta_jasa_id'],
				'text' => $value['peminta_jasa_nama'],
			]);
		}
		echo json_encode($listRequestOrder);
	}

	public function getItem()
	{
		$param['item_id'] = $this->input->get('item_id');
		$param['item_nama'] = $this->input->get('item_nama');
		$data = $this->M_material_item->getBarangMaterial($param);
		echo json_encode($data);
	}

	/* Insert Transaksi */
	public function insertTransaksi()
	{
		$user = $this->session->userdata();

		$nomor = $this->M_request->getNomorMax();
		$digi = 'DIGILABS';
		$tahun = date('Y');

		$newNomor = sprintf("%05d", ($nomor['isi'] + 1)) . '/' . $digi . '/' . $tahun;

		if ($user['user_job_title'] == 'AVP') {
			$transaksiStatus = 'a';
		} else {
			$transaksiStatus = 'n';
		}

		// $data['transaksi_id'] = $this->input->post('transaksi_id');
		// $data['company_code'] = '1';
		// $data['id_gudang_asal'] = '1';
		// $data['id_gudang_tujuan'] = $this->input->get_post('seksi_id_peminta');
		// $data['user_id_peminta']  = $this->input->get_post('user_id_peminta');
		// $data['transaksi_waktu'] = date('Y-m-d', strtotime($this->input->get_post('tanggal')));
		// $data['transaksi_jam'] = $this->input->get_post('waktu');
		// $data['transaksi_tipe']  = 'o';
		// $data['transaksi_status'] = $transaksiStatus;
		// // $data['transaksi_status'] = 'n';
		// $data['when_create'] = date('Y-m-d H:i:s');
		// $data['who_create'] = $user['user_nama_lengkap'];
		// $data['transaksi_urut']  = $nomor['isi'] + 1;
		// $data['transaksi_nomor'] = $newNomor;
		// $data['transaksi_klasifikasi_id'] = $this->input->get_post('transaksi_klasifikasi_id');

		// $updateIdTransaksiKosong['transaksi_id'] = $data['transaksi_id'];

		// $this->M_request->insertTransaksi($data);

		// materialHistory('I', $data['transaksi_id'], $data['transaksi_status'], 'Tambah Material Request');

		if (
			$user['id_seksi'] == '456' ||
			$user['id_seksi'] == '8a1768c878c3a337463221980a5fc5aea01f588f' ||
			$user['id_seksi'] == 'ab3e7d627d36dc339fdce8c2a16947fcb09940c3' ||
			$user['id_seksi'] == 'a9b1f7a5c83e5bbacc7d3632e8d642a1558a3391' ||
			$user['id_seksi'] == '6553ca3e36fe9c98e97cb66247ab0fc940fde692' ||
			$user['id_seksi'] == 'd29e2694954dad47a5ba0ef6aff0dc04f5b0fa64'
		) {
			/* luk */
			$data['transaksi_id'] = $this->input->post('transaksi_id');
			$data['company_code'] = '1';
			$data['id_gudang_asal'] = '1';
			$data['id_gudang_tujuan'] = $this->input->get_post('seksi_id_peminta');
			$data['user_id_peminta']  = $this->input->get_post('user_id_peminta');
			$data['transaksi_waktu'] = date('Y-m-d', strtotime($this->input->get_post('tanggal')));
			$data['transaksi_jam'] = $this->input->get_post('waktu');
			$data['transaksi_tipe']  = 'o';
			$data['transaksi_status'] = 'a';
			// $data['transaksi_status'] = 'n';
			$data['when_create'] = date('Y-m-d H:i:s');
			$data['who_create'] = $user['user_nama_lengkap'];
			$data['transaksi_urut']  = $nomor['isi'] + 1;
			$data['transaksi_nomor'] = $newNomor;
			$data['transaksi_klasifikasi_id'] = $this->input->get_post('transaksi_klasifikasi_id');

			$updateIdTransaksiKosong['transaksi_id'] = $data['transaksi_id'];

			$this->M_request->insertTransaksi($data);

			materialHistory('I', $data['transaksi_id'], $data['transaksi_status'], 'Tambah Transaksi Out');
		} else {

			$data['transaksi_id'] = $this->input->post('transaksi_id');
			$data['company_code'] = '1';
			$data['id_gudang_asal'] = '1';
			$data['id_gudang_tujuan'] = $this->input->get_post('seksi_id_peminta');
			$data['user_id_peminta']  = $this->input->get_post('user_id_peminta');
			$data['transaksi_waktu'] = date('Y-m-d', strtotime($this->input->get_post('tanggal')));
			$data['transaksi_jam'] = $this->input->get_post('waktu');
			$data['transaksi_tipe']  = 'o';
			$data['transaksi_status'] = $transaksiStatus;
			// $data['transaksi_status'] = 'n';
			$data['when_create'] = date('Y-m-d H:i:s');
			$data['who_create'] = $user['user_nama_lengkap'];
			$data['transaksi_urut']  = $nomor['isi'] + 1;
			$data['transaksi_nomor'] = $newNomor;
			$data['transaksi_klasifikasi_id'] = $this->input->get_post('transaksi_klasifikasi_id');

			$updateIdTransaksiKosong['transaksi_id'] = $data['transaksi_id'];

			$this->M_request->insertTransaksi($data);

			materialHistory('I', $data['transaksi_id'], $data['transaksi_status'], 'Tambah Material Request');
		}
	}
	/* Insert Transaksi */

	/* Update Transaksi */
	public function updateTransaksi()
	{
		$user = $this->session->userdata();

		$id = $this->input->post('transaksi_id');

		$data['transaksi_waktu'] = date('Y-m-d', strtotime($this->input->get_post('tanggal')));
		$data['when_create'] = date('Y-m-d H:i:s');
		$data['who_create'] = $user['user_nama_lengkap'];

		$this->M_request->updateTransaksi($id, $data);

		materialHistory('U', $id, $this->input->get_post('transaksi_status'), 'Update Material Request');
	}
	/* Update Transaksi */

	/* Approve Transaksi */
	public function approveTransaksi()
	{
		$user = $this->session->userdata();

		$id = $this->input->post('transaksi_id');
		// if ($this->input->get_post('transaksi_status') == 'n') {
		// $status = 'r';
		$keterangan = 'Approve AVP Customer';
		// } else if ($this->input->get_post('transaksi_status') == 'r') {
		$status = 'a';
		// $keterangan = 'Approve AVP LUK';
		// }

		$data['transaksi_status'] = $status;

		$this->M_request->updateTransaksi($id, $data);

		materialHistory('U', $id, $status, $keterangan);
	}
	/* Approve Transaksi */

	/* Delete Transaksi */
	public function deleteTransaksi()
	{
		$id = $this->input->get('transaksi_id');
		$this->M_request->deleteTransaksi($id);
		$this->M_request->deleteTransaksiDetail($id);
	}
	/* Delete Transaksi */

	public function cetakDetail()
	{
		$p['transaksi_id'] = $this->input->get_post('id_transaksi');
		$data['isi'] = $this->M_request->getRequestDetail($p);
		// print_r($data);
		$this->load->view('request_detail_cetak', $data);
	}


	public function getEasyuiMaterial()
	{
		$param['transaksi_id'] = $this->input->get('transaksi_id');
		$data = $this->M_request->getEasyuiMaterial($param);
		echo json_encode($data);
	}

	public function insertEasyuiMaterial()
	{
		$transaksiId = $this->input->post('transaksi_id');
		$itemId['item_id'] = $this->input->get_post('item_id');

		$user = $this->session->userdata();
		$harga = $this->M_material_item->getBarangMaterial($itemId);
		// print_r($itemId);
		$harga_item = (preg_replace('/[^0-9]/', '', $harga['item_harga']));

		// if ($transaksiId!='') {
		$data['transaksi_detail_id'] = create_id();
		$data['transaksi_id'] = $transaksiId;
		$data['item_id'] = $this->input->post('item_id');
		$data['transaksi_detail_jumlah'] = $this->input->get_post('transaksi_detail_jumlah');
		$data['transaksi_detail_total'] = $this->input->get_post('transaksi_detail_jumlah') * $harga_item;
		$data['when_create'] = date('Y-m-d H:i:s');
		$data['who_create'] = $user['user_nama_lengkap'];


		$this->M_request->insertEasyuiMaterial($data);


		// echo $this->db->last_query();
		// }
	}

	public function editEasyuiMaterial()
	{
		$id = $this->input->post('transaksi_detail_id');
		$itemId['item_id'] = $this->input->get_post('item_id');

		$user = $this->session->userdata();
		$harga = $this->M_material_item->getBarangMaterial($itemId);
		$harga_item = (preg_replace('/[^0-9]/', '', $harga['item_harga']));

		if ($id) {
			$data['item_id'] = $this->input->post('item_id');
			$data['transaksi_detail_jumlah'] = $this->input->post('transaksi_detail_jumlah');
			$data['transaksi_detail_total'] = $this->input->post('transaksi_detail_jumlah') * $harga_item;
			$data['when_create'] = date('Y-m-d H:i:s');
			$data['who_create'] = $user['user_nama_lengkap'];

			$this->M_request->editEasyuiMaterial($id, $data);
		}
	}

	public function deleteEasyuiMaterial()
	{
		$id = $this->input->post('transaksi_detail_id');
		$this->M_request->deleteEasyuiMaterial($id);
	}

	/* Proses Qr-Code */
	public function prosesQrcode()
	{
		$transaksiId = $this->input->get_post('temp_transaksi_id');
		$itemId['item_id'] = $this->input->get_post('temp_item_id');

		$user = $this->session->userdata();
		$harga = $this->M_material_item->getBarangMaterial($itemId);

		$harga_item = (preg_replace('/[^0-9]/', '', $harga['item_harga']));

		$data['transaksi_detail_id'] = create_id();
		$data['transaksi_id'] = $transaksiId;
		$data['item_id'] = $itemId['item_id'];
		$data['transaksi_detail_jumlah'] = 1;
		$data['transaksi_detail_total'] = 1 * $harga_item;
		$data['when_create'] = date('Y-m-d H:i:s');
		$data['who_create'] = $user['user_nama_lengkap'];

		$this->M_request->insertEasyuiMaterial($data);
	}
	/* Proses Qr-Code */
}
