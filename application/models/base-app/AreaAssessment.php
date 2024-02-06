<? 
include_once(APPPATH.'/models/Entity.php');

class AreaAssessment extends Entity { 

	var $query;

    function AreaAssessment()
	{
      	$this->Entity(); 
    }


    function insert()
    {
    	$this->setField("AREA_ASSESSMENT_ID", $this->getNextId("AREA_ASSESSMENT_ID","AREA_ASSESSMENT"));

    	$str = "
    	INSERT INTO AREA_ASSESSMENT
    	(
    		AREA_ASSESSMENT_ID,ASSET_ID,NAMA,GROUPING,LAST_CREATE_USER,LAST_CREATE_DATE
    	)
    	VALUES 
    	(
    		".$this->getField("AREA_ASSESSMENT_ID")."
    		, ".$this->getField("ASSET_ID")."
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("GROUPING")."'
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    )"; 

	    $this->id= $this->getField("AREA_ASSESSMENT_ID");
	    $this->query= $str;
			// echo $str;exit;
	    return $this->execQuery($str);
	}

	function insertarea()
    {
    	$this->setField("AREA_ASSESSMENT_AREA_ID", $this->getNextId("AREA_ASSESSMENT_AREA_ID","AREA_ASSESSMENT_AREA"));

    	$str = "
    	INSERT INTO AREA_ASSESSMENT_AREA
    	(
    		AREA_ASSESSMENT_AREA_ID,AREA_ASSESSMENT_ID,AREA_ID
    	)
    	VALUES 
    	(
    		".$this->getField("AREA_ASSESSMENT_AREA_ID")."
    		, ".$this->getField("AREA_ASSESSMENT_ID")."
    		, ".$this->getField("AREA_ID")."
	    )"; 

	    $this->id= $this->getField("AREA_ASSESSMENT_AREA_ID");
	    $this->query= $str;
			// echo $str;exit;
	    return $this->execQuery($str);
	}


	function insertdistrik()
    {
    	$this->setField("AREA_ASSESSMENT_DISTRIK_ID", $this->getNextId("AREA_ASSESSMENT_DISTRIK_ID","AREA_ASSESSMENT_DISTRIK"));

    	$str = "
    	INSERT INTO AREA_ASSESSMENT_DISTRIK
    	(
    		AREA_ASSESSMENT_DISTRIK_ID,AREA_ASSESSMENT_ID,DISTRIK_ID
    	)
    	VALUES 
    	(
    		".$this->getField("AREA_ASSESSMENT_DISTRIK_ID")."
    		, ".$this->getField("AREA_ASSESSMENT_ID")."
    		, ".$this->getField("DISTRIK_ID")."
	    )"; 

	    $this->id= $this->getField("AREA_ASSESSMENT_DISTRIK_ID");
	    $this->query= $str;
			// echo $str;exit;
	    return $this->execQuery($str);
	}

	function update()
	{
		$str = "
		UPDATE AREA_ASSESSMENT
		SET
		ASSET_ID= ".$this->getField("ASSET_ID")."
		, LOCATION_ID= ".$this->getField("LOCATION_ID")."
		, NAMA= '".$this->getField("NAMA")."'
		, GROUPING= '".$this->getField("GROUPING")."'
		, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE= '".$this->getField("LAST_UPDATE_DATE")."'
		WHERE AREA_ASSESSMENT_ID = '".$this->getField("AREA_ASSESSMENT_ID")."'
		"; 
		$this->query = $str;
			// echo $str;exit;
		return $this->execQuery($str);
	}

	function update_status()
	{
		$str = "
		UPDATE AREA_ASSESSMENT
		SET
		STATUS = ".$this->getField("STATUS")."
		WHERE AREA_ASSESSMENT_ID = '".$this->getField("AREA_ASSESSMENT_ID")."'
		"; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM AREA_ASSESSMENT
		WHERE 
		AREA_ASSESSMENT_ID = ".$this->getField("AREA_ASSESSMENT_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}


	function deletearea()
	{
		$str = "
		DELETE FROM AREA_ASSESSMENT_AREA
		WHERE 
		AREA_ASSESSMENT_ID = ".$this->getField("AREA_ASSESSMENT_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}


	function deletedistrik()
	{
		$str = "
		DELETE FROM AREA_ASSESSMENT_DISTRIK
		WHERE 
		AREA_ASSESSMENT_ID = ".$this->getField("AREA_ASSESSMENT_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY AREA_ASSESSMENT_ID ASC")
	{
		$str = "
			SELECT 
				A.*,
				CASE WHEN A.STATUS = 1 THEN 'Tidak  Aktif' ELSE 'Aktif' END STATUS_INFO
				, B.NAMA AREA_NAMA
			FROM AREA_ASSESSMENT A
			LEFT JOIN AREA B ON B.AREA_ID = A.AREA_ID 
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


	function selectByParamsArea($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY AREA_ASSESSMENT_AREA_ID ASC")
	{
		$str = "
			SELECT 
				A.*,B.NAMA
			FROM AREA_ASSESSMENT_AREA A
			LEFT JOIN AREA B ON B.AREA_ID = A.AREA_ID
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


	function selectByParamsDistrik($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY AREA_ASSESSMENT_DISTRIK_ID ASC")
	{
		$str = "
			SELECT 
				A.*,B.NAMA,B.KODE
			FROM AREA_ASSESSMENT_DISTRIK A
			LEFT JOIN DISTRIK B ON B.DISTRIK_ID = A.DISTRIK_ID
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