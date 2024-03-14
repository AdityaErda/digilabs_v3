<script type="text/javascript">
  $(function() {
    fun_loading();
  });

  /* Proses */
  $("#form_tenaga_kerja").on("submit", function(e) {
    e.preventDefault();
    $.getJSON('<?= base_url('login/login/checkLogin') ?>', {}, function(json) {
      if (!json.user_id) {
        fun_notifLogout();
      } else {
        if ($('#uhpd_id').val() != '') var url = '<?= base_url('master/uhpd/updateUhpd') ?>';
        else var url = '<?= base_url('master/uhpd/insertUhpd') ?>';

        e.preventDefault();
        $.ajax({
          url: url,
          data: $('#form_tenaga_kerja').serialize(),
          type: 'POST',
          dataType: 'html',
          success: function(isi) {
            $('#close').click();
            toastr.success('Berhasil');
          }
        });
      }
    });
  });
  /* Proses */

  function fun_loading() {
    var simplebar = new Nanobar();
    simplebar.go(100);
  }
</script>