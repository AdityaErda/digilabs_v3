<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Fk extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
		// $sql	= $this->db->query("SELECT a.transaksi_id,b.transaksi_detail_id,transaksi_tipe,transaksi_nomor,transaksi_detail_no_memo,transaksi_detail_nomor_sample FROM sample.sample_transaksi a left join sample.sample_transaksi_detail b on b.transaksi_id = a.transaksi_id AND a.id_transaksi_detail = b.transaksi_detail_id WHERE transaksi_tipe !='R' AND transaksi_nomor NOT LIKE '%DIGILABS%' AND transaksi_tgl::date BETWEEN '2024-01-01' AND '2024-01-16' order by transaksi_tipe ASC");

		$sql	= $this->db->query("SELECT a.transaksi_id,b.transaksi_detail_id,transaksi_tipe,transaksi_nomor,transaksi_detail_no_memo,transaksi_detail_nomor_sample FROM sample.sample_transaksi a left join sample.sample_transaksi_detail b on b.transaksi_id = a.transaksi_id AND a.id_transaksi_detail = b.transaksi_detail_id WHERE transaksi_tipe ='R' AND transaksi_nomor NOT LIKE '%DIGILABS%' AND transaksi_tgl::date BETWEEN '2024-01-01' AND '2024-01-16' order by transaksi_tipe ASC");

		$jml	= $sql->num_rows();
		$data	= $sql->result_array();
		$datas = [];

		foreach ($data as $value) {
			array_push($datas, $value);
			// update transaksi_nomor -> transaksi_detail_nomor_sample

			// $update = $this->db->query("UPDATE sample.sample_transaksi_detail A SET transaksi_detail_nomor_sample = ( SELECT transaksi_nomor FROM sample.sample_transaksi b WHERE b.transaksi_id = A.transaksi_id AND b.id_transaksi_detail = A.transaksi_detail_id ) WHERE A.transaksi_id = '" . $value['transaksi_id'] . "' AND A.transaksi_detail_id = '" . $value['transaksi_detail_id'] . "'");

			// update transaksi_detail_no_memo -> transaksi_nomor
			// $update2 = $this->db->query("UPDATE sample.sample_transaksi a SET transaksi_nomor = (SELECT transaksi_detail_no_memo FROM sample.sample_transaksi_detail b WHERE b.transaksi_id = a.transaksi_id AND b.transaksi_detail_id = a.id_transaksi_detail) WHERE a.transaksi_id = '" . $value['transaksi_id'] . "' AND a.id_transaksi_detail = '" . $value['transaksi_detail_id'] . "'");
		}


		echo "<pre>";
		print_r($datas);
		echo "</pre>";


		// echo json_encode($datas);
	}
}
