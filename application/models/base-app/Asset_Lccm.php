<? 
  include_once(APPPATH.'/models/Entity.php');

  class Asset_Lccm extends Entity{ 

	var $query;

    function Asset_Lccm()
	{
      $this->Entity(); 
    }


    function insertasset()
    {

    	$str = "
    	INSERT INTO m_asset
    	(
    		SITEID,ASSETNUM, DESCRIPTION, PARENT, RBD_ID,  KKSNUM, STATUS, INSTALLDATE, LAST_CREATE_USER, LAST_CREATE_DATE

    	)
    	VALUES 
    	(
	    	'PT'
	    	, '".$this->getField("ASSETNUM")."'
	    	, '".$this->getField("DESCRIPTION")."'
	    	, '".$this->getField("PARENT")."'
	    	, '".$this->getField("RBD_ID")."'
	    	, '".$this->getField("KKSNUM")."'
	    	, '".$this->getField("STATUS")."'
	    	, ".$this->getField("INSTALLDATE")."
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    )"; 

		// $this->id= $this->getField("PENGGUNA_EXTERNAL_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function updateasset()
	{
		$str = "
		UPDATE m_asset
		SET
		 ASSETNUM= '".$this->getField("ASSETNUM")."'
		, DESCRIPTION='".$this->getField("DESCRIPTION")."'
		, PARENT='".$this->getField("PARENT")."'
		, RBD_ID='".$this->getField("RBD_ID")."'
		, KKSNUM='".$this->getField("KKSNUM")."'
		, STATUS='".$this->getField("STATUS")."'
		, INSTALLDATE=".$this->getField("INSTALLDATE")."
		, LAST_UPDATE_USER='".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE=".$this->getField("LAST_UPDATE_DATE")."
		WHERE ASSETNUM = '".$this->getField("ASSETNUM_OLD")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}


	function insertassetlccm()
    {

    	$str = "
    	INSERT INTO m_asset_lccm
    	(
    		SITEID, ASSETNUM, ASSET_LCCM, PARENT_CHILD, PARENT, GROUP_PM, ASSET_OH, LAST_CREATE_USER, LAST_CREATE_DATE, KODE_DISTRIK, KODE_BLOK, KODE_UNIT_M


    	)
    	VALUES 
    	(
	    	'PT'
	    	, '".$this->getField("ASSETNUM")."'
	    	, ".$this->getField("ASSET_LCCM")."
	    	, '".$this->getField("PARENT_CHILD")."'
	    	, '".$this->getField("PARENT")."'
	    	, '".$this->getField("GROUP_PM")."'
	    	, ".$this->getField("ASSET_OH")."
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    )"; 

		// $this->id= $this->getField("PENGGUNA_EXTERNAL_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function updateassetlccm()
	{
		$str = "
		UPDATE m_asset_lccm
		SET
		 ASSETNUM='".$this->getField("ASSETNUM")."'
		, ASSET_LCCM=".$this->getField("ASSET_LCCM")."
		, PARENT_CHILD='".$this->getField("PARENT_CHILD")."'
		, PARENT='".$this->getField("PARENT")."'
		, GROUP_PM='".$this->getField("GROUP_PM")."'
		, ASSET_OH=".$this->getField("ASSET_OH")."
		, KODE_DISTRIK='".$this->getField("KODE_DISTRIK")."'
		, KODE_UNIT_M='".$this->getField("KODE_UNIT_M")."'
		, KODE_BLOK='".$this->getField("KODE_BLOK")."'
		, LAST_UPDATE_USER='".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE=".$this->getField("LAST_UPDATE_DATE")."
		WHERE ASSETNUM = '".$this->getField("ASSETNUM")."' AND KODE_DISTRIK = '".$this->getField("KODE_DISTRIK")."' AND KODE_BLOK = '".$this->getField("KODE_BLOK")."' AND KODE_UNIT_M = '".$this->getField("KODE_UNIT_M")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}


	function insertcapital()
    {

    	$str = "
    	INSERT INTO m_capital_lccm
    	(
    		SITEID,ASSETNUM, STATUS, CAPITAL, CAPITAL_DATE, LAST_CREATE_USER, LAST_CREATE_DATE,KODE_DISTRIK,KODE_BLOK,KODE_UNIT_M

    	)
    	VALUES 
    	(
	    	'PT'
	    	, '".$this->getField("ASSETNUM")."'
	    	, ".$this->getField("STATUS")."
	    	, ".$this->getField("CAPITAL")."
	    	, ".$this->getField("CAPITAL_DATE")."
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    	, '".$this->getField("KODE_DISTRIK")."'
	    	, '".$this->getField("KODE_BLOK")."'
	    	, '".$this->getField("KODE_UNIT_M")."'
	    )"; 

		// $this->id= $this->getField("PENGGUNA_EXTERNAL_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function updatecapital()
	{
		$str = "
		UPDATE m_capital_lccm
		SET
		 ASSETNUM= '".$this->getField("ASSETNUM")."'
		, STATUS=".$this->getField("STATUS")."
		, CAPITAL=".$this->getField("CAPITAL")."
		, CAPITAL_DATE=".$this->getField("CAPITAL_DATE")."
		, LAST_UPDATE_USER='".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE=".$this->getField("LAST_UPDATE_DATE")."
		, KODE_DISTRIK='".$this->getField("KODE_DISTRIK")."'
		, KODE_BLOK='".$this->getField("KODE_BLOK")."'
		, KODE_UNIT_M='".$this->getField("KODE_UNIT_M")."'
		WHERE ASSETNUM = '".$this->getField("ASSETNUM_OLD")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function updatestatuscapital()
	{
		$str = "
		UPDATE m_capital_lccm
		SET
		STATUS=".$this->getField("STATUS")."
		, LAST_UPDATE_USER='".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE=".$this->getField("LAST_UPDATE_DATE")."
		WHERE ASSETNUM = '".$this->getField("ASSETNUM_OLD")."' AND  CAPITAL_DATE = '".$this->getField("CAPITAL_DATE_OLD")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}


    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY A.ASSETNUM ASC")
	{
		$str = "
		SELECT 
			A.*
			, CASE WHEN A1.ASSET_LCCM = false THEN 'NO' ELSE 'YES' END ASSET_INFO
			, CASE WHEN A1.ASSET_OH = false THEN 'NO' ELSE 'YES' END ASSET_OH_INFO
			, B.NAMA DISTRIK_INFO
			, B.DISTRIK_ID
			, C.NAMA BLOK_INFO
			, C.BLOK_UNIT_ID
			, D.NAMA UNIT_INFO
			, D.UNIT_MESIN_ID
			, A.KKSNUM
			, A.DESCRIPTION M_DESCRIPTION
			, A.RBD_ID
			, A.PARENT M_PARENT
			, A.INSTALLDATE
			, A.STATUS M_STATUS
			, A2.CAPITAL
			, A2.CAPITAL_DATE
			, CASE WHEN mcl.assetnum is null THEN 'NO' ELSE 'YES' END MCL_INFO
		FROM M_ASSET A 
		LEFT JOIN M_ASSET_LCCM A1 ON trim(A1.ASSETNUM) = trim(A.ASSETNUM)
		LEFT JOIN M_CAPITAL_LCCM A2 ON trim(A2.ASSETNUM) = trim(A1.ASSETNUM)
		LEFT JOIN DISTRIK B ON B.KODE = A1.KODE_DISTRIK
		LEFT JOIN BLOK_UNIT C ON C.KODE = A1.KODE_BLOK AND C.DISTRIK_ID = B.DISTRIK_ID
		LEFT JOIN UNIT_MESIN D ON D.KODE = A1.KODE_UNIT_M AND D.BLOK_UNIT_ID = C.BLOK_UNIT_ID AND D.DISTRIK_ID = B.DISTRIK_ID
		LEFT JOIN 
		(select count(ASSETNUM) ASSETNUM_TOTAL, ASSETNUM
			from m_capital_lccm 
			GROUP BY assetnum
		)mcl ON trim(A.ASSETNUM) = trim(mcl.ASSETNUM)
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

    function selectByParamsCapital($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY A.ASSETNUM ASC")
	{
		$str = "
		SELECT 
			A.*
		

		FROM M_CAPITAL_LCCM A 
	
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,10,$from); 
    }

    function selectByParamsLookup($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY A.ASSETNUM ASC")
	{
		$str = "
		SELECT 
			A1.*
			, CASE WHEN A1.ASSET_LCCM = false THEN 'NO' ELSE 'YES' END ASSET_INFO
			, CASE WHEN A1.ASSET_OH = false THEN 'NO' ELSE 'YES' END ASSET_OH_INFO
			, B.NAMA DISTRIK_INFO
			, B.DISTRIK_ID
			, C.NAMA BLOK_INFO
			, C.BLOK_UNIT_ID
			, D.NAMA UNIT_INFO
			, D.UNIT_MESIN_ID
			, A.KKSNUM
			, A.DESCRIPTION M_DESCRIPTION
			, A.RBD_ID
			, A.PARENT M_PARENT
			, A.INSTALLDATE
			, A.STATUS M_STATUS
			

		FROM M_ASSET A 
		LEFT JOIN M_ASSET_LCCM A1 ON trim(A1.ASSETNUM) = trim(A.ASSETNUM)
		LEFT JOIN DISTRIK B ON B.KODE = A1.KODE_DISTRIK
		LEFT JOIN BLOK_UNIT C ON C.KODE = A1.KODE_BLOK AND C.DISTRIK_ID = B.DISTRIK_ID
		LEFT JOIN UNIT_MESIN D ON D.KODE = A1.KODE_UNIT_M AND D.BLOK_UNIT_ID = C.BLOK_UNIT_ID AND D.DISTRIK_ID = B.DISTRIK_ID
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