<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_lab extends CI_Model
{

	public function getLab($data = null, $where = null)
	{
		$this->db->select("a.transaksi_tgl,a.when_create,a.who_seksi_create,a.transaksi_nomor, a.transaksi_tipe, a.transaksi_status,a.transaksi_reviewer,a.transaksi_approver,a.transaksi_drafter,a.transaksi_tujuan,b.id_user_disposisi, b.peminta_jasa_id,b.transaksi_detail_no_memo,b.transaksi_detail_note, b.transaksi_detail_pic_pengirim,b.transaksi_detail_ext_pengirim, c.peminta_jasa_nama,  to_char(b.transaksi_detail_tgl_pengajuan, 'DD-MM-YYYY') AS transaksi_detail_tgl_pengajuan_baru, to_char(b.transaksi_detail_tgl_memo, 'DD-MM-YYYY') AS transaksi_detail_tgl_memo_baru, to_char(b.transaksi_detail_tgl_estimasi, 'DD-MM-YYYY') AS transaksi_detail_tgl_estimasi_baru, b.transaksi_detail_note as note_awal,a.transaksi_judul,a.transaksi_id_template_keterangan,a.transaksi_drafter,a.transaksi_attach,a.transaksi_sifat,a.transaksi_kecepatan_tanggap,a.id_transaksi_non_rutin,a.transaksi_klasifikasi_id,a.transaksi_id_user,transaksi_pic_ext,transaksi_pic_telepon,b.id_user_disposisi,b.id_seksi_disposisi");
		$this->db->distinct();
		$this->db->from('sample.sample_transaksi a');
		$this->db->join('sample.sample_transaksi_detail b', 'a.transaksi_id = b.transaksi_id AND a.transaksi_status=b.transaksi_detail_status', 'LEFT');
		$this->db->join('sample.sample_peminta_jasa c', 'c.peminta_jasa_id=b.peminta_jasa_id', 'left');
		$this->db->join('sample.sample_transaksi_non_rutin d', 'd.transaksi_non_rutin_id = b.id_non_rutin AND d.transaksi_non_rutin_id = a.id_transaksi_non_rutin', 'left');

		if (!empty($where)) $this->db->where($where);
		if (isset($data['transaksi_id'])) $this->db->where('a.transaksi_id', $data['transaksi_id']);
		if (isset($data['transaksi_non_rutin_id'])) $this->db->where('g.transaksi_non_rutin_id', $data['transaksi_non_rutin_id']);
		if (isset($data['tanggal_cari_awal'])) $this->db->where('DATE(a.transaksi_tgl) >=', $data['tanggal_cari_awal']);
		if (isset($data['tanggal_cari_akhir'])) $this->db->where('DATE(a.transaksi_tgl) <=', $data['tanggal_cari_akhir']);
		// if ($data['transaksi_non_rutin_id'] == '') {
		// if (isset($data['seksi_id'])) $this->db->where("(a.who_seksi_create = '".$data['seksi_id']."' OR b.who_seksi_create = '".$data['seksi_id']."')");
		// }
		if (isset($data['transaksi_status'])) $this->db->where('a.transaksi_status', $data['transaksi_status']);
		if (isset($data['array_transaksi_status_in'])) $this->db->where_in('transaksi_status', $data['array_transaksi_status_in']);
		if (isset($data['array_transaksi_status_not_in'])) $this->db->where_not_in('transaksi_status', $data['array_transaksi_status_not_in']);
		if (isset($data['track_sample'])) $this->db->where("upper(a.transaksi_nomor) = '" . strtoupper($data['track_sample']) . "' OR upper(jenis_nama) LIKE '%" . strtoupper($data['track_sample']) . "%'");

		$this->db->where("transaksi_tipe!='R'");

		$this->db->where("id_transaksi_non_rutin is not null");

		// $this->db->where("transaksi_status = '0'");
		// $this->db->where("transaksi_status = '1'");
		// $this->db->where("transaksi_status = '2'");
		// $this->db->where("transaksi_status = '3'");
		// $this->db->where("transaksi_status = '4'");
		// $this->db->where("transaksi_status = '5'");

		$this->db->order_by('a.transaksi_nomor', 'asc');
		$this->db->order_by('a.transaksi_tgl', 'desc');
		$this->db->order_by('a.when_create', 'desc');
		$this->db->order_by('a.transaksi_status', 'asc');
		$sql = $this->db->get();

		return (isset($data['transaksi_non_rutin_id'])) ? $sql->row_array() : $sql->result_array();
	}

	public function getLabDetail($value = '')
	{
		$this->db->select('*');
		$this->db->from('sample.sample_transaksi_detail a');
		$this->db->join('sample.sample_jenis b', 'b.jenis_id = a.jenis_id', 'left');
		$this->db->join('sample.sample_pekerjaan c', 'c.sample_pekerjaan_id = a.jenis_pekerjaan_id', 'left');
		$this->db->join('sample.sample_seksi_disposisi d', 'd.id_transaksi_detail = a.transaksi_detail_id', 'left');
		$this->db->join('global.global_seksi e', 'e.seksi_id = d.id_seksi', 'left');

		if (isset($value['transaksi_non_rutin_id'])) $this->db->where('id_non_rutin', $value['transaksi_non_rutin_id']);
		if (isset($value['transaksi_id'])) $this->db->where('transaksi_id', $value['transaksi_id']);
		if (isset($value['transaksi_detail_id'])) $this->db->where('transaksi_detail_id', $value['transaksi_detail_id']);
		if (isset($value['transaksi_status'])) $this->db->where('transaksi_detail_status', $value['transaksi_status']);
		if (isset($value['transaksi_detail_group'])) $this->db->where('transaksi_detail_group', $value['transaksi_detail_group']);
		if (isset($value['transaksi_detail_id_group'])) $this->db->where_in('transaksi_detail_id', $value['transaksi_detail_id_group']);
		if (isset($value['transaksi_detail_id_multiple'])) $this->db->where_in('transaksi_detail_id', $value['transaksi_detail_id_multiple']);

		$this->db->where("(is_proses is NULL)");

		$this->db->order_by('transaksi_detail_judul', 'asc');

		$sql = $this->db->get();

		return $sql->result_array();
	}

	public function getSeksiDisposisi($value = '')
	{
		$this->db->select('*');
		$this->db->from('sample.sample_seksi_disposisi a');
		$this->db->join('global.global_seksi b', 'b.seksi_id = a.id_seksi', 'left');

		if (isset($value['id_transaksi'])) $this->db->where('a.id_transaksi', $value['id_transaksi']);
		if (isset($value['id_transaksi_detail'])) $this->db->where('a.id_transaksi_detail', $value['id_transaksi_detail']);
		if (isset($value['seksi_disposisi_id'])) $this->db->where('a.seksi_disposisi_id', $value['seksi_disposisi_id']);

		$sql = $this->db->get();

		return (isset($value['seksi_disposisi_id'])) ? $sql->row_array() : $sql->result_array();
	}

	public function getMaxNoLab()
	{
		$this->db->select("MAX(transaksi_detail_urut) as urut");
		$this->db->from("sample.sample_transaksi_detail");
		$sql = $this->db->get();
		return $sql->row_array();
	}

	public function getMaxNoLabBaru($param = '')
	{

		if (isset($param['transaksi_tipe'])) $this->db->where('transaksi_tipe', $param['transaksi_tipe']);

		$this->db->select("MAX(CAST(transaksi_detail_urut as int)) as urut");
		$this->db->from("sample.sample_transaksi_detail a");
		$this->db->join('sample.sample_transaksi b', 'b.transaksi_id = a.transaksi_id', 'left');

		$sql = $this->db->get();
		return $sql->row_array();
	}

	public function getNoLabBaru($param = '')
	{

		if (isset($param['range'])) $this->db->like('UPPER(transaksi_detail_nomor_sample)',STRTOUPPER($param['range']),'AFTER');
		if (isset($param['transaksi_tipe'])) $this->db->where('transaksi_tipe', $param['transaksi_tipe']);

		$this->db->select("MAX(CAST(transaksi_detail_urut as int)) as urut");
		$this->db->from("sample.sample_transaksi_detail a");
		$this->db->join('sample.sample_transaksi b', 'b.transaksi_id = a.transaksi_id', 'left');

		$sql = $this->db->get();
		return $sql->row_array();
	}

	public function insertLabDetail($value = '')
	{
		// $data['transaksi_detail_id'] = $this->input->get_post('transaksi_detail_id')[$key];
		// $data['transaksi_detail_judul'] = $this->input->get_post('item_judul')[$key];
		// $data['jenis_id'] = $this->input->get_post('jenis_id')[$key];
		// $data['jenis_pekerjaan_id'] = $this->input->get_post('jenis_pekerjaan_id')[$key];
		// $data['transaksi_detail_jumlah'] = $this->input->get_post('transaksi_detail_jumlah')[$key];
		// $data['transaksi_detail_identitas'] = $this->input->get_post('transaksi_detail_identitas')[$key];
		// $data['transaksi_detail_parameter'] = $this->input->get_post('transaksi_detail_parameter')[$key];
		// $data['transaksi_detail_deskripsi_parameter'] = $this->input->get_post('transaksi_detail_deskripsi_parameter')[$key];
		// $data['transaksi_detail_catatan'] = $this->input->get_post('transaksi_detail_catatan')[$key];
		// $data['transaksi_detail_file'] = $files;
		// $data['transaksi_detail_attach'] = $attachments;
		// if (
		// 	$this->input->get_post('jenis_pekerjaan_id')[$key] == 'e00c2166d30380a078851809deb0f0b8ca51127d' || $this->input->get_post('jenis_pekerjaan_id')[$key] ==
		// 	'c467ca615b90a212089687923100d71e'
		// ) {
		// 	$data['transaksi_detail_status'] = $this->input->get_post('transaksi_status');
		// 	$data['id_user_disposisi'] = '2156231';
		// 	$data['id_disposisi'] = 'E44150051A';
		// 	$data['transaksi_detail_is_sampling'] = 'y';
		// } else {
		// 	$data['transaksi_detail_status'] = $this->input->get_post('transaksi_status') + 1;
		// 	$data['id_user_disposisi'] = '';
		// 	$data['id_disposisi'] = '';
		// 	$data['transaksi_detail_is_sampling'] = '';
		// }
		// $data['when_create'] = date('Y-m-d H:i:s');
		// $data['who_create'] = $session['user_nama_lengkap'];
		// $data['who_seksi_create'] = $session['user_unit_id'];
		// $data['transaksi_agreement_keterangan'] = anti_inject($this->input->get_post('transaksi_agreement_keterangan'));
		$this->db->query("INSERT INTO sample.sample_transaksi_detail SELECT '" . create_id() . "',id_seksi,identitas_id,'" . $value['jenis_id'] . "',peminta_jasa_id,transaksi_id,transaksi_detail_pic_pengirim,transaksi_detail_ext_pengirim,'" . $value['transaksi_detail_jumlah'] . "','" . $value['transaksi_detail_parameter'] . "','" . date('Y-m-d H:i:s') . "',transaksi_detail_tgl_memo,transaksi_detail_no_memo,transaksi_detail_foto,transaksi_detail_tgl_estimasi,'" . $value['transaksi_detail_file'] . "',transaksi_detail_no_surat,is_urgent,'" . $value['jenis_pekerjaan_id'] . "','" . $value['when_create'] . "','" . $value['who_create'] . "',transaksi_detail_note,'" . $value['is_khusus'] . "',id_user,'" . $value['who_seksi_create'] . "',id_non_rutin,transaksi_detail_nomor,'" . $value['transaksi_detail_urut'] . "',transaksi_detail_keterangan,transaksi_detail_kode_tracking,transaksi_detail_klasifikasi_id,'" . $value['transaksi_detail_nomor_sample'] . "',transaksi_detail_id_template_keterangan,transaksi_detail_is_template_keterangan,transaksi_detail_pic_telepon,'" . $value['transaksi_detail_attach'] . "','" . $value['transaksi_detail_judul'] . "','" . $value['transaksi_detail_identitas'] . "','" . $value['transaksi_detail_deskripsi_parameter'] . "','" . $value['transaksi_detail_catatan'] . "','" . $value['id_user_disposisi'] . "','" . $value['id_disposisi'] . "',transaksi_detail_reject_alasan,transaksi_detail_agreement_keterangan FROM sample.sample_transaksi_detail WHERE transaksi_detail_id = '" . $value['transaksi_detail_id'] . "'");

		return $this->db->affected_rows();
	}
}

/* End of file M_lab.php */
/* Location: .//C/Users/jii/AppData/Local/Temp/fz3temp-3/M_lab.php */