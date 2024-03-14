<?php
	defined('BASEPATH') or exit('No direct script access allowed');

	class M_material_aset extends CI_Model {
		/* GET */
			public function getAset($data = null) {
				$this->db->select('*');
				$this->db->from('material.material_aset');
				if (isset($data['aset_nama'])) $this->db->where("upper(aset_nama) LIKE '%".strtoupper($data['aset_nama'])."%'");
				if (isset($data['aset_id'])) $this->db->where('aset_id', $data['aset_id']); 
				if (isset($data['tahun'])) $this->db->where("date_part('year', aset_tahun_perolehan) = ".$data['tahun']); 
				if(isset($data['aset_nama_import'])) $this->db->where('upper(aset_nama)',strtoupper($data['aset_nama_import']));
				if(isset($data['aset_nomor_utama'])) $this->db->where('aset_nomor_utama',$data['aset_nomor_utama']);
				if(isset($data['is_aset'])) $this->db->where('is_aset',$data['is_aset']);

				$this->db->order_by('UPPER(aset_nama)', 'asc');
				$sql = $this->db->get();

				return (isset($data['aset_id'])) ? $sql->row_array() : $sql->result_array();
			}
		/* GET */

		/* INSERT */
			public function insertAset($data) {
				$this->db->insert('material.material_aset', $data);

				return $this->db->affected_rows();
			}
		/* INSERT */

		/* UPDATE */
			public function updateAset($data, $id) {
				$this->db->set($data);
		    $this->db->where('aset_id', $id);
		    $this->db->update('material.material_aset');

		    return $this->db->affected_rows();
			}
		/* UPDATE */

		/* DELETE */
			public function deleteAset($id) {
				$this->db->where('aset_id', $id);
				$this->db->delete('material.material_aset');

		    return $this->db->affected_rows();
			}

			public function resetAset() {
				$this->db->empty_table('material.material_aset');

		    return $this->db->affected_rows();
			}
		/* DELETE */

		/* GET DETAIL */
			public function getAsetDetail($data = null) {
				$this->db->select('*');
				$this->db->from('material.material_aset_detail a');
				$this->db->join('sample.sample_peminta_jasa b', 'a.peminta_jasa_id = b.peminta_jasa_id', 'left');
				if (isset($data['aset_nomor'])) $this->db->where("upper(aset_nomor) LIKE '%".strtoupper($data['aset_nomor'])."%'");
				if (isset($data['aset_id'])) $this->db->where('a.aset_id', $data['aset_id']); 
				if (isset($data['aset_detail_id'])) $this->db->where('a.aset_detail_id', $data['aset_detail_id']); 
				$this->db->where('is_aktif', 'y');
				$sql = $this->db->get();

				return (isset($data['aset_detail_id'])) ? $sql->row_array() : $sql->result_array();
			}

			public function getJumlahAsetDetail($data = null) {
				$this->db->select('COUNT(*) AS total');
				$this->db->from('material.material_aset_detail a');
				$this->db->join('sample.sample_peminta_jasa b', 'a.peminta_jasa_id = b.peminta_jasa_id', 'left');
				$this->db->where('is_aktif', 'y'); 
				if (isset($data['aset_id'])) $this->db->where('aset_id', $data['aset_id']); 
				$sql = $this->db->get();

				return $sql->row_array();
			}
		/* GET DETAIL */

		/* INSERT DETAIL */
			public function insertAsetDetail($data) {
				$this->db->insert('material.material_aset_detail', $data);

				return $this->db->affected_rows();
			}
		/* INSERT DETAIL */

		/* UPDATE DETAIL */
			public function updateAsetDetail($data, $id) {
				$this->db->set($data);
		    $this->db->where('aset_detail_id', $id);
		    $this->db->update('material.material_aset_detail');

		    return $this->db->affected_rows();
			}
		/* UPDATE DETAIL */

		/* DELETE DETAIL */
			public function deleteAsetDetail($data, $id) {
				$this->db->set($data);
		    $this->db->where('aset_detail_id', $id);
		    $this->db->update('material.material_aset_detail');

		    return $this->db->affected_rows();
			}
		/* DELETE DETAIL */

		/* GET DOCUMENT */
			public function getAsetDocument($data = null) {
				$this->db->select('*');
				$this->db->from('material.material_aset_document a');
				if (isset($data['aset_id'])) $this->db->where('aset_id', $data['aset_id']); 
				if (isset($data['aset_document_id'])) $this->db->where('aset_document_id', $data['aset_document_id']); 
				$sql = $this->db->get();

				return (isset($data['aset_document_id'])) ? $sql->row_array() : $sql->result_array();
			}
		/* GET DOCUMENT */

		/* INSERT DOCUMENT */
			public function insertAsetDocument($data) {
				$this->db->insert('material.material_aset_document', $data);

				return $this->db->affected_rows();
			}
		/* INSERT DOCUMENT */

		/* UPDATE DOCUMENT */
			public function updateAsetDocument($data, $id) {
				$this->db->set($data);
		    $this->db->where('aset_document_id', $id);
		    $this->db->update('material.material_aset_document');

		    return $this->db->affected_rows();
			}
		/* UPDATE DOCUMENT */

		/* DELETE DOCUMENT */
			public function deleteAsetDocument($id) {
				$this->db->where('aset_document_id', $id);
				$this->db->delete('material.material_aset_document');

		    return $this->db->affected_rows();
			}
		/* DELETE DOCUMENT */

		/* GET DOWNLOAD */
			public function getAsetDownload($data = null) {
				$this->db->select('*');
				$this->db->from('material.material_aset_document a');
				if (isset($data['aset_id'])) $this->db->where('aset_id', $data['aset_id']);  
				$sql = $this->db->get();

				return $sql->result_array();
			}
		/* GET DOWNLOAD */

		/* GET IMPORT */
			public function getImport($data = null) {
				$this->db->select('*');
				$this->db->from('import.import_material_aset');
				if (isset($data['import_kode'])) $this->db->where('import_kode', $data['import_kode']); 
				$sql = $this->db->get();

				return (isset($data['aset_id'])) ? $sql->row_array() : $sql->result_array();
			}
		/* GET IMPORT */

		/* INSERT IMPORT */
			public function insertImport() {
				$insert = $this->db->insert_batch('import.import_material_aset', $data);
				if($insert){
					return true;
				}
			}

			public function insertTable($data) {
				$this->db->query("INSERT INTO material.material_aset SELECT aset_id, null, aset_umur, aset_tahun_perolehan, aset_nama, aset_penyusutan_thn_lalu, aset_penyusutan_thn_ini, aset_total_penyusutan, aset_nilai_buku, 0, aset_foto, aset_file, aset_nilai_perolehan, when_create, who_create, null, null, is_aset, aset_serial, aset_serial FROM import.import_material_aset WHERE import_kode = '".$data['import_kode']."' AND UPPER(aset_nama) NOT IN (SELECT UPPER(aset_nama) FROM material.material_aset)");

				return $this->db->affected_rows();
			}
		/* INSERT IMPORT */

		/* DELETE TABLE */
			public function deleteTable($id) {
				$this->db->where('import_kode', $id);
				$this->db->delete('import.import_material_aset');

		    return $this->db->affected_rows();
			}
		/* DELETE TABLE */

		/* GET IMPORT */
		public function getImportDetail($data = null) {
			$this->db->select('*');
			$this->db->from('import.import_material_aset_detail a');
			$this->db->join('material.material_aset b','a.aset_id=b.aset_id','left');
			$this->db->join('sample.sample_peminta_jasa c','c.peminta_jasa_id=a.peminta_jasa_id','left');
			if (isset($data['import_kode'])) $this->db->where('import_kode', $data['import_kode']); 
			$sql = $this->db->get();

			return $sql->result_array();

			// return (isset($data['aset_id'])) ? $sql->row_array() : $sql->result_array();
		}
	/* GET IMPORT */

	/* INSERT IMPORT DETAIL */
		public function insertImportDetail() {
			$insert = $this->db->insert_batch('import.import_material_aset_detail', $data);
			if($insert){
				return true;
			}
		}

		public function insertTableDetail($data) {
			$this->db->query("INSERT INTO material.material_aset_detail SELECT aset_detail_id, aset_id,peminta_jasa_id, null,when_create, who_create,aset_nomor,is_aktif,aset_detail_merk FROM import.import_material_aset_detail WHERE import_kode = '".$data['import_kode']."' AND UPPER(aset_detail_merk) NOT IN (SELECT UPPER(aset_detail_merk) FROM material.material_aset_detail WHERE aset_id = '".$data['aset_id']."')");

			return $this->db->affected_rows();
		}
	/* INSERT IMPORT DETAIL */

	/* DELETE TABLE DETAIL */
		public function deleteTableDetail($id) {
			$this->db->where('import_kode', $id);
			$this->db->delete('import.import_material_aset_detail');

		return $this->db->affected_rows();
		}
	/* DELETE TABLE DETAIL */
	}