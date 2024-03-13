<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Digilabs</title>
  <meta content="" name="description">

  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="<?= base_url() ?>gambar/img/logo/logo_digilab.png" rel="icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="<?= base_url('assets_landing') ?>/vendor/aos/aos.css" rel="stylesheet">
  <link href="<?= base_url('assets_landing') ?>/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= base_url('assets_landing') ?>/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="<?= base_url('assets_landing') ?>/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="<?= base_url('assets_landing') ?>/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="<?= base_url('assets_landing') ?>/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="<?= base_url('assets_landing') ?>/css/style.css" rel="stylesheet">

  <style type="text/css">
    iframe {
      width: 100% !important;
    }

    .swiper-slide-active {
      opacity: 1 !important;
    }

    @media (min-width:1281px) {
      .swiper-slide-active {
        margin-left: 35%;
      }
    }

    section {
      margin-bottom: -50px;
    }
  </style>
</head>
<?php
$sql = $this->db->query("SELECT * FROM landing.landing WHERE aktif = 'y' ORDER BY landing_urut ASC");
$data = $sql->result_array();
?>

<body>
  <!-- HEADER -->
  <header id="header" class="header fixed-top">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">
      <a href="<?= base_url() ?>" class="logo d-flex align-items-center">
        <img src="<?= base_url() ?>gambar/img/logo/logo_digilab.png" alt="">
        <span>Digilabs</span>
      </a>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto" href="#" onclick="fun_tracking()">Tracking Sample</a></li>
          <?php foreach ($data as $key => $value) : ?>
            <?php if ($key == 0) : ?>
              <li><a class="nav-link scrollto active" href="#<?= $value['landing_link'] ?>"><?= $value['landing_judul'] ?></a></li>
            <?php else : ?>
              <li><a class="nav-link scrollto" href="#<?= $value['landing_link'] ?>"><?= $value['landing_judul'] ?></a></li>
            <?php endif ?>
          <?php endforeach ?>
          <li><a class="getstarted scrollto" href="<?= base_url('login') ?>">Login</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav>
    </div>
  </header>
  <!-- HEADER -->

  <section class="footer" style="margin-top: 80px; display: none;" id="tracking">
    <input type="hidden" name="tampil" id="tampil" value="0">
    <div class="footer-newsletter">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-12 text-center">
            <h4>Tracking Sample</h4>
          </div>
          <div class="col-lg-12">
            <form action="" method="POST">
              <input type="text" id="transaksi_nomor" name="transaksi_nomor" class="form-control" value="<?= $this->input->post('transaksi_nomor') ?>" required>
              <input type="submit" value="Cari">
            </form>
          </div>
          <p>&nbsp;</p>
          <hr>
          <?php if (($this->input->post('transaksi_nomor'))) :
            $result = htmlspecialchars($this->input->post('transaksi_nomor'), ENT_QUOTES, 'UTF-8');;
            $sql = $this->db->query("SELECT * FROM sample.sample_transaksi a LEFT JOIN sample.sample_transaksi_detail b ON a.transaksi_id = b.transaksi_id LEFT JOIN sample.sample_peminta_jasa d ON d.peminta_jasa_id = b.peminta_jasa_id LEFT JOIN sample.sample_jenis q ON q.jenis_id = b.jenis_id WHERE UPPER(transaksi_nomor) LIKE '%" . strtoupper($result) . "%' AND (is_proses != 'y' OR is_proses is NULL) ORDER BY a.transaksi_nomor ASC");
            $dataSample = $sql->result_array();
          ?>
            <table width="100%" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>No Surat</th>
                  <th>Jenis Sample</th>
                  <th>Status</th>
                  <th>Peminta Jasa</th>
                  <th>Nomor Sample</th>
                </tr>
              </thead>
              <tbody>
                <?php if ($dataSample) : ?>
                  <?php foreach ($dataSample as $value) : ?>
                    <?php
                    $status = '';
                    if ($value['transaksi_detail_status'] == '0')  $status = 'Draft';
                    else if ($value['transaksi_detail_status'] == '1')  $status = 'Pengajuan';
                    else if ($value['transaksi_detail_status'] == '2')  $status = 'Review AVP';
                    else if ($value['transaksi_detail_status'] == '3')  $status = 'Approve VP';
                    else if ($value['transaksi_detail_status'] == '4')  $status = 'Approve VP PPK';
                    else if ($value['transaksi_detail_status'] == '5')  $status = 'Approve AVP LUK';
                    else if ($value['transaksi_detail_status'] == '6')  $status = 'Sample Belum Diterima';
                    else if ($value['transaksi_detail_status'] == '12')  $status = 'Tunda';
                    else if ($value['transaksi_detail_status'] == '7')  $status = 'Sample Diterima';
                    else if ($value['transaksi_detail_status'] == '13')  $status = 'Tunda';
                    else if ($value['transaksi_detail_status'] == '8')  $status = 'On Progress';
                    else if ($value['transaksi_detail_status'] == '9')  $status = 'Log Sample';
                    else if ($value['transaksi_detail_status'] == '10')  $status = 'Terbit Sertifikat';
                    else if ($value['transaksi_detail_status'] == '11')  $status = 'Clossed';
                    else if ($value['transaksi_detail_status'] == '14')  $status = 'Batal';
                    else if ($value['transaksi_detail_status'] == '15')  $status = 'Reject';
                    else if ($value['transaksi_detail_status'] == '16') $status = 'Send DOF';
                    else if ($value['transaksi_detail_status'] == '17') $status = 'Terbit Sertifikat';
                    // else if ($value['transaksi_detail_status'] == '18' && $value['logsheet_id'] == null)                    $status = 'Closed NOn Letter';
                    else if ($value['transaksi_detail_status'] == '18') $status = 'Closed';

                    ?>
                    <tr>
                      <td><?= $value['transaksi_nomor'] ?></td>
                      <td><?= $value['jenis_nama'] ?></td>
                      <td><?= $status ?></td>
                      <td><?= $value['peminta_jasa_nama'] ?></td>
                      <td><?= $value['transaksi_detail_nomor_sample'] ?></td>
                    </tr>
                  <?php endforeach ?>
                <?php endif ?>
              </tbody>
            </table>
          <?php endif ?>
        </div>
      </div>
    </div>
  </section>

  <?php foreach ($data as $isi) : ?>
    <?php if ($isi['landing_tipe'] == 'B') : ?>
      <section id="<?= $isi['landing_link'] ?>" class="testimonials">
        <div class="container" data-aos="fade-up">
          <div class="testimonials-slider swiper" data-aos="fade-up" data-aos-delay="200">
            <div class="swiper-wrapper">
              <?php
              $sql = $this->db->query("SELECT * FROM landing.landing_detail WHERE landing_detail_status = 'y' AND id_landing = '" . $isi['landing_id'] . "' ORDER BY landing_detail_urutan ASC");
              $dataDetail = $sql->result_array();
              ?>
              <?php foreach ($dataDetail as $isi_detail) : ?>
                <div class="swiper-slide" style="opacity: 0;">
                  <div class="testimonial-item" style="padding: 30px; margin-left: -300px; margin-right: -300px;">
                    <img src="<?= base_url('landing/') . $isi_detail['landing_detail_gambar'] ?>">
                    <h3><?= $isi_detail['landing_detail_judul'] ?></h3>
                  </div>
                </div>
              <?php endforeach ?>
            </div>
            <div class="swiper-pagination"></div>
          </div>
        </div>
      </section>
    <?php elseif ($isi['landing_tipe'] == 'T') : ?>
      <section id="<?= $isi['landing_link'] ?>" class="about">
        <div class="container" data-aos="fade-up">
          <div class="row gx-0">
            <?php
            $sql = $this->db->query("SELECT * FROM landing.landing_detail WHERE landing_detail_status = 'y' AND id_landing = '" . $isi['landing_id'] . "' ORDER BY landing_detail_urutan ASC");
            $dataDetail = $sql->result_array();
            ?>
            <?php foreach ($dataDetail as $isi_detail) : ?>
              <div class="col-lg-9 d-flex flex-column justify-content-center" data-aos="fade-up" data-aos-delay="200">
                <div class="content">
                  <h1><?= $isi['landing_judul'] ?></h1>
                  <p>
                    <?= $isi_detail['landing_detail_text'] ?>
                  </p>
                </div>
              </div>
              <div class="col-lg-3 d-flex align-items-center" data-aos="zoom-out" data-aos-delay="200">
                <img src="<?= base_url('landing/') . $isi_detail['landing_detail_gambar'] ?>" class="img-fluid" alt="">
              </div>
            <?php endforeach ?>
          </div>
        </div>
      </section>
    <?php elseif ($isi['landing_tipe'] == 'N') : ?>
      <section id="<?= $isi['landing_link'] ?>" class="features">
        <div class="container" data-aos="fade-up">
          <!-- Feature Tabs -->
          <div class="row feture-tabs" data-aos="fade-up">
            <div class="col-lg-12">
              <h3><?= $isi['landing_judul'] ?></h3>
              <?php
              $sql = $this->db->query("SELECT * FROM landing.landing_detail WHERE landing_detail_status = 'y' AND id_landing = '" . $isi['landing_id'] . "' ORDER BY landing_detail_urutan ASC");
              $dataDetail = $sql->result_array();
              ?>
              <ul class="nav nav-pills mb-3">
                <?php foreach ($dataDetail as $k => $isi_detail) : ?>
                  <?php if ($k == 0) : ?>
                    <li><a class="nav-link active" data-bs-toggle="pill" href="#tab<?= $k + 1 ?>"><?= $isi_detail['landing_detail_judul'] ?></a></li>
                  <?php else : ?>
                    <li><a class="nav-link" data-bs-toggle="pill" href="#tab<?= $k + 1 ?>"><?= $isi_detail['landing_detail_judul'] ?></a></li>
                  <?php endif ?>
                <?php endforeach ?>
              </ul>

              <div class="tab-content">
                <?php foreach ($dataDetail as $k => $isi_detail) : ?>
                  <?php if ($k == 0) : ?>
                    <div class="tab-pane fade show active" id="tab<?= $k + 1 ?>">
                      <table width="100%">
                        <tr>
                          <td width="75%">
                            <p><?= $isi_detail['landing_detail_text'] ?></p>
                          </td>
                          <td width="25%">
                            <img src="<?= base_url('landing/') . $isi_detail['landing_detail_gambar'] ?>" class="img-fluid" alt="">
                          </td>
                        </tr>
                      </table>
                    </div>
                  <?php else : ?>
                    <div class="tab-pane fade show" id="tab<?= $k + 1 ?>">
                      <table width="100%">
                        <tr>
                          <td width="75%">
                            <p><?= $isi_detail['landing_detail_text'] ?></p>
                          </td>
                          <td width="25%">
                            <img src="<?= base_url('landing/') . $isi_detail['landing_detail_gambar'] ?>" class="img-fluid" alt="">
                          </td>
                        </tr>
                      </table>
                    </div>
                  <?php endif ?>
                <?php endforeach ?>
              </div>
            </div>
          </div>
        </div>
      </section>
    <?php elseif ($isi['landing_tipe'] == 'S') : ?>
      <section id="<?= $isi['landing_link'] ?>" class="portfolio">
        <div class="container" data-aos="fade-up">
          <header class="section-header">
            <p><?= $isi['landing_judul'] ?></p>
          </header>
          <?php
          $sql = $this->db->query("SELECT * FROM landing.landing_detail WHERE landing_detail_status = 'y' AND id_landing = '" . $isi['landing_id'] . "' ORDER BY landing_detail_urutan ASC");
          $dataDetail = $sql->result_array();
          ?>
          <div class="row gy-4 portfolio-container" data-aos="fade-up" data-aos-delay="200">
            <?php foreach ($dataDetail as $isi_detail) : ?>
              <div class="col-lg-6 col-md-6 portfolio-item">
                <div class="portfolio-wrap">
                  <img src="<?= base_url('landing/') . $isi_detail['landing_detail_gambar'] ?>" class="img-fluid" alt="">
                  <div class="portfolio-info">
                    <h4><?= $isi_detail['landing_detail_judul'] ?></h4>
                    <div class="portfolio-links">
                      <a href="<?= base_url('landing/') . $isi_detail['landing_detail_gambar'] ?>" data-gallery="portfolioGallery" class="portfokio-lightbox" title="<?= $isi_detail['landing_detail_judul'] ?>"><i class="bi bi-plus"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach ?>
          </div>
        </div>
      </section>
    <?php elseif ($isi['landing_tipe'] == 'G') : ?>
      <section id="<?= $isi['landing_link'] ?>" class="portfolio">
        <div class="container" data-aos="fade-up">
          <header class="section-header">
            <p><?= $isi['landing_judul'] ?></p>
          </header>
          <?php
          $sql = $this->db->query("SELECT * FROM landing.landing_detail WHERE landing_detail_status = 'y' AND id_landing = '" . $isi['landing_id'] . "' ORDER BY landing_detail_urutan ASC");
          $dataDetail = $sql->result_array();
          ?>
          <div class="row" data-aos="fade-up" data-aos-delay="200">
            <?php foreach ($dataDetail as $isi_detail) : ?>
              <div class="col-lg-12 col-md-12">
                <?= $isi_detail['landing_detail_text'] ?>
              </div>
            <?php endforeach ?>
          </div>
        </div>
      </section>
    <?php elseif ($isi['landing_tipe'] == 'R') : ?>
      <section id="<?= $isi['landing_link'] ?>" class="testimonials">
        <div class="container" data-aos="fade-up">
          <header class="section-header">
            <p><?= $isi['landing_judul'] ?></p>
          </header>
          <?php
          $sql = $this->db->query("SELECT * FROM landing.landing_detail WHERE landing_detail_status = 'y' AND id_landing = '" . $isi['landing_id'] . "' ORDER BY landing_detail_urutan ASC");
          $dataDetail = $sql->result_array();
          ?>
          <div class="testimonials-slider swiper" data-aos="fade-up" data-aos-delay="200">
            <div class="swiper-wrapper">
              <?php foreach ($dataDetail as $isi_detail) : ?>
                <div class="swiper-slide" style="margin-left: 0px;">
                  <div class="testimonial-item">
                    <p>
                      <?= $isi_detail['landing_detail_text'] ?>
                    </p>
                    <div class="profile mt-auto">
                      <img src="<?= base_url('landing/') . $isi_detail['landing_detail_gambar'] ?>" class="testimonial-img" alt="">
                      <h3><?= $isi_detail['landing_detail_judul'] ?></h3>
                    </div>
                  </div>
                </div>
              <?php endforeach ?>
            </div>
            <div class="swiper-pagination"></div>
          </div>
        </div>
      </section>
    <?php elseif ($isi['landing_tipe'] == 'K') : ?>
      <section id="<?= $isi['landing_link'] ?>" class="contact">
        <div class="container" data-aos="fade-up">
          <header class="section-header">
            <p><?= $isi['landing_judul'] ?></p>
          </header>
          <?php
          $sql = $this->db->query("SELECT * FROM landing.landing_detail WHERE landing_detail_status = 'y' AND id_landing = '" . $isi['landing_id'] . "' ORDER BY landing_detail_urutan ASC");
          $dataDetail = $sql->result_array();
          ?>
          <div class="row gy-4">
            <div class="col-lg-12">
              <div class="row">
                <?php foreach ($dataDetail as $isi_detail) : ?>
                  <div class="col-md-4">
                    <div class="info-box" style="height: 300px;">
                      <h3><?= $isi_detail['landing_detail_judul'] ?></h3>
                      <?php if ($isi_detail['landing_detail_kontak'] != '') : ?>
                        <p>Kontak : <?= $isi_detail['landing_detail_kontak'] ?></p>
                      <?php endif ?>
                      <?php if ($isi_detail['landing_detail_fax'] != '') : ?>
                        <p>Fax : <?= $isi_detail['landing_detail_fax'] ?></p>
                      <?php endif ?>
                      <?php if ($isi_detail['landing_detail_email'] != '') : ?>
                        <p>Email : <?= $isi_detail['landing_detail_email'] ?></p>
                      <?php endif ?>
                      <?php if ($isi_detail['landing_detail_web'] != '') : ?>
                        <p>Web : <?= $isi_detail['landing_detail_web'] ?></p>
                      <?php endif ?>
                      <?php if ($isi_detail['landing_detail_alamat'] != '') : ?>
                        <p>Alamat : <?= $isi_detail['landing_detail_alamat'] ?></p>
                      <?php endif ?>
                    </div>
                  </div>
                <?php endforeach ?>
              </div>
            </div>
          </div>
        </div>
      </section>
    <?php endif ?>
  <?php endforeach ?>

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong><span>Petrokimia Gresik</span></strong> - 2022
      </div>
    </div>
  </footer>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="<?= base_url('assets_landing') ?>/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="<?= base_url('assets_landing') ?>/vendor/aos/aos.js"></script>
  <script src="<?= base_url('assets_landing') ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?= base_url('assets_landing') ?>/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="<?= base_url('assets_landing') ?>/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="<?= base_url('assets_landing') ?>/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="<?= base_url('assets_landing') ?>/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="<?= base_url('assets_landing') ?>/js/main.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.2.min.js" integrity="sha256-2krYZKh//PcchRtd+H+VyyQoZ/e3EcrkxhM8ycwASPA=" crossorigin="anonymous"></script>
  <script type="text/javascript">
    $(function() {
      if ($('#transaksi_nomor').val() != '') fun_tracking();
    })

    function fun_tracking() {
      var tampil = $('#tampil').val();

      if (tampil == 0) {
        $('#tampil').val('1');
        $('#tracking').css('display', 'block');
      } else {
        $('#tampil').val('0');
        $('#tracking').css('display', 'none');
      }
    }
  </script>
</body>

</html>