<script type="text/javascript">
  $(function() {
    // tanggal filter
    $(".tanggal").daterangepicker({
      locale: {
        format: 'DD-MM-YYYY'
      }
    });
    // tanggal filter
    /* Isi Table */
    $('#table').DataTable({
      "lengthMenu": [
        [5, 10, 25, 50, -1],
        [5, 10, 25, 50, "All"]
      ],
      "dom": 'lBfrtip',
      "buttons": ["csv", "pdf", "excel", "copy", "print"],
      "scrollX": true,
      "ordering": false,
      "ajax": {
        "url": "<?= base_url('/material/Transaksi_in/getTransaksiIn?is_batal=n&tanggal_cari_awal=' . date('Y-m-d') . '&tanggal_cari_akhir=' . date('Y-m-d')) ?>",

        // "url": "<?= base_url('/material/Transaksi_in/getTransaksiIn?is_batal=n&tanggal_cari_awal=') ?>" + $('#tanggal_cari_awal').val()+"&tanggal_cari_akhir="+$('#tanggal_cari_akhir').val(),
        "dataSrc": ""
      },
      "columns": [{
          render: function(data, type, full, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        {
          "data": "transaksi_waktu"
        },
        {
          "data": "transaksi_jam"
        },
        {
          "data": "list_batch_kode_final"
        },
        {
          "render": function(data, type, full, meta) {
            return '<center><a href="javascript:;" id="' + full.transaksi_id + '" title="Detail" onclick="fun_batal(this.id)"><i class="fas fa-times" data-toggle="modal" data-target="#modal_aksi_batal" style="color:red"></i></a></center>';
          }
        },
        {
          "render": function(data, type, full, meta) {
            return '<center><a href="javascript:;" id="' + full.transaksi_id + '" title="Detail" onclick="fun_detail(this.id)"><i class="fa fa-search" data-toggle="modal" data-target="#modal_aksi_detail"></i></a></center>';
          }
        },
      ]
    });
    /* Isi Table */
    /* Isi Table */
    $('#table1').DataTable({
      "lengthMenu": [
        [5, 10, 25, 50, -1],
        [5, 10, 25, 50, "All"]
      ],
      "dom": 'lBfrtip',
      "buttons": ["csv", "pdf", "excel", "copy", "print"],
      // "scrollX": true,
      "ajax": {
        "url": "<?= base_url() ?>/material/request/getRequestDetail",
        "dataSrc": ""
      },
      "columns": [{
          render: function(data, type, full, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        {
          "data": "item_nama"
        },
        {
          "data": "item_satuan"
        },
        {
          "data": "transaksi_detail_jumlah"
        },
        {
          "render": function(data, type, full, meta) {
            return '<center><a href="javascript:;" id="' + full.item_id + '" title="Detail" onclick="fun_qrcode(this.id)"><i class="fa fa-qrcode" style="color:black"></i></a></center>';
          }
        },

      ]
    }).columns.adjust();
    /* Isi Table */

    $('.datetimepicker').datetimepicker({
      format: 'YYYY-MM-DD'
    })

    // filter start
    $("#filter").on("submit", function(e) {
      e.preventDefault();
      $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
        if (!json.user_id) {
          fun_notifLogout();
        } else {
          fun_loading();
          $('#table').DataTable().ajax.url('<?= base_url() ?>material/Transaksi_in/getTransaksiIn?is_batal=n&' + $('#filter').serialize()).load();
        }
      });
    });
    // filter end

    /* Select2 */
    $('.select2').select2({
      placeholder: 'Pilih',
    });

    $('.select2-selection').css('height', '37px');
    $('.select2').css('width', '100%');
    /* Select2 */
  });

  function fun_tanggal() {
    var today = new Date();
    var hari = today.getDate();
    var bulan = today.getMonth() + 1;
    var tahun = today.getFullYear();
    var tanggal = hari + "-" + bulan + "-" + tahun;
    $('#tanggal').val(tanggal);
  }

  function fun_waktu() {
    var today = new Date();
    var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
    $('#waktu').val(time);
  }


  function fun_tambah() {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        fun_loading();
        id = $('#transaksi_id').val(Date.now());

        setTimeout(function() {
          $('#dg').edatagrid({
            url: '<?= base_url('/material/request/getEasyuiMaterial?transaksi_id=') ?>' + $('#transaksi_id').val(),
            saveUrl: '<?= base_url('/material/request/insertEasyuiMaterial') ?>',
            updateUrl: '<?= base_url('/material/request/editEasyuiMaterial') ?>',
          });
        }, 500);
      }
    });
  }

  function fun_detail(isi) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        fun_loading()
        $('#div_detail').css('display', 'block');
        $('#table1').DataTable().ajax.url('<?= base_url() ?>material/request/getRequestDetail?transaksi_id=' + isi).load();
        // $('html, body').animate({
        // scrollTop: $("#div_detail").offset().top
        // }, 10);
      }
    });
  }

  function fun_batal(isi) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $.getJSON('<?php echo base_url() ?>material/Transaksi_in/getTransaksiIn', {
          transaksi_id: isi
        }, function(json) {
          $('#id_transaksi_batal').val(json.transaksi_id);
        })
      }
    });
  }
  // batal

  // QR CODE
  function fun_qrcode(id) {
    window.open('<?= base_url('material/Transaksi_in/printQrcode?item_id=') ?>' + id, '_blank')
  }
  // QR CODE

  $("#form_modal_batal").on('submit', function(e) {
    e.preventDefault();
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $.ajax({
          url: '<?= base_url('material/transaksi_in/batalTransaksiIn') ?>',
          data: $('#form_modal_batal').serialize(),
          dataType: 'HTML',
          type: 'POST',
          beforeSend: function() {
            $('#loading_form_batal').show();
            $('#batal').hide();
          },
          complete: function() {
            $('#loading_form_batal').hide();
            $('#batal').show();
          },
          success: function() {
            $('#form_modal_batal')[0].reset();
            $('#close_batal').click();
            $('#table').DataTable().ajax.reload(null, false);
            fun_loading();
            toastr.success('Berhasil');
          }
        })
      }
    });
  })

  // Start Simpan
  $('#simpan').on('click', function(e) {
    e.preventDefault();
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $.ajax({
          url: '<?= base_url('material/Transaksi_in/InsertTransaksiIn') ?>',
          data: $('#form_modal').serialize(),
          type: 'POST',
          dataType: 'html',
          beforeSend: function() {
            $('#loading_form').show();
            $('#simpan').hide();
            $('#edit').hide();
          },
          complete: function() {
            $('#loading_form').hide();
          },
          success: function(isi) {
            $('#form_modal')[0].reset();
            $('#table').DataTable().ajax.reload(null, false);
            $('#close').click();
            fun_loading();
            toastr.success('Berhasil');
          }
        })
      }
    });
  })
  // End Simpan

  // EASY UI
  // tambah
  function fun_tambah_ti() {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        fun_loading();
        var id = $('#transaksi_id').val();
        $('#dg').edatagrid('addRow', {
          index: 0,
          row: {
            transaksi_id: id
          }
        });
      }
    });
  }
  // tambah

  // simpan
  function fun_simpan_ti() {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        fun_loading()
        $('#dg').edatagrid('saveRow');
        setTimeout(() => {
          $('#dg').datagrid('reload')
        }, 1000);
        // setTimeout($('#dg').datagrid('reload'), 1000);
      }
    });
  }
  // simpan

  // hapus
  function fun_hapus_ti() {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        fun_loading()
        var row = $('#dg').datagrid('getSelected');
        $.post('<?= base_url() ?>material/request/deleteEasyuiMaterial', {
          transaksi_detail_id: row.transaksi_detail_id
        }, function(data, textStatus, xhr) {
          $('#dg').datagrid('reload');
        });
      }
    });
  }
  // hapus

  // reload dg
  function fun_reload_ti() {
    fun_loading()
    setTimeout(() => {
      $('#dg').datagrid('reload')
    }, 1000);
  }

  // reload dg


  // EASY UI

  /* Fun Close */
  function fun_close() {
    $('#simpan').css('display', 'block');
    $('#edit').css('display', 'none');
    $('#transaksi_id').empty();
    $('#form_modal')[0].reset();
    $('#table').DataTable().ajax.reload(null, false);
  }
  /* Fun Close */

  /* Fun Loading */
  function fun_loading() {
    var simplebar = new Nanobar();
    simplebar.go(100);
  }
  /* Fun Loading */

  $('#modal').on('hidden.bs.modal', function(e) {
    fun_close();
  });
</script>