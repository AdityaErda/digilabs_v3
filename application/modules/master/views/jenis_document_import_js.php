<script type="text/javascript">
	$(function () {
    /* Isi Table */	
      $('#table').DataTable({
        "scrollX": true,
        "ajax": {
            "url": "<?= base_url() ?>/master/jenis_document/getImport?import_kode=<?= $this->input->get('import_kode') ?>",
            "dataSrc": ""
          },
          "columns": [
            {"data": "jenis_nama"},
            {"data": "jenis_kode"},
          ]
      });
    /* Isi Table */
	});
</script>