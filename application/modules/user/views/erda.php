<? 
  if(!IsAllowed("master_alber",prive_view)){
    die("Maaf anda tidak berhak membuka halaman ini....");
    exit(1);
  } else if(IsAllowed("master_alber",'1')===1){
    echo "<script>window.parent.document.location.href='".base_url('login/')."'</script>";
    exit(1);
  } 
?>

<section class="content">
  <div class="row">
    <div class="col-12">
      <!-- DIV FILTER -->
        <div class="col-md-12">
          <div class="card">
            <!-- Header -->
              <div class="card-header">
                <h3 class="card-title">Filter Perbaikan</h3>
              </div>
            <!-- Header -->
            <!-- Body -->
              <div class="card-body">
                <form id="filter">
                  <div class="row" class="col-md-12">
                    <div class="form-group col-md-4">
                      <label>Tanggal Perbaikan</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="far fa-calendar-alt"></i>
                          </span>
                        </div>
                        <input type="text" class="form-control float-right" id="tanggal" name="tanggal">
                      </div>
                    </div>
                    <div class="form-group col-md-4">
                      <label>Jenis Alber</label>
                      <div class="input-group">
                        <select id="jenis_id" name="jenis_id" class="form-control">
                        </select>
                      </div>
                    </div>
                    <div class="form-group col-md-4">
                      <label>&nbsp;</label>
                      <div class="input-group">
                        <input type="submit" name="cari" value="cari" class="btn btn-primary col-md-4">
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            <!-- Body -->
          </div>
        </div>
      <!-- DIV FILTER -->
      <!-- DIV DATA UTAMA -->
        <div class="col-md-12">
          <div class="card">
            <!-- Header -->
              <div class="card-header">
                <h3 class="card-title">Pekerjaan</h3>
              </div>
            <!-- Header -->
            <!-- Body -->
              <div class="card-body">
                <!-- Table -->
                  <table id="table" class="table table-bordered table-striped" width="100%">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Tanggal Perbaikan</th>
                        <th>Jenis Alber</th>
                        <th>Kode Unit</th>
                        <th>Driver</th>
                        <th>Nama Pekerjaan</th>
                        <th>Detail Pekerjaan</th>
                        <th>Persen (%)</th>
                        <th>Proses</th>
                      </tr>
                    </thead>
                  </table>
                <!-- Table -->
              </div>
            <!-- Body -->
          </div>
        </div>
      <!-- DIV DATA UTAMA -->
    </div>
  </div>
</section>

