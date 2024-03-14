<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Perhitungan_sample extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        isLogin();
        $this->load->model('master/M_perhitungan_sample');
    }

    /* INDEX */
    public function index()
    {
        $isi['judul'] = 'Perhitungan Rumus Sample';
        $data = $this->session->userdata();
        $data['id_sidebar'] = $this->input->get('id_sidebar');
        $data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

        $this->load->view('tampilan/header', $isi);
        $this->load->view('tampilan/sidebar', $data);
        $this->load->view('master/perhitungan_sample');
        $this->load->view('tampilan/footer');
        $this->load->view('master/perhitungan_sample_js');
    }
    /* INDEX */

    /* GET */
    public function getPerhitunganSample()
    {
        $session = $this->session->userdata();
        $param = [];
        if ($session['role_id'] != '1') {
            $param['who_seksi_create_id'] = $session['id_seksi'];
        }
        if ($this->input->get_post('rumus_id')) {
            $param['rumus_id'] = anti_inject_replace($this->input->get_post('rumus_id'));
        }
        if ($this->input->get_post('id_rumus')) {
            $param['id_rumus'] = anti_inject_replace($this->input->get_post('id_rumus'));
        }

        $data = $this->M_perhitungan_sample->getPerhitunganSample($param);
        // echo $this->db->last_query();

        echo json_encode($data);
    }

    public function getJenisSample()
    {
        $listJenis['results'] = array();
        $param = [];
        if ($this->input->get_post('jenis_nama')) {
            $param['jenis_nama'] = anti_inject_replace($this->input->get('jenis_nama'));
        }
        foreach ($this->M_perhitungan_sample->getJenisSample($param) as $key => $value) {
            array_push($listJenis['results'], [
                'id' => $value['jenis_id'],
                'text' => $value['jenis_nama'],
            ]);
        }

        echo json_encode($listJenis);
    }

    public function getListRumus()
    {
        $rumus['rumus_detail_input'] = $this->input->get('rumus_detail_input');
        $param['id_rumus'] = $this->input->get('id_rumus');
        $param['rumus_detail_id'] = $this->input->get('rumus_detail_id');
        $data = $this->M_perhitungan_sample->getListRumus($param);

        foreach ($data as $key => $value) {
            $rumus[] = ($value['rumus_detail_nama'] != null) ? $value['rumus_detail_nama'] : $value['rumus_detail_input'];
        }

        $hasil[]['rumus'] = implode(' ', $rumus);
        echo json_encode($hasil);
    }

    public function getMaksTemplate()
    {
        $sql = $this->db->query("SELECT MAX(CAST(rumus_detail_template AS INT)) as terakhir FROM sample.sample_perhitungan_sample_detail WHERE id_rumus = '" . $this->input->get_post('id_rumus') . "'");
        $data = $sql->row_array();
        $baru['last'] = $data['terakhir'] + 1;
        echo json_encode($baru);
    }
    /* GET */

    /* INSERT */
    public function insertPerhitunganSample()
    {
        $session = $this->session->userdata();

        $desimal_angka = ($this->input->post('desimal_angka') != FALSE) ? anti_inject($this->input->post('desimal_angka')) : NULL;

        $seksi = $this->db->get_where('global.global_seksi', array('seksi_id' => $session['id_seksi']))->row_array();

        $data['rumus_id'] = create_id();
        $data['jenis_id'] = anti_inject($this->input->get_post('jenis_id'));
        $data['rumus_nama'] = anti_inject($this->input->get_post('rumus_nama'));
        $data['when_create'] = date('Y-m-d H:i:s');
        $data['who_create'] = $session['user_nama_lengkap'];
        $data['is_aktif'] = anti_inject($this->input->get_post('is_aktif'));
        $data['is_adbk'] = anti_inject($this->input->get_post('is_adbk'));
        $data['desimal_angka'] = $desimal_angka;
        $data['satuan_sample'] = anti_inject($this->input->get_post('satuan_sample'));
        $data['batasan_emisi'] = anti_inject($this->input->get_post('batasan_emisi'));
        $data['metode'] = anti_inject($this->input->get_post('metode'));
        $data['who_seksi_create_id'] = $session['id_seksi'];
        $data['who_seksi_create_name'] = $seksi['seksi_nama'];

        $this->M_perhitungan_sample->insertPerhitunganSample($data);
    }
    /* INSERT */

    /* UPDATE */
    public function updatePerhitunganSample()
    {
        $isi = $this->session->userdata();

        $desimal_angka = ($this->input->post('desimal_angka') != FALSE) ? $this->input->post('desimal_angka') : NULL;
        $batasan_emisi = ($this->input->post('batasan_emisi') != FALSE) ? $this->input->post('batasan_emisi') : NULL;

        $id = $this->input->post('rumus_id');
        $data = array(
            'rumus_nama' => anti_inject($this->input->get_post('rumus_nama')),
            'jenis_id' => anti_inject($this->input->get_post('jenis_id')),
            'when_create' => date('Y-m-d H:i:s'),
            'who_create' => $isi['user_nama_lengkap'],
            'is_aktif' => anti_inject($this->input->get_post('is_aktif')),
            'is_adbk' => anti_inject($this->input->get_post('is_adbk')),
            'desimal_angka' => $desimal_angka,
            'satuan_sample' => anti_inject($this->input->get_post('satuan_sample')),
            'batasan_emisi' => $batasan_emisi,
            'metode' => anti_inject($this->input->get_post('metode')),
        );

        $this->M_perhitungan_sample->updatePerhitunganSample($data, $id);
    }
    /* UPDATE */

    /* DELETE */
    public function deletePerhitunganSample()
    {
        $this->M_perhitungan_sample->deletePerhitunganSample($this->input->get('rumus_id'));
    }

    /* GET DETAIL */
    public function getDetailRumusSample()
    {
        $param = array();

        if ($this->input->get('id_rumus')) $param['id_rumus'] = $this->input->get('id_rumus');
        if ($this->input->get('rumus_detail_id')) $param['rumus_detail_id'] = $this->input->get('rumus_detail_id');
        if ($this->input->post('rumus_detail_nama')) $param['rumus_detail_nama'] = $this->input->post('rumus_detail_nama');

        $data = $this->M_perhitungan_sample->getDetailRumusSample($param);
        // echo $this->db->last_query($data);

        echo json_encode($data);
    }
    /* GET DETAIL */

    /* GET DETAIL TEMPLATE */
    public function getDetailRumusSampleTemplate()
    {
        $param = array();

        if ($this->input->get('id_rumus')) $param['id_rumus'] = $this->input->get('id_rumus');
        if ($this->input->get('rumus_detail_id')) $param['rumus_detail_id'] = $this->input->get('rumus_detail_id');
        if ($this->input->post('rumus_detail_nama')) $param['rumus_detail_nama'] = $this->input->post('rumus_detail_nama');

        $data = $this->M_perhitungan_sample->getDetailRumusSampleTemplate($param);
        // echo $this->db->last_query();


        echo json_encode($data);
    }

    public function getUrutanTemplate($value = '')
    {
        $select = "rumus_detail_id, id_rumus, rumus_detail_template";
        $where = array('rumus_detail_template' => $this->input->get('rumus_detail_template'), 'id_rumus' => $this->input->get('rumus_id'));
        $data = $this->M_perhitungan_sample->getUrutanTemplate($select, $where, null, null, null)->row();
        if (!empty($data)) {
            $error['field_name'] = 'rumus_detail_template';
            $error['msg'] = "Urutan Template Sudah Ada !!";

            echo json_encode($error);
        }
    }
    /* GET DETAIL TEMPLATE */

    /* INSERT DETAIL */
    public function insertPerhitunganSampleDetail()
    {
        $isi = $this->session->userdata();

        $rumus_detail_input = ($this->input->post('rumus_detail_input') != FALSE) ? $this->input->post('rumus_detail_input') : NULL;
        $rumus_detail_template = ($this->input->post('rumus_detail_template') != FALSE) ? $this->input->post('rumus_detail_template') : NULL;
        $rumus_detail_urut = ($this->input->post('rumus_detail_urut') != FALSE) ? $this->input->post('rumus_detail_urut') : NULL;

        $data['rumus_detail_id'] = create_id();
        $data['id_rumus'] = $this->input->post('temp_rumus_id');
        $data['rumus_detail_urut'] = $rumus_detail_urut;
        $data['rumus_detail_template'] = $rumus_detail_template;
        $data['rumus_detail_nama'] = $this->input->post('rumus_detail_nama');
        $data['rumus_detail_input'] = $rumus_detail_input;
        $data['rumus_jenis'] = $this->input->post('rumus_jenis');
        $data['when_create'] = date('Y-m-d H:i:s');
        $data['who_create'] = $isi['user_nama_lengkap'];

        $this->M_perhitungan_sample->insertPerhitunganSampleDetail($data);
    }
    /* INSERT DETAIL */

    /* UPDATE DETAIL */
    public function updatePerhitunganSampleDetail()
    {
        $isi = $this->session->userdata();

        $rumus_detail_template = ($this->input->post('rumus_detail_template') != FALSE) ? $this->input->post('rumus_detail_template') : NULL;
        $rumus_detail_input = ($this->input->post('rumus_detail_input') != FALSE) ? $this->input->post('rumus_detail_input') : NULL;

        $id = $this->input->post('rumus_detail_id');
        $data = array(
            'id_rumus' => $this->input->post('temp_rumus_id'),
            'rumus_detail_urut' => $this->input->post('rumus_detail_urut'),
            'rumus_detail_template' => $rumus_detail_template,
            'rumus_detail_nama' => $this->input->post('rumus_detail_nama'),
            'rumus_detail_input' => $rumus_detail_input,
            'rumus_jenis' => $this->input->post('rumus_jenis'),
            'when_create' => date('Y-m-d H:i:s'),
            'who_create' => $isi['user_nama_lengkap'],
        );

        $this->M_perhitungan_sample->updatePerhitunganSampleDetail($data, $id);
    }
    /* UPDATE DETAIL */

    /* DELETE DETAIL */
    public function deletePerhitunganSampleDetail()
    {
        $this->M_perhitungan_sample->deletePerhitunganSampleDetail($this->input->get('rumus_detail_id'));
    }
    /* DELETE DETAIL */

    /* INDEX IMPORT */
    public function index_import()
    {
        $isi['judul'] = 'Import Perhitungan Rumus Sample';
        $data = $this->session->userdata();
        $data['id_sidebar'] = $this->input->get('id_sidebar');
        $data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

        $this->load->view('tampilan/header', $isi);
        $this->load->view('tampilan/sidebar', $data);
        $this->load->view('master/perhitungan_sample_import');
        $this->load->view('tampilan/footer');
        $this->load->view('master/perhitungan_sample_import_js');
    }
    /* INDEX IMPORT */

    /* GET IMPORT */
    public function getImport()
    {
        $param['import_kode'] = $this->input->get('import_kode');

        $data = $this->M_perhitungan_sample->getImport($param);

        echo json_encode($data);
    }
    /* GET IMPORT */

    /* INSERT IMPORT */
    public function insertImport()
    {
        ini_set('display_errors', 1);
        error_reporting(E_ALL);

        $data_session = $this->session->userdata();

        $config = array(
            'upload_path'   => FCPATH . '/upload/',
            'allowed_types' => 'xls|csv'
        );

        $this->upload->initialize($config);

        if ($this->upload->do_upload('file_import')) {
            $data = $this->upload->data();
            @chmod($data['full_path'], 0777);

            $this->load->library('Spreadsheet_Excel_Reader');
            $this->spreadsheet_excel_reader->setOutputEncoding('CP1251');
            $this->db->db_set_charset('latin1', 'latin1_swedish_ci');

            $this->spreadsheet_excel_reader->read($data['full_path']);
            $sheets = $this->spreadsheet_excel_reader->sheets[0];


            $data_excel = array();
            $id = create_id();
            for ($i = 2; $i <= $sheets['numRows']; $i++) {
                if ($sheets['cells'][$i][1] == '') break;

                $param_pekerjaan['jenis_nama'] = $sheets['cells'][$i][2];
                $isiPekerjaan = $this->M_perhitungan_sample->getJenisSample($param_pekerjaan);

                $data_excel[$i - 1]['import_kode']    = $id;
                $data_excel[$i - 1]['rumus_id']    = create_id();
                $data_excel[$i - 1]['rumus_nama']  = $sheets['cells'][$i][1];
                $data_excel[$i - 1]['jenis_id'] = $isiPekerjaan[0]['jenis_id'];
                $data_excel[$i - 1]['desimal_angka']  = $sheets['cells'][$i][3];
                $data_excel[$i - 1]['is_aktif']  = $sheets['cells'][$i][4];
                $data_excel[$i - 1]['is_adbk']  = $sheets['cells'][$i][5];
                $data_excel[$i - 1]['satuan_sample']  = $sheets['cells'][$i][6];
                $data_excel[$i - 1]['when_create']  = date('Y-m-d H:i:s');
                $data_excel[$i - 1]['who_create']  = $data_session['user_nama_lengkap'];
            }

            $this->db->insert_batch('import.import_sample_perhitungan_sample', $data_excel);

            header("Location: " . base_url('master/perhitungan_sample/index_import?header_menu=0&menu_id=0&import_kode=' . $id));
        } else {
            $error = $this->upload->display_errors();
            print_r($error);
        }
    }

    public function insertTable()
    {
        $param['import_kode'] = $this->input->get('import_kode');
        $this->M_perhitungan_sample->insertTable($param);
        $this->M_perhitungan_sample->deleteTable($this->input->get('import_kode'));

        header("Location: " . base_url('master/perhitungan_sample/index?header_menu=0&menu_id=0'));
    }
    /* INSERT IMPORT */

    /* INDEX IMPORT DETAIL */
    public function index_import_detail()
    {
        $isi['judul'] = 'Import Detail Perhitungan Rumus Sample';
        $data = $this->session->userdata();
        $data['id_sidebar'] = $this->input->get('id_sidebar');
        $data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

        $this->load->view('tampilan/header', $isi);
        $this->load->view('tampilan/sidebar', $data);
        $this->load->view('master/perhitungan_sample_detail_import');
        $this->load->view('tampilan/footer');
        $this->load->view('master/perhitungan_sample_detail_import_js');
    }
    /* INDEX IMPORT DETAIL */

    /* GET IMPORT DETAIL */
    public function getImportDetail()
    {
        $param['import_kode'] = $this->input->get('import_kode');

        $data = $this->M_perhitungan_sample->getImportDetail($param);

        echo json_encode($data);
    }
    /* GET IMPORT DETAIL */

    /* INSERT IMPORT DETAIL */
    public function insertImportDetail()
    {
        ini_set('display_errors', 1);
        // error_reporting(E_ALL);
        error_reporting(0);
        $data_session = $this->session->userdata();
        $config = array(
            'upload_path'   => FCPATH . '/upload/',
            'allowed_types' => 'xls|csv'
        );

        $this->upload->initialize($config);

        if ($this->upload->do_upload('file_import')) {
            $data = $this->upload->data();
            @chmod($data['full_path'], 0777);

            $this->load->library('Spreadsheet_Excel_Reader');
            $this->spreadsheet_excel_reader->setOutputEncoding('CP1251');
            $this->db->db_set_charset('latin1', 'latin1_swedish_ci');

            $this->spreadsheet_excel_reader->read($data['full_path']);
            $sheets = $this->spreadsheet_excel_reader->sheets[0];


            $data_excel = array();
            $id = create_id();
            for ($i = 2; $i <= $sheets['numRows']; $i++) {
                if ($sheets['cells'][$i][3] == '') break;

                $param_id_rumus['id_rumus'] = $this->input->post('id_rumus');

                $data_excel[$i - 1]['import_kode'] = $id;
                $data_excel[$i - 1]['rumus_detail_id'] = create_id();
                $data_excel[$i - 1]['id_rumus'] = $param_id_rumus['id_rumus'];
                $data_excel[$i - 1]['rumus_detail_input'] = $sheets['cells'][$i][1];
                $data_excel[$i - 1]['rumus_detail_nama'] = $sheets['cells'][$i][2];
                $data_excel[$i - 1]['rumus_jenis'] = $sheets['cells'][$i][3];
                $data_excel[$i - 1]['rumus_detail_urut'] = $sheets['cells'][$i][4];
                $data_excel[$i - 1]['rumus_detail_template'] = $sheets['cells'][$i][5];
                $data_excel[$i - 1]['when_create']  = date('Y-m-d H:i:s');
                $data_excel[$i - 1]['who_create']  = $data_session['user_nama_lengkap'];
            }

            $this->db->insert_batch('import.import_sample_perhitungan_sample_detail', $data_excel);

            header("Location: " . base_url('master/perhitungan_sample/index_import_detail?header_menu=0&menu_id=0&import_kode=' . $id . '&id_rumus=' . $param_id_rumus['id_rumus']));
        } else {
            $error = $this->upload->display_errors();
            print_r($error);
        }
    }

    public function insertTableDetail()
    {
        $param['import_kode'] = $this->input->get('import_kode');
        $this->M_perhitungan_sample->insertTableDetail($param);
        $this->M_perhitungan_sample->deleteTableDetail($this->input->get('import_kode'));

        header("Location: " . base_url('master/perhitungan_sample/index?header_menu=0&menu_id=0'));
    }
    /* INSERT IMPORT DETAIL */
}
