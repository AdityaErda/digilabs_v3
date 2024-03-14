<?php $session = $this->session->userdata(); ?>

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
            <div class="card">
              <!-- Header -->
              <div class="card-header bg-warning">
                <h3 class="card-title">Filter <?= $judul ?></h3>
              </div>
              <!-- Header -->
              <!-- Body -->
              <form id="filter" method="post">
                <div class="card-body">
                  <div class="row">
                    <div class="form-group col-md-3">
                      <label class="col-md-12">Periode Awal</label>
                      <div class='input-group date' id="dev_tanggal_cari_awal">
                        <input name="tanggal_cari_awal" id="tanggal_cari_awal" class="datetimepicker form-control" type="text" inputmode="none" required="" value="<?= date('Y-m-d') ?>" />
                        <span class="input-group-text">
                          <span class="fa fa-calendar"></span>
                        </span>
                      </div>
                    </div>
                    <div class="form-group col-md-3">
                      <label class="col-md-12">Periode Akhir</label>
                      <div class='input-group date' id="dev_tanggal_cari_akhir">
                        <input name="tanggal_cari_akhir" id="tanggal_cari_akhir" class="datetimepicker form-control" type="text" inputmode="none" required="" value="<?= date('Y-m-d') ?>" />
                        <span class="input-group-text">
                          <span class="fa fa-calendar"></span>
                        </span>
                      </div>
                    </div>
                    <div class="form-group col-md-3">
                      <label class="col-md-12">Jenis Sample</label>
                      <div class="input-group col-md-12">
                        <select class="form-control select2" id="jenis" name="jenis"></select>
                      </div>
                    </div>
                    <div class="form-group col-md-3">
                      <label class="col-md-12">&nbsp;</label>
                      <input type="submit" class="btn btn-success pull-right col-md-7" id="cari" value="cari">
                    </div>
                  </div>
                </div>
              </form>
              <!-- Body -->
            </div>
          </div>
        </div>
        <!-- FILTER -->
        <!-- DIF DATA DIRI -->
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
                <table id="table" class="table table-bordered table-striped nowrap" width="100%">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Jenis Sample</th>
                      <th>Parameter Rumus</th>
                      <th>Detail</th>
                    </tr>
                  </thead>
                </table>
                <!-- Table -->
              </div>
              <!-- Body -->
            </div>
          </div>
        </div>
        <!-- DIF DATA DIRI -->
        <!-- DIV DETAIL DATA DIRI -->
        <div class="col-md-12" id="div_detail" style="display: none;">
          <div class="col-md-12">
            <div class="card">
              <!-- Header -->
              <div class="card-header bg-secondary">
                <h3 class="card-title">Hasil Log Sheet</h3>
                <input id="temp_transaksi_id" name="temp_transaksi_id" style="display: none;">
                <input id="temp_id_rumus" name="temp_id_rumus" style="display: none;">
                <input type="button" id="cetak" name="cetak" value="cetak" class="btn btn-danger float-right" onclick="fun_cetak()">
              </div>&nbsp;
              <!-- Header -->
              <!-- Body -->
              <div class="card-body">
                <!-- Table -->
                <table id="table_detail" class="table table-bordered table-striped" width="100%">
                  <thead>
                    <tr>
                      <th>Tanggal</th>
                      <th>Nomor Sample</th>
                      <th>Hasil Pengujian</th>
                      <th>Satuan</th>
                    </tr>
                  </thead>
                </table>&nbsp;
                <br>
                <!-- Table -->
              </div>
              <!-- Body -->
            </div>
          </div>
        </div>
        <!-- DIV DETAIL DATA DIRI -->
        <!-- Div Grafik -->
        <div class="col-md-12" id="div_grafik" style="display: none;">
          <div class="col-md-12">
            <div class="card">
              <!-- Header -->
              <div class="card-header bg-secondary">
                <h3 class="card-title">Grafik Hasil Log Sheet</h3>
              </div>&nbsp;
              <!-- Header -->
              <!-- Body -->
              <div class="card-body row">
                <!-- Grafik -->
                <div class="col-md-12" id="div_chartReportSample">
                  <canvas id="chartReportSample" style="width:100%"></canvas>
                </div>
                <!-- Grafik -->
              </div>
              <!-- Body -->
            </div>
          </div>
        </div>
        <!-- Div Grafik -->
      </div>
    </div>
  </section>
  <!-- Container Body -->
</div>
<!-- CONTAINER -->