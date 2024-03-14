<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<body>
	<form action="<?=base_url('sample/fk_sample')?>" method="GET" id="form">
		<label for="">Tipe</label>
		<select name="transaksi_tipe" id="transaksi_tipe" onChange="ganti_tipe(this.value)">
			<option <?php if($this->input->get('transaksi_tipe')=='I') echo 'selected' ?> value="I">Internal</option>
			<option <?php if($this->input->get('transaksi_tipe')=='E') echo 'selected' ?> value="E">External</option>
			<option <?php if($this->input->get('transaksi_tipe')=='R') echo 'selected' ?> value="R">Rutin</option>
		</select>
		<?php if($this->input->get('transaksi_tipe')!='R'): ?>
			<label for="">Status</label>
			<select name="transaksi_status" id="transaksi_status">
				<option <?php if($this->input->get('transaksi_status')=='0') echo 'selected' ?> value="0">Belum Approve</option>
				<option <?php if($this->input->get('transaksi_status')=='1') echo 'selected' ?> value="1">Suda Approve</option>
				<option <?php if($this->input->get('transaksi_status')=='2') echo 'selected' ?> value="2">Belum Diterima</option>
				<option <?php if($this->input->get('transaksi_status')=='3') echo 'selected' ?> value="3">9=tunda,3=diterima</option>
				<option <?php if($this->input->get('transaksi_status')=='4') echo 'selected' ?> value="4">9=tunda,4=inprogres</option>
				<option <?php if($this->input->get('transaksi_status')=='5') echo 'selected' ?>  value="5">sertifikat</option>
				<option <?php if($this->input->get('transaksi_status')=='6') echo 'selected' ?> value="6">close</option>
				<option <?php if($this->input->get('transaksi_status')=='7') echo 'selected' ?> value="7">ganti perencana</option>
				<option <?php if($this->input->get('transaksi_status')=='8') echo 'selected' ?> value="8">reject</option>
			</select>
		<?php else: ?>
			<label for="">Status Rutin</label>
			<select name="transaksi_status" id="transaksi_status">
				<option <?php if($this->input->get('transaksi_status')=='0') echo 'selected' ?> value="0">On Progress</option>
				<option <?php if($this->input->get('transaksi_status')=='6') echo 'selected' ?> value="6">close</option>
			</select>
		<?php endif;?>
		<label for="">Status Detail</label>
		<select name="transaksi_detail_status" id="transaksi_detail_status">
			<option value="-"></option>
			<option <?php if($this->input->get('transaksi_detail_status')=='9') echo 'selected' ?>  value="9">9=Tunda</option>
			<option <?php if($this->input->get('transaksi_detail_status')=='3') echo 'selected' ?> value="3">3=diterima</option>
			<option <?php if($this->input->get('transaksi_detail_status')=='4') echo 'selected' ?> value="4">4=In progres</option>
		</select>
		<input type="submit" value="Filter">
		<input type="button" name="fk" id="fk" value="FK">
	</form>

	<?php
	if($this->input->get('transaksi_status')){
		if($sample){
			?>
			<table border="1" style="100%">
				<thead>
					<tr>
						<td>
							Tipe
						</td>
						<td>
							id trans
						</td>
						<td>
							Status
						</td>
						<td>
							id trans Detail
						</td>
						<td>
							Status Detail
						</td>
						<td>
							Proses
						</td>
					</tr>
				</thead>
				<?php
				foreach ($sample as $key => $value) {
					?>
					<tbody>
						<tr>
							<td><?= $value['transaksi_tipe'] ?></td>
							<td><?= $value['transaksi_id'] ?></td>
							<td><?= $value['transaksi_status'] ?></td>
							<td><?= $value['transaksi_detail_id'] ?></td>
							<td><?= $value['transaksi_detail_status'] ?></td>
							<td><?= $value['is_proses'] ?></td>
						</tr>
					</tbody>
					<?php
				}
				?>
			</table>
			<?php
		}
	}
	?>

</body>
</html>

<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

<script>
	function ganti_tipe(val){
		window.location = '<?=base_url('sample/fk_sample?transaksi_tipe=')?>'+val;
	}

	$('#fk').on('click',function(){
		var url = '';
		if($("#transaksi_tipe").val()!='R'){
			var url = '<?=base_url('sample/fk_sample/fk')?>'
		}else{
			var url = '<?=base_url('sample/fk_sample/fk_rutin')?>'	
		}
		$.ajax({
			url: url,
			type: 'GET',
			dataType: 'HTML',
			data: $('#form').serialize(),
			success:function(result){

			}
		})		
	})
</script>