<? 
include_once(APPPATH.'/models/Entity.php');

class KategoriItemAssessment extends Entity { 

	var $query;

    function KategoriItemAssessment()
	{
      	$this->Entity(); 
    }

    function insert()
    {
    	$this->setField("KATEGORI_ITEM_ASSESSMENT_ID", $this->getNextId("KATEGORI_ITEM_ASSESSMENT_ID","KATEGORI_ITEM_ASSESSMENT"));

    	$str = "
    	INSERT INTO KATEGORI_ITEM_ASSESSMENT
    	(
    		KATEGORI_ITEM_ASSESSMENT_ID,NAMA,BOBOT,LAST_CREATE_USER,LAST_CREATE_DATE,KODE
    	)
    	VALUES 
    	(
    		".$this->getField("KATEGORI_ITEM_ASSESSMENT_ID")."
	    	, '".$this->getField("NAMA")."'
	    	, ".$this->getField("BOBOT")."
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    	, '".$this->getField("KODE")."'
	    )"; 

	    $this->id= $this->getField("KATEGORI_ITEM_ASSESSMENT_ID");
	    $this->query= $str;
			// echo $str;exit;
			
	    return $this->execQuery($str);
	}

	function update()
	{
		$str = "
		UPDATE KATEGORI_ITEM_ASSESSMENT
		SET
		 NAMA= '".$this->getField("NAMA")."'
		, KODE= '".$this->getField("KODE")."'
		, BOBOT= ".$this->getField("BOBOT")."
		, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE= '".$this->getField("LAST_UPDATE_DATE")."'
		WHERE KATEGORI_ITEM_ASSESSMENT_ID = '".$this->getField("KATEGORI_ITEM_ASSESSMENT_ID")."'
		"; 
		$this->query = $str;
			// echo $str;exit;
		return $this->execQuery($str);
	}


	function update_status()
	{
		$str = "
		UPDATE KATEGORI_ITEM_ASSESSMENT
		SET
		STATUS = ".$this->getField("STATUS")."
		WHERE KATEGORI_ITEM_ASSESSMENT_ID = '".$this->getField("KATEGORI_ITEM_ASSESSMENT_ID")."'
		"; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM KATEGORI_ITEM_ASSESSMENT
		WHERE 
		KATEGORI_ITEM_ASSESSMENT_ID = ".$this->getField("KATEGORI_ITEM_ASSESSMENT_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY KATEGORI_ITEM_ASSESSMENT_ID ASC")
	{
		$str = "
			SELECT 
				A.*,
			CASE WHEN A.STATUS = 1 THEN 'Tidak  Aktif' ELSE 'Aktif' END STATUS_INFO
			FROM KATEGORI_ITEM_ASSESSMENT A
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

	function selectByParamsAreaFilter($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY KATEGORI_ITEM_ASSESSMENT_ID ASC")
	{
		$str = "
			SELECT A.LIST_AREA_ID,C.KATEGORI_ITEM_ASSESSMENT_ID,C.NAMA
			FROM ITEM_ASSESSMENT A
			INNER JOIN ITEM_ASSESSMENT_FORMULIR B ON B.ITEM_ASSESSMENT_ID = A.ITEM_ASSESSMENT_ID
			INNER JOIN KATEGORI_ITEM_ASSESSMENT C ON C.KATEGORI_ITEM_ASSESSMENT_ID = B.KATEGORI_ITEM_ASSESSMENT_ID
			WHERE 1=1

		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." GROUP BY A.LIST_AREA_ID,C.KATEGORI_ITEM_ASSESSMENT_ID ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
	}

	
} 
?>