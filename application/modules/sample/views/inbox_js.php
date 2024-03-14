<script type="text/javascript">
  $(function() {
    <?php
    if (isset($_GET['transaksi_id'])) {
    ?>
      var url = "<?= base_url() ?>sample/inbox/getInbox?transaksi_status=" + $('#transaksi_status').val() + "&id_transaksi=<?= $_GET["transaksi_id"] ?>";
      var id_transaksi = "<?= $_GET['transaksi_id'] ?>";
      $('#id_transaksi').val(id_transaksi);
    <?php
    } else {
    ?>
      var url = "<?= base_url() ?>sample/inbox/getInbox?transaksi_status=" + $('#transaksi_status').val();
    <?php
    }
    ?>

    fun_loading();
    /* Isi Table */
    $('#table thead tr').clone(true).addClass('filters').appendTo('#table thead');

    $('#table').DataTable({
      "scrollX": true, // Enable horizontal scrolling
      "scrollCollapse": true,
      // "paging": false,
      fixedColumns: {
        leftColumns: 4,
      },
      "lengthMenu": [
        [5, 10, 25, 50, -1],
        [5, 10, 25, 50, "All"]
      ],

      "dom": 'lBfrtip',
      "buttons": ["csv", "pdf", "excel", "copy", "print"],
      "ajax": {
        "url": url,
        "dataSrc": ""
      },
      "fnRowCallback": function(data, type, full, meta) {
        if (type['is_urgent'] == 'y') $('td', data).css('background-color', 'Yellow');
      },
      orderCellsTop: true,
      initComplete: function() {
        $('.dataTables_scrollHead').on('scroll', function() {
          $('.dataTables_scrollBody').scrollLeft($(this).scrollLeft());
          $('.DTFC_LeftBodyWrapper').css('top', '15px');

        });
        var api = this.api();

        // For each column
        api
          .columns()
          .eq(0)
          .each(function(colIdx) {
            // Set the header cell to contain the input element
            var cell = $('.filters th').eq(
              $(api.column(colIdx).header()).index()
            );
            var title = $(cell).text();
            $(cell).html('<input type="text" class="form-control" style="width:100%" placeholder="' + title + '" />');

            // On every keypress in this input
            $(
                'input',
                $('.filters th').eq($(api.column(colIdx).header()).index())
              )
              .off('keyup change')
              .on('keyup change', function(e) {
                e.stopPropagation();

                // Get the search value
                $(this).attr('title', $(this).val());
                var regexr = '({search})'; //$(this).parents('th').find('select').val();

                var cursorPosition = this.selectionStart;
                // Search the column for that value
                api
                  .column(colIdx)
                  .search(
                    this.value != '' ?
                    regexr.replace('{search}', '(((' + this.value + ')))') :
                    '',
                    this.value != '',
                    this.value == ''
                  )
                  .draw();

                $(this)
                  .focus()[0]
                  .setSelectionRange(cursorPosition, cursorPosition);
              });
          });
      },
      "fixedHeader": true,
      "columns": [{
          render: function(data, type, full, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        {
          "data": "transaksi_nomor"
        },
        {
          "data": "transaksi_detail_nomor_sample"
        },
        {
          "data": "jenis_nama"
        },
        {
          render: function(data, type, full, meta) {
            return (full.transaksi_tipe == 'E') ? 'External' : 'Internal';
          }
        },

        {
          "data": "peminta_jasa_nama"
        },
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
            } else if (full.transaksi_detail_status == '7') {
              status = 'Sample Diterima';
              warna = '#69e8aa';
            } else if (full.transaksi_detail_status == '8') {
              status = 'On Progress';
              warna = '#69c5e8';
            } else if (full.transaksi_detail_status == '9') {
              status = 'Draft Log Sheet';
              warna = '#e8d369';
            } else if (full.transaksi_detail_status == '10' && full.is_approve == 'y') {
              status = 'Menunggu Send DOF';
              warna = '#e8d369';
            } else if (full.transaksi_detail_status == '10' && full.logsheet_review != null) {
              status = 'Menunggu Approve Kasie';
              warna = '#e8d369';
            } else if (full.transaksi_detail_status == '10' && full.logsheet_analisis != null) {
              status = 'Menunggu Review Kasie';
              warna = '#e8d369';
            } else if (full.transaksi_detail_status == '10') {
              status = 'Menunggu Kirim Analisis';
              warna = '#e8d369';
            } else if (full.transaksi_detail_status == '11') {
              status = 'Review Kasie';
              warna = '#79724d';
            } else if (full.transaksi_detail_status == '12') {
              status = 'Tunda'; //Sample Diterima
              warna = ' #f37b2d';
            } else if (full.transaksi_detail_status == '13') {
              status = 'Tunda'; //Sample On Progress
              warna = ' #f37b2d';
            } else if (full.transaksi_detail_status == '14') {
              status = 'Batal';
              warna = 'red';
            } else if (full.transaksi_detail_status == '15') {
              status = 'Reject';
              warna = '#c13333';
            } else if (full.transaksi_detail_status == '16') {
              status = 'Send DOF';
              warna = '#c13333';
            } else if (full.transaksi_detail_status == '17') {
              status = 'Terbit Sertifikat';
              warna = '#c13333';
            } else if (full.transaksi_detail_status == '18') {
              status = 'Closed';
              warna = '#c13333';
            }

            return '<span class="badge" style="background-color: ' + warna + '">' + status + '</span>';
          }
        },
        {
          "render": function(data, type, full, meta) {
            if (full.transaksi_detail_status < parseInt('5') || full.transaksi_detail_status == parseInt('4') || full.transaksi_detail_status == parseInt('17') || full.transaksi_detail_status == parseInt('18') || full.transaksi_detail_status == parseInt('14')) {
              return '<center>-</center>';
            } else if (full.transaksi_detail_status == parseInt('8') && full.kasie == 'n' && full.petugas == 'y') {
              return '<center><a href="javascript:void(0);" data-target="#modal_cara_close" data-toggle="modal" title="Proses" id="' + full.transaksi_detail_id + '" onclick="fun_cara_close(this.id,`' + full.transaksi_id + '`,`' + full.transaksi_detail_status + '`,`' + full.transaksi_status + '`)"><i class="fa fa-share" style="color: green;"></i></a></center>';
            } else if ((full.transaksi_detail_status == parseInt('9')) && full.kasie == 'n' && full.petugas == 'y') {
              return '<center><a href="<?= base_url('sample/inbox/procesLogSheet/?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) ?>&transaksi_id=' + full.transaksi_id + '&transaksi_detail_id=' + full.transaksi_detail_id + '&transaksi_detail_status=' + full.transaksi_detail_status + '&template_logsheet_id=' + full.id_template_logsheet + '&logsheet_id=' + full.logsheet_id + '&transaksi_non_rutin_id=' + full.id_non_rutin + '" title="Proses"><i class="fa fa-share" style="color: green;"></i></a></center>';
            } else if (full.transaksi_detail_status == parseInt('9') && full.kasie == 'n' && full.petugas == 'n') {
              return '<center>-</center>';
            } else if ((full.transaksi_detail_status == parseInt('10') || full.transaksi_detail_status == parseInt('11')) && full.kasie == 'y') {
              return '<center><a href="<?= base_url('sample/inbox/reviewLogSheet/?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) ?>&transaksi_id=' + full.transaksi_id + '&transaksi_detail_id=' + full.transaksi_detail_id + '&transaksi_detail_status=' + full.transaksi_detail_status + '&template_logsheet_id=' + full.id_template_logsheet + '&logsheet_id=' + full.logsheet_id + '&transaksi_non_rutin_id=' + full.id_non_rutin + '" title="Proses"><i class="fa fa-share" style="color: green;"></i></a></center>';
            } else if ((full.transaksi_detail_status == parseInt('10')) && full.kasie == 'n' && full.petugas == 'y' && full.logsheet_analisis == null) {
              return '<center><a href="<?= base_url('sample/inbox/draftLogSheet/?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) ?>&transaksi_id=' + full.transaksi_id + '&transaksi_detail_id=' + full.transaksi_detail_id + '&transaksi_detail_status=' + full.transaksi_detail_status + '&template_logsheet_id=' + full.id_template_logsheet + '&logsheet_id=' + full.logsheet_id + '&transaksi_non_rutin_id=' + full.id_non_rutin + '" title="Proses"><i class="fa fa-share" style="color: green;"></i></a></center>';
            } else if (full.transaksi_detail_status == parseInt('10') && full.kasie == 'n') {
              return '<center>-</center>';
            // } else if (full.kasie == 'y' || full.petugas == 'n') {
            //   return '<center>-</center>';
            } else {
              return '<center><a href="<?= base_url('sample/inbox/procesInbox?') . 'header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id'] ?>&transaksi_id=' + full.transaksi_id + '&transaksi_status=' + full.transaksi_status + '&transaksi_detail_status=' + full.transaksi_detail_status + '&transaksi_detail_id=' + full.transaksi_detail_id + '" id="' + full.transaksi_id + '" title="Proses"><i class="fa fa-share" style="color: green;"></i></a></center>';
            }
          }
        },
        {
          "render": function(data, type, full, meta) {
            return '<center><a href="javascript:;" id="' + full.id_non_rutin + '" title="Detail" data-toggle="modal" data-target="#modal_detail" name="' + full.transaksi_nomor + '" onclick="fun_detail(this.id,this.name,`' + full.jenis_id + '`,`' + full.transaksi_id + '`)"><i class="fa fa-search"></i></a></center>';
          }
        },
        {
          "render": function(data, type, full, meta) {
            return '<center><a href="<?= base_url('sample/notifikasi/print_qrcode/?transaksi_id=') ?>' + full.transaksi_id + '&jenis_id=' + full.jenis_id + '" target="_BLANK" id="' + full.transaksi_id + '" id="' + full.jenis_id + '" title="QRCode"><i class="fa fa-qrcode" style="color: black;"></i></a></center>';
          }
        },

        {
          "render": function(data, type, full, meta) {
            return (full.transaksi_detail_status == '6') ? '<center><a href="javascript:;" id="' + full.transaksi_id + '"  title="Alihkan" onclick="fun_alihkan(this.id,`' + full.transaksi_detail_id + '`,`' + full.id_non_rutin + '`,`' + full.transaksi_tipe + '`,`' + full.transaksi_detail_nomor_sample + '`)"><i class="fa fa-undo" data-toggle="modal" data-target="#modal_alihkan" style="color: aqua;"></i></a></center>' : '';
          }
        }
        // {
        //   "render": function(data, type, full, meta) {
        //     return '<center><a href="javascript:;" id="' + full.transaksi_id + '" title="History" onclick="fun_history(this.id)"><i class="fa fa-history" data-toggle="modal" data-target="#modal_history" style="color: green;"></i></a></center>';
        //   }
        // },
      ]
    }).columns.adjust().fixedColumns().relayout();
    /* Isi Table */

    /* Isi Table Detail */
    $('#table_detail').DataTable({
      "ordering": false,
      "ajax": {
        "url": "<?= base_url() ?>sample/inbox/getInboxDetail?transaksi_id=0",
        "dataSrc": ""
      },
      "columns": [{
          "data": "when_create_baru"
        },
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
            } else if (full.transaksi_detail_status == '7') {
              status = 'Sample Diterima';
              warna = '#69e8aa';
            } else if (full.transaksi_detail_status == '8') {
              status = 'On Progress';
              warna = '#69c5e8';
            } else if (full.transaksi_detail_status == '9') {
              status = 'Draft Log Sheet';
              warna = '#e8d369';
            } else if (full.transaksi_detail_status == '10' && full.is_approve == 'y') {
              status = 'Menunggu Send DOF';
              warna = '#e8d369';
            } else if (full.transaksi_detail_status == '10' && full.logsheet_review != null) {
              status = 'Menunggu Approve Kasie';
              warna = '#e8d369';
            } else if (full.transaksi_detail_status == '10' && full.logsheet_analisis != null) {
              status = 'Menunggu Review Kasie';
              warna = '#e8d369';
            } else if (full.transaksi_detail_status == '10') {
              status = 'Menunggu Kirim Analisis';
              warna = '#e8d369';
            } else if (full.transaksi_detail_status == '11') {
              status = 'Review Kasie';
              warna = '#79724d';
            } else if (full.transaksi_detail_status == '12') {
              status = 'Tunda'; //Sample Diterima
              warna = ' #f37b2d';
            } else if (full.transaksi_detail_status == '13') {
              status = 'Tunda'; //Sample On Progress
              warna = ' #f37b2d';
            } else if (full.transaksi_detail_status == '14') {
              status = 'Batal';
              warna = 'red';
            } else if (full.transaksi_detail_status == '15') {
              status = 'Reject';
              warna = '#c13333';
            }
            return status;
          }
        }, {
          "data": "transaksi_detail_tgl_estimasi_baru"
        },
        {
          "render": function(data, type, full, meta) {
            return (full.transaksi_detail_status <= '4') ? '-' : full.disposisi
          }
        }, {
          "data": "who_create"
        },
      ]
    });
    /* Isi Table Detail */

    // Isi Table History
    $('#table_history').DataTable({
      "ordering": false,
      "ajax": {
        "url": "<?= base_url('sample/inbox/getHistory') ?>",
        "dataSrc": ""
      },
      "columns": [{
        "data": "seksi_asal",
      }, {
        "data": "seksi_tujuan",
      }, {
        "data": "seksi_disposisi_history_alasan"
      }, {
        "data": "who_create"
      }, {
        "data": "when_create"
      }]
    })
    // Isi Table History

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
    $('#cara_close_nama').select2({
      dropdownParent: $("#modal_cara_close"),
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


    // $('.select2').select2({
    //   placeholder: 'Pilih',
    // });

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
  });

  $('.datetimepicker').datetimepicker({
    format: 'YYYY-MM-DD'
  });

  /* FIlter */
  $('#filter').on('submit', function(e) {
    e.preventDefault();
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $('#table').DataTable().ajax.url('<?= base_url() ?>sample/inbox/getInbox?transaksi_status=' + $('#transaksi_status').val() + '&' + $('#filter').serialize()).load();
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
  function fun_proses(id) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $.getJSON('<?= base_url('sample/request/getRequestDashboard?isi=ok') ?>', {
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

  /* Diterima */
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
  /* Diterima */

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
  function fun_detail(id, nama, jenis, id_trans) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        var judul = (nama != null) ? nama : '';
        $('#judul_detail').html('Detail Sample ' + judul);
        $('#table_detail').DataTable().ajax.url('<?= base_url() ?>sample/inbox/getInboxDetail?transaksi_non_rutin_id=' + id + '&jenis_id=' + jenis + '&transaksi_id=' + id_trans).load();
        setTimeout(function() {
          // $('#' + id).parents('tr').attr('style', 'color: red')
        }, 500);
      }
    });
  }

  // Tombol Alihkan
  function fun_alihkan(id, idx, idr, ids) {
    $('#id_transaksi_alihkan').val(id);
    $('#id_transaksi_detail_alihkan').val(idx);
    $('#id_non_rutin_alihkan').val(idr);
    $('#transaksi_detail_nomor_sample').val(ids)
    $('#loading_form_alihkan').hide();
    $('#simpan_alihkan').show();
  }
  // Tombol Alihkan

  // Proses Pengalihan
  $('#form_modal_alihkan').on('submit', function(e) {
    e.preventDefault();
    var data = new FormData(this);
    if ($('#alasan_alihkan').val() == '') {
      $('#alert_alasan_alihkan').show();
    } else {
      $('#alert_alasan_alihkan').hide();
    }
    if ($('#alasan_alihkan').val() != '') {
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

  // history pengaliahan
  function fun_history(id) {
    $('#table_history').DataTable().ajax.url('<?= base_url('sample/inbox/getHistory?id_transaksi=') ?>' + id).load();
  }
  // history pengaliahan

  // Cara CLose
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
    } else if ($('#cara_close_kode').val() == 'N') {
      // if ($('#transaksi_detail_nomor').val() == '') {
      //   toastr.warning('Nomor Harus Diisi');
      // } else {
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
          $('#table').DataTable().ajax.reload(null, false);
        }
      });
      // }
    } else {
      location.href = "<?= base_url('sample/inbox/procesInbox?') . 'header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id'] ?>&transaksi_id=" + $('#cara_close_transaksi_id').val() + "&transaksi_status=" + $('#cara_close_transaksi_status').val() + "&transaksi_detail_status=" + $('#cara_close_transaksi_detail_status').val() + "&transaksi_detail_id=" + $('#cara_close_transaksi_detail_id_temp').val();
    }
  })
  // Cara cLose

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
    $('#form_modal_alihkan')[0].reset();
    $('#table').DataTable().ajax.reload(null, false);
    fun_loading();
  }

  function fun_close_cara_close() {
    $('#cara_close_nama').empty();
    $('#div_cara_close_sertifikat').hide();
    $('#form_cara_close')[0].reset();
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

  $('#modal_cara_close').on('hidden.bs.modal', function(e) {
    fun_close_cara_close();
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