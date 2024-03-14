<!-- CONTAINER -->
<div class="content-wrapper">
  <!-- Container Header -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><?= $judul ?> Eksternal</h1>
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
            <div class="card card-warning">
              <!-- Header -->
              <div class="card-header">
                <h3 class="card-title">Filter <?= $judul ?> Eksternal</h3>
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
                    <div class="form-group col-md-4">
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
                <h3 class="card-title"><?= $judul ?> Eksternal</h3>
                <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal" onclick="func_tambah()">Tambah</button>
              </div>
              <!-- Header -->
              <!-- Body -->
              <div class="card-body">
                <!-- Table -->
                <table id="table" class="table table-bordered" width="100%">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Tgl Penyerahan</th>
                      <th>Tgl Selesai</th>
                      <th>Nomor Aset</th>
                      <th>Serial Number</th>
                      <th>Nama Aset</th>
                      <th>Pengelola Aset</th>
                      <th>Note</th>
                      <th>Status</th>
                      <th>File</th>
                      <th>Proses</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                </table>
                <!-- Table -->
                <!-- Modal -->
                <div class="modal fade" id="modal">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title"><?= $judul ?> Eksternal</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <form id="form_modal">
                        <input type="hidden" id="aset_perbaikan_id" name="aset_perbaikan_id">
                        <input type="hidden" id="aset_perbaikan_status" name="aset_perbaikan_status">
                        <input type="hidden" id="id_user" name="id_user">
                        <div class="modal-body">
                          <div class="modal-body">
                            <div class="card-body row">
                              <div class="col-12">
                                <div class="form-group row col-md-12">
                                  <label class="col-md-4">Tgl Penyerahan *</label>
                                  <div class="input-group col-md-8">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text">
                                        <i class="far fa-calendar-alt"></i>
                                      </span>
                                    </div>
                                    <input type="text" readonly class="form-control float-right" id="tanggal" name="tanggal">
                                  </div>
                                  <label class="col-md-4"></label>
                                  <i style="display:none;color:red" id="tanggal_alert">Tanggal Penyerahan Tidak Boleh Kosong</i>
                                </div>
                                <div class="form-group row col-md-12">
                                  <label class="col-md-4">Nomor Aset *</label>
                                  <div class="input-group col-md-8">
                                    <select class="form-control" name="aset_nomor_utama" id="aset_nomor_utama" onchange="func_gantiKodeItem(this.value);func_gantiAsetNama(this.value);">

                                    </select>
                                  </div>
                                  <label class="col-md-4"></label>
                                  <i style="display:none;color:red" class="invalid" id="nomor_alert">Nomor Aset Tidak Boleh Kosong</i>
                                </div>
                                <div class="form-group row col-md-12">
                                  <label class="col-md-4">Nama Aset *</label>
                                  <div class="input-group col-md-8">
                                    <input type="text" name="aset_nama" id="aset_nama" class="form-control">
                                    <!-- <select class=" form-control" id="aset_id" name="aset_id" onchange="func_gantiKodeItem(this.value);func_gantiSerial(this.value)">
                                    </select> -->
                                  </div>
                                  <label class="col-md-4"></label>
                                  <i style="display:none;color:red" class="invalid" id="nama_alert">Nama Aset Tidak Boleh Kosong</i>
                                </div>
                                <div class="form-group row col-md-12">
                                  <label class="col-md-4">Serial Number *</label>
                                  <div class="input-group col-md-8">
                                    <select class="form-control" id="item_id" name="item_id" style="display: none;"></select>
                                    <input type="text" name="item_id_baru" id="item_id_baru" class="form-control">
                                  </div>
                                  <label class="col-md-4"></label>
                                  <i style="display:none;color:red" class="invalid" id="serial_alert">Serial Number Tidak Boleh Kosong</i>
                                </div>
                                <div class="form-group row col-md-12">
                                  <label class="col-md-4">Jenis Pekerjaan *</label>
                                  <div class="input-group col-md-8">
                                    <select class="form-control" id="pekerjaan_id" name="pekerjaan_id">
                                      <option value="p">Perbaikan</option>
                                      <option value="k">Kalibrasi</option>
                                    </select>
                                  </div>
                                  <label class="col-md-4"></label>
                                  <i style="display:none;color:red" class="invalid" id="jenis_alert">Jenis Pekerjaan Tidak Boleh Kosong</i>
                                </div>
                                <div class="form-group row col-md-12">
                                  <label class="col-md-4">Pengelola Aset *</label>
                                  <div class="input-group col-md-8">
                                    <select class="form-control" id="peminta_id" name="peminta_id">
                                    </select>
                                  </div>
                                  <label class="col-md-4"></label>
                                  <i style="display:none;color:red" class="invalid" id="peminta_alert">Pengelola Tidak Boleh Kosong</i>
                                </div>
                                <div class="form-group row col-md-12">
                                  <label class="col-md-4">Vendor *</label>
                                  <div class="input-group col-md-8">
                                    <input type="text" class="form-control" name="aset_perbaikan_vendor" value="" id="aset_perbaikan_vendor" placeholder="Vendor">
                                  </div>
                                  <label class="col-md-4"></label>
                                  <i style="display:none;color:red" class="invalid" id="vendor_alert">Vendor Tidak Boleh Kosong</i>
                                </div>
                                <div class="form-group row col-md-12">
                                  <label class="col-md-4">Note *</label>
                                  <div class="input-group col-md-8">
                                    <input type="text" class="form-control" name="aset_note" value="" id="aset_note" placeholder="Note">
                                  </div>
                                  <label class="col-md-4"></label>
                                  <i style="display:none;color:red" class="invalid" id="note_alert">Note Tidak Boleh Kosong</i>
                                </div>
                                <div id="div_file_sebelum" style="display: none">
                                  <div class="form-group row col-md-12">
                                    <label class="col-md-4">File Sebelumnya</label>
                                    <div class="input-group col-md-8">
                                      <input type="label" class="form-control" id="aset_file_lama" name="aset_file_lama" readonly>
                                    </div>
                                  </div>
                                </div>
                                <div class="form-group row col-md-12">
                                  <label class="col-md-4">File <span id="file_wajib"> * </span></label>
                                  <div class="input-group col-md-8">
                                    <input type="file" class="form-control" id="aset_file" name="aset_file" value="" placeholder="Note" accept=".doc,.docx,.pdf">
                                  </div>
                                  <label class="col-md-4"></label>
                                  <i style="display:none;color:red" class="invalid" id="file_alert">File Tidak Boleh Kosong</i>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="text-center">
                            <div class="spinner-border" role="status" id="loading" style="display:none">
                              <span class="sr-only" style="position: absolute;display: block;top: 50%;left: 50%;">Loading...</span>
                            </div>
                          </div>
                          <div class="modal-footer justify-content-between">
                            <button type="button" id="close" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success" id="simpan">Simpan</button>
                            <button type="submit" class="btn btn-primary" id="edit" style="display: none">Edit</button>
                            <button type="submit" class="btn btn-danger" id="approve" style="display: none">Approve</button>
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