<? 
  include_once(APPPATH.'/models/Entity.php');

  class Distrik extends Entity{ 

	var $query;

    function Distrik()
	{
      $this->Entity(); 
    }

    function insert()
    {
    	$this->setField("DISTRIK_ID", $this->getNextId("DISTRIK_ID","distrik"));

    	$str = "
    	INSERT INTO distrik
    	(
    		DISTRIK_ID, KODE_SITE, NAMA, KODE, WILAYAH_ID, PERUSAHAAN_EKSTERNAL_ID, LOCATION_ID,DIREKTORAT_ID
    	)
    	VALUES 
    	(
	    	'".$this->getField("DISTRIK_ID")."'
	    	, '".$this->getField("KODE_SITE")."'
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("KODE")."'
	    	, ".$this->getField("WILAYAH_ID")."
	    	, ".$this->getField("PERUSAHAAN_EKSTERNAL_ID")."
	    	, ".$this->getField("LOCATION_ID")."
	    	, ".$this->getField("DIREKTORAT_ID")."
	    )"; 

		$this->id= $this->getField("DISTRIK_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function insertjenis()
    {
    	$this->setField("DISTRIK_JENIS_UNIT_ID", $this->getNextId("DISTRIK_JENIS_UNIT_ID","distrik_jenis_unit"));

    	$str = "
    	INSERT INTO DISTRIK_JENIS_UNIT
    	(
    		DISTRIK_JENIS_UNIT_ID, DISTRIK_ID, JENIS_UNIT_KERJA_ID
    	)
    	VALUES 
    	(
	    	".$this->getField("DISTRIK_JENIS_UNIT_ID")."
	    	, ".$this->getField("DISTRIK_ID")."
	    	, ".$this->getField("JENIS_UNIT_KERJA_ID")."
	    )"; 

		$this->id= $this->getField("DISTRIK_JENIS_UNIT_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function update()
	{
		$str = "
		UPDATE distrik
		SET
		KODE_SITE= '".$this->getField("KODE_SITE")."'
		, KODE= '".$this->getField("KODE")."'
		, NAMA= '".$this->getField("NAMA")."'
		, WILAYAH_ID= ".$this->getField("WILAYAH_ID")."
		, PERUSAHAAN_EKSTERNAL_ID= ".$this->getField("PERUSAHAAN_EKSTERNAL_ID")."
		, LOCATION_ID= ".$this->getField("LOCATION_ID")."
		, DIREKTORAT_ID= ".$this->getField("DIREKTORAT_ID")."
		WHERE DISTRIK_ID = '".$this->getField("DISTRIK_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}


	function update_status()
	{
		$str = "
		UPDATE distrik
		SET
		STATUS = ".$this->getField("STATUS")."
		WHERE DISTRIK_ID = '".$this->getField("DISTRIK_ID")."'
		"; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM distrik
		WHERE 
		DISTRIK_ID = ".$this->getField("DISTRIK_ID").""; 

		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function insertdirektorat()
   	{
	  	$this->setField("DISTRIK_DIREKTORAT_ID", $this->getNextId("DISTRIK_DIREKTORAT_ID","DISTRIK_DIREKTORAT"));

	  	$str = "
	  	INSERT INTO DISTRIK_DIREKTORAT
	  	(
	  		DISTRIK_DIREKTORAT_ID, DISTRIK_ID, DIREKTORAT_ID
	  	)
	  	VALUES 
	  	(
	  		".$this->getField("DISTRIK_DIREKTORAT_ID")."
	    	, ".$this->getField("DISTRIK_ID")."
	    	, ".$this->getField("DIREKTORAT_ID")."
	    )"; 

	    $this->id= $this->getField("DISTRIK_DIREKTORAT_ID");
	    $this->query= $str;
			// echo $str;exit;
	    return $this->execQuery($str);
	}

	function deletedirektorat()
	{
		$str = "
		DELETE FROM DISTRIK_DIREKTORAT
		WHERE 
		DISTRIK_ID = ".$this->getField("DISTRIK_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function deletejenis()
	{
		$str = "
		DELETE FROM DISTRIK_JENIS_UNIT
		WHERE 
		DISTRIK_ID = ".$this->getField("DISTRIK_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $distrikment='', $sOrder="ORDER BY DISTRIK_ID ASC")
	{
		$str = "
		SELECT 
			A.*,B.NAMA WILAYAH_NAMA,
				CASE WHEN A.STATUS = 1 THEN 'Tidak  Aktif' ELSE 'Aktif' END STATUS_INFO
				, E.KODE_LOCATION LOCATION_KODE
				, E.DESKRIPSI_LOCATION DESKRIPSI_LOCATION
				, E.KODE_LOCATION || ' - ' || E.DESKRIPSI_LOCATION LOCATION_NAMA
				, C.NAMA DIREKTORAT_NAMA
				, D.JENIS_UNIT_KERJA_ID_INFO
				, D.JENIS_UNIT_KERJA_INFO
				
		FROM distrik A
		LEFT JOIN WILAYAH B ON B.WILAYAH_ID = A.WILAYAH_ID
		LEFT JOIN DIREKTORAT C ON C.DIREKTORAT_ID = A.DIREKTORAT_ID
		LEFT JOIN
		(
			SELECT 
				A.DISTRIK_ID
				,STRING_AGG(A.JENIS_UNIT_KERJA_ID::TEXT, ', ') AS JENIS_UNIT_KERJA_ID_INFO
				,STRING_AGG(B.NAMA::TEXT, ', ') AS JENIS_UNIT_KERJA_INFO
			FROM DISTRIK_JENIS_UNIT A
			INNER JOIN JENIS_UNIT_KERJA B ON B.JENIS_UNIT_KERJA_ID = A.JENIS_UNIT_KERJA_ID
			GROUP BY A.DISTRIK_ID
		) D ON D.DISTRIK_ID = A.DISTRIK_ID
		LEFT JOIN LOCATION E ON  E.LOCATION_ID = A.LOCATION_ID
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $distrikment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsMonitoring($paramsArray=array(),$limit=-1,$from=-1, $distrikment='', $sOrder="ORDER BY DISTRIK_ID ASC")
	{
		$str = "
		SELECT 
			A.*,B.NAMA WILAYAH_NAMA,
				CASE WHEN A.STATUS = 1 THEN 'Tidak  Aktif' ELSE 'Aktif' END STATUS_INFO
				, E.KODE_LOCATION LOCATION_KODE
				, E.DESKRIPSI_LOCATION DESKRIPSI_LOCATION
				, E.KODE_LOCATION || ' - ' || E.DESKRIPSI_LOCATION LOCATION_NAMA
				, C.NAMA DIREKTORAT_NAMA
				, D.JENIS_UNIT_KERJA_ID_INFO
				, D.JENIS_UNIT_KERJA_INFO
				, F.BLOK_INFO
				
		FROM distrik A
		LEFT JOIN WILAYAH B ON B.WILAYAH_ID = A.WILAYAH_ID
		LEFT JOIN DIREKTORAT C ON C.DIREKTORAT_ID = A.DIREKTORAT_ID
		LEFT JOIN
		(
			SELECT 
				A.DISTRIK_ID
				,STRING_AGG(A.JENIS_UNIT_KERJA_ID::TEXT, ', ') AS JENIS_UNIT_KERJA_ID_INFO
				,STRING_AGG(B.NAMA::TEXT, ', ') AS JENIS_UNIT_KERJA_INFO
			FROM DISTRIK_JENIS_UNIT A
			INNER JOIN JENIS_UNIT_KERJA B ON B.JENIS_UNIT_KERJA_ID = A.JENIS_UNIT_KERJA_ID
			GROUP BY A.DISTRIK_ID
		) D ON D.DISTRIK_ID = A.DISTRIK_ID
		LEFT JOIN LOCATION E ON  E.LOCATION_ID = A.LOCATION_ID
		LEFT JOIN
		(
			SELECT 
				A.DISTRIK_ID
				,STRING_AGG(A.BLOK_UNIT_ID::TEXT, ', ') AS BLOK_UNIT_ID_INFO
				,STRING_AGG(A.NAMA::TEXT, ', ') AS BLOK_INFO
			FROM BLOK_UNIT A
			GROUP BY A.DISTRIK_ID
		) F ON F.DISTRIK_ID = A.DISTRIK_ID
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $distrikment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsDirektorat($paramsArray=array(),$limit=-1,$from=-1, $distrikment='', $sOrder="ORDER BY DISTRIK_ID ASC")
	{
		$str = "
		SELECT 
			A.*,B.DIREKTORAT_NAMA
		FROM distrik A
		LEFT JOIN
		(
		  SELECT B.NAMA DIREKTORAT_NAMA,DISTRIK_ID
		  FROM
		  DIREKTORAT_DISTRIK A
		  LEFT JOIN DIREKTORAT B ON  B.DIREKTORAT_ID = A.DIREKTORAT_ID
		  WHERE B.STATUS IS NULL
		) B ON  A.DISTRIK_ID = B.DISTRIK_ID
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $distrikment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsWilayah($paramsArray=array(),$limit=-1,$from=-1, $distrikment='', $sOrder="ORDER BY DISTRIK_ID ASC")
	{
		$str = "
		SELECT 
			A.*,B.WILAYAH_NAMA,B.DIREKTORAT_NAMA,
				CASE WHEN A.STATUS = 1 THEN 'Tidak  Aktif' ELSE 'Aktif' END STATUS_INFO
				, D.NAMA JENIS_UNIT_KERJA 
				, E.KODE_LOCATION LOCATION_KODE
				, E.DESKRIPSI_LOCATION DESKRIPSI_LOCATION
				, E.KODE_LOCATION || ' - ' || E.DESKRIPSI_LOCATION LOCATION_NAMA
		FROM distrik A
		LEFT JOIN
		(
		  SELECT A.WILAYAH_ID,B.NAMA DIREKTORAT_NAMA,A.NAMA WILAYAH_NAMA
		  FROM
		  WILAYAH A
		  LEFT JOIN  DIREKTORAT B ON B.DIREKTORAT_ID = A.DIREKTORAT_ID
		) B ON  A.WILAYAH_ID = B.WILAYAH_ID
		LEFT JOIN JENIS_UNIT_KERJA D ON  D.JENIS_UNIT_KERJA_ID = A.JENIS_UNIT_KERJA_ID
		LEFT JOIN LOCATION E ON  E.LOCATION_ID = A.LOCATION_ID
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $distrikment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }


    function selectByParamsAreaDistrik($paramsArray=array(),$limit=-1,$from=-1, $distrikment='',$statid='', $sOrder="ORDER BY DISTRIK_ID ASC")
	{
		$str = "
		SELECT * FROM DISTRIK A
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $distrikment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }


    function selectByParamsWilayahFilter($paramsArray=array(),$limit=-1,$from=-1, $distrikment='',$statid='', $sOrder="ORDER BY B.WILAYAH_ID ASC")
	{
		$str = "
		SELECT 
			B.WILAYAH_ID,B.NAMA
		FROM distrik A
		INNER JOIN WILAYAH B ON A.WILAYAH_ID = B.WILAYAH_ID
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $distrikment." GROUP BY B.WILAYAH_ID ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsDirektoratFilter($paramsArray=array(),$limit=-1,$from=-1, $distrikment='',$statid='', $sOrder="ORDER BY B.DIREKTORAT_ID ASC")
	{
		$str = "
		SELECT B.DIREKTORAT_ID,B.NAMA 
		FROM distrik A
		INNER JOIN DIREKTORAT B ON B.DIREKTORAT_ID = A.DIREKTORAT_ID
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $distrikment." GROUP BY B.DIREKTORAT_ID ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

     function selectByParamsPerusahaanFilter($paramsArray=array(),$limit=-1,$from=-1, $distrikment='',$statid='', $sOrder="ORDER BY B.PERUSAHAAN_EKSTERNAL_ID ASC")
	{
		$str = "
		SELECT 
			B.PERUSAHAAN_EKSTERNAL_ID,B.NAMA
		FROM distrik A
		INNER JOIN PERUSAHAAN_EKSTERNAL B ON A.PERUSAHAAN_EKSTERNAL_ID = B.PERUSAHAAN_EKSTERNAL_ID
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $distrikment." GROUP BY B.PERUSAHAAN_EKSTERNAL_ID ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsJenisilter($paramsArray=array(),$limit=-1,$from=-1, $distrikment='',$statid='', $sOrder="ORDER BY B.JENIS_UNIT_KERJA_ID ASC")
	{
		$str = "
		SELECT 
			B.JENIS_UNIT_KERJA_ID,B.NAMA
		FROM distrik A
		INNER JOIN JENIS_UNIT_KERJA B ON A.JENIS_UNIT_KERJA_ID = B.JENIS_UNIT_KERJA_ID
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $distrikment." GROUP BY B.JENIS_UNIT_KERJA_ID ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsPerusahaan($paramsArray=array(),$limit=-1,$from=-1, $distrikment='', $sOrder="ORDER BY DISTRIK_ID ASC")
	{
		$str = "
		SELECT 
			A.*,B.NAMA NAMA_PERUSAHAAN
		FROM distrik A
		LEFT JOIN PERUSAHAAN_EKSTERNAL B ON  A.PERUSAHAAN_EKSTERNAL_ID = B.PERUSAHAAN_EKSTERNAL_ID
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $distrikment." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

    function getCountByParamsAreaDistrik($paramsArray=array(),$statement='')
	{
		$str = "SELECT COUNT(1) AS ROWCOUNT 
		FROM distrik a
		WHERE 1=1
		  ".$statement; 
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

    function getCountByParams($paramsArray=array())
	{
		$str = "SELECT COUNT(1) AS ROWCOUNT 
		FROM distrik
		LEFT JOIN
		(
		  SELECT A.WILAYAH_ID,B.NAMA DIREKTORAT_NAMA,A.NAMA WILAYAH_NAMA
		  FROM
		  WILAYAH A
		  LEFT JOIN  DIREKTORAT B ON B.DIREKTORAT_ID = A.DIREKTORAT_ID
		) B ON  A.WILAYAH_ID = B.WILAYAH_ID
		LEFT JOIN JENIS_UNIT_KERJA D ON  D.JENIS_UNIT_KERJA_ID = A.JENIS_UNIT_KERJA_ID
		LEFT JOIN LOCATION E ON  E.LOCATION_ID = A.LOCATION_ID
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

    function getCountByParamsPenggunaDistrik($paramsArray=array(),$statement='')
	{
		$str = "SELECT COUNT(1) AS ROWCOUNT 
		FROM distrik a
		-- inner join pengguna_distrik b on b.distrik_id = a.distrik_id
		WHERE 1=1
		  ".$statement; 
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