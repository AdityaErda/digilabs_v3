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
          <form id="form_lab">
            <!-- FILTER -->
            <!-- Memorandum -->
            <div class="card">
              <!-- Header -->
              <div class="card-header bg-primary">
                <h3 class="card-title">Detail Surat (<?= $sample['transaksi_nomor'] ?>)</h3>
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
                <input type="text" id="transaksi_status" name="transaksi_status" style="display:none" value="<?= $sample['transaksi_status'] ?>">
                <input type="text" id="transaksi_non_rutin_id" name="transaksi_non_rutin_id" style="display:none" value="<?= $sample['transaksi_non_rutin_id'] ?>">
                <input type="text" id="transaksi_id" name="transaksi_id" style="display: none;" value="<?= $sample['transaksi_id'] ?>">
                <!-- <input type="text" id="transaksi_detail_id" name="transaksi_detail_id" value="" style="display: none;"> -->
                <input type="text" id="transaksi_tipe" name="transaksi_tipe" value="<?= $sample['transaksi_tipe'] ?>" style="display: none;">
                <div class="col-12">
                  <div class="form-group row col-md-12" style="display: none;">
                    <label class="col-md-4">Jenis</label>
                    <div class="input-group col-md-8">
                      <select name="transaksi_jenis_surat" id="transaksi_jenis_surat" class="select2 form-control">

                      </select>
                    </div>
                  </div>
                  <div class="form-group row col-md-12" style="display: none;">
                    <label class="col-md-4">Template</label>
                    <div class="input-group col-md-8">
                      <select name="transaksi_template_surat" id="transaksi_template_surat" class="select2 form-control">
                      </select>
                    </div>
                  </div>


                  <div class="row">
                    <div class="col-6">
                      <div class="form-group row col-12">
                        <label class="col-md-4">Judul</label>
                        <div class="input-group col-md-8">
                          <input type="text" class="form-control" id="transaksi_judul" name="transaksi_judul" placeholder="Judul" value="<?= $sample['transaksi_judul'] ?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row col-12">
                        <label class="col-md-4">Kecepatan Tanggap</label>
                        <div class="input-group col-md-8">
                          <input type="text" name="transaksi_kecepatan_tanggap" id="transaksi_kecepatan_tanggap" value="<?= $sample['transaksi_kecepatan_tanggap'] ?>" style="display:none">
                          <select name="transaksi_kecepatan_tanggap_nama" id="transaksi_kecepatan_tanggap_nama" class="select2 form-control" disabled>
                            <option <?php if ($sample['transaksi_kecepatan_tanggap'] == 'Biasa') echo 'selected' ?> value="1">Biasa</option>
                            <option <?php if ($sample['transaksi_kecepatan_tanggap'] == 'Segera') echo 'selected' ?> value="2">Segera</option>
                            <option <?php if ($sample['transaksi_kecepatan_tanggap'] == 'Sangat Segera') echo 'selected' ?> value="3">Sangat Segera</option>
                          </select>
                        </div>
                      </div>
                      <div class="form-group row col-12">
                        <label class="col-md-4">Kode Klasifikasi</label>
                        <div class="input-group col-md-8">
                          <input type="text" id="transaksi_klasifikasi_id" name="transaksi_klasifikasi_id" value="<?= $sample['klasifikasi_id'] ?>" style="display:none">
                          <select name="transaksi_klasifikasi_nama" id="transaksi_klasifikasi_nama" class="select2 form-control" disabled>
                            <?php foreach ($sample_klasifikasi as $klasifikasi) : print_r($klasifikasi); ?>
                              <option <?php if ($klasifikasi['klasifikasi_id'] == $sample['transaksi_klasifikasi_id']) echo 'selected' ?> value="<?= $klasifikasi['klasifikasi_id'] ?>"><?= $klasifikasi['klasifikasi_nama'] . '-' . $klasifikasi['klasifikasi_kode'] ?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                      </div>
                      <div class="form-group row col-12">
                        <label class="col-md-4">Sifat</label>
                        <div class="input-group col-md-8">
                          <input type="text" name="transaksi_sifat" id="transaksi_sifat" value="<?= $sample['transaksi_sifat'] ?>" style="display:none">
                          <select name="transaksi_sifat_nama" id="transaksi_sifat_nama" class="select2 form-control" disabled>
                            <option <?php if ($sample['transaksi_sifat'] == 'Rahasia') echo 'selected' ?> value="1">Rahasia</option>
                            <option <?php if ($sample['transaksi_sifat'] == 'Biasa') echo 'selected' ?> value="0">Biasa</option>
                          </select>
                        </div>
                      </div>
                    </div>

                    <div class="col-6">
                      <div class="form-group row col-12">
                        <label class="col-md-4">Reviewer</label>
                        <div class="input-group col-md-8">
                          <input type="text" style="display:none" name="transaksi_reviewer" id="transaksi_reviewer" value="<?= $sample['nik_reviewer'] ?>">
                          <input type="text" style="display:none" name="transaksi_reviewer_poscode" id="transaksi_reviewer_poscode" value="<?= $sample['transaksi_reviewer_poscode'] ?>">
                          <select name="transaksi_reviewer_nama" id="transaksi_reviewer_nama" class="select2 form-control" disabled>
                            <option><?= $sample['nik_reviewer'] . ' - ' . $sample['nama_reviewer'] . ' - ' . $sample['title_reviewer'] ?></option>
                          </select>
                        </div>
                      </div>
                      <div class=" form-group row col-12">
                        <label class="col-md-4">Approver</label>
                        <div class="input-group col-md-8">
                          <input type="text" style="display:none" name="transaksi_approver" id="transaksi_approver" value="<?= $sample['nik_reviewer'] ?>">
                          <input type="text" style="display:none" name="transaksi_approver_poscode" id="transaksi_approver_poscode" value="<?= $sample['transaksi_approver_poscode'] ?>">
                          <select name="transaksi_approver_nama" id="transaksi_approver_nama" class="select2 form-control" disabled>
                            <option><?= $sample['nik_approver'] . ' - ' . $sample['nama_approver'] . ' - ' . $sample['title_approver'] ?></option>
                          </select>
                        </div>
                      </div>
                      <div class="form-group row col-12">
                        <label class="col-md-4">Drafter</label>
                        <div class="input-group col-md-8">
                          <input type="text" style="display: none;" name="transaksi_drafter" id="transaksi_drafter" value="<?= $sample['nik_drafter'] ?>">
                          <input type="text" style="display: none;" name="transaksi_drafter_poscode" id="transaksi_drafter_poscode" value="<?= $sample['transaksi_drafter_poscode'] ?>">
                          <select name="transaksi_drafter_nama" id="transaksi_drafter_nama" class="select2 form-control" disabled>
                            <option><?= $sample['nik_drafter'] . ' - ' . $sample['nama_drafter'] . ' - ' . $sample['title_drafter'] ?></option>
                          </select>
                        </div>
                      </div>
                      <div class="form-group row col-12">
                        <label class="col-md-4">Tujuan</label>
                        <div class="input-group col-md-8">
                          <input type="text" style="display: none;" name="transaksi_tujuan" id="transaksi_tujuan" value="<?= $sample['nik_tujuan'] ?>">
                          <input type="text" style="display: none;" name="transaksi_tujuan_poscode" id="transaksi_tujuan_poscode" value="<?= $sample['transaksi_tujuan_poscode'] ?>">
                          <select name="transaksi_tujuan_nama" id="transaksi_tujuan_nama" class="select2 form-control" disabled>
                            <option><?= $sample['nik_tujuan'] . ' - ' . $sample['nama_tujuan'] . ' - ' . $sample['title_tujuan'] ?></option>
                          </select>
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
                    <div class="form-group row col-md-12">
                      <label class="col-md-4">Peminta Jasa*</label>
                      <div class="input-group col-md-8">
                        <input type="text" name="peminta_jasa_id" id="peminta_jasa_id" value="<?= $sample['peminta_jasa_id'] ?>" style="display:none">
                        <select class="form-control select2" id="peminta_jasa_nama" name="peminta_jasa_nama" disabled>
                          <option value=""><?= $sample['peminta_jasa_nama'] ?></option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row col-md-12">
                      <label class="col-md-4">PIC Pengirim Sample</label>
                      <div class="input-group col-md-8">
                        <input type="text" id="transaksi_pic_pengirim" name="transaksi_pic_pengirim" style="display:none" value="<?= $sample['transaksi_pic_pengirim_id'] ?>">
                        <input type="text" id="transaksi_pic_pengirim_poscode" name="transaksi_pic_pengirim_poscode" style="display:none" value="<?= $sample['transaksi_pic_poscode'] ?>">
                        <select name="transaksi_detail_pic_pengirim_nama" id="transaksi_detail_pic_pengirim_nama" class="select2 form-control" disabled>
                          <option><?= $sample['nik_pic_pengirim'] . ' - ' . $sample['nama_pic_pengirim'] . ' - ' . $sample['title_pic_pengirim'] ?></option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row col-md-12">
                      <label class="col-md-4">PIC Telepon / WhatsApp</label>
                      <div class="input-group col-md-8">
                        <input type="text" class="form-control" id="transaksi_detail_pic_telepon" name="transaksi_detail_pic_telepon" value="<?= $sample['transaksi_pic_telepon'] ?>" placeholder="Telp PIC" readonly>
                      </div>
                    </div>
                    <div class="form-group row col-md-12">
                      <label class="col-md-4">Ext Pengirim Sample</label>
                      <div class="input-group col-md-8">
                        <input type="text" class="form-control" id="transaksi_detail_ext_pengirim" name="transaksi_detail_ext_pengirim" value="<?= $sample['transaksi_pic_ext'] ?>" placeholder="Ext Pengirim Sample" readonly>
                      </div>
                    </div>
                    <div class="form-group row col-md-12" style="display:none">
                      <label class="col-md-4">Tanggal Pengajuan</label>
                      <div class="input-group col-md-8">
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
                <div class="div_item">
                  <?php foreach ($sample_detail as $detail) : ?>
                    <div class="div_item_baru">
                      <div class="row">
                        <!-- Kiri -->
                        <div class="form-group row col-md-12">
                          <!-- <label class="col-md-4">Nama Item</label> -->
                          <div class="input-group col-10">
                            <input id="transaksi_detail_id_temp" name="transaksi_detail_id_temp[]" value="<?= $detail['transaksi_detail_id'] ?>" style="display:none">
                            <input id="transaksi_detail_id" name="transaksi_detail_id[]" value="<?= create_id() ?>" style="display:none">
                            <input type="text" class="form-control item_judul" id="item_judul" name="item_judul[]" readonly placeholder="Judul" value="<?= $detail['transaksi_detail_judul'] ?>" style=" border:none;border-bottom: 1px solid #1890ff;padding: 5px 10px;  outline: none;">
                          </div>

                          <!-- <div class="input-group col-2">                  -->
                          <button class="btn btn-info" type="button" data-toggle="collapse" data-target="#collapseItem_<?= $detail['transaksi_detail_id'] ?>" aria-controls="collapseItem_<?= $detail['transaksi_detail_id'] ?>">
                            <i class="fas fa-minus"></i>
                          </button>
                          <!-- </div> -->

                          <div class="input-group col-2">
                            <button class="btn btn-custom btn-danger remove_item" type="button" id="remove_item" onclick="removeItem('<?= $detail['transaksi_detail_id'] ?>')">Batalkan</button>
                          </div>
                        </div>
                      </div>

                      <div class="<?php echo ($detail['transaksi_detail_status'] == '3') ? "collapse" : "collapse-show" ?>" id="collapseItem_<?= $detail['transaksi_detail_id'] ?>">
                        <div class="row">
                          <div class="col-6">
                            <div class="form-group row col-12">
                              <label class="col-md-4">Jenis Sample</label>
                              <div class="input-group col-md-8">
                                <select name="jenis_id[]" id="jenis_id" class="form-control select2 jenis_id">
                                  <?php foreach ($sample_jenis as $sample) : ?>
                                    <option <?php if ($sample['jenis_id'] == $detail['jenis_id']) {
                                              echo 'selected';
                                            } ?> value="<?= $sample['jenis_id'] ?>"><?= $sample['jenis_nama'] ?></option>
                                  <?php endforeach; ?>
                                </select>
                              </div>
                            </div>

                            <div class="form-group row col-12">
                              <label class="col-md-4">Jenis Pekerjaan</label>
                              <div class="input-group col-md-8">
                                <select name="jenis_pekerjaan_id[]" id="jenis_pekerjaan_id" class="form-control select2 jenis_pekerjaan_id">
                                  <?php foreach ($pekerjaan_jenis as $pekerjaan) : ?>
                                    <option <?php if ($pekerjaan['sample_pekerjaan_id'] == $detail['jenis_pekerjaan_id']) {
                                              echo 'selected';
                                            } ?> value="<?= $pekerjaan['sample_pekerjaan_id'] ?>"><?= $pekerjaan['sample_pekerjaan_nama']; ?></option>
                                  <?php endforeach; ?>
                                </select>
                              </div>
                            </div>

                            <div class="form-group row col-12">
                              <label for="" class="col-md-4">Jumlah Sample</label>
                              <div class="input-group col-8">
                                <input type="text" id="transaksi_detail_jumlah" name="transaksi_detail_jumlah[]" class="form-control transaksi_detail_jumlah" value="<?= $detail['transaksi_detail_jumlah']; ?>">
                              </div>
                            </div>

                            <div class="form-group row col-12">
                              <label for="" class="col-md-4">Identitas Sample</label>
                              <div class="input-group col-8">
                                <input type="text" id="transaksi_detail_identitas" name="transaksi_detail_identitas[]" placeholder="Identitas Sample" class="form-control transaksi_detail_identitas" value="<?= $detail['transaksi_detail_identitas']; ?>">
                              </div>
                            </div>

                            <div class="form-group row col-12">
                              <label for="" class="col-md-4">Parameter Sample</label>
                              <div class="input-group col-8">
                                <input type="text" id="transaksi_detail_parameter" name="transaksi_detail_parameter[]" placeholder="Parameter Sample" class="form-control transaksi_detail_parameter" value="<?= $detail['transaksi_detail_parameter'] ?>">
                              </div>
                            </div>

                            <div class="form-group row col-12">
                              <label for="" class="col-md-4">Deskripsi Parameter Uji / Kalibrasi</label>
                              <div class="input-group col-8">
                                <textarea name="transaksi_detail_deskripsi_parameter[]" id="transaksi_detail_deskripsi_parameter" cols="3" rows="3" class="form-control transaksi_detail_deskripsi_parameter" placeholder="Analisa Cu, Pb, Uji Aplikasi, Analisa Kimia / Kalibrasi Suhu Range 10 Derajat C, 20 Derajat C"><?= $detail['transaksi_detail_deskripsi_parameter'] ?></textarea>
                              </div>
                            </div>

                            <div class="form-group row col-12">
                              <label for="" class="col-md-4">Catatan Pengajuan</label>
                              <div class="input-group col-8">
                                <textarea name="transaksi_detail_catatan[]" id="transaksi_detail_catatan" cols="3" rows="3" class="form-control transaksi_detail_catatan" placeholder="Untuk kebutuhan Extra Cek Pabrik NPK 5"><?= $detail['transaksi_detail_catatan'] ?></textarea>
                              </div>
                            </div>

                          </div>
                          <div class="col-6">
                            <div class="form-group row col-12 div_attachment">
                              <label for="" class="col-md-4">Attachment</label>
                              <div class="input-group col-8">
                                <input type="file" name="transaksi_detail_attachment[]" id="transaksi_detail_attachment" class="form-control transaksi_detail_attachment">
                              </div>
                            </div>
                            <div class="form-group row col-12 div_old_attachment">
                              <label for="" class="col-md-4 div_old_attachment_title">Attachment Sebelum</label>
                              <div class="input-group col-6">
                                <input type="text" name="transaksi_detail_attachment_lama[]" id="transaksi_detail_attachment_lama" class="form-control" value="<?= $detail['transaksi_detail_attach'] ?>" readonly>
                              </div>
                              <div class="input-group col-2">
                                <a href="<?php echo site_url('document/' . $detail['transaksi_detail_attach']) ?>" class="btn btn-info" target="_blank"><i class="fa fa-download"></i></a>
                              </div>
                            </div>
                            <div class="form-group row col-12 div_foto">
                              <label for="" class="col-md-4">Foto Sample</label>
                              <div class="input-group col-8">
                                <input type="file" name="transaksi_detail_file[]" id="transaksi_detail_file" class="form-control transaksi_detail_file">
                              </div>
                            </div>
                            <div class="form-group row col-12 div_old_foto">
                              <label for="" class="col-md-4 div_old_foto_title">Foto Sample Sebelum</label>
                              <div class="input-group col-8">
                                <input type="text" name="transaksi_detail_file_lama[]" id="transaksi_detail_file_lama" class="form-control transaksi_detail_file_lama" value="<?= $detail['transaksi_detail_file'] ?>" readonly>
                              </div>
                            </div>
                            <div class="form-group row col-12">
                              <label for="" class="col-md-4"></label>
                              <div class="col-8">
                                <a class="btn btn-custom btn-info" href="javascript:;" data-toggle="modal" data-target="#modal_lihat" onclick="fun_lihat('<?= $detail['transaksi_detail_file'] ?>')">Preview</a>
                                <!-- <br>&nbsp; -->
                                <a class="btn btn-custom btn-info" target="_blank" href="<?= base_url() . 'sample/request/downloadFile?file=' . $detail['transaksi_detail_file'] ?>">Download</a>
                                <!-- <br>&nbsp; -->
                                <br />&nbsp;
                                <div class="col-8">
                                  <img src="<?= base_url() . 'document/' . $detail['transaksi_detail_file'] ?>" style="width:200px; height:100%; border:1px black">
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php endforeach; ?>
                </div>
                <br>
                <button class="btn btn-custom btn-success add_item" id="add_item" type="button">Tambah Item</button>
              </div>
            </div>
            <div class="card-footer">
              <button type="button" id="close" class="btn btn-custom btn-default border-dark" onclick="history.back()">Kembali</button>
              <button type="button" class="btn btn-custom btn-danger" id="reject">Reject</button>
              <button type="button" class="btn btn-custom btn-success float-right" id="disposisi_avp" style="display:none" data-target="#modal_disposisi" data-toggle="modal" onclick="disposisiAVP('<?= $_GET['non_rutin'] ?>','<?= $_GET['status'] ?>');">Disposisi AVP</button>
              <button type="button" class="btn btn-custom btn-success float-right" id="disposisi_seksi" stype="display:none">Disposisi Seksi</button>
              <button type="button" class="btn btn-custom btn-success float-right" id="disposisi_seksi_chemlat" data-target="#modal_disposisi_seksi_chemlat" data-toggle="modal" stype="display:none" onclick="disposisiSeksiChemlat('<?= $_GET['non_rutin'] ?>','<?= $_GET['status'] ?>')">Disposisi Seksi</button>
              <button type=" button" class="btn btn-custom btn-primary" id="edit" style="display: none">Edit</button>
              <button class="btn btn-custom btn-primary" type="button" id="loading_form" disabled style="display: none;">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Loading...
              </button>
            </div>
        </div>
        </form>
        <!-- Modal Disposisi -->
        <div class="modal fade" id="modal_disposisi">
          <div class="modal-dialog modal-xl">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title text-center w-100" id="exampleModalLabel">Disposisi AVP</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form id="form_disposisi_avp">
                <div class="modal-body">
                  <table id="table_disposisi" class="table table-bordered table-striped " width="100%">
                    <thead>
                      <tr>
                        <th>Jenis Sample</th>
                        <th>Jumlah Sample</th>
                        <th>Identitas Sample</th>
                        <th>Keterangan</th>
                        <th>Parameter Sample</th>
                        <th>Foto Sample</th>
                        <th class="text-center">Disposisi AVP</th>
                      </tr>
                    </thead>
                  </table>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-custom btn-secondary" data-dismiss="modal" id="close_disposisi_avp">Close</button>
                  <button type="button" class="btn btn-custom btn-success" id="simpan_disposisi_avp">Disposisi</button>
                  <!-- <button type="button" class="btn btn-custom btn-primary">Save changes</button> -->
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="modal fade" id="modal_disposisi_seksi">
          <div class="modal-dialog modal-xl">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Disposisi Seksi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form id="form_disposisi_seksi">
                <div class="modal-body">
                  <table id="table_disposisi_seksi" class="table table-bordered table-striped table_disposisi_seksi" width="100%">
                    <thead>
                      <tr>
                        <th>Jenis Sample</th>
                        <th>Jumlah Sample</th>
                        <!-- <th>Jenis Sample</th> -->
                        <th>Identitas Sample</th>
                        <th>Keterangan</th>
                        <th>Parameter Sample</th>
                        <th>Foto Sample</th>
                        <th>Disposisi Seksi</th>
                        <!-- <th>Disposisi Seksi</th> -->
                      </tr>
                    </thead>
                  </table>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-custom btn-secondary" data-dismiss="modal" id="close_disposisi_avp">Close</button>
                  <button type="button" class="btn btn-custom btn-success" id="simpan_disposisi_seksi">Disposisi</button>
                  <!-- <button type="button" class="btn btn-custom btn-primary">Save changes</button> -->
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="modal fade" id="modal_disposisi_seksi_chemlat">
          <div class="modal-dialog modal-xl" style="min-width: 1200px;max-width: 1250px;">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Disposisi Seksi dan Petugas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form id="form_disposisi_seksi_chemlat">
                <div class="modal-body">
                  <table id="table_disposisi_seksi_chemlat" class="table table-bordered table-striped table_disposisi_seksi_chemlat" width="100%">
                    <thead>
                      <tr>
                        <th>Jenis Sample</th>
                        <th>Jumlah Sample</th>
                        <!-- <th>Jenis Sample</th> -->
                        <th>Identitas Sample</th>
                        <th>Keterangan</th>
                        <th>Parameter Sample</th>
                        <th>Foto Sample</th>
                        <th>Disposisi Seksi</th>
                        <th>Petugas Sampling</th>
                        <th>Tanggal Sampling</th>
                        <!-- <th>Disposisi Seksi</th> -->
                      </tr>
                    </thead>
                  </table>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-custom btn-secondary" data-dismiss="modal" id="close_disposisi_avp">Close</button>
                  <button type="button" class="btn btn-custom btn-success" id="simpan_disposisi_seksi_chemlat">Disposisi</button>
                  <!-- <button type="button" class="btn btn-custom btn-primary">Save changes</button> -->
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- Modal Disposisi -->
        <!-- Modal Disposisi -->
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
                <button type="button" class="btn btn-custom btn-primary" id="simpan_reject">Reject</button>
                <button class="btn btn-custom btn-primary" type="button" id="loading_reject" disabled style="display: none;">
                  <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                  Loading...
                </button>
              </div>
            </div>
          </div>
        </div>
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
                  <button type="button" id="close" class="btn btn-custom btn-default" data-dismiss="modal">Close</button>
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