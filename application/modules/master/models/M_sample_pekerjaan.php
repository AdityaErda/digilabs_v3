<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_sample_pekerjaan extends CI_Model {
	/* GET */
		public function getJenisPekerjaan($data = null) {
			$this->db->select('*');
			$this->db->from('sample.sample_pekerjaan');
			if (isset($data['sample_pekerjaan_nama'])) $this->db->where("upper(sample_pekerjaan_nama) LIKE '%".strtoupper($data['sample_pekerjaan_nama'])."%'");
			if (isset($data['sample_pekerjaan_id'])) $this->db->where('sample_pekerjaan_id', $data['sample_pekerjaan_id']); 
			$sql = $this->db->get();

			return (isset($data['sample_pekerjaan_id'])) ? $sql->row_array() : $sql->result_array();
		}
	/* GET */

	/* INSERT */
		public function insertJenisPekerjaan($data) {
			$this->db->insert('sample.sample_pekerjaan', $data);

			return $this->db->affected_rows();
		}
	/* INSERT */

	/* UPDATE */
		public function updateJenisPekerjaan($data, $id) {
			$this->db->set($data);
	    $this->db->where('sample_pekerjaan_id', $id);
	    $this->db->update('sample.sample_pekerjaan');

	    return $this->db->affected_rows();
		}
	/* UPDATE */

	/* DELETE */
		public function deleteJenisPekerjaan($id) {
			$this->db->where('sample_pekerjaan_id', $id);
			$this->db->delete('sample.sample_pekerjaan');

	    return $this->db->affected_rows();
		}

		public function resetJenisPekerjaan() {
			$this->db->empty_table('sample.sample_pekerjaan');

	    return $this->db->affected_rows();
		}
	/* DELETE */

	/* GET IMPORT */
		public function getImport($data = null) {
			$this->db->select('*');
			$this->db->from('import.import_sample_pekerjaan');
			if (isset($data['import_kode'])) $this->db->where('import_kode', $data['import_kode']); 
			$sql = $this->db->get();

			return (isset($data['role_id'])) ? $sql->row_array() : $sql->result_array();
		}
	/* GET IMPORT */

	/* INSERT IMPORT */
		public function insertImport() {
			$insert = $this->db->insert_batch('import.import_sample_pekerjaan', $data);
			if($insert){
				return true;
			}
		}

		public function insertTable($data) {
			$this->db->select('sample_pekerjaan_id, sample_pekerjaan_kode, sample_pekerjaan_nama, when_create, who_create', false);
			$this->db->from('import.import_sample_pekerjaan');
			$this->db->where('import_kode', $data['import_kode']);
			$this->db->where("UPPER(sample_pekerjaan_nama) NOT IN (SELECT UPPER(sample_pekerjaan_nama) FROM sample.sample_pekerjaan)", NULL, false);

			return $this->db->affected_rows();
		}
	/* INSERT IMPORT */

	/* DELETE TABLE */
		public function deleteTable($id) {
			$this->db->where('import_kode', $id);
			$this->db->delete('import.import_sample_pekerjaan');

	    return $this->db->affected_rows();
		}
	/* DELETE TABLE */
}