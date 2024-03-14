<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <div class="alert alert-warning">
    Jika Dokumen Tidak Muncul Tekan Refresh
  </div>
  <div id="dokumen_dof">
  </div>
  <button class="btn btn-warning" onclick="fun_refresh_dokumen('<?= $this->uri->segment(4); ?>')">Refresh</button>
  <button class="btn btn-primary" onclick="fun_download_dokumen('<?= $this->uri->segment(4); ?>')">Download</button>
</body>

</html>

<script>
  /* Dokumen */
  setTimeout(function() {
    fun_refresh_dokumen('<?= $this->uri->segment(4); ?>')
  }, 2000);

  function fun_refresh_dokumen(dokumen) {
    var html = '<iframe src="https://docs.google.com/gview?url=103.157.97.200/dokumen_dof/' + dokumen + '&embedded=true" width="100%" height="600"></iframe>';
    $('#dokumen_dof').html(html);
  }

  function fun_download_dokumen(id) {
    window.open('<?= base_url('sample/library/downloadSertifikat/') ?>' + id, '_blank');
  }
  /* Dokumen */
</script>