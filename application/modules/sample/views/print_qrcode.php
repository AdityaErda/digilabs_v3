<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>QR-Code</title>
	<link rel="stylesheet" href="">
	<style>
		table {
			border-collapse: collapse;
			border: 0px solid gray;
			/* width: calc(50% - 150px); */
			width: calc(30%);
			float: left;
			margin: 5px;


		}

		.rounded-sm {
			border: 1px solid #242121;
		}

		.logo {
			/* display: block; */
			margin-left: auto;
			margin-right: auto;
			margin-top: auto;
			margin-bottom: auto;
			/* width: 20%; */
		}

		.logo2 {
			/* display: block; */
			margin-left: 135px;
			margin-right: auto;
			margin-top: auto;
			margin-bottom: auto;
			/* float: right; */
			/* width: 20%; */
		}

		.left {
			display: block;
			margin-left: auto;
			margin-right: auto;
			margin-top: auto;
			margin-bottom: auto;
			float: left;
			/* width: 20%; */
		}

		.rounded {
			width: 100mm;
			height: 50mm;
			border: 1px solid black;
			border-radius: 10px;
		}


		@media print {
			@page {
				margin: 0;
				width: 110mm;
				height: 30.8mm;
				orientation: landscape;
			}

			body {
				margin-left: 0.2cm;
				margin-right: 0.2cm;
				margin-top: 0.4cm;
				margin-bottom: auto;
				width: 250mm;
				height: 200mm;
				/* height: 30.8mm; */
			}
		}
	</style>
</head>

<body>
	<table class="rounded">
		<tr>
			<td>
				<table style="width: 100mm; height: 50mm;table-layout: fixed;" border="0">
					<tr>
						<td style="width: 38%;">
							<img src="<?php echo base_url('gambar/img/logo/LogoPetro-.png'); ?>" alt="" width="57px" height="20px" class="logo">
						</td>
						<td>
							<img src="<?php echo base_url('gambar/img/logo/Kan.png'); ?>" alt="" width="50px" height="15px" class="logo2" style="float: right;">
						</td>
					</tr>
					<tr>
						<td>
							<img src="<?php echo base_url('img/' . $transaksi_id . '.PNG'); ?>" style="width: 37.5mm;">
						</td>
						<td style="font-size:8pt;">
							<b>Jenis Contoh: <?= $jenis_nama ?></b><br>
							<b>Identitas Sample: <?= ($transaksi_detail_identitas) ? $transaksi_detail_identitas : $identitas_nama; ?></b><br>
							<b>Tanggal Terima: <?= date('d-m-Y',strtotime($transaksi_detail_tgl_pengajuan_baru)); ?></b><br>
							<b>Nomor Sample:
								<?php if (!empty($transaksi_tipe == 'R')) {
									echo $transaksi_detail_nomor_sample;
								} else {
									echo $transaksi_detail_nomor_sample;
								}
								?>
							</b>
						</span>
					</td>
				</tr>
				<tr>
					<td colspan="2" width="50%" style="font-size: 8pt;">Laboratorium Uji Kimia</td>
				</tr>
				<tr>
					<td colspan="2" width="50%" style="font-size: 8pt;">Dep. Proses & Pengendalian Kualitas</td>
				</tr>
				<tr>
					<td colspan="2" width="50%" style="font-size: 8pt;"><b>PT. Petrokimia Gresik<b></td>
					</tr>
					<tr>
						<td colspan="2" width="50%" style="font-size: 8pt;">Jl. Jenderal A.Yani, Gresik 61119, Indonesia</td>
					</tr>
					<tr>
						<td colspan="2" width="50%" style="font-size: 8pt;">(031) 398 2100 ext. 2427</td>
					</tr>
<!-- 					<tr>
						<td width="50%" style="font-size: 8pt;">Email : litlab@petrokimia-gresik.com</td>
						<td>
							<img src="<?php echo base_url('gambar/img/logo/logo_digilab.png'); ?>" alt="" width="57px" height="23px" class="logo2">
						</td>
					</tr> -->
					<tr>
						<td colspan="2" style="font-size: 8pt;">
							<span>
								Email : litlab@petrokimia-gresik.com
								<img src="<?php echo base_url('gambar/img/logo/logo_digilab.png'); ?>" alt="" width="57px" height="23px" class="logo2" style="float: right;">
							</span>

						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</body>
</html>