<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Print Kaji Ulang</title>
		<link rel="stylesheet" href="">
	</head>
	<body onload="window.print()">
		<H3>Kaji Ulang</H3>
		<table width="100%" border="1" style="border-collapse:collapse">
			<thead>
				<tr>
				<th width="30%">Judul Document</th>
				<th width="15%">Jenis Document</th>
				<th width="10%">Tanggal Pengesahan</th>
				<th width="10%">Nomor Document</th>
				<th>Keterangan</th>
				<th>Revisi</th>
				<th>Terbitan</th>
				<th width="20%">File</th>
				<!-- <th>Status</th> -->

				</tr>
			</thead>
			<tbody>
				<?php foreach($isi as $value): ?>
				<tr>
				<td><?= $value['transaksi_judul_document'];?></td>
				<td><?= $value['jenis_nama'];?></td>
				<td><?= $value['transaksi_tgl_pengesahan'];?></td>
				<td><?= $value['transaksi_nomor_document'];?></td>
				<td><?= $value['transaksi_tipenya'];?></td>
				<td align="center"><?= $value['transaksi_revisi'];?></td>
				<td align="center"><?= $value['transaksi_terbitan'];?></td>
				
				<?php $result = preg_replace("/[^a-zA-Z\s]/", "", $value['transaksi_filenya']); ?>
				<td><?=  $value['transaksi_filenya'];?></td>
				<!-- <td><?//= $value['transaksi_statusnya'];?></td> -->
				</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</body>
</html>