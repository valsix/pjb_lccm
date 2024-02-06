<? 
  include_once(APPPATH.'/models/Entity.php');

  class M_Inflasi extends Entity{ 

	var $query;

    function M_Inflasi()
	{
      $this->Entity(); 
    }

    function insert()
    {
    	// $this->setField("ID", $this->getNextId("ID","m_inflasi"));

    	$str = "
    	INSERT INTO m_inflasi
    	(
    		TAHUN,F,STATUS,LAST_CREATE_USER,LAST_CREATE_DATE
    	)
    	VALUES 
    	(
	    	 ".$this->getField("TAHUN")."
	    	, ".$this->getField("F")."
	    	, '".$this->getField("STATUS")."'
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    )"; 

		$this->id= $this->getField("ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	
	function update()
	{
		$str = "
		UPDATE m_inflasi
		SET
		 TAHUN= ".$this->getField("TAHUN")."
		, F= ".$this->getField("F")."
		, STATUS= '".$this->getField("STATUS")."'
		, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE= ".$this->getField("LAST_UPDATE_DATE")."
		WHERE ID = '".$this->getField("ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

   
	function delete()
	{
		$str = "
		DELETE FROM m_inflasi
		WHERE 
		ID = ".$this->getField("ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}


    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY TAHUN ASC")
	{
		$str = "
		SELECT 
			A.TAHUN
		FROM m_inflasi A 
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY A.TAHUN ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsAll($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY TAHUN ASC")
	{
		$str = "
		SELECT 
			*,CASE WHEN A.STATUS = '1' THEN 'Sesuai BI' ELSE 'Need Update' END STATUS_INFO
		FROM m_inflasi A 
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement."  ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }



  } 
?>