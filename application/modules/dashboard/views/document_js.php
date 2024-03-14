<script>
  $(function () {
    <?php foreach ($jenis as $key => $value): ?>
      var jenis_id = '<?= $value->jenis_id ?>';
      $.getJSON('<?= base_url('dashboard/document/getDocumentJenis').'?jenis_id=' ?>'+jenis_id, function(json) {$('#jenis_id_<?= $value->jenis_id ?>').html(json.total)});
    <?php endforeach ?>

    <?php foreach ($seksi as $key => $value): ?>
      var seksi_id = '<?= $value->seksi_id ?>';
      $.getJSON('<?= base_url('dashboard/document/getDocumentSeksi').'?seksi_id=' ?>'+seksi_id, function(json) {$('#seksi_id_<?= $value->seksi_id ?>').html(json.total)});
    <?php endforeach ?>

    $.ajax({
      url: "<?= base_url() ?>dashboard/document/getDocumentJenisSum",
      method: "GET",
      async: true,
      dataType: 'json',
      success: function(isi) {
        var label = [];
        var value = [];

        $.each(isi, function(index, val) {
          label.push(val.jenis_nama);
          value.push(val.total);
        });

        $('#chartJenis').remove();
        $('#div_chartJenis').append('<canvas id="chartJenis" style="width: 100%;"></canvas>');
        var ctx = document.getElementById('chartJenis').getContext('2d');
        var myChart = new Chart(ctx, {
          type: 'doughnut',
          data: {
            labels: label,
            datasets: [{
              label: 'Document',
              data: value,
              backgroundColor: ['red', 'orange', 'cyan', 'green', 'blue','gray'],
            }]
          }
        });
      }
    });

    $.ajax({
      url: "<?= base_url() ?>dashboard/document/getDocumentSeksiSum",
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
              label: 'Document',
              data: value,
              backgroundColor: ['purple', 'orange', 'green', 'blue', 'yellow', 'pink'],
            }]
          }
        });
      }
    });

    /* Isi Table */ 
      $('#table_document').DataTable({
        "scrollX": true,
        "ordering": false,
        "ajax": {
            "url": "<?= base_url() ?>dashboard/document/getDocument",
            "dataSrc": ""
          },
          "columns": [
            {"data" : "jenis_nama"},
            {"data" : "revisi"},
            {"data" : "terbitan"},
            {"render": function ( data, type, full, meta ) {
              return '-';
            }},
          ]
      });
    /* Isi Table */ 

    $.ajax({
      url: "<?= base_url() ?>dashboard/document/getDocumentHasil",
      method: "GET",
      async: true,
      dataType: 'json',
      success: function(isi) {
        var revisi = [];
        var terbit = [];

        // $.each(isi, function(index, val) {
          revisi.push(isi.revisi);
          terbit.push(isi.terbit);
        // });

        $('#chartDocument').remove();
        $('#div_chartDocument').append('<canvas id="chartDocument" style="width: 100%;"></canvas>');
        var ctx = document.getElementById('chartDocument').getContext('2d');
        var myChart = new Chart(ctx, {
          type: 'bar',
          data: {
            labels: ['Document'],
            datasets: [{
              label: 'Revisi',
              data: revisi,
              backgroundColor: ['rgba(255, 99, 132, 0.2)'],
              borderColor: ['rgba(255, 99, 132, 1)'],
              borderWidth: 1
            },{
              label: 'Terbit Baru',
              data: terbit,
              backgroundColor: ['rgba(54, 162, 235, 0.2)'],
              borderColor: ['rgba(54, 162, 235, 1)'],
              borderWidth: 1
            },{
              label: 'Unduhan',
              data: [0],
              backgroundColor: ['rgba(100, 200, 10, 0.2)'],
              borderColor: ['rgba(100, 200, 10, 1)'],
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
  });
</script>