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
        "url": "<?= base_url('/material/report_stok/getLaporanData?tanggal_cari_awal=') ?><?= date('Y-m-d') ?>&tanggal_cari_akhir=<?=date('Y-m-d')?>",
        "dataSrc": ""
      },
      "columns": [{
          "render": function(data, type, full, meta) {
            return '<center>' + full.jenis_nama + '</center>';
          }
        },
        {
          "data": "item_nama"
        },
        {
          "render": function(data, type, full, meta) {
            return '<center>' + full.item_satuan + '</center>';
          }
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
            return full.item_stok;
          }
        }
      ]

    });
    /* Isi Table */

    $('.datetimepicker').datetimepicker({
      // useCurrent: false,
      // locale: 'd',
      format: 'YYYY-MM-DD'
    })


    // pilih item
    $('#item_cari').select2({
      allowClear: true,
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url('material/report_stok/getItemReport') ?>',
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
        url: '<?= base_url('material/report_stok/getJenisBarang') ?>',
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
        $('#table').DataTable().ajax.url('<?= base_url() ?>material/report_stok/getLaporanData?' + $('#filter').serialize()).load();
      }
    })
  })

  function fun_cetak() {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        item = $('#item_id').val();
        window.open('<?= base_url() ?>material/report_stok/cetakLaporanBulanan?' + $('#filter').serialize(), '_blank');
      }
    })
  }
</script>