<script type="text/javascript">
	$(function () {
    /* Isi Table */	
      $('#table').DataTable({
        "scrollX": true,
        "ajax": {
            "url": "<?= base_url() ?>/master/jenis_pekerjaan/getImport?import_kode=<?= $this->input->get('import_kode') ?>",
            "dataSrc": ""
          },
          "columns": [
            {"data": "sample_pekerjaan_kode"},
            {"data": "sample_pekerjaan_nama"},
          ]
      });
    /* Isi Table */
	});
</script>