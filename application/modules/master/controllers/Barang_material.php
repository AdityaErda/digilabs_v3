 <?php
 defined('BASEPATH') or exit('No direct script access allowed');

 class Barang_material extends MY_Controller{

 	public function __construct(){
 		parent::__construct();

 		$this->load->model('master/M_material_item');
 		$this->load->model('master/M_material_jenis');
 		$this->load->model('master/M_material_gl_account');
 		$this->load->model('material/M_request');
 	}

 	public function index(){
 		$isi['judul'] = 'Barang Material';
 		$data = $this->session->userdata();
 		$data['id_sidebar'] = $this->input->get('id_sidebar');
 		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

 		$this->template->template_master('master/barang_material',$isi,$data);
 	}

 	public function getBarangMaterial(){
 		$param['item_id'] = $this->input->get('item_id');
 		$param['item_nama'] = $this->input->get('item_nama');

 		$data = $this->M_material_item->getBarangMaterial($param);
 		echo json_encode($data);
 	}

 	public function getJenis(){
 		$listJenis['results'] = array();

 		$param['jenis_nama'] = $this->input->get('material_nama');
 		foreach ($this->M_material_jenis->getJenisBarang($param) as $key => $value) {
 			array_push($listJenis['results'], [
 				'id' => $value['jenis_id'],
 				'text' => $value['jenis_nama'],
 			]);
 		}

 		echo json_encode($listJenis);
 	}

 	public function getGlAccount(){
 		$listGlAccount['results'] = array();

 		$param['gl_account_nama'] = $this->input->get('gl_account_nama');
 		foreach ($this->M_material_gl_account->getGlAccount($param) as $key => $value) {
 			array_push($listGlAccount['results'], [
 				'id' => $value['gl_account_id'],
 				'text' => $value['gl_account_nama'],
 			]);
 		}

 		echo json_encode($listGlAccount);
 	}
 	/* GET */

 	/* INSERT */
 	public function insertBarangMaterial(){
 		$isi = $this->session->userdata();

 		$data['item_id'] = create_id();
 		$data['jenis_id'] = anti_inject($this->input->post('jenis_id'));
 		$data['gl_account_id'] = anti_inject($this->input->post('gl_account_id'));
 		$data['item_nama'] = anti_inject($this->input->post('item_nama'));
 		$data['item_katalog_number'] = anti_inject($this->input->post('item_katalog_number'));
 		$data['item_merk'] = anti_inject($this->input->post('item_merk'));
 		$data['item_kode'] = anti_inject($this->input->post('item_kode'));
 		$data['item_harga'] = anti_inject($this->input->post('item_harga'));
 		$data['item_satuan'] = anti_inject($this->input->post('item_satuan'));
 		$data['item_stok'] = anti_inject($this->input->get_post('stok_awal'));
 		$data['item_stok_alert'] = anti_inject($this->input->get_post('stok_alert'));
 		$data['when_create'] = date('Y-m-d H:i:s');
 		$data['who_create'] = $isi['user_nama_lengkap'];

 		$this->M_material_item->insertBarangMaterial($data);

 		dblog('I', $data['item_id'], $data['item_harga']);

 		$itemId['item_id'] = $data['item_id'];

 		$harga = $this->M_material_item->getBarangMaterial($itemId);

			// insert transaksi detail
 		$data1['transaksi_detail_id'] = create_id();
 		$data1['transaksi_id'] = create_id();
 		$data1['item_id'] = $data['item_id'];
 		$data1['transaksi_detail_jumlah'] = $data['item_stok'];
 		$data1['transaksi_detail_total'] = $data1['transaksi_detail_jumlah'] * $data['item_harga'];
 		$data1['when_create'] = date('Y-m-d H:i:s');
 		$data1['who_create'] = $isi['user_nama_lengkap'];

 		$this->M_request->insertEasyuiMaterial($data1);

			// insert transaksi
 		$data2['transaksi_id'] = $data1['transaksi_id'];
 		$data2['company_code'] = '1';
 		$data2['id_gudang_asal'] = '';
 		$data2['id_gudang_tujuan'] = '1';
 		$data2['transaksi_waktu'] = date('Y-m-d', strtotime(date('Y-m-d')));
 		$data2['transaksi_jam'] = date('H:i:s');
 		$data2['transaksi_tipe'] = 'i';
 		$data2['transaksi_status'] = 'y';
 		$data2['when_create'] = date('Y-m-d H:i:s');
 		$data2['who_create'] = $isi['user_nama_lengkap'];

 		$this->M_request->InsertTransaksiIn($data2);

			// insert ke batch
 		$tahun = date('Y');
 		$bulan = date('m');
 		$tahun_potong = substr($tahun, '2');
 		$where = " 1=1 ";
 		$where .= " and transaksi_waktu >= " . "'" . $tahun . '-01-01' . "'";
 		$where .= " and transaksi_waktu <= " . "'" . $tahun . '-12-31' . "'";


 		$urut = $this->db->query("SELECT max(list_batch_kode) as urut FROM material.material_list_batch a left join material.material_transaksi b on a.transaksi_id = b.transaksi_id WHERE " . $where . " ")->row_array();
 		$kode = $urut['urut'] + 1;
 		$kodeUrut =  sprintf("%02s", $kode);

 		$jenisId['jenis_id'] = $data['jenis_id'];

 		$jenis = $this->M_material_jenis->getJenisBarang($jenisId);

 		$kodeFinal = $kodeUrut . $jenis['jenis_kode'] . $bulan . $tahun_potong;


 		$data3['list_batch_id'] = create_id();
 		$data3['transaksi_id'] = $data1['transaksi_id'];
 		$data3['transaksi_detail_id'] = $data1['transaksi_detail_id'];
 		$data3['list_batch_stok'] = $data['item_stok'];
 		$data3['who_create'] = $isi['user_nama_lengkap'];
 		$data3['when_create'] = date('Y-m-d H:i:s');
 		$data3['list_batch_kode'] = $kodeUrut;
 		$data3['list_batch_kode_final'] = $kodeFinal;

 		$this->M_request->InsertListBatch($data3);


 		$stok['item_id'] = $data['item_id'];
 		$stokList = $this->M_request->getItemJumlah($stok);

			// insert stok
 		$data4['list_stok_id'] = create_id();
 		$data4['item_id'] = $stok['item_id'];
 		$data4['company_code'] = '1';
 		$data4['id_gudang'] = $data2['id_gudang_tujuan'];
 		$data4['transaksi_detail_id'] = $data1['transaksi_detail_id'];
 		$data4['list_stok_waktu'] = $data2['transaksi_waktu'];
 		$data4['list_stok_jam'] = date('H:i:s');
 		$data4['list_stok_tipe'] = 'i';
 		$data4['list_stok_jumlah'] = anti_inject($this->input->get_post('stok_awal'));
 		$data4['list_stok_stok'] =  $stokList['item_stok'];
 		$data4['when_create'] = date('Y-m-d H:i:s');
 		$data4['who_create'] = $isi['user_nama_lengkap'];
 		$data4['list_batch_id'] = $data3['list_batch_id'];

 		$this->M_request->InsertListStok($data4);
			// print_r($this->db->last_query());

 		$idStok = $stok['item_id'];
 		$data5['item_stok'] = $data4['list_stok_stok'];
 		$this->M_request->updatejmlMaterialItem($idStok, $data5);

 		$transaksiId = $data1['transaksi_id'];





 		$batch['transaksi_id'] = $data1['transaksi_id'];
 		$stokBatch = $this->M_request->getSumDetailJumlah($batch);
 	}
 	/* INSERT */

 	/* UPDATE */
 	public function updateBarangMaterial(){
 		$isi = $this->session->userdata();

 		$id = anti_inject($this->input->post('item_id'));
 		$data = array(
 			'jenis_id' => $this->input->post('jenis_id'),
 			'gl_account_id' => $this->input->post('gl_account_id'),
 			'item_nama' => $this->input->post('item_nama'),
 			'item_katalog_number' => $this->input->post('item_katalog_number'),
 			'item_merk' => $this->input->post('item_merk'),
 			'item_kode' => $this->input->post('item_kode'),
 			'item_harga' => $this->input->post('item_harga'),
 			'item_satuan' => $this->input->post('item_satuan'),
 			'item_stok_alert' => $this->input->post('stok_alert'),
 			'when_create' => date('Y-m-d H:i:s'),
 			'who_create' => $isi['user_nama_lengkap'],
 		);

 		$this->M_material_item->updateBarangMaterial($data, $id);

 		dblog('U', $id, $data['item_harga']);

 		$this->fun_ganti_harga($id);
 	}
 	/* UPDATE */

 	/* DELETE */
 	public function deleteBarangMaterial(){
 		$this->M_material_item->deleteBarangMaterial($this->input->get('item_id'));
 	}
 	/* DELETE */

 	/* DELETE */
 	public function resetBarangMaterial(){
 		$this->M_material_item->resetBarangMaterial();
 	}
 	/* DELETE */

 	/* GET HISTORY */
 	public function getHistory(){
 		$param['item_id'] = $this->input->get('item_id');

 		$data = $this->M_material_item->getHistory($param);
 		echo json_encode($data);
 	}
 	/* GET HISTORY */

 	/* GET DETAIL */
 	public function getKomposisi(){
 		$param['komposisi_id'] = $this->input->get('komposisi_id');
 		$param['item_id'] = $this->input->get('item_id');

 		$data = $this->M_material_item->getKomposisi($param);
 		echo json_encode($data);
 	}

 	public function getItem(){
 		$listItem['results'] = array();

 		$param['item_nama'] = $this->input->get('item_nama');
 		foreach ($this->M_material_item->getBarangMaterial($param) as $key => $value) {
 			array_push($listItem['results'], [
 				'id' => $value['item_id'],
 				'text' => $value['item_nama'] . ' - ' . $value['item_harga'],
 			]);
 		}

 		echo json_encode($listItem);
 	}
 	/* GET DETAIL */

 	/* INSERT DETAIL */
 	public function insertKomposisi(){
 		$value = $this->session->userdata();
 		$isi = $this->fun_komposisi_harga($this->input->post('komposisi_item'));

 		$data['komposisi_id'] = create_id();
 		$data['item_id'] = anti_inject($this->input->post('temp_item_id'));
 		$data['komposisi_persen'] = anti_inject($this->input->post('komposisi_persen'));
 		$data['komposisi_item'] = anti_inject($this->input->post('komposisi_item'));
 		$data['komposisi_harga'] = ($isi['item_harga'] * ($this->input->post('komposisi_persen') / 100));
 		$data['when_create'] = date('Y-m-d H:i:s');
 		$data['who_create'] = $value['user_nama_lengkap'];

 		$this->M_material_item->insertKomposisi($data);

 		$this->fun_item_harga($this->input->post('temp_item_id'));
 	}
 	/* INSERT DETAIL */

 	/* UPDATE DETAIL */
 	public function updateKomposisi(){
 		$value = $this->session->userdata();
 		$isi = $this->fun_komposisi_harga($this->input->post('komposisi_item'));

 		$id = anti_inject($this->input->post('komposisi_id'));
 		$data = array(
 			'item_id' => $this->input->post('temp_item_id'),
 			'komposisi_persen' => $this->input->post('komposisi_persen'),
 			'komposisi_item' => $this->input->post('komposisi_item'),
 			'komposisi_harga' => ($isi['item_harga'] * ($this->input->post('komposisi_persen') / 100)),
 			'when_create' => date('Y-m-d H:i:s'),
 			'who_create' => $value['user_nama_lengkap'],
 		);

 		$this->M_material_item->updateKomposisi($data, $id);

 		$this->fun_item_harga($this->input->post('temp_item_id'));
 	}
 	/* UPDATE DETAIL */

 	/* DELETE DETAIL */
 	public function deleteKomposisi(){
 		$param['komposisi_id'] = $this->input->get('komposisi_id');

 		$data = $this->M_material_item->getKomposisi($param);

 		$this->M_material_item->deleteKomposisi($this->input->get('komposisi_id'));

 		$this->fun_item_harga($data['item_id']);
 	}
 	/* DELETE DETAIL */

 	/* FUN TAMBAHAN */
 	public function fun_komposisi_harga($id){
 		$param['item_id'] = $id;

 		return $this->M_material_item->getBarangMaterial($param);
 	}

 	public function fun_item_harga($id){
 		$param['item_id'] = $id;

 		$isi = $this->M_material_item->getSumKomposisi($param);

 		$data = array(
 			'item_harga' => $isi['total'],
 		);

 		$this->M_material_item->updateBarangMaterial($data, $id);

 		dblog('U', $id, $data['item_harga']);
 	}

 	public function fun_ganti_harga(){
 		$param['komposisi_item'] = $this->input->get('komposisi_item');

 		foreach ($this->M_material_item->getKomposisi($param) as $value) {
 			$data = array(
 				'komposisi_harga' => ($value['harga_item'] * ($value['komposisi_persen'] / 100)),
 			);

 			$this->M_material_item->updateKomposisi($data, $value['komposisi_id']);

 			$this->fun_item_harga($value['item_id']);
 		}
 	}
 	/* FUN TAMBAHAN */

 	/* INDEX IMPORT */
 	public function index_import(){
 		$isi['judul'] = 'Import Material Item';
 		$data = $this->session->userdata();
 		$data['id_sidebar'] = $this->input->get('id_sidebar');
 		$data['id_sidebar_detail'] = $this->input->get('id_sidebar_detail');

 		$this->template->template_master('master/barang_material_import',$isi,$data);
 	}
 	/* INDEX IMPORT */

 	/* GET IMPORT */
 	public function getImport(){
 		$param['import_kode'] = $this->input->get('import_kode');

 		$data = $this->M_material_item->getImport($param);
 		echo json_encode($data);
 	}
 	/* GET IMPORT */

 	/* INSERT IMPORT */
 	public function insertImport(){

 		error_reporting(0);
 		$data_session = $this->session->userdata();
 		$upload_path = FCPATH . './upload/';
 		/*ekstensi file yang diperbolehkan*/
 		$allowed_mime_type_arr = array('application/vnd.ms-excel');
 		$mime = get_mime_by_extension($_FILES['file']['name']);
 		if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != "") {
 			if (in_array($mime, $allowed_mime_type_arr)) {
 				/*upload excelnya*/
 				$excelTmp = $_FILES['file']['tmp_name'];
 				$excelName = $_FILES['file']['name'];
 				$excelType = $_FILES['file']['type'];

 				$acak = rand(11111111, 99999999);
 				$excelExt = substr($excelName, strrpos($excelName, '.'));
					$excelExt = str_replace('.', '', $excelExt); // Extension
					$excelName = preg_replace("/\.[^.\s]{3,4}$/", "", $excelName);
					$NewExcelName = $excelName . str_replace(' ', '', $acak . '_' . date('ymdhis') . '.' . $excelExt);
					move_uploaded_file($_FILES["file"]["tmp_name"], $upload_path . $NewExcelName);
					/*upload excelnya*/

					/*proses excelnya*/
					$this->load->library('Spreadsheet_Excel_Reader');
					$this->spreadsheet_excel_reader->setOutputEncoding('CP1251');
					$this->db->db_set_charset('latin1', 'latin1_swedish_ci');
					$this->spreadsheet_excel_reader->read($upload_path . $NewExcelName);
					$sheets = $this->spreadsheet_excel_reader->sheets[0];
					/*proses excelnya*/

					$data_excel = array();
					$id = create_id();
					for ($i = 2; $i <= $sheets['numRows']; $i++) {
						if ($sheets['cells'][$i][1] == '') break;

						$param_jenis['jenis_nama'] = $sheets['cells'][$i][5];
						$isiJenis = $this->M_material_jenis->getJenisBarang($param_jenis);

						$param_gl_account['gl_account_nama'] = $sheets['cells'][$i][6];
						$isiGlAccount = $this->M_material_gl_account->getGlAccount($param_gl_account);

						$data_excel[$i - 1]['import_kode']    = $id;
						$data_excel[$i - 1]['item_id']    = create_id();
						$data_excel[$i - 1]['item_kode']  = str_replace('°', ' DEC ', $sheets['cells'][$i][1]);
						$data_excel[$i - 1]['item_nama']  = str_replace('°', ' DEC ', $sheets['cells'][$i][2]);
						$data_excel[$i - 1]['item_katalog_number']  = $sheets['cells'][$i][3];
						$data_excel[$i - 1]['item_merk']  = $sheets['cells'][$i][4];
						$data_excel[$i - 1]['jenis_id']  = $isiJenis[0]['jenis_id'];
						$data_excel[$i - 1]['gl_account_id']  = $isiGlAccount[0]['gl_account_id'];
						$data_excel[$i - 1]['item_harga']  = $sheets['cells'][$i][7];
						$data_excel[$i - 1]['item_satuan']  = $sheets['cells'][$i][8];
						$data_excel[$i - 1]['item_stok']  = $sheets['cells'][$i][9];
						$data_excel[$i - 1]['item_stok_alert']  = $sheets['cells'][$i][10];
						$data_excel[$i - 1]['when_create']  = date('Y-m-d H:i:s');
						$data_excel[$i - 1]['who_create']  = $data_session['user_nama_lengkap'];
					}

					$this->db->insert_batch('import.import_material_item', $data_excel);

					header("Location: " . base_url('master/barang_material/index_import?header_menu=0&menu_id=0&import_kode=' . $id));
				}
			}
		}

	public function insertTable(){
		$param['import_kode'] = $this->input->get('import_kode');
		$this->M_material_item->insertTable($param);
		$this->M_material_item->deleteTable($this->input->get('import_kode'));

		header("Location: " . base_url('master/barang_material/index?header_menu=0&menu_id=0'));
	}
	/* INSERT IMPORT */
}
