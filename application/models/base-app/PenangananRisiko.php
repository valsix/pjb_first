<? 
include_once(APPPATH.'/models/Entity.php');

class PenangananRisiko extends Entity { 

	var $query;

    function PenangananRisiko()
	{
      	$this->Entity(); 
    }

    function insert()
    {
    	$this->setField("PENANGANAN_RISIKO_ID", $this->getNextId("PENANGANAN_RISIKO_ID","PENANGANAN_RISIKO"));

    	$str = "
    	INSERT INTO PENANGANAN_RISIKO
    	(
    		PENANGANAN_RISIKO_ID,RISIKO_ID,KODE_WARNA,STATUS,LAST_CREATE_USER,LAST_CREATE_DATE
    	)
    	VALUES 
    	(
    		".$this->getField("PENANGANAN_RISIKO_ID")."
	    	, ".$this->getField("RISIKO_ID")."
	    	, '".$this->getField("KODE_WARNA")."'
	    	, ".$this->getField("STATUS")."
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    )"; 

	    $this->id= $this->getField("PENANGANAN_RISIKO_ID");
	    $this->query= $str;
			// echo $str;exit;
	    return $this->execQuery($str);
	}

	function update()
	{
		$str = "
		UPDATE PENANGANAN_RISIKO
		SET
		PENANGANAN_RISIKO_ID= ".$this->getField("PENANGANAN_RISIKO_ID")."
		, RISIKO_ID= ".$this->getField("RISIKO_ID")."
		, KODE_WARNA= '".$this->getField("KODE_WARNA")."'
		, STATUS= ".$this->getField("STATUS")."
		, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE= '".$this->getField("LAST_UPDATE_DATE")."'
		WHERE PENANGANAN_RISIKO_ID = '".$this->getField("PENANGANAN_RISIKO_ID")."'
		"; 
		$this->query = $str;
			// echo $str;exit;
		return $this->execQuery($str);
	}


	function update_status()
	{
		$str = "
		UPDATE PENANGANAN_RISIKO
		SET
		STATUS = ".$this->getField("STATUS")."
		WHERE PENANGANAN_RISIKO_ID = '".$this->getField("PENANGANAN_RISIKO_ID")."'
		"; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM PENANGANAN_RISIKO
		WHERE 
		PENANGANAN_RISIKO_ID = ".$this->getField("PENANGANAN_RISIKO_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY PENANGANAN_RISIKO_ID ASC")
	{
		$str = "
			SELECT 
				A.*,
				CASE WHEN A.STATUS = 1 THEN 'Tidak  Aktif' ELSE 'Aktif' END STATUS_INFO
				, B.NAMA RISIKO_INFO
			FROM PENANGANAN_RISIKO A
			LEFT JOIN  RISIKO B ON B.RISIKO_ID = A.RISIKO_ID
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