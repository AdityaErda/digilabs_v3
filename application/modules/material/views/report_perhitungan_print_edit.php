<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Print Report Perhitungan</title>

    <!-- tambahan -->
    <script src="<?= base_url() ?>assets/plugins/jquery/jquery.min.js"></script>
    <script src="<?= base_url() ?>assets_tambahan/tinymce/tinymce.min.js"></script>
    <!-- tambahan -->

    <style type="text/css">
        @page {
            size: A4;
            margin: 0;
        }

        @media print {
            @page {
                margin: 0cm;
            }

            body {
                margin: 1cm;
            }
        }

        body {
            orientation: potrait;
            margin: 1cm;
            width: 210mm;
            /* height: 297mm; */
        }

        .isiText {
            font-family: Arial;
            font-size: 11pt;
        }

        .table {
            border: 1px solid black;
            border-collapse: collapse
        }
    </style>

</head>

<textarea name="cetak" id="cetak">
<body>
<H3>Print Report Perhitungan</H3>
	<table width="100%" border="1" style="border-collapse:collapse;border:1px solid black" id="tbl">
		<thead>
			<tr>
				<th>No</th>
				<th>Tanggal</th>
				<th>Customer</th>
				<th>Material</th>
				<th>Satuan</th>
				<th>Jumlah</th>
				<th>Harga</th>
				<th>Total</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($isi as $key => $value) : ?>

				<?php
                // $grandTotal = 0;
                @$grandTotal += $value['transaksi_total'];
                ?>
				<tr>
					<td><?= $key + 1 ?></td>
					<td><?= $value['transaksi_waktu'] ?></td>
					<td><?= $value['seksi_nama'] ?></td>
					<td><?= $value['item_nama'] ?></td>
					<td><?= $value['item_satuan'] ?></td>
					<td><?= $value['transaksi_detail_jumlah'] ?></td>
					<?php $harga_item = (preg_replace('/[^0-9]/', '', $value['item_harga'])); ?>
					<td style="text-align:right">Rp. <?= number_format($harga_item, 0, ',', '.'); ?></td>
					<td style="text-align:right">Rp. <?= number_format($value['transaksi_detail_total'], 2, ',', '.'); ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="7" align="right">Grand Total</td>
				<td style="text-align:right">Rp. <?= number_format(@$grandTotal, 2, ',', '.') ?></td>
			</tr>
		</tfoot>
	</table>
</body>
</textarea>

</html>
<script>
    // window.print();
</script>

<script>
    $(function() {
        tinymce.init({
            selector: "textarea#cetak",
            // height: 300,
            plugins: [
                "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                "save table contextmenu directionality emoticons template paste textcolor",
                "autoresize"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",
        });
    })
</script>