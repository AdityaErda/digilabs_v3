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
                      <label class="col-md-12">Jenis Barang</label>
                      <select class="form-control select2" id="jenis_barang" name="jenis_barang"></select>
                    </div>
                    <div class="form-group col-md-4">
                      <label class="col-md-12">Jenis Material</label>
                      <!-- <div class="input-group col-md-6"> -->
                      <select class="form-control select2" id="item_cari" name="item_cari">
                      </select>
                    </div>

                    <div class="form-group col-md-2">
                      <label class="col-md-12">Tahun</label>
                      <!-- <div class="input-group col-md-6"> -->
                      <!-- <input type="year" class="form-control" id="tahun_cari" name="tahun_cari" > -->
                      <select id="tahun_cari" class="form-control" name="tahun_cari">
                        <?php
                        $mulai = date('Y') - 50;
                        for ($i = $mulai; $i < $mulai + 100; $i++) {
                          $sel = $i == date('Y') ? ' selected="selected"' : '';
                          echo '<option value="' . $i . '"' . $sel . '>' . $i . '</option>';
                        }
                        ?>
                      </select>
                    </div>
                    <div class="form-group col-md-4">
                      <label class="col-md-12">&nbsp;</label>
                      <input type="button" class="btn btn-success pull-right col-md-7" id="cari" value="cari">
                    </div>
                  </div>
                </div>
                <!-- Body -->
            </div>
          </div>
        </div>
        <!-- DIV DATA DIRI -->
        <div class="col-md-12">
          <div class="col-md-12">
            <div class="card card-success">
              <!-- Header -->
              <div class="card-header">
                <h3 class="card-title"><?= $judul ?></h3>
                <input type="button" name="cetak" value="cetak" class="btn btn-danger float-right" onclick="fun_cetak()">
              </div>
              <!-- Header -->

              <!-- Body -->
              <div class="card-body">
                <!-- Table -->
                <table id="table" class="table table-bordered table-striped" width="100%">
                  <thead>
                    <tr>
                      <th>Jenis Barang</th>
                      <th>Material</th>
                      <th>Material Masuk</th>
                      <th>Material Keluar</th>
                      <th>Satuan</th>
                      <th>Stok Akhir</th>
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
      </div>
    </div>
  </section>
  <!-- Container Body -->
</div>
<!-- CONTAINER -->