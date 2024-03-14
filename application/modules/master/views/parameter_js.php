<script type="text/javascript">
  $(function() {
    fun_loading();

    /* Select2 Material */
    $('#id_material').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url('material/bulanan/getItemReport') ?>',
        dataType: 'json',
        type: 'GET',
        data: function(params) {
          var queryParameters = {
            item_nama: params.term
          }
          return queryParameters;
        }
      }
    });
    /* Select2 Material */

    /* Select2 Aset */
    $('#id_aset').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url('master/parameter/getAset') ?>',
        dataType: 'json',
        type: 'GET',
        data: function(params) {
          var queryParameters = {
            aset_nama: params.term
          }

          return queryParameters;
        }
      }
    });
    /* Select2 Aset */

    $('.select2-selection').css('height', '37px');
    $('.select2').css('width', '100%');

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
          var cell = $('.filters th').eq(
            $(api.column(colIdx).header()).index()
          );
          var title = $(cell).text();
          $(cell).html('<input type="text" class="form-control" style="width:100%" placeholder="' + title + '" />');

          $(
            'input',
            $('.filters th').eq($(api.column(colIdx).header()).index())
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
      "scrollX": true,
      "lengthMenu": [
        [5, 10, 25, 50, -1],
        [5, 10, 25, 50, "All"]
      ],
      "dom": 'lBfrtip',
      "buttons": ["csv", "pdf", "excel", "copy", "print"],
      "ajax": {
        "url": "<?= base_url() ?>/master/parameter/getParameter",
        "dataSrc": ""
      },
      "columns": [{
        render: function(data, type, full, meta) {
          return meta.row + meta.settings._iDisplayStart + 1;
        }
      }, {
        "data": "parameter_nama"
      }, {
        "data": "parameter_jasa_total"
      }, {
        "data": "parameter_material_total"
      }, {
        "data": "parameter_aset_total"
      }, {
        "data": "parameter_biaya_lain"
      }, {
        "data": "parameter_medium"
      }, {
        "data": "parameter_very_fast"
      }, {
        "data": "parameter_grand_total"
      }, {
        "render": function(data, type, full, meta) {
          return '<center><a href="javascript:;" id="' + full.parameter_id + '" title="Edit" onclick="fun_edit(this.id)"><i class="fa fa-edit" data-toggle="modal" data-target="#modal" style="color: orange"></i></a></center>';
        }
      }, {
        "render": function(data, type, full, meta) {
          return '<center><a href="javascript:;" id="' + full.parameter_id + '" title="Delete" onclick="fun_delete(this.id)"><i class="fa fa-trash" style="color: red"></i></a></center>';
        }
      }, {
        "render": function(data, type, full, meta) {
          return '<center><a href="javascript:;" id="' + full.parameter_id + '" title="Detail" onclick="fun_detail(this.id)"><i class="fa fa-search text-primary"></i></a></center>';
        }
      }, ]
    });
    /* Isi Table */

    /* Isi Table Jasa */
    $('#table_jasa thead tr').clone(true).addClass('filters_jasa').appendTo('#table_jasa thead');
    $('#table_jasa').DataTable({
      orderCellsTop: true,
      initComplete: function() {
        var api = this.api();

        api.columns().eq(0).each(function(colIdx) {
          var cell = $('.filters_jasa th').eq(
            $(api.column(colIdx).header()).index()
          );
          var title = $(cell).text();
          $(cell).html('<input type="text" class="form-control" style="width:100%" placeholder="' + title + '" />');

          $(
            'input',
            $('.filters_jasa th').eq($(api.column(colIdx).header()).index())
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
      "dom": 'lBfrtip',
      "buttons": ["csv", "pdf", "excel", "copy", "print"],
      "ajax": {
        "url": "<?= base_url() ?>/master/parameter/getParameterJasa?id_parameter=0",
        "dataSrc": ""
      },
      "columns": [{
        render: function(data, type, full, meta) {
          return meta.row + meta.settings._iDisplayStart + 1;
        }
      }, {
        "render": function(data, type, full, meta) {
          if (full.parameter_jasa_jabatan == '1') var jabatan = 'AVP';
          else if (full.parameter_jasa_jabatan == '2') var jabatan = 'KASI';
          else if (full.parameter_jasa_jabatan == '3') var jabatan = 'KARU';
          else if (full.parameter_jasa_jabatan == '4') var jabatan = 'Pelaksana';
          else var jabatan = '-';
          return jabatan;
        }
      }, {
        "data": "parameter_jasa_uhpd"
      }, {
        "data": "parameter_jasa_honorarium"
      }, {
        "data": "parameter_jasa_durasi"
      }, {
        "data": "parameter_jasa_grand_total"
      }, ]
    });
    /* Isi Table Jasa */

    /* Isi Table Material */
    $('#table_material thead tr').clone(true).addClass('filters_material').appendTo('#table_material thead');
    $('#table_material').DataTable({
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
      "dom": 'lBfrtip',
      "buttons": ["csv", "pdf", "excel", "copy", "print"],
      "ajax": {
        "url": "<?= base_url() ?>/master/parameter/getParameterMaterial?id_parameter=0",
        "dataSrc": ""
      },
      "columns": [{
        render: function(data, type, full, meta) {
          return meta.row + meta.settings._iDisplayStart + 1;
        }
      }, {
        "data": "item_nama"
      }, {
        "data": "item_satuan"
      }, {
        "data": "item_harga"
      }, {
        "data": "parameter_material_jumlah"
      }, {
        "data": "parameter_material_grand_total"
      }, {
        "render": function(data, type, full, meta) {
          return '<center><a href="javascript:;" id="' + full.parameter_material_id + '" title="Edit" onclick="fun_edit_material(this.id)"><i class="fa fa-edit" style="color: orange"></i></a></center>';
        }
      }, {
        "render": function(data, type, full, meta) {
          return '<center><a href="javascript:;" id="' + full.parameter_material_id + '" title="Delete" onclick="fun_delete_material(this.id)"><i class="fa fa-trash" style="color: red"></i></a></center>';
        }
      }, ]
    });
    /* Isi Table Material */

    /* Isi Table Aset */
    $('#table_aset thead tr').clone(true).addClass('filters_aset').appendTo('#table_aset thead');
    $('#table_aset').DataTable({
      orderCellsTop: true,
      initComplete: function() {
        var api = this.api();

        api.columns().eq(0).each(function(colIdx) {
          var cell = $('.filters_aset th').eq(
            $(api.column(colIdx).header()).index()
          );
          var title = $(cell).text();
          $(cell).html('<input type="text" class="form-control" style="width:100%" placeholder="' + title + '" />');

          $(
            'input',
            $('.filters_aset th').eq($(api.column(colIdx).header()).index())
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
      "dom": 'lBfrtip',
      "buttons": ["csv", "pdf", "excel", "copy", "print"],
      "ajax": {
        "url": "<?= base_url() ?>/master/parameter/getParameterAset?id_parameter=0",
        "dataSrc": ""
      },
      "columns": [{
        render: function(data, type, full, meta) {
          return meta.row + meta.settings._iDisplayStart + 1;
        }
      }, {
        "data": "aset_nama"
      }, {
        "data": "aset_nilai_perolehan"
      }, {
        "data": "aset_umur"
      }, {
        "data": "parameter_aset_jumlah"
      }, {
        "data": "parameter_aset_grand_total"
      }, {
        "render": function(data, type, full, meta) {
          return '<center><a href="javascript:;" id="' + full.parameter_aset_id + '" title="Edit" onclick="fun_edit_aset(this.id)"><i class="fa fa-edit" style="color: orange"></i></a></center>';
        }
      }, {
        "render": function(data, type, full, meta) {
          return '<center><a href="javascript:;" id="' + full.parameter_aset_id + '" title="Delete" onclick="fun_delete_aset(this.id)"><i class="fa fa-trash" style="color: red"></i></a></center>';
        }
      }, ]
    });
    /* Isi Table Aset */
  });

  /* View Update */
  function fun_edit(id) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $('#simpan').css('display', 'none');
        $('#edit').css('display', 'block');
        $.getJSON('<?= base_url('master/parameter/getParameter') ?>', {
          parameter_id: id
        }, function(json) {
          $('#parameter_id').val(json.parameter_id);
          $('#parameter_nama').val(json.parameter_nama);
          $('#parameter_biaya_lain').val(json.parameter_biaya_lain);
          $('#parameter_medium').val(json.parameter_medium);
          $('#parameter_very_fast').val(json.parameter_very_fast);
        });
      }
    });
  }
  /* View Update */

  /* View Update Material */
  function fun_edit_material(id) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $('#simpan_material').css('display', 'none');
        $('#edit_material').css('display', 'block');
        $.getJSON('<?= base_url('master/parameter/getParameterMaterial') ?>', {
          parameter_material_id: id
        }, function(json) {
          $('#modal_material').modal('show');
          $('#id_parameter_material').val(json.id_parameter);
          $('#parameter_material_id').val(json.parameter_material_id);
          $('#item_satuan').val(json.item_satuan);
          $('#item_harga').val(json.item_harga);
          $('#parameter_material_jumlah').val(json.parameter_material_jumlah);
          $('#parameter_material_grand_total').val(json.parameter_material_grand_total);

          $('#id_material').append('<option selected value="' + json.item_id + '">' + json.item_nama + '</option>');
          $('#id_material').select2('data', {
            id: json.item_id,
            text: json.item_nama
          });
          $('#id_material').trigger('change');
        });
      }
    });
  }
  /* View Update Material */

  /* View Update Aset */
  function fun_edit_aset(id) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $('#simpan_aset').css('display', 'none');
        $('#edit_aset').css('display', 'block');
        $.getJSON('<?= base_url('master/parameter/getParameterAset') ?>', {
          parameter_aset_id: id
        }, function(json) {
          $('#modal_aset').modal('show');
          $('#id_parameter_aset').val(json.id_parameter);
          $('#parameter_aset_id').val(json.parameter_aset_id);
          $('#aset_umur').val(json.aset_umur);
          $('#aset_nilai_perolehan').val(json.aset_nilai_perolehan);
          $('#parameter_aset_jumlah').val(json.parameter_aset_jumlah);
          $('#parameter_aset_grand_total').val(json.parameter_aset_grand_total);

          $('#id_aset').append('<option selected value="' + json.aset_id + '">' + json.aset_nama + '</option>');
          $('#id_aset').select2('data', {
            id: json.aset_id,
            text: json.aset_nama
          });
          $('#id_aset').trigger('change');
        });
      }
    });
  }
  /* View Update Aset */

  /* Proses */
  $("#form_modal").on("submit", function(e) {
    e.preventDefault();
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        if ($('#parameter_id').val() != '') var url = '<?= base_url('master/parameter/updateParameter') ?>';
        else var url = '<?= base_url('master/parameter/insertParameter') ?>';

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

  /* Proses Jasa */
  $("#form_modal_jasa").on("submit", function(e) {
    e.preventDefault();
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        var url = '<?= base_url('master/parameter/insertParameterJasa') ?>';

        e.preventDefault();
        $.ajax({
          url: url,
          data: $('#form_modal_jasa').serialize(),
          type: 'POST',
          dataType: 'html',
          success: function(isi) {
            $('#close_jasa').click();
            toastr.success('Berhasil');
          }
        });
      }
    });
  });
  /* Proses Jasa */

  /* Proses Material */
  $("#form_modal_material").on("submit", function(e) {
    e.preventDefault();
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        if ($('#parameter_material_id').val() != '') var url = '<?= base_url('master/parameter/updateParameterMaterial') ?>';
        else var url = '<?= base_url('master/parameter/insertParameterMaterial') ?>';

        e.preventDefault();
        $.ajax({
          url: url,
          data: $('#form_modal_material').serialize(),
          type: 'POST',
          dataType: 'html',
          success: function(isi) {
            $('#close_material').click();
            toastr.success('Berhasil');
          }
        });
      }
    });
  });
  /* Proses Material */

  /* Proses Aset */
  $("#form_modal_aset").on("submit", function(e) {
    e.preventDefault();
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        if ($('#parameter_aset_id').val() != '') var url = '<?= base_url('master/parameter/updateParameterAset') ?>';
        else var url = '<?= base_url('master/parameter/insertParameterAset') ?>';

        e.preventDefault();
        $.ajax({
          url: url,
          data: $('#form_modal_aset').serialize(),
          type: 'POST',
          dataType: 'html',
          success: function(isi) {
            $('#close_aset').click();
            toastr.success('Berhasil');
          }
        });
      }
    });
  });
  /* Proses Aset */

  /* Fun Delete */
  function fun_delete(id) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $.confirmModal('Apakah anda yakin akan menghapusnya?', function(el) {
          $.get('<?= base_url('master/parameter/deleteParameter') ?>', {
            parameter_id: id,
          }, function(data) {
            $('#close').click();
            toastr.success('Berhasil');
          });
        });
      }
    });
  }
  /* Fun Delete */

  /* Fun Delete Material */
  function fun_delete_material(id) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $.confirmModal('Apakah anda yakin akan menghapusnya?', function(el) {
          $.get('<?= base_url('master/parameter/deleteParameterMaterial') ?>', {
            parameter_material_id: id,
            id_parameter_material: $('#temp_parameter_id').val()
          }, function(data) {
            $('#close_material').click();
            toastr.success('Berhasil');
          });
        });
      }
    });
  }
  /* Fun Delete Material */

  /* Fun Delete Aset */
  function fun_delete_aset(id) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $.confirmModal('Apakah anda yakin akan menghapusnya?', function(el) {
          $.get('<?= base_url('master/parameter/deleteParameterAset') ?>', {
            parameter_aset_id: id,
            id_parameter_aset: $('#temp_parameter_id').val()
          }, function(data) {
            $('#close_aset').click();
            toastr.success('Berhasil');
          });
        });
      }
    });
  }
  /* Fun Delete Aset */

  function fun_detail(id) {
    $('#temp_parameter_id').val(id);
    $('#div_jasa').css('display', 'block');
    $('#div_material').css('display', 'block');
    $('#div_aset').css('display', 'block');
    $('#table_jasa').DataTable().ajax.url('<?= base_url('master/parameter/getParameterJasa?id_parameter=') ?>' + id).load();
    $('#table_material').DataTable().ajax.url('<?= base_url('master/parameter/getParameterMaterial?id_parameter=') ?>' + id).load();
    $('#table_aset').DataTable().ajax.url('<?= base_url('master/parameter/getParameterAset?id_parameter=') ?>' + id).load();
  }

  function fun_total_jasa(id, value) {
    var urut = id.split("_");
    var uhpd = $('#uhpd_' + urut[1]).val();
    var honorarium = $('#honorarium_' + urut[1]).val();

    var total = ((uhpd * 1) * value) + ((honorarium * 1) * value);
    $('#total_' + urut[1]).val(total);
  }

  function fun_material(id) {
    $.getJSON('<?= base_url('master/barang_material/getBarangMaterial') ?>', {
      item_id: id
    }, function(json) {
      $('#item_satuan').val(json.item_satuan);
      $('#item_harga').val(json.item_harga);
      fun_total_material($('#parameter_material_jumlah').val());
    });
  }

  function fun_total_material(value) {
    var harga = $('#item_harga').val();
    var total = ((harga * 1) * value);

    $('#parameter_material_grand_total').val(total);
  }

  function fun_aset(id) {
    $.getJSON('<?= base_url('master/parameter/getAsetIsi') ?>', {
      aset_id: id
    }, function(json) {
      $('#aset_umur').val(json.umur);
      $('#aset_nilai_perolehan').val(json.harga);
      fun_total_aset($('#parameter_aset_jumlah').val());
    });
  }

  function fun_total_aset(value) {
    var harga = $('#aset_nilai_perolehan').val();
    var umur = $('#aset_umur').val();
    var total = (value / (2880 * (umur * 1)) * (harga * 1));

    $('#parameter_aset_grand_total').val(total);
  }

  function fun_modal_jasa(id) {
    $('#modal_jasa').modal('show');
    $('#id_parameter_jasa').val(id);
    $.getJSON('<?= base_url('master/parameter/getParameterJasa') ?>', {
      id_parameter: id
    }, function(json) {
      $.each(json, function(index, val) {
        $('#durasi_' + val.parameter_jasa_jabatan).val(val.parameter_jasa_durasi);
        $('#total_' + val.parameter_jasa_jabatan).val(val.parameter_jasa_grand_total);
      });
    });
  }

  function fun_modal_material(id) {
    $('#modal_material').modal('show');
    $('#id_parameter_material').val(id);
  }

  function fun_modal_aset(id) {
    $('#modal_aset').modal('show');
    $('#id_parameter_aset').val(id);
  }

  /* Fun Close */
  function fun_close() {
    $('#simpan').css('display', 'block');
    $('#edit').css('display', 'none');
    $('#form_modal')[0].reset();
    $('#table').DataTable().ajax.reload(null, false);
    fun_loading();
  }
  /* Fun Close */

  $('#modal').on('hidden.bs.modal', function(e) {
    fun_close();
  });

  /* Fun Close Jasa */
  function fun_close_jasa() {
    $('#simpan_jasa').css('display', 'block');
    $('#form_modal_jasa')[0].reset();
    $('#table').DataTable().ajax.reload(null, false);
    $('#table_jasa').DataTable().ajax.reload(null, false);
    fun_loading();
  }
  /* Fun Close Jasa */

  $('#modal_jasa').on('hidden.bs.modal', function(e) {
    fun_close_jasa();
  });

  /* Fun Close Material */
  function fun_close_material() {
    $('#simpan_material').css('display', 'block');
    $('#form_modal_material')[0].reset();
    $("#id_material").empty();
    $('#table').DataTable().ajax.reload(null, false);
    $('#table_material').DataTable().ajax.reload(null, false);
    fun_loading();
  }
  /* Fun Close Material */

  $('#modal_material').on('hidden.bs.modal', function(e) {
    fun_close_material();
  });

  /* Fun Close Aset */
  function fun_close_aset() {
    $('#simpan_aset').css('display', 'block');
    $('#form_modal_aset')[0].reset();
    $("#id_aset").empty();
    $('#table').DataTable().ajax.reload(null, false);
    $('#table_aset').DataTable().ajax.reload(null, false);
    fun_loading();
  }
  /* Fun Close Aset */

  $('#modal_aset').on('hidden.bs.modal', function(e) {
    fun_close_aset();
  });

  function fun_loading() {
    var simplebar = new Nanobar();
    simplebar.go(100);
  }
</script>