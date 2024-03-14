<style type="text/css">
  .DTFC_LeftBodyWrapper {
    top: 15px;
  }

  .dataTables_scrollHead {
    overflow: auto !important;
    /*    z-index:1;*/
    /*    width: 100%;*/
  }
</style>

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
        <!-- FILTER -->
        <div class="col-md-12">
          <div class="col-md-12">
            <div class="card">
              <!-- Header -->
              <div class="card-header">
                <h3 class="card-title">Filter <?= $judul ?></h3>

              </div>
              <!-- Header -->
              <!-- Body -->
              <form id="filter">
                <input type="text" id="id_transaksi" name="id_transaksi" style="display: none;">
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
                      <label class="col-md-12">Status</label>
                      <div class="input-group col-md-12">
                        <select class="form-control" id="transaksi_status" name="transaksi_status">
                          <option value="-">Semua</option>
                          <option value="6">Sample Belum Diterima</option>
                          <option value="7">Sample Diterima</option>
                          <option value="8">On Progress</option>
                          <option value="9">Draft Log Sheet</option>
                          <option value="10">Menunggu Review Kasie</option>
                          <option value="11">Review Kasie</option>
                          <option value="12">Tunda Diterima</option>
                          <option value="13">Tunda Non Letter</option>
                          <option value="14">Batal</option>
                          <option value="15">Reject</option>
                          <option value="16">Send DOF</option>
                          <option value="17">Terbit Sertifikat</option>
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
            <div class="card card-success">
              <!-- Header -->
              <div class="card-header">
                <h3 class="card-title"><?= $judul ?></h3>
                <a href="<?= base_url('sample/multi_sample/?&header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) ?>" class="float-right btn btn-primary">Multi Sample</a>
              </div>
              <!-- Header -->
              <!-- Body -->
              <div class="card-body">
                <!-- <input type="text" name="transaksi_status" id="transaksi_status" value="6" style="display: none;"> -->
                <!-- Table -->
                <table id="table" class="table table-bordered table-striped nowrap" width="100%">
                  <thead>
                    <tr>

                      <th>No</th>
                      <th>Nomor Surat</th>
                      <th>Nomor Sample</th>
                      <th>Jenis Sample</th>
                      <th>Tipe Sample</th>
                      <th>Peminta Jasa</th>
                      <th>Status</th>
                      <!-- tombol -->
                      <th>Proses</th>
                      <th>Detail</th>
                      <th>Qrcode</th>
                      <th>Alihkan</th>
                      <!-- <th>History</th> -->
                      <!-- tombol -->
                    </tr>
                  </thead>
                </table>
                <!-- Table -->
                <!-- Modal Detail -->
                <div class="modal fade" id="modal_detail">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title" id="judul_detail"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <div class="card-body">
                          <table id="table_detail" class="table table-bordered table-striped" width="100%">
                            <thead>
                              <tr>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Estimasi</th>
                                <!-- <th>Note</th> -->
                                <th>Disposisi</th>
                                <th>Petugas</th>
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
                <!-- Modal Cara Close -->
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
                          <input type="text" name="cara_close_transaksi_detail_id_temp" id="cara_close_transaksi_detail_id_temp" style="display:none">
                          <input type="text" name="cara_close_transaksi_detail_id" id="cara_close_transaksi_detail_id" style="display:none">
                          <input type="text" name="cara_close_transaksi_id" id="cara_close_transaksi_id" style="display:none">
                          <input type="text" name="cara_close_transaksi_detail_status" id="cara_close_transaksi_detail_status" style="display:none">
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
                              <div id="div_cara_close_sertifikat" style="display:none">
                                <div class="form-group row col-md-12">
                                  <label class="col-md-4">Nomor Sertifikat / Surat</label>
                                  <div class="input-group col-md-8">
                                    <input type="text" name="transaksi_detail_nomor" id="transaksi_detail_nomor" class="form-control">
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close_cara_close" onClick="fun_close_cara_close()">Close</button>
                          <button type="submit" class="btn btn-primary" id="simpan_cara_close">Lanjut</button>
                          <button class="btn btn-primary" type="button" id="loading_cara_close" disabled style="display: none;">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                          </button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <!-- Modal Cara Close -->
                <!-- Modal Alihkan -->
                <div class="modal fade" id="modal_alihkan">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title"><?= $judul ?> - Alasan Pengalihan</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <form id="form_modal_alihkan">
                        <div class="modal-body">
                          <div class="card-body row">
                            <input type="text" id="id_transaksi_alihkan" name="id_transaksi_alihkan" style="display: none;">
                            <input type="text" id="id_transaksi_detail_alihkan" name="id_transaksi_detail_alihkan" style="display:none ;">
                            <input type="text" id="id_non_rutin_alihkan" name="id_non_rutin_alihkan" style="display:none">
                            <input type="text" id="transaksi_detail_nomor_sample" name="transaksi_detail_nomor_sample" style="display:none">
                            <input type="text" id="tipe_alihkan" name="tipe_alihkan" style="display:none">
                            <div class="col-12">
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Alasan Pengalihan / Pengembalian</label>
                                <div class="input-group col-md-8">
                                  <input id="alasan_alihkan" name="alasan_alihkan" class="form-control" type="text" placeholder="Alasan Pengalihan">
                                </div>
                                <label class="col-md-4"></label>
                                <i class="text-danger" style="display:none" id="alert_alasan_alihkan">Alasan Pengalihan Tidak Boleh Kosong</i>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                          <button type="button" id="close_alihkan" class="btn btn-default" data-dismiss="modal" onclick="fun_close()">Close</button>
                          <button type="submit" class="btn btn-success float-right" id="simpan_alihkan">Simpan</button>
                          <button class="btn btn-primary" type="button" id="loading_form_alihkan" disabled style="display: none;">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                          </button>
                        </div>
                      </form>
                      <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                  </div>
                  <!-- Modal Alihkan -->
                </div>
                <!-- Modal History -->
                <div class="modal fade" id="modal_history">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title" id="judul_history"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <div class="card-body">
                          <table id="table_history" class="table table-bordered table-striped no-wrap" width="100%">
                            <thead>
                              <tr>
                                <th>Seksi Disposisi Asal</th>
                                <th>Seksi Disposisi Tujuan</th>
                                <th>Alasan Pengalihan</th>
                                <th>Who Create</th>
                                <th>When Create</th>
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
                <!-- modal history -->
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
<!-- CONTAINER-->