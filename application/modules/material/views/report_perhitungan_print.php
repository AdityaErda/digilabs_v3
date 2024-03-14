<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Print Report Perhitungan</title>
	<link rel="stylesheet" href="">
</head>

<style>
	@media print {
		body {
			display: table;
			table-layout: fixed;
			padding-top: 1.5cm;
			padding-bottom: 2.5cm;
			height: auto;
			position: relative;
		}

		#footer {
			position: absolute;
			bottom: 0;
		}
	}
</style>

<body onload="window.print()">
	<H3>Print Report Perhitungan</H3>
	<table width="100%" border="1" style="border-collapse:collapse;border:1px solid black" id="tbl">
		<thead>
			<tr>
				<th>No</th>
				<th>Tanggal</th>
				<th>Customer</th>
				<th>Material</th>
				<th>Satuan</th>
				<th>Jumlah</th>
				<th>Harga</th>
				<th>Total</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($isi as $key => $value) : ?>

				<?php
				// $grandTotal = 0;
				@$grandTotal += $value['transaksi_total'];
				?>
				<tr>
					<td><?= $key + 1 ?></td>
					<td><?= $value['transaksi_waktu'] ?></td>
					<td><?= $value['seksi_nama'] ?></td>
					<td><?= $value['item_nama'] ?></td>
					<td><?= $value['item_satuan'] ?></td>
					<td><?= $value['transaksi_detail_jumlah'] ?></td>
					<?php $harga_item = (preg_replace('/[^0-9]/', '', $value['item_harga'])); ?>
					<td style="text-align:right">Rp. <?= number_format($harga_item, 0, ',', '.'); ?></td>
					<td style="text-align:right">Rp. <?= number_format($value['transaksi_detail_total'], 2, ',', '.'); ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="7" align="right">Grand Total</td>
				<td style="text-align:right">Rp. <?= number_format(@$grandTotal, 2, ',', '.') ?></td>
			</tr>
		</tfoot>
	</table>
</body>

</html>

<script>
	var tbl = document.getElementById('tbl');
	var foot = tbl.getElementsByTagName('tfoot')[0];
	foot.style.display = 'table-row-group';
	tbl.removeChild(foot);
	tbl.appendChild(foot);
</script>