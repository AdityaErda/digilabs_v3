<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_departemen extends CI_Model {

	public function getDepartemen($param=''){
		$this->db->select('*');
		$this->db->from('global.global_api_departemen');
		if(isset($param['param_search'])) $this->db->like('UPPER(departemen_nama)', strtoupper($param['param_search']), 'BOTH');
		$this->db->order_by('departemen_nama', 'asc');

		$sql = $this->db->get();

		return $sql->result_array();
	}	

}

/* End of file M_departemen.php */
/* Location: .//C/Users/jii/AppData/Local/Temp/fz3temp-2/M_departemen.php */