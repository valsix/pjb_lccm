<?php
defined('BASEPATH') or exit('No direct script access allowed');

include_once("functions/default.func.php");
include_once("functions/string.func.php");
include_once("functions/date.func.php");
include_once("functions/class-list-util.php");
include_once("functions/class-list-util-serverside.php");

class wo_standing_json extends CI_Controller
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


	function add()
	{
		$this->load->model("base-app/WoStanding");
		$this->load->model("base-app/T_Preperation_Lccm");

		$reqId= $this->input->post("reqId");
		$reqMode= $this->input->post("reqMode");
		$reqParent= $this->input->post("reqParent");

		$reqDistrikId= $this->input->post("reqDistrikId");
		$reqBlokId= $this->input->post("reqBlokId");
		$reqGroupPm= $this->input->post("reqGroupPm");
		$reqTahun= $this->input->post("reqTahun");
		$reqCost= $this->input->post("reqCost");
		$reqSiteId= $this->input->post("reqSiteId");
		$reqGroupPmOld= $this->input->post("reqGroupPmOld");
		$reqTahunOld= $this->input->post("reqTahunOld");
		$reqCostOld= $this->input->post("reqCostOld");
		$reqUnitMesinId= $this->input->post("reqUnitMesinId");


		$set = new WoStanding();
		$set->setField("KODE_DISTRIK", $reqDistrikId);
		$set->setField("KODE_BLOK", $reqBlokId);
		$set->setField("KODE_BLOK_OLD", $reqSiteId);
		$set->setField("GROUP_PM_OLD", $reqGroupPmOld);
		$set->setField("GROUP_PM", $reqGroupPm);
		$set->setField("PM_YEAR_OLD", $reqTahunOld);
		$set->setField("PM_YEAR", $reqTahun);
		$set->setField("COST_PM_YEARLY",str_replace(',', '', $reqCost));
		$set->setField("COST_PM_YEARLY_OLD",str_replace(',', '', $reqCostOld));
		$set->setField("KODE_UNIT_M", $reqUnitMesinId);
		

		$reqSimpan= "";
		if ($reqMode == "insert")
		{
			$set->setField("LAST_CREATE_USER", $this->appusernama);
			$set->setField("LAST_CREATE_DATE", 'NOW()');
			if($set->insert())
			{
				$reqSimpan= 1;
			}
		}
		else
		{	
			$set->setField("LAST_UPDATE_USER", $this->appusernama);
			$set->setField("LAST_UPDATE_DATE", 'NOW()');

			if($reqParent=='parent')
			{
				if($set->updatesite())
				{
					$reqSimpan= 1;
				}
			}
			else if($reqParent=='group')
			{
				if($set->updategroup())
				{
					$reqSimpan= 1;
				}
			}
			else if($reqParent=='tahun')
			{
				if($set->updatetahun())
				{
					$reqSimpan= 1;
				}
			}
			else 
			{
				if($set->update())
				{
					$reqSimpan= 1;
				}
			}
			
		}



		if($reqSimpan == 1 )
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
			$set->setField("WO_STANDING", 'true' );
			$set->setField("WO_PM", 'false' );
			$set->setField("WO_PDM", 'false' );
			$set->setField("WO_OH", 'false');
			$set->setField("PRK", 'false' );
			$set->setField("LOSS_OUTPUT", 'false' );
			$set->setField("OPERATION", 'false' );
			$set->setField("ENERGY_PRICE", 'false' );
			$set->setField("STATUS_COMPLETE", 'false' );

			if(!empty($checkKode))
			{

				$set->setField("LAST_UPDATE_USER", $this->appusernama);
				$set->setField("LAST_UPDATE_DATE", 'NOW()');
				if($set->updatestanding())
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

		if($reqSimpan == 1 )
		{
			echo $reqId."***Data berhasil disimpan";
		}
		else
		{
			echo "xxx***Data gagal disimpan";
		}
				
	}



	function tree()
	{
		$this->load->model("base-app/WoStanding");

		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$offset = ($page-1)*$rows;//
		$id = isset($_POST['id']) ? $_POST['id'] : 0;//
		$result = array();
		
		$reqId= $this->input->get('reqId');
		$reqDistrikId= $this->input->get('reqDistrikId');
		$reqBlokId= $this->input->get('reqBlokId');
		$reqGroupPm= $this->input->get('reqGroupPm');
		$reqUnitMesinId= $this->input->get('reqUnitMesinId');

		$statementunit= "";

		$statement=  "";


		if ($id == "0")
		{
			$sorder= " ";
			$statement= " ";

			if(!empty($reqDistrikId))
			{
				$statement.=" AND A.KODE_DISTRIK='".$reqDistrikId."'";
			}
			if(!empty($reqBlokId))
			{
				$statement.=" AND A.KODE_BLOK='".$reqBlokId."'";
			}
			if(!empty($reqGroupPm))
			{
				$statement.=" AND A.GROUP_PM='".$reqGroupPm."'";
			}
			if(!empty($reqUnitMesinId))
			{
				$statement.=" AND A.KODE_UNIT_M='".$reqUnitMesinId."'";
			}

			if(!empty($this->appblokunitid))
			{
				$statement.= " AND B.BLOK_UNIT_ID = ".$this->appblokunitid;
			}
			$set= new WoStanding();
			$result["total"] = 0;
			$set->selectByParamsGroup(array(), -1, -1, $statement.$statementunit, $sorder);
			// echo $set->query;exit;
			$i=0;
			while($set->nextRow())
			{
				$valinfoid= $set->getField("GROUP_PM");
				$items[$i]['ID'] = $valinfoid;
				$items[$i]['NAMA'] = $set->getField("GROUP_PM");
				$items[$i]['DISTRIK_NAMA'] = $set->getField("DISTRIK_NAMA");
				$items[$i]['BLOK_NAMA'] = $set->getField("BLOK_NAMA");
				$items[$i]['UNIT_NAMA'] = $set->getField("UNIT_NAMA");
				$items[$i]['LINK_URL_INFO'] = $set->getField("LINK_URL_INFO");
				$items[$i]['state'] = $this->hasunitchildtahun($valinfoid) ? 'closed' : 'open';
				$i++;
			}
			$result["rows"] = $items;
		} 
		else 
		{

			// print_r($id);exit;

			$child = new WoStanding();
			$statement= " AND A.KODE = '".$id."'";
			$child->selectByParamsCheckBlok(array(), -1,-1, $statement);
			// echo $child->query;exit;
			$child->firstRow();
			$checksite= "";
			unset($child);



			$child = new WoStanding();
			$statement= " AND A.GROUP_PM = '".$id."'";
			$child->selectByParamsCheckGroup(array(), -1,-1, $statement);
			// echo $child->query;exit;
			$child->firstRow();
			$checkgroup= $child->getField("GROUP_PM");
			unset($child);

			if(!is_numeric($id))
			{

				if($checksite)
				{
					$statement= " AND A.KODE_BLOK = '".$id."'";

					if(!empty($reqDistrikId))
					{
						$statement.=" AND A.KODE_DISTRIK='".$reqDistrikId."'";
					}
					if(!empty($reqBlokId))
					{
						$statement.=" AND A.KODE_BLOK='".$reqBlokId."'";
					}
					if(!empty($reqGroupPm))
					{
						$statement.=" AND A.GROUP_PM='".$reqGroupPm."'";
					}

					if(!empty($reqUnitMesinId))
					{
						$statement.=" AND A.KODE_UNIT_M='".$reqUnitMesinId."'";
					}

					if(!empty($this->appblokunitid))
					{
						$statement.= " AND B.BLOK_UNIT_ID = ".$this->appblokunitid;
					}

					$sOrder=" ";
					$set= new WoStanding();
					$set->selectByParamsGroup(array(), -1, -1, $statement, $sOrder);
					// echo $set->query;exit;
					$i=0;
					while($set->nextRow())
					{
						$valinfoid= $set->getField("GROUP_PM");
						$result[$i]['ID'] = $valinfoid;
						$result[$i]['NAMA'] = $set->getField("GROUP_PM");
						$result[$i]['UNIT_NAMA'] = $set->getField("UNIT_NAMA");
						$result[$i]['DISTRIK_NAMA'] = $set->getField("DISTRIK_NAMA");
						$result[$i]['LINK_URL_INFO'] = $set->getField("LINK_URL_INFO");
						$result[$i]['state'] = $this->hasunitchildtahun($valinfoid) ? 'closed' : 'open';
						$i++;
					}	
				}
				else
				{
					$statement= " AND A.GROUP_PM = '".$id."'";

					if(!empty($reqDistrikId))
					{
						$statement.=" AND A.KODE_DISTRIK='".$reqDistrikId."'";
					}
					if(!empty($reqBlokId))
					{
						$statement.=" AND A.KODE_BLOK='".$reqBlokId."'";
					}
					if(!empty($reqGroupPm))
					{
						$statement.=" AND A.GROUP_PM='".$reqGroupPm."'";
					}

					if(!empty($reqUnitMesinId))
					{
						$statement.=" AND A.KODE_UNIT_M='".$reqUnitMesinId."'";
					}

					if(!empty($this->appblokunitid))
					{
						$statement.= " AND B.BLOK_UNIT_ID = ".$this->appblokunitid;
					}

					$sOrder=" ORDER BY A.PM_YEAR ASC ";
					$set= new WoStanding();
					$set->selectByParamsChild(array(), -1, -1, $statement, $sOrder);
					// echo $set->query;exit;
					$i=0;
					while($set->nextRow())
					{
						$valinfoid= $set->getField("PM_YEAR");
						$result[$i]['ID'] = $valinfoid;
						$result[$i]['NAMA'] = $set->getField("PM_YEAR");
						$result[$i]['DISTRIK_NAMA'] = $set->getField("DISTRIK_NAMA");
						$result[$i]['COST_PM_YEARLY'] = toThousandComma($set->getField("COST_PM_YEARLY"));
						$result[$i]['LINK_URL_INFO'] = $set->getField("LINK_URL_INFO");
						$result[$i]['BLOK_NAMA'] = $set->getField("BLOK_NAMA");
						$result[$i]['UNIT_NAMA'] = $set->getField("UNIT_NAMA");
						// $result[$i]['state'] = $this->hasunitchildcost($valinfoid) ? 'closed' : 'open';
						$i++;
					}	
				}

			}
			// else
			// {

			// 	$statement= " AND A.PM_YEAR = '".$id."'";

			// 	$sOrder=" ";
			// 	$set= new WoStanding();
			// 	$set->selectByParamsChild(array(), -1, -1, $statement, $sOrder);
			// 		// echo $set->query;exit;
			// 	$i=0;
			// 	while($set->nextRow())
			// 	{
			// 		$valinfoid= $set->getField("COST_PM_YEARLY");
			// 		$result[$i]['ID'] = $valinfoid;
			// 		$result[$i]['NAMA'] = $set->getField("COST_PM_YEARLY");
			// 		$result[$i]['LINK_URL_INFO'] = $set->getField("LINK_URL_INFO");
			// 		$i++;
			// 	}	
			// }

			

			
			
			

		}
		
		echo json_encode($result);
	}

	function hasunitchild($id)
	{
	
		$statement= " AND A.KODE_BLOK = '".$id."'";
			
		$child = new WoStanding();
		$child->selectByParamsChild(array(), -1,-1, $statement);
		// echo $child->query;exit;
		$child->firstRow();
		$tempId= $child->getField("KODE_BLOK");
		// echo $tempId;exit;
		if($tempId == "")
		return false;
		else
		return true;
		unset($child);
	}

	function hasunitchildtahun($id)
	{
	
		$statement= " AND A.GROUP_PM = '".$id."'";
			
		$child = new WoStanding();
		$child->selectByParamsChild(array(), -1,-1, $statement);
		// echo $child->query;exit;
		$child->firstRow();
		$tempId= $child->getField("PM_YEAR");
		// echo $tempId;exit;
		if($tempId == "")
		return false;
		else
		return true;
		unset($child);
	}

	function hasunitchildcost($id)
	{
	
		$statement= " AND A.PM_YEAR = '".$id."'";
			
		$child = new WoStanding();
		$child->selectByParamsChild(array(), -1,-1, $statement);
		// echo $child->query;exit;
		$child->firstRow();
		$tempId= $child->getField("COST_PM_YEARLY");
		// echo $tempId;exit;
		if($tempId == "")
		return false;
		else
		return true;
		unset($child);
	}

	function deleteparent()
	{
		$this->load->model("base-app/WoStanding");
		$set = new WoStanding();
		
		$reqBlokId =  $this->input->get('reqBlokId');

		$set->setField("KODE_BLOK", $reqBlokId);

		if($set->deleteparent())
		{
			$arrJson["PESAN"] = "Data berhasil dihapus.";
		}
		else
		{
			$arrJson["PESAN"] = "Data gagal dihapus.";	
		}

		echo json_encode( $arrJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	
	}

	function deletegroup()
	{
		$this->load->model("base-app/WoStanding");
		$set = new WoStanding();
		
		$reqBlokId =  $this->input->get('reqBlokId');
		$reqDistrikId =  $this->input->get('reqDistrikId');
		$reqGroupPm =  $this->input->get('reqGroupPm');
		$reqUnitMesinId =  $this->input->get('reqUnitMesinId');

		$set->setField("KODE_BLOK", $reqBlokId);
		$set->setField("KODE_DISTRIK", $reqDistrikId);
		$set->setField("GROUP_PM", $reqGroupPm);
		$set->setField("KODE_UNIT_M", $reqUnitMesinId);

		if(empty($reqUnitMesinId))
		{
			if($set->deletegroup())
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
			if($set->deletegroupunit())
			{
				$arrJson["PESAN"] = "Data berhasil dihapus.";
			}
			else
			{
				$arrJson["PESAN"] = "Data gagal dihapus.";	
			}
		}


		echo json_encode( $arrJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	
	}

	function deletetahun()
	{
		$this->load->model("base-app/WoStanding");
		$set = new WoStanding();
		
		$reqBlokId =  $this->input->get('reqBlokId');
		$reqDistrikId =  $this->input->get('reqDistrikId');
		$reqGroupPm =  $this->input->get('reqGroupPm');
		$reqTahun =  $this->input->get('reqTahun');
		$reqUnitMesinId =  $this->input->get('reqUnitMesinId');

		$set->setField("KODE_BLOK", $reqBlokId);
		$set->setField("KODE_DISTRIK", $reqDistrikId);
		$set->setField("GROUP_PM", $reqGroupPm);
		$set->setField("PM_YEAR", $reqTahun);
		$set->setField("KODE_UNIT_M", $reqUnitMesinId);

		if(empty($reqUnitMesinId))
		{
			if($set->deletetahun())
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
			if($set->deletetahununit())
			{
				$arrJson["PESAN"] = "Data berhasil dihapus.";
			}
			else
			{
				$arrJson["PESAN"] = "Data gagal dihapus.";	
			}
		}

		

		echo json_encode( $arrJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	
	}



	


}