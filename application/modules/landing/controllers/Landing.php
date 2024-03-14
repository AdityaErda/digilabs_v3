<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Landing extends MX_Controller {
  public function __construct() {
      parent::__construct();
      $this->load->model('M_landing');
  }

  public function index() {
    if ($this->input->post('transaksi_nomor')) {
        $param = htmlspecialchars($this->input->post('transaksi_nomor'), ENT_QUOTES, 'UTF-8');
        $data['dataSample'] = $this->M_multi_sample->getSampleDetail($param);
    }
    $data['data'] = $this->M_landing->getLanding();

    $this->load->view('landing/landing',$data);
  }
}

/* End of file Landing
.php */
