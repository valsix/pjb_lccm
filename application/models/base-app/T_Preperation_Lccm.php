<? 
  include_once(APPPATH.'/models/Entity.php');

  class T_Preperation_Lccm extends Entity{ 

	var $query;

    function T_Preperation_Lccm()
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

	function updatedyna()
	{
		$str = "
		UPDATE t_preperation_lccm
		SET
		".$this->getField("FIELD")." = ".$this->getField("FIELD_VALUE")."
		, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE= ".$this->getField("LAST_UPDATE_DATE")."
		WHERE YEAR_LCCM = '".$this->getField("YEAR_LCCM")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function updatedynanew()
	{
		$str = "
		UPDATE t_preperation_lccm
		SET
			".$this->getField("FIELD")." = ".$this->getField("FIELD_VALUE")."
			, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
			, LAST_UPDATE_DATE= ".$this->getField("LAST_UPDATE_DATE")."
		WHERE 
			YEAR_LCCM = '".$this->getField("YEAR_LCCM")."'
			AND SITEID = '".$this->getField("SITEID")."'
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
		FROM t_preperation_lccm A 
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
		 WHEN WO_CR = 'false' 
		 THEN 
			'&#10005'
		 ELSE 
		 '&#10004'
		 END WO_CR_INFO
		 ,CASE 
		 WHEN WO_STANDING = 'false' 
		 THEN 
			'&#10005'
		 ELSE 
		 '&#10004'
		 END WO_STANDING_INFO
		 ,CASE 
		 WHEN WO_PM = 'false' 
		 THEN 
			'&#10005'
		 ELSE 
		 '&#10004'
		 END WO_PM_INFO
		 ,CASE 
		 WHEN WO_PDM = 'false' 
		 THEN 
			'&#10005'
		 ELSE 
		 '&#10004'
		 END WO_PDM_INFO
		 ,CASE 
		 WHEN WO_OH = 'false' 
		 THEN 
			'&#10005'
		 ELSE 
		 '&#10004'
		 END WO_OH_INFO
		 ,CASE 
		 WHEN PRK = 'false' 
		 THEN 
			'&#10005'
		 ELSE 
		 '&#10004'
		 END PRK_INFO
		 ,CASE 
		 WHEN LOSS_OUTPUT = 'false' 
		 THEN 
			'&#10005'
		 ELSE 
		 '&#10004'
		 END LOSS_OUTPUT_INFO
		 ,CASE 
		 WHEN ENERGY_PRICE = 'false' 
		 THEN 
			'&#10005'
		 ELSE 
		 '&#10004'
		 END ENERGY_PRICE_INFO
		  ,CASE 
		 WHEN OPERATION = 'false' 
		 THEN 
			'&#10005'
		 ELSE 
		 '&#10004'
		 END OPERATION_INFO
		 ,CASE 
		 WHEN STATUS_COMPLETE= 'false' 
		 THEN 
			'&#10005'
		 ELSE 
		 '&#10004'
		 END STATUS_COMPLETE_INFO
		FROM 
		t_preperation_lccm a
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