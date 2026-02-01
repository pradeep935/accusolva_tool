<?php
namespace App;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// error_reporting(0);

$styleArrayborder = array(
    'borders' => array(
        'outline' => array(
            'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            'color' => array('argb' => 'FF4E81BE'),
        ),
    ),
    'fill' => array('type' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,'color' => array('argb' => 'FF4E81BE',),),
);

$styleArray4 = array(
    'font' => array('bold' => true,'color' => array('argb' => 'FFFFFFFF',),),
    'alignment' => array('horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,),
    'fill' => array('type' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,'color' => array('argb' => 'FF4E81BE',),),
    'borders' => array(
        'outline' => array(
        'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        'color' => array('argb' => 'FF000000'),
        ),
    ),
 );

$spreadsheet = new Spreadsheet();  /*----Spreadsheet object-----*/
$Excel_writer = new Xlsx($spreadsheet);  /*----- Excel (Xls) Object*/
$spreadsheet->setActiveSheetIndex(0);
$activeSheet = $spreadsheet->getActiveSheet();
$activeSheet->setTitle("Today's Project Statistics");

$ar_names = array("SN","ID","SUPLIER ID","SUPLIER NAME","OUR PO","CLIENT","START IP","END IP","START TIME","END TIME","START DATE","END DATE","REF ID","UID","COUNTRY");

$ar_fields = array("sn","pid" ,"gid" ,"vendorName" ,"project_name","clientName","start_ip_address","end_ip_address","start_time","end_time","start_date","end_date","ref_id","user_id","country_name");


$ar_width = array("5","30","30","20","30","30","5","30","30","20","30","30","20","30","30");

function getNameFromNumber($num) {
    $numeric = ($num ) % 26;
    $letter = chr(65 + $numeric);
    $num2 = intval(($num ) / 26);
    if ($num2 > 0) {
        return getNameFromNumber($num2 - 1) . $letter;
    } else {
        return $letter;
    }
}

$seq = 2;
$offset = 0;
$count = 0;
$i = 0;
foreach ($ar_names as $ar) {

    $cell_val = $i + $offset;
    $cell_val = getNameFromNumber($cell_val);

    $spreadsheet->setActiveSheetIndex(0)->setCellValue($cell_val . $seq, $ar_names[$count]);
    $spreadsheet->getActiveSheet()->getColumnDimension($cell_val)->setWidth((isset($ar_width[$count]))?$ar_width[$count]:20);
    $spreadsheet->getActiveSheet()->getStyle($cell_val . $seq)->applyFromArray($styleArrayborder);
    $spreadsheet->getActiveSheet()->getStyle($cell_val . $seq)->getAlignment()->setWrapText(true);
    $i++;
    $count++;
}
$max_col = getNameFromNumber($i-1);
$spreadsheet->getActiveSheet()->mergeCells('A1:'.$max_col.'1');

$spreadsheet->setActiveSheetIndex(0)->getStyle('A2:'.$max_col.'2')->getFill()
->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
->getStartColor()->setARGB('b3caf2');


$seq++;
$sn = 0;
foreach ($dailyStats as $row) {
    $i = 0;
    foreach ($ar_fields as $ar) {
        $var = '';
        $cell = $i + $offset;
        $cell_val = getNameFromNumber($cell);

        if($ar == 'sn'){
            $var = $sn+1;
        } else {
            $var = (isset($row[$ar]))?$row[$ar]:'';
        }
        $i++;

        $spreadsheet ->getActiveSheet()-> setCellValue($cell_val . $seq, $var);
    }


    $sn++;
    $seq++;

}

$filename = "Daily_Survey_Record_".strtotime("now").'.xlsx';
$writer = new Xlsx($spreadsheet);
$path = 'uploads/';
$writer->save($path.$filename);