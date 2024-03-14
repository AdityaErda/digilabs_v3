fasfa
<script src="https://unpkg.com/mathjs/lib/browser/math.js"></script>
<link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet">
<!-- <script src="YourJquery source path"></script> -->
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>

<style type="text/css">
  .modal-content {
    overflow: scroll !important;
  }
</style>
<?php
$session = $this->session->userdata();

$vp_ppk = $this->db->query("SELECT * FROM global.global_api_user WHERE user_poscode = 'E44000000'")->row_array();



?>
<!--CONTAINER -->
<div class="content-wrapper">
  <!-- Container Header -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><?= $judul ?></h1>
        </div>
      </div>
    </div>
  </section>
  <!-- Container Header -->
  <!-- Container Body -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <form id="form_logsheet" method="POST" enctype="multipart/form-data" action="<?= base_url('sample/multi_sample/insertDraftLogSheet') ?>">
            <!-- FILTER -->
            <!-- Memorandum -->
            <div class="card">
              <!-- Header -->
              <div class="card-header bg-primary">
                <h3 class="card-title">
                  <center> Lembar Kerja <?php echo $inbox['transaksi_nomor'] ?> </center>
                </h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <!-- Header -->
              <!-- Body -->
              <div class="card-body row">
                <!-- Kiri -->
                <!-- deklarasi data awal -->
                <input type="text" id="transaksi_id" name="transaksi_id" style="display: inline-block;" value="<?= $inbox['transaksi_id'] ?>">
                <input type="text" id="transaksi_status" name="transaksi_status" style="display:inline-block" value="<?= $inbox['transaksi_status'] ?>">
                <input type="text" id="transaksi_non_rutin_id" name="transaksi_non_rutin_id" style="display:inline-block" value="<?= $inbox['transaksi_non_rutin_id'] ?>">

                <?php
                $nomor_sample = '';
                $jenis_nama = '';
                foreach ($inbox_detail as $key_header => $detail_header) :
                  $nomor_sample .= $detail_header['transaksi_detail_nomor_sample'] . ', ';
                  $jenis_nama .= $detail_header['jenis_nama'] . ', ';
                  ?>
                  
                  <input type="text" id="transaksi_detail_status" name="transaksi_detail_status[]" style="display:inline-block" value="<?= $detail_header['transaksi_detail_status'] ?>">
                  
                  <input type="text" id="template_logsheet_id" name="template_logsheet_id[]" style="display:inline-block" value="<?= $_GET['template_logsheet_id'][$key_header] ?>">
                  
                  <input type="text" id="transaksi_detail_id_temp" name="transaksi_detail_id_temp[]" value="<?= $detail_header['transaksi_detail_id'] ?>" style="display: inline-block;">
                  
                  <input type="text" id="transaksi_detail_id" name="transaksi_detail_id[]" value="<?= create_id(); ?>" style="display: inline-block;">
                  
                  <input type="text" class="form-control" id="logsheet_nomor_sample" name="logsheet_nomor_sample[]" placeholder="Judul" value="<?= $detail_header['transaksi_detail_nomor_sample']; ?>" style="display:inline-block">
                  
                  <input type="text" class="form-control" id="logsheet_jenis" name="logsheet_jenis[]" placeholder="Judul" value="<?= $detail_header['jenis_nama'] ?>" style="display:inline-block">

                <?php endforeach; ?>

                <!-- deklarasi data awal -->

                <div class="col-12">
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group row col-12">
                        <label class="col-md-4">Nomor Sample</label>
                        <div class="input-group col-md-8">
                          <input type="text" class="form-control" id="logsheet_nomor_sample_show" name="logsheet_nomor_sample_show" placeholder="Judul" value="<?= $nomor_sample; ?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row col-12">
                        <label class="col-md-4">Jenis Sample</label>
                        <div class="input-group col-md-8">
                          <input type="text" class="form-control" id="logsheet_jenis_show" name="logsheet_jenis_show" placeholder="Judul" value="<?= $jenis_nama ?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row col-12">
                        <label class="col-md-4">Peminta Jasa</label>
                        <div class="input-group col-md-8">
                          <input type="text" class="form-control" id="logsheet_peminta_jasa" name="logsheet_peminta_jasa" value="<?= $inbox['peminta_jasa_nama'] ?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row col-12">
                        <label class="col-md-4">Nomor Permintaan</label>
                        <div class="input-group col-md-8">
                          <input type="text" class="form-control" id="logsheet_nomor_permintaan" name="logsheet_nomor_permintaan" value="<?= $inbox['transaksi_nomor'] ?>" readonly>
                        </div>
                      </div>
                    </div>
                    <div class="col-6">
                      <?php if ($detail_header['is_sampling'] == 'y') { ?>
                        <div class="form-group row col-12">
                          <label class="col-md-4">Tanggal Sampling</label>
                          <div class="input-group col-md-8">
                            <div class="input-group-prepend">
                              <span class="input-group-text">
                                <i class="far fa-calendar-alt"></i>
                              </span>
                            </div>
                            <input type="text" class="form-control float-right tanggal" id="logsheet_tgl_sampling" name="logsheet_tgl_sampling" value="<?= date('d-m-Y', strtotime($detail_header['transaksi_detail_tgl_sampling'])) ?>">
                          </div>
                        </div>
                      <?php } ?>

                      <div class="form-group row col-12">
                        <label class="col-md-4">Tanggal Terima</label>
                        <div class="input-group col-md-8">
                          <div class="input-group-prepend">
                            <span class="input-group-text">
                              <i class="far fa-calendar-alt"></i>
                            </span>
                          </div>
                          <input type="text" class="form-control float-right tanggal" id="logsheet_tgl_terima" name="logsheet_tgl_terima">
                        </div>
                      </div>

                      <div class="form-group row col-12">
                        <label class="col-md-4">Tanggal Pengujian</label>
                        <div class="input-group col-md-8">
                          <div class="input-group-prepend">
                            <span class="input-group-text">
                              <i class="far fa-calendar-alt"></i>
                            </span>
                          </div>
                          <input type="text" class="form-control float-right tanggal" id="logsheet_tgl_uji" name="logsheet_tgl_uji">
                        </div>
                      </div>

                      <div class="form-group row col-12">
                        <label class="col-md-4">Asal Sample</label>
                        <div class="input-group col-md-8">
                          <input type="text" class="form-control" id="logsheet_asal_sample" name="logsheet_asal_sample" placeholder="Asal Sample" value="">
                        </div>
                      </div>
                      <div class="form-group row col-12">
                        <label class="col-md-4">Pengambilan Sample Oleh</label>
                        <div class="input-group col-md-8">
                          <input type="text" class="form-control" id="logsheet_pengolah_sample" name="logsheet_pengolah_sample" placeholder="Pengambilan Sample Oleh" value="">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Memorandum -->

            <div class="card">
              <?php foreach ($inbox_detail as $key => $detail) : ?>
                <input type="text" id="logsheet_id" name="logsheet_id[]" value="<?= rand(); ?>" style="display:inline-block">
                <!-- Header -->
                <div class="card-header bg-warning">
                  <h3 class="card-title"> Detail Sample <?= $detail['transaksi_detail_nomor_sample'] ?></h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                  </div>
                </div>
                <!-- Header -->
                <!-- Body -->
                <div class="card-body">
                  <div class="div_log">
                    <!-- this -->
                    <div class="div_log_baru">
                      <div class="row">
                        <div class="col-6">
                          <div class="form-group row col-12">
                            <label class="col-md-4">Jenis Uji</label>
                            <div class="input-group col-md-8">
                              <input type="text" class="form-control" id="log_jenis_nama" name="log_jenis_nama[0]" placeholder="Jenis Uji" value="<?= $detail['jenis_nama'] ?>">
                            </div>
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="form-group row col-12">
                            <label class="col-md-4">Metoda</label>
                            <div class="input-group col-md-8">
                              <input type="text" class="form-control" id="log_metoda" name="log_metoda[0]" placeholder="Metoda">
                            </div>
                          </div>
                          <div class="form-group row col-12">
                            <label class="col-md-4">Deskripsi</label>
                            <div class="input-group col-md-8">
                              <textarea name="log_deskripsi[0]" id="log_deskripsi" cols="30" rows="3" class="form-control" placeholder="Deskripsi Sample"></textarea>
                            </div>
                          </div>
                        </div>
                      </div>
                      <br>
                      <!-- Rumus -->
                      <div class="row" id="div_rumus">
                        <div class="row">
                          <?php foreach ($template_detail as $key_template => $value_template) : ?>
                            <?php
                            $sql_detail_rumus = $this->db->query("SELECT * FROM sample.sample_perhitungan_sample_detail WHERE id_rumus = '" . $value_template['rumus_id'] . "' AND rumus_detail_template IS NOT NULL");
                            ?>
                            <div class="card-header col-12">
                              <h3 class="card-title"><?= $value_template['rumus_nama'] ?></b></h3>
                              <br />
                              <p style="color:red;">* Klik Kolom Hasil Untuk Menghitung</p>
                            </div>
                            <div class="form-group col-12 row">
                              <input type="text" name="rumus_id[0][0]" id="rumus_id_<?= $key ?>_<?= $key_template ?>" value="<?= $value_template['rumus_id'] ?>" style="width:100%;display:inline-block">
                              <input type="text" name="rumus_nama[0][0]" id="rumus_nama_<?= $key ?>_<?= $key_template ?>" value="<?= $value_template['rumus_nama'] ?>" style="display:inline-block">
                              <table id="<?= $value_template['rumus_id'] ?>" class="table table-bordered table-striped datatables" width="100%">

                                <thead id="header_<?= $value_template['rumus_id'] ?>_<?= $key ?>_<?= $key_template ?>">
                                  <tr>
                                    <th>No</th>
                                    <?php foreach ($sql_detail_rumus->result_array() as $key_template_rumus => $value_detail_rumus) : ?>
                                      <th><?= $value_detail_rumus['rumus_detail_nama'] ?></th>
                                    <?php endforeach; ?>
                                    <th>Satuan</th>
                                    <th>Hasil</th>
                                  </tr>
                                </thead>

                                <tbody id="body_<?= $value_template['rumus_id'] ?>_<?= $key ?>_<?= $key_template ?>">
                                  <tr class="tr" id="tr_<?= $value_template['rumus_id'] ?>">
                                    <td>
                                      <input type="text" name="logsheet_detail_urut[0][0]" id="logsheet_detail_urut_<?= $value_template['rumus_id'] ?>" value="1" style="display:inline-block">
                                      <input type="text" value="1" name="logsheet_detail_urut_baris[0][0]" id="logsheet_detail_urut_baris_<?= $value_template['rumus_id'] ?>" style="display:inline-block">
                                      <input type="text" id="logsheet_rumus_id_<?= $value_template['rumus_id'] ?>" value="<?= $value_template['rumus_id'] ?>" name="logsheet_rumus_id[0][0]" style="display:inline-block">
                                      <input type="text" name="logsheet_detail_id[0][0]" style="display:inline-block" id="logsheet_detail_id_<?= $value_template['rumus_id'] ?>" value="<?= (float)microtime(true); ?>">
                                    </td>
                                    <?php foreach ($sql_detail_rumus->result_array() as $key_template_rumus => $value_detail_rumus) : ?>
                                      <?php
                                      if ($value_detail_rumus['rumus_detail_input'] != null) :
                                        ?>
                                        <td>
                                          <input type="text" style="display:inline-block" name="logsheet_rumus_id_detail[0][0]" id="logsheet_rumus_id_detail_<?= $value_template['rumus_id'] ?>_<?= $key ?>_<?= $key_template ?>" value="<?= $value_template['rumus_id'] ?>">
                                          <input type="text" style="display:inline-block" id="logsheet_detail_detail_id_<?= $value_detail_rumus['rumus_detail_id'] ?>_<?= $key ?>_<?= $key_template ?>" name="logsheet_detail_detail_id[]" value="<?= rand() ?>">
                                          <input type="text" id="rumus_detail_id_<?= $value_detail_rumus['rumus_detail_id'] ?>_<?= $key ?>_<?= $key_template ?>" name="rumus_detail_id[]" value="<?= $value_detail_rumus['rumus_detail_id'] ?>" class="form-control" style="display:inline-block">
                                          <input type="text" id="rumus_detail_nama_<?= $value_detail_rumus['rumus_detail_id'] ?>_<?= $key ?>_<?= $key_template ?>" name="rumus_detail_nama[]" value="<?= $value_detail_rumus['rumus_detail_nama'] ?>" class="form-control" style="display:inline-block">
                                          <input type="text" id="rumus_detail_isi<?= $value_detail_rumus['rumus_detail_id'] ?>_<?= $key ?>_<?= $key_template ?>" name="rumus_detail_isi[]" class="form-control" value="<?= $value_detail_rumus['rumus_detail_input'] ?>" readonly>
                                          <input type="text" id="rumus_detail_urut_<?= $value_detail_rumus['rumus_detail_id'] ?>_<?= $key ?>_<?= $key_template ?>" name="rumus_detail_urut[]" value="<?= $value_detail_rumus['rumus_detail_urut'] ?>" style="display:inline-block">
                                          <input type="text" id="rumus_detail_template_<?= $value_detail_rumus['rumus_detail_id'] ?>_<?= $key ?>_<?= $key_template ?>" name="rumus_detail_template[]" value="<?= $value_detail_rumus['rumus_detail_template'] ?>" style="display:inline-block">
                                          <input type="text" id="rumus_detail_jenis_<?= $value_detail_rumus['rumus_detail_id'] ?>_<?= $key ?>_<?= $key_template ?>" name="rumus_detail_jenis[]" value="<?= $value_detail_rumus['rumus_jenis'] ?>" style="display:inline-block">

                                        </td>
                                      <?php else : ?>
                                        <td>
                                          <input type="text" style="display:inline-block" name="logsheet_rumus_id_detail[]" id="logsheet_rumus_id_detail_<?= $value_template['rumus_id'] ?>_<?= $key ?>_<?= $key_template ?>" value="<?= $value_template['rumus_id'] ?>">
                                          <input type="text" name="logsheet_detail_id_detail[]" style="display:inline-block" id="logsheet_detail_id_detail_<?= $value_template['rumus_id'] ?>_<?= $key ?>_<?= $key_template ?>" value="<?= (float)microtime(true) ?>">

                                          <input type="text" style="display:inline-block" id="logsheet_detail_detail_id_<?= $value_detail_rumus['rumus_detail_id'] ?>_<?= $key ?>_<?= $key_template ?>" name="logsheet_detail_detail_id[]" value="<?= rand() ?>">
                                          <input type="text" id="rumus_detail_id<?= $value_detail_rumus['rumus_detail_id'] ?>_<?= $key ?>_<?= $key_template ?>" name="rumus_detail_id[]" value="<?= $value_detail_rumus['rumus_detail_id'] ?>" class="form-control" style="display:inline-block">
                                          <input type="text" id="rumus_detail_nama<?= $value_detail_rumus['rumus_detail_nama'] ?>_<?= $key ?>_<?= $key_template ?>" name="rumus_detail_nama[]" value="<?= $value_detail_rumus['rumus_detail_nama'] ?>" class="form-control" style="display:inline-block">
                                          <input type="number" id="rumus_detail_isi<?= $value_detail_rumus['rumus_detail_id'] ?>_<?= $key ?>_<?= $key_template ?>" name="rumus_detail_isi[]" class="form-control">
                                          <input type="text" id="rumus_detail_urut_<?= $value_detail_rumus['rumus_detail_id'] ?>_<?= $key ?>_<?= $key_template ?>" name="rumus_detail_urut[]" value="<?= $value_detail_rumus['rumus_detail_urut'] ?>" style="display:inline-block">
                                          <input type="text" id="rumus_detail_template_<?= $value_detail_rumus['rumus_detail_id'] ?>_<?= $key ?>_<?= $key_template ?>" name="rumus_detail_template[]" value="<?= $value_detail_rumus['rumus_detail_template'] ?>" style="display:inline-block">
                                          <input type="text" id="rumus_detail_jenis_<?= $value_detail_rumus['rumus_detail_id'] ?>_<?= $key ?>_<?= $key_template ?>" name="rumus_detail_jenis[]" value="<?= $value_detail_rumus['rumus_jenis'] ?>" style="display:inline-block">
                                        </td>
                                      <?php endif; ?>
                                    <?php endforeach; ?>
                                    <td>
                                      <input type="text" id="rumus_satuan_<?= $value_detail_rumus['rumus_detail_id'] ?>_<?= $key ?>_<?= $key_template ?>" name="rumus_satuan[]" value="<?= $value_template['satuan_sample'] ?>" class="form-control rumus_satuan<?= $value_template['rumus_id'] ?>">
                                    </td>
                                    <td>
                                      <input type="text" class="form-control hasil_<?= $value_template['rumus_id'] ?>" id="hasil_<?= $value_template['rumus_id'] ?>_<?= $key ?>_<?= $key_template ?>" name="hasil_<?= $value_template['rumus_id'] ?>[1]" readonly onclick="fun_hitung(`<?= $value_template['rumus_id'] ?>`,`<?= $key ?>`,`<?= $key_template ?>`);fun_store_history(`<?= $value_template['rumus_id'] ?>`)" readonly placeholder="klik u/ hasil">
                                      <input type="text" class="form-control" id="rumus_detail_hasil_<?= $value_template['rumus_id'] ?>_<?= $key ?>_<?= $key_template ?>" name="rumus_detail_hasil[]" style="display:inline-block">
                                    </td>
                                    <td width="20px">
                                      <a href="javascript:void(0);" id="<?= $value_template['rumus_id'] ?>_<?= $key ?>_<?= $key_template ?>" onclick="add_simplo(this.id)"><i class="fa fa-plus" style="color:green"></i></a>
                                      <br>
                                    </td>
                                  </tr>
                                </tbody>

                                <tfoot id="footer_<?= $value_template['rumus_id'] ?>">
                                  <tr id="div_rata_rata_<?= $value_template['rumus_id'] ?>_<?= $key ?>_<?= $key_template ?>" style="display:inline-block;">
                                    <td colspan="">
                                      <p>Rata-rata </p>
                                    </td>
                                    <td><input class="form-control" placeholder="klik untuk rata-rata" type="text" id="rata_<?= $value_template['rumus_id'] ?>_<?= $key ?>_<?= $key_template ?>" name="rata_rata[]" onclick="fun_average(`<?= $value_template['rumus_id'] ?>_<?= $key ?>_<?= $key_template ?>`)" readonly style="display:inline-block"></td>
                                  </tr>
                                  <tr id="div_adbk_<?= $value_template['rumus_id'] ?>_<?= $key ?>_<?= $key_template ?>" style="display: inline-block;">
                                    <td colspan="">
                                      <p>Nilai ADBK </p>
                                    </td>
                                    <td><input class="form-control" placeholder="klik untuk nilai adbk" type="text" id="nilai_adbk_<?= $value_template['rumus_id'] ?>_<?= $key ?>_<?= $key_template ?>" name="nilai_adbk[]" onclick="fun_nilai_adbk(`<?= $value_template['rumus_id'] ?>_<?= $key ?>_<?= $key_template ?>`)" readonly style="display:inline-block"></td>
                                  </tr>
                                </tfoot>

                              </table>
                            </div>
                            <!-- fun_detail_rumus(val.rumus_id); -->
                            <!-- fun_list_rumus(val.rumus_id); -->

                          <?php endforeach; ?>
                        </div>
                      </div>
                      <!-- Rumus -->
                      <hr>
                    </div>
                    <!-- this -->
                  </div>
                  <div class="input-group col-md-3">
                    <!-- <button type="button" id="add_log" name="add_log" class="btn btn-primary">Tambah Parameter Uji</button> -->
                  </div>
                </div>
              <?php endforeach; ?>
              <!-- </form> -->
              <div class="card-footer">
                <button type="button" id="close" class="btn   btn-custom btn-default border-dark" onClick="kembali_inbox_multi()">Kembali</button>
                <button type="submit" onClick="fun_simpan()" id="simpan1" class="btn  btn-custom btn-success float-right">Olah Data</button>
              </div>
            </div>
          </form>
          <!-- modal -->
          <div class="modal fade" id="modal_lihat">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title"><?= $judul ?></h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form id="form_modal_lihat">
                  <input type="hidden" id="jadwal_id" name="jadwal_id" value="">
                  <div class="modal-body">
                    <div class="card-body row" id="div_document" style="height: 400px;">
                    </div>
                  </div>
                  <div class="modal-footer justify-content-between">
                    <button type="button" id="close" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <!-- modal -->
          <div class="modal fade" id="modal_batal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Batal</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form id="form_batal">
                    <div class="row">
                      <div class="col-12">
                        <div class="form-group row col-md-12">
                          <label class="col-md-4">Alasan Pembatalan</label>
                          <div class="input-group col-md-8">
                            <input type="text" name="transaksi_batal_alasan" id="transaksi_batal_alasan" class="form-control" required>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close_batal">Close</button>
                  <button type="button" class="btn btn-primary" id="simpan_batal">Batal</button>
                  <button class="btn btn-primary" type="button" id="loading_batal" disabled style="display: inline-block;">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Loading...
                  </button>
                </div>
              </div>
            </div>
          </div>

          <div class="modal fade" id="modal_tunda" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Tunda</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form id="form_tunda">
                    <div class="row">
                      <div class="col-12">
                        <div class="form-group row col-md-12">
                          <label class="col-md-4">Alasan Penundaan</label>
                          <div class="input-group col-md-8">
                            <input type="text" name="transaksi_tunda_alasan" id="transaksi_tunda_alasan" class="form-control" required>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close_tunda">Close</button>
                  <button type="button" class="btn btn-primary" id="simpan_tunda">Tunda</button>
                  <button class="btn btn-primary" type="button" id="loading_tunda" disabled style="display: inline-block;">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Loading...
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Container Body -->
</div>
<!-- CONTAINER-->