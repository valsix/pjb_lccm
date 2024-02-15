<?php
defined('BASEPATH') or exit('No direct script access allowed');

include_once("functions/default.func.php");
include_once("functions/string.func.php");
include_once("functions/date.func.php");
include_once("functions/class-list-util.php");
include_once("functions/class-list-util-serverside.php");

class Schedule_oh_json extends CI_Controller
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
		$this->load->model("base-app/ScheduleOh");

		$set= new ScheduleOh();

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
		$searchJson= "";

		$statement="";

	

		if(!empty($reqDistrikId))
		{
			$statement .= " AND A.KODE_DISTRIK='".$reqDistrikId."'";
		}

		if(!empty($reqBlokId))
		{
			$statement .= " AND A.KODE_BLOK='".$reqBlokId."'";
		}

		if(!empty($reqTahun))
		{
			$statement .= " AND A.OH_YEAR='".$reqTahun."'";
		}

		if(!empty($this->appblokunitid))
		{
			$statement.= " AND C.BLOK_UNIT_ID = ".$this->appblokunitid;
		}
		

		$sOrder = " ORDER BY A.OH_YEAR ASC ";
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
				else if ($valkey == "ENERGY_PRICE")
				{
					$row[$valkey]= "Rp. ".$set->getField($valkey);
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
		$this->load->model("base-app/ScheduleOh");
		$this->load->model("base-app/BlokUnit");
		$this->load->model("base-app/T_Preperation_Lccm");
		$this->load->model("base-app/OhLabourCost");

		$reqId= $this->input->post("reqId");
		$reqMode= $this->input->post("reqMode");

		$reqDistrikId= $this->input->post("reqDistrikId");
		$reqDistrikIdOld= $this->input->post("reqDistrikIdOld");
		$reqBlokId= $this->input->post("reqBlokId");
		$reqBlokIdOld= $this->input->post("reqBlokIdOld");
		$reqUnitMesinId= $this->input->post("reqUnitMesinId");
		$reqUnitMesinIdOld= $this->input->post("reqUnitMesinIdOld");
		$reqTahun= $this->input->post("reqTahun");
		$reqTahunOld= $this->input->post("reqTahunOld");
		$reqOhType= $this->input->post("reqOhType");
		$reqStatus= $this->input->post("reqStatus");


		// print_r($reqTahunAwal);exit;
		$set = new ScheduleOh();
		$set->setField("KODE_DISTRIK", $reqDistrikId);
		$set->setField("KODE_DISTRIK_OLD", $reqDistrikIdOld);

		$set->setField("KODE_BLOK", $reqBlokId);
		$set->setField("KODE_BLOK_OLD", $reqBlokIdOld);
		$set->setField("KODE_UNIT_M", $reqUnitMesinId);
		$set->setField("KODE_UNIT_M_OLD", $reqUnitMesinIdOld);
		$set->setField("OH_YEAR", $reqTahun);
		$set->setField("OH_YEAR_OLD", $reqTahunOld);
		$set->setField("OH_TYPE", $reqOhType);
		$set->setField("STATUS", $reqStatus);

		
		$reqSimpan= "";
		if ($reqMode == "insert")
		{

			$statement=" AND A.KODE_DISTRIK =  '".$reqDistrikId."' AND A.KODE_BLOK =  '".$reqBlokId."' AND A.KODE_UNIT_M =  '".$reqUnitMesinId."' AND A.OH_YEAR =  '".$reqTahun."' ";
			$check = new ScheduleOh();
			$check->selectByParams(array(), -1, -1, $statement);
				// echo $check->query;exit;
			$check->firstRow();
			$checkKode= $check->getField("KODE_DISTRIK");

			if(!empty($checkKode))
			{
				echo "xxx***Data Schedule Oh sudah ada";exit;	
			}

			$set->setField("LAST_CREATE_USER", $this->appusernama);
			$set->setField("LAST_CREATE_DATE", 'NOW()');

			if($set->insert())
			{
				$reqSimpan= 1;
				$reqId = $set->id;
			}
			

			unset($set);
			
		}
		else
		{	
			
			if($reqTahun != $reqTahunOld)
			{
				$statement=" AND A.KODE_DISTRIK =  '".$reqDistrikId."' AND A.KODE_BLOK =  '".$reqBlokId."' AND A.KODE_UNIT_M =  '".$reqUnitMesinId."' AND A.OH_YEAR =  '".$reqTahun."' ";
				$check = new ScheduleOh();
				$check->selectByParams(array(), -1, -1, $statement);
				// echo $check->query;exit;
				$check->firstRow();
				$checkKode= $check->getField("KODE_DISTRIK");

				if(!empty($checkKode))
				{
					echo "xxx***Data Schedule Oh sudah ada";exit;	
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
			$statement=" AND B.KODE_DISTRIK =  '".$reqDistrikId."' AND B.KODE_BLOK =  '".$reqBlokId."' AND B.KODE_UNIT_M =  '".$reqUnitMesinId."' AND A.OH_TYPE =  '".$reqOhType."' ";
			$check = new OhLabourCost();
			$check->selectByParams(array(), -1, -1, $statement);
				// echo $check->query;exit;
			$check->firstRow();
			$checkKode= $check->getField("ASSETNUM");

			unset($check);

			if(!empty($checkKode))
			{
				$reqSimpan="";
				$statement=" AND A.KODE_DISTRIK =  '".$reqDistrikId."' AND A.KODE_BLOK =  '".$reqBlokId."' AND A.KODE_UNIT_M =  '".$reqUnitMesinId."' AND A.YEAR_LCCM =  '".$reqTahun."' ";
				$check = new T_Preperation_Lccm();
				$check->selectByParams(array(), -1, -1, $statement);
					// echo $check->query;exit;
				$check->firstRow();
				$checkKode= $check->getField("YEAR_LCCM");

				$set = new T_Preperation_Lccm();
				$set->setField("KODE_DISTRIK", $reqDistrikId);
				$set->setField("KODE_BLOK", $reqBlokId);
				$set->setField("KODE_UNIT_M", $reqUnitMesinId);
				$set->setField("SITEID", $reqBlokId);
				$set->setField("YEAR_LCCM", $reqTahun);
				$set->setField("WO_CR", 'false' );
				$set->setField("WO_STANDING", 'false' );
				$set->setField("WO_PM", 'false' );
				$set->setField("WO_PDM", 'false' );
				$set->setField("WO_OH", 'true');
				$set->setField("PRK", 'false' );
				$set->setField("LOSS_OUTPUT", 'false' );
				$set->setField("OPERATION", 'false' );
				$set->setField("ENERGY_PRICE", 'false' );
				$set->setField("STATUS_COMPLETE", 'false' );

				if(!empty($checkKode))
				{

					$set->setField("LAST_UPDATE_USER", $this->appusernama);
					$set->setField("LAST_UPDATE_DATE", 'NOW()');
					if($set->updateoh())
					{
						$reqSimpan= 1;
					}

				}
				else
				{
					$set->setField("LAST_CREATE_USER", $this->appusernama);
					$set->setField("LAST_CREATE_DATE", 'NOW()');

					if($set->insertnew())
					{
						$reqSimpan= 1;
					}

				}

				unset($check);
				
			}
		}

		unset($set);

				

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
		$this->load->model("base-app/ScheduleOh");
		$set = new ScheduleOh();
		
		$reqId =  $this->input->get('reqId');
		$reqBlokId =  $this->input->get('reqBlokId');
		$reqMode =  $this->input->get('reqMode');

		$set->setField("OH_YEAR", $reqId);
		$set->setField("KODE_BLOK", $reqBlokId);
		$set->setField("KODE_DISTRIK", $reqBlokId);
		$set->setField("KODE_UNIT_M", $reqBlokId);

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