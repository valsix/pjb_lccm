<? 
  include_once(APPPATH.'/models/Entity.php');

  class M_Group_Pm_Lccm extends Entity{ 

	var $query;

    function M_Group_Pm_Lccm()
	{
      $this->Entity(); 
    }

    function insert()
    {
    	// $this->setField("UNIT_MESIN_ID", $this->getNextId("UNIT_MESIN_ID","unit_mesin"));

    	$str = "
    	INSERT INTO m_group_pm__lccm
    	(
    		KODE_DISTRIK,KODE_BLOK,KODE_UNIT,GROUP_PM,LAST_CREATE_USER,LAST_CREATE_DATE
    	)
    	VALUES 
    	(
	    	'".$this->getField("KODE_DISTRIK")."'
	    	, '".$this->getField("KODE_BLOK")."'
	    	, '".$this->getField("KODE_UNIT")."'
	    	, '".$this->getField("GROUP_PM")."'
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
		UPDATE m_group_pm__lccm
		SET
		 KODE_DISTRIK= '".$this->getField("KODE_DISTRIK")."'
		, KODE_BLOK= '".$this->getField("KODE_BLOK")."'
		, KODE_UNIT= '".$this->getField("KODE_UNIT")."'
		, GROUP_PM= '".$this->getField("GROUP_PM")."'
		, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE= ".$this->getField("LAST_UPDATE_DATE")."
		WHERE KODE_DISTRIK = '".$this->getField("KODE_DISTRIK_UPDATE")."' AND KODE_BLOK = '".$this->getField("KODE_BLOK_UPDATE")."'  AND GROUP_PM = '".$this->getField("GROUP_PM_UPDATE")."'  AND KODE_UNIT = '".$this->getField("KODE_UNIT_UPDATE")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

   
	function delete()
	{
		$str = "
		DELETE FROM m_group_pm__lccm
		WHERE 
		KODE_DISTRIK = '".$this->getField("KODE_DISTRIK")."' AND KODE_BLOK = '".$this->getField("KODE_BLOK")."'  AND GROUP_PM = '".$this->getField("GROUP_PM")."'  AND KODE_UNIT = '".$this->getField("KODE_UNIT")."' "; 

		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}


    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY GROUP_PM ASC")
	{
		$str = "
		SELECT 
			A.*,C.BLOK_UNIT_ID,B.DISTRIK_ID,B.NAMA DISTRIK_INFO,C.NAMA BLOK_INFO,D.NAMA UNIT_INFO
		FROM m_group_pm__lccm A 
		INNER JOIN DISTRIK B ON B.KODE = A.KODE_DISTRIK
		LEFT JOIN BLOK_UNIT C ON C.KODE = A.KODE_BLOK AND C.DISTRIK_ID = B.DISTRIK_ID
		LEFT  JOIN UNIT_MESIN D ON D.KODE = A.KODE_UNIT AND D.BLOK_UNIT_ID = C.BLOK_UNIT_ID AND D.DISTRIK_ID = B.DISTRIK_ID
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

    function selectByParamscheckGroupPm($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY GROUP_PM ASC")
	{
		$str = "
		SELECT 
			A.*,C.BLOK_UNIT_ID,B.DISTRIK_ID,B.NAMA DISTRIK_INFO,C.NAMA BLOK_INFO,D.NAMA UNIT_INFO
		FROM m_group_pm__lccm A 
		INNER JOIN DISTRIK B ON B.KODE = A.KODE_DISTRIK
		LEFT JOIN BLOK_UNIT C ON C.KODE = A.KODE_BLOK AND C.DISTRIK_ID = B.DISTRIK_ID
		LEFT  JOIN UNIT_MESIN D ON D.KODE = A.KODE_UNIT AND D.BLOK_UNIT_ID = C.BLOK_UNIT_ID AND D.DISTRIK_ID = B.DISTRIK_ID
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


     function selectByParamsFilter($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY GROUP_PM ASC")
	{
		$str = "
		SELECT 
			A.GROUP_PM
		FROM m_group_pm__lccm A 
		INNER JOIN DISTRIK B ON B.KODE = A.KODE_DISTRIK
		LEFT JOIN BLOK_UNIT C ON C.KODE = A.KODE_BLOK AND C.DISTRIK_ID = B.DISTRIK_ID
		LEFT  JOIN UNIT_MESIN D ON D.KODE = A.KODE_UNIT AND D.BLOK_UNIT_ID = C.BLOK_UNIT_ID AND D.DISTRIK_ID = B.DISTRIK_ID
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY A.GROUP_PM ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

    

  } 
?>