<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Klasifikasi_sample extends MY_Controller
{


  public function __construct()
  {
    parent::__construct();
    // load model
    $this->load->model('master/M_klasifikasi_sample');
  }


  public function index()
  {
    $isi['judul'] = 'Klasifikasi Sample';
    $data = $this->session->userdata();
    $data['id_sidebar'] = $this->input->get('id_sidebar');
    $data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

    $this->load->view('tampilan/header', $isi);
    $this->load->view('tampilan/sidebar', $data);
    $this->load->view('master/klasifikasi_sample');
    $this->load->view('tampilan/footer');
    $this->load->view('master/klasifikasi_sample_js');
  }

  /* GET */
  public function getKlasifikasiSample()
  {
    $param = [];
    if ($this->input->get('klasifikasi_id')) {
      $param['klasifikasi_id'] = anti_inject_replace($this->input->get('klasifikasi_id'));
    }

    $data = $this->M_klasifikasi_sample->getKlasifikasiSample($param);

    echo json_encode($data);
  }

  public function getKlasifikasiSampleList()
  {
    $Klasifikasi['results'] = array();
    $param = [];
    if ($this->input->get('klasifikasi_nama')) {
      $param['klasifikasi_nama'] = anti_inject_replace($this->input->get('klasifikasi_nama'));
    }
    // sss
    foreach ($this->M_klasifikasi_sample->getKlasifikasiSample($param) as $key => $value) {
      array_push($Klasifikasi['results'], [
        'id' => $value['klasifikasi_id'],
        'text' => $value['klasifikasi_nama'] . ' - ' . $value['klasifikasi_kode'],
      ]);
    }
    echo json_encode($Klasifikasi);
  }

  /* GET */

  /* INSERT */
  public function insertKlasifikasiSample()
  {

    $isi = $this->session->userdata();

    $data['klasifikasi_id'] = create_id();
    $data['klasifikasi_kode'] = anti_inject($this->input->post('klasifikasi_kode'));
    $data['klasifikasi_nama'] = strtoupper(anti_inject($this->input->post('klasifikasi_nama')));
    $data['when_create'] = date('Y-m-d H:i:s');
    $data['who_create'] = $isi['user_nama_lengkap'];
    $this->M_klasifikasi_sample->insertKlasifikasiSample($data);
  }
  /* INSERT */

  /* UPDATE */
  public function updateKlasifikasiSample()
  {
    $isi = $this->session->userdata();

    $id = anti_inject($this->input->post('klasifikasi_id'));
    $data = array(
      'klasifikasi_kode' => anti_inject($this->input->post('klasifikasi_kode')),
      'klasifikasi_nama' => strtoupper(anti_inject($this->input->post('klasifikasi_nama'))),
      'when_create' => date('Y-m-d H:i:s'),
      'who_create' => $isi['user_nama_lengkap'],
    );

    $this->M_klasifikasi_sample->updateKlasifikasiSample($data, $id);
  }
  /* UPDATE */

  /* DELETE */
  public function deleteKlasifikasiSample()
  {
    $this->M_klasifikasi_sample->deleteKlasifikasiSample($this->input->get('klasifikasi_id'));
  }
  /* DELETE */

  /* RESET */

  public function resetKlasifikasiSample()
  {
    $this->M_klasifikasi_sample->resetKlasifikasiSample();
  }

  /* RESET */
}
