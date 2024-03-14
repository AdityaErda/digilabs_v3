<?php


defined('BASEPATH') or exit('No direct script access allowed');

class cara_close extends MY_Controller
{


  public function __construct()
  {
    parent::__construct();
    // load model
    $this->load->model('master/M_cara_close');
  }


  public function index()
  {
    $isi['judul'] = 'Cara Close';
    $data = $this->session->userdata();
    $data['id_sidebar'] = $this->input->get('id_sidebar');
    $data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

    $this->load->view('tampilan/header', $isi);
    $this->load->view('tampilan/sidebar', $data);
    $this->load->view('master/cara_close');
    $this->load->view('tampilan/footer');
    $this->load->view('master/cara_close_js');
  }

  /* GET */
  public function getCaraClose()
  {
    $param = array(
      'cara_close_id' => $this->input->get_post('cara_close_id'),
    );

    $data = $this->M_cara_close->getCaraClose($param);

    echo json_encode($data);
  }

  public function getCaraCloseList()
  {
    $cara_close['results'] = array();
    $param['cara_close_nama'] = $this->input->get('cara_close_nama');
    $param['multiple'] = $this->input->get('multiple');
    $param['tipe'] = $this->input->get_post('tipe');

    // $query = $this->M_cara_close->getCaraClose($param);
    // echo $this->db->last_query();

    foreach ($this->M_cara_close->getCaraClose($param) as $key => $value) {
      array_push($cara_close['results'], [
        'id' => $value['cara_close_id'],
        'text' => $value['cara_close_nama'],
      ]);
    }
    echo json_encode($cara_close);
  }

  /* GET */

  /* INSERT */
  public function insertCaraClose()
  {

    $isi = $this->session->userdata();

    $data['cara_close_id'] = create_id();
    $data['cara_close_kode'] = $this->input->post('cara_close_kode');
    $data['cara_close_nama'] = strtoupper($this->input->post('cara_close_nama'));
    $data['when_create'] = date('Y-m-d H:i:s');
    $data['who_create'] = $isi['user_nama_lengkap'];
    $this->M_cara_close->insertCaraClose($data);
  }
  /* INSERT */

  /* UPDATE */
  public function updateCaraClose()
  {
    $isi = $this->session->userdata();

    $id = $this->input->post('cara_close_id');
    $data = array(
      'cara_close_kode' => $this->input->post('cara_close_kode'),
      'cara_close_nama' => strtoupper($this->input->post('cara_close_nama')),
      'when_create' => date('Y-m-d H:i:s'),
      'who_create' => $isi['user_nama_lengkap'],
    );

    $this->M_cara_close->updateCaraClose($data, $id);
  }
  /* UPDATE */

  /* DELETE */
  public function deleteCaraClose()
  {
    $this->M_cara_close->deleteCaraClose($this->input->get('cara_close_id'));
  }
  /* DELETE */

  /* RESET */

  public function resetCaraClose()
  {
    $this->M_cara_close->resetCaraClose();
  }

  /* RESET */
}
