<?php
defined('BASEPATH') or exit('No direct script access allowed');

include_once("functions/default.func.php");
include_once("functions/string.func.php");
include_once("functions/date.func.php");
include_once("functions/class-list-util.php");
include_once("functions/class-list-util-serverside.php");

class Work_order_json extends CI_Controller
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
		$this->load->model("base-app/WorkOrder");

		$set= new WorkOrder();

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
		$reqAssetNum= $this->input->get("reqAssetNum");


		$searchJson= "";

		$statement="";

		
		if(!empty($reqDistrikId))
		{
			$statement .= " AND B.KODE_DISTRIK='".$reqDistrikId."'";
		}

		if(!empty($reqBlokId))
		{
			$statement .= " AND B.KODE_BLOK='".$reqBlokId."'";
		}

		if(!empty($reqUnitMesinId))
		{
			$statement .= " AND B.KODE_UNIT_M='".$reqUnitMesinId."'";
		}

		
		if(!empty($reqAssetNum))
		{
			$reqAssetNum = explode(",", $reqAssetNum);
			$reqAssetNum = "'" . implode("', '", $reqAssetNum) ."'";
			$statement .= " AND A.ASSETNUM IN (".$reqAssetNum.")";
		}

		if(!empty($reqStatus))
		{
			if($reqStatus=='null')
			{
				$statement .= " AND C.WO_CR is null";
			}
			else
			{
				$statement .= " AND C.WO_CR='".$reqStatus."'";
			}
			
		}

	
		$sOrder = " ORDER BY wo_year ASC ";
		$set->selectByParamsTahun(array(), $dsplyRange, $dsplyStart, $statement.$searchJson, $sOrder);

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

	function jsonvalidasi()
	{
		ini_set('max_execution_time', 500);
		ini_set("memory_limit", "-1"); 

		
		$this->load->model("base-app/WorkOrder");

		$set= new WorkOrder();

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
		$reqStatus= $this->input->get("reqStatus");
		$reqAssetNum= $this->input->get("reqAssetNum");
		$reqApprovalStatus=$this->input->get("reqApprovalStatus");

		$searchJson= "";

		$statement="";

		
		if(!empty($reqDistrikId))
		{
			$statement .= " AND B.KODE_DISTRIK='".$reqDistrikId."'";
		}

		if(!empty($reqBlokId))
		{
			$statement .= " AND B.KODE_BLOK='".$reqBlokId."'";
		}

		if(!empty($reqUnitMesinId))
		{
			$statement .= " AND B.KODE_UNIT_M='".$reqUnitMesinId."'";
		}

		
		if(!empty($reqAssetNum))
		{
			$reqAssetNum = explode(",", $reqAssetNum);
			$reqAssetNum = "'" . implode("', '", $reqAssetNum) ."'";
			$statement .= " AND A.ASSETNUM IN (".$reqAssetNum.")";
		}

		if(!empty($reqTahun))
		{
			$statement .= " AND wo_year='".$reqTahun."'";
		}

		if(!empty($reqApprovalStatus))
		{
			$statement .= " AND A.APPROVAL_STATUS ='".$reqApprovalStatus."'";
		}
		else
		{
			$statement .= " AND A.APPROVAL_STATUS IS NULL";

		}


		

		$sOrder = " ORDER BY wo_year ASC ";
		$set->selectByParamsDetail(array(), $dsplyRange, $dsplyStart, $statement.$searchJson, $sOrder);

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
				else if ($valkey == "COST_ON_ASSET" || $valkey == "VALUE_PAID" )
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



	function jsonjexcel()
	{
		ini_set('max_execution_time', 500);
		ini_set("memory_limit", "-1"); 

		
		$this->load->model("base-app/WorkOrder");

		$set= new WorkOrder();



		$reqTahun= $this->input->get("reqTahun");
		$reqGroupPm= $this->input->get("reqGroupPm");
		$reqTahun= $this->input->get("reqTahun");
		$reqDistrikId= $this->input->get("reqDistrikId");
		$reqBlokId= $this->input->get("reqBlokId");
		$reqUnitMesinId= $this->input->get("reqUnitMesinId");
		$reqStatus= $this->input->get("reqStatus");
		$reqAssetNum= $this->input->get("reqAssetNum");
		$searchJson= "";

		$statement="";

		
		if(!empty($reqDistrikId))
		{
			$statement .= " AND B.KODE_DISTRIK='".$reqDistrikId."'";
		}

		if(!empty($reqBlokId))
		{
			$statement .= " AND B.KODE_BLOK='".$reqBlokId."'";
		}

		if(!empty($reqUnitMesinId))
		{
			$statement .= " AND B.KODE_UNIT_M='".$reqUnitMesinId."'";
		}

		
		if(!empty($reqAssetNum))
		{
			$reqAssetNum = explode(",", $reqAssetNum);
			$reqAssetNum = "'" . implode("', '", $reqAssetNum) ."'";
			$statement .= " AND A.ASSETNUM IN (".$reqAssetNum.")";
		}
		if(!empty($reqTahun))
		{
			$statement .= " AND wo_year='".$reqTahun."'";
		}

		if(!empty($reqStatus))
		{
			if($reqStatus=="all")
			{}
			else
			{
				if($reqStatus=="X")
				{
					$statement .= " AND A.WOSTATUS IS NULL";
				}
				else
				{
					$statement .= " AND A.WOSTATUS='".$reqStatus."'";
				}

			}
		}

		$statement .= " AND A.APPROVAL_STATUS IS NULL";


		$arrResult= [];

		$sOrder = " ORDER BY wo_year ASC ";
		$set->selectByParamsDetail(array(), $dsplyRange, $dsplyStart, $statement.$searchJson, $sOrder);

		// echo $set->query;exit;
		while($set->nextRow())
		{
			$WORKTYPE=$set->getField("WORKTYPE");
			$NEEDDOWNTIME=$set->getField("NEEDDOWNTIME");
			$JPNUM=$set->getField("JPNUM");
			$VALIDATION_DOWNTIME="";
			$STATUS_NOT_OH_NOT_DOWNTIME=$set->getField("STATUS_NOT_OH_NOT_DOWNTIME");
			$REPORT_DOWN_TIME=$set->getField("REPORT_DOWN_TIME");
			$JUMLAH_LABOR=$set->getField("JUMLAH_LABOR");
			$ON_HAND_REPAIR=$set->getField("ON_HAND_REPAIR");
			$ACTUAL_REPAIR_TIME=$set->getField("ACTUAL_REPAIR_TIME");
			$ACTSTART=$set->getField("ACTSTART");
			$ACTFINISH=$set->getField("ACTFINISH");
			// $JUMLAH_LABOR="";

			if($WORKTYPE=="CM" || $WORKTYPE=="EM" || $WORKTYPE=="PAM")
			{
				if($NEEDDOWNTIME=='1' && $REPORT_DOWN_TIME =="DOWN")
				{
					$VALIDATION_DOWNTIME='1-1';
				}
				else if($NEEDDOWNTIME=='0' && $REPORT_DOWN_TIME =="DOWN")
				{
					$VALIDATION_DOWNTIME='1-1';
				}
				else if($NEEDDOWNTIME=='1' && $REPORT_DOWN_TIME =="")
				{
					$VALIDATION_DOWNTIME='0-0';
				}
				else
				{
					$VALIDATION_DOWNTIME='0-0';
				}
			}
			else if($WORKTYPE=="PM" || $WORKTYPE=="OH" || $WORKTYPE=="PDM")
			{
				if(!empty($JPNUM))
				{
					$VALIDATION_DOWNTIME='0-1';
				}
				else 
				{
					$VALIDATION_DOWNTIME='0-0';
				}
			}
			else
			{
				$VALIDATION_DOWNTIME='0-1';
			}

			$VALIDATION_DOWNTIME_KON=explode('-', $VALIDATION_DOWNTIME);
			$VALIDATION_DOWNTIME_KON=$VALIDATION_DOWNTIME[0];
			// print_r($VALIDATION_DOWNTIME_KON);exit;

			if($VALIDATION_DOWNTIME_KON=="0" && $WORKTYPE=="OH" && empty($JPNUM))
			{
				$STATUS_NOT_OH_NOT_DOWNTIME="0-1";
			}
			else if($VALIDATION_DOWNTIME_KON=="0" &&  $WORKTYPE!=="OH")
			{
				$STATUS_NOT_OH_NOT_DOWNTIME="1-1";
			}

			
			// $checkbgk=3;
			if(empty($ON_HAND_REPAIR))
			{
				if(!empty($ACTUAL_REPAIR_TIME))
				{
					// $checkbgk=1;

					$ON_HAND_REPAIR=$ACTUAL_REPAIR_TIME."-0";
				}
				else
				{
					$dteStart = new DateTime($ACTFINISH); 
					$dteEnd   = new DateTime($ACTSTART); 
					$dteDiff  = $dteStart->diff($dteEnd); 
					// print_r($dteDiff);exit;
					$ON_HAND_REPAIR=decimalHours($dteDiff->format("%H:%I:%S"),1);
					$ON_HAND_REPAIR=$ON_HAND_REPAIR."-0";
				}
			}
			else
			{
				// $ON_HAND_REPAIR >= 72;

				if($ON_HAND_REPAIR >= 72)
				{
					$ON_HAND_REPAIR=$ON_HAND_REPAIR."-0";
				}
				else
				{
					$ON_HAND_REPAIR=$ON_HAND_REPAIR."-1";
				}
				// $checkbgk=1;
			}


			if($VALIDATION_DOWNTIME_KON=="1" && ($JUMLAH_LABOR == 0   ||  empty($JUMLAH_LABOR)))
			{
				$JUMLAH_LABOR=$JUMLAH_LABOR;
			}
			

			$arrdata= array();
			$arrdata["ASSETNUM"]= $set->getField("ASSETNUM");
			$arrdata["EQUIPMENT_DESC"]= $set->getField("EQUIPMENT_DESC");
			$arrdata["WONUM"]= $set->getField("WONUM");
			$arrdata["WO_DESC"]= $set->getField("WO_DESC");
			$arrdata["WORKTYPE"]= $set->getField("WORKTYPE");
			$arrdata["WORK_GROUP"]= $set->getField("WORK_GROUP");
			$arrdata["NEEDDOWNTIME"]= $set->getField("NEEDDOWNTIME");
			$arrdata["REPORTDATE"]= $set->getField("REPORTDATE");
			$arrdata["DOWNTIME_INFO"]= $VALIDATION_DOWNTIME;
			$arrdata["DOWN_NOT_INFO"]= $STATUS_NOT_OH_NOT_DOWNTIME;
			$arrdata["ON_HAND_INFO"]= $ON_HAND_REPAIR;
			$arrdata["LABOUR_INFO"]= $JUMLAH_LABOR;
			$arrdata["WOSTATUSINFO"]= $set->getField("WOSTATUSINFO");
			$arrdata["SITEID"]= $set->getField("SITEID");
			$arrdata["KODE_DISTRIK"]= $set->getField("KODE_DISTRIK");
			$arrdata["KODE_BLOK"]= $set->getField("KODE_BLOK");
			$arrdata["KODE_UNIT_M"]= $set->getField("KODE_UNIT_M");
			$arrdata["JPNUM"]= $set->getField("JPNUM");



			array_push($arrResult, $arrdata);
		}
		unset($set);


		header('Content-Type: application/json');
		echo json_encode( $arrResult, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	
	}

	

	function rekapwo()
	{
		ini_set('max_execution_time', 500);
		ini_set("memory_limit", "-1"); 

		
		$this->load->model("base-app/WorkOrder");

		$set= new WorkOrder();



		$reqTahun= $this->input->get("reqTahun");
		$reqGroupPm= $this->input->get("reqGroupPm");
		$reqTahun= $this->input->get("reqTahun");
		$reqDistrikId= $this->input->get("reqDistrikId");
		$reqBlokId= $this->input->get("reqBlokId");
		$reqUnitMesinId= $this->input->get("reqUnitMesinId");
		$reqStatus= $this->input->get("reqStatus");
		$reqAssetNum= $this->input->get("reqAssetNum");
		$searchJson= "";

		$statement="";

		$arrResult=array();

		
		if(!empty($reqDistrikId))
		{
			$statement .= " AND B.KODE_DISTRIK='".$reqDistrikId."'";
		}

		if(!empty($reqBlokId))
		{
			$statement .= " AND B.KODE_BLOK='".$reqBlokId."'";
		}

		if(!empty($reqUnitMesinId))
		{
			$statement .= " AND B.KODE_UNIT_M='".$reqUnitMesinId."'";
		}

		

		$set= new WorkOrder();
		$set->jumlahasset(array(), -1, -1, $statement);
		// echo $set->query;exit;
		$set->firstRow();
		$reqJmlAsset= $set->getField("JUMLAH");
		unset($set);

		$set= new WorkOrder();

		$statement=" AND APPROVAL_STATUS IS NULL";

		if(!empty($reqDistrikId))
		{
			$statement .= " AND B.KODE_DISTRIK='".$reqDistrikId."'";
		}

		if(!empty($reqBlokId))
		{
			$statement .= " AND B.KODE_BLOK='".$reqBlokId."'";
		}

		if(!empty($reqUnitMesinId))
		{
			$statement .= " AND B.KODE_UNIT_M='".$reqUnitMesinId."'";
		}
		$set->jumlahwo(array(), -1, -1, $statement);
		// echo $set->query;exit;
		$set->firstRow();
		$reqJmlNon= $set->getField("JUMLAH");
		unset($set);

		
		$set= new WorkOrder();
		$statement="";
		if(!empty($reqDistrikId))
		{
			$statement .= " AND B.KODE_DISTRIK='".$reqDistrikId."'";
		}

		if(!empty($reqBlokId))
		{
			$statement .= " AND B.KODE_BLOK='".$reqBlokId."'";
		}

		if(!empty($reqUnitMesinId))
		{
			$statement .= " AND B.KODE_UNIT_M='".$reqUnitMesinId."'";
		}
		$set->jumlahassetwo(array(), -1, -1, $statement);
		// echo $set->query;exit;
		$set->firstRow();
		$reqJmlAssetWo= $set->getField("JUMLAH");
		unset($set);

		$set= new WorkOrder();
		$statement=" ";

		if(!empty($reqDistrikId))
		{
			$statement .= " AND B.KODE_DISTRIK='".$reqDistrikId."'";
		}

		if(!empty($reqBlokId))
		{
			$statement .= " AND B.KODE_BLOK='".$reqBlokId."'";
		}

		if(!empty($reqUnitMesinId))
		{
			$statement .= " AND B.KODE_UNIT_M='".$reqUnitMesinId."'";
		}

		$set->jumlahassetlccm(array(), -1, -1, $statement);
		// echo $set->query;exit;
		$set->firstRow();
		$reqJmlAssetLccm= $set->getField("JUMLAH");
		unset($set);


		$arrResult["reqJmlAsset"] =$reqJmlAsset;
		$arrResult["reqJmlAssetWo"] =$reqJmlAssetWo;
		$arrResult["reqJmlNon"] =$reqJmlNon;
		$arrResult["reqJmlAssetLccm"] =$reqJmlAssetLccm;

		// print_r($arrResult);exit;


		header('Content-Type: application/json');
		echo json_encode( $arrResult, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	
	}


	function addvalidasi()
	{
		$this->load->model("base-app/WorkOrder");

		$reqArrValue= $this->input->post("reqArrValue");
		$reqArrValueBefore= $this->input->post("reqArrValueBefore");
		$reqTahun= $this->input->post("reqTahun");

		$reqArrValue=json_decode($reqArrValue);
		$reqArrValueBefore=json_decode($reqArrValueBefore);
		$reqArrValueCheck=$reqArrValue;
		// print_r($reqArrValue);exit;
		$checkstatus="";
		$baris="";
		foreach ($reqArrValue as $key => $value) {
			$reqJumlahLabor=$value[11];
			$reqOnHandRepair = explode("-", $value[11])[0];
			$reqDown0 = explode("-", $value[9])[0];
			$reqDownTime = explode("-", $value[8])[0];

			// var_dump($reqDownTime);
			$baris=$key+1;
			if(!is_numeric($reqDownTime))
			{
				echo "xxx***Kolom Validation Downtime Baris ".$baris." Wajib diisi";exit;
			}

			if(!is_numeric($reqDown0))
			{
				echo "xxx***Kolom DOWN 0 & NOT OH Baris ".$baris." Wajib diisi";exit;
			}

			if(!is_numeric($reqOnHandRepair))
			{
				echo "xxx***Kolom On Hand Repair Baris ".$baris." Wajib diisi";exit;
			}

			if(!is_numeric($reqJumlahLabor))
			{
				echo "xxx***Kolom Labor Baris ".$baris." Wajib diisi";exit;
			}
			
		}


		foreach ($reqArrValue as $key => $value) {
			$set = new WorkOrder();
			$reqJumlahLabor=$value[11];
			$reqOnHandRepair = explode("-", $value[11])[0];
			$reqDown0 = explode("-", $value[9])[0];
			$reqDownTime = explode("-", $value[8])[0];
			$set->setField("ASSETNUMOLD", $reqArrValueBefore[$key][0]);
			$set->setField("ASSETNUM", $value[0]);
			$set->setField("WONUM", $value[2]);
			$set->setField("TAHUN", $reqTahun);
			$set->setField("VALIDATION_DOWNTIME", valToNullDB($reqDownTime));
			$set->setField("STATUS_NOT_OH_NOT_DOWNTIME", valToNullDB($reqDown0));
			$set->setField("ON_HAND_REPAIR", valToNullDB($reqOnHandRepair));
			$set->setField("SITEID", $value[13]);
			if($reqJumlahLabor=='xxx')
			{
				$reqJumlahLabor="";
			}
			if($value[12]==true)
			{
				$checkstatus="1";
			}

			if($value[12]==true)
			{
				$reqApprovalStatus="1";
			}
			else
			{
				$reqApprovalStatus="";
			}
			// var_dump($value[11]);

			$set->setField("JUMLAH_LABOR", valToNullDB($reqJumlahLabor));
			$set->setField("APPROVAL_STATUS", ValToNullDB($reqApprovalStatus));

			$set->setField("LAST_UPDATE_USER", $this->appusernama);
			$set->setField("LAST_UPDATE_DATE", 'NOW()');
			if($set->updatevalidasi())
			{
				$reqSimpan= 1;
			}

			
		}


		foreach ($reqArrValue as $key => $value) {
			// $setcheck = new WorkOrder();
			$reqAssetNum=$value[0];
			$reqSiteId=$value[13];
			$reqKodeDistrik=$value[14];
			$reqKodeBlok=$value[15];
			$reqKodeUnit=$value[16];

			$setcheck = new WorkOrder();

			$statement=" AND C.ASSETNUM ='".$reqAssetNum."' AND A.KODE_DISTRIK ='".$reqKodeDistrik."' AND A.KODE_BLOK ='".$reqKodeBlok."'  AND A.KODE_UNIT_M ='".$reqKodeUnit."'";
			$setcheck->selectByParamsCheckStatus(array(), -1, -1, $statement);
			// echo $setcheck->query;exit;
			$setcheck->firstRow();
			$reqWoCr= $setcheck->getField("WO_CR");

			if($reqSimpan==1 && $checkstatus && $reqWoCr =="f")
			{
				$set = new WorkOrder();
				$set->setField("WO_CR", 'true');
				$set->setField("YEAR_LCCM", $reqTahun);
				$set->setField("KODE_DISTRIK", $reqKodeDistrik);
				$set->setField("KODE_BLOK", $reqKodeBlok);
				$set->setField("KODE_UNIT_M", $reqKodeUnit);
				if($set->updateprep())
				{
					$reqSimpan= 1;
				}
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

	function addview()
	{
		$this->load->model("base-app/WorkOrder");
		$this->load->model("base-app/Asset_Lccm");

		$reqId= $this->input->post("reqId");
		$reqMode= $this->input->post("reqMode");

		$reqTahun= $this->input->post("reqTahun");
		$reqAssetNumOld= $this->input->post("reqAssetNumOld");
		$reqWoNumOld= $this->input->post("reqWoNumOld");

		$reqAssetNum= $this->input->post("reqAssetNum");
		$reqDesc= $this->input->post("reqDesc");
		$reqWoNum= $this->input->post("reqWoNum");
		$reqWoDesc= $this->input->post("reqWoDesc");
		$reqWorkType= $this->input->post("reqWorkType");
		$reqWoGroup= $this->input->post("reqWoGroup");
		$reqDowntime= $this->input->post("reqDowntime");
		$reqDownNot= $this->input->post("reqDownNot");
		$reqOnHandRepair= $this->input->post("reqOnHandRepair");
		$reqLabor= $this->input->post("reqLabor");



		$set = new WorkOrder();
		$set->setField("ASSETNUM", $reqAssetNum);
		$set->setField("ASSETNUM_OLD", $reqAssetNumOld);
		$set->setField("EQUIPMENT_DESC", $reqDesc);
		$set->setField("WONUM", $reqWoNum);
		$set->setField("WONUM_OLD", $reqWoNumOld);
		$set->setField("WO_DESC", $reqWoDesc);
		$set->setField("WORKTYPE", $reqWorkType);
		$set->setField("WORK_GROUP", $reqWoGroup);
		$set->setField("VALIDATION_DOWNTIME", $reqDowntime);
		$set->setField("STATUS_NOT_OH_NOT_DOWNTIME", $reqDownNot);
		$set->setField("ON_HAND_REPAIR", $reqOnHandRepair);
		$set->setField("JUMLAH_LABOR", $reqLabor);


		$set->setField("WO_YEAR", $reqTahun);

		$statement=" AND A.ASSETNUM =  '".$reqAssetNum."' ";
		$check = new Asset_Lccm();
		$check->selectByParams(array(), -1, -1, $statement);
			// echo $check->query;exit;
		$check->firstRow();
		$checkKode= $check->getField("ASSETNUM");

		if(empty($checkKode))
		{
			echo "xxx***Equipment No ".$checkKode." tidak ditemukan pada data asset lccm";exit;	
		}

		
		$reqSimpan= "";
		if ($reqMode == "insert")
		{
			$set->setField("LAST_CREATE_USER", $this->appusernama);
			$set->setField("LAST_CREATE_DATE", 'NOW()');

			// if($set->insert())
			// {
			// 	$reqSimpan= 1;
			// }

			unset($set);
		}
		else
		{	
			
			
			$set->setField("LAST_UPDATE_USER", $this->appusernama);
			$set->setField("LAST_UPDATE_DATE", 'NOW()');
			if($set->updatewovalid())
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


	function delete()
	{
		$this->load->model("base-app/WorkOrder");
		$set = new WorkOrder();
		
		$reqId =  $this->input->get('reqId');
		$reqTahun =  $this->input->get('reqTahun');
		$reqCost =  $this->input->get('reqCost');

		$set->setField("ASSETNUM", $reqId);
		$set->setField("PRK_YEAR", $reqTahun);
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

	

}