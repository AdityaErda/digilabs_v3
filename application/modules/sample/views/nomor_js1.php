<script type="text/javascript">
  $(function() {
    fun_alert();

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
      "scrollX": true,
      "lengthMenu": [
        [5, 10, 25, 50, -1],
        [5, 10, 25, 50, "All"]
        ],
      "dom": 'lBfrtip',
      "buttons": ["csv", "pdf", "excel", "copy", "print"],
      "ajax": {

        "url": "<?= base_url() ?>sample/nomor/getNomor?status_cari=-",
        "dataSrc": ""
      },
      "fnRowCallback": function(data, type, full, meta) {
        $(data).attr('class', 'warna');;
      },
      "columns": [{
        render: function(data, type, full, meta) {
          return meta.row + meta.settings._iDisplayStart + 1;
        }
      },
      {
        "data": "transaksi_rutin_tgl_baru"
      },
      {
        "data": "who_create"
      },
      {
        "render": function(data, type, full, meta) {
          var status = '';
          var warna = '';
          if (full.transaksi_detail_status == '0') {
            status = 'On Progress';
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
          } else if (full.transaksi_detail_status == '10') {
            status = 'Menunggu Review';
            warna = '#e8d369';
          } else if (full.transaksi_detail_status == '11') {
            status = 'Menunggu Approve';
            warna = '#79724d';
          } else if (full.transaksi_detail_status == '12') {
            status = 'Menuggu Send DOF'; //Sample Diterima
            warna = ' #f37b2d';
          } else if (full.transaksi_detail_status == '13') {
            status = 'Tunda dan Close'; //Sample On Progress
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
          return status;
            // return '<span class="badge" style="background-color: ' + warna + '">' + status + '</span>';
        }
      },
      {
        "render": function(data, type, full, meta) {
          return '<center><a href="javascript:;" id="' + full.transaksi_rutin_id + '" title="Detail" onclick="fun_detail(this.id,`'+full.transaksi_detail_status+'`)"><i class="fa fa-search"></i></a></center>';
        }
      },
      {
        "render": function(data, type, full, meta) {
          return (full.status == '0') ? '<center><a href="javascript:;" id="' + full.transaksi_rutin_id + '" title="Edit" onclick="fun_edit(this.id)" style="color: orange"><i class="fa fa-edit" data-toggle="modal" data-target="#modal"></i></a></center>' : '';
        }
      },
      {
        "render": function(data, type, full, meta) {
          if (full.status == '0') {
            return '<center><a href="javascript:;" id="' + full.transaksi_rutin_id + '" title="Proses" onclick="fun_cara_close(this.id,`' + full.status + '`);fun_close_nama(`y`);"><i class="fa fa-share" data-toggle="modal" data-target="#modal_cara_close" style="color: green"></i></a></center>'
          } else if (full.transaksi_detail_status == '9') {
            return '<center><a href="javascript:;" id="' + full.transaksi_rutin_id + '" title="Draft" onclick="fun_draft(this.id,`' + full.transaksi_detail_status + '`);fun_close_nama(`y`);"><i class="fa fa-share" style="color: green"></i></a></center>';
          } else if (full.transaksi_detail_status == '10' && full.kasie == 'y') {
            return '<center><a href="javascript:;" id="' + full.transaksi_rutin_id + '" title="Review" onclick="fun_review(this.id,`' + full.transaksi_detail_status + '`);fun_close_nama(`y`);"><i class="fa fa-share" style="color: green"></i></a></center>';
          } else if (full.transaksi_detail_status == '11' && full.kasie == 'y') {
            return '<center><a href="javascript:;" id="' + full.transaksi_rutin_id + '" title="Approve" onclick="fun_review(this.id,`' + full.transaksi_detail_status + '`);fun_close_nama(`y`);"><i class="fa fa-share" style="color: green"></i></a></center>';
          } else if (full.transaksi_detail_status == '12' && full.kasie == 'y') {
            return '<center><a href="javascript:;" id="' + full.transaksi_rutin_id + '" title="Approve" onclick="fun_review(this.id,`' + full.transaksi_detail_status + '`);fun_close_nama(`y`);"><i class="fa fa-share" style="color: green"></i></a></center>';
          } else {
            return '';
          }
        }
      },
      ]
});
    /* Isi Table */

    /* Isi Table */
$('#table_detail thead tr').clone(true).addClass('filters_detail').appendTo('#table_detail thead');
$('#table_detail').DataTable({
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
      var cell = $('.filters_detail th').eq(
        $(api.column(colIdx).header()).index()
        );
      var title = $(cell).text();
      $(cell).html('<input type="text" class="form-control" style="width:100%" placeholder="' + title + '" />');

            // On every keypress in this input
      $(
        'input',
        $('.filters_detail th').eq($(api.column(colIdx).header()).index())
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
  "scrollX": true,
  "ordering": false,
  "lengthMenu": [
    [5, 10, 25, 50, -1],
    [5, 10, 25, 50, "All"]
    ],
  "ajax": {
    "url": "<?= base_url() ?>sample/nomor/getNomorDetail?id_transaksi_rutin=0",
    "dataSrc": ""
  },
  "columns": [{
    "data": "transaksi_nomor"
  },
  {
    "data": "jenis_nama"
  },
  {
    "data": "sample_pekerjaan_nama"
  },
  {
    "data": "identitas_nama"
  },
  {
    "data": "transaksi_detail_note"
  },
  {
    "render": function(data, type, full, meta) {
      if (full.transaksi_detail_file != null && full.transaksi_detail_file != "") {
        return '<center><a href="javascript:;" id="' + full.transaksi_detail_file + '" title="Lihat" data-toggle="modal" data-target="#modal2" onClick="fun_lihat(this.id)"><i class="fa fa-file" style="color: peru"></i></a></center>';
      } else {
        return '<center>-</center>';
      }
    }
  },
  {
    "render": function(data, type, full, meta) {
      return '<center><a href="<?= base_url('sample/notifikasi/print_qrcode/?transaksi_id=') ?>' + full.transaksi_id + '" target="_BLANK" id="' + full.transaksi_id + '" title="Qrcode"><i class="fa fa-qrcode" style="color: black"></i></a></center>';
    }
  },
  {
    "render": function(data, type, full, meta) {
      if (full.transaksi_detail_status == '0') {
        return '<center><a href="javascript:;" id="' + full.transaksi_rutin_id + '" title="Proses" onclick="fun_cara_close_detail(this.id,`' + full.transaksi_detail_status + '`,`'+full.transaksi_id+'`);fun_close_nama(`n`);"><i class="fa fa-share" data-toggle="modal" data-target="#modal_cara_close" style="color: green"></i></a></center>'
      } else if (full.transaksi_detail_status == '9') {
        return '<center><a href="javascript:;" id="' + full.transaksi_rutin_id + '" title="Draft" onclick="fun_draft(this.id,`' + full.transaksi_detail_status + '`);fun_close_nama(`n`);"><i class="fa fa-share" style="color: green"></i></a></center>';
      } else if (full.transaksi_detail_status == '10' && full.kasie == 'y') {
        return '<center><a href="javascript:;" id="' + full.transaksi_rutin_id + '" title="Review" onclick="fun_review(this.id,`' + full.transaksi_detail_status + '`);fun_close_nama(`n`);"><i class="fa fa-share" style="color: green"></i></a></center>';
      } else if (full.transaksi_detail_status == '11' && full.kasie == 'y') {
        return '<center><a href="javascript:;" id="' + full.transaksi_rutin_id + '" title="Approve" onclick="fun_review(this.id,`' + full.transaksi_detail_status + '`);fun_close_nama(`n`);"><i class="fa fa-share" style="color: green"></i></a></center>';
      } else if (full.transaksi_detail_status == '12' && full.kasie == 'y') {
        return '<center><a href="javascript:;" id="' + full.transaksi_rutin_id + '" title="Approve" onclick="fun_review(this.id,`' + full.transaksi_detail_status + '`);fun_close_nama(`n`);"><i class="fa fa-share" style="color: green"></i></a></center>';
      } else {
        return '';
      }
    },
  },
  {
    "render": function(data, type, full, meta) {
      return '<center><a href="javascript:;"  id="' + full.transaksi_id + '" name="' + full.transaksi_detail_id + '" title="Hapus" onclick="fun_hapus(this.id,this.name)"><i class="fa fa-trash" style="color: red"></i></a></center>';
    },
  },
  ]
});
    /* Isi Table */

    /* Tanggal */
$(".tanggal").daterangepicker({
  showDropdowns: true,
  singleDatePicker: true,
  locale: {
    format: 'DD-MM-YYYY'
  }
});

$("#tgl_cari").daterangepicker({
  locale: {
    format: 'DD-MM-YYYY'
  }
});
    /* Tanggal */

    // select 2
    /* Select2 */
$('.select2').select2({
  placeholder: 'Pilih',
});

    // cara close
function fun_close_nama(nama) {
  $('#cara_close_nama').select2({
    placeholder: 'Pilih',
    ajax: {
      delay: 250,
      url: '<?= base_url('master/cara_close/getCaraCLoseList?multiple=') ?>' + $('#is_multiple').val() + '&tipe=R',
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
}

    // cara close

$('.select2-selection').css('height', '37px');
$('.select2').css('width', '100%');
    /* Select2 */
    // select 2

    /* Select2 */
    /* Peminta Jasa */
$('#peminta_jasa_id').select2({
  placeholder: 'Pilih',
  ajax: {
    delay: 250,
    url: '<?= base_url('sample/request/getPemintaJasa') ?>',
    dataType: 'json',
    type: 'GET',
    data: function(params) {
      var queryParameters = {
        peminta_jasa_nama: params.term
      }

      return queryParameters;
    }
  }
});
    /* Peminta Jasa */

    /* Jenis */
$('#jenis_id').select2({
  placeholder: 'Pilih',
  ajax: {
    delay: 250,
    url: '<?= base_url('sample/request/getJenisSampleUji') ?>',
    dataType: 'json',
    type: 'GET',
    data: function(params) {
      var queryParameters = {
        jenis_nama: params.term
      }

      return queryParameters;
    }
  }
});
    /* Jenis */

    /* Jenis Diklik */
$('#jenis_id').on('select2:select', function(e) {
  var data = e.params.data;

  $.getJSON('<?= base_url('master/jenis_sample_uji/getJenisSampleUji') ?>', {
    jenis_id: data.id
  }, function(json) {
    $('#parameter').val(json.jenis_parameter);
  });
});
    /* Jenis Diklik */

    /* Jenis Pekerjaan */
$('#jenis_pekerjaan_id').select2({
  placeholder: 'Pilih',
  ajax: {
    delay: 250,
    url: '<?= base_url('sample/request/getJenisPekerjaan') ?>',
    dataType: 'json',
    type: 'GET',
    data: function(params) {
      var queryParameters = {
        sample_pekerjaan_nama: params.term
      }

      return queryParameters;
    }
  }
});
    /* Jenis Pekerjaan */

$('.select2-selection').css('height', '37px');
$('.select2').css('width', '100%');
    /* Select2 */
})

  /* Filter */
  // $("#filter").on("submit", function(e) {
  //   e.preventDefault();
  //   $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
  //     if (!json.user_id) {
  //       fun_notifLogout();
  //     } else {
  //       var status = $('#status_cari').val();
  //       // console.log(status);
  //       if (status == 0) {
  //         $('#table').DataTable().ajax.url('<?= base_url() ?>sample/nomor/getNomor?status_cari=' + $('#status_cari').val()).load();
  //       } else {
  //         $('#table').DataTable().ajax.url('<?= base_url() ?>sample/nomor/getNomor?' + $('#filter').serialize()).load();
  //       }
  //       fun_loading();
  //       total_rutin();
  //     }
  //   });
  // });

$('.datetimepicker').datetimepicker({
  format: 'YYYY-MM-DD'
})

$("#filter").on("submit", function(e) {
  e.preventDefault();
  $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
    if (!json.user_id) {
      fun_notifLogout();
    } else {
      $('#table').DataTable().ajax.url('<?= base_url() ?>sample/nomor/getNomor?' + $('#filter').serialize()).load();
      fun_loading();
    }
  })
});
  /* Filter */

function fun_lihat(isi) {
  $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
    if (!json.user_id) {
      fun_notifLogout();
    } else {
      $('#document').remove();
        // $('#div_document').append('<iframe src="https://docs.google.com/viewer?url=<?= base_url('document/') ?>'+isi+'&embedded=true" frameborder="0" id="document" width="100%"></iframe>');
      $('#div_document').append('<embed src="<?= base_url('document/') ?>' + isi + '#toolbar=0" frameborder="0" id="document" width="100%"></embed>');
    }
  });
}

