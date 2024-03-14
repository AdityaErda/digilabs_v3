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
    <table class="MsoTableGrid" border="0" cellspacing="0" cellpadding="0" width="480" style="border-collapse: collapse; border: none; height: 51px;">
        <p>
            <center>
                <b>
                    <span style="font-size: 16pt;">SERTIFIKAT PENGUJIAN</span>
                </b>
            </center>
            <center>
                <i>
                    <span>Nomor</span>
                </i>
            </center>
        </p>
        <br>

        <tbody>
            <tr>
                <td style="border:none;" width="250">
                    <p class="MsoNormal"><span lang="EN-US">Contoh</span></p>
                </td>
                <td style="border:none" width="10">
                    <p class="MsoNormal"><span lang="EN-US">:</span></p>
                </td>
                <td style="border:none">
                    <b>
                        <!-- <p class="MsoNormal"><span lang="EN-US"><?php echo $detail_group['jenis_nama'] ?></span></p> -->
                    </b>
                </td>
            </tr>
            <tr>
                <td style="border:none">
                    <p class="MsoNormal"><span lang="EN-US">Asal Contoh</span></p>
                </td>
                <td style="border:none">
                    <p class="MsoNormal"><span lang="EN-US">:</span></p>
                </td>
                <td style="border:none">
                    <b>
                        <!-- <p class="MsoNormal"><span lang="EN-US"><?= $logsheet_group['logsheet_asal_sample'] ?></span></p> -->
                    </b>
                </td>
            </tr>
            <tr>
                <td style="border:none">
                    <p class="MsoNormal"><span lang="EN-US">Pengambil Contoh</span></p>
                </td>
                <td style="border:none">
                    <p class="MsoNormal"><span lang="EN-US">:</span></p>
                </td>
                <td style="border:none">
                    <b>
                        <!-- <p class="MsoNormal"><span lang="EN-US"><?= $logsheet_group['logsheet_pengolah_sample'] ?></span></p> -->
                    </b>
                </td>
            </tr>
            <tr>
                <td style="border:none">
                    <p class="MsoNormal"><span lang="EN-US">Peminta Jasa</span></p>
                </td>
                <td style="border:none">
                    <p class="MsoNormal"><span lang="EN-US">:</span></p>
                </td>
                <td style="border:none">
                    <b>
                        <!-- <p class="MsoNormal"><span lang="EN-US"><?= $detail_group['peminta_jasa_nama'] ?></span></p> -->
                    </b>
                </td>
            </tr>
            <tr>
                <td style="border:none">
                    <p class="MsoNormal"><span lang="EN-US">Tanggal Pengambilan Contoh</span></p>
                </td>
                <td style="border:none">
                    <p class="MsoNormal"><span lang="EN-US">:</span></p>
                </td>
                <td style="border:none">
                    <b>
                        <!-- <p class="MsoNormal"><span lang="EN-US"><?php echo date_indo(date('Y-m-d', strtotime($logsheet_group['logsheet_tgl_terima']))) ?></span></p> -->
                    </b>
                </td>
            </tr>
            <tr>
                <td style="border:none">
                    <p class="MsoNormal"><span lang="EN-US">Tanggal Pengujian</span></p>
                </td>
                <td style="border:none">
                    <p class="MsoNormal"><span lang="EN-US">:</span></p>
                </td>
                <td style="border:none">
                    <b>
                        <!-- <p class="MsoNormal"><span lang="EN-US"><?php echo date_indo(date('Y-m-d', strtotime($logsheet_group['logsheet_tgl_uji']))) ?></span></p> -->
                    </b>
                </td>
            </tr>
        </tbody>
    </table>
    <br>

    <center>
        <table class="MsoTableGrid" border="1" cellspacing="0" cellpadding="0" width="90%" style="" ">
        <thead>
            <tr>
                <th>Nomor Lab</th>
                <th>Parameter Uji</th>
                <th>Satuan</th>
                <th>Hasil Uji</th>
                <th>Batasan</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        </table>
    </center>
    <br>

    <p class=" MsoNormal">
        Diterbitkan pada : <?php echo date_indo(date('Y-m-d')) ?>
    </p>
    <p class="MsoNormal">
        VP Proses & Pengendalian Kualitas
    </p>
    <p class="MsoNormal" style="height:2cm"></p>

    <p><u>ADITYO DWIPUTRA SUNARTO</u></p>
    VP Proses & Pengendalian Kualitas

</body>

</html>
<script>
    window.print();
</script>