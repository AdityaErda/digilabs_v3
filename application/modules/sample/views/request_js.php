<script type="text/javascript">
  $(function() {
    fun_loading();

    /* Isi Table */
    $('#table').DataTable({
      "fixedHeader":true,
      "ordering": true,
      "lengthMenu": [
        [5, 10, 25, 50, -1],
        [5, 10, 25, 50, "All"]
      ],
      "dom": 'lBfrtip',
      "buttons": ["csv", "pdf", "excel", "copy", "print"],
      "ajax": {
        // "url": "<?= base_url() ?>sample/request/getRequest?transaksi_tipe=<?= $tipe ?>&tgl_cari=<?= date('d-m-Y') . ' - ' . date('d-m-Y') ?>",
        "url": "<?= base_url() ?>sample/request/getRequest?transaksi_status_request=0",
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
          "data": "peminta_jasa_nama"
        },
        // {
        // "data": "jenis_nama"
        // },
        {
          "data": "sample_pekerjaan_nama"
        },
        // {
        //   "data": "transaksi_detail_tgl_memo_baru"
        // },
        // {
        // "data": "transaksi_detail_no_memo"
        // },
        {
          "render": function(data, type, full, meta) {
            var status = '';
            if (full.transaksi_status == '0') status = 'Belum Diapprove';
            else if (full.transaksi_status == '1') status = 'Sudah Diapprove';
            else if (full.transaksi_status == '2') status = 'Sample Belum Diterima';
            else if (full.transaksi_status == '3' && full.transaksi_detail_status == '9') status = 'Tunda';
            else if (full.transaksi_status == '3' && full.transaksi_detail_status == '3') status = 'Sample Diterima';
            else if (full.transaksi_status == '4' && full.transaksi_detail_status == '9') status = 'Tunda';
            else if (full.transaksi_status == '4' && full.transaksi_detail_status == '4') status = 'On Progress';
            else if (full.transaksi_status == '5') status = 'Terbit Sertifikat';
            else if (full.transaksi_status == '6') status = 'Clossed';
            else if (full.transaksi_status == '7') status = 'Tambah Petugas Sampling';
            else if (full.transaksi_status == '8') status = 'Reject';
            return status;
          }
        },
        {
          "render": function(data, type, full, meta) {
            // var tombol = '<div class="input-group-prepend"><button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Action</button><div class="dropdown-menu"><a class="dropdown-item" href="#" id="' + full.transaksi_id + '" data-toggle="modal" data-target="#modal_detail" onclick="fun_detail(this.id)">Detail</a><a class="dropdown-item" href="#" id="' + full.transaksi_id + '" data-toggle="modal" data-target="#modal" onclick="fun_edit(this.id)">Edit</a><a class="dropdown-item" href="#" id="' + full.transaksi_id + '" onclick="fun_delete(this.id)">Hapus</a></div></div>';
            var tombol = '<div class="input-group-prepend"><button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Action</button><div class="dropdown-menu"><a class="dropdown-item" href="#" id="' + full.transaksi_non_rutin_id + '" data-toggle="modal" data-target="#modal_detail" onclick="fun_detail(this.id)">Detail</a><a class="dropdown-item" href="#" id="' + full.transaksi_non_rutin_id + '" data-toggle="modal" data-target="#modal" onclick="fun_edit(this.id)">Edit</a><a class="dropdown-item" href="#" id="' + full.transaksi_non_rutin_id + '" onclick="fun_delete(this.id)">Hapus</a></div></div>';
            return (full.transaksi_status == '0') ? tombol : '-';
          }
        },
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
            return row.identitas_nama;
          }
        },
        {
          "render": function(data, type, row, meta) {
            return row.transaksi_detail_keterangan;
          }
        },
        {
          "data": "transaksi_detail_parameter"
        },
        {
          "render": function(data, type, row, meta) {
            return (row.transaksi_detail_foto) ? '<center><a href="#" id="' + row.transaksi_detail_foto + '" data-toggle="modal" data-target="#modal_lihat" onclick="fun_lihat(this.id)"><i class="fa fa-image"></i></a></center>' : '-';
          }
        }
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

      fun_identitas(data.id);
    });
    /* Jenis Diklik */

    /* Identitas */
    $('#identitas_id').select2({
      placeholder: 'Pilih Jenis Sample Dahulu',
    });
    /* Identitas */

    /* Identitas Diklik */
    $('#identitas_id').on('select2:select', function(e) {
      var data = e.params.data;

      $.getJSON('<?= base_url('master/jenis_sample_uji/getSampleIdentitas') ?>', {
        identitas_id: data.id
      }, function(json) {
        $('#transaksi_detail_parameter').val(json.identitas_parameter);
      });
    });
    /* Identitas Diklik */

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

    /* Jenis Pekerjaan */
    $('#transaksi_klasifikasi_id').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url('master/klasifikasi_sample/getKlasifikasiSampleList') ?>',
        dataType: 'json',
        type: 'GET',
        data: function(params) {
          var queryParameters = {
            klasifikasi_nama: params.term
          }

          return queryParameters;
        }
      }
    });
    /* Jenis Pekerjaan */

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
        $('#table').DataTable().ajax.url('<?= base_url() ?>sample/request/getRequest?' + $('#filter').serialize()).load();
      }
    })
  })
  /* FIlter */

  /* View Update */
  function fun_edit(id) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        setTimeout(function() {
          $('#' + id).parents('tr').attr('style', 'color: red')
        }, 500);
        setTimeout(function() {
          easyuiRenderSample(id);
        }, 500);
        $('#simpan').css('display', 'none');
        $('#edit').css('display', 'block');
        $('#div_transaksi_detail_foto_sebelumnya').css('display', 'block');

        $.getJSON('<?= base_url('sample/request/getRequest') ?>', {
          transaksi_non_rutin_id: id
        }, function(json) {
          $('#is_new').val(1);
          $('#transaksi_id').val(json.transaksi_id);
          $('#transaksi_non_rutin_id').val(json.transaksi_non_rutin_id);
          $('#transaksi_detail_id').val(json.transaksi_detail_id);
          $('#transaksi_tipe').val(json.transaksi_tipe);
          $('#transaksi_detail_pic_pengirim').val(json.transaksi_detail_pic_pengirim);
          $('#transaksi_detail_ext_pengirim').val(json.transaksi_detail_ext_pengirim);
          $('#transaksi_detail_jumlah').val(json.transaksi_detail_jumlah);
          $('#transaksi_detail_tgl_pengajuan').val(json.transaksi_detail_tgl_pengajuan_baru);
          // $('#transaksi_detail_tgl_memo').val(json.transaksi_detail_tgl_memo_baru);
          $('#transaksi_detail_no_memo').val(json.transaksi_detail_no_memo);
          $('#transaksi_detail_parameter').val(json.transaksi_detail_parameter);
          $('#transaksi_detail_note').val(json.transaksi_detail_note);
          $('#temp_transaksi_detail_foto').val(json.transaksi_detail_foto);
          $('#transaksi_detail_foto_sebelumnya').attr("src", '<?= base_url('document/') ?>' + json.transaksi_detail_foto);

          $('#peminta_jasa_id').append('<option selected value="' + json.peminta_jasa_id + '">' + json.peminta_jasa_nama + '</option>');
          $('#peminta_jasa_id').select2('data', {
            id: json.peminta_jasa_id,
            text: json.peminta_jasa_nama
          });
          $('#peminta_jasa_id').trigger('change');

          $('#jenis_id').append('<option selected value="' + json.jenis_id + '">' + json.jenis_nama + '</option>');
          $('#jenis_id').select2('data', {
            id: json.jenis_id,
            text: json.jenis_nama
          });
          $('#jenis_id').trigger('change');
          fun_identitas(json.jenis_id);

          $('#jenis_pekerjaan_id').append('<option selected value="' + json.jenis_pekerjaan_id + '">' + json.sample_pekerjaan_nama + '</option>');
          $('#jenis_pekerjaan_id').select2('data', {
            id: json.jenis_pekerjaan_id,
            text: json.sample_pekerjaan_nama
          });
          $('#jenis_pekerjaan_id').trigger('change');

          $('#identitas_id').append('<option selected value="' + json.identitas_id + '">' + json.identitas_nama + '</option>');
          $('#identitas_id').select2('data', {
            id: json.identitas_id,
            text: json.identitas_nama
          });
          $('#identitas_id').trigger('change');

          $('#transaksi_klasifikasi_id').append('<option selected value="' + json.klasifikasi_id + '">' + json.klasifikasi_kode + '</option>');
          $('#klasifikasi_id').select2('data', {
            id: json.klasifikasi_id,
            text: json.klasifikasi_kode
          });
          $('#transaksi_klasifikasi_id').trigger('change');
        });
      }
    });
  }

  /* View Update */

  /* Proses */
  $("#form_modal").on("submit", function(e) {
    e.preventDefault();

    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        if ($('#is_new').val() != '') var url = '<?= base_url('sample/request/updateRequest') ?>';
        else var url = '<?= base_url('sample/request/insertRequest') ?>';

        // if ($('#transaksi_detail_id').val() != '') var url = '<?= base_url('sample/request/updateRequest') ?>';
        // else var url = '<?= base_url('sample/request/insertRequest') ?>';

        // if ($('#transaksi_detail_foto').val() == '' && $('#temp_transaksi_detail_foto').val() == '') {
        //   toastr.error('Mohon Isi Inputan yang Bertanda *');
        if ($('#peminta_jasa_id').val() == null) {
          toastr.error('Mohon Isi Inputan yang Bertanda *');
          // } else if ($('#jenis_id').val() == null) {
          //   toastr.error('Mohon Isi Inputan yang Bertanda *');
        } else if ($('#jenis_pekerjaan_id').val() == null) {
          toastr.error('Mohon Isi Inputan yang Bertanda *');
          // } else if ($('#transaksi_detail_jumlah').val() == '') {
          //   toastr.error('Mohon Isi Inputan yang Bertanda *');
        } else if ($('#transaksi_detail_no_memo').val() == '') {
          toastr.error('Mohon Isi Inputan yang Bertanda *');
          // } else if ($('#traMohon Isi Inputan yang Bertanda *nsaksi_detail_parameter').val() == '') {
          //   toastr.error('Mohon Isi Inputan yang Bertanda *');
          // } else if ($('#transaksi_detail_tgl_memo').val() == '') {
          // toastr.error('Mohon Isi Inputan yang Bertanda *');
        } else if ($('#transaksi_klasifikasi_id').val() == '') {
          toastr.error('Mohon Isi Inputan yang Bertanda *');
        } else {
          // var transaksi_detail_foto = $('#transaksi_detail_foto').prop('files')[0];
          var data = new FormData();

          // data.append('transaksi_detail_foto', transaksi_detail_foto);
          data.append('transaksi_id', $('#transaksi_id').val());
          data.append('transaksi_non_rutin_id', $('#transaksi_non_rutin_id').val());
          data.append('transaksi_detail_id', $('#transaksi_detail_id').val());
          data.append('transaksi_tipe', $('#transaksi_tipe').val());
          data.append('peminta_jasa_id', $('#peminta_jasa_id').val());
          // data.append('jenis_id', $('#jenis_id').val());
          data.append('jenis_pekerjaan_id', $('#jenis_pekerjaan_id').val());
          data.append('transaksi_klasifikasi_id', $('#transaksi_klasifikasi_id').val());
          data.append('transaksi_detail_pic_pengirim', $('#transaksi_detail_pic_pengirim').val());
          data.append('transaksi_detail_ext_pengirim', $('#transaksi_detail_ext_pengirim').val());
          // data.append('transaksi_detail_jumlah', $('#transaksi_detail_jumlah').val());
          data.append('transaksi_detail_tgl_pengajuan', $('#transaksi_detail_tgl_pengajuan').val());
          // data.append('transaksi_detail_tgl_memo', $('#transaksi_detail_tgl_memo').val());
          data.append('transaksi_detail_no_memo', $('#transaksi_detail_no_memo').val());
          // data.append('identitas_id', $('#identitas_id').val());
          // ($('#transaksi_detail_parameter').val() == '') ? data.append('transaksi_detail_parameter', 0): data.append('transaksi_detail_parameter', $('#transaksi_detail_parameter').val());
          data.append('transaksi_detail_note', $('#transaksi_detail_note').val());
          // data.append('temp_transaksi_detail_foto', $('#temp_transaksi_detail_foto').val());

          $.ajax({
            url: url,
            data: data,
            type: 'POST',
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
              $('#loading_form').css('display', 'block');
              $('#simpan').css('display', 'none');
              $('#edit').css('display', 'none');
            },
            success: function(result, status, xhr) {
              if (result) {
                toastr.error(result);
                $('#loading_form').css('display', 'none');
                $('#simpan').css('display', 'block');
                $('#edit').css('display', 'none');
              } else {
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
            }
          });
        }
      }
    });
  });
  /* Proses */

  /* Fun Delete */
  function fun_delete(id) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        setTimeout(function() {
          $('#' + id).parents('tr').attr('style', 'color: red')
        }, 500);
        setTimeout(function() {
          $('#' + id).parents('tr').attr('style', 'color: black')
        }, 3000);
        ($('#transaksi_tipe').val());
        $.confirmModal('Apakah anda yakin akan menghapusnya? Seluruh Sample Yang Terkait Akan Ikut Terhapus!!', function(el) {
          $.get('<?= base_url('sample/request/deleteRequest') ?>', {
            transaksi_non_rutin_id: id
          }, function(data) {
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
          });
        })
      }
    });
  }

  /* Fun Delete */

  /* Fun Close */
  function fun_close() {
    $('#simpan').css('display', 'block');
    $('#edit').css('display', 'none');
    $('#loading_form').css('display', 'none');
    $('#div_transaksi_detail_foto_sebelumnya').css('display', 'none');
    $('#peminta_jasa_id').empty();
    $('#jenis_id').empty();
    $('#jenis_pekerjaan_id').empty();
    $('#identitas_id').empty();
    $('#form_modal')[0].reset();
    $('#table').DataTable().ajax.reload();
    fun_loading();
  }
  /* Fun Close */

  $('#modal').on('hidden.bs.modal', function(e) {
    fun_close();
  });

  /* Fun Identitas */
  function fun_identitas(id) {
    $('#identitas_id').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url('sample/request/getSampleIdentitas?jenis_id=') ?>' + id,
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
  /* Fun Identitas */

  /* Fun Loading */
  function fun_loading() {
    var simplebar = new Nanobar();
    simplebar.go(100);
  }
  /* Fun Loading */

  function fun_tambah() {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        // $('#transaksi_detail_tgl_memo').val('');
        $('#transaksi_id').val(Date.now());
        $('#transaksi_non_rutin_id').val(Date.now() * 2);
        var id = $('#transaksi_id').val();
        setTimeout(function() {
          easyuiRenderSample($('#transaksi_non_rutin_id').val());
        }, 500);
      }
    })
  }


  // detail
  function fun_detail(id) {
    $('#table_detail').DataTable().ajax.url('<?= base_url('sample/request/getRequestDetail?transaksi_non_rutin_id=') ?>' + id).load();
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

  // EASY UI
  // deklarasi tab
  function easyuiRenderSample(id) {
    $('#dg_sample').edatagrid({
      url: '<?= base_url('/sample/request/getEasyuiSample?transaksi_non_rutin_id=') ?>' + id,
      saveUrl: '<?= base_url('/sample/request/insertEasyuiSample') ?>',
      updateUrl: '<?= base_url('/sample/request/editEasyuiSample') ?>',

      onEndEdit: function(index, row) {
        var e = $(this).datagrid('getEditor', {
          index: index,
          field: 'transaksi_detail_foto'
        });
        var files = $(e.target).filebox('files');
        if (files.length) {
          row.savedFileName = e.target.filebox('getText');
        }
      },

      columns: [
        [{
            formatter: function(value, row) {
              return row.jenis_nama
            },
            field: 'jenis_id',
            title: 'Jenis Sample',
            width: '17%',
            editor: {
              type: 'combobox',
              options: {
                idField: 'jenis_id',
                textField: 'jenis_nama',
                valueField: 'jenis_id',
                url: '<?= base_url() ?>master/jenis_sample_uji/getJenisSampleUji',
                mode: 'remote',
                fitColumns: true,
                onSelect: function(value) {
                  var row = $('#dg_sample').datagrid('getSelected');
                  var rowIndex = $('#dg_sample').datagrid('getRowIndex', row);
                  var url = '<?= base_url() ?>master/jenis_sample_uji/getSampleIdentitas?jenis_id=' + value.jenis_id;
                  var ed = $('#dg_sample').edatagrid('getEditor', {
                    index: rowIndex,
                    field: 'identitas_id'
                  });
                  (ed.target).combobox('reload', url);
                },
                columns: [
                  [{
                    field: 'jenis_nama',
                    title: 'Jenis Sample',
                    width: 300
                  }, ]
                ],
                panelHeight: 135
              }
            }
          },
          {
            field: 'transaksi_detail_jumlah',
            title: 'Jumlah Sample',
            width: '17%',
            editor: {
              type: 'numberspinner',
              options: {
                required: true,
                max: 25
              }
            }
          },
          {
            formatter: function(value, row) {
              return row.identitas_nama;
            },
            field: 'identitas_id',
            title: 'Identitas Sample',
            width: '17%',
            editor: {
              type: 'combobox',
              options: {
                idField: 'identitas_id',
                textField: 'identitas_nama',
                valueField: 'identitas_id',
                url: '<?= base_url() ?>master/jenis_sample_uji/getSampleIdentitas',
                mode: 'remote',
                fitColumns: true,
                onSelect: function(isi, value) {
                  setTimeout(function() {
                    var row = $('#dg_sample').datagrid('getSelected');
                    rowIndex = $('#dg_sample').datagrid('getRowIndex', row);
                    rows = $('#dg_sample').datagrid('getRows');
                    var ed = $('#dg_sample').datagrid('getEditor', {
                      index: rowIndex,
                      field: 'transaksi_detail_parameter'
                    });
                    var text = $(ed.target).numberspinner('setValue', isi.identitas_parameter);
                  }, 0);
                },
                columns: [
                  [{
                    field: 'identitas_nama',
                    title: 'Identitas',
                    width: 300
                  }, ]
                ],
                panelHeight: 135
              }
            }
          },
          {
            field: 'transaksi_detail_keterangan',
            title: 'Keterangan',
            width: '17%',
            editor: {
              type: 'text',
              options: {
                required: false,
              }
            }
          },
          {
            field: 'transaksi_detail_parameter',
            title: 'Parameter Sample',
            width: '15%',
            editor: {
              type: 'numberspinner',
              options: {
                required: true,
                max: 25
              }
            }
          },
          {
            field: 'transaksi_detail_foto',
            title: 'Foto Sample',
            width: '17%',
            formatter: (value, row) => row.fileName || value,
            editor: {
              type: 'filebox',
              options: {
                accept: 'Image/gif,image/jpg,image/jpeg,image/png',
                buttonText: '...',
                onChange: function() {
                  var self = $(this);
                  var files = self.filebox('files')
                  var formData = new FormData();

                  self.filebox('setText', 'Menyimpan...');
                  formData.append('transaksi_id', $('#transaksi_id').val());
                  for (var i = 0; i < files.length; i++) {
                    var file = files[i];
                    formData.append('file', file, file.name);
                  }
                  $.ajax({
                    url: '<?= base_url('sample/request/insertEasyuiSampleFile') ?>',
                    type: 'post',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                      self.filebox('setText', data);
                    }
                  })
                }
              },
            },
          },
        ],
      ],

    });
  }
  // deklarasi tab

  // tambah
  function easyuiNewSample() {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        fun_loading();
        var id = $('#transaksi_id').val();
        var id_non_rutin = $('#transaksi_non_rutin_id').val();
        $('#dg_sample').edatagrid('addRow', {
          index: 0,
          row: {
            transaksi_id: id,
            transaksi_non_rutin_id: id_non_rutin,
            transaksi_detail_jumlah: 1,
          },
        });
      }
    })
  }
  // tambah

  // simpan
  function easyuiSaveSample() {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        fun_loading();
        $('#dg_sample').edatagrid('saveRow');
        setTimeout(() => {
          $('#dg_sample').datagrid('reload')
        }, 1000);
      }
    })
  }
  // simpan


  // hapus
  function easyuiDeleteSample() {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        fun_loading();
        var row = $('#dg_sample').datagrid('getSelected');
        $.post('<?= base_url() ?>sample/request/deleteEasyuiSample', {
          transaksi_detail_id: row.transaksi_detail_id
        }, function(data, textStatus, xhr) {
          $('#dg_sample').datagrid('reload');
        });
      }
    })
  }
  // hapus

  // reload dg
  function fun_reload_request() {
    fun_loading();
    setTimeout(() => {
      $('#dg_sample').datagrid('reload')
    }, 1000);
  }
  // reload dg
  // EASYUi

  // function fun_notifLogout(){
  //   Swal.fire({
  //           text: "Session Anda Telah Habis, Silahkan Login Kembali",
  //           icon: "warning",
  //           confirmButtonColor: "#34c38f",
  //           confirmButtonText: "Iya",
  //       }).then(function (result) {
  //           if (result.value) {
  //             location.href = '<?= base_url('login') ?>';
  //       }
  //     })
  // }
</script>