<? 
include_once(APPPATH.'/models/Entity.php');

class Notif extends Entity { 

	var $query;

    function Notif()
	{
      	$this->Entity(); 
    }

  //   function getCountByParamsNotifOutlining($paramsArray=array(),$statementstatus="",$roleid="", $statement="")
  //   {
  //       $str = "
  //       SELECT COUNT(1) AS ROWCOUNT
  //       FROM APPROVAL A
  //       INNER JOIN PENGGUNA_MODUL C ON A.REF_TABEL = C.LINK_MODUL
  //       INNER JOIN OUTLINING_ASSESSMENT E ON E.OUTLINING_ASSESSMENT_ID = A.REF_ID::INTEGER  
  //       WHERE 1=1
  //        ".$statementstatus."
  //        AND (E.V_STATUS = 0 OR E.V_STATUS = 1 OR E.V_STATUS = 10 OR E.V_STATUS = 30)
  //       AND ( C.KODE_MODUL IN
  //       (
	 //        SELECT A.REF_TABEL
	 //        FROM FLOW_APPROVAL A
	 //        INNER JOIN FLOW_APPDETAIL B ON A.FLOW_ID=B.FLOW_ID
	 //        INNER JOIN ROLE_APPROVAL C ON B.ROLE_ID=C.ROLE_ID
	 //        WHERE C.ROLE_ID = '".$roleid."'
  //       ))
  //       AND  NOT EXISTS
  //       (
  //           SELECT ROLE_ID FROM APPRDETAIL X 
  //           WHERE X.APPR_ID= A.APPR_ID 
  //           AND  X.ROLE_ID = '".$roleid."'
  //           AND (APRD_STATUS = 0 OR APRD_STATUS = 1 OR APRD_STATUS = 10 OR APRD_STATUS = 30)

  //       )
		// ".$statement;

  //       while(list($key,$val)=each($paramsArray))
  //       {
  //           $str .= " AND $key= '$val' ";
  //       }
        
  //       $this->query= $str;
  //       // echo $str;exit();
  //       $this->select($str);
  //       if($this->firstRow()){
  //           return $this->getField("ROWCOUNT"); 
  //       }
  //       else {
  //           return 0; 
  //       }
  //   }

    function getCountByParamsNotifOutlining($paramsArray=array(),$statementstatus="",$roleid="", $statement="")
    {
        $str = "
        SELECT COUNT(1) AS ROWCOUNT
        FROM APPROVAL A
        INNER JOIN PENGGUNA_MODUL C ON A.REF_TABEL = C.LINK_MODUL
        INNER JOIN OUTLINING_ASSESSMENT E ON E.OUTLINING_ASSESSMENT_ID = A.REF_ID::INTEGER  
        WHERE 1=1
         ".$statementstatus."
        AND ( C.KODE_MODUL IN
        (
            SELECT A.REF_TABEL
            FROM FLOW_APPROVAL A
            INNER JOIN FLOW_APPDETAIL B ON A.FLOW_ID=B.FLOW_ID
            INNER JOIN ROLE_APPROVAL C ON B.ROLE_ID=C.ROLE_ID
        )) ".$statement;
        if(!empty($roleid))
        {
          $str .="
          AND A.NEXT_ROLE_ID =  '".$roleid."'";
        }
        
        while(list($key,$val)=each($paramsArray))
        {
            $str .= " AND $key= '$val' ";
        }
        
        $this->query= $str;
        // echo $str;exit();
        $this->select($str);
        if($this->firstRow()){
            return $this->getField("ROWCOUNT"); 
        }
        else {
            return 0; 
        }
    }


