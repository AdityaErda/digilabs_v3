<!-- CONTAINER -->
<style>
  .panel {
    overflow: auto;
    height: 35%;
  }

  .header-table {
    position: sticky;
    top: 0;
  }
</style>

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
        <!-- FILTER -->
          <div class="col-md-12">
            <div class="card card-warning">
              <!-- Header -->
              <div class="card-header">
                <h3 class="card-title">Filter <?= $judul ?></h3>
              </div>
              <form id="filter">
                <div class="card-body">
                  <div class="row">
                    <div class="form-group col-md-3">
                      <label class="col-md-12">Periode Awal</label>
                      <div class='input-group date' id="tanggal_cari_awal">
                        <input name="tanggal_cari_awal" id="tanggal_cari_awal" class="datetimepicker form-control" type="text" inputmode="none" required="" value="<?= date('Y-m-01') ?>" />
                        <span class="input-group-text">
                          <span class="fa fa-calendar"></span>
                        </span>
                      </div>
                    </div>
                    <div class="form-group col-md-3">
                      <label class="col-md-12">Periode Akhir</label>
                      <div class='input-group date' id="tanggal_cari_akhir">
                        <input name="tanggal_cari_akhir" id="tanggal_cari_akhir" class="datetimepicker form-control" type="text" inputmode="none" required="" value="<?= date('Y-m-d') ?>" />
                        <span class="input-group-text">
                          <span class="fa fa-calendar"></span>
                        </span>
                      </div>
                    </div>
                    <div class="form-group col-md-4">
                      <label class="col-md-12">&nbsp;</label>
                      <input type="submit" class="btn btn-success pull-right col-md-7" id="cari" value="cari">
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        <!-- FILTER -->
        <!-- DIV TABLE -->
          <div class="col-md-12">
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title"><?= $judul ?></h3>
                <a href="<?= base_url('material/request/indexProses') ?>?header_menu=<?= $_GET['header_menu'] ?>&menu_id=<?= $_GET['menu_id'] ?>&transaksi_id=<?= create_id() ?>&aksi=1" class="btn btn-primary float-right">Tambah</a>
              </div>
              <div class="card-body">
                <!-- Table -->
                  <table id="table" class="table table-bordered" width="100%">
                    <thead style="position: sticky; top: 0;">
                      <tr>
                        <th class="header-table" scope="col">No</th>
                        <th class="header-table" scope="col">Nomor</th>
                        <th class="header-table" scope="col">Tanggal</th>
                        <th class="header-table" scope="col">Waktu</th>
                        <th class="header-table" scope="col">Peminta Jasa</th>
                        <th class="header-table" scope="col">User Peminta</th>
                        <th class="header-table" scope="col">Status</th>
                        <th class="header-table" scope="col">History</th>
                        <th class="header-table" scope="col">Detail</th>
                        <th class="header-table" scope="col">Edit</th>
                        <th class="header-table" scope="col">Hapus</th>
                        <th class="header-table" scope="col">Proses</th>
                      </tr>
                    </thead>
                  </table>
                <!-- Table -->
                <!-- Modal Detail -->
                  <div class="modal fade" id="modal_aksi_detail">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">
                            <div id="judul_detail"></div>
                          </h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form id="form_modal_detail">
                          <div class="modal-body">
                            <table id="table1" class="table table-bordered" width="100%">
                              <thead>
                                <tr>
                                  <th>No</th>
                                  <th>Material</th>
                                  <th>Satuan</th>
                                  <th>Jumlah</th>
                                  <th>Total</th>
                                </tr>
                              </thead>
                            </table>
                          </div>
                          <div class="modal-footer justify-content-between">
                            <button type="button" id="close" onclick="fun_close()" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="edit" style="display: none">Edit</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                <!-- Modal Detail-->
                <!-- Modal History -->
                  <div class="modal fade" id="modal_aksi_history">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">
                            <div id="judul_history"></div>
                          </h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form id="form_modal_detail">
                          <div class="modal-body">
                            <table id="table_history" class="table table-bordered" width="100%">
                              <thead>
                                <tr>
                                  <th>No</th>
                                  <th>Tipe</th>
                                  <th>Status</th>
                                  <th>Waktu</th>
                                  <th>Oleh</th>
                                </tr>
                              </thead>
                            </table>
                          </div>
                          <div class="modal-footer justify-content-between">
                            <button type="button" id="close" onclick="fun_close()" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="edit" style="display: none">Edit</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                <!-- Modal History-->
              </div>
            </div>
          </div>
        <!-- DIV TABLE -->
      </div>
    </div>
  </section>
  <!-- Container Body -->
</div>
<!-- CONTAINER -->