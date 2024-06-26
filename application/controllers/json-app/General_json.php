<?php
defined('BASEPATH') or exit('No direct script access allowed');

include_once("functions/default.func.php");
include_once("functions/string.func.php");
include_once("functions/date.func.php");
include_once("functions/class-list-util.php");
include_once("functions/class-list-util-serverside.php");

class General_json extends CI_Controller
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

	function preperation_lccm()
	{
		$t= $this->input->get('t');
		$m= $this->input->get('m');
		$value= $this->input->get('value');

		if(!empty($t) && !empty($m))
		{
			$this->load->model("base-app/T_Preperation_Lccm");

			$statement= " AND A.YEAR_LCCM = ".$t;
			$set= new T_Preperation_Lccm();
			$set->selectByParams(array(), -1,-1, $statement);
			$vmode= "insert";
			if($set->firstRow())
			{
				$vmode= "update";
			}
			// echo $vmode;exit;

			if($vmode == "update")
			{
				$setdetil= new T_Preperation_Lccm();
				$setdetil->setField("YEAR_LCCM", $t);
				$setdetil->setField("FIELD", $m);
				$setdetil->setField("FIELD_VALUE", ValToNullBollDB($value));
				$setdetil->setField("LAST_UPDATE_USER", $this->appusernama);
				$setdetil->setField("LAST_UPDATE_DATE", 'NOW()');
				if($setdetil->updatedyna())
				{
					$arrJson["PESAN"] = "Data berhasil diupdate.";
				}
				else
				{
					$arrJson["PESAN"] = "Data gagal diupdate.";	
				}
				unset($setdetil);
			}
		}
		else
		{
			$arrJson["PESAN"] = "-";
		}

		echo json_encode( $arrJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
	}

	function preperation_lccm_new()
	{
		$t= $this->input->get('t');
		$vdistrik= $this->input->get('vdistrik');
		$vblok= $this->input->get('vblok');
		$vunit= $this->input->get('vunit');
		$m= $this->input->get('m');
		$value= $this->input->get('value');

		if(!empty($t) && !empty($m) && !empty($vdistrik)  && !empty($vblok) )
		{
			$this->load->model("base-app/T_Preperation_Lccm");


			$statement= " AND A.YEAR_LCCM = '".$t."' AND A.KODE_DISTRIK = '".$vdistrik."' AND A.KODE_BLOK = '".$vblok."' ";
			if(!empty($vunit))
			{
				$statement.= " AND A.KODE_UNIT_M = '".$vunit."'";
			}
			$set= new T_Preperation_Lccm();
			$set->selectByParams(array(), -1,-1, $statement);
			// echo $set->query;exit;
			$vmode= "insert";
			if($set->firstRow())
			{
				$vmode= "update";
			}
			// echo $vmode;exit;

			if($vmode == "update")
			{
				$setdetil= new T_Preperation_Lccm();
				$setdetil->setField("YEAR_LCCM", $t);
				$setdetil->setField("FIELD", $m);
				$setdetil->setField("KODE_DISTRIK", $vdistrik);
				$setdetil->setField("KODE_BLOK", $vblok);
				$setdetil->setField("KODE_UNIT_M", $vunit);
				$setdetil->setField("FIELD_VALUE", ValToNullBollDB($value));
				$setdetil->setField("LAST_UPDATE_USER", $this->appusernama);
				$setdetil->setField("LAST_UPDATE_DATE", 'NOW()');
				if($setdetil->updatedynanew())
				{
					$arrJson["PESAN"] = "Data berhasil diupdate.";
				}
				else
				{
					$arrJson["PESAN"] = "Data gagal diupdate.";	
				}
				unset($setdetil);
			}
			else
			{
				$arrJson["PESAN"] = "Data tidak ditemukan.";	
			}
		}
		else
		{
			$arrJson["PESAN"] = "-";
		}

		echo json_encode( $arrJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
	}

	function preperation_lccm_prk_loss_output()
	{
		$t= $this->input->get('t');
		$vdistrik= $this->input->get('vdistrik');
		$vblok= $this->input->get('vblok');
		$vunit= $this->input->get('vunit');
		$m= $this->input->get('m');
		$value= $this->input->get('value');

		if(!empty($t) && !empty($m) && !empty($vdistrik)  && !empty($vblok) )
		{
			$this->load->model("base-app/T_Preperation_Lccm");


			$statement= " AND A.YEAR_LCCM = '".$t."' AND A.KODE_DISTRIK = '".$vdistrik."' AND A.KODE_BLOK = '".$vblok."' ";
			if(!empty($vunit))
			{
				$statement.= " AND A.KODE_UNIT_M = '".$vunit."'";
			}
			$set= new T_Preperation_Lccm();
			$set->selectByParams(array(), -1,-1, $statement);
			$vmode= "insert";
			if($set->firstRow())
			{
				$vmode= "update";
			}
			// echo $vmode;exit;

			if($vmode == "update")
			{
				$setdetil= new T_Preperation_Lccm();
				$setdetil->setField("YEAR_LCCM", $t);
				$setdetil->setField("FIELD", $m);
				$setdetil->setField("KODE_DISTRIK", $vdistrik);
				$setdetil->setField("KODE_BLOK", $vblok);
				$setdetil->setField("KODE_UNIT_M", $vunit);
				$setdetil->setField("FIELD_VALUE", ValToNullBollDB($value));
				$setdetil->setField("LAST_UPDATE_USER", $this->appusernama);
				$setdetil->setField("LAST_UPDATE_DATE", 'NOW()');
				if($setdetil->updatedynanew())
				{
					$arrJson["PESAN"] = "Data berhasil diupdate.";
				}
				else
				{
					$arrJson["PESAN"] = "Data gagal diupdate.";	
				}
				unset($setdetil);
			}
		}
		else
		{
			$arrJson["PESAN"] = "-";
		}

		echo json_encode( $arrJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
	}
}