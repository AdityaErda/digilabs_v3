<? 
  if(!IsAllowed("master_alber",prive_view)){
    die("Maaf anda tidak berhak membuka halaman ini....");
    exit(1);
  } else if(IsAllowed("master_alber",'1')===1){
    echo "<script>window.parent.document.location.href='".base_url('login/')."'</script>";
    exit(1);
  } 
?>

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<!--jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<!--appendGrid JS library-->
<script src="https://cdn.jsdelivr.net/npm/jquery.appendgrid@2/dist/AppendGrid.js"></script>
<!--Script for initialize appendGrid-->

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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
      <!-- DIV FILTER --><!-- DIV DATA UTAMA -->
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
                  <table id="table" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Tanggal Perbaikan</th>
                        <th>Jenis Alber</th>
                        <th>Kode Unit</th>
                        <th>Driver</th>
                        <th>Nama Pekerjaan</th>
                        <th>Detail Pekerjaan</th>
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
              <div class="form-group row col-md-12">
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
              </div>
              <div class="form-group row col-md-12">
                <label class="col-md-1" style="color: orange;">Tenaga</label>
                <hr class="col-md-10" style="border: 1px solid orange">
              </div>
              <div class="form-group row col-md-12">
                <label class="col-md-4">Mekanik</label>
                <select id="perbaikan_mekanik" name="perbaikan_mekanik" class="col-md-8 form-control">
                </select>
              </div>
              <div class="form-group row col-md-12">
                <label class="col-md-4">Listrik</label>
                <select id="perbaikan_listrik" name="perbaikan_listrik" class="col-md-8 form-control">
                </select>
              </div>
              <div class="form-group row col-md-12">
                <label class="col-md-4">Las</label>
                <select id="perbaikan_las" name="perbaikan_las" class="col-md-8 form-control">
                </select>
              </div>
              <div class="form-group row col-md-12">
                <label class="col-md-4">Detail Perbaikan</label>
                <textarea class="form-control col-md-8" style="resize:none;" name="detail_perbaikan"></textarea>
              </div>
              <div class="form-group row col-md-12">
                <label class="col-md-1" style="color: orange;">Material</label>
                <hr class="col-md-10" style="border: 1px solid orange">
              </div>
              <div class="col-md-12">
                <table class="table table-bordered table-striped" id="t_material">
                </table>
              </div>
              <div class="form-group row col-md-12">
                <label class="col-md-4">Harga Material</label>
                <input type="text" id="perbaikan_harga_material" name="perbaikan_harga_material" value="" placeholder="" class="form-control col-md-8">
              </div>
              <div class="form-group row col-md-12">
                <label class="col-md-4">Harga Jasa</label>
                <input type="text" id="perbaikan_harga_jasa" name="perbaikan_harga_jasa" value="" placeholder="" class="form-control col-md-8" onkeyup="fun_total_cost(this.value)">
              </div>
              <div class="form-group row col-md-12">
                <label class="col-md-4">Total Cost</label>
                <input type="text" id="perbaikan_total_cost" name="perbaikan_total_cost" value="" placeholder="" class="form-control col-md-8">
              </div>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" id="close" class="btn btn-default" data-dismiss="modal" onclick="fun_close()">Close</button>
            <input type="submit" class="btn btn-success pull-right" id="simpan_kategori_instalasi" value="Simpan">
            <input type="submit" class="btn btn-primary pull-right" id="edit_kategori_instalasi" style="display: none" value="Edit">
          </div>
        </form>
      </div>
    </div>
  </div>
<!-- MODAL HEADER INSTALASI -->

