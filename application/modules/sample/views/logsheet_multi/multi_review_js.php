<script>
  /* SELECT2 */
  $(function() {
    $('.select2').select2({
      placeholder: 'Pilih',
    });

    $('#id_template_footer').select2({
      dropdownParent: $("#modal_template"),
      theme: 'classic',
      ajax: {
        delay: 250,
        url: '<?= base_url('master/footer_sertifikat/getFooterSertifikatList') ?>',
        dataType: 'json',
        type: 'GET',
        data: function(params) {
          var queryParameters = {
            params_search: params.term
          }
          return queryParameters;
        }
      }
    });

    $('#logsheet_keterangan').select2({
      dropdownParent: $("#modal_template"),
      theme: 'classic',
      ajax: {
        delay: 250,
        url: '<?= base_url('master/keterangan_sertifikat/getKeteranganSertifikatList') ?>',
        dataType: 'json',
        type: 'GET',
        data: function(params) {
          var queryParameters = {
            params_search: params.term
          }
          return queryParameters;
        }
      }
    });

    $("#reviewerId").select2({
      theme: 'classic',
      ajax: {
        delay: 250,
        url: '<?= base_url('api/user/getUserCCList') ?>',
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

    $("#tujuanId").select2({
      theme: 'classic',
      ajax: {
        delay: 250,
        url: '<?= base_url('api/user/getUserCCList') ?>',
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

    $("#cc").select2({
      theme: 'classic',
      ajax: {
        delay: 250,
        url: '<?= base_url('api/user/getUserCCList') ?>',
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
    /* SELECT2 */
  })

  $('#simpan').on('click', function() {

    Swal.fire({
      title: "Apakah Anda Yakin?",
      text: "Apakah Anda Yakin Review Konsep Ini ?",
      icon: "danger",
      showCancelButton: true,
      confirmButtonColor: "#34c38f",
      cancelButtonColor: "#f46a6a",
      confirmButtonText: "Yakin"
    }).then(function(result) {
      if (result.value) {

        var data = new FormData($('#form_logsheet')[0]);
        url = '<?= base_url('sample/multi_sample/insertReviewLogSheet') ?>';
        $.ajax({
          type: "POST",
          url: url,
          data: data,
          dataType: 'HTML',
          processData: false,
          contentType: false,
          cache: false,
          success: function(response) {
            location.href = '<?= base_url('sample/multi_sample/?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) ?>';
          }
        });

      }
    });

  })

  /* Setuju Raw Data */
  $('#setuju_raw').on('click', function() {
    $("#modal_template").modal('show');
    $.getJSON('<?php echo base_url('sample/multi_sample/getLogSheetGroup') ?>', {
      logsheet_multiple_id: $('#transaksi_detail_group').val()
    }, function(result, status) {
      var pecah_id_template_footer = result.id_template_footer.split(',');
      var pecah_logsheet_keterangan = result.logsheet_keterangan.split(',');
      if (result.is_kan == 'y') $('#is_kan').prop('checked', true);
      else $('#is_kan').prop('checked', false);
      if (result.is_ds == 'y') $('#is_ds').prop('checked', true);
      else $('#is_ds').prop('checked', false);
      $.each(pecah_id_template_footer, function(index, val) {
        $.getJSON('<?= base_url('master/footer_sertifikat/getFooterSertifikat') ?>', {
          footer_id: val
        }, function(result_footer, status_footer) {
          $('#id_template_footer').append('<option selected value="' + result_footer.footer_id + '">' + result_footer.footer_isi + '</option>');
        });
      })
      $.each(pecah_logsheet_keterangan, function(index, val) {
        $.getJSON('<?= base_url('master/keterangan_sertifikat/getKeteranganSertifikat') ?>', {
          keterangan_sertifikat_id: val
        }, function(result_keterangan_sertifikat, status_keterangan_sertifikat) {
          $('#logsheet_keterangan').append('<option selected value="' + result_keterangan_sertifikat.keterangan_sertifikat_id + '">' + result_keterangan_sertifikat.keterangan_sertifikat_isi + '</option>');
        });
      })
    });
  });

  /* Reupload */
  // $('#reupload').on('click', function() {
  function func_reupload() {
    Swal.fire({
      title: "Upload Ulang?",
      text: "Apakah Anda Yakin Akan Mereset Data Logsheet dan Mengupload Ulang Excel",
      type: "question",
      showCancelButton: true,
      confirmButtonColor: "#34c38f",
      cancelButtonColor: "#f46a6a",
      confirmButtonText: "Iya",
      cancelButtonText: "Tidak",
    }).then(function(result) {
      if (result.value) {
        var data = new FormData();
        data.append('transaksi_id', $('#transaksi_id').val());
        data.append('transaksi_non_rutin_id', $('#transaksi_non_rutin_id').val());
        data.append('transaksi_tipe', $('#transaksi_tipe').val());
        data.append('logsheet_multiple_id', $('#transaksi_detail_group').val());
        data.append('transaksi_reset_logsheet_alasan', 'Upload Ulang Excel');
        var url = '<?= base_url() ?>sample/multi_sample/insertReset';
        // console.log(data)
        $.ajax({
          type: "POST",
          url: url,
          data: data,
          dataType: "HTML",
          contentType: false,
          processData: false,
          // cache: false,
          success: function(response) {
            location.href = '<?= base_url('sample/multi_sample/?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) ?>'
          }
        });
      }
    });
  }
  // })
  /* Reupload */

  $('#setuju').on('click', function() {
    Swal.fire({
      title: "Apakah Anda Yakin?",
      text: "Apakah Anda Yakin Review Konsep Ini ?",
      icon: "danger",
      showCancelButton: true,
      confirmButtonColor: "#34c38f",
      cancelButtonColor: "#f46a6a",
      confirmButtonText: "Yakin"
    }).then(function(result) {
      if (result.value) {
        var data = new FormData($('#form_logsheet')[0]);
        var is_kan = ($('#is_kan').is(":checked") == true) ? 'y' : 'n';
        data.append('is_kan', is_kan);
        var is_ds = ($('#is_ds').is(":checked") == true) ? 'y' : 'n';
        data.append('is_ds', is_ds);
        data.append('id_template_footer', $('#id_template_footer').val());
        data.append('logsheet_keterangan', $('#logsheet_keterangan').val());
        url = '<?= base_url('sample/multi_sample/insertApproveKonsepLogSheet') ?>';
        $.ajax({
          type: "POST",
          url: url,
          data: data,
          dataType: 'HTML',
          processData: false,
          contentType: false,
          cache: false,
          beforeSend: function() {
            $('#setuju').hide();
            // $('#loading_send_dof').show();
          },
          success: function(response) {
            location.href = response;
          }
        });
      }
    });
  })

  $('#approve_kasie').on('click', function() {
    Swal.fire({
      title: "Apakah Anda Yakin?",
      text: "Apakah Anda Yakin Untuk Approve ?",
      icon: "danger",
      showCancelButton: true,
      confirmButtonColor: "#34c38f",
      cancelButtonColor: "#f46a6a",
      confirmButtonText: "Yakin"
    }).then(function(result) {
      if (result.value) {

        var data = new FormData($('#form_logsheet')[0]);
        url = '<?= base_url('sample/multi_sample/insertApproveSertifikat') ?>';
        $.ajax({
          type: "POST",
          url: url,
          data: data,
          dataType: 'HTML',
          processData: false,
          contentType: false,
          cache: false,
          success: function(response) {
            location.reload();
          }
        });

      }
    });
  })

  $('#send_dof').on('click', function() {

    Swal.fire({
      title: "Apakah Anda Yakin?",
      text: "Apakah Anda Yakin Untuk Send DOF ?",
      icon: "danger",
      showCancelButton: true,
      confirmButtonColor: "#34c38f",
      cancelButtonColor: "#f46a6a",
      confirmButtonText: "Yakin"
    }).then(function(result) {
      if (result.value) {

        var data = new FormData($('#form_logsheet')[0]);
        url = '<?= base_url('sample/multi_sample/insertDOF') ?>';
        $.ajax({
          type: "POST",
          url: url,
          data: data,
          dataType: 'HTML',
          processData: false,
          contentType: false,
          cache: false,
          success: function(response) {
            location.href = '<?= base_url('sample/multi_sample/?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) ?>';
          }
        });

      }
    });
  })

  /* Kirim DOF */
  $('#send_dof_modal').on('click', function(e) {
    $('#modal_send_dof').modal('show');
    // $('#modal_send_dof').css('overflow-y', 'auto');

    var id = $('#transaksi_id').val();
    var id_detail = $('#transaksi_detail_group').val();
    $.getJSON('<?= base_url() ?>sample/request/getRequestDOF', {
      transaksi_id: id,
      transaksi_detail_group: id_detail
    }, function(json, textStatus) {
      $.each(json, function(index, val) {
        $('#' + index).val(val);
      });

      $('#classId').val(json.klasifikasi_id);
      $('#className').val(json.klasifikasi_kode + ' - ' + json.klasifikasi_nama);
      $('#title').val(json.transaksi_judul);
      $('#drafterId').val(json.id_dof_drafter)
      $('#drafterName').val(json.nama_drafter)
      $('#approverId').val(json.id_dof_approver)
      $('#approverName').val(json.nama_approver)

      var newOptionReviewer = new Option(json.nama_reviewer, json.id_dof_reviewer, true, true);
      $('#reviewerId').append(newOptionReviewer).trigger('change');

      var newOptionTujuan = new Option(json.nama_tujuan, json.id_dof_tujuan, true, true);
      $('#tujuanId').append(newOptionTujuan).trigger('change');
    });

    $.getJSON('<?= base_url('api_doc/dokumen_tipe/getDokumenTipeList') ?>', {
      code: 'SF'
    }, function(json) {
      $('#typeId').val(json.results[0].id);
      $('#typeName').val(json.results[0].text);
      $('#templateId').empty();

      $.getJSON('<?= base_url('api_doc/dokumen_template/getDokumenTemplateData') ?>', {
        typeId: json.results[0].id
      }, function(val) {
        $.each(val, function(index_1, val_1) {
          $('#templateId').append('<option value="' + val_1.document_template_id + '">' + val_1.document_template_name + '</option>');
        });
      });
    });
  });

  $('#send_dof_new').on('click', function() {
    Swal.fire({
      title: "Apakah Anda Yakin ?",
      text: "Apakah Anda Yakin Untuk Send DOF ?",
      icon: "danger",
      showCancelButton: true,
      confirmButtonColor: "#34c38f",
      cancelButtonColor: "#f46a6a",
      confirmButtonText: "Yakin"
    }).then(function(result) {
      if (result.value) {
        var data = new FormData($('#form_send_dof')[0]);
        data.append('transaksi_id', $('#transaksi_id').val());
        data.append('transaksi_detail_group', $('#transaksi_detail_group').val());
        data.append('template_logsheet_id', $('#template_logsheet_id').val());
        data.append('custom_area', $('#custom_area').val());
        data.append('logsheet_id[]', $("[name='logsheet_id[]']").val());

        url = '<?= base_url('sample/multi_sample/insertDOF') ?>';
        $.ajax({
          type: "POST",
          url: url,
          data: data,
          dataType: 'HTML',
          processData: false,
          contentType: false,
          cache: false,
          beforeSend: function() {
            $('#send_dof_new').hide();
            $('#close_send_dof').hide();
            $('#loading_send_dof').show();
          },
          success: function(response) {
            location.href = '<?= base_url('sample/multi_sample/?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) ?>';
          }
        });
      }
    });
  })
  /* Kirim DOF */



  /* ganti template */
  function func_ganti_tujuan(id) {
    $('#tujuanId').empty();
    if (id != '5f68d218-11ca-430e-b071-09d4d096628b') {
      $("#tujuanId").select2({
        theme: 'classic',
        ajax: {
          delay: 250,
          url: '<?= base_url('api_doc/user_company/getuserCompanyList') ?>',
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
    } else {
      $("#tujuanId").select2({
        theme: 'classic',
        ajax: {
          delay: 250,
          url: '<?= base_url('api/user/getUserCCList') ?>',
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
    }
    $('.select2-selection').css('height', '37px');
    $('.select2').css('width', '100%');
  }
  /* ganti template */

  $('#cetak_konsep').on('click', function() {
    $('.no-print').hide();
    window.print();
    window.onfocus = $('.no-print').show()
  })

  $('#draft').on('click', function() {
    location.href = '<?= base_url('sample/multi_sample/?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) ?>';
  })


  tinymce.init({
    selector: "textarea.custom_area",
    script_url: '<?= base_url() ?>assets_tambahan/tinymce/tinymce.min.js', // replace with your own path
    // height: 300,
    plugins: [
      "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
      "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
      "save table  directionality emoticons template paste ",
      "bootstrap",
      "autoresize",

    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",
    // contextmenu: "link image imagetools table spellchecker | bootstrap",
    file_picker_types: 'file image media',

  });

  tinymce.init({
    selector: "textarea.custom_raw_eksekutor",
    // height: 300,
    plugins: [
      "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
      "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
      "save table  directionality emoticons template paste ",
      "autoresize",
      "bootstrap",
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",
  });


  $('#cetak').on('click', function() {

    // window.print();

    childWindow = window.open('', 'childWindow', 'location=yes, menubar=yes, toolbar=yes');
    childWindow.document.open();
    childWindow.document.write('<html><head></head><body>');
    childWindow.document.write(document.getElementById('custom_area').value.replace(/\n/gi, ''));
    childWindow.document.write('</body></html>');
    // childWindow.print();
    // childWindow.document.close();
    // childWindow.close();
  })

  /* Close Model Template */
  $('#modal_template').on('hidden.bs.modal', function(e) {
    $('#form_template')[0].reset();
    $('#id_template_footer').empty();
    $('#logsheet_keterangan').empty();
  });
  /* Close Model Template */

  /* Close Modal Kirim DOF */
  function func_close_send_dof() {
    $('#typeId').empty();
    $('#templateId').empty();
    $('#cc').empty();
    $('#form_send_dof')[0].reset();
    $('#reviewerId').empty();
    $('#tujuanId').empty();
  }

  $('#modal_send_dof').on('hidden.bs.modal', function(e) {
    func_close_send_dof();
  });
  /* Close Modal Kirim DOF */

  setTimeout(function() {
    fun_refresh_dokumen('<?= $this->input->get('transaksi_detail_group') ?>.docx')
  }, 2000);

  function fun_refresh_dokumen(dokumen) {
    var html = '<iframe src="https://docs.google.com/gview?url=103.157.97.200/dokumen_dof/' + dokumen + '&embedded=true" width="100%" height="600"></iframe>';
    $('#dokumen_dof').html(html);
  }
</script>