<!-- MODAL HEADER INSTALASI -->
  <div class="modal fade" id="modal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Perbaikan</h4>
        </div>
        <form id="form_modal">
          <div class="modal-body">
            <div class="card-body row">
              <input type="hidden" id="perbaikan_id" name="perbaikan_id">
              <input type="hidden" id="perbaikan_waktu_berjalan" name="perbaikan_waktu_berjalan" value="">
              <!-- <div class="form-group row col-md-12">
                <label class="col-md-4">Tgl Perbaikan</label>
                <div class="input-group col-md-8">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="far fa-calendar-alt"></i>
                    </span>
                  </div>
                  <input type="text" class="form-control float-right" id="tanggal_perbaikan" name="tanggal_perbaikan">
                </div>
              </div>
              <div class="form-group row col-md-12">
                <label class="col-md-4">Tgl Selesai</label>
                <div class="input-group col-md-8">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="far fa-calendar-alt"></i>
                    </span>
                  </div>
                  <input type="text" class="form-control float-right" id="tanggal_selesai" name="tanggal_selesai">
                </div>
              </div> -->
              <div class="form-group row col-md-12">
                <label class="col-md-1" style="color: orange;">Tenaga</label>
                <hr class="col-md-10" style="border: 1px solid orange">
              </div>
              <div class="form-group row col-md-12">
                <label class="col-md-4">Mekanik</label>
                <div class="col-md-8">
                  <select id="perbaikan_mekanik" name="perbaikan_mekanik[]" multiple="multiple" class="col-md-12 form-control">
                  </select>
                </div>
              </div>
              <div class="form-group row col-md-12">
                <label class="col-md-4">Listrik</label>
                <div class="col-md-8">
                  <select id="perbaikan_listrik" name="perbaikan_listrik[]" multiple="multiple" class="col-md-12 form-control">
                  </select>
                </div>
              </div>
              <div class="form-group row col-md-12">
                <label class="col-md-4">Las</label>
                <div class="col-md-8">
                  <select id="perbaikan_las" name="perbaikan_las[]" multiple="multiple" class="col-md-12 form-control">
                  </select>
                </div>
              </div>
              <div class="form-group row col-md-12">
                <label class="col-md-4">Detail Perbaikan</label>
                <textarea class="form-control col-md-8" style="resize:none;" id="detail_perbaikan" name="detail_perbaikan"></textarea>
              </div>
              <div class="form-group row col-md-12">
                <label class="col-md-1" style="color: orange;">Material</label>
                <hr class="col-md-10" style="border: 1px solid orange">
              </div>
              <div class="col-md-12">
                <table id="dg" title="Material" style="width:100%" toolbar="#toolbar" pagination="true" idField="id" rownumbers="true" fitColumns="true" singleSelect="true">
                  <thead>
                    <tr>
                      <th data-options="formatter:function(value,row){return row.material_nama}" field="id_material" width="50" editor="{type:'combogrid', options:{
                        idField: 'material_id', 
                        textField: 'material_nama',
                        url: 'perbaikan/getMaterial',
                        mode: 'remote',
                        fitColumns:true,
                        columns: [[
                          {field:'material_nama',title:'Material Nama',width:60},
                        ]],
                      panelHeight:135}}">Material</th>
                      <th field="spec" width="50" editor="{type:'label'}">Spec</th>
                      <th field="material_jumlah" width="50" editor="{type:'numberspinner',options:{required:true}}">Jumlah</th>
                      <th field="no" width="50" editor="{type:'label'}">No</th>
                      <th hidden field="perbaikan_material_id" width="50" editor="{type:'text'}">id</th>
                    </tr>
                  </thead>
                </table>
                <div id="toolbar">
                  <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="fun_tambah()">New</a>
                  <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="fun_hapus()">Delete</a>
                  <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="fun_simpan()">Save</a>
                  <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:$('#dg').edatagrid('cancelRow')">Cancel</a>
                </div>
                <br>
              </div>
              <!-- <div class="form-group row col-md-12">
                <label class="col-md-4">Harga Material</label>
                <input type="text" id="perbaikan_harga_material" name="perbaikan_harga_material" value="" placeholder="" class="form-control col-md-8">
              </div> -->
              <!-- <div class="form-group row col-md-12">
                <label class="col-md-4">Harga Jasa</label>
                <input type="text" id="perbaikan_harga_jasa" name="perbaikan_harga_jasa" value="" placeholder="" class="form-control col-md-8" onkeyup="fun_total_cost(this.value)">
              </div> -->
              <!-- <div class="form-group row col-md-12">
                <label class="col-md-4">Total Cost</label>
                <input type="text" id="perbaikan_total_cost" name="perbaikan_total_cost" value="" placeholder="" class="form-control col-md-8">
              </div> -->
              <div class="form-group row col-md-12" id="div_persen">
                <label class="col-md-4">Persentase Perbaikan</label>
                <input type="number" id="persen" name="persen" value="" placeholder="" class="form-control col-md-12">
              </div>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" id="close" class="btn btn-default" data-dismiss="modal" onclick="fun_close()">Close</button>
            <input type="submit" class="btn btn-success pull-right" id="mulai" value="Mulai">
            <input type="submit" class="btn btn-danger pull-right" id="selesai" style="display: none" value="Selesai">
          </div>
        </form>
      </div>
    </div>
  </div>
<!-- MODAL HEADER INSTALASI -->

