<? 
include_once(APPPATH.'/models/Entity.php');

class Pengguna extends Entity { 

	var $query;

    function Pengguna()
	{
      	$this->Entity(); 
    }

    function insert()
    {
    	$this->setField("PENGGUNA_ID", $this->getNextId("PENGGUNA_ID","PENGGUNA"));

    	$str = "
    	INSERT INTO PENGGUNA
    	(
    		PENGGUNA_ID, USERNAME, PASS, NAMA, STATUS, PERUSAHAAN_ID, ROLE_ID,TIPE,NID,NO_TELP,EMAIL,DISTRIK_ID,POSITION_ID,EXPIRED_DATE,PERUSAHAAN_EKSTERNAL_ID
    	)
    	VALUES 
    	(
	    	'".$this->getField("PENGGUNA_ID")."'
	    	, '".$this->getField("USERNAME")."'
	    	, '".$this->getField("PASS")."'
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("STATUS")."'
	    	, '".$this->getField("PERUSAHAAN_ID")."'
	    	, ".$this->getField("ROLE_ID")."
	    	, '".$this->getField("TIPE")."'
	    	, '".$this->getField("NID")."'
	    	, ".$this->getField("NO_TELP")."
	    	, '".$this->getField("EMAIL")."'
	    	, ".$this->getField("DISTRIK_ID")."
	    	, '".$this->getField("POSITION_ID")."'
	    	, ".$this->getField("EXPIRED_DATE")."
	    	, ".$this->getField("PERUSAHAAN_EKSTERNAL_ID")."

	    )"; 

		$this->id= $this->getField("PENGGUNA_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}



	function update()
	{
		$str = "
		UPDATE PENGGUNA
		SET
		USERNAME= '".$this->getField("USERNAME")."'
		, NAMA= '".$this->getField("NAMA")."'
		, STATUS= '".$this->getField("STATUS")."'
		, PERUSAHAAN_ID= '".$this->getField("PERUSAHAAN_ID")."'
		, ROLE_ID= ".$this->getField("ROLE_ID")."
		, TIPE= '".$this->getField("TIPE")."'
		, PASS= '".$this->getField("PASS")."'

		WHERE PENGGUNA_ID = '".$this->getField("PENGGUNA_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function updateupload($field)
	{
		$str = "
		UPDATE PENGGUNA
		SET
		FOTO = '".$this->getField("FOTO")."'
		WHERE PENGGUNA_ID = '".$this->getField("PENGGUNA_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}


	function updatenonpass()
	{
		$str = "
		UPDATE PENGGUNA
		SET
		USERNAME= '".$this->getField("USERNAME")."'
		, NAMA= '".$this->getField("NAMA")."'
		, PERUSAHAAN_ID= '".$this->getField("PERUSAHAAN_ID")."'
		, ROLE_ID= ".$this->getField("ROLE_ID")."
		, TIPE= '".$this->getField("TIPE")."'
		, DISTRIK_ID = ".$this->getField("DISTRIK_ID")."
		, POSITION_ID = '".$this->getField("POSITION_ID")."'
		, PERUSAHAAN_EKSTERNAL_ID = ".$this->getField("PERUSAHAAN_EKSTERNAL_ID")."
		, NID = '".$this->getField("NID")."'
		, STATUS = '".$this->getField("STATUS")."'
		, NO_TELP = ".$this->getField("NO_TELP")."
		, EMAIL = '".$this->getField("EMAIL")."'
		, EXPIRED_DATE = ".$this->getField("EXPIRED_DATE")."

		WHERE PENGGUNA_ID = '".$this->getField("PENGGUNA_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}


	function reset_password()
	{
		$str = "
		UPDATE pengguna
		SET
		 PASS = '".$this->getField("PASS")."'
		WHERE PENGGUNA_ID = '".$this->getField("PENGGUNA_ID")."';
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM PENGGUNA
		WHERE 
		PENGGUNA_ID = ".$this->getField("PENGGUNA_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function delete_gambar()
	{
		$str = "
		UPDATE PENGGUNA
		SET
		FOTO = ''
		WHERE PENGGUNA_ID = '".$this->getField("PENGGUNA_ID")."'
		"; 
		$this->query = $str;
		return $this->execQuery($str);
	}

	function insertPenggunaHakAkses()
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

	function deletePenggunaHakAkses()
	{
		$str = "
		DELETE FROM PENGGUNA_HAK_AKSES
		WHERE 
		PENGGUNA_ID = '".$this->getField("PENGGUNA_ID")."'"; 

		// echo $str;exit();
		$this->query = $str;
		return $this->execQuery($str);
	}

	function insertPenggunaDistrik()
    {
    	$this->setField("PENGGUNA_DISTRIK_ID", $this->getNextId("PENGGUNA_DISTRIK_ID","PENGGUNA_DISTRIK"));

    	$str = "
    	INSERT INTO PENGGUNA_DISTRIK
    	(
    		PENGGUNA_DISTRIK_ID, PENGGUNA_ID, DISTRIK_ID,STATUS_ALL
    	)
    	VALUES 
    	(
	    	'".$this->getField("PENGGUNA_DISTRIK_ID")."'
	    	, '".$this->getField("PENGGUNA_ID")."'
	    	, '".$this->getField("DISTRIK_ID")."'
	    	, ".$this->getField("STATUS_ALL")."
	    )"; 

	    $this->id= $this->getField("PENGGUNA_DISTRIK_ID");
	    $this->query= $str;
		// echo $str;
	    return $this->execQuery($str);
	}

	function deletePenggunaDistrik()
	{
		$str = "
		DELETE FROM PENGGUNA_DISTRIK
		WHERE 
		PENGGUNA_ID = '".$this->getField("PENGGUNA_ID")."'"; 

		// echo $str;exit();
		$this->query = $str;
		return $this->execQuery($str);
	}

	function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY PENGGUNA_ID ASC")
	{
		$str = "
			SELECT 
				A.*
				, B.PENGGUNA_HAK_NAMA_INFO
				, B.PENGGUNA_HAK_ID_INFO
				, C.NAMA_POSISI JABATAN_INFO
				, CASE WHEN A.TIPE = '1'
				THEN 'Internal'
				WHEN A.TIPE = '2'
				THEN 'Eksternal'
				END TIPE_INFO
				
			FROM PENGGUNA A
			LEFT JOIN 
			(
				SELECT B.PENGGUNA_ID
				,STRING_AGG(A.PENGGUNA_HAK_ID::text, ', ') AS PENGGUNA_HAK_ID_INFO
				,STRING_AGG(A.NAMA_HAK, ', ') AS PENGGUNA_HAK_NAMA_INFO 
				FROM PENGGUNA_HAK A
				INNER JOIN PENGGUNA_HAK_AKSES B ON B.PENGGUNA_HAK_ID = A.PENGGUNA_HAK_ID 
				GROUP BY B.PENGGUNA_ID
			) B ON B.PENGGUNA_ID = A.PENGGUNA_ID
			LEFT JOIN MASTER_JABATAN C ON C.POSITION_ID = A.POSITION_ID
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
				, a.modul_d, a.modul_anak_d
				FROM pengguna_modul b
				LEFT JOIN (SELECT * FROM pengguna_crud WHERE kode_hak = '".$kodeHak."') a ON a.kode_modul = b.kode_modul
				WHERE 1=1 and b.level_modul = '0'
				
				union all
				
				select
				a.kode_modul, a.level_modul, a.menu_modul, a.order_modul
				, a.kode_modul id, concat(idpath, lpad(a.kode_modul::varchar(12),12,'0'))::varchar(144) idpath, depth + 1::int as depth
				, a.group_modul, a.menu, a.modul_c, a.modul_anak_c, a.modul_r, a.modul_anak_r, a.modul_u, a.modul_anak_u
				, a.modul_d, a.modul_anak_d
				from cte r
				join
				(
					select
					b.kode_modul, b.level_modul, b.menu_modul, b.order_modul
					, b.group_modul, a.menu, a.modul_c, a.modul_anak_c, a.modul_r, a.modul_anak_r, a.modul_u, a.modul_anak_u
					, a.modul_d, a.modul_anak_d
					FROM pengguna_modul b
					LEFT JOIN (SELECT * FROM pengguna_crud WHERE kode_hak = '".$kodeHak."') a ON a.kode_modul = b.kode_modul
					WHERE 1=1
				)
				a on a.level_modul = r.id
			)
			select * from cte
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
	}

	function selectByParamsCombo($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY PENGGUNA_ID ASC")
	{
		$str = "
			SELECT 
				A.*,B.ROLE_NAMA
			FROM PENGGUNA A
			INNER JOIN ROLE_APPROVAL B ON B.ROLE_ID = A.ROLE_ID
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

	function selectByParamsCheckInternal($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY A.PENGGUNA_INTERNAL_ID ASC")
	{
		$str = "
		SELECT A.PENGGUNA_INTERNAL_ID,A.NAMA_LENGKAP,A.POSITION_ID,B.NAMA_POSISI,A.NID
		FROM PENGGUNA_INTERNAL A
		INNER JOIN MASTER_JABATAN B ON B.POSITION_ID = A.POSITION_ID
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
	function selectByParamsCheckEksternal($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY A.PENGGUNA_EXTERNAL_ID ASC")
	{
		$str = "
		SELECT A.PENGGUNA_EXTERNAL_ID,A.NAMA,A.POSITION_ID,B.NAMA_POSISI,A.PASSWORD
		FROM PENGGUNA_EXTERNAL A
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

	function selectByParamsAll($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY A.USER_ID ASC")
	{
		$str = "
		SELECT A.PENGGUNA_INTERNAL_ID AS USER_ID, NID, NAMA_LENGKAP, A.EMAIL
		, 'Internal' AS STATUS_INFO
		, CASE WHEN B.PENGGUNA_INTERNAL_ID IS NOT NULL
		THEN 'Sudah Terdaftar'
		ELSE 'Belum Terdaftar'
		END PENGGUNA_STATUS
		, C.DISTRIK_ID
		, A.KODE_UNIT KODE_DISTRIK
		, A.UNIT NAMA_DISTRIK
		, '1' STATUS_TABEL
		FROM PENGGUNA_INTERNAL A 
		LEFT JOIN PENGGUNA B ON A.PENGGUNA_INTERNAL_ID = B.PENGGUNA_INTERNAL_ID
		LEFT JOIN DISTRIK C ON A.KODE_UNIT = C.KODE
		WHERE 1=1 
		".$statement."
		UNION ALL 
		SELECT A.PENGGUNA_EXTERNAL_ID AS USER_ID, A.NID, A.NAMA, A.EMAIL
		,'Eksternal' AS STATUS_INFO
		, CASE WHEN B.PENGGUNA_EXTERNAL_ID IS NOT NULL
		THEN 'Sudah Terdaftar'
		ELSE 'Belum Terdaftar'
		END PENGGUNA_STATUS
		, C.DISTRIK_ID
		, C.KODE KODE_DISTRIK
		, C.NAMA NAMA_DISTRIK
		, '2' STATUS_TABEL
		FROM PENGGUNA_EXTERNAL A
		LEFT JOIN PENGGUNA B ON A.PENGGUNA_EXTERNAL_ID = B.PENGGUNA_EXTERNAL_ID
		LEFT JOIN DISTRIK C ON A.DISTRIK_ID = C.DISTRIK_ID
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

	function selectByParamsStatusAll($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY PENGGUNA_ID ASC")
	{
		$str = "
		select pengguna_id from pengguna_distrik 
		where status_all=0
		group by pengguna_id
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
	}


	function selectByParamsPenggunaDistrik($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="order by distrik_id")
	{
		$str = "
		SELECT  a.distrik_id FROM distrik a 
		where  a.distrik_id  not in
		(
		select distrik_id from pengguna_distrik x where a.distrik_id = x.distrik_id and x.status_all=0 ".$statement."
		)
		
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
	}


} 
?>