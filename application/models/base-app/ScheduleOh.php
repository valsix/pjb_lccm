<? 
  include_once(APPPATH.'/models/Entity.php');

  class ScheduleOh extends Entity{ 

	var $query;

    function ScheduleOh()
	{
      $this->Entity(); 
    }

    function insert()
    {
    	// $this->setField("KODE_UNIT_M", $this->getNextId("KODE_UNIT_M","unit_mesin"));

    	$str = "
    	INSERT INTO t_schedule_oh_lccm
    	(
    		KODE_BLOK, OH_YEAR, OH_TYPE,KODE_DISTRIK,KODE_UNIT_M
    	)
    	VALUES 
    	(
	    	'".$this->getField("KODE_BLOK")."'
	    	, ".$this->getField("OH_YEAR")."
	    	, '".$this->getField("OH_TYPE")."'
	    	, '".$this->getField("KODE_DISTRIK")."'
	    	, '".$this->getField("KODE_UNIT_M")."'
	    )"; 

		// $this->id= $this->getField("KODE_UNIT_M");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function update()
	{
		$str = "
		UPDATE t_schedule_oh_lccm
		SET
		 KODE_BLOK= '".$this->getField("KODE_BLOK")."'
		, OH_TYPE= '".$this->getField("OH_TYPE")."'
		, KODE_DISTRIK= '".$this->getField("KODE_DISTRIK")."'
		, OH_YEAR= ".$this->getField("OH_YEAR")."
		, KODE_UNIT_M= '".$this->getField("KODE_UNIT_M")."'
		WHERE OH_YEAR = '".$this->getField("OH_YEAR_OLD")."' AND KODE_BLOK = '".$this->getField("KODE_BLOK_OLD")."' AND KODE_DISTRIK = '".$this->getField("KODE_DISTRIK_OLD")."' AND KODE_UNIT_M = '".$this->getField("KODE_UNIT_M_OLD")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

   
	function delete()
	{
		$str = "
		DELETE FROM t_schedule_oh_lccm
		WHERE 
		OH_YEAR = ".$this->getField("OH_YEAR")." AND KODE_BLOK = '".$this->getField("KODE_BLOK")."'  "; 

		$this->query = $str;
		return $this->execQuery($str);
	}


    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY OH_YEAR ASC")
	{
		$str = "
		SELECT 
			A.*,B.NAMA DISTRIK_INFO,B.DISTRIK_ID,C.NAMA BLOK_INFO,C.BLOK_UNIT_ID,E.NAMA UNIT_INFO,E.UNIT_MESIN_ID
		FROM t_schedule_oh_lccm A 
		LEFT JOIN DISTRIK B ON B.KODE = A.KODE_DISTRIK
		LEFT JOIN BLOK_UNIT C ON C.KODE = A.KODE_BLOK AND C.DISTRIK_ID = B.DISTRIK_ID
		LEFT  JOIN UNIT_MESIN E ON E.KODE = A.KODE_UNIT_M AND E.BLOK_UNIT_ID = C.BLOK_UNIT_ID AND E.DISTRIK_ID = B.DISTRIK_ID

		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

     function selectByParamsTahun($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY OH_YEAR ASC")
     {
		$str = "
		SELECT 
			A.OH_YEAR 
		FROM t_schedule_oh_lccm A 
		
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY A.OH_YEAR ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

    

  } 
?>