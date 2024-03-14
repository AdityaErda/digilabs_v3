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
                <a href="<?= base_url('master/perhitungan_sample/index_import?header_menu=0&menu_id=0&import_kode=0') ?>" class="btn btn-danger float-right">Import</a>
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
                      <th>Parameter Rumus</th>
                      <th>Batas Desimal </th>
                      <th>Satuan</th>
                      <th>Metode</th>
                      <th>Aktif</th>
                      <!-- <th>Batasan mg/NM3</th> -->
                      <th>Updated</th>
                      <!-- <th>List Rumus</th> -->
                      <!-- <th>Detail</th> -->
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
                        <input type="text" id="rumus_id" name="rumus_id" value="" style="display: none;">
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
                                <label class="col-md-4">Parameter Rumus</label>
                                <div class="input-group col-md-8">
                                  <input type="text" class="form-control" id="rumus_nama" name="rumus_nama" value="" placeholder="Parameter Rumus" required>
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Desimal Angka</label>
                                <div class="input-group col-md-8">
                                  <input type="number" class="form-control" name="desimal_angka" id="desimal_angka">
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Satuan</label>
                                <div class="input-group col-md-8">
                                  <input type="text" class="form-control" name="satuan_sample" id="satuan_sample" value="">
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Metode</label>
                                <div class="input-group col-md-8">
                                  <input type="text" class="form-control" name="metode" id="metode" value="">
                                </div>
                              </div>
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
                <!-- Modal -->
                <!-- Modal Rumus-->
                <div class="modal fade" id="modal_list_rumus">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Rumus Sample</h4>
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
                                <!-- <th>Parameter Rumus</th> -->
                                <th>Rumus</th>
                              </tr>
                            </thead>
                          </table>
                        </div>
                        <div class="modal-footer justify-content-between">
                          <button type="button" id="close" onclick="fun_close()" class="btn btn-default" data-dismiss="modal">Close</button>
                          <!-- <button type="button" class="btn btn-primary" id="edit" style="display: none">Edit</button> -->
                        </div>
                      </form>
                    </div>
                    <!-- /.modal-content -->
                  </div>
                  <!-- /.modal-dialog -->
                </div>
                <!-- Modal Rumus-->
              </div>
              <!-- Body -->
            </div>
          </div>
        </div>
        <!-- DIV DATA DIRI -->
        <!-- DIV DETAIL DATA DIRI -->
        <div class="col-md-12" id="div_detail" style="display: none;">
          <input type="hidden" id="id_rumus_detail" name="id_rumus_detail">
          <div class="col-md-12">
            <div class="card">
              <!-- Header -->
              <div class="card-header bg-success">
                <h3 class="card-title">Detail Perhitungan Rumus Sample</h3>
                <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal_detail" onclick="fun_tambah_detail()">Tambah</button>
                <label class="float-right">&nbsp;</label>
                <!-- <a href="<?= base_url('master/perhitungan_sample/index_import_detail?header_menu=0&menu_id=0&import_kode=0') ?>" class="btn btn-danger float-right">Import</a> -->
                <a href="javascript:;" class="btn btn-danger float-right" onclick="fun_import_detail()">Import</a>
              </div>&nbsp;
              <!-- Header -->
              <!-- Body -->
              <div class="card-body">
                <!-- Table -->
                <table id="table_detail" class="table table-bordered table-striped" width="100%">
                  <thead>
                    <tr>
                      <!-- <th>No</th> -->
                      <!-- <th>Urutan Rumus</th> -->
                      <th>Urutan Template</th>
                      <th>Nama Parameter</th>
                      <th>Nilai Inputan Rumus</th>
                      <th>Jenis Rumus</th>
                      <th>Updated</th>
                      <!-- <th>Edit</th>
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
                        <h4 class="modal-title"><?= $judul ?></h4>
                      </div>
                      <form id="form_modal_detail">
                        <input type="text" id="temp_rumus_id" name="temp_rumus_id" style="display: none;">
                        <input type="text" id="rumus_detail_id" name="rumus_detail_id" value="" style="display: none;">
                        <div class="modal-body">
                          <div class="card-body row">
                            <div class="col-12">
                              <!-- <div class="form-group row col-md-12">
                                <label class="col-md-4">Urutan Rumus</label>
                                <div class="input-group col-md-8">
                                  <input type="number" name="rumus_detail_urut" id="rumus_detail_urut" class="form-control" placeholder="Urutan Rumus">
                                </div>
                              </div> -->
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Urutan Template</label>
                                <div class="input-group col-md-8">
                                  <input type="number" name="rumus_detail_template" id="rumus_detail_template" class="form-control" placeholder="Urutan Template">
                                  <!-- <input type="text" class="form-control" name="rumus_detail_template" id="rumus_detail_template" value="" onkeyup="func_cekNomorKembar(this.value)" placeholder="Urutan Template"> -->
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Nama Parameter</label>
                                <div class="input-group col-md-8">
                                  <input type="text" class="form-control" id="rumus_detail_nama" name="rumus_detail_nama" value="" placeholder="Nama Parameter">
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
                                    <!-- <option value="O">Operasi</option> -->
                                    <option value="A">Auto</option>
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
          </div>
        </div>
        <!-- DIV DETAIL DATA DIRI -->
      </div>
    </div>
  </section>
  <!-- Container Body -->
</div>
<!-- CONTAINER -->