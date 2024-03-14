<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>QR-Code</title>
		<link rel="stylesheet" href="">
		<style>
			table {
				border-collapse: collapse;
				float: left;
			}

			label {
				font-size: 11px;
			}

			.isi {
				font-size: 13px;
				font-weight: bold;
			}
		</style>
	</head>
	<?php		
    $sql = $this->db->query("SELECT * FROM material.material_item WHERE item_id = '".$_GET['id_qr']."'");
    $isi = $sql->row_array();
	?>
	<body onload="window.print()">
		<?php for ($i = 0; $i < $_GET['jumlah_qr']; $i++) : ?>
			<table width="33%" border="1">
				<tr>
					<td>
						<table width="100%">
							<tr>
								<td>
									<img src="<?php echo base_url('img/' . $item_id . '.png'); ?>" style="width: 20mm;">
								</td>
								<td>
									<label>Tanggal Kedatangan</label><br>
									<label class="isi"><?= date('d-m-Y') ?></label><br>
									<label>Tanggal Kadaluarsa</label><br>
									<label class="isi"><?= date('d-m-Y') ?></label>
								</td>
							</tr>
							<tr>
								<td colspan="2"><label><?= $isi['item_nama'] ?></label></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		<?php endfor ?>
	</body>
</html>