<!-- CONTAINER -->
<div class="content-wrapper">
  <!-- Container Header -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><?= $judul ?> Eksternal</h1>
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
                <h3 class="card-title">Filter <?= $judul ?> Eksternal</h3>
              </div>
              <!-- Header -->
              <!-- Body -->
              <form id="filter">
                <div class="card-body">
                  <div class="row">
                    <div class="form-group col-md-3">
                      <label class="col-md-12">Periode Awal</label>
                      <div class='input-group date' id="tanggal_cari_awal">
                        <input name="tanggal_cari_awal" id="tanggal_cari_awal" class="datetimepicker form-control" type="text" inputmode="none" required="" value="<?= date('Y-m-d') ?>" />
                        <span class="input-group-text">
                          <span class="fa fa-calendar"></span>
                        </span>
                      </div>
                    </div>
                    <div class="form-group col-md-3">
                      <label class="col-md-12">Periode Akhir</label>
                      <div class='input-group date' id="tanggal_cari_akhir">
                        <input name="tanggal_cari_akhir" id="tanggal_cari_akhir" class="datetimepicker form-control" type="text" inputmode="none" required="" value="<?= date('Y-m-d') ?>" />
                        <span class="input-group-text">
                          <span class="fa fa-calendar"></span>
                        </span>
                      </div>
                    </div>
                    <div class="form-group col-md-3">
                      <label class="col-md-12">Status Perbaikan</label>
                      <div class="input-group col-md-12">
                        <select class="form-control" name="terjadwal_cari" id="terjadwal_cari">
                          <option value="-">Semua</option>
                          <option value="t">Terjadwal</option>
                          <option value="n">Pengajuan</option>
                          <option value="k">Dikerjakan</option>
                          <option value="p">Pending</option>
                          <option value="y">Selesai</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group col-md-3">
                      <label class="col-md-12">Jenis Pekerjaan</label>
                      <div class="input-group col-md-12">
                        <select class="form-control" name="jenis_cari" id="jenis_cari">
                          <option value="-">Semua</option>
                          <option value="p">Perbaikan</option>
                          <option value="k">Kalibrasi</option>
                        </select>
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
        <!-- DIV DATA DIRI -->
        <div class="col-md-12">
          <div class="col-md-12">
            <div class="card card-success">
              <!-- Header -->
              <div class="card-header">
                <h3 class="card-title"><?= $judul ?> Eksternal</h3>
              </div>
              <!-- Header -->
              <!-- Body -->
              <div class="card-body">
                <!-- Table -->
                <table id="table" class="table table-bordered" width="100%">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Tgl Penyerahan</th>
                      <th>Tgl Selesai</th>
                      <!-- <th>Status Perbaikan</th> -->
                      <th>Jenis Pekerjaan</th>
                      <th>Nomor Aset</th>
                      <th>Serial Number</th>
                      <th>Nama Aset</th>
                      <th>Peminta Jasa</th>
                      <th>Note</th>
                      <th>Note Selesai</th>
                      <th>Status</th>
                      <th>History</th>
                      <?php
                      $login_as = $this->session->userdata();
                      $login_role = $this->db->query("SELECT * FROM global.global_role WHERE role_id = '1' OR role_id = 'df416116aa07eba2d4140d461ff2dfc3a927515c'")->result_array();
                      foreach ($login_role as $value) {
                        if ($login_as['role_id'] == $value['role_id']) {
                      ?>
                          <th>Proses</th>
                      <?php
                        }
                      }

                      ?>
                    </tr>
                  </thead>
                </table>
                <!-- Table -->
                <!-- Modal -->
                <div class="modal fade" id="modal">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title"><?= $judul ?> Eksternal</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <form id="form_modal">
                        <input type="hidden" id="aset_perbaikan_id" name="aset_perbaikan_id" value="">
                        <input type="hidden" id="temp_aset_id" name="temp_aset_id" value="">
                        <input type="hidden" id="temp_aset_nomor" name="temp_aset_nomor" value="">
                        <input type="hidden" id="temp_aset_detail_merk" name="temp_aset_detail_merk" value="">
                        <div class="modal-body">
                          <div class="card-body row">
                            <div class="col-12">
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Tgl Penyerahan *</label>
                                <div class="input-group col-md-8">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text">
                                      <i class="far fa-calendar-alt"></i>
                                    </span>
                                  </div>
                                  <input type="text" class="form-control float-right" id="tanggal" name="tanggal" readonly>
                                </div>
                                <label class="col-md-4"></label>
                                <i style="display:none;color:red" class="" id="tanggal_alert">Tanggal Penyerahan Tidak Boleh Kosong</i>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Nomor Aset *</label>
                                <div class="input-group col-md-8">
                                  <select class="form-control" name="aset_nomor_utama" id="aset_nomor_utama" onchange="func_gantiKodeItem(this.value);func_gantiAsetNama(this.value);">

                                  </select>
                                </div>
                                <label class="col-md-4"></label>
                                <i style="display:none;color:red" class="invalid" id="nomor_alert">Nomor Aset Tidak Boleh Kosong</i>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Nama Aset *</label>
                                <div class="input-group col-md-8">
                                  <input type="text" name="aset_nama" id="aset_nama" class="form-control" readonly>
                                  <!-- <select class=" form-control" id="aset_id" name="aset_id" onchange="func_gantiKodeItem(this.value);func_gantiSerial(this.value)">
                                    </select> -->
                                </div>
                                <label class="col-md-4"></label>
                                <i style="display:none;color:red" class="invalid" id="nama_alert">Nama Aset Tidak Boleh Kosong</i>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Serial Number *</label>
                                <div class="input-group col-md-8">
                                  <select class="form-control select2" id="item_id" name="item_id">
                                  </select>
                                </div>
                                <label class="col-md-4"></label>
                                <i style="display:none;color:red" class="invalid" id="serial_alert">Serial Number Tidak Boleh Kosong</i>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Jenis Pekerjaan *</label>
                                <div class="input-group col-md-8">
                                  <select class="form-control" id="pekerjaan_id" name="pekerjaan_id">
                                    <option value="p">Perbaikan</option>
                                    <option value="k">Kalibrasi</option>
                                  </select>
                                </div>
                                <label class="col-md-4"></label>
                                <i style="display:none;color:red" class="invalid" id="jenis_alert">jenis Pekerjaan Tidak Boleh Kosong</i>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Peminta Jasa *</label>
                                <div class="input-group col-md-8">
                                  <select class="form-control select2" id="peminta_id" name="peminta_id">
                                  </select>
                                </div>
                                <label class="col-md-4"></label>
                                <i style="display:none;color:red" class="invalid" id="peminta_alert">Peminta Jasa Tidak Boleh Kosong</i>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Status Pekerjaan *</label>
                                <div class="input-group col-md-8">
                                  <select class="form-control" id="aset_perbaikan_status" name="aset_perbaikan_status">
                                    <option value="t">Terjadwal</option>
                                    <option value="n">Pengajuan</option>
                                    <option value="k">Dikerjakan</option>
                                    <option value="p">Pending</option>
                                    <option value="y">Selesai</option>
                                  </select>
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Vendor *</label>
                                <div class="input-group col-md-8">
                                  <input type="text" class="form-control" id="aset_perbaikan_vendor" value="" placeholder="Vendor" name="aset_perbaikan_vendor">
                                </div>
                                <label class="col-md-4"></label>
                                <i style="display:none;color:red" class="invalid" id="vendor_alert">Vendor Tidak Boleh Kosong</i>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Note *</label>
                                <div class="input-group col-md-8">
                                  <input type="text" class="form-control" id="aset_note" value="" placeholder="Note" name="aset_note">
                                </div>
                                <label class="col-md-4"></label>
                                <i style="display:none;color:red" class="invalid" id="note_alert">Note Tidak Boleh Kosong</i>
                              </div>
                              <hr>

                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Tgl Selesai *</label>
                                <div class="input-group col-md-8">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text">
                                      <i class="far fa-calendar-alt"></i>
                                    </span>
                                  </div>
                                  <input type="text" class="form-control float-right" id="tanggal_selesai" name="tanggal_selesai">
                                </div>
                                <label class="col-md-4"></label>
                                <i style="display:none;color:red" class="invalid" id="tanggal_selesai_alert">Tanggal Selesai Tidak Boleh Kosong</i>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Note *</label>
                                <div class="input-group col-md-8">
                                  <input type="text" class="form-control" id="aset_note_selesai" name="aset_note_selesai" value="" placeholder="Note">
                                </div>
                                <label class="col-md-4"></label>
                                <i style="display:none;color:red" class="invalid" id="note_selesai_alert">Note Tidak Boleh Kosong</i>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">File Sebelumnya</label>
                                <div class="input-group col-md-8">
                                  <input type="label" class="form-control" id="aset_file_lama" name="aset_file_lama" readonly>
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">File *</label>
                                <div class="input-group col-md-8">
                                  <input type="file" class="form-control" id="aset_file" name="aset_file" value="" placeholder="Note">
                                </div>
                                <label class="col-md-4"></label>
                                <i style="display:none;color:red" class="invalid" id="file_alert">File Tidak Boleh Kosong</i>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="modal-footer justify-content-between">
                          <button type="button" id="close" class="btn btn-default" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-success" id="simpan">Simpan</button>
                          <button type="submit" class="btn btn-primary" id="edit" style="display: none">Edit</button>
                          <button class="btn btn-primary" type="button" id="loading_form" disabled style="display: none;">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                          </button>
                        </div>
                      </form>
                    </div>
                    <!-- /.modal-content -->
                  </div>
                  <!-- /.modal-dialog -->
                </div>
                <!-- Modal -->
                <!-- Modal -->
                <div class="modal fade" id="modal_history">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title"><?= $judul ?></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <form id="form_modal_history_detail">
                        <!-- <input type="text" name="aset_perbaikan_id" id="aset_perbaikan_id"> -->
                        <div class="modal-body">
                          <div class="card-body row">
                            <div class="col-12">
                              <table id="table_history" class="table table-bordered table-striped" width="100%">
                                <thead>
                                  <tr>
                                    <th>No</th>
                                    <th>Peminta Jasa</th>
                                    <th>When Create</th>
                                    <th>Who Create</th>
                                  </tr>
                                </thead>
                              </table>
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                          <button type="button" id="close_detail" class="btn btn-default" data-dismiss="modal">Close</button>
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