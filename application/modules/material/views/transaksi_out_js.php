<script type="text/javascript">
  $(function() {
    // /start tanggal cari
    // $("#tanggal_cari").daterangepicker({
    //   locale: {format: 'DD-MM-YYYY'}
    // });
    // end tanggal cari
    /* Isi Table */
    $("#table").css({
      "width": "100%"
    });
    $('#table').DataTable({
      "scrollX": true,
      "ordering": false,
      "lengthMenu": [
        [5, 10, 25, 50, -1],
        [5, 10, 25, 50, "All"]
      ],
      "dom": 'lBfrtip',
      "buttons": ["csv", "pdf", "excel", "copy", "print"],
      "ajax": {
        "url": "<?= base_url() ?>/material/request/getTransaksiOut?transaksi_tipe=O&tanggal_cari=" + $('#tanggal_cari').val(),
        "dataSrc": ""
      },
      "columns": [{
          render: function(data, type, full, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        {
          "data": "transaksi_nomor"
        },
        {
          "data": "transaksi_waktu"
        },
        {
          "data": "transaksi_jam"
        },
        {
          "data": "seksi_nama"
        },
        {
          "data": "user_nama_lengkap"
        },
        {
          "render": function(data, type, full, meta) {
            var status = '';
            var warna = '';
            if (full.transaksi_status == 'n') {
              status = 'Menunggu Approve AVP Customer';
              warna = '#FFD700';
            } else if (full.transaksi_status == 'r') {
              status = 'Menunggu Approve AVP LUK';
              warna = '#87CEFA';
            } else if (full.transaksi_status == 'a') {
              status = 'Menunggu Proses Transaksi Out';
              warna = 'red';
            } else if (full.transaksi_status == 's') {
              status = 'Sedang Disiapkan';
              warna = 'pink';
            } else if (full.transaksi_status == 'd') {
              status = 'Bisa Diambil';
              warna = 'yellow';
            } else if (full.transaksi_status == 'y') {
              status = 'Finish';
              warna = '#32CD32';
            }
            return '<span class="badge" style="background-color: ' + warna + '">' + status + '</span>';
          }
        },
        {
          "render": function(data, type, full, meta) {
            return '<center><a href="javascript:;" id="' + full.transaksi_id + '" name="' + full.user_nama_lengkap + '" title="History" onclick="fun_history(this.id,this.name)"><i class="fa fa-history" data-toggle="modal" data-target="#modal_aksi_history" style="color:aqua"></i></a></center>';
          }
        },
        {
          "render": function(data, type, full, meta) {
            return '<center><a href="javascript:;" id="' + full.transaksi_id + '" title="Detail" onclick="fun_detail(this.id)"><i class="fa fa-search" data-toggle="modal" data-target="#modal_aksi_detail"></i></a></center>';

          }
        },
        {
          "render": function(data, type, full, meta) {
            return (full.transaksi_status == 'a' || full.transaksi_status == 's' || full.transaksi_status == 'd') ? '<center><a href="<?= base_url('material/transaksi_out/proses') ?>?header_menu=<?= $_GET['header_menu'] ?>&menu_id=<?= $_GET['menu_id'] ?>&transaksi_id=' + full.transaksi_id + '&aksi=1" id="' + full.transaksi_id + '" title="Approve" style="color:lawngreen"><i class="fa fa-share"></i></a></center>' : '';
          }
        },
      ]
    });
    /* Isi Table */
    /* Isi Table */
    $('#table1').DataTable({
      // "scrollX": true,
      "lengthMenu": [
        [5, 10, 25, 50, -1],
        [5, 10, 25, 50, "All"]
      ],
      "dom": 'lBfrtip',
      "buttons": ["csv", "pdf", "excel", "copy", "print"],
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

      ]
    });
    /* Isi Table */

    /* Isi Table History*/
    $('#table_history').DataTable({
      // "scrollX": true,
      "lengthMenu": [
        [5, 10, 25, 50, -1],
        [5, 10, 25, 50, "All"]
      ],
      "dom": 'lBfrtip',
      "buttons": ["csv", "pdf", "excel", "copy", "print"],
      "ajax": {
        "url": "<?= base_url() ?>/material/request/getRequestHistory",
        "dataSrc": ""
      },
      "columns": [{
          render: function(data, type, full, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        {
          "render": function(data, type, row, meta) {
            return row.transaksi_history_keterangan;
          }
        },
        {
          "render": function(type, data, row, meta) {
            if (row.transaksi_history_status == 'n') return 'Pengajuan';
            else if (row.transaksi_history_status == 'r') return 'Approve AVP Customer';
            else if (row.transaksi_history_status == 'a') return 'Approve AVP LUK';
            else if (row.transaksi_history_status == 's') return 'Sedang Disiapkan';
            else if (row.transaksi_history_status == 'd') return 'Bisa Diambil';
            else if (row.transaksi_history_status == 'y') return 'Finish';
            else return '-';
          }
        },
        {
          "data": "transaksi_history_when"
        },
        {
          "data": "transaksi_history_who"
        },
      ]
    }).columns.adjust();
    /* Isi Table History*/

    $('.datetimepicker').datetimepicker({
      format: 'YYYY-MM-DD'
    })

    // filter
    $("#filter").on("submit", function(e) {
      e.preventDefault();
      $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
        if (!json.user_id) {
          fun_notifLogout();
        } else {
          fun_loading();
          $('#table').DataTable().ajax.url('<?= base_url('/material/request/getTransaksiOut?transaksi_tipe=O&') ?>' + $('#filter').serialize()).load();
        }
      })
    });
    // filter

    /* Tanggal */
    $(".tanggal").daterangepicker({
      showDropdowns: true,
      singleDatePicker: true,
      locale: {
        format: 'DD-MM-YYYY'
      }
    });
    /* Tanggal */

    //   /* Select2 */
    //     $('.select2').select2({
    //       placeholder: 'Pilih',
    //     });

    //     $('.select2-selection').css('height', '37px');
    //     $('.select2').css('width', '100%');
    //   /* Select2 */
    // });



    // /  * Select2  Peminta Jasa */
    $('#peminta_jasa_id').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url('material/request/getPemintaJasa') ?>',
        dataType: 'json',
        type: 'GET',
        data: function(params) {
          var queryParameters = {
            peminta_jasa_nama: params.term
          }

          return queryParameters;
        }
      }
    });

    $('.select2-selection').css('height', '37px');
    $('.select2').css('width', '100%');
    /* Select2 Peminta Jasa */
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

  function fun_seksi() {
    $.getJSON('<?= base_url('material/request/getSeksiPeminta') ?>', function(json) {
      $('#seksi_id_peminta').val(json.seksi_id);
      $('#seksi_nama_peminta').val(json.seksi_nama);
    })
  }

  function fun_userPeminta() {
    $.getJSON('<?= base_url('material/request/getUserPeminta') ?>', function(json) {
      $('#user_id_peminta').val(json.user_id);
      $('#user_nama_peminta').val(json.user_nama_lengkap);
    })
  }

  function fun_tambah() {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        fun_seksi();
        fun_userPeminta();
        fun_loading();
        $('#transaksi_id').val(Date.now());

        setTimeout(function() {
          $('#dg').edatagrid({
            url: '<?= base_url('material/request/getEasyuiMaterial?transaksi_id=') ?>' + $('#transaksi_id').val(),
            saveUrl: '<?= base_url('material/request/insertEasyuiMaterial') ?>',
            updateUrl: '<?= base_url('material/request/editEasyuiMaterial') ?>',
          });
        }, 500);
      }
    })
  }

  function fun_detail(isi) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        fun_loading();
        $('#div_detail').css('display', 'block');
        $('#table1').DataTable().ajax.url('<?= base_url() ?>material/request/getRequestDetail?transaksi_id=' + isi).load();
        // $('#modal_aksi_detail').on('show.bs.modal', function () {
        $('#table1').DataTable().columns.adjust();
        // });
      }
    })
  }

  // history transaksi
  function fun_history(isi, data) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        fun_loading();
        $('#judul_history').html('<?= $judul ?>' + ' ' + data)
        $('#id_transaksi_cetak').val(isi);
        $('#div_history').css('display', 'block');
        $('#table_history').DataTable().ajax.url('<?= base_url() ?>material/request/getRequestHistory?transaksi_id=' + isi).load();
        $('html, body').animate({
          scrollTop: $("#div_history").offset().top
        }, 10);
      }
    });
  }
  // history transaksi

  function fun_approve(isi) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        fun_loading();
        // function fun_edit(id) {
        $('#simpan').css('display', 'none');
        $('#aprove').css('display', 'block');
        $('#disiapkan').css('display', 'block');
        $('#diambil').css('display', 'block');

        $.getJSON('<?= base_url('material/request/getRequest') ?>', {
          transaksi_id: isi
        }, function(json) {
          $.each(json, function(index, val) {
            $('#' + index).val(val);
          });
          $('#tanggal').val(json.transaksi_waktu);
          $('#waktu').val(json.transaksi_jam);
          $('#transaksi_id').val(json.transaksi_id);
          $('#seksi_id_peminta').val(json.seksi_id);
          $('#seksi_nama_peminta').val(json.seksi_nama);
          $('#user_id_peminta').val(json.user_id);
          $('#user_nama_peminta').val(json.user_nama_lengkap);
        });

        setTimeout(function() {
          $('#dg').edatagrid({
            url: '<?= base_url('/material/request/getEasyuiMaterial?transaksi_id=') ?>' + isi,
            saveUrl: '<?= base_url('/material/request/insertEasyuiMaterial') ?>',
            updateUrl: '<?= base_url('/material/request/editEasyuiMaterial') ?>',
          });
        }, 500);
      }
    })
  }


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
                beforeSend: function() {
                  $('#loading_form').show();
                  $('#simpan').hide();
                  $('#aprove').hide();
                  $('#disiapkan').hide();
                  $('#diambil').hide();
                  $('#edit').hide();
                },
                complete: function() {
                  $('#loading_form').hide()
                },
                success: function(isi) {
                  fun_loading();
                  $('#form_modal')[0].reset();
                  $('#table').DataTable().ajax.reload(null, false);
                  $('#close').click();
                  toastr.success('Berhasil');
                }
              })
            }
          }
        })
      }
    })
  })

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
                beforeSend: function() {
                  $('#loading_form').show();
                  $('#simpan').hide();
                  $('#aprove').hide();
                  $('#disiapkan').hide();
                  $('#diambil').hide();
                  $('#edit').hide();
                },
                complete: function() {
                  $('#loading_form').hide()
                },
                success: function(isi) {
                  fun_loading();
                  $('#form_modal')[0].reset();
                  $('#table').DataTable().ajax.reload(null, false);
                  $('#close').click();
                  toastr.success('Berhasil');
                }
              })
            }
          }
        })
      }
    })
  })

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
                beforeSend: function() {
                  $('#loading_form').show();
                  $('#simpan').hide();
                  $('#aprove').hide();
                  $('#disiapkan').hide();
                  $('#diambil').hide();
                  $('#edit').hide();
                },
                complete: function() {
                  $('#loading_form').hide()
                },
                success: function(isi) {
                  fun_loading();
                  $('#form_modal')[0].reset();
                  $('#table').DataTable().ajax.reload(null, false);
                  $('#close').click();
                  toastr.success('Berhasil');
                }
              })
            }
          }
        })
      }
    })
  })

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
                beforeSend: function() {
                  $('#loading_form').show();
                  $('#simpan').hide();
                  $('#aprove').hide();
                  $('#disiapkan').hide();
                  $('#diambil').hide();
                  $('#edit').hide();
                },
                complete: function() {
                  $('#loading_form').hide()
                },
                success: function(isi) {
                  fun_loading();
                  $('#form_modal')[0].reset();
                  $('#table').DataTable().ajax.reload(null, false);
                  $('#close').click();
                  toastr.success('Berhasil');
                }
              })
            }
          }
        })
      }
    })
  })



  // EASY UI

  // tambah
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
  // tambah

  // simpan
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
  // simpan

  // hapus
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
  // hapus

  // reload dg
  function fun_reload_to() {
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
    $('#aprove').css('display', 'none');
    $('#disiapkan').css('display', 'none');
    $('#diambil').css('display', 'none');
    $('#peminta_alert').css('display', 'none');
    $('#transaksi_id').empty();
    $('#form_modal')[0].reset();
    $('#peminta_jasa_id').empty();
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
    fun_loading();
    fun_close();
  });
</script>