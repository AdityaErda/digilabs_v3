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
                      <label class="col-md-12">Status</label>
                      <div class="input-group col-md-12">
                        <select class="form-control select2" id="status_cari" name="status_cari">
                          <option value="-">Semua</option>
                          <option value="0">Belum Diapprove</option>
                          <option value="1">Sudah Diapprove</option>
                          <option value="8">Reject</option>
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
                <table id="table" class="table table-bordered table-striped" width="100%">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nomor Surat</th>
                      <th>Tanggal Pengajuan</th>
                      <th>Peminta Jasa</th>
                      <th>Jenis Sample</th>
                      <!-- <th>Jenis Pekerjaan</th> -->
                      <!-- <th>Tanggal Memo</th> -->
                      <!-- <th>Nomor Memo</th> -->
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                </table>
                <!-- Table -->
                <!-- Modal -->
                <div class="modal fade" id="modal">
                  <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title"><?= $judul ?></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <form id="form_modal">
                        <input type="text" id="transaksi_id" name="transaksi_id" value="" style="display: none;">
                        <input type="text" id="transaksi_status" name="transaksi_status" value="" style="display: none;">
                        <input type="hidden" id="transaksi_tipe" name="transaksi_tipe" value="">
                        <div class="modal-body">
                          <div class="card-body row">
                            <!-- Kiri -->
                            <div class="col-6">
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Peminta Jasa</label>
                                <div class="input-group col-md-8">
                                  <input type="text" class="form-control" id="peminta_jasa_nama" name="peminta_jasa_nama" value="" placeholder="Peminta Jasa" readonly="">
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Jenis Sample</label>
                                <div class="input-group col-md-8">
                                  <input type="text" class="form-control" id="jenis_nama" name="jenis_nama" value="" placeholder="Jenis Sample" readonly="">
                                </div>
                              </div>
                              <!-- <div class="form-group row col-md-12">
                                <label class="col-md-4">Jenis Pekerjaan</label>
                                <div class="input-group col-md-8">
                                  <input type="text" class="form-control" id="sample_pekerjaan_nama" name="sample_pekerjaan_nama" value="" placeholder="Jenis Pekerjaan" readonly="">
                                </div>
                              </div> -->
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">PIC Pengirim Sample</label>
                                <div class="input-group col-md-8">
                                  <input type="text" class="form-control" id="transaksi_detail_pic_pengirim" name="transaksi_detail_pic_pengirim" value="" placeholder="PIC Pengirim Sample" readonly="">
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Ext Pengirim Sample</label>
                                <div class="input-group col-md-8">
                                  <input type="text" class="form-control" id="transaksi_detail_ext_pengirim" name="transaksi_detail_ext_pengirim" value="" placeholder="Ext Pengirim Sample" readonly="">
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Jumlah Sample</label>
                                <div class="input-group col-md-8">
                                  <input type="text" class="form-control" id="transaksi_detail_jumlah" name="transaksi_detail_jumlah" value="" placeholder="Jumlah Sample" readonly="">
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <table width="100%">
                                  <tr>
                                    <td width="40%"><label>&nbsp;&nbsp;Foto Sample</label></td>
                                    <td width="50%"><img src="" alt="" style="width: 200px" id="transaksi_detail_foto"></td>
                                    <td width="10%"><a href="" target="_BLANK" id="unduh">Unduh</a></td>
                                  </tr>
                                </table>
                              </div>
                            </div>
                            <!-- Kiri -->
                            <!-- Kanan -->
                            <div class="col-6">
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Tgl Pengajuan</label>
                                <div class="input-group col-md-8">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text">
                                      <i class="far fa-calendar-alt"></i>
                                    </span>
                                  </div>
                                  <input type="text" class="form-control float-right" id="transaksi_detail_tgl_pengajuan" name="transaksi_detail_tgl_pengajuan" readonly="">
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
                                  <input type="text" class="form-control float-right tanggal" id="transaksi_detail_tgl_memo" name="transaksi_detail_tgl_memo" value="<?= date('d-m-Y H:i:s') ?>">
                                </div>
                              </div> -->
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">No Surat</label>
                                <div class="input-group col-md-8">
                                  <input type="text" class="form-control" id="transaksi_detail_nomor" name="transaksi_detail_nomor" value="" placeholder="Nomor Surat" readonly>
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Identitas</label>
                                <div class="input-group col-md-8">
                                  <input type="text" class="form-control" id="identitas_nama" name="identitas_nama" value="" placeholder="Identitas" readonly>
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Keterangan</label>
                                <div class="input-group col-md-8">
                                  <input type="text" class="form-control" id="transaksi_detail_keterangan" name="transaksi_detail_keterangan" value="" placeholder="Keterangan" readonly>
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Parameter</label>
                                <div class="input-group col-md-8">
                                  <input type="number" class="form-control" id="transaksi_detail_parameter" name="transaksi_detail_parameter" value="" placeholder="Pamameter">
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Note <span id="req_note" style="display:none">*</span></label>
                                <div class="input-group col-md-8">
                                  <input type="text" class="form-control" id="transaksi_detail_note" name="transaksi_detail_note" value="" placeholder="Note" maxlength="25">
                                </div>
                              </div>
                              <div class="form-group row col-md-12" id="div_disposisi" style="display: none;">
                                <table width="100%">
                                  <tr>
                                    <td width="35%"><label>&nbsp;&nbsp;Disposisi*</label></td>
                                    <td width="65%"><select class="form-control select2" id="id_seksi" name="id_seksi[]" multiple="multiple" required=""></select></td>
                                  </tr>
                                </table>
                              </div>
                              <div class="form-group row col-md-12" id="div_urgent" style="display: none;">
                                <table width="100%">
                                  <tr>
                                    <td width="35%"><label>&nbsp;&nbsp;Urgent</label></td>
                                    <td width="65%"><input type="checkbox" id="is_urgent" name="is_urgent" value="y" placeholder=""></select></td>
                                  </tr>
                                </table>
                              </div>
                              <div class="form-group row col-md-12" id="div_khusus" style="display: none;">
                                <table width="100%">
                                  <tr>
                                    <td width="35%"><label>&nbsp;&nbsp;Khusus</label></td>
                                    <td width="65%"><input type="checkbox" id="is_khusus" name="is_khusus" value="y" placeholder=""></select></td>
                                  </tr>
                                </table>
                              </div>
                            </div>
                            <!-- Kanan -->
                          </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                          <button type="button" id="close" class="btn btn-default" data-dismiss="modal" onclick="fun_close()">Close</button>
                          <button type="submit" class="btn btn-info" id="review" style="display: none;">Review</button>
                          <button type="submit" class="btn btn-success" id="approve" style="display: none;">Approve</button>
                          <button type="submit" class="btn btn-danger" id="reject" style="display: none;">Reject</button>
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
                <!-- Modal -->
              </div>
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