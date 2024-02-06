<? 
  include_once(APPPATH.'/models/Entity.php');

  class OhLabourCost extends Entity{ 

	var $query;

    function OhLabourCost()
	{
      $this->Entity(); 
    }

    function insert()
    {
    	// $this->setField("KODE_UNIT_M", $this->getNextId("KODE_UNIT_M","unit_mesin"));

    	$str = "
    	INSERT INTO m_oh_labour_lccm
    	(
    		 ASSETNUM, OH_TYPE, NO_PERSONAL,DURATION_HOURS,LAST_CREATE_USER,LAST_CREATE_DATE
    	)
    	VALUES 
    	(
	    	 '".$this->getField("ASSETNUM")."'
	    	, '".$this->getField("OH_TYPE")."'
	    	, ".$this->getField("NO_PERSONAL")."
	    	, ".$this->getField("DURATION_HOURS")."
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
		UPDATE m_oh_labour_lccm
		SET
		 ASSETNUM= '".$this->getField("ASSETNUM")."'
		, OH_TYPE= '".$this->getField("OH_TYPE")."'
		, NO_PERSONAL=".$this->getField("NO_PERSONAL")."
		, DURATION_HOURS=".$this->getField("DURATION_HOURS")."
		, LAST_UPDATE_USER='".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE=".$this->getField("LAST_UPDATE_DATE")."
		WHERE OH_TYPE = '".$this->getField("OH_TYPE_OLD")."'  AND ASSETNUM = '".$this->getField("ASSETNUM_OLD")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

   
	function delete()
	{
		$str = "
		DELETE FROM m_oh_labour_lccm
		WHERE 
		OH_TYPE = '".$this->getField("OH_TYPE")."' AND ASSETNUM = '".$this->getField("ASSETNUM")."'   "; 

		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}


    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="")
	{
		$str = "
		SELECT 
		A.*
		FROM m_oh_labour_lccm A 
		INNER JOIN M_ASSET_LCCM B ON trim(B.ASSETNUM) = trim(A.ASSETNUM)
		LEFT JOIN DISTRIK C ON C.KODE = B.KODE_DISTRIK
		LEFT JOIN BLOK_UNIT D ON D.KODE = B.KODE_BLOK AND D.DISTRIK_ID = C.DISTRIK_ID
		LEFT  JOIN UNIT_MESIN E ON E.KODE = B.KODE_UNIT_M AND E.BLOK_UNIT_ID = D.BLOK_UNIT_ID AND E.DISTRIK_ID = C.DISTRIK_ID
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

    function selectByParamsOhType($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="")
	{
		$str = "
		SELECT 
		A.OH_TYPE
		FROM m_oh_labour_lccm A 
		INNER JOIN M_ASSET_LCCM B ON trim(B.ASSETNUM) = trim(A.ASSETNUM)
		WHERE 1=1
		
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY A.OH_TYPE  ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }


  } 
?>