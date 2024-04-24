<? 
  include_once(APPPATH.'/models/Entity.php');

  class T_Lccm_Prj extends Entity{ 

	var $query;

    function T_Lccm_Prj()
	{
      $this->Entity(); 
    }

    function insert()
    {

    	$str = "
    	INSERT INTO t_lccm_prj
    	(
    		KODE_DISTRIK, KODE_BLOK, KODE_UNIT_M, PROJECT_NAME, PROJECT_DESC, LCCM_START_HIST_YEAR, LCCM_END_HIST_YEAR, LCCM_PREDICT_YEAR, DISC_RATE, HIST_INFLASI_RATE, ANNUAL_INFLASI_RATE, PLANT_CAPITAL_COST, SITEID, LAST_CREATE_USER, LAST_CREATE_DATE

    	)
    	VALUES 
    	(
	    	 '".$this->getField("KODE_DISTRIK")."'
	    	, '".$this->getField("KODE_BLOK")."'
	    	, '".$this->getField("KODE_UNIT_M")."'
	    	, '".$this->getField("PROJECT_NAME")."'
	    	, '".$this->getField("PROJECT_DESC")."'
	    	, ".$this->getField("LCCM_START_HIST_YEAR")."
	    	, ".$this->getField("LCCM_END_HIST_YEAR")."
	    	, ".$this->getField("LCCM_PREDICT_YEAR")."
	    	, ".$this->getField("DISC_RATE")."
	    	, ".$this->getField("HIST_INFLASI_RATE")."
	    	, ".$this->getField("ANNUAL_INFLASI_RATE")."
	    	, ".$this->getField("PLANT_CAPITAL_COST")."
	    	, '".$this->getField("SITEID")."'
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    )"; 

		$this->id= $this->getField("PROJECT_NAME");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function update()
	{
		$str = "
		UPDATE t_lccm_prj
		SET
		
	    	KODE_DISTRIK ='".$this->getField("KODE_DISTRIK")."'
	    	, KODE_BLOK='".$this->getField("KODE_BLOK")."'
	    	, KODE_UNIT_M='".$this->getField("KODE_UNIT_M")."'
	    	, PROJECT_NAME='".$this->getField("PROJECT_NAME")."'
	    	, PROJECT_DESC='".$this->getField("PROJECT_DESC")."'
	    	, LCCM_START_HIST_YEAR=".$this->getField("LCCM_START_HIST_YEAR")."
	    	, LCCM_END_HIST_YEAR=".$this->getField("LCCM_END_HIST_YEAR")."
	    	, LCCM_PREDICT_YEAR=".$this->getField("LCCM_PREDICT_YEAR")."
	    	, DISC_RATE=".$this->getField("DISC_RATE")."
	    	, HIST_INFLASI_RATE=".$this->getField("HIST_INFLASI_RATE")."
	    	, ANNUAL_INFLASI_RATE=".$this->getField("ANNUAL_INFLASI_RATE")."
	    	, PLANT_CAPITAL_COST=".$this->getField("PLANT_CAPITAL_COST")."
	    	, SITEID='".$this->getField("SITEID")."'
	    	, LAST_UPDATE_USER='".$this->getField("LAST_UPDATE_USER")."'
	    	, LAST_UPDATE_DATE=".$this->getField("LAST_UPDATE_DATE")."

		WHERE PROJECT_NAME = '".$this->getField("PROJECT_NAME_OLD")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM t_lccm_prj
		WHERE 
		PROJECT_NAME = '".$this->getField("PROJECT_NAME")."' "; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY A.PROJECT_NAME ASC")
	{
		$str = "
		SELECT 
			A.*,C.NAMA DISTRIK_INFO,D.NAMA BLOK_INFO,E.NAMA UNIT_INFO
			, LCCM_START_HIST_YEAR || ' - ' || LCCM_END_HIST_YEAR HISTORY_YEAR
		FROM t_lccm_prj A 
		LEFT JOIN DISTRIK C ON C.KODE = A.KODE_DISTRIK
		LEFT JOIN BLOK_UNIT D ON D.KODE = A.KODE_BLOK AND D.DISTRIK_ID = C.DISTRIK_ID
		LEFT JOIN UNIT_MESIN E ON E.KODE = A.KODE_UNIT_M AND E.BLOK_UNIT_ID = D.BLOK_UNIT_ID AND E.DISTRIK_ID = C.DISTRIK_ID
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

    function selectByParamsCheckPrep($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY A.YEAR_LCCM ASC")
	{
		$str = "
		SELECT KODE_DISTRIK,KODE_BLOK,KODE_UNIT_M, STATUS_COMPLETE,YEAR_LCCM 
		FROM T_PREPERATION_LCCM A
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

    function selectByParamsProjectNo($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY A.PROJECT_NAME ASC")
	{
		$str = "
		SELECT KODE_DISTRIK,KODE_BLOK,KODE_UNIT_M, PROJECT_NAME,PROJECT_DESC 
		FROM t_lccm_prj A
		WHERE 1=1
		
				
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY  KODE_DISTRIK,KODE_BLOK,KODE_UNIT_M, PROJECT_NAME,PROJECT_DESC  ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }



    
  } 
?>