<!-- Footer -->
<footer class="main-footer no-print">
  <div class="float-right d-none d-sm-block">
    <b>Version</b> 1.0.1
  </div>
  <strong>Copyright &copy; <?= date('Y') ?> Petrokimia Gresik.</strong>
</footer>
<!-- Footer -->

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- Site wrapper -->
</body>
<!-- BODY -->

</html>

<?php
if (COUNT($this->session->userdata()) < 5) {
  redirect(base_url('login/login'));
}
?>

<script type="text/javascript">
  /*fungsi tombol back*/
  // history.pushState(null, null, location.href);
  // window.onpopstate = function () {
  //   history.go(1);
  // };
  /*fungsi tombol back*/
  /*<!-- angka dengan pemisah koma -->*/
  function numberWithComma(event) {
    var charCode = (event.which) ? event.which : event.keyCode
    if ((charCode >= 48 && charCode <= 57) ||
      charCode == 46)
      return true;
    return false;
  }
  /*<!-- angka dengan pemisah koma -->*/
  /*<!-- Angka Saja -->*/
  function numberOnly(event) {
    var charCode = (event.which) ? event.which : event.keyCode
    if (charCode >= 48 && charCode <= 57)
      return true;
    return false;
  }
  /*<!-- Angka Saja -->*/
</script>

<script>
  // notifikasi review
  function notifReview() {
    $.getJSON('<?= base_url() ?>sample/review/getReview?transaksi_detail_status=1&tgl_cari=<?= date('d-m-Y') . ' - ' . date('d-m-Y') ?>', function(json) {
      $('#notif_review').html(json.length);
    });
  }
  notifReview();
  // notifikasi review

  // notifikasi approved
  function notifApproved() {
    $.getJSON('<?= base_url() ?>sample/approved/getApproved?transaksi_detail_status=2&tgl_cari=<?= date('d-m-Y') . ' - ' . date('d-m-Y') ?>', function(json) {
      $('#notif_approved').html(json.length);
    });
  }
  notifApproved();
  // notifikasi approved

  // notifikasi lab
  function notifLab() {
    $.getJSON('<?= base_url() ?>sample/lab/getLab?transaksi_detail_status=3&tgl_cari=<?= date('d-m-Y') . ' - ' . date('d-m-Y') ?>', function(json) {
      $('#notif_lab').html(json.length);
    });
  }
  notifLab();
  // notifikasi lab

  // notifikiasi inbox
  function notifInbox() {
    $.getJSON('<?= base_url() ?>sample/inbox/getInbox?transaksi_detail_status=6&tgl_cari=<?= date('d-m-Y') . ' - ' . date('d-m-Y') ?>', function(json) {
      $('#notif_inbox').html(json.length);
    });
  }
  notifInbox();
  // notifikasi inbox



  function notifstoklimit(view = '') {
    $.ajax({
      url: "<?= base_url('material/notifikasi/getLimitMaterialJumlah') ?>",
      method: "POST",
      data: {
        view: view
      },
      dataType: "json",
      success: function(data) {
        if (data.total_limit > 0) {
          $('#notifLimitStok').html(data.total_limit);
        }
      }
    });
  }
  // setInterval(() => {
  notifstoklimit();
  // }, 5);

  function notifdocexp(view = '') {
    $.ajax({
      url: "<?= base_url('material/notifikasi_document/getNotifDocumentJumlah') ?>",
      method: "POST",
      data: {
        view: view
      },
      dataType: "json",
      success: function(data) {
        if (data.total_exp > 0) {
          $('#notifDocExp').html(data.total_exp);
        }
      }
    });
  }
  // setInterval(()=>{
  notifdocexp();
  // },5)

  function fun_notifLogout() { //fungsi untuk menampilkan notifikasi saat logout
    Swal.fire({ //swal untuk logout
      text: "Sesi Anda Telah Berakhir, Silahkan Login Kembali !",
      type: 'warning', //warning,error,success
      confirmButtonColor: "#FF4500", //red
      confirmButtonText: "OK", //"<i class='fa fa-thumbs-up'></i> Great!",
      allowOutsideClick: false, //tidak bisa di klik diluar
      allowEscapeKey: false, //tidak bisa tekan tombol esc
    }).then(function(result) { //ketika user menekan tombol ok
      if (result.value) { //jika user menekan tombol ok
        location.href = '<?= base_url('login') ?>'; //maka akan di alihkan ke halaman login
      }
    })
  }
</script>

<script>
  // script untuk tombol kembali ke menu...
  function kembali_request() {
    Swal.fire({
      title: "Kembali Ke Sample Request ?",
      text: "Apakah Anda Yakin Kembali Ke Halaman Utama Sample Request ?",
      icon: "question",
      showCancelButton: true,
      confirmButtonColor: "#34c38f",
      cancelButtonColor: "#f46a6a",
      confirmButtonText: "Iya",
      cancelButtonText: "Tidak",
    }).then(function(result) {
      if (result.value) {
        location.href = '<?= base_url('sample/request/?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) ?>'
      }
    });
  }

  function kembali_inbox() {
    Swal.fire({
      title: "Kembali Ke Inbox ?",
      text: "Apakah Anda Yakin Kembali Ke Halaman Utama Inbox ?",
      icon: "question",
      showCancelButton: true,
      confirmButtonColor: "#34c38f",
      cancelButtonColor: "#f46a6a",
      confirmButtonText: "Iya",
      cancelButtonText: "Tidak",
    }).then(function(result) {
      if (result.value) {
        location.href = '<?= base_url('sample/inbox/?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) ?>'
      }
    });
  }

  function kembali_inbox_multi() {
    Swal.fire({
      title: "Kembali Ke Inbox Multi Sample ?",
      text: "Apakah Anda Yakin Kembali Ke Halaman Utama Inbox Multi Sample ?",
      icon: "question",
      showCancelButton: true,
      confirmButtonColor: "#34c38f",
      cancelButtonColor: "#f46a6a",
      confirmButtonText: "Iya",
      cancelButtonText: "Tidak",
    }).then(function(result) {
      if (result.value) {
        location.href = '<?= base_url('sample/multi_sample/?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) ?>'
      }
    });
  }

  function kembali_rutin() {
    Swal.fire({
      title: "Kembali Ke Rutin ?",
      text: "Apakah Anda Yakin Kembali Ke Halaman Utama Nomor Rutin ?",
      icon: "question",
      showCancelButton: true,
      confirmButtonColor: "#34c38f",
      cancelButtonColor: "#f46a6a",
      confirmButtonText: "Iya",
      cancelButtonText: "Tidak",
    }).then(function(result) {
      if (result.value) {
        location.href = '<?= base_url('sample/nomor/?header_menu=' . $_GET['header_menu'] . '&menu_id=' . $_GET['menu_id']) ?>'
      }
    });
  }
  // script untuk tombol kembali ke menu...
</script>