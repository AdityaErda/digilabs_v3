<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_stok extends CI_Model {
	public function getItem($data = null) {
		$this->db->select("c.item_nama, COUNT(*) AS total");
		$this->db->from('material.material_transaksi_detail a');
		$this->db->join('material.material_transaksi b', 'a.transaksi_id = b.transaksi_id', 'left');
		$this->db->join('material.material_item c', 'a.item_id = c.item_id', 'left');
		$this->db->where('c.item_nama IS NOT NULL');
		if ($data['tahun']) $this->db->where("date_part('year', b.transaksi_waktu) = ".$data['tahun']);
		$this->db->group_by('item_nama');
		$this->db->order_by('total', 'desc');
		$this->db->limit(10);
		$sql = $this->db->get();

		return $sql->result_array();
	}

	public function getTransaksiNama($data = null) {
		$this->db->select("a.id_gudang_tujuan, b.seksi_nama");
		$this->db->from('material.material_transaksi a');
		$this->db->join('global.global_seksi b ', 'a.id_gudang_tujuan = b.seksi_id', 'left');
		$this->db->where('a.transaksi_tipe', 'o');
		$this->db->where('b.seksi_nama IS NOT NULL');
		if ($data['tahun']) $this->db->where("date_part('year', a.transaksi_waktu) = ".$data['tahun']);
		$this->db->group_by("b.seksi_nama");
		$this->db->group_by("a.id_gudang_tujuan");
		$this->db->order_by('b.seksi_nama', 'asc');
		$sql = $this->db->get();

		return $sql->result_array();
	}

	public function getTransaksiTotal($data = null) {
		$this->db->select("COUNT(*) AS total");
		$this->db->from('material.material_transaksi a');
		$this->db->where('a.id_gudang_tujuan', $data['id_gudang_tujuan']);
		$this->db->where('EXTRACT(MONTH FROM a.transaksi_waktu) = ', $data['bulan']);
		if ($data['tahun']) $this->db->where("date_part('year', a.transaksi_waktu) = ".$data['tahun']);
		$sql = $this->db->get();

		return $sql->row_array();
	}

	public function getPerbaikanNama($data = null) {
		$this->db->select("c.peminta_jasa_id, b.peminta_jasa_nama");
		$this->db->from('material.material_aset_perbaikan a');
		$this->db->join('material.material_aset_detail c', 'a.aset_detail_id = c.aset_detail_id', 'left');
		$this->db->join('sample.sample_peminta_jasa b ', 'c.peminta_jasa_id = b.peminta_jasa_id', 'left');
		$this->db->where('b.peminta_jasa_nama IS NOT NULL');
		if ($data['tahun']) $this->db->where("date_part('year', a.aset_perbaikan_tgl_penyerahan) = ".$data['tahun']);
		$this->db->group_by("b.peminta_jasa_nama");
		$this->db->group_by("c.peminta_jasa_id");
		$this->db->order_by('b.peminta_jasa_nama', 'asc');
		$sql = $this->db->get();

		return $sql->result_array();
	}

	public function getPerbaikanTotal($data = null) {
		$this->db->select("COUNT(*) AS total");
		$this->db->from('material.material_aset_perbaikan a');
		$this->db->join('material.material_aset_detail c', 'a.aset_detail_id = c.aset_detail_id', 'left');
		$this->db->where('c.peminta_jasa_id', $data['peminta_jasa_id']);
		$this->db->where('EXTRACT(MONTH FROM a.aset_perbaikan_tgl_penyerahan) = ', $data['bulan']);
		if ($data['tahun']) $this->db->where("date_part('year', a.aset_perbaikan_tgl_penyerahan) = ".$data['tahun']);
		$sql = $this->db->get();

		return $sql->row_array();
	}

	public function getPenyerapanNama($data = null) {
		$this->db->select("a.id_gudang_tujuan, b.seksi_nama");
		$this->db->from('material.material_transaksi a');
		$this->db->join('global.global_seksi b ', 'a.id_gudang_tujuan = b.seksi_id', 'left');
		$this->db->where('a.transaksi_tipe', 'o');
		$this->db->where('b.seksi_nama IS NOT NULL');
		if ($data['tahun']) $this->db->where("date_part('year', a.transaksi_waktu) = ".$data['tahun']);
		$this->db->group_by("b.seksi_nama");
		$this->db->group_by("a.id_gudang_tujuan");
		$this->db->order_by('b.seksi_nama', 'asc');
		$sql = $this->db->get();

		return $sql->result_array();
	}

	public function getPenyerapanTotal($data = null) {
		$this->db->select("SUM(b.transaksi_detail_total) AS total");
		$this->db->from('material.material_transaksi a');
		$this->db->join('material.material_transaksi_detail b', 'a.transaksi_id = b.transaksi_id', 'left');
		$this->db->where('a.transaksi_tipe', 'o');
		$this->db->where('a.id_gudang_tujuan', $data['id_gudang_tujuan']);
		$this->db->where('EXTRACT(MONTH FROM a.transaksi_waktu) = ', $data['bulan']);
		if ($data['tahun']) $this->db->where("date_part('year', a.transaksi_waktu) = ".$data['tahun']);
		$sql = $this->db->get();

		return $sql->row_array();
	}

	public function getRequest($data=null){
		$this->db->select("a.transaksi_id,to_char(a.transaksi_waktu ,'DD-MM-YYYY') as transaksi_waktu,a.transaksi_status,transaksi_status,d.seksi_id,d.seksi_nama,b.user_id,b.user_nama_lengkap,
		case
		when transaksi_status = 'n' then 'Belum Approved'
		when transaksi_status = 'y' then 'Approved'
		end as transaksi_statusnya,transaksi_status,transaksi_jam");
		$this->db->from('material.material_transaksi a');
		$this->db->join('global.global_seksi d','d.seksi_id=a.id_gudang_tujuan','left');
		$this->db->join('global.global_user b','b.user_id = a.user_id_peminta','left');
		
		if (isset($data['transaksi_id'])) $this->db->where('a.transaksi_id', $data['transaksi_id']);
		if (isset($data['tanggal_awal'])) $this->db->where('date(transaksi_waktu) >= ', $data['tanggal_awal']); 
		if (isset($data['tanggal_akhir'])) $this->db->where('date(transaksi_waktu) <= ', $data['tanggal_akhir']);
		if ($data['tahun']) $this->db->where("date_part('year', a.transaksi_waktu) = ".$data['tahun']); 
		$this->db->order_by('a.transaksi_waktu desc,a.transaksi_status asc,a.transaksi_jam desc');
		$sql = $this->db->get();
		return ($data['transaksi_id']) ? $sql->row_array() : $sql->result_array();
	}

	public function getMaterial($data=null){
		$this->db->select("a.transaksi_id,to_char(a.transaksi_waktu ,'DD-MM-YYYY') as transaksi_waktu,a.transaksi_status,transaksi_status,d.seksi_id,d.seksi_nama,b.user_id,b.user_nama_lengkap,
		case
		when transaksi_status = 'n' then 'Belum Approved'
		when transaksi_status = 'y' then 'Approved'
		end as transaksi_statusnya,transaksi_status,transaksi_jam");
		$this->db->from('material.material_transaksi a');
		$this->db->join('global.global_seksi d','d.seksi_id=a.id_gudang_tujuan','left');
		$this->db->join('global.global_user b','b.user_id = a.user_id_peminta','left');
		$this->db->where('transaksi_tipe', 'o');
		$this->db->where('seksi_nama IS NOT NULL');
		if (isset($data['transaksi_id'])) $this->db->where('a.transaksi_id', $data['transaksi_id']);
		if (isset($data['tanggal_awal'])) $this->db->where('date(transaksi_waktu) >= ', $data['tanggal_awal']); 
		if (isset($data['tanggal_akhir'])) $this->db->where('date(transaksi_waktu) <= ', $data['tanggal_akhir']);
		if ($data['tahun']) $this->db->where("date_part('year', a.transaksi_waktu) = ".$data['tahun']); 
		$this->db->order_by('a.transaksi_waktu desc,a.transaksi_status asc,a.transaksi_jam desc');
		$sql = $this->db->get();
		return ($data['transaksi_id']) ? $sql->row_array() : $sql->result_array();
	}
}