<?php


defined('BASEPATH') or exit('No direct script access allowed');

class M_parameter extends CI_Model {
  /* GET PARAMETER */
    public function getParameter($param = null) {
      $this->db->select('*');
      $this->db->from('global.global_parameter');
      if (($param['parameter_id'] != '')) $this->db->where('parameter_id', $param['parameter_id']);
      $this->db->order_by('parameter_nama', 'asc');
      $query = $this->db->get();

      return (($param['parameter_id'] != '')) ? $query->row_array() : $query->result_array();
    }
  /* GET PARAMETER */

  /* GET PARAMETER JASA */
    public function getParameterJasa($param = null) {
      $this->db->select('*');
      $this->db->from('global.global_parameter_jasa');
      if (($param['id_parameter'] != '')) $this->db->where('id_parameter', $param['id_parameter']);
      $query = $this->db->get();

      return $query->result_array();
    }
  /* GET PARAMETER JASA */

  /* GET PARAMETER MATERIAL */
    public function getParameterMaterial($param = null) {
      $this->db->select('*');
      $this->db->from('global.global_parameter_material a');
      $this->db->join('material.material_item b', 'a.id_material = b.item_id', 'left');
      if (($param['id_parameter'] != '')) $this->db->where('id_parameter', $param['id_parameter']);
      if (($param['parameter_material_id'] != '')) $this->db->where('parameter_material_id', $param['parameter_material_id']);
      $query = $this->db->get();

      return (($param['parameter_material_id'] != '')) ? $query->row_array() : $query->result_array();
    }
  /* GET PARAMETER MATERIAL */

  /* GET PARAMETER ASET */
    public function getParameterAset($param = null) {
      $this->db->select('*');
      $this->db->from('global.global_parameter_aset a');
      $this->db->join('material.material_aset b', 'a.id_aset = b.aset_id', 'left');
      if (($param['id_parameter'] != '')) $this->db->where('id_parameter', $param['id_parameter']);
      if (($param['parameter_aset_id'] != '')) $this->db->where('parameter_aset_id', $param['parameter_aset_id']);
      $query = $this->db->get();

      return (($param['parameter_aset_id'] != '')) ? $query->row_array() : $query->result_array();
    }
  /* GET PARAMETER ASET */

  /* INSERT PARAMETER */
    public function insertParameter($param = null) {
      $this->db->insert('global.global_parameter', $param);
      return $this->db->affected_rows();
    }
  /* INSERT PARAMETER */

  /* INSERT PARAMETER JASA */
    public function insertParameterJasa($param = null) {
      $this->db->insert('global.global_parameter_jasa', $param);
      return $this->db->affected_rows();
    }
  /* INSERT PARAMETER JASA */

  /* INSERT PARAMETER MATERIAL */
    public function insertParameterMaterial($param = null) {
      $this->db->insert('global.global_parameter_material', $param);
      return $this->db->affected_rows();
    }
  /* INSERT PARAMETER MATERIAL */


  /* INSERT PARAMETER ASET */
    public function insertParameterAset($param = null) {
      $this->db->insert('global.global_parameter_aset', $param);
      return $this->db->affected_rows();
    }
  /* INSERT PARAMETER ASET */

  /* UPDATE PARAMETER */
    public function updateParameter($id, $param = null) {
      $this->db->where('parameter_id', $id);
      $this->db->update('global.global_parameter', $param);

      return $this->db->affected_rows();
    }
  /* UPDATE PARAMETER */

  /* UPDATE PARAMETER MATERIAL */
    public function updateParameterMaterial($id, $param = null) {
      $this->db->where('parameter_material_id', $id);
      $this->db->update('global.global_parameter_material', $param);

      return $this->db->affected_rows();
    }
  /* UPDATE PARAMETER MATERIAL */

  /* UPDATE PARAMETER ASET */
    public function updateParameterAset($id, $param = null) {
      $this->db->where('parameter_aset_id', $id);
      $this->db->update('global.global_parameter_aset', $param);

      return $this->db->affected_rows();
    }
  /* UPDATE PARAMETER ASET */

  /* DELETE PARAMETER */
    public function deleteParameter($id) {
      $this->db->where('parameter_id', $id);
      $this->db->delete('global.global_parameter');
      return $this->db->affected_rows();
    }
  /* DELETE PARAMETER */

  /* DELETE PARAMETER JASA */
    public function deleteParameterJasa($id) {
      $this->db->where('id_parameter', $id);
      $this->db->delete('global.global_parameter_jasa');
      return $this->db->affected_rows();
    }
  /* DELETE PARAMETER JASA */

  /* DELETE PARAMETER MATERIAL */
    public function deleteParameterMaterial($id) {
      $this->db->where('parameter_material_id', $id);
      $this->db->delete('global.global_parameter_material');
      return $this->db->affected_rows();
    }
  /* DELETE PARAMETER MATERIAL */

  /* DELETE PARAMETER ASET */
    public function deleteParameterAset($id) {
      $this->db->where('parameter_aset_id', $id);
      $this->db->delete('global.global_parameter_aset');
      return $this->db->affected_rows();
    }
  /* DELETE PARAMETER ASET */

}

/* End of file M_parameter.php */
