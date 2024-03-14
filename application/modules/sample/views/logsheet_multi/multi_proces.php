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
          <form id="form_inbox">
            <!-- Detail Surat -->
            <div class="card">
              <!-- Header -->
              <div class="card-header bg-primary">
                <h3 class="card-title">Detail Surat</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
              </div>
              <!-- Header -->
              <!-- Body -->
              <div class="card-body row">
                <input style="display: none;" type="text" id="header_menu" name="header_menu" value="<?= $this->input->get('header_menu') ?>">
                <input style="display: none;" type="text" id="menu_id" name="menu_id" value="<?= $this->input->get('menu_id') ?>">
                <input type="text" id="is_new" name="is_new" style="display:none">
                <input type="text" id="transaksi_status" name="transaksi_status" style="display:none" value="<?= $_GET['transaksi_status'] ?>">
                <input type="text" id="transaksi_non_rutin_id" name="transaksi_non_rutin_id" style="display:none" value="<?= $inbox['transaksi_non_rutin_id'] ?>">
                <input type="text" id="transaksi_id" name="transaksi_id" style="display: none;" value="<?= $_GET['transaksi_id'] ?>">
                <input type="text" id="transaksi_tipe" name="transaksi_tipe" value="<?= $inbox['transaksi_tipe'] ?>" style="display: none;">
                <input type="text" name="transaksi_detail_group" id="transaksi_detail_group" value="<?= $this->input->get('transaksi_detail_group') ?>" style="display:none">
                <div class="col-12">
                  <div class="form-group row col-md-12" style="display: none;">
                    <label class="col-md-4">Jenis</label>
                    <div class="input-group col-md-8">
                      <select name="transaksi_jenis_surat" id="transaksi_jenis_surat" class="select2 form-control"></select>
                    </div>
                  </div>
                  <div class="form-group row col-md-12" style="display: none;">
                    <label class="col-md-4">Template</label>
                    <div class="input-group col-md-8">
                      <select name="transaksi_template_surat" id="transaksi_template_surat" class="select2 form-control"></select>
                    </div>
                  </div>
                  <div class="row">
                    <!-- Kiri -->
                    <div class="col-6">
                      <div class="form-group row col-12">
                        <label class="col-md-4">Judul</label>
                        <div class="input-group col-md-8">
                          <input type="text" class="form-control" id="transaksi_judul" name="transaksi_judul" placeholder="Judul" value="<?= $inbox['transaksi_judul'] ?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row col-12">
                        <label class="col-md-4">Kecepatan Tanggap</label>
                        <div class="input-group col-md-8">
                          <input type="text" class="form-control" id="transaksi_kecepatan_tanggal" name="transaksi_kecepatan_tanggap" value="<?= $inbox['transaksi_kecepatan_tanggap'] ?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row col-12">
                        <label class="col-md-4">Kode Klasifikasi</label>
                        <div class="input-group col-md-8">
                          <input type="text" class="form-control" id="transaksi_klasifikasi_kode" name="transaksi_klasifikasi_kode" value="<?= $inbox['klasifikasi_nama'] . ' - ' . $inbox['klasifikasi_kode'] ?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row col-12">
                        <label class="col-md-4">Sifat</label>
                        <div class="input-group col-md-8">
                          <input type="text" name="transaksi_sifat" id="transaksi_sifat" class="form-control" value="<?= $inbox['transaksi_sifat'] ?>" readonly>
                        </div>
                      </div>
                    </div>
                    <!-- Kiri -->
                    <!-- Kanan -->
                    <div class="col-6">
                      <div class="form-group row col-12">
                        <label class="col-md-4">Reviewer</label>
                        <div class="input-group col-md-8">
                          <input type="text" name="transaksi_reviewer" id="transaksi_reviewer" class="form-control" value="<?= $inbox['nik_reviewer'] . ' - ' . $inbox['nama_reviewer'] . ' - ' . $inbox['title_reviewer'] ?>" readonly>
                        </div>
                      </div>
                      <div class=" form-group row col-12">
                        <label class="col-md-4">Approver</label>
                        <div class="input-group col-md-8">
                          <input type="text" name="transaksi_approver" id="transaksi_approver" class="form-control" value="<?= $inbox['nik_approver'] . ' - ' . $inbox['nama_approver'] . ' - ' . $inbox['title_approver'] ?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row col-12">
                        <label class="col-md-4">Drafter</label>
                        <div class="input-group col-md-8">
                          <input type="text" name="transaksi_drafter" id="transaksi_drafter" class="form-control" value="<?= $inbox['nik_drafter'] . ' - ' . $inbox['nama_drafter'] . ' - ' . $inbox['title_drafter'] ?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row col-12">
                        <label class="col-md-4">Tujuan</label>
                        <div class="input-group col-md-8">
                          <input type="text" name="transaksi_tujuan" id="transaksi_tujuan" class="form-control" value="<?= $inbox['nik_tujuan'] . ' - ' . $inbox['nama_tujuan'] . ' - ' . $inbox['title_tujuan'] ?>" readonly>
                        </div>
                      </div>
                    </div>
                    <!-- Kanan -->
                  </div>
                </div>
              </div>
              <!-- Body -->
            </div>
            <!-- Detail Surat -->
            <!-- Detail Sample -->
            <div class="card">
              <!-- Header -->
              <div class="card-header bg-warning">
                <h3 class="card-title"> Detail Sample</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
              </div>
              <!-- Header -->
              <!-- Body -->
              <div class="card-body">
                <div class="row">
                  <div class="col-12">
                    <div class="form-group row col-md-12">
                      <label class="col-md-4">Peminta Jasa</label>
                      <div class="input-group col-md-8">
                        <input class="form-control" id="peminta_jasa_nama" name="peminta_jasa_nama" value="<?= $inbox['peminta_jasa_nama'] ?>" readonly>
                      </div>
                    </div>
                    <div class="form-group row col-md-12">
                      <label class="col-md-4">PIC Pengirim Sample</label>
                      <div class="input-group col-md-8">
                        <input type="text" name="transaksi_pic_pengirim" id="transaksi_pic_pengirim" class="form-control" value="<?= $inbox['nik_pic_pengirim'] . ' - ' . $inbox['nama_pic_pengirim'] . ' - ' . $inbox['title_pic_pengirim'] ?>" readonly>
                      </div>
                    </div>
                    <div class="form-group row col-md-12">
                      <label class="col-md-4">PIC Telepon</label>
                      <div class="input-group col-md-8">
                        <input type="text" class="form-control" id="transaksi_detail_pic_telepon" name="transaksi_detail_pic_telepon" value="<?= $inbox['transaksi_pic_telepon'] ?>" placeholder="Telp PIC" readonly>
                      </div>
                    </div>
                    <div class="form-group row col-md-12">
                      <label class="col-md-4">Ext Pengirim Sample</label>
                      <div class="input-group col-md-8">
                        <input type="number" class="form-control" id="transaksi_detail_ext_pengirim" name="transaksi_detail_ext_pengirim" value="<?= $inbox['transaksi_pic_ext'] ?>" placeholder="Ext Pengirim Sample" readonly>
                      </div>
                    </div>
                    <div class="form-group row col-md-12" style="display:none">
                      <label class="col-md-4">Tanggal Pengajuan *</label>
                      <div class="input-group col-md-8">
                        <input type="date" class="form-control" id="transaksi_tanggal" name="transaksi_tanggal" value="<?= date('Y-m-d H:i:s') ?>" placeholder="Ext Pengirim Sample">
                      </div>
                    </div>
                    <?php if ($multisample_group['transaksi_detail_status'] == '8') : ?>
                      <div class="form-group row col-12" id="div_template_logsheet">
                        <label class="col-md-4">Template</label>
                        <div class="input-group col-md-8">
                          <select onchange="ganti_template(this.value)" id="template_logsheet_id" name="template_logsheet_id" class="form-control select2"></select>
                          <div class="form-group row col-12" id="div_id_template_logsheet" style="display:none">
                            <a href="javascript:void(0);" onclick="download_template(this.value)" id="id_download_logsheet" name="id_download_logsheet">Template</a>
                            <!-- <a href="javascript:void(0);" onclick="preview_template(this.value)" id="id_template_logsheet" name="id_template_logsheet">Preview</a> -->
                          </div>
                        </div>
                      </div>
                      <div class="form-group row col-12" id="div_file_excel">
                        <label class="col-md-4">File Excel</label>
                        <div class="col-md-8">
                          <input type="file" class="form-control required" id="logsheet_file_excel" name="logsheet_file_excel" placeholder="Judul" accept="application/vnd.ms-excel">
                          <span for="" style="color:red">note : format yang didukung .xls</span>
                          <!-- &nbsp;&nbsp;&nbsp;&nbsp;<span><a href="<?= base_url('document/sample/contoh sample-template zk.xls') ?>" target="_blank">Sample</a></span> -->
                        </div>
                      </div>
                      <div class="form-group row col-12" id="div_file_excel_baris">
                        <label class="col-md-4">Batas Baris Excel</label>
                        <div class="col-md-8">
                          <input type="number" class="form-control required" id="logsheet_baris_excel" name="logsheet_baris_excel" value="1">
                        </div>
                      </div>
                      <div class="form-group row col-12" id="div_file_excel_baris" style="display: none;">
                        <label class="col-md-4">Jumlah Sample</label>
                        <div class="col-md-8">
                          <input type="text" class="form-control required" id="logsheet_jumlah_sample" name="logsheet_jumlah_sample" value="<?= count($inbox_detail) ?>">
                        </div>
                      </div>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
              <!-- Body -->
            </div>
            <!-- Detail Sample -->
            <!-- Detail Item -->
            <div class="card">
              <!-- Header -->
              <div class="card-header bg-info">
                <h3 class="card-title"> Detail Item</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
              </div>
              <!-- Header -->
              <!-- Body -->
              <div class="card-body">
                <?php foreach ($inbox_detail as $key => $value) : ?>
                  <div class="div_item_baru">
                    <div class="row">
                      <!-- Judul -->
                      <div class="form-group row col-md-12">
                        <div class="input-group col-12">
                          <input id="transaksi_detail_id_temp_<?= $key ?>" name="transaksi_detail_id_temp[]" value="<?= $value['transaksi_detail_id'] ?>" style="display:none" class="transaksi_detail_id_temp">
                          <input id="transaksi_detail_id_<?= $key ?>" name="transaksi_detail_id[]" value="<?= create_id(); ?>" style="display:none" class="transaksi_detail_id">
                          <input type="text" id="transaksi_detail_status_<?= $key ?>" name="transaksi_detail_status[]" value="<?= $value['transaksi_detail_status'] ?>" style="display:none">
                          <input type="text" class="form-control" id="item_judul" name="item_judul[]" readonly placeholder="Judul" value="<?= $value['transaksi_detail_judul'] ?>" style=" border:block;border-bottom: 1px solid #1890ff;padding: 5px 10px;  outline: block;">
                        </div>
                      </div>
                      <!-- Judul -->
                    </div>
                    <div class="row">
                      <!-- Kiri -->
                      <div class="col-6">
                        <div class="form-group row col-12">
                          <label class="col-md-4">Jenis Sample</label>
                          <div class="input-group col-md-8">
                            <input type="text" id="jenis_id_<?= $key ?>" name="jenis_id[]" value="<?= $value['jenis_id'] ?>" class="form-control jenis_id" style="display: none;">
                            <input type="text" id="jenis_nama_<?= $key ?>" name="jenis_nama[]" value="<?= $value['jenis_nama'] ?>" class="form-control" readonly>
                          </div>
                        </div>
                        <div class="form-group row col-12">
                          <label class="col-md-4">Jenis Pekerjaan</label>
                          <div class="input-group col-md-8">
                            <input type="text" id="sample_pekerjaan_nama_<?= $key ?>" name="sample_pekerjaan_nama[]" class="form-control" value="<?= $value['sample_pekerjaan_nama'] ?>" readonly>
                          </div>
                        </div>
                        <div class="form-group row col-12">
                          <label for="" class="col-md-4">Jumlah Sample</label>
                          <div class="input-group col-8">
                            <input type="text" id="transaksi_detail_jumlah_<?= $key ?>" name="transaksi_detail_jumlah[]" class="form-control" value="<?= $value['transaksi_detail_jumlah']; ?>" readonly>
                          </div>
                        </div>
                        <div class="form-group row col-12">
                          <label for="" class="col-md-4">Identitas Sample</label>
                          <div class="input-group col-8">
                            <input type="text" id="identitas_nama_<?= $key ?>" name="identitas_nama[]" placeholder="Identitas Sample" class="form-control" value="<?= $value['transaksi_detail_identitas']; ?>" readonly>
                          </div>
                        </div>
                        <div class="form-group row col-12">
                          <label for="" class="col-md-4">Parameter Sample</label>
                          <div class="input-group col-8">
                            <input type="text" id="transaksi_detail_parameter_<?= $key ?>" name="transaksi_detail_parameter[]" placeholder="Parameter Sample" class="form-control" value="<?= $value['transaksi_detail_parameter'] ?>">
                          </div>
                        </div>
                        <div class="form-group row col-12">
                          <label for="" class="col-md-4">Deskripsi Parameter Uji / Kalibrasi</label>
                          <div class="input-group col-8">
                            <textarea readonly name="transaksi_detail_deskripsi_parameter[]" id="transaksi_detail_deskripsi_parameter_<?= $key ?>" cols="3" rows="3" class="form-control" placeholder="Analisa Cu, Pb, Uji Aplikasi, Analisa Kimia / Kalibrasi Suhu Range 10 Derajat C, 20 Derajat C"><?= $value['transaksi_detail_deskripsi_parameter'] ?></textarea>
                          </div>
                        </div>
                        <div class="form-group row col-12">
                          <label for="" class="col-md-4">Catatan Pengajuan</label>
                          <div class="input-group col-8">
                            <textarea readonly name="transaksi_detail_catatan[]" id="transaksi_detail_catatan_<?= $key ?>" cols="3" rows="3" class="form-control" placeholder="Untuk kebutuhan Extra Cek Pabrik NPK 5"><?= $value['transaksi_detail_catatan'] ?></textarea>
                          </div>
                        </div>
                      </div>
                      <!-- Kiri -->
                      <!-- Kanan -->
                      <div class="col-6">
                        <div class="form-group row col-md-12">
                          <label class="col-md-4">Estimasi</label>
                          <div class="input-group col-md-8">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                            </div>
                            <input type="text" class="form-control float-right tanggal" id="transaksi_detail_tgl_estimasi_<?= $key ?>" name="transaksi_detail_tgl_estimasi[]" required="">
                          </div>
                        </div>
                        <div class="form-group row col-12">
                          <label for="" class="col-md-4">Attachment</label>
                          <div class="input-group col-8">
                            <input type="text" name="transaksi_detail_attachment_lama[]" id="transaksi_detail_attachment_lama_<?= $key ?>" class="form-control" value="<?= $value['transaksi_detail_attach'] ?>" readonly>
                          </div>
                        </div>
                        <div class="form-group row col-12">
                          <label for="" class="col-md-4">Foto Sample</label>
                          <div class="input-group col-8">
                            <input type="text" name="transaksi_detail_file_lama[]" id="transaksi_detail_file_lama_<?= $key ?>" class="form-control" value="<?= $value['transaksi_detail_file'] ?>" readonly>
                          </div>
                        </div>
                        <div class="form-group row col-12">
                          <label for="" class="col-md-4"></label>
                          <div class="input-group col-8">
                            <a class="btn btn-info col-4" href="javascript:;" data-toggle="modal" data-target="#modal_lihat" onclick="fun_lihat('<?= $value['transaksi_detail_file'] ?>')">Preview</a>
                            <label class="col-1">&nbsp;</label>
                            <a class="btn btn-info col-4" target="_blank" href="<?= base_url() . 'sample/request/downloadFile?file=' . $value['transaksi_detail_file'] ?>">Download</a>
                          </div>
                        </div>
                        <div class="form-group row col-12">
                          <label for="" class="col-md-4"></label>
                          <div class="input-group col-8">
                            <img src="<?= base_url() . 'document/' . $value['transaksi_detail_file'] ?>" style="width:200px;border:1px black">
                          </div>
                        </div>
                      </div>
                      <!-- Kanan -->
                    </div>
                  </div>
                <?php endforeach ?>
              </div>
              <!-- Body -->
              <!-- Footer -->
              <div class="card-footer">
                <button type="button" id="close" class="btn btn-default border-dark" onClick="kembali_inbox_multi()">Kembali</button>
                <button type=" button" class="btn btn-info" id="batal" data-target="#modal_batal" data-toggle="modal">Batalkan</button>
                <?php if ($value['transaksi_detail_status'] == '6') : ?>
                  <button type="button" class="btn btn-danger" id="belum_diterima" style="display: none;">Sample Belum Diterima</button>
                  <button type="button" class="btn btn-success float-right" id="diterima" style="display: none;">Sample Diterima</button>
                <?php elseif ($value['transaksi_detail_status'] == '7') : ?>
                  <button type="button" class="btn btn-danger" id="tunda" style="display: none" data-target="#modal_tunda" data-toggle="modal">Tunda</button>
                  <button type="button" class="btn btn-success float-right" id="progress" style="display: none" onClick="fun_cara_close('<?= $_GET['transaksi_id'] ?>','<?= $_GET['transaksi_status'] ?>')" data-target="#modal_cara_close" data-toggle="modal">On Progress</button>
                <?php elseif ($value['transaksi_detail_status'] == '8') : ?>
                  <button type="button" class="btn btn-success float-right" id="sample_log" style="display: none">Raw Data</button>
                  <button type="button" class="btn btn-danger" id="tunda" style="display: none" data-target="#modal_tunda" data-toggle="modal">Tunda</button>
                <?php elseif ($value['transaksi_detail_status'] == '9') : ?>
                  <button type="button" class="btn btn-danger" id="tunda" style="display: none" data-target="#modal_tunda" data-toggle="modal">Tunda</button>
                  <button type="button" class="btn btn-warning" id="terbit_sertifikat" style="display: none">Terbit Sertifikat</button>
                <?php elseif ($value['transaksi_detail_status'] == '10') : ?>
                  <button type="button" class="btn btn-danger" id="tunda" style="display: none" data-target="#modal_tunda" data-toggle="modal">Tunda</button>
                  <button type="button" class="btn btn-warning" id="clossed" style="display: none">Clossed</button>
                <?php endif; ?>

                <button class="btn btn-primary" type="button" id="loading_form" disabled style="display: none;">
                  <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                  Loading...
                </button>
              </div>
              <!-- Footer -->
            </div>
            <!-- Detail Item -->
          </form>
        </div>
      </div>
    </div>
  </section>
  <!-- Container Body -->
