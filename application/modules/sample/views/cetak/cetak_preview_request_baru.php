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
		margin-top: 0.75cm;
		margin-bottom: 0mm;
		/*margin-left: 0mm;*/
		/*		margin-left: 1cm;*/
		/*margin-right: 0mm;*/
		/*		margin-right: 1cm;*/
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
			margin-top: 0.75cm;
			margin-bottom: 0mm;
			/*			margin-left: 1cm;*/
			/*margin-left: 1.08in;*/
			/*			margin-right: 1cm;*/
			/*margin-right: 0.89in;*/

		}

		body {
			margin: 0mm;
			margin-top: 0.75cm;
			margin-bottom: 0mm;
			margin-left: 1cm;
			/*margin-left: 1.08in;*/
			margin-right: 1cm;
			/*margin-right: 0.89in;*/
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
	<title>Memorandum</title>
</head>

<body>
	<div style="height:1.04in">
		<img src="<?= base_url() ?>/gambar/img/logo/LogoPetro-.png" alt="" style="width:200px">
		<img src="<?= base_url() ?>/gambar/img/logo/logo_digilab.png" alt="" style="width:200px;margin-left: 500px;">
	</div>
	<p style="font-size:1.75rem;font-family:Arial, Helvetica, sans-serif;text-align:center;margin:0cm">Service Order</p> <!-- <h2> -->
	<p style="font-family:Arial, Helvetica, sans-serif;text-align:center">Nomor : <?php if ($sample) echo $sample['transaksi_nomor'] ?></p> <!-- <h2> -->
	<!-- </h2> -->
	<table width="90%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td width="25%">Dari</td>
			<td width="5%">:</td>
			<td><?php if ($sample) echo $sample['title_approver'] ?></td>
		</tr>
		<tr>
			<td width="25%">Kepada</td>
			<td width="5%">:</td>
			<td><?php if ($sample) echo $sample['title_tujuan'] ?></td>
		</tr>
		<tr>
			<td width="25%">Perihal</td>
			<td width="5%">:</td>
			<td><?php if ($sample) echo $sample['transaksi_judul'] ?></td>
		</tr>
		<tr>
			<td width="25%">Tanggal</td>
			<td width="5%">:</td>
			<td><?php if ($sample) echo date_indo(date('Y-m-d', strtotime($sample['transaksi_tgl']))) ?></td>
		</tr>
		<tr>
			<td width="25%">Lampiran</td>
			<td width="5%">:</td>
			<?php
			$total = 0;
			if ($sample) {
				$sql = $this->db->query("select count(transaksi_detail_file) as total_file,count(transaksi_detail_attach) as total_attach from sample.sample_transaksi_detail where transaksi_id = '" . $sample['transaksi_id'] . "' AND transaksi_detail_status = '" . $sample['transaksi_status'] . "'");
				$data = $sql->row_array();
				$total = $data['total_attach'] + $data['total_file'];
			}
			?>
			<td><?php if ($sample) echo $total ?> (<?php echo ($total > 0) ? angkaHuruf($total) : '-'; ?>) Berkas</td>
		</tr>
	</table>
	<hr style="border: 1px solid black; width:90%;" align="left">
	<table width="90%" border="0" cellpadding="2" cellspacing="2">
		<tr>
			<td>Bersama dengan surat ini, kami bermaksud untuk melakukan permohonan Pengajuan Sample (Service Order). Berikut ini adalah data Sample yang kami ajukan : </td>
		</tr>
	</table>
	<table width="90%" border="1" cellpadding="2" cellspacing="2" style="border:1px solid black;border-collapse:collapse;border-radius:20cm;text-align:center">
		<tr style="background-color:gray">
			<th>No Urut</th>
			<th>Jenis Sample</th>
			<th>Jenis Pekerjaan</th>
			<th>Jumlah Sample</th>
			<th>Identitas Sample</th>
			<th>Deskripsi Parameter</th>
		</tr>
		<?php foreach ($sample_detail as $key => $detail) : ?>
			<tr>
				<td><?= $key + 1 ?></td>
				<td><?= $detail['jenis_nama'] ?></td>
				<td><?= $detail['sample_pekerjaan_nama'] ?></td>
				<td><?= $detail['transaksi_detail_jumlah'] ?></td>
				<td><?= $detail['transaksi_detail_identitas'] ?></td>
				<td><?= $detail['transaksi_detail_deskripsi_parameter'] ?></td>
			</tr>
		<?php endforeach; ?>
	</table>
	<br /><br />
	<?php
	$elements = array();
	foreach ($sample_detail as $detail_catatan) {
		$elements[] = $detail_catatan['transaksi_detail_catatan'];
	}
	?>
	Catatan : <br>
	<?php echo implode('<br>', $elements); ?>
	<br><br>
	Demikian atas bantuan dan kerjasama yang baik, kami ucapkan terima kasih
	<br /><br>
	<table width="90%" border="0" cellpadding="2" cellspacing="2">
		<tr>
			<th><?php if ($sample) echo $sample['title_approver'] ?></th>
		</tr>
		<tr>
			<td style="height: 2cm;"></td>
		</tr>
		<tr>
			<td>
				<?php
				if ($sample) {
					$str = $sample['nama_approver'];
					$strx = (explode(",", $str));
					echo $namaku = $strx[0];
				}
				?>
			</td>
		</tr>
	</table>
</body>

<footer>
	<img src="<?= base_url() ?>/gambar/img/logo/logoFooter.png" style="width:-webkit-fill-available">
</footer>

</html>



<script>
	window.print();
	// window.onfocus = setTimeout(() => {
	// window.close()
	// }, 2000);
</script>