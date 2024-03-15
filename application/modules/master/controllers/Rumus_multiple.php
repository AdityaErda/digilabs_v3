<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rumus_multiple extends MY_Controller{

  public function __construct(){
    parent::__construct();

    $this->load->model('master/M_rumus_multiple');
  }

  /* INDEX */
  public function index(){
    $isi['judul'] = 'Perhitungan Sample Rutin';
    $data = $this->session->userdata();
    $data['id_sidebar'] = $this->input->get('id_sidebar');
    $data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

    $this->template->template_master('master/rumus_multiple',$isi,$data);
  }

  public function index_import(){
    $isi['judul'] = 'Import Perhitungan Sample Rutin';
    $data = $this->session->userdata();
    $data['id_sidebar'] = $this->input->get('id_sidebar');
    $data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

    $this->template->template_master('master/rumus_multiple_import',$isi,$data);
  }

  public function index_import_detail(){
    $isi['judul'] = 'Import Parameter Rumus';
    $data = $this->session->userdata();
    $data['id_sidebar'] = $this->input->get('id_sidebar');
    $data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

    $this->template->template_master('master/rumus_multiple_parameter_import',$isi,$data);
  }

  public function index_import_detail_detail(){
    $isi['judul'] = 'Import Detail Parameter';
    $data = $this->session->userdata();
    $data['id_sidebar'] = $this->input->get('id_sidebar');
    $data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

    $this->load->view('tampilan/header', $isi);
    $this->load->view('tampilan/sidebar', $data);
    $this->load->view('master/rumus_multiple_detail_parameter_import');
    $this->load->view('tampilan/footer');
    $this->load->view('master/rumus_multiple_detail_parameter_import_js');
  }
  /* INDEX */

  /* GET */
  public function getRumusMultiple(){
    $param = [];
    if ($this->input->get_post('multiple_rumus_id')) {
      $param['multiple_rumus_id'] = anti_inject_replace($this->input->get_post('multiple_rumus_id'));
    }
    $data = $this->M_rumus_multiple->getRumusMultiple($param);
    echo json_encode($data);
  }

  public function getJenisSample(){
    $listJenis['results'] = array();
    $param = [];
    if ($this->input->get_post('jenis_nama')) {
      $param['jenis_nama'] = anti_inject_replace($this->input->get('jenis_nama'));
    }
    foreach ($this->M_rumus_multiple->getJenisSample($param) as $key => $value) {
      array_push($listJenis['results'], [
        'id' => $value['jenis_id'],
        'text' => $value['jenis_nama'],
      ]);
    }
    echo json_encode($listJenis);
  }
  /* GET */

  /* Insert */
  public function insertRumusMultiple(){
    $isi = $this->session->userdata();

    $data['multiple_rumus_id'] = create_id();
    $data['jenis_id'] = anti_inject($this->input->get_post('jenis_id'));
    $data['metode'] = anti_inject($this->input->get_post('metode'));
    $data['when_create'] = date('Y-m-d H:i:s');
    $data['who_create'] = $isi['user_nama_lengkap'];

    $this->M_rumus_multiple->insertRumusMultiple($data);
  }
  /* Insert */

  /* Update */
  public function updateRumusMultiple(){
    $isi = $this->session->userdata();

    $id = anti_inject($this->input->post('multiple_rumus_id'));
    $data = array(
      'jenis_id' => anti_inject($this->input->get_post('jenis_id')),
      'metode' => anti_inject($this->input->get_post('metode')),
      'when_create' => date('Y-m-d H:i:s'),
      'who_create' => $isi['user_nama_lengkap'],
    );

    $this->M_rumus_multiple->updateRumusMultiple($data, $id);
  }
  /* Update */

  /* Delete */
  public function deleteRumusMultiple(){
    $this->M_rumus_multiple->deleteRumusMultiple($this->input->get('multiple_rumus_id'));
  }
  /* Delete */

  /* Get Parameter & Detail Paramater */
  public function getDetailRumusMultiple(){
    $param = array();

    if ($this->input->get('id_multiple_rumus')) $param['id_multiple_rumus'] = $this->input->get('id_multiple_rumus');
    if ($this->input->get('detail_multiple_rumus_id')) $param['detail_multiple_rumus_id'] = $this->input->get('detail_multiple_rumus_id');
    if ($this->input->post('parameter_rumus')) $param['parameter_rumus'] = anti_inject($this->input->post('parameter_rumus'));

    $data = $this->M_rumus_multiple->getDetailRumusMultiple($param);

    echo json_encode($data);
  }

  public function getListRumus(){
    $rumus['rumus_detail_input'] = $this->input->get('rumus_detail_input');
    $param['id_parameter'] = $this->input->get('id_parameter');
    $param['detail_parameter_rumus_id'] = $this->input->get('detail_parameter_rumus_id');
    $data = $this->M_rumus_multiple->getListRumus($param);

    foreach ($data as $key => $value) {
      $rumus[] = ($value['detail_parameter_rumus'] != null) ? $value['detail_parameter_rumus'] : $value['rumus_detail_input'];
    }

    $hasil[]['rumus'] = implode(' ', $rumus);
    echo json_encode($hasil);
  }

  public function getUrutanRumus($value = ''){
    $select = "*";
    $where = array('rumus_detail_urut' => $this->input->get('rumus_detail_urut'), 'id_parameter' => $this->input->get('detail_multiple_rumus_id'));
    $data = $this->M_rumus_multiple->getUrutanRumus($select, $where, null, null, null)->row();
    if (!empty($data)) {
      $error['field_name'] = 'rumus_detail_urut';
      $error['msg'] = "Urutan Template Sudah Ada !!";

      echo json_encode($error);
    }
  }

  public function getParameterRumus(){
    $param['id_parameter'] = anti_inject($this->input->get_post('id_parameter'));
    $param['detail_parameter_rumus_id'] = anti_inject($this->input->get_post('detail_parameter_rumus_id'));

    $data = $this->M_rumus_multiple->getParameterRumus($param);
    // echo $this->db->last_query();

    echo json_encode($data);
  }

  public function getMaksUrut(){
    $data = $this->db->query("SELECT MAX(CAST(rumus_detail_urut AS INT)) as terakhir FROM sample.sample_parameter_rumus WHERE id_parameter = '" . $this->input->get_post('id_parameter') . "'")->row_array();
    $datanya['last'] = $data['terakhir'] + 1;
    echo json_encode($datanya);
  }
  /*Get Parameter & Detail Paramater */

  /* Insert Parameter & Detail Paramater */
  public function insertRumusMultipleDetail(){
    $isi = $this->session->userdata();

    $data['detail_multiple_rumus_id'] = create_id();
    $data['id_multiple_rumus'] = anti_inject($this->input->post('temp_multiple_rumus_id'));
    $data['parameter_rumus'] = anti_inject($this->input->post('parameter_rumus'));
    $data['satuan_parameter'] = anti_inject($this->input->post('satuan_parameter'));
    $data['when_create'] = date('Y-m-d H:i:s');
    $data['who_create'] = $isi['user_nama_lengkap'];

    $this->M_rumus_multiple->insertRumusMultipleDetail($data);
  }

  public function insertDetailParameter(){
    $isi = $this->session->userdata();

    $rumus_detail_input = ($this->input->post('rumus_detail_input') != FALSE) ? anti_inject($this->input->post('rumus_detail_input')) : NULL;
    $rumus_detail_template = ($this->input->post('rumus_detail_template') != FALSE) ? anti_inject($this->input->post('rumus_detail_template')) : NULL;
    $rumus_detail_urut = ($this->input->post('rumus_detail_urut') != FALSE) ? anti_inject($this->input->post('rumus_detail_urut')) : NULL;

    $data['detail_parameter_rumus_id'] = create_id();
    $data['id_parameter'] = anti_inject($this->input->post('id_detail_parameter_rumus'));
    $data['rumus_detail_urut'] = $rumus_detail_urut;
    $data['detail_parameter_rumus'] = anti_inject($this->input->post('detail_parameter_rumus'));
    $data['rumus_detail_input'] = $rumus_detail_input;
    $data['rumus_jenis'] = anti_inject($this->input->post('rumus_jenis'));
    $data['rumus_detail_template'] = $rumus_detail_template;
    $data['when_create'] = date('Y-m-d H:i:s');
    $data['who_create'] = $isi['user_nama_lengkap'];

    $this->M_rumus_multiple->insertDetailParameter($data);
  }
  /* Insert Parameter & Detail Paramater */

  /* Update Parameter & Detail Paramater */
  public function updateRumusMultipleDetail(){
    $isi = $this->session->userdata();

    $id = anti_inject($this->input->post('detail_multiple_rumus_id'));
    $data = array(
      'id_multiple_rumus' => anti_inject($this->input->post('temp_multiple_rumus_id')),
      'parameter_rumus' => anti_inject($this->input->post('parameter_rumus')),
      'satuan_parameter' => anti_inject($this->input->post('satuan_parameter')),
      'when_create' => date('Y-m-d H:i:s'),
      'who_create' => $isi['user_nama_lengkap'],
    );

    $this->M_rumus_multiple->updateRumusMultipleDetail($data, $id);
  }

  public function updateDetailParameter(){
    $isi = $this->session->userdata();

    $rumus_detail_template = ($this->input->post('rumus_detail_template') != FALSE) ? anti_inject($this->input->post('rumus_detail_template')) : NULL;
    $rumus_detail_input = ($this->input->post('rumus_detail_input') != FALSE) ? anti_inject($this->input->post('rumus_detail_input')) : NULL;

    $id = anti_inject($this->input->post('detail_parameter_rumus_id'));
    $data = array(
      'id_parameter' => anti_inject($this->input->post('id_detail_parameter_rumus')),
      'rumus_detail_urut' => anti_inject($this->input->post('rumus_detail_urut')),
      'detail_parameter_rumus' => anti_inject($this->input->post('detail_parameter_rumus')),
      'rumus_detail_input' => $rumus_detail_input,
      'rumus_jenis' => anti_inject($this->input->post('rumus_jenis')),
      'rumus_detail_template' => $rumus_detail_template,
      'when_create' => date('Y-m-d H:i:s'),
      'who_create' => $isi['user_nama_lengkap'],
    );

    $this->M_rumus_multiple->updateDetailParameter($data, $id);
  }
  /* Update Parameter & Detail Paramater */

  /* Delete Parameter & Detail Paramater */
  public function deleteRumusMultipleDetail(){
    $this->M_rumus_multiple->deleteRumusMultipleDetail($this->input->get('detail_multiple_rumus_id'));
  }

  public function deleteDetailParameter(){
    $this->M_rumus_multiple->deleteDetailParameter($this->input->get('detail_parameter_rumus_id'));
  }
  /* Delete Parameter & Detail Paramater */

  /* Get Import */
  public function getImport(){
    $param['import_kode'] = $this->input->get('import_kode');

    $data = $this->M_rumus_multiple->getImport($param);

    echo json_encode($data);
  }

  public function getImportParameter(){
    $param['import_kode'] = $this->input->get('import_kode');

    $data = $this->M_rumus_multiple->getImportParameter($param);

    echo json_encode($data);
  }

  public function getImportDetailParameter(){
    $param['import_kode'] = $this->input->get('import_kode');

    $data = $this->M_rumus_multiple->getImportDetailParameter($param);

    echo json_encode($data);
  }
  /* Get Import */

  /* Insert Import */
  public function insertImport(){
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    $data_session = $this->session->userdata();

    $config = array(
      'upload_path'   => FCPATH . '/upload/',
      'allowed_types' => 'xls|csv'
    );

    $this->upload->initialize($config);

    if ($this->upload->do_upload('file_import')) {
      $data = $this->upload->data();
      @chmod($data['full_path'], 0777);

      $this->load->library('Spreadsheet_Excel_Reader');
      $this->spreadsheet_excel_reader->setOutputEncoding('CP1251');
      $this->db->db_set_charset('latin1', 'latin1_swedish_ci');

      $this->spreadsheet_excel_reader->read($data['full_path']);
      $sheets = $this->spreadsheet_excel_reader->sheets[0];


      $data_excel = array();
      $id = create_id();
      for ($i = 2; $i <= $sheets['numRows']; $i++) {
        if ($sheets['cells'][$i][1] == '') break;

        $param_pekerjaan['jenis_nama'] = $sheets['cells'][$i][1];
        $isiPekerjaan = $this->M_rumus_multiple->getJenisSample($param_pekerjaan);

        $data_excel[$i - 1]['import_kode']    = $id;
        $data_excel[$i - 1]['multiple_rumus_id']    = create_id();
        $data_excel[$i - 1]['jenis_id'] = $isiPekerjaan[0]['jenis_id'];
        $data_excel[$i - 1]['metode']  = $sheets['cells'][$i][2];
        $data_excel[$i - 1]['when_create']  = date('Y-m-d H:i:s');
        $data_excel[$i - 1]['who_create']  = $data_session['user_nama_lengkap'];
      }

      $this->db->insert_batch('import.import_sample_perhitungan_multiple', $data_excel);

      header("Location: " . base_url('master/rumus_multiple/index_import?header_menu=0&menu_id=0&import_kode=' . $id));
    } else {
      $error = $this->upload->display_errors();
      print_r($error);
    }
  }

  public function insertTable(){
    $param['import_kode'] = $this->input->get('import_kode');
    $this->M_rumus_multiple->insertTable($param);
    $this->M_rumus_multiple->deleteTable($this->input->get('import_kode'));

    header("Location: " . base_url('master/rumus_multiple/index?header_menu=0&menu_id=0'));
  }
  /* Insert Import */

  /* Insert Import Paramater */
  public function insertImportParameter(){
    ini_set('display_errors', 1);
    // error_reporting(E_ALL);
    error_reporting(0);
    $data_session = $this->session->userdata();
    $config = array(
      'upload_path'   => FCPATH . '/upload/',
      'allowed_types' => 'xls|csv'
    );

    $this->upload->initialize($config);

    if ($this->upload->do_upload('file_import')) {
      $data = $this->upload->data();
      @chmod($data['full_path'], 0777);

      $this->load->library('Spreadsheet_Excel_Reader');
      $this->spreadsheet_excel_reader->setOutputEncoding('CP1251');
      $this->db->db_set_charset('latin1', 'latin1_swedish_ci');

      $this->spreadsheet_excel_reader->read($data['full_path']);
      $sheets = $this->spreadsheet_excel_reader->sheets[0];


      $data_excel = array();
      $id = create_id();
      for ($i = 2; $i <= $sheets['numRows']; $i++) {
        if ($sheets['cells'][$i][2] == '') break;

        $param_id_rumus['id_multiple_rumus'] = anti_inject($this->input->post('id_multiple_rumus'));

        $data_excel[$i - 1]['import_kode'] = $id;
        $data_excel[$i - 1]['detail_multiple_rumus_id'] = create_id();
        $data_excel[$i - 1]['id_multiple_rumus'] = $param_id_rumus['id_multiple_rumus'];
        $data_excel[$i - 1]['parameter_rumus'] = $sheets['cells'][$i][1];
        $data_excel[$i - 1]['satuan_parameter'] = $sheets['cells'][$i][2];
        $data_excel[$i - 1]['when_create']  = date('Y-m-d H:i:s');
        $data_excel[$i - 1]['who_create']  = $data_session['user_nama_lengkap'];
      }

      $this->db->insert_batch('import.import_sample_detail_multiple', $data_excel);

      header("Location: " . base_url('master/rumus_multiple/index_import_detail?header_menu=0&menu_id=0&import_kode=' . $id . '&id_multiple_rumus=' .  $param_id_rumus['id_multiple_rumus']));
    } else {
      $error = $this->upload->display_errors();
      print_r($error);
    }
  }

  public function insertTableParameter(){
    $param['import_kode'] = $this->input->get('import_kode');
    $this->M_rumus_multiple->insertTableParameter($param);
    $this->M_rumus_multiple->deleteTableParameter($this->input->get('import_kode'));

    header("Location: " . base_url('master/rumus_multiple/index?header_menu=0&menu_id=0'));
  }
  /* Insert Import Parameter */

  /* Insert Import Detail Parameter */
  public function insertImportDetailParameter(){
    ini_set('display_errors', 1);
    error_reporting(0);
    // error_reporting(E_ALL);
    $data_session = $this->session->userdata();
    $config = array(
      'upload_path'   => FCPATH . '/upload/',
      'allowed_types' => 'xls|csv'
    );

    $this->upload->initialize($config);

    if ($this->upload->do_upload('file_import')) {
      $data = $this->upload->data();
      @chmod($data['full_path'], 0777);

      $this->load->library('Spreadsheet_Excel_Reader');
      $this->spreadsheet_excel_reader->setOutputEncoding('CP1251');
      $this->db->db_set_charset('latin1', 'latin1_swedish_ci');

      $this->spreadsheet_excel_reader->read($data['full_path']);
      $sheets = $this->spreadsheet_excel_reader->sheets[0];

      $data_excel = array();
      $id = create_id();
      for ($i = 2; $i <= $sheets['numRows']; $i++) {
        if ($sheets['cells'][$i][3] == '') break;

        $param_id_rumus['id_parameter'] = anti_inject($this->input->post('id_parameter'));

        $data_excel[$i - 1]['import_kode'] = $id;
        $data_excel[$i - 1]['detail_parameter_rumus_id'] = create_id();
        $data_excel[$i - 1]['id_parameter'] = $param_id_rumus['id_parameter'];
        $data_excel[$i - 1]['rumus_detail_input'] = $sheets['cells'][$i][1];
        $data_excel[$i - 1]['detail_parameter_rumus'] = $sheets['cells'][$i][2];
        $data_excel[$i - 1]['rumus_jenis'] = $sheets['cells'][$i][3];
        $data_excel[$i - 1]['rumus_detail_urut'] = $sheets['cells'][$i][4];
        $data_excel[$i - 1]['when_create']  = date('Y-m-d H:i:s');
        $data_excel[$i - 1]['who_create']  = $data_session['user_nama_lengkap'];
      }

      $this->db->insert_batch('import.import_sample_parameter_rumus', $data_excel);

      header("Location: " . base_url('master/rumus_multiple/index_import_detail_detail?header_menu=0&menu_id=0&import_kode=' . $id . '&id_parameter=' .  $param_id_rumus['id_parameter']));
    } else {
      $error = $this->upload->display_errors();
      print_r($error);
    }
  }

  public function insertTableDetailParameter(){
    $param['import_kode'] = $this->input->get('import_kode');
    $this->M_rumus_multiple->insertTableDetailParameter($param);
    $this->M_rumus_multiple->deleteTableDetailParameter($this->input->get('import_kode'));

    header("Location: " . base_url('master/rumus_multiple/index?header_menu=0&menu_id=0'));
  }
  /* Insert Import Detail Parameter */

  public function indexMamas(){
    $this->load->view('master/mamas');
  }
} /* . End Proses Rumus_multiple */
