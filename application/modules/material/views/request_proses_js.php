<script type="text/javascript">
  $(function() {
    fun_loading();

    $('#dg_material').edatagrid({
      url: '<?= base_url('/material/request/getEasyuiMaterial?transaksi_id=') . $_GET['transaksi_id'] ?>',
      saveUrl: '<?= base_url('/material/request/insertEasyuiMaterial') ?>',
      updateUrl: '<?= base_url('/material/request/editEasyuiMaterial') ?>',
    });

    if ("<?= $_GET['aksi'] ?>" == "1") {
      $.getJSON('<?= base_url('material/request/getSeksiPeminta') ?>', function(json) {
        $('#seksi_id_peminta').val(json.seksi_id);
        $('#seksi_nama_peminta').val(json.seksi_nama);
      });

      $.getJSON('<?= base_url('material/request/getUserPeminta') ?>', function(json) {
        $('#user_id_peminta').val(json.user_id);
        $('#user_nama_peminta').val(json.user_nama_lengkap);
      })
    } else {
      $.getJSON('<?= base_url('material/request/getRequest') ?>', {
        transaksi_id: '<?= $_GET['transaksi_id'] ?>'
      }, function(json) {
        $('#tanggal').val(json.transaksi_waktu);
        $('#waktu').val(json.transaksi_jam);
        $('#seksi_id_peminta').val(json.seksi_id);
        $('#seksi_nama_peminta').val(json.seksi_nama);
        $('#user_id_peminta').val(json.user_id);
        $('#user_nama_peminta').val(json.user_nama_lengkap);
        $('#transaksi_status').val(json.transaksi_status);
      });
    }
  });

  /* Fun Tambah */
  function fun_tambah_request() {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        var id = $('#transaksi_id').val();
        $('#dg_material').edatagrid('addRow', {
          index: 0,
          row: {
            transaksi_id: id,
            transaksi_detail_jumlah: 1
          },
        });
      }
    })
  }
  /* Fun Tambah */

  /* Fun Simpan */
  function fun_simpan_request() {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        fun_loading();
        $('#dg_material').edatagrid('saveRow');
        setTimeout(() => {
          $('#dg_material').datagrid('reload')
        }, 1000);
      }
    })
  }
  /* Fun Simpan */

  /* Fun Hapus */
  function fun_hapus_request() {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        fun_loading();
        var row = $('#dg_material').datagrid('getSelected');
        $.post('<?= base_url() ?>material/request/deleteEasyuiMaterial', {
          transaksi_detail_id: row.transaksi_detail_id
        }, function(data, textStatus, xhr) {
          $('#dg_material').datagrid('reload');
        });
      }
    })
  }
  /* Fun Hapus */

  /* Fun Reload */
  function fun_reload_request() {
    setTimeout(() => {
      $('#dg_material').datagrid('reload')
    }, 1000);
  }
  /* Fun Reload */

  /* Proses Qr-Code */
  $("#form_qrcode").on("submit", function(e) {
    e.preventDefault();

    $.ajax({
      url: "<?= base_url('material/request/prosesQrcode') ?>",
      data: $('#form_qrcode').serialize(),
      type: 'POST',
      dataType: 'html',
      success: function(isi) {
        fun_reload_request();
        $('#temp_item_id').val('');
      }
    });
  });
  /* Proses Qr-Code */

  /* Proses Simpan */
  $('#simpan').on('click', function(e) {
    e.preventDefault();
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        fun_simpan_request();
        $.ajax({
          url: '<?= base_url() ?>material/request/insertTransaksi',
          data: $('#form_proses').serialize(),
          type: 'POST',
          dataType: 'html',
          success: function(isi) {
            window.location.href = "<?= base_url('material/request') ?>?header_menu=<?= $_GET['header_menu'] ?>&menu_id=<?= $_GET['menu_id'] ?>";
          }
        })
      }
    })
  })
  /* Proses Simpan */

  /* Proses Edit */
  $('#edit').on('click', function(e) {
    e.preventDefault();
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        fun_simpan_request();
        $.ajax({
          url: '<?= base_url() ?>material/request/updateTransaksi',
          data: $('#form_proses').serialize(),
          type: 'POST',
          dataType: 'html',
          success: function(isi) {
            window.location.href = "<?= base_url('material/request') ?>?header_menu=<?= $_GET['header_menu'] ?>&menu_id=<?= $_GET['menu_id'] ?>";
          }
        })
      }
    })
  })
  /* Proses Edit */

  /* Proses Approve */
  $('#approve').on('click', function(e) {
    e.preventDefault();
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        fun_simpan_request();
        $.ajax({
          url: '<?= base_url() ?>material/request/approveTransaksi',
          data: $('#form_proses').serialize(),
          type: 'POST',
          dataType: 'html',
          success: function(isi) {
            window.location.href = "<?= base_url('material/request') ?>?header_menu=<?= $_GET['header_menu'] ?>&menu_id=<?= $_GET['menu_id'] ?>";
          }
        })
      }
    })
  })
  /* Proses Approve */

  /* Fun Loading */
  function fun_loading() {
    var simplebar = new Nanobar();
    simplebar.go(100);
  }
  /* Fun Loading */
</script>