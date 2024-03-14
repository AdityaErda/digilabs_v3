<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Print Report Bulanan</title>

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
<H3>Print Report Bulanan</H3>
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