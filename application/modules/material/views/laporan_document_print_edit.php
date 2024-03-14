<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Print Laporan Sertifikasi Document</title>

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
                <?php foreach ($isi as $key => $value) : ?>
                <tr>
                    <td><?= $key + 1 ?></td>
                    <td><?= date('d-m-Y', strtotime($value['batch_file_tgl_terbit'])) ?></td>
                    <td><?= date('d-m-Y', strtotime($value['batch_file_tgl_expired'])) ?></td>
                    <td><?= $value['item_nama'] ?></td>
                    <td><?= $value['list_batch_kode_final'] ?></td>
                    <td><?= $value['batch_file_judul'] ?></td>
                    <td><?= $value['batch_file_isi'] ?></td>
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