    function getCountByParamsNotifRekomendasi($paramsArray=array(),$statementstatus="",$roleid="", $statement="")
    {
        $str = "
        SELECT COUNT(1) AS ROWCOUNT
        FROM APPROVAL A
        INNER JOIN PENGGUNA_MODUL C ON A.REF_TABEL = C.LINK_MODUL
        INNER JOIN OUTLINING_ASSESSMENT_REKOMENDASI E ON E.OUTLINING_ASSESSMENT_REKOMENDASI_ID = A.REF_ID::INTEGER  
        WHERE 1=1
         ".$statementstatus;
         if(!empty($roleid))
         {
           $str .="
           AND ( C.KODE_MODUL IN
           (
             SELECT A.REF_TABEL
             FROM FLOW_APPROVAL A
             INNER JOIN FLOW_APPDETAIL B ON A.FLOW_ID=B.FLOW_ID
             INNER JOIN ROLE_APPROVAL C ON B.ROLE_ID=C.ROLE_ID
             WHERE B.ROLE_ID =   '".$roleid."'
           ))
           AND A.NEXT_ROLE_ID =  '".$roleid."'
           ".$statement;
         }
         else
         {
           $str .="
           AND ( C.KODE_MODUL IN
           (
             SELECT A.REF_TABEL
             FROM FLOW_APPROVAL A
             INNER JOIN FLOW_APPDETAIL B ON A.FLOW_ID=B.FLOW_ID
             INNER JOIN ROLE_APPROVAL C ON B.ROLE_ID=C.ROLE_ID
           ))
           ".$statement;
         }
       

        while(list($key,$val)=each($paramsArray))
        {
            $str .= " AND $key= '$val' ";
        }
        
        $this->query= $str;
        // echo $str;exit();
        $this->select($str);
        if($this->firstRow()){
            return $this->getField("ROWCOUNT"); 
        }
        else {
            return 0; 
        }
    }

    function selectlistapproval($paramsArray=array(), $statement="")
	{
		$str = "
		SELECT B.ROLE_ID, B.FLOWD_INDEX, C.ROLE_NAMA, D.APPR_ID
		FROM flow_approval A
		INNER JOIN flow_appdetail B ON A.FLOW_ID = B.FLOW_ID
		INNER JOIN role_approval C ON B.ROLE_ID = C.ROLE_ID
		INNER JOIN
		(
			SELECT B.KODE_MODUL, A.*
			FROM approval A
			INNER JOIN (SELECT KODE_MODUL, LINK_MODUL FROM pengguna_modul) B ON LINK_MODUL = REF_TABEL
		) D ON D.KODE_MODUL = A.REF_TABEL
		INNER JOIN outlining_assessment e ON e.outlining_assessment_id = d.ref_id::integer 
		WHERE 1=1 
		";
		
		$str .= $statement." ".$sOrder;
		$this->query = $str;
		// echo $str;exit;
				
		return $this->selectLimit($str,-1,-1); 
    }

     function selectlistapprovalstatus($reftabel, $sOrder="")
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
		AND A.REF_TABEL = '".$reftabel."'
		AND A.APPR_STATUS < 30
		";
		
		$str .= " ".$sOrder;
		$this->query = $str;
		// echo $str;exit;
				
