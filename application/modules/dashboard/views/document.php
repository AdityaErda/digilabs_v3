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
        <!-- DIV DOCUMENT JENIS -->
        <div class="col-md-12 row">
          <?php
          $jenis_no[] = 'bg-danger';
          $jenis_no[] = 'bg-warning';
          $jenis_no[] = 'bg-info';
          $jenis_no[] = 'bg-success';
          $jenis_no[] = 'bg-primary';
          $jenis_no[] = 'bg-secondary';
          ?>
          <?php $jenis = $this->db->query("SELECT * FROM document.document_jenis ORDER BY jenis_nama ASC LIMIT 6") ?>
          <?php foreach ($jenis->result() as $key => $value) : ?>
            <div class="col-md-2">
              <div class="small-box <?= $jenis_no[$key] ?>">
                <div class="inner">
                  <h3 id="jenis_id_<?= $value->jenis_id ?>"></h3>

                  <p><?= $value->jenis_nama ?></p>
                </div>
                <div class="icon">
                  <i class="fa fa-chart-line"></i>
                </div>
              </div>
            </div>
          <?php endforeach ?>
        </div>
        <!-- DIV DOCUMENT JENIS -->
        <!-- DIV DATA DIRI -->
        <div class="col-md-12 row">
          <?php
          $seksi_no[] = 'purple';
          $seksi_no[] = 'orange';
          $seksi_no[] = 'green';
          $seksi_no[] = 'blue';
          $seksi_no[] = 'yellow';
          $seksi_no[] = 'aqua';
          ?>
          <?php $seksi = $this->db->query("SELECT * FROM global.global_seksi WHERE is_disposisi = 'y' ORDER BY seksi_nama ASC") ?>
          <table width="100%">
            <tr>
              <?php foreach ($seksi->result() as $key => $value) : ?>
                <td width="10%">
                  <div class="col-md-12">
                    <div class="small-box" style="background-color: <?= $seksi_no[$key] ?>;">
                      <div class="inner">
                        <h3 id="seksi_id_<?= $value->seksi_id ?>"></h3>

                        <p><?= $value->seksi_nama ?></p>
                      </div>
                      <div class="icon">
                        <i class="fa fa-chart-line"></i>
                      </div>
                    </div>
                  </div>
                </td>
              <?php endforeach ?>
            </tr>
          </table>
        </div>
        <!-- DIV DATA DIRI -->
        <!-- DIV DATA DIRI -->
        <div class="col-md-12">
          <div class="col-md-12">
            <div class="card">
              <!-- Header -->
              <div class="card-header bg-info">
                <h3 class="card-title">Grafik</h3>
              </div>
              <!-- Header -->
              <!-- Body -->
              <div class="card-body row">
                <div class="col-md-6" id="div_chartJenis">
                  <canvas id="chartJenis" style="width: 100%;"></canvas>
                </div>
                <div class="col-md-6" id="div_chartSeksi">
                  <canvas id="chartSeksi" style="width: 100%;"></canvas>
                </div>
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
                <h3 class="card-title">Top 10</h3>
              </div>
              <!-- Header -->
              <!-- Body -->
              <div class="card-body">
                <!-- Table -->
                <table id="table_document" class="table table-bordered table-striped" width="100%">
                  <thead>
                    <tr>
                      <th>Jenis Dokumen</th>
                      <th>Revisi</th>
                      <th>Terbit Baru</th>
                      <th>Unduhan</th>
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
        <div class="col-md-12">
          <div class="col-md-12">
            <div class="card">
              <!-- Header -->
              <div class="card-header bg-primary">
                <h3 class="card-title">Grafik</h3>
              </div>
              <!-- Header -->
              <!-- Body -->
              <div class="card-body row">
                <div class="col-md-12" id="div_chartDocument">
                  <canvas id="chartDocument" style="width: 100%;"></canvas>
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