function fun_detail(id,status) {
  $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
    if (!json.user_id) {
      fun_notifLogout();
    } else {
      $('#div_detail').css('display', 'block');
      $('#table_detail').DataTable().ajax.url('<?= base_url() ?>sample/nomor/getNomorDetail?&transaksi_rutin_id=' + id+'&transaksi_detail_status='+status).load();
      $('html, body').animate({
        scrollTop: $("#div_detail").offset().top
      }, 10);
      setTimeout(function() {
        $('.warna').removeAttr('style')
      }, 500);
      setTimeout(function() {
        $('#' + id).parents('tr').attr('style', 'color: red')
      }, 1000);
    }
  });
}

function fun_tambah() {
  $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
    if (!json.user_id) {
      fun_notifLogout();
    } else {
      var id = Date.now();
      $('#transaksi_rutin_id').val(id);

      setTimeout(function() {
        $('#dg').edatagrid({
          url: '<?= base_url() ?>sample/nomor/getNomorDetail?&transaksi_rutin_id=' + id,
          updateUrl: '<?= base_url() ?>sample/nomor/editEasyui',
        });
      }, 500);
    }
  });
}

function fun_edit(id) {
  $('#simpan').css('display', 'none');
  $('#edit').css('display', 'block');
  $('#close').hide();
  $('#close_edit').show();
  $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
    if (!json.user_id) {
      fun_notifLogout();
    } else {

      $('#transaksi_rutin_id').val(id);

      setTimeout(function() {
        $('#dg').edatagrid({
          url: '<?= base_url() ?>sample/nomor/getNomorDetail?&transaksi_rutin_id=' + id,
          updateUrl: '<?= base_url() ?>sample/nomor/editEasyui',
        });
      }, 500);
    }
  });
}
  /* PROSES */
  /* Proses */
