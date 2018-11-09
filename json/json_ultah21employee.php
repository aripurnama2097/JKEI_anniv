<?php
	/*
	****	create by Mohamad Yunus
	****	on 05 November 2018
	****	remark: -
	*/  
	include('../../ADODB/con_jeinultah.php');
	
	//	get paramater
	$empno		= trim(@$_REQUEST["valempno"]);
	$empname	= trim(@$_REQUEST["valempname"]);
    $page		= @$_REQUEST["page"];
	$limit		= @$_REQUEST["limit"];
	$start		= (($page*$limit)-$limit)+1;
	
	//	execute query
    $sql 		= "declare @totalcount as int; exec dispUltah21Employee $start, $limit, '{$empno}', '{$empname}', @totalcount=@totalcount out";
    $rs 		= $db->Execute($sql);
    $totalcount = $rs->fields[11];
	
	//	array data
	$return = array();
	
	for ($i = 0; !$rs->EOF; $i++) {
		$return[$i]['empno'] 		= $rs->fields[0];
		$return[$i]['empname'] 		= $rs->fields[1];
		$return[$i]['division'] 	= $rs->fields[2];
		$return[$i]['dept'] 		= $rs->fields[3];
		$return[$i]['status'] 		= $rs->fields[4];
		$return[$i]['hadiah'] 		= $rs->fields[5];
		$return[$i]['attdstatus'] 	= $rs->fields[6];
		$return[$i]['input_user'] 	= $rs->fields[7];
		$return[$i]['input_date'] 	= $rs->fields[8];
		$return[$i]['update_user'] 	= $rs->fields[9];
		$return[$i]['update_date'] 	= $rs->fields[10];
		$rs->MoveNext();
	}
	
	$o = array(
		"success"=>true,
		"totalcount"=>$totalcount,
		"rows"=>$return);
		
	echo json_encode($o);
	
	//	connection close
	$rs->Close();
	$db->Close();
?>