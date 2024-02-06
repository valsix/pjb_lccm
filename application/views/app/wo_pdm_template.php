<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");
$this->load->library('Classes/PHPExcel');
ini_set("memory_limit","256M");
$reqDistrikId= $this->input->get("reqDistrikId");
$reqBlokId= $this->input->get("reqBlokId");
$reqUnitMesinId= $this->input->get("reqUnitMesinId");

$this->load->model("base-app/Asset_Lccm");

// ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

$objPHPexcel = PHPExcel_IOFactory::load('template/wo_pdm.xls');

$objPHPExcel = new PHPExcel();

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



$sheetIndex= 1;

$objPHPExcel->createSheet();
$objPHPexcel->setActiveSheetIndex($sheetIndex);
$objWorksheet2= $objPHPexcel->getActiveSheet();
$objWorksheet2->getStyle("A1")->applyFromArray($BStyle);
$objWorksheet2->getStyle("B1")->applyFromArray($BStyle);



$objWorksheet2->setCellValue("A1","Asset No");
$objWorksheet2->setCellValue("B1","Description");




$row = 2;
$tempRowAwal= 1;

$field= array();
$field= array("ASSETNUM","M_DESCRIPTION");

$statement="";

if(!empty($reqDistrikId))
{
	$statement .=" AND A.KODE_DISTRIK='".$reqDistrikId."'";
}
if(!empty($reqBlokId))
{
	$statement .=" AND A.KODE_BLOK='".$reqBlokId."'";
}

if(!empty($reqUnitMesinId))
{
	$statement .=" AND A.KODE_UNIT_M='".$reqUnitMesinId."'";
}



$set = new Asset_Lccm();
$sOrder=" ORDER BY A.ASSETNUM ASC";
$set->selectByParams(array(), -1,-1, $statement,$sOrder);

// echo $set->query;exit; 
$no=0;
while($set->nextRow())
{
	$index_kolom= 1;
	for($i=0; $i<count($field); $i++)
	{
		$kolom= getColoms($index_kolom);
		
		$objWorksheet2->getStyle($kolom.$row)->applyFromArray($BStyle);
		$objWorksheet2->setCellValue($kolom.$row,$set->getField($field[$i]));
		$objWorksheet2->getColumnDimension($kolom)->setAutoSize(TRUE);
		
		$index_kolom++;
	}
	$row++;
	$no++;

}

$objPHPexcel->setActiveSheetIndex(0);



if($no==0)
{
	echo "xxx";exit;
}

$objWriter = PHPExcel_IOFactory::createWriter($objPHPexcel, 'Excel5');
$objWriter->save('template/export/wo_pdm_'.$reqDistrikId.'.xls');

$down = 'template/export/wo_pdm_'.$reqDistrikId.'.xls';
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