<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sertifikat extends MY_Controller
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
        $this->load->view('master/sertifikat');
        $this->load->view('tampilan/footer');
        $this->load->view('master/sertifikat_js');
    }
    /* Index */

    /* Get */
    public function getTemplateSertifikat()
    {
        $param = array(
            'sertifikat_id' => $this->input->get_post('sertifikat_id'),
        );

        $data = $this->M_sertifikat->getTemplateSertifikat($param);

        echo json_encode($data);
    }

    public function getLogSheet()
    {
        $jenisLogsheet['results'] = array();

        $param['template_logsheet_nama'] = $this->input->get('template_logsheet_nama');
        foreach ($this->M_sertifikat->getLogSheet($param) as $key => $value) {
            array_push($jenisLogsheet['results'], [
                'id' => $value['template_logsheet_id'],
                'text' => $value['template_logsheet_nama'],
            ]);
        }

        echo json_encode($jenisLogsheet);
    }
    /* Get */

    /* Insert */
    public function insertTemplateSertifikat()
    {
        $isi = $this->session->userdata();

        $data['sertifikat_id'] = create_id();
        $data['sertifikat_nama'] = $this->input->post('sertifikat_nama');
        $data['id_template_logsheet'] = $this->input->post('id_template_logsheet');
        $data['when_create'] = date('Y-m-d H:i:s');
        $data['who_create'] = $isi['user_nama_lengkap'];

        $this->M_sertifikat->insertTemplateSertifikat($data);
    }
    /* Insert */

    /* Update */
    public function updateTemplateSertifikat()
    {
        $isi = $this->session->userdata();

        $id = $this->input->post('sertifikat_id');
        $data = array(
            // 'sertifikat_nama' => $this->input->post('sertifikat_nama'),
            'id_template_logsheet' => $this->input->post('id_template_logsheet'),
            'when_create' => date('Y-m-d H:i:s'),
            'who_create' => $isi['user_nama_lengkap'],
        );

        $this->M_sertifikat->updateTemplateSertifikat($data, $id);
    }
    /* Update */

    /* Delete */
    public function deleteTemplateSertifikat()
    {
        $this->M_sertifikat->deleteTemplateSertifikat($this->input->get('sertifikat_id'));
    }
    /* Delete */

    /* Get Detail */
    public function getDetailSertifikat()
    {
        $param = array();

        if ($this->input->get('id_template_sertifikat')) $param['id_template_sertifikat'] = $this->input->get('id_template_sertifikat');
        if ($this->input->get('sertifikat_template_detail_id')) $param['sertifikat_template_detail_id'] = $this->input->get('sertifikat_template_detail_id');

        $data = $this->M_sertifikat->getDetailSertifikat($param);

        echo json_encode($data);
    }

    public function getHeaderTabelSertifikat()
    {
        $jenisLogsheet['results'] = array();

        $param['template_sertifikat_header_nama'] = $this->input->get('template_sertifikat_header_nama');
        foreach ($this->M_sertifikat->getHeaderTabelSertifikat($param) as $key => $value) {
            array_push($jenisLogsheet['results'], [
                'id' => $value['template_sertifikat_header_id'],
                'text' => $value['template_sertifikat_header_nama'],
            ]);
        }

        echo json_encode($jenisLogsheet);
    }
    /* Get Detail */

    /* Insert Detail */
    public function insertTemplateSertifikatDetail()
    {
        $isi = $this->session->userdata();

        $data['sertifikat_template_detail_id'] = create_id();
        $data['id_template_sertifikat'] = $this->input->post('temp_sertifikat_id');
        $data['id_template_sertifikat_header'] = $this->input->post('id_template_sertifikat_header');
        $data['sertifikat_template_detail_urut'] = $this->input->post('sertifikat_template_detail_urut');
        $data['when_create'] = date('Y-m-d H:i:s');
        $data['who_create'] = $isi['user_nama_lengkap'];

        $this->M_sertifikat->insertTemplateSertifikatDetail($data);
    }
    /* Insert Detail */

    /* Update Detail */
    public function updateTemplateSertifikatDetail()
    {
        $isi = $this->session->userdata();

        $id = $this->input->post('sertifikat_template_detail_id');
        $data = array(
            'id_template_sertifikat' => $this->input->post('temp_sertifikat_id'),
            'id_template_sertifikat_header' => $this->input->post('id_template_sertifikat_header'),
            'sertifikat_template_detail_urut' => $this->input->post('sertifikat_template_detail_urut'),
            'when_create' => date('Y-m-d H:i:s'),
            'who_create' => $isi['user_nama_lengkap'],
        );

        $this->M_sertifikat->updateTemplateSertifikatDetail($data, $id);
    }
    /* Update Detail */

    /* Delete Detail*/
    public function deleteTemplateSertifikatDetail()
    {
        $this->M_sertifikat->deleteTemplateSertifikatDetail($this->input->get('sertifikat_template_detail_id'));
    }
    /* Delete Detail */
}
