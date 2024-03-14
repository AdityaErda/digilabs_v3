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
                <h3 class="card-title">Seksi</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>

                <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal_seksi">Tambah</button>
                <label class="float-right">&nbsp;</label>
                <a href="<?= base_url('master/user/index_seksi_import?header_menu=0&menu_id=0&import_kode=0') ?>" class="btn btn-danger float-right">Import</a>
              </div>
              <!-- Header -->
              <!-- Body -->
              <div class="card-body">
                <!-- Table -->
                <table id="table_seksi" class="table table-bordered table-striped" width="100%">
                  <thead>
                    <tr>
                      <th>Seksi Kode</th>
                      <th>Seksi Nama</th>
                      <!-- <th>Nama Kasie</th> -->
                      <th>Updated</th>
                      <th>Tambah Kasie</th>
                      <th>Detail</th>
                      <th>Edit</th>
                      <th>Hapus</th>
                    </tr>
                  </thead>
                </table>
                <!-- Table -->
                <!-- Modal -->
                <div class="modal fade" id="modal_seksi">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Seksi</h4>
                      </div>
                      <form id="form_modal_seksi">
                        <input type="text" id="seksi_id" name="seksi_id" value="" style="display: none;">
                        <div class="modal-body">
                          <div class="card-body row">
                            <div class="col-12">
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Kode Seksi *</label>
                                <div class="input-group col-md-8">
                                  <input type="text" class="form-control" id="seksi_kode" name="seksi_kode" value="" placeholder="Kode Seksi" required="">
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Seksi Nama *</label>
                                <div class="input-group col-md-8">
                                  <input type="text" class="form-control" id="seksi_nama" name="seksi_nama" value="" placeholder="Seksi Nama" required="">
                                </div>
                              </div>
                              <!-- <div class="form-group row col-md-12">
                                <label class="col-md-4">Nama Kasie *</label>
                                <div class="input-group col-md-8">
                                <select class="select2 form-control" id="kasie_nama" name="kasie_nama"></select>
                                </div>
                              </div> -->
                              <div class="form-group row col-md-12" id="div_urgent">
                                <label class="col-md-4">Disposisi</label>
                                <div class="input-group col-md-8">
                                  <input type="checkbox" id="is_disposisi" name="is_disposisi" value="y" placeholder="">
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                          <button type="button" id="close_seksi" class="btn btn-default" data-dismiss="modal" onclick="fun_close_seksi()">Close</button>
                          <button type="submit" class="btn btn-success" id="simpan_seksi">Simpan</button>
                          <button type="submit" class="btn btn-primary" id="edit_seksi" style="display: none">Edit</button>
                        </div>
                      </form>
                    </div>
                    <!-- /.modal-content -->
                  </div>
                  <!-- /.modal-dialog -->
                </div>
                <!-- Modal -->
                <!-- Modal Kasie-->
                <div class="modal fade" id="modal_kasie">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Tamabah Kasie</h4>
                      </div>
                      <form id="form_modal_kasie">
                        <input type="text" id="identitas_kasie_nama" name="identitas_kasie_nama" value="" style="display: none;">
                        <div class="modal-body">
                          <div class="card-body row">
                            <div class="col-12">
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Nama Kasie</label>
                                <div class="input-group col-md-8">
                                  <select class="select2 form-control" id="kasie_nama" name="kasie_nama"></select>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                          <button type="button" id="close_kasie" class="btn btn-default" data-dismiss="modal" onclick="fun_close_kasie()">Close</button>
                          <button type="submit" class="btn btn-success" id="simpan_kasie">Simpan</button>
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
        <!-- DIV DATA DIRI -->
        <div class="col-md-12" id="div_detail" style="display: none;">
          <input type="text" id="temp_seksi_id" name="temp_seksi_id" style="display: none;">
          <div class="col-md-12">
            <div class="card">
              <!-- Header -->
              <div class="card-header bg-success">
                <h3 class="card-title"><?= $judul ?></h3>
                <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal" onclick="fun_tambah()">Tambah</button>
                <label class="float-right">&nbsp;</label>
                <a href="<?= base_url('master/user/index_import?header_menu=0&menu_id=0&import_kode=0') ?>" class="btn btn-danger float-right">Import</a>
              </div>
              <!-- Header -->
              <!-- Body -->
              <div class="card-body">
                <!-- Table -->
                <table id="table" class="table table-bordered table-striped" width="100%">
                  <thead>
                    <tr>
                      <th>Role</th>
                      <th>Seksi</th>
                      <th>User Login</th>
                      <th>Nama Lengkap</th>
                      <th>Tempat Lahir</th>
                      <th>Tanggal Lahir</th>
                      <th>Updated</th>
                      <th>Tanda Tangan</th>
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
                        <input type="text" id="user_id" name="user_id" value="" style="display: none;">
                        <input type="text" id="id_seksi" name="id_seksi" value="" style="display: none;">
                        <div class="modal-body">
                          <div class="card-body row">
                            <div class="col-12">
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Nama Lengkap *</label>
                                <div class="input-group col-md-8">
                                  <input type="text" class="form-control" id="user_nama_lengkap" name="user_nama_lengkap" value="" placeholder="Nama Lengkap" required="">
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Tempat Lahir</label>
                                <div class="input-group col-md-8">
                                  <input type="text" class="form-control" id="user_tempat_lahir" name="user_tempat_lahir" value="" placeholder="Tempat Lahir">
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Tanggal Lahir</label>
                                <div class="input-group col-md-8">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text">
                                      <i class="far fa-calendar-alt"></i>
                                    </span>
                                  </div>
                                  <input type="text" class="form-control float-right tanggal" id="user_tgl_lahir" name="user_tgl_lahir">
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Tanda Tangan</label>
                                <div class="input-group col-md-8">
                                  <input type="file" class="form-control" id="user_tanda_tangan" name="user_tanda_tangan">
                                </div>
                              </div>

                              <hr>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Role *</label>
                                <div class="input-group col-md-8">
                                  <select class="form-control select2" id="role_id" name="role_id" required="">
                                  </select>
                                </div>
                              </div>
                              <div class="form-group row col-md-12" id="div_seksi_id_user" style="display: none;">
                                <table width="100%">
                                  <tr>
                                    <td width="34%">
                                      <label class="col-md-4">Seksi *</label>
                                    </td>
                                    <td width="65%">
                                      <select class="form-control select2" id="seksi_id_user" name="seksi_id_user">
                                      </select>
                                    </td>
                                    <td width="1%">&nbsp;</td>
                                  </tr>
                                </table>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">User Login *</label>
                                <div class="input-group col-md-8">
                                  <input type="text" class="form-control" id="user_username" name="user_username" value="" placeholder="User Login" required="">
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Password *</label>
                                <div class="input-group col-md-8">
                                  <input type="password" class="form-control" id="user_password" name="user_password" value="" placeholder="Password" required="">
                                  <input type="hidden" class="form-control" id="user_password_lama" name="user_password_lama" value="" placeholder="Password">
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
                <div class="modal fade" id="modal_lihat">
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
                          <div class="card-body row" id="div_document" style="height: 600px;">
                          </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                          <button type="button" id="close" class="btn btn-default" data-dismiss="modal">Close</button>
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
      </div>
    </div>
  </section>
  <!-- Container Body -->
</div>
<!-- CONTAINER -->