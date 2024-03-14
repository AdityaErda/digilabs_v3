<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Stok extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('material/M_request');
		$this->load->model('master/M_material_item');
	}

	public function index()
	{
		$isi['judul'] = 'Material Stok';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

		$this->load->view('tampilan/header', $isi);
		$this->load->view('tampilan/sidebar', $data);
		$this->load->view('material/stok');
		$this->load->view('tampilan/footer');
		$this->load->view('material/stok_js');
	}

	public function getStok()
	{
		$tanggal = $this->input->get_post('tanggal_cari');
		if ($tanggal) $tgl = explode(' - ', $tanggal);
		if ($tanggal) $tgl2 = str_replace('/', '-', $tgl);
		if ($tanggal) $param['tanggal_awal'] = date('Y-m-d', strtotime($tgl2[0]));
		if ($tanggal) $param['tanggal_akhir'] = date('Y-m-d', strtotime($tgl2[1]));
		$param['filter_kode_material'] = $this->input->get_post('filter_kode_material');
		$param['item_cari'] = $this->input->get_post('item_cari');

		$data = $this->M_request->getStok($param);
		echo json_encode($data);
	}

	public function getStokDetail()
	{
		$param['item_id'] = $this->input->get('item_id');
		$data = $this->M_request->getStokDetail($param);
		echo json_encode($data);
	}

	/* QRCODE */
	public function printQrcode()
	{
		$data['item_id'] = $this->input->get('id_qr');

		// $data = $this->M_notifikasi->getNotifikasiBarcode($param);
		// $data_awal = $this->M_notifikasi->getNotifikasiBarcodeAwal($param);
		// print_r($data_awal);

		// $data['note'] = $data_awal['transaksi_detail_note'];

		// if ($data['transaksi_tipe'] == 'R') {
		// 	$data['note'] = $data['transaksi_detail_note'];
		// } else {
		// 	$data['note'] = $data_awal['transaksi_detail_note'];
		// }

		// $url = '';
		// if ($data['transaksi_tipe'] == 'E') {
		// 	$url =  base_url('login/?header_menu=01&menu_id=04&tipe=E&transaksi_id=' . $data['transaksi_id']);
		// } else if ($data['transaksi_tipe'] == 'I') {
		// 	$url = base_url('login/?header_menu=07&menu_id=10&tipe=I&transaksi_id=' . $data['transaksi_id']);
		// } else if ($data['transaksi_tipe'] == 'R') {
		// 	$url = base_url('login/?header_menu=07&menu_id=10&tipe=I&tipe_rutin=R&transaksi_id=' . $data['transaksi_id']);
		// }
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

		$this->load->view('material/print_qrcode', $data);
	}
	/* QRCODE */

	/* QRCODE */
	public function printQrcodeBesar()
	{
		$data['item_id'] = $this->input->get('id_qr_besar');
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

		$this->load->view('material/print_qrcode_besar', $data);
	}
	/* QRCODE */
}
