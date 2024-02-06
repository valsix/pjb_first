<? 
include_once(APPPATH.'/models/Entity.php');

class KonfirmasiItemAssessment extends Entity { 

	var $query;

    function KonfirmasiItemAssessment()
	{
      	$this->Entity(); 
    }

    function insert()
    {
    	$this->setField("KONFIRMASI_ITEM_ASSESSMENT_ID", $this->getNextId("KONFIRMASI_ITEM_ASSESSMENT_ID","KONFIRMASI_ITEM_ASSESSMENT"));

    	$str = "
    	INSERT INTO KONFIRMASI_ITEM_ASSESSMENT
    	(
    		KONFIRMASI_ITEM_ASSESSMENT_ID,NAMA,KETERANGAN,LAST_CREATE_USER,LAST_CREATE_DATE,KODE,NILAI
    	)
    	VALUES 
    	(
    		".$this->getField("KONFIRMASI_ITEM_ASSESSMENT_ID")."
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("KETERANGAN")."'
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    	, '".$this->getField("KODE")."'
	    	, ".$this->getField("NILAI")."
	    )"; 

	    $this->id= $this->getField("KONFIRMASI_ITEM_ASSESSMENT_ID");
	    $this->query= $str;
			// echo $str;exit;
	    return $this->execQuery($str);
	}

	function update()
	{
		$str = "
		UPDATE KONFIRMASI_ITEM_ASSESSMENT
		SET
		KONFIRMASI_ITEM_ASSESSMENT_ID= ".$this->getField("KONFIRMASI_ITEM_ASSESSMENT_ID")."
		, NAMA= '".$this->getField("NAMA")."'
		, KETERANGAN= '".$this->getField("KETERANGAN")."'
		, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE= '".$this->getField("LAST_UPDATE_DATE")."'
		, KODE= '".$this->getField("KODE")."'
		, NILAI= ".$this->getField("NILAI")."
		WHERE KONFIRMASI_ITEM_ASSESSMENT_ID = '".$this->getField("KONFIRMASI_ITEM_ASSESSMENT_ID")."'
		"; 
		$this->query = $str;
			// echo $str;exit;
		return $this->execQuery($str);
	}


	function update_status()
	{
		$str = "
		UPDATE KONFIRMASI_ITEM_ASSESSMENT
		SET
		STATUS = ".$this->getField("STATUS")."
		WHERE KONFIRMASI_ITEM_ASSESSMENT_ID = '".$this->getField("KONFIRMASI_ITEM_ASSESSMENT_ID")."'
		"; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM KONFIRMASI_ITEM_ASSESSMENT
		WHERE 
		KONFIRMASI_ITEM_ASSESSMENT_ID = ".$this->getField("KONFIRMASI_ITEM_ASSESSMENT_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY KONFIRMASI_ITEM_ASSESSMENT_ID ASC")
	{
		$str = "
			SELECT 
				A.*,
				CASE WHEN A.STATUS = 1 THEN 'Tidak  Aktif' ELSE 'Aktif' END STATUS_INFO
			FROM KONFIRMASI_ITEM_ASSESSMENT A 
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