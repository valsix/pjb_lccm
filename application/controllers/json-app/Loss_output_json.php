<?php
defined('BASEPATH') or exit('No direct script access allowed');

include_once("functions/default.func.php");
include_once("functions/string.func.php");
include_once("functions/date.func.php");
include_once("functions/class-list-util.php");
include_once("functions/class-list-util-serverside.php");

class Loss_output_json extends CI_Controller
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

		$this->configtitle= $this->config->config["configtitle"];
		// print_r($this->configtitle);exit;
	}

	function json()
	{
		$this->load->model("base-app/LossOutput");

		$set= new LossOutput();

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

		$searchJson= "";

		$statement="";

		
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

		if(!empty($this->appblokunitid))
		{
			$statement.= " AND D.BLOK_UNIT_ID = ".$this->appblokunitid;
		}

		if(!empty($reqStatus))
		{
			$statement .= " AND A.loss_output='".$reqStatus."'";
		}

		$sOrder = " ORDER BY A.YEAR_LCCM ASC ";
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

	function jsondetail()
	{
		$this->load->model("base-app/LossOutput");

		$set= new LossOutput();

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

		if(!empty($reqTahun))
		{
			$statement .= " AND A.LO_YEAR='".$reqTahun."'";
		}

		if(!empty($reqGroupPm))
		{
			$statement .= " AND B.GROUP_PM='".$reqGroupPm."'";
		}

		
		if(!empty($this->appblokunitid))
		{
			$statement.= " AND D.BLOK_UNIT_ID = ".$this->appblokunitid;
		}

		$sOrder = " ORDER BY A.LO_YEAR ASC ";
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
				else if ($valkey == "DURATION_HOURS")
				{
					$duration=toThousandNew($set->getField("DURATION_HOURS"));
					$row[$valkey]= $duration;
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

	function add()
	{
		$this->load->model("base-app/LossOutput");
		$this->load->model("base-app/Asset_Lccm");

		$reqId= $this->input->post("reqId");
		$reqMode= $this->input->post("reqMode");

		$reqAssetNum= $this->input->post("reqAssetNum");
		$reqStart= $this->input->post("reqStart");
		$reqEnd= $this->input->post("reqEnd");
		$reqDuration= $this->input->post("reqDuration");
		$reqLoadDerating= $this->input->post("reqLoadDerating");
		$reqTahun= $this->input->post("reqTahun");
		$reqStatus= $this->input->post("reqStatus");
		$reqAssetNumOld= $this->input->post("reqAssetNumOld");
		$reqStartOld= $this->input->post("reqStartOld");
		$reqEndOld= $this->input->post("reqEndOld");
		$reqStatusBaru= $this->input->post("reqStatusBaru");


		$set = new LossOutput();
		$set->setField("ASSETNUM", $reqAssetNum);
		$set->setField("ASSETNUM_OLD", $reqAssetNumOld);
		$set->setField("START_DATE", dateTimeToDBCheckNew($reqStart));
		$set->setField("START_DATE_OLD", $reqStartOld);
		$set->setField("STOP_DATE", dateTimeToDBCheckNew($reqEnd));
		$set->setField("STOP_DATE_OLD", $reqEndOld);
		$set->setField("DURATION_HOURS", ValToNullDB(str_replace(',', '.', $reqDuration)));
		$set->setField("LOAD_DERATING", ValToNullDB($reqLoadDerating));
		$set->setField("LO_YEAR", $reqTahun);
		if($reqStatus)
		{
			$set->setField("STATUS", $reqStatus);
		}
		else
		{
			$set->setField("STATUS", $reqStatusBaru);
		}
		

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

			if($set->insert())
			{
				$reqSimpan= 1;
			}

			unset($set);
		}
		else
		{	
			
			
			$set->setField("LAST_UPDATE_USER", $this->appusernama);
			$set->setField("LAST_UPDATE_DATE", 'NOW()');
			if($set->update())
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
		$this->load->model("base-app/LossOutput");
		$set = new LossOutput();
		
		$reqId =  $this->input->get('reqId');
		$reqTahun =  $this->input->get('reqTahun');
		$reqStart =  $this->input->get('reqStart');
		$reqEnd =  $this->input->get('reqEnd');

		$set->setField("ASSETNUM", $reqId);
		$set->setField("LO_YEAR", $reqTahun);
		$set->setField("START_DATE", $reqStart);
		$set->setField("STOP_DATE", $reqEnd);

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