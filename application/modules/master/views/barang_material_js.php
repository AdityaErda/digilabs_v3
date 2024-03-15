<script type="text/javascript">
  $(function () {
    fun_loading();

    /* Isi Table */ 
      $('#table thead tr').clone(true).addClass('filters').appendTo('#table thead');
      $('#table').DataTable({
        orderCellsTop: true,
        initComplete: function () {
          $('.dataTables_scrollHead').on('scroll', function () {
              $('.dataTables_scrollBody').scrollLeft($(this).scrollLeft());
          });
          var api = this.api();
          // For each column
          api.columns().eq(0).each(function (colIdx) {
            // Set the header cell to contain the input element
            var cell = $('.filters th').eq(
                $(api.column(colIdx).header()).index()
            );
            var title = $(cell).text();
            $(cell).html('<input type="text" class="form-control" style="width:100%" placeholder="' + title + '" />');
            // On every keypress in this input
            $('input',$('.filters th').eq($(api.column(colIdx).header()).index())).off('keyup change').on('keyup change', function (e) {
              e.stopPropagation();
              // Get the search value
              $(this).attr('title', $(this).val());
              var regexr = '({search})'; //$(this).parents('th').find('select').val();
              var cursorPosition = this.selectionStart;
              // Search the column for that value
              api.column(colIdx).search(
                  this.value != ''? regexr.replace('{search}', '(((' + this.value + ')))'): '',
                  this.value != '',
                  this.value == ''
              ).draw();
              $(this).focus()[0].setSelectionRange(cursorPosition, cursorPosition);
            });
          });
        },
        "scrollX": true,
        "lengthMenu":[[5,10,25,50,-1],[5,10,25,50,"All"]],
        "dom": 'lBfrtip',
        "buttons": ["csv", "pdf", "excel","copy","print"],
        "ajax": {
            "url": "<?= base_url() ?>/master/barang_material/getBarangMaterial",
            "dataSrc": ""
          },
          "fnRowCallback": function( data, type, full, meta ) {
            $(data).attr('class', 'warna');;
          },
          "columns": [
            {"data" : "item_kode"},
            {"data" : "item_nama"},
            {"data" : "item_katalog_number"},
            {"data" : "item_merk"},
            {"data" : "jenis_nama"},
            {"data" : "gl_account_nama"},
            {"data" : "item_harga", render: $.fn.dataTable.render.number( '.', ',', 2, 'Rp. '), className: "kanan"},
            {"data" : "item_satuan"},
            {"data" : "item_stok"},
            {"data" : "item_stok_alert"},
            {"render": function ( data, type, full, meta ) {
              return full.when_create+' - '+full.who_create;
              }
            },
            {"render": function ( data, type, full, meta ) {
              var tombol = '<div class="input-group-prepend"><button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Action</button><div class="dropdown-menu" style="height:auto;max-height: 100px;overflow-x:hidden;"><a class="dropdown-item" href="#" id="'+full.item_id+'" onclick="fun_detail(this.id)">Detail</a><a class="dropdown-item" href="#" id="'+full.item_id+'" onclick="fun_history(this.id)">History</a><a class="dropdown-item" href="#" id="'+full.item_id+'" onclick="fun_edit(this.id)" data-toggle="modal" data-target="#modal">Edit</a><a class="dropdown-item" href="#" id="'+full.item_id+'" onclick="fun_delete(this.id)">Hapus</a></div></div>';
              return tombol;
            }},
          ]
      }).columns.adjust();
    /* Isi Table */

    /* Isi Table Detail */ 
      $('#table_detail thead tr').clone(true).addClass('filters_detail').appendTo('#table_detail thead');
      $('#table_detail').DataTable({
        orderCellsTop: true,
        initComplete: function () {
          var api = this.api();
          api.columns().eq(0).each(function (colIdx) {
            var cell = $('.filters_detail th').eq($(api.column(colIdx).header()).index());
            var title = $(cell).text();
            $(cell).html('<input type="text" class="form-control" style="width:100%" placeholder="' + title + '" />')
            .find('input')
            .off('keyup change')
            .on('keyup change', function (e) {
              e.stopPropagation();
              $(this).attr('title', $(this).val());
              var regexr = '({search})';
              var cursorPosition = this.selectionStart;
              api.column(colIdx).search(
                  this.value != '' ? regexr.replace('{search}', '(((' + this.value + ')))') : '',
                  this.value != '',
                  this.value == ''
              ).draw();
              $(this).focus()[0].setSelectionRange(cursorPosition, cursorPosition);
            });
          });
        },
        "scrollX": true,
        "lengthMenu":[[5,10,25,50,-1],[5,10,25,50,"All"]],
        "ajax": {
          "url": "<?= base_url('master/barang_material/getKomposisi?item_id=0') ?>",
          "dataSrc": ""
        },
        "columns": [
          {"data" : "nama_item"},
          {"data" : "komposisi_persen"},
          {"data" : "komposisi_harga"},
          {"render": function ( data, type, full, meta ) {
            return full.when_create+' - '+full.who_create;
            }
          },
          {"render": function ( data, type, full, meta ) {
            return '<center><a href="javascript:;" id="'+full.komposisi_id+'" title="Edit" onclick="fun_edit_detail(this.id)"><i class="fa fa-edit" data-toggle="modal" data-target="#modal_detail" style="color: orange;"</i></a></center>';
            }
          },
          {"render": function ( data, type, full, meta ) {
            return '<center><a href="javascript:;" id="'+full.komposisi_id+'" title="Edit" onclick="fun_delete_detail(this.id)"><i class="fa fa-trash" style="color: red;"></i></a></center>';
            }
          },
        ]
      });
    /* Isi Table Detail */

    /* Isi Table History */ 
      $('#table_history').DataTable({
        "scrollX": true,
        "ordering": false,
        "ajax": {
          "url": "<?= base_url('master/barang_material/getHistory?item_id=0') ?>",
          "dataSrc": ""
        },
        "columns": [
          {render: function ( data, type, full, meta ) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }},
          {"data" : "barang_harga"},
          {"render": function ( data, type, full, meta ) {
            return full.log_who+' - '+full.log_when;
            }
          },
        ]
      });
    /* Isi Table History */

    /* Select2 */
      $('#jenis_id').select2({
        placeholder: 'Pilih',
        ajax: {
          delay: 250,
          url: '<?= base_url('master/barang_material/getJenis') ?>',
          dataType: 'json',
          type: 'GET',
          data: function (params) {
            var queryParameters = {
              material_nama: params.term
            }

            return queryParameters;
          }
        }
      });

      $('#gl_account_id').select2({
        placeholder: 'Pilih',
        ajax: {
          delay: 250,
          url: '<?= base_url('master/barang_material/getGlAccount') ?>',
          dataType: 'json',
          type: 'GET',
          data: function (params) {
            var queryParameters = {
              gl_account_nama: params.term
            }

            return queryParameters;
          }
        }
      });

      $('#komposisi_item').select2({
        placeholder: 'Pilih',
        ajax: {
          delay: 250,
          url: '<?= base_url('master/barang_material/getItem') ?>',
          dataType: 'json',
          type: 'GET',
          data: function (params) {
            var queryParameters = {
              item_nama: params.term
            }

            return queryParameters;
          }
        }
      });

      $('.select2-selection').css('height', '37px');
      $('.select2').css('width', '100%');
    /* Select2 */
  });

  /* View Update */
  function fun_edit(id) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
    if(!json.user_id){
      fun_notifLogout();
    }else{
      $('#simpan').css('display', 'none');
      $('#edit').css('display', 'block');
      $.getJSON('<?= base_url('master/barang_material/getBarangMaterial') ?>', {item_id: id}, function(json) {
        $('#stok_awal').val(json.item_stok);

        $.each(json, function(index, val) {
          $('#'+index).val(val);
        });

        $('#stok_alert').val(json.item_stok_alert);

        $('#jenis_id').append('<option selected value="'+json.jenis_id+'">'+json.jenis_nama+'</option>');
        $('#jenis_id').select2('data', {id:json.jenis_id, text:json.jenis_nama});
        $('#jenis_id').trigger('change');

        $('#gl_account_id').append('<option selected value="'+json.gl_account_id+'">'+json.gl_account_nama+'</option>');
        $('#gl_account_id').select2('data', {id:json.gl_account_id, text:json.gl_account_nama});
        $('#gl_account_id').trigger('change');
      });
    }
  });
  }
  /* View Update */

  /* Proses */
  $("#form_modal").on("submit", function (e) {
    e.preventDefault();
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if(!json.user_id){
        fun_notifLogout();
      }else{
        if ($('#item_id').val() != '') var url = '<?= base_url('master/barang_material/updateBarangMaterial') ?>';
        else var url = '<?= base_url('master/barang_material/insertBarangMaterial') ?>';

        e.preventDefault();
        $.ajax({
          url:url,
          data:$('#form_modal').serialize(),
          type:'POST',
          dataType: 'html',
          success:function(isi) {
            $('#close').click();
            toastr.success('Berhasil');
          }
        });
      }
    })
  });
  /* Proses */

  /* Fun Delete */
  function fun_delete(id) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if(!json.user_id){
        fun_notifLogout();
      }else{
       $.confirmModal('Apakah anda yakin akan menghapusnya?', function(el) {
          $.get('<?= base_url('master/barang_material/deleteBarangMaterial') ?>', {item_id: id}, function(data) {
            $('#close').click();
            toastr.success('Berhasil');
          });
        });
      }
    })
  }
  /* Fun Delete */
  /* Fun Reset */
  function fun_reset() {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if(!json.user_id){
        fun_notifLogout();
      }else{
       $.confirmModal('Apakah anda yakin akan mereset seluruh data barang material?', function(el) {
          $.get('<?= base_url('master/barang_material/resetBarangMaterial') ?>', {item_id: 'id'}, function(data) {
            $('#close').click();
            toastr.success('Berhasil');
          });
        });
      }
    })
  }
  /* Fun Reset */

  /* Fun Close */
    function fun_close() {
      $('#simpan').css('display', 'block');
      $('#edit').css('display', 'none');
      $('#form_modal')[0].reset();
      $("#jenis_id").empty();
      $("#gl_account_id").empty();
      $('#table').DataTable().ajax.reload();
      $('#table_detail').DataTable().ajax.reload();
      fun_loading();
    }
  /* Fun Close */

  $('#modal').on('hidden.bs.modal', function (e) {
    fun_close();
  });

  /* Fun History */
  function fun_history (id) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if(!json.user_id){
        fun_notifLogout();
      }else{
        $('#div_history').css('display', 'block');
        $('#div_detail').css('display', 'none');
        $('#table_history').DataTable().ajax.url('<?= base_url('master/barang_material/getHistory?item_id=') ?>'+id).load();
        $('#id_item').val(id);
        $('html, body').animate({
          scrollTop: $("#div_history").offset().top
        }, 10);

        $.ajax({
          url: "<?= base_url('master/barang_material/getHistory?item_id=') ?>"+id,
          method: "GET",
          async: true,
          dataType: 'json',
          success: function(isi) {
            var label = [];
            var value = []

            $.each(isi, function(index, val) {
              label.push(val.log_when);
              value.push(val.barang_harga);
            });

            $('#myChart').remove();
            $('#div_myChart').append('<canvas id="myChart" style="width: 100%;"></canvas>');
            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, {
              type: 'line',
              data: {
                labels: label,
                datasets: [{
                  label: 'History',
                  data: value,
                  backgroundColor: ['rgba(255, 99, 132, 0.2)'],
                  borderColor: ['rgba(255, 99, 132, 1)'],
                  borderWidth: 1
                }]
              },
              options: {
                scales: {
                  y: {
                    beginAtZero: true
                  }
                }
              }
            });
          }
        });
      }
    })
  }
  /* Fun History */

  /* Fun Detail */
  function fun_detail (id) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if(!json.user_id){
        fun_notifLogout();
      }else{
        $('#div_history').css('display', 'none');
        $('#div_detail').css('display', 'block');
        $('#table_detail').DataTable().ajax.url('<?= base_url('master/barang_material/getKomposisi?item_id=') ?>'+id).load();
        $('#id_item').val(id);
        $('html, body').animate({
          scrollTop: $("#div_detail").offset().top
        }, 10);
        setTimeout(function() {$('.warna').removeAttr('style')}, 500);
        setTimeout(function() {$('#'+id).parents('tr').attr('style','color: red')}, 1000);
      }
    })
  }
  /* Fun Detail */

  /* Fun Tambah Detail */
  function fun_tambah_detail() {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if(!json.user_id){
        fun_notifLogout();
      }else{
        $('#temp_item_id').val($('#id_item').val());
      }
    })
  }
  /* Fun Tambah Detail */

  /* View Update Detail */
  function fun_edit_detail(id) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if(!json.user_id){
        fun_notifLogout();
      }else{
        $('#simpan_detail').css('display', 'none');
        $('#edit_detail').css('display', 'block');
        $.getJSON('<?= base_url('master/barang_material/getKomposisi') ?>', {komposisi_id: id}, function(json) {
          $.each(json, function(index, val) {
            $('#'+index).val(val);
          });
          $('#temp_item_id').val(json.item_id);

          $('#komposisi_item').append('<option selected value="'+json.komposisi_item+'">'+json.nama_item+' - '+json.harga_item+'</option>');
          $('#komposisi_item').select2('data', {id:json.komposisi_item, text:json.nama_item+' - '+json.harga_item});
          $('#komposisi_item').trigger('change');
        });
      }
    })
  }
  /* View Update Detail */

  /* Proses Detail */
  $("#form_modal_detail").on("submit", function (e) {
    e.preventDefault();
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
    if(!json.user_id){
      fun_notifLogout();
    }else{
      if ($('#komposisi_id').val() != '') var url = '<?= base_url('master/barang_material/updateKomposisi') ?>';
      else var url = '<?= base_url('master/barang_material/insertKomposisi') ?>';

      e.preventDefault();
      $.ajax({
        url:url,
        data:$('#form_modal_detail').serialize(),
        type:'POST',
        dataType: 'html',
        success:function(isi) {
          $('#close_detail').click();
          toastr.success('Berhasil');
        }
      });
      }
    })
  });
  /* Proses Detail */

  /* Fun Delete Detail */
  function fun_delete_detail(id) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if(!json.user_id){
        fun_notifLogout();
      }else{
        $.confirmModal('Apakah anda yakin akan menghapusnya?', function(el) {
          $.get('<?= base_url('master/barang_material/deleteKomposisi') ?>', {komposisi_id: id}, function(data) {
            $('#close_detail').click();
            toastr.success('Berhasil');
          });
        });
      }
    })
  }
  /* Fun Delete Detail */

  /* Fun Close Detail */
  function fun_close_detail() {
    $('#simpan_detail').css('display', 'block');
    $('#edit_detail').css('display', 'none');
    $("#komposisi_item").empty();
    $('#form_modal_detail')[0].reset();
    $('#table_detail').DataTable().ajax.reload();
    $('#table').DataTable().ajax.reload();
    fun_loading();
  }
  /* Fun Close Detail */

  $('#modal_detail').on('hidden.bs.modal', function (e) {
    fun_close_detail();
  });

  function fun_loading() {
    var simplebar = new Nanobar();
    simplebar.go(100);
  }
</script>