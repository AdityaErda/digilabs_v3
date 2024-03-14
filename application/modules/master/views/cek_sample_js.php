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
        "url": "<?= base_url() ?>/master/cek_sample/getTemplateLogsheet",
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
            return full.when_create + ' - ' + full.who_create;
          }
        },
        {
          "render": function(data, type, full, meta) {
            return (full.is_aktif == 'y') ? '<span class="badge badge-success">Aktif</span>' : '<span class="badge badge-danger">Tidak Aktif</span>';
          }
        },
        {
          "render": function(data, type, full, meta) {
            return '<center><a href="javascript:void(0)" class="btn btn-primary" onclick="fun_detail(`' + full.template_logsheet_id + '`,`' + full.cek_sample_id + '`);">Detail</a></center>';
          }
        }, {
          "render": function(data, type, full, meta) {
            return '<center><a href="javascript:void(0)" class="btn btn-success" onclick="func_import(`' + full.template_logsheet_id + '`);">Import XLS</a></center>';
          }
        }
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

    $('.select2-selection').css('height', '37px');
    $('.select2').css('width', '100%');
    /* Select2 */
  });


  /* import */
  function func_import(id) {
    $('#modal_import').modal('toggle');
    $('#template_logsheet_id_import').val(id);
  }
  /* import */

  /* Proses Import */
  $("#form_modal_import").on("submit", function(e) {
    e.preventDefault();
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        var url = '<?= base_url('master/cek_sample/prosesCekSample') ?>';
        e.preventDefault();
        $.ajax({
          url: url,
          data: new FormData($('#form_modal_import')[0]),
          type: 'POST',
          dataType: 'html',
          processData: false,
          contentType: false,
          cache: false,
          success: function(isi) {
            // insertSample();
            $('#close_import_click');
            location.reload();
          }
        });
      }
    });
  });

  function insertSample() {
    var url = '<?= base_url('master/cek_sample/insertSample') ?>';
    $.ajax({
      type: "POST",
      url: url,
      data: new FormData($('#form_modal_import')[0]),
      dataType: "HTML",
      processData: false,
      contentType: false,
      cache: false,
      success: function(response) {

      }
    });
  }
  /* Proses Import */



  /* Fun Detail */
  function fun_detail(id, cek_id) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $('#div_detail').css('display', 'block');
        $('#table_detail').DataTable().ajax.url('<?= base_url('master/template_logsheet/getDetailLogsheet?id_logsheet_template=') ?>' + id).load();
        $('#id_logsheet_detail').val(id);
        $('#label_nama_logsheet').html(name);
        $('#template_logsheet_id').val(id);
        $('html, body').animate({
          scrollTop: $("#div_detail").offset().top
        }, 10);
        fun_rumus(id, cek_id);
      }
    });
  }
  /* Fun Detail */

  /* Fun Rumus */
  function fun_rumus(id, cek_id) {
    var html = "";
    $.getJSON('<?= base_url('master/cek_sample/getCekSample') ?>', {
      cek_sample_id: cek_id
    }, function(json) {
      if (json != null) {
        $.getJSON('<?= base_url() ?>/master/template_logsheet/getDetailLogsheet', {
          id_logsheet_template: id,
        }, function(data) {
          $.each(data, function(index, val) {
            $.getJSON('<?= base_url('master/cek_sample/getCekSampleDetail') ?>', {
              cek_sample_id: cek_id,
              rumus_id: val.rumus_id
            }, function(isi) {
              var urut = 0;
              $.each(isi, function(i, v) {
                urut++;
                if (urut == 1) {
                  setTimeout(function() {
                    $.getJSON('<?= base_url('master/cek_sample/getCekSampleDetailDetail') ?>', {
                      cek_sample_detail_id: v.cek_sample_detail_id
                    }, function(isi_detail) {
                      $.each(isi_detail, function(i_detail, v_detail) {
                        $('#rumus_detail_isi' + v_detail.rumus_detail_id).val(v_detail.rumus_detail_isi);
                      });
                    });

                    $('#hasil_' + val.rumus_id).val(v.rumus_hasil);
                    $('#rumus_deta il_hasil_' + val.rumus_id).val(v.rumus_hasil);
                    $('#rumus_satuan_' + val.rumus_id).val(v.rumus_satuan);
                    $('#rumus_metoda_' + val.rumus_id).val(v.rumus_metoda);
                  }, 5000);
                } else {
                  add_simplo_logsheet(val.rumus_id, v.rumus_satuan, v.rumus_metoda, urut);
                  setTimeout(function() {
                    $.getJSON('<?= base_url('master/cek_sample/getCekSampleDetailDetail') ?>', {
                      cek_sample_detail_id: v.cek_sample_detail_id
                    }, function(isi_detail) {
                      $.each(isi_detail, function(i_detail, v_detail) {
                        $('#rumus_detail_isi' + v_detail.rumus_detail_id + '_' + v.cek_sample_detail_urut).val(v_detail.rumus_detail_isi);
                      });
                    });
                    $('#hasil_' + val.rumus_id + '_' + v.cek_sample_detail_urut).val(v.rumus_hasil);
                    $('#rumus_detail_hasil_' + val.rumus_id + '_' + v.cek_sample_detail_urut).val(v.rumus_hasil);
                    $('#rumus_satuan_' + val.rumus_id + '_' + v.cek_sample_detail_urut).val(v.rumus_satuan);
                    $('#rumus_metoda_' + val.rumus_id + '_' + v.cek_sample_detail_urut).val(v.rumus_metoda);
                    $('#rata_' + val.rumus_id + '_' + v.cek_sample_detail_urut).val(v.rumus_avg);
                    $('#nilai_adbk_' + val.rumus_id + '_' + v.cek_sample_detail_urut).val(v.rumus_adbk);
                  }, 5000);
                }
              });
            });
            // }, 2500);
          });
        });
      }
    });
    $.getJSON('<?= base_url() ?>/master/template_logsheet/getDetailLogsheet', {
      id_logsheet_template: id
    }, function(json) {
      html += '<div class="row">';
      $.each(json, function(index, val) {
        var metoda = (val.metode != null) ? val.metode : '';
        html += '<div class="card-header col-12">';
        html += '<h3 class="card-title">' + val.rumus_nama + ' = <b id="list_' + val.rumus_id + '"></b></h3>';
        html += '<button type="button" id="adbk_' + val.rumus_id + '" name="adbk[]" class="btn btn-info btn-custom float-right" style="display:none" onclick="fun_adbk(`' + val.rumus_id + '`)">ADBK</button>';
        html += '</div>';
        html += '<div class="card-body col-12 row">';
        html += '<div class="col-6">';
        html += '<div class="form-group row col-12">';
        html += '<label class="col-md-4">Metoda</label>';
        html += '<div class="input-group col-md-8">';
        html += '<input type="text" class="form-control" id="rumus_metoda_' + val.rumus_id + '" name="rumus_metoda" readonly>';
        html += '</div>';
        html += '</div>';
        html += '</div>';
        html += '<div class="col-6">';
        html += '<div class="form-group row col-12">';
        html += '<label class="col-md-4">Satuan</label>';
        html += '<div class="input-group col-md-8">';
        html += '<input type="text" class="form-control" name="rumus_satuan" id="rumus_satuan_' + val.rumus_id + '" readonly>';
        html += '</div>';
        html += '</div>';
        html += '</div>';
        html += '<table id="' + val.rumus_id + '" class="table table-bordered datatables" width="100%">';
        html += '<thead id="header_' + val.rumus_id + '"></thead>';
        html += '<tbody id="body_' + val.rumus_id + '"></tbody>';
        html += '<tfoot id="footer_' + val.rumus_id + '"></tfoot>'
        html += '</table>';
        html += '</div>';
        fun_detail_rumus(val.rumus_id, val.satuan_sample, metoda);
        fun_list_rumus(val.rumus_id);
      });
      html += '</div>';

      $('#div_rumus').html(html);
    });
  }
  /* Fun Rumus */

  /* Fun Detail Rumus */
  function fun_detail_rumus(id, satuan, metoda) {
    var header = "";
    var body = "";
    var footer = "";
    var footer_adbk = "";
    var logsheet_detail_id = Date.now();

    $.getJSON('<?= base_url() ?>/master/perhitungan_sample/getDetailRumusSampleTemplate', {
      id_rumus: id
    }, function(json) {
      header += '<tr>';
      header += '<th>No</th>';
      body += '<tr class="tr" id="tr_' + id + '">';
      body += '<td>1</td>'

      footer += '<tr class="tr_foot_' + id + '" id="tr_foot_' + id + '" style="display:none">'
      footer_adbk += '<tr class="tr_foot_adbk_' + id + '" id="tr_foot_adbk_' + id + '" style="display:none">'

      $.each(json, function(index, val) {
        header += '<th>' + val.rumus_detail_nama + '</th>';
        body += '<td>';
        body += '<input type="text" id="rumus_detail_isi' + val.rumus_detail_id + '" name="rumus_detail_isi[]" class="form-control" readonly>';
        body += '</td>';
      });

      header += '<th>Hasil</th>';
      header += '</tr>';

      body += '<td>';
      body += '<input type="text" class="form-control hasil_' + id + '" id="hasil_' + id + '" name="hasil_' + id + '[1]" readonly readonly>';
      body += '</td>';
      body += '</tr>';

      footer += '<td colspan="' + (json.length + 1) + '"><p>Rata-rata </p></td><td><input class="form-control" type="text" id="rata_' + id + '" name="rata_rata[]" readonly style="display:none"></td>';
      footer += '</tr>';

      footer_adbk += '<td colspan="' + (json.length + 1) + '"><p>Rata-rata </p></td><td><input class="form-control" placeholder="klik untuk nilai adbk" type="text" id="nilai_adbk_' + id + '" name="nilai_adbk[]" onclick="fun_nilai_adbk(`' + id + '`)" readonly style="display:none"></td>';
      footer_adbk += '</tr>';

      $('#header_' + id).html(header);
      $('#body_' + id).append(body);
      $('#footer_' + id).append(footer);
      $('#footer_' + id).append(footer_adbk);
    });
  }
  /* Fun Detail Rumus */


  /* Fun List Rumus */
  function fun_list_rumus(id) {
    var html = "";
    $.getJSON('<?= base_url() ?>/master/perhitungan_sample/getListRumus', {
      id_rumus: id
    }, function(json) {
      $.each(json, function(index, val) {
        html += val.rumus;
      });

      $('#list_' + id).html(html);
    });
  }
  /* Fun List Rumus */

  /* Tambah Baris Rumus (jika ada data) */
  function add_simplo_logsheet(id, satuan, metoda, urut) {
    var header = "";
    var body = "";
    var footer = "";
    var footer_adbk = "";
    var jumlah = urut;
    var logsheet_detail_id_detail = Date.now() * jumlah;

    $.getJSON('<?= base_url() ?>/master/perhitungan_sample/getDetailRumusSampleTemplate', {
      id_rumus: id
    }, function(json) {
      header += '<tr>';
      header += '<th>No</th>';

      body += '<tr class="tr" id="tr_' + id + '">';
      body += '<td>';
      body += jumlah;
      body += '</td>';

      footer += '<tr class="tr_foot_' + id + '" id="tr_foot_' + id + '_' + jumlah + '">';
      footer_adbk += '<tr class="tr_foot_adbk_' + id + '" id="tr_foot_adbk_' + id + '_' + jumlah + '">';

      $.each(json, function(index, val) {
        header += '<th>' + val.rumus_detail_nama + '</th>';
        body += '<td>';
        body += '<input type="text" id="rumus_detail_isi' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_isi[]" class="form-control" readonly>';
        body += '</td>';
      });

      header += '<th>Hasil</th>';
      header += '</tr>';

      body += '<td>';
      body += '<input type="text" class="form-control hasil_' + id + '" id="hasil_' + id + '_' + jumlah + '" name="hasil_' + id + '[' + jumlah + ']" readonly>';
      body += '</td>';
      body += '</tr>';

      footer += '<td colspan="' + (json.length + 1) + '"><p>Rata-rata </p></td><td><input class="form-control" type="text" id="rata_' + id + '_' + jumlah + '" name="rata_rata[]" readonly></td>';
      footer += '</tr>';

      footer_adbk += '<td  style="display:none" colspan="' + (json.length + 1) + '"><p>Nilai ADBK </p></td><td style="display:none"><input style="display:none" class="form-control" placeholder="klik untuk nilai_adbk" type="text" id="nilai_adbk_' + id + '_' + jumlah + '" name="nilai_adbk[]" onclick="fun_nilai_adbk(`' + id + '`)" readonly></td>';
      footer_adbk += '</tr>';

      $('#header_' + id).html(header);
      $('#body_' + id).append(body);
      $('.tr_foot_' + id).hide();
      $('#footer_' + id).append(footer);
      $('#footer_' + id).append(footer_adbk);

      $.getJSON('<?= base_url() ?>/master/perhitungan_sample/getPerhitunganSample', {
        rumus_id: id
      }, function(json) {
        if (json.is_adbk == 'y') {
          $('.tr_foot_adbk_' + id).hide();
          $('#footer_' + id).append(footer_adbk);
        }
      });
    });
  }
  /* Tambah Baris Rumus (jika ada data) */

  function fun_loading() {
    var simplebar = new Nanobar();
    simplebar.go(100);
  }
</script>