<script type="text/javascript">
  $(function() {
    fun_loading();

    /* Isi Table */
    /* kurva */
    $('#table_kurva thead tr').clone(true).addClass('filters').appendTo('#table_kurva thead');
    $('#table_kurva').DataTable({
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
        "url": "<?= base_url() ?>/master/kurva/getKurva",
        "dataSrc": ""
      },
      "columns": [{
          render: function(data, type, full, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        {
          render: function(data, type, full, meta) {
            return full.jenis_nama + ' - ' + full.rumus_nama;
          }
        },
        {
          "data": "kurva_nama"
        },
        {
          "data": "kurva_baris"
        },
        {
          "render": function(data, type, full, meta) {
            var tombol = '<div class="input-group-prepend"><button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Action</button>';
            tombol += '<div class="dropdown-menu" style="height:auto;max-height: 100px;overflow-x:hidden;">';
            // tombol += '<a class="dropdown-item" href="#" onclick="fun_lihat(`' + full.kurva_id + '`)">Lihat</a>';
            tombol += '<a class="dropdown-item" href="<?= base_url('master/kurva/lihat?id_kurva=') ?>' + full.kurva_id + '" target="_blank">Lihat</a>';
            tombol += '<a class="dropdown-item" href="#" onclick="fun_detail(`' + full.kurva_id + '`)">Detail</a>';
            tombol += '<a class="dropdown-item" href="#" onclick="fun_edit(`' + full.kurva_id + '`)" data-toggle="modal" data-target="#modal_kurva">Edit</a>';
            tombol += '<a class="dropdown-item" href="#" onclick="fun_delete(`' + full.kurva_id + '`)">Hapus</a>';
            tombol += '</div></div>';
            return tombol;
          }
        },
      ]
    });
    /* kurva */

    /* kurva header */
    // $('#table_kurva_header thead tr').clone(true).addClass('filters').appendTo('#table_kurva_header thead');
    $('#table_kurva_header').DataTable({
      orderCellsTop: true,
      initComplete: function() {
        $('.dataTables_scrollHead').on('scroll', function() {
          $('.dataTables_scrollBody').scrollLeft($(this).scrollLeft());
        });
        // var api = this.api();
        // // For each column
        // api
        //   .columns()
        //   .eq(0)
        //   .each(function(colIdx) {
        //     // Set the header cell to contain the input element
        //     var cell = $('.filters th').eq(
        //       $(api.column(colIdx).header()).index()
        //     );
        //     var title = $(cell).text();
        //     $(cell).html('<input type="text" class="form-control" style="width:100%" placeholder="' + title + '" />');
        //     // On every keypress in this input
        //     $(
        //         'input',
        //         $('.filters th').eq($(api.column(colIdx).header()).index())
        //       )
        //       .off('keyup change')
        //       .on('keyup change', function(e) {
        //         e.stopPropagation();
        //         // Get the search value
        //         $(this).attr('title', $(this).val());
        //         var regexr = '({search})'; //$(this).parents('th').find('select').val();

        //         var cursorPosition = this.selectionStart;
        //         // Search the column for that value
        //         api
        //           .column(colIdx)
        //           .search(
        //             this.value != '' ?
        //             regexr.replace('{search}', '(((' + this.value + ')))') :
        //             '',
        //             this.value != '',
        //             this.value == ''
        //           )
        //           .draw();

        //         $(this)
        //           .focus()[0]
        //           .setSelectionRange(cursorPosition, cursorPosition);
        //       });
        //   });
      },
      "scrollX": true,
      "lengthMenu": [
        [5, 10, 25, 50, -1],
        [5, 10, 25, 50, "All"]
      ],
      "ajax": {
        "url": "<?= base_url() ?>/master/kurva/getKurvaHeader?id_kurva=0",
        "dataSrc": ""
      },
      "columns": [{
          render: function(data, type, full, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        {
          render: function(data, type, full, meta) {
            return full.kurva_header_urut;
          }
        },
        {
          render: function(data, type, full, meta) {
            return full.kurva_header_nama;
          }
        },
        {
          "render": function(data, type, full, meta) {
            var tombol = '<div class="input-group-prepend"><button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Action</button>';
            tombol += '<div class="dropdown-menu" style="height:auto;max-height: 100px;overflow-x:hidden;">';
            tombol += '<a class="dropdown-item" href="#" onclick="fun_detail_header(`' + full.kurva_header_id + '`,`' + full.id_kurva + '`)">Detail</a>';
            tombol += '<a class="dropdown-item" href="#" onclick="fun_edit_header(`' + full.kurva_header_id + '`)" data-toggle="modal" data-target="#modal_kurva_header">Edit</a>';
            tombol += '<a class="dropdown-item" href="#" onclick="fun_delete_header(`' + full.kurva_header_id + '`)">Hapus</a>';
            tombol += '</div></div>';
            return tombol;
          }
        },
      ]
    });
    /* kurva header */

    /* kurva isi */
    // $('#table_kurva_isi thead tr').clone(true).addClass('filters').appendTo('#table_kurva_isi thead');
    $('#table_kurva_isi').DataTable({
      orderCellsTop: true,
      initComplete: function() {
        $('.dataTables_scrollHead').on('scroll', function() {
          $('.dataTables_scrollBody').scrollLeft($(this).scrollLeft());
        });
        // var api = this.api();
        // // For each column
        // api
        //   .columns()
        //   .eq(0)
        //   .each(function(colIdx) {
        //     // Set the header cell to contain the input element
        //     var cell = $('.filters th').eq(
        //       $(api.column(colIdx).header()).index()
        //     );
        //     var title = $(cell).text();
        //     $(cell).html('<input type="text" class="form-control" style="width:100%" placeholder="' + title + '" />');
        //     // On every keypress in this input
        //     $(
        //         'input',
        //         $('.filters th').eq($(api.column(colIdx).header()).index())
        //       )
        //       .off('keyup change')
        //       .on('keyup change', function(e) {
        //         e.stopPropagation();
        //         // Get the search value
        //         $(this).attr('title', $(this).val());
        //         var regexr = '({search})'; //$(this).parents('th').find('select').val();

        //         var cursorPosition = this.selectionStart;
        //         // Search the column for that value
        //         api
        //           .column(colIdx)
        //           .search(
        //             this.value != '' ?
        //             regexr.replace('{search}', '(((' + this.value + ')))') :
        //             '',
        //             this.value != '',
        //             this.value == ''
        //           )
        //           .draw();

        //         $(this)
        //           .focus()[0]
        //           .setSelectionRange(cursorPosition, cursorPosition);
        //       });
        //   });
      },
      "scrollX": true,
      "lengthMenu": [
        [5, 10, 25, 50, -1],
        [5, 10, 25, 50, "All"]
      ],
      "ajax": {
        "url": "<?= base_url() ?>/master/kurva/getKurvaIsi?id_kurva_header=0",
        "dataSrc": ""
      },
      "columns": [{
          render: function(data, type, full, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        {
          render: function(data, type, full, meta) {
            return full.kurva_urut;
          }
        },
        {
          render: function(data, type, full, meta) {
            return full.kurva_isi_jumlah;
          }
        },
        {
          "render": function(data, type, full, meta) {
            var tombol = '<div class="input-group-prepend"><button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Action</button>';
            tombol += '<div class="dropdown-menu" style="height:auto;max-height: 100px;overflow-x:hidden;">';
            tombol += '<a class="dropdown-item" href="#" onclick="fun_edit_isi(`' + full.kurva_isi_id + '`)" data-toggle="modal" data-target="#modal_kurva_isi">Edit</a>';
            tombol += '<a class="dropdown-item" href="#" onclick="fun_delete_isi(`' + full.kurva_isi_id + '`)">Hapus</a>';
            tombol += '</div></div>';
            return tombol;
          }
        },
      ]
    });
    /* kurva isi */
    /* Isi Table */

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

    $('#id_rumus').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url('master/template_logsheet/getMasterRumus') ?>',
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
  });

  /* Tambah */
  function fun_tambah_kurva_header() {

  }

  function fun_tambah_kurva_isi() {
    $.getJSON("<?= base_url('master/kurva/getKurvaBatas') ?>", {
        id_kurva_header: $('#id_kurva_header').val(),
        id_kurva: $('#id_kurva_utamas').val(),
      },
      function(data, textStatus, jqXHR) {
        if (data.isian >= data.batas) {
          Swal.fire(
            'Peringatan!',
            'Batas Baris ' + data.batas,
            'warning'
          );
        } else {
          $('#modal_kurva_isi').modal('show');
        }
      }
    );
  }
  /* Tambah */

  /* View Update */
  /* kurva */
  function fun_edit(id) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $('#simpan').css('display', 'none');
        $('#edit').css('display', 'block');
        $.getJSON('<?= base_url('master/kurva/getkurva') ?>', {
          kurva_id: id
        }, function(json) {
          $('#kurva_id').val(json.kurva_id);
          $.getJSON('<?= base_url('master/template_logsheet/getMasterRumusData') ?>', {
            id_rumus: json.rumus_id,
          }, function(json_1) {
            $.each(json_1, function(index_1, jsons_1) {
              $('#id_rumus').append('<option selected value="' + jsons_1.rumus_id + '">' + jsons_1.jenis_nama + ' - ' + jsons_1.rumus_nama + '</option>');
            });
          });
          $('#kurva_nama').val(json.kurva_nama);
          $('#kurva_baris').val(json.kurva_baris);
        });
      }
    });
  }
  /* kurva */

  /* kurva header */
  function fun_edit_header(id) {
    // $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
    // if (!json.user_id) {
    // fun_notifLogout();
    // } else {
    $('#simpan_header').css('display', 'none');
    $('#edit_header').css('display', 'block');
    $.getJSON('<?= base_url('master/kurva/getkurvaHeader') ?>', {
      kurva_header_id: id
    }, function(json) {
      $('#kurva_header_id').val(json.kurva_header_id);
      $('#kurva_header_urut').val(json.kurva_header_urut);
      $('#kurva_header_nama').val(json.kurva_header_nama);
    });
    // }
    // });
  }
  /* kurva header */

  /* kurva isi */
  function fun_edit_isi(id) {
    // $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
    // if (!json.user_id) {
    // fun_notifLogout();
    // } else {
    $('#simpan_isi').css('display', 'none');
    $('#edit_isi').css('display', 'block');
    $.getJSON('<?= base_url('master/kurva/getKurvaIsi') ?>', {
      kurva_isi_id: id
    }, function(json) {
      $('#kurva_isi_id').val(json.kurva_isi_id);
      $('#kurva_isi_urut').val(json.kurva_urut);
      $('#kurva_isi_jumlah').val(json.kurva_isi_jumlah);
    });
    // }
    // });
  }
  /* kurva isi */
  /* View Update */

  /* Proses */
  /* kurva */
  $("#form_modal_kurva").on("submit", function(e) {
    e.preventDefault();
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        if ($('#kurva_id').val() != '') var url = '<?= base_url('master/kurva/updateKurva') ?>';
        else var url = '<?= base_url('master/kurva/insertKurva') ?>';
        e.preventDefault();
        $.ajax({
          url: url,
          data: $('#form_modal_kurva').serialize(),
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
  /* kurva */

  /* kurva header */
  $("#form_modal_kurva_header").on("submit", function(e) {
    e.preventDefault();
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        if ($('#kurva_header_id').val() != '') var url = '<?= base_url('master/kurva/updateKurvaHeader') ?>';
        else var url = '<?= base_url('master/kurva/insertKurvaHeader') ?>';
        var data = new FormData($('#form_modal_kurva_header')[0]);
        data.append('id_kurva', $('#id_kurva_utama').val())
        e.preventDefault();
        $.ajax({
          url: url,
          data: data,
          type: 'POST',
          dataType: 'html',
          contentType: false,
          processData: false,
          cache: false,
          success: function(isi) {
            $('#close_header').click();
            toastr.success('Berhasil');
          }
        });
      }
    });
  });
  /* kurva header */

  /* kurva isi */
  $("#form_modal_kurva_isi").on("submit", function(e) {
    e.preventDefault();
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        if ($('#kurva_isi_id').val() != '') var url = '<?= base_url('master/kurva/updateKurvaIsi') ?>';
        else var url = '<?= base_url('master/kurva/insertKurvaIsi') ?>';
        var data = new FormData($('#form_modal_kurva_isi')[0]);
        data.append('id_kurva', $('#id_kurva_utamas').val());
        data.append('id_kurva_header', $('#id_kurva_header').val());
        e.preventDefault();
        $.ajax({
          url: url,
          data: data,
          type: 'POST',
          dataType: 'html',
          contentType: false,
          processData: false,
          cache: false,
          success: function(isi) {
            $('#close_isi').click();
            toastr.success('Berhasil');
          }
        });
      }
    });
  });
  /* kurva isi */
  /* Proses */

  /* Fun Delete */
  /* kurva */
  function fun_delete(id) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $.confirmModal('Apakah anda yakin akan menghapusnya?', function(el) {
          $.get('<?= base_url('master/kurva/deleteKurva') ?>', {
            kurva_id: id
          }, function(data) {
            $('#table_kurva').DataTable().ajax.reload();
            toastr.success('Berhasil');
          });
        });
      }
    });
  }
  /* kurva */

  /* kurva header */
  function fun_delete_header(id) {
    // $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
    // if (!json.user_id) {
    // fun_notifLogout();
    // } else {
    $.confirmModal('Apakah anda yakin akan menghapusnya?', function(el) {
      $.get('<?= base_url('master/kurva/deleteKurvaHeader') ?>', {
        kurva_header_id: id
      }, function(data) {
        $('#table_kurva_header').DataTable().ajax.reload();
        toastr.success('Berhasil');
      });
    });
    // }
    // });
  }
  /* kurva header */

  /* kurva isi */
  function fun_delete_isi(id) {
    // $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
    // if (!json.user_id) {
    // fun_notifLogout();
    // } else {
    $.confirmModal('Apakah anda yakin akan menghapusnya?', function(el) {
      $.get('<?= base_url('master/kurva/deleteKurvaIsi') ?>', {
        kurva_isi_id: id
      }, function(data) {
        $('#table_kurva_isi').DataTable().ajax.reload();
        toastr.success('Berhasil');
      });
    });
    // }
    // });
  }
  /* kurva isi */
  /* Fun Delete */

  /* Fun Close */
  /* kurva */
  function fun_close() {
    $('#simpan').css('display', 'block');
    $('#edit').css('display', 'none');
    $('#form_modal_kurva')[0].reset();
    $('#id_rumus').empty();
    $('#table_kurva').DataTable().ajax.reload();
    fun_loading();
  }

  $('#modal_kurva').on('hidden.bs.modal', function(e) {
    fun_close();
  });

  function fun_close_header() {
    $('#simpan_header').css('display', 'block');
    $('#edit_header').css('display', 'none');
    $('#form_modal_kurva_header')[0].reset();
    $('#table_kurva_header').DataTable().ajax.reload();
    fun_loading();
  }

  $('#modal_kurva_header').on('hidden.bs.modal', function(e) {
    fun_close_header();
  });

  function fun_close_isi() {
    $('#simpan_isi').css('display', 'block');
    $('#edit_isi').css('display', 'none');
    $('#form_modal_kurva_isi')[0].reset();
    $('#table_kurva_isi').DataTable().ajax.reload();
    fun_loading();
  }

  $('#modal_kurva_isi').on('hidden.bs.modal', function(e) {
    fun_close_isi();
  });
  /* kurva */
  /* Fun Close */

  /* Fun Detail */
  /* kurva */
  function fun_detail(id) {
    $('#div_kurva_isi').hide();
    $('#div_kurva_lihat').hide();
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $('#div_kurva_header').show();
        $('html, body').animate({
          scrollTop: $("#div_kurva_header").offset().top
        }, 10);
        $('#id_kurva_utama').val(id);
        $('#table_kurva_header').DataTable().ajax.url('<?= base_url('master/kurva/getKurvaHeader?id_kurva=') ?>' + id).load();
      }
    });
  }
  /* kurva */

  /* kurva header */
  function fun_detail_header(id, utama) {
    $('#div_kurva_lihat');
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $('#div_kurva_isi').show();
        $('html, body').animate({
          scrollTop: $("#div_kurva_isi").offset().top
        }, 10);
        $('#id_kurva_header').val(id);
        $('#id_kurva_utamas').val(utama);
        $('#table_kurva_isi').DataTable().ajax.url('<?= base_url('master/kurva/getKurvaIsi?id_kurva_header=') ?>' + id).load();
      }
    });
  }
  /* kurva header */
  /* Fun Detail */

  /* lain */
  function fun_lihat(id) {
    $('#div_kurva_header').hide();
    $('#div_kurva_isi').hide();
    $('#div_kurva_lihat').show();
    $('html, body').animate({
      scrollTop: $("#div_kurva_lihat").offset().top
    }, 10);
    var html = "";
    html += '<div class="card">';
    html += '<div class="card-header bg-secondary">';
    html += '<h3 class="card-title">Lihat Tabel Kurva</h3>';
    html += '</div>';
    html += '<div class="card-body">';
    html += '<table id="table_kurva_lihat_' + id + '" class="table table-bordered table-striped" width="100%">';
    html += '<thead id="head_' + id + '"></thead>';
    html += '<tbody id="body_' + id + '"></tbody>';
    html += '</table>';
    html += '</div>';
    $('#div_table_kurva_lihat').html(html);
    fun_lihat_head(id)
  }

  function fun_lihat_head(id) {
    var head = "";
    $.getJSON("<?= base_url('master/kurva/getKurvaHeader') ?>", {
        id_kurva: id
      },
      function(json) {
        head += '<tr>';
        $.each(json, function(index, value) {
          head += '<th id="th_' + value.kurva_header_id + '">' + value.kurva_header_nama + '</th>';
          fun_lihat_isi(value.kurva_header_id, value.id_kurva);
        });
        head += '</tr>';
        $('#head_' + id).append(head);
      }
    );
  }

  function fun_lihat_isi(id_header, id) {
    var body = "";
    $.getJSON("<?= base_url('master/kurva/getKurvaIsi') ?>", {
        id_kurva_header: id_header,
        id_kurva: id
      },
      function(data, textStatus, jqXHR) {
        $.each(data, function(index, value) {
          body += '<tr>';
          body += '<td id="td_' + value.kurva_isi_id + '">' + value.kurva_isi_jumlah + '</td>';
          body += '</tr>';
        });
        $('#body_' + id).append(body);
      }
    );
  }


  /* lain */

  /*detail kurva*/
  function fun_detail_kurva(id) {
    var head = "";
    var body = "";
    var baris = $('tbody #body_' + id).length + 1;

    head += '<tr>';
    head += '<td>No</td>';
    head += '<td>Concentration</td>';
    head += '<td>Absorbance</td>';
    head += '<td>Aksi</td>';
    head += '</tr>';

    body += '<tr>';
    body += '<td>' + baris + '</td>';
    body += '<td><input class="form-control" type="text" id="kurva_concentration_' + baris + '" name="kurva_concentration[]"></td>';
    body += '<td><input class="form-control" type="text" id="kurva_absorbance_' + baris + '" name="kurva_absorbance[]"></td>';
    body += '<td><a href="javascript:void(0);" id="' + id + '" onclick="add_kurva(this.id)"><i class="fa fa-plus" style="color:green"></i></a></td>';
    body += '</tr>';
    $('#head_' + id).html(head);
    $('#body_' + id).html(body);
  }
  /*detail kurva*/



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
    $('#table_kurva').DataTable().ajax.reload(null, false);
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