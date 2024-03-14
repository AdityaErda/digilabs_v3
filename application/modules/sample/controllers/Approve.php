<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Approve extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('sample/M_request');
		$this->load->model('sample/M_approve');
		$this->load->model('master/M_user');
	}

	public function index()
	{
		$isi['judul'] = 'Approve';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');
		// $data['tipe'] = $this->input->get('tipe');

		$this->load->view('tampilan/header', $isi);
		$this->load->view('tampilan/sidebar', $data);
		$this->load->view('sample/approve');
		$this->load->view('tampilan/footer');
		$this->load->view('sample/approve_js');
	}

	/* GET */
	public function getApprove()
	{
		if ($this->input->get('tgl_cari')) $tgl = explode(' - ', $this->input->get('tgl_cari'));
		if ($this->input->get('tgl_cari')) $param['tgl_awal'] = date('Y-m-d', strtotime($tgl[0]));
		if ($this->input->get('tgl_cari')) $param['tgl_akhir'] = date('Y-m-d', strtotime($tgl[1]));

		$param['transaksi_id'] = $this->input->get('transaksi_id');
		// $param['transaksi_tipe'] = $this->input->get('transaksi_tipe');
		$param['transaksi_status'] = $this->input->get_post('transaksi_status');
		$param['status_cari'] = $this->input->get_post('status_cari');
		$status_approve = explode(',', $this->input->get_post('transaksi_status_approve'));
		$param['transaksi_status_approve'] = $status_approve;
		$param['tanggal_cari'] = $this->input->get_post('tanggal_cari');
		$param['tanggal_cari_awal'] = $this->input->get_post('tanggal_cari_awal');
		$param['tanggal_cari_akhir'] = $this->input->get_post('tanggal_cari_akhir');


		$where = array();
		if (!empty($param['tanggal_cari'])) {
			$tgl_ini = date($param['tanggal_cari'] . '-d');
			$where['DATE(transaksi_tgl) >= '] = date('Y-m-01', strtotime($tgl_ini));
			$where['DATE(transaksi_tgl) <= '] = date('Y-m-t', strtotime($tgl_ini));
		} else if (!empty($param['tahun_cari'])) {
			$where['DATE(transaksi_tgl) >= '] = $param['tahun_cari'] . '-01-01';
			$where['DATE(transaksi_tgl) <= '] = $param['tahun_cari'] . '-12-31';
		}

		$data = $this->M_approve->getApprove($param, $where);
		echo json_encode($data);
	}

	public function getSeksi()
	{
		$list['results'] = array();

		$param['seksi_nama'] = $this->input->get('seksi_nama');
		$param['id_seksi_saat_ini'] = $this->input->get_post('id_seksi_saat_ini');

		foreach ($this->M_approve->getSeksi($param) as $key => $value) {
			array_push($list['results'], [
				'id' => $value['seksi_id'],
				'text' => $value['seksi_nama'],
			]);
		}

		echo json_encode($list);
	}

	public function getSeksi2()
	{
	{
		$list['results'] = array();

		$param['seksi_id'] = $this->input->get('seksi_id');

		$data_seksi = $this->M_approve->getSeksi($param);
		$data['id'] = $data_seksi['seksi_id'];
		$data['text'] = $data_seksi['seksi_nama'];

		echo json_encode($data);
	}
	}
	/* GET */

	/* INSERT */
	public function insertApprove()
	{
		$isi = $this->session->userdata();
		/* Insert Petugas */
		foreach ($this->input->post('id_seksi') as $value) {
			$data_disposisi['seksi_disposisi_id'] = create_id();
			$data_disposisi['id_transaksi'] = $this->input->post('transaksi_id');
			$data_disposisi['id_seksi'] = $value;

			$this->M_approve->insertDisposisi($data_disposisi);
		}
		/* Insert Petugas */

		/* Insert Transaksi Detail */
		$data['transaksi_detail_id'] = create_id();
		$data['transaksi_id'] = $this->input->post('transaksi_id');
		$data['is_urgent'] = $this->input->post('is_urgent');
		$data['is_khusus'] = $this->input->post('is_khusus');
		$data['transaksi_detail_note'] = $this->input->post('transaksi_detail_note');
		$data['transaksi_detail_parameter'] = $this->input->post('transaksi_detail_parameter');
		$data['transaksi_detail_status'] = '1';
		$data['transaksi_detail_tgl_memo'] = date('Y-m-d H:i:s', strtotime($this->input->post('transaksi_detail_tgl_memo')));
		$data['transaksi_detail_no_memo'] = $this->input->post('transaksi_detail_no_memo');
		$data['when_create'] = date('Y-m-d H:i:s');
		$data['who_create'] = $isi['user_nama_lengkap'];
		$data['who_seksi_create'] = $isi['id_seksi'];

		$this->M_approve->insertApprove($data);
		// echo $this->db->last_query();

		/* Insert Transaksi Detail */

		/* Update Transaksi */
		$id = $this->input->post('transaksi_id');
		$data_detail = array(
			'id_transaksi_detail' => $data['transaksi_detail_id'],
			'transaksi_status' => $data['transaksi_detail_status'],
			'when_create' => date('Y-m-d H:i:s'),
			'who_create' => $isi['user_nama_lengkap'],
			'who_seksi_create' => $isi['id_seksi'],
		);

		$this->M_request->updateRequest($data_detail, $id);
		/* Update Transaksi */
	}

	/* INSERT */
	public function insertReview()
	{
		$isi = $this->session->userdata();
		/* Insert Petugas */
		foreach ($this->input->post('id_seksi') as $value) {
			$data_disposisi['seksi_disposisi_id'] = create_id();
			$data_disposisi['id_transaksi'] = $this->input->post('transaksi_id');
			$data_disposisi['id_seksi'] = $value;

			$this->M_approve->insertDisposisi($data_disposisi);
		}
		/* Insert Petugas */

		/* Insert Transaksi Detail */
		$data['transaksi_detail_id'] = create_id();
		$data['transaksi_id'] = $this->input->post('transaksi_id');
		$data['is_urgent'] = $this->input->post('is_urgent');
		$data['is_khusus'] = $this->input->post('is_khusus');
		$data['transaksi_detail_note'] = $this->input->post('transaksi_detail_note');
		$data['transaksi_detail_parameter'] = $this->input->post('transaksi_detail_parameter');
		$data['transaksi_detail_status'] = '01';
		$data['transaksi_detail_tgl_memo'] = date('Y-m-d H:i:s', strtotime($this->input->post('transaksi_detail_tgl_memo')));
		$data['transaksi_detail_no_memo'] = $this->input->post('transaksi_detail_no_memo');
		$data['when_create'] = date('Y-m-d H:i:s');
		$data['who_create'] = $isi['user_nama_lengkap'];
		$data['who_seksi_create'] = $isi['id_seksi'];

		$this->M_approve->insertApprove($data);
		// echo $this->db->last_query();

		/* Insert Transaksi Detail */

		/* Update Transaksi */
		$id = $this->input->post('transaksi_id');
		$data_detail = array(
			'id_transaksi_detail' => $data['transaksi_detail_id'],
			'transaksi_status' => $data['transaksi_detail_status'],
			'when_create' => date('Y-m-d H:i:s'),
			'who_create' => $isi['user_nama_lengkap'],
			'who_seksi_create' => $isi['id_seksi'],
		);

		$this->M_request->updateRequest($data_detail, $id);
		/* Update Transaksi */
	}

	public function insertReject()
	{
		$isi = $this->session->userdata();

		/* Insert Transaksi Detail */
		$data['transaksi_detail_id'] = create_id();
		$data['transaksi_id'] = $this->input->post('transaksi_id');
		$data['is_urgent'] = $this->input->post('is_urgent');
		$data['is_khusus'] = $this->input->post('is_khusus');
		$data['id_seksi'] = $this->input->post('id_seksi');
		$data['transaksi_detail_note'] = $this->input->post('transaksi_detail_note');
		$data['transaksi_detail_parameter'] = $this->input->post('transaksi_detail_parameter');
		$data['transaksi_detail_status'] = '8';
		$data['transaksi_detail_tgl_memo'] = date('Y-m-d H:i:s', strtotime($this->input->post('transaksi_detail_tgl_memo')));
		$data['transaksi_detail_no_memo'] = $this->input->post('transaksi_detail_no_memo');
		$data['when_create'] = date('Y-m-d H:i:s');
		$data['who_create'] = $isi['user_nama_lengkap'];
		$data['who_seksi_create'] = $isi['id_seksi'];

		$this->M_approve->insertApprove($data);
		/* Insert Transaksi Detail */

		/* Update Transaksi */
		$id = $this->input->post('transaksi_id');
		$data_detail = array(
			'id_transaksi_detail' => $data['transaksi_detail_id'],
			'transaksi_status' => $data['transaksi_detail_status'],
			'when_create' => date('Y-m-d H:i:s'),
			'who_create' => $isi['user_nama_lengkap'],
			'who_seksi_create' => $isi['id_seksi'],
		);

		$this->M_request->updateRequest($data_detail, $id);
		/* Update Transaksi */
	}
	/* INSERT */
}
