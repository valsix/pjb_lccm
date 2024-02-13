<? 
  include_once(APPPATH.'/models/Entity.php');

  class LossOutput extends Entity{ 

	var $query;

    function LossOutput()
	{
      $this->Entity(); 
    }

    function insert()
    {

    	$str = "
    	INSERT INTO t_loss_output_lccm
    	(
    		SITEID, ASSETNUM, START_DATE, STOP_DATE, DURATION_HOURS, LOAD_DERATING, LO_YEAR, STATUS, LAST_CREATE_USER, LAST_CREATE_DATE

    	)
    	VALUES 
    	(
	    	'PT'
	    	, '".$this->getField("ASSETNUM")."'
	    	, ".$this->getField("START_DATE")."
	    	, ".$this->getField("STOP_DATE")."
	    	, ".$this->getField("DURATION_HOURS")."
	    	, ".$this->getField("LOAD_DERATING")."
	    	, ".$this->getField("LO_YEAR")."
	    	, '".$this->getField("STATUS")."'
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    )"; 

		// $this->id= $this->getField("PENGGUNA_EXTERNAL_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function update()
	{
		$str = "
		UPDATE t_loss_output_lccm
		SET
		 ASSETNUM= '".$this->getField("ASSETNUM")."'
		, START_DATE= ".$this->getField("START_DATE")."
		, STOP_DATE=".$this->getField("STOP_DATE")."
		, DURATION_HOURS=".$this->getField("DURATION_HOURS")."
		, LOAD_DERATING=".$this->getField("LOAD_DERATING")."
		, LO_YEAR=".$this->getField("LO_YEAR")."
		, STATUS= '".$this->getField("STATUS")."'
		, LAST_UPDATE_USER='".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE=".$this->getField("LAST_UPDATE_DATE")."
		WHERE ASSETNUM = '".$this->getField("ASSETNUM_OLD")."' AND START_DATE = '".$this->getField("START_DATE_OLD")."' AND STOP_DATE = '".$this->getField("STOP_DATE_OLD")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM t_loss_output_lccm
		WHERE 
		ASSETNUM = '".$this->getField("ASSETNUM")."' AND START_DATE = '".$this->getField("START_DATE")."' AND STOP_DATE = '".$this->getField("STOP_DATE")."' AND LO_YEAR = ".$this->getField("LO_YEAR")." "; 

		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}


    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY A.LO_YEAR ASC")
	{
		$str = "
		SELECT
			pc.loss_output
			, CASE WHEN PC.loss_output = TRUE THEN 'Valid' WHEN PC.loss_output = FALSE THEN 'Tidak Valid' ELSE '-' END INFO_NAMA
			, A.*
		FROM
			(
			SELECT 
				A.LO_YEAR,B.GROUP_PM,A.SITEID
			FROM t_loss_output_lccm A 
			INNER JOIN M_ASSET_LCCM B ON B.ASSETNUM = A.ASSETNUM
			LEFT JOIN DISTRIK C ON C.KODE = B.KODE_DISTRIK
			LEFT JOIN BLOK_UNIT D ON D.KODE = B.SITEID AND D.DISTRIK_ID = C.DISTRIK_ID
			LEFT  JOIN UNIT_MESIN E ON E.KODE = B.KODE_UNIT_M AND E.BLOK_UNIT_ID = D.BLOK_UNIT_ID AND E.DISTRIK_ID = C.DISTRIK_ID
			WHERE 1=1
				
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement."GROUP BY A.LO_YEAR,B.GROUP_PM,A.SITEID
		) A
		LEFT JOIN t_preperation_lccm PC ON PC.YEAR_LCCM = A.LO_YEAR AND PC.SITEID=A.SITEID
		WHERE 1=1
		".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }


    function selectByParamsTahun($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY A.YEAR_LCCM ASC ")
	{
		$str = "
			SELECT 
				A.YEAR_LCCM,A.KODE_DISTRIK, C.NAMA NAMA_DISTRIK,A.KODE_BLOK,D.NAMA NAMA_BLOK,A.KODE_UNIT_M,E.NAMA NAMA_UNIT_MESIN
			FROM t_preperation_lccm A 
			LEFT JOIN DISTRIK C ON C.KODE = A.KODE_DISTRIK
			LEFT JOIN BLOK_UNIT D ON D.KODE = A.KODE_BLOK AND D.DISTRIK_ID = C.DISTRIK_ID
			LEFT JOIN UNIT_MESIN E ON E.KODE = A.KODE_UNIT_M AND E.BLOK_UNIT_ID = D.BLOK_UNIT_ID AND E.DISTRIK_ID = C.DISTRIK_ID
			WHERE 1=1
				
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement."
		
		".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }


    function selectByParamsDetail($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY A.ASSETNUM ASC")
	{
		$str = "
		SELECT 
			A.*,B.GROUP_PM
		FROM t_loss_output_lccm A 
		INNER JOIN M_ASSET_LCCM B ON B.ASSETNUM = A.ASSETNUM
		LEFT JOIN DISTRIK C ON C.KODE = B.KODE_DISTRIK
		LEFT JOIN BLOK_UNIT D ON D.KODE = B.SITEID AND D.DISTRIK_ID = C.DISTRIK_ID
		LEFT  JOIN UNIT_MESIN E ON E.KODE = B.KODE_UNIT_M AND E.BLOK_UNIT_ID = D.BLOK_UNIT_ID AND E.DISTRIK_ID = C.DISTRIK_ID
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


    function selectByParamsStatus($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY A.STATUS ASC")
	{
		$str = "
		SELECT A.STATUS
		FROM t_loss_output_lccm A
		where 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY STATUS ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }
    function getCountByParamsStatus($paramsArray=array())
	{
		$str = "SELECT COUNT(1) AS ROWCOUNT FROM t_loss_output_lccm A "; 
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