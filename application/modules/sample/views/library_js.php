<script type="text/javascript">
  $(function() {

    <?php
    if (isset($_GET['transaksi_id'])) {
    ?>
      var url = "<?= base_url() ?>sample/library/getLibrary?transaksi_id=<?= $_GET["transaksi_id"] ?>" + "&jenis_id=<?= $_GET['jenis_id'] ?>";

      var transaksi_id = "<?= $_GET['transaksi_id'] ?>";
      var jenis_id = "<?= $_GET['jenis_id'] ?>";

      $('#transaksi_id').val(transaksi_id);
      $('#jenis_id').val(jenis_id);
    <?php
    } else {
    ?>
      var url = "<?= base_url() ?>sample/library/getLibrary?tanggal_cari_awal=<?= date('Y-m-01') ?>&tanggal_cari_akhir=<?= date('Y-m-t') ?>"
    <?php
    }
    ?>

    fun_loading();

    /* Isi Table */
    $('#table thead tr').clone(true).addClass('filters').appendTo('#table thead');
    $('#table').DataTable({
      orderCellsTop: true,
      initComplete: function() {
        $('.dataTables_scrollHead').on('scroll', function() {
          $('.dataTables_scrollBody').scrollLeft($(this).scrollLeft());
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
      // "fixedHeader": true,
      "scrollX": true,
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
      "columns": [{
          render: function(data, type, full, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        {
          "data": "transaksi_detail_tgl_pengajuan_baru"
        },
        {
          "render": function(data, type, full, meta) {
            return (full.transaksi_nomor) ? full.transaksi_nomor : '-';
          }
        },
        {
          "render": function(data, type, full, meta) {
            return (full.transaksi_detail_nomor_sample) ? full.transaksi_detail_nomor_sample : '-';
          }
        },
        {
          "render": function(data, type, full, meta) {
            var jenis = '';
            var warna = '';
            if (full.transaksi_tipe == 'E') {
              jenis = 'Eksternal';
              warna = '#00a65a';
            } else if (full.transaksi_tipe == 'I') {
              jenis = 'Internal';
              warna = '#f39c12';
            } else if (full.transaksi_tipe == 'R') {
              jenis = 'Rutin';
              warna = '#f56954';
            }
            return '<span class="badge" style="background-color: ' + warna + '">' + jenis + '</span>';
          }
        },
        {
          "render": function(data, type, full, meta) {
            var status = '';
            var warna = '';
            if (full.transaksi_detail_status == '0' && full.transaksi_tipe != 'R') {
              status = 'Draft';
              warna = '#e8d234';
            } else if (full.transaksi_detail_status == '0' && full.transaksi_tipe == 'R') {
              status = 'On Progress';
              warna = '#69c5e8';
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
              status = 'Tunda dan Close'; //Sample On Progress
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
            } else if (full.transaksi_detail_status == '16') {
              status = 'Send DOF';
              warna = '#c13333';
            } else if (full.transaksi_detail_status == '17') {
              status = 'Terbit Sertifikat';
              warna = '#e8d369';
            } else if (full.transaksi_detail_status == '18' && full.logsheet_id == null) {
              status = 'Closed Non Letter';
              warna = '#c13333';
            } else if (full.transaksi_detail_status == '18') {
              status = 'Closed';
              warna = '#c13333';
            }

            return '<span class="badge" style="background-color: ' + warna + '">' + status + '</span>';
          }
        },

        {
          "data": "peminta_jasa_nama"
        },
        {
          "data": "seksi_nama"
        },
        {
          "data": "transaksi_detail_no_surat"
        },
        {
          "data": "jenis_nama"
        },
        {
          "render": function(data, type, full, meta) {
            return (full.identitas_nama) ? full.identitas_nama : full.transaksi_detail_identitas;
          }
        },
        {
          "render": function(data, type, full, meta) {
            return (full.transaksi_detail_attach) ? '<center><a href="javascript:;" id="' + full.transaksi_detail_attach + '"  name="' + full.transaksi_nomor + '" title="Lihat" data-toggle="modal" data-target="#modal" onClick="fun_lihat(this.id,this.name)"><i class="fa fa-file" style="color: red"></i></a></center>' : '';
          }
        },
        {
          "render": function(data, type, full, meta) {
            return (full.transaksi_detail_file) ? '<center><a href="javascript:;" id="' + full.transaksi_detail_file + '" name="' + full.transaksi_nomor + '" title="Foto" data-toggle="modal" data-target="#modal_foto" onClick="fun_lihat_foto(this.id,this.name)"><i class="fa fa-image" style="color: peru"></i></a></center>' : '';
          }
        },
        {
          "render": function(data, type, full, meta) {
            // return '<center><a href="javascript:;" id="' + full.transaksi_id + '" title="Detail" data-toggle="modal" data-target="#modal_detail" name="' + full.transaksi_nomor + '" onclick="fun_detail(this.id, this.name)"><i class="fa fa-info"></i></a></center>';
            return '<center><ul class="navbar-nav ml-auto">' +
              '<li class="nav-item dropdown">' +
              '<a class="nav-link" data-toggle="dropdown" href="#">' +
              '<i class="fa fa-info"></i>' +
              '</a>' +
              '<div class="dropdown-menu dropdown-menu-md dropdown-menu-right">' +
              '<a href="javascript:;" class="dropdown-item" id="' + full.transaksi_id + '" title="Detail Surat" data-toggle="modal" data-target="#modal_detail" name="' + full.transaksi_nomor + '" onclick="fun_detail(this.id, this.name,`' + full.transaksi_detail_id + '`)"><i class="fas fa-envelope mr-2"></i>Detail Surat</a>' +
              '</a>' +
              '<div class="dropdown-divider"></div>' +
              // '<a href="javascript:;" class="dropdown-item" id="' + full.transaksi_id + '" title="Detail Progress" data-toggle="modal" data-target="#modal_detail_perjalanan" name="' + full.transaksi_nomor + '" onclick="fun_detail_perjalanan(this.id, this.name)"><i class="fas fa-search mr-2"></i> Detail Progress</a>' +
              '<a href="javascript:;" class="dropdown-item"id="' + full.id_non_rutin + '"  title="Detail Progress" data-toggle="modal" data-target="#modal_detail_perjalanan" name="' + full.transaksi_nomor + '" onclick="fun_detail_perjalanan(this.id, this.name,`' + full.jenis_id + '`,`' + full.transaksi_id + '`)"><i class="fas fa-search mr-2"></i>Detail Progress</a>' +
              '</a>' +
              '<div class="dropdown-divider"></div>' +
              '<a href="javascript:;" class="dropdown-item"id="' + full.transaksi_id + '"  title="History Log Sheet" data-toggle="modal" data-target="#modal_history_logsheet"  onclick="fun_detail_logsheet(this.id)"><i class="fas fa-history mr-2"></i>History Log Sheet</a>' +
              '</a>' +
              '</li>' +
              '</ul></center';
          }
        },

        <?php $session = $this->session->userdata();
        if ($session['role_id'] == '1' || $session['role_id'] == '79d5b34a78b48d85eb1b65249fca73704dc49665') { ?> {
            "render": function(data, type, full, meta) {
              return '<center><ul class="navbar-nav ml-auto">' +
                '<li class="nav-item dropdown">' +
                '<a class="nav-link" data-toggle="dropdown" href="#">' +
                '<i class="fa fa-trash" style="color:red"></i>' +
                '</a>' +
                '<div class="dropdown-menu dropdown-menu-md dropdown-menu-right">' +
                '<a href="javascript:;" class="dropdown-item" title="Batal Sample" data-toggle="modal" data-target="#modal_batal" onClick="fun_batal(`' + full.transaksi_id + '`,`' + full.transaksi_detail_id + '`,`' + full.id_non_rutin + '`,`' + full.transaksi_detail_status + '`,`' + full.transaksi_nomor + '`,`' + full.transaksi_detail_nomor_sample + '`,`' + full.transaksi_tipe + '`)"><i class="fa fa-times mr-2"></i> Batal Sample </a>' +
                '</a>' +
                '<div class="dropdown-divider"></div>' +
                '<a href="javascript:;" class="dropdown-item" title="Hapus Sample" data-toggle="modal" onClick="fun_hapus(`' + full.transaksi_id + '`,`' + full.transaksi_detail_id + '`,`' + full.id_non_rutin + '`,`' + full.transaksi_detail_status + '`,`' + full.transaksi_nomor + '`,`' + full.transaksi_detail_nomor_sample + '`,`' + full.transaksi_tipe + '`)"><i class="fas fa-trash mr-2"></i> Hapus Sample </a>' +
                '</a>' +
                '</li>' +
                '</ul></center';
            }
          },
        <?php } ?> {
          "render": function(data, type, full, meta) {
            return '<center><a href="<?= base_url('sample/notifikasi/print_qrcode/?transaksi_id=') ?>' + full.transaksi_id + '&jenis_id=' + full.jenis_id + '" target="_BLANK" id="' + full.transaksi_id + '" id="' + full.jenis_id + '"  title="QRCode"><i class="fa fa-qrcode" style="color: black;"></i></a></center>';
          }
        },
        // close
        {
          "render": function(data, type, full, meta) {
            if ((full.transaksi_detail_status == parseInt('17') || full.transaksi_detail_status == parseInt('13'))) {
              // if (full.transaksi_tipe == 'R') {
              //   return '<center><a href="javascript:;" title="Close Sample" data-toggle="modal" data-target="#modal_close_sample" onClick="fun_close_sample_rutin(`' + full.id_transaksi_rutin + '`,`' + full.transaksi_detail_status + '`,`' + full.transaksi_id + '`,`' + full.logsheet_id + '`,`' + full.id_template_logsheet + '`)"><i class="fa fa-book" style="color: red"></i></a></center>'
              // } else {
              return '<center><a href="javascript:;" id="' + full.transaksi_detail_id + '"  name="' + full.transaksi_detail_status + '" title="Close Sample" data-toggle="modal" data-target="#modal_close_sample" onClick="fun_close_sample(this.id,this.name,`' + full.transaksi_id + '`,`' + full.logsheet_id + '`,`' + full.id_template_logsheet + '`)"><i class="fa fa-book" style="color: red"></i></a></center>';
              // }
            } else {
              return '-';
            }
          }
        },
        {
          "render": function(data, type, full, meta) {
            if (full.logsheet_id != null && full.transaksi_detail_status == parseInt('18')) {
              return '<center><a href="javascript:;" id="' + full.transaksi_detail_id + '"  name="' + full.transaksi_detail_status + '" title="Cetak Konsep" onClick="fun_cetak_konsep(this.id,this.name,`' + full.transaksi_id + '`,`' + full.logsheet_id + '`,`' + full.id_template_logsheet + '`,`' + full.transaksi_tipe + '`)"><i class="fa fa-print" style="color: blue"></i></a></center>';
            } else {
              return '<center>-</center>';
            }
          }
        },
        <?php $session = $this->session->userdata();
        if ($session['role_id'] == '1' || $session['role_id'] == '79d5b34a78b48d85eb1b65249fca73704dc49665') { ?> {
            "render": function(data, type, full, meta) {
              if (full.transaksi_detail_status == parseInt('18')) {
                return '<center><a href="javascript:;" id="' + full.transaksi_detail_id + '"  name="' + full.transaksi_detail_status + '" title="Edit Surat" data-toggle="modal" data-target="#modal_edit_surat" onClick="fun_edit_surat(`' + full.transaksi_id + '`,`' + full.transaksi_detail_id + '`,`' + full.transaksi_detail_group + '`,`' + full.logsheet_id + '`)"><i class="fa fa-edit" style="color: green"></i></a></center>';
              } else {
                return '-';
              }
            }
          },
        <?php } ?>
        <?php $session = $this->session->userdata();
        if ($session['role_id'] == '1' || $session['role_id'] == '79d5b34a78b48d85eb1b65249fca73704dc49665') { ?> {
            "render": function(data, type, full, meta) {
              if (full.transaksi_detail_status >= parseInt('9') && full.transaksi_detail_status != parseInt('18')) {
                return '<center><a href="javascript:;" id="' + full.transaksi_detail_id + '"  name="' + full.transaksi_detail_status + '" title="Reset Logsheet" data-toggle="modal" data-target="#modal_reset_logsheet" onClick="fun_reset_logsheet(`' + full.transaksi_id + '`,`' + full.transaksi_detail_id + '`,`' + full.id_non_rutin + '`,`' + full.transaksi_detail_status + '`,`' + full.transaksi_nomor + '`,`' + full.transaksi_detail_nomor_sample + '`,`' + full.transaksi_tipe + '`)"><i class="fa fa-undo" style="color: red"></i></a></center>';
              } else {
                return '-';
              }
            }
          },
        <?php } ?>
        // close
      ]
    });
    /* Isi Table */

    /* Isi Table Detail */
    // $('#table_detail thead tr').clone(true).addClass('filters_detail').appendTo('#table_detail thead');
    $('#table_detail').DataTable({
      orderCellsTop: true,
      // initComplete: function() {
      //   var api = this.api();

      //   // For each column
      //   api
      //     .columns()
      //     .eq(0)
      //     .each(function(colIdx) {
      //       // Set the header cell to contain the input element
      //       var cell = $('.filters_detail th').eq(
      //         $(api.column(colIdx).header()).index()
      //       );
      //       var title = $(cell).text();
      //       $(cell).html('<input type="text" class="form-control" style="width:100%" placeholder="' + title + '" />');

      //       // On every keypress in this input
      //       $(
      //           'input',
      //           $('.filters_detail th').eq($(api.column(colIdx).header()).index())
      //         )
      //         .off('keyup change')
      //         .on('keyup change', function(e) {
      //           e.stopPropagation();

      //           // Get the search value
      //           $(this).attr('title', $(this).val());
      //           var regexr = '({search})'; //$(this).parents('th').find('select').val();

      //           var cursorPosition = this.selectionStart;
      //           // Search the column for that value
      //           api
      //             .column(colIdx)
      //             .search(
      //               this.value != '' ?
      //               regexr.replace('{search}', '(((' + this.value + ')))') :
      //               '',
      //               this.value != '',
      //               this.value == ''
      //             )
      //             .draw();

      //           $(this)
      //             .focus()[0]
      //             .setSelectionRange(cursorPosition, cursorPosition);
      //         });
      //     });
      // },
      "ordering": false,
      "scrollX": true,
      "ajax": {
        "url": "<?= base_url() ?>sample/library/getLibraryDetail?transaksi_id=0",
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
            } else if (full.transaksi_detail_status == '17') {
              status = 'Terbit Sertifikat';
              warna = '#c13333';
            } else if (full.transaksi_detail_status == '18') {
              status = 'Closed';
              warna = '#c13333';
            }
            return status;
          }
        },
        {
          "data": "transaksi_detail_tgl_estimasi_baru"
        },
        {
          "data": "jenis_nama"
        },
        {
          "data": "transaksi_detail_jumlah"
        },
        {
          "data": "identitas_nama"
        },
        {
          "render": function(data, type, full, meta) {
            if (full.transaksi_detail_agreement_keterangan != null) {
              return full.transaksi_detail_agreement_keterangan;
            } else {
              return full.transaksi_detail_reject_alasan;
            }
          }
        },
        {
          "data": "transaksi_detail_parameter"
        },
        {
          "data": "transaksi_detail_note"
        },
        {
          "data": "transaksi_detail_no_surat"
        },
        {
          "render": function(data, type, full, meta) {
            var petugas = '';
            if (full.transaksi_detail_status == '0') petugas = full.who_create;
            else if (full.transaksi_detail_status == '1') petugas = full.who_create;
            else if (full.transaksi_detail_status == '2') petugas = full.who_create;
            else if (full.transaksi_detail_status == '3') petugas = full.who_create;
            else if (full.transaksi_detail_status == '4') petugas = full.who_create;
            else if (full.transaksi_detail_status == '5') petugas = full.who_create;
            else if (full.transaksi_detail_status == '6') petugas = full.who_create;
            else if (full.transaksi_detail_status == '7') petugas = full.who_create;
            else if (full.transaksi_detail_status == '8') petugas = full.who_create;
            else if (full.transaksi_detail_status == '9') petugas = full.who_create;
            return petugas;
          }
        },
        {
          "render": function(data, type, full, meta) {
            return (full.transaksi_detail_status <= '4') ? '-' : full.disposisi
          }
        },
      ]
    });
    /* Isi Table Detail */

    /* isi table detail modal */
    $('#modal_table_detail').DataTable({
      "ajax": {
        "url": "<?= base_url('sample/library/getLibrary') ?>",
        "dataSrc": "",
      },
      "columns": [{
        "data": "jenis_nama"
      }, {
        "data": "transaksi_detail_jumlah"
      }, {
        "render": function(data, type, row, meta) {
          return row.transaksi_detail_identitas;
        }
      }, {
        "render": function(data, type, row, meta) {
          return row.transaksi_detail_deskripsi_parameter;
        }
      }, {
        "data": "transaksi_detail_parameter"
      }]
    })
    /* isi table detail modal */


    /* Isi Table History Logsheet */
    $('#table_history_logsheet').DataTable({
      "ajax": {
        "url": "<?= base_url() ?>sample/library/getHistoryLogSheet?sample_transaksi_id=0",
        "dataSrc": ""
      },
      "columns": [{
          "data": "history_logsheet_when"
        },
        // {
        //   "data": "rumus_nama"
        // },
        {
          "data": "sample_history_detail"
        },
        {
          "data": "sample_history_isi"
        },
        {
          "data": "sample_history_hasil"
        },
        {
          "data": "history_logsheet_who"
        }
      ]
    });
    /* Isi Table History Logsheet */


    /* Tanggal */
    $(".tanggal").daterangepicker({
      showDropdowns: true,
      singleDatePicker: true,
      locale: {
        format: 'DD-MM-YYYY'
      }
    });

    /* Tanggal */
    $(".tanggal2").daterangepicker({
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
    $('.select2').select2({
      placeholder: 'Pilih',
    });

    // tipe dokumen
    $('#typeId').select2({
      dropdownParent: $("#modal_edit_surat"),
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url('api_doc/dokumen_tipe/getDokumenTipeList?tipe=') ?>' + $('#transaksi_tipe').val() + '&code=SF',
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
    // tipe dokumen

    // template dokumen
    $('#templateId').select2({
      placeholder: 'Pilih Tipe Dokumen Dahulu',
    })

    $('#classId').select2({
      // dropdownParent: $("#modal_edit_surat"),
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url('master/klasifikasi_sample/getKlasifikasiSampleList') ?>',
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
    // template dokumen

    // drafter
    $('#drafterId').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url() ?>/api/user/getUserDOFList',
        dataType: 'json',
        type: 'GET',
        data: function(params) {
          var queryParameters = {
            param_search: params.term
          }
          return queryParameters;
        },
        cache: true,
      }
    })
    // drafter

    // reviewer
    $('#reviewerId').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url() ?>/api/user/getUserDOFAVPLabList',
        dataType: 'json',
        type: 'GET',
        data: function(params) {
          var queryParameters = {
            param_search: params.term
          }
          return queryParameters;
        }
      }
    })
    // reviewer

    // approver
    $('#approverId').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: 'http://10.14.41.130/test_digilab_v2/api/user/getUserVPAVPList',
        dataType: 'json',
        type: 'GET',
        data: function(params) {
          var queryParameters = {
            param_search: params.term
          }

          return queryParameters;
        }
      }
    })
    // approver

    // tujuan
    $('#tujuanId').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: 'http://10.14.41.130/test_digilab_v2/api/user/getUserLabList',
        dataType: 'json',
        type: 'GET',
        data: function(params) {
          var queryParameters = {
            param_search: params.term
          }

          return queryParameters;
        }
      }
    })
    // tujuan

    $('.select2-selection').css('height', '37px');
    $('.select2').css('width', '100%');
    /* Select2 */
  });

  $('.datetimepicker').datetimepicker({
    format: 'YYYY-MM-DD'
  })


  /* FIlter */
  $("#filter").on("submit", function(e) {
    e.preventDefault();
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $('#table').DataTable().ajax.url('<?= base_url() ?>sample/library/getLibrary?' + $('#filter').serialize()).load();
        fun_loading();
      }
    })
  });
  /* FIlter */

  function ganti_drafter_identitas(id) {
    $.getJSON("<?= base_url() ?>api/user/getUserList3", {
        user_nik_sap: id
      },
      function(data, textStatus, jqXHR) {
        $('#drafterPoscode').val(data.user_poscode);
        $('#drafterId').val(data.user_detail_id);
      }
    );
  }

  function ganti_reviewer_identitas(id) {
    $.getJSON("<?= base_url() ?>api/user/getUserList3", {
        user_nik_sap: id
      },
      function(data, textStatus, jqXHR) {
        $('#reviewerPoscode').val(data.user_poscode)
        $('#reviewerId').val(data.user_detail_id)
      }
    );
  }

  function ganti_approver_identitas(id) {
    $.getJSON("<?= base_url() ?>api/user/getUserList3", {
        user_nik_sap: id
      },
      function(data, textStatus, jqXHR) {
        $('#approverPoscode').val(data.user_poscode)
        $('#approverId').val(data.user_detail_id)
      }
    );
  }

  function ganti_tujuan_identitas(id) {
    $.getJSON("<?= base_url() ?>api/user/getUserList3", {
        user_nik_sap: id
      },
      function(data, textStatus, jqXHR) {
        $('#tujuanPoscode').val(data.user_poscode)
        $('#tujuanId').val(data.user_detail_id)
      }
    )
  };

  function func_change_template(id) {
    $('#templateId').empty();
    $('#templateId').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url('api_doc/dokumen_template/getDokumenTemplateList?typeId=') ?>' + id + '&tipe=' + $('#transaksi_tipe').val(),
        dataType: 'json',
        type: 'GET',
        data: function(params) {
          var queryParameters = {
            identitas_nama: params.term
          }

          return queryParameters;
        }
      }
    });

    $('.select2-selection').css('height', '37px');
    $('.select2').css('width', '100%');
  }

  function fun_lihat(isi) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        console.log(name);
        var judul = (name) ? name : '';
        $('#judul_lihat').html('Sample ' + judul);
        $('#document').remove();

        // $('#div_document').append('<iframe src="https://docs.google.com/viewer?url=<?= base_url('document/') ?>'+isi+'&embedded=true" frameborder="0" id="document" width="100%"></iframe>');
        $('#div_document').append('<embed src="<?= base_url('document/') ?>' + isi + '#toolbar=0" frameborder="0" id="document" width="100%" style="height: -webkit-fill-available;"></embed>');
      }
    })
  }

  function fun_lihat_foto(isi) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        console.log(name);
        var judul = (name) ? name : '';
        $('#judul_lihat_foto').html('Sample ' + judul);
        $('#document_foto').remove();

        // $('#div_document').append('<iframe src="https://docs.google.com/viewer?url=<?= base_url('document/') ?>'+isi+'&embedded=true" frameborder="0" id="document" width="100%"></iframe>');
        $('#div_document_foto').append('<embed src="<?= base_url('document/') ?>' + isi + '#toolbar=0" frameborder="0" id="document_foto" width="100%" style="height: -webkit-fill-available;"></embed>');
      }
    })
  }


  function fun_detail_perjalanan(id, nama, jenis, id_trans) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        var judul = (nama != null) ? nama : '';
        $('#judul_detail').html('Detail Surat ' + judul);
        $('#table_detail').DataTable().ajax.url('<?= base_url() ?>sample/library/getLibraryDetail?transaksi_non_rutin_id=' + id + '&jenis_id=' + jenis + '&transaksi_id=' + id_trans).load();
        setTimeout(function() {}, 500);
      }
    });
  }

  function fun_detail_logsheet(id, id_trans) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $('#table_history_logsheet').DataTable().ajax.url('<?= base_url() ?>sample/library/getHistoryLogSheet?sample_transaksi_id=' + id).load();
        setTimeout(function() {}, 500);
        // console.log();
      }
    });
  }

  function fun_detail(id, name, id_detail) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        setTimeout(function() {
          $('#' + id).parents('tr').attr('style', 'color: red')
        }, 500);

        $('#modal_table_detail').DataTable().ajax.url("<?= base_url('sample/library/getLibrary?transaksi_id=') ?>" + id + "&transaksi_detail_id=" + id_detail).load();

        $.getJSON('<?= base_url('sample/library/getLibrary') ?>', {
          transaksi_id: id,
          transaksi_detail_id: id_detail,
        }, function(json) {

          // console.log(json);

          $('#is_new').val(1);
          $('#transaksi_id').val(json.transaksi_id);
          $('#transaksi_non_rutin_id').val(json.transaksi_non_rutin_id);
          $('#transaksi_detail_id').val(json.transaksi_detail_id);
          $('#transaksi_tipe').val(json.transaksi_tipe);
          $('#transaksi_judul').val(json.transaksi_judul);
          $('#transaksi_drafter').val(json.drafter_nama);
          $('#transaksi_reviewer').val(json.reviewer_nama);
          $('#transaksi_approver').val(json.approver_nama);
          $('#transaksi_tujuan').val(json.tujuan_nama);
          $('#transaksi_detail_pic_pengirim').val(json.pic_nama);
          $('#transaksi_detail_ext_pengirim').val(json.transaksi_detail_ext_pengirim);
          $('#transaksi_detail_jumlah').val(json.transaksi_detail_jumlah);
          $('#transaksi_detail_tgl_pengajuan').val(json.transaksi_detail_tgl_pengajuan_baru);
          $('#transaksi_detail_tgl_memo').val(json.transaksi_detail_tgl_memo_baru);
          $('#transaksi_detail_no_memo').val(json.transaksi_detail_no_memo);
          $('#transaksi_detail_parameter').val(json.transaksi_detail_parameter);
          $('#transaksi_detail_note').val(json.transaksi_detail_note);
          $('#temp_transaksi_detail_foto').val(json.transaksi_detail_foto);
          $('#transaksi_detail_foto_sebelumnya').attr("src", '<?= base_url('document/') ?>' + json.transaksi_detail_foto);
          $('#peminta_jasa_id').val(json.peminta_jasa_nama);
          $('#jenis_id').val(json.jenis_nama)
          $('#jenis_pekerjaan_id').val(json.sample_pekerjaan_nama)
          $('#identitas_id').val(json.kode_klasifikasi);
          $('#transaksi_klasifikasi_id').val(json.klasifikasi_nama);
          $('#transaksi_kecepatan_tanggap').val(json.transaksi_kecepatan_tanggap);
          $('#transaksi_sifat').val(json.transaksi_sifat);

        });
      }
    });
  }

  // Edit
  function fun_edit(id, value) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        var judul = (value) ? value : '';
        $('#judul_edit').html('Edit Sample ' + judul);
        $('#transaksi_detail_id').val(id);
        $.getJSON('<?= base_url('sample/library/getLibraryEdit') ?>', {
          transaksi_detail_id: id
        }, function(result) {
          $('#transaksi_detail_note').val(result.transaksi_detail_note);
          $('#transaksi_detail_tgl_memo').val(result.transaksi_detail_tgl_memo);
          $('#transaksi_detail_no_memo').val(result.transaksi_detail_no_memo);
        })
      }
    })
  }

  // SUBMIT Edit

  $('#form_edit').on('submit', function(e) {
    e.preventDefault();
    $.getJSON('<?= base_url() ?>login/login/checkLogin', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $.ajax({
          type: "POST",
          url: "<?= base_url('sample/library/UpdateLibraryEdit') ?>",
          data: $('#form_edit').serialize(),
          dataType: "HTML",
          processData: false,
          // contentType: false,
          cache: false,
          beforeSend: function() {
            $('#edit').hide();
            $('#loading').show();
          },
          success: function(response) {
            toastr.success('Berhasil');
            $('#closed').click();
            fun_close();
          }
        });
      }
    })
  })

  // start user klik batal  {
  function fun_batal(id, detail, non_rutin, status, nomor, nomor_sample, tipe) {
    $('#judul_batal').html(nomor + ' - ' + nomor_sample);
    $('#transaksi_id_batal').val(id);
    $('#transaksi_detail_id_batal').val(detail + '_14');
    $('#transaksi_detail_id_temp_batal').val(detail);
    $('#transaksi_non_rutin_id_batal').val(non_rutin);
    $('#transaksi_detail_status_batal').val(status);
    $('#transaksi_tipe_batal').val(tipe);
    // }
    // })
  }

  $('#simpan_batal').on('click', function() {
    var data = new FormData();
    data.append('transaksi_id', $('#transaksi_id_batal').val());
    data.append('transaksi_detail_id', $('#transaksi_detail_id_batal').val());
    data.append('transaksi_detail_id_temp', $('#transaksi_detail_id_temp_batal').val());
    data.append('transaksi_non_rutin_id', $('#transaksi_non_rutin_id_batal').val());
    data.append('transaksi_tipe', $('#transaksi_tipe_batal').val());
    data.append('transaksi_batal_alasan', $('#transaksi_detail_reject_alasan_batal').val());

    var url = '<?= base_url() ?>sample/inbox/insertBatal';

    if ($('#transaksi_detail_reject_alasan_batal').val() == '') {
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
          $('#close_batal').hide();
          $('#simpan_batal').hide();
          $('#loading_batal').show();

        },
        success: function(response) {
          $('#close_batal').click();
          toastr.success('Berhasil Dibatalkan');
        }
      });
    }
  })

  function fun_close_batal() {
    $('#close_batal').show();
    $('#simpan_batal').show();
    $('#loading_batal').hide();
    $('#form_batal')[0].reset();
    $('#table').DataTable().ajax.reload();
  }

  $('#modal_batal').on('hidden.bs.modal', function(e) {
    fun_close_batal();
  });
  // finish user klik batal  }

  // start user klik hapus {
  function fun_hapus(id, detail, non_rutin, status, nomor, nomor_sample, tipe) {
    Swal.fire({
      title: "Hapus Sample ?",
      text: "Sample Akan Terhapus dan Hilang !",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#34c38f",
      cancelButtonColor: "#f46a6a",
      confirmButtonText: "Iya"
    }).then(function(result) {
      if (result.value) {
        $.get('<?= base_url('sample/request/deleteSampleDetail?transaksi_detail_id=') ?>' + detail, function(data) {
          $('#table').DataTable().ajax.reload(null, false);
          toastr.success('Berhasil Hapus');
        });
      }
    });

  }

  // $('#simpan_batal').on('click', function() {
  //   var data = new FormData();
  //   data.append('transaksi_id', $('#transaksi_id_batal').val());
  //   data.append('transaksi_detail_id', $('#transaksi_detail_id_batal').val());
  //   data.append('transaksi_detail_id_temp', $('#transaksi_detail_id_temp_batal').val());
  //   data.append('transaksi_non_rutin_id', $('#transaksi_non_rutin_id_batal').val());
  //   data.append('transaksi_tipe', $('#transaksi_tipe_batal').val());
  //   data.append('transaksi_batal_alasan', $('#transaksi_detail_reject_alasan_batal').val());

  //   var url = '<?= base_url() ?>sample/inbox/insertBatal';

  //   if ($('#transaksi_detail_reject_alasan_batal').val() == '') {
  //     toastr.warning('Alasan Pembatalan Harus Diisi');
  //   } else {

  //     $.ajax({
  //       type: "POST",
  //       url: url,
  //       data: data,
  //       dataType: "HTML",
  //       contentType: false,
  //       processData: false,
  //       Cache: false,
  //       beforeSend: function(resppnse) {
  //         $('#close_batal').hide();
  //         $('#simpan_batal').hide();
  //         $('#loading_batal').show();

  //       },
  //       success: function(response) {
  //         $('#close_batal').click();
  //       }
  //     });
  //   }
  // })

  // function fun_close_batal() {
  //   $('#close_batal').show();
  //   $('#simpan_batal').show();
  //   $('#loading_batal').hide();
  //   $('#form_batal')[0].reset();
  //   $('#table').DataTable().ajax.reload();
  // }

  // $('#modal_batal').on('hidden.bs.modal', function(e) {
  //   fun_close_batal();
  // });
  // finish user klik hapus  }

  function fun_close_sample(id, status, idt, il, itl) {
    if (status == '13') {
      $('#div_file_close').show()
    } else {
      $('#div_file_close').hide();
    }
    $.getJSON("<?= base_url() ?>sample/library/getDOFStatus", {
        transaksi_id: idt,
        transaksi_detail_id: id,
        transaksi_detail_status: status,
        logsheet_id: il,
        template_logsheet_id: itl,
      },
      function(data, textStatus, jqXHR) {
        if (data) {
          $('#transaksi_detail_nomor_close_sample').val(data.noStr);
        }
      }
    );
    $('#transaksi_detail_id_close_sample_temp').val(id);
    $('#transaksi_detail_id_close_sample').val(id + '_' + Date.now());
    $('#transaksi_id_close_sample').val(idt);
    $('#transaksi_detail_status_close_sample').val(status);
    $('#logsheet_id_close_sample').val(il);
  }

  function fun_close_sample_rutin(id_rutin, status, id_trans, id_logsheet, id_template) {
    if (status == '13') {
      $('#div_file_close').show()
    } else {
      $('#div_file_close').hide();
    }
    $.getJSON("<?= base_url() ?>sample/library/getDOFStatus", {
        // transaksi_id: id_rutin,
        transaksi_rutin_id: id_rutin,
        transaksi_detail_status: status,
        logsheet_id: id_logsheet,
        template_logsheet_id: id_template,
      },
      function(data, textStatus, jqXHR) {
        if (data) {
          $('#transaksi_detail_nomor_close_sample').val(data.noStr);
        }
      }
    );
    $('#transaksi_detail_id_close_sample_temp').val(id_rutin);
    $('#transaksi_detail_id_close_sample').val(id_rutin + '_' + Date.now());
    $('#transaksi_id_close_sample').val(id_trans);
    $('#transaksi_detail_status_close_sample').val(status);
    $('#logsheet_id_close_sample').val(id_logsheet);
    $('#transaksi_tipe_close').val('R');
  }

  $('#form_close_sample').on('submit', function(e) {
    e.preventDefault();
    if ($('#transaksi_detail_nomor_close_sample').val() == '') {
      toastr.warning('Nomor tidak boleh kosong');
    } else {
      var url = '';
      if ($('#transaksi_tipe_close').val() == 'R') {
        url = '<?= base_url() ?>sample/inbox/insertClossedRutin';
      } else {
        url = '<?= base_url() ?>sample/inbox/insertClossed';
      }
      data = new FormData($('#form_close_sample')[0]);
      data.append('transaksi_detail_id_temp', $('#transaksi_detail_id_close_sample_temp').val());
      data.append('transaksi_detail_id', $('#transaksi_detail_id_close_sample').val());
      data.append('transaksi_id', $('#transaksi_id_close_sample').val());
      data.append('transaksi_detail_status', $('#transaksi_detail_status_close_sample').val());
      data.append('transaksi_detail_nomor', $('#transaksi_detail_nomor_close_sample').val());
      // data.append('transaksi_detail_file', $('#transaksi_detail_file_close_sample').val());
      data.append('logsheet_id', $('#logsheet_id_close_sample').val());
      data.append('transaksi_detail_tgl_pengajuan', $('#transaksi_detail_tgl_pengajuan').val());
      jQuery.ajax({
        url: '<?= base_url() ?>sample/inbox/insertClossed',
        // url: url,
        type: 'POST',
        dataType: 'html',
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        complete: function(xhr, textStatus) {

        },
        success: function(data, textStatus, xhr) {
          $('#closed_sample').click();
        },
        error: function(xhr, textStatus, errorThrown) {
          //called when there is an error
        }
      });
    }
  })

  // fitur edit surat
  function fun_edit_surat(trans_id, trans_det_id, trans_det_group, log_id) {
    alert(trans_id);
    alert(trans_det_id);
    alert(trans_det_group);
    alert(log_id);
    $.getJSON('<?= base_url() ?>sample/library/getDOFIdentitas', {
        transaksi_id: trans_id,
        transaksi_detail_id: trans_det_id,
        transaksi_detail_group: trans_det_group,
        logsheet_id: log_id,
      },
      function(data, textStatus) {
        $('#typeId').append('<option selected value="' + data.tipe_id + '">' + data.document_type_name + '</option>');
        // $('#typeId').select2('data', {
        // id: data.tipe_id,
        // text: data.document_type_name,
        // });
        $('#typeId').select2({
          disabled: true,
        })
        $('#typeId').trigger('change');

        $('#templateId').append('<option selected value="' + data.template_id + '">' + data.document_template_name + '</option>');
        // $('#templateId').select2('data', {
        //   id: data.template_id,
        //   text: data.document_template_name,
        // });
        $('#templateId').select2({
          disabled: true,
        })
        $('#templateId').trigger('change');

        $('#classId').append('<option selected value="' + data.klasifikasi_id + '">' + data.klasifikasi_nama + '</option>');
        // $('#classId').select2('data', {
        //   id: data.klasifikasi_id,
        //   text: data.klasifikasi_nama,
        // });
        $('#classId').trigger('change');

        $('#category').val(data.kategori_id)
        $('#responseSpeed').val(data.kecepatan_tanggap);
        $('#title').val(data.judul);

        $('#drafterPoscode').val(data.drafter_poscode);
        $('#drafterId').append('<option selected value="' + data.drafter_id + '">' + data.drafter_nama + '</option>');
        // $('#drafterId').select2('data', {
        //   id: data.drafter_id,
        //   text: data.drafter_nama,
        // });
        $('#drafterId').trigger('change');


        var pecah_reviewer = data.reviewer_id.split(',');
        $.each(pecah_reviewer, function(index, val) {
          $.getJSON('<?= base_url('api/user/getUserById') ?>', {
            user_detail_id: val,
          }, function(data_pecah, status_pecah) {
            $('#reviewerPoscode').val(data_pecah.user_poscode);
            $('#reviewerId').append('<option selected value="' + data_pecah.user_detail_id + '">' + data_pecah.user_detail_name + '</option>');
          });
        })

        $('#approverPoscode').val(data.approver_poscode);
        $('#approverId').append('<option selected value="' + data.approver_id + '">' + data.approver_nama + '</option>');
        // $('#approverId').select2('data', {
        //   id: data.approver_id,
        //   text: data.approver_nama,
        // });
        $('#approverId').trigger('change');

        var pecah_tujuan = data.tujuan_id.split(',');
        $.each(pecah_tujuan, function(index, val) {
          $.getJSON('<?= base_url('api/user/getUserById') ?>', {
            user_detail_id: val,
          }, function(data_pecah, status_pecah) {
            $('#tujuanPoscode').val(data_pecah.user_poscode);
            $('#tujuanId').append('<option selected value="' + data_pecah.user_detail_id + '">' + data_pecah.user_detail_name + '</option>');
          });
        })

        var pecah_cc = data.cc_id.split(',');
        $.each(pecah_cc, function(index, val) {
          $.getJSON('<?= base_url('api/user/getUserById') ?>', {
            user_detail_id: val,
          }, function(data_pecah, status_pecah) {
            $('#ccPoscode').val(data_pecah.user_poscode);
            $('#ccId').append('<option selected value="' + data_pecah.user_detail_id + '">' + data_pecah.user_detail_name + '</option>');
          });
        })
      })
  }

  $('#simpan_edit_surat').on('click', function(e) {
    e.preventDefault();
    var data = new FormData($('#form_edit_surat')[0]);
    data.append('transaksi_id', $('#transaksi_id_edit_surat').val());
    data.append('transaksi_detail_id', $('#transaksi_detail_id_edit_surat').val());
    data.append('transaksi_detail_id_temp', $('#transaksi_detail_id_temp_edit_surat').val());
    data.append('transaksi_non_rutin_id', $('#transaksi_non_rutin_id_edit_surat').val());
    data.append('transaksi_tipe', $('#transaksi_tipe_edit_surat').val());
    data.append('logsheet_id', $('#logsheet_id_edit_surat').val());
    // data.append('transaksi_edit_surat_alasan', $('#transaksi_detail_reject_alasan_edit_surat').val());
    var url = '<?= base_url() ?>sample/inbox/insertEditSurat'
    console.log(data);
    $.ajax({
      type: "POST",
      url: url,
      data: data,
      dataType: "HTML",
      contentType: false,
      processData: false,
      Cache: false,
      beforeSend: function(resppnse) {
        $('#close_edit_surat').hide();
        $('#simpan_edit_surat').hide();
        $('#loading_edit_surat').show();
      },
      success: function(response) {
        $('#close_edit_surat').click();
        toastr.success('Berhasil Diedit');
      }
    });
  })

  function func_close_edit_surat() {
    $('#close_edit_surat').show();
    $('#simpan_edit_surat').show();
    $('#loading_edit_surat').hide();
    $('#form_edit_surat')[0].reset();
    $('#table').DataTable().ajax.reload();
  }

  $('#modal_edit_surat').on('hidden.bs.modal', function(e) {
    fun_close_batal();
  });
  // fitur edit surat

  // start user klik reset_logsheet  {
  function fun_reset_logsheet(id, detail, non_rutin, status, nomor, nomor_sample, tipe) {
    $('#judul_reset_logsheet').html(nomor + ' - ' + nomor_sample);
    $('#transaksi_id_reset_logsheet').val(id);
    $('#transaksi_detail_id_reset_logsheet').val(detail + '_8rev');
    $('#transaksi_detail_id_temp_reset_logsheet').val(detail);
    $('#transaksi_non_rutin_id_reset_logsheet').val(non_rutin);
    $('#transaksi_detail_status_reset_logsheet').val(status);
    $('#transaksi_tipe_reset_logsheet').val(tipe);
  }

  $('#simpan_reset_logsheet').on('click', function() {
    var data = new FormData();
    data.append('transaksi_id', $('#transaksi_id_reset_logsheet').val());
    data.append('transaksi_detail_id', $('#transaksi_detail_id_reset_logsheet').val());
    data.append('transaksi_detail_id_temp', $('#transaksi_detail_id_temp_reset_logsheet').val());
    data.append('transaksi_non_rutin_id', $('#transaksi_non_rutin_id_reset_logsheet').val());
    data.append('transaksi_tipe', $('#transaksi_tipe_reset_logsheet').val());
    data.append('transaksi_reset_logsheet_alasan', $('#transaksi_detail_reject_alasan_reset_logsheet').val());

    var url = '<?= base_url() ?>sample/inbox/insertReset';

    if ($('#transaksi_detail_reject_alasan_reset_logsheet').val() == '') {
      toastr.warning('Alasan Reset Harus Diisi');
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
          $('#close_reset_logsheet').hide();
          $('#simpan_reset_logsheet').hide();
          $('#loading_reset_logsheet').show();

        },
        success: function(response) {
          $('#close_reset_logsheet').click();
          toastr.success('Berhasil Direset');
        }
      });
    }
  })

  function fun_close_reset_logsheet() {
    $('#close_reset_logsheet').show();
    $('#simpan_reset_logsheet').show();
    $('#loading_reset_logsheet').hide();
    $('#form_reset_logsheet')[0].reset();
    $('#table').DataTable().ajax.reload();
  }

  $('#modal_reset_logsheet').on('hidden.bs.modal', function(e) {
    fun_close_batal();
  });

  // end fitur reset logsheet

  function fun_cetak_konsep(id, status, idt, il, itl, tipe) {
    if (tipe == 'R') {
      window.open('<?= base_url() ?>sample/nomor/cetakKonsepRutin?transaksi_detail_id=' + id + '&transaksi_detail_status=' + status + '&transaksi_id=' + idt + '&template_logsheet_id=' + itl + '&logsheet_id=' + il, '_BLANK');
    } else {
      window.open('<?= base_url() ?>sample/inbox/cetakKonsep?transaksi_detail_id=' + id + '&transaksi_detail_status=' + status + '&transaksi_id=' + idt + '&template_logsheet_id=' + itl + '&logsheet_id=' + il, '_BLANK');
    }
  }

  function fun_close() {
    $('#edit').show();
    $('#loading').hide();
    $('#form_edit')[0].reset();
    $('#table').DataTable().ajax.reload();
  }

  $('#modal_edit').on('hidden.bs.modal', function(e) {
    fun_close();
  });

  function fun_closed_sample() {
    $('#form_close_sample')[0].reset();
    $('#table').DataTable().ajax.reload();
  }

  $('#modal_close_sample').on('hidden.bs.modal', function(e) {
    fun_closed_sample();
  });


  /* Fun Loading */
  function fun_loading() {
    var simplebar = new Nanobar();
    simplebar.go(100);
  }
  /* Fun Loading */
</script>