<script type="text/javascript">
  $(function () {
    $( "#tanggal" ).daterangepicker({
      locale: {format: 'DD-MM-YYYY'}
    });

    $('#jenis_id').select2({
      placeholder: 'Pilih Jenis Alber',
      ajax: {
        delay: 250,
        url: 'perbaikan/getJenisAlber',
        dataType: 'json',
        type: 'GET',
        data: function (params) {
          var queryParameters = {
            jenis_nama: params.term
          }

          return queryParameters;
        }
      }
    });

    $('#perbaikan_mekanik').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: 'perbaikan/getMekanik?id_regu=1',
        dataType: 'json',
        type: 'GET',
        data: function (params) {
          var queryParameters = {
            teknisi_nama: params.term
          }

          return queryParameters;
        }
      }
    });

    $('#perbaikan_listrik').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: 'perbaikan/getMekanik?id_regu=3',
        dataType: 'json',
        type: 'GET',
        data: function (params) {
          var queryParameters = {
            teknisi_nama: params.term
          }

          return queryParameters;
        }
      }
    });

    $('#perbaikan_las').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: 'perbaikan/getMekanik?id_regu=2',
        dataType: 'json',
        type: 'GET',
        data: function (params) {
          var queryParameters = {
            teknisi_nama: params.term
          }

          return queryParameters;
        }
      }
    });

    $('.select2-selection').css('height', '37px');
    $('.select2').css('width', '100%');

    /* Isi Table */
      $('#table').DataTable({
        "scrollX": true,
        "ajax": {
            "url": "perbaikan/getPerbaikan?tanggal="+$('#tanggal').val(),
            "dataSrc": ""
          },
          "columns": [
            {"data": "row"},
            {"data": "tanggal_perbaikan"},
            {"data": "jenis_nama"},
            {"data": "alber_no_plat"},
            {"data": "driver_nama"},
            {"data": "checklist_nama"},
            {"data": "detail_pekerjaan"},
            {"data": "perbaikan_progress"},
            {
              "render": function ( data, type, full, meta ) {
                return (full.perbaikan_progress == '100') ? '' : '<center><a href="javascript:;" id="'+full.perbaikan_id+'" title="Edit" onclick="fun_edit(this.id)"><i class="fa fa-search" data-toggle="modal" data-target="#modal"></i></a></center>';
              }
            },
          ]
      });
    /* Isi Table */

    $('#persen').on('keyup', function(event) {
      event.preventDefault();
      if ($('#persen').val() > 100) {
        $('#persen').val(100);
      }
    });
  });

  $("#filter").on("submit", function (e) {
    e.preventDefault();
    $('#table').DataTable().ajax.url('perbaikan/getPerbaikan?'+$('#filter').serialize()).load();
  });

  function fun_edit(id) {
    $('#perbaikan_id').val(id);
    $.getJSON('perbaikan/getDetailPerbaikan?perbaikan_id='+id, function(json) {      
      $('#perbaikan_waktu_berjalan').val(json.perbaikan_waktu_berjalan);
      $('#detail_perbaikan').val(json.detail_perbaikan);

      if (json.perbaikan_waktu_berjalan == 'y') {
        $('#selesai').css('display', 'block');
        $('#mulai').css('display', 'none');
        $('#div_persen').css('display', 'block');
        $('#persen').val(json.perbaikan_progress);
      } else {
        $('#selesai').css('display', 'none');
        $('#mulai').css('display', 'block');
        $('#div_persen').css('display', 'none');
      }
    });

    $.getJSON('perbaikan/getMekanikMekanik?id_regu=1&id_perbaikan='+id, function(json) {
      $.each(json, function(index, val) {
        var option = new Option(val.teknisi_nama, val.teknisi_id, true, true);
        $('#perbaikan_mekanik').append(option).trigger('change');
      });
    });

    $.getJSON('perbaikan/getMekanikListrik?id_regu=3&id_perbaikan='+id, function(json) {
      $.each(json, function(index, val) {
        var option = new Option(val.teknisi_nama, val.teknisi_id, true, true);
        $('#perbaikan_listrik').append(option).trigger('change');
      });
    });

    $.getJSON('perbaikan/getMekanikLas?id_regu=2&id_perbaikan='+id, function(json) {
      $.each(json, function(index, val) {
        var option = new Option(val.teknisi_nama, val.teknisi_id, true, true);
        $('#perbaikan_las').append(option).trigger('change');
      });
    });

    setTimeout(function() {
      $('#dg').edatagrid({
        url: 'perbaikan/getEasyuiMaterial?id_perbaikan='+id,
        saveUrl: 'perbaikan/insertEasyuiMaterial',
        updateUrl: 'perbaikan/editEasyuiMaterial',
      });
    }, 500);
  }

  $("#form_modal").on("submit", function (e) {
    e.preventDefault();
    $.ajax({
      url:'perbaikan/updatePerbaikan',
      data:$('#form_modal').serialize(),
      type:'POST',
      dataType: 'html',
      success:function(isi) {
        $('#form_modal')[0].reset();
        $('#table').DataTable().ajax.reload();
        $('#close').click();
        $('#perbaikan_mekanik').html('').trigger('change');
        $('#perbaikan_listrik').html('').trigger('change');
        $('#perbaikan_las').html('').trigger('change');
      }
    });
  });

  function fun_close() {
    $('#form_modal')[0].reset();
    $('#perbaikan_mekanik').html('').trigger('change');
    $('#perbaikan_listrik').html('').trigger('change');
    $('#perbaikan_las').html('').trigger('change');
  }

  /* FUNGSI EASYUI */
    function fun_tambah() {
      var id = $('#perbaikan_id').val();
      $('#dg').edatagrid('addRow',{
        index: 0,
        row:{
          id_perbaikan : id,
        }
      });
    }

    function fun_simpan() {
      $('#dg').edatagrid('saveRow');
      setTimeout($('#dg').datagrid('reload'), 1000);
    }

    function fun_hapus() {
      var row = $('#dg').datagrid('getSelected');
      $.post('perbaikan/deleteEasyuiMaterial', {perbaikan_material_id: row.perbaikan_material_id}, function(data, textStatus, xhr) {
        $('#dg').datagrid('reload');
      });
    }
  /* FUNGSI EASYUI */
</script>