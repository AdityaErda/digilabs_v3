<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_daftar extends CI_Model{
	public function getDaftar($data = null){
		$this->db->select('a.*,b.*,c.user_unit_id');
		$this->db->from('global.global_user a');
		$this->db->join('global.global_role b', 'b.role_id=a.role_id', 'left');
		$this->db->join('global.global_api_user c', 'c.user_nik=a.user_username', 'left');

		// $this->db->where("UPPER(role_nama) = '".strtoupper('Eksekutor')."'");
		if ($data['user_id'] != '1' and $data['role_id'] != '5c52e905e81f137cc9357a0555a6948f81e84254') {
			$this->db->where('a.user_id', $data['user_id']);
		} else {
			$this->db->where('c.user_unit_id', 'E44000');
		}
		$this->db->order_by('user_nama_lengkap', 'asc');
		$sql = $this->db->get();

		return $sql->result_array();
	}

	// start data document
	public function getDataPengajuanDocument($data){
		$this->db->select('transaksi_id,transaksi_file_word,transaksi_file_pdf,transaksi_file,concat
			(transaksi_file_word,transaksi_file_pdf) as transaksi_filenya')->from('document.document_transaksi')->where('transaksi_id', $data['transaksi_id']);
		$sql = $this->db->get();
		return $sql->result_array();
	}
	// end data document

	// start data document

	// end data document

	// get cv
	public function getCV($data = null){
		$this->db->select('*')->from('document.document_cv a')->join('global.global_user b', 'b.user_id=a.user_id', 'left');
		if (isset($data['cv_id'])) $this->db->where('cv_id', $data['cv_id']);
		if (isset($data['user_id'])) $this->db->where('a.user_id', $data['user_id']);
		$sql = $this->db->get();
		return $sql->row_array();
	}
	// get cv

	// masa jabatan start
	public function getMasaJabatan($data = null){
		$this->db->select("((jabatan_selesai - jabatan_mulai)/365) as masa_kerja")->from('document.document_cv a')->join('document.document_jabatan b', 'b.cv_id=a.cv_id', 'left')->where('b.cv_id', $data['cv_id']);

		return $this->db->get()->row_array();
	}
	// masa jabatan end

	// isnert cv
	public function insertCV($data = null){
		$this->db->insert('document.document_cv', $data);
	}

	public function updateCV($data = null, $id){
		$this->db->set($data)->where('cv_id', $id)->update('document.document_cv');
	}
	// insert cv

	// start simpan pengajuan
	public function insertPengajuan($data = null){
		$this->db->insert('document.document_transaksi', $data);
	}
	// end simpan pengajuan

	// start simpan pengajuan detail
	public function insertPengajuanDetail($data = null){
		$this->db->insert('document.document_transaksi_detail', $data);
	}
	// end simpan pengajuan detail

	// start update pengajuan
	public function updatePengajuan($data = null, $id){
		$this->db->set($data)->where('transaksi_id', $id)->update('document.document_transaksi');
	}
	// end update pengajuan

	// start update pengajuan
	public function updatePengajuanDetail($data = null, $id){
		$this->db->set($data)->where('transaksi_detail_id', $id)->update('document.document_transaksi_detail');
	}
	// end update pengajuan

	// start hapus pengajuan
	public function hapusPengajuan($id = null){
		$this->db->where('transaksi_id', $id)->delete('document.document_transaksi');
	}
	//  end hapus pengajuan

	// start hapus pengajuan
	public function hapusPengajuanDetail($id = null){
		$this->db->where('transaksi_id', $id)->delete('document.document_transaksi_detail');
	}
	//  end hapus pengajuan

	// start data pengajuan
	public function getDataPengajuan($data = null){
		$this->db->select("a.transaksi_id, a.transaksi_judul_document,a.transaksi_keterangan_document,concat_ws('<br/><br/>',a.transaksi_file_word,a.transaksi_file_pdf) as transaksi_filenya ,a.transaksi_file_word,a.transaksi_file_pdf,jenis_nama,a.jenis_id,a.seksi_id,seksi_nama,to_char(transaksi_tgl_pengesahan,'DD-MM-YYYY') as transaksi_tgl_pengesahan,transaksi_revisi,transaksi_terbitan,transaksi_keterangan_document,transaksi_nomor_document,transaksi_status,a.transaksi_file,to_char(transaksi_tgl_pengajuan,'DD-MM-YYYY') as transaksi_tgl_pengajuan,transaksi_nomor_document,
			case
			when transaksi_status = '0' then 'Pengajuan'
			when transaksi_status = '1' then 'Approved'
			when transaksi_status = '2' then 'Ditolak'
			end as transaksi_statusnya,transaksi_tipe,
			case
			when transaksi_tipe = '0' then 'Baru'
			when transaksi_tipe = '1' then 'Perubahan'
			end as transaksi_tipenya");
		$this->db->from('document.document_transaksi a');
		$this->db->join('document.document_jenis b', 'b.jenis_id = a.jenis_id', 'left');
		$this->db->join('global.global_seksi c', 'a.seksi_id = c.seksi_id', 'left');


		if (isset($data['transaksi_id'])) $this->db->where('transaksi_id', $data['transaksi_id']);
		if (isset($data['transaksi_status'])) $this->db->where('transaksi_status', $data['transaksi_status']);

		$this->db->order_by('transaksi_nomor_document', 'asc');
		$this->db->order_by('transaksi_tgl_pengesahan', 'desc');
		$this->db->order_by('transaksi_tgl_pengajuan', 'desc');
		$this->db->order_by('jenis_nama', 'asc');
		$this->db->order_by('transaksi_judul_document', 'asc');

		$sql = $this->db->get();
		return (isset($data['transaksi_id'])) ? $sql->row_array() : $sql->result_array();
	}
	// end data pengajuan

	// start data pengajuan detail
	public function getDataPengajuanDetail($data = null){
		$this->db->select("d.transaksi_id,a.transaksi_detail_id, d.transaksi_judul_document,d.transaksi_keterangan_document,concat_ws('<br/><br/>',a.transaksi_detail_file_word,a.transaksi_detail_file_pdf) as transaksi_filenya ,d.transaksi_file_word,d.transaksi_file_pdf,a.transaksi_detail_file_word,a.transaksi_detail_file_pdf,jenis_nama,d.jenis_id,d.seksi_id,seksi_nama,to_char(transaksi_tgl_pengesahan,'DD-MM-YYYY') as transaksi_tgl_pengesahan,transaksi_revisi,transaksi_terbitan,transaksi_keterangan_document,transaksi_nomor_document,transaksi_status,d.transaksi_file,a.transaksi_detail_revisi,a.transaksi_detail_terbitan,transaksi_detail_note_document,
			to_char(transaksi_detail_tgl_document_pengajuan,'DD-MM-YYYY') as transaksi_detail_tgl_document_pengajuan,
			to_char(transaksi_detail_tgl_document_pengesahan,'DD-MM-YYYY') as transaksi_detail_tgl_document_pengesahan,transaksi_detail_nomor_document,transaksi_detail_status_pengajuan,transaksi_detail_keterangan_document,
			transaksi_detail_tipe,
			case
				when transaksi_detail_status_pengajuan = '0' then 'Pengajuan'
				when transaksi_detail_status_pengajuan = '1' then 'Approved'
				when transaksi_detail_status_pengajuan = '2' then 'Ditolak'
				end as transaksi_statusnya_detail,
			case
				when transaksi_status = '0' then 'Pengajuan'
				when transaksi_status = '1' then 'Approved'
				when transaksi_status = '2' then 'Ditolak'
				end as transaksi_statusnya,
			case
				when transaksi_detail_tipe = '0' then 'Document Baru'
				when transaksi_detail_tipe = '1' then 'Document Perubahan'
				end as transaksi_perubahannya,");
		$this->db->from('document.document_transaksi_detail a');
		$this->db->join('document.document_transaksi d', 'd.transaksi_id=a.transaksi_id', 'left');
		$this->db->join('document.document_jenis b', 'b.jenis_id = d.jenis_id', 'left');
		$this->db->join('global.global_seksi c', 'd.seksi_id = c.seksi_id', 'left');


		if (isset($data['transaksi_id'])) $this->db->where('d.transaksi_id', $data['transaksi_id']);
		if (isset($data['transaksi_detail_id'])) $this->db->where('transaksi_detail_id', $data['transaksi_detail_id']);
		if (isset($data['transaksi_status'])) $this->db->where('transaksi_status', $data['transaksi_status']);
		$this->db->order_by('transaksi_detail_status_pengajuan', 'asc');
		$this->db->order_by('transaksi_detail_tipe', 'asc');
		$this->db->order_by('transaksi_detail_tgl_document_pengajuan', 'desc');
		$this->db->order_by('transaksi_detail_tgl_document_pengesahan', 'desc');
		$this->db->order_by('transaksi_judul_document', 'asc');


		$sql = $this->db->get();
		return (isset($data['transaksi_detail_id'])) ? $sql->row_array() : $sql->result_array();
	}
	// end data pengajuan detail

	// start data pengajuan detail
	public function getDataPengajuanDetailDocument($data = null){
		$this->db->select("a.transaksi_id, a.transaksi_judul_document,a.transaksi_keterangan_document,concat_ws('<br/><br/>',d.transaksi_detail_file_word,d.transaksi_detail_file_pdf) as transaksi_filenya ,a.transaksi_file_word,a.transaksi_file_pdf,d.transaksi_detail_file_word,d.transaksi_detail_file_pdf,jenis_nama,a.jenis_id,a.seksi_id,seksi_nama,to_char(transaksi_tgl_pengesahan,'DD-MM-YYYY') as transaksi_tgl_pengesahan,transaksi_revisi,transaksi_terbitan,transaksi_keterangan_document,transaksi_nomor_document,transaksi_status,a.transaksi_file,d.transaksi_detail_id,d.transaksi_detail_revisi,d.transaksi_detail_terbitan,
					case
					when transaksi_status = '0' then 'Pengajuan'
					when transaksi_status = '1' then 'Aprove'
					when transaksi_status = '2' then 'Ditolak'
					end as transaksi_statusnya,
					case
					when transaksi_detail_tipe = '0' then 'Document Baru'
					when transaksi_detail_tipe = '1' then 'Document Perubahan'
					end as transaksi_perubahannya,
					case
					when transaksi_detail_status_pengajuan = '0' then 'Pengajuan'
					when transaksi_detail_status_pengajuan = '1' then 'Aprove'
					when transaksi_detail_status_pengajuan = '2' then 'Ditolak'
					end as transaksi_statusnya_detail,");
		$this->db->from('document.document_transaksi a');
		$this->db->join('document.document_jenis b', 'b.jenis_id = a.jenis_id', 'left');
		$this->db->join('global.global_seksi c', 'a.seksi_id = c.seksi_id', 'left');
		$this->db->join('document.document_transaksi_detail d', 'd.transaksi_id=a.transaksi_id', 'left');


		if (isset($data['transaksi_id'])) $this->db->where('d.transaksi_id', $data['transaksi_id']);
		if (isset($data['transaksi_detail_id'])) $this->db->where('transaksi_detail_id', $data['transaksi_detail_id']);
		if (isset($data['transaksi_status'])) $this->db->where('transaksi_status', $data['transaksi_status']);
		$this->db->order_by('transaksi_detail_tgl_document_pengesahan', 'desc');

		$sql = $this->db->get();

		return  $sql->result_array();
	}
	// end data pengajuan detail

	// start data pengajuan
	// EASY UI

	// get data
	public function getEasyuiRiwayatPendidikanFormal($data = null){
		$this->db->select('*')->from('document.document_pendidikan_formal');
		if (isset($data['cv_id'])) $this->db->where('cv_id', $data['cv_id']);
		$this->db->order_by('pendidikan_formal_tahun', 'desc');
		$sql = $this->db->get();
		return $sql->result_array();
	}

	public function getEasyuiRiwayatPendidikanNonFormal($data = null){
		$this->db->select('*')->from('document.document_pendidikan_non_formal');
		if (isset($data['cv_id'])) $this->db->where('cv_id', $data['cv_id']);
		$this->db->order_by('pendidikan_non_formal_tahun', 'desc');
		$sql = $this->db->get();
		return $sql->result_array();		// echo $this->db->last_query();
	}
	public function getEasyuiRiwayatJabatan($data = null){
		$this->db->select('*')->from('document.document_jabatan');
		if (isset($data['cv_id'])) $this->db->where('cv_id', $data['cv_id']);
		$this->db->order_by('jabatan_mulai', 'desc');
		$this->db->order_by('jabatan_selesai', 'desc');
		$sql = $this->db->get();
		return $sql->result_array();
	}
	public function getEasyuiKompetensi($data = null){
		$this->db->select('*')->from('document.document_kompetensi');
		if (isset($data['cv_id'])) $this->db->where('cv_id', $data['cv_id']);
		$this->db->order_by('kompetensi_tahun', 'desc');
		$sql = $this->db->get();
		return $sql->result_array();
	}
	public function getEasyuiPenilaianKerja($data = null){
		$this->db->select('*')->from('document.document_penilaian_kerja');
		if (isset($data['cv_id'])) $this->db->where('cv_id', $data['cv_id']);
		$sql = $this->db->get();
		return $sql->result_array();
	}
	public function getEasyuiPenugasanInternal($data = null){
		$this->db->select('*')->from('document.document_penugasan_internal');
		if (isset($data['cv_id'])) $this->db->where('cv_id', $data['cv_id']);
		$this->db->order_by('penugasan_internal_tanggal_mulai', 'desc');
		$this->db->order_by('penugasan_internal_tanggal_selesai', 'desc');
		$sql = $this->db->get();
		return $sql->result_array();
	}
	public function getEasyuiRiwayatPengalamanKerja($data = null){
		$this->db->select('*')->from('document.document_pengalaman_kerja');
		if (isset($data['cv_id'])) $this->db->where('cv_id', $data['cv_id']);
		$this->db->order_by('pengalaman_tanggal_mulai', 'desc');
		$this->db->order_by('pengalaman_tanggal_selesai', 'desc');
		$sql = $this->db->get();
		return $sql->result_array();
	}
	public function getEasyuiDataKeluarga($data = null){
		$this->db->select('*')->from('document.document_data_keluarga');
		if (isset($data['cv_id'])) $this->db->where('cv_id', $data['cv_id']);
		$sql = $this->db->get();
		return $sql->result_array();
	}
	// get data

	// insert data
	public function insertEasyuiRiwayatPendidikanFormal($data = null){
		$this->db->insert('document.document_pendidikan_formal', $data);
	}

	public function insertEasyuiRiwayatPendidikanNonFormal($data = null){
		$this->db->insert('document.document_pendidikan_non_formal', $data);
	}
	public function insertEasyuiRiwayatJabatan($data = null){
		$this->db->insert('document.document_jabatan', $data);
	}
	public function insertEasyuiKompetensi($data = null){
		$this->db->insert('document.document_kompetensi', $data);
	}
	public function insertEasyuiPenilaianKerja($data = null){
		$this->db->insert('document.document_penilaian_kerja', $data);
	}
	public function insertEasyuiPenugasanInternal($data = null){
		$this->db->insert('document.document_penugasan_internal', $data);
	}
	public function insertEasyuiRiwayatPengalamanKerja($data = null){
		$this->db->insert('document.document_pengalaman_kerja', $data);
	}
	public function insertEasyuiDataKeluarga($data = null){
		$this->db->insert('document.document_data_keluarga', $data);
	}
	// insert data

	// update
	public function editEasyuiRiwayatPendidikanFormal($data = null, $id){
		$this->db->set($data)->where('pendidikan_formal_id', $id)->update('document.document_pendidikan_formal');
	}

	public function editEasyuiRiwayatPendidikanNonFormal($data = null, $id){
		$this->db->set($data)->where('pendidikan_non_formal_id', $id)->update('document.document_pendidikan_non_formal');
	}
	public function editEasyuiRiwayatJabatan($data = null, $id){
		$this->db->set($data)->where('jabatan_id', $id)->update('document.document_jabatan');
	}
	public function editEasyuiKompetensi($data = null, $id){
		$this->db->set($data)->where('kompetensi_id', $id)->update('document.document_kompetensi');
	}
	public function editEasyuiPenilaianKerja($data = null, $id){
		$this->db->set($data)->where('penilaian_kerja_id', $id)->update('document.document_penilaian_kerja');
	}
	public function editEasyuiPenugasanInternal($data = null, $id){
		$this->db->set($data)->where('penugasan_internal_id', $id)->update('document.document_penugasan_internal');
	}
	public function editEasyuiRiwayatPengalamanKerja($data = null, $id){
		$this->db->set($data)->where('pengalaman_id', $id)->update('document.document_pengalaman_kerja');
	}
	public function editEasyuiDataKeluarga($data = null, $id){
		$this->db->set($data)->where('data_keluarga_id', $id)->update('document.document_data_keluarga');
	}
	// update

	// hapus
	public function deleteEasyuiRiwayatPendidikanFormal($data){
		$this->db->where('pendidikan_formal_id', $data)->delete('document.document_pendidikan_formal');
	}

	public function deleteEasyuiRiwayatPendidikanNonFormal($data = null){
		$this->db->where('pendidikan_non_formal_id', $data)->delete('document.document_pendidikan_non_formal');
	}
	public function deleteEasyuiRiwayatJabatan($data = null){
		$this->db->where('jabatan_id', $data)->delete('document.document_jabatan');
	}
	public function deleteEasyuiKompetensi($data = null){
		$this->db->where('kompetensi_id', $data)->delete('document.document_kompetensi');
	}
	public function deleteEasyuiPenilaianKerja($data = null){
		$this->db->where('penilaian_kerja_id', $data)->delete('document.document_penilaian_kerja');
	}
	public function deleteEasyuiPenugasanInternal($data = null){
		$this->db->where('penugasan_internal_id', $data)->delete('document.document_penugasan_internal');
	}
	public function deleteEasyuiRiwayatPengalamanKerja($data = null){
		$this->db->where('pengalaman_id', $data)->delete('document.document_pengalaman_kerja');
	}
	public function deleteEasyuiDataKeluarga($data = null){
		$this->db->where('data_keluarga_id', $data)->delete('document.document_data_keluarga');
	}


	// hapus

	// EASY UI

	public function historyDownload($data = null){
		$this->db->insert('document.document_history_download', $data);
	}

	public function getHistoryDownload($data = null){
		$this->db->select("when_download,who_download,history_file_download")->from('document.document_history_download a')->join('document.document_transaksi b ', 'b.transaksi_id=a.transaksi_id', 'left')->join('document.document_transaksi_detail c', 'c.transaksi_detail_id=a.transaksi_detail_id', 'left')->where('a.transaksi_id', $data['transaksi_id']);
		$this->db->order_by('when_download', 'desc');
		$sql = $this->db->get();
		return $sql->result_array();
	}

	public function getHistoryDownloadDetail($data = null){
		$this->db->select(" when_download,who_download,history_file_download")->from('document.document_history_download a')->join('document.document_transaksi_detail b ', 'b.transaksi_detail_id=a.transaksi_detail_id', 'left')->where('a.transaksi_detail_id', $data['transaksi_detail_id']);
		$this->db->order_by('when_download', 'desc');
		$sql = $this->db->get();
		return $sql->result_array();
	}

	// start data cetak cv
	public function getCetakCV($data = null){
		$this->db->select('*')->from('global.global_user a')->join('document.document_cv b', 'b.user_id=a.user_id', 'left')->join('document.document_pendidikan_formal c', 'c.cv_id=b.cv_id', 'left')->join('document.document_pendidikan_non_formal d', 'd.cv_id=b.cv_id', 'left')->join('document.document_jabatan e', 'e.cv_id=b.cv_id', 'left')->join('document.document_kompetensi f', 'f.cv_id=b.cv_id', 'left')->join('document.document_penugasan_internal g', 'g.cv_id=b.cv_id', 'left')->join('document.document_pengalaman_kerja h', 'h.cv_id=b.cv_id', 'left')->join('document.document_data_keluarga i ', 'i.cv_id=b.cv_id', 'left');
		if (isset($data['cv_id'])) $this->db->where('b.cv_id', $data['cv_id']);
		if (isset($data['user_id'])) $this->db->where('a.user_id', $data['user_id']);
		$sql = $this->db->get();
		return $sql->result_array();
	}
	// end data cetak cv

	public function getSeksi($data = null){
		$this->db->select('*');
		$this->db->from('global.global_seksi a');
		$this->db->where('is_disposisi', 'y');
		if (isset($data['seksi_nama'])) $this->db->where("upper(seksi_nama) LIKE '%" . strtoupper($data['seksi_nama']) . "%'");
		if (isset($data['seksi_id'])) $this->db->where('seksi_id', $data['seksi_id']);

		$sql = $this->db->get();

		return (isset($data['jenis_id'])) ? $sql->row_array() : $sql->result_array();
	}

	public function getNomorKembar(){
		$this->db->select('transaksi_detail_nomor_document');
		$this->db->from('document.document_transaksi_detail');
		$sql = $this->db->get();
		return $sql->result_array();
	}
}
