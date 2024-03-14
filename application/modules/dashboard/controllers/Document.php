<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Document extends MY_Controller{

	public function __construct() {
		parent::__construct();

		$this->load->model('dashboard/M_document');
	}

	public function index() {
		$isi['judul'] = 'Document';
		$data = $this->session->userdata();
		$data['id_sidebar'] = $this->input->get('id_sidebar');
		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

		$this->template->template_master('dashboard/document',$isi,$data);
	}

	public function getDocument() {
		$data = $this->M_document->getDocument();
		echo json_encode($data);
	}

	public function getDocumentJenis() {
		$param = array();

		if ($this->input->get('jenis_id')) $param['jenis_id'] = $this->input->get('jenis_id');

		$data = $this->M_document->getDocumentJenis($param);
		echo json_encode($data);
	}

	public function getDocumentSeksi() {
		$param = array();

		if ($this->input->get('seksi_id')) $param['seksi_id'] = $this->input->get('seksi_id');

		$data = $this->M_document->getDocumentSeksi($param);
		// echo $this->db->last_query();
		echo json_encode($data);
	}

	public function getDocumentJenisSum() {
		$data = $this->M_document->getDocumentJenisSum();
		echo json_encode($data);
	}

	public function getDocumentSeksiSum() {
		$data = $this->M_document->getDocumentSeksiSum();
		echo json_encode($data);
	}

	public function getDocumentHasil() {
		$data = $this->M_document->getDocumentHasil();
		echo json_encode($data);
	}
}