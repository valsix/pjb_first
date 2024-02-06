<? 
  include_once(APPPATH.'/models/Entity.php');

  class UnitMesin extends Entity{ 

	var $query;

    function UnitMesin()
	{
      $this->Entity(); 
    }

    function insert()
    {
    	$this->setField("UNIT_MESIN_ID", $this->getNextId("UNIT_MESIN_ID","unit_mesin"));

    	$str = "
    	INSERT INTO unit_mesin
    	(
    		UNIT_MESIN_ID, NAMA, DISTRIK_ID,BLOK_UNIT_ID
    	)
    	VALUES 
    	(
	    	'".$this->getField("UNIT_MESIN_ID")."'
	    	, '".$this->getField("NAMA")."'
	    	, ".$this->getField("DISTRIK_ID")."
	    	, ".$this->getField("BLOK_UNIT_ID")."
	    )"; 

		$this->id= $this->getField("UNIT_MESIN_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function update()
	{
		$str = "
		UPDATE unit_mesin
		SET
		 NAMA= '".$this->getField("NAMA")."'
		, DISTRIK_ID= ".$this->getField("DISTRIK_ID")."
		, BLOK_UNIT_ID= ".$this->getField("BLOK_UNIT_ID")."
		WHERE UNIT_MESIN_ID = '".$this->getField("UNIT_MESIN_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function update_status()
	{
		$str = "
		UPDATE unit_mesin
		SET
		STATUS = ".$this->getField("STATUS")."
		WHERE UNIT_MESIN_ID = '".$this->getField("UNIT_MESIN_ID")."'
		"; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM unit_mesin
		WHERE 
		UNIT_MESIN_ID = ".$this->getField("UNIT_MESIN_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY UNIT_MESIN_ID ASC")
	{
		$str = "
		SELECT 
			A.*,B.NAMA DISTRIK_NAMA,C.NAMA UNIT_NAMA
			, CASE WHEN A.STATUS = 1 THEN 'Tidak  Aktif' ELSE 'Aktif' END STATUS_INFO
			, D.NAMA JENIS_NAMA
		FROM unit_mesin A
		INNER JOIN DISTRIK B ON B.DISTRIK_ID = A.DISTRIK_ID
		INNER JOIN BLOK_UNIT C ON C.BLOK_UNIT_ID = A.BLOK_UNIT_ID
		LEFT JOIN JENIS_UNIT_KERJA D ON D.JENIS_UNIT_KERJA_ID = C.JENIS_UNIT_KERJA_ID
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

    function getCountByParams($paramsArray=array())
	{
		$str = "SELECT COUNT(1) AS ROWCOUNT 
		FROM unit_mesin A
		INNER JOIN DISTRIK B ON B.DISTRIK_ID = A.DISTRIK_ID
		INNER JOIN BLOK_UNIT C ON C.BLOK_UNIT_ID = A.BLOK_UNIT_ID
		WHERE 1 = 1  "; 
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }

  } 
?>