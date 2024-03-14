<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Header_tabel_sertifikat extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('master/M_sertifikat');
    }

    /* Index */
    public function index()
    {
        $isi['judul'] = 'Template Sertifikat';
        $data = $this->session->userdata();
        $data['id_sidebar'] = $this->input->get('id_sidebar');
        $data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

        $this->load->view('tampilan/header', $isi);
        $this->load->view('tampilan/sidebar', $data);
        $this->load->view('master/header_tabel_sertifikat');
        $this->load->view('tampilan/footer');
        $this->load->view('master/header_tabel_sertifikat_js');
    }
    /* Index */

    /* Get */
    public function getHeaderTabelSertifikat()
    {
        $param = array(
            'template_sertifikat_header_id' => $this->input->get_post('template_sertifikat_header_id'),
        );

        $data = $this->M_sertifikat->getHeaderTabelSertifikat($param);

        echo json_encode($data);
    }
    /* Get */

    /* Insert */
    public function insertHeaderTabelSertifikat()
    {
        $isi = $this->session->userdata();

        $data['template_sertifikat_header_id'] = create_id();
        $data['template_sertifikat_header_nama'] = $this->input->post('template_sertifikat_header_nama');
        $data['when_create'] = date('Y-m-d H:i:s');
        $data['who_create'] = $isi['user_nama_lengkap'];

        $this->M_sertifikat->insertHeaderTabelSertifikat($data);
    }
    /* Insert */

    /* Update */
    public function updateHeaderTabelSertifikat()
    {
        $isi = $this->session->userdata();

        $id = $this->input->post('template_sertifikat_header_id');
        $data = array(
            'template_sertifikat_header_nama' => $this->input->post('template_sertifikat_header_nama'),
            'when_create' => date('Y-m-d H:i:s'),
            'who_create' => $isi['user_nama_lengkap'],
        );

        $this->M_sertifikat->updateHeaderTabelSertifikat($data, $id);
    }
    /* Update */

    /* Delete */
    public function deleteHeaderTabelSertifikat()
    {
        $this->M_sertifikat->deleteHeaderTabelSertifikat($this->input->get('template_sertifikat_header_id'));
    }
    /* Delete */
}
