<? 
include_once(APPPATH.'/models/Entity.php');

class Dampak extends Entity { 

	var $query;

    function Dampak()
	{
      	$this->Entity(); 
    }

    function insert()
    {
    	$this->setField("DAMPAK_ID", $this->getNextId("DAMPAK_ID","DAMPAK"));

    	$str = "
    	INSERT INTO DAMPAK
    	(
    		DAMPAK_ID,NAMA,BOBOT,LAST_CREATE_USER,LAST_CREATE_DATE,KODE,PERATURAN_ID,N_MIN,N_MAX
    	)
    	VALUES 
    	(
    		".$this->getField("DAMPAK_ID")."
	    	, '".$this->getField("NAMA")."'
	    	, ".$this->getField("BOBOT")."
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    	, '".$this->getField("KODE")."'
	    	, ".$this->getField("PERATURAN_ID")."
	    	, ".$this->getField("N_MIN")."
	    	, ".$this->getField("N_MAX")."
	    )"; 

	    $this->id= $this->getField("DAMPAK_ID");
	    $this->query= $str;
			// echo $str;exit;
	    return $this->execQuery($str);
	}

	function update()
	{
		$str = "
		UPDATE DAMPAK
		SET
		DAMPAK_ID= ".$this->getField("DAMPAK_ID")."
		, NAMA= '".$this->getField("NAMA")."'
		, BOBOT= ".$this->getField("BOBOT")."
		, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE= '".$this->getField("LAST_UPDATE_DATE")."'
		, KODE= '".$this->getField("KODE")."'
		, PERATURAN_ID= ".$this->getField("PERATURAN_ID")."
		, N_MIN= ".$this->getField("N_MIN")."
		, N_MAX= ".$this->getField("N_MAX")."
		WHERE DAMPAK_ID = '".$this->getField("DAMPAK_ID")."'
		"; 
		$this->query = $str;
			// echo $str;exit;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM DAMPAK
		WHERE 
		DAMPAK_ID = ".$this->getField("DAMPAK_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}


	function update_status()
	{
		$str = "
		UPDATE DAMPAK
		SET
		STATUS = ".$this->getField("STATUS")."
		WHERE DAMPAK_ID = '".$this->getField("DAMPAK_ID")."'
		"; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY DAMPAK_ID ASC")
	{
		$str = "
			SELECT 
				A.*,
				CASE WHEN A.STATUS = 1 THEN 'Tidak  Aktif' ELSE 'Aktif' END STATUS_INFO
				, B.NAMA PERATURAN_INFO
			FROM DAMPAK A 
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