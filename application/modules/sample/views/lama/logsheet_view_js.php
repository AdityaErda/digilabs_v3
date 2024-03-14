<script>
  $('#simpan').on('click', function() {
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
        // location.href = '<?= base_url('sample/inbox/viewLogSheet/?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) . '&transaksi_id=' . $_GET['transaksi_id'] . '&transaksi_detail_id=' ?>' + $('#transaksi_detail_id').val() + '&transaksi_detail_status=' + '<?= $_GET['transaksi_detail_status'] + 1 . '&template_logsheet_id=' ?>' + $('#template_logsheet_id').val() + '&logsheet_id=' + $('#logsheet_id').val();
      }
    });
  })

  $('#print_logsheet').on('click', function() {
    window.open('<?= base_url('sample/inbox/cetakLogSheet/?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) . '&transaksi_id=' . $_GET['transaksi_id'] . '&transaksi_detail_id=' . $_GET['transaksi_detail_id'] . '&transaksi_detail_status=' . $_GET['transaksi_detail_status'] . '&template_logsheet_id=' . $_GET['template_logsheet_id'] . '&logsheet_id=' . $_GET['logsheet_id'] ?>', '_blank');
  })

  $('#print_sertifikat').on('click', function() {
    window.open('<?= base_url('sample/inbox/cetakSertifikat/?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) . '&transaksi_id=' . $_GET['transaksi_id'] . '&transaksi_detail_id=' . $_GET['transaksi_detail_id'] . '&transaksi_detail_status=' . $_GET['transaksi_detail_status'] . '&template_logsheet_id=' . $_GET['template_logsheet_id'] . '&logsheet_id=' . $_GET['logsheet_id'] ?>', '_blank');
  })
</script>