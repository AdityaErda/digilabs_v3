<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_nomor extends CI_Model
{
	public function getNomor($data = null, $where = null)
	{
		$this->db->select("a.*, to_char(transaksi_rutin_tgl, 'DD-MM-YYYY HH24:MI:SS') AS transaksi_rutin_tgl_baru, SUM(CAST(c.transaksi_detail_status as int)) AS status,c.transaksi_detail_status");
		$this->db->from('sample.sample_transaksi_rutin a');
		$this->db->join('sample.sample_transaksi b', 'a.transaksi_rutin_id = b.id_transaksi_rutin', 'left');
		$this->db->join('sample.sample_transaksi_detail c', 'b.id_transaksi_detail = c.transaksi_detail_id', 'left');
		if ($data['transaksi_detail_status'] != '-') {
			$this->db->where('transaksi_detail_status', $data['transaksi_detail_status']);
		}
		if (!empty($where))
			$this->db->where($where);
		// if (isset($data['transaksi_detail_status']))
		if (isset($data['tanggal_cari_awal']))
			$this->db->where('DATE(transaksi_rutin_tgl) >= ', $data['tanggal_cari_awal']);
		if (isset($data['tanggal_cari_akhir']))
			$this->db->where('DATE(transaksi_rutin_tgl) <= ', $data['tanggal_cari_akhir']);
		$this->db->where("(a.who_seksi_create = '" . $data['seksi_id'] . "' OR '1' = '" . $data['role_id'] . "')");
		$this->db->where('transaksi_detail_status != ', '8');
		$this->db->where('transaksi_detail_status != ', '18');
		$this->db->order_by('transaksi_rutin_tgl', 'desc');
		$this->db->group_by('a.transaksi_rutin_id');
		$this->db->group_by('c.transaksi_detail_status');
		$sql = $this->db->get();

		return $sql->result_array();
	}

	public function getNomorAuto($data = null, $where = null)
	{
		$this->db->select("a.*, to_char(transaksi_rutin_tgl, 'DD-MM-YYYY HH24:MI:SS') AS transaksi_rutin_tgl_baru, SUM(CAST(c.transaksi_detail_status as int)) AS status,c.transaksi_detail_status");
		$this->db->from('sample.sample_transaksi_rutin a');
		$this->db->join('sample.sample_transaksi b', 'a.transaksi_rutin_id = b.id_transaksi_rutin', 'left');
		$this->db->join('sample.sample_transaksi_detail c', 'b.id_transaksi_detail = c.transaksi_detail_id', 'left');
		if ($data['transaksi_detail_status'] != '-') {
			$this->db->where('transaksi_detail_status', $data['transaksi_detail_status']);
		}
		if (!empty($where))
			$this->db->where($where);
		if (isset($data['tanggal_cari_awal']))
			$this->db->where('DATE(transaksi_rutin_tgl) >= ', $data['tanggal_cari_awal']);
		if (isset($data['tanggal_cari_akhir']))
			$this->db->where('DATE(transaksi_rutin_tgl) <= ', $data['tanggal_cari_akhir']);
		$this->db->where("(a.who_seksi_create = '" . $data['seksi_id'] . "' OR '1' = '" . $data['role_id'] . "' OR a.who_seksi_create = '-')");
		$this->db->order_by('transaksi_rutin_tgl', 'desc');
		$this->db->group_by('a.transaksi_rutin_id');
		$this->db->group_by('c.transaksi_detail_status');
		$sql = $this->db->get();

		return $sql->result_array();
	}

	public function getNomorById($data = null, $where = null)
	{
		// $this->db->select('a.*,b.when_create,b.who_create,b.transaksi_nomor,c.peminta_jasa_id,c.jenis_id,c.jenis_pekerjaan_id');

		$this->db->select("a.*, to_char(transaksi_rutin_tgl, 'DD-MM-YYYY HH24:MI:SS') AS transaksi_rutin_tgl_baru, SUM(CAST(c.transaksi_detail_status as int)) AS status");
		$this->db->from('sample.sample_transaksi_rutin a');
		$this->db->join('sample.sample_transaksi b', 'a.transaksi_rutin_id = b.id_transaksi_rutin', 'left');
		$this->db->join('sample.sample_transaksi_detail c', 'b.id_transaksi_detail = c.transaksi_detail_id', 'left');
		// $this->db->join('sample.sample_jenis d', 'd.jenis_id = c.jenis_id', 'left');
		// $this->db->join('sample.sample_peminta_jasa e', 'e.peminta_jasa_id = c.peminta_jasa_id', 'left');
		// $this->db->join('sample.sample_pekerjaan f', 'f.sample_pekerjaan_id = c.jenis_pekerjaan_id', 'left');
		// $this->db->join('sample.sample_identitas g', 'g.identitas_id = c.identitas_id', 'left');

		if ($data['transaksi_detail_status'] != '-') {
			$this->db->where('transaksi_detail_status', $data['transaksi_detail_status']);
		}
		if (!empty($where))
			$this->db->where($where);
		// if (isset($data['transaksi_detail_status']))
		if (isset($data['tanggal_cari_awal']))
			$this->db->where('DATE(transaksi_rutin_tgl) >= ', $data['tanggal_cari_awal']);
		if (isset($data['tanggal_cari_akhir']))
			$this->db->where('DATE(transaksi_rutin_tgl) <= ', $data['tanggal_cari_akhir']);
		$this->db->where('transaksi_rutin_id', $data['transaksi_rutin_id']);
		$this->db->where("(a.who_seksi_create = '" . $data['seksi_id'] . "' OR '1' = '" . $data['role_id'] . "')");
		$this->db->where('transaksi_detail_status != ', '8');
		$this->db->order_by('transaksi_rutin_tgl', 'desc');
		$this->db->group_by('a.transaksi_rutin_id');
		$sql = $this->db->get();

		return $sql->row_array();
	}

	public function getNomorAll($param = null)
	{
		if (isset($param['transaksi_rutin_id']))
			$this->db->where('a.id_transaksi_rutin', $param['transaksi_rutin_id']);

		$this->db->select('a.transaksi_id,a.id_transaksi_rutin, a.transaksi_tipe, b.transaksi_detail_id,b.jenis_id, b.jenis_id, a.transaksi_nomor, c.peminta_jasa_nama,b.identitas_id,b.transaksi_detail_nomor');
		$this->db->from('sample.sample_transaksi a');
		$this->db->join('sample.sample_transaksi_detail b', 'b.transaksi_detail_id = a.id_transaksi_detail', 'left');
		$this->db->join('sample.sample_peminta_jasa c', 'c.peminta_jasa_id = b.peminta_jasa_id', 'left');

		$this->db->order_by('jenis_id', 'asc');
		$this->db->order_by("CAST(transaksi_nomor as INT) ASC");


		$sql = $this->db->get();

		return $sql->result_array();
	}


	public function getRumusAll($param = null)
	{
		if (isset($param['jenis_id']))
			$this->db->where('jenis_id', $param['jenis_id']);

		$this->db->select('*');
		$this->db->from('sample.sample_perhitungan_multiple a');
		$this->db->join('sample.sample_detail_multiple b', 'b.id_multiple_rumus = a.multiple_rumus_id', 'right');

		$sql = $this->db->get();

		return $sql->result_array();
	}

	public function getLogsheetGroup($param = null)
	{
		if (isset($param['transaksi_rutin_id']))
			$this->db->where('id_nomor_rutin', $param['transaksi_rutin_id']);

		$this->db->select('logsheet_tgl_uji,logsheet_tgl_sampling,logsheet_tgl_terima,logsheet_asal_sample,logsheet_pengolah_sample,logsheet_analisis,logsheet_review
			,logsheet_analisis_date,logsheet_review_date,logsheet_last_update,logsheet_analisis_qr,logsheet_review_qr,is_approve,id_template_footer,id_dokumen_tipe,id_dokumen_template,dokumen_template_file,id_nomor_rutin');
		$this->db->distinct();

		$this->db->from('sample.sample_logsheet');

		$sql = $this->db->get();

		return $sql->row_array();
	}

	public function getLogsheet($param = null)
	{
		if (isset($param['transaksi_rutin_id']))
			$this->db->where('id_nomor_rutin', $param['transaksi_rutin_id']);

		$this->db->order_by('transaksi_nomor', 'asc');


		$this->db->select('*');
		$this->db->from('sample.sample_logsheet a');
		$this->db->join('sample.sample_transaksi b', 'b.id_transaksi_rutin = a.id_nomor_rutin AND a.id_transaksi = b.transaksi_id', 'left');
		$this->db->join('sample.sample_transaksi_detail c', 'c.transaksi_detail_id = b.id_transaksi_detail', 'left');

		$sql = $this->db->get();

		return $sql->result_array();
	}

	public function getLogsheetGroupIdentitas($param = null)
	{
		if (isset($param['transaksi_rutin_id']))
			$this->db->where('id_nomor_rutin', $param['transaksi_rutin_id']);
		// $this->db->order_by('transaksi_nomor', 'asc');
		// $this->db->order_by('parameter_rumus', 'asc');
		// $this->db->order_by('a.logsheet_id', 'asc');

		$this->db->distinct();
		$this->db->select('parameter_rumus,id_rumus');
		$this->db->from('sample.sample_logsheet a');
		$this->db->join('sample.sample_transaksi b', 'b.id_transaksi_rutin = a.id_nomor_rutin AND a.id_transaksi = b.transaksi_id', 'left');
		$this->db->join('sample.sample_transaksi_detail c', 'c.transaksi_detail_id = b.id_transaksi_detail', 'left');
		$this->db->join('sample.sample_logsheet_detail d', 'd.logsheet_id = a.logsheet_id', 'left');
		$this->db->join('sample.sample_detail_multiple e', 'd.id_rumus = e.detail_multiple_rumus_id', 'left');

		$sql = $this->db->get();

		return $sql->result_array();
	}

	public function getLogsheetDetail($param = null)
	{
		if (isset($param['logsheet_id'])) $this->db->where('logsheet_id', $param['logsheet_id']);

		$this->db->order_by('logsheet_detail_urut', 'asc');

		$this->db->select('a.*,b.*');
		$this->db->from('sample.sample_logsheet_detail a');
		$this->db->join('sample.sample_detail_multiple b', 'a.id_rumus = b.detail_multiple_rumus_id', 'left');

		$sql = $this->db->get();

		if ($sql) {
			return $sql->result_array();
		} else {
			return false;
		}
	}

	public function getLogsheetDetailDetail($param = null)
	{
		if (isset($param['logsheet_detail_id'])) $this->db->where('id_logsheet_detail', $param['logsheet_detail_id']);
		if (isset($param['logsheet_id'])) $this->db->where('id_logsheet', $param['logsheet_id']);
		if (isset($param['rumus_id'])) $this->db->where('id_rumus', $param['rumus_id']);

		$this->db->order_by('b.rumus_detail_urut', 'asc');

		$this->db->select("a.*,b.*,b.rumus_detail_input as rumus_input");
		$this->db->from('sample.sample_logsheet_detail_detail a');
		$this->db->join('sample.sample_parameter_rumus b', 'b.detail_parameter_rumus_id = a.rumus_detail_id', 'left');

		$sql = $this->db->get();

		if ($sql) {
			return $sql->result_array();
		} else {
			return false;
		}
	}

	public function getNomorDOF($param = null)
	{
		if (isset($param['transaksi_rutin_id']))
			$this->db->where('id_nomor_rutin', $param['transaksi_rutin_id']);

		$this->db->where('e.user_detail_jabatanInt', '3');
		$this->db->where('e.user_detail_idBag', 'E44100');

		$this->db->select('logsheet_tgl_uji,logsheet_tgl_sampling,logsheet_tgl_terima,logsheet_asal_sample,logsheet_pengolah_sample,logsheet_analisis,logsheet_review
			,logsheet_analisis_date,logsheet_review_date,logsheet_last_update,logsheet_analisis_qr,logsheet_review_qr,is_approve,id_template_footer,id_dokumen_tipe,id_dokumen_template,dokumen_template_file,id_nomor_rutin, d.user_detail_id as id_dof_drafter , d.user_detail_name as nama_drafter , d.user_detail_userName as nik_drafter, e.user_detail_id as id_dof_reviewer , e.user_detail_name as nama_reviewer ,e.user_detail_userName as nik_reviewer, f.user_detail_id as id_dof_approver ,  f.user_detail_name as nama_approver,f.user_detail_userName as nik_approver');
		$this->db->distinct();

		$this->db->from('sample.sample_logsheet c');
		$this->db->join('global.global_user_detail d', 'd.user_detail_userName = c.logsheet_review', 'left');
		// untuk id dof reviwer
		$this->db->join('global.global_user_detail e', 'e.user_detail_unitId = d.user_detail_unitId', 'left');
		// untuk id dof approver
		$this->db->join('global.global_user_detail f', 'f.user_detail_posCode = e.user_detail_directSuperior', 'left');
		// untuk id dof tujuan

		$sql = $this->db->get();

		return $sql->row_array();
	}


	public function getNomorMax()
	{
		$this->db->select('MAX( CAST( transaksi_urut AS "numeric") ) as isi');
		$this->db->from('sample.sample_transaksi');
		$this->db->where('EXTRACT(YEAR FROM transaksi_tgl) = ' . date('Y'));
		$sql = $this->db->get();

		return $sql->row_array();
	}

	public function getNomorDetailMax()
	{
		$this->db->select('MAX( CAST( transaksi_detail_urut AS "numeric") ) as isi');
		$this->db->from('sample.sample_transaksi_detail');
		$this->db->where('EXTRACT(YEAR FROM transaksi_detail_tgl_pengajuan) = ' . date('Y'));
		$sql = $this->db->get();

		return $sql->row_array();
	}

	public function getNomorDetailBySeksiMax($data = null)
	{
		$this->db->select('MAX( CAST( transaksi_detail_urut AS "numeric") ) as isi');
		$this->db->from('sample.sample_transaksi_detail');
		$this->db->where('EXTRACT(YEAR FROM transaksi_detail_tgl_pengajuan) = ' . date('Y'));
		if (isset($data['id_seksi'])) $this->db->where('who_seksi_create', $data['id_seksi']);
		$sql = $this->db->get();

		return $sql->row_array();
	}

	public function getNomorDetail($data = null)
	{
		$this->db->select("a.transaksi_id, a.transaksi_tipe, a.transaksi_status, a.transaksi_nomor, b.*, c.jenis_nama, d.peminta_jasa_nama, e.sample_pekerjaan_nama, f.identitas_nama, to_char(transaksi_detail_tgl_pengajuan, 'DD-MM-YYYY HH24:MI:SS') AS transaksi_detail_tgl_pengajuan_baru, to_char(transaksi_detail_tgl_memo, 'DD-MM-YYYY HH24:MI:SS') AS transaksi_detail_tgl_memo_baru, to_char(transaksi_detail_tgl_estimasi, 'DD-MM-YYYY HH24:MI:SS') AS transaksi_detail_tgl_estimasi_baru, transaksi_detail_note,a.id_transaksi_rutin as transaksi_rutin_id");
		$this->db->from('sample.sample_transaksi a');
		$this->db->join('sample.sample_transaksi_detail b', 'a.transaksi_id = b.transaksi_id AND a.id_transaksi_detail = b.transaksi_detail_id', 'left');
		$this->db->join('sample.sample_jenis c', 'c.jenis_id = b.jenis_id', 'left');
		$this->db->join('sample.sample_peminta_jasa d', 'd.peminta_jasa_id = b.peminta_jasa_id', 'left');
		$this->db->join('sample.sample_pekerjaan e', 'e.sample_pekerjaan_id = b.jenis_pekerjaan_id', 'left');
		$this->db->join('sample.sample_identitas f', 'f.identitas_id = b.identitas_id', 'left');
		if (isset($data['transaksi_rutin_id'])) $this->db->where('id_transaksi_rutin', $data['transaksi_rutin_id']);
		if (isset($data['transaksi_detail_status'])) $this->db->where('transaksi_detail_status', $data['transaksi_detail_status']);
		// $this->db->where("(transaksi_detail_status != '8' OR transaksi_detail_status IS NULL)");

		$this->db->order_by('transaksi_detail_urut', 'asc');
		$this->db->order_by('a.transaksi_nomor', 'ASC');
		$this->db->order_by('a.transaksi_tgl', 'ASC');
		$this->db->order_by('a.when_create', 'desc');
		$sql = $this->db->get();

		return $sql->result_array();
	}

	public function getNomorDetailGroup($data = null)
	{
		$this->db->select('a.*,b.when_create,b.who_create,b.transaksi_nomor,c.peminta_jasa_id,c.jenis_id,c.jenis_pekerjaan_id,d.jenis_nama,e.peminta_jasa_nama,f.sample_pekerjaan_nama,g.identitas_nama,count(*) as jumlah');
		$this->db->from('sample.sample_transaksi_rutin a');
		$this->db->join('sample.sample_transaksi b', 'a.transaksi_rutin_id = b.id_transaksi_rutin', 'left');
		$this->db->join('sample.sample_transaksi_detail c', 'b.id_transaksi_detail = c.transaksi_detail_id', 'left');
		$this->db->join('sample.sample_jenis d', 'd.jenis_id = c.jenis_id', 'left');
		$this->db->join('sample.sample_peminta_jasa e', 'e.peminta_jasa_id = c.peminta_jasa_id', 'left');
		$this->db->join('sample.sample_pekerjaan f', 'f.sample_pekerjaan_id = c.jenis_pekerjaan_id', 'left');
		$this->db->join('sample.sample_identitas g', 'g.identitas_id = c.identitas_id', 'left');

		if ($data['transaksi_detail_status'] != '-') {
			$this->db->where('transaksi_detail_status', $data['transaksi_detail_status']);
		}
		if (!empty($where))
			$this->db->where($where);
		// if (isset($data['transaksi_detail_status']))
		if (isset($data['tanggal_cari_awal']))
			$this->db->where('DATE(transaksi_rutin_tgl) >= ', $data['tanggal_cari_awal']);
		if (isset($data['tanggal_cari_akhir']))
			$this->db->where('DATE(transaksi_rutin_tgl) <= ', $data['tanggal_cari_akhir']);
		$this->db->where('transaksi_rutin_id', $data['transaksi_rutin_id']);
		$this->db->where("(a.who_seksi_create = '" . $data['seksi_id'] . "' OR '1' = '" . $data['role_id'] . "')");
		$this->db->where('transaksi_detail_status != ', '8');
		$this->db->order_by('transaksi_rutin_tgl', 'desc');
		$this->db->group_by('transaksi_rutin_id,b.when_create,b.who_create,b.transaksi_nomor,c.peminta_jasa_id,c.jenis_id,c.jenis_pekerjaan_id,d.jenis_nama,e.peminta_jasa_nama,f.sample_pekerjaan_nama,g.identitas_nama');

		$sql = $this->db->get();

		return $sql->result_array();
	}

	/* INSERT */
	public function insertNomor($data)
	{
		$this->db->insert('sample.sample_transaksi', $data);

		return $this->db->affected_rows();
	}
	/* INSERT */

	/* INSERT DETAIL */
	public function insertNomorDetail($data)
	{
		$this->db->insert('sample.sample_transaksi_detail', $data);

		return $this->db->affected_rows();
	}
	/* INSERT DETAIL */

	/* INSERT RUTIN */
	public function insertNomorRutin($data)
	{
		$this->db->insert('sample.sample_transaksi_rutin', $data);

		return $this->db->affected_rows();
	}
	/* INSERT RUTIN */

	/* DELETE RUTIN */
	public function deleteNomorRutin($id)
	{
		$this->db->where('transaksi_rutin_id', $id);
		$this->db->delete('sample.sample_transaksi_rutin');

		return $this->db->affected_rows();
	}
	/* DELETE RUTIN */

	/* DELETE EASYUI */
	public function deleteNomorEasyui($id)
	{
		$this->db->where('transaksi_id', $id);
		$this->db->delete('sample.sample_transaksi');

		$this->db->affected_rows();

		$this->db->where('transaksi_id', $id);
		$this->db->delete('sample.sample_transaksi_detail');

		return $this->db->affected_rows();
	}
	/* DELETE EASYUI */

	/* UPDATE DETAIL */
	public function updateNomorDetail($data, $id)
	{
		$this->db->set($data);
		$this->db->where('transaksi_detail_id', $id);
		$this->db->update('sample.sample_transaksi_detail');

		return $this->db->affected_rows();
	}
	/* UPDATE DETAIL */

	/**/
	public function deleteNomor($data,$id){
		$this->db->where('transaksi_id', $id);
		$this->db->delete('sample.sample_transaksi');
	}
	/**/

	/* UPDATE DETAIL */
	public function deleteNomorDetail($data, $id)
	{
		// $this->db->set($data);
		$this->db->where('transaksi_id', $id);
		$this->db->delete('sample.sample_transaksi_detail');

		return $this->db->affected_rows();
	}
	/* UPDATE DETAIL */

	/* UPDATE CLOSE */
	public function updateClose($data, $id)
	{
		$this->db->set($data);
		$this->db->where('id_transaksi_rutin', $id);
		$this->db->update('sample.sample_transaksi');
	}
	/* UPDATE CLOSE */

	/*UPDATE CLOSE DETAIL */
	public function updateCloseDetail($data, $id)
	{
		$this->db->set($data);
		$this->db->where('transaksi_id', $id);
		$this->db->update('sample.sample_transaksi');
	}
	/*UPDATE CLOSE DETAIL */

	/* UPDATE CLOSSED */
	public function updateClossed($data)
	{
		$this->db->query("UPDATE sample.sample_transaksi_detail a SET transaksi_detail_status = '6', transaksi_detail_no_surat = '" . $data['transaksi_detail_no_surat'] . "', transaksi_detail_file = '" . $data['transaksi_detail_file'] . "' FROM sample.sample_transaksi b WHERE a.transaksi_detail_id = b.id_transaksi_detail AND b.id_transaksi_rutin = '" . $data['id_transaksi_rutin'] . "'");

		return $this->db->affected_rows();
	}
	/* UPDATE CLOSSED */

	/* UPDATE CLOSSED DETAIL */
	public function updateClossedDetail($data)
	{
		$this->db->query("UPDATE sample.sample_transaksi_detail a SET transaksi_detail_status = '6', transaksi_detail_no_surat = '" . $data['transaksi_detail_no_surat'] . "', transaksi_detail_file = '" . $data['transaksi_detail_file'] . "' FROM sample.sample_transaksi b WHERE a.transaksi_detail_id = b.id_transaksi_detail AND b.transaksi_id = '" . $data['id_transaksi'] . "'");

		return $this->db->affected_rows();
	}
	/* UPDATE CLOSSED DETAIL */


	public function updateNomorTransaksi($id, $data)
	{
		$this->db->where('id_transaksi_rutin', $id);
		$this->db->update('sample.sample_transaksi', $data);

		return $this->db->affected_rows();
	}

	public function updateNomorTransaksiDetail($data)
	{
		$this->db->query("UPDATE sample.sample_transaksi_detail a SET transaksi_detail_status = '" . $data['transaksi_detail_status'] . "' , when_create = '" . $data['when_create'] . "', who_create = '" . $data['who_create'] . "', who_seksi_create = '" . $data['who_seksi_create'] . "' FROM sample.sample_transaksi b WHERE a.transaksi_detail_id = b.id_transaksi_detail AND id_transaksi_rutin = '" . $data['id_transaksi_rutin'] . "' ");
	}

	public function updateNomorTransaksiSingle($id, $data)
	{
		$this->db->where('transaksi_id', $id);
		$this->db->update('sample.sample_transaksi', $data);

		return $this->db->affected_rows();
	}

	public function updateNomorTransaksiDetailSingle($data)
	{
		$this->db->query("UPDATE sample.sample_transaksi_detail a SET transaksi_detail_status = '" . $data['transaksi_detail_status'] . "' , when_create = '" . $data['when_create'] . "', who_create = '" . $data['who_create'] . "', who_seksi_create = '" . $data['who_seksi_create'] . "' FROM sample.sample_transaksi b WHERE a.transaksi_detail_id = b.id_transaksi_detail AND id_transaksi_rutin = '" . $data['id_transaksi_rutin'] . "' AND a.transaksi_id = '" . $data['id_transaksi'] . "'");
	}

	// UPDATE LOGSHEET
	public function updateLogsheet($id, $data)
	{
		$this->db->where('id_nomor_rutin', $id);
		$this->db->update('sample.sample_logsheet', $data);

		return $this->db->affected_rows();
	}
	// UPDATE LOGSHEET

	/* GET EKSTERNAL */
	public function getEksternal($data = NULL)
	{
		$this->db->select('COUNT(*) AS total');
		$this->db->from('sample.sample_transaksi a');
		$this->db->join('sample.sample_seksi_disposisi b', 'a.transaksi_id = b.id_transaksi', 'left');
		$this->db->where('b.id_seksi', $data['seksi_id']);
		$this->db->where('a.transaksi_status', '7');
		$this->db->where('a.transaksi_tipe', 'E');
		$sql = $this->db->get();

		return $sql->row_array();
	}
	/* GET EKSTERNAL */

	/* GET INTERNAL */
	public function getInternal($data = NULL)
	{
		$this->db->select('COUNT(*) AS total');
		$this->db->from('sample.sample_transaksi a');
		$this->db->join('sample.sample_seksi_disposisi b', 'a.transaksi_id = b.id_transaksi', 'left');
		$this->db->where('b.id_seksi', $data['seksi_id']);
		$this->db->where('a.transaksi_status', '7');
		$this->db->where('a.transaksi_tipe', 'I');
		$sql = $this->db->get();

		return $sql->row_array();
	}
	/* GET INTERNAL */

	/* GET RUTIN*/
	public function getRutin($data = NULL)
	{
		$this->db->select("a.*, to_char(transaksi_rutin_tgl, 'DD-MM-YYYY HH24:MI:SS') AS transaksi_rutin_tgl_baru, SUM(CAST(c.transaksi_detail_status as int)) AS status");
		$this->db->from('sample.sample_transaksi_rutin a');
		$this->db->join('sample.sample_transaksi b', 'a.transaksi_rutin_id = b.id_transaksi_rutin', 'left');
		$this->db->join('sample.sample_transaksi_detail c', 'b.id_transaksi_detail = c.transaksi_detail_id', 'left');
		$this->db->where('a.who_seksi_create', $data['seksi_id']);
		$this->db->order_by('transaksi_rutin_tgl', 'desc');
		$this->db->group_by('a.transaksi_rutin_id');
		$sql = $this->db->get();

		return $sql->result_array();
	}
	/* GET RUTIN*/

	public function getNomorReject($data = null)
	{
		$this->db->select("a.transaksi_id, b.transaksi_detail_id");
		$this->db->from('sample.sample_transaksi a');
		$this->db->join('sample.sample_transaksi_detail b', 'a.id_transaksi_detail = b.transaksi_detail_id', 'left');
		$this->db->where('a.transaksi_status IS NULL');
		if (isset($data['transaksi_rutin_id']))
			$this->db->where('id_transaksi_rutin', $data['transaksi_rutin_id']);
		$sql = $this->db->get();

		return $sql->result_array();
	}

	public function insertReject($data)
	{
		$this->db->query("INSERT INTO sample.sample_transaksi_detail SELECT '" . $data['transaksi_detail_id'] . "', id_seksi, identitas_id, jenis_id, peminta_jasa_id, a.transaksi_id, transaksi_detail_pic_pengirim, transaksi_detail_ext_pengirim, transaksi_detail_jumlah, transaksi_detail_parameter, transaksi_detail_tgl_pengajuan, transaksi_detail_tgl_memo, transaksi_detail_no_memo, transaksi_detail_foto, transaksi_detail_tgl_estimasi, NULL, NULL, is_urgent, jenis_pekerjaan_id, '" . $data['when_create'] . "', '" . $data['who_create'] . "', '" . $data['transaksi_detail_note'] . "', '" . $data['transaksi_detail_status'] . "' FROM sample.sample_transaksi_detail a LEFT JOIN sample.sample_transaksi b ON a.transaksi_detail_id = b.id_transaksi_detail WHERE b.transaksi_id = '" . $data['transaksi_id'] . "'");

		return $this->db->affected_rows();
	}

	public function Cancel($data = null)
	{
		$this->db->where('id_transaksi_rutin', $data['transaksi_rutin_id']);
		$this->db->delete('sample.sample_transaksi');

		return $this->db->affected_rows();
	}

	public function hapusNomorDetail($param = null)
	{
		if (isset($param['transaksi_id']))
			$this->db->where('transaksi_id', $param['transaksi_id']);
		if (isset($param['transaksi_detail_id']))
			$this->db->where('transaksi_detail_id', $param['transaksi_detail_id']);

		$this->db->delete('sample.sample_transaksi_detail');

		return $this->db->affected_rows();
	}

	public function hapusNomor($param = null)
	{
		if (isset($param['transaksi_id']))
			$this->db->where('transaksi_id', $param['transaksi_id']);
		if (isset($param['transaksi_detail_id']))
			$this->db->where('id_transaksi_detail', $param['transaksi_detail_id']);

		$this->db->delete('sample.sample_transaksi');

		return $this->db->affected_rows();
	}
}
