<? 
include_once(APPPATH.'/models/Entity.php');

class ListArea extends Entity { 

	var $query;

    function ListArea()
	{
      	$this->Entity(); 
    }


    function insert()
    {
    	$this->setField("LIST_AREA_ID", $this->getNextId("LIST_AREA_ID","LIST_AREA"));

    	$str = "
    	INSERT INTO LIST_AREA
    	(
    		LIST_AREA_ID,KODE,NAMA,DESKRIPSI,LAST_CREATE_USER,LAST_CREATE_DATE
    	)
    	VALUES 
    	(
    		".$this->getField("LIST_AREA_ID")."
	    	, '".$this->getField("KODE")."'
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("DESKRIPSI")."'
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    )"; 

	    $this->id= $this->getField("LIST_AREA_ID");
	    $this->query= $str;
			// echo $str;exit;
	    return $this->execQuery($str);
	}

	function update()
	{
		$str = "
		UPDATE LIST_AREA
		SET
		KODE= '".$this->getField("KODE")."'
		, NAMA= '".$this->getField("NAMA")."'
		, DESKRIPSI= '".$this->getField("DESKRIPSI")."'
		, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE= '".$this->getField("LAST_UPDATE_DATE")."'
		WHERE LIST_AREA_ID = '".$this->getField("LIST_AREA_ID")."'
		"; 
		$this->query = $str;
			// echo $str;exit;
		return $this->execQuery($str);
	}

	function update_status()
	{
		$str = "
		UPDATE LIST_AREA
		SET
		STATUS = ".$this->getField("STATUS")."
		WHERE LIST_AREA_ID = '".$this->getField("LIST_AREA_ID")."'
		"; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM LIST_AREA
		WHERE 
		LIST_AREA_ID = ".$this->getField("LIST_AREA_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY LIST_AREA_ID ASC")
	{
		$str = "
			SELECT 
				A.*,
				CASE WHEN A.STATUS = 1 THEN 'Tidak  Aktif' ELSE 'Aktif' END STATUS_INFO
			FROM LIST_AREA A 
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


    function getCountByParams($paramsArray=array(),$statement='')
	{
		$str = "SELECT COUNT(1) AS ROWCOUNT 
		FROM list_area a
		WHERE 1 = 1  ".$statement; 
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }

    function selectduplikat($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY KODE_INFO ASC")
	{
		$str = "
		SELECT 
			A.KODE || GENERATEZERO(A1.KODE,2) KODE_INFO
			, CASE WHEN A.STATUS = 1 THEN 'TIDAK  AKTIF' ELSE 'AKTIF' END STATUS_INFO
			, A.*
			, A1.KODE KODE_DUPLIKAT
			, A1.ITEM_ASSESSMENT_DUPLIKAT_ID
			, B.AREA_UNIT_DETIL_ID
			, B.NAMA AREA_UNIT
			, B.STATUS_KONFIRMASI STATUS_CONFIRM
		FROM LIST_AREA A 
		INNER JOIN ITEM_ASSESSMENT_DUPLIKAT A1 ON A.LIST_AREA_ID = A1.LIST_AREA_ID
		LEFT JOIN AREA_UNIT_DETIL B ON B.ITEM_ASSESSMENT_DUPLIKAT_ID = A1.ITEM_ASSESSMENT_DUPLIKAT_ID AND B.LIST_AREA_ID = A1.LIST_AREA_ID
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


    function selectduplikatnew($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY A.NAMA ASC")
	{
		$str = "
		SELECT 
			A.KODE || GENERATEZERO(A1.KODE,2) KODE_INFO
			, CASE WHEN A.STATUS = 1 THEN 'TIDAK  AKTIF' ELSE 'AKTIF' END STATUS_INFO
			, A.*
			, A1.KODE KODE_DUPLIKAT
			, A1.ITEM_ASSESSMENT_DUPLIKAT_ID
		FROM LIST_AREA A 
		INNER JOIN ITEM_ASSESSMENT_DUPLIKAT A1 ON A.LIST_AREA_ID = A1.LIST_AREA_ID
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


	function selectduplikatfilter($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY C.BLOK_UNIT_ID,A.LIST_AREA_ID,A1.LIST_AREA_ID ASC")
	{
		$str = "
		SELECT 
			A.KODE || GENERATEZERO(A1.KODE,2) KODE_INFO
			, CASE WHEN A.STATUS = 1 THEN 'TIDAK  AKTIF' ELSE 'AKTIF' END STATUS_INFO
			, A.*
			, A1.KODE KODE_DUPLIKAT
			, A1.ITEM_ASSESSMENT_DUPLIKAT_ID
			, B.NAMA AREA_UNIT
			, B.STATUS_KONFIRMASI STATUS_CONFIRM
			, B.AREA_UNIT_ID
			, B.AREA_UNIT_DETIL_ID
			, D.BLOK_UNIT_ID
			, D.NAMA NAMA_BLOK
			, E.NAMA NAMA_MESIN
		FROM LIST_AREA A 
		INNER JOIN ITEM_ASSESSMENT_DUPLIKAT A1 ON A.LIST_AREA_ID = A1.LIST_AREA_ID
		INNER JOIN AREA_UNIT_DETIL B ON B.ITEM_ASSESSMENT_DUPLIKAT_ID = A1.ITEM_ASSESSMENT_DUPLIKAT_ID AND B.LIST_AREA_ID = A1.LIST_AREA_ID
		INNER JOIN AREA_UNIT C ON C.AREA_UNIT_ID = B.AREA_UNIT_ID
		LEFT JOIN BLOK_UNIT D ON D.BLOK_UNIT_ID = C.BLOK_UNIT_ID
		LEFT JOIN UNIT_MESIN E ON E.UNIT_MESIN_ID = C.UNIT_MESIN_ID
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

	function getCountduplikat($paramsArray=array(),$statement='')
	{
		$str = "SELECT COUNT(1) AS ROWCOUNT 
		FROM list_area A 
		INNER JOIN item_assessment_duplikat A1 ON A.LIST_AREA_ID = A1.LIST_AREA_ID
		INNER JOIN AREA_UNIT_DETIL B ON B.ITEM_ASSESSMENT_DUPLIKAT_ID = A1.ITEM_ASSESSMENT_DUPLIKAT_ID AND B.LIST_AREA_ID = A1.LIST_AREA_ID
		INNER JOIN AREA_UNIT C ON C.AREA_UNIT_ID = B.AREA_UNIT_ID
		WHERE 1 = 1  ".$statement; 
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }
	
} 
?>