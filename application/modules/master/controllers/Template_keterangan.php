<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Template_keterangan extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
		$this->load->model('M_template_keterangan');
	}

	public function index()
	{
		
	}


	// GET 

	public function getJenisTemplateList(){
		$jenis['results'] = array();
		$param['template_jenis_id'] = $this->input->get_post('template_jenis_id');
    	$param['param_search'] = $this->input->get('param_search');
    		foreach ($this->M_template_keterangan->getJenisTemplate($param) as $key => $value) {
     		 array_push($jenis['results'], [
        	'id' => $value['template_jenis_id'],
        	'text' => $value['template_jenis_nama'],
      	]);
    	}
    	echo json_encode($jenis);
	}

	public function getTemplateKeteranganList(){
		$keterangan['results'] = array();
    	$param['template_keterangan_nama'] = $this->input->get('keterangan_nama');
    		foreach ($this->M_template_keterangan->getTemplateKeterangan($param) as $key => $value) {
     		 array_push($keterangan['results'], [
        	'id' => $value['template_keterangan_id'],
        	'text' => $value['template_keterangan_nama'],
        	'jenis'=> $value['template_keterangan_jenis'],
      	]);
    	}
    	echo json_encode($keterangan);
	}
	// GET


}

/* End of file Template_keterangan.php */
