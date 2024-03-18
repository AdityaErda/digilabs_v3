<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_request extends CI_Model{
	/* GET */
	// load table awal
	public function getRequestMain($data = '', $where = ''){
		$this->db->select("*, to_char(a.transaksi_tgl, 'DD-MM-YYYY') AS transaksi_detail_tgl_pengajuan_baru");
		$this->db->from('sample.sample_transaksi a');
		$this->db->join('sample.sample_peminta_jasa b', 'a.transaksi_id_peminta_jasa=b.peminta_jasa_id', 'left');

		if (!empty($where)) $this->db->where($where);
		if (isset($data['transaksi_id'])) $this->db->where('a.transaksi_id', $data['transaksi_id']);
		if (isset($data['transaksi_non_rutin_id'])) $this->db->where('g.transaksi_non_rutin_id', $data['transaksi_non_rutin_id']);
		if (isset($data['tanggal_cari_awal'])) $this->db->where('DATE(a.transaksi_tgl) >=', $data['tanggal_cari_awal']);
		if (isset($data['tanggal_cari_akhir'])) $this->db->where('DATE(a.transaksi_tgl) <=', $data['tanggal_cari_akhir']);
		// if (isset($data['transaksi_non_rutin_id'])) {
		if (isset($data['seksi_id'])) $this->db->where("(a.who_seksi_create = '" . $data['seksi_id'] . "')");
		// }
		if (isset($data['transaksi_status'])) $this->db->where('a.transaksi_status', $data['transaksi_status']);
		if (isset($data['array_transaksi_status_in'])) $this->db->where_in('transaksi_status', $data['array_transaksi_status_in']);
		if (isset($data['array_transaksi_status_not_in'])) $this->db->where_not_in('transaksi_status', $data['array_transaksi_status_not_in']);
		if (isset($data['track_sample'])) $this->db->where("upper(a.transaksi_nomor) = '" . strtoupper($data['track_sample']) . "' OR upper(jenis_nama) LIKE '%" . strtoupper($data['track_sample']) . "%'");

		$this->db->where("id_transaksi_non_rutin is not null");
		$this->db->where("transaksi_tipe!='R'");

		$this->db->order_by('a.transaksi_tgl', 'desc');
		$this->db->order_by('a.transaksi_nomor', 'desc');
		$this->db->order_by('a.when_create', 'desc');
		$this->db->order_by('a.transaksi_status', 'asc');
		$sql = $this->db->get();

		return (isset($data['transaksi_non_rutin_id'])) ? $sql->row_array() : $sql->result_array();
	}

	// load dalam form

	public function getAllRequest($data = ''){
		$this->db->select("a.who_seksi_create,a.transaksi_nomor, a.transaksi_tipe, a.transaksi_status, a.transaksi_tgl,a.when_create,b.peminta_jasa_id,b.transaksi_detail_no_memo,b.transaksi_detail_note, b.transaksi_detail_pic_pengirim,b.transaksi_detail_ext_pengirim,b.transaksi_detail_nomor_sample, d.peminta_jasa_nama, g.transaksi_non_rutin_id,h.*,  to_char(b.transaksi_detail_tgl_pengajuan, 'DD-MM-YYYY') AS transaksi_detail_tgl_pengajuan_baru, to_char(b.transaksi_detail_tgl_memo, 'DD-MM-YYYY') AS transaksi_detail_tgl_memo_baru, to_char(b.transaksi_detail_tgl_estimasi, 'DD-MM-YYYY') AS transaksi_detail_tgl_estimasi_baru, b.transaksi_detail_note as note_awal,i.*,j.*,a.transaksi_judul,b.transaksi_detail_pic_telepon,a.transaksi_id_template_keterangan,k.user_nik_sap,k.user_nama,k.user_post_title,l.user_nik_sap as nik_reviewer,l.user_nama as nama_reviewer,l.user_post_title as title_reviewer,m.user_nik_sap as nik_approver,m.user_nama as nama_approver,m.user_post_title as title_approver, n.user_nik_sap as nik_tujuan,n.user_nama as nama_tujuan,n.user_post_title as title_tujuan,o.user_nik_sap as nik_drafter,o.user_nama as nama_drafter,o.user_post_title as title_drafter,p.user_nik_sap as nik_pic_pengirim,p.user_nama as nama_pic_pengirim,p.user_post_title as title_pic_pengirim,a.transaksi_drafter,a.transaksi_attach,a.transaksi_sifat,a.transaksi_kecepatan_tanggap,a.id_transaksi_non_rutin,a.transaksi_klasifikasi_id,a.transaksi_id_user,transaksi_pic_ext,transaksi_pic_telepon,b.id_user_disposisi,b.id_seksi_disposisi,a.transaksi_reject_alasan,b.transaksi_detail_reject_alasan,a.transaksi_id,q.jenis_nama,transaksi_reviewer_poscode,transaksi_approver_poscode,transaksi_drafter_poscode,transaksi_tujuan_poscode,transaksi_pic_pengirim_id,transaksi_pic_poscode,transaksi_detail_status,transaksi_detail_id,is_proses");
		$this->db->distinct();
		$this->db->from('sample.sample_transaksi a');
		$this->db->join('sample.sample_transaksi_detail b', 'a.transaksi_id = b.transaksi_id ', 'left');
		$this->db->join('sample.sample_peminta_jasa d', 'd.peminta_jasa_id = b.peminta_jasa_id', 'left');
		$this->db->join('sample.sample_transaksi_non_rutin g', 'g.transaksi_non_rutin_id = b.id_non_rutin AND g.transaksi_non_rutin_id = a.id_transaksi_non_rutin', 'left');
		$this->db->join('sample.sample_klasifikasi h', 'h.klasifikasi_id = a.transaksi_klasifikasi_id', 'left');
		$this->db->join('sample.sample_transaksi_keterangan i', 'a.transaksi_id_template_keterangan = i.transaksi_keterangan_id', 'left');
		$this->db->join('sample.sample_template_keterangan j', 'j.template_keterangan_id = i.transaksi_id_template', 'left');
		$this->db->join('global.global_api_user k', 'k.user_nik_sap = b.transaksi_detail_pic_pengirim', 'left');
		$this->db->join('global.global_api_user l', 'l.user_nik_sap = a.transaksi_reviewer', 'left');
		$this->db->join('global.global_api_user m', 'm.user_nik_sap = a.transaksi_approver', 'left');
		$this->db->join('global.global_api_user n', 'n.user_nik_sap = a.transaksi_tujuan', 'left');
		$this->db->join('global.global_api_user o', 'o.user_nik_sap = a.transaksi_drafter', 'left');
		$this->db->join('global.global_api_user p', 'p.user_nik_sap = a.transaksi_pic_pengirim_id', 'left');
		$this->db->join('sample.sample_jenis q', 'q.jenis_id = b.jenis_id ', 'left');

		if (!empty($where)) $this->db->where(($where));
		if (isset($data['transaksi_id'])) $this->db->where('a.transaksi_id', $data['transaksi_id']);
		if (isset($data['transaksi_non_rutin_id'])) $this->db->where('g.transaksi_non_rutin_id', $data['transaksi_non_rutin_id']);

		if (isset($data['tanggal_cari_awal'])) $this->db->where('DATE(a.transaksi_tgl) >=', $data['tanggal_cari_awal']);
		if (isset($data['tanggal_cari_akhir'])) $this->db->where('DATE(a.transaksi_tgl) <=', $data['tanggal_cari_akhir']);

		if (isset($data['tahun'])) $this->db->where("date_part('year', a.transaksi_tgl) = " . $data['tahun']);
		if (isset($data['transaksi_non_rutin_id']) && ($data['transaksi_non_rutin_id'] == '')) {
			if (isset($data['seksi_id'])) $this->db->where('a.who_seksi_create', $data['seksi_id']);
			if (isset($data['seksi_id'])) $this->db->or_where('b.who_seksi_create', $data['seksi_id']);
			if (isset($data['seksi_id'])) $this->db->or_where('b.who_seksi_create', 'E44000');
		}
		if (isset($data['transaksi_status_not_array'])) $this->db->where_not_in('a.transaksi_status', $data['transaksi_status_not_array']);
		if (isset($data['transaksi_status_not_array2'])) $this->db->where_not_in('a.transaksi_status', $data['transaksi_status_not_array2']);
		if (isset($data['transaksi_status'])) $this->db->where('a.transaksi_status', $data['transaksi_status']);

		// if (isset($data['track_sample'])) $this->db->where("upper(a.transaksi_nomor) = '" . strtoupper($data['track_sample']) . "' OR upper(jenis_nama) LIKE '%" . strtoupper($data['track_sample']) . "%'");
		if (isset($data['track_sample'])) $this->db->like('UPPER(transaksi_nomor)', strtoupper($data['track_sample']), 'BOTH');
		// if (isset($data['track_sample'])) $this->db->or_like('(transaksi_detail_nomor)', strtoupper($data['track_sample']), 'BOTH');

		$this->db->where("(is_proses!='y' OR is_proses is NULL)");

		$this->db->order_by('a.transaksi_nomor', 'asc');
		$this->db->order_by('a.transaksi_tgl', 'desc');
		$this->db->order_by('a.when_create', 'desc');
		$this->db->order_by('a.transaksi_status', 'asc');
		$sql = $this->db->get();

		return (isset($data['transaksi_non_rutin_id']) || isset($data['transaksi_id'])) ? $sql->row_array() : $sql->result_array();
	}


	public function getRequestAll($data = ''){
		$this->db->select("a.*, a.id_transaksi_non_rutin AS transaksi_non_rutin_id, b.*, c.*, d.user_nik_sap AS nik_reviewer, d.user_nama AS nama_reviewer, d.user_post_title AS title_reviewer, e.user_nik_sap AS nik_approver, e.user_nama AS nama_approver, e.user_post_title AS title_approver, f.user_nik_sap AS nik_tujuan, f.user_nama AS nama_tujuan, f.user_post_title AS title_tujuan, g.user_nik_sap AS nik_drafter, g.user_nama AS nama_drafter, g.user_post_title AS title_drafter, g.user_nik_sap AS nik_pic_pengirim, g.user_nama AS nama_pic_pengirim, g.user_post_title AS title_pic_pengirim");
		$this->db->from('sample.sample_transaksi a');
		$this->db->join('sample.sample_peminta_jasa b', 'a.transaksi_id_peminta_jasa = b.peminta_jasa_id', 'left');
		$this->db->join('sample.sample_klasifikasi c', 'c.klasifikasi_id = a.transaksi_klasifikasi_id', 'left');
		$this->db->join('global.global_api_user d', 'd.user_nik_sap = a.transaksi_reviewer', 'left');
		$this->db->join('global.global_api_user e', 'e.user_nik_sap = a.transaksi_approver', 'left');
		$this->db->join('global.global_api_user f', 'f.user_nik_sap = a.transaksi_tujuan', 'left');
		$this->db->join('global.global_api_user g', 'g.user_nik_sap = a.transaksi_drafter', 'left');

		if (!empty($where)) $this->db->where(($where));
		if (isset($data['transaksi_id'])) $this->db->where('a.transaksi_id', $data['transaksi_id']);
		if (isset($data['transaksi_non_rutin_id'])) $this->db->where('a.id_transaksi_non_rutin', $data['transaksi_non_rutin_id']);

		if (isset($data['tanggal_cari_awal'])) $this->db->where('DATE(a.transaksi_tgl) >=', $data['tanggal_cari_awal']);
		if (isset($data['tanggal_cari_akhir'])) $this->db->where('DATE(a.transaksi_tgl) <=', $data['tanggal_cari_akhir']);

		if (isset($data['tahun'])) $this->db->where("date_part('year', a.transaksi_tgl) = " . $data['tahun']);
		if (isset($data['transaksi_status_not_array'])) $this->db->where_not_in('a.transaksi_status', $data['transaksi_status_not_array']);
		if (isset($data['transaksi_status_not_array2'])) $this->db->where_not_in('a.transaksi_status', $data['transaksi_status_not_array2']);
		if (isset($data['transaksi_status'])) $this->db->where('a.transaksi_status', $data['transaksi_status']);

		if (isset($data['track_sample'])) $this->db->where("upper(a.transaksi_nomor) = '" . strtoupper($data['track_sample']) . "' OR upper(jenis_nama) LIKE '%" . strtoupper($data['track_sample']) . "%'");

		$this->db->order_by('a.transaksi_nomor', 'asc');
		$this->db->order_by('a.transaksi_tgl', 'desc');
		$this->db->order_by('a.when_create', 'desc');
		$this->db->order_by('a.transaksi_status', 'asc');
		$sql = $this->db->get();

		return (isset($data['transaksi_non_rutin_id']) || isset($data['transaksi_id'])) ? $sql->row_array() : $sql->result_array();
	}
	// load detail


	public function getRequest($data = null, $where = null){
		$this->db->select("a.transaksi_nomor,a.transaksi_tgl,a.when_create,a.transaksi_sifat,a.transaksi_kecepatan_tanggap,a.transaksi_id,a.transaksi_nomor, a.transaksi_tipe, a.transaksi_status,b.transaksi_detail_status,b.transaksi_detail_no_memo, b.transaksi_detail_no_surat,b.transaksi_detail_note,b.transaksi_detail_nomor,b.transaksi_detail_nomor_sample, c.jenis_nama, d.peminta_jasa_nama, e.sample_pekerjaan_nama, f.identitas_nama, g.*, to_char(b.transaksi_detail_tgl_pengajuan, 'DD-MM-YYYY') AS transaksi_detail_tgl_pengajuan_baru, to_char(b.transaksi_detail_tgl_memo, 'DD-MM-YYYY') AS transaksi_detail_tgl_memo_baru, to_char(b.transaksi_detail_tgl_estimasi, 'DD-MM-YYYY') AS transaksi_detail_tgl_estimasi_baru, b.transaksi_detail_note as note_awal");
		$this->db->distinct();
		$this->db->from('sample.sample_transaksi a');
		$this->db->join('sample.sample_transaksi_detail b', 'a.transaksi_id = b.transaksi_id', 'left');
		// $this->db->join('sample.sample_transaksi_detail b', 'a.transaksi_id = b.transaksi_id AND a.id_transaksi_detail = b.transaksi_detail_id', 'left');
		$this->db->join('sample.sample_jenis c', 'c.jenis_id = b.jenis_id', 'left');
		$this->db->join('sample.sample_peminta_jasa d', 'd.peminta_jasa_id = b.peminta_jasa_id', 'left');
		$this->db->join('sample.sample_pekerjaan e', 'e.sample_pekerjaan_id = b.jenis_pekerjaan_id', 'left');
		$this->db->join('sample.sample_identitas f', 'f.identitas_id = b.identitas_id', 'left');
		$this->db->join('sample.sample_klasifikasi g', 'g.klasifikasi_id = a.transaksi_klasifikasi_id', 'left');

		if (!empty($where)) $this->db->where(($where));
		if (isset($data['transaksi_id'])) $this->db->where('a.transaksi_id', $data['transaksi_id']);

		if (isset($data['tanggal_cari_awal'])) $this->db->where('DATE(a.transaksi_tgl) >= ', $data['tanggal_cari_awal']);
		if (isset($data['tanggal_cari_akhir'])) $this->db->where('DATE(a.transaksi_tgl) <= ', $data['tanggal_cari_akhir']);

		if (isset($data['transaksi_tipe']) & $data['transaksi_tipe'] != '-') {
			if (isset($data['transaksi_tipe'])) $this->db->where_in("a.transaksi_tipe", $data['transaksi_tipe']);
			if (isset($data['transaksi_status_request'])) $this->db->where("a.transaksi_status", $data['transaksi_status_request']);
		};
		if (isset($data['tahun'])) $this->db->where("date_part('year', a.transaksi_tgl) = " . $data['tahun']);
		if (isset($data['seksi_id'])) $this->db->where('a.who_seksi_create', $data['seksi_id']);
		if (isset($data['transaksi_status'])) $this->db->where_not_in('a.transaksi_status', $data['transaksi_status']);

		if (isset($data['track_sample'])) $this->db->like('(transaksi_nomor)', strtoupper($data['track_sample']), 'BOTH');
		if (isset($data['track_sample'])) $this->db->or_like('(transaksi_detail_nomor)', strtoupper($data['track_sample']), 'BOTH');

		$this->db->where("b.is_proses  is null");


		$this->db->order_by('a.transaksi_nomor', 'asc');
		$this->db->order_by('a.transaksi_tgl', 'desc');
		$this->db->order_by('a.when_create', 'desc');
		// $this->db->order_by('a.transaksi_status', 'asc');
		$this->db->order_by('b.transaksi_detail_status', 'asc');
		$sql = $this->db->get();

		return (isset($data['transaksi_id'])) ? $sql->row_array() : $sql->result_array();
	}



	public function getRequestUtama($data = null, $where = null){
		$this->db->select("a.who_seksi_create,a.transaksi_nomor, a.transaksi_tipe, a.transaksi_status, b.peminta_jasa_id,b.transaksi_detail_no_memo,b.transaksi_detail_note, b.transaksi_detail_pic_pengirim,b.transaksi_detail_ext_pengirim, d.peminta_jasa_nama, g.transaksi_non_rutin_id,h.*,  to_char(b.transaksi_detail_tgl_pengajuan, 'DD-MM-YYYY') AS transaksi_detail_tgl_pengajuan_baru, to_char(b.transaksi_detail_tgl_memo, 'DD-MM-YYYY') AS transaksi_detail_tgl_memo_baru, to_char(b.transaksi_detail_tgl_estimasi, 'DD-MM-YYYY') AS transaksi_detail_tgl_estimasi_baru, b.transaksi_detail_note as note_awal,i.*,j.*,a.transaksi_judul,b.transaksi_detail_pic_telepon,a.transaksi_id_template_keterangan,k.user_nik_sap,k.user_nama,k.user_post_title,l.user_nik_sap as nik_reviewer,l.user_nama as nama_reviewer,l.user_post_title as title_reviewer,m.user_nik_sap as nik_approver,m.user_nama as nama_approver,m.user_post_title as title_approver, n.user_nik_sap as nik_tujuan,n.user_nama as nama_tujuan,n.user_post_title as title_tujuan,o.user_nik_sap as nik_drafter,o.user_nama as nama_drafter,o.user_post_title as title_drafter,p.user_nik_sap as nik_pic_pengirim,p.user_nama as nama_pic_pengirim,p.user_post_title as title_pic_pengirim,a.transaksi_drafter,a.transaksi_attach,a.transaksi_sifat,a.transaksi_kecepatan_tanggap,a.id_transaksi_non_rutin,a.transaksi_klasifikasi_id,a.transaksi_id_user,transaksi_pic_ext,transaksi_pic_telepon,b.id_user_disposisi,b.id_seksi_disposisi");
		$this->db->from('sample.sample_transaksi a');
		$this->db->join('sample.sample_transaksi_detail b', 'a.transaksi_id = b.transaksi_id AND a.transaksi_status=b.transaksi_detail_status', 'left');
		$this->db->join('sample.sample_peminta_jasa d', 'd.peminta_jasa_id = b.peminta_jasa_id', 'left');
		$this->db->join('sample.sample_transaksi_non_rutin g', 'g.transaksi_non_rutin_id = b.id_non_rutin AND g.transaksi_non_rutin_id = a.id_transaksi_non_rutin', 'left');
		$this->db->join('sample.sample_klasifikasi h', 'h.klasifikasi_id = a.transaksi_klasifikasi_id', 'left');
		$this->db->join('sample.sample_transaksi_keterangan i', 'a.transaksi_id_template_keterangan = i.transaksi_keterangan_id', 'left');
		$this->db->join('sample.sample_template_keterangan j', 'j.template_keterangan_id = i.transaksi_id_template', 'left');
		$this->db->join('global.global_api_user k', 'k.user_nik_sap = b.transaksi_detail_pic_pengirim', 'left');
		$this->db->join('global.global_api_user l', 'l.user_nik_sap = a.transaksi_reviewer', 'left');
		$this->db->join('global.global_api_user m', 'm.user_nik_sap = a.transaksi_approver', 'left');
		$this->db->join('global.global_api_user n', 'n.user_nik_sap = a.transaksi_tujuan', 'left');
		$this->db->join('global.global_api_user o', 'o.user_nik_sap = a.transaksi_drafter', 'left');
		$this->db->join('global.global_api_user p', 'p.user_nik_sap = a.transaksi_pic_pengirim_id', 'left');

		if (!empty($where)) $this->db->where(($where));
		if (isset($data['transaksi_id'])) $this->db->where('a.transaksi_id', $data['transaksi_id']);
		if (isset($data['transaksi_non_rutin_id'])) $this->db->where('g.transaksi_non_rutin_id', $data['transaksi_non_rutin_id']);

		if (isset($data['tanggal_cari_awal'])) $this->db->where('DATE(a.transaksi_tgl) >=', $data['tanggal_cari_awal']);
		if (isset($data['tanggal_cari_akhir'])) $this->db->where('DATE(a.transaksi_tgl) <=', $data['tanggal_cari_akhir']);

		// if (isset($data['transaksi_tipe']) && $data['transaksi_tipe'] != '-') {
		// 	if (isset($data['transaksi_tipe'])) $this->db->where_in("a.transaksi_tipe", $data['transaksi_tipe']);
		// 	if (isset($data['transaksi_status_request'])) $this->db->where_in("a.transaksi_status", $data['transaksi_status_request']);
		// };
		if (isset($data['tahun'])) $this->db->where("date_part('year', a.transaksi_tgl) = " . $data['tahun']);
		if (($data['transaksi_non_rutin_id'] == '')) {
			if (isset($data['seksi_id'])) $this->db->where('a.who_seksi_create', $data['seksi_id']);
			if (isset($data['seksi_id'])) $this->db->or_where('b.who_seksi_create', $data['seksi_id']);
			if (isset($data['seksi_id'])) $this->db->or_where('b.who_seksi_create', 'E44000');
		}
		// if (isset($data['seksi_id'])) $this->db->or_where('b.id_seksi_disposisi', $data['seksi_id']);
		if (isset($data['transaksi_status_not_array'])) $this->db->where_not_in('a.transaksi_status', $data['transaksi_status_not_array']);
		if (isset($data['transaksi_status_not_array2'])) $this->db->where_not_in('a.transaksi_status', $data['transaksi_status_not_array2']);
		if (isset($data['transaksi_status'])) $this->db->where('a.transaksi_status', $data['transaksi_status']);

		if (isset($data['track_sample'])) $this->db->where("upper(a.transaksi_nomor) = '" . strtoupper($data['track_sample']) . "' OR upper(jenis_nama) LIKE '%" . strtoupper($data['track_sample']) . "%'");

		$this->db->group_by('g.transaksi_non_rutin_id');
		// $this->db->group_by('a.transaksi_id');
		$this->db->group_by('b.peminta_jasa_id');
		$this->db->group_by('b.transaksi_detail_no_memo');
		$this->db->group_by('b.transaksi_detail_tgl_memo');
		$this->db->group_by('b.transaksi_detail_tgl_pengajuan');
		$this->db->group_by('b.transaksi_detail_tgl_estimasi');
		$this->db->group_by('b.transaksi_detail_note');
		$this->db->group_by('b.transaksi_detail_pic_pengirim');
		$this->db->group_by('b.transaksi_detail_pic_telepon');
		$this->db->group_by('b.transaksi_detail_ext_pengirim');
		$this->db->group_by('d.peminta_jasa_nama');
		$this->db->group_by('transaksi_nomor');
		$this->db->group_by('transaksi_tipe');
		$this->db->group_by('transaksi_status');
		$this->db->group_by('transaksi_tgl');
		$this->db->group_by('a.when_create');
		$this->db->group_by('a.transaksi_id_template_keterangan');
		$this->db->group_by('h.klasifikasi_id');
		$this->db->group_by('i.transaksi_keterangan_id');
		$this->db->group_by('j.template_keterangan_id');
		$this->db->group_by('a.transaksi_judul');
		$this->db->group_by('k.user_nik_sap');
		$this->db->group_by('k.user_nama');
		$this->db->group_by('k.user_post_title');
		$this->db->group_by('l.user_nik_sap');
		$this->db->group_by('l.user_nama');
		$this->db->group_by('l.user_post_title');
		$this->db->group_by('m.user_nik_sap');
		$this->db->group_by('m.user_nama');
		$this->db->group_by('m.user_post_title');
		$this->db->group_by('n.user_nik_sap');
		$this->db->group_by('n.user_nama');
		$this->db->group_by('n.user_post_title');
		$this->db->group_by('o.user_nik_sap');
		$this->db->group_by('o.user_nama');
		$this->db->group_by('o.user_post_title');
		$this->db->group_by('p.user_nik_sap');
		$this->db->group_by('p.user_nama');
		$this->db->group_by('p.user_post_title');
		$this->db->group_by('a.transaksi_drafter');
		$this->db->group_by('a.transaksi_attach');
		$this->db->group_by('a.transaksi_sifat');
		$this->db->group_by('a.transaksi_kecepatan_tanggap');
		$this->db->group_by('a.id_transaksi_non_rutin');
		$this->db->group_by('a.transaksi_klasifikasi_id');
		$this->db->group_by('a.transaksi_id_user');
		$this->db->group_by('a.transaksi_pic_telepon');
		$this->db->group_by('a.transaksi_pic_ext');
		$this->db->group_by('b.id_user_disposisi');
		$this->db->group_by('b.id_seksi_disposisi');
		$this->db->group_by('a.who_seksi_create');




		$this->db->order_by('a.transaksi_nomor', 'asc');
		$this->db->order_by('a.transaksi_tgl', 'desc');
		$this->db->order_by('a.when_create', 'desc');
		$this->db->order_by('a.transaksi_status', 'asc');
		// $this->db->order_by('a.transaksi_detail_status','asc');
		$sql = $this->db->get();

		// return (isset($data['transaksi_id'])) ? $sql->row_array() : $sql->result_array();
		return (isset($data['transaksi_non_rutin_id'])) ? $sql->row_array() : $sql->result_array();
	}

	public function getRequestNew($data = null, $where = null){
		$this->db->select("a.transaksi_nomor, a.transaksi_tipe, a.transaksi_status, b.peminta_jasa_id,b.jenis_pekerjaan_id,b.transaksi_detail_no_memo,b.transaksi_detail_note, b.transaksi_detail_pic_pengirim,b.transaksi_detail_ext_pengirim, d.peminta_jasa_nama, e.sample_pekerjaan_nama,g.transaksi_non_rutin_id,h.*,  to_char(b.transaksi_detail_tgl_pengajuan, 'DD-MM-YYYY') AS transaksi_detail_tgl_pengajuan_baru, to_char(b.transaksi_detail_tgl_memo, 'DD-MM-YYYY') AS transaksi_detail_tgl_memo_baru, to_char(b.transaksi_detail_tgl_estimasi, 'DD-MM-YYYY') AS transaksi_detail_tgl_estimasi_baru, b.transaksi_detail_note as note_awal,i.*,j.*,a.transaksi_judul,b.transaksi_detail_pic_telepon,a.transaksi_id_template_keterangan,k.user_nik_sap,k.user_nama,k.user_post_title,l.user_nik_sap as nik_reviewer,l.user_nama as nama_reviewer,l.user_post_title as title_reviewer,m.user_nik_sap as nik_approver,m.user_nama as nama_approver,m.user_post_title as title_approver, n.user_nik_sap as nik_tujuan,n.user_nama as nama_tujuan,n.user_post_title as title_tujuan,o.user_nik_sap as nik_drafter,o.user_nama as nama_drafter,o.user_post_title as title_drafter,p.user_nik_sap as nik_pic_pengirim,p.user_nama as nama_pic_pengirim,p.user_post_title as title_pic_pengirim,a.transaksi_drafter,a.transaksi_attach,a.transaksi_sifat,a.transaksi_kecepatan_tanggap,a.id_transaksi_non_rutin,a.transaksi_klasifikasi_id,a.transaksi_id_user,transaksi_pic_ext,transaksi_pic_telepon,b.id_user_disposisi,b.id_seksi_disposisi");
		$this->db->from('sample.sample_transaksi a');
		$this->db->join('sample.sample_transaksi_detail b', 'a.id_transaksi_detail = b.transaksi_detail_id AND a.transaksi_status=b.transaksi_detail_status', 'left');
		$this->db->join('sample.sample_peminta_jasa d', 'd.peminta_jasa_id = b.peminta_jasa_id', 'left');
		$this->db->join('sample.sample_pekerjaan e', 'e.sample_pekerjaan_id = b.jenis_pekerjaan_id', 'left');
		$this->db->join('sample.sample_transaksi_non_rutin g', 'g.transaksi_non_rutin_id = b.id_non_rutin AND g.transaksi_non_rutin_id = a.id_transaksi_non_rutin', 'left');
		$this->db->join('sample.sample_klasifikasi h', 'h.klasifikasi_id = a.transaksi_klasifikasi_id', 'left');
		$this->db->join('sample.sample_transaksi_keterangan i', 'a.transaksi_id_template_keterangan = i.transaksi_keterangan_id', 'left');
		$this->db->join('sample.sample_template_keterangan j', 'j.template_keterangan_id = i.transaksi_id_template', 'left');
		$this->db->join('global.global_api_user k', 'k.user_nik_sap = b.transaksi_detail_pic_pengirim', 'left');
		$this->db->join('global.global_api_user l', 'l.user_nik_sap = a.transaksi_reviewer', 'left');
		$this->db->join('global.global_api_user m', 'm.user_nik_sap = a.transaksi_approver', 'left');
		$this->db->join('global.global_api_user n', 'n.user_nik_sap = a.transaksi_tujuan', 'left');
		$this->db->join('global.global_api_user o', 'o.user_nik_sap = a.transaksi_drafter', 'left');
		$this->db->join('global.global_api_user p', 'p.user_nik_sap = a.transaksi_pic_pengirim_id', 'left');

		if (!empty($where)) $this->db->where(($where));
		if (isset($data['transaksi_id'])) $this->db->where('a.transaksi_id', $data['transaksi_id']);
		if (isset($data['transaksi_non_rutin_id'])) $this->db->where('a.id_transaksi_non_rutin', $data['transaksi_non_rutin_id']);

		if (isset($data['tanggal_cari_awal'])) $this->db->where('DATE(a.transaksi_tgl) >=', $data['tanggal_cari_awal']);
		if (isset($data['tanggal_cari_akhir'])) $this->db->where('DATE(a.transaksi_tgl) <=', $data['tanggal_cari_akhir']);

		// if (isset($data['transaksi_tipe']) && $data['transaksi_tipe'] != '-') {
		// 	if (isset($data['transaksi_tipe'])) $this->db->where_in("a.transaksi_tipe", $data['transaksi_tipe']);
		// 	if (isset($data['transaksi_status_request'])) $this->db->where_in("a.transaksi_status", $data['transaksi_status_request']);
		// };
		if (isset($data['tahun'])) $this->db->where("date_part('year', a.transaksi_tgl) = " . $data['tahun']);
		if (isset($data['seksi_id'])) $this->db->where('b.who_seksi_create', $data['seksi_id']);
		if (isset($data['seksi_id'])) $this->db->or_where('a.who_seksi_create', $data['seksi_id']);
		if (isset($data['seksi_id'])) $this->db->or_where('b.who_seksi_create', 'E44000');
		// if (isset($data['seksi_id'])) $this->db->or_where('b.id_seksi_disposisi', $data['seksi_id']);
		if (isset($data['transaksi_status_not_array'])) $this->db->where_not_in('a.transaksi_status', $data['transaksi_status_not_array']);
		if (isset($data['transaksi_status_not_array2'])) $this->db->where_not_in('a.transaksi_status', $data['transaksi_status_not_array2']);
		if (isset($data['transaksi_status'])) $this->db->where('a.transaksi_status', $data['transaksi_status']);

		if (isset($data['track_sample'])) $this->db->where("upper(a.transaksi_nomor) = '" . strtoupper($data['track_sample']) . "' OR upper(jenis_nama) LIKE '%" . strtoupper($data['track_sample']) . "%'");

		$this->db->group_by('g.transaksi_non_rutin_id');
		// $this->db->group_by('a.transaksi_id');
		$this->db->group_by('b.peminta_jasa_id');
		$this->db->group_by('b.jenis_pekerjaan_id');
		$this->db->group_by('b.transaksi_detail_no_memo');
		$this->db->group_by('b.transaksi_detail_tgl_memo');
		$this->db->group_by('b.transaksi_detail_tgl_pengajuan');
		$this->db->group_by('b.transaksi_detail_tgl_estimasi');
		$this->db->group_by('b.transaksi_detail_note');
		$this->db->group_by('b.transaksi_detail_pic_pengirim');
		$this->db->group_by('b.transaksi_detail_pic_telepon');
		$this->db->group_by('b.transaksi_detail_ext_pengirim');
		$this->db->group_by('d.peminta_jasa_nama');
		$this->db->group_by('e.sample_pekerjaan_nama');
		$this->db->group_by('transaksi_nomor');
		$this->db->group_by('transaksi_tipe');
		$this->db->group_by('transaksi_status');
		$this->db->group_by('transaksi_tgl');
		$this->db->group_by('a.when_create');
		$this->db->group_by('a.transaksi_id_template_keterangan');
		$this->db->group_by('h.klasifikasi_id');
		$this->db->group_by('i.transaksi_keterangan_id');
		$this->db->group_by('j.template_keterangan_id');
		$this->db->group_by('a.transaksi_judul');
		$this->db->group_by('k.user_nik_sap');
		$this->db->group_by('k.user_nama');
		$this->db->group_by('k.user_post_title');
		$this->db->group_by('l.user_nik_sap');
		$this->db->group_by('l.user_nama');
		$this->db->group_by('l.user_post_title');
		$this->db->group_by('m.user_nik_sap');
		$this->db->group_by('m.user_nama');
		$this->db->group_by('m.user_post_title');
		$this->db->group_by('n.user_nik_sap');
		$this->db->group_by('n.user_nama');
		$this->db->group_by('n.user_post_title');
		$this->db->group_by('o.user_nik_sap');
		$this->db->group_by('o.user_nama');
		$this->db->group_by('o.user_post_title');
		$this->db->group_by('p.user_nik_sap');
		$this->db->group_by('p.user_nama');
		$this->db->group_by('p.user_post_title');
		$this->db->group_by('a.transaksi_drafter');
		$this->db->group_by('a.transaksi_attach');
		$this->db->group_by('a.transaksi_sifat');
		$this->db->group_by('a.transaksi_kecepatan_tanggap');
		$this->db->group_by('a.id_transaksi_non_rutin');
		$this->db->group_by('a.transaksi_klasifikasi_id');
		$this->db->group_by('a.transaksi_id_user');
		$this->db->group_by('a.transaksi_pic_telepon');
		$this->db->group_by('a.transaksi_pic_ext');
		$this->db->group_by('b.id_user_disposisi');
		$this->db->group_by('b.id_seksi_disposisi');




		$this->db->order_by('a.transaksi_nomor', 'asc');
		$this->db->order_by('a.transaksi_tgl', 'desc');
		$this->db->order_by('a.when_create', 'desc');
		$this->db->order_by('a.transaksi_status', 'asc');
		// $this->db->order_by('a.transaksi_detail_status','asc');
		$sql = $this->db->get();

		// return (isset($data['transaksi_id'])) ? $sql->row_array() : $sql->result_array();
		return (isset($data['transaksi_non_rutin_id'])) ? $sql->row_array() : $sql->result_array();
	}

	public function getRequestDOF($param = null){
		if (isset($param['transaksi_id'])) $this->db->where('a.transaksi_id', $param['transaksi_id']);
		if (isset($param['transaksi_detail_id'])) $this->db->where('b.transaksi_detail_id', $param['transaksi_detail_id']);
		if (isset($param['transaksi_detail_group'])) $this->db->where('b.transaksi_detail_group', $param['transaksi_detail_group']);
		$this->db->where("is_proses is null");


		$this->db->select("h.klasifikasi_id,h.klasifikasi_kode,h.klasifikasi_nama,a.transaksi_sifat,a.transaksi_kecepatan_tanggap,a.transaksi_judul,d.user_detail_id as id_dof_drafter , d.user_detail_name as nama_drafter , e.user_detail_id as id_dof_reviewer , e.user_detail_name as nama_reviewer , f.user_detail_id as id_dof_approver ,  f.user_detail_name as nama_approver , g.user_detail_id as id_dof_tujuan , g.user_detail_name  as nama_tujuan");
		if (isset($param['transaksi_detail_group'])) {
			$this->db->distinct();
		}
		$this->db->from('sample.sample_transaksi a');
		$this->db->join('sample.sample_transaksi_detail b', 'b.transaksi_id = a.transaksi_id', 'left');
		// untuk join logsheetnya
		$this->db->join('sample.sample_logsheet c', 'c.id_transaksi = a.transaksi_id AND c.id_transaksi_detail = b.transaksi_detail_id', 'left');
		// untuk id dof drafter
		$this->db->join('global.global_user_detail d', 'd.user_detail_userName = c.logsheet_review', 'left');
		// untuk id dof reviwer
		$this->db->join('global.global_user_detail e', 'e.user_detail_userName = b.id_user_disposisi', 'left');
		// untuk id dof approver
		$this->db->join('global.global_user_detail f', 'f.user_detail_posCode = e.user_detail_directSuperior', 'left');
		// untuk id dof tujuan
		$this->db->join('global.global_user_detail g', 'g.user_detail_userName = a.transaksi_approver', 'left');

		$this->db->join('sample.sample_klasifikasi h', 'h.klasifikasi_id = a.transaksi_klasifikasi_id', 'left');

		$sql = $this->db->get();

		return $sql->row_array();
	}

	public function getKeterangan($value = ''){
		$this->db->select('a.*,b.user_post_title as keterangan_asal,c.user_post_title as keterangan_tujuan');
		$this->db->from('sample.sample_transaksi_keterangan a');
		$this->db->join('global.global_api_user b', ' b.user_poscode = a.transaksi_keterangan_asal', 'left');
		$this->db->join('global.global_api_user c', 'c.user_poscode = a.transaksi_keterangan_tujuan', 'left');

		if (isset($value['transaksi_keterangan_id'])) $this->db->where('transaksi_keterangan_id', $value['transaksi_keterangan_id']);
		$sql = $this->db->get();

		return (isset($value['transaksi_keterangan_id'])) ? $sql->row_array() : $sql->result_array();
	}

	public function getRequestDetail($value = ''){
		$this->db->select('*');
		$this->db->from('sample.sample_transaksi_detail a');
		$this->db->join('sample.sample_jenis b', 'b.jenis_id = a.jenis_id', 'left');
		$this->db->join('sample.sample_pekerjaan c', 'c.sample_pekerjaan_id = a.jenis_pekerjaan_id', 'left');

		if (isset($value['transaksi_non_rutin_id'])) $this->db->where('id_non_rutin', $value['transaksi_non_rutin_id']);
		if (isset($value['transaksi_id'])) $this->db->where('transaksi_id', $value['transaksi_id']);
		if (isset($value['transaksi_detail_id'])) $this->db->where('transaksi_detail_id', $value['transaksi_detail_id']);
		if (isset($value['transaksi_status'])) $this->db->where('transaksi_detail_status', $value['transaksi_status']);
		if (isset($value['transaksi_detail_group'])) $this->db->where('transaksi_detail_group', $value['transaksi_detail_group']);
		if (isset($value['transaksi_detail_id_group'])) $this->db->where_in('transaksi_detail_id', $value['transaksi_detail_id_group']);
		if (isset($value['transaksi_detail_id_multiple'])) $this->db->where_in('transaksi_detail_id', $value['transaksi_detail_id_multiple']);

		$this->db->where("(is_proses is NULL)");

		$this->db->order_by("CAST(transaksi_detail_urut as FLOAT) ASC");
		$this->db->order_by("CAST(transaksi_detail_status as INT) ASC");
		$this->db->order_by('transaksi_detail_judul', 'asc');



		$sql = $this->db->get();

		return $sql->result_array();
	}

	public function getRequestHistory($value = ''){
		$this->db->select('b.transaksi_judul,b.transaksi_status,c.peminta_jasa_nama,d.user_nama as pic_nama,a.sample_log_status,a.sample_log_keterangan,a.sample_log_who,a.sample_log_when');
		$this->db->from('sample.sample_log a');
		$this->db->join('sample.sample_transaksi b', 'b.id_transaksi_non_rutin = a.sample_log_id_non_rutin', 'left');
		$this->db->join('sample.sample_peminta_jasa c', 'c.peminta_jasa_id = b.transaksi_id_peminta_jasa', 'left');
		$this->db->join('global.global_api_user d', 'd.user_nik_sap = b.transaksi_pic_pengirim_id', 'left');

		if (isset($value['transaksi_non_rutin_id'])) $this->db->where('id_transaksi_non_rutin', $value['transaksi_non_rutin_id']);
		if (isset($value['transaksi_id'])) $this->db->where('transaksi_id', $value['transaksi_id']);
		if (isset($value['transaksi_detail_id'])) $this->db->where('transaksi_detail_id', $value['transaksi_detail_id']);
		// if (isset($value['transaksi_status'])) $this->db->where('transaksi_detail_status', $value['transaksi_status']);

		$this->db->order_by('sample_log_status', 'desc');
		$this->db->order_by('sample_log_when', 'desc');

		$sql = $this->db->get();

		return $sql->result_array();
	}

	/* GET */

	/* INSERT */
	public function insertRequest($data){
		$this->db->insert('sample.sample_transaksi', $data);

		return $this->db->affected_rows();
	}

	public function insertKeterangan($data){
		$this->db->insert('sample.sample_transaksi_keterangan', $data);

		return $this->db->affected_rows();
	}

	public function insertReject($id, $data){
		$this->db->where('id_transaksi_non_rutin', $id);
		$this->db->update('sample.sample_transaksi', $data);
		return $this->db->affected_rows();
	}

	public function insertRejectDetail($id, $status, $data){
		$this->db->where('id_non_rutin', $id);
		$this->db->where('transaksi_detail_status', $status);
		$this->db->update('sample.sample_transaksi_detail', $data);
		return $this->db->affected_rows();
	}
	/* INSERT */

	/* UPDATE */
	public function updateRequest($data, $id){
		$this->db->set($data);
		$this->db->where('transaksi_id', $id);
		$this->db->update('sample.sample_transaksi');

		return $this->db->affected_rows();
	}

	public function updateRequestNon($data, $id){
		$this->db->set($data);
		$this->db->where('id_transaksi_non_rutin', $id);
		$this->db->update('sample.sample_transaksi');

		return $this->db->affected_rows();
	}
	/* UPDATE */

	/* DELETE */
	public function deleteRequest($id){
		$this->db->where('id_transaksi_non_rutin', $id);
		$this->db->delete('sample.sample_transaksi');

		return $this->db->affected_rows();
	}
	/* DELETE */

	/* INSERT DETAIL */
	public function insertRequestDetail($data){
		$this->db->insert('sample.sample_transaksi_detail', $data);

		return $this->db->affected_rows();
	}
	/* INSERT DETAIL */

	/* UPDATE DETAIL */
	public function updateRequestDetail($data, $id){
		$this->db->set($data);
		$this->db->where('transaksi_detail_id', $id);
		$this->db->update('sample.sample_transaksi_detail');

		return $this->db->affected_rows();
	}
	/* UPDATE DETAIL */

	/* DELETE DETAIL */
	public function deleteRequestDetail($id){
		$this->db->where('id_non_rutin', $id);
		$this->db->delete('sample.sample_transaksi_detail');

		return $this->db->affected_rows();
	}

	public function deleteSampleDetail($id){
		$this->db->where('transaksi_detail_id', $id);
		$this->db->delete('sample.sample_transaksi_detail');

		return $this->db->affected_rows();
	}
	/* DELETE DETAIL */

	// INSERT NON RUTIN
	public function insertNonRutin($data = null){
		$this->db->insert('sample.sample_transaksi_non_rutin', $data);
		return $this->db->affected_rows();
	}
	// INSERT NON RUTIN

	// UPDATE NON RUTIN
	public function updateNonRutin($data = null, $id){
		$this->db->where('transaksi_non_rutin_id', $id);
		$this->db->update('sample.sample_transaksi_non_rutin', $data);
		return $this->db->affected_rows();
	}

	// UPDATE NON RUTIN

	// INSERT ATTACH
	public function insertAttach($data = ''){
		$this->db->insert('sample.sample_transaksi_attach', $data);
		return $this->db->affected_rows();
	}
	// INSERT ATTACH

	// UPDATE ATTACH
	public function updateAttach($id, $data = ''){
		$this->db->where('transaksi_attach_id', $id);
		$this->db->update('sample.sample_transaksi_attach', $data);
		return  $this->db->affected_rows();
	}
	// UPDATE ATTACH

	// EASYUI CRUD
	public function getEasyuiSample($data = null){
		$this->db->select('*');
		$this->db->from('sample.sample_transaksi_detail a');
		$this->db->join('sample.sample_jenis b', 'a.jenis_id = b.jenis_id', 'left');
		$this->db->join('sample.sample_identitas c', 'a.identitas_id = c.identitas_id', 'left');
		if (isset($data['transaksi_id'])) $this->db->where('transaksi_id', $data['transaksi_id']);
		if (isset($data['transaksi_detail_id'])) $this->db->where('transaksi_detail_id', $data['transaksi_detail_id']);
		if (isset($data['transaksi_non_rutin_id'])) $this->db->where('id_non_rutin', $data['transaksi_non_rutin_id']);


		$sql = $this->db->get();

		return (isset($data['transaksi_detail_id'])) ? $sql->row_array() : $sql->result_array();
	}

	public function deleteEasyuiSample($id){
		$this->db->where('transaksi_detail_id', $id);
		$this->db->delete('sample.sample_transaksi_detail');
		return $this->db->affected_rows();
	}

	// EASYUI CRUD

	// EASYUI ATTACH
	public function getEasyuiAttach($data = ''){
		$this->db->select('*');
		$this->db->from('sample.sample_transaksi_attach a');
		// $this->db->join('sample.sample_transaksi b', 'a.transaksi_attach_id_transaksi = b.transaksi_id', 'left');
		if (isset($data['transaksi_id'])) $this->db->where('transaksi_attach_id_transaksi', $data['transaksi_id']);
		if (isset($data['transaksi_attach_id'])) $this->db->where('transaksi_attach_id', $data['transaksi_attach_id']);
		// if (isset($data['transaksi_non_rutin_id'])) $this->db->where('id_transaksi_non_rutin', $data['transaksi_non_rutin_id']);

		$sql = $this->db->get();

		return (isset($data['transaksi_attach_id'])) ? $sql->row_array() : $sql->result_array();
	}
	// EASYUI ATTACH

}
