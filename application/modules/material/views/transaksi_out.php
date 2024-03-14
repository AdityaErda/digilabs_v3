<!-- CONTAINER -->
<style>
  .panel {
    overflow: auto;
    height: 35%;
  }
</style>

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
            <div class="card card-warning">
              <!-- Header -->
              <div class="card-header">
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
            <div class="card card-success">
              <!-- Header -->
              <div class="card-header">
                <h3 class="card-title"><?= $judul ?></h3>
                <a href="<?= base_url('material/transaksi_out/proses') ?>?header_menu=<?= $_GET['header_menu'] ?>&menu_id=<?= $_GET['menu_id'] ?>&transaksi_id=<?= create_id() ?>&aksi=0" class="btn btn-primary float-right">Tambah</a>
              </div>
              <!-- Header -->
              <!-- Body -->
              <div class="card-body">
                <!-- Table -->
                <table id="table" class="table table-bordered" width="100%">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nomor</th>
                      <th>Tanggal</th>
                      <th>Waktu</th>
                      <th>Peminta Jasa</th>
                      <th>User Peminta</th>
                      <th>Status</th>
                      <th>History</th>
                      <th>Detail</th>
                      <th>Approved</th>
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
                        <div class="modal-body">
                          <div class="card-body row">
                            <div class="col-12">
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Waktu</label>
                                <div class="input-group col-md-4">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text">
                                      <i class="far fa-calendar-alt"></i>
                                    </span>
                                  </div>
                                  <input type="text" class="form-control float-right" id="tanggal" name="tanggal" readonly>
                                </div>
                                <div class="input-group col-md-4">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text">
                                      <i class="far fa-clock"></i>
                                    </span>
                                  </div>
                                  <input type="text" class="form-control float-right" id="waktu" name="waktu" readonly>
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">Peminta Jasa</label>
                                <div class="input-group col-md-8">
                                  <input type="text" name="seksi_id_peminta" id="seksi_id_peminta" style="display:none">
                                  <input type="text" name="seksi_nama_peminta" id="seksi_nama_peminta" class="form-control" readonly>
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <label class="col-md-4">User Peminta</label>
                                <div class="input-group col-md-8">
                                  <input type="text" name="user_id_peminta" id="user_id_peminta" style="display:none">
                                  <input type="text" name="user_nama_peminta" id="user_nama_peminta" class="form-control" readonly>
                                </div>
                              </div>
                              <div class="form-group row col-md-12">
                                <table id="dg" title="Material" style="width:100%" toolbar="#toolbar" pagination="true" idField="id" rownumbers="true" fitColumns="true" singleSelect="true">
                                  <thead>
                                    <tr>
                                      <th data-options="field:'item_id',width:100,
                                                formatter:function(value,row){
                                                  return row.item_nama;
                                                },
                                                editor:{
                                                  type:'combobox',
                                                  options:{
                                                    valueField:'item_id',
                                                    textField:'item_nama',
                                                    panelHeight: 'auto',
                                                    url : '<?= base_url() ?>material/request/getItem',
                                                    required:true,

                                                    fitColumns:true,
                                                    onSelect: function(value) {
                                                      var dg = $('#dg');
                                                      var row = dg.datagrid('getSelected');
                                                      var rowIndex = dg.datagrid('getRowIndex', row);
                                                      var get_item_satuan = dg.datagrid('getEditor', {index:rowIndex,field:'item_satuan'});

                                                      $.ajax({
                                                        url : '<?= base_url() ?>material/request/getItem',
                                                        type:'GET',
                                                        dataType:'JSON',
                                                        success:function(data){
                                                          for(let i = 0; i < data.length; i++) {
                                                            if(value.item_id != data[i].item_id) {
                                                              $(get_item_satuan.target).textbox('setValue', '');
                                                            } else if(value.item_id == data[i].item_id) {
                                                              $(get_item_satuan.target).textbox('setValue', data[i].item_satuan);
                                                              break;
                                                            }
                                                          }
                                                        }
                                                      });
                                                    },

                                                    columns:[[
																                      {field:'item_nama',title:'Material',width:500},
															                      ]],
                                                  }
                                                }">Material</th>
                                      <th field="item_satuan" width="30" editor="{type:'textbox', options:{readonly : true}}
                                                ">Satuan</th>
                                      <th field="transaksi_detail_jumlah" width="50" editor="{type:'numberbox',options:{required:true,min:0,precision:2}}
                                                ">Jumlah</th>
                                      <th field="transaksi_detail_total" width="50" editor="{type:'label'}">Total</th>
                                    </tr>
                                  </thead>
                                </table>
                                <div id="toolbar">
                                  <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="fun_tambah_to()">New</a>
                                  <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="fun_hapus_to()">Delete</a>
                                  <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="fun_simpan_to()">Save</a>
                                  <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:$('#dg').edatagrid('cancelRow')">Cancel</a>
                                </div>
                                <span><strong>NB: <br />1. Data Material diambil dari master data, harap isikan sesuai list yang tersedia<br />2. Data hanya bisa disimpan satu per satu, pastikan klik save setelah menginput sebuah data terlebih dahulu agar data yang anda inputkan tidak hilang</strong> <span>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                          <button type="button" id="close" class="btn btn-default" data-dismiss="modal">Close</button>
                          <button type="button" class="btn btn-success" id="simpan">Approved</button>
                          <button type="button" class="btn btn-warning" id="disiapkan" style="display: none;">Disiapkan</button>
                          <button type="button" class="btn btn-info" id="diambil" style="display: none;">Diambil</button>
                          <button type="button" class="btn btn-success" id="aprove" style="display: none;">Approved</button>
                          <button type="button" class="btn btn-primary" id="edit" style="display: none">Edit</button>
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
                <div class="modal fade" id="modal_aksi_detail">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title"><?= $judul ?></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <form id="form_modal_detail">
                        <div class="modal-body">
                          <table id="table1" class="table table-bordered" width="100%">
                            <thead>
                              <tr>
                                <th>No</th>
                                <th>Material</th>
                                <th>Satuan</th>
                                <th>Jumlah</th>
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
                <!-- Modal History -->
                <div class="modal fade" id="modal_aksi_history">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">
                          <div id="judul_history"></div>
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <form id="form_modal_detail">
                        <div class="modal-body">
                          <table id="table_history" class="table table-bordered" width="100%">
                            <thead>
                              <tr>
                                <th>No</th>
                                <th>Tipe</th>
                                <th>Status</th>
                                <th>Waktu</th>
                                <th>Oleh</th>
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
                <!-- Modal History-->
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