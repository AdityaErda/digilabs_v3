<script type="text/javascript">
  $(function() {
    /* Isi Table */
    $('#table').DataTable({
      "scrollX": true,
      "lengthMenu": [
        [5, 10, 25, 50, -1],
        [5, 10, 25, 50, "All"]
      ],
      "dom": 'lBfrtip',
      "buttons": ["csv", "pdf", "excel", "copy", "print"],
      "ordering": false,
      "ajax": {
        "url": "<?= base_url('/material/bulanan/getLaporanData?tanggal_cari=') ?><?= date('Y-m') ?>",
        "dataSrc": ""
      },
      "columns": [{
          "data": "jenis_nama"
        },
        {
          "data": "item_nama"
        },
        {
          "render": function(data, type, full, meta) {
            return (full.stok_masuk == null) ? '0' : full.stok_masuk;
          }
        },
        {
          "render": function(data, type, full, meta) {
            return (full.stok_keluar == null) ? '0' : full.stok_keluar;
          }
        },
        {
          "render": function(data, type, full, meta) {
            return (full.item_satuan);
          }
        },
        {
          "render": function(data, type, full, meta) {
            return full.item_stok;
          }
        }
      ]

    });
    /* Isi Table */


    // pilih item
    $('#item_cari').select2({
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

    $('#jenis_barang').select2({
      allowClear: true,
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url('material/bulanan/getJenisBarang') ?>',
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

    $('.select2-selection').css('height', '37px');
    $('.select2').css('width', '100%');
    // pilih item
  });


  $('#cari').on('click', function(e) { //button cari item
    e.preventDefault();
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $('#table').DataTable().ajax.url('<?= base_url() ?>material/bulanan/getLaporanData?' + $('#filter').serialize()).load();
      }
    })
  })

  function fun_cetak() {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        item = $('#item_id').val();
        window.open('<?= base_url() ?>material/bulanan/cetakLaporanBulanan?' + $('#filter').serialize(), '_blank');
      }
    })
  }
</script>