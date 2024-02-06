<? 
  include_once(APPPATH.'/models/Entity.php');

  class Blok extends Entity{ 

	var $query;

    function Blok()
	{
      $this->Entity(); 
    }

    function insert()
    {
    	$this->setField("BLOK_ID", $this->getNextId("BLOK_ID","blok"));

    	$str = "
    	INSERT INTO blok
    	(
    		BLOK_ID,DISTRIK_ID, KODE,NAMA,JENIS_ENTERPRISE,URL
    	)
    	VALUES 
    	(
	    	".$this->getField("BLOK_ID")."
	    	, ".$this->getField("DISTRIK_ID")."
	    	, '".$this->getField("KODE")."'
	    	, '".$this->getField("NAMA")."'
	    	, ".$this->getField("JENIS_ENTERPRISE")."
	    	, '".$this->getField("URL")."'
	    )"; 

		$this->id= $this->getField("BLOK_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function update()
	{
		$str = "
		UPDATE blok
		SET
		DISTRIK_ID= ".$this->getField("DISTRIK_ID")."
		, KODE= '".$this->getField("KODE")."'
		, NAMA= '".$this->getField("NAMA")."'
		, JENIS_ENTERPRISE= ".$this->getField("JENIS_ENTERPRISE")."
		, URL= '".$this->getField("URL")."'
		WHERE BLOK_ID = '".$this->getField("BLOK_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM blok
		WHERE 
		BLOK_ID = ".$this->getField("BLOK_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $blokment='', $sOrder="ORDER BY BLOK_ID ASC")
	{
		$str = "
		SELECT 
			A.*,B.NAMA DISTRIK_NAMA,B.KODE DISTRIK_INFO
			--, CASE WHEN A.JENIS_ENTERPRISE = 1 THEN 'Ellipse' ELSE 'Maximo' END JENIS_INFO
			, C.NAMA EAM_NAMA, C.URL EAM_URL, C.EAM_ID
		FROM blok A
		LEFT JOIN DISTRIK B ON B.DISTRIK_ID = A.DISTRIK_ID 
		LEFT JOIN EAM C ON C.EAM_ID = A.JENIS_ENTERPRISE
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $blokment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

  } 
?>