<!-- CONTAINER -->
  <div class="content-wrapper">
    <!-- Container Header -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-12">
              <h1>Stock</h1>
              <select class="form-control col-md-3 float-right" id="tahun" name="tahun" onchange="fun_grafik(this.value)">
                <?php for ($i = date('Y', strtotime('-5 years')); $i <= date('Y'); $i++) { ?>
                  <option value="<?= $i ?>" <?= ($i == date('Y')) ? 'selected' : ''; ?>><?= $i ?></option>
                <?php } ?>
              </select>
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
              <div class="col-md-12 row">
                <div class="col-md-3">
                  <a href="#" data-toggle="modal" data-target="#modal_material_request">
                    <div class="small-box bg-danger" style="margin-left: 7px;">
                      <div class="inner">
                        <h3 id="total_material_request"></h3>

                        <p>Total Material Request</p>
                      </div>
                      <div class="icon">
                        <i class="fa fa-chart-line"></i>
                      </div>
                    </div>
                  </a>
                </div>
                <div class="col-md-3">
                  <a href="#" data-toggle="modal" data-target="#modal_aset">
                    <div class="small-box bg-info">
                      <div class="inner">
                        <h3 id="total_aset"></h3>

                        <p>Total Aset</p>
                      </div>
                      <div class="icon">
                        <i class="fa fa-chart-line"></i>
                      </div>
                    </div>
                  </a>
                </div>
                <div class="col-md-3">
                  <a href="#" data-toggle="modal" data-target="#modal_perbaikan">
                    <div class="small-box bg-warning">
                      <div class="inner">
                        <h3 id="total_perbaikan"></h3>

                        <p>Total Perbaikan</p>
                      </div>
                      <div class="icon">
                        <i class="fa fa-chart-line"></i>
                      </div>
                    </div>
                  </a>
                </div>
                <div class="col-md-3">
                  <a href="#" data-toggle="modal" data-target="#modal_material_transaksi">
                    <div class="small-box bg-success" style="margin-right: -6px;">
                      <div class="inner">
                        <h3 id="total_transaksi"></h3>

                        <p>Total Transaksi</p>
                      </div>
                      <div class="icon">
                        <i class="fa fa-chart-line"></i>
                      </div>
                    </div>
                  </a>
                </div>
              </div>
            <!-- DIV DATA DIRI -->
            <!-- DIV DATA DIRI -->
              <div class="col-md-6">
                <div class="col-md-12">
                  <div class="card">
                    <!-- Header -->
                      <div class="card-header bg-success">
                        <h3 class="card-title">Total Transaksi</h3>
                      </div>
                    <!-- Header -->
                    <!-- Body -->
                      <div class="card-body row">
                        <!-- Table -->
                          <div class="col-md-12" id="div_chartTransaksi">
                            <canvas id="chartTransaksi"></canvas>
                          </div>
                        <!-- Table -->
                      </div>
                    <!-- Body -->
                  </div>
                </div>
              </div>
            <!-- DIV DATA DIRI -->
            <!-- DIV DATA DIRI -->
              <div class="col-md-6">
                <div class="col-md-12">
                  <div class="card">
                    <!-- Header -->
                      <div class="card-header bg-primary">
                        <h3 class="card-title">Total Perbaikan</h3>
                      </div>
                    <!-- Header -->
                    <!-- Body -->
                      <div class="card-body row">
                        <!-- Table -->
                          <div class="col-md-12" id="div_chartPerbaikan">
                            <canvas id="chartPerbaikan"></canvas>
                          </div>
                        <!-- Table -->
                      </div>
                    <!-- Body -->
                  </div>
                </div>
              </div>
            <!-- DIV DATA DIRI -->
            <!-- DIV DATA DIRI -->
              <div class="col-md-12">
                <div class="col-md-12">
                  <div class="card">
                    <!-- Header -->
                      <div class="card-header bg-warning">
                        <h3 class="card-title">Total Penyerapan Unit</h3>
                      </div>
                    <!-- Header -->
                    <!-- Body -->
                      <div class="card-body row">
                        <!-- Table -->
                          <div class="col-md-12" id="div_chartPenyerapan">
                            <canvas id="chartPenyerapan" style="width: 100%;"></canvas>
                          </div>
                        <!-- Table -->
                      </div>
                    <!-- Body -->
                  </div>
                </div>
              </div>
            <!-- DIV DATA DIRI -->
            <!-- DIV DATA DIRI -->
              <div class="col-md-12">
                <div class="col-md-12">
                  <div class="card">
                    <!-- Header -->
                      <div class="card-header bg-danger">
                        <h3 class="card-title">Fast Moving Item</h3>
                      </div>
                    <!-- Header -->
                    <!-- Body -->
                      <div class="card-body">
                        <!-- Table -->
                          <table id="table_item" class="table table-bordered table-striped" width="100%">
                            <thead>
                              <tr>
                                <th>Material</th>
                                <th>Jumlah</th>
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
            <!-- Modal -->
              <div class="modal fade" id="modal_material_request">
                <div class="modal-dialog modal-xl">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Material Transaksi</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <!-- Table -->
                        <table id="table_material_request" class="table table-bordered table-striped" width="100%">
                          <thead>
                            <tr>
                              <th>Tanggal</th>
                              <th>Waktu</th>
                              <th>Peminta</th>
                              <th>Status</th>
                            </tr>
                          </thead>
                        </table>
                      <!-- Table -->
                    </div>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>
            <!-- Modal -->
            <!-- Modal -->
              <div class="modal fade" id="modal_material_transaksi">
                <div class="modal-dialog modal-xl">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Material Transaksi</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <!-- Table -->
                        <table id="table_material_transaksi" class="table table-bordered table-striped" width="100%">
                          <thead>
                            <tr>
                              <th>Tanggal</th>
                              <th>Waktu</th>
                              <th>Peminta</th>
                              <th>Status</th>
                            </tr>
                          </thead>
                        </table>
                      <!-- Table -->
                    </div>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>
            <!-- Modal -->
            <!-- Modal -->
              <div class="modal fade" id="modal_aset">
                <div class="modal-dialog modal-xl">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Table Aset</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <!-- Table -->
                        <table id="table_aset" class="table table-bordered table-striped" width="100%">
                          <thead>
                            <tr>
                              <th>No</th>
                              <th>Aset Nomor</th>
                              <th>Tahun Perolehan</th>
                              <th>Nama Aset</th>
                              <th>Nilai Perolehan</th>
                              <th>Penyusutan SD THN Lalu</th>
                              <th>Penyusutan Tahun Ini</th>
                              <th>Total Penyusutan</th>
                              <th>Nilai Buku</th>
                              <th>Jumlah</th>
                            </tr>
                          </thead>
                        </table>
                      <!-- Table -->
                    </div>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>
            <!-- Modal -->
            <!-- Modal -->
              <div class="modal fade" id="modal_perbaikan">
                <div class="modal-dialog modal-xl">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Table Perbaikan</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <!-- Table -->
                        <table id="table_perbaikan" class="table table-bordered table-striped" width="100%">
                          <thead>
                            <tr>
                              <th>Tgl Penyerahan</th>
                              <th>Tgl Selesai</th>
                              <th>Serial Number</th>
                              <th>Nama Aset</th>
                              <th>Pekerjaan</th>
                              <th>Note</th>
                              <th>Status</th>
                            </tr>
                          </thead>
                        </table>
                      <!-- Table -->
                    </div>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>
            <!-- Modal -->
          </div>
        </div>
      </section>
    <!-- Container Body -->
  </div>
<!-- CONTAINER -->