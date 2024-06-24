<?php
defined('BASEPATH') or exit('No direct script access allowed');

include_once("functions/default.func.php");
include_once("functions/string.func.php");
include_once("functions/date.func.php");
include_once("functions/class-list-util.php");
include_once("functions/class-list-util-serverside.php");

class project_json extends CI_Controller
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
		$this->load->model("base-app/T_Project_Lccm_Status");

		$set= new T_Project_Lccm_Status();

		$reqDistrikId= $this->input->get("reqDistrikId");

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
		$reqDistrikId= $this->input->get("reqDistrikId");
		$reqBlokId= $this->input->get("reqBlokId");
		$reqUnitMesinId= $this->input->get("reqUnitMesinId");

		$appdistrikid= $this->appdistrikid;
		$appdistrikkode= $this->appdistrikkode;
		$appblokunitid= $this->appblokunitid;
		$appblokunitkode= $this->appblokunitkode;
		$appunitmesinkode= $this->appunitmesinkode;


		$searchJson= "";
		$statement="";

		if(!empty($reqDistrikId))
		{
			$statement .= " AND A.KODE_DISTRIK='".$reqDistrikId."'";
		}
		else
		{
			if(!empty($appdistrikkode))
			{
				$statement .= " AND A.KODE_DISTRIK='".$appdistrikkode."'";
			}
		}

		if(!empty($reqBlokId))
		{
			$statement .= " AND A.KODE_BLOK='".$reqBlokId."'";
		}
		else
		{
			if(!empty($appblokunitkode))
			{
				$statement .= " AND A.KODE_BLOK='".$appblokunitkode."'";
			}
		}

		if(!empty($reqUnitMesinId))
		{
			$statement .= " AND A.KODE_UNIT_M='".$reqUnitMesinId."'";
		}
		else
		{
			if(!empty($appunitmesinkode))
			{
				$statement .= " AND A.KODE_UNIT_M='".$appunitmesinkode."'";
			}
		}
		

		// $statement= " AND A.DISTRIK_ID=".$reqDistrikId;

		$sOrder = " ";
		$set->selectByParamsMonitoring(array(), $dsplyRange, $dsplyStart, $statement.$searchJson, $sOrder);

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
					$row[$valkey]= $set->getField("TANGGAL_DISPOSISI");
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
				$data=$data;
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

	
	

}