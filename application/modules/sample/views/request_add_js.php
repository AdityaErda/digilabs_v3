<script type="text/javascript">
  var urut = 1;

  $(function() {
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

    // Jenis Sample
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
    $('#jenis_id').on('select2:select', function(e) {
      var data = e.params.data;
      $('#transaksi_detail_parameter').val(data.parameter);
      $('#item_judul').val(data.text);
      $('#transaksi_detail_identitas').val('');
    });

    // Jenis Pekerjaan
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

    $('.select2-selection').css('height', '37px');
    $('.select2').css('width', '100%');
    /* SELECT2 */

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

    /* Proses On Load */

    // Drafter
    var newOptionDrafter = new Option('<?= $this->session->userdata('user_nik_sap') . ' - ' . $this->session->userdata('user_nama') . ' - ' . $this->session->userdata('user_post_title') ?>', '<?= $this->session->userdata('user_nik_sap'); ?>', true, true);
    $('#transaksi_drafter').append(newOptionDrafter).trigger('change');

    if ($('#pegawai_jabatan').val() == '2') {
      $('#div_reviewer').css('display', 'none');
      $('#div_approver').css('display', 'none');
    } else if ($('#pegawai_jabatan').val() == '3') {
      var newOptionReviewer = new Option('<?= $vp_nik_sap . ' - ' . $vp_nama . ' - ' . $avp_post_title ?>', '<?= $vp_nik_sap; ?>', true, true);
      $('#transaksi_reviewer').append(newOptionReviewer).trigger('change');
      var newOptionApprover = new Option('<?= $vp_nik_sap . ' - ' . $vp_nama . ' - ' . $vp_post_title ?>', '<?= $vp_nik_sap; ?>', true, true);
      $('#transaksi_approver').append(newOptionApprover).trigger('change');
    } else {
      if ($('#jabatan_atasan').val() == '2') {
        var newOptionReviewer = new Option('<?= $avp_nik_sap . ' - ' . $avp_nama . ' - ' . $avp_post_title ?>', '<?= $avp_nik_sap; ?>', true, true);
        $('#transaksi_reviewer').append(newOptionReviewer).trigger('change');
        var newOptionApprover = new Option('<?= $avp_nik_sap . ' - ' . $avp_nama . ' - ' . $vp_post_title ?>', '<?= $avp_nik_sap; ?>', true, true);
        $('#transaksi_approver').append(newOptionApprover).trigger('change');
      } else {
        var newOptionReviewer = new Option('<?= $avp_nik_sap . ' - ' . $avp_nama . ' - ' . $avp_post_title ?>', '<?= $avp_nik_sap; ?>', true, true);
        $('#transaksi_reviewer').append(newOptionReviewer).trigger('change');
        $.getJSON('<?= base_url() ?>api/user/getUserList2', {
          param1: $('#direct_superior_atasan').val()
        }, function(json) {
          var newOption = new Option(json.text, json.id, true, true);
          $('#transaksi_approver').append(newOption).trigger('change');
        });
      }
    }

    // Tujuan
    $.getJSON('<?= base_url() ?>api/user/getUserList2', {
      user_nik_sap: '2105099'
    }, function(jsonAPV) {
      var newOptionTujuan = new Option(jsonAPV.text, jsonAPV.id, true, true);
      $('#transaksi_tujuan').append(newOptionTujuan).trigger('change');
    });

    // Peminta Jasa
    var newOptionPemintaJasa = new Option('<?= $this->session->userdata('user_departemen') ?>', '<?= $this->session->userdata('user_unit_id'); ?>', true, true);
    $('#peminta_jasa_id').append(newOptionPemintaJasa).trigger('change');

    // PIC
    var newOptionPIC = new Option('<?= $this->session->userdata('user_nik_sap') . ' - ' . $this->session->userdata('user_nama') . ' - ' . $this->session->userdata('user_post_title') ?>', '<?= $this->session->userdata('user_nik_sap'); ?>', true, true);
    $('#transaksi_detail_pic_pengirim').append(newOptionPIC).trigger('change');

    // Tujuan Default
    // var newOptionTujuan = new Option('2105099',)
    /* Proses On Load */
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
    html += '<label class="col-md-4">Jumlah Sample</label>';
    html += '<div class="col-8">';
    html += '<input type="text" id="transaksi_detail_jumlah_' + urut + '" name="transaksi_detail_jumlah[]" value="1" class="form-control" onkeypress="return numberOnly(event)">';
    html += '</div>';
    html += '</div>';
    html += '<div class="form-group row col-12">';
    html += '<label class="col-md-4">Identitas Sample</label>';
    html += '<div class="col-8">';
    html += '<input type="text" id="transaksi_detail_identitas_' + urut + '" name="transaksi_detail_identitas[]" placeholder="Identitas Sample" class="form-control">';
    html += '<input type="text" id="identitas_id_' + urut + '" name="identitas_id[]" style="display: none">';
    html += '<ul class="list-group" id="transaksi_detail_identitas_hasil_' + urut + '"></ul>';
    html += '</div>';
    html += '</div>';
    html += '<div class="form-group row col-12">';
    html += '<label class="col-md-4">Jumlah Parameter</label>';
    html += '<div class="col-8">';
    html += '<input type="text" id="transaksi_detail_parameter_' + urut + '" name="transaksi_detail_parameter[]" placeholder="Parameter Sample" class="form-control" onkeypress="return numberOnly(event)">';
    html += '</div>';
    html += '</div>';
    html += '<div class="form-group row col-12">';
    html += '<label class="col-md-4">Deskripsi Parameter Uji / Kalibrasi</label>';
    html += '<div class="col-8">';
    html += '<textarea name="transaksi_detail_deskripsi_parameter[]" id="transaksi_detail_deskripsi_parameter_' + urut + '" cols="3" rows="3" class="form-control" placeholder="Analisa Cu, Pb, Uji Aplikasi, Analisa Kimia / Kalibrasi Suhu Range 10 Derajat C, 20 Derajat C"></textarea>';
    html += '</div>';
    html += '</div>';
    html += '<div class="form-group row col-12">';
    html += '<label class="col-md-4">Catatan Pengajuan</label>';
    html += '<div class="col-8">';
    html += '<textarea name="transaksi_detail_catatan[]" id="transaksi_detail_catatan_' + urut + '" cols="3" rows="3" class="form-control" placeholder="Untuk kebutuhan Extra Cek Pabrik NPK 5"></textarea>';
    html += '</div>';
    html += '</div>';
    html += '</div>';
    html += '<div class="col-6">';
    html += '<div class="form-group row col-12">';
    html += '<label class="col-md-4">Attachment</label>';
    html += '<div class="col-8">';
    html += '<input type="file" name="transaksi_detail_attachment[]" id="transaksi_detail_attachment_' + urut + '" class="form-control" accept="application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-powerpoint, application/vnd.openxmlformats-officedocument.presentationml.presentation, text/plain, application/pdf, image/jpeg,image/png,image/gif,image/bmp" required>';
    html += '</div>';
    html += '</div>';
    html += '<div class="form-group row col-12">';
    html += '<label class="col-md-4">Foto Sample</label>';
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

    $('.select2-selection').css('height', '37px');
    $('.select2').css('width', '100%');

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

  });
  /* Tambah Item */

  /* Hapus Item */
  $(document).on('click', '.remove_item', function() {
    $(this).closest('.div_item_baru').remove();
  })
  /* Hapus Item */



  /* Draft */
  $('#draft').on('click', function(e) {
    e.preventDefault();

    var set_data = new FormData($('#form_request')[0]);
    var url = ($('#is_new').val() == '') ? '<?= base_url('sample/request/insertDraft') ?>' : '<?= base_url('sample/request/updateDraft') ?>';

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
        $('#ajukan').hide();
        $('#draft').hide();
        $('#edit').hide();
        $('#kembali').hide();
      },
      success: function(response) {
        if (response == '0') {
          toastr.warning('Format File Tidak Didukung');
          $('#loading_form').hide();
          $('#close').show();
          $('#draft').show();
          $('#kembali').show();
          if ($('#is_new').val() == '') {
            $('#ajukan').show();
          } else {
            $('#edit').show();
          }
        } else {
          location.href = '<?= base_url('sample/request/?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) ?>'
        }
      }
    });
  })
  /* Draft */

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

    var url = ($('#is_new').val() == '') ? '<?= base_url('sample/Request/insertAjukan') ?>' : '<?= base_url('sample/request/updateAjukan') ?>';

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
        // cache: false,
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

  /* Loading */
  function fun_loading() {
    var simplebar = new Nanobar();
    simplebar.go(100);
  }
  /* Loading */
</script>