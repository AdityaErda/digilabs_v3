<script type="text/javascript">
  var urut = '<?= count($sample_detail) ?>';

  $(function() {
    var id = '<?= $this->input->get('non_rutin') ?>';

    /* SELECT2 */
    // Transaksi Kecepetan Tanggap
    $('#transaksi_kecepatan_tanggap').select2({
      placeholder: 'Pilih',
    });

    // Transaksi Klasifikasi
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

    // Transaksi Sifat
    $('#transaksi_sifat').select2({
      placeholder: 'Pilih',
    });

    // Transaksi Reviewer
    $('#transaksi_reviewer').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url('api/user/getUserAVPList') ?>',
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

    // Transaksi Approver
    $('#transaksi_approver').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url('api/user/getUserVPAVPList') ?>',
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

    // Transaksi Drafter
    $('#transaksi_drafter').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url('api/user/getUserList') ?>',
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

    // Transaksi Tujuan
    $('#transaksi_tujuan').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url('api/user/getUserLabList') ?>',
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

    // Peminta Jasa
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

    // Transaksi Detail PIC
    $('#transaksi_detail_pic_pengirim').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url('api/user/getUserList') ?>',
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

    /*identitas*/
    $.ajaxSetup({
      cache: false
    });
    $('#transaksi_detail_identitas').keyup(function() {
      $('#transaksi_detail_identitas_hasil').html('');
      $('#state').val('');
      var searchField = $('#transaksi_detail_identitas').val();
      var expression = new RegExp(searchField, "i");

      $.getJSON('<?= base_url('sample/request/getIdentitas') ?>', {
        jenis_id: $('#jenis_id').val(),
        search: searchField
      },
      function(data) {
        $.each(data, function(key, value) {
            // console.log(value.identitas_nama.search());
          if (value.identitas_nama.search(expression) != -1) {
            if (searchField != '') {
              $('#transaksi_detail_identitas_hasil').append(`
                <li class="list-group-item link-class">
                <span id="list_identitas_id" style="display:none">` + value.identitas_id + `</span>
                <span id="list_identitas_nama">` + value.identitas_nama + `</span>
                </li>`);
            }
          }
        });
      });
    })

    $('#transaksi_detail_identitas_hasil').on('click', 'li', function() {
      let identitas_id = $(this).children('#list_identitas_id').text();
      let identitas_nama = $(this).children('#list_identitas_nama').text();
      $('#transaksi_detail_identitas').val(identitas_nama);
      $('#identitas_id').val(identitas_id);
      $("#transaksi_detail_identitas_hasil").html('');
    });
    /*identitas*/

    <?php foreach ($sample_detail as $key => $detail) : ?>
      // Jenis Sample
      $('#jenis_id_<?= $key ?>').select2({
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
      $('#jenis_id_<?= $key ?>').on('select2:select', function(e) {
        var data = e.params.data;
        $('#transaksi_detail_parameter_<?= $key ?>').val(data.parameter);
        $('#item_judul_<?= $key ?>').val(data.text);
      });

      // Jenis Pekerjaan
      $('#jenis_pekerjaan_id_<?= $key ?>').select2({
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

      /*identitas*/
      $.ajaxSetup({
        cache: false
      });
      $('#transaksi_detail_identitas_<?= $key ?>').keyup(function() {
        $('#transaksi_detail_identitas_hasil_<?= $key ?>').html('');
        $('#state').val('');
        var searchField = $('#transaksi_detail_identitas_<?= $key ?>').val();
        var expression = new RegExp(searchField, "i");

        $.getJSON('<?= base_url('sample/request/getIdentitas') ?>', {
          jenis_id: $('#jenis_id_<?= $key ?>').val(),
          search: searchField
        },
        function(data) {
          $.each(data, function(key, value) {
              // console.log(value.identitas_nama.search());
            if (value.identitas_nama.search(expression) != -1) {
              if (searchField != '') {
                $('#transaksi_detail_identitas_hasil_<?= $key ?>').append(`
                  <li class="list-group-item link-class">
                  <span id="list_identitas_id_<?= $key ?>" style="display:none">` + value.identitas_id + `</span>
                  <span id="list_identitas_nama_<?= $key ?>">` + value.identitas_nama + `</span>
                  </li>`);
              }
            }
          });
        });
      })

      $('#transaksi_detail_identitas_hasil_<?= $key ?>').on('click', 'li', function() {
        let identitas_id = $(this).children('#list_identitas_id_<?= $key ?>').text();
        let identitas_nama = $(this).children('#list_identitas_nama_<?= $key ?>').text();
        $('#transaksi_detail_identitas_<?= $key ?>').val(identitas_nama);
        $('#identitas_id_<?= $key ?>').val(identitas_id);
        $("#transaksi_detail_identitas_hasil_<?= $key ?>").html('');
      });
      /*identitas*/

    <?php endforeach; ?>

    $('.select2-selection').css('height', '37px');
    $('.select2').css('width', '100%');
    /* SELECT2 */

    /* Get Data */
    $.getJSON('<?= base_url('sample/request/getRequest') ?>', {
      transaksi_non_rutin_id: id
    }, function(data) {
      if (data.transaksi_status == '4') {
        $('.disabled').attr('disabled', false);
      } else {
        $('.disabled').attr('disabled', true);
      }

      /* Detail Surat */
      /* Kiri */
      $('#transaksi_non_rutin_id').val(data.transaksi_non_rutin_id);
      $('#transaksi_id').val(data.transaksi_id);
      $('#transaksi_tipe').val(data.transaksi_tipe);
      $('#transaksi_judul').val(data.transaksi_judul);
      $('#transaksi_kecepatan_tanggap').val(data.transaksi_kecepatan_tanggap).trigger('change');
      var newOptionKlasifikasi = new Option(data.klasifikasi_nama + ' - ' + data.klasifikasi_kode, data.klasifikasi_id, true, true);
      $('#transaksi_klasifikasi_id').append(newOptionKlasifikasi).trigger('change');
      $('#transaksi_sifat').val(data.transaksi_sifat).trigger('change');
      /* Kiri */
      /* Kanan */
      var newOptionReviewer = new Option(data.nik_reviewer + ' - ' + data.nama_reviewer + ' - ' + data.title_reviewer, data.nik_reviewer, true, true);
      $('#transaksi_reviewer').append(newOptionReviewer).trigger('change');
      var newOptionApprover = new Option(data.nik_approver + ' - ' + data.nama_approver + ' - ' + data.title_approver, data.nik_approver, true, true);
      $('#transaksi_approver').append(newOptionApprover).trigger('change');
      var newOptionDrafter = new Option(data.nik_drafter + ' - ' + data.nama_drafter + ' - ' + data.title_drafter, data.nik_drafter, true, true);
      $('#transaksi_drafter').append(newOptionDrafter).trigger('change');
      var newOptionTujuan = new Option(data.nik_tujuan + ' - ' + data.nama_tujuan + ' - ' + data.title_tujuan, data.nik_tujuan, true, true);
      $('#transaksi_tujuan').append(newOptionTujuan).trigger('change');
      /* Kanan */
      /* Detail Surat */

      /* Detail Sample */
      var newOptionPemintaJasa = new Option(data.peminta_jasa_nama, data.peminta_jasa_id, true, true);
      $('#peminta_jasa_id').append(newOptionPemintaJasa).trigger('change');
      var newOptionPIC = new Option(data.nik_pic_pengirim + ' - ' + data.nama_pic_pengirim + ' - ' + data.title_pic_pengirim, data.nik_pic_pengirim, true, true);
      $('#transaksi_detail_pic_pengirim').append(newOptionPIC).trigger('change');
      $('#transaksi_detail_pic_telepon').val(data.transaksi_pic_telepon);
      $('#transaksi_detail_ext_pengirim').val(data.transaksi_pic_ext);
      /* Detail Sample */
    });
    /* Get Data */

    /* DataTable */
    /* Disposisi AVP */
    $('#table_disposisi').DataTable({
      drawCallback: function() {
        $(".transaksi_disposisi_avp").select2({
          placeholder: "Pilih",
          ajax: {
            delay: 250,
            url: "<?= base_url('api/user/getUserAVPLabList?user_nik_sap=2095205') ?>",
            dataType: "json",
            type: "GET",
            data: function(params) {
              var queryParameters = {
                param_search: params.term
              }
              return queryParameters;
            }
          }
        });
        $('.select2-selection').css('height', '37px');
        $('.select2').css('width', '100%');
        $.getJSON('<?= base_url() ?>api/user/getUserList2', {
          user_nik_sap: '2095205'
          // user_nik_sap: '2095205-AVP'
        }, function(jsonAPV) {
          var newOption = new Option(jsonAPV.text, jsonAPV.id, true, true);
          $('.transaksi_disposisi_avp').append(newOption).trigger('change');
        });
      },
      "ajax": {
        "url": "<?= base_url('sample/request/getRequestDetail?transaksi_non_rutin_id=') ?>" + $('#transaksi_non_rutin_id').val(),
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
          return (row.transaksi_detail_file) ? '<center><a href="#" id="' + row.transaksi_detail_file + '" data-toggle="modal" data-target="#modal_lihat" onclick="fun_lihat(this.id)"><i class="fa fa-image"></i></a></center>' : '-';
        }
      },
      {
        "render": function(data, type, row, meta) {

          return '<input type="text" style="display:none" id="transaksi_disposisi_avp_id_transaksi' + meta.row + '" name="transaksi_disposisi_avp_id_transaksi[]" value="' + row.transaksi_id + '">\
          <input type="text" style="display:none" id="transaksi_disposisi_avp_id_transaksi_detail' + meta.row + '" name="transaksi_disposisi_avp_id_transaksi_detail[]" value="' + row.transaksi_detail_id + '">\
          <select class="transaksi_disposisi_avp form-control select2" id="transaksi_disposisi_avp' + meta.row + '" name="transaksi_disposisi_avp[]" width="100%">\
          </select>'
        }
      },
      ]
    });
    /* Disposisi AVP */

    /* Disposisi Seksi */
    $('#table_disposisi_seksi').DataTable({
      drawCallback: function() {
        $(".transaksi_disposisi_seksi").select2({
          placeholder: "Pilih",
          ajax: {
            delay: 250,
            url: "<?= base_url('sample/approve/getSeksi') ?>",
            dataType: "json",
            type: "GET",
            data: function(params) {
              var queryParameters = {
                param_search: params.term
              }
              return queryParameters;
            }
          }
        });

        $('.select2-selection').css('height', '37px');
        $('.select2').css('width', '100%');
      },
      "ajax": {
        "url": "<?= base_url('sample/request/getRequestDetail?transaksi_non_rutin_id=') ?>" + $('#transaksi_non_rutin_id').val(),
        "dataSrc": "",
      },
      "columns": [{
        "data": "jenis_nama"
      },
      {
        "data": "sample_pekerjaan_nama"
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
          return (row.transaksi_detail_file) ? '<center><a href="#" id="' + row.transaksi_detail_file + '" data-toggle="modal" data-target="#modal_lihat" onclick="fun_lihat(this.id)"><i class="fa fa-image"></i></a></center>' : '-';
        }
      },
      {
        "render": function(data, type, row, meta) {
          return '<input type="text" style="display:none" id="transaksi_disposisi_seksi_id_transaksi' + meta.row + '" name="transaksi_disposisi_seksi_id_transaksi[]" value="' + row.transaksi_id + '">\
          <input type="text" style="display:none" id="transaksi_disposisi_seksi_id_transaksi_detail' + meta.row + '" name="transaksi_disposisi_seksi_id_transaksi_detail[]" value="' + row.transaksi_detail_id + '">\
          <select class="transaksi_disposisi_seksi form-control select2" id="transaksi_disposisi_seksi' + meta.row + '" name="transaksi_disposisi_seksi[]" width="100%">\
          </select>'
        }
      },
      ]
    })
    /* Disposisi Seksi */

    /* Disposisi Seksi Chemlat */
    $('#table_disposisi_seksi_chemlat').DataTable({
      drawCallback: function(settings) {
        setTimeout(() => {
          var urut = 0;
          var data = $('#table_disposisi_seksi_chemlat').DataTable().rows().data();
          var jumlah = data.length;
          $(".tanggal").daterangepicker({
            showDropdowns: true,
            singleDatePicker: true,
            locale: {
              format: 'DD-MM-YYYY'
            },
          });

          $(".transaksi_disposisi_seksi_chemlat").select2({
            placeholder: "Pilih",
            ajax: {
              delay: 250,
              url: "<?= base_url('sample/approve/getSeksi') ?>",
              dataType: "json",
              type: "GET",
              data: function(params) {
                var queryParameters = {
                  param_search: params.term
                }
                return queryParameters;
              }
            }
          });

          for (var i = 0; i < jumlah; i++) {
            var id = $("#transaksi_disposisi_seksi_id_chemlat_" + i).val()
            // console.log(id);
            $('#transaksi_petugas_sampling_chemlat_' + i).select2({
              placeholder: "Pilih",
              ajax: {
                delay: 250,
                // url: "<?= base_url('sample/notifikasi/getUserBySeksi?id_seksi=') ?>" + id,
                url: "<?= base_url('sample/notifikasi/getUserBySeksi') ?>",
                dataType: "json",
                type: "GET",
                data: function(params) {
                  var queryParameters = {
                    user_nama_lengkap: params.term,
                  }
                  return queryParameters;
                }
              }
            });
          }

          $('.select2-selection').css('height', '37px');
          $('.select2').css('width', '100%');
        }, 2500);
      },
      "ajax": {
        "url": "<?= base_url('sample/lab/getLabDetail?transaksi_non_rutin_id=') ?>" + $('#transaksi_non_rutin_id').val() + '&transaksi_status=' + $('#transaksi_status').val(),
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
          return (row.transaksi_detail_file) ? '<center><a href="#" id="' + row.transaksi_detail_file + '" data-toggle="modal" data-target="#modal_lihat" onclick="fun_lihat(this.id)"><i class="fa fa-image"></i></a></center>' : '-';
        }
      },
      {
        "render": function(data, type, row, meta) {
          if (row.transaksi_id == $('#transaksi_id').val() && row.transaksi_detail_status == '5') {
            $.getJSON("<?= base_url() ?>sample/lab/getSeksiDisposisi", {
              id_transaksi: row.transaksi_id,
            },
            function(datas, textStatus, jqXHR) {
              $('#transaksi_disposisi_seksi_chemlat_' + meta.row).append('<option selected value="' + row.seksi_id + '">' + row.seksi_nama + '</option>');
              $('#transaksi_disposisi_seksi_chemlat_' + meta.row).trigger('change');
              $('#transaksi_disposisi_seksi_id_chemlat_' + meta.row).val(row.seksi_id);
              $.each(datas, function(index, value) {
                    // $('#transaksi_disposisi_seksi_chemlat_' + meta.row).append('<option selected value="' + value.id_seksi + '">' + value.seksi_nama + '</option>');
                    // $('#transaksi_disposisi_seksi_chemlat_' + meta.row).trigger('change');
                    // $('#transaksi_disposisi_seksi_id_chemlat_' + meta.row).val(value.id_seksi);
                    // $('#transaksi_disposisi_seksi_chemlat_' + meta.row).select2('data', {
                    // id: value.id_seksi,
                    // text: value.seksi_nama,
                    // });
              });
            }
            );
          }
          var input;
          input = '<input type="text" style="display:none" id="transaksi_disposisi_seksi_id_transaksi' + meta.row + '" name="transaksi_disposisi_seksi_id_transaksi_chemlat[]" value="' + row.transaksi_id + '">';
          input += '<input type="text" style="display:none" id="transaksi_disposisi_seksi_id_transaksi_detail' + meta.row + '" name="transaksi_disposisi_seksi_id_transaksi_detail_chemlat[]" value="' + row.transaksi_detail_id + '">';
          input += '<input type="text" style="display:none" id="transaksi_disposisi_seksi_id_chemlat_' + meta.row + '" name="transaksi_disposisi_seksi_id_chemlat[]">';
          input += '<select class="transaksi_disposisi_seksi_chemlat form-control select2" id="transaksi_disposisi_seksi_chemlat_' + meta.row + '" name="transaksi_disposisi_seksi_chemlat[]" width="100%"></select>';
          return input
        }
      }, {
        "render": function(data, type, row, meta) {
          var petugas;
          petugas = '<select multiple class="transaksi_petugas_sampling_chemlat form-control select2" id="transaksi_petugas_sampling_chemlat_' + meta.row + '" name="transaksi_petugas_sampling_chemlat[' + row.transaksi_detail_id + '][]" width="100%"></select>'
          return petugas
        }
      },
      {
        "data": "transaksi_detail_id"
      }
      ],
      "columnDefs": [{
        'targets': [8],
        'render': function(data, type, full, meta) {
          if (full.sample_pekerjaan_kode == '1' || full.sample_pekerjaan_kode == '2') {
            return '<input type="text" class="form-control float-right tanggal" id="transaksi_detail_tgl_sampling_' + meta.row + '" name="transaksi_detail_tgl_sampling[]">'
          } else {
            return '<input type="text" class="form-control float-right " id="transaksi_detail_tgl_sampling_' + meta.row + '" name="transaksi_detail_tgl_sampling[]" value="00-00-0000" style="display:none">-';
          }
        }
      }, ]
    })
    /* Disposisi Seksi Chemlat */
    /* DataTable */
});

  /* Ganti Reviewer */
