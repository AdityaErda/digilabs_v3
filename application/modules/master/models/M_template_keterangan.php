<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_template_keterangan extends CI_Model {
 
 	// GET
 	public function getTemplateKeterangan($param=null){
 		$this->db->select('*');
 		$this->db->from('sample.sample_template_keterangan');
 		if(isset($param['template_keterangan_id'])) $this->db->where('template_keterangan_id', $param['template_keterangan_id']);
 		if(isset($param['template_keterangan_nama'])) $this->db->like('template_keterangan_nama', $param['template_keterangan_nama'], 'BOTH');

 		$sql = $this->db->get();

 		if($sql){
 		return (isset($param['tempalate_keterangan_id'])) ? $sql->row_array() : $sql->result_array();
 		}else{
 		return false;
 		}
	 }

	 public function getJenisTemplate($param = ''){
	 	$this->db->select('*');
	 	$this->db->from('sample.sample_template_jenis');
	 	if(isset($param['template_jenis_id'])) $this->db->where('template_jenis_id', $param['template_jenis_id'], FALSE);
	 	if(isset($param['param_search'])) $this->db->like('upper(template_jenis_nama)',strtoupper($param['template_jenis_nama']), 'both');

	 	$sql = $this->db->get();

	 	if($sql){
	 		return (isset($param['template_jenis_id'])) ? $sql->row_array() : $sql->result_array();
	 	}else{
	 		return false;
	 	}
	 }
 	// GET
	

}

/* End of file M_template_keterangan.php */
