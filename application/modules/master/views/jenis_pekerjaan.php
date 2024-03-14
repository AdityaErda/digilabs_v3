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
                      <div class="card-header bg-success">
                        <h3 class="card-title"><?= $judul ?></h3>
                        <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal">Tambah</button>
                        <label class="float-right">&nbsp;</label>
                        <button type="button" class="btn btn-warning float-right" onclick="fun_reset()">Reset Data</button>
                        <label class="float-right">&nbsp;</label>
                        <a href="<?= base_url('master/jenis_pekerjaan/index_import?header_menu=0&menu_id=0&import_kode=0') ?>" class="btn btn-danger float-right">Import</a>
                      </div>
                    <!-- Header -->
                    <!-- Body -->
                      <div class="card-body">
                        <!-- Table -->
                          <table id="table" class="table table-bordered table-striped" width="100%">
                            <thead>
                              <tr>
                                <th>Kode Jenis Pekerjaan</th>
                                <th>Nama Jenis Pekerjaan</th>
                                <th>Updated</th>
                                <th>Edit</th>
                                <th>Hapus</th>
                              </tr>
                            </thead>
                          </table>
                        <!-- Table -->
                        <!-- Modal -->
                          <div class="modal fade" id="modal">
                            <div class="modal-dialog modal-lg">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h4 class="modal-title"><?= $judul ?></h4>
                                </div>
                                <form id="form_modal">
                                  <input type="text" id="sample_pekerjaan_id" name="sample_pekerjaan_id" value="" style="display: none;">
                                  <div class="modal-body">
                                    <div class="card-body row">
                                      <div class="col-12">
                                        <div class="form-group row col-md-12">
                                          <label class="col-md-4">Kode Jenis Pekerjaan</label>
                                          <div class="input-group col-md-8">
                                            <input type="text" class="form-control" id="sample_pekerjaan_kode" name="sample_pekerjaan_kode" value="" placeholder="Kode Jenis Pekerjaan">
                                          </div>
                                        </div>
                                        <div class="form-group row col-md-12">
                                          <label class="col-md-4">Nama Jenis Pekerjaan</label>
                                          <div class="input-group col-md-8">
                                            <input type="text" class="form-control" id="sample_pekerjaan_nama" name="sample_pekerjaan_nama" value="" placeholder="Nama Jenis Pekerjaan">
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