<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_user extends CI_Model
{
	public function getUser($data = null)
	{
		$this->db->select('a.user_id, a.role_id, a.user_nama_lengkap, a.user_tgl_lahir, a.user_tempat_lahir, a.user_password,a.user_telp, a.when_create, a.who_create, a.id_seksi, c.cv_id, c.company_code, c.cv_tanggal_masuk, c.cv_tanggal_selesai, c.cv_masa_kerja_tahun, c.cv_masa_kerja_bulan, c.cv_masa_kerja_hari, c.cv_nik, c.cv_email, c.cv_alamat,b.*');
		// $this->db->select('*');
		$this->db->from('global.global_user a');
		$this->db->join('global.global_api_user b', 'b.user_nik_sap = a.user_username', 'left');
		$this->db->join('document.document_cv c', 'a.user_id = c.user_id', 'left');
		if (isset($data['username'])) $this->db->where('user_username', $data['username']);
		if (isset($data['password'])) $this->db->where('user_password', md5($data['password']));
		$sql = $this->db->get();

		if (isset($data['username']) && isset($data['password'])) {
			return $sql->row_array();
		} else {
			return false;
		}

		// return (isset($data['username']) && isset($data['password'])) ? $sql->row_array() : $sql->result_array();
	}

	public function getUserName($data = null)
	{
		$this->db->select('a.user_id, a.role_id, a.user_nama_lengkap, a.user_tgl_lahir, a.user_tempat_lahir, a.user_password,a.user_telp, a.when_create, a.who_create, a.id_seksi, b.cv_id, b.company_code, b.cv_tanggal_masuk, b.cv_tanggal_selesai, b.cv_masa_kerja_tahun, b.cv_masa_kerja_bulan, b.cv_masa_kerja_hari, b.cv_nik, b.cv_email, b.cv_alamat');
		$this->db->from('global.global_user a');
		$this->db->join('document.document_cv b', 'a.user_id = b.user_id', 'left');
		if (isset($data['username'])) $this->db->where("user_username = '" . $data['username'] . "'");
		if (isset($data['password'])) $this->db->where('user_password', md5($data['password']));
		$sql = $this->db->get();

		return ($data['username']) ? $sql->row_array() : $sql->result_array();
	}

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
}
