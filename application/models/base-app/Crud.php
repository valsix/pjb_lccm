<? 
include_once(APPPATH.'/models/Entity.php');

class Crud extends Entity { 

	var $query;

    function Crud()
	{
      	$this->Entity(); 
    }

    function insert()
    {
    	$this->setField("PENGGUNA_HAK_ID", $this->getNextId("PENGGUNA_HAK_ID","PENGGUNA_HAK"));

    	$str = "
    	INSERT INTO PENGGUNA_HAK
    	(
    		PENGGUNA_HAK_ID, KODE_HAK, NAMA_HAK, DESKRIPSI
    	)
    	VALUES 
    	(
	    	'".$this->getField("PENGGUNA_HAK_ID")."'
	    	, '".$this->getField("KODE_HAK")."'
	    	, '".$this->getField("NAMA_HAK")."'
	    	, '".$this->getField("DESKRIPSI")."'
	    )"; 

			$this->id= $this->getField("PENGGUNA_HAK_ID");
			$this->query= $str;
			// echo $str;exit;
			return $this->execQuery($str);
	}

	function insertPenggunaCrud()
    {
    	// $this->setField("PENGGUNA_HAK_ID", $this->getNextId("PENGGUNA_HAK_ID","PENGGUNA_HAK"));

    	$str = "
    	INSERT INTO PENGGUNA_CRUD
    	(
    		PENGGUNA_HAK_ID, KODE_HAK, kode_modul, menu, modul_c, modul_anak_c
    		, modul_r, modul_anak_r, modul_u, modul_anak_u, modul_d, modul_anak_d
    	)
    	VALUES 
    	(
	    	'".$this->getField("PENGGUNA_HAK_ID")."'
	    	, '".$this->getField("KODE_HAK")."'
	    	, '".$this->getField("kode_modul")."'
	    	, '".$this->getField("menu")."'
	    	, '".$this->getField("modul_c")."'
	    	, '".$this->getField("modul_anak_c")."'
	    	, '".$this->getField("modul_r")."'
	    	, '".$this->getField("modul_anak_r")."'
	    	, '".$this->getField("modul_u")."'
	    	, '".$this->getField("modul_anak_u")."'
	    	, '".$this->getField("modul_d")."'
	    	, '".$this->getField("modul_anak_d")."'
	    )"; 

			$this->id= $this->getField("PENGGUNA_HAK_ID");
			$this->query= $str;
			// echo $str;exit;
			return $this->execQuery($str);
	}

	function insertjabatan()
    {
    	$this->setField("PENGGUNA_HAK_JABATAN_ID", $this->getNextId("PENGGUNA_HAK_JABATAN_ID","PENGGUNA_HAK_JABATAN"));

    	$str = "
    	INSERT INTO PENGGUNA_HAK_JABATAN
    	(
    		PENGGUNA_HAK_JABATAN_ID, PENGGUNA_HAK_ID, POSITION_ID
    	)
    	VALUES 
    	(
	    	'".$this->getField("PENGGUNA_HAK_JABATAN_ID")."'
	    	, '".$this->getField("PENGGUNA_HAK_ID")."'
	    	, '".$this->getField("POSITION_ID")."'
	    )"; 

	    $this->id= $this->getField("PENGGUNA_HAK_JABATAN_ID");
	    $this->query= $str;
	    return $this->execQuery($str);
	}

	function inserthakakses()
    {
    	$this->setField("PENGGUNA_HAK_AKSES_ID", $this->getNextId("PENGGUNA_HAK_AKSES_ID","PENGGUNA_HAK_AKSES"));

    	$str = "
    	INSERT INTO PENGGUNA_HAK_AKSES
    	(
    		PENGGUNA_HAK_AKSES_ID, PENGGUNA_ID, PENGGUNA_HAK_ID
    	)
    	VALUES 
    	(
	    	'".$this->getField("PENGGUNA_HAK_AKSES_ID")."'
	    	, '".$this->getField("PENGGUNA_ID")."'
	    	, '".$this->getField("PENGGUNA_HAK_ID")."'
	    )"; 

	    $this->id= $this->getField("PENGGUNA_HAK_AKSES_ID");
	    $this->query= $str;
	    // echo $str;exit;
	    return $this->execQuery($str);
	}

