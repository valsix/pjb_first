<? 
  include_once(APPPATH.'/models/Entity.php');

  class LogGenerate extends Entity{ 

	var $query;

    function LogGenerate()
	{
      $this->Entity(); 
    }

   
	function insert()
	{
	    $this->setField("LOG_GENERATE_ID", $this->getNextId("LOG_GENERATE_ID","LOG_GENERATE")); 

	    $str = "
	    INSERT INTO LOG_GENERATE 
	    (
	        LOG_GENERATE_ID,TABLE_GENERATE,USER_GENERATE,DATE_GENERATE,BERHASIL_GENERATE,GAGAL_GENERATE
	    )
	    VALUES 
	    (
	      '".$this->getField("LOG_GENERATE_ID")."',
	      '".$this->getField("TABLE_GENERATE")."',
	      '".$this->getField("USER_GENERATE")."',
	      ".$this->getField("DATE_GENERATE").",
	      ".$this->getField("BERHASIL_GENERATE").",
	      ".$this->getField("GAGAL_GENERATE")."

	    )"; 
	    $this->id= $this->getField("LOG_GENERATE_ID");
	    $this->query= $str;
	    // echo $str;exit;
	    return $this->execQuery($str);
	 }




  } 
?>