<script type="text/javascript">
  $(function() {
    var transaksi_id = $('#transaksi_id').val();
    var transaksi_detail_id = $('#transaksi_detail_id_temp').val();
    var transaksi_detail_status = $('#transaksi_detail_status').val();

    $.getJSON("<?= base_url('sample/request/getRequestDetail') ?>", {
      transaksi_id: transaksi_id,
      transaksi_detail_id: transaksi_detail_id,
      transaksi_detail_status: transaksi_detail_status
    }, function(json) {
      $.each(json, function(key, data) {
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
        // $('#template_logsheet_id').attr('disabled', true);
        $('#div_template_logsheet_' + key).hide();
        $('#cara_close_id').attr('disabled', true);
        $('#div_cara_close').hide();

        if (data.transaksi_detail_status == '6') {
          $('#belum_diterima').css('display', 'inline-block');
          $('#diterima').css('display', 'inline-block');
        } else if (data.transaksi_detail_status == '7') {
          $('#belum_diterima').css('display', 'none');
          $('#diterima').css('display', 'none');
          $('#tunda').css('display', 'inline-block');
          $('#progress').css('display', 'inline-block');
        } else if (data.transaksi_detail_status == '8') {
          $('#div_logsheet').css('display', 'inline-block');
          // $('#template_logsheet_id').removeAttr('disabled');
          $('#sample_log').css('display', 'inline-block');
          $('#tunda').css('display', 'inline-block');
          $('#div_template_logsheet_' + key).show();
          // $('.div_template_logsheet').show();
          // $('#template_logsheet_id').removeAttr('disabled', true)
          $('#div_cara_close').show();
          $('#cara_close_id').removeAttr('disabled', true)
        } else if (data.transaksi_detail_status == '9') {
          $('#tunda').css('display', 'inline-block');
          $('#terbit_sertikat').css('display', 'inline-block');
        } else if (data.transaksi_detail_status == '10') {
          $('#tunda').css('display', 'inline-block');
          $('#clossed').css('display', 'inline-block');
        }
      });
    });

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

    /* SELECT2 */
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

    $('#cara_close_nama').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url('master/cara_close/getCaraCLoseList?multiple=y') ?>',
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
    /* SELECT2 */
  });

  /* Ganti Template */
  function ganti_template(id) {
    $('#div_id_template_logsheet').show();
    $('#id_template_logsheet').val(id)
    $('#id_download_logsheet').val(id)
  }
  /* Ganti Template */

  /* Preview template */
  function preview_template(id) {
    window.open('<?= base_url('master/template_logsheet/preview_template/') ?>' + id, '_blank')
  }
  /* Preview template */

  /* Download template */
  function download_template(id) {
    window.open('<?= base_url('master/template_logsheet/download_excel_multiple/') ?>' + id, '_blank')
  }
  /* Download template */

  /* Batalkan */
  $('#simpan_batal').on('click', function() {
    var data = new FormData($('#form_batal')[0]);
    data.append('transaksi_id', $('#transaksi_id').val());
    data.append('transaksi_detail_id', $('#transaksi_detail_id_temp').val());

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

        },
        success: function(response) {
          location.href = '<?= base_url('sample/inbox/?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) ?>'
        }
      });
    }
  });
  /* Batalkan */

  /*proses cara close*/
  $('#form_cara_close').on('submit', function(e) {
    e.preventDefault();
    if ($('#cara_close_kode').val() == '') {
      toastr.warning('Cara Close Harus Dipilih');
    } else if ($('#cara_close_kode').val() == 'MN') { //Non Latter
      var url = '<?= base_url('sample/multi_sample/insertClossedMultiNonLetter') ?>';
      var data = new FormData($('#form_cara_close')[0]);
      data.append('transaksi_detail_id_temp', $('#cara_close_transaksi_detail_id_temp').val());
      data.append('transaksi_detail_id', $('#cara_close_transaksi_detail_id').val());
      data.append('transaksi_id', $('#cara_close_transaksi_id').val())
      data.append('transaksi_status', $('#transaksi_status').val());
      data.append('transaksi_tipe', $('#transaksi_tipe').val());
      data.append('transaksi_non_rutin_id', $('#transaksi_non_rutin_id').val());
      data.append('transaksi_detail_group', $('#transaksi_detail_group').val());
      $.ajax({
        type: "POST",
        url: url,
        data: data,
        dataType: "HTML",
        processData: false,
        contentType: false,
        cache: false,
        success: function(response) {
          // $('#close_cara_close').click();
          location.href = '<?= base_url('sample/multi_sample/?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) ?>'
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
                url: '<?= base_url('sample/multi_sample/insertProgress') ?>',
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
                  location.href = isi;
                }
              });
            })
          }
        }
      });
    }
  })
  /*proses cara close*/

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
              url: '<?= base_url('sample/multi_sample/insertDiterima') ?>',
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
                location.href = isi;
                // location.href = "<?= base_url('sample/multi_sample/procesMulti?') . 'header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id'] ?>&transaksi_status=" + '7' + "&" + $('#form_inbox').serialize();
              }
            });
          })
        }
      }
    });
  });
  /* Diterima */

  $('#sample_log').on('click', function(e) {
    if ($('#template_logsheet_id').val() == null) {
      toastr.warning('Template Harus Dipilih')
    } else {
      if ($('#cara_close_id').val() == '3') {
        $('#modal_cara_close_letter').modal('show');
      } else {
        Swal.fire({
          title: "File Excel",
          text: "Pastikan Data Anda Sesuai Dengan Template Agar Dapat Diolah",
          type: "info",
          showCancelButton: true,
          confirmButtonColor: "#34c38f",
          cancelButtonColor: "#f46a6a",
          confirmButtonText: "Yakin",
          cancelButtonText: "Tidak",
        }).then(function(result) {
          if (result.value) {
            var data = new FormData($('#form_inbox')[0])
            var url = '<?= base_url('sample/multi_sample/insertDraftLogSheetExcel') ?>'
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


  /*raw data*/

  /*fungsi tombol*/
  function fun_cara_close(id, status) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $('#id_transaksi_rutin').val(id);
        $('#is_multiple').val('y');
        $('#status_transaksi').val(status)
        $('#simpan_cara_close_multiple').show();
        $('#simpan_cara_close').hide();
      }
    })
  }

  function fun_ganti_kode_close(id) {
    $.getJSON('<?= base_url('master/cara_close/getCaraCLose') ?>', {
        cara_close_id: id
      },
      function(data, textStatus, jqXHR) {
        $('#cara_close_kode').val(data.cara_close_kode);
      });
  }
  /*fungsi tombol*/
</script>