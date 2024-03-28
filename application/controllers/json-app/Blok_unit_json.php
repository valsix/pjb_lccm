<?php
defined('BASEPATH') or exit('No direct script access allowed');

include_once("functions/default.func.php");
include_once("functions/string.func.php");
include_once("functions/date.func.php");
include_once("functions/class-list-util.php");
include_once("functions/class-list-util-serverside.php");

class blok_unit_json extends CI_Controller
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

		$this->configtitle= $this->config->config["configtitle"];
		// print_r($this->configtitle);exit;
	}

	function json()
	{
		$this->load->model("base-app/BlokUnit");

		$set= new BlokUnit();

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
		$searchJson= "";
		

		$statement= " AND A.DISTRIK_ID=".$reqDistrikId;

		$sOrder = " ORDER BY A.BLOK_UNIT_ID ASC";
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

	function add()
	{
		$this->load->model("base-app/BlokUnit");

		$reqId= $this->input->post("reqId");
		$reqMode= $this->input->post("reqMode");

		$reqDistrikId= $this->input->post("reqDistrikId");
		$reqKode= $this->input->post("reqKode");
		$reqKodeEam= $this->input->post("reqKodeEam");
		$reqNama= $this->input->post("reqNama");
		$reqEamId= $this->input->post("reqEamId");
		$reqUrl= $this->input->post("reqUrl");
		$reqKodeOld= $this->input->post("reqKodeOld");

		
		if ( preg_match('/\s/',$reqKode) )
		{
			echo "xxx***Kolom kode tidak boleh terdapat spasi";exit;
		}

		$set = new BlokUnit();
		$set->setField("NAMA", $reqNama);
		$set->setField("DISTRIK_ID", $reqDistrikId);
		$set->setField("BLOK_UNIT_ID", $reqId);
		$set->setField("KODE", $reqKode);
		$set->setField("KODE_EAM", $reqKodeEam);
		$set->setField("URL", $reqUrl);
		$set->setField("EAM_ID", ValToNullDB($reqEamId));


		$reqSimpan= "";
		if ($reqMode == "insert")
		{

			$statement=" AND A.KODE =  '".$reqKode."' ";
			$check = new BlokUnit();
			$check->selectByParams(array(), -1, -1, $statement);
			// echo $check->query;exit;
			$check->firstRow();
			$checkKode= $check->getField("KODE");

			if(!empty($checkKode))
			{
				echo "xxx***Kode Blok ".$checkKode." sudah ada";exit;	
			}

			$set->setField("LAST_CREATE_USER", $this->appusernama);
			$set->setField("LAST_CREATE_DATE", 'NOW()');

			if($set->insert())
			{
				$reqId= $set->id;
				$reqSimpan= 1;
			}
		}
		else
		{	

			if($reqKode!=$reqKodeOld)
			{

				$statement=" AND A.KODE =  '".$reqKode."' ";
				$check = new BlokUnit();
				$check->selectByParams(array(), -1, -1, $statement);
				// echo $check->query;exit;
				$check->firstRow();
				$checkKode= $check->getField("KODE");

				if(!empty($checkKode))
				{
					echo "xxx***Kode Blok ".$checkKode." sudah ada";exit;	
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


	function update_status()
	{
		$this->load->model("base-app/BlokUnit");
		$set = new BlokUnit();
		
		$reqId =  $this->input->get('reqId');
		$reqMode =  $this->input->get('reqMode');

		$reqStatus =  $this->input->get('reqStatus');

		$set->setField("BLOK_UNIT_ID", $reqId);
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

	function delete()
	{
		$this->load->model("base-app/BlokUnit");
		$set = new BlokUnit();
		
		$reqId =  $this->input->get('reqId');
		$reqMode =  $this->input->get('reqMode');

		$set->setField("BLOK_UNIT_ID", $reqId);

		if($set->delete())
		{
			$arrJson["PESAN"] = "Data berhasil dihapus.";
		}
		else
		{
			$arrJson["PESAN"] = "Data gagal dihapus.  <br> Distrik sudah dipakai";	
		}

		echo json_encode( $arrJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	
	}

	function filter_blok()
	{
		$this->load->model("base-app/BlokUnit");
		$this->load->model("base-app/Distrik");

		$reqDistrikId =  $this->input->get('reqDistrikId');

		$appdistrikid= $this->appdistrikid;
		$appdistrikkode= $this->appdistrikkode;
		$appblokunitid= $this->appblokunitid;
		$appblokunitkode= $this->appblokunitkode;
		
		$statement=" ";


		if(!empty($reqDistrikId))
		{

			$set= new Distrik();
			$statement =" AND A.KODE  = '".$reqDistrikId."'";
			$set->selectByParamsAreaDistrik(array(), -1,-1,$statement);
			// echo $set->query;exit;
			$set->firstRow();
			$reqDistrikId= $set->getField("DISTRIK_ID");

			unset($set);

			$statement =" AND A.KODE IS NOT NULL AND A.DISTRIK_ID = ".$reqDistrikId;
		}

		if(!empty($this->appblokunitid))
		{
			$statement.=" AND A.BLOK_UNIT_ID IN (".$appblokunitid.") AND A.STATUS IS NULL AND A.NAMA IS NOT NULL 
			";
		}
		else
		{
			if(empty($reqDistrikId))
			{
				$statement.=" AND 1=2 ";
			}
			// 
		}



		$set= new BlokUnit();
		$arrset= [];

		
		$set->selectByParams(array(), -1,-1,$statement);
		// echo $set->query;exit;
		while($set->nextRow())
		{
			$arrdata= array();
			$arrdata["id"]= $set->getField("BLOK_UNIT_ID");
			$arrdata["text"]= $set->getField("KODE")." - ". $set->getField("NAMA");
			$arrdata["KODE"]= $set->getField("KODE");
			array_push($arrset, $arrdata);
		}
		unset($set);
		echo json_encode( $arrset, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	

	}

}