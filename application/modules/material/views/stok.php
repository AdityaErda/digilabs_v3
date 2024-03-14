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
        <!-- FILTER -->
        <div class="col-md-12">
          <div class="col-md-12">
            <div class="card card-warning">
              <!-- Header -->
              <div class="card-header">
                <h3 class="card-title">Filter <?= $judul ?></h3>
              </div>
              <!-- Header -->
              <!-- Body -->
              <form id="filter">
                <div class="card-body">
                  <div class="row">
                    <div class="form-group col-md-4">
                      <label class="col-md-12">Material</label>
                      <div class="input-group col-md-12">
                        <select name="item_cari" id="item_cari" class="float-right form-control select2"></select>
                      </div>
                    </div>
                    <div class="form-group col-md-4">
                      <label class="col-md-12">Kode Material</label>
                      <div class="input-group col-md-12">
                        <input type="text" name="filter_kode_material" id="filter_kode_material" class="form-control" placeholder="Qr-Code Material">
                      </div>
                    </div>
                    <div class="form-group col-md-4">
                      <label class="col-md-12">&nbsp;</label>
                      <input type="submit" class="btn btn-success pull-right col-md-7" id="cari" value="cari">
                    </div>
                  </div>
                </div>
              </form>
              <!-- Body -->
              <!-- Modal -->
              <div class="modal fade" id="modal_stok_document">
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
                        <!-- Table -->
                        <table id="table_stok_document" class="table table-bordered table-striped" width="100%">
                          <thead>
                            <tr>
                              <th>Tgl Terbit</th>
                              <th>Tgl Expired</th>
                              <th>Judul</th>
                              <th>File</th>
                              <th>Download</th>
                            </tr>
                          </thead>
                        </table>
                        <!-- Table -->
                      </div>
                      <div class="modal-footer justify-content-between">
                        <button type="button" id="close" onclick="fun_close()" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="edit" style="display: none">Edit</button>
                      </div>
                    </form>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>
              <!-- Modal -->
              <!-- Modal QR -->
              <div class="modal fade" id="modal_qr">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Qr-Code</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <form id="form_modal_qr">
                      <div class="modal-body">
                        <input type="text" name="id_qr" id="id_qr" style="display: none;">
                        <div class="form-group">
                          <label class="col-md-12">Jumlah Qr-Code</label>
                          <div class="input-group col-md-12">
                            <input type="text" name="jumlah_qr" id="jumlah_qr" class="form-control" placeholder="Jumlah Qr-Code">
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer justify-content-between">
                        <button type="button" id="close_qr" onclick="fun_close_qr()" class="btn btn-default" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" id="proses" name="proses" value="Proses">
                      </div>
                    </form>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>
              <!-- Modal QR -->
              <!-- Modal QR Besar -->
              <div class="modal fade" id="modal_qr_besar">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Qr-Code Besar</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <form id="form_modal_qr_besar">
                      <div class="modal-body">
                        <input type="text" name="id_qr_besar" id="id_qr_besar" style="display: none;">
                        <div class="form-group">
                          <label class="col-md-12">Jumlah Qr-Code</label>
                          <div class="input-group col-md-12">
                            <input type="text" name="jumlah_qr" id="jumlah_qr" class="form-control" placeholder="Jumlah Qr-Code">
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer justify-content-between">
                        <button type="button" id="close_qr_beesar" onclick="fun_close_qr_besar()" class="btn btn-default" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" id="proses_besar" name="proses_besar" value="Proses">
                      </div>
                    </form>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>
              <!-- Modal QR Besar -->
            </div>
          </div>
        </div>
        <!-- FILTER -->
        <!-- DIV DATA DIRI -->
        <div class="col-md-12">
          <div class="col-md-12">
            <div class="card card-success">
              <!-- Header -->
              <div class="card-header">
                <h3 class="card-title"><?= $judul ?></h3>
              </div>
              <!-- Header -->
              <!-- Body -->
              <div class="card-body">
                <!-- Table -->
                <table id="table" class="table table-bordered " width="100%">
                  <thead>
                    <tr>
                      <th>Material</th>
                      <th>Satuan</th>
                      <th>Stok</th>
                      <th>Detail</th>
                      <th>Qrcode</th>
                    </tr>
                  </thead>
                </table>
                <!-- Table -->
              </div>
              <!-- Body -->
            </div>
          </div>
        </div>
        <!-- DIV DATA DIRI -->
        <!-- DIV DATA DIRI -->
        <div class="col-md-12" id="div_detail" style="display: none;">
          <div class="col-md-12">
            <div class="card">
              <!-- Header -->
              <div class="card-header">
                <h3 class="card-title">Detail <?= $judul ?></h3>
                <input type="hidden" id="temp_item_id" name="temp_item_id">
                <center><button type="button" class="btn btn-danger col-2" onclick="func_stok_document($('#temp_item_id').val())" data-target="#modal_stok_document" data-toggle="modal">Download Dokumen</button></center>
              </div>
              <!-- Header -->
              <!-- Body -->
              <div class="card-body row">
                <!-- Table -->
                <div class="col-6">
                  <table id="table1" class="table table-bordered table-striped" width="100%">
                    <thead>
                      <tr>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Jenis Kegiatan</th>
                        <th>Material</th>
                        <th>Satuan</th>
                        <th>Jumlah</th>
                        <th>Stok</th>
                        <th>Keterangan</th>
                        <!-- <th>Dokumen</th> -->
                      </tr>
                    </thead>
                  </table>
                </div>
                <!-- Table -->
                <!-- Chart -->
                <div class="col-6" id="div_chartStok">
                  <canvas id="chartStok" style="width:100%"></canvas>
                </div>
                <!-- Chart -->
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