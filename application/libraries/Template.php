<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Template {
  protected $ci;

  public function __construct() {
    $this->ci = &get_instance();
  }

  public function template_master($konten, $isi = null, $data = null) {
    $field['header'] = $this->ci->load->view('tampilan/header', $isi);
    $field['sidebar'] = $this->ci->load->view('tampilan/sidebar', $data);
    $field['konten'] = $this->ci->load->view($konten, $data);
    $field['kontenjs'] = $this->ci->load->view($konten.'_js', $data);
    $field['footer'] = $this->ci->load->view('tampilan/footer');

    return $field;
  }
}