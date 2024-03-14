<script src="<?= base_url() ?>assets_tambahan/tinymce/tinymce.min.js"></script>

<script src="https://unpkg.com/mathjs/lib/browser/math.js"></script>
<link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet">
<!-- <script src="YourJquery source path"></script> -->
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>

<style type="text/css">
  #modal-content {
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
              <input type="text" id="transaksi_tipe" name="transaksi_tipe" style="display:none" value="<?= $inbox['transaksi_tipe'] ?>">
              <input type="text" id="transaksi_status" name="transaksi_status" style="display:none" value="<?= $inbox['transaksi_status'] ?>">
              <input type="text" id="transaksi_detail_status" name="transaksi_detail_status" style="display:none" value="<?= $_GET['transaksi_detail_status'] ?>">
              <input type="text" id="transaksi_non_rutin_id" name="transaksi_non_rutin_id" style="display:none" value="<?= create_id() ?>">
              <input type="text" id="transaksi_id" name="transaksi_id" style="display: none;" value="<?= $_GET['transaksi_id'] ?>">
              <input type="text" id="template_logsheet_id" name="template_logsheet_id" style="display:none" value="<?= $_GET['template_logsheet_id'] ?>">
              <input type="text" id="logsheet_id" name="logsheet_id" value="<?= $logsheet['logsheet_id'] ?>" style="display:none">
              <input type="text" id="transaksi_detail_id_temp" name="transaksi_detail_id_temp" value="<?= $_GET['transaksi_detail_id'] ?>" style="display: none;">
              <input type="text" id="transaksi_detail_id_new" name="transaksi_detail_id_new" value="<?= create_id() . '-' . rand(); ?>" style="display: none;">
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
                            <!-- <td><?php //echo $inbox_detail[0]['transaksi_detail_nomor_sample']
                          ?></td> -->
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
                        <span class="col-md-4">Contoh</span>
                        <div class="input-group col-md-8">
                          <input type="text" class="form-control" id="logsheet_jenis_nama" name="logsheet_jenis_nama" placeholder="Judul" value="<?= $logsheet['logsheet_jenis_nama'] ?>" style="display:none" readonly>
                          <span for="" class=""> : &nbsp;<?= $logsheet['logsheet_jenis_nama'] ?></span>
                        </div>
                      </div>
                      <div class="form-group row col-12">
                        <span class="col-md-4">Tanda</span>
                        <div class="input-group col-md-8">
                          <input type="text" class="form-control" id="logsheet_nomor_permintaan" name="logsheet_nomor_permintaan" placeholder="Judul" value="<?= $logsheet['logsheet_nomor_permintaan'] ?>" readonly style="display:none">
                          <span for="" class=""> : &nbsp;<?= $logsheet['logsheet_nomor_permintaan'] ?></span>
                        </div>
                      </div>
                      <div class="form-group row col-12">
                        <span class="col-md-4">Catatan</span>
                        <div class="input-group col-md-8">
                          <input type="text" class="form-control" id="logsheet_deskripsi" name="logsheet_deskripsi" value="<?= $logsheet['logsheet_deskripsi'] ?>" readonly style="display:none">
                          <span for=""> : &nbsp;<?= $logsheet['logsheet_deskripsi'] ?></span>
                        </div>
                      </div>
                      <div class="form-group row col-12">
                        <span class="col-md-4">Sertifikat</span>
                        <div class="input-group col-md-8">
                          <input type="text" class="form-control" id="transaksi_detail_nomor" name="transaksi_detail_nomor" value="<?= $inbox_detail[0]['transaksi_detail_nomor'] ?>" readonly style="display:none">
                          <span for=""> : &nbsp;<?= $inbox_detail[0]['transaksi_detail_nomor'] ?></span>
                        </div>
                      </div>
                      <div class="form-group row col-12" style="display:none">
                        <span class="col-md-4">Area</span>
                        <div class="input-group col-md-8">
                          <input type="text" class="form-control" id="logsheet_area" name="logsheet_area" value="<?= $inbox_detail[0]['transaksi_detail_nomor'] ?>" readonly style="display:none">
                          <span for=""> : &nbsp;<?= $inbox_detail[0]['transaksi_detail_nomor'] ?></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-6">

                      <div class="form-group row col-12">
                        <span class="col-md-4">No. Lab</span>
                        <div class="input-group col-md-8">
                          <input type="text" class="form-control" id="transaksi_detail_nomor_sample" name="transaksi_detail_nomor_sample" value="<?= $inbox_detail[0]['transaksi_detail_nomor_sample'] ?>" readonly style="display:none">
                          <span for=""> : &nbsp;<?= $inbox_detail[0]['transaksi_detail_nomor_sample'] ?></span>
                        </div>
                      </div>

                      <?php if ($inbox_detail[0]['is_sampling'] == 'y') { ?>
                        <div class="form-group row col-12">
                          <span class="col-md-4">Tanggal Sampling</span>
                          <div class="input-group col-md-8">
                            <div class="input-group-prepend" style="display:none">
                              <span class="input-group-text">
                                <i class="far fa-calendar-alt"></i>
                              </span>
                            </div>
                            <input type="text" class="form-control float-right tanggal" id="logsheet_tgl_sampling" name="logsheet_tgl_sampling" value="<?= date('d-m-Y', strtotime($logsheet['logsheet_tgl_sampling'])) ?>" readonly style="display:none">
                            <span for=""> : &nbsp;<?= date_indo('Y-m-d', strtotime($logsheet['logsheet_tgl_sampling'])) ?></span>
                          </div>
                        </div>
                      <?php } ?>

                      <div class="form-group row col-12">
                        <span class="col-md-4">Tanggal Terima</span>
                        <div class="input-group col-md-8">
                          <div class="input-group-prepend" style="display:none">
                            <span class="input-group-text">
                              <i class="far fa-calendar-alt"></i>
                            </span>
                          </div>
                          <input type="text" class="form-control float-right tanggal" id="logsheet_tgl_terima" name="logsheet_tgl_terima" value="<?= date('d-m-Y', strtotime($logsheet['logsheet_tgl_terima'])) ?>" readonly style="display:none">
                          <span for=""> : &nbsp;<?= date_indo('Y-m-d', strtotime($logsheet['logsheet_tgl_terima'])) ?></span>
                        </div>
                      </div>

                      <div class="form-group row col-12">
                        <span class="col-md-4">Tanggal Pengujian</span>
                        <div class="input-group col-md-8">
                          <div class="input-group-prepend" style="display:none">
                            <span class="input-group-text">
                              <i class="far fa-calendar-alt"></i>
                            </span>
                          </div>
                          <input type="text" class="form-control float-right tanggal" id="logsheet_tgl_uji" name="logsheet_tgl_uji" value="<?= date('d-m-Y', strtotime($logsheet['logsheet_tgl_uji'])) ?>" readonly style="display: none;">
                          <span for=""> : &nbsp;<?= date_indo('Y-m-d', strtotime($logsheet['logsheet_tgl_uji'])) ?></span>
                        </div>
                      </div>

                      <div class="form-group row col-12">
                        <span class="col-md-4">Analisis</span>
                        <div class="input-group col-md-8">
                          <input type="text" class="form-control" id="logsheet_analisis" name="logsheet_analisis" value="<?= $logsheet['nama_analisis'] ?>" readonly style="display:none">
                          <span for=""> : &nbsp;<?= ($logsheet['nama_analisis'] != '') ? $logsheet['nama_analisis'] : $session['user_nama'] ?></span>
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
                    <h3 class="card-title"><?= $valuex['rumus_nama'] ?> =
                      <?php foreach ($sql_detail_rumus->result_array() as $key_detail_rumus => $value_detail_rumus) : ?>
                        <?php if ($value_detail_rumus['rumus_jenis'] == 'O') { ?>
                          <?php echo $value_detail_rumus['rumus_detail_input'] ?>
                        <?php } else { ?>
                          <?php echo $value_detail_rumus['rumus_detail_nama'] ?>
                        <?php } ?>
                      <?php endforeach; ?>
                    </h3>
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
                <button type="button" id="close" class="btn btn-default" onclick="history.back()">Kembali</button>
                <button type="button" id="cetak_konsep" class="btn btn-primary">Cetak Preview</button>
                <?php if ($logsheet['logsheet_review'] == '') : ?>
                  <button type="button" id="setuju_raw" class="btn btn-success float-right">Setuju Raw Data</button>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </form>

        <?php if ($logsheet['logsheet_analisis'] != '' && $logsheet['logsheet_review'] != '') : ?>
          <!-- custom css for certificate  -->
          <center>
            <!-- custom css for certificate  -->
            <form id="form_sertifikat">
              <div id="area_cetak" class="area_cetak">
                <textarea name="custom_area" id="custom_area" class="custom_area">
                  <!-- area judul -->
                  <p>
                    <img src="https://storage.googleapis.com/pkg-portal-bucket/images/template/logo-PG-agro-trans-small.png" alt="" style="height: 60px;float:left;">
                    <span class="judul-header" " style="font-size: 1.5em;text-align: center;margin: 25mm;font-weight: bold;">
                      LABORATORIUM PENGUJI
                    </span>
                    <?php if ($logsheet['is_kan'] == 'y') : ?>
                      <img src="http://kan.or.id/images/kan.png" alt="" style="height: 50px;float:right;">
                    <?php endif ?>
                    <span style="padding-left: 48mm">
                      LP-076-IDN
                    </span>
                  </p>
                  <br>
                  <p style="padding-left: 15mm;font-size: 11pt;"> 
                    Gresik, <?php echo date_indo(date('Y-m-d')) ?>
                    <br>
                    Nomor :
                  </p>
                  <p style="text-align: center;">
                    <span id="header-judul" style="font-size: 1.5em;font-weight: bold;">
                      <u>LAPORAN HASIL UJI</u>
                    </span> 
                    <br>
                    <i>( Analysis Report )</i>
                  </p>
                  <!-- area judul -->


                  <!-- area identitas -->
                  <p style="padding-left: 60px;font-size: 11pt;">
                    <span><u>Nomor Lab</u></span>
                    <span style="padding-left: 40mm;padding-right: 2mm;">:</span>
                    <span><?php echo $inbox_detail[0]['transaksi_detail_nomor_sample'] ?></span>
                    <br>
                    <span style="font-size: 0.85em ;"><i>Lab Number</i></span>

                    <br>

                    <span><u>Jenis Contoh</u></span>
                    <span style="padding-left: 36.5mm;padding-right: 2mm;">:</span>
                    <span><?php echo $inbox_detail[0]['jenis_nama'] ?></span>
                    <br>
                    <span style="font-size: 0.85em ;"><i>Sample</i></span>

                    <br>

                    <span><u>Tgl. Penerima Contoh</u></span>
                    <span style="padding-left: 21.5mm;padding-right: 2mm;">:</span>
                    <span><?php echo date_indo(date('Y-m-d',strtotime($logsheet['logsheet_tgl_terima']))) ?></span>
                    <br>
                    <span style="font-size: 0.85em ;"><i>Sample Date</i></span>

                    <br>

                    <span><u>Tgl. Pengambilan</u></span>
                    <span style="padding-left: 29mm;padding-right: 2mm;">:</span>
                    <span><?php echo date_indo(date('Y-m-d',strtotime($logsheet['logsheet_tgl_uji']))) ?></span>
                    <br>
                    <span style="font-size: 0.85em ;"><i>Sample Date</i></span>
                    
                    <br>

                    <span><u>Tempat Pengambilan</u></span>
                    <span style="padding-left: 23mm;padding-right: 2mm;">:</span>
                    <span><?php echo $logsheet['logsheet_asal_sample'] ?></span>
                    <br>
                    <span style="font-size: 0.85em ;"><i>Sample Take</i></span>

                    <br>

                    <span><u>Pengambilan Contoh</u></span>
                    <span style="padding-left: 23mm;padding-right: 2mm;">:</span>
                    <span><?php echo $logsheet['logsheet_pengolah_sample']?></span>
                    <br>
                    <span style="font-size: 0.85em ;"><i>Sample Take By</i></span>

                    <br>

                    <span><u>Peminta</u></span>
                    <span style="padding-left: 45mm;padding-right: 2mm;">:</span>
                    <span><?php echo $logsheet['logsheet_peminta_jasa'] ?></span>
                    <br>
                    <span style="font-size: 0.85em ;"><i>Requested By</i></span>

                    <br>

                    <span><u>Referensi</u></span>
                    <span style="padding-left: 43mm;padding-right: 2mm;">:</span>
                    <span><?php echo $logsheet['logsheet_peminta_jasa'] ?></span>
                    <br>
                    <span style="font-size: 0.85em ;"><i>Reference</i></span>
                    <span style="padding-left: 49mm;"> <?=$logsheet['logsheet_nomor_permintaan']?> </span>

                  </p>
                  <!-- area identitas -->

                  <!-- area judul -->
                  <p style="text-align: center;">
                    <span id="header-judul" style="font-size: 1.5em;font-weight: bold;">
                      <u>HASIL PENGUJIAN</u>
                    </span> 
                    <br>
                    <!-- <i>( Analysis Report )</i> -->
                  </p>
                  <br>
                  <br>

                  <center>
                    <table class="MsoTableGrid" border="1" cellspacing="0" cellpadding="0" width="635" style="border-collapse: collapse; border: none; height: 51px;">
                      <!-- <table border="1"  width="85%" style="border-collapse: collapse;border:1px solid black"> -->
                        <thead>
                          <tr>
                            <th>
                              <u>
                                No
                              </u>
                              <br>
                              <i style="font-size: 0.85em;">No</i>
                            </th>
                            <th>
                              <u>Jenis Uji</u>
                              <br>
                              <i style="font-size: 0.85em;">Item of Analysis</i>
                            </th>
                            <th><u>Satuan</u>
                              <br>
                              <i style="font-size:0.85em">Unit</i></th>
                              <th><u>Hasil Uji</u>
                                <br>
                                <i style="font-size:0.85em">Analysis Result</i>
                              </th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            foreach ($detail_logsheet as $key => $value) :
                              $sql_konten = $this->db->query("SELECT * FROM sample.sample_logsheet a LEFT JOIN sample.sample_logsheet_detail b ON a.logsheet_id = b.logsheet_id LEFT JOIN sample.sample_perhitungan_sample c ON c.rumus_id = b.id_rumus WHERE id_transaksi = '" . $_GET['transaksi_id'] . "' AND a.logsheet_id = '" . $_GET['logsheet_id'] . "' AND b.id_rumus = '" . $value['rumus_id'] . "'");

                              $data_konten = $sql_konten->result_array();

                              $sql_avg = $this->db->query("SELECT DISTINCT logsheet_jenis_unit,rumus_avg,logsheet_metoda FROM sample.sample_logsheet a LEFT JOIN sample.sample_logsheet_detail b ON a.logsheet_id = b.logsheet_id LEFT JOIN sample.sample_perhitungan_sample c ON c.rumus_id = b.id_rumus WHERE id_transaksi = '" . $_GET['transaksi_id'] . "' AND a.logsheet_id = '" . $_GET['logsheet_id'] . "' AND b.id_rumus = '" . $value['rumus_id'] . "' AND rumus_avg is NOT NULL");

                              $data_avg = $sql_avg->result_array();

                              foreach ($data_konten as $key_konten => $value_konten) :
                                if ($value_konten['rumus_avg'] == '') :
                                  ?>
                                  <tr>
                                    <td><?=$key+1?></td>
                                    <td><?= $value['rumus_nama'] ?></td>
                                    <td><?= $value_konten['rumus_satuan'] ?></td>
                                    <td><?= $value_konten['rumus_hasil'] ?></td>
                                    <!-- <td><?= $value_konten['rumus_metoda'] ?></td> -->
                                  </tr>
                                  <?php
                                endif;
                              endforeach;
                              foreach ($data_avg as $key_avg => $value_avg) :
                                if ($value_konten['rumus_avg'] != '') :
                                  ?>
                                  <tr>
                                    <td><?=$key+1?></td>
                                    <td><?= $value['rumus_nama'] ?></td>
                                    <td><?= $value_avg['rumus_satuan'] ?></td>
                                    <td><?= $value_avg['rumus_avg'] ?></td>
                                    <!-- <td><?= $value_avg['rumus_metoda'] ?></td> -->
                                  </tr>

                                  <?php
                                endif;
                              endforeach;
                            endforeach;
                            ?>
                          </tbody>
                        </table>
                      </center>

                      <br>
                      <br>

                      <p style="padding-left: 15mm;font-size: 11pt;">
                        <span>PT Petrokimia Gresik</span>
                        <br>
                        <p style="height: 15mm;">

                        </p>
                        <span><u><b>
                          <?php 
                          $str = $inbox['nama_tujuan'];
                          $strx = (explode(",", $str));
                          echo $namaku = $strx[0];
                          ?>
                        </b></u></span>
                        <br>
                        <span style="font-size:12pt"><?= $inbox['title_tujuan'] ?></span>
                      </p>
                      <br>
                      <br>
                      <p>
                        <?php
                        if (!empty($logsheet['id_template_footer'])) {
                          $template_footer = explode(',', $logsheet['id_template_footer']);
                          foreach ($template_footer as $key_footer => $footer_template) {
                            $sql_footer = $this->db->query("SELECT * FROM sample.sample_footer_sertifikat WHERE footer_id = '" . $footer_template . "'");
                            $data_footer = $sql_footer->row_array();
                            ?>
                            <div style="text-align: right;padding-right: 10mm;" >
                              <i>
                                <?php echo $data_footer['footer_isi']; ?>

                              </i>
                            </div>
                            <?php
                          }
                        }
                        ?>
                      </p>
                      <br>
                      <p style="font-size: 9pt;">
                        Sesuai dengan ketentuan peraturan perundang-undangan yang berlaku, surat ini telah ditandatangani secara elektronik oleh Perum Peruri
                        yang tersertifikasi sebagai Penyelenggara Sertifikasi Elektronik (PSrE) sehingga tidak diperlukan tanda tangan dan stempel basah.
                      </p>
                      <br>

                      <footer>
                        <img src="<?= base_url() ?>/gambar/img/logo/logoFooterAlamat.png" style="width:-webkit-fill-available">
                      </footer>
                      <!-- area judul -->
                    </textarea>
                    <div class="no-print">
                      <div class="card-footer">
                        <button type="button" id="close" class="btn btn-default" onclick="history.back()" style="float:left;">Kembali</button>
                        <?php if ($logsheet['is_approve'] == '') { ?>
                          <button type="button" id="approve_kasie" class="btn btn-success float-right">Approve Kasie</button>
                        <?php } ?>
                        <?php if ($logsheet['is_approve'] == 'y') { ?>
                          <button type="button" id="send_dof_modal" class="btn btn-success float-right">Kirim DOF</button>
                        <?php } ?>
                      </div>
                    </div>
                  </form>
                </center>
              <?php endif; ?>

              <?php if ($logsheet['logsheet_analisis'] != '' && $logsheet['logsheet_review'] != '') : ?>
                        <!--   <div id="div_sertifikat">
                        <form id="form_sertifikat">
                        <div id="area_cetak" class="area_cetak">
                        <textarea name="custom_area" id="custom_area" class="custom_area">
                        <h2 style="text-align: center;"><u>CERTICATE OF ANALYSIS</u>
                        <?php if ($logsheet['is_kan'] == 'y') : ?>
                        <img src="<?= base_url() ?>assets_tambahan\ext_img\kan.png" alt="" style="height: 75px;float:right;">
                      <?php endif; ?>
                    </h2>
                    <p style="text-align: center;">No.</p>
                    <br>
                    <br>
                    <br>
                    <table border="0" width="100%" style="border-collapse: collapse;border:0px solid black">
                      <tr>
                        <td style="width: 300px;">
                          <input type="text" class="form-control" id="sertifikat_lab_no" name="sertifikat_lab_no" placeholder="Judul" value="<?= $inbox_detail[0]['transaksi_detail_nomor_sample'] ?>" style="display:none" readonly>Lab No.
                        </td>
                        <td>:</td>
                        <td>
                          <?= $inbox_detail[0]['transaksi_detail_nomor_sample'] ?>
                        </td>
                      </tr>

                      <tr>
                        <td>
                          <input type="text" class="form-control" id="sertifikat_material" name="sertifikat_material" placeholder="Judul" value="<?= $logsheet['logsheet_jenis_nama'] ?>" readonly style="display:none">Material
                        </td>
                        <td>:</td>
                        <td>
                          <?= $logsheet['logsheet_jenis_nama'] ?>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <input type="text" class="form-control" id="sertifikat_client" name="sertifikat_client" value="<?= $inbox['peminta_jasa_nama'] ?>" readonly style="display:none">
                          Client
                        </td>
                        <td>:</td>
                        <td>
                          <?= $inbox['peminta_jasa_nama'] ?>
                        </td>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <input type="text" class="form-control" id="sertifikat_client" name="sertifikat_client" value="<?= $inbox['peminta_jasa_nama'] ?>" readonly style="display:none">
                      </td>
                      <td>:</td>
                      <td>
                        <?= $logsheet['logsheet_nomor_permintaan'] ?>
                      </td>
                    </td>
                  </tr>

                  <tr>
                    <td>
                      <input type="text" class="form-control" id="sertifikat_material" name="sertifikat_material" placeholder="Judul" value="<?= $logsheet['logsheet_jenis_nama'] ?>" readonly style="display:none">Material
                    </td>
                    <td>:</td>
                    <td>
                      <?= $logsheet['logsheet_jenis_nama'] ?>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <input type="text" class="form-control" id="sertifikat_sample_code" name="sertifikat_sample_code" value="<?= $inbox_detail[0]['transaksi_detail_tgl_pengajuan'] ?>" readonly style="display:none">Sample Code
                    </td>
                    <td>:</td>
                    <td>
                      <?= bulan(date('m', strtotime($inbox_detail[0]['transaksi_detail_tgl_pengajuan']))) ?>, <?= date('Y', strtotime($inbox_detail[0]['transaksi_detail_tgl_pengajuan'])) ?>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <input type="text" class="form-control" id="sertifikat_remarks" name="sertifikat_remarks" value="<?= $inbox_detail[0]['transaksi_detail_catatan'] ?>" readonly style="display:none">Remarks
                    </td>
                    <td>:</td>
                    <td><?= $inbox_detail[0]['transaksi_detail_catatan'] ?></td>
                  </tr>
                  <tr>
                    <td>
                      <input type="text" class="form-control" id="sertifikat_shipment" name="sertifikat_shipment" value="<?= $inbox_detail[0]['transaksi_detail_catatan'] ?>" readonly style="display:none">Shipment No
                    </td>
                    <td>:</td>
                    <td>
                      <?= $inbox_detail[0]['transaksi_detail_catatan'] ?>
                    </td>
                  </tr>
                </table>
                <br>
                <br>
                <h4 style="text-align:center"><b>Result Of Testing</b></h4>
                <table border="1"  width="100%" style="border-collapse: collapse;border:1px solid black">
                  <thead class="text-center">
                    <tr>
                      <th>Kinds of Testing</th>
                      <th>Unit</th>
                      <th>Result</th>
                      <th>Test Method</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach ($detail_logsheet as $key => $value) :
                      $sql_konten = $this->db->query("SELECT * FROM sample.sample_logsheet a LEFT JOIN sample.sample_logsheet_detail b ON a.logsheet_id = b.logsheet_id LEFT JOIN sample.sample_perhitungan_sample c ON c.rumus_id = b.id_rumus WHERE id_transaksi = '" . $_GET['transaksi_id'] . "' AND a.logsheet_id = '" . $_GET['logsheet_id'] . "' AND b.id_rumus = '" . $value['rumus_id'] . "'");

                      $data_konten = $sql_konten->result_array();

                      $sql_avg = $this->db->query("SELECT DISTINCT logsheet_jenis_unit,rumus_avg,logsheet_metoda FROM sample.sample_logsheet a LEFT JOIN sample.sample_logsheet_detail b ON a.logsheet_id = b.logsheet_id LEFT JOIN sample.sample_perhitungan_sample c ON c.rumus_id = b.id_rumus WHERE id_transaksi = '" . $_GET['transaksi_id'] . "' AND a.logsheet_id = '" . $_GET['logsheet_id'] . "' AND b.id_rumus = '" . $value['rumus_id'] . "' AND rumus_avg is NOT NULL");

                      $data_avg = $sql_avg->result_array();

                      foreach ($data_konten as $key_konten => $value_konten) :
                        if ($value_konten['rumus_avg'] == '') :
                          ?>
                          <tr>
                            <td><?= $value['rumus_nama'] ?></td>
                            <td><?= $value_konten['rumus_satuan'] ?></td>
                            <td><?= $value_konten['rumus_hasil'] ?></td>
                            <td><?= $value_konten['rumus_metoda'] ?></td>
                          </tr>
                          <?php
                        endif;
                      endforeach;
                      foreach ($data_avg as $key_avg => $value_avg) :
                        if ($value_konten['rumus_avg'] != '') :
                          ?>
                          <tr>
                            <td><?= $value['rumus_nama'] ?></td>
                            <td><?= $value_avg['rumus_satuan'] ?></td>
                            <td><?= $value_avg['rumus_avg'] ?></td>
                            <td><?= $value_avg['rumus_metoda'] ?></td>
                          </tr>

                          <?php
                        endif;
                      endforeach;
                    endforeach;
                    ?>
                  </tbody>
                </table>
                <br>
                <br>
                <table border="0" style="border-collapse: collapse;border:0px solid black" width="50%">
                  <tr>
                    <td><input type="text" class="form-control" id="sertifikat_date_issue" name="sertifikat_date_issue" placeholder="Judul" value="<?= $logsheet['logsheet_review_date'] ?>" style="display:none" readonly>Date of issue</td>
                    <td>:</td>
                    <td><?= $logsheet['logsheet_review_date'] ?></td>
                  </tr>
                </table>
                <br>
                <br>
                <table border="0" style="border-collapse: collapse;border:0px solid black" width="50%">
                  <tr>
                    <td>PT Petrokimia Gresik</td>
                  </tr>
                  <tr>
                    <td height="70px"></td>
                  </tr>
                  <tr>
                    <td>
                      <u><b><?= $inbox['nama_tujuan'] ?></b></u>
                      <br>
                      <?= $inbox['title_tujuan'] ?>
                    </td>
                  </tr>
                </table>
                <br>
                <br>
                <?php
                if (!empty($logsheet['id_template_footer'])) {
                  $template_footer = explode(',', $logsheet['id_template_footer']);
                  foreach ($template_footer as $key_footer => $footer_template) {
                    $sql_footer = $this->db->query("SELECT * FROM sample.sample_footer_sertifikat WHERE footer_id = '" . $footer_template . "'");
                    $data_footer = $sql_footer->row_array();
                    ?>
                    <div class="text-center" style="text-align: center;">
                      <?php echo $data_footer['footer_isi']; ?>
                    </div>
                    <?php
                  }
                }
                ?>
              </textarea>
              <div class="no-print">
                <div class="card-footer">
                  <button type="button" id="close" class="btn btn-default" onclick="history.back()">Kembali</button>
                  <?php if ($logsheet['is_approve'] == '') { ?>
                    <button type="button" id="approve_kasie" class="btn btn-success float-right">Approve Kasie</button>
                  <?php } ?>
                  <?php if ($logsheet['is_approve'] == 'y') { ?>
                    <button type="button" id="send_dof_modal" class="btn btn-success float-right">Kirim DOF</button>
                  <?php } ?>
                </div>

              </div>
            </div>
          </div>
        </form>
      </div> -->
    <?php endif; ?>



  </div>
  <!-- modal -->
