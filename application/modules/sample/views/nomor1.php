<?php $sesi = $this->session->userdata(); ?>
<style>
  .modal-body {
    max-height: calc(100vh - 210px);
    overflow-y: auto;
  }
</style>
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
          <h1>
            <?= $judul ?>
          </h1>
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
            <div class="card">
              <!-- Header -->
              <div class="card-header bg-warning">
                <h3 class="card-title">Filter
                  <?= $judul ?>
                </h3>
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
                      <label class="col-md-12">Status Sample</label>
                      <div class="input-group col-md-12">
                        <select class="form-control select2" name="status_cari" id="status_cari">
                          <option value="0">Belum Diproses</option>
                          <option value="-">Semua</option>
                          <option value="6">Clossed</option>
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
            <div class="card">
              <!-- Header -->
              <div class="card-header bg-success">
                <input type="text" name="role_id_cek" id="role_id_cek" value="<?= $sesi['role_id'] ?>" hidden>
                <!-- bantuan -->
                <input type="text" name="header_menu" id="header_menu" value="<?= $_GET['header_menu'] ?>" hidden>
                <input type="text" name="menu_id" id="menu_id" value="<?= $_GET['menu_id'] ?>" hidden>
                <!-- bantuan -->
                <h3 class="card-title">
                  <?= $judul ?>
                </h3>
                <button id="tambah" type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal" onclick="fun_tambah()">Tambah</button>

              </div>
              <!-- Header -->
              <!-- Body -->
              <div class="card-body">
                <!-- Table -->
                <table id="table" class="table table-bordered table-striped" width="100%">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Tanggal Pengajuan</th>
                      <th>Petugas</th>
                      <th>Status</th>
                      <th>Detail</th>
                      <th>Edit</th>
                      <th>Proses</th>
                    </tr>
                  </thead>
                </table>
                <!-- Table -->
                <!-- Modal -->
                <div class="modal fade" id="modal" data-keyboard="false" data-backdrop="static">
                  <div class="modal-dialog modal-xl modal-dialog-scrollable">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">
                          <?= $judul ?>
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <form id="form_modal">
                        <input type="text" id="transaksi_rutin_id" name="transaksi_rutin_id" value="" style="display: none;">
                        <div class="modal-body">
                          <div class="card-body row">
                            <div class="col-12">
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Peminta Jasa</label>
                                <div class="input-group col-md-8">
                                  <select class="form-control select2" id="peminta_jasa_id" name="peminta_jasa_id">
                                  </select>
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Jenis Sample</label>
                                <div class="input-group col-md-8">
                                  <select class="form-control select2" id="jenis_id" name="jenis_id">
                                  </select>
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Jenis Pekerjaan</label>
                                <div class="input-group col-md-8">
                                  <select class="form-control select2" id="jenis_pekerjaan_id" name="jenis_pekerjaan_id">
                                  </select>
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Jumlah Sample</label>
                                <div class="input-group col-md-8">
                                  <input type="number" class="form-control" id="jumlah_sample" name="jumlah_sample" value="" placeholder="Jumlah Sample">
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Parameter</label>
                                <div class="input-group col-md-8">
                                  <input type="number" class="form-control" id="parameter" name="parameter" value="" placeholder="Parameter">
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-10">&nbsp;</label>
                                <button type="button" class="btn btn-primary col-md-2" id="proses">Proses</button>
                                <button class="btn btn-primary" type="button" id="loading_form" disabled style="display: none;">
                                  <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                  Loading...
                                </button>
                              </div>
                              <hr>
                              <div class="form-group row col-md-12">
                                <table id="dg" title="Sample" style="width:100%" toolbar="#toolbar" pagination="true" idField="id" rownumbers="true" fitColumns="true" singleSelect="true">
                                  <thead>
                                    <tr>
                                      <th field="transaksi_detail_tgl_pengajuan_baru" width="50" editor="{type:'label'}">Tanggal</th>
                                      <!-- <th field="peminta_jasa_nama" width="50" editor="{type:'label'}">Peminta Jasa</th> -->
                                      <th data-options="formatter:function(value,row,index){return row.peminta_jasa_nama}" field="peminta_jasa_id" width="70" editor="{type:'combobox',
                                      options:{
                                        idField: 'peminta_jasa_id',
                                        textField: 'peminta_jasa_nama',
                                        valueField: 'peminta_jasa_id',
                                        url: '<?= base_url() ?>master/peminta_jasa/getPemintaJasa',
                                        mode: 'remote',
                                        fitColumns:true,
                                        columns: [[
                                        {field:'peminta_jasa_nama',title:'Peminta Jasa',width:400},
                                        ]],
                                        panelHeight:135}}">Peminta Jasa</th>
                                        <!-- <th field="jenis_nama" width="50" editor="{type:'label'}">Jenis Sample</th> -->
                                        <th data-options="formatter:function(value,row,index){return row.jenis_nama}" field="jenis_id" width="70" editor="{type:'combobox',
                                        options:{
                                          idField: 'jenis_id',
                                          textField: 'jenis_nama',
                                          valueField: 'jenis_id',
                                          url: '<?= base_url() ?>master/jenis_sample_uji/getJenisSampleUji',
                                          mode: 'remote',
                                          fitColumns:true,
                                          columns: [[
                                          {field:'jenis_nama',title:'Jenis Sample',width:400},
                                          ]],
                                          panelHeight:135}}">Jenis Sample</th>
                                          <!-- <th field="sample_pekerjaan_nama" width="50" editor="{type:'label'}">Jenis Pekerjaan</th> -->
                                          <th data-options="formatter:function(value,row,index){return row.sample_pekerjaan_nama}" field="jenis_pekerjaan_id" width="70" editor="{type:'combobox',
                                          options:{
                                            idField: 'sample_pekerjaan_id',
                                            textField: 'sample_pekerjaan_nama',
                                            valueField: 'sample_pekerjaan_id',
                                            url: '<?= base_url() ?>master/jenis_pekerjaan/getJenisPekerjaan',
                                            mode: 'remote',
                                            fitColumns:true,
                                            columns: [[
                                            {field:'sample_pekerjaan_nama',title:'Jenis Pekerjaan',width:400},
                                            ]],
                                            panelHeight:135}}">Jenis Pekerjaan</th>

                                            <th data-options="formatter:function(value,row,index){return row.identitas_nama}" field="identitas_id" width="150" editor="{type:'combobox',
                                            options:{
                                              idField: 'identitas_id',
                                              textField: 'identitas_nama',
                                              valueField: 'identitas_id',
                                              url: '<?= base_url() ?>master/jenis_sample_uji/getSampleIdentitas',
                                              mode: 'remote',
                                              fitColumns:true,
                                              onSelect: function (isi, value){
                                                console.log(isi);
                                                console.log(value);
                                                setTimeout(function(){
                                                  var row = $('#dg').datagrid('getSelected');
                                                  rowIndex = $('#dg').datagrid('getRowIndex',row);
                                                  rows = $('#dg').datagrid('getRows');
                                                  var ed = $('#dg').datagrid('getEditor', {index:rowIndex,field:'transaksi_detail_parameter'});
                                                  var text = $(ed.target).numberspinner('setValue', isi.identitas_parameter);
                                                },0);
                                              },
                                              columns: [[
                                              {field:'identitas_nama',title:'Identitas',width:400},
                                              ]],
                                              panelHeight:135}}">Identitas</th>Jenis
                                              <th field="transaksi_detail_parameter" width="40" editor="{type:'numberspinner',options:{required:true,max:25}}">Parameter</th>
                                              <th field="transaksi_detail_note" width="70" editor="{type:'text'}">Note</th>
                                            </tr>
                                          </thead>
                                        </table>
                                        <div id="toolbar" align="right">
                                          <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="fun_hapus()">Delete</a>
                                          <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="fun_simpan()">Save</a>
                                          <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:$('#dg').edatagrid('cancelRow')">Cancel</a>
                                        </div>
                                        <span><strong>NB: <br />1. Data hanya bisa disimpan satu per satu, pastikan klik save
                                          setelah menginput sebuah data terlebih dahulu agar data yang anda inputkan tidak
                                        hilang</strong> <span>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-secondary" id="close" class="btn btn-default" data-dismiss="modal" onclick="fun_close()">Close</button>
                                    <button type="button" class="btn btn-secondary" id="close_edit" class="btn btn-default" data-dismiss="modal" onclick="fun_close_edit()" style="display:none">Close</button>
                                    <button type="button" class="btn btn-success" id="simpan" onclick="fun_close_simpan()">Simpan</button>
                                    <button type="button" class="btn btn-primary" id="edit" style="display: none;" onclick="fun_close_simpan()">Edit</button>
                                  </div>
                                </form>
                              </div>
                              <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                          </div>
                          <!-- Modal -->
                          <!-- Modal -->
                          <div class="modal fade" id="modal_proses">
                            <div class="modal-dialog modal-lg">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h4 class="modal-title">
                                    <?= $judul ?>
                                  </h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <form id="form_modal_detail">
                                  <!-- <input type="text" id="id_transaksi_rutin" name="id_transaksi_rutin" value="" style="display: none;"> -->
                                  <!-- <input type="text" id="id_transaksi" name="id_transaksi" value="" style="display: none;"> -->
                                  <div class="modal-body">
                                    <div class="card-body row">
                                      <div class="col-12">
                                        <div class="form-group row col-md-12">
                                          <label class="col-md-4">File</label>
                                          <div class="input-group col-md-8">
                                            <input type="file" class="form-control" id="transaksi_detail_file" name="transaksi_detail_file" value="" placeholder="" accept="application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-powerpoint, application/vnd.openxmlformats-officedocument.presentationml.presentation, text/plain, application/pdf, image/jpeg,image/png,image/gif,image/bmp">
                                          </div>
                                        </div>
                                        <div class="form-group row col-md-12">
                                          <label class="col-md-4">Nomor Surat</label>
                                          <div class="input-group col-md-8">
                                            <input type="number" class="form-control" id="transaksi_detail_no_surat" name="transaksi_detail_no_surat" value="" placeholder="Nomor Surat">
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="modal-footer justify-content-between">
                                    <button type="button" id="close_detail" class="btn btn-default" data-dismiss="modal" onclick="fun_close_detail()">Close</button>
                                    <button type="button" class="btn btn-success" id="clossed" onclick="fun_clossed()">Clossed</button>
                                    <button class="btn btn-primary" type="button" id="loading_form_detail" disabled style="display: none;">
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
                          <div class="modal fade" id="modal2">
                            <div class="modal-dialog modal-lg">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h4 class="modal-title">
                                    <?= $judul ?>
                                  </h4>
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
                                    <button type="button" id="close" class="btn btn-default" data-dismiss="modal">Close</button>
                                  </div>
                                </form>
                              </div>
                              <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                          </div>
                          <!-- Modal -->
                          <!-- Modal -->
                          <div class="modal fade" id="modal_cara_close">
                            <div class="modal-dialog modal-lg">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h4 class="modal-title">
                                    <?= $judul ?>
                                  </h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <form id="form_modal_cara_close">
                                  <!-- <input type="hidden" id="jadwal_id" name="jadwal_id" value=""> -->
                                  <input type="text" id="status_transaksi" name="status_transaksi" value="" style="display:block;">
                                  <input type="text" id="id_transaksi_rutin" name="id_transaksi_rutin" value="" style="display:block;">
                                  <input type="text" id="id_transaksi" name="id_transaksi" value="" style="display:block;">
                                  <input type="text" id="is_multiple" name="is_multiple" style="display:block;">
                                  <div class="modal-body">
                                    <div class="form-group row col-md-12">
                                      <label class="col-md-4">Pilih Cara Close</label>
                                      <div class="input-group col-md-8">
                                        <input type="text" id="cara_close_kode" name="cara_close_kode" style="display:block;">
                                        <select name="cara_close_nama" id="cara_close_nama" class="form-control select2" style="width:100%" onChange="fun_ganti_kode_close(this.value);">
                                        </select>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="modal-footer justify-content-between">
                                    <button type="button" id="close_cara_close" class="btn btn-default" data-dismiss="modal" onclick="fun_close_cara_close()">Close</button>
                                    <button type="button" class="btn btn-success" id="simpan_cara_close" style="display:none">Proses</button>
                                    <button type="button" class="btn btn-success" id="simpan_cara_close_multiple" style="display:none">Proses</button>
                                    <button class="btn btn-primary" type="button" id="loading_cara_close" disabled style="display: none;">
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
                        </div>
                        <!-- Body -->
                      </div>
                    </div>
                  </div>
                  <!-- DIV DATA DIRI -->
                  <!-- DIV DATA DIRI -->
                  <div class="col-md-12" id="div_detail" style="display: none;">
                    <div class="col-md-12">
                      <div class="card">
                        <!-- Header -->
                        <div class="card-header bg-primary">
                          <h3 class="card-title">Detail
                            <?= $judul ?>
                          </h3>
                        </div>
                        <!-- Header -->
                        <!-- Body -->
                        <div class="card-body">
                          <!-- Table -->
                          <table id="table_detail" class="table table-bordered table-striped" width="100%">
                            <thead>
                              <tr>
                                <th>Nomor Sample</th>
                                <th>Jenis Sample</th>
                                <th>Jenis Pekerjaan</th>
                                <th>Identitas</th>
                                <th>Note</th>
                                <th>Lihat Document</th>
                                <th>Qrcode</th>
                                <th>Proses</th>
                                <?php
                      // if ($sesi['role_id'] == '1') :
                                ?>
                                <th>Hapus</th>
                                <?php
                      // endif;
                                ?>

                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>0001</td>
                                <td>Clay</td>
                                <td>Sampling</td>
                                <td>
                                  <center><a href="#" target="_BLANK" id="" title="Edit" data-toggle="modal" data-target="#modal2"><i class="fa fa-file"></i></a></center>
                                </td>
                                <td>
                                  <center><a href="<?= base_url('sample/notifikasi/print_qrcode/') ?>" target="_BLANK" id="" title="Edit"><i class="fa fa-qrcode"></i></a></center>
                                </td>
                                <td>
                                  <center><a href="javascript:;" id="'+full.request_id+'" title="Edit" onclick="fun_tambah(this.id)"><i class="fa fa-share" data-toggle="modal" data-target="#modal"></i></a></center>
                                </td>
                              </tr>
                            </tbody>
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