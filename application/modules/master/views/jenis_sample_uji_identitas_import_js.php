<script type="text/javascript">
	$(function () {
    /* Isi Table */	
      $('#table').DataTable({
        "scrollX": true,
        "ajax": {
            "url": "<?= base_url() ?>/master/jenis_sample_uji/getImportIdentitas?import_kode=<?= $this->input->get('import_kode') ?>",
            "dataSrc": ""
          },
          "columns": [
            {"data": "identitas_nama"},
            {"data": "jenis_nama"},
            {"data": "identitas_parameter"},
            {"data": "identitas_harga"},
          ]
      });
    /* Isi Table */
	});
</script>