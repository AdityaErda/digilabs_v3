<?php
	defined('BASEPATH') or exit('No direct script access allowed');

	class M_document_jenis extends CI_Model {
		/* GET */
			public function getJenisDocument($data = null) {
				$this->db->select('*');
				$this->db->from('document.document_jenis');
				if (isset($data['jenis_nama'])) $this->db->where("upper(jenis_nama) LIKE '%".strtoupper($data['jenis_nama'])."%'");
				if (isset($data['jenis_id'])) $this->db->where('jenis_id', $data['jenis_id']); 
				$sql = $this->db->get();

				return (isset($data['jenis_id'])) ? $sql->row_array() : $sql->result_array();
			}
		/* GET */

		/* INSERT */
			public function insertJenisDocument($data) {
				$this->db->insert('document.document_jenis', $data);

				return $this->db->affected_rows();
			}
		/* INSERT */

		/* UPDATE */
			public function updateJenisDocument($data, $id) {
				$this->db->set($data);
		    $this->db->where('jenis_id', $id);
		    $this->db->update('document.document_jenis');

		    return $this->db->affected_rows();
			}
		/* UPDATE */

		/* DELETE */
			public function deleteJenisDocument($id) {
				$this->db->where('jenis_id', $id);
				$this->db->delete('document.document_jenis');

		    return $this->db->affected_rows();
			}
		/* DELETE */
		/* RESET */
		public function resetJenisDocument()
		{
			$this->db->where('jenis_id !=', '');
			$this->db->delete('document.document_jenis');

			return $this->db->affected_rows();
		}
			/* RESET */

		/* GET IMPORT */
			public function getImport($data = null) {
				$this->db->select('*');
				$this->db->from('import.import_document_jenis');
				if (isset($data['import_kode'])) $this->db->where('import_kode', $data['import_kode']); 
				$sql = $this->db->get();

				return (isset($data['role_id'])) ? $sql->row_array() : $sql->result_array();
			}
		/* GET IMPORT */

		/* INSERT IMPORT */
			public function insertImport() {
				$insert = $this->db->insert_batch('import.import_document_jenis', $data);
				if($insert){
					return true;
				}
			}

			public function insertTable($data) {
				$this->db->query("INSERT INTO document.document_jenis SELECT jenis_id, null, jenis_nama, jenis_kode, when_create, who_create FROM import.import_document_jenis WHERE import_kode = '".$data['import_kode']."' AND UPPER(jenis_nama) NOT IN(SELECT UPPER(jenis_kode) FROM document.document_jenis) AND UPPER(jenis_kode) NOT IN(SELECT UPPER(jenis_nama) FROM document.document_jenis)");

				return $this->db->affected_rows();
			}
		/* INSERT IMPORT */

		/* DELETE TABLE */
			public function deleteTable($id) {
				$this->db->where('import_kode', $id);
				$this->db->delete('import.import_document_jenis');

		    return $this->db->affected_rows();
			}
		/* DELETE TABLE */
	}