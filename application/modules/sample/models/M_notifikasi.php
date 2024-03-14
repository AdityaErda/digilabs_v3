<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_notifikasi extends CI_Model
{
	/* GET */
	public function getNotifikasi($data = null)
	{
		$this->db->select("a.transaksi_id, a.transaksi_tipe, a.transaksi_status, a.transaksi_nomor, b.*, c.jenis_nama, d.peminta_jasa_nama, e.sample_pekerjaan_nama, f.identitas_nama, to_char(transaksi_detail_tgl_pengajuan, 'DD-MM-YYYY HH24:MI:SS') AS transaksi_detail_tgl_pengajuan_baru, to_char(transaksi_detail_tgl_memo, 'DD-MM-YYYY HH24:MI:SS') AS transaksi_detail_tgl_memo_baru, to_char(transaksi_detail_tgl_estimasi, 'DD-MM-YYYY HH24:MI:SS') AS transaksi_detail_tgl_estimasi_baru, g.seksi_nama, date(transaksi_detail_tgl_estimasi)-date(transaksi_detail_tgl_pengajuan) AS estimasi");
		$this->db->from('sample.sample_transaksi a');
		$this->db->join('sample.sample_transaksi_detail b', 'a.id_transaksi_detail = b.transaksi_detail_id', 'left');
		$this->db->join('sample.sample_jenis c', 'c.jenis_id = b.jenis_id', 'left');
		$this->db->join('sample.sample_peminta_jasa d', 'd.peminta_jasa_id = b.peminta_jasa_id', 'left');
		$this->db->join('sample.sample_pekerjaan e', 'e.sample_pekerjaan_id = b.jenis_pekerjaan_id', 'left');
		$this->db->join('sample.sample_identitas f', 'f.identitas_id = b.identitas_id', 'left');
		$this->db->join('global.global_seksi g', 'g.seksi_id = b.id_seksi', 'left');
		if (isset($data['transaksi_tipe'])) $this->db->where('a.transaksi_tipe', $data['transaksi_tipe']);
		if (isset($data['transaksi_id'])) $this->db->where('a.transaksi_id', $data['transaksi_id']);
		// if (isset($data['transaksi_status'])) $this->db->where_not_in('a.transaksi_status', $data['transaksi_status']);
		$this->db->where('transaksi_status != ', '0');
		$this->db->where('transaksi_status != ', '2');
		$this->db->where('transaksi_status != ', '6');
		$this->db->where('transaksi_status != ', '7');
		$this->db->where('transaksi_status != ', '8');
		$this->db->where('is_khusus', 'y');
		$this->db->order_by('b.is_urgent', 'desc');
		$this->db->order_by('estimasi', 'desc');
		$this->db->order_by('a.when_create', 'desc');
		$sql = $this->db->get();

		return (isset($data['transaksi_id'])) ? $sql->row_array() : $sql->result_array();
	}

	public function getNotifikasiBarcodeAwal($data = null)
	{
		$this->db->select("a.transaksi_id, a.transaksi_tipe, a.transaksi_status, a.transaksi_nomor, b.*, c.jenis_nama, d.peminta_jasa_nama,a.id_transaksi_rutin,
						e.sample_pekerjaan_nama, f.identitas_nama, to_char(transaksi_detail_tgl_pengajuan, 'DD-MM-YYYY HH24:MI:SS') AS transaksi_detail_tgl_pengajuan_baru,
						to_char(transaksi_detail_tgl_memo, 'DD-MM-YYYY HH24:MI:SS') AS transaksi_detail_tgl_memo_baru, to_char(transaksi_detail_tgl_estimasi, 'DD-MM-YYYY HH24:MI:SS') AS transaksi_detail_tgl_estimasi_baru,
						g.seksi_nama, date(transaksi_detail_tgl_estimasi)-date(transaksi_detail_tgl_pengajuan) AS estimasi, h.logsheet_id, h.id_template_logsheet");
		$this->db->from('sample.sample_transaksi a');
		$this->db->join('sample.sample_transaksi_detail b', 'a.transaksi_id = b.transaksi_id', 'left');
		$this->db->join('sample.sample_jenis c', 'c.jenis_id = b.jenis_id', 'left');
		$this->db->join('sample.sample_peminta_jasa d', 'd.peminta_jasa_id = b.peminta_jasa_id', 'left');
		$this->db->join('sample.sample_pekerjaan e', 'e.sample_pekerjaan_id = b.jenis_pekerjaan_id', 'left');
		$this->db->join('sample.sample_identitas f', 'f.identitas_id = b.identitas_id', 'left');
		$this->db->join('global.global_seksi g', 'g.seksi_id = b.id_seksi', 'left');
		$this->db->join('sample.sample_logsheet h', 'h.id_transaksi = a.transaksi_id AND h.id_transaksi_detail = b.transaksi_detail_id', 'left');

		if (isset($data['transaksi_tipe'])) $this->db->where('a.transaksi_tipe', $data['transaksi_tipe']);
		if (isset($data['transaksi_detail_id'])) $this->db->where('b.transaksi_detail_id', $data['transaksi_detail_id']);
		if (isset($data['transaksi_id'])) $this->db->where('a.transaksi_id', $data['transaksi_id']);
		if (isset($data['jenis_id'])) $this->db->where('c.jenis_id', $data['jenis_id']);
		if (isset($data['transaksi_rutin_id'])) $this->db->where('id_transaksi_rutin', $data['transaksi_rutin_id']);
		if (isset($data['logsheet_id'])) $this->db->where('logsheet_id', $data['logsheet_id']);
		$this->db->where("(is_proses!='y' OR is_proses is NULL)");

		$this->db->order_by('a.when_create', 'desc');
		$this->db->order_by('a.transaksi_nomor', 'asc');
		$this->db->order_by('CAST(transaksi_detail_status as INT)', 'ASC');
		$this->db->order_by('a.transaksi_tgl', 'desc');
		$sql = $this->db->get();

		// return (isset($data['transaksi_id'])) ? $sql->row_array() : $sql->result_array();
		return $sql->row_array();
	}

	public function getNotifikasiBarcode($data = null)
	{
		$this->db->select("a.transaksi_id, a.transaksi_tipe, a.transaksi_status, a.transaksi_nomor, b.*, c.jenis_nama, d.peminta_jasa_nama,
						e.sample_pekerjaan_nama, f.identitas_nama, to_char(transaksi_detail_tgl_pengajuan, 'DD-MM-YYYY HH24:MI:SS') AS transaksi_detail_tgl_pengajuan_baru,
						to_char(transaksi_detail_tgl_memo, 'DD-MM-YYYY HH24:MI:SS') AS transaksi_detail_tgl_memo_baru, to_char(transaksi_detail_tgl_estimasi, 'DD-MM-YYYY HH24:MI:SS') AS transaksi_detail_tgl_estimasi_baru,
						g.seksi_nama, date(transaksi_detail_tgl_estimasi)-date(transaksi_detail_tgl_pengajuan) AS estimasi");
		$this->db->from('sample.sample_transaksi a');
		$this->db->join('sample.sample_transaksi_detail b', 'a.transaksi_id = b.transaksi_id', 'left');
		$this->db->join('sample.sample_jenis c', 'c.jenis_id = b.jenis_id', 'left');
		$this->db->join('sample.sample_peminta_jasa d', 'd.peminta_jasa_id = b.peminta_jasa_id', 'left');
		$this->db->join('sample.sample_pekerjaan e', 'e.sample_pekerjaan_id = b.jenis_pekerjaan_id', 'left');
		$this->db->join('sample.sample_identitas f', 'f.identitas_id = b.identitas_id', 'left');
		$this->db->join('global.global_seksi g', 'g.seksi_id = b.id_seksi', 'left');

		if (isset($data['transaksi_tipe'])) $this->db->where('a.transaksi_tipe', $data['transaksi_tipe']);
		if (isset($data['transaksi_id'])) $this->db->where('a.transaksi_id', $data['transaksi_id']);
		if (isset($data['jenis_id'])) $this->db->where('c.jenis_id', $data['jenis_id']);

		$this->db->where("(is_proses!='y' OR is_proses is NULL)");
		$this->db->order_by('a.when_create', 'desc');
		$this->db->order_by('a.transaksi_nomor', 'asc');
		$this->db->order_by('CAST(transaksi_detail_status as INT)', 'ASC');
		$this->db->order_by('a.transaksi_tgl', 'desc');
		$sql = $this->db->get();

		return (isset($data['transaksi_id'])) ? $sql->row_array() : $sql->result_array();
	}
	/* GET */

	/* INSERT */
	public function insertNotifikasi($data)
	{
		$this->db->query("INSERT INTO sample.sample_transaksi_detail SELECT '" . $data['transaksi_detail_id'] . "', id_seksi, identitas_id, jenis_id, peminta_jasa_id, a.transaksi_id, transaksi_detail_pic_pengirim, transaksi_detail_ext_pengirim, transaksi_detail_jumlah, transaksi_detail_parameter, transaksi_detail_tgl_pengajuan, transaksi_detail_tgl_memo, transaksi_detail_no_memo, transaksi_detail_foto, NULL, NULL, NULL, is_urgent, jenis_pekerjaan_id, '" . $data['when_create'] . "', '" . $data['who_create'] . "', '" . $data['transaksi_detail_note'] . "', '" . $data['transaksi_detail_status'] . "', 'n', NULL FROM sample.sample_transaksi_detail a LEFT JOIN sample.sample_transaksi b ON a.transaksi_detail_id = b.id_transaksi_detail WHERE b.transaksi_id = '" . $data['transaksi_id'] . "'");

		return $this->db->affected_rows();
	}
	/* INSERT */

	/* INSERT PETUGAS */
	public function insertNotifikasiPetugas($data)
	{
		$this->db->insert('sample.sample_petugas', $data);

		return $this->db->affected_rows();
	}
	/* INSERT PETUGAS */

	/* GET */
	public function getUser($data = null)
	{
		$this->db->select('a.*, b.role_id, b.role_nama, c.seksi_id, c.seksi_nama');
		$this->db->from('global.global_user a');
		$this->db->join('global.global_role b', 'a.role_id = b.role_id', 'left');
		$this->db->join('global.global_seksi c', 'a.id_seksi = c.seksi_id', 'left');
		$this->db->where("(c.seksi_id = 'a9b1f7a5c83e5bbacc7d3632e8d642a1558a3391' OR c.seksi_id = '8a1768c878c3a337463221980a5fc5aea01f588f' OR c.seksi_id = 'd29e2694954dad47a5ba0ef6aff0dc04f5b0fa64' OR c.seksi_id = 'ab3e7d627d36dc339fdce8c2a16947fcb09940c3' OR c.seksi_id = '6553ca3e36fe9c98e97cb66247ab0fc940fde692' OR c.seksi_id = 'cb70f2dc85571e5c29d2e9cf3f33412d3ea16508')");
		if (isset($data['user_nama_lengkap'])) $this->db->where("upper(user_nama_lengkap) LIKE '%" . strtoupper($data['user_nama_lengkap']) . "%'");
		$sql = $this->db->get();

		return $sql->result_array();
	}

	public function getUserBySeksi($data = null)
	{
		$this->db->select('a.*, b.role_id, b.role_nama, c.seksi_id, c.seksi_nama');
		$this->db->from('global.global_user a');
		$this->db->join('global.global_role b', 'a.role_id = b.role_id', 'left');
		$this->db->join('global.global_seksi c', 'a.id_seksi = c.seksi_id', 'left');
		if (isset($data['id_seksi'])) $this->db->where('c.seksi_id', $data['id_seksi']);
		if (isset($data['user_nama_lengkap'])) $this->db->like('UPPER(user_nama_lengkap)', strtoupper($data['user_nama_lengkap']), 'BOTH');
		$this->db->where('is_disposisi', 'y');
		// if (isset($data['user_nama_lengkap'])) $this->db->where("upper(user_nama_lengkap) LIKE '%" . strtoupper($data['user_nama_lengkap']) . "%'");
		$sql = $this->db->get();

		return $sql->result_array();
	}
	/* GET */
}
