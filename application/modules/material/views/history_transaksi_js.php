<script type="text/javascript">
	$(function () {
    /* Isi Table */	
      $('#table').DataTable({
        "scrollX": true,
        "ajax": {
            "url": "<?= base_url() ?>/material/request/getRequest",
            "dataSrc": ""
          },
          "columns": [
            {"render": function ( data, type, full, meta ) {
              return '23-07-2021';
              }
            },
            {"render": function ( data, type, full, meta ) {
              return 'Lab 3';
              }
            },
            {"render": function ( data, type, full, meta ) {
              return 'Ammonia';
              }
            },
            {"render": function ( data, type, full, meta ) {
              return '12';
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
	});
</script>