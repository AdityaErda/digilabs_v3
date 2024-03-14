<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Coba_barang extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('master/M_coba_jenis');
    }

    /* INDEX */
    public function index()
    {
        $isi['judul'] = 'Coba Barang';
        $data = $this->session->userdata();
        $data['id_sidebar'] = $this->input->get('id_sidebar');
        $data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

        $this->load->view('tampilan/header', $isi);
        $this->load->view('tampilan/sidebar', $data);
        $this->load->view('master/coba');
        $this->load->view('tampilan/footer');
        $this->load->view('master/coba_barang_js');
    }
    /* INDEX */

    // /* GET */
    public function getCobaBarang()
    {
        $param['jenis_id'] = $this->input->get('jenis_id');

        $data = $this->M_coba_jenis->getCobaBarang($param);
        echo json_encode($data);
    }
    // /* GET */

    /* INSERT */
    public function insertCobaBarang()
    {
        $isi = $this->session->userdata();

        $data['jenis_id'] = create_id();
        $data['jenis_kode'] = $this->input->post('jenis_kode');
        $data['jenis_nama'] = $this->input->post('jenis_nama');
        $data['when_create'] = date('Y-m-d H:i:s');
        $data['who_create'] = $isi['user_nama_lengkap'];

        $this->M_coba_jenis->insertCobaBarang($data);
    }
    /* INSERT */

    /* UPDATE */
    public function updateCobaBarang()
    {
        $isi = $this->session->userdata();
        $id = $this->input->post('jenis_id');
        $data = array(
            'jenis_kode' => $this->input->post('jenis_kode'),
            'jenis_nama' => $this->input->post('jenis_nama'),
            'when_create' => date('Y-m-d H:i:s'),
            'who_create' => $isi['user_nama_lengkap'],
        );

        $this->M_coba_jenis->updateCobaBarang($data, $id);
    }
    /* UPDATE */

    /* DELETE */
    public function deleteCobaBarang()
    {
        $this->M_coba_jenis->deleteCobaBarang($this->input->get('jenis_id'));
    }
    /* DELETE */

    /* RESET */
    public function resetCobaBarang()
    {
        $this->M_coba_jenis->resetCobaBarang();
    }
    /* RESET */

    /* INDEX IMPORT */
    public function index_import()
    {
        $isi['judul'] = 'Import Jenis Barang';
        $data = $this->session->userdata();
        $data['id_sidebar'] = $this->input->get('id_sidebar');
        $data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

        $this->load->view('tampilan/header', $isi);
        $this->load->view('tampilan/sidebar', $data);
        $this->load->view('master/coba_barang_import');
        $this->load->view('tampilan/footer');
        $this->load->view('master/coba_barang_import_js');
    }
    /* INDEX IMPORT */

    /* GET IMPORT */
    public function getImport()
    {
        $param['import_kode'] = $this->input->get('import_kode');

        $data = $this->M_coba_jenis->getImport($param);
        echo json_encode($data);
    }
    /* GET IMPORT */

    /* INSERT IMPORT */
    public function insertImport()
    {
        $data_session = $this->session->userdata();

        $config = array(
            'upload_path'   => FCPATH . 'upload/',
            'allowed_types' => 'xls|csv'
        );
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('file')) {
            $data = $this->upload->data();
            @chmod($data['full_path'], 0777);

            $this->load->library('Spreadsheet_Excel_Reader');
            $this->spreadsheet_excel_reader->setOutputEncoding('CP1251');
            $this->db->db_set_charset('latin1', 'latin1_swedish_ci');

            $this->spreadsheet_excel_reader->read($data['full_path']);
            $sheets = $this->spreadsheet_excel_reader->sheets[0];
            error_reporting(0);

            $data_excel = array();
            $id = create_id();
            for ($i = 2; $i <= $sheets['numRows']; $i++) {
                if ($sheets['cells'][$i][1] == '') break;

                $data_excel[$i - 1]['import_kode']    = $id;
                $data_excel[$i - 1]['jenis_id']    = create_id();
                $data_excel[$i - 1]['jenis_kode']  = $sheets['cells'][$i][1];
                $data_excel[$i - 1]['jenis_nama']  = $sheets['cells'][$i][2];
                $data_excel[$i - 1]['when_create']  = date('Y-m-d H:i:s');
                $data_excel[$i - 1]['who_create']  = $data_session['user_nama_lengkap'];
            }

            $this->db->insert_batch('import.import_material_jenis', $data_excel);

            header("Location: " . base_url('master/coba_barang_import/index_import?header_menu=0&menu_id=0&import_kode=' . $id));
        }
    }

    public function insertTable()
    {
        $param['import_kode'] = $this->input->get('import_kode');
        $this->M_coba_jenis->insertTable($param);
        $this->M_coba_jenis->deleteTable($this->input->get('import_kode'));

        header("Location: " . base_url('master/coba_barang/index?header_menu=0&menu_id=0'));
    }
    /* INSERT IMPORT */
}
