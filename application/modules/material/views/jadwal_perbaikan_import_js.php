<script type="text/javascript">
	$(function () {
    /* Isi Table */	
      $('#table').DataTable({
        "scrollX": true,
        "ajax": {
            "url": "<?= base_url() ?>/material/jadwal_perbaikan/getImport?import_kode=<?= $this->input->get('import_kode') ?>",
            "dataSrc": ""
          },
          "columns": [
            {"data" : "aset_perbaikan_tgl_penyerahan"},
            {"data" : "aset_perbaikan_tgl_deadline"},
            {"data" : "aset_perbaikan_tgl_selesai"},
            {"data" : "aset_nomor_utama"},
            {"data" : "aset_nama"},
            {"data" : "aset_nomor"},
            {"data" : "peminta_jasa_nama"},
            // {"data" : "pekerjaan_id"},
            {"render": function ( data, type, full, meta ) {
                        var status = ''
                        if(full.pekerjaan_id=='p'){
                          status = 'Perbaikan';
                        }else if(full.pekerjaan_id=='k'){
                          status = 'Kalibrasi';
                        }
                        return status
            }},
            {"data" : "aset_perbaikan_note"},
            {"data" : "aset_perbaikan_vendor"},
            {"render":function(data,type,full,meta){
              var status = '';
              if(full.aset_perbaikan_status=='n'){
                status = 'Pengajuan';
              }else if(full.aset_perbaikan_status=='k'){
                status = 'Dikerjakan';
              }else if(full.aset_perbaikan_status=='p'){
                status = 'Pending';
              }else if(full.aset_perbaikan_status=='y'){
                status = 'Selesai';
              }else if(full.aset_perbaikan_status=='t'){
                status = 'Terjadwal';
              }
              return status;
            }},
          ]
      });
    /* Isi Table */
	});
</script>