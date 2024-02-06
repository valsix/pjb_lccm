<?php
defined('BASEPATH') or exit('No direct script access allowed');

include_once("functions/default.func.php");
include_once("functions/string.func.php");
include_once("functions/date.func.php");
include_once("functions/class-list-util.php");
include_once("functions/class-list-util-serverside.php");

class distrik_json extends CI_Controller
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
		$this->load->model("base-app/Distrik");

		$set= new Distrik();

		$reqJenisNaskahId= $this->input->get("reqJenisNaskahId");

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
		$reqKode= $this->input->get("reqKode");
		$reqStatus= $this->input->get("reqStatus");
		$reqWilayah= $this->input->get("reqWilayah");
		$reqDirektorat= $this->input->get("reqDirektorat");
		$reqPerusahaan= $this->input->get("reqPerusahaan");
		$reqJenis= $this->input->get("reqJenis");

		$searchJson= "";
		if(!empty($reqPencarian))
		{
			$searchJson= " 
			AND 
			(
				UPPER(A.NAMA) LIKE '%".strtoupper($reqPencarian)."%'
				OR UPPER(A.NAMA) LIKE '%".strtoupper($reqPencarian)."%'
			)";
		}

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

		if(!empty($reqKode))
		{
			$statement .= " AND A.KODE ='".$reqKode."'";
		}


		if(!empty($reqWilayah))
		{
			$statement .= " AND A.WILAYAH_ID ='".$reqWilayah."'";
		}

		if(!empty($reqDirektorat))
		{
			$statement .= " AND A.DIREKTORAT_ID = '".$reqDirektorat."' ";
		}

		if(!empty($reqPerusahaan))
		{
			$statement .= " AND A.PERUSAHAAN_EKSTERNAL_ID ='".$reqPerusahaan."'";
		}

		if(!empty($reqJenis))
		{
			$statement .= " AND A.JENIS_UNIT_KERJA_ID ='".$reqJenis."'";
		}

		$sOrder = " ORDER BY A.DISTRIK_ID ASC";
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
				else if ($valkey == "BLOK_UNIT_INFO")
				{

					$blokinfo=$set->getField("BLOK_INFO");
					$arrblokinfo = explode(',', $blokinfo);
					$blokval="<ul>";
					foreach ($arrblokinfo as $key => $value) {
						$blokval .="<li>".$value."</li>";
					}
					$blokval .="<ul>";
					if(!empty($blokinfo))
					{
						$row[$valkey]= $blokval;
					}
					else
					{
						$row[$valkey]= "";
					}
					
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
		$this->load->model("base-app/Distrik");
		$this->load->model("base-app/BlokUnit");
		$this->load->model("base-app/UnitMesin");
		$this->load->model("base-app/Pengguna");

		$reqId= $this->input->post("reqId");
		$reqMode= $this->input->post("reqMode");

		$reqKodeSite= $this->input->post("reqKodeSite");
		$reqKode= $this->input->post("reqKode");
		$reqJenisUnitKerjaId= $this->input->post("reqJenisUnitKerjaId");
		$reqLocationId= $this->input->post("reqLocationId");
		$reqNama= $this->input->post("reqNama");

		$reqDirektoratId= $this->input->post("reqDirektoratId");
		$reqWilayahId= $this->input->post("reqWilayahId");
		$reqPerusahaanEksternalId= $this->input->post("reqPerusahaanEksternalId");

		
		$set = new Distrik();
		$set->setField("KODE_SITE", $reqKodeSite);
		$set->setField("KODE", $reqKode);
		$set->setField("NAMA", $reqNama);
		$set->setField("DISTRIK_ID", $reqId);
		$set->setField("WILAYAH_ID", ValToNullDB($reqWilayahId));
		$set->setField("PERUSAHAAN_EKSTERNAL_ID", ValToNullDB($reqPerusahaanEksternalId));
		// $set->setField("JENIS_UNIT_KERJA_ID", ValToNullDB($reqJenisUnitKerjaId));
		$set->setField("LOCATION_ID", ValToNullDB($reqLocationId));
		$set->setField("DIREKTORAT_ID", ValToNullDB($reqDirektoratId));

		if ( preg_match('/\s/',$reqKode) )
		{
			echo "xxx***Kolom kode tidak boleh terdapat spasi";exit;
		}

		$reqSimpan= "";
		if ($reqMode == "insert")
		{
			$set->setField("LAST_CREATE_USER", $this->appusernama);
			$set->setField("LAST_CREATE_DATE", 'NOW()');

			$statement=" AND A.KODE =  '".$reqKode."' ";
			$check = new Distrik();
			$check->selectByParams(array(), -1, -1, $statement);
			// echo $check->query;exit;
			$check->firstRow();
			$checkKode= $check->getField("KODE");

			if(!empty($checkKode))
			{
				echo "xxx***Kode Distrik ".$checkKode." sudah ada";exit;	
			}

			if($set->insert())
			{
				$reqId= $set->id;
				$reqSimpan= 1;

				$pengguna = new Pengguna();
				$pengguna->selectByParamsStatusAll(array(), -1, -1, "");
				// echo $check->query;exit;
				while($pengguna->nextRow())
				{
					$reqPenggunaId=$pengguna->getField("PENGGUNA_ID");
					$dsk = new Pengguna();
					$dsk->selectByParamsPenggunaDistrik(array(), -1, -1, " and x.pengguna_id=".$reqPenggunaId);
					// echo $dsk->query;exit;
					while($dsk->nextRow())
					{
						$reqDskId=$dsk->getField("DISTRIK_ID");
						$insert = new Pengguna();
						$insert->setField("PENGGUNA_ID", $reqPenggunaId);
						$insert->setField("DISTRIK_ID", $reqDskId);
						$insert->setField("STATUS_ALL", 0);
						if($insert->insertPenggunaDistrik())
						{
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
		}

		// if(!empty($reqJenisUnitKerjaId))
		// {
		// 	$setdelete = new Distrik();
		// 	$reqSimpan="";
		// 	$setdelete->setField("DISTRIK_ID", $reqId);
		// 	$setdelete->deletejenis();
		// 	foreach ($reqJenisUnitKerjaId as $key => $value) 
		// 	{
		// 		$setjenis = new Distrik();
		// 		$setjenis->setField("DISTRIK_ID", $reqId);
		// 		$setjenis->setField("JENIS_UNIT_KERJA_ID", $value);

		// 		if($setjenis->insertjenis())
		// 		{
		// 			$reqSimpan= 1;
		// 		}
		// 	}

		// }

		if($reqSimpan == 1 )
		{
			// untuk buat data dinamis
			$reqNamaDinamis= $this->input->post("reqNamaDinamis");
			$reqUnitKe= $this->input->post("reqUnitKe");
			$reqModeDinamis= $this->input->post("reqModeDinamis");
			$reqKodeDinamis= $this->input->post("reqKodeDinamis");
			$reqKodeEam= $this->input->post("reqKodeEam");
			$reqUrlDinamis= $this->input->post("reqUrlDinamis");
			$reqJenisUnitKerjaId= $this->input->post("reqJenisUnitKerjaId");
			// print_r($reqNamaDinamis);
			// print_r($reqJenisUnitKerjaId);exit;
			// print_r($reqModeDinamis);


			foreach ($reqModeDinamis as $key => $vmode) {
				if($vmode == "blokunit")
				{
					$set= new BlokUnit();
					$set->setField("KODE", $reqKodeDinamis[$key]);
					$set->setField("KODE_EAM", $reqKodeEam[$key]);
					$set->setField("NAMA", $reqNamaDinamis[$key]);
					$set->setField("URL", $reqUrlDinamis[$key]);
					$set->setField("DISTRIK_ID", $reqId);
					$set->setField("LAST_CREATE_USER", $this->appusernama);
					$set->setField("LAST_CREATE_DATE", 'NOW()');
					$set->setField("EAM_ID", ValToNullDB($reqJenisUnitKerjaId[$key]));
					if($set->insert())
					{
						$reqBlokUnitId= $set->id;
					}
				}

				if($vmode == "unitmesin")
				{
					$set= new UnitMesin();
					$set->setField("KODE", $reqKodeDinamis[$key]);
					$set->setField("KODE_EAM", $reqKodeEam[$key]);
					$set->setField("NAMA", $reqNamaDinamis[$key]);
					$set->setField("URL", $reqUrlDinamis[$key]);
					$set->setField("DISTRIK_ID", $reqId);
					$set->setField("BLOK_UNIT_ID", $reqBlokUnitId);
					$set->setField("LAST_CREATE_USER", $this->appusernama);
					$set->setField("LAST_CREATE_DATE", 'NOW()');
					$set->setField("EAM_ID", ValToNullDB($reqJenisUnitKerjaId[$key]));

					if($set->insert())
					{
					}
				}
			}
			// exit;

			echo $reqId."***Data berhasil disimpan";
		}
		else
		{
			echo "xxx***Data gagal disimpan";
		}
				
	}

	function update_status()
	{
		$this->load->model("base-app/Distrik");
		$set = new Distrik();
		
		$reqId =  $this->input->get('reqId');
		$reqMode =  $this->input->get('reqMode');

		$reqStatus =  $this->input->get('reqStatus');

		$set->setField("DISTRIK_ID", $reqId);
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
		$this->load->model("base-app/Distrik");
		$set = new Distrik();
		
		$reqId =  $this->input->get('reqId');
		$reqMode =  $this->input->get('reqMode');

		$set->setField("DISTRIK_ID", $reqId);

		if($set->delete())
		{
			$arrJson["PESAN"] = "Data berhasil dihapus.";
		}
		else
		{
			$arrJson["PESAN"] = "Data gagal dihapus. <br> Distrik sudah dipakai ";	
		}

		echo json_encode( $arrJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	
	}

	function getHirarki()
	{
		$this->load->model("base-app/BlokUnit");
		$this->load->model("base-app/UnitMesin");
		$set = new BlokUnit();
		
		$reqDistrikId =  $this->input->post('reqDistrikId');

		$statement = " AND A.DISTRIK_ID = '".$reqDistrikId."' ";

		$arrSet=[];

		$set->selectByParams(array(), -1, -1, $statement);
    	// echo $set->query;exit;

		while($set->nextRow())
		{
			$arrdata= array();
			// $arrdata["id"]= $set->getField("DISTRIK_ID");
			$arrdata["BLOK_NAMA"]= $set->getField("NAMA");
			array_push($arrSet, $arrdata);
		}


		$set = new UnitMesin();

		$statement = " AND A.DISTRIK_ID = '".$reqDistrikId."' ";

		// $arrSet=[];

		$set->selectByParams(array(), -1, -1, $statement);
    	// echo $set->query;exit;

		while($set->nextRow())
		{
			$arrdata= array();
			$arrdata["UNIT_NAMA"]= $set->getField("NAMA");
			array_push($arrSet, $arrdata);
		}

		print_r($arrSet);exit;
	}

}