</div>
<!--CONTAINER -->

<!-- Modal Batal -->
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
<!-- Modal Batal -->

<!-- Modal Tunda -->
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
<!-- Modal Tunda -->

<!-- Modal On Progress -->
<div class="modal fade" id="modal_cara_close" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cara Close</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="form_cara_close">
        <div class="modal-body">
          <?php foreach ($inbox_detail as $detail) : ?>
            <input type="text" name="cara_close_transaksi_detail_id_temp" id="cara_close_transaksi_detail_id_temp" value="<?= $detail['transaksi_detail_id'] ?>" style="display:none">
            <input type="text" name="cara_close_transaksi_detail_id" id="cara_close_transaksi_detail_id" style="display:none" value="<?= $detail['transaksi_detail_id'] ?>_1">
            <input type="text" name="cara_close_transaksi_detail_status" id="cara_close_transaksi_detail_status" style="display:none" value="<?= $detail['transaksi_detail_status'] ?>">
          <?php endforeach; ?>
          <input type="text" name="cara_close_transaksi_id" id="cara_close_transaksi_id" style="display:none">
          <input type="text" name="cara_close_transaksi_status" id="cara_close_transaksi_status" style="display:none">
          <div class="row">
            <div class="col-12">
              <div class="form-group row col-md-12">
                <label class="col-md-4">Pilih Cara Close</label>
                <div class="input-group col-md-8">
                  <input type="text" id="cara_close_kode" name="cara_close_kode" style="display:none">
                  <select name="cara_close_nama" id="cara_close_nama" class="form-control select2" style="width:100%" onChange="fun_ganti_kode_close(this.value);">
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close_cara_close" onclick="fun_close_cara_close()">Close</button>
          <button type="submit" class="btn btn-primary" id="simpan_cara_close_multiple">Lanjut</button>
          <button class="btn btn-primary" type="button" id="loading_cara_close" disabled style="display: none;">
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            Loading...
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Modal On Progress -->

<!-- Modal Lihat -->
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
<!-- Modal Lihat -->