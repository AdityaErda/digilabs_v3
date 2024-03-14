<?php $session = $this->session->userdata(); ?>

<style type="text/css">
  /*  table.dataTable.fixedHeader-floating{position:absolute !important}*/

  /*  table.dataTable.fixedHeader-floating{position:absolute !important}*/
</style>

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
        <!-- FILTER -->
        <div class="col-md-12">
          <div class="col-md-12">
            <div class="card">
              <!-- Header -->
              <div class="card-header bg-warning">
                <h3 class="card-title">Filter <?= $judul ?></h3>
              </div>
              <!-- Header -->
              <!-- Body -->
              <form id="filter">
                <div class="card-body">
                  <div class="row">
                    <div class="form-group col-md-3">
                      <label class="col-md-12">Periode Awal</label>
                      <div class='input-group date' id="tanggal_cari_awal">
                        <input name="tanggal_cari_awal" id="tanggal_cari_awal" class="datetimepicker form-control" type="text" inputmode="none" required="" value="<?= date('Y-m-d') ?>" />
                        <span class="input-group-text">
                          <span class="fa fa-calendar"></span>
                        </span>
                      </div>
                    </div>
                    <div class="form-group col-md-3">
                      <label class="col-md-12">Periode Akhir</label>
                      <div class='input-group date' id="tanggal_cari_akhir">
                        <input name="tanggal_cari_akhir" id="tanggal_cari_akhir" class="datetimepicker form-control" type="text" inputmode="none" required="" value="<?= date('Y-m-d') ?>" />
                        <span class="input-group-text">
                          <span class="fa fa-calendar"></span>
                        </span>
                      </div>
                    </div>
                    <div class="form-group col-md-3">
                      <label class="col-md-12">Jenis Sample</label>
                      <div class="input-group col-md-12">
                        <select class="form-control select2" id="transaksi_tipe" name="transaksi_tipe">
                          <option value="-">Semua Jenis Sample</option>
                          <option value="E">Sample Eksternal</option>
                          <option value="I">Sample Internal</option>
                          <option value="R">Sample Rutin</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group col-md-3">
                      <label class="col-md-12">&nbsp;</label>
                      <input type="submit" class="btn btn-success pull-right col-md-7" id="cari" value="cari">
                    </div>
                  </div>
                </div>
              </form>
              <!-- Body -->
            </div>
          </div>
        </div>
        <!-- FILTER -->
        <!-- DIV DATA DIRI -->
        <div class="col-md-12">
          <div class="col-md-12">
            <div class="card">
              <!-- Header -->
              <div class="card-header bg-success">
                <h3 class="card-title"><?= $judul ?></h3>
              </div>
              <!-- Header -->
              <!-- Body -->
              <div class="card-body">
                <!-- Table -->
                <table id="table" class="table table-bordered table-striped nowrap" width="100%">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Tanggal Pengajuan</th>
                      <th>Nomor Surat</th>
                      <th>Nomor Sample</th>
                      <th>Klasifikasi Sample</th>
                      <th>Status</th>
                      <th>Peminta Jasa</th>
                      <th>Seksi</th>
                      <th>No. Sertifikat</th>
                      <th>Jenis Sample</th>
                      <th>Identitas</th>
                      <th>Attachment Peminta Jasa</th>
                      <th>Foto</th>
                      <th>Detail</th>
                      <!-- <?php if ($session['role_id'] == '1' || $session['role_id'] == '79d5b34a78b48d85eb1b65249fca73704dc49665') { ?>
                        <th>Edit</th>
                        <?php } ?> -->
                      <?php if ($session['role_id'] == '1' || $session['role_id'] == '79d5b34a78b48d85eb1b65249fca73704dc49665') { ?>
                        <th>Batal / Hapus</th>
                      <?php } ?>
                      <th>QRCode Progress</th>
                      <th>Close Sample</th>
                      <th>Cetak Konsep</th>
                      <?php if ($session['role_id'] == '1' || $session['role_id'] == '79d5b34a78b48d85eb1b65249fca73704dc49665') { ?>
                        <th>Edit Surat</th>
                      <?php } ?>
                      <?php if ($session['role_id'] == '1' || $session['role_id'] == '79d5b34a78b48d85eb1b65249fca73704dc49665') { ?>
                        <th>Reset Logsheet</th>
                      <?php } ?>
                    </tr>
                  </thead>
                </table>
                <!-- Table -->
                <!-- Modal lihat file -->
                <div class="modal fade" id="modal">
                  <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title" id="judul_lihat"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <form id="form_modal">
                        <div class="modal-body">
                          <div class="card-body row" id="div_document" style="height: 400px;">
                          </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                          <button type="button" id="close" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                      </form>
                    </div>
                    <!-- /.modal-content -->
                  </div>
                  <!-- /.modal-dialog -->
                </div>
                <!-- Modal lihat file -->
                <!-- Modal close sample-->
                <div class="modal fade" id="modal_close_sample">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title" id="judul_edit">Close Sample</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <form id="form_close_sample">
                        <input type="text" id="transaksi_detail_id_close_sample_temp" name="transaksi_detail_id_close_sample_temp" style="display: none;">
                        <input type="text" id="transaksi_detail_id_close_sample" name="transaksi_detail_id_close_sample" style="display: none;">
                        <input type="text" id="transaksi_id_close_sample" name="transaksi_id_close_sample" style="display: none;">
                        <input type="text" id="transaksi_detail_status_close_sample" name="transaksi_detail_status_close_sample" style="display: none;">
                        <input type="text" id="logsheet_id_close_sample" name="logsheet_id_close_sample" style="display: none;">
                        <input type="text" id="transaksi_tipe_close" name="transaksi_tipe_close" style="display: none;">
                        <div class="modal-body">
                          <div class="card-body">
                            <div class="form-group row">
                              <label class="col-md-4">Nomor Surat / Sertifikat</label>
                              <div class="input-group col-md-8">
                                <textarea name="transaksi_detail_nomor_close_sample" id="transaksi_detail_nomor_close_sample" class="form-control" cols="30" rows="5"></textarea>
                              </div>
                            </div>
                            <div id="div_file_close" style="display: none;">
                              <div class="form-group row">
                                <label class="col-md-4">File</label>
                                <div class="input-group col-md-8">
                                  <input type="file" class="form-control" name="transaksi_detail_file" id="transaksi_detail_file">
                                </div>
                              </div>
                            </div>
                            <div class="form-group row">
                              <label class="col-md-4">Tanggal Close Sample</label>
                              <div class="input-group col-md-8">
                                <div class="input-group-prepend">
                                  <span class="input-group-text">
                                    <i class="far fa-calendar-alt"></i>
                                  </span>
                                </div>
                                <input type="text" class="form-control float-right tanggal2" id="transaksi_detail_tgl_pengajuan" name="transaksi_detail_tgl_pengajuan" class="form-control">
                              </div>
                            </div>

                          </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                          <button type="button" id="closed_sample" class="btn btn-default" data-dismiss="modal" onclick="fun_closed_sample();">Close</button>
                          <button type="submit" id="close_sample" class="btn btn-success">Close Sample</button>
                          <button class="btn btn-primary" type="button" id="loading_close_sample" disabled style="display: none;">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                          </button>
                        </div>
                      </form>
                    </div>
                    <!-- /.modal-content -->
                  </div>
                  <!-- /.modal-dialog -->
                </div>
                <!-- Modal close sample -->
                <!-- Modal Foto -->
                <div class="modal fade" id="modal_foto">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title" id="judul_lihat_foto"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <form id="form_modal">
                        <div class="modal-body">
                          <div class="card-body row" id="div_document_foto" style="height: 400px;">
                          </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                          <button type="button" id="close" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                      </form>
                    </div>
                    <!-- /.modal-content -->
                  </div>
                  <!-- /.modal-dialog -->
                </div>
                <!-- Modal Foto -->
                <!-- Modal Detail -->
                <div class="modal fade" id="modal_detail_perjalanan">
                  <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title" id="judul_detail"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <div class="card-body">
                          <table id="table_detail" width="100%" class="table table-bordered table-striped" width="100%">
                            <thead>
                              <tr>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Estimasi</th>
                                <th>Jenis Sample</th>
                                <th>Jumlah Sample</th>
                                <th>Identitas Sample</th>
                                <th>Keterangan</th>
                                <th>Parameter Sample</th>
                                <th>PIC</th>
                                <th>No. Sertifikat</th>
                                <th>Petugas</th>
                                <th>Disposisi</th>
                              </tr>
                            </thead>
                          </table>
                        </div>
                      </div>
                    </div>
                    <!-- /.modal-content -->
                  </div>
                  <!-- /.modal-dialog -->
                </div>
                <!-- Modal Detail -->
                <!-- Modal History -->
                <div class="modal fade" id="modal_history_logsheet">
                  <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">History Log Sheet</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <div class="card-body">
                          <table id="table_history_logsheet" width="100%" class="table table-bordered table-striped" width="100%">
                            <thead>
                              <tr>
                                <th>Tanggal</th>
                                <!-- <th>Parameter Rumus</th> -->
                                <th>Rumus</th>
                                <th>Nilai Perhitungan</th>
                                <th>Hasil Perhitungan</th>
                                <th>Petugas</th>
                              </tr>
                            </thead>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Modal History -->
                <!-- Modal Edit -->
                <div class="modal fade" id="modal_edit">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title" id="judul_edit"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <form id="form_edit">
                        <input type="text" id="transaksi_detail_id" name="transaksi_detail_id" style="display:none">
                        <div class="modal-body">
                          <div class="card-body">
                            <div class="form-group row">
                              <label class="col-md-4">Note</label>
                              <div class="input-group col-md-8">
                                <input type="text" id="transaksi_detail_note" name="transaksi_detail_note" class="form-control">
                              </div>
                            </div>
                            <div class="form-group row">
                              <label class="col-md-4">Tanggal Memo</label>
                              <div class="input-group col-md-8">
                                <div class="input-group-prepend">
                                  <span class="input-group-text">
                                    <i class="far fa-calendar-alt"></i>
                                  </span>
                                </div>
                                <input type="text" class="form-control float-right tanggal2" id="transaksi_detail_tgl_memo" name="transaksi_detail_tgl_memo">
                              </div>
                            </div>
                            <div class="form-group row">
                              <label class="col-md-4">Nomor Memo</label>
                              <div class="input-group col-md-8">
                                <input type="text" id="transaksi_detail_no_memo" name="transaksi_detail_no_memo" class="form-control">
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                          <button type="button" id="closed" class="btn btn-default" data-dismiss="modal" onclick="fun_close();">Close</button>
                          <button type="submit" id="edit" class="btn btn-primary">Edit</button>
                          <button class="btn btn-primary" type="button" id="loading" disabled style="display: none;">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                          </button>
                        </div>
                      </form>
                    </div>
                    <!-- /.modal-content -->
                  </div>
                  <!-- /.modal-dialog -->
                </div>
                <!-- Modal Edit -->
                <!-- Modal Edit -->
                <div class="modal fade" id="modal_batal">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title" id="judul_batal"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <form id="form_batal">
                        <input type="text" id="transaksi_id_batal" name="transaksi_id_batal" style="display:none">
                        <input type="text" id="transaksi_detail_id_batal" name="transaksi_detail_id_batal" style="display:none">
                        <input type="text" id="transaksi_detail_id_temp_batal" name="transaksi_detail_id_temp_batal" style="display:none">
                        <input type="text" id="transaksi_non_rutin_id_batal" name="transaksi_non_rutin_id_batal" style="display:none">
                        <input type="text" id="transaksi_detail_status_batal" name="transaksi_detail_status_batal" style="display:none">
                        <input type="text" id="transaksi_tipe_batal" name="transaksi_tipe_batal" style="display:none">
                        <div class="modal-body">
                          <div class="card-body">
                            <div class="form-group row">
                              <label class="col-md-4">Alasan Pembatalan</label>
                              <div class="input-group col-md-8">
                                <textarea name="transaksi_detail_reject_alasan_batal" id="transaksi_detail_reject_alasan_batal" class="form-control"></textarea>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                          <button type="button" id="close_batal" class="btn btn-default" data-dismiss="modal" onclick="fun_close_batal();">Close</button>
                          <button type="button" id="simpan_batal" class="btn btn-primary">Ya, Batal</button>
                          <button class="btn btn-primary" type="button" id="loading_batal" disabled style="display: none;">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                          </button>
                        </div>
                      </form>
                    </div>
                    <!-- /.modal-content -->
                  </div>
                  <!-- /.modal-dialog -->
                </div>
                <!-- Modal Edit -->
                <!-- Modal Detail Baru-->
                <div class="modal fade" id="modal_detail">
                  <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title"><?= $judul ?> - Identitas Surat</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <form id="form_modal">
                        <input type="text" id="is_new" name="is_new" style="display:none">
                        <input type="text" id="transaksi_non_rutin_id" name="transaksi_non_rutin_id" style="display:none">
                        <input type="text" id="transaksi_id" name="transaksi_id" value="" style="display: none;">
                        <input type="text" id="transaksi_detail_id" name="transaksi_detail_id" value="" style="display: none;">
                        <!-- <input type="text" id="transaksi_tipe" name="transaksi_tipe" value="<?= $tipe ?>" style="display: none;"> -->
                        <div class="modal-body">
                          <div class="card-body row">
                            <!-- Kiri -->
                            <div class="col-6">
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Judul</label>
                                <div class="input-group col-md-8">
                                  <input class="form-control" id="transaksi_judul" name="transaksi_judul" disabled>
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Peminta Jasa</label>
                                <div class="input-group col-md-8">
                                  <input class="form-control" id="peminta_jasa_id" name="peminta_jasa_id" disabled>
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Jenis Pekerjaan</label>
                                <div class="input-group col-md-8">
                                  <input class="form-control" id="jenis_pekerjaan_id" name="jenis_pekerjaan_id" disabled>
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">PIC Pengirim Sample</label>
                                <div class="input-group col-md-8">
                                  <input type="text" class="form-control" id="transaksi_detail_pic_pengirim" name="transaksi_detail_pic_pengirim" value="" placeholder="PIC Pengirim Sample" disabled>
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Kecepatan Tanggap</label>
                                <div class="input-group col-md-8">
                                  <input type="text" class="form-control" id="transaksi_kecepatan_tanggap" name="transaksi_kecepatan_tanggap" value="" placeholder="Kecepatan Tanggap" disabled>
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Sifat</label>
                                <div class="input-group col-md-8">
                                  <input type="text" class="form-control" id="transaksi_sifat" name="transaksi_sifat" value="" placeholder="Sifat" disabled>
                                </div>
                              </div>
                            </div>
                            <!-- Kiri -->
                            <!-- Kanan -->
                            <div class="col-6">
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Ext Pengirim Sample</label>
                                <div class="input-group col-md-8">
                                  <input type="number" class="form-control" id="transaksi_detail_ext_pengirim" name="transaksi_detail_ext_pengirim" value="" placeholder="Ext Pengirim Sample" disabled>
                                </div>
                              </div>
                              <div class="form-group row col-md-12" style="display:none">
                                <label class="col-md-4">Tgl Pengajuan</label>
                                <div class="input-group col-md-8">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text">
                                      <i class="far fa-calendar-alt"></i>
                                    </span>
                                  </div>
                                  <input type="text" class="form-control float-right" id="transaksi_detail_tgl_pengajuan" name="transaksi_detail_tgl_pengajuan" value="<?= date('d-m-Y H:i:s') ?>" disabled>
                                </div>
                              </div>
                              <!-- <div class="form-group row col-md-12">
                                <label class="col-md-4">Tgl Memo</label>
                                <div class="input-group col-md-8">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text">
                                      <i class="far fa-calendar-alt"></i>
                                    </span>
                                  </div>
                                  <input type="text" class="form-control float-right tanggal" id="transaksi_detail_tgl_memo" name="transaksi_detail_tgl_memo" value="" disabled="">
                                </div>
                              </div> -->
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Kode Klasifikasi</label>
                                <div class="input-group col-md-8">
                                  <input name="transaksi_klasifikasi_id" id="transaksi_klasifikasi_id" class="form-control" disabled="">
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Drafter</label>
                                <div class="input-group col-md-8">
                                  <input name="transaksi_drafter" id="transaksi_drafter" class="form-control" disabled="">
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Reviewer</label>
                                <div class="input-group col-md-8">
                                  <input name="transaksi_reviewer" id="transaksi_reviewer" class="form-control" disabled="">
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Approver</label>
                                <div class="input-group col-md-8">
                                  <input name="transaksi_approver" id="transaksi_approver" class="form-control" disabled="">
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Tujuan</label>
                                <div class="input-group col-md-8">
                                  <input name="transaksi_tujuan" id="transaksi_tujuan" class="form-control" disabled="">
                                </div>
                              </div>
                            </div>
                            <!-- Kanan -->
                          </div>
                          <!-- easy ui -->
                          <div class="form-group" style="display:none">
                            <table id="modal_table_detail" width="100%" class="table table-bordered table-striped">
                              <thead>
                                <tr>
                                  <th>Jenis Sample</th>
                                  <th>Jumlah Sample</th>
                                  <th>Identitas Sample</th>
                                  <th>Keterangan</th>
                                  <th>Parameter Sample</th>
                                </tr>
                              </thead>
                            </table>
                          </div>
                          <!-- easy ui -->
                        </div>
                        <div class="modal-footer justify-content-between">
                          <button type="button" id="close" class="btn btn-default" data-dismiss="modal" onclick="fun_close()">Close</button>
                          <!-- <button type="submit" class="btn btn-success" id="simpan">Simpan</button> -->
                          <!-- <button type="submit" class="btn btn-primary" id="edit" style="display: none">Edit</button> -->
                          <button class="btn btn-primary" type="button" id="loading_form" disabled style="display: none;">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                          </button>
                        </div>
                      </form>
                    </div>
                    <!-- /.modal-content -->
                  </div>
                  <!-- /.modal-dialog -->
                </div>
                <!-- Modal Detail Baru-->
              </div>
              <!-- Modal Reset Logsheet -->
              <div class="modal fade" id="modal_reset_logsheet">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title" id="judul_reset_logsheet"></h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <form id="form_reset_logsheet">
                      <input type="text" id="transaksi_id_reset_logsheet" name="transaksi_id_reset_logsheet" style="display:none">
                      <input type="text" id="transaksi_detail_id_reset_logsheet" name="transaksi_detail_id_reset_logsheet" style="display:none">
                      <input type="text" id="transaksi_detail_id_temp_reset_logsheet" name="transaksi_detail_id_temp_reset_logsheet" style="display:none">
                      <input type="text" id="transaksi_non_rutin_id_reset_logsheet" name="transaksi_non_rutin_id_reset_logsheet" style="display:none">
                      <input type="text" id="transaksi_detail_status_reset_logsheet" name="transaksi_detail_status_reset_logsheet" style="display:none">
                      <input type="text" id="transaksi_tipe_reset_logsheet" name="transaksi_tipe_reset_logsheet" style="display:none">
                      <div class="modal-body">
                        <div class="card-body">
                          <div class="form-group row">
                            <label class="col-md-4">Alasan Reset Logsheet</label>
                            <div class="input-group col-md-8">
                              <textarea name="transaksi_detail_reject_alasan_reset_logsheet" id="transaksi_detail_reject_alasan_reset_logsheet" class="form-control"></textarea>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer justify-content-between">
                        <button type="button" id="close_reset_logsheet" class="btn btn-default" data-dismiss="modal" onclick="fun_close_reset_logsheet();">Close</button>
                        <button type="button" id="simpan_reset_logsheet" class="btn btn-primary">Reset</button>
                        <button class="btn btn-primary" type="button" id="loading_reset_logsheet" disabled style="display: none;">
                          <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                          Loading...
                        </button>
                      </div>
                    </form>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>
              <!-- Modal Reset Logsheet -->
              <!-- modal edit surat -->
              <div id="modal_edit_surat" class="modal fade" tabindex="-1">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Edit Data Surat</h5>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <form id="form_edit_surat">
                      <div class="modal-body">
                        <div class="row">
                          <div class="col-12">
                            <div class="form-group row col-md-12">
                              <label class="col-md-4">Tipe Dokumen</label>
                              <div class="input-group col-md-8">
                                <select name="typeId" id="typeId" class="form-control select2" onChange="func_change_template(this.value)" readonly></select>
                              </div>
                            </div>
                          </div>
                          <div class="col-12">
                            <div class="form-group row col-md-12">
                              <label class="col-md-4">Template Dokumen</label>
                              <div class="input-group col-md-8">
                                <select name="templateId" id="templateId" class="form-control select2" readonly></select>
                              </div>
                            </div>
                          </div>
                          <div class="col-12">
                            <div class="form-group row col-md-12">
                              <label class="col-md-4">Klasifikasi Dokumen</label>
                              <div class="input-group col-md-8">
                                <select name="classId" id="classId" class="form-control select2"></select>
                              </div>
                            </div>
                          </div>
                          <div class="col-12">
                            <div class="form-group row col-md-12">
                              <label class="col-md-4">Sifat Dokumen</label>
                              <div class="input-group col-md-8">
                                <select name="category" id="category" class="form-control select2">
                                  <option value="Rahasia">Rahasia</option>
                                  <option value="Biasa">Biasa</option>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="col-12">
                            <div class="form-group row col-md-12">
                              <label class="col-md-4">Kecepatan Tanggap</label>
                              <div class="input-group col-md-8">
                                <select name="responseSpeed" id="responseSpeed" class="form-control select2">
                                  <option value="Biasa">Biasa</option>
                                  <option value="Segera">Segera</option>
                                  <option value="Sangat Segera">Sangat Segera</option>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="col-12">
                            <div class="form-group row col-md-12">
                              <label class="col-md-4">Judul</label>
                              <div class="input-group col-md-8">
                                <input type="text" name="title" id="title" class="form-control">
                              </div>
                            </div>
                          </div>
                          <div class="col-12">
                            <div class="form-group row col-md-12">
                              <label class="col-md-4">Drafter</label>
                              <div class="input-group col-md-8">
                                <input name="drafterPoscode" id="drafterPoscode" style="display:none">
                                <select name="drafterId" id="drafterId" class="select2 form-control" onChange="ganti_drafter_identitas(this.value)"></select>
                              </div>
                            </div>
                          </div>
                          <div class="col-12">
                            <div class="form-group row col-md-12">
                              <label class="col-md-4">Reviewer</label>
                              <div class="input-group col-md-8">
                                <input name="reviewerPoscode" id="reviewerPoscode" style="display:none">
                                <select name="reviewerid[]" id="reviewerId" class="form-control select2" onChange="ganti_reviewer_identitas(this.value)" multiple></select>
                              </div>
                            </div>
                          </div>
                          <div class="col-12">
                            <div class="form-group row col-md-12">
                              <label class="col-md-4">Approver</label>
                              <div class="input-group col-md-8">
                                <input name="approverPoscode" id="approverPoscode" style="display:none">
                                <select name="approverId" id="approverId" class="form-control select2" onChange="ganti_approver_identitas(this.value)"></select>
                              </div>
                            </div>
                          </div>
                          <div class="col-12">
                            <div class="form-group row col-md-12">
                              <label class="col-md-4">Tujuan</label>
                              <div class="input-group col-md-8">
                                <input name="tujuanPoscode" id="tujuanPoscode" style="display:none">
                                <select name="tujuanId[]" id="tujuanId" class="form-control select2" onChange="ganti_tujuan_identitas(this.value)" multiple></select>
                              </div>
                            </div>
                          </div>
                          <div class="col-12">
                            <div class="form-group row col-md-12">
                              <label class="col-md-4">CC</label>
                              <div class="input-group col-md-8">
                                <input name="ccPoscode" id="ccPoscode" style="display:none">
                                <select name="ccId[]" id="ccId" class="form-control select2" onChange="ganti_cc_identitas(this.value)" multiple></select>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close_edit_surat" onClick="func_close_edit_surat()">Cancel</button>
                        <button type="button" class="btn btn-primary" id="simpan_edit_surat">Simpan</button>
                        <button class="btn btn-primary" type="button" id="loading_edit_surat" disabled style="display: none;">
                          <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                          Loading...
                        </button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <!-- modal edit surat -->
              <!-- Body -->
            </div>
          </div>
        </div>
        <!-- DIV DATA DIRI -->
      </div>
    </div>
  </section>
  <!-- Container Body -->
</div>
<!-- CONTAINER -->