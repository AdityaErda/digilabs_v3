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
                      </div>
                    <!-- Header -->
                    <!-- Body -->
                      <div class="card-body">
                        <!-- Table -->
                          <table id="table" class="table table-bordered" width="100%">
                            <thead>
                              <tr >
                                <th>No</th>
                                <th>Judul</th>
                                <th>Jenis</th>
                                <th>Tgl Pengesahan</th>
                                <th>Nomor</th>
                                <th>Revisi</th>
                                <th>Terbitan</th>
                                <th>File</th>
                                <!-- jika role admin ,superadmin, dan pengendali dokumen -->
                                <?php $login_as     = $this->session->userdata();
                                
                                $login_role   = $this->db->query("SELECT role_id FROM global.global_role WHERE role_id = '5c52e905e81f137cc9357a0555a6948f81e84254' OR role_id = '1' OR role_id = '79d5b34a78b48d85eb1b65249fca73704dc49665'")->result_array();
                                $login_role_x = $this->db->query("SELECT role_id FROM global.global_role WHERE role_id != '5c52e905e81f137cc9357a0555a6948f81e84254' AND role_id != '1' AND role_id != '79d5b34a78b48d85eb1b65249fca73704dc49665'")->result_array();      
                                ?>
                                      
                                <?php foreach($login_role as $value):?>
                                <?php  if ($login_as['role_id']==$value['role_id']): ?>
                                <th width="12%">Action</th>
                                <?php endif; ?> 
                                <?php endforeach; ?>

                                <?php foreach($login_role_x as $value):?>
                                <?php  if ($login_as['role_id']==$value['role_id']): ?>
                                <th width="12%">Action</th>
                                <?php endif; ?> 
                                <?php endforeach; ?>

                              </tr>
                            </thead>
                          </table>
                        <!-- Table -->
                        
                        <!-- Modal -->
                        <div class="modal fade" id="modal_perubahan">
                            <div class="modal-dialog modal-lg">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h4 class="modal-title"><?= $judul ?></h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <form id="form_modal_perubahan">
                                  <input type="hidden" id="transaksi_id" name="transaksi_id" value="">
                                  <input type="hidden" id="transaksi_urut_document" name="transaksi_urut_document" value="">

                                  <div class="modal-body">
                                    <div class="card-body row">
                                      <!-- Kiri -->
                                        <div class="col-12">
                                          <div class="form-group row col-md-12">
                                            <label class="col-md-4">Jenis Document *</label>
                                            <div class="input-group col-md-8">
                                              <select class="form-control select2" id="jenis_document" name="jenis_document">
                                              </select>
                                            </div>
                                            <label class="col-md-4"></label>
                                            <i style="display:none;color:red" class="invalid" id="jenis_alert">Jenis Document Tidak Boleh Kosong</i>
                                          </div>
                                          <div class="form-group row col-md-12">
                                            <label class="col-md-4">Seksi *</label>
                                            <div class="input-group col-md-8">
                                              <select onchange="func_no_doc1(this.value)" class="form-control select2" id="seksi" name="seksi">
                                              </select>
                                            </div>
                                            <label class="col-md-4"></label>
                                            <i style="display:none;color:red" class="invalid" id="seksi_alert">Seksi Tidak Boleh Kosong</i>
                                          </div>
                                          <div class="form-group row col-md-12">
                                            <label class="col-md-4">Judul Document *</label>
                                            <div class="input-group col-md-8">
                                              <input type="text" class="form-control" name="judul_document" value="" placeholder="Judul Document" id="judul_document">
                                            </div>
                                            <label class="col-md-4"></label>
                                            <i style="display:none;color:red" class="invalid" id="judul_alert">Judul Tidak Boleh Kosong</i>
                                          </div>
                                          <div class="form-group row col-md-12">
                                            <label class="col-md-4">Nomor Document *</label>
                                            <div class="input-group col-md-8">
                                              <input readonly type="text" class="form-control" name="nomor_document" value="" id="nomor_document" placeholder="Nomor Document">
                                            </div>
                                            <label class="col-md-4"></label>
                                            <i style="display:none;color:red" class="invalid" id="nomor_alert">Nomor Document Tidak Boleh Kosong</i>
                                          </div>
                                          <div class="form-group row col-md-12">
                                            <label class="col-md-4">Tanggal Perubahan *</label>
                                            <div class="input-group col-md-8">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                              </span>
                                            </div>
                                              <input type="text" class="form-control" name="tanggal" id="tanggal" value="" placeholder="Tanggal Pengesahaan">
                                            </div>
                                            <label class="col-md-4"></label>
                                            <i style="display:none;color:red" class="invalid" id="tanggal_alert">Judul Tidak Boleh Kosong</i>
                                          </div>
                                          <div class="form-group row col-md-12">
                                            <label class="col-md-4">Revisi * / Terbitan *</label>
                                            <div class="input-group col-md-8">
                                              <input type="text" class="form-control col-md-5" name="revisi" id="revisi" value="" placeholder="Revisi">
                                              <label class="col-md-1">/</label>
                                              <input type="text" class="form-control col-md-5" name="" value="" name="terbitan" id="terbitan" placeholder="Terbitan">
                                            </div>
                                            <label class="col-md-4"></label>
                                            <i style="display:none;color:red" class="invalid" id="revisi_alert">Revisi Tidak Boleh Kosong</i>
                                            <label class="col-md-1"></label>
                                            <i style="display:none;color:red" class="invalid" id="terbitan_alert">Terbitan Tidak Boleh Kosong</i>
                                          </div>
                                          <div class="form-group row col-md-12">
                                            <label class="col-md-4">Keterangan *</label>
                                            <div class="input-group col-md-8">
                                              <textarea class="form-control" name="keterangan" id="keterangan" value="" placeholder="Keterangan"></textarea>
                                            </div>
                                            <label class="col-md-4"></label>
                                            <i style="display:none;color:red" class="invalid" id="keterangan_alert">Keterangan Tidak Boleh Kosong</i>
                                          </div>
                                          <div id="div_word_lama" style="display:none">
                                            <div class="form-group row col-md-12">
                                              <label class="col-md-4">File Word Sebelumnya</label>
                                              <div class="input-group col-md-8">
                                                <input type="text" readonly name="file_word_lama" id="file_word_lama" class="form-control">
                                              </div>
                                            </div>
                                          </div>
                                          <div class="form-group row col-md-12">
                                            <label class="col-md-4">File Word</label>
                                            <div class="input-group col-md-8">
                                              <input type="file" class="form-control" name="file_word" id="file_word" value="" placeholder="" accept=".doc,.docx">
                                            </div>
                                            <label class="col-md-4"></label>
                                            <i style="display:none;color:red" class="invalid" id="word_alert">File Word Tidak Boleh Kosong</i>
                                          </div>
                                          <div id="div_pdf_lama" style="display: none">
                                            <div class="form-group row col-md-12">
                                              <label class="col-md-4">File PDF Sebelumnya</label>
                                              <div class="input-group col-md-8">
                                                <input type="text" name="file_pdf_lama" readonly id="file_pdf_lama" class="form-control">
                                              </div>
                                            </div>
                                          </div>
                                          <div class="form-group row col-md-12">
                                            <label class="col-md-4">File PDF</label>
                                            <div class="input-group col-md-8">
                                              <input type="file"  class="form-control" name="file_pdf" id="file_pdf" value="" placeholder="" accept=".pdf">
                                            </div>
                                            <label class="col-md-4"></label>
                                            <i style="display:none;color:red" class="invalid" id="pdf_alert">File PDF Tidak Boleh Kosong</i>
                                          </div>
                                        </div>
                                      <!-- Kanan -->
                                    </div>
                                  <div class="modal-footer justify-content-between">
                                    <button type="button" id="close_perubahan" onclick="fun_close()" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-success" id="simpan_perubahan">Simpan</button>
                                    <button type="submit" class="btn btn-primary" id="edit_perubahan" style="display: none">Edit</button>
                                    <button class="btn btn-primary" type="button" id="loading_form" disabled style="display:none;">
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
                        </div>
                        <!-- Modal -->
                        
                        <!-- Modal -->
                          <div class="modal fade" id="modal1">
                            <div class="modal-dialog modal-lg">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h4 class="modal-title"><?= $judul ?></h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <form id="form_modal">
                                  <input type="hidden" id="jadwal_id" name="jadwal_id" value="">
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

                        <!-- Modal -->
                        <div class="modal fade" id="modal_download">
                            <div class="modal-dialog modal-lg">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h4 class="modal-title">Download <?= $judul ?></h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                  <div class="modal-body">
                                    <div class="card-body row">
                                      <div class="col-12">
                                        <table id="table_download" class="table table-bordered" width="100%">
                                          <thead>
                                            <tr>
                                              <th width="50%">File PDF</th>
                                            <?php $login_as = $this->session->userdata();?>
                                            <?php $role = $this->db->query("SELECT * FROM global.global_role WHERE role_id = '1' OR role_id = '5c52e905e81f137cc9357a0555a6948f81e84254'")->result_array();?>
                                            <?php foreach($role as $value) { ?>
                                              <?php if($value['role_id']==$login_as['role_id']){?>
                                                <th width="50%">File Word</th>
                                              <?php } ?>
                                            <?php } ?>
                                            
                                            </tr>
                                          </thead>
                                        </table>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="modal-footer justify-content-between">
                                    <button type="button" id="close" onclick="fun_close()" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" id="edit" style="display: none">Selesai</button>
                                  </div>
                               
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
                                <form id="form_modal">
                                  <div class="modal-body">
                                    <div class="card-body row">
                                      <div class="col-lg-12 col-md-12">
                                        <table id="table_history" class="table table-bordered  " width="100%">
                                          <thead>
                                            <tr >
                                              <th>Nama File</th>
                                              <th>Download By</th>
                                              <th>Download Time</th>
                                            </tr>
                                          </thead>
                                        </table>
                                      </div>
                                    </div>
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
                        <!-- Modal -->
                        <div class="modal fade" id="modal_history_detail">
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
                                    <div class="card-body row">
                                      <div class="col-12">
                                        <table id="table_history_detail" class="table table-bordered" width="100%">
                                          <thead>
                                            <tr >
                                              <th>Nama File</th>
                                              <th>Download By</th>
                                              <th>Download Time</th>
                                            </tr>
                                          </thead>
                                        </table>
                                      </div>
                                    </div>
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

            <!-- DIV DATA DIRI -->
              <div class="col-md-12" id="div_detail" style="display: none;">
                <div class="col-md-12">
                  <div class="card card-secondary">
                    <!-- Header -->
                      <div class="card-header" > 
                        <h3 class="card-title">Detail <?=$judul?></h3>
                        <button type="button" class="close" aria-label="Close" onclick="fun_close()" >
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                    <!-- Header -->
                    <!-- Body -->
                      <div class="card-body">
                        <!-- Table -->
                          <table id="table1" class="table table-bordered" width="100%">
                            <thead>
                              <tr >
                                <th>Tanggal Pengajuan</th>
                                <th>Tanggal Pengesahan</th>
                                <th>Judul Document</th>
                                <th>Nomor Document</th>
                                <th>Revisi</th>
                                <th>Terbitan</th>
                                <th>Keterangan</th>
                                <th>Note</th>
                                <th>File</th>
                                <th>Action</th>
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