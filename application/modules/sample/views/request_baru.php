<style type="text/css">
  .modal-content {
    overflow: scroll !important;
  }
</style>

<style type="text/css">
  .dataTables_scrollHead {
    overflow: auto !important;
  }
</style>
<?php
$session = $this->session->userdata();

$vp_ppk = $this->db->query("SELECT * FROM global.global_api_user WHERE user_poscode = 'E44000000'")->row_array();

?>
<!--CONTAINER -->
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
          <div class="col-md-12">
            <div class="card">
              <!-- Header -->
              <div class="card-header bg-warning">
                <h3 class="card-title">Filter <?= $judul ?></h3>
              </div>
              <!-- Header -->
              <!-- Body -->
              <form id="filter">
                <div class="card-body">
                  <div class="row">
                    <div class="form-group col-md-3">
                      <label class="col-md-12">Tipe Sample</label>
                      <select class="form-control select2" id="transaksi_tipe_cari" name="transaksi_tipe_cari">
                        <option value="-">Semua Tipe</option>
                        <option value="I">Sample Internal</option>
                        <option value="E">Sample Eksternal</option>
                      </select>
                    </div>
                    <div class="form-group col-md-3">
                      <label class="col-md-12">Periode Awal</label>
                      <div class='input-group date' id="tanggal_cari_awal">
                        <input name="tanggal_cari_awal" id="tanggal_cari_awal" class="datetimepicker form-control" type="text" inputmode="none" class="form-control" required="" value="<?= date('Y-m-d') ?>" />
                        <span class="input-group-text">
                          <span class="fa fa-calendar"></span>
                        </span>
                      </div>
                    </div>
                    <div class="form-group col-md-3">
                      <label class="col-md-12">Periode Akhir</label>
                      <div class='input-group date' id="tanggal_cari_akhir">
                        <input name="tanggal_cari_akhir" id="tanggal_cari_akhir" class="datetimepicker form-control" type="text" inputmode="none" class="form-control" required="" value="<?= date('Y-m-d') ?>" />
                        <span class="input-group-text">
                          <span class="fa fa-calendar"></span>
                        </span>
                      </div>
                    </div>
                    <div class="form-group col-md-3">
                      <label class="col-md-12">&nbsp;</label>
                      <button type="submit" class="btn btn-success form-control" id="cari">Cari</button>
                      <!-- <input type="submit" class="btn btn-success pull-right form-control" id="cari" value="cari"> -->
                    </div>
                  </div>
                </div>
              </form>
              <!-- Body -->
            </div>
          </div>
        </div>
        <!-- FILTER -->
        <!-- DIV DATA DIRI -->
        <div class="col-md-12">
          <div class="col-md-12">
            <div class="card">
              <!-- Header -->
              <div class="card-header bg-success">
                <h3 class="card-title"><?= $judul ?></h3>
                <a href="<?= base_url('sample/request/addRequest?') . 'header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id'] ?>" class="btn btn-primary float-right btn-custom-small  ">Tambah</a>
                <input type="text" id="user_unit_id" name="user_unit_id" value="<?php echo $this->session->userdata('user_unit_id'); ?>" style="display:none">
              </div>
              <!-- Header -->
              <!-- Body -->
              <div class="card-body">
                <!-- Table -->
                <table id="table" class="table table-bordered table-striped datatables nowrap" width="100%">
                  <thead style="position: sticky;top: 0">
                    <tr>
                      <th>No</th>
                      <th>Nomor Surat</th>
                      <th>Tipe Sample</th>
                      <th>Tanggal Pengajuan</th>
                      <th>Peminta Jasa</th>
                      <th>Judul Pekerjaan</th>
                      <th>Status</th>
                      <th>Note</th>
                      <th>Proses</th>
                      <th>Edit</th>
                      <th>Hapus</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                </table>
                <!-- Table -->
              </div>
            </div>
            <!-- Modal -->
            <!-- Modal Detail -->
            <div class="modal fade" id="modal_detail">
              <div class="modal-dialog modal-xl">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title title_detail" id="exampleModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <table id="table_detail" class="table table-bordered table-striped " width="100%">
                      <thead>
                        <tr>
                          <th>Jenis Sample</th>
                          <th>Jumlah Sample</th>
                          <th>Identitas Sample</th>
                          <th>Parameter Sample</th>
                          <th>Deskripsi Paramater</th>
                          <th>Foto Sample</th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- Modal Detail -->
            <!-- Modal History -->
            <div class="modal fade" id="modal_history">
              <div class="modal-dialog modal-xl">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">History</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <table id="table_history" class="table table-bordered table-striped " width="100%">
                      <thead>
                        <tr>
                          <th>Judul Pekerjaan</th>
                          <th>Peminta Jasa</th>
                          <th>PIC</th>
                          <th>Status</th>
                          <th>Keterangan</th>
                          <th>Oleh</th>
                          <th>Pada Tanggal</th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- Modal History -->
            <!-- Modal Lihat -->
            <div class="modal fade" id="modal_lihat">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title"><?= $judul ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form id="form_modal_lihat">
                    <input type="hidden" id="jadwal_id" name="jadwal_id" value="">
                    <div class="modal-body">
                      <div class="card-body row" id="div_document" style="height: 400px;">
                      </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                      <button type="button" id="close" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <!-- Modal Lihat -->

            <!-- Body -->
          </div>
        </div>
        <!-- DIV DATA DIRI -->
      </div>
    </div>
</div>
</div>
</section>
<!-- Container Body -->
</div>
<!-- CONTAINER-->