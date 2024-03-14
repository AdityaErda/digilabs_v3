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
          <form id="form_logsheet">
            <!-- FILTER -->
            <!-- Memorandum -->
            <!-- <div class="card"> -->
            <!-- Header -->
            <!-- <div class="card-header bg-primary">
                <h3 class="card-title">
                  <center> Lembar Kerja <?php echo $inbox['transaksi_nomor'] ?> </center>
                </h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div> -->

            <!-- Header -->
            <!-- Body -->
            <!-- <div class="card-body row"> -->
            <!-- Kiri -->
            <input type="text" id="is_new" name="is_new" style="display:none">
            <input type="text" id="transaksi_status" name="transaksi_status" style="display:none" value="<?= $inbox['transaksi_status'] ?>">
            <input type="text" id="transaksi_detail_status" name="transaksi_detail_status" style="display:none" value="<?= $_GET['transaksi_detail_status'] ?>">
            <input type="text" id="transaksi_non_rutin_id" name="transaksi_non_rutin_id" style="display:none" value="<?= create_id() ?>">
            <input type="text" id="transaksi_id" name="transaksi_id" style="display: none;" value="<?= $_GET['transaksi_id'] ?>">
            <input type="text" id="template_logsheet_id" name="template_logsheet_id" style="display:none" value="<?= $_GET['template_logsheet_id'] ?>">
            <input type="text" id="logsheet_id" name="logsheet_id" value="<?= $logsheet['logsheet_id'] ?>" style="display:none">
            <input type="text" id="transaksi_detail_id_temp" name="transaksi_detail_id_temp" value="<?= $_GET['transaksi_detail_id'] ?>" style="display: none;">
            <input type="text" id="transaksi_detail_id" name="transaksi_detail_id" value="<?= create_id(); ?>" style="display: none;">
            <!-- <input type="text" id="transaksi_tipe" name="transaksi_tipe" value="<?= $tipe ?>" style="display: none;"> -->
            <input type="text" id="transaksi_drafter_detault" name="transaksi_drafter_default" value="<?= $inbox['transaksi_drafter'] ?>" style="display:none">
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
              <div id="area_cetak" class="area_cetak">
                <textarea name="custom_area" id="custom_area">
              <?php foreach ($logsheet_detail as $key => $detail) :  ?>
                <div class="card-body">
                  <table border="1" width="100%" style="border:1px solid black;border-collapse:collapse">
                    <tr>
                      <th>SERTIFIKAT PENGUJIAN
                        <br>
                        <hr>
                        <br>
                        No : <? //= $inbox_detail[0]['transaksi_detail_nomor_sample']
                              ?>
                      </th>
                    </tr>
                  </table>
                  <br>
                  <table border="0" width="100%">
                    <tr>
                      <td width="30%">No Sample</td>
                      <td><?= $logsheet['logsheet_nomor_sample'] ?></td>
                    </tr>
                    <tr>
                      <td>Nama Bahan</td>
                      <td><?= $logsheet['logsheet_jenis_nama'] ?></td>
                    </tr>
                    <tr>
                      <td>Peminta Jasa</td>
                      <td><?= $logsheet['logsheet_peminta_jasa'] ?></td>
                    </tr>
                    <tr>
                      <td>Tanggal Terima</td>
                      <td><?= $logsheet['logsheet_tgl_terima']; ?></td>
                    </tr>
                    <tr>
                      <td>Tanggal Sampling</td>
                      <td><?= $logsheet['logsheet_tgl_sampling'] ?></td>
                    </tr>
                    <tr>
                      <td>Asal Sample</td>
                      <td><?= $logsheet['logsheet_asal_sample'] ?></td>
                    </tr>
                    <tr>
                      <td>Pengambilan Contoh Oleh</td>
                      <td><?= $logsheet['logsheet_pengolah_sample'] ?></td>
                    </tr>
                  </table>

                  <table border="1" width="100%" style="border:1px solid black;border-collapse:collapse">
                    <thead>
                      <tr>
                        <th>Jenis Uji</th>
                        <th>Unit</th>
                        <th>Spesifikasi Hasil Uji</th>
                        <th>Metoda </th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($logsheet_detail as $key => $value) : ?>
                        <tr>
                          <td><?= $value['logsheet_detail_nama'] ?></td>
                          <td><?= $value['logsheet_detail_unit'] ?></td>
                          <td><?= $value['logsheet_detail_spesifikasi'] ?></td>
                          <td><?= $value['logsheet_detail_metoda'] ?></td>
                        </tr>
                      <?php endforeach ?>
                    </tbody>
                  </table>
                  Catatan : jangan dicampur dengan produk dari produsen lain untuk tujuan ketertelusuran produk.
                  <br>
                  Diterbitkan Tanggal : <? //= date('d-m-y')
                                        ?>
                  <table border="0" width="100%">
                    <tr>
                      <td>
                        PT Petrokimia Gresik
                      </td>
                      <td>
                        <b>Adityo Dwiputra Sunarto, S.T. , M.Sc.</b>
                        <br>
                        Pgs VP Proses dan Pengendalian Kualitas
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <!-- PT Petrokimia Gresik -->
                      </td>
                      <td>
                        <b>Anggi Arifin Nasution</b>
                        <br>
                        SMd I Evaluasi Proses Pabrik III
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <!-- PT Petrokimia Gresik -->
                      </td>
                      <td>
                        <b>Bambang Ariwibowo . S.T., M.M.</b>
                        <br>
                        VP Proses & Pengendalian Kualitas
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <b>Adityo Dwiputra Sunarto, S.T. , M.Sc.</b>
                        <br>
                        VP Proses dan Pengendalian Kualitas
                      </td>
                      <td>
                        <b>Ari Setyo Purnomo, S.Si.</b>
                        <br>
                        AVP Lab. Pabrik III
                      </td>
                    </tr>
                  </table>
                  Asli : VP. Administrasi & Penjualan
                  <br>
                  Tembusan : Bagian Sekretariat
                  <br>
                  sa/rsy
                </div>
              <?php endforeach; ?>
              </textarea>
              </div>
              <div class="card-footer">
                <button type="button" id="close" class="btn btn-default" onclick="history.back()">Kembali</button>
                <button type="button" id="simpan" class="btn btn-success">Kirim DOF</button>
                <button type="button" id="cetak" class="btn btn-success">Cetak Word(Test)</button>
                <!-- <a href="<?= base_url('sample/inbox/insertDOF') ?>" class="btn btn-success">Cetak Word(Test)</a> -->
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