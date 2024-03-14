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
                          <table id="table" class="table table-bordered table-striped" width="100%">
                            <thead>
                              <tr>
                                <th>Tanggal Pengajuan</th>
                                <th>Estimasi</th>
                                <th>Peminta Jasa</th>
                                <th>Jenis Sample</th>
                                <th>Jenis Pekerjaan</th>
                                <th>Status</th>
                                <th>Qrcode</th>
                                <th>Detail</th>
                                <th>Proses</th>
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
                                  <input type="text" id="transaksi_detail_status" name="transaksi_detail_status" value="" style="display: none;">
                                  <!-- <input type="text" id="transaksi_tipe" name="transaksi_tipe" value="<?=$tipe?>" style="display: none;"> -->

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
                                          <div class="form-group row col-md-12">
                                            <label class="col-md-4">Jenis Pekerjaan</label>
                                            <div class="input-group col-md-8">
                                              <input type="text" class="form-control" id="sample_pekerjaan_nama" name="sample_pekerjaan_nama" value="" placeholder="Jenis Pekerjaan" readonly="">
                                            </div>
                                          </div>
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
                                                <td width="40%"><label>Foto Sample</label></td>
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
                                          <div class="form-group row col-md-12">
                                            <label class="col-md-4">Tgl Memo</label>
                                            <div class="input-group col-md-8">
                                              <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                  <i class="far fa-calendar-alt"></i>
                                                </span>
                                              </div>
                                              <input type="text" class="form-control float-right" id="transaksi_detail_tgl_memo" name="transaksi_detail_tgl_memo" readonly="">
                                            </div>
                                          </div>
                                          <div class="form-group row col-md-12">
                                            <label class="col-md-4">Nomor Memo</label>
                                            <div class="input-group col-md-8">
                                              <input type="text" class="form-control" id="transaksi_detail_no_memo" name="transaksi_detail_no_memo" value="" placeholder="Nomor Memo" readonly="">
                                            </div>
                                          </div>
                                          <div class="form-group row col-md-12">
                                            <label class="col-md-4">Identitas</label>
                                            <div class="input-group col-md-8">
                                              <input type="text" class="form-control" id="identitas_nama" name="identitas_nama" value="" placeholder="Identitas" readonly>
                                            </div>
                                          </div>
                                          <div class="form-group row col-md-12">
                                            <label class="col-md-4">Parameter</label>
                                            <div class="input-group col-md-8">
                                              <input type="number" class="form-control" id="transaksi_detail_parameter" name="transaksi_detail_parameter" value="" placeholder="Pamameter" readonly>
                                            </div>
                                          </div>
                                          <div class="form-group row col-md-12" style="display: none;">
                                            <label class="col-md-4">Disposisi</label>
                                            <div class="input-group col-md-8">
                                              <input type="text" class="form-control" id="seksi_nama" name="seksi_nama" value="" placeholder="Disposisi" readonly="">
                                            </div>
                                          </div> 
                                          <div class="form-group row col-md-12">
                                            <label class="col-md-4">Note</label>
                                            <div class="input-group col-md-8">
                                              <input type="text" class="form-control" id="transaksi_detail_note" name="transaksi_detail_note" value="" placeholder="Note" maxlength="25">
                                            </div>
                                          </div> 
                                          <div class="form-group row col-md-12">
                                            <label class="col-md-4">Petugas Sampling</label>
                                            <div class="input-group col-md-8">
                                              <select class="form-control select2" id="id_petugas" name="id_petugas[]" multiple="multiple"></select>
                                            </div>
                                          </div>
                                        </div>
                                      <!-- Kanan -->
                                    </div>
                                  </div>
                                  <div class="modal-footer justify-content-between">
                                    <button type="button" id="close" class="btn btn-default" data-dismiss="modal" onclick="fun_close()">Close</button>
                                    <button type="submit" class="btn btn-success" id="simpan">Simpan</button>
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
                                          <th>Note</th>
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