<?php
defined('BASEPATH') or exit('No direct script access allowed');

include_once("functions/default.func.php");
include_once("functions/string.func.php");
include_once("functions/date.func.php");
include_once("functions/class-list-util.php");
include_once("functions/class-list-util-serverside.php");
include_once("functions/excel_reader2.php");

class Import_json extends CI_Controller
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
	}


	function perusahaan_eksternal() 
	{
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

		if(empty($tipefile))
		{
			echo "xxx***Pilih file terlebih dahulu";exit;
		}
		else
		{
			if($acceptable !== $tipefile) {
				echo "xxx***File gagal diupload, Pastikan File berformat XLS";exit;
			}
		}
		
		$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);

		$baris = $data->rowcount($sheet_index=0);

		$arrField= array("KODE","NAMA");

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		$arrbaris=[];
		for ($z=2; $z<=$baris; $z++)
		{
			$colIndexCheck=1;
			$arrDataCheck= [];
			for($rowCheck=0; $rowCheck < count($arrField); $rowCheck++)
			{
				$tempValueCheck= $data->val($z,$colIndexCheck);
				if($arrField[$rowCheck]=="KODE")
				{
					if (!empty($tempValueCheck))
					{
						if ( preg_match('/\s/',$tempValueCheck) )
						{
							echo "xxx***Kolom kode baris ke ".$z." tidak boleh terdapat spasi";exit;
						}

						$statement =" AND A.KODE = '".$tempValueCheck."'";
						$check = new Import();
						$check->selectByParamsCheckPerusahaanExternal(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqCheckId=$check->getField("PERUSAHAAN_EKSTERNAL_ID");
						// unset($check);
						if(!empty($reqCheckId))
						{
							array_push($arrbaris, $z);
						}
					}
					else
					{
						echo "xxx***Kode Perusahaan baris ke ".$z." Belum Diisi";
						exit();
					}
				}
				$colIndexCheck++;	
			}
		}

		if(!empty($arrbaris))
		{
			$strbaris = implode (",", $arrbaris);
			echo "xxx***Kode Perusahaan baris ke ".$strbaris." sudah ada";exit;
		}

		for ($i=2; $i<=$baris; $i++){
			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){

				$tempValue= $data->val($i,$colIndex);
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);
				$set->setField($arrField[$row],$tempValue);
				$colIndex++;
			}

			$set->setField("LAST_CREATE_DATE", "NOW()");
			$set->setField("LAST_CREATE_USER", $this->appusernama);
			if($set->insertperusahaaneksternal())
			{
				$reqSimpan = 1;

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

	function direktorat() 
	{
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

		if(empty($tipefile))
		{
			echo "xxx***Pilih file terlebih dahulu";exit;
		}
		else
		{
			if($acceptable !== $tipefile) {
				echo "xxx***File gagal diupload, Pastikan File berformat XLS";exit;
			}
		}
		
		$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);

		$baris = $data->rowcount($sheet_index=0);

		$arrField= array("KODE","NAMA");

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		$arrbaris=[];
		for ($z=2; $z<=$baris; $z++)
		{
			$colIndexCheck=1;
			$arrDataCheck= [];
			for($rowCheck=0; $rowCheck < count($arrField); $rowCheck++)
			{
				$tempValueCheck= $data->val($z,$colIndexCheck);
				if($arrField[$rowCheck]=="KODE")
				{
					if (!empty($tempValueCheck))
					{
						if ( preg_match('/\s/',$tempValueCheck) )
						{
							echo "xxx***Kolom kode baris ke ".$z." tidak boleh terdapat spasi";exit;
						}

						$statement =" AND A.KODE = '".$tempValueCheck."'";
						$check = new Import();
						$check->selectByParamsCheckDirektorat(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqCheckId=$check->getField("DIREKTORAT_ID");
						// unset($check);
						if(!empty($reqCheckId))
						{
							array_push($arrbaris, $z);
						}
					}
					else
					{
						echo "xxx***Kode Direktorat baris ke ".$z." Belum Diisi";
						exit();
					}
				}
				elseif($arrField[$rowCheck]=="NAMA")
				{
					if (!empty($tempValueCheck))
					{}
					else
					{
						echo "xxx***Nama Direktorat baris ke ".$z." Belum Diisi";
						exit();
					}
				}
				$colIndexCheck++;	
			}
		}

		if(!empty($arrbaris))
		{
			$strbaris = implode (",", $arrbaris);
			echo "xxx***Kode Direktorat baris ke ".$strbaris." sudah ada";exit;
		}

		// exit;

		for ($i=2; $i<=$baris; $i++){
			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){

				$tempValue= $data->val($i,$colIndex);
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);
				$set->setField($arrField[$row],$tempValue);
				$colIndex++;
			}

			$set->setField("LAST_CREATE_DATE", "NOW()");
			$set->setField("LAST_CREATE_USER", $this->appusernama);
			if($set->insertdirektorat())
			{
				$reqSimpan = 1;
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

	function wilayah() 
	{
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

		if(empty($tipefile))
		{
			echo "xxx***Pilih file terlebih dahulu";exit;
		}
		else
		{
			if($acceptable !== $tipefile) {
				echo "xxx***File gagal diupload, Pastikan File berformat XLS";exit;
			}
		}
		
		$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);

		$baris = $data->rowcount($sheet_index=0);

		$arrField= array("KODE","NAMA");

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		$arrbaris=[];
		for ($z=2; $z<=$baris; $z++)
		{
			$colIndexCheck=1;
			$arrDataCheck= [];
			for($rowCheck=0; $rowCheck < count($arrField); $rowCheck++)
			{
				$tempValueCheck= $data->val($z,$colIndexCheck);
				if($arrField[$rowCheck]=="KODE")
				{
					if (!empty($tempValueCheck))
					{
						if ( preg_match('/\s/',$tempValueCheck) )
						{
							echo "xxx***Kolom kode baris ke ".$z." tidak boleh terdapat spasi";exit;
						}

						$statement =" AND A.KODE = '".$tempValueCheck."'";
						$check = new Import();
						$check->selectByParamsCheckWilayah(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqCheckId=$check->getField("WILAYAH_ID");
						// unset($check);
						if(!empty($reqCheckId))
						{
							array_push($arrbaris, $z);
						}
					}
					else
					{
						echo "xxx***Kode wilayah baris ke ".$z." Belum Diisi";
						exit();
					}
				}
				elseif($arrField[$rowCheck]=="NAMA")
				{
					if (!empty($tempValueCheck))
					{}
					else
					{
						echo "xxx***Nama wilayah baris ke ".$z." Belum Diisi";
						exit();
					}
				}
				$colIndexCheck++;	
			}

		}

		if(!empty($arrbaris))
		{
			$strbaris = implode (",", $arrbaris);
			echo "xxx***Kode wilayah baris ke ".$strbaris." sudah ada";exit;
		}

		// exit;
		for ($i=2; $i<=$baris; $i++){
			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){

				$tempValue= $data->val($i,$colIndex);
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);
				$set->setField($arrField[$row],$tempValue);
				$colIndex++;
			}

			$set->setField("LAST_CREATE_DATE", "NOW()");
			$set->setField("LAST_CREATE_USER", $this->appusernama);
			if($set->insertwilayah())
			{
				$reqSimpan = 1;
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


	function jenis_unit_kerja() 
	{
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

		if(empty($tipefile))
		{
			echo "xxx***Pilih file terlebih dahulu";exit;
		}
		else
		{
			if($acceptable !== $tipefile) {
				echo "xxx***File gagal diupload, Pastikan File berformat XLS";exit;
			}
		}
		
		$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);

		$baris = $data->rowcount($sheet_index=0);

		$arrField= array("KODE","NAMA");

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		$arrbaris=[];
		for ($z=2; $z<=$baris; $z++)
		{
			$colIndexCheck=1;
			$arrDataCheck= [];
			for($rowCheck=0; $rowCheck < count($arrField); $rowCheck++)
			{
				$tempValueCheck= $data->val($z,$colIndexCheck);
				if($arrField[$rowCheck]=="KODE")
				{
					if (!empty($tempValueCheck))
					{
						if ( preg_match('/\s/',$tempValueCheck) )
						{
							echo "xxx***Kolom kode baris ke ".$z." tidak boleh terdapat spasi";exit;
						}

						$statement =" AND A.KODE = '".$tempValueCheck."'";
						$check = new Import();
						$check->selectByParamsCheckJenisUnit(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqCheckId=$check->getField("JENIS_UNIT_KERJA_ID");
						// unset($check);
						if(!empty($reqCheckId))
						{
							array_push($arrbaris, $z);
						}
					}
					else
					{
						echo "xxx***Kode jenis unit kerja baris ke ".$z." Belum Diisi";
						exit();
					}
				}
				$colIndexCheck++;	
			}
		}

		if(!empty($arrbaris))
		{
			$strbaris = implode (",", $arrbaris);
			echo "xxx***Kode jenis unit kerja baris ke ".$strbaris." sudah ada";exit;
		}

		// exit;
		for ($i=2; $i<=$baris; $i++){
			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){

				$tempValue= $data->val($i,$colIndex);
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);
				$set->setField($arrField[$row],$tempValue);
				$colIndex++;
			}

			$set->setField("LAST_CREATE_DATE", "NOW()");
			$set->setField("LAST_CREATE_USER", $this->appusernama);
			if($set->insertjenis())
			{
				$reqSimpan = 1;
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

	function area_unit_template() 
	{
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];
		$reqId= $this->input->post("reqId");
		$reqJumlahArea= $this->input->post("reqJumlahArea");

		if(empty($tipefile))
		{
			echo "xxx***Pilih file terlebih dahulu";exit;
		}
		else
		{
			if($acceptable !== $tipefile) {
				echo "xxx***File gagal diupload, Pastikan File berformat XLS";exit;
			}
		}
		
		$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);

		// print_r($reqJumlahArea);exit;

		for ($sheet=1; $sheet<=$reqJumlahArea; $sheet++)
		{

			$baris = $data->rowcount($sheet);
			// print_r($baris);

			$arrField= array("AREA_UNIT_DETIL_ID","","","NAMA","STATUS_KONFIRMASI");

			$this->load->model("base-app/Import");

			$set = new Import();

			$reqSimpan="";
			$index=2;
			$arrbaris=[];
			$arrperaturan=[];
			$arrStandarId=array();
			for ($z=2; $z<=$baris; $z++)
			{
				$colIndexCheck=1;
				$arrDataCheck= [];
				for($rowCheck=0; $rowCheck < count($arrField); $rowCheck++)
				{
					// $tempValueCheck= $data->val($z,$colIndexCheck);
					$tempValueCheck= $data->val($z,$colIndexCheck,$sheet);

					if($arrField[$rowCheck]=="STATUS_KONFIRMASI")
					{
						if (isset($tempValueCheck) && is_numeric($tempValueCheck))
						{
							if($tempValueCheck > 1)
							{
								echo "xxx***Status baris ke ".$z." hanya diisi angka 1 atau 0";exit;
							}
						}
						else
						{
							echo "xxx***Status baris ke ".$z." Belum Diisi";
							exit();
						}
					}
					$colIndexCheck++;
				}
			}

			for ($i=2; $i<=$baris; $i++){
				$colIndex=1;
				$arrData= [];

				for($row=0; $row < count($arrField); $row++){
					$tempValue= $data->val($i,$colIndex,$sheet);
					$arrData[$arrField[$row]]['VALUE']= $tempValue;
					$set->setField($arrField[$row],$tempValue);
					$set->setField("AREA_UNIT_ID",$reqId);

					$colIndex++;
				}

				$set->setField("LAST_UPDATE_DATE", "NOW()");
				$set->setField("LAST_UPDATE_USER", $this->appusernama);
				if($set->updateareaunit())
				{
					$reqSimpan = 1;
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

	function distrik_template() 
	{
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];
		$reqId= $this->input->post("reqDistrikId");

		// print_r($reqId);exit;

		if(empty($tipefile))
		{
			echo "xxx***Pilih file terlebih dahulu";exit;
		}
		else
		{
			if($acceptable !== $tipefile) {
				echo "xxx***File gagal diupload, Pastikan File berformat XLS";exit;
			}
		}
		
		$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);

		$baris = $data->rowcount($sheet_index=0);

		$arrField= array("KODE","KODE_SITE","NAMA","WILAYAH_ID","DIREKTORAT_ID","PERUSAHAAN_EKSTERNAL_ID");

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		$arrbaris=[];
		$arrperaturan=[];
		$arrWilayah=[];
		$arrDirektorat=[];
		$arrperusahaan=[];
		$arrStandarId=array();
		for ($z=2; $z<=$baris; $z++)
		{
			$colIndexCheck=1;
			$arrDataCheck= [];
			for($rowCheck=0; $rowCheck < count($arrField); $rowCheck++)
			{
				$tempValueCheck= $data->val($z,$colIndexCheck);
				if($arrField[$rowCheck]=="KODE")
				{
					if (!empty($tempValueCheck))
					{
						if ( preg_match('/\s/',$tempValueCheck) )
						{
							echo "xxx***Kolom kode baris ke ".$z." tidak boleh terdapat spasi";exit;
						}

						$statement =" AND A.KODE = '".$tempValueCheck."'";
						$check = new Import();
						$check->selectByParamsCheckDistrik(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqCheckId=$check->getField("DISTRIK_ID");
						// unset($check);
						if(!empty($reqCheckId))
						{
							array_push($arrperaturan, $z);
						}
					}
					else
					{
						echo "xxx***Kode baris ke ".$z." Belum Diisi";
						exit();
					}
				}
				elseif($arrField[$rowCheck]=="WILAYAH_ID")
				{
					if (!empty($tempValueCheck))
					{
						$statement =" AND A.WILAYAH_ID = '".$tempValueCheck."'";
						$check = new Import();
						$check->selectByParamsCheckWilayah(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqCheckId=$check->getField("WILAYAH_ID");
						// unset($check);
						if(empty($reqCheckId))
						{
							array_push($arrWilayah, $z);
						}
					}
					// else
					// {
					// 	echo "xxx***Wi baris ke ".$z." Belum Diisi";
					// 	exit();
					// }
				}
				elseif($arrField[$rowCheck]=="DIREKTORAT_ID")
				{
					if (!empty($tempValueCheck))
					{
						$statement =" AND A.DIREKTORAT_ID = '".$tempValueCheck."'";
						$check = new Import();
						$check->selectByParamsCheckDirektorat(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqCheckId=$check->getField("DIREKTORAT_ID");
						// unset($check);
						if(empty($reqCheckId))
						{
							array_push($arrDirektorat, $z);
						}
					}
					// else
					// {
					// 	echo "xxx***Kode baris ke ".$z." Belum Diisi";
					// 	exit();
					// }
				}
				elseif($arrField[$rowCheck]=="PERUSAHAAN_EKSTERNAL_ID")
				{
					if (!empty($tempValueCheck))
					{
						$statement =" AND A.PERUSAHAAN_EKSTERNAL_ID = '".$tempValueCheck."'";
						$check = new Import();
						$check->selectByParamsCheckPerusahaanExternal(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqCheckId=$check->getField("PERUSAHAAN_EKSTERNAL_ID");
						// unset($check);
						if(empty($reqCheckId))
						{
							array_push($arrperusahaan, $z);
						}
					}
					// else
					// {
					// 	echo "xxx***Kode baris ke ".$z." Belum Diisi";
					// 	exit();
					// }
				}
				// print_r($tempValueCheck);
				$colIndexCheck++;
			}
		}


		if(!empty($arrperaturan))
		{
			$strbaris = implode (",", $arrperaturan);
			echo "xxx*** Kode baris ke ".$strbaris." sudah ada";exit;
		}

		if(!empty($arrWilayah))
		{
			// print_r($arrWilayah);exit;
			$strbaris = implode (",", $arrWilayah);
			echo "xxx*** Wilayah baris ke ".$strbaris." tidak ditemukan";exit;
		}

		if(!empty($arrDirektorat))
		{
			$strbaris = implode (",", $arrDirektorat);
			echo "xxx*** Direktorat baris ke ".$strbaris." tidak ditemukan";exit;
		}

		if(!empty($arrperusahaan))
		{
			$strbaris = implode (",", $arrperusahaan);
			echo "xxx*** Perusahaan baris ke ".$strbaris." tidak ditemukan";exit;
		}

		// exit;

		for ($i=2; $i<=$baris; $i++){
			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){
				$tempValue= $data->val($i,$colIndex);
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);
				if($arrField[$row]=="WILAYAH_ID" || $arrField[$row]=="PERUSAHAAN_EKSTERNAL_ID" || $arrField[$row]=="DIREKTORAT_ID")
				{
					$set->setField($arrField[$row],ValToNullDB($tempValue));
				}
				else
				{
					$set->setField($arrField[$row],$tempValue);
				}
				

				$colIndex++;
			}

			$set->setField("LAST_CREATE_DATE", "NOW()");
			$set->setField("LAST_CREATE_USER", $this->appusernama);
			if($set->insertdistrik())
			{
				$reqSimpan = 1;
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

	function blok_unit_template() 
	{
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];
		$reqDistrikId= $this->input->post("reqDistrikId");

		// print_r($reqId);exit;

		if(empty($tipefile))
		{
			echo "xxx***Pilih file terlebih dahulu";exit;
		}
		else
		{
			if($acceptable !== $tipefile) {
				echo "xxx***File gagal diupload, Pastikan File berformat XLS";exit;
			}
		}
		
		$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);

		$baris = $data->rowcount($sheet_index=0);

		$arrField= array("KODE","KODE_EAM","NAMA","EAM_ID","URL");

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		$arrbaris=[];
		$arrperaturan=[];
		$arrStandarId=array();
		for ($z=2; $z<=$baris; $z++)
		{
			$colIndexCheck=1;
			$arrDataCheck= [];
			for($rowCheck=0; $rowCheck < count($arrField); $rowCheck++)
			{
				$tempValueCheck= $data->val($z,$colIndexCheck);
				if($arrField[$rowCheck]=="KODE")
				{
					if (!empty($tempValueCheck))
					{
						$statement =" AND A.KODE = '".$tempValueCheck."' AND B.DISTRIK_ID = '".$reqDistrikId."'  ";
						$check = new Import();
						$check->selectByParamsCheckBlok(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqId=$check->getField("BLOK_UNIT_ID");
						// unset($check);
						if(!empty($reqId))
						{
							// array_push($arrperaturan, $z);
						}
					}
					else
					{
						echo "xxx***Kode Blok baris ke ".$z." Belum Diisi";
						exit();
					}
				}
				else if($arrField[$rowCheck]=="EAM_ID")
				{
					if (!empty($tempValueCheck))
					{
						$statement =" AND A.EAM_ID = '".$tempValueCheck."'";
						$check = new Import();
						$check->selectByParamsCheckEam(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqCheckId=$check->getField("NAMA");
						// unset($check);
						if(!empty($reqCheckId))
						{
						}
						else
						{
							echo "xxx***Eam  baris ke ".$z." Tidak ditemukan";
							exit();
						}
					}
				}
				// print_r($tempValueCheck);
				$colIndexCheck++;
			}
		}


		if(!empty($arrperaturan))
		{
			$strbaris = implode (",", $arrperaturan);
			echo "xxx*** Kode Unit baris ke ".$strbaris." sudah ada";exit;
		}

		// exit;

		for ($i=2; $i<=$baris; $i++){
			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){
				$tempValue= $data->val($i,$colIndex);
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);
				if($arrField[$row]=="EAM_ID")
				{
					$set->setField($arrField[$row],ValToNullDB($tempValue));
				}
				else
				{
					$set->setField($arrField[$row],$tempValue);
				}

				if($arrField[$row]=="KODE")
				{
					if (!empty($tempValue))
					{
						$statement =" AND A.KODE = '".$tempValue."' AND B.DISTRIK_ID = '".$reqDistrikId."'  ";
						$check = new Import();
						$check->selectByParamsCheckBlok(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqId=$check->getField("BLOK_UNIT_ID");
						// unset($check);
						$set->setField("BLOK_UNIT_ID",$reqId);

					}
					
				}
				$set->setField("DISTRIK_ID",$reqDistrikId);

				$colIndex++;
			}

			if(empty($reqId))
			{
				$set->setField("LAST_CREATE_DATE", "NOW()");
				$set->setField("LAST_CREATE_USER", $this->appusernama);
				if($set->insertblok())
				{
					$reqSimpan = 1;
				}
			}
			else
			{
				$set->setField("LAST_UPDATE_DATE", "NOW()");
				$set->setField("LAST_UPDATE_USER", $this->appusernama);

				if($set->updateblok())
				{
					$reqSimpan = 1;
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

	function unit_mesin() 
	{
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];
		$reqDistrikId= $this->input->post("reqDistrikId");
		$reqBlokUnitId= $this->input->post("reqBlokUnitId");

		if(empty($tipefile))
		{
			echo "xxx***Pilih file terlebih dahulu";exit;
		}
		else
		{
			if($acceptable !== $tipefile) {
				echo "xxx***File gagal diupload, Pastikan File berformat XLS";exit;
			}
		}
		
		$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);

		$baris = $data->rowcount($sheet_index=0);

		$arrField= array("KODE","KODE_EAM","NAMA","EAM_ID","URL");

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		$arrbaris=[];
		$arrperaturan=[];
		$arrStandarId=array();
		for ($z=2; $z<=$baris; $z++)
		{
			$colIndexCheck=1;
			$arrDataCheck= [];
			for($rowCheck=0; $rowCheck < count($arrField); $rowCheck++)
			{
				$tempValueCheck= $data->val($z,$colIndexCheck);
				if($arrField[$rowCheck]=="KODE")
				{
					if (!empty($tempValueCheck))
					{
					}
					else
					{
						echo "xxx***Kode Unit Mesin baris ke ".$z." Belum Diisi";
						exit();
					}
				}
				else if($arrField[$rowCheck]=="EAM_ID")
				{
					if (!empty($tempValueCheck))
					{
						$statement =" AND A.EAM_ID = '".$tempValueCheck."'";
						$check = new Import();
						$check->selectByParamsCheckEam(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqCheckId=$check->getField("NAMA");
						// unset($check);
						if(!empty($reqCheckId))
						{
						}
						else
						{
							echo "xxx***Eam baris ke ".$z." Tidak ditemukan";
							exit();
						}
					}
				}
				// print_r($tempValueCheck);
				$colIndexCheck++;
			}
		}


		// exit;

		for ($i=2; $i<=$baris; $i++){
			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){
				$tempValue= $data->val($i,$colIndex);
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);
				if($arrField[$row]=="EAM_ID")
				{
					$set->setField($arrField[$row],ValToNullDB($tempValue));
				}
				else
				{
					$set->setField($arrField[$row],$tempValue);
				}

				if($arrField[$row]=="KODE")
				{
					if (!empty($tempValue))
					{
						$statement =" AND A.KODE = '".$tempValue."' AND B.DISTRIK_ID = '".$reqDistrikId."' AND C.BLOK_UNIT_ID = '".$reqBlokUnitId."'  ";
						$check = new Import();
						$check->selectByParamsCheckUnitMesin(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqId=$check->getField("UNIT_MESIN_ID");
						// unset($check);
						$set->setField("UNIT_MESIN_ID",$reqId);

					}
					
				}
				$set->setField("DISTRIK_ID",$reqDistrikId);
				$set->setField("BLOK_UNIT_ID",$reqBlokUnitId);

				$colIndex++;
			}

			if(empty($reqId))
			{
				$set->setField("LAST_CREATE_DATE", "NOW()");
				$set->setField("LAST_CREATE_USER", $this->appusernama);
				if($set->insertunitmesin())
				{
					$reqSimpan = 1;
				}
			}
			else
			{
				$set->setField("LAST_UPDATE_DATE", "NOW()");
				$set->setField("LAST_UPDATE_USER", $this->appusernama);

				if($set->updateunitmesin())
				{
					$reqSimpan = 1;
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

	function master_jabatan() 
	{
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

		if(empty($tipefile))
		{
			echo "xxx***Pilih file terlebih dahulu";exit;
		}
		else
		{
			if($acceptable !== $tipefile) {
				echo "xxx***File gagal diupload, Pastikan File berformat XLS";exit;
			}
		}
		
		$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);

		$reqSuperiorId= $this->input->post("reqSuperiorId");


		$baris = $data->rowcount($sheet_index=0);

		$arrField= array("POSITION_ID","NAMA_POSISI","DISTRIK_ID","KATEGORI","JENJANG_JABATAN","UNIT","DITBID");

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		for ($i=2; $i<=$baris; $i++){
			// validasi kalau kode/id kosong
			// if(empty($data->val($i,2)))
			// 	continue;
			
			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){

				$tempValue= $data->val($i,$colIndex);
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);
				if($arrField[$row]=="POSITION_ID")
				{
					if (!empty($tempValue))
					{
						$statement =" AND A.POSITION_ID ='".$tempValue."' AND TIPE IS NULL";
						$check = new Import();
						$check->selectByParamsCheckJabatan(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqPositionId=$check->getField("POSITION_ID");
						unset($check);

						if(empty($reqPositionId))
						{
							$set->setField("POSITION_ID",$tempValue);
						}
						else
						{
							echo "xxx***Kode Jabatan ".$tempValue." sudah ada";
							exit();
						}
					}
					else
					{
						echo "xxx***Kode Jabatan ".$tempValue." belum Diisi";
							exit();
					}
				}
				else if($arrField[$row]=="DISTRIK_ID")
				{
					if (!empty($tempValue))
					{
						$statement =" AND A.DISTRIK_ID = '".$tempValue."'";
						$check = new Import();
						$check->selectByParamsCheckDistrik(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqKode=$check->getField("KODE");
						unset($check);
						if(empty($reqKode))
						{
							echo "xxx***Kode Distrik  ".$tempValue." tidak ditemukan";
							exit();
						}
						else
						{
							$set->setField("KODE_DISTRIK",$reqKode);
						}
					}
					else
					{
						// $set->setField("KODE_DISTRIK",ValToNullDB($tempValue));
					}
				}
				else
				{
					$set->setField($arrField[$row],$tempValue);
				}
				$colIndex++;
			}

			$set->setField("SUPERIOR_ID",$reqSuperiorId);

			if (!empty($reqId))
			{	
				$set->setField("LAST_UPDATE_DATE", "NOW()");
				$set->setField("LAST_UPDATE_USER", $this->appusernama);
				$set->setField("POSITION_ID",$reqId);			
				if($set->updatejabatan())
				{
					$reqSimpan = 1;
					
				}
			}
			else
			{
				$set->setField("LAST_CREATE_DATE", "NOW()");
				$set->setField("LAST_CREATE_USER", $this->appusernama);
				if($set->insertjabatan())
				{
					$reqSimpan = 1;
					
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

	function wo_standing() 
	{
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

		if(empty($tipefile))
		{
			echo "xxx***Pilih file terlebih dahulu";exit;
		}
		else
		{
			if($acceptable !== $tipefile) {
				echo "xxx***File gagal diupload, Pastikan File berformat XLS";exit;
			}
		}
		
		$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);

		$reqSuperiorId= $this->input->post("reqSuperiorId");


		$baris = $data->rowcount($sheet_index=0);

		$arrField= array("KODE_DISTRIK","KODE_BLOK","KODE_UNIT_M","GROUP_PM","PM_YEAR","COST_PM_YEARLY");

		$this->load->model("base-app/Import");
		$this->load->model("base-app/WoStanding");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;

		for ($z=2; $z<=$baris; $z++)
		{
			$colIndexCheck=1;
			$arrDataCheck= [];
			for($rowCheck=0; $rowCheck < count($arrField); $rowCheck++)
			{
				$tempValueCheck= $data->val($z,$colIndexCheck);
				if($arrField[$rowCheck]=="KODE_DISTRIK")
				{
					if (!empty($tempValueCheck))
					{
						$statement =" AND A.KODE = '".$tempValueCheck."'";
						$check = new Import();
						$check->selectByParamsCheckDistrik(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqKode=$check->getField("KODE");
						unset($check);
						if(empty($reqKode))
						{
							echo "xxx***Kode Distrik  ".$tempValueCheck." tidak ditemukan";
							exit();
						}
						else
						{
							$set->setField("KODE_DISTRIK",$reqKode);
						}
					}
					else
					{
						// $set->setField("KODE_DISTRIK",ValToNullDB($tempValueCheck));
					}
				}
				else if($arrField[$rowCheck]=="KODE_BLOK")
				{
					$tempValDistrik= $data->val($z,1);
					if (!empty($tempValDistrik) && !empty($tempValueCheck))
					{
						$statement =" AND A.KODE = '".$tempValDistrik."'";
						$check = new Import();
						$check->selectByParamsCheckDistrik(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqDistrikId=$check->getField("DISTRIK_ID");
						unset($check);

						$statement =" AND A.KODE = '".$tempValueCheck."' AND B.DISTRIK_ID = '".$reqDistrikId."'  ";
						$check = new Import();
						$check->selectByParamsCheckBlok(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqKodeBlok=$check->getField("KODE");
						unset($check);

						if(empty($reqKodeBlok))
						{
							echo "xxx***Kode Blok  ".$tempValueCheck." tidak ditemukan";
							exit();
						}
						else
						{
							$set->setField("KODE_BLOK",$reqKodeBlok);
						}
					}
					else
					{
						// $set->setField("KODE_DISTRIK",ValToNullDB($tempValueCheck));
					}
				}
				else if($arrField[$rowCheck]=="KODE_UNIT_M")
				{
					$tempValDistrik= $data->val($z,1);
					$tempValBlok= $data->val($z,2);
					if (!empty($tempValDistrik) && !empty($tempValBlok) && !empty($tempValueCheck))
					{
						$statement =" AND A.KODE = '".$tempValDistrik."'";
						$check = new Import();
						$check->selectByParamsCheckDistrik(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqDistrikId=$check->getField("DISTRIK_ID");
						unset($check);

						$statement =" AND A.KODE = '".$tempValBlok."' AND B.DISTRIK_ID = '".$reqDistrikId."'  ";
						$check = new Import();
						$check->selectByParamsCheckBlok(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqIdBlok=$check->getField("BLOK_UNIT_ID");
						unset($check);

						$statement =" AND A.KODE = '".$tempValueCheck."' AND B.DISTRIK_ID = '".$reqDistrikId."' AND C.BLOK_UNIT_ID = '".$reqIdBlok."'  ";
						$check = new Import();
						$check->selectByParamsCheckUnitMesin(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqKodeUnitMesin=$check->getField("KODE");
						unset($check);

						if(empty($reqKodeUnitMesin))
						{
							echo "xxx***Kode Unit Mesin  ".$tempValueCheck." tidak ditemukan";
							exit();
						}
						else
						{
							$set->setField("KODE_UNIT_M",$reqKodeUnitMesin);
						}
					}
					else
					{
						// $set->setField("KODE_DISTRIK",ValToNullDB($tempValueCheck));
					}
				}
				else if($arrField[$rowCheck]=="GROUP_PM")
				{
					$tempValDistrik= $data->val($z,1);
					$tempValBlok= $data->val($z,2);
					$tempValUnitMesin= $data->val($z,3);
					if (!empty($tempValDistrik) && !empty($tempValBlok) && !empty($tempValueCheck))
					{
						$statement =" AND A.KODE = '".$tempValDistrik."'";
						$check = new Import();
						$check->selectByParamsCheckDistrik(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqDistrikId=$check->getField("DISTRIK_ID");
						$reqDistrikKode=$check->getField("KODE");
						unset($check);

						$statement =" AND A.KODE = '".$tempValBlok."' AND B.DISTRIK_ID = '".$reqDistrikId."'  ";
						$check = new Import();
						$check->selectByParamsCheckBlok(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqIdBlok=$check->getField("BLOK_UNIT_ID");
						$reqKodeBlok=$check->getField("KODE");
						unset($check);

						if ($tempValUnitMesin) 
						{
							$statement =" AND A.KODE = '".$tempValUnitMesin."' AND B.DISTRIK_ID = '".$reqDistrikId."' AND C.BLOK_UNIT_ID = '".$reqIdBlok."'  ";
							$check = new Import();
							$check->selectByParamsCheckUnitMesin(array(), -1, -1, $statement);
							// echo $check->query;exit;
							$check->firstRow();
							$reqKodeUnitMesin=$check->getField("KODE");
							unset($check);

							$statement =" AND A.GROUP_PM = '".$tempValueCheck."' AND A.KODE_DISTRIK = '".$reqDistrikKode."' AND A.KODE_BLOK = '".$reqKodeBlok."' AND A.KODE_UNIT = '".$tempValUnitMesin."'  ";
							$check = new Import();
							$check->selectByParamsCheckGroupPmLccm(array(), -1, -1, $statement);
							// echo $check->query;exit;
							$check->firstRow();
							$reqGroupPm=$check->getField("GROUP_PM");
							unset($check);
						}
						else
						{
							$statement =" AND A.GROUP_PM = '".$tempValueCheck."' AND A.KODE_DISTRIK = '".$reqDistrikKode."' AND A.KODE_BLOK = '".$reqKodeBlok."'  ";
							$check = new Import();
							$check->selectByParamsCheckGroupPmLccm(array(), -1, -1, $statement);
							// echo $check->query;exit;
							$check->firstRow();
							$reqGroupPm=$check->getField("GROUP_PM");
							unset($check);
						}
							

						if(empty($reqGroupPm))
						{
							echo "xxx***GROUP PM  ".$tempValueCheck." tidak ditemukan";
							exit();
						}
						else
						{
							$set->setField("GROUP_PM",$reqGroupPm);
						}
					}
					else
					{
						// $set->setField("KODE_DISTRIK",ValToNullDB($tempValueCheck));
					}
				}
				else
				{
				}
				// print_r($tempValueCheck);
				$colIndexCheck++;
			}
		}


		for ($i=2; $i<=$baris; $i++){
			// validasi kalau kode/id kosong
			// if(empty($data->val($i,2)))
			// 	continue;
			
			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){

				$tempValue= $data->val($i,$colIndex);
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);

				$tempValDistrik= $data->val($i,1);
				$tempValBlok= $data->val($i,2);
				$tempValUnitMesin= $data->val($i,3);
				$tempValGroupPm= $data->val($i,4);
				$tempValYear= $data->val($i,5);
				
				
				$set->setField($arrField[$row],$tempValue);
				


				$statementupdate = " AND A.KODE_BLOK = '".$tempValBlok."' AND A.KODE_DISTRIK = '".$tempValDistrik."'";

				if(!empty($tempValUnitMesin))
				{
					$statementupdate .= " AND A.KODE_UNIT_M = '".$tempValUnitMesin."' ";
				}

				if(!empty($tempValGroupPm))
				{
					$statementupdate .= " AND A.GROUP_PM = '".$tempValGroupPm."' ";
				}


				if(!empty($tempValYear))
				{
					$statementupdate .= " AND A.PM_YEAR = '".$tempValYear."' ";
				}


				$checkupdate = new WoStanding();
				$checkupdate->selectByParamsGroup(array(), -1, -1, $statementupdate);
				$checkupdate->firstRow();
				// echo $checkupdate->query;exit; 

				$reqId= $checkupdate->getField("KODE_DISTRIK");


				$statementcheck = " AND A.KODE_BLOK = '".$tempValBlok."' AND A.KODE_DISTRIK = '".$tempValDistrik."'";

				if(!empty($tempValUnitMesin))
				{
					$statementcheck .= " AND A.KODE_UNIT_M = '".$tempValUnitMesin."' ";
				}

				if(!empty($tempValGroupPm))
				{
					$statementcheck .= " AND A.GROUP_PM = '".$tempValGroupPm."' ";
				}

				$checkstate = new WoStanding();
				$checkstate->selectByParamsGroup(array(), -1, -1, $statementcheck);
				$checkstate->firstRow();

				$reqStateStatus= $checkstate->getField("STATE_STATUS");
				


				$set->setField("STATE_STATUS",$reqStateStatus);

			
				$colIndex++;
			}

			// $set->setField("SUPERIOR_ID",$reqSuperiorId);

			if (!empty($reqId))
			{	
				$set->setField("LAST_UPDATE_DATE", "NOW()");
				$set->setField("LAST_UPDATE_USER", $this->appusernama);
				if($set->updatewostanding())
				{
					$reqSimpan = 1;
					
				}
			}
			else
			{
				$set->setField("LAST_CREATE_DATE", "NOW()");
				$set->setField("LAST_CREATE_USER", $this->appusernama);
				if($set->insertwostanding())
				{
					$reqSimpan = 1;
					
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

	function user_eksternal() 
	{
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

		if(empty($tipefile))
		{
			echo "xxx***Pilih file terlebih dahulu";exit;
		}
		else
		{
			if($acceptable !== $tipefile) {
				echo "xxx***File gagal diupload, Pastikan File berformat XLS";exit;
			}
		}
		
		$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);

		$baris = $data->rowcount($sheet_index=0);

		$arrField= array("NID","NAMA","NO_TELP","EMAIL","DISTRIK_ID","POSITION_ID","ROLE_ID","PERUSAHAAN_EKSTERNAL_ID","EXPIRED_DATE");

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		for ($i=2; $i<=$baris; $i++){
			// validasi kalau kode/id kosong
			// if(empty($data->val($i,2)))
			// 	continue;
			
			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){

				$tempValue= $data->val($i,$colIndex);
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);
				if($arrField[$row]=="NID")
				{
					if (!empty($tempValue))
					{
						$statement =" AND A.NID = '".$tempValue."'";
						$check = new Import();
						$check->selectByParamsCheckPenggunaEksternal(array(), -1, -1, $statement);
						// echo $tempValue;exit;
						$check->firstRow();
						$reqId=$check->getField("PENGGUNA_EXTERNAL_ID");
						$reqNid=$check->getField("NID");
						unset($check);
						if(empty($reqId))
						{
							$set->setField("NID",$tempValue);
						}
						else
						{
							$set->setField("NID",$reqNid);
						}
					}
					else
					{
						echo "xxx***NID baris ke ".$baris." Belum Diisi";
						exit();
					}
				}
				else if($arrField[$row]=="NO_TELP")
				{
					if (is_numeric($tempValue))
					{
						$set->setField("NO_TELP",$tempValue);
					}
					else
					{
						echo "xxx***No telp baris ke ".$baris." harus berformat numeric";
						exit();
					}
				}
				else if($arrField[$row]=="POSITION_ID")
				{
					if (!empty($tempValue))
					{
						$statement =" AND A.POSITION_ID = '".$tempValue."'";
						$check = new Import();
						$check->selectByParamsCheckMasterJabatan(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqPositionId=$check->getField("POSITION_ID");
						unset($check);
						if(empty($reqPositionId))
						{
							echo "xxx***Id Jabatan ".$tempValue." tidak ditemukan";
							exit();
						}
						else
						{
							$set->setField("POSITION_ID",$reqPositionId);
						}
					}
					else
					{
						$set->setField("POSITION_ID",ValToNullDB($reqPositionId));
					}
				}
				else if($arrField[$row]=="ROLE_ID")
				{
					if (!empty($tempValue))
					{
						$statement =" AND A.ROLE_ID = '".$tempValue."'";
						$check = new Import();
						$check->selectByParamsCheckRole(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqRoleId=$check->getField("ROLE_ID");
						unset($check);
						if(empty($reqRoleId))
						{
							echo "xxx***Id Role ".$tempValue." tidak ditemukan";
							exit();
						}
						else
						{
							$set->setField("ROLE_ID",$reqRoleId);
						}
					}
				}
				else if($arrField[$row]=="PERUSAHAAN_EKSTERNAL_ID")
				{
					if (!empty($tempValue))
					{
						$statement =" AND A.PERUSAHAAN_EKSTERNAL_ID = '".$tempValue."'";
						$check = new Import();
						$check->selectByParamsCheckPerusahaanExternal(array(), -1, -1, $statement);
							// echo $check->query;exit;
						$check->firstRow();
						$reqPerusahaanId=$check->getField("PERUSAHAAN_EKSTERNAL_ID");
						unset($check);
						if(empty($reqPerusahaanId))
						{
							echo "xxx***Id Perusahaan ".$tempValue." tidak ditemukan";
							exit();
						}
						else
						{
							$set->setField("PERUSAHAAN_EKSTERNAL_ID",$reqPerusahaanId);
						}
					}
					else
					{
						$set->setField("PERUSAHAAN_EKSTERNAL_ID",ValToNullDB($reqPerusahaanId));
					}
				}
				else if($arrField[$row]=="EXPIRED_DATE")
				{

					if (!empty($tempValue))
					{
						$tempValue = date("d-m-Y", strtotime($tempValue));
						// print_r($tempValue);exit;

						$set->setField("EXPIRED_DATE",dateToDBCheck($tempValue));
					}
				}
				else
				{
					$set->setField($arrField[$row],$tempValue);
				}
				$colIndex++;
			}

			if (!empty($reqId))
			{	
				$set->setField("LAST_UPDATE_DATE", "NOW()");
				$set->setField("LAST_UPDATE_USER", $this->appusernama);
				$set->setField("PENGGUNA_EXTERNAL_ID",$reqId);			
				if($set->updatepenggunaeksternal())
				{
					$reqSimpan = 1;
				}
			}
			else
			{
				$set->setField("LAST_CREATE_DATE", "NOW()");
				$set->setField("LAST_CREATE_USER", $this->appusernama);
				$set->setField("PASSWORD", md5("admin"));
				if($set->insertpenggunaeksternal())
				{
					$reqSimpan = 1;
					// $reqTipeInputId=$set->id;
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

	function user_internal() 
	{
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

		if(empty($tipefile))
		{
			echo "xxx***Pilih file terlebih dahulu";exit;
		}
		else
		{
			if($acceptable !== $tipefile) {
				echo "xxx***File gagal diupload, Pastikan File berformat XLS";exit;
			}
		}
		
		$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);

		$baris = $data->rowcount($sheet_index=0);
		// print_r($baris);exit;

		$arrField= array("NID","NAMA","NO_TELP","EMAIL","DISTRIK_ID","POSITION_ID","ROLE_ID","PERUSAHAAN_EKSTERNAL_ID","EXPIRED_DATE");

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		for ($i=2; $i<=$baris; $i++){
			// validasi kalau kode/id kosong
			// if(empty($data->val($i,2)))
			// 	continue;
			
			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){

				$tempValue= $data->val($i,$colIndex);
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);
				if($arrField[$row]=="NID")
				{
					if (!empty($tempValue))
					{
						$statement =" AND A.NID = '".$tempValue."'";
						$check = new Import();
						$check->selectByParamsCheckPenggunaEksternal(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqId=$check->getField("PENGGUNA_INTERNAL_ID");
						$reqNid=$check->getField("NID");
						unset($check);
						if(empty($reqId))
						{
							$set->setField("NID",$tempValue);
						}
						else
						{
							$set->setField("NID",$reqNid);
						}
						// else
						// {
						// 	echo "xxx***NID baris ke ".$baris." Sudah Ada";
						// 	exit();
						// }
						
					}
					else
					{
						echo "xxx***NID baris ke ".$baris." Belum Diisi";
						exit();
					}
				}
				else if($arrField[$row]=="NO_TELP")
				{
					if (is_numeric($tempValue))
					{
						$set->setField("NO_TELP",$tempValue);
					}
					else
					{
						echo "xxx***No telp baris ke ".$baris." harus berformat numeric";
						exit();
					}
				}
				else if($arrField[$row]=="POSITION_ID")
				{
					if (!empty($tempValue))
					{
						$statement =" AND A.POSITION_ID = '".$tempValue."'";
						$check = new Import();
						$check->selectByParamsCheckMasterJabatan(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqPositionId=$check->getField("POSITION_ID");
						unset($check);
						if(empty($reqPositionId))
						{
							echo "xxx***Id Jabatan ".$tempValue." tidak ditemukan";
							exit();
						}
						else
						{
							$set->setField("POSITION_ID",$reqPositionId);
						}
					}
					else
					{
						$set->setField("POSITION_ID",ValToNullDB($reqPositionId));
					}
				}
				else if($arrField[$row]=="ROLE_ID")
				{
					if (!empty($tempValue))
					{
						$statement =" AND A.ROLE_ID = '".$tempValue."'";
						$check = new Import();
						$check->selectByParamsCheckRole(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqRoleId=$check->getField("ROLE_ID");
						unset($check);
						if(empty($reqRoleId))
						{
							echo "xxx***Id Role ".$tempValue." tidak ditemukan";
							exit();
						}
						else
						{
							$set->setField("ROLE_ID",$reqRoleId);
						}
					}
				}
				else if($arrField[$row]=="PERUSAHAAN_EKSTERNAL_ID")
				{
					if (!empty($tempValue))
					{
						$statement =" AND A.PERUSAHAAN_EKSTERNAL_ID = '".$tempValue."'";
						$check = new Import();
						$check->selectByParamsCheckPerusahaanExternal(array(), -1, -1, $statement);
							// echo $check->query;exit;
						$check->firstRow();
						$reqPerusahaanId=$check->getField("PERUSAHAAN_EKSTERNAL_ID");
						unset($check);
						if(empty($reqPerusahaanId))
						{
							echo "xxx***Id Perusahaan ".$tempValue." tidak ditemukan";
							exit();
						}
						else
						{
							$set->setField("PERUSAHAAN_EKSTERNAL_ID",$reqPerusahaanId);
						}
					}
					else
					{
						$set->setField("PERUSAHAAN_EKSTERNAL_ID",ValToNullDB($reqPerusahaanId));
					}
				}
				else if($arrField[$row]=="EXPIRED_DATE")
				{

					if (!empty($tempValue))
					{
						$tempValue = date("d-m-Y", strtotime($tempValue));
						// print_r($tempValue);exit;

						$set->setField("EXPIRED_DATE",dateToDBCheck($tempValue));
					}
				}
				else
				{
					$set->setField($arrField[$row],$tempValue);
				}
				$colIndex++;
			}

			if (!empty($reqId))
			{	
				$set->setField("LAST_UPDATE_DATE", "NOW()");
				$set->setField("LAST_UPDATE_USER", $this->appusernama);
				$set->setField("PENGGUNA_INTERNAL_ID",$reqId);			
				if($set->updatepenggunainternal())
				{
					$reqSimpan = 1;
				}
			}
			else
			{
				$set->setField("LAST_CREATE_DATE", "NOW()");
				$set->setField("LAST_CREATE_USER", $this->appusernama);
				$set->setField("PASSWORD", md5("admin"));
				if($set->insertpenggunainternal())
				{
					$reqSimpan = 1;
					// $reqTipeInputId=$set->id;
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

	function wo_pm() 
	{
		$reqTahun= $this->input->post("reqTahun");

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

		if(empty($tipefile))
		{
			echo "xxx***Pilih file terlebih dahulu";exit;
		}
		else
		{
			if($acceptable !== $tipefile) {
				echo "xxx***File gagal diupload, Pastikan File berformat XLS";exit;
			}
		}

		
		$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);

		$baris = $data->rowcount($sheet_index=0);

		$arrField= array("ASSETNUM","PMNUM","JPNUM","NO_PERSONAL","DURATION_HOURS","PM_IN_YEAR","PM_YEAR");

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		$arrbaris=[];
		for ($z=2; $z<=$baris; $z++)
		{
			$colIndexCheck=1;
			$arrDataCheck= [];
			for($rowCheck=0; $rowCheck < count($arrField); $rowCheck++)
			{
				$tempValueCheck= $data->val($z,$colIndexCheck);
				if($arrField[$rowCheck]=="ASSETNUM")
				{
					if (!empty($tempValueCheck))
					{
						if ( preg_match('/\s/',$tempValueCheck) )
						{
							echo "xxx***Kolom Asset No baris ke ".$z." tidak boleh terdapat spasi";exit;
						}

						$statement =" AND A.ASSETNUM = '".$tempValueCheck."'";
						$check = new Import();
						$check->selectByParamsCheckAssetLccm(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqCheckId=$check->getField("ASSETNUM");
						// unset($check);
						if(empty($reqCheckId))
						{
							echo "xxx***Asset No baris ke ".$z." tidak ditemukan pada Asset lccm";exit;
						}
					}
					else
					{
						echo "xxx***Asset No baris ke ".$z." Belum Diisi";
						exit();
					}
				}
				else if($arrField[$rowCheck]=="PMNUM")
				{
					if (!empty($tempValueCheck))
					{
						// if ( preg_match('/\s/',$tempValueCheck) )
						// {
						// 	echo "xxx***Kolom PM No baris ke ".$z." tidak boleh terdapat spasi";exit;
						// }

					}
					else
					{
						echo "xxx***PM No baris ke ".$z." Belum Diisi";
						exit();
					}
				}
				else if($arrField[$rowCheck]=="JPNUM")
				{
				}
				else if($arrField[$rowCheck]=="NO_PERSONAL")
				{
					if (!empty($tempValueCheck))
					{
						if(is_numeric($tempValueCheck))
						{}
						else
						{
							echo "xxx***Pastikan number personal ke ".$z." berformat angka/numeric";
							exit();
						}
					}
				}
				else if($arrField[$rowCheck]=="DURATION_HOURS")
				{
					if (!empty($tempValueCheck))
					{
						if(is_numeric($tempValueCheck))
						{}
						else
						{
							echo "xxx***Pastikan Duration ke ".$z." berformat angka/numeric";
							exit();
						}
					}
				}
				else if($arrField[$rowCheck]=="PM_IN_YEAR")
				{
					if (!empty($tempValueCheck))
					{
						if(is_numeric($tempValueCheck))
						{}
						else
						{
							echo "xxx***Pastikan Pm Count ke ".$z." berformat angka/numeric";
							exit();
						}
					}
				}
				else if($arrField[$rowCheck]=="PM_YEAR")
				{
					if (!empty($tempValueCheck))
					{
						if(is_numeric($tempValueCheck))
						{}
						else
						{
							echo "xxx***Pastikan Pm Year ke ".$z." berformat angka/numeric";
							exit();
						}
					}
				}
				$colIndexCheck++;	
			}
		}


		for ($i=2; $i<=$baris; $i++){
			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){

				$tempValue= $data->val($i,$colIndex);
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);
				$set->setField($arrField[$row],$tempValue);
				$colIndex++;
			}

			$set->setField("LAST_CREATE_DATE", "NOW()");
			$set->setField("LAST_CREATE_USER", $this->appusernama);
			if($set->insertwopm())
			{
				$reqSimpan = 1;

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

	function wo_pdm() 
	{
		$reqTahun= $this->input->post("reqTahun");

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

		if(empty($tipefile))
		{
			echo "xxx***Pilih file terlebih dahulu";exit;
		}
		else
		{
			if($acceptable !== $tipefile) {
				echo "xxx***File gagal diupload, Pastikan File berformat XLS";exit;
			}
		}

		
		$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);

		$baris = $data->rowcount($sheet_index=0);

		$arrField= array("ASSETNUM","PDMNUM","PDM_DESC","NO_PERSONAL","DURATION_HOURS","PDM_IN_YEAR","PDM_YEAR");

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		$arrbaris=[];
		for ($z=2; $z<=$baris; $z++)
		{
			$colIndexCheck=1;
			$arrDataCheck= [];
			for($rowCheck=0; $rowCheck < count($arrField); $rowCheck++)
			{
				$tempValueCheck= $data->val($z,$colIndexCheck);
				if($arrField[$rowCheck]=="ASSETNUM")
				{
					if (!empty($tempValueCheck))
					{
						if ( preg_match('/\s/',$tempValueCheck) )
						{
							echo "xxx***Kolom Asset No baris ke ".$z." tidak boleh terdapat spasi";exit;
						}

						$statement =" AND A.ASSETNUM = '".$tempValueCheck."'";
						$check = new Import();
						$check->selectByParamsCheckAssetLccm(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqCheckId=$check->getField("ASSETNUM");
						// unset($check);
						if(empty($reqCheckId))
						{
							echo "xxx***Asset No baris ke ".$z." tidak ditemukan pada Asset lccm";exit;
						}
					}
					else
					{
						echo "xxx***Asset No baris ke ".$z." Belum Diisi";
						exit();
					}
				}
				else if($arrField[$rowCheck]=="PDMNUM")
				{
					if (!empty($tempValueCheck))
					{
						if ( preg_match('/\s/',$tempValueCheck) )
						{
							echo "xxx***Kolom PM No baris ke ".$z." tidak boleh terdapat spasi";exit;
						}

					}
					else
					{
						echo "xxx***PM No baris ke ".$z." Belum Diisi";
						exit();
					}
				}
				else if($arrField[$rowCheck]=="NO_PERSONAL")
				{
					if (!empty($tempValueCheck))
					{
						if(is_numeric($tempValueCheck))
						{}
						else
						{
							echo "xxx***Pastikan number personal ke ".$z." berformat angka/numeric";
							exit();
						}
					}
				}
				else if($arrField[$rowCheck]=="DURATION_HOURS")
				{
					if (!empty($tempValueCheck))
					{
						if(is_numeric($tempValueCheck))
						{}
						else
						{
							echo "xxx***Pastikan Duration ke ".$z." berformat angka/numeric";
							exit();
						}
					}
				}
				else if($arrField[$rowCheck]=="PDM_IN_YEAR")
				{
					if (!empty($tempValueCheck))
					{
						if(is_numeric($tempValueCheck))
						{}
						else
						{
							echo "xxx***Pastikan Pdm Count ke ".$z." berformat angka/numeric";
							exit();
						}
					}
				}
				else if($arrField[$rowCheck]=="PDM_YEAR")
				{
					if (!empty($tempValueCheck))
					{
						if(is_numeric($tempValueCheck))
						{}
						else
						{
							echo "xxx***Pastikan Pdm Year ke ".$z." berformat angka/numeric";
							exit();
						}
					}
				}
				$colIndexCheck++;	
			}
		}


		for ($i=2; $i<=$baris; $i++){
			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){

				$tempValue= $data->val($i,$colIndex);
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);
				$set->setField($arrField[$row],$tempValue);
				$colIndex++;
			}

			$set->setField("LAST_CREATE_DATE", "NOW()");
			$set->setField("LAST_CREATE_USER", $this->appusernama);
			if($set->insertwopdm())
			{
				$reqSimpan = 1;

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

	function loss_output() 
	{

		$reqTahun= $this->input->post("reqTahun");

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

		if(empty($tipefile))
		{
			echo "xxx***Pilih file terlebih dahulu";exit;
		}
		else
		{
			if($acceptable !== $tipefile) {
				echo "xxx***File gagal diupload, Pastikan File berformat XLS";exit;
			}
		}

		
		$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);

		$baris = $data->rowcount($sheet_index=0);

		$arrField= array("ASSETNUM","START_DATE","STOP_DATE","DURATION_HOURS","LOAD_DERATING","LO_YEAR","STATUS");

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		$arrbaris=[];
		for ($z=2; $z<=$baris; $z++)
		{
			$colIndexCheck=1;
			$arrDataCheck= [];
			for($rowCheck=0; $rowCheck < count($arrField); $rowCheck++)
			{
				$tempValueCheck= $data->val($z,$colIndexCheck);
				if($arrField[$rowCheck]=="ASSETNUM")
				{
					if (!empty($tempValueCheck))
					{
						if ( preg_match('/\s/',$tempValueCheck) )
						{
							echo "xxx***Kolom Asset No baris ke ".$z." tidak boleh terdapat spasi";exit;
						}

						$statement =" AND A.ASSETNUM = '".$tempValueCheck."'";
						$check = new Import();
						$check->selectByParamsCheckAssetLccm(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqCheckId=$check->getField("ASSETNUM");
						// unset($check);
						if(empty($reqCheckId))
						{
							echo "xxx***Asset No baris ke ".$z." tidak ditemukan pada Asset lccm";exit;
						}
					}
					else
					{
						echo "xxx***Asset No baris ke ".$z." Belum Diisi";
						exit();
					}
				}
				else if($arrField[$rowCheck]=="START_DATE")
				{
					if (!empty($tempValueCheck))
					{
						if(empty(checkdatetime($tempValueCheck)))
						{
							echo "xxx***Pastikan Start date baris ke ".$z." Berformat tanggal YYYY-MM-DD HH:MM:SS";
							exit();
						}
					}
					else
					{
						echo "xxx***Start date baris ke ".$z." Belum Diisi";
						exit();
					}
				}
				else if($arrField[$rowCheck]=="STOP_DATE")
				{
					if (!empty($tempValueCheck))
					{
						if(empty(checkdatetime($tempValueCheck)))
						{
							echo "xxx***Pastikan Stop date baris ke ".$z." Berformat tanggal YYYY-MM-DD HH:MM:SS";
							exit();
						}
					}
					else
					{
						echo "xxx***Stop date baris ke ".$z." Belum Diisi";
						exit();
					}
				}
				else if($arrField[$rowCheck]=="DURATION_HOURS")
				{
					if (!empty($tempValueCheck))
					{
						if(is_numeric($tempValueCheck))
						{}
						else
						{
							echo "xxx***Pastikan Duration ke ".$z." berformat angka/numeric";
							exit();
						}
					}
				}
				else if($arrField[$rowCheck]=="LOAD_DERATING")
				{
					if (!empty($tempValueCheck))
					{
						if(is_numeric($tempValueCheck))
						{}
						else
						{
							echo "xxx***Pastikan Load Derating ke ".$z." berformat angka/numeric";
							exit();
						}
					}
				}
				else if($arrField[$rowCheck]=="LO_YEAR")
				{
					if (!empty($tempValueCheck))
					{
						if(is_numeric($tempValueCheck))
						{}
						else
						{
							echo "xxx***Pastikan Lo Year ke ".$z." berformat angka/numeric";
							exit();
						}
					}
				}
				$colIndexCheck++;	
			}
		}


		for ($i=2; $i<=$baris; $i++){
			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){

				$tempValue= $data->val($i,$colIndex);
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);
				if($arrField[$row]=="START_DATE" || $arrField[$row]=="STOP_DATE")
				{
					$set->setField($arrField[$row],dateTimeToDBCheckNew($tempValue));
				}
				else
				{
					$set->setField($arrField[$row],$tempValue);
				}
				
				$colIndex++;
			}

			$set->setField("LAST_CREATE_DATE", "NOW()");
			$set->setField("LAST_CREATE_USER", $this->appusernama);
			if($set->insertloss())
			{
				$reqSimpan = 1;

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

	function prk() 
	{

		$reqTahun= $this->input->post("reqTahun");

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

		if(empty($tipefile))
		{
			echo "xxx***Pilih file terlebih dahulu";exit;
		}
		else
		{
			if($acceptable !== $tipefile) {
				echo "xxx***File gagal diupload, Pastikan File berformat XLS";exit;
			}
		}

		
		$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);

		$baris = $data->rowcount($sheet_index=0);

		$arrField= array("ASSETNUM","PRK_YEAR","COST_ON_ASSET","PROJ_DESC","PO_NO","VALUE_PAID","LAST_APPR_DATE","DSTRCT_CODE","ACCOUNT_CODE","PROJECT_NO");

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		$arrbaris=[];
		for ($z=2; $z<=$baris; $z++)
		{
			$colIndexCheck=1;
			$arrDataCheck= [];
			for($rowCheck=0; $rowCheck < count($arrField); $rowCheck++)
			{
				$tempValueCheck= $data->val($z,$colIndexCheck);
				if($arrField[$rowCheck]=="ASSETNUM")
				{
					if (!empty($tempValueCheck))
					{
						if ( preg_match('/\s/',$tempValueCheck) )
						{
							echo "xxx***Kolom Asset No baris ke ".$z." tidak boleh terdapat spasi";exit;
						}

						$statement =" AND A.ASSETNUM = '".$tempValueCheck."'";
						$check = new Import();
						$check->selectByParamsCheckAssetLccm(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqCheckId=$check->getField("ASSETNUM");
						// unset($check);
						if(empty($reqCheckId))
						{
							echo "xxx***Asset No baris ke ".$z." tidak ditemukan pada Asset lccm";exit;
						}
					}
					else
					{
						echo "xxx***Asset No baris ke ".$z." Belum Diisi";
						exit();
					}
				}
				else if($arrField[$rowCheck]=="PRK_YEAR")
				{
					if (!empty($tempValueCheck))
					{
						if(is_numeric($tempValueCheck))
						{}
						else
						{
							echo "xxx***Pastikan Prk Year ke ".$z." berformat angka/numeric";
							exit();
						}
					}
					else
					{
						echo "xxx***Prk Year baris ke ".$z." Belum Diisi";
						exit();
					}
				}
				else if($arrField[$rowCheck]=="COST_ON_ASSET")
				{
					if (!empty($tempValueCheck))
					{
						if(is_numeric($tempValueCheck))
						{}
						else
						{
							echo "xxx***Pastikan Cost ke ".$z." berformat angka/numeric";
							exit();
						}
					}
					else
					{
						echo "xxx*** Cost baris ke ".$z." Belum Diisi";
						exit();
					}
				}
				else if($arrField[$rowCheck]=="VALUE_PAID")
				{
					if (!empty($tempValueCheck))
					{
						if(is_numeric($tempValueCheck))
						{}
						else
						{
							echo "xxx***Pastikan Value Paid ke ".$z." berformat angka/numeric";
							exit();
						}
					}
				}
				// else if($arrField[$rowCheck]=="LAST_APPR_DATE")
				// {
				// 	if (!empty($tempValueCheck))
				// 	{
				// 		if(empty(checkdatetime($tempValueCheck)))
				// 		{
				// 			echo "xxx***Pastikan Last Appr date baris ke ".$z." Berformat tanggal YYYY-MM-DD HH:MM:SS";
				// 			exit();
				// 		}
				// 	}
					
				// }
				
				$colIndexCheck++;	
			}
		}


		for ($i=2; $i<=$baris; $i++){
			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){

				$tempValue= $data->val($i,$colIndex);
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);
				if($arrField[$row]=="LAST_APPR_DATE")
				{
					if(!empty($tempValue))
					{
						$tempValue= DateTime::createFromFormat('Y-m-d', $tempValue);
						$tempValue=$tempValue->format('Y-m-d');
						$set->setField($arrField[$row],dateToDBCheck2($tempValue));
					}
					else
					{
						$set->setField($arrField[$row], "NOW()");
					}
					
				}
				else if($arrField[$row]=="VALUE_PAID")
				{
					$set->setField($arrField[$row],ValToNullDB($tempValue));
				}
				else
				{
					$set->setField($arrField[$row],$tempValue);
				}
				
				$colIndex++;
			}

			$set->setField("LAST_CREATE_DATE", "NOW()");
			$set->setField("LAST_CREATE_USER", $this->appusernama);
			if($set->insertprk())
			{
				$reqSimpan = 1;

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

	function operation() 
	{

		$reqTahun= $this->input->post("reqTahun");

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

		if(empty($tipefile))
		{
			echo "xxx***Pilih file terlebih dahulu";exit;
		}
		else
		{
			if($acceptable !== $tipefile) {
				echo "xxx***File gagal diupload, Pastikan File berformat XLS";exit;
			}
		}

		
		$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);

		$baris = $data->rowcount($sheet_index=0);

		$arrField= array("ASSETNUM","OPR_YEAR","ELECT_lOSS","EFF_LOSS");

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		$arrbaris=[];
		for ($z=2; $z<=$baris; $z++)
		{
			$colIndexCheck=1;
			$arrDataCheck= [];
			for($rowCheck=0; $rowCheck < count($arrField); $rowCheck++)
			{
				$tempValueCheck= $data->val($z,$colIndexCheck);
				if($arrField[$rowCheck]=="ASSETNUM")
				{
					if (!empty($tempValueCheck))
					{
						if ( preg_match('/\s/',$tempValueCheck) )
						{
							echo "xxx***Kolom Asset No baris ke ".$z." tidak boleh terdapat spasi";exit;
						}

						$statement =" AND A.ASSETNUM = '".$tempValueCheck."'";
						$check = new Import();
						$check->selectByParamsCheckAssetLccm(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqCheckId=$check->getField("ASSETNUM");
						// unset($check);
						if(empty($reqCheckId))
						{
							echo "xxx***Asset No baris ke ".$z." tidak ditemukan pada Asset lccm";exit;
						}
					}
					else
					{
						echo "xxx***Asset No baris ke ".$z." Belum Diisi";
						exit();
					}
				}
				else if($arrField[$rowCheck]=="OPR_YEAR")
				{
					if (!empty($tempValueCheck))
					{
						if(is_numeric($tempValueCheck))
						{}
						else
						{
							echo "xxx***Pastikan Opr Year ke ".$z." berformat angka/numeric";
							exit();
						}
					}
					else
					{
						echo "xxx***Opr Year baris ke ".$z." Belum Diisi";
						exit();
					}
				}
				else if($arrField[$rowCheck]=="ELECT_lOSS")
				{
					if (!empty($tempValueCheck))
					{
						if(is_numeric($tempValueCheck))
						{}
						else
						{
							echo "xxx***Pastikan Elect Loss ke ".$z." berformat angka/numeric";
							exit();
						}
					}
				}
				else if($arrField[$rowCheck]=="EFF_LOSS")
				{
					if (!empty($tempValueCheck))
					{
						if(is_numeric($tempValueCheck))
						{}
						else
						{
							echo "xxx***Pastikan Eff Loss ke ".$z." berformat angka/numeric";
							exit();
						}
					}
				}
				
				
				$colIndexCheck++;	
			}
		}

		$reqId="";
		for ($i=2; $i<=$baris; $i++){
			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){

				$tempValue= $data->val($i,$colIndex);
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);
				$set->setField($arrField[$row],$tempValue);

				$opryear=$data->val($i,2);
				$assetnum=$data->val($i,1);
				$statement =" AND A.ASSETNUM = '".$assetnum."' AND A.OPR_YEAR = '".$opryear."'";
				$check = new Import();
				$check->selectByParamsCheckOperationAsset(array(), -1, -1, $statement);
					// echo $check->query;
				$check->firstRow();
				$reqCheckAsset=$check->getField("ASSETNUM");
				
				$colIndex++;
			}

			$set->setField("LAST_CREATE_DATE", "NOW()");
			$set->setField("LAST_CREATE_USER", $this->appusernama);

			if(empty($reqCheckAsset))
			{
				$set->setField("LAST_CREATE_DATE", "NOW()");
				$set->setField("LAST_CREATE_USER", $this->appusernama);
				if($set->insertopasset())
				{
					$reqSimpan = 1;
				}
			}
			else
			{
				$set->setField("LAST_UPDATE_DATE", "NOW()");
				$set->setField("LAST_UPDATE_USER", $this->appusernama);

				if($set->updateopasset())
				{
					$reqSimpan = 1;
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


	function oh_labor() 
	{

		$reqTahun= $this->input->post("reqTahun");

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

		if(empty($tipefile))
		{
			echo "xxx***Pilih file terlebih dahulu";exit;
		}
		else
		{
			if($acceptable !== $tipefile) {
				echo "xxx***File gagal diupload, Pastikan File berformat XLS";exit;
			}
		}

		
		$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);

		$baris = $data->rowcount($sheet_index=0);

		$arrField= array("ASSETNUM","OH_TYPE","DURATION_HOURS","NO_PERSONAL");

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$reqMode="";
		$index=2;
		$arrbaris=[];
		for ($z=2; $z<=$baris; $z++)
		{
			$colIndexCheck=1;
			$arrDataCheck= [];
			for($rowCheck=0; $rowCheck < count($arrField); $rowCheck++)
			{
				$tempValueCheck= $data->val($z,$colIndexCheck);
				if($arrField[$rowCheck]=="ASSETNUM")
				{
					if (!empty($tempValueCheck))
					{
						if ( preg_match('/\s/',$tempValueCheck) )
						{
							echo "xxx***Kolom Asset No baris ke ".$z." tidak boleh terdapat spasi";exit;
						}

						$statement =" AND A.ASSETNUM = '".$tempValueCheck."'";
						$check = new Import();
						$check->selectByParamsCheckAssetLccm(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqCheckId=$check->getField("ASSETNUM");
						// unset($check);
						if(empty($reqCheckId))
						{
							echo "xxx***Asset No baris ke ".$z." tidak ditemukan pada Asset lccm";exit;
						}
					}
					else
					{
						echo "xxx***Asset No baris ke ".$z." Belum Diisi";
						exit();
					}
				}
				else if($arrField[$rowCheck]=="OH_TYPE")
				{
					if (!empty($tempValueCheck))
					{

						$statement =" AND A.OH_TYPE = '".$tempValueCheck."'";
						$check = new Import();
						$check->selectByParamsOhType(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqCheckId=$check->getField("OH_TYPE");
						// unset($check);
						if(empty($reqCheckId))
						{
							echo "xxx***Oh Type baris ke ".$z." tidak ditemukan di database";exit;
						}
					}
					else
					{
						echo "xxx***Oh Type baris ke ".$z." Belum Diisi";
						exit();
					}
				}
				else if($arrField[$rowCheck]=="DURATION_HOURS")
				{
					if (!empty($tempValueCheck))
					{
						if(is_numeric($tempValueCheck))
						{}
						else
						{
							echo "xxx***Pastikan Duration Hours ke ".$z." berformat angka/numeric";
							exit();
						}
					}
					
				}
				else if($arrField[$rowCheck]=="NO_PERSONAL")
				{
					if (!empty($tempValueCheck))
					{
						if(is_numeric($tempValueCheck))
						{}
						else
						{
							echo "xxx***Pastikan Number Personal ke ".$z." berformat angka/numeric";
							exit();
						}
					}
				}
				
				$colIndexCheck++;	
			}
		}


		for ($i=2; $i<=$baris; $i++){
			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){
				$tempValue= $data->val($i,$colIndex);
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);

				if($arrField[$row]=="DURATION_HOURS" || $arrField[$row]=="NO_PERSONAL")
				{
					$set->setField($arrField[$row],ValToNullDB($tempValue));
				}
				else
				{
					$set->setField($arrField[$row],$tempValue);
				}

				if($arrField[$row]=="ASSETNUM" || $arrField[$row]=="OH_TYPE")
				{

					$ohtype=$data->val($i,2);
					$assetnum=$data->val($i,1);
					$statement =" AND A.ASSETNUM = '".$assetnum."' AND A.OH_TYPE = '".$ohtype."'";
					$check = new Import();
					$check->selectByParamsCheckOhLabor(array(), -1, -1, $statement);
					// echo $check->query;
					$check->firstRow();
					$reqCheckAsset=$check->getField("ASSETNUM");
					$reqCheckOhtype=$check->getField("OH_TYPE");
					if(empty($reqCheckAsset))
					{
						$reqMode="insert";
					}
					else
					{
						$reqMode="update";
						$set->setField("ASSETNUM_OLD",$reqCheckAsset);
						$set->setField("OH_TYPE_OLD",$reqCheckOhtype);
					}
					
				}
				
				$colIndex++;
			}
			if($reqMode=="insert")
			{
				$set->setField("LAST_CREATE_DATE", "NOW()");
				$set->setField("LAST_CREATE_USER", $this->appusernama);
				if($set->insertohlabor())
				{
					$reqSimpan = 1;

				}
			}
			else
			{
				$set->setField("LAST_UPDATE_DATE", "NOW()");
				$set->setField("LAST_UPDATE_USER", $this->appusernama);
				if($set->updateohlabor())
				{
					$reqSimpan = 1;

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



	function energi_price() 
	{

		$reqTahun= $this->input->post("reqTahun");

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

		if(empty($tipefile))
		{
			echo "xxx***Pilih file terlebih dahulu";exit;
		}
		else
		{
			if($acceptable !== $tipefile) {
				echo "xxx***File gagal diupload, Pastikan File berformat XLS";exit;
			}
		}

		
		$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);

		$baris = $data->rowcount($sheet_index=0);

		$arrField= array("KODE_DISTRIK","KODE_BLOK","PRICE_YEAR","ENERGY_PRICE","STATUS");

		$this->load->model("base-app/Import");
		$this->load->model("base-app/T_Preperation_Lccm");

		$set = new Import();
		
		$reqSimpan="";
		$reqMode="";
		$index=2;
		$arrbaris=[];
		for ($z=2; $z<=$baris; $z++)
		{
			$colIndexCheck=1;
			$arrDataCheck= [];
			for($rowCheck=0; $rowCheck < count($arrField); $rowCheck++)
			{
				$tempValueCheck= $data->val($z,$colIndexCheck);
				if($arrField[$rowCheck]=="KODE_DISTRIK")
				{
					if (!empty($tempValueCheck))
					{
						$statement =" AND A.KODE = '".$tempValueCheck."'";
						$check = new Import();
						$check->selectByParamsCheckDistrik(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqCheckId=$check->getField("KODE");
						// unset($check);
						if(empty($reqCheckId))
						{
							echo "xxx***Kode Distrik baris ke ".$z." tidak ditemukan di database";exit;
						}
					}
					else
					{
						echo "xxx***Kode Distrik baris ke ".$z." Belum Diisi";
						exit();
					}
				}
				else if($arrField[$rowCheck]=="KODE_BLOK")
				{
					if (!empty($tempValueCheck))
					{
						$statement =" AND A.KODE = '".$tempValueCheck."'";
						$check = new Import();
						$check->selectByParamsCheckBlok(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqCheckId=$check->getField("KODE");
						// unset($check);
						if(empty($reqCheckId))
						{
							echo "xxx***Kode Blok baris ke ".$z." tidak ditemukan di database";exit;
						}
					}
					else
					{
						echo "xxx***Kode Blok baris ke ".$z." Belum Diisi";
						exit();
					}
				}
				else if($arrField[$rowCheck]=="PRICE_YEAR")
				{
					if (!empty($tempValueCheck))
					{
						if(is_numeric($tempValueCheck))
						{}
						else
						{
							echo "xxx***Pastikan Tahun ke ".$z." berformat angka/numeric";
							exit();
						}
					}
					
				}
				else if($arrField[$rowCheck]=="ENERGY_PRICE")
				{
					if (!empty($tempValueCheck))
					{
						if(is_numeric($tempValueCheck))
						{}
						else
						{
							$pos = strpos($tempValueCheck, ",");
							if ($pos === 1) 
							{} 
							else 
							{
								echo "xxx***Pastikan Energi Price ke ".$z." berformat angka";
								exit();
							}
							
						}
					}
					
				}
				else if($arrField[$rowCheck]=="STATUS")
				{
					if (!empty($tempValueCheck))
					{
						if($tempValueCheck==1 || $tempValueCheck==2 || $tempValueCheck=="1" || $tempValueCheck=="2")
						{

						}
						else
						{
							echo "xxx***Pastikan Status ke ".$z." harus dengan angka 1 atau 2";
							exit();
						}
					}
					
				}
				
				
				$colIndexCheck++;	
			}
		}


		for ($i=2; $i<=$baris; $i++){
			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){
				$tempValue= $data->val($i,$colIndex);
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);

				if($arrField[$row]=="ENERGY_PRICE" || $arrField[$row]=="PRICE_YEAR")
				{
					$set->setField($arrField[$row],ValToNullDB(str_replace(',', '', $tempValue)));
				}
				else
				{
					$set->setField($arrField[$row],$tempValue);
				}

				if($arrField[$row]=="KODE_DISTRIK" || $arrField[$row]=="KODE_BLOK" || $arrField[$row]=="PRICE_YEAR")
				{

					$kddistrik=$data->val($i,1);
					$kdblok=$data->val($i,2);
					$priceyear=$data->val($i,3);
					$chstatus=$data->val($i,5);
					$statement =" AND A.KODE_DISTRIK = '".$kddistrik."' AND A.KODE_BLOK = '".$kdblok."'  AND A.PRICE_YEAR = '".$priceyear."'";
					$check = new Import();
					$check->selectByParamsCheckEnergiPrice(array(), -1, -1, $statement);
					// echo $check->query;
					$check->firstRow();
					$reqCheckDistrik=$check->getField("KODE_DISTRIK");
					$reqCheckBlok=$check->getField("KODE_BLOK");
					$reqCheckPrice=$check->getField("PRICE_YEAR");
					if(empty($reqCheckDistrik))
					{
						$reqMode="insert";
					}
					else
					{
						$reqMode="update";
						$set->setField("KODE_DISTRIK_OLD",$reqCheckDistrik);
						$set->setField("KODE_BLOK_OLD",$reqCheckBlok);
						$set->setField("PRICE_YEAR_OLD",$reqCheckPrice);
					}
						if(!empty($chstatus))
						{
							
							$statusprep="";
							if($chstatus==1)
							{
								$statusprep='true';
							}
							elseif ($chstatus==2) {
								$statusprep='false';
							}

							$statement=" AND A.KODE_DISTRIK =  '".$reqCheckDistrik."' AND A.KODE_BLOK =  '".$reqCheckBlok."' AND A.YEAR_LCCM =  '".$priceyear."' ";
							$checkprep = new T_Preperation_Lccm();
							$checkprep->selectByParams(array(), -1, -1, $statement);
							// echo $check->query;exit;
							$checkprep->firstRow();
							$checkKodeprep= $checkprep->getField("KODE_DISTRIK");

							if(!empty($checkKodeprep))
							{
								$reqSimpan="";
								$setprep = new T_Preperation_Lccm();
								$setprep->setField("ENERGY_PRICE", $statusprep);
								$setprep->setField("KODE_DISTRIK", $reqCheckDistrik);
								$setprep->setField("KODE_BLOK", $reqCheckBlok);
								$setprep->setField("YEAR_LCCM", $priceyear);
								$setprep->setField("LAST_UPDATE_USER", $this->appusernama);
								$setprep->setField("LAST_UPDATE_DATE", 'NOW()');
								if($setprep->updateenergy())
								{
									$reqSimpan= 1;
								}
							}
							
						}
					
				}
				
				$colIndex++;
			}
			if($reqMode=="insert")
			{
				$set->setField("LAST_CREATE_DATE", "NOW()");
				$set->setField("LAST_CREATE_USER", $this->appusernama);
				if($set->insertenergi())
				{
					$reqSimpan = 1;

				}
			}
			else
			{
				$set->setField("LAST_UPDATE_DATE", "NOW()");
				$set->setField("LAST_UPDATE_USER", $this->appusernama);
				if($set->updateenergi())
				{
					$reqSimpan = 1;

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

	function wo_import() 
	{

		$reqTahun= $this->input->post("reqTahun");

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

		if(empty($tipefile))
		{
			echo "xxx***Pilih file terlebih dahulu";exit;
		}
		else
		{
			if($acceptable !== $tipefile) {
				echo "xxx***File gagal diupload, Pastikan File berformat XLS";exit;
			}
		}

		
		$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);

		$baris = $data->rowcount($sheet_index=0);

		$arrField= array("ASSETNUM","WONUM","WO_DESC","WORKTYPE","WORK_GROUP","NEEDDOWNTIME","REPORTDATE");

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		$arrbaris=[];
		for ($z=2; $z<=$baris; $z++)
		{
			$colIndexCheck=1;
			$arrDataCheck= [];
			for($rowCheck=0; $rowCheck < count($arrField); $rowCheck++)
			{
				$tempValueCheck= $data->val($z,$colIndexCheck);
				if($arrField[$rowCheck]=="ASSETNUM")
				{
					if (!empty($tempValueCheck))
					{
						if ( preg_match('/\s/',$tempValueCheck) )
						{
							echo "xxx***Kolom Asset No baris ke ".$z." tidak boleh terdapat spasi";exit;
						}

						$statement =" AND A.ASSETNUM = '".$tempValueCheck."'";
						$check = new Import();
						$check->selectByParamsCheckAssetLccm(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqCheckId=$check->getField("ASSETNUM");
						// unset($check);
						if(empty($reqCheckId))
						{
							echo "xxx***Asset No baris ke ".$z." tidak ditemukan pada Asset lccm";exit;
						}
					}
					else
					{
						echo "xxx***Asset No baris ke ".$z." Belum Diisi";
						exit();
					}
				}
				else if($arrField[$rowCheck]=="REPORTDATE")
				{
					if (!empty($tempValueCheck))
					{
						if(empty(checkdatetime($tempValueCheck)))
						{
							echo "xxx***Pastikan Start date baris ke ".$z." Berformat tanggal YYYY-MM-DD HH:MM:SS";
							exit();
						}
					}
					else
					{
						echo "xxx***Report date baris ke ".$z." Belum Diisi";
						exit();
					}
				}
				else if($arrField[$rowCheck]=="NEEDDOWNTIME")
				{
					if (!empty($tempValueCheck))
					{
						if(is_numeric($tempValueCheck))
						{
							if($tempValueCheck== 0 ||  $tempValueCheck== 1)
							{}
							else
							{
								echo "xxx***Nilai Downtime ke ".$z." hanya 0 atau 1";
								exit();
							}

						}
						else
						{
							echo "xxx***Pastikan Downtime ke ".$z." berformat angka/numeric";
							exit();
						}
					}
				}

				$colIndexCheck++;	
			}
		}

		$reqId="";
		$woyear="";
		for ($i=2; $i<=$baris; $i++){
			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){

				$tempValue= $data->val($i,$colIndex);
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);
				if($arrField[$row]=="REPORTDATE" )
				{
					$tahunget = new DateTime($tempValue);
					$woyear=$tahunget->format("Y");
					$set->setField($arrField[$row],dateTimeToDBCheckNew($tempValue));
					
				}
				else
				{
					$set->setField($arrField[$row],$tempValue);
				}

				if($arrField[$row]=="WONUM")
				{
					if (!empty($tempValue))
					{
						$statement =" AND A.WONUM = '".$tempValue."'  ";
						$check = new Import();
						$check->selectByParamsCheckWO(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqId=$check->getField("WONUM");
						// unset($check);
						$set->setField("WONUM",$tempValue);

					}
					
				}
				$set->setField("WO_YEAR",ValToNullDB($woyear));
				$colIndex++;
			}

			$set->setField("SITEID","PT");

			if(empty($reqId))
			{
				$set->setField("LAST_CREATE_DATE", "NOW()");
				$set->setField("LAST_CREATE_USER", $this->appusernama);
				if($set->insertwo())
				{
					$reqSimpan = 1;
				}
			}
			else
			{
				$set->setField("LAST_UPDATE_DATE", "NOW()");
				$set->setField("LAST_UPDATE_USER", $this->appusernama);

				if($set->updatewo())
				{
					$reqSimpan = 1;
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


	function asset_lccm() 
	{

		$reqTahun= $this->input->post("reqTahun");

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

		if(empty($tipefile))
		{
			echo "xxx***Pilih file terlebih dahulu";exit;
		}
		else
		{
			if($acceptable !== $tipefile) {
				echo "xxx***File gagal diupload, Pastikan File berformat XLS";exit;
			}
		}

		
		$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);

		$baris = $data->rowcount($sheet_index=0);

		$arrField= array("ASSETNUM","KODE_DISTRIK","KODE_BLOK","KODE_UNIT_M","ASSET_LCCM","PARENT_CHILD","GROUP_PM","ASSET_OH","CAPITAL_DATE","CAPITAL");

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		$arrbaris=[];
		for ($z=2; $z<=$baris; $z++)
		{
			$colIndexCheck=1;
			$arrDataCheck= [];
			for($rowCheck=0; $rowCheck < count($arrField); $rowCheck++)
			{
				$tempValueCheck= $data->val($z,$colIndexCheck);
				if($arrField[$rowCheck]=="ASSETNUM")
				{
					if (!empty($tempValueCheck))
					{
						if ( preg_match('/\s/',$tempValueCheck) )
						{
							// echo "xxx***Kolom Asset No baris ke ".$z." tidak boleh terdapat spasi";exit;
						}

						$statement =" AND A.ASSETNUM = '".$tempValueCheck."'";
						$check = new Import();
						$check->selectByParamsCheckAssetLccm(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqCheckId=$check->getField("ASSETNUM");
						// unset($check);
						if(empty($reqCheckId))
						{
							echo "xxx***Asset No baris ke ".$z." tidak ditemukan pada Asset lccm";exit;
						}
					}
					else
					{
						echo "xxx***Asset No baris ke ".$z." Belum Diisi";
						exit();
					}
				}
				else if($arrField[$row]=="KODE_DISTRIK")
				{
					if (!empty($tempValue))
					{
						$statement =" AND A.KODE = '".$tempValue."'";
						$check = new Import();
						$check->selectByParamsCheckDistrik(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqKode=$check->getField("KODE");
						unset($check);
						if(empty($reqKode))
						{
							echo "xxx***Kode Distrik  ".$tempValue." tidak ditemukan";
							exit();
						}
						else
						{
							$set->setField("KODE_DISTRIK",$reqKode);
						}
					}
					else
					{
						// $set->setField("KODE_DISTRIK",ValToNullDB($tempValue));
					}
				}
				else if($arrField[$row]=="KODE_BLOK")
				{
					$tempValDistrik= $data->val($i,1);
					if (!empty($tempValDistrik) && !empty($tempValue))
					{
						$statement =" AND A.KODE = '".$tempValDistrik."'";
						$check = new Import();
						$check->selectByParamsCheckDistrik(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqDistrikId=$check->getField("DISTRIK_ID");
						unset($check);

						$statement =" AND A.KODE = '".$tempValue."' AND B.DISTRIK_ID = '".$reqDistrikId."'  ";
						$check = new Import();
						$check->selectByParamsCheckBlok(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqKodeBlok=$check->getField("KODE");
						unset($check);

						if(empty($reqKodeBlok))
						{
							echo "xxx***Kode Blok  ".$tempValue." tidak ditemukan";
							exit();
						}
						else
						{
							$set->setField("KODE_BLOK",$reqKodeBlok);
						}
					}
					else
					{
						// $set->setField("KODE_DISTRIK",ValToNullDB($tempValue));
					}
				}
				else if($arrField[$row]=="KODE_UNIT_M")
				{
					$tempValDistrik= $data->val($i,1);
					$tempValBlok= $data->val($i,2);
					if (!empty($tempValDistrik) && !empty($tempValBlok) && !empty($tempValue))
					{
						$statement =" AND A.KODE = '".$tempValDistrik."'";
						$check = new Import();
						$check->selectByParamsCheckDistrik(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqDistrikId=$check->getField("DISTRIK_ID");
						unset($check);

						$statement =" AND A.KODE = '".$tempValBlok."' AND B.DISTRIK_ID = '".$reqDistrikId."'  ";
						$check = new Import();
						$check->selectByParamsCheckBlok(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqIdBlok=$check->getField("BLOK_UNIT_ID");
						unset($check);

						$statement =" AND A.KODE = '".$tempValue."' AND B.DISTRIK_ID = '".$reqDistrikId."' AND C.BLOK_UNIT_ID = '".$reqIdBlok."'  ";
						$check = new Import();
						$check->selectByParamsCheckUnitMesin(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqKodeUnitMesin=$check->getField("KODE");
						unset($check);

						if(empty($reqKodeUnitMesin))
						{
							echo "xxx***Kode Unit Mesin  ".$tempValue." tidak ditemukan";
							exit();
						}
						else
						{
							$set->setField("KODE_UNIT_M",$reqKodeUnitMesin);
						}
					}
					else
					{
						// $set->setField("KODE_DISTRIK",ValToNullDB($tempValue));
					}
				}

				else if($arrField[$row]=="GROUP_PM")
				{
					$tempValDistrik= $data->val($i,2);
					$tempValBlok= $data->val($i,3);
					$tempValUnitMesin= $data->val($i,4);
					if (!empty($tempValDistrik) && !empty($tempValBlok) && !empty($tempValue))
					{
						$statement =" AND A.KODE = '".$tempValDistrik."'";
						$check = new Import();
						$check->selectByParamsCheckDistrik(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqDistrikId=$check->getField("DISTRIK_ID");
						$reqDistrikKode=$check->getField("KODE");
						unset($check);

						$statement =" AND A.KODE = '".$tempValBlok."' AND B.DISTRIK_ID = '".$reqDistrikId."'  ";
						$check = new Import();
						$check->selectByParamsCheckBlok(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqIdBlok=$check->getField("BLOK_UNIT_ID");
						$reqKodeBlok=$check->getField("KODE");
						unset($check);

						if ($tempValUnitMesin) 
						{
							$statement =" AND A.KODE = '".$tempValUnitMesin."' AND B.DISTRIK_ID = '".$reqDistrikId."' AND C.BLOK_UNIT_ID = '".$reqIdBlok."'  ";
							$check = new Import();
							$check->selectByParamsCheckUnitMesin(array(), -1, -1, $statement);
							// echo $check->query;exit;
							$check->firstRow();
							$reqKodeUnitMesin=$check->getField("KODE");
							unset($check);

							$statement =" AND A.GROUP_PM = '".$tempValue."' AND A.KODE_DISTRIK = '".$reqDistrikKode."' AND A.KODE_BLOK = '".$reqKodeBlok."' AND A.KODE_UNIT = '".$tempValUnitMesin."'  ";
							$check = new Import();
							$check->selectByParamsCheckGroupPmLccm(array(), -1, -1, $statement);
							// echo $check->query;exit;
							$check->firstRow();
							$reqGroupPm=$check->getField("GROUP_PM");
							unset($check);
						}
						else
						{
							$statement =" AND A.GROUP_PM = '".$tempValue."' AND A.KODE_DISTRIK = '".$reqDistrikKode."' AND A.KODE_BLOK = '".$reqKodeBlok."'  ";
							$check = new Import();
							$check->selectByParamsCheckGroupPmLccm(array(), -1, -1, $statement);
							// echo $check->query;exit;
							$check->firstRow();
							$reqGroupPm=$check->getField("GROUP_PM");
							unset($check);
						}
							

						if(empty($reqGroupPm))
						{
							echo "xxx***GROUP PM  ".$tempValue." tidak ditemukan";
							exit();
						}
						else
						{
							$set->setField("GROUP_PM",$reqGroupPm);
						}
					}
					else
					{
						// $set->setField("KODE_DISTRIK",ValToNullDB($tempValue));
					}
				}
				else if($arrField[$rowCheck]=="CAPITAL_DATE")
				{
					if (!empty($tempValueCheck))
					{
						if(empty(validateDate($tempValueCheck)))
						{
							echo "xxx***Pastikan Start date baris ke ".$z." Berformat tanggal YYYY-MM-DD";
							exit();
						}
					}
					else
					{
						echo "xxx***Report date baris ke ".$z." Belum Diisi";
						exit();
					}
				}
				else if($arrField[$rowCheck]=="ASSET_LCCM")
				{
					if (!empty($tempValueCheck))
					{
						// var_dump($tempValueCheck);exit;
						if(strtoupper($tempValueCheck)== "TRUE" || strtoupper($tempValueCheck)== "FALSE" ||  $tempValueCheck==1 || $tempValueCheck==0)
						{}
						else
						{
							echo "xxx***Input Asset Lccm ke ".$z." hanya false atau true";
							exit();
						}
					}
				}
				else if($arrField[$rowCheck]=="ASSET_OH")
				{
					if (!empty($tempValueCheck))
					{
						if(strtoupper($tempValueCheck)== "TRUE" || strtoupper($tempValueCheck)== "FALSE" ||  $tempValueCheck==1 || $tempValueCheck==0)
						{}
						else
						{
							echo "xxx***Input Asset Oh ke ".$z." hanya false atau true";
							exit();
						}
					}
				}

				$colIndexCheck++;	
			}
		}

		$reqId="";
		$reqCapital="";
		$reqCapitalDate="";
		for ($i=2; $i<=$baris; $i++){
			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){

				$tempValue= $data->val($i,$colIndex);
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);
				if($arrField[$row]=="CAPITAL_DATE" )
				{
					$reqCapitalDate= $tempValue;
					
				}
				else if($arrField[$row]=="CAPITAL" )
				{
					$reqCapital= $tempValue;
				}
				else if($arrField[$row]=="ASSET_LCCM" || $arrField[$row]=="ASSET_OH" )
				{
					$set->setField($arrField[$row],ValToNullBollDB($tempValue));
				}
				else if($arrField[$row]=="ASSETNUM")
				{
					$tempValNum= $data->val($i,1);
					$tempValDistrik= $data->val($i,2);
					$tempValBlok= $data->val($i,3);
					$tempValUnitMesin= $data->val($i,4);

					$checkSite = new Import();
					$checkSite->selectByParamsCheckSiteId(array(), -1, -1, $tempValBlok, $tempValDistrik);
						// echo $checkSite->query;exit;
					$checkSite->firstRow();
					$reqSiteId=$checkSite->getField("KODE_EAM");
					$set->setField("SITEID",$reqSiteId);

					if (!empty($tempValue))
					{
						$statement =" AND A.ASSETNUM = '".$tempValNum."'  AND A.SITEID = '".$reqSiteId."'";
						$check = new Import();
						$check->selectByParamsCheckAssetLccm(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqId=$check->getField("ASSETNUM");
						$set->setField("ASSETNUM",$tempValue);

						// unset($check);

					}
				}
				else
				{
					$set->setField($arrField[$row],$tempValue);
				}

				
				$colIndex++;
			}


			if(empty($reqId))
			{
				$set->setField("LAST_CREATE_DATE", "NOW()");
				$set->setField("LAST_CREATE_USER", $this->appusernama);
				
				if($set->insertassetlccm())
				{
					$reqSimpan = 1;
				}
			}
			else
			{
				$set->setField("LAST_UPDATE_DATE", "NOW()");
				$set->setField("LAST_UPDATE_USER", $this->appusernama);

				if($set->updateassetlccm())
				{
					$reqSimpan = 1;
				}
			}


			$checkcapital = new Import();
			$set->setField("CAPITAL_DATE", dateToDBCheck2($reqCapitalDate));
			$set->setField("CAPITAL_DATE_UP", $reqCapitalDate);
			$set->setField("CAPITAL", valToNullDB(str_replace(',', '', $reqCapital)));
			$set->setField("ASSETNUM", $tempValNum);
			$set->setField("STATUS", "true");
			$set->setField("KODE_DISTRIK", $tempValDistrik);
			$set->setField("KODE_BLOK", $tempValBlok);
			$set->setField("KODE_UNIT_M", $tempValUnitMesin);

			$statement =" AND A.ASSETNUM = '".$tempValNum."'  AND A.SITEID = '".$reqSiteId."'";

			$check = new Import();
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



	

}