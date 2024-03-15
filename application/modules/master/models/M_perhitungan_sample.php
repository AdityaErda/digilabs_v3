<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_perhitungan_sample extends CI_Model{
  /* GET */
  public function getJenisSample($data = null){
      $this->db->select('*');
      $this->db->from('sample.sample_jenis');
      if (isset($data['jenis_nama'])) $this->db->where("upper(jenis_nama) LIKE '%" . strtoupper($data['jenis_nama']) . "%'");
      if (isset($data['jenis_id'])) $this->db->where('jenis_id', $data['jenis_id']);
      $sql = $this->db->get();

      return (isset($data['jenis_id'])) ? $sql->row_array() : $sql->result_array();
  }

  public function getPerhitunganSample($data = null){
      $this->db->select('a.*, b.jenis_id, b.jenis_nama');
      $this->db->from('sample.sample_perhitungan_sample a');
      $this->db->join('sample.sample_jenis b', 'a.jenis_id = b.jenis_id', 'left');

      if (isset($data['rumus_nama'])) $this->db->where("upper(rumus_nama) LIKE '%" . strtoupper($data['rumus_nama']) . "%'");
      if (isset($data['rumus_id'])) $this->db->where('rumus_id', $data['rumus_id']);
      if (isset($data['aktif'])) $this->db->where('aktif', $data['aktif']);
      if (isset($data['who_seksi_create_id'])) $this->db->where('who_seksi_create_id', $data['who_seksi_create_id']);

      // $this->db->order_by('a.rumus_nama', 'ASC');
      $sql = $this->db->get();

      return (isset($data['rumus_id'])) ? $sql->row_array() : $sql->result_array();
  }

  public function getListRumus($data = null){
      $this->db->select('a.*');
      $this->db->from('sample.sample_perhitungan_sample_detail a');

      if (isset($data['rumus_detail_input'])) $this->db->where("upper(rumus_detail_input) LIKE '%" . strtoupper($data['rumus_detail_input']) . "%'");
      $this->db->where('id_rumus = ', $data['id_rumus']);

      $this->db->order_by('rumus_detail_urut', 'ASC');
      $sql = $this->db->get();

      return $sql->result_array();
  }
  /* GET */

  /* INSERT */
  public function insertPerhitunganSample($data){
      $this->db->insert('sample.sample_perhitungan_sample', $data);

      return $this->db->affected_rows();
  }
  /* INSERT */

  /* UPDATE */
  public function updatePerhitunganSample($data, $id){
      $this->db->set($data);
      $this->db->where('rumus_id', $id);
      $this->db->update('sample.sample_perhitungan_sample');

      return $this->db->affected_rows();
  }
  /* UPDATE */

  /* DELETE */
  public function deletePerhitunganSample($id){
      $this->db->where('rumus_id', $id);
      $this->db->delete('sample.sample_perhitungan_sample');

      return $this->db->affected_rows();
  }
  /* DELETE */

  /* GET DETAIL */
  public function getDetailRumusSample($data = null){
      $this->db->select('a.*, b.desimal_angka, b.batasan_emisi');
      $this->db->from('sample.sample_perhitungan_sample_detail a');
      $this->db->join('sample.sample_perhitungan_sample b', 'a.id_rumus = b.rumus_id', 'left');

      if (isset($data['rumus_detail_nama'])) $this->db->where("upper(rumus_detail_nama) LIKE '%" . strtoupper($data['rumus_detail_nama']) . "%'");
      if (isset($data['id_rumus'])) $this->db->where('id_rumus', $data['id_rumus']);
      if (isset($data['rumus_detail_id'])) $this->db->where('rumus_detail_id', $data['rumus_detail_id']);

      $this->db->order_by('rumus_detail_template', 'ASC');
      $sql = $this->db->get();

      return (isset($data['rumus_detail_id'])) ? $sql->row_array() : $sql->result_array();
  }

  public function getUrutanTemplate($field, $where, $order = '', $limit = '', $offset = ''){
      $this->db->select($field);
      $this->db->order_by($order);
      if (!empty($where)) $this->db->where($where);
      return $this->db->get('sample.sample_perhitungan_sample_detail', $limit, $offset);
  }
  /* GET DETAIL */

  /* GET DETAIL TEMPLATE */
  public function getDetailRumusSampleTemplate($data = null){
      $this->db->select('*');
      $this->db->from('sample.sample_perhitungan_sample_detail');
      $this->db->where('rumus_detail_template IS NOT NULL');

      if (isset($data['rumus_detail_nama'])) $this->db->where("upper(rumus_detail_nama) LIKE '%" . strtoupper($data['rumus_detail_nama']) . "%'");
      if (isset($data['id_rumus'])) $this->db->where('id_rumus', $data['id_rumus']);
      if (isset($data['rumus_detail_id'])) $this->db->where('rumus_detail_id', $data['rumus_detail_id']);

      $this->db->order_by('rumus_detail_template', 'ASC');
      $sql = $this->db->get();

      return (isset($data['rumus_detail_id'])) ? $sql->row_array() : $sql->result_array();
  }
  /* GET DETAIL TEMPLATE */

  /* INSERT DETAIL */
  public function insertPerhitunganSampleDetail($data){
      $this->db->insert('sample.sample_perhitungan_sample_detail', $data);

      return $this->db->affected_rows();
  }
  /* INSERT DETAIL */

  /* UPDATE DETAIL */
  public function updatePerhitunganSampleDetail($data, $id){
      $this->db->set($data);
      $this->db->where('rumus_detail_id', $id);
      $this->db->update('sample.sample_perhitungan_sample_detail');

      return $this->db->affected_rows();
  }
  /* UPDATE DETAIL */

  /* DELETE DETAIL */
  public function deletePerhitunganSampleDetail($id){
      $this->db->where('rumus_detail_id', $id);
      $this->db->delete('sample.sample_perhitungan_sample_detail');

      return $this->db->affected_rows();
  }
  /* DELETE DETAIL */

  /* GET IMPORT */
  public function getImport($data = null){
      $this->db->select('*');
      $this->db->from('import.import_sample_perhitungan_sample a');
      $this->db->join('sample.sample_jenis b', 'a.jenis_id = b.jenis_id', 'left');

      if (isset($data['import_kode'])) $this->db->where('import_kode', $data['import_kode']);
      $sql = $this->db->get();

      return (isset($data['rumus_id'])) ? $sql->row_array() : $sql->result_array();
  }
  /* GET IMPORT */

  /* INSERT IMPORT */
  public function insertTable($data){
      $this->db->query("INSERT INTO sample.sample_perhitungan_sample SELECT rumus_id, rumus_nama, when_create, who_create, is_aktif, jenis_id, is_adbk, desimal_angka, satuan_sample FROM import.import_sample_perhitungan_sample WHERE import_kode = '" . $data['import_kode'] . "'");

      return $this->db->affected_rows();
  }
  /* INSERT IMPORT */

  /* DELETE TABLE */
  public function deleteTable($id){
      $this->db->where('import_kode', $id);
      $this->db->delete('import.import_sample_perhitungan_sample');

      return $this->db->affected_rows();
  }
  /* DELETE TABLE */

  /* GET IMPORT DETAIL */
  public function getImportDetail($data = null){
      $this->db->select('*');
      $this->db->from('import.import_sample_perhitungan_sample_detail a');
      $this->db->join('sample.sample_perhitungan_sample b', 'a.id_rumus = b.rumus_id', 'left');

      if (isset($data['import_kode'])) $this->db->where('import_kode', $data['import_kode']);
      $this->db->order_by('rumus_detail_urut', 'ASC');
      $sql = $this->db->get();

      return $sql->result_array();
  }
  /* GET IMPORT DETAIL*/

  /* INSERT IMPORT */
  public function insertTableDetail($data){
      $this->db->query("INSERT INTO sample.sample_perhitungan_sample_detail SELECT rumus_detail_id, id_rumus, rumus_detail_input, rumus_detail_nama, rumus_jenis, when_create, who_create, rumus_detail_urut, rumus_detail_template FROM import.import_sample_perhitungan_sample_detail WHERE import_kode = '" . $data['import_kode'] . "'");

      return $this->db->affected_rows();
  }
  /* INSERT IMPORT */

  /* DELETE TABLE */
  public function deleteTableDetail($id){
      $this->db->where('import_kode', $id);
      $this->db->delete('import.import_sample_perhitungan_sample_detail');

      return $this->db->affected_rows();
  }
  /* DELETE TABLE */
}
