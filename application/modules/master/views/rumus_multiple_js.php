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
      "ajax": {
        "url": "<?= base_url() ?>/master/rumus_multiple/getRumusMultiple",
        "dataSrc": ""
      },
      "columns": [{
          render: function(data, type, full, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        {
          "data": "jenis_nama"
        },
        {
          "data": "metode"
        },
        // {
        //     "render": function(data, type, full, meta) {
        //         return '<center><a href="javascript:;" id="' + full.multiple_rumus_id + '" title="Detail" onclick="fun_detail(this.id)"><i class="fa fa-search"></i></a></center>';
        //     }
        // },
        // {
        //     "render": function(data, type, full, meta) {
        //         return '<center><a href="javascript:;" id="' + full.multiple_rumus_id + '" title="Edit" onclick="fun_edit(this.id)"><i class="fa fa-edit" data-toggle="modal" data-target="#modal" style="color: orange"></i></a></center>';
        //     }
        // },
        // {
        //     "render": function(data, type, full, meta) {
        //         return '<center><a href="javascript:;" id="' + full.multiple_rumus_id + '" title="Hapus" onclick="fun_delete(this.id)"><i class="fa fa-trash" style="color: red"></i></a></center>';
        //     }
        // },
        {
          "render": function(data, type, full, meta) {
            var tombol = '<div class="input-group-prepend"><button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Action</button><div class="dropdown-menu" style="height:auto;max-height: 100px;overflow-x:auto;">';
            tombol += '<a class="dropdown-item" href="javascript:;" title="Detail" onclick="fun_detail(`' + full.multiple_rumus_id + '`)">Detail</a>';
            tombol += '<a class="dropdown-item" href="#" onclick="fun_edit(`' + full.multiple_rumus_id + '`)" data-toggle="modal" data-target="#modal">Edit</a>'
            tombol += '<a class="dropdown-item" href="#" onclick="fun_delete(`' + full.multiple_rumus_id + '`)">Hapus</a></div></div>';
            return tombol;
          }
        },
      ]
    });
    /* Isi Table */

    /* Isi Table Parameter */
    $('#table_parameter thead tr').clone(true).addClass('filters_detail').appendTo('#table_parameter thead');
    $('#table_parameter').DataTable({
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
      "ajax": {
        "url": "<?= base_url() ?>/master/rumus_multiple/getDetailRumusMultiple?detail_multiple_rumus_id=0",
        "dataSrc": ""
      },
      "columns": [{
          render: function(data, type, full, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        {
          "data": "parameter_rumus"
        },
        {
          "data": "satuan_parameter"
        },
        // {
        //   "render": function(data, type, full, meta) {
        //     return '<center><a href="javascript:;" id="' + full.detail_multiple_rumus_id + '" title="List Rumus" onclick="fun_rumus(this.id)"><i class="fa fa-calculator" data-toggle="modal" data-target="#modal_list_rumus" style="color: grey"></i></a></center>';
        //   }
        // },
        // {
        //   "render": function(data, type, full, meta) {
        //     return '<center><a href="javascript:;" id="' + full.detail_multiple_rumus_id + '" title="Detail" onclick="fun_detail_parameter(this.id)"><i class="fa fa-search"></i></a></center>';
        //   }
        // },
        // {
        //   "render": function(data, type, full, meta) {
        //     return '<center><a href="javascript:;" id="' + full.detail_multiple_rumus_id + '" title="Edit" onclick="fun_edit_detail(this.id)"><i class="fa fa-edit" data-toggle="modal" data-target="#modal_detail" style="color: orange"></i></a></center>';
        //   }
        // },
        // {
        //   "render": function(data, type, full, meta) {
        //     return '<center><a href="javascript:;" id="' + full.detail_multiple_rumus_id + '" title="Hapus" onclick="fun_delete_detail(this.id)"><i class="fa fa-trash" style="color: red"></i></a></center>';
        //   }
        // },
        {
          "render": function(data, type, full, meta) {
            var tombol = '<div class="input-group-prepend"><button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Action</button><div class="dropdown-menu" style="height:auto;max-height: 100px;overflow-x:auto;">';
            tombol += '<a class="dropdown-item" href="javascript:;" title="List Rumus" onclick="fun_rumus(`' + full.detail_multiple_rumus_id + '`)" data-toggle="modal" data-target="#modal_list_rumus">List Rumus</a>';
            tombol += '<a class="dropdown-item" href="javascript:;" title="Detail" onclick="fun_detail_parameter(`' + full.detail_multiple_rumus_id + '`)">Detail</a>';
            tombol += '<a class="dropdown-item" href="#" onclick="fun_edit_detail(`' + full.detail_multiple_rumus_id + '`)" data-toggle="modal" data-target="#modal_detail">Edit</a>';
            tombol += '<a class="dropdown-item" href="#" onclick="fun_delete_detail(`' + full.detail_multiple_rumus_id + '`)">Hapus</a></div></div>';
            return tombol;
          }
        },
      ]
    });
    /* Isi Table Parameter */

    /* Isi Table List Rumus */
    $('#table_list_rumus').DataTable({
      "lengthMenu": [
        [5, 10, 25, 50, -1],
        [5, 10, 25, 50, "All"]
      ],
      "ajax": {
        "url": "<?= base_url() ?>/master/rumus_multiple/getListRumus",
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

    /* Isi Table Detail Parameter */
    $('#table_detail_parameter thead tr').clone(true).addClass('filters_material').appendTo('#table_detail_parameter thead');
    $('#table_detail_parameter').DataTable({
      orderCellsTop: true,
      initComplete: function() {
        var api = this.api();

        api.columns().eq(0).each(function(colIdx) {
          var cell = $('.filters_material th').eq(
            $(api.column(colIdx).header()).index()
          );
          var title = $(cell).text();
          $(cell).html('<input type="text" class="form-control" style="width:100%" placeholder="' + title + '" />');

          $(
            'input',
            $('.filters_material th').eq($(api.column(colIdx).header()).index())
          ).off('keyup change').on('keyup change', function(e) {
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
      "lengthMenu": [
        [5, 10, 25, 50, -1],
        [5, 10, 25, 50, "All"]
      ],
      "ajax": {
        "url": "<?= base_url() ?>/master/rumus_multiple/getParameterRumus?id_parameter=0",
        "dataSrc": ""
      },
      "columns": [{
          "data": "rumus_detail_urut"
        },
        {
          "data": "detail_parameter_rumus"
        },
        {
          "data": "rumus_detail_input"
        },
        // {
        //     "data": "rumus_detail_template"
        // },
        {
          "data": "rumus_jenis"
        },
        {
          "render": function(data, type, full, meta) {
            return '<center><a href="javascript:;" id="' + full.detail_parameter_rumus_id + '" title="Edit" onclick="fun_edit_detail_parameter(this.id)"><i class="fa fa-edit" style="color: orange"></i></a></center>';
          }
        }, {
          "render": function(data, type, full, meta) {
            return '<center><a href="javascript:;" id="' + full.detail_parameter_rumus_id + '" title="Delete" onclick="fun_delete_detail_parameter(this.id)"><i class="fa fa-trash" style="color: red"></i></a></center>';
          }
        },
      ]
    });
    /* Isi Table Detail Parameter */


    /* Select2 */
    $('#jenis_id').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url('master/rumus_multiple/getJenisSample') ?>',
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

    /* Validasi Inputan Urutan Rumus */
    var validation_el = $('<div>')
    validation_el.addClass('validation-err alert alert-danger my-2')
    validation_el.hide()
    $('input[name="rumus_detail_urut"]').on('input', function() {
      var rumus_detail_urut = $(this).val()
      var detail_multiple_rumus_id = $('#id_detail_parameter_rumus').val()
      $(this).removeClass("border-danger border-success")
      $(this).siblings(".validation-err").remove();
      var err_el = validation_el.clone()

      if (rumus_detail_urut == '')
        return false;

      $.ajax({
        url: "<?php echo base_url('master/rumus_multiple/getUrutanRumus'); ?>",
        method: 'GET',
        data: {
          rumus_detail_urut: rumus_detail_urut,
          detail_multiple_rumus_id: detail_multiple_rumus_id,
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
    /* Validasi Inputan Urutan Rumus */
  });


  /* View Update */
  function fun_edit(id) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $('#simpan').css('display', 'none');
        $('#edit').css('display', 'block');
        $.getJSON('<?= base_url('master/rumus_multiple/getRumusMultiple') ?>', {
          multiple_rumus_id: id
        }, function(json) {
          $.each(json, function(index, val) {
            $('#' + index).val(val);
          });

          $('#jenis_id').append('<option selected value="' + json.jenis_id + '">' + json.jenis_nama + '</option>');
          $('#jenis_id').select2('data', {
            id: json.jenis_id,
            text: json.jenis_nama
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
        if ($('#multiple_rumus_id').val() != '') var url = '<?= base_url('master/rumus_multiple/updateRumusMultiple') ?>';
        else var url = '<?= base_url('master/rumus_multiple/insertRumusMultiple') ?>';

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
          $.get('<?= base_url('master/rumus_multiple/deleteRumusMultiple') ?>', {
            multiple_rumus_id: id
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
    $("#jenis_id").empty();
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
        $('#div_detail_parameter').css('display', 'none');
        $('#div_detail').css('display', 'block');
        $('#table_parameter').DataTable().ajax.url('<?= base_url('master/rumus_multiple/getDetailRumusMultiple?id_multiple_rumus=') ?>' + id).load();

        $('#id_multiple_rumus_detail').val(id);
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
  function fun_tambah_parameter() {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $('#temp_multiple_rumus_id').val($('#id_multiple_rumus_detail').val());
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
        $.getJSON('<?= base_url('master/rumus_multiple/getDetailRumusMultiple') ?>', {
          detail_multiple_rumus_id: id
        }, function(json) {
          $.each(json, function(index, val) {
            $('#' + index).val(val);
          });
          $('#temp_multiple_rumus_id').val(json.id_multiple_rumus);
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
        if ($('#detail_multiple_rumus_id').val() != '') var url = '<?= base_url('master/rumus_multiple/updateRumusMultipleDetail') ?>';
        else var url = '<?= base_url('master/rumus_multiple/insertRumusMultipleDetail') ?>';

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
          $.get('<?= base_url('master/rumus_multiple/deleteRumusMultipleDetail') ?>', {
            detail_multiple_rumus_id: id
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
  function fun_close_parameter() {
    $('#simpan_detail').css('display', 'block');
    $('#edit_detail').css('display', 'none');
    $('#form_modal_detail')[0].reset();
    $('#table_parameter').DataTable().ajax.reload();
    fun_loading();
  }
  /* Fun Close Detail */

  $('#modal_detail').on('hidden.bs.modal', function(e) {
    fun_close_parameter();
  });


  //* List Rumus *//
  function fun_rumus(id) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        fun_loading()
        $('#table_list_rumus').DataTable().ajax.url('<?= base_url() ?>master/rumus_multiple/getListRumus?id_parameter=' + id).load();
      }
    });
  }
  //* List Rumus *//

  /* Fun Detail Parameter*/
  function fun_detail_parameter(id) {
    $('#temp_detail_parameter').val(id);
    $('#div_detail_parameter').css('display', 'block');
    $('#table_detail_parameter').DataTable().ajax.url('<?= base_url('master/rumus_multiple/getParameterRumus?id_parameter=') ?>' + id).load();
  }
  /* Fun Detail Parameter*/

  /* Fun Tambah Detail Parameter */
  function fun_parameter_detail(id) {
    $('#modal_detail_parameter').modal('show');
    $('#id_detail_parameter_rumus').val(id);
    $.getJSON("<?= base_url('master/rumus_multiple/getMaksUrut') ?>", {
        id_parameter: id
      },
      function(data, textStatus, jqXHR) {
        $('#rumus_detail_urut').val(data.last);
      }
    );
  }
  /* Fun Tambah Detail Parameter */

  /* View Update Detail Parameter */
  function fun_edit_detail_parameter(id) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $('#simpan_detail_parameter').css('display', 'none');
        $('#edit_detail_parameter').css('display', 'block');
        $.getJSON('<?= base_url('master/rumus_multiple/getParameterRumus') ?>', {
          detail_parameter_rumus_id: id
        }, function(json) {
          $('#modal_detail_parameter').modal('show');
          $('#id_detail_parameter_rumus').val(json.id_parameter);
          $('#detail_parameter_rumus_id').val(json.detail_parameter_rumus_id);

          $('#rumus_detail_urut').val(json.rumus_detail_urut);
          $('#rumus_detail_template').val(json.rumus_detail_template);
          $('#rumus_detail_input').val(json.rumus_detail_input);
          $('#rumus_jenis').val(json.rumus_jenis);

          $('#detail_parameter_rumus').val(json.detail_parameter_rumus);
        });
      }
    });
  }
  /* View Update Detail Parameter */

  /* Proses Detail Parameter */
  $("#form_modal_detail_parameter").on("submit", function(e) {
    e.preventDefault();
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        if ($('#detail_parameter_rumus_id').val() != '') var url = '<?= base_url('master/rumus_multiple/updateDetailParameter') ?>';
        else var url = '<?= base_url('master/rumus_multiple/insertDetailParameter') ?>';

        e.preventDefault();
        $.ajax({
          url: url,
          data: $('#form_modal_detail_parameter').serialize(),
          type: 'POST',
          dataType: 'html',
          success: function(isi) {
            $('#close_detail_parameter').click();
            toastr.success('Berhasil');
          }
        });
      }
    });
  });
  /* Proses Detail Parameter */

  /* Fun Detail Parameter */
  function fun_delete_detail_parameter(id) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $.confirmModal('Apakah anda yakin akan menghapusnya?', function(el) {
          $.get('<?= base_url('master/rumus_multiple/deleteDetailParameter') ?>', {
            detail_parameter_rumus_id: id
          }, function(data) {
            $('#close_detail_parameter').click();
            toastr.success('Berhasil');
          });
        });
      }
    });
  }
  /* Fun Detail Parameter */

  /* Fun Close Material */
  function fun_close_detail_parameter() {
    $('#simpan_detail_parameter').css('display', 'block');
    $('#edit_detail_parameter').css('display', 'none');
    $('#form_modal_detail_parameter')[0].reset();
    $('#table').DataTable().ajax.reload(null, false);
    $('#table_detail_parameter').DataTable().ajax.reload(null, false);
    fun_loading();
  }
  /* Fun Close Material */

  $('#modal_detail_parameter').on('hidden.bs.modal', function(e) {
    fun_close_detail_parameter();
  });

  function fun_import_parameter() {
    var url = "<?= base_url('master/rumus_multiple/index_import_detail?header_menu=0&menu_id=0&import_kode=0&id_multiple_rumus=') ?>" + $('#id_multiple_rumus_detail').val();

    location.href = url;
  }

  function fun_import_detail() {
    var url = "<?= base_url('master/rumus_multiple/index_import_detail_detail?header_menu=0&menu_id=0&import_kode=0&id_parameter=') ?>" + $('#temp_detail_parameter').val();

    location.href = url;
  }

  function fun_loading() {
    var simplebar = new Nanobar();
    simplebar.go(100);
  }
</script>