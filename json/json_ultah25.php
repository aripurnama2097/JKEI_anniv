<?php
	/*
	****	create by Mohamad Yunus
	****	on 2 November 2021
	****	remark: -
	*/  
	include('../../ADODB/con_jeinultah.php');
	
	//	get paramater
	$empno		= trim(@$_REQUEST["valempno"]);
	$empname	= trim(@$_REQUEST["valempname"]);
	$hadiah		= trim(@$_REQUEST["valhadiah"]);
    $page		= @$_REQUEST["page"];
	$limit		= @$_REQUEST["limit"];
	$start		= (($page*$limit)-$limit)+1;
	
	//	execute query
    $sql 		= "declare @totalcount as int; exec dispUltah25ResultUndian $start, $limit, '{$empno}', '{$empname}', '{$hadiah}', @totalcount=@totalcount out";
    $rs 		= $db->Execute($sql);
    $totalcount = $rs->fields[4];
	
	//	array data
	$return = array();
	
	for ($i = 0; !$rs->EOF; $i++) {
		$return[$i]['empno'] 		= $rs->fields[0];
		$return[$i]['empname'] 		= $rs->fields[1];
		$return[$i]['division'] 	= $rs->fields[2];
		$return[$i]['dept'] 		= $rs->fields[3];
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