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
                        <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal">Tambah</button>
                        <label class="float-right">&nbsp;</label>
                        <a href="<?= base_url('master/barang_material/index_import?header_menu=0&menu_id=01&import_kode=0') ?>" class="btn btn-danger float-right">Import</a>
                        <label class="float-right">&nbsp;</label>
                        <button type="button" class="btn btn-success float-right" onclick="fun_reset()">Reset</button>
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
                                <th>Katalog Number</th>
                                <th>Merk</th>
                                <th>Jenis Barang</th>
                                <th>Gl Account</th>
                                <th>Harga Satuan</th>
                                <th>Satuan</th>
                                <th>Stok</th>
                                <th>Stok Alert</th>
                                <th>Updated</th>
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
                                  <h4 class="modal-title"><?= $judul ?></h4>
                                </div>
                                <form id="form_modal">
                                  <input type="text" id="item_id" name="item_id" value="" style="display: none;">
                                  <div class="modal-body">
                                    <div class="card-body row">
                                      <div class="col-12">
                                        <div class="form-group row col-md-12">
                                          <label class="col-md-4">Kode Barang *</label>
                                          <div class="input-group col-md-8">
                                            <input type="text" class="form-control" id="item_kode" name="item_kode" value="" placeholder="Kode Barang" required="">
                                          </div>
                                        </div>
                                        <div class="form-group row col-md-12">
                                          <label class="col-md-4">Nama Barang *</label>
                                          <div class="input-group col-md-8">
                                            <input type="text" class="form-control" id="item_nama" name="item_nama" value="" placeholder="Nama Barang" required="">
                                          </div>
                                        </div>
                                        <div class="form-group row col-md-12">
                                          <label class="col-md-4">Katalog Number *</label>
                                          <div class="input-group col-md-8">
                                            <input type="text" class="form-control" id="item_katalog_number" name="item_katalog_number" value="" placeholder="Katalog Number" required="">
                                          </div>
                                        </div>
                                        <div class="form-group row col-md-12">
                                          <label class="col-md-4">Merk *</label>
                                          <div class="input-group col-md-8">
                                            <input type="text" class="form-control" id="item_merk" name="item_merk" value="" placeholder="Merk" required="">
                                          </div>
                                        </div>
                                        <div class="form-group row col-md-12">
                                          <label class="col-md-4">Jenis Barang *</label>
                                          <div class="input-group col-md-8">
                                            <select class="form-control select2" id="jenis_id" name="jenis_id" required="">
                                            </select>
                                          </div>
                                        </div>
                                        <div class="form-group row col-md-12">
                                          <label class="col-md-4">Gl Account *</label>
                                          <div class="input-group col-md-8">
                                            <select class="form-control select2" id="gl_account_id" name="gl_account_id" required="">
                                            </select>
                                          </div>
                                        </div>
                                        <div class="form-group row col-md-12">
                                          <label class="col-md-4">Harga Satuan *</label>
                                          <div class="input-group col-md-8">
                                            <input type="number" class="form-control" id="item_harga" name="item_harga" value="" placeholder="Harga Satuan" required="">
                                          </div>
                                        </div>
                                        <div class="form-group row col-md-12">
                                          <label class="col-md-4">Stok Awal *</label>
                                          <div class="input-group col-md-8">
                                            <input type="number" class="form-control" id="stok_awal" name="stok_awal" value=""  placeholder="Stok Awal" required=""  step="0.01">
                                          </div>
                                        </div>
                                        <div class="form-group row col-md-12">
                                          <label class="col-md-4">Stok Alert *</label>
                                          <div class="input-group col-md-8">
                                            <input type="number" class="form-control" id="stok_alert" name="stok_alert" value="" placeholder="Stok Alert" required="">
                                          </div>
                                        </div>
                                        <div class="form-group row col-md-12">
                                          <label class="col-md-4">Satuan *</label>
                                          <div class="input-group col-md-8">
                                            <input type="text" class="form-control" id="item_satuan" name="item_satuan" value="" placeholder="Satuan" required="">
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
            <!-- DIV DATA DIRI -->
              <div class="col-md-12" id="div_detail" style="display: none;">
                <input type="hidden" id="id_item" name="id_item">
                <div class="col-md-12">
                  <div class="card">
                    <!-- Header -->
                      <div class="card-header bg-success">
                        <h3 class="card-title">Detail <?= $judul ?></h3>
                        <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal_detail" onclick="fun_tambah_detail()">Tambah</button>
                      </div>
                    <!-- Header -->
                    <!-- Body -->
                      <div class="card-body">
                        <!-- Table -->
                          <table id="table_detail" class="table table-bordered table-striped" width="100%">
                            <thead>
                              <tr>
                                <th>Nama Barang</th>
                                <th>Persen</th>
                                <th>Harga</th>
                                <th>Updated</th>
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
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <form id="form_modal_detail">
                                  <input type="text" id="komposisi_id" name="komposisi_id" value="" style="display: none;">
                                  <input type="text" id="temp_item_id" name="temp_item_id" value="" style="display: none;">
                                  <div class="modal-body">
                                    <div class="card-body row">
                                      <div class="col-12">
                                        <div class="form-group row col-md-12">
                                          <label class="col-md-4">Nama Barang *</label>
                                          <div class="input-group col-md-8">
                                            <select id="komposisi_item" name="komposisi_item" class="form-control select2" required="">
                                            </select>
                                          </div>
                                        </div>
                                        <div class="form-group row col-md-12">
                                          <label class="col-md-4">Persen *</label>
                                          <div class="input-group col-md-8">
                                            <input type="number" class="form-control" id="komposisi_persen" name="komposisi_persen" value="" placeholder="Persen" step="any" required="">
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
                </div>
              </div>
            <!-- DIV DATA DIRI -->
            <!-- DIV DATA DIRI -->
              <div class="col-md-12" id="div_history" style="display: none;">
                <input type="hidden" id="id_item" name="id_item">
                <div class="col-md-12">
                  <div class="card">
                    <!-- Header -->
                      <div class="card-header bg-danger">
                        <h3 class="card-title">History <?= $judul ?></h3>
                      </div>
                    <!-- Header -->
                    <!-- Body -->
                      <div class="card-body row">
                        <!-- Table -->
                          <div class="col-md-6">
                            <table id="table_history" class="table table-bordered table-striped" width="100%">
                              <thead>
                                <tr>
                                  <th>No</th>
                                  <th>Harga</th>
                                  <th>Updated</th>
                                </tr>
                              </thead>
                            </table>
                          </div>
                          <div class="col-md-6" id="div_myChart">
                            <canvas id="myChart" style="width: 100%;"></canvas>
                          </div>
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