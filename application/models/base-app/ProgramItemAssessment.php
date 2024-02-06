<? 
include_once(APPPATH.'/models/Entity.php');

class ProgramItemAssessment extends Entity { 

	var $query;

    function ProgramItemAssessment()
	{
      	$this->Entity(); 
    }

    function insert()
    {
    	$this->setField("PROGRAM_ITEM_ASSESSMENT_ID", $this->getNextId("PROGRAM_ITEM_ASSESSMENT_ID","PROGRAM_ITEM_ASSESSMENT"));

    	$str = "
    	INSERT INTO PROGRAM_ITEM_ASSESSMENT
    	(
    		PROGRAM_ITEM_ASSESSMENT_ID,NAMA,LAST_CREATE_USER,LAST_CREATE_DATE,KODE,RATING
    	)
    	VALUES 
    	(
    		".$this->getField("PROGRAM_ITEM_ASSESSMENT_ID")."
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    	, '".$this->getField("KODE")."'
	    	, ".$this->getField("RATING")."
	    )"; 

	    $this->id= $this->getField("PROGRAM_ITEM_ASSESSMENT_ID");
	    $this->query= $str;
			// echo $str;exit;
	    return $this->execQuery($str);
	}

	function update()
	{
		$str = "
		UPDATE PROGRAM_ITEM_ASSESSMENT
		SET
		PROGRAM_ITEM_ASSESSMENT_ID= ".$this->getField("PROGRAM_ITEM_ASSESSMENT_ID")."
		, NAMA= '".$this->getField("NAMA")."'
		, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE= '".$this->getField("LAST_UPDATE_DATE")."'
		, KODE= '".$this->getField("KODE")."'
		, RATING= ".$this->getField("RATING")."
		WHERE PROGRAM_ITEM_ASSESSMENT_ID = '".$this->getField("PROGRAM_ITEM_ASSESSMENT_ID")."'
		"; 
		$this->query = $str;
			// echo $str;exit;
		return $this->execQuery($str);
	}

	function update_status()
	{
		$str = "
		UPDATE PROGRAM_ITEM_ASSESSMENT
		SET
		STATUS = ".$this->getField("STATUS")."
		WHERE PROGRAM_ITEM_ASSESSMENT_ID = '".$this->getField("PROGRAM_ITEM_ASSESSMENT_ID")."'
		"; 

		$this->query = $str;
		return $this->execQuery($str);
	}


	function delete()
	{
		$str = "
		DELETE FROM PROGRAM_ITEM_ASSESSMENT
		WHERE 
		PROGRAM_ITEM_ASSESSMENT_ID = ".$this->getField("PROGRAM_ITEM_ASSESSMENT_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY PROGRAM_ITEM_ASSESSMENT_ID ASC")
	{
		$str = "
			SELECT 
				A.*,
				CASE WHEN A.STATUS = 1 THEN 'Tidak  Aktif' ELSE 'Aktif' END STATUS_INFO
			FROM PROGRAM_ITEM_ASSESSMENT A 
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