<?php
	/*
	****	create by Mohamad Yunus
	****	on 25 November 2020
	****	remark: -
	*/  
	include('../../ADODB/con_jeinultah.php');
	
	//	get paramater	
	//	execute query
    $sql 		= "exec dispUltah23CbxDiv;";
    $rs 		= $db->Execute($sql);
	
	//	array data
	$return = array();
	
	for ($i = 0; !$rs->EOF; $i++) {
		$return[$i]['div'] 		= $rs->fields[0];
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