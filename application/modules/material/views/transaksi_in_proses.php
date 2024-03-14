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
        <!-- DIV DATA DIRI -->
          <div class="col-md-12">
            <div class="card card-success">
              <!-- Header -->
              <div class="card-header">
                <h3 class="card-title"><?= $judul ?></h3>
              </div>
              <!-- Header -->
              <!-- Body -->
              <div class="card-body">
                <form id="form_modal">
                  <input type="hidden" id="transaksi_id" name="transaksi_id" value="<?= $_GET['transaksi_id'] ?>">
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
                            <input type="text" class="form-control float-right" id="tanggal" name="tanggal" value="<?= date('Y-m-d') ?>" readonly>
                          </div>
                          <div class="input-group col-md-4">
                            <div class="input-group-prepend">
                              <span class="input-group-text">
                                <i class="far fa-clock"></i>
                              </span>
                            </div>
                            <input type="text" class="form-control float-right" id="waktu" name="waktu" value="<?= date('H:i:s') ?>" readonly>
                          </div>
                        </div>
                        <div class="form-group row col-md-12">
                          <table id="dg" title="Material" style="width:100%" toolbar="#toolbar" pagination="true" idField="id" rownumbers="true" fitColumns="true" singleSelect="true">
                            <thead>
                              <tr>
                                <th data-options="field:'item_id',width:40,
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
                                <th field="transaksi_detail_jumlah" width="30" editor="{type:'numberbox',options:{required:true,min:0,precision:2}}">Jumlah</th>
                              </tr>
                            </thead>
                          </table>
                          <div id="toolbar">
                            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="fun_tambah_ti()">New</a>
                            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="fun_hapus_ti()">Delete</a>
                            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="fun_simpan_ti()">Save</a>
                            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:$('#dg').edatagrid('cancelRow')">Cancel</a>
                          </div>
                          <span><strong>NB: <br />1. Data Material diambil dari master data, harap isikan sesuai list yang tersedia<br />2. Data hanya bisa disimpan satu per satu, pastikan klik save setelah menginput sebuah data terlebih dahulu agar data yang anda inputkan tidak hilang</strong> <span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer justify-content-between">
                    <a href="<?= base_url('material/transaksi_in') ?>?header_menu=<?= $_GET['header_menu'] ?>&menu_id=<?= $_GET['menu_id'] ?>" class="btn btn-danger col-2">Kembali</a>
                    <button type="button" class="btn btn-success col-2" id="simpan">Simpan</button>
                  </div>
                </form>
              </div>
              <!-- Body -->
            </div>
          </div>
        <!-- DIV DATA DIRI -->
      </div>
    </div>
  </section>
  <!-- Container Body -->
</div>
<!-- CONTAINER -->