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
        
          LPAD(A.PERUSAHAAN_EKSTERNAL_ID::text || ' - ' || A.DIREKTORAT_ID::text, 6, '0') DIR_ID
        ,  B.NAMA DIREKTORAT_NAMA
        FROM distrik A
        INNER JOIN DIREKTORAT B ON B.DIREKTORAT_ID = A.DIREKTORAT_ID 
        WHERE 1=1        
    	";

    	while(list($key,$val) = each($paramsArray))
    	{
    		$str .= " AND $key = '$val' ";
    	}

    	$str .= $statement." GROUP BY A.DIREKTORAT_ID,A.PERUSAHAAN_EKSTERNAL_ID,B.NAMA ".$sOrder;
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
         SELECT
            LPAD(A.PERUSAHAAN_EKSTERNAL_ID::text || ' - ' || A.DIREKTORAT_ID::text || ' - ' || A.WILAYAH_ID , 11, '0') WIL_ID
            , B.NAMA WILAYAH_NAMA
            FROM DISTRIK A
            LEFT JOIN WILAYAH B ON B.WILAYAH_ID = A.WILAYAH_ID
            LEFT JOIN DIREKTORAT C ON C.DIREKTORAT_ID = A.DIREKTORAT_ID  
            WHERE 1=1            
        ";

        while(list($key,$val) = each($paramsArray))
        {
            $str .= " AND $key = '$val' ";
        }

        $str .= $statement." GROUP BY A.PERUSAHAAN_EKSTERNAL_ID,A.DIREKTORAT_ID,B.NAMA,A.WILAYAH_ID ".$sOrder;
        $this->query = $str;

        return $this->selectLimit($str,$limit,$from); 
    }


    function selectByParamsDistrik($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="")
    {
        $str = "
        SELECT
        A.*,
        A.PERUSAHAAN_EKSTERNAL_ID || ' - ' || A.DIREKTORAT_ID || ' - ' || A.WILAYAH_ID || ' - ' || A.DISTRIK_ID DIS_ID
        , A.NAMA DISTRIK_NAMA
        FROM distrik A
        LEFT JOIN WILAYAH C ON C.WILAYAH_ID = A.WILAYAH_ID 
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
        C.PERUSAHAAN_EKSTERNAL_ID || ' - ' || C.DIREKTORAT_ID || ' - ' || C.DISTRIK_ID || ' - ' || A.BLOK_UNIT_ID  BLOK_UNIT_INFO
        , C.NAMA DISTRIK_NAMA
        , C.PERUSAHAAN_EKSTERNAL_ID
        FROM blok_unit A
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
        C.PERUSAHAAN_EKSTERNAL_ID || ' - ' || C.DIREKTORAT_ID || ' - ' || A.DISTRIK_ID || ' - ' || A.UNIT_MESIN_ID  UNIT_MESIN_INFO
        , C.NAMA DISTRIK_NAMA
        , C.PERUSAHAAN_EKSTERNAL_ID
        , D.NAMA BLOK_NAMA
        FROM unit_mesin A

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

    

  } 
?>