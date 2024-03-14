<script type="text/javascript">
	$(function () {
    /* Isi Table */	
      $('#table').DataTable({
        "scrollX": true,
        "ajax": {
            "url": "<?= base_url() ?>/master/aset/getImport?import_kode=<?= $this->input->get('import_kode') ?>",
            "dataSrc": ""
          },
          "columns": [
            {"data": "aset_serial"},
            {"data": "aset_nama"},
            {"data": "aset_umur"},
            {"data": "aset_tahun_perolehan"},
            {"data" : "aset_nilai_perolehan", render: $.fn.dataTable.render.number( '.', ',', 2, 'Rp. ')},
            {"data" : "aset_penyusutan_thn_lalu", render: $.fn.dataTable.render.number( '.', ',', 2, 'Rp. ')},
            {"data" : "aset_penyusutan_thn_ini", render: $.fn.dataTable.render.number( '.', ',', 2, 'Rp. ')},
            {"data" : "aset_total_penyusutan", render: $.fn.dataTable.render.number( '.', ',', 2, 'Rp. ')},
            {"data" : "aset_nilai_buku", render: $.fn.dataTable.render.number( '.', ',', 2, 'Rp. ')},
            {"data": "is_aset"},
          ]
      });
    /* Isi Table */
	});
</script>