$('#proses').on('click', function(event) {
  event.preventDefault();
  $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
    if (!json.user_id) {
      fun_notifLogout();
    } else {
      var jumlah = $('#jumlah_sample').val();
      Swal.fire({
          // title: "Anda Yakin Logout?",
        text: "Apakah akan memproses " + jumlah + " Sample ?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#34c38f",
        cancelButtonColor: "#f46a6a",
        confirmButtonText: "Iya",
        cancelButtonText: 'Tidak',
      }).then(function(result) {
        if (result.value) {
          $.ajax({
            url: '<?= base_url('sample/nomor/insertProses') ?>',
            data: $('#form_modal').serialize(),
            type: 'POST',
            dataType: 'html',
            beforeSend: function() {
              $('#loading_form').css('display', 'block');
              $('#proses').css('display', 'none');
            },
            success: function(isi) {
                // $('#form_modal')[0].reset();
              $('#peminta_jasa_id').empty();
              $('#jenis_id').empty();
              $('#jenis_pekerjaan_id').empty();
              $('#jumlah_sample').val('');
              $('#parameter').val('');
              $('#dg').datagrid('reload')
              $('#loading_form').css('display', 'none');
              $('#proses').css('display', 'block');
            }
          });
        }
      });
    }
  });
})
  /* Proses */


  /* Fun Simpan */
