<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Landing extends MX_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('M_landing');
    }

    public function index() {
        if ($this->input->post('transaksi_nomor')) {
            $result = htmlspecialchars($this->input->post('transaksi_nomor'), ENT_QUOTES, 'UTF-8');
            $data['dataSample'] = $this->db->query("SELECT * FROM sample.sample_transaksi a LEFT JOIN sample.sample_transaksi_detail b ON a.transaksi_id = b.transaksi_id LEFT JOIN sample.sample_peminta_jasa d ON d.peminta_jasa_id = b.peminta_jasa_id LEFT JOIN sample.sample_jenis q ON q.jenis_id = b.jenis_id WHERE UPPER(transaksi_nomor) LIKE '%" . strtoupper($result) . "%' AND (is_proses != 'y' OR is_proses is NULL) ORDER BY a.transaksi_nomor ASC")->result_array();
        }
        $data['data'] = $this->db->query("SELECT * FROM landing.landing WHERE aktif = 'y' ORDER BY landing_urut ASC")->result_array();

        $this->load->view('landing/landing',$data);
    }
}

/* End of file Landing
.php */
