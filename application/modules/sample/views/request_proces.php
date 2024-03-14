<style type="text/css">
  /* Important part */
  .modal-content {
    /* overflow-y: initial !important; */
    overflow: scroll !important;
  }

  #loader {
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: url('//upload.wikimedia.org/wikipedia/commons/thumb/e/e5/Phi_fenomeni.gif/50px-Phi_fenomeni.gif') 50% 50% no-repeat rgb(249, 249, 249);
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
          <!-- <div id="loader"></div> -->
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
                <input type="text" id="is_new" name="is_new" style="display: none;" value="n">
                <input type="text" id="transaksi_non_rutin_id" name="transaksi_non_rutin_id" style="display: none" value="">
                <input type="text" id="transaksi_id" name="transaksi_id" style="display: none;" value="<?= create_id() ?>">
                <!-- <input type="text" id="transaksi_detail_id" name="transaksi_detail_id" value="" style="display: none;"> -->
                <!-- <input type="text" id="transaksi_tipe" name="transaksi_tipe" value="<?= $tipe ?>" style="display: none;"> -->
                <input type="text" id="transaksi_status" name="transaksi_status" value="<?= $_GET['status']; ?>" style="display: none;">

                <!-- <div class="col-12">
                    <div class="form-group row col-md-12">
                      <label class="col-md-4">Kepada</label>
                      <div class="input-group col-md-8">
                        <select class="form-control select2" id="keterangan_kepada" name="keterangan_kepada">
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-group row col-md-12">
                      <label class="col-md-4">Dari</label>
                      <div class="input-group col-md-8">
                        <select class="form-control select2" id="keterangan_dari" name="keterangan_dari">
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-group row col-md-12">
                      <label class="col-md-4">Perihal</label>
                      <div class="input-group col-md-8">
                        <input type="text" class="form-control" id="keterangan_perihal" name="keterangan_perihal">
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-group row col-md-12">
                      <label class="col-md-4">Tanggal</label>
                      <div class='input-group date col-md-8' id="keterangan_tanggal">
                        <input name="keterangan_tanggal" id="keterangan_tanggal" class="datetimepicker form-control" type="text" inputmode="none" class="form-control" required="" value="<?= date('Y-m-d') ?>" />
                        <span class="input-group-text">
                          <span class="fa fa-calendar"></span>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-group row col-md-12">
                      <label class="col-md-4">Isi</label>
                      <div class="input-group col-md-8">
                        <textarea class="form-control" id="keterangan_isi" name="keterangan_isi"></textarea>
                      </div>
                    </div>
                  </div> -->

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
                        <label class="col-md-4">Judul *</label>
                        <div class="input-group col-md-8">
                          <input type="text" class="form-control required" id="transaksi_judul" name="transaksi_judul" placeholder="Judul" value="">
                        </div>
                      </div>
                      <div class="form-group row col-12">
                        <label class="col-md-4">Kecepatan Tanggap</label>
                        <div class="input-group col-md-8">
                          <select name="transaksi_kecepatan_tanggap" id="transaksi_kecepatan_tanggap" class="select2 form-control">
                            <option value="Biasa">Biasa</option>
                            <option value="Segera">Segera</option>
                            <option value="Sangat Segera">Sangat Segera</option>
                          </select>
                        </div>
                      </div>
                      <div class="form-group row col-12">
                        <label class="col-md-4">Kode Klasifikasi</label>
                        <div class="input-group col-md-8">
                          <select name="transaksi_klasifikasi_id" id="transaksi_klasifikasi_id" class="select2 form-control"></select>
                        </div>
                      </div>
                      <div class="form-group row col-12">
                        <label class="col-md-4">Sifat</label>
                        <div class="input-group col-md-8">
                          <select name="transaksi_sifat" id="transaksi_sifat" class="select2 form-control">
                            <option value="Rahasia">Rahasia</option>
                            <option value="Biasa">Biasa</option>
                          </select>
                        </div>
                      </div>
                    </div>

                    <div class="col-6">
                      <div class="form-group row col-12">
                        <label class="col-md-4">Drafter</label>
                        <div class="input-group col-md-8">
                          <select name="transaksi_drafter" id="transaksi_drafter" class="select2 form-control"></select>
                        </div>
                      </div>
                      <div class="form-group row col-12">
                        <label class="col-md-4">Reviewer</label>
                        <div class="input-group col-md-8">
                          <select name="transaksi_reviewer" id="transaksi_reviewer" class="select2 form-control"></select>
                        </div>
                      </div>
                      <div class=" form-group row col-12">
                        <label class="col-md-4">Approver</label>
                        <div class="input-group col-md-8">
                          <select name="transaksi_approver" id="transaksi_approver" class="select2 form-control"></select>
                        </div>
                      </div>
                      
                      <div class="form-group row col-12">
                        <label class="col-md-4">Tujuan</label>
                        <div class="input-group col-md-8">
                          <select name="transaksi_tujuan" id="transaksi_tujuan" class="select2 form-control"></select>
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
                        <select class="form-control select2 required" id="peminta_jasa_id" name="peminta_jasa_id">
                        </select>
                      </div>
                    </div>
                    <div class="form-group row col-md-12">
                      <label class="col-md-4">PIC Pengirim Sample</label>
                      <div class="input-group col-md-8">
                        <input type="text" id="transaksi_pic_pengirim_id" name="transaksi_pic_pengirim_id" style="display:none">
                        <input type="text" id="transaksi_pic_seksi_id" name="transaksi_pic_seksi_id" style="display:none">
                        <select name="transaksi_detail_pic_pengirim" id="transaksi_detail_pic_pengirim" class="select2 form-control" onchange="gantiPICPengirim(this.value)"></select>
                      </div>
                    </div>
                    <div class="form-group row col-md-12">
                      <label class="col-md-4">PIC Telepon</label>
                      <div class="input-group col-md-8">
                        <input type="text" class="form-control" id="transaksi_detail_pic_telepon" name="transaksi_detail_pic_telepon" value="<?= $session['user_no_hp'] ?>" placeholder="Telp PIC">
                      </div>
                    </div>
                    <div class="form-group row col-md-12">
                      <label class="col-md-4">Ext Pengirim Sample *</label>
                      <div class="input-group col-md-8">
                        <input type="number" class="form-control required" id="transaksi_detail_ext_pengirim" name="transaksi_detail_ext_pengirim" value="" placeholder="Ext Pengirim Sample">
                      </div>
                    </div>
                    <div class="form-group row col-md-12" style="display:none">
                      <label class="col-md-4">Tanggal Pengajuan *</label>
                      <div class="input-group col-md-8">
                        <input type="date" class="form-control" id="transaksi_tanggal" name="transaksi_tanggal" value="<?= date('Y-m-d H:i:s') ?>" placeholder="Ext Pengirim Sample">
                      </div>
                    </div>
                  </div>
                </div>


                <!-- easy ui -->
              </div>
              <!--               <div class="card-footer">
                <button type="button" id="close" class="btn btn-default" onclick="history.back()">Kembali</button>
                <button type="button" class="btn btn-info" id="draft">Draft</button>
                <button type="button" class="btn btn-primary" id="edit" style="display: none">Edit</button>
                <button type="button" class="btn btn-success" id="ajukan">Ajukan</button>
                <button type="button" class="btn btn-success" id="simpan_ajukan" style="display:none">Ajukan</button>
                <button class="btn btn-primary" type="button" id="loading_form" disabled style="display: none;">
                  <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                  Loading...
                </button>
              </div> -->
              <!-- Body -->
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
                            <input id="transaksi_detail_id" name="transaksi_detail_id[]" value="<?= create_id(); ?>" style="display:none">
                            <input required type="text" class="form-control" id="item_judul" name="item_judul[]" placeholder="Judul" value="<?= $detail['transaksi_detail_judul'] ?>" style=" border:none;border-bottom: 1px solid #1890ff;padding: 5px 10px;  outline: none;">
                          </div>
                          <div class="input-group col-2">
                            <button class="btn btn-danger btn-block" type="button" id="remove_item" onclick="removeItem('<?= $detail['transaksi_detail_id'] ?>')">Hapus</button>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-6">
                          <div class="form-group row col-12">
                            <label class="col-md-4">Jenis Sample</label>
                            <div class="input-group col-md-8">
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
                            <label class="col-md-4">Jenis Pekerjaan</label>
                            <div class="input-group col-md-8">
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
                            <label for="" class="col-md-4">Jumlah Sample</label>
                            <div class="input-group col-8">
                              <input type="text" id="transaksi_detail_jumlah" name="transaksi_detail_jumlah[]" class="form-control" value="<?= $detail['transaksi_detail_jumlah']; ?>">
                            </div>
                          </div>

                          <div class="form-group row col-12">
                            <label for="" class="col-md-4">Identitas Sample</label>
                            <div class="input-group col-8">
                              <input type="text" id="transaksi_detail_identitas" name="transaksi_detail_identitas[]" placeholder="Identitas Sample" class="form-control" value="<?= $detail['transaksi_detail_identitas']; ?>">
                            </div>
                          </div>

                          <div class="form-group row col-12">
                            <label for="" class="col-md-4">Parameter Sample</label>
                            <div class="input-group col-8">
                              <input type="text" id="transaksi_detail_parameter" name="transaksi_detail_parameter[]" placeholder="Parameter Sample" class="form-control" value="<?= $detail['transaksi_detail_parameter'] ?>">
                            </div>
                          </div>

                          <div class="form-group row col-12">
                            <label for="" class="col-md-4">Deskripsi Parameter Uji / Kalibrasi</label>
                            <div class="input-group col-8">
                              <textarea name="transaksi_detail_deskripsi_parameter[]" id="transaksi_detail_deskripsi_parameter" cols="3" rows="3" class="form-control" placeholder="Analisa Cu, Pb, Uji Aplikasi, Analisa Kimia / Kalibrasi Suhu Range 10 Derajat C, 20 Derajat C"><?= $detail['transaksi_detail_deskripsi_parameter'] ?></textarea>
                            </div>
                          </div>

                          <div class="form-group row col-12">
                            <label for="" class="col-md-4">Catatan Pengajuan</label>
                            <div class="input-group col-8">
                              <textarea name="transaksi_detail_catatan[]" id="transaksi_detail_catatan" cols="3" rows="3" class="form-control" placeholder="Untuk kebutuhan Extra Cek Pabrik NPK 5"><?= $detail['transaksi_detail_catatan'] ?></textarea>
                            </div>
                          </div>

                        </div>
                        <div class="col-6">
                          <div class="form-group row col-12">
                            <label for="" class="col-md-4">Attachment</label>
                            <div class="input-group col-8">
                              <input type="file" name="transaksi_detail_attachment[]" id="transaksi_detail_attachment" class="form-control">
                            </div>
                          </div>
                          <div class="form-group row col-12">
                            <label for="" class="col-md-4">Attachment Sebelum</label>
                            <div class="input-group col-8">
                              <input type="text" name="transaksi_detail_attachment_lama" id="transaksi_detail_attachment_lama" class="form-control" value="<?= $detail['transaksi_detail_attach'] ?>" readonly>
                            </div>
                          </div>
                          <div class="form-group row col-12">
                            <label for="" class="col-md-4">Foto Sample</label>
                            <div class="input-group col-8">
                              <input type="file" name="transaksi_detail_file[]" id="transaksi_detail_file" class="form-control">
                            </div>
                          </div>
                          <div class="form-group row col-12">
                            <label for="" class="col-md-4">Foto Sample Sebelum</label>
                            <div class="input-group col-8">
                              <input type="text" name="transaksi_detail_file_lama" id="transaksi_detail_file_lama" class="form-control" value="<?= $detail['transaksi_detail_file'] ?>" readonly>
                            </div>
                          </div>
                          <div class="form-group row col-12" style="display: none;" id="div_petugas">
                            <label for="" class="col-md-4">Petugas</label>
                            <div class="input-group col-8">
                              <select name="transaksi_detail_petugas[]" id="transaksi_detail_petugas" class="form-control" multiple></select>
                            </div>
                          </div>
                          <div class="form-group row col-12" style="display: none;" id="div_disposisi">
                            <label for="" class="col-md-4">Disposisi</label>
                            <div class="input-group col-8">
                              <select name="transaksi_detail_disposisi[]" id="transaksi_detail_disposisi" class="form-control" multiple></select>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php endforeach; ?>
                </div>
              </div>
              <br>
              <button class="btn btn-block btn-success" id="add_item" type="button">Tambah Item Baru</button>
            </div>
            <div class="card-footer">
              <button type="button" id="back" class="btn btn-default" onclick="history.back()">Kembali</button>
              <button type="button" class="btn btn-warning" id="reject">Reject</button>
              <button type="button" class="btn btn-success" id="review" style="display: none;">Review</button>
              <button type="button" class="btn btn-success" id="approve" style="display: none;">Approved</button>
              <button type="button" class="btn btn-success" id="disposisi_vp" style="display:none">Disposisi VP LUK</button>
              <button type="button" class="btn btn-success" id="disposisi_avp" style="display:none">Disposisi AVP PPK</button>
              <button type="button" class="btn btn-success" id="disposisi_pic" style="display:none">Disposisi PIC</button>
              <button type="button" class="btn btn-success" id="disposisi_petugas" style="display:none">Tambah Petugas dan Disposisi Seksi</button>
              <button type="button" class="btn btn-success" id="disposisi_seksi" style="display:none">Disposisi Seksi</button>
              <button type="button" class="btn btn-success" id="close" style="display:none">Close</button>
              <button class="btn btn-primary" type="button" id="loading_form" disabled style="display: none;">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Loading...
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
  <!-- Container Body -->
</div>
<!-- CONTAINER-->