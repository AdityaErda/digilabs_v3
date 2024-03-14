<script type="text/javascript">
  $(function() {
    fun_loading();
    /* Isi Table */
    $('#table thead tr').clone(true).addClass('filters').appendTo('#table thead');
    var table = $('#table').DataTable({
      orderCellsTop: true,
      initComplete: function() {
        $("#table").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");
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
      //      "autoWidth": true,
      // "scrollX": true,
      "ordering": true,
      "lengthMenu": [
        [5, 10, 25, 50, -1],
        [5, 10, 25, 50, "All"]
      ],
      "dom": 'lBfrtip',
      "buttons": ["csv", "pdf", "excel", "copy", "print"],
      "ajax": {
        "url": "<?= base_url() ?>sample/request/getRequestMain?",
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
          "render": function(data, type, full, meta) {
            return (full.transaksi_tipe == 'E') ? 'Eksternal' : 'Internal'
          }
        },
        {
          "data": "transaksi_detail_tgl_pengajuan_baru"
        },
        {
          "data": "peminta_jasa_nama"
        },
        {
          "data": "transaksi_judul"
        },
        {
          "render": function(data, type, full, meta) {
            var status = '';
            if (full.transaksi_status == '0') {
              status = 'Draft';
            } else if (full.transaksi_status == '1') {
              status = 'Pengajuan';
            } else if (full.transaksi_status == '2') {
              status = 'Review AVP Peminta Jasa';
            } else if (full.transaksi_status == '3') {
              status = 'Approve VP Peminta jasa';
            } else if (full.transaksi_status == '4') {
              status = 'Approve VP PPK';
            } else if (full.transaksi_status == '5') {
              status = 'Approve AVP LUK';
            } else if (full.transaksi_status == '6') {
              status = 'On Progress';
            } else if (full.transaksi_status == '15') {
              status = 'Reject';
            }
            return status;
          }
        },
        {
          "data": "transaksi_agreement_keterangan",
        },
        {
          "data": "transaksi_pic_pengirim_id",
          "defaultContent": ""
        },
        {
          "data": "transaksi_pic_pengirim_id",
          "defaultContent": ""
        },
        {
          "data": "transaksi_pic_pengirim_id",
          "defaultContent": "",
        },
        {
          "render": function(data, type, full, meta) {
            return '<div class="btn-group">\
          <button type="button" class="btn btn-default dropdown-toggle btn-custom-small border-dark" data-toggle="dropdown">Detail<span class="caret"></span></button>\
          <ul class="dropdown-menu scrollable-menu" role="menu" style="height: auto;max-height: 200px;overflow-x: hidden;">\
          <li> <a href="javascript:;" class="dropdown-item" id="' + full.id_transaksi_non_rutin + '" title="Detail" data-toggle="modal" data-target="#modal_detail" onclick="fun_detail(this.id,' + full.transaksi_status + ')">Detail</a>\
          </li>\
          <li> <a href="javascript:;" class="dropdown-item" id="' + full.id_transaksi_non_rutin + '" title="History" data-toggle="modal" data-target="#modal_history" onclick="fun_history(this.id,' + full.transaksi_status + ')">History</a>\
          </li>\
          <li><a href="javascript:;" class="dropdown-item" id="' + full.id_transaksi_non_rutin + '"  onclick="cetak_template(this.id,' + full.transaksi_status + ')">Cetak Template</a>\
          </li>\
          </ul>\
          </div>'
          }
        }
      ],
      "columnDefs": [{
          'targets': [8],
          'render': function(data, type, full, meta) {
            if (full.transaksi_pic_pengirim_id == '<?= $this->session->userdata('user_nik_sap') ?>' || $('#user_id').val() == '1') {
              table.columns([8]).visible(false);
            } else {
              if (full.transaksi_status == '0') {
                return '<center>-</center>'
              } else if (full.transaksi_status == '1' && (full.transaksi_reviewer == '<?= $this->session->userdata('user_nik_sap') ?>' || $('#user_id').val() == '1')) {
                return '<a class="btn btn-success btn-custom-small" href="<?= base_url('sample/review/procesReview/?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id'] . '&non_rutin=') ?>' + full.id_transaksi_non_rutin + '&status=' + full.transaksi_status + '"> Review </a>'
              } else if (full.transaksi_status == '2' && (full.transaksi_approver == '<?= $this->session->userdata('user_nik_sap') ?>' || $('#user_id').val() == '1')) {
                return '<a class="btn btn-success btn-custom-small" href="<?= base_url('sample/approved/procesApproved/?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id'] . '&non_rutin=') ?>' + full.id_transaksi_non_rutin + '&status=' + full.transaksi_status + '"> Approve </a>'
              } else if (full.transaksi_status == '3' && ($('#user_unit_id').val() == 'E44000' && full.id_user_disposisi == '<?= $this->session->userdata('user_nik_sap') ?>' || $('#user_id').val() == '1')) {
                return '<a class="btn btn-success btn-custom-small" href="<?= base_url('sample/lab/procesLab/?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id'] . '&non_rutin=') ?>' + full.id_transaksi_non_rutin + '&status=' + full.transaksi_status + '"> Approve VP </a>'
              } else if (full.transaksi_status == '4' && ($('#user_unit_id').val() == 'E44000' || $('#user_id').val() == '1')) {
                return '<a class="btn btn-success btn-custom-small" href="<?= base_url('sample/lab/procesLab/?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id'] . '&non_rutin=') ?>' + full.id_transaksi_non_rutin + '&status=' + full.transaksi_status + '"> Approve AVP </a>'
              } else {
                return '<center>-</center>'
              }
            }
          }
        },
        {
          'targets': [9],
          'render': function(data, type, full, meta) {
            // if (full.transaksi_pic_pengirim_id == '<?= $this->session->userdata('user_nik_sap') ?>' || $('#user_id').val() == '1') {
            if ((full.transaksi_status == '0' || full.transaksi_status == '1' || full.transaksi_status == '15') && full.transaksi_pic_pengirim_id == '<?= $this->session->userdata('user_nik_sap') ?>') {
              return '<center><a class="btn btn-sm" href="<?= base_url('sample/request/editRequest/?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id'] . '&non_rutin=') ?>' + full.id_transaksi_non_rutin + '&status=' + full.transaksi_status + '"><i class="fa fa-edit" style="color:limegreen"></i></a></a></center>';
            } else {
              return '<center>-</center>';
            }
            // } else {
            //   table.columns([9]).visible(false);
            // }
          }
        },
        {
          'targets': [10],
          'render': function(data, type, full, meta) {
            // if (full.transaksi_pic_pengirim_id == '<?= $this->session->userdata('user_nik_sap') ?>' || $('#user_id').val() == '1') {
            if (full.transaksi_status == '0' || (full.transaksi_status == '1' && full.transaksi_pic_pengirim_id == '<?= $this->session->userdata('user_nik_sap') ?>')) {
              return '<center><a href="javascript:;" class="btn  btn-sm" id="' + full.id_transaksi_non_rutin + '"  onclick="fun_delete(this.id)"><i class="fa fa-trash" style="color:red"></i></a><center>';
            } else {
              return '<center>-</center>';
            }
            // } else if (full.transaksi_reviewer == '<?= $this->session->userdata('user_nik_sap') ?>' && full.transaksi_status == '1') {
            if (full.transaksi_status == '0' || (full.transaksi_status == '1' && full.transaksi_pic_pengirim_id == '<?= $this->session->userdata('user_nik_sap') ?>')) {
              return '<center><a href="javascript:;" class="btn  btn-sm" id="' + full.id_transaksi_non_rutin + '"  onclick="fun_delete(this.id)"><i class="fa fa-trash" style="color:red"></i></a><center>';
            } else {
              return '<center>-</center>';
            }
            // } else {
            //   table.columns([10]).visible(false);
            // }
          }
        }
      ]
    });
    /* Isi Table */

    // table detail -> ambil dari easyui juga
    $('#table_detail').DataTable({
      "ajax": {
        "url": "<?= base_url('sample/request/getRequestDetail') ?>",
        "dataSrc": "",
      },
      "columns": [{
          "data": "jenis_nama"
        },
        {
          "data": "transaksi_detail_jumlah"
        },
        {
          "render": function(data, type, row, meta) {
            return row.transaksi_detail_identitas;
          }
        },
        {
          "render": function(data, type, row, meta) {
            return row.transaksi_detail_deskripsi_parameter;
          }
        },
        {
          "data": "transaksi_detail_parameter"
        },
        {
          "render": function(data, type, row, meta) {
            return (row.transaksi_detail_file) ? '<center><a href="#" id="' + row.transaksi_detail_file + '" data-toggle="modal" data-target="#modal_lihat" onclick="fun_lihat(this.id)"><i class="fa fa-image"></i></a></center>' : '<center>-</center>';
          }
        }
      ]
    })

    // table detail -> ambil dari easyui juga
    $('#table_history').DataTable({
      "ajax": {
        "url": "<?= base_url('sample/request/getRequestHistory') ?>",
        "dataSrc": "",
      },
      "columns": [{
          "data": "transaksi_judul"
        },
        {
          "data": "peminta_jasa_nama"
        },
        {
          "render": function(data, type, row, meta) {
            return row.pic_nama;
          }
        },
        {
          "render": function(data, type, full, meta) {
            var status = '';
            var warna = '';
            if (full.sample_log_status == '0') {
              status = 'Draft';
              warna = '#e8d234';
            } else if (full.sample_log_status == '1') {
              status = 'Pengajuan';
              warna = '#5fa7bb';
            } else if (full.sample_log_status == '2') {
              status = 'Review AVP Peminta Jasa';
              warna = '#5fa7dd';
            } else if (full.sample_log_status == '3') {
              status = 'Approve VP Peminta Jasa';
              warna = '#5eb916';
            } else if (full.sample_log_status == '4') {
              status = 'Approve VP PPK';
              warna = '#ea815f';
            } else if (full.sample_log_status == '5') {
              status = 'Approve AVP LUK';
              warna = '#ea815f';
            } else if (full.sample_log_status == '6') {
              status = 'Sample Belum Diterima';
              warna = '#ea815f';
            } else if (full.sample_log_status == '12') {
              status = 'Tunda'; //Sample Diterima
              warna = ' #f37b2d';
            } else if (full.sample_log_status == '7') {
              status = 'Sample Diterima';
              warna = '#69e8aa';
            } else if (full.sample_log_status == '13') {
              status = 'Tunda'; //Sample On Progress
              warna = ' #f37b2d';
            } else if (full.sample_log_status == '8') {
              status = 'On Progress';
              warna = '#69c5e8';
            } else if (full.sample_log_status == '9') {
              status = 'Draft Log Sheet';
              warna = '#e8d369';
            } else if (full.sample_log_status == '10') {
              status = 'Menunggu Review Kasie';
              warna = '#e8d369';
            } else if (full.sample_log_status == '11') {
              status = 'Review Kasie';
              warna = '#79724d';
            } else if (full.sample_log_status == '14') {
              status = 'Batal';
              warna = 'red';
            } else if (full.sample_log_status == '15') {
              status = 'Reject';
              warna = '#c13333';
            }
            return status;
          }
        },
        {
          "data": "sample_log_keterangan"
        },
        {
          "data": "sample_log_who"
        },
        {
          "data": "sample_log_when"
        },
      ]
    })

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
    $('#transaksi_tipe_cari').select2({})

    $('.select2-selection').css('height', '37px');
    $('.select2').css('width', '100%');
    /* Select2 */
  });

  $('.datetimepicker').datetimepicker({
    format: 'YYYY-MM-DD'
  })

  /* FIlter */
  $('#cari').on('click', function(e) { //button cari item
    e.preventDefault();
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $('#table').DataTable().ajax.url('<?= base_url() ?>sample/request/getRequestMain?&' + $('#filter').serialize()).load();
      }
    })
  })
  /* FIlter */



  // detail
  function fun_detail(id, status) {
    $('#table_detail').DataTable().ajax.url('<?= base_url('sample/request/getRequestDetail?transaksi_non_rutin_id=') ?>' + id + '&transaksi_status=' + status).load();
    $('.title_detail').html('Detail Sample');
  }

  // history

  function fun_history(id, status) {
    $('#table_history').DataTable().ajax.url('<?= base_url('sample/request/getRequestHistory?transaksi_non_rutin_id=') ?>' + id + '&transaksi_status=' + status).load();
  }

  // lihat
  function fun_lihat(isi) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $('#document').remove();
        // $('#div_document').append('<iframe src="https://docs.google.com/viewer?url=<?= base_url('document/') ?>'+isi+'&embedded=true" frameborder="0" id="document" width="100%"></iframe>');
        $('#div_document').append('<embed src="<?= base_url('document/') ?>' + isi + '#toolbar=0" frameborder="0" id="document" width="100%" style="height: -webkit-fill-available;"></embed>');
      }
    });
  }

  function fun_delete(id) {
    Swal.fire({
      title: "Hapus Pengajuan Sample?",
      text: "Seluruh Detail Sample Akan Terhapus!",
      icon: "danger",
      showCancelButton: true,
      confirmButtonColor: "#34c38f",
      cancelButtonColor: "#f46a6a",
      confirmButtonText: "Iya"
    }).then(function(result) {
      if (result.value) {
        $.get('<?= base_url('sample/request/deleteRequest?transaksi_non_rutin_id=') ?>' + id, function(data) {
          $('#table').DataTable().ajax.reload(null, false);
          toastr.success('Berhasil Hapus');
        });
      }
    });
  }


  $('#modal_keterangan').on('hidden.bs.modal', function(e) {
    // fun_close_keterangan();
  });

  function cetak_template(id, status) {
    window.open('<?= base_url() ?>sample/request/cetakPreviewRequest?non_rutin=' + id + '&status=' + status, '_blank');
  }

  // EXTRA
  /* Fun Loading */
  function fun_loading() {
    var simplebar = new Nanobar();
    simplebar.go(100);
  }
  /* Fun Loading */
  // EXTRA
</script>