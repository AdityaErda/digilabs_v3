<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sertifikat Pengujian</title>

    <style>
        .center {
            margin-left: auto;
            margin-right: auto;
        }

        body {
            font-size: 11pt;
            font-family: Arial;
            size: A4;
            margin-top: 0mm;
            margin-bottom: 0mm;
            margin-left: 1.08in;
            margin-right: 0.89in;
        }

        footer {
            font-size: 11pt;
            font-family: Arial;
            color: #f00;
            text-align: center;
            /* position: fixed; */
        }

        @page {
            size: A4;
            margin-top: 0cm;
            margin-bottom: 0cm;
        }

        @media print {

            @page {
                margin: 3mm;
                margin-left: 1.08in;
                margin-right: 0.89in;

            }

            body {
                margin: 0mm;
                /* margin-left: 1.08in;
			margin-right: 0.89in; */
                /* margin-bottom: 0mm; */
                /* margin-left: 1.08in; */
                /* margin-right: 0.89in; */
            }

            footer {
                position: fixed;
                width: -webkit-fill-available;
                bottom: 0;
            }

            .content-block,
            p {
                page-break-inside: avoid;
            }
        }
    </style>
</head>


<body>
    <table border="0" width="100%">
        <tr>
            <td width="20%" rowspan="2">
                <center><img src="https://storage.googleapis.com/pkg-portal-bucket/images/template/logo-PG-agro-trans-small.png" alt="" style="height: 60px;float:left;"></center>
            </td>
            <td width="80%">
                <center>
                    <b><label style="font-size: 1.5em;">LABORATORIUM PENGUJI</label></b><br>
                    <label style="font-size: 17px;">LP-076-IDN</label><br>
                </center>
            </td>
            <td width="20%" rowspan="2">
                <center>
                    <?php if ($logsheet['is_kan'] == 'y') : ?>
                        <img src="http://kan.or.id/images/kan.png" alt="" style="height: 47px;float:right;">
                    <?php endif ?>
                </center>
            </td>
        </tr>
    </table>
    <br>
    <p style="padding-left: 15mm;font-size: 11pt;">
        Gresik, <?php echo date_indo(date('Y-m-d')) ?>
        <br>
        Nomor :
    </p>
    <p style="text-align: center;">
        <span id="header-judul" style="font-size: 1.5em;font-weight: bold;">
            <u>LAPORAN HASIL UJI</u>
        </span>
        <br>
        <i>( Analysis Report )</i>
    </p>

    <!-- area identitas -->
    <p style="padding-left: 60px;font-size: 11pt;">
        <span><u>Nomor Lab</u></span>
        <span style="padding-left: 40mm;padding-right: 2mm;">:</span>
        <span><?php echo $inbox_detail[0]['transaksi_detail_nomor_sample'] ?></span>
        <br>
        <span style="font-size: 0.85em ;"><i>Lab Number</i></span>

        <br>

        <span><u>Jenis Contoh</u></span>
        <span style="padding-left: 36.5mm;padding-right: 2mm;">:</span>
        <span><?php echo $inbox_detail[0]['jenis_nama'] ?></span>
        <br>
        <span style="font-size: 0.85em ;"><i>Sample</i></span>

        <br>

        <span><u>Tgl. Penerima Contoh</u></span>
        <span style="padding-left: 21.5mm;padding-right: 2mm;">:</span>
        <span><?php echo date_indo(date('Y-m-d', strtotime($logsheet['logsheet_tgl_terima']))) ?></span>
        <br>
        <span style="font-size: 0.85em ;"><i>Sample Date</i></span>

        <br>

        <span><u>Tgl. Pengambilan</u></span>
        <span style="padding-left: 29mm;padding-right: 2mm;">:</span>
        <span><?php echo date_indo(date('Y-m-d', strtotime($logsheet['logsheet_tgl_uji']))) ?></span>
        <br>
        <span style="font-size: 0.85em ;"><i>Sample Date</i></span>

        <br>

        <span><u>Tempat Pengambilan</u></span>
        <span style="padding-left: 23mm;padding-right: 2mm;">:</span>
        <span><?php echo $logsheet['logsheet_asal_sample'] ?></span>
        <br>
        <span style="font-size: 0.85em ;"><i>Sample Take</i></span>

        <br>

        <span><u>Pengambilan Contoh</u></span>
        <span style="padding-left: 23mm;padding-right: 2mm;">:</span>
        <span><?php echo $logsheet['logsheet_pengolah_sample'] ?></span>
        <br>
        <span style="font-size: 0.85em ;"><i>Sample Take By</i></span>

        <br>

        <span><u>Peminta</u></span>
        <span style="padding-left: 45mm;padding-right: 2mm;">:</span>
        <span><?php echo $logsheet['logsheet_peminta_jasa'] ?></span>
        <br>
        <span style="font-size: 0.85em ;"><i>Requested By</i></span>

        <br>

        <span><u>Referensi</u></span>
        <span style="padding-left: 43mm;padding-right: 2mm;">:</span>
        <span><?php echo $logsheet['logsheet_peminta_jasa'] ?></span>
        <br>
        <span style="font-size: 0.85em ;"><i>Reference</i></span>
        <span style="padding-left: 49mm;"> <?= $logsheet['logsheet_nomor_permintaan'] ?> </span>

    </p>
    <br>
    <!-- area identitas -->

    <p style="text-align: center;">
        <span id="header-judul" style="font-size: 1.5em;font-weight: bold;">
            <u>HASIL PENGUJIAN</u>
        </span>
        <br>
    </p>
    <br>

    <center>
        <table class="MsoTableGrid" border="1" cellspacing="0" cellpadding="0" width="480" style="border-collapse: collapse; border: none; height: 51px;">
            <thead>
                <tr>
                    <th>
                        <u>
                            No
                        </u>
                        <br>
                        <i style="font-size: 0.85em;">No</i>
                    </th>
                    <th>
                        <u>Jenis Uji</u>
                        <br>
                        <i style="font-size: 0.85em;">Item of Analysis</i>
                    </th>
                    <th><u>Satuan</u>
                        <br>
                        <i style="font-size:0.85em">Unit</i>
                    </th>
                    <th><u>Hasil Uji</u>
                        <br>
                        <i style="font-size:0.85em">Analysis Result</i>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($detail_logsheet as $key => $value) :
                    $sql_konten = $this->db->query("SELECT * FROM sample.sample_logsheet a LEFT JOIN sample.sample_logsheet_detail b ON a.logsheet_id = b.logsheet_id LEFT JOIN sample.sample_perhitungan_sample c ON c.rumus_id = b.id_rumus WHERE id_transaksi = '" . $_GET['transaksi_id'] . "' AND a.logsheet_id = '" . $_GET['logsheet_id'] . "' AND b.id_rumus = '" . $value['rumus_id'] . "'");

                    $data_konten = $sql_konten->result_array();

                    $sql_avg = $this->db->query("SELECT DISTINCT logsheet_jenis_unit,rumus_avg,logsheet_metoda FROM sample.sample_logsheet a LEFT JOIN sample.sample_logsheet_detail b ON a.logsheet_id = b.logsheet_id LEFT JOIN sample.sample_perhitungan_sample c ON c.rumus_id = b.id_rumus WHERE id_transaksi = '" . $_GET['transaksi_id'] . "' AND a.logsheet_id = '" . $_GET['logsheet_id'] . "' AND b.id_rumus = '" . $value['rumus_id'] . "' AND rumus_avg is NOT NULL");

                    $data_avg = $sql_avg->result_array();

                    foreach ($data_konten as $key_konten => $value_konten) :
                        if ($value_konten['rumus_avg'] == '') :
                ?>
                            <tr>
                                <td><?= $key + 1 ?></td>
                                <td><?= $value['rumus_nama'] ?></td>
                                <td><?= $value_konten['rumus_satuan'] ?></td>
                                <td><?= $value_konten['rumus_hasil'] ?></td>
                                <!-- <td><?= $value_konten['rumus_metoda'] ?></td> -->
                            </tr>
                        <?php
                        endif;
                    endforeach;
                    foreach ($data_avg as $key_avg => $value_avg) :
                        if ($value_konten['rumus_avg'] != '') :
                        ?>
                            <tr>
                                <td><?= $key + 1 ?></td>
                                <td><?= $value['rumus_nama'] ?></td>
                                <td><?= $value_avg['rumus_satuan'] ?></td>
                                <td><?= $value_avg['rumus_avg'] ?></td>
                                <!-- <td><?= $value_avg['rumus_metoda'] ?></td> -->
                            </tr>

                <?php
                        endif;
                    endforeach;
                endforeach;
                ?>
            </tbody>
        </table>
    </center>
    <br>
    <br>

    <p style="padding-left: 15mm;font-size: 11pt;">
        <span>PT Petrokimia Gresik</span>
        <br>
    <p style="height: 15mm;">

    </p>
    <span style="padding-left: 15mm;">
        <u>
            <b>
                <?php
                $str = $inbox['nama_tujuan'];
                $strx = (explode(",", $str));
                echo $namaku = $strx[0];
                ?>
            </b>
        </u>
    </span>
    <br>
    <span style="padding-left: 15mm;font-size:12pt"><?= $inbox['title_tujuan'] ?></span>
    </p>
    <br>
    <br>
    <p>
        <?php
        if (!empty($logsheet['id_template_footer'])) {
            $template_footer = explode(',', $logsheet['id_template_footer']);
            foreach ($template_footer as $key_footer => $footer_template) {
                $sql_footer = $this->db->query("SELECT * FROM sample.sample_footer_sertifikat WHERE footer_id = '" . $footer_template . "'");
                $data_footer = $sql_footer->row_array();
        ?>
    <div style="text-align: right;padding-right: 10mm;">
        <i>
            <?php echo $data_footer['footer_isi']; ?>

        </i>
    </div>
<?php
            }
        }
?>
</p>
<br>
<p style="font-size: 9pt;">
    Sesuai dengan ketentuan peraturan perundang-undangan yang berlaku, surat ini telah ditandatangani secara elektronik oleh Perum Peruri
    yang tersertifikasi sebagai Penyelenggara Sertifikasi Elektronik (PSrE) sehingga tidak diperlukan tanda tangan dan stempel basah.
</p>
<br>
<footer>
    <img src="<?= base_url() ?>/gambar/img/logo/logoFooterAlamat.png" style="width:-webkit-fill-available">
</footer>

</body>

</html>

<script>
    window.print();
    // window.onfocus = setTimeout(() => {
    // window.close()
    // }, 2000);
</script>