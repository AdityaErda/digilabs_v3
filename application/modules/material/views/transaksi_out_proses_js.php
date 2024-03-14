<script type="text/javascript">
  $(function() {
    fun_loading();
    fun_seksi();
    fun_userPeminta();

    $('#dg').edatagrid({
      url: '<?= base_url('material/request/getEasyuiMaterial?transaksi_id=') ?>' + $('#transaksi_id').val(),
      saveUrl: '<?= base_url('material/request/insertEasyuiMaterial') ?>',
      updateUrl: '<?= base_url('material/request/editEasyuiMaterial') ?>',
    });
  })

  /* EASY UI */
    /* Tambah */
  function fun_tambah_to() {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        fun_loading()
        var id = $('#transaksi_id').val();
        $('#dg').edatagrid('addRow', {
          index: 0,
          row: {
            transaksi_id: id
          }

        });
      }
    })
  }
    /* Tambah */

    /* Simpan */
  function fun_simpan_to() {
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
    })
  }
    /* Simpan */

    /* Hapus */
  function fun_hapus_to() {
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
    })
  }
    /* Hapus */

    /* Reload DG */
  function fun_reload_to() {
    fun_loading()
    setTimeout(() => {
      $('#dg').datagrid('reload')
    }, 1000);
  }
    /* Reload DG */
  /* EASY UI */

  /* Proses Qr-Code */
  $("#form_qrcode").on("submit", function(e) {
    e.preventDefault();

    $.ajax({
      url: "<?= base_url('material/request/prosesQrcode') ?>",
      data: $('#form_qrcode').serialize(),
      type: 'POST',
      dataType: 'html',
      success: function(isi) {
        fun_reload_to();
        $('#temp_item_id').val('');
      }
    });
  });
  /* Proses Qr-Code */

  /* Klik Simpan */
  $('#simpan').on('click', function(e) {
    e.preventDefault();
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        var data = $('#form_modal').serialize();
        $.ajax({
          url: '<?= base_url('material/Transaksi_out/cekStok') ?>',
          data: data,
          type: 'POST',
          dataType: 'HTML',
          success: function(isi) {
            if (isi != '') {
              toastr.error(isi);
            } else {
              e.preventDefault();
              $.ajax({
                url: '<?= base_url('material/Transaksi_out/insertTransaksiOut') ?>',
                data: $('#form_modal').serialize(),
                type: 'POST',
                dataType: 'html',
                success: function(isi) {
                  fun_loading();
                  toastr.success('Berhasil');
                    // window.location.href = "<?= base_url('material/Transaksi_out') ?>?header_menu=<?= $_GET['header_menu'] ?>&menu_id=<?= $_GET['menu_id'] ?>";
                }
              })
            }
          }
        })
      }
    })
  })
  /* Klik Simpan */

  /* Klik Approve */
  $('#aprove').on('click', function(e) {
    e.preventDefault();
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        var data = $('#form_modal').serialize();
        $.ajax({
          url: '<?= base_url('material/Transaksi_out/cekStok') ?>',
          data: data,
          type: 'POST',
          dataType: 'HTML',
          success: function(isi) {
            if (isi != '') {
              toastr.error(isi);
            } else {
              e.preventDefault();
              $.ajax({
                url: '<?= base_url('material/Transaksi_out/approveTransaksi') ?>',
                data: $('#form_modal').serialize(),
                type: 'POST',
                dataType: 'html',
                success: function(isi) {
                  fun_loading();
                  toastr.success('Berhasil');
                  window.location.href = "<?= base_url('material/Transaksi_out') ?>?header_menu=<?= $_GET['header_menu'] ?>&menu_id=<?= $_GET['menu_id'] ?>";
                }
              })
            }
          }
        })
      }
    })
  })
  /* Klik Approve */

  /* Klik Disiapkan */
  $('#disiapkan').on('click', function(e) {
    e.preventDefault();
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        var data = $('#form_modal').serialize();
        $.ajax({
          url: '<?= base_url('material/Transaksi_out/cekStok') ?>',
          data: data,
          type: 'POST',
          dataType: 'HTML',
          success: function(isi) {
            if (isi != '') {
              toastr.error(isi);
            } else {
              e.preventDefault();
              $.ajax({
                url: '<?= base_url('material/Transaksi_out/disiapkanTransaksi') ?>',
                data: $('#form_modal').serialize(),
                type: 'POST',
                dataType: 'html',
                success: function(isi) {
                  fun_loading();
                  toastr.success('Berhasil');
                  window.location.href = "<?= base_url('material/Transaksi_out') ?>?header_menu=<?= $_GET['header_menu'] ?>&menu_id=<?= $_GET['menu_id'] ?>";
                }
              })
            }
          }
        })
      }
    })
  })
  /* Klik Disiapkan */

  /* Klik Diambil */
  $('#diambil').on('click', function(e) {
    e.preventDefault();
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        var data = $('#form_modal').serialize();
        $.ajax({
          url: '<?= base_url('material/Transaksi_out/cekStok') ?>',
          data: data,
          type: 'POST',
          dataType: 'HTML',
          success: function(isi) {
            if (isi != '') {
              toastr.error(isi);
            } else {
              e.preventDefault();
              $.ajax({
                url: '<?= base_url('material/Transaksi_out/diambilTransaksi') ?>',
                data: $('#form_modal').serialize(),
                type: 'POST',
                dataType: 'html',
                success: function(isi) {
                  fun_loading();
                  toastr.success('Berhasil');
                  window.location.href = "<?= base_url('material/Transaksi_out') ?>?header_menu=<?= $_GET['header_menu'] ?>&menu_id=<?= $_GET['menu_id'] ?>";
                }
              })
            }
          }
        })
      }
    })
  })
  /* Klik Diambil */

  function fun_seksi() {
    $.getJSON('<?= base_url('material/request/getSeksiPeminta') ?>',
    {
      id_transaksi:'<?= $this->input->get('transaksi_id')?>',
      aksi:'<?=$this->input->get_post('aksi');?>'
    }
    , function(json) {
      $('#seksi_id_peminta').val(json.seksi_id);
      $('#seksi_nama_peminta').val(json.seksi_nama);
    })
  }

  function fun_userPeminta() {
    $.getJSON('<?= base_url('material/request/getUserPeminta') ?>',
    {
      id_transaksi:'<?= $this->input->get('transaksi_id')?>',
      aksi:'<?=$this->input->get_post('aksi');?>'
    }
    , function(json) {
      $('#user_id_peminta').val(json.user_id);
      $('#user_nama_peminta').val(json.user_nama_lengkap);
    })
  }

  function fun_loading() {
    var simplebar = new Nanobar();
    simplebar.go(100);
  }
</script>