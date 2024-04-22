<?php
defined('BASEPATH') or exit('No direct script access allowed');

include_once("functions/default.func.php");
include_once("functions/string.func.php");
include_once("functions/date.func.php");
include_once("functions/class-list-util.php");
include_once("functions/class-list-util-serverside.php");

class Lccm_json extends CI_Controller
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
		$this->load->model("base-app/T_Lccm_Prj");

		$set= new T_Lccm_Prj();

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
				$statement .= " AND A.STATUS = ''";
			}
			else
			{
				$statement .= " AND A.STATUS ='".$reqStatus."'";
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


	function add()
	{
		$this->load->model("base-app/T_Lccm_Prj");


		$reqId= $this->input->post("reqId");

		// print_r($reqId);exit;
		$reqMode= $this->input->post("reqMode");

		$reqDistrikId= $this->input->post("reqDistrikId");
		$reqBlokId= $this->input->post("reqBlokId");
		$reqUnitMesinId= $this->input->post("reqUnitMesinId");

		$reqPrediction= $this->input->post("reqPrediction");
		$reqHistoryYearStart= $this->input->post("reqHistoryYearStart");
		$reqHistoryYearEnd= $this->input->post("reqHistoryYearEnd");
		$reqDiscount= $this->input->post("reqDiscount");
		$reqPlant= $this->input->post("reqPlant");
		$reqProjectNo= $this->input->post("reqProjectNo");
		$reqProjectDesc= $this->input->post("reqProjectDesc");

		$reqProjectNoOld= $this->input->post("reqProjectNoOld");

		$set = new T_Lccm_Prj();
		$set->setField("KODE_DISTRIK", $reqDistrikId);
		$set->setField("KODE_BLOK", $reqBlokId);
		$set->setField("KODE_UNIT_M", $reqUnitMesinId);


		$set->setField("PROJECT_NAME", $reqProjectNo);
		$set->setField("PROJECT_DESC", $reqProjectDesc);
		$set->setField("LCCM_START_HIST_YEAR", $reqHistoryYearStart);
		$set->setField("LCCM_END_HIST_YEAR", $reqHistoryYearEnd);
		$set->setField("LCCM_PREDICT_YEAR", $reqPrediction);
		$set->setField("DISC_RATE", $reqDiscount);
		$set->setField("HIST_INFLASI_RATE", 1);
		$set->setField("ANNUAL_INFLASI_RATE", 1);
		$set->setField("PLANT_CAPITAL_COST", $reqPlant);
		$set->setField("SITEID", "");
		
		$set->setField("PROJECT_NAME_OLD", $reqProjectNoOld);

		$reqSimpan= "";
		if ($reqId == "")
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

	

}