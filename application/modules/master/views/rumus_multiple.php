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
                <a href="<?= base_url('master/rumus_multiple/index_import?header_menu=0&menu_id=0&import_kode=0') ?>" class="btn btn-danger float-right">Import</a>
              </div>&nbsp;
              <!-- Header -->
              <!-- Body -->
              <div class="card-body">
                <!-- Table -->
                <table id="table" class="table table-bordered table-striped" width="100%">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Jenis Sample</th>
                      <th>Metode</th>
                      <!-- <th>Detail</th> -->
                      <!-- <th>Edit</th> -->
                      <!-- <th>Hapus</th> -->
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
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <form id="form_modal">
                        <input type="text" id="multiple_rumus_id" name="multiple_rumus_id" value="" style="display: none;">
                        <div class="modal-body">
                          <div class="card-body row">
                            <div class="col-12">
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Jenis sample</label>
                                <div class="input-group col-md-8">
                                  <select class="form-control select2" id="jenis_id" name="jenis_id" required="">
                                  </select>
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Metode</label>
                                <div class="input-group col-md-8">
                                  <input type="text" class="form-control" name="metode" id="metode" value="">
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
        <!-- DIV PARAMETER -->
        <div class="col-md-12" id="div_detail" style="display: none;">
          <input type="hidden" id="id_multiple_rumus_detail" name="id_multiple_rumus_detail">
          <div class="col-md-12">
            <div class="card">
              <!-- Header -->
              <div class="card-header bg-secondary">
                <h3 class="card-title">Parameter Rumus</h3>
                <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal_detail" onclick="fun_tambah_parameter()">Tambah</button>
                <label class="float-right">&nbsp;</label>
                <a href="javascript:;" class="btn btn-danger float-right" onclick="fun_import_parameter()">Import</a>
              </div>&nbsp;
              <!-- Header -->
              <!-- Body -->
              <div class="card-body">
                <!-- Table -->
                <input type="hidden" id="temp_detail_parameter" name="temp_detail_parameter">
                <table id="table_parameter" class="table table-bordered table-striped" width="100%">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Parameter Rumus</th>
                      <th>Satuan</th>
                      <!-- <th>List Rumus</th>
                      <th>Detail</th>
                      <th>Edit</th>
                      <th>Hapus</th> -->
                      <th>Action</th>
                    </tr>
                  </thead>
                </table>
                <!-- Table -->
                <!-- Modal -->
                <div class="modal fade" id="modal_detail">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Parameter Rumus</h4>
                      </div>
                      <form id="form_modal_detail">
                        <input type="text" id="temp_multiple_rumus_id" name="temp_multiple_rumus_id" style="display: none;">
                        <input type="text" id="detail_multiple_rumus_id" name="detail_multiple_rumus_id" value="" style="display: none;">
                        <div class="modal-body">
                          <div class="card-body row">
                            <div class="col-12">
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Parameter Rumus</label>
                                <div class="input-group col-md-8">
                                  <input type="text" name="parameter_rumus" id="parameter_rumus" class="form-control">
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Satuan</label>
                                <div class="input-group col-md-8">
                                  <input type="text" name="satuan_parameter" id="satuan_parameter" class="form-control">
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                          <button type="button" id="close_detail" class="btn btn-default" data-dismiss="modal" onclick="fun_close_parameter()">Close</button>
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
        <!-- DIV PARAMETER -->
        <!-- Modal Rumus-->
        <div class="modal fade" id="modal_list_rumus">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Rumus Sample Multiple</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form id="form_list_rumus">
                <div class="modal-body">
                  <table id="table_list_rumus" class="table table-bordered " width="100%">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Rumus</th>
                      </tr>
                    </thead>
                  </table>
                </div>
                <div class="modal-footer justify-content-between">
                  <button type="button" id="close_detail" onclick="fun_close_parameter()" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
              </form>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- Modal Rumus-->
        <!-- DIV DETAIL PARAMETER -->
        <div class="col-md-12" id="div_detail_parameter" style="display: none;">
          <div class="col-md-12">
            <div class="card">
              <!-- Header -->
              <div class="card-header bg-secondary">
                <h3 class="card-title">Detail Parameter</h3>
                <button type="button" class="btn btn-primary float-right" onclick="fun_parameter_detail($('#temp_detail_parameter').val())">Tambah</button>
                <label class="float-right">&nbsp;</label>
                <a href="javascript:;" class="btn btn-danger float-right" onclick="fun_import_detail()">Import</a>
              </div>&nbsp;
              <!-- Header -->
              <!-- Body -->
              <div class="card-body">
                <!-- Table -->
                <table id="table_detail_parameter" class="table table-bordered table-striped" width="100%">
                  <thead>
                    <tr>
                      <!-- <th>No</th> -->
                      <th>Urutan Rumus</th>
                      <th>Nama Parameter</th>
                      <th>Nilai Inputan Rumus</th>
                      <!-- <th>Urutan Template</th> -->
                      <th>Jenis Rumus</th>
                      <th>Edit</th>
                      <th>Hapus</th>
                    </tr>
                  </thead>
                </table>
                <!-- Table -->
                <!-- Modal -->
                <div class="modal fade" id="modal_detail_parameter">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Detail Parameter</h4>
                      </div>
                      <form id="form_modal_detail_parameter">
                        <input type="text" id="id_detail_parameter_rumus" name="id_detail_parameter_rumus" style="display: none;">
                        <input type="text" id="detail_parameter_rumus_id" name="detail_parameter_rumus_id" value="" style="display: none;">
                        <div class="modal-body">
                          <div class="card-body row">
                            <div class="col-12">
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Urutan Rumus</label>
                                <div class="input-group col-md-8">
                                  <input type="number" name="rumus_detail_urut" id="rumus_detail_urut" class="form-control" placeholder="Urutan Rumus">
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Nama Parameter</label>
                                <div class="input-group col-md-8">
                                  <input type="text" class="form-control" id="detail_parameter_rumus" name="detail_parameter_rumus" value="" placeholder="Nama Parameter">
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Nilai Inputan Rumus</label>
                                <div class="input-group col-md-8">
                                  <input type="text" class="form-control" id="rumus_detail_input" name="rumus_detail_input" value="" placeholder="Nilai Inputan Rumus">
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Jenis Rumus</label>
                                <div class="input-group col-md-8">
                                  <select class="form-control select2" id="rumus_jenis" name="rumus_jenis">
                                    <option value="null">Pilih Jenis Rumus</option>
                                    <option value="I">Inputan</option>
                                    <option value="O">Operasi</option>
                                    <option value="A">Auto</option>
                                  </select>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                          <button type="button" id="close_detail_parameter" class="btn btn-default" data-dismiss="modal" onclick="fun_close_detail_parameter()">Close</button>
                          <button type="submit" class="btn btn-success" id="simpan_detail_parameter">Simpan</button>
                          <button type="submit" class="btn btn-primary" id="edit_detail_parameter" style="display: none">Edit</button>
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
        <!-- DIV DETAIL PARAMETER -->
      </div>
    </div>
  </section>
  <!-- Container Body -->
</div>
<!-- CONTAINER -->