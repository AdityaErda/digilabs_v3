<script>
  $(function() {

    $(document).ready(function() {

      var transaksi_id = $('#transaksi_id').val();
      var transaksi_detail_id = $('#transaksi_detail_id_temp').val();
      var transaksi_detail_status = $('#transaksi_detail_status').val();

      $.getJSON("<?= base_url('sample/request/getRequestDetail') ?>", {
          // transaksi_non_rutin_id: id,
          transaksi_id: transaksi_id,
          transaksi_detail_id: transaksi_detail_id,
          transaksi_detail_status: transaksi_detail_status
        },
        function(json, textStatus, jqXHR) {
          $.each(json, function(key, data) {
            console.log(key);
            // alert(key + ": " + data);
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
            $('#div_template_logsheet_' + key).hide();
            // $('.div_template_logsheet').hide();
            $('#cara_close_id').attr('disabled', true);
            $('#div_cara_close').hide();


            if (data.transaksi_detail_status == '6') {
              $('#belum_diterima').css('display', 'inline-block');
              $('#diterima').css('display', 'inline-block');
            } else if (data.transaksi_detail_status == '7') {
              $('#tunda').css('display', 'inline-block');
              $('#progress').css('display', 'inline-block');
            } else if (data.transaksi_detail_status == '8') {
              $('#div_logsheet').css('display', 'inline-block');
              $('#template_logsheet_id').removeAttr('disabled');
              $('#sample_log').css('display', 'inline-block');
              $('#tunda').css('display', 'inline-block');
              $('#div_template_logsheet_' + key).show();
              // $('.div_template_logsheet').show();
              $('#template_logsheet_id').removeAttr('disabled', true)
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
        })
    });


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

    $('.template_logsheet_id').select2({
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
      var data = new FormData($('#form_inbox')[0]);

      var gabung = '';

      $('input[name="transaksi_detail_id[]"]').each(function() {
        var cek = ('transaksi_detail_id[]=' + ($(this).val()));

        const url = cek.split('')
          .join('')
          .toLowerCase();

        // console.log(url);

        // console.log(cek);
      });


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
                cache: false,
                beforeSend: function() {

                },
                success: function(isi) {

                  location.href = "<?= base_url('sample/multi_sample/procesMulti?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) ?>&transaksi_id=" + $('#transaksi_id').val() + "&transaksi_status=" + $('#transaksi_status').val() + isi;

                  // location.href = "<?= base_url('sample/inbox/procesInbox?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) ?>&transaksi_id=" + $('#transaksi_id').val() + '&transaksi_status=' + $('#transaksi_status').val() + '&transaksi_detail_status=' + (parseInt($('#transaksi_detail_status').val()) + parseInt(1)) + '&transaksi_detail_id=' + $('#transaksi_detail_id').val();
                }
              });
            })
          }
        }
      });
    });
    /* Diterima */


    /* On Progress */
    $('#progress1').on('click', function(event) {
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
    });
    /* On Progress */

    // Sample Log
    $('#sample_log').on('click', function(e) {
      // if ($('.template_logsheet_id').val() == null) {
      //   toastr.warning('Template Harus Dipilih')
      // } else {
      //   var data = $('.template_logsheet_id').val();
      // console.log(data);
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

              // location.href = '<?= base_url('sample/multi_sample/procesLogSheet/?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) . '&transaksi_id=' . $_GET['transaksi_id'] ?>&' + $('#form_inbox').serialize();

              location.href = '<?= base_url('sample/multi_sample/procesLogSheet/?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) . '&transaksi_id=' . $_GET['transaksi_id'] ?>&jenis_id=' + $('.jenis_id').val();


            })
          }
        }
      })
    })


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
    $('#simpan_tunda').on('click', function(event) {
      var data = new FormData($('#form_tunda')[0]);
      data.append('transaksi_id', $('#transaksi_id').val());
      data.append('transaksi_detail_id', $('#transaksi_detail_id_temp').val());

      if ($('#transaksi_detail_status').val() == '7') {
        data.append('transaksi_detail_status', '12');
      } else if ($('#transaksi_detail_status').val() == '8') {
        data.append('transaksi_detail_status', '13');
      }

      data.append('transaksi_detail_parameter', $('#transaksi_detail_parameter').val())
      data.append('transaksi_detail_jumlah', $('#transaksi_detail_jumlah').val())

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
          beforeSend: function(resppnse) {

          },
          success: function(response) {
            location.href = '<?= base_url('sample/inbox/?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) ?>'
          }
        });
      }
    })
    /* Tunda */

    // Batal
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
    })
    // Batal
    /* Proses */
  })

  // Cara CLose
  // function fun_cara_close(idtd, idt, tsd, ts) {
  //   $('#cara_close_transaksi_detail_id_temp').val(idtd);
  //   $('#cara_close_transaksi_detail_id').val(idtd + '_1');
  //   $('#cara_close_transaksi_id').val(idt);
  //   $('#cara_close_transaksi_detail_status').val(tsd);
  //   $('#cara_close_transaksi_status').val(ts);
  // }

  function fun_cara_close(ti, ts) {
    $('#cara_close_transaksi_id').val(ti);
    $('#cara_close_transaksi_status').val(ts);
  }

  function fun_ganti_kode_close(id) {
    $.getJSON('<?= base_url('master/cara_close/getCaraCLose') ?>', {
        cara_close_id: id
      },
      function(data, textStatus, jqXHR) {
        $('#cara_close_kode').val(data.cara_close_kode);
        // if ($('#cara_close_kode').val() == 'N') {
        //   $('#div_cara_close_sertifikat').show();
        // } else {
        //   $('#div_cara_close_sertifikat').hide();
        // }
      });
  }

  $('#form_cara_close').on('submit', function(e) {
    e.preventDefault();
    if ($('#cara_close_kode').val() == '') {
      toastr.warning('Cara Close Harus Dipilih');
    } else if ($('#cara_close_kode').val() == 'MN') {
      var url = '<?= base_url('sample/multi_sample/insertClossedNonLetter') ?>';
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
          // location.href = '<?= base_url('sample/inbox/?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) ?>'
        }
      });
    } else {
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
                  console.log(isi);
                  location.href = "<?= base_url('sample/multi_sample/procesMulti?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) ?>&transaksi_id=" + $('#transaksi_id').val() + "&transaksi_status=" + $('#transaksi_status').val() + isi;

                  // location.href = "<?= base_url('sample/inbox/procesInbox?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) ?>&transaksi_id=" + $('#transaksi_id').val() + '&transaksi_status=' + $('#transaksi_status').val() + '&transaksi_detail_status=' + (parseInt($('#transaksi_detail_status').val()) + parseInt(1)) + '&transaksi_detail_id=' + $('#transaksi_detail_id').val();
                }
              });
            })
          }
        }
      });
    }
  })
  // Cara cLose


  // EXTRA
  function fun_loading() {
    var simplebar = new Nanobar();
    simplebar.go(100);
  }

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

  $('#modal_cara_close').on('hidden.bs.modal', function(e) {
    fun_cara_close();
  });


  function fun_close_cara_close() {
    $('#cara_close_nama').empty();
    $('#div_cara_close_sertifikat').hide();
    $('#form_cara_close')[0].reset();
    fun_loading();
  }


  function marquue(id) {
    var css = document.createElement('style');
    css.innerHTML = `
  @-webkit-keyframes marquee {
    0% {
      text-indent: 100%;
    }

    100% {
      text-indent: -70%
    }
  }

  input#` + id + ` {
    -webkit-animation: marquee 5s infinite;
    -webkit-animation-timing-function: linear;
  }`
    document.head.appendChild(css);
  }
  // EXTRA
</script>