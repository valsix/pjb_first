<? 
  include_once(APPPATH.'/models/Entity.php');

  class ImportDinamis extends Entity{ 

	var $query;

    function ImportDinamis()
	{
      $this->Entity(); 
    }

    function insertdetil()
    {
    	$this->setField("DISTRIK_ID", $this->getNextId("DISTRIK_ID","distrik"));

    	$str = "
    	INSERT INTO distrik
    	(
    		DISTRIK_ID, NAMA, KODE , PERUSAHAAN_EKSTERNAL_ID, LAST_CREATE_USER, LAST_CREATE_DATE
    	)
    	VALUES 
    	(
	    	'".$this->getField("DISTRIK_ID")."'
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("KODE")."'
	    	, ".$this->getField("PERUSAHAAN_EKSTERNAL_ID")."
	    	, '".$this->getField("LAST_CREATE_USER")."'
	    	, ".$this->getField("LAST_CREATE_DATE")."
	    )"; 

		$this->id= $this->getField("DISTRIK_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}


	function updatedetil()
	{
		$str = "
		UPDATE distrik
		SET
		NAMA= '".$this->getField("NAMA")."'
		, PERUSAHAAN_EKSTERNAL_ID= ".$this->getField("PERUSAHAAN_EKSTERNAL_ID")."
		, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
		, LAST_UPDATE_DATE= ".$this->getField("LAST_UPDATE_DATE")."
		WHERE DISTRIK_ID = '".$this->getField("DISTRIK_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}


    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $jabatanment='', $sOrder="ORDER BY TABEL_TEMPLATE_ID ASC")
	{
		$str = "
		SELECT 
			A.*
		FROM tabel_template A
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $jabatanment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }




  } 
?>