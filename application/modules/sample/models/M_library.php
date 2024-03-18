<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_library extends CI_Model{
	/* GET */
	public function getLibrary($data = null, $where = null){
		$this->db->select("a.transaksi_pic_pengirim,q.user_nama as pic_nama,a.transaksi_id, a.transaksi_tipe, a.transaksi_status, a.transaksi_nomor,a.transaksi_sifat,a.transaksi_kecepatan_tanggap,a.transaksi_judul, b.*, c.jenis_nama, d.peminta_jasa_nama, e.sample_pekerjaan_nama, a.transaksi_tgl, f.identitas_nama, to_char(transaksi_detail_tgl_pengajuan, 'DD-MM-YYYY HH24:MI:SS') AS transaksi_detail_tgl_pengajuan_baru, to_char(transaksi_detail_tgl_memo, 'DD-MM-YYYY') AS transaksi_detail_tgl_memo_baru, to_char(transaksi_detail_tgl_estimasi, 'DD-MM-YYYY HH24:MI:SS') AS transaksi_detail_tgl_estimasi_baru,a.transaksi_id_template_keterangan,g.*,h.*,i.logsheet_id,i.id_template_logsheet,i.id_dokumen_tipe,i.id_dokumen_template,i.dokumen_template_file,j.document_type_id,j.document_type_name,k.document_template_id,k.document_template_name,l.klasifikasi_id,l.klasifikasi_nama, m.user_detail_id as drafter_id, m.user_detail_userName as drafter_nik, m.user_detail_name as drafter_nama, m.user_detail_posCode as drafter_poscode, n.user_detail_id as reviewer_id, n.user_detail_userName as reviewer_nik, n.user_detail_name as reviewer_nama, n.user_detail_posCode as reviewer_poscode, o.user_detail_id as approver_id, o.user_detail_userName as approver_nik, o.user_detail_name as approver_nama, o.user_detail_posCode as approver_poscode, p.user_detail_id as tujuan_id, p.user_detail_userName as tujuan_nik, p.user_detail_name as tujuan_nama, p.user_detail_posCode as tujuan_poscode,id_transaksi_rutin,seksi_nama,b.transaksi_detail_no_surat,a.transaksi_nomor,CAST(transaksi_detail_status as INT),a.when_create");
		$this->db->distinct();
		$this->db->from('sample.sample_transaksi a');
		// $this->db->join('sample.sample_transaksi_detail b', 'a.transaksi_id = b.transaksi_id AND a.id_transaksi_detail = b.transaksi_detail_id', 'left');
		$this->db->join('sample.sample_transaksi_detail b', 'a.transaksi_id = b.transaksi_id', 'left');
		$this->db->join('sample.sample_jenis c', 'c.jenis_id = b.jenis_id', 'left');
		$this->db->join('sample.sample_peminta_jasa d', 'd.peminta_jasa_id = b.peminta_jasa_id', 'left');
		$this->db->join('sample.sample_pekerjaan e', 'e.sample_pekerjaan_id = b.jenis_pekerjaan_id', 'left');
		$this->db->join('sample.sample_identitas f', 'f.identitas_id = b.identitas_id', 'left');
		$this->db->join('sample.sample_transaksi_keterangan g', 'g.transaksi_keterangan_id = a.transaksi_id_template_keterangan', 'left');
		$this->db->join('sample.sample_template_keterangan h', 'h.template_keterangan_id = g.transaksi_id_template', 'left');
		$this->db->join('sample.sample_logsheet i', 'i.id_transaksi = a.transaksi_id AND i.id_transaksi_detail = b.transaksi_detail_id', 'left');
		$this->db->join('global.global_document_type j', 'j.document_type_id = i.id_dokumen_tipe', 'left');
		$this->db->join('global.global_document_template k', 'k.document_template_id = i.id_dokumen_template', 'left');
		$this->db->join('sample.sample_klasifikasi l', 'l.klasifikasi_id = a.transaksi_klasifikasi_id', 'left');
		$this->db->join('global.global_user_detail m', 'm.user_detail_userName = a.transaksi_drafter', 'left');
		$this->db->join('global.global_user_detail n', 'n.user_detail_userName = a.transaksi_reviewer', 'left');
		$this->db->join('global.global_user_detail o', 'o.user_detail_userName = a.transaksi_approver', 'left');
		$this->db->join('global.global_user_detail p', 'p.user_detail_userName = a.transaksi_tujuan', 'left');
		$this->db->join('global.global_api_user q', 'q.user_nik_sap = a.transaksi_pic_pengirim', 'left');
		$this->db->join('global.global_seksi r', 'r.seksi_id = a.who_seksi_create', 'left');


		if (!empty($where) && !isset($data['transaksi_status'])) {
			$this->db->where(($where));
			// $this->db->or_where('transaksi_status', '0');
		}

		if (isset($data['transaksi_tipe'])) $this->db->where('transaksi_tipe', $data['transaksi_tipe']);

		if (isset($data['transaksi_status'])) $this->db->where("CAST(b.transaksi_detail_status as INT) >= '" . ($data['transaksi_status']) . "' ");
		if (isset($data['transaksi_id'])) $this->db->where('b.transaksi_id', $data['transaksi_id']);
		if (isset($data['transaksi_detail_id'])) $this->db->where('b.transaksi_detail_id', $data['transaksi_detail_id']);
		if (isset($data['jenis_id'])) $this->db->where('b.jenis_id', $data['jenis_id']);

		if (isset($data['tanggal_cari_awal'])) $this->db->where('DATE(a.transaksi_tgl) >=', $data['tanggal_cari_awal']);
		if (isset($data['tanggal_cari_akhir'])) $this->db->where('DATE(a.transaksi_tgl) <=', $data['tanggal_cari_akhir']);
		if (isset($data['user_unit_id'])) $this->db->where('q.user_unit_id', $data['user_unit_id']);

		$this->db->where("is_proses is NULL");
		$this->db->order_by('transaksi_tipe', 'asc');
		$this->db->order_by('a.transaksi_tgl', 'asc');
		$this->db->order_by('a.transaksi_nomor', 'asc');
		$this->db->order_by('CAST(transaksi_detail_status as INT)', 'ASC');
		$this->db->order_by('a.when_create', 'desc');
		$sql = $this->db->get();

		return (isset($data['transaksi_id']) && isset($data['transaksi_detail_id'])) ? $sql->row_array() : $sql->result_array();
		// return (isset($data['transaksi_id'])) ? $sql->row_array() : $sql->result_array();
		// return $sql->result_array();
	}


	public function getLibraryDetail($data = null){
		$this->db->select("a.*,b.jenis_nama,c.identitas_nama, to_char(transaksi_detail_tgl_pengajuan, 'DD-MM-YYYY HH24:MI:SS') AS transaksi_detail_tgl_pengajuan_baru, to_char(transaksi_detail_tgl_memo, 'DD-MM-YYYY HH24:MI:SS') AS transaksi_detail_tgl_memo_baru, to_char(transaksi_detail_tgl_estimasi, 'DD-MM-YYYY HH24:MI:SS') AS transaksi_detail_tgl_estimasi_baru, to_char(a.when_create, 'DD-MM-YYYY HH24:MI:SS') AS when_create_baru,transaksi_detail_note");
		$this->db->from('sample.sample_transaksi_detail a');
		$this->db->join('sample.sample_jenis b', 'b.jenis_id = a.jenis_id', 'left');
		$this->db->join('sample.sample_identitas c', 'c.identitas_id = a.identitas_id', 'left');

		if (isset($data['transaksi_non_rutin_id'])) $this->db->where('id_non_rutin', $data['transaksi_non_rutin_id']);
		if (isset($data['jenis_id'])) $this->db->where('a.jenis_id', $data['jenis_id']);
		if (isset($data['transaksi_id'])) $this->db->where('transaksi_id', $data['transaksi_id']);

		if (isset($data['tgl_awal'])) $this->db->where('DATE(transaksi_detail_tgl_pengajuan) >= ', $data['tgl_awal']);
		if (isset($data['tgl_akhir'])) $this->db->where('DATE(transaksi_detail_tgl_pengajuan) <= ', $data['tgl_akhir']);

		$this->db->order_by('when_create_baru', 'asc');
		$this->db->order_by('cast(transaksi_detail_status as int)', 'asc');
		$sql = $this->db->get();

		return $sql->result_array();
	}

	public function getHistoryLogSheet($data = null){
		$this->db->select('a.history_logsheet_when, a.sample_history_detail, a.sample_history_isi, a.sample_history_hasil, a.history_logsheet_who');
		$this->db->from('global.global_history_logsheet a');
		$this->db->join('sample.sample_logsheet b', 'b.id_transaksi = a.sample_transaksi_id', 'left');
		// $this->db->join('sample.sample_logsheet_detail c', 'c.logsheet_id = a.sample_logsheet_id', 'left');
		// $this->db->join('sample.sample_perhitungan_sample d', 'd.rumus_id = c.id_rumus', 'left');

		if (isset($data['sample_transaksi_id'])) $this->db->where('sample_transaksi_id', $data['sample_transaksi_id']);
		if (isset($data['rumus_nama'])) $this->db->where("upper(rumus_nama) LIKE '%" . strtoupper($data['rumus_nama']) . "%'");

		$this->db->group_by('a.history_logsheet_when');
		$this->db->group_by('a.sample_history_detail');
		$this->db->group_by('a.sample_history_isi');
		$this->db->group_by('a.sample_history_hasil');
		$this->db->group_by('a.history_logsheet_who');
		// $this->db->group_by('d.rumus_nama');

		$this->db->order_by('history_logsheet_when', 'desc');
		$sql = $this->db->get();

		return $sql->result_array();
	}

	public function getLibraryDisposisi($data = null){
		$this->db->select("b.seksi_nama");
		$this->db->from('sample.sample_seksi_disposisi a');
		$this->db->join('global.global_seksi b ', 'a.id_seksi = b.seksi_id', 'left');
		$this->db->where('a.id_transaksi', $data['transaksi_id']);
		$this->db->order_by('b.seksi_nama', 'asc');
		$sql = $this->db->get();

		return $sql->result_array();
	}

	public function getLibraryEdit($data = null){
		$this->db->select('*');
		$this->db->from('sample.sample_transaksi_detail');
		if (isset($data['transaksi_detail_id'])) $this->db->where('transaksi_detail_id', $data['transaksi_detail_id']);
		$query = $this->db->get();
		return (isset($data['transaksi_detail_id'])) ? $query->row_array() : $query->result_array();
	}

	public function getDOFIdentitas($data = ''){
		if (isset($data['transaksi_id'])) $this->db->where('a.transaksi_id', $data['transaksi_id']);
		if (isset($data['transaksi_detail_id'])) $this->db->where('a.transaksi_detail_id', $data['transaksi_detail_id']);
		if (isset($data['transaksi_detail_group'])) $this->db->where('a.transaksi_detail_group', $data['transaksi_detail_group']);
		if (isset($data['logsheet_id'])) $this->db->where('a.logsheet_id', $data['logsheet_id']);
		if (isset($data['transaksi_rutin_id'])) $this->db->where('a.transaksi_rutin_id', $data['transaksi_rutin_id']);

		$this->db->select('
		a.dof_identitas_id,
		a.tipe_id,
		a.template_id,
		a.klasifikasi_id,
		a.klasifikasi_nama,
		a.kategori_id,
		a.kecepatan_tanggap,
		a.judul,
		a.drafter_id,
		a.reviewer_id,
		a.approver_id,
		a.tujuan_id,
		a.cc_id,
		a.transaksi_id,
		a.transaksi_detail_id,
		a.transaksi_detail_group,
		a.logsheet_id,
		a.id_surat,
		b.document_type_name,
		c.document_template_name,
		d.klasifikasi_nama,
		e.user_detail_name AS drafter_nama,
		e.user_detail_userName AS drafter_nik,
		e.user_detail_posCode AS drafter_poscode,
		f.user_detail_name AS approver_nama,
		f.user_detail_userName AS approver_nik,
		f.user_detail_posCode AS approver_poscode,
		');
		$this->db->from('sample.sample_dof_identitas a');
		$this->db->join('global.global_document_type b', 'b.document_type_id = a.tipe_id', 'left');
		$this->db->join('global.global_document_template c', 'c.document_template_id = a.template_id', 'left');
		$this->db->join('sample.sample_klasifikasi d', 'd.klasifikasi_id = a.klasifikasi_id', 'left');
		$this->db->join('global.global_user_detail e', 'e.user_detail_id = a.drafter_id', 'left');
		$this->db->join('global.global_user_detail f', 'f.user_detail_id = a.approver_id', 'left');



		$sql = $this->db->get();
		return $sql->row_array();
	}
	/* GET */

	// UPDATE
	public function  updateLibraryEdit($id, $data = null){
		$this->db->where('transaksi_detail_id', $id);
		$this->db->update('sample.sample_transaksi_detail', $data);
		return $this->db->affected_rows();
	}
	// UPDATE
}
