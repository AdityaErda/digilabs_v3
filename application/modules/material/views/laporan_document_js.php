<script type="text/javascript">
  $(function() {
    // tanggal range
    // $('#tanggal_cari').daterangepicker({
    //   locale:
    //           {format: 'DD-MM-YYYY'},
    // })
    // tangggal range
    /* Isi Table */
    $('#table thead tr')
      .clone(true)
      .addClass('filters')
      .appendTo('#table thead');

    var table = $('#table').DataTable({
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
            $(cell).html('<input type="text" class="form-control" placeholder="' + title + '" />');

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
      "lengthMenu": [
        [5, 10, 25, 50, -1],
        [5, 10, 25, 50, "All"]
      ],
      // "order":[[0,"desc"],[1,"desc"]],
      "dom": 'lBfrtip',
      "buttons": ["csv", "pdf", "excel", "copy", "print"],
      "scrollX": true,
      "ajax": {
        "url": "<?= base_url('material/laporan_document/getLapDocument?tanggal_cari=') ?>" + $('#tanggal_cari').val(),
        "dataSrc": ""
      },
      "columns": [{
          render: function(data, type, full, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        {
          "data": "batch_file_tgl_terbit"
        },
        {
          "data": "batch_file_tgl_expired"
        },
        {
          "data": "item_nama"
        },
        {
          "data": "list_batch_kode_final"
        },
        {
          "data": "batch_file_judul"
        },
        {
          "data": "batch_file_isi"
        },
      ]
    }).columns.adjust();

    new $.fn.dataTable.FixedHeader(table);
    /* Isi Table */

    /* Tanggal */
    $(".tanggal").daterangepicker({
      showDropdowns: true,
      singleDatePicker: true,
      locale: {
        format: 'DD-MM-YYYY'
      }
    });
    /* Tanggal */

    $('.datetimepicker').datetimepicker({
      format: 'YYYY-MM-DD'
    })

    //filter
    $('#filter').on('submit', function(e) {
      e.preventDefault();
      $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
        if (!json.user_id) {
          fun_notifLogout();
        } else {
          $('#table').DataTable().ajax.url('<?= base_url('material/laporan_document/getLapDocument?') ?>' + $('#filter').serialize()).load();
        }
      });
    })
    // filter
    /* Select2 */
    $('.select2').select2({
      placeholder: 'Pilih',
    });

    $('.select2-selection').css('height', '37px');
    $('.select2').css('width', '100%');
    /* Select2 */
  });

  // cetak

  function func_cetak() {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        window.open('<?= base_url('material/laporan_document/cetakLapDocument?') ?>' + $('#filter').serialize(), '_blank');
      }
    });
  }
</script>