</div>
</div>
<!-- modal template -->
<div id="modal_template" class="modal fade" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Template</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <form id="form_template">
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <div class="form-group row col-md-12">
                <label class="col-md-4">is KAN</label>
                <div class="input-group col-md-8">
                  <input type="checkbox" name="is_kan" id="is_kan" class="form-control-checkbox" value="y">
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group row col-md-12">
                <label class="col-md-4">Bilingual</label>
                <div class="input-group col-md-8">
                  <select name="bahasa" id="bahasa" class="select2 form-control" onchange="func_ganti_bahasa(this.value)">
                    <option value="">-Pilih-</option>
                    <option value="I">Indonesia</option>
                    <option value="E">Inggris</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group row col-md-12">
                <label class="col-md-4">Template Footer</label>
                <div class="input-group col-md-8">
                  <select name="id_template_footer[]" id="id_template_footer" class="form-control select2" style="width:100%" multiple>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" id="setuju">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- modal template -->
<!-- modal send dof -->
<div id="modal_send_dof" class="modal fade" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Data Dokumen DOF</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <form id="form_send_dof">
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <div class="form-group row col-md-12">
                <label class="col-md-4">Tipe Dokumen</label>
                <div class="input-group col-md-8">
                  <select name="typeId" id="typeId" class="form-control select2" onChange="func_change_template(this.value)"></select>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group row col-md-12">
                <label class="col-md-4">Template Dokumen</label>
                <div class="input-group col-md-8">
                  <select name="templateId" id="templateId" class="form-control select2"></select>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group row col-md-12">
                <label class="col-md-4">Klasifikasi Dokumen</label>
                <div class="input-group col-md-8">
                  <input type="text" name="classId" id="classId" class="form-control" readonly style="display:none">
                  <input type="text" name="className" id="className" class="form-control" readonly>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group row col-md-12">
                <label class="col-md-4">Sifat Dokumen</label>
                <div class="input-group col-md-8">
                  <input type="text" name="category" id="category" class="form-control" readonly>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group row col-md-12">
                <label class="col-md-4">Kecepatan Tanggap</label>
                <div class="input-group col-md-8">
                  <input type="text" name="responseSpeed" id="responseSpeed" class="form-control" readonly>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group row col-md-12">
                <label class="col-md-4">Judul</label>
                <div class="input-group col-md-8">
                  <input type="text" name="title" id="title" class="form-control" readonly>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group row col-md-12">
                <label class="col-md-4">Drafter</label>
                <div class="input-group col-md-8">
                  <input type="text" name="drafterId" id="drafterId" class="form-control" readonly style="display:none">
                  <input type="text" name="drafterName" id="drafterName" class="form-control" readonly>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group row col-md-12">
                <label class="col-md-4">Reviewer</label>
                <div class="input-group col-md-8">
                  <input type="text" name="reviewerId[]" id="reviewerId" class="form-control" readonly style="display:none">
                  <input type="text" name="reviewerName" id="reviewerName" class="form-control" readonly>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group row col-md-12">
                <label class="col-md-4">Approver</label>
                <div class="input-group col-md-8">
                  <input type="text" name="approverId" id="approverId" class="form-control" readonly style="display:none">
                  <input type="text" name="approverName" id="approverName" class="form-control" readonly>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group row col-md-12">
                <label class="col-md-4">Tujuan</label>
                <div class="input-group col-md-8">
                  <input type="text" name="tujuanId[]" id="tujuanId" class="form-control" readonly style="display:none">
                  <input type="text" name="tujuanName" id="tujuanName" class="form-control" readonly>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close_send_dof" onClick="func_close_send_dof()">Cancel</button>
          <button type="button" class="btn btn-primary" id="send_dof_new">Simpan</button>
          <button class="btn btn-primary" type="button" id="loading_send_dof" disabled style="display: none;">
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            Loading...
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- modal send dof -->
</section>
<!-- Container Body -->
</div>
<!-- CONTAINER-->