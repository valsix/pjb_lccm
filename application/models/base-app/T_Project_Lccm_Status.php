<? 
  include_once(APPPATH.'/models/Entity.php');

  class T_project_lccm_status extends Entity{ 

	var $query;

    function T_project_lccm_status()
	{
      $this->Entity(); 
    }

    function insert()
    {
    	// $this->setField("UNIT_MESIN_ID", $this->getNextId("UNIT_MESIN_ID","unit_mesin"));

    	$str = "
    	INSERT INTO t_preperation_lccm
    	(
    		SITEID, YEAR_LCCM, WO_CR, WO_STANDING, WO_PM, WO_PDM, WO_OH, PRK, LOSS_OUTPUT, ENERGY_PRICE, OPERATION, STATUS_COMPLETE, LAST_CREATE_USER, LAST_CREATE_DATE
    	)
    	VALUES 
    	(
	    	'".$this->getField("SITEID")."'
	    	, ".$this->getField("YEAR_LCCM")."
	    	, '".$this->getField("WO_CR")."'
	    	, '".$this->getField("WO_STANDING")."'
	    	, '".$this->getField("WO_PM")."'
	    	, '".$this->getField("WO_PDM")."'
	    	, '".$this->getField("WO_OH")."'
	    	, '".$this->getField("PRK")."'
	    	, '".$this->getField("LOSS_OUTPUT")."'
	    	, '".$this->getField("ENERGY_PRICE")."'
	    	, '".$this->getField("OPERATION")."'
	    	, '".$this->getField("STATUS_COMPLETE")."'
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    )"; 

		// $this->id= $this->getField("UNIT_MESIN_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}


	
	function update()
	{
		$str = "
		UPDATE t_preperation_lccm
		SET
		 ENERGY_PRICE= '".$this->getField("ENERGY_PRICE")."'
		, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE= ".$this->getField("LAST_UPDATE_DATE")."
		WHERE YEAR_LCCM = '".$this->getField("YEAR_LCCM")."' AND SITEID = '".$this->getField("SITEID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}


	
	
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="")
	{
		$str = "
		SELECT 
			A.*
		FROM t_project_lccm_status A 
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		// echo $str;exit();
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }


    function selectByParamsMonitoring($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="")
	{
		$str = "
		SELECT a.*
		 ,CASE 
		 	WHEN PROJECT_PARAM = '0' 
		 THEN 
		 	'<button type=\"button\" class=\"btn btn-danger\" style=\"background-color: #c7de25;border: 1px solid #bcd123;\">Belum Ada</button>'
			WHEN PROJECT_PARAM = '1' 
		 THEN 
			'<button type=\"button\" class=\"btn btn-danger\" style=\"background-color: #ee5d9e;border: 1px solid #df3974;\">In Progress</button>'
			WHEN PROJECT_PARAM = '2' 
		 THEN 
		 	'<button type=\"button\" class=\"btn btn-danger\" style=\"background-color: #2bcfa9;border: 1px solid #4ea684;\">Selesai</button>'
		 ELSE 
		 'Data Kosong'
		 END PROJECT_PARAM_INFO
		 ,CASE 
		 	WHEN ASSET_PARAM = '0' 
		 THEN 
		 	'<button type=\"button\" class=\"btn btn-danger\" style=\"background-color: #c7de25;border: 1px solid #bcd123;\">Belum Ada</button>'
			WHEN ASSET_PARAM = '1' 
		 THEN 
			'<button type=\"button\" class=\"btn btn-danger\" style=\"background-color: #ee5d9e;border: 1px solid #df3974;\">In Progress</button>'
			WHEN ASSET_PARAM = '2' 
		 THEN 
		 	'<button type=\"button\" class=\"btn btn-danger\" style=\"background-color: #2bcfa9;border: 1px solid #4ea684;\">Selesai</button>'
		 ELSE 
		 'Data Kosong'
		 END ASSET_PARAM_INFO
		 ,CASE 
		 	WHEN CALCULATION = '0' 
		 THEN 
		 	'<button type=\"button\" class=\"btn btn-danger\" style=\"background-color: #c7de25;border: 1px solid #bcd123;\">Belum Ada</button>'
			WHEN CALCULATION = '1' 
		 THEN 
			'<button type=\"button\" class=\"btn btn-danger\" style=\"background-color: #ee5d9e;border: 1px solid #df3974;\">In Progress</button>'
			WHEN CALCULATION = '2' 
		 THEN 
		 	'<button type=\"button\" class=\"btn btn-danger\" style=\"background-color: #2bcfa9;border: 1px solid #4ea684;\">Selesai</button>'
		 ELSE 
		 'Data Kosong'
		 END CALCULATION_INFO
		 ,CASE 
		 	WHEN EAC = '0' 
		 THEN 
		 	'<button type=\"button\" class=\"btn btn-danger\" style=\"background-color: #c7de25;border: 1px solid #bcd123;\">Belum Ada</button>'
			WHEN EAC = '1' 
		 THEN 
			'<button type=\"button\" class=\"btn btn-danger\" style=\"background-color: #ee5d9e;border: 1px solid #df3974;\">In Progress</button>'
			WHEN EAC = '2' 
		 THEN 
		 	'<button type=\"button\" class=\"btn btn-danger\" style=\"background-color: #2bcfa9;border: 1px solid #4ea684;\">Selesai</button>'
		 ELSE 
		 'Data Kosong'
		 END EAC_INFO
		 ,CASE 
		 	WHEN MIN_EAC = '0' 
		 THEN 
		 	'<button type=\"button\" class=\"btn btn-danger\" style=\"background-color: #c7de25;border: 1px solid #bcd123;\">Belum Ada</button>'
			WHEN MIN_EAC = '1' 
		 THEN 
			'<button type=\"button\" class=\"btn btn-danger\" style=\"background-color: #ee5d9e;border: 1px solid #df3974;\">In Progress</button>'
			WHEN MIN_EAC = '2' 
		 THEN 
		 	'<button type=\"button\" class=\"btn btn-danger\" style=\"background-color: #2bcfa9;border: 1px solid #4ea684;\">Selesai</button>'
		 ELSE 
		 'Data Kosong'
		 END MIN_EAC_INFO
		FROM 
		t_project_lccm_status a
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		// echo $str;exit();
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }


    

  } 
?>