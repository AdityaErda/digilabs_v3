<script type="text/javascript">
  $(function() {
    // date range
    // $('#tanggal_cari').daterangepicker({
    //   locale:{format: 'DD-MM-YYYY'}
    // })


    // date range
    /* Isi Table */
    $('#table').DataTable({
      "scrollX": true,
      // "order":[[0,"desc"]],
      "lengthMenu": [
        [5, 10, 25, 50, -1],
        [5, 10, 25, 50, "All"]
      ],
      "dom": 'lBfrtip',
      // "buttons": ["csv", "pdf", "excel","copy","print"],
      buttons: [{
          extend: 'csvHtml5',
          footer: true
        },
        {
          extend: 'pdfHtml5',
          footer: true
        },
        {
          extend: 'excelHtml5',
          footer: true
        },
        {
          extend: 'copyHtml5',
          footer: true
        },
        {
          extend: 'print',
          footer: true
        },
      ],
      "ordering": false,
      // "paging":false,
      "ajax": {
        "url": "<?= base_url() ?>/material/report_perhitungan/getReportPerhitungan?filter=" + $('#filter').val(),
        // "url": "<?= base_url() ?>/material/report_perhitungan/getReportPerhitungan",
        "dataSrc": ""
      },

      "columns": [{
          render: function(data, type, full, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        {
          "data": "transaksi_waktu"
        },
        {
          "data": "seksi_nama"
        },
        {
          "data": "item_nama"
        },
        {
          "data": "item_satuan"
        },
        {
          "data": "transaksi_detail_jumlah"
        },

        {
          "data": "item_harga",
          "className": "text-right",
          render: $.fn.dataTable.render.number('.', ',', 2, 'Rp. ')
        },
        {
          "data": "transaksi_detail_total",
          "className": "text-right",
          render: $.fn.dataTable.render.number('.', ',', 2, 'Rp. ')
        },
      ],
      "footerCallback": function(row, data, start, end, display) {
        var api = this.api(),
          data;

        // Remove the formatting to get integer data for summation
        var intVal = function(i) {
          return typeof i === 'string' ?
            i.replace(/[\R\p,]]/g, '') * 1 :
            typeof i === 'number' ?
            i : 0;
        };

        // Total over all pages
        total = api
          .column(7)
          .data()
          .reduce(function(a, b) {
            return intVal(a) + intVal(b);
          }, 0);

        // Total over this page
        pageTotal = api
          .column(7, {
            page: 'current'
          })
          .data()
          .reduce(function(a, b) {
            return intVal(a) + intVal(b);
          }, 0);

        // var inputVal = "";
        reverse = total.toString().split('').reverse().join(''),
          // if (input) {
          total = reverse.match(/\d{1,3}/g);
        // inputVal = t otal.value;
        // }
        total = total.join('.').split('').reverse().join('');

        // Update footer
        $(api.column(7).footer()).html(
          'Rp. ' + (total) + ',00'
        );
      },
    });
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

    /* Select2 */
    $('.select2').select2({
      placeholder: 'Pilih',
    });

    $('.select2-selection').css('height', '37px');
    $('.select2').css('width', '100%');
    /* Select2 */

    $('#material_cari').select2({
      allowClear: true,
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

    $('.select2-selection').css('height', '37px');
    $('.select2').css('width', '100%');

    $('#peminta_jasa_cari').select2({
      allowClear: true,
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url('material/request/getSeksiList') ?>',
        dataType: 'json',
        type: 'GET',
        data: function(params) {
          var queryParameters = {
            seksi_nama: params.term
          }

          return queryParameters;
        }
      }
    });

    $('.select2-selection').css('height', '37px');
    $('.select2').css('width', '100%');
    /* Select2 Peminta Jasa */
  });

  $('.datetimepicker').datetimepicker({
    format: 'YYYY-MM-DD'
  })

  // $(function(){
  $('#filter').on('submit', function(e) {
    e.preventDefault();
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        fun_loading();
        $('#table').DataTable().ajax.url('<?= base_url() ?>material/report_perhitungan/getReportPerhitungan?' + $('#filter').serialize()).load();
      }
    })
  })
  // })


  function fun_cetak() {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        fun_loading();
        item = $('#item_id').val();
        window.open('<?= base_url() ?>material/report_perhitungan/print?' + $('#filter').serialize(), '_blank');
      }
    })
  }




  /* Fun Loading */
  function fun_loading() {
    var simplebar = new Nanobar();
    simplebar.go(100);
  }
  /* Fun Loading */
</script>