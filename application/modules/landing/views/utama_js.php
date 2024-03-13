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
      "dom": 'lBfrtip',
      "buttons": ["csv", "pdf", "excel", "copy", "print"],

      "ajax": {
        "url": "<?= base_url() ?>/landing/getLanding",
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
          "data": "landing_urut"
        },
        {
          "data": "landing_judul"
        },
        {
          "data": "landing_link"
        },
        {
          "data": "landing_template_nama"
        },
        {
          "render": function(data, type, full, meta) {
            return (full.aktif == 'y') ? '<span class="badge badge-success">Aktif</span>' : '<span class="badge badge-danger">Tidak Aktif</span>';
          }
        },
        {
          "render": function(data, type, full, meta) {
            return '<center><a class="" href="#" id="' + full.landing_id + '" name="' + full.landing_judul + '-' + full.landing_template_tipe + '"  onclick="fun_detail(this.id,this.name)"><i class="fas fa-search"></i></a></center>';
          }
        },
        {
          "render": function(data, type, full, meta) {
            return '<center><a href="#" id="' + full.landing_id + '" name="' + full.landing_judul + '-' + full.landing_template_tipe + '"  onclick="fun_edit(this.id,this.name)" data-toggle="modal" data-target="#modal"><i style="color:orange" class="fa fa-edit"></i></a></center>';
          }
        },
        {
          "render": function(data, type, full, meta) {
            return '<center><a href="#" id="' + full.landing_id + '" name="' + full.landing_judul + '-' + full.landing_template_tipe + '"  onclick="fun_delete(this.id,this.name)"><i style="color:red" class="fa fa-trash"></i></a></center>';
          }
        },
      ]
    }).columns.adjust();
    /* Isi Table */

    /* Isi Table Detail */
    $('#table_detail_banner thead tr').clone(true).addClass('filters_detail_banner').appendTo('#table_detail_banner thead');
    $('#table_detail_banner').DataTable({
      orderCellsTop: true,
      initComplete: function() {
        var api = this.api();

        // For each column
        api
          .columns()
          .eq(0)
          .each(function(colIdx) {
            // Set the header cell to contain the input element
            var cell = $('.filters_detail_banner th').eq(
              $(api.column(colIdx).header()).index()
            );
            var title = $(cell).text();
            $(cell).html('<input type="text" class="form-control" style="width:100%" placeholder="' + title + '" />');

            // On every keypress in this input
            $(
                'input',
                $('.filters_detail_banner th').eq($(api.column(colIdx).header()).index())
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
        "url": "<?= base_url('landing/getLandingDetail?id_landing=0') ?>",
        "dataSrc": ""
      },
      "columns": [{
          render: function(data, type, full, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        {
          "data": "landing_detail_urutan"
        },
        {
          "data": "landing_detail_judul"
        },
        {
          "render": function(data, type, full, meta) {
            return (full.landing_detail_gambar != null) ? '<center><a href="javascript:;" id="' + full.landing_detail_gambar + '" title="Lihat" onclick="func_lihat(this.id)"><i style="color:red" class="fa fa-image" data-toggle="modal" data-target="#modal_lihat"></i></a></center>' : '';
          }
        },
        {
          "render": function(data, type, full, meta) {
            return '<center><a href="javascript:;" id="' + full.landing_detail_id + '" title="Edit" onclick="fun_edit_detail(this.id)"><i class="fa fa-edit" data-toggle="modal" data-target="#modal_detail" style="color: orange;"</i></a></center>';
          }
        },
        {
          "render": function(data, type, full, meta) {
            return '<center><a href="javascript:;" id="' + full.landing_detail_id + '" title="Edit" onclick="fun_delete_detail(this.id)"><i class="fa fa-trash" style="color: red;"></i></a></center>';
          }
        },
      ]
    });
    /* Isi Table Detail */

    /* Isi Table Detail */
    $('#table_detail_tentang thead tr').clone(true).addClass('filters_detail_tentang').appendTo('#table_detail_tentang thead');
    $('#table_detail_tentang').DataTable({
      orderCellsTop: true,
      initComplete: function() {
        var api = this.api();

        // For each column
        api
          .columns()
          .eq(0)
          .each(function(colIdx) {
            // Set the header cell to contain the input element
            var cell = $('.filters_detail_tentang th').eq(
              $(api.column(colIdx).header()).index()
            );
            var title = $(cell).text();
            $(cell).html('<input type="text" class="form-control" style="width:100%" placeholder="' + title + '" />');

            // On every keypress in this input
            $(
                'input',
                $('.filters_detail_tentang th').eq($(api.column(colIdx).header()).index())
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
        "url": "<?= base_url('landing/getLandingDetail?id_landing=0') ?>",
        "dataSrc": ""
      },
      "columns": [{
          render: function(data, type, full, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        {
          "data": "landing_detail_judul"
        },
        {
          "data": "landing_detail_text"
        },
        {
          "render": function(data, type, full, meta) {
            return (full.landing_detail_gambar != null) ? '<center><a href="javascript:;" id="' + full.landing_detail_gambar + '" title="Lihat" onclick="func_lihat(this.id)"><i style="color:red" class="fa fa-image" data-toggle="modal" data-target="#modal_lihat"></i></a></center>' : '';
          }
        },
        {
          "render": function(data, type, full, meta) {
            return '<center><a href="javascript:;" id="' + full.landing_detail_id + '" title="Edit" onclick="fun_edit_detail(this.id)"><i class="fa fa-edit" data-toggle="modal" data-target="#modal_detail" style="color: orange;"</i></a></center>';
          }
        },
        {
          "render": function(data, type, full, meta) {
            return '<center><a href="javascript:;" id="' + full.landing_detail_id + '" title="Hapus" onclick="fun_delete_detail(this.id)"><i class="fa fa-trash" style="color: red;"></i></a></center>';
          }
        },
      ]
    });
    /* Isi Table Detail */

    /* Isi Table Detail */
    $('#table_detail_berita thead tr').clone(true).addClass('filters_detail_berita').appendTo('#table_detail_berita thead');
    $('#table_detail_berita').DataTable({
      orderCellsTop: true,
      initComplete: function() {
        var api = this.api();

        // For each column
        api
          .columns()
          .eq(0)
          .each(function(colIdx) {
            // Set the header cell to contain the input element
            var cell = $('.filters_detail_berita th').eq(
              $(api.column(colIdx).header()).index()
            );
            var title = $(cell).text();
            $(cell).html('<input type="text" class="form-control" style="width:100%" placeholder="' + title + '" />');

            // On every keypress in this input
            $(
                'input',
                $('.filters_detail_berita th').eq($(api.column(colIdx).header()).index())
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
        "url": "<?= base_url('landing/getLandingDetail?id_landing=0') ?>",
        "dataSrc": ""
      },
      "columns": [{
          render: function(data, type, full, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        {
          "data": "landing_detail_judul"
        },
        {
          "data": "landing_detail_text"
        },
        {
          "render": function(data, type, full, meta) {
            return (full.landing_detail_gambar != null) ? '<center><a href="javascript:;" id="' + full.landing_detail_gambar + '" title="Lihat" onclick="func_lihat(this.id)"><i style="color:red" class="fa fa-image" data-toggle="modal" data-target="#modal_lihat"></i></a></center>' : '';
          }
        },
        {
          "render": function(data, type, full, meta) {
            return '<center><a href="javascript:;" id="' + full.landing_detail_id + '" title="Edit" onclick="fun_edit_detail(this.id)"><i class="fa fa-edit" data-toggle="modal" data-target="#modal_detail" style="color: orange;"</i></a></center>';
          }
        },
        {
          "render": function(data, type, full, meta) {
            return '<center><a href="javascript:;" id="' + full.landing_detail_id + '" title="Edit" onclick="fun_delete_detail(this.id)"><i class="fa fa-trash" style="color: red;"></i></a></center>';
          }
        },
      ]
    });
    /* Isi Table Detail */

    /* Isi Table Detail */
    $('#table_detail_sertifikat thead tr').clone(true).addClass('filters_detail_sertifikat').appendTo('#table_detail_sertifikat thead');
    $('#table_detail_sertifikat').DataTable({
      orderCellsTop: true,
      initComplete: function() {
        var api = this.api();

        // For each column
        api
          .columns()
          .eq(0)
          .each(function(colIdx) {
            // Set the header cell to contain the input element
            var cell = $('.filters_detail_sertifikat th').eq(
              $(api.column(colIdx).header()).index()
            );
            var title = $(cell).text();
            $(cell).html('<input type="text" class="form-control" style="width:100%" placeholder="' + title + '" />');

            // On every keypress in this input
            $(
                'input',
                $('.filters_detail_sertifikat th').eq($(api.column(colIdx).header()).index())
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
        "url": "<?= base_url('landing/getLandingDetail?id_landing=0') ?>",
        "dataSrc": ""
      },
      "columns": [{
          render: function(data, type, full, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        {
          "data": "landing_detail_nomor"
        },
        {
          "data": "landing_detail_judul"
        },
        {
          "render": function(data, type, full, meta) {
            return (full.landing_detail_gambar != null) ? '<center><a href="javascript:;" id="' + full.landing_detail_gambar + '" title="Lihat" onclick="func_lihat(this.id)"><i style="color:red" class="fa fa-image" data-toggle="modal" data-target="#modal_lihat"></i></a></center>' : '';
          }
        },
        {
          "render": function(data, type, full, meta) {
            return (full.landing_detail_file != null) ? '<center><a href="javascript:;" id="' + full.landing_detail_file + '" title="Lihat" onclick="func_lihat(this.id)"><i style="color:red" class="fa fa-file" data-toggle="modal" data-target="#modal_lihat"></i></a></center>' : '';
          }
        },
        {
          "render": function(data, type, full, meta) {
            return '<center><a href="javascript:;" id="' + full.landing_detail_id + '" title="Edit" onclick="fun_edit_detail(this.id)"><i class="fa fa-edit" data-toggle="modal" data-target="#modal_detail" style="color: orange;"</i></a></center>';
          }
        },
        {
          "render": function(data, type, full, meta) {
            return '<center><a href="javascript:;" id="' + full.landing_detail_id + '" title="Edit" onclick="fun_delete_detail(this.id)"><i class="fa fa-trash" style="color: red;"></i></a></center>';
          }
        },
      ]
    });
    /* Isi Table Detail */

    /* Isi Table Detail */
    $('#table_detail_kerjasama thead tr').clone(true).addClass('filters_detail_kerjasama').appendTo('#table_detail_kerjasama thead');
    $('#table_detail_kerjasama').DataTable({
      orderCellsTop: true,
      initComplete: function() {
        var api = this.api();

        // For each column
        api
          .columns()
          .eq(0)
          .each(function(colIdx) {
            // Set the header cell to contain the input element
            var cell = $('.filters_detail_kerjasama th').eq(
              $(api.column(colIdx).header()).index()
            );
            var title = $(cell).text();
            $(cell).html('<input type="text" class="form-control" style="width:100%" placeholder="' + title + '" />');

            // On every keypress in this input
            $(
                'input',
                $('.filters_detail_kerjasama th').eq($(api.column(colIdx).header()).index())
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
        "url": "<?= base_url('landing/getLandingDetail?id_landing=0') ?>",
        "dataSrc": ""
      },
      "columns": [{
          render: function(data, type, full, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        {
          "data": "landing_detail_nomor"
        },
        {
          "data": "landing_detail_judul"
        },
        {
          "render": function(data, type, full, meta) {
            return (full.landing_detail_gambar != null) ? '<center><a href="javascript:;" id="' + full.landing_detail_gambar + '" title="Lihat" onclick="func_lihat(this.id)"><i style="color:red" class="fa fa-image" data-toggle="modal" data-target="#modal_lihat"></i></a></center>' : '';
          }
        },
        {
          "render": function(data, type, full, meta) {
            return '<center><a href="javascript:;" id="' + full.landing_detail_id + '" title="Edit" onclick="fun_edit_detail(this.id)"><i class="fa fa-edit" data-toggle="modal" data-target="#modal_detail" style="color: orange;"</i></a></center>';
          }
        },
        {
          "render": function(data, type, full, meta) {
            return '<center><a href="javascript:;" id="' + full.landing_detail_id + '" title="Edit" onclick="fun_delete_detail(this.id)"><i class="fa fa-trash" style="color: red;"></i></a></center>';
          }
        },
      ]
    });
    /* Isi Table Detail */

    /* Isi Table Detail */
    $('#table_detail_kontak thead tr').clone(true).addClass('filters_detail_kontak').appendTo('#table_detail_kontak thead');
    $('#table_detail_kontak').DataTable({
      orderCellsTop: true,
      initComplete: function() {
        var api = this.api();

        // For each column
        api
          .columns()
          .eq(0)
          .each(function(colIdx) {
            // Set the header cell to contain the input element
            var cell = $('.filters_detail_kontak th').eq(
              $(api.column(colIdx).header()).index()
            );
            var title = $(cell).text();
            $(cell).html('<input type="text" class="form-control" style="width:100%" placeholder="' + title + '" />');

            // On every keypress in this input
            $(
                'input',
                $('.filters_detail_kontak th').eq($(api.column(colIdx).header()).index())
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
        "url": "<?= base_url('landing/getLandingDetail?id_landing=0') ?>",
        "dataSrc": ""
      },
      "columns": [{
          render: function(data, type, full, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        {
          "data": "landing_detail_judul"
        },
        {
          "data": "landing_detail_alamat"
        },
        {
          "data": "landing_detail_kontak"
        },
        {
          "data": "landing_detail_fax"
        },
        {
          "data": "landing_detail_email"
        },
        {
          "render": function(data, type, full, meta) {
            return '<center><a href="javascript:;" id="' + full.landing_detail_id + '" title="Edit" onclick="fun_edit_detail(this.id)"><i class="fa fa-edit" data-toggle="modal" data-target="#modal_detail" style="color: orange;"</i></a></center>';
          }
        },
        {
          "render": function(data, type, full, meta) {
            return '<center><a href="javascript:;" id="' + full.landing_detail_id + '" title="Edit" onclick="fun_delete_detail(this.id)"><i class="fa fa-trash" style="color: red;"></i></a></center>';
          }
        },
      ]
    });
    /* Isi Table Detail */

    /* Isi Table History */
    $('#table_history').DataTable({
      "scrollX": true,
      "ordering": false,
      "ajax": {
        "url": "<?= base_url('master/barang_material/getHistory?item_id=0') ?>",
        "dataSrc": ""
      },
      "columns": [{
          render: function(data, type, full, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        {
          "data": "barang_harga"
        },
        {
          "render": function(data, type, full, meta) {
            return full.log_who + ' - ' + full.log_when;
          }
        },
      ]
    });
    /* Isi Table History */

    /* Select2 */
    $('#jenis_id').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url('master/barang_material/getJenis') ?>',
        dataType: 'json',
        type: 'GET',
        data: function(params) {
          var queryParameters = {
            material_nama: params.term
          }

          return queryParameters;
        }
      }
    });

    $('#gl_account_id').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url('master/barang_material/getGlAccount') ?>',
        dataType: 'json',
        type: 'GET',
        data: function(params) {
          var queryParameters = {
            gl_account_nama: params.term
          }

          return queryParameters;
        }
      }
    });

    $('#komposisi_item').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url('master/barang_material/getItem') ?>',
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

    $('#id_landing_template').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url('landing/getLandingTemplate') ?>',
        dataType: 'json',
        type: 'GET',
        data: function(params) {
          var queryParameters = {
            landing_template_nama: params.term
          }

          return queryParameters;
        }
      }
    });

    $('.select2-selection').css('height', '37px');
    $('.select2').css('width', '100%');
    /* Select2 */
  });

  /* View Update */
  function fun_edit(id) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $('#simpan').css('display', 'none');
        $('#edit').css('display', 'block');
        $.getJSON('<?= base_url('landing/getLanding') ?>', {
          landing_id: id
        }, function(json) {
          console.log(json);
          $.each(json, function(index, val) {
            $('#' + index).val(val);
          });
          $('#landing_id').val(json.landing_id);
          $('#landing_urutan').val(json.landing_urut);
          $('#landing_nama').val(json.landing_nama);
          $('#landing_link').val(json.landing_link);
          $('#landing_tipe').val(json.landing_tipe);
          $('#id_landing_template').append('<option selected value="' + json.landing_template_id + '">' + json.landing_template_nama + '</option>');
          $('#id_landing_template').select2('data', {
            id: json.landing_template_id,
            text: json.landing_template_nama
          });
          $('#id_landing_template').trigger('change');

          if (json.aktif == 'y') $('#landing_aktif').prop('checked', true);
          $('#landing_aktif').val('y');
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
        if ($('#landing_id').val() != '') var url = '<?= base_url('landing/updateLanding') ?>';
        else var url = '<?= base_url('landing/insertLanding') ?>';

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
    })
  });
  /* Proses */

  /* Fun Delete */
  function fun_delete(id) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $.confirmModal('Apakah anda yakin akan menghapusnya?', function(el) {
          $.get('<?= base_url('landing/deleteLanding') ?>', {
            landing_id: id
          }, function(data) {
            $('#close').click();
            toastr.success('Berhasil');
          });
        });
      }
    })
  }
  /* Fun Delete */
  /* Fun Reset */
  function fun_reset() {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $.confirmModal('Apakah anda yakin akan mereset seluruh data barang material?', function(el) {
          $.get('<?= base_url('master/barang_material/resetBarangMaterial') ?>', {
            item_id: 'id'
          }, function(data) {
            $('#close').click();
            toastr.success('Berhasil');
          });
        });
      }
    })
  }
  /* Fun Reset */

  /* Fun Close */
  function fun_close() {
    $('#simpan').css('display', 'block');
    $('#edit').css('display', 'none');
    $('#form_modal')[0].reset();
    $("#jenis_id").empty();
    $("#gl_account_id").empty();
    $('#table').DataTable().ajax.reload();
    $('#table_detail').DataTable().ajax.reload();
    fun_loading();
  }
  /* Fun Close */

  $('#modal').on('hidden.bs.modal', function(e) {
    fun_close();
  });

  // Tambah
  function fun_tambah() {}
  $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
    if (!json.user_id) {
      fun_notifLogout();
    } else {
      $('#simpan').show();
      $('#edit').hide();
    }
  })
  // Tambah

  /* Fun Detail */
  function fun_detail(id, name) {
    var nama = name.split("-");
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        if (nama[1] == 'B') {
          $('#div_table_detail_banner').show();
          $('#div_table_detail_tentang').hide();
          $('#div_table_detail_berita').hide();
          $('#div_table_detail_sertifikat').hide();
          $('#div_table_detail_kerjasama').hide();
          $('#div_table_detail_kontak').hide();

          $('#table_detail_banner').DataTable().ajax.url('<?= base_url('landing/getLandingDetail?id_landing=') ?>' + id + '&landing_template_tipe=' + nama[1]).load();

        } else if (nama[1] == 'T') {
          $('#div_table_detail_banner').hide();
          $('#div_table_detail_tentang').show();
          $('#div_table_detail_berita').hide();
          $('#div_table_detail_sertifikat').hide();
          $('#div_table_detail_kerjasama').hide();
          $('#div_table_detail_kontak').hide();

          $('#table_detail_tentang').DataTable().ajax.url('<?= base_url('landing/getLandingDetail?id_landing=') ?>' + id + '&landing_template_tipe=' + nama[1]).load();

        } else if (nama[1] == 'N') {
          $('#div_table_detail_banner').hide();
          $('#div_table_detail_tentang').hide();
          $('#div_table_detail_berita').show();
          $('#div_table_detail_sertifikat').hide();
          $('#div_table_detail_kerjasama').hide();
          $('#div_table_detail_kontak').hide();
          $('#table_detail_berita').DataTable().ajax.url('<?= base_url('landing/getLandingDetail?id_landing=') ?>' + id + '&landing_template_tipe=' + nama[1]).load();

        } else if (nama[1] == 'S') {
          $('#div_table_detail_banner').hide();
          $('#div_table_detail_tentang').hide();
          $('#div_table_detail_berita').hide();
          $('#div_table_detail_sertifikat').show();
          $('#div_table_detail_kerjasama').hide();
          $('#div_table_detail_kontak').hide();
          $('#table_detail_sertifikat').DataTable().ajax.url('<?= base_url('landing/getLandingDetail?id_landing=') ?>' + id + '&landing_template_tipe=' + nama[1]).load();

        } else if (nama[1] == 'C') {
          $('#div_table_detail_banner').hide();
          $('#div_table_detail_tentang').hide();
          $('#div_table_detail_berita').hide();
          $('#div_table_detail_sertifikat').hide();
          $('#div_table_detail_kerjasama').show();
          $('#div_table_detail_kontak').hide();
          $('#table_detail_kerjasama').DataTable().ajax.url('<?= base_url('landing/getLandingDetail?id_landing=') ?>' + id + '&landing_template_tipe=' + nama[1]).load();

        } else if (nama[1] == 'K') {
          $('#div_table_detail_banner').hide();
          $('#div_table_detail_tentang').hide();
          $('#div_table_detail_berita').hide();
          $('#div_table_detail_sertifikat').hide();
          $('#div_table_detail_kerjasama').hide();
          $('#div_table_detail_kontak').show();
          $('#table_detail_kontak').DataTable().ajax.url('<?= base_url('landing/getLandingDetail?id_landing=') ?>' + id + '&landing_template_tipe=' + nama[1]).load();
        } else if (nama[1] == 'G') {
          $('#div_table_detail_banner').hide();
          $('#div_table_detail_tentang').hide();
          $('#div_table_detail_berita').show();
          $('#div_table_detail_sertifikat').hide();
          $('#div_table_detail_kerjasama').hide();
          $('#div_table_detail_kontak').hide();
          $('#table_detail_berita').DataTable().ajax.url('<?= base_url('landing/getLandingDetail?id_landing=') ?>' + id + '&landing_template_tipe=' + nama[1]).load();
        }

        $('#div_detail').css('display', 'block');
        $('#id_landing').val(id);
        $('#id_landing_temp').val(id);
        $('#judul_detail').html(nama[0]);
        $('#landing_template_tipe').val(nama[1]);
        $('html, body').animate({
          scrollTop: $("#div_detail").offset().top
        }, 10);
        setTimeout(function() {
          $('.warna').removeAttr('style')
        }, 500);
        setTimeout(function() {
          $('#' + id).parents('tr').attr('style', 'color: red')
        }, 1000);
      }
    })
  }
  /* Fun Detail */

  /* Fun Tambah Detail */
  function fun_tambah_detail() {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $('#id_landing_temp').val($('#id_landing').val());
        var landing_template_tipe = $('#landing_template_tipe').val();
        if (landing_template_tipe == 'B') {
          $('#div_landing_detail_urutan').show();
          $('#div_landing_detail_judul').show();
          $('#div_landing_detail_gambar').show();
          $('#div_landing_detail_status').show();
          $('#div_image_home').show();
          $('#div_image_tentang_kami').hide();
          $('#div_image_berita_terkini').hide();
          $('#div_image_sertifikat').hide();
          $('#div_image_testimoni').hide();
        } else if (landing_template_tipe == 'T') {
          $('#div_landing_detail_judul').show();
          $('#div_landing_detail_text').show();
          $('#div_landing_detail_gambar').show();
          $('#div_landing_detail_status').show();
          $('#div_image_home').hide();
          $('#div_image_tentang_kami').show();
          $('#div_image_berita_terkini').hide();
          $('#div_image_sertifikat').hide();
          $('#div_image_testimoni').hide();
        } else if (landing_template_tipe == 'N') {
          $('#div_landing_detail_judul').show();
          $('#div_landing_detail_text').show();
          $('#div_landing_detail_gambar').show();
          $('#div_landing_detail_status').show();
          $('#div_image_berita_terkini').show();
          $('#div_image_home').hide();
          $('#div_image_tentang_kami').hide();
          $('#div_image_sertifikat').hide();
          $('#div_image_testimoni').hide();
        } else if (landing_template_tipe == 'S') {
          $('#div_landing_detail_nomor').show();
          $('#div_landing_detail_judul').show();
          $('#div_landing_detail_gambar').show();
          $('#div_landing_detail_file').show();
          $('#div_landing_detail_status').show();
          $('#div_image_sertifikat').show();
          $('#div_image_home').hide();
          $('#div_image_tentang_kami').hide();
          $('#div_image_berita_terkini').hide();
          $('#div_image_testimoni').hide();
        } else if (landing_template_tipe == 'C') {
          $('#div_landing_detail_nomor').show();
          $('#div_landing_detail_judul').show();
          $('#div_landing_detail_gambar').show();
          $('#div_landing_detail_status').show();
          $('#div_image_home').hide();
          $('#div_image_tentang_kami').hide();
          $('#div_image_berita_terkini').hide();
          $('#div_image_sertifikat').hide();
          $('#div_image_testimoni').hide();
        } else if (landing_template_tipe == 'K') {
          $('#div_landing_detail_judul').show();
          $('#div_landing_detail_alamat').show();
          $('#div_landing_detail_kontak').show();
          $('#div_landing_detail_fax').show();
          $('#div_landing_detail_email').show();
          $('#div_landing_detail_status').show();
          $('#div_image_home').hide();
          $('#div_image_tentang_kami').hide();
          $('#div_image_berita_terkini').hide();
          $('#div_image_sertifikat').hide();
          $('#div_image_testimoni').hide();
        } else if (landing_template_tipe == 'G') {
          $('#div_landing_detail_judul').show();
          $('#div_landing_detail_text').show();
          $('#div_landing_detail_gambar').show();
          $('#div_landing_detail_status').show();
          $('#div_image_berita_terkini').show();
          $('#div_image_home').hide();
          $('#div_image_tentang_kami').hide();
          $('#div_image_sertifikat').hide();
          $('#div_image_testimoni').hide();
        } else {
          $('#div_landing_detail_judul').hide();
          $('#div_landing_detail_gambar').hide();
        }
      }
    })
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
        $.getJSON('<?= base_url('landing/getLandingDetail') ?>', {
          landing_detail_id: id
        }, function(json) {
          console.log(json);
          $('#id_landing_temp').val(json.id_landing);
          $('#landing_detail_id').val(json.landing_detail_id);

          if (json.landing_template_tipe == 'B') {
            $('#div_landing_detail_urutan').show();
            $('#div_landing_detail_judul').show();
            $('#div_landing_detail_gambar').show();
            $('#div_landing_detail_text').hide();
            $('#div_image_home').show();
            $('#div_image_tentang_kami').hide();
            $('#div_image_berita_terkini').hide();
            $('#div_image_sertifikat').hide();
            $('#div_image_testimoni').hide();

            // data
            $('#landing_detail_urutan').val(json.landing_detail_urutan);
            $('#landing_detail_judul').val(json.landing_detail_judul);
            $('#landing_detail_image_preview').html('<img src="<?= base_url('landing/') ?>' + json.landing_detail_gambar + '" width="100px">');
            $('#landing_detail_gambar_temp').val(json.landing_detail_gambar);
          } else if (json.landing_template_tipe == 'T') {
            $('#div_landing_detail_judul').show();
            $('#div_landing_detail_gambar').show();
            $('#div_landing_detail_text').show();
            $('#div_image_home').hide();
            $('#div_image_tentang_kami').show();
            $('#div_image_berita_terkini').hide();
            $('#div_image_sertifikat').hide();
            $('#div_image_testimoni').hide();

            // data
            $('#landing_detail_text').summernote('code', json.landing_detail_text);
            $('#landing_detail_judul').val(json.landing_detail_judul);
            $('#landing_detail_image_preview').html('<img src="<?= base_url('landing/') ?>' + json.landing_detail_gambar + '" width="100px">');
            $('#landing_detail_gambar_temp').val(json.landing_detail_gambar);
          } else if (json.landing_template_tipe == 'N') {
            $('#div_landing_detail_judul').show();
            $('#div_landing_detail_gambar').show();
            $('#div_landing_detail_text').show();
            $('#div_image_home').hide();
            $('#div_image_tentang_kami').hide();
            $('#div_image_berita_terkini').show();
            $('#div_image_sertifikat').hide();
            $('#div_image_testimoni').hide();

            // data
            $('#landing_detail_text').summernote('code', json.landing_detail_text);
            $('#landing_detail_judul').val(json.landing_detail_judul);
            $('#landing_detail_image_preview').html('<img src="<?= base_url('landing/') ?>' + json.landing_detail_gambar + '" width="100px">');
            $('#landing_detail_gambar_temp').val(json.landing_detail_gambar);
          } else if (json.landing_template_tipe == 'S') {
            $('#div_landing_detail_nomor').show();
            $('#div_landing_detail_judul').show();
            $('#div_landing_detail_gambar').show();
            $('#div_landing_detail_file').show();
            $('#div_image_home').hide();
            $('#div_image_tentang_kami').hide();
            $('#div_image_berita_terkini').hide();
            $('#div_image_sertifikat').show();
            $('#div_image_testimoni').hide();

            // data
            $('#landing_detail_nomor').val(json.landing_detail_nomor);
            $('#landing_detail_judul').val(json.landing_detail_judul);
            $('#landing_detail_image_preview').html('<img src="<?= base_url('landing/') ?>' + json.landing_detail_gambar + '" width="100px">');
            $('#landing_detail_gambar_temp').val(json.landing_detail_gambar);
            $('#landing_detail_file_temp').val(json.landing_detail_file);

          } else if (json.landing_template_tipe == 'C') {
            $('#div_landing_detail_nomor').show();
            $('#div_landing_detail_judul').show();
            $('#div_landing_detail_gambar').show();
            $('#div_image_home').hide();
            $('#div_image_tentang_kami').hide();
            $('#div_image_berita_terkini').hide();
            $('#div_image_sertifikat').hide();
            $('#div_image_testimoni').hide();

            // data
            $('#landing_detail_nomor').val(json.landing_detail_nomor);
            $('#landing_detail_judul').val(json.landing_detail_judul);
            $('#landing_detail_image_preview').html('<img src="<?= base_url('landing/') ?>' + json.landing_detail_gambar + '" width="100px">');
            $('#landing_detail_gambar_temp').val(json.landing_detail_gambar);
          } else if (json.landing_template_tipe == 'K') {
            $('#div_landing_detail_judul').show();
            $('#div_landing_detail_alamat').show();
            $('#div_landing_detail_kontak').show();
            $('#div_landing_detail_fax').show();
            $('#div_landing_detail_email').show();
            $('#div_image_home').hide();
            $('#div_image_tentang_kami').hide();
            $('#div_image_berita_terkini').hide();
            $('#div_image_sertifikat').hide();
            $('#div_image_testimoni').hide();

            // data
            $('#landing_detail_judul').val(json.landing_detail_judul);
            $('#landing_detail_alamat').val(json.landing_detail_alamat);
            $('#landing_detail_kontak').val(json.landing_detail_kontak);
            $('#landing_detail_fax').val(json.landing_detail_fax);
            $('#landing_detail_email').val(json.landing_detail_email);
          } else if (json.landing_template_tipe == 'G') {
            $('#div_landing_detail_judul').show();
            $('#div_landing_detail_gambar').show();
            $('#div_landing_detail_text').show();
            $('#div_image_home').hide();
            $('#div_image_tentang_kami').hide();
            $('#div_image_berita_terkini').show();
            $('#div_image_sertifikat').hide();
            $('#div_image_testimoni').hide();

            // data
            $('#landing_detail_text').summernote('code', json.landing_detail_text);
            $('#landing_detail_judul').val(json.landing_detail_judul);
            $('#landing_detail_image_preview').html('<img src="<?= base_url('landing/') ?>' + json.landing_detail_gambar + '" width="100px">');
            $('#landing_detail_gambar_temp').val(json.landing_detail_gambar);
          }
        });
      }
    })
  }
  /* View Update Detail */

  /* Proses Detail */
  $("#form_modal_detail").on("submit", function(e) {
    e.preventDefault();
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        if ($('#landing_detail_id').val() != '') var url = '<?= base_url('landing/updateLandingDetail') ?>';
        else var url = '<?= base_url('landing/insertLandingDetail') ?>';


        var landing_detail_gambar = $('#landing_detail_gambar').prop('files')[0];
        var landing_detail_file = $('#landing_detail_file').prop('files')[0];
        // var landing_detail_thumbsnail = $('#landing_detail_thumbsnail').prop('files')[0];
        var data = new FormData();

        data.append('landing_detail_gambar', landing_detail_gambar);
        data.append('landing_detail_gambar_temp', $('#landing_detail_gambar_temp').val());
        data.append('landing_detail_file', landing_detail_file);
        data.append('landing_detail_file_temp', $('#landing_detail_file_temp').val());
        data.append('landing_detail_id', $('#landing_detail_id').val());
        data.append('landing_detail_urutan', $('#landing_detail_urutan').val());
        data.append('landing_detail_nomor', $('#landing_detail_nomor').val());
        data.append('landing_detail_judul', $('#landing_detail_judul').val());
        data.append('landing_detail_alamat', $('#landing_detail_alamat').val());
        data.append('landing_detail_kontak', $('#landing_detail_kontak').val());
        data.append('landing_detail_fax', $('#landing_detail_fax').val());
        data.append('landing_detail_email', $('#landing_detail_email').val());
        data.append('landing_detail_text', $('#landing_detail_text').val());
        data.append('landing_detail_status', $('#landing_detail_status').val());
        data.append('id_landing', $('#id_landing_temp').val());
        // data.append('landing_detail_thumbsnall', landing_detail_thumbsnail);


        e.preventDefault();
        $.ajax({
          url: url,
          data: data,
          type: 'POST',
          dataType: 'html',
          processData: false,
          contentType: false,
          success: function(isi) {
            $('#close_detail').click();
            toastr.success('Berhasil');
          }
        });
      }
    })
  });
  /* Proses Detail */

  /* Fun Delete Detail */
  function fun_delete_detail(id) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $.confirmModal('Apakah anda yakin akan menghapusnya?', function(el) {
          $.get('<?= base_url('landing/deleteLandingDetail') ?>', {
            landing_detail_id: id
          }, function(data) {
            $('#close_detail').click();
            toastr.success('Berhasil');
          });
        });
      }
    })
  }
  /* Fun Delete Detail */

  /* Fun Close Detail */
  function fun_close_detail() {
    $('#simpan_detail').css('display', 'block');
    $('#edit_detail').css('display', 'none');
    // $("#komposisi_item").empty();

    $('#table').DataTable().ajax.reload();

    $('#form_modal_detail')[0].reset();
    $('#landing_detail_text').summernote('reset');


    $('#table_detail_banner').DataTable().ajax.reload();
    $('#table_detail_tentang').DataTable().ajax.reload();
    $('#table_detail_berita').DataTable().ajax.reload();
    $('#table_detail_sertifikat').DataTable().ajax.reload();
    $('#table_detail_kerjasama').DataTable().ajax.reload();
    $('#table_detail_kontak').DataTable().ajax.reload();

    fun_loading();

    // hide all div
    $('#div_landing_detail_urutan').hide();
    $('#div_landing_detail_nomor').hide();
    $('#div_landing_detail_judul').hide();
    $('#div_landing_detail_alamat').hide();
    $('#div_landing_detail_kontak').hide();
    $('#div_landing_detail_fax').hide();
    $('#div_landing_detail_email').hide();
    $('#div_landing_detail_text').hide();
    $('#div_landing_detail_gambar').hide();


  }
  /* Fun Close Detail */

  $('#modal_detail').on('hidden.bs.modal', function(e) {
    fun_close_detail();
  });

  function fun_loading() {
    var simplebar = new Nanobar();
    simplebar.go(100);
  }

  function func_lihat(data) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        fun_loading();
        $('#document').remove();
        $('#div_document').append('<embed src="<?= base_url('landing/') ?>' + data + '#toolbar=0" frameborder="0" id="document" width="100%" height="600px"></embed>');
      }
    });
  }


  // Summernote
  $('#landing_detail_text').summernote()

  function ganti_tipe(id) {
    $.getJSON('<?= base_url('landing/getLandingTemplateTipe') ?>', {
      landing_template_id: id,
    }, function(result) {
      console.log(result);
      $('#landing_template_tipe').val(result.landing_template_tipe);
      $('#landing_tipe').val(result.landing_template_tipe);
    })
  }
</script>