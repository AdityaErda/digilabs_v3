<script type="text/javascript">
  $(function() {
    fun_loading();

    $('#penyimpanan_aset').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url('master/penyimpanan_barang/getAset') ?>',
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
    
    $('#penyimpanan_status').select2({
      placeholder: 'Pilih'
    });
 
    $('.select2-selection').css('height', '37px');
    $('.select2').css('width', '100%');

    /* Isi Table */
    $('#table thead tr').clone(true).addClass('filters').appendTo('#table thead');
      $('#table').DataTable({
      orderCellsTop: true,
      initComplete: function () {
        $('.dataTables_scrollHead').on('scroll', function () {
            $('.dataTables_scrollBody').scrollLeft($(this).scrollLeft());
        });
        var api = this.api();
        api.columns().eq(0).each(function (colIdx) {
          var cell = $('.filters th').eq($(api.column(colIdx).header()).index());
          var title = $(cell).text();
          $(cell).html('<input type="text" class="form-control" style="width:100%" placeholder="' + title + '" />');

          $('input', $('.filters th').eq($(api.column(colIdx).header()).index()))
          .off('keyup change')
          .on('keyup change', function (e) {
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
        "url": "<?= base_url('master/penyimpanan_barang/getPenyimpananBarang') ?>",
        "dataSrc": ""
      },
      "columns": [{
          "data": "aset_nama"
        },
        {
          "data": "penyimpanan_status"
        },
        {
          "render": function(data, type, full, meta) {
            return full.when_create + ' - ' + full.who_create;
          }
        },
        {
          "render": function(data, type, full, meta) {
            return '<center><a href="javascript:;" id="' + full.penyimpanan_id + '" title="Edit" onclick="fun_edit(this.id)"><i class="fa fa-edit" data-toggle="modal" data-target="#modal" style="color: orange;"></i></a></center>';
          }
        },
        {
          "render": function(data, type, full, meta) {
            return '<center><a href="javascript:;" id="' + full.penyimpanan_id + '" title="Edit" onclick="fun_delete(this.id)"><i class="fa fa-trash" style="color: red;"></i></a></center>';
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
        $.getJSON('<?= base_url('master/penyimpanan_barang/getPenyimpananBarang') ?>', {
          penyimpanan_id: id
        }, function(json) {
          $.each(json, function(index, val) {
            $('#' + index).val(val);
          });

          $('#penyimpanan_aset').append('<option selected value="' + json.penyimpanan_aset + '">' + json.aset_nama + '</option>');
          $('#penyimpanan_aset').select2('data', {
            id: json.penyimpanan_aset,
            text: json.aset_nama
          });
          $('#penyimpanan_aset').trigger('change');

          $('#penyimpanan_status').append('<option selected value="' + json.penyimpanan_status + '">' + json.penyimpanan_status + '</option>');
          $('#penyimpanan_status').select2('data', {
            id: json.penyimpanan_status,
            text: json.penyimpanan_status
          });
          $('#penyimpanan_status').trigger('change');
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
        if ($('#penyimpanan_id').val() != '') var url = '<?= base_url('master/penyimpanan_barang/updatePenyimpananBarang') ?>'; 
        else var url = '<?= base_url('master/penyimpanan_barang/insertPenyimpananBarang') ?>';

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
          $.get('<?= base_url('master/penyimpanan_barang/deletePenyimpananBarang') ?>', {
            penyimpanan_id: id
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
          $.get('<?= base_url('master/penyimpanan_barang/resetPenyimpananBarang') ?>', {
            penyimpanan_id: 'id'
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
    $("#penyimpanan_aset").empty();
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