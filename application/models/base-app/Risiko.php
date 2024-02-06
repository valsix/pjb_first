<? 
include_once(APPPATH.'/models/Entity.php');

class Risiko extends Entity { 

	var $query;

    function Risiko()
	{
      	$this->Entity(); 
    }

    function insert()
    {
    	$this->setField("RISIKO_ID", $this->getNextId("RISIKO_ID","RISIKO"));

    	$str = "
    	INSERT INTO RISIKO
    	(
    		RISIKO_ID,NAMA,LAST_CREATE_USER,LAST_CREATE_DATE,KODE,PERATURAN_ID
    	)
    	VALUES 
    	(
    		".$this->getField("RISIKO_ID")."
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    	, '".$this->getField("KODE")."'
	    	, ".$this->getField("PERATURAN_ID")."
	    )"; 

	    $this->id= $this->getField("RISIKO_ID");
	    $this->query= $str;
			// echo $str;exit;
	    return $this->execQuery($str);
	}

	function update()
	{
		$str = "
		UPDATE RISIKO
		SET
		RISIKO_ID= ".$this->getField("RISIKO_ID")."
		, NAMA= '".$this->getField("NAMA")."'
		, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE= '".$this->getField("LAST_UPDATE_DATE")."'
		, KODE= '".$this->getField("KODE")."'
		, PERATURAN_ID= ".$this->getField("PERATURAN_ID")."
		WHERE RISIKO_ID = '".$this->getField("RISIKO_ID")."'
		"; 
		$this->query = $str;
			// echo $str;exit;
		return $this->execQuery($str);
	}


	function update_status()
	{
		$str = "
		UPDATE RISIKO
		SET
		STATUS = ".$this->getField("STATUS")."
		WHERE RISIKO_ID = '".$this->getField("RISIKO_ID")."'
		"; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM RISIKO
		WHERE 
		RISIKO_ID = ".$this->getField("RISIKO_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY RISIKO_ID ASC")
	{
		$str = "
			SELECT 
				A.*,
				CASE WHEN A.STATUS = 1 THEN 'Tidak  Aktif' ELSE 'Aktif' END STATUS_INFO
				, B.NAMA PERATURAN_INFO
			FROM RISIKO A
			LEFT JOIN  PERATURAN B ON B.PERATURAN_ID = A.PERATURAN_ID
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