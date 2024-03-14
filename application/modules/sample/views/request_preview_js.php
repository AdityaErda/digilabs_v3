<script>
  $(function() {

    $(document).ready(function() {
      var id = '<?= $_GET['non_rutin'] ?>';
      // data utama
      $.getJSON("<?= base_url('sample/request/getRequest') ?>", {
          transaksi_non_rutin_id: id,
        },
        function(data, textStatus, jqXHR) {
          console.log(data);
          if (data.transaksi_status == '3') {
            $('#disposisi_avp').show();
            $('#disposisi_seksi').hide()
          } else if (data.transaksi_status == '4') {
            $('#disposisi_avp').hide();
            $('#disposisi_seksi').show()
          }

          $('#transaksi_non_rutin_id').val(data.transaksi_non_rutin_id);
          $('#transaksi_judul').val(data.transaksi_judul);

          $('#transaksi_kecepatan_tanggap').val(data.transaksi_kecepatan_tanggap).trigger('change');
          $('#transaksi_sifat').val(data.transaksi_sifat).trigger('change');

          $('#transaksi_klasifikasi_id').append('<option selected value="' + data.klasifikasi_id + '">' + data.klasifikasi_nama + ' - ' + data.klasifikasi_kode + '</option>');
          $('#klasifikasi_id').select2('data', {
            id: data.klasifikasi_id,
            text: data.klasifikasi_kode
          });

          $('#transaksi_reviewer').append('<option selected value="' + data.nik_reviewer + '">' + data.nik_reviewer + ' - ' + data.nama_reviewer + ' - ' + data.title_reviewer + '</option>');
          $('#transaksi_reviewer').select2('data', {
            id: data.nik_reviewer,
            text: data.nik_reviewer + '">' + data.nik_reviewer + ' - ' + data.nama_reviewer + ' - ' + data.title_reviewer,
          });
          $('#transaksi_reviewer').trigger('change');

          $('#transaksi_approver').append('<option selected value="' + data.nik_approver + '">' + data.nik_approver + ' - ' + data.nama_approver + ' - ' + data.title_approver + '</option>');
          $('#transaksi_approver').select2('data', {
            id: data.nik_approver,
            text: data.nik_approver + '">' + data.nik_approver + ' - ' + data.nama_approver + ' - ' + data.title_approver,
          });
          $('#transaksi_approver').trigger('change');

          $('#transaksi_tujuan').append('<option selected value="' + data.nik_tujuan + '">' + data.nik_tujuan + ' - ' + data.nama_tujuan + ' - ' + data.title_tujuan + '</option>');
          $('#transaksi_tujuan').select2('data', {
            id: data.nik_tujuan,
            text: data.nik_tujuan + '">' + data.nik_tujuan + ' - ' + data.nama_tujuan + ' - ' + data.title_tujuan,
          });
          $('#transaksi_tujuan').trigger('change');

          $('#transaksi_drafter').append('<option selected value="' + data.nik_drafter + '">' + data.nik_drafter + ' - ' + data.nama_drafter + ' - ' + data.title_drafter + '</option>');
          $('#transaksi_drafter').select2('data', {
            id: data.nik_drafter,
            text: data.nik_drafter + '">' + data.nik_drafter + ' - ' + data.nama_drafter + ' - ' + data.title_drafter,
          });
          $('#transaksi_drafter').trigger('change');

          $('#peminta_jasa_id').append('<option selected value="' + data.peminta_jasa_id + '">' + data.peminta_jasa_nama + '</option>');
          $('#peminta_jasa_id').select2('data', {
            id: data.peminta_jasa_id,
            text: data.peminta_jasa_nama + '">',
          });
          $('#peminta_jasa_id').trigger('change');

          $('#transaksi_drafter').append('<option selected value="' + data.nik_drafter + '">' + data.nik_drafter + ' - ' + data.nama_drafter + ' - ' + data.title_drafter + '</option>');
          $('#transaksi_drafter').select2('data', {
            id: data.nik_drafter,
            text: data.nik_drafter + '">' + data.nik_drafter + ' - ' + data.nama_drafter + ' - ' + data.title_drafter,
          });
          $('#transaksi_drafter').trigger('change');


          $('#transaksi_detail_pic_pengirim').append('<option selected value="' + data.nik_pic_pengirim + '">' + data.nik_pic_pengirim + ' - ' + data.nama_pic_pengirim + ' - ' + data.title_pic_pengirim + '</option>');
          $('#transaksi_detail_pic_pengirim').select2('data', {
            id: data.nik_pic_pengirim,
            text: data.nik_pic_pengirim + '">' + data.nik_pic_pengirim + ' - ' + data.nama_pic_pengirim + ' - ' + data.title_pic_pengirim,
          });
          $('#transaksi_detail_pic_pengirim').trigger('change');

          $('#transaksi_detail_pic_telepon').val(data.transaksi_pic_telepon);
          $('#transaksi_detail_ext_pengirim').val(data.transaksi_pic_ext);
        })

    });

    let rand = $('#table_disposisi').length + 1;

    $('#table_disposisi').DataTable({
      drawCallback: function() {
        $(".transaksi_disposisi_avp").select2({
          placeholder: "Pilih",
          ajax: {
            delay: 250,
            url: "<?= base_url('api/user/getUserLabList') ?>",
            dataType: "json",
            type: "GET",
            data: function(params) {
              var queryParameters = {
                param_search: params.term
              }
              return queryParameters;
            }
          }
        })
        $('.select2-modal-selection').css('height', '37px');
        $('.select2-modal').css('width', '100%');
      },
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
            return (row.transaksi_detail_foto) ? '<center><a href="#" id="' + row.transaksi_detail_foto + '" data-toggle="modal" data-target="#modal_lihat" onclick="fun_lihat(this.id)"><i class="fa fa-image"></i></a></center>' : '-';
          }
        },
        // dipoisisi
        {
          "render": function(data, type, row, meta) {
            console.log(row);
            return '<input type="text" id="transaksi_disposisi_avp_id_transaksi' + meta.row + '" name="transaksi_disposisi_avp_id_transaksi[]" value="' + row.transaksi_id + '">\
            <input type="text" id="transaksi_disposisi_avp_id_transaksi_detail' + meta.row + '" name="transaksi_disposisi_avp_id_transaksi_detail[]" value="' + row.transaksi_detail_id + '">\
            <select class="transaksi_disposisi_avp form-control select2-modal" id="transaksi_disposisi_avp' + meta.row + '" name="transaksi_disposisi_avp[]" width="100%">\
             </select>'
          }
        },
        // disposisi
      ]
    })


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
        })
        $('.select2-modal-selection').css('height', '37px');
        $('.select2-modal').css('width', '100%');
      },
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
            return (row.transaksi_detail_foto) ? '<center><a href="#" id="' + row.transaksi_detail_foto + '" data-toggle="modal" data-target="#modal_lihat" onclick="fun_lihat(this.id)"><i class="fa fa-image"></i></a></center>' : '-';
          }
        },
        // dipoisisi
        {
          "render": function(data, type, row, meta) {
            console.log(row);
            return '<input type="text" id="transaksi_disposisi_seksi_id_transaksi' + meta.row + '" name="transaksi_disposisi_seksi_id_transaksi[]" value="' + row.transaksi_id + '">\
            <input type="text" id="transaksi_disposisi_seksi_id_transaksi_detail' + meta.row + '" name="transaksi_disposisi_seksi_id_transaksi_detail[]" value="' + row.transaksi_detail_id + '">\
            <select class="transaksi_disposisi_seksi form-control select2-modal" id="transaksi_disposisi_seksi' + meta.row + '" name="transaksi_disposisi_seksi[]" width="100%">\
             </select>'
          }
        },
        // disposisi
      ]
    })

    /* Select2 */
    // Ajukan
    $('#transaksi_jenis_surat').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url('master/template_keterangan/getJenisTemplateList') ?>',
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

    /* Peminta Jasa */
    $('#peminta_jasa_id').on('select2:select', function(e) {
      var data = e.params.data;

      fun_pic(data.id);
    });
    /* Peminta Jasa */

    $('#transaksi_detail_pic_pengirim').select2({
      placeholder: 'Pilih Peminta Jasa Terlebih Dahulu'
    })
    /* Jenis */

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

    /* Jenis Diklik */
    $('#jenis_id').on('select2:select', function(e) {
      var data = e.params.data;

      fun_parameter(data.parameter);
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

    /* Template Keterangan */
    $('#template_keterangan_id').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url('master/template_keterangan/getTemplateKeteranganList') ?>',
        dataType: 'json',
        type: 'GET',
        data: function(params) {
          var queryParameters = {
            keterangan_nama: params.term
          }

          return queryParameters;
        }
      }
    });
    /* Template Keterangan */

    /* Template Keterangan diklik */
    $('#template_keterangan_id').on('select2:select', function(e) {
      var data = e.params.data;

      renderTemplate(data.id, data.jenis);
    });
    /* Template Keterangan diklik */

    // Sifat
    $('#transaksi_sifat').select2({
      placeholder: 'Pilih',
    })
    // Sifat

    // Kecepatan Tanggap
    $('#transaksi_kecepatan_tanggap').select2({
      placeholder: 'Pilih',

    })
    // Kecepatan Tanggap

    // reviewer
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
    })
    // reviewer

    // Approver
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
    })
    // Approver

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
    })

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
    })

    $('.transaksi_disposisi_avp').select2({
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
    })

    $('.select2-selection').css('height', '37px');
    $('.select2').css('width', '100%');
    $('.select2-modal-selection').css('height', '37px');
    $('.select2-modal').css('width', '100%');
    $(".select2").prop("disabled", true);
    $("input[type='text']").attr('readonly', true);
    $("input[type='number']").attr("readonly", true);
    $("textarea").attr('readonly', true);

    // Aksi Tombol
    $('#simpan_disposisi_avp').on('click', function(e) {
      e.preventDefault();
      var data = new FormData($('#form_disposisi_avp')[0]);
      data.append('transaksi_status', $('#transaksi_status').val());
      console.log(data);
      $.ajax({
        type: "POST",
        url: "<?= base_url() ?>sample/lab/insertDisposisiAVP",
        data: data,
        dataType: "HTML",
        processData: false,
        contentType: false,
        cache: false,
        success: function(response) {
          location.href = '<?= base_url('sample/lab/?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) ?>'
        }
      });
    })

    $('#simpan_disposisi_seksi').on('click', function(e) {
      e.preventDefault();
      var data = new FormData($('#form_disposisi_seksi')[0]);
      data.append('transaksi_status', $('#transaksi_status').val());
      console.log(data);
      $.ajax({
        type: "POST",
        url: "<?= base_url() ?>sample/lab/insertDisposisiSeksi",
        data: data,
        dataType: "HTML",
        processData: false,
        contentType: false,
        cache: false,
        success: function(response) {
          location.href = '<?= base_url('sample/lab/?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) ?>'
        }
      });
    })
    // Aksi Tombol



    // if ('<?= $this->session->userdata('user_nik_sap') != null ?>') {

    //   var nik = '<?= $this->session->userdata('user_nik_sap') ?>';
    //   $('#transaksi_drafter').append('<option selected value="<?= $this->session->userdata('user_nik_sap') ?>"> <?= $this->session->userdata('user_nik_sap') . ' - ' . $this->session->userdata('user_nama') . ' - ' . $this->session->userdata('user_post_title'); ?> </option>');
    //   $('#peminta_jasa_id').append('<option selected value="<?= $this->session->userdata('user_unit_id') ?>"> <?= $this->session->userdata('user_departemen'); ?> </option>');
    //   $('#transaksi_detail_pic_pengirim').append('<option selected value="<?= $this->session->userdata('user_nik_sap') ?>"> <?= $this->session->userdata('user_nik_sap') . ' - ' . $this->session->userdata('user_nama') . ' - ' . $this->session->userdata('user_post_title'); ?> </option>');
    //   $('#transaksi_detail_pic_pengirim').trigger('change');
    //   // $('#transaksi_reviewer').
    //   $.getJSON('<?= base_url() ?>api/user/getUserList3', {
    //     user_nik_sap: nik
    //   }, function(json) { // JSON CARI JABATAN PIC

    //     $('#transaksi_drafter_poscode').val(json.user_poscode);

    //     var user_job_id = json.user_job_id;
    //     var q = user_job_id.substring(0, 1);
    //     if (q == '2') {
    //       $('#div_reviewer').css('display', 'none');
    //       $('#div_approver').css('display', 'none');
    //       $('#transaksi_approver').val('');
    //       $('#transaksi_reviewer').val('');
    //     } else if (q == '3') {
    //       $('#div_reviewer').css('display', 'none');
    //       $('#div_approver').css('display', 'block');
    //       $('#transaksi_reviewer').val('');
    //       //Approver VP
    //       $.getJSON('<?= base_url() ?>api/user/getUserList2', {
    //         param1: json.user_direct_superior
    //       }, function(jsonq) {
    //         var newOption = new Option(jsonq.text, jsonq.id, true, true);
    //         $('#transaksi_approver').append(newOption).trigger('change');
    //       });
    //     } else {
    //       $('#div_reviewer').css('display', 'block');
    //       $('#div_approver').css('display', 'block');
    //       $.getJSON('<?= base_url() ?>api/user/getUserList3', {
    //         param1: json.user_direct_superior
    //       }, function(json3) {
    //         var user_job_id = json3.user_job_id;
    //         var q = user_job_id.substring(0, 1);
    //         if (q == '2') {
    //           // Review & Approver direct atasan
    //           $.getJSON('<?= base_url() ?>api/user/getUserList2', {
    //             param1: json.user_direct_superior
    //           }, function(jsonReviewer) {
    //             console.log(jsonReviewer);
    //             var newOption = new Option(jsonReviewer.text, jsonReviewer.id, true, true);
    //             $('#transaksi_reviewer').append(newOption).trigger('change');
    //             $('#transaksi_reviewer_poscode').val(jsonReviewer.user_poscode)
    //             var newOption = new Option(jsonReviewer.text, jsonReviewer.id, true, true);
    //             $('#transaksi_approver').append(newOption).trigger('change');
    //             $('#transaksi_approver_poscode').val(jsonReviewer.user_poscode)
    //           });
    //         } else {
    //           // Review direct atasan ; Approve VP
    //           $.getJSON('<?= base_url() ?>api/user/getUserList2', {
    //             param1: json.user_direct_superior
    //           }, function(jsonReviewer) {
    //             var newOption = new Option(jsonReviewer.text, jsonReviewer.id, true, true);
    //             $('#transaksi_reviewer').append(newOption).trigger('change');
    //             $('#transaksi_reviewer_poscode').val(jsonReviewer.user_poscode);
    //             $.getJSON('<?= base_url() ?>api/user/getUserList3', {
    //               user_nik_sap: jsonReviewer.id
    //             }, function(json2) {
    //               $.getJSON('<?= base_url() ?>api/user/getUserList2', {
    //                 param1: json2.user_direct_superior
    //               }, function(jsonApprover) {
    //                 var newOption = new Option(jsonApprover.text, jsonApprover.id, true, true);
    //                 $('#transaksi_approver').append(newOption).trigger('change');
    //                 $('#transaksi_approver_poscode').val(jsonApprover.user_poscode);
    //               });
    //             });
    //           });
    //         }
    //       });
    //     }
    //   });

    // }


    /* Select2 */
    // FORM
  })

  // PIC pengirim ID
  function gantiPICPengirim(id) {
    $('#transaksi_pic_pengirim_id').val(id);
    $.getJSON("<?= base_url() ?>api/user/getUserList3", {
        user_nik_sap: id
      },
      function(data, textStatus, jqXHR) {
        $('#transaksi_pic_pengirim_poscode').val(data.user_poscode);
      }
    );
  }
  // PIC pengirim ID

  /* Fun PIC */
  function fun_pic(id) {
    $('#transaksi_detail_pic_pengirim').empty();
    $('#transaksi_detail_pic_pengirim').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url('api/user/getUserList?user_unit_id=') ?>' + id,
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

    $('.select2-selection').css('height', '37px');
    $('.select2').css('width', '100%');
  }
  /* Fun PIC */

  function fun_parameter(parameter) {
    $('#transaksi_detail_parameter').val(parameter);
  }
  // render simpan item

  function reviewerDefault() {
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
    })
  }

  function gantiReviewer(id) {
    $.getJSON("<?= base_url() ?>api/user/getUserList3", {
        user_nik_sap: id
      },
      function(data, textStatus, jqXHR) {
        $('#transaksi_reviewer_poscode').val(data.user_poscode)
      }
    );
  }

  function gantiApprover(id) {
    $.getJSON("<?= base_url() ?>api/user/getUserList3", {
        user_nik_sap: id
      },
      function(data, textStatus, jqXHR) {
        $('#transaksi_approver_poscode').val(data.user_poscode)
      }
    );
  }

  function gantiDrafter(id) {
    $.getJSON("<?= base_url() ?>api/user/getUserList3", {
        user_nik_sap: id
      },
      function(data, textStatus, jqXHR) {
        $('#transaksi_drafter_poscode').val(data.user_poscode)
      }
    );
  }

  function gantiTujuan(id) {
    $.getJSON("<?= base_url() ?>api/user/getUserList3", {
        user_nik_sap: id
      },
      function(data, textStatus, jqXHR) {
        $('#transaksi_tujuan_poscode').val(data.user_poscode)
      }
    )
  };

  function disposisiAVP(id, status) {
    $('#table_disposisi').DataTable().ajax.url('<?= base_url('sample/request/getRequestDetail?transaksi_non_rutin_id=') ?>' + id + '&transaksi_status=' + status).load();
  }

  function disposisiSeksi(id, status) {
    $('#table_disposisi_seksi').DataTable().ajax.url('<?= base_url('sample/request/getRequestDetail?transaksi_non_rutin_id=') ?>' + id + '&transaksi_status=' + status).load();
  }

  function cetakPreview(id, status) {
    window.open('<?= base_url() ?>sample/request/cetakPreviewRequest?non_rutin=' + id + '&status=' + status, '_blank');
  }

  function cariDisposisiAVP(value) {}
  // EXTRA
  function fun_loading() {
    var simplebar = new Nanobar();
    simplebar.go(100);
  }

  function fun_lihat(isi) {
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        $('#document').remove();
        $('#div_document').append('<embed src="<?= base_url('document/') ?>' + isi + '#toolbar=0" frameborder="0" id="document" width="100%" style="height: -webkit-fill-available;"></embed>');
      }
    });
  }


  // EXTRA
</script>