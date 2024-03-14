<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaksi_out extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('material/M_request');
		$this->load->model('master/M_material_item');
	}

	public function index()
	{
		$isi['judul'] = 'Transaksi Out';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

		$this->load->view('tampilan/header', $isi);
		$this->load->view('tampilan/sidebar', $data);
		$this->load->view('material/transaksi_out');
		$this->load->view('tampilan/footer');
		$this->load->view('material/transaksi_out_js');
	}

	public function proses() {
		$isi['judul'] = 'Transaksi Out - Proses';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

		$this->load->view('tampilan/header', $isi);
		$this->load->view('tampilan/sidebar', $data);
		$this->load->view('material/transaksi_out_proses');
		$this->load->view('tampilan/footer');
		$this->load->view('material/transaksi_out_proses_js');
	}

	public function approveTransaksi()
	{
		$user = $this->session->userdata();
		$Id = $this->input->post('transaksi_id');

		$cek = $this->cekStok();

		if (!$cek) {

			$data['transaksi_status'] = 'y';
			$this->M_request->approveTransaksi($Id, $data);

			materialHistory('U', $Id, 'y', 'Approve Transaksi');

			$batch['transaksi_id'] = $this->input->get_post('transaksi_id');
			$stokBatch = $this->M_request->getSumDetailJumlah($batch);

			//insert ke list batch
			if ($stokBatch['batch_stok'] != '') {
				// $data1['list_batch_id'] = create_id();
				// $data1['transaksi_id'] = $data['transaksi_id'];
				// $data1['list_batch_stok'] = $stokBatch['batch_stok'];
				// $data1['who_create'] = $user['user_nama_lengkap'];
				// $data1['when_create'] = date('Y-m-d H:i:s');

				// $this->M_request->InsertListBatch($data1);

				// insert ke list stok
				foreach ($this->M_request->getRequestDetail($batch) as  $value) {
					// echo json_encode($value);
					$stok['item_id'] = $value['item_id'];
					$stokList = $this->M_request->getItemJumlah($stok);

					// $data2 = array();

					$data2['list_stok_id'] = create_id();
					$data2['item_id'] = $stok['item_id'];
					$data2['company_code'] = '1';
					// $data2['id_gudang'] = $this->input->get_post('peminta_jasa_id');
					$data2['transaksi_detail_id'] = $value['transaksi_detail_id'];
					$data2['list_stok_waktu'] = date('Y-m-d', strtotime($this->input->get_post('tanggal')));
					$data2['list_stok_jam'] = $this->input->get_post('waktu');
					$data2['list_stok_tipe'] = 'o';
					$data2['list_stok_jumlah'] = $value['transaksi_detail_jumlah'];
					$list_stok_stok = $stokList['item_stok'] . " - " . $data2['list_stok_jumlah'];
					$data2['list_stok_stok'] =  $stokList['item_stok'] - $data2['list_stok_jumlah'];
					$data2['when_create'] = date('Y-m-d H:i:s');
					$data2['who_create'] = $user['user_nama_lengkap'];
					// $data2['list_batch_id'] = $data1['list_batch_id'];

					$this->M_request->InsertListStok($data2);

					// update ke master stoknya
					$item_id = $stok['item_id'];
					$data5['item_stok'] =  $stokList['item_stok'] - $value['transaksi_detail_jumlah'];
					$this->M_material_item->UpdateBarangMaterial($data5, $item_id);
				}
				$idStok = $stok['item_id'];
				// $data4['item_stok'] = $stokList['item_stok'] - $stokBatch['batch_stok'];
				$data4['item_stok'] = $data2['list_stok_stok'];
				$this->M_request->updatejmlMaterialItem($idStok, $data4);
			}
		}
	}

	/* Disiapkan Transaksi */
	public function disiapkanTransaksi() {
		$user = $this->session->userdata();

		$id = $this->input->post('transaksi_id');
		$data['transaksi_status'] = 's';

		$this->M_request->updateTransaksi($id, $data);

		materialHistory('s', $id, $status, 'Sedang Disiapkan');
	}
	/* Disiapkan Transaksi */

	/* Diambil Transaksi */
	public function diambilTransaksi() {
		$user = $this->session->userdata();

		$id = $this->input->post('transaksi_id');
		$data['transaksi_status'] = 'd';

		$this->M_request->updateTransaksi($id, $data);

		materialHistory('d', $id, $status, 'Bisa Diambil');
	}
	/* Diambil Transaksi */

	public function insertTransaksiOut()
	{
		$user = $this->session->userdata();
		$cek = $this->cekStok();

		$nomor = $this->M_request->getNomorMax();
		$digi = 'DIGILABS';
		$tahun = date('Y');

		$newNomor = sprintf("%05d", ($nomor['isi'] + 1)) . '/' . $digi . '/' . $tahun;

		if (!$cek) {
			$data['transaksi_id'] = $this->input->post('transaksi_id');
			$data['company_code'] = '1';
			$data['id_gudang_asal'] = '1';
			$data['id_gudang_tujuan'] = $this->input->post('seksi_id_peminta');
			$data['user_id_peminta'] = $this->input->get_post('user_id_peminta');
			$data['transaksi_waktu'] = date('Y-m-d', strtotime($this->input->get_post('tanggal')));
			$data['transaksi_jam'] = $this->input->get_post('waktu');
			$data['transaksi_tipe']  = 'o';
			$data['transaksi_status'] = 'y';
			$data['when_create'] = date('Y-m-d H:i:s');
			$data['transaksi_nomor'] = $newNomor;
			$data['who_create'] = $user['user_nama_lengkap'];


			$this->M_request->insertTransaksiOut($data);

			materialHistory('I', $data['transaksi_id'], $data['transaksi_status'], 'Insert dan Approve Transaksi');

			// untuk jumlah batch
			$batch['transaksi_id'] = $this->input->get_post('transaksi_id');
			$stokBatch = $this->M_request->getSumDetailJumlah($batch);

			//insert ke list batch
			if ($stokBatch['batch_stok'] != '') {
				// $data1['list_batch_id'] = create_id();
				// $data1['transaksi_id'] = $data['transaksi_id'];
				// $data1['list_batch_stok'] = $stokBatch['batch_stok'];
				// $data1['who_create'] = $user['user_nama_lengkap'];
				// $data1['when_create'] = date('Y-m-d H:i:s');

				// $this->M_request->InsertListBatch($data1);

				// insert ke list stok
				foreach ($this->M_request->getRequestDetail($batch) as  $value) {
					// echo json_encode($value);
					$stok['item_id'] = $value['item_id'];
					$stokList = $this->M_request->getItemJumlah($stok);

					// $data2 = array();

					$data2['list_stok_id'] = create_id();
					$data2['item_id'] = $stok['item_id'];
					$data2['company_code'] = '1';
					$data2['id_gudang'] = $this->input->get_post('peminta_jasa_id');
					$data2['transaksi_detail_id'] = $value['transaksi_detail_id'];
					$data2['list_stok_waktu'] = date('Y-m-d', strtotime($this->input->get_post('tanggal')));
					$data2['list_stok_jam'] = $this->input->get_post('waktu');
					$data2['list_stok_tipe'] = 'o';
					$data2['list_stok_jumlah'] = $value['transaksi_detail_jumlah'];
					$list_stok_stok = $stokList['item_stok'] . " - " . $data2['list_stok_jumlah'];
					$data2['list_stok_stok'] =  $stokList['item_stok'] - $data2['list_stok_jumlah'];
					$data2['when_create'] = date('Y-m-d H:i:s');
					$data2['who_create'] = $user['user_nama_lengkap'];
					// $data2['list_batch_id'] = $data1['list_batch_id'];
					$this->M_request->InsertListStok($data2);

					// update ke master stoknya
					$item_id = $stok['item_id'];
					$data5['item_stok'] =  $stokList['item_stok'] - $value['transaksi_detail_jumlah'];
					$this->M_material_item->UpdateBarangMaterial($data5, $item_id);
				}
				$idStok = $stok['item_id'];
				// $data4['item_stok'] = $stokList['item_stok'] - $stokBatch['batch_stok'];
				$data4['item_stok'] = $data2['list_stok_stok'];
				$this->M_request->updatejmlMaterialItem($idStok, $data4);
			}
		}
		// endforeach;

	}
	//   update material stok

	public function cekStok()
	{
		$par['transaksi_id'] = $this->input->get_post('transaksi_id');
		$this->M_request->cekStok($par);
		foreach ($this->M_request->cekStok($par) as $value) {
			$par1['item_id'] = $value['item_id'];
			$par1['transaksi_detail_jumlah'] = $value['transaksi_detail_jumlah'];
			// print_r($par1);
			$cek = $this->M_request->cekdetailStok($par1);
			// echo $this->db->last_query();
			print_r($cek);
			// if($cek){}
		}
	}
}
