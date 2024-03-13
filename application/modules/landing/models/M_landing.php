<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_landing extends CI_Model
{
    public function getLanding($param = null)
    {
        $this->db->select('*');
        $this->db->from('landing.landing a');
        $this->db->join('landing.landing_template b', 'b.landing_template_id = a.id_landing_template', 'left');

        if (isset($param['landing_id'])) $this->db->where('landing_id', $param['landing_id']);
        if (isset($param['not_landing_id'])) $this->db->where('landing_id !=', $param['not_landing_id']);
        // $this->db->where('aktif', 'y');
        if (isset($param['aktif'])) $this->db->where('aktif', $param['aktif']);


        $this->db->order_by('landing_urut', 'asc');
        $query = $this->db->get();
        return (isset($param['landing_id'])) ? $query->row_array() : $query->result_array();
    }

    public function getLandingDetail($param = null)
    {
        $this->db->select('*');
        $this->db->from('landing.landing_detail a');
        $this->db->join('landing.landing b', 'b.landing_id = a.id_landing', 'left');
        $this->db->join('landing.landing_template c', 'c.landing_template_id = b.id_landing_template', 'left');

        if (isset($param['id_landing'])) $this->db->where('a.id_landing', $param['id_landing']);
        if (isset($param['landing_detail_id'])) $this->db->where('a.landing_detail_id', $param['landing_detail_id']);
        if (isset($param['landing_tipe'])) $this->db->where('b.landing_tipe', $param['landing_tipe']);
        if (isset($param['landing_template_tipe'])) $this->db->where('c.landing_template_tipe', $param['landing_template_tipe']);
        // $this->db->where('a.landing_detail_status', 'y');
        $this->db->order_by('landing_urut', 'asc');
        $query = $this->db->get();
        return (isset($param['landing_detail_id'])) ? $query->row_array() : $query->result_array();
    }

    public function getLandingTemplate($param = null)
    {
        $this->db->select('*');
        $this->db->from('landing.landing_template a');
        if (isset($param['landing_template_nama'])) $this->db->like('upper(landing_template_nama)', strtoupper($param['landing_template_nama']));
        if (isset($param['landing_template_id'])) $this->db->where('landing_template_id', $param['landing_template_id']);



        $query = $this->db->get();
        return (isset($param['landing_template_id'])) ? $query->row_array() : $query->result_array();
    }

    public function insertLanding($param = null)
    {
        $this->db->insert('landing.landing', $param);
        return $this->db->affected_rows();
    }

    public function updateLanding($id, $param = null)
    {
        $this->db->where('landing_id', $id);
        $this->db->update('landing.landing', $param);

        return $this->db->affected_rows();
    }

    public function deleteLanding($id)
    {
        $this->db->where('landing_id', $id);
        $this->db->delete('landing.landing');

        return $this->db->affected_rows();
    }

    public function insertLandingDetail($param = null)
    {
        $this->db->insert('landing.landing_detail', $param);
        return $this->db->affected_rows();
    }

    public function updateLandingDetail($id, $param = null)
    {
        $this->db->where('landing_detail_id', $id);
        $this->db->update('landing.landing_detail', $param);
        return $this->db->affected_rows();
    }

    public function deleteLandingDetail($id)
    {
        $this->db->where('landing_detail_id', $id);
        $this->db->delete('landing.landing_detail');
        return $this->db->affected_rows();
    }
}

/* End of file M_landing.php */
