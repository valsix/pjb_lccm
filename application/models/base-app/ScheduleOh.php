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
    		KODE_BLOK, OH_YEAR, OH_TYPE,KODE_DISTRIK,KODE_UNIT_M, LAST_CREATE_USER, LAST_CREATE_DATE
    	)
    	VALUES 
    	(
	    	'".$this->getField("KODE_BLOK")."'
	    	, ".$this->getField("OH_YEAR")."
	    	, '".$this->getField("OH_TYPE")."'
	    	, '".$this->getField("KODE_DISTRIK")."'
	    	, '".$this->getField("KODE_UNIT_M")."'
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
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
		, LAST_UPDATE_USER='".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE=".$this->getField("LAST_UPDATE_DATE")."
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
			, CASE WHEN A.OH_TYPE IS NULL OR A.OH_TYPE='' THEN 'Tidak ada Overhaul'
			ELSE A.OH_TYPE
			END OH_TYPE_INFO
		FROM t_schedule_oh_lccm A 
		LEFT JOIN DISTRIK B ON B.KODE = A.KODE_DISTRIK
		LEFT JOIN BLOK_UNIT C ON C.KODE = A.KODE_BLOK AND C.DISTRIK_ID = B.DISTRIK_ID
		LEFT  JOIN UNIT_MESIN E ON E.KODE = A.KODE_UNIT_M AND E.BLOK_UNIT_ID = C.BLOK_UNIT_ID AND E.DISTRIK_ID = B.DISTRIK_ID
		LEFT  JOIN m_oh_type_lccm F ON F.OH_TYPE = A.OH_TYPE 

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

    function selectByParamsMonitoring($paramsArray=array(),$limit=-1,$from=-1, $statement='',  $statement2='',$sOrder="ORDER BY A.OH_YEAR ASC")
	{
		$str = "
		SELECT
			PC.WO_OH
			, CASE WHEN PC.WO_OH = TRUE THEN 'Valid' WHEN PC.WO_OH = FALSE THEN 'Tidak Valid' ELSE '-' END INFO_NAMA
			, A.*
		FROM
		(
			SELECT 
			A.*,B.NAMA DISTRIK_INFO,B.DISTRIK_ID,C.NAMA BLOK_INFO,C.BLOK_UNIT_ID,E.NAMA UNIT_INFO,E.UNIT_MESIN_ID
			, CASE WHEN A.OH_TYPE IS NULL OR A.OH_TYPE='' THEN 'Tidak ada Overhaul'
			ELSE A.OH_TYPE
			END OH_TYPE_INFO
			FROM t_schedule_oh_lccm A 
			LEFT JOIN DISTRIK B ON B.KODE = A.KODE_DISTRIK
			LEFT JOIN BLOK_UNIT C ON C.KODE = A.KODE_BLOK AND C.DISTRIK_ID = B.DISTRIK_ID
			LEFT  JOIN UNIT_MESIN E ON E.KODE = A.KODE_UNIT_M AND E.BLOK_UNIT_ID = C.BLOK_UNIT_ID AND E.DISTRIK_ID = B.DISTRIK_ID
			LEFT  JOIN m_oh_type_lccm F ON F.OH_TYPE = A.OH_TYPE 

			WHERE 1=1
			
			
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement."  GROUP BY A.OH_YEAR,A.KODE_DISTRIK,A.KODE_BLOK,A.KODE_UNIT_M,B.NAMA,C.NAMA,E.NAMA,B.DISTRIK_ID,C.BLOK_UNIT_ID,E.UNIT_MESIN_ID
		) A
		LEFT JOIN t_preperation_lccm PC ON PC.YEAR_LCCM = A.OH_YEAR AND PC.KODE_DISTRIK = A.KODE_DISTRIK AND PC.KODE_BLOK = A.KODE_BLOK AND PC.KODE_UNIT_M = A.KODE_UNIT_M
		WHERE 1=1 ".$statement2."
		".$sOrder;
		$this->query = $str;
		// echo $str;exit;
				
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