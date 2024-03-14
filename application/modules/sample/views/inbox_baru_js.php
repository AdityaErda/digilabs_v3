<script>
  $(function() {
    fun_proses('<?= $_GET['transaksi_id'] ?>')

  });

  /* View Update */
  function fun_proses(id) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        // $.getJSON('<?= base_url('sample/request/getRequestDashboard?isi=ok') ?>', {
        $.getJSON('<?= base_url('sample/inbox/getRequestDashboard?isi=ok') ?>', {
          transaksi_id: id
        }, function(json) {
          var transaksi_detail_tgl_estimasi = '';
          if (json.transaksi_detail_tgl_estimasi_baru) transaksi_detail_tgl_estimasi = json.transaksi_detail_tgl_estimasi_baru;
          else transaksi_detail_tgl_estimasi = '';

          $('#transaksi_id').val(json.transaksi_id);
          $('#peminta_jasa_nama').val(json.peminta_jasa_nama);
          $('#jenis_nama').val(json.jenis_nama);
          $('#identitas_nama').val(json.identitas_nama);
          $('#transaksi_detail_parameter').val(json.transaksi_detail_parameter);
          $('#sample_pekerjaan_nama').val(json.sample_pekerjaan_nama);
          $('#transaksi_detail_pic_pengirim').val(json.transaksi_detail_pic_pengirim);
          $('#transaksi_detail_ext_pengirim').val(json.transaksi_detail_ext_pengirim);
          $('#transaksi_detail_jumlah').val(json.transaksi_detail_jumlah);
          $('#transaksi_detail_tgl_pengajuan').val(json.transaksi_detail_tgl_pengajuan_baru);
          $('#transaksi_detail_tgl_memo').val(json.transaksi_detail_tgl_memo_baru);
          $('#transaksi_detail_no_memo').val(json.transaksi_detail_no_memo);
          $('#transaksi_detail_tgl_estimasi').val(json.transaksi_detail_tgl_estimasi);
          $('#transaksi_detail_keterangan').val(json.template_keterangan_nama);
          // $('#transaksi_detail_foto').attr("src", '<?= base_url('document/') ?>' + json.transaksi_detail_foto);
          // $('#unduh').attr("href", '<?= base_url('document/') ?>' + json.transaksi_detail_foto);

          if (json.transaksi_status == '1' || json.transaksi_status == '2' || json.transaksi_status == '7') {
            $('#belum_diterima').css('display', 'block');
            $('#diterima').css('display', 'block');
            $('#peminta_jasa_nama').attr('readonly', 'true');
            $('#jenis_nama').attr('readonly', 'true');
            $('#sample_pekerjaan_nama').attr('readonly', 'true');
            $('#transaksi_detail_pic_pengirim').attr('readonly', 'true');
            $('#transaksi_detail_ext_pengirim').attr('readonly', 'true');
            $('#transaksi_detail_jumlah').attr('readonly', 'true');
            $('#identitas_nama').attr('readonly', 'true');
            $('#transaksi_detail_keterangan').attr('readonly', 'true');
            $('#transaksi_detail_tgl_pengajuan').attr('readonly', 'true');
          } else if (json.transaksi_status == '3') {
            $('#tunda').css('display', 'block');
            $('#progress').css('display', 'block');
            $('#peminta_jasa_nama').attr('readonly', 'true');
            $('#jenis_nama').attr('readonly', 'true');
            $('#sample_pekerjaan_nama').attr('readonly', 'true');
            $('#transaksi_detail_pic_pengirim').attr('readonly', 'true');
            $('#transaksi_detail_ext_pengirim').attr('readonly', 'true');
            $('#transaksi_detail_jumlah').attr('readonly', 'true');
            $('#identitas_nama').attr('readonly', 'true');
            $('#transaksi_detail_keterangan').attr('readonly', 'true');
            $('#transaksi_detail_tgl_pengajuan').attr('readonly', 'true');
          } else if (json.transaksi_status == '4' && json.transaksi_detail_status == '9') {
            $('#tunda').css('display', 'block');
            $('#progress').css('display', 'block');
          } else if (json.transaksi_status == '4' && json.transaksi_detail_status != '9') {
            $('#tunda').css('display', 'block');
            $('#terbit_sertifikat').css('display', 'block');
          } else if (json.transaksi_status == '5') {
            $('#div_file').css('display', 'block');
            $('#div_surat').css('display', 'block');
            $('#clossed').css('display', 'block');
            $('#peminta_jasa_nama').attr('readonly', 'true');
            $('#jenis_nama').attr('readonly', 'true');
            $('#sample_pekerjaan_nama').attr('readonly', 'true');
            $('#transaksi_detail_pic_pengirim').attr('readonly', 'true');
            $('#transaksi_detail_ext_pengirim').attr('readonly', 'true');
            $('#transaksi_detail_jumlah').attr('readonly', 'true');
            $('#identitas_nama').attr('readonly', 'true');
            $('#transaksi_detail_keterangan').attr('readonly', 'true');
            $('#transaksi_detail_parameter').attr('readonly', 'true');
            $('#transaksi_detail_tgl_pengajuan').attr('readonly', 'true');
          }
        });
      }
    });
  }
  /* View Update */

  /* Proses */
  /* Belum Diterima*/
  $('#belum_diterima').on('click', function(event) {
    event.preventDefault();
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        if ($('#transaksi_detail_tgl_estimasi').val() == '') {
          toastr.error('Tgl Estimasi Tidak Boleh Kosong');
        } else if ($('#transaksi_detail_parameter').val() == '') {
          toastr.error('Parameter Tidak Boleh Kosong');
        } else {
          $.confirmModal('Apakah anda yakin dengan tanggal estimasi tersebut ?', function(el) {
            $.ajax({
              url: '<?= base_url('sample/inbox/insertBelumDiterima') ?>',
              data: $('#form_modal').serialize(),
              type: 'POST',
              dataType: 'html',
              beforeSend: function() {
                $('#loading_form').show();
                $('#belum_diterima').hide();
                $('#diterima').hide();
              },
              success: function(isi) {
                $('#close').click();
                $('#loading_form').hide();
                $('#belum_diterima').show();
                $('#diterima').show();
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
          })
        }
      }
    });
  });
  /* Belum Diterima*/

  /* Sample Diterima */
  $('#diterima').on('click', function(event) {
    event.preventDefault();
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        if ($('#transaksi_detail_tgl_estimasi').val() == '') {
          toastr.error('Tgl Estimasi Tidak Boleh Kosong');
        } else if ($('#transaksi_detail_parameter').val() == '') {
          toastr.error('Parameter Tidak Boleh Kosong');
        } else {
          $.confirmModal('Apakah anda yakin dengan tanggal estimasi tersebut ?', function(el) {
            $.ajax({
              url: '<?= base_url('sample/inbox/insertDiterima') ?>',
              data: $('#form_modal').serialize(),
              type: 'POST',
              dataType: 'html',
              beforeSend: function() {
                $('#loading_form').show();
                $('#belum_diterima').hide();
                $('#diterima').hide();
              },
              success: function(isi) {
                $('#close').click();
                $('#loading_form').hide();
                $('#belum_diterima').show();
                $('#diterima').show();
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
          })
        }
      }
    });
  });
  /* Sample Diterima */

  /* On Progress */
  $('#progress').on('click', function(event) {
    event.preventDefault();
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        if ($('#transaksi_detail_tgl_estimasi').val() == '') {
          toastr.error('Tgl Estimasi Tidak Boleh Kosong');
        } else if ($('#transaksi_detail_parameter').val() == '') {
          toastr.error('Parameter Tidak Boleh Kosong');
        } else {
          $.confirmModal('Apakah anda yakin dengan tanggal estimasi tersebut ?', function(el) {
            $.ajax({
              url: '<?= base_url('sample/inbox/insertProgress') ?>',
              data: $('#form_modal').serialize(),
              type: 'POST',
              dataType: 'html',
              beforeSend: function() {
                $('#loading_form').show();
                $('#progress').hide();
                $('#tunda').hide();
              },
              success: function(isi) {
                $('#loading_form').hide();
                $('#progress').show();
                $('#tunda').show();
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
          })
        }
      }
    });
  });
  /* On Progress */

  /* Terbit Sertifikat */
  $('#terbit_sertifikat').on('click', function(event) {
    event.preventDefault();
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        if ($('#transaksi_detail_tgl_estimasi').val() == '') {
          toastr.error('Tgl Estimasi Tidak Boleh Kosong');
        } else if ($('#transaksi_detail_parameter').val() == '') {
          toastr.error('Parameter Tidak Boleh Kosong');
        } else {
          $.confirmModal('Apakah anda yakin dengan tanggal estimasi tersebut ?', function(el) {
            $.ajax({
              url: '<?= base_url('sample/inbox/insertTerbitSertifikat') ?>',
              data: $('#form_modal').serialize(),
              type: 'POST',
              dataType: 'html',
              beforeSend: function() {
                $('#loading_form').show();
                $('#terbit_sertifikat').hide();
                $('#tunda').hide();
              },
              success: function(isi) {
                $('#terbit_sertifikat').show();
                $('#tunda').show();
                $('#loading_form').hide();
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
          })
        }
      }
    });
  });
  /* Terbit Sertifikat */

  /* Clossed */
  $('#clossed').on('click', function(event) {
    event.preventDefault();
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        if ($('#transaksi_detail_file').val() != '' || $('#transaksi_detail_no_surat').val() != '') {
          // $.confirmModal('Apakah anda yakin dengan tanggal estimasi tersebut ?', function(el) {
          var transaksi_detail_file = $('#transaksi_detail_file').prop('files')[0];
          var data = new FormData();

          data.append('transaksi_detail_file', transaksi_detail_file);
          data.append('transaksi_id', $('#transaksi_id').val());
          data.append('transaksi_detail_no_surat', $('#transaksi_detail_no_surat').val());
          data.append('transaksi_detail_tgl_estimasi', $('#transaksi_detail_tgl_estimasi').val());
          data.append('transaksi_detail_note', $('#transaksi_detail_note').val());
          data.append('transaksi_detail_tgl_memo', $('#transaksi_detail_tgl_memo').val());
          data.append('transaksi_detail_no_memo', $('#transaksi_detail_no_memo').val());

          $.ajax({
            url: '<?= base_url('sample/inbox/insertClossed') ?>',
            data: data,
            type: 'POST',
            processData: false,
            contentType: false,
            beforeSend: function() {
              $('#loading_form').show();
              $('#clossed').hide();
            },
            success: function(isi) {
              $('#loading_form').hide();
              $('#clossed').show();
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
          // })
        } else {
          toastr.error('File atau No Surat Tidak Boleh Kosong');
        }
      }
    });
  });
  /* Clossed */

  /* Tunda */
  $('#tunda').on('click', function(event) {
    event.preventDefault();
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        if ($('#transaksi_detail_note').val() != '') {
          $.confirmModal('Apakah anda yakin dengan tanggal estimasi tersebut ?', function(el) {
            $.ajax({
              url: '<?= base_url('sample/inbox/insertTunda') ?>',
              data: $('#form_modal').serialize(),
              type: 'POST',
              dataType: 'html',
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
          })
        } else if ($('#transaksi_detail_tgl_estimasi').val() == '') {
          toastr.error('Tgl Estimasi Tidak Boleh Kosong');
        } else {
          toastr.error('Note Tidak Boleh Kosong');
        }
      }
    })
  });
  /* Tunda */

  /* Proses */

  /* Tanggal */
  $(".tanggal").daterangepicker({
    showDropdowns: true,
    singleDatePicker: true,
    timePicker: true,
    timePicker24Hour: true,
    timePickerSeconds: true,
    locale: {
      format: 'DD-MM-YYYY HH:mm:ss'
    },
  });

  /* Select2 */
  $('.select2').select2({
    placeholder: 'Pilih',
  });

  $('.select2-selection').css('height', '37px');
  $('.select2').css('width', '100%');
  /* Select2 */

  // Select 2 seksi alihkan
  $('#id_seksi_alihkan').select2({
    placeholder: 'Pilih',
    ajax: {
      delay: 250,
      url: '<?= base_url('sample/approve/getSeksi?id_seksi_saat_ini=') ?>' + $("#id_seksi_saat_ini").val(),
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
  // Select 2 seksi alihkan

  $('.datetimepicker').datetimepicker({
    format: 'YYYY-MM-DD'
  });

  // Tombol Alihkan
  function fun_alihkan(id) {
    $('#id_transaksi_alihkan').val(id);
    $('#loading_form_alihkan').hide();
    $('#simpan_alihkan').show();
  }
  // Tombol Alihkan

  // Proses Pengalihan
  $('#form_modal_alihkan').on('submit', function(e) {
    e.preventDefault();

    var data = new FormData(this);

    if ($('#id_seksi_alihkan').val() == null) {
      $('#alert_seksi_alihkan').show();
    } else {
      $('#alert_seksi_alihkan').hide();
    }

    if ($('#alasan_alihkan').val() == '') {
      $('#alert_alasan_alihkan').show();
    } else {
      $('#alert_alasan_alihkan').hide();
    }

    if ($('#id_seksi_alihkan').val() != null && $('#alasan_alihkan').val() != '') {
      $.ajax({
        type: "POST",
        url: '<?= base_url('sample/inbox/insertAlihkan') ?>',
        data: data,
        dataType: "HTML",
        contentType: false,
        processData: false,
        cache: false,
        beforeSend: function() {
          $('#simpan_alihkan').hide();
          $('#loading_form_alihkan').show();
        },
        complete: function(response) {
          $('#simpan_alihkan').show();
          $('#loading_alihkan').hide();
        },
        success: function(response) {
          $('#close_alihkan').click();
        },
        error: function(xhr, ajaxOptions, thrownError) {
          console.log(xhr.status + "\n" + xhr.responseText + "\n" + thrownError)
        }
      });
    }
  })
  // Proses Pengalihan

  /* Fun Close */
  function fun_close() {
    $('#belum_diterima').css('display', 'none');
    $('#diterima').css('display', 'none');
    $('#tunda').css('display', 'none');
    $('#progress').css('display', 'none');
    $('#terbit_sertifikat').css('display', 'none');
    $('#clossed').css('display', 'none');
    $('#div_file').css('display', 'none');
    $('#div_surat').css('display', 'none');
    $('#id_seksi_alihkan').empty();
    $('#transaksi_detail_parameter').removeAttr('readonly');
    $('#form_modal')[0].reset();
    $('#form_modal_alihkan')[0].reset();
    $('#table').DataTable().ajax.reload(null, false);
    fun_loading();
  }

  /* Fun Close */

  $('#modal').on('hidden.bs.modal', function(e) {
    fun_close();
  });

  $('#modal_detail').on('hidden.bs.modal', function(e) {
    fun_close();
  });

  $('#modal_alihkan').on('hidden.bs.modal', function(e) {
    fun_close();
  });



  /* Fun Loading */
  function fun_loading() {
    var simplebar = new Nanobar();
    simplebar.go(100);
  }
  /* Fun Loading */
  $(document).keypress(
    function(event) {
      if (event.which == '13') {
        event.preventDefault();
      }
    });
</script>