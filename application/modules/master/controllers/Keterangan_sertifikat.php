<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Keterangan_sertifikat extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('master/M_keterangan_sertifikat');
    }

    public function index()
    {
        $isi['judul'] = 'Ketarangan Sertifikat';
        $data = $this->session->userdata();
        $data['id_sidebar'] = $this->input->get('id_sidebar');
        $data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

        $this->load->view('tampilan/header', $isi);
        $this->load->view('tampilan/sidebar', $data);
        $this->load->view('master/keterangan_sertifikat');
        $this->load->view('tampilan/footer');
        $this->load->view('master/keterangan_sertifikat_js');
    }

    public function getKeteranganSertifikat($data = null)
    {
        $param = array(
            'keterangan_sertifikat_id' => $this->input->get_post('keterangan_sertifikat_id'),
        );
        $data = $this->M_keterangan_sertifikat->getKeteranganSertifikat($param);

        echo json_encode($data);
    }

    public function insertKeteranganSertifikat()
    {
        $isi = $this->session->userdata();

        $data['keterangan_sertifikat_id'] = create_id();
        $data['keterangan_sertifikat_isi'] = anti_inject($this->input->post('keterangan_sertifikat_isi'));

        $this->M_keterangan_sertifikat->insertKeteranganSertifikat($data);
    }

    public function updateKeteranganSertifikat()
    {
        $isi = $this->session->userdata();

        $id = anti_inject($this->input->post('keterangan_sertifikat_id'));
        $data = array(
            'keterangan_sertifikat_isi' => anti_inject($this->input->get_post('keterangan_sertifikat_isi')),
        );

        $this->M_keterangan_sertifikat->updateKeteranganSertifikat($data, $id);
    }

    public function deleteKeteranganSertifikat()
    {
        $this->M_keterangan_sertifikat->deleteKeteranganSertifikat($this->input->get('keterangan_sertifikat_id'));
    }

    public function getKeteranganSertifikatList()
    {
        $ListKeteranganSertifikat['results'] = array();
        $param['params_search'] = $this->input->get('params_search');
        foreach ($this->M_keterangan_sertifikat->getKeteranganSertifikat($param) as $key => $value) {
            array_push($ListKeteranganSertifikat['results'], [
                'id' => $value['keterangan_sertifikat_id'],
                'text' => $value['keterangan_sertifikat_isi']
            ]);
        }

        echo json_encode($ListKeteranganSertifikat);
    }
}
