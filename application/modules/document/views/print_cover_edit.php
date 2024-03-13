<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Cover</title>

	<!-- tambahan -->
	<script src="<?= base_url() ?>assets/plugins/jquery/jquery.min.js"></script>
	<script src="<?= base_url() ?>assets_tambahan/tinymce/tinymce.min.js"></script>
	<!-- tambahan -->

	<style type="text/css">
		@page {
			size: A4;
			margin: 0;
		}

		@media print {
			@page {
				margin: 0cm;
			}

			body {
				margin: 1cm;
			}
		}

		body {
			orientation: potrait;
			margin: 1cm;
			width: 210mm;
			/* height: 297mm; */
		}

		.isiText {
			font-family: Arial;
			font-size: 11pt;
		}

		.table {
			border: 1px solid black;
			border-collapse: collapse
		}
	</style>

</head>

<textarea name="cetak" id="cetak">
<body>
		<table class="table" width="95%" border="1">
			<tr>
			<th width="25%"><img style="background-repeat: no-repeat;height:90px;margin:0.3cm" src="<?= base_url('gambar/img/logo/logo_PG_Solusi_Agroindustri.png') ?>"></th>
			<th width="75%" style="font-family: Arial, Helvetica, sans-serif;">
				<h2>PT. PETROKIMIA GRESIK</h2>
			</th>
		</tr>
		<tr>
			<th class="isiText" colspan="2" height="300px">
				<?php echo $isi['transaksi_nomor_document'] ?><br /><br />
				<?php echo $isi['transaksi_judul_document'] ?>
			</th>
		</tr>
	</table>
	<table class="table" width="95%" border="1">
		<tbody>
			<tr>
				<td class="isiText" width="50%" height="160px">&nbsp;</td>
				<td class="isiText" width="50%">&nbsp;</td>
			</tr>
			<tr>
				<td class="isiText" height="160px">&nbsp;</td>
				<td class="isiText">&nbsp;</td>
			</tr>
		</tbody>
	</table>
	<table class="table" width="95%" border="1">
		<tbody>
			<tr>
				<th class="isiText" width="25%" height="65px">Tanggal Pengesahan</th>
				<th class="isiText" width="25%" height="65px">Terbitan</th>
				<th class="isiText" width="25%" height="65px">Revisi</th>
				<th class="isiText" width="25%" height="65px">No. Copy</th>
			</tr>
			<tr>
				<th class="isiText" height="65px"><?= $isi['transaksi_tgl_pengesahan'] ?></th>
				<th class="isiText" height="65px"><?= $isi['transaksi_terbitan'] ?></th>
				<th class="isiText" height="65px"><?= $isi['transaksi_revisi'] ?></th>
				<th class="isiText" height="65px">1</th>
			</tr>
		</tbody>
	</table>
	<!-- <br><br><br><br><br> -->
	<table class="table" width="95%" border="1">
		<tbody>
			<tr>
				<td class="isiText" width="33%" height="125px" valign="top">Dibuat Oleh:<br></td>
				<td class="isiText" width="33%" valign="top">Diterima Oleh:<br></td>
				<td class="isiText" width="33%" valign="top">Disahkan Oleh:<br></td>
			</tr>
		</tbody>
	</table>
</body>
</textarea>

</html>
<script>
	// window.print();
</script>

<script>
	$(function() {
		tinymce.init({
			selector: "textarea#cetak",
			// height: 300,
			plugins: [
				"advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
				"searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
				"save table contextmenu directionality emoticons template paste textcolor",
				"autoresize"
			],
			toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",
		});
	})
</script>