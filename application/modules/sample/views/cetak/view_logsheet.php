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
          <h1>Review <?= $judul ?></h1>
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
                  <center> Lembar Kerja<?php echo $inbox['transaksi_nomor'] ?> </center>
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
                <input type="text" id="is_new" name="is_new" style="display:none">
                <input type="text" id="transaksi_status" name="transaksi_status" style="display:none" value="<?= $inbox['transaksi_status'] ?>">
                <input type="text" id="transaksi_detail_status" name="transaksi_detail_status" style="display:none" value="<?= $_GET['transaksi_detail_status'] ?>">
                <input type="text" id="transaksi_non_rutin_id" name="transaksi_non_rutin_id" style="display:none" value="<?= create_id() ?>">
                <input type="text" id="transaksi_id" name="transaksi_id" style="display: none;" value="<?= $_GET['transaksi_id'] ?>">
                <input type="text" id="template_logsheet_id" name="template_logsheet_id" style="display:none" value="<?= $_GET['template_logsheet_id'] ?>">
                <input type="text" id="logsheet_id" name="logsheet_id" value="<?= $logsheet['logsheet_id'] ?>" style="display:none">

                <input type="text" id="transaksi_detail_id" name="transaksi_detail_id" value="<?= $_GET['transaksi_detail_id'] ?>" style="display: none;">
                <input type="text" id="transaksi_tipe" name="transaksi_tipe" value="<?= $tipe ?>" style="display: none;">
                <div class="col-12">
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group row col-12">
                        <label class="col-md-4">Jenis</label>
                        <div class="input-group col-md-8">
                          <input type="text" class="form-control" id="transaksi_jenis" name="transaksi_jenis" placeholder="Judul" value="<?= $logsheet['logsheet_jenis_nama'] ?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row col-12">
                        <label class="col-md-4">Tanda</label>
                        <div class="input-group col-md-8">
                          <input type="text" class="form-control" id="transaksi_tanda" name="transaksi_tanda" placeholder="Judul" value="<?= $logsheet['logsheet_tanda'] ?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row col-12">
                        <label class="col-md-4">Catatan</label>
                        <div class="input-group col-md-8">
                          <input type="text" class="form-control" id="transaksi_catatan" name="transaksi_catatan" value="<?= $logsheet['logsheet_catatan'] ?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row col-12">
                        <label class="col-md-4">Sertifikat</label>
                        <div class="input-group col-md-8">
                          <input type="text" class="form-control" id="transaksi_sertifikat" name="transaksi_sertifikat" value="<?= $logsheet['logsheet_sertifikat'] ?>" readonly>
                        </div>
                      </div>
                    </div>

                    <div class="col-6">
                      <div class="form-group row col-12">
                        <label class="col-md-4">No Lab</label>
                        <div class="input-group col-md-8">
                          <input type="text" class="form-control" id="transaksi_no_lab" name="transaksi_no_lab" value="<?= $logsheet['logsheet_nolab'] ?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row col-12">
                        <label class="col-md-4">Tanggal Terima</label>
                        <div class="input-group col-md-8">
                          <div class="input-group-prepend">
                            <span class="input-group-text">
                              <i class="far fa-calendar-alt"></i>
                            </span>
                          </div>
                          <input type="text" class="form-control float-right tanggal" id="transaksi_tgl_terima" name="transaksi_tgl_terima" readonly value="<?= $logsheet['logsheet_tgl_terima'] ?>">
                        </div>
                      </div>
                      <div class="form-group row col-12">
                        <label class="col-md-4">Tanggal Sampling</label>
                        <div class="input-group col-md-8">
                          <div class="input-group-prepend">
                            <span class="input-group-text">
                              <i class="far fa-calendar-alt"></i>
                            </span>
                          </div>
                          <input type="text" class="form-control float-right tanggal" id="transaksi_tgl_sampling" name="transaksi_tgl_sampling" readonly value="<?= $logsheet['logsheet_tgl_sampling'] ?>">
                        </div>
                      </div>
                      <div class="form-group row col-12">
                        <label class="col-md-4">Jam Sampling</label>
                        <div class="input-group col-md-8">
                          <div class="input-group-prepend">
                            <span class="input-group-text">
                              <i class="far fa-calendar-alt"></i>
                            </span>
                          </div>
                          <input type="text" class="form-control float-right waktu" id="transaksi_jam_sampling" name="transaksi_jam_sampling" readonly value="<?= $logsheet['logsheet_jam_sampling'] ?>">
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
                <h3 class="card-title"> Detail Sample <?= $inbox_detail[0]['transaksi_detail_nomor_sample'] ?></h3>
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
                  <?php foreach ($logsheet_detail as $key => $value) : ?>
                    <div class="div_log_baru">
                      <div class="row">
                        <div class="col-6">
                          <div class="form-group row col-12">
                            <label class="col-md-4">Jenis Uji</label>
                            <div class="input-group col-md-8">
                              <input type="text" class="form-control" id="log_jenis_nama" name="log_jenis_nama[0]" placeholder="Jenis Uji" value="<?= $value['logsheet_detail_nama'] ?>" readonly>
                            </div>
                          </div>
                          <div class="form-group row col-12">
                            <label class="col-md-4">Satuan</label>
                            <div class="input-group col-md-8">
                              <input type="text" class="form-control" id="log_jenis_unit" name="log_jenis_unit[0]" placeholder="Satuan" value="<?= $value['logsheet_detail_unit'] ?>" readonly>
                            </div>
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="form-group row col-12">
                            <label class="col-md-4">Metoda</label>
                            <div class="input-group col-md-8">
                              <input type="text" class="form-control" id="log_metoda" name="log_metoda[0]" placeholder="Metoda" value="<?= $value['logsheet_detail_metoda'] ?>" readonly>
                            </div>
                          </div>
                          <div class="form-group row col-12">
                            <label class="col-md-4">Rumus</label>
                            <div class="input-group col-md-8">
                              <select id="rumus" name="rumus[0]" class="form-control select2 rumus"></select>
                            </div>
                          </div>
                        </div>
                      </div>
                      <br>
                      <div class="row">
                        <div class=" form-group col-12 row">
                          <!-- <form id="form_logsheet"> -->
                          <table id="table" class="table table-bordered table-striped" width="100%">
                            <thead>
                              <tr>
                                <th>No</th>
                                <th>Vol Orsat</th>
                                <th>Vol Sisa Gas</th>
                                <th>Hasil</th>
                                <!-- <th>Aksi</th> -->
                              </tr>
                            </thead>
                            <tbody class="tbody" id="tbody">
                              <input type="text" id="logsheet_urut" name="logsheet_urut[0]" value="<?= $value['logsheet_detail_urut'] ?>" hidden>
                              <input type="text" id="logsheeet_detail_id" name="logsheet_detail_id[0]" value="<?= $value['logsheet_detail_id'] ?>" class="logsheet_detail_id" hidden>
                              <tr class="tr" id="tr">
                                <!-- <input type="text" id="logsheet_isi_urut" name="logsheet_isi_urut" value="1"> -->
                                <?php foreach ($this->M_inbox->getLogsheetDetailDetail(array('logsheet_detail_id' => $value['logsheet_detail_id'])) as $key1 => $value1) :  ?>
                                  <td class="td">
                                    <input type="text" id="param_urut_1" name="param_urut[0][]" value="<?= $value1['logsheet_detail_detail_isi_urut'] ?>" hidden>
                                    <input type="text" class="form-control" id="param_1" name="param_isi[0][]" value="<?= $value1['logsheet_detail_detail_isi'] ?>" readonly>
                                  </td>
                                  <!--                               <td class="td">
                                <input type="text" id="param_urut_1" name="param_urut[0][]" value="2">
                                <input type="text" class="form-control" id="param_2" name="param_isi[0][]">
                              </td>
                              <td class="td">
                                <input type="text" id="param_urut_1" name="param_urut[0][]" value="3">
                                <input type="text" class="form-control" id="param_3" name="param_isi[0][]">
                              </td>
                              <td class="td">
                                <input type="text" id="param_urut_1" name="param_urut[0][]" value="4">
                                <input type="text" class="form-control" id="param_4" name="param_isi[0][]">
                              </td>-->
                                <?php endforeach; ?>
                              </tr>
                            </tbody>
                          </table>
                          <!-- </form> -->
                        </div>
                      </div>
                      <hr>
                    </div>
                  <?php endforeach; ?>
                  <!-- this -->
                </div>
              </div>
              <!-- </form> -->
              <div class="card-footer">
                <button type="button" id="close" class="btn btn-default" onclick="history.back()">Kembali</button>
                <!-- <button type="button" id="simpan" class="btn btn-success">Kirim Ka Sie</button> -->
                <button onclick="cetak_logsheet()">Cetak Logsheet</button>
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
                  <button class="btn btn-primary" type="button" id="loading_batal" disabled style="display: none;">
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
                  <button class="btn btn-primary" type="button" id="loading_tunda" disabled style="display: none;">
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