<script src="https://unpkg.com/mathjs/lib/browser/math.js"></script>
<link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet">
<!-- <script src="YourJquery source path"></script> -->
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
<!-- <style type="text/css">
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
</style> -->

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
          <form action="<?= base_url('sample/multi_sample/insertDraftLogsheet') ?>" method="POST">
            <!-- <form id="form_logsheet" action="<?= base_url('sample/multi_sample/insertDraftLogsheet') ?>" method="POST"> -->
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
                <input type="text" id="transaksi_id" name="transaksi_id" style="display: none;" value="<?php echo $multisample_group['transaksi_id'] ?>">
                <input type="text" id="transaksi_status" name="transaksi_status" style="display:none" value="<?php echo $multisample_group['transaksi_detail_status'] ?>">
                <input type="text" id="transaksi_non_rutin_id" name="transaksi_non_rutin_id" style="display:none" value="<?php echo $multisample_group['id_transaksi_non_rutin'] ?>">
                <!-- <input type="text" class="form-control" id="transaksi_detail_id_temp_<?= $key_inbox ?>" name="transaksi_detail_id_temp[<?= $key_inbox ?>]" value="<?php echo $detail_inbox['transaksi_detail_id'] ?>" style="display: none;">
                <input type="text" class="form-control" id="transaksi_detail_id_<?= $key_inbox ?>" name="transaksi_detail_id[<?= $key_inbox ?>]" value="<?php echo create_id(); ?>" style="display: none;">
                <input type="text" class="form-control" id="logsheet_nomor_sample_<?= $key_inbox ?>" name="logsheet_nomor_sample[<?= $key_inbox ?>]" placeholder="Judul" value="<?php echo $detail_inbox['transaksi_detail_nomor_sample']; ?>" style="display:none">
                <input type="text" class="form-control" id="logsheet_jenis_<?= $key_inbox ?>" name="logsheet_jenis[<?= $key_inbox ?>]" placeholder="Judul" value="<?php echo $detail_inbox['jenis_nama'] ?>" style="display:none">
                <input type="text" class="form-control" id="logsheet_jenis_id_<?= $key_inbox ?>" name="logsheet_jenis_id[<?= $key_inbox ?>]" placeholder="Judul" value="<?php echo $detail_inbox['jenis_id'] ?>" style="display:none">
                <input type="text" name="logsheet_tgl_sampling[<?= $key_inbox ?>]" id="logsheet_tgl_sampling_<?= $key_inbox ?>" value="<?= $detail_inbox['transaksi_detail_tgl_sampling'] ?>" style="display:none">
                <input type="text" id="logsheet_id" name="logsheet_id[<?= $key_inbox ?>]" value="<?php echo create_id(); ?>" style="display:none"> -->
                <!-- deklarasi data awal -->

                <div class="col-12">
                  <div class="row">
                    <div class="col-6">
                      <!-- <div class="form-group row col-12">
                        <label class="col-md-4">Nomor Sample</label>
                        <div class="input-group col-md-8">
                          <input type="text" class="form-control" id="logsheet_nomor_sample_show" name="logsheet_nomor_sample_show" placeholder="Judul" value="<?php echo $nomor_sample; ?>" readonly>
                        </div>
                      </div> -->
                      <div class="form-group row col-12">
                        <label class="col-md-4">Jenis Sample</label>
                        <div class="input-group col-md-8">
                          <input type="text" class="form-control" id="logsheet_jenis_show" name="logsheet_jenis_show" placeholder="Judul" value="<?= $multisample_group['jenis_nama'] ?>" readonly>
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
            <?php foreach ($multi_detail as $key_md => $val_md) : ?>
              <div class="card">
                <!-- Header -->
                <div class="card-header bg-warning">
                  <h3 class="card-title"> Detail Sample </h3>
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
                            <label class="col-md-4">Nomor Sample</label>
                            <div class="input-group col-md-8">
                              <input type="text" class="form-control" id="transaksi_detail_nomor" name="transaksi_detail_nomor" placeholder="Nomor Sample" value="<?= $val_md['transaksi_detail_nomor_sample'] ?>" readonly>
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
                        <div class="input-group col-md-3">
                          <!-- <button type="button" id="remove_log" name="remove_log" class="btn btn-danger">Batalkan Parameter Uji</button> -->
                        </div>
                        <div class="input-group col-1" style="min-width:max-content">
                          <!-- <button type="button" id="add_log_detail" name="add_log_detail" class="btn btn-info">Simplo / Duplo</button> -->
                        </div>
                        <div class="input-group col-1" style="min-width:max-content">
                          <!-- <button type="button" id="add_log_detail_column" name="add_log_detail_column" class="btn btn-info">Tambah Kolom</button> -->
                        </div>
                      </div>
                      <br>
                      <!-- Rumus -->
                      <div class="row">
                        <?php foreach ($template_detail as $key_td => $val_td) : ?>
                          <?php $list_rumus = $this->M_perhitungan_sample->getListRumus(array('id_rumus' => $val_td['rumus_id']));
                          ?>
                          <div class="card-header col-12">
                            <h3 class="card-title">
                              <?= $val_td['rumus_nama'] ?> =
                              <strong>
                                <?php foreach ($list_rumus as $lr) {
                                  echo ($lr['rumus_detail_nama'] != null) ? $lr['rumus_detail_nama'] : $lr['rumus_detail_input'];
                                } ?>
                              </strong>
                            </h3>
                            <br />
                            <p style="color:red;">* Klik Kolom Hasil Untuk Menghitung</p>
                            <button type="button" id="adbk_<?= $val_td['rumus_id'] ?>" name="adbk[]" class="btn btn-info btn-custom float-right" style="display:none" onclick="fun_adbk(`<?= $val_td['rumus_id'] ?>`)">ADBK</button>
                          </div>
                          <div class="card-body">

                            <div class="form-group col-12 row">
                              <input type="text" name="rumus_id[]" id="rumus_id_<?= $val_td['template_logsheet_detail_id'] ?>_<?= $val_md['transaksi_detail_id'] ?>" value="<?= $val_td['rumus_id'] ?>" style="display:none">
                              <input type="text" name="rumus_nama[]" id="rumus_nama_<?= $val_td['template_logsheet_detail_id'] ?>_<?= $val_md['transaksi_detail_id'] ?>" value="<?= $val_td['rumus_nama'] ?>" style="display:none">
                              <table id="<?= $val_td['rumus_id'] ?>_<?= $val_md['transaksi_detail_id'] ?>" class="table table-bordered table-striped datatables" width="100%">
                                <?php $detail_rumus = $this->M_perhitungan_sample->getDetailRumusSampleTemplate(array('id_rumus' => $val_td['rumus_id'])); ?>
                                <thead id="header_<?= $val_td['rumus_id'] ?>_<?= $val_md['transaksi_detail_id'] ?>">
                                  <tr>
                                    <th>No</th>
                                    <?php foreach ($detail_rumus as $key_dr => $val_dr) : ?>
                                      <th><?= $val_dr['rumus_detail_nama']; ?></th>
                                    <?php endforeach; ?>
                                    <th>Hasil</th>
                                  </tr>
                                </thead>
                                <tbody id="body_<?= $val_td['rumus_id'] ?>_<?= $val_md['transaksi_detail_id'] ?>">
                                  <tr>
                                    <td>1</td>
                                    <?php foreach ($detail_rumus as $key_dr => $val_dr) : ?>
                                      <?php
                                      if ($val_dr['rumus_detail_input'] != null) {
                                      ?>
                                        <td>
                                          <input type="text" id="rumus_detail_isi_<?= $val_dr['rumus_detail_id'] ?>_<?= $key_md ?>" name="rumus_detail_isi[]" class="form-control" value="<?= $val_dr['rumus_detail_input'] ?>" readonly>
                                          <input type="text" style="display:none" name="logsheet_rumus_id_detail[]" id="logsheet_rumus_id_detail_<?= $val_dr['id_rumus'] ?>_<?= $val_md['transaksi_detail_id'] ?>" value="<?= $val_dr['id_rumus'] ?>">
                                          <input type="text" name="logsheet_detail_id_detail[]" style="display:none" id="logsheet_detail_id_detail_<?= $val_dr['id_rumus'] ?>_<?= $val_md['transaksi_detail_id'] ?>" value="<?= date('YmdHis') ?>">
                                          <input type="text" style="display:none" id="logsheet_detail_detail_id_<?= $val_dr['rumus_detail_id'] ?>_<?= $val_md['transaksi_detail_id'] ?>" name="logsheet_detail_detail_id[]" value="<?= date('YmdHis') * 3600 ?>_<?= $val_dr['rumus_detail_urut'] ?>">
                                          <input type="text" id="rumus_detail_id_<?= $val_dr['rumus_detail_id'] ?>_<?= $val_md['transaksi_detail_id'] ?>" name="rumus_detail_id[]" value="<?= $val_dr['rumus_detail_id']; ?>" class="form-control" style="display:none">
                                          <input type="text" id="rumus_detail_nama_<?= $val_dr['rumus_detail_id'] ?>_<?= $val_md['transaksi_detail_id'] ?>" name="rumus_detail_nama[]" value="<?= $val_dr['rumus_detail_nama'] ?>" class="form-control" style="display:none">
                                          <input type="text" id="rumus_detail_urut_<?= $val_dr['rumus_detail_id'] ?>_<?= $val_md['transaksi_detail_id'] ?>" name="rumus_detail_urut[]" value="<?= $val_dr['rumus_detail_urut'] ?>" style="display:none">
                                          <input type="text" id="rumus_detail_template_<?= $val_dr['rumus_detail_id'] ?>_<?= $val_md['transaksi_detail_id'] ?>" name="rumus_detail_template[]" value="<?= $val_dr['rumus_detail_template'] ?>" style="display:none">
                                          <input type="text" id="rumus_detail_jenis_<?= $val_dr['rumus_detail_id'] ?>_<?= $val_md['transaksi_detail_id'] ?>" name="rumus_detail_jenis[]" value="<?= $val_dr['rumus_jenis']; ?>" style="display:none">
                                        </td>
                                      <?php } else { ?>
                                        <td>
                                          <input type="number" id="rumus_detail_isi_<?= $val_dr['rumus_detail_id'] ?>_<?= $key_md ?>" name="rumus_detail_isi[]" class="form-control">
                                          <input type="text" style="display:none" name="logsheet_rumus_id_detail[]" id="logsheet_rumus_id_detail_<?= $val_dr['id_rumus'] ?>_<?= $val_md['transaksi_detail_id'] ?>" value="<?= $val_dr['id_rumus'] ?> ">
                                          <input type="text" name="logsheet_detail_id_detail[]" style="display:none" id="logsheet_detail_id_detail_<?= $val_dr['id_rumus'] ?>_<?= $val_md['transaksi_detail_id'] ?>" value="<?= date('YmdHis') ?>">
                                          <input type="text" style="display:none" id="logsheet_detail_detail_id_<?= $val_dr['rumus_detail_id'] ?>_<?= $val_md['transaksi_detail_id'] ?>" name="logsheet_detail_detail_id[]" value="<?= date('YmdHis') * 3600 ?>_<?= $val_dr['rumus_detail_urut'] ?>">
                                          <input type="text" id="rumus_detail_id_<?= $val_dr['rumus_detail_id'] ?>_<?= $val_md['transaksi_detail_id'] ?>" name="rumus_detail_id[]" value="<?= $val_dr['rumus_detail_id'] ?>" class="form-control" style="display:none">
                                          <input type="text" id="rumus_detail_nama_<?= $val_dr['rumus_detail_nama'] ?>_<?= $val_md['transaksi_detail_id'] ?>" name="rumus_detail_nama[]" value="<?= $val_dr['rumus_detail_nama'] ?>" class="form-control" style="display:none">
                                          <input type="text" id="rumus_detail_urut_<?= $val_dr['rumus_detail_id'] ?>_<?= $val_md['transaksi_detail_id'] ?>" name="rumus_detail_urut[]" value="<?= $val_dr['rumus_detail_urut'] ?>" style="display:none">
                                          <input type="text" id="rumus_detail_template_<?= $val_dr['rumus_detail_id'] ?>_<?= $val_md['transaksi_detail_id'] ?>" name="rumus_detail_template[]" value="<?= $val_dr['rumus_detail_template'] ?>" style="display:none">
                                          <input type="text" id="rumus_detail_jenis_<?= $val_dr['rumus_detail_id'] ?>_<?= $val_md['transaksi_detail_id'] ?>" name="rumus_detail_jenis[]" value="<?= $val_dr['rumus_jenis'] ?>" style="display:none">
                                        </td>
                                      <?php } ?>

                                    <?php endforeach; ?>
                                    <td>
                                      <input type="text" class="form-control hasil_<?= $val_td['rumus_id'] ?>" id="hasil_<?= $val_td['rumus_id'] ?>_<?= $key_md ?>" name="hasil_<?= $val_td['rumus_id'] ?>[1]" onclick="fun_hitung(`<?= $val_td['rumus_id'] ?>`,<?= $key_md ?>);" readonly placeholder="klik u/ hasil">
                                      <input type="text" class="form-control" id="rumus_detail_hasil_<?= $val_td['rumus_id'] ?>" name="rumus_detail_hasil[]" style="display:none">
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                          </div>
                        <?php endforeach ?>
                      </div>
                      <!-- Rumus -->
                      <hr>
                    </div>
                    <!-- this -->
                  </div>
                </div>
                <!-- </form> -->

              <?php endforeach; ?>
              <div class="card-footer">
                <button type="button" id="close" class="btn   btn-custom btn-default border-dark" onclick="kembali_inbox()">Kembali</button>
                <button type="submit" id="" class="btn  btn-custom btn-success float-right">Olah Data</button>
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