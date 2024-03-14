<script type="text/javascript">
	$(function () {
    /* Isi Table */	
      $('#table').DataTable({
        "scrollX": true,
        "ajax": {
            "url": "<?= base_url() ?>/master/user/getImport?import_kode=<?= $this->input->get('import_kode') ?>",
            "dataSrc": ""
          },
          "columns": [
            {"data": "user_nama_lengkap"},
            {"data": "user_tempat_lahir"},
            {"render": function ( data, type, full, meta ) {
              return full.user_tgl_lahir.split("-").reverse().join("-");;
              }
            },
            {"data" : "role_nama"},
            {"data" : "seksi_nama"},
            {"data" : "user_username"},
            {"data" : "user_password"},
          ]
      });
    /* Isi Table */
	});
</script>