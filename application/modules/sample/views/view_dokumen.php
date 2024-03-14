<?php
	header('Content-disposition: inline');
	header('Content-type: application/msword'); // not sure if this is the correct MIME type
	readfile('./dokumen_dof/template.docx');
	exit;