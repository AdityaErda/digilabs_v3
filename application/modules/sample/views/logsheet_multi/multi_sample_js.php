<script type="text/javascript">
  $(function() {

    var url = '<?= base_url('sample/multi_sample/getDataSample?transaksi_status=') ?>' + $('#transaksi_status').val();;

    fun_loading();
    /* Isi Table */
    $('#table thead tr').clone(true).addClass('filters').appendTo('#table thead');

    $('#table').DataTable({
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
      "fnRowCallback": function(data, type, full, meta) {
        if (type['is_urgent'] == 'y') $('td', data).css('background-color', 'Yellow');
      },
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
      "fixedHeader": true,
      "columns": [{
          "render": function(data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        {
          "data": "transaksi_nomor"
        },
        {
          "render": function(data, type, row, meta) {
            return (row.transaksi_tipe == 'E') ? 'Eksternal' : 'Internal'
          }
        },
        {
          "render": function(data, type, row, meta) {
            return row.transaksi_tgl;
          }
        },
        {
          "render": function(data, type, row, meta) {
            return row.peminta_jasa_nama;
          }
        },
        // {
        //   render: function(data, type, full, meta) {
        //     return '<center><a href="javascript:void(0)" onclick="func_cara_close(`' + full.transaksi_id + '`,`' + full.transaksi_detail_status + '`,`' + full.transaksi_status + '`)" id="' + full.transaksi_id + '"><i class="fa fa-share" style="color:green" data-target="#modal_cara_close" data-toggle="modal"></i></a></center>'
        //   }
        // },
        {
          render: function(data, type, full, meta) {
            return '<center><a href="javascript:void(0)" onclick="func_detail(this.id,`' + full.transaksi_detail_status + '`,`' + full.transaksi_status + '`)" id="' + full.transaksi_id + '"><i class="fa fa-search"></i></a></center>'
          }
        },

      ]
    });
    /* Isi Table */
  })

  $(function() {

    var url = '<?= base_url('sample/multi_sample/getDetailSample?transaksi_status=-') ?>';

    fun_loading();
    /* Isi Table */
    var table_detail = $('#table_detail').DataTable({
      drawCallback: function(settings) {
        var data = $('#table_detail').DataTable().rows().data();
        var jumlah = data.length;
        const datas = document.querySelectorAll('.multiple');
        const selectedDatas = [];
        datas.forEach(data => {
          data.addEventListener('click', () => {
            data.classList.toggle('selected');
            if (data.classList.contains('selected')) {
              selectedDatas.push(data.value);
            } else {
              const index = selectedDatas.indexOf(data.value);
              if (index !== -1) {
                selectedDatas.splice(index, 1);
              }
            }
            const joinedDatas = selectedDatas.join(',');
            $("input[name='transaksi_detail_id_group']").val(joinedDatas);
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
        "url": url,
        "dataSrc": ""
      },

      'columnDefs': [{
        targets: 0,
        orderable: false,
        render: function(data, type, row, meta) {
          if ((row.transaksi_detail_status == parseInt('9') || row.transaksi_detail_status == parseInt('10')) && row.logsheet_analisis == null) {
            return '<div class="form-check form-check-sm form-check-custom form-check-solid">\
          <input class="form-check-input multiple" type="checkbox" value="' + row.transaksi_detail_id + '" name="transaksi_detail_id[]" id="transaksi_detail_id_' + meta.row + '" onclick="func_check(this.value,this.id,' + row.transaksi_detail_status + ' , `' + row.id_template_logsheet + '`,`' + row.transaksi_detail_group + '`,`' + row.logsheet_analisis + '`,`' + row.logsheet_review + '`,`' + row.is_approve + '`)">\
          <input type="text" style="display:none" id="transaksi_detail_status_detail_' + meta.row + '" name="transaksi_detail_status" value="' + row.transaksi_detail_status + '">\
          <input type="text" style="display:none" id="transaksi_detail_group_detail_' + meta.row + '" name="transaksi_detail_group" value="' + row.transaksi_detail_group + '">\
          <input type="text" style="display:none" id="id_template_logsheet_detail_' + meta.row + '" name="id_template_logsheet" value="' + row.id_template_logsheet + '">\
          <input type="text" style="display:none" name="id_non_rutin" value="' + row.id_non_rutin + '">\
          <input type="text" style="display:none" name="template_logsheet_id[]" value="' + row.id_template_logsheet + '">\
          <input type="text" style="display:none" name="logsheet_id[]" value="' + row.logsheet_id + '">\
          </div>';
          } else if (row.transaksi_detail_status == parseInt('10') && row.logsheet_analisis != null && row.kasie == 'y') {
            return '<div class="form-check form-check-sm form-check-custom form-check-solid">\
          <input class="form-check-input multiple" type="checkbox" value="' + row.transaksi_detail_id + '" name="transaksi_detail_id[]" id="transaksi_detail_id_' + meta.row + '" onclick="func_check(this.value,this.id,' + row.transaksi_detail_status + ' , `' + row.id_template_logsheet + '`,`' + row.transaksi_detail_group + '`,`' + row.logsheet_analisis + '`,`' + row.logsheet_review + '`,`' + row.is_approve + '`)">\
          <input type="text" style="display:none" id="transaksi_detail_status_detail_' + meta.row + '" name="transaksi_detail_status" value="' + row.transaksi_detail_status + '">\
          <input type="text" style="display:none" id="transaksi_detail_group_detail_' + meta.row + '" name="transaksi_detail_group" value="' + row.transaksi_detail_group + '">\
          <input type="text" style="display:none" id="id_template_logsheet_detail_' + meta.row + '" name="id_template_logsheet" value="' + row.id_template_logsheet + '">\
          <input type="text" style="display:none" name="id_non_rutin" value="' + row.id_non_rutin + '">\
          <input type="text" style="display:none" name="template_logsheet_id[]" value="' + row.id_template_logsheet + '">\
          <input type="text" style="display:none" name="logsheet_id[]" value="' + row.logsheet_id + '">\
          </div>';
          } else if (row.transaksi_detail_status < parseInt('9')) {
            return '<div class="form-check form-check-sm form-check-custom form-check-solid">\
          <input class="form-check-input multiple" type="checkbox" value="' + row.transaksi_detail_id + '" name="transaksi_detail_id[]" id="transaksi_detail_id_' + meta.row + '" onclick="func_check(this.value,this.id,' + row.transaksi_detail_status + ' , `' + row.id_template_logsheet + '`,`' + row.transaksi_detail_group + '`,`' + row.logsheet_analisis + '`,`' + row.logsheet_review + '`,`' + row.is_approve + '`)">\
          <input type="text" style="display:none" id="transaksi_detail_status_detail_' + meta.row + '" name="transaksi_detail_status" value="' + row.transaksi_detail_status + '">\
          <input type="text" style="display:none" id="transaksi_detail_group_detail_' + meta.row + '" name="transaksi_detail_group" value="' + row.transaksi_detail_group + '">\
          <input type="text" style="display:none" id="id_template_logsheet_detail_' + meta.row + '" name="id_template_logsheet" value="' + row.id_template_logsheet + '">\
          <input type="text" style="display:none" name="id_non_rutin" value="' + row.id_non_rutin + '">\
          <input type="text" style="display:none" name="template_logsheet_id[]" value="' + row.id_template_logsheet + '">\
          <input type="text" style="display:none" name="logsheet_id[]" value="' + row.logsheet_id + '">\
          </div>';
          } else {
            return '-'
          }
        },
      }],
      // orderCellsTop: true,
      // "fixedHeader": true,
      "columns": [{
          "data": "transaksi_detail_id"
        },
        {

          "render": function(data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        {
          "data": "transaksi_detail_nomor_sample"
        },
        {
          "data": "jenis_nama"
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
              status = 'Tunda Diterima'; //Sample Diterima
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

            return '<span class="badge" style="background-color: ' + warna + '">' + status + '</span>';
          }
        },
      ],
    });
    /* Isi Table */
  })

  /* Select2 */
  $('#cara_close_nama').select2({
    dropdownParent: $("#modal_cara_close"),
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

  function func_cara_close(idt, tsd, ts) {
    // $('#cara_close_transaksi_detail_id_temp').val(idtd);
    // $('#cara_close_transaksi_detail_id').val(idtd + '_1');
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
      });
  }

  $('#form_cara_close').on('submit', function(e) {
    e.preventDefault();
    if ($('#cara_close_kode').val() == '') {
      toastr.warning('Cara Close Harus Dipilih');
    } else if ($('#cara_close_kode').val() == 'MN') {
      var url = '<?= base_url('sample/multi_sample/insertClossedMultiNonLetter') ?>';
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
      location.href = "<?= base_url('sample/multi_sample/procesMulti?') . 'header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id'] ?>&transaksi_id=" + $('#cara_close_transaksi_id').val() + "&transaksi_status=" + $('#cara_close_transaksi_status').val() + "&transaksi_detail_status=" + $('#cara_close_transaksi_detail_status').val() + "&transaksi_detail_id=" + $('#cara_close_transaksi_detail_id_temp').val();
    }
  })

  function fun_close_cara_close() {
    $('#cara_close_nama').empty();
    $('#div_cara_close_sertifikat').hide();
    $('#form_cara_close')[0].reset();
    fun_loading();
  }

  function func_detail(id, tds, ts) {
    $('#transaksi_id').val(id);
    $('#transaksi_detail_status').val(tds);
    // $('#logsheet_multiple_id').val(tm);
    // $('#transaksi_status_detail').val(ts);
    $('.div_detail').show();
    $('#table_detail').DataTable().ajax.url('<?= base_url('sample/multi_sample/getDetailSample?transaksi_id=') ?>' + id).load();
  }


  function func_pilih_checkbox_sample() {
    var data = new FormData($('#form_detail')[0]);
    Swal.fire({
      title: "Proses Sample?",
      text: "Apakah Anda Yakin Proses Sample Tersebut ?",
      type: "question",
      showCancelButton: true,
      confirmButtonColor: "#34c38f",
      cancelButtonColor: "#f46a6a",
      confirmButtonText: "Iya",
      cancelButtonText: "Tidak",
    }).then(function(result) {
      if (result.value) {
        $.ajax({
          url: '<?= base_url('sample/multi_sample/ceklistMultiSample') ?>',
          type: 'POST',
          dataType: 'HTML',
          data: data,
          cache: false,
          processData: false,
          contentType: false,
          success: function(response) {
            console.log(response);
            if (response == 0) {
              toastr.warning('Harap Pilih Sample Dengan Nama dan Status Sama');
            } else {
              if ($("#transaksi_detail_status_group").val() == '10' && $('#logsheet_analisis_group').val() == 'null') {
                location.href = "<?php echo base_url('sample/multi_sample/draftLogSheet?') . 'header_menu=' . $this->input->get('header_menu') . '&menu_id=' . $this->input->get('menu_id') ?>&transaksi_status=10&transaksi_id=" + $('#transaksi_id').val() + '&transaksi_detail_group=' + $("#transaksi_detail_group_group").val() + '&template_logsheet_id=' + $("#id_template_logsheet_group").val() + '&transaksi_non_rutin_id=' + $("[name='id_non_rutin']").val() + '&transaksi_detail_id_group=' + $("[name='transaksi_detail_id_group']").val();
              } else if ($("#transaksi_detail_status_group").val() == '10') {
                location.href = "<?php echo base_url('sample/multi_sample/reviewLogSheet?') . 'header_menu=' . $this->input->get('header_menu') . '&menu_id=' . $this->input->get('menu_id') ?>&transaksi_status=10&transaksi_id=" + $('#transaksi_id').val() + '&transaksi_detail_group=' + $("#transaksi_detail_group_group").val() + '&template_logsheet_id=' + $("#id_template_logsheet_group").val() + '&transaksi_non_rutin_id=' + $("[name='id_non_rutin']").val() + '&transaksi_detail_id_group=' + $("[name='transaksi_detail_id_group']").val();
              } else if ($("#transaksi_detail_status_group").val() == '9') {
                location.href = "<?php echo base_url('sample/multi_sample/procesLogSheet?') . 'header_menu=' . $this->input->get('header_menu') . '&menu_id=' . $this->input->get('menu_id') ?>&transaksi_status=9&transaksi_id=" + $('#transaksi_id').val() + '&transaksi_detail_group=' + $("[name='transaksi_detail_group']").val() + '&template_logsheet_id=' + $("[name='id_template_logsheet']").val() + '&transaksi_non_rutin_id=' + $("[name='id_non_rutin']").val() + '&transaksi_detail_id_group=' + $("[name='transaksi_detail_id_group']").val();
              } else {
                location.href = "<?php echo base_url('sample/multi_sample/procesMulti?') . 'header_menu=' . $this->input->get('header_menu') . '&menu_id=' . $this->input->get('menu_id') ?>&transaksi_status=" + $("[name='transaksi_detail_status']").val() + "&transaksi_id=" + $('#transaksi_id').val() + '&transaksi_detail_group=' + $("[name='transaksi_detail_group']").val() + '&template_logsheet_id=' + $("[name='id_template_logsheet']").val() + '&transaksi_non_rutin_id=' + $("[name='id_non_rutin']").val() + '&transaksi_detail_id_group=' + $("[name='transaksi_detail_id_group']").val();
              }
            }
          }
        })

      }
    })
  }

  function func_check(val, id, status, template, id_group, analisis, review, approve) {
    $('#transaksi_detail_status_group').val(status);
    $('#id_template_logsheet_group').val(template);
    $('#transaksi_detail_group_group').val(id_group);
    $('#logsheet_analisis_group').val(analisis);
    $('#logsheet_review_group').val(review);
    $('#is_approve_group').val(approve);
  }


  $('#filter').on('submit', function(e) {
    e.preventDefault();
    $('#table').DataTable().ajax.url('<?= base_url('sample/multi_sample/getDataSample?') ?>' + $('#filter').serialize()).load();
  })

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