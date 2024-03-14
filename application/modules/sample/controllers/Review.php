<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Review extends MY_Controller
{


	public function __construct()
	{
		parent::__construct();
		isLogin();
		$this->load->model('api/M_user', 'M_user_api');
		$this->load->model('master/M_user', 'M_user');
		$this->load->model('master/M_sample_peminta_jasa');
		$this->load->model('master/M_sample_jenis');
		$this->load->model('master/M_sample_pekerjaan');
		$this->load->model('sample/M_request');
		$this->load->model('sample/M_nomor');
	}

	public function index()
	{
		// $this->checkLogin();
		$isi['judul'] = 'Sample Review';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');
		// $data['tipe'] = $this->input->get('tipe');

		$this->load->view('tampilan/header', $isi);
		$this->load->view('tampilan/sidebar', $data);
		$this->load->view('sample/review');
		$this->load->view('tampilan/footer');
		$this->load->view('sample/review_js');
	}

	// Proccess
	public function procesReview()
	{
		$isi['judul'] = 'Sample Review';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');
		// $data['tipe'] = $this->input->get('tipe');

		$param['transaksi_id'] = $this->input->get_post('transaksi_id');
		$param['transaksi_detail_id'] = $this->input->get_post('transaksi_detail_id');
		$param['transaksi_non_rutin_id'] = $this->input->get_post('non_rutin');
		$param['transaksi_status'] = $this->input->get_post('status');


		$result['sample_jenis'] = $this->M_sample_jenis->getJenisSampleUJi($param);
		$result['pekerjaan_jenis'] = $this->M_sample_pekerjaan->getJenisPekerjaan($param);
		$result['sample_detail'] = $this->M_request->getRequestDetail($param);


		$this->load->view('tampilan/header', $isi);
		$this->load->view('tampilan/sidebar', $data);
		$this->load->view('sample/review_proces', $result);
		$this->load->view('tampilan/footer');
		$this->load->view('sample/review_proces_js');
	}

	/* GET */
	public function getReview()
	{
		$isi = $this->session->userdata();

		if ($this->input->get('tgl_cari')) $tgl = explode(' - ', $this->input->get('tgl_cari'));
		if ($this->input->get('tgl_cari')) $param['tgl_awal'] = date('Y-m-d', strtotime($tgl[0]));
		if ($this->input->get('tgl_cari')) $param['tgl_akhir'] = date('Y-m-d', strtotime($tgl[1]));
		if ($this->input->get('isi') != 'ok') if ($isi['role_id'] != '1') $param['seksi_id'] = $isi['user_unit_id'];

		$param['transaksi_id'] = $this->input->get('transaksi_id');
		$param['transaksi_non_rutin_id'] = $this->input->get('transaksi_non_rutin_id');
		$param['transaksi_tipe'] = $this->input->get('transaksi_tipe');
		$param['transaksi_status'] = '1';
		// $param['transaksi_status_not_array'] = array('1', '2');
		if (!empty($this->input->get_post('transaksi_status_not_array2'))) {
			$explode_not_status = explode(',', $this->input->get_post('transaksi_status_not_array2'));
			$param['transaksi_status_not_array2'] = $explode_not_status;
		}

		if (!empty($this->input->get_post('array_transaksi_status_in'))) {
			$explode_status_in = explode(',', $this->input->get_post('array_transaksi_status_in'));
			$param['array_transaksi_status_in'] = $explode_status_in;
		}

		if (!empty($this->input->get_post('array_transaksi_status_not_in'))) {
			$explode_status_not_in = explode(',', $this->input->get_post('array_transaksi_status_not_in'));
			$param['array_transaksi_status_not_in'] = $explode_status_not_in;
		}

		$status_request = explode(',', $this->input->get_post('transaksi_status_request'));
		$param['transaksi_status_request'] = $status_request;
		$param['tahun'] = $this->input->get('tahun');
		$param['tanggal_cari'] = $this->input->get_post('tanggal_cari');
		$param['tanggal_cari_awal'] = $this->input->get_post('tanggal_cari_awal');
		$param['tanggal_cari_akhir'] = $this->input->get_post('tanggal_cari_akhir');

		$where = array();
		if (!empty($param['tanggal_cari'])) {
			$tgl_ini = date($param['tanggal_cari'] . '-d');
			$where['DATE(transaksi_tgl) >= '] = date('Y-m-d', strtotime($tgl_ini));
			$where['DATE(transaksi_tgl) <= '] = date('Y-m-d', strtotime($tgl_ini));
		} else if (!empty($param['tahun_cari'])) {
			$where['DATE(transaksi_tgl) >= '] = $param['tahun_cari'] . '-01-01';
			$where['DATE(transaksi_tgl) <= '] = $param['tahun_cari'] . '-12-31';
		}

		if (!empty($this->input->get_post('transaksi_tipe_cari') && $this->input->get_post('transaksi_tipe_cari') != '-')) {
			$where['transaksi_tipe'] = $this->input->get_post('transaksi_tipe_cari');
		}

		$data = $this->M_request->getRequestMain($param, $where);

		echo json_encode($data);
	}

	public function insertReview()
	{
		$session = $this->session->userdata();
		$data_user['direct_superior'] = substr($session['user_direct_superior'], 0, 6);
		$user = $this->M_user_api->getUserList($data_user);

		/* Nomor Surat */
		$nomor = $this->M_nomor->getNomorMax();
		$sekretariat = $this->input->get_post('transaksi_klasifikasi_id');
		$kode_sekretariat = $this->db->get_where('sample.sample_klasifikasi', array('klasifikasi_id' => $sekretariat))->row_array();
		$dept = '39.4';
		$digi = 'DIGILABS';
		$tahun = date('Y');

		$newNomor = sprintf("%05d", ($nomor['isi'] + 1)) . '/' . $kode_sekretariat['klasifikasi_kode'] . '/'  . $digi . '/' . $tahun;
		/* Nomor Surat */

		$config['upload_path'] = FCPATH . './document/';
		$config['allowed_types'] = '*';

		$this->upload->initialize($config);

		$jumlah_upload_data = count($this->input->get_post('transaksi_detail_id'));
		for ($i = 0; $i < $jumlah_upload_data; $i++) {
			if (!empty($_FILES['transaksi_detail_attachment']['name'][$i])) {
				$_FILES['file']['name'] = $_FILES['transaksi_detail_attachment']['name'][$i];
				$_FILES['file']['type'] = $_FILES['transaksi_detail_attachment']['type'][$i];
				$_FILES['file']['tmp_name'] = $_FILES['transaksi_detail_attachment']['tmp_name'][$i];
				$_FILES['file']['error'] = $_FILES['transaksi_detail_attachment']['error'][$i];
				$_FILES['file']['size'] = $_FILES['transaksi_detail_attachment']['size'][$i];

				if (!$this->upload->do_upload('file')) {
					$error_attachment = array('error' => $this->upload->display_errors());
				} else {
					$data_attachment = $this->upload->data();
					$new_attachment = $data_attachment['file_name'];
				}
			} else {
				$new_attachment =	$this->input->get_post('transaksi_detail_attachment_lama')[$i];
			}

			if (!empty($_FILES['transaksi_detail_file']['name'][$i])) {
				$_FILES['file']['name'] = $_FILES['transaksi_detail_file']['name'][$i];
				$_FILES['file']['type'] = $_FILES['transaksi_detail_file']['type'][$i];
				$_FILES['file']['tmp_name'] = $_FILES['transaksi_detail_file']['tmp_name'][$i];
				$_FILES['file']['error'] = $_FILES['transaksi_detail_file']['error'][$i];
				$_FILES['file']['size'] = $_FILES['transaksi_detail_file']['size'][$i];

				if (!$this->upload->do_upload('file')) {
					$error_file = array('error' => $this->upload->display_errors());
				} else {
					$data_file = $this->upload->data();
					$new_file = $data_file['file_name'];
				}
			} else {
				$new_file =	$this->input->get_post('transaksi_detail_file_lama')[$i];
			}

			/* Update Detail Pekerjaan Lama */
			$id_detail = $this->input->post('transaksi_detail_id_temp')[$i];
			$data_detail['is_proses'] = 'y';

			$this->M_request->updateRequestDetail($data_detail, $id_detail);
			/* Update Detail Pekerjaan Lama */

			/* Transaksi Detail */
			$data[] = array(
				'transaksi_detail_id' => anti_inject($this->input->get_post('transaksi_detail_id')[$i]),
				'transaksi_detail_judul' => anti_inject($this->input->get_post('item_judul')[$i]),
				'jenis_id' => anti_inject($this->input->get_post('jenis_id')[$i]),
				'jenis_pekerjaan_id' => anti_inject($this->input->get_post('jenis_pekerjaan_id')[$i]),
				'identitas_id' => anti_inject($this->input->get_post('identitas_id')[$i]),
				'transaksi_detail_jumlah' => anti_inject($this->input->get_post('transaksi_detail_jumlah')[$i]),
				'transaksi_detail_identitas' => anti_inject($this->input->get_post('transaksi_detail_identitas')[$i]),
				'transaksi_detail_parameter' => anti_inject($this->input->get_post('transaksi_detail_parameter')[$i]),
				'transaksi_detail_deskripsi_parameter' => anti_inject($this->input->get_post('transaksi_detail_deskripsi_parameter')[$i]),
				'transaksi_detail_catatan' => anti_inject($this->input->get_post('transaksi_detail_catatan')[$i]),
				'transaksi_detail_attach' => $new_attachment,
				'transaksi_detail_file' => $new_file,
				'transaksi_id' => anti_inject($this->input->get_post('transaksi_id')),
				'id_non_rutin' => anti_inject($this->input->get_post('transaksi_non_rutin_id')),
				'peminta_jasa_id' => anti_inject($this->input->get_post('peminta_jasa_id')),
				'transaksi_detail_pic_pengirim' => anti_inject($this->input->get_post('transaksi_detail_pic_pengirim')),
				'transaksi_detail_pic_telepon' => anti_inject($this->input->get_post('transaksi_detail_pic_telepon')),
				'transaksi_detail_ext_pengirim' => anti_inject($this->input->get_post('transaksi_detail_ext_pengirim')),
				'transaksi_detail_tgl_pengajuan' => date('Y-m-d H:i:s'),
				'transaksi_detail_klasifikasi_id' => anti_inject($this->input->get_post('transaksi_klasifikasi_id')),
				'transaksi_detail_id_template_keterangan' => anti_inject($this->input->get_post('template_id')),
				'transaksi_detail_status' => anti_inject($this->input->get_post('transaksi_status') + 1),
				'when_create' => date('Y-m-d H:i:s'),
				'who_create' => $session['user_nama_lengkap'],
				'who_seksi_create' => $session['user_unit_id'],
				'transaksi_detail_agreement_keterangan' => anti_inject($this->input->get_post('transaksi_agreement_keterangan')),
			);
			/* Transaksi Detail */
		}
		$this->db->insert_batch('sample.sample_transaksi_detail', $data);

		/* Update Transaksi */
		$id_non_rutin = anti_inject($this->input->get_post('transaksi_non_rutin_id'));

		$data_transaksi['transaksi_id'] = anti_inject($this->input->get_post('transaksi_id'));
		$data_transaksi['transaksi_tipe'] = anti_inject($this->input->get_post('transaksi_tipe'));
		$data_transaksi['transaksi_judul'] = anti_inject($this->input->get_post('transaksi_judul'));
		$data_transaksi['transaksi_id_peminta_jasa'] = anti_inject($this->input->get_post('peminta_jasa_id'));
		$data_transaksi['transaksi_id_template_keterangan'] = anti_inject($this->input->get_post('template_id'));
		$data_transaksi['transaksi_klasifikasi_id'] = anti_inject($this->input->get_post('transaksi_klasifikasi_id'));
		$data_transaksi['transaksi_sifat'] = anti_inject($this->input->get_post('transaksi_sifat'));
		$data_transaksi['transaksi_kecepatan_tanggap'] = anti_inject($this->input->get_post('transaksi_kecepatan_tanggap'));
		$data_transaksi['transaksi_reviewer'] = anti_inject($this->input->get_post('transaksi_reviewer'));
		$data_transaksi['transaksi_approver'] = anti_inject($this->input->get_post('transaksi_approver'));
		$data_transaksi['transaksi_drafter'] = anti_inject($this->input->get_post('transaksi_drafter'));
		$data_transaksi['transaksi_tujuan'] = anti_inject($this->input->get_post('transaksi_tujuan'));
		$data_transaksi['transaksi_pic_pengirim_id'] = anti_inject($this->input->get_post('transaksi_pic_pengirim_id'));
		$data_transaksi['transaksi_pic_pengirim'] = anti_inject($this->input->get_post('transaksi_detail_pic_pengirim'));
		$data_transaksi['transaksi_pic_ext'] = anti_inject($this->input->get_post('transaksi_detail_ext_pengirim'));
		$data_transaksi['transaksi_pic_telepon'] = anti_inject($this->input->get_post('transaksi_detail_pic_telepon'));
		$data_transaksi['transaksi_reviewer_poscode'] = anti_inject($this->input->get_post('transaksi_reviewer_poscode'));
		$data_transaksi['transaksi_approver_poscode'] = anti_inject($this->input->get_post('transaksi_approver_poscode'));
		$data_transaksi['transaksi_drafter_poscode'] = anti_inject($this->input->get_post('transaksi_drafter_poscode'));
		$data_transaksi['transaksi_tujuan_poscode'] = anti_inject($this->input->get_post('transaksi_tujuan_poscode'));
		$data_transaksi['transaksi_pic_poscode'] = anti_inject($this->input->get_post('transaksi_pic_pengirim_poscode'));
		$data_transaksi['transaksi_status'] = anti_inject($this->input->get_post('transaksi_status')) + 1;
		$data_transaksi['transaksi_agreement_keterangan'] = anti_inject($this->input->get_post('transaksi_agreement_keterangan'));

		$this->M_request->updateRequestNon($data_transaksi, $id_non_rutin);
		/* Update Transaksi */

		sampleLog($this->input->get_post('transaksi_id'), null, $id_non_rutin, $data_transaksi['transaksi_tipe'], $data_transaksi['transaksi_status'], 'Pekerjaan Telah Review Oleh AVP Peminta Jasa ');
	}

	public function insertReject()
	{
		$id = $this->input->get_post('transaksi_non_rutin_id');
		$param['transaksi_reject_alasan']  = anti_inject($this->input->get_post('transaksi_reject_alasan'));
		$param['transaksi_status'] = '15';

		$this->M_request->insertReject($id, $param);

		$id_detail = anti_inject($this->input->get_post('transaksi_non_rutin_id'));
		$id_status = anti_inject($this->input->get_post('transaksi_status'));

		$param_detail['transaksi_detail_reject_alasan'] = anti_inject($this->input->get_post('transaksi_detail_reject_alasan'));
		$param_detail['transaksi_detail_status'] = '15';

		$this->M_request->insertRejectDetail($id_detail, $id_status, $param_detail);

		if ($this->input->get_post('transaksi_status') == '1') {
			sampleLog($this->input->get_post('transaksi_id'), null, $this->input->get_post('transaksi_non_rutin_id'), $this->input->get_post('transaksi_tipe'), $param['transaksi_status'], 'Pekerjaan Telah Direject oleh Reviewer');
		} else if ($this->input->get_post('transaksi_status') == '2') {
			sampleLog($this->input->get_post('transaksi_id'), null, $this->input->get_post('transaksi_non_rutin_id'), $this->input->get_post('transaksi_tipe'), $param['transaksi_status'], 'Pekerjaan Telah Direject oleh Approver');
		} else if ($this->input->get_post('transaksi_status') == '3') {
			sampleLog($this->input->get_post('transaksi_id'), null, $this->input->get_post('transaksi_non_rutin_id'), $this->input->get_post('transaksi_tipe'), $param['transaksi_status'], 'Pekerjaan Telah Direject oleh VP PPK');
		} else if ($this->input->get_post('transaksi_status') == '4') {
			sampleLog($this->input->get_post('transaksi_id'), null, $this->input->get_post('transaksi_non_rutin_id'), $this->input->get_post('transaksi_tipe'), $param['transaksi_status'], 'Pekerjaan Telah Direject oleh AVP LUK');
		} else if ($this->input->get_post('transaksi_status') == '5') {
			sampleLog($this->input->get_post('transaksi_id'), null, $this->input->get_post('transaksi_non_rutin_id'), $this->input->get_post('transaksi_tipe'), $param['transaksi_status'], 'Pekerjaan Telah Direject oleh Kompilator');
		}
	}
}
