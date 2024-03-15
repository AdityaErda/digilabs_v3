<script type="text/javascript">
  $(function() {
    fun_loading();

    /* Isi Table */
    $('#table thead tr').clone(true).addClass('filters').appendTo('#table thead');
    $('#table').DataTable({
      orderCellsTop: true,
      initComplete: function () {
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
            api.column(colIdx).search(this.value != ''? regexr.replace('{search}', '(((' + this.value + ')))'): '',this.value != '',this.value == '').draw();
            $(this).focus()[0].setSelectionRange(cursorPosition, cursorPosition);
          });
        });
      },
      "lengthMenu":[[5,10,25,50,-1],[5,10,25,50,"All"]],
      "dom": 'lBfrtip',
      "buttons": ["csv", "pdf", "excel","copy","print"],
      "ajax": {
        "url": "<?= base_url('master/jenis_barang/getJenisBarang') ?>",
        "dataSrc": ""
      },
      "columns": [{
          "data": "jenis_kode"
        },
        {
          "data": "jenis_nama"
        },
        {
          "render": function(data, type, full, meta) {
            return full.when_create + ' - ' + full.who_create;
          }
        },
        {
          "render": function(data, type, full, meta) {
            return '<center><a href="javascript:;" id="' + full.jenis_id + '" title="Edit" onclick="fun_edit(this.id)"><i class="fa fa-edit" data-toggle="modal" data-target="#modal" style="color: orange;"></i></a></center>';
          }
        },
        {
          "render": function(data, type, full, meta) {
            return '<center><a href="javascript:;" id="' + full.jenis_id + '" title="Edit" onclick="fun_delete(this.id)"><i class="fa fa-trash" style="color: red;"></i></a></center>';
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
        $.getJSON('<?= base_url('master/jenis_barang/getJenisBarang') ?>', {
          jenis_id: id
        }, function(json) {
          $.each(json, function(index, val) {
            $('#' + index).val(val);
          });
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
        if ($('#jenis_id').val() != '') var url = '<?= base_url('master/jenis_barang/updateJenisBarang') ?>';
        else var url = '<?= base_url('master/jenis_barang/insertJenisBarang') ?>';

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
          $.get('<?= base_url('master/jenis_barang/deleteJenisBarang') ?>', {
            jenis_id: id
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
          $.get('<?= base_url('master/jenis_barang/resetJenisBarang') ?>', {
            jenis_id: 'id'
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