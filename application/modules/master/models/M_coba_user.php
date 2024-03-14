<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_coba_user extends CI_Model
{
    /* GET */
    public function getUser($data = null)
    {
        $this->db->select('a.*, b.role_id, b.role_nama, c.seksi_id, c.seksi_nama');
        $this->db->from('global.global_coba_user a');
        $this->db->join('global.global_role b', 'a.role_id = b.role_id', 'left');
        $this->db->join('global.global_coba_seksi c', 'a.id_seksi = c.seksi_id', 'left');
        if (isset($data['user_id'])) $this->db->where('user_id', $data['user_id']);
        if (isset($data['id_seksi'])) $this->db->where('id_seksi', $data['id_seksi']);
        if (isset($data['user_nama_lengkap'])) $this->db->where("upper(user_nama_lengkap) LIKE '%" . strtoupper($data['user_nama_lengkap']) . "%'");
        $sql = $this->db->get();

        return (isset($data['user_id'])) ? $sql->row_array() : $sql->result_array();
    }
    /* GET */

    /* INSERT */
    public function insertUser($data)
    {
        $this->db->insert('global.global_coba_user', $data);

        return $this->db->affected_rows();
    }
    /* INSERT */

    /* UPDATE */
    public function updateUser($data, $id)
    {
        $this->db->set($data);
        $this->db->where('user_id', $id);
        $this->db->update('global.global_coba_user');

        return $this->db->affected_rows();
    }
    /* UPDATE */

    /* DELETE */
    public function deleteUser($id)
    {
        $this->db->where('user_id', $id);
        $this->db->delete('global.global_coba_user');

        return $this->db->affected_rows();
    }
    /* DELETE */

    /* GET SEKSI */
    public function getSeksi($data = null)
    {
        $this->db->select('*');
        $this->db->from('global.global_coba_seksi a');
        if (isset($data['seksi_nama'])) $this->db->where("upper(seksi_nama) LIKE '%" . strtoupper($data['seksi_nama']) . "%'");
        if (isset($data['seksi_id'])) $this->db->where('seksi_id', $data['seksi_id']);
        $sql = $this->db->get();

        return (isset($data['seksi_id'])) ? $sql->row_array() : $sql->result_array();
    }
    /* GET SEKSI */

    /* INSERT SEKSI */
    public function insertSeksi($data)
    {
        $this->db->insert('global.global_coba_seksi', $data);

        return $this->db->affected_rows();
    }
    /* INSERT SEKSI */

    /* UPDATE SEKSI */
    public function updateSeksi($data, $id)
    {
        $this->db->set($data);
        $this->db->where('seksi_id', $id);
        $this->db->update('global.global_coba_seksi');

        return $this->db->affected_rows();
    }
    /* UPDATE SEKSI */

    /* DELETE SEKSI */
    public function deleteSeksi($id)
    {
        $this->db->where('seksi_id', $id);
        $this->db->delete('global.global_coba_seksi');

        return $this->db->affected_rows();
    }
    /* DELETE SEKSI */

    /* DELETE TABLE SEKSI */
    public function deleteTableSeksi($id)
    {
        $this->db->where('import_kode', $id);
        $this->db->delete('import.import_global_seksi');

        return $this->db->affected_rows();
    }
    /* DELETE TABLE SEKSI */

    /* DELETE TABLE */
    public function deleteTable($id)
    {
        $this->db->where('import_kode', $id);
        $this->db->delete('import.import_global_user');

        return $this->db->affected_rows();
    }
    /* DELETE TABLE */
}
