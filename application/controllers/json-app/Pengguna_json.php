<?php
defined('BASEPATH') or exit('No direct script access allowed');

include_once("functions/default.func.php");
include_once("functions/string.func.php");
include_once("functions/date.func.php");
include_once("functions/class-list-util.php");
include_once("functions/class-list-util-serverside.php");

class Pengguna_json extends CI_Controller
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
		$this->load->model("base-app/Pengguna");

		$set= new Pengguna();

		$reqJenisNaskahId= $this->input->get("reqJenisNaskahId");

		ini_set("memory_limit", "512M"); 

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

		$sOrder = " ORDER BY PENGGUNA_ID ASC ";
		$set->selectByParams(array(), $dsplyRange, $dsplyStart, $statement.$searchJson, $sOrder);

		// echo $set->query;exit;
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
		$this->load->model("base-app/Pengguna");
		$this->load->model("base-app/Distrik");

		$reqId= $this->input->post("reqId");
		$reqMode= $this->input->post("reqMode");

		$reqUsername= $this->input->post("reqUsername");
		$reqNama= $this->input->post("reqNama");
		$reqHakAkses= $this->input->post("reqHakAkses");
		$reqRoleApprId= $this->input->post("reqRoleApprId");
		$reqPenggunaEksternalId= $this->input->post("reqPenggunaEksternalId");
		$reqEksternalId= $this->input->post("reqEksternalId");
		$reqPenggunaInternalId= $this->input->post("reqPenggunaInternalId");
		$reqInternalId= $this->input->post("reqInternalId");
		$reqTipe= $this->input->post("reqTipe");
		$reqDistrik= $this->input->post("reqDistrik");
		$reqPass= $this->input->post("reqPass");

		$reqNid= $this->input->post("reqNid");
		$reqNoTelpon= $this->input->post("reqNoTelpon");
		$reqEmail= $this->input->post("reqEmail");
		$reqDistrikId= $this->input->post("reqDistrikId");
		$reqPositionId= $this->input->post("reqPositionId");
		$reqRoleId= $this->input->post("reqRoleId");
		$reqPerusahaanId= $this->input->post("reqPerusahaanId");
		$reqStatus= $this->input->post("reqStatus");
		$reqExpiredDate= $this->input->post("reqExpiredDate");
		$reqPassword= $this->input->post("reqPassword");
		$reqLinkFoto = $_FILES['reqLinkFoto']['name'];


		if(empty($reqTipe))
		{
			$reqTipe= $this->input->post("reqTipeId");
		}


		if(!empty($reqUsername) && $reqMode == "insert")
		{
			$checkusername = new Pengguna();
			$statementcheck = " AND A.USERNAME = '".$reqUsername."' ";
			$checkusername->selectByParams(array(), -1, -1, $statementcheck);
			$checkusername->firstRow();
			$reqUser= $checkusername->getField("USERNAME");
			if(!empty($reqUser))
			{
				echo "xxx*** Username sudah ada";exit;
			}

		}

		if(!empty($reqNid))
		{

			$set = new Pengguna();
			$statement = " AND A.NID = '".$reqNid."'";
			$set->selectByParams(array(), -1, -1, $statement);
			// echo $set->query;exit;
			$set->firstRow();
			$reqNidCheck= $set->getField("NID");

			if($reqNid !== $reqNidCheck)
			{
				if(!empty($reqNidCheck))
				{
					echo "xxx***NID ".$reqNidCheck." Sudah ada ";exit;
				}
			}

		}
		

		// print_r($reqPass);exit;
		if(empty($reqTipe))
		{
			echo "xxx*** Tipe tidak boleh kosong";exit;
			
		}
		

		$set = new Pengguna();
		$set->setField("PENGGUNA_ID", $reqId);
		$set->setField("USERNAME", $reqUsername);
		
		$set->setField("NAMA", $reqNama);
		$set->setField("ROLE_ID", valToNullDB($reqRoleApprId));

		$set->setField("NID", $reqNid);

		$set->setField("STATUS", '1');
		$set->setField("PERUSAHAAN_ID", '0');
		$set->setField("PENGGUNA_EXTERNAL_ID", valToNullDB($reqPenggunaEksternalId));
		$set->setField("PENGGUNA_INTERNAL_ID", valToNullDB($reqInternalId));
		$set->setField("TIPE", $reqTipe);
		$set->setField("DISTRIK_ID", ValToNullDB($reqDistrikId));

		$set->setField("NO_TELP", ValToNullDB($reqNoTelpon));
		$set->setField("EMAIL", $reqEmail);
		$set->setField("ROLE_ID", ValToNullDB($reqRoleId));
		$set->setField("STATUS", $reqStatus);
		$set->setField("FOTO", $reqLinkFoto);
		$set->setField("PASS", md5($reqPass));
		$set->setField("EXPIRED_DATE", dateToDBCheck($reqExpiredDate));
		$set->setField("POSITION_ID", $reqPositionId);
		$set->setField("PERUSAHAAN_EKSTERNAL_ID", ValToNullDB($reqPerusahaanId));

		// $set->setField("EMAIL", $reqEmail);

		$reqSimpan= "";
		if ($reqMode == "insert")
		{
			$set->setField("LAST_CREATE_USER", $this->adminusernama);
			$set->setField("LAST_CREATE_DATE", 'SYSDATE');
			if($set->insert())
			{
				$reqSimpan= 1;
				$reqId= $set->id;
			}
		}
		else
		{	
			$set->setField("LAST_UPDATE_USER", $this->adminusernama);
			$set->setField("LAST_UPDATE_DATE", 'SYSDATE');
			if(!empty($reqPass))
			{
				if($set->update())
				{
					$reqSimpan= 1;
				}
			}
			else
			{
				if($set->updatenonpass())
				{
					$reqSimpan= 1;
				}
			}
			
		}

		if($reqSimpan == 1 )
		{
			if(!empty($reqHakAkses))
			{
				$setinsert = new Pengguna();
				$setinsert->setField("PENGGUNA_ID", $reqId);
				$setinsert->deletePenggunaHakAkses();
				foreach ($reqHakAkses as $key => $value) {
					
					$setinsert->setField("PENGGUNA_HAK_ID", $value);
					
					if($setinsert->insertPenggunaHakAkses())
					{
						$reqSimpan= 1;
					}
					
				}
			}

			if(!empty($reqLinkFoto))
			{
				$reqSimpan="";
				$linkupload="uploads/pengguna/foto/".$reqId."/";
				if (!is_dir($linkupload)) {
					makedirs($linkupload);
				}
				$reqLinkFile=$_FILES['reqLinkFoto']['tmp_name'];
				$namefile= $linkupload.$reqLinkFoto;
				// print_r($namefile);exit;
				if(move_uploaded_file($reqLinkFile, $namefile))
				{
					$set = new Pengguna();
					$reqSimpan="";
					$set->setField("PENGGUNA_ID", $reqId);
					$set->setField("FOTO", $namefile);
					if($set->updateupload())
					{
						$reqSimpan= 1;
					}
				}
			}

		
			

			echo $reqId."***Data berhasil disimpan";
		}
		else
		{
			echo "xxx***Data gagal disimpan";
		}
				
	}

	function delete()
	{
		$this->load->model("base-app/Pengguna");
		$set = new Pengguna();
		
		$reqId =  $this->input->get('reqId');
		$reqMode =  $this->input->get('reqMode');

		$set->setField("PENGGUNA_ID", $reqId);

		if($set->delete())
		{
			if ($set->deletePenggunaHakAkses()) 
			{
				if ($set->deletePenggunaDistrik()) 
				{
					$arrJson["PESAN"] = "Data berhasil dihapus.";
				}
			}
		}
		else
		{
			$arrJson["PESAN"] = "Data gagal dihapus.";	
		}

		echo json_encode( $arrJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	
	}



	function delete_gambar()
	{
		$this->load->model("base-app/Pengguna");
		$set = new Pengguna();
		
		$reqId =  $this->input->get('reqId');
		$reqMode =  $this->input->get('reqMode');

		$set->setField("PENGGUNA_ID", $reqId);

		$check = new Pengguna();
		$statement = " AND A.PENGGUNA_ID = '".$reqId."' ";
		$check->selectByParams(array(), -1, -1, $statement);
  		  // echo $check->query;exit;
		$check->firstRow();
		$reqLinkFoto= $check->getField("FOTO");

		if(file_exists($reqLinkFoto))
		{
			unlink($reqLinkFoto);
		}


		if($set->delete_gambar())
		{
			$arrJson["PESAN"] = "Gambar berhasil dihapus.";
		}
		else
		{
			$arrJson["PESAN"] = "Gambar gagal dihapus.";	
		}

		echo json_encode( $arrJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	
	}


	function reset_password()
	{
		$this->load->model("base-app/Pengguna");

		$reqId= $this->input->post("reqId");
		$reqMode= $this->input->post("reqMode");

		
		$reqPassword= $this->input->post("reqPassword");
		$reqKonfirmasiPassword= $this->input->post("reqKonfirmasiPassword");

		$set = new Pengguna();
		$set->setField("PASS", md5($reqPassword));
		$set->setField("PENGGUNA_ID", $reqId);

		if($reqKonfirmasiPassword !== $reqPassword)
		{
			echo "xxx***Password tidak sama, cek kembali password anda";exit;
		}

		$reqSimpan= "";
		
		$set->setField("LAST_UPDATE_USER", $this->adminusernama);
		$set->setField("LAST_UPDATE_DATE", 'SYSDATE');
		if($set->reset_password())
		{
			$reqSimpan= 1;
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

	function reset_master_password()
	{
		$this->load->model("base-app/Pengguna");

		$reqId= $this->input->post("reqId");
		$reqMode= $this->input->post("reqMode");

		
		$reqPassword= $this->input->post("reqPassword");
		$reqKonfirmasiPassword= $this->input->post("reqKonfirmasiPassword");

		$set = new Pengguna();
		$set->setField("MASTER_PASS", md5($reqPassword));
		$set->setField("TIPE", "1");
		$set->setField("PENGGUNA_ID", $reqId);

		if($reqKonfirmasiPassword !== $reqPassword)
		{
			echo "xxx***Password tidak sama, cek kembali password anda";exit;
		}

		$reqSimpan= "";
		
		$set->setField("LAST_UPDATE_USER", $this->adminusernama);
		$set->setField("LAST_UPDATE_DATE", 'SYSDATE');
		if($set->reset_password_master())
		{
			$reqSimpan= 1;
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

}