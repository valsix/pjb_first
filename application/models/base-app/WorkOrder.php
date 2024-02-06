<? 
include_once(APPPATH.'/models/Entity.php');

class WorkOrder extends Entity { 

	var $query;

    function WorkOrder()
	{
      	$this->Entity(); 
    }

    function insert()
    {
    	$this->setField("WORK_ORDER_ID", $this->getNextId("WORK_ORDER_ID","WORK_ORDER"));

    	$str = "
    	INSERT INTO WORK_ORDER
    	(
    		WORK_ORDER_ID, ASSET_NUM, WO, DESCRIPTION, STATUS,SITE_ID,EQUIPMENT_ID,PROJECT_NO,WORKTYPE
    	)
    	VALUES 
    	(
	    	".$this->getField("WORK_ORDER_ID")."
	    	, '".$this->getField("ASSET_NUM")."'
	    	, '".$this->getField("WO")."'
	    	, '".$this->getField("DESCRIPTION")."'
	    	, '".$this->getField("STATUS")."'
	    	, '".$this->getField("SITE_ID")."'
	    	, '".$this->getField("SITE_ID")."'
	    	, ".$this->getField("EQUIPMENT_ID")."
	    	, '".$this->getField("PROJECT_NO")."'
	    	, '".$this->getField("WORKTYPE")."'
	    )"; 

		$this->id= $this->getField("WORK_ORDER_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function update()
	{
		$str = "
			UPDATE WORK_ORDER
			SET
			ASSET_NUM= '".$this->getField("ASSET_NUM")."'
			, WO= '".$this->getField("WO")."'
			, DESCRIPTION= '".$this->getField("DESCRIPTION")."'
			, STATUS= '".$this->getField("STATUS")."'
			, SITE_ID= '".$this->getField("SITE_ID")."'
			, EQUIPMENT_ID= ".$this->getField("EQUIPMENT_ID")."
			, PROJECT_NO= '".$this->getField("PROJECT_NO")."'
			, WORKTYPE= '".$this->getField("WORKTYPE")."'
			WHERE WO = '".$this->getField("WO")."'
		"; 

		$this->query = $str;
		// echo $str;exit;

		return $this->execQuery($str);
	}

	function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY WO ASC")
	{
		$str = "
			SELECT 
				A.*
			FROM WORK_ORDER A 
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