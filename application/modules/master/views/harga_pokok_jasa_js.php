<script type="text/javascript">

// default toFixed() method
// 2 decimal places
  $(function() {
    fun_loading();

    $('#id_item').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url('master/harga_pokok_jasa/getBarangMaterial') ?>',
        dataType: 'json',
        type: 'GET',
        data: function(params) {
          var queryParameters = {
            item_nama: params.term
          }
          return queryParameters;
        }
      }
    });

    $('#id_item').on('select2:select', function (e) {
        var data = e.params.data;
        let num = parseInt(data.harga);
        $('#penyimpanan_item_barang_harga_view').val('Rp '+ num.toLocaleString());
        $('#harga_item').val(data.harga);
        // $('#div_penyimpanan_item_barang_harga').css('display', 'block');
    });

    $('#id_aset').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url('master/harga_pokok_jasa/getAset') ?>',
        dataType: 'json',
        type: 'GET',
        data: function(params) {
          var queryParameters = {
            aset_nama: params.term
          }
          return queryParameters;
        }
      }
    });

    $('#id_aset').on('select2:select', function (e) {
        var data = e.params.data;        
        let num = parseInt(data.harga);
        $('#penyimpanan_aset_harga_view').val('Rp '+ num.toLocaleString());
        $('#harga_aset').val(data.harga);
        // $('#div_penyimpanan_aset_harga').css('display', 'block');
    });

    /* Jenis Diklik */
    $('#penyimpanan_jenis_sample').on('select2:select', function (e) {
        var data = e.params.data;
        fun_identitas(data.id);
    });

    $('#penyimpanan_jenis_sample').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url('master/harga_pokok_jasa/getJenisSampleUji') ?>',
        dataType: 'json',
        type: 'GET',
        data: function(params) {
          var queryParameters = {
            jenis_nama: params.term
          }
          return queryParameters;
        }
      }
    });
    
    /* Jenis Diklik */
    $('#penyimpanan_jenis_sample').on('select2:select', function (e) {
        var data = e.params.data;
        fun_identitas(data.id);
        $('#penyimpanan_jenis_sample_det_harga_view').val('');
        $('#harga_sample').val(0);
    });
    /* Jenis Diklik */

    /* Identitas */
    $('#id_sample').select2({
        placeholder: 'Pilih Jenis Sample Dahulu',
    });
    /* Identitas */

    /* Fun Identitas */
    function fun_identitas(id) {
        $('#id_sample').select2({
            placeholder: 'Pilih',
            ajax: {
                delay: 250,
                url: '<?= base_url('master/harga_pokok_jasa/getSampleIdentitas?jenis_id=') ?>'+id,
                // url: 'http://103.157.97.200/digilab/sample/request/getSampleIdentitas?jenis_id='+id,
                dataType: 'json',
                type: 'GET',
                data: function (params) {
                    var queryParameters = {
                        identitas_nama: params.term
                    }
                    return queryParameters;
                }
            }
        });
        
        $('.select2-selection').css('height', '37px');
        $('.select2').css('width', '100%');
    }   
  /* Fun Identitas */

    $('#id_sample').on('select2:select', function (e) {
        var data = e.params.data;
        let num = parseInt(data.harga);
        $('#penyimpanan_jenis_sample_det_harga_view').val('Rp '+ (num == NaN) ? 0 : num.toLocaleString());
        $('#harga_sample').val(data.harga);
        // $('#div_penyimpanan_jenis_sample_det_harga').css('display', 'block');
    });
        

    $('.select2-selection').css('height', '37px');
    $('.select2').css('width', '100%');

    /* Isi Table */
    $('#table thead tr').clone(true).addClass('filters').appendTo('#table thead');
    $('#table').DataTable({
    orderCellsTop: true,
    initComplete: function() {
      $('.dataTables_scrollHead').on('scroll', function () {
          $('.dataTables_scrollBody').scrollLeft($(this).scrollLeft());
      });
      var api = this.api();
      api.columns().eq(0).each(function(colIdx) {
        var cell = $('.filters th').eq($(api.column(colIdx).header()).index());
        var title = $(cell).text();
        $(cell).html('<input type="text" class="form-control" style="width:100%" placeholder="' + title + '" />');

        $('input', $('.filters th').eq($(api.column(colIdx).header()).index()))
          .off('keyup change')
          .on('keyup change', function(e) {
              e.stopPropagation();
              $(this).attr('title', $(this).val());
              var regexr = '({search})';
              var cursorPosition = this.selectionStart;
              api.column(colIdx)
                  .search(this.value != '' ? regexr.replace('{search}', '(((' + this.value + ')))') : '', this.value != '', this.value == '')
                  .draw();
              $(this).focus()[0].setSelectionRange(cursorPosition, cursorPosition);
          });
        });
      },
      "scrollX": true,
      "lengthMenu":[[5,10,25,50,-1],[5,10,25,50,"All"]],
      "dom": 'lBfrtip',
      "buttons": ["csv", "pdf", "excel","copy","print"],
      "ajax": {
        "url": "<?= base_url('master/harga_pokok_jasa/getHargaPokokJasa') ?>",
        "dataSrc": ""
      },
      "columns": [{
          "data": "item_nama"
        },
        {"data" : "harga_item", render: $.fn.dataTable.render.number( '.', ',', 2, 'Rp. '), className: "kanan"},
        {"data" : "harga_aset", render: $.fn.dataTable.render.number( '.', ',', 2, 'Rp. '), className: "kanan"},
        {"data" : "harga_sample", render: $.fn.dataTable.render.number( '.', ',', 2, 'Rp. '), className: "kanan"},
        {"data" : "harga_total", render: $.fn.dataTable.render.number( '.', ',', 2, 'Rp. '), className: "kanan"},
        {
          "render": function(data, type, full, meta) {
            return full.when_create + ' - ' + full.who_create;
          }
        },
        {
          "render": function(data, type, full, meta) {
            return '<center><a href="javascript:;" id="' + full.harga_pokok_jasa_id + '" title="Edit" onclick="fun_edit(this.id)"><i class="fa fa-edit" data-toggle="modal" data-target="#modal" style="color: orange;"></i></a></center>';
          }
        },
        {
          "render": function(data, type, full, meta) {
            return '<center><a href="javascript:;" id="' + full.harga_pokok_jasa_id + '" title="Edit" onclick="fun_delete(this.id)"><i class="fa fa-trash" style="color: red;"></i></a></center>';
          }
        },
      ]
    });
    /* Isi Table */
  });

  /* View Update */
  function fun_edit(id) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if(!json.user_id){
        fun_notifLogout();
      }else{
        $('#simpan').css('display', 'none');
        $('#edit').css('display', 'block');
        $.getJSON('<?= base_url('master/harga_pokok_jasa/getHargaPokokJasa') ?>', {
          harga_pokok_jasa_id: id
        }, function(json) {
          $.each(json, function(index, val) {
            $('#' + index).val(val);
          });
          let harga_item = parseInt(json.harga_item); 
          let harga_aset = parseInt(json.harga_aset); 
          let harga_sample = parseInt(json.harga_sample); 
          $('#penyimpanan_item_barang_harga_view').val('Rp '+harga_item.toLocaleString());
          $('#penyimpanan_aset_harga_view').val('Rp '+harga_aset.toLocaleString());
          $('#penyimpanan_jenis_sample_det_harga_view').val('Rp '+harga_sample.toLocaleString());

          $('#id_item').append('<option selected value="' + json.item_id + '">' + json.item_nama + '</option>');
          $('#id_item').select2('data', {
            id: json.item_id,
            text: json.itemt_nama
          });
          $('#id_item').trigger('change');

          $('#id_aset').append('<option selected value="' + json.aset_id + '">' + json.aset_nama + '</option>');
          $('#id_aset').select2('data', {
            id: json.aset_id,
            text: json.aset_nama
          });

          $('#penyimpanan_jenis_sample').trigger('change');
          $('#penyimpanan_jenis_sample').append('<option selected value="' + json.jenis_id + '">' + json.jenis_nama + '</option>');
          $('#penyimpanan_jenis_sample').select2('data', {
            id: json.jenis_id,
            text: json.jenis_nama
          });
          $('#penyimpanan_jenis_sample').trigger('change');

          $('#id_sample').trigger('change');
          $('#id_sample').append('<option selected value="' + json.id_sample + '">' + json.identitas_nama + '</option>');
          $('#id_sample').select2('data', {
            id: json.id_sample,
            text: json.aset_nama
          });
          $('#id_sample').trigger('change');
        });
      }
    });
  }
  /* View Update */

  /* Proses */
  $("#form_modal").on("submit", function(e) {
    e.preventDefault(); 
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if(!json.user_id){
        fun_notifLogout();
      }else{
        if ($('#harga_pokok_jasa_id').val() != '') var url = '<?= base_url('master/harga_pokok_jasa/updateHargaPokokJasa') ?>'; 
        else var url = '<?= base_url('master/harga_pokok_jasa/insertHargaPokokJasa') ?>';

        e.preventDefault();
        $.ajax({
          url: url,
          data: $('#form_modal').serialize(),
          type: 'POST',
          dataType: 'html',
          success: function(isi) {
            $('#close').click();
            toastr.success('Berhasil');
          }
        });
      }
    });
  });
  /* Proses */

  /* Fun Delete */
  function fun_delete(id) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if(!json.user_id){
        fun_notifLogout();
      }else{
        $.confirmModal('Apakah anda yakin akan menghapusnya?', function(el) {
          $.get('<?= base_url('master/harga_pokok_jasa/deleteHargaPokokJasa') ?>', {
            harga_pokok_jasa_id: id
          }, function(data) {
            $('#close').click();
            toastr.success('Berhasil');
          });
        });
      }
    });
  }
  /* Fun Delete */

  /* Fun Reset */
  function fun_reset() {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if(!json.user_id){
        fun_notifLogout();
      }else{
        $.confirmModal('Apakah anda yakin akan mereset seluruh data jenis barang ?', function(el) {
          $.get('<?= base_url('master/harga_pokok_jasa/resetHargaPokokJasa') ?>', {
            harga_pokok_jasa_id: 'id'
          }, function(data) {
            $('#close').click();
            toastr.success('Berhasil');
          });
        });
      }
    });
  }
  /* Fun Reset */
  /* Fun Close */
  function fun_close() {
    $('#simpan').css('display', 'block');
    $('#edit').css('display', 'none');
    $('#form_modal')[0].reset();
    $("#id_item").empty();
    $("#id_aset").empty();
    $("#penyimpanan_jenis_sample").empty();
    $("#id_sample").empty();
    $("#penyimpanan_status").empty();
    $('#table').DataTable().ajax.reload();
    fun_loading();
  }
  /* Fun Close */

  $('#modal').on('hidden.bs.modal', function(e) {
    fun_close();
  });

  function fun_loading() {
    var simplebar = new Nanobar();
    simplebar.go(100);
  }
</script>