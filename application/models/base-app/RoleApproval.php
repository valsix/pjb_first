<? 
include_once(APPPATH.'/models/Entity.php');

class RoleApproval extends Entity { 

	var $query;

    function RoleApproval()
	{
      	$this->Entity(); 
    }

    function insert()
    {
    	$this->setField("ROLE_ID", $this->getNextId("ROLE_ID","ROLE_APPROVAL"));

    	$str = "
    	INSERT INTO ROLE_APPROVAL
    	(
    		ROLE_ID, ROLE_NAMA, ROLE_DESK, CREATED_BY, CREATED_AT,STATUS
    	)
    	VALUES 
    	(
	    	'".$this->getField("ROLE_ID")."'
	    	, '".$this->getField("ROLE_NAMA")."'
	    	, '".$this->getField("ROLE_DESK")."'
	    	, '".$this->getField("CREATED_BY")."'
	    	, ".$this->getField("CREATED_AT")."
	    	, '".$this->getField("STATUS")."'
	    )"; 

		$this->id= $this->getField("ROLE_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function update()
	{
		$str = "
		UPDATE ROLE_APPROVAL
		SET
		ROLE_NAMA= '".$this->getField("ROLE_NAMA")."'
		, ROLE_DESK= '".$this->getField("ROLE_DESK")."'
		, UPDATED_BY= '".$this->getField("UPDATED_BY")."'
		, UPDATED_AT= ".$this->getField("UPDATED_AT")."
		, STATUS= '".$this->getField("STATUS")."'
		WHERE ROLE_ID = '".$this->getField("ROLE_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM ROLE_APPROVAL
		WHERE 
		ROLE_ID = ".$this->getField("ROLE_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY ROLE_ID ASC")
	{
		$str = "
			SELECT 
				A.*
			FROM ROLE_APPROVAL A 
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