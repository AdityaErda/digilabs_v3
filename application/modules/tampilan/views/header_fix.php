<!DOCTYPE html>
<html>
<!-- HEAD -->

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= $judul ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Tell the browser to be responsive to screen width -->

  <!-- Tambahan -->
  <script src="<?= base_url() ?>assets_tambahan/tinymce/tinymce.min.js"></script>

  <!-- Tambahan -->


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
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/plugins/datatables-fixedheader/css/fixedHeader.bootstrap4.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/plugins/datatables-fixedcolumns/css/fixedColumns.bootstrap4.min.css') ?>">
  <!-- DataTables -->
  <!-- Summer Note -->
  <link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/summernote/summernote-bs4.css">
  <!-- Summer Note -->
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
  <script src="<?= base_url() ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?= base_url() ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?= base_url() ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="<?= base_url() ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="<?= base_url() ?>assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="<?= base_url() ?>assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="<?= base_url() ?>assets/plugins/jszip/jszip.min.js"></script>
  <script src="<?= base_url() ?>assets/plugins/pdfmake/pdfmake.min.js"></script>
  <script src="<?= base_url() ?>assets/plugins/pdfmake/vfs_fonts.js"></script>
  <script src="<?= base_url() ?>assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="<?= base_url() ?>assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
  <script src="<?= base_url() ?>assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
  <script src="<?= base_url() ?>assets/plugins/datatables-fixedheader/js/dataTables.fixedHeader.min.js"></script>
  <script src="<?= base_url() ?>assets/plugins/datatables-fixedheader/js/fixedHeader.bootstrap4.min.js"></script>
  <script src="<?= base_url() ?>assets/plugins/datatables-fixedcolumns/js/dataTables.fixedColumns.min.js"></script>
  <script src="<?= base_url() ?>assets/plugins/datatables-fixedcolumns/js/fixedColumns.bootstrap4.min.js"></script>
  <!-- DataTables -->
  <!-- summer note -->
  <script src="<?= base_url('assets/') ?>plugins/summernote/summernote-bs4.min.js"></script>
  <!-- summer note -->
  <!-- Toastr -->
  <script src="<?= base_url() ?>assets/plugins/toastr/toastr.min.js"></script>
  <!-- Toastr -->
  <!-- confirm-modal-master -->
  <script src="<?= base_url() ?>assets_tambahan/confirm-modal-master/js/jquery.confirmModal.min.js"></script>
  <!-- <script type="text/javascript">
    function logout() {
      $.confirmModal('Yakin Log Out?', {
        // modalBoxHeight: "300px"
      }, function(el) {
        location.href = "<?= base_url() ?>/login/keluar";
      });
    }
  </script> -->

  

  <link href="<?= base_url() ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
  <script src="<?= base_url() ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>
  <script type="text/javascript">
    function logout() {
      Swal.fire({
        title: "Anda Yakin Logout?",
        text: "Ketika anda logut maka akan keluar dari aplikasi Digilab!",
        icon: "danger",
        showCancelButton: true,
        confirmButtonColor: "#34c38f",
        cancelButtonColor: "#f46a6a",
        confirmButtonText: "Iya"
      }).then(function(result) {
        if (result.value) {
          location.href = "<?= base_url() ?>/login/keluar";
        }
      });
    }
  </script>

  <!-- confirm-modal-master -->
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
  <!-- datetimepicker -->
  <link href="<?=base_url()?>assets/plugins/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
  <script src="<?=base_url()?>assets/plugins/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
  <!-- datetimepicker -->
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
  <!-- PDFObject -->
  <!-- <script src="<?= base_url() ?>assets_tambahan/PDFObject/pdfobject.min.js"></script> -->
  <script src="<?= base_url() ?>assets_tambahan/PDFObject/pdfobject.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.5/jszip.min.js"></script>
  <!-- pdf js -->
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.0.943/pdf.min.js"></script> -->
  <!-- <script src="<?= base_url() ?>assets_tambahan/pdfjs-2.11.338-dist/build/pdf.js"></script> -->
  <!-- <sc  ript src="<?= base_url() ?>assets_tambahan/pdfjs/build/pdf.js"></sc> -->
  <!-- <scrip  src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.0.943/pdf.min.js"> </script> -->
  <!-- <script src="https://unpkg.com/pdfjs-dist@latest/build/pdf.min.js"></script> -->
  <!-- <script src="https://www.jsdelivr.com/package/npm/pdfjs-dist"> </script> -->
  <!-- <script src="https://unpkg.com/pdfjs-dist/"> </script> -->
  <link href="<?= base_url() ?>assets/plugins/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
  <script src="<?= base_url() ?>assets/plugins/sweetalert2/sweetalert2.min.js"></script>
  <script>
    $(function() {
      /* jQueryKnob */
      $('.knob').knob({
        /*change : function (value) {
         //console.log("change : " + value);
         },
         release : function (value) {
         console.log("release : " + value);
         },
         cancel : function () {
         console.log("cancel : " + this.value);
         },*/
        draw: function() {
          // "tron" case
          if (this.$.data('skin') == 'tron') {
            var a = this.angle(this.cv) // Angle
              ,
              sa = this.startAngle // Previous start angle
              ,
              sat = this.startAngle // Start angle
              ,
              ea // Previous end angle
              ,
              eat = sat + a // End angle
              ,
              r = true
            this.g.lineWidth = this.lineWidth
            this.o.cursor &&
              (sat = eat - 0.3) &&
              (eat = eat + 0.3)
            if (this.o.displayPrevious) {
              ea = this.startAngle + this.angle(this.value)
              this.o.cursor &&
                (sa = ea - 0.3) &&
                (ea = ea + 0.3)
              this.g.beginPath()
              this.g.strokeStyle = this.previousColor
              this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sa, ea, false)
              this.g.stroke()
            }
            this.g.beginPath()
            this.g.strokeStyle = r ? this.o.fgColor : this.fgColor
            this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sat, eat, false)
            this.g.stroke()
            this.g.lineWidth = 2
            this.g.beginPath()
            this.g.strokeStyle = this.o.fgColor
            this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false)
            this.g.stroke()
            return false
          }
        }
      })
      /* END JQUERY KNOB */
      //INITIALIZE SPARKLINE CHARTS
      $('.sparkline').each(function() {
        var $this = $(this)
        $this.sparkline('html', $this.data())
      })
      /* SPARKLINE DOCUMENTATION EXAMPLES http://omnipotent.net/jquery.sparkline/#s-about */
      drawDocSparklines()
      drawMouseSpeedDemo()
    })

    function drawDocSparklines() {
      // Bar + line composite charts
      $('#compositebar').sparkline('html', {
        type: 'bar',
        barColor: '#aaf'
      })
      $('#compositebar').sparkline([4, 1, 5, 7, 9, 9, 8, 7, 6, 6, 4, 7, 8, 4, 3, 2, 2, 5, 6, 7], {
        composite: true,
        fillColor: false,
        lineColor: 'red'
      })
      // Line charts taking their values from the tag
      $('.sparkline-1').sparkline()
      // Larger line charts for the docs
      $('.largeline').sparkline('html', {
        type: 'line',
        height: '2.5em',
        width: '4em'
      })
      // Customized line chart
      $('#linecustom').sparkline('html', {
        height: '1.5em',
        width: '8em',
        lineColor: '#f00',
        fillColor: '#ffa',
        minSpotColor: false,
        maxSpotColor: false,
        spotColor: '#77f',
        spotRadius: 3
      })
      // Bar charts using inline values
      $('.sparkbar').sparkline('html', {
        type: 'bar'
      })
      $('.barformat').sparkline([1, 3, 5, 3, 8], {
        type: 'bar',
        tooltipFormat: '{{value:levels}} - {{value}}',
        tooltipValueLookups: {
          levels: $.range_map({
            ':2': 'Low',
            '3:6': 'Medium',
            '7:': 'High'
          })
        }
      })
      // Tri-state charts using inline values
      $('.sparktristate').sparkline('html', {
        type: 'tristate'
      })
      $('.sparktristatecols').sparkline('html', {
        type: 'tristate',
        colorMap: {
          '-2': '#fa7',
          '2': '#44f'
        }
      })
      // Composite line charts, the second using values supplied via javascript
      $('#compositeline').sparkline('html', {
        fillColor: false,
        changeRangeMin: 0,
        chartRangeMax: 10
      })
      $('#compositeline').sparkline([4, 1, 5, 7, 9, 9, 8, 7, 6, 6, 4, 7, 8, 4, 3, 2, 2, 5, 6, 7], {
        composite: true,
        fillColor: false,
        lineColor: 'red',
        changeRangeMin: 0,
        chartRangeMax: 10
      })
      // Line charts with normal range marker
      $('#normalline').sparkline('html', {
        fillColor: false,
        normalRangeMin: -1,
        normalRangeMax: 8
      })
      $('#normalExample').sparkline('html', {
        fillColor: false,
        normalRangeMin: 80,
        normalRangeMax: 95,
        normalRangeColor: '#4f4'
      })
      // Discrete charts
      $('.discrete1').sparkline('html', {
        type: 'discrete',
        lineColor: 'blue',
        xwidth: 18
      })
      $('#discrete2').sparkline('html', {
        type: 'discrete',
        lineColor: 'blue',
        thresholdColor: 'red',
        thresholdValue: 4
      })
      // Bullet charts
      $('.sparkbullet').sparkline('html', {
        type: 'bullet'
      })
      // Pie charts
      $('.sparkpie').sparkline('html', {
        type: 'pie',
        height: '1.0em'
      })
      // Box plots
      $('.sparkboxplot').sparkline('html', {
        type: 'box'
      })
      $('.sparkboxplotraw').sparkline([1, 3, 5, 8, 10, 15, 18], {
        type: 'box',
        raw: true,
        showOutliers: true,
        target: 6
      })
      // Box plot with specific field order
      $('.boxfieldorder').sparkline('html', {
        type: 'box',
        tooltipFormatFieldlist: ['med', 'lq', 'uq'],
        tooltipFormatFieldlistKey: 'field'
      })
      // click event demo sparkline
      $('.clickdemo').sparkline()
      $('.clickdemo').bind('sparklineClick', function(ev) {
        var sparkline = ev.sparklines[0],
          region = sparkline.getCurrentRegionFields()
        value = region.y
        alert('Clicked on x=' + region.x + ' y=' + region.y)
      })
      // mouseover event demo sparkline
      $('.mouseoverdemo').sparkline()
      $('.mouseoverdemo').bind('sparklineRegionChange', function(ev) {
        var sparkline = ev.sparklines[0],
          region = sparkline.getCurrentRegionFields()
        value = region.y
        $('.mouseoverregion').text('x=' + region.x + ' y=' + region.y)
      }).bind('mouseleave', function() {
        $('.mouseoverregion').text('')
      })
    }
    /**
     ** Draw the little mouse speed animated graph
     ** This just attaches a handler to the mousemove event to see
     ** (roughly) how far the mouse has moved
     ** and then updates the display a couple of times a second via
     ** setTimeout()
     **/
    function drawMouseSpeedDemo() {
      var mrefreshinterval = 500 // update display every 500ms
      var lastmousex = -1
      var lastmousey = -1
      var lastmousetime
      var mousetravel = 0
      var mpoints = []
      var mpoints_max = 30
      $('html').mousemove(function(e) {
        var mousex = e.pageX
        var mousey = e.pageY
        if (lastmousex > -1) {
          mousetravel += Math.max(Math.abs(mousex - lastmousex), Math.abs(mousey - lastmousey))
        }
        lastmousex = mousex
        lastmousey = mousey
      })
      var mdraw = function() {
        var md = new Date()
        var timenow = md.getTime()
        if (lastmousetime && lastmousetime != timenow) {
          var pps = Math.round(mousetravel / (timenow - lastmousetime) * 1000)
          mpoints.push(pps)
          if (mpoints.length > mpoints_max) {
            mpoints.splice(0, 1)
          }
          mousetravel = 0
          $('#mousespeed').sparkline(mpoints, {
            width: mpoints.length * 2,
            tooltipSuffix: ' pixels per second'
          })
        }
        lastmousetime = timenow
        setTimeout(mdraw, mrefreshinterval)
      }
      // We could use setInterval instead, but I prefer to do it this way
      setTimeout(mdraw, mrefreshinterval);
    }
  </script>
  <script type="text/javascript">
    $(function() {
      $("input[type='number']").on('keydown', function(e) {
        -1 !== $
          .inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) || /65|67|86|88/
          .test(e.keyCode) && (!0 === e.ctrlKey || !0 === e.metaKey) ||
          35 <= e.keyCode && 40 >= e.keyCode || (e.shiftKey || 48 > e.keyCode || 57 < e.keyCode) &&
          (96 > e.keyCode || 105 < e.keyCode) && e.preventDefault()
      });
      approve_internal();
      approve_eksternal();
      inbox_internal();
      inbox_eksternal();
      notif_internal();
      notif_eksternal();
      total_eksternal();
      total_internal();
    })
    /* Fun Notifikasi Sample Eksternal */
    function notif_eksternal() {
      $.getJSON('<?= base_url() ?>sample/notifikasi/getNotifikasi?transaksi_tipe=E&transaksi_status=1', function(json) {
        $('#notif_eksternal').html(json.length);
      });
    }
    /* Fun Notifikasi Sample Eksternal */
    /* Fun Notifikasi Sample Internal */
    function notif_internal() {
      $.getJSON('<?= base_url() ?>sample/notifikasi/getNotifikasi?transaksi_tipe=I&transaksi_status=1', function(json) {
        $('#notif_internal').html(json.length);
      });
    }
    /* Fun Notifikasi Sample Internal */
    /* Fun Approve Sample Eksternal */
    function approve_eksternal() {
      // $.getJSON('<?= base_url() ?>sample/approve/getApprove?transaksi_tipe=E&transaksi_status_approve=0&tgl_cari=<?= date('d-m-Y') . ' - ' . date('d-m-Y') ?>', function(json) {
      $.getJSON('<?= base_url() ?>sample/approve/getApprove?transaksi_tipe=E&transaksi_status_approve=0', function(json) {
        $('#notif_approve_eksternal').html(json.length);
      });
    }
    /* Fun Approve Sample Eksternal */
    /* Fun Approve Sample Internal */
    function approve_internal() {
      $.getJSON('<?= base_url() ?>sample/approve/getApprove?transaksi_tipe=I&transaksi_status_approve=0', function(json) {
        // $.getJSON('<?= base_url() ?>sample/approve/getApprove?transaksi_tipe=I&transakxsi_status_approve=0&tgl_cari=<?= date('d-m-Y') . ' - ' . date('d-m-Y') ?>', function(json) {
        $('#notif_approve_internal').html(json.length);
      });
    }
    /* Fun Approve Sample Internal */
    /* Fun Inbox Sample Eksternal */
    function inbox_eksternal() {
      $.getJSON('<?= base_url() ?>sample/inbox/getInbox?transaksi_tipe=E&transaksi_status=6&tgl_cari=<?= date('d-m-Y') . ' - ' . date('d-m-Y') ?>', function(json) {
        $('#notif_inbox_eksternal').html(json.length);
      });
    }
    /* Fun Inbox Sample Eksternal */
    /* Fun Inbox Sample Internal */
    function inbox_internal() {
      $.getJSON('<?= base_url() ?>sample/inbox/getInbox?transaksi_tipe=I&transaksi_status=6&tgl_cari=<?= date('d-m-Y') . ' - ' . date('d-m-Y') ?>', function(json) {
        $('#notif_inbox_internal').html(json.length);
      });
    }
    /* Fun Inbox Sample Internal */
    /* Fun Total Sample Eksternal */
    function total_eksternal() {
      var approve = ($('#notif_approve_eksternal').html() != undefined) ? $('#notif_approve_eksternal').html() : 0;
      var notif = ($('#notif_eksternal').html() != undefined) ? $('#notif_eksternal').html() : 0;
      var inbox = ($('#notif_inbox_eksternal').html() != undefined) ? $('#notif_inbox_eksternal').html() : 0;
      $('#notif_total_eksternal').html((approve * 1) + (notif * 1) + (inbox * 1));
    }
    setTimeout(function() {
      total_eksternal();
    }, 2000);
    /* Fun Total Sample Eksternal */
    /* Fun Total Sample Internal */
    function total_internal() {
      var approve = ($('#notif_approve_internal').html() != undefined) ? $('#notif_approve_internal').html() : 0;
      var notif = ($('#notif_internal').html() != undefined) ? $('#notif_internal').html() : 0;
      var inbox = ($('#notif_inbox_internal').html() != undefined) ? $('#notif_inbox_internal').html() : 0;
      $('#notif_total_internal').html((approve * 1) + (notif * 1) + (inbox * 1));
    }
    setTimeout(function() {
      total_internal();
    }, 2000);
    /* Fun Total Sample Internal */
    /* Fun Rutin */
    function total_rutin() {
      $.getJSON('<?= base_url() ?>sample/nomor/getNomor?status_cari=0', function(json) {
        $('#notif_rutin').html(json.length);
      });
    }
    setTimeout(function() {
      total_rutin();
    }, 2000);
    /* Fun Rutin */
  </script>
  <!-- Nanobar -->
  <script type="text/javascript" src="<?= base_url() ?>assets_tambahan/nanobar-master/nanobar.js"></script>
  <!-- Nanobar -->
  <!-- <link rel="stylesheet" type="text/css" href="https://www.jeasyui.com/easyui/themes/default/easyui.css">
  <link rel="stylesheet" type="text/css" href="https://www.jeasyui.com/easyui/themes/icon.css">
  <script type="text/javascript" src="https://www.jeasyui.com/easyui/jquery.easyui.min.js"></script>
  <script type="text/javascript" src="https://www.jeasyui.com/easyui/jquery.edatagrid.js"></script> -->
  <link rel="stylesheet" type="text/css" href="<?= base_url('assets_tambahan') ?>/easyui/themes/default/easyui.css">
  <link rel="stylesheet" type="text/css" href="<?= base_url('assets_tambahan') ?>/easyui/themes/icon.css">
  <script type="text/javascript" src="<?= base_url('assets_tambahan') ?>/easyui/jquery.easyui.min.js"></script>
  <script type="text/javascript" src="<?= base_url('assets_tambahan') ?>/easyui/jquery.edatagrid.js"></script>
  <style type="text/css">
    a.btn-danger {
      color: white !important;
    }

    .select2-selection__rendered {
      padding-left: 0px !important;
    }

    .select2-selection--multiple {
      overflow: hidden !important;
      height: auto !important;
    }
  </style>
</head>
<!-- HEAD -->
<!-- BODY -->

