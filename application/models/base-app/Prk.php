<? 
  include_once(APPPATH.'/models/Entity.php');

  class Prk extends Entity{ 

	var $query;

    function Prk()
	{
      $this->Entity(); 
    }

    function insert()
    {

    	$str = "
    	INSERT INTO t_prk_lccm
    	(
    		SITEID, ASSETNUM, COST_ON_ASSET, PRK_YEAR, DSTRCT_CODE, ACCOUNT_CODE, PROJECT_NO, PROJ_DESC, PO_NO, VALUE_PAID, LAST_APPR_DATE,LAST_CREATE_USER, LAST_CREATE_DATE

    	)
    	VALUES 
    	(
	    	'PT'
	    	, '".$this->getField("ASSETNUM")."'
	    	, ".$this->getField("COST_ON_ASSET")."
	    	, ".$this->getField("PRK_YEAR")."
	    	, '".$this->getField("DSTRCT_CODE")."'
	    	, '".$this->getField("ACCOUNT_CODE")."'
	    	, '".$this->getField("PROJECT_NO")."'
	    	, '".$this->getField("PROJ_DESC")."'
	    	, '".$this->getField("PO_NO")."'
	    	, ".$this->getField("VALUE_PAID")."
	    	, ".$this->getField("LAST_APPR_DATE")."
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
		UPDATE t_prk_lccm
		SET
		 ASSETNUM='".$this->getField("ASSETNUM")."'
		, COST_ON_ASSET=".$this->getField("COST_ON_ASSET")."
		, PRK_YEAR=".$this->getField("PRK_YEAR")."
		, DSTRCT_CODE='".$this->getField("DSTRCT_CODE")."'
		, ACCOUNT_CODE='".$this->getField("ACCOUNT_CODE")."'
		, PROJECT_NO='".$this->getField("PROJECT_NO")."'
		, PROJ_DESC='".$this->getField("PROJ_DESC")."'
		, PO_NO='".$this->getField("PO_NO")."'
		, VALUE_PAID=".$this->getField("VALUE_PAID")."
		, LAST_APPR_DATE=".$this->getField("LAST_APPR_DATE")."
		, LAST_UPDATE_USER='".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE=".$this->getField("LAST_UPDATE_DATE")."
		WHERE ASSETNUM = '".$this->getField("ASSETNUM_OLD")."' AND COST_ON_ASSET = ".$this->getField("COST_ON_ASSET_OLD")." AND PRK_YEAR = '".$this->getField("PRK_YEAR_OLD")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM t_prk_lccm
		WHERE 
		ASSETNUM = '".$this->getField("ASSETNUM")."' AND COST_ON_ASSET = ".$this->getField("COST_ON_ASSET")." AND PRK_YEAR = '".$this->getField("PRK_YEAR")."' "; 

		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $statement2='',$sOrder="ORDER BY A.PRK_YEAR ASC")
	{
		$str = "
		SELECT
			PC.PRK
			, CASE WHEN PC.PRK = TRUE THEN 'Valid' WHEN PC.PRK = FALSE THEN 'Tidak Valid' ELSE '-' END INFO_NAMA
			, A.*
		FROM
		(
			SELECT 
				A.PRK_YEAR,B.KODE_DISTRIK, C.NAMA NAMA_DISTRIK,B.KODE_BLOK, D.NAMA NAMA_BLOK, B.KODE_UNIT_M,E.NAMA NAMA_UNIT_MESIN
			FROM t_prk_lccm A 
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
		
		$str .= $statement." GROUP BY A.PRK_YEAR, B.KODE_DISTRIK,B.KODE_BLOK,B.KODE_UNIT_M, C.NAMA,D.NAMA,E.NAMA 
		) A
		LEFT JOIN t_preperation_lccm PC ON PC.YEAR_LCCM = A.PRK_YEAR AND PC.KODE_DISTRIK = A.KODE_DISTRIK AND PC.KODE_BLOK = A.KODE_BLOK AND PC.KODE_UNIT_M = A.KODE_UNIT_M
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
		FROM t_prk_lccm A 
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

    
  } 
?>