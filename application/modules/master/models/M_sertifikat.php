<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_sertifikat extends CI_Model
{
    /* Get */
    public function getTemplateSertifikat($data = null)
    {
        $this->db->select('a.*, b.jenis_id, b.jenis_nama, c.template_logsheet_id, c.template_logsheet_nama');
        $this->db->from('sample.sample_template_sertifikat a');
        $this->db->join('sample.sample_jenis b', 'a.sertifikat_nama = b.jenis_id', 'left');
        $this->db->join('sample.sample_template_logsheet c', 'a.id_template_logsheet = c.template_logsheet_id', 'left');
        if (isset($data['sertifikat_nama'])) $this->db->where("upper(sertifikat_nama) LIKE '%" . strtoupper($data['sertifikat_nama']) . "%'");
        if (isset($data['sertifikat_id'])) $this->db->where('sertifikat_id', $data['sertifikat_id']);

        $sql = $this->db->get();

        $this->db->order_by('sertifikat_nama', 'ASC');
        return (isset($data['sertifikat_id'])) ? $sql->row_array() : $sql->result_array();
    }

    public function getLogSheet($data = null)
    {
        $this->db->select('*');
        $this->db->from('sample.sample_template_logsheet');
        if (isset($data['template_logsheet_nama'])) $this->db->where("upper(template_logsheet_nama) LIKE '%" . strtoupper($data['jenis_nama']) . "%'");
        if (isset($data['template_logsheet_id'])) $this->db->where('template_logsheet_id', $data['jenis_id']);
        $sql = $this->db->get();

        return (isset($data['template_logsheet_id'])) ? $sql->row_array() : $sql->result_array();
    }
    /* Get */

    /* Insert */
    public function insertTemplateSertifikat($data)
    {
        $this->db->insert('sample.sample_template_sertifikat', $data);

        return $this->db->affected_rows();
    }
    /* Insert */

    /* Update */
    public function updateTemplateSertifikat($data, $id)
    {
        $this->db->set($data);
        $this->db->where('sertifikat_id', $id);
        $this->db->update('sample.sample_template_sertifikat');

        return $this->db->affected_rows();
    }
    /* Update */

    /* Delete */
    public function deleteTemplateSertifikat($id)
    {
        $this->db->where('sertifikat_id', $id);
        $this->db->delete('sample.sample_template_sertifikat');

        return $this->db->affected_rows();
    }
    /* Delete */

    /* Get Detail */
    public function getDetailSertifikat($data = null)
    {
        $this->db->select('*');
        $this->db->from('sample.sample_template_sertifikat_detail a');
        $this->db->join('sample.sample_template_sertifikat_header b', 'a.id_template_sertifikat_header = b.template_sertifikat_header_id', 'left');
        // if (isset($data['logsheet_nama_rumus'])) $this->db->where("upper(logsheet_nama_rumus) LIKE '%" . strtoupper($data['logsheet_nama_rumus']) . "%'");
        if (isset($data['id_template_sertifikat'])) $this->db->where('id_template_sertifikat', $data['id_template_sertifikat']);
        if (isset($data['sertifikat_template_detail_id'])) $this->db->where('sertifikat_template_detail_id', $data['sertifikat_template_detail_id']);

        $this->db->order_by('sertifikat_template_detail_urut', 'ASC');
        $sql = $this->db->get();

        return (isset($data['sertifikat_template_detail_id'])) ? $sql->row_array() : $sql->result_array();
    }
    /* Get Detail */

    /* Insert Detail */
    public function insertTemplateSertifikatDetail($data)
    {
        $this->db->insert('sample.sample_template_sertifikat_detail', $data);

        return $this->db->affected_rows();
    }
    /* Insert Detail */

    /* Update Detail */
    public function updateTemplateSertifikatDetail($data, $id)
    {
        $this->db->set($data);
        $this->db->where('sertifikat_template_detail_id', $id);
        $this->db->update('sample.sample_template_sertifikat_detail');

        return $this->db->affected_rows();
    }
    /* Update Detail */

    /* Delete Detail */
    public function deleteTemplateSertifikatDetail($id)
    {
        $this->db->where('sertifikat_template_detail_id', $id);
        $this->db->delete('sample.sample_template_sertifikat_detail');

        return $this->db->affected_rows();
    }
    /* Delete Detail */

    /* Get Header */
    public function getHeaderTabelSertifikat($data = null)
    {
        $this->db->select('*');
        $this->db->from('sample.sample_template_sertifikat_header');
        if (isset($data['template_sertifikat_header_nama'])) $this->db->where("upper(template_sertifikat_header_nama) LIKE '%" . strtoupper($data['template_sertifikat_header_nama']) . "%'");
        if (isset($data['template_sertifikat_header_id'])) $this->db->where('template_sertifikat_header_id', $data['template_sertifikat_header_id']);

        $sql = $this->db->get();

        $this->db->order_by('template_sertifikat_header_nama', 'ASC');

        return (isset($data['template_sertifikat_header_id'])) ? $sql->row_array() : $sql->result_array();
    }
    /* Get Header */

    /* Insert Header Tabel*/
    public function insertHeaderTabelSertifikat($data)
    {
        $this->db->insert('sample.sample_template_sertifikat_header', $data);

        return $this->db->affected_rows();
    }
    /* Insert Header Tabel */

    /* Update Header Tabel */
    public function updateHeaderTabelSertifikat($data, $id)
    {
        $this->db->set($data);
        $this->db->where('template_sertifikat_header_id', $id);
        $this->db->update('sample.sample_template_sertifikat_header');

        return $this->db->affected_rows();
    }
    /* Update Header Tabel */

    /* Delete Header Tabel */
    public function deleteHeaderTabelSertifikat($id)
    {
        $this->db->where('template_sertifikat_header_id', $id);
        $this->db->delete('sample.sample_template_sertifikat_header');

        return $this->db->affected_rows();
    }
    /* Delete Header Tabel */
}
