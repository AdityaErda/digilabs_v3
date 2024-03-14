<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_audit_kategori extends CI_Model
{
  /* GET */
  public function getKategoriAudit($data = null)
  {
    $this->db->select('*');
    $this->db->from('global.global_audit_kategori');
    if (isset($data['audit_kategori_nama'])) $this->db->where("upper(audit_kategori_nama) LIKE '%" . strtoupper($data['audit_kategori_nama']) . "%'");
    if (isset($data['audit_kategori_id'])) $this->db->where('audit_kategori_id', $data['audit_kategori_id']);
    $sql = $this->db->get();

    return (isset($data['audit_kategori_id'])) ? $sql->row_array() : $sql->result_array();
  }
  /* GET */

  /* INSERT */
  public function insertKategoriAudit($data)
  {
    $this->db->insert('global.global_audit_kategori', $data);
    return $this->db->affected_rows();
  }
  /* INSERT */

  /* UPDATE */
  public function updateKategoriAudit($data, $id)
  {
    $this->db->set($data);
    $this->db->where('audit_kategori_id', $id);
    $this->db->update('global.global_audit_kategori');

    return $this->db->affected_rows();
  }
  /* UPDATE */

 /* DELETE */
  public function deleteKategoriAudit($id)
  {
    $this->db->where('audit_kategori_id', $id);
    $this->db->delete('global.global_audit_kategori');
    return $this->db->affected_rows();
  }
 /* DELETE */

 /* RESET */
  public function resetKategoriAudit($id)
  {
    
    $this->db->empty_table('global.global_audit_kategori');
    return $this->db->affected_rows();
  }
  /* RESET */

}


