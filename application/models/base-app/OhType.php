<? 
  include_once(APPPATH.'/models/Entity.php');

  class OhType extends Entity{ 

	var $query;

    function OhType()
	{
      $this->Entity(); 
    }

    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="")
	{
		$str = "
		SELECT 
		A.OH_TYPE
		FROM m_oh_cost_lccm A 
		INNER JOIN M_ASSET_LCCM B ON B.ASSETNUM = A.ASSETNUM
		WHERE 1=1
		
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY A.OH_TYPE  ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

     function selectByParamsAll($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="")
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


  } 
?>