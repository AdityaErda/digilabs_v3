<!DOCTYPE html>
<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Cetak</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="<?= base_url() ?>assets/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <style type="text/css">
        @page {
            size: A4;
            margin: 0.1;
        }

        @media print {

            html,
            body {
                width: 100%;
                height: 100%;
            }
        }

        table th {
            text-align: left;
        }
    </style>
</head>

<body>

    <div id="cetakan">
        <table style="border-collapse: collapse;" border="1" width="100%" class="tabel tabel-berwarna">
            <tbody>
                <tr>
                    <td>Identitas</td>
                    <td>Identitas 1</td>
                </tr>
            </tbody>
            <?php foreach ($template_detail as $key_td => $val_td) : ?>
                <?php $list_rumus = $this->M_perhitungan_sample->getListRumus(array('id_rumus' => $val_td['rumus_id'])); ?>
                <tbody>
                    <tr>
                        <td>Rumus</td>
                        <td><?= $val_td['rumus_nama'] ?></td>
                        <td></td>
                        <td>Metoda</td>
                        <td><?= $val_td['metode'] ?></td>
                    </tr>
                </tbody>
                <tbody>
                    <tr>
                        <td>Satuan</td>
                        <td><?= $val_td['satuan_sample'] ?></td>
                    </tr>
                </tbody>
                <tbody>
                    <?php $detail_rumus = $this->M_perhitungan_sample->getDetailRumusSampleTemplate(array('id_rumus' => $val_td['rumus_id'])); ?>
                    <tr style=" background-color:lightgreen">
                        <td class="table-head">No</td>
                        <?php foreach ($detail_rumus as $key_dr => $val_dr) : ?>
                            <td class="table-head"><?= $val_dr['rumus_detail_nama']; ?></td>
                        <?php endforeach; ?>
                        <td class="table-head">Hasil</td>
                        <td class="table-head">Rerata</td>
                    </tr>
                </tbody>
                <?php for ($x = 1; $x <= 2; $x++) {  ?>
                    <tbody>
                        <tr>
                            <td><?= $i ?></td>
                            <?php foreach ($detail_rumus as $key_dr => $val_dr) :
                                $bg = '';
                                if ($val_dr['rumus_detail_input'] != null) {
                                    $bg = 'yellow';
                                } ?>
                                <td style="background-color:<?= $bg ?>"><?php echo ($val_dr['rumus_detail_input'] != null) ? $val_dr['rumus_detail_input'] : '' ?></td>
                            <?php endforeach; ?>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                <?php } ?>
            <?php endforeach ?>
        </table>
    </div>
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<!-- <script src="<?= base_url() ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script> -->
<script src="<?= base_url('assets_tambahan/jquery-table2excel/dist/jquery.table2excel.js') ?>"></script>

<script>
    function excel() {
        // var table = $(this).prev('.tabel');
        // if (table) {
        // var preserveColors = (table.hasClass('tabel-berwarna') ? true : false);
        // console.log(preserveColors);
        $('.tabel').table2excel({
            exclude: ".noExl",
            name: "tabel",
            filename: "Template Multiple - <?= $template['template_logsheet_nama'] ?>",
            fileext: ".xls",
            exclude_img: true,
            exclude_links: true,
            exclude_inputs: true,
            preserveColors: true
        });
        // }
    }
    setTimeout(() => {
        excel();
    }, 500);

    setTimeout(() => {
        window.close();
    }, 1500);
</script>