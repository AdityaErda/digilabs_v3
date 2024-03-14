<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_document extends CI_Model {
	
	public function getDocument($data = null) {
		$this->db->select("b.jenis_nama, SUM(a.transaksi_revisi) AS revisi, SUM(a.transaksi_terbitan) AS terbitan");
		$this->db->from('document.document_transaksi a');
		$this->db->join('document.document_jenis b', 'a.jenis_id = b.jenis_id', 'left');
		$this->db->group_by('b.jenis_nama');
		$this->db->order_by('revisi', 'desc');
		$this->db->limit(10);
		$sql = $this->db->get();

		return $sql->result_array();
	}

	public function getDocumentJenis($data = null) {
		$this->db->select('COUNT(*) AS total');
		$this->db->from('document.document_transaksi');
		if (isset($data['jenis_id'])) $this->db->where('jenis_id', $data['jenis_id']);
		$sql = $this->db->get();

		return $sql->row_array();
	}

	public function getDocumentSeksi($data = null) {
		$this->db->select('COUNT(*) AS total');
		$this->db->from('document.document_transaksi');
		if (isset($data['seksi_id'])) $this->db->where('seksi_id', $data['seksi_id']);
		$sql = $this->db->get();

		return $sql->row_array();
	}

	public function getDocumentJenisSum($data = null) {
		$this->db->select('COUNT(*) AS total, b.jenis_nama');
		$this->db->from('document.document_transaksi a');
		$this->db->join('document.document_jenis b', 'a.jenis_id = b.jenis_id', 'left');
		$this->db->where('b.jenis_nama IS NOT NULL');
		$this->db->group_by('b.jenis_nama');
		$this->db->order_by('b.jenis_nama', 'asc');
		$this->db->limit(6);
		$sql = $this->db->get();

		return $sql->result_array();
	}

	public function getDocumentSeksiSum($data = null) {
		$this->db->select('COUNT(*) AS total, b.seksi_nama');
		$this->db->from('document.document_transaksi a');
		$this->db->join('global.global_seksi b', 'a.seksi_id = b.seksi_id', 'left');
		$this->db->where('b.is_disposisi', 'y');
		$this->db->group_by('b.seksi_nama');
		$this->db->order_by('b.seksi_nama', 'asc');
		$sql = $this->db->get();

		return $sql->result_array();
	}

	public function getDocumentHasil($data = null) {
		$this->db->select("SUM(a.transaksi_revisi) AS revisi, SUM(a.transaksi_terbitan) AS terbit");
		$this->db->from('document.document_transaksi a');
		$sql = $this->db->get();

		return $sql->row_array();
	}
}