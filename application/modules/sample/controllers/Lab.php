<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lab extends MY_Controller
{


	public function __construct()
	{
		parent::__construct();
		isLogin();
		$this->load->model('master/M_user', 'M_user');
		$this->load->model('api/M_user', 'M_user_api');
		$this->load->model('master/M_sample_peminta_jasa');
		$this->load->model('master/M_sample_jenis');
		$this->load->model('master/M_sample_pekerjaan');
		$this->load->model('master/M_klasifikasi_sample');
		$this->load->model('sample/M_request');
		$this->load->model('sample/M_nomor');
		$this->load->model('sample/M_lab');
		$this->load->model('sample/M_approve');
	}



	public function index()
	{
		// $this->checkLogin();
		$isi['judul'] = 'Sample Accepted';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');
		// $data['tipe'] = $this->input->get('tipe');

		$this->load->view('tampilan/header', $isi);
		$this->load->view('tampilan/sidebar', $data);
		$this->load->view('sample/lab');
		$this->load->view('tampilan/footer');
		$this->load->view('sample/lab_js');
	}

	// Proccess
	public function procesLab()
	{
		$isi['judul'] = 'Sample Accepted';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');
		// $data['tipe'] = $this->input->get('tipe');

		$param['transaksi_id'] = $this->input->get_post('transaksi_id');
		$param['transaksi_detail_id'] = $this->input->get_post('transaksi_detail_id');
		$param['transaksi_non_rutin_id'] = $this->input->get_post('non_rutin');
		$param['transaksi_status'] = $this->input->get_post('status');


		$result['sample'] = $this->M_request->getRequestAll($param, $where = null);
		$result['sample_klasifikasi'] = $this->M_klasifikasi_sample->getKlasifikasiSample($param);
		$result['sample_jenis'] = $this->M_sample_jenis->getJenisSampleUJi($param);
		$result['pekerjaan_jenis'] = $this->M_sample_pekerjaan->getJenisPekerjaan($param);
		$result['sample_detail'] = $this->M_request->getRequestDetail($param);

		$this->load->view('tampilan/header', $isi);
		$this->load->view('tampilan/sidebar', $data);
		$this->load->view('sample/lab_proces', $result);
		$this->load->view('tampilan/footer');
		$this->load->view('sample/lab_proces_js');
	}

	// Preview
	public function previewRequest()
	{
		$isi['judul'] = 'Sample Approved';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');
		// $data['tipe'] = $this->input->get('tipe');

		$param['transaksi_id'] = $this->input->get_post('transaksi_id');
		$param['transaksi_detail_id'] = $this->input->get_post('transaksi_detail_id');
		$param['transaksi_non_rutin_id'] = $this->input->get_post('non_rutin');
		$param['transaksi_status'] = $this->input->get_post('status');

		$result['sample'] = $this->M_request->getRequestNew($param, $where = null);

		$result['sample_jenis'] = $this->M_sample_jenis->getJenisSampleUJi($param);
		$result['pekerjaan_jenis'] = $this->M_sample_pekerjaan->getJenisPekerjaan($param);
		$result['sample_detail'] = $this->M_request->getRequestDetail($param);

		$this->load->view('tampilan/header', $isi);
		$this->load->view('tampilan/sidebar', $data);
		$this->load->view('sample/request_preview', $result);
		$this->load->view('tampilan/footer');
		// $this->load->view('sample/request_proces_js');
	}


	/* GET */
	public function getLab()
	{
		$isi = $this->session->userdata();

		if ($this->input->get('tgl_cari')) $tgl = explode(' - ', $this->input->get('tgl_cari'));
		if ($this->input->get('tgl_cari')) $param['tgl_awal'] = date('Y-m-d', strtotime($tgl[0]));
		if ($this->input->get('tgl_cari')) $param['tgl_akhir'] = date('Y-m-d', strtotime($tgl[1]));
		if ($this->input->get('isi') != 'ok') if ($isi['role_id'] != '1') $param['seksi_id'] = $isi['user_unit_id'];

		$param['transaksi_id'] = $this->input->get('transaksi_id');
		$param['transaksi_non_rutin_id'] = $this->input->get('transaksi_non_rutin_id');
		$param['transaksi_tipe'] = $this->input->get('transaksi_tipe');
		$param['transaksi_status_not_array'] = array('0', '1', '2', '6');
		$param['array_transaksi_status_in'] = array('3', '4', '5');
		// $param['transaksi_status'] = $this->input->get_post('transaksi_status');
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

		$data = $this->M_lab->getLab($param, $where);

		echo json_encode($data);
	}

	public function getLabDetail()
	{
		$param['transaksi_id'] = $this->input->get_post('transaksi_id');
		$param['transaksi_detail_id'] = $this->input->get_post('transaksi_detail_id');
		$param['transaksi_non_rutin_id'] = $this->input->get_post('transaksi_non_rutin_id');
		$param['transaksi_status'] = $this->input->get_post('transaksi_status');

		$data = $this->M_lab->getLabDetail($param);

		echo json_encode($data);
	}

	public function getSeksiDisposisi()
	{
		$param['id_transaksi'] = $this->input->get_post('id_transaksi');
		$param['id_transaksi_detail'] = $this->input->get_post('id_transaksi_detail');
		$param['seksi_disposisi_id'] = $this->input->get_post('seksi_disposisi_id');

		$data = $this->M_lab->getSeksiDisposisi($param);

		echo json_encode($data);
	}


	// /* GET */

	// BARU

	public function insertLabDetail()
	{
		$session = $this->session->userdata();
		$status = $this->input->get_post('transaksi_status');
		$jumlah_upload_data = count($this->input->get_post('transaksi_detail_id'));

		$delete_detail = $this->db->delete('sample.sample_transaksi_detail', array('id_non_rutin' => $this->input->get_post('transaksi_non_rutin_id'), 'transaksi_detail_status' => $this->input->get_post('transaksi_status')));

		$config['upload_path'] = FCPATH . './document/';
		$config['allowed_types'] = '*';
		$this->upload->initialize($config);

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
					$new_attachment  = $data_attachment['file_name'];
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

			$data_detail[] = array(
				'id_non_rutin' => $this->input->get_post('transaksi_non_rutin_id'),
				'transaksi_id' => $this->input->get_post('transaksi_id'),
				'transaksi_detail_id' => $this->input->get_post('transaksi_detail_id')[$i],
				'transaksi_detail_judul' => $this->input->get_post('item_judul')[$i],
				'jenis_id' => $this->input->get_post('jenis_id')[$i],
				'jenis_pekerjaan_id' => $this->input->get_post('jenis_pekerjaan_id')[$i],
				'transaksi_detail_jumlah' => $this->input->get_post('transaksi_detail_jumlah')[$i],
				'identitas_id' => $this->input->get_post('identitas_id')[$i],
				'transaksi_detail_identitas' => $this->input->get_post('transaksi_detail_identitas')[$i],
				'transaksi_detail_parameter' => $this->input->get_post('transaksi_detail_parameter')[$i],
				'transaksi_detail_deskripsi_parameter' => $this->input->get_post('transaksi_detail_deskripsi_parameter')[$i],
				'transaksi_detail_catatan' => $this->input->get_post('transaksi_detail_catatan')[$i],
				'transaksi_detail_attach' => $new_attachment,
				'transaksi_detail_file' => $new_file,
				'id_user_disposisi' => '2105087',
				'peminta_jasa_id' => $this->input->get_post('peminta_jasa_id'),
				'transaksi_detail_pic_pengirim' => $this->input->get_post('transaksi_pic_pengirim'),
				'transaksi_detail_ext_pengirim' => $this->input->get_post('transaksi_detail_ext_pengirim'),
				'transaksi_detail_tgl_pengajuan' => date('Y-m-d H:i:s'),
				'transaksi_detail_status' => $this->input->get_post('transaksi_status'),
				'transaksi_detail_klasifikasi_id' => $this->input->get_post('transaksi_klasifikasi_id'),
				'transaksi_detail_pic_telepon' => $this->input->get_post('transaksi_detail_pic_telepon'),
				'when_create' => date('Y-m-d H:i:s'),
				'who_create' => $session['user_nama_lengkap'],
				'who_seksi_create' => $session['user_unit_id'],
			);
		}
		$this->db->insert_batch('sample.sample_transaksi_detail', $data_detail);
	}

	public function insertDisposisiAVP()
	{
		$session = $this->session->userdata();
		$status = $this->input->get_post('transaksi_status') + 1;

		if (!empty($this->input->get_post('transaksi_disposisi_avp'))) {
			foreach ($this->input->get_post('transaksi_disposisi_avp') as $key => $disposisi_avp) {
				$id_detail = $this->input->get_post('transaksi_disposisi_avp_id_transaksi_detail')[$key];
				$data_detail['is_proses'] = 'y';
				$this->M_request->updateRequestDetail($data_detail, $id_detail);

				$this->db->query("INSERT INTO sample.sample_transaksi_detail SELECT '" . create_id() . "',id_seksi,identitas_id,jenis_id,peminta_jasa_id,transaksi_id,transaksi_detail_pic_pengirim,transaksi_detail_ext_pengirim,transaksi_detail_jumlah,transaksi_detail_parameter,'" . date('Y-m-d H:i:s') . "',transaksi_detail_tgl_memo,null,transaksi_detail_foto,transaksi_detail_tgl_estimasi,transaksi_detail_file,transaksi_detail_no_surat,is_urgent,jenis_pekerjaan_id,'" . date('Y-m-d H:i:s') . "','" . $session['user_nama'] . "',transaksi_detail_note,'" . $status . "',is_khusus,id_user,who_seksi_create,id_non_rutin,transaksi_detail_nomor,transaksi_detail_urut,transaksi_detail_keterangan,null,transaksi_detail_klasifikasi_id,transaksi_detail_nomor_sample,transaksi_detail_id_template_keterangan,transaksi_detail_is_template_keterangan,transaksi_detail_pic_telepon,transaksi_detail_attach,transaksi_detail_judul,transaksi_detail_identitas,transaksi_detail_deskripsi_parameter,transaksi_detail_catatan,'" . $disposisi_avp . "',null,null,NULL,transaksi_detail_tgl_sampling,transaksi_detail_tgl_pengujian FROM sample.sample_transaksi_detail WHERE transaksi_detail_id = '" . $this->input->get_post('transaksi_disposisi_avp_id_transaksi_detail')[$key] . "'");

				$this->db->query("UPDATE sample.sample_transaksi SET transaksi_status = '" . $status . "', transaksi_tgl = '" . date('Y-m-d H:i:s') . "' WHERE transaksi_id = '" . $this->input->get_post('transaksi_disposisi_avp_id_transaksi')[$key] . "'");
			}

			sampleLog($this->input->get_post('transaksi_id'), null, $this->input->get_post('transaksi_non_rutin_id'), $this->input->get_post('transaksi_tipe'), $this->input->get_post('transaksi_status'), 'Pekerjaan Telah Disposisikan Oleh VP PPK');
		}
	}

	public function insertDisposisiSeksi()
	{
		$session = $this->session->userdata();

		$transaksi_id = $this->input->post('transaksi_id');
		$seksi_id_transaksi = ($this->input->get_post('transaksi_disposisi_seksi_id_transaksi'));
		$seksi_id_transaksi_detail =  ($this->input->get_post('transaksi_disposisi_seksi_id_transaksi_detail'));
		$seksi = ($this->input->get_post('transaksi_disposisi_seksi'));
		$jenis_id = $this->input->get_post('jenis_id');
		$jenis_pekerjaan_id = ($this->input->get_post('jenis_pekerjaan_id'));
		$identitas_id = $this->input->get_post('identitas_id');
		$transaksi_tipe = ($this->input->get_post('transaksi_tipe'));
		$transaksi_status = ($transaksi_tipe == 'I') ? (($this->input->get_post('transaksi_status') + 2)) : (($this->input->get_post('transaksi_status') + 1));

		foreach ($seksi_id_transaksi_detail as $key => $id_transaksi_detail) {
			$data_detail['is_proses'] = 'y';
			$this->M_request->updateRequestDetail($data_detail, $id_transaksi_detail);

			$khusus = array("e00c2166d30380a078851809deb0f0b8ca51127d", "c467ca615b90a212089687923100d71e");

			for ($i = 0; $i < $this->input->post('transaksi_detail_jumlah')[$key]; $i++) {

				$param['seksi_id'] = $seksi[$key];
				$seksies = $this->M_user->getSeksi($param);
				$param_nomor['transaksi_tipe'] = $transaksi_tipe;
				$nomor = $this->M_lab->getMaxNoLabBaru($param_nomor);
				$tipe = $transaksi_tipe;
				$seksi_tujuan = $seksies['disposisi_kode'];
				$nomor_urutan = $nomor['urut'] + 1;
				$nomor_urutan_digit = sprintf('%04d', $nomor_urutan);
				$bulan = date('m');
				$tahun = substr(date('Y'), -2);


				/*kode baru*/
				$range = '';
				if($this->input->post('transaksi_tipe')=='I'){
					$range = range('A','E');
				}else if($this->input->post('transaksi_tipe')=='E'){
					$range = range('F','J');
				}else if($this->input->post('transaksi_tipe')=='R'){
					$range = range('K','O');
				}

				$param_nomor_baru['range'] = $range[$key];
				$param_nomor_baru['transaksi_tipe'] = $this->input->post('transaksi_tipe');
				$param_nomor_baru['seksi_kode'] = $seksies['disposisi_kode'];

				$nomor_baru = $this->M_lab->getNoLabBaru($param_nomor_baru);
				$nomor_urutan_baru = $nomor_baru['urut'] + 1;
				$nomor_urutan_digit_baru = sprintf('%04d', $nomor_urutan_baru);

				if ($i < count($range)) {
					$kode_sample = $range[$key].$seksi_tujuan.$bulan.$tahun.$nomor_urutan_digit;
				} else {
					$kode_sample = $range[($key-1)-$i].$seksi_tujuan.$bulan.$tahun.$nomor_urutan_digit;
				}

				/*kode baru*/

				// $kode_sample = $tipe . $seksi_tujuan . $bulan . $tahun . $nomor_urutan_digit;


				// die();
				$seksi_id_transaksi_detail_baru = create_id();

				if (in_array($jenis_pekerjaan_id[$key], $khusus)) {
					$this->db->query("INSERT INTO sample.sample_transaksi_detail SELECT '" . $seksi_id_transaksi_detail_baru . "',id_seksi,identitas_id,'" . $jenis_id[$key] . "',peminta_jasa_id,'" . $transaksi_id . "',transaksi_detail_pic_pengirim,transaksi_detail_ext_pengirim,'1',transaksi_detail_parameter,transaksi_detail_tgl_pengajuan,transaksi_detail_tgl_memo,transaksi_detail_no_memo,transaksi_detail_foto,transaksi_detail_tgl_estimasi,transaksi_detail_file,transaksi_detail_no_surat,is_urgent,'" . $jenis_pekerjaan_id[$key] . "','" . date('Y-m-d H:i:s') . "','" . $session['user_nama'] . "',transaksi_detail_note,'" . $transaksi_status . "',is_khusus,id_user,'" . $seksi[$key] . "',id_non_rutin,transaksi_detail_nomor,'" . $nomor_urutan . "',transaksi_detail_keterangan,transaksi_detail_kode_tracking,transaksi_detail_klasifikasi_id,'" . $kode_sample . "',transaksi_detail_id_template_keterangan,transaksi_detail_is_template_keterangan,transaksi_detail_pic_telepon,transaksi_detail_attach,transaksi_detail_judul,transaksi_detail_identitas,transaksi_detail_deskripsi_parameter,transaksi_detail_catatan,id_user_disposisi,id_disposisi,id_seksi_disposisi,transaksi_detail_reject_alasan,transaksi_detail_agreement_keterangan,'y',NULL,transaksi_detail_tgl_sampling,transaksi_detail_tgl_pengujian FROM sample.sample_transaksi_detail WHERE transaksi_detail_id = '" . $id_transaksi_detail . "'");
				} else {
					$this->db->query("INSERT INTO sample.sample_transaksi_detail SELECT '" . $seksi_id_transaksi_detail_baru . "',id_seksi,identitas_id,'" . $jenis_id[$key] . "',peminta_jasa_id,'" . $transaksi_id . "',transaksi_detail_pic_pengirim,transaksi_detail_ext_pengirim,'1',transaksi_detail_parameter,transaksi_detail_tgl_pengajuan,transaksi_detail_tgl_memo,transaksi_detail_no_memo,transaksi_detail_foto,transaksi_detail_tgl_estimasi,transaksi_detail_file,transaksi_detail_no_surat,is_urgent,'" . $jenis_pekerjaan_id[$key] . "','" . date('Y-m-d H:i:s') . "','" . $session['user_nama'] . "',transaksi_detail_note,'" . $transaksi_status . "',is_khusus,id_user,'" . $seksi[$key] . "',id_non_rutin,transaksi_detail_nomor,'" . $nomor_urutan . "',transaksi_detail_keterangan,transaksi_detail_kode_tracking,transaksi_detail_klasifikasi_id,'" . $kode_sample . "',transaksi_detail_id_template_keterangan,transaksi_detail_is_template_keterangan,transaksi_detail_pic_telepon,transaksi_detail_attach,transaksi_detail_judul,transaksi_detail_identitas,transaksi_detail_deskripsi_parameter,transaksi_detail_catatan,id_user_disposisi,id_disposisi,id_seksi_disposisi,transaksi_detail_reject_alasan,transaksi_detail_agreement_keterangan,is_sampling,NULL,transaksi_detail_tgl_sampling,transaksi_detail_tgl_pengujian FROM sample.sample_transaksi_detail WHERE transaksi_detail_id = '" . $id_transaksi_detail . "'");
				}

				$this->db->query("INSERT INTO sample.sample_seksi_disposisi VALUES ('" . create_id() . "','" . $seksi[$key] . "','" . $transaksi_id . "','" . $seksi_id_transaksi_detail_baru . "')");
			}
			$this->db->query("UPDATE sample.sample_transaksi SET transaksi_status = '" . $transaksi_status . "' WHERE transaksi_id = '" . $transaksi_id . "'");
		}
		sampleLog(anti_inject($this->input->get_post('transaksi_id')), null, anti_inject($this->input->get_post('transaksi_non_rutin_id')), anti_inject($this->input->get_post('transaksi_tipe')), anti_inject($this->input->get_post('transaksi_status')), 'Pekerjaan Telah Disposisikan Oleh AVP LUK');
	}

	public function insertDisposisiSeksiChemlat()
	{
		$session = $this->session->userdata();

		$seksi_id_transaksi = $this->input->get_post('transaksi_disposisi_seksi_id_transaksi_chemlat');
		$seksi_id_transaksi_detail =  $this->input->get_post('transaksi_disposisi_seksi_id_transaksi_detail_chemlat');
		$seksi = $this->input->get_post('transaksi_disposisi_seksi_chemlat');
		$jenis_pekerjaan_id = $this->input->get_post('jenis_pekerjaan_id');
		$jenis_id = $this->input->get_post('jenis_id');
		$petugas = $this->input->get_post('transaksi_petugas_sampling_chemlat');
		$tanggal = $this->input->get_post('transaksi_detail_tgl_sampling');
		$transaksi_tipe = $this->input->get_post('transaksi_tipe');
		$transaksi_status = $this->input->get_post('transaksi_status') + 1;

		foreach ($seksi_id_transaksi_detail as $key => $id_transaksi_detail) {
			if ($tanggal[$key] == '00-00-0000') {
				$tanggal_sampling = '1970-01-01';
				$is_sampling = 'n';
			} else {
				$tanggal_sampling = date('Y-m-d', strtotime($tanggal[$key]));
				$is_sampling = 'y';
			}

			$id_detail = $id_transaksi_detail;
			$data_detail['is_proses'] = 'y';
			$this->M_request->updateRequestDetail($data_detail, $id_detail);

			$seksi_id_transaksi_detail_baru = create_id();
			$this->db->query("INSERT INTO sample.sample_transaksi_detail SELECT '" . $seksi_id_transaksi_detail_baru . "',id_seksi,identitas_id,'" . $jenis_id[$key] . "',peminta_jasa_id,'" . $seksi_id_transaksi[$key] . "',transaksi_detail_pic_pengirim,transaksi_detail_ext_pengirim,transaksi_detail_jumlah,transaksi_detail_parameter,transaksi_detail_tgl_pengajuan,transaksi_detail_tgl_memo,transaksi_detail_no_memo,transaksi_detail_foto,transaksi_detail_tgl_estimasi,transaksi_detail_file,transaksi_detail_no_surat,is_urgent,'" . $jenis_pekerjaan_id[$key] . "','" . date('Y-m-d H:i:s') . "','" . $session['user_nama'] . "',transaksi_detail_note,'" . $transaksi_status . "',is_khusus,id_user,'" . $seksi[$key] . "',id_non_rutin,transaksi_detail_nomor,transaksi_detail_urut,transaksi_detail_keterangan,transaksi_detail_kode_tracking,transaksi_detail_klasifikasi_id,transaksi_detail_nomor_sample,transaksi_detail_id_template_keterangan,transaksi_detail_is_template_keterangan,transaksi_detail_pic_telepon,transaksi_detail_attach,transaksi_detail_judul,transaksi_detail_identitas,transaksi_detail_deskripsi_parameter,transaksi_detail_catatan,id_user_disposisi,id_disposisi,id_seksi_disposisi,transaksi_detail_reject_alasan,transaksi_detail_agreement_keterangan,'" . $is_sampling . "',NULL,'" . $tanggal_sampling . "',transaksi_detail_tgl_pengujian FROM sample.sample_transaksi_detail WHERE transaksi_detail_id = '" . $id_transaksi_detail . "'");

			$this->db->query("UPDATE sample.sample_transaksi SET transaksi_status = '" . $transaksi_status . "' WHERE transaksi_id = '" . $seksi_id_transaksi[$key] . "'");

			$this->db->query("DELETE FROM sample.sample_seksi_disposisi WHERE id_transaksi = '" . $seksi_id_transaksi[$key] . "' AND id_transaksi_detail = '" . $id_transaksi_detail . "'");

			$this->db->query("INSERT INTO sample.sample_seksi_disposisi VALUES ('" . create_id() . "','" . $seksi[$key] . "','" . $seksi_id_transaksi[$key] . "','" . $seksi_id_transaksi_detail_baru . "')");
				if ($this->input->get_post('transaksi_petugas_sampling_chemlat')[$id_transaksi_detail]) {
					foreach ($this->input->get_post('transaksi_petugas_sampling_chemlat')[$id_transaksi_detail] as $key_petugas => $petugase) {
						$this->db->query("INSERT INTO sample.sample_petugas VALUES ('" . create_id() . "','" . $seksi_id_transaksi[$key] . "','" . $petugase . "','" . $seksi_id_transaksi_detail_baru . "')");
					}
				} else {
					$seksi_petugas = $this->db->query("SELECT * FROM global.global_user WHERE id_seksi IN(select id_seksi FROM sample.sample_seksi_disposisi WHERE id_transaksi_detail = '" . $seksi_id_transaksi_detail_baru . "' AND id_seksi = '" . $seksi[$key] . "')")->result_array();
				// $seksi_petugas = $this->db->query("SELECT * FROM global.global_user WHERE id_seksi IN(select id_seksi FROM sample.sample_seksi_disposisi WHERE id_transaksi_detail = '" . $id_transaksi_detail . "' AND id_seksi = '" . $seksi[$key] . "')")->result_array();
						foreach ($seksi_petugas as $seksi_petugase) {
							$this->db->query("INSERT INTO sample.sample_petugas VALUES ('" . create_id() . "','" . $seksi_id_transaksi[$key] . "','" . $seksi_petugase['user_id'] . "','" . $seksi_id_transaksi_detail_baru . "')");
						}
					}
				}
				sampleLog($this->input->get_post('transaksi_id'), null, $this->input->get_post('transaksi_non_rutin_id'), $this->input->get_post('transaksi_tipe'), $this->input->get_post('transaksi_status'), 'Pekerjaan Telah Disposisikan Oleh Chemlat');
			}

	// cetak
			public function cetakKeterangan()
			{
				$param['transaksi_keterangan_id'] = anti_inject($this->input->get_post('transaksi_keterangan_id'));
				$data['keterangan'] = $this->M_request->getKeterangan($param);
				$this->load->view('sample/cetak/memo', $data, FALSE);
			}
	// cetak

		}
