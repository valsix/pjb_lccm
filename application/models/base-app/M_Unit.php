<? 
  include_once(APPPATH.'/models/Entity.php');

  class M_Unit extends Entity{ 

	var $query;

    function M_Unit()
	{
      $this->Entity(); 
    }

    function insert()
    {
    	// $this->setField("DISTRIK_ID", $this->getNextId("DISTRIK_ID","distrik"));

    	$str = "
    	INSERT INTO M_UNIT
    	(
    		UNIT_CODE, ELL_CODE, MAX_CODE, UNIT_NAME, LAST_MOD_DATE, LAST_MOD_TIME, LONGITUDE, LATITUDE
    	)
    	VALUES 
    	(
	    	'".$this->getField("UNIT_CODE")."'
	    	, '".$this->getField("ELL_CODE")."'
	    	, '".$this->getField("MAX_CODE")."'
	    	, '".$this->getField("UNIT_NAME")."'
	    	, ".$this->getField("LAST_MOD_DATE")."
	    	, '".$this->getField("LAST_MOD_TIME")."'
	    	, '".$this->getField("LONGITUDE")."'
	    	, '".$this->getField("LATITUDE")."'
	    )"; 

		$this->id= $this->getField("DISTRIK_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}


	function update()
	{
		$str = "
		UPDATE M_UNIT
		SET
		UNIT_CODE= '".$this->getField("UNIT_CODE")."'
		, ELL_CODE=  '".$this->getField("ELL_CODE")."'
		, MAX_CODE= '".$this->getField("MAX_CODE")."'
		, UNIT_NAME= '".$this->getField("UNIT_NAME")."'
		, LAST_MOD_DATE= ".$this->getField("LAST_MOD_DATE")."
		, LAST_MOD_TIME= '".$this->getField("LAST_MOD_TIME")."'
		, LONGITUDE= '".$this->getField("LONGITUDE")."'
		, LATITUDE= '".$this->getField("LATITUDE")."'
		WHERE UNIT_CODE = '".$this->getField("UNIT_CODE")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM M_UNIT
		WHERE 
		UNIT_CODE = '".$this->getField("UNIT_CODE")."'
		"; 

		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $distrikment='', $sOrder="ORDER BY UNIT_CODE ASC")
	{
		$str = "
		SELECT 
			A.*
		FROM M_UNIT A
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $distrikment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsMonitoring($paramsArray=array(),$limit=-1,$from=-1, $distrikment='', $sOrder="ORDER BY UNIT_CODE ASC")
	{
		$str = "
		SELECT 
			A.*
		FROM M_UNIT A
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $distrikment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

   
    function getCountByParams($paramsArray=array())
	{
		$str = "SELECT COUNT(1) AS ROWCOUNT 
		FROM M_UNIT
		WHERE 1 = 1  "; 
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }

   

  } 
?>