<? 
include_once(APPPATH.'/models/Entity.php');

class Kemungkinan extends Entity { 

	var $query;

    function Kemungkinan()
	{
      	$this->Entity(); 
    }

    function insert()
    {
    	$this->setField("KEMUNGKINAN_ID", $this->getNextId("KEMUNGKINAN_ID","KEMUNGKINAN"));

    	$str = "
    	INSERT INTO KEMUNGKINAN
    	(
    		KEMUNGKINAN_ID,NAMA,BOBOT,LAST_CREATE_USER,LAST_CREATE_DATE,KODE,PERATURAN_ID,N_MIN,N_MAX
    	)
    	VALUES 
    	(
    		".$this->getField("KEMUNGKINAN_ID")."
	    	, '".$this->getField("NAMA")."'
	    	, ".$this->getField("BOBOT")."
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    	, '".$this->getField("KODE")."'
	    	, ".$this->getField("PERATURAN_ID")."
	    	, ".$this->getField("N_MIN")."
	    	, ".$this->getField("N_MAX")."
	    )"; 

	    $this->id= $this->getField("KEMUNGKINAN_ID");
	    $this->query= $str;
			// echo $str;exit;
	    return $this->execQuery($str);
	}

	function update()
	{
		$str = "
		UPDATE KEMUNGKINAN
		SET
		KEMUNGKINAN_ID= ".$this->getField("KEMUNGKINAN_ID")."
		, NAMA= '".$this->getField("NAMA")."'
		, BOBOT= ".$this->getField("BOBOT")."
		, KODE= '".$this->getField("KODE")."'
		, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE= '".$this->getField("LAST_UPDATE_DATE")."'
		, PERATURAN_ID= ".$this->getField("PERATURAN_ID")."
		, N_MIN= ".$this->getField("N_MIN")."
		, N_MAX= ".$this->getField("N_MAX")."
		WHERE KEMUNGKINAN_ID = '".$this->getField("KEMUNGKINAN_ID")."'
		"; 
		$this->query = $str;
			// echo $str;exit;
		return $this->execQuery($str);
	}

	function update_status()
	{
		$str = "
		UPDATE KEMUNGKINAN
		SET
		STATUS = ".$this->getField("STATUS")."
		WHERE KEMUNGKINAN_ID = '".$this->getField("KEMUNGKINAN_ID")."'
		"; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM KEMUNGKINAN
		WHERE 
		KEMUNGKINAN_ID = ".$this->getField("KEMUNGKINAN_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY KEMUNGKINAN_ID ASC")
	{
		$str = "
			SELECT 
				A.*,
				CASE WHEN A.STATUS = 1 THEN 'Tidak  Aktif' ELSE 'Aktif' END STATUS_INFO
				, B.NAMA PERATURAN_INFO
			FROM KEMUNGKINAN A 
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