function fun_simpan() {
  $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
    if (!json.user_id) {
      fun_notifLogout();
    } else {
      $('#dg').edatagrid('saveRow');
      setTimeout(() => {
        $('#dg').datagrid('reload')
      }, 500);
    }
  });
}
  // }
  // }
  /* Fun Simpan */

  /* Fun Hapus */
function fun_hapus() {
  $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
    if (!json.user_id) {
      fun_notifLogout();
    } else {
      var row = $('#dg').datagrid('getSelected');
      $.post('<?= base_url('/sample/nomor/deleteNomorEasyui') ?>', {
        transaksi_id: row.transaksi_id
      }, function(data, textStatus, xhr) {
        $('#dg').datagrid('reload');
        total_rutin();
      });
    }
  });
}
  /* Fun Hapus */
  /* PROSES */

  /* CLOSSED */
function fun_clossed() {
  $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
    if (!json.user_id) {
      fun_notifLogout();
    } else {
      if ($('#id_transaksi').val() != '') var url = '<?= base_url('sample/nomor/updateClossedDetail') ?>';
      else var url = '<?= base_url('sample/nomor/updateClossed') ?>';

      if ($('#transaksi_detail_file').val() != '' || $('#transaksi_detail_no_surat').val() != '') {
        var transaksi_detail_file = $('#transaksi_detail_file').prop('files')[0];
        var data = new FormData();

        data.append('transaksi_detail_file', transaksi_detail_file);
        data.append('id_transaksi_rutin', $('#id_transaksi_rutin').val());
        data.append('id_transaksi', $('#id_transaksi').val());
        data.append('transaksi_detail_no_surat', $('#transaksi_detail_no_surat').val());

        $.ajax({
          url: url,
          data: data,
          type: 'POST',
          processData: false,
          contentType: false,
          beforeSend: function() {
            $('#loading_form_detail').css('display', 'block');
              // $('#clossed').css('display', 'none');
          },
          success: function(response) {
            if (response == 0) {
              toastr.warning('Format Tidak Didukung');
              $('#loading_form_detail').css('display', 'none');
            } else {
              $('#close_detail').click();
              toastr.success('Berhasil');
              total_rutin();
            }
          }
        });
      } else {
        toastr.error('File atau No Surat Tidak Boleh Kosong');
      }
    };
  });
}
  /* CLOSSED */

  /* Fun Proses */
