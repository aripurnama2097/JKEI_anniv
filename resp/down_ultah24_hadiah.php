<?php
	/*
	****	create by Mohamad Yunus
	****	on 4 November 2021
	****	revise:
	*/
	//	session start
	session_start();
	
	//	connect to svrdbn
	include '../../adodb/con_jeinultah.php';
	
	//	get paramater
	$empno			= trim(@$_REQUEST["valempno"]);
	$empname		= trim(@$_REQUEST["valempname"]);
	$hadiah			= trim(@$_REQUEST["valhadiah"]);
	
	//	execute query
    $sql 		= "select * from tblUltah24Employee where emp_no like '%{$empno}%' and emp_name like '%{$empname}%' and hadiah = '{$hadiah}'";
    $rs 		= $db->Execute($sql);
?>
<html>
<head>
	<title>Data Jein Ultah 24th</title>
</head>
<body>
<?php
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=jeinultah24th - ".$hadiah.".xls");
	
	echo '<table border="1">';
		echo '<tr>';
			echo '<th>No</th>';
			echo '<th>NIK</th>';
			echo '<th>NAMA</th>';
			echo '<th>DEPT</th>';
			echo '<th>JOB STATUS</th>';
			echo '<th>JOIN DATE</th>';
			echo '<th>HADIAH</th>';
		echo '</tr>';
		
		$no = 1;
		while(!$rs->EOF){
			echo '<tr>';
				echo '<td>'.$no.'</td>';
				echo '<td>'.$rs->fields[0].'</td>';
				echo '<td>'.$rs->fields[1].'</td>';
				echo '<td>'.$rs->fields[2].'</td>';
				echo '<td>'.$rs->fields[3].'</td>';
				echo '<td>'.$rs->fields[4].'</td>';
				echo '<td>'.$rs->fields[5].'</td>';
			echo '</tr>';
			$no++;
			$rs->MoveNext();
		}
	echo '</table>';
	$rs->Close();
?>
</body>
</html>
<?php	
	$db->Close();
?>