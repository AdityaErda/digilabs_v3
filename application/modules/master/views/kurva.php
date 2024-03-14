<style type="text/css">
  .dataTables_scrollHead {
    overflow: auto !important;
  }
</style>

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

        <!-- TABLE -->
        <!-- DIV KURVA -->
        <div class="col-md-12">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header bg-warning">
                <h3 class="card-title">Kurva</h3>
                <button type="button" class="btn btn-primary float-right ml-2" data-toggle="modal" data-target="#modal_kurva">Tambah</button>
              </div>&nbsp;
              <div class="card-body">
                <table id="table_kurva" class="table table-bordered table-striped" width="100%">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Jenis Sample - Rumus</th>
                      <th>Nama</th>
                      <th>Batas</th>
                      <th>Detail</th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
          </div>
        </div>
        <!-- DIV KURVA -->

        <!-- DIV KURVA HEADER-->
        <div class="col-md-12" id="div_kurva_header" style="display: none;">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header bg-secondary">
                <h3 class="card-title">header Kurva</h3>
                <button type="button" class="btn btn-primary float-right ml-2" data-toggle="modal" data-target="#modal_kurva_header" onclick="fun_tambah_kurva_header()">Tambah</button>
              </div>&nbsp;
              <div class="card-body">
                <input type="text" id="id_kurva_utama" name="id_kurva_utama" style="display:none">
                <table id="table_kurva_header" class="table table-bordered table-striped" width="100%">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Urutan</th>
                      <th>Judul Kurva</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
          </div>
        </div>
        <!-- DIV KURVA HEADER-->

        <!-- DIV KURVA ISI-->
        <div class="col-md-12" id="div_kurva_isi" style="display: none;">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header bg-secondary">
                <h3 class="card-title">Isian Kurva</h3>
                <button type="button" class="btn btn-primary float-right ml-2" onclick="fun_tambah_kurva_isi()">Tambah</button>
              </div>&nbsp;
              <div class="card-body">
                <input type="text" id="id_kurva_utamas" name="id_kurva_utamas" style="display:none">
                <input type="text" id="id_kurva_header" name="id_kurva_header" style="display:none">
                <table id="table_kurva_isi" class="table table-bordered table-striped" width="100%">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Urutan</th>
                      <th>Isi</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
          </div>
        </div>
        <!-- DIV KURVA ISI-->

        <!-- DIV KURVA ISI-->
        <div class="col-md-12" id="div_kurva_lihat" style="display: none;">
          <div class="col-md-12" id="div_table_kurva_lihat">
          </div>
        </div>
        <!-- DIV KURVA ISI-->


        <!-- TABLE -->

        <!-- MODAL -->
        <!--  KURVA -->
        <div class="modal fade" id="modal_kurva">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title"><?= $judul ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form id="form_modal_kurva">
                <input type="text" id="kurva_id" name="kurva_id" value="" style="display: none;">
                <div class="modal-body">
                  <div class="card-body row">
                    <div class="col-12">
                      <div class="form-group row col-md-12">
                        <label class="col-md-4">Jenis sample</label>
                        <div class="input-group col-md-8">
                          <select class="form-control select2" id="id_rumus" name="id_rumus">
                          </select>
                        </div>
                      </div>
                      <div class="form-group row col-md-12">
                        <label class="col-md-4">Nama Kurva</label>
                        <div class="input-group col-md-8">
                          <input type="text" class="form-control" name="kurva_nama" id="kurva_nama" value="">
                        </div>
                      </div>
                      <div class="form-group row col-md-12">
                        <label class="col-md-4">Batas Kurva</label>
                        <div class="input-group col-md-8">
                          <input type="number" class="form-control" name="kurva_baris" id="kurva_baris" min="1" max="7">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer justify-content-between">
                  <button type="button" id="close" class="btn btn-default" data-dismiss="modal" onclick="fun_close()">Close</button>
                  <button type="submit" class="btn btn-success" id="simpan">Simpan</button>
                  <button type="submit" class="btn btn-primary" id="edit" style="display: none">Edit</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- KURVA -->

        <!-- KURVA HEADER-->
        <div class="modal fade" id="modal_kurva_header">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title"><?= $judul ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form id="form_modal_kurva_header">
                <input type="text" id="kurva_header_id" name="kurva_header_id" value="" style="display: none;">
                <div class="modal-body">
                  <div class="card-body row">
                    <div class="col-12">
                      <div class="form-group row col-md-12">
                        <label class="col-md-4">Urutan Kurva</label>
                        <div class="input-group col-md-8">
                          <input type="text" class="form-control" name="kurva_header_urut" id="kurva_header_urut" value="">
                        </div>
                      </div>
                      <div class="form-group row col-md-12">
                        <label class="col-md-4">Judul Kurva</label>
                        <div class="input-group col-md-8">
                          <input type="text" class="form-control" name="kurva_header_nama" id="kurva_header_nama">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer justify-content-between">
                  <button type="button" id="close_header" class="btn btn-default" data-dismiss="modal" onclick="fun_close_header()">Close</button>
                  <button type="submit" class="btn btn-success" id="simpan_header">Simpan</button>
                  <button type="submit" class="btn btn-primary" id="edit_header" style="display: none">Edit</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- KURVA HEADER -->

        <!-- KURVA ISI -->
        <div class="modal fade" id="modal_kurva_isi">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title"><?= $judul ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form id="form_modal_kurva_isi">
                <input type="text" id="kurva_isi_id" name="kurva_isi_id" value="" style="display: none;">
                <div class="modal-body">
                  <div class="card-body row">
                    <div class="col-12">
                      <div class="form-group row col-md-12">
                        <label class="col-md-4">Urutan</label>
                        <div class="input-group col-md-8">
                          <input type="text" class="form-control" name="kurva_isi_urut" id="kurva_isi_urut" value="">
                        </div>
                      </div>
                      <div class="form-group row col-md-12">
                        <label class="col-md-4">Angka</label>
                        <div class="input-group col-md-8">
                          <input type="text" class="form-control" name="kurva_isi_jumlah" id="kurva_isi_jumlah">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer justify-content-between">
                  <button type="button" id="close_isi" class="btn btn-default" data-dismiss="modal" onclick="fun_close_isi()">Close</button>
                  <button type="submit" class="btn btn-success" id="simpan_isi">Simpan</button>
                  <button type="submit" class="btn btn-primary" id="edit_isi" style="display: none">Edit</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- KURVA ISI -->
        <!-- MODAL -->
      </div>
    </div>
  </section>
  <!-- Container Body -->
</div>
<!-- CONTAINER -->