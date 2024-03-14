<?php
	defined('BASEPATH') or exit('No direct script access allowed');

	class M_sample_peminta_jasa extends CI_Model {
		/* GET */
			public function getPemintaJasa($data = null) {
				$this->db->select('*');
				$this->db->from('sample.sample_peminta_jasa');
				if (isset($data['peminta_jasa_nama'])) $this->db->where("upper(peminta_jasa_nama) LIKE '%".strtoupper($data['peminta_jasa_nama'])."%'");
				if (isset($data['peminta_jasa_nama_import'])) $this->db->where("upper(peminta_jasa_nama)",strtoupper($data['peminta_jasa_nama_import']));
				if (isset($data['peminta_jasa_id'])) $this->db->where('peminta_jasa_id', $data['peminta_jasa_id']); 
				$sql = $this->db->get();

				return (isset($data['peminta_jasa_id'])) ? $sql->row_array() : $sql->result_array();
			}
		/* GET */

		/* INSERT */
			public function insertPemintaJasa($data) {
				$this->db->insert('sample.sample_peminta_jasa', $data);

				return $this->db->affected_rows();
			}
		/* INSERT */

		/* UPDATE */
			public function updatePemintaJasa($data, $id) {
				$this->db->set($data);
		    $this->db->where('peminta_jasa_id', $id);
		    $this->db->update('sample.sample_peminta_jasa');

		    return $this->db->affected_rows();
			}
		/* UPDATE */

		/* DELETE */
			public function deletePemintaJasa($id) {
				$this->db->where('peminta_jasa_id', $id);
				$this->db->delete('sample.sample_peminta_jasa');

		    return $this->db->affected_rows();
			}

			public function resetPemintaJasa() {
				$this->db->empty_table('sample.sample_peminta_jasa');

		    return $this->db->affected_rows();
			}
		/* DELETE */

		/* GET IMPORT */
			public function getImport($data = null) {
				$this->db->select('*');
				$this->db->from('import.import_sample_peminta_jasa');
				if (isset($data['import_kode'])) $this->db->where('import_kode', $data['import_kode']); 
				$sql = $this->db->get();

				return (isset($data['role_id'])) ? $sql->row_array() : $sql->result_array();
			}
		/* GET IMPORT */

		/* INSERT IMPORT */
			public function insertImport() {
				$insert = $this->db->insert_batch('import.import_sample_peminta_jasa', $data);
				if($insert){
					return true;
				}
			}

			public function insertTable($data) {
				$this->db->query("INSERT INTO sample.sample_peminta_jasa SELECT peminta_jasa_id, null, peminta_jasa_kode, peminta_jasa_nama, peminta_jasa_ext, when_create, who_create FROM import.import_sample_peminta_jasa WHERE import_kode = '".$data['import_kode']."' AND UPPER(peminta_jasa_nama) NOT IN (SELECT UPPER(peminta_jasa_nama) FROM sample.sample_peminta_jasa)");

				return $this->db->affected_rows();
			}
		/* INSERT IMPORT */

		/* DELETE TABLE */
			public function deleteTable($id) {
				$this->db->where('import_kode', $id);
				$this->db->delete('import.import_sample_peminta_jasa');

		    return $this->db->affected_rows();
			}
		/* DELETE TABLE */
	}