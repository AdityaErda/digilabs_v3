<script type="text/javascript">
  $(function() {
    // tanggal range
    $('#tanggal_cari').daterangepicker({
      locale: {
        format: 'DD-MM-YYYY'
      }
    })
    // tanggal range
    /* Isi Table */
    $('#table').DataTable({
      "scrollX": true,
      "lengthMenu": [
        [5, 10, 25, 50, -1],
        [5, 10, 25, 50, "All"]
      ],
      "dom": 'lBfrtip',
      "buttons": ["csv", "pdf", "excel", "copy", "print"],
      "ajax": {
        "url": "<?= base_url('material/notifikasi/getLimitMaterial') ?>",
        "dataSrc": ""
      },
      "columns": [{
          "data": "item_nama"
        },{
          render: function(data, type, full, meta) {
            return (full.batch_file_judul == null) ? '-' : full.batch_file_judul;
          }
        },
        {
          "data": "item_satuan"
        },
        {
          "data": "item_stok"
        },
        {
          "data": "item_stok_alert"
        },
        {
          render: function(data, type, full, meta) {
            var d = new Date();
            var tgl = d.getFullYear() + '-' + d.getMonth() + '-' + d.getDate();
            var text = '';
            if (parseInt(full.item_stok) <= parseInt(full.item_stok_alert)) {
              text = 'Stok Menipis';
            }
            if (full.batch_file_tgl_expired <= '<?= date('Y-m-d') ?>') {
              text = text+' & Dokumen Expired';
            }
            return text;
          }
        },
      ]
    });
    /* Isi Table */

    // filter
    $('#filter').on('submit', function(e) {
      e.preventDefault();
      $('#table').DataTable().ajax.url('<?= base_url('material/notifikasi/getLimitMaterial?') ?>' + $('#filter').serialize()).load();
    })

    // filter

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
  });
</script>