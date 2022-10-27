<?php
	/*
	****	create by Mohamad Yunus
	****	on 2 November 2021
	****	remark: -
	*/  
	include('../../ADODB/con_jeinultah.php');
	
	//	get paramater	
	//	execute query
    $sql 		= "exec dispUltah24CbxBarang;";
    $rs 		= $db->Execute($sql);
	
	//	array data
	$return = array();
	
	for ($i = 0; !$rs->EOF; $i++) {
		$return[$i]['barangid']		= $rs->fields[0];
		$return[$i]['empstatus']	= $rs->fields[1];
		$return[$i]['barangtotal']	= $rs->fields[2];
		$return[$i]['nama']			= $rs->fields[3];
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