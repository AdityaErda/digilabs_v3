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
        <!-- DIV DATA DIRI -->
        <div class="col-md-12">
          <div class="col-md-12">
            <div class="card card-success">
              <!-- Header -->
              <div class="card-header">
                <h3 class="card-title"><?= $judul ?></h3>
              </div>
              <!-- Header -->
              <!-- Body -->
              <div class="card-body">
                <!-- Table -->
                <table id="table" class="table table-bordered" width="100%">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>Pengajuan</th>
                      <th>Pengesahan</th>
                      <th>Judul</th>
                      <th>Nomor</th>
                      <th>Keterangan</th>
                      <th>File</th>
                      <th>Status Perubahan</th>
                      <th>Status Pengajuan</th>
                      <th>Lihat</th>
                      <th>Proses</th>
                  </thead>
                </table>
                <!-- Table -->
                <!-- Modal -->
                <div class="modal fade" id="modal">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title"><?= $judul ?></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <form id="form_modal">
                        <input type="hidden" id="transaksi_id" name="transaksi_id" value="">
                        <input type="hidden" id="transaksi_detail_id" name="transaksi_detail_id" value="">
                        <div class="modal-body">
                          <div class="card-body row">
                            <div class="col-12">
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Jenis Document *</label>
                                <div class="input-group col-md-8">
                                  <select class="form-control select2" id="jenis_document" name="jenis_document">
                                  </select>
                                </div>
                                <i style="display:none;color:red" id="jenis_alert">Jenis Document Tidak Boleh Kosong</i>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Seksi *</label>
                                <div class="input-group col-md-8">
                                  <select class="form-control select2" id="seksi" name="seksi">
                                  </select>
                                </div>
                                <i style="display:none;color:red" id="seksi_alert">Seksi Document Tidak Boleh Kosong</i>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Judul Document *</label>
                                <div class="input-group col-md-8">
                                  <input type="text" class="form-control" name="judul_document" value="" placeholder="Judul Document" id="judul_document">
                                </div>
                                <label class="col-md-4"></label>
                                <i style="display:none;color:red" id="judul_alert">Judul Document Tidak Boleh Kosong</i>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Nomor Document *</label>
                                <div class="input-group col-md-8">
                                  <input type="text" class="form-control" id="nomor_document" name="nomor_document" value="" placeholder="Nomor Document" readonly>
                                </div>
                                <label class="col-md-4"></label>
                                <i style="display:none;color:red" id="nomor_alert">Nomor Document Tidak Boleh Kosong</i>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Tanggal Pengesahan *</label>
                                <div class="input-group col-md-8">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text">
                                      <i class="far fa-calendar-alt"></i>
                                    </span>
                                  </div>
                                  <input type="text" class="form-control" name="tanggal" id="tanggal" value="" placeholder="Tanggal Pengesahaan">
                                </div>
                                <label class="col-md-4"></label>
                                <i style="display:none;color:red" id="tanggal_alert">Tanggal Pengesahan Tidak Boleh Kosong</i>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Revisi * / Terbitan *</label>
                                <div class="input-group col-md-8">
                                  <input type="text" class="form-control col-md-5" value="" placeholder="Revisi" id="revisi" name="revisi">
                                  <label class="col-md-1">/</label>
                                  <input type="text" class="form-control col-md-5" value="" placeholder="Terbitan" id="terbitan" name="terbitan">
                                </div>
                                <label class="col-md-4"></label>
                                <i style="display:none;color:red" id="revisi_alert">Revisi Document Tidak Boleh Kosong</i>
                                <label class="col-md-1"></label>
                                <i style="display:none;color:red" id="terbitan_alert">Terbitan Document Tidak Boleh Kosong</i>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Keterangan</label>
                                <div class="input-group col-md-8">
                                  <textarea class="form-control" value="" placeholder="Keterangan" id="keterangan" name="keterangan"></textarea>
                                </div>
                              </div>

                              <div id="div_pdf_lama" style="display: none">
                                <div class="form-group row col-md-12">
                                  <label class="col-md-4">File PDF</label>
                                  <div class="input-group col-md-8">
                                    <input type="text" readonly id="file_pdf_lama" class="form-control">
                                  </div>
                                </div>
                              </div>
                              <div id="div_word_lama" style="display: none">
                                <div class="form-group row col-md-12">
                                  <label class="col-md-4">File Word</label>
                                  <div class="input-group col-md-8">
                                    <input type="text" readonly id="file_word_lama" class="form-control">
                                  </div>
                                </div>
                              </div>
                              <hr>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Note</label>
                                <div class="input-group col-md-8">
                                  <textarea class="form-control" value="" placeholder="Note" id="note" name="note"></textarea>
                                </div>
                                <label class="col-md-4"></label>
                                <i style="display:none;color:red" id="note_alert">Note Document Tidak Boleh Kosong</i>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="modal-footer justify-content-between">
                          <button type="button" id="close" class="btn btn-default" data-dismiss="modal" onclick="fun_close();">Close</button>
                          <button type="button" class="btn btn-danger" id="tolak">Tolak</button>
                          <button type="button" class="btn btn-success" id="aprove">Approve</button>
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
                <!-- Modal -->
                <div class="modal fade" id="modal1">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title"><?= $judul ?></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <form id="form_modal">
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