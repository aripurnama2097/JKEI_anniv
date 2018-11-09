<?php
	/*
	****	create by Mohamad Yunus
	****	on 05 November 2018
	****	remark: -
	*/  
	include('../../ADODB/con_jeinultah.php');
	
	//	get paramater
	//	execute query
    $sql 		= "select empno from tblUltah21Employee where hadiah = '' order by newid()";
    $rs 		= $db->Execute($sql);
	
	//	array data
	$return = array();
	
	for ($i = 0; !$rs->EOF; $i++) {
		$return[$i]['empno'] = $rs->fields[0];
		$rs->MoveNext();
	}
	
	$o = array(
		"success"=>true,
		"rows"=>$return);
		
	echo json_encode($o);
	
	//	connection close
	$rs->Close();
	$db->Close();
?>