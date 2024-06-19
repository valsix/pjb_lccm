<?php
defined('BASEPATH') or exit('No direct script access allowed');

include_once("functions/default.func.php");
include_once("functions/string.func.php");
include_once("functions/date.func.php");
include_once("functions/class-list-util.php");
include_once("functions/class-list-util-serverside.php");
include_once("functions/excel_reader2.php");

class Import_asset_lccm_json extends CI_Controller
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
		
		$reqSimpan="";
		$index=2;
		$arrbaris=[];
		for ($z=2; $z<=$baris; $z++)
		{

			$set = new Import();
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
			$set = new Import();
			
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
				else
				{
					$set->setField($arrField[$row],$tempValue);
				}


				$tempValNum= $data->val($i,1);
				$tempValDistrik= $data->val($i,2);
				$tempValBlok= $data->val($i,3);
				$tempValUnitMesin= $data->val($i,4);

				$checkSite = new Import();
				$checkSite->selectByParamsCheckSiteId(array(), -1, -1, $tempValBlok, $tempValDistrik);
				$checkSite->firstRow();
				$reqSiteId=$checkSite->getField("KODE_EAM");

				if (!empty($tempValue))
				{
					$statement =" AND A.ASSETNUM = '".$tempValNum."'  AND A.SITEID = '".$reqSiteId."'";
					$check = new Import();
					$check->selectByParamsCheckAssetLccm(array(), -1, -1, $statement);
					// echo $check->query;exit;
					$check->firstRow();
					$reqId=$check->getField("ASSETNUM");

				}

				$set->setField("SITEID",$reqSiteId);
				
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