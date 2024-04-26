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
		$reqProjectNoR= $this->input->post("reqProjectNoR");
		$reqProjectDesc= $this->input->post("reqProjectDesc");

		$reqProjectNoOld= $this->input->post("reqProjectNoOld");

		if(is_numeric($reqDiscount))
		{
			$reqDiscount=$reqDiscount/100;
		}

		$reqPredictionMin=date("Y");

		if($reqId=="" && $reqMode=="update")
		{
			$reqId=$reqProjectNo;
		}

		if($reqHistoryYearEnd < $reqHistoryYearStart)
		{
			echo "xxx*** Tahun Akhir tidak boleh kurang dari tahun awal";exit;
		}

		if(empty($reqDistrikId) ||  empty($reqBlokId) || empty($reqUnitMesinId) )
		{
			echo "xxx*** Distrik/Blok/Unit tidak boleh kosong";exit;
		}

		if(empty($reqHistoryYearStart))
		{
			echo "xxx*** Tahun History Awal tidak boleh kosong";exit;
		}

		if(empty($reqHistoryYearEnd))
		{
			echo "xxx*** Tahun History Akhir tidak boleh kosong";exit;
		}

		if(empty($reqPrediction))
		{
			echo "xxx*** Tahun Prediction tidak boleh kosong";exit;
		}


		if($reqPrediction < $reqHistoryYearStart)
		{
			echo "xxx*** Tahun Prediction tidak boleh kurang dari history tahun awal";exit;
		}


		if($reqPrediction < $reqPredictionMin)
		{
			// echo "xxx*** Tahun Prediction tidak boleh kurang dari tahun sekarang";exit;
		}

		$reqHistoryInflasi=$this->kalkulasi($reqHistoryYearStart,$reqHistoryYearEnd);
		$reqAnnual=$this->kalkulasi($reqHistoryYearStart,$reqPrediction);
		// print_r($reqHistoryInflasi);exit;

		if(empty($reqHistoryInflasi))
		{
			$reqHistoryInflasi=0;
		}
		if(empty($reqAnnual))
		{
			$reqAnnual=0;
		}

		$reqProjectNo=  $reqProjectNoR."-".$reqProjectNo ;


		// if($reqMode=="insert")
		// {
		// 	$reqProjectNo=  $reqDistrikId.$reqBlokId.$reqUnitMesinId.$reqHistoryYearStart.$reqHistoryYearEnd.$reqPrediction.$reqProjectNo;
		// }
		// else
		// {
			// $reqProjectNo=  $reqProjectNo;
		// }

		
		
		// $reqProjectDesc= "DESC_".$reqProjectNo;

		$checkprim= new T_Lccm_Prj();
		$statement = " AND A.PROJECT_NAME = '".$reqProjectNo."' ";
		$checkprim->selectByParams(array(), -1, -1, $statement);
		$checkprim->firstRow();
		$reqCheckPrim= $checkprim->getField("PROJECT_NAME");

		if(!empty($reqCheckPrim))
		{
			echo "xxx*** Project No sudah ada";exit;
		}
		

		$set = new T_Lccm_Prj();
		$set->setField("KODE_DISTRIK", $reqDistrikId);
		$set->setField("KODE_BLOK", $reqBlokId);
		$set->setField("KODE_UNIT_M", $reqUnitMesinId);


		$set->setField("PROJECT_NAME", $reqProjectNo);
		$set->setField("PROJECT_DESC", $reqProjectDesc);
		$set->setField("LCCM_START_HIST_YEAR", $reqHistoryYearStart);
		$set->setField("LCCM_END_HIST_YEAR", $reqHistoryYearEnd);
		$set->setField("LCCM_PREDICT_YEAR", $reqPrediction);
		$set->setField("HIST_INFLASI_RATE", $reqHistoryInflasi);
		$set->setField("ANNUAL_INFLASI_RATE", $reqAnnual);
		$set->setField("PLANT_CAPITAL_COST",str_replace(',', '', $reqPlant));
		$set->setField("SITEID", "");
		$set->setField("DISC_RATE", str_replace(',', '.', $reqDiscount));
		
		$set->setField("PROJECT_NAME_OLD", $reqProjectNo);



		$checkprep= new T_Lccm_Prj();

		$statement = " AND A.KODE_DISTRIK = '".$reqDistrikId."' AND A.KODE_BLOK = '".$reqBlokId."' AND A.KODE_UNIT_M = '".$reqUnitMesinId."' AND A.YEAR_LCCM >= '".$reqHistoryYearStart."' AND A.YEAR_LCCM <= '".$reqHistoryYearEnd."'  ";
		$checkprep->selectByParamsCheckPrep(array(), -1, -1, $statement);
    	// echo $checkprep->query;exit;
		// $checkprep->firstRow();
		$arrpesan=array();
		while($checkprep->nextRow())
		{
			$reqStatusComplete= $checkprep->getField("STATUS_COMPLETE");
			$reqTahunComp= $checkprep->getField("YEAR_LCCM");

			if($reqStatusComplete==f || $reqStatusComplete==false)
			{
				  array_push($arrpesan, $reqTahunComp);
			}

		}

		if(!empty($arrpesan))
		{
			$pesantahun= implode (", ", $arrpesan);
			echo "xxx***Data gagal disimpan, data histori tidak lengkap pada tahun ".$pesantahun;exit;
		}
				
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
		$this->load->model("base-app/T_Lccm_Prj");
		$set = new T_Lccm_Prj();
		
		$reqId =  $this->input->get('reqId');
		$reqMode =  $this->input->get('reqMode');

		$set->setField("PROJECT_NAME", $reqId);

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

	function project_no()
	{
		$this->load->model("base-app/T_Lccm_Prj");

		$reqDistrikId =  $this->input->get('reqDistrikId');
		$reqBlokId =  $this->input->get('reqBlokId');
		$reqUnitMesinId =  $this->input->get('reqUnitMesinId');


		$appdistrikid= $this->appdistrikid;
		$appdistrikkode= $this->appdistrikkode;
		$appblokunitid= $this->appblokunitid;
		$appblokunitkode= $this->appblokunitkode;
		
		
		$statement=" AND 1=2 ";


		if(empty($reqDistrikId) && !empty($reqBlokId)  && !empty($reqUnitMesinId))
		{
			 $statement=" AND A.KODE_DISTRIK = '".$reqDistrikId."' AND A.KODE_BLOK = '".$reqBlokId."' AND A.KODE_UNIT_M = '".$reqUnitMesinId."' ";
		}


		$set= new T_Lccm_Prj();
		$arrset= [];

		$set->selectByParams(array(), -1,-1,$statement);
		// echo $set->query;exit;
		while($set->nextRow())
		{
			$arrdata= array();
			$arrdata["id"]= $set->getField("PROJECT_NAME");
			$arrdata["text"]= $set->getField("PROJECT_DESC");
			array_push($arrset, $arrdata);
		}
		unset($set);
		echo json_encode( $arrset, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	

	}


	function kalkulasi($reqTahunAwal,$reqTahunAkhir)
	{
		$this->load->model("base-app/M_Inflasi_Calculate");
		$this->load->model("base-app/M_Inflasi");

		
		$set= new M_Inflasi();
		$arrset= [];

		$statement=" AND tahun >= ".$reqTahunAwal." and tahun <= ".$reqTahunAkhir."  ";
		$set->selectByParamsAll(array(), -1,-1,$statement);
		// echo $set->query;exit;
		$product=1;
		while($set->nextRow())
		{
			$fp1= $set->getField("FP1");
			$product *= $fp1;
		}
		unset($set);

		$product=number_format((float)$product, 8, '.', '');

		$jangkawaktu= $reqTahunAkhir-$reqTahunAwal;


		$nper = $jangkawaktu;
		$pmt = 0;
		$pv = -1;
		$fv = $product;
		$type = 0;
		$guess = 0.1;
		$rate=$this->RATE($nper, $pmt, $pv, $fv, $guess);
		$rate=round($rate, 4);
		$rate=$rate*100;
	

		$total=$rate;

		return $total;
				
	}

	function RATE($nper, $pmt, $pv, $fv = 0.0, $type = 0, $guess = 0.1) {
		define('FINANCIAL_MAX_ITERATIONS', 128);
		define('FINANCIAL_PRECISION', 1.0e-08);

		$rate = $guess;
		if (abs($rate) < FINANCIAL_PRECISION) {
			$y = $pv * (1 + $nper * $rate) + $pmt * (1 + $rate * $type) * $nper + $fv;
		} else {
			$f = exp($nper * log(1 + $rate));
			$y = $pv * $f + $pmt * (1 / $rate + $type) * ($f - 1) + $fv;
		}
		$y0 = $pv + $pmt * $nper + $fv;
		$y1 = $pv * $f + $pmt * (1 / $rate + $type) * ($f - 1) + $fv;

		$i  = $x0 = 0.0;
		$x1 = $rate;
		while ((abs($y0 - $y1) > FINANCIAL_PRECISION) && ($i < FINANCIAL_MAX_ITERATIONS)) {
			$rate = ($y1 * $x0 - $y0 * $x1) / ($y1 - $y0);
			$x0 = $x1;
			$x1 = $rate;

			if (abs($rate) < FINANCIAL_PRECISION) {
				$y = $pv * (1 + $nper * $rate) + $pmt * (1 + $rate * $type) * $nper + $fv;
			} else {
				$f = exp($nper * log(1 + $rate));
				$y = $pv * $f + $pmt * (1 / $rate + $type) * ($f - 1) + $fv;
			}

			$y0 = $y1;
			$y1 = $y;
			++$i;
		}
		return $rate;
	}  


	function filter_history()
	{
		$this->load->model("base-app/T_Preperation_Lccm");

		$reqDistrikId =  $this->input->get('reqDistrikId');
		$reqBlokId =  $this->input->get('reqBlokId');
		$reqUnitMesinId =  $this->input->get('reqUnitMesinId');
		$reqMode =  $this->input->get('reqMode');


		$appdistrikid= $this->appdistrikid;
		$appdistrikkode= $this->appdistrikkode;
		$appblokunitid= $this->appblokunitid;
		$appblokunitkode= $this->appblokunitkode;
		

		$statement=" AND A.KODE_DISTRIK = '".$reqDistrikId."' AND A.KODE_BLOK = '".$reqBlokId."' AND A.KODE_UNIT_M = '".$reqUnitMesinId."' ";

		if($reqMode=='awal')
		{

			$set= new T_Preperation_Lccm();
			$arrset= [];


			$set->selectByParamsTahunHistory(array(), 1,-1,$statement);
			// echo $set->query;exit;
			$set->firstRow();
			$reqTahunMin= $set->getField("YEAR_LCCM");
			$reqTahunMax= $set->getField("YEAR_LCCM") + 30;

			for ($x = $reqTahunMin; $x <= $reqTahunMax; $x++) 
			{
				$arrdata= array();
				$arrdata["id"]= $x;
				$arrdata["text"]= $x;
				array_push($arrset, $arrdata);
			}

		}
		else
		{
			$set= new T_Preperation_Lccm();
			$arrset= [];

			$set->selectByParamsTahunHistory(array(), 1,-1,$statement);
			// echo $set->query;exit;
			$set->firstRow();
			$reqTahunMin= date("Y");
			$reqTahunMax= $set->getField("YEAR_LCCM") + 30;

			for ($x = $reqTahunMin; $x <= $reqTahunMax; $x++) 
			{
				$arrdata= array();
				$arrdata["id"]= $x;
				$arrdata["text"]= $x;
				array_push($arrset, $arrdata);
			}
		}

		

		unset($set);
		echo json_encode( $arrset, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	

	}


	

}