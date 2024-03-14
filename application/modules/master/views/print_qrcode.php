<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>QR-Code</title>
	<style>
		table {
			border-collapse: collapse;
			border: 0px solid gray;
			width: calc(50% - 10px);
			float: left;
			margin: 5px;
		}

		p {
			margin: 0px;
			font-size: 11px;
			font-weight: bolder;
		}
	</style>
</head>

<body onload="window.print()">
	<table width="100%">
		<tr>
			<td height="100%" width="50%" align="left">
				<img src="<?= base_url('img/' . $aset_nomor . '.png'); ?>" alt="" width="50%" class="center" style="margin-left: -12px;"><br>
				<p><?= $aset_nomor ?></p>
				<p><?= $aset_nomor_utama ?></p>
				<p><?= $aset_nama ?></p>
			</td>
		</tr>
	</table>
</body>

</html>