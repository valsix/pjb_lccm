<? 
  include_once(APPPATH.'/models/Entity.php');

  class UnitMesin extends Entity{ 

	var $query;

    function UnitMesin()
	{
      $this->Entity(); 
    }

    function insert()
    {
    	$this->setField("UNIT_MESIN_ID", $this->getNextId("UNIT_MESIN_ID","unit_mesin"));

    	$str = "
    	INSERT INTO unit_mesin
    	(
    		UNIT_MESIN_ID, NAMA, DISTRIK_ID,BLOK_UNIT_ID,KODE,KODE_EAM,EAM_ID,URL
    	)
    	VALUES 
    	(
	    	'".$this->getField("UNIT_MESIN_ID")."'
	    	, '".$this->getField("NAMA")."'
	    	, ".$this->getField("DISTRIK_ID")."
	    	, ".$this->getField("BLOK_UNIT_ID")."
	    	, '".$this->getField("KODE")."'
	    	, '".$this->getField("KODE_EAM")."'
	    	, ".$this->getField("EAM_ID")."
	    	, '".$this->getField("URL")."'
	    )"; 

		$this->id= $this->getField("UNIT_MESIN_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function update()
	{
		$str = "
		UPDATE unit_mesin
		SET
		 NAMA= '".$this->getField("NAMA")."'
		, DISTRIK_ID= ".$this->getField("DISTRIK_ID")."
		, BLOK_UNIT_ID= ".$this->getField("BLOK_UNIT_ID")."
		, KODE= '".$this->getField("KODE")."'
		, KODE_EAM= '".$this->getField("KODE_EAM")."'
		, EAM_ID= ".$this->getField("EAM_ID")."
		, URL= '".$this->getField("URL")."'
		WHERE UNIT_MESIN_ID = '".$this->getField("UNIT_MESIN_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function update_status()
	{
		$str = "
		UPDATE unit_mesin
		SET
		STATUS = ".$this->getField("STATUS")."
		WHERE UNIT_MESIN_ID = '".$this->getField("UNIT_MESIN_ID")."'
		"; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM unit_mesin
		WHERE 
		UNIT_MESIN_ID = ".$this->getField("UNIT_MESIN_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY UNIT_MESIN_ID ASC")
	{
		$str = "
		SELECT 
			A.*,B.NAMA DISTRIK_NAMA,C.NAMA UNIT_NAMA
			, CASE WHEN A.STATUS = 1 THEN 'Tidak  Aktif' ELSE 'Aktif' END STATUS_INFO
			, D.NAMA EAM_NAMA
		FROM unit_mesin A
		INNER JOIN DISTRIK B ON B.DISTRIK_ID = A.DISTRIK_ID
		INNER JOIN BLOK_UNIT C ON C.BLOK_UNIT_ID = A.BLOK_UNIT_ID
		LEFT JOIN EAM D ON D.EAM_ID = A.EAM_ID
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

    function getCountByParams($paramsArray=array())
	{
		$str = "SELECT COUNT(1) AS ROWCOUNT 
		FROM unit_mesin A
		INNER JOIN DISTRIK B ON B.DISTRIK_ID = A.DISTRIK_ID
		INNER JOIN BLOK_UNIT C ON C.BLOK_UNIT_ID = A.BLOK_UNIT_ID
		LEFT JOIN EAM D ON D.EAM_ID = A.EAM_ID
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