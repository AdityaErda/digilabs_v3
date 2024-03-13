<!-- Tambahan -->
<style>
  /* Important part */
  .modal-dialog {
    overflow-y: initial !important
  }

  .modal-body {
    height: 80vh;
    overflow-y: auto;
  }
</style>
<!-- Tambahan -->
<!-- CONTAINER -->
<div class="content-wrapper">
  <!-- Container Header -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
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
              <div class="card-header bg-success">
                <h3 class="card-title"><?= $judul ?></h3>
                <select class="form-control col-md-3 float-right" id="tahun" name="tahun" onchange="fun_grafik(this.value)">
                  <?php for ($i = date('Y', strtotime('-5 years')); $i <= date('Y'); $i++) { ?>
                    <option value="<?= $i ?>" <?= ($i == date('Y')) ? 'selected' : '' ?>><?= $i ?></option>
                  <?php } ?>
                </select>
              </div>
              <!-- Header -->
              <!-- Body -->
              <div class="card-body row">
                <!-- Table -->
                <div class="col-md-6" id="div_chartBulan">
                  <canvas id="chartBulan" style="width: 100%;"></canvas>
                </div>
                <div class="col-md-3" id="div_chartSeksi">
                  <canvas id="chartSeksi" style="width: 100%;"></canvas>
                </div>
                <div class="col-md-3" id="div_chartStatus">
                  <canvas id="chartStatus" style="width: 100%;"></canvas>
                </div>
                <!-- Table -->
              </div>
              <!-- Body -->
            </div>
          </div>
        </div>
        <!-- DIV DATA DIRI -->
        <!-- DIV DATA DIRI -->
        <div class="col-md-12 row">
          <div class="col-md-3">
            <a href="#" data-toggle="modal" data-target="#modal_eksternal">
              <div class="small-box bg-danger">
                <div class="inner">
                  <h3 id="total_eksternal"></h3>

                  <p>Sample Eksternal</p>
                </div>
                <div class="icon">
                  <i class="fa fa-chart-line"></i>
                </div>
              </div>
            </a>
          </div>
          <div class="col-md-3">
            <a href="#" data-toggle="modal" data-target="#modal_internal">
              <div class="small-box bg-info">
                <div class="inner">
                  <h3 id="total_internal"></h3>

                  <p>Sample Internal</p>
                  <!-- <p>Sample Internal Non Rutin</p> -->
                </div>
                <div class="icon">
                  <i class="fa fa-chart-line"></i>
                </div>
              </div>
            </a>
          </div>
          <div class="col-md-3">
            <a href="#" data-toggle="modal" data-target="#modal_rutin">
              <div class="small-box bg-warning">
                <div class="inner">
                  <h3 id="total_rutin"></h3>

                  <p>Sample Rutin</p>
                  <!-- <p>Sample Internal Rutin</p> -->
                </div>
                <div class="icon">
                  <i class="fa fa-chart-line"></i>
                </div>
              </div>
            </a>
          </div>
          <div class="col-md-3">
            <div class="small-box bg-success">
              <div class="inner">
                <h3 id="total_parameter"></h3>

                <p>Total Parameter</p>
              </div>
              <div class="icon">
                <i class="fa fa-chart-line"></i>
              </div>
            </div>
          </div>
        </div>
        <!-- DIV DATA DIRI -->
        <!-- DIV DATA DIRI -->
        <!-- for some role , isn't appear -->
        <!-- for now, is show for admin only -->
        <?php if ($session_login['role_id'] == '1') : ?>
          <div class="col-md-12">
            <div class="col-md-12">
              <div class="card">
                <!-- Header -->
                <div class="card-header bg-primary">
                  <h3 class="card-title">Pendapatan Jasa Analisa</h3>
                </div>
                <!-- Header -->
                <!-- Body -->
                <div class="card-body row">
                  <!-- Table -->
                  <div class="col-md-6" id="div_chart_pendapatan">
                    <canvas id="chart_pendapatan" style="width: 100%;"></canvas>
                  </div>
                  <div class="col-md-6">
                    <table id="table" class="table table-bordered table-striped" width="100%">
                      <thead>
                        <tr>
                          <th>Customer</th>
                          <th>Total</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <td>Grand Total</td>
                          <td></td>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                  <!-- Table -->
                </div>
                <!-- Body -->
              </div>
            </div>
          </div>
        <?php endif; ?>
        <!-- for some role , isn't appear -->
        <!-- DIV DATA DIRI -->
        <!-- Modal -->
        <div class="modal fade" id="modal_eksternal">
          <div class="modal-dialog modal-xl">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Table Eksternal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <table id="table_eksternal" class="table table-bordered table-striped " style="table-layout:auto;" width="100%">
                  <thead>
                    <tr>
                      <th>Tanggal Pengajuan</th>
                      <th>Tanggal Estimasi</th>
                      <th>Jenis Pekerjaan</th>
                      <th>Peminta Jasa</th>
                      <th>Jenis Sample</th>
                      <th>Identitas</th>
                      <th>Nomor Surat</th>
                      <th>Nomor Sample</th>
                      <th>Nomor Sertifikat</th>
                      <th>Status</th>
                      <th>Note</th>
                      <th>Lihat</th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- Modal -->
        <!-- Modal -->
        <div class="modal fade" id="modal_internal">
          <div class="modal-dialog modal-xl">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Table Internal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <table id="table_internal" class="table table-bordered table-striped " style="table-layout:auto;" width="100%">
                  <thead>
                    <tr>
                      <th>Tanggal Pengajuan</th>
                      <th>Tanggal Estimasi</th>
                      <th>Jenis Pekerjaan</th>
                      <th>Peminta Jasa</th>
                      <th>Jenis Sample</th>
                      <th>Identitas</th>
                      <th>Nomor Surat</th>
                      <th>Nomor Sample</th>
                      <th>Nomor Sertifikat</th>
                      <th>Status</th>
                      <th>Note</th>
                      <th>Lihat</th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- Modal -->
        <!-- Modal -->
        <div class="modal fade" id="modal_rutin">
          <div class="modal-dialog modal-xl">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Table Rutin</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <table id="table_rutin" class="table table-bordered table-striped " style="table-layout:auto;" width="100%">
                  <thead>
                    <tr>
                      <th>Tanggal Pengajuan</th>
                      <th>Jenis Pekerjaan</th>
                      <th>Peminta Jasa</th>
                      <th>Jenis Sample</th>
                      <th>Identitas</th>
                      <th>Nomor Memo</th>
                      <th>Nomor Sample</th>
                      <th>Nomor Sertifikat</th>
                      <th>Status</th>
                      <th>Note</th>
                      <th>Lihat</th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- Modal -->
        <div class="modal fade" id="modal_lihat">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">
                  <div id="judul_lihat"></div>
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form id="form_modal">
                <!-- <input type="hidden" id="jadwal_id" name="jadwal_id" value=""> -->
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
    </div>
  </section>
  <!-- Container Body -->
</div>
<!-- CONTAINER -->