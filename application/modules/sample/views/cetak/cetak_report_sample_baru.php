<!-- Font Awesome -->
<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/fontawesome-free/css/all.min.css">
<!-- Font Awesome -->
<!-- overlayScrollbars -->
<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
<!-- overlayScrollbars -->
<!-- Theme style -->
<link rel="stylesheet" href="<?= base_url() ?>assets/dist/css/adminlte.min.css">
<!-- Theme style -->
<!-- Google Font: Source Sans Pro -->
<link href="<?= base_url() ?>assets_tambahan/googleapis/googleapis.css" rel="stylesheet">
<!-- Google Font: Source Sans Pro -->
<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<!-- DataTables -->
<!-- Toastr -->
<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/toastr/toastr.min.css">
<!-- Toastr -->
<!-- Select2 -->
<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<!-- Select2 -->
<!-- daterange picker -->
<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/daterangepicker/daterangepicker.css">
<!-- daterange picker -->


<!-- jQuery -->
<script src="<?= base_url() ?>assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url() ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Bootstrap 4 -->
<!-- overlayScrollbars -->
<script src="<?= base_url() ?>assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- overlayScrollbars -->
<!-- AdminLTE App -->
<script src="<?= base_url() ?>assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE App -->
<!-- AdminLTE for demo purposes -->
<script src="<?= base_url() ?>assets/dist/js/demo.js"></script>
<!-- AdminLTE for demo purposes -->
<!-- DataTables -->
<script src="<?= base_url() ?>assets/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script>
    $(function() {
        $("#example1").DataTable();
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": false,
            "ordering": false,
            "info": false,
            "autoWidth": false,
        });
    });
</script>
<!-- DataTables -->
<!-- Toastr -->
<script src="<?= base_url() ?>assets/plugins/toastr/toastr.min.js"></script>
<!-- Toastr -->

<link rel="stylesheet" href="https://printjs-4de6.kxcdn.com/print.min.css">
<script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
<!-- Select2 -->
<script src="<?= base_url() ?>assets/plugins/select2/js/select2.full.min.js"></script>
<!-- Select2 -->
<!-- InputMask -->
<script src="<?= base_url() ?>assets/plugins/moment/moment.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
<script type="text/javascript">
    $(function() {
        $('[data-mask]').inputmask()
    });
</script>
<!-- InputMask -->
<!-- date-range-picker -->
<script src="<?= base_url() ?>assets/plugins/daterangepicker/daterangepicker.js"></script>
<!-- date-range-picker -->
<!-- Bootstrap Switch -->
<script src="<?= base_url() ?>assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<script type="text/javascript">
    $(function() {
        $("input[data-bootstrap-switch]").each(function() {
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
        });
    });
</script>
<!-- Bootstrap Switch -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.0/dist/chart.min.js"></script>

<!-- jQuery Knob -->
<script src="<?= base_url() ?>assets/plugins/jquery-knob/jquery.knob.min.js"></script>


<!-- tambahan -->
<script src="<?= base_url() ?>assets/plugins/jquery/jquery.min.js"></script>
<script src="<?= base_url() ?>assets_tambahan/tinymce/tinymce.min.js"></script>
<!-- tambahan -->


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

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Print Report Sample</title>
</head>

<body id="print_report">
    <table border="0" width="90%">
        <tr>
            <td width="20%" rowspan="2">
                <center><img src="https://1.bp.blogspot.com/-hlefFvu4SZ8/UPvcAKxF3jI/AAAAAAAALzc/YdnYzEbtPkA/s1600/LOGO+PETROKIMIA+GRESIK.png" alt="" width="100px"></center>
            </td>
            <td width="80%">
                <center>
                    <b><label style="font-size: 25px;">LABORATORIUM PENGUJI</label></b><br>
                    <label style="font-size: 17px;">LP-076-IDN</label><br>
                </center>
            </td>
            <td width="20%" rowspan="2">
                <center><img src="<?php echo base_url('gambar/img/logo/logo_digilab.png'); ?>" alt="" width="150px"></center>
            </td>
        </tr>
    </table>
    <br>

    <!-- area identitas -->
    <p style="text-align: center;">
        <span style="font-size: 22px;font-weight: bold;">
            <u>LAPORAN HASIL UJI</u>
        </span>
    </p>&nbsp;

    <table width="90%" border="0" cellpadding="1" cellspacing="1">
        <tr>
            <td width="25%">Jenis Contoh</td>
            <td width="1%">:</td>
            <td><?= $aset_baru[0]['jenis_nama'] ?></td>
        </tr>
        <tr>
            <td width="25%">Parameter</td>
            <td width="5%">:</td>
            <td><?= $aset_baru[0]['rumus_nama'] ?></td>
        </tr>
    </table>
    <br>
    <br>
    <!-- area identitas -->

    <!-- Hasil Uji -->
    <p style="text-align: center;">
        <span style="font-size: 22px;font-weight: bold;">
            <u>HASIL PENGUJIAN</u>
        </span>
    </p>

    <table width="90%" border="1" cellpadding="2" cellspacing="2" style="border:1px solid black;border-collapse:collapse;border-radius:20cm;text-align:center">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Nomor Sample</th>
                <th>Hasil Pengujian</th>
                <th>Satuan</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($aset_baru as $value) : ?>
                <tr>
                    <td><?= $value['when_create_baru'] ?></td>
                    <td><?= $value['transaksi_detail_nomor_sample'] ?></td>
                    <td><?= $value['rumus_hasil'] ?></td>
                    <td><?= $value['rumus_satuan'] ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    <br>
    <br>
    <!-- Hasil Uji -->

    <div class="col-md-9">
        <div class="card-body">
            <div class="col-md-9" id="div_chartReportSample">
                <canvas id="chartReportSample" style="width:90%"></canvas>
            </div>
        </div>
    </div>
</body>

<script type="text/javascript">
    $(function() {
        $.ajax({
            url: "<?= base_url() ?>/sample/report/getHistoryLogSheet?jenis_id=<?= $_GET['jenis'] ?>&tanggal_cari_awal=<?= $_GET['tanggal_cari_awal'] ?>&tanggal_cari_akhir=<?= $_GET['tanggal_cari_akhir'] ?>&id_rumus=<?= $_GET['id_rumus'] ?>",
            method: "GET",
            async: true,
            dataType: 'json',
            success: function(id) {
                console.log(id);
                var label = [];
                var value = []

                $.each(id, function(index, val) {
                    label.push(val.when_create_baru);
                    value.push(val.rumus_hasil);
                });

                $('#chartReportSample').remove();
                $('#div_chartReportSample').append('<canvas id="chartReportSample" style="width: 100%;"></canvas>');
                var ctx = document.getElementById('chartReportSample').getContext('2d');
                var chartReportSample = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: label,
                        datasets: [{
                            label: 'Hasil Pengujian',
                            data: value,
                            backgroundColor: ['rgba(255, 99, 132, 0.2)'],
                            borderColor: ['rgba(255, 99, 132, 1)'],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
        });
    })
</script>

<script>
    setTimeout(() => {
        printJS('print_report', 'html');
        window.print();
    }, 1500);
</script>