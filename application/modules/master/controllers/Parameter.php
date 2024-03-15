<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Parameter extends MY_Controller{

  public function __construct(){
    parent::__construct();
    // load model
    $this->load->model('master/M_parameter');
  }

  /* INDEX PARAMETER */
  public function index(){
    $isi['judul'] = 'Parameter';
    $data = $this->session->userdata();
    $data['id_sidebar'] = $this->input->get('id_sidebar');
    $data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');
    $data['data'] = $this->M_parameter->gettenagakerja();

    $this->template->template_master('master/parameter',$isi,$data);
  }
  /* INDEX PARAMETER */

  /* GET PARAMETER */
  public function getParameter(){
    $param['parameter_id'] = anti_inject($this->input->get_post('parameter_id'));

    $data = $this->M_parameter->getParameter($param);

    echo json_encode($data);
  }
  /* GET PARAMETER */

  /* GET PARAMETER JAsA */
  public function getParameterJasa(){
    $param['id_parameter'] = anti_inject($this->input->get_post('id_parameter'));

    $data = $this->M_parameter->getParameterJasa($param);

    echo json_encode($data);
  }
  /* GET PARAMETER JAsA */

  /* GET PARAMETER MATERIAL */
  public function getParameterMaterial(){
    $param['id_parameter'] = anti_inject($this->input->get_post('id_parameter'));
    $param['parameter_material_id'] = anti_inject($this->input->get_post('parameter_material_id'));

    $data = $this->M_parameter->getParameterMaterial($param);

    echo json_encode($data);
  }
  /* GET PARAMETER MATERIAL */

  /* GET PARAMETER ASET */
  public function getParameterAset(){
    $param['id_parameter'] = anti_inject($this->input->get_post('id_parameter'));
    $param['parameter_aset_id'] = anti_inject($this->input->get_post('parameter_aset_id'));

    $data = $this->M_parameter->getParameterAset($param);

    echo json_encode($data);
  }
  /* GET PARAMETER ASET */

  /* GET ASET */
  public function getAset(){
    $list['results'] = array();
    $where_aset = ($this->input->get('aset_nama') != null) ? "UPPER(aset_nama) LIKE '%" . strtoupper($this->input->get('aset_nama')) . "%'" : '1=1';

    $sql = $this->db->query("SELECT * FROM material.material_aset WHERE " . $where_aset . " ORDER BY aset_nama ASC");
    $dataAset = $sql->result_array();

    foreach ($dataAset as $key => $value) {
      array_push($list['results'], [
        'id' => $value['aset_id'],
        'text' => $value['aset_nama'],
      ]);
    }

    $where_material = ($this->input->get('aset_nama') != null) ? "UPPER(item_nama) LIKE '%" . strtoupper($this->input->get('aset_nama')) . "%'" : '1=1';

    $sql = $this->db->query("SELECT * FROM material.material_item WHERE jenis_id = 'da7ee77490abcee5aec6b3518e5490f56cce7b17' AND " . $where_material . " ORDER BY item_nama ASC");
    $dataAset = $sql->result_array();

    foreach ($dataAset as $key => $value) {
      array_push($list['results'], [
        'id' => $value['item_id'],
        'text' => $value['item_nama'],
      ]);
    }

    echo json_encode($list);
  }
  /* GET ASET */

  /* GET ASET ISI */
  public function getAsetIsi(){
    $isi = array();

    $sql = $this->db->query("SELECT * FROM material.material_aset WHERE aset_id = '" . $_GET['aset_id'] . "'");
    $dataAset = $sql->row_array();

    $sql = $this->db->query("SELECT * FROM material.material_item WHERE item_id = '" . $_GET['aset_id'] . "'");
    $dataMaterial = $sql->row_array();

    if ($dataAset != null) {
      $isi['umur'] = $dataAset['aset_umur'];
      $isi['harga'] = $dataAset['aset_nilai_perolehan'];
    } else {
      $isi['umur'] = '1';
      $isi['harga'] = $dataMaterial['item_harga'];
    }

    echo json_encode($isi);
  }
  /* GET ASET ISI */

  /* INSERT PARAMETER */
  public function insertParameter(){
    $sesi = $this->session->userdata();

    $param['parameter_id'] = anti_inject(create_id());
    $param['parameter_nama'] = anti_inject($this->input->get_post('parameter_nama'));
    $param['parameter_biaya_lain'] = anti_inject($this->input->get_post('parameter_biaya_lain'));
    $param['parameter_medium'] = anti_inject($this->input->get_post('parameter_medium'));
    $param['parameter_very_fast'] = anti_inject($this->input->get_post('parameter_very_fast'));

    $this->M_parameter->insertParameter($param);

    /* Update Total */
    $sql_total = $this->db->query("SELECT parameter_jasa_total + parameter_material_total + parameter_aset_total + parameter_biaya_lain AS total FROM global.global_parameter WHERE parameter_id = '" . anti_inject($param['parameter_id']) . "'");
    $dataTotal = $sql_total->row_array();

    $id_total = anti_inject($param['parameter_id']);
    $param_total['parameter_grand_total'] = anti_inject($dataTotal['total']);

    $this->M_parameter->updateParameter($id_total, $param_total);
    /* Update Total */
  }
  /* INSERT PARAMETER */

  /* INSERT PARAMETER JASA */
  public function insertParameterJasa(){
    $this->M_parameter->deleteParameterJasa($this->input->get_post('id_parameter_jasa'));

    $sql = $this->db->query("SELECT * FROM global.global_tenaga_kerja ORDER BY tenaga_kerja_jabatan ASC");
    $data = $sql->result_array();

    foreach ($data as $key => $value) {
      $param['parameter_jasa_id'] = anti_inject(create_id());
      $param['id_parameter'] = anti_inject($this->input->get_post('id_parameter_jasa'));
      $param['parameter_jasa_jabatan'] = anti_inject($value['tenaga_kerja_jabatan']);
      $param['parameter_jasa_uhpd'] = anti_inject($this->input->get_post('uhpd')[$value['tenaga_kerja_jabatan']]);
      $param['parameter_jasa_honorarium'] = anti_inject($this->input->get_post('honorarium')[$value['tenaga_kerja_jabatan']]);
      $param['parameter_jasa_durasi'] = anti_inject($this->input->get_post('durasi')[$value['tenaga_kerja_jabatan']]);
      $param['parameter_jasa_grand_total'] = anti_inject($this->input->get_post('total')[$value['tenaga_kerja_jabatan']]);

      $this->M_parameter->insertParameterJasa($param);
    }

    /* Update Total Jasa */
    $sql_parameter = $this->db->query("SELECT SUM(parameter_jasa_grand_total) AS total FROM global.global_parameter_jasa WHERE id_parameter = '" . anti_inject($this->input->get_post('id_parameter_jasa')) . "'");
    $dataParameter = $sql_parameter->row_array();

    $id_jasa = anti_inject($this->input->get_post('id_parameter_jasa'));
    $param_jasa['parameter_jasa_total'] = anti_inject($dataParameter['total']);

    $this->M_parameter->updateParameter($id_jasa, $param_jasa);
    /* Update Total Jasa */

    /* Update Total */
    $sql_total = $this->db->query("SELECT parameter_jasa_total + parameter_material_total + parameter_aset_total + parameter_biaya_lain AS total FROM global.global_parameter WHERE parameter_id = '" . anti_inject($this->input->get_post('id_parameter_jasa')) . "'");
    $dataTotal = $sql_total->row_array();

    $id_total = anti_inject($this->input->get_post('id_parameter_jasa'));
    $param_total['parameter_grand_total'] = anti_inject($dataTotal['total']);

    $this->M_parameter->updateParameter($id_total, $param_total);
    /* Update Total */
  }
  /* INSERT PARAMETER JASA */

  /* INSERT PARAMETER MATERIAL */
  public function insertParameterMaterial(){
    $param['parameter_material_id'] = anti_inject(create_id());
    $param['id_parameter'] = anti_inject($this->input->get_post('id_parameter_material'));
    $param['id_material'] = anti_inject($this->input->get_post('id_material'));
    $param['parameter_material_jumlah'] = anti_inject($this->input->get_post('parameter_material_jumlah'));
    $param['parameter_material_grand_total'] = anti_inject($this->input->get_post('parameter_material_grand_total'));

    $this->M_parameter->insertParameterMaterial($param);

    /* Update Total Material */
    $sql_parameter = $this->db->query("SELECT SUM(parameter_material_grand_total) AS total FROM global.global_parameter_material WHERE id_parameter = '" . anti_inject($this->input->get_post('id_parameter_material')) . "'");
    $dataParameter = $sql_parameter->row_array();

    $id_material = anti_inject($this->input->get_post('id_parameter_material'));
    $param_material['parameter_material_total'] = anti_inject($dataParameter['total']);

    $this->M_parameter->updateParameter($id_material, $param_material);
    /* Update Total Material */

    /* Update Total */
    $sql_total = $this->db->query("SELECT parameter_jasa_total + parameter_material_total + parameter_aset_total + parameter_biaya_lain AS total FROM global.global_parameter WHERE parameter_id = '" . anti_inject($this->input->get_post('id_parameter_material')) . "'");
    $dataTotal = $sql_total->row_array();

    $id_total = anti_inject($this->input->get_post('id_parameter_material'));
    $param_total['parameter_grand_total'] = anti_inject($dataTotal['total']);

    $this->M_parameter->updateParameter($id_total, $param_total);
    /* Update Total */
  }
  /* INSERT PARAMETER MATERIAL */

  /* INSERT PARAMETER ASET */
  public function insertParameterAset(){
    $param['parameter_aset_id'] = anti_inject(create_id());
    $param['id_parameter'] = anti_inject($this->input->get_post('id_parameter_aset'));
    $param['id_aset'] = anti_inject($this->input->get_post('id_aset'));
    $param['parameter_aset_jumlah'] = anti_inject($this->input->get_post('parameter_aset_jumlah'));
    $param['parameter_aset_grand_total'] = anti_inject($this->input->get_post('parameter_aset_grand_total'));

    $this->M_parameter->insertParameterAset($param);

    /* Update Total Aset */
    $sql_parameter = $this->db->query("SELECT SUM(parameter_aset_grand_total) AS total FROM global.global_parameter_aset WHERE id_parameter = '" . anti_inject($this->input->get_post('id_parameter_aset')) . "'");
    $dataParameter = $sql_parameter->row_array();

    $id_aset = anti_inject($this->input->get_post('id_parameter_aset'));
    $param_aset['parameter_aset_total'] = anti_inject($dataParameter['total']);

    $this->M_parameter->updateParameter($id_aset, $param_aset);
    /* Update Total Aset */

    /* Update Total */
    $sql_total = $this->db->query("SELECT parameter_jasa_total + parameter_material_total + parameter_aset_total + parameter_biaya_lain AS total FROM global.global_parameter WHERE parameter_id = '" . anti_inject($this->input->get_post('id_parameter_aset')) . "'");
    $dataTotal = $sql_total->row_array();

    $id_total = anti_inject($this->input->get_post('id_parameter_aset'));
    $param_total['parameter_grand_total'] = anti_inject($dataTotal['total']);

    $this->M_parameter->updateParameter($id_total, $param_total);
    /* Update Total */
  }
  /* INSERT PARAMETER ASET */

  /* UPDATE PARAMETER */
  public function updateParameter(){
    $id = anti_inject($this->input->get_post('parameter_id'));
    $param['parameter_nama'] = anti_inject($this->input->get_post('parameter_nama'));
    $param['parameter_biaya_lain'] = anti_inject($this->input->get_post('parameter_biaya_lain'));

    $this->M_parameter->updateParameter($id, $param);

    /* Update Total */
    $sql_total = $this->db->query("SELECT parameter_jasa_total + parameter_material_total + parameter_aset_total + parameter_biaya_lain AS total FROM global.global_parameter WHERE parameter_id = '" . anti_inject($id) . "'");
    $dataTotal = $sql_total->row_array();

    $id_total = anti_inject($id);
    $param_total['parameter_grand_total'] = anti_inject($dataTotal['total']);

    $this->M_parameter->updateParameter($id_total, $param_total);
    /* Update Total */
  }
  /* UPDATE PARAMETER */

  /* UPDATE PARAMETER MATERIAL */
  public function updateParameterMaterial(){
    $id = anti_inject($this->input->get_post('parameter_material_id'));
    $param['id_material'] = anti_inject($this->input->get_post('id_material'));
    $param['parameter_material_jumlah'] = anti_inject($this->input->get_post('parameter_material_jumlah'));
    $param['parameter_material_grand_total'] = anti_inject($this->input->get_post('parameter_material_grand_total'));

    $this->M_parameter->updateParameterMaterial($id, $param);

    /* Update Total Material */
    $sql_parameter = $this->db->query("SELECT SUM(parameter_material_grand_total) AS total FROM global.global_parameter_material WHERE id_parameter = '" . anti_inject($this->input->get_post('id_parameter_material')) . "'");
    $dataParameter = $sql_parameter->row_array();

    $id_material = anti_inject($this->input->get_post('id_parameter_material'));
    $param_material['parameter_material_total'] = anti_inject($dataParameter['total']);

    $this->M_parameter->updateParameter($id_material, $param_material);
    /* Update Total Material */

    /* Update Total */
    $sql_total = $this->db->query("SELECT parameter_jasa_total + parameter_material_total + parameter_aset_total + parameter_biaya_lain AS total FROM global.global_parameter WHERE parameter_id = '" . anti_inject($this->input->get_post('id_parameter_material')) . "'");
    $dataTotal = $sql_total->row_array();

    $id_total = anti_inject($this->input->get_post('id_parameter_material'));
    $param_total['parameter_grand_total'] = anti_inject($dataTotal['total']);

    $this->M_parameter->updateParameter($id_total, $param_total);
    /* Update Total */
  }
  /* UPDATE PARAMETER MATERIAL */

  /* UPDATE PARAMETER ASET */
  public function updateParameterAset(){
    $id = anti_inject($this->input->get_post('parameter_aset_id'));
    $param['id_aset'] = anti_inject($this->input->get_post('id_aset'));
    $param['parameter_aset_jumlah'] = anti_inject($this->input->get_post('parameter_aset_jumlah'));
    $param['parameter_aset_grand_total'] = anti_inject($this->input->get_post('parameter_aset_grand_total'));

    $this->M_parameter->updateParameterAset($id, $param);

    /* Update Total Aset */
    $sql_parameter = $this->db->query("SELECT SUM(parameter_aset_grand_total) AS total FROM global.global_parameter_aset WHERE id_parameter = '" . anti_inject($this->input->get_post('id_parameter_aset')) . "'");
    $dataParameter = $sql_parameter->row_array();

    $id_aset = anti_inject($this->input->get_post('id_parameter_aset'));
    $param_aset['parameter_aset_total'] = anti_inject($dataParameter['total']);

    $this->M_parameter->updateParameter($id_aset, $param_aset);
    /* Update Total Aset */

    /* Update Total */
    $sql_total = $this->db->query("SELECT parameter_jasa_total + parameter_material_total + parameter_aset_total + parameter_biaya_lain AS total FROM global.global_parameter WHERE parameter_id = '" . anti_inject($this->input->get_post('id_parameter_aset')) . "'");
    $dataTotal = $sql_total->row_array();

    $id_total = anti_inject($this->input->get_post('id_parameter_aset'));
    $param_total['parameter_grand_total'] = anti_inject($dataTotal['total']);

    $this->M_parameter->updateParameter($id_total, $param_total);
    /* Update Total */
  }
  /* UPDATE PARAMETER ASET */

  /* HAPUS PARAMETER */
  public function deleteParameter(){
    $id = anti_inject($this->input->get_post('parameter_id'));

    $this->M_parameter->deleteParameter($id);
  }
  /* HAPUS PARAMETER */

  /* HAPUS PARAMETER MATERIAL */
  public function deleteParameterMaterial(){
    $id = anti_inject($this->input->get_post('parameter_material_id'));

    $this->M_parameter->deleteParameterMaterial($id);

    /* Update Total Material */
    $sql_parameter = $this->db->query("SELECT SUM(parameter_material_grand_total) AS total FROM global.global_parameter_material WHERE id_parameter = '" . anti_inject($this->input->get_post('id_parameter_material')) . "'");
    $dataParameter = $sql_parameter->row_array();

    $id_material = anti_inject($this->input->get_post('id_parameter_material'));
    $param_material['parameter_material_total'] = ($dataParameter['total'] != null) ? anti_inject($dataParameter['total']) : 0;

    $this->M_parameter->updateParameter($id_material, $param_material);
    /* Update Total Material */

    /* Update Total */
    $sql_total = $this->db->query("SELECT parameter_jasa_total + parameter_material_total + parameter_aset_total + parameter_biaya_lain AS total FROM global.global_parameter WHERE parameter_id = '" . anti_inject($this->input->get_post('id_parameter_material')) . "'");
    $dataTotal = $sql_total->row_array();

    $id_total = anti_inject($this->input->get_post('id_parameter_material'));
    $param_total['parameter_grand_total'] = anti_inject($dataTotal['total']);

    $this->M_parameter->updateParameter($id_total, $param_total);
    /* Update Total */
  }
  /* HAPUS PARAMETER MATERIAL */

  /* HAPUS PARAMETER ASET */
  public function deleteParameterAset(){
    $id = anti_inject($this->input->get_post('parameter_aset_id'));

    $this->M_parameter->deleteParameterAset($id);

    /* Update Total Aset */
    $sql_parameter = $this->db->query("SELECT SUM(parameter_aset_grand_total) AS total FROM global.global_parameter_aset WHERE id_parameter = '" . anti_inject($this->input->get_post('id_parameter_aset')) . "'");
    $dataParameter = $sql_parameter->row_array();

    $id_aset = anti_inject($this->input->get_post('id_parameter_aset'));
    $param_aset['parameter_aset_total'] = ($dataParameter['total'] != null) ? anti_inject($dataParameter['total']) : 0;

    $this->M_parameter->updateParameter($id_aset, $param_aset);
    /* Update Total Aset */

    /* Update Total */
    $sql_total = $this->db->query("SELECT parameter_jasa_total + parameter_material_total + parameter_aset_total + parameter_biaya_lain AS total FROM global.global_parameter WHERE parameter_id = '" . anti_inject($this->input->get_post('id_parameter_aset')) . "'");
    $dataTotal = $sql_total->row_array();

    $id_total = anti_inject($this->input->get_post('id_parameter_aset'));
    $param_total['parameter_grand_total'] = anti_inject($dataTotal['total']);

    $this->M_parameter->updateParameter($id_total, $param_total);
    /* Update Total */
  }
  /* HAPUS PARAMETER ASET */
}

/* End of file Paramater.php */
