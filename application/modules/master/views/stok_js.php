<script type="text/javascript">
	$(function () {
    /* Isi Table */	
      $('#table').DataTable({
        "scrollX": true,
        "ajax": {
            "url": "<?= base_url() ?>/sample/request/getRequest",
            "dataSrc": ""
          },
          "columns": [
            {"render": function ( data, type, full, meta ) {
              return '0001';
              }
            },
            {"render": function ( data, type, full, meta ) {
              return 'Barang 1';
              }
            },
            {"render": function ( data, type, full, meta ) {
              return 'Jenis A';
              }
            },
            {"render": function ( data, type, full, meta ) {
              return 'Kategori A';
              }
            },
            {"render": function ( data, type, full, meta ) {
              return 'Kimia';
              }
            },
            {"render": function ( data, type, full, meta ) {
              return '100';
              }
            },
            {"render": function ( data, type, full, meta ) {
              return '<center><a href="javascript:;" id="'+full.request_id+'" title="Edit" onclick="fun_edit(this.id)"><i class="fa fa-edit" data-toggle="modal" data-target="#modal"></i></a></center>';
              }
            },
            {"render": function ( data, type, full, meta ) {
              return '<center><a href="javascript:;" id="'+full.request_id+'" title="Edit" onclick="fun_edit(this.id)"><i class="fa fa-trash" data-toggle="modal" data-target="#modal"></i></a></center>';
              }
            },
          ]
      });
    /* Isi Table */ 

    /* Tanggal */
      $(".tanggal").daterangepicker({
      showDropdowns: true,
      singleDatePicker: true,
      locale: {format: 'DD-MM-YYYY'}
    });
    /* Tanggal */

    /* Select2 */
      $('.select2').select2({
        placeholder: 'Pilih',
      });

      $('.select2-selection').css('height', '37px');
      $('.select2').css('width', '100%');
    /* Select2 */
	})
</script>