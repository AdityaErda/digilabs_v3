<script type="text/javascript">
  $(function() {
    /* Isi Table */
    $('#table').DataTable({
      "scrollX": true,
      "ajax": {
        "url": "<?= base_url() ?>/master/jenis_sample_uji/getImport?import_kode=<?= $this->input->get('import_kode') ?>",
        "dataSrc": ""
      },
      "columns": [{
          "data": "jenis_nama"
        },
        {
          "data": "jenis_kode"
        },
        {
          "data": "jenis_parameter"
        },
        {
          "data": "pengambil_sample"
        },
      ]
    });
    /* Isi Table */
  });
</script>