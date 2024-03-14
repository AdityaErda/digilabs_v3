<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Landing extends MX_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('M_landing');
    }

    public function index() {
        $sql = $this->db->query("SELECT * FROM landing.landing WHERE aktif = 'y' ORDER BY landing_urut ASC");
        $data['data'] = $sql->result_array();

        $this->load->view('landing/landing',$data);
    }
}

/* End of file Landing
.php */
