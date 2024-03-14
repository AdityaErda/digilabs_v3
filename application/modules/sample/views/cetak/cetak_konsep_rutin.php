<!DOCTYPE html>
<html lang="en">
<style>
	.center {
		margin-left: auto;
		margin-right: auto;
	}

	body {
		font-size: 11pt;
		font-family: Arial;
		size: A4;
		margin-top: 0mm;
		margin-bottom: 0mm;
		margin-left: 1.08in;
		margin-right: 0.89in;
	}

	footer {
		font-size: 11pt;
		font-family: Arial;
		color: #f00;
		text-align: center;
		/* position: fixed; */
	}

	@page {
		size: A4;
		margin-top: 0cm;
		margin-bottom: 0cm;
	}

	@media print {

		@page {
			/*			margin: 3mm;*/
			/*			margin-left: 1.08in;*/
			/*			margin-right: 0.89in; */

		}

		body {
			margin: 0mm;
			/* margin-left: 1.08in;
			margin-right: 0.89in; */
			/* margin-bottom: 0mm; */
			/* margin-left: 1.08in; */
			/* margin-right: 0.89in; */
		}

		footer {
			position: fixed;
			width: -webkit-fill-available;
			bottom: 0;
		}

		.content-block,
		p {
			page-break-inside: avoid;
		}
	}
</style>


<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Konsep</title>
	<!-- tambahan -->
	<script src="<?= base_url() ?>assets/plugins/jquery/jquery.min.js"></script>
	<script src="<?= base_url() ?>assets_tambahan/tinymce/tinymce.min.js"></script>
	<!-- tambahan -->
