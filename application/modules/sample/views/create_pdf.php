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
	  <?= $isi ?>
	</body>
</html>