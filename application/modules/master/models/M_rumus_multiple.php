<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_rumus_multiple extends CI_Model
{
  /* GET */
  public function getJenisSample($data = null){
    $this->db->select('*');
    $this->db->from('sample.sample_jenis');

    if (isset($data['jenis_nama'])) $this->db->where("upper(jenis_nama) LIKE '%" . strtoupper($data['jenis_nama']) . "%'");
    if (isset($data['jenis_id'])) $this->db->where('jenis_id', $data['jenis_id']);
    $sql = $this->db->get();

    return (isset($data['jenis_id'])) ? $sql->row_array() : $sql->result_array();
  }

  public function getRumusMultiple($data = null){
    $this->db->select('a.*, b.jenis_id, b.jenis_nama');
    $this->db->from('sample.sample_perhitungan_multiple a');
    $this->db->join('sample.sample_jenis b', 'a.jenis_id = b.jenis_id', 'left');

    if (isset($data['metode'])) $this->db->where("upper(metode) LIKE '%" . strtoupper($data['metode']) . "%'");
    if (isset($data['multiple_rumus_id'])) $this->db->where('multiple_rumus_id', $data['multiple_rumus_id']);
    if (isset($data['jenis_id'])) $this->db->where('b.jenis_id', $data['jenis_id']);
    $sql = $this->db->get();

    return (isset($data['multiple_rumus_id'])) ? $sql->row_array() : $sql->result_array();
  }
  /* GET */

  /* Insert */
  public function insertRumusMultiple($data){
    $this->db->insert('sample.sample_perhitungan_multiple', $data);

    return $this->db->affected_rows();
  }
  /* Insert */

  /* Update */
  public function updateRumusMultiple($data, $id){
    $this->db->set($data);
    $this->db->where('multiple_rumus_id', $id);
    $this->db->update('sample.sample_perhitungan_multiple');

    return $this->db->affected_rows();
  }
  /* Update */

  /* Delete */
  public function deleteRumusMultiple($id){
    $this->db->where('multiple_rumus_id', $id);
    $this->db->delete('sample.sample_perhitungan_multiple');

    return $this->db->affected_rows();
  }
  /* Delete */

  /* Get Parameter & Detail Paramater */
  public function getDetailRumusMultiple($data = null){
    $this->db->select('a.*');
    $this->db->from('sample.sample_detail_multiple a');
    $this->db->join('sample.sample_perhitungan_multiple b', 'a.id_multiple_rumus = b.multiple_rumus_id', 'left');

    if (isset($data['parameter_rumus'])) $this->db->where("upper(parameter_rumus) LIKE '%" . strtoupper($data['parameter_rumus']) . "%'");
    if (isset($data['id_multiple_rumus'])) $this->db->where('id_multiple_rumus', $data['id_multiple_rumus']);
    if (isset($data['detail_multiple_rumus_id'])) $this->db->where('detail_multiple_rumus_id', $data['detail_multiple_rumus_id']);

    // $this->db->order_by('rumus_detail_urut', 'ASC');
    $sql = $this->db->get();

    // return (isset($data['detail_multiple_rumus_id'])) ? $sql->row_array() : $sql->result_array();
    return $sql->result_array();
  }

  public function getListRumus($data = null){
    $this->db->select('*');
    $this->db->from('sample.sample_parameter_rumus');

    if (isset($data['rumus_detail_input'])) $this->db->where("upper(rumus_detail_input) LIKE '%" . strtoupper($data['rumus_detail_input']) . "%'");
    $this->db->where('id_parameter = ', $data['id_parameter']);

    $this->db->order_by('rumus_detail_urut', 'ASC');
    $sql = $this->db->get();

    return $sql->result_array();
  }

  public function getUrutanRumus($field, $where, $order = '', $limit = '', $offset = ''){
    $this->db->select($field);
    $this->db->order_by($order);
    if (!empty($where)) $this->db->where($where);
    return $this->db->get('sample.sample_parameter_rumus', $limit, $offset);
  }

  public function getParameterRumus($param = null){
    $this->db->select('*');
    $this->db->from('sample.sample_parameter_rumus');

    if (isset($param['id_parameter']) && $param['id_parameter'] != '') $this->db->where('id_parameter', $param['id_parameter']);
    if (isset($param['detail_parameter_rumus_id']) && $param['detail_parameter_rumus_id'] != '') $this->db->where('detail_parameter_rumus_id', $param['detail_parameter_rumus_id']);
    $this->db->order_by('cast(rumus_detail_urut as int)', 'asc');

    $query = $this->db->get();

    return (isset($param['detail_parameter_rumus_id']) && $param['detail_parameter_rumus_id'] != '') ? $query->row_array() : $query->result_array();
  }
  /* Get Parameter & Detail Paramater */

  /* Insert Parameter & Detail Paramater */
  public function insertRumusMultipleDetail($data){
    $this->db->insert('sample.sample_detail_multiple', $data);

    return $this->db->affected_rows();
  }

  public function insertDetailParameter($data){
    $this->db->insert('sample.sample_parameter_rumus', $data);

    return $this->db->affected_rows();
  }
  /* Insert Parameter & Detail Paramater */

  /* Update Parameter & Detail Paramater */
  public function updateRumusMultipleDetail($data, $id){
    $this->db->set($data);
    $this->db->where('detail_multiple_rumus_id', $id);
    $this->db->update('sample.sample_detail_multiple');

    return $this->db->affected_rows();
  }

  public function updateDetailParameter($data, $id){
    $this->db->set($data);
    $this->db->where('detail_parameter_rumus_id', $id);
    $this->db->update('sample.sample_parameter_rumus');

    return $this->db->affected_rows();
  }
  /* Update Parameter & Detail Paramater */

  /* Delete Parameter & Detail Paramater */
  public function deleteRumusMultipleDetail($id){
    $this->db->where('detail_multiple_rumus_id', $id);
    $this->db->delete('sample.sample_detail_multiple');

    return $this->db->affected_rows();
  }

  public function deleteDetailParameter($id){
    $this->db->where('detail_parameter_rumus_id', $id);
    $this->db->delete('sample.sample_parameter_rumus');

    return $this->db->affected_rows();
  }
  /* Delete Parameter & Detail Paramater */

  /* Get Import */
  public function getImport($data = null){
    $this->db->select('*');
    $this->db->from('import.import_sample_perhitungan_multiple a');
    $this->db->join('sample.sample_jenis b', 'a.jenis_id = b.jenis_id', 'left');

    if (isset($data['import_kode'])) $this->db->where('import_kode', $data['import_kode']);
    $sql = $this->db->get();

    return (isset($data['multiple_rumus_id'])) ? $sql->row_array() : $sql->result_array();
  }

  public function getImportParameter($data = null){
    $this->db->select('*');
    $this->db->from('import.import_sample_detail_multiple a');
    $this->db->join('sample.sample_perhitungan_multiple b', 'a.id_multiple_rumus = b.multiple_rumus_id', 'left');

    if (isset($data['import_kode'])) $this->db->where('import_kode', $data['import_kode']);
    $sql = $this->db->get();

    return $sql->result_array();
  }

  public function getImportDetailParameter($data = null){
    $this->db->select('*');
    $this->db->from('import.import_sample_parameter_rumus a');
    $this->db->join('sample.sample_detail_multiple b', 'a.id_parameter = b.detail_multiple_rumus_id', 'left');

    if (isset($data['import_kode'])) $this->db->where('import_kode', $data['import_kode']);

    $this->db->order_by('rumus_detail_urut', 'ASC');
    $sql = $this->db->get();

    return $sql->result_array();
  }
  /* Get Import */

  /* Insert Import */
  public function insertTable($data){
    $this->db->query("INSERT INTO sample.sample_perhitungan_multiple SELECT multiple_rumus_id, jenis_id, metode, when_create, who_create FROM import.import_sample_perhitungan_multiple WHERE import_kode = '" . $data['import_kode'] . "'");

    return $this->db->affected_rows();
  }

  public function insertTableParameter($data){
    $this->db->query("INSERT INTO sample.sample_detail_multiple SELECT detail_multiple_rumus_id, id_multiple_rumus, parameter_rumus, when_create, who_create, satuan_parameter FROM import.import_sample_detail_multiple WHERE import_kode = '" . $data['import_kode'] . "'");

    return $this->db->affected_rows();
  }

  public function insertTableDetailParameter($data){
    $this->db->query("INSERT INTO sample.sample_parameter_rumus SELECT detail_parameter_rumus_id, id_parameter, detail_parameter_rumus, when_create, who_create, rumus_detail_input, rumus_jenis, rumus_detail_urut FROM import.import_sample_parameter_rumus WHERE import_kode = '" . $data['import_kode'] . "'");

    return $this->db->affected_rows();
  }
  /* Insert Import */

  /* Delete Import */
  public function deleteTable($id){
    $this->db->where('import_kode', $id);
    $this->db->delete('import.import_sample_perhitungan_multiple');

    return $this->db->affected_rows();
  }

  public function deleteTableParameter($id){
    $this->db->where('import_kode', $id);
    $this->db->delete('import.import_sample_detail_multiple');

    return $this->db->affected_rows();
  }

  public function deleteTableDetailParameter($id){
    $this->db->where('import_kode', $id);
    $this->db->delete('import.import_sample_parameter_rumus');

    return $this->db->affected_rows();
  }
  /* Delete Import */
}   /* . end proses M_rumus_multiple */
