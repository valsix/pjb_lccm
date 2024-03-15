<? 
  include_once(APPPATH.'/models/Entity.php');

  class WoStanding extends Entity{ 

	var $query;

    function WoStanding()
	{
      $this->Entity(); 
    }

     function insert()
    {
        $str = "
        INSERT INTO t_wo_standing_lccm
        (
            KODE_BLOK, GROUP_PM, PM_YEAR, COST_PM_YEARLY, LAST_CREATE_USER, LAST_CREATE_DATE,KODE_DISTRIK,KODE_UNIT_M
        )
        VALUES 
        (
            '".$this->getField("KODE_BLOK")."'
          , '".$this->getField("GROUP_PM")."'
          , ".$this->getField("PM_YEAR")."
          , ".$this->getField("COST_PM_YEARLY")."
          , '".$this->getField("LAST_CREATE_USER")."'
          , ".$this->getField("LAST_CREATE_DATE")."
          , '".$this->getField("KODE_DISTRIK")."'
          , '".$this->getField("KODE_UNIT_M")."'
         
        )"; 
        $this->query= $str;
        // echo $str;exit;
        return $this->execQuery($str);
    }

    function update()
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
        WHERE KODE_BLOK = '".$this->getField("KODE_BLOK")."' AND  GROUP_PM = '".$this->getField("GROUP_PM")."' AND PM_YEAR = '".$this->getField("PM_YEAR")."'
        "; 
        $this->query = $str;
        // echo $str;exit;
        return $this->execQuery($str);
    }

    function updatesite()
    {
        $str = "
        UPDATE t_wo_standing_lccm 
        SET
          KODE_BLOK= '".$this->getField("KODE_BLOK")."'
          , LAST_UPDATE_USER=  '".$this->getField("LAST_UPDATE_USER")."'
          , LAST_UPDATE_DATE= '".$this->getField("LAST_UPDATE_DATE")."'
        WHERE KODE_BLOK = '".$this->getField("KODE_BLOK_OLD")."' 
        "; 
        $this->query = $str;
        // echo $str;exit;
        return $this->execQuery($str);
     }
    function updategroup()
    {
        $str = "
        UPDATE t_wo_standing_lccm 
        SET
          GROUP_PM= '".$this->getField("GROUP_PM")."'
          , KODE_UNIT_M= '".$this->getField("KODE_UNIT_M")."'
          , KODE_BLOK= '".$this->getField("KODE_BLOK")."'
          , LAST_UPDATE_USER=  '".$this->getField("LAST_UPDATE_USER")."'
          , LAST_UPDATE_DATE= '".$this->getField("LAST_UPDATE_DATE")."'
        WHERE GROUP_PM = '".$this->getField("GROUP_PM_OLD")."' AND  KODE_BLOK = '".$this->getField("KODE_BLOK_OLD")."'
        "; 
        $this->query = $str;
        // echo $str;exit;
        return $this->execQuery($str);
     }
    function updatetahun()
    {
        $str = "
        UPDATE t_wo_standing_lccm 
        SET
        PM_YEAR= ".$this->getField("PM_YEAR")."
        , COST_PM_YEARLY=  ".$this->getField("COST_PM_YEARLY")."
        , LAST_UPDATE_USER=  '".$this->getField("LAST_UPDATE_USER")."'
        , LAST_UPDATE_DATE= '".$this->getField("LAST_UPDATE_DATE")."'
        WHERE PM_YEAR = '".$this->getField("PM_YEAR_OLD")."' AND COST_PM_YEARLY = '".$this->getField("COST_PM_YEARLY_OLD")."' 
        "; 
        $this->query = $str;
        // echo $str;exit;
        return $this->execQuery($str);
    }


    function savestate()
    {
        $str = "
        UPDATE t_wo_standing_lccm 
        SET
          STATE_STATUS= '".$this->getField("STATE_STATUS")."'
        WHERE KODE_DISTRIK = '".$this->getField("KODE_DISTRIK")."' AND KODE_BLOK = '".$this->getField("KODE_BLOK")."'  AND KODE_UNIT_M = '".$this->getField("KODE_UNIT_M")."'  AND GROUP_PM = '".$this->getField("GROUP_PM")."' 
        "; 
        $this->query = $str;
        // echo $str;exit;
        return $this->execQuery($str);
     }

    function deleteparent()
    {
        $str = "
        DELETE FROM t_wo_standing_lccm
        WHERE 
        KODE_BLOK = '".$this->getField("KODE_BLOK")."'"; 

        $this->query = $str;
        // echo $str;exit;
        return $this->execQuery($str);
    }

    function deletegroup()
    {
        $str = "
        DELETE FROM t_wo_standing_lccm
        WHERE 
        KODE_BLOK = '".$this->getField("KODE_BLOK")."' AND KODE_DISTRIK = '".$this->getField("KODE_DISTRIK")."' AND GROUP_PM = '".$this->getField("GROUP_PM")."' "; 

        $this->query = $str;
        // echo $str;exit;
        return $this->execQuery($str);
    }

    function deletegroupunit()
    {
        $str = "
        DELETE FROM t_wo_standing_lccm
        WHERE 
        KODE_BLOK = '".$this->getField("KODE_BLOK")."' AND KODE_DISTRIK = '".$this->getField("KODE_DISTRIK")."' AND GROUP_PM = '".$this->getField("GROUP_PM")."' AND KODE_UNIT_M = '".$this->getField("KODE_UNIT_M")."' "; 

        $this->query = $str;
        // echo $str;exit;
        return $this->execQuery($str);
    }

    function deletetahun()
    {
        $str = "
        DELETE FROM t_wo_standing_lccm
        WHERE 
        KODE_BLOK = '".$this->getField("KODE_BLOK")."' AND KODE_DISTRIK = '".$this->getField("KODE_DISTRIK")."' AND GROUP_PM = '".$this->getField("GROUP_PM")."' AND PM_YEAR = '".$this->getField("PM_YEAR")."'  "; 

        $this->query = $str;
        // echo $str;exit;
        return $this->execQuery($str);
    }

    function deletetahununit()
    {
        $str = "
        DELETE FROM t_wo_standing_lccm
        WHERE 
        KODE_BLOK = '".$this->getField("KODE_BLOK")."' AND KODE_DISTRIK = '".$this->getField("KODE_DISTRIK")."' AND GROUP_PM = '".$this->getField("GROUP_PM")."' AND PM_YEAR = '".$this->getField("PM_YEAR")."' AND KODE_UNIT_M = '".$this->getField("KODE_UNIT_M")."' "; 

        $this->query = $str;
        // echo $str;exit;
        return $this->execQuery($str);
    }

     function selectByParamsEdit($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="")
    {
        $str = "
        SELECT
        A.KODE_BLOK,B.NAMA BLOK_NAMA,C.NAMA DISTRIK_NAMA,A.KODE_DISTRIK,A.GROUP_PM,A.PM_YEAR,A.COST_PM_YEARLY,A.KODE_UNIT_M,E.NAMA UNIT_NAMA
         
        FROM t_wo_standing_lccm A
        INNER JOIN DISTRIK C ON C.KODE = A.KODE_DISTRIK
        INNER JOIN BLOK_UNIT B ON B.KODE = A.KODE_BLOK AND B.DISTRIK_ID = C.DISTRIK_ID
        LEFT JOIN m_group_pm__lccm D ON D.GROUP_PM = A.GROUP_PM 
        LEFT  JOIN UNIT_MESIN E ON E.KODE = A.KODE_UNIT_M AND E.BLOK_UNIT_ID = B.BLOK_UNIT_ID AND E.DISTRIK_ID = B.DISTRIK_ID
        WHERE 1=1      
        ";

        while(list($key,$val) = each($paramsArray))
        {
            $str .= " AND $key = '$val' ";
        }

        $str .= $statement."   ".$sOrder;
        $this->query = $str;

        return $this->selectLimit($str,$limit,$from); 
    }


   //  function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="")
   //  {
   //  	$str = "
 		// SELECT
   //  	A.KODE_BLOK,B.NAMA BLOK_NAMA,C.NAMA DISTRIK_NAMA
   //  	 ,'<a onClick=\"openurl(''app/index/wo_standing_add?reqMode=insert&reqSiteId=' || TRIM(A.KODE_BLOK) || '&reqDistrikId=' || TRIM(A.KODE_DISTRIK) || ''')\" 
   //      style=\"cursor:pointer\" title=\"Tambah\"><img src=\"images/icn_add.gif\" width=\"15px\" heigth=\"15px\"></a>'
   //      '<a onClick=\"openurl(''app/index/wo_standing_add?reqMode=update&reqSiteId=' || TRIM(A.KODE_BLOK) || ''')\" 
   //      style=\"cursor:pointer\" title=\"Ubah\"><img src=\"images/icn_edit.gif\" KODE_BLOK=\"15px\" heigth=\"15px\"></a>'
   //      '<a onClick=\"delete_parent(''' || TRIM(A.KODE_BLOK) || ''')\" 
   //      style=\"cursor:pointer\" title=\"Hapus\"><img src=\"images/icon-hapus.png\" width=\"15px\" heigth=\"15px\"></a>'
   //      '<a onClick=\"import_child(''' || TRIM(A.KODE_BLOK) || ''')\" 
   //      style=\"cursor:pointer\" title=\"Import\"><img src=\"images/icn-excel.png\" width=\"15px\" heigth=\"15px\"></a>'
   //  	LINK_URL_INFO

   //      ,'<a onClick=\"openurl(''app/index/wo_standing_add?reqMode=insert&reqParent=parent&reqSiteId=' || TRIM(A.KODE_BLOK) || '&reqDistrikId=' || TRIM(A.KODE_DISTRIK) || ''')\" 
   //      style=\"cursor:pointer\" title=\"Tambah\"><img src=\"images/icn_add.gif\" width=\"15px\" heigth=\"15px\"></a>'
   //      '<a onClick=\"openurl(''app/index/wo_standing_add?reqMode=update&reqParent=parent&reqSiteId=' || TRIM(A.KODE_BLOK) || ''')\" 
   //      style=\"cursor:pointer\" title=\"Ubah\"><img src=\"images/icn_edit.gif\" KODE_BLOK=\"15px\" heigth=\"15px\"></a>'
   //      '<a onClick=\"delete_parent(''' || TRIM(A.KODE_BLOK) || ''')\" 
   //      style=\"cursor:pointer\" title=\"Hapus\"><img src=\"images/icon-hapus.png\" width=\"15px\" heigth=\"15px\"></a>'
   //      '<a onClick=\"import_child(''' || TRIM(A.KODE_BLOK) || ''')\" 
   //      style=\"cursor:pointer\" title=\"Import\"><img src=\"images/icn-excel.png\" width=\"15px\" heigth=\"15px\"></a>'
   //      LINK_URL_PARENT
    	
   //  	FROM t_wo_standing_lccm A
   //      INNER JOIN BLOK_UNIT B ON B.KODE = A.KODE_BLOK
   //      INNER JOIN DISTRIK C ON C.DISTRIK_ID = B.DISTRIK_ID
   //      WHERE 1=1      
   //  	";

   //  	while(list($key,$val) = each($paramsArray))
   //  	{
   //  		$str .= " AND $key = '$val' ";
   //  	}

   //  	$str .= $statement."  GROUP BY A.KODE_BLOK,B.NAMA,C.NAMA,A.KODE_DISTRIK   ".$sOrder;
   //  	$this->query = $str;

   //  	return $this->selectLimit($str,$limit,$from); 
   //  }

    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="")
    {
        $str = "
        SELECT
        A.KODE_BLOK,B.NAMA BLOK_NAMA,C.NAMA DISTRIK_NAMA,E.NAMA UNIT_NAMA
         ,'<a onClick=\"openurl(''app/index/wo_standing_add?reqMode=insert&reqSiteId=' || TRIM(A.KODE_BLOK) || '&reqDistrikId=' || TRIM(A.KODE_DISTRIK) || '&reqUnitMesinId=' || TRIM(A.KODE_UNIT_M) || '&reqUnitMesinId=' || TRIM(A.KODE_UNIT_M) || ''')\" 
        style=\"cursor:pointer\" title=\"Tambah\"><img src=\"images/icn_add.gif\" width=\"15px\" heigth=\"15px\"></a>'
        '<a onClick=\"openurl(''app/index/wo_standing_add?reqMode=update&reqSiteId=' || TRIM(A.KODE_BLOK) || ''')\" 
        style=\"cursor:pointer\" title=\"Ubah\"><img src=\"images/icn_edit.gif\" KODE_BLOK=\"15px\" heigth=\"15px\"></a>'
        '<a onClick=\"delete_parent(''' || TRIM(A.KODE_BLOK) || ''')\" 
        style=\"cursor:pointer\" title=\"Hapus\"><img src=\"images/icon-hapus.png\" width=\"15px\" heigth=\"15px\"></a>'
        '<a onClick=\"import_child(''' || TRIM(A.KODE_BLOK) || ''')\" 
        style=\"cursor:pointer\" title=\"Import\"><img src=\"images/icn-excel.png\" width=\"15px\" heigth=\"15px\"></a>'
        LINK_URL_INFO

        ,'<a onClick=\"openurl(''app/index/wo_standing_add?reqMode=insert&reqParent=parent&reqSiteId=' || TRIM(A.KODE_BLOK) || '&reqDistrikId=' || TRIM(A.KODE_DISTRIK) || ''')\" 
        style=\"cursor:pointer\" title=\"Tambah\"><img src=\"images/icn_add.gif\" width=\"15px\" heigth=\"15px\"></a>'
        '<a onClick=\"openurl(''app/index/wo_standing_add?reqMode=update&reqParent=parent&reqSiteId=' || TRIM(A.KODE_BLOK) || ''')\" 
        style=\"cursor:pointer\" title=\"Ubah\"><img src=\"images/icn_edit.gif\" KODE_BLOK=\"15px\" heigth=\"15px\"></a>'
        '<a onClick=\"delete_parent(''' || TRIM(A.KODE_BLOK) || ''')\" 
        style=\"cursor:pointer\" title=\"Hapus\"><img src=\"images/icon-hapus.png\" width=\"15px\" heigth=\"15px\"></a>'
       
        LINK_URL_PARENT
        
        FROM t_wo_standing_lccm A
        INNER JOIN DISTRIK C ON C.KODE = A.KODE_DISTRIK
        INNER JOIN BLOK_UNIT B ON B.KODE = A.KODE_BLOK AND B.DISTRIK_ID = C.DISTRIK_ID
        INNER JOIN M_GROUP_PM__LCCM D ON D.GROUP_PM = A.GROUP_PM 
        LEFT  JOIN UNIT_MESIN E ON E.KODE = A.KODE_UNIT_M AND E.BLOK_UNIT_ID = B.BLOK_UNIT_ID AND E.DISTRIK_ID = B.DISTRIK_ID


        WHERE 1=1      
        ";

        while(list($key,$val) = each($paramsArray))
        {
            $str .= " AND $key = '$val' ";
        }

        $str .= $statement."  GROUP BY A.KODE_BLOK,B.NAMA,C.NAMA,A.KODE_DISTRIK,A.KODE_UNIT_M,E.NAMA    ".$sOrder;
        $this->query = $str;

        return $this->selectLimit($str,$limit,$from); 
    }

    // function selectByParamsGroup($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="")
    // {
    //     $str = "
    //     SELECT
    //     A.KODE_BLOK,A.GROUP_PM,B.NAMA BLOK_NAMA,C.NAMA DISTRIK_NAMA,A.KODE_DISTRIK
    //      ,'<a onClick=\"openurl(''app/index/wo_standing_add?reqMode=insert&reqParent=group&reqSiteId=' || TRIM(A.KODE_BLOK) || '&reqDistrikId=' || TRIM(A.KODE_DISTRIK) || '&reqGroupPm=' || TRIM(A.GROUP_PM) || ''')\" 
    //     style=\"cursor:pointer\" title=\"Tambah\"><img src=\"images/icn_add.gif\" width=\"15px\" heigth=\"15px\"></a>'
    //     '<a onClick=\"openurl(''app/index/wo_standing_add?reqMode=update&reqParent=group&reqSiteId=' || TRIM(A.KODE_BLOK) || '&reqDistrikId=' || TRIM(A.KODE_DISTRIK) || '&reqGroupPm=' || TRIM(A.GROUP_PM) || ' '')  \" 
    //     style=\"cursor:pointer\" title=\"Ubah\"><img src=\"images/icn_edit.gif\" KODE_BLOK=\"15px\" heigth=\"15px\"></a>'
    //     '<a onClick=\"delete_group(''' || TRIM(A.KODE_BLOK) || ''',''' || TRIM(A.KODE_DISTRIK) || ''',''' || TRIM(A.GROUP_PM) || ''')\" 
    //     style=\"cursor:pointer\" title=\"Hapus\"><img src=\"images/icon-hapus.png\" width=\"15px\" heigth=\"15px\"></a>'
    //     '<a onClick=\"import_child(''' || TRIM(A.KODE_BLOK) || ''')\" 
    //     style=\"cursor:pointer\" title=\"Import\"><img src=\"images/icn-excel.png\" width=\"15px\" heigth=\"15px\"></a>'
    //     LINK_URL_INFO
        
    //     FROM t_wo_standing_lccm A
    //     INNER JOIN BLOK_UNIT B ON B.KODE = A.KODE_BLOK
    //     INNER JOIN DISTRIK C ON C.DISTRIK_ID = B.DISTRIK_ID
    //     WHERE 1=1      
    //     ";

    //     while(list($key,$val) = each($paramsArray))
    //     {
    //         $str .= " AND $key = '$val' ";
    //     }

    //     $str .= $statement."  GROUP BY A.KODE_BLOK,A.GROUP_PM,B.NAMA,C.NAMA,A.KODE_DISTRIK ".$sOrder;
    //     $this->query = $str;

    //     return $this->selectLimit($str,$limit,$from); 
    // }

     function selectByParamsGroup($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="")
    {
        $str = "
        SELECT
        A.KODE_BLOK,A.KODE_DISTRIK,A.KODE_UNIT_M,A.GROUP_PM,B.NAMA BLOK_NAMA,C.NAMA DISTRIK_NAMA,A.KODE_DISTRIK,E.NAMA UNIT_NAMA,A.STATE_STATUS
        , CASE WHEN A.KODE_UNIT_M IS NULL THEN
        '<a onClick=\"openurl(''app/index/wo_standing_add?reqMode=insert&reqParent=group&reqSiteId=' || TRIM(A.KODE_BLOK) || '&reqDistrikId=' || TRIM(A.KODE_DISTRIK) || '&reqGroupPm=' || TRIM(A.GROUP_PM) || '&reqUnitMesinId=' || TRIM(A.KODE_UNIT_M) || ''')\" 
        style=\"cursor:pointer\" title=\"Tambah\"><img src=\"images/icn_add.gif\" width=\"15px\" heigth=\"15px\"></a>'
        '<a onClick=\"openurl(''app/index/wo_standing_add?reqMode=update&reqParent=group&reqSiteId=' || TRIM(A.KODE_BLOK) || '&reqDistrikId=' || TRIM(A.KODE_DISTRIK) || '&reqGroupPm=' || TRIM(A.GROUP_PM) || '&reqUnitMesinId=' || TRIM(A.KODE_UNIT_M) || ' '')  \" 
        style=\"cursor:pointer\" title=\"Ubah\"><img src=\"images/icn_edit.gif\" KODE_BLOK=\"15px\" heigth=\"15px\"></a>'
        '<a onClick=\"delete_group(''' || TRIM(A.KODE_BLOK) || ''',''' || TRIM(A.KODE_DISTRIK) || ''',''' || TRIM(A.GROUP_PM) || ''')\" 
        style=\"cursor:pointer\" title=\"Hapus\"><img src=\"images/icon-hapus.png\" width=\"15px\" heigth=\"15px\"></a>'
        '<a onClick=\"import_child(''' || TRIM(A.GROUP_PM) || ''')\" 
        style=\"cursor:pointer\" title=\"Import\"><img src=\"images/icn-excel.png\" width=\"15px\" heigth=\"15px\"></a>'
        ELSE
        '<a onClick=\"openurl(''app/index/wo_standing_add?reqMode=insert&reqParent=group&reqSiteId=' || TRIM(A.KODE_BLOK) || '&reqDistrikId=' || TRIM(A.KODE_DISTRIK) || '&reqGroupPm=' || TRIM(A.GROUP_PM) || '&reqUnitMesinId=' || TRIM(A.KODE_UNIT_M) || ''')\" 
        style=\"cursor:pointer\" title=\"Tambah\"><img src=\"images/icn_add.gif\" width=\"15px\" heigth=\"15px\"></a>'
        '<a onClick=\"openurl(''app/index/wo_standing_add?reqMode=update&reqParent=group&reqSiteId=' || TRIM(A.KODE_BLOK) || '&reqDistrikId=' || TRIM(A.KODE_DISTRIK) || '&reqGroupPm=' || TRIM(A.GROUP_PM) || '&reqUnitMesinId=' || TRIM(A.KODE_UNIT_M) || ''')  \" 
        style=\"cursor:pointer\" title=\"Ubah\"><img src=\"images/icn_edit.gif\" KODE_BLOK=\"15px\" heigth=\"15px\"></a>'
        '<a onClick=\"delete_group(''' || TRIM(A.KODE_BLOK) || ''',''' || TRIM(A.KODE_DISTRIK) || ''',''' || TRIM(A.GROUP_PM) || ''',''' || TRIM(A.KODE_UNIT_M) || ''')\" 
        style=\"cursor:pointer\" title=\"Hapus\"><img src=\"images/icon-hapus.png\" width=\"15px\" heigth=\"15px\"></a>'
        '<a onClick=\"import_child(''' || TRIM(A.GROUP_PM) || ''')\" 
        style=\"cursor:pointer\" title=\"Import\"><img src=\"images/icn-excel.png\" width=\"15px\" heigth=\"15px\"></a>'
        END
        LINK_URL_INFO
        
        FROM t_wo_standing_lccm A
        INNER JOIN DISTRIK C ON C.KODE = A.KODE_DISTRIK
        INNER JOIN BLOK_UNIT B ON B.KODE = A.KODE_BLOK AND B.DISTRIK_ID = C.DISTRIK_ID
        LEFT  JOIN UNIT_MESIN E ON E.KODE = A.KODE_UNIT_M AND E.BLOK_UNIT_ID = B.BLOK_UNIT_ID AND E.DISTRIK_ID = B.DISTRIK_ID
        WHERE 1=1    
        ";

        while(list($key,$val) = each($paramsArray))
        {
            $str .= " AND $key = '$val' ";
        }

        $str .= $statement."  GROUP BY A.KODE_BLOK,A.GROUP_PM,B.NAMA,C.NAMA,A.KODE_DISTRIK,A.KODE_UNIT_M,E.NAMA,A.STATE_STATUS  ".$sOrder;
        $this->query = $str;

        return $this->selectLimit($str,$limit,$from); 
    }

    // function selectByParamsChild($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="")
    // {
    //     $str = "
    //     SELECT
    //     A.KODE_BLOK,A.GROUP_PM,A.PM_YEAR,A.COST_PM_YEARLY,B.NAMA BLOK_NAMA,C.NAMA DISTRIK_NAMA
      
    //     ,'<a onClick=\"openurl(''app/index/wo_standing_add?reqMode=update&reqParent=tahun&reqSiteId=' || TRIM(A.KODE_BLOK) || '&reqDistrikId=' || TRIM(A.KODE_DISTRIK) || '&reqGroupPm=' || TRIM(A.GROUP_PM) || '&reqTahun=' || A.PM_YEAR || '&reqCost=' || A.COST_PM_YEARLY || ''')\" 
    //     style=\"cursor:pointer\" title=\"Ubah\"><img src=\"images/icn_edit.gif\" KODE_BLOK=\"15px\" heigth=\"15px\"></a>'
    //     '<a onClick=\"delete_detail(''' || TRIM(A.KODE_BLOK) || ''')\" 
    //     style=\"cursor:pointer\" title=\"Hapus\"><img src=\"images/icon-hapus.png\" width=\"15px\" heigth=\"15px\"></a>'
       
       
    //     LINK_URL_INFO
        
    //     FROM t_wo_standing_lccm A
    //     INNER JOIN BLOK_UNIT B ON B.KODE = A.KODE_BLOK
    //     INNER JOIN DISTRIK C ON C.DISTRIK_ID = B.DISTRIK_ID
    //     WHERE 1=1      
    //     ";

    //     while(list($key,$val) = each($paramsArray))
    //     {
    //         $str .= " AND $key = '$val' ";
    //     }

    //     $str .= $statement."  ".$sOrder;
    //     $this->query = $str;

    //     return $this->selectLimit($str,$limit,$from); 
    // }


    function selectByParamsChild($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="")
    {
        $str = "
        SELECT
        A.KODE_BLOK,A.KODE_DISTRIK,A.KODE_UNIT_M,A.GROUP_PM,A.PM_YEAR,A.COST_PM_YEARLY,B.NAMA BLOK_NAMA,C.NAMA DISTRIK_NAMA,E.NAMA UNIT_NAMA,A.STATE_STATUS
        , CASE WHEN A.KODE_UNIT_M IS NULL THEN
        '<a onClick=\"openurl(''app/index/wo_standing_add?reqMode=update&reqParent=tahun&reqSiteId=' || TRIM(A.KODE_BLOK) || '&reqDistrikId=' || TRIM(A.KODE_DISTRIK) || '&reqGroupPm=' || TRIM(A.GROUP_PM) || '&reqTahun=' || A.PM_YEAR || '&reqCost=' || A.COST_PM_YEARLY || '&reqUnitMesinId=' || TRIM(A.KODE_UNIT_M) || ''')\" 
        style=\"cursor:pointer\" title=\"Ubah\"><img src=\"images/icn_edit.gif\" KODE_BLOK=\"15px\" heigth=\"15px\"></a>'
        '<a onClick=\"delete_tahun(''' || TRIM(A.KODE_BLOK) || ''',''' || TRIM(A.KODE_DISTRIK) || ''',''' || TRIM(A.GROUP_PM) || ''',''' || A.PM_YEAR || '&reqUnitMesinId=' || TRIM(A.KODE_UNIT_M) || ''')\" 
        style=\"cursor:pointer\" title=\"Hapus\"><img src=\"images/icon-hapus.png\" width=\"15px\" heigth=\"15px\"></a>'
        ELSE
        '<a onClick=\"openurl(''app/index/wo_standing_add?reqMode=update&reqParent=tahun&reqSiteId=' || TRIM(A.KODE_BLOK) || '&reqDistrikId=' || TRIM(A.KODE_DISTRIK) || '&reqGroupPm=' || TRIM(A.GROUP_PM) || '&reqTahun=' || A.PM_YEAR || '&reqCost=' || A.COST_PM_YEARLY || '&reqUnitMesinId=' || TRIM(A.KODE_UNIT_M) || ''')\" 
        style=\"cursor:pointer\" title=\"Ubah\"><img src=\"images/icn_edit.gif\" KODE_BLOK=\"15px\" heigth=\"15px\"></a>'
        '<a onClick=\"delete_tahun(''' || TRIM(A.KODE_BLOK) || ''',''' || TRIM(A.KODE_DISTRIK) || ''',''' || TRIM(A.GROUP_PM) || ''',''' || A.PM_YEAR || ''',''' || TRIM(A.KODE_UNIT_M) || ''')\" 
        style=\"cursor:pointer\" title=\"Hapus\"><img src=\"images/icon-hapus.png\" width=\"15px\" heigth=\"15px\"></a>'
        END
        LINK_URL_INFO
        
        FROM t_wo_standing_lccm A
        INNER JOIN DISTRIK C ON C.KODE = A.KODE_DISTRIK
        INNER JOIN BLOK_UNIT B ON B.KODE = A.KODE_BLOK AND B.DISTRIK_ID = C.DISTRIK_ID
        LEFT  JOIN UNIT_MESIN E ON E.KODE = A.KODE_UNIT_M AND E.BLOK_UNIT_ID = B.BLOK_UNIT_ID AND E.DISTRIK_ID = B.DISTRIK_ID
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


    function selectByParamsCheckBlok($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="")
    {
        $str = "
        SELECT
        A.*
        
        FROM BLOK_UNIT A
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

    function selectByParamsCheckGroup($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="")
    {
        $str = "
        SELECT
        A.*
        
        FROM m_group_pm__lccm A
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