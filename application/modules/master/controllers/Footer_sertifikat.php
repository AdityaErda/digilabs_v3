<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Footer_sertifikat extends MY_Controller{

  public function __construct(){
    parent::__construct();

    $this->load->model('master/M_footer_sertifikat');
  }

  /* Index */
  public function index(){
    $isi['judul'] = 'Footer Sertifikat';
    $data = $this->session->userdata();
    $data['id_sidebar'] = $this->input->get('id_sidebar');
    $data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

    $this->template->template_master('master/footer_sertifikat',$isi,$data);
  }
  /* Index */

  /* Get */
  public function getFooterSertifikat($data = null){
    $param = array(
        'footer_id' => ($this->input->get_post('footer_id')),
    );
    $data = $this->M_footer_sertifikat->getFooterSertifikat($param);

    echo json_encode($data);
  }
  /* Get */

  /* Insert */
  public function insertFooterSertifikat(){
    $isi = $this->session->userdata();

    $data['footer_id'] = create_id();
    $data['footer_isi'] = anti_inject($this->input->post('footer_isi'));
    $data['when_create'] = date('Y-m-d H:i:s');
    $data['who_create'] = $isi['user_nama_lengkap'];
    $data['is_bahasa'] = anti_inject($this->input->post('is_bahasa'));

    $this->M_footer_sertifikat->insertFooterSertifikat($data);
  }
  /* Insert */

  /* Update */
  public function updateFooterSertifikat(){
    $isi = $this->session->userdata();

    $id = anti_inject($this->input->post('footer_id'));
    $data = array(
        'footer_isi' => anti_inject($this->input->get_post('footer_isi')),
        'when_create' => date('Y-m-d H:i:s'),
        'who_create' => $isi['user_nama_lengkap'],
        'is_bahasa' => anti_inject($this->input->get_post('is_bahasa')),
    );

    $this->M_footer_sertifikat->updateFooterSertifikat($data, $id);
  }
  /* Update */

  /* Delete */
  public function deleteFooterSertifikat(){
      $this->M_footer_sertifikat->deleteFooterSertifikat($this->input->get('footer_id'));
  }
  /* Delete */

  // SELECT 2
  public function getFooterSertifikatList(){
    $ListFooterSertifikat['results'] = array();
    $param['bahasa'] = anti_inject($this->input->get_post('bahasa'));
    $param['params_search'] = $this->input->get('params_search');
    foreach ($this->M_footer_sertifikat->getFooterSertifikat($param) as $key => $value) {
        // print_r($value);
        array_push($ListFooterSertifikat['results'], [
            'id' => $value['footer_id'],
            'text' => $value['footer_isi'],
        ]);
    }

    echo json_encode($ListFooterSertifikat);
  }
  // SELECT 2
}
