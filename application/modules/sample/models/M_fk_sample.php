<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_fk_sample extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
	}

	public function get($p='')
	{
		if(isset($p['transaksi_tipe'])) $this->db->where('transaksi_tipe',$p['transaksi_tipe']);
		if(isset($p['transaksi_status'])) $this->db->where('transaksi_status',$p['transaksi_status']);
		if(isset($p['transaksi_detail_status']) && $p['transaksi_detail_status']!='-') $this->db->where('transaksi_detail_status',$p['transaksi_detail_status']);

		$this->db->select('a.transaksi_tipe,a.transaksi_id,a.transaksi_status,b.transaksi_detail_id,transaksi_detail_status,is_proses');
		$this->db->from('sample.sample_transaksi a');
		$this->db->join('sample.sample_transaksi_detail b', 'b.transaksi_id = a.transaksi_id ', 'left');

		$this->db->order_by('transaksi_tipe', 'asc');
		$this->db->order_by('transaksi_status', 'asc');
		$this->db->order_by('transaksi_detail_status', 'asc');
		$this->db->order_by('transaksi_id', 'asc');
		$this->db->order_by('transaksi_detail_id', 'asc');

		if(isset($p['transaksi_tipe']) && $p['transaksi_tipe']=='R'){
			// $this->db->join('sample.sample_transaksi_rutin c', 'c.transaksi_rutin_id = a.id_transaksi_rutin', 'left');
		}
		$q=$this->db->get();
		return $q->result_array();

	}

}

/* End of file M_fk_sample.php */
/* Location: ./application/models/M_fk_sample.php */