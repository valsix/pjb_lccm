<? 
  include_once(APPPATH.'/models/Entity.php');

  class Generate extends Entity{ 

	var $query;

    function Generate()
	{
      $this->Entity(); 
    }

    function insertJabatan()
  	{
	    $str = "
	    INSERT INTO MASTER_JABATAN
	    (
	        POSITION_ID, NAMA_POSISI, SUPERIOR_ID, KODE_KATEGORI, KATEGORI, KODE_KELOMPOK_JABATAN, KELOMPOK_JABATAN
	        , KODE_JENJANG_JABATAN, JENJANG_JABATAN, KODE_KLASIFIKASI_UNIT, KLASIFIKASI_UNIT, KODE_UNIT, UNIT, KODE_DITBID, DITBID, KODE_BAGIAN, BAGIAN,OCCUP_STATUS,NAMA_LENGKAP,EMAIL,NID,POSISI,CHANGE_REASON,TIPE
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
	      , '".$this->getField("TIPE")."'
	    )"; 
	    $this->query= $str;
	    return $this->execQuery($str);
  	}

	function updateJabatan()
	{
	    $str = "
	    UPDATE MASTER_JABATAN 
	    SET
	      NAMA_POSISI= '".$this->getField("NAMA_POSISI")."'
	      , SUPERIOR_ID= '".$this->getField("SUPERIOR_ID")."'
	      , KODE_KATEGORI= '".$this->getField("KODE_KATEGORI")."'
	      , KATEGORI= '".$this->getField("KATEGORI")."'
	      , KODE_KELOMPOK_JABATAN= '".$this->getField("KODE_KELOMPOK_JABATAN")."'
	      , KELOMPOK_JABATAN= '".$this->getField("KELOMPOK_JABATAN")."'
	      , KODE_JENJANG_JABATAN= '".$this->getField("KODE_JENJANG_JABATAN")."'
	      , JENJANG_JABATAN= '".$this->getField("JENJANG_JABATAN")."'
	      , KODE_KLASIFIKASI_UNIT= '".$this->getField("KODE_KLASIFIKASI_UNIT")."'
	      , KLASIFIKASI_UNIT= '".$this->getField("KLASIFIKASI_UNIT")."'
	      , KODE_UNIT= '".$this->getField("KODE_UNIT")."'
	      , UNIT= '".$this->getField("UNIT")."'
	      , KODE_DITBID= '".$this->getField("KODE_DITBID")."'
	      , DITBID= '".$this->getField("DITBID")."'
	      , KODE_BAGIAN= '".$this->getField("KODE_BAGIAN")."'
	      , BAGIAN= '".$this->getField("BAGIAN")."'
	      , OCCUP_STATUS= '".$this->getField("OCCUP_STATUS")."'
	      , NAMA_LENGKAP= '".$this->getField("NAMA_LENGKAP")."'
	      , EMAIL= '".$this->getField("EMAIL")."'
	      , NID= '".$this->getField("NID")."'
	      , POSISI= '".$this->getField("POSISI")."'
	      , CHANGE_REASON= '".$this->getField("CHANGE_REASON")."'
	      , TIPE= '".$this->getField("TIPE")."'
	    WHERE POSITION_ID = '".$this->getField("POSITION_ID")."'
	    "; 
	    $this->query = $str;
	    // echo $str;exit;
	    return $this->execQuery($str);
	}

	function insertUserInternal()
  	{
  		$this->setField("PENGGUNA_INTERNAL_ID", $this->getNextId("PENGGUNA_INTERNAL_ID","pengguna_internal"));
	    $str = "
	    INSERT INTO PENGGUNA_INTERNAL(
            PENGGUNA_INTERNAL_ID, NID, NAMA_LENGKAP, EMAIL, OCCUP_STATUS, KODE_BAGIAN, BAGIAN, 
            KODE_DITBID, DITBID, KODE_UNIT, UNIT, KODE_KLASIFIKASI_UNIT, 
            KLASIFIKASI_UNIT, POSITION_ID, NAMA_POSISI
        )
	    VALUES 
	    (
	    	'".$this->getField("PENGGUNA_INTERNAL_ID")."'
	      ,	'".$this->getField("NID")."'
	      , '".$this->getField("NAMA_LENGKAP")."'
	      , '".$this->getField("EMAIL")."'
	      , '".$this->getField("OCCUP_STATUS")."'
	      , '".$this->getField("KODE_BAGIAN")."'
	      , '".$this->getField("BAGIAN")."'
	      , '".$this->getField("KODE_DITBID")."'
	      , '".$this->getField("DITBID")."'
	      , '".$this->getField("KODE_UNIT")."'
	      , '".$this->getField("UNIT")."'
	      , '".$this->getField("KODE_KLASIFIKASI_UNIT")."'
	      , '".$this->getField("KLASIFIKASI_UNIT")."'
	      , '".$this->getField("POSITION_ID")."'
	      , '".$this->getField("NAMA_POSISI")."'
	  
	    )"; 
	    $this->query= $str;
	    return $this->execQuery($str);
  	}


	function insertUserInternalPengguna()
  	{
  		$this->setField("PENGGUNA_ID", $this->getNextId("PENGGUNA_ID","pengguna"));
	    $str = "
	    INSERT INTO PENGGUNA(
            PENGGUNA_ID, NID, USERNAME, NAMA_LENGKAP, EMAIL, OCCUP_STATUS, KODE_BAGIAN, BAGIAN, 
            KODE_DITBID, DITBID, KODE_UNIT, UNIT, KODE_KLASIFIKASI_UNIT, 
            KLASIFIKASI_UNIT, POSITION_ID, NAMA_POSISI,KODE_DISTRIK,KODE_BLOK,KODE_UNIT_M,NAMA
        )
	    VALUES 
	    (
	    	'".$this->getField("PENGGUNA_ID")."'
	      ,	'".$this->getField("NID")."'
	      ,	'".$this->getField("USERNAME")."'
	      , '".$this->getField("NAMA_LENGKAP")."'
	      , '".$this->getField("EMAIL")."'
	      , '".$this->getField("OCCUP_STATUS")."'
	      , '".$this->getField("KODE_BAGIAN")."'
	      , '".$this->getField("BAGIAN")."'
	      , '".$this->getField("KODE_DITBID")."'
	      , '".$this->getField("DITBID")."'
	      , '".$this->getField("KODE_UNIT")."'
	      , '".$this->getField("UNIT")."'
	      , '".$this->getField("KODE_KLASIFIKASI_UNIT")."'
	      , '".$this->getField("KLASIFIKASI_UNIT")."'
	      , '".$this->getField("POSITION_ID")."'
	      , '".$this->getField("NAMA_POSISI")."'
	      , '".$this->getField("KODE_DISTRIK")."'
	      , '".$this->getField("KODE_UNIT")."'
	      , '".$this->getField("KODE_SUBDIT")."'
	      , '".$this->getField("NAMA")."'
	      , '1'
	  
	    )"; 
	    $this->query= $str;
	    	    // echo $str;exit;

	    return $this->execQuery($str);
  	}

	function updateUserInternal()
	{
	    $str = "
	    UPDATE PENGGUNA_INTERNAL 
	    SET
	      NAMA_LENGKAP= '".$this->getField("NAMA_LENGKAP")."'
	      , EMAIL= '".$this->getField("EMAIL")."'
	      , OCCUP_STATUS= '".$this->getField("OCCUP_STATUS")."'
	      , KODE_BAGIAN= '".$this->getField("KODE_BAGIAN")."'
	      , BAGIAN= '".$this->getField("BAGIAN")."'
	      , KODE_DITBID= '".$this->getField("KODE_DITBID")."'
	      , DITBID= '".$this->getField("DITBID")."'
	      , KODE_UNIT= '".$this->getField("KODE_UNIT")."'
	      , UNIT= '".$this->getField("UNIT")."'
	      , KODE_KLASIFIKASI_UNIT= '".$this->getField("KODE_KLASIFIKASI_UNIT")."'
	      , KLASIFIKASI_UNIT= '".$this->getField("KLASIFIKASI_UNIT")."'
	      , POSITION_ID= '".$this->getField("POSITION_ID")."'
	      , NAMA_POSISI= '".$this->getField("NAMA_POSISI")."'
	    WHERE PENGGUNA_INTERNAL_ID = '".$this->getField("PENGGUNA_INTERNAL_ID")."'
	    "; 
	    $this->query = $str;
	    // echo $str;exit;
	    return $this->execQuery($str);
	}

	function updateUserInternalPengguna()
	{
	    $str = "
	    UPDATE PENGGUNA 
	    SET
	      NAMA_LENGKAP= '".$this->getField("NAMA_LENGKAP")."'
	      , EMAIL= '".$this->getField("EMAIL")."'
	      , OCCUP_STATUS= '".$this->getField("OCCUP_STATUS")."'
	      , KODE_BAGIAN= '".$this->getField("KODE_BAGIAN")."'
	      , BAGIAN= '".$this->getField("BAGIAN")."'
	      , KODE_DITBID= '".$this->getField("KODE_DITBID")."'
	      , DITBID= '".$this->getField("DITBID")."'
	      , KODE_UNIT= '".$this->getField("KODE_UNIT")."'
	      , UNIT= '".$this->getField("UNIT")."'
	      , KODE_KLASIFIKASI_UNIT= '".$this->getField("KODE_KLASIFIKASI_UNIT")."'
	      , KLASIFIKASI_UNIT= '".$this->getField("KLASIFIKASI_UNIT")."'
	      , POSITION_ID= '".$this->getField("POSITION_ID")."'
	      , NAMA_POSISI= '".$this->getField("NAMA_POSISI")."'
	      , KODE_DISTRIK= '".$this->getField("KODE_DISTRIK")."'
	      , KODE_BLOK= '".$this->getField("KODE_UNIT")."'
	      , KODE_UNIT_M= '".$this->getField("KODE_SUBDIT")."'
	      , NAMA= '".$this->getField("NAMA")."'
	      , TIPE= '1'
	    WHERE PENGGUNA_ID = '".$this->getField("PENGGUNA_ID")."'
	    "; 
	    $this->query = $str;
	    // echo $str;exit;
	    return $this->execQuery($str);
	}

    function selectByParamsCheckJabatan($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="")
    {
    	$str = "
    	SELECT
    	A.*
    	FROM MASTER_JABATAN A
    	WHERE 1=1 "; 

    	while(list($key,$val) = each($paramsArray))
    	{
    		$str .= " AND $key = '$val' ";
    	}

    	$str .= $statement." ".$sOrder;
    	$this->query = $str;

    	return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsCheckUserInternal($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="")
    {
    	$str = "
    	SELECT
    	A.*
    	FROM PENGGUNA_INTERNAL A
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

    function selectByParamsCheckPengguna($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="")
    {
    	$str = "
    	SELECT
    	A.*
    	FROM PENGGUNA A
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