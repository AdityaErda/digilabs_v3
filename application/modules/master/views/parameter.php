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
  <?php
  $sql = $this->db->query("SELECT * FROM global.global_tenaga_kerja ORDER BY tenaga_kerja_jabatan ASC");
  $data = $sql->result_array();
  ?>
  <!-- Container Body -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- DIV PARAMETER -->
        <div class="col-md-12">
          <div class="card">
            <!-- Header -->
            <div class="card-header bg-warning">
              <h3 class="card-title"><?= $judul ?></h3>
              <button type="button" class="btn btn-primary float-right ml-2" data-toggle="modal" data-target="#modal">Tambah</button>
            </div>
            <!-- Header -->
            <!-- Body -->
            <div class="card-body">
              <!-- Table -->
              <input type="hidden" id="temp_parameter_id" name="temp_parameter_id">
              <table id="table" class="table table-bordered table-striped" width="100%">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Parameter</th>
                    <th>Total Jasa</th>
                    <th>Total Material</th>
                    <th>Total Aset</th>
                    <th>Biaya Lain-lain</th>
                    <th>Medium</th>
                    <th>Very Fast</th>
                    <th>Grand Total</th>
                    <th>Edit</th>
                    <th>Hapus</th>
                    <th>Detail</th>
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
                      <input type="text" id="parameter_id" name="parameter_id" value="" style="display: none;">
                      <div class="modal-body">
                        <div class="card-body row">
                          <div class="col-12">
                            <div class="form-group row col-md-12">
                              <label class="col-md-4">Nama Parameter</label>
                              <div class="input-group col-md-8">
                                <input type="text" class="form-control" id="parameter_nama" name="parameter_nama" value="" placeholder="Nama Parameter">
                              </div>
                            </div>
                            <div class="form-group row col-md-12">
                              <label class="col-md-4">Biaya Lain-lain</label>
                              <div class="input-group col-md-8">
                                <input type="number" step="any" class="form-control" id="parameter_biaya_lain" name="parameter_biaya_lain" value="" placeholder="Biaya Lain-lain">
                              </div>
                            </div>
                            <div class="form-group row col-md-12">
                              <label class="col-md-4">Medium</label>
                              <div class="input-group col-md-8">
                                <input type="number" class="form-control" id="parameter_medium" name="parameter_medium" value="" placeholder="Medium">
                              </div>
                            </div>
                            <div class="form-group row col-md-12">
                              <label class="col-md-4">Very Fast</label>
                              <div class="input-group col-md-8">
                                <input type="number" class="form-control" id="parameter_very_fast" name="parameter_very_fast" value="" placeholder="Very Fast">
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
        <!-- DIV PARAMETER -->
        <!-- DIV JASA -->
        <div class="col-md-12">
          <div class="card" id="div_jasa" style="display: none;">
            <!-- Header -->
            <div class="card-header bg-secondary">
              <h3 class="card-title">Jasa Parameter</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-secondary btn-sm" data-card-widget="collapse" title="Collapse"><i class="fas fa-minus"></i></button>
              </div>
              <center><button type="button" class="btn btn-primary" onclick="fun_modal_jasa($('#temp_parameter_id').val())">Proses</button></center>
            </div>
            <!-- Header -->
            <!-- Body -->
            <div class="card-body">
              <!-- Table -->
              <table id="table_jasa" class="table table-bordered table-striped" width="100%">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Jabatan</th>
                    <th>UHPD</th>
                    <th>Honorarium</th>
                    <th>Durasi</th>
                    <th>Grand Total</th>
                  </tr>
                </thead>
              </table>
              <!-- Table -->
              <!-- Modal -->
              <div class="modal fade" id="modal_jasa">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Jasa Parameter</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <form id="form_modal_jasa">
                      <input type="text" id="id_parameter_jasa" name="id_parameter_jasa" value="" style="display: none;">
                      <div class="modal-body">
                        <div class="card-body row">
                          <div class="col-12">
                            <table id="table_uhpd" class="table table-bordered table-striped" width="100%">
                              <thead>
                                <tr>
                                  <th>Jabatan</th>
                                  <th>UHPD</th>
                                  <th>Honorarium</th>
                                  <th>Durasi (Jam)</th>
                                  <th>Total</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php foreach ($data as $key => $value) : ?>
                                  <tr>
                                    <?php if ($value['tenaga_kerja_jabatan'] == '1') : ?>
                                      <td>AVP</td>
                                    <?php elseif ($value['tenaga_kerja_jabatan'] == '2') : ?>
                                      <td>KASI</td>
                                    <?php elseif ($value['tenaga_kerja_jabatan'] == '3') : ?>
                                      <td>KARU</td>
                                    <?php elseif ($value['tenaga_kerja_jabatan'] == '4') : ?>
                                      <td>Pelaksana</td>
                                    <?php else : ?>
                                      <td>-</td>
                                    <?php endif ?>
                                    <td><input type="number" step="any" id="uhpd_<?= $value['tenaga_kerja_id'] ?>" name="uhpd[<?= $value['tenaga_kerja_id'] ?>]" value="<?= $value['tenaga_kerja_uhpd'] ?>" class="form-control" readonly></td>
                                    <td><input type="number" step="any" id="honorarium_<?= $value['tenaga_kerja_id'] ?>" name="honorarium[<?= $value['tenaga_kerja_id'] ?>]" value="<?= $value['tenaga_kerja_honorarium'] ?>" class="form-control" readonly></td>
                                    <td><input type="number" step="any" id="durasi_<?= $value['tenaga_kerja_id'] ?>" name="durasi[<?= $value['tenaga_kerja_id'] ?>]" class="form-control" onkeyup="fun_total_jasa(this.id, this.value)"></td>
                                    <td><input type="number" step="any" id="total_<?= $value['tenaga_kerja_id'] ?>" name="total[<?= $value['tenaga_kerja_id'] ?>]" class="form-control" readonly></td>
                                  </tr>
                                <?php endforeach ?>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer justify-content-between">
                        <button type="button" id="close_jasa" class="btn btn-default" data-dismiss="modal" onclick="fun_close_jasa()">Close</button>
                        <button type="submit" class="btn btn-success" id="simpan_jasa">Simpan</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <!-- Modal -->
            </div>
            <!-- Body -->
          </div>
        </div>
        <!-- DIV JASA -->
        <!-- DIV MATERIAL -->
        <div class="col-md-12">
          <div class="card" id="div_material" style="display: none;">
            <!-- Header -->
            <div class="card-header bg-secondary">
              <h3 class="card-title">Material Parameter</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-secondary btn-sm" data-card-widget="collapse" title="Collapse"><i class="fas fa-minus"></i></button>
              </div>
              <center><button type="button" class="btn btn-primary" onclick="fun_modal_material($('#temp_parameter_id').val())">Tambah</button></center>
            </div>
            <!-- Header -->
            <!-- Body -->
            <div class="card-body">
              <!-- Table -->
              <table id="table_material" class="table table-bordered table-striped" width="100%">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Material</th>
                    <th>Satuan</th>
                    <th>Harga Satuan</th>
                    <th>Jumlah</th>
                    <th>Grand Total</th>
                    <th>Edit</th>
                    <th>Hapus</th>
                  </tr>
                </thead>
              </table>
              <!-- Table -->
              <!-- Modal -->
              <div class="modal fade" id="modal_material">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Material Parameter</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <form id="form_modal_material">
                      <input type="text" id="id_parameter_material" name="id_parameter_material" value="" style="display: none;">
                      <input type="text" id="parameter_material_id" name="parameter_material_id" value="" style="display: none;">
                      <div class="modal-body">
                        <div class="card-body row">
                          <div class="col-12">
                            <div class="form-group row col-md-12">
                              <label class="col-md-4">Nama Material</label>
                              <div class="input-group col-md-8">
                                <select class="form-control select2" id="id_material" name="id_material" onchange="fun_material(this.value)"></select>
                              </div>
                            </div>
                            <div class="form-group row col-md-12">
                              <label class="col-md-4">Satuan</label>
                              <div class="input-group col-md-8">
                                <input type="text" class="form-control" id="item_satuan" name="item_satuan" readonly>
                              </div>
                            </div>
                            <div class="form-group row col-md-12">
                              <label class="col-md-4">Harga Satuan</label>
                              <div class="input-group col-md-8">
                                <input type="text" class="form-control" id="item_harga" name="item_harga" readonly>
                              </div>
                            </div>
                            <div class="form-group row col-md-12">
                              <label class="col-md-4">Jumlah</label>
                              <div class="input-group col-md-8">
                                <input type="number" step="any" class="form-control" id="parameter_material_jumlah" name="parameter_material_jumlah" onkeyup="fun_total_material(this.value)">
                              </div>
                            </div>
                            <div class="form-group row col-md-12">
                              <label class="col-md-4">Grand Total</label>
                              <div class="input-group col-md-8">
                                <input type="number" step="any" class="form-control" id="parameter_material_grand_total" name="parameter_material_grand_total" readonly>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer justify-content-between">
                        <button type="button" id="close_material" class="btn btn-default" data-dismiss="modal" onclick="fun_close_material()">Close</button>
                        <button type="submit" class="btn btn-success" id="simpan_material">Simpan</button>
                        <button type="submit" class="btn btn-primary" id="edit_material" style="display: none">Edit</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <!-- Modal -->
            </div>
            <!-- Body -->
          </div>
        </div>
        <!-- DIV MATERIAL -->
        <!-- DIV ASET -->
        <div class="col-md-12">
          <div class="card" id="div_aset" style="display: none;">
            <!-- Header -->
            <div class="card-header bg-secondary">
              <h3 class="card-title">Aset Parameter</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-secondary btn-sm" data-card-widget="collapse" title="Collapse"><i class="fas fa-minus"></i></button>
              </div>
              <center><button type="button" class="btn btn-primary" onclick="fun_modal_aset($('#temp_parameter_id').val())">Tambah</button></center>
            </div>
            <!-- Header -->
            <!-- Body -->
            <div class="card-body">
              <!-- Table -->
              <table id="table_aset" class="table table-bordered table-striped" width="100%">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Aset</th>
                    <th>Harga Satuan</th>
                    <th>Umur Ekonomois (Tahun)</th>
                    <th>Durasi Pemakaian (Jam)</th>
                    <th>Grand Total</th>
                    <th>Edit</th>
                    <th>Hapus</th>
                  </tr>
                </thead>
              </table>
              <!-- Table -->
              <!-- Modal -->
              <div class="modal fade" id="modal_aset">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Aset Parameter</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <form id="form_modal_aset">
                      <input type="text" id="id_parameter_aset" name="id_parameter_aset" value="" style="display: none;">
                      <input type="text" id="parameter_aset_id" name="parameter_aset_id" value="" style="display: none;">
                      <div class="modal-body">
                        <div class="card-body row">
                          <div class="col-12">
                            <div class="form-group row col-md-12">
                              <label class="col-md-4">Nama Aset</label>
                              <div class="input-group col-md-8">
                                <select class="form-control select2" id="id_aset" name="id_aset" onchange="fun_aset(this.value)"></select>
                              </div>
                            </div>
                            <div class="form-group row col-md-12">
                              <label class="col-md-4">Harga</label>
                              <div class="input-group col-md-8">
                                <input type="text" class="form-control" id="aset_nilai_perolehan" name="aset_nilai_perolehan" readonly>
                              </div>
                            </div>
                            <div class="form-group row col-md-12">
                              <label class="col-md-4">Umur Ekonomis (Tahun)</label>
                              <div class="input-group col-md-8">
                                <input type="text" class="form-control" id="aset_umur" name="aset_umur" readonly>
                              </div>
                            </div>
                            <div class="form-group row col-md-12">
                              <label class="col-md-4">Durasi Pemakaian (Jam)</label>
                              <div class="input-group col-md-8">
                                <input type="number" step="any" class="form-control" id="parameter_aset_jumlah" name="parameter_aset_jumlah" onkeyup="fun_total_aset(this.value)">
                              </div>
                            </div>
                            <div class="form-group row col-md-12">
                              <label class="col-md-4">Grand Total</label>
                              <div class="input-group col-md-8">
                                <input type="number" step="any" class="form-control" id="parameter_aset_grand_total" name="parameter_aset_grand_total" readonly>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer justify-content-between">
                        <button type="button" id="close_aset" class="btn btn-default" data-dismiss="modal" onclick="fun_close_aset()">Close</button>
                        <button type="submit" class="btn btn-success" id="simpan_aset">Simpan</button>
                        <button type="submit" class="btn btn-primary" id="edit_aset" style="display: none">Edit</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <!-- Modal -->
            </div>
            <!-- Body -->
          </div>
        </div>
        <!-- DIV ASET -->
      </div>
    </div>
  </section>
  <!-- Container Body -->
</div>
<!-- CONTAINER -->