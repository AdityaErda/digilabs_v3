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
          <form id="form_logsheet">
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
                  <input type="text" class="form-control" id="transaksi_detail_status_<?= $key_inbox ?>" name="transaksi_detail_status[<?=$key_inbox?>]" style="display:none" value="<?php echo $detail_inbox['transaksi_detail_status'] ?>">
                  <input type="text" class="form-control" id="transaksi_detail_id_temp_<?= $key_inbox ?>" name="transaksi_detail_id_temp[<?=$key_inbox?>]" value="<?php echo $detail_inbox['transaksi_detail_id'] ?>" style="display: none;">
                  <input type="text" class="form-control" id="transaksi_detail_id_<?= $key_inbox ?>" name="transaksi_detail_id[<?=$key_inbox?>]" value="<?php echo create_id(); ?>" style="display: none;">
                  <input type="text" class="form-control" id="logsheet_nomor_sample_<?= $key_inbox ?>" name="logsheet_nomor_sample[<?=$key_inbox?>]" placeholder="Judul" value="<?php echo $detail_inbox['transaksi_detail_nomor_sample']; ?>" style="display:none">
                  <input type="text" class="form-control" id="logsheet_jenis_<?= $key_inbox ?>" name="logsheet_jenis[<?=$key_inbox?>]" placeholder="Judul" value="<?php echo $detail_inbox['jenis_nama'] ?>" style="display:none">
                  <input type="text" class="form-control" id="logsheet_jenis_id_<?= $key_inbox ?>" name="logsheet_jenis_id[<?=$key_inbox?>]" placeholder="Judul" value="<?php echo $detail_inbox['jenis_id'] ?>" style="display:none">
                  <input type="text" name="logsheet_tgl_sampling[<?=$key_inbox?>]" id="logsheet_tgl_sampling_<?= $key_inbox ?>" value="<?= $detail_inbox['transaksi_detail_tgl_sampling'] ?>" style="display:none">
                  <input type="text" id="logsheet_id" name="logsheet_id[<?=$key_inbox?>]" value="<?php echo create_id(); ?>" style="display:none">
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
                          <select name="logsheet_pengolah_sample" id="logsheet_pengolah_sample" class="form-control select2"></select>
                          <!-- <input type="text" class="form-control" id="logsheet_pengolah_sample" name="logsheet_pengolah_sample" placeholder="Pengambilan Sample Oleh" value=""> -->
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Memorandum -->
            <div class="card">
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
                            <input type="text" class="form-control" id="log_jenis_nama" name="log_jenis_nama" placeholder="Jenis Uji" value="<?php echo $jenis_nama ?>">
                          </div>
                        </div>
                        <div class="form-group row col-12">
                          <label class="col-md-4">Metoda</label>
                          <div class="input-group col-md-8">
                            <input type="text" class="form-control" id="log_metoda" name="log_metoda" placeholder="Metoda">
                          </div>
                        </div>

                      </div>
                      <div class="col-6">
                        <div class="form-group row col-12">
                          <label class="col-md-4">Deskripsi</label>
                          <div class="input-group col-md-8">
                            <textarea name="log_deskripsi" id="log_deskripsi" cols="30" rows="3" class="form-control" placeholder="Deskripsi Sample"></textarea>
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
                              <th rowspan="4">Jenis Sample Uji</th>
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
                            foreach ($multi_detail as $key_log => $multi_log) :
                              $param['jenis_id'] = $multi_log['jenis_id'];
                              $sql_rumus = $this->db->query("SELECT * FROM sample.sample_perhitungan_sample WHERE jenis_id = '" . $param['jenis_id'] . "' ORDER BY rumus_nama ASC");
                              $data_rumus = $sql_rumus->result_array();
                              ?>
                              <input style="display:none" type="text" name="logsheet_id_temp[<?= $multi_log['transaksi_detail_id'] ?>][]" value="<?= $multi_log['rumus_id'] ?>">
                              <tr>
                                <!-- kolom lokasi -->
                                <td class="kolom_header">
                                  <?php if ($multi_log['rumus_id'] != '') : ?>
                                    <?php echo ($multi_log['jenis_nama']) ?> -
                                    <br /><span class="badge badge-primary"><?php echo ($multi_log['rumus_nama']) ?></span>
                                  <?php else : ?>
                                    <?php echo ($multi_log['jenis_nama']) ?>
                                  <?php endif; ?>
                                </td>
                                <!-- kolom lokasi -->
                                <!-- kolom tanggal -->
                                <td class="kolom_header">
                                  <?php echo ($multi_log['is_sampling'] == 'y') ? date('d-m-Y', strtotime($multi_log['transaksi_detail_tgl_sampling'])) : "Non" ?>
                                </td>
                                <!-- kolom tanggal -->
                                <!-- kolom no lab -->
                                <td class="kolom_header">
                                  <?php echo ($multi_log['transaksi_detail_nomor_sample']) ?>
                                </td>
                                <!-- kolom no lab -->
                                <!-- kolom no parameter -->
                                <td class="kolom_header">
                                  <?php echo ($multi_log['transaksi_detail_parameter']) ?>
                                </td>
                                <!-- kolom no parameter -->
                                <!-- kolom rumus -->
                                <td class="kolom_header">
                                  <input type="text" name="rumus_id[<?= $multi_log['transaksi_detail_id'] ?>][]" id="rumus_id_<?= $key_log ?>" value="<?= $multi_log['rumus_id'] ?>" style="display: none;">
                                  <?php
                                  if ($multi_log['rumus_id'] != '') :
                                    $param_detail['id_rumus'] = $multi_log['rumus_id'];
                                    $data_detail_rumus = $this->M_perhitungan_sample->getDetailRumusSampleTemplate($param_detail);
                                    $ada_sample = '';
                                    ?>
                                    <?php foreach ($data_detail_rumus as $key_detail_rumus => $detail_rumus_log) : ?>
                                      <?php $ada_sample = $detail_rumus_log['rumus_detail_id']; ?>
                                      <?php if ($detail_rumus_log['rumus_jenis'] == 'I') : ?>
                                        <input type="text" name="rumus_isi[<?= $multi_log['transaksi_detail_id'] ?>][<?= $multi_log['rumus_id'] ?>][]" id="rumus_isi_<?= $detail_rumus_log['rumus_detail_id'] ?>" class="rumus_isi form-control-custom" onkeypress="return numberOnly(event)">
                                      <?php else : ?>
                                        <input type="text" name="rumus_isi[<?= $multi_log['transaksi_detail_id'] ?>][<?= $multi_log['rumus_id'] ?>][]" id="rumus_isi_<?= $detail_rumus_log['rumus_detail_id'] ?>" class="rumus_isi form-control-custom" value="<?= $detail_rumus_log['rumus_detail_input'] ?>" readonly style="background-color:#e9ecef">
                                      <?php endif; ?>
                                    <?php endforeach; ?>
                                  <?php endif; ?>
                                </td>
                                <!-- kolom rumus -->
                                <!-- kolom hasil -->
                                <td class="kolom_header">
                                  <input type="text" name="rumus_hasil[<?= $multi_log['transaksi_detail_id'] ?>][]" placeholder="klik U/ Hasil" readonly class="hasil form-control-custom" id="hasil_<?= $multi_log['rumus_id'] ?>" style="background-color:#e9ecef;display: none;" >
                                  <?php if (isset($ada_sample)) : ?>
                                    <input type="text" name="rumus_hasil_dump[<?= $multi_log['transaksi_detail_id'] ?>][]" placeholder="klik U/ Hasil" readonly onClick="func_hasil(`<?= $multi_log['rumus_id'] ?>`)" class="hasil form-control-custom" id="hasil_dump_<?= $multi_log['rumus_id'] ?>" style="background-color:#e9ecef">
                                  <?php endif; ?>
                                </td>
                                <!-- kolom hasil -->
                                <!-- kolom checklist -->
                                <td class=" kolom_header">
                                  <input type="text" class="checklist" id="checklist_<?= $multi_log['rumus_id'] ?>" style="display:none" name="checklist[<?= $multi_log['transaksi_detail_id'] ?>][]">
                                  <div id="checklist_dump_<?= $multi_log['rumus_id'] ?>" class="checklist_dump">-</div>
                                </td>
                                <!-- kolom checklist -->
                                <!-- kolom batasan -->
                                <td class="kolom_header">
                                  <input type="text" class="batasan" id="batasan_<?= $multi_log['rumus_id'] ?>" value="<?= $multi_log['batasan_emisi'] ?>" style="" name="batasan[<?= $multi_log['transaksi_detail_id'] ?>][]" onkeypress="return numberOnly(event)">
                                  <!-- <?= $multi_log['batasan_emisi'] ?> -->
                                </td>
                                <!-- kolom batasan -->
                                <!-- kolom kesimpulan -->
                                <td class="kolom_header">
                                  <input type="text" class="kesimpulan" name="kesimpulan[<?= $multi_log['transaksi_detail_id'] ?>][]" id="kesimpulan_<?= $multi_log['rumus_id'] ?>" style="display:none">
                                  <div id="kesimpulan_dump_<?= $multi_log['rumus_id'] ?>" class="kesimpulan_dump">-</div>
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
                  <button type="button" id="simpan" class="btn  btn-custom btn-success float-right">Olah Data</button>
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