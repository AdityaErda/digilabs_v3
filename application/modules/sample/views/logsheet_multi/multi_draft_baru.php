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
          <form action="<?= base_url('sample/multi_sample/urll') ?>" method="POST">
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
                <input type="text" style="display: none;" name="header_menu" value="<?= $this->input->get('header_menu') ?>">
                <input type="text" style="display: none;" name="menu_id" value="<?= $this->input->get('menu_id') ?>">
                <input type="text" style="display: none;" name="template_logsheet_id" value="<?= $this->input->get('template_logsheet_id') ?>">
                <div class="col-12">
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group row col-12">
                        <label class="col-md-4">Jenis Sample</label>
                        <div class="input-group col-md-8">
                          <input type="text" class="form-control" id="logsheet_jenis_id" name="logsheet_jenis_id" placeholder="Judul" value="<?= $multisample_group['jenis_id'] ?>" readonly style="display: none;">
                          <input type="text" class="form-control" id="logsheet_jenis_sample" name="logsheet_jenis_sample" placeholder="Judul" value="<?= $multisample_group['jenis_nama'] ?>" readonly>
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
                          <input type="text" class="form-control float-right tanggal_none" id="logsheet_tgl_terima" name="logsheet_tgl_terima" readonly value="<?= $logsheet_group['logsheet_tgl_terima'] ?>">
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
                          <input type="text" class="form-control float-right tanggal_none" id="logsheet_tgl_uji" name="logsheet_tgl_uji" value="<?= $logsheet_group['logsheet_tgl_uji'] ?>" readonly>
                        </div>
                      </div>

                      <div class="form-group row col-12">
                        <label class="col-md-4">Asal Sample</label>
                        <div class="input-group col-md-8">
                          <input type="text" class="form-control" id="logsheet_asal_sample" name="logsheet_asal_sample" placeholder="Asal Sample" value="<?= $logsheet_group['logsheet_asal_sample'] ?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row col-12">
                        <label class="col-md-4">Pengambilan Sample Oleh</label>
                        <div class="input-group col-md-8">
                          <!-- <select name="logsheet_pengolah_sample" id="logsheet_pengolah_sample" class="form-control select2"></select> -->
                          <input type="text" class="form-control" id="logsheet_pengolah_sample" name="logsheet_pengolah_sample" placeholder="Pengambilan Sample Oleh" value="<?= $logsheet_group['logsheet_pengolah_sample'] ?>" readonly>
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
                <h3 class="card-title"> Draft Sample </h3>
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
                    <br>
                    <!-- Rumus -->
                    <!-- table -->
                    <div class="row">
                      <?php foreach ($template_detail as $key_td => $val_td) :                      ?>
                        <?php
                        $list_rumus = $this->M_perhitungan_sample->getListRumus(array('id_rumus' => $val_td['rumus_id']));
                        $detail_rumus = $this->M_perhitungan_sample->getDetailRumusSampleTemplate(array('id_rumus' => $val_td['rumus_id']));
                        foreach ($multi_detail as $key_detail => $val_detail) :
                          $logsheets = $this->M_multi_sample->getLogsheet(array('transaksi_id' => $this->input->get_post('transaksi_id'), 'logsheet_multiple_id' => $this->input->get('multiple_logsheet_id'), 'id_transaksi_detail' => $val_detail['transaksi_detail_id']));
                        endforeach;
                        ?>
                        <div class="card-header col-12">
                          <center>
                            <h3 class="card-title">
                              <?= $val_td['rumus_nama'] ?>
                            </h3>
                          </center>
                          <br />
                        </div>
                        <div class="card-body">
                          <table id="table" class="table table-bordered  datatables" width="100%">
                            <thead>
                              <tr>
                                <th>No Sample</th>
                                <?php foreach ($detail_rumus as $key_dr => $val_dr) : ?>
                                  <th><?= $val_dr['rumus_detail_nama']; ?></th>
                                <?php endforeach; ?>
                                <th>Hasil</th>
                              </tr>
                            </thead>
                            <?php $logsheet_level_2 = $this->M_inbox->getLogsheetDetail(array('logsheet_multiple_id' => $this->input->get('multiple_logsheet_id'), 'rumus_id' => $val_td['rumus_id']));
                            ?>
                            <?php foreach ($logsheet_level_2 as $key_ll2 => $val_ll2) : ?>
                              <tbody>
                                <tr>
                                  <td>
                                    <?= $val_ll2['logsheet_nomor_sample'] ?>
                                  </td>
                                  <?php
                                  $logsheet_level_3 = $this->M_inbox->getLogsheetDetailDetail(array('logsheet_detail_id' => $val_ll2['logsheet_detail_id']));
                                  foreach ($logsheet_level_3 as $key_ll3 => $val_ll3) : ?>
                                    <?php
                                    $background = '';

                                    ?>
                                    <td style="background-color: <?= $background ?>;">
                                      <?= $val_ll3['rumus_detail_isi']; ?>
                                    </td>
                                  <?php endforeach; ?>
                                  <td>
                                    <?= $val_ll2['rumus_hasil'] ?>
                                  </td>

                                </tr>
                              </tbody>
                            <?php endforeach; ?>

                          </table>
                        </div>
                      <?php endforeach; ?>
                    </div>
                    <!-- table -->
                    <!-- Rumus -->
                    <hr>
                  </div>
                  <!-- this -->
                </div>
              </div>

              <div class="card-body">
                <!-- <div class="col-6"></div> -->
                <div class="col-6" style="float:right">
                  <table id="table" class="table table-bordered" width="50%" style="float:right">
                    <thead>
                      <tr>
                        <th>Analisis</th>
                        <th>Reviewer</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th>
                          <?php if ($logsheet_group['logsheet_analisis'] != '') : ?>
                            <img src="<?= base_url('img/' . $logsheet_group['logsheet_analisis_qr']) ?>" style="max-width:4cm;max-height:4cm">
                          <?php endif; ?>
                        </th>
                        <th>
                          <?php if ($logsheet_group['logsheet_review'] != '') : ?>
                            <img src="<?= base_url('img/' . $logsheet_group['logsheet_review_qr']) ?>" style="max-width:4cm;max-height:4cm">
                          <?php endif; ?>
                        </th>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <!-- </form> -->

              <div class="card-footer">
                <button type="button" id="close" class="btn btn-default border-dark">Kembali</button>
                <button type="button" id="cetak" class="btn btn-primary">Cetak Preview</button>
                <button type="button" id="simpan" class="btn btn-success float-right">Selanjutnya</button>
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