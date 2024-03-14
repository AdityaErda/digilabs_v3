<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Detail Material Request</title>
</head>
<body>
<h3>Detail Material Request</h3>
    <table style="border:1px solid black;border-collapse:collapse;" border="1px" width="100%">
        <thead>
            <tr>
                <th>Material</th>
                <th>Satuan</th>
                <th>Jumlah</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($isi as $value): ?>
                <?php 
                    // $jumlah = 0;
                 @$jumlah += $value['transaksi_detail_jumlah'];
                 @$total += $value['transaksi_detail_total']
                ?>
            <tr>
                <td><?=$value['item_nama']?></td>
                <td><?=$value['item_satuan']?></td>
                <td><?=number_format($value['transaksi_detail_jumlah'],0,',','.');?></td>
                <td>Rp. <?=number_format($value['transaksi_detail_total'],2,',','.');?></td>
            </tr>
            <?php endforeach;?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2">Total</th>
                <td><?=$jumlah?></td>
                <td>Rp. <?=number_format($total,2,',','.');?></td>
            </tr>
        </tfoot>
        
    </table>
</body>
</html>
<script>
    window.print();
</script>