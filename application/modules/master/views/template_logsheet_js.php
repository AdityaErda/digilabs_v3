<script src="https://unpkg.com/mathjs/lib/browser/math.js"></script>
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

        api
          .columns()
          .eq(0)
          .each(function(colIdx) {
            var cell = $('.filters th').eq(
              $(api.column(colIdx).header()).index()
            );
            var title = $(cell).text();
            $(cell).html('<input type="text" class="form-control" style="width:100%" placeholder="' + title + '" />');
            $(
                'input',
                $('.filters th').eq($(api.column(colIdx).header()).index())
              )
              .off('keyup change')
              .on('keyup change', function(e) {
                e.stopPropagation();

                $(this).attr('title', $(this).val());
                var regexr = '({search})';
                //$(this).parents('th').find('select').val();

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
        "url": "<?= base_url() ?>/master/template_logsheet/getTemplateLogsheet",
        "dataSrc": ""
      },
      "fnRowCallback": function(data, type, full, meta) {
        $(data).attr('class', 'warna');;
      },
      "columns": [{
          render: function(data, type, full, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        {
          "data": "template_logsheet_nama"
        },
        {
          "render": function(data, type, full, meta) {
            return full.when_create + ' - ' + full.who_create + ' - ' + full.who_seksi_create_name;
          }
        },
        {
          "render": function(data, type, full, meta) {
            return (full.is_aktif == 'y') ? '<span class="badge badge-success">Aktif</span>' : '<span class="badge badge-danger">Tidak Aktif</span>';
          }
        },
        {
          "render": function(data, type, full, meta) {
            var tombol = '<div class="input-group-prepend"><button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Action</button><div class="dropdown-menu" style="height:auto;max-height: 100px;overflow-x:hidden;">'
            tombol += '<a class="dropdown-item" href="javascript:void(0);" onclick="fun_detail(`' + full.template_logsheet_id + '`)">Detail</a>'
            tombol += '<a class="dropdown-item" href="javascript:void(0);" onclick="fun_edit(`' + full.template_logsheet_id + '`)" data-toggle="modal" data-target="#modal">Edit</a>'
            tombol += '<a class="dropdown-item" href="javascript:void(0);" onclick="fun_delete(`' + full.template_logsheet_id + '`)">Hapus</a>'
            tombol += '<a class="dropdown-item" href="<?= base_url('master/template_logsheet/download_excel?template_logsheet_id=') ?>' + full.template_logsheet_id + '" target="_blank">Download Single</a>'
            tombol += '<a class="dropdown-item" href="<?= base_url('master/template_logsheet/download_excel_multiple?template_logsheet_id=') ?>' + full.template_logsheet_id + '" target="_blank">Download Multiple</a>'
            tombol += '</div></div>';
            return tombol;
          }
        },
      ]
    }).columns.adjust();
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
      "ajax": {
        "url": "<?= base_url() ?>/master/template_logsheet/getDetailLogsheet?template_logsheet_detail_id=0",
        "dataSrc": ""
      },
      "columns": [
        // {
        //     render: function(data, type, full, meta) {
        //         return meta.row + meta.settings._iDisplayStart + 1;
        //     }
        // },
        {
          "data": "detail_logsheet_urut"
        },
        {
          "data": "rumus_nama"
        },
        {
          "render": function(data, type, full, meta) {
            return (full.is_sertifikat == 'y') ? 'Iya' : 'Tidak';
          }
        },
        {
          "render": function(data, type, full, meta) {
            return '<center><a href="javascript:;" id="' + full.template_logsheet_detail_id + '" title="Edit" onclick="fun_edit_detail(this.id)"><i class="fa fa-edit" data-toggle="modal" data-target="#modal_detail" style="color: orange"></i></a></center>';
          }
        },
        {
          "render": function(data, type, full, meta) {
            return '<center><a href="javascript:;" id="' + full.template_logsheet_detail_id + '" title="Hapus" onclick="fun_delete_detail(this.id)"><i class="fa fa-trash" style="color: red"></i></a></center>';
          }
        },
      ]
    });
    /* Isi Table Detail */

    $('#template_logsheet_file').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url('master/template_logsheet/getMasterTemplate') ?>',
        dataType: 'json',
        type: 'GET',
        data: function(params) {
          var queryParameters = {
            logsheet_template_nama: params.term
          }

          return queryParameters;
        }
      }
    });

    $('#logsheet_nama_rumus').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url('master/template_logsheet/getMasterRumus') ?>',
        dataType: 'json',
        type: 'GET',
        data: function(params) {
          var queryParameters = {
            rumus_nama: params.term
          }

          return queryParameters;
        }
      }
    });

    $('.select2-selection').css('height', '37px');
    $('.select2').css('width', '100%');
    /* Select2 */
  });

  /* Proses */
  $("#form_modal").on("submit", function(e) {
    e.preventDefault();
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        if ($('#template_logsheet_id').val() != '') var url = '<?= base_url('master/template_logsheet/updateTemplateLogsheet') ?>';
        else var url = '<?= base_url('master/template_logsheet/insertTemplateLogsheet') ?>';

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
        $.getJSON('<?= base_url('master/template_logsheet/getTemplateLogsheet') ?>', {
          template_logsheet_id: id
        }, function(json) {
          $.each(json, function(index, val) {
            $('#' + index).val(val);
          });

          // $('#template_logsheet_file').append('<option selected value="' + json.logsheet_template_id + '">' + json.logsheet_template_nama + '</option>');
          // $('#template_logsheet_file').select2('data', {
          //     id: json.logsheet_template_id,
          //     text: json.logsheet_template_nama
          // });

          if (json.is_aktif == 'y') $('#is_aktif').prop('checked', true);
          $('#is_aktif').val('y');

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
          $.get('<?= base_url('master/template_logsheet/deleteTemplateLogsheet') ?>', {
            template_logsheet_id: id
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
    $("#template_logsheet_file").empty();
    $('#form_modal')[0].reset();
    $('#table').DataTable().ajax.reload();
    fun_loading();
  }
  /* Fun Close */


  /* Fun Detail */
  function fun_detail(id) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $('#div_detail').css('display', 'block');
        $('#table_detail').DataTable().ajax.url('<?= base_url('master/template_logsheet/getDetailLogsheet?id_logsheet_template=') ?>' + id).load();
        $('#id_logsheet_detail').val(id);
        $('html, body').animate({
          scrollTop: $("#div_detail").offset().top
        }, 10);

        fun_rumus(id);
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
        $('#temp_logsheet_id').val($('#id_logsheet_detail').val());
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
        $.getJSON('<?= base_url('master/template_logsheet/getDetailLogsheet') ?>', {
          template_logsheet_detail_id: id
        }, function(json) {
          $.each(json, function(index, val) {
            $('#' + index).val(val);
          });

          $('#logsheet_nama_rumus').append('<option selected value="' + json.rumus_id + '">' + json.rumus_nama + '</option>');
          $('#logsheet_nama_rumus').select2('data', {
            id: json.rumus_id,
            text: json.rumus_nama
          });

          $('#temp_logsheet_id').val(json.id_logsheet_template);
          $('#is_sertifikat').val(json.is_sertifikat);
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
        if ($('#template_logsheet_detail_id').val() != '') var url = '<?= base_url('master/template_logsheet/updateTemplateLogsheetDetail') ?>';
        else var url = '<?= base_url('master/template_logsheet/insertTemplateLogsheetDetail') ?>';

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

  /* Fun Delete */
  function fun_delete_detail(id) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $.confirmModal('Apakah anda yakin akan menghapusnya?', function(el) {
          $.get('<?= base_url('master/template_logsheet/deleteTemplateLogsheetDetail') ?>', {
            template_logsheet_detail_id: id
          }, function(data) {
            $('#close_detail').click();
            toastr.success('Berhasil');
          });
        });
      }
    });
  }

  /* Fun Close Detail */
  function fun_close_detail() {
    $('#simpan_detail').css('display', 'block');
    $('#edit_detail').css('display', 'none');
    $("#logsheet_nama_rumus").empty();
    $('#form_modal_detail')[0].reset();
    $('#table_detail').DataTable().ajax.reload();
    fun_loading();
  }
  /* Fun Close Detail */

  $('#modal_detail').on('hidden.bs.modal', function(e) {
    fun_close_detail();
  });

  function fun_loading() {
    var simplebar = new Nanobar();
    simplebar.go(100);
  }


  function fun_rumus(id) {
    var html = "";
    $.getJSON('<?= base_url("master/template_logsheet/getDetailLogsheet") ?>', {
      id_logsheet_template: id
    }, function(json) {
      html += '<div class="row">';
      $.each(json, function(index, val) {
        html += '<h3 class="card-title">';
        html += val.rumus_nama + ' = <b id="list_' + val.rumus_id + '"></b>';
        html += '<br/>Metode = <b>' + val.metode + '</b>';
        html += '<br/>Satuan = <b>' + val.satuan_sample + '</b>';
        html += '</h3>';
        html += '<div class=" form-group col-12 row">';
        html += '<table id="' + val.rumus_id + '" class="table table-bordered table-striped" width="100%">';
        html += '<thead id="header_' + val.rumus_id + '"></thead>';
        html += '<tbody id="body_' + val.rumus_id + '"></tbody>';
        html += '</table>';
        html += '</div>';
        fun_detail_rumus(val.rumus_id, val.satuan_sample, val.batasan_emisi);
        fun_list_rumus(val.rumus_id);
      });
      html += '</div>';

      $('#div_rumus').html(html);
    });
  }

  function fun_detail_rumus(id, satuan, batasan) {
    var header = "";
    var body = "";
    var footer = "";
    $.getJSON('<?= base_url('master/perhitungan_sample/getDetailRumusSampleTemplate') ?>', {
      id_rumus: id
    }, function(json) {
      header += '<tr ><th>No</th>';
      body += '<tr class="tr" id="tr_' + id + '">';
      body += '<td>';
      body += '<input type="text" name="logsheet_detail_urut[]" id="logsheet_detail_urut_' + id + '" value="1" style="display:none">1';
      body += '<input type="text" value="1" name="logsheet_detail_urut_baris[]" id="logsheet_detail_urut_baris_' + id + '" style="display:none"><input type="text" id="logsheet_rumus_id_' + id + '" value="' + id + '" name="logsheet_rumus_id[]" style="display:none">'
      body += '<input type="text" name="logsheet_detail_id[]" style="display:none" id="logsheet_detail_id_' + id + '" value="' + (Date.now()) + '"></td>';

      footer += '<tr class="tr_foot_' + id + '" id="tr_foot_' + id + '" style="display:none">'

      $.each(json, function(index, val) {
        header += '<th>' + val.rumus_detail_nama + '</th>';
        if (val.rumus_detail_input != null) body += '<td><input type="text" id="' + val.rumus_detail_id + '" name="' + val.rumus_detail_id + '" class="form-control" value="' + val.rumus_detail_input + '" readonly></td>';
        else body += '<td><input type="number" id="' + val.rumus_detail_id + '" name="' + val.rumus_detail_id + '" class="form-control"></td>';

      });
      header += '<th>Hasil</th></tr>';
      body += '<td>'
      body += '<input type="text" class="form-control" id="hasil_' + id + '" name="' + id + '" readonly onclick="fun_hitung(this.name)" >'
      body += '<input type="text" class="form-control" id="rumus_detail_hasil_' + id + '" name="rumus_detail_hasil[]" style="display:none"></td>'
      body += '</tr>';
      $('#header_' + id).html(header);
      $('#body_' + id).append(body);
    });
  }

  function fun_list_rumus(id) {
    var html = "";
    $.getJSON('<?= base_url() ?>master/perhitungan_sample/getListRumus', {
      id_rumus: id
    }, function(json) {
      $.each(json, function(index, val) {
        html += val.rumus;
      });

      $('#list_' + id).html(html);
    });
  }

  function fun_hitung(id) {
    $.getJSON('<?= base_url() ?>master/perhitungan_sample/getDetailRumusSample', {
      id_rumus: id
    }, function(json) {
      var rumus = '';
      var desimal = '';
      var batasan = '';
      $.each(json, function(index, val) {
        if (val.rumus_jenis == 'I') rumus += '(' + $('#' + val.rumus_detail_id).val() + ')';
        else rumus += val.rumus_detail_input;

        desimal = val.desimal_angka;
        batasan = val.batasan_emisi;
      });

      // console.log(rumus);
      var hasil = math.evaluate(rumus);
      $('#hasil_' + id).val(hasil.toFixed(desimal));
      $('#rumus_detail_hasil_' + id).val(hasil.toFixed(2));
      console.log(hasil);

      /* Cek Checklist */
      $('#kesimpulan1_' + id).val('');
      if ($('#hasil_' + id).val() < $('#nilai_batasan_' + id).val()) {
        $('#kesimpulan1_' + id).val('√');
      } else {
        $('#kesimpulan1_' + id).val('X');
      }
      /* Cek Checklist */

      /* Cek Kesimpulan */
      $('#kesimpulan2_' + id).val('');
      if ($('#hasil_' + id).val() < $('#nilai_batasan_' + id).val()) {
        $('#kesimpulan2_' + id).val('Aman');
      } else {
        $('#kesimpulan2_' + id).val('Over');
      }
      /* Cek Kesimpulan */
    });
  }

  // * Simplo * //
  function add_simplo(id, satuan, batasan) {
    var form = "";
    var header = "";
    var body = "";
    var footer = "";
    var jumlah = $('tbody #tr_' + id).length + 1;
    $.getJSON('<?= base_url() ?>/master/perhitungan_sample/getDetailRumusSampleTemplate', {
      id_rumus: id
    }, function(json) {
      form += '<form id="form_logsheet_detail">';
      header += '<tr ><th>No</th>';
      body += '<tr class="tr" id="tr_' + id + '"><td>\
    <input type="text" name="logsheet_detail_urut[]" id="logsheet_detail_urut_' + id + '_' + jumlah + '" value="' + jumlah + '" style="display:none">\
    ' + jumlah + '\
    <input type="text" value="' + jumlah + '" name="logsheet_detail_urut_baris[]" id="logsheet_detail_urut_baris_' + id + '_' + jumlah + '" style="display:none">\
    <input type="text" id="logsheet_rumus_id_' + id + '_' + jumlah + '" value="' + id + '" name="logsheet_rumus_id[]" style="display:none"><input type="text" name="logsheet_detail_id[]" style="display:none" id="logsheet_detail_id_' + id + '_' + jumlah + '" value="' + (Date.now() * jumlah) + '"></td>';
      footer += '<tr class="tr_foot_' + id + '" id="tr_foot_' + id + '_' + jumlah + '">'
      $.each(json, function(index, val) {
        header += '<th>' + val.rumus_detail_nama + '</th>';
        if (val.rumus_detail_input != null) body += '<td><input type="text" id="' + val.rumus_detail_id + '" name="' + val.rumus_detail_id + '" class="form-control" value="' + val.rumus_detail_input + '" readonly></td>';
        else body += '<td><input type="number" id="' + val.rumus_detail_id + '" name="' + val.rumus_detail_id + '" class="form-control"></td>';
      });

      header += '<th>Hasil</th><th>Satuan</th><th></th><th>Batasan mg/NM3</th><th>Kesimpulan</th><th>Aksi</th></tr>';
      body += '\
    <td>\
    <input type="text" class="form-control hasil_' + id + '" id="hasil_' + id + '_' + jumlah + '" name="hasil_' + id + '[' + jumlah + ']" readonly placeholder="klik u/ hasil">\
    <br>\
    <input type="text" class="form-control" id="rumus_detail_hasil_' + id + '_' + jumlah + '" name="rumus_detail_hasil[]" style="display:none">\
    </td>\
    <td><input type="text" id="rumus_satuan_' + id + '" name="rumus_satuan[]" value="' + satuan + '" class="form-control"></td>\
    <td><input type="text" class="form-control" id="kesimpulan1_' + id + '" name="' + id + '" readonly></td>\
    <td><input type="text" id="nilai_batasan_' + id + '" name="nilai_batasan[]" value="' + batasan + '" readonly class="form-control"></td>\
    <td><input type="text" class="form-control" id="kesimpulan2_' + id + '" name="' + id + '" readonly></td>\
    <td>\
    <a href="javascript:void(0);" id="' + id + '" onclick="add_simplo(this.id)"><i class="fa fa-plus" style="color:green"></i></a><br>\
    <a href="javascript:void(0);" id="remove_simplo" ><i class="fa fa-minus" style="color:red"></i></a>\
    <br>\
    </td></tr>';
      footer += '<td colspan="' + (json.length + 1) + '"><p>Rata-rata </p></td><td><input class="form-control" placeholder="klik untuk rata-rata" type="text" id="rata_' + id + '_' + jumlah + '" name="rata_rata[]" onclick="fun_average(`' + id + '`)" readonly></td></tr>';

      form += '</form>';

      $('#header_' + id).html(header);
      $('#body_' + id).append(body);
      $('#footer_' + id).append(footer);

    });

    $(document).on('click', '#hasil_' + id + '_' + jumlah, function() {
      $.getJSON('<?= base_url() ?>/master/perhitungan_sample/getDetailRumusSample', {
        id_rumus: id
      }, function(json) {
        var rumus = '';
        $.each(json, function(index, val) {
          if (val.rumus_jenis == 'I') rumus += '(' + $('#rumus_detail_isi' + val.rumus_detail_id + '_' + jumlah).val() + ')';
          else rumus += val.rumus_detail_input;
        });

        var hasil = math.evaluate(rumus);
        $('#hasil_' + id + '_' + jumlah).val(hasil.toFixed(2));
        $('#rumus_detail_hasil_' + id + '_' + jumlah).val(hasil.toFixed(2));
      });
    })
  }

  $(document).on('click', '#remove_simplo', function() {
    $(this).parents("tr").remove();
  })
  // * Simplo * //
</script>