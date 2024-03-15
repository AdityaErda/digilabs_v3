<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_harga_pokok_jasa extends CI_Model{
	/* GET */
	public function getHargaPokokJasa($data = null){
		$this->db->select('*');
		$this->db->from('global.global_harga_pokok_jasa a');
        $this->db->join('material.material_item b', 'a.id_item = b.item_id', 'left');
        $this->db->join('material.material_aset c', 'a.id_aset = c.aset_id', 'left');
        $this->db->join('sample.sample_identitas d', 'a.id_sample = d.identitas_id', 'left');
        $this->db->join('sample.sample_jenis e', 'd.jenis_id = e.jenis_id', 'left');
		if (isset($data['item_nama'])) $this->db->where("upper(item_nama) LIKE '%" . strtoupper($data['item_nama']) . "%'");
		if (isset($data['harga_pokok_jasa_id'])) $this->db->where('harga_pokok_jasa_id', $data['harga_pokok_jasa_id']);
		$sql = $this->db->get();

		return (isset($data['harga_pokok_jasa_id'])) ? $sql->row_array() : $sql->result_array();
	}
	
	/* GET */

	/* INSERT */
	public function insertHargaPokokJasa($data){
		$this->db->insert('global.global_harga_pokok_jasa', $data);

		return $this->db->affected_rows();
	}
	/* INSERT */

	/* UPDATE */
	public function updateHargaPokokJasa($data, $id){
		$this->db->set($data);
		$this->db->where('harga_pokok_jasa_id', $id);
		$this->db->update('global.global_harga_pokok_jasa');

		return $this->db->affected_rows();
	}
	/* UPDATE */

	/* DELETE */
	public function deleteHargaPokokJasa($id){
		$this->db->where('harga_pokok_jasa_id', $id);
		$this->db->delete('global.global_harga_pokok_jasa');

		return $this->db->affected_rows();
	}
	/* DELETE */

	/* RESET */
	public function resetHargaPokokJasa(){
		$this->db->where('harga_pokok_jasa_id !=', '');
		$this->db->delete('global.global_harga_pokok_jasa');

		return $this->db->affected_rows();
	}
	/* RESET */
	/* GET IMPORT */
	public function getImport($data = null){
		$this->db->select('*');
		$this->db->from('import.import_material_jenis');
		if (isset($data['import_kode'])) $this->db->where('import_kode', $data['import_kode']);
		$sql = $this->db->get();

		return (isset($data['role_id'])) ? $sql->row_array() : $sql->result_array();
	}
	/* GET IMPORT */

	/* INSERT IMPORT */
	public function insertImport(){
		$insert = $this->db->insert_batch('import.import_material_jenis', $data);
		if ($insert) {
			return true;
		}
	}

	public function insertTable($data){
		$this->db->query("INSERT INTO material.material_jenis SELECT jenis_id, null, jenis_nama, jenis_kode, when_create, who_create FROM import.import_material_jenis WHERE import_kode = '" . $data['import_kode'] . "' AND UPPER(jenis_nama) NOT IN (SELECT UPPER(jenis_nama) FROM material.material_jenis)");

		return $this->db->affected_rows();
	}
	/* INSERT IMPORT */

	/* DELETE TABLE */
	public function deleteTable($id){
		$this->db->where('import_kode', $id);
		$this->db->delete('import.import_material_jenis');

		return $this->db->affected_rows();
	}
	/* DELETE TABLE */
}
