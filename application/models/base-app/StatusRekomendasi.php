<? 
include_once(APPPATH.'/models/Entity.php');

class StatusRekomendasi extends Entity { 

	var $query;

    function StatusRekomendasi()
	{
      	$this->Entity(); 
    }


    function insert()
    {
    	$this->setField("STATUS_REKOMENDASI_ID", $this->getNextId("STATUS_REKOMENDASI_ID","STATUS_REKOMENDASI"));

    	$str = "
    	INSERT INTO STATUS_REKOMENDASI
    	(
    		STATUS_REKOMENDASI_ID,NAMA,LAST_CREATE_USER,LAST_CREATE_DATE,KODE
    	)
    	VALUES 
    	(
    		".$this->getField("STATUS_REKOMENDASI_ID")."
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    	, '".$this->getField("KODE")."'
	    )"; 

	    $this->id= $this->getField("STATUS_REKOMENDASI_ID");
	    $this->query= $str;
			// echo $str;exit;
	    return $this->execQuery($str);
	}

	
	function update()
	{
			$str = "
			UPDATE STATUS_REKOMENDASI
			SET
			 NAMA= '".$this->getField("NAMA")."'
			, KODE= '".$this->getField("KODE")."'
			, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
			, LAST_UPDATE_DATE= '".$this->getField("LAST_UPDATE_DATE")."'
			WHERE STATUS_REKOMENDASI_ID = '".$this->getField("STATUS_REKOMENDASI_ID")."'
			"; 
			$this->query = $str;
			// echo $str;exit;
			return $this->execQuery($str);
	}

	function update_status()
	{
		$str = "
		UPDATE STATUS_REKOMENDASI
		SET
		STATUS = ".$this->getField("STATUS")."
		WHERE STATUS_REKOMENDASI_ID = '".$this->getField("STATUS_REKOMENDASI_ID")."'
		"; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM STATUS_REKOMENDASI
		WHERE 
		STATUS_REKOMENDASI_ID = ".$this->getField("STATUS_REKOMENDASI_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}


	function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY STATUS_REKOMENDASI_ID ASC")
	{
		$str = "
			SELECT 
				A.*,
				CASE WHEN A.STATUS = 1 THEN 'Tidak  Aktif' ELSE 'Aktif' END STATUS_INFO
			FROM STATUS_REKOMENDASI A 
			
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