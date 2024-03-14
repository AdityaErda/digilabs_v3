<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Template extends MY_Controller
{
  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    $isi['judul'] = 'Template Sample';
    $data = $this->session->userdata();
    $data['id_sidebar'] = $this->input->get('id_sidebar');
    $data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

    $this->load->view('tampilan/header', $isi);
    $this->load->view('tampilan/sidebar', $data);
    $this->load->view('master/stok');
    $this->load->view('tampilan/footer');
    $this->load->view('master/stok_js');
  }
}
