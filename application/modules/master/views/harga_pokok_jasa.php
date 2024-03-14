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
                <!-- <a href="<?= base_url('master/jenis_barang/index_import?header_menu=0&menu_id=0&import_kode=0') ?>" class="btn btn-danger float-right">Import</a> -->
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
                      <th>Item</th>
                      <th>Harga Item</th>
                      <th>Harga Aset</th>
                      <th>Harga Sample</th>
                      <th>Harga Total</th>
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
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <form id="form_modal">
                        <input type="text" id="harga_pokok_jasa_id" name="harga_pokok_jasa_id" value="" style="display: none;">
                        <div class="modal-body">
                          <div class="card-body row">
                            <div class="col-12">
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Item Barang</label>
                                <div class="input-group col-md-8">
                                    <select class="form-control select2" id="id_item" name="id_item"></select>
                                </div>
                              </div>
                              <div class="form-group row col-md-12"">
                                <label class="col-md-4">Harga Satuan</label>
                                <div class="input-group col-md-8">
                                    <input type="text" class="form-control" readonly id="penyimpanan_item_barang_harga_view" name="penyimpanan_item_barang_harga_view">
                                    <input type="hidden" class="form-control" readonly id="harga_item" name="harga_item">
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Aset</label>
                                <div class="input-group col-md-8">
                                    <select class="form-control select2" id="id_aset" name="id_aset"></select>
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Nilai Perolehan</label>
                                <div class="input-group col-md-8">
                                    <input type="text" class="form-control" readonly id="penyimpanan_aset_harga_view" name="penyimpanan_aset_harga_view">
                                    <input type="hidden" class="form-control" readonly id="harga_aset" name="harga_aset">
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Jenis sample uji</label>
                                <div class="input-group col-md-8">
                                    <select class="form-control select2" id="penyimpanan_jenis_sample" name="penyimpanan_jenis_sample" ></select>
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Identitas</label>
                                <div class="input-group col-md-8">
                                    <select class="form-control select2" id="id_sample" name="id_sample"></select>
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Harga</label>
                                <div class="input-group col-md-8">
                                    <input type="text" class="form-control" readonly id="penyimpanan_jenis_sample_det_harga_view" name="penyimpanan_jenis_sample_det_harga_view">
                                    <input type="hidden" class="form-control" readonly id="harga_sample" name="harga_sample">
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