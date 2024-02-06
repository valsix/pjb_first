<? 
include_once(APPPATH.'/models/Entity.php');

class BobotItemAssessment extends Entity { 

	var $query;

    function BobotItemAssessment()
	{
      	$this->Entity(); 
    }

    function insert()
    {
    	$this->setField("BOBOT_ITEM_ASSESSMENT_ID", $this->getNextId("BOBOT_ITEM_ASSESSMENT_ID","BOBOT_ITEM_ASSESSMENT"));

    	$str = "
    	INSERT INTO BOBOT_ITEM_ASSESSMENT
    	(
    		BOBOT_ITEM_ASSESSMENT_ID,KATEGORI_ITEM_ASSESSMENT_ID,BOBOT,LAST_CREATE_USER,LAST_CREATE_DATE
    	)
    	VALUES 
    	(
    		".$this->getField("BOBOT_ITEM_ASSESSMENT_ID")."
    		, ".$this->getField("KATEGORI_ITEM_ASSESSMENT_ID")."
	    	, ".$this->getField("BOBOT")."
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    )"; 

	    $this->id= $this->getField("BOBOT_ITEM_ASSESSMENT_ID");
	    $this->query= $str;
			// echo $str;exit;
	    return $this->execQuery($str);
	}

	function update()
	{
		$str = "
		UPDATE BOBOT_ITEM_ASSESSMENT
		SET
		BOBOT_ITEM_ASSESSMENT_ID= ".$this->getField("BOBOT_ITEM_ASSESSMENT_ID")."
		, KATEGORI_ITEM_ASSESSMENT_ID= ".$this->getField("KATEGORI_ITEM_ASSESSMENT_ID")."
		, BOBOT= ".$this->getField("BOBOT")."
		, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE= '".$this->getField("LAST_UPDATE_DATE")."'
		WHERE BOBOT_ITEM_ASSESSMENT_ID = '".$this->getField("BOBOT_ITEM_ASSESSMENT_ID")."'
		"; 
		$this->query = $str;
			// echo $str;exit;
		return $this->execQuery($str);
	}

	function update_status()
	{
		$str = "
		UPDATE BOBOT_ITEM_ASSESSMENT
		SET
		STATUS = ".$this->getField("STATUS")."
		WHERE BOBOT_ITEM_ASSESSMENT_ID = '".$this->getField("BOBOT_ITEM_ASSESSMENT_ID")."'
		"; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM BOBOT_ITEM_ASSESSMENT
		WHERE 
		BOBOT_ITEM_ASSESSMENT_ID = ".$this->getField("BOBOT_ITEM_ASSESSMENT_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY BOBOT_ITEM_ASSESSMENT_ID ASC")
	{
		$str = "
			SELECT 
				A.*,B.NAMA  KATEGORI_ITEM
				,
				CASE WHEN A.STATUS = 1 THEN 'Tidak  Aktif' ELSE 'Aktif' END STATUS_INFO
			FROM BOBOT_ITEM_ASSESSMENT A 
			LEFT JOIN KATEGORI_ITEM_ASSESSMENT B ON B.KATEGORI_ITEM_ASSESSMENT_ID = A.KATEGORI_ITEM_ASSESSMENT_ID
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