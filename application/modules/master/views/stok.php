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
                      <div class="card-header">
                        <h3 class="card-title"><?= $judul ?></h3>
                        <a href="<?= base_url('master/stok/index_import') ?>" class="btn btn-primary float-right">Import</a>
                        <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal">Tambah</button>
                      </div>
                    <!-- Header -->
                    <!-- Body -->
                      <div class="card-body">
                        <!-- Table -->
                          <table id="table" class="table table-bordered table-striped" width="100%">
                            <thead>
                              <tr>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Jenis Barang</th>
                                <th>Kategori Barang</th>
                                <th>Tipe Barang</th>
                                <th>Stok</th>
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
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <form id="form_modal">
                                  <input type="hidden" id="jadwal_id" name="jadwal_id" value="">
                                  <div class="modal-body">
                                    <div class="card-body row">
                                      <div class="col-12">
                                        <div class="form-group row col-md-12">
                                          <label class="col-md-4">Nama Barang</label>
                                          <div class="input-group col-md-8">
                                            <select class="form-control select2">
                                            </select>
                                          </div>
                                        </div>
                                        <div class="form-group row col-md-12">
                                          <label class="col-md-4">Stok</label>
                                          <div class="input-group col-md-8">
                                            <input type="text" class="form-control" name="" value="" placeholder="Stok">
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="modal-footer justify-content-between">
                                    <button type="button" id="close" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-success" id="simpan">Simpan</button>
                                    <button type="button" class="btn btn-primary" id="edit" style="display: none">Edit</button>
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