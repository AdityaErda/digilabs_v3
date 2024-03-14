<!DOCTYPE html>
<html lang="en">
<style>
	.center {
  margin-left: auto;
  margin-right: auto;
}
body{
	font-size:18px;
}
</style>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Memorandum</title>
</head>
<body>
	<div>
		<img src="<?=base_url()?>/gambar/img/logo/logo_digilab.png" alt="" style="width:200px">
	</div>
	<h2><center>Memorandum</center></h2>
	<h2><center>Nomor : </center></h2>
	<table width="70%" border="0" class="center" cellpadding="2" cellspacing="2">
		<tr>
			<td width="25%">Kepada</td>
			<td width="5%">:</td>
			<td><?=$keterangan['keterangan_tujuan']?></td>
		</tr>
		<tr>
			<td width="25%">Dari</td>
			<td width="5%">:</td>
			<td><?=$keterangan['keterangan_asal']?></td>
		</tr>
		<tr>
			<td width="25%">Perihal</td>
			<td width="5%">:</td>
			<td><?=$keterangan['transaksi_keterangan_perihal']?></td>
		</tr>
		<tr>
			<td width="25%">Tanggal</td>
			<td width="5%">:</td>
			<td><?=$keterangan['transaksi_keterangan_tanggal']?></td>
		</tr>
		<tr>
			<td width="25%">Lampiran</td>
			<td width="5%">:</td>
			<td><?=$keterangan['transaksi_keterangan_file']?></td>
		</tr>
	</table>
	<hr style="border: 1px solid black; width:70%;">
	<table class="center">
		<tr>
			<td><?=$keterangan['transaksi_keterangan_isi']?></td>
		</tr>
	</table>
</body>
</html>