<script type="text/javascript">
  $(function() {
    fun_loading();

    /* Isi Table */
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
        "url": "<?= base_url() ?>sample/notifikasi/getNotifikasi",
        "dataSrc": ""
      },
      "fnRowCallback": function(data, type, full, meta) {
        if (type['is_urgent'] == 'y') $('td', data).css('background-color', 'Yellow');
      },
      "columns": [{
          "data": "transaksi_detail_tgl_pengajuan_baru"
        },
        {
          "render": function(data, type, full, meta) {
            return (full.estimasi) ? full.estimasi + ' Hari' : '-';
          }
        },
        {
          "data": "peminta_jasa_nama"
        },
        {
          "data": "jenis_nama"
        },
        {
          "data": "sample_pekerjaan_nama"
        },
        {
          "render": function(data, type, full, meta) {
            var status = '';
            var warna = '';
            if (full.transaksi_status == '0') {
              status = 'Belum Diapprove';
              warna = '#5fa7bb';
            } else if (full.transaksi_status == '1') {
              status = 'Sudah Diapprove';
              warna = '#5eb916';
            } else if (full.transaksi_status == '2') {
              status = 'Sample Belum Diterima';
              warna = '#ea815f';
            } else if (full.transaksi_status == '3' && full.transaksi_detail_status == '9') {
              status = 'Tunda';
              warna = ' #f37b2d';
            } else if (full.transaksi_status == '3' && full.transaksi_detail_status == '3') {
              status = 'Sample Diterima';
              warna = '#69e8aa';
            } else if (full.transaksi_status == '4' && full.transaksi_detail_status == '9') {
              status = 'Tunda';
              warna = ' #f37b2d';
            } else if (full.transaksi_status == '4' && full.transaksi_detail_status == '4') {
              status = 'On Progress';
              warna = '#69c5e8';
            } else if (full.transaksi_status == '5') {
              status = 'Terbit Sertifikat';
              warna = '#e8d369';
            } else if (full.transaksi_status == '6') {
              status = 'Clossed';
              warna = '#79724d';
            } else if (full.transaksi_status == '7') {
              status = 'Tambah Petugas Sampling';
              warna = '#b2a4da';
            } else if (full.transaksi_status == '8') {
              status = 'Reject';
              warna = '#c13333';
            }
            return '<span class="badge" style="background-color: ' + warna + '">' + status + '</span>';
          }
        },
        {
          "render": function(data, type, full, meta) {
            return '<center><a href="<?= base_url('sample/notifikasi/print_qrcode/?transaksi_id=') ?>' + full.transaksi_id + '" target="_BLANK" id="' + full.transaksi_id + '" title="Edit"><i class="fa fa-qrcode" style="color: black;"></i></a></center>';
          }
        }, {
          "render": function(data, type, full, meta) {
            return '<center><a href="javascript:;" id="' + full.transaksi_id + '" title="Detail" data-toggle="modal" data-target="#modal_detail" name="' + full.transaksi_nomor + '" onclick="fun_detail(this.id, this.name)"><i class="fa fa-search"></i></a></center>';
          }
        },
        {
          "render": function(data, type, full, meta) {
            return (full.is_khusus == 'y' && full.transaksi_tipe == 'E') ? '<center><a href="javascript:;" id="' + full.transaksi_id + '" title="Edit" onclick="fun_proses(this.id)"><i class="fa fa-share" data-toggle="modal" data-target="#modal" style="color: green;"></i></a></center>' : '';
          }
        },
      ]
    });
    /* Isi Table */

    /* Isi Table Detail */
    $('#table_detail').DataTable({
      "ordering": false,
      "ajax": {
        "url": "<?= base_url() ?>sample/library/getLibraryDetail?transaksi_id=0",
        "dataSrc": ""
      },
      "columns": [{
          "data": "transaksi_detail_tgl_pengajuan_baru"
        },
        {
          "render": function(data, type, full, meta) {
            var status = '';
            if (full.transaksi_status == 'n') status = 'Draft';
            else if (full.transaksi_status == '00') status = 'Pengajuan Draft';
            else if (full.transaksi_status == '0') status = 'Pengajuan';
            else if (full.transaksi_status == '01') status = 'Review';
            else if (full.transaksi_detail_status == '1') status = 'Sudah Diapprove';
            else if (full.transaksi_detail_status == '2') status = 'Sample Belum Diterima';
            else if (full.transaksi_detail_status == '3') status = 'Sample Diterima';
            else if (full.transaksi_detail_status == '4') status = 'On Progress';
            else if (full.transaksi_detail_status == '5') status = 'Terbit Sertifikat';
            else if (full.transaksi_detail_status == '6') status = 'Clossed';
            else if (full.transaksi_detail_status == '7') status = 'Tambah Petugas Sampling';
            else if (full.transaksi_detail_status == '8') status = 'Reject';
            else if (full.transaksi_detail_status == '9') status = 'Tunda';
            return status;
          }
        },
        {
          "data": "transaksi_detail_tgl_estimasi_baru"
        },
        {
          "data": "transaksi_detail_note"
        },
        {
          "data": "who_create"
        },
      ]
    });
    /* Isi Table Detail */

    /* Tanggal */
    $("#tanggal").daterangepicker({
      showDropdowns: true,
      singleDatePicker: true,
      locale: {
        format: 'DD-MM-YYYY'
      }
    });
    /* Tanggal */

    /* Select2 */
    /* User */
    $('#id_petugas').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url('sample/notifikasi/getUser') ?>',
        dataType: 'json',
        type: 'GET',
        data: function(params) {
          var queryParameters = {
            user_nama_lengkap: params.term
          }

          return queryParameters;
        }
      }
    });
    /* User */

    $('.select2-selection').css('height', 'auto');
    $('.select2').css('width', '100%');
    /* Select2 */
  });

  /* View Update */
  function fun_proses(id) {
    $.getJSON('<?= base_url('sample/notifikasi/getNotifikasi') ?>', {
      transaksi_id: id
    }, function(json) {
      $('#transaksi_id').val(json.transaksi_id);
      $('#peminta_jasa_nama').val(json.peminta_jasa_nama);
      $('#jenis_nama').val(json.jenis_nama);
      $('#identitas_nama').val(json.identitas_nama);
      $('#transaksi_status').val(json.transaksi_status);
      $('#transaksi_detail_status').val(json.transaksi_detail_status);
      $('#sample_pekerjaan_nama').val(json.sample_pekerjaan_nama);
      $('#transaksi_detail_pic_pengirim').val(json.transaksi_detail_pic_pengirim);
      $('#transaksi_detail_ext_pengirim').val(json.transaksi_detail_ext_pengirim);
      $('#transaksi_detail_jumlah').val(json.transaksi_detail_jumlah);
      $('#transaksi_detail_tgl_pengajuan').val(json.transaksi_detail_tgl_pengajuan_baru);
      $('#transaksi_detail_tgl_memo').val(json.transaksi_detail_tgl_memo_baru);
      $('#transaksi_detail_no_memo').val(json.transaksi_detail_no_memo);
      $('#transaksi_detail_parameter').val(json.transaksi_detail_parameter);
      $('#seksi_nama').val(json.seksi_nama);
      $('#transaksi_detail_foto').attr("src", '<?= base_url('document/') ?>' + json.transaksi_detail_foto);
      $('#unduh').attr("href", '<?= base_url('document/') ?>' + json.transaksi_detail_foto);
    });
  }
  /* View Update */

  /* Proses */
  $("#form_modal").on("submit", function(event) {
    event.preventDefault();
    $.ajax({
      url: '<?= base_url('sample/notifikasi/insertNotifikasi') ?>',
      data: $('#form_modal').serialize(),
      type: 'POST',
      dataType: 'html',
      beforeSend: function() {
        $('#loading_form').css('display', 'block');
        $('#simpan').css('display', 'none');
      },
      success: function(isi) {
        $('#close').click();
        $('#simpan').show();
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
  });
  /* Proses */

  function fun_detail(id, nama) {
    var judul = (nama) ? nama : '';
    $('#judul_detail').html('Detail - ' + judul);
    $('#table_detail').DataTable().ajax.url('<?= base_url() ?>sample/library/getLibraryDetail?transaksi_id=' + id).load();
    setTimeout(function() {
      $('#' + id).parents('tr').attr('style', 'color: red')
    }, 500);
  }

  /* Fun Close */
  function fun_close() {
    $("#id_petugas").val("");
    $("#id_petugas").trigger("change");

    $('#approve').css('display', 'none');
    $('#reject').css('display', 'none');
    $('#loading_form').css('display', 'none');
    $('#div_khusus').css('display', 'none');
    $('#div_urgent').css('display', 'none');
    $('#div_disposisi').css('display', 'none');
    $('#role_id').empty();
    $('#form_modal')[0].reset();
    $('#table').DataTable().ajax.reload();
    fun_loading();
  }
  /* Fun Close */

  $('#modal').on('hidden.bs.modal', function(e) {
    fun_close();
  });

  $('#modal_detail').on('hidden.bs.modal', function(e) {
    fun_close();
  });

  function fun_loading() {
    var simplebar = new Nanobar();
    simplebar.go(100);
  }
</script>