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
        <!-- <div class="col-md-12">
                <div class="col-md-12">
                  <div class="card"> -->
        <!-- Header -->
        <!-- <div class="card-header">
                        <h3 class="card-title">Filter <?= $judul ?></h3>
                      </div> -->
        <!-- Header -->
        <!-- Body -->
        <!-- <form id="filter">
                      <div class="card-body">
                        <div class="row">
                        <div class="form-group col-md-4">
                            <label class="col-md-12">Tanggal</label>
                            <div class="input-group col-md-12">
                              <div class="input-group-prepend">
                                <span class="input-group-text">
                                  <i class="far fa-calendar-alt"></i>
                                </span>
                              </div>
                              <input type="text" class="form-control float-right" id="tanggal_cari" name="tanggal_cari">
                            </div>
                          </div>                          
                          <div class="form-group col-md-4">
                            <label class="col-md-12">&nbsp;</label>
                            <input type="submit"  class="btn btn-success pull-right col-md-7" id="cari" value="cari">
                          </div>
                        </div>
                      </div>  
                    </form> -->
        <!-- Body -->
        <!-- </div>
                </div>
              </div> -->
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
                <table id="table" class="table table-bordered" width="100%">
                  <thead>
                    <tr>
                      <th>Material</th>
                      <th>Judul Dokumen</th>
                      <th>Satuan</th>
                      <th>Stok</th>
                      <th>Stok Alert</th>
                      <th>Keterangan</th>
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