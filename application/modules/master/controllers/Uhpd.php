<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Uhpd extends MY_Controller{

	public function __construct(){
		parent::__construct();

		$this->load->model('master/M_uhpd');
	}

	/* INDEX */
	public function index(){
		$isi['judul'] = 'Biaya Tenaga Kerja';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');
		$data['data'] = $this->M_uhpd->getUhpd();

		$this->template->template_master('master/uhpd',$isi,$data);
	}
	/* INDEX */

	/* UPDATE */
	public function updateUhpd() {
		$isi = $this->session->userdata();

		$sql = $this->db->query("SELECT * FROM global.global_tenaga_kerja ORDER BY tenaga_kerja_jabatan ASC");
    $data = $sql->result_array();

		foreach ($data as $key => $value) {
			$id = $value['tenaga_kerja_id'];
      $data = array(
        'tenaga_kerja_uhpd' => $_POST['uhpd'][$value['tenaga_kerja_id']],
        'tenaga_kerja_honorarium' => $_POST['honor'][$value['tenaga_kerja_id']],
      );
			$this->M_uhpd->updateUhpd($data, $id);
		}
	}
	/* UPDATE */
}