<script type="text/javascript">
  $(function () { 
    var myAppendGrid = new AppendGrid({
      element: "t_material",
      hideButtons: {
        append: true,
        removeLast: true,
        moveUp: true,
        moveDown: true,
      },
      columns: [
        {
          name: "material",
          display : 'Material',
          displayCss: {
            "width": "120px"
          },
          type: "custom",
          customBuilder: function(parent, idPrefix, name, uniqueIndex) {
            var inputGroup = document.createElement("select");
            inputGroup.classList.add("select2", "col-md-12");
            inputGroup.id = 'material_'+(uniqueIndex-1);
            inputGroup.name = 'material['+(uniqueIndex-1)+']';
            parent.appendChild(inputGroup);
          }
        }, {
          name: "spec",
          display : "Spec",
          displayCss: {
            "width": "120px"
          },
          type: "custom",
          customBuilder: function(parent, idPrefix, name, uniqueIndex) {
            var inputGroup = document.createElement("label");
            inputGroup.classList.add("form-control", "spec");
            inputGroup.id = 'spec_material_'+(uniqueIndex-1);
            inputGroup.name = 'spec_material['+(uniqueIndex-1)+']';
            parent.appendChild(inputGroup);
          }
        }, {
          name: "jumlah",
          display : "Jumlah",
          displayCss: {
            "width": "80px"
          },
          type: "custom",
          customBuilder: function(parent, idPrefix, name, uniqueIndex) {
            var inputGroup = document.createElement("input");
            inputGroup.classList.add("form-control", "jumlah");
            inputGroup.id = 'jumlah_material_'+(uniqueIndex-1);
            inputGroup.name = 'jumlah_material['+(uniqueIndex-1)+']';
            parent.appendChild(inputGroup);
          }
        }, {
          name: "jumlah_satuan",
          display : "Harga",
          invisible: true,
          displayCss: {
            "width": "80px"
          },
          type: "custom",
          customBuilder: function(parent, idPrefix, name, uniqueIndex) {
            var inputGroup = document.createElement("label");
            inputGroup.classList.add("form-control");
            inputGroup.id = 'satuan_jumlah_material_'+(uniqueIndex-1);
            inputGroup.name = 'satuan_jumlah_material['+(uniqueIndex-1)+']';
            parent.appendChild(inputGroup);
          }
        }, {
          name: "satuan",
          display : "Satuan",
          displayCss: {
            "width": "100px"
          },
          type: "custom",
          customBuilder: function(parent, idPrefix, name, uniqueIndex) {
            var inputGroup = document.createElement("label");
            inputGroup.classList.add("form-control");
            inputGroup.id = 'satuan_material_'+(uniqueIndex-1);
            inputGroup.name = 'satuan_material['+(uniqueIndex-1)+']';
            parent.appendChild(inputGroup);
          }
        }, {
          name: "no_mat",
          display : "No.",
          displayCss: {
            "width": "50px"
          },
          type: "custom",
          customBuilder: function(parent, idPrefix, name, uniqueIndex) {
            var inputGroup = document.createElement("label");
            inputGroup.classList.add("form-control");
            inputGroup.id = 'no_mat_material_'+(uniqueIndex-1);
            inputGroup.name = 'no_mat_material['+(uniqueIndex-1)+']';
            parent.appendChild(inputGroup);
          }
        }, {
          name: "harga",
          display : "Total",
          displayCss: {
            "width": "160px"
          },
          type: "custom",
          customBuilder: function(parent, idPrefix, name, uniqueIndex) {
            var inputGroup = document.createElement("label");
            inputGroup.classList.add("form-control", "total");
            inputGroup.id = 'total_jumlah_material_'+(uniqueIndex-1);
            inputGroup.name = 'total_jumlah_material['+(uniqueIndex-1)+']';
            parent.appendChild(inputGroup);
          }
        }
      ]
    });

    fun_s2();
    

    $('button').click(function() {
      fun_s2();
    });

    $( "#tanggal" ).daterangepicker({
      locale: {format: 'DD-MM-YYYY'}
    });

    $("#tanggal_perbaikan").daterangepicker({
      showDropdowns: true,
      timePicker: true,
      timePicker24Hour: true,
      singleDatePicker: true,
      locale: {format: 'DD-MM-YYYY HH:mm'}
    });

    $("#tanggal_selesai").daterangepicker({
      showDropdowns: true,
      timePicker: true,
      timePicker24Hour: true,
      singleDatePicker: true,
      locale: {format: 'DD-MM-YYYY HH:mm'}
    });

    fun_jenis();

    /* Isi Table */
      $('#table').DataTable({
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
            {
              "render": function ( data, type, full, meta ) {
                return (full.perbaikan_status == 'y') ? '' : '<center><a href="javascript:;" id="'+full.perbaikan_id+'" title="Edit" onclick="fun_edit(this.id)"><i class="fa fa-search" data-toggle="modal" data-target="#modal"></i></a></center>';
              }
            },
          ]
      });
    /* Isi Table */
  });

  function fun_s2() {
    $('.select2').select2({
      ajax: {
        delay: 250,
        url: 'perbaikan/getMaterial',
        dataType: 'json',
        type: 'GET',
        data: function (params) {
          var queryParameters = {
            material_nama: params.term
          }

          return queryParameters;
        },
      }
    });

    $('.spec').css({width: '120px', height: '60px'});
    $('.select2').css('width', '120px');
    $('.select2-selection').css('height', '35px');
    $('.select2').on('select2:select', function (e) {
      var id = e.currentTarget.id;
      var data = e.params.data.id;

      $.getJSON('perbaikan/getMaterialId?material_id='+data, function(json) {
        console.log(json);
        $('#spec_'+id).html(json.material_spesifikasi);
        $('#satuan_'+id).html(json.satuan_nama);
        $('#no_mat_'+id).html(json.material_nomer);
        $('#satuan_jumlah_'+id).html(json.material_harga_satuan);
      });
    });

    $('.jumlah').keyup(function() {
      var id = this.id;
      var isi = this.value;
      var harga = $('#satuan_'+id).text();
      $('#total_'+id).html(isi*harga);

      fun_total_material();
    });
  }

  function fun_total_material() {
    var sum = 0;
    $('.total').each(function(){
      sum += parseFloat($(this).text() * 1);  // Or this.innerHTML, this.innerText
    });

    $('#perbaikan_harga_material').val(sum);
  }

  function fun_total_cost(isi) {
    var total = parseFloat(isi) + parseFloat($('#perbaikan_harga_material').val());
    $('#perbaikan_total_cost').val(total);
  }

  function fun_edit(id) {
    $('#perbaikan_id').val(id);
    fun_mekanik();
    fun_listrik();
    fun_las();
    setTimeout($.getJSON('perbaikan/getDetailPerbaikan?perbaikan_id='+id, function(json) {      
      $.each(json, function(index, val) {
        $('#'+index).val(val);
      });
    }), 1500);
  }

  function fun_jenis() {
    $.getJSON('perbaikan/getJenisAlber', function(json) {
      $('#jenis_id').html('<option value="">Pilih Jenis Alber</option>');
      $.each(json, function(index, val) {
        $('#jenis_id').append('<option value="'+val.jenis_id+'">'+val.jenis_nama+'</option>');
      });
    });
  }

  function fun_mekanik() {
    $.getJSON('perbaikan/getMekanik?id_regu=1', function(json) {
      $('#perbaikan_mekanik').html('<option value="">Pilih Tenaga Mekanik</option>');
      $.each(json, function(index, val) {
        $('#perbaikan_mekanik').append('<option value="'+val.teknisi_id+'">'+val.teknisi_nama+'</option>');
      });
    });
  }

  function fun_listrik() {
    $.getJSON('perbaikan/getMekanik?id_regu=3', function(json) {
      $('#perbaikan_listrik').html('<option value="">Pilih Tenaga Listrik</option>');
      $.each(json, function(index, val) {
        $('#perbaikan_listrik').append('<option value="'+val.teknisi_id+'">'+val.teknisi_nama+'</option>');
      });
    });
  }

  function fun_las() {
    $.getJSON('perbaikan/getMekanik?id_regu=2', function(json) {
      $('#perbaikan_las').html('<option value="">Pilih Tenaga Las</option>');
      $.each(json, function(index, val) {
        $('#perbaikan_las').append('<option value="'+val.teknisi_id+'">'+val.teknisi_nama+'</option>');
      });
    });
  }

  $("#filter").on("submit", function (e) {
    e.preventDefault();
    $('#table').DataTable().ajax.url('perbaikan/getPerbaikan?'+$('#filter').serialize()).load();
  });

  $("#form_modal").on("submit", function (e) {
    e.preventDefault();
    $.ajax({
      url:'perbaikan/updatePerbaikan',
      data:$('#form_modal').serialize(),
      type:'POST',
      dataType: 'html',
      success:function(isi) {
        $('#form_modal').reset();
        $('#table').DataTable().ajax.reload();
        $('#modal').modal('hide');
        $(".modal-backdrop").remove();
      }
    });
  });

  function fun_close() {
    $('#form_modal').reset();
  }
</script>