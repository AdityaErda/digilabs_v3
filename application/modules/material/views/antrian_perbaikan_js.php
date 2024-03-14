<script type="text/javascript">
  $(function() {
    // $('#tanggal_cari').daterangepicker({
    //   locale: {format:'DD-MM-YYYY'},
    // })
    /* Isi Table */
    $('#table thead tr')
      .clone(true)
      .addClass('filters')
      .appendTo('#table thead');

    $('#table').DataTable({
      orderCellsTop: true,
      initComplete: function() {
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
            $(cell).html('<input type="text" class="form-control" placeholder="' + title + '" />');

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
      // "ordering":[7,desc], 
      // "order":[[0,"desc"]],
      "lengthMenu": [
        [5, 10, 25, 50, -1],
        [5, 10, 25, 50, "All"]
      ],
      "dom": 'lBfrtip',
      "buttons": ["csv", "pdf", "excel", "copy", "print"],
      "ajax": {
        "url": "<?= base_url() ?>/material/antrian_perbaikan/getAntrianPerbaikan?tanggal_cari_awal=<?= date('Y-m-d') ?>&tanggal_cari_akhir=<?= date('Y-m-d') ?>",
        "dataSrc": ""
      },
      "columns": [{
          render: function(data, type, full, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        {
          "data": "tanggal_penyerahan"
        },
        {
          "data": "tanggal_selesai"
        },
        {
          "render": function(data, type, full, meta) {
            var status = '';
            if (full.pekerjaan_id === 'p') {
              status = 'Perbaikan';
            } else if (full.pekerjaan_id === 'k') {
              status = 'Kalibrasi';
            }
            return status;
          }
        },
        {
          "data": "aset_nomor_utama"
        },
        {
          "data": "aset_nomor"
        },
        {
          "data": "aset_nama"
        },
        {
          "data": "peminta_jasa_nama"
        },
        {
          "data": "aset_perbaikan_note"
        },
        {
          "data": "aset_perbaikan_note_selesai"
        },
        {
          "render": function(data, type, full, meta) {
            var status_text = '';
            var status_warna = '';
            if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'p') {
              status_warna = '#FFA500'
              status_text = 'Perbaikan Pengajuan'
            } else if (full.aset_perbaikan_status == '0' && full.pekerjaan_id == 'p') {
              status_warna = '#FF4500';
              status_text = 'Menunggu Approve AVP Custormer'
            } else if (full.aset_perbaikan_status == '1' && full.pekerjaan_id == 'p') {
              status_warna = '#FF4500';
              status_text = 'Menunggu Approve AVP LUK'
            } else if (full.aset_perbaikan_status == 'n' && full.pekerjaan_id == 'k') {
              status_warna = '#FF4500';
              status_text = 'Kalibrasi Pengajuan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'p') {
              status_warna = '#0FF700';
              status_text = 'Perbaikan Dikerjakan'
            } else if (full.aset_perbaikan_status == 'k' && full.pekerjaan_id == 'k') {
              status_warna = '#32CD32';
              status_text = 'Kalibrasi Dikerjakan';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'p') {
              status_warna = '#FFFF66';
              status_text = 'Kalibrasi Pending';
            } else if (full.aset_perbaikan_status == 'p' && full.pekerjaan_id == 'k') {
              status_warna = '#FFFF33';
              status_text = 'Kalibrasi Pending';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'p') {
              status_warna = '#20B2AA';
              status_text = 'Perbaikan Sudah Dikerjakan';
            } else if (full.aset_perbaikan_status == 'y' && full.pekerjaan_id == 'k') {
              status_warna = '#1E90FF';
              status_text = 'Kalibrasi Sudah Dikerjakan';
            }

            return '<span class="badge" style="background-color: ' + status_warna + '">' + status_text + '</span>';
          }
        },
        {
          "render": function(data, type, full, meta) {
            return '<center><a href="javascript:;" id="' + full.aset_perbaikan_id + '" onclick="fun_history(this.id)" title="Proses"><i class="fa fa-history" data-toggle="modal" data-target="#modal_history" style="color:red"></i></a></center>';
          }
        },
        <?php
        $login_as = $this->session->userdata();
        $login_role = $this->db->query("SELECT * FROM global.global_role WHERE role_id = '1' OR role_id = 'df416116aa07eba2d4140d461ff2dfc3a927515c'")->result_array();
        foreach ($login_role as $value) {
          if ($login_as['role_id'] == $value['role_id']) {
        ?> {
              "render": function(data, type, full, meta) {
                return (full.aset_perbaikan_status != '0' && full.aset_perbaikan_status != '1' && full.aset_perbaikan_status != 'y') ? '<center><a href="javascript:;" id="' + full.aset_perbaikan_id + '" onclick="fun_proses(this.id)" title="Proses"><i class="fa fa-share" data-toggle="modal" data-target="#modal" style="color:lime"></i></a></center>' : '';
              }
            },
        <?php }
        } ?>
      ]
    });
    /* Isi Table */

    $('#table_history thead tr').clone(true).addClass('filters_history').appendTo('#table_history thead');
    $('#table_history').DataTable({
      orderCellsTop: true,
      initComplete: function() {
        var api = this.api();

        // For each column
        api
          .columns()
          .eq(0)
          .each(function(colIdx) {
            // Set the header cell to contain the input element
            var cell = $('.filters_history th').eq(
              $(api.column(colIdx).header()).index()
            );
            var title = $(cell).text();
            $(cell).html('<input type="text" class="form-control" placeholder="' + title + '" />');

            // On every keypress in this input
            $(
                'input',
                $('.filters_history th').eq($(api.column(colIdx).header()).index())
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
      // "scrollX": true,
      "lengthMenu": [
        [5, 10, 25, 50, -1],
        [5, 10, 25, 50, "All"]
      ],
      // "order":[[1,"desc"],[2,"desc"]],
      "dom": 'lBfrtip',
      "buttons": ["csv", "pdf", "excel", "copy", "print"],
      "ajax": {
        "url": "<?= base_url() ?>/material/pengajuan_perbaikan/getAsetHistory?aset_perbaikan_id=0",
        "dataSrc": ""
      },
      "columns": [{
          render: function(data, type, full, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        {
          render: function(data, type, full, meta) {
            var status_text = '';
            var status_warna = '';
            if (full.material_aset_histori_status == 'n') {
              status_warna = '#FFA500'
              status_text = 'Proses Pengajuan'
            } else if (full.material_aset_histori_status == '0') {
              status_warna = '#FF4500';
              status_text = 'Menunggu Approve AVP Custormer'
            } else if (full.material_aset_histori_status == '1') {
              status_warna = '#FF4500';
              status_text = 'Menunggu Approve AVP LUK'
            } else if (full.material_aset_histori_status == 'k') {
              status_warna = '#0FF700';
              status_text = 'Dikerjakan'
            } else if (full.material_aset_histori_status == 'p') {
              status_warna = '#FFFF66';
              status_text = 'Pending';
            } else if (full.material_aset_histori_status == 'y') {
              status_warna = '#20B2AA';
              status_text = 'Sudah Dikerjakan';
            }

            return '<span class="badge" style="background-color: ' + status_warna + '">' + status_text + '</span>';
          }
        },
        {
          "data": "material_aset_histori_waktu"
        },
        {
          "data": "who_create"
        },
      ]
    }).columns.adjust();

    /* Tanggal */
    $(".tanggal").daterangepicker({
      showDropdowns: true,
      singleDatePicker: true,
      locale: {
        format: 'DD-MM-YYYY'
      }
    });
    /* Tanggal */

    $('.datetimepicker').datetimepicker({
      format: 'YYYY-MM-DD'
    })

    // filter
    $('#filter').on('submit', function(e) {
      e.preventDefault();
      $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
        if (!json.user_id) {
          fun_notifLogout();
        } else {
          fun_loading();
          $('#table').DataTable().ajax.url('<?= base_url('material/antrian_perbaikan/getAntrianPerbaikan?') ?>' + $('#filter').serialize()).load();
        }
      });
    })
    // filter
    /* Select2 */
    $('#jenis_cari').select2({
      placeholder: 'Pilih',
    });

    $('.select2-selection').css('height', '37px');
    $('.select2').css('width', '100%');
    /* Select2 */
    /* Select2 */
    $('#terjadwal_cari').select2({
      placeholder: 'Pilih',
    });

    $('.select2-selection').css('height', '37px');
    $('.select2').css('width', '100%');
    /* Select2 */
    /* Select2 */
    $('#pekerjaan_id').select2({
      placeholder: 'Pilih',
    });

    $('.select2-selection').css('height', '37px');
    $('.select2').css('width', '100%');
    /* Select2 */
    /* Select2 */
    $('#aset_perbaikan_status').select2({
      placeholder: 'Pilih',
    });

    $('.select2-selection').css('height', '37px');
    $('.select2').css('width', '100%');
    /* Select2 */
    /* Select2  Global*/
    $('#status_pekerjaan').select2({
      placeholder: 'Pilih',
    });

    $('.select2-selection').css('height', '37px');
    $('.select2').css('width', '100%');
    /* Select2  Global*/
  });

  $('#aset_id').select2({
    placeholder: 'Pilih',
    ajax: {
      delay: 250,
      url: '<?= base_url('material/antrian_perbaikan/getAsetNama') ?>',
      dataType: 'json',
      type: 'GET',
      data: function(params) {
        var queryParameters = {
          aset_nama: params.term
        }

        return queryParameters;
      }
    }
  });

  $('.select2-selection').css('height', '37px');
  $('.select2').css('width', '100%');
  // end select 2 aset

  /* select2 aset nomor utama */
  $('#aset_nomor_utama').select2({
    placeholder: 'Pilih',
    ajax: {
      delay: 250,
      url: '<?= base_url('material/pengajuan_perbaikan/getAsetNomor') ?>',
      dataType: 'json',
      type: 'GET',
      data: function(params) {
        var queryParameters = {
          aset_nomor_utama: params.term
        }
        return queryParameters;

      }
    }
  });

  $('.select2-selection').css('height', '37px');
  $('.select2').css('width', '100%');
  /* select2 aset nomor utama */

  $('#aset_nomor_utama').on('change', function() {
    $('#item_id').empty();
  })

  // function func_gantiKodeItem(isi){
  //   func_kodeItem(isi);
  // }

  $('#item_id').select2({});

  function func_gantiKodeItem(isi) {
    $('#item_id').empty();
    $('#item_id').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url('material/antrian_perbaikan/getAsetKode?aset_id=') ?>' + isi,
        dataType: 'json',
        type: 'GET',
        data: function(params) {
          var queryParameters = {
            aset_nomor: params.term
          }

          return queryParameters;
        }
      }
    });
    $('.select2-selection').css('height', '37px');
    $('.select2').css('width', '100%');
  }
  $('.select2-selection').css('height', '37px');
  $('.select2').css('width', '100%');

  //

  // start select 2 jenis pekerjaan
  $('#peminta_id').select2({
    placeholder: 'Pilih',
    ajax: {
      delay: 250,
      url: '<?= base_url('material/request/getPemintaJasa') ?>',
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


  $('.select2-selection').css('height', '37px');
  $('.select2').css('width', '100%');
  // end select  2 jenis pekerjaan

  function func_tanggal() {
    $("#tanggal_selesai").daterangepicker({
      showDropdowns: true,
      singleDatePicker: true,
      locale: {
        format: 'DD-MM-YYYY'
      }
    });
  }

  // ganti serial
  function func_gantiSerial(id) {
    $.getJSON('<?= base_url('material/jadwal_perbaikan/getSerialNumber') ?>', {
      aset_id: id
    }, function(json) {
      $('#aset_nomor_utama').val(json.aset_nomor_utama);
      // console.log(json.aset_nomor_utama);
    })
  }

  function func_gantiAsetNama(id) {
    $.getJSON('<?= base_url('master/aset/getAset') ?>', {
      aset_id: id
    }, function(json) {
      $('#aset_nama').val(json.aset_nama);
    })
  }

  function fun_proses(id) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        fun_loading();
        console.log(id);
        // $('#simpan').css('display', 'none');
        // $('#edit').css('display', 'block');
        $.getJSON('<?= base_url('material/antrian_perbaikan/getAntrianPerbaikan') ?>', {
          aset_perbaikan_id: id
        }, function(json) {
          $.each(json, function(index, val) {
            $('#' + index).val(val);
          });
          console.log(json);
          $('#tanggal').val(json.tanggal_penyerahan);
          $('#aset_note').val(json.aset_perbaikan_note);
          $('#aset_note_selesai').val(json.aset_perbaikan_note_selesai);
          $('#aset_file_lama').val(json.aset_perbaikan_file);
          $('#aset_nomor_utama').val(json.aset_nomor_utama);
          $('#aset_perbaikan_vendor').val(json.aset_perbaikan_vendor);
          $('#temp_aset_id').val(json.aset_id);
          $('#temp_aset_nomor').val(json.aset_nomor);
          $('#temp_aset_detail_merk').val(json.aset_detail_merk);
          func_tanggal();

          // $('#aset_id').append('<option selected value="' + json.aset_id + '">' + json.aset_nama + '</option>');
          // $('#aset_id').select2('data', {
          //   id: json.aset_id,
          //   text: json.aset_nama
          // });
          // $('#aset_id').trigger('change');

          $('#aset_nomor_utama').append('<option selected value="' + json.aset_id + '">' + json.aset_nomor_utama + '</option>');
          $('#aset_nomor_utama').select2('data', {
            id: json.aset_id,
            text: json.aset_nomor_utama
          });
          $('#aset_nomor_utama').trigger('change');

          $('#item_id').append('<option selected value="' + json.aset_detail_id + '">' + json.aset_nomor + '</option>');
          $('#item_id').select2('data', {
            id: json.aset_detail_id,
            text: json.aset_nomor
          });
          $('#item_id').trigger('change');

          $('#aset_perbaikan_status').select2('data', {
            id: json.aset_perbaikan_status,
            text: json.perbaikan_status
          });
          $('#aset_perbaikan_status').trigger('change');

          $('#pekerjaan_id').select2('data', {
            id: json.pekerjaan_id,
            text: json.pekerjaan_nama
          });
          $('#pekerjaan_id').trigger('change');

          $('#peminta_id').append('<option selected value="' + json.peminta_jasa_id + '">' + json.peminta_jasa_nama + '</option>');
          $('#peminta_id').select2('data', {
            id: json.peminta_jasa_id,
            text: json.peminta_jasa_nama
          });
          $('#peminta_id').trigger('change');
        });
      }
    });
  }
  // 
  $("#form_modal").on("submit", function(e) {
    e.preventDefault();
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        if ($('#aset_perbaikan_id').val() != '') var url = '<?= base_url('material/antrian_perbaikan/updateAntrianPerbaikan') ?>';
        else var url = '<?= base_url('material/antrian_perbaikan/insertAntrianPerbaikan') ?>';

        // setTimeout(()=>{
        if ($('#tanggal').val() == '') {
          $('#tanggal_alert').show();
        } else {
          $('#tanggal_alert').hide();
        }
        // if ($('#aset_id').val() == null) {
        //   $('#nama_alert').show();
        // } else {
        //   $('#nama_alert').hide();
        // }
        if ($('#aset_nomor_utama').val() == null) {
          $('#nomor_alert').show();
        } else {
          $('#nomor_alert').hide();
        }
        if ($('#item_id').val() == null) {
          $('#serial_alert').show();
        } else {
          $('#serial_alert').hide();
        }
        if ($('#pekerjaan_id').val() == null) {
          $('#jenis_alert').show();
        } else {
          $('#jenis_alert').hide();
        }
        if ($('#tanggal_selesai').val() == '') {
          $('#tanggal_selesai_alert').show();
        } else {
          $('#tanggal_selesai_alert').hide();
        }
        if ($('#peminta_id').val() == null) {
          $('#peminta_alert').show();
        } else {
          $('#peminta_alert').hide();
        }
        if ($('#aset_note').val() == '') {
          $('#note_alert').show();
        } else {
          $('#note_alert').hide();
        }
        if ($('#aset_note_selesai').val() == '') {
          $('#note_selesai_alert').show();
        } else {
          $('#note_selesai_alert').hide();
        }
        if ($('#aset_file').val() == '') {
          $('#file_alert').show();
        } else {
          $('#file_alert').hide();
        }
        if ($('#aset_perbaikan_vendor').val() == '') {
          $('#vendor_alert').show();
        } else {
          $('#vendor_alert').hide();
        }
        // },2000)


        if ($('#tanggal').val() != '' && $('#aset_nomor_utama').val() != null && $('#item_id').val() != null && $('#pekerjaan_id').val() != null & $('#tanggal_selesai').val() != '' && $('#peminta_id').val() != null && $('#aset_note').val() != '' && $('#aset_note_selesai').val() != '' && $('#aset_file').val() != '') {

          var aset_foto = $('#aset_file').prop('files')[0];
          var data = new FormData();

          data.append('temp_aset_id', $('#temp_aset_id').val());
          data.append('temp_aset_nomor', $('#temp_aset_nomor').val());
          data.append('temp_aset_detail_merk', $('#temp_aset_detail_merk').val());
          data.append('aset_perbaikan_id', $('#aset_perbaikan_id').val());
          data.append('aset_detail_id', $('#item_id').val())
          data.append('pekerjaan_id', $('#pekerjaan_id').val())
          data.append('peminta_id', $('#peminta_id').val())
          data.append('aset_perbaikan_vendor', $('#aset_perbaikan_vendor').val())
          data.append('aset_perbaikan_tgl_penyerahan', $('#tanggal').val())
          data.append('aset_perbaikan_tgl_selesai', $('#tanggal_selesai').val())
          data.append('aset_perbaikan_note', $('#aset_note').val())
          data.append('aset_perbaikan_note_selesai', $('#aset_note_selesai').val())
          data.append('aset_perbaikan_status', $('#aset_perbaikan_status').val())
          data.append('aset_perbaikan_file', aset_foto);
          e.preventDefault();

          $.ajax({
            url: url,
            data: data,
            type: 'POST',
            processData: false,
            contentType: false,
            beforeSend: function() {
              $('#loading_form').show();
              $('#simpan').hide();
              $('#edit').hide();
            },
            complete: function() {
              $('#loading_form').hide()
            },
            success: function(isi) {
              $('#close').click();
              fun_loading();
              toastr.success('Berhasil');
            }
          });
        } else {
          e.preventDefault();
        }
      }
    })
  });

  function fun_close() {
    fun_loading();
    $('#tanggal_alert').hide();
    $('#nama_alert').hide();
    $('#serial_alert').hide();
    $('#jenis_alert').hide();
    $('#tanggal_selesai_alert').hide();
    $('#peminta_alert').hide();
    $('#simpan').css('display', 'block');
    $('#edit').css('display', 'none');
    $('#aset_perbaikan_id').empty();
    $('#form_modal')[0].reset();
    $('#aset_nomor_utama').empty();
    $('#table').DataTable().ajax.reload(null, false);
  }
  /* Fun Close */

  $('#modal').on('hidden.bs.modal', function(e) {
    fun_close();
  });

  /* Fun Loading */
  function fun_loading() {
    var simplebar = new Nanobar();
    simplebar.go(100);
  }
  /* Fun Loading */

  function fun_history(id) {
    fun_loading();
    $('#table_history').DataTable().ajax.url('<?= base_url('material/pengajuan_perbaikan/getAsetHistory?aset_perbaikan_id=') ?>' + id).load();
  }
</script>