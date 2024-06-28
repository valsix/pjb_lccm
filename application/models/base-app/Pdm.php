<? 
  include_once(APPPATH.'/models/Entity.php');

  class Pdm extends Entity{ 

	var $query;

    function Pdm()
	{
      $this->Entity(); 
    }

    function insert()
    {

    	$str = "
    	INSERT INTO t_wo_pdm_lccm
    	(
    		SITEID, ASSETNUM, PDM_YEAR, PDM_DESC, PDMNUM, NO_PERSONAL, DURATION_HOURS, PDM_IN_YEAR, LAST_CREATE_USER, LAST_CREATE_DATE

    	)
    	VALUES 
    	(
	    	'PT'
	    	, '".$this->getField("ASSETNUM")."'
	    	, ".$this->getField("PDM_YEAR")."
	    	, '".$this->getField("PDM_DESC")."'
	    	, '".$this->getField("PDMNUM")."'
	    	, ".$this->getField("NO_PERSONAL")."
	    	, ".$this->getField("DURATION_HOURS")."
	    	, ".$this->getField("PDM_IN_YEAR")."
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
		UPDATE t_wo_pdm_lccm
		SET
		 ASSETNUM= '".$this->getField("ASSETNUM")."'
		, PDM_YEAR= ".$this->getField("PDM_YEAR")."
		, PDM_DESC='".$this->getField("PDM_DESC")."'
		, PDMNUM='".$this->getField("PDMNUM")."'
		, NO_PERSONAL=".$this->getField("NO_PERSONAL")."
		, DURATION_HOURS=".$this->getField("DURATION_HOURS")."
		, PDM_IN_YEAR=".$this->getField("PDM_IN_YEAR")."
		, LAST_UPDATE_USER='".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE=".$this->getField("LAST_UPDATE_DATE")."
		WHERE ASSETNUM = '".$this->getField("ASSETNUM_OLD")."' AND PDM_YEAR = '".$this->getField("PDM_YEAR")."' AND PDMNUM = '".$this->getField("PDMNUM_OLD")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM t_wo_pdm_lccm
		WHERE 
		ASSETNUM = '".$this->getField("ASSETNUM")."' AND PDM_YEAR = '".$this->getField("PDM_YEAR")."'  AND PDMNUM = '".$this->getField("PDMNUM")."' "; 

		$this->query = $str;
		return $this->execQuery($str);
	}


    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $statement2='', $sOrder="ORDER BY A.PDM_YEAR ASC")
	{
		$str = "
		SELECT DISTINCT
			PC.WO_PDM
			, CASE WHEN PC.WO_PDM = TRUE THEN 'Valid' WHEN PC.WO_PDM = FALSE THEN 'Tidak Valid' ELSE '-' END INFO_NAMA
			, A.*
		FROM
		(
			SELECT 
				B.KODE_DISTRIK,B.KODE_BLOK,B.KODE_UNIT_M,A.PDM_YEAR,B.GROUP_PM, SUM(PDM_IN_YEAR) TOTAL_TAHUN
			FROM t_wo_pdm_lccm A 
			INNER JOIN M_ASSET_LCCM B ON B.ASSETNUM = A.ASSETNUM
			LEFT JOIN DISTRIK C ON C.KODE = B.KODE_DISTRIK
			LEFT JOIN BLOK_UNIT D ON D.KODE = B.SITEID AND D.DISTRIK_ID = C.DISTRIK_ID
			LEFT JOIN UNIT_MESIN E ON E.KODE = B.KODE_UNIT_M AND E.BLOK_UNIT_ID = D.BLOK_UNIT_ID AND E.DISTRIK_ID = C.DISTRIK_ID
			WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY A.PDM_YEAR, B.GROUP_PM,B.KODE_DISTRIK,B.KODE_BLOK,B.KODE_UNIT_M
		) A
		LEFT JOIN t_preperation_lccm PC ON PC.YEAR_LCCM = A.PDM_YEAR AND PC.KODE_DISTRIK = A.KODE_DISTRIK AND PC.KODE_BLOK = A.KODE_BLOK AND PC.KODE_UNIT_M = A.KODE_UNIT_M
		WHERE 1=1 ".$statement2."
		".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsTahun($paramsArray=array(),$limit=-1,$from=-1, $statement='',  $statement2='',$sOrder="ORDER BY A.PDM_YEAR ASC")
	{
		$str = "
		SELECT
			PC.WO_PDM
			, CASE WHEN PC.WO_PDM = TRUE THEN 'Valid' WHEN PC.WO_PDM = FALSE THEN 'Tidak Valid' ELSE '-' END INFO_NAMA
			, A.*
		FROM
		(
			SELECT 
			B.KODE_DISTRIK,C.NAMA DISTRIK_INFO,B.KODE_BLOK,D.NAMA BLOK_INFO,B.KODE_UNIT, D.NAMA UNIT_INFO,A.PDM_YEAR,B.GROUP_PM, A.TOTAL_PDM TOTAL_TAHUN
			FROM t_total_wopdm_lccm A 
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
		
		$str .= $statement." GROUP BY A.PDM_YEAR, B.GROUP_PM,B.KODE_DISTRIK,B.KODE_BLOK,B.KODE_UNIT,A.TOTAL_PDM,C.NAMA,D.NAMA,D.NAMA
		) A
		LEFT JOIN t_preperation_lccm PC ON PC.YEAR_LCCM = A.PDM_YEAR AND PC.KODE_DISTRIK = A.KODE_DISTRIK AND PC.KODE_BLOK = A.KODE_BLOK AND PC.KODE_UNIT_M = A.KODE_UNIT
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
		FROM t_wo_pdm_lccm A 
		INNER JOIN M_ASSET_LCCM B ON B.ASSETNUM = A.ASSETNUM
		LEFT JOIN DISTRIK C ON C.KODE = B.KODE_DISTRIK
		LEFT JOIN BLOK_UNIT D ON D.KODE = B.KODE_BLOK AND D.DISTRIK_ID = C.DISTRIK_ID
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


    function selectByParamsMonitoringView($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY A.PM_YEAR ASC")
	{
		$str = "
		SELECT * FROM 
		V_TOTAL_WO_PDM  A
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

    
  } 
?>