<? 
  include_once(APPPATH.'/models/Entity.php');

  class SubMesin extends Entity{ 

	var $query;

    function SubMesin()
	{
      $this->Entity(); 
    }

    function insert()
    {
    	$this->setField("SUB_MESIN_ID", $this->getNextId("SUB_MESIN_ID","sub_mesin"));

    	$str = "
    	INSERT INTO sub_mesin
    	(
    		SUB_MESIN_ID, NAMA, DISTRIK_ID,BLOK_UNIT_ID,UNIT_MESIN_ID
    	)
    	VALUES 
    	(
	    	'".$this->getField("SUB_MESIN_ID")."'
	    	, '".$this->getField("NAMA")."'
	    	, ".$this->getField("DISTRIK_ID")."
	    	, ".$this->getField("BLOK_UNIT_ID")."
	    	, ".$this->getField("UNIT_MESIN_ID")."
	    )"; 

		$this->id= $this->getField("SUB_MESIN_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function update()
	{
		$str = "
		UPDATE sub_mesin
		SET
		 NAMA= '".$this->getField("NAMA")."'
		, DISTRIK_ID= ".$this->getField("DISTRIK_ID")."
		, BLOK_UNIT_ID= ".$this->getField("BLOK_UNIT_ID")."
		, UNIT_MESIN_ID= ".$this->getField("UNIT_MESIN_ID")."
		WHERE SUB_MESIN_ID = '".$this->getField("SUB_MESIN_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function update_status()
	{
		$str = "
		UPDATE sub_mesin
		SET
		STATUS = ".$this->getField("STATUS")."
		WHERE SUB_MESIN_ID = '".$this->getField("SUB_MESIN_ID")."'
		"; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM sub_mesin
		WHERE 
		SUB_MESIN_ID = ".$this->getField("SUB_MESIN_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY SUB_MESIN_ID ASC")
	{
		$str = "
		SELECT 
			A.*,B.NAMA DISTRIK_NAMA,C.NAMA UNIT_NAMA,D.NAMA MESIN_NAMA
			, CASE WHEN A.STATUS = 1 THEN 'Tidak  Aktif' ELSE 'Aktif' END STATUS_INFO
		FROM sub_mesin A
		INNER JOIN DISTRIK B ON B.DISTRIK_ID = A.DISTRIK_ID
		INNER JOIN BLOK_UNIT C ON C.BLOK_UNIT_ID = A.BLOK_UNIT_ID
		INNER JOIN UNIT_MESIN D ON D.UNIT_MESIN_ID = A.UNIT_MESIN_ID
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
		FROM sub_mesin A
		INNER JOIN DISTRIK B ON B.DISTRIK_ID = A.DISTRIK_ID
		INNER JOIN BLOK_UNIT C ON C.BLOK_UNIT_ID = A.BLOK_UNIT_ID
		INNER JOIN UNIT_MESIN D ON D.UNIT_MESIN_ID = A.UNIT_MESIN_ID
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