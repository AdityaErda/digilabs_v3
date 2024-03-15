<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_user extends CI_Model{

  public function getUserJabatanList($value = ''){
    $this->db->select('user_poscode,user_post_title');
    $this->db->from('global.global_api_user');
    $this->db->like('upper(user_post_title)', strtoupper($value['param_name']), 'BOTH');
    $this->db->order_by('user_poscode', 'asc');
    $this->db->group_by('user_poscode');
    $this->db->group_by('user_post_title');

    $sql = $this->db->get();

    return $sql->result_array();
  }

  public function getUserList($value = null){
    $this->db->select('*');
    $this->db->from('global.global_api_user a');
    $this->db->join('global.global_user_detail b', 'b.user_detail_userName = a.user_nik_sap', 'left');

    if (isset($value['user_job_id_array'])) $this->db->where_in('user_job_id', $value['user_job_id_array']);
    if (isset($value['user_unit_id_array'])) $this->db->where_in('user_unit_id', $value['user_unit_id_array']);
    if (isset($value['direct_superior'])) $this->db->where('user_unit_kerja_id', $value['direct_superior']);
    if (isset($value['user_nik_sap'])) $this->db->where('user_nik_sap', $value['user_nik_sap']);
    if (isset($value['user_unit_id'])) $this->db->where('user_unit_id', $value['user_unit_id']);

    // if (isset($value['param_search'])) $this->db->like('UPPER(user_nama)', strtoupper($value['param_search']), 'BOTH');

    if (isset($value['param_search'])) {
      $this->db->where("(upper(user_nama) LIKE '%" . strtoupper($value['param_search']) . "%' OR upper(user_post_title) LIKE '%" . strtoupper($value['param_search']) . "%')");
    }

    if (isset($value['user_detail_id'])) $this->db->where('b.user_detail_id', $value['user_detail_id']);

    $this->db->order_by('user_post_title', 'desc');
    $this->db->order_by('user_nik_sap', 'asc');
    $this->db->order_by('user_nama', 'asc');

    $sql = $this->db->get();

    return $sql->result_array();
  }

  public function getUserCCList($value = null){
    $this->db->select('*');
    $this->db->from('global.global_api_user a');
    $this->db->join('global.global_user_detail b', 'b.user_detail_userName = a.user_nik_sap', 'left');
    if (isset($value['param_search'])) $this->db->like('UPPER(user_detail_name)', strtoupper($value['param_search']), 'BOTH');
    $this->db->order_by('user_nama', 'asc');
    $this->db->order_by('user_detail_name', 'asc');

    // if(isset($value))

    $sql = $this->db->get();

    return $sql->result_array();
  }

  public function getUserList2($data = null){
    if (isset($data['user_poscode'])) $this->db->where("user_poscode", $data['user_poscode']);
    if (isset($data['user_nik_sap'])) $this->db->where("user_nik_sap", $data['user_nik_sap']);
    if (isset($data['user_detail_id'])) $this->db->where('b.user_detail_id', $data['user_detail_id']);

    $this->db->select('a.*,b.user_detail_id,b.user_detail_name');
    $this->db->from('global.global_api_user a');
    $this->db->join('global.global_user_detail b', 'b.user_detail_userName = a.user_nik_sap', 'left');

    $this->db->order_by('user_nik_sap', 'asc');
    $this->db->order_by('user_nama', 'asc');

    $sql = $this->db->get();

    return $sql->row_array();
  }

  public function getUserList3($data = null){
    if (isset($data['user_poscode'])) $this->db->where("user_poscode", $data['user_poscode']);
    if (isset($data['user_nik_sap'])) $this->db->where("user_nik_sap", $data['user_nik_sap']);
    if (isset($data['user_detail_id'])) $this->db->where('b.user_detail_id', $data['user_detail_id']);

    $this->db->select('a.user_nik,a.user_nik_sap,a.user_nama,a.user_status_karyawan,a.user_unit_kerja_nama,a.user_lokasi_kerja,a.user_poscode,a.user_direct_superior,a.user_post_title,a.user_departemen_nama,b.user_detail_id,b.user_detail_name');
    $this->db->from('global.global_api_user a');
    $this->db->join('global.global_user_detail b', 'b.user_detail_userName = a.user_nik_sap', 'left');

    $this->db->order_by('user_nik_sap', 'asc');
    $this->db->order_by('user_nama', 'asc');

    $sql = $this->db->get();

    return $sql->row_array();
  }
}

/* End of file M_user.php */
