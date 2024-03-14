<script type="text/javascript">
  $(function() {
    fun_loading();
    /* Isi Table */
    $('#table').DataTable({
      "lengthMenu": [
        [5, 10, 25, 50, -1],
        [5, 10, 25, 50, "All"]
      ],
      "dom": 'lBfrtip',
      "buttons": ["csv", "pdf", "excel", "copy", "print"],
      "ajax": {
        "url": "<?= base_url() ?>/sample/approve/getApprove?transaksi_status_approve=0,01",
        // "url": "<?= base_url() ?>/sample/approve/getApprove?transaksi_status_approve=0tgl_cari=<?= date('d-m-Y') . ' - ' . date('d-m-Y') ?>",
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
          "data": "transaksi_detail_tgl_pengajuan_baru"
        },
        {
          "data": "peminta_jasa_nama"
        },
        {
          "data": "jenis_nama"
        },
        // {
        //   "data": "sample_pekerjaan_nama"
        // },
        // {
        //   "data": "transaksi_detail_tgl_memo_baru"
        // },
        // {
        //   "data": "transaksi_detail_no_memo"
        // },
        {
          "render": function(data, type, full, meta) {
            var status = '';
            var warna = '';
            if (full.transaksi_detail_status == '0') {
              status = 'Draft';
              warna = '#e8d234';
            } else if (full.transaksi_detail_status == '1') {
              status = 'Pengajuan';
              warna = '#5fa7bb';
            } else if (full.transaksi_detail_status == '2') {
              status = 'Review AVP';
              warna = '#5fa7dd';
            } else if (full.transaksi_detail_status == '3') {
              status = 'Approve VP';
              warna = '#5eb916';
            } else if (full.transaksi_detail_status == '4') {
              status = 'Approve VP PPK';
              warna = '#ea815f';
            } else if (full.transaksi_detail_status == '5') {
              status = 'Approve AVP LUK';
              warna = '#ea815f';
            } else if (full.transaksi_detail_status == '6') {
              status = 'Sample Belum Diterima';
              warna = '#ea815f';
            } else if (full.transaksi_detail_status == '12') {
              status = 'Tunda'; //Sample Diterima
              warna = ' #f37b2d';
            } else if (full.transaksi_detail_status == '7') {
              status = 'Sample Diterima';
              warna = '#69e8aa';
            } else if (full.transaksi_detail_status == '13') {
              status = 'Tunda'; //Sample On Progress
              warna = ' #f37b2d';
            } else if (full.transaksi_detail_status == '8') {
              status = 'On Progress';
              warna = '#69c5e8';
            } else if (full.transaksi_detail_status == '9') {
              status = 'Draft Log Sheet';
              warna = '#e8d369';
            } else if (full.transaksi_detail_status == '10') {
              status = 'Menunggu Review Kasie';
              warna = '#e8d369';
            } else if (full.transaksi_detail_status == '11') {
              status = 'Review Kasie';
              warna = '#79724d';
            } else if (full.transaksi_detail_status == '14') {
              status = 'Batal';
              warna = 'red';
            } else if (full.transaksi_detail_status == '15') {
              status = 'Reject';
              warna = '#c13333';
            }
            return '<span class="badge" style="background-color: ' + warna + '">' + status + '</span>';
          }
        },
        {
          "render": function(data, type, full, meta) {
            if (full.transaksi_status == '0') {
              return '<center><ul class="navbar-nav ml-auto">' +
                '<li class="nav-item dropdown">' +
                '<a class="nav-link btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">' +
                'Action<i class=""></i>' +
                '</a>' +
                '<div class="dropdown-menu dropdown-menu-md dropdown-menu-right">' +
                '<a href="javascript:;" class="dropdown-item" id="' + full.transaksi_id + '" title="Detail" data-toggle="modal" data-target="#modal" onclick="fun_review(this.id)">Review</a>' +
                '</a>' +
                '<div class="dropdown-divider"></div>' +
                '<a href="javascript:;" class="dropdown-item" id="' + full.transaksi_id + '"  data-toggle="modal" data-target="#modal" onclick="fun_reject(this.id)">Reject</a>' +
                '</a>' +
                '</li>' +
                '</ul></center';
            } else if (full.transaksi_status == '2') {
              return '<center><ul class="navbar-nav ml-auto">' +
                '<li class="nav-item dropdown">' +
                '<a class="nav-link btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">' +
                'Action<i class=""></i>' +
                '</a>' +
                '<div class="dropdown-menu dropdown-menu-md dropdown-menu-right">' +
                '<a href="javascript:;" class="dropdown-item" id="' + full.transaksi_id + '"  title="Edit" data-toggle="modal" data-target="#modal"  onclick="fun_approve(this.id)">Approve</a>' +
                '</a>' +
                '<div class="dropdown-divider"></div>' +
                '<a href="javascript:;" class="dropdown-item" id="' + full.transaksi_id + '"  data-toggle="modal" data-target="#modal" onclick="fun_reject(this.id)">Reject</a>' +
                '</a>' +
                '</li>' +
                '</ul></center';
            }else{
              return '<center>-</center'
            }
          }
        },
      ]
    });
    /* Isi Table */

    /* Tanggal */
    $(".tanggal").daterangepicker({
      showDropdowns: true,
      singleDatePicker: true,
      timePicker: true,
      timePicker24Hour: true,
      timePickerSeconds: true,
      locale: {
        format: 'DD-MM-YYYY HH:mm:ss'
      }
    });

    $("#tgl_cari").daterangepicker({
      locale: {
        format: 'DD-MM-YYYY'
      }
    });
    /* Tanggal */

    /* Select2 */
    /* Jenis Pekerjaan */
    $('#id_seksi').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url('sample/approve/getSeksi') ?>',
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
    /* Jenis Pekerjaan */

    $('.select2-selection').css('height', 'auto');
    $('.select2').css('width', '100%');
    /* Select2 */
  });

  $('.datetimepicker').datetimepicker({
    format: 'YYYY-MM-DD'
  })

  /* FIlter */
  $('#filter').on('submit', function(e) {
    e.preventDefault();
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $('#table').DataTable().ajax.url('<?= base_url() ?>sample/approve/getApprove?transaksi_status_approve=0,01' + $('#filter').serialize()).load();
        fun_loading();
        if ($('#transaksi_tipe').val() == 'E') {
          approve_eksternal();
          notif_eksternal();
          inbox_eksternal();
          total_eksternal();
        } else if ($('#transaksi_tipe').val() == 'I') {
          approve_internal();
          notif_internal();
          inbox_internal();
          total_internal();
        }
      }
    });
  });
  /* FIlter */


  /* View Update */
  function fun_approve(id) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $.getJSON('<?= base_url('sample/request/getRequestDashboard?isi=ok') ?>', {
          transaksi_id: id
        }, function(json) {
          $('#approve').css('display', 'block');
          $('#div_khusus').css('display', 'block');
          $('#div_urgent').css('display', 'block');
          $('#div_disposisi').css('display', 'block');

          $('#identitas_nama').val(json.identitas_nama);
          $('#transaksi_id').val(json.transaksi_id);
          $('#peminta_jasa_nama').val(json.peminta_jasa_nama);
          $('#jenis_nama').val(json.jenis_nama);
          $('#sample_pekerjaan_nama').val(json.sample_pekerjaan_nama);
          $('#transaksi_detail_pic_pengirim').val(json.transaksi_detail_pic_pengirim);
          $('#transaksi_detail_ext_pengirim').val(json.transaksi_detail_ext_pengirim);
          $('#transaksi_detail_jumlah').val(json.transaksi_detail_jumlah);
          $('#transaksi_detail_tgl_pengajuan').val(json.transaksi_detail_tgl_pengajuan_baru);
          // $('#transaksi_detail_tgl_memo').val(json.transaksi_detail_tgl_memo_baru);
          $('#transaksi_detail_nomor').val(json.transaksi_detail_nomor);
          // $('#transaksi_detail_no_memo').val(json.transaksi_detail_no_memo);
          $('#transaksi_detail_parameter').val(json.transaksi_detail_parameter);
          $('#transaksi_detail_keterangan').val(json.template_keterangan_nama);
          // $('#transaksi_detail_foto').attr("src", '<?= base_url('document/') ?>' + json.transaksi_detail_foto);
          // $('#unduh').attr("href", '<?= base_url('document/') ?>' + json.transaksi_detail_foto);
        });
      }
    });
  }

  function fun_review(id) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $.getJSON('<?= base_url('sample/request/getRequestDashboard?isi=ok') ?>', {
          transaksi_id: id
        }, function(json) {
          $('#review').css('display', 'block');
          $('#div_khusus').css('display', 'block');
          $('#div_urgent').css('display', 'block');
          $('#div_disposisi').css('display', 'block');

          $('#identitas_nama').val(json.identitas_nama);
          $('#transaksi_id').val(json.transaksi_id);
          $('#peminta_jasa_nama').val(json.peminta_jasa_nama);
          $('#jenis_nama').val(json.jenis_nama);
          $('#sample_pekerjaan_nama').val(json.sample_pekerjaan_nama);
          $('#transaksi_detail_pic_pengirim').val(json.transaksi_detail_pic_pengirim);
          $('#transaksi_detail_ext_pengirim').val(json.transaksi_detail_ext_pengirim);
          $('#transaksi_detail_jumlah').val(json.transaksi_detail_jumlah);
          $('#transaksi_detail_tgl_pengajuan').val(json.transaksi_detail_tgl_pengajuan_baru);
          // $('#transaksi_detail_tgl_memo').val(json.transaksi_detail_tgl_memo_baru);
          $('#transaksi_detail_nomor').val(json.transaksi_detail_nomor);
          // $('#transaksi_detail_no_memo').val(json.transaksi_detail_no_memo);
          $('#transaksi_detail_parameter').val(json.transaksi_detail_parameter);
          $('#transaksi_detail_keterangan').val(json.transaksi_detail_keterangan);
          $('#transaksi_detail_foto').attr("src", '<?= base_url('document/') ?>' + json.transaksi_detail_foto);
          $('#unduh').attr("href", '<?= base_url('document/') ?>' + json.transaksi_detail_foto);
        });
      }
    });
  }

  function fun_reject(id) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $.getJSON('<?= base_url('sample/request/getRequestDashboard?isi=ok') ?>', {
          transaksi_id: id
        }, function(json) {
          $('#req_note').show();

          $('#identitas_nama').val(json.identitas_nama);
          $('#transaksi_id').val(json.transaksi_id);
          $('#peminta_jasa_nama').val(json.peminta_jasa_nama);
          $('#jenis_nama').val(json.jenis_nama);
          $('#sample_pekerjaan_nama').val(json.sample_pekerjaan_nama);
          $('#transaksi_detail_pic_pengirim').val(json.transaksi_detail_pic_pengirim);
          $('#transaksi_detail_ext_pengirim').val(json.transaksi_detail_ext_pengirim);
          $('#transaksi_detail_jumlah').val(json.transaksi_detail_jumlah);
          $('#transaksi_detail_tgl_pengajuan').val(json.transaksi_detail_tgl_pengajuan_baru);
          // $('#transaksi_detail_tgl_memo').val(json.transaksi_detail_tgl_memo_baru);
          // $('#transaksi_detail_no_memo').val(json.transaksi_detail_no_memo);
          $('#transaksi_detail_nomor').val(json.transaksi_detail_nomor);
          $('#transaksi_detail_parameter').val(json.transaksi_detail_parameter);
          $('#transaksi_detail_keterangan').val(json.transaksi_detail_keterangan);
          $('#transaksi_detail_foto').attr("src", '<?= base_url('document/') ?>' + json.transaksi_detail_foto);
          $('#unduh').attr("href", '<?= base_url('document/') ?>' + json.transaksi_detail_foto);

          $('#reject').css('display', 'block');
        });
      }
    });
  }
  /* View Update */

  /* Proses */
  /* Approve */
  $('#approve').on('click', function(event) {
    event.preventDefault();
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        console.log($('#id_seksi').val());
        if ($('#id_seksi').val() != '') {
          $.ajax({
            url: '<?= base_url('sample/approve/insertApprove') ?>',
            data: $('#form_modal').serialize(),
            type: 'POST',
            dataType: 'html',
            beforeSend: function() {
              $('#loading_form').css('display', 'block');
              $('#approve').css('display', 'none');
            },
            success: function(isi) {
              $('#close').click();
              toastr.success('Berhasil');
              if ($('#transaksi_tipe').val() == 'E') {
                approve_eksternal();
                notif_eksternal();
                inbox_eksternal();
                total_eksternal();
              } else if ($('#transaksi_tipe').val() == 'I') {
                approve_internal();
                notif_internal();
                inbox_internal();
                total_internal();
              }
            }
          });
        } else {
          toastr.error('Disposisi Harus Diisi');
        }
      }
    });
  });
  /* Approve */

  /* Approve */
  $('#review').on('click', function(event) {
    event.preventDefault();
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        console.log($('#id_seksi').val());
        if ($('#id_seksi').val() != '') {
          $.ajax({
            url: '<?= base_url('sample/approve/insertReview') ?>',
            data: $('#form_modal').serialize(),
            type: 'POST',
            dataType: 'html',
            beforeSend: function() {
              $('#loading_form').css('display', 'block');
              $('#approve').css('display', 'none');
            },
            success: function(isi) {
              $('#close').click();
              toastr.success('Berhasil');
              if ($('#transaksi_tipe').val() == 'E') {
                approve_eksternal();
                notif_eksternal();
                inbox_eksternal();
                total_eksternal();
              } else if ($('#transaksi_tipe').val() == 'I') {
                approve_internal();
                notif_internal();
                inbox_internal();
                total_internal();
              }
            }
          });
        } else {
          toastr.error('Disposisi Harus Diisi');
        }
      }
    });
  });
  /* Approve */

  /* Reject */
  $('#reject').on('click', function(event) {
    event.preventDefault();
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        if ($('#transaksi_detail_note').val() != '') {
          $.ajax({
            url: '<?= base_url('sample/approve/insertReject') ?>',
            data: $('#form_modal').serialize(),
            type: 'POST',
            dataType: 'html',
            beforeSend: function() {
              $('#loading_form').css('display', 'block');
              $('#reject').css('display', 'none');
            },
            success: function(isi) {
              $('#close').click();
              toastr.success('Berhasil');
              if ($('#transaksi_tipe').val() == 'E') {
                approve_eksternal();
                notif_eksternal();
                inbox_eksternal();
                total_eksternal();
              } else if ($('#transaksi_tipe').val() == 'I') {
                approve_internal();
                notif_internal();
                inbox_internal();
                total_internal();
              }
            }
          });
        } else {
          toastr.error('Note Harus Diisi');
        }
      }
    });
  });
  /* Reject */
  /* Proses */

  /* Fun Close */
  function fun_close() {
    $('#approve').css('display', 'none');
    $('#reject').css('display', 'none');
    $('#review').css('display', 'none');
    $('#loading_form').css('display', 'none');
    $('#div_khusus').css('display', 'none');
    $('#div_urgent').css('display', 'none');
    $('#div_disposisi').css('display', 'none');
    $('#req_note').hide();
    $('#id_seksi').empty();
    $('#form_modal')[0].reset();
    $('#table').DataTable().ajax.reload();
    fun_loading();
  }
  /* Fun Close */

  $('#modal').on('hidden.bs.modal', function(e) {
    fun_close();
  });

  function fun_loading() {
    var simplebar = new Nanobar();
    simplebar.go(100);
  }
</script>