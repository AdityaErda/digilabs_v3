<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_cek_sample extends CI_Model
{
	/* GET */
	public function getTemplateLogsheet($data = null)
	{
		$this->db->select('*');
		$this->db->from('sample.sample_template_logsheet a');
		$this->db->join('sample.sample_cek_sample b', 'b.id_template_logsheet = a.template_logsheet_id', 'left');

		if (isset($data['param_search'])) $this->db->wher("upper(jenis_nama) LIKE '%" . strtoupper($data['param_search']) . "%'");
		if (isset($data['template_logsheet_id'])) $this->db->where('template_logsheet_id', $data['template_logsheet_id']);
		if (isset($data['template_logsheet_id_multiple'])) $this->db->where_in('template_logsheet_id', $data['template_logsheet_id_multiple']);
		$this->db->where("(b.is_lama != 'y' or b.is_lama is null)");

		$sql = $this->db->get();

		return (isset($data['template_logsheet_id'])) ? $sql->row_array() : $sql->result_array();
	}

	public function getSample($param = null)
	{
		if (isset($param['cek_sample_id'])) $this->db->where('cek_sample_id', $param['cek_sample_id']);
		$this->db->where("(is_lama != 'y' or is_lama is null)");
		$this->db->select('*');
		$this->db->from('sample.sample_cek_sample');
		$q = $this->db->get();
		if ($q) {
			return $q->row_array();
		} else {
			return false;
		}
	}

	public function getSampleDetail($par = null)
	{
		if (!empty($par['rumus_id'])) $this->db->where('id_rumus', $par['rumus_id']);
		if (!empty($par['cek_sample_id'])) $this->db->where('a.cek_sample_id', $par['cek_sample_id']);
		$this->db->where('is_lama', 'n');

		$this->db->select('*');
		$this->db->from('sample.sample_cek_sample_detail a');
		$this->db->order_by('cek_sample_detail_urut', 'asc');

		$query = $this->db->get();
		return $query->result_array();
	}

	public function getSampleDetailDetail($par = null)
	{
		if (!empty($par['cek_sample_detail_id'])) $this->db->where('cek_sample_detail_id', $par['cek_sample_detail_id']);
		$this->db->where('a.is_lama', 'n');
		$this->db->where('b.is_lama', 'n');
		// $this->db->where('rumus_jenis', 'I');
		$this->db->select('*');
		$this->db->from('sample.sample_cek_sample_detail a');
		$this->db->join('sample.sample_cek_sample_detail_detail b', 'b.id_cek_sample_detail = a.cek_sample_detail_id', 'left');
		$this->db->order_by('rumus_detail_urut', 'asc');

		$query = $this->db->get();
		return $query->result_array();
	}


	/* GET */

	/* INSERT */
	public function insertCekSample($data = null)
	{
		$this->db->insert('sample.sample_cek_sample', $data);
		return $this->db->affected_rows();
	}

	public function insertCekSampleDetail($data = null)
	{
		$this->db->insert('sample.sample_cek_sample_detail', $data);
		return $this->db->affected_rows();
	}

	public function insertCekSampleDetailDetail($data = null)
	{
		$this->db->insert('sample.sample_cek_sample_detail_detail', $data);
		return $this->db->affected_rows();
	}
	/* INSERT */

	/* UPDATE */
	public function updateTemplateLogsheet($data, $id)
	{
		$this->db->set($data);
		$this->db->where('template_logsheet_id', $id);
		$this->db->update('sample.sample_template_logsheet');

		return $this->db->affected_rows();
	}
	/* UPDATE */

	/* DELETE */
	public function deleteTemplateLogsheet($id)
	{
		$this->db->where('template_logsheet_id', $id);
		$this->db->delete('sample.sample_template_logsheet');

		return $this->db->affected_rows();
	}

	public function resetTemplateLogsheet()
	{
		$this->db->empty_table('sample.sample_template_logsheet');

		return $this->db->affected_rows();
	}
	/* DELETE */


	/* GET DETAIL */
	public function getDetailLogsheet($data = null)
	{
		$this->db->select('a.*, b.rumus_id, b.rumus_nama, b.is_adbk, b.satuan_sample, b.desimal_angka, b.batasan_emisi,b.metode');
		$this->db->from('sample.sample_template_logsheet_detail a');
		$this->db->join('sample.sample_perhitungan_sample b', 'a.logsheet_nama_rumus = b.rumus_id', 'left');

		if (isset($data['logsheet_nama_rumus'])) $this->db->where("upper(logsheet_nama_rumus) LIKE '%" . strtoupper($data['logsheet_nama_rumus']) . "%'");
		if (isset($data['id_logsheet_template'])) $this->db->where('id_logsheet_template', $data['id_logsheet_template']);
		if (isset($data['template_logsheet_id_multiple'])) $this->db->where_in('id_logsheet_template', $data['template_logsheet_id_multiple']);
		if (isset($data['template_logsheet_detail_id'])) $this->db->where('template_logsheet_detail_id', $data['template_logsheet_detail_id']);
		if (isset($data['rumus_id'])) $this->db->where('rumus_id', $data['rumus_id']);
		if (isset($data['jenis_id'])) $this->db->where('jenis_id', $data['jenis_id']);
		// if (isset($data['satuan_sample'])) $this->db->where('satuan_sample', $data['satuan_sample']);

		$this->db->order_by('detail_logsheet_urut', 'ASC');
		$sql = $this->db->get();

		return (isset($data['template_logsheet_detail_id'])) ? $sql->row_array() : $sql->result_array();
	}

	public function getMasterRumus($data = null)
	{
		$this->db->select('a.*, b.jenis_id, b.jenis_nama');
		$this->db->from('sample.sample_perhitungan_sample a');
		$this->db->join('sample.sample_jenis b', 'a.jenis_id = b.jenis_id', 'left');

		if (isset($data['rumus_nama'])) $this->db->where("upper(rumus_nama) LIKE '%" . strtoupper($data['rumus_nama']) . "%'");
		if (isset($data['rumus_id'])) $this->db->where('rumus_id', $data['rumus_id']);
		$sql = $this->db->get();

		return (isset($data['rumus_id'])) ? $sql->row_array() : $sql->result_array();
	}
	/* GET DETAIL */

	/* INSERT DETAIL */
	public function insertTemplateLogsheetDetail($data)
	{
		$this->db->insert('sample.sample_template_logsheet_detail', $data);

		return $this->db->affected_rows();
	}
	/* INSERT DETAIL */

	/* UPDATE DETAIL */
	public function updateTemplateLogsheetDetail($data, $id)
	{
		$this->db->set($data);
		$this->db->where('template_logsheet_detail_id', $id);
		$this->db->update('sample.sample_template_logsheet_detail');

		return $this->db->affected_rows();
	}
	/* UPDATE DETAIL */

	/* DELETE DETAIL */
	public function deleteTemplateLogsheetDetail($id)
	{
		$this->db->where('template_logsheet_detail_id', $id);
		$this->db->delete('sample.sample_template_logsheet_detail');

		return $this->db->affected_rows();
	}

	/* DELETE DETAIL */

	/* GET LOG SHEET */
	public function getListRumus($data = null)
	{
		$this->db->select('*');
		$this->db->from('sample.sample_perhitungan_sample_detail a');
		$this->db->join('sample.sample_perhitungan_sample b', 'a.rumus_id = b.id_rumus', 'left');
		if (isset($data['rumus_detail_input'])) $this->db->where("upper(rumus_detail_input) LIKE '%" . strtoupper($data['rumus_detail_input']) . "%'");
		$this->db->where('id_rumus = ', $data['id_rumus']);
		$sql = $this->db->get();

		return $sql->result_array();
	}
	/* GET LOG SHEET */
}
