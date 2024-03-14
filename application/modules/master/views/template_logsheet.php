<style type="text/css">
  .dataTables_scrollHead {
    overflow: auto !important;
  }
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
        <!-- DIV DATA DIRI -->
        <div class="col-md-12">
          <div class="col-md-12">
            <div class="card">
              <!-- Header -->
              <div class="card-header bg-warning">
                <h3 class="card-title"><?= $judul ?></h3>
                <button type="button" class="btn btn-primary col-1 float-right" data-toggle="modal" data-target="#modal">Tambah</button>
                <label class="float-right">&nbsp;</label>
              </div>&nbsp;
              <!-- Header -->
              <!-- Body -->
              <div class="card-body">
                <!-- Table -->
                <table id="table" class="table table-bordered table-striped" width="100%">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama Log Sheet</th>
                      <th>Update</th>
                      <th>Aktif</th>
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
                        <input type="text" id="template_logsheet_id" name="template_logsheet_id" value="" style="display: none;">
                        <div class="modal-body">
                          <div class="card-body row">
                            <div class="col-12">
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Nama LogSheet</label>
                                <div class="input-group col-md-8">
                                  <input type="text" class="form-control" id="template_logsheet_nama" name="template_logsheet_nama" required>
                                </div>
                              </div>
                              <!-- <div class="form-group row col-md-12">
                                                                <label class="col-md-4">Template</label>
                                                                <div class="input-group col-md-8">
                                                                    <select class="form-control select2" id="template_logsheet_file" name="template_logsheet_file" required="">
                                                                    </select>
                                                                </div>
                                                            </div> -->
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Aktif</label>
                                <div class="input-group col-md-8">
                                  <input type="checkbox" name="is_aktif" id="is_aktif" value="y">
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                          <button type="button" id="close" class="btn btn-default" data-dismiss="modal" onclick="fun_close()">Close</button>
                          <button type="submit" class="btn btn-success" id="simpan">Simpan</button>
                          <button type="submit" class="btn btn-primary" id="edit" style="display: none">Edit</button>
                        </div>
                      </form>
                    </div>
                    <!-- /.modal-content -->
                  </div>
                  <!-- /.modal-dialog -->
                </div>
              </div>
              <!-- Body -->
            </div>
          </div>
        </div>
        <!-- DIV DATA DIRI -->

        <!-- DIV DETAIL LOGSHEET-->
        <div class="col-md-12" id="div_detail" style="display: none;">
          <input type="hidden" id="id_logsheet_detail" name="id_logsheet_detail">
          <div class="col-md-12">
            <div class="card">
              <!-- Header -->
              <div class="card-header bg-success">
                <h3 class="card-title">DetaiL Template Logsheet</h3>
                <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal_detail" onclick="fun_tambah_detail()">Tambah</button>
              </div>&nbsp;
              <!-- Header -->
              <!-- Body -->
              <div class="card-body">
                <!-- Table -->
                <table id="table_detail" class="table table-bordered table-striped" width="100%">
                  <thead>
                    <tr>
                      <!-- <th>No</th> -->
                      <th>Urutan</th>
                      <th>Parameter Rumus</th>
                      <th>Sertifikat</th>
                      <th>Edit</th>
                      <th>Hapus</th>
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
                      </div>
                      <form id="form_modal_detail">
                        <input type="text" id="temp_logsheet_id" name="temp_logsheet_id" style="display: none;">
                        <input type="text" id="template_logsheet_detail_id" name="template_logsheet_detail_id" value="" style="display: none;">
                        <div class="modal-body">
                          <div class="card-body row">
                            <div class="col-12">
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Urutan</label>
                                <div class="input-group col-md-8">
                                  <input type="number" name="detail_logsheet_urut" id="detail_logsheet_urut" class="form-control">
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Parameter Rumus</label>
                                <div class="input-group col-md-8">
                                  <select class="form-control select2" id="logsheet_nama_rumus" name="logsheet_nama_rumus" required="">
                                  </select>
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Sertifikat</label>
                                <div class="input-group col-md-8">
                                  <select class="form-control" id="is_sertifikat" name="is_sertifikat" required="">
                                    <option value="y">Iya</option>
                                    <option value="n">Tidak</option>
                                  </select>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                          <button type="button" id="close_detail" class="btn btn-default" data-dismiss="modal" onclick="fun_close_detail()">Close</button>
                          <button type="submit" class="btn btn-success" id="simpan_detail">Simpan</button>
                          <button type="submit" class="btn btn-primary" id="edit_detail" style="display: none">Edit</button>
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
            <div class="card">
              <!-- Header -->
              <div class="card-header bg-warning">
                <h3 class="card-title">Rumus Template LogSheet (Hanya Preview Saja)</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>&nbsp;
              <div class="card-body" id="div_rumus">

              </div>
              <!-- Rumus -->
            </div>
          </div>

        </div>
        <!-- DIV DETAIL LOGSHEET -->
      </div>
    </div>
  </section>
  <!-- Container Body -->
</div>
<!-- CONTAINER -->