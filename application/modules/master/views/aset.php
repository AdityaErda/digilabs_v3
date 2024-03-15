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
                <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal" onclick="fun_tambah()">Tambah</button>
                <label class="float-right">&nbsp;</label>
                <button type="button" class="btn btn-success float-right" onclick="fun_reset()">Reset Data</button>
                <label class="float-right">&nbsp;</label>
                <a href="<?= base_url('master/aset/index_import?header_menu=0&menu_id=0&import_kode=0') ?>" class="btn btn-danger float-right">Import</a>
              </div>
              <!-- Header -->
              <!-- Body -->
              <div class="card-body">
                <!-- Table -->
                <table id="table" class="table table-bordered table-striped" width="100%">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Aset Nomor</th>
                      <th>Jenis Aset</th>
                      <th>Tahun Perolehan</th>
                      <th>Nama Aset</th>
                      <th>Nilai Perolehan</th>
                      <th>Penyusutan SD THN Lalu</th>
                      <th>Penyusutan Tahun Ini</th>
                      <th>Total Penyusutan</th>
                      <th>Nilai Buku</th>
                      <th>Jumlah</th>
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
                        <input type="text" id="aset_id" name="aset_id" value="" style="display: none;">
                        <input type="text" id="temp_aset_id" name="temp_aset_id" value="" style="display: none;">
                        <div class="modal-body">
                          <div class="card-body row">
                            <div class="col-12">
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Nomor Aset *</label>
                                <div class="input-group col-md-8">
                                  <input type="number" class="form-control" id="aset_nomor_utama" name="aset_nomor_utama" value="" placeholder="Nomor Aset">
                                </div>
                                <i style="display:none; color:red" class="invalid offset-md-4" id="aset_nomor_utama_alert">Nomor Aset Tidak Boleh Kosong</i>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Nama Aset *</label>
                                <div class="input-group col-md-8">
                                  <input type="text" class="form-control" id="aset_nama" name="aset_nama" value="" placeholder="Nama Aset">
                                </div>
                                <i style="display:none; color:red" class="invalid offset-md-4" id="aset_nama_alert">Nama Aset Tidak Boleh Kosong</i>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Tahun Perolehan</label>
                                <div class="input-group col-md-8">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text">
                                      <i class="far fa-calendar-alt"></i>
                                    </span>
                                  </div>
                                  <input type="text" class="form-control float-right tanggal" id="aset_tahun_perolehan" name="aset_tahun_perolehan" onchange="fun_umur(this.value)">
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Umur Ekonomis *</label>
                                <div class="input-group col-md-8">
                                  <input type="number" class="form-control" id="aset_umur_ekonomis" name="aset_umur_ekonomis" value="" placeholder="Umur Ekonomis" onkeyup="fun_nilai_buku($('#aset_nilai_perolehan').val(), $('#aset_residu').val(), $('#aset_umur').val(), this.value)">
                                </div>
                                <i style="display:none; color:red" class="invalid offset-md-4" id="aset_umur_ekonomis_alert">Umur Ekonomis Tidak Boleh Kosong</i>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Umur Aset</label>
                                <div class="input-group col-md-8">
                                  <input type="text" class="form-control" id="aset_umur" name="aset_umur" value="" placeholder="Umur Aset" readonly="">
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Nilai Perolehan *</label>
                                <div class="input-group col-md-8">
                                  <input type="number" class="form-control" id="aset_nilai_perolehan" name="aset_nilai_perolehan" value="" placeholder="Nilai Perolehan" onkeyup="fun_nilai_buku(this.value, $('#aset_residu').val(), $('#aset_umur').val(), $('#aset_umur_ekonomis').val())">
                                </div>
                                <i style="display:none; color:red" class="invalid offset-md-4" id="aset_nilai_perolehan_alert">Nilai Perolehan Tidak Boleh Kosong</i>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Residu *</label>
                                <div class="input-group col-md-8">
                                  <input type="number" class="form-control" id="aset_residu" name="aset_residu" value="" placeholder="Residu" onkeyup="fun_nilai_buku($('#aset_nilai_perolehan').val(), this.value, $('#aset_umur').val(), $('#aset_umur_ekonomis').val())">
                                </div>
                                <i style="display:none; color:red" class="invalid offset-md-4" id="aset_residu_alert">Residu Tidak Boleh Kosong</i>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Penyusutan SD THN Lalu</label>
                                <div class="input-group col-md-8">
                                  <input type="number" class="form-control" id="aset_penyusutan_thn_lalu" name="aset_penyusutan_thn_lalu" value="" placeholder="Penyusutan SD THN Lalu" readonly="">
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Penyusutan Tahun Ini</label>
                                <div class="input-group col-md-8">
                                  <input type="number" class="form-control" id="aset_penyusutan_thn_ini" name="aset_penyusutan_thn_ini" value="" placeholder="Penyusutan Tahun Ini" readonly="">
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Total Penyusutan</label>
                                <div class="input-group col-md-8">
                                  <input type="number" class="form-control" id="aset_total_penyusutan" name="aset_total_penyusutan" value="" placeholder="Total Penyusutan" readonly="">
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Nilai Buku</label>
                                <div class="input-group col-md-8">
                                  <input type="number" class="form-control" id="aset_nilai_buku" name="aset_nilai_buku" value="" placeholder="Nilai Penyusutan" readonly="">
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Foto</label>
                                <div class="input-group col-md-8">
                                  <input type="file" class="form-control" id="aset_foto" name="aset_foto" value="" placeholder="" accept="image/jpeg, image/png, image/gif, image/bmp">
                                </div>
                              </div>
                              <div class="form-group row col-md-12" id="foto_sebelumnya" style="display: none;">
                                <table width="100%">
                                  <tr>
                                    <td width="40%"><label>Foto Sebelumnya</label></td>
                                    <td width="60%"><img src="" alt="" style="width: 100px" id="aset_foto_sebelumnya"></td>
                                  </tr>
                                </table>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Is Aset</label>
                                <div class="input-group col-md-8">
                                  <input type="checkbox" id="is_aset" name="is_aset" value="y" placeholder="" checked="">
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <table id="dg_document" title="Document" style="width:100%" toolbar="#toolbar" pagination="true" idField="id" rownumbers="true" fitColumns="true" singleSelect="true">
                                  <thead>
                                    <tr>
                                      <th field="aset_document_nama" width="50" editor="{type:'text', options:{required:true}}">Nama</th>
                                      <th field="aset_document_file" width="50" editor="{type:'label'}">File</th>
                                    </tr>
                                  </thead>
                                </table>
                                <div id="toolbar">
                                  <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="fun_tambah_document()">New</a>
                                  <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="fun_hapus_document()">Delete</a>
                                  <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="fun_simpan_document()">Save</a>
                                  <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:$('#dg_document').edatagrid('cancelRow')">Cancel</a>
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
                <!-- Modal -->
                <div class="modal fade" id="modal_foto">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title"><?= $judul ?></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <form id="form_modal">
                        <div class="modal-body">
                          <center><img src="" alt="" id="foto" style="width: 300px;"></center>
                        </div>
                        <div class="modal-footer justify-content-between">
                          <button type="button" id="close" class="btn btn-default" data-dismiss="modal">Close</button>
                          <button type="button" class="btn btn-primary" id="edit" style="display: none">Edit</button>
                        </div>
                      </form>
                    </div>
                    <!-- /.modal-content -->
                  </div>
                  <!-- /.modal-dialog -->
                </div>
                <!-- Modal -->
                <!-- Modal -->
                <div class="modal fade" id="modal_download">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title"><?= $judul ?></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <form id="form_modal">
                        <div class="modal-body">
                          <div class="card-body row">
                            <div class="col-12">
                              <table id="table_download" class="table table-bordered table-striped" width="100%">
                                <thead>
                                  <tr>
                                    <th>Nama File</th>
                                    <th>Download</th>
                                  </tr>
                                </thead>
                              </table>
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                          <button type="button" id="close" class="btn btn-default" data-dismiss="modal">Close</button>
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

        <!-- DIV DATA DIRI -->
        <div class="col-md-12" id="div_detail" style="display: none;">
          <input type="text" id="id_aset" name="id_aset" style="display: none;">
          <div class="col-md-12">
            <div class="card">
              <!-- Header -->
              <div class="card-header bg-success">
                <h3 class="card-title">Detail <?= $judul ?></h3>
                <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal_detail" onclick="fun_tambah_detail()">Tambah</button>
                <label class="float-right">&nbsp;</label>
                <a href="<?= base_url('master/aset/index_import_detail?header_menu=0&menu_id=0&import_kode=0') ?>" class="btn btn-danger float-right">Import</a>
              </div>
              <!-- Header -->
              <!-- Body -->
              <div class="card-body">
                <!-- Table -->
                <table id="table_detail" class="table table-bordered table-striped" width="100%">
                  <thead>
                    <tr>
                      <th>Merk</th>
                      <th>Serial Number</th>
                      <th>Pengelola / Pegguna Aset</th>
                      <th>Edit</th>
                      <th>Hapus</th>
                      <th>Barcode</th>
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
                        <input type="text" id="temp_aset_id_detail" name="temp_aset_id_detail" value="" style="display: none;">
                        <input type="text" id="aset_detail_id" name="aset_detail_id" value="" style="display: none;">
                        <div class="modal-body">
                          <div class="card-body row">
                            <div class="col-12">
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Serial Number</label>
                                <div class="input-group col-md-8">
                                  <input type="text" class="form-control" id="aset_nomor" name="aset_nomor" value="" placeholder="Serial Number">
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Merk</label>
                                <div class="input-group col-md-8">
                                  <input type="text" class="form-control" id="aset_detail_merk" name="aset_detail_merk" value="" placeholder="Merk">
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Pengelola / Pengguna Aset</label>
                                <div class="input-group col-md-8">
                                  <select class="form-control select2" id="peminta_jasa_id" name="peminta_jasa_id">
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
        <!-- DIV DATA DIRI -->
      </div>
    </div>
  </section>
  <!-- Container Body -->
</div>
<!-- CONTAINER -->