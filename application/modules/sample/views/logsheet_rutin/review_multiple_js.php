<script type="text/javascript">
  $(function() {
    /* SELECT2 */
    $('.select2').select2({
      placeholder: 'Pilih',
    });

    // $('#typeId').select2({
    //   dropdownParent: $("#modal_send_dof"),
    //   placeholder: 'Pilih',
    //   ajax: {
    //     delay: 250,
    //     url: '<?= base_url('api_doc/dokumen_tipe/getDokumenTipeList?tipe=') ?>' + $('#transaksi_tipe').val() + '&code=SF',
    //     dataType: 'json',
    //     type: 'GET',
    //     data: function(params) {
    //       var queryParameters = {
    //         param_search: params.term
    //       }
    //       return queryParameters;
    //     }
    //   }
    // });

    $(".cc").select2({
      placeholder: "Pilih",
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


    $('#templateId').select2({
      placeholder: 'Pilih Tipe Dokumen Dahulu',
    });

    $('#classId').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url() ?>/master/klasifikasi_sample/getKlasifikasiSampleList',
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

    $('#drafterNik').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url() ?>/api/user/getUserList',
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

    $('#reviewerNik').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url() ?>/api/user/getUserAVPList',
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

    $('#approverNik').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url() ?>/api/user/getUserVPAVPList',
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

    $('#tujuanNik').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url() ?>/api/user/getUserLabList',
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

    setTimeout(function() {
      fun_refresh_dokumen('<?= $this->input->get('id_transaksi_rutin') ?>.docx')
    }, 2000);
  });

  function func_change_template(id) {
    $('#templateId').empty();
    $('#templateId').select2({
      placeholder: 'Pilih',
      ajax: {
        delay: 250,
        url: '<?= base_url('api_doc/dokumen_template/getDokumenTemplateList?typeId=') ?>' + id + '&tipe=' + $('#transaksi_tipe').val(),
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

  function ganti_drafter_identitas(id) {
    $.getJSON("<?= base_url() ?>api/user/getUserList3", {
        user_nik_sap: id
      },
      function(data) {
        $('#drafterId').val(data.user_detail_id);
      }
    );
  }

  function ganti_reviewer_identitas(id) {
    $.getJSON("<?= base_url() ?>api/user/getUserList3", {
        user_nik_sap: id
      },
      function(data) {
        $('#reviewerId').val(data.user_detail_id)
      }
    );
  }

  function ganti_approver_identitas(id) {
    $.getJSON("<?= base_url() ?>api/user/getUserList3", {
        user_nik_sap: id
      },
      function(data) {
        $('#approverId').val(data.user_detail_id)
      }
    );
  }

  function ganti_tujuan_identitas(id) {
    $.getJSON("<?= base_url() ?>api/user/getUserList3", {
        user_nik_sap: id
      },
      function(data) {
        $('#tujuanId').val(data.user_detail_id)
      }
    )
  };

  function cetak_draft() {
    $('.no-print').hide();
    window.print();
    window.onfocus = $('.no-print').show();
  }

  /* Approve Kasie */
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
        var data = new FormData($('#form_logsheet_multiple')[0]);
        url = '<?= base_url('sample/nomor/insertLogsheetMultipleApprove') ?>';
        $.ajax({
          type: "POST",
          url: url,
          data: data,
          dataType: 'HTML',
          processData: false,
          contentType: false,
          cache: false,
          success: function(response) {
            var url = '<?= base_url() . 'sample/nomor/reviewMultipleNomor?header_menu=' ?>' + $('#header_menu').val() + '&menu_id=' + $('#menu_id').val() + '&id_transaksi_rutin=' + $('#transaksi_rutin_id').val() + '&status=12';
            location.href = url;
          }
        });
      }
    });
  })
  /* Approve Kasie */

  /* Send DOF */
  $('#send_dof_modal').on('click', function(e) {
    $('#modal_send_dof').modal('show');

    var id = $('#transaksi_rutin_id').val();
    $.getJSON('<?= base_url() ?>sample/nomor/getNomorDOF', {
      transaksi_rutin_id: id
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

      // var newOptionTujuan = new Option(json.nama_tujuan, json.id_dof_tujuan, true, true);
      // $('#tujuanId').append(newOptionTujuan).trigger('change');
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

  $('#simpan_send_dof').on('click', function() {
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
        data.append('transaksi_rutin_id', $('#transaksi_rutin_id').val());
        data.append('custom_area', $('#custom-sertifikat').val());
        url = '<?= base_url('sample/nomor/insertDOF') ?>';
        $.ajax({
          type: "POST",
          url: url,
          data: data,
          dataType: 'HTML',
          processData: false,
          contentType: false,
          cache: false,
          beforeSend: function() {
            $('#simpan_send_dof').hide();
            $('#close_send_dof').hide();
            $('#loading_send_dof').show();
          },
          success: function(response) {
            location.href = '<?= base_url('sample/nomor/?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) ?>';
          }
        });
      }
    });
  });
  /* Send DOF */

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

  /* Close Modal Kirim DOF */
  function func_close_send_dof() {
    $('#form_send_dof')[0].reset();
    $('#typeId').empty();
    $('#classId').empty();
    $('#templateId').empty();
    $('#cc').empty();
    $('#drafterNik').empty();
    $('#reviewerNik').empty();
    $('#approverNik').empty();
    $('#tujuanNik').empty();
  }

  $('#modal_send_dof').on('hidden.bs.modal', function(e) {
    func_close_send_dof();
  });
  /* Close Modal Kirim DOF */

  /* Dokumen */
  function fun_refresh_dokumen(dokumen) {
    var html = '<iframe src="https://docs.google.com/gview?url=103.157.97.200/dokumen_dof/' + dokumen + '&embedded=true" width="100%" height="600"></iframe>';
    $('#dokumen_dof').html(html);
  }
  /* Dokumen */
</script>