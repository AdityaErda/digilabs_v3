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
        <div class="col-md-12">
          <div class="col-md-12">
            <div class="card">
              <!-- Header -->
              <div class="card-header bg-warning">
                <h3 class="card-title">Filter <?= $judul ?></h3>
              </div>
              <!-- Header -->
              <!-- Body -->
              <form id="filter">
                <div class="card-body">
                  <div class="row">
                    <div class="form-group col-md-3">
                      <label class="col-md-12">Periode Awal</label>
                      <div class='input-group date' id="tanggal_cari_awal">
                        <input name="tanggal_cari_awal" id="tanggal_cari_awal" class="datetimepicker" type="text" inputmode="none" class="form-control" required="" value="<?= date('Y-m-d') ?>" />
                        <span class="input-group-text">
                          <span class="fa fa-calendar"></span>
                        </span>
                      </div>
                    </div>
                    <div class="form-group col-md-3">
                      <label class="col-md-12">Periode Akhir</label>
                      <div class='input-group date' id="tanggal_cari_akhir">
                        <input name="tanggal_cari_akhir" id="tanggal_cari_akhir" class="datetimepicker" type="text" inputmode="none" class="form-control" required="" value="<?= date('Y-m-d') ?>" />
                        <span class="input-group-text">
                          <span class="fa fa-calendar"></span>
                        </span>
                      </div>
                    </div>
                    <div class="form-group col-md-4">
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
                <h3 class="card-title"><?= $judul ?></h3>
                <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal" onclick="fun_tambah()">Tambah</button>
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
                      <th>Peminta Jasa</th>
                      <!-- <th>Jenis Sample</th> -->
                      <th>Jenis Pekerjaan</th>
                      <!-- <th>Tanggal Memo</th> -->
                      <!-- <th>Nomor Memo</th> -->
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                </table>
                <!-- Table -->
                <!-- Modal -->
                <div class="modal fade" id="modal">
                  <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title"><?= $judul ?></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <form id="form_modal">
                        <input type="text" id="is_new" name="is_new" style="display:none">
                        <input type="text" id="transaksi_non_rutin_id" name="transaksi_non_rutin_id" style="display:none">
                        <input type="text" id="transaksi_id" name="transaksi_id" value="" style="display: none;">
                        <input type="text" id="transaksi_detail_id" name="transaksi_detail_id" value="" style="display: none;">
                        <!-- <input type="text" id="transaksi_tipe" name="transaksi_tipe" value="<?= $tipe ?>" style="display: none;"> -->
                        <div class="modal-body">
                          <div class="card-body row">
                            <!-- Kiri -->
                            <div class="col-6">
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Peminta Jasa*</label>
                                <div class="input-group col-md-8">
                                  <select class="form-control select2" id="peminta_jasa_id" name="peminta_jasa_id">
                                  </select>
                                </div>
                              </div>
                              <!-- <div class="form-group row col-md-12">
                                <label class="col-md-4">Jenis Sample*</label>
                                <div class="input-group col-md-8">
                                  <select class="form-control select2" id="jenis_id" name="jenis_id">
                                  </select>
                                </div>
                              </div> -->
                              <!-- <div class="form-group row col-md-12">
                                <label class="col-md-4">Jumlah Sample*</label>
                                <div class="input-group col-md-8">
                                  <input type="text" class="form-control" id="transaksi_detail_jumlah" name="transaksi_detail_jumlah" value="" placeholder="Jumlah Sample" onkeypress="return numberWithComma(event)">
                                </div>
                              </div> -->
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Jenis Pekerjaan*</label>
                                <div class="input-group col-md-8">
                                  <select class="form-control select2" id="jenis_pekerjaan_id" name="jenis_pekerjaan_id">
                                  </select>
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">PIC Pengirim Sample</label>
                                <div class="input-group col-md-8">
                                  <input type="text" class="form-control" id="transaksi_detail_pic_pengirim" name="transaksi_detail_pic_pengirim" value="" placeholder="PIC Pengirim Sample">
                                </div>
                              </div>
                            </div>
                            <!-- Kiri -->
                            <!-- Kanan -->
                            <div class="col-6">
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Ext Pengirim Sample*</label>
                                <div class="input-group col-md-8">
                                  <input type="number" class="form-control" id="transaksi_detail_ext_pengirim" name="transaksi_detail_ext_pengirim" value="" placeholder="Ext Pengirim Sample">
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Tgl Pengajuan</label>
                                <div class="input-group col-md-8">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text">
                                      <i class="far fa-calendar-alt"></i>
                                    </span>
                                  </div>
                                  <input type="text" class="form-control float-right" id="transaksi_detail_tgl_pengajuan" name="transaksi_detail_tgl_pengajuan" value="<?= date('d-m-Y H:i:s') ?>" readonly>
                                </div>
                              </div>
                              <!-- <div class="form-group row col-md-12">
                                <label class="col-md-4">Tgl Memo*</label>
                                <div class="input-group col-md-8">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text">
                                      <i class="far fa-calendar-alt"></i>
                                    </span>
                                  </div>
                                  <input type="text" class="form-control float-right tanggal" id="transaksi_detail_tgl_memo" name="transaksi_detail_tgl_memo" value="">
                                </div>
                              </div> -->
                              <!-- <div class="form-group row col-md-12">
                                <label class="col-md-4">Nomor Memo*</label>
                                <div class="input-group col-md-8">
                                  <input type="number" class="form-control" id="transaksi_detail_no_memo" name="transaksi_detail_no_memo" value="" placeholder="Nomor Memo">
                                </div>
                              </div> -->
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Kode Klasifikasi*</label>
                                <div class="input-group col-md-8">
                                  <select name="transaksi_klasifikasi_id" id="transaksi_klasifikasi_id" class="select2 form-control"></select>
                                </div>
                              </div>
                              <!-- <div class="form-group row col-md-12">
                                <label class="col-md-4">Identitas*</label>
                                <div class="input-group col-md-8">
                                  <select class="form-control select2" id="identitas_id" name="identitas_id">
                                  </select>
                                </div>
                                <p style="color: red;padding-left: 7px;margin-top: 10px;margin-bottom: 0px;">* jika identitas tidak ada silahkan pilih sesuai jenis sample & tuliskan identitas sample anda di NOTE</p>
                              </div> -->
                              <!-- <div class="form-group row col-md-12">
                                <label class="col-md-4">Parameter*</label>
                                <div class="input-group col-md-8">
                                  <input type="number" class="form-control" id="transaksi_detail_parameter" name="transaksi_detail_parameter" value="" placeholder="Parameter">
                                </div>
                              </div> -->
                              <!-- <div class="form-group row col-md-12">
                                <label class="col-md-4">Note</label>
                                <div class="input-group col-md-8">
                                  <input type="text" class="form-control" id="transaksi_detail_note" name="transaksi_detail_note" value="" placeholder="Note" maxlength="25">
                                </div>
                              </div> -->
                              <!-- <div class="form-group row col-md-12">
                                <label class="col-md-4">Foto Sample*</label>
                                <div class="input-group col-md-8">
                                  <input type="file" class="form-control" id="transaksi_detail_foto" name="transaksi_detail_foto" value="" placeholder="" accept="image/*">
                                  <input type="text" class="form-control" id="temp_transaksi_detail_foto" name="temp_transaksi_detail_foto" value="" placeholder="Note" style="display: none;">
                                </div>
                              </div> -->
                              <div class="form-group row col-md-12" id="div_transaksi_detail_foto_sebelumnya" style="display: none;">
                                <table width="100%">
                                  <tr>
                                    <td width="40%"><label>Foto Sebelumnya</label></td>
                                    <td width="60%"><img required src="" alt="" style="width: 100px" id="transaksi_detail_foto_sebelumnya"></td>
                                  </tr>
                                </table>
                              </div>
                            </div>
                            <!-- Kanan -->
                          </div>
                          <!-- easy ui -->
                          <div class="form-group row col-md-12">
                            <table id="dg_sample" title="Sample" style="width:100%" toolbar="#toolbar" pagination="true" idField="id" rownumbers="true" fitColumns="true" singleSelect="true">
                              <thead>
                                <tr>
                                  <th data-options="formatter:function(value,row,index){return row.jenis_nama}" field="jenis_id" width="150" editor="{type:'combobox',
                                                options:{
                                                  idField: 'jenis_id',
                                                  textField: 'jenis_nama',
                                                  valueField: 'jenis_id',
                                                  url: '<?= base_url() ?>master/jenis_sample_uji/getJenisSampleUji',
                                                  mode: 'remote',
                                                  fitColumns:true,
                                                  onSelect: function (value){
                                                      var row = $('#dg_sample').datagrid('getSelected');
                                                      var rowIndex = $('#dg_sample').datagrid('getRowIndex',row);
                                                      var url = '<?= base_url() ?>master/jenis_sample_uji/getSampleIdentitas?jenis_id='+value.jenis_id;
                                                      var ed = $('#dg_sample').edatagrid('getEditor', {index:rowIndex,field:'identitas_id'});
                                                      (ed.target).combobox('reload',url);
                                                    },
                                                  columns: [[
                                                    {field:'jenis_nama',title:'Jenis Sample',width:300},
                                                  ]],
                                                panelHeight:135}}">Jenis Sample</th>
                                  <th field="transaksi_detail_jumlah" width="40" editor="{type:'numberspinner',options:{required:true,max:25}}">Jumlah</th>
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
                                                    var row = $('#dg_sample').datagrid('getSelected');
                                                    rowIndex = $('#dg_sample').datagrid('getRowIndex',row);
                                                    rows = $('#dg_sample').datagrid('getRows');
                                                    var ed = $('#dg_sample').datagrid('getEditor', {index:rowIndex,field:'transaksi_detail_parameter'});
                                                    var text = $(ed.target).numberspinner('setValue', isi.identitas_parameter);
                                                    },0);
                                                  },
                                                  columns: [[
                                                    {field:'identitas_nama',title:'Identitas',width:300},
                                                  ]],
                                                panelHeight:135}}">Identitas</th>
                                  <th field="transaksi_detail_parameter" width="40" editor="{type:'numberspinner'}">Parameter</th>
                                  <th field="transaksi_detail_foto" width="40" editor="{type:'text'}">Foto</th>
                                </tr>
                              </thead>
                            </table>
                            <div id="toolbar">
                              <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="easyuiNewSample()">New</a>
                              <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="easyuiDeleteSample()">Delete</a>
                              <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="easyuiSaveSample()">Save</a>
                              <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:$('#dg_sample').edatagrid('cancelRow')">Cancel</a>
                              <!-- <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-reload" plain="true" onclick="fun_reload_request()">Reload</a> -->

                            </div>
                            <span><strong>NB: <br />1. Data hanya bisa disimpan satu per satu, pastikan klik save setelah menginput sebuah data terlebih dahulu agar data yang anda inputkan tidak hilang</strong> <span>
                          </div>
                          <!-- easy ui -->
                        </div>
                        <div class="modal-footer justify-content-between">
                          <button type="button" id="close" class="btn btn-default" data-dismiss="modal" onclick="fun_close()">Close</button>
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
                <!-- Modal Detail -->
                <div class="modal fade" id="modal_detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <table id="table_detail" class="table table-bordered table-striped " width="100%">
                          <thead>
                            <tr>
                              <th>Jenis Sample</th>
                              <th>Jumlah Sample</th>
                              <!-- <th>Jenis Sample</th> -->
                              <th>Identitas Sample</th>
                              <th>Keterangan</th>
                              <th>Parameter Sample</th>
                              <th>Foto Sample</th>
                            </tr>
                          </thead>
                        </table>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Modal Detail -->
                <!-- Modal Lihat -->
                <div class="modal fade" id="modal_lihat">
                  <div class="modal-dialog">
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
                          <button type="button" id="close" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                      </form>
                    </div>
                    <!-- Modal Lihat -->
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