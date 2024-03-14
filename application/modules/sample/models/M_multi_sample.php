<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_multi_sample extends CI_Model
{
	public function getLogSheetGroup($param = '')
	{
		if (isset($param['transaksi_id'])) $this->db->where('id_transaksi', $param['transaksi_id']);
		if (isset($param['logsheet_multiple_id'])) $this->db->where('logsheet_multiple_id', $param['logsheet_multiple_id']);
		if (isset($param['transaksi_detail_id_group'])) $this->db->where_in('id_transaksi_detail', $param['transaksi_detail_id_group']);


		$this->db->select('logsheet_tgl_sampling,logsheet_tgl_terima,logsheet_tgl_uji,id_transaksi,logsheet_multiple_id,logsheet_asal_sample,logsheet_pengolah_sample,logsheet_analisis,logsheet_analisis_date,logsheet_review,logsheet_review_date,logsheet_jenis,logsheet_nomor_permintaan,is_kan,is_ds,id_template_footer,logsheet_keterangan,logsheet_peminta_jasa,logsheet_review_qr,logsheet_analisis_qr,is_approve,id_template_logsheet,logsheet_last_update,b.user_tanda_tangan as ttd_analisis,c.user_tanda_tangan as ttd_review,b.user_nama_lengkap as nama_analisis,c.user_nama_lengkap as nama_review');
		$this->db->distinct();
		$this->db->from('sample.sample_logsheet a');
		$this->db->join('global.global_user b', 'b.user_username = a.logsheet_analisis', 'left');
		$this->db->join('global.global_user c', 'c.user_username = a.logsheet_review', 'left');

		$sql = $this->db->get();

		return $sql->row_array();
	}

	function getLogsheet($param = '')
	{
		if (isset($param['transaksi_id'])) $this->db->where('a.transaksi_id', $param['transaksi_id']);
		if (isset($param['transaksi_detail_id'])) $this->db->where('a.transaksi_detail_id', $param['transaksi_detail_id']);
		if (isset($param['transaksi_detail_status'])) $this->db->where('transaksi_detail_status', $param['transaksi_detail_status']);
		if (isset($param['transaksi_non_rutin_id'])) $this->db->where('id_transaksi_non_rutin', $param['transaksi_non_rutin_id']);
		if (isset($param['logsheet_multiple_id'])) $this->db->where('logsheet_multiple_id', $param['logsheet_multiple_id']);

		$this->db->select('*');
		$this->db->from('sample.sample_transaksi_detail a');
		$this->db->join('sample.sample_jenis b', 'b.jenis_id = a.jenis_id', 'left');
		$this->db->join('sample.sample_transaksi c ', 'c.transaksi_id = a.transaksi_id', 'left');
		$this->db->join('sample.sample_logsheet d', 'd.id_transaksi = a.transaksi_id', 'left');
		// $this->db->join('sample.sample_logsheet_detail e', 'e.logsheet_id = d.logsheet_id', 'left');

		$this->db->where("is_proses is null");
		$this->db->order_by('transaksi_detail_judul', 'ASC');
		$this->db->order_by('logsheet_nomor_sample', 'ASC');


		$sql = $this->db->get();

		return $sql->result_array();
	}

	function getLogsheetDetail($param = '')
	{
		if (isset($param['logsheet_id'])) $this->db->where('logsheet_id', $param['logsheet_id']);
		if (isset($param['rumus_id'])) $this->db->where('rumus_id', $param['rumus_id']);

		$this->db->select('*');
		$this->db->from('sample.sample_logsheet_detail');
		$sql = $this->db->get();
		return $sql->result_array();
	}

	public function getDataSample($param = '', $where = '')
	{

		$this->db->select('a.transaksi_tgl,a.transaksi_nomor,a.transaksi_tipe,a.transaksi_status,b.peminta_jasa_nama,a.transaksi_id,is_proses,peminta_jasa_nama');
		$this->db->distinct();
		$this->db->from('sample.sample_transaksi a');
		$this->db->join('sample.sample_peminta_jasa b', 'b.peminta_jasa_id=transaksi_id_peminta_jasa', 'left');
		$this->db->join('sample.sample_transaksi_detail c', 'c.transaksi_id = a.transaksi_id', 'left');
		$this->db->join('sample.sample_logsheet i', 'i.id_transaksi = a.transaksi_id AND i.id_transaksi_detail = c.transaksi_detail_id', 'left');

		if (isset($where)) $this->db->where($where);

		if (isset($param['transaksi_status'])) $this->db->where('transaksi_status', $param['transaksi_status']);
		if (isset($param['status'])) $this->db->where('transaksi_detail_status', $param['status']);


		if (isset($param['tanggal_cari_awal'])) $this->db->where("transaksi_tgl >= '" . $param['tanggal_cari_awal'] . "'");
		if (isset($param['tanggal_cari_akhir'])) $this->db->where("transaksi_tgl >= '" . $param['tanggal_cari_akhir'] . "'");


		$this->db->where("transaksi_tipe != 'R'");
		$this->db->where("(is_proses != 'y' or is_proses is null)");

		$this->db->where("(id_transaksi_rutin = '' OR id_transaksi_rutin is NULL)");
		// $this->db->group_by('transaksi_detail_status,a.transaksi_id,b.peminta_jasa_id,c.transaksi_detail_id');

		$this->db->order_by('transaksi_nomor', 'asc');
		$this->db->order_by('transaksi_tgl', 'desc');

		$sql = $this->db->get();

		return isset($param['transaksi_id']) ? $sql->row_array() : $sql->result_array();
	}

	public function getIdentitas($param = '')
	{
		if (isset($param['transaksi_detail_status'])) $this->db->where('transaksi_detail_status', $param['transaksi_detail_status']);
		if (isset($param['transaksi_id'])) $this->db->where('transaksi_id', $param['transaksi_id']);
		$this->db->where("is_proses is null");
		$this->db->select('*');
		$this->db->from('sample.sample_transaksi_detail a');
		$this->db->join('sample.sample_jenis b', 'b.jenis_id = a.jenis_id', 'left');
		$this->db->join('sample.sample_pekerjaan c', 'c.sample_pekerjaan_id = a.jenis_pekerjaan_id', 'left');
		$this->db->order_by('transaksi_detail_judul', 'ASC');

		$sql = $this->db->get();

		return $sql->result_array();
	}

	public function getDetailSample($param = '')
	{
		if (isset($param['transaksi_id'])) $this->db->where('a.transaksi_id', $param['transaksi_id']);
		if (isset($param['transaksi_detail_status'])) $this->db->where('transaksi_detail_status', $param['transaksi_detail_status']);
		if (isset($param['id_jenis'])) $this->db->where('b.jenis_id', $param['id_jenis']);
		if (isset($param['transaksi_detail_group'])) $this->db->where('b.transaksi_detail_group', $param['transaksi_detail_group']);

		$this->db->select("a.transaksi_id, a.transaksi_tipe, a.transaksi_status, a.transaksi_nomor, b.*, c.jenis_nama, d.peminta_jasa_nama, e.sample_pekerjaan_nama, a.transaksi_tgl, f.identitas_nama, to_char(transaksi_detail_tgl_pengajuan, 'DD-MM-YYYY HH24:MI:SS') AS transaksi_detail_tgl_pengajuan_baru, to_char(transaksi_detail_tgl_memo, 'DD-MM-YYYY') AS transaksi_detail_tgl_memo_baru, to_char(transaksi_detail_tgl_estimasi, 'DD-MM-YYYY HH24:MI:SS') AS transaksi_detail_tgl_estimasi_baru,a.transaksi_id_template_keterangan,g.*,h.*,i.logsheet_id,i.id_template_logsheet,i.logsheet_multiple_id,transaksi_detail_group,is_approve,logsheet_analisis,logsheet_review");
		$this->db->from('sample.sample_transaksi a');
		$this->db->join('sample.sample_transaksi_detail b', 'a.transaksi_id = b.transaksi_id', 'left');
		$this->db->join('sample.sample_jenis c', 'c.jenis_id = b.jenis_id', 'left');
		$this->db->join('sample.sample_peminta_jasa d', 'd.peminta_jasa_id = b.peminta_jasa_id', 'left');
		$this->db->join('sample.sample_pekerjaan e', 'e.sample_pekerjaan_id = b.jenis_pekerjaan_id', 'left');
		$this->db->join('sample.sample_identitas f', 'f.identitas_id = b.identitas_id', 'left');
		$this->db->join('sample.sample_transaksi_keterangan g', 'g.transaksi_keterangan_id = a.transaksi_id_template_keterangan', 'left');
		$this->db->join('sample.sample_template_keterangan h', 'h.template_keterangan_id = g.transaksi_id_template', 'left');
		$this->db->join('sample.sample_logsheet i', 'i.id_transaksi = a.transaksi_id AND i.id_transaksi_detail = b.transaksi_detail_id', 'left');


		$this->db->where("transaksi_tipe != 'R'");
		$this->db->where("(is_proses is null)");

		$this->db->order_by('transaksi_detail_nomor_sample', 'asc');

		$sql = $this->db->get();

		return $sql->result_array();
	}

	function getMultiDetail($param = '')
	{
		if (isset($param['transaksi_id'])) $this->db->where('a.transaksi_id', $param['transaksi_id']);
		if (isset($param['transaksi_detail_status'])) $this->db->where('transaksi_detail_status', $param['transaksi_detail_status']);
		if (isset($param['transaksi_non_rutin_id'])) $this->db->where('id_transaksi_non_rutin', $param['transaksi_non_rutin_id']);
		if (isset($param['transaksi_detail_group'])) $this->db->where('transaksi_detail_group', $param['transaksi_detail_group']);

		$this->db->select('*');
		// $this->db->distinct();
		$this->db->from('sample.sample_transaksi_detail a');
		$this->db->join('sample.sample_jenis b', 'b.jenis_id = a.jenis_id', 'left');
		$this->db->join('sample.sample_transaksi c ', 'c.transaksi_id = a.transaksi_id', 'left');
		// $this->db->join('sample.sample_logsheet d', 'd.multiple_logsheet_id = a.transaksi_detail_group AND d.id_transaksi=b.transaksi_id', 'left');


		$this->db->where("is_proses is null");
		$this->db->order_by('transaksi_detail_judul', 'ASC');

		$sql = $this->db->get();

		return $sql->result_array();
	}

	function getMultiDetailLogsheet($param = '')
	{
		if (isset($param['transaksi_id'])) $this->db->where('a.transaksi_id', $param['transaksi_id']);
		if (isset($param['transaksi_detail_status'])) $this->db->where('transaksi_detail_status', $param['transaksi_detail_status']);
		if (isset($param['transaksi_non_rutin_id'])) $this->db->where('id_transaksi_non_rutin', $param['transaksi_non_rutin_id']);
		if (isset($param['transaksi_detail_group'])) $this->db->where('transaksi_detail_group', $param['transaksi_detail_group']);

		$this->db->select('*');
		// $this->db->distinct();
		$this->db->from('sample.sample_transaksi_detail a');
		$this->db->join('sample.sample_jenis b', 'b.jenis_id = a.jenis_id', 'left');
		$this->db->join('sample.sample_transaksi c ', 'c.transaksi_id = a.transaksi_id', 'left');
		$this->db->join('sample.sample_logsheet d', 'd.logsheet_multiple_id = a.transaksi_detail_group AND d.id_transaksi_detail = a.transaksi_detail_id', 'left');


		$this->db->where("is_proses is null");
		$this->db->order_by('transaksi_detail_judul', 'ASC');
		$this->db->order_by('logsheet_nomor_sample', 'ASC');


		$sql = $this->db->get();

		return $sql->result_array();
	}

	public function getMultiSampleGroup($param = '')
	{
		if (isset($param['transaksi_non_rutin_id'])) $this->db->where('a.id_non_rutin', $param['transaksi_non_rutin_id']);
		if (isset($param['transaksi_id'])) $this->db->where('a.transaksi_id', $param['transaksi_id']);
		if (isset($param['transaksi_detail_id'])) $this->db->where('transaksi_detail_id', $param['transaksi_detail_id']);
		if (isset($param['transaksi_detail_id_multiple'])) $this->db->where_in('transaksi_detail_id', $param['transaksi_detail_id_multiple']);
		if (isset($param['transaksi_detail_group'])) $this->db->where('transaksi_detail_group', $param['transaksi_detail_group']);
		if (isset($param['transaksi_detail_id_group'])) $this->db->where_in('transaksi_detail_id', $param['transaksi_detail_id_group']);

		$this->db->select("a.jenis_id,a.transaksi_id,transaksi_detail_status,b.jenis_nama,id_transaksi_non_rutin,logsheet_asal_sample,to_char(logsheet_tgl_terima, 'DD-MM-YYYY') AS logsheet_tgl_terima,to_char(logsheet_tgl_uji, 'DD-MM-YYYY') AS logsheet_tgl_uji,logsheet_pengolah_sample,transaksi_tipe,logsheet_file_excel");
		$this->db->distinct();
		$this->db->from('sample.sample_transaksi_detail a');
		$this->db->join('sample.sample_jenis b', 'b.jenis_id = a.jenis_id', 'left');
		$this->db->join('sample.sample_pekerjaan c', 'c.sample_pekerjaan_id = a.jenis_pekerjaan_id', 'left');
		$this->db->join('sample.sample_transaksi d', 'd.transaksi_id = a.transaksi_id', 'left');
		$this->db->join('sample.sample_logsheet e', 'e.logsheet_multiple_id = a.transaksi_detail_group', 'left');


		$this->db->where("(is_proses IS NULL)");
		$sql = $this->db->get();
		return $sql->row_array();
	}

	function getMultiDetailHasil($param = '')
	{
		$this->db->select('*');
		$this->db->distinct();
		$this->db->from('sample.sample_logsheet a');
		$this->db->join('sample.sample_logsheet_detail b', 'b.logsheet_id = a.logsheet_id', 'left');
		$this->db->join('sample.sample_transaksi_detail c', 'c.transaksi_detail_id = a.id_transaksi_detail', 'left');
		$this->db->join('sample.sample_jenis d', 'd.jenis_id = c.jenis_id', 'left');
		$this->db->join(' sample.sample_perhitungan_sample e', 'e.rumus_id = b.id_rumus', 'left');

		if (isset($param['transaksi_id'])) $this->db->where('transaksi_id', $param['transaksi_id']);
		if (isset($param['logsheet_multiple_id'])) $this->db->where('logsheet_multiple_id', $param['logsheet_multiple_id']);
		$this->db->where("(is_proses != 'y' or is_proses is null)");

		$this->db->order_by('transaksi_detail_judul', 'ASC');
		$this->db->order_by('logsheet_nomor_sample', 'asc');
		$this->db->order_by('logsheet_detail_urut', 'asc');

		$sql = $this->db->get();

		return $sql->result_array();
	}

	function insertLogsheetMultiple($param)
	{
		$this->db->insert('sample.sample_logsheet_multiple', $param);
		$this->db->affected_rows();
	}

	public function cekLogsheet($param = null)
	{
		if (isset($param['logsheet_multiple_id'])) $this->db->where('logsheet_multiple_id', $param['logsheet_multiple_id']);
		$this->db->select('*');
		$this->db->from('sample.sample_logsheet');
		$sql = $this->db->get();
		if ($sql) {
			return $sql->result_array();
		} else {
			return false;
		}
	}
}

/* End of file M_multi_sample.php */
/* Location: ./application/modules/sample/models/M_multi_sample.php */