function gantiReviewer(id) {
  $.getJSON("<?= base_url() ?>api/user/getUserList3", {
    user_nik_sap: id
  }, function(data) {
    $('#transaksi_reviewer_poscode').val(data.user_poscode)
  });
}
  /* Ganti Reviewer */

  /* Ganti Approver */
function gantiApprover(id) {
  $.getJSON("<?= base_url() ?>api/user/getUserList3", {
    user_nik_sap: id
  }, function(data) {
    $('#transaksi_approver_poscode').val(data.user_poscode)
  });
}
  /* Ganti Approver */

  /* Ganti Drafter */
function gantiDrafter(id) {
  $.getJSON("<?= base_url() ?>api/user/getUserList3", {
    user_nik_sap: id
  }, function(data) {
    $('#transaksi_drafter_poscode').val(data.user_poscode)
  });
}
  /* Ganti Drafter */

  /* Ganti Tujuan */
function gantiTujuan(id) {
  $.getJSON("<?= base_url() ?>api/user/getUserList3", {
    user_nik_sap: id
  }, function(data) {
    $('#transaksi_tujuan_poscode').val(data.user_poscode)
  })
};
  /* Ganti Tujuan */

  /* Ganti PIC */
function gantiPICPengirim(id) {
  $('#transaksi_pic_pengirim_id').val(id);
  $.getJSON("<?= base_url() ?>api/user/getUserList3", {
    user_nik_sap: id
  }, function(data) {
    $('#transaksi_pic_pengirim_poscode').val(data.user_poscode);
  });
}
  /* Ganti PIC */

  /* Tambah Item */
