<? 
  include_once(APPPATH.'/models/Entity.php');

  class Operation extends Entity{ 

	var $query;

    function Operation()
	{
      $this->Entity(); 
    }

    function insertplant()
    {
    	$str = "
    	INSERT INTO t_opr_plant_lccm
    	(
    		SITEID, OPR_YEAR, EMPLOY_SALARY, OPR_HOURS_IN_YEAR, PROD_IN_YEAR, EFF_PRICE
    		, LAST_CREATE_USER, LAST_CREATE_DATE,KODE_DISTRIK,KODE_BLOK,KODE_UNIT_M
    	)
    	VALUES 
    	(
	    	'PT'
	    	, ".$this->getField("OPR_YEAR")."
	    	, ".$this->getField("EMPLOY_SALARY")."
	    	, ".$this->getField("OPR_HOURS_IN_YEAR")."
	    	, ".$this->getField("PROD_IN_YEAR")."
	    	, ".$this->getField("EFF_PRICE")."
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    	, '".$this->getField("KODE_DISTRIK")."'
	    	, '".$this->getField("KODE_BLOK")."'
	    	, '".$this->getField("KODE_UNIT_M")."'
	    )";

		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function updateplant()
	{
		$str = "
		UPDATE t_opr_plant_lccm
		SET
		EMPLOY_SALARY= ".$this->getField("EMPLOY_SALARY")."
		, OPR_HOURS_IN_YEAR= ".$this->getField("OPR_HOURS_IN_YEAR")."
		, PROD_IN_YEAR= ".$this->getField("PROD_IN_YEAR")."
		, EFF_PRICE= ".$this->getField("EFF_PRICE")."
		, LAST_UPDATE_USER='".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE=".$this->getField("LAST_UPDATE_DATE")."
		, KODE_DISTRIK='".$this->getField("KODE_DISTRIK")."'
		, KODE_BLOK='".$this->getField("KODE_BLOK")."'
		, KODE_UNIT_M='".$this->getField("KODE_UNIT_M")."'
		WHERE OPR_YEAR = ".$this->getField("OPR_YEAR")."
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}


	function updateasset()
	{
		$str = "
		UPDATE T_OPR_ASSET_LCCM
		SET
		 ELECT_LOSS=".$this->getField("ELECT_LOSS")."
		, EFF_LOSS=".$this->getField("EFF_LOSS")."
		, COST_OF_ELECT_LOSS=".$this->getField("COST_OF_ELECT_LOSS")."
		, COST_OF_EFF_LOSS=".$this->getField("COST_OF_EFF_LOSS")."
		, OPERATION_COST=".$this->getField("OPERATION_COST")."
		, LAST_UPDATE_USER='".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE=".$this->getField("LAST_UPDATE_DATE")."
		WHERE OPR_YEAR = '".$this->getField("OPR_YEAR")."'  AND  ASSETNUM = '".$this->getField("ASSETNUM")."' 
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}


	function updateassetdinamis()
	{
		$str = "
		UPDATE T_OPR_ASSET_LCCM
		SET
		 EMPLOY_SALARY_ASSET=".$this->getField("EMPLOY_SALARY_ASSET")."
		, COST_OF_ELECT_LOSS=".$this->getField("COST_OF_ELECT_LOSS")."
		, COST_OF_EFF_LOSS='".$this->getField("COST_OF_EFF_LOSS")."'
		, OPERATION_COST=".$this->getField("OPERATION_COST")."
		, LAST_UPDATE_USER='".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE=".$this->getField("LAST_UPDATE_DATE")."
		WHERE OPR_YEAR = '".$this->getField("OPR_YEAR")."' AND  ASSETNUM = '".$this->getField("ASSETNUM")."' ;
		"; 
		$this->query = $str;
		// echo $str;
		return $this->execQuery($str);
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


	function deleteasset()
	{
		$str = "
		DELETE FROM t_opr_asset_lccm
		WHERE 
		ASSETNUM = '".$this->getField("ASSETNUM")."' AND OPR_YEAR = '".$this->getField("OPR_YEAR")."' "; 

		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}


    function selectByParamsTahun($paramsArray=array(),$limit=-1,$from=-1, $statement='',  $statement2='',$sOrder="ORDER BY A.OPR_YEAR ASC")
	{
		$str = "
		SELECT
			PC.OPERATION
			, CASE WHEN PC.OPERATION = TRUE THEN 'Valid' WHEN PC.OPERATION = FALSE THEN 'Tidak Valid' ELSE '-' END INFO_NAMA
			, A.*
		FROM
			(
				SELECT A.OPR_YEAR,B1.KODE_DISTRIK, C.NAMA NAMA_DISTRIK,B1.KODE_BLOK, D.NAMA NAMA_BLOK, B1.KODE_UNIT_M,E.NAMA NAMA_UNIT_MESIN
				FROM 
				t_opr_asset_lccm a
				LEFT JOIN t_opr_plant_lccm b on b.opr_year = a.opr_year
				INNER JOIN M_ASSET_LCCM B1 ON B1.ASSETNUM = A.ASSETNUM
				LEFT JOIN DISTRIK C ON C.KODE = B1.KODE_DISTRIK
				LEFT JOIN BLOK_UNIT D ON D.KODE = B1.KODE_BLOK AND D.DISTRIK_ID = C.DISTRIK_ID
				LEFT  JOIN UNIT_MESIN E ON E.KODE = B1.KODE_UNIT_M AND E.BLOK_UNIT_ID = D.BLOK_UNIT_ID AND E.DISTRIK_ID = C.DISTRIK_ID
				WHERE 1=1

		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY A.OPR_YEAR, B1.KODE_DISTRIK,B1.KODE_BLOK,B1.KODE_UNIT_M, C.NAMA,D.NAMA,E.NAMA 
		) A
		LEFT JOIN t_preperation_lccm PC ON PC.YEAR_LCCM = A.OPR_YEAR AND PC.KODE_DISTRIK = A.KODE_DISTRIK AND PC.KODE_BLOK = A.KODE_BLOK AND PC.KODE_UNIT_M = A.KODE_UNIT_M
		WHERE 1=1 ".$statement2."
		".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsDetail($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY A.ASSETNUM ASC")
	{
		$str = "
		
		
		SELECT A.*, COALESCE(EMPLOY_SALARY_INFO,0::double precision) +   COALESCE(ELECT_COST_INFO,0::double precision) + COALESCE(EFF_COST_INFO,0::double precision) OPERATION_COST_INFO
		FROM
		( 
			SELECT A.ASSETNUM,C.DESCRIPTION ASSET_DESC,A.OPR_YEAR,B.EMPLOY_SALARY,A.ELECT_LOSS,A.EFF_LOSS
			, A.EFF_LOSS * B.PROD_IN_YEAR * B.EFF_PRICE EFF_COST_INFO
			, A.ELECT_LOSS * B.OPR_HOURS_IN_YEAR * A.ELECT_LOSS ELECT_COST_INFO
			, D.CAPITAL / SUM(OK.TOTAL_CAPITAL) * B.EMPLOY_SALARY EMPLOY_SALARY_INFO
			FROM 
			T_OPR_ASSET_LCCM A
			LEFT JOIN T_OPR_PLANT_LCCM B ON B.OPR_YEAR = A.OPR_YEAR
			LEFT JOIN M_ASSET C ON TRIM(C.ASSETNUM) = TRIM(A.ASSETNUM)
			LEFT JOIN M_CAPITAL_LCCM D ON TRIM(D.ASSETNUM) = TRIM(A.ASSETNUM) AND D.STATUS IS TRUE
			LEFT JOIN 
			(
				SELECT ENERGY_PRICE,KODE_DISTRIK,KODE_BLOK,PRICE_YEAR
				FROM T_ENERGY_PRICE_LCCM A
			) EN ON B.KODE_DISTRIK = EN.KODE_DISTRIK AND B.KODE_BLOK = EN.KODE_BLOK AND B.OPR_YEAR = EN.PRICE_YEAR
			LEFT JOIN 
			(
				SELECT  KODE_DISTRIK,KODE_BLOK,KODE_UNIT_M,SUM(A.CAPITAL) TOTAL_CAPITAL
				FROM M_CAPITAL_LCCM A
				GROUP BY KODE_DISTRIK,KODE_BLOK,KODE_UNIT_M
			) 
			OK ON D.KODE_DISTRIK = OK.KODE_DISTRIK AND D.KODE_BLOK = OK.KODE_BLOK AND D.KODE_UNIT_M = OK.KODE_UNIT_M
			WHERE 1=1
			
			GROUP BY A.ASSETNUM,C.DESCRIPTION,A.OPR_YEAR,B.EMPLOY_SALARY,B.EFF_PRICE,B.PROD_IN_YEAR,B.OPR_HOURS_IN_YEAR,D.CAPITAL,EN.ENERGY_PRICE
		) A
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


    function selectByParamsHitung($paramsArray=array(),$limit=-1,$from=-1, $statement='',$effloss='',$electloss='', $sOrder="ORDER BY A.ASSETNUM ASC")
	{
		if(empty($electloss))
		{
			$electloss="A.ELECT_LOSS";
		}

		if(empty($effloss))
		{
			$effloss="A.EFF_LOSS";
		}
		$str = "
		
		SELECT OPR_YEAR,EFF_COST_INFO, ELECT_COST_INFO,EMPLOY_SALARY_INFO,COALESCE(EMPLOY_SALARY_INFO,0::double precision) +   COALESCE(ELECT_COST_INFO,0::double precision) + COALESCE(EFF_COST_INFO,0::double precision) OPERATION_COST_INFO
		FROM
		( 
			SELECT 
			A.OPR_YEAR,A.ASSETNUM
			, ".$effloss." * B.PROD_IN_YEAR * B.EFF_PRICE EFF_COST_INFO
			, ".$electloss." * B.OPR_HOURS_IN_YEAR * ".$electloss." ELECT_COST_INFO
			, D.CAPITAL / SUM(OK.TOTAL_CAPITAL) * B.EMPLOY_SALARY EMPLOY_SALARY_INFO
			FROM 
			T_OPR_ASSET_LCCM A
			LEFT JOIN T_OPR_PLANT_LCCM B ON B.OPR_YEAR = A.OPR_YEAR
			LEFT JOIN M_ASSET C ON C.ASSETNUM = A.ASSETNUM
			LEFT JOIN M_CAPITAL_LCCM D ON D.ASSETNUM = A.ASSETNUM
			LEFT JOIN 
			(
				SELECT ENERGY_PRICE,KODE_DISTRIK,KODE_BLOK,PRICE_YEAR
				FROM T_ENERGY_PRICE_LCCM A
			) EN ON B.KODE_DISTRIK = EN.KODE_DISTRIK AND B.KODE_BLOK = EN.KODE_BLOK AND B.OPR_YEAR = EN.PRICE_YEAR
			LEFT JOIN 
			(
				SELECT  KODE_DISTRIK,KODE_BLOK,KODE_UNIT_M,SUM(A.CAPITAL) TOTAL_CAPITAL
				FROM M_CAPITAL_LCCM A
				GROUP BY KODE_DISTRIK,KODE_BLOK,KODE_UNIT_M
			) 
			OK ON D.KODE_DISTRIK = OK.KODE_DISTRIK AND D.KODE_BLOK = OK.KODE_BLOK AND D.KODE_UNIT_M = OK.KODE_UNIT_M
			WHERE 1=1
			
			GROUP BY A.ASSETNUM,C.DESCRIPTION,A.OPR_YEAR,B.EMPLOY_SALARY,B.EFF_PRICE,B.PROD_IN_YEAR,B.OPR_HOURS_IN_YEAR,D.CAPITAL,EN.ENERGY_PRICE
		) A
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

    function selectByParamsDetailNew($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY A.ASSETNUM ASC")
	{
		$str = "
		
		
		SELECT a.*,C.DESCRIPTION ASSET_DESC
			FROM 
			T_OPR_ASSET_LCCM A
			LEFT JOIN T_OPR_PLANT_LCCM B ON B.OPR_YEAR = A.OPR_YEAR
			LEFT JOIN M_ASSET C ON C.ASSETNUM = A.ASSETNUM
			LEFT JOIN M_CAPITAL_LCCM D ON D.ASSETNUM = A.ASSETNUM
			LEFT JOIN 
			(
				SELECT ENERGY_PRICE,KODE_DISTRIK,KODE_BLOK,PRICE_YEAR
				FROM T_ENERGY_PRICE_LCCM A
			) EN ON B.KODE_DISTRIK = EN.KODE_DISTRIK AND B.KODE_BLOK = EN.KODE_BLOK AND B.OPR_YEAR = EN.PRICE_YEAR
			
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

    function selectplant($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="")
	{
		$str = "
		SELECT A.*,A.OPR_YEAR OPR_YEAR_ASSET,c.energy_price,D.DISTRIK_ID,E.BLOK_UNIT_ID,F.UNIT_MESIN_ID
		FROM 
		t_opr_plant_lccm a
		LEFT JOIN t_energy_price_lccm C on c.kode_distrik = a.kode_distrik and c.kode_blok = a.kode_blok and c.price_year = a.opr_year
		LEFT JOIN DISTRIK D ON D.KODE = A.KODE_DISTRIK
		LEFT JOIN BLOK_UNIT E ON E.KODE = A.KODE_BLOK AND E.DISTRIK_ID = D.DISTRIK_ID
		LEFT  JOIN UNIT_MESIN F ON F.KODE = A.KODE_UNIT_M AND F.BLOK_UNIT_ID = E.BLOK_UNIT_ID AND F.DISTRIK_ID = D.DISTRIK_ID

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