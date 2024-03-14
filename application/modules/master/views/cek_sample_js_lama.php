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
            return '<center><a href="javascript:void(0)" class="btn btn-primary" onclick="fun_detail_isi(`' + full.template_logsheet_id + '`);">Detail</a></center>';
            // return '<center><a href="javascript:void(0)" class="btn btn-primary" onclick="fun_detail(`' + full.template_logsheet_id + '`,`' + full.template_logsheet_nama + '`);fun_detail_isi(`' + full.template_logsheet_id + '`)">Detail</a></center></center>';
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
  function fun_detail(id, name) {
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
        fun_rumus(id);
      }
    });
  }
  /* Fun Detail */

  /* Fun Detail Isi */
  function fun_detail_isi(id) {
    $('#div_detail').css('display', 'block');
    $('#table_detail').DataTable().ajax.url('<?= base_url('master/template_logsheet/getDetailLogsheet?id_logsheet_template=') ?>' + id).load();
    $('#id_logsheet_detail').val(id);
    $('#label_nama_logsheet').html(name);
    $('#template_logsheet_id').val(id);
    $('html, body').animate({
      scrollTop: $("#div_detail").offset().top
    }, 10);

    fun_rumus(id);

    $.getJSON('<?= base_url('master/cek_sample/cekSample') ?>', {
      template_logsheet_id: id
    }, function(json) {
      if (json != null) {
        $.getJSON('<?= base_url() ?>/master/template_logsheet/getDetailLogsheet', {
          id_logsheet_template: id
        }, function(data) {
          $.each(data, function(index, val) {
            $.getJSON('<?= base_url('master/cek_sample/cekSampleDetail') ?>', {
              cek_sample_id: json.cek_sample_id,
              rumus_id: val.rumus_id
            }, function(isi) {
              var urut = 0;
              $.each(isi, function(i, v) {
                urut++;

                if (urut == 1) {
                  setTimeout(function() {
                    $.getJSON('<?= base_url('master/cek_sample/cekSampleDetailDetail') ?>', {
                      id_cek_sample_detail: v.cek_sample_detail_id
                    }, function(isi_detail) {
                      $.each(isi_detail, function(i_detail, v_detail) {
                        $('#rumus_detail_isi' + v_detail.rumus_detail_id).val(v_detail.rumus_detail_isi);
                      });
                    });
                    $('#rumus_metoda_' + val.rumus_id).val(v.rumus_metoda);
                    $('#hasil_' + val.rumus_id).val(v.rumus_hasil);
                    $('#rumus_detail_hasil_' + val.rumus_id).val(v.rumus_hasil);
                    $('#rumus_satuan_' + val.rumus_id).val(v.rumus_satuan);
                  }, 1000);
                } else {
                  add_simplo_isi(val.rumus_id, v.rumus_satuan, v.rumus_metoda, v.cek_sample_detail_urut_baris);
                  console.log('urut' + v.cek_sample_detail_urut_baris);
                  setTimeout(function() {
                    $.getJSON('<?= base_url('master/cek_sample/cekSampleDetailDetail') ?>', {
                      id_cek_sample_detail: v.cek_sample_detail_id
                    }, function(isi_detail) {
                      $.each(isi_detail, function(i_detail, v_detail) {
                        console.log(v_detail);
                        $('#rumus_detail_isi' + v_detail.rumus_detail_id + '_' + v.cek_sample_detail_urut_baris).val(v_detail.rumus_detail_isi);
                      });
                    });
                    $('#rumus_metoda_' + val.rumus_id + '_' + v.cek_sample_detail_urut_baris).val(v.rumus_metoda);
                    $('#hasil_' + val.rumus_id + '_' + v.cek_sample_detail_urut_baris).val(v.rumus_hasil);
                    $('#rumus_detail_hasil_' + val.rumus_id + '_' + v.cek_sample_detail_urut_baris).val(v.rumus_hasil);
                    $('#rumus_satuan_' + val.rumus_id + '_' + v.cek_sample_detail_urut_baris).val(v.rumus_satuan);
                    $('#rumus_metoda_' + val.rumus_id + '_' + v.cek_sample_detail_urut_baris).val(v.rumus_metoda);
                    $('#rata_' + val.rumus_id + '_' + v.cek_sample_detail_urut_baris).val(v.rumus_avg);
                    $('#nilai_adbk_' + val.rumus_id + '_' + v.cek_sample_detail_urut_baris).val(v.rumus_adbk);
                  }, 1000);
                }
              });
            });
          });
        });
      }
    });
  }
  /* Fun Detail Isi */

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
    $.getJSON('<?= base_url() ?>/master/template_logsheet/getDetailLogsheet', {
      id_logsheet_template: id
    }, function(json) {
      html += '<div class="row">';
      $.each(json, function(index, val) {
        var metoda = (val.metode != null) ? val.metode : '';

        html += '<div class="card-header col-12">';
        html += '<h3 class="card-title">';
        html += val.rumus_nama + ' = <b id="list_' + val.rumus_id + '"></b>';
        html += '<br/>Metode = <b>' + val.metode + '</b>';
        html += '<br/>Satuan = <b>' + val.satuan_sample + '</b>';
        html += '</h3>';
        html += '<br/><br/><br/><p style="color:red;">* Klik Kolom Hasil Untuk Menghitung</p>';
        html += '<button type="button" id="adbk_' + val.rumus_id + '" name="adbk[]" class="btn btn-info btn-custom float-right" style="display:none" onclick="fun_adbk(`' + val.rumus_id + '`)">ADBK</button>';
        html += '</div>';
        html += '<div class="form-group col-12 row">';
        html += '<input type="text" name="rumus_id[]" id="rumus_id_' + id + '" value="' + val.rumus_id + '" style="display:none">';
        html += '<input type="text" name="rumus_nama[]" id="rumus_nama_' + id + '" value="' + val.rumus_nama + '" style="display:none">';
        html += '<table id="' + val.rumus_id + '" class="table table-bordered table-striped datatables" width="100%">';
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
      body += '<td>';
      body += '<input type="text" name="logsheet_detail_urut[]" id="logsheet_detail_urut_' + id + '" value="1" style="display:none">1';
      body += '<input type="text" value="1" name="logsheet_detail_urut_baris[]" id="logsheet_detail_urut_baris_' + id + '" style="display:none"><input type="text" id="logsheet_rumus_id_' + id + '" value="' + id + '" name="logsheet_rumus_id[]" style="display:none">';
      body += '<input type="text" name="logsheet_detail_id[]" style="display:none" id="logsheet_detail_id_' + id + '" value="' + (logsheet_detail_id) + '">';
      body += '</td>';

      footer += '<tr class="tr_foot_' + id + '" id="tr_foot_' + id + '" style="display:none">'
      footer_adbk += '<tr class="tr_foot_adbk_' + id + '" id="tr_foot_adbk_' + id + '" style="display:none">'

      $.each(json, function(index, val) {
        header += '<th>' + val.rumus_detail_nama + '</th>';

        if (val.rumus_detail_input != null) {
          body += '<td>';
          body += '<input type="text" style="display:none" name="logsheet_rumus_id_detail[]" id="logsheet_rumus_id_detail_' + id + '" value="' + id + '">';
          body += '<input type="text" name="logsheet_detail_id_detail[]" style="display:none" id="logsheet_detail_id_detail_' + id + '" value="' + (logsheet_detail_id) + '">';
          body += '<input type="text" style="display:none" id="logsheet_detail_detail_id_' + val.rumus_detail_id + '" name="logsheet_detail_detail_id[]" value="' + (new Date().getMilliseconds() * 3600) + '_' + val.rumus_detail_urut + '">';
          body += '<input type="text" id="rumus_detail_id_' + val.rumus_detail_id + '" name="rumus_detail_id[]" value="' + val.rumus_detail_id + '" class="form-control" style="display:none">';
          body += '<input type="text" id="rumus_detail_nama_' + val.rumus_detail_id + '" name="rumus_detail_nama[]" value="' + val.rumus_detail_nama + '" class="form-control" style="display:none">';
          body += '<input type="text" id="rumus_detail_isi_' + val.rumus_detail_id + '" name="rumus_detail_isi[]" class="form-control" value="' + val.rumus_detail_input + '" readonly>';
          body += '<input type="text" id="rumus_detail_urut_' + val.rumus_detail_id + '" name="rumus_detail_urut[]" value="' + val.rumus_detail_urut + '" style="display:none">';
          body += '<input type="text" id="rumus_detail_template_' + val.rumus_detail_id + '" name="rumus_detail_template[]" value="' + val.rumus_detail_template + '" style="display:none">';
          body += '<input type="text" id="rumus_detail_jenis_' + val.rumus_detail_id + '" name="rumus_detail_jenis[]" value="' + val.rumus_jenis + '" style="display:none">';
          body += '</td>';
        } else {
          body += '<td>';
          body += '<input type="text" style="display:none" name="logsheet_rumus_id_detail[]" id="logsheet_rumus_id_detail_' + id + '" value="' + id + '">';
          body += '<input type="text" name="logsheet_detail_id_detail[]" style="display:none" id="logsheet_detail_id_detail_' + id + '" value="' + (logsheet_detail_id) + '">';
          body += '<input type="text" style="display:none" id="logsheet_detail_detail_id_' + val.rumus_detail_id + '" name="logsheet_detail_detail_id[]" value="' + (new Date().getMilliseconds() * 3600) + '_' + val.rumus_detail_urut + '">';
          body += '<input type="text" id="rumus_detail_id' + val.rumus_detail_id + '" name="rumus_detail_id[]" value="' + val.rumus_detail_id + '" class="form-control" style="display:none">';
          body += '<input type="text" id="rumus_detail_nama' + val.rumus_detail_nama + '" name="rumus_detail_nama[]" value="' + val.rumus_detail_nama + '" class="form-control" style="display:none">';
          body += '<input type="number" id="rumus_detail_isi' + val.rumus_detail_id + '" name="rumus_detail_isi[]" class="form-control">';
          body += '<input type="text" id="rumus_detail_urut_' + val.rumus_detail_id + '" name="rumus_detail_urut[]" value="' + val.rumus_detail_urut + '" style="display:none">';
          body += '<input type="text" id="rumus_detail_template_' + val.rumus_detail_id + '" name="rumus_detail_template[]" value="' + val.rumus_detail_template + '" style="display:none">';
          body += '<input type="text" id="rumus_detail_jenis_' + val.rumus_detail_id + '" name="rumus_detail_jenis[]" value="' + val.rumus_jenis + '" style="display:none">';
          body += '</td>';
        }
      });
      header += '<th>Hasil</th>';
      header += '<th>Aksi</th>';
      header += '</tr>';

      body += '<td>';
      body += '<input type="text" class="form-control hasil_' + id + '" id="hasil_' + id + '" name="hasil_' + id + '[1]" onclick="fun_hitung(`' + id + '`);fun_store_history(`' + id + '`)" placeholder="klik u/ hasil">';
      body += '<input type="text" class="form-control" id="rumus_detail_hasil_' + id + '" name="rumus_detail_hasil[]" style="display:none">';
      body += '</td>';
      body += '<td width="20px">';
      body += '<a href="javascript:void(0);" id="' + id + '" onclick="add_simplo(this.id,`' + satuan + '`,`' + metoda + '`)"><i class="fa fa-plus" style="color:green"></i></a><br>';
      body += '</td>';
      body += '</tr>';

      footer += '<td colspan="' + (json.length + 1) + '"><p>Rata-rata </p></td><td><input class="form-control" placeholder="klik untuk rata-rata" type="text" id="rata_' + id + '" name="rata_rata[]" onclick="fun_average(`' + id + '`)" readonly style="display:none"></td>';
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

  /* Tambah Baris Rumus */
  function add_simplo(id, satuan, metoda, urut = null) {
    var header = "";
    var body = "";
    var footer = "";
    var footer_adbk = "";
    var jumlah = $('tbody #tr_' + id).length + 1;
    console.log(jumlah);
    var logsheet_detail_id_detail = Date.now() * jumlah;

    $.getJSON('<?= base_url() ?>/master/perhitungan_sample/getDetailRumusSampleTemplate', {
      id_rumus: id
    }, function(json) {
      header += '<tr>';
      header += '<th>No</th>';

      body += '<tr class="tr" id="tr_' + id + '">';
      body += '<td>';
      body += '<input type="text" name="logsheet_detail_urut[]" id="logsheet_detail_urut_' + id + '_' + jumlah + '" value="' + jumlah + '" style="display:none">' + jumlah;
      body += '<input type="text" value="' + jumlah + '" name="logsheet_detail_urut_baris[]" id="logsheet_detail_urut_baris_' + id + '_' + jumlah + '" style="display:none">';
      body += '<input type="text" id="logsheet_rumus_id_' + id + '_' + jumlah + '" value="' + id + '" name="logsheet_rumus_id[]" style="display:none"><input type="text" name="logsheet_detail_id[]" style="display:none" id="logsheet_detail_id_' + id + '_' + jumlah + '" value="' + (logsheet_detail_id_detail) + '">';
      body += '</td>';

      footer += '<tr class="tr_foot_' + id + '" id="tr_foot_' + id + '_' + jumlah + '">';
      footer_adbk += '<tr class="tr_foot_adbk_' + id + '" id="tr_foot_adbk_' + id + '_' + jumlah + '">';

      $.each(json, function(index, val) {
        header += '<th>' + val.rumus_detail_nama + '</th>';

        if (val.rumus_detail_input != null) {
          body += '<td>';
          body += '<input type="text" style="display:none" name="logsheet_rumus_id_detail[]" id="logsheet_rumus_id_detail_' + id + '_' + jumlah + '" value="' + id + '">';
          body += '<input type="text" name="logsheet_detail_id_detail[]" style="display:none" id="logsheet_detail_id_detail_' + id + '_' + jumlah + '" value="' + (logsheet_detail_id_detail) + '">';
          body += '<input type="text" style="display:none" id="logsheet_detail_detail_id_' + val.rumus_detail_id + '_' + jumlah + '" name="logsheet_detail_detail_id[]" value="' + (new Date().getMilliseconds() * 3600 * jumlah) + '_' + val.rumus_detail_urut + '">';
          body += '<input type="text" id="rumus_detail_id_' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_id[]" value="' + val.rumus_detail_id + '" class="form-control" style="display:none">';
          body += '<input type="text" id="rumus_detail_nama_' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_nama[]" value="' + val.rumus_detail_nama + '" class="form-control" style="display:none">';
          body += '<input type="text" id="rumus_detail_isi_' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_isi[]" class="form-control" value="' + val.rumus_detail_input + '" readonly>';
          body += '<input type="text" id="rumus_detail_urut_' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_urut[]" value="' + val.rumus_detail_urut + '" style="display:none">';
          body += '<input type="text" id="rumus_detail_template_' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_template[]" value="' + val.rumus_detail_template + '" style="display:none">';
          body += '<input type="text" id="rumus_detail_jenis_' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_jenis[]" value="' + val.rumus_jenis + '" style="display:none">';
          body += '</td>';
        } else {
          body += '<td>';
          body += '<input type="text" style="display:none" name="logsheet_rumus_id_detail[]" id="logsheet_rumus_id_detail_' + id + '_' + jumlah + '" value="' + id + '">';
          body += '<input type="text" name="logsheet_detail_id_detail[]" style="display:none" id="logsheet_detail_id_detail_' + id + '_' + jumlah + '" value="' + (logsheet_detail_id_detail) + '">';
          body += '<input type="text" style="display:none" id="logsheet_detail_detail_id_' + val.rumus_detail_id + '_' + jumlah + '" name="logsheet_detail_detail_id[]" value="' + (new Date().getMilliseconds() * 3600 * jumlah) + '_' + val.rumus_detail_urut + '">';
          body += '<input type="text" id="rumus_detail_id' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_id[]" value="' + val.rumus_detail_id + '" class="form-control" style="display:none">';
          body += '<input type="text" id="rumus_detail_nama' + val.rumus_detail_nama + '_' + jumlah + '" name="rumus_detail_nama[]" value="' + val.rumus_detail_nama + '" class="form-control" style="display:none">';
          body += '<input type="number" id="rumus_detail_isi' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_isi[]" class="form-control">';
          body += '<input type="text" id="rumus_detail_urut_' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_urut[]" value="' + val.rumus_detail_urut + '" style="display:none">';
          body += '<input type="text" id="rumus_detail_template_' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_template[]" value="' + val.rumus_detail_template + '" style="display:none">';
          body += '<input type="text" id="rumus_detail_jenis_' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_jenis[]" value="' + val.rumus_jenis + '" style="display:none">';
          body += '</td>';
        }
      });

      header += '<th>Hasil</th>';
      header += '<th>Aksi</th>';
      header += '</tr>';

      body += '<td>';
      body += '<input type="text" class="form-control hasil_' + id + '" id="hasil_' + id + '_' + jumlah + '" name="hasil_' + id + '[' + jumlah + ']" placeholder="klik u/ hasil">';
      body += '<input type="text" class="form-control" id="rumus_detail_hasil_' + id + '_' + jumlah + '" name="rumus_detail_hasil[]" style="display:none">';
      body += '</td>';
      body += '<td>';
      body += '<a href="javascript:void(0);" id="' + id + '" onclick="add_simplo(this.id,`' + satuan + '`,`' + metoda + '`)"><i class="fa fa-plus" style="color:green"></i></a><br>';
      body += '<a href="javascript:void(0);" id="remove_simplo" ><i class="fa fa-minus" style="color:red"></i></a>';
      body += '</td>';
      body += '</tr>';

      footer += '<td colspan="' + (json.length + 1) + '"><p>Rata-rata </p></td><td><input class="form-control" placeholder="klik untuk rata-rata" type="text" id="rata_' + id + '_' + jumlah + '" name="rata_rata[]" onclick="fun_average(`' + id + '`)" readonly></td>';
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
    });
  }

  function add_simplo_isi(id, satuan, metoda, urut) {
    var header = "";
    var body = "";
    var footer = "";
    var footer_adbk = "";
    var jumlah = urut;
    console.log(jumlah);
    var logsheet_detail_id_detail = Date.now() * jumlah;

    $.getJSON('<?= base_url() ?>/master/perhitungan_sample/getDetailRumusSampleTemplate', {
      id_rumus: id
    }, function(json) {
      header += '<tr>';
      header += '<th>No</th>';

      body += '<tr class="tr" id="tr_' + id + '">';
      body += '<td>';
      body += '<input type="text" name="logsheet_detail_urut[]" id="logsheet_detail_urut_' + id + '_' + jumlah + '" value="' + jumlah + '" style="display:none">' + jumlah;
      body += '<input type="text" value="' + jumlah + '" name="logsheet_detail_urut_baris[]" id="logsheet_detail_urut_baris_' + id + '_' + jumlah + '" style="display:none">';
      body += '<input type="text" id="logsheet_rumus_id_' + id + '_' + jumlah + '" value="' + id + '" name="logsheet_rumus_id[]" style="display:none"><input type="text" name="logsheet_detail_id[]" style="display:none" id="logsheet_detail_id_' + id + '_' + jumlah + '" value="' + (logsheet_detail_id_detail) + '">';
      body += '</td>';

      footer += '<tr class="tr_foot_' + id + '" id="tr_foot_' + id + '_' + jumlah + '">';
      footer_adbk += '<tr class="tr_foot_adbk_' + id + '" id="tr_foot_adbk_' + id + '_' + jumlah + '">';

      $.each(json, function(index, val) {
        header += '<th>' + val.rumus_detail_nama + '</th>';

        if (val.rumus_detail_input != null) {
          body += '<td>';
          body += '<input type="text" style="display:none" name="logsheet_rumus_id_detail[]" id="logsheet_rumus_id_detail_' + id + '_' + jumlah + '" value="' + id + '">';
          body += '<input type="text" name="logsheet_detail_id_detail[]" style="display:none" id="logsheet_detail_id_detail_' + id + '_' + jumlah + '" value="' + (logsheet_detail_id_detail) + '">';
          body += '<input type="text" style="display:none" id="logsheet_detail_detail_id_' + val.rumus_detail_id + '_' + jumlah + '" name="logsheet_detail_detail_id[]" value="' + (new Date().getMilliseconds() * 3600 * jumlah) + '_' + val.rumus_detail_urut + '">';
          body += '<input type="text" id="rumus_detail_id_' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_id[]" value="' + val.rumus_detail_id + '" class="form-control" style="display:none">';
          body += '<input type="text" id="rumus_detail_nama_' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_nama[]" value="' + val.rumus_detail_nama + '" class="form-control" style="display:none">';
          body += '<input type="text" id="rumus_detail_isi_' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_isi[]" class="form-control" value="' + val.rumus_detail_input + '" readonly>';
          body += '<input type="text" id="rumus_detail_urut_' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_urut[]" value="' + val.rumus_detail_urut + '" style="display:none">';
          body += '<input type="text" id="rumus_detail_template_' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_template[]" value="' + val.rumus_detail_template + '" style="display:none">';
          body += '<input type="text" id="rumus_detail_jenis_' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_jenis[]" value="' + val.rumus_jenis + '" style="display:none">';
          body += '</td>';
        } else {
          body += '<td>';
          body += '<input type="text" style="display:none" name="logsheet_rumus_id_detail[]" id="logsheet_rumus_id_detail_' + id + '_' + jumlah + '" value="' + id + '">';
          body += '<input type="text" name="logsheet_detail_id_detail[]" style="display:none" id="logsheet_detail_id_detail_' + id + '_' + jumlah + '" value="' + (logsheet_detail_id_detail) + '">';
          body += '<input type="text" style="display:none" id="logsheet_detail_detail_id_' + val.rumus_detail_id + '_' + jumlah + '" name="logsheet_detail_detail_id[]" value="' + (new Date().getMilliseconds() * 3600 * jumlah) + '_' + val.rumus_detail_urut + '">';
          body += '<input type="text" id="rumus_detail_id' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_id[]" value="' + val.rumus_detail_id + '" class="form-control" style="display:none">';
          body += '<input type="text" id="rumus_detail_nama' + val.rumus_detail_nama + '_' + jumlah + '" name="rumus_detail_nama[]" value="' + val.rumus_detail_nama + '" class="form-control" style="display:none">';
          body += '<input type="number" id="rumus_detail_isi' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_isi[]" class="form-control">';
          body += '<input type="text" id="rumus_detail_urut_' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_urut[]" value="' + val.rumus_detail_urut + '" style="display:none">';
          body += '<input type="text" id="rumus_detail_template_' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_template[]" value="' + val.rumus_detail_template + '" style="display:none">';
          body += '<input type="text" id="rumus_detail_jenis_' + val.rumus_detail_id + '_' + jumlah + '" name="rumus_detail_jenis[]" value="' + val.rumus_jenis + '" style="display:none">';
          body += '</td>';
        }
      });

      header += '<th>Hasil</th>';
      header += '<th>Aksi</th>';
      header += '</tr>';
      body += '<td>';
      body += '<input type="text" class="form-control hasil_' + id + '" id="hasil_' + id + '_' + jumlah + '" name="hasil_' + id + '[' + jumlah + ']"  placeholder="klik u/ hasil">';
      body += '<input type="text" class="form-control" id="rumus_detail_hasil_' + id + '_' + jumlah + '" name="rumus_detail_hasil[]" style="display:none">';
      body += '</td>';
      body += '<td>';
      body += '<a href="javascript:void(0);" id="' + id + '" onclick="add_simplo(this.id,`' + satuan + '`,`' + metoda + '`)"><i class="fa fa-plus" style="color:green"></i></a><br>';
      body += '<a href="javascript:void(0);" id="remove_simplo" ><i class="fa fa-minus" style="color:red"></i></a>';
      body += '</td>';
      body += '</tr>';

      footer += '<td colspan="' + (json.length + 1) + '"><p>Rata-rata </p></td><td><input class="form-control" placeholder="klik untuk rata-rata" type="text" id="rata_' + id + '_' + jumlah + '" name="rata_rata[]" onclick="fun_average(`' + id + '`)" readonly></td>';
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
    });
  }
  /* Tambah Baris Rumus */

  /* Hapus Baris Rumus */
  $(document).on('click', '#remove_simplo', function() {
    $(this).parents("tr").remove();
  });
  /* Hapus Baris Rumus */

  /* Fun Hitung */
  function fun_hitung(id) {
    $.getJSON('<?= base_url() ?>/master/perhitungan_sample/getDetailRumusSample', {
      id_rumus: id
    }, function(json) {
      var rumus = '';
      $.each(json, function(index, val) {
        if (val.rumus_jenis == 'I') rumus += '(' + $('#rumus_detail_isi' + val.rumus_detail_id).val() + ')';
        else if (val.rumus_jenis == 'A') rumus += '(' + val.rumus_detail_input + ')';
        else rumus += val.rumus_detail_input;
      });

      var hasil = (math.evaluate(rumus));
      $('#hasil_' + id).val(hasil.toFixed(2));
      $('#rumus_detail_hasil_' + id).val(hasil.toFixed(2));
    });
  }
  /* Fun Hitung */

  /* Fun Log History */
  function fun_store_history(id) {
    // $.getJSON('<?= base_url() ?>/master/perhitungan_sample/getDetailRumusSample', {
    //     id_rumus: id
    // }, function(json) {
    //     var rumus = '';
    //     var rumus_detail_nama = '';

    //     $.each(json, function(index, val) {
    //         if (val.rumus_jenis == 'I') rumus += '(' + $('#rumus_detail_isi' + val.rumus_detail_id).val() + ')';
    //         else if (val.rumus_jenis == 'A') rumus += '(' + val.rumus_detail_input + ')';
    //         else rumus += val.rumus_detail_input;

    //         if (val.rumus_jenis == 'O') rumus_detail_nama += val.rumus_detail_input;
    //         else rumus_detail_nama += val.rumus_detail_nama;
    //     });

    //     var hasil = (math.evaluate(rumus));
    //     var url = '<?= base_url('sample/inbox/storeLogsheetHistory') ?>';
    //     var data = new FormData($('#form_logsheet')[0]);
    //     data.append('logsheet_rumus_nama', rumus_detail_nama)
    //     data.append('logsheet_rumus', rumus);
    //     data.append('logsheet_hasil', hasil);

    //     $.ajax({
    //         url: url,
    //         type: 'POST',
    //         dataType: 'HTML',
    //         data: data,
    //         processData: false,
    //         contentType: false,
    //         cache: false,
    //     });
    // });
  }
  /* Fun Log History */

  /* Fun Rata-rata */
  function fun_average(id) {
    var header = "";
    var body = "";
    var footer = "";
    var jumlah = $('tbody #tr_' + id).length;

    $.getJSON('<?= base_url() ?>/master/perhitungan_sample/getDetailRumusSample', {
      id_rumus: id
    }, function(json) {
      var hasil = 0;

      $(".hasil_" + id).each(function() {
        hasil += parseFloat($(this).val());
      });

      var total = hasil;
      var rata = (hasil / jumlah);

      $('#rata_' + id + '_' + jumlah).val(rata.toFixed(2));
      $('#rata_' + id).val(rata.toFixed(2));
    });
  }
  /* Fun Rata-rata */

  /* Fun ADBK */
  function fun_nilai_adbk(id) {
    var jumlah = $('tbody #tr_' + id).length;
    var rata = $('#rata_' + id).val();
    var rata_pembanding = $('#rata_33e69e61484d80e34599b5d16c2a0e1255fce468').val();

    var nilai_adbk = rata / (parseFloat('1') - rata_pembanding / parseFloat('100'));

    $('#nilai_adbk_' + id + '_' + jumlah).val(nilai_adbk);
    $('#nilai_adbk_' + id).val(nilai_adbk);
  }

  // $(document).on('click', '#hasil_' + id + '_' + jumlah, function() {
  //     $.getJSON('<?= base_url() ?>/master/perhitungan_sample/getDetailRumusSample', {
  //         id_rumus: id
  //     }, function(json) {
  //         var rumus = '';
  //         $.each(json, function(index, val) {
  //             if (val.rumus_jenis == 'I') rumus += '(' + $('#rumus_detail_isi' + val.rumus_detail_id + '_' + jumlah).val() + ')';
  //             else rumus += val.rumus_detail_input;
  //         });

  //         var hasil = math.evaluate(rumus);
  //         $('#hasil_' + id + '_' + jumlah).val(hasil.toFixed(2));
  //         $('#rumus_detail_hasil_' + id + '_' + jumlah).val(hasil.toFixed(2));
  //     });
  // })


  $(document).on('click', '#remove_simplo', function() {
    $(this).parents("tr").remove();
  })
  // * Simplo * //
  $(function() {
    $('#simpan').on('click', function() {
      var data = new FormData($('#form_logsheet')[0]);
      url = '<?= base_url('master/cek_sample/UpdateSample') ?>';
      $.ajax({
        type: "POST",
        url: url,
        data: data,
        dataType: 'HTML',
        processData: false,
        contentType: false,
        cache: false,
        success: function(response) {
          insertSample();
        }
      });
    })
  })

  function insertSample() {
    var data = new FormData($('#form_logsheet')[0]);
    url = '<?= base_url('master/cek_sample/insertSample') ?>';
    $.ajax({
      type: "POST",
      url: url,
      data: data,
      dataType: 'HTML',
      processData: false,
      contentType: false,
      cache: false,
      success: function(response) {
        // $('#table_detail').DataTable().ajax.url('<?= base_url('master/template_logsheet/getDetailLogsheet?id_logsheet_template=') ?>' + $('#template_logsheet_id').val()).load();
        location.reload();
      }
    });
  }
</script>