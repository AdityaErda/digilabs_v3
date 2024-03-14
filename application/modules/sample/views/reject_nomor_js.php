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
      "lengthMenu": [
        [5, 10, 25, 50, -1],
        [5, 10, 25, 50, "All"]
      ],
      "dom": 'lBfrtip',
      "buttons": ["csv", "pdf", "excel", "copy", "print"],
      "ajax": {
        "url": "<?= base_url() ?>sample/reject_nomor/getNomor?tgl_cari=<?= date('d-m-Y') . ' - ' . date('d-m-Y') ?>",
        "dataSrc": ""
      },
      "columns": [{
          render: function(data, type, full, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        {
          "data": "transaksi_detail_tgl_pengajuan_baru"
        },
        {
          "data": "transaksi_nomor"
        },
        {
          "data": "jenis_nama"
        },
        {
          "data": "sample_pekerjaan_nama"
        },
      ]
    });
    /* Isi Table */

    /* Tanggal */
    $("#tgl_cari").daterangepicker({
      locale: {
        format: 'DD-MM-YYYY'
      }
    });
    /* Tanggal */
  });

  $('.datetimepicker').datetimepicker({
    format: 'YYYY-MM-DD'
  })

  /* Filter */
  $("#filter").on("submit", function(e) {
    e.preventDefault();
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        fun_loading();
        $('#table').DataTable().ajax.url('<?= base_url() ?>sample/reject_nomor/getNomor?' + $('#filter').serialize()).load();
      }
    });
  });
  /* Filter */

  $('#reject').on('click', function(event) {
    event.preventDefault();
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $.confirmModal('Apakah anda yakin akan mereject data ini?', function(el) {
          $.ajax({
              url: '<?= base_url() ?>sample/reject_nomor/prosesNomor?' + $('#filter').serialize(),
              dataType: 'html',
            })
            .always(function() {
              fun_loading();
              $('#table').DataTable().ajax.reload();
            });
        });
      }
    });
  });

  /* Fun Loading */
  function fun_loading() {
    var simplebar = new Nanobar();
    simplebar.go(100);
  }
  /* Fun Loading */
</script>