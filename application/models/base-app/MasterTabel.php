<? 
  include_once(APPPATH.'/models/Entity.php');

  class MasterTabel extends Entity{ 

	var $query;

    function MasterTabel()
	{
      $this->Entity(); 
    }


    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $unitment='', $sOrder="ORDER BY MASTER_TABEL_ID ASC")
	{
		$str = "
		SELECT 
			A.*
		FROM MASTER_TABEL A
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

  } 
?>