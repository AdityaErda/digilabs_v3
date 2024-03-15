<script type="text/javascript">
  $(function() {
    fun_loading();

    /* Isi Table */
    $('#table thead tr').clone(true).addClass('filters').appendTo('#table thead');
    $('#table').DataTable({
    orderCellsTop: true,
    initComplete: function() {
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
      "lengthMenu": [
        [5, 10, 25, 50, -1],
        [5, 10, 25, 50, "All"]
      ],
      "dom": 'lBfrtip',
      "buttons": ["csv", "pdf", "excel", "copy", "print"],
      "ajax": {
        "url": "<?= base_url() ?>api/unit_kerja/getUnitKerja",
        "dataSrc": ""
      },
      "columns": [{
          "data": "unit_kerja_nama"
        },
        {
          "data": "unit_kerja_parent"
        },
        {
          "data": "unit_kerja_level"
        },
      ]
    });
    /* Isi Table */
  });

  /* View Update */
  function fun_edit(id) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $('#simpan').css('display', 'none');
        $('#edit').css('display', 'block');
        $.getJSON('<?= base_url('master/peminta_jasa/getPemintaJasa') ?>', {
          peminta_jasa_id: id
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
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        if ($('#peminta_jasa_id').val() != '') var url = '<?= base_url('master/peminta_jasa/updatePemintaJasa') ?>';
        else var url = '<?= base_url('master/peminta_jasa/insertPemintaJasa') ?>';

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
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $.confirmModal('Apakah anda yakin akan menghapusnya?', function(el) {
          $.get('<?= base_url('master/peminta_jasa/deletePemintaJasa') ?>', {
            peminta_jasa_id: id
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
  function fun_reset(id) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $.confirmModal('Apakah anda yakin akan reset data?', function(el) {
          $.get('<?= base_url('master/peminta_jasa/resetPemintaJasa') ?>', function(data) {
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