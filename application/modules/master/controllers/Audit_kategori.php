<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Audit_kategori extends MY_Controller
{


  public function __construct()
  {
    parent::__construct();
    // load model
    $this->load->model('master/M_audit_kategori');
  }


  public function index()
  {
    $isi['judul'] = 'Kategori Audit';
    $data = $this->session->userdata();
    $data['id_sidebar'] = $this->input->get('id_sidebar');
    $data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

    $this->load->view('tampilan/header', $isi);
    $this->load->view('tampilan/sidebar', $data);
    $this->load->view('master/audit_kategori');
    $this->load->view('tampilan/footer');
    $this->load->view('master/audit_kategori_js');
  }

  /* GET */
  public function getKategoriAudit()
  {
    $param = [];
    if ($this->input->get('audit_kategori_id')) {
      $param['audit_kategori_id'] = anti_inject_replace($this->input->get_post('audit_kategori_id'));
    }

    $data = $this->M_audit_kategori->getKategoriAudit($param);

    echo json_encode($data);
  }


  public function getAuditKategoriList()
  {
    $auditKategori['results'] = array();
    $param = [];
    if ($this->input->get('audit_kategori_nama')) {
      $param['audit_kategori_nama'] = anti_inject_replace($this->input->get('audit_kategori_nama'));
    }
    // sss
    foreach ($this->M_audit_kategori->getKategoriAudit($param) as $key => $value) {
      array_push($auditKategori['results'], [
        'id' => $value['audit_kategori_id'],
        'text' => $value['audit_kategori_nama'],
      ]);
    }
    echo json_encode($auditKategori);
  }
  /* GET */

  /* INSERT */
  public function insertKategoriAudit()
  {

    $isi = $this->session->userdata();

    $data['audit_kategori_id'] = create_id();
    $data['audit_kategori_nama'] = anti_inject($this->input->post('audit_kategori_nama'));
    $data['when_create'] = date('Y-m-d H:i:s');
    $data['who_create'] = $isi['user_nama_lengkap'];
    $this->M_audit_kategori->insertKategoriAudit($data);
  }
  /* INSERT */

  /* UPDATE */
  public function updateKategoriAudit()
  {
    $isi = $this->session->userdata();

    $id = anti_inject($this->input->post('audit_kategori_id'));
    $data = array(
      'audit_kategori_nama' => anti_inject($this->input->post('audit_kategori_nama')),
      'when_create' => date('Y-m-d H:i:s'),
      'who_create' => $isi['user_nama_lengkap'],
    );

    $this->M_audit_kategori->updateKategoriAudit($data, $id);
  }
  /* UPDATE */

  /* DELETE */
  public function deleteKategoriAudit()
  {
    $this->M_audit_kategori->deleteKategoriAudit($this->input->get('audit_kategori_id'));
  }
  /* DELETE */

  /* RESET */

  public function resetKategoriAudit()
  {
    $this->M_audit_kategori->resetKategoriAudit();
  }

  /* RESET */
}
