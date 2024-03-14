<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Stok extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('dashboard/M_stok');
	}

	public function index()
	{
		$isi['judul'] = 'Stok';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

		$this->template->template_master('dashboard/stok',$isi,$data);

	}

	public function getItem()
	{
		$param = array();
		$param['tahun'] = $this->input->get('tahun');
		$data = $this->M_stok->getItem($param);
		echo json_encode($data);
	}

	public function getTransaksi()
	{
		$bulan_nama = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
		$isi = array();
		$isi['isi'] = array();
		$hasil = array();
		$param = array();
		$param['tahun'] = $this->input->get('tahun');

		$data = $this->M_stok->getTransaksiNama($param);

		foreach ($data as $value) {
			$hasil['isi'] = $value['seksi_nama'];
			$hasil['total'] = array();

			for ($i = 1; $i <= 12; $i++) {
				$isi['bulan'][$i] = $bulan_nama[$i - 1];

				$param['id_gudang_tujuan'] = $value['id_gudang_tujuan'];
				$param['bulan'] = $i;

				$data_isi = $this->M_stok->getTransaksiTotal($param);

				array_push($hasil['total'], $data_isi['total']);
			}
			array_push($isi['isi'], $hasil);
		}
		echo json_encode($isi);
	}

	public function getPerbaikan()
	{
		$bulan_nama = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
		$isi = array();
		$isi['isi'] = array();
		$hasil = array();
		$param = array();
		$param['tahun'] = $this->input->get('tahun');

		$data = $this->M_stok->getPerbaikanNama($param);

		foreach ($data as $value) {
			$hasil['isi'] = $value['peminta_jasa_nama'];
			$hasil['total'] = array();

			for ($i = 1; $i <= 12; $i++) {
				$isi['bulan'][$i] = $bulan_nama[$i - 1];

				$param['peminta_jasa_id'] = $value['peminta_jasa_id'];
				$param['bulan'] = $i;

				$data_isi = $this->M_stok->getPerbaikanTotal($param);

				array_push($hasil['total'], $data_isi['total']);
			}
			array_push($isi['isi'], $hasil);
		}
		echo json_encode($isi);
	}

	public function getPenyerapan()
	{
		$bulan_nama = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
		$isi = array();
		$isi['isi'] = array();
		$hasil = array();
		$param = array();
		$param['tahun'] = $this->input->get('tahun');

		$data = $this->M_stok->getPenyerapanNama($param);

		foreach ($data as $value) {
			$hasil['isi'] = $value['seksi_nama'];
			$hasil['total'] = array();

			for ($i = 1; $i <= 12; $i++) {
				$isi['bulan'][$i] = $bulan_nama[$i - 1];

				$param['id_gudang_tujuan'] = $value['id_gudang_tujuan'];
				$param['bulan'] = $i;

				$data_isi = $this->M_stok->getPenyerapanTotal($param);

				array_push($hasil['total'], $data_isi['total']);
			}
			array_push($isi['isi'], $hasil);
		}
		echo json_encode($isi);
	}

	public function getRequest()
	{

		$tanggal = $this->input->get('tanggal_cari');
		if ($tanggal) $tgl = explode(' - ', $tanggal);
		if ($tanggal) $tgl2 = str_replace('/', '-', $tgl);
		if ($tanggal) $param['tanggal_awal'] = date('Y-m-d', strtotime($tgl2[0]));
		if ($tanggal) $param['tanggal_akhir'] = date('Y-m-d', strtotime($tgl2[1]));


		$param['tahun'] = $this->input->get('tahun');
		$param['transaksi_id'] = $this->input->get('transaksi_id');
		$param['transaksi_tipe'] = $this->input->get_post('transaksi_tipe');
		$data = $this->M_stok->getRequest($param);
		echo json_encode($data);
	}

	public function getMaterial()
	{
		$tanggal = $this->input->get('tanggal_cari');
		if ($tanggal) $tgl = explode(' - ', $tanggal);
		if ($tanggal) $tgl2 = str_replace('/', '-', $tgl);
		if ($tanggal) $param['tanggal_awal'] = date('Y-m-d', strtotime($tgl2[0]));
		if ($tanggal) $param['tanggal_akhir'] = date('Y-m-d', strtotime($tgl2[1]));


		$param['tahun'] = $this->input->get('tahun');
		$param['transaksi_id'] = $this->input->get('transaksi_id');
		$param['transaksi_tipe'] = $this->input->get_post('transaksi_tipe');
		$data = $this->M_stok->getMaterial($param);

		// echo $this->db->last_query();

		echo json_encode($data);
	}
}
