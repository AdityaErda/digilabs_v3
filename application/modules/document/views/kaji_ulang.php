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
                  <div class="card card-success">
                    <!-- Header -->
                      <div class="card-header">
                        <h3 class="card-title"><?= $judul ?></h3>
                        <a href="<?= base_url('document/kaji_ulang/print') ?>" target="_BLANK" title=""class="btn btn-danger float-right">Print</a>
                      </div>
                    <!-- Header -->
                    <!-- Body -->
                      <div class="card-body">
                        <!-- Table -->
                          <table id="table" class="table table-bordered" width="100%">
                            <thead>
                              <tr>
                                <th>Judul Document</th>
                                <th>Jenis Document</th>
                                <th>Tanggal Pengesahan</th>
                                <th>Nomor Document</th>
                                <th>Keterangan</th>
                                <th>Revisi</th>
                                <th>Terbitan</th>
                                <th>File</th>
                                <th>Detail</th>
                              </tr>
                            </thead>
                          </table>
                        <!-- Table -->
                        <!-- Modal -->
                          <div class="modal fade" id="modal_aksi_detail">
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
                                    <table id="table1" class="table table-bordered " width="100%">
                                      <thead>
                                        <tr>
                                          <th>Tanggal Pengajuan</th>
                                          <th>Tanggal Pengesahan</th>
                                          <th>Judul Document</th>
                                          <th>Nomor Document</th>
                                          <th>Revisi</th>
                                          <th>Terbitan</th>
                                          <th>Note</th>
                                          <th>File</th>
                                          <th>Status Perubahan</th>
                                          <th>Status Pengajuan</th>
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
                              <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                          </div>
                          <!-- Modal -->
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