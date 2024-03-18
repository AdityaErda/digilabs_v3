<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Approve extends MY_Controller{

	public function __construct(){
		parent::__construct();

		$this->load->model('M_daftar');
	}

	public function index(){
		$isi['judul'] = 'Approve Document';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

		$this->template->template_master('document/approve',$isi,$data);
	}

	// get data
	public function getDataPengajuanDetail(){
		$par['transaksi_detail_id'] = ($this->input->get_post('transaksi_detail_id'));
		echo json_encode($this->M_daftar->getDataPengajuanDetail($par));
	}
	// end  data

	// start aprove
	public function aprovePengajuan(){
		$user = $this->session->userdata();

		if (isset($_FILES['transaksi_file'])) {
			$temp = './upload/';

			if (!file_exists($temp)) mkdir($temp);

			$fileupload      = $_FILES['transaksi_file']['tmp_name'];
			$ImageName       = $_FILES['transaksi_file']['name'];
			$ImageType       = $_FILES['transaksi_file']['type'];

			if (!empty($fileupload)) {
				$acak           = rand(11111111, 99999999);
				$ImageExt       = substr($ImageName, strrpos($ImageName, '.'));
				$ImageExt       = str_replace('.', '', $ImageExt); // Extension
				$ImageName      = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
				$NewImageName   = date('His') . '-' . $ImageName . '.' . $ImageExt;
				move_uploaded_file($_FILES["transaksi_file"]["tmp_name"], $temp . $NewImageName); // Menyimpan file

				$cek = "Data Berhasil Disimpan";
			} else {
				$cek = "Data Gagal Disimpan";
			}
			echo $cek;
		} else {
			$NewImageName = null;
		}
		// simpan pdf

		$id =  anti_inject($this->input->get_post('transaksi_id'));
		$par['company_code'] = '1';
		$par['jenis_id'] = anti_inject($this->input->get_post('jenis_id'));
		$par['transaksi_tgl_pengesahan'] = date('Y-m-d', strtotime($this->input->get_post('transaksi_tgl_pengesahan')));
		$par['transaksi_judul_document'] = anti_inject($this->input->get_post('transaksi_judul_document'));
		$par['transaksi_nomor_document'] = anti_inject($this->input->get_post('transaksi_nomor_document'));
		$par['transaksi_revisi'] = anti_inject($this->input->get_post('transaksi_revisi'));
		$par['transaksi_terbitan'] = anti_inject($this->input->get_post('transaksi_terbitan'));
		$par['transaksi_file_word'] = anti_inject($this->input->get_post('transaksi_file_word'));
		$par['transaksi_file_pdf'] = anti_inject($this->input->get_post('transaksi_file_pdf'));
		$par['who_create'] = $user['user_nama_lengkap'];
		$par['when_create'] = date('Y-m-d H:i:s');
		$par['seksi_id'] = anti_inject($this->input->get_post('seksi_id'));
		$par['transaksi_keterangan_document'] = anti_inject($this->input->get_post('transaksi_keterangan_document'));
		$par['transaksi_status'] = '1';
		$par['transaksi_note_document'] = anti_inject($this->input->get_post('transaksi_note_document'));
		$this->M_daftar->updatePengajuan($par, $id);

		$id_det = anti_inject($this->input->get_post('transaksi_detail_id'));
		$par1['transaksi_id'] = $id;
		$par1['transaksi_detail_judul_document'] = anti_inject($this->input->get_post('transaksi_judul_document'));
		$par1['transaksi_detail_revisi'] = anti_inject($this->input->get_post('transaksi_revisi'));
		$par1['transaksi_detail_terbitan'] = anti_inject($this->input->get_post('transaksi_terbitan'));
		$par1['when_create'] = date('Y-m-d H:i:s');
		$par1['who_create'] = $user['user_nama_lengkap'];
		$par1['transaksi_detail_keterangan_document'] = anti_inject($this->input->get_post('transaksi_keterangan_document'));
		$par1['transaksi_detail_nomor_document'] = anti_inject($this->input->get_post('transaksi_nomor_document'));
		$par1['transaksi_detail_note_document'] = anti_inject($this->input->get_post('transaksi_note_document'));
		$par1['transaksi_detail_tgl_document_pengesahan'] = date('Y-m-d', strtotime($this->input->get_post('transaksi_tgl_pengesahan')));
		$par1['transaksi_detail_status_pengajuan'] = '1';
		$this->M_daftar->updatePengajuanDetail($par1, $id_det);
	}

	// start aprove
	public function tolakPengajuan(){
		$user = $this->session->userdata();

		if (isset($_FILES['transaksi_file'])) {
			$temp = './upload/';

			if (!file_exists($temp)) mkdir($temp);

			$fileupload      = $_FILES['transaksi_file']['tmp_name'];
			$ImageName       = $_FILES['transaksi_file']['name'];
			$ImageType       = $_FILES['transaksi_file']['type'];

			if (!empty($fileupload)) {
				$acak           = rand(11111111, 99999999);
				$ImageExt       = substr($ImageName, strrpos($ImageName, '.'));
				$ImageExt       = str_replace('.', '', $ImageExt); // Extension
				$ImageName      = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
				$NewImageName   = date('His') . '-' . $ImageName . '.' . $ImageExt;
				move_uploaded_file($_FILES["transaksi_file"]["tmp_name"], $temp . $NewImageName); // Menyimpan file

				$cek = "Data Berhasil Disimpan";
			} else {
				$cek = "Data Gagal Disimpan";
			}
			echo $cek;
		} else {
			$NewImageName = null;
		}

		// simpan pdf


		$id =  anti_inject($this->input->get_post('transaksi_id'));
		$par['company_code'] = '1';
		$par['jenis_id'] = anti_inject($this->input->get_post('jenis_id'));
		$par['transaksi_tgl_pengesahan'] = date('Y-m-d', strtotime($this->input->get_post('transaksi_tgl_pengesahan')));
		$par['transaksi_judul_document'] = anti_inject($this->input->get_post('transaksi_judul_document'));
		$par['transaksi_nomor_document'] = anti_inject($this->input->get_post('transaksi_nomor_document'));
		$par['transaksi_revisi'] = anti_inject($this->input->get_post('transaksi_revisi'));
		$par['transaksi_terbitan'] = anti_inject($this->input->get_post('transaksi_terbitan'));
		if ($this->input->get_post('transaksi_file') != 'undefined') {
			// $par['transaksi_file'] = $NewImageName;
		}
		$par['who_create'] = $user['user_nama_lengkap'];
		$par['when_create'] = date('Y-m-d H:i:s');
		$par['seksi_id'] = anti_inject($this->input->get_post('seksi_id'));
		$par['transaksi_keterangan_document'] = anti_inject($this->input->get_post('transaksi_keterangan_document'));
		$par['transaksi_note_document'] = anti_inject($this->input->get_post('transaksi_note_document'));
		$this->M_daftar->updatePengajuan($par, $id);

		$id_det = anti_inject($this->input->get_post('transaksi_detail_id'));
		$par1['transaksi_id'] = $id;
		$par1['transaksi_detail_judul_document'] = anti_inject($this->input->get_post('transaksi_detail_document'));
		$par1['transaksi_detail_revisi'] = anti_inject($this->input->get_post('transaksi_revisi'));
		$par1['transaksi_detail_terbitan'] = anti_inject($this->input->get_post('transaksi_terbitan'));
		$par1['when_create'] = date('Y-m-d H:i:s');
		$par1['who_create'] = $user['user_nama_lengkap'];
		$par1['transaksi_detail_keterangan_document'] = anti_inject($this->input->get_post('transaksi_keterangan_document'));
		$par1['transaksi_detail_nomor_document'] = anti_inject($this->input->get_post('transaksi_nomor_document'));
		$par1['transaksi_detail_note_document'] = anti_inject($this->input->get_post('transaksi_note_document'));
		$par1['transaksi_detail_tgl_document_pengesahan'] = date('Y-m-d', strtotime($this->input->get_post('transaksi_tgl_pengesahan')));
		$par1['transaksi_detail_status_pengajuan'] = '2';
		$this->M_daftar->updatePengajuanDetail($par1, $id_det);
	}
	// end aprove
}
