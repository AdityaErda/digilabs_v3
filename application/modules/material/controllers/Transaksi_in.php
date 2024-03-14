<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaksi_in extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('material/M_request');
		$this->load->model('master/M_material_item');
	}

	public function index()
	{
		$isi['judul'] = 'Transaksi In';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

		$this->load->view('tampilan/header', $isi);
		$this->load->view('tampilan/sidebar', $data);
		$this->load->view('material/transaksi_in');
		$this->load->view('tampilan/footer');
		$this->load->view('material/transaksi_in_js');
	}


	public function proses()
	{
		$isi['judul'] = 'Transaksi In - Proses';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

		$this->load->view('tampilan/header', $isi);
		$this->load->view('tampilan/sidebar', $data);
		$this->load->view('material/transaksi_in_proses');
		$this->load->view('tampilan/footer');
		$this->load->view('material/transaksi_in_proses_js');
	}

	// data Transaksi In
	public function getTransaksiIn()
	{

		$param['is_batal'] = $this->input->get_post('is_batal');
		$param['transaksi_id'] = $this->input->get_post('transaksi_id');
		$param['tanggal_cari'] = $this->input->get_post('tanggal_cari');
		$param['tanggal_cari_awal'] = $this->input->get_post('tanggal_cari_awal');
		$param['tanggal_cari_akhir'] = $this->input->get_post('tanggal_cari_akhir');
		$where = array();
		if (!empty($param['tanggal_cari'])) {
			$tgl_ini = date($param['tanggal_cari'] . '-d');
			$where['DATE(transaksi_waktu) >= '] = date('Y-m-01', strtotime($tgl_ini));
			$where['DATE(transaksi_waktu) <= '] = date('Y-m-t', strtotime($tgl_ini));
		} else if (!empty($param['tanggal_cari_awal']) && !empty($param['tanggal_cari_akhir'])) {
			$tgl_ini = date($param['tanggal_cari_awal'] . '-d');
			$tgl_akhir = date($param['tanggal_cari_akhir'] . '-d');
			$where['DATE(transaksi_waktu) >= '] = date('Y-m-01', strtotime($tgl_ini));
			$where['DATE(transaksi_waktu) <= '] = date('Y-m-t', strtotime($tgl_akhir));
		} else if (!empty($param['tahun_cari'])) {
			$where['DATE(transaksi_waktu) >= '] = $param['tahun_cari'] . '-01-01';
			$where['DATE(transaksi_waktu) <= '] = $param['tahun_cari'] . '-12-31';
		}

		$data = $this->M_request->getTransaksiIn($param, $where);
		// echo $this->db->last_query($data);
		echo json_encode($data);
	}
	// end data Transaksi In

	// start no batch
	public function noBatch()
	{
		$tahun = date('Y');
		$bulan = date('m');
		$tahun_potong = substr($tahun, '2');
		$where = " 1=1 ";
		$where .= " and transaksi_waktu >= " . "'" . $tahun . '-01-01' . "'";
		$where .= " and transaksi_waktu <= " . "'" . $tahun . '-12-31' . "'";
		// $where['transaksi_waktu >= '] = $tahun . '-01-01';
		// $where['transaksi_waktu <= '] = $tahun . '-12-31';
		// }


		$urut = $this->db->query("SELECT max(list_batch_kode) as urut FROM material.material_list_batch a left join material.material_transaksi b on a.transaksi_id = b.transaksi_id WHERE " . $where . " ")->row_array();
		$kode = $urut['urut'] + 1;
		$kodeUrut =  sprintf("%02s", $kode);
		$kodeFinal = $kodeUrut . $bulan . $tahun_potong;



		print_r($kodeFinal);
	}

	// end no batch

	// simpan Transaksi In
	public function InsertTransaksiIn()
	{
		$user = $this->session->userdata();

		$data['transaksi_id'] = $this->input->post('transaksi_id');
		$data['company_code'] = '1';
		$data['id_gudang_asal'] = '';
		$data['id_gudang_tujuan'] = '1';
		$data['transaksi_waktu'] = date('Y-m-d', strtotime($this->input->get_post('tanggal')));
		$data['transaksi_jam'] = $this->input->get_post('waktu');
		$data['transaksi_tipe'] = 'i';
		$data['transaksi_status'] = 'y';
		$data['is_batal'] = 'n';
		$data['when_create'] = date('Y-m-d H:i:s');
		$data['who_create'] = $user['user_nama_lengkap'];

		$this->M_request->InsertTransaksiIn($data);


		$batch['transaksi_id'] = $this->input->get_post('transaksi_id');
		$stokBatch = $this->M_request->getSumDetailJumlah($batch);


		$tahun = date('Y');
		$bulan = date('m');
		$tahun_potong = substr($tahun, '2');
		$where = " 1=1 ";
		$where .= " and transaksi_waktu >= " . "'" . $tahun . '-01-01' . "'";
		$where .= " and transaksi_waktu <= " . "'" . $tahun . '-12-31' . "'";


		$urut = $this->db->query("SELECT max(list_batch_kode) as urut FROM material.material_list_batch a left join material.material_transaksi b on a.transaksi_id = b.transaksi_id WHERE " . $where . " ")->row_array();
		$kode = $urut['urut'] + 1;
		$kodeUrut =  sprintf("%02s", $kode);


		//insert ke list batch
		if ($stokBatch['batch_stok'] != '') {
			foreach ($this->M_request->getkodeItem($batch) as $kodeValue) {

				$kodeFinal = $kodeUrut . $kodeValue['jenis_kode'] . $bulan . $tahun_potong;

				$data1['list_batch_id'] = create_id();
				$data1['transaksi_id'] = $data['transaksi_id'];
				$data1['transaksi_detail_id'] = $kodeValue['transaksi_detail_id'];
				$data1['list_batch_stok'] = $stokBatch['batch_stok'];
				$data1['who_create'] = $user['user_nama_lengkap'];
				$data1['when_create'] = date('Y-m-d H:i:s');
				$data1['list_batch_kode'] = $kodeUrut;
				$data1['list_batch_kode_final'] = $kodeFinal;

				$this->M_request->InsertListBatch($data1);
			}
			// insert ke list stok
			foreach ($this->M_request->getRequestDetail($batch) as  $value) {
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
				$data2['list_stok_tipe'] = 'i';
				$data2['list_stok_jumlah'] = $value['transaksi_detail_jumlah'];
				// $list_stok_stok = $stokList['item_stok']." + ".$data2['list_stok_jumlah'];
				$data2['list_stok_stok'] =  $stokList['item_stok'] + $data2['list_stok_jumlah'];
				$data2['when_create'] = date('Y-m-d H:i:s');
				$data2['who_create'] = $user['user_nama_lengkap'];
				$data2['list_batch_id'] = $data1['list_batch_id'];

				$this->M_request->InsertListStok($data2);

				// update ke master stoknya
				$item_id = $stok['item_id'];
				$data5['item_stok'] =  $stokList['item_stok'] + $value['transaksi_detail_jumlah'];
				$this->M_material_item->UpdateBarangMaterial($data5, $item_id);
			}
			$idStok = $stok['item_id'];
			// $data4['item_stok'] = $stokList['item_stok'] - $stokBatch['batch_stok'];
			$data4['item_stok'] = $data2['list_stok_stok'];
			// print_r($data4);
			$this->M_request->updatejmlMaterialItem($idStok, $data4);
			// echo $this->db->last_query();
		}
	}
	// end simpan Transaksi In

	public function batalTransaksiIn()
	{
		$user = $this->session->userdata();
		// print_r($user);
		$id = $this->input->get_post('id_transaksi_batal');
		$param['is_batal'] = 'y';
		$param['batal_alasan'] = $this->input->get_post('batal_alasan');

		$this->M_request->batalTransaksiIn($id, $param);

		$batch['transaksi_id'] = $this->input->get_post('id_transaksi_batal');
		$stokBatch = $this->M_request->getSumDetailJumlah($batch);

		foreach ($this->M_request->getRequestDetail($batch) as  $value) {
			// print_r($value);
			$stok['item_id'] = $value['item_id'];
			$stokList = $this->M_request->getitemJumlah($stok);

			// print_r($stokList);

			$data2['list_stok_id'] = create_id();
			$data2['item_id'] = $stok['item_id'];
			$data2['company_code'] = '1';
			// $data2['id_gudang'] = $this->input->get_post('peminta_jasa_id');
			$data2['id_gudang'] = '1';
			$data2['transaksi_detail_id'] = $value['transaksi_detail_id'];
			$data2['list_stok_waktu'] = date('Y-m-d');
			$data2['list_stok_jam'] = date('H:i:s');
			$data2['list_stok_tipe'] = 'o';
			$data2['list_stok_jumlah'] = $value['transaksi_detail_jumlah'];
			// $list_stok_stok = $stokList['item_stok']." - ".$data2['list_stok_jumlah'];
			$data2['list_stok_stok'] =  $stokList['item_stok'] + $data2['list_stok_jumlah'];
			$data2['when_create'] = date('Y-m-d H:i:s');
			$data2['who_create'] = $user['user_nama_lengkap'];
			// // $data2['list_batch_id'] = $data1['list_batch_id'];

			$this->M_request->InsertListStok($data2);
			echo $this->db->last_query();

			// update ke master stoknya
			$item_id = $stok['item_id'];
			$data5['item_stok'] =  $stokList['item_stok'] - $value['transaksi_detail_jumlah'];
			// print_r($data5);
			$this->M_material_item->UpdateBarangMaterial($data5, $item_id);
		}
		// $idStok = $stok['item_id'];
		// $data4['item_stok'] = $stokList['item_stok'] - $stokBatch['batch_stok'];
		// $data4['item_stok'] = $data2['list_stok_stok'];
		// $this->M_request->updatejmlMaterialItem($idStok,$data4);
	}


	/* QRCODE */
	public function printQrcode()
	{
		$data['item_id'] = $this->input->get('item_id');
		// print_r($data);

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

		$nim = $data['item_id'];
		$image_name = $nim . '.png'; //buat name dari qr code sesuai dengan nim

		// $url = 'coba';
		// $url =  base_url('login/?header_menu=01&menu_id=04&tipe=E&transaksi_id=' . $data['transaksi_id']);
		$url = $data['item_id'];

		$params['data'] = $url; //data yang akan di jadikan QR CODE
		$params['level'] = 'H'; //H=High
		$params['size'] = 10;
		$params['savename'] = FCPATH . $config['imagedir'] . $image_name; //simpan image QR CODE ke folder assets/images/
		$this->ciqrcode->generate($params);
		/* QRCODE */

		$this->load->view('material/qrcode_transaksi_in', $data);
	}
	/* QRCODE */
}
