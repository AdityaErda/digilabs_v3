<script type="text/javascript">
  $(function() {
    // tanngal range
    // $('#tanggal_cari').daterangepicker({
    //   locale: {format: 'DD-MM-YYYY'},
    // })
    // tanggal range
    /* Isi Table */
    $('#table').DataTable({
      "scrollX": true,
      // "order":[[0,"desc"],[7,"desc"]],
      "lengthMenu": [
        [5, 10, 25, 50, -1],
        [5, 10, 25, 50, "All"]
      ],
      "dom": 'lBfrtip',
      "buttons": ["csv", "pdf", "excel", "copy", "print"],
      "ajax": {
        "url": "<?= base_url() ?>/material/pengajuan_perbaikan/getPengajuan?tanggal_cari=" + $('#tanggal_cari').val(),
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
          "data": "aset_perbaikan_file"
        }, {
          "render": function(data, type, full, meta) {
            if (full.aset_perbaikan_status == '0' && full.user_nik_sap == '<?= $this->session->userdata('user_nik_sap') ?>') return '<center><a href="javascript:;" id="' + full.aset_perbaikan_id + '" title="Proses" onclick="fun_proses(this.id)"  data-toggle="modal" data-target="#modal"><i class="fa fa-share" style="color: orange;"></i></a></center>';
            else if (full.aset_perbaikan_status == '1' && '2105087' == '<?= $this->session->userdata('user_nik_sap') ?>') return '<center><a href="javascript:;" id="' + full.aset_perbaikan_id + '" title="Proses" onclick="fun_proses(this.id)"  data-toggle="modal" data-target="#modal"><i class="fa fa-share" style="color: orange;"></i></a></center>';
            else return '<center>-</center>';
          }
        },
        {
          "render": function(data, type, full, meta) {
            var tambol = '';
            var tombol = '<div class="input-group-prepend" ><button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Action</button><div style="height:auto;max-height: 135px;overflow-x: hidden;" class="dropdown-menu pre-scrollable"><a class="dropdown-item" href="javascript:;" id="' + full.aset_perbaikan_id + '" title="Edit" onclick="fun_edit(this.id)"  data-toggle="modal" data-target="#modal">Edit<i style="color:lime"></i></a><a class="dropdown-item" href="javascript:;" onclick="return fun_delete(this.id)" id="' + full.aset_perbaikan_id + '" title="Hapus">Hapus<i  style="color:red" ></i></a></div></div>';
            return (full.aset_perbaikan_status == '0') ? tombol : '<center>-</center>';
            // return tombol
          }
        },
      ]
    });
    $('#cari').click();
  })
  /* Isi Table */


  /* select2 aset nomor utama */
  $('#aset_nomor_utama').select2({
    placeholder: 'Pilih',
    allowClear: true,
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

  // start select 2 aset
  // $('#aset_id').select2({
  //   placeholder: 'Pilih',
  //   ajax: {
  //     delay: 250,
  //     url: '<?= base_url('material/pengajuan_perbaikan/getAsetNama') ?>',
  //     dataType: 'json',
  //     type: 'GET',
  //     data: function(params) {
  //       var queryParameters = {
  //         aset_nama: params.term
  //       }

  //       return queryParameters;
  //     }
  //   }
  // });

  // $('.select2-selection').css('height', '37px');
  // $('.select2').css('width', '100%');
  // end select 2 aset

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

  function func_gantiKodeItem(isi) {
    if (isi != '') {
      $('#item_id').select2({
        placeholder: 'Pilih',
        ajax: {
          delay: 250,
          url: '<?= base_url('material/pengajuan_perbaikan/getAsetKode?aset_id=') ?>' + isi,
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
      $('#item_id').css('display', 'block');
      $('#item_id_baru').css('display', 'none');
      $('#item_id_baru').val('');
    } else {
      $('#item_id').empty();
      $('#item_id').css('display', 'none');
      $('#item_id').select2('destroy');
      $('#item_id_baru').css('display', 'block');
    }
  }
  $('.select2-selection').css('height', '37px');
  $('.select2').css('width', '100%');


  /* Tanggal */
  //   $(".tanggal").daterangepicker({
  //   showDropdowns: true,
  //   singleDatePicker: true,
  //   locale: {format: 'DD-MM-YYYY'}
  // });
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
        $('#table').DataTable().ajax.url('<?= base_url('/material/pengajuan_perbaikan/getPengajuan?') ?>' + $('#filter').serialize()).load();
      }
    })
  })
  // filter

  /* Select2 */
  $('#pekerjaan_id').select2({
    placeholder: 'Pilih',
  });

  $('.select2-selection').css('height', '37px');
  $('.select2').css('width', '100%');
  /* Select2 */

  // ganti serial
  // function func_gantiSerial(id) {
  // $.getJSON('<?= base_url('material/jadwal_perbaikan/getSerialNumber') ?>', {
  // aset_id: id
  // }, function(json) {
  // $('#aset_nomor_utama').val(json.aset_nomor_utama);
  // console.log(json.aset_nomor_utama);
  // })
  // }
  // ganti serial

  // ganti nama
  function func_gantiAsetNama(id) {
    if (id != '') {
      $.getJSON('<?= base_url('master/aset/getAset') ?>', {
        aset_id: id
      }, function(json) {
        $('#aset_nama').val(json.aset_nama);
        $('#aset_nama').attr('readonly', true);
      })
    } else {
      $('#aset_nama').val('');
      $('#aset_nama').removeAttr('readonly');
    }
  }

  // ganti nama


  function fun_edit(id) {
    fun_loading();
    console.log(id);
    $('#simpan').css('display', 'none');
    $('#file_wajib').hide();
    $('#edit').css('display', 'block');
    $('#div_file_sebelum').css('display', 'inline');

    $.getJSON('<?= base_url('material/pengajuan_perbaikan/getPengajuan') ?>', {
      aset_perbaikan_id: id
    }, function(json) {
      $.each(json, function(index, val) {
        $('#' + index).val(val);
      });
      $('#id_user').val(json.id_user);
      $('#tanggal').val(json.tanggal_penyerahan);
      $('#aset_note').val(json.aset_perbaikan_note);
      $('#aset_file_lama').val(json.aset_perbaikan_file);
      $('#aset_perbaikan_vendor').val(json.aset_perbaikan_vendor);


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

      $('#peminta_id').append('<option selected value="' + json.peminta_jasa_id + '">' + json.peminta_jasa_nama + '</option>');
      $('#peminta_id').select2('data', {
        id: json.peminta_jasa_id,
        text: json.peminta_jasa_nama
      });
      $('#peminta_id').trigger('change');

      // $('#pekerjaan_id').append('<option selected value="'+json.pekerjaan_id+'">'+json.pekerjaan_nama+'</option>');
      $('#pekerjaan_id').select2('data', {
        id: json.pekerjaan_id,
        text: json.pekerjaan_nama
      });
      $('#pekerjaan_id').trigger('change');
    });
  }

  function fun_proses(id) {
    fun_loading();
    console.log(id);
    $('#simpan').css('display', 'none');
    $('#file_wajib').hide();
    $('#approve').css('display', 'block');
    $('#div_file_sebelum').css('display', 'inline');

    $('#aset_note').attr('readonly', true);
    $('#aset_perbaikan_vendor').attr('readonly', true);
    $('#aset_nomor_utama').attr('disabled', true);
    $('#item_id').attr('disabled', true);
    $('#pekerjaan_id').attr('disabled', true);
    $('#peminta_id').attr('disabled', true);
    $('#aset_file').attr('disabled', true);

    $.getJSON('<?= base_url('material/pengajuan_perbaikan/getPengajuan') ?>', {
      aset_perbaikan_id: id
    }, function(json) {
      $.each(json, function(index, val) {
        $('#' + index).val(val);
      });
      $('#id_user').val(json.id_user);
      $('#tanggal').val(json.tanggal_penyerahan);
      $('#aset_note').val(json.aset_perbaikan_note);
      $('#aset_file_lama').val(json.aset_perbaikan_file);
      $('#aset_perbaikan_vendor').val(json.aset_perbaikan_vendor);



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

      $('#peminta_id').append('<option selected value="' + json.peminta_jasa_id + '">' + json.peminta_jasa_nama + '</option>');
      $('#peminta_id').select2('data', {
        id: json.peminta_jasa_id,
        text: json.peminta_jasa_nama
      });
      $('#peminta_id').trigger('change');

      // $('#pekerjaan_id').append('<option selected value="'+json.pekerjaan_id+'">'+json.pekerjaan_nama+'</option>');
      $('#pekerjaan_id').select2('data', {
        id: json.pekerjaan_id,
        text: json.pekerjaan_nama
      });
      $('#pekerjaan_id').trigger('change');
    });
  }

  function fun_delete(data) {
    // $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
    // if (!json.user_id) {
    // fun_notifLogout();
    // } else {
    $.confirmModal('Apakah anda yakin akan menghapusnya?', function(el) {
      $.ajax({
        url: '<?= base_url() ?>material/pengajuan_perbaikan/deletePengajuanPerbaikan',
        data: {
          aset_perbaikan_id: data
        },
        type: 'GET',
        dataType: 'html',
        success: function(isi) {
          $('#form_modal')[0].reset();
          $('#table').DataTable().ajax.reload(null, false);
          $('#close').click();
          toastr.success('Berhasil');
          fun_loading();
        }
      })
    })
  }
  // })
  // }

  $('#approve').click(function(e) {
    e.preventDefault();

    var data = new FormData();
    data.append('aset_perbaikan_id', $('#aset_perbaikan_id').val());
    data.append('aset_perbaikan_status', $('#aset_perbaikan_status').val());

    $.ajax({
      url: '<?= base_url('material/pengajuan_perbaikan/approvePengajuanPerbaikan') ?>',
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
        $('#loading_form').hide();
      },
      success: function(isi) {
        $('#close').click();
        toastr.success('Berhasil');
        fun_loading();
      }
    });
  });

  $("#form_modal").on("submit", function(e) {
    e.preventDefault();
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        if ($('#aset_perbaikan_id').val() != '') var url = '<?= base_url('material/pengajuan_perbaikan/updatePengajuanPerbaikan') ?>';
        else var url = '<?= base_url('material/pengajuan_perbaikan/insertPengajuanPerbaikan') ?>';

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
        if ($('#aset_nama').val() == '') {
          $('#nama_alert').show();
        } else {
          $('#nama_alert').hide();
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
        if ($('#aset_perbaikan_vendor').val() == '') {
          $('#vendor_alert').show();
        } else {
          $('#vendor_alert').hide();
        }

        $('#aset_note').val() == '' ? $('#note_alert').show() : $('#note_alert').hide();

        if ($('#aset_file_lama').val() != '') {
          $('#file_alert').hide();
        } else if ($('#aset_file').val() == '') {
          $('#file_alert').show();
        } else {
          $('#file_alert').hide();
        }

        if ($('#tanggal').val() != '' && $('#pekerjaan_id').val() != null & $('#tanggal_selesai').val() != '' && $('#peminta_id').val() != null && $('#aset_perbaikan_vendor').val() != '' && ($('#aset_file').val() != '' || $('#aset_file_lama').val() != '') && $('#aset_note') != '') {

          var aset_foto = $('#aset_file').prop('files')[0];
          var data = new FormData();
          data.append('aset_perbaikan_id', $('#aset_perbaikan_id').val());
          data.append('aset_detail_id', $('#item_id').val());
          data.append('item_id_baru', $('#item_id_baru').val());
          data.append('aset_nama', $('#aset_nama').val());
          data.append('pekerjaan_id', $('#pekerjaan_id').val());
          data.append('peminta_id', $('#peminta_id').val());
          data.append('aset_perbaikan_tgl_penyerahan', $('#tanggal').val());
          data.append('aset_perbaikan_vendor', $('#aset_perbaikan_vendor').val());
          data.append('aset_perbaikan_note', $('#aset_note').val());
          data.append('id_user', $('#id_user').val());
          data.append('aset_perbaikan_status', '0')
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
              $('#loading_form').hide();
            },
            success: function(isi) {
              $('#close').click();
              toastr.success('Berhasil');
              fun_loading();
            }
          });
        } else {
          e.preventDefault();
        }
      }
    })
  });

  // user data
  function func_userPeminta() {
    $.getJSON('<?= base_url('material/request/getUserPeminta') ?>', function(json) {
      $('#id_user').val(json.user_id);
      // $('#user_nama_peminta').val(json.user_nama_lengkap);
    })
  }
  // user data

  function func_tambah() {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        func_userPeminta();
        func_tanggal();
        fun_loading();
      }
    })
  }

  /* Tanggal */
  function func_tanggal() {
    // $(".tanggal").daterangepicker({
    //   showDropdowns: true,
    //   singleDatePicker: true,
    //   locale: {format: 'DD-MM-YYYY'}
    // });
    var today = new Date();
    var hari = today.getDate();
    var bulan = today.getMonth() + 1;
    var tahun = today.getFullYear();
    var tanggal = hari + "-" + bulan + "-" + tahun;
    $('#tanggal').val(tanggal);
  }

  function fun_close() {
    $('#tanggal_alert').hide();
    $('#nama_alert').hide();
    $('#serial_alert').hide();
    $('#jenis_alert').hide();
    $('#tanggal_selesai_alert').hide();
    $('#peminta_alert').hide();
    $('#vendor_alert').hide();
    $('#file_alert').hide();
    $('#file_wajib').show();
    $('#simpan').css('display', 'block');
    $('#edit').css('display', 'none');
    $('#approve').css('display', 'none');
    $('#div_file_sebelum').css('display', 'none');
    $('#aset_perbaikan_id').empty();
    $('#item_id').empty();
    // $('#aset_id').empty();
    $('#aset_nomor_utama').empty();
    $('#peminta_id').empty();
    // $('#pekerjaan_id').empty();
    $('#form_modal')[0].reset();
    $('#table').DataTable().ajax.reload(null, false);

    $('#aset_note').attr('readonly', false);
    $('#aset_perbaikan_vendor').attr('readonly', false);
    $('#aset_nomor_utama').attr('disabled', false);
    $('#item_id').attr('disabled', false);
    $('#pekerjaan_id').attr('disabled', false);
    $('#peminta_id').attr('disabled', false);
    $('#aset_file').attr('disabled', false);
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
  // });


  /* AutoComplete */
</script>