<? 
include_once(APPPATH.'/models/Entity.php');

class PrioritasRekomendasi extends Entity { 

	var $query;

    function PrioritasRekomendasi()
	{
      	$this->Entity(); 
    }


    function insert()
    {
    	$this->setField("PRIORITAS_REKOMENDASI_ID", $this->getNextId("PRIORITAS_REKOMENDASI_ID","PRIORITAS_REKOMENDASI"));

    	$str = "
    	INSERT INTO PRIORITAS_REKOMENDASI
    	(
    		PRIORITAS_REKOMENDASI_ID,NAMA,LAST_CREATE_USER,LAST_CREATE_DATE,KODE
    	)
    	VALUES 
    	(
    		".$this->getField("PRIORITAS_REKOMENDASI_ID")."
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    	, '".$this->getField("KODE")."'
	    )"; 

	    $this->id= $this->getField("PRIORITAS_REKOMENDASI_ID");
	    $this->query= $str;
			// echo $str;exit;
	    return $this->execQuery($str);
	}

	
	function update()
	{
			$str = "
			UPDATE PRIORITAS_REKOMENDASI
			SET
			 NAMA= '".$this->getField("NAMA")."'
			, KODE= '".$this->getField("KODE")."'
			, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
			, LAST_UPDATE_DATE= '".$this->getField("LAST_UPDATE_DATE")."'
			WHERE PRIORITAS_REKOMENDASI_ID = '".$this->getField("PRIORITAS_REKOMENDASI_ID")."'
			"; 
			$this->query = $str;
			// echo $str;exit;
			return $this->execQuery($str);
	}

	function update_status()
	{
		$str = "
		UPDATE PRIORITAS_REKOMENDASI
		SET
		STATUS = ".$this->getField("STATUS")."
		WHERE PRIORITAS_REKOMENDASI_ID = '".$this->getField("PRIORITAS_REKOMENDASI_ID")."'
		"; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM PRIORITAS_REKOMENDASI
		WHERE 
		PRIORITAS_REKOMENDASI_ID = ".$this->getField("PRIORITAS_REKOMENDASI_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}


	function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY PRIORITAS_REKOMENDASI_ID ASC")
	{
		$str = "
			SELECT 
				A.*,
				CASE WHEN A.STATUS = 1 THEN 'Tidak  Aktif' ELSE 'Aktif' END STATUS_INFO
			FROM PRIORITAS_REKOMENDASI A 
			
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