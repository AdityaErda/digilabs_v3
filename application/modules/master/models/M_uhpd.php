<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_uhpd extends CI_Model {
	/* UPDATE */
		public function updateUhpd($data, $id) {
			$this->db->set($data);
			$this->db->where('tenaga_kerja_id', $id);
			$this->db->update('global.global_tenaga_kerja');

			return $this->db->affected_rows();
		}
	/* UPDATE */
}
