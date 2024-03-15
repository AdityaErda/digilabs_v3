<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_role extends CI_Model
{
	/* GET */
	public function getRole($data = null){
		$this->db->select('*');
		$this->db->from('global.global_role');
		if (isset($data['role_nama'])) $this->db->where("upper(role_nama) LIKE '%" . strtoupper($data['role_nama']) . "%'");
		if (isset($data['role_id'])) $this->db->where('role_id', $data['role_id']);
		$this->db->order_by('UPPER(role_nama)', 'asc');
		$sql = $this->db->get();

		return (isset($data['role_id'])) ? $sql->row_array() : $sql->result_array();
	}

	public function getMenu(){
		$this->db->select('*');
		$this->db->from('global.global_menu_baru');
		$this->db->order_by("menu_id", "asc");
		$sql = $this->db->get();

		return $sql->result_array();
	}

	public function getMenuRole($data = null){
		$this->db->select('*');
		$this->db->from('global.global_menu_baru a');
		$this->db->join('global.global_menu_role b', 'a.menu_id = b.id_menu', 'left');
		if (isset($data['role_id'])) $this->db->where('b.id_role', $data['role_id']);
		$this->db->order_by('menu_urut', 'asc');
		$sql = $this->db->get();

		return $sql->result_array();
	}
	/* GET */

	/* INSERT */
	public function insertRole($data){
		$this->db->insert('global.global_role', $data);

		return $this->db->affected_rows();
	}

	public function insertMenuRole($data){
		$this->db->insert('global.global_menu_role', $data);

		return $this->db->affected_rows();
	}
	/* INSERT */

	/* UPDATE */
	public function updateRole($data, $id){
		$this->db->set($data);
		$this->db->where('role_id', $id);
		$this->db->update('global.global_role');

		return $this->db->affected_rows();
	}
	/* UPDATE */

	/* DELETE */
	public function deleteRole($id){
		$this->db->where('role_id', $id);
		$this->db->delete('global.global_role');

		return $this->db->affected_rows();
	}

	public function deleteMenuRole($id){
		$this->db->where('id_role', $id);
		$this->db->delete('global.global_menu_role');

		return $this->db->affected_rows();
	}
	/* DELETE */

	/* GET IMPORT */
	public function getImport($data = null){
		$this->db->select('*');
		$this->db->from('import.import_global_role');
		if (isset($data['import_kode'])) $this->db->where('import_kode', $data['import_kode']);
		$sql = $this->db->get();

		return (isset($data['role_id'])) ? $sql->row_array() : $sql->result_array();
	}
	/* GET IMPORT */

	/* INSERT IMPORT */
	public function insertImport(){
		$insert = $this->db->insert_batch('import.import_global_role', $data);
		if ($insert) {
			return true;
		}
	}

	public function insertTable($data){
		$this->db->query("INSERT INTO global.global_role SELECT role_id, null, role_kode, role_nama, when_create, who_create FROM import.import_global_role WHERE import_kode = '" . $data['import_kode'] . "' AND UPPER(role_nama) NOT IN (SELECT UPPER(role_nama) FROM global.global_role)");

		return $this->db->affected_rows();
	}
	/* INSERT IMPORT */

	/* DELETE TABLE */
	public function deleteTable($id){
		$this->db->where('import_kode', $id);
		$this->db->delete('import.import_global_role');

		return $this->db->affected_rows();
	}
	/* DELETE TABLE */
}
