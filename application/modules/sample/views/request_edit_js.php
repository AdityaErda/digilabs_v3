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
            console.log(value.identitas_nama.search());
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
              console.log(value.identitas_nama.search());
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
      if (data.transaksi_status == '15') {
        $('#div_reject').show();
        $('#transaksi_reject_alasan').val(data.transaksi_reject_alasan);
      }

      if (data.transaksi_status == '1') {
        $('#edit').hide();
      }

      /* Detail Surat */
      /* Kiri */
      $('#transaksi_non_rutin_id').val(data.transaksi_non_rutin_id);
      $('#transaksi_id').val(data.transaksi_id);
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
    html += '<input id="transaksi_detail_id_' + urut + '" name="transaksi_detail_id[]" value="<?= create_id(); ?>_' + urut + '" style="display:none">';
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
    html += '<label for="" class="col-md-4">Jumlah Sample</label>';
    html += '<div class="col-8">';
    html += '<input type="text" id="transaksi_detail_jumlah_' + urut + '" name="transaksi_detail_jumlah[]" value="1" class="form-control" onkeypress="return numberOnly(event)">';
    html += '</div>';
    html += '</div>';
    html += '<div class="form-group row col-12">';
    html += '<label for="" class="col-md-4">Identitas Sample</label>';
    html += '<div class="col-8">';
    html += '<input type="text" id="transaksi_detail_identitas_' + urut + '" name="transaksi_detail_identitas[]" placeholder="Identitas Sample" class="form-control">';
    html += '<input type="text" id="identitas_id_' + urut + '" name="identitas_id[]" style="display: none">';
    html += '<ul class="list-group" id="transaksi_detail_identitas_hasil_' + urut + '"></ul>';
    html += '</div>';
    html += '</div>';
    html += '<div class="form-group row col-12">';
    html += '<label for="" class="col-md-4">Jumlah Parameter</label>';
    html += '<div class="col-8">';
    html += '<input type="text" id="transaksi_detail_parameter_' + urut + '" name="transaksi_detail_parameter[]" placeholder="Parameter Sample" class="form-control" onkeypress="return numberOnly(event)">';
    html += '</div>';
    html += '</div>';
    html += '<div class="form-group row col-12">';
    html += '<label for="" class="col-md-4">Deskripsi Parameter Uji / Kalibrasi</label>';
    html += '<div class="col-8">';
    html += '<textarea name="transaksi_detail_deskripsi_parameter[]" id="transaksi_detail_deskripsi_parameter_' + urut + '" cols="3" rows="3" class="form-control" placeholder="Analisa Cu, Pb, Uji Aplikasi, Analisa Kimia / Kalibrasi Suhu Range 10 Derajat C, 20 Derajat C"></textarea>';
    html += '</div>';
    html += '</div>';
    html += '<div class="form-group row col-12">';
    html += '<label for="" class="col-md-4">Catatan Pengajuan</label>';
    html += '<div class="col-8">';
    html += '<textarea name="transaksi_detail_catatan[]" id="transaksi_detail_catatan_' + urut + '" cols="3" rows="3" class="form-control" placeholder="Untuk kebutuhan Extra Cek Pabrik NPK 5"></textarea>';
    html += '</div>';
    html += '</div>';
    html += '</div>';
    html += '<div class="col-6">';
    html += '<div class="form-group row col-12">';
    html += '<label for="" class="col-md-4">Attachment</label>';
    html += '<div class="col-8">';
    html += '<input type="file" name="transaksi_detail_attachment[]" id="transaksi_detail_attachment_' + urut + '" class="form-control" accept="application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-powerpoint, application/vnd.openxmlformats-officedocument.presentationml.presentation, text/plain, application/pdf, image/jpeg,image/png,image/gif,image/bmp" required>';
    html += '</div>';
    html += '</div>';
    html += '<div class="form-group row col-12">';
    html += '<label for="" class="col-md-4">Foto Sample</label>';
    html += '<div class="col-8">';
    html += '<input type="file" name="transaksi_detail_file[]" id="transaksi_detail_file_' + urut + '" class="form-control" accept="image/jpeg,image/png,image/gif,image/bmp" required>';
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
            console.log(value.identitas_nama.search());
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

  /* Edit */
  $('#edit').on('click', function(e) {
    e.preventDefault();
    var set_data = new FormData($('#form_request')[0]);
    var url = '<?= base_url('sample/request/updateDraft') ?>';

    $.ajax({
      url: url,
      type: 'POST',
      dataType: 'HTML',
      data: set_data,
      contentType: false,
      processData: false,
      cache: false,
      beforeSend: function() {
        $('#loading_form').show();
        // $('#close').hide();
        // $('#ajukan').hide();
        // $('#draft').hide();
        // $('#edit').hide();
      },
      success: function(response) {
        if (response == '0') {
          toastr.warning('Format File Tidak Didukung');
          $('#loading_form').hide();
        } else {
          location.href = '<?= base_url('sample/request/?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) ?>'
        }
      }
    });
  })
  /* Edit */

  /* Ajukan */
  // $('#ajukan').on('click', function(e) {
  //   e.preventDefault();
  //   var set_data = new FormData($('#form_request')[0]);
  //   var url = ($('#is_new').val() == '') ? '<?= base_url('sample/request/insertAjukan') ?>' : '<?= base_url('sample/request/updateAjukan') ?>';

  //   $.ajax({
  //     type: "POST",
  //     url: url,
  //     data: set_data,
  //     dataType: "HTML",
  //     contentType: false,
  //     processData: false,
  //     cache: false,
  //     beforeSend: function() {
  //       $('#loading_form').show();
  //     },
  //     success: function(response) {
  //       if (response == '0') {
  //         toastr.warning('Format File Tidak Didukung');
  //         $('#loading_form').hide();
  //       } else {
  //         location.href = '<?= base_url('sample/request/?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) ?>'
  //       }
  //     }
  //   });
  // })
  /* Ajukan */

  /*Ajukan*/
  $('#ajukan').on('click', function(e) {
    var data = new FormData($('#form_request')[0]);
    if ($('#transaksi_judul').val() == '') {
      $('#alert_judul').css('display', 'block');
    } else {
      $('#alert_judul').css('display', 'none');
    }

    if ($('#transaksi_klasifikasi_id').val() == null) {
      $('#alert_klasifikasi').css('display', 'block');
    } else {
      $('#alert_klasifikasi').css('display', 'none');
    }

    if ($('#transaksi_detail_pic_telepon').val() == '') {
      $('#alert_pic_telp').css('display', 'block');
    } else {
      $('#alert_pic_telp').css('display', 'none');
    }

    if ($('#transaksi_detail_ext_pengirim').val() == '') {
      $('#alert_ext_pengirim').css('display', 'block');
    } else {
      $('#alert_ext_pengirim').css('display', 'none');
    }

    if ((($('#transaksi_judul').val() != '') && ($('#transaksi_klasifikasi_id').val() != null) && ($('#transaksi_detail_pic_telepon').val() != '') && ($('transaksi_detail_ext_pengirim').val() != ''))) {
      $('#modal_agreement').modal('show');
    }

    if ((($('#transaksi_judul').val() == '') || ($('#transaksi_klasifikasi_id').val() == null) || ($('#transaksi_detail_pic_telepon').val() == '') || ($('transaksi_detail_ext_pengirim').val() == ''))) {
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    }
  })
  /*Ajukan*/

  /* Insert Ajukan */
  $('#insert_ajukan').on('click', function(e) {
    e.preventDefault();
    var set_data = new FormData($('#form_request')[0]);
    set_data.append('transaksi_agreement_keterangan', $('#transaksi_agreement_keterangan').val());

    var url = ($('#is_new').val() == '') ? '<?= base_url('sample/request/insertAjukan') ?>' : '<?= base_url('sample/request/updateAjukan') ?>';

    if ($('#transaksi_agreement_keterangan').val() == '') {
      toastr.warning('Note Harap Diisi');
    } else {
      $.ajax({
        type: "POST",
        url: url,
        data: set_data,
        dataType: "HTML",
        contentType: false,
        processData: false,
        cache: false,
        beforeSend: function() {
          $('#loading_form').show();
          $('#close').hide();
          $('#insert_ajukan').hide();
        },
        success: function(response) {
          if (response == '0') {
            toastr.warning('Format File Tidak Didukung');
            $('#loading_form').hide();
            $('#close').show();
            $('#insert_ajukan').show();
          } else {
            location.href = '<?= base_url('sample/request/previewRequest?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) . '&non_rutin=' ?>' + $('#transaksi_non_rutin_id').val()
          }
        }
      });
    }
  })
  /* Insert Ajukan */

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