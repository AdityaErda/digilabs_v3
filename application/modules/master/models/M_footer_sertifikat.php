<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_footer_sertifikat extends CI_Model
{
    /* Get */
    public function getFooterSertifikat($data = null)
    {
        $this->db->select('*');
        $this->db->from('sample.sample_footer_sertifikat');


        if(isset($data['bahasa'])){
            if($data['bahasa']=='I'){
                $this->db->where('is_bahasa', 'y');
            }else if($data['bahasa']=='E'){
                $this->db->where('is_bahasa', NULL);
            }
        }

        if (isset($data['footer_id'])) $this->db->where('footer_id', $data['footer_id']);

        // for live search
        if (isset($data['params_search'])) $this->db->like('footer_isi', $data['params_search'], 'ESCAPE');
        // for live search

        $this->db->order_by('footer_isi', 'ASC');
        $sql = $this->db->get();

        return (isset($data['footer_id'])) ? $sql->row_array() : $sql->result_array();
    }
    /* Get */

    /* Insert */
    public function insertFooterSertifikat($data)
    {
        $this->db->insert('sample.sample_footer_sertifikat', $data);

        return $this->db->affected_rows();
    }
    /* Insert */

    /* Update */
    public function updateFooterSertifikat($data, $id)
    {
        $this->db->set($data);
        $this->db->where('footer_id', $id);
        $this->db->update('sample.sample_footer_sertifikat');

        return $this->db->affected_rows();
    }
    /* Update */

    /* Delete */
    public function deleteFooterSertifikat($id)
    {
        $this->db->where('footer_id', $id);
        $this->db->delete('sample.sample_footer_sertifikat');

        return $this->db->affected_rows();
    }
    /* Delete */
}
