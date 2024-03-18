<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_inbox extends CI_Model{
	/* GET */

	public function getTransaksiTipe($data = null){
		$this->db->select('a.transaksi_tipe');
		$this->db->from('sample.sample_transaksi a');
		if (isset($data['transaksi_id'])) $this->db->where('transaksi_id', $data['id_transaksi']);

		$sql = $this->db->get();

		return $sql->row_array();
	}

	public function getInboxMain(){
		$this->db->select("a.transaksi_id,a.transaksi_tgl,a.when_create,a.who_seksi_create,a.transaksi_nomor, a.transaksi_tipe, a.transaksi_status,a.transaksi_reviewer,a.transaksi_approver,a.transaksi_drafter,a.transaksi_tujuan,b.is_urgent,b.transaksi_detail_nomor_sample,b.id_user_disposisi, b.peminta_jasa_id,b.transaksi_detail_no_memo,b.transaksi_detail_note, b.transaksi_detail_pic_pengirim,b.transaksi_detail_ext_pengirim, c.peminta_jasa_nama, d.transaksi_non_rutin_id,  to_char(b.transaksi_detail_tgl_pengajuan, 'DD-MM-YYYY') AS transaksi_detail_tgl_pengajuan_baru, to_char(b.transaksi_detail_tgl_memo, 'DD-MM-YYYY') AS transaksi_detail_tgl_memo_baru, to_char(b.transaksi_detail_tgl_estimasi, 'DD-MM-YYYY') AS transaksi_detail_tgl_estimasi_baru, b.transaksi_detail_note as note_awal,a.transaksi_judul,b.transaksi_detail_pic_telepon,a.transaksi_id_template_keterangan,a.transaksi_drafter,a.transaksi_attach,a.transaksi_sifat,a.transaksi_kecepatan_tanggap,a.id_transaksi_non_rutin,a.transaksi_klasifikasi_id,a.transaksi_id_user,transaksi_pic_ext,transaksi_pic_telepon,b.id_user_disposisi,b.id_seksi_disposisi");
		// $this->db->distinct();
		$this->db->from('sample.sample_transaksi a');
		$this->db->join('sample.sample_transaksi_detail b', 'a.transaksi_id = b.transaksi_id AND a.transaksi_status=b.transaksi_detail_status', 'right');
		$this->db->join('sample.sample_peminta_jasa c', 'c.peminta_jasa_id=b.peminta_jasa_id', 'left');
		$this->db->join('sample.sample_transaksi_non_rutin d', 'd.transaksi_non_rutin_id = b.id_non_rutin AND d.transaksi_non_rutin_id = a.id_transaksi_non_rutin', 'left');

		if (!empty($where) && !isset($data['transaksi_status'])) {
			$this->db->where(($where));
			// $this->db->or_where('transaksi_status', '0');
		}

		if (isset($data['transaksi_tipe'])) $this->db->where('a.transaksi_tipe', $data['transaksi_tipe']);
		if (isset($data['transaksi_id'])) $this->db->where('a.transaksi_id', $data['transaksi_id']);
		if (isset($data['status']) && $data['status'] != '-') $this->db->where('a.transaksi_status', $data['status']);
		if (isset($data['id_transaksi'])) $this->db->where('a.transaksi_id', $data['id_transaksi']);
		// if (isset($data['tgl_awal'])) $this->db->where('DATE(a.transaksi_tgl) >= ', $data['tgl_awal']);
		// if (isset($data['tgl_akhir'])) $this->db->where('DATE(a.transaksi_tgl) <= ', $data['tgl_akhir']);
		if (isset($data['tanggal_cari_awal'])) $this->db->where('DATE(a.transaksi_tgl) >=', $data['tanggal_cari_awal']);
		if (isset($data['tanggal_cari_akhir'])) $this->db->where('DATE(a.transaksi_tgl) <=', $data['tanggal_cari_akhir']);
		if (isset($data['transaksi_status'])) $this->db->where('a.transaksi_status', $data['transaksi_status']);

		if (!isset($data['transaksi_tipe_rutin'])) {
			$this->db->where("transaksi_status != '0'");
			$this->db->where("transaksi_status != '1'");
			$this->db->where("transaksi_status != '2'");
			$this->db->where("transaksi_status != '3'");
			$this->db->where("transaksi_status != '4'");
			$this->db->where("transaksi_status != '5'");
			$this->db->where("transaksi_status != 'R'");
			$this->db->where("(is_khusus != 'y')");
		}

		$this->db->where("transaksi_status != '0'");
		$this->db->where("transaksi_status != '1'");
		$this->db->where("transaksi_status != '2'");
		$this->db->where("transaksi_status != '3'");
		$this->db->where("transaksi_status != '4'");
		$this->db->where("transaksi_status != '5'");
		$this->db->where("transaksi_status != 'R'");		// $this->db->where("(is_khusus != 'y')");
		$this->db->order_by('b.is_urgent', 'desc');
		$this->db->order_by('a.transaksi_nomor', 'asc');
		$this->db->order_by('a.transaksi_tgl', 'desc');
		$this->db->order_by('a.when_create', 'desc');
		$sql = $this->db->get();

		return (isset($data['transaksi_id'])) ? $sql->row_array() : $sql->result_array();
	}

	public function getInbox($data = null, $where = null){
		$this->db->select("a.transaksi_id, a.transaksi_tipe, a.transaksi_status, a.transaksi_nomor, b.*, c.jenis_nama, d.peminta_jasa_nama, e.sample_pekerjaan_nama, a.transaksi_tgl, f.identitas_nama, to_char(transaksi_detail_tgl_pengajuan, 'DD-MM-YYYY HH24:MI:SS') AS transaksi_detail_tgl_pengajuan_baru, to_char(transaksi_detail_tgl_memo, 'DD-MM-YYYY') AS transaksi_detail_tgl_memo_baru, to_char(transaksi_detail_tgl_estimasi, 'DD-MM-YYYY HH24:MI:SS') AS transaksi_detail_tgl_estimasi_baru,a.transaksi_id_template_keterangan,i.logsheet_id,i.id_template_logsheet,i.logsheet_tipe,i.is_approve,i.logsheet_analisis,i.logsheet_review");
		$this->db->from('sample.sample_transaksi a');
		$this->db->join('sample.sample_transaksi_detail b', 'a.transaksi_id = b.transaksi_id', 'left');
		$this->db->join('sample.sample_jenis c', 'c.jenis_id = b.jenis_id', 'left');
		$this->db->join('sample.sample_peminta_jasa d', 'd.peminta_jasa_id = b.peminta_jasa_id', 'left');
		$this->db->join('sample.sample_pekerjaan e', 'e.sample_pekerjaan_id = b.jenis_pekerjaan_id', 'left');
		$this->db->join('sample.sample_identitas f', 'f.identitas_id = b.identitas_id', 'left');
		// $this->db->join('sample.sample_transaksi_keterangan g', 'g.transaksi_keterangan_id = a.transaksi_id_template_keterangan', 'left');
		// $this->db->join('sample.sample_template_keterangan h', 'h.template_keterangan_id = g.transaksi_id_template', 'left');
		$this->db->join('sample.sample_logsheet i', 'i.id_transaksi = a.transaksi_id AND i.id_transaksi_detail = b.transaksi_detail_id', 'left');

		if (!empty($where) && !isset($data['transaksi_status'])) {
			$this->db->where(($where));
		}
		if ($data['transaksi_status'] != '-') {
			if (isset($data['transaksi_status'])) $this->db->where("CAST(b.transaksi_detail_status as INT) >= '" . ($data['transaksi_status']) . "' ");
		} else {
			$this->db->where("CAST(b.transaksi_detail_status as INT) >= 6 ");
		}
		if (isset($data['id_transaksi'])) $this->db->where('b.transaksi_id', $data['id_transaksi']);
		if (isset($data['tanggal_cari_awal'])) $this->db->where('DATE(a.transaksi_tgl) >=', $data['tanggal_cari_awal']);
		if (isset($data['tanggal_cari_akhir'])) $this->db->where('DATE(a.transaksi_tgl) <=', $data['tanggal_cari_akhir']);

		if (!isset($data['transaksi_tipe_rutin'])) {
			$this->db->where("transaksi_status != '0'");
			$this->db->where("transaksi_status != '1'");
			$this->db->where("transaksi_status != '2'");
			$this->db->where("transaksi_status != '3'");
			$this->db->where("transaksi_status != '4'");
			$this->db->where("transaksi_status != '5'");
			$this->db->where("transaksi_status != '15'");
			$this->db->where("(is_khusus != 'y')");
		}

		// $this->db->where("transaksi_status != '0'");
		// $this->db->where("transaksi_status != '1'");
		// $this->db->where("transaksi_status != '2'");
		// $this->db->where("transaksi_status != '3'");
		// $this->db->where("transaksi_status != '4'");
		// $this->db->where("transaksi_status != '5'");
		$this->db->where("transaksi_status != '15'");

		$this->db->where("(is_proses!='y' OR is_proses is NULL)");

		$this->db->where("(id_transaksi_rutin = '' OR id_transaksi_rutin is NULL)");


		// $this->db->where("(is_khusus != 'y')");
		// $this->db->order_by('b.is_urgent', 'desc');
		$this->db->order_by('a.transaksi_nomor', 'asc');
		$this->db->order_by('CAST(transaksi_detail_status as INT)', 'ASC');
		$this->db->order_by('a.transaksi_tgl', 'desc');
		$this->db->order_by('a.when_create', 'desc');
		$sql = $this->db->get();

		return (isset($data['transaksi_id'])) ? $sql->row_array() : $sql->result_array();
	}


	public function getDisposisi($data = null){
		$this->db->select('COUNT(*) AS total');
		$this->db->from('sample.sample_seksi_disposisi');
		$this->db->where('id_transaksi', $data['transaksi_id']);
		$this->db->where('id_seksi', $data['id_seksi']);
		if (isset($data['transaksi_detail_id'])) $this->db->where('id_transaksi_detail', $data['transaksi_detail_id']);
		$sql = $this->db->get();

		return $sql->row_array();
	}

	public function getPetugas($data = null){
		$this->db->select('COUNT(*) AS total');
		$this->db->from('sample.sample_petugas');
		$this->db->where('id_transaksi', $data['transaksi_id']);
		$this->db->where('id_user', $data['user_id']);
		if (isset($data['transaksi_detail_id'])) $this->db->where('id_transaksi_detail', $data['transaksi_detail_id']);
		$sql = $this->db->get();

		return $sql->row_array();
	}

	public function getTransaksiSeksiDisposisi($data = null){
		$this->db->select('*');
		$this->db->from('sample.sample_seksi_disposisi a');
		$this->db->join('global.global_seksi b', 'a.id_seksi = b.seksi_id', 'left');

		if (isset($data['transaksi_id'])) $this->db->where('id_transaksi', $data['transaksi_id']);
		$sql = $this->db->get();
		return $sql->result_array();
	}

	public function getHistory($data = null){
		$this->db->select('a.who_create,a.when_create,a.seksi_disposisi_history_alasan,b.seksi_nama as seksi_asal,c.seksi_nama as seksi_tujuan');
		$this->db->from('sample.sample_seksi_disposisi_history a');
		$this->db->join('global.global_seksi b', 'b.seksi_id = a.id_seksi_asal', 'left');
		$this->db->join('global.global_seksi c', 'c.seksi_id = a.id_seksi_asal', 'left');

		if (isset($data['id_transaksi'])) $this->db->where('a.id_transaksi', $data['id_transaksi']);

		$this->db->order_by('a.when_create', 'desc');

		$sql = $this->db->get();

		return $sql->result_array();
	}

	public function getRumus($data = ''){
		$this->db->select('*');
		$this->db->from('sample.sample_perhitungan_sample a');
		$this->db->join('sample.sample_perhitungan_sample_detail b', 'b.id_rumus = a.rumus_id', 'left');

		$this->db->order_by('rumus_nama', 'asc');
		$this->db->order_by('b.rumus_detail_urut', 'asc');

		$sql = $this->db->get();

		return $sql->result_array();
	}

	public function getLogsheet($data = ''){
		$this->db->select('a.*,b.user_tanda_tangan as ttd_analisis,c.user_tanda_tangan as ttd_review,b.user_nama_lengkap as nama_analisis,c.user_nama_lengkap as nama_review');
		$this->db->from('sample.sample_logsheet a');
		$this->db->join('global.global_user b', 'b.user_username = a.logsheet_analisis', 'left');
		$this->db->join('global.global_user c', 'c.user_username = a.logsheet_review', 'left');

		if (isset($data['logsheet_id'])) $this->db->where('logsheet_id', $data['logsheet_id']);
		if (isset($data['logsheet_multiple_id'])) $this->db->where('logsheet_multiple_id', $data['logsheet_multiple_id']);
		if (isset($data['logsheet_id_multiple'])) $this->db->where_in('logsheet_id', $data['logsheet_id_multiple']);

		$sql = $this->db->get();

		return (isset($data['logsheet_id'])) ? $sql->row_array() : $sql->result_array();
	}

	public function getLogsheetDetail($data = ''){
		$this->db->select('*');
		$this->db->from('sample.sample_logsheet a');
		$this->db->join('sample.sample_logsheet_detail b', 'a.logsheet_id = b.logsheet_id', 'left');
		$this->db->join('sample.sample_perhitungan_sample c', 'c.rumus_id = b.id_rumus', 'left');

		if (isset($data['transaksi_id'])) $this->db->where('id_transaksi', $data['transaksi_id']);
		if (isset($data['logsheet_id'])) $this->db->where('a.logsheet_id', $data['logsheet_id']);
		if (isset($data['logsheet_id_multiple'])) $this->db->where_in('a.logsheet_id', $data['logsheet_id_multiple']);
		if (isset($data['logsheet_multiple_id'])) $this->db->where('logsheet_multiple_id', $data['logsheet_multiple_id']);
		if (isset($data['id_template_logsheet'])) $this->db->where('id_template_logsheet', $data['id_template_logsheet']);
		if (isset($data['rumus_id'])) $this->db->where_in('rumus_id', $data['rumus_id']);
		if (isset($data['id_transaksi_detail_group'])) $this->db->where_in('a.id_transaksi_detail', $data['id_transaksi_detail_group']);

		$this->db->order_by('logsheet_nomor_sample', 'asc');
		$this->db->order_by('logsheet_detail_urut', 'asc');

		$sql = $this->db->get();

		return $sql->result_array();
	}

	public function getLogsheetDetailGroup($data = ''){
		$this->db->select("rumus_metoda,rumus_satuan,rumus_avg,logsheet_nomor_sample");
		$this->db->distinct();
		$this->db->from('sample.sample_logsheet a');
		$this->db->join('sample.sample_logsheet_detail b', 'a.logsheet_id = b.logsheet_id', 'left');
		$this->db->join('sample.sample_perhitungan_sample c', 'c.rumus_id = b.id_rumus', 'left');

		if (isset($data['transaksi_id'])) $this->db->where('id_transaksi', $data['transaksi_id']);
		if (isset($data['logsheet_id'])) $this->db->where('a.logsheet_id', $data['logsheet_id']);
		if (isset($data['logsheet_id_multiple'])) $this->db->where_in('a.logsheet_id', $data['logsheet_id_multiple']);
		if (isset($data['logsheet_multiple_id'])) $this->db->where('logsheet_multiple_id', $data['logsheet_multiple_id']);
		if (isset($data['id_template_logsheet'])) $this->db->where('id_template_logsheet', $data['id_template_logsheet']);
		if (isset($data['rumus_id'])) $this->db->where('rumus_id', $data['rumus_id']);

		$this->db->order_by('logsheet_nomor_sample', 'asc');
		// $this->db->order_by('logsheet_detail_urut', 'asc');

		$sql = $this->db->get();

		return $sql->result_array();
	}

	public function getLogsheetDetailDetail($data = ''){
		$this->db->select('*');
		$this->db->from('sample.sample_logsheet_detail_detail a');
		$this->db->join('sample.sample_logsheet_detail b', 'a.id_logsheet_detail = b.logsheet_detail_id', 'left');

		if (isset($data['logsheet_detail_id'])) $this->db->where('b.logsheet_detail_id', $data['logsheet_detail_id']);
		$this->db->where("rumus_detail_id!=''");


		$this->db->order_by('logsheet_detail_urut', 'asc');
		$this->db->order_by('rumus_detail_template', 'asc');


		$sql = $this->db->get();

		return $sql->result_array();
	}

	public function getInboxDetail($data = null){
		$this->db->select("a.transaksi_detail_status,a.who_create,b.jenis_nama,c.identitas_nama, to_char(transaksi_detail_tgl_pengajuan, 'DD-MM-YYYY HH24:MI:SS') AS transaksi_detail_tgl_pengajuan_baru, to_char(transaksi_detail_tgl_memo, 'DD-MM-YYYY HH24:MI:SS') AS transaksi_detail_tgl_memo_baru, to_char(transaksi_detail_tgl_estimasi, 'DD-MM-YYYY HH24:MI:SS') AS transaksi_detail_tgl_estimasi_baru, to_char(a.when_create, 'DD-MM-YYYY HH24:MI:SS') AS when_create_baru,transaksi_detail_note");
		$this->db->distinct();
		$this->db->from('sample.sample_transaksi_detail a');
		$this->db->join('sample.sample_transaksi d', 'd.transaksi_id = a.transaksi_id', 'left');
		$this->db->join('sample.sample_jenis b', 'b.jenis_id = a.jenis_id', 'left');
		$this->db->join('sample.sample_identitas c', 'c.identitas_id = a.identitas_id', 'left');

		if (isset($data['transaksi_non_rutin_id'])) $this->db->where('id_non_rutin', $data['transaksi_non_rutin_id']);
		if (isset($data['jenis_id'])) $this->db->where('a.jenis_id', $data['jenis_id']);
		if (isset($data['transaksi_id'])) $this->db->where('transaksi_id', $data['transaksi_id']);

		if (isset($data['tgl_awal'])) $this->db->where('DATE(transaksi_detail_tgl_pengajuan) >= ', $data['tgl_awal']);
		if (isset($data['tgl_akhir'])) $this->db->where('DATE(transaksi_detail_tgl_pengajuan) <= ', $data['tgl_akhir']);

		$this->db->order_by('when_create_baru', 'asc');
		// $this->db->order_by('cast(transaksi_detail_status as int)', 'asc');
		$sql = $this->db->get();

		if ($sql) {
			return $sql->result_array();
		} else {
			return false;
		}
	}
	/* GET */

	/* INSERT */
	public function insertInbox($data){
		// $this->db->query("INSERT INTO sample.sample_transaksi_detail SELECT '" . $data['transaksi_detail_id'] . "', id_seksi, identitas_id, jenis_id, peminta_jasa_id, a.transaksi_id, transaksi_detail_pic_pengirim, transaksi_detail_ext_pengirim, '" . $data['transaksi_detail_jumlah'] . "', '" . $data['transaksi_detail_parameter'] . "', transaksi_detail_tgl_pengajuan, '" . $data['transaksi_detail_tgl_memo'] . "', '" . $data['transaksi_detail_no_memo'] . "', transaksi_detail_foto, '" . $data['transaksi_detail_tgl_estimasi'] . "', NULL, NULL, is_urgent, jenis_pekerjaan_id, '" . $data['when_create'] . "', '" . $data['who_create'] . "', '" . $data['transaksi_detail_note'] . "', '" . $data['transaksi_detail_status'] . "' FROM sample.sample_transaksi_detail a LEFT JOIN sample.sample_transaksi b ON a.transaksi_detail_id = b.id_transaksi_detail WHERE b.transaksi_id = '" . $data['transaksi_id'] . "'");

		$this->db->query("INSERT INTO sample.sample_transaksi_detail SELECT '" . $data['transaksi_detail_id'] . "',id_seksi,identitas_id,jenis_id,a.peminta_jasa_id,a.transaksi_id,transaksi_detail_pic_pengirim,transaksi_detail_ext_pengirim,'" . $data['transaksi_detail_jumlah'] . "','" . $data['transaksi_detail_parameter'] . "',transaksi_detail_tgl_pengajuan,'" . $data['transaksi_detail_tgl_memo'] . "',transaksi_detail_no_memo,transaksi_detail_foto,'" . $data['transaksi_detail_tgl_estimasi'] . "',transaksi_detail_file,transaksi_detail_no_surat,is_urgent,jenis_pekerjaan_id,'" . $data['when_create'] . "','" . $data['who_create'] . "','" . $data['transaksi_detail_note'] . "','" . $data['transaksi_detail_status'] . "',is_khusus,id_user,who_seksi_create,id_non_rutin,transaksi_detail_nomor,transaksi_detail_urut,transaksi_detail_keterangan,transaksi_detail_kode_tracking,transaksi_detail_klasifikasi_id,transaksi_detail_nomor_sample,transaksi_detail_id_template_keterangan,transaksi_detail_id_template_keterangan,transaksi_detail_pic_telepon,transaksi_detail_attach,transaksi_detail_judul,transaksi_detail_identitas,transaksi_detail_deskripsi_parameter,transaksi_detail_catatan,id_user_disposisi,id_disposisi,id_seksi_disposisi,'" . $data['transaksi_detail_reject_alasan'] . "',transaksi_detail_agreement_keterangan,is_sampling,is_proses,transaksi_detail_tgl_sampling,transaksi_detail_tgl_pengujian FROM sample.sample_transaksi_detail a WHERE transaksi_detail_id = '" . $data['transaksi_detail_id_awal'] . "' AND transaksi_detail_status = '" . $data['transaksi_detail_status_awal'] . "'");

		return $this->db->affected_rows();
	}

	public function insertInboxDiterima($data = null){
		$this->db->query("INSERT INTO sample.sample_transaksi_detail SELECT '" . $data['transaksi_detail_id'] . "',id_seksi,identitas_id,jenis_id,peminta_jasa_id,'" . $data['transaksi_id'] . "',transaksi_detail_pic_pengirim,transaksi_detail_ext_pengirim,'" . $data['transaksi_detail_jumlah'] . "','" . $data['transaksi_detail_parameter'] . "',transaksi_detail_tgl_pengajuan,transaksi_detail_tgl_memo,transaksi_detail_no_memo,transaksi_detail_foto,transaksi_detail_tgl_memo,transaksi_detail_file,transaksi_detail_no_surat,is_urgent,jenis_pekerjaan_id,'" . $data['when_create'] . "','" . $data['who_create'] . "',transaksi_detail_note,'" . $data['transaksi_detail_status'] . "',is_khusus,id_user,'" . $data['who_seksi_create'] . "',id_non_rutin,transaksi_detail_nomor,transaksi_detail_urut,transaksi_detail_keterangan,transaksi_detail_kode_tracking,transaksi_detail_klasifikasi_id,transaksi_detail_nomor_sample,transaksi_detail_id_template_keterangan,transaksi_detail_is_template_keterangan,transaksi_detail_pic_telepon,transaksi_detail_attach,transaksi_detail_judul,transaksi_detail_identitas,'" . $data['transaksi_detail_deskripsi_parameter'] . "',transaksi_detail_catatan,id_user_disposisi,id_disposisi,id_seksi_disposisi,transaksi_detail_reject_alasan,transaksi_detail_agreement_keterangan,is_sampling,NULL,transaksi_detail_tgl_sampling,transaksi_detail_tgl_pengujian FROM sample.sample_transaksi_detail WHERE transaksi_detail_id = '" . $data['transaksi_detail_id_temp'] . "'");

		return $this->db->affected_rows();
	}

	public function insertInboxNew($data = null){
		$this->db->query("INSERT INTO sample.sample_transaksi_detail SELECT '" . $data['transaksi_detail_id'] . "',id_seksi,identitas_id,jenis_id,peminta_jasa_id,'" . $data['transaksi_id'] . "',transaksi_detail_pic_pengirim,transaksi_detail_ext_pengirim,'" . $data['transaksi_detail_jumlah'] . "','" . $data['transaksi_detail_parameter'] . "',transaksi_detail_tgl_pengajuan,transaksi_detail_tgl_memo,'" . $data['transaksi_detail_no_memo'] . "',transaksi_detail_foto,'" . $data['transaksi_detail_tgl_memo'] . "',transaksi_detail_file,transaksi_detail_no_surat,is_urgent,jenis_pekerjaan_id,'" . $data['when_create'] . "','" . $data['who_create'] . "','" . $data['transaksi_detail_note'] . "','" . $data['transaksi_detail_status'] . "',is_khusus,id_user,'" . $data['who_seksi_create'] . "',id_non_rutin,transaksi_detail_nomor,transaksi_detail_urut,transaksi_detail_keterangan,transaksi_detail_kode_tracking,transaksi_detail_klasifikasi_id,transaksi_detail_nomor_sample,transaksi_detail_id_template_keterangan,transaksi_detail_is_template_keterangan,transaksi_detail_pic_telepon,transaksi_detail_attach,transaksi_detail_judul,transaksi_detail_identitas,transaksi_detail_deskripsi_parameter,transaksi_detail_catatan,id_user_disposisi,id_disposisi,id_seksi_disposisi,transaksi_detail_reject_alasan,transaksi_detail_agreement_keterangan,is_sampling,NULL,transaksi_detail_tgl_sampling,transaksi_detail_tgl_pengujian FROM sample.sample_transaksi_detail WHERE transaksi_detail_id = '" . $data['transaksi_detail_id_temp'] . "'");

		return $this->db->affected_rows();
	}

	public function insertInboxAlihkan($data = null){
		$this->db->query("INSERT INTO sample.sample_transaksi_detail SELECT '" . $data['transaksi_detail_id'] . "',id_seksi,identitas_id,jenis_id,peminta_jasa_id,'" . $data['transaksi_id'] . "',transaksi_detail_pic_pengirim,transaksi_detail_ext_pengirim,transaksi_detail_jumlah,transaksi_detail_parameter,transaksi_detail_tgl_pengajuan,transaksi_detail_tgl_memo,transaksi_detail_no_memo,transaksi_detail_foto,transaksi_detail_tgl_memo,transaksi_detail_file,transaksi_detail_no_surat,is_urgent,jenis_pekerjaan_id,'" . $data['when_create'] . "','" . $data['who_create'] . "',transaksi_detail_note,'" . $data['transaksi_detail_status'] . "',is_khusus,id_user,'" . $data['who_seksi_create'] . "',id_non_rutin,transaksi_detail_nomor,transaksi_detail_urut,transaksi_detail_keterangan,transaksi_detail_kode_tracking,transaksi_detail_klasifikasi_id,NULL,transaksi_detail_id_template_keterangan,transaksi_detail_is_template_keterangan,transaksi_detail_pic_telepon,transaksi_detail_attach,transaksi_detail_judul,transaksi_detail_identitas,transaksi_detail_deskripsi_parameter,transaksi_detail_catatan,'2105087',id_disposisi,id_seksi_disposisi,'" . $data['transaksi_detail_reject_alasan'] . "',transaksi_detail_agreement_keterangan,is_sampling,NULL,transaksi_detail_tgl_sampling,transaksi_detail_tgl_pengujian FROM sample.sample_transaksi_detail WHERE transaksi_detail_id = '" . $data['transaksi_detail_id_temp'] . "'");

		return $this->db->affected_rows();
	}

	public function insertInboxLogsheet($data = null){
		$this->db->query("INSERT INTO sample.sample_transaksi_detail SELECT '" . $data['transaksi_detail_id'] . "',id_seksi,identitas_id,jenis_id,peminta_jasa_id,'" . $data['transaksi_id'] . "',transaksi_detail_pic_pengirim,transaksi_detail_ext_pengirim,transaksi_detail_jumlah,transaksi_detail_parameter,transaksi_detail_tgl_pengajuan,transaksi_detail_tgl_memo,transaksi_detail_no_memo,transaksi_detail_foto,transaksi_detail_tgl_memo,transaksi_detail_file,transaksi_detail_no_surat,is_urgent,jenis_pekerjaan_id,'" . $data['when_create'] . "','" . $data['who_create'] . "',transaksi_detail_note,'" . $data['transaksi_detail_status'] . "',is_khusus,id_user,'" . $data['who_seksi_create'] . "',id_non_rutin,transaksi_detail_nomor,transaksi_detail_urut,transaksi_detail_keterangan,transaksi_detail_kode_tracking,transaksi_detail_klasifikasi_id,transaksi_detail_nomor_sample,transaksi_detail_id_template_keterangan,transaksi_detail_is_template_keterangan,transaksi_detail_pic_telepon,transaksi_detail_attach,transaksi_detail_judul,transaksi_detail_identitas,transaksi_detail_deskripsi_parameter,transaksi_detail_catatan,id_user_disposisi,id_disposisi,id_seksi_disposisi,transaksi_detail_reject_alasan,transaksi_detail_agreement_keterangan,is_sampling,NULL,transaksi_detail_tgl_sampling,transaksi_detail_tgl_pengujian FROM sample.sample_transaksi_detail WHERE transaksi_detail_id = '" . $data['transaksi_detail_id_temp'] . "'");

		return $this->db->affected_rows();
	}

	public function insertInboxClossed($data = null){
		$this->db->query("INSERT INTO sample.sample_transaksi_detail SELECT '" . $data['transaksi_detail_id'] . "',id_seksi,identitas_id,jenis_id,peminta_jasa_id,'" . $data['transaksi_id'] . "',transaksi_detail_pic_pengirim,transaksi_detail_ext_pengirim,transaksi_detail_jumlah,transaksi_detail_parameter,transaksi_detail_tgl_pengajuan,transaksi_detail_tgl_memo,transaksi_detail_no_memo,transaksi_detail_foto,transaksi_detail_tgl_memo,transaksi_detail_file,'" . $data['transaksi_detail_no_surat'] . "',is_urgent,jenis_pekerjaan_id,'" . $data['when_create'] . "','" . $data['who_create'] . "',transaksi_detail_note,'" . $data['transaksi_detail_status'] . "',is_khusus,id_user,'" . $data['who_seksi_create'] . "',id_non_rutin,transaksi_detail_nomor,transaksi_detail_urut,transaksi_detail_keterangan,transaksi_detail_kode_tracking,transaksi_detail_klasifikasi_id,transaksi_detail_nomor_sample,transaksi_detail_id_template_keterangan,transaksi_detail_is_template_keterangan,transaksi_detail_pic_telepon,transaksi_detail_attach,transaksi_detail_judul,transaksi_detail_identitas,transaksi_detail_deskripsi_parameter,transaksi_detail_catatan,id_user_disposisi,id_disposisi,id_seksi_disposisi,transaksi_detail_reject_alasan,transaksi_detail_agreement_keterangan,is_sampling,NULL,transaksi_detail_tgl_sampling,transaksi_detail_tgl_pengujian FROM sample.sample_transaksi_detail WHERE transaksi_detail_id = '" . $data['transaksi_detail_id_temp'] . "'");

		return $this->db->affected_rows();
	}

	public function insertInboxRejectKasie($data = null){
		$this->db->query("INSERT INTO sample.sample_transaksi_detail SELECT '" . $data['transaksi_detail_id'] . "',id_seksi,identitas_id,jenis_id,peminta_jasa_id,'" . $data['transaksi_id'] . "',transaksi_detail_pic_pengirim,transaksi_detail_ext_pengirim,transaksi_detail_jumlah,transaksi_detail_parameter,transaksi_detail_tgl_pengajuan,transaksi_detail_tgl_memo,transaksi_detail_no_memo,transaksi_detail_foto,transaksi_detail_tgl_memo,transaksi_detail_file,transaksi_detail_no_surat,is_urgent,jenis_pekerjaan_id,'" . $data['when_create'] . "','" . $data['who_create'] . "',transaksi_detail_note,'" . $data['transaksi_detail_status'] . "',is_khusus,id_user,'" . $data['who_seksi_create'] . "',id_non_rutin,transaksi_detail_nomor,transaksi_detail_urut,transaksi_detail_keterangan,transaksi_detail_kode_tracking,transaksi_detail_klasifikasi_id,transaksi_detail_nomor_sample,transaksi_detail_id_template_keterangan,transaksi_detail_is_template_keterangan,transaksi_detail_pic_telepon,transaksi_detail_attach,transaksi_detail_judul,transaksi_detail_identitas,transaksi_detail_deskripsi_parameter,transaksi_detail_catatan,id_user_disposisi,id_disposisi,id_seksi_disposisi, '" . $data['transaksi_detail_reject_alasan'] . "',transaksi_detail_agreement_keterangan,is_sampling,NULL,transaksi_detail_tgl_sampling,transaksi_detail_tgl_pengujian FROM sample.sample_transaksi_detail WHERE transaksi_detail_id = '" . $data['transaksi_detail_id_temp'] . "'");

		return $this->db->affected_rows();
	}

	/* INSERT */

	// INSERT BATAL
	public function insertBatal($data = ''){


		$this->db->query("INSERT INTO sample.sample_transaksi_detail SELECT '" . $data['transaksi_detail_id'] . "',id_seksi,identitas_id,jenis_id,peminta_jasa_id,'" . $data['transaksi_id'] . "',transaksi_detail_pic_pengirim,transaksi_detail_ext_pengirim,transaksi_detail_jumlah,transaksi_detail_parameter,transaksi_detail_tgl_pengajuan,transaksi_detail_tgl_memo,transaksi_detail_no_memo,transaksi_detail_foto,transaksi_detail_tgl_estimasi,transaksi_detail_file,transaksi_detail_no_surat,is_urgent,jenis_pekerjaan_id,'" . $data['when_create'] . "','" . $data['who_create'] . "',transaksi_detail_note,'" . $data['transaksi_detail_status'] . "',is_khusus,id_user,'" . $data['who_seksi_create'] . "',id_non_rutin,transaksi_detail_nomor,transaksi_detail_urut,transaksi_detail_keterangan,transaksi_detail_kode_tracking,transaksi_detail_klasifikasi_id,transaksi_detail_nomor_sample,transaksi_detail_id_template_keterangan,transaksi_detail_is_template_keterangan,transaksi_detail_pic_telepon,transaksi_detail_attach,transaksi_detail_judul,transaksi_detail_identitas,transaksi_detail_deskripsi_parameter,transaksi_detail_catatan,id_user_disposisi,id_disposisi,id_seksi_disposisi,'" . $data['transaksi_detail_reject_alasan'] . "',transaksi_detail_agreement_keterangan,is_sampling,NULL,transaksi_detail_tgl_sampling,transaksi_detail_tgl_pengujian FROM sample.sample_transaksi_detail WHERE transaksi_detail_id = '" . $data['transaksi_detail_id_temp'] . "'");
	}
	// INSERT BATAL

	/* INSERT CLOSSED */
	public function insertInboxClossedx($data){
		$this->db->query("INSERT INTO sample.sample_transaksi_detail SELECT '" . $data['transaksi_detail_id'] . "', id_seksi, identitas_id, jenis_id, peminta_jasa_id, a.transaksi_id, transaksi_detail_pic_pengirim, transaksi_detail_ext_pengirim, transaksi_detail_jumlah, transaksi_detail_parameter, transaksi_detail_tgl_pengajuan, '" . $data['transaksi_detail_tgl_memo'] . "', '" . $data['transaksi_detail_no_memo'] . "', transaksi_detail_foto, '" . $data['transaksi_detail_tgl_estimasi'] . "', '" . $data['transaksi_detail_file'] . "', '" . $data['transaksi_detail_no_surat'] . "', is_urgent, jenis_pekerjaan_id, '" . $data['when_create'] . "', '" . $data['who_create'] . "', '" . $data['transaksi_detail_note'] . "', '" . $data['transaksi_detail_status'] . "' FROM sample.sample_transaksi_detail a LEFT JOIN sample.sample_transaksi b ON a.transaksi_detail_id = b.id_transaksi_detail WHERE b.transaksi_id = '" . $data['transaksi_id'] . "'");

		return $this->db->affected_rows();
	}
	/* INSERT CLOSSED */

	/* SPLIT */
	public function insertTransaksiSplit($id, $id_baru, $nomor_baru, $urut){
		$this->db->query("INSERT INTO sample.sample_transaksi SELECT '" . $id_baru . "', company_code, transaksi_tgl, transaksi_tipe, transaksi_status, when_create, who_create, id_transaksi_detail||'_'||'" . $urut . "', '" . $nomor_baru . "', '" . NULL . "', who_seksi_create FROM sample.sample_transaksi WHERE transaksi_id = '" . $id . "'");

		return $this->db->affected_rows();
	}

	public function insertTransaksiDetailSplit($id, $id_baru, $urut){
		$this->db->query("INSERT INTO sample.sample_transaksi_detail SELECT transaksi_detail_id||'_'||'" . $urut . "', id_seksi, identitas_id, jenis_id, peminta_jasa_id, '" . $id_baru . "', transaksi_detail_pic_pengirim, transaksi_detail_ext_pengirim, transaksi_detail_jumlah, transaksi_detail_parameter, transaksi_detail_tgl_pengajuan, transaksi_detail_tgl_memo, transaksi_detail_no_memo, transaksi_detail_foto, transaksi_detail_tgl_estimasi, transaksi_detail_file, transaksi_detail_no_surat, is_urgent, jenis_pekerjaan_id, when_create, who_create, transaksi_detail_note, transaksi_detail_status, is_khusus, id_user, who_seksi_create FROM sample.sample_transaksi_detail WHERE transaksi_id = '" . $id . "'");

		return $this->db->affected_rows();
	}

	public function insertTransaksiSeksiDisposisiSplit($id, $id_baru, $urut){
		$this->db->query("INSERT INTO sample.sample_seksi_disposisi SELECT seksi_disposisi_id||'_'||'" . $urut . "', id_seksi, '" . $id_baru . "' FROM sample.sample_seksi_disposisi WHERE id_transaksi = '" . $id . "'");

		return $this->db->affected_rows();
	}

	public function insertTransaksiPetugasSplit($id, $id_baru, $urut){
		$this->db->query("INSERT INTO sample.sample_petugas SELECT petugas_id||'_'||'" . $urut . "', '" . $id_baru . "', id_user FROM sample.sample_petugas WHERE id_transaksi = '" . $id . "'");

		return $this->db->affected_rows();
	}
	/* SPLIT */

	// INSERT HISTORY DISPOSISI
	public function insertHistoryDisposisi($data){
		$this->db->insert('sample.sample_seksi_disposisi_history', $data);
		return $this->db->affected_rows();
	}

	public function insertAlihkan($data){
		$this->db->insert('sample.sample_seksi_disposisi', $data);

		return $this->db->affected_rows();
	}

	public function hapusDisposisiLama($id){
		$this->db->where('seksi_disposisi_id', $id);
		$this->db->delete('sample.sample_seksi_disposisi');

		return $this->db->affected_rows();
	}
	// INSERT HISTORY DISPOSISI

	public function insertLogSheet($data = ''){
		$this->db->insert('sample.sample_logsheet', $data);
		return	$this->db->affected_rows();
	}

	public function insertLogSheetDetail($data = ''){
		$this->db->insert('sample.sample_logsheet_detail', $data);
		return	$this->db->affected_rows();
	}

	public function insertLogSheetDetailDetail($data = ''){
		$this->db->insert('sample.sample_logsheet_detail_detail', $data);
		return	$this->db->affected_rows();
	}

	// UPDATE
	public function updateLogSheet($id, $data = ''){
		$this->db->where('logsheet_id', $id);
		$this->db->update('sample.sample_logsheet', $data);
		return	$this->db->affected_rows();
	}

	public function updateTransaksiSeksiDisposisi($where, $data){

		if (isset($where['id_seksi'])) $this->db->where('id_seksi', $where['id_seksi']);
		if (isset($where['id_transaksi'])) $this->db->where('id_transaksi', $where['id_transaksi']);
		if (isset($where['id_transaksi_detail'])) $this->db->where('id_transaksi_detail', $where['id_transaksi_detail']);

		$this->db->update('sample.sample_seksi_disposisi', $data);

		return $this->db->affected_rows();
	}
	// UPDATE

	// DELETE
	public function deleteDisposisi($param = ''){
		$this->db->where('id_transaksi', $param['id_transaksi']);
		$this->db->where('id_transaksi_detail', $param['id_transaksi_detail']);
		$this->db->delete('sample.sample_seksi_disposisi');
		return	$this->db->affected_rows();
	}

	public function deleteLogsheet($param){
		if (isset($param['id_transaksi'])) $this->db->where('id_transaksi', $param['id_transaksi']);
		if (isset($param['id_transaksi_detail'])) $this->db->where('id_transaksi_detail', $param['id_transaksi_detail']);
		$this->db->delete('sample.sample_logsheet');
		return $this->db->affected_rows();
	}

	public function deleteLogsheetDetail($param){
		if (isset($param['logsheet_id'])) $this->db->where('logsheet_id', $param['logsheet_id']);
		$this->db->delete('sample.sample_logsheet_detail');
		return $this->db->affected_rows();
	}

	public function deleteLogsheetDetailDetail($param){
		if (isset($param['id_logsheet'])) $this->db->where('id_logsheet', $param['id_logsheet']);
		if (isset($param['id_logsheet_detail'])) $this->db->where('id_logsheet_detail', $param['id_logsheet_detail']);
		$this->db->delete('sample.sample_logsheet_detail_detail');
		return $this->db->affected_rows();
	}
	// DELETE
}
