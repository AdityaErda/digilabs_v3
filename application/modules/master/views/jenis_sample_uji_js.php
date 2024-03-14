<script type="text/javascript">
  $(function() {
    fun_loading();

    /* Isi Table */
    $('#table thead tr').clone(true).addClass('filters').appendTo('#table thead');
    $('#table').DataTable({
      orderCellsTop: true,
      initComplete: function() {
        var api = this.api();

        // For each column
        api
          .columns()
          .eq(0)
          .each(function(colIdx) {
            // Set the header cell to contain the input element
            var cell = $('.filters th').eq(
              $(api.column(colIdx).header()).index()
            );
            var title = $(cell).text();
            $(cell).html('<input type="text" class="form-control" style="width:100%" placeholder="' + title + '" />');

            // On every keypress in this input
            $(
                'input',
                $('.filters th').eq($(api.column(colIdx).header()).index())
              )
              .off('keyup change')
              .on('keyup change', function(e) {
                e.stopPropagation();

                // Get the search value
                $(this).attr('title', $(this).val());
                var regexr = '({search})'; //$(this).parents('th').find('select').val();

                var cursorPosition = this.selectionStart;
                // Search the column for that value
                api
                  .column(colIdx)
                  .search(
                    this.value != '' ?
                    regexr.replace('{search}', '(((' + this.value + ')))') :
                    '',
                    this.value != '',
                    this.value == ''
                  )
                  .draw();

                $(this)
                  .focus()[0]
                  .setSelectionRange(cursorPosition, cursorPosition);
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
        "url": "<?= base_url() ?>/master/jenis_sample_uji/getJenisSampleUji",
        "dataSrc": ""
      },
      "columns": [{
          "data": "jenis_kode"
        },
        {
          "data": "jenis_nama"
        },
        {
          "data": "jenis_parameter"
        },
        {
          "data": "pengambil_sample"
        },
        {
          "data": "referensi_spesifikasi"
        },
        {
          "render": function(data, type, full, meta) {
            return full.when_create + ' - ' + full.who_create;
          }
        },
        {
          "render": function(data, type, full, meta) {
            return '<center><a href="javascript:;" id="' + full.jenis_id + '" title="Detail" onclick="fun_detail(this.id)"><i class="fa fa-search"></i></a></center>';
          }
        },
        {
          "render": function(data, type, full, meta) {
            return '<center><a href="javascript:;" id="' + full.jenis_id + '" title="Edit" onclick="fun_edit(this.id)"><i class="fa fa-edit" data-toggle="modal" data-target="#modal" style="color: orange"></i></a></center>';
          }
        },
        {
          "render": function(data, type, full, meta) {
            return '<center><a href="javascript:;" id="' + full.jenis_id + '" title="Hapus" onclick="fun_delete(this.id)"><i class="fa fa-trash" style="color: red"></i></a></center>';
          }
        },
      ]
    });
    /* Isi Table */

    /* Isi Table Detail */
    $('#table_detail thead tr').clone(true).addClass('filters_detail').appendTo('#table_detail thead');
    $('#table_detail').DataTable({
      orderCellsTop: true,
      initComplete: function() {
        var api = this.api();

        // For each column
        api
          .columns()
          .eq(0)
          .each(function(colIdx) {
            // Set the header cell to contain the input element
            var cell = $('.filters_detail th').eq(
              $(api.column(colIdx).header()).index()
            );
            var title = $(cell).text();
            $(cell).html('<input type="text" class="form-control" style="width:100%" placeholder="' + title + '" />');

            // On every keypress in this input
            $(
                'input',
                $('.filters_detail th').eq($(api.column(colIdx).header()).index())
              )
              .off('keyup change')
              .on('keyup change', function(e) {
                e.stopPropagation();

                // Get the search value
                $(this).attr('title', $(this).val());
                var regexr = '({search})'; //$(this).parents('th').find('select').val();

                var cursorPosition = this.selectionStart;
                // Search the column for that value
                api
                  .column(colIdx)
                  .search(
                    this.value != '' ?
                    regexr.replace('{search}', '(((' + this.value + ')))') :
                    '',
                    this.value != '',
                    this.value == ''
                  )
                  .draw();

                $(this)
                  .focus()[0]
                  .setSelectionRange(cursorPosition, cursorPosition);
              });
          });
      },
      "scrollX": true,
      "lengthMenu": [
        [5, 10, 25, 50, -1],
        [5, 10, 25, 50, "All"]
      ],
      "dom": 'lBfrtip',
      "buttons": [{
          extend: "csv",
          title: "Identitas"
        },
        {
          extend: "pdf",
          title: "Identitas"
        },
        {
          extend: "excel",
          title: "Identitas"
        },
        "copy",
        {
          extend: "print",
          title: "Identitas"
        }
      ],
      "ajax": {
        "url": "<?= base_url() ?>/master/jenis_sample_uji/getSampleIdentitas?identitas_id=0",
        "dataSrc": ""
      },
      "columns": [{
          "data": "identitas_nama"
        },
        {
          "data": "identitas_parameter"
        },
        {
          "data": "identitas_harga"
        },
        {
          "render": function(data, type, row, meta) {
            return "(Harga * Jumlah Tenaga Kerja) + Biaya Tambahan"
          }
        },
        {
          "data": "identitas_harga_total"
        },
         {
          "data": "batasan_minimal"
        },
        {
          "data": "batasan_maksimal"
        },
        {
          "data": "identitas_spesifikasi"
        },
        {
          "render": function(data, type, full, meta) {
            return full.when_create + ' - ' + full.who_create;
          }
        },
        {
          "render": function(data, type, full, meta) {
            return '<center><a href="javascript:;" id="' + full.identitas_id + '" title="Rumus Harga" onclick="fun_rumus(this.id)"><i class="fa fa-calculator" data-toggle="modal" data-target="#modal_rumus" style="color: grey"></i></a></center>';
          }
        },
        {
          "render": function(data, type, full, meta) {
            return '<center><a href="javascript:;" id="' + full.identitas_id + '" title="Edit" onclick="fun_edit_detail(this.id)"><i class="fa fa-edit" data-toggle="modal" data-target="#modal_detail" style="color: orange"></i></a></center>';
          }
        },
        {
          "render": function(data, type, full, meta) {
            return '<center><a href="javascript:;" id="' + full.identitas_id + '" title="Hapus" onclick="fun_delete_detail(this.id)"><i class="fa fa-trash" style="color: red"></i></a></center>';
          }
        },
      ]
    });
    /* Isi Table Detail */

    /* Select2 */
    $('.select2').select2({
      placeholder: 'Pilih',
    });

    $('.select2-selection').css('height', '37px');
    $('.select2').css('width', '100%');
    /* Select2 */
  });

  /* View Update */
  function fun_edit(id) {
    $('#simpan').css('display', 'none');
    $('#edit').css('display', 'block');
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $.getJSON('<?= base_url('master/jenis_sample_uji/getJenisSampleUji') ?>', {
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
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        if ($('#jenis_id').val() != '') var url = '<?= base_url('master/jenis_sample_uji/updateJenisSampleUji') ?>';
        else var url = '<?= base_url('master/jenis_sample_uji/insertJenisSampleUji') ?>';

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
          $.get('<?= base_url('master/jenis_sample_uji/deleteJenisSampleUji') ?>', {
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
  function fun_reset(id) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $.confirmModal('Apakah anda yakin akan reset data?', function(el) {
          $.get('<?= base_url('master/jenis_sample_uji/resetJenisSampleUji') ?>', function(data) {
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

  /* Fun Detail */
  function fun_detail(id) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $('#div_detail').css('display', 'block');
        $('#table').DataTable().ajax.reload(null, false);
        $('#table_detail').DataTable().ajax.url('<?= base_url('master/jenis_sample_uji/getSampleIdentitas?jenis_id=') ?>' + id).load();
        $('#id_jenis').val(id);
        $('html, body').animate({
          scrollTop: $("#div_detail").offset().top
        }, 10);

        setTimeout(function() {
          $('#' + id).parents('tr').attr('style', 'color: red')
        }, 500);

      }
    });
  }
  /* Fun Detail */

  /* Fun Tambah Detail */
  function fun_tambah_detail() {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $('#temp_jenis_id').val($('#id_jenis').val());
      }
    });
  }
  /* Fun Tambah Detail */

  /* View Update Detail */
  function fun_edit_detail(id) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $('#simpan_detail').css('display', 'none');
        $('#edit_detail').css('display', 'block');
        $.getJSON('<?= base_url('master/jenis_sample_uji/getSampleIdentitas') ?>', {
          identitas_id: id
        }, function(json) {
          $.each(json, function(index, val) {
            $('#' + index).val(val);
          });
          $('#temp_jenis_id').val(json.jenis_id);
        });
      }
    });
  }
  /* View Update Detail */

  /* Proses Detail */
  $("#form_modal_detail").on("submit", function(e) {
    e.preventDefault();
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        if ($('#identitas_id').val() != '') var url = '<?= base_url('master/jenis_sample_uji/updateSampleIdentitas') ?>';
        else var url = '<?= base_url('master/jenis_sample_uji/insertSampleIdentitas') ?>';

        e.preventDefault();
        $.ajax({
          url: url,
          data: $('#form_modal_detail').serialize(),
          type: 'POST',
          dataType: 'html',
          success: function(isi) {
            $('#close_detail').click();
            toastr.success('Berhasil');
          }
        });
      }
    });
  });
  /* Proses Detail */

  /* Fun Delete Detail */
  function fun_delete_detail(id) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $.confirmModal('Apakah anda yakin akan menghapusnya?', function(el) {
          $.get('<?= base_url('master/jenis_sample_uji/deleteSampleIdentitas') ?>', {
            identitas_id: id
          }, function(data) {
            $('#close_detail').click();
            toastr.success('Berhasil');
          });
        });
      }
    });
  }
  /* Fun Delete Detail */

  /* Fun Close Detail */
  function fun_close_detail() {
    $('#simpan_detail').css('display', 'block');
    $('#edit_detail').css('display', 'none');
    $('#form_modal_detail')[0].reset();
    $('#table_detail').DataTable().ajax.reload();
    fun_loading();
  }
  /* Fun Close Detail */

  $('#modal_detail').on('hidden.bs.modal', function(e) {
    fun_close_detail();
  });


  // Rumus
  // fun rumus
  function fun_rumus(id) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $('#simpan_rumus').css('display', 'none');
        $('#edit_rumus').css('display', 'block');
        $.getJSON('<?= base_url('master/jenis_sample_uji/getSampleIdentitas') ?>', {
          identitas_id: id
        }, function(json) {
          $.each(json, function(index, val) {
            var cek = $('#' + index).val(val);
          });
          $('#temp_jenis_id_rumus').val(json.jenis_id);
          $('#identitas_id_rumus').val(json.identitas_id);
          $('#identitas_harga_rumus').val((json.identitas_harga) ? json.identitas_harga : '0');
          $('#identitas_jumlah_tenaga_kerja_rumus').val((json.identitas_jumlah_tenaga_kerja) ? json.identitas_jumlah_tenaga_kerja : '0');
          $('#identitas_harga_tambahan_rumus').val((json.identitas_harga_tambahan) ? json.identitas_harga_tambahan : '0');
        });
      }
    });
  }
  // fun rumus

  // submit rumus
  $('#form_modal_rumus').on('submit', function(e) {
    e.preventDefault();
    $.getJSON("<?= base_url() ?>login/login/checkLogin", {},
      function(data, textStatus, jqXHR) {
        if (!data.user_id) {
          fun_notifLogout();
        } else {
          $.ajax({
            type: "POST",
            dataType: "HTML",
            url: "<?= base_url('master/jenis_sample_uji/updateRumus') ?>",
            data: $('#form_modal_rumus').serialize(),
            // contentType: "text/html; charset=utf-8",
            processData: false,
            cache: false,
            beforeSend: function() {
              $('#edit_rumus').hide();
              $('#simpan_rumus').show();
            },
            success: function(response) {
              $('#close_rumus').click();
              fun_close_rumus();
            }
          });
        }
      }
    );
  })
  // submit rumus

  // close rumus
  function fun_close_rumus() {
    $('#simpan_rumus').css('display', 'block');
    $('#edit_rumus').css('display', 'none');
    $('#form_modal_rumus')[0].reset();
    $('#table_detail').DataTable().ajax.reload(null, false);
    fun_loading();
  }

  $('#modal_rumus').on('hidden.bs.modal', function(e) {
    fun_close_rumus();
  });
  // close rumus

  // Rumus

  function fun_loading() {
    var simplebar = new Nanobar();
    simplebar.go(100);
  }
</script>