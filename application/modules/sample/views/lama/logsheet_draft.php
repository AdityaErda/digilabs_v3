<!-- <script src="<?= base_url() ?>assets/plugins/jquery/jquery.min.js"></script> -->
<script src="<?= base_url() ?>assets_tambahan/tinymce/tinymce.min.js"></script>

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
          <!-- <h1>Lembar Kerja <?= $inbox_detail[0]['jenis_nama'] ?></h1> -->
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
              <input type="text" id="is_new" name="is_new" style="display:none">
              <input type="text" id="transaksi_status" name="transaksi_status" style="display:none" value="<?= $inbox['transaksi_status'] ?>">
              <input type="text" id="transaksi_detail_status" name="transaksi_detail_status" style="display:none" value="<?= $_GET['transaksi_detail_status'] ?>">
              <input type="text" id="transaksi_non_rutin_id" name="transaksi_non_rutin_id" style="display:none" value="<?= create_id() ?>">
              <input type="text" id="transaksi_id" name="transaksi_id" style="display: none;" value="<?= $_GET['transaksi_id'] ?>">
              <input type="text" id="template_logsheet_id" name="template_logsheet_id" style="display:none" value="<?= $_GET['template_logsheet_id'] ?>">
              <input type="text" id="logsheet_id" name="logsheet_id" value="<?= $logsheet['logsheet_id'] ?>" style="display:none">
              <input type="text" id="transaksi_detail_id_temp" name="transaksi_detail_id_temp" value="<?= $_GET['transaksi_detail_id'] ?>" style="display: none;">
              <input type="text" id="transaksi_detail_id" name="transaksi_detail_id" value="<?= create_id(); ?>" style="display: none;">
              <input type="text" id="transaksi_drafter_detault" name="transaksi_drafter_default" value="<?= $inbox['transaksi_drafter'] ?>" style="display:none">
              <textarea name="custom_raw_eksekutor" class="custom_raw_eksekutor" id="custom_raw_eksekutor">
                <div class="card-body row">
                  <!-- Kiri -->
                  <div class="col-12">
                    <div class="row">
                      <div class="col-6">
                        <h4 class="text-center">LEMBAR KERJA <?= strtoupper($logsheet['logsheet_jenis_nama']) ?></h4>
                      </div>
                      <div class="col-6">
                        <table style="border-collapse:collapse;border:1px solid black;float:right" width="100%" cellpadding="2" cellspacing="2">
                          <tr>
                            <td width="45%">No Dokumen</td>
                            <td>:</td>
                            <td>FM-39-4210</td>
                          </tr>
                          <tr>
                            <td>Terbitan / Revisi</td>
                            <td>:</td>
                            <td></td>
                          </tr>
                          <tr>
                            <td>Tanggal Pengesahan</td>
                            <td>:</td>
                            <td><?= ($logsheet['logsheet_review_date'] != '') ? date_indo(date('Y-m-d', strtotime($logsheet['logsheet_review_date']))) : '-' ?></td>
                          </tr>
                          <tr>
                            <td>Lembar</td>
                            <td>:</td>
                          </tr>
                        </table>
                      </div>
                    </div>
                  </div>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <div class="col-12">
                    <div class="row">
                      <div class="col-6">
                        <div class="form-group row col-12">
                          <label class="col-md-4">Contoh</label>
                          <div class="input-group col-md-8">
                            <input type="text" class="form-control" id="logsheet_jenis_nama" name="logsheet_jenis_nama" placeholder="Judul" value="<?= $logsheet['logsheet_jenis_nama'] ?>" style="display:none" readonly>
                            <label for="" class="">:&nbsp;<?= $logsheet['logsheet_jenis_nama'] ?></label>
                          </div>
                        </div>
                        <div class="form-group row col-12">
                          <label class="col-md-4">Tanda</label>
                          <div class="input-group col-md-8">
                            <input type="text" class="form-control" id="logsheet_nomor_permintaan" name="logsheet_nomor_permintaan" placeholder="Judul" value="<?= $logsheet['logsheet_nomor_permintaan'] ?>" readonly style="display:none">
                            <label for="" class="">:&nbsp;<?= $logsheet['logsheet_nomor_permintaan'] ?></label>
                          </div>
                        </div>
                        <div class="form-group row col-12">
                          <label class="col-md-4">Catatan</label>
                          <div class="input-group col-md-8">
                            <input type="text" class="form-control" id="logsheet_deskripsi" name="logsheet_deskripsi" value="<?= $logsheet['logsheet_deskripsi'] ?>" readonly style="display:none">
                            <label for="">:&nbsp;<?= $logsheet['logsheet_deskripsi'] ?></label>
                          </div>
                        </div>
                        <div class="form-group row col-12">
                          <label class="col-md-4">Sertifikat</label>
                          <div class="input-group col-md-8">
                            <input type="text" class="form-control" id="transaksi_detail_nomor" name="transaksi_detail_nomor" value="<?= $inbox_detail[0]['transaksi_detail_nomor'] ?>" readonly style="display:none">
                            <label for="">:&nbsp;<?= $inbox_detail[0]['transaksi_detail_nomor'] ?></label>
                          </div>
                        </div>
                        <div class="form-group row col-12" style="display:none">
                          <label class="col-md-4">Area</label>
                          <div class="input-group col-md-8">
                            <input type="text" class="form-control" id="logsheet_area" name="logsheet_area" value="<?= $inbox_detail[0]['transaksi_detail_nomor'] ?>" readonly style="display:none">
                            <label for=""> : &nbsp;<?= $inbox_detail[0]['transaksi_detail_nomor'] ?></label>
                          </div>
                        </div>
                      </div>
                      <div class="col-6">

                        <div class="form-group row col-12">
                          <label class="col-md-4">No. Lab</label>
                          <div class="input-group col-md-8">
                            <input type="text" class="form-control" id="transaksi_detail_nomor_sample" name="transaksi_detail_nomor_sample" value="<?= $inbox_detail[0]['transaksi_detail_nomor_sample'] ?>" readonly style="display:none">
                            <label for="">:&nbsp;<?= $inbox_detail[0]['transaksi_detail_nomor_sample'] ?></label>
                          </div>
                        </div>

                        <?php if ($inbox_detail[0]['is_sampling'] == 'y') { ?>
                          <div class="form-group row col-12">
                            <label class="col-md-4">Tanggal Sampling</label>
                            <div class="input-group col-md-8">
                              <div class="input-group-prepend" style="display:none">
                                <span class="input-group-text">
                                  <i class="far fa-calendar-alt"></i>
                                </span>
                              </div>
                              <input type="text" class="form-control float-right tanggal" id="logsheet_tgl_sampling" name="logsheet_tgl_sampling" value="<?= date('d-m-Y', strtotime($logsheet['logsheet_tgl_sampling'])) ?>" readonly style="display:none">
                              <label for="">:&nbsp;<?= date_indo('Y-m-d', strtotime($logsheet['logsheet_tgl_sampling'])) ?></label>
                            </div>
                          </div>
                        <?php } ?>

                        <div class="form-group row col-12">
                          <label class="col-md-4">Tanggal Terima</label>
                          <div class="input-group col-md-8">
                            <div class="input-group-prepend" style="display:none">
                              <span class="input-group-text">
                                <i class="far fa-calendar-alt"></i>
                              </span>
                            </div>
                            <input type="text" class="form-control float-right tanggal" id="logsheet_tgl_terima" name="logsheet_tgl_terima" value="<?= date('d-m-Y', strtotime($logsheet['logsheet_tgl_terima'])) ?>" readonly style="display:none">
                            <label for="">:&nbsp;<?= date_indo('Y-m-d', strtotime($logsheet['logsheet_tgl_terima'])) ?></label>
                          </div>
                        </div>

                        <div class="form-group row col-12">
                          <label class="col-md-4">Tanggal Pengujian</label>
                          <div class="input-group col-md-8">
                            <div class="input-group-prepend" style="display:none">
                              <span class="input-group-text">
                                <i class="far fa-calendar-alt"></i>
                              </span>
                            </div>
                            <input type="text" class="form-control float-right tanggal" id="logsheet_tgl_uji" name="logsheet_tgl_uji" value="<?= date('d-m-Y', strtotime($logsheet['logsheet_tgl_uji'])) ?>" readonly style="display: none;">
                            <label for="">:&nbsp;<?= date_indo('Y-m-d', strtotime($logsheet['logsheet_tgl_uji'])) ?></label>
                          </div>
                        </div>

                        <div class="form-group row col-12">
                          <label class="col-md-4">Analisis</label>
                          <div class="input-group col-md-8">
                            <input type="text" class="form-control" id="logsheet_analisis" name="logsheet_analisis" value="<?= $logsheet['nama_analisis'] ?>" readonly style="display:none">
                            <label for="">:&nbsp;<?= ($logsheet['nama_analisis'] != '') ? $logsheet['nama_analisis'] : $session['user_nama'] ?></label>
                          </div>
                        </div>

                      </div>
                    </div>
                  </div>

                  <?php foreach ($detail_logsheet as $keyx => $valuex) : ?>
                    <?php
                    $sql_header = $this->db->query("SELECT DISTINCT rumus_detail_nama FROM sample.sample_logsheet_detail_detail where id_rumus = '" . $valuex['rumus_id'] . "'");

                    $sql_footer = $this->db->query("SELECT DISTINCT rumus_avg,rumus_adbk FROM sample.sample_logsheet_detail WHERE id_rumus = '" . $valuex['rumus_id'] . "' AND logsheet_id='" . $_GET['logsheet_id'] . "' AND rumus_avg IS NOT NULL AND rumus_adbk IS NOT NULL");

                    $sql_konten = $this->db->query("SELECT * FROM sample.sample_logsheet a LEFT JOIN sample.sample_logsheet_detail b ON a.logsheet_id = b.logsheet_id LEFT JOIN sample.sample_perhitungan_sample c ON c.rumus_id = b.id_rumus WHERE id_transaksi = '" . $_GET['transaksi_id'] . "' AND a.logsheet_id = '" . $_GET['logsheet_id'] . "' AND b.id_rumus = '" . $valuex['rumus_id'] . "'");

                    $sql_detail_rumus = $this->db->query("SELECT * FROM sample.sample_perhitungan_sample_detail WHERE id_rumus = '" . $valuex['rumus_id'] . "' ORDER BY rumus_detail_urut ASC");

                    $jumlah_header = $sql_header->num_rows();

                    ?>

                    <div class="card-header col-12">
                      <h4 class="card-title"><?= $valuex['rumus_nama'] ?> =
                        <?php foreach ($sql_detail_rumus->result_array() as $key_detail_rumus => $value_detail_rumus) : ?>
                          <?php if ($value_detail_rumus['rumus_jenis'] == 'O') { ?>
                            <?php echo $value_detail_rumus['rumus_detail_input'] ?>
                          <?php } else { ?>
                            <?php echo $value_detail_rumus['rumus_detail_nama'] ?>
                          <?php } ?>
                        <?php endforeach; ?>
                      </h4>
                    </div>
                    <div class="form-group col-12 row">
                      <table id="" class="table datatables table-bordered" width="100%" border="1">
                        <thead>
                          <tr>
                            <?php foreach ($sql_header->result_array() as $key_header1 => $value_header1) : ?>
                              <?php if ($value_header1['rumus_detail_nama'] != $value_header1['rumus_detail_nama']) : ?>
                                <th><?= $value_header1['rumus_detail_nama'] ?></th>
                              <?php else : ?>
                                <th><?= $value_header1['rumus_detail_nama'] ?></th>
                              <?php endif ?>
                            <?php endforeach; ?>
                            <th>Metoda</th>
                            <th>Satuan</th>
                            <th>Hasil</th>
                          </tr>
                        </thead>

                        <?php
                        foreach ($sql_konten->result_array() as $key => $value) :

                          $sql = $this->db->query("SELECT * FROM sample.sample_logsheet_detail_detail WHERE id_logsheet_detail='" . $value['logsheet_detail_id'] . "'");
                        ?>
                          <tbody>
                            <tr>
                              <?php foreach ($sql->result_array() as $key1 => $value1) :
                              ?>
                                <td><?= $value1['rumus_detail_isi'] ?></td>
                              <?php endforeach; ?>
                              <td><?= $value['rumus_metoda'] ?></td>
                              <td><?= $value['rumus_satuan'] ?></td>
                              <td><?= $value['rumus_hasil'] ?></td>
                            </tr>
                          </tbody>
                        <?php endforeach; ?>
                        <tfoot>
                          <tr>
                            <?php foreach ($sql_footer->result_array() as $key_footer1 => $value_footer1) : ?>
                              <?php if ($value_footer1['rumus_avg'] != '') { ?>
                                <th colspan="<?php echo ($jumlah_header) ?>"> Rata - rata</th>
                                <th><?= $value_footer1['rumus_avg'] ?></th>
                              <?php } ?>
                            <?php endforeach; ?>
                          </tr>
                          <tr>
                            <?php foreach ($sql_footer->result_array() as $key_footer1 => $value_footer1) : ?>
                              <?php if ($value_footer1['rumus_adbk'] != '') { ?>
                                <th colspan="<?php echo ($jumlah_header) ?>"> ADBK</th>
                                <th><?= $value_footer1['rumus_adbk'] ?></th>
                              <?php } ?>
                            <?php endforeach; ?>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
                  <?php endforeach; ?>
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
                            <?php if ($logsheet['logsheet_analisis'] != '') : ?>
                              <img src="<?= base_url('img/' . $logsheet['logsheet_analisis_qr']) ?>" style="max-width:4cm;max-height:4cm">
                            <?php endif; ?>
                          </th>
                          <th>
                            <?php if ($logsheet['logsheet_review'] != '') : ?>
                              <img src="<?= base_url('img/' . $logsheet['logsheet_review_qr']) ?>" style="max-width:4cm;max-height:4cm">
                            <?php endif; ?>
                          </th>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </textarea>
              <!-- Memorandum -->
              <div class="no-print">
                <div class="card-footer">
                  <button type="button" id="close" class="btn btn-default border-dark" onclick="history.back()">Kembali</button>
                  <button type="button" id="draft" class="btn btn-info">Draft</button>
                  <button type="button" id="cetak" class="btn btn-primary">Cetak Preview</button>
                  <button type="button" id="simpan" class="btn btn-success float-right">Selanjutnya</button>
                </div>
              </div>
            </div>
          </form>
          <!-- modal -->
        </div>
      </div>
    </div>
  </section>
  <!-- Container Body -->
</div>
<!-- CONTAINER-->