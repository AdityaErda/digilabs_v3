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
              <?php
              $nomor_sample = '';
              $jenis_nama = '';
              foreach ($inbox_detail as $key_header => $detail_header) :

                $nomor_sample .= $detail_header['transaksi_detail_nomor_sample'] . ', ';
                $jenis_nama .= $detail_header['jenis_nama'] . ', ';
              ?>
                <input type="text" id="is_new" name="is_new" style="display:none">
                <input type="text" id="transaksi_id" name="transaksi_id" style="display: none;" value="<?= $inbox['transaksi_id'] ?>">
                <input type="text" id="transaksi_status" name="transaksi_status" style="display:none" value="<?= $inbox['transaksi_status'] ?>">
                <input type="text" id="transaksi_non_rutin_id" name="transaksi_non_rutin_id" style="display:none" value="<?= $inbox['transaksi_non_rutin_id'] ?>">
                <input type="text" id="transaksi_drafter_detault" name="transaksi_drafter_default" value="<?= $inbox['transaksi_drafter'] ?>" style="display:none">
                <input type="text" id="transaksi_detail_status" name="transaksi_detail_status[]" style="display:none" value="<?= $detail_header['transaksi_detail_status'] ?>">
                <input type="text" id="template_logsheet_id" name="template_logsheet_id[]" style="display:none" value="<?= $_GET['template_logsheet_id'][$key_header] ?>">

                <input type="text" id="transaksi_detail_id_temp" name="transaksi_detail_id_temp[]" value="<?= $detail_header['transaksi_detail_id'] ?>" style="display: none;">
                <input type="text" id="transaksi_detail_id" name="transaksi_detail_id[]" value="<?= create_id(); ?>" style="display: none;">
                <input type="text" class="form-control" id="logsheet_nomor_sample" name="logsheet_nomor_sample[]" placeholder="Judul" value="<?= $detail_header['transaksi_detail_nomor_sample']; ?>" style="display:none">
                <input type="text" class="form-control" id="logsheet_jenis" name="logsheet_jenis[]" placeholder="Judul" value="<?= $detail_header['jenis_nama'] ?>" style="display:none">
              <?php endforeach; ?>
              <textarea1 name="custom_raw_eksekutor1" class="custom_raw_eksekutor1" id="custom_raw_eksekutor1">
                <div class="card-body row">
                  <?php foreach ($logsheet as $key_logsheet => $data_logsheet) :  ?>
                    <input type="text" id="logsheet_id" name="logsheet_id[]" value="<?= $data_logsheet['logsheet_id'] ?>" style="display:none">
                  <?php endforeach; ?>
                  <!-- Kiri -->
                  <div class="col-12">
                    <div class="row">
                      <div class="col-6">
                        <h4 class="text-center">LEMBAR KERJA <?= strtoupper($jenis_nama) ?></h4>
                      </div>
                      <div class="col-6">
                        <table style="border-collapse:collapse;border:1px solid black;float:right" width="100%" cellpadding="2" cellspacing="2">
                          <tr>
                            <td width="45%">No Dokumen</td>
                            <td>:</td>
                            <td><?= $nomor_sample ?></td>
                          </tr>
                          <tr>
                            <td>Terbitan / Revisi</td>
                            <td>:</td>
                            <td></td>
                          </tr>
                          <tr>
                            <td>Tanggal Pengesahan</td>
                            <td>:</td>
                            <td><?= ($data_logsheet['logsheet_review_date'] != '') ? date_indo(date('Y-m-d', strtotime($data_logsheet['logsheet_review_date']))) : '-' ?></td>
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
                            <input type="text" class="form-control" id="logsheet_jenis_nama" name="logsheet_jenis_nama" placeholder="Judul" value="<?= $jenis_nama ?>" style="display:none" readonly>
                            <label for="" class="">:&nbsp;<?= $jenis_nama ?></label>
                          </div>
                        </div>
                        <div class="form-group row col-12">
                          <label class="col-md-4">Tanda</label>
                          <div class="input-group col-md-8">
                            <input type="text" class="form-control" id="logsheet_nomor_permintaan" name="logsheet_nomor_permintaan" placeholder="Judul" value="<?= $data_logsheet['logsheet_nomor_permintaan'] ?>" readonly style="display:none">
                            <label for="" class="">:&nbsp;<?= $data_logsheet['logsheet_nomor_permintaan'] ?></label>
                          </div>
                        </div>
                        <div class="form-group row col-12">
                          <label class="col-md-4">Catatan</label>
                          <div class="input-group col-md-8">
                            <input type="text" class="form-control" id="logsheet_deskripsi" name="logsheet_deskripsi" value="<?= $data_logsheet['logsheet_deskripsi'] ?>" readonly style="display:none">
                            <label for="">:&nbsp;<?= $data_logsheet['logsheet_deskripsi'] ?></label>
                          </div>
                        </div>
                        <div class="form-group row col-12">
                          <label class="col-md-4">Sertifikat</label>
                          <div class="input-group col-md-8">
                            <input type="text" class="form-control" id="transaksi_detail_nomor" name="transaksi_detail_nomor" value="<?= $data_logsheet['logsheet_nomor_permintaan'] ?>" readonly style="display:none">
                            <label for="">:&nbsp;<?= $data_logsheet['logsheet_nomor_permintaan'] ?></label>
                          </div>
                        </div>
                        <div class="form-group row col-12">
                          <label class="col-md-4">Area</label>
                          <div class="input-group col-md-8">
                            <input type="text" class="form-control" id="logsheet_area" name="logsheet_area" value="<?= $data_logsheet['logsheet_nomor_permintaan'] ?>" readonly style="display:none">
                            <label for=""> : &nbsp;<?= $data_logsheet['logsheet_nomor_permintaan'] ?></label>
                          </div>
                        </div>
                      </div>
                      <div class="col-6">

                        <div class="form-group row col-12">
                          <label class="col-md-4">No. Lab</label>
                          <div class="input-group col-md-8">
                            <input type="text" class="form-control" id="transaksi_detail_nomor_sample" name="transaksi_detail_nomor_sample" value="<?= $nomor_sample ?>" readonly style="display:none">
                            <label for="">:&nbsp;<?= $nomor_sample ?></label>
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
                              <input type="text" class="form-control float-right tanggal" id="logsheet_tgl_sampling" name="logsheet_tgl_sampling" value="<?= date('d-m-Y', strtotime($data_logsheet['logsheet_tgl_sampling'])) ?>" readonly style="display:none">
                              <label for="">:&nbsp;<?= date_indo('Y-m-d', strtotime($data_logsheet['logsheet_tgl_sampling'])) ?></label>
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
                            <input type="text" class="form-control float-right tanggal" id="logsheet_tgl_terima" name="logsheet_tgl_terima" value="<?= date('d-m-Y', strtotime($data_logsheet['logsheet_tgl_terima'])) ?>" readonly style="display:none">
                            <label for="">:&nbsp;<?= date_indo('Y-m-d', strtotime($data_logsheet['logsheet_tgl_terima'])) ?></label>
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
                            <input type="text" class="form-control float-right tanggal" id="logsheet_tgl_uji" name="logsheet_tgl_uji" value="<?= date('d-m-Y', strtotime($data_logsheet['logsheet_tgl_uji'])) ?>" readonly style="display: none;">
                            <label for="">:&nbsp;<?= date_indo('Y-m-d', strtotime($data_logsheet['logsheet_tgl_uji'])) ?></label>
                          </div>
                        </div>

                        <div class="form-group row col-12">
                          <label class="col-md-4">Analisis</label>
                          <div class="input-group col-md-8">
                            <input type="text" class="form-control" id="logsheet_analisis" name="logsheet_analisis" value="<?= $data_logsheet['nama_analisis'] ?>" readonly style="display:none">
                            <label for="">:&nbsp;<?= ($data_logsheet['nama_analisis'] != '') ? $data_logsheet['nama_analisis'] : $session['user_nama'] ?></label>
                          </div>
                        </div>

                      </div>
                    </div>
                  </div>
                </div>

                <div class="card-body">
                  <!-- <table  width="100%" border="1"> -->
                  <table width="100%" border="1" class1="table table-striped table-bordered nowrap table_rumus" cellspacing="0" cellpadding="0" id="table_rumus1">
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
                      foreach ($multi_detail_hasil as $key_log => $multi_log) :
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
                          <td class="kolom_header text-center">
                            <input type="text" name="rumus_id[<?= $multi_log['transaksi_detail_id'] ?>][]" id="rumus_id_<?= $key_log ?>" value="<?= $multi_log['rumus_id'] ?>" style="display: none;">
                            <?php
                            if ($multi_log['rumus_id'] != '') :
                              $param_detail['id_rumus'] = $multi_log['rumus_id'];
                              $data_detail_rumus = $this->db->query("SELECT * FROM sample.sample_logsheet_detail_detail WHERE id_rumus = '" . $multi_log['rumus_id'] . "'")->result_array();
                              // echo $this->db->last_query();
                              $ada_sample = '';
                            ?>
                              <?php foreach ($data_detail_rumus as $key_detail_rumus => $detail_rumus_log) : ?>
                                <?php $ada_sample = $detail_rumus_log['rumus_detail_id']; ?>
                                <?= $detail_rumus_log['rumus_detail_isi'] ?>
                                <!-- <input type="text" class="" value="<?= $detail_rumus_log['rumus_detail_isi'] ?>"> -->
                              <?php endforeach; ?>
                            <?php endif; ?>
                          </td>
                          <!-- kolom rumus -->
                          <!-- kolom hasil -->
                          <td class="kolom_header">
                            <?php echo $multi_log['rumus_hasil'] ?>
                          </td>
                          <!-- kolom hasil -->
                          <!-- kolom checklist -->
                          <td class=" kolom_header">
                            <?php echo $multi_log['logsheet_checklist'] ?>
                          </td>
                          <!-- kolom checklist -->
                          <!-- kolom batasan -->
                          <td class="kolom_header">
                            <?php echo $multi_log['logsheet_batasan'] ?>
                          </td>
                          <!-- kolom batasan -->
                          <!-- kolom kesimpulan -->
                          <td class="kolom_header">
                            <?php echo $multi_log['logsheet_kesimpulan'] ?>
                          </td>
                          <!-- kolom kesimpulan -->
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
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
                            <?php if ($data_logsheet['logsheet_analisis'] != '') : ?>
                              <img src="<?= base_url('img/' . $data_logsheet['logsheet_analisis_qr']) ?>" style="max-width:4cm;max-height:4cm">
                            <?php endif; ?>
                          </th>
                          <th>
                            <?php if ($data_logsheet['logsheet_review'] != '') : ?>
                              <img src="<?= base_url('img/' . $data_logsheet['logsheet_review_qr']) ?>" style="max-width:4cm;max-height:4cm">
                            <?php endif; ?>
                          </th>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </textarea1>
              <!-- Memorandum -->
              <div class="no-print">
                <div class="card-footer">
                  <button type="button" id="close" class="btn btn-default" onclick="history.back()">Kembali</button>
                  <button type="button" id="cetak_konsep" class="btn btn-primary">Cetak Preview</button>
                  <?php if ($data_logsheet['logsheet_review'] == '') : ?>
                    <!-- <button type="button" id="reject" class="btn btn-danger">Reject Raw Data</button> -->
                    <button type="button" id="setuju" class="btn btn-success float-right">Setuju Raw Data</button>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </form>

          <?php if ($data_logsheet['logsheet_review'] != '') : ?>
            <div id="div_sertifikat">
              <form id="form_sertifikat">
                <!-- FILTER -->
                <!-- Memorandum -->
                <div id="area_cetak" class="area_cetak">
                  <div class="card">
                    <textarea1 name="custom_area1" id="custom_area1" class="custom_area1">
                      <div class="card-body row">
                        <!-- Kiri -->
                        <div class="col-12">
                          <div class="row">
                            <div class="col-12">
                              <h2 class="text-center"><u>CERTICATE OF ANALYSIS</u></h2>
                              <p class="text-center">No.</p>
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
                          <!-- <div class="row justify-content-md-center"> -->
                          <div class="form-group row col-12">
                            <span class="col-md-4">Lab No.</span>
                            <div class="input-group col-md-8">
                              <input type="text" class="form-control" id="sertifikat_lab_no" name="sertifikat_lab_no" placeholder="Judul" value="<?= $inbox_detail[0]['transaksi_detail_nomor_sample'] ?>" style="display:none" readonly>
                              <span for="" class=""> : &nbsp;<?= $inbox_detail[0]['transaksi_detail_nomor_sample'] ?></span>
                            </div>
                          </div>
                          <div class="form-group row col-12">
                            <span class="col-md-4">Material</span>
                            <div class="input-group col-md-8">
                              <input type="text" class="form-control" id="sertifikat_material" name="sertifikat_material" placeholder="Judul" value="<?= strtoupper($jenis_nama) ?>" readonly style="display:none">
                              <span for="" class=""> : &nbsp;<?= strtoupper($jenis_nama) ?></span>
                            </div>
                          </div>
                          <div class="form-group row col-12">
                            <span class="col-md-4">Client</span>
                            <div class="input-group col-md-8">
                              <input type="text" class="form-control" id="sertifikat_client" name="sertifikat_client" value="<?= $inbox['peminta_jasa_nama'] ?>" readonly style="display:none">
                              <span for=""> : &nbsp;<?= $inbox['peminta_jasa_nama'] ?></span>
                            </div>
                          </div>
                          <div class="form-group row col-12">
                            <span class="col-md-4"></span>
                            <div class="input-group col-md-8">
                              <span for=""> &nbsp;&nbsp;&nbsp;<?= $data_logsheet['logsheet_nomor_permintaan'] ?></span>
                            </div>
                          </div>

                          <div class="form-group row col-12">
                            <span class="col-md-4">Sample Code</span>
                            <div class="input-group col-md-8">
                              <input type="text" class="form-control" id="sertifikat_sample_code" name="sertifikat_sample_code" value="<?= $inbox_detail[0]['transaksi_detail_tgl_pengajuan'] ?>" readonly style="display:none">
                              <span for=""> : &nbsp;<?= bulan(date('m', strtotime($inbox_detail[0]['transaksi_detail_tgl_pengajuan']))) ?>, <?= date('Y', strtotime($inbox_detail[0]['transaksi_detail_tgl_pengajuan'])) ?> </span>
                            </div>
                          </div>
                          <div class="form-group row col-12">
                            <span class="col-md-4">Remarks</span>
                            <div class="input-group col-md-8">
                              <input type="text" class="form-control" id="sertifikat_remarks" name="sertifikat_remarks" value="<?= $inbox_detail[0]['transaksi_detail_catatan'] ?>" readonly style="display:none">
                              <span for=""> : &nbsp;<?= $inbox_detail[0]['transaksi_detail_catatan'] ?></span>
                            </div>
                          </div>
                          <div class="form-group row col-12">
                            <span class="col-md-4">Shipment No</span>
                            <div class="input-group col-md-8">
                              <input type="text" class="form-control" id="sertifikat_shipment" name="sertifikat_shipment" value="<?= $inbox_detail[0]['transaksi_detail_catatan'] ?>" readonly style="display:none">
                              <span for=""> : &nbsp;<?= $inbox_detail[0]['transaksi_detail_catatan'] ?></span>
                            </div>
                            <!-- </div> -->
                          </div>
                        </div>


                        <div class="col-12">
                          <!-- <div class="card-header"> -->
                          <h4 class="text-center col-12" style="text-align:center"><b>Result Of Testing</b></h4>
                          <!-- </div> -->
                          <table border="1" class="table datatables table-bordered" width="100%">
                            <thead class="text-center">
                              <tr>
                                <th>Kinds of Testing</th>
                                <th>Unit</th>
                                <th>Result</th>
                                <th>Test Method</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php foreach ($multi_detail_hasil as $key_log => $multi_log) : ?>
                                <tr>
                                  <td><?php echo $multi_log['rumus_nama'] ?></td>
                                  <td><?php echo $multi_log['rumus_satuan'] ?></td>
                                  <td><?php echo $multi_log['rumus_hasil'] ?></td>
                                  <td><?php echo $multi_log['logsheet_metoda'] ?></td>
                                </tr>
                              <?php endforeach; ?>
                            </tbody>
                          </table>
                          <div class="mt-5">
                            <div class="form-group row col-12">
                              <span class="col-md-3">Date of issue&nbsp; : &nbsp;</span>
                              <div class="input-group col-md-8">
                                <input type="text" class="form-control" id="sertifikat_date_issue" name="sertifikat_date_issue" placeholder="Judul" value="<?= $data_logsheet['logsheet_review_date'] ?>" style="display:none" readonly>
                                <span for="" class=""><?= $data_logsheet['logsheet_review_date'] ?></span>
                              </div>
                            </div>

                            <div class="form-group row col-12">
                              <span class="col-md-4">PT Petrokimia Gresik</span>
                            </div>
                            <br>
                            <br>
                            <br>
                            <br>
                            <div class="form-group row col-12 mt-5">
                              <span class="col-md-4">
                                <span class="font-weight-bold"><u><?= $inbox['nama_tujuan'] ?></u></span>
                                <br>
                                <span><?= $inbox['title_tujuan'] ?></span>
                              </span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </textarea1>
                    <!-- Memorandum -->
                    <div class="no-print">
                      <div class="card-footer">
                        <button type="button" id="close" class="btn btn-default" onclick="history.back()">Kembali</button>
                        <?php if ($data_logsheet['is_approve'] == '') { ?>
                          <button type="button" id="approve_kasie" class="btn btn-success float-right">Approve Kasie</button>
                        <?php } ?>
                        <?php if ($data_logsheet['is_approve'] == 'y') { ?>
                          <button type="button" id="send_dof" class="btn btn-success float-right">Kirim DOF</button>
                        <?php } ?>
                      </div>
                    </div>
                  </div>
              </form>
            </div>
          <?php endif; ?>
        </div>
        <!-- modal -->
      </div>
    </div>
</div>
</section>
<!-- Container Body -->
</div>
<!-- CONTAINER-->