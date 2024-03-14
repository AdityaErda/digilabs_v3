<style type="text/css">
  .modal-content {
    overflow: scroll !important;
  }
</style>

<?php
$session = $this->session->userdata();
$vp_ppk = $this->db->query("SELECT * FROM global.global_api_user WHERE user_poscode = 'E44000000'")->row_array();
?>

<!-- CONTAINER -->
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
          <form id="form_review">
            <!-- Detail Surat -->
            <div class="card">
              <!-- Header -->
              <div class="card-header bg-primary">
                <h3 class="card-title">Detail Surat</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <!-- Header -->
              <!-- Body -->
              <div class="card-body row">
                <input type="text" id="is_new" name="is_new" style="display: none;">
                <input type="text" id="transaksi_non_rutin_id" name="transaksi_non_rutin_id" style="display:none" value="">
                <input type="text" id="transaksi_id" name="transaksi_id" style="display: none;" value="">
                <input type="text" id="transaksi_status" name="transaksi_status" style="display:none" value="<?= $_GET['status'] ?>">
                <input type="text" id="transaksi_tipe" name="transaksi_tipe" style="display: none;">
                <div class="col-12">
                  <div class="row">
                    <!-- Kiri -->
                    <div class="col-6">
                      <div class="form-group row col-12">
                        <label class="col-md-4">Judul </label>
                        <div class="col-md-8">
                          <input type="text" class="form-control required" id="transaksi_judul" name="transaksi_judul" placeholder="Judul" value="">
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
                      <div class="form-group row col-12">
                        <label class="col-md-4">Reviewer</label>
                        <div class="col-md-8">
                          <input type="text" name="transaksi_reviewer_poscode" id="transaksi_reviewer_poscode" style="display:none">
                          <select name="transaksi_reviewer" id="transaksi_reviewer" class="select2 form-control" onchange="gantiReviewer(this.value)"></select>
                        </div>
                      </div>
                      <div class=" form-group row col-12">
                        <label class="col-md-4">Approver</label>
                        <div class="col-md-8">
                          <input type="text" name="transaksi_approver_poscode" id="transaksi_approver_poscode" style="display:none">
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
              <!-- Body -->
            </div>
            <!-- Detail Surat -->

            <!-- Detail Sample -->
            <div class="card">
              <!-- Header -->
              <div class="card-header bg-warning">
                <h3 class="card-title"> Detail Sample</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <!-- Header -->
              <!-- Body -->
              <div class="card-body">
                <div class="row">
                  <div class="col-12">
                    <div class="form-group row col-md-12">
                      <label class="col-md-4">Peminta Jasa</label>
                      <div class="col-md-8">
                        <select class="form-control select2 required" id="peminta_jasa_id" name="peminta_jasa_id">
                        </select>
                      </div>
                    </div>
                    <div class="form-group row col-md-12">
                      <label class="col-md-4">PIC Pengirim Sample</label>
                      <div class="col-md-8">
                        <input type="text" id="transaksi_pic_pengirim_poscode" name="transaksi_pic_pengirim_poscode" style="display:none">
                        <input type="text" id="transaksi_pic_pengirim_id" name="transaksi_pic_pengirim_id" style="display:none">
                        <select name="transaksi_detail_pic_pengirim" id="transaksi_detail_pic_pengirim" class="select2 form-control" onchange="gantiPICPengirim(this.value)"></select>
                      </div>
                    </div>
                    <div class="form-group row col-md-12">
                      <label class="col-md-4">PIC Telepon / WhatsApp</label>
                      <div class="col-md-8">
                        <input type="text" class="form-control" id="transaksi_detail_pic_telepon" name="transaksi_detail_pic_telepon" value="<?= $session['user_no_hp'] ?>" placeholder="Telp PIC" onkeypress="return numberOnly(event)">
                      </div>
                    </div>
                    <div class="form-group row col-md-12">
                      <label class="col-md-4">Ext Pengirim Sample </label>
                      <div class="col-md-8">
                        <input type="text" class="form-control required" id="transaksi_detail_ext_pengirim" name="transaksi_detail_ext_pengirim" value="" placeholder="Ext Pengirim Sample" onkeypress="return numberOnly(event)">
                      </div>
                    </div>
                    <div class="form-group row col-md-12" style="display:none">
                      <label class="col-md-4">Tanggal Pengajuan </label>
                      <div class="col-md-8">
                        <input type="date" class="form-control" id="transaksi_tanggal" name="transaksi_tanggal" value="<?= date('Y-m-d H:i:s') ?>" placeholder="Ext Pengirim Sample">
                      </div>
                    </div>
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
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <!-- Header -->
              <!-- Body -->
              <div class="card-body">
                <div class="div_item">
                  <?php foreach ($sample_detail as $key => $detail) : ?>
                    <div class="div_item_baru">
                      <div class="row">
                        <div class="form-group row col-md-12">
                          <div class="col-11">
                            <input id="transaksi_detail_id_temp_<?= $key ?>" name="transaksi_detail_id_temp[]" style="display: none;" value="<?= $detail['transaksi_detail_id'] ?>">
                            <input id="transaksi_detail_id_<?= $key ?>" name="transaksi_detail_id[]" value="<?= create_id() ?>" style="display:none">
                            <input required type="text" class="form-control" id="item_judul_<?= $key ?>" name="item_judul[]" placeholder="Judul" value="<?= $detail['transaksi_detail_judul'] ?>" style=" border:none;border-bottom: 1px solid #1890ff;padding: 5px 10px;  outline: none;">
                          </div>
                          <div class="col-1">
                            <button class="btn btn-danger btn-custom remove_item" type="button">Hapus</button>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <!-- Kiri -->
                        <div class="col-6">
                          <div class="form-group row col-12">
                            <label class="col-md-4">Jenis Sample</label>
                            <div class="col-md-8">
                              <select name="jenis_id[]" id="jenis_id_<?= $key ?>" class="form-control select2">
                                <?php foreach ($sample_jenis as $sample) : ?>
                                  <option <?php if ($sample['jenis_id'] == $detail['jenis_id']) echo 'selected'; ?> value="<?= $sample['jenis_id'] ?>"><?= $sample['jenis_nama'] ?></option>
                                <?php endforeach; ?>
                              </select>
                            </div>
                          </div>
                          <div class="form-group row col-12">
                            <label class="col-md-4">Jenis Pekerjaan</label>
                            <div class="col-md-8">
                              <select name="jenis_pekerjaan_id[]" id="jenis_pekerjaan_id_<?= $key ?>" class="form-control select2">
                                <?php foreach ($pekerjaan_jenis as $pekerjaan) : ?>
                                  <option <?php if ($pekerjaan['sample_pekerjaan_id'] == $detail['jenis_pekerjaan_id']) echo 'selected'; ?> value="<?= $pekerjaan['sample_pekerjaan_id'] ?>"><?= $pekerjaan['sample_pekerjaan_nama']; ?></option>
                                <?php endforeach; ?>
                              </select>
                            </div>
                          </div>
                          <div class="form-group row col-12">
                            <label class="col-md-4">Jumlah Sample</label>
                            <div class="col-8">
                              <input type="text" id="transaksi_detail_jumlah_<?= $key ?>" name="transaksi_detail_jumlah[]" class="form-control" value="<?= $detail['transaksi_detail_jumlah']; ?>" onkeypress="return numberOnly(event)">
                            </div>
                          </div>
                          <div class="form-group row col-12">
                            <label class="col-md-4">Identitas Sample</label>
                            <div class="col-8">
                              <input type="text" id="transaksi_detail_identitas_<?= $key ?>" name="transaksi_detail_identitas[]" placeholder="Identitas Sample" class="form-control" value="<?= $detail['transaksi_detail_identitas']; ?>">
                              <input type="text" id="identitas_id_<?= $key ?>" name="identitas_id[]" style="display: none" value="<?= $detail['identitas_id'] ?>">
                              <ul class="list-group" id="transaksi_detail_identitas_hasil_<?= $key ?>"></ul>
                            </div>
                          </div>
                          <div class="form-group row col-12">
                            <label class="col-md-4">Jumlah Parameter</label>
                            <div class="col-8">
                              <input type="text" id="transaksi_detail_parameter_<?= $key ?>" name="transaksi_detail_parameter[]" placeholder="Parameter Sample" class="form-control" value="<?= $detail['transaksi_detail_parameter'] ?>" onkeypress="return numberOnly(event)">
                            </div>
                          </div>
                          <div class="form-group row col-12">
                            <label class="col-md-4">Deskripsi Parameter Uji / Kalibrasi</label>
                            <div class="col-8">
                              <textarea name="transaksi_detail_deskripsi_parameter[]" id="transaksi_detail_deskripsi_parameter_<?= $key ?>" cols="3" rows="3" class="form-control" placeholder="Analisa Cu, Pb, Uji Aplikasi, Analisa Kimia / Kalibrasi Suhu Range 10 Derajat C, 20 Derajat C"><?= $detail['transaksi_detail_deskripsi_parameter'] ?></textarea>
                            </div>
                          </div>
                          <div class="form-group row col-12">
                            <label class="col-md-4">Catatan Pengajuan</label>
                            <div class="col-8">
                              <textarea name="transaksi_detail_catatan[]" id="transaksi_detail_catatan_<?= $key ?>" cols="3" rows="3" class="form-control" placeholder="Untuk kebutuhan Extra Cek Pabrik NPK 5"><?= $detail['transaksi_detail_catatan'] ?></textarea>
                            </div>
                          </div>
                        </div>
                        <!-- Kiri -->
                        <!-- Kanan -->
                        <div class="col-6">
                          <div class="form-group row col-12">
                            <label class="col-md-4">Attachment</label>
                            <div class="col-8">
                              <input type="file" name="transaksi_detail_attachment[]" id="transaksi_detail_attachment_<?= $key ?>" class="form-control" accept="application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-powerpoint, application/vnd.openxmlformats-officedocument.presentationml.presentation, text/plain, application/pdf, image/*">
                            </div>
                          </div>
                          <div class="form-group row col-12">
                            <label class="col-md-4">Attachment Sebelum</label>
                            <div class="col-6">
                              <input type="text" name="transaksi_detail_attachment_lama[]" id="transaksi_detail_attachment_lama_<?= $key ?>" class="form-control" value="<?= $detail['transaksi_detail_attach'] ?>" readonly>
                            </div>
                            <div class="col-2">
                              <a href="<?= base_url('document/' . $detail['transaksi_detail_attach']) ?>" target="_blank" class="btn btn-info"><i class="fa fa-download"></i></a>
                            </div>
                          </div>
                          <div class="form-group row col-12">
                            <label class="col-md-4">Foto Sample</label>
                            <div class="col-8">
                              <input type="file" name="transaksi_detail_file[]" id="transaksi_detail_file_<?= $key ?>" class="form-control" accept="image/*">
                            </div>
                          </div>
                          <div class="form-group row col-12">
                            <label class="col-md-4">Foto Sample Sebelum</label>
                            <div class="col-8">
                              <input type="text" name="transaksi_detail_file_lama[]" id="transaksi_detail_file_lama_<?= $key ?>" class="form-control" value="<?= $detail['transaksi_detail_file'] ?>" readonly>
                            </div>
                          </div>
                          <div class="form-group row col-12">
                            <label class="col-md-4"></label>
                            <div class="col-8">
                              <a class="btn btn-custom btn-info" href="javascript:;" data-bs-toggle="modal" data-bs-target="#modal_lihat" onclick="fun_lihat('<?= $detail['transaksi_detail_file'] ?>')">Preview</a>
                              <a class="btn btn-custom btn-info" target="_blank" href="<?= base_url() . 'sample/request/downloadFile?file=' . $detail['transaksi_detail_file'] ?>">Download</a>
                              <br />
                              <img src="<?= base_url() . 'document/' . $detail['transaksi_detail_file'] ?>" style="width:200px;border:1px black">
                            </div>
                          </div>
                        </div>
                        <!-- Kanan -->
                      </div>
                    </div>
                  <?php endforeach; ?>
                </div>
                <button class="btn btn-custom btn-success" id="add_item" type="button">Tambah Item</button>
              </div>
              <!-- Body -->
            </div>
            <!-- Detail Item -->

            <!-- Tombol -->
            <div class="card-footer">
              <button type="button" id="close" class="btn btn-custom btn-default border-dark" onclick="history.back()">Kembali</button>
              <button type="button" class="btn btn-custom btn-danger" id="reject">Reject</button>
              <button type="button" class="btn btn-custom btn-success float-right" id="review">Review</button>
              <button type="button" class="btn btn-custom btn-primary" id="edit" style="display: none">Edit</button>
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

