<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Landing extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_landing');
    }

    public function index()
    {
        if (COUNT($this->session->userdata()) > 5) {
            redirect(base_url('dashboard/order/?&header_menu=53&menu_id=54'));
        } else {
            $this->load->view('landing/landing');
        }
    }

    public function indexPreview()
    {
        $this->load->view('landing/landing_preview');
    }

    public function preview()
    {
        $param_landing = array(
            'aktif' => 'y',
        );

        $landing = $this->M_landing->getLanding($param_landing);

        $data_landing['utama'] = $this->M_landing->getLanding($param_landing);
        $this->load->view('web/web_header', $data_landing, FALSE);
        // $this->load->view('web/konten', $data_landing, FALSE);

        foreach ($landing as $value) :

            $param_template_banner = array('landing_template_tipe' => 'B', 'id_landing' => $value['landing_id']);
            $param_template_about = array('landing_template_tipe' => 'T', 'id_landing' => $value['landing_id']);
            $param_template_news = array('landing_template_tipe' => 'N', 'id_landing' => $value['landing_id']);
            $param_template_certificate = array('landing_template_tipe' => 'S', 'id_landing' => $value['landing_id']);
            $param_template_cooperation = array('landing_template_tipe' => 'C', 'id_landing' => $value['landing_id']);
            $param_template_contact = array('landing_template_tipe' => 'K', 'id_landing' => $value['landing_id']);
            $param_template_testimonial = array('landing_template_tipe' => 'T', 'id_landing' => $value['landing_id']);

            $data_landing['banner'] = $this->M_landing->getLandingDetail($param_template_banner);
            $data_landing['about'] = $this->M_landing->getLandingDetail($param_template_about);
            $data_landing['news'] = $this->M_landing->getLandingDetail($param_template_news);
            $data_landing['certificate'] = $this->M_landing->getLandingDetail($param_template_certificate);
            $data_landing['cooperation'] = $this->M_landing->getLandingDetail($param_template_cooperation);
            $data_landing['contact'] = $this->M_landing->getLandingDetail($param_template_contact);
            $data_landing['testimonial'] = $this->M_landing->getLandingDetail($param_template_testimonial);


            $this->load->view('web/content/' . $value['landing_template_file'], $data_landing, false);
        endforeach;

        $this->load->view('web/web_footer', $data_landing, FALSE);
        $this->load->view('web/web_js', $data_landing, FALSE);
    }


    public function utama()
    {

        $isi['judul'] = 'Landing Page';
        $data = $this->session->userdata();
        $data['id_sidebar'] = $this->input->get('id_sidebar');
        $data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

        $this->load->view('tampilan/header', $isi, FALSE);
        $this->load->view('tampilan/sidebar', $data, FALSE);
        $this->load->view('landing/utama');
        $this->load->view('landing/utama_js');
        $this->load->view('tampilan/footer');
    }

    public function getLanding()
    {
        $param = array(
            'landing_id' => $this->input->get_post('landing_id'),
        );
        $data = $this->M_landing->getLanding($param);
        echo json_encode($data);
    }

    // landing banner
    public function getLandingDetail()
    {
        $param = array(
            'id_landing' => $this->input->get_post('id_landing'),
            'landing_detail_id' => $this->input->get_post('landing_detail_id'),
            'landing_tipe' => $this->input->get_post('landing_tipe'),
        );
        $data = $this->M_landing->getLandingDetail($param);
        echo json_encode($data);
    }
    // landing banner

    public function getLandingTemplate()
    {
        $landingTemplate['results'] = array();
        $param['landing_template_nama'] = $this->input->get('landing_template_nama');
        foreach ($this->M_landing->getLandingTemplate($param) as $key => $value) {
            array_push($landingTemplate['results'], [
                'id' => $value['landing_template_id'],
                'text' => $value['landing_template_nama'],
            ]);
        }
        echo json_encode($landingTemplate);
    }

    public function getLandingTemplateTipe()
    {

        $param['landing_template_id'] = $this->input->get_post('landing_template_id');
        $data = $this->M_landing->getLandingTemplate($param);
        echo json_encode($data);
    }

    public function insertLanding()
    {
        $sesi = $this->session->userdata();

        $param = array(
            'landing_id' => create_id(),
            'landing_judul' => anti_inject($this->input->get_post('landing_judul')),
            'landing_who_create' => $sesi['user_nama_lengkap'],
            'landing_date_create' => date('Y-m-d'),
            'landing_tipe' => anti_inject($this->input->get_post('landing_tipe')),
            'aktif' => anti_inject($this->input->get_post('landing_aktif')),
            'landing_link' => anti_inject($this->input->get_post('landing_link')),
            'landing_urut' => anti_inject($this->input->get_post('landing_urutan')),
            'id_landing_template' => anti_inject($this->input->get_post('id_landing_template')),
        );

        $this->M_landing->insertLanding($param);
    }


    public function updateLanding()
    {
        $sesi = $this->session->userdata();

        $id = anti_inject($this->input->get_post('landing_id'));
        $param = array(
            // 'landing_id' => create_id(),
            'landing_judul' => anti_inject($this->input->get_post('landing_judul')),
            'landing_who_create' => $sesi['user_nama_lengkap'],
            'landing_date_create' => date('Y-m-d'),
            // 'landing_gambar' => anti_inject($this->input->get_post('name')),
            'landing_tipe' => anti_inject($this->input->get_post('landing_tipe')),
            'aktif' => anti_inject($this->input->get_post('landing_aktif')),
            'landing_link' => anti_inject($this->input->get_post('landing_link')),
            'landing_urut' => anti_inject($this->input->get_post('landing_urutan')),
            'id_landing_template' => anti_inject($this->input->get_post('id_landing_template')),
        );

        $this->M_landing->updateLanding($id, $param);
    }

    public function deleteLanding()
    {
        $id = anti_inject($this->input->get_post('landing_id'));
        $this->M_landing->deleteLanding($id);
    }

    public function insertLandingDetail()
    {
        $sesi = $this->session->userdata();

        // if (isset($_FILES['landing_detail_gambar'])) {
        //     $temp = "./landing/";
        //     if (!file_exists($temp)) mkdir($temp);

        //     $fileupload      = $_FILES['landing_detail_gambar']['tmp_name'];
        //     $ImageName       = $_FILES['landing_detail_gambar']['name'];
        //     $ImageType       = $_FILES['landing_detail_gambar']['type'];

        //     if (!empty($fileupload)) {
        //         $Extension        = array("jpeg", "jpg", "png", "bmp", "gif", "doc", "docx", "xls", "xlsx", "ppt", "pptx", "pdf");
        //         $acak           = rand(11111111, 99999999);
        //         $ImageExt       = substr($ImageName, strrpos($ImageName, '.'));
        //         $ImageExt       = str_replace('.', '', $ImageExt); // Extension
        //         $ImageName      = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
        //         $NewImageName   = str_replace(' ', '', create_id() . '_' . date('ymdhis') . '.' . $ImageExt);


        //         if (in_array($ImageExt, $Extension)) {
        //             move_uploaded_file($_FILES["landing_detail_gambar"]["tmp_name"], $temp . $NewImageName); // Menyimpan file
        //         }
        //         $note = "Data Berhasil Disimpan";
        //     } else {
        //         $note = "Data Gagal Disimpan";
        //     }
        //     echo $note;
        // } else {
        //     $NewImageName = null;
        // }

        if (!empty($_FILES['landing_detail_gambar']['name'])) {

            $file_name                  = str_replace(' ', '', create_id() . '_' . date('ymdhis'));
            $config['upload_path']      = './landing/';
            $config['allowed_types']    = 'jpeg|jpg|png|bmp|gif';
            $config['max_size']         = 2048; // 2MB
            // $config['width']            = 495;
            // $config['height']           = 440;
            $config['file_name']        = $file_name;

            $this->upload->initialize($config);

            if (!$this->upload->do_upload('landing_detail_gambar')) {
                echo "Data Gagal Disimpan";
                die();
            } else {
                $landing_detail_gambar = $this->upload->data('file_name');
            }
            echo "Data Berhasil Disimpan";
        }


        if (isset($_FILES['landing_detail_file'])) {
            $temp = "./landing/";
            if (!file_exists($temp)) mkdir($temp);

            $fileupload      = $_FILES['landing_detail_file']['tmp_name'];
            $ImageName       = $_FILES['landing_detail_file']['name'];
            $ImageType       = $_FILES['landing_detail_file']['type'];

            if (!empty($fileupload)) {
                $Extension        = array("jpeg", "jpg", "png", "bmp", "gif", "doc", "docx", "xls", "xlsx", "ppt", "pptx", "pdf");
                $acak           = rand(11111111, 99999999);
                $ImageExt       = substr($ImageName, strrpos($ImageName, '.'));
                $ImageExt       = str_replace('.', '', $ImageExt); // Extension
                $ImageName      = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
                $NewFileName   = str_replace(' ', '', create_id() . '_' . date('ymdhis') . '.' . $ImageExt);

                if (in_array($ImageExt, $Extension)) {
                    move_uploaded_file($_FILES["landing_detail_file"]["tmp_name"], $temp . $NewFileName); // Menyimpan file
                }
                $note = "Data Berhasil Disimpan";
            } else {
                $note = "Data Gagal Disimpan";
            }
            echo $note;
        } else {
            $NewFileName = null;
        }

        $text_1 = str_replace("&lt;", "<", $this->input->get_post('landing_detail_text'));
        $text_2 = str_replace("&gt;", ">", $text_1);

        $data_detail = array(
            'landing_detail_id' => create_id(),
            'id_landing' => anti_inject($this->input->get_post('id_landing')),
            'landing_detail_nama' => anti_inject($this->input->get_post('landing_detail_nama')),
            'landing_detail_urutan' => anti_inject($this->input->get_post('landing_detail_urutan')),
            'landing_detail_nomor' => anti_inject($this->input->get_post('landing_detail_nomor')),
            'landing_detail_judul' => anti_inject($this->input->get_post('landing_detail_judul')),
            // 'landing_detail_thumbnails' => anti_inject($this->input->get_post('landing_detail_thumbnails')),
            'landing_detail_gambar' => $landing_detail_gambar,
            'landing_detail_file' => $NewFileName,
            'landing_detail_text' => $text_2,
            'landing_detail_kontak' => anti_inject($this->input->get_post('landing_detail_kontak')),
            'landing_detail_fax' => anti_inject($this->input->get_post('landing_detail_fax')),
            'landing_detail_email' => anti_inject($this->input->get_post('landing_detail_email')),
            'landing_detail_web' => anti_inject($this->input->get_post('landing_detail_web')),
            'landing_detail_alamat' => anti_inject($this->input->get_post('landing_detail_alamat')),
            'landing_detail_tanggal' => anti_inject($this->input->get_post('landing_detail_tanggal')),
            'landing_detail_who_create' => $sesi['user_nama_lengkap'],
            'landing_detail_date_create' => date('Y-m-d'),
            // 'landing_detail_status' => anti_inject($this->input->get_post('landing_detail_status')),
        );

        $this->M_landing->insertLandingDetail($data_detail);
    }

    public function updateLandingDetail()
    {
        $sesi = $this->session->userdata();

        // if (isset($_FILES['landing_detail_gambar'])) {
        //     $temp = "./landing/";
        //     if (!file_exists($temp)) mkdir($temp);

        //     $fileupload      = $_FILES['landing_detail_gambar']['tmp_name'];
        //     $ImageName       = $_FILES['landing_detail_gambar']['name'];
        //     $ImageType       = $_FILES['landing_detail_gambar']['type'];

        //     if (!empty($fileupload)) {
        //         $Extension        = array("jpeg", "jpg", "png", "bmp", "gif", "doc", "docx", "xls", "xlsx", "ppt", "pptx", "pdf");
        //         $acak           = rand(11111111, 99999999);
        //         $ImageExt       = substr($ImageName, strrpos($ImageName, '.'));
        //         $ImageExt       = str_replace('.', '', $ImageExt); // Extension
        //         $ImageName      = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
        //         $NewImageName   = str_replace(' ', '', create_id() . '_' . date('ymdhis') . '.' . $ImageExt);

        //         if (in_array($ImageExt, $Extension)) {
        //             move_uploaded_file($_FILES["landing_detail_gambar"]["tmp_name"], $temp . $NewImageName); // Menyimpan file
        //         }
        //     }
        // }

        if (!empty($_FILES['landing_detail_gambar']['name'])) {

            $file_name                  = str_replace(' ', '', create_id() . '_' . date('ymdhis'));
            $config['upload_path']      = './landing/';
            $config['allowed_types']    = 'jpeg|jpg|png|bmp|gif';
            $config['max_size']         = 2048; // 2MB
            // $config['width']            = 495;
            // $config['height']           = 440;
            $config['file_name']        = $file_name;

            $this->upload->initialize($config);

            if (!$this->upload->do_upload('landing_detail_gambar')) {
                echo "Data Gagal Disimpan";
                die();
            } else {
                $landing_detail_gambar = $this->upload->data('file_name');
            }
            echo "Data Berhasil Disimpan";
        }

        $landing_detail_gambar = ($landing_detail_gambar) ? $landing_detail_gambar : anti_inject($this->input->get_post('landing_detail_gambar_temp'));

        if (isset($_FILES['landing_detail_file'])) {
            $temp = "./landing/";
            if (!file_exists($temp)) mkdir($temp);

            $fileupload      = $_FILES['landing_detail_file']['tmp_name'];
            $ImageName       = $_FILES['landing_detail_file']['name'];
            $ImageType       = $_FILES['landing_detail_file']['type'];

            if (!empty($fileupload)) {
                $Extension        = array("jpeg", "jpg", "png", "bmp", "gif", "doc", "docx", "xls", "xlsx", "ppt", "pptx", "pdf");
                $acak           = rand(11111111, 99999999);
                $ImageExt       = substr($ImageName, strrpos($ImageName, '.'));
                $ImageExt       = str_replace('.', '', $ImageExt); // Extension
                $ImageName      = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
                $NewFileName   = str_replace(' ', '', create_id() . '_' . date('ymdhis') . '.' . $ImageExt);

                if (in_array($ImageExt, $Extension)) {
                    move_uploaded_file($_FILES["landing_detail_file"]["tmp_name"], $temp . $NewFileName); // Menyimpan file
                }
            }
        }

        $NewFileName = ($NewFileName) ? $NewFileName : anti_inject($this->input->get_post('landing_detail_file_temp'));

        $id = anti_inject($this->input->get_post('landing_detail_id'));
        $data_detail = array(
            'id_landing' => anti_inject($this->input->get_post('id_landing')),
            'landing_detail_nama' => anti_inject($this->input->get_post('landing_detail_nama')),
            'landing_detail_urutan' => anti_inject($this->input->get_post('landing_detail_urutan')),
            'landing_detail_nomor' => anti_inject($this->input->get_post('landing_detail_nomor')),
            'landing_detail_judul' => anti_inject($this->input->get_post('landing_detail_judul')),
            // 'landing_detail_thumbnails' => anti_inject($this->input->get_post('landing_detail_thumbnails')),
            'landing_detail_gambar' => $landing_detail_gambar,
            'landing_detail_file' => $NewFileName,
            'landing_detail_text' => anti_inject($this->input->get_post('landing_detail_text')),
            'landing_detail_kontak' => anti_inject($this->input->get_post('landing_detail_kontak')),
            'landing_detail_fax' => anti_inject($this->input->get_post('landing_detail_fax')),
            'landing_detail_email' => anti_inject($this->input->get_post('landing_detail_email')),
            'landing_detail_web' => anti_inject($this->input->get_post('landing_detail_web')),
            'landing_detail_alamat' => anti_inject($this->input->get_post('landing_detail_alamat')),
            'landing_detail_tanggal' => anti_inject($this->input->get_post('landing_detail_tanggal')),
            'landing_detail_who_create' => $sesi['user_nama_lengkap'],
            'landing_detail_date_create' => date('Y-m-d'),
        );

        $this->M_landing->updateLandingDetail($id, $data_detail);
    }

    public function deleteLandingDetail()
    {
        $id = anti_inject($this->input->get_post('landing_detail_id'));
        $this->M_landing->deleteLandingDetail($id);
    }
}

/* End of file Landing
.php */
