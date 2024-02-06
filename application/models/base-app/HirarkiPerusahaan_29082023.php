<? 
  include_once(APPPATH.'/models/Entity.php');

  class HirarkiPerusahaan extends Entity{ 

	var $query;

    function HirarkiPerusahaan()
	{
      $this->Entity(); 
    }


    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="")
    {
    	$str = "
 		SELECT
    	A.*,
    	'<a onClick=\"openurl(''app/index/master_jabatan_add?reqId=' || A.PERUSAHAAN_EKSTERNAL_ID || ''')\" 
    	style=\"cursor:pointer\" title=\"Ubah\"><img src=\"images/icn_edit.gif\" width=\"15px\" heigth=\"15px\"></a>'
    	LINK_URL_INFO
    	
    	FROM PERUSAHAAN_EKSTERNAL A
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


    function selectByParamsDirektorat($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="")
    {
    	$str = "
 		SELECT
        A.*
        ,  LPAD(A.PERUSAHAAN_EKSTERNAL_ID::text || ' - ' || A.DIREKTORAT_ID::text, 6, '0') DIR_ID
        ,  B.NAMA DIREKTORAT_NAMA
        FROM perusahaan_eksternal_direktorat A
        LEFT JOIN DIREKTORAT B ON B.DIREKTORAT_ID = A.DIREKTORAT_ID 
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


   //  function selectByParamsWilayah($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="")
   //  {
   //  	$str = "
 		// SELECT
   //      A.*,
   //      LPAD(C.PERUSAHAAN_EKSTERNAL_ID::text || ' - ' || A.DIREKTORAT_ID::text || ' - ' || A.WILAYAH_ID , 11, '0') WIL_ID
   //      , B.NAMA WILAYAH_NAMA
   //      FROM direktorat_wilayah A
   //      LEFT JOIN WILAYAH B ON B.WILAYAH_ID = A.WILAYAH_ID
   //      LEFT JOIN PERUSAHAAN_EKSTERNAL_DIREKTORAT C ON C.DIREKTORAT_ID = A.DIREKTORAT_ID  
   //      WHERE 1=1      
   //  	";

   //  	while(list($key,$val) = each($paramsArray))
   //  	{
   //  		$str .= " AND $key = '$val' ";
   //  	}

   //  	$str .= $statement." ".$sOrder;
   //  	$this->query = $str;

   //  	return $this->selectLimit($str,$limit,$from); 
   //  }

    function selectByParamsWilayah($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="")
    {
        $str = "
        SELECT WIL_ID ,WILAYAH_NAMA,DIREKTORAT_ID,PERUSAHAAN_EKSTERNAL_ID
        FROM
        (
            SELECT
            LPAD(C.PERUSAHAAN_EKSTERNAL_ID::text || ' - ' || A.DIREKTORAT_ID::text || ' - ' || A.WILAYAH_ID , 11, '0') WIL_ID
            , B.NAMA WILAYAH_NAMA, A.DIREKTORAT_ID,C.PERUSAHAAN_EKSTERNAL_ID
            FROM direktorat_wilayah A
            LEFT JOIN WILAYAH B ON B.WILAYAH_ID = A.WILAYAH_ID
            LEFT JOIN PERUSAHAAN_EKSTERNAL_DIREKTORAT C ON C.DIREKTORAT_ID = A.DIREKTORAT_ID  
            WHERE 1=1      
            UNION ALL
            SELECT
            'DIS' || ' - ' || LPAD(C.PERUSAHAAN_EKSTERNAL_ID::text || ' - ' || A.DIREKTORAT_ID::text || ' - ' || A.DISTRIK_ID , 11, '0') WIL_ID
            , B.NAMA WILAYAH_NAMA , A.DIREKTORAT_ID,C.PERUSAHAAN_EKSTERNAL_ID
            FROM direktorat_distrik A
            LEFT JOIN DISTRIK B ON B.DISTRIK_ID = A.DISTRIK_ID
            LEFT JOIN PERUSAHAAN_EKSTERNAL_DIREKTORAT C ON C.DIREKTORAT_ID = A.DIREKTORAT_ID  
            WHERE 1=1      
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


    function selectByParamsDistrikWilayah($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="")
    {
        $str = "
        SELECT
        A.*,
        LPAD( C.PERUSAHAAN_EKSTERNAL_ID || ' - ' || C.DIREKTORAT_ID || ' - ' || A.WILAYAH_ID || ' - ' || A.DISTRIK_ID , 16, '0') DIS_ID
        , B.NAMA DISTRIK_NAMA
        FROM wilayah_distrik A
        LEFT JOIN DISTRIK B ON B.DISTRIK_ID = A.DISTRIK_ID
        LEFT JOIN 
        (
            SELECT A.DIREKTORAT_ID,PERUSAHAAN_EKSTERNAL_ID,WILAYAH_ID
            FROM  direktorat_wilayah A
            LEFT JOIN PERUSAHAAN_EKSTERNAL_DIREKTORAT C ON C.DIREKTORAT_ID = A.DIREKTORAT_ID  
        ) C  ON C.WILAYAH_ID = A.WILAYAH_ID
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

    function selectByParamsBlokUnit($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="")
    {
        $str = "
        SELECT
        A.*,
        LPAD( B.PERUSAHAAN_EKSTERNAL_ID || ' - ' || B.DIREKTORAT_ID || ' - ' || B.WILAYAH_ID || ' - ' || A.DISTRIK_ID || ' - ' || A.BLOK_UNIT_ID , 21, '0') BLOK_UNIT_ID
        , C.NAMA DISTRIK_NAMA
        , B.PERUSAHAAN_EKSTERNAL_ID
        FROM blok_unit A
        LEFT JOIN 
        (
            SELECT A.DISTRIK_ID,A.WILAYAH_ID,B.DIREKTORAT_ID,B.PERUSAHAAN_EKSTERNAL_ID
            FROM wilayah_distrik A
            LEFT JOIN 
            (
                SELECT A.DIREKTORAT_ID,PERUSAHAAN_EKSTERNAL_ID,WILAYAH_ID
                FROM  direktorat_wilayah A
                LEFT JOIN PERUSAHAAN_EKSTERNAL_DIREKTORAT B ON B.DIREKTORAT_ID = A.DIREKTORAT_ID  
            ) B  ON B.WILAYAH_ID = A.WILAYAH_ID
        ) B  ON B.DISTRIK_ID = A.DISTRIK_ID
        LEFT JOIN DISTRIK C ON C.DISTRIK_ID = A.DISTRIK_ID
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

    function selectByParamsBlokUnitDistrik($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="")
    {
        $str = "
        SELECT
        A.*,
        LPAD( B.PERUSAHAAN_EKSTERNAL_ID || ' - ' || B.DIREKTORAT_ID || ' - ' || A.DISTRIK_ID || ' - ' || A.BLOK_UNIT_ID , 17, '0') BLOK_UNIT_ID
        , C.NAMA DISTRIK_NAMA
        , B.PERUSAHAAN_EKSTERNAL_ID
        FROM blok_unit A
        LEFT JOIN 
        (
                SELECT A.DIREKTORAT_ID,PERUSAHAAN_EKSTERNAL_ID,DISTRIK_ID
                FROM  direktorat_distrik A
                LEFT JOIN PERUSAHAAN_EKSTERNAL_DIREKTORAT B ON B.DIREKTORAT_ID = A.DIREKTORAT_ID  
        ) B  ON B.DISTRIK_ID = A.DISTRIK_ID
        LEFT JOIN DISTRIK C ON C.DISTRIK_ID = A.DISTRIK_ID
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

    function selectByParamsUnitMesin($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="")
    {
        $str = "
        SELECT
        A.*,
        LPAD( B.PERUSAHAAN_EKSTERNAL_ID || ' - ' || B.DIREKTORAT_ID || ' - ' || A.DISTRIK_ID || ' - ' || A.UNIT_MESIN_ID , 18, '0') UNIT_MESIN_ID
        , C.NAMA DISTRIK_NAMA
        , B.PERUSAHAAN_EKSTERNAL_ID
        , D.NAMA BLOK_NAMA
        FROM unit_mesin A
        LEFT JOIN 
        (
                SELECT A.DIREKTORAT_ID,PERUSAHAAN_EKSTERNAL_ID,DISTRIK_ID
                FROM  direktorat_distrik A
                LEFT JOIN PERUSAHAAN_EKSTERNAL_DIREKTORAT B ON B.DIREKTORAT_ID = A.DIREKTORAT_ID  
        ) B  ON B.DISTRIK_ID = A.DISTRIK_ID
        LEFT JOIN DISTRIK C ON C.DISTRIK_ID = A.DISTRIK_ID
        LEFT JOIN BLOK_UNIT D  ON D.BLOK_UNIT_ID = A.BLOK_UNIT_ID
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

    function selectByParamsSubUnitMesin($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="")
    {
        $str = "
        SELECT
        A.*,
        LPAD( B.PERUSAHAAN_EKSTERNAL_ID || ' - ' || B.DIREKTORAT_ID || ' - ' || A.DISTRIK_ID || ' - ' || A.SUB_MESIN_ID , 19, '0') SUB_MESIN_ID
        , C.NAMA DISTRIK_NAMA
        , B.PERUSAHAAN_EKSTERNAL_ID
        , D.NAMA BLOK_NAMA
        FROM sub_mesin A
        LEFT JOIN 
        (
                SELECT A.DIREKTORAT_ID,PERUSAHAAN_EKSTERNAL_ID,DISTRIK_ID
                FROM  direktorat_distrik A
                LEFT JOIN PERUSAHAAN_EKSTERNAL_DIREKTORAT B ON B.DIREKTORAT_ID = A.DIREKTORAT_ID  
        ) B  ON B.DISTRIK_ID = A.DISTRIK_ID
        LEFT JOIN DISTRIK C ON C.DISTRIK_ID = A.DISTRIK_ID
        LEFT JOIN BLOK_UNIT D  ON D.BLOK_UNIT_ID = A.BLOK_UNIT_ID
        LEFT JOIN UNIT_MESIN E  ON E.UNIT_MESIN_ID = A.UNIT_MESIN_ID
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