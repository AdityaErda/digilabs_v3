<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_material_penyimpanan extends CI_Model
{
	/* GET */
	public function getPenyimpananBarang($data = null)
	{
		$this->db->select('*');
		$this->db->from('material.material_penyimpanan a');
        $this->db->join('material.material_aset b', 'a.penyimpanan_aset = b.aset_id', 'left');
		if (isset($data['penyimpanan_nama'])) $this->db->where("upper(penyimpanan_nama) LIKE '%" . strtoupper($data['penyimpanan_nama']) . "%'");
		if (isset($data['penyimpanan_id'])) $this->db->where('penyimpanan_id', $data['penyimpanan_id']);
		$sql = $this->db->get();

		return (isset($data['penyimpanan_id'])) ? $sql->row_array() : $sql->result_array();
	}
	
    public function getAset($data = null)
	{
		$this->db->select('*');
		$this->db->from('material.material_aset a');
        $this->db->join('material.material_penyimpanan b', 'a.aset_id = b.penyimpanan_aset', 'left');
        if (isset($data['aset_nama'])) $this->db->where("upper(aset_nama) LIKE '%".strtoupper($data['aset_nama'])."%'"); 
        $this->db->where('penyimpanan_aset', null);
        $this->db->order_by('UPPER(aset_nama)', 'asc');

		$sql = $this->db->get();
// echo $sql;
		return (isset($data['penyimpanan_id'])) ? $sql->row_array() : $sql->result_array();
	}
	/* GET */

	/* INSERT */
	public function insertPenyimpananBarang($data)
	{
		$this->db->insert('material.material_penyimpanan', $data);

		return $this->db->affected_rows();
	}
	/* INSERT */

	/* UPDATE */
	public function updatePenyimpananBarang($data, $id)
	{
		$this->db->set($data);
		$this->db->where('penyimpanan_id', $id);
		$this->db->update('material.material_penyimpanan');

		return $this->db->affected_rows();
	}
	/* UPDATE */

	/* DELETE */
	public function deletePenyimpananBarang($id)
	{
		$this->db->where('penyimpanan_id', $id);
		$this->db->delete('material.material_penyimpanan');

		return $this->db->affected_rows();
	}
	/* DELETE */

	/* RESET */
	public function resetPenyimpananBarang()
	{
		$this->db->where('penyimpanan_id !=', '');
		$this->db->delete('material.material_penyimpanan');

		return $this->db->affected_rows();
	}
	/* RESET */
	/* GET IMPORT */
	public function getImport($data = null)
	{
		$this->db->select('*');
		$this->db->from('import.import_material_jenis');
		if (isset($data['import_kode'])) $this->db->where('import_kode', $data['import_kode']);
		$sql = $this->db->get();

		return (isset($data['role_id'])) ? $sql->row_array() : $sql->result_array();
	}
	/* GET IMPORT */

	/* INSERT IMPORT */
	public function insertImport()
	{
		$insert = $this->db->insert_batch('import.import_material_jenis', $data);
		if ($insert) {
			return true;
		}
	}

	public function insertTable($data)
	{
		$this->db->query("INSERT INTO material.material_jenis SELECT jenis_id, null, jenis_nama, jenis_kode, when_create, who_create FROM import.import_material_jenis WHERE import_kode = '" . $data['import_kode'] . "' AND UPPER(jenis_nama) NOT IN (SELECT UPPER(jenis_nama) FROM material.material_jenis)");

		return $this->db->affected_rows();
	}
	/* INSERT IMPORT */

	/* DELETE TABLE */
	public function deleteTable($id)
	{
		$this->db->where('import_kode', $id);
		$this->db->delete('import.import_material_jenis');

		return $this->db->affected_rows();
	}
	/* DELETE TABLE */
}
