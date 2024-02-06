<? 
include_once(APPPATH.'/models/Entity.php');

class FlowApproval extends Entity { 

	var $query;

    function FlowApproval()
	{
      	$this->Entity(); 
    }

    function insert()
    {
    	$this->setField("FLOW_ID", $this->getNextId("FLOW_ID","FLOW_APPROVAL"));

    	$str = "
    	INSERT INTO FLOW_APPROVAL
    	(
    		FLOW_ID, REF_TABEL, REF_DESK, JP_ID
    	)
    	VALUES 
    	(
	    	'".$this->getField("FLOW_ID")."'
	    	, '".$this->getField("REF_TABEL")."'
	    	, '".$this->getField("REF_DESK")."'
	    	, ".$this->getField("JP_ID")."
	    )"; 

			$this->id= $this->getField("FLOW_ID");
			$this->query= $str;
			// echo $str;exit;
			return $this->execQuery($str);
	}

	function insert_detil()
    {
    	$this->setField("FLOWD_ID", $this->getNextId("FLOWD_ID","FLOW_APPDETAIL"));

    	$str = "
    	INSERT INTO FLOW_APPDETAIL
    	(
    		FLOWD_ID, FLOW_ID, ROLE_ID, FLOWD_INDEX
    	)
    	VALUES 
    	(
	    	'".$this->getField("FLOWD_ID")."'
	    	, '".$this->getField("FLOW_ID")."'
	    	, '".$this->getField("ROLE_ID")."'
	    	, ".$this->getField("FLOWD_INDEX")."
	    )"; 

			$this->id= $this->getField("FLOWD_ID");
			$this->query= $str;
			// echo $str;exit;
			return $this->execQuery($str);
	}

	function update()
	{
			$str = "
			UPDATE FLOW_APPROVAL
			SET
			REF_TABEL= '".$this->getField("REF_TABEL")."'
			, REF_DESK= '".$this->getField("REF_DESK")."'
			, JP_ID= ".$this->getField("JP_ID")."
			WHERE FLOW_ID = '".$this->getField("FLOW_ID")."'
			"; 
			$this->query = $str;
			// echo $str;exit;
			return $this->execQuery($str);
	}

	function update_insert()
	{
			$str = "
			UPDATE FLOW_APPDETAIL
			SET
			ROLE_ID= '".$this->getField("ROLE_ID")."'
			, FLOWD_INDEX= '".$this->getField("FLOWD_INDEX")."'
			WHERE FLOWD_ID = '".$this->getField("FLOWD_ID")."'
			"; 
			$this->query = $str;
			// echo $str;exit;
			return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM FLOW_APPROVAL
		WHERE 
		FLOW_ID = ".$this->getField("FLOW_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function delete_detil()
	{
		$str = "
		DELETE FROM flow_appdetail
		WHERE 
		FLOWD_ID = ".$this->getField("FLOWD_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY FLOW_ID ASC")
	{
		$str = "
			SELECT 
				A.*, B.MENU_MODUL
			FROM FLOW_APPROVAL A 
			LEFT JOIN PENGGUNA_MODUL B ON B.KODE_MODUL = A.REF_TABEL
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

	function selectByParamsDetil($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY FLOWD_INDEX ASC")
	{
		$str = "
			SELECT 
				A.*, b.role_nama nama_role
			FROM flow_appdetail A 
			LEFT join role_approval b on a.role_id=b.role_id
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