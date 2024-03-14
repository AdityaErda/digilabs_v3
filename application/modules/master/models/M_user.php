<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_user extends CI_Model
{
	/* GET */
	public function getUser($data = null)
	{
		$this->db->select('a.*, b.role_id, b.role_nama, c.seksi_id, c.seksi_nama');
		$this->db->from('global.global_user a');
		$this->db->join('global.global_role b', 'a.role_id = b.role_id', 'left');
		$this->db->join('global.global_seksi c', 'a.id_seksi = c.seksi_id', 'left');
		if (isset($data['user_id'])) $this->db->where('user_id', $data['user_id']);
		if (isset($data['id_seksi'])) $this->db->where('id_seksi', $data['id_seksi']);
		if (isset($data['user_nama_lengkap'])) $this->db->where("upper(user_nama_lengkap) LIKE '%" . strtoupper($data['user_nama_lengkap']) . "%'");
		$sql = $this->db->get();

		return (isset($data['user_id'])) ? $sql->row_array() : $sql->result_array();
	}
	/* GET */

	/* INSERT */
	public function insertUser($data)
	{
		$this->db->insert('global.global_user', $data);

		return $this->db->affected_rows();
	}
	/* INSERT */

	/* UPDATE */
	public function updateUser($data, $id)
	{
		$this->db->set($data);
		$this->db->where('user_id', $id);
		$this->db->update('global.global_user');

		return $this->db->affected_rows();
	}
	/* UPDATE */

	/* DELETE */
	public function deleteUser($id)
	{
		$this->db->where('user_id', $id);
		$this->db->delete('global.global_user');

		return $this->db->affected_rows();
	}
	/* DELETE */

	/* GET SEKSI */
	public function getSeksi($data = null)
	{
		$this->db->select('*');
		$this->db->from('global.global_seksi a');
		if (isset($data['seksi_nama'])) $this->db->where("upper(seksi_nama) LIKE '%" . strtoupper($data['seksi_nama']) . "%'");
		if (isset($data['seksi_id'])) $this->db->where('seksi_id', $data['seksi_id']);
		$sql = $this->db->get();

		return (isset($data['seksi_id'])) ? $sql->row_array() : $sql->result_array();
	}
	/* GET SEKSI */

	/* GET KASIE */
	public function getNamaKasie($data = null)
	{
		$this->db->select('*');
		$this->db->from('global.global_user a');
		// $this->db->join('global.global seksi b', 'a.id_seksi = b.seksi_id', 'left');
		if (isset($data['user_nama_lengkap'])) $this->db->where("upper(user_nama_lengkap) LIKE '%" . strtoupper($data['user_nama_lengkap']) . "%'");
		if (isset($data['user_id'])) $this->db->where('user_id', $data['user_id']);
		$sql = $this->db->get();

		return (isset($data['user_id'])) ? $sql->row_array() : $sql->result_array();
	}
	/* GET KASIE */

	/* Insert Kasie */
	public function updateKasieNama($id, $data = null)
	{
		$this->db->where('seksi_id', $id);
		$this->db->update('global.global_seksi', $data);

		return $this->db->affected_rows();
	}
	/* Insert Kasie */

	/* INSERT SEKSI */
	public function insertSeksi($data)
	{
		$this->db->insert('global.global_seksi', $data);

		return $this->db->affected_rows();
	}
	/* INSERT SEKSI */

	/* UPDATE SEKSI */
	public function updateSeksi($data, $id)
	{
		$this->db->set($data);
		$this->db->where('seksi_id', $id);
		$this->db->update('global.global_seksi');

		return $this->db->affected_rows();
	}
	/* UPDATE SEKSI */

	/* DELETE SEKSI */
	public function deleteSeksi($id)
	{
		$this->db->where('seksi_id', $id);
		$this->db->delete('global.global_seksi');

		return $this->db->affected_rows();
	}
	/* DELETE SEKSI */

	/* GET IMPORT SEKSI */
	public function getImportSeksi($data = null)
	{
		$this->db->select('*');
		$this->db->from('import.import_global_seksi');
		if (isset($data['import_kode'])) $this->db->where('import_kode', $data['import_kode']);
		$sql = $this->db->get();

		return (isset($data['role_id'])) ? $sql->row_array() : $sql->result_array();
	}
	/* GET IMPORT SEKSI */

	/* INSERT IMPORT SEKSI */
	public function insertImportSeksi()
	{
		$insert = $this->db->insert_batch('import.import_global_seksi', $data);
		if ($insert) {
			return true;
		}
	}

	public function insertTableSeksi($data)
	{
		$this->db->query("INSERT INTO global.global_seksi SELECT seksi_id, seksi_kode, seksi_nama, when_create, who_create FROM import.import_global_seksi WHERE import_kode = '" . $data['import_kode'] . "' AND seksi_nama NOT IN (SELECT seksi_nama FROM global.global_seksi)");

		return $this->db->affected_rows();
	}
	/* INSERT IMPORT SEKSI */

	/* DELETE TABLE SEKSI */
	public function deleteTableSeksi($id)
	{
		$this->db->where('import_kode', $id);
		$this->db->delete('import.import_global_seksi');

		return $this->db->affected_rows();
	}
	/* DELETE TABLE SEKSI */

	/* GET IMPORT */
	public function getImport($data = null)
	{
		$this->db->select('a.*, b.role_nama, c.seksi_nama');
		$this->db->from('import.import_global_user a');
		$this->db->join('global.global_role b', 'a.role_id = b.role_id', 'left');
		$this->db->join('global.global_seksi c', 'a.id_seksi = c.seksi_id', 'left');
		if (isset($data['import_kode'])) $this->db->where('import_kode', $data['import_kode']);
		$sql = $this->db->get();

		return (isset($data['role_id'])) ? $sql->row_array() : $sql->result_array();
	}
	/* GET IMPORT */

	/* INSERT IMPORT */
	public function insertImport()
	{
		$insert = $this->db->insert_batch('import.import_global_user', $data);
		if ($insert) {
			return true;
		}
	}

	public function insertTable($data)
	{
		$this->db->query("INSERT INTO global.global_user SELECT user_id, role_id, user_nama_lengkap, user_tgl_lahir, user_tempat_lahir, user_username, user_password, null, when_create, who_create, id_seksi FROM import.import_global_user WHERE import_kode = '" . $data['import_kode'] . "' AND UPPER(user_username) NOT IN (SELECT UPPER(user_username) FROM global.global_user WHERE id_seksi='" . $data['id_seksi'] . "')");

		return $this->db->affected_rows();
	}
	/* INSERT IMPORT */

	/* DELETE TABLE */
	public function deleteTable($id)
	{
		$this->db->where('import_kode', $id);
		$this->db->delete('import.import_global_user');

		return $this->db->affected_rows();
	}
	/* DELETE TABLE */
}
