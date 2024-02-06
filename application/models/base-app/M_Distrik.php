<? 
  include_once(APPPATH.'/models/Entity.php');

  class M_Distrik extends Entity{ 

	var $query;

    function M_Distrik()
	{
      $this->Entity(); 
    }

    function insert()
    {
    	// $this->setField("DISTRIK_ID", $this->getNextId("DISTRIK_ID","distrik"));

    	$str = "
    	INSERT INTO M_DISTRIK
    	(
    		DISTRICT_CODE, ELL_CODE, MAX_CODE, DISTRICT_NAME, LAST_MOD_DATE, LAST_MOD_TIME, LONGITUDE, LATITUDE, AKRONIM
    	)
    	VALUES 
    	(
	    	'".$this->getField("DISTRICT_CODE")."'
	    	, '".$this->getField("ELL_CODE")."'
	    	, '".$this->getField("MAX_CODE")."'
	    	, '".$this->getField("DISTRICT_NAME")."'
	    	, ".$this->getField("LAST_MOD_DATE")."
	    	, '".$this->getField("LAST_MOD_TIME")."'
	    	, '".$this->getField("LONGITUDE")."'
	    	, '".$this->getField("LATITUDE")."'
	    	, '".$this->getField("AKRONIM")."'
	    )"; 

		$this->id= $this->getField("DISTRIK_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}


	function update()
	{
		$str = "
		UPDATE M_DISTRIK
		SET
		DISTRICT_CODE= '".$this->getField("DISTRICT_CODE")."'
		, ELL_CODE=  '".$this->getField("ELL_CODE")."'
		, MAX_CODE= '".$this->getField("MAX_CODE")."'
		, DISTRICT_NAME= '".$this->getField("DISTRICT_NAME")."'
		, LAST_MOD_DATE= ".$this->getField("LAST_MOD_DATE")."
		, LAST_MOD_TIME= '".$this->getField("LAST_MOD_TIME")."'
		, LONGITUDE= '".$this->getField("LONGITUDE")."'
		, LATITUDE= '".$this->getField("LATITUDE")."'
		, AKRONIM= '".$this->getField("AKRONIM")."'
		WHERE DISTRICT_CODE = '".$this->getField("DISTRICT_CODE")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM M_DISTRIK
		WHERE 
		DISTRICT_CODE = '".$this->getField("DISTRICT_CODE")."'
		"; 

		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $distrikment='', $sOrder="ORDER BY DISTRICT_CODE ASC")
	{
		$str = "
		SELECT 
			A.*
		FROM M_DISTRIK A
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

    function selectByParamsMonitoring($paramsArray=array(),$limit=-1,$from=-1, $distrikment='', $sOrder="ORDER BY DISTRICT_CODE ASC")
	{
		$str = "
		SELECT 
			A.*
		FROM M_DISTRIK A
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
		FROM M_DISTRIK
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