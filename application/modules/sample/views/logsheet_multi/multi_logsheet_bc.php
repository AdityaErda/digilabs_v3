<script src="https://unpkg.com/mathjs/lib/browser/math.js"></script>
<link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet">
<!-- <script src="YourJquery source path"></script> -->
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>

<style type="text/css">
  .modal-content {
    overflow: scroll !important;
  }

  .dataTables_scrollHead {
    /* overflow: auto !important; */
    /*    width: 100%;*/
  }

  .kolom_header {
    /* background-color: grey; */
  }

  .kolom_konten {
    background-color: white;
  }
</style>

<?php $session = $this->session->userdata(); ?>

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
          <form id="form_logsheet" method="POST" enctype="multipart/form-data" action=" base_url('sample/multi_sample/insertDraftLogSheet') ">
            <!-- FILTER -->
            <!-- Memorandum -->
            <div class="card">
              <!-- Header -->
              <div class="card-header bg-primary">
                <h3 class="card-title">
                  <center> Lembar Kerja <?= $inbox['transaksi_nomor'] ?> </center>
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
                <input type="text" id="transaksi_id" name="transaksi_id" style="display: none;" value="<?php echo $inbox['transaksi_id'] ?>">
                <input type="text" id="transaksi_status" name="transaksi_status" style="display:none" value="<?php echo $inbox['transaksi_status'] ?>">
                <input type="text" id="transaksi_non_rutin_id" name="transaksi_non_rutin_id" style="display:none" value="<?php echo $inbox['transaksi_non_rutin_id'] ?>">


                <?php
                $nomor_sample = '';
                $jenis_nama = '';

                foreach ($inbox_detail as $key_inbox => $detail_inbox) :
                  $nomor_sample .= $detail_inbox['transaksi_detail_nomor_sample'] . ', ';
                  $jenis_nama .= $detail_inbox['jenis_nama'] . ', ';
                ?>
                  <input type="text" class="form-control" id="transaksi_detail_status_<?= $key_inbox ?>" name="transaksi_detail_status[]" style="display:none" value="<?php echo $detail_inbox['transaksi_detail_status'] ?>">

                  <!-- <input type="text" id="template_logsheet_id_<?= $key_inbox ?>" name="template_logsheet_id[]" style="display:none" value="<?php echo $_GET['template_logsheet_id'][$key_header] ?>"> -->

                  <input type="text" class="form-control" id="transaksi_detail_id_temp_<?= $key_inbox ?>" name="transaksi_detail_id_temp[]" value="<?php echo $detail_inbox['transaksi_detail_id'] ?>" style="display: none;">

                  <input type="text" class="form-control" id="transaksi_detail_id_<?= $key_inbox ?>" name="transaksi_detail_id[]" value="<?php echo create_id(); ?>" style="display: none;">

                  <input type="text" class="form-control" id="logsheet_nomor_sample_<?= $key_inbox ?>" name="logsheet_nomor_sample[]" placeholder="Judul" value="<?php echo $detail_inbox['transaksi_detail_nomor_sample']; ?>" style="display:none">

                  <input type="text" class="form-control" id="logsheet_jenis_<?= $key_inbox ?>" name="logsheet_jenis[]" placeholder="Judul" value="<?php echo $detail_inbox['jenis_nama'] ?>" style="display:none">

                  <input type="text" class="form-control" id="logsheet_jenis_id_<?= $key_inbox ?>" name="logsheet_jenis_id[]" placeholder="Judul" value="<?php echo $detail_inbox['jenis_id'] ?>" style="display:none">

                <?php endforeach; ?>

                <!-- deklarasi data awal -->

                <div class="col-12">
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group row col-12">
                        <label class="col-md-4">Nomor Sample</label>
                        <div class="input-group col-md-8">
                          <input type="text" class="form-control" id="logsheet_nomor_sample_show" name="logsheet_nomor_sample_show" placeholder="Judul" value="<?php echo $nomor_sample; ?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row col-12">
                        <label class="col-md-4">Jenis Sample</label>
                        <div class="input-group col-md-8">
                          <input type="text" class="form-control" id="logsheet_jenis_show" name="logsheet_jenis_show" placeholder="Judul" value="<?php echo $jenis_nama ?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row col-12">
                        <label class="col-md-4">Peminta Jasa</label>
                        <div class="input-group col-md-8">
                          <input type="text" class="form-control" id="logsheet_peminta_jasa" name="logsheet_peminta_jasa" value="<?php echo $inbox['peminta_jasa_nama'] ?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row col-12">
                        <label class="col-md-4">Nomor Permintaan</label>
                        <div class="input-group col-md-8">
                          <input type="text" class="form-control" id="logsheet_nomor_permintaan" name="logsheet_nomor_permintaan" value="<?php echo $inbox['transaksi_nomor'] ?>" readonly>
                        </div>
                      </div>
                    </div>
                    <div class="col-6">
                      <!-- jika sampling -->
                      <?php
                      if ($detail_inbox['is_sampling'] == 'y') {
                      ?>
                        <div class="form-group row col-12">
                          <label class="col-md-4">Tanggal Sampling</label>
                          <div class="input-group col-md-8">
                            <div class="input-group-prepend">
                              <span class="input-group-text">
                                <i class="far fa-calendar-alt"></i>
                              </span>
                            </div>
                            <input type="text" class="form-control float-right tanggal" id="logsheet_tgl_sampling" name="logsheet_tgl_sampling" value="<?php echo date('d-m-Y', strtotime($detail_inbox['transaksi_detail_tgl_sampling'])) ?>">
                          </div>
                        </div>
                      <?php
                      }
                      ?>
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
              <input type="text" id="logsheet_id" name="logsheet_id[]" value="<?php echo rand(); ?>" style="display:inline-block">
              <!-- Header -->
              <div class="card-header bg-warning">
                <h3 class="card-title"> Detail Sample</h3>
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
                            <input type="text" class="form-control" id="log_jenis_nama" name="log_jenis_nama[0]" placeholder="Jenis Uji" value="<?php echo $jenis_nama ?>">
                          </div>
                        </div>
                        <div class="form-group row col-12">
                          <label class="col-md-4">Bulan</label>
                          <div class="input-group col-md-8">
                            <input type="text" class="form-control" id="log_bulan" name="log_bulan[0]" placeholder="Tanggal" value="<?php echo date('m-Y') ?>">
                            <input type="text" class="form-control" id="log_bulan_dump" name="log_bulan_dump[0]" placeholder="Tanggal" value="<?php echo bulan(date('m')) . ' ' . date('Y') ?>">
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
                    <div class="card-body">
                      <!-- <table  width="100%" border="1"> -->
                      <table width="100%" class="table table-striped table-bordered nowrap table_rumus" cellspacing="0" cellpadding="0" id="table_rumus">
                        <thead>
                          <tr>
                            <th rowspan="4">Lokasi</th>
                            <th rowspan="4">Tgl Sampling</th>
                            <th rowspan="4">No Lab</th>
                            <th rowspan="4">Parameter</th>
                            <th rowspan="4">Rumus Perhitungan</th>
                            <th colspan="2">OT=Faktor</th>
                            <th rowspan="4">Batasan mg/NM3</th>
                            <th rowspan="4">Kesimpulan</th>
                          </tr>
                          <tr>
                            <th colspan="2">32=0.8632</th>
                          </tr>
                          <tr>
                            <th colspan="2">JIS-Z-8808,1977</th>
                          </tr>
                          <tr>
                            <!-- <th><input type="text" placeholder="Lokasi" name="log_lokasi" id="log_lokasi" class="col-md-12"></th> -->
                            <th>mg/NM3</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          foreach ($multi_detail as $key_log => $inbox_log) :
                            $param['jenis_id'] = $inbox_log['jenis_id'];
                            $sql_rumus = $this->db->query("SELECT * FROM sample.sample_perhitungan_sample WHERE jenis_id = '" . $param['jenis_id'] . "' ORDER BY rumus_nama ASC");
                            $data_rumus = $sql_rumus->result_array();

                          ?>
                            <tr>
                              <!-- kolom lokasi -->
                              <td class="kolom_header table-primary">
                                <?php if ($inbox_log['rumus_id'] != '') : ?>
                                  <?php echo ($inbox_log['jenis_nama']) ?> - <?php echo ($inbox_log['rumus_nama']) ?>
                                <?php else : ?>
                                  <?php echo ($inbox_log['jenis_nama']) ?>
                                <?php endif; ?>
                                <!-- <table width="100%" style="border-collapse:collapse;border:1px solid black;text-align:center" rules="all"> -->
                                <!-- <tbody> -->
                                <!-- <?php //foreach ($data_rumus as $key_rumus => $rumus_log) :
                                      ?> -->
                                <!-- <tr> -->
                                <!-- <td style="color:red" class="kolom_konten"><?php print_r($inbox_log['rumus_nama']) ?></td> -->
                                <!-- </tr> -->
                                <!-- <?php //endforeach;
                                      ?> -->
                                <!-- </tbody> -->
                                <!-- </table> -->
                              </td>
                              <!-- kolom lokasi -->
                              <!-- kolom tanggal -->
                              <td class="kolom_header">
                                <?php echo ($inbox_log['is_sampling'] == 'y') ? date('d', strtotime($inbox_log['transaksi_detail_tgl_sampling'])) : "Non" ?>
                                <table width="100%" style="border-collapse:collapse;border:1px solid black;text-align:center" rules="all">
                                  <?php foreach ($data_rumus as $key_rumus => $rumus_log) : ?>
                                    <tr>
                                      <!-- <td style="color:red" class="kolom_konten"> -->
                                      <!-- <?= $inbox_log['transaksi_detail_tgl_sampling'] ?> -->
                                      <!-- </td> -->
                                    </tr>
                                  <?php endforeach; ?>
                                </table>
                              </td>
                              <!-- kolom tanggal -->
                              <!-- kolom no lab -->
                              <td class="kolom_header">
                                <?php echo ($inbox_log['transaksi_detail_nomor_sample']) ?>
                                <table width="100%" style="border-collapse:collapse;border:1px solid black;text-align:center" rules="all">
                                  <?php foreach ($data_rumus as $key_rumus => $rumus_log) : ?>
                                    <!-- <tr> -->
                                    <!-- <td style="color:red" class="kolom_konten"><?php print_r($rumus_log['rumus_nama']) ?></td> -->
                                    <!-- </tr> -->
                                  <?php endforeach; ?>
                                </table>
                              </td>
                              <!-- kolom no lab -->
                              <!-- kolom no parameter -->
                              <td class="kolom_header">
                                <?php echo ($inbox_log['transaksi_detail_parameter']) ?>
                                <table width="100%" style="border-collapse:collapse;border:1px solid black;text-align:center" rules="all">
                                  <?php foreach ($data_rumus as $key_rumus => $rumus_log) : ?>
                                    <!-- <tr> -->
                                    <!-- <td style="color:red" class="kolom_konten"><?php print_r($rumus_log['rumus_nama']) ?></td> -->
                                    <!-- </tr> -->
                                  <?php endforeach; ?>
                                </table>
                              </td>
                              <!-- kolom no parameter -->
                              <!-- kolom rumus -->
                              <td class="kolom_header">
                                <?php echo ($inbox_log['jenis_nama']) ?>
                                <table width="100%" style="border-collapse:collapse;border:1px solid black;text-align:center" rules="all">
                                  <?php foreach ($data_rumus as $key_rumus => $rumus_log) : ?>
                                    <tr>
                                      <?php
                                      $param_detail['id_rumus'] = $rumus_log['rumus_id'];
                                      $data_detail_rumus = $this->M_perhitungan_sample->getDetailRumusSampleTemplate($param_detail);
                                      ?>
                                      <?php foreach ($data_detail_rumus as $key_detail_rumus => $detail_rumus_log) : ?>
                                        <td style="color:red" class="kolom_konten">
                                          <?php if ($detail_rumus_log['rumus_jenis'] == 'I') : ?>
                                            <input type="text" name="rumus_isi" id="rumus_isi_<?= $detail_rumus_log['rumus_detail_id'] ?>" class="rumus_isi">
                                          <?php else : ?>
                                            <input type="text" name="rumus_isi" id="rumus_isi_<?= $detail_rumus_log['rumus_detail_id'] ?>" class="rumus_isi" value="<?= $detail_rumus_log['rumus_detail_input'] ?>" readonly>
                                          <?php endif; ?>
                                        </td>
                                      <?php endforeach; ?>
                                    </tr>
                                  <?php endforeach; ?>
                                </table>
                              </td>
                              <!-- kolom rumus -->
                              <!-- kolom hasil -->
                              <td class="kolom_header">
                                <?php echo ($inbox_log['jenis_nama']) ?>
                                <table width="100%" style="border-collapse:collapse;border:1px solid black;text-align:center" rules="all">
                                  <?php foreach ($data_rumus as $key_rumus => $rumus_log) : ?>
                                    <tbody>
                                      <tr>
                                        <td style="color:red" class="kolom_konten">
                                          <input type="text" placeholder="klik U/ Hasil" readonly onClick="func_hasil(`<?= $rumus_log['rumus_id'] ?>`)" class="hasil" id="hasil_<?= $rumus_log['rumus_id'] ?>">
                                        </td>
                                      </tr>
                                    </tbody>
                                  <?php endforeach; ?>
                                </table>
                              </td>
                              <!-- kolom hasil -->
                              <!-- kolom checklist -->
                              <td class=" kolom_header">
                                <?php echo ($inbox_log['jenis_nama']) ?>
                                <table width="100%" style="border-collapse:collapse;border:1px solid black;text-align:center" rules="all">
                                  <?php foreach ($data_rumus as $key_rumus => $rumus_log) : ?>
                                    <tbody>
                                      <tr>
                                        <td style="color:red" class="kolom_konten">
                                          <input type="text" class="checklist" id="checklist_<?= $rumus_log['rumus_id'] ?>" style="display:none">
                                          <div id="checklist_tmp_<?= $rumus_log['rumus_id'] ?>" class="checklist_tmp">-</div>
                                        </td>
                                      </tr>
                                    </tbody>
                                  <?php endforeach; ?>
                                </table>
                              </td>
                              <!-- kolom checklist -->
                              <!-- kolom batasan -->
                              <td class="kolom_header">
                                <?php echo ($inbox_log['jenis_nama']) ?>
                                <table width="100%" style="border-collapse:collapse;border:1px solid black;text-align:center" rules="all">
                                  <?php foreach ($data_rumus as $key_rumus => $rumus_log) : ?>
                                    <tbody>
                                      <tr>
                                        <td style="color:red" class="kolom_konten"><input type="text" class="batasan" id="batasan_<?= $rumus_log['rumus_id'] ?>" value="<?= $rumus_log['batasan_emisi'] ?>"></td>
                                      </tr>
                                    </tbody>
                                  <?php endforeach; ?>
                                </table>
                              </td>
                              <!-- kolom batasan -->
                              <!-- kolom kesimpulan -->
                              <td class="kolom_header">
                                <?php echo ($inbox_log['jenis_nama']) ?>
                                <table width="100%" style="border-collapse:collapse;border:1px solid black;text-align:center" rules="all">
                                  <?php foreach ($data_rumus as $key_rumus => $rumus_log) : ?>
                                    <tbody>
                                      <tr>
                                        <td style="color:red" class="kolom_konten"><?php print_r($rumus_log['rumus_nama']) ?></td>
                                      </tr>
                                    </tbody>
                                  <?php endforeach; ?>
                                </table>
                              </td>
                              <!-- kolom kesimpulan -->
                            </tr>
                          <?php endforeach; ?>
                        </tbody>
                      </table>
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
                  <h4 class="modal-title"> $judul </h4>
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