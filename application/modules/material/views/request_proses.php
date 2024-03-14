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
        <!-- QR-CODE -->
        <div class="col-md-12">
          <div class="card card-secondary">
            <!-- Header -->
            <div class="card-header">
              <h3 class="card-title">Proses Qr-Code</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-secondary btn-sm" data-card-widget="collapse" title="Collapse"><i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">
              <form id="form_qrcode">
                <input type="hidden" id="temp_transaksi_id" name="temp_transaksi_id" value="<?= $_GET['transaksi_id'] ?>">
                <div class="row">
                  <div class="col-12">
                    <div class="input-group mb-3">
                      <input type="text" id="temp_item_id" name="temp_item_id" class="form-control rounded-0">
                      <span class="input-group-append">
                        <button type="button" class="btn btn-info btn-flat">Proses</button>
                      </span>
                    </div>
                    <span>
                      <strong>
                        NB: <br />
                        Silahkan klik inputan diatas lalu scan Qr-Code dan klik proses!
                      </strong>
                      <span>
                  </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- QR-CODE -->
      <!-- PROSES -->
      <div class="col-md-12">
        <div class="card card-warning">
          <!-- Header -->
          <div class="card-header">
            <h3 class="card-title"><?= $judul ?></h3>
          </div>
          <form id="form_proses">
            <input type="hidden" id="transaksi_id" name="transaksi_id" value="<?= $_GET['transaksi_id'] ?>">
            <input type="hidden" id="transaksi_status" name="transaksi_status">
            <div class="card-body">
              <div class="row">
                <div class="col-12">
                  <div class="form-group row col-md-12">
                    <label class="col-md-4">Waktu</label>
                    <div class="input-group col-md-4">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="far fa-calendar-alt"></i>
                        </span>
                      </div>
                      <input type="text" class="form-control float-right" id="tanggal" name="tanggal" value="<?= date('d-m-Y') ?>" readonly>
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
                    <label class="col-md-4">Peminta Jasa</label>
                    <div class="input-group col-md-8">
                      <input type="text" id="seksi_id_peminta" name="seksi_id_peminta" required style="display:none">
                      <br />
                      <input type="text" id="seksi_nama_peminta" name="seksi_nama_peminta" class="form-control" readonly required>
                    </div>
                  </div>
                  <div class="form-group row col-md-12">
                    <label class="col-md-4">User Peminta</label>
                    <div class="input-group col-md-8">
                      <input type="text" id="user_id_peminta" name="user_id_peminta" required style="display:none">
                      <br />
                      <input type="text" id="user_nama_peminta" name="user_nama_peminta" class="form-control" readonly required>
                    </div>
                  </div>
                  <div class="form-group row col-md-12">
                    <table id="dg_material" title="Material" style="width:100%" toolbar="#toolbar" pagination="true" idField="id" rownumbers="true" fitColumns="true" singleSelect="true">
                      <thead>
                        <tr>
                          <th id="item_id" data-options="field:'item_id',width:100,
                                formatter:function(value,row){
                                  return row.item_nama;
                                },
                                editor:{
                                  type:'combobox',
                                  options:{
                                    idField:'item_id',
                                    valueField:'item_id',
                                    textField:'item_nama',
                                    panelHeight: '200',
                                    url : '<?= base_url() ?>material/request/getItem',
                                    required:true,
                                    fitColumns:true,
                                    onSelect: function(value) {
                                      var dg = $('#dg_material');
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
                          <th field="item_satuan" width="50" editor="{type:'textbox', options:{readonly : true}}">Satuan</th>
                          <th data-options="field:'item_harga',width:20" field="item_harga" hidden></th>
                          <th field="transaksi_detail_jumlah" width="50" editor="{type:'numberbox',options:{required:true,min:0,precision:2}}" value="1">Jumlah</th>
                          <th field="transaksi_detail_total" width="50" editor="{type:'label'}">Total</th>
                        </tr>
                      </thead>
                    </table>
                    <?php if ($_GET['aksi'] == '1' || $_GET['aksi'] == '2') : ?>
                      <div id="toolbar">
                        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="fun_tambah_request()">New</a>
                        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="fun_hapus_request()">Delete</a>
                        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="fun_simpan_request()">Save</a>
                        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:$('#dg_material').edatagrid('cancelRow')">Cancel</a>
                      </div>
                    <?php endif ?>
                    <span>
                      <strong>
                        NB: <br />
                        1. Data Material diambil dari master data, harap isikan sesuai list yang tersedia<br />
                        2. Data hanya bisa disimpan satu per satu, pastikan klik save setelah menginput sebuah data terlebih dahulu agar data yang anda inputkan tidak hilang
                      </strong>
                      <span>
                  </div>
                  <div class="col-12">
                    <a href="<?= base_url('material/request') ?>?header_menu=<?= $_GET['header_menu'] ?>&menu_id=<?= $_GET['menu_id'] ?>" class="btn btn-danger col-2">Kembali</a>
                    <?php if ($_GET['aksi'] == '1') : ?>
                      <button type="button" class="btn btn-success col-2 float-right" id="simpan">Ajukan</button>
                    <?php elseif ($_GET['aksi'] == '2') : ?>
                      <button type="button" class="btn btn-primary col-2 float-right" id="edit">Edit</button>
                    <?php elseif ($_GET['aksi'] == '3') : ?>
                      <button type="button" class="btn btn-warning col-2 float-right" id="approve">Approve</button>
                    <?php endif ?>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
      <!-- PROSES -->
    </div>
</div>
</section>
<!-- Container Body -->
</div>