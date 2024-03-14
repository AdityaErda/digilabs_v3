<?php

error_reporting(0);
foreach ($template_detail as $key_td => $val_td) :
    $this->excel->setActiveSheetIndex(0);
    $this->excel->getActiveSheet()->setTitle('Sheet 1');
    $this->excel->getActiveSheet()->setCellValue('A1', 'Rumus');
    $this->excel->getActiveSheet()->setCellValue('B1', $val_td['rumus_nama']);
    $this->excel->getActiveSheet()->setCellValue('A4', 'Rumus');
    $this->excel->getActiveSheet()->setCellValue('B4', $val_td['rumus_nama']);
endforeach;
$filename = $template['template_logsheet_nama'] . '.xls';
header('Content-Type: application/vnd.ms-excel'); //mime type
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0'); //no cache
$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
$objWriter->save('php://output');