</head>
<textarea name="custom_area" id="custom_area">
	<body>
		<table width="100%" border="1"  cellpadding="2" cellspacing="2" style="border:1px solid black;border-collapse:collapse;border-radius:20cm;text-align:left">
			<tr style="text-align: center;">
				<td rowspan="4"><img src="<?= base_url() ?>/gambar/img/logo/LogoPetro-.png" alt="" style="width:200px"></td>
				<td rowspan="4"><strong>BAGIAN LABORATORIUM UJI KIMIA</strong><br>LEMBAR ANALISA/UJI & KALIBRASI</td>
				<td style="text-align: left;">No. Dokumen : FM-39-4001</td>
				<!-- <td style="text-align: left;">No. Dokumen : <?php print_r($inbox_detail[0]['transaksi_detail_nomor']); ?></td> -->
			</tr>
			<tr>
				<td>Terbitan / Revisi : -</td>
			</tr>
			<tr>
				<td>Tgl Pengesahan : <?= date_indo(date('Y-m-d')); ?></td>
			</tr>
			<tr>
				<td>Lembar : 1 Dari 1</td>
			</tr>
		</table>
		<table width="100%" border="0"  cellpadding="1" cellspacing="1">
			<tr>
				<td width="25%">Nomor Sample</td>
				<td width="5%">:</td>
				<td><?= $inbox_detail[0]['transaksi_detail_nomor_sample'] ?></td>
			</tr>
			<tr>
				<td width="25%">Jenis Sample</td>
				<td width="5%">:</td>
				<td ><?= $inbox_detail[0]['jenis_nama'] ?></td>
			</tr>
			<tr>
				<td width="25%">Peminta Jasa</td>
				<td width="5%">:</td>
				<td ><?= $sample['peminta_jasa_nama'] ?></td>
			</tr>
			<tr>
				<td width="25%">Nomor Permintaan</td>
				<td width="5%">:</td>
				<td ><?= $sample['transaksi_nomor'] ?></td>
			</tr>
			<tr>
				<td width="25%">Asal Sample</td>
				<td width="5%">:</td>
				<td ><?= $logsheet['logsheet_asal_sample'] ?></td>
			</tr>
			<?php if ($inbox_detail[0]['is_sampling'] == 'y') { ?>
				<tr>
					<td width="25%">Tanggal Pengambilan Sample</td>
					<td width="5%">:</td>
					<td ><?= $logsheet['logsheet_tgl_sampling'] ?></td>
				</tr>
			<?php } ?>
			<tr>
				<td width="25%">Pengambilan Sample Oleh</td>
				<td width="5%">:</td>
				<td ><?= $logsheet['logsheet_pengolah_sample'] ?></td>
			</tr>
			<tr>
				<td width="25%">Deskripsi Sample</td>
				<td width="5%">:</td>
				<td ><?= $logsheet['logsheet_deskripsi'] ?></td>
			</tr>
		</table>
		<br>
		<br>
		<table width="100%" border="1"  cellpadding="2" cellspacing="2" style="border:1px solid black;border-collapse:collapse;border-radius:20cm;text-align:left">
			<tr>
				<td width="25%">Diterima Oleh</td>
				<td><?= $logsheet['nama_review'] ?></td>
				<td >NIK</td>
				<td ><?= $logsheet['logsheet_review'] ?></td>
				<td rowspan="2" width="7%"><img src="<?= base_url('img/' . $logsheet['logsheet_review_qr']) ?>" style="max-width:2cm;max-height:2cm"></td>
			</tr>
			<tr>
				<td>Tanggal</td>
				<td colspan="3"><?= date_indo(date('Y-m-d', strtotime($logsheet['logsheet_review_date']))) ?></td>
			</tr>

		</table>
		<table width="100%" border="1"  cellpadding="2" cellspacing="2" style="border:1px solid black;border-collapse:collapse;border-radius:20cm;text-align:left">
			<tr>
				<td width="25%">Diserahkan Kepada</td>
				<td><?= $logsheet['nama_analisis'] ?></td>
				<td >NIK</td>
				<td ><?= $logsheet['logsheet_analisis'] ?></td>
				<td rowspan="4"  width="7%"><img src="<?= base_url('img/' . $logsheet['logsheet_analisis_qr']) ?>" style="max-width:2cm;max-height:2cm"></td>
			</tr>
			<tr>
				<td>Tanggal</td>
				<td colspan="3"><?= date_indo(date('Y-m-d', strtotime($logsheet['logsheet_analisis_date']))) ?></td>
			</tr>
			<tr>
				<td width="25%">Dikerjakan Oleh</td>
				<td><?= $logsheet['nama_analisis'] ?></td>
				<td >NIK</td>
				<td ><?= $logsheet['logsheet_analisis'] ?></td>
			</tr>
			<tr>
				<td width="25%">Mulai Dikerjakan</td>
				<td><?= date_indo(date('Y-m-d', strtotime($logsheet['logsheet_tgl_terima']))) ?></td>
				<td >Selesai Dikerjakan</td>
				<td ><?= date_indo(date('Y-m-d', strtotime($logsheet['logsheet_review_date']))) ?></td>
			</tr>
		</table>
		<table width="100%" border="0"  cellpadding="2" cellspacing="2" >
			<tr>
				<td width="25%">Diterbitkan</td>
				<td> Koreksi (Staf Pratama I / II / III)</td>
			</tr>
		</table>
		<table width="100%" border="1"  cellpadding="2" cellspacing="2" style="border:1px solid black;border-collapse:collapse;border-radius:20cm;text-align:left">
			<tr>
				<td width="25%">Tanggal</td>
				<td><?= date_indo(date('Y-m-d', strtotime($logsheet['logsheet_last_update']))) ?></td>
				<td width="7%"><img src="<?= base_url('img/' . $logsheet['logsheet_analisis_qr']) ?>" style="max-width:2cm;max-height:2cm"></td>

				<td width="25%">Tanggal</td>
				<td><?= date_indo(date('Y-m-d', strtotime($logsheet['logsheet_review_date']))) ?></td>
				<td width="7%"><img src="<?= base_url('img/' . $logsheet['logsheet_analisis_qr']) ?>" style="max-width:2cm;max-height:2cm"></td>
			</tr>
		</table>
		<table width="100%" border="1"  cellpadding="2" cellspacing="2" style="border:1px solid black;border-collapse:collapse;border-radius:20cm;text-align:left">
			<tr>
				<td width="25%">No. Surat / Sertifikat Hasil Pengujian</td>
				<td><?php echo $inbox_detail[0]['transaksi_detail_no_surat'] ?></td>

			</tr>
			<tr>
				<td width="25%">Tanggal</td>
				<td><?= date_indo(date('Y-m-d', strtotime($inbox_detail[0]['transaksi_detail_tgl_pengajuan']))) ?></td>
			</tr>
		</table>
		<br>
	</body>
</textarea>



</html>



<script>
	tinymce.init({
		selector: "textarea#custom_area",
		// height: 300,
		plugins: [
			"advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
			"searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
			"save table contextmenu directionality emoticons template paste textcolor",
			"autoresize"
			],
		toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",
	});
</script>