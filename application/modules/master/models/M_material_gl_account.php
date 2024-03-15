<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_material_gl_account extends CI_Model {
	/* GET */
		public function getGlAccount($data = null) {
			$this->db->select('*');
			$this->db->from('material.material_gl_account');
			if (isset($data['gl_account_nama'])) $this->db->where("upper(gl_account_nama) LIKE '%".strtoupper($data['gl_account_nama'])."%'");
			if (isset($data['gl_account_id'])) $this->db->where('gl_account_id', $data['gl_account_id']); 
			$sql = $this->db->get();

			return (isset($data['gl_account_id'])) ? $sql->row_array() : $sql->result_array();
		}
	/* GET */

	/* INSERT */
		public function insertGlAccount($data) {
			$this->db->insert('material.material_gl_account', $data);

			return $this->db->affected_rows();
		}
	/* INSERT */

	/* UPDATE */
		public function updateGlAccount($data, $id) {
			$this->db->set($data);
	    $this->db->where('gl_account_id', $id);
	    $this->db->update('material.material_gl_account');

	    return $this->db->affected_rows();
		}
	/* UPDATE */

	/* DELETE */
		public function deleteGlAccount($id) {
			$this->db->where('gl_account_id', $id);
			$this->db->delete('material.material_gl_account');

	    return $this->db->affected_rows();
		}
	/* DELETE */
	/* RESET */
		public function resetGlAccount(){
			$this->db->where('gl_account_id !=', '');
			$this->db->delete('material.material_gl_account');

			return $this->db->affected_rows();
		}
		/* RESET */

	/* GET IMPORT */
		public function getImport($data = null) {
			$this->db->select('*');
			$this->db->from('import.import_material_gl_account');
			if (isset($data['import_kode'])) $this->db->where('import_kode', $data['import_kode']); 
			$sql = $this->db->get();

			return (isset($data['role_id'])) ? $sql->row_array() : $sql->result_array();
		}
	/* GET IMPORT */

	/* INSERT IMPORT */
		public function insertImport() {
			$insert = $this->db->insert_batch('import.import_material_gl_account', $data);
			if($insert){
				return true;
			}
		}

		public function insertTable($data) {
			$this->db->query("INSERT INTO material.material_gl_account SELECT gl_account_id, null, gl_account_kode, gl_account_nama, when_create, who_create FROM import.import_material_gl_account WHERE import_kode = '".$data['import_kode']."' AND UPPER(gl_account_nama) NOT IN (SELECT UPPER(gl_account_nama) FROM material.material_gl_account)");

			return $this->db->affected_rows();
		}
	/* INSERT IMPORT */

	/* DELETE TABLE */
		public function deleteTable($id) {
			$this->db->where('import_kode', $id);
			$this->db->delete('import.import_material_gl_account');

	    return $this->db->affected_rows();
		}
	/* DELETE TABLE */
}