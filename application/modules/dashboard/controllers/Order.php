<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		isLogin();
		$this->load->model('dashboard/M_order');
	}

	public function index()
	{
		$isi['judul'] = 'Order';
		$data = $this->session->userdata();
		$data['session_login'] = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

		$this->load->view('tampilan/header', $isi);
		$this->load->view('tampilan/sidebar', $data);
		$this->load->view('dashboard/order');
		$this->load->view('tampilan/footer');
		$this->load->view('dashboard/order_js');
	}

	public function getOrderData()
	{
		$param['transaksi_tipe'] = $this->input->get_post('transaksi_tipe');
		$param['tahun'] = $this->input->get('tahun');
		$data = $this->M_order->getOrderData($param);
		echo json_encode($data);
	}

	public function getOrderTotal()
	{
		$param['transaksi_status'] = $this->input->get_post('transaksi_status');
		$param['transaksi_tipe'] = $this->input->get_post('transaksi_tipe');
		$param['tahun'] = $this->input->get('tahun');
		$data = $this->M_order->getOrderTahun($param);
		// echo $this->db->last_query();
		echo json_encode($data);
	}

	public function getOrderBulan()
	{
		$param = array();
		$param['tahun'] = $this->input->get('tahun');
		$data = array();

		foreach ($this->M_order->getOrderBulan($param) as $value) {
			$param_detail['tahun'] = $this->input->get('tahun');
			$param_detail['bulan'] = $value['bln'];

			$eksternal = $this->M_order->getOrderBulanEksternal($param_detail);
			$internal = $this->M_order->getOrderBulanInternal($param_detail);
			$rutin = $this->M_order->getOrderBulanRutin($param_detail);

			$isi['bulan'] = $value['bulan'];
			$isi['total_eksternal'] = $eksternal['total'];
			$isi['total_internal'] = $internal['total'];
			$isi['total_rutin'] = $rutin['total'];

			array_push($data, $isi);
		}

		echo json_encode($data);
	}

	public function getOrderSeksi()
	{
		$param['tahun'] = $this->input->get('tahun');
		$data = $this->M_order->getOrderSeksi($param);
		// echo $this->db->last_query();
		echo json_encode($data);
	}

	public function getOrderStatus()
	{
		$param['tahun'] = $this->input->get('tahun');
		$data = $this->M_order->getOrderStatus($param);
		// echo $this->db->last_query();

		echo json_encode($data);
	}

	public function getSumParameter()
	{
		$param = array();
		$param['tahun'] = $this->input->get('tahun');
		$data = $this->M_order->getSumParameter($param);

		// echo $this->db->last_query();
		echo json_encode($data);
	}

	public function getOrderCustomer()
	{
		$param = array();
		$param['tahun'] = $this->input->get('tahun');
		$data = $this->M_order->getOrderCustomer($param);
		// echo $this->db->last_query();

		echo json_encode($data);
	}

	public function getPendapatanBulan()
	{
		$param = array();
		if ($this->input->get('tahun')) {
			$param['tahun'] =  anti_inject_angka($this->input->get('tahun'));
		}
		$data = $this->M_order->getPendapatanBulan($param);
		// echo $this->db->last_query();

		$param_lalu = [];
		if ($this->input->get('tahun') && is_numeric($this->input->get('tahun'))) {
			$param_lalu['tahun'] =  anti_inject_angka($this->input->get('tahun')) - 1;
		}

		$data_lalu = $this->M_order->getPendapatanBulan($param_lalu);

		$isi = array();
		foreach ($data as $key => $value) {
			$isi[$key] = $value;
			if ($data_lalu) {
				$isi[$key]['total_lalu'] = $data_lalu[$key]['total'];
			}
		}

		echo json_encode($isi);
	}
}
