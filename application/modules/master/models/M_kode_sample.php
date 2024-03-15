<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_kode_sample extends CI_Model{

	public function getKodeSample($param = null){
		$this->db->select('*');
		$this->db->from('global.global_kode_sample');
		if (isset($param['kode_sample_id'])) $this->db->where('kode_sample_id', $param['kode_sample_id']);
		$query = $this->db->get();

		if ($query) {
			return (isset($param['kode_sample_id'])) ? $query->row_array() : $query->result_array();
		}
		return false;
	}

	public function updateKodeSample($id, $param = null){
		$this->db->where('kode_sample_id', $id);
		$this->db->update('global.global_kode_sample', $param);

		return $this->db->affected_rows();
	}
}

/* End of file M_kode_sample.php */
