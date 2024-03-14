<script type="text/javascript">
  $(function() {
    tinymce.init({
      selector: "textarea.custom_raw_eksekutor",
      plugins: [
        "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
        "save table contextmenu directionality emoticons template paste textcolor",
        "autoresize",
      ],
      toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",
    });
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

  /* Reupload */
  $('#reupload').on('click', function() {
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
        data.append('transaksi_detail_id', $('#transaksi_detail_id').val());
        data.append('transaksi_detail_id_temp', $('#transaksi_detail_id_temp').val());
        data.append('transaksi_non_rutin_id', $('#transaksi_non_rutin_id').val());
        data.append('transaksi_tipe', $('#transaksi_tipe').val());
        data.append('transaksi_reset_logsheet_alasan', 'Upload Ulang Excel');

        var url = '<?= base_url() ?>sample/inbox/insertReset';

        $.ajax({
          type: "POST",
          url: url,
          data: data,
          dataType: "HTML",
          contentType: false,
          processData: false,
          Cache: false,
          success: function(response) {
            location.href = '<?= base_url('sample/inbox/?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) ?>'
          }
        });
      }
    });
  })
  /* Reupload */

  $('#close').on('click', function() {
    location.href = '<?= base_url('sample/inbox/?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) ?>';
  });

  $('#cetak').on('click', function() {
    tinymce.activeEditor.execCommand('mcePrint');
  });

  $('#draft').on('click', function() {
    location.href = '<?= base_url('sample/inbox/?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) ?>';
  });

  $('#simpan_modal').on('click', function() {
    $("#modal_template").modal('show');
  });

  $('#simpan').on('click', function() {
    Swal.fire({
      title: "Apakah Anda Yakin?",
      text: "Pastikan Data Yang Anda Input Sudah Sesuai Sebelum Melanjutkan !",
      icon: "danger",
      showCancelButton: true,
      confirmButtonColor: "#34c38f",
      cancelButtonColor: "#f46a6a",
      confirmButtonText: "Yakin",
      cancelButtonText: "Cek Lagi",
    }).then(function(result) {
      if (result.value) {
        var data = new FormData($('#form_logsheet')[0]);

        var is_kan = ($('#is_kan').is(":checked") == true) ? 'y' : 'n';
        data.append('is_kan', is_kan);
        var is_ds = ($('#is_ds').is(":checked") == true) ? 'y' : 'n';
        data.append('is_ds', is_ds);
        data.append('id_template_footer', $('#id_template_footer').val());
        data.append('logsheet_keterangan', $('#logsheet_keterangan').val());

        url = '<?= base_url('sample/inbox/insertLogSheet') ?>';
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
</script>