function fun_proses(id) {
  $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
    if (!json.user_id) {
      fun_notifLogout();
    } else {
      $('#modal_proses').modal('show');
      $('#id_transaksi_rutin').val(id);
    }
  });
}
  /* Fun Proses */

  /* Fun Proses Detail */
function fun_proses_detail(id) {
  $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
    if (!json.user_id) {
      fun_notifLogout();
    } else {
      $('#id_transaksi').val(id);
    }
  });
}
  /* Fun Proses Detail */

  // Fun Close Detail
function fun_close_simpan() {
  $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
    if (!json.user_id) {
      fun_notifLogout();
    } else {
      fun_simpan_sample($('#transaksi_rutin_id').val());
      $('#form_modal')[0].reset();
      $('#modal').modal('hide');

      $('#table').DataTable().ajax.reload();

      $('#peminta_jasa_id').empty();
      $('#jenis_id').empty();
      $('#jenis_pekerjaan_id').empty();

      $('#simpan').css('display', 'block');
      $('#edit').css('display', 'none');
      $('#loading_form').css('display', 'none');
    }
  });
}
  // Fun Close Detail

function fun_simpan_sample(id) {
  $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
    if (!json.user_id) {
      fun_notifLogout();
    } else {
      $.getJSON('<?= base_url('sample/nomor/simpanSample') ?>', {
        id: id
      }, function(json) {});
      $('#table').DataTable().ajax.reload();
        // $('#table').DataTable().ajax.reload();
    }
  });
}

function fun_reject(id) {
  $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
    if (!json.user_id) {
      fun_notifLogout();
    } else {
      $.getJSON('<?= base_url('sample/nomor/Reject') ?>', {
        id: id
      }, function(json) {

      });
    }
  });
}

function fun_cancel(id) {
  $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
    if (!json.user_id) {
      fun_notifLogout();
    } else {
      $.getJSON('<?= base_url('sample/nomor/Cancel') ?>', {
        id: id
      }, function(json) {

      })
    }
  });
}

  /* Fun Close */
