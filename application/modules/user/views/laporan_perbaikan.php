<? 
  if(!IsAllowed("master_alber",prive_view)){
    die("Maaf anda tidak berhak membuka halaman ini....");
    exit(1);
  } else if(IsAllowed("master_alber",'1')===1){
    echo "<script>window.parent.document.location.href='".base_url('login/')."'</script>";
    exit(1);
  } 
?><? 
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
                <h3 class="card-title">Filter Laporan Perbaikan</h3>
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
                        <input type="submit" name="cari" value="cari" class="btn btn-primary col-md-4">&nbsp;
                        <input type="submit" name="cetak" value="cetak" class="btn btn-danger col-md-4" onclick="fun_cetak()">
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
                <h3 class="card-title">Laporan Perbaikan</h3>
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
                        <th>Detail</th>
                      </tr>
                    </thead>
                  </table>
                <!-- Table -->
              </div>
            <!-- Body -->
          </div>
        </div>
      <!-- DIV DATA UTAMA -->
      <!-- DIV PERBAIKAN MATERIAL -->
        <div class="col-md-12" id="div_material" style="display: none;">
          <div class="card">
            <!-- Header -->
              <div class="card-header">
                <h3 class="card-title">Perbaikan Material</h3>
              </div>
            <!-- Header -->
            <!-- Body -->
              <div class="card-body">
                <!-- Table -->
                  <table id="table_material" class="table table-bordered table-striped" width="100%">
                    <thead>
                      <tr>
                        <th>No Material</th>
                        <th>Nama Material</th>
                        <th>Jumlah Material</th>
                        <th>Spec Material</th>
                      </tr>
                    </thead>
                  </table>
                <!-- Table -->
              </div>
            <!-- Body -->
          </div>
        </div>
      <!-- DIV PERBAIKAN MATERIAL -->
      <!-- DIV PERABAIKAN DETAIL -->
        <div class="col-md-12" id="div_detail" style="display: none;">
          <div class="card">
            <!-- Header -->
              <div class="card-header">
                <h3 class="card-title">Perbaikan Detail</h3>
              </div>
            <!-- Header -->
            <!-- Body -->
              <div class="card-body">
                <!-- Table -->
                  <table id="table_detail" class="table table-bordered table-striped" width="100%">
                    <thead>
                      <tr>
                        <th>Waktu Mulai</th>
                        <th>Waktu Selesai</th>
                        <th>Persen (%)</th>
                        <th>Keterangan</th>
                        <th>Detail</th>
                      </tr>
                    </thead>
                  </table>
                <!-- Table -->
              </div>
            <!-- Body -->
          </div>
        </div>
      <!-- DIV PERABAIKAN DETAIL -->
      <!-- DIV PERABAIKAN TEKNISI -->
        <div class="col-md-12" id="div_teknisi" style="display: none;">
          <div class="card">
            <!-- Header -->
              <div class="card-header">
                <h3 class="card-title">Perbaikan Teknisi</h3>
              </div>
            <!-- Header -->
            <!-- Body -->
              <div class="card-body">
                <!-- Table -->
                  <table id="table_teknisi" class="table table-bordered table-striped" width="100%">
                    <thead>
                      <tr>
                        <th>Jenis Teknisi</th>
                        <th>Nama Teknisi</th>
                      </tr>
                    </thead>
                  </table>
                <!-- Table -->
              </div>
            <!-- Body -->
          </div>
        </div>
      <!-- DIV PERABAIKAN TEKNISI -->
    </div>
  </div>
</section>

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
            {
              "render": function ( data, type, full, meta ) {
                return '<center><a href="javascript:;" id="'+full.perbaikan_id+'" title="Edit" onclick="fun_detail(this.id)"><i class="fa fa-search"></i></a></center>';
              }
            },
          ]
      });
    /* Isi Table */

    /* Isi Table Material */
      $('#table_material').DataTable({
        "scrollX": true,
        "ajax": {
            "url": "perbaikan/getEasyuiMaterial",
            "dataSrc": ""
          },
          "columns": [
            {"data": "material_nomer"},
            {"data": "material_nama"},
            {"data": "material_jumlah"},
            {"data": "material_spesifikasi"},
          ]
      });
    /* Isi Table Material */

    /* Isi Table Detail */
      $('#table_detail').DataTable({
        "scrollX": true,
        "ajax": {
            "url": "perbaikan/getEasyuiProgress",
            "dataSrc": ""
          },
          "columns": [
            {"data": "waktu_mulai"},
            {"data": "waktu_selesai"},
            {"data": "perbaikan_detail_progress"},
            {"data": "perbaikan_detail_keterangan"},
            {
              "render": function ( data, type, full, meta ) {
                return '<center><a href="javascript:;" id="'+full.perbaikan_detail_id+'" title="Detail" onclick="fun_teknisi(this.id)"><i class="fa fa-search"></i></a></center>';
              }
            },
          ]
      });
    /* Isi Table Detail */

    /* Isi Table Teknisi */
      $('#table_teknisi').DataTable({
        "scrollX": true,
        "ajax": {
            "url": "perbaikan/getEasyuiTeknisi",
            "dataSrc": ""
          },
          "columns": [
            {"data": "regu_nama"},
            {"data": "teknisi_nama"},
          ]
      });
    /* Isi Table Teknisi */
  });

  $("#filter").on("submit", function (e) {
    e.preventDefault();
    $('#table').DataTable().ajax.url('perbaikan/getPerbaikan?'+$('#filter').serialize()).load();
    $('#div_material').css('display', 'none');
    $('#div_detail').css('display', 'none');
    $('#div_teknisi').css('display', 'none');
  });

  function fun_cetak() {
    window.open('perbaikan/laporan_perbaikan_cetak?'+$('#filter').serialize(), '_blank');
  }

  function fun_detail(id) {
    $('#table_material').DataTable().ajax.url('perbaikan/getEasyuiMaterial?id_perbaikan='+id).load();
    $('#table_detail').DataTable().ajax.url('perbaikan/getEasyuiProgress?id_perbaikan='+id).load();
    $('#div_material').css('display', 'block');
    $('#div_detail').css('display', 'block');
    $('#div_teknisi').css('display', 'none');
  }

  function fun_teknisi(id) {
    $('#table_teknisi').DataTable().ajax.url('perbaikan/getEasyuiTeknisi?id_perbaikan_detail='+id).load();
    $('#div_teknisi').css('display', 'block');
  }
</script>