$('#add_item').on('click', function() {
  urut++;
  var html = '';

  html += '<div class="div_item_baru">';
  html += '<div class="row">';
  html += '<div class="form-group row col-md-12">';
  html += '<div class="col-11">';
  html += '<input id="transaksi_detail_id" name="transaksi_detail_id[]" value="<?= create_id(); ?>_' + urut + '" style="display:none">';
  html += '<input required type="text" class="form-control" id="item_judul_' + urut + '" name="item_judul[]" placeholder="Judul" value="Sample ' + urut + '" style=" border:none;border-bottom: 1px solid #1890ff;padding: 5px 10px;  outline: none;">';
  html += '</div>';
  html += '<div class="col-1">';
  html += '<button class="btn btn-danger btn-custom remove_item float-right" type="button" id="remove_item">Hapus</button>';
  html += '</div>';
  html += '</div>';
  html += '</div>';
  html += '<div class="row">';
  html += '<div class="col-6">';
  html += '<div class="form-group row col-12">';
  html += '<label class="col-md-4">Jenis Sample</label>';
  html += '<div class="col-md-8">';
  html += '<select name="jenis_id[]" id="jenis_id_' + urut + '" class="form-control select2"></select>';
  html += '</div>';
  html += '</div>';
  html += '<div class="form-group row col-12">';
  html += '<label class="col-md-4">Jenis Pekerjaan</label>';
  html += '<div class="col-md-8">';
  html += '<select name="jenis_pekerjaan_id[]" id="jenis_pekerjaan_id_' + urut + '" class="form-control select2"></select>';
  html += '</div>';
  html += '</div>';
  html += '<div class="form-group row col-12">';
  html += '<label  class="col-md-4">Jumlah Sample</label>';
  html += '<div class="col-8">';
  html += '<input type="text" id="transaksi_detail_jumlah" name="transaksi_detail_jumlah[]" value="1" class="form-control" onkeypress="return numberOnly(event)">';
  html += '</div>';
  html += '</div>';
  html += '<div class="form-group row col-12">';
  html += '<label  class="col-md-4">Identitas Sample</label>';
  html += '<div class="col-8">';
  html += '<input type="text" id="transaksi_detail_identitas_' + urut + '" name="transaksi_detail_identitas[]" placeholder="Identitas Sample" class="form-control">';
  html += '<input type="text" id="identitas_id_' + urut + '" name="identitas_id[]" style="display: none">';
  html += '<ul class="list-group" id="transaksi_detail_identitas_hasil_' + urut + '"></ul>';
  html += '</div>';
  html += '</div>';
  html += '<div class="form-group row col-12">';
  html += '<label  class="col-md-4">Jumlah Parameter</label>';
  html += '<div class="col-8">';
  html += '<input type="text" id="transaksi_detail_parameter_' + urut + '" name="transaksi_detail_parameter[]" placeholder="Parameter Sample" class="form-control" onkeypress="return numberOnly(event)">';
  html += '</div>';
  html += '</div>';
  html += '<div class="form-group row col-12">';
  html += '<label  class="col-md-4">Deskripsi Parameter Uji / Kalibrasi</label>';
  html += '<div class="col-8">';
  html += '<textarea name="transaksi_detail_deskripsi_parameter[]" id="transaksi_detail_deskripsi_parameter" cols="3" rows="3" class="form-control" placeholder="Analisa Cu, Pb, Uji Aplikasi, Analisa Kimia / Kalibrasi Suhu Range 10 Derajat C, 20 Derajat C"></textarea>';
  html += '</div>';
  html += '</div>';
  html += '<div class="form-group row col-12">';
  html += '<label  class="col-md-4">Catatan Pengajuan</label>';
  html += '<div class="col-8">';
  html += '<textarea name="transaksi_detail_catatan[]" id="transaksi_detail_catatan" cols="3" rows="3" class="form-control" placeholder="Untuk kebutuhan Extra Cek Pabrik NPK 5"></textarea>';
  html += '</div>';
  html += '</div>';
  html += '</div>';
  html += '<div class="col-6">';
  html += '<div class="form-group row col-12">';
  html += '<label  class="col-md-4">Attachment</label>';
  html += '<div class="col-8">';
  html += '<input type="file" name="transaksi_detail_attachment[]" id="transaksi_detail_attachment" class="form-control" required accept="application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-powerpoint, application/vnd.openxmlformats-officedocument.presentationml.presentation, text/plain, application/pdf, image/*"  >';
  html += '</div>';
  html += '</div>';
  html += '<div class="form-group row col-12">';
  html += '<label  class="col-md-4">Foto Sample</label>';
  html += '<div class="col-8">';
  html += '<input type="file" name="transaksi_detail_file[]" id="transaksi_detail_file" class="form-control" accept="image/*" required>';
  html += '</div>';
  html += '</div>';
  html += '</div>';
  html += '</div>';
  html += '</div>';

  $(".div_item").append(html);

    // Jenis Sample
  $('#jenis_id_' + urut).select2({
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
  $('#jenis_id_' + urut).on('select2:select', function(e) {
    var data = e.params.data;
    $('#transaksi_detail_parameter_' + urut).val(data.parameter);
    $('#item_judul_' + urut).val(data.text);
  });

    // Jenis Pekerjaan
  $('#jenis_pekerjaan_id_' + urut).select2({
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

    /*identitas*/
  $.ajaxSetup({
    cache: false
  });
  $('#transaksi_detail_identitas_' + urut).keyup(function() {
    $('#transaksi_detail_identitas_hasil_' + urut).html('');
    $('#state').val('');
    var searchField = $('#transaksi_detail_identitas_' + urut).val();
    var expression = new RegExp(searchField, "i");

    $.getJSON('<?= base_url('sample/request/getIdentitas') ?>', {
      jenis_id: $('#jenis_id_' + urut).val(),
      search: searchField
    },
    function(data) {
      $.each(data, function(key, value) {
            // console.log(value.identitas_nama.search());
        if (value.identitas_nama.search(expression) != -1) {
          if (searchField != '') {
            $('#transaksi_detail_identitas_hasil_' + urut).append(`
              <li class="list-group-item link-class">
              <span id="list_identitas_id_` + urut + `" style="display:none">` + value.identitas_id + `</span>
              <span id="list_identitas_nama_` + urut + `">` + value.identitas_nama + `</span>
              </li>`);
          }
        }
      });
    });
  })

  $('#transaksi_detail_identitas_hasil_' + urut).on('click', 'li', function() {
    let identitas_id = $(this).children('#list_identitas_id_' + urut).text();
    let identitas_nama = $(this).children('#list_identitas_nama_' + urut).text();
    $('#transaksi_detail_identitas_' + urut).val(identitas_nama);
    $('#identitas_id_' + urut).val(identitas_id);
    $("#transaksi_detail_identitas_hasil_" + urut).html('');
  });
    /*identitas*/

  $('.select2-selection').css('height', '37px');
  $('.select2').css('width', '100%');
});
  /* Tambah Item */

  /* Hapus Item */
$(document).on('click', '.remove_item', function() {
  $(this).closest('.div_item_baru').remove();
})
  /* Hapus Item */

  /* Reject */
$('#reject').on('click', function() {
  $('#modal_reject').modal('show');
})

$('#simpan_reject').on('click', function(e) {
  e.preventDefault()
  var set_data = new FormData($('#form_reject')[0]);
  set_data.append('transaksi_non_rutin_id', $('#transaksi_non_rutin_id').val());
  set_data.append('transaksi_status', $("#transaksi_status").val());
  set_data.append('transaksi_tipe', $('#transaksi_tipe').val());
  set_data.append('transaksi_id', $('#transaksi_id').val());

  var url = '<?= base_url() ?>sample/review/insertReject'

  $.ajax({
    type: "POST",
    url: url,
    data: set_data,
    dataType: "HTML",
    processData: false,
    contentType: false,
    cache: false,
    beforeSend: function() {
      $('#loading_reject').show();
      $('#close').hide();
      $('#reject').hide();
      $('#approved').hide();
      $('#simpan_reject').hide();
      $('#close_reject').hide();
    },
    success: function(response) {
      $('#form_reject')[0].reset();
      $('#modal_reject').modal('hide');
      if (response) {
        toastr.error(response);
      } else {
        window.history.go(-1);
      }
    }
  });
})
  /* Reject */

  /* Disposisi AVP */
$('#disposisi_avp').on('click', function() {
  $('#table_disposisi').DataTable().ajax.url('<?= base_url('sample/request/getRequestDetail?transaksi_non_rutin_id=') . $this->input->get('non_rutin') . "&transaksi_status=" . $this->input->get('status') ?>').load();
  $('#modal_disposisi').modal('show');
});

$('#simpan_disposisi_avp').on('click', function(e) {
  e.preventDefault();
  var data = new FormData($('#form_disposisi_avp')[0]);
  data.append('transaksi_status', $('#transaksi_status').val());
  data.append('transaksi_id', $('#transaksi_id').val());
  data.append('transaksi_non_rutin_id', $('#transaksi_non_rutin_id').val());
  data.append('transaksi_tipe', $('#transaksi_tipe').val());

  $.ajax({
    type: "POST",
    url: "<?= base_url() ?>sample/lab/insertDisposisiAVP",
    data: data,
    dataType: "HTML",
    processData: false,
    contentType: false,
    cache: false,
    success: function(response) {
      window.history.go(-1);
    }
  });
})
  /* Disposisi AVP */

  /* Disposisi Seksi */
$('#disposisi_seksi').on('click', function(e) {
  e.preventDefault();
  var data = new FormData($('#form_lab')[0]);
  var url = '<?= base_url() ?>sample/lab/insertLabDetail';

  $.ajax({
    type: "POST",
    url: url,
    data: data,
    dataType: false,
    processData: false,
    contentType: false,
    cache: false,
    success: function(response) {
      $('#table_disposisi_seksi').DataTable().ajax.url('<?= base_url('sample/request/getRequestDetail?transaksi_non_rutin_id=') . $this->input->get('non_rutin') . "&transaksi_status=" . $this->input->get('status') ?>').load()
      $('#modal_disposisi_seksi').modal('show');
    }
  });
});

$('#simpan_disposisi_seksi').on('click', function(e) {
  e.preventDefault();

  var data = new FormData($('#form_disposisi_seksi')[0]);
  var jenis_pekerjaan_id = document.getElementsByName('jenis_pekerjaan_id[]');

  for (var i = 0; i < jenis_pekerjaan_id.length; i++) {
    var a = jenis_pekerjaan_id[i];
    data.append("" + a.name + "", "" + a.value + "");
  }

  var jenis_id = document.getElementsByName('jenis_id[]');

  for (var i = 0; i < jenis_id.length; i++) {
    var a = jenis_id[i];
    data.append("" + a.name + "", "" + a.value + "");
  }

  var transaksi_detail_jumlah = document.getElementsByName('transaksi_detail_jumlah[]');

  for (var i = 0; i < transaksi_detail_jumlah.length; i++) {
    var a = transaksi_detail_jumlah[i];
    data.append("" + a.name + "", "" + a.value + "");
  }

  data.append('transaksi_status', $('#transaksi_status').val());
  data.append('transaksi_id', $('#transaksi_id').val());
  data.append('transaksi_non_rutin_id', $('#transaksi_non_rutin_id').val());
  data.append('transaksi_tipe', $('#transaksi_tipe').val());

  $.ajax({
    type: "POST",
    url: "<?= base_url() ?>sample/lab/insertDisposisiSeksi",
    data: data,
    dataType: "HTML",
    processData: false,
    contentType: false,
    cache: false,
    success: function(response) {
      window.history.go(-1);
    }
  });
})
  /* Disposisi Seksi */

  /* Disposisi Seksi Chemlat */
$('#disposisi_seksi_chemlat').on('click', function() {
  $('#table_disposisi_seksi_chemlat').DataTable().ajax.url('<?= base_url('sample/lab/getLabDetail?transaksi_non_rutin_id=') . $this->input->get('non_rutin') . "&transaksi_status=" . $this->input->get('status') ?>').load();
  $('#modal_disposisi_seksi_chemlat').modal('show');
});

$('#simpan_disposisi_seksi_chemlat').on('click', function(e) {
  e.preventDefault();
  var data = new FormData($('#form_disposisi_seksi_chemlat')[0]);

  var jenis_pekerjaan_id = document.getElementsByName('jenis_pekerjaan_id[]');

  for (var i = 0; i < jenis_pekerjaan_id.length; i++) {
    var a = jenis_pekerjaan_id[i];
    data.append("" + a.name + "", "" + a.value + "");
  }

  var jenis_id = document.getElementsByName('jenis_id[]');

  for (var i = 0; i < jenis_id.length; i++) {
    var a = jenis_id[i];
    data.append("" + a.name + "", "" + a.value + "");
  }

  var transaksi_detail_jumlah = document.getElementsByName('transaksi_detail_jumlah[]');

  for (var i = 0; i < transaksi_detail_jumlah.length; i++) {
    var a = transaksi_detail_jumlah[i];
    data.append("" + a.name + "", "" + a.value + "");
  }

  data.append('transaksi_status', $('#transaksi_status').val());
  data.append('transaksi_id', $('#transaksi_id').val());
  data.append('transaksi_non_rutin_id', $('#transaksi_non_rutin_id').val());
  data.append('transaksi_tipe', $('#transaksi_tipe').val());

  $.ajax({
    type: "POST",
    url: "<?= base_url() ?>sample/lab/insertDisposisiSeksiChemlat",
    data: data,
    dataType: "HTML",
    processData: false,
    contentType: false,
    cache: false,
    success: function(response) {
      window.history.go(-1);
    }
  });
})
  /* Disposisi Seksi Chemlat */

  /* Fun Lihat */
function fun_lihat(isi) {
  $.getJSON('<?= base_url('login/login/checkLogin') ?>', function(json) {
    if (!json.user_id) {
      fun_notifLogout();
    } else {
      $('#document').remove();
      $('#div_document').append('<embed src="<?= base_url('document/') ?>' + isi + '#toolbar=0" frameborder="0" id="document" width="100%" style="height: -webkit-fill-available;"></embed>');
      $('#modal_lihat').modal('show');
    }
  });
}
  /* Fun Lihat */

  /* Loading */
function fun_loading() {
  var simplebar = new Nanobar();
  simplebar.go(100);
}
  /* Loading */
</script>