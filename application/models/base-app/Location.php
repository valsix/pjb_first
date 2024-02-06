<? 
include_once(APPPATH.'/models/Entity.php');

class Location extends Entity { 

	var $query;

    function Location()
	{
      	$this->Entity(); 
    }

    function insert()
    {
    	$this->setField("LOCATION_ID", $this->getNextId("LOCATION_ID","LOCATION"));

    	$str = "
    	INSERT INTO LOCATION
    	(
    		LOCATION_ID,EAM_ID,KODE_LOCATION,DESKRIPSI_LOCATION,LAST_CREATE_USER,LAST_CREATE_DATE
    	)
    	VALUES 
    	(
    		".$this->getField("LOCATION_ID")."
    		,".$this->getField("EAM_ID")."
    		, '".$this->getField("KODE_LOCATION")."'
	    	, '".$this->getField("DESKRIPSI_LOCATION")."'
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    )"; 

	    $this->id= $this->getField("LOCATION_ID");
	    $this->query= $str;
			// echo $str;exit;
	    return $this->execQuery($str);
	}

	function update()
	{
		$str = "
		UPDATE LOCATION
		SET
		EAM_ID= ".$this->getField("EAM_ID")."
		, KODE_LOCATION= '".$this->getField("KODE_LOCATION")."'
		, DESKRIPSI_LOCATION= '".$this->getField("DESKRIPSI_LOCATION")."'
		, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE= '".$this->getField("LAST_UPDATE_DATE")."'
		WHERE LOCATION_ID = '".$this->getField("LOCATION_ID")."'
		"; 
		$this->query = $str;
			// echo $str;exit;
		return $this->execQuery($str);
	}


	function update_status()
	{
		$str = "
		UPDATE location
		SET
		STATUS = ".$this->getField("STATUS")."
		WHERE LOCATION_ID = '".$this->getField("LOCATION_ID")."'
		"; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM LOCATION
		WHERE 
		LOCATION_ID = ".$this->getField("LOCATION_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY LOCATION_ID ASC")
	{
		$str = "
			SELECT 
				A.*,B.NAMA EAM_NAMA,
				CASE WHEN A.STATUS = 1 THEN 'Tidak  Aktif' ELSE 'Aktif' END STATUS_INFO
				, A.KODE_LOCATION || ' - ' || A.DESKRIPSI_LOCATION LOCATION_NAMA
			FROM LOCATION A
			LEFT JOIN EAM B ON B.EAM_ID = A.EAM_ID 
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