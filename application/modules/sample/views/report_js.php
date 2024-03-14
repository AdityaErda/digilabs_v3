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
      "fixedHeader": true,
      "scrollX": true,
      "lengthMenu": [
        [5, 10, 25, 50, -1],
        [5, 10, 25, 50, "All"]
        ],
      "dom": 'lBfrtip',
      "buttons": ["csv", "pdf", "excel", "copy", "print"],
      "scrollX": true,
      "ajax": {
        "url": "<?= base_url('sample/report/getParameter') ?>",
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
        "data": "rumus_nama"
      },
      {
        "render": function(data, type, full, meta) {
          return '<center><a href="javascript:;" id="' + full.jenis_id + '"  title="Detail" onclick="fun_detail(this.id,`' + full.id_rumus + '`)"><i class="fa fa-search"></i></a></center>';
        }
      },
      ]
    });
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
        "url": "<?= base_url() ?>sample/report/getHistoryLogSheet?transaksi_id=0",
        "dataSrc": ""
      },
      "columns": [{
        "data": "when_create_baru"
      },
      {
        "data": "transaksi_detail_nomor_sample"
      },
      {
        "data": "rumus_hasil"
      },
      {
        "data": "rumus_satuan"
      }
      ]
    });
    /* Isi Table Detail */

    /* Jenis Sample */
    $('#jenis').select2({
      allowClear: true,
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url('sample/report/getJenisSample') ?>',
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
    /* Jenis Sample */

    /* Select2 */
    $('.select2-selection').css('height', '37px');
    $('.select2').css('width', '100%');
    /* Select2 */

    $('.datetimepicker').datetimepicker({
      format: 'YYYY-MM-DD'
    })
  });


  /* Fun Detail */
function fun_detail(id, rumus, tanggal, tanggalx) {
  var tanggal = $('#tanggal_cari_awal').val();
  var tanggalx = $('#tanggal_cari_akhir').val();

  $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
    if (!json.user_id) {
      fun_notifLogout();
    } else {
      fun_loading();
      $('#temp_transaksi_id').val(id);
      $('#temp_id_rumus').val(rumus);
      $('#div_detail').css('display', 'block');
      $('#div_grafik').css('display', 'block');
      $('#table_detail').DataTable().ajax.url('<?= base_url() ?>sample/report/getHistoryLogSheet?jenis_id=' + id + '&id_rumus=' + rumus + '&tanggal_cari_awal=' + tanggal + '&tanggal_cari_akhir=' + tanggalx).load();
      $('html, body').animate({
        scrollTop: $("#div_detail").offset().top
      }, 10);

      $.ajax({  
        url: "<?= base_url('sample/report/getHistoryLogSheet?jenis_id=') ?>" + id + '&id_rumus=' + rumus + '&tanggal_cari_awal=' + tanggal + '&tanggal_cari_akhir=' + tanggalx,
        method: "GET",
        async: true,
        dataType: 'json',
        success: function(id) {
          console.log(id);
          var label = [];
          var value = []

          $.each(id, function(index, val) {
            label.push(val.when_create_baru+'('+val.rumus_satuan+')');
            value.push(val.rumus_hasil);
          });

          $('#chartReportSample').remove();
          $('#div_chartReportSample').append('<canvas id="chartReportSample" style="width: 100%;"></canvas>');
          var ctx = document.getElementById('chartReportSample').getContext('2d');
          var chartReportSample = new Chart(ctx, {
            type: 'line',
            data: {
              labels: label,
              datasets: [{
                label: 'Hasil Uji',
                data: value,
                backgroundColor: ['rgba(255, 99, 132, 0.2)'],
                borderColor: ['rgba(255, 99, 132, 1)'],
                borderWidth: 1
              }]
            },
            options: {
              scales: {
                  // y: {
                  //   beginAtZero: true
                  // }
                y: [{
                  ticks: {
                    callback: function (value) {
                      return numeral(value).format('$ 0,0')
                    }
                  }
                }]
              }
            }
          });
        }
      });
    }
  })
}
  /* Fun Detail */

  /* Filter */
$("#filter").on("submit", function(e) {
  e.preventDefault();
  $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
    if (!json.user_id) {
      fun_notifLogout();
    } else {
      $('#div_detail').css('display', 'none');
      $('#div_grafik').css('display', 'none');
      $('#table').DataTable().ajax.url('<?= base_url() ?>sample/report/getParameter?' + $('#filter').serialize()).load();
      fun_loading();
    }
  })
});
  /* Filter */

  /* Fun Cetak */
function fun_cetak(rumus) {
  var rumus = $('#temp_id_rumus').val();
  $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
    if (!json.user_id) {
      fun_notifLogout();
    } else {
      window.open('<?= base_url() ?>/sample/report/print?' + $('#filter').serialize() + '&id_rumus=' + rumus, '_blank');
    }
  })
}
  /* Fun Cetak */

  /* Fun Loading */
function fun_loading() {
  var simplebar = new Nanobar();
  simplebar.go(100);
}
  /* Fun Loading */
</script>