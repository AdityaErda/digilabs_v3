<script type="text/javascript">
  $(function() {
    // tanggal range
    $('#tanggal_cari').daterangepicker({
      locale: {
        format: 'DD-MM-YYYY'
      },
    })
    // tanggal range
    /* Isi Table */
    $('#table').DataTable({
      "lengthMenu": [
        [5, 10, 25, 50, -1],
        [5, 10, 25, 50, "All"]
      ],
      "dom": 'lBfrtip',
      "buttons": ["csv", "pdf", "excel", "copy", "print"],
      "scrollX": true,
      "ajax": {
        "url": "<?= base_url('material/stok/getStok') ?>",
        "dataSrc": ""
      },
      "columns": [{
          "data": "item_nama"
        },
        {
          "data": "item_satuan"
        },
        {
          "data": "item_stok"
        },
        {
          "render": function(data, type, full, meta) {
            return '<center><a href="javascript:;" id="' + full.item_id + '" title="Detail" onclick="fun_detail(this.id)" ><i class="fa fa-search"></i></a></center>';
          }
        },
        {
          "render": function(data, type, full, meta) {
            return '<center><a href="javascript:;" id="' + full.item_id + '" title="Qr-Code Kecil" onclick="fun_qr(this.id)"  data-target="#modal_qr" data-toggle="modal"><i class="fa fa-qrcode"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:;" id="' + full.item_id + '" title="Qr-Code Besar" onclick="fun_qr_besar(this.id)"  data-target="#modal_qr_besar" data-toggle="modal"><i class="fa fa-qrcode" style="color: red;"></i></a></center>';
          }
        },
        // {
        //   "render": function(data, type, full, meta) {
        //     return '<center><a href="<?= base_url('material/stok/printQrcode/?item_id=') ?>' + full.item_id + '" target="_BLANK" title="Qrcode" "><i class="fa fa-qrcode" style="color: black;"></i></a></center>';
        //   }
        // }
      ]
    });
    /* Isi Table */
    /* Isi Table */
    $('#table1').DataTable({
      "scrollX": true,
      "lengthMenu": [
        [5, 10, 25, 50, -1],
        [5, 10, 25, 50, "All"]
      ],
      "dom": 'lBfrtip',
      "buttons": [{
          extend: "csv",
          title: "Detail Material Stok"
        },
        {
          extend: "pdf",
          title: "Detail Material Stok"
        },
        {
          extend: "excel",
          title: "Detail Material Stok"
        },
        "copy",
        {
          extend: "print",
          title: "Detail Material Stok  "
        }
      ],
      // autoWidth:true,
      "ajax": {
        "url": "<?= base_url('material/stok/getStokDetail') ?>",
        "dataSrc": ""
      },
      "columns": [{
          "data": "list_stok_waktu"
        },
        {
          "data": "list_stok_jam"
        },
        {
          "data": "jenis_kegiatan"
        },
        {
          "data": "item_nama"
        },
        {
          "data": "item_satuan"
        },
        {
          "data": "list_stok_jumlah"
        },
        {
          "data": "list_stok_stok"
        },
        {
          "data": "keterangan"
        },
        // {
        //   "render": function(data, type, full, meta) {
        //     if (full.list_stok_tipe == 'i') {
        //       return '<center><a href="javascript:;" id="' + full.list_batch_id + '" onclick="func_stok_document(this.id)" data-target="#modal_stok_document" data-toggle="modal" ><i class="fa fa-search"></i></a></center>';
        //     } else {
        //       return '';
        //     }
        //   }
        // },
      ]
    });
    /* Isi Table */
    $('#table_stok_document').DataTable({
      "lengthMenu": [
        [5, 10, 25, 50, -1],
        [5, 10, 25, 50, "All"]
      ],
      "dom": 'lBfrtip',
      "buttons": ["csv", "pdf", "excel", "copy", "print"],
      // "scrollX": true,
      "ajax": {
        "url": "<?= base_url('material/update_document/getDocumentDetail') ?>",
        "dataSrc": ""
      },
      "columns": [{
          "data": "batch_file_tgl_terbit"
        },
        {
          "data": "batch_file_tgl_expired"
        },
        {
          "data": "batch_file_judul"
        },
        {
          "data": "batch_file_isi"
        },
        {
          "render": function(data, type, full, meta) {
            if (full.batch_file_isi != null) {
              return '<center><a href="<?= base_url('./upload/') ?>' + full.batch_file_isi + '" target="_blank" id="' + full.batch_file_id + '" title="Edit"><i class="fa fa-download"></i></a></center>';
            } else {
              return '';
            }
          }
        },
      ]
    });
    /* Isi Table */
    // });
    /* Isi Table */



    /* Tanggal */
    $(".tanggal").daterangepicker({
      showDropdowns: true,
      singleDatePicker: true,
      locale: {
        format: 'DD-MM-YYYY'
      }
    });
    /* Tanggal */



    // filter
    $('#filter').on('submit', function(e) {
      e.preventDefault();
      $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
        if (!json.user_id) {
          fun_notifLogout();
        } else {
          fun_loading();
          $('#table').DataTable().ajax.url('<?= base_url('/material/stok/getStok?') ?>' + $('#filter').serialize()).load();
        }
      })
    });
    // filter

    $('#item_cari').select2({
      // minimumInputLength: 1,
      allowClear: true,
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url('material/bulanan/getItemReport') ?>',
        dataType: 'json',
        type: 'GET',
        data: function(params) {
          var queryParameters = {
            item_nama: params.term
          }
          return queryParameters;
        }
      }
    });

    $('.select2-selection').css('height', '37px');
    $('.select2').css('width', '100%');

    /* Select2 */
    // $('.select2').select2({
    //   placeholder: 'Pilih',
    // });

    // $('.select2-selection').css('height', '37px');
    // $('.select2').css('width', '100%');
    /* Select2 */
  });


  function fun_detail(isi) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        fun_loading();
        $('#temp_item_id').val(isi);
        $('#div_detail').css('display', 'block');
        $('#table1').DataTable().ajax.url('<?= base_url() ?>material/stok/getStokDetail?item_id=' + isi).load();
        $('html, body').animate({
          scrollTop: $("#div_detail").offset().top
        }, 10);

        $.ajax({
          url: "<?= base_url('material/stok/getStokDetail?item_id=') ?>" + isi,
          method: "GET",
          async: true,
          dataType: 'json',
          success: function(isi) {
            console.log(isi);
            var label = [];
            var value = []

            $.each(isi, function(index, val) {
              label.push(val.jenis_kegiatan);
              value.push(val.list_stok_jumlah);
            });

            $('#chartStok').remove();
            $('#div_chartStok').append('<canvas id="chartStok" style="width: 100%;"></canvas>');
            var ctx = document.getElementById('chartStok').getContext('2d');
            var chartStok = new Chart(ctx, {
              type: 'line',
              data: {
                labels: label,
                datasets: [{
                  label: 'Moving Stok',
                  data: value,
                  backgroundColor: ['rgba(255, 99, 132, 0.2)'],
                  borderColor: ['rgba(255, 99, 132, 1)'],
                  borderWidth: 1
                }]
              },
              options: {
                scales: {
                  y: {
                    beginAtZero: true
                  }
                }
              }
            });
          }
        });
      }
    })
  }

  function fun_qr(isi) {
    $('#id_qr').val(isi);
  }

  function fun_qr_besar(isi) {
    $('#id_qr_besar').val(isi);
  }

  function func_stok_document(id) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        fun_loading();
        $('#table_stok_document').DataTable().ajax.url('<?= base_url() ?>material/update_document/getDocumentDetailAll?id_item=' + id + '&tanggal_exp=<?= date('Y-m-d') ?>').load();
      }
    })
  }

  $('#proses').on('click', function(e) {
    e.preventDefault();

    window.open('<?= base_url('material/stok/printQrcode/?') ?>'+$('#form_modal_qr').serialize());
    $('#close_qr').click();
  })

  $('#proses_besar').on('click', function(e) {
    e.preventDefault();

    window.open('<?= base_url('material/stok/printQrcodeBesar/?') ?>'+$('#form_modal_qr_besar').serialize());
    $('#close_qr_besar').click();
  })

  /* Fun Close */
    $('#modal_qr').on('hidden.bs.modal', function(e) {
      fun_close_qr();
    });

    $('#modal_qr_besar').on('hidden.bs.modal', function(e) {
      fun_close_qr_besar();
    });

    function fun_close_qr() {
      $('#form_modal_qr')[0].reset();
      $('#table').DataTable().ajax.reload(null, false);
    }
  /* Fun Close */

  /* Fun Loading */
  function fun_loading() {
    var simplebar = new Nanobar();
    simplebar.go(100);
  }
  /* Fun Loading */
</script>