	function insertPenggunaHakDistrik()
    {
    	$this->setField("PENGGUNA_HAK_DISTRIK_ID", $this->getNextId("PENGGUNA_HAK_DISTRIK_ID","PENGGUNA_HAK_DISTRIK"));

    	$str = "
    	INSERT INTO PENGGUNA_HAK_DISTRIK
    	(
    		PENGGUNA_HAK_DISTRIK_ID, PENGGUNA_HAK_ID, DISTRIK_ID,STATUS_ALL
    	)
    	VALUES 
    	(
	    	'".$this->getField("PENGGUNA_HAK_DISTRIK_ID")."'
	    	, '".$this->getField("PENGGUNA_HAK_ID")."'
	    	, '".$this->getField("DISTRIK_ID")."'
	    	, ".$this->getField("STATUS_ALL")."
	    )"; 

	    $this->id= $this->getField("PENGGUNA_HAK_DISTRIK_ID");
	    $this->query= $str;
		// echo $str;
	    return $this->execQuery($str);
	}

	function update()
	{
			$str = "
			UPDATE PENGGUNA_HAK
			SET
			KODE_HAK= '".$this->getField("KODE_HAK")."'
			, NAMA_HAK= '".$this->getField("NAMA_HAK")."'
			, DESKRIPSI= '".$this->getField("DESKRIPSI")."'
			WHERE PENGGUNA_HAK_ID = '".$this->getField("PENGGUNA_HAK_ID")."'
			"; 
			$this->query = $str;
			// echo $str;exit;
			return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM PENGGUNA_HAK
		WHERE 
		PENGGUNA_HAK_ID = ".$this->getField("PENGGUNA_HAK_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function deletejabatan()
	{
		$str = "
		DELETE FROM PENGGUNA_HAK_JABATAN
		WHERE 
		PENGGUNA_HAK_ID = ".$this->getField("PENGGUNA_HAK_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function deletejabatandetil()
	{
		$str = "
		DELETE FROM PENGGUNA_HAK_JABATAN
		WHERE 
		PENGGUNA_HAK_JABATAN_ID = ".$this->getField("PENGGUNA_HAK_JABATAN_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function deletePenggunaHakAkses()
	{
		$str = "
		DELETE FROM PENGGUNA_HAK_AKSES
		WHERE 
		PENGGUNA_ID = '".$this->getField("PENGGUNA_ID")."' AND PENGGUNA_HAK_ID = '".$this->getField("PENGGUNA_HAK_ID")."' "; 

		// echo $str;exit();
		$this->query = $str;
		return $this->execQuery($str);
	}

	function deletePenggunaCrud()
	{
		$str = "
		DELETE FROM PENGGUNA_CRUD
		WHERE 
		KODE_HAK = '".$this->getField("KODE_HAK")."'"; 

		// echo $str;exit();
		$this->query = $str;
		return $this->execQuery($str);
	}

	function deletePenggunaHakDistrik()
	{
		$str = "
		DELETE FROM PENGGUNA_HAK_DISTRIK
		WHERE 
		PENGGUNA_HAK_ID = '".$this->getField("PENGGUNA_HAK_ID")."'"; 

		// echo $str;exit();
		$this->query = $str;
		return $this->execQuery($str);
	}

	function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY PENGGUNA_HAK_ID ASC")
	{
		$str = "
			SELECT 
				A.*
				, F.DISTRIK_ID_INFO
				, F.DISTRIK_NAMA_INFO
				, F.STATUS_ALL_INFO
			FROM PENGGUNA_HAK A 
			LEFT JOIN 
			(
				SELECT B.PENGGUNA_HAK_ID
				,STRING_AGG(A.DISTRIK_ID::text, ', ') AS DISTRIK_ID_INFO
				,STRING_AGG(B.STATUS_ALL::text, ', ') AS STATUS_ALL_INFO
				,STRING_AGG(A.NAMA, ', ') AS DISTRIK_NAMA_INFO 
				FROM DISTRIK A
				LEFT JOIN PENGGUNA_HAK_DISTRIK B ON B.DISTRIK_ID = A.DISTRIK_ID 
				GROUP BY B.PENGGUNA_HAK_ID
			) F ON F.PENGGUNA_HAK_ID = A.PENGGUNA_HAK_ID
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

	function selectByParamsJabatan($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY PENGGUNA_HAK_JABATAN_ID ASC")
	{
		$str = "
			SELECT 
				A.*,B.NAMA_POSISI
			FROM PENGGUNA_HAK_JABATAN A
			LEFT JOIN MASTER_JABATAN B ON B.POSITION_ID = A.POSITION_ID
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

	function selectByParamsInternal($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="")
	{
		$str = "
		SELECT A.PENGGUNA_INTERNAL_ID,A.NID,A.NAMA_LENGKAP,A.POSITION_ID,B.PENGGUNA_ID 
		FROM PENGGUNA_INTERNAL A
		INNER JOIN PENGGUNA B ON B.PENGGUNA_INTERNAL_ID = A.PENGGUNA_INTERNAL_ID
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

	function selectByParamsHakAkses($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="")
	{
		$str = "
		SELECT *
				FROM PENGGUNA_HAK_AKSES a
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

	function selectByParamsMenus($paramsArray=array(),$limit=-1,$from=-1, $statement='', $kodeHak='', $sOrder="ORDER BY idpath ASC")
	{
		$str = "
			with recursive cte as 
			(
				select
				b.kode_modul, b.level_modul, b.menu_modul, b.order_modul
				, b.kode_modul id, lpad(b.kode_modul::varchar(12),12,'0')::varchar(144) as idpath, 1::int as depth
				, b.group_modul, a.menu, a.modul_c, a.modul_anak_c, a.modul_r, a.modul_anak_r, a.modul_u, a.modul_anak_u
				, a.modul_d, a.modul_anak_d,b.status_sub_appr
				FROM pengguna_modul b
				LEFT JOIN (SELECT * FROM pengguna_crud WHERE kode_hak = '".$kodeHak."') a ON a.kode_modul = b.kode_modul
				WHERE 1=1 and b.level_modul = '0'
				
				union all
				
				select
				a.kode_modul, a.level_modul, a.menu_modul, a.order_modul
				, a.kode_modul id, concat(idpath, lpad(a.kode_modul::varchar(12),12,'0'))::varchar(144) idpath, depth + 1::int as depth
				, a.group_modul, a.menu, a.modul_c, a.modul_anak_c, a.modul_r, a.modul_anak_r, a.modul_u, a.modul_anak_u
				, a.modul_d, a.modul_anak_d,a.status_sub_appr
				from cte r
				join
				(
					select
					b.kode_modul, b.level_modul, b.menu_modul, b.order_modul
					, b.group_modul, a.menu, a.modul_c, a.modul_anak_c, a.modul_r, a.modul_anak_r, a.modul_u, a.modul_anak_u
					, a.modul_d, a.modul_anak_d,b.status_sub_appr
					FROM pengguna_modul b
					LEFT JOIN (SELECT * FROM pengguna_crud WHERE kode_hak = '".$kodeHak."') a ON a.kode_modul = b.kode_modul
					WHERE 1=1
				)
				a on a.level_modul = r.id
			)
			select * from cte
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



	function selectByParamsCrudHak($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY PENGGUNA_HAK_ID ASC")
	{
		$str = "
			SELECT 
				A.*,B.MENU
			FROM PENGGUNA_HAK A 
			INNER JOIN PENGGUNA_CRUD B ON B.PENGGUNA_HAK_ID = A.PENGGUNA_HAK_ID
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

	function selectByParamsPengguna($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="")
	{
		$str = "
		SELECT A.* 
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