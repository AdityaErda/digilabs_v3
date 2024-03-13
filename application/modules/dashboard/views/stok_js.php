<script>
  $(function() {
    /* Isi Table */
    $('#table_item').DataTable({
      "scrollX": true,
      "ordering": false,
      "ajax": {
        "url": "<?= base_url() ?>dashboard/stok/getItem?tahun=<?= date('Y') ?>",
        "dataSrc": ""
      },
      "columns": [{
          "data": "item_nama"
        },
        {
          "data": "total"
        },
      ]
    });
    /* Isi Table */

    /* Isi Table */
    $('#table_material_request').DataTable({
      "ordering": false,
      "ajax": {
        "url": "<?= base_url('dashboard/stok/getMaterial?tahun=') . date('Y') ?>",
        "dataSrc": ""
      },
      "columns": [{
          "data": "transaksi_waktu"
        },
        {
          "data": "transaksi_jam"
        },
        {
          "data": "seksi_nama"
        },
        {
          "render": function(data, type, full, meta) {

            var status = '';
            var warna = '';
            if (full.transaksi_status == 'n') {
              status = 'Pengajuan';
              warna = '#FFD700';
            } else if (full.transaksi_status == 'y') {
              status = 'Approved';
              warna = '#87CEFA';
            }
            return '<span class="badge" style="background-color: ' + warna + '">' + status + '</span>';
          }
        },
      ]
    });
    /* Isi Table */

    /* Isi Table */
    $('#table_material_transaksi').DataTable({
      "ordering": false,
      "ajax": {
        "url": "<?= base_url('dashboard/stok/getRequest?tahun=') . date('Y') ?>",
        "dataSrc": ""
      },
      "columns": [{
          "data": "transaksi_waktu"
        },
        {
          "data": "transaksi_jam"
        },
        {
          "data": "seksi_nama"
        },
        {
          "render": function(data, type, full, meta) {

            var status = '';
            var warna = '';
            if (full.transaksi_status == 'n') {
              status = 'Pengajuan';
              warna = '#FFD700';
            } else if (full.transaksi_status == 'y') {
              status = 'Approved';
              warna = '#87CEFA';
            }
            return '<span class="badge" style="background-color: ' + warna + '">' + status + '</span>';
          }
        },
      ]
    });
    /* Isi Table */

    /* Isi Table */
    $('#table_aset').DataTable({
      "ajax": {
        "url": "<?= base_url('master/aset/getAset?tahun=') . date('Y') ?>",
        "dataSrc": ""
      },
      "columns": [{
          render: function(data, type, full, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        {
          "data": "aset_nomor_utama"
        },
        {
          render: function(data, type, full, meta) {
            return full.aset_tahun_perolehan.split("-").reverse().join("-");
          }
        },
        {
          "data": "aset_nama"
        },
        {
          "data": "aset_nilai_perolehan",
          render: $.fn.dataTable.render.number('.', ',', 2, 'Rp. ')
        },
        {
          "data": "aset_penyusutan_thn_lalu",
          render: $.fn.dataTable.render.number('.', ',', 2, 'Rp. ')
        },
        {
          "data": "aset_penyusutan_thn_ini",
          render: $.fn.dataTable.render.number('.', ',', 2, 'Rp. ')
        },
        {
          "data": "aset_total_penyusutan",
          render: $.fn.dataTable.render.number('.', ',', 2, 'Rp. ')
        },
        {
          "data": "aset_nilai_buku",
          render: $.fn.dataTable.render.number('.', ',', 2, 'Rp. ')
        },
        {
          "data": "aset_jumlah"
        },
      ]
    });
    /* Isi Table */

    /* Isi Table */
    $('#table_perbaikan').DataTable({
      "order": [
        [0, "desc"]
      ],
      "ajax": {
        "url": "<?= base_url() ?>/material/antrian_perbaikan/getAntrianPerbaikan?tahun=<?= date('Y') ?>",
        "dataSrc": ""
      },
      "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
        if (aData['aset_perbaikan_status'] == "y") {
          $('td', nRow).css('background-color', '#03fc07  ');
        } else if (aData['aset_perbaikan_status'] == "n")
          $('td', nRow).css('background-color', '#ff2a00');
      },
      "columns": [{
          "data": "tanggal_penyerahan"
        },
        {
          "data": "tanggal_selesai"
        },
        {
          "data": "aset_nomor"
        },
        {
          "data": "aset_nama"
        },
        {
          "data": "sample_pekerjaan_nama"
        },
        {
          "data": "aset_perbaikan_note"
        },
        {
          "data": "perbaikan_status"
        },
      ]
    });
    /* Isi Table */

    fun_grafik('<?= date('Y') ?>');
  });

  function getRandomColor() {
    var letters = '0123456789ABCDEF';
    var color = '#';
    for (var i = 0; i < 6; i++) {
      color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
  }

  function fun_grafik(tahun) {
    $.getJSON('<?= base_url('dashboard/stok/getMaterial?tahun=') ?>' + tahun, function(json) {
      $('#total_material_request').html(json.length)
    });
    $.getJSON('<?= base_url('master/aset/getAset?tahun=') ?>' + tahun, function(json) {
      $('#total_aset').html(json.length)
    });
    $.getJSON('<?= base_url('material/antrian_perbaikan/getAntrianPerbaikan?tahun=') ?>' + tahun, function(json) {
      $('#total_perbaikan').html(json.length)
    });
    $.getJSON('<?= base_url('dashboard/stok/getRequest?tahun=') ?>' + tahun, function(json) {
      $('#total_transaksi').html(json.length)
    });

    $('#table_item').DataTable().ajax.url('<?= base_url() ?>dashboard/stok/getItem?tahun=' + tahun).load();
    $('#table_perbaikan').DataTable().ajax.url('<?= base_url() ?>/material/antrian_perbaikan/getAntrianPerbaikan?tahun=' + tahun).load();
    $('#table_material_transaksi').DataTable().ajax.url('<?= base_url() ?>dashboard/stok/getRequest?tahun=' + tahun).load();
    $('#table_material_request').DataTable().ajax.url('<?= base_url() ?>dashboard/stok/getMaterial?tahun=' + tahun).load();
    $('#table_aset').DataTable().ajax.url('<?= base_url() ?>master/aset/getAset?tahun=' + tahun).load();

    $.ajax({
      url: "<?= base_url() ?>dashboard/stok/getTransaksi?tahun=" + tahun,
      method: "GET",
      async: true,
      dataType: 'json',
      success: function(isi) {
        var isi_chart = [];
        var bulan = [];

        $.each(isi.bulan, function(index, val) {
          bulan.push(val);
        });

        $.each(isi.isi, function(index, val) {
          var warna = getRandomColor();
          var data = [];
          $.each(val.total, function(i, v) {
            data.push(v);
          });

          isi_chart.push({
            label: [val.isi],
            data: data,
            backgroundColor: [warna],
            borderColor: [warna],
            borderWidth: 2
          });
        });

        $('#chartTransaksi').remove();
        $('#div_chartTransaksi').append('<canvas id="chartTransaksi" style="width: 100%;"></canvas>');
        var ctx = document.getElementById('chartTransaksi').getContext('2d');
        var myChart = new Chart(ctx, {
          type: 'line',
          data: {
            labels: bulan,
            datasets: isi_chart
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
      url: "<?= base_url() ?>dashboard/stok/getPerbaikan?tahun=" + tahun,
      method: "GET",
      async: true,
      dataType: 'json',
      success: function(isi) {
        var isi_chart = [];
        var bulan = [];

        $.each(isi.bulan, function(index, val) {
          bulan.push(val);
        });
        $.each(isi.isi, function(index, val) {
          var warna = getRandomColor(index);
          var data = [];
          $.each(val.total, function(i, v) {
            data.push(v);
          });

          isi_chart.push({
            label: [val.isi],
            data: data,
            backgroundColor: [warna],
            borderColor: [warna],
            borderWidth: 2
          });
        });

        $('#chartPerbaikan').remove();
        $('#div_chartPerbaikan').append('<canvas id="chartPerbaikan" style="width: 100%;"></canvas>');
        var ctx = document.getElementById('chartPerbaikan').getContext('2d');
        var myChart = new Chart(ctx, {
          type: 'line',
          data: {
            labels: bulan,
            datasets: isi_chart
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
      url: "<?= base_url() ?>dashboard/stok/getPenyerapan?tahun=" + tahun,
      method: "GET",
      async: true,
      dataType: 'json',
      success: function(isi) {
        var isi_chart = [];
        var bulan = [];

        $.each(isi.bulan, function(index, val) {
          bulan.push(val);
        });
        $.each(isi.isi, function(index, val) {
          var warna = getRandomColor();
          var data = [];
          $.each(val.total, function(i, v) {
            data.push(v);
          });

          isi_chart.push({
            label: [val.isi],
            data: data,
            backgroundColor: [warna],
            borderColor: [warna],
            borderWidth: 2
          });
        });

        $('#chartPenyerapan').remove();
        $('#div_chartPenyerapan').append('<canvas id="chartPenyerapan" style="width: 100%;"></canvas>');
        var ctx = document.getElementById('chartPenyerapan').getContext('2d');
        var myChart = new Chart(ctx, {
          type: 'bar',
          data: {
            labels: bulan,
            datasets: isi_chart
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
</script>