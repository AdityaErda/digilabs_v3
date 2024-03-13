<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_order extends CI_Model
{
	public function getOrderBulan($data = null)
	{
		$this->db->select("to_char(a.transaksi_detail_tgl_pengajuan, 'Month') as bulan, EXTRACT(MONTH FROM TO_DATE(to_char(a.transaksi_detail_tgl_pengajuan, 'Month'), 'Month')) AS bln");
		$this->db->from('sample.sample_transaksi_detail a');
		$this->db->join('sample.sample_transaksi b', 'a.transaksi_id = b.transaksi_id');
		if (isset($data['tahun'])) $this->db->where("date_part('year', b.transaksi_tgl) = " . $data['tahun']);
		// $this->db->where('is_proses is null');

		$this->db->group_by("to_char(a.transaksi_detail_tgl_pengajuan, 'Month')");
		$this->db->order_by('bln', 'asc');
		$sql = $this->db->get();

		return $sql->result_array();
	}

	public function getOrderData($data = null)
	{
		$this->db->select("a.transaksi_nomor,a.transaksi_tgl,a.when_create,a.transaksi_sifat,a.transaksi_kecepatan_tanggap,a.transaksi_id,a.transaksi_nomor, a.transaksi_tipe, a.transaksi_status,b.transaksi_detail_status,b.transaksi_detail_no_memo, b.transaksi_detail_no_surat,b.transaksi_detail_note,b.transaksi_detail_nomor,b.transaksi_detail_nomor_sample, c.jenis_nama, d.peminta_jasa_nama, e.sample_pekerjaan_nama, f.identitas_nama, g.*, to_char(b.transaksi_detail_tgl_pengajuan, 'DD-MM-YYYY') AS transaksi_detail_tgl_pengajuan_baru, to_char(b.transaksi_detail_tgl_memo, 'DD-MM-YYYY') AS transaksi_detail_tgl_memo_baru, to_char(b.transaksi_detail_tgl_estimasi, 'DD-MM-YYYY') AS transaksi_detail_tgl_estimasi_baru, b.transaksi_detail_note as note_awal,transaksi_detail_file,transaksi_detail_attach");
		$this->db->from('sample.sample_transaksi a');
		$this->db->join('sample.sample_transaksi_detail b', 'a.transaksi_id = b.transaksi_id', 'left');
		$this->db->join('sample.sample_jenis c', 'c.jenis_id = b.jenis_id', 'left');
		$this->db->join('sample.sample_peminta_jasa d', 'd.peminta_jasa_id = b.peminta_jasa_id', 'left');
		$this->db->join('sample.sample_pekerjaan e', 'e.sample_pekerjaan_id = b.jenis_pekerjaan_id', 'left');
		$this->db->join('sample.sample_identitas f', 'f.identitas_id = b.identitas_id', 'left');
		$this->db->join('sample.sample_klasifikasi g', 'g.klasifikasi_id = a.transaksi_klasifikasi_id', 'left');

		if (isset($data['transaksi_id'])) $this->db->where('a.transaksi_id', $data['transaksi_id']);

		// if (isset($data['tanggal_cari_awal'])) $this->db->where('DATE(a.transaksi_tgl) >= ', $data['tanggal_cari_awal']);
		// if (isset($data['tanggal_cari_akhir'])) $this->db->where('DATE(a.transaksi_tgl) <= ', $data['tanggal_cari_akhir']);

		if (isset($data['transaksi_tipe']) & $data['transaksi_tipe'] != '-') {
			if (isset($data['transaksi_tipe'])) $this->db->where_in("a.transaksi_tipe", $data['transaksi_tipe']);
			if (isset($data['transaksi_status_request'])) $this->db->where("a.transaksi_status", $data['transaksi_status_request']);
		};
		if (isset($data['tahun'])) $this->db->where("date_part('year', a.transaksi_tgl) = " . $data['tahun']);
		// if (isset($data['seksi_id'])) $this->db->where('a.who_seksi_create', $data['seksi_id']);
		// if (isset($data['transaksi_status'])) $this->db->where_not_in('a.transaksi_status', $data['transaksi_status']);

		// if (isset($data['track_sample'])) $this->db->like('(transaksi_nomor)', strtoupper($data['track_sample']), 'BOTH');
		// if (isset($data['track_sample'])) $this->db->or_like('(transaksi_detail_nomor)', strtoupper($data['track_sample']), 'BOTH');

		$this->db->where("b.is_proses  is null");


		$this->db->order_by('a.transaksi_nomor', 'asc');
		$this->db->order_by('b.transaksi_detail_nomor', 'asc');
		$this->db->order_by('a.transaksi_tgl', 'desc');
		$this->db->order_by('a.when_create', 'desc');
		// $this->db->order_by('a.transaksi_status', 'asc');
		$this->db->order_by('b.transaksi_detail_status', 'asc');
		$sql = $this->db->get();

		return $sql->result_array();
	}

	public function getOrderTahun($data = null)
	{
		$this->db->select("count(*) as total");
		$this->db->from('sample.sample_transaksi_detail a');
		$this->db->join('sample.sample_transaksi b', 'a.transaksi_id = b.transaksi_id AND a.transaksi_detail_id = b.id_transaksi_detail');
		if (isset($data['tahun'])) $this->db->where("date_part('year', b.transaksi_tgl) = " . $data['tahun']);
		if (isset($data['transaksi_tipe'])) $this->db->where('transaksi_tipe', $data['transaksi_tipe']);
		if (isset($data['transaksi_status'])) $this->db->where_not_in('transaksi_status', $data['transaksi_status']);

		// $this->db->where('is_proses is null');
		$sql = $this->db->get();

		return $sql->row_array();
	}

	public function getOrderBulanEksternal($data = null)
	{
		$this->db->select("COUNT(b.transaksi_id) AS total");
		$this->db->from('sample.sample_transaksi_detail a');
		$this->db->join('sample.sample_transaksi b', 'a.transaksi_detail_id = b.id_transaksi_detail AND b.transaksi_tipe = ' . "'E'", 'left');
		// $this->db->where("a.is_proses  is null");

		if (isset($data['tahun'])) $this->db->where("date_part('year', b.transaksi_tgl) = " . $data['tahun']);
		if (isset($data['bulan'])) $this->db->where("date_part('Month', b.transaksi_tgl) = " . $data['bulan']);
		$sql = $this->db->get();

		return $sql->row_array();
	}

	public function getOrderBulanInternal($data = null)
	{
		$this->db->select("COUNT(b.transaksi_id) AS total");
		$this->db->from('sample.sample_transaksi_detail a');
		$this->db->join('sample.sample_transaksi b', 'a.transaksi_detail_id = b.id_transaksi_detail AND b.transaksi_tipe = ' . "'I'", 'left');
		// $this->db->where("a.is_proses  is null");

		if (isset($data['tahun'])) $this->db->where("date_part('year', b.transaksi_tgl) = " . $data['tahun']);
		if (isset($data['bulan'])) $this->db->where("date_part('Month', b.transaksi_tgl) = " . $data['bulan']);
		$sql = $this->db->get();

		return $sql->row_array();
	}

	public function getOrderBulanRutin($data = null)
	{
		$this->db->select("COUNT(b.transaksi_id) AS total");
		$this->db->from('sample.sample_transaksi_detail a');
		$this->db->join('sample.sample_transaksi b', 'a.transaksi_detail_id = b.id_transaksi_detail AND b.transaksi_tipe = ' . "'R'", 'left');
		// $this->db->where("b.is_proses  is null");

		if (isset($data['tahun'])) $this->db->where("date_part('year', b.transaksi_tgl) = " . $data['tahun']);
		if (isset($data['bulan'])) $this->db->where("date_part('Month', b.transaksi_tgl) = " . $data['bulan']);
		$this->db->where_not_in('transaksi_status', '8');
		$sql = $this->db->get();

		return $sql->row_array();
	}

	public function getOrderSeksi($data = null)
	{
		// $this->db->select("*");
		$this->db->select("c.seksi_nama, COUNT(*) AS total,is_disposisi");
		$this->db->from('sample.sample_transaksi a');
		$this->db->join('sample.sample_transaksi_detail b', 'b.transaksi_detail_id = a.id_transaksi_detail', 'left');
		$this->db->join('global.global_seksi c', 'a.who_seksi_create = c.seksi_id', 'left');
		// $this->db->where("(is_proses IS NULL)");
		$this->db->where('c.is_disposisi', 'y');
		$this->db->where('a.transaksi_tipe !=', 'R');
		if (isset($data['tahun'])) $this->db->where("date_part('year', a.transaksi_tgl) = " . $data['tahun']);
		$this->db->group_by("seksi_nama,is_disposisi");
		$this->db->order_by('seksi_nama', 'asc');
		$sql = $this->db->get();

		return $sql->result_array();
	}

	public function getOrderStatus($data = null)
	{
		$this->db->select("b.transaksi_detail_status, COUNT(*) AS total");
		// $this->db->select('*');
		$this->db->from('sample.sample_transaksi a');
		$this->db->join('sample.sample_transaksi_detail b', 'a.id_transaksi_detail = b.transaksi_detail_id', 'left');
		$this->db->where('a.transaksi_tipe !=', 'R');
		$this->db->where("(b.transaksi_detail_status = '12' OR b.transaksi_detail_status = '15' OR b.transaksi_detail_status = '18')");
		$this->db->where("a.who_seksi_create != '6553ca3e36fe9c98e97cb66247ab0fc940fde692'");
		// $this->db->where("a.who_seksi_create != '6553ca3e36fe9c98e97cb66247ab0fc940fde692' AND a.peminta_jasa_id != '5b2cd34d84e8b3c4c1750af221a70a599d6d54f7' ");
		// $this->db->where('E')
		// $this->db->where('EXTRACT(YEAR FROM a.transaksi_tgl) = ', date('Y'));
		if (isset($data['tahun'])) $this->db->where("date_part('year', a.transaksi_tgl) = " . $data['tahun']);
		$this->db->group_by("b.transaksi_detail_status");
		$this->db->order_by('b.transaksi_detail_status', 'asc');
		$sql = $this->db->get();

		return $sql->result_array();
	}

	public function getSumParameter($data = null)
	{
		$this->db->select("SUM(b.transaksi_detail_parameter) AS total");
		$this->db->from('sample.sample_transaksi a');
		$this->db->join('sample.sample_transaksi_detail b', 'a.id_transaksi_detail = b.transaksi_detail_id', 'left');
		if (isset($data['tahun'])) $this->db->where("date_part('year', a.transaksi_tgl) = " . $data['tahun']);
		// $this->db->where("is_proses is null");

		$sql = $this->db->get();

		return $sql->row_array();
	}

	public function getOrderCustomer($data = null)
	{
		// $this->db->select("(SUM(c.identitas_harga*b.transaksi_detail_jumlah)) AS total, d.peminta_jasa_nama");
		$this->db->select("(c.identitas_harga * b.transaksi_detail_jumlah) as total , d.peminta_jasa_nama");
		$this->db->from('sample.sample_transaksi a');
		$this->db->join('sample.sample_transaksi_detail b', 'a.id_transaksi_detail = b.transaksi_detail_id', 'left');
		$this->db->join('sample.sample_jenis e', 'b.jenis_id = e.jenis_id', 'left');
		$this->db->join('sample.sample_identitas c', 'b.identitas_id = c.identitas_id AND c.jenis_id = e.jenis_id', 'left');
		$this->db->join('sample.sample_peminta_jasa d', 'b.peminta_jasa_id = d.peminta_jasa_id', 'left');
		if (isset($data['tahun'])) $this->db->where("date_part('year', a.transaksi_tgl) = " . $data['tahun']);
		$this->db->where('identitas_harga IS NOT NULL');
		$this->db->group_by("peminta_jasa_nama,identitas_harga,transaksi_detail_jumlah");
		$this->db->order_by('peminta_jasa_nama', 'asc');
		$sql = $this->db->get();

		return $sql->result_array();
	}

	public function getPendapatanBulan($data = null)
	{
		$this->db->select("(SUM(c.identitas_harga*b.transaksi_detail_jumlah)) AS total, to_char(a.transaksi_tgl, 'Month') as bulan, EXTRACT(MONTH FROM TO_DATE(to_char(a.transaksi_tgl, 'Month'), 'Month')) AS bln");
		$this->db->from('sample.sample_transaksi a');
		$this->db->join('sample.sample_transaksi_detail b', 'a.id_transaksi_detail = b.transaksi_detail_id', 'left');
		$this->db->join('sample.sample_jenis e', 'b.jenis_id = e.jenis_id', 'left');
		$this->db->join('sample.sample_identitas c', 'b.identitas_id = c.identitas_id AND c.jenis_id = e.jenis_id', 'left');
		$this->db->join('sample.sample_peminta_jasa d', 'b.peminta_jasa_id = d.peminta_jasa_id', 'left');
		$this->db->where("to_char(a.transaksi_tgl, 'Month') IS NOT NULL");
		if (isset($data['tahun'])) $this->db->where("date_part('year', a.transaksi_tgl) = " . $data['tahun']);
		$this->db->where('identitas_harga IS NOT NULL');
		$this->db->where('b.peminta_jasa_id IS NOT NULL');
		$this->db->group_by("to_char(a.transaksi_tgl, 'Month')");
		$this->db->order_by('bln', 'asc');
		$sql = $this->db->get();

		return $sql->result_array();
	}
}
