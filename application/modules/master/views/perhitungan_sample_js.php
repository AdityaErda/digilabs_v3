<script type="text/javascript">
  $(function() {
    fun_loading();

    /* Isi Table */
    $('#table thead tr').clone(true).addClass('filters').appendTo('#table thead');
    $('#table').DataTable({
    orderCellsTop: true,
    initComplete: function() {
      $('.dataTables_scrollHead').on('scroll', () => $('.dataTables_scrollBody').scrollLeft($(this).scrollLeft()));
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
      "ajax": {
        "url": "<?= base_url() ?>/master/perhitungan_sample/getPerhitunganSample",
        "dataSrc": ""
      },
      // "fnRowCallback": function(data, type, full, meta) {
      //     if (type['is_adbk'] == 'y') $('td', data).css('background-color', 'Yellow');
      // },
      "columns": [{
          render: function(data, type, full, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        {
          "data": "jenis_nama"
        },
        {
          "render": function(data, type, row, meta) {
            return (row.is_adbk == 'y') ? '<span style="background-color:aqua" class="badge">' + row.rumus_nama + '</span>' : row.rumus_nama;
          }
        },
        {
          "data": "desimal_angka"
        },
        {
          "data": "satuan_sample"
        },
        {
          "data": "metode"
        },
        {
          render: function(data, type, row, meta) {
            var status = "";
            if (row.is_aktif == 'y') {
              status = "Aktif"
            } else {
              status = 'Non-Aktif'
            }
            return status;
          }
        },
        {
          "render": function(data, type, full, meta) {
            return full.when_create + ' - ' + full.who_create + ' - ' + full.who_seksi_create_name;
          }
        },
        {
          "render": function(data, type, full, meta) {
            var tombol = '<div class="input-group-prepend"><button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Action</button><div class="dropdown-menu" style="height:auto;max-height: 100px;overflow-x:auto;">';
            tombol += '<a class="dropdown-item" href="javascript:;" id="' + full.rumus_id + '" title="Detail" onclick="fun_detail(this.id)">Detail</a>';
            tombol += '<a class="dropdown-item" href="#" id="' + full.rumus_id + '" onclick="fun_edit(this.id)" data-toggle="modal" data-target="#modal">Edit</a>'
            tombol += '<a class="dropdown-item" href="#" id="' + full.rumus_id + '" onclick="fun_delete(this.id)">Hapus</a></div></div>';
            return tombol;
          }
        },
      ]
    });
    /* Isi Table */

    /* Isi Table List Rumus */
    $('#table_list_rumus').DataTable({
      "lengthMenu": [
        [5, 10, 25, 50, -1],
        [5, 10, 25, 50, "All"]
      ],
      "ajax": {
        "url": "<?= base_url() ?>/master/perhitungan_sample/getListRumus",
        "dataSrc": ""
      },
      "columns": [{
          render: function(data, type, full, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        {
          "data": "rumus"
        },
      ]
    });
    /* Isi Table List Rumus */

    /* Isi Table Detail */
    $('#table_detail thead tr').clone(true).addClass('filters_detail').appendTo('#table_detail thead');
    $('#table_detail').DataTable({
    orderCellsTop: true,
    initComplete: function() {
      var api = this.api();
      api.columns().eq(0).each(function(colIdx) {
        var cell = $('.filters_detail th').eq($(api.column(colIdx).header()).index());
        var title = $(cell).text();
        $(cell).html('<input type="text" class="form-control" style="width:100%" placeholder="' + title + '" />');
        $('input', $('.filters_detail th').eq($(api.column(colIdx).header()).index()))
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
      "ajax": {
        "url": "<?= base_url() ?>/master/perhitungan_sample/getDetailRumusSample?rumus_detail_id=0",
        "dataSrc": ""
      },
      "columns": [
        {
          "data": "rumus_detail_template"
        },
        {
          "data": "rumus_detail_nama"
        },
        {
          "data": "rumus_detail_input"
        },
        {
          "render": function(data, type, row, meta) {
            var jenis = "";
            if (row.rumus_jenis == 'I') {
              jenis = "Input";
            } else if (row.rumus_jenis == 'A') {
              jenis = 'Auto';
            }
            return jenis;
          }
        },
        {
          "render": function(data, type, full, meta) {
            return full.when_create + ' - ' + full.who_create;
          }
        },
        {
          "render": function(data, type, full, meta) {
            var tombol = '<div class="input-group-prepend"><button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Action</button><div class="dropdown-menu" style="height:auto;max-height: 100px;overflow-x:auto;">';
            tombol += '<a class="dropdown-item" href="#"  onclick="fun_edit_detail(`' + full.rumus_detail_id + '`)" data-toggle="modal" data-target="#modal_detail">Edit</a>'
            tombol += '<a class="dropdown-item" href="#"  onclick="fun_delete_detail(`' + full.rumus_detail_id + '`)">Hapus</a></div></div>';
            return tombol;
          }
        },
      ]
    });
    /* Isi Table Detail */

    /* Select2 */
    $('#jenis_id').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url('master/perhitungan_sample/getJenisSample') ?>',
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

    $('.select2-selection').css('height', '37px');
    $('.select2').css('width', '100%');
    /* Select2 */


    /* Validasi Inputan Urutan Template */
    var validation_el = $('<div>')
    validation_el.addClass('validation-err alert alert-danger my-2')
    validation_el.hide()
    $('input[name="rumus_detail_template"]').on('input', function() {
      var rumus_detail_template = $(this).val()
      var rumus_id = $('#temp_rumus_id').val()
      $(this).removeClass("border-danger border-success")
      $(this).siblings(".validation-err").remove();
      var err_el = validation_el.clone()

      if (rumus_detail_template == '')
        return false;

      $.ajax({
        url: "<?php echo base_url('master/perhitungan_sample/getUrutanTemplate'); ?>",
        method: 'GET',
        data: {
          rumus_detail_template: rumus_detail_template,
          rumus_id: rumus_id,
        },
        dataType: 'json',
        // error: err => {
        //     console.error(err)
        //     alert("An error occured while validating the data")
        // },
        success: function(result) {
          Swal.fire({
            text: "Urutan Template Sudah Di Gunakan !!",
            type: 'warning',
            confirmButtonColor: "#FF4500",
            confirmButtonText: "OK",
            allowOutsideClick: false,
          }).then(function(result) {
            if (result.value) {

            }
          })
        }
      })
    })
    /* Validasi Inputan Urutan Template */

  });


  //* List Rumus *//
  function fun_rumus(id) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        fun_loading()
        // $('#div_detail').css('display', 'block');
        $('#table_list_rumus').DataTable().ajax.url('<?= base_url() ?>master/perhitungan_sample/getListRumus?id_rumus=' + id).load();
      }
    });
  }

  //* List Rumus *//

  /* View Update */
  function fun_edit(id) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $('#simpan').css('display', 'none');
        $('#edit').css('display', 'block');
        $.getJSON('<?= base_url('master/perhitungan_sample/getPerhitunganSample') ?>', {
          rumus_id: id
        }, function(json) {
          $.each(json, function(index, val) {
            $('#' + index).val(val);
          });

          $('#jenis_id').append('<option selected value="' + json.jenis_id + '">' + json.jenis_nama + '</option>');
          $('#jenis_id').select2('data', {
            id: json.jenis_id,
            text: json.jenis_nama
          });

          if (json.is_aktif == 'y') $('#is_aktif').prop('checked', true);
          $('#is_aktif').val('y');

          if (json.is_adbk == 'y') $('#is_adbk').prop('checked', true);
          $('#is_adbk').val('y');

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
        if ($('#rumus_id').val() != '') var url = '<?= base_url('master/perhitungan_sample/updatePerhitunganSample') ?>';
        else var url = '<?= base_url('master/perhitungan_sample/insertPerhitunganSample') ?>';

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
    // $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
    //     if (!json.user_id) {
    //         fun_notifLogout();
    //     } else {
    $.confirmModal('Apakah anda yakin akan menghapusnya?', function(el) {
      $.get('<?= base_url('master/perhitungan_sample/deletePerhitunganSample') ?>', {
        rumus_id: id
      }, function(data) {
        $('#close').click();
        toastr.success('Berhasil');
      });
    });
    // }
    // });
  }
  /* Fun Delete */

  /* Fun Close */
  function fun_close() {
    $('#simpan').css('display', 'block');
    $('#edit').css('display', 'none');
    $("#jenis_id").empty();
    $('#form_modal')[0].reset();
    $('#table').DataTable().ajax.reload();
    $('#table_list_rumus').DataTable().ajax.reload();
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
        // $('#table').DataTable().ajax.reload(null, false);
        $('#table_detail').DataTable().ajax.url('<?= base_url('master/perhitungan_sample/getDetailRumusSample?id_rumus=') ?>' + id).load();
        $('#id_rumus_detail').val(id);
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
        $('#temp_rumus_id').val($('#id_rumus_detail').val());
        $.getJSON("<?= base_url('master/perhitungan_sample/getMaksTemplate') ?>", {
            id_rumus: $('#temp_rumus_id').val()
          },
          function(data, textStatus, jqXHR) {
            $('#rumus_detail_template').val(data.last);
          }
        );

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
        $.getJSON('<?= base_url('master/perhitungan_sample/getDetailRumusSample') ?>', {
          rumus_detail_id: id
        }, function(json) {
          $.each(json, function(index, val) {
            $('#' + index).val(val);
          });
          $('#temp_rumus_id').val(json.id_rumus);
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
        if ($('#rumus_detail_id').val() != '') var url = '<?= base_url('master/perhitungan_sample/updatePerhitunganSampleDetail') ?>';
        else var url = '<?= base_url('master/perhitungan_sample/insertPerhitunganSampleDetail') ?>';

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
          $.get('<?= base_url('master/perhitungan_sample/deletePerhitunganSampleDetail') ?>', {
            rumus_detail_id: id
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

  function fun_import_detail() {
    var url = "<?= base_url('master/perhitungan_sample/index_import_detail?header_menu=0&menu_id=0&import_kode=0&id_rumus=') ?>" + $('#id_rumus_detail').val();

    location.href = url;
  }

  function fun_loading() {
    var simplebar = new Nanobar();
    simplebar.go(100);
  }
</script>