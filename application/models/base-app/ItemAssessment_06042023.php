<? 
include_once(APPPATH.'/models/Entity.php');

class ItemAssessment extends Entity { 

	var $query;

    function ItemAssessment()
	{
      	$this->Entity(); 
    }

    function insert()
    {
    	$this->setField("ITEM_ASSESSMENT_ID", $this->getNextId("ITEM_ASSESSMENT_ID","ITEM_ASSESSMENT"));

    	$str = "
    	INSERT INTO ITEM_ASSESSMENT
    	(
    		ITEM_ASSESSMENT_ID,STANDAR_REFERENSI_ID,NAMA,DESKRIPSI,LAST_CREATE_USER,LAST_CREATE_DATE
    	)
    	VALUES 
    	(
    		".$this->getField("ITEM_ASSESSMENT_ID")."
    		, ".$this->getField("STANDAR_REFERENSI_ID")."
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("DESKRIPSI")."'
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    )"; 

	    $this->id= $this->getField("ITEM_ASSESSMENT_ID");
	    $this->query= $str;
			// echo $str;exit;
	    return $this->execQuery($str);
	}

	function update()
	{
		$str = "
		UPDATE ITEM_ASSESSMENT
		SET
		STANDAR_REFERENSI_ID= ".$this->getField("STANDAR_REFERENSI_ID")."
		, NAMA= '".$this->getField("NAMA")."'
		, DESKRIPSI= '".$this->getField("DESKRIPSI")."'
		, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE= '".$this->getField("LAST_UPDATE_DATE")."'
		WHERE ITEM_ASSESSMENT_ID = '".$this->getField("ITEM_ASSESSMENT_ID")."'
		"; 
		$this->query = $str;
			// echo $str;exit;
		return $this->execQuery($str);
	}

	function update_status()
	{
		$str = "
		UPDATE ITEM_ASSESSMENT
		SET
		STATUS = ".$this->getField("STATUS")."
		WHERE ITEM_ASSESSMENT_ID = '".$this->getField("ITEM_ASSESSMENT_ID")."'
		"; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM ITEM_ASSESSMENT
		WHERE 
		ITEM_ASSESSMENT_ID = ".$this->getField("ITEM_ASSESSMENT_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY ITEM_ASSESSMENT_ID ASC")
	{
		$str = "
			SELECT 
				A.*,B.NAMA  STANDAR_NAMA
				, CASE WHEN A.STATUS = 1 THEN 'Tidak  Aktif' ELSE 'Aktif' END STATUS_INFO
			FROM ITEM_ASSESSMENT A 
			LEFT JOIN STANDAR_REFERENSI B ON B.STANDAR_REFERENSI_ID = A.STANDAR_REFERENSI_ID
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