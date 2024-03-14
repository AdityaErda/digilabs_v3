<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_audit_klausul extends CI_Model
{
  /* GET */
  public function getKlausulAudit($data = null)
  {
    $this->db->select('*');
    $this->db->from('global.global_audit_klausul');
    if (isset($data['audit_klausul_nama'])) $this->db->where("upper(audit_klausul_nama) LIKE '%" . strtoupper($data['audit_klausul_nama']) . "%'");
    if (isset($data['audit_klausul_id'])) $this->db->where('audit_klausul_id', $data['audit_klausul_id']);
    $sql = $this->db->get();

    return (isset($data['audit_klausul_id'])) ? $sql->row_array() : $sql->result_array();
  }
  /* GET */

  /* INSERT */
  public function insertKlausulAudit($data)
  {
    $this->db->insert('global.global_audit_klausul', $data);
    return $this->db->affected_rows();
  }
  /* INSERT */

  /* UPDATE */
  public function updateKlausulAudit($data, $id)
  {
    $this->db->set($data);
    $this->db->where('audit_klausul_id', $id);
    $this->db->update('global.global_audit_klausul');

    return $this->db->affected_rows();
  }
  /* UPDATE */

  /* DELETE */
  public function deleteKlausulAudit($id)
  {
    $this->db->where('audit_klausul_id', $id);
    $this->db->delete('global.global_audit_klausul');
    return $this->db->affected_rows();
  }
  /* DELETE */

  /* RESET */
  public function resetKlausulAudit()
  {

    $this->db->empty_table('global.global_audit_klausul');
    return $this->db->affected_rows();
  }
  /* RESET */
}
