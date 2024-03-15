<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dokumen_tipe extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();
    //Do your magic here
    islogin();
    $this->load->model('M_departemen');
  }

  public function index()
  {
    $isi['judul'] = 'Departemen';
    $data = $this->session->userdata();
    $data['id_sidebar'] = $this->input->get('id_sidebar');
    $data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');
    $data['kategori'] = $this->input->get('kategori');

    $this->load->view('tampilan/header', $isi);
    $this->load->view('tampilan/sidebar', $data);
    // $this->load->view('api/dokumen_tipe');
    $this->load->view('tampilan/footer');
    // $this->load->view('api/dokumen_tipe_js');
  }


  public function getDokumenTipe()
  {
    $sesi = $this->session->userdata();
    // generate token
    $dep = $this->input->get_post('departemen_id');
    $api_key = "6BF86150-729F-410B-9871-D3F06CA05B7E";

    // $paramLetterUser'] =

    // $dofLetterUser = $this->M_Letter_user->getDofLetterUser();

    // nanti generate berdarkan loginnya
    $token = $this->session->userdata('access_token');

    $url = 'https://dof.petrokimia-gresik.com/api/DocTypes';
    $options = array('http' => array(
      'method'  => 'GET',
      'header' => 'Authorization: Bearer ' . $token
    ));
    $context  = stream_context_create($options);
    $response = file_get_contents($url, false, $context);


    if (json_decode($response, true)) {
      $data = json_decode($response, true);
      for ($i = 0; $i < count($data); $i++) {
        $datas[$i] = array(
          'departemen_kode' => $data[$i]['depCode'],
          'departemen_id' => $data[$i]['idDep'],
          'departemen_nama' => $data[$i]['namaDep'],
          'departemen_komp_id' => $data[$i]['idKomp'],
          'departemen_komp_nama' => $data[$i]['namaKomp'],
          'status' => 'success',
        );

        // checking
        $query = $this->db->get_where('global.global_api_departemen', array('departemen_id' => $data[$i]['idDep']))->num_rows();
        if ($query == 0) {
          $param['departemen_kode'] = $data[$i]['depCode'];
          $param['departemen_id'] = $data[$i]['idDep'];
          $param['departemen_nama'] = $data[$i]['namaDep'];
          $param['departemen_komp_id'] = $data[$i]['idKomp'];
          $param['departemen_nama_komp'] = $data[$i]['namaKomp'];

          // $this->db->insert('global.global_api_departemen', $param);
        } else {
          $id = $data[$i]['idDep'];
          $param['departemen_kode'] = $data[$i]['depCode'];
          $param['departemen_nama'] = $data[$i]['namaDep'];
          $param['departemen_komp_id'] = $data[$i]['idKomp'];
          $param['departemen_nama_komp'] = $data[$i]['namaKomp'];

          // $this->db->where('departemen_id', $id);
          // $this->db->update('global.global_api_departemen', $param);
        }
      }
    } else {
      $datas[0] = array(
        'status' => 'fail',
      );
    }
    echo json_encode($datas);
  }

  public function getDepartemenList()
  {
    $departemen['results'] = array();
    $param['param_search'] = $this->input->get('param_search');
    // sss
    foreach ($this->M_departemen->getDepartemen($param) as $key => $value) {
      array_push($departemen['results'], [
        'id' => $value['departemen_id'],
        'text' => $value['departemen_nama'],
      ]);
    }
    echo json_encode($departemen);
  }
}

/* End of file Departemen.php */
