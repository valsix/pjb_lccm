<?php
defined('BASEPATH') or exit('No direct script access allowed');

include_once("functions/default.func.php");
include_once("functions/string.func.php");
include_once("functions/date.func.php");
include_once("functions/class-list-util.php");
include_once("functions/class-list-util-serverside.php");

class Energi_price_Json extends CI_Controller
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
		$this->load->model("base-app/T_Energy_Price_Lccm");

		$set= new T_Energy_Price_Lccm();

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
		$reqGlobalValidasiCheck= $this->input->get("reqGlobalValidasiCheck");
		$arrGlobalValidasiCheck= explode(",", $reqGlobalValidasiCheck);
		$searchJson= "";

		$statement="";

		// if(!empty($reqStatus))
		// {
		// 	if($reqStatus== 'NULL')
		// 	{
		// 		$statement .= " AND A.STATUS IS NULL";
		// 	}
		// 	else
		// 	{
		// 		$statement .= " AND A.STATUS =".$reqStatus;
		// 	}
			
		// }

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
			$statement .= " AND A.PRICE_YEAR='".$reqTahun."'";
		}

		if(!empty($this->appblokunitid))
		{
			$statement.= " AND C.BLOK_UNIT_ID = ".$this->appblokunitid;
		}

		if(!empty($reqStatus))
		{
			$statement .= " AND A.STATUS='".$reqStatus."'";
		}
		

		$sOrder = " ORDER BY A.PRICE_YEAR ASC ";
		$set->selectByParams(array(), $dsplyRange, $dsplyStart, $statement.$searchJson, $sOrder);

		// echo $set->query;exit;
		$infobatasdetil= $_REQUEST['start'] + $_REQUEST['length'];
		$infonomor= 0;
		while ($set->nextRow()) 
		{
			$infocheckid= $set->getField("PRICE_YEAR")."_".$set->getField("KODE_BLOK");
			$infonomor++;

			$row= [];
			foreach($columnsDefault as $valkey => $valitem) 
			{
				if ($valkey == "SORDERDEFAULT")
				{
					$row[$valkey]= $set->getField("NAMA");
				}
				else if ($valkey == "CHECK")
				{
					$checked= "";
					if (in_array($infocheckid, $arrGlobalValidasiCheck))
					{
						$checked= "checked";
					}

					$row[$valkey]= "<input type='checkbox' $checked onclick='setglobalklikcheck()' class='editor-active' id='reqPilihCheck".$infocheckid."' value='".$infocheckid."' /><label for='reqPilihCheck".$infocheckid."'></label>";
				}
				else if ($valkey == "NO")
				{
					$row[$valkey]= $infonomor;
				}
				else if ($valkey == "ENERGY_PRICE")
				{
					$row[$valkey]= "Rp. ".toThousandComma($set->getField($valkey));
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
		$this->load->model("base-app/T_Energy_Price_Lccm");
		$this->load->model("base-app/BlokUnit");
		$this->load->model("base-app/T_Preperation_Lccm");

		$reqId= $this->input->post("reqId");
		$reqMode= $this->input->post("reqMode");

		$reqDistrikId= $this->input->post("reqDistrikId");
		$reqBlokId= $this->input->post("reqBlokId");
		$reqUnitMesinId= $this->input->post("reqUnitMesinId");
		$reqTahun= $this->input->post("reqTahun");
		$reqEnergyPrice= $this->input->post("reqEnergyPrice");
		$reqStatus= $this->input->post("reqStatus");


		// print_r($reqTahunAwal);exit;
		$set = new T_Energy_Price_Lccm();
		$set->setField("KODE_DISTRIK", $reqDistrikId);
		$set->setField("KODE_BLOK", $reqBlokId);
		// $set->setField("UNIT_MESIN_ID", ValToNullDB($reqUnitMesinId));
		$set->setField("PRICE_YEAR", $reqTahun);
		// $set->setField("ENERGY_PRICE", $reqEnergyPrice);
		$set->setField("ENERGY_PRICE", str_replace(',', '', $reqEnergyPrice));

		$set->setField("STATUS", $reqStatus);

		$statement=" AND A.KODE =  '".$reqBlokId."' ";
		$check = new BlokUnit();
		$check->selectByParams(array(), -1, -1, $statement);
			// echo $check->query;exit;
		$check->firstRow();
		$checkKode= $check->getField("KODE");

		if(empty($checkKode))
		{
			echo "xxx***Kode Blok Kosong ";exit;	
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

			unset($set);
			if($reqSimpan == 1 )
			{
				if(!empty($reqStatus))
				{
					
					$statusprep="";
					if($reqStatus==1)
					{
						$statusprep='true';
					}
					elseif ($reqStatus==2) {
						$statusprep='false';
					}

					$statement=" AND A.KODE_DISTRIK =  '".$reqDistrikId."' AND A.KODE_BLOK =  '".$reqBlokId."' AND A.YEAR_LCCM =  '".$reqTahun."' ";
					$check = new T_Preperation_Lccm();
					$check->selectByParams(array(), -1, -1, $statement);
					// echo $check->query;exit;
					$check->firstRow();
					$checkKode= $check->getField("KODE_BLOK");

					if(!empty($checkKode))
					{
						$reqSimpan="";
						$set = new T_Preperation_Lccm();
						$set->setField("ENERGY_PRICE", $statusprep);
						$set->setField("KODE_DISTRIK", $reqDistrikId);
						$set->setField("KODE_BLOK", $reqBlokId);
						$set->setField("YEAR_LCCM", $reqTahun);
						$set->setField("LAST_UPDATE_USER", $this->appusernama);
						$set->setField("LAST_UPDATE_DATE", 'NOW()');
						if($set->updateenergy())
						{
							$reqSimpan= 1;
						}
					}


					
				}
				
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

			unset($set);
			if($reqSimpan == 1 )
			{
				if(!empty($reqStatus))
				{
					
					$statusprep="";
					if($reqStatus==1)
					{
						$statusprep='true';
					}
					elseif ($reqStatus==2) {
						$statusprep='false';
					}

					$statement=" AND A.KODE_DISTRIK =  '".$reqDistrikId."' AND A.KODE_BLOK =  '".$reqBlokId."' AND A.YEAR_LCCM =  '".$reqTahun."' ";
					$check = new T_Preperation_Lccm();
					$check->selectByParams(array(), -1, -1, $statement);
					// echo $check->query;exit;
					$check->firstRow();
					$checkKode= $check->getField("KODE_BLOK");

					if(!empty($checkKode))
					{
						$reqSimpan="";
						$set = new T_Preperation_Lccm();
						$set->setField("ENERGY_PRICE", $statusprep);
						$set->setField("KODE_DISTRIK", $reqDistrikId);
						$set->setField("KODE_BLOK", $reqBlokId);
						$set->setField("YEAR_LCCM", $reqTahun);
						$set->setField("LAST_UPDATE_USER", $this->appusernama);
						$set->setField("LAST_UPDATE_DATE", 'NOW()');
						if($set->updateenergy())
						{
							$reqSimpan= 1;
						}
					}
					
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

	function deletetahunkodeblok()
	{
		$this->load->model("base-app/T_Energy_Price_Lccm");
		
		$statement= $statemendetil= "";
		$reqId= $this->input->get('reqId');
		$arrId= explode(",", $reqId);
		foreach ($arrId as $key => $value)
		{
			$v= explode("_", $value);

			$statemendetil= getconcatseparator($statemendetil, " (PRICE_YEAR= '".$v[0]."' AND KODE_BLOK = '".$v[1]."')", " OR");
		}
		// echo $statemendetil;exit;

		if(!empty($statemendetil))
		{
			$statement= "AND (".$statemendetil.")";
			$set= new T_Energy_Price_Lccm();
			$set->setField("STATEMENT", $statement);
			if($set->deletetahunkodeblok())
			{
				$arrJson["PESAN"] = "Data berhasil dihapus.";
			}
			else
			{
				$arrJson["PESAN"] = "Data gagal dihapus.";	
			}
		}
		else
		{
			$arrJson["PESAN"] = "Data gagal dihapus.";	
		}

		echo json_encode( $arrJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	
	}

	function delete()
	{
		$this->load->model("base-app/T_Energy_Price_Lccm");
		$set = new T_Energy_Price_Lccm();
		
		$reqId =  $this->input->get('reqId');
		$reqMode =  $this->input->get('reqMode');

		$set->setField("PRICE_YEAR", $reqId);

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

	function filter_unit()
	{
		$this->load->model("base-app/T_Energy_Price_Lccm");

		$reqDistrikId =  $this->input->get('reqDistrikId');
		$reqBlokId =  $this->input->get('reqBlokId');
		$reqTahun =  $this->input->get('reqTahun');
		
		
		$statement=" AND 1=2 ";

		if(!empty($reqDistrikId) && !empty($reqBlokId))
		{
			$statement="  AND A.PRICE_YEAR =   '".$reqTahun."' AND B.KODE =   '".$reqDistrikId."' AND C.KODE =   '".$reqBlokId."' ";
		}


		$set= new T_Energy_Price_Lccm();
		$arrset= [];

		$set->selectByParams(array(), -1,-1,$statement);
		// echo $set->query;exit;
		while($set->nextRow())
		{
			$arrdata= array();
			$arrdata["text"]= $set->getField("ENERGY_PRICE");
			array_push($arrset, $arrdata);
		}
		unset($set);
		echo json_encode( $arrset, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	

	}


	// function update_status()
	// {
	// 	$this->load->model("base-app/T_Energy_Price_Lccm");
	// 	$set = new T_Energy_Price_Lccm();
		
	// 	$reqId =  $this->input->get('reqId');
	// 	$reqMode =  $this->input->get('reqMode');

	// 	$reqStatus =  $this->input->get('reqStatus');

	// 	$set->setField("PERUSAHAAN_EKSTERNAL_ID", $reqId);
	// 	$set->setField("STATUS", ValToNullDB($reqStatus));

	// 	if($reqStatus==1)
	// 	{
	// 		$pesan="dinonaktifkan.";
	// 	}
	// 	else
	// 	{
	// 		$pesan="diaktifkan.";
	// 	}

	// 	if($set->update_status())
	// 	{
	// 		$arrJson["PESAN"] = "Data berhasil ".$pesan;
	// 	}
	// 	else
	// 	{
	// 		$arrJson["PESAN"] =  "Data gagal ".$pesan;
	// 	}

	// 	echo json_encode( $arrJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	
	// }

}