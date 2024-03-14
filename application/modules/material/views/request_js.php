<script type="text/javascript">
  $(function() {
    fun_loading();

    $(".tanggal").daterangepicker({
      locale: {
        format: 'DD-MM-YYYY'
      }
    });

    $('.datetimepicker').datetimepicker({
      format: 'YYYY-MM-DD'
    });

    /* Select2  Peminta Jasa */
    $('#peminta_jasa_id').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url('material/request/getSeksiPeminta') ?>',
        dataType: 'json',
        type: 'GET',
        data: function(params) {
          var queryParameters = {
            seksi_nama: params.term
          }

          return queryParameters;
        }
      }
    });
    /* Select2 Peminta Jasa */

    $('.select2-selection').css('height', '37px');
    $('.select2').css('width', '100%');

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
        "url": "<?= base_url() ?>/material/request/getRequest?transaksi_status=n&transaksi_tipe=O",
        "dataSrc": ""
      },

      "columns": [{
        render: function(data, type, full, meta) {
          return meta.row + meta.settings._iDisplayStart + 1;
        }
      }, {
        "data": "transaksi_nomor"
      }, {
        "data": "transaksi_waktu"
      }, {
        "data": "transaksi_jam"
      }, {
        "data": "seksi_nama"
      }, {
        "data": "user_nama_lengkap"
      }, {
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
      }, {
        "render": function(data, type, full, meta) {
          return '<center><a href="javascript:;" id="' + full.transaksi_id + '" name="' + full.user_nama_lengkap + '" title="History" onclick="fun_history(this.id,this.name)"><i class="fa fa-history" data-toggle="modal" data-target="#modal_aksi_history" style="color:aqua"></i></a></center>';
        }
      }, {
        "render": function(data, type, full, meta) {
          return '<center><a href="javascript:;" id="' + full.transaksi_id + '" name="' + full.user_nama_lengkap + '" title="Detail" onclick="fun_detail(this.id,this.name)"><i class="fa fa-search" data-toggle="modal" data-target="#modal_aksi_detail"></i></a></center>';
        }
      }, {
        "render": function(data, type, full, meta) {
          return (full.transaksi_status == 'n' && (full.user_id == '<?= $this->session->userdata('user_id') ?>' || '<?= $this->session->userdata('user_id') ?>' == '1')) ? '<center><a href="<?= base_url('material/request/indexProses') ?>?header_menu=<?= $_GET['header_menu'] ?>&menu_id=<?= $_GET['menu_id'] ?>&transaksi_id=' + full.transaksi_id + '&aksi=2" id="' + full.transaksi_id + '" title="Edit"><i class="fa fa-edit" style="color: lime;"></i></a></center>' : '<center>-</center';
        }
      }, {
        "render": function(data, type, full, meta) {
          if('<?= $this->session->userdata('user_id') ?>' == '1' && (full.transaksi_status == 'n' || full.transaksi_status =='r' || full.transaksi_status == 'a'))
            return '<center><a href="javascript:;" id="' + full.transaksi_id + '" title="Delete" onclick="return fun_delete(this.id)"><i class="fa fa-trash" style="color: red;"></i></a></center>'
          else if(full.user_id == '<?= $this->session->userdata('user_id')?>' && full.transaksi_status =='n')
            return '<center><a href="javascript:;" id="' + full.transaksi_id + '" title="Delete" onclick="return fun_delete(this.id)"><i class="fa fa-trash" style="color: red;"></i></a></center>'
          else
            return '<center>-</center'
        }
      }, {
        "render": function(data, type, full, meta) {
          if (full.transaksi_status == 'n' && full.user_nik_sap == '<?= $this->session->userdata('user_nik_sap') ?>') return '<center><a href="<?= base_url('material/request/indexProses') ?>?header_menu=<?= $_GET['header_menu'] ?>&menu_id=<?= $_GET['menu_id'] ?>&transaksi_id=' + full.transaksi_id + '&aksi=3" id="' + full.transaksi_id + '" title="Proses"><i class="fa fa-share" style="color: orange;"></i></a></center>';
          // else if (full.transaksi_status == 'n' && '2145622' == '<?= $this->session->userdata('user_nik_sap') ?>') return '<center><a href="<?= base_url('material/request/indexProses') ?>?header_menu=<?= $_GET['header_menu'] ?>&menu_id=<?= $_GET['menu_id'] ?>&transaksi_id=' + full.transaksi_id + '&aksi=3" id="' + full.transaksi_id + '" title="Proses"><i class="fa fa-share" style="color: orange;"></i></a></center>';
          else if (full.transaksi_status == 'r' && '2105087' == '<?= $this->session->userdata('user_nik_sap') ?>') return '<center><a href="<?= base_url('material/request/indexProses') ?>?header_menu=<?= $_GET['header_menu'] ?>&menu_id=<?= $_GET['menu_id'] ?>&transaksi_id=' + full.transaksi_id + '&aksi=3" id="' + full.transaksi_id + '" title="Proses"><i class="fa fa-share" style="color: orange;"></i></a></center>';
          else return '<center>-</center>';
        }
      }, ]
    }).columns.adjust();
    /* Isi Table */

    /* Isi Table Detail*/
    $('#table1').DataTable({
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
      }, {
        "data": "item_nama"
      }, {
        "data": "item_satuan"
      }, {
        "data": "transaksi_detail_jumlah"
      }, {
        "data": "transaksi_detail_total",
        render: $.fn.dataTable.render.number('.', ',', 2, 'Rp. ')
      }, ]
    }).columns.adjust();
    /* Isi Table Detail*/

    /* Isi Table History*/
    $('#table_history').DataTable({
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
      }, {
        "render": function(data, type, row, meta) {
          return row.transaksi_history_keterangan;
        }
      }, {
        "render": function(type, data, row, meta) {
          if (row.transaksi_history_status == 'n') return 'Pengajuan';
          else if (row.transaksi_history_status == 'r') return 'Approve AVP Customer';
          else if (row.transaksi_history_status == 'a') return 'Approve AVP LUK';
          else if (row.transaksi_history_status == 's') return 'Sedang Disiapkan';
          else if (row.transaksi_history_status == 'd') return 'Bisa Diambil';
          else if (row.transaksi_history_status == 'y') return 'Finish';
          else return '-';
        }
      }, {
        "data": "transaksi_history_when"
      }, {
        "data": "transaksi_history_who"
      }, ]
    }).columns.adjust();
    /* Isi Table History*/

    $('#filter').submit();
  });

  /* Proses Filter */
  $("#filter").on("submit", function(e) {
    e.preventDefault();
    fun_loading();
    $('#table').DataTable().ajax.url('<?= base_url() ?>material/request/getRequest?transaksi_tipe=O&' + $('#filter').serialize()).load();
  });
  /* Proses Filter */

  /* History*/
  function fun_history(isi, data) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        fun_loading();
        $('#judul_history').html('<?= $judul ?>' + ' ' + data);
        $('#table_history').DataTable().ajax.url('<?= base_url() ?>material/request/getRequestHistory?transaksi_id=' + isi).load();
      }
    });
  }
  /* History*/

  /* Detail */
  function fun_detail(isi, data) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        fun_loading();
        $('#judul_detail').html('<?= $judul ?>' + ' ' + data);
        $('#table1').DataTable().ajax.url('<?= base_url() ?>material/request/getRequestDetail?transaksi_id=' + isi).load();
      }
    });
  }
  /* Detail */

  /* Delete */
  function fun_delete($data) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $.confirmModal('Apakah anda yakin akan menghapusnya?', function(el) {
          $.ajax({
            url: '<?= base_url() ?>material/request/deleteTransaksi',
            data: {
              transaksi_id: $data
            },
            type: 'GET',
            dataType: 'html',
            success: function(isi) {
              $('#table').DataTable().ajax.reload(null, false);
              toastr.success('Berhasil');
              fun_loading();
            }
          })
        })
      }
    })
  }
  /* Delete */

  /* Fun Loading */
  function fun_loading() {
    var simplebar = new Nanobar();
    simplebar.go(100);
  }
  /* Fun Loading */
</script>