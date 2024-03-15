<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_unit_kerja extends CI_Model {

	public function getUnitKerja($param=null){
		$this->db->select('*');
		$this->db->from('global.global_api_unit_kerja');
		if(isset($param['unit_kerja_nama'])) $this->db->like('unit_kerja_nama', $param['unit_kerja_nama'], 'BOTH');
		$query = $this->db->get();

		return $query->result_array();
	}

}

/* End of file M_unit_kerja.php */
/* Location: .//C/Users/jii/AppData/Local/Temp/fz3temp-2/M_unit_kerja.php */