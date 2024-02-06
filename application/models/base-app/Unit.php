<? 
  include_once(APPPATH.'/models/Entity.php');

  class Unit extends Entity{ 

	var $query;

    function Unit()
	{
      $this->Entity(); 
    }

    function insert()
    {
    	$this->setField("UNIT_ID", $this->getNextId("UNIT_ID","unit"));

    	$str = "
    	INSERT INTO unit
    	(
    		UNIT_ID, KODE,NAMA
    	)
    	VALUES 
    	(
	    	".$this->getField("UNIT_ID")."
	    	, '".$this->getField("KODE")."'
	    	, '".$this->getField("NAMA")."'
	    )"; 

		$this->id= $this->getField("UNIT_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function update()
	{
		$str = "
		UPDATE unit
		SET
		UNIT_ID= ".$this->getField("UNIT_ID")."
		, KODE= '".$this->getField("KODE")."'
		, NAMA= '".$this->getField("NAMA")."'
		WHERE UNIT_ID = '".$this->getField("UNIT_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM unit
		WHERE 
		UNIT_ID = ".$this->getField("UNIT_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $unitment='', $sOrder="ORDER BY UNIT_ID ASC")
	{
		$str = "
		SELECT 
			A.*
		FROM unit A
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $unitment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

    function getCountByParams($paramsArray=array())
	{
		$str = "SELECT COUNT(1) AS ROWCOUNT 
		FROM unit a
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