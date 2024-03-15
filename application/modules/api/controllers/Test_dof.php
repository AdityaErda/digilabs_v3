<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test_dof extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		isLogin();
	}

	public function index()
	{
		
	}

	public function login(){
		$isi['username'] = 'digilab_apps_dev';
		$isi['password'] = 'Digilab123';
			// get token
		$client_id = "";
		$client_secret = "";
		$tokenUrl = "https://newdevdof.petrokimia-gresik.com/api/v2/Account/Login";
		$tokenContent = "grant_type=password&username=".$isi['username']."&password=".$isi['password'].""; // sementara
		// $tokenContent = "grant_type=password&username=digilab_apps_dev&password=Digilab123"; // sementara
		// $authorization = base64_encode("$client_id:$client_secret");
		$tokenHeaders = array("User-Agent:PostmanRuntime/7.30.0", "Content-Type: application/x-www-form-urlencoded");
		$token = curl_init();

		curl_setopt($token, CURLOPT_URL, $tokenUrl);
		curl_setopt($token, CURLOPT_HTTPHEADER, $tokenHeaders);
		curl_setopt($token, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($token, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($token, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($token, CURLOPT_MAXREDIRS, 10);
		curl_setopt($token, CURLOPT_TIMEOUT, 0);
		curl_setopt($token, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($token, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($token, CURLOPT_POSTFIELDS, $tokenContent);

		$item = curl_exec($token);
		curl_close($token);

		echo "<pre>";
		print_r($item);
		echo "</pre>";;

	}

}

/* End of file Test_dof.php */
/* Location: ./application/controllers/Test_dof.php */