<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Cetak Sertifikat</title>
	<link rel="stylesheet" href="">
</head>

<body>
	<table border="1" width="100%" style="border:1px solid black;border-collapse:collapse">
		<tr>
			<th>SERTIFIKAT PENGUJIAN
				<br>
				<hr>
				<br>
				No : <? //= $inbox_detail[0]['transaksi_detail_nomor_sample'] 
							?>
			</th>
		</tr>
	</table>
	<br>
	<table border="0" width="100%">
		<tr>
			<td width="30%">No Lab</td>
			<td><?= $logsheet_detail[0]['logsheet_nolab'] ?></td>
		</tr>
		<tr>
			<td>Nama Bahan</td>
			<td><?= $logsheet_detail[0]['logsheet_jenis_nama'] ?></td>
		</tr>
		<tr>
			<td>Peminta Jasa</td>
			<td><?= $inbox['peminta_jasa_nama'] ?></td>
		</tr>
		<tr>
			<td>Tanggal Sampling / Waktu</td>
			<td><?= $logsheet_detail[0]['logsheet_tgl_sampling'] . '/' . $logsheet_detail[0]['logsheet_jam_sampling'] ?></td>
		</tr>
		<tr>
			<td>Tanggal Pengujian</td>
			<td><?= $logsheet_detail[0]['logsheet_tgl_terima'] ?></td>
		</tr>
		<tr>
			<td>Pengambilan Contoh Oleh</td>
			<td><?= $logsheet_detail[0]['who_create'] ?></td>
		</tr>
		<tr>
			<td>Keterangan Contoh</td>
			<td><?= $inbox_detail[0]['transaksi_detail_deskripsi_parameter'] ?></td>
		</tr>
	</table>

	<table border="1" width="100%" style="border:1px solid black;border-collapse:collapse">
		<thead>
			<tr>
				<th>Jenis Uji</th>
				<th>Unit</th>
				<th>Spesifikasi Hasil Uji</th>
				<th>Metoda </th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($logsheet_detail as $key => $value) : ?>
				<tr>
					<td><?= $value['logsheet_detail_nama'] ?></td>
					<td><?= $value['logsheet_detail_unit'] ?></td>
					<td><?= $value['logsheet_detail_hasil_akhir'] ?></td>
					<td><?= $value['logsheet_detail_metoda'] ?></td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
	Catatan : jangan dicampur dengan produk dari produsen lain untuk tujuan ketertelusuran produk.
	<br>
	Diterbitkan Tanggal : <? //= date('d-m-y')
												?>
	<table border="0" width="100%">
		<tr>
			<td>
				PT Petrokimia Gresik
			</td>
			<td>
				<b>Adityo Dwiputra Sunarto, S.T. , M.Sc.</b>
				<br>
				Pgs VP Proses dan Pengendalian Kualitas
			</td>
		</tr>
		<tr>
			<td>
				<!-- PT Petrokimia Gresik -->
			</td>
			<td>
				<b>Anggi Arifin Nasution</b>
				<br>
				SMd I Evaluasi Proses Pabrik III
			</td>
		</tr>
		<tr>
			<td>
				<!-- PT Petrokimia Gresik -->
			</td>
			<td>
				<b>Bambang Ariwibowo . S.T., M.M.</b>
				<br>
				VP Proses & Pengendalian Kualitas
			</td>
		</tr>
		<tr>
			<td>
				<b>Adityo Dwiputra Sunarto, S.T. , M.Sc.</b>
				<br>
				VP Proses dan Pengendalian Kualitas
			</td>
			<td>
				<b>Ari Setyo Purnomo, S.Si.</b>
				<br>
				AVP Lab. Pabrik III
			</td>
		</tr>
	</table>
	Asli : VP. Administrasi & Penjualan
	<br>
	Tembusan : Bagian Sekretariat
	<br>
	sa/rsy
</body>

</html>