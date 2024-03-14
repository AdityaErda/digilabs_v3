<script src="https://unpkg.com/mathjs/lib/browser/math.js"></script>
<link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet">
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>

<style type="text/css">
  .modal-content {
    overflow: scroll !important;
  }
</style>

<?php
$session = $this->session->userdata();
$vp_ppk = $this->db->query("SELECT * FROM global.global_api_user WHERE user_poscode = 'E44000000'")->row_array();
$logsheet = $this->db->query("SELECT * FROM sample.sample_logsheet WHERE id_transaksi_detail = '" . $this->input->get_post('transaksi_detail_id') . "' AND logsheet_id = '" . $this->input->get('logsheet_id') . "'")->row_array();
$logsheet_detail_group = $this->db->query("SELECT DISTINCT(rumus_metoda,rumus_avg,rumus_satuan) FROM sample.sample_logsheet_detail WHERE logsheet_id = '" . $logsheet['logsheet_id'] . "'")->result_array();
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
            <!-- Lembar Kerja -->
            <div class="card">
              <!-- Header -->
              <div class="card-header bg-primary">
                <h3 class="card-title">
                  <center> Lembar Kerja <?php echo $inbox['transaksi_nomor'] ?> </center>
                </h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
              </div>
              <!-- Header -->
              <!-- Body -->
              <div class="card-body row">
                <input type="text" id="is_new" name="is_new" style="display:none">
                <input type="text" id="transaksi_tipe" name="transaksi_tipe" style="display:none" value="<?= $inbox['transaksi_tipe'] ?>">
                <input type="text" id="transaksi_status" name="transaksi_status" style="display:none" value="<?= $inbox['transaksi_status'] ?>">
                <input type="text" id="transaksi_detail_status" name="transaksi_detail_status" style="display:none" value="<?= $_GET['transaksi_detail_status'] ?>">
                <input type="text" id="transaksi_non_rutin_id" name="transaksi_non_rutin_id" style="display:none" value="<?= $_GET['transaksi_non_rutin_id'] ?>">
                <input type="text" id="transaksi_id" name="transaksi_id" style="display: none;" value="<?= $_GET['transaksi_id'] ?>">
                <input type="text" id="template_logsheet_id" name="template_logsheet_id" style="display:none" value="<?= $_GET['template_logsheet_id'] ?>">
                <input type="text" id="logsheet_id" name="logsheet_id" value="<?= $logsheet['logsheet_id'] ?>" style="display:none">
                <input type="text" id="transaksi_detail_id_temp" name="transaksi_detail_id_temp" value="<?= $_GET['transaksi_detail_id'] ?>" style="display: none;">
                <input type="text" id="transaksi_detail_id" name="transaksi_detail_id" value="<?= create_id(); ?>" style="display: none;">
                <input type="text" id="transaksi_drafter_detault" name="transaksi_drafter_default" value="<?= $inbox['transaksi_drafter'] ?>" style="display:none">
                <div class="col-12">
                  <div class="row">
                    <!-- Kiri -->
                    <div class="col-6">
                      <div class="form-group row col-12">
                        <label class="col-md-4">Nomor Sample</label>
                        <div class="input-group col-md-8">
                          <input type="text" class="form-control" id="logsheet_nomor_sample" name="logsheet_nomor_sample" placeholder="Judul" value="<?= $inbox_detail[0]['transaksi_detail_nomor_sample'] ?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row col-12">
                        <label class="col-md-4">Jenis Sample</label>
                        <div class="input-group col-md-8">
                          <input type="text" class="form-control" id="logsheet_jenis" name="logsheet_jenis" placeholder="Judul" value="<?= $inbox_detail[0]['jenis_nama'] ?>" readonly>
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
                      <div class="form-group row col-12">
                        <label class="col-md-4">File Excel</label>
                        <div class="input-group col-md-8">
                          <a href="<?= base_url('dokumen_logsheet/' . $logsheet['logsheet_file_excel']) ?>">Download</a>
                        </div>
                      </div>
                    </div>
                    <!-- Kiri -->
                    <!-- Kanan -->
                    <div class="col-6">
                      <?php if ($inbox_detail[0]['is_sampling'] == 'y') { ?>
                        <div class="form-group row col-12">
                          <label class="col-md-4">Tanggal Sampling</label>
                          <div class="input-group col-md-8">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                            </div>
                            <input type="text" class="form-control float-right tanggal" id="logsheet_tgl_sampling" name="logsheet_tgl_sampling">
                          </div>
                        </div>
                      <?php } ?>
                      <div class="form-group row col-12">
                        <label class="col-md-4">Tanggal Terima</label>
                        <div class="input-group col-md-8">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                          </div>
                          <input type="text" class="form-control float-right tanggal" id="logsheet_tgl_terima" name="logsheet_tgl_terima">
                        </div>
                      </div>
                      <div class="form-group row col-12">
                        <label class="col-md-4">Tanggal Pengujian</label>
                        <div class="input-group col-md-8">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
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
                        <label class="col-md-4">Pengambil Sample Oleh</label>
                        <div class="input-group col-md-8">
                          <select name="logsheet_pengolah_sample" id="logsheet_pengolah_sample_list" class="form-control select2 logsheet_pengolah_sample_list">
                            <?php foreach ($pengambil_sample as $key => $pengambil) : ?>
                              <option value="<?= $pengambil['pengambil_sample'] ?>" <?php if ($pengambil['pengambil_sample'] == $inbox_detail[0]['pengambil_sample']) echo 'selected' ?>><?= $pengambil['pengambil_sample'] ?></option>
                            <?php endforeach; ?>
                            <option value="9999">Lainnya....</option>
                          </select>
                          <input type="text" class="form-control logsheet_pengolah_sample_input mt-3 col-10" id="logsheet_pengolah_sample_input" name="logsheet_pengolah_sample" placeholder="Pengambil Sample Oleh" value="" style="display: none;" disabled>
                          <button type="button" class="btn btn-danger form-control col-2 mt-3 logsheet_pengolah_sample_input_cancel" name="input_cancel" id="input_cancel" onClick="pengolah_input_cancel(`<?= $inbox_detail[0]['pengambil_sample'] ?>`)" style="display:none;"><i class="fa fa-times"></i></button>
                        </div>
                      </div>
                    </div>
                    <!-- Kanan -->
                  </div>
                </div>
              </div>
              <!-- Body -->
            </div>
            <!-- Lembar Kerja -->

            <!-- Detail Sample -->
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
                  <div class="div_log_baru">
                    <div class="row">
                      <div class="col-6">
                        <div class="form-group row col-12">
                          <label class="col-md-4">Jenis Uji</label>
                          <div class="input-group col-md-8">
                            <input type="text" class="form-control" id="log_jenis_nama" name="log_jenis_nama" placeholder="Jenis Uji" value="<?= $inbox_detail[0]['jenis_nama'] ?>" readonly>
                          </div>
                        </div>
                        <!-- <div class="form-group row col-12">
                          <label class="col-md-4">Satuan</label>
                          <div class="input-group col-md-8">
                            <input type="text" class="form-control" id="log_metoda" name="log_metoda" placeholder="Satuan">
                          </div>
                        </div> -->
                      </div>
                      <div class="col-6">
                        <!-- <div class="form-group row col-12">
                          <label class="col-md-4">Metoda</label>
                          <div class="input-group col-md-8">
                            <input type="text" class="form-control" id="log_metoda" name="log_metoda" placeholder="Metoda">
                          </div>
                        </div> -->
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
                    <div class="row" id="div_rumus"></div>
                    <!-- Rumus -->
                    <hr>
                  </div>
                </div>
              </div>
              <!-- Body -->
              <!-- Footer -->
              <div class="card-footer">
                <button type="button" id="close" class="col-2 btn btn-default border-dark" onclick="kembali_inbox()">Kembali</button>
                <button type="button" id="draft" class="col-2 btn btn-warning">Draft</button>
                <button type="button" id="reupload" class="col-2 btn btn-info">Upload Ulang</button>
                <button type="button" id="simpan" class="col-2 btn btn-success float-right">Olah Data</button>
              </div>
              <!-- Footer -->
            </div>
            <!-- Detail Sample -->
          </form>
        </div>
      </div>
    </div>
  </section>
  <!-- Container Body -->
</div>
<!-- CONTAINER-->