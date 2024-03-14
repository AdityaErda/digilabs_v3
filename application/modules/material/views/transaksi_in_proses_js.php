<script type="text/javascript">
  $(function() {
    fun_loading();

    $('#dg').edatagrid({
      url: '<?= base_url('/material/request/getEasyuiMaterial?transaksi_id=').$_GET['transaksi_id'] ?>',
      saveUrl: '<?= base_url('/material/request/insertEasyuiMaterial') ?>',
      updateUrl: '<?= base_url('/material/request/editEasyuiMaterial') ?>',
    });
  })

  /* Simpan */
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
            success: function(isi) {
              fun_loading();
              toastr.success('Berhasil');
              window.location.href = "<?= base_url('material/Transaksi_in') ?>?header_menu=<?= $_GET['header_menu'] ?>&menu_id=<?= $_GET['menu_id'] ?>";
            }
          })
        }
      });
    })
  /* Simpan */

  /* EASY UI */
    /* Tambah */
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
    /* Tambah */

    /* Simpan */
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
    /* Simpan */

    /* Hapus */
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
    /* Hapus */

    /* Reload */
        function fun_reload_ti() {
          fun_loading()
          setTimeout(() => {
            $('#dg').datagrid('reload')
          }, 1000);
        }
    /* Reload */
  /* EASY UI */

  /* Fun Loading */
    function fun_loading() {
      var simplebar = new Nanobar();
      simplebar.go(100);
    }
  /* Fun Loading */
</script>