<!-- modal lihat -->
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
          <button type="button" class="btn btn-custom btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- modal lihat -->

<!-- modal reject -->
<div class="modal fade" id="modal_reject" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Reject</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form_reject">
          <div class="row">
            <div class="col-12">
              <div class="form-group row col-md-12">
                <label class="col-md-4">Alasan Reject</label>
                <div class="input-group col-md-8">
                  <input type="text" name="transaksi_reject_alasan" id="transaksi_reject_alasan" class="form-control" required>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-custom btn-secondary" data-dismiss="modal" id="close_reject">Close</button>
        <button type="button" class="btn btn-custom btn-danger" id="simpan_reject">Reject</button>
        <button class="btn btn-custom btn-primary" type="button" id="loading_reject" disabled style="display: none;">
          <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
          Loading...
        </button>
      </div>
    </div>
  </div>
</div>
<!-- modal reject -->

<!-- modal review -->
<div class="modal fade" id="modal_agreement" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Note Review</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="form_agreement">
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <div class="form-group row col-12">
                <label class="col-md-4">Note Review </label>
                <div class="input-group col-md-8">
                  <input type="text" id="transaksi_agreement_keterangan" name="transaksi_agreement_keterangan" class="form-control">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-custom btn-secondary" data-dismiss="modal" id="close_review">Close</button>
          <button type="button" class="btn btn-custom btn-success" id="insertReview">Review</button>
          <button class="btn btn-primary" type="button" id="loading_review" disabled style="display: none;">
            <img src="<?php echo site_url('assets_tambahan/ext_img/loading_page_resize_2.gif') ?>" alt="" style="width:30px">
            Loading...
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- modal review -->