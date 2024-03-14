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
                <!-- <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal" onclick="fun_tambah()">Tambah</button> -->
                <label class="float-right">&nbsp;</label>
                <!-- <a href="<? //= base_url('master/aset/index_import?id_sidebar=12&id_sidebar_detail=12.5&import_kode=0') 
                              ?>" class="btn btn-danger float-right">Import</a> -->
              </div>
              <!-- Header -->
              <!-- Body -->
              <div class="card-body">
                <!-- Table -->
                <table id="table" class="table table-bordered table-striped" width="100%">
                  <thead>
                    <tr>
                      <th class="th_filter">No</th>
                      <th class="th_filter">Aset Nomor</th>
                      <th class="th_filter">Jenis Aset</th>
                      <th class="th_filter">Nama Aset</th>
                      <th class="th_filter">Merk</th>
                      <th class="th_filter">Serial Number</th>
                      <th class="th_filter">Pengelola</th>
                      <th>Detail</th>
                    </tr>
                  </thead>
                </table>
                <!-- Table -->
                <!-- Modal -->
                <div class="modal fade" id="modal_detail">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title"><?= $judul ?></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <form id="form_modal_detail">
                        <input type="hidden" name="aset_perbaikan_id" id="aset_perbaikan_id">
                        <div class="modal-body">
                          <div class="card-body row">
                            <div class="col-12">
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Tgl Perpindahan</label>
                                <div class="input-group col-md-8">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text">
                                      <i class="far fa-calendar-alt"></i>
                                    </span>
                                  </div>
                                  <input type="text" class="form-control float-right" id="tanggal" name="tanggal">
                                </div>
                                <label class="col-md-4"></label>
                                <i style="color:red;display:none" id="tanggal_perpindahan_alert">Tanggal Pengajuan Tidak Boleh Kosong</i>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Peminta Jasa</label>
                                <div class="input-group col-md-8">
                                  <select class="form-control" id="peminta_jasa_id" name="peminta_jasa_id"> </select>
                                </div>
                                <label class="col-md-4"></label>
                                <i style="color:red;display:none" id="tanggal_pengajuan_alert">Tanggal Pengajuan Tidak Boleh Kosong</i>
                              </div>

                            </div>
                          </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                          <button type="button" id="close_detail" class="btn btn-default" data-dismiss="modal" onclick="func_close_detail()">Close</button>
                          <button type="submit" class="btn btn-success" id="simpan">Simpan</button>
                          <button type="submit" class="btn btn-primary" id="edit" style="display: none">Edit</button>
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
                <div class="modal fade" id="modal_history_detail">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title"><?= $judul ?></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <form id="form_modal_history_detail">
                        <!-- <input type="text" name="aset_perbaikan_id" id="aset_perbaikan_id"> -->
                        <div class="modal-body">
                          <div class="card-body row">
                            <div class="col-12">
                              <table id="table_history_detail" class="table table-bordered table-striped" width="100%">
                                <thead>
                                  <tr>
                                    <th>No</th>
                                    <th>Peminta Jasa</th>
                                    <th>Tanggal Movement</th>
                                    <th>When Create</th>
                                    <th>Who Create</th>
                                  </tr>
                                </thead>
                              </table>
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                          <button type="button" id="close_detail" class="btn btn-default" data-dismiss="modal" onclick="func_close_detail()">Close</button>
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

        <!-- DIV DATA DIRI -->
        <div class="col-md-12" id="div_detail" style="display: none;">
          <input type="text" id="id_aset" name="id_aset" style="display: none;">
          <div class="col-md-12">
            <div class="card card-secondary">
              <!-- Header -->
              <div class="card-header">
                <h3 class="card-title">
                  <div id="judul_detail"></div>
                </h3>
                <!-- <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal_detail" onclick="fun_tambah_detail()">Tambah</button> -->
              </div>
              <!-- Header -->
              <!-- Body -->
              <div class="card-body">
                <!-- Table -->
                <table id="table_detail" class="table table-bordered table-striped" width="100%">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Serial Number</th>
                      <th>Tanggal Penyerahan</th>
                      <th>Tanggal Deadline</th>
                      <th>Tanggal Selesai</th>
                      <!-- <th>Tanggal Perpindahan</th> -->
                      <th>Jenis Pekerjaan</th>
                      <th>Status Pekerjaan</th>
                      <!-- <th>User</th> -->
                      <th>Pengelola Aset</th>
                      <th>Is Jadwal</th>
                      <th>Movement</th>
                      <th>Detail</th>
                    </tr>
                  </thead>
                </table>
                <!-- Table -->

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