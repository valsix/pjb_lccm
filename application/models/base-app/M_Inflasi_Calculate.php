<? 
  include_once(APPPATH.'/models/Entity.php');

  class M_Inflasi_Calculate extends Entity{ 

	var $query;

    function M_Inflasi_Calculate()
	{
      $this->Entity(); 
    }

    function insert()
    {
    	$this->setField("M_INFLASI_CALCULATE_ID", $this->getNextId("M_INFLASI_CALCULATE_ID","m_inflasi_calculate"));

    	$str = "
    	INSERT INTO m_inflasi_calculate
    	(
    		M_INFLASI_CALCULATE_ID, TAHUN_AWAL,TAHUN_AKHIR,INFLASI,STATUS,LAST_CREATE_USER,LAST_CREATE_DATE
    	)
    	VALUES 
    	(
	    	".$this->getField("M_INFLASI_CALCULATE_ID")."
	    	, ".$this->getField("TAHUN_AWAL")."
	    	, ".$this->getField("TAHUN_AKHIR")."
	    	, ".$this->getField("INFLASI")."
	    	, '".$this->getField("STATUS")."'
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    )"; 

		$this->id= $this->getField("M_INFLASI_CALCULATE_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	
	function update()
	{
		$str = "
		UPDATE m_inflasi_calculate
		SET
		 TAHUN_AWAL= ".$this->getField("TAHUN_AWAL")."
		, TAHUN_AKHIR= ".$this->getField("TAHUN_AKHIR")."
		, INFLASI= ".$this->getField("INFLASI")."
		, STATUS= '".$this->getField("STATUS")."'
		, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE= ".$this->getField("LAST_UPDATE_DATE")."
		WHERE M_INFLASI_CALCULATE_ID = '".$this->getField("M_INFLASI_CALCULATE_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	
	function update_status()
	{
		$str = "
		UPDATE m_inflasi_calculate
		SET
		STATUS= '".$this->getField("STATUS")."'
		WHERE M_INFLASI_CALCULATE_ID = '".$this->getField("M_INFLASI_CALCULATE_ID")."'
		"; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM m_inflasi_calculate
		WHERE 
		M_INFLASI_CALCULATE_ID = ".$this->getField("M_INFLASI_CALCULATE_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}



    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $m_inflasi_calculatement='', $sOrder="ORDER BY M_INFLASI_CALCULATE_ID ASC")
	{
		$str = "
		SELECT 
			A.*
			,CASE WHEN A.STATUS = '1' THEN 'Tidak  Aktif' ELSE 'Aktif' END STATUS_INFO
		FROM m_inflasi_calculate A 
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $m_inflasi_calculatement." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }



  } 
?>