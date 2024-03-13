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
                <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal" onclick="func_tambah()">Tambah</button>
              </div>
              <!-- Header -->
              <!-- Body -->
              <div class="card-body">
                <!-- Table -->
                <table id="table" class="table table-bordered " width="100%">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Pengajuan</th>
                      <th>Pengesahan</th>
                      <th>Judul</th>
                      <th>Jenis</th>
                      <th>Nomor</th>
                      <th>Keterangan</th>
                      <th>File</th>
                      <!-- <th>File PDF</th> -->
                      <th>Status</th>
                      <th>Lihat</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                </table>
                <!-- Table -->
                <!-- Modal -->
                <div class="modal fade" id="modal">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title"><?= $judul ?></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <form id="form_modal">
                        <input type="hidden" id="transaksi_id" name="transaksi_id" value="">
                        <input type="hidden" id="transaksi_urut_document" name="transaksi_urut_document">
                        <div class="modal-body">

                          <div class="card-body row">
                            <!-- Kiri -->
                            <div class="col-12">
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Jenis Document *</label>
                                <div class="input-group col-md-8">
                                  <select class="form-control select2" id="jenis_document" name="jenis_document" onchange="func_jenis_no_doc(this.value)">
                                  </select>
                                  <i style="display:none;color:red" class="invalid" id="jenis_alert">Jenis Document Tidak Boleh Kosong</i>
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Seksi *</label>
                                <div class="input-group col-md-8">
                                  <select onchange="func_no_doc(this.value);fun_no_kosong();" class="form-control select2" id="seksi" name="seksi">
                                  </select>
                                  <i style="display:none;color:red" class="invalid" id="seksi_alert">Seksi Document Tidak Boleh Kosong</i>
                                </div>
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
                                  <input type="text" class="form-control" onkeyup="func_cekNomorKembar(this.value)" name="nomor_document" value="" id="nomor_document" placeholder="Nomor Document">
                                </div>
                                <label class="col-md-4"></label>
                                <i style="display:none;color:red" class="invalid" id="nomor_alert">Nomor Document Tidak Boleh Kosong</i>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Tanggal Pengajuan *</label>
                                <div class="input-group col-md-8">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text">
                                      <i class="far fa-calendar-alt"></i>
                                    </span>
                                  </div>
                                  <input readonly type="text" class="form-control" name="tanggal" id="tanggal" value="" placeholder="Tanggal Pengajuan">
                                </div>
                                <label class="col-md-4"></label>
                                <i style="display:none;color:red" class="invalid" id="tanggal_alert">Tanggal Tidak Boleh Kosong</i>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Revisi / Terbitan *</label>
                                <div class="input-group col-md-8">
                                  <input type="text" class="form-control col-md-5" name="revisi" id="revisi" value="" placeholder="Revisi" onkeypress="return numberOnly(event)" onpaste="return numberOnly(event)">
                                  <label class="col-md-1">/</label>
                                  <input type="text" class="form-control col-md-5" name="" value="" name="terbitan" id="terbitan" placeholder="Terbitan" onkeypress="return numberOnly(event)">
                                </div>
                                <label class="col-md-4"></label>
                                <i style="display:none;color:red" class="invalid" id="revisi_alert">Revisi Tidak Boleh Kosong</i>
                                <label class="col-md-1"></label>
                                <i style="display:none;color:red" class="invalid" id="terbitan_alert">Terbitan Tidak Boleh Kosong</i>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Keterangan</label>
                                <div class="input-group col-md-8">
                                  <textarea class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan"></textarea>
                                </div>
                                <label class="col-md-4"></label>
                                <i style="display:none;color:red" class="invalid" id="keterangan_alert">Keterangan Tidak Boleh Kosong</i>
                              </div>
                              <div id="div_word_lama" style="display:none">
                                <div class="form-group row col-md-12">
                                  <label class="col-md-4">File Word Sebelumnya </label>
                                  <div class="input-group col-md-8">
                                    <input type="text" readonly id="file_word_lama" class="form-control">
                                  </div>
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">File Word <span id="word_wajib_bintang">*</span></label>
                                <div class="input-group col-md-8">
                                  <input type="file" class="form-control" name="file_word" id="file_word" value="" placeholder="" accept=".doc,.docx">
                                </div>
                                <label class="col-md-4"></label>
                                <i style="display:none;color:red" class="invalid" id="word_alert">File Word Tidak Boleh Kosong</i>
                              </div>
                              <div id="div_pdf_lama" style="display: none">
                                <div class="form-group row col-md-12">
                                  <label class="col-md-4">File PDF Sebelumnya </label>
                                  <div class="input-group col-md-8">
                                    <input type="text" readonly id="file_pdf_lama" class="form-control">
                                  </div>
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">File PDF <span id="pdf_wajib_bintang">*</span></label>
                                <div class="input-group col-md-8">
                                  <input type="file" class="form-control" name="file_pdf" id="file_pdf" value="" placeholder="" accept=".pdf">
                                </div>
                                <label class="col-md-4"></label>
                                <i style="display:none;color:red" class="invalid" id="pdf_alert">File PDF Tidak Boleh Kosong</i>
                              </div>
                            </div>
                          </div>
                          <!-- Kanan -->
                        </div>
                        <div class="modal-footer justify-content-between">
                          <button type="button" id="close" class="btn btn-default" data-dismiss="modal" onclick="fun_close();">Close</button>
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
                            <!-- <iframe src="http://docs.google.com/viewer?url=<? //=base_url('upload/20210913091837-DB digilab.pdf	')
                                                                                ?>embedded=true" style="margin:0 auto; width:800px; height:800px;" frameborder="0"></iframe> -->
                            <!-- <iframe src="" id="frame_file" frameborder="0" width="600" height="" style="display:block"></iframe> -->
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