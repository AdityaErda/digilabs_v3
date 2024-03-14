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
                <button type="button" class="btn btn-success float-right" onclick="fun_reset()">Reset Data</button>
                <label class="float-right">&nbsp;</label>
                <a href="<?= base_url('master/jenis_sample_uji/index_import?header_menu=0&menu_id=0&import_kode=0') ?>" class="btn btn-danger float-right">Import</a>
                <label class="float-right">&nbsp;</label>
                <a href="<?= base_url('master/jenis_sample_uji/cetakRumus') ?>" class="btn btn-info float-right" target="_BLANK">Cetak Rumus</a>
              </div>
              <!-- Header -->
              <!-- Body -->
              <div class="card-body">
                <!-- Table -->
                <table id="table" class="table table-bordered table-striped" width="100%">
                  <thead>
                    <tr>
                      <th>Kode Jenis Sample</th>
                      <th>Nama Jenis Sample</th>
                      <th>Jumlah Parameter</th>
                      <th>Pengambil Sample</th>
                      <th>Referensi Spesifikasi</th>
                      <th>Updated</th>
                      <th>Detail</th>
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
                        <input type="text" id="jenis_id" name="jenis_id" value="" style="display: none;">
                        <div class="modal-body">
                          <div class="card-body row">
                            <div class="col-12">
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Kode Jenis Sample</label>
                                <div class="input-group col-md-8">
                                  <input type="text" class="form-control" id="jenis_kode" name="jenis_kode" value="" placeholder="Kode Jenis Sample">
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Nama Jenis Sample</label>
                                <div class="input-group col-md-8">
                                  <input type="text" class="form-control" id="jenis_nama" name="jenis_nama" value="" placeholder="Nama Jenis Sample">
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Jumlah Parameter</label>
                                <div class="input-group col-md-8">
                                  <input type="number" class="form-control" id="jenis_parameter" name="jenis_parameter" value="" placeholder="Jumlah Parameter">
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Pengambil Sample</label>
                                <div class="input-group col-md-8">
                                  <input type="text" class="form-control" id="pengambil_sample" name="pengambil_sample" value="" placeholder="Pengambil Sample">
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Referensi Spesifikasi</label>
                                <div class="input-group col-md-8">
                                  <input type="text" class="form-control" id="referensi_spesifikasi" name="referensi_spesifikasi" value="" placeholder="Referensi Spesifikasi">
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
          <input type="hidden" id="id_jenis" name="id_jenis">
          <div class="col-md-12">
            <div class="card">
              <!-- Header -->
              <div class="card-header bg-success">
                <h3 class="card-title">Identitas</h3>
                <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal_detail" onclick="fun_tambah_detail()">Tambah</button>
                <label class="float-right">&nbsp;</label>
                <a href="<?= base_url('master/jenis_sample_uji/index_identitas_import?header_menu=0&menu_id=0&import_kode=0') ?>" class="btn btn-danger float-right">Import</a>
              </div>
              <!-- Header -->
              <!-- Body -->
              <div class="card-body">
                <!-- Table -->
                <table id="table_detail" class="table table-bordered table-striped" width="100%">
                  <thead>
                    <tr>
                      <th>Nama Identitas</th>
                      <th>Parameter</th>
                      <th>Harga</th>
                      <th>Rumus</th>
                      <th>Harga Rumus</th>
                      <th>Batasan Minimal</th>
                      <th>Batasan Maksimal</th>
                      <th>Spesifikasi Per Identitas</th>
                      <th>Updated</th>
                      <th>Rumus Harga</th>
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
                        <input type="text" id="temp_jenis_id" name="temp_jenis_id" style="display: none;">
                        <input type="text" id="identitas_id" name="identitas_id" value="" style="display: none;">
                        <div class="modal-body">
                          <div class="card-body row">
                            <div class="col-12">
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Nama Identitas</label>
                                <div class="input-group col-md-8">
                                  <input type="text" class="form-control" id="identitas_nama" name="identitas_nama" value="" placeholder="Nama Identitras">
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Parameter</label>
                                <div class="input-group col-md-8">
                                  <input type="text" class="form-control" id="identitas_parameter" name="identitas_parameter" value="" placeholder="Parameter">
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Harga</label>
                                <div class="input-group col-md-8">
                                  <input type="text" class="form-control" id="identitas_harga" name="identitas_harga" value="" placeholder="Harga">
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Batasan Minimal</label>
                                <div class="input-group col-md-8">
                                  <input type="number" class="form-control" id="batasan_minimal" name="batasan_minimal" value="" placeholder="Batasan Minimal">
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Batasan Maksimal</label>
                                <div class="input-group col-md-8">
                                  <input type="number" class="form-control" id="batasan_maksimal" name="batasan_maksimal" value="" placeholder="Batasan Maksimal">
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Spesifikasi Per Identitas</label>
                                <div class="input-group col-md-8">
                                  <input type="text" class="form-control" id="identitas_spesifikasi" name="identitas_spesifikasi" value="" placeholder="Spesifikasi Per Identitas">
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
                <!-- Modal Rumus-->
                <div class="modal fade" id="modal_rumus">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title"><?= $judul ?></h4>
                      </div>
                      <form id="form_modal_rumus">
                        <input type="text" id="temp_jenis_id_rumus" name="temp_jenis_id_rumus" style="display: none;">
                        <input type="text" id="identitas_id_rumus" name="identitas_id_rumus" value="" style="display: none;">
                        <div class="modal-body">
                          <div class="card-body row">
                            <div class="col-12">
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Harga</label>
                                <div class="input-group col-md-8">
                                  <input type="text" class="form-control" id="identitas_harga_rumus" name="identitas_harga_rumus" value="" placeholder="Harga" readonly>
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Jumlah Tenaga Kerja</label>
                                <div class="input-group col-md-8">
                                  <input type="text" class="form-control" id="identitas_jumlah_tenaga_kerja_rumus" name="identitas_jumlah_tenaga_kerja_rumus" value="" placeholder="Jumlah Tenaga Kerja" onkeypress="return numberOnly(event)">
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Harga Tambahan</label>
                                <div class="input-group col-md-8">
                                  <input type="text" class="form-control" id="identitas_harga_tambahan_rumus" name="identitas_harga_tambahan_rumus" value="" placeholder="Harga Tambahan" onkeypress="return numberOnly(event)">
                                </div>
                              </div>
                              <i class="text-danger">Rumus : (Harga * Jumlah Tenaga Kerja) + Biaya Tambahan</i>
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                          <button type="button" id="close_rumus" class="btn btn-default" data-dismiss="modal" onclick="fun_close_rumus()">Close</button>
                          <button type="submit" class="btn btn-success" id="simpan_rumus">Simpan</button>
                          <button type="submit" class="btn btn-primary" id="edit_rumus" style="display: none">Edit</button>
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
      </div>
    </div>
  </section>
  <!-- Container Body -->
</div>
<!-- CONTAINER -->