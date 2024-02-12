<? 
  include_once(APPPATH.'/models/Entity.php');

  class T_Energy_Price_Lccm extends Entity{ 

	var $query;

    function T_Energy_Price_Lccm()
	{
      $this->Entity(); 
    }

    function insert()
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

	function update()
	{
		$str = "
		UPDATE t_energy_price_lccm
		SET
		 KODE_BLOK= '".$this->getField("KODE_BLOK")."'
		, ENERGY_PRICE= ".$this->getField("ENERGY_PRICE")."
		, KODE_DISTRIK= '".$this->getField("KODE_DISTRIK")."'
		, PRICE_YEAR= ".$this->getField("PRICE_YEAR")."
		, STATUS= '".$this->getField("STATUS")."'
		WHERE PRICE_YEAR = '".$this->getField("PRICE_YEAR")."' AND KODE_BLOK = '".$this->getField("KODE_BLOK")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

   	function deletetahunkodeblok()
	{
		$str = "
		DELETE FROM t_energy_price_lccm
		WHERE 1=1
		".$this->getField("STATEMENT");

		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM t_energy_price_lccm
		WHERE 
		PRICE_YEAR = ".$this->getField("PRICE_YEAR").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}


    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY PRICE_YEAR ASC")
	{
		$str = "
		SELECT 
			A.*,B.NAMA DISTRIK_INFO,C.NAMA BLOK_INFO,CASE WHEN A.STATUS = '1' THEN 'Valid' WHEN A.STATUS = '2' THEN 'Tidak Valid' ELSE 'Belum Diisi' END STATUS_INFO
		FROM t_energy_price_lccm A 
		LEFT JOIN DISTRIK B ON B.KODE = A.KODE_DISTRIK
		LEFT JOIN BLOK_UNIT C ON C.KODE = A.KODE_BLOK AND C.DISTRIK_ID = B.DISTRIK_ID

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

     function selectByParamsTahun($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY PRICE_YEAR ASC")
     {
		$str = "
		SELECT 
			A.PRICE_YEAR 
		FROM t_energy_price_lccm A 
		
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY A.PRICE_YEAR ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

    

  } 
?>