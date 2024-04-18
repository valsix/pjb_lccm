<? 
  include_once(APPPATH.'/models/Entity.php');

  class Import extends Entity{ 

	var $query;

    function Import()
	{
      $this->Entity(); 
    }


    function insertperusahaaneksternal()
    {
    	$this->setField("PERUSAHAAN_EKSTERNAL_ID", $this->getNextId("PERUSAHAAN_EKSTERNAL_ID","perusahaan_eksternal"));

    	$str = "
    	INSERT INTO perusahaan_eksternal
    	(
    		PERUSAHAAN_EKSTERNAL_ID, NAMA, KODE
    	)
    	VALUES 
    	(
	    	'".$this->getField("PERUSAHAAN_EKSTERNAL_ID")."'
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("KODE")."'
	    )"; 

		$this->id= $this->getField("PERUSAHAAN_EKSTERNAL_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function updateperusahaaneksternal()
	{
		$str = "
		UPDATE perusahaan_eksternal
		SET
		NAMA= '".$this->getField("NAMA")."'
		, KODE= '".$this->getField("KODE")."'
		WHERE PERUSAHAAN_EKSTERNAL_ID = '".$this->getField("PERUSAHAAN_EKSTERNAL_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

    function insertdirektorat()
    {
    	$this->setField("DIREKTORAT_ID", $this->getNextId("DIREKTORAT_ID","DIREKTORAT"));

    	$str = "
    	INSERT INTO DIREKTORAT
    	(
    		DIREKTORAT_ID,NAMA, LAST_CREATE_USER,LAST_CREATE_DATE,KODE
    	)
    	VALUES 
    	(
    		".$this->getField("DIREKTORAT_ID")."
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    	, '".$this->getField("KODE")."'
	    )"; 

	    $this->id= $this->getField("DIREKTORAT_ID");
	    $this->query= $str;
			// echo $str;exit;
	    return $this->execQuery($str);
	}

	function updatedirektorat()
	{
		$str = "
		UPDATE DIREKTORAT
		SET
		NAMA= '".$this->getField("NAMA")."'
		, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE= '".$this->getField("LAST_UPDATE_DATE")."'
		, KODE= '".$this->getField("KODE")."'
		WHERE DIREKTORAT_ID = '".$this->getField("DIREKTORAT_ID")."'
		"; 
		$this->query = $str;
			// echo $str;exit;
		return $this->execQuery($str);
	}

	function insertwilayah()
    {
    	$this->setField("WILAYAH_ID", $this->getNextId("WILAYAH_ID","WILAYAH"));

    	$str = "
    	INSERT INTO WILAYAH
    	(
    		WILAYAH_ID,NAMA,LAST_CREATE_USER,LAST_CREATE_DATE,KODE
    	)
    	VALUES 
    	(
    		".$this->getField("WILAYAH_ID")."
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    	, '".$this->getField("KODE")."'
	    )"; 

	    $this->id= $this->getField("WILAYAH_ID");
	    $this->query= $str;
			// echo $str;exit;
	    return $this->execQuery($str);
	}


	function updatewilayah()
	{
		$str = "
		UPDATE WILAYAH
		SET
		NAMA= '".$this->getField("NAMA")."'
		, KODE= '".$this->getField("KODE")."'
		, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE= '".$this->getField("LAST_UPDATE_DATE")."'
		WHERE WILAYAH_ID = '".$this->getField("WILAYAH_ID")."'
		"; 
		$this->query = $str;
			// echo $str;exit;
		return $this->execQuery($str);
	}


	function insertjenis()
    {
    	$this->setField("JENIS_UNIT_KERJA_ID", $this->getNextId("JENIS_UNIT_KERJA_ID","JENIS_UNIT_KERJA"));

    	$str = "
    	INSERT INTO JENIS_UNIT_KERJA
    	(
    		JENIS_UNIT_KERJA_ID,NAMA,LAST_CREATE_USER,LAST_CREATE_DATE,KODE
    	)
    	VALUES 
    	(
    		".$this->getField("JENIS_UNIT_KERJA_ID")."
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    	, '".$this->getField("KODE")."'
	    )"; 

	    $this->id= $this->getField("JENIS_UNIT_KERJA_ID");
	    $this->query= $str;
			// echo $str;exit;
	    return $this->execQuery($str);
	}


	function updatejenis()
	{
			$str = "
			UPDATE JENIS_UNIT_KERJA
			SET
			 NAMA= '".$this->getField("NAMA")."'
			, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
			, LAST_UPDATE_DATE= '".$this->getField("LAST_UPDATE_DATE")."'
			, KODE= '".$this->getField("KODE")."'
			WHERE JENIS_UNIT_KERJA_ID = '".$this->getField("JENIS_UNIT_KERJA_ID")."'
			"; 
			$this->query = $str;
			// echo $str;exit;
			return $this->execQuery($str);
	}


    function insertblok()
    {
    	$this->setField("BLOK_UNIT_ID", $this->getNextId("BLOK_UNIT_ID","blok_unit"));

    	$str = "
    	INSERT INTO blok_unit
    	(
    		BLOK_UNIT_ID, NAMA, DISTRIK_ID,KODE,KODE_EAM,EAM_ID,URL
    	)
    	VALUES 
    	(
	    	'".$this->getField("BLOK_UNIT_ID")."'
	    	, '".$this->getField("NAMA")."'
	    	, ".$this->getField("DISTRIK_ID")."
	    	, '".$this->getField("KODE")."'
	    	, '".$this->getField("KODE_EAM")."'
	    	, ".$this->getField("EAM_ID")."
	    	, '".$this->getField("URL")."'
	    )"; 

		$this->id= $this->getField("BLOK_UNIT_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function insertunitmesin()
    {
    	$this->setField("UNIT_MESIN_ID", $this->getNextId("UNIT_MESIN_ID","unit_mesin"));

    	$str = "
    	INSERT INTO unit_mesin
    	(
    		UNIT_MESIN_ID, NAMA, DISTRIK_ID,BLOK_UNIT_ID,KODE,KODE_EAM,EAM_ID,URL
    	)
    	VALUES 
    	(
	    	'".$this->getField("UNIT_MESIN_ID")."'
	    	, '".$this->getField("NAMA")."'
	    	, ".$this->getField("DISTRIK_ID")."
	    	, ".$this->getField("BLOK_UNIT_ID")."
	    	, '".$this->getField("KODE")."'
	    	, '".$this->getField("KODE_EAM")."'
	    	, ".$this->getField("EAM_ID")."
	    	, '".$this->getField("URL")."'
	    )"; 

		$this->id= $this->getField("UNIT_MESIN_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}


	function updateunitmesin()
	{
		$str = "
		UPDATE unit_mesin
		SET
		 NAMA= '".$this->getField("NAMA")."'
		, DISTRIK_ID= ".$this->getField("DISTRIK_ID")."
		, BLOK_UNIT_ID= ".$this->getField("BLOK_UNIT_ID")."
		, KODE= '".$this->getField("KODE")."'
		, KODE_EAM= '".$this->getField("KODE_EAM")."'
		, EAM_ID= ".$this->getField("EAM_ID")."
		, URL= '".$this->getField("URL")."'
		WHERE UNIT_MESIN_ID = '".$this->getField("UNIT_MESIN_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	
	 function insertdistrik()
    {
    	$this->setField("DISTRIK_ID", $this->getNextId("DISTRIK_ID","distrik"));

    	$str = "
    	INSERT INTO distrik
    	(
    		DISTRIK_ID, KODE_SITE, NAMA, KODE, WILAYAH_ID, PERUSAHAAN_EKSTERNAL_ID,DIREKTORAT_ID
    	)
    	VALUES 
    	(
	    	'".$this->getField("DISTRIK_ID")."'
	    	, '".$this->getField("KODE_SITE")."'
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("KODE")."'
	    	, ".$this->getField("WILAYAH_ID")."
	    	, ".$this->getField("PERUSAHAAN_EKSTERNAL_ID")."
	    	, ".$this->getField("DIREKTORAT_ID")."
	    )"; 

		$this->id= $this->getField("DISTRIK_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	
	
	function selectByParamsCheckPerusahaanExternal($paramsArray=array(),$limit=-1,$from=-1, $distrikment='', $sOrder="ORDER BY PERUSAHAAN_EKSTERNAL_ID ASC")
	{
		$str = "
		SELECT 
			A.*
		FROM perusahaan_eksternal A
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $distrikment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }


    function selectByParamsCheckDirektorat($paramsArray=array(),$limit=-1,$from=-1, $distrikment='', $sOrder="ORDER BY DIREKTORAT_ID ASC")
	{
		$str = "
		SELECT 
			A.*
		FROM DIREKTORAT A
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $distrikment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsCheckWilayah($paramsArray=array(),$limit=-1,$from=-1, $distrikment='', $sOrder="ORDER BY WILAYAH_ID ASC")
	{
		$str = "
		SELECT 
			A.*
		FROM WILAYAH A
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $distrikment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

     function selectByParamsCheckDistrik($paramsArray=array(),$limit=-1,$from=-1, $distrikment='', $sOrder="ORDER BY DISTRIK_ID ASC")
	{
		$str = "
		SELECT 
			A.*
		FROM DISTRIK A
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $distrikment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }


	function selectByParamsCheckJabatan($paramsArray=array(),$limit=-1,$from=-1, $pengguna_externalment='', $sOrder="ORDER BY POSITION_ID ASC")
	{
		$str = "
		SELECT 
			A.*
		FROM MASTER_JABATAN A
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $pengguna_externalment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

    function insertjabatan()
  	{
	    $str = "
	    INSERT INTO MASTER_JABATAN
	    (
	        POSITION_ID, NAMA_POSISI, SUPERIOR_ID, KODE_KATEGORI, KATEGORI, KODE_KELOMPOK_JABATAN, KELOMPOK_JABATAN
	        , KODE_JENJANG_JABATAN, JENJANG_JABATAN, KODE_KLASIFIKASI_UNIT, KLASIFIKASI_UNIT, KODE_UNIT, UNIT, KODE_DITBID, DITBID, KODE_BAGIAN, BAGIAN,OCCUP_STATUS,NAMA_LENGKAP,EMAIL,NID,POSISI,CHANGE_REASON,KODE_DISTRIK
	    )
	    VALUES 
	    (
	     	'".$this->getField("POSITION_ID")."'
	      , '".$this->getField("NAMA_POSISI")."'
	      , '".$this->getField("SUPERIOR_ID")."'
	      , '".$this->getField("KODE_KATEGORI")."'
	      , '".$this->getField("KATEGORI")."'
	      , '".$this->getField("KODE_KELOMPOK_JABATAN")."'
	      , '".$this->getField("KELOMPOK_JABATAN")."'
	      , '".$this->getField("KODE_JENJANG_JABATAN")."'
	      , '".$this->getField("JENJANG_JABATAN")."'
	      , '".$this->getField("KODE_KLASIFIKASI_UNIT")."'
	      , '".$this->getField("KLASIFIKASI_UNIT")."'
	      , '".$this->getField("KODE_UNIT")."'
	      , '".$this->getField("UNIT")."'
	      , '".$this->getField("KODE_DITBID")."'
	      , '".$this->getField("DITBID")."'
	      , '".$this->getField("KODE_BAGIAN")."'
	      , '".$this->getField("BAGIAN")."'
	      , '".$this->getField("OCCUP_STATUS")."'
	      , '".$this->getField("NAMA_LENGKAP")."'
	      , '".$this->getField("EMAIL")."'
	      , '".$this->getField("NID")."'
	      , '".$this->getField("POSISI")."'
	      , '".$this->getField("CHANGE_REASON")."'
	      , '".$this->getField("KODE_DISTRIK")."'
	    )"; 
	    $this->query= $str;
	    // echo $str;exit;
	    return $this->execQuery($str);
  	}

    function insertwostanding()
  	{
	    $str = "
	    INSERT INTO T_WO_STANDING_LCCM
	    (
	        KODE_DISTRIK, KODE_BLOK, KODE_UNIT_M, GROUP_PM, PM_YEAR, COST_PM_YEARLY, LAST_CREATE_USER, LAST_CREATE_DATE,STATE_STATUS
	    )
	    VALUES 
	    (
	     	'".$this->getField("KODE_DISTRIK")."'
	      , '".$this->getField("KODE_BLOK")."'
	      , '".$this->getField("KODE_UNIT_M")."'
	      , '".$this->getField("GROUP_PM")."'
	      , '".$this->getField("PM_YEAR")."'
	      , '".$this->getField("COST_PM_YEARLY")."'
	      , '".$this->getField("LAST_CREATE_USER")."'
	      , '".$this->getField("LAST_CREATE_DATE")."'
	      , '".$this->getField("STATE_STATUS")."'
	    )"; 
	    $this->query= $str;
	    // echo $str;exit;
	    return $this->execQuery($str);
  	}


    function insertwo()
    {

    	$str = "
    	INSERT INTO t_workorder
    	(
    		SITEID, ASSETNUM, WONUM, WO_DESC, WORKTYPE, WORK_GROUP, NEEDDOWNTIME, REPORTDATE, LAST_CREATE_USER, LAST_CREATE_DATE,WO_YEAR
    	)
    	VALUES 
    	(
	    	'PT'
	    	, '".$this->getField("ASSETNUM")."'
	    	, '".$this->getField("WONUM")."'
	    	, '".$this->getField("WO_DESC")."'
	    	, '".$this->getField("WORKTYPE")."'
	    	, '".$this->getField("WORK_GROUP")."'
	    	, '".$this->getField("NEEDDOWNTIME")."'
	    	, ".$this->getField("REPORTDATE")."
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    	, ".$this->getField("WO_YEAR")."
	    )"; 

		// $this->id= $this->getField("PENGGUNA_EXTERNAL_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function updatewo()
	{
		$str = "
		UPDATE t_workorder
		SET
		 ASSETNUM= '".$this->getField("ASSETNUM")."'
		, WONUM= '".$this->getField("WONUM")."'
		, WO_DESC= '".$this->getField("WO_DESC")."'
		, WORKTYPE= '".$this->getField("WORKTYPE")."'
		, WORK_GROUP= '".$this->getField("WORK_GROUP")."'
		, NEEDDOWNTIME= '".$this->getField("NEEDDOWNTIME")."'
		, REPORTDATE= ".$this->getField("REPORTDATE")."
		, WO_YEAR= ".$this->getField("WO_YEAR")."
		WHERE WONUM = '".$this->getField("WONUM")."' AND SITEID = '".$this->getField("SITEID")."' AND ASSETNUM = '".$this->getField("ASSETNUM")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}


	function updatewostanding()
    {
        $str = "
        UPDATE t_wo_standing_lccm 
        SET
          KODE_BLOK= '".$this->getField("KODE_BLOK")."'
          , GROUP_PM = '".$this->getField("GROUP_PM")."'
          , PM_YEAR= ".$this->getField("PM_YEAR")."
          , COST_PM_YEARLY= ".$this->getField("COST_PM_YEARLY")."
          , LAST_UPDATE_USER=  '".$this->getField("LAST_UPDATE_USER")."'
          , LAST_UPDATE_DATE= '".$this->getField("LAST_UPDATE_DATE")."'
          , KODE_DISTRIK= '".$this->getField("KODE_DISTRIK")."'
          , KODE_UNIT_M= '".$this->getField("KODE_UNIT_M")."'
        WHERE KODE_DISTRIK = '".$this->getField("KODE_DISTRIK")."' AND  KODE_BLOK = '".$this->getField("KODE_BLOK")."' AND  KODE_UNIT_M = '".$this->getField("KODE_UNIT_M")."' AND  GROUP_PM = '".$this->getField("GROUP_PM")."' AND PM_YEAR = '".$this->getField("PM_YEAR")."'
        "; 
        $this->query = $str;
        // echo $str;exit;
        return $this->execQuery($str);
    }

  	function selectByParamsCheckPenggunaEksternal($paramsArray=array(),$limit=-1,$from=-1, $pengguna_externalment='', $sOrder="ORDER BY PENGGUNA_EXTERNAL_ID ASC")
	{
		$str = "
		SELECT 
			A.*
		FROM pengguna_external A
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $pengguna_externalment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

   	function selectByParamsCheckMasterJabatan($paramsArray=array(),$limit=-1,$from=-1, $pengguna_externalment='', $sOrder="ORDER BY POSITION_ID ASC")
	{
		$str = "
		SELECT 
			A.*
		FROM master_jabatan A
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $pengguna_externalment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsCheckRole($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY ROLE_ID ASC")
	{
		$str = "
			SELECT 
				A.*
			FROM ROLE_APPROVAL A 
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

	function insertpenggunaeksternal()
    {
    	$this->setField("PENGGUNA_EXTERNAL_ID", $this->getNextId("PENGGUNA_EXTERNAL_ID","pengguna_external"));

    	$str = "
    	INSERT INTO pengguna_external
    	(
    		PENGGUNA_EXTERNAL_ID,DISTRIK_ID,POSITION_ID,ROLE_ID,PERUSAHAAN_EKSTERNAL_ID, NID, NAMA, STATUS, NO_TELP, EMAIL, FOTO, PASSWORD,EXPIRED_DATE
    	)
    	VALUES 
    	(
	    	".$this->getField("PENGGUNA_EXTERNAL_ID")."
	    	, ".$this->getField("DISTRIK_ID")."
	    	, '".$this->getField("POSITION_ID")."'
	    	, ".$this->getField("ROLE_ID")."
	    	, ".$this->getField("PERUSAHAAN_EKSTERNAL_ID")."
	    	, '".$this->getField("NID")."'
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("STATUS")."'
	    	, ".$this->getField("NO_TELP")."
	    	, '".$this->getField("EMAIL")."'
	    	, '".$this->getField("FOTO")."'
	    	, '".$this->getField("PASSWORD")."'
	    	, ".$this->getField("EXPIRED_DATE")."
	    )"; 

		$this->id= $this->getField("PENGGUNA_EXTERNAL_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function updatepenggunaeksternal()
	{
		$str = "
		UPDATE pengguna_external
		SET
		DISTRIK_ID = ".$this->getField("DISTRIK_ID")."
		, POSITION_ID = '".$this->getField("POSITION_ID")."'
		, ROLE_ID = ".$this->getField("ROLE_ID")."
		, PERUSAHAAN_EKSTERNAL_ID = ".$this->getField("PERUSAHAAN_EKSTERNAL_ID")."
		, NID = '".$this->getField("NID")."'
		, NAMA = '".$this->getField("NAMA")."'
		, STATUS = '".$this->getField("STATUS")."'
		, NO_TELP = ".$this->getField("NO_TELP")."
		, EMAIL = '".$this->getField("EMAIL")."'
		, EXPIRED_DATE = ".$this->getField("EXPIRED_DATE")."
		WHERE PENGGUNA_EXTERNAL_ID = '".$this->getField("PENGGUNA_EXTERNAL_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}


	function selectByParamsCheckAssetLccm($paramsArray=array(),$limit=-1,$from=-1, $distrikment='', $sOrder="")
	{
		$str = "
		SELECT 
			A.*
		FROM m_asset_lccm A
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $distrikment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

    function insertwopm()
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

	function insertwopdm()
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

	function insertloss()
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


	 function insertprk()
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

	function insertopasset()
    {

    	$str = "
    	INSERT INTO t_opr_asset_lccm
    	(
    		SITEID, ASSETNUM, OPR_YEAR, ELECT_LOSS, EFF_LOSS,LAST_CREATE_USER, LAST_CREATE_DATE

    	)
    	VALUES 
    	(
	    	'PT'
	    	, '".$this->getField("ASSETNUM")."'
	    	, ".$this->getField("OPR_YEAR")."
	    	, ".$this->getField("ELECT_LOSS")."
	    	, ".$this->getField("EFF_LOSS")."
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    )"; 

		// $this->id= $this->getField("PENGGUNA_EXTERNAL_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}


	function updateopasset()
	{
		$str = "
		UPDATE t_opr_asset_lccm
		SET
		 ELECT_lOSS=".$this->getField("ELECT_lOSS")."
		, EFF_LOSS=".$this->getField("EFF_LOSS")."
		, LAST_UPDATE_USER='".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE=".$this->getField("LAST_UPDATE_DATE")."
		WHERE OPR_YEAR = '".$this->getField("OPR_YEAR")."'  AND ASSETNUM = '".$this->getField("ASSETNUM")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}


	
    function selectByParamsCheckJenisUnit($paramsArray=array(),$limit=-1,$from=-1, $distrikment='', $sOrder="ORDER BY JENIS_UNIT_KERJA_ID ASC")
	{
		$str = "
		SELECT 
			A.*
		FROM JENIS_UNIT_KERJA A
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $distrikment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }


    function insertohlabor()
    {

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

		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	
	function updateohlabor()
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


	function insertassetlccm()
    {

    	$str = "
    	INSERT INTO m_asset_lccm
    	(
    		KODE_DISTRIK,KODE_BLOK,KODE_UNIT_M,SITEID, ASSETNUM, ASSET_LCCM, PARENT_CHILD, PARENT, GROUP_PM, ASSET_OH, LAST_CREATE_USER, LAST_CREATE_DATE


    	)
    	VALUES 
    	(
    		 '".$this->getField("KODE_DISTRIK")."'
    		, '".$this->getField("KODE_BLOK")."'
	    	, '".$this->getField("KODE_UNIT_M")."'
	    	, '".$this->getField("KODE_BLOK")."'
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
	    	 '".$this->getField("KODE_BLOK")."'
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
		WHERE ASSETNUM = '".$this->getField("ASSETNUM")."' AND KODE_DISTRIK = '".$this->getField("KODE_DISTRIK")."' AND KODE_BLOK = '".$this->getField("KODE_BLOK")."' AND KODE_UNIT_M = '".$this->getField("KODE_UNIT_M")."' AND CAPITAL_DATE = '".$this->getField("CAPITAL_DATE_UP")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function selectByParamsOhLabor($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="")
	{
		$str = "
		SELECT 
		A.*
		FROM m_oh_labour_lccm A 
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
		
		$str .= $statement."  ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsOhType($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="")
	{
		$str = "
		SELECT 
		A.OH_TYPE,A.DESCRIPTION
		FROM m_oh_type_lccm A 
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

    function selectByParamsCheckOhLabor($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="")
	{
		$str = "
		SELECT 
		A.*
		FROM m_oh_labour_lccm A 
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


    function selectByParamsCheckEnergiPrice($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="")
	{
		$str = "
		SELECT 
		A.*
		FROM t_energy_price_lccm A 
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


    function selectByParamsCheckBlok($paramsArray=array(),$limit=-1,$from=-1, $blok_unitment='', $sOrder="ORDER BY BLOK_UNIT_ID ASC")
	{
		$str = "
		SELECT 
			A.*,B.NAMA DISTRIK_NAMA,B.KODE DISTRIK_KODE,
			CASE WHEN A.STATUS = 1 THEN 'Tidak  Aktif' ELSE 'Aktif' END STATUS_INFO
			, C.NAMA EAM_NAMA
		FROM blok_unit A
		INNER JOIN DISTRIK B ON B.DISTRIK_ID = A.DISTRIK_ID
		LEFT JOIN EAM C ON C.EAM_ID = A.EAM_ID
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $blok_unitment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

    function insertenergi()
    {
    	// $this->setField("KODE_UNIT_M", $this->getNextId("KODE_UNIT_M","unit_mesin"));

    	$str = "
    	INSERT INTO t_energy_price_lccm
    	(
    		KODE_BLOK, PRICE_YEAR, ENERGY_PRICE,KODE_DISTRIK,STATUS
    	)
    	VALUES 
    	(
	    	'".$this->getField("KODE_BLOK")."'
	    	, ".$this->getField("PRICE_YEAR")."
	    	, ".$this->getField("ENERGY_PRICE")."
	    	, '".$this->getField("KODE_DISTRIK")."'
	    	, '".$this->getField("STATUS")."'
	    )"; 

		// $this->id= $this->getField("KODE_UNIT_M");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function updateenergi()
	{
		$str = "
		UPDATE t_energy_price_lccm
		SET
		 KODE_BLOK= '".$this->getField("KODE_BLOK")."'
		, ENERGY_PRICE= ".$this->getField("ENERGY_PRICE")."
		, KODE_DISTRIK= '".$this->getField("KODE_DISTRIK")."'
		, PRICE_YEAR= ".$this->getField("PRICE_YEAR")."
		, STATUS= '".$this->getField("STATUS")."'
		WHERE KODE_BLOK = '".$this->getField("KODE_BLOK_OLD")."' AND KODE_DISTRIK = '".$this->getField("KODE_DISTRIK_OLD")."'  AND PRICE_YEAR = '".$this->getField("PRICE_YEAR_OLD")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function selectByParamsCheckEam($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY EAM_ID ASC")
	{
		$str = "
			SELECT 
				A.*,
				CASE WHEN A.STATUS = 1 THEN 'Tidak  Aktif' ELSE 'Aktif' END STATUS_INFO
			FROM EAM A 
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


	function updateblok()
	{
		$str = "
		UPDATE blok_unit
		SET
		 NAMA= '".$this->getField("NAMA")."'
		, DISTRIK_ID= ".$this->getField("DISTRIK_ID")."
		, KODE= '".$this->getField("KODE")."'
		, KODE_EAM= '".$this->getField("KODE_EAM")."'
		, EAM_ID= ".$this->getField("EAM_ID")."
		, URL= '".$this->getField("URL")."'
		WHERE BLOK_UNIT_ID = '".$this->getField("BLOK_UNIT_ID")."'
		"; 
		$this->query = $str;
		// echo $str;
		return $this->execQuery($str);
	}



    function selectByParamsCheckUnitMesin($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY UNIT_MESIN_ID ASC")
	{
		$str = "
		SELECT 
			A.*,B.NAMA DISTRIK_NAMA,C.NAMA UNIT_NAMA
			, CASE WHEN A.STATUS = 1 THEN 'Tidak  Aktif' ELSE 'Aktif' END STATUS_INFO
			, D.NAMA EAM_NAMA
		FROM unit_mesin A
		INNER JOIN DISTRIK B ON B.DISTRIK_ID = A.DISTRIK_ID
		INNER JOIN BLOK_UNIT C ON C.BLOK_UNIT_ID = A.BLOK_UNIT_ID
		LEFT JOIN EAM D ON D.EAM_ID = A.EAM_ID
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

  function selectByParamsCheckGroupPmLccm($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY a.kode_distrik ASC, a.kode_blok ASC, a.kode_unit ASC, a.group_pm ASC")
	{
		$str = "
		SELECT 
			A.*,C.BLOK_UNIT_ID,B.DISTRIK_ID,B.NAMA DISTRIK_INFO,C.NAMA BLOK_INFO,D.NAMA UNIT_INFO
		FROM m_group_pm__lccm A 
		INNER JOIN DISTRIK B ON B.KODE = A.KODE_DISTRIK
		LEFT JOIN BLOK_UNIT C ON C.KODE = A.KODE_BLOK AND C.DISTRIK_ID = B.DISTRIK_ID
		LEFT  JOIN UNIT_MESIN D ON D.KODE = A.KODE_UNIT AND D.BLOK_UNIT_ID = C.BLOK_UNIT_ID AND D.DISTRIK_ID = B.DISTRIK_ID
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

    function selectByParamsCheckWO($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY A.ASSETNUM ASC")
	{
		$str = "
		SELECT A.* 
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

    function selectByParamsCheckOperationAsset($paramsArray=array(),$limit=-1,$from=-1, $distrikment='', $sOrder="ORDER BY OPR_YEAR ASC")
	{
		$str = "
		SELECT 
			A.*
		FROM t_opr_asset_lccm A
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $distrikment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }





  } 
?>