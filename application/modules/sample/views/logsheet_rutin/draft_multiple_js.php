<script>
  function cetak_draft() {
    $('.no-print').hide();
    document.execCommand('print');
    window.onfocus = $('.no-print').show();
  }

  /* Reupload */
  $('#ulang').on('click', function() {
    Swal.fire({
      title: "Isi Ulang?",
      text: "Apakah Anda Yakin Akan Mereset dan Mengisi Ulang ?",
      type: "question",
      showCancelButton: true,
      confirmButtonColor: "#34c38f",
      cancelButtonColor: "#f46a6a",
      confirmButtonText: "Iya",
      cancelButtonText: "Tidak",
    }).then(function(result) {
      if (result.value) {
        var data = new FormData($('#form_logsheet_multiple')[0]);
        var url = '<?= base_url() ?>sample/nomor/insertReset';
        $.ajax({
          type: "POST",
          url: url,
          data: data,
          dataType: "HTML",
          contentType: false,
          processData: false,
          Cache: false,
          success: function(response) {
            location.href = '<?= base_url('sample/nomor/?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) ?>'
          }
        });
      }
    });
  })
  /* Reupload */
</script>