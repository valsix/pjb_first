<? 
include_once(APPPATH.'/models/Entity.php');

class Pengguna extends Entity { 

	var $query;

    function Pengguna()
	{
      	$this->Entity(); 
    }

    function insert()
    {
    	$this->setField("PENGGUNA_ID", $this->getNextId("PENGGUNA_ID","PENGGUNA"));

    	$str = "
    	INSERT INTO PENGGUNA
    	(
    		PENGGUNA_ID, USERNAME, NAMA, STATUS, PERUSAHAAN_ID, ROLE_ID,PENGGUNA_INTERNAL_ID,TIPE,PENGGUNA_EXTERNAL_ID,PASS
    	)
    	VALUES 
    	(
	    	'".$this->getField("PENGGUNA_ID")."'
	    	, '".$this->getField("USERNAME")."'
	    	, '".$this->getField("NAMA")."'
	    	, '".$this->getField("STATUS")."'
	    	, '".$this->getField("PERUSAHAAN_ID")."'
	    	, ".$this->getField("ROLE_ID")."
	    	, ".$this->getField("PENGGUNA_INTERNAL_ID")."
	    	, '".$this->getField("TIPE")."'
	    	, ".$this->getField("PENGGUNA_EXTERNAL_ID")."
	    	, '".$this->getField("PASS")."'
	    )"; 

		$this->id= $this->getField("PENGGUNA_ID");
		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}



