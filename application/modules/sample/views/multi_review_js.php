<script>
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
        url = '<?= base_url('sample/multi_sample/insertApproveKonsepLogsheet') ?>';
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
      "save table contextmenu directionality emoticons template paste textcolor",
      "bootstrap",
      "autoresize",

    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",
    contextmenu: "link image imagetools table spellchecker | bootstrap",
    file_picker_types: 'file image media',

  });

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
</script>