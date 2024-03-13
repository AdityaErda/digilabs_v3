<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Print Kaji Ulang</title>

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
<H3>Kaji Ulang</H3>
		<table width="100%" border="1" style="border-collapse:collapse">
			<thead>
				<tr>
				<th width="30%">Judul Document</th>
				<th width="15%">Jenis Document</th>
				<th width="10%">Tanggal Pengesahan</th>
				<th width="10%">Nomor Document</th>
				<th>Keterangan</th>
				<th>Revisi</th>
				<th>Terbitan</th>
				<th width="20%">File</th>
				<!-- <th>Status</th> -->

				</tr>
			</thead>
			<tbody>
				<?php foreach ($isi as $value) : ?>
				<tr>
				<td><?= $value['transaksi_judul_document']; ?></td>
				<td><?= $value['jenis_nama']; ?></td>
				<td><?= $value['transaksi_tgl_pengesahan']; ?></td>
				<td><?= $value['transaksi_nomor_document']; ?></td>
				<td><?= $value['transaksi_tipenya']; ?></td>
				<td align="center"><?= $value['transaksi_revisi']; ?></td>
				<td align="center"><?= $value['transaksi_terbitan']; ?></td>
				
				<?php $result = preg_replace("/[^a-zA-Z\s]/", "", $value['transaksi_filenya']); ?>
				<td><?= $value['transaksi_filenya']; ?></td>
				<!-- <td><? //= $value['transaksi_statusnya'];
                            ?></td> -->
				</tr>
				<?php endforeach ?>
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