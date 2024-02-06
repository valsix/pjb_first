<? 
  include_once(APPPATH.'/models/Entity.php');

  class Pengaturan extends Entity{ 

	var $query;

    function Pengaturan()
	{
      $this->Entity(); 
    }

    function selectByParamsFormula($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY FORMULA_ID ASC")
	{
		$str = "
		SELECT
			FORMULA_ID, FORMULA, TAHUN, TIPE, KETERANGAN, TIPE_FORMULA TIPE_FORMULA_ID,
			CASE 
			WHEN TIPE_FORMULA = '1' THEN 'Pengisian Jabatan' 
			WHEN TIPE_FORMULA = '2' THEN 'Pemetaan Kompetensi'
			else 
			'-'
			END TIPE_FORMULA 
		FROM formula_assesment A
		WHERE 1=1 "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		$this->query = $str;
		// echo $str;exit;
				
		return $this->selectLimit($str,$limit,$from); 
    }
        
  } 
?>