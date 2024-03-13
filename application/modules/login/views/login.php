<!DOCTYPE html>
<html lang="en">

<head>
	<title>Log in | DIGILAB PT. PETROKIMIA GRESIK</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="<?= base_url('assets_login') ?>/images/icons/favicon.ico" />
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets_login') ?>/vendor/bootstrap/css/bootstrap.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets_login') ?>/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets_login') ?>/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets_login') ?>/vendor/animate/animate.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets_login') ?>/vendor/css-hamburgers/hamburgers.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets_login') ?>/vendor/animsition/css/animsition.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets_login') ?>/vendor/select2/select2.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets_login') ?>/vendor/daterangepicker/daterangepicker.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets_login') ?>/css/util.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets_login') ?>/css/main.css">
	<!--===============================================================================================-->
</head>

<body style="background-color: #666666;">

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">

				<form class="login100-form validate-form" action="<?php echo base_url('login/masuk'); ?>" method="post" style="padding: 20px 55px 55px 55px;">
					<input type="hidden" name="header_menu" value="<?= (isset($_GET['header_menu'])) ? $_GET['header_menu'] : '' ?>">
					<input type="hidden" name="menu_id" value="<?= (isset($_GET['menu_id'])) ? $_GET['menu_id'] : '' ?>">
					<input type="hidden" name="tipe" value="<?= (isset($_GET['tipe'])) ? $_GET['tipe'] : '' ?>">
					<input type="hidden" name="transaksi_id" value="<?= (isset($_GET['transaksi_id'])) ? $_GET['transaksi_id'] : '' ?>">
					<input type="hidden" name="jenis_id" value="<?= (isset($_GET['jenis_id'])) ? $_GET['jenis_id'] : '' ?>">

					<span class="login100-form-title p-b-43">
						<img src="<?= base_url('gambar/img/logo/logo_digilab.png') ?>" width="60%">
					</span>
					<?php if ($this->session->flashdata('pesan')) { ?>
						<div class="alert alert-danger"><?= $this->session->flashdata('pesan') ?></div>
					<?php } ?>

					<div class="alert alert-primary">Login menggunakan login DOF</div>

					<div class="wrap-input100">
						<input class="input100" name="username" type="text" required="">
						<span class="focus-input100"></span>
						<span class="label-input100">Username</span>
					</div>


					<div class="wrap-input100">
						<input class="input100" name="password" type="password" required="">
						<span class="focus-input100"></span>
						<span class="label-input100">Password</span>
					</div>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn" style="background-color: green;">
							Login
						</button>
						<p>&nbsp;</p>
						<a href="<?= base_url() ?>" class="login100-form-btn" style="background-color: orange;">Kembali Ke Beranda</a>
					</div>
					<br>
					<div>
						<center>&copy; Petrokimia Gresik 2021</center>
					</div>
				</form>
				<div class="login100-more" style="background-image: url('<?= base_url("gambar/img/logo/login_baru.png") ?>'); background-size: 100%;">
				</div>
			</div>
		</div>
	</div>

	<!--===============================================================================================-->
	<script src="<?= base_url('assets_login') ?>/vendor/jquery/jquery-3.2.1.min.js"></script>
	<!--===============================================================================================-->
	<script src="<?= base_url('assets_login') ?>/vendor/animsition/js/animsition.min.js"></script>
	<!--===============================================================================================-->
	<script src="<?= base_url('assets_login') ?>/vendor/bootstrap/js/popper.js"></script>
	<script src="<?= base_url('assets_login') ?>/vendor/bootstrap/js/bootstrap.min.js"></script>
	<!--===============================================================================================-->
	<script src="<?= base_url('assets_login') ?>/vendor/select2/select2.min.js"></script>
	<!--===============================================================================================-->
	<script src="<?= base_url('assets_login') ?>/vendor/daterangepicker/moment.min.js"></script>
	<script src="<?= base_url('assets_login') ?>/vendor/daterangepicker/daterangepicker.js"></script>
	<!--===============================================================================================-->
	<script src="<?= base_url('assets_login') ?>/vendor/countdowntime/countdowntime.js"></script>
	<!--===============================================================================================-->
	<script src="<?= base_url('assets_login') ?>/js/main.js"></script>

</body>

</html>