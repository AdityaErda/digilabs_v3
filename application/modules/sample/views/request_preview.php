<link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet">
<!-- <script src="YourJquery source path"></script> -->
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>

<style type="text/css">
  /* Important part */
  .modal-content {
    /* overflow-y: initial !important; */
    overflow: scroll !important;
  }

  /* .modal-body { */
  /* height: 80vh; */
  /* } */
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
          <form id="form_approved">
            <!-- FILTER -->
            <!-- Memorandum -->
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
                <!-- Kiri -->
                <input type="text" id="is_new" name="is_new" style="display:none">
                <!-- <input type="text" id="transaksi_status" name="transaksi_status" style="display:none" value="<?= $_GET['status'] ?>"> -->
                <input type="text" id="transaksi_non_rutin_id" name="transaksi_non_rutin_id" style="display:none" value="<?= $_GET['non_rutin'] ?>">
                <input type="text" id="transaksi_id" name="transaksi_id" style="display: none;" value="<?= create_id() ?>">
                <input type="text" id="transaksi_detail_id" name="transaksi_detail_id" value="" style="display: none;">
                <!-- <input type="text" id="transaksi_tipe" name="transaksi_tipe" value="<?= $tipe ?>" style="display: none;"> -->

                <div class="col-12">
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group row col-12">
                        <label class="col-4">Judul</label>
                        <div class="col-8">
                          <input type="text" class="form-control" id="transaksi_judul" name="transaksi_judul" placeholder="Judul" value="" readonly>
                        </div>
                      </div>
                      <div class="form-group row col-12">
                        <label class="col-4">Kecepatan Tanggap</label>
                        <div class="col-8">
                          <select name="transaksi_kecepatan_tanggap" id="transaksi_kecepatan_tanggap" class="select2 form-control" readonly>
                            <option value="Biasa">Biasa</option>
                            <option value="Segera">Segera</option>
                            <option value="Sangat Segera">Sangat Segera</option>
                          </select>
                        </div>
                      </div>
                      <div class="form-group row col-12">
                        <label class="col-4">Kode Klasifikasi</label>
                        <div class="col-8">
                          <select name="transaksi_klasifikasi_id" id="transaksi_klasifikasi_id" class="select2 form-control"></select>
                        </div>
                      </div>
                      <div class="form-group row col-12">
                        <label class="col-4">Sifat</label>
                        <div class="col-8">
                          <select name="transaksi_sifat" id="transaksi_sifat" class="select2 form-control">
                            <option value="Biasa">Biasa</option>
                            <option value="Rahasia">Rahasia</option>
                          </select>
                        </div>
                      </div>
                    </div>

                    <div class="col-6">
                      <div class="form-group row col-12">
                        <label class="col-4">Drafter</label>
                        <div class="col-8">
                          <input type="text" style="display:none" name="transaksi_drafter_poscode" id="transaksi_drafter_poscode">
                          <select name="transaksi_drafter" id="transaksi_drafter" class="select2 form-control" onchange="gantiDrafter(this.value)"></select>
                        </div>
                      </div>
                      <div class="form-group row col-12">
                        <label class="col-4">Reviewer</label>
                        <div class="col-8">
                          <input type="text" style="display:none" name="transaksi_reviewer_poscode" id="transaksi_reviewer_poscode">
                          <select name="transaksi_reviewer" id="transaksi_reviewer" class="select2 form-control" onchange="gantiReviewer(this.value)"></select>
                        </div>
                      </div>
                      <div class=" form-group row col-12">
                        <label class="col-4">Approver</label>
                        <div class="col-8">
                          <input type="text" style="display:none" name="transaksi_approver_poscode" id="transaksi_approver_poscode">
                          <select name="transaksi_approver" id="transaksi_approver" class="select2 form-control" onchange="gantiApprover(this.value)"></select>
                        </div>
                      </div>

                      <div class="form-group row col-12">
                        <label class="col-4">Tujuan</label>
                        <div class="col-8">
                          <input type="text" style="display:none" name="transaksi_tujuan_poscode" id="transaksi_tujuan_poscode">
                          <select name="transaksi_tujuan" id="transaksi_tujuan" class="select2 form-control" onchange="gantiTujuan(this.value)"></select>
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
                    <div class="form-group row col-12">
                      <label class="col-4">Peminta Jasa*</label>
                      <div class="col-8">
                        <s class="form-control select2" id="peminta_jasa_id" name="peminta_jasa_id">
                        </s readonlyelect>
                      </div>
                    </div>
                    <div class="form-group row col-12">
                      <label class="col-4">PIC Pengirim Sample</label>
                      <div class="col-8">
                        <input type="text" id="transaksi_pic_pengirim_id" name="transaksi_pic_pengirim_id" style="display:none">
                        <input type="text" id="transaksi_pic_pengirim_poscode" name="transaksi_pic_pengirim_poscode" style="display:none">
                        <select name="transaksi_detail_pic_pengirim" id="transaksi_detail_pic_pengirim" class="select2 form-control" onchange="gantiPICPengirim(this.value)"></select>
                      </div>
                    </div>
                    <div class="form-group row col-12">
                      <label class="col-4">PIC Telepon</label>
                      <div class="col-8">
                        <input type="text" class="form-control" id="transaksi_detail_pic_telepon" name="transaksi_detail_pic_telepon" value="<?= $session['user_no_hp'] ?>" placeholder="Telp PIC">
                      </div>
                    </div>
                    <div class="form-group row col-12">
                      <label class="col-4">Ext Pengirim Sample</label>
                      <div class="col-8">
                        <input type="number" class="form-control" id="transaksi_detail_ext_pengirim" name="transaksi_detail_ext_pengirim" value="" placeholder="Ext Pengirim Sample">
                      </div>
                    </div>
                    <div class="form-group row col-12" style="display:none">
                      <label class="col-4">Tanggal Pengajuan</label>
                      <div class="col-8">
                        <input type="date" class="form-control" id="transaksi_tanggal" name="transaksi_tanggal" value="<?= date('Y-m-d H:i:s') ?>" placeholder="Ext Pengirim Sample">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- </form> -->


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
              <div class="card-body">
                <!-- <form id="form_item"> -->
                <?php foreach ($sample_detail as $detail) : ?>
                  <div class="div_item_baru">
                    <div class="row">
                      <!-- Kiri -->
                      <div class="form-group row col-12">
                        <div class="col-12">
                          <input id="transaksi_detail_id" name="transaksi_detail_id[]" value="<?= create_id() ?>" style="display:none">
                          <input type="text" class="form-control" id="item_judul" name="item_judul[]" readonly plac eholder="Judul" value="<?= $detail['transaksi_detail_judul'] ?>" style=" border:none;border-bottom: 1px solid #1890ff;padding: 5px 10px;  outline: none;">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-6">
                        <div class="form-group row col-12">
                          <label class="col-4">Jenis Sample</label>
                          <div class="col-8">
                            <select name="jenis_id[]" id="jenis_id" class="form-control select2">
                              <?php foreach ($sample_jenis as $sample) : ?>
                                <option <?php if ($sample['jenis_id'] == $detail['jenis_id']) {
                                          echo 'selected';
                                        } ?> value="<?= $sample['jenis_id'] ?>"><?= $sample['jenis_nama'] ?></option>
                              <?php endforeach; ?>
                            </select>
                          </div>
                        </div>

                        <div class="form-group row col-12">
                          <label class="col-4">Jenis Pekerjaan</label>
                          <div class="col-8">
                            <select name="jenis_pekerjaan_id[]" id="jenis_pekerjaan_id" class="form-control select2">
                              <?php foreach ($pekerjaan_jenis as $pekerjaan) : ?>
                                <option <?php if ($pekerjaan['sample_pekerjaan_id'] == $detail['jenis_pekerjaan_id']) {
                                          echo 'selected';
                                        } ?> value="<?= $pekerjaan['sample_pekerjaan_id'] ?>"><?= $pekerjaan['sample_pekerjaan_nama']; ?></option>
                              <?php endforeach; ?>
                            </select>
                          </div>
                        </div>

                        <div class="form-group row col-12">
                          <label for="" class="col-4">Jumlah Sample</label>
                          <div class="col-8">
                            <input type="text" id="transaksi_detail_jumlah" name="transaksi_detail_jumlah[]" class="form-control" value="<?= $detail['transaksi_detail_jumlah']; ?>">
                          </div>
                        </div>

                        <div class="form-group row col-12">
                          <label for="" class="col-4">Identitas Sample</label>
                          <div class="col-8">
                            <input type="text" id="transaksi_detail_identitas" name="transaksi_detail_identitas[]" placeholder="Identitas Sample" class="form-control" value="<?= $detail['transaksi_detail_identitas']; ?>">
                          </div>
                        </div>

                        <div class="form-group row col-12">
                          <label for="" class="col-4">Jumlah Parameter</label>
                          <div class="col-8">
                            <input type="text" id="transaksi_detail_parameter" name="transaksi_detail_parameter[]" placeholder="Parameter Sample" class="form-control" value="<?= $detail['transaksi_detail_parameter'] ?>">
                          </div>
                        </div>

                        <div class="form-group row col-12">
                          <label for="" class="col-4">Deskripsi Parameter</label>
                          <div class="col-8">
                            <textarea name="transaksi_detail_deskripsi_parameter[]" id="transaksi_detail_deskripsi_parameter" cols="3" rows="3" class="form-control"><?= $detail['transaksi_detail_deskripsi_parameter'] ?></textarea>
                          </div>
                        </div>

                        <div class="form-group row col-12">
                          <label for="" class="col-4">Catatan Pengajuan</label>
                          <div class="col-8">
                            <textarea name="transaksi_detail_catatan[]" id="transaksi_detail_catatan" cols="3" rows="3" class="form-control"><?= $detail['transaksi_detail_catatan'] ?></textarea>
                          </div>
                        </div>

                      </div>
                      <div class="col-6">
                        <div class="form-group row col-12">
                          <label for="" class="col-4">Attachment</label>
                          <div class="col-8">
                            <input type="text" name="transaksi_detail_attachment_lama" id="transaksi_detail_attachment_lama" class="form-control" value="<?= $detail['transaksi_detail_attach'] ?>" readonly>
                          </div>
                        </div>
                        <div class="form-group row col-12">
                          <label for="" class="col-4">Foto Sample</label>
                          <div class="col-8">
                            <input type="text" name="transaksi_detail_file_lama" id="transaksi_detail_file_lama" class="form-control" value="<?= $detail['transaksi_detail_file'] ?>" readonly>
                          </div>
                        </div>
                        <div class="form-group row col-12">
                          <label for="" class="col-4"></label>
                          <div class="col-8">
                            <a class="btn btn-info btn-custom" href="javascript:;" data-toggle="modal" data-target="#modal_lihat" onclick="fun_lihat('<?= $detail['transaksi_detail_file'] ?>')">Preview</a>
                            <!-- <br>&nbsp; -->
                            <a class="btn btn-info btn-custom" target="_blank" href="<?= base_url() . 'sample/request/downloadFile?file=' . $detail['transaksi_detail_file'] ?>">Download</a>
                            <!-- <br>&nbsp; -->
                            <br>&nbsp;
                            <div class="col-8">
                              <img src="<?= base_url() . 'document/' . $detail['transaksi_detail_file'] ?>" style="width:200px; height:100%; border:1px black">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
                <br>
                <!-- <button class="btn btn-block btn-success" id="add_item" type="button">Tambah Item Baru</button> -->
              </div>
              <div class="card-footer">
                <button type="button" id="back" class="btn btn-custom btn-default border-dark" onclick="kembali_request()">Kembali</button>
                <a class="btn btn-custom btn-success float-right" href="<?= base_url('sample/request/?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) ?>" id="ok">Kirim</a>
                <button type="button" class="btn btn-custom btn-primary" onclick="cetakPreview($('#transaksi_non_rutin_id').val(),'1')" id="print">Cetak</button>
                <button class="btn btn-custom btn-primary" type="button" id="loading_form" disabled style="display: none;">
                  <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                  Loading...
                </button>
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
        </div>
      </div>
    </div>
  </section>
  <!-- Container Body -->
</div>
<!-- CONTAINER-->