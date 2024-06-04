<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");
$this->load->library('Classes/PHPExcel');
ini_set("memory_limit","256M");
$reqDistrikId= $this->input->get("reqDistrikId");
$reqBlokId= $this->input->get("reqBlokId");
$reqUnitMesinId= $this->input->get("reqUnitMesinId");

$this->load->model("base-app/Asset_Lccm");
$this->load->model("base-app/Distrik");
$this->load->model("base-app/BlokUnit");
$this->load->model("base-app/UnitMesin");
$this->load->model("base-app/M_Group_Pm_Lccm");

// ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

$objPHPexcel = PHPExcel_IOFactory::load('template/asset_lccm.xls');

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

$statementnew= " AND A.BLOK_UNIT_ID = ".$this->appblokunitid;

$setcheck= new BlokUnit();
$setcheck->selectByParams(array(), $dsplyRange, $dsplyStart, $statementnew, $sOrder);
// echo $setcheck->query;exit; 
$setcheck->firstRow();
$reqDistrikId= $setcheck->getField("DISTRIK_ID");// if(!empty($reqKodeEam))
$reqKodeEam= $setcheck->getField("KODE_EAM");

$statement .=" AND A.siteid='".$reqKodeEam."'";

// echo $reqDistrikId;exit;

$set = new Asset_Lccm();
$sOrder=" ORDER BY A1.ASSETNUM ASC";
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

$sheetIndex= 2;
$objPHPexcel->setActiveSheetIndex($sheetIndex);
$objWorksheet= $objPHPexcel->getActiveSheet();
$objWorksheet->getStyle("A1")->applyFromArray($BStyle);
$objWorksheet->getStyle("B1")->applyFromArray($BStyle);
$objWorksheet->getStyle("C1")->applyFromArray($BStyle);

$objWorksheet->setCellValue("A1","Distrik Id");
$objWorksheet->setCellValue("B1","Kode");
$objWorksheet->setCellValue("C1","Nama");

$row = 2;
$tempRowAwal= 1;

$field= array();
$field= array("DISTRIK_ID","KODE","NAMA");

$statement=" AND A.STATUS IS NULL";

if(!empty($reqDistrikId))
{
	$statement .=" AND A.DISTRIK_ID='".$reqDistrikId."'";
}

$set = new Distrik();
$sOrder=" ORDER BY A.DISTRIK_ID ASC ";
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

$sheetIndex= 3;
$objPHPexcel->setActiveSheetIndex($sheetIndex);
$objWorksheet= $objPHPexcel->getActiveSheet();
$objWorksheet->getStyle("A1")->applyFromArray($BStyle);
$objWorksheet->getStyle("B1")->applyFromArray($BStyle);
$objWorksheet->getStyle("C1")->applyFromArray($BStyle);
$objWorksheet->getStyle("D1")->applyFromArray($BStyle);

$objWorksheet->setCellValue("A1","Blok Unit Id");
$objWorksheet->setCellValue("B1","Distrik Id");
$objWorksheet->setCellValue("C1","Kode");
$objWorksheet->setCellValue("D1","Nama");

$row = 2;
$tempRowAwal= 1;

$field= array();
$field= array("BLOK_UNIT_ID","DISTRIK_ID","KODE","NAMA");

$statement=" AND A.STATUS IS NULL";

if(!empty($reqDistrikId))
{
	$statement .=" AND B.DISTRIK_ID='".$reqDistrikId."'";
}
if(!empty($reqBlokId))
{
	$statement .=" AND A.KODE='".$reqBlokId."'";
}


$set = new BlokUnit();
$sOrder=" ORDER BY A.BLOK_UNIT_ID ASC ";
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

$sheetIndex= 4;
$objPHPexcel->setActiveSheetIndex($sheetIndex);
$objWorksheet= $objPHPexcel->getActiveSheet();
$objWorksheet->getStyle("A1")->applyFromArray($BStyle);
$objWorksheet->getStyle("B1")->applyFromArray($BStyle);
$objWorksheet->getStyle("C1")->applyFromArray($BStyle);
$objWorksheet->getStyle("D1")->applyFromArray($BStyle);
$objWorksheet->getStyle("E1")->applyFromArray($BStyle);

$objWorksheet->setCellValue("A1","Unit Mesin Id");
$objWorksheet->setCellValue("B1","Blok Unit Id");
$objWorksheet->setCellValue("C1","Distrik Id");
$objWorksheet->setCellValue("D1","Kode");
$objWorksheet->setCellValue("E1","Nama");

$row = 2;
$tempRowAwal= 1;

$field= array();
$field= array("UNIT_MESIN_ID","BLOK_UNIT_ID","DISTRIK_ID","KODE","NAMA");

$statement=" AND A.STATUS IS NULL";

if(!empty($reqDistrikId))
{
	$statement .=" AND B.DISTRIK_ID='".$reqDistrikId."'";
}
if(!empty($reqBlokId))
{
	$statement .=" AND C.KODE='".$reqBlokId."'";
}

if(!empty($reqUnitMesinId))
{
	$statement .=" AND D.KODE='".$reqUnitMesinId."'";
}

$set = new UnitMesin();
$sOrder=" ORDER BY A.UNIT_MESIN_ID ASC ";
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

$sheetIndex= 5;
$objPHPexcel->setActiveSheetIndex($sheetIndex);
$objWorksheet= $objPHPexcel->getActiveSheet();
$objWorksheet->getStyle("A1")->applyFromArray($BStyle);

$objWorksheet->setCellValue("A1","Nama");

$row = 2;
$tempRowAwal= 1;

$field= array();
$field= array("GROUP_PM");

$statement="";

if(!empty($reqDistrikId))
{
	$statement .=" AND B.DISTRIK_ID='".$reqDistrikId."'";
}
if(!empty($reqBlokId))
{
	$statement .=" AND C.KODE='".$reqBlokId."'";
}

if(!empty($reqUnitMesinId))
{
	$statement .=" AND D.KODE='".$reqUnitMesinId."'";
}


$set = new M_Group_Pm_Lccm();
$sOrder=" ORDER BY A.GROUP_PM ASC ";
$set->selectByParams(array(), -1,-1, $statement,$sOrder);

// echo $set->query;exit;
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



$objPHPexcel->setActiveSheetIndex(0);



if($no==0)
{
	echo "xxx";exit;
}

$objWriter = PHPExcel_IOFactory::createWriter($objPHPexcel, 'Excel5');
$objWriter->save('template/export/asset_lccm_'.$reqKodeEam.'.xls');

$down = 'template/export/asset_lccm_'.$reqKodeEam.'.xls';
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