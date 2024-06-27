<? 
  include_once(APPPATH.'/models/Entity.php');

  class Wo_Pm extends Entity{ 

	var $query;

    function Wo_Pm()
	{
      $this->Entity(); 
    }


    function insert()
    {

    	$str = "
    	INSERT INTO t_wo_pm_lccm
    	(
    		 ASSETNUM, PM_YEAR, PMNUM, JPNUM, NO_PERSONAL, DURATION_HOURS, PM_IN_YEAR, LAST_CREATE_USER, LAST_CREATE_DATE

    	)
    	VALUES 
    	(
	    	 '".$this->getField("ASSETNUM")."'
	    	, ".$this->getField("PM_YEAR")."
	    	, '".$this->getField("PMNUM")."'
	    	, '".$this->getField("JPNUM")."'
	    	, ".$this->getField("NO_PERSONAL")."
	    	, ".$this->getField("DURATION_HOURS")."
	    	, ".$this->getField("PM_IN_YEAR")."
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
		UPDATE t_wo_pm_lccm
		SET
		 ASSETNUM= '".$this->getField("ASSETNUM")."'
		, PM_YEAR= ".$this->getField("PM_YEAR")."
		, PMNUM='".$this->getField("PMNUM")."'
		, JPNUM='".$this->getField("JPNUM")."'
		, NO_PERSONAL=".$this->getField("NO_PERSONAL")."
		, DURATION_HOURS=".$this->getField("DURATION_HOURS")."
		, PM_IN_YEAR=".$this->getField("PM_IN_YEAR")."
		, LAST_UPDATE_USER='".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE=".$this->getField("LAST_UPDATE_DATE")."
		WHERE ASSETNUM = '".$this->getField("ASSETNUM_OLD")."' AND PM_YEAR = '".$this->getField("PM_YEAR")."' AND PMNUM = '".$this->getField("PMNUM_OLD")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM t_wo_pm_lccm
		WHERE 
		ASSETNUM = '".$this->getField("ASSETNUM")."' AND PM_YEAR = '".$this->getField("PM_YEAR")."'  AND PMNUM = '".$this->getField("PMNUM")."' "; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function selectByParamsOld($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY A.PM_YEAR ASC")
	{
		$str = "
		SELECT
			PC.WO_PM
			, CASE WHEN PC.WO_PM = TRUE THEN 'Valid' WHEN PC.WO_PM = FALSE THEN 'Tidak Valid' ELSE '-' END INFO_NAMA
			, A.*
		FROM
		(
			SELECT 
				B.KODE_BLOK,A.PM_YEAR,B.GROUP_PM, SUM(PM_IN_YEAR) TOTAL_TAHUN
			FROM t_wo_pm_lccm A 
			INNER JOIN M_ASSET_LCCM B ON B.ASSETNUM = A.ASSETNUM
			LEFT JOIN DISTRIK C ON C.KODE = B.KODE_DISTRIK
			LEFT JOIN BLOK_UNIT D ON D.KODE = B.KODE_BLOK AND D.DISTRIK_ID = C.DISTRIK_ID
			LEFT JOIN UNIT_MESIN E ON E.KODE = B.KODE_UNIT_M AND E.BLOK_UNIT_ID = D.BLOK_UNIT_ID AND E.DISTRIK_ID = C.DISTRIK_ID
			WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY A.PM_YEAR, B.GROUP_PM,b.KODE_BLOK
		) A
		LEFT JOIN t_preperation_lccm PC ON PC.YEAR_LCCM = A.PM_YEAR AND PC.SITEID = A.KODE_BLOK
		WHERE 1=1
		".$sOrder;
		$this->query = $str;
		// echo $str;exit;
				
		return $this->selectLimit($str,$limit,$from); 
    }


    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='',  $statement2='', $sOrder="ORDER BY A.PM_YEAR ASC")
	{
		$str = "
		SELECT
			PC.WO_PM
			, CASE WHEN PC.WO_PM = TRUE THEN 'Valid' WHEN PC.WO_PM = FALSE THEN 'Tidak Valid' ELSE '-' END INFO_NAMA
			, A.*
		FROM
		(
			SELECT 
				B.KODE_DISTRIK,C.NAMA DISTRIK_INFO,B.KODE_BLOK,D.NAMA BLOK_INFO,B.KODE_UNIT, D.NAMA UNIT_INFO,A.PM_YEAR,B.GROUP_PM, SUM(PM_IN_YEAR) TOTAL_TAHUN
			FROM t_wo_pm_lccm A
			LEFT JOIN M_ASSET_LCCM B1 ON trim(B1.ASSETNUM) = trim(A.ASSETNUM) 
			LEFT JOIN DISTRIK C ON C.KODE = B1.KODE_DISTRIK
			LEFT JOIN BLOK_UNIT D ON D.KODE = B1.KODE_BLOK AND D.DISTRIK_ID = C.DISTRIK_ID
			LEFT JOIN UNIT_MESIN E ON E.KODE = B1.KODE_UNIT_M AND E.BLOK_UNIT_ID = D.BLOK_UNIT_ID AND E.DISTRIK_ID = C.DISTRIK_ID
			LEFT JOIN m_group_pm__lccm B ON B.KODE_DISTRIK = C.KODE AND B.KODE_BLOK = D.KODE AND B.KODE_UNIT = E.KODE
			WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY A.PM_YEAR, B.GROUP_PM,B.KODE_DISTRIK,B.KODE_BLOK,B.KODE_UNIT,C.NAMA,D.NAMA,D.NAMA
		) A
		LEFT JOIN t_preperation_lccm PC ON PC.YEAR_LCCM = A.PM_YEAR AND PC.KODE_DISTRIK = A.KODE_DISTRIK AND PC.KODE_BLOK = A.KODE_BLOK AND PC.KODE_UNIT_M = A.KODE_UNIT
		WHERE 1=1 ".$statement2."
		".$sOrder;
		$this->query = $str;
		// echo $str;exit;
				
		return $this->selectLimit($str,$limit,$from); 
    }


    function selectByParamsTahun($paramsArray=array(),$limit=-1,$from=-1, $statement='',  $statement2='',$sOrder="ORDER BY A.PM_YEAR ASC")
	{
		$str = "
		SELECT
			PC.WO_PM
			, CASE WHEN PC.WO_PM = TRUE THEN 'Valid' WHEN PC.WO_PM = FALSE THEN 'Tidak Valid' ELSE '-' END INFO_NAMA
			, A.*
		FROM
		(
			SELECT 
			B.KODE_DISTRIK,C.NAMA DISTRIK_INFO,B.KODE_BLOK,D.NAMA BLOK_INFO,B.KODE_UNIT, D.NAMA UNIT_INFO,A.PM_YEAR,B.GROUP_PM, A.TOTAL_PM TOTAL_TAHUN
			FROM t_total_wopm_lccm A 
			LEFT JOIN DISTRIK C ON C.KODE = A.KODE_DISTRIK
			LEFT JOIN BLOK_UNIT D ON D.KODE = A.KODE_BLOK AND D.DISTRIK_ID = C.DISTRIK_ID
			LEFT JOIN UNIT_MESIN E ON E.KODE = A.KODE_UNIT_M AND E.BLOK_UNIT_ID = D.BLOK_UNIT_ID AND E.DISTRIK_ID = C.DISTRIK_ID
			LEFT JOIN m_group_pm__lccm B ON B.KODE_DISTRIK = C.KODE AND B.KODE_BLOK = D.KODE AND B.KODE_UNIT = E.KODE
			WHERE 1=1
			
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY A.PM_YEAR, B.GROUP_PM,B.KODE_DISTRIK,B.KODE_BLOK,B.KODE_UNIT,A.TOTAL_PM,C.NAMA,D.NAMA,D.NAMA
		) A
		LEFT JOIN t_preperation_lccm PC ON PC.YEAR_LCCM = A.PM_YEAR AND PC.KODE_DISTRIK = A.KODE_DISTRIK AND PC.KODE_BLOK = A.KODE_BLOK AND PC.KODE_UNIT_M = A.KODE_UNIT
		WHERE 1=1 ".$statement2."
		".$sOrder;
		$this->query = $str;
		// echo $str;exit;
				
		return $this->selectLimit($str,$limit,$from); 
    }


    function selectByParamsDetail($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY A.ASSETNUM ASC")
	{
		$str = "
		SELECT 
			A.*,B.GROUP_PM
		FROM t_wo_pm_lccm A 
		INNER JOIN M_ASSET_LCCM B ON B.ASSETNUM = A.ASSETNUM
		LEFT JOIN DISTRIK C ON C.KODE = B.KODE_DISTRIK
		LEFT JOIN BLOK_UNIT D ON D.KODE = B.KODE_BLOK AND D.DISTRIK_ID = C.DISTRIK_ID
		LEFT JOIN UNIT_MESIN E ON E.KODE = B.KODE_UNIT_M AND E.BLOK_UNIT_ID = D.BLOK_UNIT_ID AND E.DISTRIK_ID = C.DISTRIK_ID
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


    function selectByParamsMonitoringFunc($paramsArray=array(),$limit=-1,$from=-1, $statementdistrik='',$statementblok='',$statementunit='',$statementwopm=null, $sOrder="ORDER BY A.ASSETNUM ASC")
	{
		$str = "
		select * from f_total_pm ('".$statementdistrik."','".$statementblok."','".$statementunit."',".$statementwopm.");
				
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }


   

    
  } 
?>