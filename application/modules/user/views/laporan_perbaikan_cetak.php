<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Laporan Perbaikan</title>

		<style type="text/css" media="screen">
			table {
				border-color:#000000;
				border-collapse : collapse;
				border-style:solid;
			}
		</style>
	</head>
	<body onload="window.print()">
		<?php foreach ($perbaikan as $key => $value): ?>
			<p>Perbaikan <?= $key+1 ?></p>
			<table width="100%" border="1">
				<thead>
					<tr>
						<th width="15%">Tanggal Perbaikan</th>
						<th width="15%">Jenis Alber</th>
						<th width="15%">Kode Unit</th>
						<th width="15%">Driver</th>
						<th width="20%">Pekerjaan</th>
						<th width="20%">Detail Pekerjaan</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><?= $value['tanggal_perbaikan'] ?></td>
						<td><?= $value['jenis_nama'] ?></td>
						<td><?= $value['alber_no_plat'] ?></td>
						<td><?= $value['driver_nama'] ?></td>
						<td><?= $value['checklist_nama'] ?></td>
						<td><?= $value['detail_checklist_keterangan'] ?></td>
					</tr>
				</tbody>
			</table><br>
			<table border="1" width="100%">
				<thead>
					<tr>
						<th width="25%">No Material</th>
						<th width="25%">Nama Material</th>
						<th width="25%">Jumlah Material</th>
						<th width="25%">Spec Material</th>
					</tr>
				</thead>
				<tbody>
					<?php if ($material[$value['perbaikan_id']]): ?>
						<?php foreach ($material[$value['perbaikan_id']] as $val): ?>
							<tr>
								<td><?= $val['material_nomer'] ?></td>
								<td><?= $val['material_nama'] ?></td>
								<td><?= $val['material_jumlah'] ?></td>
								<td><?= $val['material_spesifikasi'] ?></td>
							</tr>
						<?php endforeach ?>
					<?php endif ?>
				</tbody>
			</table><br>
			<table border="1" width="100%">
				<thead>
					<tr>
						<th width="25%">Waktu</th>
						<th width="10%">Persen (%)</th>
						<th width="20%">Keterangan</th>
						<th width="45%">Teknisi</th>
					</tr>
				</thead>
				<tbody>
					<?php if ($detail[$value['perbaikan_id']]): ?>
						<?php foreach ($detail[$value['perbaikan_id']] as $val): ?>
							<tr>
								<td><?= $val['waktu_mulai'].' - '.$val['waktu_selesai'] ?></td>
								<td><?= $val['perbaikan_detail_progress'] ?></td>
								<td><?= $val['perbaikan_detail_keterangan'] ?></td>
								<td>
									<table width="100%" border="1">
										<thead>
											<tr>
												<th>Tipe Teknisi</th>
												<th>Nama Teknisi</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach ($teknisi[$val['perbaikan_detail_id']] as $v): ?>
												<tr>
													<td><?= $v['regu_nama'] ?></td>
													<td><?= $v['teknisi_nama'] ?></td>
												</tr>
											<?php endforeach ?>
										</tbody>
									</table>
								</td>
							</tr>
						<?php endforeach ?>
					<?php endif ?>
				</tbody>
			</table>
			<hr>
		<?php endforeach ?>
	</body>
</html>