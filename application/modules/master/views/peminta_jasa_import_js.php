<script type="text/javascript">
	$(function () {
    /* Isi Table */	
      $('#table').DataTable({
        "scrollX": true,
        "ajax": {
            "url": "<?= base_url() ?>/master/peminta_jasa/getImport?import_kode=<?= $this->input->get('import_kode') ?>",
            "dataSrc": ""
          },
          "columns": [
            {"data": "peminta_jasa_kode"},
            {"data": "peminta_jasa_nama"},
            {"data": "peminta_jasa_ext"},
          ]
      });
    /* Isi Table */
	});
</script>