function fun_close() {
  $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
    if (!json.user_id) {
      fun_notifLogout();
    } else {
        // fun_reject ($('#transaksi_rutin_id').val());
      fun_cancel($('#transaksi_rutin_id').val());

      $('#form_modal')[0].reset();

      $('#peminta_jasa_id').empty();
      $('#jenis_id').empty();
      $('#jenis_pekerjaan_id').empty();

      $('#simpan').css('display', 'block');
      $('#edit').css('display', 'none');
      $('#loading_form').css('display', 'none');

      $('#table').DataTable().ajax.reload();
    }
  });
}

function fun_close_edit() {
  $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
    if (!json.user_id) {
      fun_notifLogout();
    } else {
      $('#form_modal')[0].reset();

      $('#peminta_jasa_id').empty();
      $('#jenis_id').empty();
      $('#jenis_pekerjaan_id').empty();

      $('#simpan').css('display', 'block');
      $('#edit').css('display', 'none');
      $('#loading_form').css('display', 'none');

      $('#table').DataTable().ajax.reload();
    }
  });
}

  /* Fun Close */

$('#modal').on('hidden.bs.modal', function(e) {
    // fun_close();
});

  /* Fun Close Detail */
function fun_close_detail() {
  $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
    if (!json.user_id) {
      fun_notifLogout();
    } else {
      $('#form_modal_detail')[0].reset();

      $('#loading_form_detail').css('display', 'none');
      $('#clossed').css('display', 'block');
      $('#table_detail').DataTable().ajax.reload();
      $('#table').DataTable().ajax.reload();
    }
  });
}
  /* Fun Close */

$('#form_modal_detail').on('hidden.bs.modal', function(e) {
  fun_close_detail();
});

  /* Fun Loading */
function fun_loading() {
  var simplebar = new Nanobar();
  simplebar.go(100);
}
  /* Fun Loading */

  /* Fun Alert */
function fun_alert() {
  $.getJSON('<?= base_url('sample/nomor/getAlert') ?>', function(json) {
    toastr.warning('Sample Eksternal : ' + json.eksternal + '<br>Sample Internal : ' + json.internal + '<br>Sample Rutin : ' + json.rutin);
    if (json.eksternal >= 40 || json.internal >= 40 || json.rutin >= 40) {
      toastr.error('Sample Sudah Maksimal');
      $('#tambah').css('display', 'none');
    } else {
      $('#tambah').css('display', 'block');
    }
  });
}
  /* Fun Alert */

  // Delete
function fun_hapus(id, value) {
  $.confirmModal('Apakah Anda Yakin Akan Menghapus Data Ini ?', function(e) {
    $.get('<?= base_url('sample/nomor/hapusNomorDetail') ?>', {
      transaksi_id: id,
      transaksi_detail_id: value
    }, function(result) {
      toastr.success('Berhasil');
      $('#table_detail').DataTable().ajax.reload();
    })
  })
}
  // Delete

  // cara close
