<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Print Laporan Sertifikasi Document</title>
		<link rel="stylesheet" href="">
	</head>
	<body onload="window.print()">
		<H3>Print Laporan Sertifikasi Document</H3>
		<table border="1" style="border-collapse:collapse;border:1px solid black" width="100%">
            <thead>
                <tr>
                <th>No</th>
                <th width="10%">Tgl Terbit</th>
                <th>Tgl Expired</th>
                <th>Material</th>
                <th>Batch</th>
                <th>Judul</th>
                <th width="10%">File</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($isi as $key=>$value): ?>
                <tr>
                    <td><?=$key+1?></td>
                    <td><?=date('d-m-Y',strtotime($value['batch_file_tgl_terbit']))?></td>
                    <td><?=date('d-m-Y',strtotime($value['batch_file_tgl_expired']))?></td>
                    <td><?=$value['item_nama']?></td>
                    <td><?=$value['list_batch_kode_final']?></td>
                    <td><?=$value['batch_file_judul']?></td>
                    <td><?=$value['batch_file_isi']?></td>
                </tr>
                
                <?php endforeach; ?>
            </tbody>
        </table>
	</body>
</html>