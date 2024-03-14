<script type="text/javascript">
	$(function () {
    /* Isi Table */	
      $('#table').DataTable({
        "scrollX": true,
        "ajax": {
            "url": "<?= base_url() ?>/master/barang_material/getImport?import_kode=<?= $this->input->get('import_kode') ?>",
            "dataSrc": ""
          },
          "columns": [
            {"data": "item_kode"},
            {"data": "item_nama"},
            {"data": "item_katalog_number"},
            {"data" : "item_merk"},
            {"data" : "jenis_nama"},
            {"data" : "gl_account_nama"},
            {"data" : "item_harga"},
            {"data" : "item_satuan"},
            {"data" : "item_stok"},
            {"data" : "item_stok_alert"},
          ]
      });
    /* Isi Table */
	});
</script>