	function update()
	{
		$str = "
		UPDATE PENGGUNA
		SET
		USERNAME= '".$this->getField("USERNAME")."'
		, NAMA= '".$this->getField("NAMA")."'
		, STATUS= '".$this->getField("STATUS")."'
		, PERUSAHAAN_ID= '".$this->getField("PERUSAHAAN_ID")."'
		, ROLE_ID= ".$this->getField("ROLE_ID")."
		, PENGGUNA_EXTERNAL_ID= ".$this->getField("PENGGUNA_EXTERNAL_ID")."
		, PENGGUNA_INTERNAL_ID= ".$this->getField("PENGGUNA_INTERNAL_ID")."
		, TIPE= '".$this->getField("TIPE")."'
		, PASS= '".$this->getField("PASS")."'

		WHERE PENGGUNA_ID = '".$this->getField("PENGGUNA_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}


	function updatenonpass()
	{
		$str = "
		UPDATE PENGGUNA
		SET
		USERNAME= '".$this->getField("USERNAME")."'
		, NAMA= '".$this->getField("NAMA")."'
		, STATUS= '".$this->getField("STATUS")."'
		, PERUSAHAAN_ID= '".$this->getField("PERUSAHAAN_ID")."'
		, ROLE_ID= ".$this->getField("ROLE_ID")."
		, PENGGUNA_EXTERNAL_ID= ".$this->getField("PENGGUNA_EXTERNAL_ID")."
		, PENGGUNA_INTERNAL_ID= ".$this->getField("PENGGUNA_INTERNAL_ID")."
		, TIPE= '".$this->getField("TIPE")."'

		WHERE PENGGUNA_ID = '".$this->getField("PENGGUNA_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function reset_password()
	{
		$str = "
		UPDATE pengguna
		SET
		 PASS = '".$this->getField("PASS")."'
		WHERE PENGGUNA_ID = '".$this->getField("PENGGUNA_ID")."';
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function delete()
	{
		$str = "
		DELETE FROM PENGGUNA
		WHERE 
		PENGGUNA_ID = ".$this->getField("PENGGUNA_ID").""; 

		$this->query = $str;
		return $this->execQuery($str);
	}

	function insertPenggunaHakAkses()
    {
    	$this->setField("PENGGUNA_HAK_AKSES_ID", $this->getNextId("PENGGUNA_HAK_AKSES_ID","PENGGUNA_HAK_AKSES"));

    	$str = "
    	INSERT INTO PENGGUNA_HAK_AKSES
    	(
    		PENGGUNA_HAK_AKSES_ID, PENGGUNA_ID, PENGGUNA_HAK_ID
    	)
    	VALUES 
    	(
	    	'".$this->getField("PENGGUNA_HAK_AKSES_ID")."'
	    	, '".$this->getField("PENGGUNA_ID")."'
	    	, '".$this->getField("PENGGUNA_HAK_ID")."'
	    )"; 

			$this->id= $this->getField("PENGGUNA_HAK_AKSES_ID");
			$this->query= $str;
			// echo $str;exit;
			return $this->execQuery($str);
	}

	function deletePenggunaHakAkses()
	{
		$str = "
		DELETE FROM PENGGUNA_HAK_AKSES
		WHERE 
		PENGGUNA_ID = '".$this->getField("PENGGUNA_ID")."'"; 

		// echo $str;exit();
		$this->query = $str;
		return $this->execQuery($str);
	}

	function insertPenggunaDistrik()
    {
    	$this->setField("PENGGUNA_DISTRIK_ID", $this->getNextId("PENGGUNA_DISTRIK_ID","PENGGUNA_DISTRIK"));

    	$str = "
    	INSERT INTO PENGGUNA_DISTRIK
    	(
    		PENGGUNA_DISTRIK_ID, PENGGUNA_ID, DISTRIK_ID,STATUS_ALL
    	)
    	VALUES 
    	(
	    	'".$this->getField("PENGGUNA_DISTRIK_ID")."'
	    	, '".$this->getField("PENGGUNA_ID")."'
	    	, '".$this->getField("DISTRIK_ID")."'
	    	, ".$this->getField("STATUS_ALL")."
	    )"; 

	    $this->id= $this->getField("PENGGUNA_DISTRIK_ID");
	    $this->query= $str;
		// echo $str;
	    return $this->execQuery($str);
	}

	function deletePenggunaDistrik()
	{
		$str = "
		DELETE FROM PENGGUNA_DISTRIK
		WHERE 
		PENGGUNA_ID = '".$this->getField("PENGGUNA_ID")."'"; 

		// echo $str;exit();
		$this->query = $str;
		return $this->execQuery($str);
	}

	function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY PENGGUNA_ID ASC")
	{
		$str = "
			SELECT 
				A.PENGGUNA_ID,A.USERNAME,A.NAMA,A.HAK,A.STATUS,A.FOTO,A.KONTAK,A.ALAMAT
				, A.AKTIVASI,A.PERUSAHAAN_ID,A.ROLE_ID,A.EMAIL,A.LINK_FILE,A.PENGGUNA_EXTERNAL_ID,A.TIPE,A.PENGGUNA_INTERNAL_ID
				, B.PENGGUNA_HAK_NAMA_INFO
				, B.PENGGUNA_HAK_ID_INFO
				, C.ROLE_NAMA
				, D.NAMA PENGGUNA_EKSTERNAL_INFO
				, E.NAMA_LENGKAP PENGGUNA_INTERNAL_INFO
				, COALESCE (D.NAMA_POSISI,E.NAMA_POSISI) JABATAN
				, F.DISTRIK_ID_INFO
				, F.DISTRIK_NAMA_INFO
				, F.STATUS_ALL_INFO
			FROM PENGGUNA A
			LEFT JOIN 
			(
				SELECT B.PENGGUNA_ID
				,STRING_AGG(A.PENGGUNA_HAK_ID::text, ', ') AS PENGGUNA_HAK_ID_INFO
				,STRING_AGG(A.NAMA_HAK, ', ') AS PENGGUNA_HAK_NAMA_INFO 
				FROM PENGGUNA_HAK A
				INNER JOIN PENGGUNA_HAK_AKSES B ON B.PENGGUNA_HAK_ID = A.PENGGUNA_HAK_ID 
				GROUP BY B.PENGGUNA_ID
			) B ON B.PENGGUNA_ID = A.PENGGUNA_ID
			LEFT JOIN ROLE_APPROVAL C ON C.ROLE_ID = A.ROLE_ID
			LEFT JOIN 
			(
				SELECT A.PENGGUNA_EXTERNAL_ID,A.NAMA,A.POSITION_ID,B.NAMA_POSISI
				FROM PENGGUNA_EXTERNAL A
				LEFT JOIN MASTER_JABATAN B ON B.POSITION_ID = A.POSITION_ID
				GROUP BY A.PENGGUNA_EXTERNAL_ID,A.NAMA,A.POSITION_ID,B.NAMA_POSISI
			) D ON D.PENGGUNA_EXTERNAL_ID = A.PENGGUNA_EXTERNAL_ID
			LEFT JOIN 
			(
				SELECT A.PENGGUNA_INTERNAL_ID,A.NAMA_LENGKAP,A.POSITION_ID,B.NAMA_POSISI
				FROM PENGGUNA_INTERNAL A
				LEFT JOIN MASTER_JABATAN B ON B.POSITION_ID = A.POSITION_ID
				GROUP BY A.PENGGUNA_INTERNAL_ID,A.NAMA_LENGKAP,A.POSITION_ID,B.NAMA_POSISI
			) E ON E.PENGGUNA_INTERNAL_ID = A.PENGGUNA_INTERNAL_ID
			LEFT JOIN 
			(
				SELECT B.PENGGUNA_ID
				,STRING_AGG(A.DISTRIK_ID::text, ', ') AS DISTRIK_ID_INFO
				,STRING_AGG(B.STATUS_ALL::text, ', ') AS STATUS_ALL_INFO
				,STRING_AGG(A.NAMA, ', ') AS DISTRIK_NAMA_INFO 
				FROM DISTRIK A
				LEFT JOIN PENGGUNA_DISTRIK B ON B.DISTRIK_ID = A.DISTRIK_ID 
				GROUP BY B.PENGGUNA_ID
			) F ON F.PENGGUNA_ID = A.PENGGUNA_ID
			
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

	function selectByParamsMenus($paramsArray=array(),$limit=-1,$from=-1, $statement='', $kodeHak='', $sOrder="ORDER BY idpath ASC")
	{
		$str = "
			with recursive cte as 
			(
				select
				b.kode_modul, b.level_modul, b.menu_modul, b.order_modul
				, b.kode_modul id, lpad(b.kode_modul::varchar(12),12,'0')::varchar(144) as idpath, 1::int as depth
				, b.group_modul, a.menu, a.modul_c, a.modul_anak_c, a.modul_r, a.modul_anak_r, a.modul_u, a.modul_anak_u
				, a.modul_d, a.modul_anak_d
				FROM pengguna_modul b
				LEFT JOIN (SELECT * FROM pengguna_crud WHERE kode_hak = '".$kodeHak."') a ON a.kode_modul = b.kode_modul
				WHERE 1=1 and b.level_modul = '0'
				
				union all
				
				select
				a.kode_modul, a.level_modul, a.menu_modul, a.order_modul
				, a.kode_modul id, concat(idpath, lpad(a.kode_modul::varchar(12),12,'0'))::varchar(144) idpath, depth + 1::int as depth
				, a.group_modul, a.menu, a.modul_c, a.modul_anak_c, a.modul_r, a.modul_anak_r, a.modul_u, a.modul_anak_u
				, a.modul_d, a.modul_anak_d
				from cte r
				join
				(
					select
					b.kode_modul, b.level_modul, b.menu_modul, b.order_modul
					, b.group_modul, a.menu, a.modul_c, a.modul_anak_c, a.modul_r, a.modul_anak_r, a.modul_u, a.modul_anak_u
					, a.modul_d, a.modul_anak_d
					FROM pengguna_modul b
					LEFT JOIN (SELECT * FROM pengguna_crud WHERE kode_hak = '".$kodeHak."') a ON a.kode_modul = b.kode_modul
					WHERE 1=1
				)
				a on a.level_modul = r.id
			)
			select * from cte
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
	}

	function selectByParamsCombo($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY PENGGUNA_ID ASC")
	{
		$str = "
			SELECT 
				A.*,B.ROLE_NAMA
			FROM PENGGUNA A
			INNER JOIN ROLE_APPROVAL B ON B.ROLE_ID = A.ROLE_ID
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

	function selectByParamsCheckInternal($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY A.PENGGUNA_INTERNAL_ID ASC")
	{
		$str = "
		SELECT A.PENGGUNA_INTERNAL_ID,A.NAMA_LENGKAP,A.POSITION_ID,B.NAMA_POSISI,A.NID
		FROM PENGGUNA_INTERNAL A
		INNER JOIN MASTER_JABATAN B ON B.POSITION_ID = A.POSITION_ID
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
	function selectByParamsCheckEksternal($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY A.PENGGUNA_EXTERNAL_ID ASC")
	{
		$str = "
		SELECT A.PENGGUNA_EXTERNAL_ID,A.NAMA,A.POSITION_ID,B.NAMA_POSISI,A.PASSWORD
		FROM PENGGUNA_EXTERNAL A
		LEFT JOIN MASTER_JABATAN B ON B.POSITION_ID = A.POSITION_ID
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

	function selectByParamsAll($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY A.USER_ID ASC")
	{
		$str = "
		SELECT A.PENGGUNA_INTERNAL_ID AS USER_ID, NID, NAMA_LENGKAP, A.EMAIL
		, 'Internal' AS STATUS_INFO
		, CASE WHEN B.PENGGUNA_INTERNAL_ID IS NOT NULL
		THEN 'Sudah Terdaftar'
		ELSE 'Belum Terdaftar'
		END PENGGUNA_STATUS
		, C.DISTRIK_ID
		, A.KODE_UNIT KODE_DISTRIK
		, A.UNIT NAMA_DISTRIK
		, '1' STATUS_TABEL
		FROM PENGGUNA_INTERNAL A 
		LEFT JOIN PENGGUNA B ON A.PENGGUNA_INTERNAL_ID = B.PENGGUNA_INTERNAL_ID
		LEFT JOIN DISTRIK C ON A.KODE_UNIT = C.KODE
		WHERE 1=1 
		".$statement."
		UNION ALL 
		SELECT A.PENGGUNA_EXTERNAL_ID AS USER_ID, A.NID, A.NAMA, A.EMAIL
		,'Eksternal' AS STATUS_INFO
		, CASE WHEN B.PENGGUNA_EXTERNAL_ID IS NOT NULL
		THEN 'Sudah Terdaftar'
		ELSE 'Belum Terdaftar'
		END PENGGUNA_STATUS
		, C.DISTRIK_ID
		, C.KODE KODE_DISTRIK
		, C.NAMA NAMA_DISTRIK
		, '2' STATUS_TABEL
		FROM PENGGUNA_EXTERNAL A
		LEFT JOIN PENGGUNA B ON A.PENGGUNA_EXTERNAL_ID = B.PENGGUNA_EXTERNAL_ID
		LEFT JOIN DISTRIK C ON A.DISTRIK_ID = C.DISTRIK_ID
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

	function selectByParamsStatusAll($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY PENGGUNA_ID ASC")
	{
		$str = "
		select pengguna_id from pengguna_distrik 
		where status_all=0
		group by pengguna_id
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
	}


	function selectByParamsPenggunaDistrik($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="order by distrik_id")
	{
		$str = "
		SELECT  a.distrik_id FROM distrik a 
		where  a.distrik_id  not in
		(
		select distrik_id from pengguna_distrik x where a.distrik_id = x.distrik_id and x.status_all=0 ".$statement."
		)
		
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
	}


} 
?>