<? 
  include_once(APPPATH.'/models/Entity.php');

  class WorkOrder extends Entity{ 

	var $query;

    function WorkOrder()
	{
      $this->Entity(); 
    }

    
    function insert()
    {

    	$str = "
    	INSERT INTO t_workorder
    	(
    		SITEID, ASSETNUM, EQUIPMENT_DESC, WONUM, WO_DESC, LONG_DESCRIPTION, WORKLOG, WO_COMPLT_COMMENT, TASK_DESC, TASK_COMPLETION_COMMENTS, WORKTYPE, JPNUM, WORK_GROUP, TASK_WORK_GROUP, MAT_COST, SERV_COST, TOTAL_COST, REPORTDATE, ACTSTART, ACTFINISH, ACTUAL_REPAIR_TIME, ON_HAND_REPAIR, JUMLAH_LABOR, EST_LAB_HRS, ACT_LAB_HRS, ACTLABCOST, ACT_EQUIP_COST, ESTDUR, YEAR, SCHEDSTART, SCHEDFINISH, WOSTATUS, WO_TASK_STATUS, NEEDDOWNTIME, REPORT_DOWN_TIME, VALIDATION_DOWNTIME, STATUS_NOT_OH_NOT_DOWNTIME, KKS_VALID, APPROVAL_STATUS, SOURCE_DATA, LAST_SYNC, LAST_CREATE_USER, LAST_CREATE_DATE
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
		UPDATE t_workorder
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


	function updatewovalid()
	{
		$str = "
		UPDATE t_workorder
		SET
		 ASSETNUM='".$this->getField("ASSETNUM")."'
		, EQUIPMENT_DESC='".$this->getField("EQUIPMENT_DESC")."'
		, WONUM='".$this->getField("WONUM")."'
		, WO_DESC='".$this->getField("WO_DESC")."'
		, WORKTYPE='".$this->getField("WORKTYPE")."'
		, WORK_GROUP='".$this->getField("WORK_GROUP")."'
		, VALIDATION_DOWNTIME=".$this->getField("VALIDATION_DOWNTIME")."
		, STATUS_NOT_OH_NOT_DOWNTIME=".$this->getField("STATUS_NOT_OH_NOT_DOWNTIME")."
		, ON_HAND_REPAIR=".$this->getField("ON_HAND_REPAIR")."
		, JUMLAH_LABOR=".$this->getField("JUMLAH_LABOR")."
		, LAST_UPDATE_USER='".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE=".$this->getField("LAST_UPDATE_DATE")."
		WHERE ASSETNUM = '".$this->getField("ASSETNUM_OLD")."' AND WONUM= '".$this->getField("WONUM_OLD")."' AND WO_YEAR = '".$this->getField("WO_YEAR")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}




	function updatevalidasi()
	{
		$str = "
		UPDATE t_workorder
		SET
		 ASSETNUM='".$this->getField("ASSETNUM")."'
		, VALIDATION_DOWNTIME=".$this->getField("VALIDATION_DOWNTIME")."
		, STATUS_NOT_OH_NOT_DOWNTIME=".$this->getField("STATUS_NOT_OH_NOT_DOWNTIME")."
		, ON_HAND_REPAIR=".$this->getField("ON_HAND_REPAIR")."
		, JUMLAH_LABOR=".$this->getField("JUMLAH_LABOR")."
		, APPROVAL_STATUS='".$this->getField("APPROVAL_STATUS")."'
		, LAST_UPDATE_USER='".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE=".$this->getField("LAST_UPDATE_DATE")."
		WHERE  date_part('year', REPORTDATE)='".$this->getField("TAHUN")."'  AND WONUM = '".$this->getField("WONUM")."' AND SITEID = '".$this->getField("SITEID")."' AND ASSETNUM = '".$this->getField("ASSETNUMOLD")."'
		"; 
		$this->query = $str;
		// echo $str;
		return $this->execQuery($str);
	}

	function updateprep()
	{
		$str = "
		UPDATE t_preperation_lccm
		SET
		 WO_CR=".$this->getField("WO_CR")."
		WHERE  YEAR_LCCM='".$this->getField("YEAR_LCCM")."'  AND KODE_DISTRIK = '".$this->getField("KODE_DISTRIK")."' AND KODE_BLOK = '".$this->getField("KODE_BLOK")."' AND KODE_UNIT_M = '".$this->getField("KODE_UNIT_M")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM t_workorder
		WHERE 
		ASSETNUM = '".$this->getField("ASSETNUM")."' AND COST_ON_ASSET = ".$this->getField("COST_ON_ASSET")." AND PRK_YEAR = '".$this->getField("PRK_YEAR")."' "; 

		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}



    function selectByParamsTahun($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY wo_year ASC")
	{
		$str = "
		SELECT wo_year YEAR_INFO,c.WO_CR
		 ,CASE 
		 WHEN c.WO_CR = true 
		 THEN 
			'Valid'
		 ELSE 
		 'Belum Valid'
		 END STATUS_INFO
		FROM 
		t_workorder a
		LEFT JOIN M_ASSET_LCCM b on b.ASSETNUM = a.ASSETNUM
		left JOIN T_PREPERATION_LCCM C on C.YEAR_LCCM = a.wo_year
		WHERE 1=1
		and A.wo_year is not null


		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY wo_year,c.WO_CR ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsDetail($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY A.ASSETNUM ASC")
	{
		$str = "
		SELECT A.*
		, 
		 B.KODE_DISTRIK, B.KODE_BLOK,B.KODE_UNIT_M
		, CASE 
		 WHEN on_hand_repair is null 
		 THEN 
			 case
			 WHEN actual_repair_time is not null
			 THEN 
			 on_hand_repair = actual_repair_time
			 else
			 on_hand_repair::text = to_char(actstart-actfinish, 'DD/MM/YYYY')
			 end
		 ELSE on_hand_repair >= 72 END ON_HAND_INFO
		 , CASE 
		 WHEN APPROVAL_STATUS is null 
		 THEN 
		 'X'
		 ELSE
		 'V'
		 END WOSTATUSINFO
		FROM 
		T_WORKORDER A
		LEFT JOIN M_ASSET_LCCM B ON B.ASSETNUM = A.ASSETNUM
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

    function selectByParamsCheckStatus($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY B.ASSETNUM ASC")
	{
		$str = "
		SELECT A.*,B.APPROVAL_STATUS
		
		FROM 
		t_preperation_lccm A
		INNER JOIN T_WORKORDER B ON B.WO_YEAR = A.YEAR_LCCM
		LEFT JOIN M_ASSET_LCCM C ON C.ASSETNUM = B.ASSETNUM
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
		LEFT JOIN UNIT_MESIN F ON F.KODE = A.KODE_UNIT_M AND F.BLOK_UNIT_ID = E.BLOK_UNIT_ID AND F.DISTRIK_ID = D.DISTRIK_ID

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


    function jumlahwo($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="")
	{
		$str = "
		SELECT COUNT(1) JUMLAH FROM T_WORKORDER A WHERE 1=1

		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

    function jumlahasset($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="")
	{
		$str = "
		SELECT COUNT(1) JUMLAH FROM m_asset a
		left join m_asset_lccm b on b.assetnum = a.assetnum
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

    function jumlahassetlccm($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="")
	{
		$str = "
		SELECT COUNT(1) JUMLAH 
		FROM m_asset a
		inner join m_asset_lccm b on b.assetnum = a.assetnum
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

    function jumlahassetwo($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="")
	{
		$str = "
		SELECT COUNT(1) JUMLAH 
		FROM T_WORKORDER a
		inner join m_asset_lccm b on b.assetnum = a.assetnum
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