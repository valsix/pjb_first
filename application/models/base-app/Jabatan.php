<? 
  include_once(APPPATH.'/models/Entity.php');

  class Jabatan extends Entity{ 

	var $query;

    function Jabatan()
	{
      $this->Entity(); 
    }

    function insert()
    {
    	$this->setField("JABATAN_ID", $this->getNextId("JABATAN_ID","jabatan"));

    	$str = "
    	INSERT INTO jabatan
    	(
    		JABATAN_ID,DISTRIK_ID, KODE, NAMA, KATEGORI, JENJANG, TIPE_UNIT
    	)
    	VALUES 
    	(
	    	".$this->getField("JABATAN_ID")."
	    	, ".$this->getField("DISTRIK_ID")."
	    	, '".$this->getField("KODE")."'
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("KATEGORI")."'
	    	, '".$this->getField("JENJANG")."'
	    	, '".$this->getField("TIPE_UNIT")."'
	    	, '".$this->getField("DIT_BID")."'
	    )"; 

		$this->id= $this->getField("JABATAN_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function update()
	{
		$str = "
		UPDATE jabatan
		SET
		JABATAN_ID= ".$this->getField("JABATAN_ID")."
		, DISTRIK_ID= ".$this->getField("DISTRIK_ID")."
		, KODE= '".$this->getField("KODE")."'
		, NAMA= '".$this->getField("NAMA")."'
		, KATEGORI= '".$this->getField("KATEGORI")."'
		, JENJANG= '".$this->getField("JENJANG")."'
		, TIPE_UNIT= '".$this->getField("TIPE_UNIT")."'
		, DIT_BID= '".$this->getField("DIT_BID")."'
		WHERE JABATAN_ID = '".$this->getField("JABATAN_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM jabatan
		WHERE 
		JABATAN_ID = ".$this->getField("JABATAN_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $jabatanment='', $sOrder="ORDER BY JABATAN_ID ASC")
	{
		$str = "
		SELECT 
			A.*,B.NAMA DISTRIK_NAMA,B.KODE || '-' || B.NAMA DISTRIK_INFO
			, CASE WHEN A.TIPE IS NULL THEN 'Eksternal' else 'Internal' END
			TIPE_INFO
		FROM jabatan A
		LEFT JOIN DISTRIK B ON B.DISTRIK_ID = A.DISTRIK_ID
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