<? 
include_once(APPPATH.'/models/Entity.php');

class JenisUnitKerja extends Entity { 

	var $query;

    function JenisUnitKerja()
	{
      	$this->Entity(); 
    }


    function insert()
    {
    	$this->setField("JENIS_UNIT_KERJA_ID", $this->getNextId("JENIS_UNIT_KERJA_ID","JENIS_UNIT_KERJA"));

    	$str = "
    	INSERT INTO JENIS_UNIT_KERJA
    	(
    		JENIS_UNIT_KERJA_ID,NAMA,LAST_CREATE_USER,LAST_CREATE_DATE,KODE
    	)
    	VALUES 
    	(
    		".$this->getField("JENIS_UNIT_KERJA_ID")."
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    	, '".$this->getField("KODE")."'
	    )"; 

	    $this->id= $this->getField("JENIS_UNIT_KERJA_ID");
	    $this->query= $str;
			// echo $str;exit;
	    return $this->execQuery($str);
	}

	
	function update()
	{
			$str = "
			UPDATE JENIS_UNIT_KERJA
			SET
			 NAMA= '".$this->getField("NAMA")."'
			, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
			, LAST_UPDATE_DATE= '".$this->getField("LAST_UPDATE_DATE")."'
			, KODE= '".$this->getField("KODE")."'
			WHERE JENIS_UNIT_KERJA_ID = '".$this->getField("JENIS_UNIT_KERJA_ID")."'
			"; 
			$this->query = $str;
			// echo $str;exit;
			return $this->execQuery($str);
	}


	function update_status()
	{
		$str = "
		UPDATE JENIS_UNIT_KERJA
		SET
		STATUS = ".$this->getField("STATUS")."
		WHERE JENIS_UNIT_KERJA_ID = '".$this->getField("JENIS_UNIT_KERJA_ID")."'
		"; 

		$this->query = $str;
		return $this->execQuery($str);
	}


	function delete()
	{
		$str = "
		DELETE FROM JENIS_UNIT_KERJA
		WHERE 
		JENIS_UNIT_KERJA_ID = ".$this->getField("JENIS_UNIT_KERJA_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}


	function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY JENIS_UNIT_KERJA_ID ASC")
	{
		$str = "
			SELECT 
				A.*,
				CASE WHEN A.STATUS = 1 THEN 'Tidak  Aktif' ELSE 'Aktif' END STATUS_INFO
			FROM JENIS_UNIT_KERJA A 
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