function fun_close_nama(nama) {
  $('#cara_close_nama').select2({
    placeholder: 'Pilih',
    ajax: {
      delay: 250,
      url: '<?= base_url('master/cara_close/getCaraCLoseList?multiple=') ?>' + nama + '&tipe=R',
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
}
  // cara close

  // klik proses atas
function fun_cara_close(id, status) {
  $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
    if (!json.user_id) {
      fun_notifLogout();
    } else {
      $('#id_transaksi_rutin').val(id);
      // $('#is_multiple').val('y');
      $('#status_transaksi').val(status)
      $('#simpan_cara_close_multiple').show();
      $('#simpan_cara_close').hide();
    }
  })
}
  // klik proses atas



  //  proses cara close
$('#simpan_cara_close_multiple').on('click', function(e) {
  e.preventDefault();

  if ($('#cara_close_kode').val() == '') {
    toastr.warning('Cara Close Harus Dipilih');
  } else if ($('#cara_close_kode').val() == 'MN') {
    var url = '<?= base_url('sample/nomor/insertCloseNonLetter') ?>'
    var data = new FormData($('#form_modal_cara_close')[0]);
    $.ajax({
      url: url,
      type: 'POST',
      dataType: 'HTML',
      data: data,
      processData: false,
      contentType: false,
      cache: false,
      beforeSend: function() {
        $('#loading_cara_close').css('display', 'block');
        $('#simpan_cara_close_multiple').css('display', 'none');
      },
      success: function() {
        toastr.success('Berhasil');
        $('#close_cara_close').click();
        $('#table').DataTable().ajax.reload(null, false);
      }
    })
  } else if ($('#cara_close_kode').val() == 'E') {
    toastr.error('Under Maintenance!!');
  } else {
    var url = "<?= base_url('sample/nomor/logsheetMultipleNomor?') . 'header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id'] ?>&id_transaksi_rutin=" + $('#id_transaksi_rutin').val() + '&status=' + $('#status_transaksi').val();
    location.href = url;
  }
})
  //  proses cara close

 // klik proses bawah
function fun_cara_close_detail(id, status,id_trans) {
  $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
    if (!json.user_id) {
      fun_notifLogout();
    } else {
      $('#id_transaksi').val(id_trans);
      $('#id_transaksi_rutin').val(id);
      // $('#is_multiple').val('y');
      $('#status_transaksi').val(status)
      $('#simpan_cara_close_multiple').hide();
      $('#simpan_cara_close').show();
    }
  })
}
  // klik proses bawah

  //  proses cara close detail
$('#simpan_cara_close').on('click', function(e) {
  e.preventDefault();

  if ($('#cara_close_kode').val() == '') {
    toastr.warning('Cara Close Harus Dipilih');
  } else if ($('#cara_close_kode').val() == 'N') {
    var url = '<?= base_url('sample/nomor/insertCloseNonLetterDetail') ?>'
    var data = new FormData($('#form_modal_cara_close')[0]);
    $.ajax({
      url: url,
      type: 'POST',
      dataType: 'HTML',
      data: data,
      processData: false,
      contentType: false,
      cache: false,
      beforeSend: function() {
        $('#loading_cara_close').css('display', 'block');
        $('#simpan_cara_close').css('display', 'none');
      },
      success: function() {
        toastr.success('Berhasil');
        $('#close_cara_close').click();
        $('#table').DataTable().ajax.reload(null, false);
      }
    })
  } else if ($('#cara_close_kode').val() == 'E') {
    toastr.error('Under Maintenance!!');
  } else {
    var url = "<?= base_url('sample/nomor/logsheetNomor?') . 'header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id'] ?>&id_transaksi_rutin=" + $('#id_transaksi_rutin').val() + '&status=' + $('#status_transaksi').val();
    location.href = url;
  }
})
  //  proses cara close detail


// kode close multiple
function fun_ganti_kode_close(id) {
  $.getJSON('<?= base_url('master/cara_close/getCaraCLose') ?>', {
    cara_close_id: id
  },
  function(data, textStatus, jqXHR) {
    $('#cara_close_kode').val(data.cara_close_kode);
  });
}
  // kode close multiple

function fun_close_cara_close() {
  $('#id_transaksi').val();
  $('#id_transaksi_rutin').val();
  $('#is_multiple').val();
  $('#status_transaksi').val()
  $('#simpan_cara_close_multiple').hide();
  $('#simpan_cara_close').hide();
}

  // fungsi close
  // $('#modal').modal({backdrop: 'static', keyboard: false})

function fun_draft(id, status) {
  var redirect = '<?= base_url() ?>/sample/nomor/draftMultipleNomor?header_menu=' + $('#header_menu').val() + '&menu_id=' + $('#menu_id').val() + '&id_transaksi_rutin=' + id + '&status=' + status;

  location.href = redirect;
}

function fun_review(id, status) {
  var redirect = '<?= base_url() ?>/sample/nomor/reviewMultipleNomor?header_menu=' + $('#header_menu').val() + '&menu_id=' + $('#menu_id').val() + '&id_transaksi_rutin=' + id + '&status=' + status;

  location.href = redirect;
}
</script>