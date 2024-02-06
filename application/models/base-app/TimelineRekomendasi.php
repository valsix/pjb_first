<? 
include_once(APPPATH.'/models/Entity.php');

class TimelineRekomendasi extends Entity { 

	var $query;

    function TimelineRekomendasi()
	{
      	$this->Entity(); 
    }


    function insert()
    {
    	$this->setField("TIMELINE_REKOMENDASI_ID", $this->getNextId("TIMELINE_REKOMENDASI_ID","TIMELINE_REKOMENDASI"));

    	$str = "
    	INSERT INTO TIMELINE_REKOMENDASI
    	(
    		TIMELINE_REKOMENDASI_ID,NAMA,TAHUN,LAST_CREATE_USER,LAST_CREATE_DATE,KODE
    	)
    	VALUES 
    	(
    		".$this->getField("TIMELINE_REKOMENDASI_ID")."
	    	, '".$this->getField("NAMA")."'
	    	, ".$this->getField("TAHUN")."
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    	, '".$this->getField("KODE")."'
	    )"; 

	    $this->id= $this->getField("TIMELINE_REKOMENDASI_ID");
	    $this->query= $str;
			// echo $str;exit;
	    return $this->execQuery($str);
	}

	
	function update()
	{
			$str = "
			UPDATE TIMELINE_REKOMENDASI
			SET
			 NAMA= '".$this->getField("NAMA")."'
			, KODE= '".$this->getField("KODE")."'
			, TAHUN= ".$this->getField("TAHUN")."
			, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
			, LAST_UPDATE_DATE= '".$this->getField("LAST_UPDATE_DATE")."'
			WHERE TIMELINE_REKOMENDASI_ID = '".$this->getField("TIMELINE_REKOMENDASI_ID")."'
			"; 
			$this->query = $str;
			// echo $str;exit;
			return $this->execQuery($str);
	}


	function update_status()
	{
		$str = "
		UPDATE TIMELINE_REKOMENDASI
		SET
		STATUS = ".$this->getField("STATUS")."
		WHERE TIMELINE_REKOMENDASI_ID = '".$this->getField("TIMELINE_REKOMENDASI_ID")."'
		"; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM TIMELINE_REKOMENDASI
		WHERE 
		TIMELINE_REKOMENDASI_ID = ".$this->getField("TIMELINE_REKOMENDASI_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}


	function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY TIMELINE_REKOMENDASI_ID ASC")
	{
		$str = "
			SELECT 
				A.*,
				CASE WHEN A.STATUS = 1 THEN 'Tidak  Aktif' ELSE 'Aktif' END STATUS_INFO
			FROM TIMELINE_REKOMENDASI A 
			
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