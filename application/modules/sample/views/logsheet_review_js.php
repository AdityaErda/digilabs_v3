<script>
  $('#id_template_footer').select2({
    dropdownParent: $("#modal_template"),
    placeholder: 'Pilih',
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

  $('#typeId').select2({
    dropdownParent: $("#modal_send_dof"),
    placeholder: 'Pilih',
    ajax: {
      delay: 250,
      url: '<?= base_url('api_doc/dokumen_tipe/getDokumenTipeList?tipe=') ?>' + $('#transaksi_tipe').val() + '&code=SF',
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
  })


  $('.select2-selection').css('height', '37px');
  $('.select2').css('width', '100%');

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
        url = '<?= base_url('sample/inbox/insertReviewLogSheet') ?>';
        $.ajax({
          type: "POST",
          url: url,
          data: data,
          dataType: 'HTML',
          processData: false,
          contentType: false,
          cache: false,
          success: function(response) {
            location.href = '<?= base_url('sample/inbox/?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) ?>';
          }
        });

      }
    });
  })

  $('#setuju_raw').on('click', function() {
    $("#modal_template").modal('show');
  })

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

        if ($('#is_kan').is(":checked") == true) var is_kan = 'y';
        else var is_kan = 'n';

        data.append('is_kan', is_kan);
        data.append('id_template_footer', $('#id_template_footer').val());

        url = '<?= base_url('sample/inbox/insertApproveKonsepLogsheet') ?>';
        $.ajax({
          type: "POST",
          url: url,
          data: data,
          dataType: 'HTML',
          processData: false,
          contentType: false,
          cache: false,
          success: function(response) {
            var reload = location.reload();
            if (reload) {
              $('#div_sertifikat').show();
            }
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
        url = '<?= base_url('sample/inbox/insertApproveSertifikat') ?>';
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

  $('#send_dof_modal').on('click', function(e) {
    $('#modal_send_dof').modal('show');
    var id = $('#transaksi_id').val();
    $.getJSON('<?= base_url() ?>sample/request/getRequest', {
        transaksi_id: id
      },
      function(json, textStatus) {
        $.each(json, function(index, val) {
          $('#' + index).val(val);
        });
        $('#classId').val(json.klasifikasi_id);
        $('#className').val(json.klasifikasi_kode + ' - ' + json.klasifikasi_nama);
        $('#category').val(json.transaksi_sifat);
        $('#responseSpeed').val(json.transaksi_kecepatan_tanggap);
        $('#title').val(json.transaksi_judul);
        $('#drafterId').val(json.id_dof_drafter)
        $('#drafterName').val(json.nama_drafter)
        $('#approverId').val(json.id_dof_approver)
        $('#approverName').val(json.nama_approver)
        $('#reviewerId').val(json.id_dof_reviewer)
        $('#reviewerName').val(json.nama_reviewer)
        $('#tujuanId').val(json.id_dof_tujuan)
        $('#tujuanName').val(json.nama_tujuan)
        /*optional stuff to do after success */
      });
  })

  $('#send_dof').on('click', function() {

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

        var data = new FormData($('#form_logsheet')[0]);
        data.append('custom_area', $('#custom_area').val());

        url = '<?= base_url('sample/inbox/insertDOF') ?>';
        $.ajax({
          type: "POST",
          url: url,
          data: data,
          dataType: 'HTML',
          processData: false,
          contentType: false,
          cache: false,
          success: function(response) {
            // location.href = '<?= base_url('sample/inbox/?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) ?>';
          }
        });

      }
    });
  })

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
        data.append('transaksi_detail_id', $('#transaksi_detail_id_new').val());
        data.append('transaksi_detail_id_temp', $('#transaksi_detail_id_temp').val());
        data.append('logsheet_id', $('#logsheet_id').val());
        data.append('custom_area', $('#custom_area').val());

        url = '<?= base_url('sample/inbox/insertDOF') ?>';
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
            // location.href = '<?= base_url('sample/inbox/?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) ?>';
          }
        });

      }
    });
  })

  $('#cetak_konsep').on('click', function() {
    $('.no-print').hide();
    window.print();
    window.onfocus = $('.no-print').show()
  })

  $('#draft').on('click', function() {
    location.href = '<?= base_url('sample/inbox/?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) ?>';
  })


  $('#print_logsheet').on('click', function() {
    window.open('<?= base_url('sample/inbox/cetakLogSheet/?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) . '&transaksi_id=' . $_GET['transaksi_id'] . '&transaksi_detail_id=' . $_GET['transaksi_detail_id'] . '&transaksi_detail_status=' . $_GET['transaksi_detail_status'] . '&template_logsheet_id=' . $_GET['template_logsheet_id'] . '&logsheet_id=' . $_GET['logsheet_id'] ?>', '_blank');
  })

  $('#print_sertifikat').on('click', function() {
    window.open('<?= base_url('sample/inbox/cetakSertifikat/?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) . '&transaksi_id=' . $_GET['transaksi_id'] . '&transaksi_detail_id=' . $_GET['transaksi_detail_id'] . '&transaksi_detail_status=' . $_GET['transaksi_detail_status'] . '&template_logsheet_id=' . $_GET['template_logsheet_id'] . '&logsheet_id=' . $_GET['logsheet_id'] ?>', '_blank');
  })

  function func_is_kan(id) {
    if (id == 'y') {
      $('#div_is_kan').show();
    } else {
      $('#div_is_kan').hide();
    }
  }

  tinymce.init({
    selector: "textarea.custom_raw_eksekutor",
    // height: 300,
    plugins: [
      "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
      "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
      "save table contextmenu directionality emoticons template paste textcolor",
      "autoresize",
      "bootstrap",
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",
  });

  tinymce.init({
    selector: "textarea.custom_area",
    script_url: '<?= base_url() ?>assets_tambahan/tinymce/tinymce.min.js', // replace with your own path
    // height: 300,
    plugins: "advlist code searchreplace autolink directionality visualblocks visualchars image link media codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist charmap emoticons print autosave autoresize charmap colorpicker contextmenu fullscreen fullpage textpattern bootstrap",

    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",
    contextmenu: "link image imagetools table spellchecker | bootstrap",
    file_picker_types: 'file image media',

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

  function func_change_tipe() {
    $.getJSON("<?= base_url() ?>api_doc/dokumen_tipe/getDokumenTipe2", {
        code: 'SF'
      },
      function(data, textStatus, jqXHR) {
        $.each(data, function(index, value) {
          $('#typeId').append('<option selected value="' + value.document_type_id + '"> ' + value.document_type_name + ' </option>');
          $('#typeId').trigger('change');
        });
      }
    );


    $('.select2-selection').css('height', '37px');
    $('.select2').css('width', '100%');
  }

  func_change_tipe();
  /* Fun Close Detail */
  function func_close_send_dof() {
    $('#typeId').empty();
    $('#templateId').empty();
    // $('#form_modal_detail')[0].reset();

    // $('#loading_form_detail').css('display', 'none');
    // $('#clossed').css('display', 'block');
    // $('#table_detail').DataTable().ajax.reload();
    // $('#table').DataTable().ajax.reload();
  }
  /* Fun Close */
  $('#modal_send_dof').on('hidden.bs.modal', function(e) {
    func_close_send_dof();
  });
</script>