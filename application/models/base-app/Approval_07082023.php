<? 
include_once(APPPATH.'/models/Entity.php');

class Approval extends Entity { 

	var $query;

    function Approval()
	{
      	$this->Entity(); 
    }

    function insertapproval()
    {
    	$str = "
    	INSERT INTO approval(REF_TABEL, REF_ID, APPR_DESK, APPR_TYPE, APPR_STATUS, PERUSAHAAN_ID, CREATED_AT)
    	VALUES 
    	(
	    	'".$this->getField("REF_TABEL")."'
	    	, '".$this->getField("REF_ID")."'
	    	, '".$this->getField("APPR_DESK")."'
	    	, ".$this->getField("APPR_TYPE")."
	    	, ".$this->getField("APPR_STATUS")."
	    	, ".$this->getField("PERUSAHAAN_ID")."
	    	, NOW()
	    )";

		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function updateapproval()
    {
    	$str = "
    	UPDATE approval
		SET
			APPR_STATUS= ".$this->getField("APPR_STATUS")."
		WHERE APPR_ID = '".$this->getField("APPR_ID")."'
		";

		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function deleteapprdetil()
    {
    	$str = "
    	DELETE FROM apprdetail
		WHERE APPR_ID = '".$this->getField("APPR_ID")."'
		";

		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function deleteapprdetilreturn()
    {
    	$str = "
    	DELETE FROM apprdetail
		WHERE APRD_ID = '".$this->getField("APRD_ID")."'
		";

		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function deleteapprdetilreturnall()
    {
    	$str = "
    	DELETE FROM apprdetail
		WHERE APPR_ID = '".$this->getField("APPR_ID")."'
		AND APRD_STATUS = '".$this->getField("APRD_STATUS")."'
		";

		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

    function selectapproval($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY A.APPR_ID DESC")
	{
		$str = "
		SELECT 
			SA.NAMA APPR_STATUS_NAMA
			, A.*
		FROM approval A
		LEFT JOIN status_approve SA ON A.APPR_STATUS = SA.STATUS_APPROVE_ID
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

    function selectapprdetail($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY A.APRD_ID DESC")
	{
		$str = "
		SELECT 
			A.*
		FROM apprdetail A
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

	function selectmenu($kodeHak='', $statement="", $sOrder="ORDER BY order_modul ASC")
	{
		$str = "
			with recursive cte as 
			(
				select
				b.kode_modul, b.level_modul, b.menu_modul, b.order_modul, b.link_modul
				, b.kode_modul id, lpad(b.kode_modul::varchar(12),12,'0')::varchar(144) as idpath, 1::int as depth
				, b.group_modul, a.menu, a.modul_c, a.modul_anak_c, a.modul_r, a.modul_anak_r, a.modul_u, a.modul_anak_u
				, a.modul_d, a.modul_anak_d
				FROM pengguna_modul b
				INNER JOIN (SELECT * FROM pengguna_crud WHERE kode_hak = '".$kodeHak."') a ON a.kode_modul = b.kode_modul
				WHERE 1=1 and b.level_modul = '0'
				union all
				select
				a.kode_modul, a.level_modul, a.menu_modul, a.order_modul, a.link_modul
				, a.kode_modul id, concat(idpath, lpad(a.kode_modul::varchar(12),12,'0'))::varchar(144) idpath, depth + 1::int as depth
				, a.group_modul, a.menu, a.modul_c, a.modul_anak_c, a.modul_r, a.modul_anak_r, a.modul_u, a.modul_anak_u
				, a.modul_d, a.modul_anak_d
				from cte r
				join
				(
					select
					b.kode_modul, b.level_modul, b.menu_modul, b.order_modul, b.link_modul
					, b.group_modul, a.menu, a.modul_c, a.modul_anak_c, a.modul_r, a.modul_anak_r, a.modul_u, a.modul_anak_u
					, a.modul_d, a.modul_anak_d
					FROM pengguna_modul b
					INNER JOIN (SELECT * FROM pengguna_crud WHERE kode_hak = '".$kodeHak."') a ON a.kode_modul = b.kode_modul
					WHERE 1=1
				)
				a on a.level_modul = r.id
			)
			select * from cte
			WHERE 1=1
		";
		
		$str .= $statement." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,-1,-1); 
	}

	function selectlistapproval($reftabel, $refid, $sOrder="ORDER BY B.FLOWD_INDEX ASC")
	{
		$str = "
		SELECT
			B.ROLE_ID, B.FLOWD_INDEX, C.ROLE_NAMA, D.APPR_ID
		FROM flow_approval A
		INNER JOIN flow_appdetail B ON A.FLOW_ID = B.FLOW_ID
		INNER JOIN role_approval C ON B.ROLE_ID = C.ROLE_ID
		INNER JOIN
		(
			SELECT B.KODE_MODUL, A.*
			FROM approval A
			INNER JOIN (SELECT KODE_MODUL, LINK_MODUL FROM pengguna_modul) B ON LINK_MODUL = REF_TABEL
		) D ON D.KODE_MODUL = A.REF_TABEL AND REF_ID = '".$refid."'
		WHERE 1=1 AND D.REF_TABEL = '".$reftabel."'
		";
		
		$str .= " ".$sOrder;
		$this->query = $str;
		// echo $str;exit;
				
		return $this->selectLimit($str,-1,-1); 
    }

    function selectlistapprovalstatus($reftabel, $refid, $sOrder="")
	{
		$str = "
		SELECT
		B.ROLE_ID, C.NAMA, B.APRD_TGL, B.APRD_STATUS, B.APRD_ALASANTOLAK
		, SA.NAMA APRD_STATUS_NAMA
    	--*
		FROM approval A
		INNER JOIN apprdetail B ON A.APPR_ID=B.APPR_ID
		INNER JOIN pengguna C ON B.USER_ID=C.PENGGUNA_ID
		LEFT JOIN status_approve SA ON B.APRD_STATUS = SA.STATUS_APPROVE_ID
		WHERE 1=1
		AND A.REF_ID = '".$refid."'
		AND A.REF_TABEL = '".$reftabel."'
		";
		
		$str .= " ".$sOrder;
		$this->query = $str;
		// echo $str;exit;
				
		return $this->selectLimit($str,-1,-1); 
    }

    function insertapprdetail()
    {
    	$str = "
    	INSERT INTO apprdetail(APPR_ID, USER_ID, ROLE_ID, APRD_TGL, APRD_ALASANTOLAK, APRD_STATUS)
    	VALUES 
    	(
	    	".$this->getField("APPR_ID")."
	    	, ".$this->getField("USER_ID")."
	    	, ".$this->getField("ROLE_ID")."
	    	, ".$this->getField("APRD_TGL")."
	    	, '".$this->getField("APRD_ALASANTOLAK")."'
	    	, ".$this->getField("APRD_STATUS")."
	    )";

		$this->query= $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function updateapprdetail()
	{
		$str = "
		UPDATE apprdetail
		SET
		APRD_STATUS= ".$this->getField("APRD_STATUS")."
		WHERE APPR_ID = '".$this->getField("APPR_ID")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

	function updatetableapprove()
	{
		$str = "
		UPDATE ".$this->getField("TABLE")."
		SET
		V_STATUS= ".$this->getField("V_STATUS")."
		WHERE ".$this->getField("FIELD_ID")." = ".$this->getField("VAL_ID")."
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
	}

    function getjumlahflow($vapprid)
	{
		$str = "
		SELECT
			MAX(FLOWD_INDEX) ROWCOUNT
		FROM flow_approval A
		INNER JOIN flow_appdetail B ON A.FLOW_ID = B.FLOW_ID
		INNER JOIN
		(
			SELECT B.KODE_MODUL, A.*
			FROM approval A
			INNER JOIN (SELECT KODE_MODUL, LINK_MODUL FROM pengguna_modul) B ON LINK_MODUL = REF_TABEL
		) D ON D.KODE_MODUL = A.REF_TABEL
		WHERE D.APPR_ID = ".$vapprid;

		$this->query = $str;
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0;  
    }

    function getjumlahapproval($vapprid)
	{
		$str = "
		SELECT COUNT(1) ROWCOUNT
		FROM
		(
			SELECT ROLE_ID FROM apprdetail WHERE APPR_ID = ".$vapprid." GROUP BY ROLE_ID
		) A";

		$this->query = $str;
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0;  
    }

} 
?>