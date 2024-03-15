<script type="text/javascript">
  $(function() {
    fun_loading();

    /* Isi Table */
    $('#table thead tr').clone(true).addClass('filters').appendTo('#table thead');
    $('#table').DataTable({
      orderCellsTop: true,
      initComplete: function() {
        $('.dataTables_scrollHead').on('scroll', function() {
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
      "lengthMenu": [
          [5, 10, 25, 50, -1],
          [5, 10, 25, 50, "All"]
      ],
      // "dom": 'lBfrtip',
      // "buttons": ["csv", "pdf", "excel", "copy", "print"],
      "ajax": {
          "url": "<?= base_url() ?>/master/keterangan_sertifikat/getKeteranganSertifikat",
          "dataSrc": ""
      },
      "columns": [{
              render: function(data, type, full, meta) {
                  return meta.row + meta.settings._iDisplayStart + 1;
              }
          },
          // {
          //     "render": function(data, type, row, meta) {
          //         return (row.is_bahasa == 'y') ? '<span style="background-color:aqua" class="badge">' + row.keterangan_isi + '</span>' : row.keterangan_isi;
          //     }
          // },
          {
              "data": "keterangan_sertifikat_isi"
          },
          {
              "render": function(data, type, full, meta) {
                  return '<center><a href="javascript:;" id="' + full.keterangan_sertifikat_id + '" title="Edit" onclick="fun_edit(this.id)"><i class="fa fa-edit" data-toggle="modal" data-target="#modal" style="color: orange"></i></a></center>';
              }
          },
          {
              "render": function(data, type, full, meta) {
                  return '<center><a href="javascript:;" id="' + full.keterangan_sertifikat_id + '" title="Hapus" onclick="fun_delete(this.id)"><i class="fa fa-trash" style="color: red"></i></a></center>';
              }
          },
      ]
    });
    /* Isi Table */
  });

  /* Proses */
  $("#form_modal").on("submit", function(e) {
    e.preventDefault();
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
          fun_notifLogout();
      } else {
        if ($('#keterangan_sertifikat_id').val() != '') var url = '<?= base_url('master/keterangan_sertifikat/updateKeteranganSertifikat') ?>';
        else var url = '<?= base_url('master/keterangan_sertifikat/insertKeteranganSertifikat') ?>';

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

  /* View Update */
  function fun_edit(id) {
      $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
          if (!json.user_id) {
              fun_notifLogout();
          } else {
              $('#simpan').css('display', 'none');
              $('#edit').css('display', 'block');
              $.getJSON('<?= base_url('master/keterangan_sertifikat/getKeteranganSertifikat') ?>', {
                  keterangan_sertifikat_id: id
              }, function(json) {
                  $.each(json, function(index, val) {
                      $('#' + index).val(val);
                  });
              });
          }
      });
  }
  /* View Update */

  /* Fun Delete */
  function fun_delete(id) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
          fun_notifLogout();
      } else {
        $.confirmModal('Apakah anda yakin akan menghapusnya?', function(el) {
            $.get('<?= base_url('master/keterangan_sertifikat/deleteKeteranganSertifikat') ?>', {
                keterangan_sertifikat_id: id
            }, function(data) {
                $('#close').click();
                toastr.success('Berhasil');
            });
        });
      }
    });
  }
  /* Fun Delete */

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