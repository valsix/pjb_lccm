<?php
defined('BASEPATH') or exit('No direct script access allowed');

include_once("functions/default.func.php");
include_once("functions/string.func.php");
include_once("functions/date.func.php");
include_once("functions/class-list-util.php");
include_once("functions/class-list-util-serverside.php");

class Asset_lccm_json extends CI_Controller
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
		// print_r($this->session->userdata);exit;
	}

	function json()
	{

		ini_set("memory_limit","512M");
		$this->load->model("base-app/Asset_Lccm");
		$this->load->model("base-app/BlokUnit");

		$set= new Asset_Lccm();

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
		$searchJson= "";

		$statement="";

		
		if(!empty($reqDistrikId))
		{
			$statement .= " AND A1.KODE_DISTRIK='".$reqDistrikId."'";
		}

		if(!empty($reqBlokId))
		{
			$statement .= " AND A1.KODE_BLOK='".$reqBlokId."'";
		}

		if(!empty($reqUnitMesinId))
		{
			$statement .= " AND A1.KODE_UNIT_M='".$reqUnitMesinId."'";
		}

		if(!empty($this->appblokunitid))
		{
			$statementnew= " AND A.BLOK_UNIT_ID = ".$this->appblokunitid;

			$setcheck= new BlokUnit();
			$setcheck->selectByParams(array(), $dsplyRange, $dsplyStart, $statementnew, $sOrder);
			$setcheck->firstRow();
			$reqKodeEam= $setcheck->getField("KODE_EAM");

			// if(!empty($reqKodeEam))
			// {
				$statement .= " AND ( C.BLOK_UNIT_ID = ".$this->appblokunitid." or a.siteid = '".$reqKodeEam."'  )";
			// }
		}



		$sOrder = " ORDER BY A1.ASSETNUM ASC ";
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
				else if ($valkey == "CAPITAL")
				{
					if ($set->getField('MCL_INFO')=='YES'){
						$row[$valkey]= '<span style="background-color:green;min-width:30px;color:white; padding: 10px">'. toThousandComma($set->getField($valkey)).'</span>';
					}
					else{
						$row[$valkey]=toThousandComma($set->getField($valkey));
					}
				}
				else if ($valkey == "CAPITAL_DATE")
				{
					if ($set->getField('MCL_INFO')=='YES'){
						$row[$valkey]= '<span style="background-color:green;min-width:30px;color:white; padding: 10px">'. $set->getField($valkey).'</span>';
					}
					else{
						$row[$valkey]=$set->getField($valkey);
					}
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
		$this->load->model("base-app/Asset_Lccm");

		$reqId= $this->input->post("reqId");
		$reqMode= $this->input->post("reqMode");

		// $reqAssetNum= $this->input->post("reqAssetNum");
		// $reqKksNo= $this->input->post("reqKksNo");
		// $reqDescription= $this->input->post("reqDescription");
		// $reqRbdId= $this->input->post("reqRbdId");
		// $reqParentAsset= $this->input->post("reqParentAsset");
		// $reqInstallDate= $this->input->post("reqInstallDate");
		// $reqAssetStatus= $this->input->post("reqAssetStatus");
		// // asset lccm
		
	
		// $reqCapitalDate= $this->input->post("reqCapitalDate");
		// $reqCapital= $this->input->post("reqCapital");


		// $set = new Asset_Lccm();
		// $set->setField("ASSETNUM", $reqAssetNum);
		// $set->setField("ASSETNUM_OLD", $reqAssetNumOld);
		// $set->setField("KKSNUM", $reqKksNo);
		// $set->setField("DESCRIPTION", $reqDescription);
		// $set->setField("RBD_ID", $reqRbdId);
		// $set->setField("PARENT", $reqParentAsset);
		// $set->setField("INSTALLDATE", dateToDBCheck($reqInstallDate));
		// $set->setField("STATUS", $reqAssetStatus);


		// $reqSimpan= "";
		// if ($reqMode == "insert")
		// {
		// 	$set->setField("LAST_CREATE_USER", $this->appusernama);
		// 	$set->setField("LAST_CREATE_DATE", 'NOW()');

		// 	if($set->insertasset())
		// 	{
		// 		$reqSimpan= 1;
		// 	}

		// 	unset($set);
		// }
		// else
		// {	
			
			
		// 	$set->setField("LAST_UPDATE_USER", $this->appusernama);
		// 	$set->setField("LAST_UPDATE_DATE", 'NOW()');
		// 	if($set->updateasset())
		// 	{
		// 		$reqSimpan= 1;
		// 	}

		// 	unset($set);
		// }
		$reqAssetNum= $this->input->post("reqAssetNum");
		$reqParentName= $this->input->post("reqParentName");
		$reqDistrikId= $this->input->post("reqDistrikId");
		$reqBlokId= $this->input->post("reqBlokId");
		$reqUnitMesinId= $this->input->post("reqUnitMesinId");
		$reqIsAsset= $this->input->post("reqIsAsset");
		$reqParentChild= $this->input->post("reqParentChild");
		$reqGroupPm= $this->input->post("reqGroupPm");
		$reqAssetOh= $this->input->post("reqAssetOh");
		$reqDistrikIdOld= $this->input->post("reqDistrikIdOld");
		$reqBlokIdOld= $this->input->post("reqBlokIdOld");
		$reqUnitMesinIdOld= $this->input->post("reqUnitMesinIdOld");

		$set = new Asset_Lccm();
		$set->setField("ASSETNUM", $reqAssetNum);
		$set->setField("PARENT", $reqParentName);
		$set->setField("KODE_DISTRIK", $reqDistrikId);
		$set->setField("KODE_BLOK", $reqBlokId);
		$set->setField("KODE_UNIT_M", $reqUnitMesinId);
		$set->setField("ASSET_LCCM", $reqIsAsset);
		$set->setField("PARENT_CHILD", $reqParentChild);
		$set->setField("GROUP_PM", $reqGroupPm);
		$set->setField("ASSET_OH", $reqAssetOh);
		$set->setField("KODE_DISTRIK_OLD", $reqDistrikIdOld);
		$set->setField("KODE_BLOK_OLD", $reqBlokIdOld);
		$set->setField("KODE_UNIT_M_OLD", $reqUnitMesinIdOld);


		$reqSimpan= "";
		if ($reqMode == "insert")
		{
			$set->setField("LAST_CREATE_USER", $this->appusernama);
			$set->setField("LAST_CREATE_DATE", 'NOW()');

			if($set->insertassetlccm())
			{
				$reqSimpan= 1;
			}

			unset($set);
		}
		else
		{	


			$set->setField("LAST_UPDATE_USER", $this->appusernama);
			$set->setField("LAST_UPDATE_DATE", 'NOW()');
			if($set->updateassetlccm())
			{
				$reqSimpan= 1;
			}

			unset($set);
		}

		if($reqSimpan==1)
		{

			$reqCapitalDateA= $this->input->post("reqCapitalDate");
			$reqCapitalDate=date("Y-m-d", strtotime($reqCapitalDateA)); 
			$reqCapital= $this->input->post("reqCapital");
			$reqCapitalDateOld= $this->input->post("reqCapitalDateOld");
			$reqAssetNumOld= $this->input->post("reqAssetNumOld");

			$set = new Asset_Lccm();
			$set->setField("CAPITAL_DATE", dateToDBCheck($reqCapitalDateA));
			$set->setField("CAPITAL_DATE_OLD", $reqCapitalDateOld);
			$set->setField("CAPITAL", valToNullDB(str_replace(',', '', $reqCapital)));
			$set->setField("ASSETNUM", $reqAssetNum);
			$set->setField("ASSETNUM_OLD", $reqAssetNumOld);
			$set->setField("STATUS", "true");
			$set->setField("KODE_DISTRIK", $reqDistrikId);
			$set->setField("KODE_BLOK", $reqBlokId);
			$set->setField("KODE_UNIT_M", $reqUnitMesinId);

			$statement=" AND A.ASSETNUM =  '".$reqAssetNum."' AND A.CAPITAL_DATE =  '".$reqCapitalDate."' ";
			$check = new Asset_Lccm();
			$check->selectByParamsCapital(array(), -1, -1, $statement);
			// echo $check->query;exit;
			$check->firstRow();
			$checkKode= $check->getField("CAPITAL_DATE");

			if(empty($checkKode))
			{
				$reqMode = "insert";
			}
			else
			{
				$reqMode = "update";

			}
			
			

			$reqSimpan= "";
			if ($reqMode == "insert")
			{
				$set->setField("LAST_CREATE_USER", $this->appusernama);
				$set->setField("LAST_CREATE_DATE", 'NOW()');

				if($set->insertcapital())
				{
					$reqSimpan= 1;
				}

				unset($set);
			}
			else
			{	

				// $set->setField("STATUS", "false");
				$set->setField("LAST_UPDATE_USER", $this->appusernama);
				$set->setField("LAST_UPDATE_DATE", 'NOW()');
				if($set->updatecapital())
				{
					$reqSimpan= 1;
				}

				// $set = new Asset_Lccm();
				// $set->setField("CAPITAL_DATE", dateToDBCheck($reqCapitalDateA));
				// $set->setField("CAPITAL_DATE_OLD", $reqCapitalDateOld);
				// $set->setField("CAPITAL", valToNullDB($reqCapital));
				// $set->setField("ASSETNUM", $reqAssetNum);
				// $set->setField("ASSETNUM_OLD", $reqAssetNumOld);
				// $set->setField("STATUS", "true");

				// $set->setField("LAST_CREATE_USER", $this->appusernama);
				// $set->setField("LAST_CREATE_DATE", 'NOW()');

				// if($set->insertcapital())
				// {
				// 	$reqSimpan= 1;
				// }

				// unset($set);
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


	function filter_asset()
	{
		$this->load->model("base-app/Asset_Lccm");
		ini_set("memory_limit","256M");

		$reqDistrikId =  $this->input->get('reqDistrikId');
		$reqBlokId =  $this->input->get('reqBlokId');

		// print_r($reqDistrikId);exit;
		
		
		$statement="";
		if(!empty($reqDistrikId))
		{
			$statement =" AND A.KODE_DISTRIK  = '".$reqDistrikId."'";
		}

		if(!empty($reqBlokId))
		{
			$statement =" AND A.KODE_BLOK  = '".$reqBlokId."'";
		}

		$set= new Asset_Lccm();
		$arrset= [];

		
		$set->selectByParams(array(), -1,-1,$statement);
		// echo $set->query;exit;
		while($set->nextRow())
		{
			$arrdata= array();
			$arrdata["ASSETNUM"]= $set->getField("ASSETNUM");
			// $arrdata["text"]= $set->getField("KODE")." - ". $set->getField("NAMA");
			// $arrdata["KODE"]= $set->getField("KODE");
			array_push($arrset, $arrdata);
		}
		unset($set);
		echo json_encode( $arrset, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	

	}

	

}