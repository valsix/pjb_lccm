<? 
  include_once(APPPATH.'/models/Entity.php');

  class PerusahaanEksternal extends Entity{ 

	var $query;

    function PerusahaanEksternal()
	{
      $this->Entity(); 
    }

    function insert()
    {
    	$this->setField("PERUSAHAAN_EKSTERNAL_ID", $this->getNextId("PERUSAHAAN_EKSTERNAL_ID","perusahaan_eksternal"));

    	$str = "
    	INSERT INTO perusahaan_eksternal
    	(
    		PERUSAHAAN_EKSTERNAL_ID, NAMA, KODE,LAST_CREATE_USER,LAST_CREATE_DATE
    	)
    	VALUES 
    	(
	    	'".$this->getField("PERUSAHAAN_EKSTERNAL_ID")."'
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("KODE")."'
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    )"; 

		$this->id= $this->getField("PERUSAHAAN_EKSTERNAL_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function insertdirektorat()
    {
    	$this->setField("PERUSAHAAN_EKSTERNAL_DIREKTORAT_ID", $this->getNextId("PERUSAHAAN_EKSTERNAL_DIREKTORAT_ID","PERUSAHAAN_EKSTERNAL_DIREKTORAT"));

    	$str = "
    	INSERT INTO PERUSAHAAN_EKSTERNAL_DIREKTORAT
    	(
    		PERUSAHAAN_EKSTERNAL_DIREKTORAT_ID, PERUSAHAAN_EKSTERNAL_ID, DIREKTORAT_ID
    	)
    	VALUES 
    	(
	    	".$this->getField("PERUSAHAAN_EKSTERNAL_DIREKTORAT_ID")."
	    	,".$this->getField("PERUSAHAAN_EKSTERNAL_ID")."
	    	, ".$this->getField("DIREKTORAT_ID")."
	    )"; 

		$this->id= $this->getField("PERUSAHAAN_EKSTERNAL_DIREKTORAT_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function update()
	{
		$str = "
		UPDATE perusahaan_eksternal
		SET
		NAMA= '".$this->getField("NAMA")."'
		, KODE= '".$this->getField("KODE")."'
		, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE= ".$this->getField("LAST_UPDATE_DATE")."
		WHERE PERUSAHAAN_EKSTERNAL_ID = '".$this->getField("PERUSAHAAN_EKSTERNAL_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function updatedirektorat()
	{
		$str = "
		UPDATE PERUSAHAAN_EKSTERNAL_DIREKTORAT
		SET
		DIREKTORAT_ID= ".$this->getField("DIREKTORAT_ID")."
		WHERE PERUSAHAAN_EKSTERNAL_DIREKTORAT_ID = ".$this->getField("PERUSAHAAN_EKSTERNAL_DIREKTORAT_ID")."
		AND PERUSAHAAN_EKSTERNAL_ID = ".$this->getField("PERUSAHAAN_EKSTERNAL_ID")."
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}


	function update_status()
	{
		$str = "
		UPDATE perusahaan_eksternal
		SET
		STATUS = ".$this->getField("STATUS")."
		WHERE PERUSAHAAN_EKSTERNAL_ID = '".$this->getField("PERUSAHAAN_EKSTERNAL_ID")."'
		"; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM perusahaan_eksternal
		WHERE 
		PERUSAHAAN_EKSTERNAL_ID = ".$this->getField("PERUSAHAAN_EKSTERNAL_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}


	function deleteall()
	{
		$str = "
		DELETE FROM perusahaan_eksternal
		WHERE 
		PERUSAHAAN_EKSTERNAL_ID = ".$this->getField("PERUSAHAAN_EKSTERNAL_ID").";";


		$this->query = $str;
		return $this->execQuery($str);
	}

	function deletedirektorat()
	{
		$str = "
		DELETE FROM PERUSAHAAN_EKSTERNAL_DIREKTORAT
		WHERE 
		PERUSAHAAN_EKSTERNAL_ID = ".$this->getField("PERUSAHAAN_EKSTERNAL_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $perusahaan_eksternalment='', $sOrder="ORDER BY PERUSAHAAN_EKSTERNAL_ID ASC")
	{
		$str = "
		SELECT 
			A.*
			,CASE WHEN A.STATUS = 1 THEN 'Tidak  Aktif' ELSE 'Aktif' END STATUS_INFO
		FROM perusahaan_eksternal A 
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $perusahaan_eksternalment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }


    function selectByParamsDirektorat($paramsArray=array(),$limit=-1,$from=-1, $perusahaan_eksternalment='', $sOrder="ORDER BY PERUSAHAAN_EKSTERNAL_ID ASC")
	{
		$str = "
		SELECT A.*
		FROM PERUSAHAAN_EKSTERNAL A
		
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $perusahaan_eksternalment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsDirektoratDetil($paramsArray=array(),$limit=-1,$from=-1, $perusahaan_eksternalment='', $sOrder="ORDER BY PERUSAHAAN_EKSTERNAL_DIREKTORAT_ID ASC")
	{
		$str = "
		SELECT A.*
		FROM PERUSAHAAN_EKSTERNAL_DIREKTORAT A
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $perusahaan_eksternalment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

  } 
?>