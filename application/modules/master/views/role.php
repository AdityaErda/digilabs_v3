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
                        <a href="<?= base_url('master/role/index_import/') ?>?header_menu=<?= $_GET['header_menu'] ?>&menu_id=<?= $_GET['menu_id'] ?>&import_kode=0" class="btn btn-danger float-right">Import</a>
                      </div>
                    <!-- Header -->
                    <!-- Body -->
                      <div class="card-body">
                        <!-- Table -->
                          <table id="table" class="table table-bordered table-striped" width="100%">
                            <thead>
                              <tr>
                                <th>Kode Role</th>
                                <th>Nama Role</th>
                                <th>Updated</th>
                                <th>Menu</th>
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
                                  <input type="text" id="role_id" name="role_id" value="" style="display: none;">
                                  <div class="modal-body">
                                    <div class="card-body row">
                                      <div class="col-12">
                                        <div class="form-group row col-md-12">
                                          <label class="col-md-4">Kode Role *</label>
                                          <div class="input-group col-md-8">
                                            <input type="text" class="form-control" id="role_kode" name="role_kode" value="" placeholder="Kode Role" required="">
                                          </div>
                                        </div>
                                        <div class="form-group row col-md-12">
                                          <label class="col-md-4">Nama Role *</label>
                                          <div class="input-group col-md-8">
                                            <input type="text" class="form-control" id="role_nama" name="role_nama" value="" placeholder="Nama Role" required="">
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="modal-footer justify-content-between">
                                    <button type="button" id="close" class="btn btn-default" data-dismiss="modal" onclick="fun_close()">Close</button>
                                    <button type="submit" class="btn btn-success" id="simpan">Simpan</button>
                                    <button type="submit" class="btn btn-primary" id="edit" style="display: none">Edit</button>
                                    <button class="btn btn-primary" type="button" id="loading_form" disabled style="display: none;">
                                      <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                      Loading...
                                    </button>
                                  </div>
                                </form>
                              </div>
                              <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                          </div>
                        <!-- Modal -->
                        <!-- Modal Menu -->
                          <div class="modal fade" id="modal_menu">
                            <div class="modal-dialog modal-lg">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h4 class="modal-title"><?= $judul ?> Menu</h4>
                                </div>
                                <form id="form_modal_menu">
                                  <input type="text" id="role_id_temp" name="role_id_temp" value="" style="display: none;">
                                  <div class="modal-body">
                                    <div class="card-body row">
                                      <div class="col-12">
                                        <table border="1" width="100%">
                                          <thead>
                                            <tr>
                                              <th><center>Menu</center></th>
                                              <th><center>Aktif</center></th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            <?php foreach ($menu as $value): ?>
                                              <tr>
                                                <td><?= ($value['header_menu'] == NULL) ? '<b><i><u>'.$value['menu_judul'].'</u></i></b>' : $value['menu_judul'] ?></td>
                                                <td align="center"><input type="checkbox" id="<?= $value['menu_id'] ?>" name="menu[]" value="<?= $value['menu_id'] ?>"></td>
                                              </tr>
                                            <?php endforeach ?>
                                          </tbody>
                                        </table>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="modal-footer justify-content-between">
                                    <button type="button" id="close_menu" class="btn btn-default" data-dismiss="modal" onclick="fun_close_menu()">Close</button>
                                    <button type="submit" class="btn btn-success">Simpan</button>
                                  </div>
                                </form>
                              </div>
                              <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                          </div>
                        <!-- Modal Menu -->
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