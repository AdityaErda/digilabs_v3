<?php
function api($data)
{
	$url = "http://localhost/api/" . $data;

	return $url;
}

function create_id()
{
	/* ID OTOMATIS */
	$r = rand();
	$u = uniqid(getmypid() . $r . (float)microtime() * 1000000, true);
	$id = sha1(session_id() . $u);

	return $id;
}

function dblog($tipe, $id_barang = null, $harga = null)
{
	$CI = &get_instance();
	$isi = $CI->session->userdata();

	$data['log_id'] = create_id();
	$data['log_data'] = addslashes($CI->db->last_query());
	$data['log_tipe'] = strtoupper($tipe);
	$data['log_ip'] = ($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'UNKNOWN IP';
	$data['barang_id'] = $id_barang;
	$data['barang_harga'] = $harga;
	$data['log_when'] = date('Y-m-d H:i:s');
	$data['log_who'] = $isi['user_nama_lengkap'];

	$CI->db->insert('global.global_dblog', $data);

	$CI->db->affected_rows();
}

function auditHistory($id_audit = null, $status = null, $alasan = null, $tgl = null)
{
	$CI = &get_instance();
	$sesi = $CI->session->userdata();

	$data['audit_detail_id'] = create_id();
	$data['id_audit'] = $id_audit;
	$data['audit_detail_status'] = $status;
	$data['audit_detail_penyebab'] = $alasan;
	$data['who_create'] = $sesi['user_nama_lengkap'];
	$data['when_create'] = date('Y-m-d H:i:s');
	$data['audit_detail_tanggal'] = $tgl;

	$CI->db->insert('audit.audit_detail', $data);
	$CI->db->affected_rows();
}

function materialAsetHisotri($id_perbaikan = null, $status = null)
{
	$CI = &get_instance();
	$sesi = $CI->session->userdata();

	$data['material_aset_histori_id'] = create_id();
	$data['id_perbaikan_aset'] = $id_perbaikan;
	$data['material_aset_histori_status'] = $status;
	$data['who_create'] = $sesi['user_nama_lengkap'];
	$data['material_aset_histori_waktu'] = date('Y-m-d H:i:s');

	$CI->db->insert('material.material_aset_histori', $data);
	$CI->db->affected_rows();
}

function materialHistory($tipe, $id_transaksi = null, $status = null, $keterangan = null)
{
	$CI = &get_instance();
	$sesi = $CI->session->userdata();

	$data['transaksi_history_id'] = create_id();
	$data['id_transaksi'] = $id_transaksi;
	$data['transaksi_history_tipe'] = strtoupper($tipe);
	$data['transaksi_history_status'] = $status;
	$data['transaksi_history_ip'] = ($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'UNKNOWN IP';
	$data['transaksi_history_who'] = $sesi['user_nama_lengkap'];
	$data['transaksi_history_when'] = date('Y-m-d H:i:s');
	$data['transaksi_history_data'] = $CI->db->last_query();
	$data['transaksi_history_keterangan'] = $keterangan;

	$CI->db->insert('material.material_transaksi_history', $data);

	$CI->db->affected_rows();
}

function sampleLog($id_transaksi = '', $id_transaksi_detail = '', $id_non_rutin = '', $transaksi_tipe = '', $transaksi_status = '', $transaksi_keterangan = '')
{
	$CI = &get_instance();
	$sesi = $CI->session->userdata();

	$data['sample_log_id'] = create_id();
	$data['sample_log_id_transaksi'] = $id_transaksi;
	$data['sample_log_id_transaksi_detail'] = $id_transaksi_detail;
	$data['sample_log_id_non_rutin'] = $id_non_rutin;
	$data['sample_log_tipe'] = $transaksi_tipe;
	$data['sample_log_status'] = $transaksi_status;
	$data['sample_log_who'] =  ($sesi['user_id'] == '1') ?  'Super Admin' : $sesi['user_nama'];
	$data['sample_log_when'] = date('Y-m-d H:i:s');
	$data['sample_log_ip'] = ($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'UNKNOWN IP';
	$data['sample_log_query'] = $CI->db->last_query();
	$data['sample_log_keterangan'] = $transaksi_keterangan;
	$data['sample_log_url'] = ($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : 'UNKNOWN URL';

	$CI->db->insert('sample.sample_log', $data);

	$CI->db->affected_rows();
}


function logsheetHistory($sample_logsheet_id, $sample_transaksi_id, $sample_transaksi_detail_id, $sample_transaksi_non_rutin_id, $sample_history_detail, $sample_history_isi, $sample_history_hasil)
{
	$CI = &get_instance();
	$sesi = $CI->session->userdata();

	$data['history_logsheet_id'] = create_id();
	$data['sample_logsheet_id'] = $sample_logsheet_id;
	$data['sample_transaksi_id'] = $sample_transaksi_id;
	$data['sample_transaksi_detail_id'] = $sample_transaksi_detail_id;
	$data['sample_transaksi_non_rutin_id'] = $sample_transaksi_non_rutin_id;
	// $data['history_logsheet_tipe'] =
	// $data['history_logsheet_status'] =
	$data['history_logsheet_who'] = $sesi['user_nama'];
	$data['history_logsheet_when'] = date('Y-m-d H:i:s');
	$data['history_logsheet_ip'] = ($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'UNKNOWN IP';
	// $data['history_logsheet_query'] =
	$data['history_logsheet_url'] = ($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : 'UNKNOWN URL';
	$data['sample_history_detail'] = $sample_history_detail;
	$data['sample_history_isi'] = $sample_history_isi;
	$data['sample_history_hasil'] = $sample_history_hasil;

	$CI->db->insert('global.global_history_logsheet', $data);

	$CI->db->affected_rows();
}

function indo_date($date)
{

	$newDate = date('d-m-y', strtotime($date));

	return $newDate;
}

function anti_inject($kata)
{
	$filter = htmlentities(stripslashes(stripcslashes(strip_tags(($kata)))));
	return $filter;
}

function anti_inject_replace($kata)
{
	$pattern = '/[^a-zA-Z0-9]+/'; // Matches anything that is not a letter (a-zA-Z) or a digit (0-9)
	$filter = htmlentities(stripslashes(stripcslashes(strip_tags(preg_replace($pattern, '', $kata)))));
	return $filter;
}

function anti_inject_angka($kata)
{
	$pattern = '/[^0-9]+/'; // Matches anything that is not a letter (a-zA-Z) or a digit (0-9)
	$filter = htmlentities(stripslashes(stripcslashes(strip_tags(preg_replace($pattern, '', $kata)))));
	return $filter;
}

function anti_inject_js($kata)
{
	$filter = htmlentities(stripslashes(stripcslashes(strip_tags(htmlspecialchars($kata, ENT_QUOTES, 'UTF-8')))));
	return $filter;
}

function angkaHuruf($bilangan)
{

	$angka = array(
		'0', '0', '0', '0', '0', '0', '0', '0', '0', '0',
		'0', '0', '0', '0', '0', '0'
	);
	$kata = array(
		'', 'satu', 'dua', 'tiga', 'empat', 'lima',
		'enam', 'tujuh', 'delapan', 'sembilan'
	);
	$tingkat = array('', 'ribu', 'juta', 'milyar', 'triliun');

	$panjang_bilangan = strlen($bilangan);

	/* pengujian panjang bilangan */
	if ($panjang_bilangan > 15) {
		$kalimat = "Diluar Batas";
		return $kalimat;
	}

	/* mengambil angka-angka yang ada dalam bilangan,
  dimasukkan ke dalam array */
	for ($i = 1; $i <= $panjang_bilangan; $i++) {
		$angka[$i] = substr($bilangan, - ($i), 1);
	}

	$i = 1;
	$j = 0;
	$kalimat = "";


	/* mulai proses iterasi terhadap array angka */
	while ($i <= $panjang_bilangan) {

		$subkalimat = "";
		$kata1 = "";
		$kata2 = "";
		$kata3 = "";

		/* untuk ratusan */
		if ($angka[$i + 2] != "0") {
			if ($angka[$i + 2] == "1") {
				$kata1 = "seratus";
			} else {
				$kata1 = $kata[$angka[$i + 2]] . " ratus";
			}
		}

		/* untuk puluhan atau belasan */
		if ($angka[$i + 1] != "0") {
			if ($angka[$i + 1] == "1") {
				if ($angka[$i] == "0") {
					$kata2 = "sepuluh";
				} elseif ($angka[$i] == "1") {
					$kata2 = "sebelas";
				} else {
					$kata2 = $kata[$angka[$i]] . " belas";
				}
			} else {
				$kata2 = $kata[$angka[$i + 1]] . " puluh";
			}
		}

		/* untuk satuan */
		if ($angka[$i] != "0") {
			if ($angka[$i + 1] != "1") {
				$kata3 = $kata[$angka[$i]];
			}
		}

		/* pengujian angka apakah tidak nol semua,
    lalu ditambahkan tingkat */
		if (($angka[$i] != "0") or ($angka[$i + 1] != "0") or
			($angka[$i + 2] != "0")
		) {
			$subkalimat = "$kata1 $kata2 $kata3 " . $tingkat[$j] . " ";
		}

		/* gabungkan variabe sub kalimat (untuk satu blok 3 angka)
    ke variabel kalimat */
		$kalimat = $subkalimat . $kalimat;
		$i = $i + 3;
		$j = $j + 1;
	}

	/* mengganti satu ribu jadi seribu jika diperlukan */
	if (($angka[5] == "0") and ($angka[6] == "0")) {
		$kalimat = str_replace("satu ribu", "seribu", $kalimat);
	}

	return trim($kalimat);
}

// function angkaHuruf1($num)
// {

// 	$ones = array(
// 		0 =>"Kosong",
// 		1 => "ONE",
// 		2 => "TWO",
// 		3 => "THREE",
// 		4 => "FOUR",
// 		5 => "FIVE",
// 		6 => "SIX",
// 		7 => "SEVEN",
// 		8 => "EIGHT",
// 		9 => "NINE",
// 		10 => "TEN",
// 		11 => "ELEVEN",
// 		12 => "TWELVE",
// 		13 => "THIRTEEN",
// 		14 => "FOURTEEN",
// 		15 => "FIFTEEN",
// 		16 => "SIXTEEN",
// 		17 => "SEVENTEEN",
// 		18 => "EIGHTEEN",
// 		19 => "NINETEEN",
// 		"014" => "FOURTEEN"
// 	);
// 	$tens = array(
// 		0 => "ZERO",
// 		1 => "TEN",
// 		2 => "TWENTY",
// 		3 => "THIRTY",
// 		4 => "FORTY",
// 		5 => "FIFTY",
// 		6 => "SIXTY",
// 		7 => "SEVENTY",
// 		8 => "EIGHTY",
// 		9 => "NINETY"
// 	);
// 	$hundreds = array(
// 		"HUNDRED",
// 		"THOUSAND",
// 		"MILLION",
// 		"BILLION",
// 		"TRILLION",
// 		"QUARDRILLION"
// 	); /*limit t quadrillion */
// 	$num = number_format($num,2,".",",");
// 	$num_arr = explode(".",$num);
// 	$wholenum = $num_arr[0];
// 	$decnum = $num_arr[1];
// 	$whole_arr = array_reverse(explode(",",$wholenum));
// 	krsort($whole_arr,1);
// 	$rettxt = "";
// 	foreach($whole_arr as $key => $i){

// 		while(substr($i,0,1)=="0")
// 			$i=substr($i,1,5);
// 		if($i < 20){
// 			/* echo "getting:".$i; */
// 			$rettxt .= $ones[$i];
// 		}elseif($i < 100){
// 			if(substr($i,0,1)!="0")  $rettxt .= $tens[substr($i,0,1)];
// 			if(substr($i,1,1)!="0") $rettxt .= " ".$ones[substr($i,1,1)];
// 		}else{
// 			if(substr($i,0,1)!="0") $rettxt .= $ones[substr($i,0,1)]." ".$hundreds[0];
// 			if(substr($i,1,1)!="0")$rettxt .= " ".$tens[substr($i,1,1)];
// 			if(substr($i,2,1)!="0")$rettxt .= " ".$ones[substr($i,2,1)];
// 		}
// 		if($key > 0){
// 			$rettxt .= " ".$hundreds[$key]." ";
// 		}
// 	}
// 	if($decnum > 0){
// 		$rettxt .= " and ";
// 		if($decnum < 20){
// 			$rettxt .= $ones[$decnum];
// 		}elseif($decnum < 100){
// 			$rettxt .= $tens[substr($decnum,0,1)];
// 			$rettxt .= " ".$ones[substr($decnum,1,1)];
// 		}
// 	}
// 	return $rettxt;
// }

function isLogin()
{
	$CI = &get_instance();
	$session = $CI->session->userdata();
	if (empty($session['user_id'])) {
		$CI->session->set_flashdata('pesan', 'Dilarang Akses Tanpa Login');
		redirect(base_url('login'), 'refresh');
	}
}
