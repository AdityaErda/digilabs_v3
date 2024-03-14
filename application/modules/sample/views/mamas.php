<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Create PDF</title>
	  <link rel="stylesheet" href="<?= base_url() ?>assets/dist/css/adminlte.min.css">
	  <style type="text/css">
	  	@page {
			  size: A4;
			  margin: 0;
			}
			@media print {
			  html, body {
			    width: 210mm;
			    height: 297mm;
			  }
			}
			body {
				font-family: 'Arial'!important;
				font-size: 11pt;
			}
			header {
				 margin-left: 1cm; 
				 margin-top: 1cm; 
				 margin-right: 1cm;
			}
			footer {
				 position: absolute; 
				 bottom: 0; 
				 width: 100%;
			}
	  </style>
	</head>
	<body>
	  <header>
      <table width="100%">
        <tr>
          <td width="20%" valign="top">
            <img src="https://storage.googleapis.com/pkg-portal-bucket/images/template/logo-PG-agro-trans-small.png" width="150px">
          </td>
          <td width="60%" align="center" valign="bottom">
            <p style="font-size: 16pt; font-weight: bold;" class="mb-0">LABORATORIUM PENGUJI</p>
            <p style="margin-top: -10px;">LP-076-IDN</p>
          </td>
          <td width="20%" align="right" valign="top">
            <img src="http://kan.or.id/images/kan.png" width="130px">
          </td>
        </tr>
      </table>
    </header>
    <div class="main" style="flex: 1; margin-left: 2.5cm; margin-top: 1cm; margin-right: 2cm;line-height: 0.2;">
      <p>Gresik, </p>
      <p>Nomor &nbsp;&nbsp;&nbsp;&nbsp;: </p>
      <center>
        <p style="font-size: 14pt; font-weight: bold; text-decoration: underline;">LAPORAN HASIL UJI</p>
        <p style="font-style: italic;">( Analysis Report )</p>
      </center>
      <table width="100%">
        <tr>
          <td width="30%" valign="top">
            <p style="text-decoration: underline;">Nomor Lab</p>
            <p style="font-style: italic; font-size: 10pt;">Lab. number</p>
          </td>
          <td width="10%" valign="top" align="center">:</td>
          <td width="60%" valign="top">00444</td>
        </tr>
        <tr>
          <td width="30%" valign="top">
            <p style="text-decoration: underline;">Nomor Lab</p>
            <p style="font-style: italic; font-size: 10pt;">Lab. number</p>
          </td>
          <td width="10%" valign="top" align="center">:</td>
          <td width="60%" valign="top">00444</td>
        </tr>
      </table>
    </div>
    <footer>
      <img src="<?= base_url() ?>/gambar/img/logo/logoFooterAlamat.png" style="width: 100%;">
    </footer>
	</body>
</html>