<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kurva extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->load->model('master/M_Kurva');
    $this->load->model('master/M_rumus_multiple');
    $this->load->model('master/M_perhitungan_sample');
  }

  /* INDEX */
  public function index()
  {
    $isi['judul'] = 'Kurva';
    $data = $this->session->userdata();
    $data['id_sidebar'] = $this->input->get('id_sidebar');
    $data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

    $this->load->view('tampilan/header', $isi);
    $this->load->view('tampilan/sidebar', $data);
    $this->load->view('master/kurva');
    $this->load->view('tampilan/footer');
    $this->load->view('master/kurva_js');
  }

  public function lihat()
  {
    $isi['judul'] = 'Lihat Kurva';
    $data = $this->session->userdata();
    $data['id_sidebar'] = $this->input->get('id_sidebar');
    $data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

    $param['kurva_id'] = $this->input->get_post('id_kurva');
    $param['id_kurva'] = $this->input->get_post('id_kurva');

    $konten['kurva_header'] = $this->M_Kurva->getKurvaHeader($param);
    $konten['kurva'] = $this->M_Kurva->getKurva($param);

    $this->load->view('tampilan/header', $isi);
    $this->load->view('tampilan/sidebar', $data);
    $this->load->view('master/kurva_lihat', $konten);
    $this->load->view('tampilan/footer');
    $this->load->view('master/kurva_lihat_js');
  }


  /* INDEX */

  /* GET */
  public function getRumusMultiple()
  {
    $param = array(
      'multiple_rumus_id' => $this->input->get_post('multiple_rumus_id'),
      // 'id_rumus' => $this->input->get_post('id_rumus'),
    );
    $data = $this->M_rumus_multiple->getRumusMultiple($param);

    echo json_encode($data);
  }

  public function getJenisSample()
  {
    $listJenis['results'] = array();

    $param['jenis_nama'] = $this->input->get('jenis_nama');
    foreach ($this->M_rumus_multiple->getJenisSample($param) as $key => $value) {
      array_push($listJenis['results'], [
        'id' => $value['jenis_id'],
        'text' => $value['jenis_nama'],
      ]);
    }

    echo json_encode($listJenis);
  }

  public function getJenisRumusList()
  {
    $listJenis['results'] = array();

    $param['jenis_nama'] = $this->input->get('jenis_nama');

    $data = $this->M_perhitungan_sample->getPerhitunganSample($param);
    foreach ($data as $key => $value) {
      array_push($listJenis['results'], [
        'id' => $value['rumus_id'],
        'text' => $value['jenis_nama'] . ' - ' . $value['rumus_nama'],
      ]);
    }

    echo json_encode($listJenis);
  }

  public function getKurva()
  {
    $param['kurva_id'] = $this->input->get_post('kurva_id');
    $data = $this->M_Kurva->getKurva($param);
    echo json_encode($data);
  }

  public function getKurvaHeader()
  {
    $param['kurva_header_id'] = $this->input->get_post('kurva_header_id');
    $param['id_kurva'] = $this->input->get_post('id_kurva');
    $data = $this->M_Kurva->getKurvaHeader($param);
    echo json_encode($data);
  }

  public function getKurvaIsi()
  {
    $param['kurva_isi_id'] = $this->input->get_post('kurva_isi_id');
    $param['id_kurva'] = $this->input->get_post('id_kurva');
    $param['id_kurva_header'] = $this->input->get_post('id_kurva_header');
    $data = $this->M_Kurva->getKurvaIsi($param);
    echo json_encode($data);
  }

  public function getKurvaBatas()
  {
    $param['id_kurva'] = $this->input->get_post('id_kurva');
    $param['id_kurva_header'] = $this->input->get_post('id_kurva_header');
    $isi = array();
    $isian = $this->db->query("SELECT count(*) as total FROM sample.sample_kurva_isi WHERE id_kurva = '" . $param['id_kurva'] . "' AND id_kurva_header='" . $param['id_kurva_header'] . "'")->row_array();
    $batas = $this->db->query("SELECT kurva_baris as batas FROM sample.sample_kurva WHERE kurva_id = '" . $param['id_kurva'] . "'")->row_array();

    $data['isian'] = ($isian['total'] > 0) ? $isian['total'] : '0';
    $data['batas'] = ($batas['batas'] > 0) ? $batas['batas'] : '0';

    array_merge($data);

    echo json_encode($data);
  }
  /* GET */

  /* Insert */
  public function insertKurva()
  {
    $sesi = $this->session->userdata();

    $data['kurva_id'] = create_id();
    $data['id_rumus'] = $this->input->get_post('id_rumus');
    $data['kurva_nama'] = $this->input->get_post('kurva_nama');
    $data['kurva_baris'] = $this->input->get_post('kurva_baris');
    $data['when_create'] = date('Y-m-d H:i:s');
    $data['who_create'] = ($sesi['user_id'] == '1') ? 'Super Admin' : $sesi['user_nama'];

    $this->M_Kurva->insertKurva($data);
  }

  public function insertKurvaHeader()
  {
    $data['kurva_header_id'] = create_id();
    $data['id_kurva'] = $this->input->get_post('id_kurva');
    $data['kurva_header_nama'] = $this->input->get_post('kurva_header_nama');
    $data['kurva_header_urut'] = $this->input->get_post('kurva_header_urut');

    $this->M_Kurva->insertKurvaHeader($data);
  }

  public function insertKurvaIsi()
  {
    $data['kurva_isi_id'] = create_id();
    $data['id_kurva'] = $this->input->get_post('id_kurva');
    $data['id_kurva_header']  = $this->input->get_post('id_kurva_header');
    $data['kurva_urut'] = $this->input->get_post('kurva_isi_urut');
    $data['kurva_isi_jumlah'] = $this->input->get_post('kurva_isi_jumlah');

    $this->M_Kurva->insertKurvaIsi($data);
  }


  /* Insert */

  /* Update */
  public function updateKurva()
  {
    $sesi = $this->session->userdata();

    $id = $this->input->get_post('kurva_id');
    $data['id_rumus'] = $this->input->get_post('id_rumus');
    $data['kurva_nama'] = $this->input->get_post('kurva_nama');
    $data['kurva_baris'] = $this->input->get_post('kurva_baris');
    $data['when_create'] = date('Y-m-d H:i:s');
    $data['who_create'] = ($sesi['user_id'] == '1') ? 'Super Admin' : $sesi['user_nama'];

    $this->M_Kurva->updateKurva($id, $data);
  }

  public function updateKurvaHeader()
  {
    $id = $this->input->get_post('kurva_header_id');
    $data['id_kurva'] = $this->input->get_post('id_kurva');
    $data['kurva_header_nama'] = $this->input->get_post('kurva_header_nama');
    $data['kurva_header_urut'] = $this->input->get_post('kurva_header_urut');

    $this->M_Kurva->updateKurvaHeader($id, $data);
  }

  public function updateKurvaIsi()
  {
    $id = $this->input->get_post('kurva_isi_id');
    $data['kurva_urut'] = $this->input->get_post('kurva_isi_urut');
    $data['kurva_isi_jumlah'] = $this->input->get_post('kurva_isi_jumlah');

    $this->M_Kurva->updateKurvaIsi($id, $data);
  }

  public function updateRumusMultiple()
  {
    $isi = $this->session->userdata();

    $id = $this->input->post('multiple_rumus_id');
    $data = array(
      'jenis_id' => $this->input->get_post('jenis_id'),
      'metode' => $this->input->get_post('metode'),
      'when_create' => date('Y-m-d H:i:s'),
      'who_create' => $isi['user_nama_lengkap'],
    );

    $this->M_rumus_multiple->updateRumusMultiple($data, $id);
  }
  /* Update */

  /* Delete */
  public function deleteKurva()
  {
    $id = $this->input->get_post('kurva_id');
    $this->M_Kurva->deleteKurva($id);
  }

  public function deleteKurvaHeader()
  {
    $id = $this->input->get_post('kurva_header_id');
    $this->M_Kurva->deleteKurvaHeader($id);
  }

  public function deleteKurvaIsi()
  {
    $id = $this->input->get_post('kurva_isi_id');
    $this->M_Kurva->deleteKurvaIsi($id);
  }

  public function deleteRumusMultiple()
  {
    $this->M_rumus_multiple->deleteRumusMultiple($this->input->get('multiple_rumus_id'));
  }
  /* Delete */

  /* Get Parameter & Detail Paramater */
  public function getDetailRumusMultiple()
  {
    $param = array();

    if ($this->input->get('id_multiple_rumus')) $param['id_multiple_rumus'] = $this->input->get('id_multiple_rumus');
    if ($this->input->get('detail_multiple_rumus_id')) $param['detail_multiple_rumus_id'] = $this->input->get('detail_multiple_rumus_id');
    if ($this->input->post('parameter_rumus')) $param['parameter_rumus'] = $this->input->post('parameter_rumus');

    $data = $this->M_rumus_multiple->getDetailRumusMultiple($param);
    // echo $this->db->last_query($data);

    echo json_encode($data);
  }

  public function getListRumus()
  {
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

  public function getUrutanRumus($value = '')
  {
    $select = "*";
    $where = array('rumus_detail_urut' => $this->input->get('rumus_detail_urut'), 'id_parameter' => $this->input->get('detail_multiple_rumus_id'));
    $data = $this->M_rumus_multiple->getUrutanRumus($select, $where, null, null, null)->row();
    if (!empty($data)) {
      $error['field_name'] = 'rumus_detail_urut';
      $error['msg'] = "Urutan Template Sudah Ada !!";

      echo json_encode($error);
    }
  }

  public function getParameterRumus()
  {
    $param['id_parameter'] = anti_inject($this->input->get_post('id_parameter'));
    $param['detail_parameter_rumus_id'] = anti_inject($this->input->get_post('detail_parameter_rumus_id'));

    $data = $this->M_rumus_multiple->getParameterRumus($param);
    // echo $this->db->last_query();

    echo json_encode($data);
  }
  /*Get Parameter & Detail Paramater */

  /* Insert Parameter & Detail Paramater */
  public function insertRumusMultipleDetail()
  {
    $isi = $this->session->userdata();

    $data['detail_multiple_rumus_id'] = create_id();
    $data['id_multiple_rumus'] = $this->input->post('temp_multiple_rumus_id');
    $data['parameter_rumus'] = $this->input->post('parameter_rumus');
    $data['satuan_parameter'] = $this->input->post('satuan_parameter');
    $data['when_create'] = date('Y-m-d H:i:s');
    $data['who_create'] = $isi['user_nama_lengkap'];

    $this->M_rumus_multiple->insertRumusMultipleDetail($data);
  }

  public function insertDetailParameter()
  {
    $isi = $this->session->userdata();

    $rumus_detail_input = ($this->input->post('rumus_detail_input') != FALSE) ? $this->input->post('rumus_detail_input') : NULL;
    $rumus_detail_template = ($this->input->post('rumus_detail_template') != FALSE) ? $this->input->post('rumus_detail_template') : NULL;
    $rumus_detail_urut = ($this->input->post('rumus_detail_urut') != FALSE) ? $this->input->post('rumus_detail_urut') : NULL;

    $data['detail_parameter_rumus_id'] = create_id();
    $data['id_parameter'] = $this->input->post('id_detail_parameter_rumus');
    $data['rumus_detail_urut'] = $rumus_detail_urut;
    $data['detail_parameter_rumus'] = $this->input->post('detail_parameter_rumus');
    $data['rumus_detail_input'] = $rumus_detail_input;
    $data['rumus_jenis'] = $this->input->post('rumus_jenis');
    $data['rumus_detail_template'] = $rumus_detail_template;
    $data['when_create'] = date('Y-m-d H:i:s');
    $data['who_create'] = $isi['user_nama_lengkap'];

    $this->M_rumus_multiple->insertDetailParameter($data);
  }
  /* Insert Parameter & Detail Paramater */

  /* Update Parameter & Detail Paramater */
  public function updateRumusMultipleDetail()
  {
    $isi = $this->session->userdata();

    $id = $this->input->post('detail_multiple_rumus_id');
    $data = array(
      'id_multiple_rumus' => $this->input->post('temp_multiple_rumus_id'),
      'parameter_rumus' => $this->input->post('parameter_rumus'),
      'satuan_parameter' => $this->input->post('satuan_parameter'),
      'when_create' => date('Y-m-d H:i:s'),
      'who_create' => $isi['user_nama_lengkap'],
    );

    $this->M_rumus_multiple->updateRumusMultipleDetail($data, $id);
  }

  public function updateDetailParameter()
  {
    $isi = $this->session->userdata();

    $rumus_detail_template = ($this->input->post('rumus_detail_template') != FALSE) ? $this->input->post('rumus_detail_template') : NULL;
    $rumus_detail_input = ($this->input->post('rumus_detail_input') != FALSE) ? $this->input->post('rumus_detail_input') : NULL;

    $id = $this->input->post('detail_parameter_rumus_id');
    $data = array(
      'id_parameter' => $this->input->post('id_detail_parameter_rumus'),
      'rumus_detail_urut' => $this->input->post('rumus_detail_urut'),
      'detail_parameter_rumus' => $this->input->post('detail_parameter_rumus'),
      'rumus_detail_input' => $rumus_detail_input,
      'rumus_jenis' => $this->input->post('rumus_jenis'),
      'rumus_detail_template' => $rumus_detail_template,
      'when_create' => date('Y-m-d H:i:s'),
      'who_create' => $isi['user_nama_lengkap'],
    );

    $this->M_rumus_multiple->updateDetailParameter($data, $id);
  }
  /* Update Parameter & Detail Paramater */

  /* Delete Parameter & Detail Paramater */
  public function deleteRumusMultipleDetail()
  {
    $this->M_rumus_multiple->deleteRumusMultipleDetail($this->input->get('detail_multiple_rumus_id'));
  }

  public function deleteDetailParameter()
  {
    $this->M_rumus_multiple->deleteDetailParameter($this->input->get('detail_parameter_rumus_id'));
  }
  /* Delete Parameter & Detail Paramater */

  /* Get Import */
  public function getImport()
  {
    $param['import_kode'] = $this->input->get('import_kode');

    $data = $this->M_rumus_multiple->getImport($param);

    echo json_encode($data);
  }

  public function getImportParameter()
  {
    $param['import_kode'] = $this->input->get('import_kode');

    $data = $this->M_rumus_multiple->getImportParameter($param);

    echo json_encode($data);
  }

  public function getImportDetailParameter()
  {
    $param['import_kode'] = $this->input->get('import_kode');

    $data = $this->M_rumus_multiple->getImportDetailParameter($param);

    echo json_encode($data);
  }
  /* Get Import */

  /* Insert Import */
  public function insertImport()
  {
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

  public function insertTable()
  {
    $param['import_kode'] = $this->input->get('import_kode');
    $this->M_rumus_multiple->insertTable($param);
    $this->M_rumus_multiple->deleteTable($this->input->get('import_kode'));

    header("Location: " . base_url('master/rumus_multiple/index?header_menu=0&menu_id=0'));
  }
  /* Insert Import */

  /* Insert Import Paramater */
  public function insertImportParameter()
  {
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

        $param_id_rumus['id_multiple_rumus'] = $this->input->post('id_multiple_rumus');

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

  public function insertTableParameter()
  {
    $param['import_kode'] = $this->input->get('import_kode');
    $this->M_rumus_multiple->insertTableParameter($param);
    $this->M_rumus_multiple->deleteTableParameter($this->input->get('import_kode'));

    header("Location: " . base_url('master/rumus_multiple/index?header_menu=0&menu_id=0'));
  }
  /* Insert Import Parameter */

  /* Insert Import Detail Parameter */
  public function insertImportDetailParameter()
  {
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

        $param_id_rumus['id_parameter'] = $this->input->post('id_parameter');

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

  public function insertTableDetailParameter()
  {
    $param['import_kode'] = $this->input->get('import_kode');
    $this->M_rumus_multiple->insertTableDetailParameter($param);
    $this->M_rumus_multiple->deleteTableDetailParameter($this->input->get('import_kode'));

    header("Location: " . base_url('master/rumus_multiple/index?header_menu=0&menu_id=0'));
  }
  /* Insert Import Detail Parameter */

  public function indexMamas()
  {
    $this->load->view('master/mamas');
  }
} /* . End Proses Rumus_multiple */
