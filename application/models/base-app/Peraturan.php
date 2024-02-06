<? 
include_once(APPPATH.'/models/Entity.php');

class Peraturan extends Entity { 

	var $query;

    function Peraturan()
	{
      	$this->Entity(); 
    }

    function insert()
    {
    	$this->setField("PERATURAN_ID", $this->getNextId("PERATURAN_ID","PERATURAN"));

    	$str = "
    	INSERT INTO PERATURAN
    	(
    		PERATURAN_ID,NAMA,LAST_CREATE_USER,LAST_CREATE_DATE
    	)
    	VALUES 
    	(
    		".$this->getField("PERATURAN_ID")."
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    )"; 

	    $this->id= $this->getField("PERATURAN_ID");
	    $this->query= $str;
			// echo $str;exit;
	    return $this->execQuery($str);
	}

	function update()
	{
		$str = "
		UPDATE PERATURAN
		SET
		PERATURAN_ID= ".$this->getField("PERATURAN_ID")."
		, NAMA= '".$this->getField("NAMA")."'
		, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE= '".$this->getField("LAST_UPDATE_DATE")."'
		WHERE PERATURAN_ID = '".$this->getField("PERATURAN_ID")."'
		"; 
		$this->query = $str;
			// echo $str;exit;
		return $this->execQuery($str);
	}

	function update_status()
	{
		$str = "
		UPDATE PERATURAN
		SET
		STATUS = ".$this->getField("STATUS")."
		WHERE PERATURAN_ID = '".$this->getField("PERATURAN_ID")."'
		"; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function update_status_new()
	{

		$str = "
		UPDATE PERATURAN
		SET
		STATUS = ".$this->getField("STATUS_NEW")."
		WHERE PERATURAN_ID IS NOT NULL ;
		"; 

		$str .= "
		UPDATE PERATURAN
		SET
		STATUS = ".$this->getField("STATUS")."
		WHERE PERATURAN_ID = '".$this->getField("PERATURAN_ID")."' ;
		";

		// echo $str;exit;

		

		$this->query = $str;
		return $this->execQuery($str);
	}


	function delete()
	{
		$str = "
		DELETE FROM PERATURAN
		WHERE 
		PERATURAN_ID = ".$this->getField("PERATURAN_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY PERATURAN_ID ASC")
	{
		$str = "
			SELECT 
				A.*,
				CASE WHEN A.STATUS = 1 THEN 'Tidak  Aktif' ELSE 'Aktif' END STATUS_INFO
			FROM PERATURAN A 
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