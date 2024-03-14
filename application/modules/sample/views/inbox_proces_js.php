<script type="text/javascript">
  $(function() {
    var transaksi_id = $('#transaksi_id').val();
    var transaksi_detail_id = $('#transaksi_detail_id_temp').val();
    var transaksi_detail_status = $('#transaksi_detail_status').val();

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
    /* Tanggal */

    /* Select2 */
    // Template Logsheet
    $('#template_logsheet_id').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url('master/template_logsheet/getTemplateLogsheetList') ?>',
        dataType: 'json',
        type: 'GET',
        data: function(params) {
          var queryParameters = {
            param_search: params.term
          }

          return queryParameters;
        }
      }
    });

    // Cara Close
    $('#cara_close_nama').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url('master/cara_close/getCaraCLoseList?multiple=n') ?>',
        dataType: 'json',
        type: 'GET',
        data: function(params) {
          var queryParameters = {
            cara_close_nama: params.term
          }

          return queryParameters;
        }
      }
    });

    $('.select2-selection').css('height', '37px');
    $('.select2').css('width', '100%');
    /* Select2 */

    $.getJSON("<?= base_url('sample/request/getRequestDetail') ?>", {
      transaksi_id: transaksi_id,
      transaksi_detail_id: transaksi_detail_id,
      transaksi_detail_status: transaksi_detail_status
    }, function(json) {
      $.each(json, function(index, val) {
        $('#peminta_jasa_nama').attr('readonly', 'true');
        $('#jenis_nama').attr('readonly', 'true');
        $('#sample_pekerjaan_nama').attr('readonly', 'true');
        $('#transaksi_detail_pic_pengirim').attr('readonly', 'true');
        $('#transaksi_detail_ext_pengirim').attr('readonly', 'true');
        $('#transaksi_detail_jumlah').attr('readonly', 'true');
        $('#identitas_nama').attr('readonly', 'true');
        $('#transaksi_detail_keterangan').attr('readonly', 'true');
        $('#transaksi_detail_tgl_pengajuan').attr('readonly', 'true');
        $('#transaksi_detail_deskripsi_parameter').attr('readonly', 'true');
        $('#transaksi_detail_catatan').attr('readonly', 'true');
        $('#template_logsheet_id').attr('disabled', true);
        $('#div_template_logsheet').hide();
        $('#div_file_excel').hide();
        $('#div_file_excel_baris').hide();
        $('#cara_close_id').attr('disabled', true);
        $('#div_cara_close').hide();

        if (val.transaksi_detail_status == '6') {
          $('#belum_diterima').css('display', 'inline-block');
          $('#diterima').css('display', 'inline-block');
          $('#transaksi_detail_jumlah').attr('readonly', true);
          $('#transaksi_detail_parameter').attr('readonly', false);
          $('#transaksi_detail_deskripsi_parameter').attr('readonly', false);
        } else if (val.transaksi_detail_status == '7') {
          $('#tunda').css('display', 'inline-block');
          $('#progress').css('display', 'inline-block');
        } else if (val.transaksi_detail_status == '8') {
          $('#div_logsheet').css('display', 'inline-block');
          $('#template_logsheet_id').removeAttr('disabled');
          $('#sample_log').css('display', 'inline-block');
          $('#tunda').css('display', 'inline-block');
          $('#div_template_logsheet').show();
          $('#div_file_excel').show();
          $('#div_file_excel_baris').show();
          $('#template_logsheet_id').removeAttr('disabled', true)
          $('#div_cara_close').show();
          $('#cara_close_id').removeAttr('disabled', true)
        } else if (val.transaksi_detail_status == '9') {
          $('#tunda').css('display', 'inline-block');
          $('#terbit_sertikat').css('display', 'inline-block');
        } else if (val.transaksi_detail_status == '10') {
          $('#tunda').css('display', 'inline-block');
        } else if (val.transaksi_detail_status == '12') {
          $('#progress').css('display', 'inline-block');
        } else if (val.transaksi_detail_status == '13') {
          $('#div_logsheet').css('display', 'inline-block');
          $('#template_logsheet_id').removeAttr('disabled');
          $('#sample_log').css('display', 'inline-block');
          $('#div_template_logsheet').show();
          $('#div_file_excel').show();
          $('#div_file_excel_baris').show();
          $('#template_logsheet_id').removeAttr('disabled', true)
          $('#div_cara_close').show();
          $('#cara_close_id').removeAttr('disabled', true)
        }
      });
    });
  });

  /* Ganti Template */
  function ganti_template(id) {
    $('#div_id_template_logsheet').show();
    $('#div_id_download_logsheet').show();
    $('#id_template_logsheet').val(id)
    $('#id_download_logsheet').val(id);
  }
  /* Ganti Template */

  /* Preview template */
  function preview_template(id) {
    window.open('<?= base_url('master/template_logsheet/preview_template/') ?>' + id, '_blank')
  }
  /* Preview template */

  /* Download template */
  function download_template(id) {
    window.open('<?= base_url('master/template_logsheet/download_excel/') ?>' + id, '_blank')
  }
  /* Download template */

  /* Fun Lihat */
  function fun_lihat(isi) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $('#document').remove();
        $('#div_document').append('<embed src="<?= base_url('document/') ?>' + isi + '#toolbar=0" frameborder="0" id="document" width="100%" style="height: -webkit-fill-available;"></embed>');
      }
    });
  }
  /* Fun Lihat */

  /* Kembali */
  function kembali_inbox() {
    Swal.fire({
      title: "Kembali Ke Inbox?",
      text: "Apakah Anda Yakin Kembali Ke Halaman Utama Inbox ?",
      icon: "danger",
      showCancelButton: true,
      confirmButtonColor: "#34c38f",
      cancelButtonColor: "#f46a6a",
      confirmButtonText: "Iya",
      cancelButtonText: "Tidak",
    }).then(function(result) {
      if (result.value) {
        location.href = '<?= base_url('sample/inbox/?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) ?>'
      }
    });
  }
  /* Kembali */

  /* Batalkan */
  $('#simpan_batal').on('click', function() {
    var data = new FormData($('#form_batal')[0]);
    data.append('transaksi_id', $('#transaksi_id').val());
    data.append('transaksi_detail_id', $('#transaksi_detail_id').val());
    data.append('transaksi_detail_id_temp', $('#transaksi_detail_id_temp').val());
    data.append('transaksi_non_rutin_id', $('#transaksi_non_rutin_id').val());
    data.append('transaksi_tipe', $('#transaksi_tipe').val());

    var url = '<?= base_url() ?>sample/inbox/insertBatal';

    if ($('#transaksi_batal_alasan').val() == '') {
      toastr.warning('Alasan Pembatalan Harus Diisi');
    } else {
      $.ajax({
        type: "POST",
        url: url,
        data: data,
        dataType: "HTML",
        contentType: false,
        processData: false,
        Cache: false,
        beforeSend: function(resppnse) {
          $('#belum_diterima').hide();
          $('#diterima').hide();
          $('#kembali').hide();
          $('#batal').hide();
        },
        success: function(response) {
          location.href = '<?= base_url('sample/inbox/?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) ?>'
        }
      });
    }
  });
  /* Batalkan */

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
              data: $('#form_inbox').serialize(),
              type: 'POST',
              dataType: 'html',
              beforeSend: function() {

              },
              success: function(isi) {
                location.href = '<?= base_url('sample/inbox/?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) ?>'
              }
            });
          })
        }
      }
    });
  });
  /* Belum Diterima*/

  /* Diterima */
  $('#diterima').on('click', function(event) {
    event.preventDefault();
    var data = new FormData($('#form_inbox')[0])
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
              data: data,
              type: 'POST',
              dataType: 'html',
              processData: false,
              contentType: false,
              beforeSend: function() {
                $('#belum_diterima').hide();
                $('#diterima').hide();
                $('#kembali').hide();
                $('#batal').hide();
              },
              success: function(isi) {
                location.href = "<?= base_url('sample/inbox/procesInbox?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) ?>&transaksi_id=" + $('#transaksi_id').val() + '&transaksi_status=' + $('#transaksi_status').val() + '&transaksi_detail_status=' + (parseInt($('#transaksi_detail_status').val()) + parseInt(1)) + '&transaksi_detail_id=' + $('#transaksi_detail_id').val();
              }
            });
          })
        }
      }
    });
  });
  /* Diterima */

  /* Tunda */
  $('#simpan_tunda').on('click', function(event) {
    var data = new FormData($('#form_tunda')[0]);
    data.append('transaksi_id', $('#transaksi_id').val());
    data.append('transaksi_detail_id_temp', $('#transaksi_detail_id_temp').val());
    data.append('transaksi_detail_id', $('#transaksi_detail_id').val());
    data.append('transaksi_detail_parameter', $('#transaksi_detail_parameter').val())
    data.append('transaksi_detail_jumlah', $('#transaksi_detail_jumlah').val())

    if ($('#transaksi_detail_status').val() == '7') {
      data.append('transaksi_detail_status', '12');
    } else if ($('#transaksi_detail_status').val() == '8') {
      data.append('transaksi_detail_status', '13');
    }

    var url = '<?= base_url() ?>sample/inbox/insertTunda';

    if ($('#transaksi_tunda_alasan').val() == '') {
      toastr.warning('Alasan Penundaan Harus Diisi');
    } else {
      $.ajax({
        type: "POST",
        url: url,
        data: data,
        dataType: "HTML",
        contentType: false,
        processData: false,
        Cache: false,
        success: function(response) {
          location.href = '<?= base_url('sample/inbox/?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) ?>'
        }
      });
    }
  })
  /* Tunda */

  /* On Progress */
  function fun_cara_close(idtd, idt, tsd, ts) {
    $('#cara_close_transaksi_detail_id_temp').val(idtd);
    $('#cara_close_transaksi_detail_id').val(idtd + '_1');
    $('#cara_close_transaksi_id').val(idt);
    $('#cara_close_transaksi_detail_status').val(tsd);
    $('#cara_close_transaksi_status').val(ts);
  }

  function fun_ganti_kode_close(id) {
    $.getJSON('<?= base_url('master/cara_close/getCaraCLose') ?>', {
      cara_close_id: id
    }, function(data) {
      $('#cara_close_kode').val(data.cara_close_kode);
    });
  }

  $('#form_cara_close').on('submit', function(e) {
    e.preventDefault();
    if ($('#cara_close_kode').val() == '') {
      toastr.warning('Cara Close Harus Dipilih');
    } else if ($('#cara_close_kode').val() == 'N') { //Non Latter
      var url = '<?= base_url('sample/inbox/insertClossedNonLetter') ?>';
      var data = new FormData($('#form_cara_close')[0]);
      data.append('transaksi_detail_id_temp', $('#cara_close_transaksi_detail_id_temp').val());
      data.append('transaksi_detail_id', $('#cara_close_transaksi_detail_id').val());
      data.append('transaksi_id', $('#cara_close_transaksi_id').val())
      data.append('transaksi_status', $('#transaksi_status').val());
      data.append('transaksi_tipe', $('#transaksi_tipe').val());
      data.append('transaksi_non_rutin_id', $('#transaksi_non_rutin_id').val());
      $.ajax({
        type: "POST",
        url: url,
        data: data,
        dataType: "HTML",
        processData: false,
        contentType: false,
        cache: false,
        success: function(response) {
          $('#close_cara_close').click();
          location.href = '<?= base_url('sample/inbox/?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) ?>'
        }
      });
    } else { // Single
      event.preventDefault();
      var data = new FormData($('#form_inbox')[0])
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
                data: data,
                type: 'POST',
                dataType: 'html',
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function() {
                  $('#loading_form').show();
                  $('#progress').hide();
                  $('#tunda').hide();
                },
                success: function(isi) {
                  location.href = "<?= base_url('sample/inbox/procesInbox?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) ?>&transaksi_id=" + $('#transaksi_id').val() + '&transaksi_status=' + $('#transaksi_status').val() + '&transaksi_detail_status=' + (parseInt($('#transaksi_detail_status').val()) + parseInt(1)) + '&transaksi_detail_id=' + $('#transaksi_detail_id').val();
                }
              });
            })
          }
        }
      });
    }
  })
  /* On Progress */

  /* Raw Data */
  $('#sample_log').on('click', function(e) {
    if ($('#template_logsheet_id').val() == null) {
      toastr.warning('Template Harus Dipilih')
    } else {
      if ($('#cara_close_id').val() == '3') {
        $('#modal_cara_close_letter').modal('show');
      } else {
        Swal.fire({
          title: "File Excel",
          text: "Pastikan Data Anda Sesuai Dengan Template Agar Excel Dapat Diolah",
          type: "info",
          showCancelButton: true,
          confirmButtonColor: "#34c38f",
          cancelButtonColor: "#f46a6a",
          confirmButtonText: "Yakin",
          cancelButtonText: "Tidak",
        }).then(function(result) {
          if (result.value) {
            var data = new FormData($('#form_inbox')[0])
            var url = '<?= base_url('sample/inbox/insertDraftLogSheetExcel') ?>'
            $.ajax({
              url: url,
              type: 'POST',
              dataType: 'HTML',
              data: data,
              processData: false,
              contentType: false,
              cache: false,
              success: function(response) {
                console.log(response);
                if (response == 0) {
                  toastr.warning('Harap Upload File Excel Dengan Extensi yang ditentukan');
                } else {
                  location.href = response;
                }
              },
            })
          }
        })
      }
    }
  })

  /* Raw Data */

  /* Close Modal On Progress */
  function fun_close_cara_close() {
    $('#cara_close_nama').empty();
    $('#div_cara_close_sertifikat').hide();
    $('#form_cara_close')[0].reset();
    fun_loading();
  }
  /* Close Modal On Progress */

  /* Loading */
  function fun_loading() {
    var simplebar = new Nanobar();
    simplebar.go(100);
  }
  /* Loading */
</script>