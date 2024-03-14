<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_request extends CI_Model
{
	/* Get Request */
	public function getRequest($data = null, $where = null)
	{
		$this->db->select("a.transaksi_id, to_char(a.transaksi_waktu ,'DD-MM-YYYY') as transaksi_waktu, a.transaksi_status, transaksi_status, d.seksi_id, d.seksi_nama, b.user_id, b.user_nama_lengkap,
			case
			when transaksi_status = 'n' then 'Belum Approved'
			when transaksi_status = 'r' then 'Approve AVP Customer'
			when transaksi_status = 'a' then 'Approve AVP LUK'
			when transaksi_status = 'y' then 'Approved'
			end as transaksi_statusnya, transaksi_status, transaksi_jam, transaksi_nomor, f.user_nik_sap,a.transaksi_waktu,a.transaksi_status,a.transaksi_jam");
		$this->db->distinct();
		$this->db->from('material.material_transaksi a');
		$this->db->join('global.global_seksi d', 'd.seksi_id = a.id_gudang_tujuan', 'left');
		$this->db->join('global.global_user b', 'b.user_id = a.user_id_peminta', 'left');
		$this->db->join('global.global_api_user e', 'b.user_username = e.user_nik_sap', 'left');
		$this->db->join('global.global_api_user f', 'e.user_direct_superior = f.user_poscode', 'left');

		if (isset($data['user_id']) && $data['role_id'] != '1' && $data['role_id'] != 'df416116aa07eba2d4140d461ff2dfc3a927515c' && $data['role_id'] != '79d5b34a78b48d85eb1b65249fca73704dc49665' && $data['grade'] == '1') $this->db->where("a.user_id_peminta = '$data[user_id]'");
		// if (isset($data['user_nik_sap'])) $this->db->where("e.user_nik_sap = '$data[user_nik_sap]'");
		// if (isset($data['user_unit_id'])) $this->db->where("e.user_unit_id = '$data[user_unit_id]'");
		if ($data['role_id'] != 'df416116aa07eba2d4140d461ff2dfc3a927515c' && $data['role_id'] != '1') {
			if (isset($data['user_unit_id'])) $this->db->where("e.user_unit_id = '$data[user_unit_id]'");
		}
		if (isset($data['transaksi_status'])) $this->db->where("a.transaksi_status = '$data[transaksi_status]'");
		if (isset($data['transaksi_tipe'])) $this->db->where('upper(transaksi_tipe)', strtoupper($data['transaksi_tipe']));
		if (isset($data['transaksi_id'])) $this->db->where('a.transaksi_id', $data['transaksi_id']);
		if (isset($data['tanggal_cari_awal'])) $this->db->where('transaksi_waktu >=', $data['tanggal_cari_awal']);
		if (isset($data['tanggal_cari_akhir'])) $this->db->where('transaksi_waktu <=', $data['tanggal_cari_akhir']);
		if ($data['tahun']) $this->db->where("date_part('year', a.transaksi_waktu) = " . $data['tahun']);
		$this->db->order_by('a.transaksi_waktu desc,a.transaksi_status asc,a.transaksi_jam desc');
		$sql = $this->db->get();

		return ($data['transaksi_id']) ? $sql->row_array() : $sql->result_array();
	}

	public function getTransaksiOut($data = null, $where = null)
	{
		$this->db->select("a.transaksi_id, to_char(a.transaksi_waktu ,'DD-MM-YYYY') as transaksi_waktu, a.transaksi_status, transaksi_status, d.seksi_id, d.seksi_nama, b.user_id, b.user_nama_lengkap,
			case
			when transaksi_status = 'n' then 'Belum Approved'
			when transaksi_status = 'r' then 'Approve AVP Customer'
			when transaksi_status = 'a' then 'Approve AVP LUK'
			when transaksi_status = 'y' then 'Approved'
			end as transaksi_statusnya, transaksi_status, transaksi_jam, transaksi_nomor, f.user_nik_sap");
		$this->db->from('material.material_transaksi a');
		$this->db->join('global.global_seksi d', 'd.seksi_id = a.id_gudang_tujuan', 'left');
		$this->db->join('global.global_user b', 'b.user_id = a.user_id_peminta', 'left');
		$this->db->join('global.global_api_user e', 'b.user_username = e.user_nik_sap', 'left');
		$this->db->join('global.global_api_user f', 'e.user_direct_superior = f.user_poscode', 'left');

		if (isset($data['user_id']) && $data['role_id'] != '1' && $data['role_id'] != 'df416116aa07eba2d4140d461ff2dfc3a927515c' && $data['role_id'] != '79d5b34a78b48d85eb1b65249fca73704dc49665' && $data['grade'] == '1') $this->db->where("a.user_id_peminta = '$data[user_id]'");
		if (isset($data['transaksi_status'])) $this->db->where("a.transaksi_status = '$data[transaksi_status]'");
		if (isset($data['transaksi_tipe'])) $this->db->where('upper(transaksi_tipe)', strtoupper($data['transaksi_tipe']));
		if (isset($data['transaksi_id'])) $this->db->where('a.transaksi_id', $data['transaksi_id']);
		if (isset($data['tanggal_cari_awal'])) $this->db->where('transaksi_waktu >=', $data['tanggal_cari_awal']);
		if (isset($data['tanggal_cari_akhir'])) $this->db->where('transaksi_waktu <=', $data['tanggal_cari_akhir']);
		if ($data['tahun']) $this->db->where("date_part('year', a.transaksi_waktu) = " . $data['tahun']);
		$this->db->order_by('a.transaksi_waktu desc,a.transaksi_status asc,a.transaksi_jam desc');
		$sql = $this->db->get();

		return ($data['transaksi_id']) ? $sql->row_array() : $sql->result_array();
	}
	/* Get Request */

	public function getRequestDetail($data = null)
	{
		$this->db->select('b.transaksi_detail_id,b.transaksi_id,b.item_id,b.transaksi_detail_jumlah,(b.transaksi_detail_total),a.item_nama,a.item_satuan');
		$this->db->from('material.material_transaksi_detail b');
		$this->db->join('material.material_item a', 'a.item_id=b.item_id', 'left');
		$this->db->where('b.transaksi_id = ', $data['transaksi_id']);
		$sql = $this->db->get();
		// echo json_encode($data);
		return $sql->result_array();
	}

	public function getRequestHistory($data = null)
	{
		$this->db->select('*');
		$this->db->from('material.material_transaksi_history a');
		if (isset($data['transaksi_id'])) $this->db->where('id_transaksi', $data['transaksi_id']);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function getNomorMax($data = null)
	{
		$this->db->select('MAX(CAST(transaksi_urut AS "numeric")) AS isi');
		$this->db->from('material.material_transaksi');
		$this->db->where("EXTRACT(YEAR FROM transaksi_waktu) = '" . date('Y') . "'");

		return $this->db->get()->row_array();
	}

	public function insertTransaksi($data)
	{
		$this->db->insert('material.material_transaksi', $data);
		return $this->db->affected_rows();
	}

	public function updateIdTransaksiKosong($data)
	{
		$this->db->set($data);
		$this->db->where('transaksi_id=', '');
		$this->db->or_where('transaksi_id is null');
		$this->db->update('material.material_transaksi_detail');

		return $this->db->affected_rows();
	}

	public function deleteTransaksi($id)
	{
		$this->db->where('transaksi_id', $id);
		$this->db->delete('material.material_transaksi');
		$this->db->affected_rows();
	}

	public function deleteTransaksiDetail($id)
	{
		$this->db->where('transaksi_id', $id);
		$this->db->delete('material.material_transaksi_detail');
		$this->db->affected_rows();
	}

	public function updateTransaksi($id, $data)
	{

		$this->db->set($data);
		$this->db->where('transaksi_id', $id);
		$this->db->update('material.material_transaksi');

		return $this->db->affected_rows();
	}



	// End Material Request

	// Start Transaksi IN
	// get data Transaksi In
	public function getTransaksiIn($data = null, $where = null)
	{
		$this->db->where('transaksi_tipe=', 'i');

		$this->db->select("a.transaksi_id,to_char(transaksi_waktu,'DD-MM-YYYY') as transaksi_waktu,transaksi_jam,is_batal,list_batch_kode,list_batch_kode_final");
		$this->db->distinct();
		$this->db->from('material.material_transaksi a');
		$this->db->join('material.material_list_batch b', 'b.transaksi_id = a.transaksi_id', 'left');



		if (isset($where)) $this->db->where($where);
		if (isset($data['transaksi_id'])) $this->db->where('transaksi_id', $data['transaksi_id']);
		// if (isset($data['tanggal_awal'])) $this->db->where('date(transaksi_waktu) >= ', $data['tanggal_awal']);
		// if (isset($data['tanggal_akhir'])) $this->db->where('date(transaksi_waktu) <= ', $data['tanggal_akhir']);
		if (isset($data['is_batal'])) $this->db->where('is_batal', $data['is_batal']);
		$this->db->order_by('transaksi_waktu desc,transaksi_jam desc');
		$sql = $this->db->get();
		return (isset($data['transaksi_id'])) ? $sql->row_array() : $sql->result_array();
	}
	// end get Data Transaksi In

	// start Simpan Transaksi In
	public function insertTransaksiIn($data)
	{
		$this->db->insert('material.material_transaksi', $data);
		return $this->db->affected_rows();
		echo json_encode($data);
	}
	// End Simpan Transaksi In

	public function batalTransaksiIn($id, $data)
	{
		$this->db->set($data)->where('transaksi_id', $id)->update('material.material_transaksi');
		return $this->db->affected_rows();
	}

	// End Transaksi In

	// Start Transaksi Out
	// start Approve Transaksi
	public function approveTransaksi($id, $data)
	{
		$this->db->set($data);
		$this->db->where('transaksi_id', $id);
		$this->db->update('material.material_transaksi');
		return $this->db->affected_rows();
	}
	// End Approve Transaksi

	// Start Insert Transaksi Out
	public function insertTransaksiOut($data)
	{
		$this->db->insert('material.material_transaksi', $data);
		return $this->db->affected_rows();
	}


	// End Insert Transaksi Out
	// End Transaksi Out

	// EASY UI
	// start easy ui request

	public function getEasyuiMaterial($data = null)
	{
		$this->db->select("a.transaksi_detail_id,a.transaksi_id,a.item_id,c.item_nama,a.transaksi_detail_jumlah, to_char(a.transaksi_detail_total,'999G999G990D00' ) as transaksi_detail_total,c.item_harga,c.item_satuan");
		$this->db->from('material.material_transaksi_detail a');
		$this->db->join('material.material_transaksi b', 'b.transaksi_id = a.transaksi_id', 'left');
		$this->db->join('material.material_item c', 'c.item_id = a.item_id', 'left');
		// $this->db->where('a.transaksi_id = ',$data['transaksi_id']);
		if (isset($data['transaksi_id'])) $this->db->where('a.transaksi_id', $data['transaksi_id']);
		// $this->db->or_where('a.transaksi_id= ','');
		// $this->db->or_where('a.transaksi_id is null');
		$sql = $this->db->get();

		return $sql->result_array();
	}

	public function insertEasyuiMaterial($data)
	{
		$this->db->insert('material.material_transaksi_detail', $data);
		return $this->db->affected_rows();
	}

	public function editEasyuiMaterial($id, $data)
	{
		$this->db->set($data);
		$this->db->where('transaksi_detail_id', $id);
		$this->db->update('material.material_transaksi_detail');

		return $this->db->affected_rows();
	}
	public function deleteEasyuiMaterial($id)
	{
		$this->db->where('transaksi_detail_id', $id);
		$this->db->delete('material.material_transaksi_detail');
		return $this->db->affected_rows();
	}
	// end easy ui request

	// start easy ui update document
	public function getEasyuiDocument($data = null)
	{
		$this->db->select('*');
		$this->db->from('material.material_batch_file');
		$this->db->where('list_batch_id=', $data['list_batch_id']);
		$sql = $this->db->get();
		return $sql->result_array();
	}

	public function insertEasyuiDocument($data)
	{
		$this->db->insert('material.material_batch_file', $data);
		return $this->db->affected_rows();
	}

	public function editEasyuiDocument($id, $data)
	{
		$this->db->set($data);
		$this->db->where('batch_file_id', $id);
		$this->db->update('material.material_batch_file');

		return $this->db->affected_rows();
	}
	public function deleteEasyuiDocument($id)
	{
		$this->db->where('batch_file_id', $id);
		$this->db->delete('material.material_batch_file');
		return $this->db->affected_rows();
	}


	// end easy ui update document


	// END EASY UI


	// lain
	public function getSumDetailJumlah($data = null)
	{
		$this->db->select('sum(transaksi_detail_jumlah) as batch_stok');
		$this->db->from('material.material_transaksi_detail');
		$this->db->where('transaksi_id=', $data['transaksi_id']);
		$sql = $this->db->get();
		return $sql->row_array();
	}

	public function insertListBatch($data1)
	{
		$this->db->insert('material.material_list_batch', $data1);
		return $this->db->affected_rows();
	}



	public function getItemJumlah($data = null)
	{
		$this->db->select('*');
		$this->db->from('material.material_item');
		$this->db->where('item_id ', $data['item_id']);
		$sql = $this->db->get();
		return $sql->row_array();
	}

	public function insertListStok($data2)
	{
		$this->db->insert('material.material_list_stok', $data2);
		return $this->db->affected_rows();
	}

	public function updatejmlMaterialItem($id, $data4)
	{
		$this->db->set($data4);
		$this->db->where('item_id', $id);
		$this->db->update('material.material_item');

		return $this->db->affected_rows();
	}

	public function getStok($data = null)
	{
		$this->db->select('item_id,item_nama,item_stok,item_satuan');
		$this->db->from('material.material_item');

		if (isset($data['tanggal_awal'])) $this->db->where('date(transaksi_waktu) >= ', $data['tanggal_awal']);
		if (isset($data['tanggal_akhir'])) $this->db->where('date(transaksi_waktu) <= ', $data['tanggal_akhir']);
		if (isset($data['item_id'])) $this->db->where('item_id', $data['item_id']);
		if (isset($data['filter_kode_material'])) $this->db->where('item_id', $data['filter_kode_material']);
		if (isset($data['item_cari'])) $this->db->where("item_id", $data['item_cari']);
		if (isset($data['item_nama'])) $this->db->where("upper(item_nama) LIKE '%" . strtoupper($data['item_nama']) . "%'");

		$sql = $this->db->get();

		return (isset($data['item_id'])) ? $sql->row_array() : $sql->result_array();
	}

	public function getJenisBarang($data = null)
	{
		$this->db->select('*');
		$this->db->from('material.material_jenis');
		if (isset($data['tanggal_awal'])) $this->db->where('date(transaksi_waktu) >= ', $data['tanggal_awal']);
		if (isset($data['tanggal_akhir'])) $this->db->where('date(transaksi_waktu) <= ', $data['tanggal_akhir']);
		if (isset($data['jenis_id'])) $this->db->where('jenis_id', $data['jenis_id']);
		if (isset($data['jenis_barang'])) $this->db->where("jenis_id", $data['jenis_barang']);
		if (isset($data['jenis_nama'])) $this->db->where("upper(jenis_nama) LIKE '%" . strtoupper($data['jenis_nama']) . "%'");

		$sql = $this->db->get();

		return (isset($data['jenis_id'])) ? $sql->row_array() : $sql->result_array();
	}

	public function getStokDetail($data = null)
	{
		$this->db->select("to_char(list_stok_waktu,'DD-MM-YYYY') as list_stok_waktu,list_stok_tipe,list_stok_id,a.list_batch_id,
			case
			when list_stok_tipe = 'i' then 'Barang Masuk'
			when list_stok_tipe = 'o' then 'Barang Keluar'
			end as jenis_kegiatan,
			item_nama,list_stok_jumlah,list_stok_stok,
			case
			when list_stok_tipe = 'i' then 'Barang Masuk'
			when list_stok_tipe = 'o' then 'Barang Keluar'
			end as keterangan,list_stok_jam,
			item_satuan,seksi_nama");

		$this->db->from('material.material_list_stok a');
		$this->db->join('material.material_item b', 'b.item_id = a.item_id', 'left');
		$this->db->join('sample.sample_peminta_jasa c', 'c.peminta_jasa_id = a.id_gudang', 'left');
		$this->db->join('global.global_departement d', 'd.dep_id=a.id_gudang', 'left');
		//
		$this->db->join('material.material_transaksi_detail e', 'e.transaksi_detail_id = a.transaksi_detail_id', 'left');
		$this->db->join('material.material_transaksi f', 'f.transaksi_id = e.transaksi_id', 'left');
		$this->db->join('global.global_seksi g', 'g.seksi_id = f.id_gudang_tujuan', 'left');
		$this->db->join('global.global_user h', 'h.user_id = f.user_id_peminta', 'left');


		//
		// $this->db->join('material.material_batch_file e','e.list_batch_id=a.list_batch_id','left');
		$this->db->where('a.item_id=', $data['item_id']);
		$this->db->order_by('list_stok_waktu desc,list_stok_jam desc');

		$sql = $this->db->get();

		return $sql->result_array();
	}

	// start data stok limit
	public function getLimitMaterial($data = null)
	{
		// $this->db->select('item_nama, item_satuan, item_stok, item_stok_alert, batch_file_tgl_expired, batch_file_judul');
		$this->db->select('*');
		$this->db->from('material.material_item a');
		$this->db->join('material.material_transaksi_detail b', 'a.item_id = b.item_id', 'left');
		$this->db->join('material.material_list_batch c', 'b.transaksi_detail_id = c.transaksi_detail_id', 'left');
		$this->db->join('material.material_batch_file d', "c.list_batch_id = d.list_batch_id AND d.batch_file_tgl_expired <= '" . date('Y-m-d') . "'", 'left');
		$this->db->where("item_stok <= item_stok_alert");
		// $this->db->or_where("batch_file_tgl_expired <= ", date('Y-m-d'));
		if (isset($data['item_id'])) $this->db->where('item_id', $data['item_id']);
		$sql = $this->db->get();
		return (isset($data['item_id'])) ? $sql->row_array() : $sql->result_array();
	}

	public function getLimitMaterialJumlah($data = null)
	{
		$this->db->select('count(a.item_id) as total_limit');
		$this->db->from('material.material_item a');
		$this->db->join('material.material_transaksi_detail b', 'a.item_id = b.item_id', 'left');
		$this->db->join('material.material_list_batch c', 'b.transaksi_detail_id = c.transaksi_detail_id', 'left');
		$this->db->join('material.material_batch_file d', 'c.list_batch_id = d.list_batch_id', 'left');
		$this->db->where("item_stok <= item_stok_alert");
		$this->db->or_where("batch_file_tgl_expired <= ", date('Y-m-d'));
		$sql = $this->db->get();
		return $sql->row_array();
	}
	// untuk notif stok limit


	// public function getNotifLimitMaterial($data=null){
	// 	$this->db->select('count(item_id) as item_id');
	// 	$this->db->from('material.material_item');
	// 	$this->db->where('item_stok <= 20');
	// 	if(isset($data['item_id'])) $this->db->where('item_id',$data['item_id']);
	// 	$sql = $this->db->get();
	// 	return (isset($data['item_id'])) ? $sql->row_array() : $sql->result_array();


	// }
	// end data stok limit

	// start GET material ganti item
	public function getMaterial($data = null)
	{

		$this->db->select("b.item_id,item_nama,list_stok_stok,a.item_stok,
			case
			when b.list_stok_tipe = 'i' then 'barang_masuk'
			end as stok_masuk,
			case
			when b.list_stok_tipe = 'i' then 'barang_keluar'
			end as stok_keluar");
		$this->db->from('material.material_item a');
		$this->db->join('material.material_list_stok b', 'a.item_id = b.item_id');
		$this->db->join('material.material_transaksi_detail c', 'c.transaksi_detail_id=b.transaksi_detail_id', 'left');
		$this->db->join('material.material_transaksi d', 'd.transaksi_id=c.transaksi_id');
		if (isset($data['item_cari'])) $this->db->where('b.item_id', $data['item_cari']);
		// if(isset($data['bulan_cari'])) $this->db->where("DATE_FORMAT(list_stok_waktu,'Y-m')",$data['bulan_cari']);
		// if(isset($data['bulan_cari'])) $this->db->where("MONTH(list_stok_waktu)",$data['bulan_cari']);
		// if(isset($data['tahun_cari'])) $this->db->where("YEAR(list_stok_waktu)",$data['tahun_cari']);
		// $this->db->group_by('b.item_id,item_nama,a.item_stok,b.list_stok_jumlah');
		$sql = $this->db->get();

		return $sql->result_array();
	}
	// end get material ganti item

	// laporan stok
	public function getLaporanData($data = null, $where)
	{
		$this->db->select("jenis_nama,item_nama,item_satuan,
			sum(case
			when a.list_stok_tipe = 'i' then list_stok_jumlah
			end) as stok_masuk,
			sum(case
			when a.list_stok_tipe = 'o' then list_stok_jumlah
			end) as stok_keluar,item_stok
			");
		// $this->db->select('*');
		$this->db->from('material.material_list_stok a');
		$this->db->join('material.material_item b', 'b.item_id = a.item_id', 'inner');
		$this->db->join('material.material_jenis c', 'c.jenis_id = b.jenis_id', 'inner');
		// $this->db->where('transaksi_status','y');
		if (isset($data['item_cari'])) $this->db->where('a.item_id', $data['item_cari']);
		if (isset($data['jenis_barang'])) $this->db->where('b.jenis_id', $data['jenis_barang']);
		if (isset($data['tanggal_cari_awal'])) $this->db->where('list_stok_waktu >=', $data['tanggal_cari_awal']);
		if (isset($data['tanggal_cari_akhir'])) $this->db->where('list_stok_waktu <=', $data['tanggal_cari_akhir']);

		if (!empty($where)) $this->db->where($where);

		$this->db->group_by('item_nama,item_stok,item_satuan,jenis_nama');

		$this->db->order_by('jenis_nama asc');
		$this->db->order_by('item_nama asc');
		$sql = $this->db->get();
		return $sql->result_array();
	}

	// end laporan stok

	// start cetak laporan bulanan
	public function getMaterialCetak($data)
	{
		$this->db->select("b.item_id,item_nama,item_stok,a.item_stok");
		$this->db->from('material.material_item a');
		$this->db->join('material.material_list_stok b', 'a.item_id = b.item_id');
		if (isset($data['item_cari'])) $this->db->where('b.item_id', $data['item_cari']);
		// if(isset($data['bulan_cari'])) $this->db->where("DATE_FORMAT(list_stok_waktu,'Y-m')",$data['bulan_cari']);
		// if(isset($data['bulan_cari'])) $this->db->where("MONTH(list_stok_waktu)",$data['bulan_cari']);
		// if(isset($data['tahun_cari'])) $this->db->where("YEAR(list_stok_waktu)",$data['tahun_cari']);
		$this->db->group_by('b.item_id,item_nama,a.item_stok');
		$sql = $this->db->get();

		return $sql->result_array();
	}
	// end cetak laporan bulanan



	// start cetak laporan tahun
	public function cetakLaporanTahunan($data)
	{
		$this->db->select('item_id,item_nama,item_stok');
		$this->db->from('material.material_item');

		if ($data['item_id'] != 'null') {
			$this->db->where('item_id = ', $data['item_id']);
		}
		// $this->db->where('');

		$sql = $this->db->get();

		return $sql->result_array();
	}
	// end cetak laporan tahun

	// start data update document
	public function getDocument($data = null, $where = null)
	{
		$this->db->select("item_nama, a.list_batch_id , to_char(b.transaksi_waktu ,'DD-MM-YYYY') as transaksi_waktu,a.list_batch_kode_final");
		$this->db->from('material.material_list_batch a');
		$this->db->join('material.material_transaksi b', 'a.transaksi_id = b.transaksi_id', 'left');
		$this->db->join('material.material_transaksi_detail c', 'c.transaksi_detail_id = a.transaksi_detail_id', 'left');
		$this->db->join('material.material_item d', 'c.item_id = d.item_id', 'left');
		if (isset($where)) $this->db->where($where);
		if (isset($data['tanggal_cari_awal'])) $this->db->where('date(transaksi_waktu) >= ', $data['tanggal_cari_awal']);
		if (isset($data['tanggal_cari_akhir'])) $this->db->where('date(transaksi_waktu) <= ', $data['tanggal_cari_akhir']);
		if (isset($data['list_batch_id'])) $this->db->where('list_batch_id=', $data['list_batch_id']);
		// $this->db->where('d.jenis_id', 'd2b711f83dfc51852493d7690e59d82f142bf5db');

		$this->db->order_by('transaksi_waktu', 'desc');
		$this->db->order_by('b.when_create', 'desc');

		//  $this->db->where("a.transaksi_id!=''");
		$sql = $this->db->get();

		return (isset($data['list_batch_id'])) ? $sql->row_array() : $sql->result_array();
	}
	// end data update document

	// start data update document detail
	public function getDocumentDetail($data = null)
	{
		$this->db->select("batch_file_id,list_batch_id, to_char(batch_file_tgl_terbit, 'DD-MM-YYYY') as batch_file_tgl_terbit, to_char(batch_file_tgl_expired,'DD-MM-YYYY') as batch_file_tgl_expired,batch_file_isi,batch_file_judul ");
		$this->db->from('material.material_batch_file a');
		$this->db->where('list_batch_id=', $data['list_batch_id']);
		if (isset($data['batch_file_tgl_expired'])) $this->db->where("batch_file_tgl_expired>='$data[batch_file_tgl_expired]'");
		$this->db->order_by('batch_file_tgl_terbit', 'desc');
		$this->db->order_by('batch_file_tgl_expired', 'desc');
		$this->db->order_by('when_create', 'desc');
		// if(isset($data['batch_file_id'])) $this->db->where('batch_file_id',$data['batch_file_id']);

		$sql = $this->db->get();

		// return (isset($data['batch_file_id'])) ? $sql->row_array() : $sql->result_array();
		return $sql->result_array();
	}

	public function getDocumentDetailAll($data = null)
	{
		$this->db->select("a.batch_file_id,a.list_batch_id, to_char(batch_file_tgl_terbit, 'DD-MM-YYYY') as batch_file_tgl_terbit, to_char(batch_file_tgl_expired,'DD-MM-YYYY') as batch_file_tgl_expired,a.batch_file_isi,a.batch_file_judul ");
		$this->db->from('material.material_batch_file a');
		$this->db->join('material.material_list_batch b', 'a.list_batch_id = b.list_batch_id', 'left');
		$this->db->join('material.material_transaksi_detail c', 'c.transaksi_detail_id = b.transaksi_detail_id', 'left');
		$this->db->where('item_id', $data['id_item']);
		// if (isset($data['batch_file_tgl_expired'])) $this->db->where("batch_file_tgl_expired>='$data[batch_file_tgl_expired]'");
		$this->db->order_by('a.batch_file_tgl_terbit', 'desc');
		$this->db->order_by('a.batch_file_tgl_expired', 'desc');
		$this->db->order_by('a.when_create', 'desc');
		// if(isset($data['batch_file_id'])) $this->db->where('batch_file_id',$data['batch_file_id']);

		$sql = $this->db->get();

		// return (isset($data['batch_file_id'])) ? $sql->row_array() : $sql->result_array();
		return $sql->result_array();
	}
	// start data update documet detail

	// isnert pengajauan perbaiakn
	public function insertPengajuanPerbaikan($data)
	{
		$this->db->insert('material.material_aset_perbaikan', $data);
		return $this->db->affected_rows();
	}

	//

	// end isnert pengajuan perbaiakn

	// start pengajuan perbaikan
	public function updatePengajuanPerbaikan($id, $data)
	{
		$this->db->set($data);
		$this->db->where('aset_perbaikan_id=', $id);
		$this->db->update('material.material_aset_perbaikan');

		return $this->db->affected_rows();
	}
	// end pengajuan perbaikan

	// start delete pengjuan
	public function deletePengajuanPerbaikan($id)
	{
		$this->db->where('aset_perbaikan_id', $id);
		$this->db->delete('material.material_aset_perbaikan');

		return $this->db->affected_rows();
	}
	// end delete pengajuan


	// start get pengajuan
	public function getPengajuan($data = null, $where = null)
	{
		$this->db->select("to_char(a.aset_perbaikan_tgl_penyerahan, 'DD-MM-YYYY') as tanggal_penyerahan,to_char(a.aset_perbaikan_tgl_selesai,'DD-MM-YYYY') as tanggal_selesai,aset_nomor,aset_nama,aset_perbaikan_note,aset_perbaikan_note_selesai,aset_perbaikan_file,a.pekerjaan_id,d.sample_pekerjaan_id,d.sample_pekerjaan_nama,aset_perbaikan_vendor,is_jadwal,
			case
			when aset_perbaikan_status ='n' then 'Belum Dikerjakan'
			when aset_perbaikan_status ='y' then 'Sudah Dikerjakan'
			end as perbaikan_status,
			aset_perbaikan_status,peminta_jasa_nama,e.peminta_jasa_id,pekerjaan_id,aset_nomor_utama,
			a.aset_perbaikan_id,a.aset_detail_id,c.aset_id,aset_perbaikan_file,id_user,aset_detail_merk ");
		$this->db->from('material.material_aset_perbaikan a');
		$this->db->join('material.material_aset_detail b', 'a.aset_detail_id=b.aset_detail_id','left');
		$this->db->join('material.material_aset c ', 'c.aset_id=b.aset_id','left');
		$this->db->join('sample.sample_pekerjaan d', 'd.sample_pekerjaan_id = a.pekerjaan_id', 'left');
		$this->db->join('sample.sample_peminta_jasa e', 'e.peminta_jasa_id = a.peminta_id', 'left');
		$this->db->join('global.global_user z', 'z.user_id = a.id_user');
		if (isset($data['user_id']) && $data['role_id'] != '1' && $data['role_id'] != 'df416116aa07eba2d4140d461ff2dfc3a927515c' && $data['role_id'] != '79d5b34a78b48d85eb1b65249fca73704dc49665' && $data['grade'] == '1') {
			$this->db->join('global.global_api_user y', 'z.user_username = y.user_nik_sap');
			$this->db->join('global.global_api_user x', 'y.user_direct_superior = x.user_poscode');
		}
		if (isset($where)) $this->db->where($where);
		if (isset($data['user_id']) && $data['role_id'] != '1' && $data['role_id'] != 'df416116aa07eba2d4140d461ff2dfc3a927515c' && $data['role_id'] != '79d5b34a78b48d85eb1b65249fca73704dc49665' && $data['grade'] == '1') {
			$this->db->where("a.id_user = '$data[user_id]'");
			if (isset($data['user_unit_id'])) $this->db->where("y.user_unit_id = '$data[user_unit_id]'");
		}
		if (isset($data['tanggal_cari_awal'])) $this->db->where('date(a.aset_perbaikan_tgl_penyerahan) >= ', $data['tanggal_cari_awal']);
		if (isset($data['tanggal_cari_akhir'])) $this->db->where('date(a.aset_perbaikan_tgl_penyerahan) <= ', $data['tanggal_cari_akhir']);
		if (isset($data['aset_perbaikan_id'])) $this->db->where('aset_perbaikan_id', $data['aset_perbaikan_id']);
		if (isset($data['tahun'])) $this->db->where("date_part('year', a.aset_perbaikan_tgl_penyerahan) = " . $data['tahun']);
		if (isset($data['terjadwal_cari']) && $data['terjadwal_cari'] != '-') $this->db->where('aset_perbaikan_status', $data['terjadwal_cari']);
		if (isset($data['jenis_cari']) && $data['jenis_cari'] != '-') $this->db->where('pekerjaan_id', $data['jenis_cari']);
		$this->db->order_by('a.aset_perbaikan_tgl_penyerahan', 'desc');
		$this->db->order_by('a.when_create', 'desc');
		$sql = $this->db->get();
		return (isset($data['aset_perbaikan_id'])) ? $sql->row_array() : $sql->result_array();
	}
	// end get pengajuan

	// start get pengajuan
	public function getJadwalPerbaikan($data = null, $where)
	{
		$this->db->select("to_char(a.aset_perbaikan_tgl_penyerahan, 'DD-MM-YYYY') as tanggal_penyerahan,to_char(a.aset_perbaikan_tgl_selesai,'DD-MM-YYYY') as tanggal_selesai,to_char(a.aset_perbaikan_tgl_deadline,'DD-MM-YYYY') as tanggal_deadline,to_char(a.aset_perbaikan_tgl_selesai,'DD-MM-YYYY') as tanggal_selesai,aset_nomor,aset_nama,aset_perbaikan_note,aset_perbaikan_file,a.pekerjaan_id,d.sample_pekerjaan_id,d.sample_pekerjaan_nama,aset_perbaikan_tgl_selesai,aset_perbaikan_tgl_penyerahan,aset_perbaikan_tgl_deadline,aset_perbaikan_tgl_selesai,a.aset_perbaikan_status,
			case
			when aset_perbaikan_status ='n' then 'Pengajuan'
			when aset_perbaikan_status ='k' then 'Dikerjakan'
			when aset_perbaikan_status ='p' then 'Pending'
			when aset_perbaikan_status ='y' then 'Selesai'
			end as perbaikan_status,peminta_jasa_nama,
			case
			when pekerjaan_id ='p' then 'Perbaikan'
			when pekerjaan_id ='k' then 'Kalibrasi'
			end as pekerjaan_nama,e.peminta_jasa_id,a.aset_perbaikan_tgl_penyerahan,a.aset_perbaikan_tgl_selesai,c.aset_nomor_utama,aset_perbaikan_vendor,
			a.aset_perbaikan_id,b.aset_detail_id,c.aset_id,aset_perbaikan_file ");
		$this->db->from('material.material_aset_perbaikan a');
		$this->db->join('material.material_aset_detail b', 'a.aset_detail_id=b.aset_detail_id');
		$this->db->join('material.material_aset c ', 'c.aset_id=b.aset_id');
		$this->db->join('sample.sample_pekerjaan d', 'd.sample_pekerjaan_id = a.pekerjaan_id', 'left');
		$this->db->join('sample.sample_peminta_jasa e', 'e.peminta_jasa_id = a.peminta_id', 'left');
		$this->db->where('is_jadwal', 'y');
		if (!empty($where)) $this->db->where($where);
		// if (isset($data['tanggal_awal'])) $this->db->where('date(a.aset_perbaikan_tgl_penyerahan) >= ', $data['tanggal_awal']);
		// if (isset($data['tanggal_akhir'])) $this->db->where('date(a.aset_perbaikan_tgl_penyerahan) <= ', $data['tanggal_akhir']);
		// if (isset($data['tanggal_awal'])) $this->db->where('date(a.aset_perbaikan_tgl_deadline) >= ', $data['tanggal_awal']);
		// if (isset($data['tanggal_akhir'])) $this->db->where('date(a.aset_perbaikan_tgl_deadline) <= ', $data['tanggal_akhir']);
		if (isset($data['aset_perbaikan_id'])) $this->db->where('aset_perbaikan_id', $data['aset_perbaikan_id']);
		if (isset($data['aset_nomor'])) $this->db->where("UPPER(aset_nomor) LIKE  '%" . strtoupper($data['aset_nomor']) . "%'");
		if (isset($data['aset_nama'])) $this->db->where("UPPER(aset_nama) LIKE '%" . strtoupper($data['aset_nama']) . "%'");
		if (isset($data['aset_nomor_utama'])) $this->db->where("cast(c.aset_nomor_utama as TEXT) LIKE '%" . ($data['aset_nomor_utama']) . "%' ");
		if (isset($data['sample_peminta_jasa'])) $this->db->where("upper(peminta_jasa_nama) LIKE '%" . strtoupper($data['sample_peminta_jasa']) . "%'");
		if (isset($data['aset_perbaikan_vendor'])) $this->db->where("aset_perbaikan_vendor LIKE '%" . strtoupper($data['aset_perbaikan_vendor']) . "%'");
		if (isset($data['pekerjaan_id_cari']) && $data['pekerjaan_id_cari'] != '-') $this->db->where('a.pekerjaan_id', $data['pekerjaan_id_cari']);
		if (isset($data['terjadwal_cari']) && $data['terjadwal_cari'] != '-') $this->db->where('aset_perbaikan_status', $data['terjadwal_cari']);

		// if (isset($data['tahun'])) $this->db->where("date_part('year', a.aset_perbaikan_tgl_penyerahan) = ".$data['tahun']);
		// if (isset($data['tahun'])) $this->db->where("date_part('year', a.aset_perbaikan_tgl_deadline) = ".$data['tahun']);
		$this->db->order_by('a.when_create', 'desc');

		$sql = $this->db->get();
		return (isset($data['aset_perbaikan_id'])) ? $sql->row_array() : $sql->result_array();
	}
	// end get pengajuan

	//

	public function getNotifDokumen($data = null, $where = null)
	{
		$this->db->select("item_nama,a.list_batch_id,to_char(batch_file_tgl_expired, 'DD-MM-YYYY') as batch_file_tgl_expired,batch_file_isi,batch_file_judul,list_batch_kode_final,item_stok");
		$this->db->from('material.material_list_batch a');
		$this->db->join('material.material_transaksi_detail b', 'a.transaksi_detail_id = b.transaksi_detail_id', 'left');
		$this->db->join('material.material_item c', 'c.item_id = b.item_id', 'left');
		$this->db->join('material.material_batch_file d', 'd.list_batch_id = a.list_batch_id', 'left');
		$this->db->where("batch_file_tgl_expired <= ", date('Y-m-d'));
		$this->db->where("item_stok > ", '0');
		if (isset($where)) $this->db->where($where);
		if (isset($data['tanggal_cari_awal'])) $this->db->where('date(batch_file_tgl_expired) >= ', $data['tanggal_cari_awal']);
		if (isset($data['tanggal_cari_akhir'])) $this->db->where('date(batch_file_tgl_expired) <= ', $data['tanggal_cari_akhir']);
		$this->db->order_by('batch_file_tgl_expired desc,d.when_create desc');
		$sql = $this->db->get();
		return $sql->result_array();
	}

	// jumlah notif dkumennya
	public function getNotifDocumentJumlah($data = null)
	{
		$this->db->select("count(batch_file_id) as total_exp");
		$this->db->from('material.material_list_batch a');
		$this->db->join('material.material_transaksi_detail b', 'a.transaksi_detail_id = b.transaksi_detail_id', 'left');
		$this->db->join('material.material_item c', 'c.item_id = b.item_id', 'left');
		$this->db->join('material.material_batch_file d', 'd.list_batch_id = a.list_batch_id', 'left');
		$this->db->where("batch_file_tgl_expired <= ", date('Y-m-d'));
		$sql = $this->db->get();
		return $sql->row_array();
	}

	// untuk laporan
	public function getLapDocument($data = null, $where = null)
	{
		$this->db->select("item_nama,a.list_batch_id,to_char(batch_file_tgl_expired, 'DD-MM-YYYY') as batch_file_tgl_expired,to_char(batch_file_tgl_terbit, 'DD-MM-YYYY') as batch_file_tgl_terbit,batch_file_isi,batch_file_judul,list_batch_kode_final");
		$this->db->from('material.material_list_batch a');
		$this->db->join('material.material_transaksi_detail b', 'a.transaksi_id = b.transaksi_id', 'left');
		$this->db->join('material.material_item c', 'c.item_id = b.item_id', 'left');
		$this->db->join('material.material_batch_file d', 'd.list_batch_id = a.list_batch_id', 'left');
		$this->db->where("batch_file_tgl_expired > ", date('Y-m-d'));
		if (isset($where)) $this->db->where($where);
		if (isset($data['tanggal_cari_awal'])) $this->db->where('date(batch_file_tgl_terbit) >= ', $data['tanggal_cari_awal']);
		if (isset($data['tanggal_cari_akhir'])) $this->db->where('date(batch_file_tgl_terbit) <= ', $data['tanggal_cari_akhir']);
		$this->db->order_by('batch_file_tgl_terbit desc,d.when_create desc');
		$sql = $this->db->get();
		return $sql->result_array();
	}

	public function getAset($data = null)
	{
		$this->db->select('*');
		$this->db->from('material.material_aset a');
		$this->db->join('material.material_aset_detail b', 'b.aset_id=a.aset_id', 'left');
		$this->db->join('sample.sample_peminta_jasa c', 'c.peminta_jasa_id = b.peminta_jasa_id', 'left');
		$sql = $this->db->get();
		return $sql->result_array();
	}
	// history card aset detail
	public function getAsetDetail($data = null)
	{
		$this->db->select("to_char(aset_perbaikan_tgl_penyerahan,'DD-MM-YYYY') as tgl_penyerahan,to_char(aset_perbaikan_tgl_deadline,'DD-MM-YYYY') as tgl_deadline,to_char(aset_perbaikan_tgl_selesai,'DD-MM-YYYY') as tgl_selesai,a.aset_detail_id,a.aset_nomor,c.peminta_jasa_nama,b.aset_perbaikan_tgl_penyerahan,aset_perbaikan_tgl_deadline,aset_perbaikan_tgl_selesai,aset_detail_merk,sample_pekerjaan_nama,c.peminta_jasa_id,aset_perbaikan_id,a.aset_id,pekerjaan_id,is_jadwal,aset_perbaikan_status");
		$this->db->from('material.material_aset_detail a');
		$this->db->join('material.material_aset_perbaikan b', 'b.aset_detail_id = a.aset_detail_id', 'left');
		$this->db->join('sample.sample_peminta_jasa c', 'c.peminta_jasa_id = b.peminta_id', 'left');
		$this->db->join('sample.sample_pekerjaan d', 'd.sample_pekerjaan_id = b.pekerjaan_id', 'left');
		$this->db->join('material.material_aset e', 'e.aset_id=a.aset_id', 'left');
		// $this->db->join('global.global_user e','e.user_id=c.id_user','left');
		if (isset($data['aset_nomor'])) $this->db->where("upper(aset_nomor) LIKE '%" . strtoupper($data['aset_nomor']) . "%'");
		if (isset($data['aset_id'])) $this->db->where('a.aset_id', $data['aset_id']);
		if (isset($data['aset_detail_id'])) $this->db->where('a.aset_detail_id', $data['aset_detail_id']);
		$this->db->where('is_aktif', 'y');
		$this->db->order_by('aset_perbaikan_tgl_penyerahan', 'desc');
		$this->db->order_by('b.when_create', 'desc');
		$sql = $this->db->get();
		return $sql->result_array();

		// return (isset($data['aset_detail_id'])) ? $sql->row_array() : $sql->result_array();
	}

	// history card aset detail

	// histoty card aset download

	public function getAsetDetailDownload($data = null)
	{
		$this->db->select('*');
		$this->db->from('material.material_aset_document');
		if (isset($data['aset_id'])) $this->db->where('aset_id', $data['aset_id']);
		if (isset($data['aset_document_id'])) $this->db->where('aset_document_id', $data['aset_document_id']);


		$sql = $this->db->get();
		return $sql->result_array();
	}

	// end history card asset download

	// aset history start

	public function getAsetDetailHistory($data = null)
	{
		$this->db->select("aset_perbaikan_tgl_penyerahan,
			case
			when aset_perbaikan_status!='' then 'Perbaikan'
			end as perbaikan_kegiatan,
			aset_perbaikan_note,
			case
			when aset_perbaikan_status='y' then 'Perbaikan Selesai'
			when aset_perbaikan_status='n' then 'Perbaikan Dalam Proses'
			end as perbaikan_kondisi,
			peminta_jasa_nama");
		$this->db->from('material.material_aset_perbaikan a');
		$this->db->join('material.material_aset_detail b', 'a.aset_detail_id = b.aset_detail_id', 'left');
		$this->db->join('sample.sample_peminta_jasa c', 'c.peminta_jasa_id = b.peminta_jasa_id');
		if (isset($data['aset_id'])) $this->db->where('aset_id', $data['aset_id']);
		if (isset($data['aset_document_id'])) $this->db->where('aset_document_id', $data['aset_document_id']);


		$sql = $this->db->get();
		return $sql->result_array();
	}

	// aset history end

	//start data report penghitungan
	public function getReportPerhitungan($data = null, $where = null)
	{
		// number_format($p->alber_kapasitas,1,",",".");
		$this->db->select("item_satuan , to_char(transaksi_waktu,'DD-MM-YYYY') as transaksi_waktu,seksi_nama,item_nama,transaksi_detail_jumlah , (item_harga)		, (transaksi_detail_total), transaksi_detail_total as transaksi_total");
		$this->db->from('material.material_transaksi_detail a');
		$this->db->join('material.material_transaksi b', 'a.transaksi_id = b.transaksi_id', 'left');
		$this->db->join('global.global_seksi c', 'b.id_gudang_tujuan = c.seksi_id');
		$this->db->join('material.material_item d', 'a.item_id = d.item_id');
		$this->db->where('transaksi_tipe=', 'o');
		$this->db->where('transaksi_status=', 'y');
		if (isset($where)) $this->db->where($where);
		if (isset($data['tanggal_cari_awal'])) $this->db->where('date(transaksi_waktu) >= ', $data['tanggal_cari_awal']);
		if (isset($data['tanggal_cari_akhir'])) $this->db->where('date(transaksi_waktu) <= ', $data['tanggal_cari_akhir']);
		if (isset($data['peminta_jasa_cari'])) $this->db->where('c.seksi_id', $data['peminta_jasa_cari']);
		if (isset($data['material_cari'])) $this->db->where('d.item_id', $data['material_cari']);
		// if (isset($data['tanggal_cari'])) $this->db->where('transaksi_waktu', $data['tanggal_cari']);
		$this->db->order_by('transaksi_waktu desc,seksi_nama asc, item_nama asc,b.when_create desc');

		$sql = $this->db->get();

		return $sql->result_array();
	}

	public function getKodeItem($data = null)
	{
		$this->db->select('jenis_kode,transaksi_detail_id');
		$this->db->from('material.material_item a');
		$this->db->join('material.material_transaksi_detail b', 'b.item_id = a.item_id', 'left');
		$this->db->join('material.material_jenis c', 'c.jenis_id=a.jenis_id', 'left');
		$this->db->where('b.transaksi_id', $data['transaksi_id']);
		$sql = $this->db->get();
		return $sql->result_array();
	}

	public function cekStok($data = null)
	{
		$this->db->select('*')->from('material.material_transaksi_detail')->where('transaksi_id=', $data['transaksi_id']);
		$sql = $this->db->get();
		return $sql->result_array();
	}

	public function cekDetailStok($data)
	{
		$cek = $this->db->select('*')->from('material.material_item')->where('item_id', $data['item_id'])->get()->row_array();
		if ($cek['item_stok'] < $data['transaksi_detail_jumlah']) {
			return  'Stok Item ' . $cek['item_nama'] . ' Tidak Mencukupi, Stok Tersedia ' . $cek['item_stok'];
			// }else{
			// return '';
		}
	}

	public function getSerialNumber($data = null)
	{
		return $this->db->select('aset_nomor_utama')->from('material.material_aset')->where('aset_id', $data['aset_id'])->get()->row_array();
	}

	public function getAsetImport($data = null)
	{
		$this->db->select('*');
		$this->db->from('material.material_aset a');
		$this->db->join('material.material_aset_detail b', 'b.aset_id=a.aset_id');
		$this->db->where('aset_nomor', $data['aset_nomor']);
		$this->db->where("aset_nama", $data['aset_nama']);
		$this->db->where("aset_nomor_utama", $data['aset_nomor_utama']);

		$sql = $this->db->get();
		return $sql->result_array();
	}

	/* GET IMPORT */
	public function getImport($data = null)
	{
		$this->db->select('*');
		$this->db->from('import.import_jadwal_perbaikan a')->join('material.material_aset_detail b', 'a.aset_detail_id=b.aset_detail_id', 'left')->join('material.material_aset c', 'c.aset_id=b.aset_id', 'left')->join('sample.sample_peminta_jasa d', 'd.peminta_jasa_id=a.peminta_id', 'left');
		if (isset($data['import_kode'])) $this->db->where('import_kode', $data['import_kode']);
		$sql = $this->db->get();
		return $sql->result_array();

		// return (isset($data['aset_id'])) ? $sql->row_array() : $sql->result_array();
	}
	/* GET IMPORT */

	/* INSERT IMPORT */
	public function insertImport()
	{
		$insert = $this->db->insert_batch('import.import_jadwal_perbaikan', $data);
		if ($insert) {
			return true;
		}
	}

	public function insertTable($data)
	{
		$this->db->query("INSERT INTO material.material_aset_perbaikan SELECT aset_perbaikan_id, aset_detail_id, aset_perbaikan_tgl_penyerahan,aset_perbaikan_tgl_selesai, aset_perbaikan_note, aset_perbaikan_status, null, when_create, who_create,pekerjaan_id,aset_perbaikan_vendor,peminta_id,null,aset_perbaikan_tgl_deadline,is_jadwal,id_user FROM import.import_jadwal_perbaikan WHERE import_kode = '" . $data['import_kode'] . "'");

		return $this->db->affected_rows();
	}
	/* INSERT IMPORT */

	/* DELETE TABLE */
	public function deleteTable($id)
	{
		$this->db->where('import_kode', $id);
		$this->db->delete('import.import_jadwal_perbaikan');

		return $this->db->affected_rows();
	}
	/* DELETE TABLE */

	public function updateJadwalSelesai($id, $data = null)
	{
		$this->db->set($data);
		$this->db->where('aset_perbaikan_id=', $id);
		$this->db->update('material.material_aset_perbaikan');

		return $this->db->affected_rows();
	}

	// aset movement
	public function getAsetMovement($data = null)
	{
		$this->db->select('*');
		$this->db->from('material.material_aset_perbaikan a');
		$this->db->join('sample.sample_peminta_jasa b', 'a.peminta_id = b.peminta_jasa_id', 'left');
		if (isset($data['aset_perbaikan_id'])) $this->db->where('aset_perbaikan_id', $data['aset_perbaikan_id']);
		$sql = $this->db->get();
		return ($data['aset_perbaikan_id']) ? $sql->row_array() : $sql->result_array();
	}
	// aset movement

	// update aset movement
	public function updateAsetMovement($id, $data = null)
	{
		$this->db->set($data);
		$this->db->where('aset_perbaikan_id', $id);
		$this->db->update('material.material_aset_perbaikan');

		return $this->db->affected_rows();
	}
	// update aset movement

	// insert aset movement
	public function insertAsetMovement($data = null)
	{
		$this->db->insert('material.material_aset_perbaikan_history', $data);
		return $this->db->affected_rows();
	}
	// insert aset movement

	public function getAsetHistory($data = null)
	{
		$this->db->select("to_char(aset_history_tgl_movement,'DD-MM-YYYY') as tgl_movement,peminta_jasa_nama,a.when_create,a.who_create");
		$this->db->from('material.material_aset_perbaikan_history a');
		$this->db->join('sample.sample_peminta_jasa b', 'b.peminta_jasa_id = a.peminta_jasa_id');
		if (isset($data['aset_perbaikan_id'])) $this->db->where('a.aset_perbaikan_id', $data['aset_perbaikan_id']);
		$this->db->order_by('a.aset_history_tgl_movement', 'desc');
		$this->db->order_by('a.when_create', 'desc');
		$sql = $this->db->get();

		return $sql->result_array();
	}
}
