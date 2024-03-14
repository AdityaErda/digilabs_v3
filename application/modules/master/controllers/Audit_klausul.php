<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Audit_klausul extends MY_Controller
{


  public function __construct()
  {
    parent::__construct();
    // load model
    $this->load->model('master/M_audit_klausul');
  }


  public function index()
  {
    $isi['judul'] = 'Klausul Audit';
    $data = $this->session->userdata();
    $data['id_sidebar'] = $this->input->get('id_sidebar');
    $data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

    $this->load->view('tampilan/header', $isi);
    $this->load->view('tampilan/sidebar', $data);
    $this->load->view('master/audit_klausul');
    $this->load->view('tampilan/footer');
    $this->load->view('master/audit_klausul_js');
  }

  /* GET */
  public function getKlausulAudit()
  {
    $param = [];
    if ($this->input->get('audit_klausul_id')) {
      $param['audit_klausul_id'] = anti_inject_replace($this->input->get_post('audit_klausul_id'));
    }

    $data = $this->M_audit_klausul->getKlausulAudit($param);

    echo json_encode($data);
  }


  public function getAuditKlausulList()
  {
    $auditKlausul['results'] = array();
    $param = [];
    if ($this->input->get('audit_klausul_nama')) {
      $param['audit_klausul_nama'] = anti_inject_replace($this->input->get('audit_klausul_nama'));
    }
    // $param['audit_klausul_nama'] = $this->input->get('audit_klausul_nama');
    // sss
    foreach ($this->M_audit_klausul->getKlausulAudit($param) as $key => $value) {
      array_push($auditKlausul['results'], [
        'id' => $value['audit_klausul_id'],
        'text' => $value['audit_klausul_nama'] . ' - ' . $value['audit_klausul_keterangan'],
      ]);
    }
    echo json_encode($auditKlausul);
  }
  /* GET */

  /* INSERT */
  public function insertKlausulAudit()
  {

    $isi = $this->session->userdata();

    $data['audit_klausul_id'] = create_id();
    $data['audit_klausul_nama'] = anti_inject($this->input->post('audit_klausul_nama'));
    $data['audit_klausul_keterangan'] = anti_inject($this->input->post('audit_klausul_keterangan'));
    $data['when_create'] = date('Y-m-d H:i:s');
    $data['who_create'] = $isi['user_nama_lengkap'];
    $this->M_audit_klausul->insertKlausulAudit($data);
  }
  /* INSERT */

  /* UPDATE */
  public function updateKlausulAudit()
  {
    $isi = $this->session->userdata();

    $id = anti_inject($this->input->post('audit_klausul_id'));
    $data = array(
      'audit_klausul_nama' => anti_inject($this->input->post('audit_klausul_nama')),
      'audit_klausul_keterangan' => anti_inject($this->input->post('audit_klausul_keterangan')),
      'when_create' => date('Y-m-d H:i:s'),
      'who_create' => $isi['user_nama_lengkap'],
    );

    $this->M_audit_klausul->updateKlausulAudit($data, $id);
  }
  /* UPDATE */

  /* DELETE */
  public function deleteKlausulAudit()
  {
    $this->M_audit_klausul->deleteKlausulAudit($this->input->get('audit_klausul_id'));
  }
  /* DELETE */

  /* RESET */

  public function resetKlausulAudit()
  {
    $this->M_audit_klausul->resetKlausulAudit();
  }

  /* RESET */
}