		return $this->selectLimit($str,-1,-1); 
    }


  function selectcheckapprekom($paramsArray=array(), $statement="")
  {
    $str = "
    SELECT *
    FROM FLOW_APPROVAL A
    INNER JOIN FLOW_APPDETAIL B ON A.FLOW_ID=B.FLOW_ID
    INNER JOIN ROLE_APPROVAL C ON B.ROLE_ID=C.ROLE_ID
    WHERE 1=1     
    ";
    
    $str .= $statement." ".$sOrder;
    $this->query = $str;
    // echo $str;exit;
        
    return $this->selectLimit($str,-1,-1); 
    }

  function selectByParamsRekomendasiNull($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="")
  {
    $str = "
    SELECT count(1) jumlah
    FROM OUTLINING_ASSESSMENT_AREA_DETIL A
    INNER JOIN OUTLINING_ASSESSMENT C ON C.OUTLINING_ASSESSMENT_ID = A.OUTLINING_ASSESSMENT_ID
    INNER JOIN OUTLINING_ASSESSMENT_DETIL D ON D.OUTLINING_ASSESSMENT_DETIL_ID = A.OUTLINING_ASSESSMENT_DETIL_ID
    LEFT JOIN OUTLINING_ASSESSMENT_REKOMENDASI E ON E.OUTLINING_ASSESSMENT_AREA_DETIL_ID = A.OUTLINING_ASSESSMENT_AREA_DETIL_ID
    INNER JOIN LIST_AREA F ON F.LIST_AREA_ID = D.LIST_AREA_ID
    INNER JOIN ITEM_ASSESSMENT_DUPLIKAT G ON G.ITEM_ASSESSMENT_DUPLIKAT_ID = D.ITEM_ASSESSMENT_DUPLIKAT_ID AND G.LIST_AREA_ID = D.LIST_AREA_ID
    INNER JOIN ITEM_ASSESSMENT_FORMULIR H ON H.ITEM_ASSESSMENT_FORMULIR_ID = A.ITEM_ASSESSMENT_FORMULIR_ID
    LEFT JOIN JENIS_REKOMENDASI I ON I.JENIS_REKOMENDASI_ID = E.JENIS_REKOMENDASI_ID
    LEFT JOIN PRIORITAS_REKOMENDASI J ON J.PRIORITAS_REKOMENDASI_ID = E.PRIORITAS_REKOMENDASI_ID
    LEFT JOIN KATEGORI_REKOMENDASI K ON K.KATEGORI_REKOMENDASI_ID = E.KATEGORI_REKOMENDASI_ID
    LEFT JOIN STATUS_REKOMENDASI L ON L.STATUS_REKOMENDASI_ID = E.STATUS_REKOMENDASI_ID
    LEFT JOIN DISTRIK DR ON DR.DISTRIK_ID = C.DISTRIK_ID
    LEFT JOIN BLOK_UNIT BU ON BU.BLOK_UNIT_ID = C.BLOK_UNIT_ID
    LEFT JOIN UNIT_MESIN UM ON UM.UNIT_MESIN_ID = C.UNIT_MESIN_ID
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

  function selectByParamsRekomendasiNotif($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY C.DISTRIK_ID ASC",$appuserroleid)
  {
    $str = "
    SELECT A.*,F.NAMA,F.KODE || GENERATEZERO(G.KODE,2) || ' - ' || F.NAMA KODE_INFO,H.NAMA ITEM_ASSESSMENT_INFO
    , C.BULAN,C.TAHUN
    , DR.NAMA DISTRIK_INFO
    , BU.NAMA BLOK_INFO
    , E.DETAIL
    , I.NAMA JENIS_NAMA
    , J.NAMA PRIORITAS_NAMA
    , K.NAMA  KATEGORI_NAMA
    , E.OUTLINING_ASSESSMENT_REKOMENDASI_ID
    FROM OUTLINING_ASSESSMENT_AREA_DETIL A
    INNER JOIN OUTLINING_ASSESSMENT C ON C.OUTLINING_ASSESSMENT_ID = A.OUTLINING_ASSESSMENT_ID
    INNER JOIN OUTLINING_ASSESSMENT_DETIL D ON D.OUTLINING_ASSESSMENT_DETIL_ID = A.OUTLINING_ASSESSMENT_DETIL_ID
    INNER JOIN OUTLINING_ASSESSMENT_REKOMENDASI E ON E.OUTLINING_ASSESSMENT_AREA_DETIL_ID = A.OUTLINING_ASSESSMENT_AREA_DETIL_ID
    INNER JOIN LIST_AREA F ON F.LIST_AREA_ID = D.LIST_AREA_ID
    INNER JOIN ITEM_ASSESSMENT_DUPLIKAT G ON G.ITEM_ASSESSMENT_DUPLIKAT_ID = D.ITEM_ASSESSMENT_DUPLIKAT_ID AND G.LIST_AREA_ID = D.LIST_AREA_ID
    INNER JOIN ITEM_ASSESSMENT_FORMULIR H ON H.ITEM_ASSESSMENT_FORMULIR_ID = A.ITEM_ASSESSMENT_FORMULIR_ID
    LEFT JOIN JENIS_REKOMENDASI I ON I.JENIS_REKOMENDASI_ID = E.JENIS_REKOMENDASI_ID
    LEFT JOIN PRIORITAS_REKOMENDASI J ON J.PRIORITAS_REKOMENDASI_ID = E.PRIORITAS_REKOMENDASI_ID
    LEFT JOIN KATEGORI_REKOMENDASI K ON K.KATEGORI_REKOMENDASI_ID = E.KATEGORI_REKOMENDASI_ID
    LEFT JOIN STATUS_REKOMENDASI L ON L.STATUS_REKOMENDASI_ID = E.STATUS_REKOMENDASI_ID
    
    LEFT JOIN DISTRIK DR ON DR.DISTRIK_ID = C.DISTRIK_ID
    LEFT JOIN BLOK_UNIT BU ON BU.BLOK_UNIT_ID = C.BLOK_UNIT_ID
    LEFT JOIN UNIT_MESIN UM ON UM.UNIT_MESIN_ID = C.UNIT_MESIN_ID
    INNER JOIN APPROVAL APPR ON APPR.REF_ID::integer = E.OUTLINING_ASSESSMENT_REKOMENDASI_ID 
    AND APPR.REF_TABEL ='outlining_assessment_rekomendasi' and NEXT_ROLE_ID = ".$appuserroleid."


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