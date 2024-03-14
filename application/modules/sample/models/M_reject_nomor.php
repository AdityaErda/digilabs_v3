<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_reject_nomor extends CI_Model
{
	public function getNomor($data = null, $where = null)
	{
		$this->db->select("a.transaksi_id, a.transaksi_tipe, a.transaksi_status, a.transaksi_nomor, b.*, c.jenis_nama, d.peminta_jasa_nama, e.sample_pekerjaan_nama, f.identitas_nama, to_char(transaksi_detail_tgl_pengajuan, 'DD-MM-YYYY HH24:MI:SS') AS transaksi_detail_tgl_pengajuan_baru, to_char(transaksi_detail_tgl_memo, 'DD-MM-YYYY HH24:MI:SS') AS transaksi_detail_tgl_memo_baru, to_char(transaksi_detail_tgl_estimasi, 'DD-MM-YYYY HH24:MI:SS') AS transaksi_detail_tgl_estimasi_baru");
		$this->db->from('sample.sample_transaksi a');
		$this->db->join('sample.sample_transaksi_detail b', 'a.transaksi_id = b.transaksi_id AND a.id_transaksi_detail = b.transaksi_detail_id', 'left');
		$this->db->join('sample.sample_jenis c', 'c.jenis_id = b.jenis_id', 'left');
		$this->db->join('sample.sample_peminta_jasa d', 'd.peminta_jasa_id = b.peminta_jasa_id', 'left');
		$this->db->join('sample.sample_pekerjaan e', 'e.sample_pekerjaan_id = b.jenis_pekerjaan_id', 'left');
		$this->db->join('sample.sample_identitas f', 'f.identitas_id = b.identitas_id', 'left');
		if (isset($where)) $this->db->where($where);
		if (isset($data['tanggal_cari_awal'])) $this->db->where('DATE(transaksi_tgl) >= ', $data['tanggal_cari_awal']);
		if (isset($data['tanggal_cari_akhir'])) $this->db->where('DATE(transaksi_tgl) <= ', $data['tanggal_cari_akhir']);
		$this->db->where('a.who_seksi_create', '-');
		$this->db->where('a.transaksi_status', '0');
		$this->db->order_by('a.transaksi_tgl', 'ASC');
		$this->db->order_by('a.when_create', 'desc');
		$sql = $this->db->get();

		return $sql->result_array();
	}

	/* UPDATE */
	public function updateNomor($data, $id)
	{
		$this->db->set($data);
		$this->db->where('transaksi_id', $id);
		$this->db->update('sample.sample_transaksi');

		return $this->db->affected_rows();
	}
	/* UPDATE */

	/* UPDATE DETAIL */
	public function updateNomorDetail($data, $id)
	{
		$this->db->set($data);
		$this->db->where('transaksi_id', $id);
		$this->db->update('sample.sample_transaksi_detail');

		return $this->db->affected_rows();
	}
	/* UPDATE DETAIL */
}
