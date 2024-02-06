<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");
$this->load->library('Classes/PHPExcel');


$this->load->model("base-app/Distrik");
$this->load->model("base-app/BlokUnit");
$this->load->model("base-app/UnitMesin");
$this->load->model("base-app/M_Group_Pm_Lccm");

$reqSuperiorId= $this->input->get("reqSuperiorId");
// echo $reqSuperiorId;exit;

if (!$reqSuperiorId) 
{
	exit();
}

// ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

$objPHPexcel = PHPExcel_IOFactory::load('template/export/wo_standing_anak.xlsx');

$BStyle = array(
	'borders' => array(
		'allborders' => array(

			'style' => PHPExcel_Style_Border::BORDER_THIN
		)				
	),
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	)
);

// $sheetIndex= 1;
// $objPHPexcel->setActiveSheetIndex($sheetIndex);
$objWorksheet= $objPHPexcel->getActiveSheet();
// $objWorksheet->getStyle("A1")->applyFromArray($BStyle);
// $objWorksheet->getStyle("B1")->applyFromArray($BStyle);
// $objWorksheet->getStyle("C1")->applyFromArray($BStyle);

// $objWorksheet->setCellValue("A1","Distrik Id");
// $objWorksheet->setCellValue("B1","Kode");
// $objWorksheet->setCellValue("C1","Nama");

$row = 2;
$tempRowAwal= 1;

$field= array();
$field= array("KODE_DISTRIK","KODE_BLOK","KODE_UNIT","GROUP_PM");

$statement=" AND A.GROUP_PM = '".$reqSuperiorId."'";

$set = new M_Group_Pm_Lccm();
$sOrder=" ORDER BY A.GROUP_PM ASC ";
$set->selectByParams(array(), -1,-1, $statement,$sOrder);
while($set->nextRow())
{
	$index_kolom= 1;
	for($i=0; $i<count($field); $i++)
	{
		$kolom= getColoms($index_kolom);
		
		$objWorksheet->getStyle($kolom.$row)->applyFromArray($BStyle);
		$objWorksheet->setCellValue($kolom.$row,$set->getField($field[$i]));
		$objWorksheet->getColumnDimension($kolom)->setAutoSize(TRUE);
		
		$index_kolom++;
	}
	$row++;
}



$objWriter = PHPExcel_IOFactory::createWriter($objPHPexcel, 'Excel5');
$objWriter->save('template/export/wo_standing_anak.xls');

$down = 'template/export/wo_standing_anak.xls';
header('Content-Description: File Transfer');
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename='.basename($down));
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-Length: ' . filesize($down));
ob_clean();
flush();
readfile($down);
unlink($down);
//unlink($save);
?>