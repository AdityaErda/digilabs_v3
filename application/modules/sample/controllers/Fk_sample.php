<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Fk_sample extends MY_Controller
{


	public function __construct()
	{
		parent::__construct();
		$this->load->model('sample/M_fk_sample');
	}

	public function index()
	{
		$isi['judul'] = 'Inbox';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

		$p['transaksi_tipe'] = $this->input->get('transaksi_tipe');
		$p['transaksi_status'] = $this->input->get('transaksi_status');
		$p['transaksi_detail_status'] = $this->input->get('transaksi_detail_status');
		$v['sample'] = $this->M_fk_sample->get($p);
		$this->load->view('sample/fk_sample', $v, false);
	}

	public function fk()
	{

		$transaksi_tipe = $this->input->get('transaksi_tipe');
		$transaksi_status = $this->input->get('transaksi_status');
		$transaksi_detail_status = $this->input->get('transaksi_detail_status');

		$q = "SELECT * FROM sample.sample_transaksi a LEFT JOIN sample.sample_transaksi_detail b ON a.transaksi_id  = b.transaksi_id WHERE transaksi_tipe = '" . $transaksi_tipe . "'";

		if ($transaksi_status == '0') {
			$q .= " AND transaksi_status ='0'";
			$s = $this->db->query($q);
			$r = $s->result_array();
			foreach ($r as $v) {
				if ($v['transaksi_detail_status'] == $transaksi_status) {
					$this->db->query("UPDATE sample.sample_transaksi_detail SET transaksi_detail_status ='4' WHERE transaksi_detail_id = '" . $v['transaksi_detail_id'] . "'");
					echo "<pre>";
					print_r($this->db->last_query());
					echo "</pre>";
				}
				$this->db->query("UPDATE sample.sample_transaksi SET transaksi_status = '4' WHERE transaksi_id = '" . $v['transaksi_id'] . "'");
				echo "<pre>";
				print_r($this->db->last_query());
				echo "</pre>";
			}
		} else if ($transaksi_status == '1') {
			$q .= " AND transaksi_status ='1'";
			$s = $this->db->query($q);
			$r = $s->result_array();
			foreach ($r as $v) {
				if ($v['transaksi_detail_status'] == $transaksi_status) {
					$this->db->query("UPDATE sample.sample_transaksi_detail SET transaksi_detail_status ='5' WHERE transaksi_detail_id = '" . $v['transaksi_detail_id'] . "' AND transaksi_detail_status = '" . $transaksi_status . "'");
					echo "<pre>";
					print_r($this->db->last_query());
					echo "</pre>";
				} else {
					$this->db->query("UPDATE sample.sample_transaksi_detail SET is_proses ='y' WHERE transaksi_detail_id = '" . $v['transaksi_detail_id'] . "' AND transaksi_detail_status != '" . $transaksi_status . "'");
					echo "<pre>";
					print_r($this->db->last_query());
					echo '</pre>';
				}
				$this->db->query("UPDATE sample.sample_transaksi SET transaksi_status = '5' WHERE transaksi_id = '" . $v['transaksi_id'] . "'");
				echo "<pre>";
				print_r($this->db->last_query());
				echo "</pre>";
			}
		} else if ($transaksi_status == '2') {
			$q .= " AND transaksi_status ='2'";
			$s = $this->db->query($q);
			$r = $s->result_array();
			foreach ($r as $v) {
				if ($v['transaksi_detail_status'] == $transaksi_status) {
					$this->db->query("UPDATE sample.sample_transaksi_detail SET transaksi_detail_status ='6' WHERE transaksi_detail_id = '" . $v['transaksi_detail_id'] . "' AND transaksi_detail_status = '" . $transaksi_status . "'");
					echo "<pre>";
					print_r($this->db->last_query());
					echo "</pre>";
				} else {
					$this->db->query("UPDATE sample.sample_transaksi_detail SET is_proses ='y' WHERE transaksi_detail_id = '" . $v['transaksi_detail_id'] . "' AND transaksi_detail_status != '" . $transaksi_status . "'");
					echo "<pre>";
					print_r($this->db->last_query());
					echo '</pre>';
				}
				$this->db->query("UPDATE sample.sample_transaksi SET transaksi_status = '6' WHERE transaksi_id = '" . $v['transaksi_id'] . "'");
				echo "<pre>";
				print_r($this->db->last_query());
				echo "</pre>";
			}
		} else if ($transaksi_status == '3') {
			$q .= " AND transaksi_status ='" . $transaksi_status . "'";
			if($transaksi_detail_status != '-'){
				$q .= "AND transaksi_detail_status = '".$transaksi_detail_status."'";
			}
			$s = $this->db->query($q);
			$r = $s->result_array();
			foreach ($r as $v) {
				if ($v['transaksi_detail_status'] == $transaksi_status) {
					$this->db->query("UPDATE sample.sample_transaksi_detail SET transaksi_detail_status ='7' WHERE transaksi_detail_id = '" . $v['transaksi_detail_id'] . "' AND transaksi_detail_status = '" . $transaksi_status . "'");
					echo "<pre>";
					print_r($this->db->last_query());
					echo "</pre>";
				} else {
					$this->db->query("UPDATE sample.sample_transaksi_detail SET is_proses ='y' WHERE transaksi_detail_id = '" . $v['transaksi_detail_id'] . "' AND transaksi_detail_status != '" . $transaksi_status . "'");
					echo "<pre>";
					print_r($this->db->last_query());
					echo '</pre>';
				}
				$this->db->query("UPDATE sample.sample_transaksi SET transaksi_status = '6' WHERE transaksi_id = '" . $v['transaksi_id'] . "'");
				echo "<pre>";
				print_r($this->db->last_query());
				echo "</pre>";
			}
		} else if ($transaksi_status == '4') {
			$q .= " AND transaksi_status ='" . $transaksi_status . "'";
			if($transaksi_detail_status != '-'){
				$q .= "AND transaksi_detail_status = '".$transaksi_detail_status."'";
			}
			$s = $this->db->query($q);
			$r = $s->result_array();
			foreach ($r as $v) {
				if ($v['transaksi_detail_status'] == $transaksi_status) {
					$this->db->query("UPDATE sample.sample_transaksi_detail SET transaksi_detail_status ='8' WHERE transaksi_detail_id = '" . $v['transaksi_detail_id'] . "' AND transaksi_detail_status = '" . $transaksi_status . "'");
					echo "<pre>";
					print_r($this->db->last_query());
					echo "</pre>";
				} else {
					$this->db->query("UPDATE sample.sample_transaksi_detail SET is_proses ='y' WHERE transaksi_detail_id = '" . $v['transaksi_detail_id'] . "' AND transaksi_detail_status != '" . $transaksi_status . "'");
					echo "<pre>";
					print_r($this->db->last_query());
					echo '</pre>';
				}
				$this->db->query("UPDATE sample.sample_transaksi SET transaksi_status = '6' WHERE transaksi_id = '" . $v['transaksi_id'] . "'");
				echo "<pre>";
				print_r($this->db->last_query());
				echo "</pre>";
			}
		} else if ($transaksi_status == '5') {
			$q .= " AND transaksi_status ='" . $transaksi_status . "'";
			$s = $this->db->query($q);
			$r = $s->result_array();
			foreach ($r as $v) {
				if ($v['transaksi_detail_status'] == $transaksi_status) {
					$this->db->query("UPDATE sample.sample_transaksi_detail SET transaksi_detail_status ='17' WHERE transaksi_detail_id = '" . $v['transaksi_detail_id'] . "' AND transaksi_detail_status != '" . $transaksi_status . "'");
					echo "<pre>";
					print_r($this->db->last_query());
					echo "</pre>";
				} else {
					$this->db->query("UPDATE sample.sample_transaksi_detail SET is_proses ='y' WHERE transaksi_detail_id = '" . $v['transaksi_detail_id'] . "' AND transaksi_detail_status != '" . $transaksi_status . "'");
					echo "<pre>";
					print_r($this->db->last_query());
					echo '</pre>';
				}
				$this->db->query("UPDATE sample.sample_transaksi SET transaksi_status = '6' WHERE transaksi_id = '" . $v['transaksi_id'] . "'");
				echo "<pre>";
				print_r($this->db->last_query());
				echo "</pre>";
			}
		} else if ($transaksi_status == '6') {
			$q .= " AND transaksi_status ='" . $transaksi_status . "'";
			$s = $this->db->query($q);
			$r = $s->result_array();
			foreach ($r as $v) {
				if ($v['transaksi_detail_status'] == $transaksi_status) {
					$this->db->query("UPDATE sample.sample_transaksi_detail SET transaksi_detail_status ='18' WHERE transaksi_detail_id = '" . $v['transaksi_detail_id'] . "' AND transaksi_detail_status = '" . $transaksi_status . "'");
					echo "<pre>";
					print_r($this->db->last_query());
					echo "</pre>";
				} else {
					$this->db->query("UPDATE sample.sample_transaksi_detail SET is_proses ='y' WHERE transaksi_detail_id = '" . $v['transaksi_detail_id'] . "' AND transaksi_detail_status != '" . $transaksi_status . "'");
					echo "<pre>";
					print_r($this->db->last_query());
					echo '</pre>';
				}
				$this->db->query("UPDATE sample.sample_transaksi SET transaksi_status = '6' WHERE transaksi_id = '" . $v['transaksi_id'] . "'");
				echo "<pre>";
				print_r($this->db->last_query());
				echo "</pre>";
			}
		} else if ($transaksi_status == '7') {
		} else if ($transaksi_status == '8') {
			$q .= " AND transaksi_status ='" . $transaksi_status . "'";
			$s = $this->db->query($q);
			$r = $s->result_array();
			foreach ($r as $v) {
				if ($v['transaksi_detail_status'] == $transaksi_status) {
					$this->db->query("UPDATE sample.sample_transaksi_detail SET transaksi_detail_status ='15' WHERE transaksi_detail_id = '" . $v['transaksi_detail_id'] . "' AND transaksi_detail_status = '" . $transaksi_status . "'");
					echo "<pre>";
					print_r($this->db->last_query());
					echo "</pre>";
				} else {
					$this->db->query("UPDATE sample.sample_transaksi_detail SET is_proses ='y' WHERE transaksi_detail_id = '" . $v['transaksi_detail_id'] . "' AND transaksi_detail_status != '" . $transaksi_status . "'");
					echo "<pre>";
					print_r($this->db->last_query());
					echo '</pre>';
				}
				$this->db->query("UPDATE sample.sample_transaksi SET transaksi_status = '6' WHERE transaksi_id = '" . $v['transaksi_id'] . "'");
				echo "<pre>";
				print_r($this->db->last_query());
				echo "</pre>";
			}
		}
	}
}

/* End of file Fk_sample.php */
/* Location: ./application/modules/sample/controllers/Fk_sample.php */