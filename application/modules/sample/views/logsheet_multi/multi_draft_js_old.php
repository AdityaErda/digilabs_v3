<script>
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
        url = '<?= base_url('sample/multi_sample/insertLogSheet') ?>';
        $.ajax({
          type: "POST",
          url: url,
          data: data,
          dataType: 'HTML',
          processData: false,
          contentType: false,
          cache: false,
          success: function(response) {
            // location.href = '<?= base_url('sample/multi_sample/?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) ?>';
          }
        });

      }
    });

  })

  $('#cetak').on('click', function() {
    $('.no-print').hide();
    // window.open();
    window.print();
    window.onfocus = $('.no-print').show();
  })

  $('#draft').on('click', function() {
    location.href = '<?= base_url('sample/inbox/?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) ?>';
  })


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
</script>
<!-- $('#print_logsheet').on('click', function() {
  window.open('<?= base_url('sample/inbox/cetakLogSheet/?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) . '&transaksi_id=' . $_GET['transaksi_id'] . '&transaksi_detail_id=' . $_GET['transaksi_detail_id'] . '&transaksi_detail_status=' . $_GET['transaksi_detail_status'] . '&template_logsheet_id=' . $_GET['template_logsheet_id'] . '&logsheet_id=' . $_GET['logsheet_id'] ?>', '_blank');
})

$('#print_sertifikat').on('click', function() {
  window.open('<?= base_url('sample/inbox/cetakSertifikat/?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) . '&transaksi_id=' . $_GET['transaksi_id'] . '&transaksi_detail_id=' . $_GET['transaksi_detail_id'] . '&transaksi_detail_status=' . $_GET['transaksi_detail_status'] . '&template_logsheet_id=' . $_GET['template_logsheet_id'] . '&logsheet_id=' . $_GET['logsheet_id'] ?>', '_blank');
}) -->