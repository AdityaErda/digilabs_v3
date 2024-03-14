<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_material_item extends CI_Model
{
	/* GET */
	public function getBarangMaterial($data = null)
	{
		$this->db->select('a.*, b.jenis_id, b.jenis_nama, c.gl_account_id, c.gl_account_nama');
		$this->db->from('material.material_item a');
		$this->db->join('material.material_jenis b', 'a.jenis_id = b.jenis_id', 'left');
		$this->db->join('material.material_gl_account c', 'a.gl_account_id = c.gl_account_id', 'left');
		if (isset($data['item_id'])) $this->db->where('item_id', $data['item_id']);
		if (isset($data['item_nama'])) $this->db->where("UPPER(item_nama) like '%" . strtoupper($data['item_nama']) . "%'");
		$sql = $this->db->get();

		return (isset($data['item_id'])) ? $sql->row_array() : $sql->result_array();
	}
	/* GET */

	/* INSERT */
	public function insertBarangMaterial($data)
	{
		$this->db->insert('material.material_item', $data);

		return $this->db->affected_rows();
	}
	/* INSERT */

	/* UPDATE */
	public function updateBarangMaterial($data, $id)
	{
		$this->db->set($data);
		$this->db->where('item_id', $id);
		$this->db->update('material.material_item');

		return $this->db->affected_rows();
	}
	/* UPDATE */

	/* DELETE */
	public function deleteBarangMaterial($id)
	{
		$this->db->where('item_id', $id);
		$this->db->delete('material.material_item');

		return $this->db->affected_rows();
	}
	/* DELETE */

	/* DELETE */
	public function resetBarangMaterial()
	{
		$this->db->where('item_id !=', '');
		$this->db->delete('material.material_item');
		return $this->db->affected_rows();
	}
	/* DELETE */

	/* GET HISTORY */
	public function getHistory($data = null)
	{
		$this->db->select('log_when, log_who, barang_id, barang_harga');
		$this->db->from('global.global_dblog');
		if (isset($data['item_id'])) $this->db->where('barang_id', $data['item_id']);
		$this->db->order_by('log_when', 'asc');
		$sql = $this->db->get();

		return $sql->result_array();
	}
	/* GET HISTORY */

	/* GET DETAIL */
	public function getKomposisi($data = null)
	{
		$this->db->select('a.*, b.item_nama, b.item_harga, c.item_nama AS nama_item, c.item_harga AS harga_item');
		$this->db->from('material.material_komposisi a');
		$this->db->join('material.material_item b', 'a.item_id = b.item_id', 'left');
		$this->db->join('material.material_item c', 'a.komposisi_item = c.item_id', 'left');
		if (isset($data['komposisi_id'])) $this->db->where('komposisi_id', $data['komposisi_id']);
		if (isset($data['item_id'])) $this->db->where('a.item_id', $data['item_id']);
		if (isset($data['komposisi_item'])) $this->db->where('a.komposisi_item', $data['komposisi_item']);
		$sql = $this->db->get();

		return (isset($data['komposisi_id'])) ? $sql->row_array() : $sql->result_array();
	}

	public function getSumKomposisi($data = null)
	{
		$this->db->select('SUM(a.komposisi_harga) AS total');
		$this->db->from('material.material_komposisi a');
		if (isset($data['item_id'])) $this->db->where('a.item_id', $data['item_id']);
		$sql = $this->db->get();

		return $sql->row_array();
	}
	/* GET DETAIL */

	/* INSERT DETAIL */
	public function insertKomposisi($data)
	{
		$this->db->insert('material.material_komposisi', $data);

		return $this->db->affected_rows();
	}
	/* INSERT DETAIL */

	/* UPDATE DETAIL */
	public function updateKomposisi($data, $id)
	{
		$this->db->set($data);
		$this->db->where('komposisi_id', $id);
		$this->db->update('material.material_komposisi');

		return $this->db->affected_rows();
	}
	/* UPDATE DETAIL */

	/* DELETE DETAIL */
	public function deleteKomposisi($id)
	{
		$this->db->where('komposisi_id', $id);
		$this->db->delete('material.material_komposisi');

		return $this->db->affected_rows();
	}
	/* DELETE DETAIL */

	/* GET IMPORT */
	public function getImport($data = null)
	{
		$this->db->select('a.*, b.jenis_nama, c.gl_account_nama');
		$this->db->from('import.import_material_item a');
		$this->db->join('material.material_jenis b', 'a.jenis_id = b.jenis_id', 'left');
		$this->db->join('material.material_gl_account c', 'a.gl_account_id = c.gl_account_id', 'left');
		if (isset($data['import_kode'])) $this->db->where('import_kode', $data['import_kode']);
		$sql = $this->db->get();

		return (isset($data['item_id'])) ? $sql->row_array() : $sql->result_array();
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
		$this->db->query("INSERT INTO material.material_item SELECT item_id, company_code, jenis_id, gl_account_id, item_nama, item_kode, item_harga, item_stok, item_tgl_expired, when_create, who_create, item_katalog_number, item_merk, item_satuan, item_stok_alert FROM import.import_material_item WHERE import_kode = '" . $data['import_kode'] . "' AND UPPER(item_nama) NOT IN (SELECT UPPER(item_nama) FROM material.material_item)");

		return $this->db->affected_rows();
	}
	/* INSERT IMPORT */

	/* DELETE TABLE */
	public function deleteTable($id)
	{
		$this->db->where('import_kode', $id);
		$this->db->delete('import.import_material_item');

		return $this->db->affected_rows();
	}
	/* DELETE TABLE */
}
