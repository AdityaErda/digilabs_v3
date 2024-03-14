<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_approve extends CI_Model
{

	// DATA APPROVE
	public function getApprove($data = null, $where = null)
	{
		$this->db->select("a.transaksi_id, a.transaksi_tipe, a.transaksi_status,a.transaksi_nomor, b.*, c.jenis_nama, d.peminta_jasa_nama, e.sample_pekerjaan_nama, f.identitas_nama, to_char(transaksi_detail_tgl_pengajuan, 'DD-MM-YYYY HH24:MI:SS') AS transaksi_detail_tgl_pengajuan_baru, to_char(transaksi_detail_tgl_memo, 'DD-MM-YYYY') AS transaksi_detail_tgl_memo_baru, to_char(transaksi_detail_tgl_estimasi, 'DD-MM-YYYY HH24:MI:SS') AS transaksi_detail_tgl_estimasi_baru");
		$this->db->from('sample.sample_transaksi a');
		$this->db->join('sample.sample_transaksi_detail b', 'a.transaksi_id = b.transaksi_id AND a.id_transaksi_detail = b.transaksi_detail_id', 'left');
		$this->db->join('sample.sample_jenis c', 'c.jenis_id = b.jenis_id', 'left');
		$this->db->join('sample.sample_peminta_jasa d', 'd.peminta_jasa_id = b.peminta_jasa_id', 'left');
		$this->db->join('sample.sample_pekerjaan e', 'e.sample_pekerjaan_id = b.jenis_pekerjaan_id', 'left');
		$this->db->join('sample.sample_identitas f', 'f.identitas_id = b.identitas_id', 'left');
		// if (isset($data['transaksi_tipe'])) $this->db->where('a.transaksi_tipe', $data['transaksi_tipe']);

		if (isset($data['transaksi_id'])) $this->db->where('a.transaksi_id', $data['transaksi_id']);
		if (isset($where)) $this->db->where($where);
		if (isset($data['id_transaksi'])) $this->db->where('a.transaksi_id', $data['id_transaksi']);
		// if (isset($data['tgl_awal'])) $this->db->where('DATE(a.transaksi_tgl) >= ', $data['tgl_awal']);
		// if (isset($data['tgl_akhir'])) $this->db->where('DATE(a.transaksi_tgl) <= ', $data['tgl_akhir']);
		if (isset($data['tanggal_cari_awal'])) $this->db->where('DATE(a.transaksi_tgl) >=', $data['tanggal_cari_awal']);
		if (isset($data['tanggal_cari_akhir'])) $this->db->where('DATE(a.transaksi_tgl) <=', $data['tanggal_cari_akhir']);
		$this->db->where_not_in('a.transaksi_tipe', 'R');
		if (isset($data['transaksi_tipe']) && $data['transaksi_tipe'] != '-' && !isset($data['status_cari'])) {
			$this->db->where("(a.transaksi_tipe = '$data[transaksi_tipe]') ");
			$this->db->where_in('a.transaksi_status ', $data['transaksi_status_approve']);
		} elseif (isset($data['transaksi_tipe']) && $data['transaksi_tipe'] != '-' && (isset($data['status_cari']) && $data['status_cari'] != '-')) {
			$this->db->where("(a.transaksi_tipe = '$data[transaksi_tipe]') ");
		} elseif (isset($data['transaksi_tipe']) && $data['transaksi_tipe'] != '-' && (isset($data['status_cari']) && $data['status_cari'] == '-')) {
			$this->db->where("(a.transaksi_tipe = '$data[transaksi_tipe]')  ");
			// $this->db->where('a.transaksi_tipe', $data['transaksi_tipe']);
		};

		if (isset($data['status_cari']) && $data['status_cari'] != '-') {
			$this->db->where('a.transaksi_status', $data['status_cari']);
			// }else{
			// $this->db->or_where('a.transaksi_status', $data['transaksi_status_approve']);
		}
		if (isset($data['transaksi_status'])) $this->db->where('a.transaksi_status', $data['transaksi_status']);
		$this->db->where("transaksi_status != '2'");
		$this->db->where("transaksi_status != '3'");
		$this->db->where("transaksi_status != '4'");
		$this->db->where("transaksi_status != '5'");
		$this->db->where("transaksi_status != '6'");
		$this->db->where("transaksi_status != '7'");
		$this->db->order_by('a.transaksi_tgl', 'desc');
		$this->db->order_by('a.when_create', 'desc');
		$sql = $this->db->get();

		return (isset($data['transaksi_id'])) ? $sql->row_array() : $sql->result_array();
	}
	// DATA APPROVE
	/* INSERT */
	public function insertApprove($data)
	{
		$this->db->query("INSERT INTO sample.sample_transaksi_detail SELECT '" . $data['transaksi_detail_id'] . "', '" . $data['id_seksi'] . "', identitas_id, jenis_id, peminta_jasa_id, a.transaksi_id, transaksi_detail_pic_pengirim, transaksi_detail_ext_pengirim, transaksi_detail_jumlah, '" . $data['transaksi_detail_parameter'] . "', transaksi_detail_tgl_pengajuan, '" . $data['transaksi_detail_tgl_memo'] . "', '" . $data['transaksi_detail_no_memo'] . "', transaksi_detail_foto, NULL, NULL, NULL, '" . $data['is_urgent'] . "', jenis_pekerjaan_id, '" . $data['when_create'] . "', '" . $data['who_create'] . "', '" . $data['transaksi_detail_note'] . "', '" . $data['transaksi_detail_status'] . "', '" . $data['is_khusus'] . "' FROM sample.sample_transaksi_detail a LEFT JOIN sample.sample_transaksi b ON a.transaksi_detail_id = b.id_transaksi_detail WHERE b.transaksi_id = '" . $data['transaksi_id'] . "'");

		return $this->db->affected_rows();
	}
	/* INSERT */

	/* INSERT DISPOSISI */
	public function insertDisposisi($data)
	{
		$this->db->insert('sample.sample_seksi_disposisi', $data);

		return $this->db->affected_rows();
	}
	/* INSERT DISPOSISI */

	/* GET SEKSI */
	public function getSeksi($data = null)
	{
		$this->db->select('*');
		$this->db->from('global.global_seksi a');
		$this->db->where('is_disposisi', 'y');
		if (isset($data['seksi_nama'])) $this->db->where("upper(seksi_nama) LIKE '%" . strtoupper($data['seksi_nama']) . "%'");
		if (isset($data['seksi_id'])) $this->db->where('seksi_id', $data['seksi_id']);
		if (isset($data['id_seksi_saat_ini'])) $this->db->where('seksi_id!=', $data['id_seksi_saat_ini']);

		$sql = $this->db->get();

		return (isset($data['seksi_id'])) ? $sql->row_array() : $sql->result_array();
	}
	/* GET SEKSI */
}
