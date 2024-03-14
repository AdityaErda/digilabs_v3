<script>
  $(document).ready(function() {
    /* Isi Table */
    $('#table').DataTable({
      "scrollX": true,
      "ordering": false,
      "searching": false,
      "lengthChange": false,
      "ajax": {
        "url": "<?= base_url() ?>dashboard/order/getOrderCustomer?tahun=<?= date('Y') ?>",
        "dataSrc": ""
      },
      "columns": [{
          "data": "peminta_jasa_nama"
        },
        {
          "data": "total",
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
          .column(1)
          .data()
          .reduce(function(a, b) {
            return intVal(a) + intVal(b);
          }, 0);

        // Total over this page
        pageTotal = api
          .column(1, {
            page: 'current'
          })
          .data()
          .reduce(function(a, b) {
            return intVal(a) + intVal(b);
          }, 0);

        // var inputVal = "";
        reverse = pageTotal.toString().split('').reverse().join(''),
          // if (input) {
          total = reverse.match(/\d{1,3}/g);
        // inputVal = t otal.value;
        // }
        total = total.join('.').split('').reverse().join('');

        // Update footer
        $(api.column(1).footer()).html(
          'Rp. ' + (total) + ',00'
        );
      },
    });
    /* Isi Table */

    /* Isi Table */
    $('#table_eksternal').DataTable({
      "ordering": false,
      "ajax": {
        "url": "<?= base_url() ?>dashboard/order/getOrderData?transaksi_tipe=E&tahun=<?= date('Y') ?>",
        "dataSrc": ""
      },
      "columns": [{
          "data": "transaksi_detail_tgl_pengajuan_baru"
        },
        {
          "data": "transaksi_detail_tgl_estimasi_baru"
        },
        {
          "data": "sample_pekerjaan_nama"
        },
        {
          "data": "peminta_jasa_nama"
        },
        {
          "data": "jenis_nama"
        },
        {
          "data": "identitas_nama"
        },
        {
          "data": "transaksi_nomor"
        },
        {
          "data": "transaksi_detail_nomor_sample"
        },
        {
          "data": "transaksi_detail_no_surat"
        },
        {
          "render": function(data, type, full, meta) {
            var status = '';
            var warna = '';
            if (full.transaksi_detail_status == '0') {
              status = 'Draft';
              warna = '#e8d234';
            } else if (full.transaksi_detail_status == '1') {
              status = 'Pengajuan';
              warna = '#5fa7bb';
            } else if (full.transaksi_detail_status == '2') {
              status = 'Review AVP';
              warna = '#5fa7dd';
            } else if (full.transaksi_detail_status == '3') {
              status = 'Approve VP';
              warna = '#5eb916';
            } else if (full.transaksi_detail_status == '4') {
              status = 'Approve VP PPK';
              warna = '#ea815f';
            } else if (full.transaksi_detail_status == '5') {
              status = 'Approve AVP LUK';
              warna = '#ea815f';
            } else if (full.transaksi_detail_status == '6') {
              status = 'Sample Belum Diterima';
              warna = '#ea815f';
            } else if (full.transaksi_detail_status == '12') {
              status = 'Tunda'; //Sample Diterima
              warna = ' #f37b2d';
            } else if (full.transaksi_detail_status == '7') {
              status = 'Sample Diterima';
              warna = '#69e8aa';
            } else if (full.transaksi_detail_status == '13') {
              status = 'Tunda dan Close'; //Sample On Progress
              warna = ' #f37b2d';
            } else if (full.transaksi_detail_status == '8') {
              status = 'On Progress';
              warna = '#69c5e8';
            } else if (full.transaksi_detail_status == '9') {
              status = 'Draft Log Sheet';
              warna = '#e8d369';
            } else if (full.transaksi_detail_status == '10') {
              status = 'Menunggu Review Kasie';
              warna = '#e8d369';
            } else if (full.transaksi_detail_status == '11') {
              status = 'Review Kasie';
              warna = '#79724d';
            } else if (full.transaksi_detail_status == '14') {
              status = 'Batal';
              warna = 'red';
            } else if (full.transaksi_detail_status == '15') {
              status = 'Reject';
              warna = '#c13333';
            } else if (full.transaksi_detail_status == '16') {
              status = 'Send DOF';
              warna = '#c13333';
            } else if (full.transaksi_detail_status == '17') {
              status = 'Terbit Sertifikat';
              warna = '#e8d369';
            } else if (full.transaksi_detail_status == '18' && full.logsheet_id == null) {
              status = 'Closed NOn Letter';
              warna = '#c13333';
            } else if (full.transaksi_detail_status == '18') {
              status = 'Closed';
              warna = '#c13333';
            }

            return '<span class="badge" style="background-color: ' + warna + '">' + status + '</span>';
          }
        },
        {
          "render": function(data, type, full, meta) {
            var note = '';
            if ((full.transaksi_status == '3' && full.transaksi_detail_status == '9') || (full.transaksi_status == '4' && full.transaksi_detail_status == '9') || (full.transaksi_status == '8')) {
              note = full.transaksi_detail_note
            } else {
              note = '-';
            }
            return note;
          }
        },
        {
          "render": function(data, type, full, meta) {
            var lihat = '';
            if (full.transaksi_status == '6' && (full.transaksi_detail_file != '')) {
              // if (full.transaksi_status == '6' && (full.transaksi_detail_file != '')) {
              lihat = '<center><a href="javascript:;" onclick="fun_lihat(this.id,this.name)" id="' + full.transaksi_detail_file + '" name="' + full.transaksi_nomor + '" data-toggle="modal" data-target="#modal_lihat"><i class="fa fa-file"></i></a></center>'
            } else {
              lihat = '-';
            }
            return lihat;
          }
        },
      ]
    }).columns.adjust().draw();
    /* Isi Table */

    /* Isi Table */
    $('#table_internal').DataTable({
      // "scrollX":true,
      "order": [
        [0, "desc"]
      ],
      "ajax": {
        "url": "<?= base_url() ?>dashboard/order/getOrderData?transaksi_tipe=I&tahun=<?= date('Y') ?>",
        "dataSrc": ""
      },
      "columns": [{
          "data": "transaksi_detail_tgl_pengajuan_baru"
        },
        {
          "data": "transaksi_detail_tgl_estimasi_baru"
        },
        {
          "data": "sample_pekerjaan_nama"
        },
        {
          "data": "peminta_jasa_nama"
        },
        {
          "data": "jenis_nama"
        },
        {
          "data": "identitas_nama"
        },
        {
          "data": "transaksi_nomor"
        },
        {
          "data": "transaksi_detail_nomor_sample"
        },
        {
          "data": "transaksi_detail_no_surat"
        },
        {
          "render": function(data, type, full, meta) {
            var status = '';
            var warna = '';
            if (full.transaksi_detail_status == '0') {
              status = 'Draft';
              warna = '#e8d234';
            } else if (full.transaksi_detail_status == '1') {
              status = 'Pengajuan';
              warna = '#5fa7bb';
            } else if (full.transaksi_detail_status == '2') {
              status = 'Review AVP';
              warna = '#5fa7dd';
            } else if (full.transaksi_detail_status == '3') {
              status = 'Approve VP';
              warna = '#5eb916';
            } else if (full.transaksi_detail_status == '4') {
              status = 'Approve VP PPK';
              warna = '#ea815f';
            } else if (full.transaksi_detail_status == '5') {
              status = 'Approve AVP LUK';
              warna = '#ea815f';
            } else if (full.transaksi_detail_status == '6') {
              status = 'Sample Belum Diterima';
              warna = '#ea815f';
            } else if (full.transaksi_detail_status == '12') {
              status = 'Tunda'; //Sample Diterima
              warna = ' #f37b2d';
            } else if (full.transaksi_detail_status == '7') {
              status = 'Sample Diterima';
              warna = '#69e8aa';
            } else if (full.transaksi_detail_status == '13') {
              status = 'Tunda dan Close'; //Sample On Progress
              warna = ' #f37b2d';
            } else if (full.transaksi_detail_status == '8') {
              status = 'On Progress';
              warna = '#69c5e8';
            } else if (full.transaksi_detail_status == '9') {
              status = 'Draft Log Sheet';
              warna = '#e8d369';
            } else if (full.transaksi_detail_status == '10') {
              status = 'Menunggu Review Kasie';
              warna = '#e8d369';
            } else if (full.transaksi_detail_status == '11') {
              status = 'Review Kasie';
              warna = '#79724d';
            } else if (full.transaksi_detail_status == '14') {
              status = 'Batal';
              warna = 'red';
            } else if (full.transaksi_detail_status == '15') {
              status = 'Reject';
              warna = '#c13333';
            } else if (full.transaksi_detail_status == '16') {
              status = 'Send DOF';
              warna = '#c13333';
            } else if (full.transaksi_detail_status == '17') {
              status = 'Terbit Sertifikat';
              warna = '#e8d369';
            } else if (full.transaksi_detail_status == '18' && full.logsheet_id == null) {
              status = 'Closed NOn Letter';
              warna = '#c13333';
            } else if (full.transaksi_detail_status == '18') {
              status = 'Closed';
              warna = '#c13333';
            }

            return '<span class="badge" style="background-color: ' + warna + '">' + status + '</span>';
          }
        },
        {
          "render": function(data, type, full, meta) {
            var note = '';
            if ((full.transaksi_status == '3' && full.transaksi_detail_status == '9') || (full.transaksi_status == '4' && full.transaksi_detail_status == '9') || (full.transaksi_status == '8')) {
              note = full.transaksi_detail_note
            } else {
              note = '-';
            }
            return note;
          }
        },
        {
          "render": function(data, type, full, meta) {
            var lihat = '';
            if (full.transaksi_status == '6' && (full.transaksi_detail_file != '')) {
              lihat = '<center><a href="javascript:;" onclick="fun_lihat(this.id,this.name)" id="' + full.transaksi_detail_file + '" name="' + full.transaksi_nomor + '" data-toggle="modal" data-target="#modal_lihat"><i class="fa fa-file"></i></a></center>'
            } else {
              lihat = '-';
            }
            return lihat;
          }
        },
      ]
    }).columns.adjust().draw();
    /* Isi Table */

    /* Isi Table */
    $('#table_rutin').DataTable({
      "responsive": true,
      "ordering": false,
      "cache": false,
      "ajax": {
        "url": "<?= base_url() ?>dashboard/order/getOrderData?transaksi_tipe=R&transaksi_status=8&tahun=<?= date('Y') ?>",
        "dataSrc": ""
      },
      "columns": [{
          "data": "transaksi_detail_tgl_pengajuan_baru"
        },
        {
          "data": "sample_pekerjaan_nama"
        },
        {
          "data": "peminta_jasa_nama"
        },
        {
          "data": "jenis_nama"
        },
        {
          "data": "identitas_nama"
        },
        {
          "data": "transaksi_detail_no_memo"
        },
        {
          "data": "transaksi_nomor"
        },
        {
          "data": "transaksi_detail_no_surat"
        },
        {
          "render": function(data, type, full, meta) {
            var status = '';
            var warna = '';
            if (full.transaksi_detail_status == '0') {
              status = 'Draft';
              warna = '#e8d234';
            } else if (full.transaksi_detail_status == '1') {
              status = 'Pengajuan';
              warna = '#5fa7bb';
            } else if (full.transaksi_detail_status == '2') {
              status = 'Review AVP';
              warna = '#5fa7dd';
            } else if (full.transaksi_detail_status == '3') {
              status = 'Approve VP';
              warna = '#5eb916';
            } else if (full.transaksi_detail_status == '4') {
              status = 'Approve VP PPK';
              warna = '#ea815f';
            } else if (full.transaksi_detail_status == '5') {
              status = 'Approve AVP LUK';
              warna = '#ea815f';
            } else if (full.transaksi_detail_status == '6') {
              status = 'Sample Belum Diterima';
              warna = '#ea815f';
            } else if (full.transaksi_detail_status == '12') {
              status = 'Tunda'; //Sample Diterima
              warna = ' #f37b2d';
            } else if (full.transaksi_detail_status == '7') {
              status = 'Sample Diterima';
              warna = '#69e8aa';
            } else if (full.transaksi_detail_status == '13') {
              status = 'Tunda dan Close'; //Sample On Progress
              warna = ' #f37b2d';
            } else if (full.transaksi_detail_status == '8') {
              status = 'On Progress';
              warna = '#69c5e8';
            } else if (full.transaksi_detail_status == '9') {
              status = 'Draft Log Sheet';
              warna = '#e8d369';
            } else if (full.transaksi_detail_status == '10') {
              status = 'Menunggu Review Kasie';
              warna = '#e8d369';
            } else if (full.transaksi_detail_status == '11') {
              status = 'Review Kasie';
              warna = '#79724d';
            } else if (full.transaksi_detail_status == '14') {
              status = 'Batal';
              warna = 'red';
            } else if (full.transaksi_detail_status == '15') {
              status = 'Reject';
              warna = '#c13333';
            } else if (full.transaksi_detail_status == '16') {
              status = 'Send DOF';
              warna = '#c13333';
            } else if (full.transaksi_detail_status == '17') {
              status = 'Terbit Sertifikat';
              warna = '#e8d369';
            } else if (full.transaksi_detail_status == '18' && full.logsheet_id == null) {
              status = 'Closed NOn Letter';
              warna = '#c13333';
            } else if (full.transaksi_detail_status == '18') {
              status = 'Closed';
              warna = '#c13333';
            }

            return '<span class="badge" style="background-color: ' + warna + '">' + status + '</span>';
          }
        },
        {
          "data": "transaksi_detail_note"
        },
        {
          render: function(data, type, full, meta) {
            var lihat = '';
            if (full.transaksi_status == '6' && (full.transaksi_detail_file != '')) {
              lihat = '<center><a href="javascript:;" onclick="fun_lihat(this.id,this.name)" id="' + full.transaksi_detail_file + '" name="' + full.transaksi_nomor + '" data-toggle="modal" data-target="#modal_lihat"><i class="fa fa-file"></i></a></center>'
            } else {
              lihat = '-';
            }
            return lihat;
          }
        },
      ],
      columnDefs: [{
          targets: 8,
          defaultContent: ''
        },
        {
          targets: 10,
          defaultContent: ''
        }
      ]
    }).columns.adjust().draw();
    /* Isi Table */

    fun_grafik('<?= date('Y') ?>');
  });

  function fun_grafik(tahun) {
    $.getJSON('<?= base_url('dashboard/order/getOrderTotal') . '?isi=ok&transaksi_tipe=E&tahun=' ?>' + tahun, function(json) {
      $('#total_eksternal').html(json.total)
    });
    $.getJSON('<?= base_url('dashboard/order/getOrderTotal') . '?isi=ok&transaksi_tipe=I&tahun=' ?>' + tahun, function(json) {
      $('#total_internal').html(json.total)
    });
    $.getJSON('<?= base_url('dashboard/order/getOrderTotal') . '?transaksi_status=8&isi=ok&transaksi_tipe=R&tahun=' ?>' + tahun, function(json) {
      $('#total_rutin').html(json.total)
    });

    $.getJSON('<?= base_url('dashboard/order/getSumParameter?tahun=') ?>' + tahun, function(json) {
      $('#total_parameter').html(json.total)
    });

    $('#table').DataTable().ajax.url('<?= base_url() ?>dashboard/order/getOrderCustomer?tahun=' + tahun).load();
    $('#table_eksternal').DataTable().ajax.url('<?= base_url('dashboard/order/getOrderData') . '?isi=ok&transaksi_tipe=E&tahun=' ?>' + tahun).load();
    $('#table_internal').DataTable().ajax.url('<?= base_url('dashboard/order/getOrderData') . '?isi=ok&transaksi_tipe=I&tahun=' ?>' + tahun).load();
    $('#table_rutin').DataTable().ajax.url('<?= base_url('dashboard/order/getOrderData') . '?transaksi_status=8&isi=ok&transaksi_tipe=R&tahun=' ?>' + tahun).load();


    $.ajax({
      url: "<?= base_url() ?>dashboard/order/getOrderBulan?tahun=" + tahun,
      method: "GET",
      async: true,
      dataType: 'json',
      success: function(isi) {
        var label = [];
        var internal = []
        var eksternal = []
        var rutin = []

        $.each(isi, function(index, val) {
          label.push(val.bulan);
          internal.push(val.total_internal);
          eksternal.push(val.total_eksternal);
          rutin.push(val.total_rutin);
        });

        $('#chartBulan').remove();
        $('#div_chartBulan').append('<canvas id="chartBulan" style="width: 100%;"></canvas>');
        var ctx = document.getElementById('chartBulan').getContext('2d');
        var myChart = new Chart(ctx, {
          type: 'line',
          data: {
            labels: label,
            datasets: [{
                label: 'Total Eksternal',
                data: eksternal,
                backgroundColor: ['rgba(220, 53, 69, 0.5)'],
                borderColor: ['rgba(220, 53, 69, 1)'],
                borderWidth: 1
              },
              {
                label: 'Total Internal',
                data: internal,
                backgroundColor: ['rgba(23, 162, 184, 0.5)'],
                borderColor: ['rgba(23, 162, 184, 1)'],
                borderWidth: 1
              },
              {
                label: 'Total Rutin',
                data: rutin,
                backgroundColor: ['rgba(23, 162, 61, 0.5)'],
                borderColor: ['rgba(23, 162, 61, 1)'],
                borderWidth: 1
              }
            ]
          },
          options: {
            scales: {
              y: {
                beginAtZero: true
              }
            }
          }
        });
      }
    });

    $.ajax({
      url: "<?= base_url() ?>dashboard/order/getOrderSeksi?tahun=" + tahun,
      method: "GET",
      async: true,
      dataType: 'json',
      success: function(isi) {
        var label = [];
        var value = [];

        $.each(isi, function(index, val) {
          label.push(val.seksi_nama);
          value.push(val.total);
        });

        $('#chartSeksi').remove();
        $('#div_chartSeksi').append('<canvas id="chartSeksi" style="width: 100%;"></canvas>');
        var ctx = document.getElementById('chartSeksi').getContext('2d');
        var myChart = new Chart(ctx, {
          type: 'doughnut',
          data: {
            labels: label,
            datasets: [{
              label: 'Sample Internal',
              data: value,
              backgroundColor: ['blue', 'red', 'green', 'orange', 'black', ],
            }]
          }
        });
      }
    });

    $.ajax({
      url: "<?= base_url() ?>dashboard/order/getOrderStatus?tahun=" + tahun,
      method: "GET",
      async: true,
      dataType: 'json',
      success: function(isi) {
        var label = [];
        var value = [];

        $.each(isi, function(index, val) {
          if (val.transaksi_detail_status == '12') var status = 'Tunda';
          else if (val.transaksi_detail_status == '15') var status = 'Reject';
          else if (val.transaksi_detail_status == '18') var status = 'Clossed';
          label.push(status);
          value.push(val.total);

        });

        $('#chartStatus').remove();
        $('#div_chartStatus').append('<canvas id="chartStatus" style="width: 100%;"></canvas>');
        var ctx = document.getElementById('chartStatus').getContext('2d');
        var myChart = new Chart(ctx, {
          type: 'doughnut',
          data: {
            labels: label,
            datasets: [{
              label: 'Sample',
              data: value,
              backgroundColor: ['blue', 'red', 'green'],
            }]
          }
        });
      }
    });

    $.ajax({
      url: "<?= base_url() ?>dashboard/order/getPendapatanBulan?tahun=" + tahun,
      method: "GET",
      async: true,
      dataType: 'json',
      success: function(isi) {
        var label = [];
        var value = [];
        var value_lalu = [];

        $.each(isi, function(index, val) {
          label.push(val.bulan);
          value.push((val.total != null) ? val.total : 0);
          value_lalu.push((val.total_lalu != null) ? val.total_lalu : 0);
        });

        $('#chart_pendapatan').remove();
        $('#div_chart_pendapatan').append('<canvas id="chart_pendapatan" style="width: 100%;"></canvas>');
        var ctx = document.getElementById('chart_pendapatan').getContext('2d');
        var myChart = new Chart(ctx, {
          type: 'line',
          data: {
            labels: label,
            datasets: [{
              label: 'Total Pendapatan Thn Lalu',
              data: value_lalu,
              backgroundColor: ['rgba(40, 20, 20, 0.2)'],
              borderColor: ['rgba(40, 20, 20, 1)'],
              borderWidth: 1
            }, {
              label: 'Total Pendapatan',
              data: value,
              backgroundColor: ['rgba(255, 99, 132, 0.2)'],
              borderColor: ['rgba(255, 99, 132, 1)'],
              borderWidth: 1
            }]
          },
          options: {
            scales: {
              y: {
                beginAtZero: true
              }
            }
          }
        });
      }
    });
  }

  function fun_lihat(data, name) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        // fun_loading();
        $('#judul_lihat').html("Sample " + name);
        $('#document').remove();
        $('#div_document').append('<embed src="<?= base_url('document/') ?>' + data + '#toolbar=0" frameborder="0" id="document" width="100%" height="600px"></embed>');
      }
    });
  }
</script>