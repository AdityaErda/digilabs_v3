<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Print Report Tahunan</title>
	<link rel="stylesheet" href="">
</head>
<script>
	window.print();
	window.onfocus = setTimeout(() => {
		window.close();
	}, 2000);
</script>

<body>

	<body>
		<H3>Print Report Tahunan</H3>
		<table width="100%" border="1">
			<thead>
				<tr>
					<th>Material</th>
					<th>Stok Masuk</th>
					<th>Stok Keluar</th>
					<th>Satuan</th>
					<th>Stok</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($data as $key => $value) :  ?>
					<tr>
						<td><?= $value['item_nama'] ?></td>
						<td><?= ($value['stok_masuk'] == null) ? '0' : $value['stok_masuk'] ?></td>
						<td><?= ($value['stok_keluar'] == null) ? '0' : $value['stok_keluar'] ?></td>
						<td><?= $value['item_satuan'] ?></td>
						<td><?= $value['item_stok'] ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</body>

</html>