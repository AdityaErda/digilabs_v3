<script type="text/javascript">
	$(function () {
    /* Isi Table */	
      $('#table').DataTable({
        "scrollX": true,
        "ajax": {
            "url": "<?= base_url() ?>/master/aset/getImportDetail?import_kode=<?= $this->input->get('import_kode') ?>",
            "dataSrc": ""
          },
          "columns": [
            {"data": "aset_nomor_utama"},
            {render:function(data,type,full,meta){
                return (full.is_aset=='y') ? 'Aset' : 'Non Aset';
            }},
            {"data": "aset_nama"},
            {"data": "aset_detail_merk"},
            {"data" : "aset_nomor"},
            {"data" : "peminta_jasa_nama"},
            {render:function(data,type,full,meta){
                return (full.is_aktif=='y') ? 'Aktif' : 'Non Aktif';
            }},
          ]    
      });
    /* Isi Table */
	});
</script>