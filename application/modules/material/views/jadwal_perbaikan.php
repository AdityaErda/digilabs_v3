<!-- css tambahan -->
<style>
  div.dataTables_wrapper {
    margin: 0 auto;
  }

  .form-control-xs {
    padding: 15px !important;
    font-size: 9pt !important;
    line-height: 1.75px;
    border-radius: 15px;
  }

  .bulan {
    text-align: center;
  }

  .DTFC_LeftBodyWrapper {
    top: 15px;
  }

  .dataTables_scrollHead {
    overflow: auto !important;
    /*    z-index:1;*/
    /*    width: 100%;*/
  }

  /* .dataTables_scrollHead { */
  /* overflow: auto !important; */
  /* } */
</style>
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

                    <div class="form-group col-md-2">
                      <label class="col-md-12">Tahun</label>
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
                    <div class="form-group row col-md-3">
                      <label class="col-md-12">Jenis Pekerjaan</label>
                      <div class="input-group col-md-12">
                        <select class="form-control" id="pekerjaan_id_cari" name="pekerjaan_id_cari">
                          <option value="-">Semua Pekerjaan</option>
                          <option value="p">Perbaikan</option>
                          <option value="k">Kalibrasi</option>
                        </select>
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
                    <div class="form-group col-md-4">
                      <label class="col-md-12">&nbsp;</label>
                      <input type="submit" class="btn btn-success pull-right col-md-7" id="cari" value="cari" onclick="fun_tahun(this.value)">
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
                <?php $login_as = $this->session->userdata(); ?>
                <?php $role = $this->db->query("SELECT * FROM global.global_role WHERE role_id = '1' OR role_id = 'df416116aa07eba2d4140d461ff2dfc3a927515c' OR role_id = '79d5b34a78b48d85eb1b65249fca73704dc49665'")->result_array(); ?>
                <?php foreach ($role as $value) { ?>
                  <?php if ($value['role_id'] == $login_as['role_id']) { ?>
                    <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal" onclick="fun_tambah()">Tambah</button>
                    <label class="float-right">&nbsp;</label>
                    <a href="<?= base_url('material/jadwal_perbaikan/index_import?header_menu=32&menu_id=35&import_kode=0') ?>" class="btn btn-danger float-right">Import</a>
                <?php }
                } ?>
              </div>
              <!-- Header -->
              <!-- Body -->
              <div class="card-body">
                <!-- Table -->
                <table id="table" class="table table-sm table-bordered table-striped" width="100%">
                  <thead style="background-color:white">
                    <tr>
                      <th style="background-color:white">
                        <input type="text" class="form-control form-control-xs" onkeyup="func_nomor_aset_cari(this.value)" name="nomor_aset_cari" placeholder="Nomor Aset">
                      </th>
                      <th style="background-color:white">
                        <input type="text" class="form-control form-control-xs" onkeyup="func_nama_aset_cari(this.value)" name="nama_aset_cari" placeholder="Nama Aset">
                      </th>
                      <th style="background-color:white">
                        <input type="text" class="form-control form-control-xs" onkeyup="func_serial_number_cari(this.value)" name="serial_number_cari" placeholder="Serial Number">
                      </th>
                      <th style="background-color:white">
                        <input type="text" class="form-control form-control-xs" onkeyup="func_pengelola_cari(this.value)" name="pengelola_cari" placeholder="Pengelola Aset">
                      </th>
                      <th style="background-color:white">
                        <input type="text" class="form-control form-control-xs" onkeyup="func_vendor_cari(this.value)" name="vendor_cari" placeholder="Vendor">
                      </th>
                      <th style="background-color:white"></th>
                      <?php $Bulan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"); ?>
                      <?php for ($i = 0; $i < 12; $i++) { ?>
                        <th colspan="4" class="bulan"><?= $Bulan[$i] ?></th>
                      <?php } ?>
                      <?php $login_as = $this->session->userdata(); ?>
                      <?php $role = $this->db->query("SELECT * FROM global.global_role WHERE role_id = '1' OR role_id = 'df416116aa07eba2d4140d461ff2dfc3a927515c' OR role_id = '79d5b34a78b48d85eb1b65249fca73704dc49665'")->result_array(); ?>
                      <?php foreach ($role as $value) { ?>
                        <?php if ($value['role_id'] == $login_as['role_id']) { ?>
                          <th rowspan="2" class="bulan">Action</th>
                      <?php }
                      } ?>
                    </tr>

                    <tr>
                      <th class="sort" style="background-color:white">Nomor Aset</th>
                      <th class="sort" style="background-color:white">Nama Aset</th>
                      <th class="sort" style="background-color:white">Serial Number</th>
                      <th class="sort" style="background-color:white">Pengelola Aset</th>
                      <th class="sort" style="background-color:white">Vendor</th>
                      <th class="sort" style="background-color:white">Status Pekerjaan</th>
                      <?php for ($i = 1; $i <= 12; $i++) { ?>
                        <?php for ($j = 1; $j <= 4; $j++) { ?>
                          <th><?= $j ?></th>
                      <?php }
                      } ?>
                      <?php $login_as = $this->session->userdata(); ?>
                      <?php $role = $this->db->query("SELECT * FROM global.global_role WHERE role_id = '1' OR role_id = 'df416116aa07eba2d4140d461ff2dfc3a927515c' OR role_id = '79d5b34a78b48d85eb1b65249fca73704dc49665'")->result_array(); ?>
                      <?php foreach ($role as $value) { ?>
                        <?php if ($value['role_id'] == $login_as['role_id']) { ?>
                          <!-- <th rowspan="2" style="" class="bulan">Action</th> -->
                      <?php }
                      } ?>
                    </tr>
                  </thead>
                </table>

                Info :<br>
                <i style="color:#FFA500" class="fa fa-circle"></i>
                Perbaikan Terjadwal<br />
                <i style="color:#FF0000" class="fa fa-circle"></i>
                Kalibrasi Terjadwal<br />
                <i style="color:#DA70D6" class="fa fa-circle"></i>
                Perbaikan Pengajuan<br />
                <i style="color:#8A2BE2" class="fa fa-circle"></i>
                Kalibrasi Pengajuan<br />
                <i style="color:#0FF700" class="fa fa-circle"></i>
                Perbaikan Dikerjakan<br />
                <i style="color:#32CD32" class="fa fa-circle"></i>
                Kalibrasi Dikerjakan<br />
                <i style="color: #FFFF66" class="fa fa-circle"></i>
                Perbaikan Pending<br />
                <i style="color: #FFFF33" class="fa fa-circle"></i>
                Kalibrasi Pending<br />
                <i style="color: #20B2AA" class="fa fa-circle"></i>
                Perbaikan Sudah Dikerjakan<br />
                <i style="color: #1E90FF" class="fa fa-circle"></i>
                Kalibrasi Sudah Dikerjakan<br />

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
                        <div class="modal-body">
                          <div class="card-body row">
                            <div class="col-12">
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Tgl Pengajuan *</label>
                                <div class="input-group col-md-8">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text">
                                      <i class="far fa-calendar-alt"></i>
                                    </span>
                                  </div>
                                  <input type="text" class="form-control float-right" id="tanggal" name="tanggal">
                                </div>
                                <label class="col-md-4"></label>
                                <i style="color:red;display:none" id="tanggal_pengajuan_alert">Tanggal Pengajuan Tidak Boleh Kosong</i>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Tgl Deadline *</label>
                                <div class="input-group col-md-8">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text">
                                      <i class="far fa-calendar-alt"></i>
                                    </span>
                                  </div>
                                  <input type="text" class="form-control float-right" id="tanggal_deadline" name="tanggal_deadline">
                                </div>
                                <label class="col-md-4"></label>
                                <i style="color:red;display:none" id="tanggal_deadline_alert">Tanggal Deadline Tidak Boleh Kosong</i>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Tgl Selesai </label>
                                <div class="input-group col-md-8">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text">
                                      <i class="far fa-calendar-alt"></i>
                                    </span>
                                  </div>
                                  <input type="text" class="form-control float-right" id="tanggal_selesai" name="tanggal_selesai">
                                </div>
                                <label class="col-md-4"></label>
                                <i style="color:red;display:none" id="tanggal_selesai_alert">Tanggal Selesai Tidak Boleh Kosong</i>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Nama Aset * </label>
                                <div class="input-group col-md-8">
                                  <select class="form-control" id="aset_id" name="aset_id" onchange="func_gantiKodeItem(this.value);func_gantiSerial(this.value)">
                                  </select>
                                </div>
                                <label class="col-md-4"></label>
                                <i style="color:red;display:none" id="aset_alert">Nama Aset Tidak Boleh Kosong</i>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Nomor Aset</label>
                                <div class="input-group col-md-8">
                                  <input type="text" readonly class="form-control" name="aset_nomor_utama" id="aset_nomor_utama">
                                </div>
                                <label class="col-md-4"></label>
                                <i style="color:red;display:none" id="nomor_utama_alert">Nomor Aset Tidak Boleh Kosong</i>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Serial Number *</label>
                                <div class="input-group col-md-8">
                                  <select class="form-control" id="item_id" name="item_id">
                                  </select>
                                </div>
                                <label class="col-md-4"></label>
                                <i style="color:red;display:none" id="serial_alert">Serial Number Tidak Boleh Kosong</i>
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
                                <i style="color:red;display:none" id="pekerjaan_alert">Jenis Pekerjaan Tidak Boleh Kosong</i>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Pengelola Aset *</label>
                                <div class="input-group col-md-8">
                                  <select class="form-control" id="peminta_id" name="peminta_id">
                                  </select>
                                </div>
                                <label class="col-md-4"></label>
                                <i style="color:red;display:none" id="peminta_alert">Pengelola Aset Tidak Boleh Kosong</i>
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
                                <label class="col-md-4"></label>
                                <i style="color:red;display:none" id="perbaikan_status_alert">Status Pekerjaan Tidak Boleh Kosong</i>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Vendor *</label>
                                <div class="input-group col-md-8">
                                  <input type="text" class="form-control" name="aset_perbaikan_vendor" value="" id="aset_perbaikan_vendor" placeholder="Vendor">
                                </div>
                                <label class="col-md-4"></label>
                                <i style="color:red;display:none" id="perbaikan_vendor_alert">Vendor Tidak Boleh Kosong</i>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Note *</label>
                                <div class="input-group col-md-8">
                                  <input type="text" class="form-control" name="aset_note" value="" id="aset_note" placeholder="Note">
                                </div>
                                <label class="col-md-4"></label>
                                <i style="color:red;display:none" id="note_alert">Note Tidak Boleh Kosong</i>
                              </div>
                              <div id="div_file_sebelum" style="display: none">
                                <div class="form-group row col-md-12">
                                  <label class="col-md-4">File Sebelumnya</label>
                                  <div class="input-group col-md-8">
                                    <input type="label" class="form-control" id="aset_file_lama" name="aset_file_lama" readonly>
                                  </div>
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">File <span id="file_required">*</span></label>
                                <div class="input-group col-md-8">
                                  <input type="file" class="form-control" id="aset_file" name="aset_file" value="" placeholder="Note" accept="application/pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,image/*">
                                </div>
                                <label class="col-md-4"></label>
                                <i style="color:red;display:none" id="file_alert">File Tidak Boleh Kosong</i>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="text-center">
                          <div class="spinner-border" role="status" id="loading" style="display:none">
                            <span class="sr-only" style="position: absolute;display: block;top: 50%;left: 50%;">Loading...</span>
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
                <div class="modal fade" id="modal_lihat">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title"><?= $judul ?> Eksternal</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <form id="form_modal">
                        <!-- <input type="hidden" id="jadwal_id" name="jadwal_id" value=""> -->
                        <div class="modal-body">
                          <div class="card-body row" id="div_document" style="height: 400px;">
                          </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                          <button type="button" id="close" onclick="fun_close()" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
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