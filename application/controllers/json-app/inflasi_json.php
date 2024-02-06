<?php
defined('BASEPATH') or exit('No direct script access allowed');

include_once("functions/default.func.php");
include_once("functions/string.func.php");
include_once("functions/date.func.php");
include_once("functions/class-list-util.php");
include_once("functions/class-list-util-serverside.php");

class Inflasi_Json extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		if($this->session->userdata("appuserid") == "")
		{
			redirect('login');
		}
		
		$this->appuserid= $this->session->userdata("appuserid");
		$this->appusernama= $this->session->userdata("appusernama");
		$this->personaluserlogin= $this->session->userdata("personaluserlogin");
		$this->appusergroupid= $this->session->userdata("appusergroupid");

		$this->configtitle= $this->config->config["configtitle"];
		// print_r($this->configtitle);exit;
	}

	function json()
	{
		$this->load->model("base-app/M_Inflasi_Calculate");

		$set= new M_Inflasi_Calculate();

		if ( isset( $_REQUEST['columnsDef'] ) && is_array( $_REQUEST['columnsDef'] ) ) {
			$columnsDefault = [];
			foreach ( $_REQUEST['columnsDef'] as $field ) {
				$columnsDefault[ $field ] = "true";
			}
		}
		// print_r($columnsDefault);exit;

		$displaystart= -1;
		$displaylength= -1;

		$arrinfodata= [];

		$reqPencarian= $this->input->get("reqPencarian");
		$reqStatus= $this->input->get("reqStatus");
		$reqKode= $this->input->get("reqKode");
		$searchJson= "";
		// if(!empty($reqPencarian))
		// {
		// 	$searchJson= " 
		// 	AND 
		// 	(
		// 		UPPER(A.NAMA) LIKE '%".strtoupper($reqPencarian)."%'
		// 		OR UPPER(A.NAMA) LIKE '%".strtoupper($reqPencarian)."%'
		// 	)";
		// }

		$statement="";

		if(!empty($reqStatus))
		{
			if($reqStatus== 'NULL')
			{
				$statement .= " AND A.STATUS IS NULL";
			}
			else
			{
				$statement .= " AND A.STATUS =".$reqStatus;
			}
			
		}
		

		$sOrder = " ";
		$set->selectByParams(array(), $dsplyRange, $dsplyStart, $statement.$searchJson, $sOrder);

		// echo $set->query;exit;
		$infobatasdetil= $_REQUEST['start'] + $_REQUEST['length'];
		$infonomor= 0;
		while ($set->nextRow()) 
		{
			$infonomor++;

			$row= [];
			foreach($columnsDefault as $valkey => $valitem) 
			{
				if ($valkey == "SORDERDEFAULT")
				{
					$row[$valkey]= $set->getField("NAMA");
				}
				else if ($valkey == "NO")
				{
					$row[$valkey]= $infonomor;
				}
				else if ($valkey == "INFLASI")
				{
					$row[$valkey]= $set->getField("INFLASI")."%";
				}
				else
					$row[$valkey]= $set->getField($valkey);
			}
			array_push($arrinfodata, $row);
		}

		// get all raw data
		$alldata = $arrinfodata;
		// print_r($alldata);exit;

		$data = [];
		// internal use; filter selected columns only from raw data
		foreach ( $alldata as $d ) {
			// $data[] = filterArray( $d, $columnsDefault );
			$data[] = $d;
		}

		// count data
		$totalRecords = $totalDisplay = count( $data );

		// filter by general search keyword
		if ( isset( $_REQUEST['search'] ) ) {
			$data         = filterKeyword( $data, $_REQUEST['search'] );
			$totalDisplay = count( $data );
		}

		if ( isset( $_REQUEST['columns'] ) && is_array( $_REQUEST['columns'] ) ) {
			foreach ( $_REQUEST['columns'] as $column ) {
				if ( isset( $column['search'] ) ) {
					$data         = filterKeyword( $data, $column['search'], $column['data'] );
					$totalDisplay = count( $data );
				}
			}
		}

		// sort
		if ( isset( $_REQUEST['order'][0]['column'] ) && $_REQUEST['order'][0]['dir'] ) {
			$column = $_REQUEST['order'][0]['column'];

				$dir    = $_REQUEST['order'][0]['dir'];
				usort( $data, function ( $a, $b ) use ( $column, $dir ) {
					$a = array_slice( $a, $column, 1 );
					$b = array_slice( $b, $column, 1 );
					$a = array_pop( $a );
					$b = array_pop( $b );

					if ( $dir === 'asc' ) {
						return $a > $b ? true : false;
					}

					return $a < $b ? true : false;
				} );
		}

		// pagination length
		if ( isset( $_REQUEST['length'] ) ) {
			if($_REQUEST['length'] =="-1")
			{
				$data=array_values($data);
			}
			else
			{
				$data = array_splice( $data, $_REQUEST['start'], $_REQUEST['length'] );
			}
		}

		// return array values only without the keys
		if ( isset( $_REQUEST['array_values'] ) && $_REQUEST['array_values'] ) {
			$tmp  = $data;
			$data = [];
			foreach ( $tmp as $d ) {
				$data[] = array_values( $d );
			}
		}

		$result = [
		    'recordsTotal'    => $totalRecords,
		    'recordsFiltered' => $totalDisplay,
		    'data'            => $data,
		];

		header('Content-Type: application/json');
		echo json_encode( $result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	
	}

	function json_m()
	{
		$this->load->model("base-app/M_Inflasi");

		$set= new M_Inflasi();

		if ( isset( $_REQUEST['columnsDef'] ) && is_array( $_REQUEST['columnsDef'] ) ) {
			$columnsDefault = [];
			foreach ( $_REQUEST['columnsDef'] as $field ) {
				$columnsDefault[ $field ] = "true";
			}
		}
		// print_r($columnsDefault);exit;

		$displaystart= -1;
		$displaylength= -1;

		$arrinfodata= [];

		$reqPencarian= $this->input->get("reqPencarian");
		$reqStatus= $this->input->get("reqStatus");
		$reqKode= $this->input->get("reqKode");
		$searchJson= "";
		
		$statement="";

		if(!empty($reqStatus))
		{
			if($reqStatus== 'NULL')
			{
				$statement .= " AND A.STATUS IS NULL";
			}
			else
			{
				$statement .= " AND A.STATUS =".$reqStatus;
			}
			
		}
		

		$sOrder = " ORDER BY A.ID ASC";
		$set->selectByParamsAll(array(), $dsplyRange, $dsplyStart, $statement.$searchJson, $sOrder);

		// echo $set->query;exit;
		$infobatasdetil= $_REQUEST['start'] + $_REQUEST['length'];
		$infonomor= 0;
		while ($set->nextRow()) 
		{
			$infonomor++;

			$row= [];
			foreach($columnsDefault as $valkey => $valitem) 
			{
				if ($valkey == "SORDERDEFAULT")
				{
					$row[$valkey]= $set->getField("NAMA");
				}
				else if ($valkey == "NO")
				{
					$row[$valkey]= $infonomor;
				}
				else if ($valkey == "F")
				{
					$valf=$set->getField("F");
					$valf=$valf * 100;
					$valf=$valf." %";
					// $formatter = new NumberFormatter('en_US', NumberFormatter::PERCENT);
					// $valf= $formatter->format($valf);
					$row[$valkey]= $valf;
				}
				else
					$row[$valkey]= $set->getField($valkey);
			}
			array_push($arrinfodata, $row);
		}

		// get all raw data
		$alldata = $arrinfodata;
		// print_r($alldata);exit;

		$data = [];
		// internal use; filter selected columns only from raw data
		foreach ( $alldata as $d ) {
			// $data[] = filterArray( $d, $columnsDefault );
			$data[] = $d;
		}

		// count data
		$totalRecords = $totalDisplay = count( $data );

		// filter by general search keyword
		if ( isset( $_REQUEST['search'] ) ) {
			$data         = filterKeyword( $data, $_REQUEST['search'] );
			$totalDisplay = count( $data );
		}

		if ( isset( $_REQUEST['columns'] ) && is_array( $_REQUEST['columns'] ) ) {
			foreach ( $_REQUEST['columns'] as $column ) {
				if ( isset( $column['search'] ) ) {
					$data         = filterKeyword( $data, $column['search'], $column['data'] );
					$totalDisplay = count( $data );
				}
			}
		}

		// sort
		if ( isset( $_REQUEST['order'][0]['column'] ) && $_REQUEST['order'][0]['dir'] ) {
			$column = $_REQUEST['order'][0]['column'];

				$dir    = $_REQUEST['order'][0]['dir'];
				usort( $data, function ( $a, $b ) use ( $column, $dir ) {
					$a = array_slice( $a, $column, 1 );
					$b = array_slice( $b, $column, 1 );
					$a = array_pop( $a );
					$b = array_pop( $b );

					if ( $dir === 'asc' ) {
						return $a > $b ? true : false;
					}

					return $a < $b ? true : false;
				} );
		}

		// pagination length
		if ( isset( $_REQUEST['length'] ) ) {
			if($_REQUEST['length'] =="-1")
			{
				$data=array_values($data);
			}
			else
			{
				$data = array_splice( $data, $_REQUEST['start'], $_REQUEST['length'] );
			}
		}

		// return array values only without the keys
		if ( isset( $_REQUEST['array_values'] ) && $_REQUEST['array_values'] ) {
			$tmp  = $data;
			$data = [];
			foreach ( $tmp as $d ) {
				$data[] = array_values( $d );
			}
		}

		$result = [
		    'recordsTotal'    => $totalRecords,
		    'recordsFiltered' => $totalDisplay,
		    'data'            => $data,
		];

		header('Content-Type: application/json');
		echo json_encode( $result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	
	}


	function add()
	{
		$this->load->model("base-app/M_Inflasi_Calculate");


		$reqId= $this->input->post("reqId");
		$reqMode= $this->input->post("reqMode");

		$reqTahunAwal= $this->input->post("reqTahunAwal");
		$reqTahunAkhir= $this->input->post("reqTahunAkhir");
		$reqRata= $this->input->post("reqRata");

		$set = new M_Inflasi_Calculate();
		$set->setField("TAHUN_AWAL", $reqTahunAwal);
		$set->setField("TAHUN_AKHIR", $reqTahunAkhir);
		$set->setField("INFLASI", $reqRata);
		$set->setField("M_INFLASI_CALCULATE_ID", $reqId);

		if($reqTahunAwal==$reqTahunAkhir)
		{
			echo "xxx***Tahun Awal / Tahun Akhir tidak boleh sama";exit;
		}

		if($reqTahunAwal > $reqTahunAkhir)
		{
			echo "xxx***Tahun Awal tidak boleh lebih dari Tahun Akhir";exit;
		}

		
		$reqSimpan= "";
		if ($reqMode == "insert")
		{
			$set->setField("LAST_CREATE_USER", $this->appusernama);
			$set->setField("LAST_CREATE_DATE", 'NOW()');

			if($set->insert())
			{
				$reqSimpan= 1;
				$reqId = $set->id;
			}
		}
		else
		{	
			
			$set->setField("LAST_UPDATE_USER", $this->appusernama);
			$set->setField("LAST_UPDATE_DATE", 'NOW()');
			if($set->update())
			{
				$reqSimpan= 1;
			}

		}
		

		if($reqSimpan == 1 )
		{
			echo $reqId."***Data berhasil disimpan";
		}
		else
		{
			echo "xxx***Data gagal disimpan";
		}
				
	}

	function addm()
	{
		$this->load->model("base-app/M_Inflasi");


		$reqId= $this->input->post("reqId");
		$reqMode= $this->input->post("reqMode");

		$reqTahun= $this->input->post("reqTahun");
		$reqTahunOld= $this->input->post("reqTahunOld");
		$reqF= $this->input->post("reqF");
		$reqStatus= $this->input->post("reqStatus");

		$set = new M_Inflasi();
		$set->setField("TAHUN", $reqTahun);
		$set->setField("F", str_replace(',', '.', $reqF));
		$set->setField("STATUS", $reqStatus);
		$set->setField("ID", $reqId);

		
		$reqSimpan= "";
		if ($reqMode == "insert")
		{

			$statement=" AND A.TAHUN =  '".$reqTahun."' ";
			$check = new M_Inflasi();
			$check->selectByParamsAll(array(), -1, -1, $statement);
				// echo $check->query;exit;
			$check->firstRow();
			$checkKode= $check->getField("TAHUN");

			if(!empty($checkKode))
			{
				echo "xxx***Data Tahun sudah ada";exit;	
			}

			$set->setField("LAST_CREATE_USER", $this->appusernama);
			$set->setField("LAST_CREATE_DATE", 'NOW()');

			if($set->insert())
			{
				$reqSimpan= 1;
				$reqId = $set->id;
			}
		}
		else
		{	

			if($reqTahun != $reqTahunOld)
			{
				$statement=" AND A.TAHUN =  '".$reqTahun."' ";
				$check = new M_Inflasi();
				$check->selectByParamsAll(array(), -1, -1, $statement);
					// echo $check->query;exit;
				$check->firstRow();
				$checkKode= $check->getField("TAHUN");

				if(!empty($checkKode))
				{
					echo "xxx***Data Tahun sudah ada";exit;	
				}
			}
			
			$set->setField("LAST_UPDATE_USER", $this->appusernama);
			$set->setField("LAST_UPDATE_DATE", 'NOW()');
			if($set->update())
			{
				$reqSimpan= 1;
			}

		}
		

		if($reqSimpan == 1 )
		{
			echo $reqId."***Data berhasil disimpan";
		}
		else
		{
			echo "xxx***Data gagal disimpan";
		}
				
	}


	function kalkulasi()
	{
		$this->load->model("base-app/M_Inflasi_Calculate");
		$this->load->model("base-app/M_Inflasi");


		$reqId= $this->input->post("reqId");
		$reqMode= $this->input->post("reqMode");

		$reqTahunAwal= $this->input->get("reqTahunAwal");
		$reqTahunAkhir= $this->input->get("reqTahunAkhir");

		
		$set= new M_Inflasi();
		$arrset= [];

		$statement=" AND tahun >= ".$reqTahunAwal." and tahun <= ".$reqTahunAkhir."  ";
		$set->selectByParamsAll(array(), -1,-1,$statement);
		// echo $set->query;exit;
		$product=1;
		while($set->nextRow())
		{
			$fp1= $set->getField("FP1");
			$product *= $fp1;
		}
		unset($set);

		$product=number_format((float)$product, 8, '.', '');

		$jangkawaktu= $reqTahunAkhir-$reqTahunAwal;


		$nper = $jangkawaktu;
		$pmt = 0;
		$pv = -1;
		$fv = $product;
		$type = 0;
		$guess = 0.1;
		$rate=$this->RATE($nper, $pmt, $pv, $fv, $guess);
		$rate=round($rate, 4);
		$rate=$rate*100;
		// $formatter = new NumberFormatter('en_US', NumberFormatter::PERCENT);
		// $rate= $formatter->format($rate);

		// print_r($rate);exit;

		// $formatter = new NumberFormatter('en_US', NumberFormatter::PATTERN_DECIMAL);
		// $rate= $formatter->format($rate);

		

		// $formatter = new NumberFormatter('en_US', NumberFormatter::DECIMAL);
		// $rate= $formatter->format($rate);

		// $formatter = new NumberFormatter('en_US', NumberFormatter::PERCENT);
		// $rate= $formatter->format($rate);

		// $rate=round($rate, 2);
		// $rate= number_format((float)$rate , 2, '.', '');


		$total=$rate;

		echo $total;
				
	}

	function RATE($nper, $pmt, $pv, $fv = 0.0, $type = 0, $guess = 0.1) {
		define('FINANCIAL_MAX_ITERATIONS', 128);
		define('FINANCIAL_PRECISION', 1.0e-08);

		$rate = $guess;
		if (abs($rate) < FINANCIAL_PRECISION) {
			$y = $pv * (1 + $nper * $rate) + $pmt * (1 + $rate * $type) * $nper + $fv;
		} else {
			$f = exp($nper * log(1 + $rate));
			$y = $pv * $f + $pmt * (1 / $rate + $type) * ($f - 1) + $fv;
		}
		$y0 = $pv + $pmt * $nper + $fv;
		$y1 = $pv * $f + $pmt * (1 / $rate + $type) * ($f - 1) + $fv;

		$i  = $x0 = 0.0;
		$x1 = $rate;
		while ((abs($y0 - $y1) > FINANCIAL_PRECISION) && ($i < FINANCIAL_MAX_ITERATIONS)) {
			$rate = ($y1 * $x0 - $y0 * $x1) / ($y1 - $y0);
			$x0 = $x1;
			$x1 = $rate;

			if (abs($rate) < FINANCIAL_PRECISION) {
				$y = $pv * (1 + $nper * $rate) + $pmt * (1 + $rate * $type) * $nper + $fv;
			} else {
				$f = exp($nper * log(1 + $rate));
				$y = $pv * $f + $pmt * (1 / $rate + $type) * ($f - 1) + $fv;
			}

			$y0 = $y1;
			$y1 = $y;
			++$i;
		}
		return $rate;
	}  



	// function RATE($nper, $pmt, $pv, $fv = 0, $type = 0, $guess = 0.1) {
	// 	define('FINANCIAL_MAX_ITERATIONS', 128);
	// 	define('FINANCIAL_PRECISION', 1.0e-08);
	// 	$rate = $guess;
	// 	if (abs($rate) < FINANCIAL_PRECISION) {
	// 		$y = $pv * (1 + $nper * $rate) + $pmt * (1 + $rate * $type) * $nper + $fv;
	// 	} else {
	// 		$f = exp($nper * log(1 + $rate));
	// 		$y = $pv * $f + $pmt * (1 / $rate + $type) * ($f - 1) + $fv;
	// 	}
	// 	$y0 = $pv + $pmt * $nper + $fv;
	// 	$y1 = $pv * $f + $pmt * (1 / $rate + $type) * ($f - 1) + $fv;
	// 	$i = $x0 = 0.0;
	// 	$x1 = $rate;
	// 	while ((abs($y0 - $y1) > FINANCIAL_PRECISION) && ($i < FINANCIAL_MAX_ITERATIONS)) {
	// 		$rate = ($y1 * $x0 - $y0 * $x1) / ($y1 - $y0);
	// 		$x0 = $x1;
	// 		$x1 = $rate;
	// 		if (abs($rate) < FINANCIAL_PRECISION) {
	// 			$y = $pv * (1 + $nper * $rate) + $pmt * (1 + $rate * $type) * $nper + $fv;
	// 		} else {
	// 			$f = exp($nper * log(1 + $rate));
	// 			$y = $pv * $f + $pmt * (1 / $rate + $type) * ($f - 1) + $fv;
	// 		}
	// 		$y0 = $y1;
	// 		$y1 = $y;
	// 		++$i;
	// 	}
	// 	return $rate;
	// }





	function delete()
	{
		$this->load->model("base-app/M_Inflasi_Calculate");
		$set = new M_Inflasi_Calculate();
		
		$reqId =  $this->input->get('reqId');
		$reqMode =  $this->input->get('reqMode');

		$set->setField("M_INFLASI_CALCULATE_ID", $reqId);

		if($set->delete())
		{
			$arrJson["PESAN"] = "Data berhasil dihapus.";
		}
		else
		{
			$arrJson["PESAN"] = "Data gagal dihapus.";	
		}

		echo json_encode( $arrJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	
	}

	function deletem()
	{
		$this->load->model("base-app/M_Inflasi");
		$set = new M_Inflasi();
		
		$reqId =  $this->input->get('reqId');
		$reqMode =  $this->input->get('reqMode');

		$set->setField("ID", $reqId);

		if($set->delete())
		{
			$arrJson["PESAN"] = "Data berhasil dihapus.";
		}
		else
		{
			$arrJson["PESAN"] = "Data gagal dihapus.";	
		}

		echo json_encode( $arrJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	
	}


	function update_status()
	{
		$this->load->model("base-app/M_Inflasi_Calculate");
		$set = new M_Inflasi_Calculate();
		
		$reqId =  $this->input->get('reqId');
		$reqMode =  $this->input->get('reqMode');

		$reqStatus =  $this->input->get('reqStatus');

		$set->setField("PERUSAHAAN_EKSTERNAL_ID", $reqId);
		$set->setField("STATUS", ValToNullDB($reqStatus));

		if($reqStatus==1)
		{
			$pesan="dinonaktifkan.";
		}
		else
		{
			$pesan="diaktifkan.";
		}

		if($set->update_status())
		{
			$arrJson["PESAN"] = "Data berhasil ".$pesan;
		}
		else
		{
			$arrJson["PESAN"] =  "Data gagal ".$pesan;
		}

		echo json_encode( $arrJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	
	}

}