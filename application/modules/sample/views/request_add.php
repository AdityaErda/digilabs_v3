<style type="text/css">
  .modal-content {
    overflow: scroll !important;
  }
</style>
<?php
$session = $this->session->userdata();
$atasan = $this->db->query("SELECT * FROM global.global_api_user WHERE user_poscode = '" . $session['user_direct_superior'] . "'")->row_array();

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
          <form id="form_request">
            <!-- Detail Surat -->
            <div class="card">
              <div class="card-header bg-primary">
                <h3 class="card-title">Detail Surat</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body row">
                <input type="text" name="pegawai_jabatan" id="pegawai_jabatan" value="<?= substr($session['user_job_id'], 0, 1) ?>" style="display:none;">
                <input type="text" name="jabatan_atasan" id="jabatan_atasan" value="<?= (!isset($atasan)) ? '' : substr($atasan['user_job_id'], 0, 1) ?>" style="display:none;">
                <input type="text" name="direct_superior_atasan" id="direct_superior_atasan" value="<?= (!isset($atasan)) ? '' : $atasan['user_direct_superior'] ?>" style="display:none;">
                <input type="text" id="is_new" name="is_new" style="display:none">
                <input type="text" id="transaksi_non_rutin_id" name="transaksi_non_rutin_id" style="display:none" value="<?= create_id() ?>">
                <input type="text" id="transaksi_id" name="transaksi_id" style="display: none;" value="<?= create_id() ?>">
                <input type="text" id="transaksi_tipe" name="transaksi_tipe" value="" style="display: none">
                <div class="col-12">
                  <div class="row">
                    <!-- Kiri -->
                    <div class="col-6">
                      <div class="form-group row col-12">
                        <label class="col-md-4">Judul</label>
                        <div class="col-md-8">
                          <input type="text" class="form-control required" id="transaksi_judul" name="transaksi_judul" placeholder="Judul">
                          <span id="alert_judul" class="text-danger" style="display:none">Judul Harus Diisi</span>
                          <!-- <input type="text" class="form-control-plaintext text-danger" value="Judul Harus Diisi" id="alert_judul" style="display:none;" readonly> -->
                        </div>
                      </div>
                      <div class="form-group row col-12">
                        <label class="col-md-4">Kecepatan Tanggap</label>
                        <div class="col-md-8">
                          <select name="transaksi_kecepatan_tanggap" id="transaksi_kecepatan_tanggap" class="select2 form-control">
                            <option value="Biasa">Biasa</option>
                            <option value="Segera">Segera</option>
                            <option value="Sangat Segera">Sangat Segera</option>
                          </select>

                        </div>
                      </div>
                      <div class="form-group row col-12">
                        <label class="col-md-4">Kode Klasifikasi</label>
                        <div class="col-md-8">
                          <select name="transaksi_klasifikasi_id" id="transaksi_klasifikasi_id" class="select2 form-control"></select>
                          <span id="alert_klasifikasi" class="text-danger" style="display:none">Kode Klasifikasi Harus Diisi</span>
                          <!-- <input type="text" class="form-control-plaintext text-danger" value="Kode Klasifikasi Harus Diisi" id="alert_klasifikasi" style="display:none;" readonly> -->
                        </div>
                      </div>
                      <div class="form-group row col-12">
                        <label class="col-md-4">Sifat</label>
                        <div class="col-md-8">
                          <select name="transaksi_sifat" id="transaksi_sifat" class="select2 form-control">
                            <option value="Biasa">Biasa</option>
                            <option value="Rahasia">Rahasia</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <!-- Kiri -->
                    <!-- Kanan -->
                    <div class="col-6">
                      <div class="form-group row col-12">
                        <label class="col-md-4">Drafter</label>
                        <div class="col-md-8">
                          <input type="text" name="transaksi_drafter_poscode" id="transaksi_drafter_poscode" style="display:none">
                          <select name="transaksi_drafter" id="transaksi_drafter" class="select2 form-control" onchange="gantiDrafter(this.value)"></select>
                        </div>
                      </div>
                      <div class="form-group row col-12" id="div_reviewer1">
                        <label class="col-md-4">Reviewer</label>
                        <div class="col-md-8">
                          <input type="text" name="transaksi_reviewer_poscode" id="transaksi_reviewer_poscode" style="display:none">
                          <select name="transaksi_reviewer" id="transaksi_reviewer" class="select2 form-control" onchange="gantiReviewer(this.value)"></select>
                        </div>
                      </div>
                      <div class=" form-group row col-12" id="div_approver1">
                        <label class="col-md-4">Approver</label>
                        <div class="col-md-8">
                          <input type="text" name="transaksi_approver_poscode" id="transaksi_approver_poscode" style="display:none;">
                          <select name="transaksi_approver" id="transaksi_approver" class="select2 form-control" onchange="gantiApprover(this.value)"></select>
                        </div>
                      </div>
                      <div class="form-group row col-12">
                        <label class="col-md-4">Tujuan</label>
                        <div class="col-md-8">
                          <input type="text" name="transaksi_tujuan_poscode" id="transaksi_tujuan_poscode" style="display:none">
                          <select name="transaksi_tujuan" id="transaksi_tujuan" class="select2 form-control" onchange="gantiTujuan(this.value)"></select>
                        </div>
                      </div>
                    </div>
                    <!-- Kanan -->
                  </div>
                </div>
              </div>
            </div>
            <!-- Detail Surat -->
            <!-- Detail Sample -->
            <div class="card">
              <div class="card-header bg-warning">
                <h3 class="card-title"> Detail Sample</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-12">
                    <div class="form-group row col-md-12">
                      <label class="col-md-4">Peminta Jasa</label>
                      <div class="col-md-8">
                        <select class="form-control select2 required" id="peminta_jasa_id" name="peminta_jasa_id"></select>
                      </div>
                    </div>
                    <div class="form-group row col-md-12">
                      <label class="col-md-4">PIC Pengirim Sample</label>
                      <div class="col-md-8">
                        <input type="text" id="transaksi_pic_pengirim_id" name="transaksi_pic_pengirim_id" style="display:none">
                        <input type="text" id="transaksi_pic_pengirim_poscode" name="transaksi_pic_pengirim_poscode" style="display:none">
                        <select name="transaksi_detail_pic_pengirim" id="transaksi_detail_pic_pengirim" class="select2 form-control" onchange="gantiPICPengirim(this.value)"></select>
                      </div>
                    </div>
                    <div class="form-group row col-md-12">
                      <label class="col-md-4">PIC Telepon / WhatsApp</label>
                      <div class="col-md-8">
                        <input type="text" class="form-control" id="transaksi_detail_pic_telepon" name="transaksi_detail_pic_telepon" value="<?= $session['user_no_hp'] ?>" placeholder="Telp PIC" onkeypress="return numberOnly(event)" onpaste="return numberOnly(event)">
                        <span id="alert_pic_telp" class="text-danger" style="display:none">PIC Telepon / WhatsApp Harus Diisi</span>
                        <!-- <input type="text" class="form-control-plaintext text-danger" value="PIC Telepon / WhatsApp Harus Diisi" id="alert_pic_telp" style="display:none;"> -->
                      </div>
                    </div>
                    <div class="form-group row col-md-12">
                      <label class="col-md-4">Ext Pengirim Sample </label>
                      <div class="col-md-8">
                        <input type="text" class="form-control required" id="transaksi_detail_ext_pengirim" name="transaksi_detail_ext_pengirim" value="" placeholder="Ext Pengirim Sample" onkeypress="return numberOnly(event)" onpaste="return numberOnly(event)">
                        <span id="alert_ext_pengirim" class="text-danger" style="display:none">EXT Pengirim Sample Harus Diisi</span>
                        <!-- <input type="text" class="form-control-plaintext text-danger" value="EXT Pengirim Sample Harus Diisi" id="alert_ext_pengirim" style="display:none;"> -->
                      </div>
                    </div>
                    <div class="form-group row col-md-12" style="display:none">
                      <label class="col-md-4">Tanggal Pengajuan </label>
                      <div class="col-md-8">
                        <input type="date" class="form-control" id="transaksi_tanggal" name="transaksi_tanggal" value="<?= date('Y-m-d H:i:s') ?>" placeholder="Tanggal Pengajuan">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Detail Sample -->
            <!-- Detial Item -->
            <div class="card">
              <div class="card-header bg-info">
                <h3 class="card-title"> Detail Item</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="div_item">
                  <div class="div_item_baru">
                    <div class="row">
                      <div class="form-group row col-md-12">
                        <div class="col-11">
                          <input id="transaksi_detail_id" name="transaksi_detail_id[]" value="<?= create_id(); ?>" style="display:none">
                          <input required type="text" class="form-control" id="item_judul" name="item_judul[]" placeholder="Judul" value="Sample 1" style=" border:none;border-bottom: 1px solid #1890ff;padding: 5px 10px;  outline: none;">
                        </div>
                        <div class="col-1">
                          <button class="btn btn-danger btn-custom remove_item float-right" type="button" id="remove_item">Hapus</button>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <!-- Kiri -->
                      <div class="col-6">
                        <div class="form-group row col-12">
                          <label class="col-md-4">Jenis Sample</label>
                          <div class="col-md-8">
                            <select name="jenis_id[]" id="jenis_id" class="form-control select2"></select>
                          </div>
                        </div>
                        <div class="form-group row col-12">
                          <label class="col-md-4">Jenis Pekerjaan</label>
                          <div class="col-md-8">
                            <select name="jenis_pekerjaan_id[]" id="jenis_pekerjaan_id" class="form-control select2"></select>
                          </div>
                        </div>
                        <div class="form-group row col-12">
                          <label class="col-md-4">Jumlah Sample</label>
                          <div class="col-8">
                            <input type="text" id="transaksi_detail_jumlah" name="transaksi_detail_jumlah[]" value="1" class="form-control" onkeypress="return numberOnly(event)" onpaste="return numberOnly(event)">
                          </div>
                        </div>
                        <div class="form-group row col-12">
                          <label class="col-md-4">Identitas Sample</label>
                          <div class="col-8">
                            <input type="text" id="transaksi_detail_identitas" name="transaksi_detail_identitas[]" placeholder="Identitas Sample" class="form-control">
                            <input type="text" id="identitas_id" name="identitas_id[]" style="display: none">
                            <ul class="list-group" id="transaksi_detail_identitas_hasil"></ul>
                          </div>
                        </div>
                        <div class="form-group row col-12">
                          <label class="col-md-4">Jumlah Parameter</label>
                          <div class="col-8">
                            <input type="text" id="transaksi_detail_parameter" name="transaksi_detail_parameter[]" placeholder="Parameter Sample" class="form-control" onkeypress="return numberOnly(event)" onpaste="return numberOnly(event)">
                          </div>
                        </div>
                        <div class="form-group row col-12">
                          <label class="col-md-4">Deskripsi Parameter Uji / Kalibrasi</label>
                          <div class="col-8">
                            <textarea name="transaksi_detail_deskripsi_parameter[]" id="transaksi_detail_deskripsi_parameter" cols="3" rows="3" class="form-control" placeholder="Analisa Cu, Pb, Uji Aplikasi, Analisa Kimia / Kalibrasi Suhu Range 10 Derajat C, 20 Derajat C"></textarea>
                          </div>
                        </div>
                        <div class="form-group row col-12">
                          <label class="col-md-4">Catatan Pengajuan</label>
                          <div class="col-8">
                            <textarea name="transaksi_detail_catatan[]" id="transaksi_detail_catatan" cols="3" rows="3" class="form-control" placeholder="Untuk kebutuhan Extra Cek Pabrik NPK 5"></textarea>
                          </div>
                        </div>
                      </div>
                      <!-- Kiri -->
                      <!-- Kanan -->
                      <div class="col-6">
                        <div class="form-group row col-12">
                          <label class="col-md-4">Attachment</label>
                          <div class="col-8">
                            <input type="file" name="transaksi_detail_attachment[]" id="transaksi_detail_attachment" class="form-control" accept="application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-powerpoint, application/vnd.openxmlformats-officedocument.presentationml.presentation, text/plain, application/pdf, image/jpeg,image/png,image/gif,image/bmp" required>
                          </div>
                        </div>
                        <div class="form-group row col-12">
                          <label class="col-md-4">Foto Sample</label>
                          <div class="col-8">
                            <input type="file" name="transaksi_detail_file[]" id="transaksi_detail_file" class="form-control" accept="image/jpeg,image/png,image/gif,image/bmp" required>
                          </div>
                        </div>
                      </div>
                      <!-- Kanan -->
                    </div>
                  </div>
                </div>
                <button class="btn btn-custom btn-success" id="add_item" type="button">Tambah Item</button>
              </div>
            </div>
            <!-- Detial Item -->
            <!-- Tombol -->
            <div class="card-footer">
              <button type="button" id="kembali" class="btn btn-default btn-custom border-dark" onclick="kembali_request()">Kembali</button>
              <button type="button" class="btn btn-info btn-custom" id="draft">Draft</button>
              <button type="button" class="btn btn-success btn-custom float-right" id="ajukan">Ajukan</button>
              <button type="button" class="btn btn-primary btn-custom" id="edit" style="display: none">Edit</button>
            </div>
            <!-- Tombol -->
          </form>
        </div>
      </div>
    </div>
  </section>
  <!-- Container Body -->
</div>
<!-- CONTAINER-->

<!-- modal note proses -->
<div class="modal fade" id="modal_agreement" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Note Pengajuan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="form_agreement">
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <div class="form-group row col-12">
                <label class="col-md-4">Note Pengajuan </label>
                <div class="col-md-8">
                  <input type="text" id="transaksi_agreement_keterangan" name="transaksi_agreement_keterangan" class="form-control">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-custom" data-dismiss="modal" id="close">Close</button>
          <button type="button" class="btn btn-primary btn-custom" id="insert_ajukan">Ajukan</button>
          <button class="btn btn-primary" type="button" id="loading_form" disabled style="display: none;">
            <img src="<?php echo site_url('assets_tambahan/ext_img/loading_page_resize_2.gif') ?>" alt="" style="width:30px">Loading...
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- modal note proses -->