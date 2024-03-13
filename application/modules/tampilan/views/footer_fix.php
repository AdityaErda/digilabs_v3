          <!-- Footer -->
          <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
              <b>Version</b> 1.0.1
            </div>
            <strong>Copyright &copy; 2021 Petrokimia Gresik.</strong>
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

          <!-- angka dengan pemisah koma -->
          <script type="text/javascript">
            function numberWithComma(event) {
              var charCode = (event.which) ? event.which : event.keyCode
              if ((charCode >= 48 && charCode <= 57) ||
                charCode == 44)
                return true;
              return false;
            }
          </script>
          <!-- angka dengan pemisah koma -->

          <!-- Angka Saja -->
          <script type="text/javascript">
            function numberOnly(event) {
              var charCode = (event.which) ? event.which : event.keyCode
              if (charCode >= 48 && charCode <= 57)
                return true;
              return false;
            }
          </script>
          <!-- Angka Saja -->

          <script>
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