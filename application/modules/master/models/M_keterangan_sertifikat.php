<?php
  defined('BASEPATH') or exit('No direct script access allowed');

class M_keterangan_sertifikat extends CI_Model{
  
  public function getKeteranganSertifikat($data = null) {
    $this->db->select('*');
    $this->db->from('sample.sample_keterangan_sertifikat');

    if (isset($data['keterangan_sertifikat_id'])) $this->db->where('keterangan_sertifikat_id', $data['keterangan_sertifikat_id']);
    if (isset($data['params_search'])) $this->db->like('keterangan_sertifikat_isi', $data['params_search'], 'ESCAPE');

    $this->db->order_by('keterangan_sertifikat_isi', 'ASC');
    $sql = $this->db->get();

    return (isset($data['keterangan_sertifikat_id'])) ? $sql->row_array() : $sql->result_array();
  }

  public function insertKeteranganSertifikat($data) {
    $this->db->insert('sample.sample_keterangan_sertifikat', $data);

    return $this->db->affected_rows();
  }

  public function updateKeteranganSertifikat($data, $id) {
    $this->db->set($data);
    $this->db->where('keterangan_sertifikat_id', $id);
    $this->db->update('sample.sample_keterangan_sertifikat');

    return $this->db->affected_rows();
  }

  public function deleteKeteranganSertifikat($id) {
    $this->db->where('keterangan_sertifikat_id', $id);
    $this->db->delete('sample.sample_keterangan_sertifikat');

    return $this->db->affected_rows();
  }
}