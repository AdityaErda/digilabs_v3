<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_sample_jenis extends CI_Model
{
	/* GET */
	public function getJenisSampleUJi($data = null)
	{
		$this->db->select('*');
		$this->db->from('sample.sample_jenis');
		if (isset($data['jenis_nama'])) $this->db->where("upper(jenis_nama) LIKE '%" . strtoupper($data['jenis_nama']) . "%'");
		if (isset($data['jenis_id'])) $this->db->where('jenis_id', $data['jenis_id']);
		$sql = $this->db->get();

		return (isset($data['jenis_id'])) ? $sql->row_array() : $sql->result_array();
	}
	/* GET */

	/* INSERT */
	public function insertJenisSampleUJi($data)
	{
		$this->db->insert('sample.sample_jenis', $data);

		return $this->db->affected_rows();
	}
	/* INSERT */

	/* UPDATE */
	public function updateJenisSampleUJi($data, $id)
	{
		$this->db->set($data);
		$this->db->where('jenis_id', $id);
		$this->db->update('sample.sample_jenis');

		return $this->db->affected_rows();
	}
	/* UPDATE */

	/* DELETE */
	public function deleteJenisSampleUJi($id)
	{
		$this->db->where('jenis_id', $id);
		$this->db->delete('sample.sample_jenis');

		return $this->db->affected_rows();
	}

	public function resetJenisSampleUJi()
	{
		$this->db->empty_table('sample.sample_jenis');

		return $this->db->affected_rows();
	}
	/* DELETE */

	/* GET DETAIL */
	public function getSampleIdentitas($data = null)
	{
		$this->db->select('*');
		$this->db->from('sample.sample_identitas');
		if (isset($data['identitas_nama'])) $this->db->where("upper(identitas_nama) LIKE '%" . strtoupper($data['identitas_nama']) . "%'");
		if (isset($data['jenis_id'])) $this->db->where('jenis_id', $data['jenis_id']);
		if (isset($data['identitas_id'])) $this->db->where('identitas_id', $data['identitas_id']);
		$sql = $this->db->get();

		return (isset($data['identitas_id'])) ? $sql->row_array() : $sql->result_array();
	}
	/* GET DETAIL */

	/* INSERT DETAIL */
	public function insertSampleIdentitas($data)
	{
		$this->db->insert('sample.sample_identitas', $data);

		return $this->db->affected_rows();
	}
	/* INSERT DETAIL */

	/* UPDATE DETAIL */
	public function updateSampleIdentitas($data, $id)
	{
		$this->db->set($data);
		$this->db->where('identitas_id', $id);
		$this->db->update('sample.sample_identitas');

		return $this->db->affected_rows();
	}
	/* UPDATE DETAIL */

	/* DELETE DETAIL */
	public function deleteSampleIdentitas($id)
	{
		$this->db->where('identitas_id', $id);
		$this->db->delete('sample.sample_identitas');

		return $this->db->affected_rows();
	}
	/* DELETE DETAIL */

	/* GET IMPORT */
	public function getImport($data = null)
	{
		$this->db->select('*');
		$this->db->from('import.import_sample_jenis');
		if (isset($data['import_kode'])) $this->db->where('import_kode', $data['import_kode']);
		$sql = $this->db->get();

		return (isset($data['jenis_id'])) ? $sql->row_array() : $sql->result_array();
	}
	/* GET IMPORT */

	/* INSERT IMPORT */
	public function insertImport()
	{
		$insert = $this->db->insert_batch('import.import_sample_jenis', $data);
		if ($insert) {
			return true;
		}
	}

	public function insertTable($data)
	{
		$this->db->query("INSERT INTO sample.sample_jenis SELECT jenis_id, null, jenis_nama, jenis_kode, when_create, who_create, jenis_parameter, pengambil_sample FROM import.import_sample_jenis WHERE import_kode = '" . $data['import_kode'] . "' AND UPPER(jenis_nama) NOT IN (SELECT UPPER(jenis_kode) FROM sample.sample_jenis) AND UPPER(jenis_kode) NOT IN (SELECT UPPER(jenis_nama) FROM sample.sample_jenis)");

		return $this->db->affected_rows();
	}
	/* INSERT IMPORT */

	/* DELETE TABLE */
	public function deleteTable($id)
	{
		$this->db->where('import_kode', $id);
		$this->db->delete('import.import_sample_jenis');

		return $this->db->affected_rows();
	}
	/* DELETE TABLE */

	/* GET IMPORT DETAIL */
	public function getImportIdentitas($data = null)
	{
		$this->db->select('a.*, b.jenis_id, b.jenis_nama');
		$this->db->from('import.import_sample_identitas a');
		$this->db->join('sample.sample_jenis b', 'a.jenis_id = b.jenis_id', 'left');
		if (isset($data['import_kode'])) $this->db->where('import_kode', $data['import_kode']);
		$sql = $this->db->get();

		return (isset($data['identitas_id'])) ? $sql->row_array() : $sql->result_array();
	}
	/* GET IMPORT DETAIL */

	/* INSERT IMPORT DETAIL */
	public function insertImportIdentitas()
	{
		$insert = $this->db->insert_batch('import.import_sample_identitas', $data);
		if ($insert) {
			return true;
		}
	}

	public function insertTableIdentitas($data)
	{
		$this->db->query("INSERT INTO sample.sample_identitas SELECT identitas_id, jenis_id, identitas_nama, identitas_parameter, identitas_harga, when_create, who_create FROM import.import_sample_identitas WHERE import_kode = '" . $data['import_kode'] . "' AND UPPER(identitas_nama) NOT IN (SELECT UPPER(identitas_nama) FROM sample.sample_identitas WHERE jenis_id = '" . $data['jenis_id'] . "')");

		return $this->db->affected_rows();
	}
	/* INSERT IMPORT DETAIL */

	/* DELETE TABLE DETAIL */
	public function deleteTableIdentitas($id)
	{
		$this->db->where('import_kode', $id);
		$this->db->delete('import.import_sample_identitas');

		return $this->db->affected_rows();
	}
	/* DELETE TABLE DETAIL */

	// UPDATE RUMUS
	public function updateRumus($id, $data = null)
	{
		$this->db->where('identitas_id', $id);
		$this->db->update('sample.sample_identitas', $data);

		return $this->db->affected_rows();
	}
	// UPDATE RUMUS

	// TAMBAHAN
	public function getPengambil($param = null)
	{
		$this->db->select('pengambil_sample');
		$this->db->distinct();
		$this->db->from('sample.sample_jenis');

		$this->db->order_by('pengambil_sample', 'asc');


		$sql = $this->db->get();

		return $sql->result_array();
	}
	// TAMBAHAN
}
