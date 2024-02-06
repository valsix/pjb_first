<? 
  include_once(APPPATH.'/models/Entity.php');

  class Tes extends Entity{ 

	var $query;

    function Tes()
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
    	A.*,
    	LPAD(direktorat_id::text, 2, '0') DIR_ID,
    	'<a onClick=\"openurl(''app/index/master_jabatan_add?reqId=' || A.DIREKTORAT_ID || ''')\" 
    	style=\"cursor:pointer\" title=\"Ubah\"><img src=\"images/icn_edit.gif\" width=\"15px\" heigth=\"15px\"></a>'
    	LINK_URL_INFO
    	
    	FROM DIREKTORAT A
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


    function selectByParamsWilayah($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="")
    {
    	$str = "
 		SELECT
    	A.*,
    	LPAD(wilayah_id::text, 3, '0') WIL_ID,
    	'<a onClick=\"openurl(''app/index/master_jabatan_add?reqId=' || A.wilayah_id || ''')\" 
    	style=\"cursor:pointer\" title=\"Ubah\"><img src=\"images/icn_edit.gif\" width=\"15px\" heigth=\"15px\"></a>'
    	LINK_URL_INFO
    	
    	FROM WILAYAH A
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


     function selectByParamsDistrik($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="")
    {
        $str = "
        SELECT
        A.*,
        LPAD(distrik_id::text, 4, '0') DIS_ID,
        '<a onClick=\"openurl(''app/index/master_jabatan_add?reqId=' || A.distrik_id || ''')\" 
        style=\"cursor:pointer\" title=\"Ubah\"><img src=\"images/icn_edit.gif\" width=\"15px\" heigth=\"15px\"></a>'
        LINK_URL_INFO
        
        FROM DISTRIK A
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