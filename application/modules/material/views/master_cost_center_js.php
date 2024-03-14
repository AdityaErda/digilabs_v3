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
              return 'Ammonia';
              }
            },
            {"render": function ( data, type, full, meta ) {
              return '10.000';
              }
            },
            {"render": function ( data, type, full, meta ) {
              return '<center><a href="javascript:;" id="'+full.request_id+'" title="Edit" onclick="fun_tambah(this.id)"><i class="fa fa-edit" data-toggle="modal" data-target="#modal"></i></a></center>';
              }
            },
          ]
      });
    /* Isi Table */
    /* Isi Table */ 
      $('#table1').DataTable({
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

  function fun_tambah() {
    setTimeout(function() {
      $('#dg').edatagrid({
        url: 'perbaikan/getEasyuiMaterial',
        saveUrl: 'perbaikan/insertEasyuiMaterial',
        updateUrl: 'perbaikan/editEasyuiMaterial',
      });
    }, 500);
  }

  function fun_detail(isi) {
    $('#div_detail').css('display', 'block');
  }
</script>