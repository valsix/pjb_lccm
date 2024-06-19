<?php
defined('BASEPATH') or exit('No direct script access allowed');

include_once("functions/default.func.php");
include_once("functions/string.func.php");
include_once("functions/date.func.php");
include_once("functions/class-list-util.php");
include_once("functions/class-list-util-serverside.php");

class Operation_json extends CI_Controller
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
		$this->appblokunitid= $this->session->userdata("appblokunitid");
		$this->appdistrikid= $this->session->userdata("appdistrikid");
		$this->appdistrikkode= $this->session->userdata("appdistrikkode");
		$this->appblokunitkode= $this->session->userdata("appblokunitkode");
		$this->appunitmesinid= $this->session->userdata("appunitmesinid");
		$this->appunitmesinkode= $this->session->userdata("appunitmesinkode");

		$this->configtitle= $this->config->config["configtitle"];
		// print_r($this->configtitle);exit;
	}

	function json()
	{
		$this->load->model("base-app/Operation");

		$set= new Operation();

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
		$reqTahun= $this->input->get("reqTahun");
		$reqDistrikId= $this->input->get("reqDistrikId");
		$reqBlokId= $this->input->get("reqBlokId");
		$reqUnitMesinId= $this->input->get("reqUnitMesinId");
		$reqGroupPm= $this->input->get("reqGroupPm");

		$appdistrikid= $this->appdistrikid;
		$appdistrikkode= $this->appdistrikkode;
		$appblokunitid= $this->appblokunitid;
		$appblokunitkode= $this->appblokunitkode;
		$appunitmesinkode= $this->appunitmesinkode;

		$searchJson= "";

		$statement="";
		$statement2="";

		
		if(!empty($reqDistrikId))
		{
			$statement .= " AND A.KODE_DISTRIK='".$reqDistrikId."'";
		}

		if(!empty($reqBlokId))
		{
			$statement .= " AND A.SITEID='".$reqBlokId."'";
		}

		if(!empty($reqUnitMesinId))
		{
			$statement .= " AND A.KODE_UNIT_M='".$reqUnitMesinId."'";
		}

		
		if(!empty($reqGroupPm))
		{
			$statement .= " AND B.GROUP_PM='".$reqGroupPm."'";
		}

		if(!empty($reqStatus))
		{
			$statement2 .= " AND PC.OPERATION='".$reqStatus."'";
		}

		if(!empty($appblokunitkode))
		{
			$statement2 .= " AND A.KODE_BLOK='".$appblokunitkode."'";
		}

		if(!empty($appunitmesinkode))
		{
			$statement2 .= " AND A.KODE_UNIT_M='".$appunitmesinkode."'";
		}

		$sOrder = " ORDER BY A.OPR_YEAR ASC ";
		$set->selectByParamsTahun(array(), $dsplyRange, $dsplyStart, $statement.$searchJson,$statement2, $sOrder);

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
				else
				{
					$row[$valkey]= $set->getField($valkey);
				}
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

	function jsondetail()
	{
		$this->load->model("base-app/Operation");

		$set= new Operation();

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

		$reqTahun= $this->input->get("reqTahun");
		$reqGroupPm= $this->input->get("reqGroupPm");
		$reqTahun= $this->input->get("reqTahun");
		$reqDistrikId= $this->input->get("reqDistrikId");
		$reqBlokId= $this->input->get("reqBlokId");
		$reqUnitMesinId= $this->input->get("reqUnitMesinId");
		$searchJson= "";

		$statement="";

		
		
		if(!empty($reqTahun))
		{
			$statement .= " AND A.OPR_YEAR='".$reqTahun."'";
		}

		

		$sOrder = " ORDER BY A.ASSETNUM ASC ";
		$set->selectByParamsDetailNew(array(), $dsplyRange, $dsplyStart, $statement.$searchJson, $sOrder);

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
				else if ($valkey == "EMPLOY_SALARY_ASSET" || $valkey == "COST_OF_ELECT_LOSS"  || $valkey == "COST_OF_EFF_LOSS" || $valkey == "OPERATION_COST" )
				{
					$row[$valkey]= toThousandComma($set->getField($valkey));
				}
				else
				{
					$row[$valkey]= $set->getField($valkey);
				}
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

	function addplant()
	{
		$this->load->model("base-app/Operation");
		$reqMode= $this->input->post("reqMode");
		$reqTahun= $this->input->post("reqTahun");
		$reqEmploySalary= $this->input->post("reqEmploySalary");
		$reqOperationHourYear= $this->input->post("reqOperationHourYear");
		$reqGrosProdHourYear= $this->input->post("reqGrosProdHourYear");
		$reqEffCost= $this->input->post("reqEffCost");
		$reqDistrik= $this->input->post("reqDistrik");
		$reqBlok= $this->input->post("reqBlok");
		$reqUnitMesin= $this->input->post("reqUnitMesin");

		// print_r($reqBlok);exit;


		$reqSimpan= "";
		$set= new Operation();
		$set->setField("OPR_YEAR", $reqTahun);
		$set->setField("EMPLOY_SALARY", ValToNullDB(str_replace(",", "", $reqEmploySalary)));
		$set->setField("OPR_HOURS_IN_YEAR", ValToNullDB(dotToNo($reqOperationHourYear)));
		$set->setField("PROD_IN_YEAR", ValToNullDB(dotToNo($reqGrosProdHourYear)));
		$set->setField("EFF_PRICE", ValToNullDB(str_replace(",", "", $reqEffCost)));
		$set->setField("LAST_CREATE_USER", $this->appusernama);
		$set->setField("LAST_CREATE_DATE", 'NOW()');
		$set->setField("LAST_UPDATE_USER", $this->appusernama);
		$set->setField("LAST_UPDATE_DATE", 'NOW()');
		$set->setField("KODE_DISTRIK", $reqDistrik);
		$set->setField("KODE_BLOK", $reqBlok);
		$set->setField("KODE_UNIT_M", $reqUnitMesin);

		// echo $reqMode;exit;
		if($reqMode == "insert")
		{
			if($set->insertplant())
			{
				$reqSimpan= "1";
			}
		}
		else
		{
			if($set->updateplant())
			{
				$reqSimpan= "1";
			}
		}

		if($reqSimpan == 1)
		{
			echo $reqId."***Data berhasil disimpan";
		}
		else
		{
			echo "xxx***Data gagal disimpan";
		}
	}

	function addasset()
	{
		$this->load->model("base-app/Operation");
		$this->load->model("base-app/Asset_Lccm");

		$reqId= $this->input->post("reqId");
		$reqMode= $this->input->post("reqMode");

		$reqElecCostH= $this->input->post("reqElecCostH");
		$reqEfficencyLoss= $this->input->post("reqEfficencyLoss");
		$reqTahun= $this->input->post("reqTahun");
		$reqAssetNum= $this->input->post("reqAssetNum");
		$reqEfficencyCost= $this->input->post("reqEfficencyCost");
		$reqElecCost= $this->input->post("reqElecCost");
		$reqOperationCost= $this->input->post("reqOperationCost");


		$set = new Operation();
		$set->setField("ELECT_LOSS", $reqElecCostH);
		$set->setField("EFF_LOSS", $reqEfficencyLoss);
		$set->setField("OPR_YEAR", $reqTahun);
		$set->setField("ASSETNUM", $reqAssetNum);

	
		$set->setField("COST_OF_ELECT_LOSS", ValToNullDB($reqElecCost));
		$set->setField("COST_OF_EFF_LOSS", ValToNullDB($reqEfficencyCost));
		$set->setField("OPERATION_COST", ValToNullDB($reqOperationCost));


		
		
		$reqSimpan= "";
		if ($reqMode == "insert")
		{
			$set->setField("LAST_CREATE_USER", $this->appusernama);
			$set->setField("LAST_CREATE_DATE", 'NOW()');

			if($set->insertasset())
			{
				$reqSimpan= 1;
			}

			unset($set);
		}
		else
		{	
			
			
			$set->setField("LAST_UPDATE_USER", $this->appusernama);
			$set->setField("LAST_UPDATE_DATE", 'NOW()');
			if($set->updateasset())
			{
				$reqSimpan= 1;
			}

			unset($set);
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

	function proses()
	{
		$this->load->model("base-app/Operation");
		$this->load->model("base-app/Asset_Lccm");

		$reqId= $this->input->post("reqId");
		$reqMode= $this->input->post("reqMode");

		$reqTahun= $this->input->get("reqTahun");

		$statement="";

		if(!empty($reqTahun))
		{
			$statement .= " AND A.OPR_YEAR='".$reqTahun."'";
		}

		$set= new Operation();
		$arrset= [];

		$reqSimpan="";

		
		$set->selectByParamsDetail(array(), -1,-1,$statement);
		// echo $set->query;exit;
		while($set->nextRow())
		{

			$reqEmploySalary=$set->getField("EMPLOY_SALARY_INFO");
			$reqElecLoss=$set->getField("ELECT_COST_INFO");
			$reqEffCost=$set->getField("EFF_COST_INFO");
			$reqOperationCost=$set->getField("OPERATION_COST_INFO");
			$reqAssetNum=$set->getField("ASSETNUM");
			

			$setinsert = new Operation();
			$setinsert->setField("EMPLOY_SALARY_ASSET", $reqEmploySalary);
			$setinsert->setField("COST_OF_ELECT_LOSS", $reqElecLoss);
			$setinsert->setField("COST_OF_EFF_LOSS", $reqEffCost);
			$setinsert->setField("OPERATION_COST", $reqOperationCost);
			$setinsert->setField("OPR_YEAR", $reqTahun);
			$setinsert->setField("ASSETNUM", $reqAssetNum);
			$setinsert->setField("LAST_UPDATE_USER", $this->appusernama);
			$setinsert->setField("LAST_UPDATE_DATE", 'NOW()');
			if($setinsert->updateassetdinamis())
			{
				$reqSimpan= 1;
			}
			
		}
		unset($set);


		if($reqSimpan == 1 )
		{
			echo $reqTahun."***Data berhasil diproses";
		}
		else
		{
			echo "xxx***Data gagal diproses";
		}
				
	}


	function delete()
	{
		$this->load->model("base-app/Operation");
		$set = new Operation();
		
		$reqId =  $this->input->get('reqId');
		$reqTahun =  $this->input->get('reqTahun');
		$reqCost =  $this->input->get('reqCost');

		$set->setField("ASSETNUM", $reqId);
		$set->setField("OPR_YEAR", $reqTahun);
		$set->setField("COST_ON_ASSET", $reqCost);

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


	function deleteasset()
	{
		$this->load->model("base-app/Operation");
		$set = new Operation();
		
		$reqTahun =  $this->input->get('reqTahun');
		$reqAssetNum =  $this->input->get('reqAssetNum');

		$set->setField("ASSETNUM", $reqAssetNum);
		$set->setField("OPR_YEAR", $reqTahun);

		if($set->deleteasset())
		{
			$arrJson["PESAN"] = "Data berhasil dihapus.";
		}
		else
		{
			$arrJson["PESAN"] = "Data gagal dihapus.";	
		}

		echo json_encode( $arrJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	
	}

	function hitung()
	{
		$this->load->model("base-app/Operation");
		$this->load->model("base-app/Asset_Lccm");

		$reqId= $this->input->post("reqId");
		$reqMode= $this->input->post("reqMode");

		$reqTahun= $this->input->get("reqTahun");
		$reqAssetNum= $this->input->get("reqAssetNum");
		$reqElecCostH= $this->input->get("reqElecCostH");
		$reqEfficencyLoss= $this->input->get("reqEfficencyLoss");

		$statement="";

		if(is_numeric($reqElecCostH) || is_numeric($reqElecCostH))
		{
			// print_r($reqElecCostH);exit();

			$set= new Operation();
			$arrset= [];

			$reqSimpan="";


			$reqSimpan= "";
			$sethitung = new Operation();
			$statement = " AND A.OPR_YEAR='".$reqTahun."' AND A.ASSETNUM='".$reqAssetNum."'";
			$sethitung->selectByParamsHitung(array(), -1,-1,$statement,$reqEfficencyLoss,$reqElecCostH);
			// echo $sethitung->query;exit;
			$sethitung->firstRow();

			$reqEmploySalary=$sethitung->getField("EMPLOY_SALARY_INFO");
			$reqElecLoss=$sethitung->getField("ELECT_COST_INFO");
			$reqEffCost=$sethitung->getField("EFF_COST_INFO");
			$reqOperationCost=$sethitung->getField("OPERATION_COST_INFO");
			$reqAssetNum=$sethitung->getField("ASSETNUM");
			unset($set);


			$arrJson=[];

			$arrJson["reqEmploySalary"] =$reqEmploySalary;
			$arrJson["reqElecLoss"] =$reqElecLoss;
			$arrJson["reqEffCost"] =$reqEffCost;
			$arrJson["reqOperationCost"] =$reqOperationCost;

			echo json_encode( $arrJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
		}
		else
		{
			echo 'xxx';
		}

		
	}

	

}