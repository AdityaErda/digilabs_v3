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
                    <tr>
                      <th>Nama Lengkap</th>
                      <th>Tempat Lahir</th>
                      <th>Tanggal Lahir</th>
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
                        <input type="text" id="user_id" name="user_id" value="" style="display:none">
                        <input type="text" id="cv_id" name="cv_id" value="" style="display:none">
                        <div class="modal-body">
                          <div class="card-body row">
                            <div class="col-12">
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">NIK</label>
                                <div class="input-group col-md-8">
                                  <input type="text" id="nik" name="nik" placeholder="NIK" class="form-control">
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Nama Lengkap</label>
                                <div class="input-group col-md-8">
                                  <input type="text" id="user_nama" name="user_nama" placeholder="Nama Lengkap" class="form-control" readonly>
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Tempat Lahir</label>
                                <div class="input-group col-md-8">
                                  <input type="text" placeholder="Tempat Lahir" id="tempat_lahir" name="tempat_lahir" class="form-control" readonly>
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Tanggal Lahir</label>
                                <div class="input-group col-md-8">
                                  <input type="text" placeholder="Tanggal Lahir" id="tanggal_lahir" name="tanggal_lahir" class="form-control" readonly>
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Email</label>
                                <div class="input-group col-md-8">
                                  <input type="email" id="email" name="email" placeholder="Email" class="form-control">
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Alamat</label>
                                <div class="input-group col-md-8">
                                  <textarea id="alamat" name="alamat" class="form-control" placeholder="Alamat"></textarea>
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Tanggal Masuk</label>
                                <div class="input-group col-md-8">
                                  <input type="date" placeholder="Tanggal Masuk" id="tanggal_masuk" name="tanggal_masuk" class="form-control" onchange="func_masaKerja(this.value)">
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Masa Kerja</label>
                                <div class="input-group col-md-8">
                                  <input type="text" placeholder="Masa Kerja" id="masa_kerja_tahun" name="masa_kerja_tahun" class="form-control">
                                </div>
                              </div>

                              <button type="button" class="btn btn-success pull-right" id="konfirmasi">Konfirmasi</button>
                              <button class="btn btn-primary" type="button" id="loading_form" disabled style="display: none;">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...
                              </button>
                              <hr>
                              <div class="form-group row col-md-12">
                                <table id="dg_pendidikan_formal" title="Riwayat Pendidikan Formal" style="width:100%" toolbar="#toolbar_pendidikan_formal" pagination="true" idField="pendidikan_formal_id" rownumbers="true" fitColumns="true" singleSelect="true">
                                  <thead>
                                    <tr>
                                      <th field="pendidkan_formal_jenjang" width="50" editor="{type:'text'}">Jenjang</th>
                                      <th field="pendidikan_formal_jurusan" width="50" editor="{type:'text'}">Jurusan</th>
                                      <th field="pendidikan_formal_institusi" width="50" editor="{type:'text'}">Nama Institusi</th>
                                      <th field="pendidikan_formal_tahun" width="50" editor="{type:'numberspinner'}">Tahun Lulus</th>
                                      <th field="pendidikan_formal_file" width="50" editor="{type:'text'}">File</th>
                                    </tr>
                                  </thead>
                                </table>
                                <div id="toolbar_pendidikan_formal">
                                  <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="fun_tambah_pendidikan_formal()">New</a>
                                  <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="fun_hapus_pendidikan_formal()">Delete</a>
                                  <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="fun_simpan_pendidikan_formal(this)">Save</a>
                                  <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:$('#dg_pendidikan_formal').edatagrid('cancelRow')">Cancel</a>
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <table id="dg_pendidikan_non_formal" title="Riwayat Pendidikan Non Formal" style="width:100%" toolbar="#toolbar1" pagination="true" idField="pendidikan_non_formal_id" rownumbers="true" fitColumns="true" singleSelect="true">
                                  <thead>
                                    <tr>
                                      <th field="pendidikan_non_formal_judul" width="50" editor="{type:'text'}">Judul</th>
                                      <th field="pendidikan_non_formal_institusi" width="50" editor="{type:'text'}">Nama Institusi</th>
                                      <th field="pendidikan_non_formal_tahun" width="50" editor="{type:'numberspinner'}">Tahun Lulus</th>
                                      <th field="pendidikan_non_formal_file" width="50" editor="{type:'text'}">File</th>
                                    </tr>
                                  </thead>
                                </table>
                                <div id="toolbar1">
                                  <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="fun_tambah_pendidikan_non_formal()">New</a>
                                  <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="fun_hapus_pendidikan_non_formal()">Delete</a>
                                  <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="fun_simpan_pendidikan_non_formal()">Save</a>
                                  <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:$('#dg_pendidikan_non_formal').edatagrid('cancelRow')">Cancel</a>
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <table id="dg_jabatan" title="Riwayat Jabatan" style="width:100%" toolbar="#toolbar2" pagination="true" idField="jabatan_id" rownumbers="true" fitColumns="true" singleSelect="true">
                                  <thead>
                                    <tr>
                                      <th field="jabatan_mulai" width="50" editor="{type:'datebox'}">Tanggal Mulai</th>
                                      <th field="jabatan_selesai" width="50" editor="{type:'datebox'}">Tanggal Selesai</th>
                                      <th field="jabatan_masa_kerja" width="50" editor="{type:'numberspinner'}">Masa Kerja</th>
                                      <th field="jabatan_unit_kerja" width="50" editor="{type:'text'}">Unit Kerja</th>
                                      <th field="jabatan_nama" width="50" editor="{type:'text'}">Jabatan</th>
                                      <th field="jabatan_file" width="50" editor="{type:'text'}">File</th>
                                    </tr>
                                  </thead>
                                </table>
                                <div id="toolbar2">
                                  <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="fun_tambah_jabatan()">New</a>
                                  <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="fun_hapus_jabatan()">Delete</a>
                                  <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="fun_simpan_jabatan()">Save</a>
                                  <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:$('#dg_jabatan').edatagrid('cancelRow')">Cancel</a>
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <table id="dg_kompetensi" title="Sertifikasi Kompetensi" style="width:100%" toolbar="#toolbar3" pagination="true" idField="kompetensi_id" rownumbers="true" fitColumns="true" singleSelect="true">
                                  <thead>
                                    <tr>
                                      <th field="kompetensi_judul" width="50" editor="{type:'text'}">Judul</th>
                                      <th field="kompetensi_nama" width="50" editor="{type:'text'}">Nama Pelatihan</th>
                                      <th field="kompetensi_tahun" width="50" editor="{type:'numberspinner'}">Tahun Lulus</th>
                                      <th field="kompetensi_file" width="50" editor="{type:'text'}">File</th>
                                    </tr>
                                  </thead>
                                </table>
                                <div id="toolbar3">
                                  <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="fun_tambah_kompetensi()">New</a>
                                  <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="fun_hapus_kompetensi()">Delete</a>
                                  <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="fun_simpan_kompetensi()">Save</a>
                                  <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:$('#dg_kompetensi').edatagrid('cancelRow')">Cancel</a>
                                </div>
                              </div>

                              <div class="form-group row col-md-12">
                                <table id="dg_penugasan_internal" title="Penugasan Internal" style="width:100%" toolbar="#toolbar5" pagination="true" idField="penugasan_internal_id" rownumbers="true" fitColumns="true" singleSelect="true">
                                  <thead>
                                    <tr>
                                      <th field="penugasan_internal_mulai" width="50" editor="{type:'datebox'}">Tanggal Mulai</th>
                                      <th field="penugasan_internal_selesai" width="50" editor="{type:'datebox'}">Tanggal Selesai</th>
                                      <th field="penugasan_internal_nama" width="50" editor="{type:'text'}">Penugasan Internal</th>
                                      <th field="penugasan_internal_memo" width="50" editor="{type:'text'}">Memo</th>
                                      <th field="penugasan_internal_file" width="50" editor="{type:'text'}">File</th>
                                  </thead>
                                </table>
                                <div id="toolbar5">
                                  <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="fun_tambah_penugasan_internal()">New</a>
                                  <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="fun_hapus_penugasan_internal()">Delete</a>
                                  <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="fun_simpan_penugasan_internal()">Save</a>
                                  <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:$('#dg_penugasan_internal').edatagrid('cancelRow')">Cancel</a>
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <table id="dg_pengalaman_kerja" title="Riwayat Pengalaman Kerja Sebelumnya" style="width:100%" toolbar="#toolbar6" pagination="true" idField="pengalaman_kerja_id" rownumbers="true" fitColumns="true" singleSelect="true">
                                  <thead>
                                    <tr>
                                      <th field="pengalaman_tanggal_mulai" width="50" editor="{type:'datebox'}">Tanggal Mulai</th>
                                      <th field="pengalaman_tanggal_selesai" width="50" editor="{type:'datebox'}">Tanggal Selesai</th>
                                      <th field="pengalaman_instansi" width="50" editor="{type:'text'}">Nama Instansi</th>
                                      <th field="pengalaman_unit_kerja" width="50" editor="{type:'text'}">Unit Kerja</th>
                                      <th field="pengalaman_nama" width="50" editor="{type:'text'}">Jabatan</th>
                                      <th field="pengalaman_file" width="50" editor="{type:'text'}">File</th>
                                  </thead>
                                </table>
                                <div id="toolbar6">
                                  <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="fun_tambah_pengalaman_kerja()">New</a>
                                  <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="fun_hapus_pengalaman_kerja()">Delete</a>
                                  <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="fun_simpan_pengalaman_kerja()">Save</a>
                                  <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:$('#dg_pengalaman_kerja').edatagrid('cancelRow')">Cancel</a>
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <table id="dg_data_keluarga" title="Data Keluarga" style="width:100%" toolbar="#toolbar7" pagination="true" idField="data_keluarga_id" rownumbers="true" fitColumns="true" singleSelect="true">
                                  <thead>
                                    <tr>
                                      <th field="data_keluarga_nama" width="50" editor="{type:'text'}">Nama Keluarga</th>
                                      <th field="data_keluarga_status" width="50" editor="{type:'text'}">Status</th>
                                      <th field="data_keluarga_alamat" width="50" editor="{type:'text'}">Alamat</th>
                                  </thead>
                                </table>
                                <div id="toolbar7">
                                  <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="fun_tambah_data_keluarga()">New</a>
                                  <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="fun_hapus_data_keluarga()">Delete</a>
                                  <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="fun_simpan_data_keluarga()">Save</a>
                                  <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:$('#dg_data_keluarga').edatagrid('cancelRow')">Cancel</a>
                                </div>
                              </div>

                            </div>
                          </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                          <button type="button" id="close" class="btn btn-default" data-dismiss="modal" onclick="fun_close()">Close</button>
                          <button type="button" class="btn btn-success" id="simpan">Simpan</button>
                          <button type="button" class="btn btn-primary" id="edit" style="display: none">Edit</button>
                          <button class="btn btn-primary" type="button" id="loading_form_simpan" disabled style="display: none;">
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
                <div class="modal fade" id="modal_downloadCV">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title"><?= $judul ?></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <form id="form_modalDownloadCV">
                        <input type="hidden" id="download_user_id" name="download_user_id" value="">
                        <input type="hidden" id="download_cv_id" name="download_cv_id" value="">
                        <div class="modal-body">
                          <div class="card-body row">
                            <div class="col-12">
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">NIK</label>
                                <div class="input-group col-md-8">
                                  <input type="text" id="download_nik" name="download_nik" placeholder="" class="form-control" style="border:none">
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Nama Lengkap</label>
                                <div class="input-group col-md-8">
                                  <input type="text" id="download_user_nama" name="download_user_nama" placeholder="Nama Lengkap" class="form-control" style="border:none">
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Tempat Lahir</label>
                                <div class="input-group col-md-8">
                                  <input type="text" placeholder="Tempat Lahir" id="download_tempat_lahir" name="download_tempat_lahir" class="form-control" style="border:none">
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Tanggal Lahir</label>
                                <div class="input-group col-md-8">
                                  <input type="text" placeholder="Tanggal Lahir" id="download_tanggal_lahir" name="download_tanggal_lahir" class="form-control" style="border:none">
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Email</label>
                                <div class="input-group col-md-8">
                                  <input type="text" id="download_email" name="download_email" placeholder="" class="form-control" style="border:none">
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Alamat</label>
                                <div class="input-group col-md-8">
                                  <input type="text" id="download_alamat" name="download_alamat" placeholder="" class="form-control" style="border:none">
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Tanggal Masuk</label>
                                <div class="input-group col-md-8">
                                  <input type="text" placeholder="Tanggal Masuk" id="download_tanggal_masuk" name="download_tanggal_masuk" class="form-control" style="border:none">
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Masa Kerja</label>
                                <div class="input-group col-md-8">
                                  <input type="text" placeholder="" id="download_masa_kerja_tahun" name="download_masa_kerja_tahun" class="form-control" style="border:none">
                                </div>
                              </div>
                              <!-- <div class="form-group row col-md-12">
                                          <label class="col-md-4">Agama</label>
                                          <div class="input-group col-md-8">
                                            <select class="form-control select2">
                                            </select>
                                          </div>
                                        </div> -->
                              <hr>
                              <br>
                              <div class="col-lg-12 col-md-12">
                                <input type="checkbox" class="pilih_semua" onChange="func_pilih_semua()"> Pilih Semua
                              </div>
                              <div class="col-lg-12 col-md-12">
                                <table id="tbPendidikanFormal" class="table table-bordered  table-hover" width="100%">
                                  <strong> <input type="checkbox" id="pilih_cetak" class="pilih_cetak" name="cpf" value="cpf"> Riwayat Pendidikan Formal </strong>
                                  <thead>
                                    <tr>
                                      <th>Jenjang</th>
                                      <th>Jurusan</th>
                                      <th>Nama Instansi</th>
                                      <th>Tahun Lulus</th>

                                    </tr>
                                  </thead>
                                </table>
                              </div>
                              <br>

                              <div class="col-lg-12 col-md-12">
                                <table id="tbPendidikanNonFormal" class="table table-bordered  table-hover" width="100%">
                                  <strong> <input type="checkbox" id="pilih_cetak" class="pilih_cetak" name="cpnf" value="cpnf"> Riwayat Pendidikan Non Formal</strong>
                                  <thead>
                                    <tr>
                                      <th>Judul</th>
                                      <th>Nama Institusi</th>
                                      <th>Tahun Lulus</th>

                                    </tr>
                                  </thead>
                                </table>
                              </div>
                              <br>

                              <div class="col-lg-12 col-md-12">
                                <table id="tbRiwayatJabatan" class="table table-bordered  table-hover" width="100%">
                                  <strong> <input type="checkbox" id="pilih_cetak" class="pilih_cetak" name="crj" value="crj"> Riwayat Jabatan</strong>
                                  <thead>
                                    <tr>
                                      <th>Mulai</th>
                                      <th>Selesai</th>
                                      <th>Masa Kerja</th>
                                      <th>Unit Kerja</th>
                                      <th>Jabatan</th>

                                    </tr>
                                  </thead>
                                </table>
                              </div>
                              <br>
                              <div class="col-lg-12 col-md-12">
                                <table id="tbKompetensi" class="table table-bordered  table-hover" width="100%">
                                  <strong> <input type="checkbox" id="pilih_cetak" class="pilih_cetak" name="ck" value="ck"> Sertifikasi Kompetensi</strong>
                                  <thead>
                                    <tr>
                                      <th>Judul</th>
                                      <th>Nama Kompetensi</th>
                                      <th>Tahun Lulus</th>

                                    </tr>
                                  </thead>
                                </table>
                              </div>
                              <br>
                              <div class="col-lg-12 col-md-12">
                                <table id="tbPenugasanInternal" class="table table-bordered  table-hover" width="100%">
                                  <strong> <input type="checkbox" id="pilih_cetak" class="pilih_cetak" name="cpi" value="cpi"> Penugasan Internal</strong>
                                  <thead>
                                    <tr>
                                      <th>Tanggal Mulai</th>
                                      <th>Tanggal Selesai</th>
                                      <th>Penugasan Internal</th>
                                      <th>Memo</th>

                                    </tr>
                                  </thead>
                                </table>
                              </div>
                              <br>
                              <div class="col-lg-12 col-md-12">
                                <table id="tbRiwayatKerja" class="table table-bordered  table-hover" width="100%">
                                  <strong> <input type="checkbox" id="pilih_cetak" class="pilih_cetak" name="crk" value="crk"> Riwayat Pengalaman Kerja Sebelumnya</strong>
                                  <thead>
                                    <tr>
                                      <th>Tanggal Mulai</th>
                                      <th>Tanggal Selesai</th>
                                      <th>Instansi</th>
                                      <th>Jabatan</th>

                                    </tr>
                                  </thead>
                                </table>
                              </div>
                              <br>
                              <div class="col-lg-12 col-md-12">
                                <table id="tbDataKeluarga" class="table table-bordered  table-hover" width="100%">
                                  <strong> <input type="checkbox" id="pilih_cetak" class="pilih_cetak" name="cdk" value="cdk"> Data Keluarga</strong>
                                  <thead>
                                    <tr>
                                      <th>Nama Keluarga</th>
                                      <th>Status</th>
                                      <th>Alamat</th>
                                    </tr>
                                  </thead>
                                </table>
                              </div>
                              <br>
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                          <button type="button" id="close_cv" class="btn btn-default" data-dismiss="modal" onclick="fun_close()">Close</button>
                          <button type="button" class="btn btn-danger" id="cetak" onclick="func_cetakCV()">Cetak</button>
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