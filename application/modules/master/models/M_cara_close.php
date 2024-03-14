<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_cara_close extends CI_Model
{
  /* GET */
  public function getCaraClose($data = null)
  {
    if (isset($data['cara_close_nama'])) $this->db->where("upper(cara_close_nama) LIKE '%" . strtoupper($data['cara_close_nama']) . "%'");
    if (isset($data['cara_close_id'])) $this->db->where('cara_close_id', $data['cara_close_id']);
    if (isset($data['multiple'])) $this->db->where('multiple', $data['multiple']);
    if (isset($data['tipe'])) $this->db->or_where('tipe', $data['tipe']);

    $this->db->select('*');
    $this->db->from('sample.sample_cara_close');

    $sql = $this->db->get();

    return (isset($data['cara_close_id'])) ? $sql->row_array() : $sql->result_array();
  }
  /* GET */

  /* INSERT */
  public function insertCaraClose($data)
  {
    $this->db->insert('sample.sample_cara_close', $data);
    return $this->db->affected_rows();
  }
  /* INSERT */

  /* UPDATE */
  public function updateCaraClose($data, $id)
  {
    $this->db->set($data);
    $this->db->where('cara_close_id', $id);
    $this->db->update('sample.sample_cara_close');

    return $this->db->affected_rows();
  }
  /* UPDATE */

  /* DELETE */
  public function deleteCaraClose($id)
  {
    $this->db->where('cara_close_id', $id);
    $this->db->delete('sample.sample_cara_close');
    return $this->db->affected_rows();
  }
  /* DELETE */

  /* RESET */
  public function resetCaraClose($id)
  {

    $this->db->empty_table('sample.sample_cara_close');
    return $this->db->affected_rows();
  }
  /* RESET */
}
