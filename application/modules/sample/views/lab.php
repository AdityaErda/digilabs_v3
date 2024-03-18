  <style type="text/css">
    /* Important part */
    .modal-content {
      overflow: scroll !important;
    }

    .dataTables_scrollHead {
      overflow: auto !important;
      /*    width: 100%;*/
    }

  </style>
  <!--CONTAINER -->
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
                        <label class="col-md-12">Tipe Sample</label>
                        <select class="form-control select2" id="trnsaksi_tipe_cari" name="transaksi_tipe_cari">
                          <option value="-">Semua Tipe</option>
                          <option value="I">Sample Internal</option>
                          <option value="E">Sample Eksternal</option>
                        </select>
                      </div>
                      <div class="form-group col-md-3">
                        <label class="col-md-12">Periode Awal</label>
                        <div class='input-group date' id="tanggal_cari_awal">
                          <input name="tanggal_cari_awal" id="tanggal_cari_awal" class="datetimepicker form-control" type="text" inputmode="none" class="form-control" required="" value="<?= date('Y-m-d') ?>" />
                          <span class="input-group-text">
                            <span class="fa fa-calendar"></span>
                          </span>
                        </div>
                      </div>
                      <div class="form-group col-md-3">
                        <label class="col-md-12">Periode Akhir</label>
                        <div class='input-group date' id="tanggal_cari_akhir">
                          <input name="tanggal_cari_akhir" id="tanggal_cari_akhir" class="datetimepicker form-control" type="text" inputmode="none" class="form-control" required="" value="<?= date('Y-m-d') ?>" />
                          <span class="input-group-text">
                            <span class="fa fa-calendar"></span>
                          </span>
                        </div>
                      </div>
                      <div class="form-group col-md-3">
                        <label class="col-md-12">&nbsp;</label>
                        <input type="submit" class="btn btn-success pull-right btn-block" id="cari" value="cari">
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
                  <!--       <a href="<?= base_url('sample/request/addRequest?tipe=') . $_GET['tipe'] . '&header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id'] ?>" class="btn btn-primary float-right">Tambah</a> -->
                  <input type="text" name="user_id" id="user_id" value="<?= $session['user_id'] ?>" style="display: none;">
                  <input type="text" name="user_unit_id" id="user_unit_id" value="<?= $session['user_unit_id'] ?>" style="display:none">
                  <input type="text" name="user_poscode" id="user_poscode" value="<?= $session['user_poscode'] ?>" style="display:none">

                </div>
                <!-- Header -->
                <!-- Body -->
                <div class="card-body">
                  <!-- Table -->
                  <table id="table" class="table table-bordered table-striped" width="100%">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Nomor Surat</th>
                        <th>Tipe Sample</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Peminta Jasa</th>
                        <!-- <th>Jenis Sample</th> -->
                        <th>Judul Pekerjaan</th>
                        <!-- <th>Tanggal Memo</th> -->
                        <!-- <th>Nomor Memo</th> -->
                        <th>Status</th>
                        <th>Proses</th>
                        <!-- <th>Edit</th> -->
                        <!-- <th>Hapus</th> -->
                        <th>Aksi</th>
                      </tr>
                    </thead>
                  </table>
                  <!-- Table -->
                  <!-- Modal -->
                  <div class="modal fade" id="modal">
                    <div class="modal-dialog modal-xl modal-dialog-scrollable">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title"><?= $judul ?></h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form id="form_modal">
                          <input type="text" id="is_new" name="is_new" style="display:none">
                          <input type="text" name="transaksi_status" id="transaksi_status" value="$_GET['status']" readonly="">
                          <input type="text" id="transaksi_non_rutin_id" name="transaksi_non_rutin_id" style="display:none">
                          <input type="text" id="transaksi_id" name="transaksi_id" value="" style="display: none;">
                          <input type="text" id="transaksi_detail_id" name="transaksi_detail_id" value="" style="display: none;">
                          <!-- <input type="text" id="transaksi_tipe" name="transaksi_tipe" value="<?= $tipe ?>" style="display: none;"> -->
                          <div class="modal-body">
                            <div class="card-body row">
                              <!-- Kiri -->
                              <div class="col-6">
                                <div class="form-group row col-md-12">
                                  <label class="col-md-4">Judul *</label>
                                  <div class="input-group col-md-8">
                                    <input type="text" class="form-control required" id="transaksi_judul" name="transaksi_judul" placeholder="Judul" value="">
                                  </div>
                                </div>
                                <div class="form-group row col-md-12">
                                  <label class="col-md-4">Peminta Jasa*</label>
                                  <div class="input-group col-md-8">
                                    <select class="form-control select2 required" id="peminta_jasa_id" name="peminta_jasa_id">
                                    </select>
                                  </div>
                                </div>
                                <div class="form-group row col-md-12">
                                  <label class="col-md-4">PIC Pengirim Sample</label>
                                  <div class="input-group col-md-8">
                                    <!-- <input type="text" class="form-control" id="transaksi_detail_pic_pengirim" name="transaksi_detail_pic_pengirim" placeholder="PIC Pengirim Sample" value="<?= $session['user_nama'] ?>"> -->
                                    <select name="transaksi_detail_pic_pengirim" id="transaksi_detail_pic_pengirim" class="select2 form-control"></select>
                                  </div>
                                </div>
                                <div class="form-group row col-md-12">
                                  <label class="col-md-4">PIC Telepon</label>
                                  <div class="input-group col-md-8">
                                    <input type="text" class="form-control" id="transaksi_detail_pic_telepon" name="transaksi_detail_pic_telepon" value="<?= $session['user_no_hp'] ?>" placeholder="Telp PIC">
                                  </div>
                                </div>
                                <div class="form-group row col-md-12">
                                  <label class="col-md-4">Keterangan</label>
                                  <div class="input-group col-md-8">
                                    <input type="text" id="template_id" name="template_id" style="display:none">
                                    <input type="text" id="template_jenis" name="template_jenis" style="display:none">
                                    <select class="form-control select2" id="template_keterangan_id" name="template_keterangan_id"></select>
                                  </div>
                                  <!-- <div class="input-group col-md-2">
                                  <button class="btn btn-warning" type="button" onclick="cetak_keterangan($('#template_id').val(),$('#template_jenis').val())"><i class="fa fa-print"></i></button>
                                </div> -->
                              </div>
                            </div>
                            <!-- Kiri -->
                            <!-- Kanan -->
                            <div class="col-6">
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Ext Pengirim Sample *</label>
                                <div class="input-group col-md-8">
                                  <input type="number" class="form-control required" id="transaksi_detail_ext_pengirim" name="transaksi_detail_ext_pengirim" value="" placeholder="Ext Pengirim Sample">
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Kode Klasifikasi *</label>
                                <div class="input-group col-md-8">
                                  <select name="transaksi_klasifikasi_id" id="transaksi_klasifikasi_id" class="select2 form-control required"></select>
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Sifat *</label>
                                <div class="input-group col-md-8">
                                  <select name="transaksi_sifat" id="transaksi_sifat" class="select2 form-control required">
                                    <option value="1">Rahasia</option>
                                    <option value="0">Biasa</option>
                                  </select>
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Kecepatan Tanggapan *</label>
                                <div class="input-group col-md-8">
                                  <select name="transaksi_kecepatan_tanggap" id="transaksi_kecepatan_tanggap" class="select2 form-control required">
                                    <option value="1">Biasa</option>
                                    <option value="2">Segera</option>
                                    <option value="3">Sangat Segera</option>
                                  </select>
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Reviewer *</label>
                                <div class="input-group col-md-8">
                                  <select name="transaksi_reviewer" id="transaksi_reviewer" class="select2 form-control required"></select>
                                </div>
                              </div>
                              <div class=" form-group row col-md-12">
                                <label class="col-md-4">Approver *</label>
                                <div class="input-group col-md-8">
                                  <select name="transaksi_approver" id="transaksi_approver" class="select2 form-control required"></select>
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Drafter</label>
                                <div class="input-group col-md-8">
                                  <input readonly type="text" name="transaksi_drafter_id" id="transaksi_drafter_id" class="form-control" value="<?= $session['user_nik_sap'] ?>">
                                  <!-- <input readonly type="text" name="transaksi_drafter" id="transaksi_drafter" class="form-control"> -->
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Tujuan</label>
                                <div class="input-group col-md-8">
                                  <input readonly type="text" name="transaksi_tujuan_id" id="transaksi_tujuan_id" class="form-control" value="<?= $vp_ppk['user_nik_sap'] ?>">
                                  <!-- <input readonly type="text" name="transaksi_tujuan" id="transaksi_tujuan" class="form-control"> -->
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Attach</label>
                                <div class="input-group col-md-8">
                                  <input type="file" name="transaksi_attach" id="transaksi_attach" class="form-control">
                                </div>
                              </div>
                              <div class="form-group row col-md-12" id="div_attach_lama" style="display: none;">
                                <table width="100%">
                                  <tr>
                                    <td width="40%"><label>Attach Sebelumnya</label></td>
                                    <td width="60%">
                                      <div id="transaksi_attach_lama" name="transaksi_attach_lama"></div>
                                    </td>
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
                                <button type="button" class="btn btn-info" id="draft">Draft</button>
                                <button type="button" class="btn btn-primary" id="edit" style="display: none">Edit</button>
                                <button type="button" class="btn btn-success" id="simpan">Ajukan</button>
                                <button type="button" class="btn btn-success" id="simpan_ajukan" style="display:none">Ajukan</button>
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
                      <div class="modal fade" id="modal_review">
                        <div class="modal-dialog modal-xl modal-dialog-scrollable">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title"><?= $judul ?></h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <form id="form_modal_review">
                              <input type="text" id="is_new_review" name="is_new" style="display:none">
                              <input type="text" id="transaksi_non_rutin_id_review" name="transaksi_non_rutin_id" style="display:none">
                              <input type="text" id="transaksi_id" name="transaksi_id_review" value="" style="display: none;">
                              <input type="text" id="transaksi_detail_id" name="transaksi_detail_id_review" value="" style="display: none;">
                              <input type="text" id="transaksi_tipe" name="transaksi_tipe_review" value="<?= $tipe ?>" style="display: none;">
                              <div class="modal-body">
                                <div class="card-body row">
                                  <!-- Kiri -->
                                  <div class="col-6">
                                    <div class="form-group row col-md-12">
                                      <label class="col-md-4">Judul *</label>
                                      <div class="input-group col-md-8">
                                        <input type="text" class="form-control" id="transaksi_judul_review" name="transaksi_judul_review" placeholder="Judul" readonly>
                                      </div>
                                    </div>
                                    <div class="form-group row col-md-12">
                                      <label class="col-md-4">Peminta Jasa*</label>
                                      <div class="input-group col-md-8">
                                        <input type="text" class="form-control" id="peminta_jasa_id_review" name="peminta_jasa_id_review" placeholder="Peminta Jasa" readonly>
                                      </div>
                                    </div>
                                    <div class="form-group row col-md-12">
                                      <label class="col-md-4">PIC Pengirim Sample</label>
                                      <div class="input-group col-md-8">
                                        <input type="text" class="form-control" id="transaksi_detail_pic_pengirim_review" name="transaksi_detail_pic_pengirim_review" placeholder="PIC Pengirim Sample">
                                      </div>
                                    </div>
                                    <div class="form-group row col-md-12">
                                      <label class="col-md-4">PIC Telepon</label>
                                      <div class="input-group col-md-8">
                                        <input type="text" class="form-control" id="transaksi_detail_pic_telepon_review" name="transaksi_detail_pic_telepon_review" placeholder="Telp PIC">
                                      </div>
                                    </div>
                                    <div class="form-group row col-md-12">
                                      <label class="col-md-4">Keterangan</label>
                                      <div class="input-group col-md-8">
                                        <input type="text" id="template_id_review" name="template_id_review" style="display:none">
                                        <input type="text" id="template_jenis_review" name="template_jenis_review" style="display:none">
                                        <input type="text" id="template_keterangan_id_review" name="te">
                                      </div>
                                    </div>
                                  </div>
                                  <!-- Kiri -->
                                  <!-- Kanan -->
                                  <div class="col-6">
                                    <div class="form-group row col-md-12">
                                      <label class="col-md-4">Ext Pengirim Sample *</label>
                                      <div class="input-group col-md-8">
                                        <input type="text" class="form-control required" id="transaksi_detail_ext_pengirim_review" name="transaksi_detail_ext_pengirim_review" value="" placeholder="Ext Pengirim Sample">
                                      </div>
                                    </div>
                                    <div class="form-group row col-md-12">
                                      <label class="col-md-4">Kode Klasifikasi *</label>
                                      <div class="input-group col-md-8">
                                        <!-- <select name="transaksi_klasifikasi_id" id="transaksi_klasifikasi_id" class="select2 form-control required"></select> -->
                                        <input type="text" class="form_control" id="transaksi_klasifikasi_id_review" name="transaksi_klasifikasi_id_review">
                                      </div>
                                    </div>
                                    <div class="form-group row col-md-12">
                                      <label class="col-md-4">Sifat *</label>
                                      <div class="input-group col-md-8">
                                    <!-- <select name="transaksi_sifat" id="transaksi_sifat" class="select2 form-control required">
                                    <option value="1">Rahasia</option>
                                    <option value="0">Biasa</option>
                                  </select> -->
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Kecepatan Tanggapan *</label>
                                <div class="input-group col-md-8">
                                    <!-- <select name="transaksi_kecepatan_tanggap" id="transaksi_kecepatan_tanggap" class="select2 form-control required">
                                    <option value="1">Biasa</option>
                                    <option value="2">Segera</option>
                                    <option value="3">Sangat Segera</option>
                                  </select> -->
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Reviewer *</label>
                                <div class="input-group col-md-8">
                                  <!-- <select name="transaksi_reviewer" id="transaksi_reviewer" class="select2 form-control required"></select> -->
                                </div>
                              </div>
                              <div class=" form-group row col-md-12">
                                <label class="col-md-4">Approver *</label>
                                <div class="input-group col-md-8">
                                  <!-- <select name="transaksi_approver" id="transaksi_approver" class="select2 form-control required"></select> -->
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Drafter</label>
                                <div class="input-group col-md-8">
                                  <!-- <input readonly type="text" name="transaksi_drafter_id" id="transaksi_drafter_id" class="form-control" value="<?= $session['user_nik_sap'] ?>"> -->
                                  <!-- <input readonly type="text" name="transaksi_drafter" id="transaksi_drafter" class="form-control"> -->
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Tujuan</label>
                                <div class="input-group col-md-8">
                                  <!-- <input readonly type="text" name="transaksi_tujuan_id" id="transaksi_tujuan_id" class="form-control" value="<?= $vp_ppk['user_nik_sap'] ?>"> -->
                                  <!-- <input readonly type="text" name="transaksi_tujuan" id="transaksi_tujuan" class="form-control"> -->
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Attach</label>
                                <div class="input-group col-md-8">
                                  <!-- <input type="file" name="transaksi_attach" id="transaksi_attach" class="form-control"> -->
                                </div>
                              </div>
                              <div class="form-group row col-md-12" id="div_transaksi_detail_foto_sebelumnya" style="display: none;">
                                <table width="100%">
                                  <tr>
                                    <td width="40%"><label>Foto Sebelumnya</label></td>
                                    <!-- <td width="60%"><img required src="" alt="" style="width: 100px" id="transaksi_detail_foto_sebelumnya"></td> -->
                                  </tr>
                                </table>
                              </div>
                            </div>
                            <!-- Kanan -->
                          </div>
                          <!-- easy ui -->
                            <!-- <div class="form-group row col-md-12">
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
                            </div> -->
                            <!-- easy ui -->
                          </div>
                          <div class="modal-footer justify-content-between">
                      <!-- <button type="button" id="close" class="btn btn-default" data-dismiss="modal" onclick="fun_close()">Close</button>
                    <button type="button" class="btn btn-info" id="draft">Draft</button>
                    <button type="button" class="btn btn-primary" id="edit" style="display: none">Edit</button>
                    <button type="button" class="btn btn-success" id="simpan">Ajukan</button>
                    <button class="btn btn-primary" type="button" id="loading_form" disabled style="display: none;">
                      <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                      Loading...
                    </button> -->
                  </div>
                </form>
              </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
          </div>
          <!-- Modal -->
          <!-- Modal Detail -->
          <div class="modal fade" id="modal_detail">
            <div class="modal-dialog modal-lg">
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
          <!-- Modal Detail -->
          <div class="modal fade" id="modal_history">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">History</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <table id="table_history" class="table table-bordered table-striped " width="100%">
                    <thead>
                      <tr>
                        <th>Judul Pekerjaan</th>
                        <th>Peminta Jasa</th>
                        <th>PIC</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                        <th>Oleh</th>
                        <th>Pada Tanggal</th>
                      </tr>
                    </thead>
                  </table>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>
          <!-- Modal Lihat -->
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
                <form id="form_modal_lihat">
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
            </div>
          </div>
          <!-- Modal Lihat -->
          <!-- Modal Keterangan -->
          <div class="modal fade" id="modal_keterangan">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Memorandum</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form id="form_keterangan">
                  <input id="id_template" name="id_template" style="display:none">
                  <input id="keterangan_id" name="keterangan_id" style="display:none">
                  <input id="keterangan_new" name="keterangan_new" style="display:none">
                  <div class="modal-body">
                    <div id="div_modal_keterangan">
                      <div class="card-body row">
                        <!-- Kiri -->
                        <div class="col-12">
                          <div class="form-group row col-md-12">
                            <label class="col-md-4">Kepada</label>
                            <div class="input-group col-md-8">
                              <select class="form-control select2" id="keterangan_kepada" name="keterangan_kepada">
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="col-12">
                          <div class="form-group row col-md-12">
                            <label class="col-md-4">Dari</label>
                            <div class="input-group col-md-8">
                              <select class="form-control select2" id="keterangan_dari" name="keterangan_dari">
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="col-12">
                          <div class="form-group row col-md-12">
                            <label class="col-md-4">Perihal</label>
                            <div class="input-group col-md-8">
                              <input type="text" class="form-control" id="keterangan_perihal" name="keterangan_perihal">
                            </div>
                          </div>
                        </div>
                        <div class="col-12">
                          <div class="form-group row col-md-12">
                            <label class="col-md-4">Tanggal</label>
                            <div class='input-group date col-md-8' id="keterangan_tanggal">
                              <input name="keterangan_tanggal" id="keterangan_tanggal" class="datetimepicker form-control" type="text" inputmode="none" class="form-control" required="" value="<?= date('Y-m-d') ?>" />
                              <span class="input-group-text">
                                <span class="fa fa-calendar"></span>
                              </span>
                            </div>
                          </div>
                        </div>
                        <div class="col-12">
                          <div class="form-group row col-md-12">
                            <label class="col-md-4">Lampiran</label>
                            <div class="input-group col-md-8">
                              <input type="file" class="form-control" id="keterangan_file" name="keterangan_file">
                            </div>
                          </div>
                        </div>
                        <div class="col-12">
                          <div class="form-group row col-md-12">
                            <label class="col-md-4">Isi</label>
                            <div class="input-group col-md-8">
                              <textarea class="form-control" id="keterangan_isi" name="keterangan_isi"></textarea>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="tutup_keterangan" onclick="fun_close_keterangan()">Close</button>
                    <button type="submit" class="btn btn-primary" id="simpan_keterangan">Simpan</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <!-- Modal Keterangan -->
          <!-- Body -->
        </div>
      </div>
      <!-- DIV DATA DIRI -->
    </div>
  </div>
</div>
</div>
</section>
<!-- Container Body -->
</div>
  <!-- CONTAINER-->