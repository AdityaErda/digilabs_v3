<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_report extends CI_Model{
  /* GET */
  public function getJenisSample($data = null){
    $this->db->select('*');
    $this->db->from('sample.sample_jenis');

    if (isset($data['jenis_nama'])) $this->db->where("upper(jenis_nama) LIKE '%" . strtoupper($data['jenis_nama']) . "%'");
    if (isset($data['jenis_id'])) $this->db->where('jenis_id', $data['jenis_id']);
    $sql = $this->db->get();

    return (isset($data['jenis_id'])) ? $sql->row_array() : $sql->result_array();
  }

  public function getParameter($data = null, $where = null){
    $this->db->select("b.jenis_id, c.jenis_nama, e.id_rumus, f.rumus_nama");

    $this->db->from('sample.sample_transaksi a');
    $this->db->join('sample.sample_transaksi_detail b', 'a.transaksi_id = b.transaksi_id', 'left');
    $this->db->join('sample.sample_jenis c', 'c.jenis_id = b.jenis_id', 'left');
    $this->db->join('sample.sample_logsheet d', 'd.id_transaksi = a.transaksi_id AND d.id_transaksi_detail = b.transaksi_detail_id', 'left');
    $this->db->join('sample.sample_logsheet_detail e', 'e.logsheet_id = d.logsheet_id', 'left');
    $this->db->join('sample.sample_perhitungan_sample f', 'f.rumus_id = e.id_rumus', 'left');
    $this->db->join('sample.sample_perhitungan_multiple g', 'g.jenis_id = b.jenis_id', 'left');
    $this->db->join('sample.sample_detail_multiple h', 'h.id_multiple_rumus = g.multiple_rumus_id', 'left');


    if (isset($data['transaksi_status'])) $this->db->where("CAST(b.transaksi_detail_status as INT) >= '" . ($data['transaksi_status']) . "' ");
    if (isset($data['transaksi_id'])) $this->db->where('b.transaksi_id', $data['transaksi_id']);
    if (isset($data['transaksi_detail_id'])) $this->db->where('b.transaksi_detail_id', $data['transaksi_detail_id']);
    if (isset($data['jenis_id'])) $this->db->where('b.jenis_id', $data['jenis_id']);

    if (isset($data['tanggal_cari_awal'])) $this->db->where('DATE(a.transaksi_tgl) >=', $data['tanggal_cari_awal']);
    if (isset($data['tanggal_cari_akhir'])) $this->db->where('DATE(a.transaksi_tgl) <=', $data['tanggal_cari_akhir']);

    $this->db->where("(is_proses!='y' OR is_proses is NULL)");
    $this->db->where('f.rumus_nama IS NOT NULL');
    // $this->db->where('h.parameter_rumus IS NOT NULL');

    $this->db->group_by('b.jenis_id');
    $this->db->group_by('c.jenis_nama');
    $this->db->group_by('e.id_rumus');
    $this->db->group_by('f.rumus_nama');
    // $this->db->group_by('h.parameter_rumus');
    $sql = $this->db->get();

    return $sql->result_array();
  }

  public function getHistoryLogSheet($data = null){
    $this->db->select("a.transaksi_id, b.transaksi_detail_id, b.jenis_id, b.transaksi_detail_status, b.transaksi_detail_nomor_sample, 
                          c.logsheet_id, c.logsheet_jenis, c.logsheet_asal_sample, c.logsheet_pengolah_sample, c.logsheet_peminta_jasa, 
                          d.logsheet_detail_id, d.id_rumus, d.rumus_satuan, to_char(d.when_create, 'DD-MM-YYYY') AS when_create_baru, d.rumus_hasil, h.rumus_nama, g.jenis_nama");
    $this->db->from('sample.sample_transaksi a');
    $this->db->join('sample.sample_transaksi_detail b', 'a.transaksi_id = b.transaksi_id', 'left');
    $this->db->join('sample.sample_logsheet c', 'c.id_transaksi = a.transaksi_id AND c.id_transaksi_detail = b.transaksi_detail_id', 'left');
    $this->db->join('sample.sample_logsheet_detail d', 'c.logsheet_id = d.logsheet_id', 'left');
    $this->db->join('sample.sample_logsheet_detail_detail e', 'd.logsheet_detail_id = e.id_logsheet_detail', 'left');
    $this->db->join('sample.sample_perhitungan_sample_detail f', 'd.id_rumus = f.id_rumus', 'left');
    $this->db->join('sample.sample_jenis g', 'b.jenis_id = g.jenis_id', 'left');
    $this->db->join('sample.sample_perhitungan_sample h', 'd.id_rumus = h.rumus_id', 'left');

    if (isset($data['jenis_id'])) $this->db->where('b.jenis_id', $data['jenis_id']);
    if (isset($data['id_rumus'])) $this->db->where('d.id_rumus', $data['id_rumus']);
    if (isset($data['tanggal_cari_awal'])) $this->db->where('DATE(a.transaksi_tgl) >=', $data['tanggal_cari_awal']);
    if (isset($data['tanggal_cari_akhir'])) $this->db->where('DATE(a.transaksi_tgl) <=', $data['tanggal_cari_akhir']);

    $this->db->group_by('a.transaksi_id');
    $this->db->group_by('b.transaksi_detail_id');
    $this->db->group_by('b.jenis_id');
    $this->db->group_by('b.transaksi_detail_status');
    $this->db->group_by('b.transaksi_detail_nomor_sample');
    $this->db->group_by('c.logsheet_id');
    $this->db->group_by('c.logsheet_jenis');
    $this->db->group_by('c.logsheet_asal_sample');
    $this->db->group_by('c.logsheet_pengolah_sample');
    $this->db->group_by('c.logsheet_peminta_jasa');
    $this->db->group_by('d.logsheet_detail_id');
    $this->db->group_by('d.id_rumus');
    $this->db->group_by('d.rumus_satuan');
    $this->db->group_by('d.rumus_hasil');
    $this->db->group_by('d.when_create');
    $this->db->group_by('g.jenis_nama');
    $this->db->group_by('h.rumus_nama');
    $sql = $this->db->get();

    return $sql->result_array();
  }
  /* GET */
}
