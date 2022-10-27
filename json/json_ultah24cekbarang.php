<?php
	/*
	****	create by Mohamad Yunus
	****	on 11 November 2021
	****	remark: -
	*/  
	include('../../ADODB/con_jeinultah.php');
	
	//	get paramater
	$hadiah		= trim(@$_REQUEST["valhadiah"]);
	
	//	execute query
    $sql 		= "exec cekUltah24CbxBarang '{$hadiah}';";
    $rs 		= $db->Execute($sql);
	
	//	array data
	$return = array();
	
	for ($i = 0; !$rs->EOF; $i++) {
		$return[$i]['barangid']	= $rs->fields[0];
		$return[$i]['totalemp']	= $rs->fields[1];
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