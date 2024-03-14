<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Coba_User extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('master/M_coba_user');
        $this->load->model('master/M_role');
    }

    public function index()
    {
        $isi['judul'] = 'User Coba';
        $data = $this->session->userdata();
        $data['id_sidebar'] = $this->input->get('id_sidebar');
        $data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

        $this->load->view('tampilan/header', $isi);
        $this->load->view('tampilan/sidebar', $data);
        $this->load->view('master/coba_user');
        $this->load->view('tampilan/footer');
        $this->load->view('master/coba_user_js');
    }

    /* GET */
    public function getUser()
    {
        $param['user_id'] = $this->input->get('user_id');
        $param['id_seksi'] = $this->input->get('id_seksi');

        $data = $this->M_coba_user->getUser($param);
        echo json_encode($data);
    }

    public function getRole()
    {
        $listRole['results'] = array();

        $param['role_nama'] = $this->input->get('role_nama');
        foreach ($this->M_role->getRole($param) as $key => $value) {
            array_push($listRole['results'], [
                'id' => $value['role_id'],
                'text' => $value['role_nama'],
            ]);
        }

        echo json_encode($listRole);
    }

    public function getSeksiUser()
    {
        $listSeksi['results'] = array();

        $param['seksi_nama'] = $this->input->get('seksi_nama');
        foreach ($this->M_coba_user->getSeksi($param) as $key => $value) {
            array_push($listSeksi['results'], [
                'id' => $value['seksi_id'],
                'text' => $value['seksi_nama'],
            ]);
        }

        echo json_encode($listSeksi);
    }
    /* GET */

    /* INSERT */
    public function insertUser()
    {
        $isi = $this->session->userdata();

        $data['user_id'] = create_id();
        $data['role_id'] = $this->input->post('role_id');
        $data['id_seksi'] = $this->input->post('id_seksi');
        $data['user_nama_lengkap'] = $this->input->post('user_nama_lengkap');
        $data['user_tempat_lahir'] = $this->input->post('user_tempat_lahir');
        $data['user_tgl_lahir'] = date('Y-m-d', strtotime($this->input->post('user_tgl_lahir')));
        $data['user_username'] = $this->input->post('user_username');
        $data['user_password'] = md5($this->input->post('user_password'));
        $data['when_create'] = date('Y-m-d H:i:s');
        $data['who_create'] = $isi['user_nama_lengkap'];

        $this->M_coba_user->insertUser($data);
    }
    /* INSERT */

    /* UPDATE */
    public function updateUser()
    {
        $isi = $this->session->userdata();

        $id = $this->input->post('user_id');
        $password = ($this->input->post('user_password') == $this->input->post('user_password_lama')) ? $this->input->post('user_password') : md5($this->input->post('user_password'));
        $data = array(
            'role_id' => $this->input->post('role_id'),
            'id_seksi' => $this->input->post('seksi_id_user'),
            'user_nama_lengkap' => $this->input->post('user_nama_lengkap'),
            'user_tempat_lahir' => $this->input->post('user_tempat_lahir'),
            'user_tgl_lahir' => date('Y-m-d', strtotime($this->input->post('user_tgl_lahir'))),
            'user_username' => $this->input->post('user_username'),
            'user_password' => $password,
            'when_create' => date('Y-m-d H:i:s'),
            'who_create' => $isi['user_nama_lengkap'],
        );

        $this->M_coba_user->updateUser($data, $id);
    }
    /* UPDATE */

    /* DELETE */
    public function deleteUser()
    {
        $this->M_coba_user->deleteUser($this->input->get('user_id'));
    }
    /* DELETE */

    /* GET SEKSI */
    public function getSeksi()
    {
        $param['seksi_id'] = $this->input->get('seksi_id');
        $param['seksi_nama'] = $this->input->get('seksi_nama');

        $data = $this->M_coba_user->getSeksi($param);
        echo json_encode($data);
    }
    /* GET SEKSI */

    /* INSERT SEKSI */
    public function insertSeksi()
    {
        $isi = $this->session->userdata();

        $data['seksi_id'] = create_id();
        $data['seksi_kode'] = $this->input->post('seksi_kode');
        $data['seksi_nama'] = $this->input->post('seksi_nama');
        $data['is_disposisi'] = $this->input->post('is_disposisi');
        $data['when_create'] = date('Y-m-d H:i:s');
        $data['who_create'] = $isi['user_nama_lengkap'];

        $this->M_coba_user->insertSeksi($data);
    }
    /* INSERT SEKSI */

    /* UPDATE SEKSI */
    public function updateSeksi()
    {
        $isi = $this->session->userdata();

        $id = $this->input->post('seksi_id');
        $data = array(
            'seksi_kode' => $this->input->post('seksi_kode'),
            'seksi_nama' => $this->input->post('seksi_nama'),
            'is_disposisi' => $this->input->post('is_disposisi'),
            'when_create' => date('Y-m-d H:i:s'),
            'who_create' => $isi['user_nama_lengkap'],
        );

        $this->M_coba_user->updateSeksi($data, $id);
    }
    /* UPDATE SEKSI */

    /* DELETE SEKSI */
    public function deleteSeksi()
    {
        $this->M_coba_user->deleteSeksi($this->input->get('seksi_id'));
    }
    /* DELETE SEKSI */

    public function insertTableSeksi()
    {
        $param['import_kode'] = $this->input->get('import_kode');
        $this->M_coba_user->insertTableSeksi($param);
        $this->M_coba_user->deleteTableSeksi($this->input->get('import_kode'));

        header("Location: " . base_url('master/coba_user/index?header_menu=0&menu_id=0'));
    }
    /* INSERT IMPORT SEKSI */
}
