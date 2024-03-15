<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_klasifikasi_sample extends CI_Model{
  /* GET */
  public function getKlasifikasiSample($data = null){
    $this->db->select('*');
    $this->db->from('sample.sample_klasifikasi');
    if (isset($data['klasifikasi_nama'])) $this->db->where("upper(klasifikasi_nama) LIKE '%" . strtoupper($data['klasifikasi_nama']) . "%'");
    if (isset($data['klasifikasi_id'])) $this->db->where('klasifikasi_id', $data['klasifikasi_id']);
    $sql = $this->db->get();

    return (isset($data['klasifikasi_id'])) ? $sql->row_array() : $sql->result_array();
  }
  /* GET */

  /* INSERT */
  public function insertKlasifikasiSample($data){
    $this->db->insert('sample.sample_klasifikasi', $data);
    return $this->db->affected_rows();
  }
  /* INSERT */

  /* UPDATE */
  public function updateKlasifikasiSample($data, $id){
    $this->db->set($data);
    $this->db->where('klasifikasi_id', $id);
    $this->db->update('sample.sample_klasifikasi');

    return $this->db->affected_rows();
  }
  /* UPDATE */

  /* DELETE */
  public function deleteKlasifikasiSample($id){
    $this->db->where('klasifikasi_id', $id);
    $this->db->delete('sample.sample_klasifikasi');
    return $this->db->affected_rows();
  }
  /* DELETE */

  /* RESET */
  public function resetKlasifikasiSample($id){

    $this->db->empty_table('sample.sample_klasifikasi');
    return $this->db->affected_rows();
  }
  /* RESET */
}
