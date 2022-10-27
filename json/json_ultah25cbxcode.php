<?php
	/*
	****	create by Mohamad Yunus
	****	on 03 November 2018
	****	remark: -
	*/  
	include('../../ADODB/con_jeinultah.php');
	
	//	get paramater	
	//	execute query
    $sql 		= "exec dispUltah25CbxBarang;";
    $rs 		= $db->Execute($sql);
	
	//	array data
	$return = array();
	
	for ($i = 0; !$rs->EOF; $i++) {
		$return[$i]['codeid'] 		= $rs->fields[0];
		$return[$i]['codename'] 	= $rs->fields[1];
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